<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Learningandteaching extends CI_Controller {

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

	public function index($uuid='missed', $version='missed', $tcode='missed', $parent='missed', $pversion='missed')
	{
		
		
		$parentItem = $parent;
		
		#$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";
        
        if($this->validate_params($uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            $this->load->view('som/showerror_view', $errdata);
            return;
        }
		
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		
		$success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('som/showerror_view', $errdata);
            return;
        }    
        
        
		/****************************************************************************/
		
		/* Find the activity information                                               */
		
		/****************************************************************************/
		
		
		$success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = 'error in learning and teaching controller getItem:'.$this->flexrest->error;
            $this->load->view('som/showerror_view', $errdata);
            return;
        }
		

/*
echo "<pre>";
print_r($response);
echo "</pre>";

//exit;
			
*/		

		


			$xmlwrapper_name = 'xmlwrapper'.'lat';
			
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
		
		
		
		
		if(!$this->itemIsIntegrated($this->$xmlwrapper_name))
        {
            $errdata['message'] = "Item is not integrated";
            $this->load->view('som/showerror_view', $errdata);
            return;
        }
		
		
		 
		
		$item_array = $this->itemXml2Array($this->$xmlwrapper_name);
		$item_array['itemTitle'] = $response['name'];
		$item_array['itemDescription'] = $response['description'];
		$item_array['itemTopic'] = $tcode;
		
		if (isset($parentItem) && (($parentItem != '') && ($parentItem != 'missed'))) {
		
		
		$item_array['hasParent'] = 1;
		$item_array['parentItem'] = $parentItem;
		$item_array['parentVersion'] = $pversion;
		
		
		// get details of parent item
		$psuccess = $this->flexrest->getItem($parentItem, $pversion, $presponse);
		
		if(!$psuccess)
        {
            $perrdata['message'] = $this->flexrest->error;
            $this->load->view('som/showerror_view', $p);
            return;
        }
		
		$item_array['parentName'] = $presponse['name'];
		
		//echo "<pre>";
		//print_r($presponse);
		//echo "</pre>";
		
		}
	
		
		if($this->itemIsIntegrated($this->$xmlwrapper_name))
        {
            $item_array['activityType'] = "group";
        }

		
		$aCtr = 0;
		
		
		
		foreach ($response['attachments'] as $activity) 
		
		
		{
			
			if ($activity['@type'] == 'custom' ) {
			
			$aCtr++;
			
			
			$itemsuccess = $this->flexrest->getItem($activity['itemUuid'], $activity['itemVersion'], $itemresponse);
        	if(!$itemsuccess)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('som/showerror_view', $errdata);
            return;
        }
		
			
			
			
			
			$xmlwrapper_name = 'xmlwrapper'.$activity['itemUuid'];
			
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$itemresponse['metadata']), $xmlwrapper_name);
			
			$item_array['activities'][$aCtr] = $this->attachmentXml2Array($this->$xmlwrapper_name);
			
			
			//echo $aCtr;
			
			$item_array['activities'][$aCtr]['itemUUID'] = $itemresponse['uuid'];
			$item_array['activities'][$aCtr]['itemVersion'] = $itemresponse['version'];
			
			/*
			$item_array['activities'][$aCtr]['name'] = $activity['description'];
			$item_array['activities'][$aCtr]['link'] = $activity['itemUuid'];
			$item_array['activities'][$aCtr]['version'] = $activity['itemVersion'];
			$item_array['activities'][$aCtr]['activityType'] = '';
			
			*/
			
			}
			
		}
		
		
		$item_array['thisUuid'] = $uuid;
		$item_array['thisVersion'] = $version;



		if ($_SERVER['REMOTE_ADDR'] == '10.30.26.103') {
	/*     

		echo "<h2>Item Response</h2>";
			
		echo "<pre>";
      	print_r($itemresponse);
		echo "</pre>";
	
	*/		
		echo "<h2>Item Array</h2>";
			
		echo "<pre>";
      	print_r($item_array);
		echo "</pre>";


		
	   
	    //
		
		}
		
		
		
		
				
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
		
		
		//$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$sam['results'][0]['metadata']), $xmlwrapper_name);
		//$topic = $this->samXml2Array($this->$xmlwrapper_name);
		
		
		
		
		$data = array('item' => $item_array);
		
		$this->load->view('som/lta_item', $data);
		
		

		
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
	
	
		
		$tmp['activityTitle'] = $attachmentXml->nodeValue('/xml/item/itembody/name');
		$tmp['activityDescription'] = $attachmentXml->nodeValue('/xml/item/itembody/description');
		$tmp['activityType'] = $attachmentXml->nodeValue('/xml/item/curriculum/activities/activity/@type');
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