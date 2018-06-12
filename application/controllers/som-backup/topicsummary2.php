<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Topicsummary2 extends CI_Controller {

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

	public function index($uuid='missed', $version='missed')
	{
		
		
		
		//echo "topicsummary2.php";
		
		
		//exit;
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
		
		/* Find the topic information                                               */
		
		/****************************************************************************/
		
		
		$success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('som/showerror_view', $errdata);
            return;
        }
		

			
		/****************************************************************************/
		
		/* Get the topic code from the response from the search                      */
		
		/****************************************************************************/	
		
		
		
		$tcode = substr($response['name'],0,8); 
		
		
		$xmlwrapper_name = 'xmlwrapper'.'topic';
		
		
		
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
		
		if(!$this->itemIsTopic($this->$xmlwrapper_name))
        {
            $errdata['message'] = "Item is not a Topic";
            $this->load->view('som/showerror_view', $errdata);
            return;
        }
		

		
		
		
		$topic_array = $this->topicXml2Array($this->$xmlwrapper_name);
		$topic_array['itemID'] = $response['uuid'];
		
		$itemID = $response['uuid'];
		

		
		
		
		
		
		
		
		 
		
		
		
		/****************************************************************************/
		
		/* Now find the SAM for this topic                                          */
		
		/****************************************************************************/
		
		
		 
		
		// Search variables
		
		/**/
		
        $q = '';
        $start = 0;
        $length = 1;

        $collections = '2fcc59e4-7fbc-4a87-9c84-a94ca4a850e1';  // The SAM collection
	

        $order = 'name';
        $reverse = false;

        $samwhere = "/xml/item/curriculum/@item_type='SAM'";
        $samwhere .= " AND /xml/item/curriculum/topics/topic/code='".$tcode."'";

        
        $samwhere = urlencode($samwhere);
		
		#echo "<br /><br /><br />".urldecode($samwhere)."<br /><br />";
		
        $info = 'all';
        $showall = false;

		$searchsuccess = $this->flexrest->search($sam, $q, $collections, $samwhere, $start, $length, $order, $reverse, $info, $showall);

		$xmlwrapper_name = 'xmlwrapper'.'sam';
		
		        
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$sam['results'][0]['metadata']), $xmlwrapper_name);
		$sam_array = $this->samXml2Array($this->$xmlwrapper_name);
		
	

		
        /****************************************************************************/
		
		/* Now find the Topic Availabilities Activities (TAA) for this topic                                          */
		
		/****************************************************************************/
		
		
		 
		
		// Search variables
        
		
		
		
		$q = '';
        $start = 0;
        $length = 1;

        $collections = '5194ef90-32e1-4d8c-ba14-27dd489c5bf5';  // The TAA collection
	

        $order = 'name';
        $reverse = false;

        $taawhere = "/xml/item/curriculum/@item_type='TAA'";
        $taawhere .= " AND /xml/item/curriculum/topics/topic/code='".$tcode."'";

        
        $taawhere = urlencode($taawhere);
		

		
        $info = 'all';
        $showall = true;

		$taasuccess = $this->flexrest->search($taa, $q, $collections, $taawhere, $start, $length, $order, $reverse, $info, $showall);

		//echo "<pre>";
      	//print_r($taa['results'][0]['attachments']);
		//echo "</pre>";
	
		//exit;
		
		$aCtr = 0;
		
		
		$xmlwrapper_name = 'xmlwrapper'.'taa';
		
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$taa['results'][0]['metadata']), $xmlwrapper_name);
		
		$taa_array = $this->numactivitiesXml2Array($this->$xmlwrapper_name);
		
		
		
		
		$xmlwrapper_name = 'xmlwrapper'.'taa_activities';
		
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$taa['results'][0]['metadata']), $xmlwrapper_name);

		$taa_array['activities'] = $this->taaXml2Array($this->$xmlwrapper_name);
		
		
	
		
		
		foreach ($taa_array['activities'] as $linkedactivity) {
			
			$a = 0;
			
			$linkedUUID = $linkedactivity['uuid'];
			
			foreach ($taa['results'][0]['attachments'] as $attachment) {
				
				$a++;
				
				$attachmentUuid = $attachment['uuid'];
				

				if ($attachmentUuid === $linkedUUID ) {
					
					
					$taa_array['activities'][$a]['itemUuid'] = $attachment['itemUuid'];
					$taa_array['activities'][$a]['itemVersion'] = $attachment['itemVersion'];
					
					
					
					$itemsuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $itemresponse);
					
					
						//echo "<pre>";
      					//print_r($itemresponse);
					//	echo "</pre>";
					
					
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
		
		
		
	/*
	
		echo "<h2>TAA data array</h2>";
			
		echo "<pre>";
      	print_r($taa_array);
		echo "</pre>";
		
		exit;
		
 
*/




		
		
	
	

		
		
		$data = array('topics' => $topic_array, 'taa' => $taa_array, 'sam' => $sam_array);
		
		//$this->load->view('som/topicview', $data);
		$this->load->view('som/topicsummary2', $data);
		

		
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
		
		$tmp['newTcode'] = '';
		
		$ctr = 0; //set a counter
		
		 for ($t = 1; $t <= $itemXml->numNodes('/xml/item/curriculum/topics/topic'); $t++) 
		
		{
		
		$topicCode = '/xml/item/curriculum/topics/topic['.$t.']/code';
        $topicTitle = '/xml/item/curriculum/topics/topic['.$t.']/name';
		
		if ($ctr >= 1) { $tmp['topicTitle'] .= ', ';  $tmp['tcode'] .= ' '; }
		
        $tmp['tcode'] .= $itemXml->nodeValue($topicCode);
        $tmp['topicTitle'] .= $itemXml->nodeValue($topicTitle);

		$tcode = $itemXml->nodeValue($topicCode);
		
		$ctr++; // increment the counter
		
		
		}
		
		

		
				
		
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
		
		
        return $tmp;

    }


 /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function samXml2Array($itemXml) 
    {
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

        return $tmp;

    }



 /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function numactivitiesXml2Array($itemXml) 
    {
       
	   
	   
	   $tmp['numLinkedActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_actvities/uuid'); 
	
        return $tmp;

    }



 /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function taaXml2Array($itemXml) 
    {
       
	   
	   
	   //$tmp['numLinkedActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_actvities/uuid'); 
	   
	  for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/linked_actvities/uuid');  $i++) {
		  
		  
		  $uuid = '/xml/item/curriculum/activities/linked_actvities/uuid['.$i.']'; 
		
		  
		  $tmp[$i]['uuid'] = $itemXml->nodeValue($uuid);
		  
	  }

	   
	   
	

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
    
	 
} 