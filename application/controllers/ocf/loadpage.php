<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loadpage extends CI_Controller {
 
	public function index($linktype='missed', $uuid='missed', $version='missed', $webfile='missed')
	{
		$auuid = substr(base64_decode(urldecode($webfile)), 9, 36);
		
		//echo $pageuuid ;
		
		//echo $_SERVER['SERVER_NAME'];
		//exit;	
				
		switch ($_SERVER['SERVER_NAME']) {
		
		
			case "flextra.flinders.edu.au":
			
				$flexserv = "flex";
				break;
		
			case "flextra-test.flinders.edu.au":
			
				$flexserv = "flex-test";
				break;
		
		
			case "flextra-dev.flinders.edu.au":
			
				$flexserv = "flex-dev";
				break;
		
		}
	
		$theurl = $linktype.'/'.$uuid.'/'.$version.'/'. base64_decode(urldecode($webfile));
		
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
		$groups = $this->flexsoap->getGroupsByUser($userUuid);
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
		
		if(strpos($groups, $usergrp_taa_moderator) !== false || strpos($groups, $usergrp_taa_contributor) !== false)
		{
			//$_SESSION['ocf_privilege'] = 'mod&con';
			$user_role = 'moderator&contributor';
		}
		


		/****************************************************************************/
		
		/* Find the activity information                                               */
		
		/****************************************************************************/
		
		$success = $this->flexrest->getItemBasic($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
		
		
		$asuccess = $this->flexrest->getItemAttachments($uuid, $version, $aresponse);
        if(!$asuccess)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
		//echo "<pre>";
		foreach ($aresponse['attachments'] as $attachment) {
			
			//echo $attachment['uuid'] . " ";
			
			//echo $auuid ;
			
			if ($attachment['uuid'] == $auuid) {
				
				
			//	echo " true";
				$attachmenttitle = $attachment['description'];
				
			}
		//	echo  "<br />";
		}//
		
		//echo "</pre>";
		
	
		$usertoken = $this->generateToken($userUuid);
		
		$urltoget = "https://";
		$urltoget .= $flexserv . ".flinders.edu.au/";
		$urltoget .= $theurl;
		$urltoget .= "?token=";
		$urltoget .= $usertoken;
		
		$pagecontent = file_get_contents($urltoget);
	
		//echo $pagecontent;
		
		//exit;
					
		$data = array('theserver' => $flexserv, 'thePage' => $theurl, 'token' => $usertoken, 'privilege' => $user_role, 'pagecontent' => $pagecontent, 'activitytitle' => $response['name'], 'title' => $attachmenttitle);

		
		/*    ---------------       	

		if($_SERVER['REMOTE_USER'] == 'couc0005') {
			
			echo "<pre>";
			print_r($response);
			echo "</pre>";
			
			echo "<pre>";
			print_r($aresponse);
			echo "</pre>";
			
			echo "<pre>";
			print_r($data);
			echo "</pre>";
		}
				 
	
	*/
	
				
		$this->load->view('ocf/webpage', $data);
	 
} 



/**********************************/
/*       FUNCTIONS                */
/**********************************/





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