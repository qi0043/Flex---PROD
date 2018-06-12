<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller to show SAM in HTML or PDF format
 */
class Showsam extends CI_Controller 
{
    
    /**
     * Display a SAM in HTML or PDF format
     *
     * @param string $format, html/pdf
     * @param array $uuid, item UUID
     * @param array $version, item Version
     */
    public function index($format='html', $uuid='missed', $version='missed')
    {
        #$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";
        
        if($this->validate_params($format, $uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
		
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
        
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }    
        
        $success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        
        #echo "<pre>";
        #print_r($response);
        #echo "</pre>";
        #log_message('error', htmlentities($response['metadata']));
        
        $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));
        
        if(!$this->itemIsSam($this->xmlwrapper))
        {
            $errdata['message'] = "Item is not SAM";
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
       
        $sam_array = $this->samXml2Array($this->xmlwrapper);
        
        $sam_array['status'] = $response['status'];
		
        
        #echo'<pre>';
        #echo 'response================<br>';
        #print_r($response);
	#echo 'sam-array===============<br>';
       	#print_r($sam_array);
	#echo 'responsemetadata========<br>';
        
        #echo (string)$response['metadata'];
        #echo'</pre><br><hr/>';
        
        /*
        if($this->xmlwrapper->num_node_notfound > 7)
        {
            $errdata['message'] = "Metadata missing";
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        */
        $data = array('sam_array' => $sam_array);
		
        
        if($format=='html')
        {
            $data['sam_array']['format'] = 'html';
			
            $this->load->view('sam/showsam_view', $data);
        }
        else if($format=='pdf')
        {
            $data['sam_array']['format'] = 'pdf';
            $data['sam_array']['uuid'] = $uuid; #item uuid
            $data['sam_array']['version'] = $version; #item version number
			
            /*if($data['sam_array']['metadata']['approved'] == 'Yes' && isset($response['attachments']))
            {
		    //if a = b, means this attachment is the signature image
		    if($response['attachments'][0]['uuid'] == $data['sam_array']['metadata']['signature_Uuid'])
                    { //attachment uuid
                        $data['sam_array']['attachments_name'] = $response['attachments'][0]['filename']; //attachment file name
                        #generate a token for OAuth user to be able to see digital signature for 30 mintues.
                        $data['sam_array']['url'] = $this->generateToken();
		    }
            }*/
            
            if(isset($data['sam_array']['metadata']['availability_name']))
                $pdffilename = 'SAM ' . $data['sam_array']['metadata']['availability_name'] . " ";
            else
                $pdffilename = 'SAM ';
            
            $pdffilename .= date("Y-m-d");
            
            ob_start();
            $this->load->view('sam/showsam_view', $data);
            $html = ob_get_contents();
            ob_end_clean();

            //mPDF generates lots of PHP ERR logs, disable the logs here.
            #$errorlevel=error_reporting();
            #error_reporting(0);
            //See class MY_Exceptions
            #$_SESSION['GEN_PHPERR_LOGS'] = false;
            
            $this->load->library('pdf/pdf_class'); 
            #$this->pdf_class->SetDisplayMode('fullpage');
            $this->pdf_class->setFooter('{PAGENO} / {nb}');
            $this->pdf_class->WriteHTML($html);
            $this->pdf_class->Output($pdffilename, 'I');
            
            #error_reporting($errorlevel);
            #$_SESSION['GEN_PHPERR_LOGS'] = true;
        }
		
		
        
       
    }
    
    /**
     * Check whether the item has a type of SAM
     *
     * @param xmlwrapper $itemXml
     */
    protected function itemIsSam($itemXml) 
    { 

        $type = '/xml/item/uni/topic/@type';
        $itemissam = $itemXml->nodeValue($type);
        if(isset($itemissam) && $itemissam=='SAM')
            return true;
        return false;
    }
    
