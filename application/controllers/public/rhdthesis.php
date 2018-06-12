<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller to show SAM in HTML or PDF format
 */
class RHDThesis extends CI_Controller 
{
    public function __construct() {
        parent::__construct();
        $this->load->model('public/rhd_model');
        $down_notice = $this->rhd_model->db_chk_notice();
        if($down_notice != false) {
            if ($down_notice['message'] == '')
                $down_notice['message'] = 'The thesis system is temporarily unavailable, please try again later.';
            $errdata['message'] = $down_notice['message'];
            $errdata['heading'] = "Notice";
            $this->load->view('reading_listmgr/showerror_view', $errdata);
            $this->output->_display();
            exit();
        }
    }

    public function report($org_num)
	{
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
        
		if(intval($org_num) > 0 && strlen($org_num) == 3)
		{
			$ci = & get_instance();
			$ci->load->config('flex');
			$this->load->model('rhd/rhd_cron_model');
			$this->load->model('sam/report_model');
			$this->load->helper('url');
			$collection_id = $ci->config->item('rhd_collection');	
			
			$theses = $this->rhd_cron_model->eq_db_get_all_thesis_by_org_num($collection_id, $org_num);
			$school = $this->report_model->db_get_school_name_by_org_num($org_num);
			//print_r($school);
			//$data['heading'] = 'School of Health Sciences';
			$data['heading'] = $school[0]['org_name'];
			$data['rhds'] = $theses;
			
			$this->load->view('public/rhd/hlth_report', $data); 
		}
		else
		{
			log_message('error', 'invalid org_num: ' . $org_num);
			$this->error_info('Invalid URL');
			exit();
		}
		//echo json_encode($theses);
	}
	
	public function ph_thesis()
	{
		$ci = & get_instance();
		$ci->load->config('flex');
		$this->load->model('rhd/rhd_cron_model');
		$this->load->helper('url');
		$collection_id = $ci->config->item('rhd_collection');	
		$org_num = '750';
		
		$theses = $this->rhd_cron_model->eq_db_get_all_thesis_by_subject($collection_id);
		$data['heading'] = 'Public Health thesis';
		$data['rhds'] = $theses;
	    $this->load->view('public/rhd/hlth_report', $data); 
		
		//echo json_encode($theses);
	}
	
	
    public function rhd_school()
    {
	$this->load->library('flexrest/flexrest');
        
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            #$errdata['message'] = $this->flexrest->error;
            log_message('error', 'view RHD, error on flex rest access: ' . $this->flexrest->error);
            $this->error_info('Failed to connect to FLEX to access RHD, please try again later.');
            exit();
        }
        
	$batch_size = 50;
        $ci =& get_instance();
        $ci->load->config('flex');
        #$sam_collection = $ci->config->item('sam_collection');
	$rhd_collection = '1bb07d74-be3c-41b9-8467-3096c2d21f25';
	$org_unit = 750;
        $institute_url = $ci->config->item('institute_url');
        #echo $institute_url;exit();
        $q = '';
        $start = 0;
        $length = $batch_size;
        #$collections = $sam_collection;
        $order = 'modified';
        $reverse = false;
        $info = 'all';#$info = 'metadata';
        $showall = true;
        
	$where = "/xml/item/curriculum/thesis/schools/current_schools/current_school/org_unit='$org_unit'";
            #$where = "/xml/item/curriculum/avails/avail/@avail_ref='$avail_ref'";
        $where .= " AND /xml/item/@itemstatus='live'";
	$where = urlencode($where);
	    
	$rhds = array();    
	#Search SAM in FLEX
            $searchsuccess = $this->flexrest->search($response, $q, $rhd_collection, $where, $start, $length, $order, $reverse, $info, $showall);
            if(!$searchsuccess)
            {
                #$errdata['message'] = $this->flexrest->error;
                log_message('error', 'view SAM from flo, error on flex rest searching function: ' . $this->flexrest->error);
                $this->error_info('Internal error, please try again later.');
                exit();
            }

            #echo '<pre>'; print_r($response);echo '</pre>';exit();

            $rhd_count = intval($response['available']);
            if($rhd_count == 0)
            {
                echo 'No result found.';
            }
	    
	    
            $res_rhds = $response['results'];
            #$uuid = $sam['uuid'];
            #$version = $sam['version'];
	    for($j=0; $j<count($res_rhds); $j++)
	    {
		$tmp_rhd = $res_rhds[$j];
		$xmlwrapper_name = 'xmlwrapper'.$j;
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$tmp_rhd['metadata']), $xmlwrapper_name);

		$tmp_rhd_array = $this->ListRhdXml2Array($this->$xmlwrapper_name);
		$tmp_rhd_array['uuid'] = $tmp_rhd['uuid'];
		$tmp_rhd_array['version'] = $tmp_rhd['version'];

	        $rhds[] = $tmp_rhd_array;
	    }
	    #log_message('error', print_r($rhds, true));
	    
	    $data['rhds'] = $rhds;
		 
	    $this->load->view('public/rhd/hlth_report', $data); 
	    return;
	    if($rhd_count > $batch_size)
	    {
		
		$pages = $rhd_count / $batch_size;
		
		
	    }
	    echo '<pre>'; print_r($rhds); echo '</pre>';
    }	    
    
	    /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function ListRhdXml2Array($itemXml) 
    {
        /*$item_status = '/xml/item/@itemstatus';
        $rhdArray['item_status'] = $itemXml->nodeValue($item_status);
        $itemdefid = '/xml/item/@itemdefid';
        $rhdArray['item_defid'] = $itemXml->nodeValue($itemdefid);*/
        
        $thesis_name = '/xml/item/itembody/name';
        $rhdArray['thesis_name'] = $itemXml->nodeValue($thesis_name);
        
        $interim = '/xml/item/sys_variables/interim';
        $rhdArray['interim'] = $itemXml->nodeValue($interim);
        
        #$abstract = '/xml/item/curriculum/thesis/version/abstract/text';
        #$rhdArray['abstract'] = $itemXml->nodeValue($abstract);
        
        
        
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
	    
	    
	    
    
    
    //
    // Show error information
    //
    public function error_info($error_info) {
	echo $error_info;
        #$data['page_title'] = 'Error';
        #$data['view'] = 'sam/flo/error_info';
        #$data['error_info'] = $error_info;
        #$this->load->view('sam/flo/layout', $data);
        #$this->output->_display();
        exit();
    }
}
