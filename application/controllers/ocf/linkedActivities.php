<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LinkedActivities extends CI_Controller 
{
	 public $activity_count;
	 
	 public function __construct()
     {
            parent::__construct();
            $ci =& get_instance();
            $ci->load->config('flex');
			$this->load->helper('url');
        	$this->load->library('flexrest/flexrest');
			$this->load->model('ocf/ocf_model');
			$activity_count = 0;
	 }
	 
	public function update($courseCode)
	{	
		global $activity_count;
		$courseCode = strtoupper($courseCode);
		//place this before any script you want to calculate time
		$time_start = microtime(true);		//error page heading
		$errdata['heading'] = "Notice";
		
		if(!$this -> validate_params($courseCode))
		{
			$errdata['message'] = 'Invalid course code';
            $this->load->view('ocf/showerror_view', $errdata);
            return;
		}    

		#check course code
		$check_course_code = $this->ocf_model->db_get_courseInfo($courseCode);
		if(!$check_course_code)
		{
			$errdata['message'] = 'course code not valid';
			$time_end = microtime(true);
		
			//dividing with 60 will give the execution time in minutes other wise seconds
			$execution_time = ($time_end - $time_start)/60;
			$this->notification($courseCode, 'E', 0, 0, 0, 0, $execution_time);
			return;
		}
		$course_year = $check_course_code[0]['course_total_year'];
		//$course_year = 1;
		//echo $course_year;
		
		$ci =& get_instance();
		$ci->load->config('flex');
		$collection_uuid = $ci->config->item('taa_collection');
		
		$course=array();
		//$data = array('course' => $this->recursiveCall(3, $courseCode,'','', $collection_uuid,'TAA', $course, 3, $error_array=array()));
		$data = array('course' => $this->recursiveCall($course_year, $courseCode,'','', $collection_uuid,'TAA', $course, 1, $error_array=array()));
		unset($course);
		
		echo "<pre>DATA:";                                 
		print_r($data);
		
		echo "<pre>";
		
		echo "<pre>Activity Count:";                                 
		print_r($activity_count);
		echo "<pre>";
		
		
		// Display Script End time
		$time_end = microtime(true);
		
		//dividing with 60 will give the execution time in minutes other wise seconds
		$execution_time = ($time_end - $time_start)/60;
		//$this->notification($courseCode, $data['course']['update_status'], $data['course']['updated_items_count'], $data['course']['deleted_items_count'], $data['course']['search_count'], $data['course']['message'], $execution_time);
		
		exit;
	}
	
    /****
		get all TAAs recursively
		Parameters:
		@depth: how many years of study this course may have. eg: 4 ( NOT NULL )
		@courseCode: eg: MD
		@schoolName: eg School of Medicine
		@topicDisciplline : eg MMED or MMED8    ( NOT NULL )
		@collectionUuid: the uuid of the collection you would like to search in
		@item_type: /xml/item/curriculum/@item_type , eg: SAM, TAA    ( NOT NULL )
		
		return $course array
	******/
	protected function recursiveCall($depth_index, $courseCode = '', $schoolName = '', $topicDiscipline = '', $collectionUuid, $item_type, $course, $depth, $error_array)
	{     
		//global $updated_items_count, $deleted_items_count, $search_count, $update_status;
		
		
		if($courseCode != '' || $schoolName != '')
		{
			
			if($depth <=  $depth_index)
			{
				//construct where query
				$where = "";
				
				if($item_type != '')
				{
					$where = $where . "/xml/item/curriculum/@item_type='" . $item_type . "' AND ";
				}
				if($courseCode != '')
				{
					$where = $where . "/xml/item/curriculum/courses/course/code='" . $courseCode ."' AND ";
				}
				if($schoolName != '')
				{
					$where = $where . "/xml/item/curriculum/topics/topic/school='" . $schoolName ."' AND ";
				}
				$where = $where . "/xml/item/curriculum/topics/topic/level=" . $depth;
				if($topicDiscipline != '')
				{
					$where = $where . " AND /xml/item/curriculum/topics/topic/code LIKE '" . $topicDiscipline . "%'";
				}
				
				//echo "<pre>";
				//echo $where;
				//echo "</pre>";
				
				$where = urlencode($where);
				
				//generate temp access token
				$success = $this->flexrest->processClientCredentialToken();
			    $errdata['heading'] = "Error";
				if(!$success)
				{
					$errdata['message'] = $this->flexrest->error;
					//$this->load->view('ocf/showerror_view', $errdata);
					$update_status = 'E';
					log_message('error', 'Error of processClientCredentialToken() - course code:   '.$courseCode.'/ topic_code: '. $course[$depth]['topics'][$j]['code']. '/year level: '.$depth.'/html content: '.$html.'<br/>');
					array_push($error_array, 'time '. date("Y-m-d H:i:s") . 'Error of processClientCredentialToken() - course code:   '.$courseCode.'/ topic_code: '. $course[$depth]['topics'][$j]['code']. '/year level: '.$depth.'/error content: '.$this->flexrest->error.'<br/>');
					$course['course_code'] = $courseCode;
					$course['search_count'] = $search_count;
					$course['$updated_items_count'] = $updated_items_count;
					$course['$deleted_items_count'] = $deleted_items_count;
					$course['update_status'] = $update_status;
					$course['message'] = $error_array;
					return $course;
				}  
				
				if($success)
				{	//echo $depth;
				    
					$searchsuccess = $this->flexrest->search($response, '', $collectionUuid, $where, 0, 50, 'modified', false, 'all', false);
				
					if(!$searchsuccess)
					{
						$errdata['message'] = $this->flexrest->error;
						//$this->load->view('ocf/showerror_view', $errdata);
						$update_status = 'E';
						log_message('error', 'Error of searching item in flex - course code:   '.$courseCode.'/ topic_code: '. $course[$depth]['topics'][$j]['code']. '/year level: '.$depth.'/html content: '.$html.'<br/>');
						array_push($error_array, 'time '. date("Y-m-d H:i:s") . 'Error of searching item in flex - course code:   '.$courseCode.'/ topic_code: '. $course[$depth]['topics'][$j]['code']. '/year level: '.$depth.'/error content: '.$this->flexrest->error.'<br/>');
						$course['course_code'] = $courseCode;
						$course['search_count'] = $search_count;
						$course['updated_items_count'] = $updated_items_count;
						$course['deleted_items_count'] = $deleted_items_count;
						$course['update_status'] = $update_status;
						$course['message'] = $error_array;
						return $course;
					}
					//unset($response['headers']);
					$topicCount = intval($response['available']);
					//lets start building the array
					$course[$depth]['year'] = $depth;
					$course[$depth]['numTopics'] = $topicCount;
					$topic_array = array();
					ignore_user_abort(true);				
					sleep (1);
					for ($i=0; $i < $topicCount; $i++) 
					{
						
						//$search_count++;
						$j = $i+1;
						$xmlwrapper_name = 'xmlwrapper'.$depth."_".$j;
						//pull out each TAA XML 
						$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['results'][$i]['metadata']), $xmlwrapper_name);
						$course[$depth]['topics'][$j] = $this->Xml2Array($this->$xmlwrapper_name, $depth, $j);
						
						$topics = $this->topicXml2Array($this->$xmlwrapper_name);
						
						if(!in_array($course[$depth]['topics'][$j]['code'], $topic_array))
						{
							$course[$depth]['topics'][$j]['name'] = $response['results'][$i]['name']; //store each TAA name in array
							
							//echo 'topic code:'.$course[$depth]['topics'][$j]['code'];
							
							 $l = 0 ;
							//iterate through all linked_activities under each TAA XML
							if(isset($course[$depth]['topics'][$j]['linked_activities']))
							{
								foreach($course[$depth]['topics'][$j]['linked_activities'] as $linked) 
								{
									$l++;
									$linkedUUID = $linked['uuid']; //get each linked_activity UUID
									$a = 0;
									//iterate through all attachments under each responsed TAA
									for($a=0; $a<count($response['results'][$i]['attachments']); $a++)
									{
										$attachmentUuid = $response['results'][$i]['attachments'][$a]['uuid'];
										if ( $attachmentUuid === $linkedUUID ) 
										{
											$course[$depth]['topics'][$j]['linked_activities'][$l]['itemUuid'] = $response['results'][$i]['attachments'][$a]['itemUuid'];
											$course[$depth]['topics'][$j]['linked_activities'][$l]['itemVersion'] = $response['results'][$i]['attachments'][$a]['itemVersion'];
											//getActivityRecursiveCall($attatchmentUuid, $uuid, $version, $topicCode, $do_condition, $itemresponse, $index, &$keys, &$data, $furtherCall)
											$returnData = $this->getActivityRecursiveCall($attachmentUuid,$response['results'][$i]['attachments'][$a]['itemUuid'],$response['results'][$i]['attachments'][$a]['itemVersion'],$topics,'', '',1,$key=array(),$vdata=array(),true);
																
											if(!$returnData)
											{
												$update_status = 'PS';
												array_push($error_array, 'time '. date("Y-m-d H:i:s") . 'Error get flex items - course code:   '.$courseCode.'/ topic_code: '. $course[$depth]['topics'][$j]['code']. '/year level: '.$depth); 
												continue;
											}
											$course[$depth]['topics'][$j]['linked_activities'][$l] = $returnData;
										}
									}
								}
							}
							
							//$topic_act = array('topic' => $course[$depth]['topics'][$j]);
							$topic_act = $course[$depth]['topics'][$j];
						
							//$html = $this->generateHtml($topic_act, $courseCode);
							//$this->ocf_model->db_ins_static_html($html, $depth, $courseCode, $course[$depth]['topics'][$j]['code']);
							//$return_data = $this->ocf_model->db_function_ocf_build($depth, $courseCode, $course[$depth]['topics'][$j]['code'], $html);
							
							//$return_data = $this->ocf_model->db_transaction_static_html($html, $depth, $courseCode, $course[$depth]['topics'][$j]['code']);
							//$return_data = $this->ocf_model->db_transaction_static_html($html, $depth, $courseCode, $course[$depth]['topics'][$j]['code']);
							/*if($return_data != 'Successful')
							{
								$update_status = 'PS';
								log_message('error', 'Error of db_transaction_static_html - course code:   '.$courseCode.'/ topic_code: '. $course[$depth]['topics'][$j]['code']. '/year level: '.$depth.'/html content: '.$html.'<br/>');
								array_push($error_array, 'time '. date("Y-m-d H:i:s") . 'Error of db_transaction_static_html - course code:   '.$courseCode.'/ topic_code: '. $course[$depth]['topics'][$j]['code']. '/year level: '.$depth.'/html content: '.$html.'<br/>');
							}
							else
							{
								$updated_items_count++;
							}*/
							//log_message('error', 'topic_code'.$course[$depth]['topics'][$j]['code'].': ' . $html);
							/*echo '<pre>';
							echo 'updates item count: ' . $updated_items_count.'<br/>';
							echo 'transaction status: ';
							print_r($return_data);
							echo '<br/>';
							echo $html;
							echo '</pre>';*/
							
							array_push($topic_array, $course[$depth]['topics'][$j]['code']);
						}
					}
					unset($topic_array);
				}
				
				/*echo "Course <pre>";                                 
				print_r($course);
				echo "<pre>";*/
				$depth++;
				$this->recursiveCall($depth_index,$courseCode,$schoolName,$topicDiscipline,$collectionUuid,$item_type,$course, $depth,$error_array);
			}
			/*if($update_status=='N')
			{
				$update_status = 'S';
			}*/
			
			$course['course_code'] = $courseCode;
			//$course['search_count'] = $search_count;
			//$course['updated_items_count'] = $updated_items_count;
			//$course['deleted_items_count'] = $deleted_items_count;
			//$course['update_status'] = $update_status;
			//$course['message'] = $error_array;
			echo '<pre>';
			echo 'course:';
			echo '<br/>';
			print_r($course);
			echo '</pre>';
			return $course;	
		}
		else
		{
			 #go to error page (have to provide a courseCode or schoolName)
			 $errdata['message'] = "have to provide a course code or a school name";
			 $this->load->view('ocf/showerror_view', $errdata);
			 return;
		}
	}
	
	
	/***************************************
		recursive call of Linked Activities 
	****************************************/
	protected function getActivityRecursiveCall($attatchmentUuid, $uuid, $version, $topics, $do_condition, $itemresponse, $index, &$keys, &$data, $furtherCall)
	{
		global $activity_count;
		$activity_count++;
		
		$this->load->library('flexrest/flexrest');
		$itemsuccess = $this->flexrest->getItem($uuid, $version,$itemresponse);
		
		if($itemsuccess)
		{
			/* set topic code */
		   
			$item_bean = $itemresponse;
			$xmlwrapper_name = 'xmlwrapper_' . $uuid . '_' .  $topics['topic'][1]['code'];
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$itemresponse['metadata']), $xmlwrapper_name);
			$act_name = $this->$xmlwrapper_name->nodeValue("/xml/item/itembody/name");
			$act_managed_by = $this->$xmlwrapper_name->nodeValue("/xml/item/restrictions/management/manage/@id");
			
			echo $act_name.'_'.$act_managed_by.'<br/>';
			
			$return_data = $this->ocf_model->db_add_linked_activities($act_name, $activity_count, $uuid, $version, $topics['topic'][1]['code'], $act_managed_by);//$activity_name, $id, $item_uuid, $item_version, $topic_code)
			if(!$return_data)
			{
				echo 'database error: ' . $uuid .'/'.$version .'<br/>';
				exit;
			}
			
			/*$topic_code_count =  $this->$xmlwrapper_name->numNodes("/xml/item/curriculum/topics/topic/code");
			echo '<pre>';
			print_r($topics);
			echo '</pre>';
			
			//for($h=1; $h<=count($topics['topic']); $h++)
			$h=0;
			foreach($topics['topic'] as $topic)
			{
				$h++;
				$flag = false;
				
				//$topicCode = $topics['topic'][$h]['code'];
				$topicCode = $topic['code'];
				echo $h.'_'.$topicCode.'<br/>';
				if($topic_code_count > 0)
				{
					
					for($i=1; $i<=$topic_code_count; $i++)
					{
						$code = $this->$xmlwrapper_name->nodeValue("/xml/item/curriculum/topics/topic/code[".$i."]");
						
						if($code == $topicCode)
						{
							$flag = true;
							echo $activity_count.' found: '. $topicCode. '-'.$uuid.'/'. $version.'<br/>';
							break;
						}
						
					}
				}
			
				if(!$flag)
				{
					echo $activity_count.' Not FOUND: '. $topicCode. '-'. $uuid.'/'. $version.'<br/>';
					 
					$topics_node = $this->$xmlwrapper_name->createNodeFromXPath('/xml/item/curriculum/topics');
					 echo 'topics_node created<br/>';
					$topic_node =$this->$xmlwrapper_name->createNodeFromXPath('/xml/item/curriculum/topics/topic');
					echo 'topic_node created<br/>';
					$topic_code_node = $this->$xmlwrapper_name->createNode($topic_node, 'code');
					echo 'code created<br/>';
					$topic_code_node->nodeValue = $topicCode;
					echo 'topic code added<br/>';
						
					
					
					$item_bean['metadata'] = $this->$xmlwrapper_name->__toString();
					
					$updatesuccess = $this->flexrest->editItem($uuid, $version, $item_bean, $updateresponse, '');
					if(!$updatesuccess)
					{
						log_message('error', 'error of updating topic code for activity: '.$uuid.'/'. $version. '/'.$updateresponse);
						exit;
					}
				}
			}*/
			
			/***************************************************************************/
			
			$tmp = array();
			$tmp['uuid']=$attatchmentUuid;
			$tmp['itemUuid']=$uuid;
			$tmp['itemVersion']=$version;
			$tmp['activityType'] = $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/activities/activity/@type');
			$tmp['activityName']= $this->$xmlwrapper_name->nodeValue('/xml/item/itembody/name');
			//$tmp['topicCode']=$topicCode;

			if($tmp['activityType'] == 'group')
			{
				
				$tmp['numLinkedActivities'] = $this->$xmlwrapper_name->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');  
	 	
				for ($i = 1; $i <= $this->$xmlwrapper_name->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');  $i++) 
				{
					$linked_uuid = '/xml/item/curriculum/activities/linked_activities/uuid['.$i.']';
					$tmp['linked_activities'][$i]['uuid'] = $this->$xmlwrapper_name->nodeValue($linked_uuid);
				}	
				
			   $this->setValue($data,$keys,$tmp);
					
				$attachments = $itemresponse['attachments'];
				

				if(isset($tmp['linked_activities'] ) && count($tmp['linked_activities'])>0)
				{

					array_push($keys,'linked_activities');	
					array_push($keys,$index);
					$act_index = 0;
					$condition = '';
					foreach($tmp['linked_activities'] as $linked_uuid_object)
					{	
						for ($j = 1; $j <= $this->$xmlwrapper_name->numNodes('/xml/item/curriculum/activities/act_items/act_item');  $j++) 
						{
							$act_uuid = $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/activities/act_items/act_item['.$j.']/@sys_id');
							if($act_uuid == $linked_uuid_object['uuid'])
							{
								$condition = $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/activities/act_items/act_item['.$j.']/do_condition');
								//$tmp['linked_activities'][$i]['do_condition'] = $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/activities/act_items/act_item['.$j.']/do_condition');
								continue;
							}
						}
						$act_index ++;
						foreach($attachments as $attachment)
						{
							if($attachment['type'] == 'linked-resource')
							{
								if($linked_uuid_object['uuid'] == $attachment['uuid'])
								{
									//$array_index++;
									$linked_attachment_item_uuid = $attachment['itemUuid'];
									$linked_attachment_item_version = $attachment['itemVersion'];
									
									//$keys[count($keys)-1] = $array_index;
									$keys[count($keys)-1] = $act_index;
									if($act_index >= count($tmp['linked_activities']))
									{
										$this->getActivityRecursiveCall($attachment['uuid'],$linked_attachment_item_uuid,$linked_attachment_item_version,$topics,$condition,'', $act_index, $keys, $data, false);
									}
									else
									{
										$this->getActivityRecursiveCall($attachment['uuid'],$linked_attachment_item_uuid,$linked_attachment_item_version,$topics,$condition,'', $act_index, $keys, $data, true);
									}
								}
							}
						}
					}
				} 
				else
				{
					//$tmp['uuid']=$attatchmentUuid;
					$tmp['numLinkedActivities'] = 0; 
					//$tmp['itemVersion']=$version; 
					$this->setValue($data,$keys,$tmp); 
				}
			}
			
			if($tmp['activityType'] == 'activity')
			{
				
				//$tmp['do_condition'] = $do_condition;
				$tmp['numLinkedActivities'] = 0;  
				//$tmp['itemVersion']=$version;
				$this->setValue($data,$keys,$tmp);  
			}
			if(!$furtherCall)
			{	
				array_pop($keys);
				array_pop($keys);
			}
			unset($tmp);
		}
		else
		{
			 //echo 'item not found';
			log_message('error', 'cmap getActivitiesRecursiveCall() - activity item not found: '.$uuid.'/'. $version. '/');
			return;
		}
		/*echo "<pre>";                                 
		print_r($data);
		echo "<pre>";	
		exit;*/	
		return $data;
	} //END OF getActivityRecursiveCall()
	
	
	 
     /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
	 
    protected function Xml2Array($itemXml, $y, $j) 
    {
       $tmp = array();
	   $topicTitle = '/xml/item/curriculum/topics/topic/name';
	   $topicCode = '/xml/item/curriculum/topics/topic/code';
	   //$activityType = '/xml/item/curriculum/activities/activity/@type';
	   	   
	   $tmp['title'] = $itemXml->nodeValue($topicTitle);
	   $tmp['code'] = $itemXml->nodeValue($topicCode);
	  // $tmp['activityType'] = $itemXml->nodeValue($activityType);
	   
	   $tmp['numLinkedActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid'); 
	   
	   // Put the linked activity uuids into an array
	   for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');  $i++) {
			
			$uuid = '/xml/item/curriculum/activities/linked_activities/uuid['.$i.']';
			$tmp['linked_activities'][$i]['uuid'] = $itemXml->nodeValue($uuid);

	   }
       return $tmp;
    }
	

 	protected function topicXml2Array($itemXml) 
    {
       $tmp = array();
	  // $topicTitle = '/xml/item/curriculum/topics/topic/name';
	   $topicCount = $itemXml->numNodes('/xml/item/curriculum/topics/topic');
	   for($x=1; $x<=$topicCount; $x++)
	   {
		   $tmp['topic'][$x]['title'] = $itemXml->nodeValue('/xml/item/curriculum/topics/topic['.$x.']/name');
		   $tmp['topic'][$x]['code']= $itemXml->nodeValue('/xml/item/curriculum/topics/topic['.$x.']/code');
	   }
	 
       return $tmp;
    }
	
     /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
	 
    protected function itemXml2Array($itemXml) 
    {		
		$tmp = array();
	   // $activityType = '/xml/item/curriculum/activities/activity/@type';
	   //$tmp['numActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_actvities/uuid');
	   
	   	// Put the linked activity uuids into an array
		
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');  $i++) 
		{
			$uuid = '/xml/item/curriculum/activities/linked_activities/uuid['.$i.']';
			$tmp[$i]['uuid'] = $itemXml->nodeValue($uuid);
		}
        return $tmp;
    }
	
	private function setValue(&$data, $path, $value) 
	{
    	$temp = &$data;
    	foreach ( $path as $key ) {
        	$temp = &$temp[$key];
   		 }
    	$temp = $value;
    	return $value ;
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
    private function validate_params($courseCode)
    {

        if(strcmp($courseCode, 'missed')==0 ||is_numeric($courseCode) )
		{
            return false;
		}
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