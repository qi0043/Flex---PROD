<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flosom extends CI_Controller {

    /**
     * Entry point from FLO to view SOM
     * 
     * Perform LTI authentication
     * Check User Flo role
     * Search for SAM in FLEX based on topic availability
     *
     */


    //
    // Show error information
    //
    public function error_info($error_info) {
        $data['page_title'] = 'Error';
        $data['view'] = 'sam/flo/error_info';
        $data['error_info'] = $error_info;
        $this->load->view('sam/flo/layout', $data);
        $this->output->_display();
        #exit();
    }
    
    //
    // Get SAM pdf attachment uuid

    


    /**
     * Entry point from FLO to view SAM
     * 
     * Perform LTI authentication
     * Check User Flo role
     * Search for SAM in FLEX based on topic availability
     *
     */

    public function index($view_type=1, $param2='',$param3='') {
        
        #session_start();
        $this->load->helper('url');
        $this->load->library('lti/lti');

        if (!$this->lti->authenticate()) {
        	$this->error_info('Your are not authorized to view this page.');
                exit();
        }

        
        $user_id = $this->input->post('user_id');
        #$role = $this->input->post('roles');
        #$user_id = 63;$role = 'Learner';
        log_message('debug', 'user flo_id: '.$user_id);
        log_message('debug', 'REMOTE_ADDR: '.$_SERVER['REMOTE_ADDR']);
        $this->load->library('flo/flo');
        
        $flouser = $this->flo->fetch_user_info($user_id);
        if($flouser === false)
        {
            
            log_message('error', 'Error getting user info (fetch_user_info) for user id: ' . $user_id);
            #redirect('flosam/error_info');
            $this->error_info('Error in getting user data.');
            #$data['page_title'] = 'Error';
            #$data['view'] = 'pages/error_info';
            #$data['error_info'] = 'User data error';
            #$this->load->view('layout', $data);
            exit();
        }
		
        $user['fan'] = $flouser[0]['username'];
        $user['name'] = $flouser[0]['fullname'];
        $user['email'] = $flouser[0]['email'];
        
        $user['flo_id'] = $user_id;
        
        $userrole = $this->input->post('roles');
        log_message('debug', 'user flo roles: ' . $userrole . ', fan: ' . $user['fan']);
        $user['flo_roles'] = $userrole;
        
        if (strpos($userrole, 'Learner') !== false)
        {
            $user['role'] = 'Learner';
        }
        else if (strpos($userrole, 'Instructor') !== false)
        {
            $user['role'] = 'Instructor';
        }
        else
        {
            #$user['role'] = 'noauth';
            log_message('error', 'User Not Instructor or Learner to view the SAM, role: ' . $userrole . ', fan: ' . $user['fan']);
            #redirect('sam/flosam/noauth');
            $this->error_info('Your role is not authorized to view this page.');
            exit();
        }

        #$user['role'] = $this->input->post('roles');

        $flo_site_id = $this->input->post('context_id');
        $topic = $this->input->post('context_label');
        log_message('debug', 'flo_site_id: ' . $flo_site_id . ', topic: ' . $topic);
        
        
        #Get topic information
        $course_meta = $this->flo->get_course_meta_details((string)$flo_site_id, (string)$user_id);
        if($course_meta === false)
        {
            
            log_message('error', 'Error getting course info (get_course_meta_details) for user id: ' . $user_id . ', flo site id: ' . $flo_site_id);
            #redirect('welcome/error_info');
            $this->error_info('Internal error, please try again later.');
            #$data['page_title'] = 'Error';
            #$data['view'] = 'pages/error_info';
            #$data['error_info'] = 'User data error';
            #$this->load->view('layout', $data);
            exit();
        }
        #echo '<pre>333'; print_r($course_meta);echo '</pre>444';exit();
        
        if(isset($course_meta['errors'][0]['errorcode']) && $course_meta['errors'][0]['errorcode'] == 'NOSUCHCOURSE')
        {
            log_message('error', 'Error (NOSUCHCOURSE) getting course info (get_course_meta_details) for user id: ' . $user_id . ', flo site id: ' . $flo_site_id);
            $this->error_info('User/course data error.');
            exit();
        }
        
        if(isset($course_meta['errors'][0]['errorcode']) && $course_meta['errors'][0]['errorcode'] == 'NOMETALINKS')
        {
            $course_meta['enrolled'][0]['courseid'] = $flo_site_id;
            $course_meta['enrolled'][0]['shortname'] = $topic;
            $course_meta['othertopics'] = array();
            unset($course_meta['errors']);
        }
        
        $num_enrolled = count($course_meta['enrolled']);
        $num_othertopics = count($course_meta['othertopics']);

	switch ($view_type){
	    case 1:
	        $fwd_url = 'ocf/maptest/getTopics/md';
	        break;
	    case 2:
		$fwd_url = 'ocf/maptopics/' . $param2;  # . '/0';
		break;
            case 3:
		$fwd_url = 'ocf/ltaflo/' . $param2 . '/1/' . $param3;
                break;
            case 4:
		$fwd_url = 'ocf/activityflo/' . $param2 . '/1/' . $param3;
		break;
	}

	
	
	redirect($fwd_url);
    }        
    
    
    /**
     * Validate incoming parameters
     *
     * @param array $uuid, item UUID
     * @param array $version, item Version
     * @param array $file_uuid, attachment file UUID
     */
    protected function validate_params($uuid='missed', $version='missed', $file_uuid='missed')
    {

        if(strcmp($uuid, 'missed')==0 || strlen($uuid) != 36)
            return false;
        
        if(strcmp($version, 'missed')==0 || !is_numeric($version))
            return false;
        
        if(strcmp($uuid, 'missed')==0 || strlen($uuid) != 36)
            return false;
        
        return true;
    }
    
}


/* End of file flosom.php */
/* Location: ./application/controllers/flosam.php */
