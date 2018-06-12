<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Learningandteachingnew extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/
<method_name>
* @see http://codeigniter.com/user_guide/general/urls.html
	**/

	public function index($uuid='missed', $version='missed', $tcode='missed', $parent='missed', $pversion='missed', $depth='missed')
	{
		
		

		#$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";
        
        if($this->validate_params($uuid, $version) == false)
        {
            $errdata['message'] = "Invalid learning and teaching uuid or version";
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
		
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		
		$success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = 'error in learning and teaching controller process clicent credential token: '.$this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }    
        
        
		/****************************************************************************/
		
		/* Find the activity information                                               */
		
		/****************************************************************************/
		
		
			$success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = 'error in learning and teaching controller getItem:'.$this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }


 


			
			
			
			$xmlwrapper_name = 'xmlwrapper'.'lat';
			
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
		
		
		
		
		if(!$this->itemIsIntegrated($this->$xmlwrapper_name))
        {
            $errdata['message'] = "Item is not integrated";
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
		
		
		 
		
		$item_array = $this->itemXml2Array($this->$xmlwrapper_name);
		
		
		$i = 0;
		
		foreach ($item_array['activities'] as $linked) {
			
			$i++;
			$linkedUUID = $linked['uuid'];
			
			foreach ($response['attachments'] as $attachment) {
				
				$attachmentUuid = $attachment['uuid'];
				
				if ($linkedUUID == $attachmentUuid) {
					
					$item_array['activities'][$i]['itemUuid'] = $attachment['itemUuid'];
					$item_array['activities'][$i]['itemVersion'] = $attachment['itemVersion'];
					$item_array['activities'][$i]['title'] = $attachment['description'];
					
					
					$itemsuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $itemresponse);
       				
					if(!$itemsuccess)
        				{
            				$errdata['message'] = $this->flexrest->error;
            				$this->load->view('ocf/showerror_view', $errdata);
            				return;
        				}
						
						
					$item_array['activities'][$i]['itemresponse'] = $itemresponse['metadata'];
					
					$xmlwrapper_name_item = 'xmlwrapper'.$attachment['itemUuid'];
			
					$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$itemresponse['metadata']), $xmlwrapper_name_item);
					
					
					$item_array['activities'][$i]['activityType'] = $this->attachmentXml2Array($this->$xmlwrapper_name_item);
					
					$item_array['activities'][$i]['activityParent'] = $uuid;
					$item_array['activities'][$i]['activityParentVersion'] = $version;
					$item_array['activities'][$i]['activityParentTitle'] = $response['name'];
					
					
				}
				
				
				
				
			}
			
			
			
			
			
		}
		
		
	
		
		$item_array['itemTitle'] = $response['name'];
		$item_array['itemDescription'] = $response['description'];
		$item_array['itemTopic'] = $tcode;
		
		$item_array['depth'] = $depth + 1;
		
		if (isset($parentItem) && (($parentItem != '') && ($parentItem != 'missed'))) {
		
		
		$item_array['hasParent'] = 1;
		$item_array['parentItem'] = $parentItem;
		$item_array['parentVersion'] = $pversion;
		$item_array['fromdepth'] = $depth;
		$item_array['depth'] = $depth + 1;
		
		
		
		// get details of parent item
		$psuccess = $this->flexrest->getItem($parentItem, $pversion, $presponse);
		
		if(!$psuccess)
        {
            $perrdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $p);
            return;
        }
		
		$item_array['parentName'] = $presponse['name'];
		/*
		echo "<pre>";
		print_r($presponse);
		echo "</pre>";
		
		exit;
		*/
		
		}
	
		
		if($this->itemIsIntegrated($this->$xmlwrapper_name))
        {
            $item_array['activityType'] = "group";
        }

		
		$aCtr = 0;
		
		
		
		
		
		
		
		
		$item_array['thisUuid'] = $uuid;
		$item_array['thisVersion'] = $version;

		
		
		
				
		/****************************************************************************/
		
		/* Now find the UUID for this topic                                          */
		
		/****************************************************************************/
		
		
		 
		
		// Search variables
		
		/**/
		
        $q = '';
        $start = 0;
        $length = 1;

        $collections = '6704afea-e88c-4230-b277-6d9d413bfbff';  // The Topic collection
	

        $order = 'name';
        $reverse = false;

       
        $topicwhere = "/xml/item/curriculum/topics/topic/code='".$tcode."'";

        
        $topicwhere = urlencode($topicwhere);
		
		//echo "<br /><br /><br />".urldecode($topicwhere)."<br /><br />";
		
        $info = 'basic';
        $showall = false;

		$searchsuccess = $this->flexrest->search($topic, $q, $collections, $topicwhere, $start, $length, $order, $reverse, $info, $showall);


		
		
		$item_array['topicUUID'] = $topic['results'][0]['uuid'];
		$item_array['topicName'] = $topic['results'][0]['name'];
		
		
		$attachment_array = array();
		
		$aCtr = 0;
		
		foreach ($response['attachments'] as $attachment) {
			
			
			if ($attachment['type'] != 'linked-resource'){
				
				$aCtr++;
				$attachment_array[$aCtr]['title'] = $attachment['description'];
				$attachment_array[$aCtr]['uuid'] = $attachment['uuid'];
				$attachment_array[$aCtr]['filename'] = $attachment['filename'];
				$attachment_array[$aCtr]['thumbnail'] = $attachment['thumbFilename'];
				$attachment_array[$aCtr]['type'] = $attachment['type'];
				
			}
						
	
		}
		
		/*      		
		if ($_SERVER['REMOTE_ADDR'] == '10.30.26.203') {
		
		
		echo "<h2>Item Array</h2>";
		echo "<pre>";
      	print_r($item_array);
		echo "</pre>";
		
		}
		
		*/

		
		
		
		//$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$sam['results'][0]['metadata']), $xmlwrapper_name);
		//$topic = $this->samXml2Array($this->$xmlwrapper_name);
		/* 
	
		
		//exit;
		
		
		      */
		
		
		$data = array('item' => $item_array, 'attachments' => $attachment_array);
		
		/*    
		echo "<pre>";
      	print_r($data);
		echo "</pre>";
		 */
		
		
		$this->load->view('ocf/lta2_item', $data);
		
		

		
		}
	
	
	
	// checks for activity typ of "group"
	
    protected function itemIsIntegrated($itemXml) 
    { 

        $type = '/xml/item/curriculum/activities/activity/@type';
        $itemIsIntegrated = $itemXml->nodeValue($type);
        if(isset($itemIsIntegrated) && $itemIsIntegrated=='group')
            return true;
        return false;
    }
	

  /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function itemXml2Array($itemXml) 
    { 
	
	$tmp['numLinked'] = $itemXml->numNodes('/xml/item/curriculum/activities/act_items/act_item');
	
	
	/*         */     
	for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/act_items/act_item'); $i++) {
	
	$tmp['activities'][$i]['uuid'] = $itemXml->nodeValue('/xml/item/curriculum/activities/act_items/act_item['.$i.']/@sys_id');
	$tmp['activities'][$i]['name'] = $itemXml->nodeValue('/xml/item/curriculum/activities/act_items/act_item['.$i.']/name');
	$tmp['activities'][$i]['docondition'] = $itemXml->nodeValue('/xml/item/curriculum/activities/act_items/act_item['.$i.']/do_condition');
	
	}
	
	
	
		
		// Get activity LOs
		
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/activities/los/lo'); $i++) {
			
			$loSysID = '/xml/item/curriculum/outcomes/activities/los/lo['.$i.']/@sys_id';
            $loName = '/xml/item/curriculum/outcomes/activities/los/lo['.$i.']/name';
            $loCode = '/xml/item/curriculum/outcomes/activities/los/lo['.$i.']/code';
			
			
			$tmp['los']['lo'.$i]['loSysID'] = $itemXml->nodeValue($loSysID);
            $tmp['los']['lo'.$i]['name'] = $itemXml->nodeValue($loName);
			$tmp['los']['lo'.$i]['code'] = $itemXml->nodeValue($loCode);
		
		}

		return $tmp;
	}



    protected function attachmentXml2Array($attachmentXml) 
    { 
	
	
		
		//$tmp['activityTitle'] = $attachmentXml->nodeValue('/xml/item/itembody/name');
		//$tmp['activityDescription'] = $attachmentXml->nodeValue('/xml/item/itembody/description');
		$tmp = $attachmentXml->nodeValue('/xml/item/curriculum/activities/activity/@type');
		//$tmp['itemUUID'] = $attachmentXml->nodeValue('/xml/item/@id');
		//$tmp['itemVersion'] = $attachmentXml->nodeValue('/xml/item/@version');

	
		
		
		

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
    
	 
} 