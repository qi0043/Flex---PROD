<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contributeactivity extends CI_Controller {
 
	public function index($uuid='missed', $version='missed', $taa='missed')
	{
		
		if(!isset($_SESSION)){ session_start();}
		
		#echo "<pre>";
		#echo "contributeactivity.php - AC 30 SEP 2015<br />";
		
		
		
		$uuid= "a69768ef-7aa3-4d88-8318-a0266c7ce2fa";
		
		$uuid_length = strlen($uuid);
		
		$first32 = substr($uuid, 0, 32);
		$last4 = substr($uuid, -4);
		
		
		#echo $uuid . "<br />";
		#echo $first32 . " " . $last4;
		
		#if (!is_numeric($last4)) { echo " (NOT NUMERIC) <br />"; }
		
		#$last4 = 1000;
		
		
		#echo $first32 . " " . $last4;
		
		#if (!is_numeric($last4)) { echo " (NOT NUMERIC) <br />"; }
		
		
		#exit;
		
		$version = "1";
		
		
		$topic= "MMED8103";
		
		$fan = $_SERVER['REMOTE_USER'];
		
		#echo  "uuid = " . $uuid . "<br />";
		#echo  "version = " . $version . "<br />";
		#echo  "topic = " . $taa . "<br />";
		
		#echo  "fan = " . $fan . "<br />";
		
		$this->load->library('flexrest/flexrest');
			$ci =& get_instance();
            $ci->load->config('flex');
           // $institute_url = $ci->config->item('institute_url');
			$collection_id = $ci->config->item('md_activities_collection');
			
			#echo  "collection_id = " . $collection_id . "<br />";
		
		
		$success = $this->flexrest->processClientCredentialToken();
			
			if(!$success)
			{
				$errdata['heading'] = "Error";
				$errdata['message'] = $this->flexrest->error;
				$this->load->view('rhd/showerror_view', $errdata);
				return;
			}  
		
		
		
		/****************************************************************************/
		
		/* Find parent activity information                                         */
		
		/****************************************************************************/
		
		$success = $this->flexrest->getItem($uuid, $version, $response); // will use this response array later
		
		
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
		
		
		
		//print_r($response);
		
		#echo "</pre>";
		
		
		//create a new item
		$item_bean["collection"]["uuid"] = $collection_id;
		
		
		//root node
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => '<xml><item></item></xml>'));
				
		//activity title, item name
		$title = "New activity for " . $response['name'];
		#$item_name = $this->xmlwrapper->createNodeFromXPath("/xml/item/itembody/name");
		$item_name = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/activities/activity/name");
		$this->xmlwrapper->createTextNode($item_name, $title);
			
		// activity description
		$description = "Please describe this activity";
		$item_description = $this->xmlwrapper->createNodeFromXPath("/xml/item/itembody/description");
		$this->xmlwrapper->createTextNode($item_description, $description);
		
		
		// activity type attribute
		
		// create node
		$activity = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/activities/activity/");
		
		// create attribute
		$this->xmlwrapper->createAttribute($activity, "type");
		
		// set attribute
		
		//$activitytype = $this->xmlwrapper->node("/xml/item/curriculum/activities/activity/@type");
		$this->xmlwrapper->setNodeValue("/xml/item/curriculum/activities/activity/@type", "activity");
		
					
		// owner fan 
		$owner_fan = $this->xmlwrapper->createNodeFromXPath("/xml/item/item_owners/owner/fan");
		$this->xmlwrapper->createTextNode($owner_fan, $fan);
		
		// parent topic
		$created_for= $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/topics/topic/code");
		$this->xmlwrapper->createTextNode($created_for, $taa);
		
		
		$item_bean['metadata'] = $this->xmlwrapper->__toString();
		
		
		#echo "<pre>";
		
		#print_r($item_bean);
		
		#echo "</pre>";
		
		
		$itemsuccess = $this->flexrest->createItem($item_bean, $newitem);
		
		 if(!$itemsuccess)
            {
                $errdata['message'] = $this->flexrest->error;
                log_message('error', 'eReading list management createItem failed' . ', error: ' . $errdata['message']);
                #log_message('error', 'Metadata: ' . $item_bean['metadata']);
                #$this->load->view('reading_listmgr/showerror_view', $errdata);
                $result['error_info'] = $this->flexrest->error;
                echo json_encode($result);
                return;
            }
           
            #echo("<pre>==========response of createItem:<br>");
            #print_r($response1); echo("</pre>");
           
            if(!isset($newitem['headers']['location']))
            {
                $errdata['message'] = 'No Location header in createItem response.';
                log_message('error', 'eReading list management createItem failed' . ', error: ' . $errdata['message']);
                #$this->load->view('reading_listmgr/showerror_view', $errdata);
                $result['error_info'] = $errdata['message'];
                echo json_encode($result);
                return;
            }
            $location = $newitem['headers']['location'];
            $institute_url = $ci->config->item('institute_url');
            $location1 = substr($location, strpos($location, 'item')+5);
            #$location1 = $institute_url . 'items' . $location1;
			$location1 = explode('/', substr($location1, 0, strlen($location1)-1));
			
			//$location1 = substr($location1, strlen($location1)-1);
			
			
			$new_uuid = $location1[0];
			$new_version = $location1[1];
			
			
 
		
		/****************************************************************************/
		
		/* Find new activity information                                         */
		
		/****************************************************************************/
		
		$newsuccess = $this->flexrest->getItem($new_uuid, $new_version, $newresponse);
		
		
		if(!$newsuccess)
            {
                $errdata['message'] = $this->flexrest->error;
                log_message('error', 'new item not found' . ', error: ' . $errdata['message']);
                #log_message('error', 'Metadata: ' . $item_bean['metadata']);
                #$this->load->view('reading_listmgr/showerror_view', $errdata);
                $result['error_info'] = $this->flexrest->error;
                echo json_encode($result);
                return;
            }
           
		
		/*
		echo "<pre>";
		print_r($newresponse);
		echo "</pre>";
		
		*/
		
		
		$parent_item_bean = $response;
		
		
		//echo "<pre>";
		//print_r($parent_item_bean);
		//echo "</pre>";
		
		//echo $parent_item_bean['metadata'];
		
		//exit;
		 
		
		
		
		
		$xmlwrapper_name = 'xmlwrapper'.'activity';
		//pull out metadata XML 
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$parent_item_bean['metadata']), $xmlwrapper_name);
		
		$linked_activities = $this->itemXml2Array($this->$xmlwrapper_name, $uuid);
		
		$new_attachment_uuid = $linked_activities['first32'].$linked_activities['last4'];
		
		//echo $new_attachment_uuid . "<br /><br /><br /><br />";
		// add this new uuid into the XML
		
		
		
		$linked_activity = $this->$xmlwrapper_name ->createNodeFromXPath("/xml/item/curriculum/activities/linked_activities/");
		//$this->$xmlwrapper_name ->createTextNode($linked_activity , $new_attachment_uuid);
		
		
		//$node_previous_files = $this->xmlwrapper->createNodeFromXPath($xpath_previous_files);
 
		$tmp_node_previous_file_uuid = $this->$xmlwrapper_name->createNode($linked_activity, "uuid");
 		$tmp_node_previous_file_uuid->nodeValue = $new_attachment_uuid;
		
		// create node
		$act_item = $this->$xmlwrapper_name ->createNodeFromXPath("/xml/item/curriculum/activities/act_item/");
		
		// create attribute
		$this->$xmlwrapper_name ->createAttribute($act_item, "sys_id");
		
		// set attribute
		
		//$activitytype = $this->xmlwrapper->node("/xml/item/curriculum/activities/activity/@type");
		$this->$xmlwrapper_name ->setNodeValue("/xml/item/curriculum/activities/act_item/@sys_id", $new_attachment_uuid);
		
		#do_condition
		$do_condition = $this->$xmlwrapper_name ->createNodeFromXPath("/xml/item/curriculum/activities/act_item/do_condition");
		$this->$xmlwrapper_name ->createTextNode($do_condition, "required");
		
		#name
		$name = $this->$xmlwrapper_name ->createNodeFromXPath("/xml/item/curriculum/activities/act_item/name");
		$this->$xmlwrapper_name ->createTextNode($name, $title);
		
		
		
		
		$parent_item_bean['metadata'] = $this->$xmlwrapper_name ->__toString();
		
		//echo "<pre>";
		//print_r($parent_item_bean['attachments']);
		//echo "</pre>";
		
		$existing_attachments = $parent_item_bean['attachments'];
		$num_attachments = count($existing_attachments );
		//echo "number of attachments = " . $num_attachments . "<br />";
		
		$new_attachment[$num_attachments] = array('type'=>'linked-resource','uuid'=>$new_attachment_uuid, 'description'=>$title,'itemUuid'=>$new_uuid,'itemVersion'=>$new_version, 'resourceType'=>'p', 'links'=>array('view'=>' ','view'=>' ','thumbnail'=>' ' ));
 
		
		$parent_item_bean['attachments'] = array_merge($existing_attachments, $new_attachment);
		
		//echo "<pre>";
		//print_r($parent_item_bean['attachments']);
		//echo "</pre>";

		
		//exit;
		
		$updateparentsuccess = $this->flexrest->editItem($uuid, $version, $parent_item_bean, $updateresponse, $filearea_uuid);
		
			
		
	
		echo "<pre>";
		print_r($updateresponse);
		echo "</pre>";
		 

	
		
		//echo $parent_item_bean['metadata'];
		
		//exit;
		
		/*
		 if(!isset($parent_item_bean['attachments']))
           $parent_item_bean['attachments'] = array();
         
        $existing_attachments = $parent_item_bean['attachments'];
 
      
	  
	  $new_attachments = array();
 
      $new_attachments[$attachment_count] = array('type'=>'file',
                                              'filename'=>$filename,
                                              'description'=>$filename,
                                              'uuid'=>$file_uuid);
 
     
	 
	 
	 $item_bean['attachments'] = array_merge($new_attachments, $existing_attachments);
	 
	 
		
		echo "<pre>";
		print_r($linked_activities);
		echo "</pre>";
		
		*/
	
				
				
				
} 



