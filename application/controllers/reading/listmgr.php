<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class to support eReading list management by topic coordinator:
 *
 *   Rollover: activate eReadings against availabilities based on activated eReadings of another availability
 *
 *   activation: activate one eReading against multiple availabilities
 */
class Listmgr extends CI_Controller {

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

            session_start();
            $ci =& get_instance();
            $ci->load->config('flex');
            $loggings = $ci->config->item('rolloverlog');
            $this->load->library('logging/logging',$loggings);
            $this->logger_rollover = $this->logging->get_logger('rollover');
            $this->logger_activation = $this->logging->get_logger('activation');
            $this->load->helper('url');

            $this->load->model('reading_listmgr/listmgr_model');
            #check down time before authentication through FLEX
            $down_notice = false;
            $down_notice = $this->listmgr_model->db_chk_notice();
            if($down_notice != false)
            {

                if ($down_notice['message'] == '')
                    $down_notice['message'] = 'The eReading list management system is temporarily unavailable, please try again later.';

                $errdata['message'] = $down_notice['message'];
                $errdata['heading'] = "Notice";
                $this->load->view('reading_listmgr/showerror_view', $errdata);
                $this->output->_display();
                exit;
            }
           /* #check down time before authentication through FLEX
            $_SESSION['listmgr_notice'] = null;
            $down_notice = false;
            $down_notice = $this->listmgr_model->db_chk_notice();
            if($down_notice != false)
            {

                #if ($down_notice['message'] == '')
                #    $down_notice['message'] = 'eReading list management application is temporarily unavailable, please try again later.';

                #$errdata['message'] = $down_notice['message'];
                #$errdata['heading'] = "Notice";
                #$this->load->view('reading_listmgr/showerror_view', $errdata);
                #$this->output->_display();
                #exit();
                $_SESSION['listmgr_notice'] = $down_notice['message'];
            }*/
						if(isset($_SESSION['rollover_privilege']) && $_SESSION['rollover_privilege']=='administrator')
								return;
            if(isset($_SESSION['rollover_privilege']) && $_SESSION['rollover_privilege']=='contributor')
                return;
            if(isset($_SESSION['rollover_privilege']) && $_SESSION['rollover_privilege']=='topic_coordinator')
                return;

            #Below URL does not require authenticaion:
            $link_erlist_url = '/flex/reading/listmgr/view_erlist_url';
            $link_erlist_url_length = strlen($link_erlist_url);
            if( substr($_SERVER['REQUEST_URI'], 0, $link_erlist_url_length) === $link_erlist_url )
                    return;

            if(isset($_SESSION['rollover_privilege']) && $_SESSION['rollover_privilege']=='none')
            {
                redirect( 'reading/notification/noprivilege');
                return;
            }

            if(!isset($_SERVER['REMOTE_USER']))
            {
                ####
                $this->logger_rollover->error("Error: REMOTE_USER not set.");
                $this->logger_activation->error("Error: REMOTE_USER not set.");
                $errdata['message'] = 'Unable to get username';
                $errdata['heading'] = "Internal error";
                $this->load->view('reading_listmgr/showerror_view', $errdata);
                $this->output->_display();
                exit();
            }
            $userUuid = strtolower($_SERVER['REMOTE_USER']);
            #log_message('error', '2222' . $userUuid);

            #check topic coordinator
            $topic_coord = $this->listmgr_model->db_chk_topic_coord($userUuid);
            if($topic_coord != false)
            {
                #Is topic coordinator
                $_SESSION['rollover_privilege'] = 'topic_coordinator';
                //$_SESSION['listmgr_role'] = 'topic_coordinator';
                return;
            }

            #Check eReadings team
            $this->soapusername = $ci->config->item('soap_activation_username');
            $this->soappassword = $ci->config->item('soap_activation_password');
            $this->soapparams = array('username'=>$this->soapusername, 'password'=>$this->soappassword);

            #$groups = 'EQ contributor'; #### '';
            $groups = '';

            $usergrp_listmgr_advcontributor = $ci->config->item('usergrp_listmgr_advcontributor');
            $usergrp_listmgr_libviewer = $ci->config->item('usergrp_listmgr_libviewer');
						$usergrp_listmgr_lib_admin = $ci->config->item('usergrp_listmgr_lib_admin');

            $this->load->library('flexsoap/flexsoap',$this->soapparams);
            if(!$this->flexsoap->success)
            {
                ####
                $this->logger_rollover->error($this->flexsoap->error_info);
                $this->logger_activation->error($this->flexsoap->error_info);
                $errdata['message'] = $this->flexsoap->error_info;
                $errdata['heading'] = "Internal error";
                $this->load->view('reading_listmgr/showerror_view', $errdata);
                $this->output->_display();
                exit();
            }

            $groups = $this->flexsoap->getGroupsByUser($userUuid);
            if(!$this->flexsoap->success)
            {
                ####
                $this->logger_rollover->error($this->flexsoap->error_info);
                $this->logger_activation->error($this->flexsoap->error_info);
                $errdata['message'] = $this->flexsoap->error_info;
                $errdata['heading'] = "Internal error";
                $this->load->view('reading_listmgr/showerror_view', $errdata);
                $this->output->_display();
                exit();
            }

