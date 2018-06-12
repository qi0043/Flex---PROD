<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class to support eReading: 
 *   
 *   Rollover: activate eReadings against availabilities based on activated eReadings of another availability
 * 
 *   activation: activate one eReading against multiple availabilities
 */
class Rollover extends CI_Controller {

	protected $logger_rollover;
        protected $logger_activation;
        protected $soapusername;
        protected $soappassword;
        protected $soapparams;
	
        /**
         * Constructor
         *
         * Get logger at application/logs/rollover for rollover and
         *               application/logs/activation for activation
         *
         * Get user's user groups in Equella. Check whether the user is in 
         * required group for rollover and activation. Set session variables.
         */
        public function __construct()
        {
            parent::__construct();
            
            $ci =& get_instance();
            $ci->load->config('flex');
            $loggings = $ci->config->item('rolloverlog');
            $this->load->library('logging/logging',$loggings);
            $this->logger_rollover = $this->logging->get_logger('rollover');
            $this->logger_activation = $this->logging->get_logger('activation');
            $this->soapusername = $ci->config->item('soap_activation_username');
            $this->soappassword = $ci->config->item('soap_activation_password');
            $this->soapparams = array('username'=>$this->soapusername, 'password'=>$this->soappassword);
            $this->load->helper('url');
            
            session_start();
            if(isset($_SESSION['rollover_privilege']) && $_SESSION['rollover_privilege']=='contributor')
                return;
            #return;####
            
            if(isset($_SESSION['rollover_privilege']) && $_SESSION['rollover_privilege']=='none')
            {
                redirect( 'reading/notification/noprivilege');
                return;
            }
            
            #$groups = 'EQ contributor'; #### '';
            $groups = '';
            
            $usergrp1_activation = $ci->config->item('usergrp1_activation');
            $usergrp2_activation = $ci->config->item('usergrp2_activation');
            
            if(!isset($_SERVER['REMOTE_USER']))
            {
                $errdata['message'] = 'Unable to get username';
                $errdata['heading'] = "Internal error";
                $this->load->view('reading_rollover/showerror_view', $errdata);
                return;
            }
            $userUuid = $_SERVER['REMOTE_USER'];
            
            $this->load->library('flexsoap/flexsoap',$this->soapparams);
            if(!$this->flexsoap->success)
            {
                $errdata['message'] = $this->flexsoap->error_info;
                $errdata['heading'] = "Internal error";
                $this->load->view('reading_rollover/showerror_view', $errdata);
                return;
            }
            
            $groups = $this->flexsoap->getGroupsByUser($userUuid);
            if(!$this->flexsoap->success)
            {
                $errdata['message'] = $this->flexsoap->error_info;
                $errdata['heading'] = "Internal error";
                $this->load->view('reading_rollover/showerror_view', $errdata);
                return;
            }
            
            #$this->logger_rollover->info("user group: " . $groups);
            #must in one of the user groups to proceed.
            if(strpos($groups, $usergrp1_activation) === false && strpos($groups, $usergrp2_activation) === false)
            {
                $_SESSION['rollover_privilege'] = 'none';
                redirect( 'reading/notification/noprivilege');
            }
            else
            {
                $_SESSION['rollover_privilege'] = 'contributor';
            }
        }
        
        public function chktopic()
	{
                #$this->load->helper('form');
                #$this->load->library('form_validation');
                $this->load->helper('url');
		$this->load->view('reading_rollover/chktopic_view.php');
	}
        /*
        public function notauthorized()
	{
                $errdata['message'] = "Your don't have the required previlege for this function.";
                $errdata['heading'] = "Authorization Failed";
                $this->load->view('activate/showerror_view', $errdata);
                return;
	}
        */

