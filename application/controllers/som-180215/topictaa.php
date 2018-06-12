<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Topictaa extends CI_Controller {

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
	 
	 
	 	$this->load->view('som/topics', $topicsdata);
	 
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

        $collections = '5194ef90-32e1-4d8c-ba14-27dd489c5bf5';  // The TAA collection
	

        $order = 'name';
        $reverse = false;

        $taawhere = "/xml/item/curriculum/@item_type='TAA'";
        $taawhere .= " AND /xml/item/curriculum/topics/topic/code='MMED8102'";

        
        $taawhere = urlencode($taawhere);
		

		
        $info = 'all';
        $showall = true;


		
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
			//echo "<br /><br />Credentials success<br />";
			
			
		 	$searchsuccess = $this->flexrest->search($taa, $q, $collections, $taawhere, $start, $length, $order, $reverse, $info, $showall);
			
			


			
			 if(!$searchsuccess)
        {
            
		
        }
		
		
		if($searchsuccess)
		
        {
     
		 /*	
			echo "<pre>";
			print_r($taa['results'][0]['metadata']);
			echo "</pre>";
		
			
			
		
			
			
			exit;
			
			
	*/
		

			
			
			
		
			
			
			
			
			
			//$taa_array = array();
			
			
			//$topic_array['numTopics'] = intval($response['available']);
			
			//$topicCount = intval($response['available']);
			


			
			

			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$taa['results'][0]['metadata']));
			
		
			$taa_array = $this->taaXml2Array($this->xmlwrapper);
			

			

	
				

			 /*      */  
			
			
			echo "<pre>";
			print_r($taa_array);
			echo "</pre>";
	
	
			
			exit;
			     
			//$this->load->view('som/topics_fmgo', $data);
			
			
			


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
    protected function taaXml2Array($itemXml) 
    {
       $topicVersion = '/xml/item/curriculum/activities/TAA/linked_topic/version';
		$tmp['taa']['version'] = $itemXml->nodeValue($topicVersion);


		
  
			for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo'); $i++) {
				
				$loSysID = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/@sys_id';
            	$loName = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/name';
            	$loCode = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/code';
				
				
				
				
				$tmp['taa']['los']['lo'.$i]['loSysID'] = $itemXml->nodeValue($loSysID);
            	$tmp['taa']['los']['lo'.$i]['name'] = $itemXml->nodeValue($loName);
				$tmp['taa']['los']['lo'.$i]['code'] = $itemXml->nodeValue($loCode);
				
				
			
				
				$numaligned = $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/aligned/act_items/act_item');
				$tmp['taa']['los']['lo'.$i]['numAligned'] = $numaligned;
				

				
				for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/aligned/act_items/act_item'); $j++) {
					
					$aItemID = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/aligned/act_items/act_item['.$j.']/@sys_id';
            		$aName = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/aligned/act_items/act_item['.$j.']/name';
					
					
					$tmp['taa']['los']['lo'.$i]['actitem'.$j]['actItemID'] = $itemXml->nodeValue($aItemID);
            		$tmp['taa']['los']['lo'.$i]['actitem'.$j]['actname'] = $itemXml->nodeValue($aName);
            		
					
				}
				
			/*	*/
			}
		


        return $tmp;

    }


	


	
	
}

/* End of file start.php */
