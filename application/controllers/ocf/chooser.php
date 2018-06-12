<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chooser extends CI_Controller {

	public function index($taxonomyID = 'missed')
	{
		$errdata['heading'] = "Notice";
		$this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		
		if(!isset($_SESSION)){session_start();}
		
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
			$errdata['heading'] = "Notice";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			exit;
		}
		
		/****************************************************************************/
		
		/* Find user permissions                                                    */
		
		/****************************************************************************/
		
		$fan = $_SERVER['REMOTE_USER'];
		
		//$fan = "crib0006";
		
		$this->load->library('permission/permission');
       
        if(!$this->permission->success)
        {   
           $errdata['message'] = 'Permission not granted';
			$errdata['heading'] = "Internal error";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			exit();
        }
		
        $permission_array = $this->permission->get_ocf_permission($fan);
		
		
		if(!$this->permission->success)
        {   
           	$errdata['message'] = 'User not in authorised groups';
			$errdata['heading'] = "Internal error";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			exit();
        }
	
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
	
		//exit;
		//echo "</pre>";
		
		/*            		echo "<pre>";
		print_r($groupauth);
		echo "</pre>";
		
		exit;
		*/
		
		
		/*  -----------    
		
		
		if($_SERVER['REMOTE_USER']=='couc0005')  
		{
			echo "permission array: <pre>";
			print_r($permission_array);
			echo "</pre>";
			
			
			echo "session:<pre>";
			print_r($_SESSION);
			echo "</pre>";
			
			echo "courses:<pre>";
			print_r($coursetax);
			echo "</pre>";
			
			
			exit;
		}
*/
		
		$data = array('courses' => $coursetax,'ldapauth' => $groupauth);
		
	

		// Load the view	
		
		$this->load->view('ocf/courseselect', $data);
		}	
	}
	
	
	

}

/* End of file startup.php */
