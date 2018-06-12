<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Tutor extends CI_Controller {
	
	
	

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
		
		$success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('pbl/showerror_view', $errdata);
            return;
        }    
        
        $success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('pbl/showerror_view', $errdata);
            return;
        }
		
		$success_a = $this->flexrest->getItemAttachments($uuid, $version, $attachments);
        if(!$success_a)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('pbl/showerror_view', $errdata);
            return;
        }
		
		
		
		 /* 
		
		echo "<pre>";
       print_r($response);
       echo "</pre>";
	   
	   exit;
	  
	   
	  */
       //log_message('error', htmlentities($response['metadata']));
	   
	   
	   //echo htmlentities($response['metadata']);
	   
	   
	   
	   
	  
	   
	   
	   
        
		
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));
		
		if(!$this->itemIsPBL($this->xmlwrapper))
        {
            $errdata['message'] = "Item is not a PBL Case";
            $this->load->view('pbl/showerror_view', $errdata);
            return;
        }
		
		$case_array = $this->pblXml2Array($this->xmlwrapper);
			


		
		
		  $ci =& get_instance();
                    $ci->load->config('flex');
                    $institute_url = $ci->config->item('institute_url');
                    $attachments['institute_url'] = $institute_url;
		 
		 $attachments['url'] = $this->generateToken();
		 
		 
		 $attachments['uuid'] = $uuid;
		 
		 $attachments['version'] = $version;
		
