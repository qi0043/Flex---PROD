<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Trigger extends CI_Controller {
	
	
	

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
		
		#echo "trigger.php AC 19 AUG 2015<br />";
		
		
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
		
		#echo "get item basic<br />";
		
		
		
		
		$success_b = $this->flexrest->getItemBasic($uuid, $version, $basic);
        if(!$success_b)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('pbl/showerror_view', $errdata);
            return;
        }
		
		/*
		echo "<pre>";
       	print_r($basic);
       	echo "</pre>";
		*/
	   
	  	/****************************************************************************/
		
		/* Get attachment data                                                      */
		
		/****************************************************************************/
	   
	   $success_a = $this->flexrest->getItemAttachments($uuid, $version, $attachments);
        if(!$success_a)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('pbl/showerror_view', $errdata);
            return;
        }
		
		/*
		echo "<pre>";
      	print_r($attachments);
       	echo "</pre>";
		*/
		
		
		
	
		$data = array('basic' => $basic, 'files' => $attachments, 'token' => $this->generateToken($userUuid));
		
		$this->load->view('pbl/trigger', $data); 












		
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
				
				
				
				
				
				$who_for = '/xml/item/specific/pbls/pbl/sections/section'.$t.'/atoms/atom['.$s.']/@who_for';
				$textNode = '/xml/item/specific/pbls/pbl/sections/section'.$t.'/atoms/atom['.$s.']/text';
				
				
				$usage = $itemXml->nodeValue($who_for);
				$screenText = $itemXml->nodeValue($textNode);
				
				if ($usage == 'Standard') {
					
					
					$scrCounter++;
					
					
					$hashCounter++;
					
					
					$tmp['screens'][$hashCounter]['tutorial'] = $t;
					
					$tmp['screens'][$hashCounter]['screenNumber'] = $scrCounter;
					
					
					if ($hashCounter < 10) { $idhash = $hashseed."0".$hashCounter; } else { $idhash = $hashseed.$hashCounter; }
					$tmp['screens'][$hashCounter]['idhash'] = $idhash;
					
			
					$tmp['screens'][$hashCounter]['use'] = $usage;
					$tmp['screens'][$hashCounter]['text'] = $screenText;
				
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