<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assessment extends CI_Controller {
	
	public function index()
	{
		$this->load->helper('url');
       	$this->load->library('flexrest/flexrest');
		
		$ci =& get_instance();
		$ci->load->config('flex');
		$collection_uuid = $ci->config->item('sam_collection');
		
		$course=array();
		$courseCode = 'MD';	
		$data = array('course' => $this->listSam(1, 4,$courseCode,$collection_uuid, $course));
		
		/*echo "<pre>";                                 
	    print_r($data);
		echo "<pre>";	*/
		
		unset($course);
		$this->load->view('ocf/assessmentMap', $data);   //load data to the view
		
	}
	
	private function listSam($year, $year_max, $courseCode, $collection_uuid, $course)
	{
		$this->load->library('flexrest/flexrest');
		while($year <= $year_max)
		{
			$where = "/xml/item/curriculum/courses/course/code='" . $courseCode ."' AND ";
			$where = $where . "/xml/item/curriculum/topics/topic/code LIKE '" . "MMED8".$year."%' AND ";
			$where = $where . "/xml/item/@itemstatus='live'";
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
				$searchsuccess = $this->flexrest->search($response, '', $collection_uuid, $where, 0, 50, 'name', false, 'all', false);
			
				if(!$searchsuccess)
				{
					$errdata['message'] = $this->flexrest->error;
					$this->load->view('ocf/showerror_view', $errdata);
					return;
				}
				
				$topicCount = intval($response['available']);
	            
				//lets start building the array
				$course[$year]['year'] = $year;
				$course[$year]['numSAMs'] = $topicCount;
				
				//iterate through all TAAs under the current study year
				for ($i=0; $i < $topicCount; $i++) 
				{
					$j = $i + 1;
					$xmlwrapper_name = 'xmlwrapper'.$year."_".$j;
					
					//pull out each TAA XML 
					$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['results'][$i]['metadata']), $xmlwrapper_name); 
					$tmp = $this->sam2Array($this->$xmlwrapper_name);
					$tmp_avail_year = $tmp['availyear']; 
					$tmp['samTitle'] = (string)$response['results'][$i]['name'];
					$tmp['samDescription'] = (string)$response['results'][$i]['description'];
					$tmp['item_uuid'] = $response['results'][$i]['uuid'];
					$tmp['item_version'] = (int)$response['results'][$i]['version'];
					//array_push($course[$year]['SAM'][$tmp_avail_year], $tmp);
					$course[$year]['SAM'][$tmp_avail_year][$j] = $tmp;
					
				}
			}
			$year++;
			$this->listSam($year, $year_max, $courseCode, $collection_uuid, $course);
		}
		return $course;
    }
	
	
	private function searchAssessment($year, $year_max,$courseCode, $collection_uuid, $course)
	{   
		$this->load->library('flexrest/flexrest');
		while($year <= $year_max)
		{
			$where = "/xml/item/curriculum/courses/course/code='" . $courseCode ."' AND ";
			$where = $where . "/xml/item/curriculum/topics/topic/code LIKE '" . "MMED8".$year."%'";
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
				$searchsuccess = $this->flexrest->search($response, '', $collection_uuid, $where, 0, 50, 'name', false, 'all', false);
			
				if(!$searchsuccess)
				{
					$errdata['message'] = $this->flexrest->error;
					$this->load->view('ocf/showerror_view', $errdata);
					return;
				}
				
				$topicCount = intval($response['available']);
	
				//lets start building the array
				$course[$year]['year'] = $year;
				$course[$year]['numSAMs'] = $topicCount;
				
				//iterate through all TAAs under the current study year
				for ($i=0; $i < $topicCount; $i++) 
				{
					$j = $i + 1;
					$xmlwrapper_name = 'xmlwrapper'.$year."_".$j;
	
					//pull out each TAA XML 
					$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['results'][$i]['metadata']), $xmlwrapper_name);
					$course[$year]['SAM'][$j] = $this->Assessment2Array($this->$xmlwrapper_name, $year, $j);
					//$course[$year]['SAM'][$j]['name'] = $response['results'][$i]['name']; //store each TAA name in array		
				}
			}
			$year++;
			$this->searchAssessment($year, $year_max, $courseCode, $collection_uuid, $course);
		}
		
		return $course;	
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
		$this->load->library('flexrest/flexrest');

		if($courseCode != '' || $schoolName != '')
		{
			
			while($depth <=  $depth_index)
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
							//iterate through all attachments under each responsed TAA
							foreach( $response['results'][$i]['attachments'] as $attachment ) 
							{
								$a++ ;
								$attachmentUuid = $attachment['uuid'];
								if ( $attachmentUuid === $linkedUUID ) 
								{
									$course[$depth]['topics'][$j]['linked_activities'][$a]['itemUuid'] = $attachment['itemUuid'];
									$course[$depth]['topics'][$j]['linked_activities'][$a]['itemVersion'] = $attachment['itemVersion'];
									//$time_start=$this->microtime_float();
									
									//$data = $this->getActivityRecursiveCall($attachment['uuid'],$attachment['itemUuid'],$attachment['itemVersion'],'',1, $keys=array(), $vdata = array(),true);
									//$time_end = $this->microtime_float();
									
									//$time = $time_end - $time_start;
									
									//$this->logger_topics->error('linked activity: '.$attachmentUuid .' executive time: ' . $time);
									//echo "<pre>";                                 
									//print_r($data);
									//echo "<pre>";							
									//$course[$depth]['topics'][$j]['linked_activities'][$l] = $data;
								}
							}
						}
					}
				}
				//return $course;	
				//$depth--;
				$depth++;
				$this->recursiveCall($depth_index,$courseCode,$schoolName,$topicDiscipline,$collectionUuid,$item_type,$course, $depth);
			}
			return $course;	
			//echo "<pre>";                                 
			//print_r($course);
			//echo "<pre>";	
			//exit;	
		}
		else
		{
			 #go to error page (have to provide a courseCode or schoolName)
			 $errdata['message'] = "have to provide a course code or a school name";
			 $this->load->view('ocf/showerror_view', $errdata);
			 return;
		}
	}

	/************************************************
		AJAX function posting from cmap.js
	*************************************************/
	public function getActivities()
	{
		 $this->load->helper('url');   
		 $activities = $_POST["activities"];
		 
		 $itemresponse = '';
		 $key = array();
		 $data = array();
		 $returnData = array();
	    
		 for($x=1; $x<=count($activities); $x++)
		 {	 
			 $attachmentUuid = $activities[$x]["uuid"];
			 $uuid = $activities[$x]["itemUuid"];
			 $version = $activities[$x]["itemVersion"];
			 $topicCode = $activities[$x]["topic_code"];
			 $do_condition = '';
			 if($attachmentUuid != '' && $uuid != '')
			{
				$returnData[$x] = $this->getActivityRecursiveCall($attachmentUuid,$uuid,$version,$topicCode, $do_condition, '',1,$key,$data,true);
				
			//$this->load->view('ocf/cmap_activities', $attachmentUuid, $uuid,$version,$topicCode); 
			}
			 else
			{
				echo 'not right';
			}
		 }
		 $data = array('data' => $returnData);
		
		 $this->load->view('ocf/cmap_activities', $data); 
		 
		
		/* $attachmentUuid = $_POST["attachmentUuid"];
		 $uuid = $_POST["uuid"];
		 $version = $_POST["version"];
		 $topicCode = $_POST["topicCode"];
		 $itemresponse = '';
		 $index = 1;
		 $key = array();
		 $data = array();
		 if($attachmentUuid != '' && $uuid != '')
		 {
		 	$returnData = $this->getActivityRecursiveCall($attachmentUuid,$uuid,$version,$topicCode,'',1,$key,$data,true);
			$this->load->view('ocf/cmap_activities', $returnData); 
		 }
		 else
		 {
			 echo 'not right';
		  }*/
	}


    /***************************************
		recursive call of Linked Activities 
	****************************************/
	private function getActivityRecursiveCall($attatchmentUuid, $uuid, $version, $topicCode, $do_condition, $itemresponse, $index, &$keys, &$data, $furtherCall)
	{

		$this->load->library('flexrest/flexrest');
		$itemsuccess = $this->flexrest->getItem($uuid, $version,$itemresponse);
		
		if($itemsuccess)
		{
			$xmlwrapper_name = 'xmlwrapper_' . $uuid;
			
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$itemresponse['metadata']), $xmlwrapper_name);
			
			$tmp = array();
			$tmp['uuid']=$attatchmentUuid;
			$tmp['itemUuid']=$uuid;
			$tmp['itemVersion']=$version;
			$tmp['activityType'] = $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/activities/activity/@type');
			$tmp['activityName']= $this->$xmlwrapper_name->nodeValue('/xml/item/itembody/name');
			$tmp['topicCode']=$topicCode;
			if($do_condition!= '')
			{
				$tmp['do_condition'] = $do_condition;
			}
			if($tmp['activityType'] == 'group')
			{
				//echo 'activityType:'. $tmp['activityType'];
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
										$this->getActivityRecursiveCall($attachment['uuid'],$linked_attachment_item_uuid,$linked_attachment_item_version,$topicCode,$condition,'', $act_index, $keys, $data, false);
									}
									else
									{
										$this->getActivityRecursiveCall($attachment['uuid'],$linked_attachment_item_uuid,$linked_attachment_item_version,$topicCode,$condition,'', $act_index, $keys, $data, true);
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
				$tmp['do_condition'] = $do_condition;
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
			log_message('error', 'cmap getActivitiesRecursiveCall() - activity item not found: '.$uuid.'/'. $version. '/'.$itemresponse);
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
	
	protected function sam2Array($itemXml) 
    {
    	$tmp = array();
	   	$topicTitle = '/xml/item/curriculum/topics/topic/name';
	  	$topicCode = '/xml/item/curriculum/topics/topic/code';
		$availYear = '/xml/item/curriculum/avails/avail/year';

		$tmp['topicTitle'] = $itemXml->nodeValue($topicTitle);
	   	$tmp['code'] = $itemXml->nodeValue($topicCode);
		$tmp['availyear'] = $itemXml->nodeValue($availYear);
		
		
		
		/*echo " SAM Items: <pre>";                                 
	    print_r($tmp);
		echo "<pre>";
		exit;*/
		
		return $tmp;
	}
	protected function Assessment2Array($itemXml, $y, $j) 
    {
       $tmp = array();
	   $topicTitle = '/xml/item/curriculum/topics/topic/name';
	   $topicCode = '/xml/item/curriculum/topics/topic/code';
	   //$activityType = '/xml/item/curriculum/activities/activity/@type';
	   	   
	   $tmp['title'] = $itemXml->nodeValue($topicTitle);
	   $tmp['code'] = $itemXml->nodeValue($topicCode);
	  // $tmp['activityType'] = $itemXml->nodeValue($activityType);
	   
	   $tmp['assessment_num'] = $itemXml->numNodes('/xml/item/curriculum/assessment/a_items/a_item'); 
	   
	   //assessments
	   for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/assessment/a_items/a_item');  $i++) {
			
			$sys_id = '/xml/item/curriculum/assessment/a_items/a_item['.$i.']/@sys_id';
			$tmp['assessment'][$i]['sys_id'] = $itemXml->nodeValue($sys_id);
			$name = '/xml/item/curriculum/assessment/a_items/a_item['.$i.']/name';
			$tmp['assessment'][$i]['name'] = $itemXml->nodeValue($name);
			$format = '/xml/item/curriculum/assessment/a_items/a_item['.$i.']/format';
			$tmp['assessment'][$i]['format'] = $itemXml->nodeValue($format);
			$deadline = '/xml/item/curriculum/assessment/a_items/a_item['.$i.']/deadline';
			$tmp['assessment'][$i]['deadline'] = $itemXml->nodeValue($deadline);
			$penalties = '/xml/item/curriculum/assessment/a_items/a_item['.$i.']/penalties';
			$tmp['assessment'][$i]['penalties'] = $itemXml->nodeValue($penalties);
			$return_date = '/xml/item/curriculum/assessment/a_items/a_item['.$i.']/return_date';
			$tmp['assessment'][$i]['return_date'] = $itemXml->nodeValue($return_date);
	   }
	   
	   //course learning ouctomes and alignment
	   $tmp['course_outcome_num'] = $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo');
	   for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo');  $i++) {
			
			$cat_code = '/xml/item/curriculum/outcomes/course/los/lo['.$i.']/@cat_code';
			$tmp['course_outcome'][$i]['cat_code'] = $itemXml->nodeValue($cat_code);
			
			$cat_name = '/xml/item/curriculum/outcomes/course/los/lo['.$i.']/@cat_name';
			$tmp['course_outcome'][$i]['cat_name'] = $itemXml->nodeValue($cat_name);
			
			$sys_id = '/xml/item/curriculum/outcomes/course/los/lo['.$i.']/@sys_id';
			$tmp['course_outcome'][$i]['sys_id'] = $itemXml->nodeValue($sys_id);
			
			$code = '/xml/item/curriculum/outcomes/course/los/lo['.$i.']/code';
			$tmp['course_outcome'][$i]['code'] = $itemXml->nodeValue($code);
			
			$name = '/xml/item/curriculum/outcomes/course/los/lo['.$i.']/name';
			$tmp['course_outcome'][$i]['name'] = $itemXml->nodeValue($name);
			
			$level= '/xml/item/curriculum/outcomes/course/los/lo['.$i.']/level';
			$tmp['course_outcome'][$i]['level'] = $itemXml->nodeValue($level);
			
			$tmp['course_outcome'][$i]['aligned_topic_los_num'] = $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo['.$i.']/aligned/topic/los/lo');
			
			for ($x = 1; $x <= $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo['.$i.']/aligned/topic/los/lo');  $x++) {
				$aligned_topic_sysid = '/xml/item/curriculum/outcomes/course/los/lo['.$i.']/aligned/topic/los/lo['.$x.']/@sys_id';
				$tmp['course_outcome'][$i]['aligned_topic_los'][$x]['sys_id'] = $itemXml->nodeValue($aligned_topic_sysid);
				$aligned_topic_code= '/xml/item/curriculum/outcomes/course/los/lo['.$i.']/aligned/topic/los/lo['.$x.']/code';
				$tmp['course_outcome'][$i]['aligned_topic_los'][$x]['code'] = $itemXml->nodeValue($aligned_topic_code);
				$aligned_topic_name= '/xml/item/curriculum/outcomes/course/los/lo['.$i.']/aligned/topic/los/lo['.$x.']/name';
				$tmp['course_outcome'][$i]['aligned_topic_los'][$x]['name'] = $itemXml->nodeValue($aligned_topic_name);
				
			}
			
			$tmp['course_outcome'][$i]['aligned_assessment_num'] = $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo['.$i.']/aligned/a_items/a_item');
			
			for ($s = 1; $s <= $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo['.$i.']/aligned/a_items/a_item');  $s++) {
				$aligned_assessment_sysid = '/xml/item/curriculum/outcomes/course/los/lo['.$i.']/aligned/a_items/a_item['.$s.']/@sys_id';
				$tmp['course_outcome'][$i]['aligned_assessment'][$s]['sys_id'] = $itemXml->nodeValue($aligned_assessment_sysid);
				$aligned_assessment_code= '/xml/item/curriculum/outcomes/course/los/lo['.$i.']/aligned/a_items/a_item['.$s.']/code';
				$tmp['course_outcome'][$i]['aligned_assessment'][$s]['code'] = $itemXml->nodeValue($aligned_assessment_code);
				$aligned_assessment_name= '/xml/item/curriculum/outcomes/course/los/lo['.$i.']/aligned/a_items/a_item['.$s.']/name';
				$tmp['course_outcome'][$i]['aligned_assessment'][$s]['name'] = $itemXml->nodeValue($aligned_assessment_name);
			}
			
	   }
	   
	   //professional learning outcomes and alignment
	   $tmp['prof_outcome_num'] = $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo');
	   for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo');  $i++) {
			
			$cat_code = '/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/@cat_code';
			$tmp['prof_outcome'][$i]['cat_code'] = $itemXml->nodeValue($cat_code);
			
			$cat_name = '/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/@cat_name';
			$tmp['prof_outcome'][$i]['cat_name'] = $itemXml->nodeValue($cat_name);
			
			$sys_id = '/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/@sys_id';
			$tmp['prof_outcome'][$i]['sys_id'] = $itemXml->nodeValue($sys_id);
			
			$code = '/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/code';
			$tmp['prof_outcome'][$i]['code'] = $itemXml->nodeValue($code);
			
			$name = '/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/name';
			$tmp['prof_outcome'][$i]['name'] = $itemXml->nodeValue($name);
			
			$level= '/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/level';
			$tmp['prof_outcome'][$i]['level'] = $itemXml->nodeValue($level);
			
			$tmp['prof_outcome'][$i]['aligned_topic_los_num'] = $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/aligned/topic/los/lo');
			
			for ($x = 1; $x <= $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/aligned/topic/los/lo');  $x++) {
				$aligned_topic_sysid = '/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/aligned/topic/los/lo['.$x.']/@sys_id';
				$tmp['prof_outcome'][$i]['aligned_topic_los'][$x]['sys_id'] = $itemXml->nodeValue($aligned_topic_sysid);
				$aligned_topic_code= '/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/aligned/topic/los/lo['.$x.']/code';
				$tmp['prof_outcome'][$i]['aligned_topic_los'][$x]['code'] = $itemXml->nodeValue($aligned_topic_code);
				$aligned_topic_name= '/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/aligned/topic/los/lo['.$x.']/name';
				$tmp['prof_outcome'][$i]['aligned_topic_los'][$x]['name'] = $itemXml->nodeValue($aligned_topic_name);
				
			}
			
			$tmp['prof_outcome'][$i]['aligned_assessment_num'] = $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/aligned/a_items/a_item');
			
			for ($s = 1; $s <= $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/aligned/a_items/a_item');  $s++) {
				$aligned_assessment_sysid = '/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/aligned/a_items/a_item['.$s.']/@sys_id';
				$tmp['prof_outcome'][$i]['aligned_assessment'][$s]['sys_id'] = $itemXml->nodeValue($aligned_assessment_sysid);
				//$aligned_assessment_code= '/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/aligned/a_items/a_item['.$s.']/code';
				//$tmp['prof_outcome'][$i]['aligned_assessment'][$s]['code'] = $itemXml->nodeValue($aligned_assessment_code);
				$aligned_assessment_name= '/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/aligned/a_items/a_item['.$s.']/name';
				$tmp['prof_outcome'][$i]['aligned_assessment'][$s]['name'] = $itemXml->nodeValue($aligned_assessment_name);
			}
			
	   }

	   /*echo " Assessment Items: <pre>";                                 
	    print_r($tmp);
		echo "<pre>";*/	
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
	 
} 