/*
		 echo'<pre>';

       	print_r($attachments);

        echo'</pre>';
		


exit;		
		
 	  */	


		
		$data = array('case' => $case_array,'files' => $attachments, 'token' => $this->generateToken($userUuid));
		
		
		$this->load->view('pbl/tutorview', $data);
		
		/*
		$pdffilename = $data['case']['caseTitle'];
		$pdffilename .= " - Tutor Guide";
		
		ob_start();
		$this->load->view('pbl/tutorview', $data);
		$html = ob_get_contents();
        ob_end_clean();
		
		
		 $this->load->library('pdf/pdf_class'); 
         #$this->pdf_class->SetDisplayMode('fullpage');
         #$this->pdf_class->setFooter('{PAGENO} / {nb}');
         $this->pdf_class->WriteHTML($html);
         $this->pdf_class->Output($pdffilename,'I');

		*/
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
		$caseDescription = '/xml/item/specific/pbls/pbl/overview';
		
		
		$numTutes = '/xml/item/specific/pbls/pbl/number_sections';
		
		
		$caseKW = '/xml/item/tlf/catalogentry/catalog';
		
		$hashCtr = 0;
		
		
		$tmp['caseTitle'] = $itemXml->nodeValue($caseTitle);
		$tmp['caseDescription'] = $itemXml->nodeValue($caseDescription);
		$tmp['numTutes'] = intval($itemXml->nodeValue($numTutes));
		$tmp['caseKW'] = $itemXml->nodeValue($caseKW);
		
		
		$hashseed = substr(md5($itemXml->nodeValue($caseTitle)),0,4);
		
	
		
		
		$numTutes = intval($itemXml->nodeValue($numTutes));
		
		
		$hashCounter = 0;
		$scrCounter = 0;
		
	
		
		
		
		for ($t=1; $t <= $numTutes; $t++) {
			
		
		
		
			//$tmp['tutorial'][$t]['number'] = $t;
			
			$numAtoms = $itemXml->numNodes('/xml/item/specific/pbls/pbl/sections/section'.$t.'/atoms/atom');
			//$tmp['tutorial'][$t]['numAtoms'] = $numAtoms;
			
			
			
			
			
			
			$thistute = $t;
			$prevtute = '';
		
			
			
			
			for ($s = 1; $s <= $numAtoms; $s++) {
				
				
				
				
				$iconType = '/xml/item/specific/pbls/pbl/sections/section'.$t.'/atoms/atom['.$s.']/@icon_type';
				$who_for = '/xml/item/specific/pbls/pbl/sections/section'.$t.'/atoms/atom['.$s.']/@who_for';
				$atomIndex = '/xml/item/specific/pbls/pbl/sections/section'.$t.'/atoms/atom['.$s.']/@index';
				$atomName = '/xml/item/specific/pbls/pbl/sections/section'.$t.'/atoms/atom['.$s.']/name';
				$textNode = '/xml/item/specific/pbls/pbl/sections/section'.$t.'/atoms/atom['.$s.']/text';
				
				
				$icon = $itemXml->nodeValue($iconType);
				$usage = $itemXml->nodeValue($who_for);
				$screenIndex = $itemXml->nodeValue($atomIndex);
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
				
				
				if ($usage === 'Student') {
					
					
					
					
					//echo $thistute;
					
					//echo $prevtute;
					
					if ($thistute != $prevtute) { $scrCounter = 0; }		
					
					$scrCounter++;
					$hashCounter++;
					
					$tmp['screens'][$hashCounter]['thistute'] = $thistute;
					
					$tmp['screens'][$hashCounter]['prevtute'] = $prevtute;
					
					$tmp['screens'][$hashCounter]['tutorial'] = $t;
					
					$tmp['screens'][$hashCounter]['screenNumber'] = $scrCounter;
					
					
					if ($hashCounter < 10) { $idhash = $hashseed."0".$hashCounter; } else { $idhash = $hashseed.$hashCounter; }
					$tmp['screens'][$hashCounter]['idhash'] = $idhash;
					
					$tmp['screens'][$hashCounter]['use'] = $usage;
					$tmp['screens'][$hashCounter]['text'] = $screenText;
					$tmp['screens'][$hashCounter]['icon'] = $iconfile;
					$tmp['screens'][$hashCounter]['screenIndex'] = $screenIndex;
					$tmp['screens'][$hashCounter]['iconName'] = $iconName;
					$tmp['screens'][$hashCounter]['screenName'] = $screenName;
					
					
					
					$prevtute = $thistute;
					
				
				}  // end of standard text
				
				
					if ($usage === 'Tutor') {
						
					$hashCounter++;
					
					
						
					$tmp['screens'][$hashCounter]['thistute'] = $thistute;
					
					$tmp['screens'][$hashCounter]['prevtute'] = $prevtute;
					
					$tmp['screens'][$hashCounter]['tutorial'] = $t;
					
					$tmp['screens'][$hashCounter]['use'] = $usage;
					$tmp['screens'][$hashCounter]['text'] = $screenText;
					$tmp['screens'][$hashCounter]['icon'] = $iconfile;
					$tmp['screens'][$hashCounter]['screenIndex'] = $screenIndex;
					$tmp['screens'][$hashCounter]['iconName'] = $iconName;
					$tmp['screens'][$hashCounter]['screenName'] = $screenName;
					
					//$prevtute = $thistute;
					
				
				}  // end of tutor text
			
			
			
			
			
			
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
        //$username = $ci->config->item('sam_shared_secret_username');
		$username = "couc0005";
        $sharedSecretId = $ci->config->item('sam_shared_secret_id');
        $sharedSecretValue = $ci->config->item('sam_shared_secret_value');
		
		//echo "URL encode username = ". $urlencode ($username) ;
		
		//exit;
        
		$time = mktime() . '000';
		/*return urlencode ($username) . ':' . urlencode($sharedSecretId) . ':' .  $time . ':' . 
                        urlencode(base64_encode (pack ('H*', md5 ($username . $sharedSecretId . $time . $sharedSecretValue))));*/
		
		
		
		return urlencode($username) . ':' . urlencode($sharedSecretId) . ':' .  $time . ':' . 
                        urlencode(base64_encode (pack ('H*', md5 ($username . $sharedSecretId . $time . $sharedSecretValue))));
						
	}
        
	
	
}

/* End of file startup.php */