<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller to show SAM in HTML or PDF format
 */
class Rhd extends CI_Controller 
{
    
    
    public function view($uuid='missed', $version='missed')
    {
        
        $this->load->helper('url');   
        #$this->load->view('public/rhd/view');
        #return;
        $ci =& get_instance();
        $ci->load->config('flex');
        #$sam_collection = $ci->config->item('sam_collection');
        $institute_url = $ci->config->item('institute_url');
        $errdata['heading'] = "Error";
        $rhd_collection = $ci->config->item('rhd_collection');
        $rhd_oddball_collection = $ci->config->item('rhd_oddball_collection');
        $coursework_thesis_collection = $ci->config->item('coursework_thesis_collection');
        
        if($this->validate_params($uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            $this->load->view('public/rhd/showerror_view', $errdata);
            return;
        }
		
        $this->load->helper('url');
        
        $this->load->model('public/rhd_model');
        $down_notice = false;
        $down_notice = $this->rhd_model->db_chk_notice();
        if($down_notice != false)
        {

            if ($down_notice['message'] == '')
                $down_notice['message'] = 'The thesis system is temporarily unavailable, please try again later.';

            $errdata['message'] = $down_notice['message'];
            $errdata['heading'] = "Notice";
            $this->load->view('public/rhd/showerror_view', $errdata);
            return;
        }
            
        $param1 = array('oauth_client_config_name' => 'rhd');
        $this->load->library('flexrest/flexrest', $param1);
        
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = 'Failed to access RHD thesis.';
            log_message('error','When view public RHD, failed to access FLEX: ' . $this->flexrest->error);
            $this->load->view('public/rhd/showerror_view', $errdata);
            return;
        }    
        
        $success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = 'Failed to access RHD thesis.';
            log_message('error','When view public RHD, failed to access FLEX item: ' . $this->flexrest->error);
            $this->load->view('public/rhd/showerror_view', $errdata);
            return;
        }
        
