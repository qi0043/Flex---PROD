<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SetActivityLock extends CI_Controller {
	
	 public function __construct()
     {
            parent::__construct();
            $ci =& get_instance();
            $ci->load->config('flex');
			$this->load->helper('url');
        	$this->load->library('flexrest/flexrest');
			$this->load->model('ocf/ocf_model');
			
			//session_start();
			
	 }
	
	public function getTopics($courseCode = 'missed')
	{			
		$errdata['heading'] = "Notice";
		
		if(!$this -> validate_params($courseCode))
		{
			$errdata['message'] = 'Invalid course code';
            $this->load->view('ocf/showerror_view', $errdata);
            return;
		}    
		
		#check course code
		/*$check_course_code = $this->ocf_model->db_get_courseInfo(strtoupper($courseCode));
		$course_year = $check_course_code[0]['course_total_year'];*/
		
		$ci =& get_instance();
		$ci->load->config('flex');
		$collection_uuid = $ci->config->item('taa_collection');
		
		$course=array();
		$data = array('course' => $this->recursiveCall(4, strtoupper($courseCode),'','', $collection_uuid,'TAA', $course, 1));
		unset($course); 
		/*echo "<pre>";                                 
		print_r($data);
		echo "<pre>"; */
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
	private function recursiveCall($depth_index, $courseCode = '', $schoolName = '', $topicDiscipline = '', $collectionUuid, $item_type, $course, $depth)
	{
		//$this->load->library('flexrest/flexrest');

		if($courseCode != '' || $schoolName != '')
		{
			
			while($depth <=  $depth_index)
			{
				echo '<h1>Updating ' . $depth. '</h1><br/>';
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
					$this->load->view('ocf/showerror_view', $errdata);
					return;
				}  
				
				if($success)
				{	//echo $depth;
					$searchsuccess = $this->flexrest->search($response, '', $collectionUuid, $where, 0, 50, 'name', false, 'all', false);
				
					if(!$searchsuccess)
					{
						$errdata['message'] = $this->flexrest->error;
						$this->load->view('ocf/showerror_view', $errdata);
						return;
					}
					
					$topicCount = intval($response['available']);
					
					//lets start building the array
					$course[$depth]['year'] = $depth;
					$course[$depth]['numTopics'] = $topicCount;
					
					//iterate through all TAAs under the current study year
					for ($i=0; $i < $topicCount; $i++) 
					{
						$j = $i + 1;
						$xmlwrapper_name = 'xmlwrapper'.$depth."_".$j;

						//pull out each TAA XML 
						$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['results'][$i]['metadata']), $xmlwrapper_name);
						$course[$depth]['topics'][$j] = $this->Xml2Array($this->$xmlwrapper_name, $depth, $j);
						$course[$depth]['topics'][$j]['name'] = $response['results'][$i]['name']; //store each TAA name in array
						
						$l = 0 ;
						//iterate through all linked_activities under each TAA XML
						foreach($course[$depth]['topics'][$j]['linked_activities'] as $linked) 
						{
							$l++;
							$linkedUUID = $linked['uuid']; //get each linked_activity UUID
							$a = 0;
	               		 	$itemresponse = '';
							$key = array();
							$data = array();
							$returnData = array();
							$do_condition = '';
							//iterate through all attachments under each responsed TAA
							foreach( $response['results'][$i]['attachments'] as $attachment ) 
							{
								$a++ ;
								$attachmentUuid = $attachment['uuid'];
								if ( $attachmentUuid === $linkedUUID ) 
								{
									$course[$depth]['topics'][$j]['linked_activities'][$l]['itemUuid'] = $attachment['itemUuid'];
									$course[$depth]['topics'][$j]['linked_activities'][$l]['itemVersion'] = $attachment['itemVersion'];
									//$time_start=$this->microtime_float();
									
									//$data = $this->getActivityRecursiveCall($attachment['uuid'],$attachment['itemUuid'],$attachment['itemVersion'],'',1, $keys=array(), $vdata = array(),true);
									$returnData = $this->getActivityRecursiveCall($attachmentUuid,$attachment['itemUuid'],$attachment['itemVersion'], $do_condition, '',1,$key,$data,true);
									//$time_end = $this->microtime_float();
									
									//$time = $time_end - $time_start;
									
									//$this->logger_topics->error('linked activity: '.$attachmentUuid .' executive time: ' . $time);
									//echo "<pre>";                                 
									//print_r($data);
									//echo "<pre>";				
									//$topics['linked_activities'][$l] = $returnData;			
									$course[$depth]['topics'][$j]['linked_activities'][$l] = $returnData;
								}
							}
						}
					}
				}
				
				$depth++;
				$this->recursiveCall($depth_index,$courseCode,$schoolName,$topicDiscipline,$collectionUuid,$item_type,$course, $depth);
			}
			$course['course_code'] = $courseCode;
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
	private function getActivityRecursiveCall($attatchmentUuid, $uuid, $version, $do_condition, $r, $index, &$keys, &$data, $furtherCall)
	{

		$this->load->library('flexrest/flexrest');
		$itemsuccess = $this->flexrest->getItem($uuid, $version,$r);
		
		if($itemsuccess)
		{
			echo 'updating item' .$uuid . '...<br/>' ;
			$s = $this->flexrest->getLock($uuid, $version, $lock);
			if($s)
			{
				echo '<h3>item locked ' .$uuid . '</h3><br/>' ;
			}
			
			$itemresponse = $r;
				
				$xmlwrapper_name = 'xmlwrapper_' . $uuid.'_'.$index;
				
				$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$itemresponse['metadata']), $xmlwrapper_name);
				
				$tmp = array();
				$tmp['uuid'] = $attatchmentUuid;
				$tmp['itemUuid'] = $uuid;
				$tmp['itemVersion'] = $version;
				$tmp['activityType'] = $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/activities/activity/@type');
				$tmp['activityName']= $this->$xmlwrapper_name->nodeValue('/xml/item/itembody/name');
				$tmp['activityLevel'] = $index;
				
				//get activity locks
				$nLock = $this->$xmlwrapper_name->nodeValue('/xml/item/restrictions/locked/locks/item_name');
				if(isset($nLock) && $nLock != 'Yes')
				{
					$this->$xmlwrapper_name->setNodeValue("/xml/item/restrictions/locked/locks/item_name", 'Yes');
				}
				
				$oLock = $this->$xmlwrapper_name->nodeValue('/xml/item/restrictions/locked/locks/item_description');
				if(isset($oLock) && $oLock != 'Yes')
				{
					$this->$xmlwrapper_name->setNodeValue("/xml/item/restrictions/locked/locks/item_description", 'Yes');
				}
				
			
				if($do_condition== '')
				{
					$do_condition = 'required';
				}
				$tmp['do_condition'] = $do_condition;
				
				if($tmp['activityType'] == 'group')
				{
					$aLock = $this->$xmlwrapper_name->nodeValue('/xml/item/restrictions/locked/locks/activities');
					if(isset($aLock) && $aLock != 'Yes')
					{
						$this->$xmlwrapper_name->setNodeValue("/xml/item/restrictions/locked/locks/activities", 'Yes');
					}
	 
					$tmp['numLinkedActivities'] = $this->$xmlwrapper_name->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');  
					$tmp['group_how_many'] =  $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/activities/activity/@group_how_many');  
					
						
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
											$itemresponse['metadata'] = $this->$xmlwrapper_name->__toString();
											$updatesuccess = $this->flexrest->editItem($uuid, $version, $itemresponse, $updateresponse, '');
											 
											if(!$updatesuccess)
											{
												$errdata['message'] = $this->flexrest->error;
												log_message('error', 'Item name update fail, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
												echo $errdata['message'];
												//$this->load->view('rhd/showerror_view', $errdata);
												return;
											} 
											$this->getActivityRecursiveCall($attachment['uuid'],$linked_attachment_item_uuid,$linked_attachment_item_version,$condition,'', $act_index, $keys, $data, false);
										}
										else
										{
											$itemresponse['metadata'] = $this->$xmlwrapper_name->__toString();
											$updatesuccess = $this->flexrest->editItem($uuid, $version, $itemresponse, $updateresponse, '');
											 
											if(!$updatesuccess)
											{
												$errdata['message'] = $this->flexrest->error;
												log_message('error', 'Item name update fail, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
												echo $errdata['message'];
												//$this->load->view('rhd/showerror_view', $errdata);
												return;
											} 
											$this->getActivityRecursiveCall($attachment['uuid'],$linked_attachment_item_uuid,$linked_attachment_item_version,$condition,'', $act_index, $keys, $data, true);
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
						$itemresponse['metadata'] = $this->$xmlwrapper_name->__toString();
						$updatesuccess = $this->flexrest->editItem($uuid, $version, $itemresponse, $updateresponse, '');
						if(!$updatesuccess)
						{
							$errdata['message'] = $this->flexrest->error;
							log_message('error', 'Item name update fail, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
							echo $errdata['message'];
							//$this->load->view('rhd/showerror_view', $errdata);
							return;
						} 
					
						echo $uuid.' unlocked<br/>';
						
					}
				}
				
				if($tmp['activityType'] == 'activity')
				{
					//$do_condition = 'required';
					$tmp['do_condition'] = $do_condition;
					$tmp['numLinkedActivities'] = 0;  
					//$tmp['itemVersion']=$version;
					$this->setValue($data,$keys,$tmp);  
					$itemresponse['metadata'] = $this->$xmlwrapper_name->__toString();
					$updatesuccess = $this->flexrest->editItem($uuid, $version, $itemresponse, $updateresponse, '');
					 
					if(!$updatesuccess)
					{
						$errdata['message'] = $this->flexrest->error;
						log_message('error', 'Item name update fail, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
						echo $errdata['message'];
						//$this->load->view('rhd/showerror_view', $errdata);
						return;
					} 
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
			log_message('error', 'cmap getActivitiesRecursiveCall() - activity item not found: '.$uuid.'/'. $version. '/'.$r);
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
	
	private function setValue(&$data, $path, $value) {
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

	 
} 