/**********************************/
/*      PRIVATE FUNCTIONS         */
/**********************************/

private function Xml2Array($itemXml) 
    {
    
		
		$newname = $this->input->post('name');
		
		//$tmp = $itemXml->nodeValue('/xml/item/curriculum/activities/activity/name');
		
		//echo $newname;
	

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


	private function generateToken($username)
	{
		$ci =& get_instance();
		$ci->load->config('flex');
	
		$sharedSecretId = $ci->config->item('ocf_shared_secret_id');
		$sharedSecretValue = $ci->config->item('ocf_shared_secret_value');
		

	
		$time = mktime() . '000';
				
	    return urlencode ($username) . ':' . urlencode($sharedSecretId) . ':' .  $time . ':' . 
	    urlencode(base64_encode (pack ('H*', md5 ($username . $sharedSecretId . $time . $sharedSecretValue))));
																
	}
	
	
     /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
	 
    protected function itemXml2Array($itemXml, $uuid) 
    {		
		$tmp = array();
		
		$first32 = substr($uuid, 0, 32);
		

		
	   # $activityType = '/xml/item/curriculum/activities/activity/@type';
		#$tmp['activity_type'] =  $itemXml->nodeValue($activityType);
		#$activityName = '/xml/item/itembody/name';
		#$tmp['activity_name'] =  $itemXml->nodeValue($activityName);
	   
	   
	   #$tmp['numActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');
	   
	   	// Put the linked activity uuids into an array
		
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');  $i++) 
		{
			$uuid = '/xml/item/curriculum/activities/linked_activities/uuid['.$i.']';
			$i_first32 = substr($itemXml->nodeValue($uuid), 0, 32);
			$i_last4 = substr($itemXml->nodeValue($uuid), -4);
			
			
			$tmp['first32'] = $first32;
			
			
			if (!is_numeric($i_last4)) { // not a number = first attachment from web interface
			
			$tmp['last4'] = 1000;
			
			}
			
			if($i_first32 == $first32) { // uuid exists so its not the first time
			
				
				$tmp['last4'] = $i_last4++;
				
		
			
			}
			
			
			
			
			
		}
        return $tmp;
    }


}