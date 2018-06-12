<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flosam extends CI_Controller {

    /**
     * Entry point from FLO to view SAM
     * 
     * Perform LTI authentication
     * Check User Flo role
     * Search for SAM in FLEX based on topic availability
     *
     */

    public function index_old1() {
        
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
        
        #$this->load->library('flo/flo');
        #$flo_site_id = 6; $user_id = 6;
        #$flo_site_id = 5; $user_id = 4;
        #$flo_site_id = 10; $user_id = 5;
        $course_meta = $this->flo->get_course_meta_details((string)$flo_site_id, (string)$user_id);
        if($course_meta === false)
        {
            
            log_message('error', 'Error getting course info (get_course_meta_details) for user id: ' . $user_id . ', flo site id: ' . $flo_site_id);
            #redirect('welcome/error_info');
            $this->error_info('User/course data error.');
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
        
        #$this->load->helper('url');
        #$errdata['heading'] = 'Error';
        $this->load->library('flexrest/flexrest');
        
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            #$errdata['message'] = $this->flexrest->error;
            log_message('error', 'view SAM from flo, error on flex rest access: ' . $this->flexrest->error);
            $this->error_info('Error occurred when accessing the SAM.');
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
        $order = 'name';
        $reverse = false;
        $info = 'metadata';
        $showall = true;
        
        #$username = $user['fan'];
        $token = $this->generateToken($user['fan']);
        
        #$find_sam = false;
        $sam_first = null;
        $sam_first_xmlwrapper = null;
        
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
            $avail_ref = $course_meta[$category][$j]['shortname'];
        
            #$avail_ref = 'ENGR4700A_2014_S2';

            $where = "/xml/item/curriculum/assessment/SAMs/files/file/@ref='$avail_ref'";
            #$where = "/xml/item/curriculum/avails/avail/@avail_ref='$avail_ref'";
            #$where .= "AND /xml/item/curriculum/info/course/code='MD'";
            $where = urlencode($where);
            
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
                    $course_meta[$category][$j]['file_url'] = $file_url;
                    #log_message('error', 'using $sam_first ' . $i);
                    continue;
                }
            }

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
                    log_message('error', 'view SAM from flo, multiple SAMs found for topic availability:' . $avail_ref);
                
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
            $sam['file_uuid'] = $this->getFileUuid($this->$xmlwrapper_name, $avail_ref);

            #$filename = 'ENGR4700A%202014%20%20%20S2%20%28U%29.pdf';
            #$filename = urlencode($filename);
            $file_url = $institute_url . 'items/' . $sam['uuid'] . '/' . $sam['version'] . '/?.vi=file&attachment.uuid=' . $sam['file_uuid'];
            $file_url .= '&token=' . $token;
            #redirect($file_url);exit();
            $course_meta[$category][$j]['file_url'] = $file_url;
        
        
        }
        
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
            $data['view'] = 'sam/flo/sampdf3_view';
            #$this->load->view('sam/flo/sampdf_view', $data);
        }
        else
        {
        
            $data['view'] = 'sam/flo/samfiles3_view';
            #$data['page_title'] = 'Statement of Assessment Methods';
            #$data['course_meta'] = $course_meta;
            #$this->load->view('sam/flo/layout', $data);
        }
        
        $data['page_title'] = 'Statement of Assessment Methods';
        $data['course_meta'] = $course_meta;
        $this->load->view('sam/flo/layout', $data);
    }


    //
    // user has tried to access a page they don't have permission for
    //
    /*
    public function noauth() {
        $this->load->helper('url');
        $data['page_title'] = 'Unauthorised access';
        $data['view'] = 'sam/flo/error_auth';
        $this->load->view('sam/flo/layout', $data);
    }
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
    //
    protected function getFileUuid($itemXml, $avail_ref) 
    { 

        $num_files = $itemXml->numNodes('/xml/item/curriculum/assessment/SAMs/files/file');
        for ($i = 1; $i <= $num_files; $i++) 
        {
            $file_ref_path = '/xml/item/curriculum/assessment/SAMs/files/file['.$i.']/@ref';

            $file_ref = $itemXml->nodeValue($file_ref_path);
            if($file_ref == $avail_ref)
            {
                $file_uuid_path = '/xml/item/curriculum/assessment/SAMs/files/file['.$i.']/uuid';
                $file_uuid = $itemXml->nodeValue($file_uuid_path);
                return $file_uuid;
            }
	}
        return false;
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
        $ci =& get_instance();
        $ci->load->config('flex');
        #$username = $ci->config->item('sam_shared_secret_username');
        $sharedSecretId = $ci->config->item('sam_shared_secret_id');
        $sharedSecretValue = $ci->config->item('sam_shared_secret_value');
        
		$time = mktime() . '000';
		/*return urlencode ($username) . ':' . urlencode($sharedSecretId) . ':' .  $time . ':' . 
                        urlencode(base64_encode (pack ('H*', md5 ($username . $sharedSecretId . $time . $sharedSecretValue))));*/
		  return urlencode ($username) . ':' . urlencode($sharedSecretId) . ':' .  $time . ':' . 
                        urlencode(base64_encode (pack ('H*', md5 ($username . $sharedSecretId . $time . $sharedSecretValue))));
						
	}

    /**
     * Entry point from FLO to view SAM
     * 
     * Perform LTI authentication
     * Check User Flo role
     * Search for SAM in FLEX based on topic availability
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
        
        #$_SESSION['user_fan'] = $user['fan'];
        #$this->load->library('flo/flo');
        #$flo_site_id = 6; $user_id = 6;
        #$flo_site_id = 5; $user_id = 4;
        #$flo_site_id = 10; $user_id = 5;
        $course_meta = $this->flo->get_course_meta_details((string)$flo_site_id, (string)$user_id);
        if($course_meta === false)
        {
            
            log_message('error', 'Error getting course info (get_course_meta_details) for user id: ' . $user_id . ', flo site id: ' . $flo_site_id);
            #redirect('welcome/error_info');
            $this->error_info('User/course data error.');
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
        
        #$this->load->helper('url');
        #$errdata['heading'] = 'Error';
        $this->load->library('flexrest/flexrest');
        
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            #$errdata['message'] = $this->flexrest->error;
            log_message('error', 'view SAM from flo, error on flex rest access: ' . $this->flexrest->error);
            $this->error_info('Error occurred when accessing the SAM.');
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
        $order = 'name';
        $reverse = false;
        $info = 'metadata';
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
            $avail_ref = $course_meta[$category][$j]['shortname'];
        
            #$avail_ref = 'ENGR4700A_2014_S2';

            $where = "/xml/item/curriculum/assessment/SAMs/files/file/@ref='$avail_ref'";
            #$where = "/xml/item/curriculum/avails/avail/@avail_ref='$avail_ref'";
            #$where .= "AND /xml/item/curriculum/info/course/code='MD'";
            $where = urlencode($where);
            
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
                    continue;
                }
            }

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
            
            $file_url = $institute_url . 'items/' . $sam['uuid'] . '/' . $sam['version'] . '/?.vi=file&attachment.uuid=' . $fileuuid_tmp;
            $file_url .= '&token=' . $token;
            $file_url_interim = 'viewsam/' . $sam['uuid'] . '/' . $sam['version'] . '/' . $fileuuid_tmp;
            
            #redirect($file_url);exit();
            $course_meta[$category][$j]['file_url'] = $file_url;
            $course_meta[$category][$j]['file_url_interim'] = $file_url_interim;
        
        }
        
        if($num_enrolled == 1 && $num_othertopics == 0 && $course_meta['enrolled'][0]['file_url_interim'] != null)
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
    }        
    
    /**
     * View SAM PDF
     *
     * @param array $uuid, item UUID
     * @param array $version, item Version
     * @param array $file_uuid, attachment file UUID
     */
    public function viewsam($uuid='missed', $version='missed', $file_uuid='missed') 
    {
        $this->load->helper('url');
        if($this->validate_params($uuid, $version, $file_uuid) == false)
        {
            #$errdata['message'] = "Invalid Request";
            $this->error_info('Invalid Request or session timeout.');
            exit();
        }
        
        session_start();
        $ci =& get_instance();
        $ci->load->config('flex');
        $institute_url = $ci->config->item('institute_url');
        $file_url = $institute_url . 'items/' . $uuid . '/' . $version . '/?.vi=file&attachment.uuid=' . $file_uuid;
        
        if(!isset($_SESSION['user_sam_token']) || !isset($_SESSION['user_fan']) 
           || !isset($_SESSION['user_sam_auth']) || $_SESSION['user_sam_auth'] != 'pass')
        {
            $this->error_info('Invalid Request or session timeout.');
            exit();
        }
        $file_url .= '&token=' . $_SESSION['user_sam_token'];
        
        #echo $file_url;
        #$data['pdf_link'] = $file_url;
        #$data['view'] = 'sam/flo/sampdf1_view';
        #$data['page_title'] = 'Statement of Assessment Methods';
      
        #$this->load->view('sam/flo/layout', $data);
        #if($_SESSION['user_fan'] == 'wang1204')
        #    log_message('error', $file_url);
        redirect($file_url);
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


/* End of file flosam.php */
/* Location: ./application/controllers/flosam.php */