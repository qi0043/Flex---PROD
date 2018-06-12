<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maptopicstest extends CI_Controller {
	
	public function index( $topic_code='missed' )
	{
		//parameter validation
		$errdata['heading'] = "Error";
        if($this->validate_params($topic_code) == false)
        {
            $errdata['message'] = "Invalid Request";
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
		
		$this->load->helper('url');
       	$this->load->library('flexrest/flexrest');
		
		$ci =& get_instance();
		$ci->load->config('flex');
		$collection_uuid = $ci->config->item('taa_collection');
					
		$course = array();
		$data = array('course' => $this->getTopics($topic_code, $collection_uuid,'TAA', $course));
		unset($course);
		
		/*echo "<pre>";
		echo "Course array from public function<br />";
		print_r($data);
		echo "</pre>";*/
		
		$this->load->view('ocf/topicmap_test', $data);   //load data to the view
	}
	 
    /****
		Parameters:
		@depth: how many years of study this course may have. eg: 4 ( NOT NULL )
		@courseCode: eg: MD
		@schoolName: eg School of Medicine
		@topicDisciplline : eg MMED or MMED8    ( NOT NULL )
		@collectionUuid: the uuid of the collection you would like to search in
		@item_type: /xml/item/curriculum/@item_type , eg: SAM, TAA    ( NOT NULL )
		
		return $course array
	******/
	private function getTopics($topicDiscipline = 'missed', $collectionUuid='missed', $item_type='missed', $course)
	{
		$depth = 1;
		$this->load->library('flexrest/flexrest');
		$errdata['heading'] = "Error";
		
		if($this->validate_params_getTopics($topicDiscipline, $item_type, $collectionUuid) == false)
        {
            $errdata['message'] = "Invalid Request";
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
		
		//construct where query
		$where = "/xml/item/@itemdefid='" . $collectionUuid . "' AND /xml/item/curriculum/@item_type='". $item_type . "' AND /xml/item/curriculum/topics/topic/code LIKE '" . $topicDiscipline . "%'";		
		$where = urlencode($where);
		
		//generate temp access token
		$success = $this->flexrest->processClientCredentialToken();
	
		if(!$success)
		{
			$errdata['message'] = $this->flexrest->error;
			$this->load->view('ocf/showerror_view', $errdata);
			return;
		}  
		else
		{	//echo $depth;
			$searchsuccess = $this->flexrest->search($response, '', $collectionUuid, $where, 0, 50, 'name', false, 'all', false);
		
			/*echo 'Response: <pre>';
			print_r($response);
			echo '</pre>';*/
			
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
							$keys=array();
							$data=array();
							$returndata = $this->getActivityRecursiveCall($attachmentUuid, $attachment['itemUuid'], $attachment['itemVersion'], $topicDiscipline, '', 1, $keys,$data,true);						
						    $course[$depth]['topics'][$j]['linked_activities'][$l] = $returndata;
						}
					}
				}
			}
		}
		return $course;			
	}

    /***************************************
		recursive call of Linked Activities 
	****************************************/
	private function getActivityRecursiveCall($attatchmentUuid, $uuid, $version, $topicCode, $itemresponse, $index, &$keys, &$data, $furtherCall)
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
			
			if($tmp['activityType'] == 'integrated')
			{
				//echo 'activityType:'. $tmp['activityType'];
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
					foreach($tmp['linked_activities'] as $linked_uuid_object)
					{	
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
										$this->getActivityRecursiveCall($attachment['uuid'],$linked_attachment_item_uuid,$linked_attachment_item_version,$topicCode,'', $act_index, $keys, $data, false);
									}
									else
									{
										$this->getActivityRecursiveCall($attachment['uuid'],$linked_attachment_item_uuid,$linked_attachment_item_version,$topicCode,'', $act_index, $keys, $data, true);
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
				//$tmp['uuid']=$attatchmentUuid;
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
			echo 'item not found';
		}
		return $data;
	} //END OF getActivityRecursiveCall()
	

    /**
     * Validate index parameters
     *
     * @param string $topic_code, eg. 'MMED8104'
     */
    private function validate_params($topic_code)
    {
        if(strcmp($topic_code, 'missed')==0 || strlen($topic_code) > 9 || strlen($topic_code) < 8 || is_numeric($topic_code))
		{
            return false;
		}
		else
		{
        	return true;
		}
    }
	
	/**
     * Validate getTopics parameters
     *
     * @param string $topic_code, eg. 'MMED8104'
     */
    private function validate_params_getTopics($topic_code,$item_type, $collectionUuid)
    {
        if(strcmp($topic_code, 'missed')==0 || strlen($topic_code) > 9 || strlen($topic_code) < 8 || is_numeric($topic_code))
		{
            return false;
		}
		else if(strcmp($item_type, 'missed')==0 || is_numeric($item_type)) 
		{
			return false;
		}
		else if(strcmp($collectionUuid, 'missed')==0 || strlen($collectionUuid) != 36 || is_numeric($collectionUuid))
		{
			return false;
		}
		else
		{
        	return true;
		}
    }
	 
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
	 
} 