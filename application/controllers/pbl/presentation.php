<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Presentation extends CI_Controller {
	
	
	

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/
<method_name>
* @see http://codeigniter.com/user_guide/general/urls.html
	**/

	public function index($uuid='missed', $version='missed')
	{
		
		
		if(!isset($_SESSION)){ session_start();}
		
		#$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";
        
        if($this->validate_params($uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            $this->load->view('pbl/showerror_view', $errdata);
            return;
        }
		
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		$ci =& get_instance();
		$ci->load->config('flex');
		
		
		$success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('pbl/showerror_view', $errdata);
            return;
        }    
        
		
		
		if(!isset($_SERVER['REMOTE_USER']))
		{
			$errdata['message'] = 'Unable to get username';
			$errdata['heading'] = "Internal error";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			exit();
		}
		
		
		/****************************************************************************/
		
		/* LDAP user functions                                                      */
		
		/****************************************************************************/
		
		#echo "LDAP functions<br />";
		
		
		//load the ldap library
		$this->load->library('ldap/ldap');
		
		if(!$this->ldap->success)
		{   
    		$errdata['message'] = 'Unable to connect to LDAP server';
			$errdata['heading'] = "Internal error";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			exit();
		}
		
		// get the user details
		
		
		$fan = strtolower($_SERVER['REMOTE_USER']);
		$result = $this->ldap->get_attributes($fan);
		if(!$this->ldap->success)
		{   
    		$errdata['message'] = 'User not found in LDAP';
			$errdata['heading'] = "Internal error";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			exit();
		}
	
	
		
		$ldapgroups = array();
		
		
		$ldapgroups = $result['groups'];
		
		
		
	
		
		$groupauth = $this->ldap->findLDAPgroup($ldapgroups);
		
		/****************************************************************************/
		
		/* Soap user functions                                                      */
		
		/****************************************************************************/
		
		#echo "SOAP functions<br />";
		
		
		$userUuid = strtolower($_SERVER['REMOTE_USER']);

        $this->soapusername = $ci->config->item('soap_username');
		$this->soappassword = $ci->config->item('soap_password');
		$this->soapparams = array('username'=>$this->soapusername, 'password'=>$this->soappassword);
		   
		
		
		$this->load->library('flexsoap/flexsoap',$this->soapparams);
		if(!$this->flexsoap->success)
		{
			
			$this->logger_rollover->error($this->flexsoap->error_info);
			$this->logger_activation->error($this->flexsoap->error_info);
			$errdata['message'] = $this->flexsoap->error_info;
			$errdata['heading'] = "Internal error";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			exit();
		}
			
     
		//get user group
		$internalgroups = $this->flexsoap->getGroupsByUser($userUuid);
		//print_r($groups);
		
		if(!$this->flexsoap->success)
		{
			####
			$this->logger_rollover->error($this->flexsoap->error_info);
			$this->logger_activation->error($this->flexsoap->error_info);
			$errdata['message'] = $this->flexsoap->error_info;
			$errdata['heading'] = "Internal error";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			exit();
		}
		//set up login user privilege
		$usergrp_taa_moderator = $ci -> config ->item('TAA moderation grp'); //get taa moderator group uuid
		$usergrp_taa_contributor = $ci -> config->item('TAA contributor grp'); //get taa contributor group uuid
		
		$user_role = '';
		
		if(strpos($internalgroups, $usergrp_taa_moderator) !== false || strpos($internalgroups, $usergrp_taa_contributor) !== false)
		{
			$_SESSION['ocf_privilege'] = 'mod&con';
			$user_role = 'moderator&contributor';
		}
		
		
		
		
		/****************************************************************************/
		
		/* Get item data                                                            */
		
		/****************************************************************************/
		
		
        $success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('pbl/showerror_view', $errdata);
            return;
        }
		
		
	
        
		
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));
		
		if(!$this->itemIsPBL($this->xmlwrapper))
        {
            $errdata['message'] = "Item is not a PBL Case";
            $this->load->view('pbl/showerror_view', $errdata);
            return;
        }
		
		$case_array = $this->pblXml2Array($this->xmlwrapper);
		
		$case_array['uuid'] = $uuid;
		$case_array['version'] = $version;
			