        /**
         * Get the availabilities of From/To topic codes
         *
         * Get the number of activated eReadings for the availabilities.
         * This is on AJAX post call.
         */
        public function getavails()
	{
            $this->load->helper('url');    
            #$this->load->helper('form');
            #$this->load->library('form_validation');
            
            if(!isset($_POST["from_topic_code"]) || !isset($_POST["to_topic_code"]))
            {
                $error_data = array('error_info'=>'Invalid input topic code.');
                $this->load->view('reading_rollover/fromto_avails_error_view', $error_data);
                return;
            }
            
            $from_topic_code = strtoupper(trim($_POST["from_topic_code"]));
            $to_topic_code = strtoupper(trim($_POST["to_topic_code"]));
            #log_message('error', $topic_code);
            #$topic_code = strtoupper(trim(set_value('topic_code')));
            #log_message('error', $topic_code);
            $this->load->model('reading_rollover/rollover_model');
                
            $from_avails = $this->rollover_model->db_chk_avails_by_topic($from_topic_code);
            
            if($from_avails === false )
            {
                $error_data = array('error_info'=>'No availability found for From topic code.');
                $this->load->view('reading_rollover/fromto_avails_error_view', $error_data);
                #echo ('<br><div class="breadcrumbs"><b>Availabilities for rollover:</b></div><br>');
                #echo ('<p style="color:red">&nbsp;No availability found for From topic code.<p>');
                return;
            }
            
            $to_avails = $this->rollover_model->db_chk_avails_by_topic($to_topic_code);
            
            if($to_avails === false )
            {
                $error_data = array('error_info'=>'No availability found for To topic code.');
                $this->load->view('reading_rollover/fromto_avails_error_view', $error_data);
                return;
            }
            
            #
            $from_topic_name = $this->rollover_model->db_get_topicname($from_topic_code);
            $to_topic_name = $this->rollover_model->db_get_topicname($to_topic_code);
            
            $from_avails_num_readings = $this->rollover_model->db_get_numof_readings_by_avail($from_avails);
            $to_avails_num_readings = $this->rollover_model->db_get_numof_readings_by_avail($to_avails);
            
            #Number of readings rolled over or activated in this system today.
            $from_avails_rollover_readings = $this->rollover_model->db_get_numof_rollover_readings_by_avail($from_avails);
            $to_avails_rollover_readings = $this->rollover_model->db_get_numof_rollover_readings_by_avail($to_avails);
            
            #$from_data = '';
            #foreach ($avails as $row)
            #{
              #$from_data .= '<br>' . $row['availability'];
              
            #}
            #echo $data;
            $data = array("from_avails"=>$from_avails,"to_avails"=>$to_avails,
                            "from_topic_name"=>$from_topic_name, "to_topic_name"=>$to_topic_name,
                            "from_avails_num_readings"=>$from_avails_num_readings,
                            "to_avails_num_readings"=>$to_avails_num_readings,
                            "from_avails_rollover_readings"=>$from_avails_rollover_readings,
                            "to_avails_rollover_readings"=>$to_avails_rollover_readings);
            $this->load->view('reading_rollover/fromto_avails_view', $data);
        }
        
        /**
         * Get the activated eReadings for the From availability
         *
         * The eReading database is updated daily from Equella.
         */
        public function getereadings()
	{
            $this->load->helper('url');    
            #$this->load->helper('form');
            #$this->load->library('form_validation');
            
            if(!isset($_POST["from_avail"]) || !isset($_POST["to_avails"]))
            {
                $error_data = array('heading'=>'Error', 'message'=>'Invalid input data');
                $this->load->view('reading_rollover/showerror_view', $error_data);
                return;
            }
            
            $from_avail = strtoupper(trim($_POST["from_avail"]));
            $to_avails = $_POST["to_avails"];
            #echo $from_avail;
            
            $this->load->model('reading_rollover/rollover_model');
                
            $ereadings = $this->rollover_model->db_get_readings_by_avail($from_avail);
            
            ##$rollover_ereadings = $this->rollover_model->db_get_rollover_readings_by_avail($from_avail);
            $from_avails[0]['availability'] = $from_avail;
            $num_rollover_ereadings = $this->rollover_model->db_get_numof_rollover_readings_by_avail($from_avails);
            
            #echo '<pre>';
            #print_r($ereadings);
            #echo '</pre>';
            if($ereadings != false)
                $readings_count = count($ereadings);
            $to_avails_count = count($to_avails);
            
            /*
            for($e=0;$e<$readings_count;$e++)
            {
                $ereadings[$e]['act_stat'] = '';
                for($i=0;$i<$to_avails_count;$i++)
                {
                    $acted = $this->activate_model->db_chk_reading_for_avail($ereadings[$e]['reading_link'],$to_avails[$i]);
                    $ereadings[$e]['act_stat'] .= ','.($acted?1:0);
                }
            }
            */
            $data = array("from_avail"=>$from_avail, "ereadings"=>$ereadings, 
                            "to_avails"=>$to_avails, "num_rollover_ereadings"=>$num_rollover_ereadings[0]['num_readings']);
            $this->load->view('reading_rollover/ereadings_view', $data);
            
        }
        
        /**
         * rollover_activate()
         * Activate the eReadings in rollover process. This is in AJAX post call to activate a few eReadings. 
         *
         * Get UUID/Version/Attachment from the reading link, check whether this activation
         * on selected availability already exitsts, if not, activate the reading against the availability.
         */
        
