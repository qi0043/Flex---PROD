<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Weeklist extends CI_Controller {

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

	public function index($topiccode)
	{
		
	
	
		//$mystring = "PBL Cases - KHI1A";
		//$myExplode = explode(" - ", $mystring);
		
		//echo $myExplode[0];
		
		//exit;
		
		
		//echo $topiccode;
		
		//exit;
		
		
		// Search variables
        $q = '';
        $start = 0;
        $length = 50;

        $collections = '5194ef90-32e1-4d8c-ba14-27dd489c5bf5';

        $order = 'name';
        $reverse = false;

        $where = "/xml/item/curriculum/@item_type='TAA' ";
        $where .= " AND /xml/item/curriculum/courses/course/code='MD' ";
		$where .= " AND /xml/item/curriculum/topics/topic/code='";
		$where .= $topiccode;
		$where .= "'";
		
		//echo $where;
		
		//echo "<br />";



        $where = urlencode($where);
		
		
		
		//exit;

        $info = 'all';
        $showall = false;
		
	
		
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
		
		
		$searchsuccess = $this->flexrest->search($response, $q, $collections, $where, $start, $length, $order, $reverse, $info, $showall);
		
		if(!$searchsuccess)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('som/showerror_view', $errdata);
            return;
        }
		
		
		
		
		/*       
		echo "<pre>";
		print_r($response);
		echo "</pre>";
		*/
		
		 $xmlwrapper_name = 'xmlwrapper'.$topiccode;
		 
		 $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['results'][0]['metadata']), $xmlwrapper_name);
		 
		 
		 $topic = $this->Xml2Array($this->$xmlwrapper_name);
		 
		 
		 $itemctr = 0;
		 
		 
		 foreach ($topic['act_item'] as $item) {
			 
			 $itemctr++;
			 
			 $itemUUID = $item['uuid'];
			 
			 $aCtr = 0;
			 foreach ($response['results'][0]['attachments'] as $attachment) {
				 
			 	$aUUID = $attachment['uuid'];
				if ($aUUID == $itemUUID) {
					
					//add the item to the array
					
					$topic['act_item'][$itemctr]['itemUuid'] = $attachment['itemUuid'];
					$topic['act_item'][$itemctr]['itemVersion'] = $attachment['itemVersion'];
					$topic['act_item'][$itemctr]['title'] = $attachment['description'];
					
					
					
					
				}
			 
			 
			 }
			 
			 
		 }
		 
		 
		 
		 $topic['availability'] = $response['results'][0]['name'];
		 
		 
		 $topic['tcode'] = substr($response['results'][0]['name'], 0, 8);
		 $topic['dyear'] = substr($response['results'][0]['name'], 9, 4);
		 
		 switch(trim(substr($response['results'][0]['name'], 14, 3))) {
			 
			 
			 case 'HY1':
			 case 'S1':
			 	$topic['semester'] = 1;
				break;
			 
			 case 'HY2':
			 case 'S2':
			 	$topic['semester'] = 2;
				break;
			 
			 
		 }
		
		
		echo "<pre>";
		print_r($topic);
		echo "</pre>";
		
		
		
		$data = array('topic' => $topic);
		
		//$this->load->view('som/topicview', $data);
		$this->load->view('mymedcourse/weeklist', $data);
	
	

	}
 
	}
 
	
	
	
	protected function Xml2Array($itemXml) 
	
    {
       
	
	   $notrequired = array("PBL Cases","Lectures","Practicals");
	   
	   
	   $topicTitle = '/xml/item/curriculum/topics/topic/name';
	   $topicCode = '/xml/item/curriculum/topics/topic/code';
	   $itemType = '/xml/item/curriculum/@item_type';
	   
	   
	   $tmp['title'] = $itemXml->nodeValue($topicTitle);
	   $tmp['code'] = $itemXml->nodeValue($topicCode);
	   $tmp['itemType'] = $itemXml->nodeValue($itemType);
	   
	   
	   //$tmp['numLinkedActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/act_items/act_item'); 
	   
	   //$tmp['numLinkedActivities2'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid'); 
	   
	   
	   	// Put the linked activity uuids into an array
		
		// set counter
		
		$ctr = 0;
		
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/act_items/act_item');  $i++) {
			
			
			$name = '/xml/item/curriculum/activities/act_items/act_item['.$i.']/name';
			
			$item_name = explode(" - ", $itemXml->nodeValue($name));
			
			$item = $item_name[0];
			
			if (!(in_array($item, $notrequired))) {
			
				$ctr++;
				$uuid = '/xml/item/curriculum/activities/act_items/act_item['.$i.']/@sys_id';
				$tmp['act_item'][$i]['uuid'] = $itemXml->nodeValue($uuid);
				
			}

		
		}
		
		$tmp['numLinkedActivities'] = $ctr;
	
	 


        return $tmp;

    }
	
	
	 
  
	
	
	 
} 