<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Weekview extends CI_Controller {

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

	public function index($uuid='missed', $version='missed', $tcode='missed')
	{
		
	
	
	
		//echo "uuid = " . $uuid . "<br />";
		//echo "version = " . $version . "<br />";
		//echo "tcode = " . $tcode . "<br />";
		
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
		
		if($success)
		{
		
		//echo "Success!<br />";
	
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
		
		
		//echo "Item got!<br />";
		
		/*           
		echo "<pre>";
		print_r($response);
		echo "</pre>";
		*/
	

		$xmlwrapper_name = 'xmlwrapper'.'group';
			
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
		
		/*
		if(!$this->itemIsGroup($this->$xmlwrapper_name))
        {
            $errdata['message'] = "Item is not group";
            $this->load->view('som/showerror_view', $errdata);
            return;
        }
		*/
		
		
		$week = array();
		
	
	
		
		$week= $this->Xml2Array($this->$xmlwrapper_name);
		
		 
		 
		 $itemctr = 0;
		 $casectr = 0;
		 $lecturectr = 0;
		 $practicalctr = 0;
		 $otherctr = 0;
		 
		 
		 
		 foreach ($week['act_item'] as $activity) {
			 
			 
			 
			 $itemctr++;
			 
			 $itemUUID = $activity['uuid'];
			 
			// echo $itemUUID . " - ";
			 
			 $aCtr = 0;
			 foreach ($response['attachments'] as $attachment) {
				 
			 	$aUUID = $attachment['uuid'];
				
				//echo $aUUID . "<br />";
				
				
				
				
				if ($aUUID == $itemUUID) {
					
					
					
					$success = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $itemresponse);
					
					//add the item to the array
					
					//$week['act_item'][$itemctr]['itemUuid'] = $attachment['itemUuid'];
					//$week['act_item'][$itemctr]['itemVersion'] = $attachment['itemVersion'];
					//$week['act_item'][$itemctr]['title'] = $attachment['description'];
					
					
					
					
					
					/*
						echo "<pre>";
						print_r($itemresponse);
						echo "</pre>";
					
					*/
					
					$xmlwrapper_name = 'xmlwrapper_'.$attachment['itemUuid'];
					
					$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$itemresponse['metadata']), $xmlwrapper_name);
					
					$week['act_item'][$itemctr]['type'] = $this->itemXml2Array($this->$xmlwrapper_name);
					
					//echo "Item " . $itemctr . " = " . $week['act_item'][$itemctr]['type'] . "<br / >";
					
					
						$week['act_item'][$itemctr]['title'] = $attachment['description'];
						$week['act_item'][$itemctr]['itemUuid'] = $attachment['itemUuid'];
					    $week['act_item'][$itemctr]['itemVersion'] = $attachment['itemVersion'];
					
					
					
				
				
				}
			 
			 
			 }
			 
			 
		 }
		
		$week['cases'] = array();
		$week['lectures'] = array();
		$week['practicals'] = array();
		$week['other'] = array();
		
		
		 $itemctr = 0;
		 $casectr = 0;
		 $lecturectr = 0;
		 $practicalctr = 0;
		 $otherctr = 0;
		
	
	 foreach ($week['act_item'] as $item) {
			 
			 
	
					switch (trim($item['type'])) {
						
						case "Problem Based Learning":
						
						$casectr++;
						//echo $casectr . "<br />";
						
						//$week['cases'][$casectr]['title'] = "Test";
						$week['cases'][$casectr]['title'] = $item['title'];
						$week['cases'][$casectr]['itemUuid'] = $item['itemUuid'];
					    $week['cases'][$casectr]['itemVersion'] = $item['itemVersion'];
						break;
						
						
						case "Lecture":
						
						$lecturectr++;
						//echo $casectr . "<br />";
						
						//$week['cases'][$casectr]['title'] = "Test";
						$week['lectures'][$lecturectr]['title'] = $item['title'];
						$week['lectures'][$lecturectr]['itemUuid'] = $item['itemUuid'];
					    $week['lectures'][$lecturectr]['itemVersion'] = $item['itemVersion'];
						break;
					
						case "Practical":
						
						$practicalctr++;
						//echo $casectr . "<br />";
						
						//$week['cases'][$casectr]['title'] = "Test";
						$week['practicals'][$practicalctr]['title'] = $item['title'];
						$week['practicals'][$practicalctr]['itemUuid'] = $item['itemUuid'];
					    $week['practicals'][$practicalctr]['itemVersion'] = $item['itemVersion'];
						break;
						
						
						default:
						
						$otherctr++;
						//echo $casectr . "<br />";
						
						//$week['cases'][$casectr]['title'] = "Test";
						$week['other'][$otherctr]['title'] = $item['title'];
						$week['other'][$otherctr]['itemUuid'] = $item['itemUuid'];
					    $week['other'][$otherctr]['itemVersion'] = $item['itemVersion'];
						break;
						
						
					} 
				
					
	
			 
			 
		 }
		
		
		echo "<pre>";
		print_r($week);
		echo "</pre>";

		
		
		$data = array('week' => $week);
		
		//$this->load->view('som/topicview', $data);
		//$this->load->view('mymedcourse/weekview', $data);
	
	

	}
 
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
     * Check whether the item has a type of Topic Information
     *
     * @param xmlwrapper $itemXml
     */
    protected function itemIsGroup($itemXml) 
    { 

        $type = '/xml/item/curriculum/activities/activity/@type';
        $itemIsGroup = $itemXml->nodeValue($type);
        if(isset($itemIsGroup) && $itemIsGroup=='group')
            return true;
        return false;
    }
	
	
	
	
	protected function Xml2Array($itemXml) 
	
    {
       
	  // echo "In function Xml2Array". "<br />";
	   
	   
	   $topicTitle = '/xml/item/curriculum/activities/activity/name';
	   $topicCode = '/xml/item/curriculum/topics/topic/code';
	   $itemType = '/xml/item/curriculum/activities/activity/@type';
	   
	   
	   $tmp['title'] = $itemXml->nodeValue($topicTitle);
	   $tmp['code'] = $itemXml->nodeValue($topicCode);
	   $tmp['itemType'] = $itemXml->nodeValue($itemType);
	   
	
	 $ctr = 0;
		
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/act_items/act_item');  $i++) {
			
			
			$name = '/xml/item/curriculum/activities/act_items/act_item['.$i.']/name';
			
	
				$ctr++;
				$uuid = '/xml/item/curriculum/activities/act_items/act_item['.$i.']/@sys_id';
				$tmp['act_item'][$i]['uuid'] = $itemXml->nodeValue($uuid);
				
			

		
		}
		
		$tmp['numLinkedActivities'] = $ctr;
	
	 


        return $tmp;

    }
	
	    protected function itemXml2Array($itemXml) 
	
    {
       
	
	
	   	 $activityType = '/xml/item/curriculum/activities/activity/teaching_type';
		
		 
		 
		 $tmp = $itemXml->nodeValue($activityType);

	   

		
	
	

        return $tmp;

    }
	 
  
	
	
	 
} 