        /**
         * This comment block is to explain the functions of ereadings.js which calls rollover_activate().
         * The source javascript file is at flex/resource/rollover/js/readings.js.
         * 
         * All the selected eReadings are in ereadingArray, suppose there are 173 eReadings,
         * then num_div = 173/5 = 34 (batch_size=5)
         *      num_mod = 173%5 = 3
         *      
         * to_avails array has all the To availabilities, supporse there are 5 availabilities,
         * then toavail_idx is incremented from 0 to 4.
         * 
         * In every AJAX call 5(batch_size) eReadings are activated. postcall_idx is incremented from 1
         * to 34. After it reaches 34 then toavail_idx is incremented by 1 and postcall_idx is set to 1.
         * This means it is one availability after another.
         * 
         * num_success is the number of all successful new activations (for one availability) and
         * num_duplication is the number of all duplication activations (for one availability)
         */
        public function rollover_activate()
	{
            
            /*
            if(!isset($_POST["from_avail"]) || !isset($_POST["to_avail"])
                || !isset($_POST["readings"]) || !isset($_POST["reading_idxs"]))
            {
                $result['items_count'] = 1;
                $result['items']["status"][0] = "Failed";
                $result['error_info'] = "Input data error";
                echo json_encode($result);
                return;
            }
            */
            $from_avail = ($_POST["from_avail"]);
            $to_avail = ($_POST["to_avail"]);
            $readings = ($_POST["readings"]);
            $reading_idxs = ($_POST["reading_idxs"]);
            $reading_count = count($readings);
            #log_message('error', "reaing_count is:".$reading_count);
            
            #$result['to_avail'] = $to_avail;
            $result['items_count'] = $reading_count;
            
            if(isset($_SERVER['REMOTE_USER']))
                $user = $_SERVER['REMOTE_USER'];
            else
                $user = '????';
                    
            
            $this->load->library('flexsoap/flexsoap',$this->soapparams);
            
            if(!$this->flexsoap->success)
            {
                $errdata['message'] = $this->flexsoap->error_info;
                #echo $errdata['message'];
                #$this->load->view('sam/showerror_view', $errdata);
                $this->logger_rollover->error("Error: " . $this->flexsoap->error_info);
                $result['items_count'] = 1;
                $result['items']["status"][0] = "failed";
                $result['items']["readingidx"][0] = $reading_idxs[0];
                $result['error_info'] = $this->flexsoap->error_info;
                echo json_encode($result);
                return;
            }

            for($i=0;$i<$reading_count;$i++)
            {
                //log_message('error', "reaing idx is:".$reading_idxs[$i]);
                //log_message('error', "\nreaing is:".$readings[$i]);
                
                $reading_link = $readings[$i];
                $item_uuid = substr($reading_link, strpos($reading_link, 'items')+6, 36);
                $attachment_uuid = substr($reading_link, strpos($reading_link, 'uuid')+5, 36);
                $version = substr($reading_link, strpos($reading_link, 'items')+43, strpos($reading_link, '/?') - (strpos($reading_link, 'items')+43) );
                #log_message('error', "version is:".$version);
                
                $this->load->model('reading_rollover/rollover_model');
                #this is a validation
                $data_valid = $this->rollover_model->db_chk_reading_for_avail($reading_link,$from_avail);
                if($data_valid == false)
                {
                    $this->logger_rollover->error("Error: data invalid, reading is not activated for from availability"
                            . "availability: " . $from_avail . ", reaidng: " . $reading_link);
                    $result['items_count'] = $i+1;
                    $result['items']["status"][$i] = "failed";
                    $result['items']["readingidx"][$i] = $reading_idxs[$i];
                    $result['error_info'] = "Error: data invalid";
                    echo json_encode($result);
                    return;
                }    
                    
                $activated = $this->rollover_model->db_chk_reading_for_avail($reading_link,$to_avail);
                $rollovered = $this->rollover_model->db_chk_rollover_reading_for_avail($reading_link,$to_avail);
                
                if($activated == false && $rollovered == false)
                //if($activated == false)    
                {
                    
                    $this->flexsoap->activateItemAttachments($item_uuid, intval($version), $to_avail, array($attachment_uuid));
                    if(!$this->flexsoap->success)
                    {
                        #$errdata['message'] = $this->flexsoap->error_info;
                        #echo $errdata['message'];
                        #$this->load->view('sam/showerror_view', $errdata);
                        $this->logger_rollover->error("Error: " . $this->flexsoap->error_info);
                        $result['items_count'] = $i+1;
                        $result['items']["status"][$i] = "failed";
                        $result['items']["readingidx"][$i] = $reading_idxs[$i];
                        $result['error_info'] = $this->flexsoap->error_info;
                        echo json_encode($result);
                        return;
                    }
                    
                    $this->rollover_model->db_ins_rollover_reading_for_avail($reading_link,$to_avail,$user,$from_avail);
                    
                    $result['items']["readingidx"][$i] = $reading_idxs[$i];
                    $result['items']["status"][$i] = "activated";
                    
                    $this->logger_rollover->info("Rollover Success with user: " . $user . ", from: " . $from_avail . " to " . $to_avail . ", index: " . $reading_idxs[$i] . ", reading link: " . $reading_link);
                    
                }
                else
                {
                    $result['items']["readingidx"][$i] = $reading_idxs[$i];
                    $result['items']["status"][$i] = "duplication";
                    
                    $this->logger_rollover->info("Rollover Duplication with user: " . $user . ", from: " . $from_avail . " to " . $to_avail . ", index: " . $reading_idxs[$i] . ", reading link: " . $reading_link);
                    
                    if($reading_idxs[$i] == 1118) #### for testing
                    {

                        $result['items']["status"][$i] = "failed";
                        $result['error_info'] = "Soap fault: Network issue, unable to connect to host";
                        echo json_encode($result);
                        return;
                    }
                }
                //log_message('error', "uuid: " . $item_uuid . "   attachment: " . $attachment_uuid);
            }
            //log_message('error', json_encode($result));
            $result['satus'] = "success";
            $result['error_info'] = "";
            echo json_encode($result); 
           
        }
        
