<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Startup extends CI_Controller {

	public function index($courseId = 'missed')
	{
		$errdata['heading'] = "Notice";
		$this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		
		if(!$this -> validate_params($courseId))
		{
			$errdata['message'] = 'Invalid course code';
            $this->load->view('ocf/showerror_view', $errdata);
            return;
		}
	
		$this->load->model('ocf/ocf_model');
            
		#check down time before authentication through FLEX
		$down_notice = false;
		$down_notice = $this->ocf_model->db_chk_notice();
		if($down_notice != false)
		{
			#$this->error_info($down_notice['message']);
			if ($down_notice['message'] == '')
				$down_notice['message'] = 'Online Curriculum Framework is temporarily unavailable, please try again later.';
			#echo $down_notice['message'];
			$errdata['message'] = $down_notice['message'];
			//$errdata['heading'] = "Notice";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			return;
		}
		#check course code
		$check_course_code = $this->ocf_model->db_get_courseInfo(strtoupper($courseId));
		if(!$check_course_code)
		{
			$errdata['message'] = 'course code not valid';
			$this->load->view('ocf/showerror_view', $errdata);
			return;
			
		}
		
		
		// Get OCF Courses from taxonomy
		
		$taxUUID = '45096246-ea34-4268-96d9-269c7479d653';
		$ocfCourses = $this->flexrest->getTaxonomy($taxUUID, $taxresponse);
		
		
	//	if ($_SERVER['REMOTE_USER'] == 'couc0005') {
			
			//echo "<pre>";
			//print_r($taxresponse);
			
			$coursenumber = count($taxresponse) - 1;
			//echo $coursenumber . "<br />";
			
			$coursetax = array();
			
			for ($i = 1; $i <= $coursenumber; $i++) {
				
				
				//echo $i . "<br />";
				//echo $taxresponse[$i-1]['term'] . " " . $taxresponse[$i-1]['uuid'] . "<br />";
				
				$coursetax[$i]['code'] = $taxresponse[$i-1]['term'];
				$ocfCourseTerms = $this->flexrest->getTaxonomyTerm($taxUUID , $taxresponse[$i-1]['uuid'], $termresponse);
				
				$coursetax[$i]['coursetitle'] = $termresponse['detail'];
	
				//print_r($termresponse);
				
			}
		
		
		//print_r($coursetax);
		
		//	echo "</pre>";
			
		//	exit;
			
	//	}
		
		
		
		// Search variables
        $q = '';
        $start = 0;
        $length = 50;
		
        //Topic Information Collection Uuid
		$ci =& get_instance();
		$ci->load->config('flex');
		$collections = $ci->config->item('topic_information_collection');

        $order = 'name';
        $reverse = false;

        $where = "/xml/item/curriculum/@item_type='Topic Information' ";
        $where .= "AND /xml/item/curriculum/courses/course/code='" . strtoupper($courseId) . "' ";

        $where = urlencode($where);

        $info = 'metadata';
        $showall = false;
		
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

			/*echo "<pre>";
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

		$course_array['code'] = $courseId;
		
	
	// Get OCF Courses from taxonomy
		
		$taxUUID = '45096246-ea34-4268-96d9-269c7479d653';
		$ocfCourses = $this->flexrest->getTaxonomy($taxUUID, $taxresponse);
		
		
	//	if ($_SERVER['REMOTE_USER'] == 'couc0005') {
			
			//echo "<pre>";
			//print_r($taxresponse);
			
			$coursenumber = count($taxresponse) - 1;
			//echo $coursenumber . "<br />";
			
			$coursetax = array();
			
			for ($i = 1; $i <= $coursenumber; $i++) {
				
				
				//echo $i . "<br />";
				//echo $taxresponse[$i-1]['term'] . " " . $taxresponse[$i-1]['uuid'] . "<br />";
				
				$coursetax[$i]['code'] = $taxresponse[$i-1]['term'];
				$ocfCourseTerms = $this->flexrest->getTaxonomyTerm($taxUUID , $taxresponse[$i-1]['uuid'], $termresponse);
				
				$coursetax[$i]['coursetitle'] = $termresponse['detail'];
	
				//print_r($termresponse);
				
			}
	
	
	
		
		$data = array('topiccount' => $topicsdata, 'topics' => $topic_array, 'courses' => $course_array, 'ocfcourses' => $coursetax);
		$data['courseCode'] = $courseId;
		
		
		
		
		/*echo "<pre>";
		print_r($data);
		echo "</pre>";
		exit;*/

		// Load the view	
		
		$this->load->view('ocf/mdcf', $data);
		}	
	}
	
	
	private function Xml2Array($itemXml,$j) 
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
	
	/**
     * Validate incoming parameters
     *
     * @param string $coursecode
     */
    private function validate_params($courseCode)
    {

        if(strcmp($courseCode, 'missed')==0 ||is_numeric($courseCode) )
		{
            return false;
		}
        return true;
    }

}

/* End of file startup.php */