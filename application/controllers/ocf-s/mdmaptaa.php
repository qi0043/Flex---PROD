<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Mdmaptaa extends CI_Controller {

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
		
		
			$course = array();
		
		
		for ($y=1; $y <= 4; $y++) {
		
		$topicStart = "MMED8";
		$level = $y;
		
		$searchTopic = $topicStart.$level."%";
		
		// Search variables
        $q = '';
        $start = 0;
        $length = 50;

        $collections = '5194ef90-32e1-4d8c-ba14-27dd489c5bf5';

        $order = 'name';
        $reverse = false;

        $where = "/xml/item/curriculum/@item_type='TAA' ";
        $where .= " AND /xml/item/curriculum/courses/course/code='MD' ";
		$where .= " AND /xml/item/curriculum/topics/topic/code LIKE '";
		$where .= $searchTopic;
		$where .= "'";
		
		//echo $where;


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
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }  
		
		if($success)
		{
		
		
		$searchsuccess = $this->flexrest->search($response, $q, $collections, $where, $start, $length, $order, $reverse, $info, $showall);
		
		if(!$searchsuccess)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
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
		
		
		
		$topicCount = intval($response['available']);
		
	
		
		
		//lets start building the array
		
		
        $course[$y]['year'] = $level;
		$course[$y]['numTopics'] = $topicCount;

        ///$topic_array = array();

        
		
		
		for ($i=0; $i < $topicCount; $i++ ) {

            
			
			
			
			
			
			
			
			$j = $i + 1;

            $xmlwrapper_name = 'xmlwrapper'.$j;
			
			
			$course[$y]['topics'][$j]['name'] = $response['results'][$i]['name'];
			

            $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['results'][$i]['metadata']), $xmlwrapper_name);

            $course[$y]['topics'][$j] = $this->Xml2Array($this->$xmlwrapper_name, $y, $j);
			
			
			 //echo "<pre>";
			
			$l = 0 ; 
			
		
			
			
			foreach ($course[$y]['topics'][$j]['linked_activities'] as $linked) {
				
				$l++;
				$linkedUUID = $linked['uuid'];
				
				//echo  $l . " - "  . $linkedUUID ; 
				//echo "<br />";
				
				$a = 0;
				
				foreach ($response['results'][$i]['attachments'] as $attachment) {
					
					$a++ ;
					
					$attachmentUuid = $attachment['uuid'];
					
					if ($attachmentUuid === $linkedUUID ) {
						
						
						
						
						$itemsuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $itemresponse);
						
						$b = 0;
						
						
						if($itemsuccess)  {
							
							// linked item has been found
							/*
							echo "<h2>";
							echo $attachment['description'] . '(results[' . $l . '])';
							echo "</h2>";
							echo "<pre>";
							print_r($itemresponse);
							echo "</pre>";
							*/
							
							$b++;
							
							$xmlwrapper_name = 'xmlwrapper_'.$attachment['itemUuid'];
							
							//echo $xmlwrapper_name . '<br />';
							$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$itemresponse['metadata']), $xmlwrapper_name);
							
							
		
							$course[$y]['topics'][$j]['linked_activities'][$a] = $this->linkedXml2Array($this->$xmlwrapper_name, $y, $j, $a);
							
							$course[$y]['topics'][$j]['linked_activities'][$a]['linked_activities'] = $this->itemXml2Array($this->$xmlwrapper_name, $y, $j, $a);
							
							
							
							foreach ($course[$y]['topics'][$j]['linked_activities'][$a]['linked_activities'] as $linkedactivity) {
								
							
								
								$alinkedUUID = $linkedactivity['uuid'];
								
								//echo $alinkedUUID . ' = ';
								
								$aitem = 0;
								
								foreach ($itemresponse['attachments'] as $attachedItem) {
									
									$aitem++;
									
									$aitemUuid = $attachedItem['uuid'];
									
									if ($aitemUuid === $alinkedUUID ) {
										
										$course[$y]['topics'][$j]['linked_activities'][$a]['linked_activities'][$aitem]['itemUuid'] = $attachedItem['itemUuid'];
										$course[$y]['topics'][$j]['linked_activities'][$a]['linked_activities'][$aitem]['itemVersion'] = $attachedItem['itemVersion'];
										$course[$y]['topics'][$j]['linked_activities'][$a]['linked_activities'][$aitem]['title'] = $attachedItem['description'];
										
									}
									
									
									
									
									
									
								}
								
	
								
							//	echo '<br />';
								
								
							}

						
							
							
						}
						
						$course[$y]['topics'][$j]['linked_activities'][$a]['itemUuid'] = $attachment['itemUuid'];
						$course[$y]['topics'][$j]['linked_activities'][$a]['itemVersion'] = $attachment['itemVersion'];
						$course[$y]['topics'][$j]['linked_activities'][$a]['title'] = $attachment['description'];
						
						
						
					}
					
				}
				
			}
			
			
				/*
			
			*/
			
			
			
			$course[$y]['topics'][$j]['name'] = $response['results'][$i]['name'];
			
	//echo "</pre>";

        }  // end "for" loop
		
		
		}  //  end of success
		
	
	
	
	
	
	
	
	
	
	
	
	}
	
	
	// code to invoke the view to go here
	
	
	/*
		echo "<pre>";
		print_r($course);
		echo "</pre>";
	*/
	
	
	
	
		$data = array('course' => $course);
		
		//$this->load->view('ocf/topicview', $data);
		$this->load->view('ocf/cmap', $data);
	
	

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
	   
	   
	   $tmp['numLinkedActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid'); 
	   
	   
	   	// Put the linked activity uuids into an array
		
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');  $i++) {
			
			$uuid = '/xml/item/curriculum/activities/linked_activities/uuid['.$i.']';
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
	   
	   
	   $tmp['numLinkedActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid'); 
	   
	   
	   	// Put the linked activity uuids into an array
		
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');  $i++) {
			
			//$uuid = '/xml/item/curriculum/activities/linked_activities/uuid['.$i.']';
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
	   
	   

	   //$tmp['numActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');
	   
	   
	   
	   	// Put the linked activity uuids into an array
		
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');  $i++) {
			
			$uuid = '/xml/item/curriculum/activities/linked_activities/uuid['.$i.']';
			$tmp[$i]['uuid'] = $itemXml->nodeValue($uuid);
			
	
	   

		
		}
	
	 
		
	
		
   /**/

        return $tmp;

    }
	
	
	 
} 