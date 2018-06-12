<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Floreadings extends CI_Controller {


    /*public function __construct()
    {
        parent::__construct();
	$this->load->helper('url');
	if (session_id() == '')
        {
	    session_start();
	}
    }*/
    
	

    /**
     * Entry point from FLO to view eReadings
     * 
     * Perform LTI authentication
     * Check User Flo role
     * Search for eReadings in database based on topic availability
     *
     */

    public function index() {
        
        #session_start();
        $this->load->helper('url');
        $this->load->library('lti/lti');
	
        if (!$this->lti->authenticate()) {
        	$this->error_info('Your are not authorized to view this page.');
                exit();
        }
	
	if (session_id() == '')
        {
	    session_start();
	}
        #echo 'good'; return;
        #Check system down time.
	$this->load->model('reading_listmgr/floreadings_model');
        #$this->load->model('reading_listmgr/listmgr_model');
        $down_notice = false;
        $down_notice = $this->floreadings_model->db_chk_notice();
        if($down_notice != false)
        {
            #$this->error_info($down_notice['message']);
            if ($down_notice['message'] == '')
                $down_notice['message'] = 'eReadings are temporarily unavailable, please try again later.';
            
        }
        
        $user_id = $this->input->post('user_id');
        #$role = $this->input->post('roles');
        #$user_id = 63;$role = 'Learner';
        log_message('debug', 'user flo_id: '.$user_id);
        log_message('debug', 'REMOTE_ADDR: '.$_SERVER['REMOTE_ADDR']);
        $this->load->library('flo/flo');
        
        $flouser = $this->flo->fetch_user_info($user_id);
	#echo  $user_id;
	#echo '<pre>';print_r($flouser);echo '</pre>';exit();
        if($flouser === false || empty($flouser))
        {
            
            log_message('error', 'Error getting user info (fetch_user_info) for user id: ' . $user_id);
            #redirect('flosam/error_info');
            $this->error_info('Failed to get user information.');
            #$data['page_title'] = 'Error';
            #$data['view'] = 'pages/error_info';
            #$data['error_info'] = 'User data error';
            #$this->load->view('layout', $data);
            exit();
        }
		
        $user['fan'] = $flouser[0]['username'];
        #$user['name'] = $flouser[0]['fullname'];
        #$user['email'] = $flouser[0]['email'];
        
        $user['flo_id'] = $user_id;
        
        $userrole = $this->input->post('roles');
        log_message('debug', 'user flo roles: ' . $userrole . ', fan: ' . $user['fan']);
        #$user['flo_roles'] = $userrole;
        
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
            log_message('error', 'User Not Instructor or Learner to view the eReading from FLO, role: ' . $userrole . ', fan: ' . $user['fan']);
            #redirect('sam/flosam/noauth');
            $this->error_info('Your role is not authorized to view this page.');
            exit();
        }

	#$user['role'] = 'Learner';
        #$user['role'] = $this->input->post('roles');

        $flo_site_id = $this->input->post('context_id');
        $topic = $this->input->post('context_label');
        log_message('debug', 'flo_site_id: ' . $flo_site_id . ', topic: ' . $topic);
        
        $_SESSION['floreading_user_fan'] = $user['fan'];
	#log_message('error', 'user_fan: ' . $_SESSION['user_fan']);
        #$this->load->library('flo/flo');
        #$flo_site_id = 6; $user_id = 6;
        #$flo_site_id = 5; $user_id = 4;
        #$flo_site_id = 10; $user_id = 5;
        
        #Get topic information
        $course_meta = $this->flo->get_course_meta_details((string)$flo_site_id, (string)$user_id);
        if($course_meta === false)
        {
            
            log_message('error', 'Error getting course info (get_course_meta_details) for user id: ' . $user_id . ', flo site id: ' . $flo_site_id);
            #redirect('welcome/error_info');
            $this->error_info('Internal error, failed to get course information, please try again later.');
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
            $this->error_info('User or course data error.');
            exit();
        }
        
        if(isset($course_meta['errors'][0]['errorcode']) && $course_meta['errors'][0]['errorcode'] == 'NOMETALINKS')
        {
	    
            $course_meta['enrolled'][0]['courseid'] = $flo_site_id;
            $course_meta['enrolled'][0]['shortname'] = $topic;
            $course_meta['othertopics'] = array();
            unset($course_meta['errors']);
        }
        
        $enrolled_num = count($course_meta['enrolled']);
        $othertopics_num = count($course_meta['othertopics']);
	
	#$course_meta['user_fan'] = $user['fan'];
	$course_meta['user_role'] = $user['role'];
	$include_pend_inact = false;
	if($course_meta['user_role'] == 'Instructor')
	    $include_pend_inact = true;
	
	$ereadings = false;
	$first_avail = "";
	#echo $enrolled_num; echo '<pre>';print_r($course_meta);echo '</pre>';exit();
	if($enrolled_num > 0)
	{
	    $enrolled_avails = array();
	    for($i=0; $i<$enrolled_num; $i++)
	    {
		$course_meta['enrolled'][$i]['ercount'] = 0;
		#if($i>0 && $i<$enrolled_num)
		#    $enrolled_avails .= ", ";
		#$enrolled_avails .= '"'.$course_meta['enrolled'][$i]['shortname'].'"';
		$enrolled_avails[] = $course_meta['enrolled'][$i]['shortname'];
	    }
	    #echo $enrolled_avails; exit();
	    $enrolled_ercount = $this->floreadings_model->db_get_ercount_of_avails($enrolled_avails, $include_pend_inact);
	    if($enrolled_ercount == false)
		$enrolled_ercount = array();
	    for($i=0; $i<count($enrolled_ercount); $i++)
	    {
		for($j=0; $j<$enrolled_num; $j++)
		{
		    if($course_meta['enrolled'][$j]['shortname'] == $enrolled_ercount[$i]['avail_ref'] )
		    {
			$course_meta['enrolled'][$j]['ercount'] = $enrolled_ercount[$i]['ercount'];
			break;
		    }
		}
	    }
	
	    $first_avail = $course_meta['enrolled'][0]['shortname'];
	    $ereadings = $this->floreadings_model->db_get_readings_of_avail($first_avail, $include_pend_inact);
	}
	else
	{
	    #$course_meta['enrolled'] =  array();
	    #$enrolled_avails = "";
	}
        
	if($othertopics_num > 0)
	{
	    $othertopics_avails = array();
	    for($i=0; $i<$othertopics_num; $i++)
	    {
		$course_meta['othertopics'][$i]['ercount'] = 0;
		#if($i>0 && $i<$othertopics_num)
		#    $othertopics_avails .= ",";
		#$othertopics_avails .= '"'.$course_meta['othertopics'][$i]['shortname'].'"';
		$othertopics_avails[] = $course_meta['othertopics'][$i]['shortname'];
	    }
	    
	    $othertopics_ercount = $this->floreadings_model->db_get_ercount_of_avails($othertopics_avails, $include_pend_inact);
	    if($othertopics_ercount == false)
		$othertopics_ercount = array();
	    for($i=0; $i<count($othertopics_ercount); $i++)
	    {
		for($j=0; $j<$othertopics_num; $j++)
		{
		    if($course_meta['othertopics'][$j]['shortname'] == $othertopics_ercount[$i]['avail_ref'] )
		    {
			$course_meta['othertopics'][$j]['ercount'] = $othertopics_ercount[$i]['ercount'];
			break;
		    }
		}
	    }
	    
	    if($enrolled_num == 0 && $ereadings == false)
            {
	        $first_avail = $course_meta['othertopics'][0]['shortname'];
	        $ereadings = $this->floreadings_model->db_get_readings_of_avail($first_avail, $include_pend_inact);
	    }
	}
	else
	{
	    #$course_meta['othertopics'] =  array();
	    #$othertopics_avails = "";
	}
	
	/*
	$all_avails = (array)array_filter(array_merge((array)$course_meta['enrolled'], (array)$course_meta['othertopics']));
	#$all_topic_codes = array();
	#for($i=0; $i<count($all_avails); $i++)
	#{
	#    $tmp_topic_code = substr($all_avails[$i]['shortname'], 0, strpos($all_avails[$i]['shortname'], "_"));
	#    $all_topic_codes[] = $tmp_topic_code;
	#}
	#$topic_avails = $this->floreadings_model->db_get_avails_of_topic_libpet(implode(',', $all_topic_codes));
	$all_avails_name = array();
	for($i=0; $i<count($all_avails); $i++)
	{
	    $tmp_avail = $all_avails[$i]['shortname'];
	    $all_avails_name[] = $tmp_avail;
	}
	#var_dump($all_avails_name);
	#echo implode(',', $all_avails_name);
	$topic_avails = $this->floreadings_model->db_get_ercount_of_avails(implode(',', $all_avails_name)); 
	
	$ereadings = $this->floreadings_model->db_get_readings_of_avail($from_avail);
	*/
	
	$_SESSION['flo_ereading'][$topic] = $course_meta;
	# Generate a token in view_flex_reading for SSO when viewing a eReading
	if($ereadings != false)
	{
	    for($i=0;$i<count($ereadings);$i++)
	    {
		$link = $ereadings[$i]['reading_link'];
		$part1 = substr($link, 0, strpos($link, 'items')+6);
		$ereadings[$i]['reading_link'] = str_replace($part1, 'view_flex_reading/items/', $link);

	    }
	}
	else
	{
	    #echo 'No eReadings found for this topic.';
	    #return;
	    $ereadings = array();
	}
	    
	$data = array("ereadings"=>$ereadings, "course_meta"=>$course_meta, "current_avail"=>$first_avail, 
	              #"enrolled_avails"=>$enrolled_avails, "othertopics_avails"=>$othertopics_avails, 
	              'flo_site'=>$topic, 'down_notice'=>$down_notice);
        $this->load->view('reading/floreadings/view_ereadings_view', $data);
	
	return;
	
	
	
	/*
	$this->load->library('flexrest/flexrest');
        
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            #$errdata['message'] = $this->flexrest->error;
            log_message('error', 'view eReadings from flo, error on flex rest access: ' . $this->flexrest->error);
            $this->error_info('Failed to connect to FLEX to access eReadings, please try again later.');
            exit();
        }
        
        $ci =& get_instance();
        $ci->load->config('flex');
        $sam_collection = $ci->config->item('past_exam_collection');
        $institute_url = $ci->config->item('institute_url');
        #echo $institute_url;exit();
        $q = '';
        $start = 0;
        $length = 10;
        #$collections = $sam_collection;
        $order = 'modified';
        $reverse = false;
        $info = 'all';#$info = 'metadata';
        $showall = true;
	$where = "/xml/item/curriculum/topics/topic/code='$topic_code'";
        #$where = "/xml/item/curriculum/avails/avail/@avail_ref='$avail_ref'";
        $where .= " AND /xml/item/@itemstatus='live'";
	
	$searchsuccess = $this->flexrest->search($response, $q, $sam_collection, $where, $start, $length, $order, $reverse, $info, $showall);
	if(!$searchsuccess)
	{
	    #$errdata['message'] = $this->flexrest->error;
	    log_message('error', 'view SAM from flo, error on flex rest searching function: ' . $this->flexrest->error);
	    $this->error_info('Error occurred when accessing the SAM.');
	    exit();
	}

	#echo '<pre>'; print_r($response);echo '</pre>';exit();

	$sam_count = intval($response['available']);
	    
	    
	    
	
        #$this->load->helper('url');
        #$errdata['heading'] = 'Error';
        $this->load->library('flexrest/flexrest');
        
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            #$errdata['message'] = $this->flexrest->error;
            log_message('error', 'view eReadings from flo, error on flex rest access: ' . $this->flexrest->error);
            $this->error_info('Failed to connect to FLEX to access eReadings, please try again later.');
            exit();
        }
        
        $ci =& get_instance();
        $ci->load->config('flex');
        $sam_collection = $ci->config->item('sam_collection');
        $institute_url = $ci->config->item('institute_url');
        #echo $institute_url;exit();
        $q = '';
        $start = 0;
        $length = 10;
        #$collections = $sam_collection;
        $order = 'modified';
        $reverse = false;
        $info = 'all';#$info = 'metadata';
        $showall = true;
        
        #$username = $user['fan'];
        $token = $this->generateToken($user['fan']);
        
        #if($user['fan'] == 'wang1204')
        #    log_message('error', $token);
        
        $_SESSION['user_sam_auth'] = 'pass';
        $_SESSION['user_fan'] = $user['fan'];
        $_SESSION['user_sam_token'] = $token;
        
        #$find_sam = false;
        $sam_first = null;
        $sam_first_xmlwrapper = null;
        $approvalDateXpath = '/xml/item/curriculum/assessment/approval/date';
        
        for($i=0; $i<$num_enrolled+$num_othertopics; $i++)
        {
            if($i<$num_enrolled)
            {
                $category = 'enrolled';
                $j = $i;
            }
            else
            {
                $category = 'othertopics';
                $j = $i - $num_enrolled;
            }
            
            $course_meta[$category][$j]['file_url'] = null;
            $course_meta[$category][$j]['file_url_interim'] = null;
            $course_meta[$category][$j]['approval_date'] = null;
            
            $avail_ref = $course_meta[$category][$j]['shortname'];
        
            #$avail_ref = 'ENGR4700A_2014_S2';

            $where = "/xml/item/curriculum/assessment/SAMs/files/file/@ref='$avail_ref'";
            #$where = "/xml/item/curriculum/avails/avail/@avail_ref='$avail_ref'";
            $where .= " AND /xml/item/@itemstatus='live'";
            $where = urlencode($where);
            
            #First check the already found SAM
            if($i > 0 && $sam_first != null)
            {
                $xmlwrapper_name = $sam_first_xmlwrapper;
                #$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$sam['metadata']), $xmlwrapper_name);
                $fileuuid_tmp = $this->getFileUuid($this->$xmlwrapper_name, $avail_ref);
                if($fileuuid_tmp !== false)
                {
                    #$sam = $sam_first;
                    #$sam['file_uuid'] = $fileuuid_tmp;
                    $file_url = $institute_url . 'items/' . $sam_first['uuid'] . '/' . $sam_first['version'] . '/?.vi=file&attachment.uuid=' . $fileuuid_tmp;
                    $file_url .= '&token=' . $token;
                    $file_url_interim = 'viewsam/' . $sam_first['uuid'] . '/' . $sam_first['version'] . '/' . $fileuuid_tmp;
                    
                    $course_meta[$category][$j]['file_url'] = $file_url;
                    $course_meta[$category][$j]['file_url_interim'] = $file_url_interim;
                    #log_message('error', 'using $sam_first ' . $i);
                    
                    $approval_date = $this->$xmlwrapper_name->nodeValue($approvalDateXpath);
                    $course_meta[$category][$j]['approval_date'] = $approval_date;
            
                    continue;
                }
            }

            #Search SAM in FLEX
            $searchsuccess = $this->flexrest->search($response, $q, $sam_collection, $where, $start, $length, $order, $reverse, $info, $showall);
            if(!$searchsuccess)
            {
                #$errdata['message'] = $this->flexrest->error;
                log_message('error', 'view SAM from flo, error on flex rest searching function: ' . $this->flexrest->error);
                $this->error_info('Error occurred when accessing the SAM.');
                exit();
            }

            #echo '<pre>'; print_r($response);echo '</pre>';exit();

            $sam_count = intval($response['available']);
            if($sam_count > 0)
            {
                #$find_sam = true;
                if($sam_count > 1)
                    log_message('error', 'view SAM from flo, multiple SAMs found for topic availability: ' . $avail_ref);
                
                $sam = $response['results'][0];
                
                if($sam_first == null)
                {
                    $sam_first = $sam;
                    $sam_first_xmlwrapper = 'xmlwrapper'.$i;
                }
            }
            else {
                continue;
            }
            #$uuid = $sam['uuid'];
            #$version = $sam['version'];

            $xmlwrapper_name = 'xmlwrapper'.$i;
            $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$sam['metadata']), $xmlwrapper_name);
            $fileuuid_tmp = $this->getFileUuid($this->$xmlwrapper_name, $avail_ref);
            
            $file_name = null;
            foreach($sam['attachments'] as $attach1)
            {
                if($attach1["uuid"] == $fileuuid_tmp)
                {
                    $file_name = $attach1["filename"];
                    break;
                }
            }
            if($file_name == null)
            {
                log_message('error', 'view SAM from flo, could not find file name, sam uuid: ' . $sam['uuid']);
                $this->error_info('Failed to get SAM name, please try again later.');
                exit();
            }
            
            #$file_url = $institute_url . 'items/' . $sam['uuid'] . '/' . $sam['version'] . '/?.vi=file&attachment.uuid=' . $fileuuid_tmp;
            #$file_url .= '&token=' . $token;
            $file_url = $institute_url . 'file/' . $sam['uuid'] . '/' . $sam['version'] . '/' . $file_name;
            $file_url .= '?token=' . $token;
            $file_url_interim = 'viewsam/' . $sam['uuid'] . '/' . $sam['version'] . '/' . $fileuuid_tmp;
            
            #redirect($file_url);exit();
            $course_meta[$category][$j]['file_url'] = $file_url;
            $course_meta[$category][$j]['file_url_interim'] = $file_url_interim;
            
            $approval_date = $this->$xmlwrapper_name->nodeValue($approvalDateXpath);
            $course_meta[$category][$j]['approval_date'] = $approval_date;
        
        }
        
        #Single topic or list of topics
        if($num_enrolled == 1 && $num_othertopics == 0 && $course_meta['enrolled'][0]['file_url'] != null)
        {
            #$content = file_get_contents($course_meta['enrolled'][0]['file_url']);
            #echo $content;
            #header('Content-type: application/pdf');
            #header("Cache-Control: no-store, no-cache");
            #redirect($course_meta['enrolled'][0]['file_url']);
            #
            #$data['view'] = 'sam/flo/samfiles_view';
            #$data['page_title'] = 'Statement of Assessment Methods';
            #$data['course_meta'] = $course_meta;
            $data['view'] = 'sam/flo/sampdf_view';
            #$this->load->view('sam/flo/sampdf_view', $data);
        }
        else
        {
        
            $data['view'] = 'sam/flo/samfiles_view';
            #$data['page_title'] = 'Statement of Assessment Methods';
            #$data['course_meta'] = $course_meta;
            #$this->load->view('sam/flo/layout', $data);
        }
        
        $data['page_title'] = 'Statement of Assessment Methods';
        $data['course_meta'] = $course_meta;
        $this->load->view('sam/flo/layout', $data);
	 
	 */
    }        
    
        /**
         * Get eReadings for an availability
         *
         *  
         */
        public function get_reading_for_avail()
        {
	    $this->load->helper('url');
	    #echo $_POST["enrolled_avails"];echo $_POST["othertopics_avails"];
	    if (session_id() == '')
	    {
		session_start();
	    }
	    
	    #if( (!isset($_POST["enrolled_avails"]) && !isset($_POST["othertopics_avails"])) ||
		#($_POST["enrolled_avails"] == "" && $_POST["othertopics_avails"] == "") )
	    if(!isset($_POST["flo_site"]) || !isset($_POST["current_avail"]) )
	    {
		$errdata['message'] = "Invalid Request!";
		$errdata['title'] = "Error";
		$this->load->view('reading/floreadings/showerror_view', $errdata);
		return;
	    }
	    $flo_site = $_POST["flo_site"];
	    if(!isset($_SESSION['flo_ereading'][$flo_site]))
	    {
		$errdata['message'] = "Session timeout or invalid request!";
		$errdata['title'] = "";
		$this->load->view('reading/floreadings/showerror_view', $errdata);
		return;
	    }
	    
	    $this->load->model('reading_listmgr/floreadings_model');
	    
	    $down_notice = false;
	    $down_notice = $this->floreadings_model->db_chk_notice();
	    if($down_notice != false)
	    {
		#$this->error_info($down_notice['message']);
		if ($down_notice['message'] == '')
		    $down_notice['message'] = 'eReadings are temporarily unavailable, please try again later.';

	    }
	
	    $course_meta = $_SESSION['flo_ereading'][$flo_site];
	    $enrolled_num = count($course_meta['enrolled']);
            $othertopics_num = count($course_meta['othertopics']);
	    
	    $include_pend_inact = false;
	    if($course_meta['user_role'] == 'Instructor')
		$include_pend_inact = true;
	    
	    #$enrolled_avails = $_POST["enrolled_avails"];
	    #$othertopics_avails = $_POST["othertopics_avails"];
	    $current_avail = $_POST["current_avail"];
	    
	    
	    
            #$this->load->model('reading_listmgr/listmgr_model');
	    #echo 'good';
	     
	    #$course_meta1['enrolled'] = explode(',', $enrolled_avails);
	    #$course_meta1['othertopics'] = explode(',', $othertopics_avails);
	    #var_dump($course_meta['enrolled']);exit();
	    #$enrolled_num = count($course_meta1['enrolled']);
            #$othertopics_num = count($course_meta1['othertopics']);
	    
	    /*for($i=0; $i<$enrolled_num; $i++)
	    {
		$course_meta['enrolled'][$i]['ercount'] = 0;
		$course_meta['enrolled'][$i]['shortname'] = $course_meta1['enrolled'][$i];

	    }
	    for($i=0; $i<$othertopics_num; $i++)
	    {
		$course_meta['othertopics'][$i]['ercount'] = 0;
		$course_meta['othertopics'][$i]['shortname'] = $course_meta1['othertopics'][$i];
	    }*/
	    
	    if($enrolled_num > 0)
	    {
		$enrolled_avails = array();
		for($i=0; $i<$enrolled_num; $i++)
		{
		    $course_meta['enrolled'][$i]['ercount'] = 0;
		    #if($i>0 && $i<$enrolled_num)
		    #    $enrolled_avails .= ", ";
		    #$enrolled_avails .= '"'.$course_meta['enrolled'][$i]['shortname'].'"';
		    $enrolled_avails[] = $course_meta['enrolled'][$i]['shortname'];
		}
		#echo $enrolled_avails; exit();
		$enrolled_ercount = $this->floreadings_model->db_get_ercount_of_avails($enrolled_avails, $include_pend_inact);
		if($enrolled_ercount == false)
		    $enrolled_ercount = array();
		for($i=0; $i<count($enrolled_ercount); $i++)
		{
		    for($j=0; $j<$enrolled_num; $j++)
		    {
			if($course_meta['enrolled'][$j]['shortname'] == $enrolled_ercount[$i]['avail_ref'] )
			{
			    $course_meta['enrolled'][$j]['ercount'] = $enrolled_ercount[$i]['ercount'];
			    break;
			}
		    }
		}

		
	    }
	    
	    if($othertopics_num > 0)
	    {
		$othertopics_avails = array();
		for($i=0; $i<$othertopics_num; $i++)
		{
		    $course_meta['othertopics'][$i]['ercount'] = 0;
		    #if($i>0 && $i<$othertopics_num)
		    #    $othertopics_avails .= ",";
		    #$othertopics_avails .= '"'.$course_meta['othertopics'][$i]['shortname'].'"';
		    $othertopics_avails[] = $course_meta['othertopics'][$i]['shortname'];
		}

		$othertopics_ercount = $this->floreadings_model->db_get_ercount_of_avails($othertopics_avails, $include_pend_inact);
		if($othertopics_ercount == false)
		    $othertopics_ercount = array();
		for($i=0; $i<count($othertopics_ercount); $i++)
		{
		    for($j=0; $j<$othertopics_num; $j++)
		    {
			if($course_meta['othertopics'][$j]['shortname'] == $othertopics_ercount[$i]['avail_ref'] )
			{
			    $course_meta['othertopics'][$j]['ercount'] = $othertopics_ercount[$i]['ercount'];
			    break;
			}
		    }
		}

		
	    }
	   
	   #log_message('error', 'avail: '.$current_avail);
	   $ereadings = $this->floreadings_model->db_get_readings_of_avail($current_avail, $include_pend_inact);
		
	    
	    #$tmp_topic_code = substr($availability, 0, strpos($availability, "_"));
	    
	    #$topic_avails = $this->floreadings_model->db_get_avails_of_topic_libpet($tmp_topic_code);
	    #$ereadings = $this->floreadings_model->db_get_readings_of_avail($availability);
	    
	    # Generate a token in view_flex_reading for SSO when viewing a eReading
	    if($ereadings != false)
	    {
		for($i=0;$i<count($ereadings);$i++)
		{
		    $link = $ereadings[$i]['reading_link'];
		    $part1 = substr($link, 0, strpos($link, 'items')+6);
		    $ereadings[$i]['reading_link'] = str_replace($part1, '../view_flex_reading/items/', $link);

		}
	    }
	    
	    $data = array("ereadings"=>$ereadings, "course_meta"=>$course_meta, "current_avail"=>$current_avail,
		          "flo_site"=>$flo_site, 'down_notice'=>$down_notice);
	              #"enrolled_avails"=>$enrolled_avails, "othertopics_avails"=>$othertopics_avails);
            $this->load->view('reading/floreadings/view_ereadings_view', $data);
	}
	
	/**
         * Get eReadings for an availability
         *
         *  
         */
        /*public function get_past_exam()
        {
	    $this->load->helper('url');
	    
	    $this->load->model('reading_listmgr/floreadings_model');
            #$this->load->model('reading_listmgr/listmgr_model');
	    #echo 'good';
	    $topic_avails = $this->floreadings_model->db_get_avails_of_topic_libpet('');
	    $ereadings = array();
	    
	    $this->load->library('flexrest/flexrest');
	    $success = $this->flexrest->processClientCredentialToken();
	    if(!$success)
	    {
		#$errdata['message'] = $this->flexrest->error;
		log_message('error', 'view eReadings from flo, error on flex rest access: ' . $this->flexrest->error);
		$this->error_info('Failed to connect to FLEX to access eReadings, please try again later.');
		exit();
	    }

	    $ci =& get_instance();
	    $ci->load->config('flex');
	    $pep_collection = $ci->config->item('past_exam_collection');
	    #$pep_collection = '5b836ea2-a865-46ff-9c05-d0e25c56cd8d';
	    $institute_url = $ci->config->item('institute_url');
	    #echo $institute_url;exit();
	    $q = '';
	    $start = 0;
	    $length = 10;
	    $collections = $pep_collection;
	    $order = 'modified';
	    $reverse = false;
	    $info = 'all';#$info = 'metadata';
	    $showall = true;
	    $where = "/xml/item/curriculum/topics/topic/code='MMED8106'";
	    #$where = "/xml/item/curriculum/avails/avail/@avail_ref='$avail_ref'";
	    $where .= " AND /xml/item/@itemstatus='live'";

	    $searchsuccess = $this->flexrest->search($response, $q, $pep_collection, $where, $start, $length, $order, $reverse, $info, $showall);
	    if(!$searchsuccess)
	    {
		#$errdata['message'] = $this->flexrest->error;
		log_message('error', 'view SAM from flo, error on flex rest searching function: ' . $this->flexrest->error);
		$this->error_info('Error occurred when accessing the SAM.');
		exit();
	    }

	    #echo '<pre>'; print_r($response);echo '</pre>';exit();

	    $pep_count = intval($response['available']);
	    
	    $peps = $response['results'];
	
	    $data = array("ereadings"=>$ereadings, "topic_avails"=>$topic_avails, 'past_exams'=>$peps);
            $this->load->view('reading/floreadings/view_ereadings_view', $data);
	}*/
	
	/**
	 * Entry point from FLO to view past exam papers
	 * 
	 * Perform LTI authentication
	 * Check User Flo role
	 * Search for past exam papers in FLEX based on topic code
	 *
	 **/
	public function get_past_exam_papers()
        {
	    $this->load->helper('url');
	    $this->load->library('lti/lti');

	    if (!$this->lti->authenticate()) {
		    $this->error_info('Your are not authorized to view this page.');
		    exit();
	    }
	    
	    if (session_id() == '')
	    {
		session_start();
	    }
	    #echo 'good'; return;
	    #Check system down time.
	    $this->load->model('reading_listmgr/floreadings_model');
	    #$this->load->model('reading_listmgr/listmgr_model');
	    $down_notice = false;
	    $down_notice = $this->floreadings_model->db_chk_notice();
	    if($down_notice != false)
	    {
		#$this->error_info($down_notice['message']);
		if ($down_notice['message'] == '')
		    $down_notice['message'] = 'eReadings and past exams are temporarily unavailable, please try again later.';

	    }

	    $user_id = $this->input->post('user_id');
	    #$role = $this->input->post('roles');
	    #$user_id = 63;$role = 'Learner';
	    log_message('debug', 'user flo_id: '.$user_id);
	    log_message('debug', 'REMOTE_ADDR: '.$_SERVER['REMOTE_ADDR']);
	    $this->load->library('flo/flo');

	    $flouser = $this->flo->fetch_user_info($user_id);
	    #echo  $user_id;
	    #echo '<pre>';print_r($flouser);echo '</pre>';exit();
	    if($flouser === false || empty($flouser))
	    {

		log_message('error', 'Error getting user info (fetch_user_info) for user id: ' . $user_id);
		#redirect('flosam/error_info');
		$this->error_info('Failed to get user information.');
		#$data['page_title'] = 'Error';
		#$data['view'] = 'pages/error_info';
		#$data['error_info'] = 'User data error';
		#$this->load->view('layout', $data);
		exit();
	    }

	    $user['fan'] = $flouser[0]['username'];
	    #$user['name'] = $flouser[0]['fullname'];
	    #$user['email'] = $flouser[0]['email'];

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
		log_message('error', 'User Not Instructor or Learner to view the eReading from FLO, role: ' . $userrole . ', fan: ' . $user['fan']);
		#redirect('sam/flosam/noauth');
		$this->error_info('Your role is not authorized to view this page.');
		exit();
	    }

	    #$user['role'] = $this->input->post('roles');

	    $flo_site_id = $this->input->post('context_id');
	    $topic = $this->input->post('context_label');
	    log_message('debug', 'flo_site_id: ' . $flo_site_id . ', topic: ' . $topic);

	    $_SESSION['floreading_user_fan'] = $user['fan'];
	    #log_message('error', 'user_fan: ' . $_SESSION['user_fan']);
	    #$this->load->library('flo/flo');
	    #$flo_site_id = 6; $user_id = 6;
	    #$flo_site_id = 5; $user_id = 4;
	    #$flo_site_id = 10; $user_id = 5;

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


	    $enrolled_num = count($course_meta['enrolled']);
	    $othertopics_num = count($course_meta['othertopics']);

	    $topic_codes = array();
	    $topic_codes_str = "";
	    foreach($course_meta['enrolled'] as $enrolled_avail)
	    {
		$tmp_avail = $enrolled_avail['shortname'];
		if(strpos($tmp_avail, '_') !== false)
		{
		    $tmp_topic_code = substr($tmp_avail, 0, strpos($tmp_avail,"_"));
		    $topic_codes[] = $tmp_topic_code;
		}
	    }
	    foreach($course_meta['othertopics'] as $othertopics_avail)
	    {
		$tmp_avail = $othertopics_avail['shortname'];
		if(strpos($tmp_avail, '_') !== false)
		{
		    $tmp_topic_code = substr($tmp_avail, 0, strpos($tmp_avail,"_"));
		    $topic_codes[] = $tmp_topic_code;
		}
	    }
	    #log_message('error',count($topic_codes));
	    for($i=0; $i<count($topic_codes); $i++)
	    {
		if($i>0 && $i<count($topic_codes))
		    $topic_codes_str .= ",";
		$topic_codes_str .= "'" . $topic_codes[$i] . "'";
		 
	    }
	    #log_message('error',$topic_codes_str);
	
	    
	    $this->load->model('reading_listmgr/floreadings_model');
            #$this->load->model('reading_listmgr/listmgr_model');
	    #echo 'good';
	    #$topic_avails = $this->floreadings_model->db_get_avails_of_topic_libpet('');
	    #$ereadings = array();
	    
	    $this->load->library('flexrest/flexrest');
	    $success = $this->flexrest->processClientCredentialToken();
	    if(!$success)
	    {
		#$errdata['message'] = $this->flexrest->error;
		log_message('error', 'view past exam papers from flo, error on flex rest access: ' . $this->flexrest->error);
		$this->error_info('Internal error, failed to access past exam papers, please try again later.');
		exit();
	    }

	    $ci =& get_instance();
	    $ci->load->config('flex');
	    $pep_collection = $ci->config->item('past_exam_collection');
	    #$pep_collection = '5b836ea2-a865-46ff-9c05-d0e25c56cd8d';
	    $institute_url = $ci->config->item('institute_url');
	    #echo $institute_url;exit();
	    $q = '';
	    $start = 0;
	    $length = 40;
	    $collections = $pep_collection;
	    $order = 'modified';
	    $reverse = false;
	    $info = 'all';#$info = 'metadata';
	    $showall = true;
	    $where = "/xml/item/curriculum/topics/topic/code in (" . $topic_codes_str .')';
	    #$where = "/xml/item/curriculum/avails/avail/@avail_ref='$avail_ref'";
	    $where .= " AND /xml/item/@itemstatus='live'";
	    
	    #$where = str_replace('HACM9300', 'MMED8106', $where);
	    #log_message('error',$where);

	    $searchsuccess = $this->flexrest->search($response, $q, $pep_collection, $where, $start, $length, $order, $reverse, $info, $showall);
	    if(!$searchsuccess)
	    {
		#$errdata['message'] = $this->flexrest->error;
		log_message('error', 'view past exam from flo, error on flex rest searching function: ' . $this->flexrest->error);
		$this->error_info('Internal error, failed to access past exam papers, please try again later.');
		exit();
	    }

	    #echo '<pre>'; print_r($where);echo '</pre>';exit();
	    #echo '<pre>'; print_r($response);echo '</pre>';exit();

	    $pep_count = intval($response['available']);
	    
	    $peps = $response['results'];
	    
	    for($i=0; $i<$pep_count; $i++)
	    {
		$peps[$i]['pep_link'] = '../view_flex_reading/items/' . $peps[$i]['uuid'] . '/' . 
			$peps[$i]['version'] . '/?.vi=file&attachment.uuid=' . $peps[$i]['attachments'][0]['uuid'];
	    }
	    
	    $_SESSION['floreading_user_fan'] = $user['fan'];
	    $data = array('past_exams'=>$peps, 'down_notice'=>$down_notice);
            $this->load->view('reading/floreadings/view_past_exams_view', $data);
	}
	
        /**
         * View the eReading in FLEX
         *
         * attach token if necessary
         */
        public function view_flex_reading($items='missed', $uuid='missed', $version='missed')
        {
	    if (session_id() == '')
	    {
		session_start();
	    }
	
            $this->load->helper('url');
	    /*
	    if(!isset($_SESSION['floreading_user_fan']))
	    {
		$errdata['message'] = "Session timeout or invalid request!";
		$errdata['title'] = "";
		$this->load->view('reading/floreadings/showerror_view', $errdata);
		return;
	    }*/
	    
            if(isset($_GET["attachment_uuid"]))
                $attachment_uuid = $_GET["attachment_uuid"];
            else
                $attachment_uuid = "";
            if($items != 'items' || strlen($uuid) != 36 || $version == 'missed' || strlen($attachment_uuid) != 36)
            {
                $error_data = array('error_info'=>'Invalid request!');
                $this->load->view('reading/floreadings/showerror_view', $error_data);
                return;
            }
	    
            $ci =& get_instance();
            $ci->load->config('flex');
	    #$username = $_SESSION['floreading_user_fan'];
	    #log_message('error', 'user_fan: ' . $username);
            $institute_url = $ci->config->item('institute_url');
            $reading_link = $institute_url . "items/" . $uuid . "/" . $version . "/?.vi=file&attachment.uuid=" . $attachment_uuid;
    
            if(isset($_SESSION['floreading_user_fan']))
            {
		$username = $_SESSION['floreading_user_fan'];
                $token = $this->generateToken($username);
                $reading_link .= '&token=' . $token;
                
	    }
	    
            redirect($reading_link);
        }
    
	/**
	Generates a token that is valid for 30 minutes.  This should be appended to URLs so that users are not forced to log in to view content.
	E.g. 
	$itemURL = "http://MYSERVER/myinst/items/619722b1-22f8-391a-2bcf-46cfaab36265/1/?token=" . generateToken("fred.smith", "IntegSecret", "squirrel");
        
	In the example above, if fred.smith is a valid username on the EQUELLA server he will be automatically logged into the system so that he can view 
	item 619722b1-22f8-391a-2bcf-46cfaab36265/1 (provided he has the permissions to do so).
        
	Note that to use this functionality, the Shared Secrets user management plugin must be enabled (see User Management in the EQUELLA Administration Console)
	and a shared secret must be configured.
	
	@param username :The username of the user to log in as
	@param sharedSecretId :The ID of the shared secret
	@param sharedSecretValue :The value of the shared secret
	@return : A token that can be directly appended to a URL (i.e. it is already URL encoded)   E.g.  $URL = $URL . "?token=" . generateToken(x,y,z);
	*/
	private function generateToken($username)
	{
	    if(!isset($_SESSION['floreading_user_fan']))
            {
		log_message('error', 'floreadings.php, generateToken called without floreading_user_fan in Session');
		return;
	    }
	    $ci =& get_instance();
	    $ci->load->config('flex');
	    #$username = $ci->config->item('erlistmgr_shared_secret_username');
	    #$sharedSecretId = $ci->config->item('erlistmgr_shared_secret_id');
	    #$sharedSecretValue = $ci->config->item('erlistmgr_shared_secret_value');
	    $username = $username;
	    $sharedSecretId = $ci->config->item('ereadings_shared_secret_id');
	    $sharedSecretValue = $ci->config->item('ereadings_shared_secret_value');

	    $time = mktime() . '000';
	    /*return urlencode ($username) . ':' . urlencode($sharedSecretId) . ':' .  $time . ':' . 
		    urlencode(base64_encode (pack ('H*', md5 ($username . $sharedSecretId . $time . $sharedSecretValue))));*/
	    return urlencode ($username) . ':' . urlencode($sharedSecretId) . ':' .  $time . ':' . 
		urlencode(base64_encode (pack ('H*', md5 ($username . $sharedSecretId . $time . $sharedSecretValue))));
						
	}
	
        //
	// Show error information
	//
	public function error_info($error_info) 
	{
	    $errdata['message'] = $error_info;
            $errdata['title'] = "Error";
	    $this->load->view('reading/floreadings/showerror_view', $errdata);
	    $this->output->_display();
	    
	    #exit();
	}

}


/* End of file flosam.php */
/* Location: ./application/controllers/flosam.php */
