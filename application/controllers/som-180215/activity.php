<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Activity extends CI_Controller {

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

	public function index($uuid='missed', $version='missed', $taa='missed')
	{
		
		/*
		echo "uuid= " . $uuid . "<br />";
		echo "version= " . $version . "<br />";
		echo "taa= " . $taa . "<br />";
		
		
		exit;
		
		*/
		
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
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('som/showerror_view', $errdata);
            return;
        }
		

			
		$taasuccess = $this->flexrest->getItem($taa, $version, $taaresponse);
        if(!$taasuccess)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('som/showerror_view', $errdata);
            return;
        }
		
	/*
		echo "<h2>TAA Response</h2>";
			
		echo "<pre>";
      	print_r($taaresponse);
		echo "</pre>";

	*/


			$xmlwrapper_name = 'xmlwrapper'.'activity';
			
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
		
		
		

		
		
		if(!$this->itemIsActivity($this->$xmlwrapper_name))
        {
            $errdata['message'] = "Item is not activity";
            $this->load->view('som/showerror_view', $errdata);
            return;
        }
		
		
		 
		
		$item_array = $this->itemXml2Array($this->$xmlwrapper_name);
		
		if($this->itemIsActivity($this->$xmlwrapper_name))
        {
            $item_array['activityType'] = "Activity";
        }
		
		
		
		$tcode = $item_array['itemTopic'];

						
		/****************************************************************************/
		
		/* Now find the UUID for this topic                                          */
		
		/****************************************************************************/
		
		
		 
		
		// Search variables
		
		/*	*/
		
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

		
		
		$item_array['thisUUID'] = $uuid;
		$item_array['thisVersion'] = $version;
		
		$item_array['topicUUID'] = $topic['results'][0]['uuid'];
		$item_array['topicName'] = $topic['results'][0]['name'];
		

		
		
		
		
		
		$item_array['parentTopic'] = $taaresponse['name'];
		$item_array['parentUUID'] = $taaresponse['uuid'];
	
	
	
		
		
		
		
		// related items
		
		$ctr = 0;
		
		
		foreach ($taaresponse['attachments'] as $relatedItem) {
			 $ctr++;
			 
			 $item_array['relatedItem'][$ctr]['title'] = $relatedItem['description'];
			 $item_array['relatedItem'][$ctr]['itemUuid'] = $relatedItem['itemUuid'];
			 $item_array['relatedItem'][$ctr]['sysUuid'] = $relatedItem['uuid'];
			 $item_array['relatedItem'][$ctr]['itemVersion'] = $relatedItem['itemVersion'];
			 
			 if ($uuid == $relatedItem['itemUuid']) {
				 
				 $item_array['sysUUID'] = $item_array['relatedItem'][$ctr]['sysUuid'];
				 
			 }
			
			
			
			
			
		}
		
		
		$sysID = $item_array['sysUUID'];
		
		$wrapper  = 'xmlwrapper'.'lo';
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$taaresponse['metadata']), $wrapper);

		
		
		$lo_array = $this->loXml2Array($this->$wrapper,$sysID);

		



		if ($_SERVER['REMOTE_ADDR'] == '10.26.21.73') {
	
/*
		echo "<h2>Response</h2>";
			
		echo "<pre>";
      	print_r($response);
		echo "</pre>";
			

		echo "<h2>Item Array</h2>";
			
		echo "<pre>";
      	print_r($item_array);
		echo "</pre>";
		

			
		echo "<h2>LO Array</h2>";
			
		echo "<pre>";
      	print_r($lo_array);
		echo "</pre>";
	
	*/
   
	    //
		
		}
		
		

		

		
		
		//$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$sam['results'][0]['metadata']), $xmlwrapper_name);
		//$topic = $this->samXml2Array($this->$xmlwrapper_name);
		
	
		
		
		$data = array('item' => $item_array, 'los' => $lo_array );
		
		$this->load->view('som/activity_item', $data);
		
		

		
		}
	
	
	
	    /**
     * Check whether the item has a type of Topic Information
     *
     * @param xmlwrapper $itemXml
     */
    protected function itemIsActivity($itemXml) 
    { 

        $type = '/xml/item/curriculum/activities/activity/@type';
        $itemIsActivity = $itemXml->nodeValue($type);
        if(isset($itemIsActivity) && $itemIsActivity=='activity')
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
	
	
		$itemTitle = '/xml/item/curriculum/activities/activity/name';
		$itemDescription = '/xml/item/curriculum/activities/activity/description';
		$itemTopic = '/xml/item/curriculum/topics/topic/code';
		
		
		$preInstructions = '/xml/item/curriculum/activities/activity/instructions/pre/description';
		$duringInstructions = '/xml/item/curriculum/activities/activity/instructions/during/description';
		$postInstructions = '/xml/item/curriculum/activities/activity/instructions/post/description';
       

		
		$tmp['itemTitle'] = $itemXml->nodeValue($itemTitle);
		$tmp['itemDescription'] = $itemXml->nodeValue($itemDescription);
		$tmp['itemTopic'] = $itemXml->nodeValue($itemTopic);
		
		$tmp['preInstructions'] = $itemXml->nodeValue($preInstructions);
		$tmp['duringInstructions'] = $itemXml->nodeValue($duringInstructions);
		$tmp['postInstructions'] = $itemXml->nodeValue($postInstructions);
		
		
			
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo'); $i++) {
			
			
			
			/*
			$loSysID = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/@sys_id';
            $loName = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/name';
            $loCode = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/code';
			
			
			$tmp['topic']['los']['lo'.$i]['loSysID'] = $itemXml->nodeValue($loSysID);
            $tmp['topic']['los']['lo'.$i]['name'] = $itemXml->nodeValue($loName);
			$tmp['topic']['los']['lo'.$i]['code'] = $itemXml->nodeValue($loCode);
			
			*/
		
			
		} // end of $i loop
		


		return $tmp;
	}


    protected function loXml2Array($itemXml,$receivedID) 
    { 


		$numApply = 0;

		$tmp2 = array();
		
		
		
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/activities/los/lo'); $i++) {
			
			
			
           $tmp2['numberLOs'] = $itemXml->numNodes('/xml/item/curriculum/outcomes/activities/los/lo') ;

			
			
			$numApply = 0;
			
			
			for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/activities/los/lo['.$i.']/aligned/act_items/act_item'); $j++) {
				
				
				
				$sysID = '/xml/item/curriculum/outcomes/activities/los/lo['.$i.']/aligned/act_items/act_item['.$j.']/@sys_id';
				
				
				
				


				
				if( $receivedID === $itemXml->nodeValue($sysID)) { //The item matches this item
											   
							
				$numApply++;
				
							
					$loName = '/xml/item/curriculum/outcomes/activities/los/lo['.$i.']/name';
            		$loCode = '/xml/item/curriculum/outcomes/activities/los/lo['.$i.']/code';		
					#$taa['los'][$i]['matching'] = "Y";
					
					
					
					$tmp2['los'][$i]['name'] = $itemXml->nodeValue($loName) ;
					$tmp2['los'][$i]['code'] = $itemXml->nodeValue($loCode) ;
					
					
					
					
					#$taa['lo'][$i]['code'] = $itemXml->nodeValue($loCode);					   
											   
				 }
				
				
				$tmp2['numberApplicable'] = $numApply;
			
			}
			
	
			} // end of $i loop



		return $tmp2;

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