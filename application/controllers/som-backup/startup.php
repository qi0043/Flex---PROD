<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Startup extends CI_Controller {

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
        $where .= "AND /xml/item/curriculum/courses/course/code='MD' ";
        #$where .= "AND /xml/item/curriculum/outcomes/course/los/lo/code='Know'";
        #              '/xml/item/curriculum/outcomes/course/los/lo['.$k.']/code'

        $where = urlencode($where);

        $info = 'metadata';
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
		
		echo "<pre>";
		print_r($response);
		echo "</pre>";
		
		exit;
		*/
		
		$topicsdata = array();
        $topicsdata['numTopics'] = intval($response['available']);

        $topic_array = array();

        $topicCount = intval($response['available']);
		
		
		for ($i=0; $i < $topicCount; $i++ ) {

            $j = $i + 1;

            $xmlwrapper_name = 'xmlwrapper'.$j;

            $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['results'][$i]['metadata']), $xmlwrapper_name);

            $topic_array[$j] = $this->Xml2Array($this->$xmlwrapper_name, $j);
			
			$topic_array[$j]['uuid'] = $response['results'][$i]['uuid'];
			$topic_array[$j]['version'] = $response['results'][$i]['version'];

        }
		
		
		
		
		$data = array('topiccount' => $topicsdata, 'topics' => $topic_array );
		
		//echo "<pre>";
		//print_r($data);
		//echo "</pre>";
		
		//exit;
 
		
		
		// Load the view	
		
		$this->load->view('som/mdcf', $data);
		
		}
		

		
		
		
	}
	
	
	protected function Xml2Array($itemXml,$j) 
    { 

        
			// loop through related topics
		
		
		//echo "Number of topic in topics: ". $itemXml->numNodes('/xml/item/curriculum/topics/topic') . "<br />";
		
		
        $tmp['code'] = '';
		$tmp['title'] = '';
		
		$ctr = 0; //set a counter
		
		 for ($t = 1; $t <= $itemXml->numNodes('/xml/item/curriculum/topics/topic'); $t++) 
		
		{
		
		$topicCode = '/xml/item/curriculum/topics/topic['.$t.']/code';
        $topicTitle = '/xml/item/curriculum/topics/topic['.$t.']/name';
		
		if ($ctr >= 1) { $tmp['title'] .= ', ';  }
		
        $tmp['code'] .= $itemXml->nodeValue($topicCode);
		$tmp['code'] .= ' ';
        $tmp['title'] .= $itemXml->nodeValue($topicTitle);
		
		
		$ctr++; // increment the counter
		
		
		}
		
		
		


        return $tmp;
	
    }	
	
	
	
	
}

/* End of file startup.php */