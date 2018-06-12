<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Mymedcourse extends CI_Controller {

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

	public function index($uuid='missed', $version='missed', $topiccode='missed')
	{
		
	
	
		
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
		
		echo $where;
		
		echo "<br />";



        $where = urlencode($where);
		
		
		
		exit;

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
		echo $_SERVER['REMOTE_USER'];
		echo "</pre>";
		 */
		//echo "<pre>";
		//print_r($response);
		//echo "</pre>";
		
		//exit;
		
		
		

	
	
	
	
		//$data = array('course' => $course);
		
		//$this->load->view('som/topicview', $data);
		//$this->load->view('som/cmap', $data);
	
	

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
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
	 
	 
       /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
	 
	 
	 
    protected function Xml2Array($itemXml, $y, $j) 
	
    {
       
	
	   $topicTitle = '/xml/item/curriculum/topics/topic/name';
	   $topicCode = '/xml/item/curriculum/topics/topic/code';
	   $activityType = '/xml/item/curriculum/activities/activity/@type';
	   
	   
	   $tmp['title'] = $itemXml->nodeValue($topicTitle);
	   $tmp['code'] = $itemXml->nodeValue($topicCode);
	   $tmp['activityType'] = $itemXml->nodeValue($activityType);
	   
	   
	   $tmp['numLinkedActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_actvities/uuid'); 
	   
	   
	   	// Put the linked activity uuids into an array
		
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/linked_actvities/uuid');  $i++) {
			
			$uuid = '/xml/item/curriculum/activities/linked_actvities/uuid['.$i.']';
			$tmp['linked_activities'][$i]['uuid'] = $itemXml->nodeValue($uuid);

		
		}
	
	 
		
	
		
   /**/

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
	 
	 
	 
    protected function linkedXml2Array($itemXml, $y, $j) 
	
    {
       
	
	
	
	   $activityType = '/xml/item/curriculum/activities/activity/@type';
	   
	   
	
	   $tmp['activityType'] = $itemXml->nodeValue($activityType);
	   
	   
	   $tmp['numLinkedActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_actvities/uuid'); 
	   
	   
	   	// Put the linked activity uuids into an array
		
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/linked_actvities/uuid');  $i++) {
			
			//$uuid = '/xml/item/curriculum/activities/linked_actvities/uuid['.$i.']';
			//$tmp['linked_activities'][$i]['uuid'] = $itemXml->nodeValue($uuid);

		
		}
	
	 
		
	
		
   /**/

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
	 
	 
	 
    protected function itemXml2Array($itemXml, $y, $j, $a) 
	
    {
       
	
	
	  // $activityType = '/xml/item/curriculum/activities/activity/@type';
	   
	   

	   //$tmp['numActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_actvities/uuid');
	   
	   
	   
	   	// Put the linked activity uuids into an array
		
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/linked_actvities/uuid');  $i++) {
			
			$uuid = '/xml/item/curriculum/activities/linked_actvities/uuid['.$i.']';
			$tmp[$i]['uuid'] = $itemXml->nodeValue($uuid);
			
	
	   

		
		}
	
	 
		
	
		
   /**/

        return $tmp;

    }
	
	
	 
} 