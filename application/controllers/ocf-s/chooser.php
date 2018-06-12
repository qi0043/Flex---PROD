<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chooser extends CI_Controller {

	public function index($taxonomyID = 'missed')
	{
		$errdata['heading'] = "Notice";
		$this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		
		
		
		//echo "chooser";
		
		//exit;
		
        $this->load->model('ocf/ocf_model');
		#check down time before authentication through FLEX
		
		/* */
		
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
		
		

			
	//	}
	
		    
		$success = $this->flexrest->processClientCredentialToken();
	
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }  
		
		if($success)
		{
	
	
		
		
		
		// Get OCF Courses from taxonomy
		
		$taxUUID = '45096246-ea34-4268-96d9-269c7479d653';
		$ocfCourses = $this->flexrest->getTaxonomy($taxUUID, $taxresponse);
		
		

			
			//echo "<pre>";
			//echo "TAXONOMY RESPONSE <br />";
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
	
	
		//exit;
		//echo "</pre>";
		
		
		$data = array('courses' => $coursetax);
		
		
		/*      			
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		exit;
		
	*/
		


		// Load the view	
		
		$this->load->view('ocf/courseselect', $data);
		}	
	}
	
	
	

}

/* End of file startup.php */