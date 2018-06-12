<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Amcgolevel extends CI_Controller {

	public function index($courseId='missed', $level='missed')
	{
		$errdata['heading'] = "Error";
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
		
		$q = '';
		$start = 0;
		$length = 50;
		
		$ci =& get_instance();
		$ci->load->config('flex');
		$collections= $ci->config->item('topic_information_collection'); // The Topic Information collection uuid 

		$order = 'name';
		$reverse = false;
		
		$where = "/xml/item/curriculum/@item_type='Topic Information' ";
		$where .= "AND /xml/item/curriculum/courses/course/code='".strtoupper($courseId)."'";

		$where = urlencode($where);

		$info = 'metadata';
		$showall = true;
		
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
            	$errdata['message'] = $this->flexrest->error;
            	$this->load->view('ocf/showerror_view', $errdata);
           	    return;
        	}
		
		
			if($searchsuccess)
			{
				$topicsdata = array();
				$topicsdata['numTopics'] = intval($response['available']);
				
				$topicCount = intval($response['available']);
				
				$topicsdata['theLevel'] = $level;		
				
				$topic_array = array();
				
				
				//$topic_array['numTopics'] = intval($response['available']);
				
				$topicCount = intval($response['available']);
				
				for ($i=0; $i < $topicCount; $i++ )
				{
					$j = $i + 1;
					$xmlwrapper_name = 'xmlwrapper'.$j;
		
					$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['results'][$i]['metadata']), $xmlwrapper_name);
				
					$topic_array[$j] = $this->Xml2Array($this->$xmlwrapper_name,$j);
	
					$topic_array[$j]['uuid'] = $response['results'][$i]['uuid'];
					$topic_array[$j]['version'] = $response['results'][$i]['version'];
				}
				
				$data = array('topiccount' => $topicsdata, 'topics' => $topic_array );
				$data['courses']['code'] = $courseId;
				$data['courses']['numProfLO']= $topic_array[1]['numProfLOs'];

				
				/*echo "<pre>";
				print_r($data);
				echo "</pre>";*/
				
				
				$this->load->view('ocf/topics_amcgo_level', $data);
			}
		}
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


	 /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function Xml2Array($itemXml,$j) 
    { 

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
		
		// loop through course objectives
		
		
		for ($k = 1; $k <= $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo'); $k++) 
		{
			
			
			$loCatCode = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/@cat_code';
            $loCatName = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/@cat_name';
            $loCode = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/code';
			$loLevel = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/level';

            $tmp['prof']['los']['lo'.$k]['catCode'] = $itemXml->nodeValue($loCatCode);
            $tmp['prof']['los']['lo'.$k]['catName'] = $itemXml->nodeValue($loCatName);
			$tmp['prof']['los']['lo'.$k]['code'] = $itemXml->nodeValue($loCode);
			$tmp['prof']['los']['lo'.$k]['level'] = $itemXml->nodeValue($loLevel);

			$topicAlign = $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/aligned/topic/los/lo');
			
			$tmp['prof']['los']['lo'.$k]['numAlign'] = intval($topicAlign);
			$tmp['numProfLOs'] = $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo');			
		}

        return $tmp;
	
	}

	


	
	
}

/* End of file start.php */
