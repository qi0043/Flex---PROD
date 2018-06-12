<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flogc extends CI_Controller {

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

    public function index($view_type=1, $param2='',$param3='', $param4='') 
	{
        if(!isset($_SESSION))
		{
			session_start();
		}
		
        $this->load->helper('url');
        $this->load->library('lti/lti');
        
        #echo "Libraries loaded";
        
        
        #exit;

       if (!($this->lti->authenticate())) {
        	$this->error_info('Your are not authorized to view this page.');
            exit();
        }
        
       
		
		/*     ----------      */
		echo "<pre>";
		echo "POST variables <br />";
		print_r($_POST);
		echo "</pre>";
		
		#exit;
        
        $user_id = $this->input->post('user_id');
		
		
		
        #$role = $this->input->post('roles');
        #$user_id = 63;$role = 'Learner';
       # log_message('debug', 'user flo_id: '.$user_id);
       # log_message('debug', 'REMOTE_ADDR: '.$_SERVER['REMOTE_ADDR']);
		
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
        #log_message('debug', 'user flo roles: ' . $userrole . ', fan: ' . $user['fan']);
        $user['flo_roles'] = $userrole;
        
		if (strpos($userrole, 'Learner') !== false)
        {
            $user['role'] = 'Learner';
			$_SESSION['flo_ocf_role'] = 'Learner';
			$_SESSION['flo_fan'] = $user['fan'];
        }
        else if(strpos($userrole, 'Instructor') !== false)
        {
            $user['role'] = 'Instructor';
			$_SESSION['flo_ocf_role'] = 'Instructor';
			$_SESSION['flo_fan'] = $user['fan'];
        }
        else
        {
            #$user['role'] = 'noauth';
            log_message('error', 'User Not Instructor or Learner to view the activity, role: ' . $userrole . ', fan: ' . $user['fan']);
            #redirect('sam/flosam/noauth');
            $this->error_info('Your role is not authorized to view this page.');
            exit();
        }
		
		
		$_SESSION['userinfo'] = $user;
		
		

	
		
		
		
        #$user['role'] = $this->input->post('roles');

        $flo_site_id = $this->input->post('context_id');
        $topic = $this->input->post('context_label');
        #log_message('debug', 'flo_site_id: ' . $flo_site_id . ', topic: ' . $topic);
        
        
        #Get topic information
        $course_meta = $this->flo->get_course_meta_details((string)$flo_site_id, (string)$user_id);
		
		/* - --- ---        
		echo "<pre>";
		echo "Course Meta";
		print_r($course_meta);
		echo "</pre>";
		
		exit;
		*/
		
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
		
		$ocf_topic_codes = array();
		
		$tmp_topics = array();
		foreach($course_meta['enrolled'] as $enrolled_avail)
		{
			$tmp_avail = $enrolled_avail['shortname'];
			if(strpos($tmp_avail, '_') !== false)
			{
				$tmp_topic_code = substr($tmp_avail, 0, strpos($tmp_avail,"_"));
				array_push($tmp_topics, $tmp_topic_code);
			   // $ocf_topic_codes['enrolled'][$i] = $tmp_topic_code;
			}
		}
		if(count($tmp_topics)>0)
		{
			array_unique($tmp_topics);
			$ocf_topic_codes['enrolled'] = array_values(array_unique($tmp_topics));
			$tmp_topics = array();
		}
	
		
		foreach($course_meta['othertopics'] as $othertopics_avail)
		{
			$tmp_avail = $othertopics_avail['shortname'];
			if(strpos($tmp_avail, '_') !== false)
			{
				$tmp_topic_code = substr($tmp_avail, 0, strpos($tmp_avail,"_"));
				//$ocf_topic_codes['other'][$j] = $tmp_topic_code;
				array_push($tmp_topics, $tmp_topic_code);
			}
		}
		
		if(count($tmp_topics)>0)
		{
			$ocf_topic_codes['other'] = array_values(array_unique($tmp_topics));
			//unset($tmp_topics);
		}
		
		$_SESSION['ocf_topic_codes'] = $ocf_topic_codes;
		
			/*   ----------------------------      */     		

		
		if ($_SESSION['flo_fan'] == 'couc0005') {
		echo "<pre>";
		echo "SESSION VARS <br /><br />";
		print_r($_SESSION);
		echo "</pre>";
		
		#exit;
		
		}
		
		
		exit;
		switch ($view_type){
			case 1:
				//$fwd_url = 'flo-ocf/maptest/getTopics/md';
				$fwd_url = 'flo-ocf/flomap/render/md';
				break;
		   
			case 2:
				$fwd_url = 'flo-ocf/maptopics/' . $param2;  # . '/0';
				break;
		   
		   // Single level activity group
			case 3:
				$fwd_url = 'flo-ocf/ltaflo/' . $param2 . '/1/' . $param4;
				break;
			
			//Single activity
			case 4:
				$fwd_url = 'flo-ocf/activityflo1/' . $param2 . '/1/' . $param2 . '/1/';
				break;
			
			// Learning objectives only
			case 5:
				$fwd_url = 'flo-ocf/losflo/' . $param2 . '/1/' . $param3;
				break;
			
			// Multi-level level activity group
			case 6:
				$fwd_url = 'flo-ocf/ltamlflo/' . $param2 . '/1/' . $param3;
				break;
		}

		
	redirect($fwd_url);
    }        
    
   
    
}


/* End of file flosom.php */
/* Location: ./application/controllers/flosam.php */
