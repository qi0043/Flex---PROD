<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coursework extends CI_Controller {

	    protected $logger_rhd;
        protected $soapusername;
        protected $soappassword;
        protected $soapparams;
	
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
			
			$this->soapusername = $ci->config->item('soap_activation_username');
            $this->soappassword = $ci->config->item('soap_activation_password');
            $this->soapparams = array('username'=>$this->soapusername, 'password'=>$this->soappassword);
            
        }
        
		public function index()
		{
			$this->load->helper('url');
			//session_start();
			$this->load->model('public/rhd_model');
			/*$down_notice = false;
			$down_notice = $this->rhd_model->db_chk_notice();
			if($down_notice != false)
			{				
				if ($down_notice['message'] == '')
				$down_notice['message'] = 'The thesis system is temporarily unavailable, please try again later.';
				
				$errdata['message'] = $down_notice['message'];
				$errdata['heading'] = "Notice";
				$this->load->view('public/rhd/showerror_view', $errdata);
				return;
			}*/
			
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
			$_SESSION['fan'] = $userUuid;
			$user_role = $this->getUserGroups($userUuid);
			
			switch($user_role)
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
		}

	
		private function getUserGroups($userUuid)
		{ 
            $this->load->library('flexsoap/flexsoap',$this->soapparams);
            if(!$this->flexsoap->success)
            {
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
			
			$user_role = '';
			
			if(strpos($groups, $usergrp_rhd_moderator) !== false)
            {
				if(strpos($groups, $usergrp_rhd_contributor) !== false)
                {
                	$_SESSION['rhd_privilege'] = 'mod&con';
               		$user_role = 'mod&con';
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
			
			return $user_role;
		}
		
		
		/*** NOT IN USE Function for moderatiors ***/
		private function moderaterRhd()
		{
			$oauth = array('oauth_client_config_name' => 'rhd');
			$this->load->library('flexrest/flexrest', $oauth);

			//$this->load->library('flexrest/flexrest');
			
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
		
		
		/*** NOT IN USE Function for moderatior and contributor role ***/
		private function modAndConRhd()
		{
		}
		
   
        /*** Function for contributors ***/
		private function contributorRhd($userUuid)
		{
			$oauth = array('oauth_client_config_name' => 'rhd');
			$this->load->library('flexrest/flexrest', $oauth);

			$ci = & get_instance();
			$ci->load->config('flex');
			
			//$rhd_schools_taxonomy_uuid = $ci->config->item('rhd_schools_taxonomy_uuid'); //get rhd school taxonomy uuid
			$collection_id = $ci->config->item('coursework_thesis_collection');
			//$collection_id = 'c097379c-8611-4449-8b1a-47b70b0de2da';			
			$success = $this->flexrest->processClientCredentialToken();
			
			if(!$success)
			{
				$errdata['heading'] = "Error";
				$errdata['message'] = $this->flexrest->error;
				$this->load->view('rhd/showerror_view', $errdata);
				return;
			}  
			
			//build up search query
			$where = "/xml/item/curriculum/people/students/student/fan='".$userUuid."' OR ";
			$where = $where . "/xml/item/curriculum/people/students/student/fan='" . strtoupper($userUuid) ."'";
			
			$where = urlencode($where);
		
			$searchsuccess = $this->flexrest->search($response, '', $collection_id, $where, 0, 1, 'modified', false, 'all', true);
			if($searchsuccess)
			{
				if(intval($response['available']) > 0)
				{
					$data['status'] = $response['results'][0]['status'];
					$data['name'] =  addslashes(html_entity_decode($response['results'][0]['name']));
					$data['uuid'] = $response['results'][0]['uuid'];
					$data['version'] = $response['results'][0]['version'];
					$data['createdDate'] = $response['results'][0]['createdDate'];
					$data['modifiedDate'] = $response['results'][0]['modifiedDate'];
					
					if($data['status'] == 'draft')
					{
						$success = $this->flexrest->getItemAll($data['uuid'], $data['version'], $r);
						if(!$success)
						{
							$errdata['message'] = $this->flexrest->error;
							$this->load->view('rhd/showerror_view', $errdata);
							return;
						}
						
						$xmlwrapper_name = 'xmlwrapper';
						$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$r['metadata']), $xmlwrapper_name);
								
						$item_array = $this->itemXml2Array($this->$xmlwrapper_name);
						$item_array = $this->thesis_validation($item_array, $r['attachments']);
						$valid = true;
						
						foreach($item_array['validation'] as $validation)
						{
							if($validation['valid'] == 'invalid')
							{
								$valid = false;
								break;
							}
						}
						$data['valid'] = $valid;
					}
				}
				else
				{
					$data['status'] = 'notCreated';
				}	
				
				$this->load->view('rhd/frontview', $data); 
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
		
		public function createThesis()
		{
			if(!isset($_SERVER['REMOTE_USER']))
            {
                redirect(base_url('thesis/coursework'));
                exit();
            }
			else
			{
				$_SESSION['fan'] = strtolower($_SERVER['REMOTE_USER']);
			}
			
			$this->load->helper('url');
			$ci = & get_instance();
			$oauth = array('oauth_client_config_name' => 'rhd');
			
		 	$this->load->library('ldap/ldap', $oauth);
			$ldap_user = $ci->ldap->get_attributes($_SESSION['fan']);
			
			
			$user_groups = $ldap_user['groups'];
			
			$stu_id = '';
			$stu_email = $ldap_user['email'];
		
			$stu_first_name = $ldap_user['givenname'];
		
			$stu_last_name = $ldap_user['sn'];
			
			foreach($user_groups as $user_group)
			{
				if(strtolower($user_group) == 'cn=student,ou=groups,o=flinders')
				{
					$stu_id = isset($ldap_user['user_info']['flindersPersonStudentNumber'][0])? $ldap_user['user_info']['flindersPersonStudentNumber'][0] : '';
				}
			}
			
			$data['stu_id'] = $stu_id;
			$data['stu_first_name_dip'] = $stu_first_name;
			$data['stu_last_name_dip'] = $stu_last_name;
			$data['stu_email'] = $stu_email;
			
		
			$navs = array();
			$navs[1]['url'] = 'thesis/coursework';
			$navs[1]['text'] = 'Step 1: About';
			$navs[1]['active'] = 'active';
			$navs[1]['disabled'] = false;
			$navs[2]['url'] = '';
			$navs[2]['text'] = 'Step 2: Upload';
			$navs[2]['active'] = 'inactive';
			$navs[2]['disabled'] = true;
			$navs[3]['url'] = '';
			$navs[3]['text'] = 'Step 3: Public Release';
			$navs[3]['active'] = 'inactive';
			$navs[3]['disabled'] = true;
			$navs[4]['url'] = '';
			$navs[4]['text'] = 'Step 4: Submit';
			$navs[4]['active'] = 'inactive';
			$navs[4]['disabled'] = true;
			$data['schools'] = $this->getSchools();
			
			$data['navs'] = $navs;
			$data['new_thesis'] = true;
			$data['status'] = 'draft';
			
			$this->load->view('rhd/step1', $data);
			
		}
		
		public function redirect()
		{
			$this->load->helper('url');
			
			if(isset($_SERVER['REMOTE_USER']))
			{
				$result['status'] = 'success';
				$result['token'] = $this->generateToken($_SERVER['REMOTE_USER']);
				echo json_encode($result);
				return;
			}
			else
			{
				redirect(base_url('thesis/courswork'));
                exit();
			}
		}
		
		public function getThesis_part1($uuid='missed', $version='missed', $newThesis = 'missed')
		{
			if(!$this->validate_params($uuid, $version))
			{
				$errdata['message'] = 'invalid url';
				$this->load->view('rhd/showerror_view', $errdata);
				return;
			}
			
			if(!isset($_SERVER['REMOTE_USER']))
            {
                redirect(base_url('thesis/courswork'));
                exit();
            }
			else
			{
				$_SESSION['fan'] = strtolower($_SERVER['REMOTE_USER']);
			}
			
			$this->load->helper('url');
			$ci = & get_instance();
			$oauth = array('oauth_client_config_name' => 'rhd');
			$this->load->library('flexrest/flexrest', $oauth);
		 	$this->load->library('ldap/ldap', $oauth);
			$ldap_user = $ci->ldap->get_attributes($_SESSION['fan']);
			$user_groups = isset($ldap_user['groups'])? $ldap_user['groups'] : '';
			
			$stu_id = '';
			$stu_email = isset($ldap_user['email'])? $ldap_user['email'] : '' ;
			$stu_first_name = isset($ldap_user['givenname'])?$ldap_user['givenname']:'';
			$stu_last_name =isset( $ldap_user['sn']) ? $ldap_user['sn']: '';
			foreach($user_groups as $user_group)
			{
				if(strtolower($user_group) == 'cn=student,ou=groups,o=flinders')
				{
					$stu_id = isset($ldap_user['user_info']['flindersPersonStudentNumber'][0])? $ldap_user['user_info']['flindersPersonStudentNumber'][0] : '';
				
				}
			}
			
			$success = $this->flexrest->processClientCredentialToken();
			
			if(!$success)
			{
				$errdata['heading'] = "Error";
				$errdata['message'] = $this->flexrest->error;
				$this->load->view('rhd/showerror_view', $errdata);
				return;
			}
			
			$success = $this->flexrest->getItemAll($uuid, $version, $response);
			if(!$success)
			{
				$errdata['heading'] = "Error";
				$errdata['message'] = $this->flexrest->error;
				$this->load->view('rhd/showerror_view', $errdata);
				return;
			}
			
			$xmlwrapper_name = 'xmlwrapper_'.$uuid;
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
			
			$student_fan = $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/people/students/student/fan');
			
			if($_SESSION['fan'] != $student_fan && strtoupper($_SESSION['fan']) != $student_fan )
			{
				$errdata['heading'] = "Warning";
				$errdata['message'] = "You don't have privilege to view this page";
				$this->load->view('rhd/showerror_view', $errdata);
				return;
			}
					
			$item_array = $this->itemXml2Array($this->$xmlwrapper_name);
		 
			if(isset($item_array['abstract_attachment']) && strlen($item_array['abstract_attachment'][1]['uuid']) == 36)
			{
				
				foreach ($response['attachments'] as $attachment) 
				{
					
					if($attachment['uuid'] == $item_array['abstract_attachment'][1]['uuid'])
					{
						
						$item_array['abstract_attachment'][1]['filename'] = addslashes($attachment['filename']);
						$item_array['abstract_attachment'][1]['filesize'] = $attachment['size'];
						$item_array['abstract_attachment'][1]['filelink'] = $attachment['links']['view'];
						break;
					}
				}
			}
			
			
			if(isset($item_array['stu_id']) && $item_array['stu_id'] == '')
			{
				$item_array['stu_id'] = $stu_id;
			}
			if(isset($item_array['stu_pre_first_name']) && $item_array['stu_pre_first_name'] == '')
			{
				$item_array['stu_pre_first_name'] = $stu_first_name;
			}
			if(isset($item_array['stu_pre_last_name'])&& $item_array['stu_pre_last_name'] == '')
			{
				$item_array['stu_pre_last_name'] = $stu_last_name;
			}
			if(isset($item_array['stu_email']) && $item_array['stu_email'] == '')
			{
				$item_array['stu_email'] = $stu_email;
			}
			
			$item_array['schools'] = $this->getSchools();
			$item_array['token'] = $this->generateToken($_SESSION['fan']);
			
			$new = false;
			
			$navs = array();
			if(intval($newThesis) == 15)
			{
				$new = true;
				$validation = $this->thesis_validation($item_array, $response['attachments']);
			
				$navs[1]['url'] = 'rhd/coursework/getThesis_part1/' . $uuid . '/' . $version . '/15/';
				$navs[1]['text'] = 'Step 1: About';
				$navs[1]['active'] = 'active';
				$navs[1]['disabled'] = false;
				
				if($validation['validation']['part_1']['valid'] == 'valid')
				{
					$navs[2]['url'] = 'rhd/coursework/getThesis_part2/' . $uuid . '/' . $version . '/15/';
					$navs[2]['disabled'] = false;
					
					if($validation['validation']['part_2']['valid'] == 'valid')
					{
						$navs[3]['url'] = 'rhd/coursework/getThesis_part3/' . $uuid . '/' . $version . '/15/';
						$navs[3]['disabled'] = false;
					}
					else
					{
						$navs[3]['url'] = '';
						$navs[3]['disabled'] = true;
						$navs[4]['url'] = '';
						$navs[4]['disabled'] = true;
					}
					
					if($validation['validation']['part_3']['valid'] == 'valid')
					{
						$navs[4]['url'] = 'rhd/coursework/getThesis_part4/' . $uuid . '/' . $version . '/15/';
						$navs[4]['disabled'] = false;
					}
					else
					{
						$navs[4]['url'] = '';
						$navs[4]['disabled'] = true;
					}
					
				}
				else
				{
					$navs[2]['url'] = '';
					$navs[2]['disabled'] = true;
					$navs[3]['url'] = '';
					$navs[3]['disabled'] = true;
					$navs[4]['url'] = '';
					$navs[4]['disabled'] = true;
				}
				
				$navs[2]['text'] = 'Step 2: Upload';
				$navs[2]['active'] = 'inactive';
				
				$navs[3]['text'] = 'Step 3: Public Release';
				$navs[3]['active'] = 'inactive';
			
				$navs[4]['text'] = 'Step 4: Submit';
				$navs[4]['active'] = 'inactive';
				
			}
			else
			{
				$navs[1]['url'] = 'rhd/coursework/getThesis_part1/' . $uuid . '/' . $version;
				$navs[1]['text'] = 'Step 1: About';
				$navs[1]['active'] = 'active';
				$navs[1]['disabled'] = false;
				$navs[2]['url'] = 'rhd/coursework/getThesis_part2/' . $uuid . '/' . $version;
				$navs[2]['text'] = 'Step 2: Upload';
				$navs[2]['active'] = 'inactive';
				$navs[2]['disabled'] = false;
				$navs[3]['url'] = 'rhd/coursework/getThesis_part3/' . $uuid . '/' . $version;
				$navs[3]['text'] = 'Step 3: Public Release';
				$navs[3]['active'] = 'inactive';
				$navs[3]['disabled'] = false;
				
				$url='';
				
				if($response['status'] == 'draft')
				{
					$url = 'rhd/coursework/getThesis_part4/' . $uuid. '/' . $version.'/';
				}
				else
				{
					$url = 'thesis/coursework';
				}
				
				$navs[4]['url'] = $url;
				$navs[4]['text'] = 'Step 4: Submit';
				$navs[4]['active'] = 'inactive';
				$navs[4]['disabled'] = false;
			}
			
			$item_array['navs'] = $navs;
			$item_array['uuid'] = $uuid;
			$item_array['version'] = $version;
			$item_array['status'] = $response['status'];
			$item_array['new_thesis'] = $new;
			
			unset($response);
			unset($r);

			$this->load->view('rhd/step1', $item_array);
		}
		
		public function getThesis_part2($uuid='missed', $version='missed', $newThesis = 'missed')
		{
			if(!$this->validate_params($uuid, $version))
			{
				$errdata['message'] = 'invalid url';
				$this->load->view('rhd/showerror_view', $errdata);
				return;
			}
			
			$this->load->helper('url');
			$oauth = array('oauth_client_config_name' => 'rhd');
			$this->load->library('flexrest/flexrest', $oauth);
			
			if(!isset($_SERVER['REMOTE_USER']))
			{
				redirect(base_url('thesis/coursework'));
				exit();
			}
			else
			{
				$_SESSION['fan'] = strtolower($_SERVER['REMOTE_USER']);
			}
			
			$success = $this->flexrest->processClientCredentialToken();
			
			if(!$success)
			{
				$errdata['heading'] = "Error";
				$errdata['message'] = $this->flexrest->error;
				$this->load->view('rhd/showerror_view', $errdata);
				return;
			}
			
			$success = $this->flexrest->getItemAll($uuid, $version, $response);
			if(!$success)
			{
				$errdata['message'] = $this->flexrest->error;
				$this->load->view('rhd/showerror_view', $errdata);
				return;
			}
			
			$xmlwrapper_name = 'xmlwrapper_'.$uuid;
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
			
			$student_fan = $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/people/students/student/fan');
			
			if( $_SESSION['fan'] != $student_fan && strtoupper($_SESSION['fan']) != $student_fan )
			{
				$errdata['heading'] = "Warning";
				$errdata['message'] = "You don't have privilege to view this page";
				$this->load->view('rhd/showerror_view', $errdata);
				return;
			}		
			$item_array = $this->itemXml2Array($this->$xmlwrapper_name);
			
			if(isset($item_array['examined_thesis']))
			{
				$index = 0;
				foreach($item_array['examined_thesis'] as $thesis)
				{
					$index ++;
					
					if(strlen($thesis['uuid']) == 36)
					{
						foreach ($response['attachments'] as $attachment) 
						{
							if($thesis['uuid'] == $attachment['uuid'])
							{
								$item_array['examined_thesis'][$index]['filename'] = addslashes($attachment['filename']);
								$item_array['examined_thesis'][$index]['filesize'] = $attachment['size'];
								$item_array['examined_thesis'][$index]['filelink'] = $attachment['links']['view'];
								break;
							}
						}
					}
				}
			}
			/***get scholl data from taxonomy**/
			
			$item_array['token'] = $this->generateToken($_SESSION['fan']);
			
			$new = false;
			
			if(intval($newThesis) == 15)
			{
				$new = true;
			
				$validation = $this->thesis_validation($item_array, $response['attachments']);
			
				$navs[1]['url'] = 'rhd/coursework/getThesis_part1/' . $uuid . '/' . $version . '/15/';
				$navs[1]['text'] = 'Step 1: About';
				$navs[1]['active'] = 'inactive';
				$navs[1]['disabled'] = false;
				
				$navs[2]['url'] = 'rhd/coursework/getThesis_part2/' . $uuid . '/' . $version . '/15/';
				$navs[2]['disabled'] = false;
				$navs[2]['text'] = 'Step 2: Upload';
				$navs[2]['active'] = 'active';
				
				if($validation['validation']['part_2']['valid'] == 'valid')
				{
					$navs[3]['url'] = 'rhd/coursework/getThesis_part3/' . $uuid . '/' . $version . '/15/';
					$navs[3]['disabled'] = false;
					if($validation['validation']['part_3']['valid'] == 'valid')
					{
						$navs[4]['url'] = 'rhd/coursework/getThesis_part4/' . $uuid . '/' . $version . '/15/';
						$navs[4]['disabled'] = false;
					}
					else
					{
						$navs[4]['url'] = '';
						$navs[4]['disabled'] = true;
					}
					
				}
				else
				{
					$navs[3]['url'] = '';
					$navs[3]['disabled'] = true;
					$navs[4]['url'] = '';
					$navs[4]['disabled'] = true;
				}
				
				$navs[3]['text'] = 'Step 3: Public Release';
				$navs[3]['active'] = 'inactive';
			
				$navs[4]['text'] = 'Step 4: Submit';
				$navs[4]['active'] = 'inactive';
			}
			else
			{
				$navs[1]['url'] = 'rhd/coursework/getThesis_part1/' . $uuid . '/' . $version.'/';
				$navs[1]['text'] = 'Step 1: About';
				$navs[1]['active'] = 'inactive';
				$navs[1]['disabled'] = false;
				
				$navs[2]['url'] = 'rhd/coursework/getThesis_part2/' . $uuid . '/' . $version.'/';
				$navs[2]['text'] = 'Step 2: Upload';
				$navs[2]['active'] = 'active';
				$navs[2]['disabled'] = false;
			
				$navs[3]['url'] = 'rhd/coursework/getThesis_part3/' . $uuid. '/' . $version.'/';
				$navs[3]['text'] = 'Step 3: Public Release';
				$navs[3]['active'] = 'inactive';
				$navs[3]['disabled'] = false;
				
				if($response['status'] == 'draft')
				{
					$url = 'rhd/coursework/getThesis_part4/' . $uuid. '/' . $version.'/';
				}
				else
				{
					$url = 'thesis/coursework';
				}
				
				
				$navs[4]['url'] = $url;
				$navs[4]['text'] = 'Step 4: Submit';
				$navs[4]['active'] = 'inactive';
				$navs[4]['disabled'] = $disable;
			}
			
			$item_array['navs'] = $navs;
			
			$item_array['uuid'] = $uuid;
			$item_array['version'] = $version;
			$item_array['status'] = $response['status'];
			
			$item_array['new_thesis'] = $new;
			unset($response);
			unset($r);
			
			$this->load->view('rhd/step2', $item_array);
		}
		
		public function getThesis_part3($uuid='missed', $version='missed', $newThesis = 'missed')
		{
			$new = false;
			$disable = false;
			if(intval($newThesis) == 15)
			{
				$new = true;
				$disable = true;
			}
			else
			{
				$new = false;
			}
			
			$this->load->helper('url');
			if(!$this->validate_params($uuid, $version))
			{
				$errdata['message'] = 'invalid url';
				$this->load->view('rhd/showerror_view', $errdata);
				return;
			}
			
			if(!isset($_SERVER['REMOTE_USER']))
            {
				
                redirect(base_url('thesis/coursework'));
			
                exit();
            }
			else
			{
				$_SESSION['fan'] = strtolower($_SERVER['REMOTE_USER']);
			}
			
			$oauth = array('oauth_client_config_name' => 'rhd');
			$this->load->library('flexrest/flexrest', $oauth);
		
			$success = $this->flexrest->processClientCredentialToken();
			
			if(!$success)
			{
				$errdata['heading'] = "Error";
				$errdata['message'] = $this->flexrest->error;
				$this->load->view('rhd/showerror_view', $errdata);
				return;
			}
			
			$success = $this->flexrest->getItemAll($uuid, $version, $response);
			if(!$success)
			{
				$errdata['message'] = $this->flexrest->error;
				$this->load->view('rhd/showerror_view', $errdata);
				return;
			}
			
			$xmlwrapper_name = 'xmlwrapper_'.$uuid;
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
			
			$student_fan = $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/people/students/student/fan');
			
			if( $_SESSION['fan'] != $student_fan && strtoupper($_SESSION['fan']) != $student_fan )
			{
				$errdata['heading'] = "Warning";
				$errdata['message'] = "You don't have privilege to view this page";
				$this->load->view('rhd/showerror_view', $errdata);
				return;
			}
					
			$item_array = $this->itemXml2Array($this->$xmlwrapper_name);
			if(isset($item_array['open_access']))
			{
				$index = 0;
				foreach($item_array['open_access'] as $thesis)
				{
					$index ++;
					
					if(strlen($thesis['uuid']) == 36)
					{
						foreach ($response['attachments'] as $attachment) 
						{
							if($thesis['uuid'] == $attachment['uuid'])
							{
								$item_array['open_access'][$index]['fileuuid'] = $attachment['uuid'];
								$item_array['open_access'][$index]['filename'] = $attachment['filename'];
								$item_array['open_access'][$index]['filesize'] = $attachment['size'];
								$item_array['open_access'][$index]['filelink'] = $attachment['links']['view'];
								break;
							}
						}
					}
				}
			}
			
			$item_array['status'] = $response['status'];
			$item_array['token'] = $this->generateToken($_SESSION['fan']);
			if(intval($newThesis) == 15)
			{
				$new = true;
			
				$validation = $this->thesis_validation($item_array, $response['attachments']);
			
				$navs[1]['url'] = 'rhd/coursework/getThesis_part1/' . $uuid . '/' . $version . '/15/';
				$navs[1]['text'] = 'Step 1: About';
				$navs[1]['active'] = 'inactive';
				$navs[1]['disabled'] = false;
				
				$navs[2]['url'] = 'rhd/coursework/getThesis_part2/' . $uuid . '/' . $version . '/15/';
				$navs[2]['disabled'] = false;
				$navs[2]['text'] = 'Step 2: Upload';
				$navs[2]['active'] = 'inactive';
				
				$navs[3]['url'] = 'rhd/coursework/getThesis_part3/' . $uuid . '/' . $version . '/15/';
				$navs[3]['disabled'] = false;
				$navs[3]['text'] = 'Step 3: Public Release';
				$navs[3]['active'] = 'active';
				
				
				if($validation['validation']['part_3']['valid'] == 'valid')
				{
					$navs[4]['url'] = 'rhd/coursework/getThesis_part4/' . $uuid . '/' . $version . '/15/';
					$navs[4]['disabled'] = false;
				}
				else
				{
					$navs[4]['url'] = '';
					$navs[4]['disabled'] = true;
				}
				
				$navs[4]['text'] = 'Step 4: Submit';
				$navs[4]['active'] = 'inactive';
			}
			else
			{
				$navs[1]['url'] = 'rhd/coursework/getThesis_part1/' . $uuid . '/' . $version;
				$navs[1]['text'] = 'Step 1: About';
				$navs[1]['active'] = 'inactive';
				$navs[1]['disabled'] = false;
				$navs[2]['url'] = 'rhd/coursework/getThesis_part2/' . $uuid . '/' . $version.'/';
				$navs[2]['text'] = 'Step 2: Upload';
				$navs[2]['active'] = 'inactive';
				$navs[2]['disabled'] = false;
				$navs[3]['url'] = 'rhd/coursework/getThesis_part3/' . $uuid. '/' . $version.'/';
				$navs[3]['text'] = 'Step 3: Public Release';
				$navs[3]['active'] = 'active';
				$navs[3]['disabled'] = false;
			
				if($item_array['status'] == 'draft')
				{
					$navs[4]['url'] = 'rhd/coursework/getThesis_part4/' . $uuid. '/' . $version.'/';
					$navs[4]['disabled'] = false;
				}
				else
				{
					$navs[4]['url'] ='thesis/coursework';
					$navs[4]['disabled'] = false;
				}
				
				$navs[4]['text'] = 'Step 4: Submit';
				$navs[4]['active'] = 'inactive';
			}
			$item_array['navs'] = $navs;
			
			$item_array['uuid'] = $uuid;
			$item_array['version'] = $version;
			
			$item_array['new_thesis'] = $new;
			
			$this->load->view('rhd/step3', $item_array);
		}
		
		public function getThesis_part4($uuid='missed', $version='missed', $newThesis = 'missed')
		{
			$this->load->helper('url');
			if(!isset($_SESSION['fan']))
			{
				 redirect(base_url('thesis/coursework'));
			}
			
			$new = false;
			if(intval($newThesis) == 15)
			{
				$new = true;
			}
			else
			{
				$new = false;
			}
			
			if(!$this->validate_params($uuid, $version))
			{
				$errdata['message'] = 'invalid url';
				$this->load->view('rhd/showerror_view', $errdata);
				return false;
			}
			if(!isset($_SESSION['fan']))
            {
                redirect(base_url('thesis/coursework'));
			
                exit();
            }
			
			$oauth = array('oauth_client_config_name' => 'rhd');
			$this->load->library('flexrest/flexrest', $oauth);
		
			$success = $this->flexrest->processClientCredentialToken();
			
			if(!$success)
			{
				return;
			}
			
			$success = $this->flexrest->getItemAll($uuid, $version, $response);
			if(!$success)
			{
				
				return;
			}
			
			
			$xmlwrapper_name = 'xmlwrapper_'.$uuid;
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
					
			$item_array = $this->itemXml2Array($this->$xmlwrapper_name);
			
			$item_array = $this->thesis_validation($item_array, $response['attachments']);
			
			$valid = TRUE;
		
			foreach($item_array['validation'] as $validation)
			{
				if($validation['valid'] == 'invalid')
				{
					
					
					$valid = false;
					break;
				}
			}
			$item_array['valid'] = $valid;
			$item_array['token'] = $this->generateToken($_SESSION['fan']);
			
			
			if($response['status'] == 'draft')
			{
				if($new)
				{
					$navs[1]['url'] = 'rhd/coursework/getThesis_part1/' . $uuid . '/' . $version . '/15';
					$navs[1]['valid'] = $item_array['validation']['part_1']['valid'];
					$navs[1]['text'] = 'Step 1: About';
					$navs[1]['active'] = 'inactive';
					$navs[1]['disabled'] = false;
					
					$navs[2]['url'] = 'rhd/coursework/getThesis_part2/' . $uuid . '/' . $version.'/15';
					$navs[2]['valid'] = $item_array['validation']['part_2']['valid'];
					$navs[2]['text'] = 'Step 2: Upload';
					$navs[2]['active'] = 'inactive';
					$navs[2]['disabled'] = false;
					
					
					$navs[3]['url'] = 'rhd/coursework/getThesis_part3/' . $uuid. '/' . $version.'/15';
					$navs[3]['valid'] = $item_array['validation']['part_3']['valid'];
					$navs[3]['text'] = 'Step 3: Public Release';
					$navs[3]['active'] = 'inactive';
					$navs[3]['disabled'] = false;
					
					$navs[4]['url'] = 'rhd/coursework/getThesis_part4/' . $uuid. '/' . $version.'/15';
					$navs[4]['text'] = 'Step 4: Submit';
					$navs[4]['active'] = 'active';
					$navs[4]['disabled'] = false;
				}
				else
				{
					$navs[1]['url'] = 'rhd/coursework/getThesis_part1/' . $uuid . '/' . $version;
					$navs[1]['valid'] = $item_array['validation']['part_1']['valid'];
					$navs[1]['text'] = 'Step 1: About';
					$navs[1]['active'] = 'inactive';
					$navs[1]['disabled'] = false;
					
					$navs[2]['url'] = 'rhd/coursework/getThesis_part2/' . $uuid . '/' . $version.'/';
					$navs[2]['valid'] = $item_array['validation']['part_2']['valid'];
					$navs[2]['text'] = 'Step 2: Upload';
					$navs[2]['active'] = 'inactive';
					$navs[2]['disabled'] = false;
					
					
					$navs[3]['url'] = 'rhd/coursework/getThesis_part3/' . $uuid. '/' . $version.'/';
					$navs[3]['valid'] = $item_array['validation']['part_3']['valid'];
					$navs[3]['text'] = 'Step 3: Public Release';
					$navs[3]['active'] = 'inactive';
					$navs[3]['disabled'] = false;
					
					$navs[4]['url'] = 'rhd/coursework/getThesis_part4/' . $uuid. '/' . $version.'/';
					$navs[4]['text'] = 'Step 4: Submit';
					$navs[4]['active'] = 'active';
					$navs[4]['disabled'] = false;
				}
				
				$item_array['navs'] = $navs;
				
				$item_array['uuid'] = $uuid;
				$item_array['version'] = $version;
				
				$item_array['new_thesis'] = $new;
				$item_array['status'] = $response['status'];
				
				$this->load->view('rhd/step4', $item_array);
			}
			else
			{
				$navs[1]['url'] = 'rhd/coursework/getThesis_part1/' . $uuid . '/' . $version;
				$navs[1]['valid'] = $item_array['validation']['part_1']['valid'];
				$navs[1]['text'] = 'Step 1: About';
				$navs[1]['active'] = 'active';
				$navs[1]['disabled'] = false;
				
				$navs[2]['url'] = 'rhd/coursework/getThesis_part2/' . $uuid . '/' . $version.'/';
				$navs[2]['valid'] = $item_array['validation']['part_2']['valid'];
				$navs[2]['text'] = 'Step 2: Upload';
				$navs[2]['active'] = 'inactive';
				$navs[2]['disabled'] = false;
				
				
				$navs[3]['url'] = 'rhd/coursework/getThesis_part3/' . $uuid. '/' . $version.'/';
				$navs[3]['valid'] = $item_array['validation']['part_3']['valid'];
				$navs[3]['text'] = 'Step 3: Public Release';
				$navs[3]['active'] = 'inactive';
				$navs[3]['disabled'] = false;
				
				$navs[4]['url'] = 'thesis/coursework';
				$navs[4]['text'] = 'Step 4: Submit';
				$navs[4]['active'] = 'inactive';
				$navs[4]['disabled'] = false;
				
				$item_array['navs'] = $navs;
				
				$item_array['uuid'] = $uuid;
				$item_array['version'] = $version;
				
				if(isset($item_array['abstract_attachment']) && strlen($item_array['abstract_attachment'][1]['uuid']) == 36)
				{
					
					foreach ($response['attachments'] as $attachment) 
					{
						
						if($attachment['uuid'] == $item_array['abstract_attachment'][1]['uuid'])
						{
							$item_array['abstract_attachment'][1]['filename'] = addslashes($attachment['filename']);
							$item_array['abstract_attachment'][1]['filesize'] = $attachment['size'];
							$item_array['abstract_attachment'][1]['filelink'] = $attachment['links']['view'];
							break;
						}
					}
				}
			
			
				$item_array['schools'] = $this->getSchools();
				$item_array['token'] = $this->generateToken($_SESSION['fan']);
				
				
				$item_array['new_thesis'] = $new;
				$item_array['status'] = $response['status'];
			
				$this->load->view('rhd/step1', $item_array);
			}
			
		}
		
		
		/*****************************************************************
			AJAX CALL:  create a new RHD Thesis 
		*****************************************************************/ 
		public function createRHD()
		{
			$this->load->helper('url');
			$ci = & get_instance();
		
			if(!isset($_SERVER['REMOTE_USER']))
            {
				$result['status'] = "session_time_out";
                $result['error_info'] = 'Session Expired';
                echo json_encode($result);
                return;
            }
          
			$coursework_collection_id = $ci->config->item('coursework_thesis_collection');
			$rhd_schools_taxonomy_uuid = $ci->config->item('rhd_schools_taxonomy_uuid'); 
			
			$userUuid = $_SERVER['REMOTE_USER'];
			$result['status'] = "failed";
            $result['error_info'] = ""; 
			
			$oauth = array('oauth_client_config_name' => 'rhd');
			$this->load->library('flexrest/flexrest', $oauth);
			$success = $this->flexrest->processClientCredentialToken();
            if(!$success)
            {
                $result['status'] = "error";
                $result['error_info'] = 'Internal error, please try again or contact flex.help@flinders.edu.au';
				log_message('error', 'Internal error, please try again or contact flex.help@flinders.edu.au' . ', error: ' . $errdata['error_info']);
                echo json_encode($result);
                return;
            }
			
			$this->load->library('form_validation');
			//form validation rules
			$this->form_validation->set_rules('stu_pre_first_name', 'Student Prefered First Name', 'xss_clean');
			$this->form_validation->set_rules('stu_pre_last_name', 'Student Prefered Last Name', 'xss_clean');
			$this->form_validation->set_rules('stu_email', 'Student Email', 'required|valid_email');
			$this->form_validation->set_rules('comp_yr', 'Complete Year', 'required|callback_year_check');
			$this->form_validation->set_rules('school', 'School', 'required|xss_clean');
			$this->form_validation->set_rules('thesis_type', 'Thesis Type', 'required|required|xss_clean');
			$this->form_validation->set_rules('sup_name', 'Principle Supervisor Name', 'required|xss_clean');
			$this->form_validation->set_rules('sup_email', 'Supervisor Email', 'valid_email');
			$this->form_validation->set_rules('thesis_title', 'Thesis title', 'required|xss_clean');
			$this->form_validation->set_rules('thesis_abstract', 'Abstract', 'required|xss_clean');
			$this->form_validation->set_rules('keywords', 'Thesis Keywords', 'required|xss_clean');
			
			if ($this->form_validation->run() == FALSE)
			{
				$result['status'] = "error"; 
				$result['error_info'] = "invalid input";
				echo json_encode($result);
				return;
			}
			else
			{	
				$title = $this->input->post("thesis_title", TRUE); 
			
			
				/**********************************************
				 search thesis title in existing contributions.
				 **********************************************/
				
				//build up search query
				$where = "/xml/item/curriculum/people/students/student/fan='".$userUuid."' OR ";
				$where = $where . "/xml/item/curriculum/people/students/student/fan='" . strtoupper($userUuid) ."'";
				$where = urlencode($where);
				$searchsuccess = $this->flexrest->search($response, '', $coursework_collection_id, $where, 0, 50, 'modified', false, 'all', true);
				
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
						$result['error_info'] = "Thesis title already existed";
						echo json_encode($result); 
						return;
					}
				}
				
				
				//get post variables
				$stuID = htmlentities($this->input->post('stu_id', TRUE));
				$stuFirstName = htmlentities($this->input->post("stu_pre_first_name")); 
				$stuLastName = htmlentities($this->input->post("stu_pre_last_name")); 
				
				$stuEmail = $this->trim_all($this->input->post("stu_email"));  
				
				$thesisType = $this->input->post("thesis_type", TRUE);
				
				$compYr = $this->input->post("comp_yr", TRUE);
				$school_org_unit = $this->input->post("school", TRUE);
				
				$supName =  htmlentities($this->input->post("sup_name", TRUE)); 
				$supEmail = $this->trim_all($this->input->post("sup_email")); 
				
				$abstract = htmlentities($this->input->post("thesis_abstract", TRUE)); 

				$abstract_file = isset($_FILES['abstract_file']) ? $_FILES['abstract_file'] : '';
				
				$keywords = htmlentities($this->input->post("keywords", TRUE)); 
				
				/** topics **/
				$topics = array();
				
				$topic_code = $this->input->post("topic_code"); 
				
				if($topic_code!= '')
				{
					for($x=0; $x < count($topic_code); $x++)
					{
						$topics[$x]['code'] = $topic_code[$x];
					}
				}
				
				$topic_name = $this->input->post("topic_name"); 
				if($topic_name!= '')
				{
					for($x=0; $x < count($topic_name); $x++)
					{
						$topics[$x]['name']=  htmlentities($topic_name[$x]);
					}
				}
			
				$item_bean["collection"]["uuid"] = $coursework_collection_id;
				
				//root node
				$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => '<xml><item></item></xml>'));			
				
				//thesis title, item name
				$thesis_name = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/thesis/title");
				$this->xmlwrapper->createTextNode($thesis_name, $title);
				
				//abstract
				if($abstract != false)
				{
					$a = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/thesis/version/abstract/text");
					$this->xmlwrapper->createTextNode($a, $abstract);
				}
				
				// thesis type
				$thesis_node = $this->xmlwrapper->node("/xml/item/curriculum/thesis");
				$thesis_type = $this->xmlwrapper->createAttribute($thesis_node, "selected_type");
				$this->xmlwrapper->createTextNode($thesis_type, $thesisType);
				
				//topic subtrees
				if(count($topics)> 0)
				{
					$topics_root_xpath = "/xml/item/curriculum/topics";
					$this->xmlwrapper->deleteNodeFromXPath($topics_root_xpath); 
					$node_topics = $this->xmlwrapper->createNodeFromXPath($topics_root_xpath); 
					for($i=0; $i<count($topics); $i++)
					{
						$node_topic = $this->xmlwrapper->createNode($node_topics, "topic");
						$node_code= $this->xmlwrapper->createNode($node_topic, "code");
						$node_name = $this->xmlwrapper->createNode($node_topic, "name");
						
						$node_code->nodeValue = $topics[$i]['code']; 
						$node_name->nodeValue = $topics[$i]['name'];
					}
				}
				
				// student fan 
				$stu_fan = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/students/student/fan");
				$this->xmlwrapper->createTextNode($stu_fan, $userUuid);
				
				$this->load->library('ldap/ldap', $oauth);
				$ldap_user = $ci->ldap->get_attributes($_SESSION['fan']);
				$ld_gn =  htmlentities($ldap_user['givenname']);
				$ld_sn = htmlentities($ldap_user['sn']);
				
				//student ID
				$stu_node = $this->xmlwrapper->node("/xml/item/curriculum/people/students/student");
				$student_ID = $this->xmlwrapper->createAttribute($stu_node, "id");
				
				if(!$stuID || $stuID == '')
				{
						foreach($user_groups as $user_group)
						{
							if(strtolower($user_group) == 'cn=student,ou=groups,o=flinders')
							{
								$stu_id = isset($ldap_user['user_info']['flindersPersonStudentNumber'][0])? $ldap_user['user_info']['flindersPersonStudentNumber'][0] : '';
							}
						}
				}
				$this->xmlwrapper->createTextNode($student_ID, $stuID);
				
				//student name
				
				
				$stu_first_name = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/students/student/firstname");
				$this->xmlwrapper->createTextNode($stu_first_name, $ld_gn);
				
				$stu_last_name = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/students/student/lastname");
				$this->xmlwrapper->createTextNode($stu_last_name,  $ld_sn);
				
				if($stuFirstName == '')
				{
					$stuFirstName = $ldap_user['givenname'];
				}
				$stu_first_display = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/students/student/firstname_display");
				$this->xmlwrapper->createTextNode($stu_first_display, $stuFirstName);
				
				
				if($stuLastName == '')
				{
					$stuLastName = $ldap_user['sn'];
				}
				$stu_last_display = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/students/student/lastname_display");
				$this->xmlwrapper->createTextNode($stu_last_display, $stuLastName);
				
				//student email
				$owner_email = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/students/student/email");
				$this->xmlwrapper->createTextNode($owner_email, $stuEmail);
				
				//supervisor name
				$supervisor_name = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/coords/coord/name");
				$this->xmlwrapper->createTextNode($supervisor_name, $supName);
				
				//supervisor email
				$supervisor_email = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/coords/coord/email");
				$this->xmlwrapper->createTextNode($supervisor_email, $supEmail?$supEmail:'');
				
				//complete year
				$complete_year = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/thesis/complete_date");
				$this->xmlwrapper->createTextNode($complete_year, $compYr?$compYr.'-12-01':'');
				
				//information lock
				$infor_lock = $this->xmlwrapper->createNodeFromXPath("/xml/item/sys_variables/locks/information");
				$this->xmlwrapper->createTextNode($infor_lock, "Yes");
				
				//keywords
				$keyword = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/thesis/keywords/keyword");
				$this->xmlwrapper->createTextNode($keyword, $keywords? $keywords:'');
				
				//school
					//get school name from Taxonomy
					$school_name = '';
					$this->flexrest->getTaxonomy($rhd_schools_taxonomy_uuid, $r);
					if(count($r)>=1)
					{
						$schools[0]['text'] = '';
						$schools[0]['value']='#';
						for($i=0; $i < count($r); $i++)
						{
							if(isset($r[$i]['term']) && $r[$i]['term']!= '')
							{	
								$this->flexrest->getTermData($rhd_schools_taxonomy_uuid, $r[$i]['uuid'], 'org_unit', $r_data);
								if($school_org_unit == ($r_data['org_unit']))
								{
									$school_name = $r[$i]['term'];
								}
							}
						}
					}
				
				if($school_name != '')
				{
					$school = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/thesis/schools/primary");
					$this->xmlwrapper->createTextNode($school, $school_name);
				}
			
				
				$item_bean['metadata'] = $this->xmlwrapper->__toString();
				
				// public function createItem ($item_bean, &$response, $filearea_uuid=null, $draft=false, $waitforindex=false)
				$success = $this->flexrest->createDraftItem($item_bean, $response);

				if(!$success)
				{
					$errdata['message'] = $this->flexrest->error;
					log_message('error', 'Thesis createItem failed' . ', error: ' . $errdata['message']);
					$result['status'] = "error";
					$result['error_info'] = $this->flexrest->error;
					echo json_encode($result);
					return;
				}
				
				if(!isset($response['headers']['location']))
				{
					$errdata['message'] = 'No Location header in createItem response.';
					log_message('error', 'coursework thesis createItem failed' . ', error: ' . $errdata['message']);
					$result['status'] = "error";
					$result['error_info'] = $errdata['message'];
					echo json_encode($result);
					return;
				}
				
				$location = $response['headers']['location'];
				$uuid = substr($location, strpos($location, 'item')+5, 36);
				$version = substr($location, strpos($location, 'item')+42, (strlen($location)-1-(strpos($location, 'item')+42)));
				
				//IF there is no abstract file needs to upload
				//THEN return to the view
				if(!isset($_FILES['abstract_file']['name'][0]))
				{
					if($result['status'] == "failed")
					{ 	
						$result['status'] = "success";
						$result['uuid'] = $uuid;
						$result['version'] = $version;
						$result['itemName'] = $title;
						$result['token'] = $this->generateToken($userUuid);
					}
					
					echo json_encode($result); 
					return;
				}
				else //IF abstract file exists, upload file
				{
					//get item to upload files. 
					$s = $this->flexrest->getItem($uuid, $version, $r_item);
					if(!$s)
					{
						$result['status'] = "error";
						log_message('error', 'Get Item failed' . ', error: ' . $uuid);
						$result['error_info'] = 'Get Item failed' . ', error: ' . $uuid;
						$result['uuid'] = $uuid;
						echo json_encode($result);
						return;
					}
					
					$new_item_bean = $r_item;
				 
					//echo $item_bean['metadata'] . "\n\n";
					 
					$xmlwrapper = 'xmlwrapper_new_thesis';
				
					//pull out metadata XML 
					$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$new_item_bean['metadata']), $xmlwrapper);
					//generate atatchment
					
					$success = $this->flexrest->newFileArea($r);
					if(!$success)
					{
						$result['status'] = "f_error";
						log_message('error', '1369 Failed to create new file area, item uuid: ' . $uuid . ', error: ' . $this->flexrest->error);
						$result['error_info'] = 'Failed to create new file area, item uuid: ' . $uuid . ', error: ' . $this->flexrest->error;
						$result['uuid'] = $uuid;
						echo json_encode($result);
						return;
					}
					
					if(!isset($r['uuid']) || $r['uuid']=='')
					{
						$result['status'] = "f_error";
						log_message('error', 'File area uuid does not exist, item uuid: ' . $uuid);
						$result['error_info'] = 'File area uuid does not exist, item uuid: ' . $uuid;
						$result['uuid'] = $uuid;
						echo json_encode($result);
						return;
					}
					
					$filearea_uuid = $r['uuid'];
					
					
					$success = $this->flexrest->fileUpload($filearea_uuid, htmlentities($abstract_file['name']), file_get_contents($abstract_file['tmp_name']), $r);
					if(!$success)
					{
						$result['status'] = "f_error";
						$errdata['message'] = $this->flexrest->error;
						log_message('error', 'Attachment failed (fileUpload), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
						$result['error_info'] = 'Attachment upload failed. Abstract PDF file name CAN NOT contain any special characters, eg. " . < > ? ; &';
						$result['uuid'] = $uuid;
						echo json_encode($result);
						return;
					}
					
					/*$str = 'file area uuid: '. $filearea_uuid . ' file name ' .$r['filename']. ' file size:' .$r['size'] . ' file links" ' . $r['links']['content'] ;
					echo $str;
					return;*/
					
					$file_uuid = sprintf("%03d", 0);
					$file_uuid = substr($uuid, 0, 33) . $file_uuid;
					$new_attachments[0] = array('type'=>'file', 
												'filename'=> $r['filename'], 
												'description'=> $r['filename'],
												'uuid'=>$file_uuid);
												
					$xpath_files = "/xml/item/curriculum/thesis/version/abstract/uuid";
					$node_files = $this->$xmlwrapper->createNodeFromXPath($xpath_files);
					$this->$xmlwrapper->createTextNode($node_files, $file_uuid);							
												
					$new_item_bean['attachments'] = $new_attachments;
					$new_item_bean['metadata'] = $this->$xmlwrapper->__toString();
					
					$success = $this->flexrest->editItem($uuid, $version, $new_item_bean, $response3, $filearea_uuid);
					
					if(!$success)
					{
						$result['status'] = "f_error";
						$errdata['message'] = $this->flexrest->error;
						log_message('error', 'Failed to edit item, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
						$result['error_info'] = 'Failed to edit item, item uuid: ' . $uuid . ', error: ' . $errdata['message'];
						$result['uuid'] = $uuid;
						echo json_encode($result);
						return;
					}
					
					
					
					if($result['status'] == "failed")
					{
						$result['status'] = "success";
					}
					$result['uuid'] = $uuid;
					$result['version'] = $version;
					$result['itemName'] = $title;
					$result['token'] = $this->generateToken($userUuid);
					
					echo json_encode($result); 
				}
			}
		}
		/*****************************************************************
			AJAX CALL:  Edit part 1: About yoou and your thesis
		*****************************************************************/ 
		public function getTopicInfo()
		{
			$this->load->helper('url');
			$ci = & get_instance();
			
			$oauth = array('oauth_client_config_name' => 'rhd');
			$this->load->library('flexrest/flexrest', $oauth);
			$success = $this->flexrest->processClientCredentialToken();
            if(!$success)
            {
                return;
            }
			if(isset($_POST['topic_code']))
			{
				$code = $_POST['topic_code'];
				
				$topic_collection_uuid = '53ff320d-c227-4224-862a-bfdba4176bc0';
				$this->flexrest->getTaxonomy($topic_collection_uuid, $r);
				
				$topic_info = array();
				
				if(count($r)>=1)
				{
					for($i=0; $i < count($r); $i++)
					{
						if(isset($r[$i]['term']) && $r[$i]['term']!= '')
						{
							if($r[$i]['term'] == $code)
							{
								$this->flexrest->getTermData($topic_collection_uuid, $r[$i]['uuid'], 'topic_name', $r_data);
							 	$topic_info['name'] = isset($r_data['topic_name']) ? $r_data['topic_name'] : '';
								
								$this->flexrest->getTermData($topic_collection_uuid, $r[$i]['uuid'], 'topic_coord', $r_data);
								$topic_info['topic_coord'] = isset($r_data['topic_coord']) ? $r_data['topic_coord'] : '';
							
								$this->flexrest->getTermData($topic_collection_uuid, $r[$i]['uuid'], 'org_unit', $r_data);
								$topic_info['org_unit'] = isset($r_data['org_unit']) ? $r_data['org_unit'] : '';
								
								break;
							}
						}
					}
				}
				echo json_encode($topic_info);
			}
		}
		
		
		public function edit_part1()
		{
			$this->load->helper('url');
			$ci = & get_instance();
			
			$result['status'] = "failed";
            $result['error_info'] = "";
			
			if(!isset($_SERVER['REMOTE_USER']))
            {
               	$result['status'] = 'session_time_out';
                $result['error_info'] = "Session Time Out";
                echo json_encode($result);
				return;
            }
           
			$coursework_collection_id = $ci->config->item('coursework_thesis_collection');
			$rhd_schools_taxonomy_uuid = $ci->config->item('rhd_schools_taxonomy_uuid'); 
			
			$userUuid = $_SERVER['REMOTE_USER'];
		
			$oauth = array('oauth_client_config_name' => 'rhd');
			$this->load->library('flexrest/flexrest', $oauth);
			$success = $this->flexrest->processClientCredentialToken();
            if(!$success)
            {
				$result['status'] = "error";
            	$result['error_info'] = $this->flexrest->error;
                echo json_encode($result);
                return;
            }
			
			$this->load->library('form_validation');
			//form validation rules
			//$this->form_validation->set_rules('stu_id', 'Student ID', '|min_length[5]|xss_clean');
			$this->form_validation->set_rules('stu_pre_first_name', 'Student Prefered First Name', 'xss_clean');
			$this->form_validation->set_rules('stu_pre_last_name', 'Student Prefered Last Name', 'xss_clean');
			$this->form_validation->set_rules('stu_email', 'Student Email', 'required|valid_email');
			$this->form_validation->set_rules('comp_yr', 'Complete Year', 'required|callback_year_check');
			$this->form_validation->set_rules('school', 'School', 'required|xss_clean');
			$this->form_validation->set_rules('thesis_type', 'Thesis Type', 'required|xss_clean');
			$this->form_validation->set_rules('sup_name', 'Principle Supervisor Name', 'required|xss_clean');
			$this->form_validation->set_rules('sup_email', 'Supervisor Email', 'valid_email');
			$this->form_validation->set_rules('thesis_title', 'Thesis title', 'required|xss_clean');
			$this->form_validation->set_rules('thesis_abstract', 'Abstract', 'required|xss_clean');
			$this->form_validation->set_rules('keywords', 'Thesis Keywords', 'required|xss_clean');
			
			if ($this->form_validation->run() == FALSE)
			{
				$result['status'] = "invalid";
				$result['error_info'] = "One or more invalid inputs."; 
				echo json_encode($result);
				return;
			}
			else
			{	
				//get post variables
				$new_thesis = $this->input->post('new_thesis');
				$item_uuid = $this->input->post('item_uuid');
				$item_version = $this->input->post('item_version');
				$stuID = $this->input->post('stu_id');
				
				$stuFirstName =  htmlentities($this->input->post("stu_pre_first_name")); 
				$stuLastName =  htmlentities($this->input->post("stu_pre_last_name")); 
				
				$stuEmail = $this->trim_all($this->input->post("stu_email"));  
				
				$thesisType = $this->input->post("thesis_type", TRUE);
				
				$compYr = $this->input->post("comp_yr", TRUE);
				$school_org_unit = htmlentities($this->input->post("school", TRUE));
				
				$supName =  htmlentities($this->input->post("sup_name", TRUE)); 
				$supEmail =  htmlentities($this->input->post("sup_email")); 
				
				$title =  htmlentities($this->input->post("thesis_title", TRUE)); 
				//$title = htmlentities($_POST['thesis_title']);
				$abstract =  htmlentities($this->input->post("thesis_abstract", TRUE)); 

				$abstract_file = isset($_FILES['abstract_file']) ? $_FILES['abstract_file'] : '';
				
				$keywords =  htmlentities($this->input->post("keywords", TRUE)); 
				
				/** topics **/
				$topics = array();
				
				$topic_code = $this->input->post("topic_code"); 
				
				if($topic_code!= '')
				{
					for($x=0; $x < count($topic_code); $x++)
					{
						$topics[$x]['code'] = $topic_code[$x];
					}
				}
				
				$topic_name = $this->input->post("topic_name"); 
				if($topic_name!= '')
				{
					for($x=0; $x < count($topic_name); $x++)
					{
						$topics[$x]['name'] = htmlentities($topic_name[$x]);
					}
				}
				
				
				$default_abstract_file = $this->input->post("default_abstract_file"); 
				
				$s = $this->flexrest->getItem($item_uuid, $item_version, $r_item);
				
				if(!$s)
				{
					$result['status'] = "error";
					log_message('error', 'Get Item failed' . ', error: ' . $item_uuid);
					$result['error_info'] = 'Get Item failed, please try again or contact flex.help@flinders.edu.au';
					echo json_encode($result);
					return;
				}
					
				$new_item_bean = $r_item;
				
				$xmlwrapper = 'xmlwrapper_' . $item_uuid;
			
				//pull out metadata XML 
				$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$new_item_bean['metadata']), $xmlwrapper);
				
				//thesis title, item name
				if($this->$xmlwrapper->nodeExists('/xml/item/curriculum/thesis/title'))
				{
					$this->$xmlwrapper->setNodeValue('/xml/item/curriculum/thesis/title', $title);
				}
				else
				{  
					$thesis_name = $this->$xmlwrapper->createNodeFromXPath("/xml/item/curriculum/thesis/title");
					$this->$xmlwrapper->createTextNode($thesis_name, $title, true);
				}
				
				//abstract
				if($this->$xmlwrapper->nodeExists('/xml/item/curriculum/thesis/version/abstract/text'))
				{
					$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/thesis/version/abstract/text", $abstract, true);
				}
				else
				{
					$a = $this->$xmlwrapper->createNodeFromXPath("/xml/item/curriculum/thesis/version/abstract/text");
					$this->$xmlwrapper->createTextNode($a, $abstract);
				}
				
				// thesis type
				if($this->$xmlwrapper->nodeExists('/xml/item/curriculum/thesis/@selected_type'))
				{
					$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/thesis/@selected_type", $thesisType, true);
				}
				else
				{
					$thesis_node = $this->$xmlwrapper->node("/xml/item/curriculum/thesis");
					$thesis_type = $this->$xmlwrapper->createAttribute($thesis_node, "selected_type");
					$this->$xmlwrapper->createTextNode($thesis_type, $thesisType);
				}
				 
				//topic subtrees
				if(count($topics)> 0)
				{
					$topics_root_xpath = "/xml/item/curriculum/topics";
					$this->$xmlwrapper->deleteNodeFromXPath($topics_root_xpath); 
					$node_topics = $this->$xmlwrapper->createNodeFromXPath($topics_root_xpath); 
					for($i=0; $i<count($topics); $i++)
					{
						$node_topic = $this->$xmlwrapper->createNode($node_topics, "topic");
						$node_code= $this->$xmlwrapper->createNode($node_topic, "code");
						$node_name = $this->$xmlwrapper->createNode($node_topic, "name");
						
						$node_code->nodeValue = $topics[$i]['code']; 
						$node_name->nodeValue = $topics[$i]['name'];
					}
				}
				
				//student ID
				$this->load->library('ldap/ldap', $oauth);
				$ldap_user = $ci->ldap->get_attributes($_SESSION['fan']);
				
				$ld_sn = htmlentities($ldap_user['sn']);
				$ld_gn = htmlentities($ldap_user['givenname']);
				if(!$stuID || $stu_ID == '')
				{
					if(count($user_group) >0)
					{
						foreach($user_groups as $user_group)
						{
							if(strtolower($user_group) == 'cn=student,ou=groups,o=flinders')
							{
								$stu_id = isset($ldap_user['user_info']['flindersPersonStudentNumber'][0])? $ldap_user['user_info']['flindersPersonStudentNumber'][0] : '';
							}
						}
					}
				}
				
				if($this->$xmlwrapper->nodeExists('/xml/item/curriculum/people/students/student/@id'))
				{
					
					$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/people/students/student/@id", $stuID, true);
				}
				else
				{
					$stu_node = $this->$xmlwrapper->node("/xml/item/curriculum/people/students/student");
					$student_ID = $this->$xmlwrapper->createAttribute($stu_node, "id");
					$this->$xmlwrapper->createTextNode($student_ID, $stuID);
				}
				
				
				//student fan
				
				if($this->$xmlwrapper->nodeExists('/xml/item/curriculum/people/students/student/fan'))
				{
					$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/people/students/student/fan", $_SESSION['fan'], true);
				}
				else
				{
					$owner_fan = $this->$xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/students/student/fan");
					$this->$xmlwrapper->createTextNode($owner_fan, $_SESSION['fan']);
				}
				
				//student names
				$this->load->library('ldap/ldap', $oauth);
				$ldap_user = $ci->ldap->get_attributes($_SESSION['fan']);
			    if(!$ci->ldap->success)
				{
					$result['status'] = "error";
					$result['error_info'] = "Failed to get user information from Ldap, please try again";
					echo json_encode($result); 
					return;
				}
				
				if($this->$xmlwrapper->nodeExists('/xml/item/curriculum/people/students/student/firstname'))
				{
					$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/people/students/student/firstname", $ld_gn, true);
				}
				else
				{
					$stu = $this->$xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/students/student/firstname");
					$this->$xmlwrapper->createTextNode($stu, $ld_gn);
				}
				
				if($this->$xmlwrapper->nodeExists('/xml/item/curriculum/people/students/student/lastname'))
				{
					$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/people/students/student/lastname", $ld_sn, true);
				}
				else
				{
					$stu = $this->$xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/students/student/lastname");
					$this->$xmlwrapper->createTextNode($stu, $ld_sn);
				}
			
				if($stuFirstName == '')
				{
					$stuFirstName = htmlentities($ldap_user['givenname']);
				}
				if($this->$xmlwrapper->nodeExists('/xml/item/curriculum/people/students/student/firstname_display'))
				{
					
					$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/people/students/student/firstname_display", $stuFirstName, true);
				}
				else
				{
					$stu = $this->$xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/students/student/firstname_display");
					$this->$xmlwrapper->createTextNode($stu, $stuFirstName);
				}
				
				
				if($stuLastName == '')
				{
					$stuLastName = $ld_sn;
				}
				
				if($this->$xmlwrapper->nodeExists('/xml/item/curriculum/people/students/student/lastname_display'))
				{
					$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/people/students/student/lastname_display", $stuLastName, true);
				}
				else
				{
					$stu = $this->$xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/students/student/lastname_display");
					$this->$xmlwrapper->createTextNode($stu, $stuLastName);
				}
				
				//student email
				if($this->$xmlwrapper->nodeExists('/xml/item/curriculum/people/students/student/email'))
				{
					$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/people/students/student/email", $this->trim_all($stuEmail), true);
				}
				else
				{
					$owner_email = $this->$xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/students/student/email");
					$this->$xmlwrapper->createTextNode($owner_email, $this->trim_all($stuEmail));
				}
				
				//supervisor name
				if($this->$xmlwrapper->nodeExists('/xml/item/curriculum/people/coords/coord/name'))
				{
					$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/people/coords/coord/name",$this->trim_all($supName), true);
				}
				else
				{
					$supervisor_name = $this->$xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/coords/coord/name");
					$this->$xmlwrapper->createTextNode($supervisor_name, $this->trim_all($supName));
				}
				
				//supervisor email
				if($this->$xmlwrapper->nodeExists('/xml/item/curriculum/people/coords/coord/email'))
				{
					$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/people/coords/coord/email",$supEmail?$this->trim_all($supEmail):'', true);
				}
				else
				{
					$supervisor_email = $this->$xmlwrapper->createNodeFromXPath("/xml/item/curriculum/people/coords/coord/email");
					$this->$xmlwrapper->createTextNode($supervisor_email, $supEmail?$this->trim_all($supEmail):'');
				}
				
				//complete date -> would automatically save year in complete year node 
				if($this->$xmlwrapper->nodeExists('/xml/item/curriculum/thesis/complete_date'))
				{
					$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/thesis/complete_date",$compYr?$compYr.'-12-01':'', true);
				}
				else
				{
					$complete_year = $this->$xmlwrapper->createNodeFromXPath("/xml/item/curriculum/thesis/complete_date");
					$this->$xmlwrapper->createTextNode($complete_year, $compYr?$compYr.'-12-01':'');
				}
				
				//keywords
				if($this->$xmlwrapper->nodeExists('/xml/item/curriculum/thesis/keywords/keyword'))
				{
					$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/thesis/keywords/keyword",$keywords?$this->trim_all($keywords):'', true);
				}
				else
				{
					$keyword = $this->$xmlwrapper->createNodeFromXPath("/xml/item/curriculum/thesis/keywords/keyword");
					$this->$xmlwrapper->createTextNode($keyword, $keywords?$this->trim_all($keywords):'');
				}
				
				//school
				//get school name from Taxonomy
				$school_name = '';
				$this->flexrest->getTaxonomy($rhd_schools_taxonomy_uuid, $r);
				if(count($r)>=1)
				{
					$schools[0]['text'] = '';
					$schools[0]['value']='#';
					for($i=0; $i < count($r); $i++)
					{
						if(isset($r[$i]['term']) && $r[$i]['term']!= '')
						{	
							$this->flexrest->getTermData($rhd_schools_taxonomy_uuid, $r[$i]['uuid'], 'org_unit', $r_data);
							if($school_org_unit == ($r_data['org_unit']))
							{
								$school_name = $r[$i]['term'];
							}
						}
					}
				}
				
				if($school_name != '')
				{
					if($this->$xmlwrapper->nodeExists('/xml/item/curriculum/thesis/schools/primary'))
					{
						$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/thesis/schools/primary",$school_name, true);
					}
					else
					{
						$school = $this->xmlwrapper->createNodeFromXPath("/xml/item/curriculum/thesis/schools/primary");
						$this->xmlwrapper->createTextNode($school, $school_name);
					}
				}
				
				
				//IF abstract file attachment already exists AND current POST File needs to upload
				//THEN delete the old attachment -> create a new one
				//ELSE IF abstract file attachment doesn't exists AND current POST File needs to upload
				//just create a new one
				$filearea_uuid = '';
				
				if($default_abstract_file == 'true'  || $default_abstract_file == true)
				{
					if(isset($abstract_file['name']) && $abstract_file['name']!= '')
					{
						if($this->$xmlwrapper->nodeExists('/xml/item/curriculum/thesis/version/abstract/uuid'))
						{
							$existing_abstract_uuid = $this->$xmlwrapper->nodeValue('/xml/item/curriculum/thesis/version/abstract/uuid');
							
							$existing_abstract_item_uuid = '';
							$existing_file_path = '';
							
							//get old attachment file path
							foreach ($r_item['attachments'] as $attachment) 
							{
								if($existing_abstract_uuid == $attachment['uuid'])
								{
									$existing_abstract_item_uuid = $attachment['uuid'];
									$existing_file_path = $attachment['filename'];
									break;
								}
							}
						
							//Delete old attachment and then create a new attachemnt IF new abstract pdf 
							if(strlen($existing_abstract_item_uuid) == 36 && $existing_file_path!= '')
							{
								$filearea_uuid = '';
								if(count($r_item['attachments']) >0)
								{
									//copy item files to a filearea, get the filearea uuid
									$success = $this->flexrest->filesCopy($item_uuid, $item_version, $response1);
									if(!$success)
									{
										$result['status'] = "error";
										$errdata['message'] = $this->flexrest->error;
										log_message('error', '1910. Failed to copy file, item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
										$result['error_info'] = '1910. Failed to copy file, please try again or contact flex.help@flinders.edu.au';
										echo json_encode($result);
										return;
									}
									if(!isset($response1['headers']['location']))
									{
										$errdata['message'] = 'No Location header in response to copy files REST call.';
										log_message('error', 'No Location header in response to copy files REST call. item uuid: ' . $item_uuid  . ', error: ' . $errdata['message']);
										$result['error_info'] = 'No Location header in response to copy files REST call';
										echo json_encode($result);
										return;
									}
									$location = $response1['headers']['location'];
									
									$filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
			
								}
								else
								{
									$success = $this->flexrest->newFileArea($r);
									if(!$success)
									{
										$result['status'] = "error";
										log_message('error', '1369 Failed to create new file area, item uuid: ' . $uuid . ', error: ' . $this->flexrest->error);
										$result['error_info'] = '1369. Failed to create new file area, item uuid: ' . $uuid . ', error: ' . $this->flexrest->error;
										echo json_encode($result);
										return;
									}
									
									if(!isset($r['uuid']) || $r['uuid']=='')
									{
										$result['status'] = "error";
										log_message('error', 'File area uuid does not exist, item uuid: ' . $uuid);
										$result['error_info'] = 'File area uuid does not exist, item uuid: ' . $uuid;
										echo json_encode($result);
										return;
									}
									
									$filearea_uuid = $r['uuid'];
									
								}
								
								//Delete attachemnt in XML
								$this->$xmlwrapper->deleteNodeFromXPath('/xml/item/curriculum/thesis/version/abstract/uuid');    
								
								$success = $this->flexrest->fileUpload($filearea_uuid, htmlentities($abstract_file['name']), file_get_contents($abstract_file['tmp_name']), $r);
								if(!$success)
								{
									$result['status'] = "error";
									$errdata['message'] = $this->flexrest->error;
									log_message('error', 'Attachment failed (fileUpload), item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
									$result['error_info'] = 'Attachment upload failed. Abstract PDF file name CAN NOT contain any special characters, eg. " . < > ? ; &';
									echo json_encode($result);
									return;
								}
								
								$file_uuid = sprintf("%03d", 0);
								$file_uuid = substr($filearea_uuid, 0, 33) . $file_uuid;
								$new_attachments = array('type'=>'file', 
															'filename'=> htmlentities($r['filename']), 
															'description'=> htmlentities($r['filename']),
															'uuid'=>$file_uuid);
															
								$xpath_files = "/xml/item/curriculum/thesis/version/abstract/uuid";
								$node_files = $this->$xmlwrapper->createNodeFromXPath($xpath_files);
								$this->$xmlwrapper->createTextNode($node_files, $file_uuid);							
								array_push($new_item_bean['attachments'], $new_attachments);								
							}
							else
							{
								log_message('error', 'No abstract attachment uploaded, failed in getting existing attachment uuid or file path item uuid: ' . $item_uuid  . ', error: ' . $errdata['message']);
								$result['status'] = 'error';
								$result['error_info'] = 'Abstract pdf uploading failed, please try again or contact flex.help@flinders.edu.au';
								echo json_encode($result);
								return;
							}
						}
						else
						{
							$success = $this->flexrest->newFileArea($r);
							if(!$success)
							{
								$result['status'] = "error";
								log_message('error', 'filesCopy failed, item uuid: ' . $item_uuid . ', error: ' . $this->flexrest->error);
								$result['error_info'] = 'filesCopy failed' . $this->flexrest->error . ', please try again or contact flex.help@flinders.edu';
								echo json_encode($result);
								return;
							}
							
							if(!isset($r['uuid']) || $r['uuid']=='')
							{
								$result['status'] = "error";
								log_message('error', 'File area uuid does not exist, item uuid: ' . $item_uuid );
								$result['error_info'] = 'File area uuid does not exist, please try again or contact flex.help@flinders.edu' ;
								echo json_encode($result);
								return;
							}
							
							$filearea_uuid = $r['uuid'];
							
							$success = $this->flexrest->fileUpload($filearea_uuid, htmlentities($abstract_file['name']), file_get_contents($abstract_file['tmp_name']), $r);
							if(!$success)
							{
								$result['status'] = "error";
								$errdata['message'] = $this->flexrest->error;
								log_message('error', 'Attachment failed (fileUpload), item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
								$result['error_info'] = 'Attachment upload failed. Abstract PDF file name CAN NOT contain any special characters, eg. " . < > ?  ; &';
								echo json_encode($result);
								return;
							}
							
							
							$file_uuid = sprintf("%03d", 0);
							$file_uuid = substr($filearea_uuid, 0, 33) . $file_uuid;
							$new_attachments = array('type'=>'file', 
														'filename'=> htmlentities($r['filename']), 
														'description'=> htmlentities($r['filename']),
														'uuid'=>$file_uuid);
														
							$xpath_files = "/xml/item/curriculum/thesis/version/abstract/uuid";
							$node_files = $this->$xmlwrapper->createNodeFromXPath($xpath_files);
							$this->$xmlwrapper->createTextNode($node_files, $file_uuid);							
							array_push($new_item_bean['attachments'], $new_attachments);	
						}
					}
				}
				if($default_abstract_file == 'false' || $default_abstract_file == false)
				{   
					//IF abstract file already exists. delete it
					if($this->$xmlwrapper->nodeExists('/xml/item/curriculum/thesis/version/abstract/uuid'))
					{
						$existing_abstract_uuid = $this->$xmlwrapper->nodeValue('/xml/item/curriculum/thesis/version/abstract/uuid');
						
						$existing_abstract_item_uuid = '';
						$existing_file_path = '';
						$filearea_uuid = '';
						
						if(count($r_item['attachments']) >0)
						{
							//copy item files to a filearea, get the filearea uuid
							$success = $this->flexrest->filesCopy($item_uuid, $item_version, $response1);
							if(!$success)
							{
								$result['status'] = "error";
								$errdata['message'] = $this->flexrest->error;
								log_message('error', '2072. Failed to copy file, item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
								$result['error_info'] = '2072. Failed to copy file, please try again or contact flex.help@flinders.edu.au';
								echo json_encode($result);
								return;
							}
							if(!isset($response1['headers']['location']))
							{
								$errdata['message'] = 'No Location header in response to copy files REST call.';
								log_message('error', 'No Location header in response to copy files REST call. item uuid: ' . $item_uuid  . ', error: ' . $errdata['message']);
								$result['error_info'] = 'No Location header in response to copy files REST call';
								echo json_encode($result);
								return;
							}
							$location = $response1['headers']['location'];
							
							$filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
						}
						else
						{
							$success = $this->flexrest->newFileArea($r);
							if(!$success)
							{
								$result['status'] = "error";
								log_message('error', '1369 Failed to create new file area, item uuid: ' . $uuid . ', error: ' . $this->flexrest->error);
								$result['error_info'] = 'Failed to create new file area, item uuid: ' . $uuid . ', error: ' . $this->flexrest->error;
								echo json_encode($result);
								return;
							}
							
							if(!isset($r['uuid']) || $r['uuid']=='')
							{
								$result['status'] = "error";
								log_message('error', 'File area uuid does not exist, item uuid: ' . $uuid);
								$result['error_info'] = 'File area uuid does not exist, item uuid: ' . $uuid;
								echo json_encode($result);
								return;
							}
							
							$filearea_uuid = $r['uuid'];
							
						}
						
						//Delete attachemnt in XML
						$this->$xmlwrapper->deleteNodeFromXPath('/xml/item/curriculum/thesis/version/abstract/uuid');   
						
						if(isset($_FILES['abstract_file']) && $abstract_file['name']!= '')
						{			
							$success = $this->flexrest->fileUpload($filearea_uuid,  htmlentities($abstract_file['name']), file_get_contents($abstract_file['tmp_name']), $r);
							if(!$success)
							{
								$result['status'] = "error";
								$errdata['message'] = $this->flexrest->error;
								log_message('error', 'Attachment failed (fileUpload), item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
								$result['error_info'] = 'Attachment upload failed. Abstract PDF file name CAN NOT contain any special characters, eg. " . < > ?  ; &';
								echo json_encode($result);
								return;
							}
							
							$file_uuid = sprintf("%03d", 0);
							$file_uuid = substr($filearea_uuid, 0, 33) . $file_uuid;
							$new_attachments = array('type'=>'file', 
														'filename'=> htmlentities($r['filename']), 
														'description'=> htmlentities($r['filename']),
														'uuid'=>$file_uuid);
														
							$xpath_files = "/xml/item/curriculum/thesis/version/abstract/uuid";
							$node_files = $this->$xmlwrapper->createNodeFromXPath($xpath_files);
							$this->$xmlwrapper->createTextNode($node_files, $file_uuid);							
							array_push($new_item_bean['attachments'], $new_attachments);
							//$new_item_bean['attachments'] = $new_attachments;
						}
						
					}
					else
					{
						if(isset($_FILES['abstract_file']) && $abstract_file['name']!= '')
						{
							$filearea_uuid = '';
							if(count($r_item['attachments']) >0)
							{
								//copy item files to a filearea, get the filearea uuid
								$success = $this->flexrest->filesCopy($item_uuid, $item_version, $response1);
								if(!$success)
								{
									$result['status'] = "error";
									$errdata['message'] = $this->flexrest->error;
									log_message('error', '1910. Failed to copy file, item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
									$result['error_info'] = '1910. Failed to copy file, please try again or contact flex.help@flinders.edu.au';
									echo json_encode($result);
									return;
								}
								if(!isset($response1['headers']['location']))
								{
									$errdata['message'] = 'No Location header in response to copy files REST call.';
									log_message('error', 'No Location header in response to copy files REST call. item uuid: ' . $item_uuid  . ', error: ' . $errdata['message']);
									$result['error_info'] = 'No Location header in response to copy files REST call';
									echo json_encode($result);
									return;
								}
								$location = $response1['headers']['location'];
								
								$filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
		
							}
							else
							{
								$success = $this->flexrest->newFileArea($r);
								if(!$success)
								{
									$result['status'] = "error";
									log_message('error', 'filesCopy failed, item uuid: ' . $item_uuid . ', error: ' . $this->flexrest->error);
									$result['error_info'] = 'filesCopy failed' . $this->flexrest->error . ', please try again or contact flex.help@flinders.edu';
									echo json_encode($result);
									return;
								}
								
								if(!isset($r['uuid']) || $r['uuid']=='')
								{
									$result['status'] = "error";
									log_message('error', 'File area uuid does not exist, item uuid: ' . $item_uuid );
									$result['error_info'] = 'File area uuid does not exist, please try again or contact flex.help@flinders.edu' ;
									echo json_encode($result);
									return;
								}
								
								$filearea_uuid = $r['uuid'];
							}
							$success = $this->flexrest->fileUpload($filearea_uuid,  htmlentities($abstract_file['name']), file_get_contents($abstract_file['tmp_name']), $r);
							if(!$success)
							{
								$result['status'] = "error";
								$errdata['message'] = $this->flexrest->error;
								log_message('error', 'Attachment failed (fileUpload), item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
								$result['error_info'] = 'Attachment upload failed. Abstract PDF file name CAN NOT contain any special characters, eg. " . < > ? ; &';
								echo json_encode($result);
								return;
							}
							
							$file_uuid = sprintf("%03d", 0);
							$file_uuid = substr($filearea_uuid, 0, 33) . $file_uuid;
							$new_attachments = array('type'=>'file', 
														'filename'=> htmlentities($r['filename']), 
														'description'=> htmlentities($r['filename']),
														'uuid'=>$file_uuid);
														
							$xpath_files = "/xml/item/curriculum/thesis/version/abstract/uuid";
							$node_files = $this->$xmlwrapper->createNodeFromXPath($xpath_files);
							$this->$xmlwrapper->createTextNode($node_files, $file_uuid);							
							array_push($new_item_bean['attachments'], $new_attachments);
						}
					}
				}
				$new_item_bean['metadata'] = $this->$xmlwrapper->__toString();
				$success = $this->flexrest->editItem($item_uuid, $item_version, $new_item_bean, $response3, $filearea_uuid);
				
				if(!$success)
				{
					$result['status'] = "error";
					$errdata['message'] = $this->flexrest->error;
					log_message('error', 'Failed to edit item, item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
					$result['error_info'] = 'Failed to edit item, please try again or contact flex.help@flinders.edu.au';
					echo json_encode($result);
					return;
				}
				
				$result['response'] = $response3;
				
				if(isset($_FILES['abstract_file']) && $abstract_file['name']!= '')
				{
					$s = $this->flexrest->getItemAll($item_uuid, $item_version, $item_all);
					
					if(!$s)
					{
						$result['status'] = "error";
						log_message('error', 'Get Item failed' . ', error: ' . $item_uuid);
						$result['error_info'] = 'Get Item failed, please try again or contact flex.help@flinders.edu.au';
						echo json_encode($result);
						return;
					}
					
					$xmlwrapper_name = 'xml_' . $item_uuid . 'xx'. $item_version;
			
					//pull out metadata XML 
					$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$item_all['metadata']), $xmlwrapper_name );
					
					if($this->$xmlwrapper_name ->nodeExists('/xml/item/curriculum/thesis/version/abstract/uuid'))
					{
						$abstract_uuid = $this->$xmlwrapper_name ->nodeValue('/xml/item/curriculum/thesis/version/abstract/uuid');
						if(count($item_all['attachments']) < 1)
						{
							
							$result['status'] = "attachment_error";
							log_message('error', '2226. Failed to upload attachment' . ', error: ' . $item_uuid);
							$result['error_info'] = '2226. Failed to upload attachment, please try again or contact flex.help@flinders.edu.au';
							echo json_encode($result);
							return;
						}
						else
						{
							$flag = false;
							$size = 0;
							foreach ($item_all['attachments'] as $attachment) 
							{
								if($abstract_uuid == $attachment['uuid'])
								{
									$flag = true;
									$size = $attachment['size'];
									break;
								}
							}
							
							if(!$flag || $size < 1)
							{
								$result['status'] = "attachment_error";
								log_message('error', '2249. Failed to upload attachment' . ', error: ' . $item_uuid);
								$result['error_info'] = '2250. Failed to upload attachment, please try again or contact flex.help@flinders.edu.au';
								echo json_encode($result);
								return;
							}
							
						}
					}
				}
				
				if($result['status'] =='failed')
					$result['status'] = "success";
				//$result['itemName'] = $title;
			  $result['token'] = $this->generateToken($userUuid);
				echo json_encode($result); 
		}
			
		}
		
		//Ajax call from thesis_form_part2 view
		public function edit_part2()
		{
			$this->load->helper('url');
			
			$result['status'] = "failed";
            $result['error_info'] = ""; 
			
			if(!isset($_SERVER['REMOTE_USER']))
            {
				$result['status'] = 'session_time_out';
                $result['error_info'] = "Session Time Out";
				
                echo json_encode($result);
				return;
            }
			
           	$userUuid = $_SERVER['REMOTE_USER'];
			$coursework_collection_id = $ci->config->item('coursework_thesis_collection');
			
			$oauth = array('oauth_client_config_name' => 'rhd');
			$this->load->library('flexrest/flexrest', $oauth);
			$success = $this->flexrest->processClientCredentialToken();
            if(!$success)
            {
                $result['status'] = 'error';
                $result['error_info'] = "Failed to process client credential token, please try again or contact flex.help@flinders.edu.au";
                echo json_encode($result);
            }
			
			$thesis_version = isset($_POST['thesis_version']) ? $_POST['thesis_version']:'' ;
			$item_version = isset($_POST['item_version']) ? $_POST['item_version']:'' ;
			$item_uuid = isset($_POST['item_uuid']) ? $_POST['item_uuid']:'' ;
			
			if(!$this->validate_params($item_uuid, $item_version))
			{
				$result['status'] = 'error';
                $result['error_info'] = 'item uuid /item version invalid';
				echo json_encode($result);
				return;
			}
			
			if($thesis_version == 'version of record')
			{
				$success = $this->flexrest->getItemAll($item_uuid, $item_version, $response);
				if(!$success)
				{
					$result['status'] = 'error';
					$result['error_info'] = 'Failed to get item, please try again or contact flex.help@flinders.edu.au';
					echo json_encode($result);
					return;
					
				}
				
				$new_item_bean = $response;
				
				$xmlwrapper_name = 'xmlwrapper_'.$item_uuid;
				$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$new_item_bean['metadata']), $xmlwrapper_name);
				
				$this->$xmlwrapper_name->setNodeValue("/xml/item/curriculum/thesis/version/open_access/required", $thesis_version, true);
				
				if($this->$xmlwrapper_name->numNodes('/xml/item/curriculum/thesis/version/open_access/files/uuid') > 0)
				{
					$this->$xmlwrapper_name->deleteNodeFromXPath('/xml/item/curriculum/thesis/version/open_access/file');  
				}
				
				$new_item_bean['metadata'] = $this->$xmlwrapper_name->__toString();
				
				$success = $this->flexrest->editItem($item_uuid, $item_version, $new_item_bean, $response3, '');
				
				if(!$success)
				{   
					$result['status'] = 'error';
					$result['error_info'] = 'Failed to edit thesis, please try again or contact flex.help@flinders.edu.au';
					echo json_encode($result);
					return;
				}
				
				if($result['status'] == 'failed')
				{
					$result['status'] = 'success';
					echo json_encode($result);
				}
                
			}
			else
			{	
				$result['status'] = 'error';
                echo json_encode($result);
				return;
			}
		}
		
		//Ajax call from thesis_form_part2 view
		public function edit_part2_all()
		{
			$this->load->helper('url');
			
			$result['status'] = "failed";
            $result['error_info'] = ""; 
			
			if(!isset($_SERVER['REMOTE_USER']))
            {
				$result['status'] = 'session_time_out';
                $result['error_info'] = "Session Time Out";
				
                echo json_encode($result);
				return;
            }
			$ci = & get_instance();
            $ci->load->config('flex');
			
           	$userUuid = $_SERVER['REMOTE_USER'];
			$coursework_collection_id = $ci->config->item('coursework_thesis_collection');
			
			$oauth = array('oauth_client_config_name' => 'rhd');
			$this->load->library('flexrest/flexrest', $oauth);
			$success = $this->flexrest->processClientCredentialToken();
            if(!$success)
            {
                $result['status'] = 'error';
                $result['error_info'] = "2125. Failed to process client credential token, please try again or contact flex.help@flinders.edu.au";
                echo json_encode($result);
            }
			
			$thesis_files = isset($_FILES['thesis_file']) ? $_FILES['thesis_file'] : '';
			$attachments = isset($_POST['attachments'])? $_POST['attachments'] : '';
			
			$authenticity = isset($_POST['authenticity']) ? $_POST['authenticity']:'' ;
			$declaration = isset($_POST['declaration']) ? $_POST['declaration']:'' ;
			
			$item_version = isset($_POST['item_version']) ? $_POST['item_version']:'' ;
			$item_uuid = isset($_POST['item_uuid']) ? $_POST['item_uuid']:'' ;
			$thesis_xpath = isset($_POST['xpath']) ? $_POST['xpath']:'' ;
			
			
			$result['authenticity'] = $authenticity;
			$result['declaration'] = $declaration;
			
			$result['item_version'] = $item_version;
			$result['item_uuid'] = $item_uuid;
			$result['attachments'] = $attachments;
			$result['thesis_files'] = $thesis_files;
		
			
			
			if(!$this->validate_params($item_uuid, $item_version))
			{
				$result['status'] = 'error';
                $result['error_info'] = 'item uuid /item version invalid';
				echo json_encode($result);
				return;
			}
			
			$success = $this->flexrest->getItemAll($item_uuid, $item_version, $response);
			if(!$success)
			{
				$result['status'] = 'error';
				$result['error_info'] = 'Failed to get item, please try again or contact flex.help@flinders.edu.au';
				echo json_encode($result);
				return;
				
			}
			
			$new_item_bean = $response;
			
			$xmlwrapper_name = 'xmlwrapper_'.$item_uuid;
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$new_item_bean['metadata']), $xmlwrapper_name);
			
			$this->$xmlwrapper_name->setNodeValue("/xml/item/curriculum/thesis/agreements/authenticity", $authenticity , true);
			$this->$xmlwrapper_name->setNodeValue("/xml/item/curriculum/thesis/agreements/declaration", $declaration, true);
			
			$filearea_uuid = '';
			
			$this->$xmlwrapper_name->deleteNodeFromXPath($thesis_xpath);        
        	$node_files = $this->$xmlwrapper_name->createNodeFromXPath($thesis_xpath);
			$updated = array();
			
			if(count($attachments)>0)
			{
				for($i=0; $i<count($attachments); $i++)
				{
					$attachment = json_decode($attachments[$i], true);
					
					if($attachment['uuid'] != '' && strlen($attachment['uuid']) == 36)
					{
						foreach($response['attachments'] as $a) 
						{ 
							
							if($attachment['uuid'] == $a['uuid'])
							{
								 $node_file = $this->$xmlwrapper_name->createNode($node_files, "uuid");
            				     $node_file->nodeValue = $a['uuid']; 
								 break;
							}
						}
					}
					else
					{
						if(isset($attachment['file_name']) && $attachment['file_name']!= '')
						{
							if($thesis_files!='')
							{
								for($j=0; $j<count($thesis_files['name']); $j++)
								{
									$file_name = $attachment['file_name'];
									$file_size = $attachment['file_size'];
									
									if($thesis_files['name'][$j] == $file_name && $thesis_files['size'][$j] == $file_size)
									{
										//$filearea_uuid = '';
										if($filearea_uuid=='')
										{
											if(count($new_item_bean['attachments']) > 0)
											{
												
												$success = $this->flexrest->filesCopy($item_uuid, $item_version, $response1);
												if(!$success)
												{
													$result['status'] = "error";
													$errdata['message'] = $this->flexrest->error;
													log_message('error', '2204. Failed to copy file, item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
													$result['error_info'] = '2204. Failed to copy file, please try again or contact flex.help@flinders.edu.au';
													echo json_encode($result);
													return;
												}
												if(!isset($response1['headers']['location']))
												{
													$result['status'] = "error";
													$errdata['message'] = 'No Location header in response to copy files REST call.';
													log_message('error', '2232. No Location header in response to copy files REST call. item uuid: ' . $item_uuid  . ', error: ' . $errdata['message']);
													$result['error_info'] = '2232. No Location header in response to copy files REST call';
													echo json_encode($result);
													return;
												}
												$location = $response1['headers']['location'];
												
												$filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
												unset($response1);
												
											}
											else
											{
												$success = $this->flexrest->newFileArea($r_a);
												if(!$success)
												{
													$result['status'] = "error";
													log_message('error', '2654 Failed to create new file area, item uuid: ' . $item_uuid . ', error: ' . $this->flexrest->error);
													$result['error_info'] = 'Failed to create new file area, item uuid: ' . $item_uuid . ', error: ' . $this->flexrest->error;
													echo json_encode($result);
													return;
												}
												
												if(!isset($r_a['uuid']) || $r_a['uuid']=='')
												{
													$result['status'] = "error";
													log_message('error', 'File area uuid does not exist, item uuid: ' . $item_uuid);
													$result['error_info'] = 'File area uuid does not exist, item uuid: ' . $item_uuid;
													echo json_encode($result);
													return;
												}
												
												$filearea_uuid = $r_a['uuid'];
												
											}
										}
										
										$success = $this->flexrest->fileUpload($filearea_uuid, htmlentities($thesis_files['name'][$j]), file_get_contents($thesis_files['tmp_name'][$j]), $r);
										//usleep(100000);
										//log_message('error', $r['filename']);
										if(!$success)
										{
											$result['status'] = "error";
											$errdata['message'] = $this->flexrest->error;
											log_message('error', '2682. Attachment failed (fileUpload), item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
											$result['error_info'] = '2682. Attachment upload failed. Thesis file name CAN NOT contain any special characters, eg. " . < > ? ; &';
											echo json_encode($result);
											return;
										}
										
										$success = $this->flexrest->newFileArea($xa);
										$file_uuid = $xa['uuid'];
										
										$new_attachments = array('type'=>'file', 
																	'filename'=> htmlentities($r['filename']), 
																	'description'=> htmlentities($r['filename']),
																	'uuid'=>$file_uuid);
																	
										$node_file = $this->$xmlwrapper_name->createNode($node_files, "uuid");
            				     		$node_file->nodeValue = $file_uuid;
										
										array_push($new_item_bean['attachments'], $new_attachments);
										
										$temp=array();
										$temp['file_name'] = htmlentities($thesis_files['name'][$j]);
										$temp['file_size'] = $thesis_files['size'][$j];
										array_push($updated, $temp);
										unset($xa);
									}
								}
							}
							
						}
					}
					
				}
				
				$result['updated'] = $updated;
				
				if(isset($thesis_files['name']))
				{
					if(count($thesis_files['name']) > count($updated) )
					{
						for($j=0; $j<count($thesis_files['name']); $j++)
						{
							$flag = false;
							foreach($updated as $u)
							{
								if($thesis_files['name'][$j]== $u['file_name'] && $thesis_files['size'][$j]== $u['file_size'])
								{
									$flag = true;
									break;
								}
							}
							if(!$flag)
							{
								if($filearea_uuid == '')
								{
									if(count($new_item_bean['attachments']) > 0)
									{
										$success = $this->flexrest->filesCopy($item_uuid, $item_version, $response1);
										if(!$success)
										{
											$result['status'] = "error";
											$errdata['message'] = $this->flexrest->error;
											log_message('error', '2298. Failed to copy file, item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
											$result['error_info'] = '2298. Failed to copy file, please try again or contact flex.help@flinders.edu.au';
											echo json_encode($result);
											return;
										}
										if(!isset($response1['headers']['location']))
										{
											$errdata['message'] = 'No Location header in response to copy files REST call.';
											log_message('error', '2306. No Location header in response to copy files REST call. item uuid: ' . $item_uuid  . ', error: ' . $errdata['message']);
											$result['error_info'] = '2306. No Location header in response to copy files REST call';
											echo json_encode($result);
											return;
										}
										$location = $response1['headers']['location'];
										
										$filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
										unset($response1);
										
									}
									else
									{
										$success = $this->flexrest->newFileArea($r_a);
										if(!$success)
										{
											$result['status'] = "error";
											log_message('error', '2643. Failed to create new file area, item uuid: ' . $item_uuid . ', error: ' . $this->flexrest->error);
											$result['error_info'] = '2643. Failed to create new file area, item uuid: ' . $item_uuid . ', error: ' . $this->flexrest->error;
											echo json_encode($result);
											return;
										}
										
										if(!isset($r_a['uuid']) || $r_a['uuid']=='')
										{
											$result['status'] = "error";
											log_message('error', '2653. File area uuid does not exist, item uuid: ' . $item_uuid);
											$result['error_info'] = '2653. File area uuid does not exist, item uuid: ' . $item_uuid;
											echo json_encode($result);
											return;
										}
										
										$filearea_uuid = $r_a['uuid'];
									}
								}
								$success = $this->flexrest->fileUpload($filearea_uuid, htmlentities($thesis_files['name'][$j], ENT_COMPAT, 'UTF-8'), file_get_contents($thesis_files['tmp_name'][$j]), $r);
						
								if(!$success)
								{
									$result['status'] = "error";
									$errdata['message'] = $this->flexrest->error;
									log_message('error', 'Attachment failed (fileUpload), item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
									$result['error_info'] = 'Attachment upload failed. Attachment file name CAN NOT contain any special characters, eg. " . < > ? ; &';
									echo json_encode($result);
									return;
								}
								
								$success = $this->flexrest->newFileArea($r_x);
								$file_uuid = $r_x['uuid'];
								//$file_uuid = sprintf("%03d", $j);
								//$file_uuid = substr($filearea_uuid, 0, 33) . $file_uuid;
								$new_attachments = array('type'=>'file', 
															'filename'=> htmlentities($r['filename']), 
															'description'=> htmlentities($r['filename']),
															'uuid'=>$file_uuid);
								$node_file = $this->$xmlwrapper_name->createNode($node_files, "uuid");
								$node_file->nodeValue = $file_uuid; 
								array_push($new_item_bean['attachments'], $new_attachments);
								unset($r_x);
							}
						}
					}
				}
			}
			else
			{
				if($thesis_files!='')
				{
					
					for($j=0; $j<count($thesis_files['name']); $j++)
					{
						if($filearea_uuid == '' )
						{
							if(count($new_item_bean['attachments']) > 0)
							{		
								$success = $this->flexrest->filesCopy($item_uuid, $item_version, $response1);
								if(!$success)
								{
									$result['status'] = "error";
									$errdata['message'] = $this->flexrest->error;
									log_message('error', '2353. Failed to copy file, item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
									$result['error_info'] = 'Failed to copy file, please try again or contact flex.help@flinders.edu.au';
									echo json_encode($result);
									return;
								}
								if(!isset($response1['headers']['location']))
								{
									$errdata['message'] = 'No Location header in response to copy files REST call.';
									log_message('error', '2362. No Location header in response to copy files REST call. item uuid: ' . $item_uuid  . ', error: ' . $errdata['message']);
									$result['error_info'] = '2362. No Location header in response to copy files REST call';
									echo json_encode($result);
									return;
								}
								$location = $response1['headers']['location'];
								
								$filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
								unset($response1);
							}
							else
							{
								$success = $this->flexrest->newFileArea($r_a);
								if(!$success)
								{
									$result['status'] = "error";
									log_message('error', '2643. Failed to create new file area, item uuid: ' . $item_uuid . ', error: ' . $this->flexrest->error);
									$result['error_info'] = '2643. Failed to create new file area, item uuid: ' . $item_uuid . ', error: ' . $this->flexrest->error;
									echo json_encode($result);
									return;
								}
								
								if(!isset($r_a['uuid']) || $r_a['uuid']=='')
								{
									$result['status'] = "error";
									log_message('error', '2715. File area uuid does not exist, item uuid: ' . $item_uuid);
									$result['error_info'] = '2715. File area uuid does not exist, item uuid: ' . $item_uuid;
									echo json_encode($result);
									return;
								}
								
								$filearea_uuid = $r_a['uuid'];
							}
						}
						
						$success = $this->flexrest->fileUpload($filearea_uuid, htmlentities($thesis_files['name'][$j], ENT_COMPAT, 'UTF-8'), file_get_contents($thesis_files['tmp_name'][$j]), $r);
					
						if(!$success)
						{
							$result['status'] = "error";
							$errdata['message'] = $this->flexrest->error;
							log_message('error', '2878. Attachment failed (fileUpload), item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
							$result['error_info'] = '2879. Attachment upload failed. Attachment file name CAN NOT contain any special characters, eg. " . < > ? ; &';
							echo json_encode($result);
							return;
						}
						$success = $this->flexrest->newFileArea($r_x);
						$file_uuid = $r_x['uuid'];
						
						$new_attachments = array('type'=>'file', 
													'filename'=> htmlentities($r['filename']), 
													'description'=> htmlentities($r['filename']),
													'uuid'=>$file_uuid);
						$node_file = $this->$xmlwrapper_name->createNode($node_files, "uuid");
						$node_file->nodeValue = $file_uuid; 
						array_push($new_item_bean['attachments'], $new_attachments);
						unset($r_x);
					}
				}
			}
			
			$new_item_bean['metadata'] = $this->$xmlwrapper_name->__toString();
			
			$success = $this->flexrest->editItem($item_uuid, $item_version, $new_item_bean, $response3, $filearea_uuid);
			
			if(!$success)
			{   
				$result['status'] = 'error';
				$result['error_info'] = '2404. Failed to edit thesis, please try again or contact flex.help@flinders.edu.au';
				echo json_encode($result);
				return;
			}
			
			if($result['status'] == 'failed')
			{
				$result['status'] = 'success';
				echo json_encode($result);
				return;
			}
		}
		
		public function edit_part3()
		{
			$ci = & get_instance();
            $ci->load->config('flex');
			$this->load->helper('url');
			
			$result['status'] = "failed";
            $result['error_info'] = ""; 
			
			if(!isset($_SERVER['REMOTE_USER']))
            {
				$result['status'] = 'session_time_out';
                $result['error_info'] = "Session Time Out";
				
                echo json_encode($result);
				return;
            }
			
           	$userUuid = $_SERVER['REMOTE_USER'];
			$coursework_collection_id = $ci->config->item('coursework_thesis_collection');
			
			
			$oauth = array('oauth_client_config_name' => 'rhd');
			$this->load->library('flexrest/flexrest', $oauth);
			$success = $this->flexrest->processClientCredentialToken();
            if(!$success)
            {
                $result['status'] = 'error';
                $result['error_info'] = "Failed to process client credential token, please try again or contact flex.help@flinders.edu.au";
                echo json_encode($result);
            }
			
			$this->load->library('form_validation');
			
			//form validation rules
			$this->form_validation->set_rules('item_version', 'Item version not valid', '');
			$this->form_validation->set_rules('item_uuid', 'Item UUID not valid', '');
			$this->form_validation->set_rules('open_access', '', 'required|xss_clean');
			$this->form_validation->set_rules('release_status', '', 'required');
			$this->form_validation->set_rules('embargo_duration', '', 'xss_clean');
			$this->form_validation->set_rules('embargo_reason', 'Embargo reason not valid', 'xss_clean');
			$this->form_validation->set_rules('embargo_statement', '', 'xss_clean');
			$this->form_validation->set_rules('embargo_ext_request', '', 'xss_clean');
			$this->form_validation->set_rules('embargo_ext_reason', 'Embargo reason not valid', 'xss_clean');
			$this->form_validation->set_rules('copyright_statement', '', 'required|xss_clean');
			
		
			
			if ($this->form_validation->run() == FALSE)
			{
				$result['status'] = "error"; 
				$result['error_info'] = "invalid input";
				echo json_encode($result);
				return;
			}
			else
			{
				$item_version = isset($_POST['item_version']) ? $_POST['item_version']:'' ;
				$item_uuid = isset($_POST['item_uuid']) ? $_POST['item_uuid']:'' ;
			
			if(!$this->validate_params($item_uuid, $item_version))
			{
				$result['status'] = 'error';
                $result['error_info'] = 'item uuid /item version invalid';
				echo json_encode($result);
				return;
			}
			
			$success = $this->flexrest->getItemAll($item_uuid, $item_version, $response);
			
			if(!$success)
			{
				$result['status'] = 'error';
				$result['error_info'] = 'Failed to get item, please try again or contact flex.help@flinders.edu.au';
				echo json_encode($result);
				return;
			}
			
			$new_item_bean = $response;
				
			$xmlwrapper_name = 'xmlwrapper_'.$item_uuid.'_'.$item_version;
			
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$new_item_bean['metadata']), $xmlwrapper_name);
			
			$thesis_xpath = isset($_POST['xpath']) ? $_POST['xpath']:'' ;
			
			$open_access = isset($_POST['open_access']) ? $_POST['open_access']:'' ;
			$this->$xmlwrapper_name->setNodeValue("/xml/item/curriculum/thesis/version/open_access/required", $open_access, true);
			
			$release_status = isset($_POST['release_status']) ? $_POST['release_status']:'' ;
			$this->$xmlwrapper_name->setNodeValue("/xml/item/curriculum/thesis/release/status", $release_status, true);
			
			if($release_status == 'Restricted Access')
			{	
				$embargo_reason = isset($_POST['embargo_reason']) ? htmlentities($_POST['embargo_reason']):'' ;
				$this->$xmlwrapper_name->setNodeValue("/xml/item/curriculum/thesis/release/embargo_request/standard_request/reason", $this->trim_all($embargo_reason), true);
				
				$embargo_statement = isset($_POST['embargo_statement']) ? htmlentities($_POST['embargo_statement']):'' ;
				$this->$xmlwrapper_name->setNodeValue("/xml/item/curriculum/thesis/agreements/embargo", $embargo_statement, true);

			    $embargo_duration = isset($_POST['embargo_duration']) ? $_POST['embargo_duration']:'' ;
				$this->$xmlwrapper_name->setNodeValue("/xml/item/curriculum/thesis/release/embargo_request/standard_request/duration", $embargo_duration , true);
				
				if($embargo_duration == '36'|| $embargo_duration == 36)
				{
					$embargo_ext_request = isset($_POST['embargo_ext_request']) ? $_POST['embargo_ext_request']:'' ;
					$this->$xmlwrapper_name->setNodeValue("/xml/item/curriculum/thesis/release/embargo_request/extension_request/requested", $embargo_ext_request , true);
					
					if($embargo_ext_request == 'Additional Restriction')
					{	
						$embargo_ext_reason = isset($_POST['embargo_ext_reason']) ? htmlentities($_POST['embargo_ext_reason']):'' ;
						$this->$xmlwrapper_name->setNodeValue("/xml/item/curriculum/thesis/release/embargo_request/extension_request/reason", $this->trim_all($embargo_ext_reason), true);
					}
					else
					{
						$this->$xmlwrapper_name->setNodeValue("/xml/item/curriculum/thesis/release/embargo_request/extension_request/reason", '', true);
						
					}
				}
				else
				{
					$this->$xmlwrapper_name->setNodeValue("/xml/item/curriculum/thesis/release/embargo_request/extension_request/requested", '' , true);
					$this->$xmlwrapper_name->setNodeValue("/xml/item/curriculum/thesis/release/embargo_request/extension_request/reason", '', true);
				}
			}
			
			$copyright_statement = isset($_POST['copyright_statement']) ? htmlentities($_POST['copyright_statement']) : '' ; 
			$this->$xmlwrapper_name->setNodeValue("/xml/item/curriculum/thesis/agreements/copyright", $copyright_statement, true);
			
			
			$this->$xmlwrapper_name->deleteNodeFromXPath($thesis_xpath);      
			
			$filearea_uuid = '';
			
			if($open_access == 'new version')
			{
				$thesis_files = isset($_FILES['thesis_file']) ? $_FILES['thesis_file'] : '';
				$attachments = isset($_POST['attachments'])? $_POST['attachments'] : '';
				
				  
				$node_files = $this->$xmlwrapper_name->createNodeFromXPath($thesis_xpath);
				$updated = array();
				$filearea_uuid = '';
				
				if(count($attachments)>0)
				{
					for($i=0; $i<count($attachments); $i++)
					{
						$attachment = json_decode($attachments[$i], true);
						
						if($attachment['uuid'] != '' && strlen($attachment['uuid']) == 36)
						{
							foreach($response['attachments'] as $a) 
							{ 
								
								if($attachment['uuid'] == $a['uuid'])
								{
									 $node_file = $this->$xmlwrapper_name->createNode($node_files, "uuid");
									 $node_file->nodeValue = $a['uuid']; 
									 break;
								}
							}
						}
						else
						{
							if(isset($attachment['file_name']) && $attachment['file_name']!= '')
							{
								if($thesis_files!='')
								{
									for($j=0; $j<count($thesis_files['name']); $j++)
									{
										$file_name = $attachment['file_name'];
										$file_size = $attachment['file_size'];
										
										if($thesis_files['name'][$j] == $file_name && $thesis_files['size'][$j] == $file_size)
										{
											//$filearea_uuid = '';
											if($filearea_uuid=='')
											{
												if(count($new_item_bean['attachments']) > 0)
												{
													
													$success = $this->flexrest->filesCopy($item_uuid, $item_version, $response1);
													if(!$success)
													{
														$result['status'] = "error";
														$errdata['message'] = $this->flexrest->error;
														log_message('error', '2204. Failed to copy file, item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
														$result['error_info'] = '2204. Failed to copy file, please try again or contact flex.help@flinders.edu.au';
														echo json_encode($result);
														return;
													}
													if(!isset($response1['headers']['location']))
													{
														$result['status'] = "error";
														$errdata['message'] = 'No Location header in response to copy files REST call.';
														log_message('error', '2232. No Location header in response to copy files REST call. item uuid: ' . $item_uuid  . ', error: ' . $errdata['message']);
														$result['error_info'] = '2232. No Location header in response to copy files REST call';
														echo json_encode($result);
														return;
													}
													$location = $response1['headers']['location'];
													
													$filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
													unset($response1);
													
												}
												else
												{
													$success = $this->flexrest->newFileArea($r_a);
													if(!$success)
													{
														$result['status'] = "error";
														log_message('error', '1369 Failed to create new file area, item uuid: ' . $item_uuid . ', error: ' . $this->flexrest->error);
														$result['error_info'] = 'Failed to create new file area, item uuid: ' . $item_uuid . ', error: ' . $this->flexrest->error;
														echo json_encode($result);
														return;
													}
													
													if(!isset($r_a['uuid']) || $r_a['uuid']=='')
													{
														$result['status'] = "error";
														log_message('error', 'File area uuid does not exist, item uuid: ' . $item_uuid);
														$result['error_info'] = 'File area uuid does not exist, item uuid: ' . $item_uuid;
														echo json_encode($result);
														return;
													}
													
													$filearea_uuid = $r_a['uuid'];
													
												}
											}
											
											$success = $this->flexrest->fileUpload($filearea_uuid, htmlentities($thesis_files['name'][$j], ENT_COMPAT, 'UTF-8'), file_get_contents($thesis_files['tmp_name'][$j]), $r);
									
											
											if(!$success)
											{
												$result['status'] = "error";
												$errdata['message'] = $this->flexrest->error;
												log_message('error', '3153. Attachment failed (fileUpload), item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
												$result['error_info'] = '3153. Attachment upload failed. Attachment file name CAN NOT contain any special characters, eg. " . < > ? ; &';
												echo json_encode($result);
												return;
											}
											
											$success = $this->flexrest->newFileArea($xa);
											$file_uuid = $xa['uuid'];
										
											$new_attachments = array('type'=>'file', 
																		'filename'=>$r['filename'], 
																		'description'=>$r['filename'],
																		'uuid'=>$file_uuid);
																		
											$node_file = $this->$xmlwrapper_name->createNode($node_files, "uuid");
											$node_file->nodeValue = $file_uuid;
											
											array_push($new_item_bean['attachments'], $new_attachments);
											
											$temp=array();
											$temp['file_name'] = $thesis_files['name'][$j];
											$temp['file_size'] = $thesis_files['size'][$j];
											array_push($updated, $temp);
											unset($xa);
										}
									}
								}
								
							}
						}
						
					}
					
					$result['updated'] = $updated;
					
					if(isset($thesis_files['name']))
					{
						if(count($thesis_files['name']) > count($updated) )
						{
							for($j=0; $j<count($thesis_files['name']); $j++)
							{
								$flag = false;
								foreach($updated as $u)
								{
									if($thesis_files['name'][$j]== $u['file_name'] && $thesis_files['size'][$j]== $u['file_size'])
									{
										$flag = true;
										break;
									}
								}
								if(!$flag)
								{
									if($filearea_uuid == '')
									{
										if(count($new_item_bean['attachments']) > 0)
										{
											$success = $this->flexrest->filesCopy($item_uuid, $item_version, $response1);
											if(!$success)
											{
												$result['status'] = "error";
												$errdata['message'] = $this->flexrest->error;
												log_message('error', '2298. Failed to copy file, item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
												$result['error_info'] = '2298. Failed to copy file, please try again or contact flex.help@flinders.edu.au';
												echo json_encode($result);
												return;
											}
											if(!isset($response1['headers']['location']))
											{
												$errdata['message'] = 'No Location header in response to copy files REST call.';
												log_message('error', '2306. No Location header in response to copy files REST call. item uuid: ' . $item_uuid  . ', error: ' . $errdata['message']);
												$result['error_info'] = '2306. No Location header in response to copy files REST call';
												echo json_encode($result);
												return;
											}
											$location = $response1['headers']['location'];
											
											$filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
											unset($response1);
											
										}
										else
										{
											$success = $this->flexrest->newFileArea($r_a);
											if(!$success)
											{
												$result['status'] = "error";
												log_message('error', '2643. Failed to create new file area, item uuid: ' . $item_uuid . ', error: ' . $this->flexrest->error);
												$result['error_info'] = '2643. Failed to create new file area, item uuid: ' . $item_uuid . ', error: ' . $this->flexrest->error;
												echo json_encode($result);
												return;
											}
											
											if(!isset($r_a['uuid']) || $r_a['uuid']=='')
											{
												$result['status'] = "error";
												log_message('error', '2653. File area uuid does not exist, item uuid: ' . $item_uuid);
												$result['error_info'] = '2653. File area uuid does not exist, item uuid: ' . $item_uuid;
												echo json_encode($result);
												return;
											}
											
											$filearea_uuid = $r_a['uuid'];
										}
									}
									$success = $this->flexrest->fileUpload($filearea_uuid, htmlentities($thesis_files['name'][$j], ENT_COMPAT, 'UTF-8'), file_get_contents($thesis_files['tmp_name'][$j]), $r);
							
									if(!$success)
									{
										$result['status'] = "error";
										$errdata['message'] = $this->flexrest->error;
										log_message('error', '3270. Attachment failed (fileUpload), attachemnet name: '. $thesis_files['name'][$j] .' item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
										$result['error_info'] = '3270. Attachment upload failed. Attachment file name CAN NOT contain any special characters, eg. " . < > ? ; &';
										echo json_encode($result);
										return;
									}
									
									$success = $this->flexrest->newFileArea($r_x);
									$file_uuid = $r_x['uuid'];
									$new_attachments = array('type'=>'file', 
																'filename'=> htmlentities($r['filename']), 
																'description'=> htmlentities($r['filename']),
																'uuid'=>$file_uuid);
									$node_file = $this->$xmlwrapper_name->createNode($node_files, "uuid");
									$node_file->nodeValue = $file_uuid; 
									array_push($new_item_bean['attachments'], $new_attachments);
									unset($r_x);
								}
							}
						}
					}
				}
				else
				{
					if($thesis_files!='')
					{
						for($j=0; $j<count($thesis_files['name']); $j++)
						{
							if($filearea_uuid == '' )
							{
								if(count($new_item_bean['attachments']) > 0)
								{		
									$success = $this->flexrest->filesCopy($item_uuid, $item_version, $response1);
									if(!$success)
									{
										$result['status'] = "error";
										$errdata['message'] = $this->flexrest->error;
										log_message('error', '2353. Failed to copy file, item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
										$result['error_info'] = 'Failed to copy file, please try again or contact flex.help@flinders.edu.au';
										echo json_encode($result);
										return;
									}
									if(!isset($response1['headers']['location']))
									{
										$errdata['message'] = 'No Location header in response to copy files REST call.';
										log_message('error', '2362. No Location header in response to copy files REST call. item uuid: ' . $item_uuid  . ', error: ' . $errdata['message']);
										$result['error_info'] = '2362. No Location header in response to copy files REST call';
										echo json_encode($result);
										return;
									}
									$location = $response1['headers']['location'];
									
									$filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
									unset($response1);
								}
								else
								{
									$success = $this->flexrest->newFileArea($r_a);
									if(!$success)
									{
										$result['status'] = "error";
										log_message('error', '2643. Failed to create new file area, item uuid: ' . $item_uuid . ', error: ' . $this->flexrest->error);
										$result['error_info'] = '2643. Failed to create new file area, item uuid: ' . $item_uuid . ', error: ' . $this->flexrest->error;
										echo json_encode($result);
										return;
									}
									
									if(!isset($r_a['uuid']) || $r_a['uuid']=='')
									{
										$result['status'] = "error";
										log_message('error', '2715. File area uuid does not exist, item uuid: ' . $item_uuid);
										$result['error_info'] = '2715. File area uuid does not exist, item uuid: ' . $item_uuid;
										echo json_encode($result);
										return;
									}
									
									$filearea_uuid = $r_a['uuid'];
								}
							}
							
							$success = $this->flexrest->fileUpload($filearea_uuid, htmlentities($thesis_files['name'][$j], ENT_COMPAT, 'UTF-8'), file_get_contents($thesis_files['tmp_name'][$j]), $r);
							//usleep(100000);
							if(!$success)
							{
								$result['status'] = "error";
								$errdata['message'] = $this->flexrest->error;
								log_message('error', '3355. Attachment failed (fileUpload), item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
								$result['error_info'] = '3355.  Attachment upload failed. Attachment file name CAN NOT contain any special characters, eg. " . < > ? ; &';
								echo json_encode($result);
								return;
							}
							$success = $this->flexrest->newFileArea($r_x);
							$file_uuid = $r_x['uuid'];
							//$file_uuid = sprintf("%03d", $j+23);
							//$file_uuid = substr($item_uuid, 0, 33) . $file_uuid;
							$new_attachments = array('type'=>'file', 
														'filename'=>htmlentities($r['filename']), 
														'description'=>htmlentities($r['filename']),
														'uuid'=>$file_uuid);
							$node_file = $this->$xmlwrapper_name->createNode($node_files, "uuid");
							$node_file->nodeValue = $file_uuid; 
							array_push($new_item_bean['attachments'], $new_attachments);
							unset($r_x);
						}
					}
				}
			}
			
			$new_item_bean['metadata'] = $this->$xmlwrapper_name->__toString();
			
			$success = $this->flexrest->editItem($item_uuid, $item_version, $new_item_bean, $response, $filearea_uuid);
			
			if(!$success)
			{   
				$result['status'] = 'error';
				$result['error_info'] = '3310. Failed to edit thesis, please try again or contact flex.help@flinders.edu.au';
				echo json_encode($result);
				return;
			}
			
			if($result['status'] == 'failed')
			{
				$result['status'] = 'success';
				echo json_encode($result);
			}
			}
		}
		
		
		
		//NOT IN USE
		public function uploadThesis()
		{
			$this->load->helper('url');
			
			$item_uuid = $this->input->post("item_uuid", TRUE); 
			$item_version = $this->input->post("item_version", TRUE);
			$thesis_files = isset($_FILES['thesis_file']) ? $_FILES['thesis_file'] : '';
			$attachments = isset($_POST['attachments'])? $_POST['attachments'] : '';
			$thesis_xpath = $this->input->post("xpath");
			
			
			$ci = & get_instance();
			
			if(!isset($_SERVER['REMOTE_USER']))
            {
                $this->logger_rhd->error("Error: REMOTE_USER not set.");
				
                $errdata['message'] = 'Session expired';
                $errdata['heading'] = "Internal error";
                $this->load->view('rhd/showerror_view', $errdata);
                $this->output->_display();
                exit();
            }
           
			$coursework_collection_id  = $ci->config->item('coursework_thesis_collection');
			
			//$rhd_schools_taxonomy_uuid = $ci->config->item('rhd_schools_taxonomy_uuid'); 
			
			$userUuid = $_SERVER['REMOTE_USER'];
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
			
			$s = $this->flexrest->getItem($item_uuid, $item_version, $r_item);
			if(!$s)
			{
				$result['status'] = "error";
				log_message('error', 'Get Item failed' . ', error: ' . $item_uuid);
				$result['error_info'] = 'Get Item failed, please try again or contact flex.help@flinders.edu.au';
				echo json_encode($result);
				return;
			}
				
			$new_item_bean = $r_item;
			
		    $xmlwrapper = 'xmlwrapper_' . $item_uuid;
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$new_item_bean['metadata']), $xmlwrapper);
			
			if($thesis_xpath == '/xml/item/curriculum/thesis/version/open_access/files')
			{
				$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/thesis/version/open_access/required", 'new version', true);
			}
			
			$filearea_uuid = '';
			
			$this->$xmlwrapper->deleteNodeFromXPath($thesis_xpath);        
        	$node_files = $this->$xmlwrapper->createNodeFromXPath($thesis_xpath);
			$updated = array();
			
			if(count($attachments)>0)
			{
				for($i=0; $i<count($attachments); $i++)
				{
					$attachment = json_decode($attachments[$i], true);
					
					if($attachment['uuid'] != '' && strlen($attachment['uuid']) == 36)
					{
						foreach($r_item['attachments'] as $a) 
						{ 
							
							if($attachment['uuid'] == $a['uuid'])
							{
								 $node_file = $this->$xmlwrapper->createNode($node_files, "uuid");
            				     $node_file->nodeValue = $a['uuid']; 
								 break;
							}
						}
					}
					else
					{
						if(isset($attachment['file_name']) && $attachment['file_name']!= '')
						{
							if($thesis_files!='')
							{
								for($j=0; $j<count($thesis_files['name']); $j++)
								{
									$file_name = $attachment['file_name'];
									$file_size = $attachment['file_size'];
									
									if($thesis_files['name'][$j] == $file_name && $thesis_files['size'][$j] == $file_size)
									{
										
										$success = $this->flexrest->filesCopy($item_uuid, $item_version, $response1);
										if(!$success)
										{
											$result['status'] = "error";
											$errdata['message'] = $this->flexrest->error;
											log_message('error', 'Failed to copy file, item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
											$result['error_info'] = 'Failed to copy file, please try again or contact flex.help@flinders.edu.au';
											echo json_encode($result);
											return;
										}
										if(!isset($response1['headers']['location']))
										{
											$errdata['message'] = 'No Location header in response to copy files REST call.';
											log_message('error', 'No Location header in response to copy files REST call. item uuid: ' . $item_uuid  . ', error: ' . $errdata['message']);
											$result['error_info'] = 'No Location header in response to copy files REST call';
											echo json_encode($result);
											return;
										}
										$location = $response1['headers']['location'];
										
										$filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
										
										$success = $this->flexrest->fileUpload($filearea_uuid, htmlentities($thesis_files['name'][$j], ENT_COMPAT, 'UTF-8'), file_get_contents($thesis_files['tmp_name'][$j]), $r);
										if(!$success)
										{
											$result['status'] = "error";
											$errdata['message'] = $this->flexrest->error;
											log_message('error', 'Attachment failed (fileUpload), item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
											$result['error_info'] = 'Attachment upload failed (fileUpload), please try again or contact flex.help@flinders.edu';
											echo json_encode($result);
											return;
										}
										
										$file_uuid = sprintf("%03d", $i+$j);
										$file_uuid = substr($filearea_uuid, 0, 33) . $file_uuid;
										$new_attachments = array('type'=>'file', 
																	'filename'=>$r['filename'], 
																	'description'=>$r['filename'],
																	'uuid'=>$file_uuid);
																	
										$node_file = $this->$xmlwrapper->createNode($node_files, "uuid");
            				     		$node_file->nodeValue = $file_uuid;
										
										array_push($new_item_bean['attachments'], $new_attachments);
										
										$temp=array();
										$temp['file_name'] = $thesis_files['name'][$j];
										$temp['file_size'] = $thesis_files['size'][$j];
										array_push($updated, $temp);
									}
								}
							}
							
						}
					}
				}
				if(isset($thesis_files['name']))
				{
					if(count($thesis_files['name']) > count($updated) )
					{
						for($j=0; $j<count($thesis_files['name']); $j++)
						{
							$flag = false;
							foreach($updated as $u)
							{
								if($thesis_files['name'][$j]== $u['file_name'] && $thesis_files['size'][$j]== $u['file_size'])
								{
									$flag = true;
									break;
								}
							}
							
							if(!false)
							{
								$success = $this->flexrest->filesCopy($item_uuid, $item_version, $response1);
								if(!$success)
								{
									$result['status'] = "error";
									$errdata['message'] = $this->flexrest->error;
									log_message('error', '3113.Failed to copy file, item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
									$result['error_info'] = 'Failed to copy file, please try again or contact flex.help@flinders.edu.au';
									echo json_encode($result);
									return;
								}
								if(!isset($response1['headers']['location']))
								{
									$errdata['message'] = 'No Location header in response to copy files REST call.';
									log_message('error', 'No Location header in response to copy files REST call. item uuid: ' . $item_uuid  . ', error: ' . $errdata['message']);
									$result['error_info'] = 'No Location header in response to copy files REST call';
									echo json_encode($result);
									return;
								}
								$location = $response1['headers']['location'];
								
								$filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
								
								$success = $this->flexrest->fileUpload($filearea_uuid, htmlentities($thesis_files['name'][$j], ENT_COMPAT, 'UTF-8'), file_get_contents($thesis_files['tmp_name'][$j]), $r);
								if(!$success)
								{
									$result['status'] = "error";
									$errdata['message'] = $this->flexrest->error;
									log_message('error', '3135. Attachment failed (fileUpload), item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
									$result['error_info'] = 'Attachment upload failed (fileUpload), please try again or contact flex.help@flinders.edu';
									echo json_encode($result);
									return;
								}
								
								$file_uuid = sprintf("%03d", $j);
								$file_uuid = substr($filearea_uuid, 0, 33) . $file_uuid;
								$new_attachments = array('type'=>'file', 
															'filename'=>$r['filename'], 
															'description'=>$r['filename'],
															'uuid'=>$file_uuid);
								$node_file = $this->$xmlwrapper->createNode($node_files, "uuid");
								$node_file->nodeValue = $file_uuid; 
								array_push($new_item_bean['attachments'], $new_attachments);
							}
						}
					}
				}
			}
			else
			{
				if($thesis_files!='')
				{
					for($j=0; $j<count($thesis_files['name']); $j++)
					{
						$success = $this->flexrest->filesCopy($item_uuid, $item_version, $response1);
						if(!$success)
						{
							$result['status'] = "error";
							$errdata['message'] = $this->flexrest->error;
							log_message('error', '3169. Failed to copy file, item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
							$result['error_info'] = '3169. Failed to copy file, please try again or contact flex.help@flinders.edu.au';
							echo json_encode($result);
							return;
						}
						if(!isset($response1['headers']['location']))
						{
							$errdata['message'] = 'No Location header in response to copy files REST call.';
							log_message('error', 'No Location header in response to copy files REST call. item uuid: ' . $item_uuid  . ', error: ' . $errdata['message']);
							$result['error_info'] = 'No Location header in response to copy files REST call';
							echo json_encode($result);
							return;
						}
						$location = $response1['headers']['location'];
						
						$filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
						
						$success = $this->flexrest->fileUpload($filearea_uuid, htmlentities($thesis_files['name'][$j], ENT_COMPAT, 'UTF-8'), file_get_contents($thesis_files['tmp_name'][$j]), $r);
						if(!$success)
						{
							$result['status'] = "error";
							$errdata['message'] = $this->flexrest->error;
							log_message('error', 'Attachment failed (fileUpload), item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
							$result['error_info'] = 'Attachment upload failed (fileUpload), please try again or contact flex.help@flinders.edu';
							echo json_encode($result);
							return;
						}
						
						$file_uuid = sprintf("%03d", $j+23);
						$file_uuid = substr($item_uuid, 0, 33) . $file_uuid;
						$new_attachments[0] = array('type'=>'file', 
													'filename'=>$r['filename'], 
													'description'=>$r['filename'],
													'uuid'=>$file_uuid);
						$node_file = $this->$xmlwrapper->createNode($node_files, "uuid");
						$node_file->nodeValue = $file_uuid; 
						array_push($new_item_bean['attachments'], $new_attachments);
						//$new_item_bean['attachments'] = array_merge($new_attachments, $r_item['attachments']);
						
					}
				}
				
			}
			
			$new_item_bean['metadata'] = $this->$xmlwrapper->__toString();
			$success = $this->flexrest->editItem($item_uuid, $item_version, $new_item_bean, $response3, $filearea_uuid);
			
			if(!$success)
			{
				$result['status'] = "error";
				$errdata['message'] = $this->flexrest->error;
				log_message('error', '3221. Failed to edit item, item uuid: ' . $item_uuid . ', error: ' . $errdata['message']);
				$result['error_info'] = 'Failed to edit item, please try again or contact flex.help@flinders.edu';
				echo json_encode($result);
				return;
			}
			
			$result['response'] = $response3;
			if($result['status'] =='failed')
			{
				$result['status'] = "success";
			}
		    $result['token'] = $this->generateToken($userUuid);
			echo json_encode($result); 
		}
		
		//Ajax call from thesis_form_part4 view
		public function submitForModeration()
		{
			$this->load->helper('url');
			$result['status'] = "failed";
            $result['error_info'] = ""; 
			
			if(!isset($_SERVER['REMOTE_USER']))
            {
				$result['status'] = 'session_time_out';
                $result['error_info'] = "Session Time Out";
				
                echo json_encode($result);
				return;
            }
			
			$uuid = $this->input->post("item_uuid", TRUE); 
			$version = $this->input->post("item_version", TRUE);
			$new = $this->input->post("new_thesis", TRUE);
			
			if(!$this->validate_params($uuid, $version))
			{
				$result['status'] = 'error';
                $result['error_info'] = "Invalid item uuid or version number, please try again or contact flex.help@flinders.edu.au";
				echo json_encode($result);
				return;
			}
			
			$oauth = array('oauth_client_config_name' => 'rhd');
			$this->load->library('flexrest/flexrest', $oauth);
		
			$success = $this->flexrest->processClientCredentialToken();
			
			if(!$success)
			{
				$result['status'] = 'error';
                $result['error_info'] = "Internal error (failed to connect to flex_rest), please try again or contact flex.help@flinders.edu.au";
				echo json_encode($result);
				return;
			}
			
			$success = $this->flexrest->getItemAll($uuid, $version, $response);
			if(!$success)
			{
				$result['status'] = 'error';
                $result['error_info'] = "Internal error (failed to get thesis), please try again or contact flex.help@flinders.edu.au";
				echo json_encode($result);
				return;
				
			}
			if($response['status'] == 'draft')
			{
				$xmlwrapper_name = 'xmlwrapper_'.$uuid;
				$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
						
				$item_array = $this->itemXml2Array($this->$xmlwrapper_name);
				
				$item_array = $this->thesis_validation($item_array, $response['attachments']);
				$item_array['token'] = $this->generateToken($_SESSION['fan']);
				
				/*echo '<pre>';
				print_r($validation);
				echo '</pre>';
				exit;*/
			
				$valid = '';
				if($item_array['validation']['part_1']['valid'] == 'valid')
				{
					$valid = true;
				}
				else
				{
					$valid = false;
				}
				
				if($valid)
				{
					if($item_array['validation']['part_2']['valid'] == 'valid')
					{
						$valid = true;
					}
					else
					{
						$valid = false;
					}
				}
				
				if($valid)
				{
					if($item_array['validation']['part_3']['valid'] == 'valid')
					{
						$valid = true;
					}
					else
					{
						$valid = false;
					}
				}
				
				if($valid)
				{
					$success = $this->flexrest->submitForModeration($uuid, $version, $response_1);
					if(!$success)
					{
						$result['status'] = 'error';
						$result['error_info'] = 'Failed to submit thesis. Please submit again or contact flex.help@flinders.edu.au';
						echo json_encode($result);
						return;
					}
					if($result['status'] = 'failed')
					{
						$result['status'] = 'success';
                		$result['info'] = $response_1;
						echo json_encode($result);
						return;
					}
					
				}
				
				if(!$valid)
				{
					 redirect(base_url('rhd/coursework/getThesis_part4/' . $uuid. '/' . $version.'/'));
                 	 exit();
				}
			}
			
			else
			{
				 redirect(base_url('thesis/coursework'));
                 exit();
			}
			
		}
		
		/** private functions**/
		
		protected function validate_params($uuid, $version)
		{
			if(strcmp($uuid, 'missed')==0 || strlen($uuid) != 36)
				return false;
			
			if(strcmp($version, 'missed')==0 || !is_numeric($version))
				return false;
			
			return true;
		}
		
		private function itemXml2Array($itemXml)
		{
			$tmp = array();
			
			$thesis_title = '/xml/item/curriculum/thesis/title';
			$tmp['thesis_title'] = addslashes(html_entity_decode($itemXml->nodeValue($thesis_title)));
	 
			
			/****** version********/
				//abstract
			$abstract= '/xml/item/curriculum/thesis/version/abstract/text';
			$tmp['abstract'] = addslashes(html_entity_decode($itemXml->nodeValue($abstract)));
			
			$abstract_attachment= '/xml/item/curriculum/thesis/version/abstract/uuid';
			$tmp['abstract_attachment'][1]['uuid'] = $itemXml->nodeValue($abstract_attachment);
				//examined thesis
			if($itemXml->numNodes('/xml/item/curriculum/thesis/version/examined_thesis/files/uuid') > 0)
			{
				for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/thesis/version/examined_thesis/files/uuid'); $i++) 
				{
					$tmp['examined_thesis'][$i]['uuid'] = $itemXml->nodeValue('/xml/item/curriculum/thesis/version/examined_thesis/files/uuid['.$i.']');
				}
			}
				
				//new version or version of record
			//$new_version_required = '/xml/item/curriculum/thesis/version/open_access/required';
			$tmp['new_version_required'] = $itemXml->nodeValue('/xml/item/curriculum/thesis/version/open_access/required');
				//Open access thesis
			if(isset($tmp['new_version_required']) && $tmp['new_version_required'] == 'new version')
			{
				if($itemXml->numNodes('/xml/item/curriculum/thesis/version/open_access/files/uuid') > 0)
				{
					for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/thesis/version/open_access/files/uuid'); $i++) 
					{
						$tmp['open_access'][$i]['uuid'] = $itemXml->nodeValue('/xml/item/curriculum/thesis/version/open_access/files/uuid['.$i.']');
					}
				}
			}
			/******** End version ******************/	
			
			//thesis type
			$thesis_type = '/xml/item/curriculum/thesis/@type';
			$tmp['thesis_type'] = $itemXml->nodeValue($thesis_type);
			
			$coursework_type = '/xml/item/curriculum/thesis/@selected_type';
			$tmp['coursework_type'] = $itemXml->nodeValue($coursework_type);
			//student info
			$stu_id = '/xml/item/curriculum/people/students/student/@id';
			$tmp['stu_id'] =  addslashes(html_entity_decode($itemXml->nodeValue($stu_id)));
			
			$stu_first_name = '/xml/item/curriculum/people/students/student/firstname';
			$tmp['stu_first_name'] = addslashes(html_entity_decode($itemXml->nodeValue($stu_first_name)));
			
			$stu_last_name = '/xml/item/curriculum/people/students/student/lastname';
			$tmp['stu_last_name'] = addslashes(html_entity_decode($itemXml->nodeValue($stu_last_name)));
			
			$stu_first_name_dip = '/xml/item/curriculum/people/students/student/firstname_display';
			$tmp['stu_first_name_dip'] = addslashes(html_entity_decode($itemXml->nodeValue($stu_first_name_dip)));
			
			$stu_last_name_dip = '/xml/item/curriculum/people/students/student/lastname_display';
			$tmp['stu_last_name_dip'] = addslashes(html_entity_decode($itemXml->nodeValue($stu_last_name_dip)));
			
			$stu_email = '/xml/item/curriculum/people/students/student/email';
			$tmp['stu_email'] = $itemXml->nodeValue($stu_email);
			
			//coordinator info
			$coord_name = '/xml/item/curriculum/people/coords/coord/name';
			$tmp['coord_name'] = addslashes(html_entity_decode($itemXml->nodeValue($coord_name)));
			
			$coord_email = '/xml/item/curriculum/people/coords/coord/email';
			$tmp['coord_email'] = addslashes(html_entity_decode($itemXml->nodeValue($coord_email)));
			
			//complete date and year
			$comp_yr = '/xml/item/curriculum/thesis/complete_year';
			$tmp['comp_yr'] = $itemXml->nodeValue($comp_yr);
			
			$comp_date = '/xml/item/curriculum/thesis/complete_date';
			$tmp['comp_date'] = $itemXml->nodeValue($comp_date);
			
			//schools
			$school = '/xml/item/curriculum/thesis/schools/current_schools/current_school/org_unit';
			$tmp['school_org_unit'] = $itemXml->nodeValue($school);
			$school_name = '/xml/item/curriculum/thesis/schools/primary';
			$tmp['school_name'] = addslashes(html_entity_decode($itemXml->nodeValue($school_name)));
			//Topics
			if($itemXml->numNodes('/xml/item/curriculum/topics/topic/code') > 0)
			{
				for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/topics/topic/code'); $i++) 
				{
					$tmp['topic'][$i]['code'] = $itemXml->nodeValue('/xml/item/curriculum/topics/topic['.$i.']/code');
					$tmp['topic'][$i]['name'] = addslashes(html_entity_decode($itemXml->nodeValue('/xml/item/curriculum/topics/topic['.$i.']/name')));
				}
			}
			
			//version
			$open_access_required = '/xml/item/curriculum/thesis/version/open_access/required';
			$tmp['open_access_required'] = $itemXml->nodeValue($open_access_required);
			
			$thesis_version = '/xml/item/curriculum/thesis/version/thesis_version';
			$tmp['thesis_version'] = $itemXml->nodeValue($thesis_version);
			
			//Release
				//standard request
			$release_status = '/xml/item/curriculum/thesis/release/status'; //Restricted Access | Open Access | Never for release
			$tmp['release_status'] = $itemXml->nodeValue($release_status);
			
			$embargo_standard_request_duration = '/xml/item/curriculum/thesis/release/embargo_request/standard_request/duration';
			$tmp['embargo_standard_request_duration'] = $itemXml->nodeValue($embargo_standard_request_duration);
			
			$embargo_standard_request_reason = '/xml/item/curriculum/thesis/release/embargo_request/standard_request/reason';
			$tmp['embargo_standard_request_reason'] = addslashes(html_entity_decode($itemXml->nodeValue($embargo_standard_request_reason)));
				
				//extension request
			$embargo_extension = '/xml/item/curriculum/thesis/release/embargo_request/extension_request/duration';
			
		    $embargo_extension_request_duration = '/xml/item/curriculum/thesis/release/embargo_request/extension_request/requested';
			$tmp['embargo_extension'] = $itemXml->nodeValue($embargo_extension_request_duration);
			
			$embargo_extension_request_reason = '/xml/item/curriculum/thesis/release/embargo_request/extension_request/reason';
			$tmp['embargo_extension_request_reason'] = addslashes(html_entity_decode($itemXml->nodeValue($embargo_extension_request_reason)));
			
			
			
			//agreements
			$authenticity = '/xml/item/curriculum/thesis/agreements/authenticity';
			$tmp['authenticity'] = $itemXml->nodeValue($authenticity);
			
			$declaration = '/xml/item/curriculum/thesis/agreements/declaration';
			$tmp['declaration'] = $itemXml->nodeValue($declaration);

			$copyright = '/xml/item/curriculum/thesis/agreements/copyright';
			$tmp['copyright'] = $itemXml->nodeValue($copyright);
			
			$embargo = '/xml/item/curriculum/thesis/agreements/embargo';
			$tmp['embargo'] = $itemXml->nodeValue($embargo);
			
			//keywords
			$keywords = '/xml/item/curriculum/thesis/keywords/keyword';
			$tmp['keywords'] = addslashes(html_entity_decode($itemXml->nodeValue($keywords)));
			//language
			/*$language = '/xml/item/curriculum/thesis/language';
			$tmp['language'] = $itemXml->nodeValue($language);*/
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
		
		public function year_check($yr)
		{
			$year = intval($yr);
			
			if(preg_match('/^\d{4}$/', $year)) {
				if($year > 1980 && $year < 2030)
				{
					return true;	
				}
				else
				{
					return false;
				}
			}
			else {
			  return false;
			}
		}
		private function getSchools()
		{
			$this->load->helper('url');
			$oauth = array('oauth_client_config_name' => 'rhd');
			$this->load->library('flexrest/flexrest', $oauth);
		
			$success = $this->flexrest->processClientCredentialToken();
			
			if(!$success)
			{
				$errdata['heading'] = "Error";
				$errdata['message'] = $this->flexrest->error;
				$this->load->view('rhd/showerror_view', $errdata);
				return;
			}
			/***get school data from taxonomy**/
			
			$ci = & get_instance();
			$ci->load->config('flex');
			$rhd_schools_taxonomy_uuid = $ci->config->item('rhd_schools_taxonomy_uuid'); //get rhd school taxonomy uuid
		    
			$schools = array();
			$this->flexrest->getTaxonomy($rhd_schools_taxonomy_uuid, $r);
			if(count($r)>=1)
			{
				$schools[0]['text'] = '';
				$schools[0]['value']='#';
				for($i=0; $i < count($r); $i++)
				{
					if(isset($r[$i]['term']) && $r[$i]['term']!= '')
					{
						$schools[$i+1]['text'] = $r[$i]['term'];		
						$this->flexrest->getTermData($rhd_schools_taxonomy_uuid, $r[$i]['uuid'], 'org_unit', $r_data);
						$schools[$i+1]['value'] = $r_data['org_unit'];	
					}
				}
			}
			
			return $schools;
		}
		
		private function thesis_validation($item_array, $attachments)
		{
			$validation= array();
			
			//Part 1
			$part_1 = array();
			$valid = true;
			$part_1['error_list'] = array();
			$error_list = array();
			//thesis title
			if($item_array['thesis_title'] == '')
			{
				$part_1['error_list']['thesis_title'] = 'To be added';
				$valid = false;
			}
			//abstract
			if(!isset($item_array['abstract']) || $item_array['abstract'] == '')
			{
				$part_1['error_list']['abstract'] = 'To be added';
				
			}
			
			if(isset($item_array['abstract_attachment'][1]['uuid']) && $item_array['abstract_attachment'][1]['uuid'] != '')
			{
				$a_uuid = $item_array['abstract_attachment'][1]['uuid'];
				
				if(strlen($a_uuid) != 36)
				{
					$part_1['error_list']['abstract_attachment'] = 'Abstract attachment is not valid';
					$valid = false;
				}
				else
				{
					$flag = false;
					foreach ($attachments as $attachment) 
					{
						if($a_uuid  == $attachment['uuid'])
						{
							if($attachment['filename'] == '')
							{
								$part_1['error_list']['abstract_attachment'] = 'Abstract attachment upload error, please reupload';
								$valid = false;
							}
							if($attachment['size'] == '' || intval($attachment['size']) == 0)
							{
								$part_1['error_list']['abstract_attachment'] = 'Abstract attachment upload error, please reupload';
								$valid = false;
							}
							if($attachment['links']['view'] == '')
							{
								$part_1['error_list']['abstract_attachment'] = 'Abstract attachment upload error, please reupload';
								$valid = false;
							}
							
							$item_array['abstract_attachment'][1]['filename'] = $attachment['filename'];
							$item_array['abstract_attachment'][1]['filesize'] = $attachment['size'];
							$item_array['abstract_attachment'][1]['filelink'] = $attachment['links']['view'];
							$flag=true;
							break;
						}
					}
					if(!$flag)
					{
						$part_1['error_list']['abstract_attachment'] = 'Abstract attachment upload error (not found in stage), please re upload';
						$valid = false;
					}
				}
			}
			
			//thesis type
			/*if($item_array['thesis_type'] == '')
				array_push($part_1['error_info'], 'thesis type is required');
				$part_1['valid'] == false;*/
			
			//coursework type
			if($item_array['coursework_type'] == '')
			{
				$part_1['error_list']['coursework_type'] ='To be added';
				$valid = false;
			}
			
			//student id
			if($item_array['stu_id'] == '')
			{
				$part_1['error_list']['stu_id'] ='To be added';
				$valid = false;
			}
				
			//student email
			if($item_array['stu_email'] == '')
			{
				$part_1['error_list']['stu_email'] ='To be added';
				$valid = false;
			}
			else
			{
				//need to check email format
			}
			
			//supervisor name
			if($item_array['coord_name'] == '')
			{
				$part_1['error_list']['coord_name'] ='To be added';
				$valid = false;
			}
			
			//supervisor email
			if($item_array['coord_email'] != '')
			{
				//need to check email format
			
			}
			
			//complete year 
			if($item_array['comp_yr'] != '')
			{
				$valid = $this->year_check($item_array['comp_yr']);
				if(!$valid)
				{
					$part_1['error_list']['comp_yr'] ='Complete year is not valid';
					$valid = false;
					
				}
			}
			else
			{
				$part_1['error_list']['comp_yr'] ='To be added';
				$valid = false;
			}
			
			//school
			if($item_array['school_org_unit'] == '')
			{
				$part_1['error_list']['school_org_unit'] ='To be added';
				$valid = false;
			}
			
			//topic
			if(!isset($item_array['topic']))
			{
				$part_1['error_list']['topic']['error'] = 'To be added';
				$valid = false;
			}
			else
			{
				for($i = 1; $i <= count($item_array['topic']); $i++)
				{
					if($item_array['topic'][$i]['code']=='')
					{
						$part_1['error_list']['topic'][$i]['topic_code'] = 'To be added';
						$valid = false;
					}
					if($item_array['topic'][$i]['name']=='')
					{
						$part_1['error_list']['topic'][$i]['topic_name'] = 'To be added';
						$valid = false;
					}
				}
			}
			
			//keywords
			if($item_array['keywords'] == '')
			{
				$part_1['error_list']['keywords'] ='To be added';
				$valid = false;
			}
			
			$validation['part_1'] = $part_1;
			$validation['part_1']['valid'] = $valid ? 'valid' : 'invalid';	
			
			//part 2
			//examined thesis
			$part_2 = array();
			$valid = true;
			$part_2['error_list'] = array();
			
			$examined_thesis = $item_array['examined_thesis'];
			if(!isset($examined_thesis) || count($examined_thesis) < 1)
			{
				$part_2['error_list']['examined_thesis']['error']= 'To be added';
				$valid = false;
				
			}
			else
			{
				$index = 0;
				
				foreach($examined_thesis as $thesis)
				{
					$index ++;
					$a_uuid = $thesis['uuid'];
					if(strlen($thesis['uuid']) != 36)
					{
						$part_2['error_list']['examined_thesis'][$i]= 'Examined thesis attachment is not valid';
						$valid = false;
					}
					else
					{
						$flag = false;
						foreach ($attachments as $attachment) 
						{
							if($a_uuid  == $attachment['uuid'])
							{
								if($attachment['filename'] == '')
								{
									$part_2['error_list']['examined_thesis'][$i]= 'Examined thesis attachment upload error, please reupload (no file name)';
									$valid = false;
								}
								if($attachment['size'] == '' || intval($attachment['size']) == 0)
								{
									$part_2['error_list']['examined_thesis'][$i]= 'Examined thesis attachment upload error, please reupload (no file name)';
									$valid = false;
								}
								if($attachment['links']['view'] == '')
								{
									$part_2['error_list']['examined_thesis'][$i]= 'Examined thesis attachment upload error, please reupload (no file name)';
									$valid = false;
								}
								
								$item_array['examined_attachment'][$index]['filename'] = $attachment['filename'];
								$item_array['examined_attachment'][$index]['filesize'] = $attachment['size'];
								$item_array['examined_attachment'][$index]['filelink'] = $attachment['links']['view'];
								$flag = true;
								break;
							}
						}
						
						if(!$flag)
						{
							$part_2['error_list']['examined_thesis']['error']= 'Examined thesis attachment upload error (not found in stage), please re upload';
							$valid = false;
						}
					}
				}
			}
			
			
			//statements
			if(!isset($item_array['authenticity']) || $item_array['authenticity']== '')
			{
				$part_2['error_list']['authenticity'] = 'To be added';
				$valid = false;
			}
			
			if(!isset($item_array['declaration']) || $item_array['declaration']== '')
			{
				$part_2['error_list']['declaration'] = 'To be added';
				$valid = false;
			}
			
			$validation['part_2'] = $part_2;
			$validation['part_2']['valid']= $valid ? 'valid' : 'invalid';
			
			//part 3
			$part_3 = array();
			$valid = true;
			$part_3['error_list'] = array();
			
			//new_version_required
			if(!isset($item_array['open_access_required']) || $item_array['open_access_required'] == '')
			{
				$part_3['error_list']['open_access_required'] = 'To be added';
				$valid = false;
			}
			else if($item_array['open_access_required'] == 'new version')
			{
				$open_access = $item_array['open_access'];
				if(!isset($item_array['open_access']) || count($item_array['open_access']) < 1)
				{	
					$part_3['error_list']['open_access']['error'] =  'To be added';
					$valid = false;
				}
				else
				{
					$index = 0;
					
					foreach($item_array['open_access'] as $thesis)
					{
						$index ++;
						$a_uuid = $thesis['uuid'];
						if(strlen($thesis['uuid']) != 36)
						{
							$part_3['error_list']['open_access'][$index] = 'Open access thesis attachment is not valid';
							$valid == false;
						}
						else
						{
							$flag = false;
							foreach ($attachments as $attachment) 
							{
								if($a_uuid  == $attachment['uuid'])
								{
									if($attachment['filename'] == '')
									{
										$part_3['error_list']['open_access'][$index] = 'Open access thesis attachment '.$index.' upload error, please reupload (no file name)';
										$valid = false;
									}
									if($attachment['size'] == '' || intval($attachment['size']) == 0)
									{
										$part_3['error_list']['open_access'][$index] = 'Open access thesis attachment '.$index.' upload error, please reupload (size is 0)';
										$valid = false;
									}
									if($attachment['links']['view'] == '')
									{
										$part_3['error_list']['open_access'][$index] = 'Open access thesis attachment '.$index.' upload error, please reupload (not valid file link)';
										$valid = false;
									}
									
									$item_array['open_access_attachment'][$index]['filename'] = $attachment['filename'];
									$item_array['open_access_attachment'][$index]['filesize'] = $attachment['size'];
									$item_array['open_access_attachment'][$index]['filelink'] = $attachment['links']['view'];
									$flag = true;
									break;
								}
							}
							
							if(!$flag)
							{
								$part_3['error_list']['open_access'] = 'Open access attachment upload error (not found in stage), please re upload';
								$valid = false;
							}
						}
					}
				}
			}
			
			
			
			
			$release_status = $item_array['release_status'];
			if(!isset($release_status) || $release_status == '')
			{
				$part_3['error_list']['release_status'] = 'To be added';
				$valid = false;
			}
			
			if($release_status == 'Restricted Access')
			{
				$embargo_standard_request_reason = $item_array['embargo_standard_request_reason'];
				
				if($embargo_standard_request_reason == '')
				{
					$part_3['error_list']['release_status'] = 'To be added';
					$valid = false;
				}
				
				$embargo_standard_request_duration = $item_array['embargo_standard_request_duration'];
				if($embargo_standard_request_duration == '')
				{
					$part_3['error_list']['embargo_standard_request_duration'] = 'To be added';
					$valid = false;
				}
				if(intval($embargo_standard_request_duration) ==  36)
				{
					$embargo_extension = $item_array['embargo_extension'];
					if($embargo_standard_request_reason == 'Additional Restriction')
					{
						$embargo_extension_request_reason = $item_array['embargo_extension_request_reason'];
						if($embargo_extension_request_reason == '')
						{
							$part_3['error_list']['embargo_extension_request_reason'] = 'To be added';
							$valid = false;
						}
					}
				}
				
				$embargo = $item_array['embargo'];
				if($embargo == '')
				{
					$part_3['error_list']['embargo'] = 'To be added';
					$valid = false;
				}
			}
			
			if(!isset($item_array['copyright']) || $item_array['copyright']== '')
			{
				$part_3['error_list']['copyright'] = 'To be added';
				$valid = false;
			}
			
			$validation['part_3'] = $part_3;
			$validation['part_3']['valid']= $valid ? 'valid' : 'invalid';
			
			/*echo 'validation: <pre>';
			print_r($validation);
			echo '</pre>';*/
			$item_array['validation'] = $validation;
			return $item_array;
		}
		
		private function trim_all( $str , $what = NULL , $with = ' ' )
		{
			if( $what === NULL )
			{
				//  Character      Decimal      Use
				//  "\0"            0           Null Character
				//  "\t"            9           Tab
				//  "\n"           10           New line
				//  "\x0B"         11           Vertical Tab
				//  "\r"           13           New Line in Mac
				//  " "            32           Space
			   
				$what   = "\\x00-\\x20";    //all white-spaces and control chars
			}
		   
			return trim( preg_replace( "/[".$what."]+/" , $with , $str ) , $what );
		}
}
