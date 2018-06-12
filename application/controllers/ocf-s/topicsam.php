<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Topicsam extends CI_Controller {

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
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 
	 
	 	$this->load->view('ocf/topics', $topicsdata);
	 
	 */
	public function index()
	{
		
		#$this->output->enable_profiler(TRUE)
		
	/****************************************************************************/
		
		/* Now find the SAM for this topic                                          */
		
		/****************************************************************************/
		
		
		
		
		// Search variables
        $q = '';
        $start = 0;
        $length = 1;

        $collections = '2fcc59e4-7fbc-4a87-9c84-a94ca4a850e1';  // The SAM collection
	

        $order = 'name';
        $reverse = false;

        $samwhere = "/xml/item/curriculum/@item_type='SAM'";
        $samwhere .= " AND /xml/item/curriculum/topics/topic/code='MMED8102'";
		//$samwhere .= " AND /xml/item/curriculum/assessment/SAMs/linked_topic/uuid='".$itemID."'";
		//$samwhere .= " AND /xml/item/curriculum/assessment/SAMs/linked_topic/version='".$thisVersion."'";
        
        $samwhere = urlencode($samwhere);
		
		//echo "<br /><br /><br />".urldecode($samwhere)."<br /><br />";
		
        $info = 'all';
        $showall = true;


		
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
			//echo "<br /><br />Credentials success<br />";
			
			
		 	$searchsuccess = $this->flexrest->search($sam, $q, $collections, $samwhere, $start, $length, $order, $reverse, $info, $showall);
			
			


			
			 if(!$searchsuccess)
        {
            
		
        }
		
		
		if($searchsuccess)
		
        {
      /*
	
			echo "<pre>";
			print_r($sam);
			echo "</pre>";
		
			
			
		
			
			
			exit;
			
			
			*/
		

			
			
			
		
			
			
			
			
			
			$sam_array = array();
			
			
			//$topic_array['numTopics'] = intval($response['available']);
			
			$topicCount = intval($response['available']);
			


			
			

			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$sam['results'][0]['metadata']));
			
		
			$sam = $this->samXml2Array($this->xmlwrapper);
			

			
			
			
 			echo "<pre>";
			print_r($sam);
			echo "</pre>";
			
			exit;
	
				



          

			
			
			
			$data = array('topiccount' => $topicsdata, 'topics' => $topic_array );
			
			 /*     
			if ($_SERVER['REMOTE_ADDR'] == '129.96.68.25') {
			
			echo "<pre>";
			print_r($data);
			echo "</pre>";
	
			}
			
			exit;
			 */       
			$this->load->view('ocf/topics_fmgo', $data);
			
			
			


        }
		
			
		}
		

		
		
		
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
    protected function samXml2Array($itemXml) 
    {
       $topicVersion = '/xml/item/curriculum/assessment/SAMs/version_definition';
		$tmp['sam']['version'] = $itemXml->nodeValue($topicVersion);
		
     	
			for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo'); $i++) {
				
				$loSysID = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/@sys_id';
            	$loName = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/name';
            	$loCode = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/code';
				
				
				
				
				$tmp['sam']['los']['lo'.$i]['loSysID'] = $itemXml->nodeValue($loSysID);
            	$tmp['sam']['los']['lo'.$i]['name'] = $itemXml->nodeValue($loName);
				$tmp['sam']['los']['lo'.$i]['code'] = $itemXml->nodeValue($loCode);
				
				
			
				
				$numaligned = $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/aligned/a_items/a_item');
				
				$tmp['sam']['los']['lo'.$i]['numAligned'] = $numaligned;
				
				
				for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/aligned/a_items/a_item'); $j++) {
					
					$aItemID = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/aligned/a_items/a_item['.$j.']/@sys_id';
            		$aName = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/aligned/a_items/a_item['.$j.']/name';
					
					
					$tmp['sam']['los']['lo'.$i]['aitem'.$j]['aItemID'] = $itemXml->nodeValue($aItemID);
            		$tmp['sam']['los']['lo'.$i]['aitem'.$j]['aname'] = $itemXml->nodeValue($aName);
            		
					
				}
				
				
			}
		
		

        return $tmp;

    }


	


	
	
}

/* End of file start.php */
