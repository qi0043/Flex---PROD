<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topicsummary extends CI_Controller {

	public function index($courseId='missed', $uuid='missed', $version='missed')
	{
        $errdata['heading'] = "Error";
        
        if($this->validate_params($uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
		
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		
		if(!$this -> validate_course_params($courseId))
		{
			$errdata['message'] = 'Invalid course code';
            $this->load->view('ocf/showerror_view', $errdata);
            return;
		}
	
		$this->load->model('ocf/ocf_model');
            
		#check down time before authentication through FLEX
		$down_notice = false;
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
		}
		#check course code
		$check_course_code = $this->ocf_model->db_get_courseInfo(strtoupper($courseId));
		if(!$check_course_code)
		{
			$errdata['message'] = 'course code not valid';
			$this->load->view('ocf/showerror_view', $errdata);
			return;
		}
		
		$success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }    
       
		/****************************************************************************/
		
		/* Find the topic information                                               */
		
		/****************************************************************************/
		
		$success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = 'Can not get item: ' . $uuid .'/'.$version . '<br/>'. $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
			
		/****************************************************************************/
		
		/* Get the topic code from the response from the search                      */
		
		/****************************************************************************/	
		
		$tcode = substr($response['name'],0,8); 
		$xmlwrapper_name = 'xmlwrapper'.'topic';
		
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
		/*echo 'Topic Information response : <pre>';
		print_r($response);
		echo '</pre>';*/
       
				
		if(!$this->itemIsTopic($this->$xmlwrapper_name))
        {
            $errdata['message'] = "Item is not a Topic";
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
	
		$topic_array = $this->topicXml2Array($this->$xmlwrapper_name);
		$topic_array['itemID'] = $response['uuid'];	
		$itemID = $response['uuid'];
		
		/****************************************************************************/
		
		/* Now find the SAM for this topic                                          */
		
		/****************************************************************************/
		
		// Search variables
		
        $q = '';
        $start = 0;
        $length = 1;

		$ci =& get_instance();
		$ci->load->config('flex');
		$collections= $ci->config->item('sam_collection'); // The SAM collection uuid 
        $order = 'name';
        $reverse = false;

        $samwhere = "/xml/item/curriculum/@item_type='SAM'";
        $samwhere .= " AND /xml/item/curriculum/topics/topic/code='".$tcode."'";   
        $samwhere = urlencode($samwhere);
		
		#echo "<br /><br /><br />".urldecode($samwhere)."<br /><br />";		
        $info = 'all';  
        $showall = false; // only search for live items

		$searchsuccess = $this->flexrest->search($sam, $q, $collections, $samwhere, $start, $length, $order, $reverse, $info, $showall);

		$xmlwrapper_name = 'xmlwrapper'.'sam';
		
		if(isset($sam['results'][0]))
		{     
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$sam['results'][0]['metadata']), $xmlwrapper_name);
			$sam_array = $this->samXml2Array($this->$xmlwrapper_name);
			$sam_name = '/xml/item/itembody/name';
			$sam_array['sam_name'] = $this->$xmlwrapper_name->nodeValue($sam_name);
		}

        /****************************************************************************/
		
		/* Now find the Topic Availabilities Activities (TAA) for this topic                                          
		
		/****************************************************************************/
		
		// Search variables
       
		$q = '';
        $start = 0;
        $length = 1;
		
		$ci =& get_instance();
		$ci->load->config('flex');
		$collection_uuid = $ci->config->item('taa_collection');
	
        $order = 'name';
        $reverse = false;

        $taawhere = "/xml/item/curriculum/@item_type='TAA'";
        $taawhere .= " AND /xml/item/curriculum/topics/topic/code='".$tcode."'";       
        $taawhere = urlencode($taawhere);
			
        $info = 'all';
        $showall = false;

		$taasuccess = $this->flexrest->search($taa, $q, $collection_uuid, $taawhere, $start, $length, $order, $reverse, $info, $showall);

		/*echo "taa response<pre>";
      	print_r($taa['results'][0]['metadata']);
		echo "</pre>";*/
	
		//exit;
		
		$aCtr = 0;
		$xmlwrapper_name = 'xmlwrapper'.'taa';		
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$taa['results'][0]['metadata']), $xmlwrapper_name);
		
		$taa_array = $this->numactivitiesXml2Array($this->$xmlwrapper_name);
		
		/*echo "taa <pre>";
      	print_r($taa_array);
		echo "</pre>";	*/	
		
		$xmlwrapper_name = 'xmlwrapper'.'taa_activities';
		
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$taa['results'][0]['metadata']), $xmlwrapper_name);

		$taa_array['activities'] = $this->taaXml2Array($this->$xmlwrapper_name);
        $taa_name = '/xml/item/itembody/name';
		$taa_array['taa_name'] = $this->$xmlwrapper_name->nodeValue($taa_name);
		
		if(count($taa_array['activities'])>0)
		{
			foreach ($taa_array['activities'] as $linkedactivity) 
			{
				$a = 0;
				
				$linkedUUID = $linkedactivity['uuid'];
				foreach ($taa['results'][0]['attachments'] as $attachment) 
				{			
					$a++;				
					$attachmentUuid = $attachment['uuid'];
					if ($attachmentUuid === $linkedUUID ) 
					{
						$taa_array['activities'][$a]['itemUuid'] = $attachment['itemUuid'];
						$taa_array['activities'][$a]['itemVersion'] = $attachment['itemVersion'];	
						$itemsuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $itemresponse);	
							
						/*echo "item response<pre>";
						print_r($itemresponse);
						echo "</pre>";*/
	
						$b = 0;			
						if($itemsuccess)  {						
							$b++;						
							$xmlwrapper_name = 'xmlwrapper_'.$attachment['itemUuid'];					
							$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$itemresponse['metadata']), $xmlwrapper_name);
							$taa_array['activities'][$a]['activityType'] = $this->itemXml2Array($this->$xmlwrapper_name);					
							$xmlwrapper_name = 'xmlwrapper_'.$attachment['itemUuid'];						
							$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$itemresponse['metadata']), $xmlwrapper_name);
							$taa_array['activities'][$a]['itemTitle'] = $this->titleXml2Array($this->$xmlwrapper_name);		
						}
						
					}
		
				}		
			}
		}
		if(!isset($sam_array))
		{
			$sam_array = array();
		}
		
		$course_array['code'] = $courseId;
		
		$data = array('topics' => $topic_array, 'taa' => $taa_array, 'sam' => $sam_array, 'courses' => $course_array);
		
		
		//$data['courses']['code']=$courseId;
		/*   
		if($_SERVER['REMOTE_USER'] == 'couc0005') {
		echo "data<pre>";
		print_r($data);
		echo "</pre>";
		}
		 */
	
		//$this->load->view('ocf/topicview', $data);
		$this->load->view('ocf/topicsummary', $data);
		
		}
	
	
	
	    /**
     * Check whether the item has a type of Topic Information
     *
     * @param xmlwrapper $itemXml
     */
    protected function itemIsTopic($itemXml) 
    { 

        $type = '/xml/item/curriculum/@item_type';
        $itemistopic = $itemXml->nodeValue($type);
        if(isset($itemistopic) && $itemistopic=='Topic Information')
            return true;
        return false;
    }
	

 /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function topicXml2Array($itemXml) 
    { 
		// loop through related topics	
		//echo "Number of topic in topics: ". $itemXml->numNodes('/xml/item/curriculum/topics/topic') . "<br />";
	
        $tmp['tcode'] = '';
		$tmp['topicTitle'] = '';
		$tmp['courseCode'] = '';	
		$tmp['courseTitle'] = '';
	//	$tmp['newTcode'] = '';
		
		$ctr = 0; //set a counter	
		for ($t = 1; $t <= $itemXml->numNodes('/xml/item/curriculum/topics/topic'); $t++) 
		{
			$topicCode = '/xml/item/curriculum/topics/topic['.$t.']/code';
			$topicTitle = '/xml/item/curriculum/topics/topic['.$t.']/name';
			
			if ($ctr >= 1) 
			{ 
				$tmp['topicTitle'] .= ', ';  
				$tmp['tcode'] .= ' '; 
			}
			
			$tmp['tcode'] .= $itemXml->nodeValue($topicCode);
			$tmp['topicTitle'] .= $itemXml->nodeValue($topicTitle);
			
			$ctr++; // increment the counter
		}
		
		$ctr = 0; //set a counter	
		
		for ($t = 1; $t <= $itemXml->numNodes('/xml/item/curriculum/courses/course'); $t++) 
		{
			$courseCode = '/xml/item/curriculum/courses/course['.$t.']/code';
			$courseName = '/xml/item/curriculum/courses/course['.$t.']/name';
			if ($ctr >= 1) 
			{ 
				$tmp['courseTitle'] .= ', ';  
				$tmp['courseCode'] .= ' '; 
			}
			
			$tmp['courseCode'] .= $itemXml->nodeValue($courseCode);
			$tmp['courseTitle'] .= $itemXml->nodeValue($courseName);
			
			$ctr++; // increment the counter
		}
		
		unset($ctr);
		
		$topicDescription = '/xml/item/curriculum/topics/topic/description';
		
		$outcomeIntro = '/xml/item/curriculum/outcomes/topic/intro';		

		$tmp['description'] = $itemXml->nodeValue($topicDescription);
		$tmp['ocIntro'] = $itemXml->nodeValue($outcomeIntro);
	
		$numTopicLOS = $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo');
		$numCourseLOS = $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo');
		$numAmcLOS = $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo');
	
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo'); $i++) {
	
			$loSysID = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/@sys_id';
            $loName = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/name';
            $loCode = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/code';
					
			$tmp['topic']['los']['lo'.$i]['loSysID'] = $itemXml->nodeValue($loSysID);
            $tmp['topic']['los']['lo'.$i]['name'] = $itemXml->nodeValue($loName);
			$tmp['topic']['los']['lo'.$i]['code'] = $itemXml->nodeValue($loCode);
			
		} // end of $i loop
		
		/*echo 'Topic Information Temp array: <pre>';
		print_r($tmp);
		echo '</pre>';*/
		
        return $tmp;

    }


 /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
	protected function samXml2Array($itemXml) 
	{
		$tmp = array();
		$topicVersion = '/xml/item/curriculum/assessment/SAMs/version_definition';
		$tmp['sam']['version'] = $itemXml->nodeValue($topicVersion);  	
		// Assessment items
		
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/assessment/a_items/a_item'); $i++) {
				
			$aItemSysID = '/xml/item/curriculum/assessment/a_items/a_item['.$i.']/@sys_id';
			$aItemName = '/xml/item/curriculum/assessment/a_items/a_item['.$i.']/name';
			$tmp['sam']['assessment']['item'.$i]['SysID'] = $itemXml->nodeValue($aItemSysID);
			$tmp['sam']['assessment']['item'.$i]['name'] = $itemXml->nodeValue($aItemName);
				
		}	
			// Topic coordinators
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/people/coords/coord'); $i++) {
			
			$fan = '/xml/item/curriculum/people/coords/coord['.$i.']/fan';
			$name = '/xml/item/curriculum/people/coords/coord['.$i.']/name_display';	
			$tmp['sam']['coord'][$i]['fan'] = $itemXml->nodeValue($fan);
			$tmp['sam']['coord'][$i]['name'] = $itemXml->nodeValue($name);
		}
		/*echo 'SAM Temp array: <pre>';
		print_r($tmp);
		echo '</pre>';*/
		
		return $tmp;
	
	}



 /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function numactivitiesXml2Array($itemXml) 
    {   
	   $tmp['numLinkedActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid'); 
       return $tmp;
    }

 /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function taaXml2Array($itemXml) 
    {
       $tmp = array();
	   //$tmp['numLinkedActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid'); 
	  for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');  $i++) 
	  {		  
		  $uuid = '/xml/item/curriculum/activities/linked_activities/uuid['.$i.']'; 		  
		  $tmp[$i]['uuid'] = $itemXml->nodeValue($uuid);	  
		 
	  }
	  
	    /*echo 'TAA Temp array: <pre>';
		print_r($tmp);
		echo '</pre>';*/
        return $tmp;
    }


	/**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
	 
	 
       /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
	 
    protected function itemXml2Array($itemXml) 	
    {
		$tmp = array();
		$activityType = '/xml/item/curriculum/activities/activity/@type';
		$tmp = $itemXml->nodeValue($activityType);
        return $tmp;
    }


 
    protected function titleXml2Array($itemXml) 
    {
	   	$itemTitle = '/xml/item/curriculum/activities/activity/name';	 
		$tmp = $itemXml->nodeValue($itemTitle);
        return $tmp;
    }


    /**
     * Validate incoming parameters
     *
     * @param string $format, html/pdf
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
    
	  /**
     * Validate incoming parameters
     *
     * @param string $coursecode
     */
    private function validate_course_params($courseCode)
    {

        if(strcmp($courseCode, 'missed')==0 ||is_numeric($courseCode) )
		{
            return false;
		}
        return true;
    }
} 