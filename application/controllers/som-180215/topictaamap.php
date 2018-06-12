<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Topictaamap extends CI_Controller {

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
		
		$uuid = 'a150992f-217e-4a25-9fea-362819182eee';
		
		$version = 1;
		
		
		echo $uuid . " / Version " . $version . "<br />";
		
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
        
        $success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('som/showerror_view', $errdata);
            return;
        }
		

		/* 
	     
		echo "<pre>";
		print_r($response);
		echo "</pre>";
		
		exit;
		
		 	*/
		
		
		$xmlwrapper_name = 'xmlwrapper'.'taa';
		
		
		
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
		
		
		//$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
		
		
		
		
		
		/*      */
		
		
		if(!$this->itemIsTaa($this->$xmlwrapper_name))
        {
            $errdata['message'] = "Item is not a TAA";
            $this->load->view('som/showerror_view', $errdata);
            return;
        }
		
		
		
		
		
		
		
		
		
		 $taa_array = $this->taaXml2Array($this->$xmlwrapper_name);
		 
		 
	        echo "<pre>";
			
			$i = 0;
			
			foreach ($taa_array['linked_activities'] as $linked) {
				
				$i++;
				
				
				$linkedUUID = $linked['uuid'];
				//echo  $i . " - "  . $linkedUUID ; 
				
				
				$j = 0;
				
				
				
				foreach ($response['attachments'] as $attachment) {
				
				$j++;
				
				$attachmentUuid = $attachment['uuid'];
				
				
				if ($attachmentUuid === $linkedUUID ) {
					
					//echo  " :: " . $j . " - " . $attachmentUuid; 
					
					//echo  " itemUuid - " . $attachment['itemUuid'];
					
					$taa_array['linked_activities'][$i]['itemUuid'] = $attachment['itemUuid'];
					$taa_array['linked_activities'][$i]['itemVersion'] = $attachment['itemVersion'];
					$taa_array['linked_activities'][$i]['title'] = $attachment['description'];
					
					$linksuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $linked);
					
					
					print_r($linked);
					
					
					
					
				}
				
				
				
	
	}
	
	    /*            */
				
			//echo "<br />";
	
	
	}
			
			
			echo "</pre>";
	
		 
		 
		 
		 
		 
		 
		 
	
		 	echo "<pre>";
			print_r($taa_array);
			echo "</pre>";
	
		 /*	 */
		 
		 
		 //$activityCounter = 0;
		 
		 
		 /*
		 
		 foreach ($response['attachments'] as $attachment)  {
			 
			 $activityCounter++;
			 
			// echo "Attachment " . $activityCounter . "uuid = ";
			 
			 
			 //echo $attachment['uuid'] . "  ::  ";
			 
			//echo "TAA array uuid = " . $taa_array['activities']['activity'][$activityCounter]['uuid'];
			/*
			if ($attachment['uuid'] === $taa_array['activities']['activity'][$activityCounter]['uuid']) 
			
				{  
				
					$taa_array['activities']['activity'][$activityCounter]['linkeduuid'] = $attachment['itemUuid'];
					$taa_array['activities']['activity'][$activityCounter]['version'] = $attachment['itemVersion'];
					
					
					
					
					$getlinked = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $linkedItem);
					

				
				
				}
			 
			 */
			 
		 }
		
		
	

		
		
	
	    /**
     * Check whether the item has a type of TAA
     *
     * @param xmlwrapper $itemXml
     */
    protected function itemIsTaa($itemXml) 
    { 

        $type = '/xml/item/curriculum/@item_type';
        $itemIsTaa = $itemXml->nodeValue($type);
        if(isset($itemIsTaa) && $itemIsTaa==='TAA')
            return true;
        return false;
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
	 
	 
	 
    protected function taaXml2Array($itemXml) 
	
    {
       
	
	   $topicTitle = '/xml/item/curriculum/topics/topic/name';
	   
	   
	   $tmp['topicTitle'] = $itemXml->nodeValue($topicTitle);
	   
	   
	   
	 $tmp['numLinked'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid'); 
	 
	 	
		// Put the linked activity uuids into an array
		
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');  $i++) {
			
			$uuid = '/xml/item/curriculum/activities/linked_activities/uuid['.$i.']';

			
			
			$tmp['linked_activities'][$i]['uuid'] = $itemXml->nodeValue($uuid);

		
		}

	 
		
	
		
   /**/

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