        /**
         * Above functions are for the eReading rollovers.
         * 
         * Below functions (with the help of the the construtor) are for the
         * eReading activation against multiple availabilies
         */
        
        /**
         * Get the eReading link.
         *
         * Show the topic code input box.
         */
        public function activate_reading()
	{
            if(!isset($_GET["uuid"]) || !isset($_GET["version"]) || !isset($_GET["attachment"]))
            {
                $error_data = array('heading'=>'Error', 'message'=>'Invalid Request');
                $this->load->view('reading_activate/showerror_view', $error_data);
                return;
            }
            $uuid = $_GET["uuid"];
            $version = $_GET["version"];
            $attachment = $_GET["attachment"];
            
            if(strlen($uuid) != 36 || !is_numeric($version) || strlen($attachment) != 36 )
            {
                $error_data = array('heading'=>'Error', 'message'=>'Invalid Request');
                $this->load->view('reading_activate/showerror_view', $error_data);
                return;
            }
            
            $data['uuid'] = $uuid;
            $data['version'] = $version;
            $data['attachment'] = $attachment;
            
            $ci =& get_instance();
            $ci->load->config('flex');
            $institute_url = $ci->config->item('institute_url');
            $reading_link = $institute_url . "items/" . $uuid . "/" . $version . "/?.vi=file&attachment.uuid=" . $attachment;
            $data['reading_link'] = $reading_link;
            /*
            $data['uuid'] = $_GET["uuid"];
            $data['version'] = $_GET["version"];
            $data['attachment'] = $_GET["attachment"];
            */
            #$this->load->helper('form');
            #$this->load->library('form_validation');
            $this->load->helper('url');
            $this->load->view('reading_activate/reading_activate_view.php', $data);
	}
        
        /**
         * Get the availabilities for the specified topic code.
         *
         * This is on AJAX post call.
         */
        public function getavailabilities()
	{
            #$uuid = $_POST["uuid"];
            #$version = $_POST["version"];
            #$attachment = $_POST["attachment"];
            
            $this->load->helper('url');    
            #$this->load->helper('form');
            #$this->load->library('form_validation');
            
            $topic_code = strtoupper(trim($_POST["topic_code"]));
            #$to_topic_code = strtoupper(trim($_POST["to_topic_code"]));
            #log_message('error', $topic_code);
            #$topic_code = strtoupper(trim(set_value('topic_code')));
            #log_message('error', $topic_code);
            $this->load->model('reading_rollover/rollover_model');
                
            $availabilities = $this->rollover_model->db_chk_avails_by_topic($topic_code);
            $topic_name = $this->rollover_model->db_get_topicname($topic_code);
            
            if($availabilities === false )
            {
                $error_data = array('error_info'=>'No availability found for the topic code.');
                $this->load->view('reading_activate/avails_error_view', $error_data);
                return;
            }
            
            #$from_avails_num_readings = $this->activate_model->db_get_numof_readings_by_avail($from_avails);
            #$to_avails_num_readings = $this->activate_model->db_get_numof_readings_by_avail($to_avails);
            
            #Number of readings rolled over today.
            #$from_avails_rollover_readings = $this->activate_model->db_get_numof_rollover_readings_by_avail($from_avails);
            #$to_avails_rollover_readings = $this->activate_model->db_get_numof_rollover_readings_by_avail($to_avails);
            
            #$from_data = '';
            #foreach ($avails as $row)
            #{
              #$from_data .= '<br>' . $row['availability'];
              
            #}
            #echo $data;
            $data = array("topic_code"=>$topic_code, "availabilities"=>$availabilities, "topic_name"=>$topic_name);
            $this->load->view('reading_activate/availability_view', $data);
        }
        