/*   ----------------------------               
		echo'<pre>';
       	print_r($case_array);
       	echo'</pre>';
		
		exit;
		

*/
		$restricted = false;
		
		$attachments = array();
		$i = 0;
		
	foreach ($response['attachments'] as $attachment) {
			
			$cp = stripos($attachment['description'], 'cover photo');
			$ct = stripos($attachment['description'], 'case trigger');
			$unused = stripos($attachment['description'], 'unused');
			
	
			
			if (($cp <= 1) && ($ct <= 1) && ($unused <= 1)) {
			
			
			
			$i++;
			
			$attachments[$i]['cp'] = 0;
			$attachments[$i]['ct'] = 0;
			$attachments[$i]['hide'] = 0;
			
			$attachments[$i]['cp'] = stripos($attachment['description'], 'cover photo');
			$attachments[$i]['ct'] = stripos($attachment['description'], 'case trigger');
			$attachments[$i]['hide'] = stripos($attachment['description'], 'true');
			
			

			
			$attachments[$i]['title'] =  $attachment['description'];
			$attachments[$i]['filename'] =  $attachment['filename'];
			$attachments[$i]['thumbnail'] =  $attachment['thumbnail'];
			$attachments[$i]['uuid'] =  $attachment['uuid'];
			$attachments[$i]['type'] =  $attachment['type'];
			$attachments[$i]['url'] =  $attachment['url'];
			$attachments[$i]['thumbnailLink'] =  $attachment['links']['thumbnail'];
			$attachments[$i]['view'] =  $attachment['links']['view'];
			
				
			}
			
			
			
			
			
		
		}
		
		
		
		$data = array('case' => $case_array, 'caseresources' => $attachments, 'token' => $this->generateToken($userUuid));
		
		
		//$this->load->view('pbl/caseview', $data);
		
		$this->load->view('pbl/caseview2', $data);
		

		
		}
	
	
	
	    /**
     * Check whether the item has a type of Topic Information
     *
     * @param xmlwrapper $itemXml
     */
    protected function itemIsPbl($itemXml) 
    { 

        $type = '/xml/item/curriculum/@item_type';
        $itemistopic = $itemXml->nodeValue($type);
        if(isset($itemistopic) && $itemistopic=='PBL Case')
            return true;
        return false;
    }
	

 /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function pblXml2Array($itemXml) 
    { 

 

		
		
		$caseTitle = '/xml/item/itembody/name';
		$numTutes = '/xml/item/specific/pbls/pbl/number_sections';
		
		$hashCtr = 0;
		
		
		$tmp['caseTitle'] = $itemXml->nodeValue($caseTitle);
		$tmp['numTutes'] = intval($itemXml->nodeValue($numTutes));
		
		
		$hashseed = substr(md5($itemXml->nodeValue($caseTitle)),0,4);
		
	
		
		
		$numTutes = intval($itemXml->nodeValue($numTutes));
		
		
		$hashCounter = 0;
		
		
		
		for ($t=1; $t <= $numTutes; $t++) {
			
			
			//$tmp['tutorial'][$t]['number'] = $t;
			
			$numAtoms = $itemXml->numNodes('/xml/item/specific/pbls/pbl/sections/section'.$t.'/atoms/atom');
			//$tmp['tutorial'][$t]['numAtoms'] = $numAtoms;
			
			
			$scrCounter = 0;
			
			for ($s = 1; $s <= $numAtoms; $s++) {
				
				
				
				
				
				$iconType = '/xml/item/specific/pbls/pbl/sections/section'.$t.'/atoms/atom['.$s.']/@icon_type';
				$who_for = '/xml/item/specific/pbls/pbl/sections/section'.$t.'/atoms/atom['.$s.']/@who_for';
				$atomName = '/xml/item/specific/pbls/pbl/sections/section'.$t.'/atoms/atom['.$s.']/name';
				$textNode = '/xml/item/specific/pbls/pbl/sections/section'.$t.'/atoms/atom['.$s.']/text';
				
				
				$icon = $itemXml->nodeValue($iconType);
				$usage = $itemXml->nodeValue($who_for);
				$screenName = $itemXml->nodeValue($atomName);
				$screenText = $itemXml->nodeValue($textNode);
				
				switch ($icon) {
					
					case 1:
						$iconfile = '1_patient_presentation_48px.png';
						$iconName = "Patient Presentation";
						break;
					
					case 2:
						$iconfile = '2_overview_48px.png';
						$iconName = "Overview";
						break;
					
					case 3:
						$iconfile = '3_tutor_notes_48px.png';
						$iconName = "Tutor Notes";
						break;
						
					case 4:
						$iconfile = '4_discussion_questions_48px.png';
						$iconName = "Discussion Qustions";
						break;
						
					case 5:
						$iconfile = '5_history_48px.png';
						$iconName = "History";
						break;
						
					case 6:
						$iconfile = '6_examination_48px.png';
						$iconName = "Examination";
						break;
						
					case 7:
						$iconfile = '7_information_48px.png';
						$iconName = "Information";
						break;
						
					case 8:
						$iconfile = '8_follow_up_48px.png';
						$iconName = "Follow up";
						break;
						
					case 9:
						$iconfile = '9_further_developments_48px.png';
						$iconName = "Further tests";
						break;
						
					case 10:
						$iconfile = '10_lab_tests_48px.png';
						$iconName = "Laboratory tests";
						break;
						
					case 11:
						$iconfile = '11_objectives_48px.png';
						$iconName = "Objectives";
						break;
						
					case 12:
						$iconfile = '12_resources_48px.png';
						$iconName = "Resources";
						break;
						
					case 13:
						$iconfile = '13_learning_issues_48px.png';
						$iconName = "Learning issues";
						break;
						
					
					
				
				
				
				
				
				
				
				}
				
				
				if ($usage == 'Student') {
					
					
					$scrCounter++;
					
					
					$hashCounter++;
					
					
					$tmp['screens'][$hashCounter]['tutorial'] = $t;
					
					$tmp['screens'][$hashCounter]['screenNumber'] = $scrCounter;
					
					
					if ($hashCounter < 10) { $idhash = $hashseed."0".$hashCounter; } else { $idhash = $hashseed.$hashCounter; }
					$tmp['screens'][$hashCounter]['idhash'] = $idhash;
					
			
					$tmp['screens'][$hashCounter]['use'] = $usage;
					$tmp['screens'][$hashCounter]['text'] = $screenText;
					$tmp['screens'][$hashCounter]['icon'] = $iconfile;
					$tmp['screens'][$hashCounter]['iconName'] = $iconName;
					$tmp['screens'][$hashCounter]['screenName'] = $screenName;
				
				}  // end of standard text
				
				
			}   // end of $s loop = screens
			
			
			
		}  // end of $t loop = tutorials

			
			

		
		
        return $tmp;

    }


    /**
     * Validate incoming parameters
     *
     * @param string $format, html/pdf
     * @param array $uuid, item UUID
     * @param array $version, item Version
     */
    protected function validate_params($uuid, $version)
    {

        if(strcmp($uuid, 'missed')==0 || strlen($uuid) != 36)
            return false;
        
        if(strcmp($version, 'missed')==0 || !is_numeric($version))
            return false;
        
        return true;
    }
	
	
	
	 private function generateToken($username)
	{
		$ci =& get_instance();
		$ci->load->config('flex');
	
		$sharedSecretId = $ci->config->item('ocf_shared_secret_id');
		$sharedSecretValue = $ci->config->item('ocf_shared_secret_value');
		

	
		$time = mktime() . '000';
				
	    return urlencode ($username) . ':' . urlencode($sharedSecretId) . ':' .  $time . ':' . 
	    urlencode(base64_encode (pack ('H*', md5 ($username . $sharedSecretId . $time . $sharedSecretValue))));
																
	}
    
	 
}

/* End of file startup.php */