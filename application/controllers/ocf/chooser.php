<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chooser extends CI_Controller {

	public function index($taxonomyID = 'missed')
	{
			$errdata['heading'] = "Notice";
			$this->load->helper('url');
			$this->load->library('flexrest/flexrest');
			$this->CI =& get_instance();
	    $this->CI->load->config('flex');

			if(!isset($_SESSION)){session_start();}

			#check down time before authentication through FLEX
			$this->load->model('ocf/ocf_model');

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
				$taxUUID = $this->CI->config->item('ocf_course_code_taxonomy');
				$ocfCourses = $this->flexrest->getTaxonomy($taxUUID, $taxresponse);
				$coursenumber = count($taxresponse) - 1;
				$coursetax = array();

				for ($i = 1; $i <= $coursenumber; $i++)
				{
						$coursetax[$i]['code'] = $taxresponse[$i-1]['term'];
						$ocfCourseTerms = $this->flexrest->getTaxonomyTerm($taxUUID , $taxresponse[$i-1]['uuid'], $termresponse);

						$coursetax[$i]['coursetitle'] = $termresponse['detail'];
				}

				$data = array('courses' => $coursetax);
				$this->load->view('ocf/courseselect', $data);
		}
	}
}