        /**
         * Activate the eReading against selected availabilities.
         *
         * Show activation results.
         */
        public function activate_reading_res()
	{
            $this->load->helper('url'); 
            //sleep(1);
            //log_message('error', implode($readings, ","));
            
            #$from_avail = ($_POST["from_avail"]);
            $to_avails = ($_POST["to_avails"]);
            $item_uuid = $_POST["uuid"];
            $version = $_POST["version"];
            $attachment_uuid = $_POST["attachment"];
            $avail_count = count($to_avails);
            #log_message('error', "reaing_count is:".$reading_count);
            
            #$result['to_avail'] = $to_avail;
            #$result['items_count'] = $reading_count;
            $ci =& get_instance();
            $ci->load->config('flex');
            $institute_url = $ci->config->item('institute_url');
            $reading_link = $institute_url . "items/" . $item_uuid . "/" . $version . "/?.vi=file&attachment.uuid=" . $attachment_uuid;
            #"https://flex-test.flinders.edu.au/items/28c35509-8943-4e76-ac54-0863e24e36ce/1/?.vi=file&attachment.uuid=f9f4c271-dbb1-4093-9a4c-e974bc406d26"
            
            if(isset($_SERVER['REMOTE_USER']))
                $user = $_SERVER['REMOTE_USER'];
            else
                $user = '????';
                    
            for($i=0;$i<$avail_count;$i++)
            {
                $result["status"][$i] = '';
            }
            $result['error_info'] = '';
            
            $this->load->library('flexsoap/flexsoap',$this->soapparams);
            
            if(!$this->flexsoap->success)
            {
                $this->logger_activation->error("Error: " . $this->flexsoap->error_info);
                $result["status"][0] = "Failed";
                $result['error_info'] = $this->flexsoap->error_info;
                $data = array("to_avails"=>$to_avails,"result"=>$result);
                $this->load->view('reading_activate/readingfortopic_res_view', $data);
                return;
            }
            

            for($i=0;$i<$avail_count;$i++)
            {
                
                $to_avail = $to_avails[$i];
                
                $this->load->model('reading_rollover/rollover_model');
                
                $activated = $this->rollover_model->db_chk_reading_for_avail($reading_link,$to_avail);
                $rollovered = $this->rollover_model->db_chk_rollover_reading_for_avail($reading_link,$to_avail);
                
                if($activated == false && $rollovered == false)
                //if($activated == false)    
                {

                    
                    $this->flexsoap->activateItemAttachments($item_uuid, intval($version), $to_avail, array($attachment_uuid));
                    if(!$this->flexsoap->success)
                    {
                        $this->logger_activation->error("Error: " . $this->flexsoap->error_info);
                        $result["status"][$i] = "Failed";
                        $result['error_info'] = $this->flexsoap->error_info;
                        break;
                    }
                    
                    $this->rollover_model->db_ins_rollover_reading_for_avail($reading_link,$to_avail,$user);
                    
                    $result["status"][$i] = "Success";
                    
                    $this->logger_activation->info("Activation Successful with user: " . $user . ", availability: " . $to_avail . ", reading link: " . $reading_link);
                    
                }
                else
                {
                    $result["status"][$i] = "Duplication";
                    
                    $this->logger_activation->info("Activation Duplicate with user: " . $user . ", availability: " . $to_avail . ", reading link: " . $reading_link);
                    
                    if($i == 1113) #### for testing
                    {

                        $result["status"][$i] = "Failed";
                        $result['error_info'] = "Soap fault: Network issue, unable to connect to host";
                        #echo json_encode($result);
                        #return;
                    }
                }
                //log_message('error', "uuid: " . $item_uuid . "   attachment: " . $attachment_uuid);
            }
            
            $data = array("to_avails"=>$to_avails, "result"=>$result, "reading_link"=>$reading_link);
            $this->load->view('reading_activate/reading_activate_res_view', $data);
           
        }
}
