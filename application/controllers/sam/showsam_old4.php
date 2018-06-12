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
    public function index($format='html', $uuid='missed', $version='missed', $avail_ref='missed', $avail_ver='missed')
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
	#log_message('error', $response['status']);	
        
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
	
        $data['sam_array']['avail_ref'] = $avail_ref;
        $data['sam_array']['avail_ver'] = $avail_ver;
        
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
			
            /*
            if($data['sam_array']['metadata']['approved'] == 'Yes' && isset($response['attachments']) && isset($response['attachments'][0]))
            {
		    //if a = b, means this attachment is the signature image
		    if($response['attachments'][0]['uuid'] == $data['sam_array']['metadata']['signature_Uuid'])
            { //attachment uuid
                  $data['sam_array']['attachments_name'] = $response['attachments'][0]['filename']; //attachment file name
				  
                  #generate a token for OAuth user to be able to see digital signature for 30 mintues.
                  $data['sam_array']['url'] = $this->generateToken();
		    }
                   
                    $ci =& get_instance();
                    $ci->load->config('flex');
                    $institute_url = $ci->config->item('institute_url');
                    $data['sam_array']['institute_url'] = $institute_url;
            }
            */

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
		$type = '/xml/item/curriculum/@item_type';

        $itemissam = $itemXml->nodeValue($type);
		$itemissam = 'SAM';
        if(isset($itemissam) && $itemissam == 'SAM')
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
        
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/topics/topic'); $j++) 
        {
            $topicCode = '/xml/item/curriculum/topics/topic['.$j.']/code';
            $topicTitle = '/xml/item/curriculum/topics/topic['.$j.']/name';
            $topicUnits = '/xml/item/curriculum/topics/topic['.$j.']/units';
            $topicSchool = '/xml/item/curriculum/topics/topic['.$j.']/school';
            $work_load = '/xml/item/curriculum/topics/topic['.$j.']/workload';
            
            $samsArray['metadata']['topics'][$j]['tcode'] = $itemXml->nodeValue($topicCode);
            $samsArray['metadata']['topics'][$j]['topicTitle'] = $itemXml->nodeValue($topicTitle);
            $samsArray['metadata']['topics'][$j]['topicUnits'] = $itemXml->nodeValue($topicUnits);
            $samsArray['metadata']['topics'][$j]['topicSchool'] = trim($itemXml->nodeValue($topicSchool));
            $samsArray['metadata']['topics'][$j]['work_load'] = $itemXml->nodeValue($work_load);
	}	
	    #$topicLocation = '/xml/item/curriculum/avails/avail/location_code';
		$version_definition = '/xml/item/curriculum/assessment/SAMs/version_definition';
        $approval = '/xml/item/curriculum/assessment/SAMs/distributed';
        $grad_quals = '/xml/item/curriculum/topics/topic/ugrad';
				
        $approved = '/xml/item/curriculum/assessment/approval/approved'; #boolean yes/no
        $approvalDate = '/xml/item/curriculum/assessment/approval/date';
        $approvalPerson = '/xml/item/curriculum/assessment/approval/name_display';
		$approvalFan = '/xml/item/curriculum/assessment/approval/fan';
                
        $attachment_uuid = '/xml/item/curriculum/assessment/approval/signature_file';
        $availability_name = '/xml/item/itembody/name';
		

        $samsArray['metadata']['approval'] = $itemXml->nodeValue($approval);
        $samsArray['metadata']['grad_quals'] = $itemXml->nodeValue($grad_quals);
		
	    $samsArray['metadata']['signature_Uuid'] = $itemXml->nodeValue($attachment_uuid);
	
        #$samsArray['metadata']['work_load'] = $itemXml->nodeValue($work_load);
	    $samsArray['metadata']['approvalDate'] = $itemXml->nodeValue($approvalDate);
	    $samsArray['metadata']['approvalPerson'] = $itemXml->nodeValue($approvalPerson);
	    $samsArray['metadata']['approvalFan'] = $itemXml->nodeValue($approvalFan);
	    $samsArray['metadata']['approved'] = $itemXml->nodeValue($approved);
        
	    $samsArray['metadata']['availability_name'] = $itemXml->nodeValue($availability_name);	
		$samsArray['metadata']['attachment_uuid'] = $itemXml->nodeValue($attachment_uuid);
                #log_message('error', 'attachment_uuid: '.$samsArray['metadata']['attachment_uuid']);
		$samsArray['metadata']['version_definition'] = $itemXml->nodeValue($version_definition);
        // get availabilities information
		
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/avails/avail'); $j++) 
        {

            $avYear = '/xml/item/curriculum/avails/avail['.$j.']/year';
            $avDuration = '/xml/item/curriculum/avails/avail['.$j.']/period_display';
            $avDuration_code = '/xml/item/curriculum/avails/avail['.$j.']/period_code';
            $avLocation = '/xml/item/curriculum/avails/avail['.$j.']/location_display';
            $avLocation_code = '/xml/item/curriculum/avails/avail['.$j.']/location_code';
            $av_version = '/xml/item/curriculum/avails/avail['.$j.']/version';
            $av_ref = '/xml/item/curriculum/avails/avail['.$j.']/@avail_ref';
			$av_topic_code = '/xml/item/curriculum/avails/avail['.$j.']/topic_code';
			$av_topic_name = '/xml/item/curriculum/avails/avail['.$j.']/topic_name';

            $samsArray['metadata']['availability'][$j]['avYear'] = $itemXml->nodeValue($avYear);
            $samsArray['metadata']['availability'][$j]['avDuration'] = $itemXml->nodeValue($avDuration);
            $samsArray['metadata']['availability'][$j]['avDuration_code'] = $itemXml->nodeValue($avDuration_code);
            $samsArray['metadata']['availability'][$j]['avLocation'] = $itemXml->nodeValue($avLocation);
            $samsArray['metadata']['availability'][$j]['avLocation_code'] = $itemXml->nodeValue($avLocation_code);
            $samsArray['metadata']['availability'][$j]['avVersion'] = $itemXml->nodeValue($av_version);
            $samsArray['metadata']['availability'][$j]['avRef'] = $itemXml->nodeValue($av_ref);
			$samsArray['metadata']['availability'][$j]['topic_code'] = $itemXml->nodeValue($av_topic_code);
			$samsArray['metadata']['availability'][$j]['topic_name'] = $itemXml->nodeValue($av_topic_name);
        }
		
		//get course coordinators
       for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/people/coords/coord'); $j++) 
	   {
		   $coord_type = '/xml/item/curriculum/people/coords/coord['.$j.']/@type';
		   $coord_fan = '/xml/item/curriculum/people/coords/coord['.$j.']/fan';
		   $coord_name = '/xml/item/curriculum/people/coords/coord['.$j.']/name';
		   $coord_name_display = '/xml/item/curriculum/people/coords/coord['.$j.']/name_display';
		   $coord_phone = '/xml/item/curriculum/people/coords/coord['.$j.']/phone';
		   $coord_location = '/xml/item/curriculum/people/coords/coord['.$j.']/location';
            
		   $samsArray['metadata']['coordinators'][$j]['coord_type'] = $itemXml->nodeValue($coord_type);
		   $samsArray['metadata']['coordinators'][$j]['coord_fan'] = $itemXml->nodeValue($coord_fan);
		   $samsArray['metadata']['coordinators'][$j]['coord_name'] = $itemXml->nodeValue($coord_name);
		   $samsArray['metadata']['coordinators'][$j]['coord_name_display'] = $itemXml->nodeValue($coord_name_display);
		   $samsArray['metadata']['coordinators'][$j]['coord_phone'] = $itemXml->nodeValue($coord_phone);
		   $samsArray['metadata']['coordinators'][$j]['coord_location'] = $itemXml->nodeValue($coord_location);
	   }
		
		
        // Alignment: topic outcomes
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo'); $j++) 
        {
            $name = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/name';
            $code = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/code';
            $level = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/level';
			
            $samsArray['metadata']['topicalign'][$j]['name'] = $itemXml->nodeValue($name);
            $samsArray['metadata']['topicalign'][$j]['code'] = $itemXml->nodeValue($code);
            $samsArray['metadata']['topicalign'][$j]['level'] = $itemXml->nodeValue($level);
			
            for ($k = 1; $k <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/aligned/a_items/a_item'); $k++) 
            {
            	$assessment = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/aligned/a_items/a_item['.$k.']/name';
                $assessment_id = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/aligned/a_items/a_item['.$k.']/@sys_id';
                //$samsArray['metadata']['topicalign'][$j]['assessment'][$k] ='text'; 
                //$samsArray['metadata']['topicalign'][$j]['assessment'][$k] = $itemXml->nodeValue($assessment); 
                $samsArray['metadata']['topicalign'][$j]['assessment'][$k] = $itemXml->nodeValue($assessment_id); 
            }

                //$samsArray['metadata']['topicalign'][$j]['numItems'] = [$k]; 
        }

        // graduate qualities
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/grad_quals/los/lo'); $j++) 
        {
            $name = '/xml/item/curriculum/outcomes/grad_quals/los/lo['.$j.']/name';
            $code = '/xml/item/curriculum/outcomes/grad_quals/los/lo['.$j.']/code';
            $samsArray['metadata']['gradattribute'][$j]['name'] = $itemXml->nodeValue($name);
            $samsArray['metadata']['gradattribute'][$j]['code'] = $itemXml->nodeValue($code);

            for ($k = 1; $k <= $itemXml->numNodes('/xml/item/curriculum/outcomes/grad_quals/los/lo['.$j.']/aligned/a_items/a_item'); $k++) {

                    //$assessment = '/xml/item/uni/course/grad_attributes/grad_attribute['.$j.']/assessments/assessment['.$k.']/name';
                    $assessment_id = '/xml/item/curriculum/outcomes/grad_quals/los/lo['.$j.']/aligned/a_items/a_item['.$k.']/@sys_id';
                    //$samsArray['metadata']['topicalign'][$j]['assessment'][$k] ='text'; 
                    $samsArray['metadata']['gradattribute'][$j]['assessment'][$k] = $itemXml->nodeValue($assessment_id); 
            }
                //$samsArray['metadata']['topicalign'][$j]['numItems'] = [$k]; 
        }

        // topic alignment
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/assessment/a_items/a_item'); $j++) 
        {
            $name = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/name';
            $format = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/format';
            $proportion = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/proportion';
            $deadline = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/deadline';
            $penalties = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/penalties';
            $return = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/return_date';
            $id = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/@sys_id';

            $samsArray['metadata']['assessment'][$j]['name'] = $itemXml->nodeValue($name);
            $samsArray['metadata']['assessment'][$j]['format'] = $itemXml->nodeValue($format);
            $samsArray['metadata']['assessment'][$j]['proportion'] = $itemXml->nodeValue($proportion);
            $samsArray['metadata']['assessment'][$j]['deadline'] = $itemXml->nodeValue($deadline);
            $samsArray['metadata']['assessment'][$j]['penalties'] = $itemXml->nodeValue($penalties);
            $samsArray['metadata']['assessment'][$j]['return'] = $itemXml->nodeValue($return);
            $samsArray['metadata']['assessment'][$j]['id'] = $itemXml->nodeValue($id);
			
        }
        
		$multiple = '/xml/item/curriculum/assessment/SAMs/multiple';
        $scaling = '/xml/item/curriculum/assessment/scaling/used';
        $scalingDetail = '/xml/item/curriculum/assessment/scaling/detail';
        $resubmissionPermitted = '/xml/item/curriculum/assessment/resubmit/permitted';
        $resubmissionDetail = '/xml/item/curriculum/assessment/resubmit/conditions';

        $academicIntegrity = '/xml/item/curriculum/assessment/text_matching/used';
        $pass = '/xml/item/curriculum/assessment/pass';
        $consideration = '/xml/item/curriculum/assessment/special/contact';

		$samsArray['metadata']['multiple'] = $itemXml->nodeValue($multiple);
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
        

    /**
     * Attach SAM PDF to ITEM
     *
     * @param string $uuid, item UUID
     * @param string $version, item Version
     */
    public function attach_pdf_lx9n3h2($uuid='missed', $version='missed')
    {
        #$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";
        
        if($this->validate_params('pdf', $uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . 'Invalid input params.');
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
        
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }  
        
	#ob_end_flush();
	#log_message('error', 'ob_get_level ():');
	#log_message('error', ob_get_level ());
        #ob_start();
        #echo 'good';

        // Ignore connection-closing by the client/user
        ignore_user_abort(true);

        // Set your timelimit to a length long enough for your script to run, 
        // but not so long it will bog down your server in case multiple versions run 
        // or this script get's in an endless loop.
        /*if ( 
             !ini_get('safe_mode') 
             && strpos(ini_get('disable_functions'), 'set_time_limit') === FALSE 
        ){
            set_time_limit(60);
        }*/

        // Get your output and send it to the client
        $content = 'good';         // Get the content of the output buffer
        #ob_end_clean();                     // Close current output buffer
	$len = strlen($content);             
	header('Content-Type: text/html; charset=UTF-8');
	header('Content-Encoding: none;');
        header('Connection: close');         // Tell the client to close connection
        header("Content-Length: $len");      // Close connection after $size characters
	echo $content;                       // Output content
	ob_flush();
        flush();                             // Force php-output-cache to flush to flex.
                                             
	ob_end_flush();
	
        // Optional: kill all other output buffering
        #while (ob_get_level() > 0) {
        #    ob_end_clean();
	#}
        
        #make sure sam work flow completely finishes
        sleep (5);

	$success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        
        unset($response['headers']);
        $item_bean = $response;
        /*
        echo "<br>=====================================";
        echo "<pre>";
        print_r($response);
        echo "</pre>";
	 */
        $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));
        
        if(!$this->itemIsSam($this->xmlwrapper))
        {
            $errdata['message'] = "Item is not SAM";
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        
        $sam_array = $this->samXml2Array($this->xmlwrapper);
        $sam_array['status'] = $response['status'];
        $data = array('sam_array' => $sam_array);
        #$data['sam_array']['avail_ref'] = $avail_ref;
        #$data['sam_array']['avail_ver'] = $avail_ver;
        $data['sam_array']['format'] = 'pdf';
        $data['sam_array']['uuid'] = $uuid; #item uuid
        $data['sam_array']['version'] = $version; #item version number

	#log_message('error', 'ob_get_level ():');
	#log_message('error', ob_get_level ());
	ob_start();
	#log_message('error', 'ob_get_level ():');
	#log_message('error', ob_get_level ());
        
        $success = $this->flexrest->filesCopy($uuid, $version, $response1);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        if(!isset($response1['headers']['location']))
        {
            $errdata['message'] = 'No Location header in response to copy files REST call.';
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        $location = $response1['headers']['location'];
        $filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
        
        $xpath_files = '/xml/item/curriculum/assessment/SAMs/files';
        #$xpath_uuid = '/xml/item/curriculum/files/file/uuid';
        #$this->xmlwrapper->deleteNodeFromXPath('/xml/item/curriculum/SAMs');
        $this->xmlwrapper->deleteNodeFromXPath($xpath_files);        
        $node_files = $this->xmlwrapper->createNodeFromXPath($xpath_files);
        $distributed = new DateTime("now");
        $approve_time = $distributed->format('c');
        $item_bean['attachments'] = null;
        $file_uuid = $uuid;
        
        #if($data['sam_array']['metadata']['multiple'] == 'yes') 
        {
            $attachment_count = 0;
            foreach ($data['sam_array']['metadata']['availability'] as $availdata  )
            {
                $data['sam_array']['avail_ref'] = $availdata['avRef'];
                $data['sam_array']['avail_ver'] = $availdata['avVersion'];
                
                if($data['sam_array']['metadata']['multiple'] == 'yes' || $attachment_count == 0) 
                {

                    ob_start();
                    $this->load->view('sam/showsam_view', $data);
                    $html = ob_get_contents();
                    ob_end_clean();

                    $pdfclsname = 'pdf_class'.$attachment_count;
                    $this->load->library('pdf/pdf_class', null, $pdfclsname); 
                    #$this->pdf_class->SetDisplayMode('fullpage');
                    $this->$pdfclsname->setFooter('{PAGENO} / {nb}');
                    $this->$pdfclsname->WriteHTML($html);
                    if($data['sam_array']['metadata']['multiple'] == 'yes') 
                        $filename = $data['sam_array']['avail_ref'] . '_' . $approve_time . '.pdf'; 
                    else
                    {
                        $filename = $data['sam_array']['metadata']['availability_name'];
                        if(substr($filename, -2) == '. ')
                                $filename = substr($filename, 0, strlen($filename)-2);
                        $filename = str_replace('. ', '_', $filename);
                        $filename .= '_' . $approve_time . '.pdf';
                    }
                    
                    $pdf_content = $this->$pdfclsname->Output($filename, 'S');

                    $success = $this->flexrest->fileUpload($filearea_uuid, $filename, $pdf_content, $response2);
                    if(!$success)
                    {
                        $errdata['message'] = $this->flexrest->error;
                        log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
                        $this->load->view('sam/showerror_view', $errdata);
                        return;
                    }

                    $file_uuid = sprintf("%03d", $attachment_count);
                    $file_uuid = substr($uuid, 0, 33) . $file_uuid;
                    $item_bean['attachments'][$attachment_count] = array('type'=>'file', 
                                                  'filename'=>$filename, 
                                                  'description'=>$filename,
                                                  'uuid'=>$file_uuid);
                }
                $node_file = $this->xmlwrapper->createNode($node_files, "file");
                $node_uuid = $this->xmlwrapper->createNode($node_file, "uuid");
                $node_ref = $this->xmlwrapper->createAttribute($node_file, "ref");
                $node_distri = $this->xmlwrapper->createAttribute($node_file, "distributed");
                $node_uuid->nodeValue = $file_uuid; 
                $node_ref->nodeValue = $data['sam_array']['avail_ref'];
                $node_distri->nodeValue = $distributed->format('c');
                
                $attachment_count ++;
            }
        }
        
        
        $item_bean['metadata'] = $this->xmlwrapper->__toString();
        $success = $this->flexrest->editItem($uuid, $version, $item_bean, $response3, $filearea_uuid);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        #log_message('error', htmlentities($response['metadata']));
        /*
        echo "<br>=====================================";
        echo "<pre>";
        print_r($response3);
	echo "</pre>";
	 */
    }   
    
    
    
    /**
     * Attach SAM PDF to ITEM
     *
     * @param string $uuid, item UUID
     * @param string $version, item Version
     */
    public function attach_pdf_lx9n3h2_old($uuid='missed', $version='missed')
    {
        #$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";
        
        if($this->validate_params('pdf', $uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . 'Invalid input params.');
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
        
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }  
        
	#ob_end_flush();
	#log_message('error', 'ob_get_level ():');
	#log_message('error', ob_get_level ());
        #ob_start();
        #echo 'good';

        // Ignore connection-closing by the client/user
        ignore_user_abort(true);

        // Set your timelimit to a length long enough for your script to run, 
        // but not so long it will bog down your server in case multiple versions run 
        // or this script get's in an endless loop.
        /*if ( 
             !ini_get('safe_mode') 
             && strpos(ini_get('disable_functions'), 'set_time_limit') === FALSE 
        ){
            set_time_limit(60);
        }*/

        // Get your output and send it to the client
        $content = 'good';         // Get the content of the output buffer
        #ob_end_clean();                     // Close current output buffer
	$len = strlen($content);             
	header('Content-Type: text/html; charset=UTF-8');
	header('Content-Encoding: none;');
        header('Connection: close');         // Tell the client to close connection
        header("Content-Length: $len");      // Close connection after $size characters
	echo $content;                       // Output content
	ob_flush();
        flush();                             // Force php-output-cache to flush to flex.
                                             
	ob_end_flush();
	
        // Optional: kill all other output buffering
        #while (ob_get_level() > 0) {
        #    ob_end_clean();
	#}
        
        #make sure sam work flow completely finishes
        sleep (5);

	$success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        
        unset($response['headers']);
        $item_bean = $response;
        /*
        echo "<br>=====================================";
        echo "<pre>";
        print_r($response);
        echo "</pre>";
	 */
        $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));
        
        if(!$this->itemIsSam($this->xmlwrapper))
        {
            $errdata['message'] = "Item is not SAM";
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        
        $sam_array = $this->samXml2Array($this->xmlwrapper);
        $sam_array['status'] = $response['status'];
        $data = array('sam_array' => $sam_array);
        #$data['sam_array']['avail_ref'] = $avail_ref;
        #$data['sam_array']['avail_ver'] = $avail_ver;
        $data['sam_array']['format'] = 'pdf';
        $data['sam_array']['uuid'] = $uuid; #item uuid
        $data['sam_array']['version'] = $version; #item version number

	#log_message('error', 'ob_get_level ():');
	#log_message('error', ob_get_level ());
	ob_start();
	#log_message('error', 'ob_get_level ():');
	#log_message('error', ob_get_level ());
        
        $success = $this->flexrest->filesCopy($uuid, $version, $response1);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        if(!isset($response1['headers']['location']))
        {
            $errdata['message'] = 'No Location header in response to copy files REST call.';
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        $location = $response1['headers']['location'];
        $filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
        
        $xpath_files = '/xml/item/curriculum/assessment/SAMs/files';
        #$xpath_uuid = '/xml/item/curriculum/files/file/uuid';
        #$this->xmlwrapper->deleteNodeFromXPath('/xml/item/curriculum/SAMs');
        $this->xmlwrapper->deleteNodeFromXPath($xpath_files);        
        $node_files = $this->xmlwrapper->createNodeFromXPath($xpath_files);
        $distributed = new DateTime("now");
        $item_bean['attachments'] = null;
        $file_uuid = $uuid;
        
        #if($data['sam_array']['metadata']['multiple'] == 'yes') 
        {
            $attachment_count = 0;
            foreach ($data['sam_array']['metadata']['availability'] as $availdata  )
            {
                $data['sam_array']['avail_ref'] = $availdata['avRef'];
                $data['sam_array']['avail_ver'] = $availdata['avVersion'];
                
                if($data['sam_array']['metadata']['multiple'] == 'yes' || $attachment_count == 0) 
                {

                    ob_start();
                    $this->load->view('sam/showsam_view', $data);
                    $html = ob_get_contents();
                    ob_end_clean();

                    $pdfclsname = 'pdf_class'.$attachment_count;
                    $this->load->library('pdf/pdf_class', null, $pdfclsname); 
                    #$this->pdf_class->SetDisplayMode('fullpage');
                    $this->$pdfclsname->setFooter('{PAGENO} / {nb}');
                    $this->$pdfclsname->WriteHTML($html);
                    if($data['sam_array']['metadata']['multiple'] == 'yes') 
                        $filename = $data['sam_array']['avail_ref'] . '.pdf'; 
                    else
                    {
                        $filename = $data['sam_array']['metadata']['availability_name'];
                        if(substr($filename, -2) == '. ')
                                $filename = substr($filename, 0, strlen($filename)-2);
                        $filename = str_replace('. ', '_', $filename);
                        $filename .= '.pdf';
                    }
                    
                    $pdf_content = $this->$pdfclsname->Output($filename, 'S');

                    $success = $this->flexrest->fileUpload($filearea_uuid, $filename, $pdf_content, $response2);
                    if(!$success)
                    {
                        $errdata['message'] = $this->flexrest->error;
                        log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
                        $this->load->view('sam/showerror_view', $errdata);
                        return;
                    }

                    $file_uuid = sprintf("%03d", $attachment_count);
                    $file_uuid = substr($uuid, 0, 33) . $file_uuid;
                    $item_bean['attachments'][$attachment_count] = array('type'=>'file', 
                                                  'filename'=>$filename, 
                                                  'description'=>$filename,
                                                  'uuid'=>$file_uuid);
                }
                $node_file = $this->xmlwrapper->createNode($node_files, "file");
                $node_uuid = $this->xmlwrapper->createNode($node_file, "uuid");
                $node_ref = $this->xmlwrapper->createAttribute($node_file, "ref");
                $node_distri = $this->xmlwrapper->createAttribute($node_file, "distributed");
                $node_uuid->nodeValue = $file_uuid; 
                $node_ref->nodeValue = $data['sam_array']['avail_ref'];
                $node_distri->nodeValue = $distributed->format('c');
                
                $attachment_count ++;
            }
        }
        
        
        $item_bean['metadata'] = $this->xmlwrapper->__toString();
        $success = $this->flexrest->editItem($uuid, $version, $item_bean, $response3, $filearea_uuid);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        #log_message('error', htmlentities($response['metadata']));
        /*
        echo "<br>=====================================";
        echo "<pre>";
        print_r($response3);
	echo "</pre>";
	 */
    }   
    
    /**
     * Attach SAM PDF to ITEM
     *
     * @param string $uuid, item UUID
     * @param string $version, item Version
     */
    public function attach_pdf_temp_klk398wd($uuid='missed', $version='missed')
    {
        #$filename_encode = 'kk   kk kk';
        #$filename_encode = rawurlencode($filename_encode);
        #echo $filename_encode;
        #exit();
        
        #$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";
        
        if($this->validate_params('pdf', $uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            log_message('error', 'Attaching SAM pdf failed (validate_params), item uuid: ' . $uuid . ', error: ' . 'Invalid input params.');
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }

        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
        
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }  
        
	#ob_end_flush();
	#log_message('error', 'ob_get_level ():');
	#log_message('error', ob_get_level ());
        #ob_start();
        #echo 'good';

        // Ignore connection-closing by the client/user
        ignore_user_abort(true);

        // Set your timelimit to a length long enough for your script to run, 
        // but not so long it will bog down your server in case multiple versions run 
        // or this script get's in an endless loop.
        /*if ( 
             !ini_get('safe_mode') 
             && strpos(ini_get('disable_functions'), 'set_time_limit') === FALSE 
        ){
            set_time_limit(60);
        }*/
        /*
        // Get your output and send it to the client
        $content = 'good';         // Get the content of the output buffer

	$len = strlen($content);             
	header('Content-Type: text/html; charset=UTF-8');
	header('Content-Encoding: none;');
        header('Connection: close');         // Tell the client to close connection
        header("Content-Length: $len");      // Close connection after $size characters
	echo $content;                       // Output content
	ob_flush();
        flush();                             // Force php-output-cache to flush to flex.
                                             
	ob_end_flush();
	*/
        // Optional: kill all other output buffering
        #while (ob_get_level() > 0) {
        #    ob_end_clean();
	#}
        
        #make sure sam work flow completely finishes
        #sleep (5);

	$success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed (getItem), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        
        unset($response['headers']);
        $item_bean = $response;
        /*
        echo "<br>=====================================";
        echo "<pre>";
        print_r($response);
        echo "</pre>";
	exit();
        */
        $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));
        
        if(!$this->itemIsSam($this->xmlwrapper))
        {
            $errdata['message'] = "Item is not SAM";
            log_message('error', 'Attaching SAM pdf failed (itemIsSam), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        
        $xpath_files = '/xml/item/curriculum/assessment/SAMs/files';
        #$xpath_uuid = '/xml/item/curriculum/files/file/uuid';
        #$this->xmlwrapper->deleteNodeFromXPath('/xml/item/curriculum/SAMs');
        $xpath_files_first_file = $xpath_files . '/file[1]/@distributed';
        $approve_date = $this->xmlwrapper->nodeValue($xpath_files_first_file);
        
        $xpath_approved = '/xml/item/curriculum/assessment/approval/approved';
        $xpath_approval_date = '/xml/item/curriculum/assessment/approval/date';
        $xpath_distributed_date = '/xml/item/curriculum/assessment/SAMs/distributed';
        $tmp_date = $this->xmlwrapper->nodeValue($xpath_approval_date);
        $this->xmlwrapper->setNodeValue($xpath_distributed_date, $tmp_date);
        $this->xmlwrapper->setNodeValue($xpath_approved, $approve_date);
        $this->xmlwrapper->setNodeValue($xpath_approval_date, substr($approve_date, 0, 10));
        
        
        $sam_array = $this->samXml2Array($this->xmlwrapper);
        $sam_array['status'] = $response['status'];
        $data = array('sam_array' => $sam_array);
        #$data['sam_array']['avail_ref'] = $avail_ref;
        #$data['sam_array']['avail_ver'] = $avail_ver;
        $data['sam_array']['format'] = 'pdf';
        $data['sam_array']['uuid'] = $uuid; #item uuid
        $data['sam_array']['version'] = $version; #item version number

	#log_message('error', 'ob_get_level ():');
	#log_message('error', ob_get_level ());
	ob_start();
	#log_message('error', 'ob_get_level ():');
	#log_message('error', ob_get_level ());
        
        $success = $this->flexrest->filesCopy($uuid, $version, $response1);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed, item uuid (filesCopy): ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        if(!isset($response1['headers']['location']))
        {
            $errdata['message'] = 'No Location header in response to copy files REST call.';
            log_message('error', 'Attaching SAM pdf failed, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        $location = $response1['headers']['location'];
        $filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
        
       
        
        $this->xmlwrapper->deleteNodeFromXPath($xpath_files);        
        $node_files = $this->xmlwrapper->createNodeFromXPath($xpath_files);
        
        
        #echo $approve_date; echo 'kkk'; exit();
        
        ##$xpath_approvedate = '/xml/item/moderation/liveapprovaldate';
        ##$approve_date = $this->xmlwrapper->nodeValue($xpath_approvedate) . '111';
        #echo $approve_date; exit();
        #$distributed = new DateTime("now");
        $distributed = $approve_date;
        $item_bean['attachments'] = null;
        $file_uuid = $uuid;
        
        #if($data['sam_array']['metadata']['multiple'] == 'yes') 
        {
            $attachment_count = 0;
            foreach ($data['sam_array']['metadata']['availability'] as $availdata  )
            {
                $data['sam_array']['avail_ref'] = $availdata['avRef'];
                $data['sam_array']['avail_ver'] = $availdata['avVersion'];
                
                if($data['sam_array']['metadata']['multiple'] == 'yes' || $attachment_count == 0) 
                {

                    ob_start();
                    $this->load->view('sam/showsam_view', $data);
                    $html = ob_get_contents();
                    ob_end_clean();

                    $pdfclsname = 'pdf_class'.$attachment_count;
                    $this->load->library('pdf/pdf_class', null, $pdfclsname); 
                    #$this->pdf_class->SetDisplayMode('fullpage');
                    $this->$pdfclsname->setFooter('{PAGENO} / {nb}');
                    $this->$pdfclsname->WriteHTML($html);
                    if($data['sam_array']['metadata']['multiple'] == 'yes') 
                    {
                        $filename = $data['sam_array']['avail_ref'] . '.pdf'; 
                        $filename_date = $data['sam_array']['avail_ref'] . '_' . $approve_date . '.pdf';
                    }
                    else
                    {
                        $filename = $data['sam_array']['metadata']['availability_name'];
                        if(substr($filename, -2) == '. ')
                                $filename = substr($filename, 0, strlen($filename)-2);
                        $filename = str_replace('. ', '_', $filename);
                        $filename_date = $filename . '_' . $approve_date . '.pdf';
                        $filename .= '.pdf';
                    }
                    
                    $filename_encode = rawurlencode($filename);
                    $success = $this->flexrest->fileDelete($filearea_uuid, $filename_encode, $response2);
                    if(!$success)
                    {
                        $errdata['message'] = $this->flexrest->error;
                        #log_message('error', 'Attaching SAM pdf failed (fileDelete), item uuid: ' . $uuid . ', error: ' . $errdata['message'] . ' file name: ' . $filename_encode);
                        #$this->load->view('sam/showerror_view', $errdata);
                        #return;
                        $filename_encode = str_replace('14%20S2', '14%20%20%20S2', $filename_encode);
                        $success = $this->flexrest->fileDelete($filearea_uuid, $filename_encode, $response2);
                        if(!$success)
                        {
                            #$errdata['message'] = $this->flexrest->error;
                            log_message('error', 'Attaching SAM pdf failed (fileDelete), item uuid: ' . $uuid . ', error: ' . $errdata['message'] . ' file name: ' . $filename_encode);
                            #$this->load->view('sam/showerror_view', $errdata);
                            #exit();
                            echo 'failed to delete old file<br>';
                        }
                        #echo "Changed to 3 spaces and file deleted!";
                    }
                    #echo 'Old file deleted<br>';
                    echo 'new file:' . $filename_date . '<br>';
                    
                    $pdf_content = $this->$pdfclsname->Output($filename_date, 'S');

                    $success = $this->flexrest->fileUpload($filearea_uuid, $filename_date, $pdf_content, $response3);
                    #echo 'after fileUpload<br>';
                    if(!$success)
                    {
                        $errdata['message'] = $this->flexrest->error;
                        log_message('error', 'Attaching SAM pdf failed (fileUpload), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
                        $this->load->view('sam/showerror_view', $errdata);
                        return;
                    }
                    echo 'fileUpload success<br>';

                    $file_uuid = sprintf("%03d", $attachment_count);
                    $file_uuid = substr($uuid, 0, 33) . $file_uuid;
                    $item_bean['attachments'][$attachment_count] = array('type'=>'file', 
                                                  'filename'=>$filename_date, 
                                                  'description'=>$filename_date,
                                                  'uuid'=>$file_uuid);
                    #echo 'after setting $item_bean[attachments][$attachment_count]<br>';
                }
                $node_file = $this->xmlwrapper->createNode($node_files, "file");
                $node_uuid = $this->xmlwrapper->createNode($node_file, "uuid");
                $node_ref = $this->xmlwrapper->createAttribute($node_file, "ref");
                $node_distri = $this->xmlwrapper->createAttribute($node_file, "distributed");
                $node_uuid->nodeValue = $file_uuid; 
                $node_ref->nodeValue = $data['sam_array']['avail_ref'];
                $node_distri->nodeValue = $distributed;
                
                $attachment_count ++;
            }
        }
        
        
        $item_bean['metadata'] = $this->xmlwrapper->__toString();
        $success = $this->flexrest->editItem($uuid, $version, $item_bean, $response4, $filearea_uuid);
        #echo 'after editItem<br>';
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            log_message('error', 'Attaching SAM pdf failed (editItem), item uuid: ' . $uuid . ', error: ' . $errdata['message']);
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        echo 'editItem success<br>';
        #log_message('error', htmlentities($response['metadata']));
        /*
        echo "<br>=====================================";
        echo "<pre>";
        print_r($response3);
	echo "</pre>";
	 */
    }   
}

/* End of file */
