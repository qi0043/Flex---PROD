<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Activitygroupflo extends CI_Controller {

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

	public function index($uuid='missed', $version='missed', $tcode='missed', $parent='missed', $pversion='missed', $depth='missed')
	{
		
	
		session_start();

		//$_SESSION['nav']['parent'] = $_SESSION['nav']['current'];
		
		
		$_SESSION['nav']['current'] = explode('/', $_SERVER['REQUEST_URI']);
		
		
		sleep(1);
		
		
		#$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";
        
        if($this->validate_params($uuid, $version) == false)
        {
            $errdata['message'] = "Invalid learning and teaching uuid or version";
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
		
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		$ci =& get_instance();
		$ci->load->config('flex');
		
		$success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = 'error in learning and teaching controller process clicent credential token: '.$this->flexrest->error;
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
		
		
		$fan = strtolower($_SESSION['userinfo']['fan']);
			
		$userUuid = strtolower($_SESSION['userinfo']['fan']);

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
		
		
			$success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = 'error in learning and teaching controller getItem:'.$this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }

			
			$xmlwrapper_name = 'xmlwrapper'.'lat';
			
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
		
		
		
		
		if(!$this->itemIsIntegrated($this->$xmlwrapper_name))
        {
            $errdata['message'] = "Item is not integrated";
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
		
		
		 
		
		$item_array = $this->itemXml2Array($this->$xmlwrapper_name);
		
		$activitylos_array = $this->itemLOsXml2Array($this->$xmlwrapper_name);
		
		
		/****************************************************************************/		
		/* Get information about instructions and resources from attachments        */		
		/****************************************************************************/	
		
		
		// check for populated arrays
		
		$overall = empty($item_array['overall']);
		$pre = empty($item_array['pre']);
		$during = empty($item_array['during']);
		$post = empty($item_array['post']);
		$teachingTeam = empty($item_array['teachingTeam']);
		
	    /****************************************************************************/		
		/*          POPULATE ATTACHMENT ARRAYS                                      */		
		/****************************************************************************/		
		
		
		
		if (!($overall)) {  // overall array not empty
		
		if(!(empty($item_array['overall']['instructions']))) {
			
		$Uuid = $item_array['overall']['instructions']['uuid'];
		
					
			foreach ($response['attachments'] as $attachment) {
				
				$aUuid = $attachment['uuid'];
				
				if ($Uuid == $aUuid) {
					
					
					
					switch ($attachment['type']) {
						
						case 'file':
													
							$item_array['overall']['instructions']['description'] = $attachment['description'];
							$item_array['overall']['instructions']['filename'] = $attachment['filename'];
							$item_array['overall']['instructions']['thumbnail'] = $attachment['thumbFilename'];
							$item_array['overall']['instructions']['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['overall']['instructions']['description'] = $attachment['description'];
							$item_array['overall']['instructions']['filename'] = $attachment['filename'];
							$item_array['overall']['instructions']['type'] = $attachment['type'];
							$item_array['overall']['instructions']['resourceType'] = $attachment['resourceType'];
							break;
						
						
						case 'linked-resource':
						
							
							if ($attachment['resourceType']	== 'p') {	// resource type p
											
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
								if($typeasuccess)
									{
										$item_array['overall']['instructions']['pbl'] = 'False';
										if($typearesponse['collection']['uuid']== $pblCollectionUuid)
											{
												$item_array['overall']['instructions']['pbl'] = 'True';
											}
									}	
												
							$item_array['overall']['instructions']['description'] = $attachment['description'];
							$item_array['overall']['instructions']['itemUuid'] = $attachment['itemUuid'];
							$item_array['overall']['instructions']['itemVersion'] = $attachment['itemVersion'];
							$item_array['overall']['instructions']['type'] = $attachment['type'];
							$item_array['overall']['instructions']['resourceType'] = $attachment['resourceType'];
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['overall']['instructions']['description'] = $attachment['description'];
								$item_array['overall']['instructions']['itemUuid'] = $attachment['itemUuid'];
								$item_array['overall']['instructions']['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['overall']['instructions']['itemVersion'] = $attachment['itemVersion'];
								//$item_array['overall']['instructions']['type'] = $attachment['type'];
								$item_array['overall']['instructions']['resourceType'] = $attachment['resourceType'];
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
       							 if(!$typeasuccess)
        							{
        					   			 $errdata['message'] = $this->flexrest->error;
           								 $this->load->view('ocf/showerror_view', $errdata);
            								return;
        							}
								
								
								foreach ($typearesponse['attachments'] as $subattachment) { // subattachments
								
									if ($subattachment['uuid'] == $attachment['attachmentUuid']) { // uuid match
										
										$item_array['overall']['instructions']['description'] = $subattachment['description'];
										$item_array['overall']['instructions']['filename'] = $subattachment['filename'];
										$item_array['overall']['instructions']['type'] = $subattachment['type'];
										
										
										} // uuid match
										
									}   // end subattachments
									
							}   // end type a
							
							
							
							break;
							
						case 'url':
	
							$item_array['overall']['instructions']['description'] = $attachment['description'];
							$item_array['overall']['instructions']['url'] = $attachment['url'];
							$item_array['overall']['instructions']['type'] = $attachment['type'];
							break;
							
							
					}  // end switch
	
				} // end overallUuid == aUuid
	
			}  // foreach

		
		} // instructions not empty
		
		// get infor for linked resources
		
		$l = 0; // counter variable
		
		
		if(!(empty($item_array['overall']['linked']))) {
			
			foreach ($item_array['overall']['linked'] as $linked) {
			
			$Uuid = $linked['uuid'];
			
			$a = 0;
			
			foreach ($response['attachments'] as $attachment) {
				
				
				$a++;
				
				$aUuid = $attachment['uuid'];
				
				
				if ($Uuid == $aUuid) {  // uuid match
				
					$l++; // increment counter
					
					switch ($attachment['type']) {
						
						case 'file':
													
							$item_array['overall']['linked'][$l]['description'] = $attachment['description'];
							$item_array['overall']['linked'][$l]['filename'] = $attachment['filename'];
							$item_array['overall']['linked'][$l]['thumbnail'] = $attachment['thumbFilename'];
							$item_array['overall']['linked'][$l]['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['overall']['linked'][$l]['description'] = $attachment['description'];
							$item_array['overall']['linked'][$l]['filename'] = $attachment['filename'];
							$item_array['overall']['linked'][$l]['type'] = $attachment['type'];
							$item_array['overall']['linked'][$l]['resourceType'] = $attachment['resourceType'];
							break;
						
						case 'linked-resource':
						
							
							if ($attachment['resourceType']	== 'p') {	// resource type p
							
							
								$item_array['overall']['linked'][$l]['pbl'] = 'False';
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
									if($typeasuccess)
									{
										if($typearesponse['collection']['uuid']== $pblCollectionUuid)
										{
											$item_array['overall']['linked'][$l]['pbl'] = 'True';
										}
										
									}	
							
											
								$item_array['overall']['linked'][$l]['description'] = $attachment['description'];
								$item_array['overall']['linked'][$l]['itemUuid'] = $attachment['itemUuid'];
								$item_array['overall']['linked'][$l]['itemVersion'] = $attachment['itemVersion'];
								$item_array['overall']['linked'][$l]['type'] = $attachment['type'];
								$item_array['overall']['linked'][$l]['resourceType'] = $attachment['resourceType'];
								
								
								
								
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['overall']['linked'][$l]['description'] = $attachment['description'];
								$item_array['overall']['linked'][$l]['itemUuid'] = $attachment['itemUuid'];
								$item_array['overall']['linked'][$l]['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['overall']['linked'][$l]['itemVersion'] = $attachment['itemVersion'];
								//$item_array['overall']['linked'][$l]['type'] = $attachment['type'];
								$item_array['overall']['linked'][$l]['resourceType'] = $attachment['resourceType'];
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
       							 if(!$typeasuccess)
        							{
        					   			 $errdata['message'] = $this->flexrest->error;
           								 $this->load->view('ocf/showerror_view', $errdata);
            								return;
        							}
								
								
								foreach ($typearesponse['attachments'] as $subattachment) { // subattachments
								
									if ($subattachment['uuid'] == $attachment['attachmentUuid']) { // uuid match
										
										$item_array['overall']['linked'][$l]['description'] = $subattachment['description'];
										$item_array['overall']['linked'][$l]['filename'] = $subattachment['filename'];
										$item_array['overall']['linked'][$l]['type'] = $subattachment['type'];
										
										
										} // uuid match
										
									}   // end subattachments
									
							}   // end type a
							
							
							
							break;
							
						case 'url':
	
							$item_array['overall']['linked'][$l]['description'] = $attachment['description'];
							$item_array['overall']['linked'][$l]['url'] = $attachment['url'];
							$item_array['overall']['linked'][$l]['type'] = $attachment['type'];
							break;
							
							
					}
					
					
				}
				
				
			}  // end foreach attachment
			
			
			
			}  // end foreach linked
			
		}   // end if linked not empty
		
		
		
		} // end overall not empty
		
		
		
		
		
				
		if (!($pre)) {  // pre array not empty
		
		if(!(empty($item_array['pre']['instructions']))) {
			
		$Uuid = $item_array['pre']['instructions']['uuid'];
		
					
			foreach ($response['attachments'] as $attachment) {
				
				$aUuid = $attachment['uuid'];
				
				if ($Uuid == $aUuid) {
					
					
					
					switch ($attachment['type']) {
						
						case 'file':
													
							$item_array['pre']['instructions']['description'] = $attachment['description'];
							$item_array['pre']['instructions']['filename'] = $attachment['filename'];
							$item_array['pre']['instructions']['thumbnail'] = $attachment['thumbFilename'];
							$item_array['pre']['instructions']['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['pre']['instructions']['description'] = $attachment['description'];
							$item_array['pre']['instructions']['filename'] = $attachment['filename'];
							$item_array['pre']['instructions']['type'] = $attachment['type'];
							$item_array['pre']['instructions']['resourceType'] = $attachment['resourceType'];
							break;
						
						
						case 'linked-resource':
						
							
							if ($attachment['resourceType']	== 'p') {	// resource type p
											
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
								if($typeasuccess)
									{
										$item_array['pre']['instructions']['pbl'] = 'False';
										if($typearesponse['collection']['uuid']== $pblCollectionUuid)
											{
												$item_array['pre']['instructions']['pbl'] = 'True';
											}
									}	
												
							$item_array['pre']['instructions']['description'] = $attachment['description'];
							$item_array['pre']['instructions']['itemUuid'] = $attachment['itemUuid'];
							$item_array['pre']['instructions']['itemVersion'] = $attachment['itemVersion'];
							$item_array['pre']['instructions']['type'] = $attachment['type'];
							$item_array['pre']['instructions']['resourceType'] = $attachment['resourceType'];
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['pre']['instructions']['description'] = $attachment['description'];
								$item_array['pre']['instructions']['itemUuid'] = $attachment['itemUuid'];
								$item_array['pre']['instructions']['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['pre']['instructions']['itemVersion'] = $attachment['itemVersion'];
								//$item_array['pre']['instructions']['type'] = $attachment['type'];
								$item_array['pre']['instructions']['resourceType'] = $attachment['resourceType'];
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
       							 if(!$typeasuccess)
        							{
        					   			 $errdata['message'] = $this->flexrest->error;
           								 $this->load->view('ocf/showerror_view', $errdata);
            								return;
        							}
								
								
								foreach ($typearesponse['attachments'] as $subattachment) { // subattachments
								
									if ($subattachment['uuid'] == $attachment['attachmentUuid']) { // uuid match
										
										$item_array['pre']['instructions']['description'] = $subattachment['description'];
										$item_array['pre']['instructions']['filename'] = $subattachment['filename'];
										$item_array['pre']['instructions']['type'] = $subattachment['type'];
										
										
										} // uuid match
										
									}   // end subattachments
									
							}   // end type a
							
							
							
							break;
							
						case 'url':
	
							$item_array['pre']['instructions']['description'] = $attachment['description'];
							$item_array['pre']['instructions']['url'] = $attachment['url'];
							$item_array['pre']['instructions']['type'] = $attachment['type'];
							break;
							
							
					}  // end switch
	
				} // end preUuid == aUuid
	
			}  // foreach

		
		} // instructions not empty
		
		// get infor for linked resources
		
		$l = 0; // counter variable
		
		
		if(!(empty($item_array['pre']['linked']))) {
			
			foreach ($item_array['pre']['linked'] as $linked) {
			
			$Uuid = $linked['uuid'];
			
			$a = 0;
			
			foreach ($response['attachments'] as $attachment) {
				
				
				$a++;
				
				$aUuid = $attachment['uuid'];
				
				
				if ($Uuid == $aUuid) {  // uuid match
				
					$l++; // increment counter
					
					switch ($attachment['type']) {
						
						case 'file':
													
							$item_array['pre']['linked'][$l]['description'] = $attachment['description'];
							$item_array['pre']['linked'][$l]['filename'] = $attachment['filename'];
							$item_array['pre']['linked'][$l]['thumbnail'] = $attachment['thumbFilename'];
							$item_array['pre']['linked'][$l]['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['pre']['linked'][$l]['description'] = $attachment['description'];
							$item_array['pre']['linked'][$l]['filename'] = $attachment['filename'];
							$item_array['pre']['linked'][$l]['type'] = $attachment['type'];
							$item_array['pre']['linked'][$l]['resourceType'] = $attachment['resourceType'];
							break;
						
						case 'linked-resource':
						
							
							if ($attachment['resourceType']	== 'p') {	// resource type p
							
							
								$item_array['pre']['linked'][$l]['pbl'] = 'False';
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
									if($typeasuccess)
									{
										if($typearesponse['collection']['uuid']== $pblCollectionUuid)
										{
											$item_array['pre']['linked'][$l]['pbl'] = 'True';
										}
										
									}	
							
											
								$item_array['pre']['linked'][$l]['description'] = $attachment['description'];
								$item_array['pre']['linked'][$l]['itemUuid'] = $attachment['itemUuid'];
								$item_array['pre']['linked'][$l]['itemVersion'] = $attachment['itemVersion'];
								$item_array['pre']['linked'][$l]['type'] = $attachment['type'];
								$item_array['pre']['linked'][$l]['resourceType'] = $attachment['resourceType'];
								
								
								
								
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['pre']['linked'][$l]['description'] = $attachment['description'];
								$item_array['pre']['linked'][$l]['itemUuid'] = $attachment['itemUuid'];
								$item_array['pre']['linked'][$l]['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['pre']['linked'][$l]['itemVersion'] = $attachment['itemVersion'];
								//$item_array['pre']['linked'][$l]['type'] = $attachment['type'];
								$item_array['pre']['linked'][$l]['resourceType'] = $attachment['resourceType'];
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
       							 if(!$typeasuccess)
        							{
        					   			 $errdata['message'] = $this->flexrest->error;
           								 $this->load->view('ocf/showerror_view', $errdata);
            								return;
        							}
								
								
								foreach ($typearesponse['attachments'] as $subattachment) { // subattachments
								
									if ($subattachment['uuid'] == $attachment['attachmentUuid']) { // uuid match
										
										$item_array['pre']['linked'][$l]['description'] = $subattachment['description'];
										$item_array['pre']['linked'][$l]['filename'] = $subattachment['filename'];
										$item_array['pre']['linked'][$l]['type'] = $subattachment['type'];
										
										
										} // uuid match
										
									}   // end subattachments
									
							}   // end type a
							
							
							
							break;
							
						case 'url':
	
							$item_array['pre']['linked'][$l]['description'] = $attachment['description'];
							$item_array['pre']['linked'][$l]['url'] = $attachment['url'];
							$item_array['pre']['linked'][$l]['type'] = $attachment['type'];
							break;
							
							
					}
					
					
				}
				
				
			}  // end foreach attachment
			
			
			
			}  // end foreach linked
			
		}   // end if linked not empty
		
		
		
		} // end pre not empty
		
		
	
	
	
	if (!($during)) {  // during array not empty
		
		if(!(empty($item_array['during']['instructions']))) {
			
		$Uuid = $item_array['during']['instructions']['uuid'];
		
					
			foreach ($response['attachments'] as $attachment) {
				
				$aUuid = $attachment['uuid'];
				
				if ($Uuid == $aUuid) {
					
					
					
					switch ($attachment['type']) {
						
						case 'file':
													
							$item_array['during']['instructions']['description'] = $attachment['description'];
							$item_array['during']['instructions']['filename'] = $attachment['filename'];
							$item_array['during']['instructions']['thumbnail'] = $attachment['thumbFilename'];
							$item_array['during']['instructions']['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['during']['instructions']['description'] = $attachment['description'];
							$item_array['during']['instructions']['filename'] = $attachment['filename'];
							$item_array['during']['instructions']['type'] = $attachment['type'];
							$item_array['during']['instructions']['resourceType'] = $attachment['resourceType'];
							break;
						
						
						case 'linked-resource':
						
							
							if ($attachment['resourceType']	== 'p') {	// resource type p
											
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
								if($typeasuccess)
									{
										$item_array['during']['instructions']['pbl'] = 'False';
										if($typearesponse['collection']['uuid']== $pblCollectionUuid)
											{
												$item_array['during']['instructions']['pbl'] = 'True';
											}
									}	
												
							$item_array['during']['instructions']['description'] = $attachment['description'];
							$item_array['during']['instructions']['itemUuid'] = $attachment['itemUuid'];
							$item_array['during']['instructions']['itemVersion'] = $attachment['itemVersion'];
							$item_array['during']['instructions']['type'] = $attachment['type'];
							$item_array['during']['instructions']['resourceType'] = $attachment['resourceType'];
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['during']['instructions']['description'] = $attachment['description'];
								$item_array['during']['instructions']['itemUuid'] = $attachment['itemUuid'];
								$item_array['during']['instructions']['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['during']['instructions']['itemVersion'] = $attachment['itemVersion'];
								//$item_array['during']['instructions']['type'] = $attachment['type'];
								$item_array['during']['instructions']['resourceType'] = $attachment['resourceType'];
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
       							 if(!$typeasuccess)
        							{
        					   			 $errdata['message'] = $this->flexrest->error;
           								 $this->load->view('ocf/showerror_view', $errdata);
            								return;
        							}
								
								
								foreach ($typearesponse['attachments'] as $subattachment) { // subattachments
								
									if ($subattachment['uuid'] == $attachment['attachmentUuid']) { // uuid match
										
										$item_array['during']['instructions']['description'] = $subattachment['description'];
										$item_array['during']['instructions']['filename'] = $subattachment['filename'];
										$item_array['during']['instructions']['type'] = $subattachment['type'];
										
										
										} // uuid match
										
									}   // end subattachments
									
							}   // end type a
							
							
							
							break;
							
						case 'url':
	
							$item_array['during']['instructions']['description'] = $attachment['description'];
							$item_array['during']['instructions']['url'] = $attachment['url'];
							$item_array['during']['instructions']['type'] = $attachment['type'];
							break;
							
							
					}  // end switch
	
				} // end duringUuid == aUuid
	
			}  // foreach

		
		} // instructions not empty
		
		// get infor for linked resources
		
		$l = 0; // counter variable
		
		
		if(!(empty($item_array['during']['linked']))) {
			
			foreach ($item_array['during']['linked'] as $linked) {
			
			$Uuid = $linked['uuid'];
			
			$a = 0;
			
			foreach ($response['attachments'] as $attachment) {
				
				
				$a++;
				
				$aUuid = $attachment['uuid'];
				
				
				if ($Uuid == $aUuid) {  // uuid match
				
					$l++; // increment counter
					
					switch ($attachment['type']) {
						
						case 'file':
													
							$item_array['during']['linked'][$l]['description'] = $attachment['description'];
							$item_array['during']['linked'][$l]['filename'] = $attachment['filename'];
							$item_array['during']['linked'][$l]['thumbnail'] = $attachment['thumbFilename'];
							$item_array['during']['linked'][$l]['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['during']['linked'][$l]['description'] = $attachment['description'];
							$item_array['during']['linked'][$l]['filename'] = $attachment['filename'];
							$item_array['during']['linked'][$l]['type'] = $attachment['type'];
							$item_array['during']['linked'][$l]['resourceType'] = $attachment['resourceType'];
							break;
						
						case 'linked-resource':
						
							
							if ($attachment['resourceType']	== 'p') {	// resource type p
							
							
								$item_array['during']['linked'][$l]['pbl'] = 'False';
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
									if($typeasuccess)
									{
										if($typearesponse['collection']['uuid']== $pblCollectionUuid)
										{
											$item_array['during']['linked'][$l]['pbl'] = 'True';
										}
										
									}	
							
											
								$item_array['during']['linked'][$l]['description'] = $attachment['description'];
								$item_array['during']['linked'][$l]['itemUuid'] = $attachment['itemUuid'];
								$item_array['during']['linked'][$l]['itemVersion'] = $attachment['itemVersion'];
								$item_array['during']['linked'][$l]['type'] = $attachment['type'];
								$item_array['during']['linked'][$l]['resourceType'] = $attachment['resourceType'];
								
								
								
								
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['during']['linked'][$l]['description'] = $attachment['description'];
								$item_array['during']['linked'][$l]['itemUuid'] = $attachment['itemUuid'];
								$item_array['during']['linked'][$l]['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['during']['linked'][$l]['itemVersion'] = $attachment['itemVersion'];
								//$item_array['during']['linked'][$l]['type'] = $attachment['type'];
								$item_array['during']['linked'][$l]['resourceType'] = $attachment['resourceType'];
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
       							 if(!$typeasuccess)
        							{
        					   			 $errdata['message'] = $this->flexrest->error;
           								 $this->load->view('ocf/showerror_view', $errdata);
            								return;
        							}
								
								
								foreach ($typearesponse['attachments'] as $subattachment) { // subattachments
								
									if ($subattachment['uuid'] == $attachment['attachmentUuid']) { // uuid match
										
										$item_array['during']['linked'][$l]['description'] = $subattachment['description'];
										$item_array['during']['linked'][$l]['filename'] = $subattachment['filename'];
										$item_array['during']['linked'][$l]['type'] = $subattachment['type'];
										
										
										} // uuid match
										
									}   // end subattachments
									
							}   // end type a
							
							
							
							break;
							
						case 'url':
	
							$item_array['during']['linked'][$l]['description'] = $attachment['description'];
							$item_array['during']['linked'][$l]['url'] = $attachment['url'];
							$item_array['during']['linked'][$l]['type'] = $attachment['type'];
							break;
							
							
					}
					
					
				}
				
				
			}  // end foreach attachment
			
			
			
			}  // end foreach linked
			
		}   // end if linked not empty
		
		
		
		} // end during not empty
		
		
		
if (!($post)) {  // post array not empty
		
		if(!(empty($item_array['post']['instructions']))) {
			
		$Uuid = $item_array['post']['instructions']['uuid'];
		
					
			foreach ($response['attachments'] as $attachment) {
				
				$aUuid = $attachment['uuid'];
				
				if ($Uuid == $aUuid) {
					
					
					
					switch ($attachment['type']) {
						
						case 'file':
													
							$item_array['post']['instructions']['description'] = $attachment['description'];
							$item_array['post']['instructions']['filename'] = $attachment['filename'];
							$item_array['post']['instructions']['thumbnail'] = $attachment['thumbFilename'];
							$item_array['post']['instructions']['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['post']['instructions']['description'] = $attachment['description'];
							$item_array['post']['instructions']['filename'] = $attachment['filename'];
							$item_array['post']['instructions']['type'] = $attachment['type'];
							$item_array['post']['instructions']['resourceType'] = $attachment['resourceType'];
							break;
						
						
						case 'linked-resource':
						
							
							if ($attachment['resourceType']	== 'p') {	// resource type p
											
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
								if($typeasuccess)
									{
										$item_array['post']['instructions']['pbl'] = 'False';
										if($typearesponse['collection']['uuid']== $pblCollectionUuid)
											{
												$item_array['post']['instructions']['pbl'] = 'True';
											}
									}	
												
							$item_array['post']['instructions']['description'] = $attachment['description'];
							$item_array['post']['instructions']['itemUuid'] = $attachment['itemUuid'];
							$item_array['post']['instructions']['itemVersion'] = $attachment['itemVersion'];
							$item_array['post']['instructions']['type'] = $attachment['type'];
							$item_array['post']['instructions']['resourceType'] = $attachment['resourceType'];
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['post']['instructions']['description'] = $attachment['description'];
								$item_array['post']['instructions']['itemUuid'] = $attachment['itemUuid'];
								$item_array['post']['instructions']['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['post']['instructions']['itemVersion'] = $attachment['itemVersion'];
								//$item_array['post']['instructions']['type'] = $attachment['type'];
								$item_array['post']['instructions']['resourceType'] = $attachment['resourceType'];
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
       							 if(!$typeasuccess)
        							{
        					   			 $errdata['message'] = $this->flexrest->error;
           								 $this->load->view('ocf/showerror_view', $errdata);
            								return;
        							}
								
								
								foreach ($typearesponse['attachments'] as $subattachment) { // subattachments
								
									if ($subattachment['uuid'] == $attachment['attachmentUuid']) { // uuid match
										
										$item_array['post']['instructions']['description'] = $subattachment['description'];
										$item_array['post']['instructions']['filename'] = $subattachment['filename'];
										$item_array['post']['instructions']['type'] = $subattachment['type'];
										
										
										} // uuid match
										
									}   // end subattachments
									
							}   // end type a
							
							
							
							break;
							
						case 'url':
	
							$item_array['post']['instructions']['description'] = $attachment['description'];
							$item_array['post']['instructions']['url'] = $attachment['url'];
							$item_array['post']['instructions']['type'] = $attachment['type'];
							break;
							
							
					}  // end switch
	
				} // end postUuid == aUuid
	
			}  // foreach

		
		} // instructions not empty
		
		// get infor for linked resources
		
		$l = 0; // counter variable
		
		
		if(!(empty($item_array['post']['linked']))) {
			
			foreach ($item_array['post']['linked'] as $linked) {
			
			$Uuid = $linked['uuid'];
			
			$a = 0;
			
			foreach ($response['attachments'] as $attachment) {
				
				
				$a++;
				
				$aUuid = $attachment['uuid'];
				
				
				if ($Uuid == $aUuid) {  // uuid match
				
					$l++; // increment counter
					
					switch ($attachment['type']) {
						
						case 'file':
													
							$item_array['post']['linked'][$l]['description'] = $attachment['description'];
							$item_array['post']['linked'][$l]['filename'] = $attachment['filename'];
							$item_array['post']['linked'][$l]['thumbnail'] = $attachment['thumbFilename'];
							$item_array['post']['linked'][$l]['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['post']['linked'][$l]['description'] = $attachment['description'];
							$item_array['post']['linked'][$l]['filename'] = $attachment['filename'];
							$item_array['post']['linked'][$l]['type'] = $attachment['type'];
							$item_array['post']['linked'][$l]['resourceType'] = $attachment['resourceType'];
							break;
						
						case 'linked-resource':
						
							
							if ($attachment['resourceType']	== 'p') {	// resource type p
							
							
								$item_array['post']['linked'][$l]['pbl'] = 'False';
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
									if($typeasuccess)
									{
										if($typearesponse['collection']['uuid']== $pblCollectionUuid)
										{
											$item_array['post']['linked'][$l]['pbl'] = 'True';
										}
										
									}	
							
											
								$item_array['post']['linked'][$l]['description'] = $attachment['description'];
								$item_array['post']['linked'][$l]['itemUuid'] = $attachment['itemUuid'];
								$item_array['post']['linked'][$l]['itemVersion'] = $attachment['itemVersion'];
								$item_array['post']['linked'][$l]['type'] = $attachment['type'];
								$item_array['post']['linked'][$l]['resourceType'] = $attachment['resourceType'];
								
								
								
								
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['post']['linked'][$l]['description'] = $attachment['description'];
								$item_array['post']['linked'][$l]['itemUuid'] = $attachment['itemUuid'];
								$item_array['post']['linked'][$l]['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['post']['linked'][$l]['itemVersion'] = $attachment['itemVersion'];
								//$item_array['post']['linked'][$l]['type'] = $attachment['type'];
								$item_array['post']['linked'][$l]['resourceType'] = $attachment['resourceType'];
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
       							 if(!$typeasuccess)
        							{
        					   			 $errdata['message'] = $this->flexrest->error;
           								 $this->load->view('ocf/showerror_view', $errdata);
            								return;
        							}
								
								
								foreach ($typearesponse['attachments'] as $subattachment) { // subattachments
								
									if ($subattachment['uuid'] == $attachment['attachmentUuid']) { // uuid match
										
										$item_array['post']['linked'][$l]['description'] = $subattachment['description'];
										$item_array['post']['linked'][$l]['filename'] = $subattachment['filename'];
										$item_array['post']['linked'][$l]['type'] = $subattachment['type'];
										
										
										} // uuid match
										
									}   // end subattachments
									
							}   // end type a
							
							
							
							break;
							
						case 'url':
	
							$item_array['post']['linked'][$l]['description'] = $attachment['description'];
							$item_array['post']['linked'][$l]['url'] = $attachment['url'];
							$item_array['post']['linked'][$l]['type'] = $attachment['type'];
							break;
							
							
					}
					
					
				}
				
				
			}  // end foreach attachment
			
			
			
			}  // end foreach linked
			
		}   // end if linked not empty
		
		
		
		} // end post not empty
		
		
		
		if (!($teachingTeam)) {  // teachingTeam array not empty
		
		if(!(empty($item_array['teachingTeam']['instructions']))) {
			
		$Uuid = $item_array['teachingTeam']['instructions']['uuid'];
		
					
			foreach ($response['attachments'] as $attachment) {
				
				$aUuid = $attachment['uuid'];
				
				if ($Uuid == $aUuid) {
					
					
					
					switch ($attachment['type']) {
						
						case 'file':
													
							$item_array['teachingTeam']['instructions']['description'] = $attachment['description'];
							$item_array['teachingTeam']['instructions']['filename'] = $attachment['filename'];
							$item_array['teachingTeam']['instructions']['thumbnail'] = $attachment['thumbFilename'];
							$item_array['teachingTeam']['instructions']['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['teachingTeam']['instructions']['description'] = $attachment['description'];
							$item_array['teachingTeam']['instructions']['filename'] = $attachment['filename'];
							$item_array['teachingTeam']['instructions']['type'] = $attachment['type'];
							$item_array['teachingTeam']['instructions']['resourceType'] = $attachment['resourceType'];
							break;
						
						
						case 'linked-resource':
						
							
							if ($attachment['resourceType']	== 'p') {	// resource type p
											
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
								if($typeasuccess)
									{
										$item_array['teachingTeam']['instructions']['pbl'] = 'False';
										if($typearesponse['collection']['uuid']== $pblCollectionUuid)
											{
												$item_array['teachingTeam']['instructions']['pbl'] = 'True';
											}
									}	
												
							$item_array['teachingTeam']['instructions']['description'] = $attachment['description'];
							$item_array['teachingTeam']['instructions']['itemUuid'] = $attachment['itemUuid'];
							$item_array['teachingTeam']['instructions']['itemVersion'] = $attachment['itemVersion'];
							$item_array['teachingTeam']['instructions']['type'] = $attachment['type'];
							$item_array['teachingTeam']['instructions']['resourceType'] = $attachment['resourceType'];
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['teachingTeam']['instructions']['description'] = $attachment['description'];
								$item_array['teachingTeam']['instructions']['itemUuid'] = $attachment['itemUuid'];
								$item_array['teachingTeam']['instructions']['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['teachingTeam']['instructions']['itemVersion'] = $attachment['itemVersion'];
								//$item_array['teachingTeam']['instructions']['type'] = $attachment['type'];
								$item_array['teachingTeam']['instructions']['resourceType'] = $attachment['resourceType'];
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
       							 if(!$typeasuccess)
        							{
        					   			 $errdata['message'] = $this->flexrest->error;
           								 $this->load->view('ocf/showerror_view', $errdata);
            								return;
        							}
								
								
								foreach ($typearesponse['attachments'] as $subattachment) { // subattachments
								
									if ($subattachment['uuid'] == $attachment['attachmentUuid']) { // uuid match
										
										$item_array['teachingTeam']['instructions']['description'] = $subattachment['description'];
										$item_array['teachingTeam']['instructions']['filename'] = $subattachment['filename'];
										$item_array['teachingTeam']['instructions']['type'] = $subattachment['type'];
										
										
										} // uuid match
										
									}   // end subattachments
									
							}   // end type a
							
							
							
							break;
							
						case 'url':
	
							$item_array['teachingTeam']['instructions']['description'] = $attachment['description'];
							$item_array['teachingTeam']['instructions']['url'] = $attachment['url'];
							$item_array['teachingTeam']['instructions']['type'] = $attachment['type'];
							break;
							
							
					}  // end switch
	
				} // end teachingTeamUuid == aUuid
	
			}  // foreach

		
		} // instructions not empty
		
		// get infor for linked resources
		
		$l = 0; // counter variable
		
		
		if(!(empty($item_array['teachingTeam']['linked']))) {
			
			foreach ($item_array['teachingTeam']['linked'] as $linked) {
			
			$Uuid = $linked['uuid'];
			
			$a = 0;
			
			foreach ($response['attachments'] as $attachment) {
				
				
				$a++;
				
				$aUuid = $attachment['uuid'];
				
				
				if ($Uuid == $aUuid) {  // uuid match
				
					$l++; // increment counter
					
					switch ($attachment['type']) {
						
						case 'file':
													
							$item_array['teachingTeam']['linked'][$l]['description'] = $attachment['description'];
							$item_array['teachingTeam']['linked'][$l]['filename'] = $attachment['filename'];
							$item_array['teachingTeam']['linked'][$l]['thumbnail'] = $attachment['thumbFilename'];
							$item_array['teachingTeam']['linked'][$l]['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['teachingTeam']['linked'][$l]['description'] = $attachment['description'];
							$item_array['teachingTeam']['linked'][$l]['filename'] = $attachment['filename'];
							$item_array['teachingTeam']['linked'][$l]['type'] = $attachment['type'];
							$item_array['teachingTeam']['linked'][$l]['resourceType'] = $attachment['resourceType'];
							break;
						
						case 'linked-resource':
						
							
							if ($attachment['resourceType']	== 'p') {	// resource type p
							
							
								$item_array['teachingTeam']['linked'][$l]['pbl'] = 'False';
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
									if($typeasuccess)
									{
										if($typearesponse['collection']['uuid']== $pblCollectionUuid)
										{
											$item_array['teachingTeam']['linked'][$l]['pbl'] = 'True';
										}
										
									}	
							
											
								$item_array['teachingTeam']['linked'][$l]['description'] = $attachment['description'];
								$item_array['teachingTeam']['linked'][$l]['itemUuid'] = $attachment['itemUuid'];
								$item_array['teachingTeam']['linked'][$l]['itemVersion'] = $attachment['itemVersion'];
								$item_array['teachingTeam']['linked'][$l]['type'] = $attachment['type'];
								$item_array['teachingTeam']['linked'][$l]['resourceType'] = $attachment['resourceType'];
								
								
								
								
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['teachingTeam']['linked'][$l]['description'] = $attachment['description'];
								$item_array['teachingTeam']['linked'][$l]['itemUuid'] = $attachment['itemUuid'];
								$item_array['teachingTeam']['linked'][$l]['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['teachingTeam']['linked'][$l]['itemVersion'] = $attachment['itemVersion'];
								//$item_array['teachingTeam']['linked'][$l]['type'] = $attachment['type'];
								$item_array['teachingTeam']['linked'][$l]['resourceType'] = $attachment['resourceType'];
								$typeasuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $typearesponse);
       							 if(!$typeasuccess)
        							{
        					   			 $errdata['message'] = $this->flexrest->error;
           								 $this->load->view('ocf/showerror_view', $errdata);
            								return;
        							}
								
								
								foreach ($typearesponse['attachments'] as $subattachment) { // subattachments
								
									if ($subattachment['uuid'] == $attachment['attachmentUuid']) { // uuid match
										
										$item_array['teachingTeam']['linked'][$l]['description'] = $subattachment['description'];
										$item_array['teachingTeam']['linked'][$l]['filename'] = $subattachment['filename'];
										$item_array['teachingTeam']['linked'][$l]['type'] = $subattachment['type'];
										
										
										} // uuid match
										
									}   // end subattachments
									
							}   // end type a
							
							
							
							break;
							
						case 'url':
	
							$item_array['teachingTeam']['linked'][$l]['description'] = $attachment['description'];
							$item_array['teachingTeam']['linked'][$l]['url'] = $attachment['url'];
							$item_array['teachingTeam']['linked'][$l]['type'] = $attachment['type'];
							break;
							
							
					}
					
					
				}
				
				
			}  // end foreach attachment
			
			
			
			}  // end foreach linked
			
		}   // end if linked not empty
		
		
		
		} // end teachingTeam not empty
		
		if(!(empty($item_array['activities']))) {
		
		$i = 0;
		
		foreach ($item_array['activities'] as $linked) {
			
			$i++;
			$linkedUUID = $linked['uuid'];
			
			foreach ($response['attachments'] as $attachment) {
				
				$attachmentUuid = $attachment['uuid'];
				
				if ($linkedUUID == $attachmentUuid) {
					
					$item_array['activities'][$i]['itemUuid'] = $attachment['itemUuid'];
					$item_array['activities'][$i]['itemVersion'] = $attachment['itemVersion'];
					//$item_array['activities'][$i]['title'] = $attachment['description'];
					
					
					$itemsuccess = $this->flexrest->getItem($attachment['itemUuid'], $attachment['itemVersion'], $itemresponse);
       				
					if(!$itemsuccess)
        				{
            				$errdata['message'] = $this->flexrest->error;
            				$this->load->view('ocf/showerror_view', $errdata);
            				return;
        				}
						
						
					$item_array['activities'][$i]['itemresponse'] = $itemresponse['metadata'];
					
					$xmlwrapper_name_item = 'xmlwrapper'.$attachment['itemUuid'];
			
					$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$itemresponse['metadata']), $xmlwrapper_name_item);
					
					
					//$item_array['activities'][$i]['activityType'] = $this->attachmentXml2Array($this->$xmlwrapper_name_item);
					$attachmentArray = $this->attachmentXml2Array($this->$xmlwrapper_name_item);	
					$item_array['activities'][$i]['activityType'] = isset($attachmentArray['activity_type']) ? $attachmentArray['activity_type'] : '';
					$item_array['activities'][$i]['title'] = isset($attachmentArray['activity_name']) ? $attachmentArray['activity_name'] : '';
					
					$item_array['activities'][$i]['activityParent'] = $uuid;
					$item_array['activities'][$i]['activityParentVersion'] = $version;
					$item_array['activities'][$i]['activityParentTitle'] = $response['name'];
					
					
				}
				
				
				
				
			}
			
			
			
			
			
		}
		
		} // array $item_array['activities'] not empty
	
		
		$item_array['itemTitle'] = $response['name'];
		$item_array['itemDescription'] = $response['description'];
		$item_array['itemTopic'] = $tcode;
		
		$item_array['depth'] = $depth + 1;
		
		if (isset($parentItem) && (($parentItem != '') && ($parentItem != 'missed'))) {
		
		
		$item_array['hasParent'] = 1;
		$item_array['parentItem'] = $parentItem;
		$item_array['parentVersion'] = $pversion;
		$item_array['fromdepth'] = $depth;
		$item_array['depth'] = $depth + 1;
		
		
		
		// get details of parent item
		$psuccess = $this->flexrest->getItem($parentItem, $pversion, $presponse);
		
		if(!$psuccess)
        {
            $perrdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $p);
            return;
        }
		
		$item_array['parentName'] = $presponse['name'];
		/*
		echo "<pre>";
		print_r($presponse);
		echo "</pre>";
		
		exit;
		*/
		
		}
	
		
		if($this->itemIsIntegrated($this->$xmlwrapper_name))
        {
            $item_array['activityType'] = "group";
        }

		
		$aCtr = 0;
		
		
		
		
		
		
		
		
		$item_array['thisUuid'] = $uuid;
		$item_array['thisVersion'] = $version;

		
		
		
				
		/****************************************************************************/
		
		/* Now find the UUID for this topic                                          */
		
		/****************************************************************************/
		
		
		 
		
		// Search variables
		
		/**/
		
        $q = '';
        $start = 0;
        $length = 1;

        $collections = '6704afea-e88c-4230-b277-6d9d413bfbff';  // The Topic collection
	

        $order = 'name';
        $reverse = false;

       
        $topicwhere = "/xml/item/curriculum/topics/topic/code='".$tcode."'";

        
        $topicwhere = urlencode($topicwhere);
		
		//echo "<br /><br /><br />".urldecode($topicwhere)."<br /><br />";
		
        $info = 'basic';
        $showall = false;

		$searchsuccess = $this->flexrest->search($topic, $q, $collections, $topicwhere, $start, $length, $order, $reverse, $info, $showall);


		
		
		$item_array['topicUUID'] = $topic['results'][0]['uuid'];
		$item_array['topicName'] = $topic['results'][0]['name'];
		
		
		
		
		 /*    --------------    	
		 
		 
		 if ($_SERVER['REMOTE_USER'] == 'couc0005') {
		
		
		echo "<h2>Item Array</h2>";
		echo "<pre>";
      	print_r($item_array);
		echo "</pre>";
		
		}
	
		*/


		
		
		
		//$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$sam['results'][0]['metadata']), $xmlwrapper_name);
		//$topic = $this->samXml2Array($this->$xmlwrapper_name);
		/* 
	
		
		//exit;
		
		
		      */
		
		$parentitem = array();
		$parentitem['uuid'] = $parent;
		$parentitem['version'] = $pversion;
		
	
		
		
		$data = array('item' => $item_array, 'token' => $this->generateToken($userUuid), 'privilege' => $user_role, 'parentitem'=> $parentitem);
		
		
		 /*   --------      
		       
		 
		 
		if ($_SERVER['REMOTE_USER'] == 'couc0005') {			
		echo "<pre>";
      	print_r($data);
		//print_r($_SESSION);
		echo "</pre>";
		
		}
		           
        
   
			echo "<pre>";
      	print_r($data);
		//print_r($_SESSION);
		echo "</pre>";
			*/
		#$this->load->view('ocf/lta3_itemFLO', $data);
		
	
		//echo "<pre>";
      	//print_r($data['parentitem']);
		//print_r($_SESSION);
		//echo "</pre>";
		//exit;
		
		
		
		$this->load->view('ocf/grouplistFLO', $data);
		


		
		}
	
	
	
	// checks for activity typ of "group"
	
    protected function itemIsIntegrated($itemXml) 
    { 

        $type = '/xml/item/curriculum/activities/activity/@type';
        $itemIsIntegrated = $itemXml->nodeValue($type);
        if(isset($itemIsIntegrated) && $itemIsIntegrated=='group')
            return true;
        return false;
    }
	

  /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function itemXml2Array($itemXml) 
    { 
	
	$tmp['numLinked'] = $itemXml->numNodes('/xml/item/curriculum/activities/act_items/act_item');
	
	   
	for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/act_items/act_item'); $i++) {
	
	$tmp['activities'][$i]['uuid'] = $itemXml->nodeValue('/xml/item/curriculum/activities/act_items/act_item['.$i.']/@sys_id');
	$tmp['activities'][$i]['name'] = $itemXml->nodeValue('/xml/item/curriculum/activities/act_items/act_item['.$i.']/name');
	$tmp['activities'][$i]['docondition'] = $itemXml->nodeValue('/xml/item/curriculum/activities/act_items/act_item['.$i.']/do_condition');
	
	
	// Get activity LOs
		
		for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/activity/los/lo'); $j++) {
			
			
			
			$loSysID = '/xml/item/curriculum/outcomes/activity/los/lo['.$j.']/@sys_id';
            $loName = '/xml/item/curriculum/outcomes/activity/los/lo['.$j.']/name';
            $loCode = '/xml/item/curriculum/outcomes/activity/los/lo['.$j.']/code';
			
			
			$tmp['activities'][$i]['los'][$j]['loSysID'] = $itemXml->nodeValue($loSysID);
			$tmp['activities'][$i]['los'][$j]['code'] = $itemXml->nodeValue($loCode);
			$tmp['activities'][$i]['los'][$j]['name'] = $itemXml->nodeValue($loName);
			$tmp['activities'][$i]['los'][$j]['aligned'] = 'NULL';
			
	
		}
	
	}
	
	
			
	
		
		// Get activity LOs
		
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/activity/los/lo'); $i++) {
			
			$loSysID = '/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/@sys_id';
            $loName = '/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/name';
            $loCode = '/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/code';
			
			
			$tmp['los']['lo'.$i]['loSysID'] = $itemXml->nodeValue($loSysID);
            $tmp['los']['lo'.$i]['name'] = $itemXml->nodeValue($loName);
			$tmp['los']['lo'.$i]['code'] = $itemXml->nodeValue($loCode);
			
			
	
	
			for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid'); $j++) {
			
			// $j = number of linked activities
			
	
				
				$activityUuid = $itemXml->nodeValue('/xml/item/curriculum/activities/linked_activities/uuid['.$j.']');
				
				for ($k = 1; $k <= $itemXml->numNodes('/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/aligned/act_items/act_item'); $k++) {
					
					$alignedUuid = $itemXml->nodeValue('/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/aligned/act_items/act_item['.$k.']/@sys_id');
					
	
					if($activityUuid == $alignedUuid) {
						
						$tmp['activities'][$j]['los'][$i]['aligned'] = '1';
						
					}
					
					
				}
				
			
				
			}
		
			
		
		}

		
		$tmp['teachingType'] = $itemXml->nodeValue('/xml/item/curriculum/activities/activity/teaching_types/teaching_type');
		
		// cross-topic types
		
		if($itemXml->numNodes('/xml/item/curriculum/activities/activity/cross_topic_types/cross_topic_type') > 0)
		
		{
			
			for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/activity/cross_topic_types/cross_topic_type'); $i++) {
				
				$tmp['crossTopic'][$i]['type'] = $itemXml->nodeValue('/xml/item/curriculum/activities/activity/cross_topic_types/cross_topic_type['.$i.']');
				
				}
			
			
			
		}
		
		// other tags
		
		if($itemXml->numNodes('/xml/item/curriculum/activities/activity/other_tags/other_tag') > 0)
		
		{
			
			for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/activity/other_tags/other_tag'); $i++) {
				
				$tmp['otherTags'][$i]['tag'] = $itemXml->nodeValue('/xml/item/curriculum/activities/activity/other_tags/other_tag['.$i.']');
				
				}
			
			
			
		}
		
		// skills tags
		
		if($itemXml->numNodes('/xml/item/curriculum/activities/activity/skills/skill') > 0)
		
		{
			
			for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/activity/skills/skill'); $i++) {
				
				$tmp['skills'][$i]['skill'] = $itemXml->nodeValue('/xml/item/curriculum/activities/activity/skills/skill['.$i.']');
				
				}
			
			
			
		}
		
		
			// presentations tags
		
		if($itemXml->numNodes('/xml/item/curriculum/activities/activity/common_presentations/common_presentation') > 0)
		
		{
			
			for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/activity/common_presentations/common_presentation'); $i++) {
				
				$tmp['common_presentations'][$i]['presentation'] = $itemXml->nodeValue('/xml/item/curriculum/activities/activity/common_presentations/common_presentation['.$i.']');
				
				}
			
			
			
		}
		
		
		
			// conditions tags
		
		if($itemXml->numNodes('/xml/item/curriculum/activities/activity/common_conditions/common_condition') > 0)
		
		{
			
			for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/activity/common_conditions/common_condition'); $i++) {
				
				$tmp['common_conditions'][$i]['condition'] = $itemXml->nodeValue('/xml/item/curriculum/activities/activity/common_conditions/common_condition['.$i.']');
				
				}
			
			
			
		}	
		
		
				// disciplines tags
		
		if($itemXml->numNodes('/xml/item/curriculum/activities/activity/disciplines/discipline') > 0)
		
		{
			
			for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/activity/disciplines/discipline'); $i++) {
				
				$tmp['disciplines'][$i]['discipline'] = $itemXml->nodeValue('/xml/item/curriculum/activities/activity/disciplines/discipline['.$i.']');
				
				}
			
			
			
		}	
		
		
		
		// setup arrays for instructions and resources
		
		$tmp['overall'] = array();
		$tmp['pre'] = array();
		$tmp['during'] = array();
		$tmp['post'] = array();
	
		
		
		//overall instructions and resources
		$overallInstructions = '/xml/item/curriculum/activities/activity/instructions/overall/detail/uuid';
		
		
		if ( $itemXml->nodeValue($overallInstructions) != '') {
		$tmp['overall']['instructions']['uuid'] = $itemXml->nodeValue($overallInstructions);
		}
		
		if($itemXml->numNodes('/xml/item/curriculum/activities/activity/instructions/overall/linked_resources/uuid') > 0)

		{
			
			
			$overallLinked = $itemXml->numNodes('/xml/item/curriculum/activities/activity/instructions/overall/linked_resources/uuid');
			
			if ($overallLinked >= 1 ) {
				
				for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/activity/instructions/overall/linked_resources/uuid'); $i++) {
				
				$tmp['overall']['linked'][$i]['uuid'] = $itemXml->nodeValue('/xml/item/curriculum/activities/activity/instructions/overall/linked_resources/uuid['.$i.']');
				
				}
				
			}
			
		}
		
		
		//pre instructions and resources
		$preInstructions = '/xml/item/curriculum/activities/activity/instructions/pre/detail/uuid';
		
		if($itemXml->nodeValue($preInstructions) != '') {
		
		$tmp['pre']['instructions']['uuid'] = $itemXml->nodeValue($preInstructions);
		
		}
		
		if($itemXml->numNodes('/xml/item/curriculum/activities/activity/instructions/pre/linked_resources/uuid') > 0)

		{
			
			
			$preLinked = $itemXml->numNodes('/xml/item/curriculum/activities/activity/instructions/pre/linked_resources/uuid');
			
			if ($preLinked >= 1 ) {
				
				for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/activity/instructions/pre/linked_resources/uuid'); $i++) {
				
				$tmp['pre']['linked'][$i]['uuid'] = $itemXml->nodeValue('/xml/item/curriculum/activities/activity/instructions/pre/linked_resources/uuid['.$i.']');
				
				}
				
			}
			
		}
		
		
		//during instructions and resources
		$duringInstructions = '/xml/item/curriculum/activities/activity/instructions/during/detail/uuid';
		
		if($itemXml->nodeValue($duringInstructions) != '') {
		
		$tmp['during']['instructions']['uuid'] = $itemXml->nodeValue($duringInstructions);
		
		}
		
		if($itemXml->numNodes('/xml/item/curriculum/activities/activity/instructions/during/linked_resources/uuid') > 0)

		{
			
			
			$duringLinked = $itemXml->numNodes('/xml/item/curriculum/activities/activity/instructions/during/linked_resources/uuid');
			
			if ($duringLinked >= 1 ) {
				
				for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/activity/instructions/during/linked_resources/uuid'); $i++) {
				
				
				//echo $itemXml->nodeValue('/xml/item/curriculum/activities/activity/instructions/during/linked_resources/uuid') . "<br />";
				$tmp['during']['linked'][$i]['uuid'] = $itemXml->nodeValue('/xml/item/curriculum/activities/activity/instructions/during/linked_resources/uuid['.$i.']');
				
				}
				
			}
			
		}
		
		
		
		//post instructions and resources
		$postInstructions = '/xml/item/curriculum/activities/activity/instructions/post/detail/uuid';
		
		if($itemXml->nodeValue($postInstructions) != '') {
		
		$tmp['post']['instructions']['uuid'] = $itemXml->nodeValue($postInstructions);
		
		}
		
		if($itemXml->numNodes('/xml/item/curriculum/activities/activity/instructions/post/linked_resources/uuid') > 0)

		{
			
			
			$postLinked = $itemXml->numNodes('/xml/item/curriculum/activities/activity/instructions/post/linked_resources/uuid');
			
			if ($postLinked >= 1 ) {
				
				for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/activity/instructions/post/linked_resources/uuid'); $i++) {
				
				$tmp['post']['linked'][$i]['uuid'] = $itemXml->nodeValue('/xml/item/curriculum/activities/activity/instructions/post/linked_resources/uuid['.$i.']');
				
				}
				
			}
			
		}
		
		
		
		return $tmp;
	}


  /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function itemLOsXml2Array($itemXml) 
    {
		if($itemXml->numNodes('/xml/item/curriculum/outcomes/activity/los/lo') > 0)
		
		{
			
			$tmp3 = array();
			for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/activity/los/lo'); $i++) {
				$tmp3[$i]['sysid'] = $itemXml->nodeValue('/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/@sys_id');
				$tmp3[$i]['code'] = $itemXml->nodeValue('/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/code');
				$tmp3[$i]['name'] = $itemXml->nodeValue('/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/name');
	
			}
			
			return $tmp3;
		}
		
		else
		
		{
			
			return '';
			
			
		}

	
	
	}





    protected function attachmentXml2Array($attachmentXml) 
    { 
		$tmp['activity_type'] = $attachmentXml->nodeValue('/xml/item/curriculum/activities/activity/@type');
		$tmp['activity_name'] = $attachmentXml->nodeValue('/xml/item/itembody/name');

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