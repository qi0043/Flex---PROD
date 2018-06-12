<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activityflo1 extends CI_Controller {
 
	public function index($uuid='missed', $version='missed', $taa='missed')
	{
		
		
		session_start();

		$this->load->model('ocf/ocf_model');
		#check down time before authentication through FLEX
		
		/* */
		
		$down_notice = false;
		$down_notice = $this->ocf_model->db_chk_notice();
		if($down_notice != false)
		{
			#$this->error_info($down_notice['message']);
			if ($down_notice['message'] == '')
				$down_notice['message'] = 'Online Curriculum Framework is temporarily unavailable, please try again later.';
			#echo $down_notice['message'];
			$errdata['message'] = $down_notice['message'];
			$errdata['heading'] = "Notice";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			exit;
		}



		
		#$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";
        
        if($this->validate_params($uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
		
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		$ci =& get_instance();
		$ci->load->config('flex');
		$collections = $ci->config->item('topic_information_collection');
		$pblCollectionUuid = $ci->config->item('pbl_collection');
		
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
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
         //parent activity uuid
		$taasuccess = $this->flexrest->getItem($taa, $version, $taaresponse);
        if(!$taasuccess)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
		
		
		
		
		$xmlwrapper_name = 'xmlwrapper'.'activity';
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);

		if(!$this->itemIsActivity($this->$xmlwrapper_name))
        {
            $errdata['message'] = "Item is not activity";
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
				
		$item_array = $this->itemXml2Array($this->$xmlwrapper_name);
		
		$item_array['pblCase'] = "False";
		$pblstring = "PBL Case";
		
		if(isset($item_array['crossTopic']))
		{
			foreach ($item_array['crossTopic'] as $crosstopic) 
			{
			
				if (in_array($pblstring, $crosstopic)) 
				{
					$isPBL = true;
					$item_array['pblCase'] = "True";
				}
			}
		}
		
		
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
							$item_array['overall']['instructions']['thumbnail'] = isset($attachment['thumbFilename'])?$attachment['thumbFilename']:'';
							$item_array['overall']['instructions']['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['overall']['instructions']['description'] = $attachment['description'];
							$item_array['overall']['instructions']['filename'] = $attachment['filename'];
							$item_array['overall']['instructions']['type'] = $attachment['type'];
							$item_array['overall']['instructions']['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
							$item_array['overall']['instructions']['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['overall']['instructions']['description'] = $attachment['description'];
								$item_array['overall']['instructions']['itemUuid'] = $attachment['itemUuid'];
								$item_array['overall']['instructions']['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['overall']['instructions']['itemVersion'] = $attachment['itemVersion'];
								//$item_array['overall']['instructions']['type'] = $attachment['type'];
								$item_array['overall']['instructions']['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
							$item_array['overall']['linked'][$l]['thumbnail'] = isset($attachment['thumbFilename'])?$attachment['thumbFilename']:'';
							$item_array['overall']['linked'][$l]['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['overall']['linked'][$l]['description'] = $attachment['description'];
							$item_array['overall']['linked'][$l]['filename'] = $attachment['filename'];
							$item_array['overall']['linked'][$l]['type'] = $attachment['type'];
							$item_array['overall']['linked'][$l]['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
								$item_array['overall']['linked'][$l]['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
								
								
								
								
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['overall']['linked'][$l]['description'] = $attachment['description'];
								$item_array['overall']['linked'][$l]['itemUuid'] = $attachment['itemUuid'];
								$item_array['overall']['linked'][$l]['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['overall']['linked'][$l]['itemVersion'] = $attachment['itemVersion'];
								//$item_array['overall']['linked'][$l]['type'] = $attachment['type'];
								$item_array['overall']['linked'][$l]['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
							$item_array['pre']['instructions']['thumbnail'] = isset($attachment['thumbFilename'])?$attachment['thumbFilename']:'';
							$item_array['pre']['instructions']['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['pre']['instructions']['description'] = $attachment['description'];
							$item_array['pre']['instructions']['filename'] = $attachment['filename'];
							$item_array['pre']['instructions']['type'] = $attachment['type'];
							$item_array['pre']['instructions']['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
							$item_array['pre']['instructions']['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['pre']['instructions']['description'] = $attachment['description'];
								$item_array['pre']['instructions']['itemUuid'] = $attachment['itemUuid'];
								$item_array['pre']['instructions']['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['pre']['instructions']['itemVersion'] = $attachment['itemVersion'];
								//$item_array['pre']['instructions']['type'] = $attachment['type'];
								$item_array['pre']['instructions']['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
							$item_array['pre']['linked'][$l]['thumbnail'] = isset($attachment['thumbFilename'])?$attachment['thumbFilename']:'';
							$item_array['pre']['linked'][$l]['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['pre']['linked'][$l]['description'] = $attachment['description'];
							$item_array['pre']['linked'][$l]['filename'] = $attachment['filename'];
							$item_array['pre']['linked'][$l]['type'] = $attachment['type'];
							$item_array['pre']['linked'][$l]['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
								$item_array['pre']['linked'][$l]['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
								
								
								
								
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['pre']['linked'][$l]['description'] = $attachment['description'];
								$item_array['pre']['linked'][$l]['itemUuid'] = $attachment['itemUuid'];
								$item_array['pre']['linked'][$l]['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['pre']['linked'][$l]['itemVersion'] = $attachment['itemVersion'];
								//$item_array['pre']['linked'][$l]['type'] = $attachment['type'];
								$item_array['pre']['linked'][$l]['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
							$item_array['during']['instructions']['thumbnail'] = isset($attachment['thumbFilename'])?$attachment['thumbFilename']:'';
							$item_array['during']['instructions']['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['during']['instructions']['description'] = $attachment['description'];
							$item_array['during']['instructions']['filename'] = $attachment['filename'];
							$item_array['during']['instructions']['type'] = $attachment['type'];
							$item_array['during']['instructions']['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
							$item_array['during']['instructions']['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['during']['instructions']['description'] = $attachment['description'];
								$item_array['during']['instructions']['itemUuid'] = $attachment['itemUuid'];
								$item_array['during']['instructions']['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['during']['instructions']['itemVersion'] = $attachment['itemVersion'];
								//$item_array['during']['instructions']['type'] = $attachment['type'];
								$item_array['during']['instructions']['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
							$item_array['during']['linked'][$l]['thumbnail'] = isset($attachment['thumbFilename'])?$attachment['thumbFilename']:'';
							$item_array['during']['linked'][$l]['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['during']['linked'][$l]['description'] = $attachment['description'];
							$item_array['during']['linked'][$l]['filename'] = $attachment['filename'];
							$item_array['during']['linked'][$l]['type'] = $attachment['type'];
							$item_array['during']['linked'][$l]['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
								$item_array['during']['linked'][$l]['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
								
								
								
								
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['during']['linked'][$l]['description'] = $attachment['description'];
								$item_array['during']['linked'][$l]['itemUuid'] = $attachment['itemUuid'];
								$item_array['during']['linked'][$l]['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['during']['linked'][$l]['itemVersion'] = $attachment['itemVersion'];
								//$item_array['during']['linked'][$l]['type'] = $attachment['type'];
								$item_array['during']['linked'][$l]['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
							$item_array['post']['instructions']['thumbnail'] = isset($attachment['thumbFilename'])?$attachment['thumbFilename']:'';
							$item_array['post']['instructions']['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['post']['instructions']['description'] = $attachment['description'];
							$item_array['post']['instructions']['filename'] = $attachment['filename'];
							$item_array['post']['instructions']['type'] = $attachment['type'];
							$item_array['post']['instructions']['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
							$item_array['post']['instructions']['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['post']['instructions']['description'] = $attachment['description'];
								$item_array['post']['instructions']['itemUuid'] = $attachment['itemUuid'];
								$item_array['post']['instructions']['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['post']['instructions']['itemVersion'] = $attachment['itemVersion'];
								//$item_array['post']['instructions']['type'] = $attachment['type'];
								$item_array['post']['instructions']['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
							$item_array['post']['linked'][$l]['thumbnail'] = isset($attachment['thumbFilename'])?$attachment['thumbFilename']:'';
							$item_array['post']['linked'][$l]['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['post']['linked'][$l]['description'] = $attachment['description'];
							$item_array['post']['linked'][$l]['filename'] = $attachment['filename'];
							$item_array['post']['linked'][$l]['type'] = $attachment['type'];
							$item_array['post']['linked'][$l]['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
								$item_array['post']['linked'][$l]['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
								
								
								
								
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['post']['linked'][$l]['description'] = $attachment['description'];
								$item_array['post']['linked'][$l]['itemUuid'] = $attachment['itemUuid'];
								$item_array['post']['linked'][$l]['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['post']['linked'][$l]['itemVersion'] = $attachment['itemVersion'];
								//$item_array['post']['linked'][$l]['type'] = $attachment['type'];
								$item_array['post']['linked'][$l]['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
							$item_array['teachingTeam']['instructions']['thumbnail'] = isset($attachment['thumbFilename'])?$attachment['thumbFilename']:'';
							$item_array['teachingTeam']['instructions']['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['teachingTeam']['instructions']['description'] = $attachment['description'];
							$item_array['teachingTeam']['instructions']['filename'] = $attachment['filename'];
							$item_array['teachingTeam']['instructions']['type'] = $attachment['type'];
							$item_array['teachingTeam']['instructions']['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
							$item_array['teachingTeam']['instructions']['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['teachingTeam']['instructions']['description'] = $attachment['description'];
								$item_array['teachingTeam']['instructions']['itemUuid'] = $attachment['itemUuid'];
								$item_array['teachingTeam']['instructions']['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['teachingTeam']['instructions']['itemVersion'] = $attachment['itemVersion'];
								//$item_array['teachingTeam']['instructions']['type'] = $attachment['type'];
								$item_array['teachingTeam']['instructions']['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
							$item_array['teachingTeam']['linked'][$l]['thumbnail'] = isset($attachment['thumbFilename'])?$attachment['thumbFilename']:'';
							$item_array['teachingTeam']['linked'][$l]['type'] = $attachment['type'];
							break;

						case 'htmlpage':
				
							
							$item_array['teachingTeam']['linked'][$l]['description'] = $attachment['description'];
							$item_array['teachingTeam']['linked'][$l]['filename'] = $attachment['filename'];
							$item_array['teachingTeam']['linked'][$l]['type'] = $attachment['type'];
							$item_array['teachingTeam']['linked'][$l]['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
								$item_array['teachingTeam']['linked'][$l]['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
								
								
								
								
								
								}  // end type p
								
								
							if ($attachment['resourceType']	== 'a') {	// resource type a				
								$item_array['teachingTeam']['linked'][$l]['description'] = $attachment['description'];
								$item_array['teachingTeam']['linked'][$l]['itemUuid'] = $attachment['itemUuid'];
								$item_array['teachingTeam']['linked'][$l]['attachmentUuid'] = $attachment['attachmentUuid'];
								$item_array['teachingTeam']['linked'][$l]['itemVersion'] = $attachment['itemVersion'];
								//$item_array['teachingTeam']['linked'][$l]['type'] = $attachment['type'];
								$item_array['teachingTeam']['linked'][$l]['resourceType'] = isset($attachment['resourceType'])?$attachment['resourceType']:'';
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
		
		
		
		
		/****************************************************************************/		
		/*        CHECK THAT ITEM IS AN ACTIVITY                                    */		
		/****************************************************************************/
		
		
		if($this->itemIsActivity($this->$xmlwrapper_name))
        {
            $item_array['activityType'] = "Activity";
        }

		$tcode = $item_array['itemTopic'];
		
		/****************************************************************************/
		
		/* Now find the UUID for this topic                                         */
		
		/****************************************************************************/
			
		// Search variables
		
		/*	*/
		
        $q = '';
        $start = 0;
        $length = 1;

       // $collections = '6704afea-e88c-4230-b277-6d9d413bfbff';  // The Topic collection
	

        $order = 'name';
        $reverse = false;

       
        $topicwhere = "/xml/item/curriculum/topics/topic/code='".$tcode."'";

        
        $topicwhere = urlencode($topicwhere);
		
		//echo "<br /><br /><br />".urldecode($topicwhere)."<br /><br />";
		
        $info = 'basic';
        $showall = false;

		$searchsuccess = $this->flexrest->search($topic, $q, $collections, $topicwhere, $start, $length, $order, $reverse, $info, $showall);

		
		
		$item_array['thisUuid'] = $uuid;
		$item_array['thisVersion'] = $version;
		
		
		$item_array['topicUUID'] = isset($topic['results'][0]['uuid'])?$topic['results'][0]['uuid']:'';
		$item_array['topicName'] = isset($topic['results'][0]['name'])?$topic['results'][0]['name']:'';
		
		$item_array['parentTopic'] = $taaresponse['name'];
		$item_array['parentUUID'] = $taaresponse['uuid'];
		
		// related items
		
		$ctr = 0;
		$other_ctr = 0;
		
		
		if(!(empty($taaresponse['attachments']))) {
		foreach ($taaresponse['attachments'] as $relatedItem) {
			if($relatedItem['type']=='linked-resource')
			{
				 $ctr++;
				 $item_array['relatedItem'][$ctr]['type'] = $relatedItem['type'];
				 $item_array['relatedItem'][$ctr]['title'] = $relatedItem['description'];
				 $item_array['relatedItem'][$ctr]['itemUuid'] = $relatedItem['itemUuid'];
				 $item_array['relatedItem'][$ctr]['sysUuid'] = $relatedItem['uuid'];
				 $item_array['relatedItem'][$ctr]['itemVersion'] = $relatedItem['itemVersion'];
				 
				 if ($uuid == $relatedItem['itemUuid']) {
					 $item_array['sysUUID'] = $item_array['relatedItem'][$ctr]['sysUuid'];
				 }
			}
			elseif($relatedItem['type']=='htmlpage')
			{
				$other_ctr++;
				$item_array['related_html_item'][$ctr]['type'] = $relatedItem['type'];
				$item_array['related_html_item'][$ctr]['title'] = $relatedItem['description'];
				$item_array['related_html_item'][$ctr]['sysUuid'] = $relatedItem['uuid'];
				$item_array['related_html_item'][$ctr]['preview'] = $relatedItem['preview'];
				$item_array['related_html_item'][$ctr]['restricted'] = $relatedItem['restricted'];
				$item_array['related_html_item'][$ctr]['size'] = $relatedItem['size'];
				$item_array['related_html_item'][$ctr]['filename'] = $relatedItem['filename'];
				//$item_array['related_html_item'][$ctr]['lins'] = $relatedItem['links'];

			}
		}
		
		} // not empty $taaresponse['attachments']
		
		
		 // $sysID = $item_array['sysUUID'];
			
			if (isset($item_array['sysUUID'])) {
			
			$wrapper  = 'xmlwrapper'. $item_array['sysUUID'] . 'lo';
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$taaresponse['metadata']), $wrapper);
			
			$lo_array = $this->loXml2Array($this->$wrapper,$item_array['sysUUID']);
			
			} else {
				
				$lo_array = array();
			}
			
			
			$data = array('item' => $item_array, 'activity_los' => $activitylos_array, 'los' => $lo_array, 'token' => $this->generateToken($userUuid), 'privilege' => $user_role, 'fan' => $_SESSION['userinfo']['fan']);

		
		/*    ---------------    	 


		if($_SESSION['userinfo']['fan'] == 'couc0005') {
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		
		exit;
		}
	 
		*/ 
		
				 
		
		
				
		$this->load->view('ocf/activity_itemFLOsingle', $data);
	 
} 



/**********************************/
/*       FUNCTIONS                */
/**********************************/



    /**
     * Check whether the item has a type of Topic Information
     *
     * @param xmlwrapper $itemXml
     */
    protected function itemIsActivity($itemXml) 
    { 
        $type = '/xml/item/curriculum/activities/activity/@type';
        $itemIsActivity = $itemXml->nodeValue($type);
        if(isset($itemIsActivity) && $itemIsActivity=='activity')
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

		
				
	
		
		$itemTitle = '/xml/item/curriculum/activities/activity/name';
		$itemDescription = '/xml/item/itembody/description';
		$itemTopic = '/xml/item/curriculum/topics/topic/code';
		$itemOCFid = '/xml/item/restrictions/management/manage/@ocf_id';
		
		
		
		$hideLink = '/xml/item/testing/test1';
		
		
		
		
		$tmp['itemTitle'] = $itemXml->nodeValue($itemTitle);
		$tmp['itemDescription'] = $itemXml->nodeValue($itemDescription);
		$tmp['itemTopic'] = $itemXml->nodeValue($itemTopic);
		$tmp['itemOCFid'] = $itemXml->nodeValue($itemOCFid);
		
		
		if($itemXml->nodeValue($hideLink) == '1') {
			$tmp['hideLink'] = $itemXml->nodeValue($hideLink);
		} else {
			$tmp['hideLink'] = '0';
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
		$tmp['teachingTeam'] = array();
	
		
		
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
		
			//teaching team instructions and resources
		$teachingTeamInstructions = '/xml/item/curriculum/activities/activity/teaching_team/detail/uuid';
		
		if($itemXml->nodeValue($teachingTeamInstructions) != '') {
		
		$tmp['teachingTeam']['instructions']['uuid'] = $itemXml->nodeValue($teachingTeamInstructions);
		
		}
		
		if($itemXml->numNodes('/xml/item/curriculum/activities/activity/teaching_team/linked_resources/uuid') > 0)

		{
			
			
			$teachingTeamLinked = $itemXml->numNodes('/xml/item/curriculum/activities/activity/teaching_team/linked_resources/uuid');
			
			if ($teachingTeamLinked >= 1 ) {
				
				for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/activity/teaching_team/linked_resources/uuid'); $i++) {
				
				$tmp['teachingTeam']['linked'][$i]['uuid'] = $itemXml->nodeValue('/xml/item/curriculum/activities/activity/teaching_team/linked_resources/uuid['.$i.']');
				
				}
				
			}
			
		}
		
		
	// tags
	
	// teaching type
	
	
	
	
		/*for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo'); $i++) {
			
			$loSysID = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/@sys_id';
            $loName = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/name';
            $loCode = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/code';
	
			$tmp['topic']['los']['lo'.$i]['loSysID'] = $itemXml->nodeValue($loSysID);
            $tmp['topic']['los']['lo'.$i]['name'] = $itemXml->nodeValue($loName);
			$tmp['topic']['los']['lo'.$i]['code'] = $itemXml->nodeValue($loCode);
			
		}*/ // end of $i loop

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



	protected function loXml2Array($itemXml,$receivedID) 
    { 
		$numApply = 0;
		
		if($itemXml->numNodes('/xml/item/curriculum/outcomes/activity/los/lo') > 0)
		{
			$tmp2 = array();
			for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/activity/los/lo'); $i++) {
				$tmp2['numberLOs'] = $itemXml->numNodes('/xml/item/curriculum/outcomes/activity/los/lo') ;			
				$numApply = 0;
	
				for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/aligned/act_items/act_item'); $j++) 			{
					$sysID = '/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/aligned/act_items/act_item['.$j.']/@sys_id';
					
					if( $receivedID === $itemXml->nodeValue($sysID)) { //The item matches this item
				
						$numApply++;
						$loName = '/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/name';
						$loCode = '/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/code';		
						#$taa['los'][$i]['matching'] = "Y";
					
						$tmp2['los'][$i]['name'] = $itemXml->nodeValue($loName) ;
						$tmp2['los'][$i]['code'] = $itemXml->nodeValue($loCode) ;
		
						#$taa['lo'][$i]['code'] = $itemXml->nodeValue($loCode);					   						   
					 }
					$tmp2['numberApplicable'] = $numApply;
				}
	
			} // end of $i loop

			return $tmp2;
		}
		else
		{
			return '';
		}
		
		
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