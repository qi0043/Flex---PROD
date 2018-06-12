<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModifyStaticMap extends CI_Controller 
{
	 protected $update_status;
	 public function __construct()
     {
            parent::__construct();
            $ci =& get_instance();
            $ci->load->config('flex');
			$this->load->helper('url');
        	$this->load->library('flexrest/flexrest');
			$this->load->model('ocf/ocf_model');
			$update_status = 'N';
	 }
	 
	public function activityRename($item_uuid, $item_version)
	{	
		//global $updated_items_count, $deleted_items_count, $update_status, $search_count;
		global $update_status;
		$update_status = 'N'; //N: none E: error. S: success. PS: partly success
		//place this before any script you want to calculate time
		$time_start = microtime(true);
		
		//error page heading
		$errdata['heading'] = "Notice";
		
		if(!$this -> validate_params($item_uuid, $item_version))
		{
			$errdata['message'] = 'Invalid item';
            $this->load->view('ocf/showerror_view', $errdata);
            return;
		}    
		
		#check down time before authentication through FLEX
		/*$down_notice = false;
		$down_notice = $this->ocf_model->db_chk_notice();
		if($down_notice != false)
		{
			#$this->error_info($down_notice['message']);
			if ($down_notice['message'] == '')
				$down_notice['message'] = 'Online Curriculum Framework is temporarily unavailable, please try again later.';
			#echo $down_notice['message'];
			$errdata['message'] = $down_notice['message'];
			//$errdata['heading'] = "Notice";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			return;
			
		}*/
		$success = $this->flexrest->processClientCredentialToken();
        if(!$success)
		{
			$errdata['message'] = 'could not generate token <br/>';
            $this->load->view('ocf/showerror_view', $errdata);
            return;
		}
		$itemsuccess = $this->flexrest->getItem($item_uuid, $item_version, $itemresponse);
		if(!$itemsuccess)
		{
			$errdata['message'] = 'could not get item '. $item_uuid . '/' .$item_version;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
		}
		
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$itemresponse['metadata']));
		
        $activity_item = $this->itemXml2Array($this->xmlwrapper);
		//print_r($activity_item);
		
		$return_topics = $this->ocf_model->db_get_content_by_item_uuid($item_uuid, $item_version);
		if(!$return_topics)
		{
			$errdata['message'] = 'have found this activity';
			//$this->load->view('ocf/showerror_view', $errdata);
			$update_status = 'E';
			$updated_items_count = 0;
			$deleted_items_count = 0;
			$search_count = 0;
			$time_end = microtime(true);
			//dividing with 60 will give the execution time in minutes other wise seconds
			$execution_time = ($time_end - $time_start)/60;
			//$this->notification($courseCode, $update_status, $updated_items_count, $deleted_items_count, $search_count, $errdata['message'], $execution_time);
			return;
		}
		
		echo "<pre>Return topic:";       
		//echo count($return_topics).'<br/>';                          
		print_r($return_topics);
		
		
		$uuid_version = $item_uuid.'/'.$item_version;
		
		for($i=0; $i<count($return_topics); $i++)
		{
			$content = trim(preg_replace("/&(?!(?:apos|quot|[gl]t|amp);|#)/", '&amp;', $return_topics[$i]['content']));
			$dom = new DOMDocument();
			libxml_use_internal_errors(true); //remove load html warning from log
			@$dom -> loadHtml($content);
			//log_message('error', htmlspecialchars_decode($dom->saveXML()));
			$length = $dom->getElementsByTagName('a')->length;
			//log_message('error', htmlspecialchars_decode($dom->saveXML()));
			
			for($x=0; $x<$length; $x++)
			{
				$href = $dom->getElementsByTagName("a")->item($x)->getAttribute("href");
				//echo $href;
				if(stripos($href, 'ocf/lta/'.$uuid_version)>0) //activity group
				{
					$path = $dom->getElementsByTagName("a")->item($x)->getNodePath();
					$new_xpath = rtrim($path, "a").'span';
					$xpath = new DOMXPath($dom);
					$prev = $xpath->evaluate($new_xpath);
					$old_name = $prev->item(0)->textContent;
					$text = trim(htmlspecialchars($activity_item['activity_name']));
					foreach($prev->item(0)->childNodes as $child) 
					{ 
						
						if($child->nodeValue == $old_name)
						{
							$child->nodeValue = str_replace($old_name, '&nbsp;'.$text, $child->nodeValue);
						   // echo 'child: '.$child->nodeValue . "<br />";
						}
					}
					//$prev->item(0)->nodeValue = str_replace($old_name, $text, $prev->item(0)->nodeValue);
				}
				elseif(stripos($href, 'ocf/activity/'.$uuid_version)>0) //activity
				{
					if(isset($activity_item['activity_name']))
					{
						$dom->getElementsByTagName("a")->item($x)->nodeValue = $activity_item['activity_name'];
					}
				}	
				
			}
			$tmp = $dom->saveXML($dom,LIBXML_NOEMPTYTAG);
			$body_pos= stripos($tmp, '<body>')+6;
			$sbody_pos = stripos($tmp, '</body>');
			$tmp = substr($tmp, $body_pos, $sbody_pos-$body_pos);
			//$tmp = preg_replace('/\/>/', '></i>', $tmp);
			//log_message('error', htmlspecialchars_decode($tmp) );
			
			$return_status = $this->ocf_model->db_transaction_static_html(htmlspecialchars_decode($tmp), $return_topics[$i]['year_level'], $return_topics[$i]['course_code'], $return_topics[$i]['topic_code']);
		    echo $return_status;
		}
		/*
		#check course code
		$check_course_code = $this->ocf_model->db_get_courseInfo($courseCode);
		if(!$check_course_code)
		{
			$errdata['message'] = 'course code not valid';
			//$this->load->view('ocf/showerror_view', $errdata);
			$update_status = 'E';
			$updated_items_count = 0;
			$deleted_items_count = 0;
			$search_count = 0;
			$time_end = microtime(true);
		
			//dividing with 60 will give the execution time in minutes other wise seconds
			$execution_time = ($time_end - $time_start)/60;
			$this->notification($courseCode, $update_status, $updated_items_count, $deleted_items_count, $search_count, $errdata['message'], $execution_time);
			return;
		}
		$course_year = $check_course_code[0]['course_total_year'];
		//$course_year = 1;
		//echo $course_year;
		
		$ci =& get_instance();
		$ci->load->config('flex');
		$collection_uuid = $ci->config->item('taa_collection');
		
		$course=array();
		$data = array('course' => $this->recursiveCall($course_year, $courseCode,'','', $collection_uuid,'TAA', $course, 1, $error_array=array()));
		
		unset($course);
		
		echo "<pre>DATA:";                                 
		print_r($data);
		echo "<pre>";
		
		
		// Display Script End time
		$time_end = microtime(true);
		
		//dividing with 60 will give the execution time in minutes other wise seconds
		$execution_time = ($time_end - $time_start)/60;
		$this->notification($courseCode, $data['course']['update_status'], $data['course']['updated_items_count'], $data['course']['deleted_items_count'], $data['course']['search_count'], $data['course']['message'], $execution_time);
		*/
		
	}

     /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
	 
    protected function itemXml2Array($itemXml) 
    {		
		$tmp = array();
	    $activityType = '/xml/item/curriculum/activities/activity/@type';
		$tmp['activity_type'] =  $itemXml->nodeValue($activityType);
		$activityName = '/xml/item/itembody/name';
		$tmp['activity_name'] =  $itemXml->nodeValue($activityName);
	   //$tmp['numActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_actvities/uuid');
	   
	   	// Put the linked activity uuids into an array
		
		/*for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');  $i++) 
		{
			$uuid = '/xml/item/curriculum/activities/linked_activities/uuid['.$i.']';
			$tmp[$i]['uuid'] = $itemXml->nodeValue($uuid);
		}*/
        return $tmp;
    }
	

	private function microtime_float()
	{
    	list($usec, $sec) = explode(" ", microtime());
   		return ((float)$usec + (float)$sec);
	}
	
	/**
     * Validate incoming parameters
     *
     * @param string $coursecode
     */
    /**
     * Validate incoming parameters
     *
     * @param array $uuid, item UUID
     * @param array $version, item Version
     */
    protected function validate_params($uuid, $version)
    {
        if(strcmp($uuid, 'missed')==0 || strlen($uuid) != 36)
            return false;
        
        if(strcmp($version, 'missed')==0 || !is_numeric($version))
            return false;
			
        return true;
    }
	
	private function notification($course_code, $update_status, $updated_items_count, $deleted_items_count, $search_count, $errmsg, $execution_time)
	{
		$current_timestamp = date("Y-m-d H:i:sa"); 
		$this->load->library('email');
		$msg = '';
		for($i = 0; $i < count($errmsg); $i++)
		{
			$msg = $msg . '  ' . $errmsg[$i];
		}
		$this->email->from('DoNotReply@flinders.edu.au', 'DoNotReply@flinders.edu.au');
		$this->email->to('qi0043@flinders.edu.au'); 
		$this->email->subject('Static Map notification');
		if($deleted_items_count == '')
			$deleted_items_count = 0;
		if($search_count == '')
			$search_count = 0;	
		if($updated_items_count == '')
			$updated_items_count = 0;
	
		
		$mes = 'The '.$course_code.' static updated on ' .$current_timestamp.'. The update was ' . $update_status .'. There were '. $search_count. ' searched in the flex system,  '.$updated_items_count.' items upadted or created in the database and '.$deleted_items_count. ' items deleted from the database. '.'Count of Errors: ' . count($errmsg) .' Execution time: '.$execution_time.'Mins. Error List: ' .$msg . '';
		$this->email->message($mes);	
		$this->email->send();
		return;
	}

	 
} 