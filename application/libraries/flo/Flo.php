<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once('curl.php');

class Flo {

    private $serverurl;

    function __construct() {
        // Construct ws address
        $ci =& get_instance();
        $ci->load->config('flo');
        
        $flo_websvr_domain = $ci->config->item('flo_websvr_domain');
        $flo_websvr_urlparam = $ci->config->item('flo_websvr_urlparam');
        $flo_websvr_token = $ci->config->item('flo_websvr_token');
        
        #$flo_websvr_token = '846453d97e01378ba97c5e0eb804356e';
        #flo_websvr_domain = 'http://flotest.flinders.edu.au';
        
        $this->serverurl = $flo_websvr_domain . $flo_websvr_urlparam . $flo_websvr_token;

        
    }

    //
    // return information for given person
    //
    public function fetch_user_info($flo_id) {
        // Set functionname.
        $functionname = 'core_user_get_users_by_field';

        // Function to use 'id' to find user.
        $field = 'id';
        // FAN to find user by.
        $userid = array();
        $userid[] = $flo_id;
        #log_message('error', 'user flo_id: ' . $flo_id);
        $params = array($field, $userid);
        
        #echo '<pre>';print_r($params);    
        $response = $this->send_ws_request($functionname, $params);

        #echo '<pre>';print_r($response);echo '</pre>';exit();####

        // Format returned users.
        // @todo: error check response.
        if ($response != false && !isset($response[0]['id']))
        {
            #data incorrect
            log_message('error', "XMLRPC call in fetch_user_info returned data without response['courses'][0]['id'].");
            $response = false;
        }
        
        if ($response != false && !isset($response['faultCode']) && !empty($response)) {
            foreach ($response as $user => $values) {
                foreach ($values as $key => $value) {
                    // Remove any elements that don't match id, name or duedate.
                    switch ($key):
                        case 'username':
                        case 'fullname':
                        case 'email':
                            break;
                        default:
                            unset($response[$user][$key]);
                    endswitch;
                }
            }
        }

        return $response;

        // this is placeholder information
        return array(
            'fan' => 'demo000' . $flo_id,
            'name' => 'Demo User ' . $flo_id,
            'email' => 'login_as_demo000' . $flo_id . '@noemail.com'
        );
    }

    //
    // return list of assignments for given topic
    //
    public function fetch_assignments($courseid, $userid) {
        // Set functionname.
        $functionname = 'mod_assign_get_assignments';

        // Create array for topic and capability.
        #$course = array();
        #$course[] = $courseid;
  #echo '<pre>'; print_r($course);####
        // Hard code in capability check?
        #$capability = array();
        #$capability[] = 'mod/assign:view';

        #$params = array($course, $capability); // Add $flo_id to params when ws is altered by RT#398659.
 

        $courseids = array($courseid);
        $capabilities = array('mod/assign:view');
        #$userid = '26';
        $params1 = array($courseids, $capabilities, (int) $userid);


        //echo '<pre>';print_r($params1); 
        $response = $this->send_ws_request($functionname, $params1);
        
        //print_r($response); echo '</pre>';####
        // Check that ws returned assignment data.
        if ($response != false && isset($response['courses'][0]['assignments'])) {
            $formatted_response = $response['courses'][0]['assignments'];
            foreach ($formatted_response as $assignment => $values){
                foreach ($values as $key => $value){
                    // Remove any elements that don't match id, name or duedate.
                    switch ($key):
                        case 'id':
                        case 'name':
                        case 'duedate':
                            break;
                        default:
                            unset($formatted_response[$assignment][$key]);
                    endswitch;
                }
            }
        } else {
            // Throw error.
            log_message('error', "XMLRPC call in fetch_assignments returned data without response['courses'][0]['assignments'].");
            $formatted_response = false;#'No assignments found';
        }

        #print_r($formatted_response);
        #die();

        return $formatted_response;
    }


