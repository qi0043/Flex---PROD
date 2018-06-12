<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generatetoken extends CI_Controller {
 
	public function index()
	{
		
			
		if(!isset($_SESSION)){ session_start();}
		
		
		
		
		#echo "generatetoken.php - AC 27 JAN 2016<br />";
		
		
		
		
		
		
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
        if(!isset($_SESSION['userinfo']['fan']))
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
		
		$fan = $_SESSION['userinfo']['fan'];
		
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

	
	public function editactivity($items='missed', $uuid='missed', $version='missed')
	{
	    
		   if(!isset($_SESSION)){ session_start();}
		
		$this->load->helper('url');
            
            if($items != 'items' || strlen($uuid) != 36 || $version == 'missed' )
            {
                #$error_data = array('error_info'=>'Invalid data.');
                #$this->load->view('reading_listmgr/fromto_avails_error_view', $error_data);
                return;
            }
	    
            $ci =& get_instance();
            $ci->load->config('flex');
            $institute_url = $ci->config->item('institute_url');
            $reading_link = $institute_url . "items/" . $uuid . "/" . $version;
    
	    $fan = $_SESSION['userinfo']['fan'];
	    $token =  $this->generateToken1($fan);
	    $reading_link .= '?token=' . $token;
            
	    #if(isset($_SESSION['rollover_privilege']) && $_SESSION['rollover_privilege'] == 'topic_coordinator')
            #{
            #    $token = $this->generateToken();
            #    $reading_link .= '&token=' . $token;
                
            #}
	    
            redirect($reading_link);
																
	}

	public function viewSummaryPage($items='missed', $uuid='missed', $version='missed')
	{
		if(!isset($_SESSION)){ session_start();}
		
		$this->load->helper('url');
            
            if($items != 'items' || strlen($uuid) != 36 || $version == 'missed' )
            {
                #$error_data = array('error_info'=>'Invalid data.');
                #$this->load->view('reading_listmgr/fromto_avails_error_view', $error_data);
                return;
            }
	    
            $ci =& get_instance();
            $ci->load->config('flex');
            $institute_url = $ci->config->item('institute_url');
            $reading_link = $institute_url . "items/" . $uuid . "/" . $version;
    
	    $fan = $_SESSION['userinfo']['fan'];
	    $token =  $this->generateToken1($fan);
	    $reading_link .= '?token=' . $token;
            
	    #if(isset($_SESSION['rollover_privilege']) && $_SESSION['rollover_privilege'] == 'topic_coordinator')
            #{
            #    $token = $this->generateToken();
            #    $reading_link .= '&token=' . $token;
                
            #}
	    
            redirect($reading_link);
	}


	public function viewitem($items='missed', $uuid='missed', $version='missed', $auuid='missed')
	{
	    
		   
		  //echo "generatetoken.php - AC 27 JAN 2016<br />";
		  
		  //exit;
		  
		   
			   
			   
			   
			   #echo $items . "<br />";
			   #echo $uuid . "<br />";
			   #echo $version . "<br />";
			   #echo $auuid . "<br />";
			   
	
		   //exit;
		   
		   if(!isset($_SESSION)){ session_start();}
		
		$this->load->helper('url');
            
            if($items != 'items' || strlen($uuid) != 36 || $version == 'missed' || $auuid == 'missed' )
            {
                #$error_data = array('error_info'=>'Invalid data.');
                #$this->load->view('reading_listmgr/fromto_avails_error_view', $error_data);
                return;
            }
	    
            $ci =& get_instance();
            $ci->load->config('flex');
            $institute_url = $ci->config->item('institute_url');
            $reading_link = $institute_url . "items/" . $uuid . "/" . $version . "/?attachment.uuid=" . $auuid ;
			
			
    
	    $fan = $_SESSION['userinfo']['fan'];
	    $token =  $this->generateToken1($fan);
	    $reading_link .= '&token=' . $token;
		
		#echo $reading_link;
			#exit;
            
	    #if(isset($_SESSION['rollover_privilege']) && $_SESSION['rollover_privilege'] == 'topic_coordinator')
            #{
            #    $token = $this->generateToken();
            #    $reading_link .= '&token=' . $token;
                
            #}
	    
            redirect($reading_link);
																
	}



	public function viewfile($file='missed', $uuid='missed', $version='missed', $filename='missed')
	{

	   if(!isset($_SESSION)){ session_start();}
	
		
		$this->load->helper('url');
            
            if($file != 'file' || strlen($uuid) != 36 || $version == 'missed' || $filename=='missed' )
           {
              echo $file . "<br />";
              echo strlen($uuid) . "<br />";
              echo $filename . "<br />";
			 # echo base64_decode($filename) . "<br />";
            
                #$error_data = array('error_info'=>'Invalid data.');
                #$this->load->view('reading_listmgr/fromto_avails_error_view', $error_data);
               return;
           }
	    
            $ci =& get_instance();
            $ci->load->config('flex');
            $institute_url = $ci->config->item('institute_url');
            $reading_link = $institute_url . "file/" . $uuid . "/" . $version . "/" . $filename;
    
	    $fan = $_SESSION['userinfo']['fan'];
	    $token =  $this->generateToken1($fan);
	    $reading_link .= '?token=' . $token;
            
	    #if(isset($_SESSION['rollover_privilege']) && $_SESSION['rollover_privilege'] == 'topic_coordinator')
            #{
            #    $token = $this->generateToken();
            #    $reading_link .= '&token=' . $token;
                
            #}
	    
            redirect($reading_link);
																
	}
	
	/*
	 * View the management groups e.g. MD, AS-LIFT
	 * This is used in course map -> detail -> managed by...
	 */
	public function view_mgmgrps($mgmgrps='missed')
	{
	    $this->load->helper('url');
            
            if($mgmgrps == 'missed')
            {
                #$error_data = array('error_info'=>'Invalid data.');
                #$this->load->view('reading_listmgr/fromto_avails_error_view', $error_data);
                return;
            }
	    
            $ci =& get_instance();
            $ci->load->config('flex');
            $institute_url = $ci->config->item('institute_url');
	    $ocf_groups_collection = $ci->config->item('ocf_groups_collection');
            #$reading_link = $institute_url . "items/" . $uuid . "/" . $version . "/?attachment.uuid=" . $auuid ;
            $mgmgrps_lnk = $institute_url . 'access/searching.do?in=C' . $ocf_groups_collection . '&q=' . htmlentities($mgmgrps);
     
	    if(!isset($_SESSION['userinfo']['fan']))
		return;
	    $fan = $_SESSION['userinfo']['fan'];
	    
	    $token =  $this->generateToken1($fan);
	    $mgmgrps_lnk .= '&token=' . $token;
            
	    #if(isset($_SESSION['rollover_privilege']) && $_SESSION['rollover_privilege'] == 'topic_coordinator')
            #{
            #    $token = $this->generateToken();
            #    $reading_link .= '&token=' . $token;
                
            #}
	    
            redirect($mgmgrps_lnk);
																
	}


}