        #echo "<pre>";
        #print_r($response);
        #echo "</pre>";
        #log_message('error', htmlentities($response['metadata']));
        unset($response['headers']);
        #$item_bean = $response;
        $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));
        if(!isset($response['attachments']))
            $attachments = array();
        else
            $attachments = $response['attachments'];
        /*if(!$this->itemIsSam($this->xmlwrapper))
        {
            $errdata['message'] = "Item is not SAM";
            $this->load->view('public/rhd/showerror_view', $errdata);
            return;
        }*/
        $rhd_array = $this->rhdXml2Array($this->xmlwrapper);
        
        if($response['status'] != 'live' || $rhd_array['interim'] == 'Yes' ||
	    ($response['collection']['uuid'] != $rhd_collection && 
	     $response['collection']['uuid'] != $rhd_oddball_collection &&
	     $response['collection']['uuid'] != $coursework_thesis_collection) )
        {
            $errdata['message'] = "Invalid item.";
            $this->load->view('public/rhd/showerror_view', $errdata);
            return;
        }    
                
        #In this case the open access file uuids are same as examined file uuids
        if($rhd_array['open_access_required'] == 'version of record' && !isset($rhd_array['open_access_uuid']) && isset($rhd_array['examined_thesis_uuid']))
        {
            #unset($rhdArray['open_access_uuid']);
            $rhd_array['open_access_uuid'] = $rhd_array['examined_thesis_uuid'];
        }
        
        /*
         * IF 'Open Access'’'
         *   OK
         * IF 'Restricted Access'
         *   IF Today >= release_date
         *      OK
         *   ELSE
         *      Show abstract but don't show attachments
         * IF 'Never for release'
         *   Forbidden
         */
        #echo $rhd_array['release_status'];return;               
        $rhd_array['restrict_attachments'] = false;
        if($response['collection']['uuid'] == $rhd_collection || $response['collection']['uuid'] == $coursework_thesis_collection)
        {
			if($rhd_array['release_date'] != '')
			{
            $date1 = DateTime::createFromFormat('Y-m-d', $rhd_array['release_date']);
            if($date1 === false)
            {
                $errdata['message'] = "Internal error with invalid thesis release date.";
                $this->load->view('public/rhd/showerror_view', $errdata);
                return;
            }
            $date1->setTime(0, 0, 0);
            $rhd_array['release_date_format'] = $date1->format('j M Y');
			}
			else
			{
				$rhd_array['release_date_format'] = '';
			}
        }        
        switch($rhd_array['release_status']){
            
            case "Restricted Access":
                
                $date2 = new DateTime("now"); 
                if($date1 > $date2)
                {
                    $rhd_array['restrict_attachments'] = true;
                    #$errdata['message'] = "The public release date of this thesis is not reached yet.";
                    #$this->load->view('public/rhd/showerror_view', $errdata);
                    #return;
                }
                break;
                
            case "Open Access":
                break;
            
            case "Never for release":
                
                $errdata['message'] = "This thesis is never for release.";
                $this->load->view('public/rhd/showerror_view', $errdata);
                
                return;
                
            default:   
                #echo $release_status; return;
                $errdata['message'] = "Internal error with invalid access type.";
                $this->load->view('public/rhd/showerror_view', $errdata);
                return;
        }
       
        
        #echo "<pre>";
        #print_r($rhd_array);
        #echo "</pre>";exit();
        #$institute_url = $ci->config->item('institute_url');
        #$file_url = $institute_url . 'items/' . $sam_first['uuid'] . '/' . $sam_first['version'] . '/?.vi=file&attachment.uuid=' . $fileuuid_tmp;
        #for($i=0; $i<count($attachments); $i++)
        #{
        #    $attachments[$i]['href'] = null;
        #}
        
        for($i=0; $i<count($attachments); $i++)
        {
            $attachments[$i]['href'] = null;
            
            if($attachments[$i]['uuid'] == $rhd_array['abstract_uuid'])
            {
                $attachments[$i]['href'] = $institute_url . 'items/' . $uuid . '/' . $version . '/?.vi=file&attachment.uuid=' . $attachments[$i]['uuid'];
                
                $attachments[$i]['displaysize'] = $this->display_size($attachments[$i]['size']);

                continue;
            }        
            
            if(isset($rhd_array['open_access_uuid']))
            {
                for($j=0;$j<count($rhd_array['open_access_uuid']);$j++)
                {
                    if($rhd_array['open_access_uuid'][$j]==$attachments[$i]['uuid'] && $rhd_array['restrict_attachments'] == false)
                    {
                        $attachments[$i]['href'] = $institute_url . 'items/' . $uuid . '/' . $version . '/?.vi=file&attachment.uuid=' . $attachments[$i]['uuid'];
                        $attachments[$i]['displaysize'] = $this->display_size($attachments[$i]['size']);
                        break;
                    }
                }
            }
        }
        
	if(strpos($rhd_array['thesis_type'], 'Doctor') !== false)
		$rhd_array['degree_level'] = 2;
	else if(strpos($rhd_array['thesis_type'], 'Master') !== false)
		$rhd_array['degree_level'] = 1;
	else
		$rhd_array['degree_level'] = null;
	
        $rhd_array['attachments'] = $attachments;
	$rhd_array['item_uuid'] = $uuid;
	$rhd_array['item_version'] = $version;
        #echo "<pre>";
        #print_r($rhd_array);
        #echo "</pre>";exit();
        #$data = array('rhd_array' => $rhd_array);
        
        $this->load->view('public/rhd/view', $rhd_array); 
                    
    }
    
    /**
     * Validate incoming parameters
     *
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
     * Calculate display size
     *
     *    *
     */
    protected function display_size($filesize)
    {
        
      $kb = 1024;
      $MB = $kb * $kb;

      // size in kB, no decimal places
      $sizeKB = round($filesize/$kb, 0);

      // size in MB, none decimal place
      $sizeMB = round($filesize/$MB, 1);

      if ($sizeKB > $kb) {
          $displaysize = $sizeMB . " MB";

      } else {
        $displaysize = $sizeKB . " kB";
      }



        return $displaysize;
    }
    
    
    /**
     * Check whether the item has a type of SAM
     *
     * @param xmlwrapper $itemXml
     */
    /*protected function itemIsSam($itemXml) 
    { 
		$type = '/xml/item/curriculum/@item_type';

        $itemissam = $itemXml->nodeValue($type);
		$itemissam = 'SAM';
        if(isset($itemissam) && $itemissam == 'SAM')
            return true;
        return false;
    }*/
    
    /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function rhdXml2Array($itemXml) 
    {
        /*$item_status = '/xml/item/@itemstatus';
        $rhdArray['item_status'] = $itemXml->nodeValue($item_status);
        $itemdefid = '/xml/item/@itemdefid';
        $rhdArray['item_defid'] = $itemXml->nodeValue($itemdefid);*/
        
        $thesis_name = '/xml/item/itembody/name';
        $rhdArray['thesis_name'] = $itemXml->nodeValue($thesis_name);
        
        $interim = '/xml/item/sys_variables/interim';
        $rhdArray['interim'] = $itemXml->nodeValue($interim);
        
        $abstract = '/xml/item/curriculum/thesis/version/abstract/text';
        $rhdArray['abstract'] = $itemXml->nodeValue($abstract);
        $abstract_uuid = '/xml/item/curriculum/thesis/version/abstract/uuid';
        $rhdArray['abstract_uuid'] = $itemXml->nodeValue($abstract_uuid);
        
        $open_access_required = '/xml/item/curriculum/thesis/version/open_access/required';
        $rhdArray['open_access_required'] = $itemXml->nodeValue($open_access_required);
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/thesis/version/open_access/files/uuid'); $j++) 
        {
            $open_access_uuid = '/xml/item/curriculum/thesis/version/open_access/files/uuid['.$j.']';
            $rhdArray['open_access_uuid'][$j-1] = $itemXml->nodeValue($open_access_uuid);
        }
        for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/thesis/version/examined_thesis/files/uuid'); $j++) 
        {
            $examined_thesis_uuid = '/xml/item/curriculum/thesis/version/examined_thesis/files/uuid['.$j.']';
            $rhdArray['examined_thesis_uuid'][$j-1] = $itemXml->nodeValue($examined_thesis_uuid);
        }
        
        $release_date = '/xml/item/curriculum/thesis/release/release_date';
        $rhdArray['release_date'] = $itemXml->nodeValue($release_date);
        #$first_approval_date = '/xml/item/curriculum/thesis/release/first_approval_date';
        #$rhdArray['first_approval_date'] = $itemXml->nodeValue($first_approval_date);
        $release_status = '/xml/item/curriculum/thesis/release/status';
        $rhdArray['release_status'] = $itemXml->nodeValue($release_status);
        $complete_year = '/xml/item/curriculum/thesis/complete_year';
        $rhdArray['complete_year'] = $itemXml->nodeValue($complete_year);
        $thesis_type = '/xml/item/curriculum/thesis/@type';
        $rhdArray['thesis_type'] = $itemXml->nodeValue($thesis_type);
        
        $school = '/xml/item/curriculum/thesis/schools/primary';
        $rhdArray['school'] = $itemXml->nodeValue($school);
        $faculty = '/xml/item/curriculum/thesis/faculties/primary';
        $rhdArray['faculty'] = $itemXml->nodeValue($faculty);
        $publisher = '/xml/item/curriculum/thesis/publisher';
        $rhdArray['publisher'] = $itemXml->nodeValue($publisher);
        $keyword = '/xml/item/curriculum/thesis/keywords/keyword';
        $rhdArray['keyword_string'] = $itemXml->nodeValue($keyword);
        #$subject = '/xml/item/curriculum/thesis/subjects/subject';
        #$rhdArray['subject'] = $itemXml->nodeValue($subject);
        
	$rhdArray['keyword_array'] = array();
	if($rhdArray['keyword_string'] != "")
	    $rhdArray['keyword_array'] = array_map('trim', explode(',', $rhdArray['keyword_string']) );
	
	$rhdArray['subject_string'] = "";
	$rhdArray['subject_array'] = array();
	for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/thesis/subjects/subject'); $j++) 
        {
            $subject = '/xml/item/curriculum/thesis/subjects/subject['.$j.']';
            $rhdArray['subject_array'][$j-1] = $itemXml->nodeValue($subject);
        }
	if(count($rhdArray['subject_array']) > 0)
	    $rhdArray['subject_string'] = implode(', ', $rhdArray['subject_array']);
	    
        $student_first_name = '/xml/item/curriculum/people/students/student/firstname_display';
        $rhdArray['student_first_name'] = $itemXml->nodeValue($student_first_name);
        $student_last_name = '/xml/item/curriculum/people/students/student/lastname_display';
        $rhdArray['student_last_name'] = $itemXml->nodeValue($student_last_name);
        $student_name = '/xml/item/curriculum/people/students/student/name_display';
        $rhdArray['student_name'] = $itemXml->nodeValue($student_name);
        $supervisor_name = '/xml/item/curriculum/people/coords/coord[1]/name';
        $rhdArray['supervisor_name'] = $itemXml->nodeValue($supervisor_name);
        
        return $rhdArray;
        
    }
    
   
}
