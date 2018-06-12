<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Fmgo extends CI_Controller {

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
            $this->load->view('som/showerror_view', $errdata);
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
      


			
			$topicsdata = array();
			$topicsdata['numTopics'] = intval($response['available']);
			
			$topicCount = intval($response['available']);
			
			
			
		
			
			
			
			
			
			$topic_array = array();
			
			
			//$topic_array['numTopics'] = intval($response['available']);
			
			$topicCount = intval($response['available']);
			
			for ($i=0; $i < $topicCount; $i++ ) {
			
			
			$j = $i + 1;
			
			

			
			$xmlwrapper_name = 'xmlwrapper'.$j;

			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['results'][$i]['metadata']), $xmlwrapper_name);
			
		
			$topic_array[$j] = $this->Xml2Array($this->$xmlwrapper_name,$j);
			
			

			$topic_array[$j]['uuid'] = $response['results'][$i]['uuid'];
			$topic_array[$j]['version'] = $response['results'][$i]['version'];
			
			
			
			
			
 
	
				
			}
			


          

			
			
			
			$data = array('topiccount' => $topicsdata, 'topics' => $topic_array );
			
			/*    */
			if ($_SERVER['REMOTE_ADDR'] == '129.96.68.25') {
			
			echo "<pre>";
			print_r($data);
			echo "</pre>";
	
			}
			
			$this->load->view('som/topics_fmgo', $data);
			
			
			


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

	
		#echo "In function #";
		
		
		//echo $itemXml."<br />";
		
		
		$topicCode = '/xml/item/curriculum/info/topic/code';
        $topicTitle = '/xml/item/curriculum/info/topic/name';
		
		
		
        $tmp['code'] = $itemXml->nodeValue($topicCode);
        $tmp['title'] = $itemXml->nodeValue($topicTitle);
		
		
		
		// loop through course objectives
		
		
		 for ($k = 1; $k <= $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo'); $k++) 
		
		{
			
			
			$loCatCode = '/xml/item/curriculum/outcomes/course/los/lo['.$k.']/@cat_code';
            $loCatName = '/xml/item/curriculum/outcomes/course/los/lo['.$k.']/@cat_name';
            $loCode = '/xml/item/curriculum/outcomes/course/los/lo['.$k.']/code';
    

            $tmp['course']['los']['lo'.$k]['catCode'] = $itemXml->nodeValue($loCatCode);
            $tmp['course']['los']['lo'.$k]['catName'] = $itemXml->nodeValue($loCatName);
			$tmp['course']['los']['lo'.$k]['code'] = $itemXml->nodeValue($loCode);
			
			
			$topicAlign = $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo['.$k.']/aligned/topic/los/lo');
			
			
			$tmp['course']['los']['lo'.$k]['numAlign'] = intval($topicAlign);
			
			

			
		}
		
		
		
		#echo '$topic_array[$j]["code"]: ' . $topic_array[$j]['code'] . "<br />" ;
		
	#echo '$itemXml->nodeValue($topicCode): ' . $itemXml->nodeValue($topicCode) . "<br />" ;

        return $tmp;
	
	}

	


	
	
}

/* End of file start.php */
