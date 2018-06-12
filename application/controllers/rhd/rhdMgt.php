<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class RhdMgt extends CI_Controller {

	    protected $logger_rhd;
        protected $soapusername;
        protected $soappassword;
        protected $soapparams;
		//protected $userUuid;

        /**
         * Constructor
         *
         * Get logger at application/logs/rhdLog
         *
         * Get user's user groups in Equella. Check whether the user is in
         * required group for moderating or contribution.

		 * Set session variables.
         */
        public function __construct()
        {
            parent::__construct();

            session_start();

			$ci = & get_instance();
            $ci->load->config('flex');
			//loading log
			$loggings = $ci->config->item('rhdLog');
            $this->load->library('logging/logging',$loggings);
            $this->logger_rhd = $this->logging->get_logger('rhd');

			$this->load->model('rhd/rhd_cron_model');
			
			#check down time before authentication through FLEX
            $down_notice = false;
            $down_notice = $this->rhd_cron_model->db_chk_notice();
            if($down_notice != false)
            {
                #$this->error_info($down_notice['message']);
                if ($down_notice['message'] == '')
                    $down_notice['message'] = 'The RHD thesis submission is temporarily unavailable, please try again later.';
                #echo $down_notice['message'];
                $errdata['message'] = $down_notice['message'];
                $errdata['heading'] = "Notice";
                $this->load->view('rhd/showerror_view', $errdata);
                $this->output->_display();
                exit;
            }

            $this->soapusername = $ci->config->item('soap_activation_username');
            $this->soappassword = $ci->config->item('soap_activation_password');
            $this->soapparams = array('username'=>$this->soapusername, 'password'=>$this->soappassword);
        }

		public function report()
		{
			$this->load->helper('url');
			if(!isset($_SERVER['REMOTE_USER']))
            {
                $this->logger_rhd->error("Error: REMOTE_USER not set.");
                $errdata['message'] = 'Unable to get username';
                $errdata['heading'] = "Internal error";
                $this->load->view('rhd/showerror_view', $errdata);
                $this->output->_display();
                exit();
            }

			$userUuid = strtolower($_SERVER['REMOTE_USER']);

            $this->load->library('flexsoap/flexsoap',$this->soapparams);
            if(!$this->flexsoap->success)
            {
                $this->logger_rollover->error($this->flexsoap->error_info);
                $this->logger_activation->error($this->flexsoap->error_info);
                $errdata['message'] = $this->flexsoap->error_info;
                $errdata['heading'] = "Internal error";
                $this->load->view('rhd/showerror_view', $errdata);
                $this->output->_display();
                exit();
            }

            //get user group
			$groups = $this->flexsoap->getGroupsByUser($userUuid);
            if(!$this->flexsoap->success)
            {
                $this->logger_rollover->error($this->flexsoap->error_info);
                $this->logger_activation->error($this->flexsoap->error_info);
                $errdata['message'] = $this->flexsoap->error_info;
                $errdata['heading'] = "Internal error";
                $this->load->view('rhd/showerror_view', $errdata);
                $this->output->_display();
                exit();
            }

			$ci = & get_instance();
			$ci->load->config('flex');

			$usergrp_rhd_moderator = $ci -> config ->item('rhd_moderator_group'); //get rhd moderator group uuid
			$usergrp_rhd_contributor = $ci -> config->item('rhd_thesis_contributor_group'); //get rhd contributor group uuid

			//$user_role = '';
			if(strpos($groups, $usergrp_rhd_moderator) !== false)
            {
				if(strpos($groups, $usergrp_rhd_contributor) !== false)
                {
                	$_SESSION['rhd_privilege'] = 'mod&con';
               		//$user_role = 'moderator&contributor';
				}
				else
				{
					$_SESSION['rhd_privilege'] = 'moderator';
					//$user_role = 'moderator';
				}
            }
			else
			{
				$_SESSION['rhd_privilege'] = 'contributor';
				//$user_role = 'contributor';
			}

			if($_SESSION['rhd_privilege'] === 'moderator' || $_SESSION['rhd_privilege'] === 'mod&con')
			{
				$this->load->view('rhd/report');
			}
			else
			{
                $errdata['message'] = 'You do not have access to this page.';
                $errdata['heading'] = "Error";
                $this->load->view('rhd/showerror_view', $errdata);
                $this->output->_display();
                exit();
			}
		}

		public function generateReport()
		{
			if($_SESSION['rhd_privilege'] === 'moderator' || $_SESSION['rhd_privilege'] === 'mod&con')
			{
				$this->load->helper('url');
				$ci = & get_instance();
				$ci->load->config('flex');
				$collection_id = $ci->config->item('rhd_collection');
				$theses = $this->rhd_cron_model->eq_db_get_all_thesis($collection_id);

				echo json_encode($theses);
			}
			else
			{
                $errdata['message'] = 'You do not have access to this page.';
                $errdata['heading'] = "Error";
                $this->load->view('rhd/showerror_view', $errdata);
                $this->output->_display();
                exit();
			}
		}


		public function getUserGroups()
		{
			$this->load->helper('url');
			//session_start();

			if(!isset($_SERVER['REMOTE_USER']))
            {
                $this->logger_rhd->error("Error: REMOTE_USER not set.");
                $errdata['message'] = 'Unable to get username';
                $errdata['heading'] = "Internal error";
                $this->load->view('rhd/showerror_view', $errdata);
                $this->output->_display();
                exit();
            }

			$userUuid = strtolower($_SERVER['REMOTE_USER']);

           // $usergrp_listmgr_advcontributor = $ci->config->item('usergrp_listmgr_advcontributor');
            //$usergrp_listmgr_libviewer = $ci->config->item('usergrp_listmgr_libviewer');

            $this->load->library('flexsoap/flexsoap',$this->soapparams);
            if(!$this->flexsoap->success)
            {
                ####
                $this->logger_rollover->error($this->flexsoap->error_info);
                $this->logger_activation->error($this->flexsoap->error_info);
                $errdata['message'] = $this->flexsoap->error_info;
                $errdata['heading'] = "Internal error";
                $this->load->view('rhd/showerror_view', $errdata);
                $this->output->_display();
                exit();
            }


            //get user group
			$groups = $this->flexsoap->getGroupsByUser($userUuid);
            if(!$this->flexsoap->success)
            {
                ####
                $this->logger_rollover->error($this->flexsoap->error_info);
                $this->logger_activation->error($this->flexsoap->error_info);
                $errdata['message'] = $this->flexsoap->error_info;
                $errdata['heading'] = "Internal error";
                $this->load->view('rhd/showerror_view', $errdata);
                $this->output->_display();
                exit();
            }

			/*$xmlwrapper_name = 'xmlwrapper_' . $userUuid;

			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$groups), $xmlwrapper_name);

			$g = $this->Xml2Array($this->$xmlwrapper_name);

			echo 'groups: <pre>';
			print_r($g);
			echo '</pre>';*/

			$ci = & get_instance();
			$ci->load->config('flex');

			$usergrp_rhd_moderator = $ci -> config ->item('rhd_moderator_group'); //get rhd moderator group uuid
			//echo 'usergrp_rhd_moderator:'.$usergrp_rhd_moderator . '<br/>';
			$usergrp_rhd_contributor = $ci -> config->item('rhd_thesis_contributor_group'); //get rhd contributor group uuid
			//echo 'usergrp_rhd_contributor:'.$usergrp_rhd_contributor . '<br/>';

			$user_role = '';

			if(strpos($groups, $usergrp_rhd_moderator) !== false)
            {
				if(strpos($groups, $usergrp_rhd_contributor) !== false)
                {
                	$_SESSION['rhd_privilege'] = 'mod&con';
               		$user_role = 'moderator&contributor';
				}
				else
				{
					$_SESSION['rhd_privilege'] = 'moderator';
					$user_role = 'moderator';
				}
            }
			else
			{
				$_SESSION['rhd_privilege'] = 'contributor';
				$user_role = 'contributor';
			}

			switch($_SESSION['rhd_privilege'])
			{
				case 'moderator':
					$this -> contributorRhd($userUuid);
					break;
				case 'contributor':

					$this -> contributorRhd($userUuid);
					break;
				case '':
					$this -> modAndConRhd($userUuid);
					break;
			}

			return;
		}


		private function moderaterRhd()
		{
			$oauth = array('oauth_client_config_name' => 'rhd');
			$this->load->library('flexrest/flexrest', $oauth);

		//	$this->load->library('flexrest/flexrest');

			$ci =& get_instance();
            $ci->load->config('flex');
			$collection_id = $ci->config->item('rhd_collection');
			$success = $this->flexrest->processClientCredentialToken();

			if(!$success)
			{
				$errdata['heading'] = "Error";
				$errdata['message'] = $this->flexrest->error;
				$this->load->view('rhd/showerror_view', $errdata);
				return;
			}


			$current_tasks = $this->flexrest->getCurrentTasks('all', 0, 100, $collection_id, $response);
			if($current_tasks)
			{
				echo 'Current Tasks response: <pre>';
				print_r($response);
				echo '</pre>';


				if( $response['available'] > 0 )
				{
					$results = $response['results'];
					for($i=0; $i < $response['available']; $i++)
					{

					}
				}
			}
			else
			{
				$error_data = array('heading'=>'Error', 'message'=>'cannot get current tasks');
				$this->load->view('rhd/showerror_view', $error_data);
                return;
			}


		}


		private function modAndConRhd()
		{
		}


		private function contributorRhd($userUuid)
		{
			//searchMyresources
			$oauth = array('oauth_client_config_name' => 'rhd');
			$this->load->library('flexrest/flexrest', $oauth);

		//	$this->load->library('flexrest/flexrest');

			$ci =& get_instance();
            $ci->load->config('flex');
			$rhd_schools_taxonomy_uuid = $ci->config->item('rhd_schools_taxonomy_uuid'); //get rhd school taxonomy uuid
			$collection_id = $ci->config->item('rhd_collection');
			$success = $this->flexrest->processClientCredentialToken();

			if(!$success)
			{
				$errdata['heading'] = "Error";
				$errdata['message'] = $this->flexrest->error;
				$this->load->view('rhd/showerror_view', $errdata);
				return;
			}
			//user log in ID
			//$userUuid = $_SERVER['REMOTE_USER'];

			//build up search query

			$where = "/xml/item/curriculum/people/students/student/fan='".$userUuid."' OR ";

			$where = $where . "/xml/item/curriculum/people/students/student/fan='" . strtoupper($userUuid) ."'";
			//	echo $where;
			$where = urlencode($where);

			//public function searchMyresources(&$response,$q=null, $collections=null, $where=null, $start=null, $length=null, $order=null, $reverse=false, $info='basic')
			$searchsuccess = $this->flexrest->search($response, '', $collection_id, $where, 0, 50, 'modified', false, 'all', true);
			if($searchsuccess)
			{
				$statusArray = array();

				$draft_index = 0;
				$live_index = 0;
				$rej_index = 0;
				$mod_index = 0;

				for($i=0; $i< $response['available']; $i++)
				{
					if(isset($response['results'][$i]['status']))
					{
						$status = $response['results'][$i]['status'];
						$item = $this->buildItemArray($response['results'][$i]);
						switch($status)
						{
							case 'live':
								$live_index++;
								$statusArray[$status][$live_index-1] = $item;
							break;
							case 'draft';
								$draft_index++;
								$statusArray[$status][$draft_index-1] = $item;
							break;
							case 'moderating';
								$mod_index++;
								$statusArray[$status][$mod_index-1] = $item;
							break;
							case 'rejected';
								$rej_index++;
								$statusArray[$status][$rej_index-1] = $item;
							break;
						}
					}
				}

				unset($draft_index);
				unset($live_index);
				unset($rej_index);
				unset($mod_index);
				/*echo 'status array: <pre>';
				print_r($statusArray);
				echo '</pre>';*/
				$data = array('data' => $statusArray);
				$data['owner'] = strtolower($userUuid);
				$data['token'] = $this->generateToken($userUuid);
				/*echo 'status array: <pre>';
				print_r($data);
				echo '</pre>';*/
				//$this->load->view('rhd/contribution', $data);

				/***get scholl data from taxonomy**/

			    $this->flexrest->getTerms($rhd_schools_taxonomy_uuid, '', $response);
				$schools = array();
				for($i=0; $i<count($response)-1; $i++)
				{
					array_push($schools, $response[$i]['term']);
				}
				$data['schools'] = $schools;
				$this->load->view('rhd/dashboard', $data);
			}
			else
			{
				$this->logger_rhd->error("Error: flexrest search error for user: " . $userUuid);
                $errdata['message'] = 'Unable to search';
                $errdata['heading'] = "Internal error";
                $this->load->view('rhd/showerror_view', $errdata);
                $this->output->_display();
                exit();
			}
		}



	   /*****************************************************************
			AJAX CALL:  create a new RHD Thesis
		*****************************************************************/
		public function createRHD()
		{
			$this->load->helper('url');
			$ci = & get_instance();

			$collection_id = $ci->config->item('rhd_collection');

			$userUuid = strtolower($_SERVER['REMOTE_USER']);
			$result['status'] = "failed";
            $result['error_info'] = "";

			$oauth = array('oauth_client_config_name' => 'rhd');
			$this->load->library('flexrest/flexrest', $oauth);
			$success = $this->flexrest->processClientCredentialToken();
            if(!$success)
            {
                $errdata['message'] = $this->flexrest->error;
                $result['error_info'] = $this->flexrest->error;
                echo json_encode($result);
                return;
            }

			//get compulsory post variables
		 	$stuID = $_POST["stuID"];
			//$prfStuName = $_POST["prfStuName"];
			//$prfStuLastName = $_POST["prfStuLastName"];
			$stuEmail = $_POST["stuEmail"];
			$thesisType = $_POST["thesisType"];
			$supName = $_POST["supName"];
			$title = $_POST["title"];
			$school =  $_POST["school"];

            if(!isset($_POST["stuID"] ) || !isset($_POST["stuEmail"]) || !isset($_POST["thesisType"]) || !isset($_POST["title"]) || !isset($_POST["school"]))
            {
                $error_data = array('heading'=>'Error', 'message'=>'Invalid input data');
                $this->load->view('rhd/showerror_view', $error_data);
                return;
            }

			// thesis type cannot be Master by coursework
			if(isset($_POST["thesisType"]) && $_POST["thesisType"] == "Master by Coursework")
			{
				$error_data = array('heading'=>'Error', 'message'=>'Thesis type can not be coursework');
				$this->load->view('rhd/showerror_view', $error_data);
                return;
			}

			/**********************************************
			 search thesis title in existing contributions.
			 **********************************************/

			//build up search query
			$where = "/xml/item/curriculum/people/students/student/fan='".$userUuid."' OR ";
			$where = $where . "/xml/item/curriculum/people/students/student/fan='" . strtoupper($userUuid) ."'";

			$where = urlencode($where);
			$searchsuccess = $this->flexrest->search($response, '', $collection_id, $where, 0, 50, 'modified', false, 'all', true);

			if($searchsuccess)
			{
				$flag = true;
				$thesisTitle = strtoupper(preg_replace('/( *)/', '', $title));
				if(isset($response['available']) && isset($response['results']))
				{
					for($i=0; $i< $response['available']; $i++)
					{
						if(isset($response['results'][$i]['status']))
						{
							if($response['results'][$i]['status'] != 'deleted')
							{
								$name =  $response['results'][$i]['name'];
								$name = strtoupper(preg_replace('/( *)/', '', $name));
								if($name == $thesisTitle)
								{
									$flag = false;
									break;
								}
							}
						}
					}
				}

				//if item already exists, return error message to the view
				if(!$flag)
				{
					$result['status'] = "itemExists";
					$result['error_info'] = "RHD Thesis title exists";
					//log_message('error', 'result: ' . $result);
					#log_message('error', 'RHD Thesis title exists');
					//$data = array("result"=>$result, "result_status"=>$result['status'], "error_info"=>$result['error_info']);
					echo json_encode($result);
					//$this->load->view('rhd/create_RHD_view', $data);
					return;
				}

				//create a new item
				$item_bean["collection"]["uuid"] = $collection_id;


				//root node
				$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => '<xml><item></item></xml>'));

				//thesis title, item name
				$thesis_name = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/thesis/title");
				$this->xmlwrapper->createTextNode($thesis_name, $title);

				// theis type
				$thesis_node = $this->xmlwrapper->node("/xml/item/curriculum/thesis");
				$thesis_type = $this->xmlwrapper->createAttribute($thesis_node, "selected_type");
				$this->xmlwrapper->createTextNode($thesis_type, $thesisType);



				// student fan
				$stu_fan = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/students/student/fan");
				$this->xmlwrapper->createTextNode($stu_fan, strtolower($userUuid));

				//student ID
				$stu_node = $this->xmlwrapper->node("/xml/item/curriculum/people/students/student");
				$student_ID = $this->xmlwrapper->createAttribute($stu_node, "id");
				$this->xmlwrapper->createTextNode($student_ID, $stuID);

				//student email
				$owner_email = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/students/student/email");
				$this->xmlwrapper->createTextNode($owner_email, $stuEmail);

				//student first name
				/*$owner_firstname = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/students/student/firstname");
				$this->xmlwrapper->createTextNode($owner_firstname, $prfStuName);

				$owner_lastname = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/students/student/lastname");
				$this->xmlwrapper->createTextNode($owner_lastname, $prfStuLastName);*/

				//supervisor name
				$supervisor_name = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/coords/coord/name");
				$this->xmlwrapper->createTextNode($supervisor_name, $supName);


				//supervisor email
				if(isset($_POST["supEmail"]) && $_POST["supEmail"]!= '')
				{
					$supervisor_email = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/coords/coord/email");
				    $this->xmlwrapper->createTextNode($supervisor_email, $_POST["supEmail"]);

				}

				//completion year
				if(isset($_POST["compYear"]) && $_POST["compYear"]!= '')
				{
					$complete_year = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/thesis/complete_date");
					$this->xmlwrapper->createTextNode($complete_year, $_POST["compYear"]);

				}

				$infor_lock = $this->xmlwrapper->createNodeFromXPath("/xml/item/sys_variables/locks/information");
				$this->xmlwrapper->createTextNode($infor_lock, "Yes");

				$school_name = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/thesis/schools/primary");
				$this->xmlwrapper->createTextNode($school_name, $school);


				$item_bean['metadata'] = $this->xmlwrapper->__toString();

				// public function createItem ($item_bean, &$response, $filearea_uuid=null, $draft=false, $waitforindex=false)
				$success = $this-> flexrest->createDraftItem($item_bean, $response1);

				if(!$success)
				{
					$errdata['message'] = $this->flexrest->error;
					log_message('error', 'RHD Thesis createItem failed' . ', error: ' . $errdata['message']);
					log_message('error', 'Metadata: ' . $item_bean['metadata']);
					#$this->load->view('reading_listmgr/showerror_view', $errdata);
					$result['error_info'] = $this->flexrest->error;
					echo json_encode($result);
					return;
				}

				if(!isset($response1['headers']['location']))
				{
					$errdata['message'] = 'No Location header in createItem response.';
					log_message('error', ' RHD thesis createItem failed' . ', error: ' . $errdata['message']);
					#$this->load->view('reading_listmgr/showerror_view', $errdata);
					$result['error_info'] = $errdata['message'];
					echo json_encode($result);
					return;
				}
				$location = $response1['headers']['location'];

				$uuid = substr($location, strpos($location, 'item')+5, 36);

				$version = substr($location, strpos($location, 'item')+42, (strlen($location)-1-(strpos($location, 'item')+42)));

				$result['status'] = "success";
				$result['uuid'] = $uuid;
				$result['version'] = $version;
				$result['itemName'] = $title;
				$result['token'] = $this->generateToken($userUuid);
				echo json_encode($result);

				//$data = array("result"=>$result, "result_status"=>$result['status'], "error_info"=>$result['error_info']);
				//$this->load->view('rhd/create_RHD_view', $data);
				}
				else
				{
					$this->logger_rhd->error("Error: flexrest search error for user: " . $userUuid);
					$errdata['message'] = 'Unable to search';
					$errdata['heading'] = "Internal error";
					$this->load->view('rhd/showerror_view', $errdata);
					$this->output->_display();
					exit();
				}

		}



	/** private functions**/


	private function Xml2Array($itemXml)
    {
       $tmp = array();
	   for ($i = 1; $i <= $itemXml->numNodes('/groups/group');  $i++)
	   {
		   $uuid = '/groups/group[' . $i .']/uuid';
		   $tmp['group'][$i]['uuid'] = $itemXml->nodeValue($uuid);
		   $name = '/groups/group[' . $i .']/name';
		   $tmp['group'][$i]['name'] = $itemXml->nodeValue($name);
	   }
       return $tmp;
    }


	private function buildItemArray($responseArray)
	{
		$itemArray = array();
		//$itemArray['owner'] = $responseArray['owner'];
		$itemArray['uuid'] = $responseArray['uuid'];
		$itemArray['name'] = $responseArray['name'];
		$itemArray['version'] = $responseArray['version'];
		$itemArray['createdDate'] = $responseArray['createdDate'];
		$itemArray['modifiedDate'] = $responseArray['modifiedDate'];
		return $itemArray;
	}

	private function generateToken($username)
	{
		$ci =& get_instance();
		$ci->load->config('flex');

		$sharedSecretId = $ci->config->item('rhd_shared_secret_id');
		$sharedSecretValue = $ci->config->item('rhd_shared_secret_value');

		$time = mktime() . '000';

	    return urlencode ($username) . ':' . urlencode($sharedSecretId) . ':' .  $time . ':' .
	    urlencode(base64_encode (pack ('H*', md5 ($username . $sharedSecretId . $time . $sharedSecretValue))));

	}


}