    //
    // return list of teaching staff members for given topic
    //
    public function fetch_teachers ($courseid) {
        // Set functionname.
        $functionname = 'core_enrol_get_enrolled_users';

        // Return only staff (using mod/assign:addinstance capability).
        #$option1 = array();
        #$option1['name'] = 'withcapability';
        #$option1['value'] = 'mod/assign:addinstance';
        #$option1['value'] = 'mod/assign:grantextension';
        // Return onlyactive users.
        #$option2 = array();
        #$option2['name'] = 'onlyactive';
        #$option2['value'] = 1;
        #$courseid = '63';
        $options = array(array('name' => 'withcapability', 'value' => 'mod/assign:grantextension'));
        $params1 = array((int) $courseid, $options);
        #echo '<pre>'; print_r($params1);

        //Add options to array before adding to params.
        #$options = array($option1);
        #$params = array('courseid'=>$topic, $opt1, $opt2);
        
#echo '<pre>'; print_r($params1);echo '</pre>';
        $response = $this->send_ws_request($functionname, $params1);
        
#echo $topic;        
#echo '<pre>'; print_r($response);echo '</pre>';exit(); ####
        // Format returned users.
        // @todo: error check response.
        
        
        if ($response != false && !isset($response['faultCode']) && !empty($response)) {
            foreach ($response as $staff => $values) {
                $response[$staff]['is_coordinator'] = "no";
                foreach ($values as $key => $value) {
                    // Remove any elements that don't match id, name or duedate.
                    switch ($key):
                        case 'id':
                        case 'username':
                        case 'fullname':
                        case 'email':
                            break;
                        case 'roles':
                            foreach($response[$staff]['roles'] as $role)
                            {
                                if($role['name'] == "Topic Coordinator")
                                {
                                    $response[$staff]['is_coordinator'] = "Coordinator";
                                    #log_message('error', "set user data is is_coord");
                                    break;
                                }
                        
                            }
                            unset ($response[$staff]['roles']);
                            break;
                        default:
                            unset($response[$staff][$key]);
                    endswitch;
                }
            }
        }

        return $response;
    }


    //
    // send extension date back to flo
    // return true on success, false on failure
    //
    public function push_extension_date($student, $assign_id, $extn_date) {
        // Set functionname.
        $functionname = 'mod_assign_save_user_extensions';

        // Create array for topic and capability.
        if (!is_array($student)){
            $userid = array();
            $userid[] = intval($student);
        } else {
            $userid = $student;
        }

        if (!is_array($extn_date)){
            $date = array();
            $date[] = intval($extn_date);
        } else {
            $date = $extn_date;
        }

        $params = array(intval($assign_id), $userid, $date);
        #echo '<pre>'; print_r($params);echo '</pre>';
        $response = $this->send_ws_request($functionname, $params);
        
        #echo '<pre>'; print_r($response);echo '</pre>';exit();
        // Check that ws returned assignment data.
        if ($response !== false && empty($response)) {
            return true;
        } else {
            // Throw error.
            log_message('error', "XMLRPC call in push_extension_date returned non-empty array.");
            return false;
        }

        #return $response;
    }

    //
    // return all child topics of a specific parent topic
    //
    public function get_course_meta_details($courseid, $userid) {
        // Set functionname.
        $functionname = 'fl_course_get_course_meta_details';

        $params1 = array($courseid, $userid);
        
        $response = $this->send_ws_request($functionname, $params1);
        #echo '<pre>'; print_r($params1); 
        #echo '<pre>'; print_r($response); echo '</pre>';####
        #exit();
        #log_message('error', "XMLRPC call in fl_course_get_course_meta_details return error.");
        #log_message('error', print_r($response, true));
        // Check that ws returned assignment data.
        if ($response != false && (isset($response['enrolled']) || isset($response['errors']))) {
            
            return $response;
        } else {
            // Throw error.
            log_message('error', "XMLRPC call in fl_course_get_course_meta_details return error.");
            log_message('error', print_r($response, true));
            return false;
        }

    }

    private function send_ws_request($functionname, $params) {
        
        //log_message('error', 'functionname: ' . $functionname);
        // Load curl to send ws request.
        $curl = new curl;

        // Send xml to FLO and record response.
        $post = xmlrpc_encode_request($functionname, $params);
        $response = xmlrpc_decode($curl->post($this->serverurl, $post));
        
        if (is_array($response) && xmlrpc_is_fault($response)) 
        {
            log_message('error', "XMLRPC call faulted in $functionname: faultCode: " . $response['faultCode'] . ', faultString: ' . $response['faultString']);
            return false;
        }

        return $response;
    }
}

/* End of file Flo.php */