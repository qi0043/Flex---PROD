<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generatetoken extends CI_Controller {
 
	public function index()
	{
		
			
		if(!isset($_SESSION)){ session_start();}
		#echo "activity.php - AC 21 APR 2015<br />";
		
		
		//echo "in function";
		
		
		//exit;
		
		#$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";
        
    
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		$ci =& get_instance();
		$ci->load->config('flex');
		$collections = $ci->config->item('topic_information_collection');
		
		$success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
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
		
		/* Find user permissions                                                    */
		
		/****************************************************************************/
		
		$fan = $_SERVER['REMOTE_USER'];
		
		//echo $fan;
		//
				

	
     

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
		//$groups = $this->flexsoap->getGroupsByUser($fan);
		//print_r($groups);
		/*
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
		*/
		//set up login user privilege
		$usergrp_taa_moderator = $ci -> config ->item('TAA moderation grp'); //get taa moderator group uuid
		$usergrp_taa_contributor = $ci -> config->item('TAA contributor grp'); //get taa contributor group uuid
		
		$user_role = '';
		
		if(strpos($groups, $usergrp_taa_moderator) !== false || strpos($groups, $usergrp_taa_contributor) !== false)
		{
			//$_SESSION['ocf_privilege'] = 'mod&con';
			$user_role = 'moderator&contributor';
		}
		
		
		/*
		
		if(!$this->permission->success)
        {   
           	$errdata['message'] = 'User not in authorised groups';
			$errdata['heading'] = "Internal error";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			exit();
        }
	
*/
	$theToken =  $this->generateToken1($fan);

	echo $theToken;
	
	 

	
	
	 
} 



/**********************************/
/*       FUNCTIONS                */
/**********************************/






	private function generateToken1($username)
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