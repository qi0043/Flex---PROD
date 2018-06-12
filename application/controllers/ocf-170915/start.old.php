<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Start extends CI_Controller {

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
		
		
		// Search variables
		$q = '';
		$start = 0;
		$length = 50;
		
		$collections = '6704afea-e88c-4230-b277-6d9d413bfbff';
		
		
		
		
		$order = 'name';
		$reverse = false;
		
		
		$where = "/xml/item/curriculum/@item_type='Topic Information' ";
		$where .= "AND /xml/item/curriculum/info/course/code='MD'";
		
		
		
		$where = urlencode($where);

		$info = 'metadata';
		$showall = true;
		
		
		/*
		
		echo "<p><strong>Variables passing to search funtion</strong></p>";
		
		echo "q = ".$q."<br />";
		echo "start = ".$start."<br />";
		echo "length = ".$length."<br />";
		echo "collections = ".$collections."<br />";
		echo "order = ".$order."<br />";
		echo "reverse = ".$reverse."<br />";
		echo "where = ".$where."<br />";
		echo "info = ".$info."<br />";
		echo "showall = ".$showall."<br />";
		
		*/
		
	
		
	
		
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
			
			
		 	$searchsuccess = $this->flexrest->search($response, $q, $collections, $where, $start, $length, $order, $reverse, $info, $showall);
			

			
			 if(!$searchsuccess)
        {
            
		
        }
		
		
		if($searchsuccess)
		
        {
      
			
				/*		
			echo "<pre>";
			print_r($response['results']);
			echo "</pre>";
		*/	
			
			
			$topicsdata['numTopics'] = intval($response['available']);
			
			$topicCount = intval($response['available']);
			
			$topic_array = array();
			
			for ($i=0; $i < $topicCount; $i++ ) {
			
			
			$j = $i + 1;
			
			
			
			
			
		/*		
			echo "<pre>";
			print_r($response['results'][$i]['metadata']);
			echo "</pre>";
		*/	
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['results'][$i]['metadata']));
			
		
			$topic_array[$j] = $this->Xml2Array($this->xmlwrapper,$j);
			
			$topic_array[$j]['uuid'] = $response['results'][$i]['uuid'];
			
			
			
			
 
	
				
			}
			



			
			
			echo "<pre>";
			print_r($topic_array);
			echo "</pre>";
			/*
			
			*/
			
			
			$this->load->view('ocf/topics', $topicsdata);
			
			
			


        }
		
			
		}
		

		
		
		
	}
	
	
	    /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
	 
	 
    protected function Xml2Array($itemXml,$j) 
    { 
	
		
		
		//echo $itemXml."<br />";
		
		
		$topicCode = '/xml/item/curriculum/info/topic/code';
        $topicTitle = '/xml/item/curriculum/info/topic/name';
		
		
		
		
		
        $topic_array[$j]['code'] = $itemXml->nodeValue($topicCode);
        $topic_array[$j]['title'] = $itemXml->nodeValue($topicTitle);
		
		echo $topic_array[$j]['code'] ;
		
		
        
	
	}

	
	
	
	
}

/* End of file start.php */