            #$this->logger_rollover->info("user group: " . $groups);
            #must in one of the user groups to proceed.
            if(strpos($groups, $usergrp_listmgr_lib_admin) !== false)
						{
							$_SESSION['rollover_privilege'] = 'administrator';
							return;
						}
            else if(strpos($groups, $usergrp_listmgr_advcontributor) !== false)
            {
                #Advanced contributors
                $_SESSION['rollover_privilege'] = 'contributor';
                return;
            }
            else if(strpos($groups, $usergrp_listmgr_libviewer) !== false)
            {
                #Lib Viewerws have the same privilege as topic coordinator
                $_SESSION['rollover_privilege'] = 'topic_coordinator';
                return;
            }
            else
            {
                $_SESSION['rollover_privilege'] = 'none';
                redirect( 'reading/notification/noprivilege');
            }

        }

        public function rollover_er_chktopic()
	{

            $this->load->helper('url');

            $topic_code = null;
            $view_type = null;
            if(isset($_GET["topic_code"]))
            {
                 $topic_code = strtoupper(trim($_GET["topic_code"]));
            }
            if(isset($_GET["view_type"]))
            {
                 $view_type = strtoupper(trim($_GET["view_type"]));
            }

            $data = array("view_type"=>$view_type,
                          "topic_code"=>$topic_code);
            $this->load->view('reading_listmgr/rollover_er_chktopic_view.php', $data);
	}

        public function view_er_chktopic()
	{

            $this->load->helper('url');

            $topic_code = null;
            $view_type = null;
            if(isset($_GET["topic_code"]))
            {
                 $topic_code = strtoupper(trim($_GET["topic_code"]));
            }
            if(isset($_GET["view_type"]))
            {
                 $view_type = strtoupper(trim($_GET["view_type"]));
            }

            $data = array("view_type"=>$view_type,
                          "topic_code"=>$topic_code);
            $this->load->view('reading_listmgr/view_er_chktopic_view.php', $data);
	}

        public function view_req_chktopic()
	{

            $this->load->helper('url');

            $topic_code = null;
            $view_type = null;
            if(isset($_GET["topic_code"]))
            {
                 $topic_code = strtoupper(trim($_GET["topic_code"]));
            }
            if(isset($_GET["view_type"]))
            {
                 $view_type = strtoupper(trim($_GET["view_type"]));
            }

            $data = array("view_type"=>$view_type,
                          "topic_code"=>$topic_code);
            $this->load->view('reading_listmgr/view_req_chktopic_view.php', $data);
	}

        public function create_req_chktopic()
	{

            $this->load->helper('url');

            $topic_code = null;
            $view_type = null;
            if(isset($_GET["topic_code"]))
            {
                 $topic_code = strtoupper(trim($_GET["topic_code"]));
            }
            if(isset($_GET["view_type"]))
            {
                 $view_type = strtoupper(trim($_GET["view_type"]));
            }

            $data = array("view_type"=>$view_type,
                          "topic_code"=>$topic_code);
            $this->load->view('reading_listmgr/create_req_chktopic_view.php', $data);
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
         * Get the availabilities of From/ topic codes
         *
         * Get the number of activated eReadings for the availabilities.
         * This is on AJAX post call.
         */
        public function getavails()
	{
            $this->load->helper('url');
            #$this->load->helper('form');
            #$this->load->library('form_validation');

            if(!isset($_POST["from_topic_code"]) || !isset($_POST["action_type"]))
            {
                $error_data = array('error_info'=>'Invalid input topic code.');
                $this->load->view('reading_listmgr/fromto_avails_error_view', $error_data);
                return;
            }

            $from_topic_code = strtoupper(trim($_POST["from_topic_code"]));
            $action_type = (trim($_POST["action_type"]));
           # $to_topic_code = strtoupper(trim($_POST["to_topic_code"]));
            #log_message('error', $topic_code);
            #$topic_code = strtoupper(trim(set_value('topic_code')));
            #log_message('error', $topic_code);
            $this->load->model('reading_listmgr/listmgr_model');
            /*
            $from_avails = $this->listmgr_model->db_get_all_avails_by_topic($from_topic_code);
            #$from_avails = $this->listmgr_model->db_chk_avails_by_topic($from_topic_code);

            if($from_avails === false )
            {
                $error_data = array('error_info'=>'No availability with eReading list found for the topic code.');
                $this->load->view('reading_listmgr/fromto_avails_error_view', $error_data);
                #echo ('<br><div class="breadcrumbs"><b>Availabilities for rollover:</b></div><br>');
                #echo ('<p style="color:red">&nbsp;No availability found for From topic code.<p>');
                return;
            }
            */

            #$tmp_count = count($from_avails);
            #$from_avails[$tmp_count]['availability'] = $from_topic_code . '_OTHER';
            #$from_avails[$tmp_count]['in_equella'] = 'existing';
            /*
            $to_avails = $this->listmgr_model->db_chk_avails_by_topic($to_topic_code);

            if($to_avails === false )
            {
                $error_data = array('error_info'=>'No availability found for To topic code.');
                $this->load->view('reading_listmgr/fromto_avails_error_view', $error_data);
                return;
            }
            */

            #
            $from_topic_name = $this->listmgr_model->db_get_topicname($from_topic_code);
            /*
            $from_avails_num_readings = $this->listmgr_model->db_get_numof_readings_by_avail($from_avails);

            #Number of readings rolled over or activated in this system today.
            $from_avails_rollover_readings = $this->listmgr_model->db_get_numof_rollover_readings_by_avail($from_avails);

            $data = array("from_avails"=>$from_avails,
                            "from_topic_code"=>$from_topic_code,
                            "from_topic_name"=>$from_topic_name,
                            "from_avails_num_readings"=>$from_avails_num_readings,
                            "from_avails_rollover_readings"=>$from_avails_rollover_readings
                            #"avails_num_requests"=>$avails_num_requests
                         );
             $this->load->view('reading_listmgr/fromto_avails_view', $data);
            */
            $avails = $this->listmgr_model->db_get_avails_ercount_by_topic($from_topic_code);
            if($avails === false )
            {
                $error_data = array('error_info'=>'Either this is an invalid topic code or there are no availabilities for the topic code.');
                $this->load->view('reading_listmgr/fromto_avails_error_view', $error_data);
                #echo ('<br><div class="breadcrumbs"><b>Availabilities for rollover:</b></div><br>');
                #echo ('<p style="color:red">&nbsp;No availability found for From topic code.<p>');
                return;
            }

            $to_avails = $this->listmgr_model->db_get_active_avails_by_topic($from_topic_code);

            $_SESSION['listmgr_topic_code'] = $from_topic_code;

            $data = array("from_topic_code"=>$from_topic_code,
                          "from_topic_name"=>$from_topic_name,
                          "action_type"=>$action_type,
                          "from_avails"=>$avails,
                          "to_avails"=>$to_avails);
            $this->load->view('reading_listmgr/fromto_avails_view', $data);
        }

        /**
         * Get the availabilities of From/ topic codes
         *
         * Get the number of activated eReadings for the availabilities.
         * This is on AJAX post call.
         */
        public function getrequests()
	{
            $this->load->helper('url');
            #$this->load->helper('form');
            #$this->load->library('form_validation');

            if(!isset($_POST["from_topic_code"]) || !isset($_POST["action_type"]))
            {
                $error_data = array('error_info'=>'Invalid input topic code.');
                $this->load->view('reading_listmgr/fromto_avails_error_view', $error_data);
                return;
            }

            $from_topic_code = strtoupper(trim($_POST["from_topic_code"]));
            $action_type = (trim($_POST["action_type"]));
           # $to_topic_code = strtoupper(trim($_POST["to_topic_code"]));
            #log_message('error', $topic_code);
            #$topic_code = strtoupper(trim(set_value('topic_code')));
            #log_message('error', $topic_code);
            $this->load->model('reading_listmgr/listmgr_model');

            $from_avails = $this->listmgr_model->db_get_active_avails_by_topic($from_topic_code);
            #$from_avails = $this->listmgr_model->db_chk_avails_by_topic($from_topic_code);

            if($from_avails === false )
            {
                $error_data = array('error_info'=>'Requests can only be viewd/added for topic availabilities that are currently in progress, or have a future start date. Please check the Topic Code is entered correctly.');
                $this->load->view('reading_listmgr/fromto_avails_error_view', $error_data);
                #echo ('<br><div class="breadcrumbs"><b>Availabilities for rollover:</b></div><br>');
                #echo ('<p style="color:red">&nbsp;No availability found for From topic code.<p>');
                return;
            }
            $tmp_count = count($from_avails);
            $from_avails[$tmp_count]['availability'] = $from_topic_code . '_OTHER';
            $from_avails[$tmp_count]['in_equella'] = 'existing';
            /*
            $to_avails = $this->listmgr_model->db_chk_avails_by_topic($to_topic_code);

            if($to_avails === false )
            {
                $error_data = array('error_info'=>'No availability found for To topic code.');
                $this->load->view('reading_listmgr/fromto_avails_error_view', $error_data);
                return;
            }
            */
            $_SESSION['listmgr_topic_code'] = $from_topic_code;
            #
            $from_topic_name = $this->listmgr_model->db_get_topicname($from_topic_code);

            #$from_avails_num_readings = $this->listmgr_model->db_get_numof_readings_by_avail($from_avails);

            #Number of readings rolled over or activated in this system today.
            #$from_avails_rollover_readings = $this->listmgr_model->db_get_numof_rollover_readings_by_avail($from_avails);

            $avails_num_requests = $this->get_count_of_requests($from_topic_code, $from_avails);

            $data = array("from_avails"=>$from_avails,
                            "from_topic_code"=>$from_topic_code,
                            "from_topic_name"=>$from_topic_name,
                            "action_type"=>$action_type,
                            //"from_avails_num_readings"=>$from_avails_num_readings,
                            //"from_avails_rollover_readings"=>$from_avails_rollover_readings,
                            "avails_num_requests"=>$avails_num_requests
                         );
            $this->load->view('reading_listmgr/fromto_avails_requests_view', $data);
        }

        /**
         * Get the activated eReadings for the From availability
         * This is for Rollover
         * The eReading database is imported daily from Equella.
         */
        public function rollover_ereadings()
	{
            $this->load->helper('url');
            #$this->load->helper('form');
            #$this->load->library('form_validation');

            if(!isset($_POST["from_avail"]) || !isset($_POST["from_topic_code"]))
            {
                $error_data = array('heading'=>'Error', 'message'=>'Invalid input data');
                $this->load->view('reading_listmgr/showerror_view', $error_data);
                return;
            }

            $from_avail = (trim($_POST["from_avail"]));
            $from_topic_code = $_POST["from_topic_code"];

            #$to_avails = $_POST["to_avails"];
            #echo $from_avail;
            #if($from_avail != null)
            #{
            $this->load->model('reading_listmgr/listmgr_model');

            #$ereadings = $this->listmgr_model->db_get_readings_by_avail($from_avail);
            $ereadings = $this->listmgr_model->db_get_ereadings_usg_by_avail($from_avail);

            $is_tc = false;
            if(isset($_SESSION['rollover_privilege']) && $_SESSION['rollover_privilege'] == 'topic_coordinator')
            {
                /*$token = $this->generateToken();
                if($ereadings != false)
                {
                    for($i=0;$i<count($ereadings);$i++)
                       $ereadings[$i]['reading_link'] .= '&token=' . $token;
                }*/
                $is_tc = true;
            }

	    #### Generate a token in view_flex_reading for SSO when viewing a eReading
				    if($ereadings != false)
				    {
								for($i=0;$i<count($ereadings);$i++)
								{
								    $link = $ereadings[$i]['reading_link'];
								    $part1 = substr($link, 0, strpos($link, 'items')+6);
								    $ereadings[$i]['reading_link'] = str_replace($part1, 'view_flex_reading/items/', $link);

								}
				    }

            #echo'<pre>'; print_r($other_avails); echo'</pre>'; exit();

            ##$rollover_ereadings = $this->listmgr_model->db_get_rollover_readings_by_avail($from_avail);
            $from_avails[0]['availability'] = $from_avail;
            $num_rollover_ereadings = $this->listmgr_model->db_get_numof_rollover_readings_by_avail($from_avails);

            $avail_info = $this->listmgr_model->db_get_availability_info($from_avail);
            #}
            #else
            #{
            #    $ereadings = false;
            #    $num_rollover_ereadings[0]['num_readings'] = 0;
            #}
            #echo '<pre>';
            #print_r($ereadings);
            #echo '</pre>';
            #if($ereadings != false)
            #    $readings_count = count($ereadings);
            #$to_avails_count = count($to_avails);
            $to_avails = null;
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
            $data = array("from_avail"=>$from_avail, "ereadings"=>$ereadings, "from_topic_code"=>$from_topic_code, "avail_info"=>$avail_info,
                            "to_avails"=>$to_avails, "num_rollover_ereadings"=>$num_rollover_ereadings[0]['num_readings'],
                            "is_tc"=>$is_tc);
            $this->load->view('reading_listmgr/rollover_ereadings_view', $data);

        }

        /**
         * Get the activated eReadings for the availability, view only, no rollover
         *
         * The eReading database is imported daily from Equella.
         */
        public function view_ereadings()
	{
            $this->load->helper('url');
            #$this->load->helper('form');
            #$this->load->library('form_validation');
            if(isset($_POST["from_avail"]) )
            {
                $from_avail = (trim($_POST["from_avail"]));
                #$from_topic_code = $_POST["from_topic_code"];
            }
            else if (isset($_GET["from_avail"]) )
            {
                $from_avail = (trim($_GET["from_avail"]));
                #$from_topic_code = $_GET["from_topic_code"];
            }
            else
            {
                $error_data = array('heading'=>'Error', 'message'=>'Invalid input data');
                $this->load->view('reading_listmgr/showerror_view', $error_data);
                return;
            }

            if($from_avail == "")
            {
                $error_data = array('heading'=>'Error', 'message'=>'Invalid input data');
                $this->load->view('reading_listmgr/showerror_view', $error_data);
                return;
            }
            $from_topic_code = substr($from_avail, 0, strpos($from_avail,"_"));

            /*if(!isset($_POST["from_avail"]) || !isset($_POST["from_topic_code"]))
            {
                $error_data = array('heading'=>'Error', 'message'=>'Invalid input data');
                $this->load->view('reading_listmgr/showerror_view', $error_data);
                return;
            }

            $from_avail = (trim($_POST["from_avail"]));
            $from_topic_code = $_POST["from_topic_code"];*/

            #$to_avails = $_POST["to_avails"];
            #echo $from_avail;
            #if($from_avail != null)
            #{
            $this->load->model('reading_listmgr/listmgr_model');

            #$ereadings = $this->listmgr_model->db_get_readings_by_avail($from_avail);
            $ereadings = $this->listmgr_model->db_get_ereadings_usg_by_avail($from_avail);

            #echo'<pre>'; print_r($other_avails); echo'</pre>'; exit();

            ##$rollover_ereadings = $this->listmgr_model->db_get_rollover_readings_by_avail($from_avail);
            $from_avails[0]['availability'] = $from_avail;
            $num_rollover_ereadings = $this->listmgr_model->db_get_numof_rollover_readings_by_avail($from_avails);
            $rollover_today_readings = $this->listmgr_model->db_get_rollover_today_reading_for_avail($from_avail);
            $activate_today_readings = $this->listmgr_model->db_get_activate_today_reading_for_avail($from_avail);

            $is_tc = false;
            if(isset($_SESSION['rollover_privilege']) && $_SESSION['rollover_privilege'] == 'topic_coordinator')
            {
                /*$token = $this->generateToken();
                if($ereadings != false)
                {
                    for($i=0;$i<count($ereadings);$i++)
                       $ereadings[$i]['reading_link'] .= '&token=' . $token;
                }
                if($rollover_today_readings != false)
                {
                    for($i=0;$i<count($rollover_today_readings);$i++)
                       $rollover_today_readings[$i]['reading_link'] .= '&token=' . $token;
                }*/
                $is_tc = true;
            }

	    #### Generate a token in view_flex_reading for SSO when viewing a eReading
	    if($ereadings != false)
	    {
		for($i=0;$i<count($ereadings);$i++)
		{
		    $link = $ereadings[$i]['reading_link'];
		    $part1 = substr($link, 0, strpos($link, 'items')+6);
		    $ereadings[$i]['reading_link'] = str_replace($part1, 'view_flex_reading/items/', $link);

		}
	    }
	    if($rollover_today_readings != false)
	    {
		for($i=0;$i<count($rollover_today_readings);$i++)
		{
		    $link = $rollover_today_readings[$i]['reading_link'];
		    $part1 = substr($link, 0, strpos($link, 'items')+6);
		    $rollover_today_readings[$i]['reading_link'] = str_replace($part1, 'view_flex_reading/items/', $link);
		    #$rollover_today_readings[$i]['reading_link'] .= '&token=' . $token;

		}
	    }

            $avail_info = $this->listmgr_model->db_get_availability_info($from_avail);
            #}
            #else
            #{
            #    $ereadings = false;
            #    $num_rollover_ereadings[0]['num_readings'] = 0;
            #}

            #if($ereadings != false)
            #    $readings_count = count($ereadings);
            #$to_avails_count = count($to_avails);
            $to_avails = null;
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
            $data = array("from_avail"=>$from_avail, "ereadings"=>$ereadings, "avail_info"=>$avail_info, "from_topic_code"=>$from_topic_code,
                            "to_avails"=>$to_avails, "num_rollover_ereadings"=>$num_rollover_ereadings[0]['num_readings'],
                            "rollover_today_readings"=>$rollover_today_readings, "is_tc"=>$is_tc, "activate_today_readings"=>$activate_today_readings);
            $this->load->view('reading_listmgr/view_ereadings_view', $data);

        }

        /**
         * View the eReading in FLEX
         *
         * attach token if necessary
         */
        public function view_flex_reading($items='missed', $uuid='missed', $version='missed')
        {
            $this->load->helper('url');
            if(isset($_GET["attachment_uuid"]))
                $attachment_uuid = $_GET["attachment_uuid"];
            else
                $attachment_uuid = "";
            if($items != 'items' || strlen($uuid) != 36 || $version == 'missed' || strlen($attachment_uuid) != 36)
            {
                $error_data = array('error_info'=>'Invalid data.');
                $this->load->view('reading_listmgr/fromto_avails_error_view', $error_data);
                return;
            }

            $ci =& get_instance();
            $ci->load->config('flex');
            $institute_url = $ci->config->item('institute_url');
            $reading_link = $institute_url . "items/" . $uuid . "/" . $version . "/?.vi=file&attachment.uuid=" . $attachment_uuid;



            if(isset($_SESSION['rollover_privilege']) && $_SESSION['rollover_privilege'] == 'topic_coordinator')
            {
                $token = $this->generateToken();
                $reading_link .= '&token=' . $token;

            }

            redirect($reading_link);
        }

        /**
         * Get the activated eReadings for the availability, with URLs to readings
         *
         * no usage data
         */
        public function view_erlist_url()
	{
            $this->load->helper('url');
            #$this->load->helper('form');
            #$this->load->library('form_validation');
            if(isset($_POST["from_avail"]) )
            {
                $from_avail = (trim($_POST["from_avail"]));
                #$from_topic_code = $_POST["from_topic_code"];
            }
            else if (isset($_GET["from_avail"]) )
            {
                $from_avail = (trim($_GET["from_avail"]));
                #$from_topic_code = $_GET["from_topic_code"];
            }
            else
            {
                $error_data = array('heading'=>'Error', 'message'=>'Invalid input data');
                $this->load->view('reading_listmgr/showerror_view', $error_data);
                return;
            }

            if($from_avail == "")
            {
                $error_data = array('heading'=>'Error', 'message'=>'Invalid input data');
                $this->load->view('reading_listmgr/showerror_view', $error_data);
                return;
            }
            $from_topic_code = substr($from_avail, 0, strpos($from_avail,"_"));


            $this->load->model('reading_listmgr/listmgr_model');

            #$ereadings = $this->listmgr_model->db_get_readings_by_avail($from_avail);
            $ereadings = $this->listmgr_model->db_get_ereadings_usg_by_avail($from_avail);

            #echo'<pre>'; print_r($other_avails); echo'</pre>'; exit();

            ##$rollover_ereadings = $this->listmgr_model->db_get_rollover_readings_by_avail($from_avail);
            $from_avails[0]['availability'] = $from_avail;
            $num_rollover_ereadings = $this->listmgr_model->db_get_numof_rollover_readings_by_avail($from_avails);
            $rollover_today_readings = $this->listmgr_model->db_get_rollover_today_reading_for_avail($from_avail);

            #$avail_info = $this->listmgr_model->db_get_availability_info($from_avail);
            $avail_info = null;

            $to_avails = null;

            $data = array("from_avail"=>$from_avail, "ereadings"=>$ereadings, "avail_info"=>$avail_info, "from_topic_code"=>$from_topic_code,
                            "to_avails"=>$to_avails, "num_rollover_ereadings"=>$num_rollover_ereadings[0]['num_readings'],
                            "rollover_today_readings"=>$rollover_today_readings);
            $this->load->view('reading_listmgr/view_erlist_url_view', $data);

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

            $this->load->model('reading_listmgr/listmgr_model');

            $avail_date = $this->listmgr_model->db_get_avail_date($to_avail);
            if($avail_date === false)
            {
                $this->logger_rollover->error("Error: wrong availability data");
                #log_message('error', "Activation Error: " . $this->flexrest->error);
                $result['items_count'] = 1;
                $result['items']["status"][0] = "failed";
                $result['items']["readingidx"][0] = $reading_idxs[0];
                $result['items']["message"][0] = "Error: wrong availability data";
                $result['error_info'] = "Error: wrong availability data";
                echo json_encode($result);
                return;
            }
            /*#SOAP
            $ci =& get_instance();
            $ci->load->config('flex');
            $this->soapusername = $ci->config->item('soap_activation_username');
            $this->soappassword = $ci->config->item('soap_activation_password');
            $this->soapparams = array('username'=>$this->soapusername, 'password'=>$this->soappassword);
            $this->load->library('flexsoap/flexsoap',$this->soapparams);

            if(!$this->flexsoap->success)
            {
                #$errdata['message'] = $this->flexsoap->error_info;
                #echo $errdata['message'];
                #$this->load->view('sam/showerror_view', $errdata);
                $this->logger_rollover->error("Error: " . $this->flexsoap->error_info);
                $result['items_count'] = 1;
                $result['items']["status"][0] = "failed";
                $result['items']["readingidx"][0] = $reading_idxs[0];
                $result['items']["message"][0] = $this->flexsoap->error_info;
                $result['error_info'] = $this->flexsoap->error_info;
                echo json_encode($result);
                return;
            }*/
            #REST
            $this->load->library('flexrest/flexrest');
            $success = $this->flexrest->processClientCredentialToken();
            if(!$success)
            {
                $this->logger_rollover->error("Error: " . $this->flexrest->error);
                #log_message('error', "Activation Error: " . $this->flexrest->error);
                $result['items_count'] = 1;
                $result['items']["status"][0] = "failed";
                $result['items']["readingidx"][0] = $reading_idxs[0];
                $result['items']["message"][0] = $this->flexrest->error;
                $result['error_info'] = $this->flexrest->error;
                echo json_encode($result);
                return;
            }
            ##

            for($i=0;$i<$reading_count;$i++)
            {
                //log_message('error', "reaing idx is:".$reading_idxs[$i]);
                //log_message('error', "\nreaing is:".$readings[$i]);

                $reading_link = $readings[$i];
                $item_uuid = substr($reading_link, strpos($reading_link, 'items')+6, 36);
                $attachment_uuid = substr($reading_link, strpos($reading_link, 'uuid')+5, 36);
                $version = substr($reading_link, strpos($reading_link, 'items')+43, strpos($reading_link, '/?') - (strpos($reading_link, 'items')+43) );
                #log_message('error', "version is:".$version);

		####
		$ci =& get_instance();
		$ci->load->config('flex');
		$institute_url = $ci->config->item('institute_url');
		$reading_link = $institute_url . "items/" . $item_uuid . "/" . $version . "/?.vi=file&attachment.uuid=" . $attachment_uuid;

                #$this->load->model('reading_listmgr/listmgr_model');
                #this is a validation
                $data_valid = true;
                #$data_valid = $this->listmgr_model->db_chk_reading_for_avail($reading_link,$from_avail);
                if($data_valid == false)
                {
                    $this->logger_rollover->error("Error: data invalid, reading is not activated for from availability"
                            . "availability: " . $from_avail . ", reading: " . $reading_link);
                    $result['items_count'] = $i+1;
                    $result['items']["status"][$i] = "failed";
                    $result['items']["readingidx"][$i] = $reading_idxs[$i];
                    $result['items']["message"][$i] = "Error: data invalid";
                    $result['error_info'] = "Error: data invalid";
                    echo json_encode($result);
                    return;
                }

                ##$activated = $this->listmgr_model->db_chk_reading_for_avail($reading_link,$to_avail);
                $activated = $this->listmgr_model->db_chk_active_reading_for_avail($reading_link,$to_avail);
                $rollovered = $this->listmgr_model->db_chk_rollover_reading_for_avail($reading_link,$to_avail);

                if($activated == false && $rollovered == false)
                #if(false)####
                {
                    #$result['items']["status"][$i] = "failed";
                    #$result['items']["readingidx"][$i] = $reading_idxs[$i];
                    #$result['items']["message"][$i] = "Copywrite error! Missing item!" ;
                    #continue;

                    #REST
                    $activation_bean = null;
                    $activation_bean["type"] = "cal";
                    $activation_bean["item"]["uuid"] = $item_uuid;
                    $activation_bean["item"]["version"] = $version;
                    $activation_bean["attachment"] = $attachment_uuid;
                    #$activation_bean["course"]["uuid"] = "9c27caa4-fc55-4c34-a8fc-c63303585532";
                    $activation_bean["course"]["code"] = $to_avail;
                    $activation_bean["from"] = substr($avail_date["active_from"], 0, 10) . "T00:00:01";
                    $activation_bean["until"] = substr($avail_date["active_to"], 0, 10) . "T23:59:59";
                    if( date("I", strtotime($activation_bean["from"])) == 1 )
                        $activation_bean["from"] .= "+10:30";
                    else
                        $activation_bean["from"] .= "+09:30";
                    if( date("I", strtotime($activation_bean["until"])) == 1 )
                        $activation_bean["until"] .= "+10:30";
                    else
                        $activation_bean["until"] .= "+09:30";

                    $success = $this->flexrest->createActivation($activation_bean, $response1);
                    if(!$success)
                    {
                        $this->logger_rollover->error("Error: " . $this->flexrest->error);
                        $this->logger_rollover->error("Rollover Failed with user: " . $user . ", from: " . $from_avail . " to " . $to_avail . ", index: " . $reading_idxs[$i] . ", reading link: " . $reading_link);
                        ##$result['items_count'] = $i+1;
                        #log_message('error', 'eReading list management create_activation failed' . ', error: ' . $this->flexrest->error);
                        $result['items']["status"][$i] = "failed";
                        $result['items']["readingidx"][$i] = $reading_idxs[$i];
                        ##$result['error_info'] = $this->flexsoap->error_info;
                        ##echo json_encode($result);
                        ##return;
                        $result['items']["message"][$i] = $this->flexrest->error;
                        continue;
                    }##

                    /*#SOAP
                    $this->flexsoap->activateItemAttachments($item_uuid, intval($version), $to_avail, array($attachment_uuid));
                    if(!$this->flexsoap->success)
                    {
                        #$errdata['message'] = $this->flexsoap->error_info;
                        #echo $errdata['message'];
                        #$this->load->view('sam/showerror_view', $errdata);
                        $this->logger_rollover->error("Error: " . $this->flexsoap->error_info);
                        $this->logger_rollover->error("Rollover Failed with user: " . $user . ", from: " . $from_avail . " to " . $to_avail . ", index: " . $reading_idxs[$i] . ", reading link: " . $reading_link);
                        ##$result['items_count'] = $i+1;
                        $result['items']["status"][$i] = "failed";
                        $result['items']["readingidx"][$i] = $reading_idxs[$i];
                        ##$result['error_info'] = $this->flexsoap->error_info;
                        ##echo json_encode($result);
                        ##return;
                        $result['items']["message"][$i] = $this->flexsoap->error_info;
                        continue;
                    }*/

                    $this->listmgr_model->db_ins_rollover_reading_for_avail($reading_link,$to_avail,$user,$from_avail);

                    $result['items']["readingidx"][$i] = $reading_idxs[$i];
                    $result['items']["status"][$i] = "activated";
                    $result['items']["message"][$i] = "";

                    $this->logger_rollover->info("Rollover Success with user: " . $user . ", from: " . $from_avail . " to " . $to_avail . ", index: " . $reading_idxs[$i] . ", reading link: " . $reading_link);

                }
                else
                {
                    $result['items']["readingidx"][$i] = $reading_idxs[$i];
                    $result['items']["status"][$i] = "duplication";
                    $result['items']["message"][$i] = "";

                    $this->logger_rollover->info("Rollover Duplication with user: " . $user . ", from: " . $from_avail . " to " . $to_avail . ", index: " . $reading_idxs[$i] . ", reading link: " . $reading_link);

                    /*if($reading_idxs[$i] == 8) #### for testing
                    {

                        $result['items']["status"][$i] = "failed";
                        $result['error_info'] = "Soap fault: Network issue, unable to connect to host";
                        echo json_encode($result);
                        return;
                    }*/
                }
                //log_message('error', "uuid: " . $item_uuid . "   attachment: " . $attachment_uuid);
            }
            //log_message('error', json_encode($result));
            $result['satus'] = "success";
            $result['error_info'] = "";
            echo json_encode($result);

        }


        /**
         * On FLEX item summary page there is a link "Activate via Flextra tool",
         * this is the function to activate the eReading for selected availabilities.
         *
         * Show activation interface.
         */
        public function activate_reading()
	{
            if(!isset($_SESSION['rollover_privilege']) || ($_SESSION['rollover_privilege']!='contributor' && $_SESSION['rollover_privilege']!='administrator'))
            {
                $error_data = array('heading'=>'Error', 'message'=>"Sorry you don't have the required privilege.");
                $this->load->view('reading_listmgr/showerror_view', $error_data);
                return;
            }

            if(!isset($_GET["uuid"]) || !isset($_GET["version"]) || !isset($_GET["attachment"]) || !isset($_GET["item_name"]))
            {
                $error_data = array('heading'=>'Error', 'message'=>'Invalid Request');
                $this->load->view('reading_listmgr/showerror_view', $error_data);
                return;
            }
            $uuid = $_GET["uuid"];
            $version = $_GET["version"];
            $attachment = $_GET["attachment"];
            $item_name = $_GET["item_name"];

            if(strlen($uuid) != 36 || !is_numeric($version) || strlen($attachment) != 36 )
            {
                $error_data = array('heading'=>'Error', 'message'=>'Invalid Request');
                $this->load->view('reading_listmgr/showerror_view', $error_data);
                return;
            }

            $data['uuid'] = $uuid;
            $data['version'] = $version;
            $data['attachment'] = $attachment;
            $data['item_name'] = $item_name;

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
            $this->load->view('reading_listmgr/activate_reading_view.php', $data);
	}

        /**
         * Get the availabilities for the specified (To, Target) topic code.
         *
         * This is on AJAX post call. Used to activate one eReading for availabilities.
         */
        public function activate_reading_get_avails()
	{
            #$uuid = $_POST["uuid"];
            #$version = $_POST["version"];
            #$attachment = $_POST["attachment"];

            $this->load->helper('url');
            #$this->load->helper('form');
            #$this->load->library('form_validation');
            if(!isset($_POST["topic_code"]))
            {
                $error_data = array('error_info'=>'Invalid input topic code.');
                $this->load->view('reading_listmgr/toavails_error_view', $error_data);
                return;
            }
            $topic_code = strtoupper(trim($_POST["topic_code"]));
            #$to_topic_code = strtoupper(trim($_POST["to_topic_code"]));
            #log_message('error', $topic_code);
            #$topic_code = strtoupper(trim(set_value('topic_code')));
            #log_message('error', $topic_code);
            $this->load->model('reading_listmgr/listmgr_model');

            #$availabilities = $this->listmgr_model->db_chk_to_avails_by_topic($topic_code);
            $availabilities = $this->listmgr_model->db_get_active_avails_by_topic($topic_code);

            $topic_name = $this->listmgr_model->db_get_topicname($topic_code);

            if($availabilities === false )
            {
                $error_data = array('error_info'=>'eReadings can only be activated for topic availabilities that are currently in progress, or have a future start date. Please check the Topic Code is entered correctly.');
                $this->load->view('reading_listmgr/toavails_error_view', $error_data);
                return;
            }
            #$_SESSION['listmgr_topic_code'] = $topic_code;
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
            $this->load->view('reading_listmgr/activate_reading_avails_view', $data);
        }

        /**
         * Get the availabilities for the specified (To, Target) topic code.
         *
         * This is on AJAX post call.
         */
        public function get_toavailabilities()
	{
            #$uuid = $_POST["uuid"];
            #$version = $_POST["version"];
            #$attachment = $_POST["attachment"];

            $this->load->helper('url');
            #$this->load->helper('form');
            #$this->load->library('form_validation');
            if(!isset($_POST["topic_code"]))
            {
                $error_data = array('error_info'=>'Invalid input topic code.');
                $this->load->view('reading_listmgr/toavails_error_view', $error_data);
                return;
            }
            $topic_code = strtoupper(trim($_POST["topic_code"]));
            #$to_topic_code = strtoupper(trim($_POST["to_topic_code"]));
            #log_message('error', $topic_code);
            #$topic_code = strtoupper(trim(set_value('topic_code')));
            #log_message('error', $topic_code);
            $this->load->model('reading_listmgr/listmgr_model');

            #$availabilities = $this->listmgr_model->db_chk_to_avails_by_topic($topic_code);
            $availabilities = $this->listmgr_model->db_get_active_avails_by_topic($topic_code);

            $topic_name = $this->listmgr_model->db_get_topicname($topic_code);

            if($availabilities === false )
            {
                $error_data = array('error_info'=>'eReadings can only be activated for topic availabilities that are currently in progress, or have a future start date. Please check the Topic Code is entered correctly.');
                $this->load->view('reading_listmgr/toavails_error_view', $error_data);
                return;
            }
            $_SESSION['listmgr_topic_code'] = $topic_code;
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
            $this->load->view('reading_listmgr/toavailability_view', $data);
        }

        /**
         * Check the specified (To) topic availabilities, if it is not in Flex
         * then add it to Flex via soap.
         *
         * This is on AJAX post call.
         */
        public function chk_to_availabilities($ajax=true,$avails_param=null)
	{

            #$this->load->helper('url');
            if($ajax)
            {
                if(!isset($_POST["to_avails"]))
                {
                    $result["result_stat"] = "failed";
                    $result['error_info'] = "Invalid input topic code.";
                    echo json_encode($result);
                    return;
                }
                $to_avails = ($_POST["to_avails"]);
                }
            else
            {
                $to_avails = $avails_param;

                $result['error_info'] = '';
                $result['courses_added'] = null;
            }
            #$to_topic_code = strtoupper(trim($_POST["to_topic_code"]));
            #log_message('error', $topic_code);
            #$topic_code = strtoupper(trim(set_value('topic_code')));
            #log_message('error', $topic_code);
            $this->load->model('reading_listmgr/listmgr_model');

            $course = $this->listmgr_model->db_chk_to_availabilities($to_avails);
            #$topic_name = $this->listmgr_model->db_get_topicname($topic_code);
            $result['count_courses_added'] = $course["count"];
            /*
            if($course === false )
            {
                $this->logger_rollover->error("Error: Failed to add the topic availability, course===false");
                $result["result_stat"] = "failed";
                $result['error_info'] = "Error: Failed to add the topic availability.";
                echo json_encode($result);
                return;
            }
            */
            #$course["count"] = 0;####
            if($course["count"] === 0 )
            {
                $result["result_stat"] = "success";
                $result['error_info'] = "";
                if($ajax)
                {
                    echo json_encode($result);
                    return;
                }
                else
                {
                    return $result;
                }
            }


            $this->load->library('flexrest/flexrest');
            $success = $this->flexrest->processClientCredentialToken();
            if(!$success)
            {
                $this->logger_rollover->error("Error: " . $this->flexrest->error);
                log_message('error', $this->flexrest->error);
                $result["result_stat"] = "failed";
                $result['error_info'] = $this->flexrest->error;
                #echo json_encode($result);
                #return;
                if($ajax)
                {
                    echo json_encode($result);
                    return;
                }
                else
                {
                    return $result;
                }
            }
            for($i=0; $i<$course["count"]; $i++)
            {
                $onecourse = $course["array"][$i];
                $course_bean = null;
                $course_bean["code"] = $onecourse["code"];
                $course_bean["name"] = $onecourse["name"];
                $course_bean["description"] = $onecourse["description"];
                $course_bean["students"] = $onecourse["students"];
                $course_bean["type"] = $onecourse["type"];
                $course_bean["citation"] = "Generic";
                $course_bean["departmentName"] = $onecourse["departmentname"];
                $course_bean["from"] = substr($onecourse["start"], 0, 10);
                $course_bean["until"] = substr($onecourse["end"], 0, 10);
                /*
                $course_bean["from"] = substr($onecourse["start"], 0, 10) . "T00:00:01";
                $course_bean["until"] = substr($onecourse["end"], 0, 10) . "T23:59:59";

                if( date("I", strtotime($course_bean["from"])) == 1 )
                    $course_bean["from"] .= "+10:30";
                else
                    $course_bean["from"] .= "+09:30";
                if( date("I", strtotime($course_bean["until"])) == 1 )
                    $course_bean["until"] .= "+10:30";
                else
                    $course_bean["until"] .= "+09:30";
                #log_message('error', $course_bean["from"]);
                */
                $success = $this->flexrest->createCourse($course_bean, $response1);

                if(!$success)
                {
                    if(strpos($this->flexrest->error, "Course code must be unique") === false)
                    {
                        $this->logger_rollover->error("Error: " . $this->flexrest->error);
                        $result["result_stat"] = "failed";
                        $result['error_info'] = $this->flexrest->error;
                        log_message('error', 'Adding course to Flex: ' . $course_bean["code"] . ", Error: " . $this->flexrest->error);
                        #echo json_encode($result);
                        #return;
                        if($ajax)
                        {
                            echo json_encode($result);
                            return;
                        }
                        else
                        {
                            return $result;
                        }
                    }
                    else
                    {
                        $this->logger_activation->error("Adding course to Flex but it is already in Flex. Course code: " . $course_bean["code"]);
                        log_message("error", "Adding course to Flex but it is already in Flex. Course code: " . $course_bean["code"]);
                    }
                }
                if($ajax==false)
                    $result['courses_added'] .= "<br>- " . $course_bean["code"];
                $this->logger_activation->error("Added course to Flex: " . $course_bean["code"]);
                $db_course["count"] = 1;
                $db_course["array"][0] = $onecourse;
                $this->listmgr_model->db_ins_readings_avails($db_course);
            }

            /* SOAP way to add course
            $ci =& get_instance();
            $ci->load->config('flex');
            $soapusername = $ci->config->item('soap_coursemgt_username');
            $soappassword = $ci->config->item('soap_coursemgt_password');
            $soapparams = array('username'=>$soapusername, 'password'=>$soappassword);
            $this->load->library('flexsoap/flexsoap',$soapparams);
            if(!$this->flexsoap->success)
            {
                $this->logger_rollover->error("Error: " . $this->flexsoap->error_info);
                $result["result_stat"] = "failed";
                $result['error_info'] = $this->flexsoap->error_info;
                #echo json_encode($result);
                #return;
                if($ajax)
                {
                    echo json_encode($result);
                    return;
                }
                else
                {
                    return $result;
                }
            }

            $this->flexsoap->bulkImportCourses($course["csv"]);
            if(!$this->flexsoap->success)
            {
                $this->logger_rollover->error("Error: " . $this->flexsoap->error_info);
                $result["result_stat"] = "failed";
                $result['error_info'] = $this->flexsoap->error_info;
                #echo json_encode($result);
                #return;
                if($ajax)
                {
                    echo json_encode($result);
                    return;
                }
                else
                {
                    return $result;
                }
            }

            $this->listmgr_model->db_ins_readings_avails($course);
            #$data = array("topic_code"=>$topic_code, "availabilities"=>$availabilities, "topic_name"=>$topic_name);
            #$this->load->view('reading_listmgr/availability_view', $data);
            */
            $result["result_stat"] = "success";
            $result['error_info'] = "";

            #echo json_encode($result);
            if($ajax)
            {
                echo json_encode($result);
                return;
            }
            else
            {
                return $result;
            }
        }

        /**
         * On FLEX item summary page there is a link "Activate via Flextra tool",
         * this is the function to activate the eReading for selected availabilities.
         *
         * Show activation results.
         */

        public function activate_reading_res()
	{
            if(!isset($_SESSION['rollover_privilege']) || ($_SESSION['rollover_privilege']!='contributor' && $_SESSION['rollover_privilege']!='administrator'))
            {
                $error_data = array('heading'=>'Error', 'message'=>"Sorry you don't have the required privilege.");
                $this->load->view('reading_listmgr/showerror_view', $error_data);
                return;
            }

            $this->load->helper('url');
            //sleep(1);
            //log_message('error', implode($readings, ","));
            if(!isset($_POST["to_avails"]) || !isset($_POST["uuid"]) || !isset($_POST["version"]) || !isset($_POST["attachment"]) || !isset($_POST["item_name"]))
            {
                $error_data = array('heading'=>'Error', 'message'=>'Invalid input data');
                $this->load->view('reading_listmgr/showerror_view', $error_data);
                return;
            }

            #$from_avail = ($_POST["from_avail"]);
            $to_avails = ($_POST["to_avails"]);
            $item_uuid = $_POST["uuid"];
            $version = $_POST["version"];
            $attachment_uuid = $_POST["attachment"];
            $item_name = $_POST["item_name"];
            $avail_count = count($to_avails);

            $suppress_dup_chk = false;
            if(isset($_POST["suppress_dup_chk"]) && $_POST["suppress_dup_chk"] == '1')
                $suppress_dup_chk = true;
            #log_message('error', "reaing_count is:".$reading_count);

            #$result['to_avail'] = $to_avail;
            #$result['items_count'] = $reading_count;
            $ci =& get_instance();
            $ci->load->config('flex');
            $institute_url = $ci->config->item('institute_url');
            $reading_link = $institute_url . "items/" . $item_uuid . "/" . $version . "/?.vi=file&attachment.uuid=" . $attachment_uuid;
            $activate_link = "activate_reading?uuid=" . $item_uuid . "&version=" . $version . "&attachment=" . $attachment_uuid . "&item_name=" . htmlentities($item_name);
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
            $result['courses_added'] = null;

            #REST
            $this->load->library('flexrest/flexrest');
            $success = $this->flexrest->processClientCredentialToken();
            if(!$success)
            {
                $this->logger_activation->error("Error: " . $this->flexrest->error);
                $error_data = array('heading'=>'Error', 'message'=>$this->flexrest->error);
                $this->load->view('reading_listmgr/showerror_view', $error_data);
                return;
            }
            /* #SOAP
            $this->soapusername = $ci->config->item('soap_activation_username');
            $this->soappassword = $ci->config->item('soap_activation_password');
            $this->soapparams = array('username'=>$this->soapusername, 'password'=>$this->soappassword);

            $this->load->library('flexsoap/flexsoap',$this->soapparams);

            if(!$this->flexsoap->success)
            {
                $this->logger_activation->error("Error: " . $this->flexsoap->error_info);
                $result["status"][0] = "Failed";
                $result['error_info'] = $this->flexsoap->error_info;
                $data = array("to_avails"=>$to_avails,"result"=>$result);
                $this->load->view('reading_activate/readingfortopic_res_view', $data);
                return;
            }*/

            #$this->load->model('reading_rollover/rollover_model');
            $this->load->model('reading_listmgr/listmgr_model');

            #Add new courses to FLEX.
            $add_couse_res = $this->chk_to_availabilities(false,$to_avails);
            $result['error_info'] = $add_couse_res['error_info'];
            $result['courses_added'] = $add_couse_res['courses_added'];
            /*
            $course = $this->listmgr_model->db_chk_to_availabilities($to_avails);
            if($course["count"] != 0 )
            {
                for($i=0; $i<$course["count"]; $i++)
                {
                    $onecourse = $course["array"][$i];
                    $course_bean = null;
                    $course_bean["code"] = $onecourse["code"];
                    $course_bean["name"] = $onecourse["name"];
                    $course_bean["description"] = $onecourse["description"];
                    $course_bean["students"] = $onecourse["students"];
                    $course_bean["type"] = $onecourse["type"];
                    $course_bean["citation"] = "Generic";
                    $course_bean["departmentName"] = $onecourse["departmentname"];
                    $course_bean["from"] = substr($onecourse["start"], 0, 10);
                    $course_bean["until"] = substr($onecourse["end"], 0, 10);

                    $success = $this->flexrest->createCourse($course_bean, $response1);

                    if(!$success)
                    {
                        if(strpos($this->flexrest->error, "Course code must be unique") === false)
                        {
                            $this->logger_activation->error("Error: " . $this->flexrest->error);
                            #$result["status"][0] = "Failed";
                            $result['error_info'] = $this->flexrest->error;
                            break;
                        }
                        else
                        {
                            log_message("error", "Adding course to Flex but it is already in Flex. Course code: " . $course_bean["code"]);
                        }
                    }

                    $courses_added .= "<br>- " . $onecourse["code"];
                    $db_course["count"] = 1;
                    $db_course["array"][0] = $onecourse;
                    $this->listmgr_model->db_ins_readings_avails($db_course);
                }
            }*/

            if($result['error_info'] == '')
            {
            for($i=0;$i<$avail_count;$i++)
            {

                $to_avail = $to_avails[$i];
                $avail_date = $this->listmgr_model->db_get_avail_date($to_avail);
                #$this->load->model('reading_rollover/rollover_model');
                $activated = false;
                $rollovered = false;
                if($suppress_dup_chk == false)
                {
                    ##$activated = $this->rollover_model->db_chk_reading_for_avail($reading_link,$to_avail);
                    $activated = $this->listmgr_model->db_chk_active_reading_for_avail($reading_link,$to_avail);
                    $rollovered = $this->listmgr_model->db_chk_rollover_reading_for_avail($reading_link,$to_avail);
                }
                if($suppress_dup_chk == true || ($activated == false && $rollovered == false))
                //if($activated == false)
                {

                    #Activate eReading via REST.
                    $activation_bean = null;
                    $activation_bean["type"] = "cal";
                    $activation_bean["item"]["uuid"] = $item_uuid;
                    $activation_bean["item"]["version"] = $version;
                    $activation_bean["attachment"] = $attachment_uuid;
                    #$activation_bean["course"]["uuid"] = "9c27caa4-fc55-4c34-a8fc-c63303585532";
                    $activation_bean["course"]["code"] = $to_avail;
                    $activation_bean["from"] = substr($avail_date["active_from"], 0, 10) . "T00:00:01";
                    $activation_bean["until"] = substr($avail_date["active_to"], 0, 10) . "T23:59:59";
                    if( date("I", strtotime($activation_bean["from"])) == 1 )
                        $activation_bean["from"] .= "+10:30";
                    else
                        $activation_bean["from"] .= "+09:30";
                    if( date("I", strtotime($activation_bean["until"])) == 1 )
                        $activation_bean["until"] .= "+10:30";
                    else
                        $activation_bean["until"] .= "+09:30";

                    $success = $this->flexrest->createActivation($activation_bean, $response1);
                    if(!$success)
                    {
                        $this->logger_activation->error("Error: " . $this->flexrest->error);
                        $result["status"][$i] = "Failed";
                        $result['error_info'] = $this->flexrest->error;
                        break;
                    }
                    ##
                    /*# SOAP way of activation
                    $this->flexsoap->activateItemAttachments($item_uuid, intval($version), $to_avail, array($attachment_uuid));
                    if(!$this->flexsoap->success)
                    {
                        $this->logger_activation->error("Error: " . $this->flexsoap->error_info);
                        $result["status"][$i] = "Failed";
                        $result['error_info'] = $this->flexsoap->error_info;
                        break;
                    }*/

                    $this->listmgr_model->db_ins_rollover_reading_for_avail($reading_link,$to_avail,$user);

                    $result["status"][$i] = "Success";

                    $this->logger_activation->info("Activation Successful with user: " . $user . ", availability: " . $to_avail . ", reading link: " . $reading_link);

                }
                else
                {
                    $result["status"][$i] = "Duplication";

                    $this->logger_activation->info("Activation Duplicate with user: " . $user . ", availability: " . $to_avail . ", reading link: " . $reading_link);

                    /*if($i == 1113) #### for testing
                    {

                        $result["status"][$i] = "Failed";
                        $result['error_info'] = "Soap fault: Network issue, unable to connect to host";
                        #echo json_encode($result);
                        #return;
                    }*/
                }
                //log_message('error', "uuid: " . $item_uuid . "   attachment: " . $attachment_uuid);
            }
            }
            $data = array("to_avails"=>$to_avails, "result"=>$result, "reading_link"=>$reading_link,
                    "activate_link" => $activate_link, "item_name"=>$item_name);
            $this->load->view('reading_listmgr/activate_reading_res_view', $data);

        }

        /**
         * Show the form to create new request
         *
         *
         */
        public function create_request()
	{
            if(!isset($_POST["avails_for_new_req"]) || !isset($_POST["topic_code"]))
            {
                $error_data = array('heading'=>'Error', 'message'=>'Invalid Request');
                $this->load->view('reading_listmgr/showerror_view', $error_data);
                return;
            }
            /*if(!isset($_POST["avails_for_new_req"]))
            {
                ####
                #return;
                $avails_for_new_req = null;
            }
            else
            {
                $avails_for_new_req = ($_POST["avails_for_new_req"]);
            }
            */
            $avails_for_new_req = ($_POST["avails_for_new_req"]);
            $topic_code = ($_POST["topic_code"]);

            $date_neededby = new DateTime();
            date_add($date_neededby, date_interval_create_from_date_string('28 days'));

            $data = array("avails_for_new_req"=>$avails_for_new_req, "topic_code"=>$topic_code, "date_neededby"=>$date_neededby->format('Y-m-d'));
            $this->load->view('reading_listmgr/create_request_view', $data);
        }

        /**
         * Contribute the request to Equella via REST
         *
         *
         */
        public function create_request_res()
	{
            #sleep(1);
            $result['status'] = "failed";
            $result['error_info'] = "";
            $errdata['heading'] = 'Internal Error';

            if( !isset($_POST["editor1"]) || !isset($_POST["topic_code"]) || !isset($_POST["avails_for_new_req"]) ||
                    !isset($_POST["needed_by_date"]) || !isset($_POST["request_subject"]) )
            {
                $errdata['message'] = 'Invalid input data.';
                log_message('error', 'Invalid request to create new eReading list management request' . ', error: missing post variable.');
                #$this->load->view('reading_listmgr/showerror_view', $errdata);
                $result['error_info'] = $errdata['message'];
                echo json_encode($result);
                return;
            }
            $request_content = $_POST["editor1"];
            #$to_topic_code = $_POST["to_topic_code"];
            $to_topic_code = $_POST["topic_code"];
            $to_avails = $_POST["avails_for_new_req"];
            $needed_by = $_POST["needed_by_date"];
            $request_subject = $_POST["request_subject"];
            #echo '111<br>';
            if($to_avails == null)
                $availabilities = null;
            else
                $availabilities = explode(',', $to_avails);

            #$to_topic_code = substr($availabilities[0], 0, strpos($availabilities[0],"_"));

            /*
            echo("<pre>==========content of to_topic_code:<br>");
            print_r($to_topic_code);echo("</pre>");
            echo("<pre>==========content of availabilities:<br>");
            print_r($availabilities);echo("</pre>");
            echo("<pre>==========content of request_content:<br>");
            print_r($request_content);echo("</pre>");
            exit();
            */

            $ci =& get_instance();
            $ci->load->config('flex');
            $collection_id = $ci->config->item('erlistmgt_collection');

            $this->load->model('reading_listmgr/listmgr_model');
            $school_name = $this->listmgr_model->db_get_orgname($to_topic_code);
            if($school_name === false)
            {
                $errdata['message'] = 'Failed to get the school name of selected topic: ' . $to_topic_code;
                log_message('error', 'Failed to create new eReading list management request: ' . ', error: ' . $errdata['message']);
                #$this->load->view('reading_listmgr/showerror_view', $errdata);
                $result['error_info'] = $this->flexrest->error;
                echo json_encode($result);
                return;
            }

            #Check wether there are topic availabilities that are not in FLEX.
            #### need to handle the special availability TOPIC_OTHER
            /*
            if($availabilities != null)
            {
                $ret = $this->chk_to_availabilities(false, $availabilities);
                #log_message('error', 'New availabilities needed to be added to FLEX: ' . $ret['count_courses_added']);
                if($ret["result_stat"] == "failed")
                {
                    $errdata['message'] = $ret['error_info'];
                    log_message('error', 'Failed to create new eReading list management request' . ', error: ' . $errdata['message']);
                    #$this->load->view('reading_listmgr/showerror_view', $errdata);
                    $result['error_info'] = $errdata['message'];
                    echo json_encode($result);
                    return;
                }
            }
            */

            $this->load->library('flexrest/flexrest');
            $success = $this->flexrest->processClientCredentialToken();
            if(!$success)
            {
                $errdata['message'] = $this->flexrest->error;
                log_message('error', 'Failed to create new eReading list management request' . ', error: ' . $errdata['message']);
                #$this->load->view('reading_listmgr/showerror_view', $errdata);
                $result['error_info'] = $this->flexrest->error;
                echo json_encode($result);
                return;
            }

            $item_bean["collection"]["uuid"] = $collection_id;

            #$dom = new DOMDocument('1.0');
            #log_message('error', 'new dom: ' . $dom->saveXML());

            $now = date("Y-m-d H:i:s");
            $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => '<xml><item></item></xml>'));
            $request_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/admin/to_do/requests/request");
            $request_content_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/admin/to_do/requests/request/content");
            #$request_content_node->nodeValue = $request_content;

            $this->xmlwrapper->createTextNode($request_content_node, $request_content);
            #$request_content_node->appendChild($text_content);

            $request_note_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/admin/to_do/note");
            $this->xmlwrapper->createTextNode($request_note_node, $request_content);

            $request_date_added_node = $this->xmlwrapper->createAttribute($request_node, "date_added");
            $request_date_added_node->nodeValue = $now;
            $request_status_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/admin/to_do/status");
            $request_status_node->nodeValue = 'New request';
            $request_name_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/admin/to_do/name");
            $request_name_node->nodeValue = str_replace('&', 'and', $request_subject);
            #$this->xmlwrapper->createTextNode($request_name_node, $request_subject);

            $request_added_by_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/admin/to_do/added_by");
            $request_addedby_fan_node = $this->xmlwrapper->createAttribute($request_added_by_node, "fan");
            $request_addedby_fan_node->nodeValue = $_SERVER['REMOTE_USER'];
            $request_neededby_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/admin/to_do/needed_by");
            $request_neededby_node->nodeValue = $needed_by;

            $date_added_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/admin/to_do/date_added");
            $date_added_node->nodeValue = $now;

            $topic_code_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/topics/topic/code");
            $topic_code_node->nodeValue = $to_topic_code;
            $topic_school_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/topics/topic/school");
            $topic_school_node->nodeValue = str_replace('&', 'and', $school_name);
            $item_name_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/itembody/name");
            $item_name_node->nodeValue = str_replace('&', 'and', $request_subject);
            #$this->xmlwrapper->createTextNode($item_name_node, $request_subject);
            $to_avails_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/avails");

            if($availabilities != null)
            {
                foreach($availabilities as $to_avail)
                {
                    #log_message('error', "to_avail: " . $to_avail);
                    $to_avail_node = $this->xmlwrapper->createNode($to_avails_node, "avail");
                    $to_avail_ref_node = $this->xmlwrapper->createAttribute($to_avail_node, "avail_ref");
                    $to_avail_ref_node->nodeValue = $to_avail;
                }
            }
            $item_bean['metadata'] = $this->xmlwrapper->__toString();
            #$item_bean['metadata'] = str_replace('&nbsp;', '&amp;nbsp;', $item_bean['metadata']);
            #echo("<pre>==========content of item_bean:<br>");
            #print_r($item_bean);echo("</pre>");

            $success = $this->flexrest->createItem($item_bean, $response1);
            if(!$success)
            {
                $errdata['message'] = $this->flexrest->error;
                log_message('error', 'eReading list management createItem failed' . ', error: ' . $errdata['message']);
                #log_message('error', 'Metadata: ' . $item_bean['metadata']);
                #$this->load->view('reading_listmgr/showerror_view', $errdata);
                $result['error_info'] = $this->flexrest->error;
                echo json_encode($result);
                return;
            }

            #echo("<pre>==========response of createItem:<br>");
            #print_r($response1); echo("</pre>");

            if(!isset($response1['headers']['location']))
            {
                $errdata['message'] = 'No Location header in createItem response.';
                log_message('error', 'eReading list management createItem failed' . ', error: ' . $errdata['message']);
                #$this->load->view('reading_listmgr/showerror_view', $errdata);
                $result['error_info'] = $errdata['message'];
                echo json_encode($result);
                return;
            }
            $location = $response1['headers']['location'];
            $institute_url = $ci->config->item('institute_url');
            $location1 = substr($location, strpos($location, 'item')+4);
            $location1 = $institute_url . 'items' . $location1;
            #$location1 = str_replace('api/item', 'items', $location);
            #log_message('error', $location1);
            $discipline = substr($to_topic_code, 0, 4);
            $email_subject = $ci->config->item('listmgr_email_request_subject');
            $this->email_req_created($discipline, $location1, $email_subject, $to_topic_code);
            #log_message('error', 'after calling email_req_created');

            $uuid = substr($location, strpos($location, 'item')+5, 36);
            $version = substr($location, strpos($location, 'item')+42, (strlen($location)-1-(strpos($location, 'item')+42)));
            #log_message('error', 'location: ' . $location);
            #log_message('error', 'uuid: ' . $uuid);
            #log_message('error', 'version: ' . $version);
            $result['status'] = "success";
            $result['uuid'] = $uuid;
            $result['version'] = $version;
            echo json_encode($result);
            /*
            $data = array("avails_for_new_req"=>$availabilities,"editor1"=>$request_content,
                  "result_status"=>$result['status'], "error_info"=>$result['error_info']);
            $this->load->view('reading_listmgr/create_request_view', $data);
            */

        }

        public function get_count_of_requests($topic_code, $availabilities)
        {
            $ci =& get_instance();
            $ci->load->config('flex');
            $collection_id = $ci->config->item('erlistmgt_collection');
            #echo '<pre>'; print_r($availabilities);echo '</pre>';exit();
            $this->load->library('flexrest/flexrest');
            $success = $this->flexrest->processClientCredentialToken();
            if(!$success)
            {
                $errdata['message'] = $this->flexrest->error;
                log_message('error', 'Failed to get the exiting requests: ' . $errdata['message']);
                $this->load->view('reading_listmgr/showerror_view', $errdata);
                return;
            }

            $ci =& get_instance();
            $ci->load->config('flex');
            $erlistmgt_collection = $ci->config->item('erlistmgt_collection');

            #$institute_url = $ci->config->item('institute_url');
            #echo $institute_url;exit();
            $q = '';
            $start = 0;
            $length = 30;
            $order = 'name';
            $reverse = false;
            $info = 'basic';
            $showall = true;
            #$where = "/xml/item/curriculum/assessment/SAMs/files/file/@ref='$avail_ref'";

            #array_push($availabilities, $topic_code . '_OTHERS');

            for($i=0; $i<count($availabilities); $i++)
            {
                $avail_ref = $availabilities[$i]['availability'];
                $where = "/xml/item/curriculum/avails/avail/@avail_ref='$avail_ref'";
                $where .= " AND /xml/item/@itemstatus='live'";
                $where = urlencode($where);
                #Search in FLEX
                $searchsuccess = $this->flexrest->search($response, $q, $erlistmgt_collection, $where, $start, $length, $order, $reverse, $info, $showall);
                if(!$searchsuccess)
                {
                    #$errdata['message'] = $this->flexrest->error;
                    log_message('error', 'Failed to get the exiting requests: ' . $this->flexrest->error);
                    #$this->error_info('Error occurred when searching the requests.');
                    $errdata['message'] = 'Error occurred when searching the requests.';
                    $this->load->view('reading_listmgr/showerror_view', $errdata);
                    return;
                    #$this->output->_display();
                    #exit();
                }

                #echo '<pre>'; print_r($response);echo '</pre>';exit();

                $avails_num_requests[$i] = intval($response['available']);

            }

            return $avails_num_requests;

        }

        public function get_requests_by_avail()
        {
            $errdata['heading'] = "Internal error";
            if(!isset($_POST["avail_for_requests"]))
            {
                $errdata['message'] = 'Invalid Request';
                $this->load->view('reading_listmgr/showerror_view', $errdata);
                return;
            }
            $avail_ref = $_POST["avail_for_requests"];

            $new_req_created = false;
            if(isset($_POST["new_req_created"]))
                $new_req_created = true;
            #$ci =& get_instance();
            #$ci->load->config('flex');
            #$collection_id = $ci->config->item('erlistmgt_collection');

            $this->load->library('flexrest/flexrest');
            $success = $this->flexrest->processClientCredentialToken();
            if(!$success)
            {
                $errdata['message'] = $this->flexrest->error;
                log_message('error', 'Failed to get the exiting requests: ' . $errdata['message']);
                $this->load->view('reading_listmgr/showerror_view', $errdata);
                return;
            }

            $ci =& get_instance();
            $ci->load->config('flex');
            $erlistmgt_collection = $ci->config->item('erlistmgt_collection');

            #$institute_url = $ci->config->item('institute_url');
            #echo $institute_url;exit();
            $q = '';
            $start = 0;
            $length = 30;
            $order = 'modified';
            $reverse = false;
            $info = 'all';
            $showall = true;
            #$where = "/xml/item/curriculum/assessment/SAMs/files/file/@ref='$avail_ref'";

            $where = "/xml/item/curriculum/avails/avail/@avail_ref='$avail_ref'";
            $where .= " AND /xml/item/@itemstatus='live'";
            $where = urlencode($where);
            #Search in FLEX

            $searchsuccess = $this->flexrest->search($response, $q, $erlistmgt_collection, $where, $start, $length, $order, $reverse, $info, $showall);
            if(!$searchsuccess)
            {
                #$errdata['message'] = $this->flexrest->error;
                log_message('error', 'Failed to get the exiting requests: ' . $this->flexrest->error);
                #$this->error_info('Error occurred when searching for the requests.');
                $errdata['message'] = 'Error occurred when searching the requests';
                $this->load->view('reading_listmgr/showerror_view', $errdata);
                return;
            }

            for($i=0;$i<$response['length'];$i++)
            {
                $xmlwrapper_name = 'xmlwrapper'.$i;
                $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['results'][$i]['metadata']),$xmlwrapper_name);

                /*if(!$this->itemIsSam($this->xmlwrapper))
                {
                    $errdata['message'] = "Item is not SAM";
                    $this->load->view('sam/showerror_view', $errdata);
                    return;
                }*/
                #log_message('error', $response['results'][$i]['metadata']);

                $meta_array = $this->requestXml2Array($this->$xmlwrapper_name);
                $response['results'][$i]['meta_array'] = $meta_array;
            }


            #echo '<pre>'; print_r($response);echo '</pre>';exit();

            $data['availability'] = $avail_ref;
            $data['requests'] = $response;
            $data["new_req_created"] = $new_req_created;

            $this->load->view('reading_listmgr/requests_by_avail_view', $data);

        }


        public function get_one_request()
        {
            #$ci =& get_instance();
            #$ci->load->config('flex');
            #$collection_id = $ci->config->item('erlistmgt_collection');
            /*if(!isset($_POST["uuid"]))
            {
                $errdata['message'] = 'Invalid Request';
                $this->load->view('reading_listmgr/showerror_view', $errdata);
                return;
            }*/
            $uuid = $_POST["uuid"];
            $version = $_POST["version"];
            $topic_code = $_POST["topic_code"];

            $this->load->library('flexrest/flexrest');
            $success = $this->flexrest->processClientCredentialToken();
            if(!$success)
            {
                $errdata['message'] = $this->flexrest->error;
                log_message('error', 'Failed to get ereading list mgt item' . ', error: ' . $errdata['message']);
                $this->load->view('reading_listmgr/showerror_view', $errdata);
                return;
            }

            $success = $this->flexrest->getItem($uuid, $version, $response);
            if(!$success)
            {
                $errdata['message'] = $this->flexrest->error;
                log_message('error', 'Failed to get ereading list mgt item' . ', uuid: ' . $uuid . ', error: ' . $errdata['message']);
                $this->load->view('reading_listmgr/showerror_view', $errdata);
                return;
            }

            #echo '<pre>'; print_r($response);echo '</pre>';exit();

            $new_req_created = true;

            $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));

            /*if(!$this->itemIsSam($this->xmlwrapper))
            {
                $errdata['message'] = "Item is not SAM";
                $this->load->view('sam/showerror_view', $errdata);
                return;
            }*/
            $meta_array = $this->requestXml2Array($this->xmlwrapper);
            $response['meta_array'] = $meta_array;


            $data['request'] = $response;
            $data["new_req_created"] = $new_req_created;
            $data["topic_code"] = $topic_code;

            $this->load->view('reading_listmgr/view_one_req_view', $data);

        }

    /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function requestXml2Array($itemXml)
    {

        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/topics/topic'); $j++)
        {
            $topicCode = '/xml/item/curriculum/topics/topic['.$j.']/code';
            $topicTitle = '/xml/item/curriculum/topics/topic['.$j.']/name';

            $topicSchool = '/xml/item/curriculum/topics/topic['.$j.']/school';

            $samsArray['topics'][$j]['tcode'] = $itemXml->nodeValue($topicCode);
            $samsArray['topics'][$j]['topicTitle'] = $itemXml->nodeValue($topicTitle);

            $samsArray['topics'][$j]['topicSchool'] = trim($itemXml->nodeValue($topicSchool));
	}

        $name = '/xml/item/itembody/name';
        $samsArray['name'] = $itemXml->nodeValue($name);
	$req_content = '/xml/item/admin/to_do/requests/request[1]/content';
        $samsArray['content'] = $itemXml->nodeValue($req_content);
	$req_status = '/xml/item/admin/to_do/status';
        $samsArray['status'] = $itemXml->nodeValue($req_status);
        $needed_by = '/xml/item/admin/to_do/needed_by';
        $samsArray['needed_by'] = $itemXml->nodeValue($needed_by);
        $date_added = '/xml/item/admin/to_do/date_added';
        $samsArray['date_added'] = $itemXml->nodeValue($date_added);
        $added_by_name = '/xml/item/admin/to_do/added_by/name';
        $samsArray['added_by_name'] = $itemXml->nodeValue($added_by_name);
        $added_by_fan = '/xml/item/admin/to_do/added_by/@fan';
        $samsArray['added_by_fan'] = $itemXml->nodeValue($added_by_fan);

        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/avails/avail'); $j++)
        {

            $avYear = '/xml/item/curriculum/avails/avail['.$j.']/year';

            $avLocation = '/xml/item/curriculum/avails/avail['.$j.']/location_display';
            $avLocation_code = '/xml/item/curriculum/avails/avail['.$j.']/location_code';

            $av_ref = '/xml/item/curriculum/avails/avail['.$j.']/@avail_ref';

            $samsArray['availability'][$j]['avYear'] = $itemXml->nodeValue($avYear);

            $samsArray['availability'][$j]['avLocation'] = $itemXml->nodeValue($avLocation);
            $samsArray['availability'][$j]['avLocation_code'] = $itemXml->nodeValue($avLocation_code);

            $samsArray['availability'][$j]['avRef'] = $itemXml->nodeValue($av_ref);

        }

        $samsArray['owners'][1]['fan'] = null;
        $samsArray['owners'][1]['full_name'] = null;
	for ($j = 1; $j <= $itemXml->numNodes('/xml/item/item_owners/owner'); $j++)
        {
            $owner_full_name = '/xml/item/item_owners/owner['.$j.']/full_name';
            $samsArray['owners'][$j]['full_name'] = $itemXml->nodeValue($owner_full_name);
            $owner_fan = '/xml/item/item_owners/owner['.$j.']/fan';
            $samsArray['owners'][$j]['fan'] = $itemXml->nodeValue($owner_fan);

	}

        return $samsArray;

    }

        /**
         * Get the availabilities of From/ topic codes
         *
         * Get the number of activated eReadings for the availabilities.
         * This is on AJAX post call.
         */
        /*
        public function get_from_availabilities()
	{
            $this->load->helper('url');
            #$this->load->helper('form');
            #$this->load->library('form_validation');

            if(!isset($_POST["from_topic_code"]))
            {
                $error_data = array('error_info'=>'Invalid input topic code.');
                $this->load->view('reading_listmgr/fromto_avails_error_view', $error_data);
                return;
            }

            $from_topic_code = strtoupper(trim($_POST["from_topic_code"]));
           # $to_topic_code = strtoupper(trim($_POST["to_topic_code"]));
            #log_message('error', $topic_code);
            #$topic_code = strtoupper(trim(set_value('topic_code')));
            #log_message('error', $topic_code);
            $this->load->model('reading_listmgr/listmgr_model');

            $from_avails = $this->listmgr_model->db_get_all_avails_by_topic($from_topic_code);
            #$from_avails = $this->listmgr_model->db_chk_avails_by_topic($from_topic_code);

            if($from_avails === false )
            {
                $error_data = array('error_info'=>'No availability found for the topic code.');
                $this->load->view('reading_listmgr/fromto_avails_error_view', $error_data);
                #echo ('<br><div class="breadcrumbs"><b>Availabilities for rollover:</b></div><br>');
                #echo ('<p style="color:red">&nbsp;No availability found for From topic code.<p>');
                return;
            }
            #$tmp_count = count($from_avails);
            #$from_avails[$tmp_count]['availability'] = $from_topic_code . '_OTHER';
            #$from_avails[$tmp_count]['in_equella'] = 'existing';

            #
            $from_topic_name = $this->listmgr_model->db_get_topicname($from_topic_code);
            #$to_topic_name = $this->listmgr_model->db_get_topicname($to_topic_code);

            $from_avails_num_readings = $this->listmgr_model->db_get_numof_readings_by_avail($from_avails);
            #$to_avails_num_readings = $this->listmgr_model->db_get_numof_readings_by_avail($to_avails);

            #Number of readings rolled over or activated in this system today.
            $from_avails_rollover_readings = $this->listmgr_model->db_get_numof_rollover_readings_by_avail($from_avails);
            #$to_avails_rollover_readings = $this->listmgr_model->db_get_numof_rollover_readings_by_avail($to_avails);

            $avails_num_requests = $this->get_count_of_requests($from_topic_code, $from_avails);

            $data = array("from_avails"=>$from_avails,
                            "from_topic_code"=>$from_topic_code,
                            "from_topic_name"=>$from_topic_name,
                            "from_avails_num_readings"=>$from_avails_num_readings,
                            "from_avails_rollover_readings"=>$from_avails_rollover_readings,
                            "avails_num_requests"=>$avails_num_requests
                         );
            $this->load->view('reading_listmgr/from_availabilities_view', $data);
        }
        */

        public function home()
        {
            #$data = null;
            $topic_code = null;
            if(isset($_GET["topic_code"]))
                $topic_code = $_GET["topic_code"];
            else if(isset($_SESSION['listmgr_topic_code']))
                $topic_code = $_SESSION['listmgr_topic_code'];
            //$topic_code = strtoupper(trim($_GET["topic_code"]));
            $data["topic_code"] = $topic_code;

            $this->load->view('reading_listmgr/home', $data);

        }

        public function test()
        {
            $data = null;
            #phpinfo();
            #$this->load->view('reading_listmgr/test', $data);

        }

        /**
         * Get the availabilities of From/ topic codes
         *
         * Get the number of activated eReadings for the availabilities.
         * This is on AJAX post call.
         */
        /*
        public function chktopic_noajax()
	{
            $this->load->helper('url');
            #$this->load->helper('form');
            #$this->load->library('form_validation');
            $topic_code_input = true;
            if(!isset($_GET["topic_code"]))
            {
                $topic_code_input = false;
                $data = array("topic_code_input"=>$topic_code_input);
                $this->load->view('reading_listmgr/chktopic_view', $data);
                return;
            }

            $from_topic_code = strtoupper(trim($_GET["topic_code"]));
           # $to_topic_code = strtoupper(trim($_POST["to_topic_code"]));
            #log_message('error', $topic_code);
            #$topic_code = strtoupper(trim(set_value('topic_code')));
            #log_message('error', $topic_code);
            $this->load->model('reading_listmgr/listmgr_model');

            $from_avails = $this->listmgr_model->db_get_all_avails_by_topic($from_topic_code);
            #$from_avails = $this->listmgr_model->db_chk_avails_by_topic($from_topic_code);

            if($from_avails === false )
            {
                $data = array("topic_code_input"=>$topic_code_input,
                              "from_topic_code"=>$from_topic_code,
                              "from_avails"=>$from_avails);
                $this->load->view('reading_listmgr/chktopic_view', $data);
                return;
            }
            #$tmp_count = count($from_avails);
            #$from_avails[$tmp_count]['availability'] = $from_topic_code . '_OTHER';
            #$from_avails[$tmp_count]['in_equella'] = 'existing';


            #
            $from_topic_name = $this->listmgr_model->db_get_topicname($from_topic_code);
            #$to_topic_name = $this->listmgr_model->db_get_topicname($to_topic_code);

            $from_avails_num_readings = $this->listmgr_model->db_get_numof_readings_by_avail($from_avails);
            #$to_avails_num_readings = $this->listmgr_model->db_get_numof_readings_by_avail($to_avails);

            #Number of readings rolled over or activated in this system today.
            $from_avails_rollover_readings = $this->listmgr_model->db_get_numof_rollover_readings_by_avail($from_avails);
            #$to_avails_rollover_readings = $this->listmgr_model->db_get_numof_rollover_readings_by_avail($to_avails);

            $avails_num_requests = $this->get_count_of_requests($from_topic_code, $from_avails);

            $data = array("topic_code_input"=>$topic_code_input,
                            "from_avails"=>$from_avails,
                            "from_topic_code"=>$from_topic_code,
                            "from_topic_name"=>$from_topic_name,
                            "from_avails_num_readings"=>$from_avails_num_readings,
                            "from_avails_rollover_readings"=>$from_avails_rollover_readings,
                            "avails_num_requests"=>$avails_num_requests
                         );
            $this->load->view('reading_listmgr/chktopic_view', $data);
        }
        */


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
	private function generateToken()
	{
        $ci =& get_instance();
        $ci->load->config('flex');
        $username = $ci->config->item('erlistmgr_shared_secret_username');
        $sharedSecretId = $ci->config->item('erlistmgr_shared_secret_id');
        $sharedSecretValue = $ci->config->item('erlistmgr_shared_secret_value');

		$time = mktime() . '000';
		/*return urlencode ($username) . ':' . urlencode($sharedSecretId) . ':' .  $time . ':' .
                        urlencode(base64_encode (pack ('H*', md5 ($username . $sharedSecretId . $time . $sharedSecretValue))));*/
		  return urlencode ($username) . ':' . urlencode($sharedSecretId) . ':' .  $time . ':' .
                        urlencode(base64_encode (pack ('H*', md5 ($username . $sharedSecretId . $time . $sharedSecretValue))));

	}

        /**
         * Report the rollover logs to Equella via REST
         *
         *
         */
        public function report_error_logs()
	{
            $result['satus'] = "failed";
            $result['error_info'] = "";
            $errdata['heading'] = 'Internal Error';
            #log_message('error', 'before create item 111');
            if( !isset($_POST["to_avails"]) || !isset($_POST["log_content"]) )
            {
                $errdata['message'] = 'Invalid input data.';
                log_message('error', 'Invalid request to reoport logs for list management rollover' . ', error: missing post variable.');
                #$this->load->view('reading_listmgr/showerror_view', $errdata);
                $result['error_info'] = $errdata['message'];
                echo json_encode($result);
                return;
            }
            $availabilities = $_POST["to_avails"];
            $to_topic_code = substr($availabilities[0], 0, strpos($availabilities[0],"_"));
            #$to_topic_code = $_POST["to_topic_code"];
            $request_content = $_POST["log_content"];
            $there_is_error = $_POST["there_is_error"];

            $needed_by = "";
            if($there_is_error == 1)
            {
                $request_subject = "For Library follow up: error in eReadings rollover";
                $request_status = "New request";
            }
            else
            {
                $request_subject = "Notification only: successful eReadings rollover";
                $request_status = "Notification";
            }

            #$to_topic_code = substr($availabilities[0], 0, strpos($availabilities[0],"_"));

            /*
            echo("<pre>==========content of to_topic_code:<br>");
            print_r($to_topic_code);echo("</pre>");
            echo("<pre>==========content of availabilities:<br>");
            print_r($availabilities);echo("</pre>");
            echo("<pre>==========content of request_content:<br>");
            print_r($request_content);echo("</pre>");
            exit();
            */

            $ci =& get_instance();
            $ci->load->config('flex');
            $collection_id = $ci->config->item('erlistmgt_collection');

            $this->load->model('reading_listmgr/listmgr_model');
            $school_name = $this->listmgr_model->db_get_orgname($to_topic_code);
            if($school_name === false)
            {
                $errdata['message'] = 'Failed to get the school name of selected topic: ' . $to_topic_code;
                log_message('error', 'Failed to create new eReading list management request: ' . ', error: ' . $errdata['message']);
                #$this->load->view('reading_listmgr/showerror_view', $errdata);
                $result['error_info'] = $errdata['message'];
                echo json_encode($result);
                return;
            }

            #Check wether there are topic availabilities that are not in FLEX.
            #### need to handle the special availability TOPIC_OTHER
            /*
            if($availabilities != null)
            {
                $ret = $this->chk_to_availabilities(false, $availabilities);
                #log_message('error', 'New availabilities needed to be added to FLEX: ' . $ret['count_courses_added']);
                if($ret["result_stat"] == "failed")
                {
                    $errdata['message'] = $ret['error_info'];
                    log_message('error', 'Failed to create new eReading list management request' . ', error: ' . $errdata['message']);
                    #$this->load->view('reading_listmgr/showerror_view', $errdata);
                    $result['error_info'] = $errdata['message'];
                    echo json_encode($result);
                    return;
                }
            }
            */

            $this->load->library('flexrest/flexrest');
            $success = $this->flexrest->processClientCredentialToken();
            if(!$success)
            {
                $errdata['message'] = $this->flexrest->error;
                log_message('error', 'Failed to create new eReading list management request' . ', error: ' . $errdata['message']);
                #$this->load->view('reading_listmgr/showerror_view', $errdata);
                $result['error_info'] = $this->flexrest->error;
                echo json_encode($result);
                return;
            }

            $item_bean["collection"]["uuid"] = $collection_id;

            #$dom = new DOMDocument('1.0');
            #log_message('error', 'new dom: ' . $dom->saveXML());

            $now = date("Y-m-d H:i:s");
            $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => '<xml><item></item></xml>'));
            $request_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/admin/to_do/requests/request");
            $request_content_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/admin/to_do/requests/request/content");
            #$request_content_node->nodeValue = $request_content;

            $this->xmlwrapper->createTextNode($request_content_node, $request_content);
            #$request_content_node->appendChild($text_content);

            $request_date_added_node = $this->xmlwrapper->createAttribute($request_node, "date_added");
            $request_date_added_node->nodeValue = $now;
            $request_status_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/admin/to_do/status");
            $request_status_node->nodeValue = $request_status;
            $request_name_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/admin/to_do/name");
            $request_name_node->nodeValue = str_replace('&', 'and', $request_subject);

            $request_added_by_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/admin/to_do/added_by");
            $request_addedby_fan_node = $this->xmlwrapper->createAttribute($request_added_by_node, "fan");
            $request_addedby_fan_node->nodeValue = $_SERVER['REMOTE_USER'];
            $request_neededby_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/admin/to_do/needed_by");
            $request_neededby_node->nodeValue = $needed_by;

            $date_added_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/admin/to_do/date_added");
            $date_added_node->nodeValue = $now;

            $topic_code_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/topics/topic/code");
            $topic_code_node->nodeValue = $to_topic_code;
            $topic_school_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/topics/topic/school");
            $topic_school_node->nodeValue = str_replace('&', 'and', $school_name);
            $item_name_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/itembody/name");
            $item_name_node->nodeValue = str_replace('&', 'and', $request_subject);

            $to_avails_node = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/avails");

            if($availabilities != null)
            {
                foreach($availabilities as $to_avail)
                {
                    #log_message('error', "to_avail: " . $to_avail);
                    $to_avail_node = $this->xmlwrapper->createNode($to_avails_node, "avail");
                    $to_avail_ref_node = $this->xmlwrapper->createAttribute($to_avail_node, "avail_ref");
                    $to_avail_ref_node->nodeValue = $to_avail;
                }
            }
            $item_bean['metadata'] = $this->xmlwrapper->__toString();
            #$item_bean['metadata'] = str_replace('&nbsp;', '&amp;nbsp;', $item_bean['metadata']);
            #$item_bean['metadata'] = str_replace('&ldquo;', '&amp;ldquo;', $item_bean['metadata']);
            #$item_bean['metadata'] = str_replace('&rdquo;', '&amp;rdquo;', $item_bean['metadata']);
            #$item_bean['metadata'] = str_replace('&lsquo;', '&amp;lsquo;', $item_bean['metadata']);
            #$item_bean['metadata'] = str_replace('&rsquo;', '&amp;rsquo;', $item_bean['metadata']);
            #$item_bean['metadata'] = str_replace('&ndash;', '&amp;ndash;', $item_bean['metadata']);
            #echo("<pre>==========content of item_bean:<br>");
            #print_r($item_bean);echo("</pre>");

            $success = $this->flexrest->createItem($item_bean, $response1);
            if(!$success)
            {
                $errdata['message'] = $this->flexrest->error;
                log_message('error', 'eReading list management createItem failed' . ', error: ' . $errdata['message']);
                log_message('error', 'Metadata: ' . $item_bean['metadata']);
                #$this->load->view('reading_listmgr/showerror_view', $errdata);
                $result['error_info'] = $this->flexrest->error;
                echo json_encode($result);
                return;
            }

            if(!isset($response1['headers']['location']))
            {
                $errdata['message'] = 'No Location header in createItem response.';
                log_message('error', 'eReading list management createItem failed' . ', error: ' . $errdata['message']);
                #$this->load->view('reading_listmgr/showerror_view', $errdata);
                $result['error_info'] = $errdata['message'];
                echo json_encode($result);
                return;
            }
            $location = $response1['headers']['location'];

            $institute_url = $ci->config->item('institute_url');
            $location1 = substr($location, strpos($location, 'item')+4);
            $location1 = $institute_url . 'items' . $location1;
            #$location1 = str_replace('api/item', 'items', $location);
            $discipline = substr($to_topic_code, 0, 4);
            if($there_is_error == 1)
            {
                $email_subject = $ci->config->item('listmgr_email_error_subject');
            }
            else
            {
                $email_subject = $ci->config->item('listmgr_email_notification_subject');
            }

            $this->email_req_created($discipline, $location1, $email_subject, $to_topic_code);

            #echo("<pre>==========response of createItem:<br>");
            #print_r($response1); echo("</pre>");

            $result['status'] = "success";

            echo json_encode($result);
            /*
            $data = array("avails_for_new_req"=>$availabilities,"editor1"=>$request_content,
                  "result_status"=>$result['status'], "error_info"=>$result['error_info']);
            $this->load->view('reading_listmgr/create_request_view', $data);
            */

        }

        /**
         * Send Email when a request is created.
         *
         * TO addresses are based on first four letters of topic code, e.g. EDUC.
         */

        public function email_req_created($discipline, $item_location, $email_subject, $topic_code)
        {

            $this->load->library('flexrest/flexrest');
            $success = $this->flexrest->processClientCredentialToken();
            if(!$success)
            {
                $errdata['message'] = $this->flexrest->error;
                log_message('error', 'Failed to access flex: ' . $errdata['message']);
                #$this->load->view('reading_listmgr/showerror_view', $errdata);
                return;
            }

            $ci =& get_instance();
            $ci->load->config('flex');
            $erlist_liaison_collection = $ci->config->item('subject_areas_collection');

            #$institute_url = $ci->config->item('institute_url');
            #echo $institute_url;exit();
            $q = '';
            $start = 0;
            $length = 10;
            $order = 'modified';
            $reverse = false;
            $info = 'all';
            $showall = true;
            #$where = "/xml/item/curriculum/assessment/SAMs/files/file/@ref='$avail_ref'";

            $where = "/xml/item/curriculum/topics/topic/discipline='$discipline'";
            $where .= " AND /xml/item/@itemstatus='live'";
            $where = urlencode($where);
            #Search in FLEX

            $searchsuccess = $this->flexrest->search($response, $q, $erlist_liaison_collection, $where, $start, $length, $order, $reverse, $info, $showall);
            if(!$searchsuccess)
            {
                #$errdata['message'] = $this->flexrest->error;
                log_message('error', 'Failed to search discipline in subject areas collection: ' . $this->flexrest->error);
                #$this->error_info('Failed to search discipline in subject areas collection.');
                return;
            }
            #echo '<pre>';print_r($response);echo '</pre>';exit();

            if(intval($response['available']) == 0)
            {
                log_message('error', 'No item found in the subject areas collection for the Learning Access Team , discipline: ' . $discipline);
                return;
            }
            #log_message('error', (string)$response['results'][0]['metadata']);
            $xmlwrapper_name = 'xmlwrapper_liaison';
            $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['results'][0]['metadata']), $xmlwrapper_name);

            #log_message('error', $this->$xmlwrapper_name->__toString());
            $meta_array = $this->liaisonXml2Array($this->$xmlwrapper_name);

            if(!isset($meta_array['coords']) && !isset($meta_array['supports']))
            {
                log_message('error', 'No coords or supports found in subject areas item, discipline: ' . $discipline);
                return;
            }

            $to_list = array();

            if(isset($meta_array['coords']['fan']))
            for($j =1; $j <= count($meta_array['coords']['fan']); $j++)
            {
                $to_list[] = $meta_array['coords']['fan'][$j] . '@flinders.edu.au';
                #log_message('error', $meta_array['coords']['fan'][$j] . '@flinders.edu.au');
            }

            if(isset($meta_array['supports']['fan']))
            for($j =1; $j <= count($meta_array['supports']['fan']); $j++)
            {
                #log_message('error', $meta_array['supports']['fan'][$j] . '@flinders.edu.au');
                $to_list[] = $meta_array['supports']['fan'][$j] . '@flinders.edu.au';
            }
            #log_message('error', implode(',',$to_list));
            $this->load->library('email');
            $CI =& get_instance();
            $CI->load->config('flex');
            $listmgr_email_from_addr = $CI->config->item('listmgr_email_from_addr');
            $listmgr_email_from_title = $CI->config->item('listmgr_email_from_title');

            $mes = '<html><body>
            Dear Learning Access Team,
            <br><br>
            You have one new eReadings list management request for topic: ' . $topic_code . '<br><br>Please click on the link to see the details in FLEX.
            <br>
            <a href="' . $item_location . '"> ' . $email_subject . '</a>' .
            '<br><br><br>
            Regards,<br>
            eReadings list management system
            ';

            $this->email->from($listmgr_email_from_addr, $listmgr_email_from_title);
            $this->email->to($to_list);
            $this->email->subject($email_subject);
            $this->email->set_mailtype("html");
            $this->email->message($mes);

            $this->email->send();
            #log_message('error', $this->email->print_debugger());
            #log_message('error', 'After sending email');
            #$this->email->print_debugger();
        }

    /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function liaisonXml2Array($itemXml)
    {

        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/people/coords/coord/fan'); $j++)
        {
            $fan = '/xml/item/curriculum/people/coords/coord/fan['.$j.']';
            $xmlArray['coords']['fan'][$j] = $itemXml->nodeValue($fan);
            #log_message('error', '111'.$itemXml->nodeValue($fan));
	}
	for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/people/supports/support/fan'); $j++)
        {
            $fan = '/xml/item/curriculum/people/supports/support/fan['.$j.']';
            $xmlArray['supports']['fan'][$j] = $itemXml->nodeValue($fan);
            #log_message('error', '222'.$itemXml->nodeValue($fan));
	}

        $name = '/xml/item/itembody/name';
        $xmlArray['name'] = $itemXml->nodeValue($name);

        return $xmlArray;

    }

    /**for TEST
     * Create an activation via REST
     *
     *
     */
    public function create_activation()
    {



        $this->load->library('flexrest/flexrest');
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Failed to create new eReading list management request' . ', error: ' . $errdata['message']);
            #$this->load->view('reading_listmgr/showerror_view', $errdata);
            $result['error_info'] = $this->flexrest->error;
            echo json_encode($result);
            return;
        }

        $activation_bean["type"] = "cal";
        $activation_bean["item"]["uuid"] = "2d60492f-0ce5-4921-bb24-742a3d0ce746";
        $activation_bean["item"]["version"] = 1;
        $activation_bean["attachment"] = "b97413e3-4ca5-42e0-8923-4d53c217184c";
        $activation_bean["course"]["uuid"] = "9c27caa4-fc55-4c34-a8fc-c63303585532";
        $activation_bean["course"]["code"] = "test_new2";

        $success = $this->flexrest->createActivation($activation_bean, $response1);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'eReading list management create_activation failed' . ', error: ' . $errdata['message']);
            echo 'eReading list management create_activation failed' . ', error: ' . $errdata['message'];
        }
        echo 'success<br><pre>'; print_r($response1); echo '</pre>'; exit();


        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'eReading list management createItem failed' . ', error: ' . $errdata['message']);
            #log_message('error', 'Metadata: ' . $item_bean['metadata']);
            #$this->load->view('reading_listmgr/showerror_view', $errdata);
            $result['error_info'] = $this->flexrest->error;
            echo json_encode($result);
            return;
        }

        #echo("<pre>==========response of createItem:<br>");
        #print_r($response1); echo("</pre>");

        if(!isset($response1['headers']['location']))
        {
            $errdata['message'] = 'No Location header in createItem response.';
            log_message('error', 'eReading list management createItem failed' . ', error: ' . $errdata['message']);
            #$this->load->view('reading_listmgr/showerror_view', $errdata);
            $result['error_info'] = $errdata['message'];
            echo json_encode($result);
            return;
        }
        $location = $response1['headers']['location'];
        $institute_url = $ci->config->item('institute_url');
        $location1 = substr($location, strpos($location, 'item')+4);
        $location1 = $institute_url . 'items' . $location1;
        #$location1 = str_replace('api/item', 'items', $location);
        #log_message('error', $location1);
        $discipline = substr($to_topic_code, 0, 4);
        $email_subject = $ci->config->item('listmgr_email_request_subject');
        $this->email_req_created($discipline, $location1, $email_subject, $to_topic_code);
        #log_message('error', 'after calling email_req_created');

        $uuid = substr($location, strpos($location, 'item')+5, 36);
        $version = substr($location, strpos($location, 'item')+42, (strlen($location)-1-(strpos($location, 'item')+42)));
        #log_message('error', 'location: ' . $location);
        #log_message('error', 'uuid: ' . $uuid);
        #log_message('error', 'version: ' . $version);
        $result['status'] = "success";
        $result['uuid'] = $uuid;
        $result['version'] = $version;
        echo json_encode($result);
        /*
        $data = array("avails_for_new_req"=>$availabilities,"editor1"=>$request_content,
              "result_status"=>$result['status'], "error_info"=>$result['error_info']);
        $this->load->view('reading_listmgr/create_request_view', $data);
        */

    }

    /**for TEST
     * Create an equella course via soap
     *
     *
     */
    public function create_course_soap()
    {

       $ci =& get_instance();
            $ci->load->config('flex');
            $soapusername = $ci->config->item('soap_coursemgt_username');
            $soappassword = $ci->config->item('soap_coursemgt_password');
            $soapparams = array('username'=>$soapusername, 'password'=>$soappassword);
            $this->load->library('flexsoap/flexsoap',$soapparams);
            if(!$this->flexsoap->success)
            {
                #$this->logger_rollover->error("Error: " . $this->flexsoap->error_info);
                $result["result_stat"] = "failed";
                $result['error_info'] = $this->flexsoap->error_info;
                #echo json_encode($result);
                #return;
                print_r($result);
                return;
            }


            /*$courseXml = $this->flexsoap->getCourse($courseCode="test_new8");

            log_message('error', $courseXml);
            echo '<pre>';print_r($courseXml);echo '</pre>';
            exit();*/

            /*
            $course_csv = '"Name","Description","Code","Citation","Start","End","Students","Type","DepartmentName"' . "\n";
            $course_csv .= '"TEST NEW 6","TEST NEW 6","test_new6","Generic","15/03/2015 00:00:00.0","15/05/2015T00:00:00+10:30","100","Internal",""';

            $this->flexsoap->bulkImportCourses($course_csv);
            if(!$this->flexsoap->success)
            {
                #$this->logger_rollover->error("Error: " . $this->flexsoap->error_info);
                $result["result_stat"] = "failed";
                $result['error_info'] = $this->flexsoap->error_info;
                #echo json_encode($result);
                #return;
                print_r($result);
                return;
            }
            exit();*/

       $courseXml = '<com.tle.beans.item.cal.request.CourseInfo>
           <uuid>77e6f9e5-7075-4755-b4b5-2a6d144c5555</uuid>
    <name>
      <strings>
        <entry>
          <string>en_US</string>
          <com.tle.beans.entity.LanguageString>
            <locale>en_US</locale>
            <priority>2</priority>
            <text>TEST NEW 18</text>
          </com.tle.beans.entity.LanguageString>
        </entry>
      </strings>
    </name>
    <attributes/>
    <systemType>false</systemType>
    <disabled>false</disabled>
    <students>7</students>
    <from class="sql-timestamp">2015-03-25 00:00:00.0</from>
    <until class="sql-timestamp">2015-05-28 23:59:59.0</until>
    <citation>Generic</citation>
    <departmentName></departmentName>
    <courseType>i</courseType>
    <code>test_new18</code>
</com.tle.beans.item.cal.request.CourseInfo>';

        $res = $this->flexsoap->addCourse($courseXml);
        if(!$this->flexsoap->success)
            {
                #$this->logger_rollover->error("Error: " . $this->flexsoap->error_info);
                $result["result_stat"] = "failed";
                $result['error_info'] = $this->flexsoap->error_info;
                #echo json_encode($result);
                #return;
                print_r($result);
                return;
            }
            #log_message('error', $courseXml);
            echo '<pre>';print_r($res);echo '</pre>';
            exit();


    }

    /**for TEST
     * Edit an equella course via soap
     *
     *
     */
    public function edit_course_soap()
    {

       $ci =& get_instance();
            $ci->load->config('flex');
            $soapusername = $ci->config->item('soap_coursemgt_username');
            $soappassword = $ci->config->item('soap_coursemgt_password');
            $soapparams = array('username'=>$soapusername, 'password'=>$soappassword);
            $this->load->library('flexsoap/flexsoap',$soapparams);
            if(!$this->flexsoap->success)
            {
                #$this->logger_rollover->error("Error: " . $this->flexsoap->error_info);
                $result["result_stat"] = "failed";
                $result['error_info'] = $this->flexsoap->error_info;
                #echo json_encode($result);
                #return;
                print_r($result);
                return;
            }


            /*$courseXml = $this->flexsoap->getCourse($courseCode="test_new8");

            log_message('error', $courseXml);
            echo '<pre>';print_r($courseXml);echo '</pre>';
            exit();*/

            /*
            $course_csv = '"Name","Description","Code","Citation","Start","End","Students","Type","DepartmentName"' . "\n";
            $course_csv .= '"TEST NEW 6","TEST NEW 6","test_new6","Generic","15/03/2015 00:00:00.0","15/05/2015T00:00:00+10:30","100","Internal",""';

            $this->flexsoap->bulkImportCourses($course_csv);
            if(!$this->flexsoap->success)
            {
                #$this->logger_rollover->error("Error: " . $this->flexsoap->error_info);
                $result["result_stat"] = "failed";
                $result['error_info'] = $this->flexsoap->error_info;
                #echo json_encode($result);
                #return;
                print_r($result);
                return;
            }
            exit();*/

       $courseXml = '<com.tle.beans.item.cal.request.CourseInfo>
  <id>4932511</id>
  <uuid>77e6f9e9-707c-4759-b4b2-2a6d144c6e22</uuid>
  <institution>
    <id>3621556</id>
    <uniqueId>0</uniqueId>
    <enabled>true</enabled>
  </institution>
  <name>
    <id>4932512</id>
    <strings>
      <entry>
        <string>en_US</string>
        <com.tle.beans.entity.LanguageString>
          <id>4932513</id>
          <locale>en_US</locale>
          <priority>2</priority>
          <text>TEST NEW 8</text>
          <bundle reference="../../../.."/>
        </com.tle.beans.entity.LanguageString>
      </entry>
    </strings>
  </name>
  <students>0</students>
  <from class="sql-timestamp">2015-02-25 10:30:00.0</from>
  <until class="sql-timestamp">2015-03-28 10:30:00.0</until>
  <citation>Generic</citation>
  <departmentName></departmentName>
  <courseType>i</courseType>
  <code>test_new8</code>
</com.tle.beans.item.cal.request.CourseInfo>';

        $res = $this->flexsoap->editCourse($courseXml);
        if(!$this->flexsoap->success)
            {
                #$this->logger_rollover->error("Error: " . $this->flexsoap->error_info);
                $result["result_stat"] = "failed";
                $result['error_info'] = $this->flexsoap->error_info;
                #echo json_encode($result);
                #return;
                print_r($result);
                return;
            }
            #log_message('error', $courseXml);
            echo '<pre>';print_r($res);echo '</pre>';
            exit();


    }

    #for TEST
     public function create_cus_rest()
    {


        $this->load->library('flexrest/flexrest');
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Failed to create new eReading list management request' . ', error: ' . $errdata['message']);
            #$this->load->view('reading_listmgr/showerror_view', $errdata);
            $result['error_info'] = $this->flexrest->error;
            echo json_encode($result);
            return;
        }

        $course_bean["code"] = "test_new17";
        $course_bean["type"] = "Internal";
        $course_bean["citation"] = "Generic";
        $course_bean["from"] = "2015-02-25T00:00:00+10:30";
        $course_bean["until"] = "2015-05-29T00:00:00+09:30";


        $success = $this->flexrest->createCourse($course_bean, $response1);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'eReading list management create_course failed' . ', error: ' . $errdata['message']);
            echo 'eReading list management create_activation failed' . ', error: ' . $errdata['message'];
        }
        echo 'success<br><pre>'; print_r($response1); echo '</pre>'; exit();




    }
}