    /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function samXml2Array($itemXml) 
    { 

        #$type = '/xml/item/uni/topic/@type';
    
        $topicCode = '/xml/item/uni/topic/used_in/topics/code';
        $topicTitle = '/xml/item/uni/topic/used_in/topics/title';
        $topicUnits = '/xml/item/uni/topic/used_in/topics/units';
        $topicSchool = '/xml/item/uni/topic/used_in/topics/school';
		
		$work_load = '/xml/item/uni/topic/used_in/topics/workload';
		
        $approval = '/xml/item/uni/topic/assessment/distributed';
        $grad_quals = '/xml/item/uni/topic/specs/grad_quals';
		
        #$samsArray['metadata']['type'] = $itemXml->nodeValue($type);
		
		$approved = '/xml/item/uni/topic/assessment/approval/approved'; #boolean yes/no
		$approvalDate = '/xml/item/uni/topic/assessment/approval/date';
		$approvalPerson = '/xml/item/uni/topic/assessment/approval/by/person';
                
        $attachment_uuid = '/xml/item/uni/topic/attachments/attachment_upload';
	$availability_name = '/xml/item/itembody/name';
		
		
        $samsArray['metadata']['tcode'] = $itemXml->nodeValue($topicCode);
        $samsArray['metadata']['topicTitle'] = $itemXml->nodeValue($topicTitle);
        $samsArray['metadata']['topicUnits'] = $itemXml->nodeValue($topicUnits);
        $samsArray['metadata']['topicSchool'] = trim($itemXml->nodeValue($topicSchool));

        $samsArray['metadata']['approval'] = $itemXml->nodeValue($approval);
        $samsArray['metadata']['grad_quals'] = $itemXml->nodeValue($grad_quals);
		
	$samsArray['metadata']['signature_Uuid'] = $itemXml->nodeValue($attachment_uuid);
	
        $samsArray['metadata']['work_load'] = $itemXml->nodeValue($work_load);
	$samsArray['metadata']['approvalDate'] = $itemXml->nodeValue($approvalDate);
	$samsArray['metadata']['approvalPerson'] = $itemXml->nodeValue($approvalPerson);
	$samsArray['metadata']['approved'] = $itemXml->nodeValue($approved);
        
	$samsArray['metadata']['availability_name'] = $itemXml->nodeValue($availability_name);	
		
                #$samsArray['metadata']['attachment_uuid'] = $itemXml->nodeValue($attachment_uuid);
                #log_message('error', 'attachment_uuid: '.$samsArray['metadata']['attachment_uuid']);
       
        // get availabilities information
		
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/uni/topic/used_in/availabilities/availability'); $j++) 
        {

            $avYear = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/year';
            $avDuration = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/duration';
            $avLocation = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/location';
            $avCoordName = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/coordinators/coordinators/coordinator/name';
            $avCoordPhone = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/coordinators/coordinators/coordinator/phone';
            $avCoordLocation = '/xml/item/uni/topic/used_in/availabilities/availability['.$j.']/coordinators/coordinators/coordinator/location';

            $samsArray['metadata']['availability'][$j]['avYear'] = $itemXml->nodeValue($avYear);
            $samsArray['metadata']['availability'][$j]['avDuration'] = $itemXml->nodeValue($avDuration);
            $samsArray['metadata']['availability'][$j]['avLocation'] = $itemXml->nodeValue($avLocation);
            $samsArray['metadata']['availability'][$j]['avCoordName'] = $itemXml->nodeValue($avCoordName);
            $samsArray['metadata']['availability'][$j]['avCoordPhone'] = $itemXml->nodeValue($avCoordPhone);
            $samsArray['metadata']['availability'][$j]['avCoordLocation'] = $itemXml->nodeValue($avCoordLocation);
        }
		
		
        // assessable tasks
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/uni/topic/outcomes/outcome'); $j++) 
        {
            $name = '/xml/item/uni/topic/outcomes/outcome['.$j.']/name';
            $samsArray['metadata']['topicalign'][$j]['name'] = $itemXml->nodeValue($name);

            for ($k = 1; $k <= $itemXml->numNodes('/xml/item/uni/topic/outcomes/outcome['.$j.']/assessments/assessment'); $k++) 
            {
                    $assessment = '/xml/item/uni/topic/outcomes/outcome['.$j.']/assessments/assessment['.$k.']/name';
                    //$samsArray['metadata']['topicalign'][$j]['assessment'][$k] ='text'; 
                    $samsArray['metadata']['topicalign'][$j]['assessment'][$k] = $itemXml->nodeValue($assessment); 
            }

                //$samsArray['metadata']['topicalign'][$j]['numItems'] = [$k]; 
        }

        // graduate qualities
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/uni/course/grad_attributes/grad_attribute'); $j++) 
        {

            $name = '/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/name';
            $code = '/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/code';
            $samsArray['metadata']['gradattribute'][$j]['name'] = $itemXml->nodeValue($name);
            $samsArray['metadata']['gradattribute'][$j]['code'] = $itemXml->nodeValue($code);

            for ($k = 1; $k <= $itemXml->numNodes('/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/assessments/assessment'); $k++) {

                    $assessment = '/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/assessments/assessment['.$k.']/name';
                    //$samsArray['metadata']['topicalign'][$j]['assessment'][$k] ='text'; 
                    $samsArray['metadata']['gradattribute'][$j]['assessment'][$k] = $itemXml->nodeValue($assessment); 
            }
                //$samsArray['metadata']['topicalign'][$j]['numItems'] = [$k]; 
        }

        // topic alignment
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/uni/topic/assessment/items/item'); $j++) 
        {
            $name = '/xml/item/uni/topic/assessment/items/item['.$j.']/name';
			$format = '/xml/item/uni/topic/assessment/items/item['.$j.']/format';
			#$format=htmlentities('/xml/item/uni/topic/assessment/items/item['.$j.']/format');  
            $proportion = '/xml/item/uni/topic/assessment/items/item['.$j.']/proportion';
            $deadline = '/xml/item/uni/topic/assessment/items/item['.$j.']/deadline';
            $penalties = '/xml/item/uni/topic/assessment/items/item['.$j.']/penalties';
            $return = '/xml/item/uni/topic/assessment/items/item['.$j.']/return_date';

            $samsArray['metadata']['assessment'][$j]['name'] = $itemXml->nodeValue($name);
			$samsArray['metadata']['assessment'][$j]['format'] = $itemXml->nodeValue($format);
            $samsArray['metadata']['assessment'][$j]['proportion'] = $itemXml->nodeValue($proportion);
            $samsArray['metadata']['assessment'][$j]['deadline'] = $itemXml->nodeValue($deadline);
            $samsArray['metadata']['assessment'][$j]['penalties'] = $itemXml->nodeValue($penalties);
            $samsArray['metadata']['assessment'][$j]['return'] = $itemXml->nodeValue($return);
        }


		$scaling = '/xml/item/uni/topic/assessment/scaling/used';
		$scalingDetail = '/xml/item/uni/topic/assessment/scaling/detail';
        $resubmissionPermitted = '/xml/item/uni/topic/assessment/resubmission/permitted';
        $resubmissionDetail = '/xml/item/uni/topic/assessment/resubmission/detail';

        $academicIntegrity = '/xml/item/uni/topic/assessment/integrity';

        $pass = '/xml/item/uni/topic/assessment/pass';

        $consideration = '/xml/item/uni/topic/assessment/special_contact';

        $samsArray['metadata']['pass'] = $itemXml->nodeValue($pass);
        $samsArray['metadata']['consideration'] = $itemXml->nodeValue($consideration);
		$samsArray['metadata']['scaling'] = $itemXml->nodeValue($scaling);
		$samsArray['metadata']['scalingDetail'] = $itemXml->nodeValue($scalingDetail);
        $samsArray['metadata']['resubmissionPermitted'] = $itemXml->nodeValue($resubmissionPermitted);
        
        if(strnatcasecmp($samsArray['metadata']['resubmissionPermitted'], 'Yes') == 0)
            $samsArray['metadata']['resubmissionDetail'] = $itemXml->nodeValue($resubmissionDetail);
        else
            $samsArray['metadata']['resubmissionDetail'] = '';

        $samsArray['metadata']['academicIntegrity'] = $itemXml->nodeValue($academicIntegrity);		

        return $samsArray;

    }
    
    /**
     * Validate incoming parameters
     *
     * @param string $format, html/pdf
     * @param array $uuid, item UUID
     * @param array $version, item Version
     */
    protected function validate_params($format, $uuid, $version)
    {
        if($format!='html' && $format!='pdf')
            return false;
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
        $username = $ci->config->item('sam_shared_secret_username');
        $sharedSecretId = $ci->config->item('sam_shared_secret_id');
        $sharedSecretValue = $ci->config->item('sam_shared_secret_value');
        
		$time = mktime() . '000';
		/*return urlencode ($username) . ':' . urlencode($sharedSecretId) . ':' .  $time . ':' . 
                        urlencode(base64_encode (pack ('H*', md5 ($username . $sharedSecretId . $time . $sharedSecretValue))));*/
		return urlencode($username) . ':' . urlencode($sharedSecretId) . ':' .  $time . ':' . 
                        urlencode(base64_encode (pack ('H*', md5 ($username . $sharedSecretId . $time . $sharedSecretValue))));
						
	}
        
}

/* End of file */
