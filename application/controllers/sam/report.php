<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	
class Report extends CI_Controller 
{
	protected $soapusername;
	protected $soappassword;
	protected $soapparams;
	
	public function __construct()
	{
		parent::__construct();
		$ci =& get_instance();
		$ci->load->config('flex');
		$this->load->helper('url');
		$this->load->model('sam/report_model');

        $this->load->model('sam/sam_model');
        $down_notice = false;
        $down_notice = $this->sam_model->db_chk_notice();
        if($down_notice != false)
        {

            if ($down_notice['message'] == '')
                $down_notice['message'] = 'The SAMs system is temporarily unavailable, please try again later.';

            $errdata['message'] = $down_notice['message'];
            $errdata['heading'] = "Notice";
            $this->load->view('sam/showerror_view', $errdata);
            $this->output->_display();
            exit;
        }

		/********** Get user fan **************/
		if(!isset($_SERVER['REMOTE_USER']))
		{
			log_message('error', 'Failed to get User fan <br/>');
			return;
		}
		$fan= strtolower($_SERVER['REMOTE_USER']);
		$_SESSION['fan'] = $fan;
	    /********** Get user groups **************/
		$this->soapusername = $ci->config->item('soap_username');
		$this->soappassword = $ci->config->item('soap_password');
		
		$this->soapparams = array('username'=>$this->soapusername, 'password'=>$this->soappassword);
            
		$groups = '';
		
        //get user groups from SOAP
		$this->load->library('flexsoap/flexsoap',$this->soapparams);
		if(!$this->flexsoap->success)
		{
			echo $this->flexsoap->error_info . '<br/>';
			exit();
		}
        
		//return user groups in a string    
		$groups = $this->flexsoap->getGroupsByUser($fan);
		if(!$this->flexsoap->success)
		{
			echo $this->flexsoap->error_info . '<br/>';
			exit();
		}
		
		//get authorised group UUIDs
		$sam_contributor_grp = $ci->config->item('sam_contributor_grp');
		$sam_moderation_grp = $ci->config->item('sam_moderation_grp');
		$sam_report_viewer_grp = $ci->config->item('sam_report_viewer_grp');
	
		if(strpos($groups, $sam_moderation_grp) !== false)
		{
			$_SESSION['sam_privilege'] = 'topic_coordinator';
			return;
		}
		else if(strpos($groups, $sam_contributor_grp) !== false)
		{
			
			$_SESSION['sam_privilege'] = 'contributor';
			return;
		}
		
		else if(strpos($groups, $sam_report_viewer_grp) !== false)
		{
			$_SESSION['sam_privilege'] = 'report_viewer';
			return;
		}
		else
		{
			$_SESSION['sam_privilege'] = 'none';
			echo 'You do not have permission to view this report <br/>';
			exit();
		}
		 
	}
	
	public function gq()
	{
		if(isset($_SESSION['sam_privilege']))
		{
			$this->load->view('sam/report_graduate_quality');
		}
	}
	
	//Ajax call from view sam/report_graduate_quality ->ReactDOM.render
	public function get_gq_data()
	{
		$avails= $this->report_model->db_get_vw_avails_grad_quals();
		
		for($i=0; $i<count($avails); $i++)
		{
			
			if($avails[$i]['gradqual1_lvl'] == NULL || $avails[$i]['gradqual1_lvl'] == '')
			{
				if($avails[$i]['gradqual1_aa'] == 't' || $avails[$i]['gradqual1_aa'] == true)
				{
					$avails[$i]['gradqual1_lvl'] = '3';
				}
			}
			if($avails[$i]['gradqual2_lvl'] == NULL || $avails[$i]['gradqual2_lvl'] == '')
			{
				if($avails[$i]['gradqual2_aa'] == 't' || $avails[$i]['gradqual2_aa'] == true)
				{
					$avails[$i]['gradqual2_lvl'] = '3';
				}
			}
			if($avails[$i]['gradqual3_lvl'] == NULL || $avails[$i]['gradqual3_lvl'] == '')
			{
				if($avails[$i]['gradqual3_aa'] == 't' || $avails[$i]['gradqual3_aa'] == true)
				{
					$avails[$i]['gradqual3_lvl'] = '3';
				}
			}
			if($avails[$i]['gradqual4_lvl'] == NULL || $avails[$i]['gradqual4_lvl'] == '')
			{
				if($avails[$i]['gradqual4_aa'] == 't' || $avails[$i]['gradqual4_aa'] == true)
				{
					$avails[$i]['gradqual4_lvl'] = '3';
				}
			}
			if($avails[$i]['gradqual5_lvl'] == NULL || $avails[$i]['gradqual5_lvl'] == '')
			{
				if($avails[$i]['gradqual5_aa'] == 't' || $avails[$i]['gradqual5_aa'] == true)
				{
					$avails[$i]['gradqual5_lvl'] = '3';
				}
			}
			if($avails[$i]['gradqual6_lvl'] == NULL || $avails[$i]['gradqual6_lvl'] == '')
			{
				if($avails[$i]['gradqual6_aa'] == 't' || $avails[$i]['gradqual6_aa'] == true)
				{
					$avails[$i]['gradqual6_lvl'] = '3';
				}
			}
			if($avails[$i]['gradqual7_lvl'] == NULL || $avails[$i]['gradqual7_lvl'] == '')
			{
				if($avails[$i]['gradqual7_aa'] == 't' || $avails[$i]['gradqual7_aa'] == true)
				{
					$avails[$i]['gradqual7_lvl'] = '3';
				}
			}
		}
		
		echo json_encode($avails);
	}
	
	public function index($avail_year_from = 'missed', $avail_year_to = 'missed')
	{
		if(isset($_SESSION['sam_privilege']))
		{
			if($avail_year_from == 'missed' && $avail_year_to == 'missed')
			{
				$avail_year_from = (string)date('Y');
			}
			else
			{
				$current_year = intval(date('Y')); 
				
				if($avail_year_from != 'missed' && $avail_year_to == 'missed')
				{
					$from = intval($avail_year_from);
					
					if($from < 2013 || $from > $current_year)
					{
						echo 'Invalid availability year input <br/>';
						exit;
					}
				}
				else if($avail_year_from != 'missed' && $avail_year_to != 'missed')
				{
					$from = intval($avail_year_from);
					$to = intval($avail_year_to);
					if($from < 2013 || $from > $current_year || $to <= $from || $to > $current_year+1)
					{
						echo 'Invalid availability year input <br/>';
						exit;
					}
				}
			}
			
			$avail_years['from'] = $avail_year_from; 
			$avail_years['to'] = $avail_year_to;

			$res = $this->report_model->db_get_avail_schools($avail_year_from, $avail_year_to);
			
			/*$schools = array();
			if(count($res) > 0)
			{
				foreach($res as $s)
				{
					array_push($schools, $s['school_name']);
				}
			}*/
			
			$r = $this->report_model->db_get_disciplines($avail_year_from, $avail_year_to);
			$disciplines = array();
			if(count($r) > 0)
			{
				foreach($r as $d)
				{
					array_push($disciplines, $d['discipline']);
				}
			}
			
			$data = array('schools' => $res, 'disciplines' => $disciplines, 'avail_yrs' => $avail_years);
			/*echo '<pre>';
			print_r($data);
			echo '</pre>';*/
			$this->load->view('sam/report_dashboard', $data);
		}
	
	}
	
	public function org($org_num)	
	{
		$school = $avails = $this->report_model->db_get_school_name_by_org_num($org_num);
		$data['org_num'] = $org_num;
		$data['org_name'] = $school[0]['org_name'];
		$this->load->view('sam/report_by_org_view', $data);
	}
	
	public function getByOrgNum($org_num)
	{
		$ci =& get_instance();
		$ci->load->config('flex');
		$collection_uuid = $ci->config->item('sam_collection');
		$avail_yr = '2016';
		
		$avails = $this->report_model->postgre_db_get_SAMs_by_school($collection_uuid, $org_num, $avail_yr);
		$avails[0]['key'] = true;
		for($i=1; $i<count($avails); $i++)
		{
			if($avails[$i]['item_id'] == $avails[$i-1]['item_id'])
			{
				$avails[$i]['key'] = false;
			}
			else
			{
				$avails[$i]['key'] = true;
			}
		}
		
		echo json_encode($avails);
		
	}
		
    public function dashboard($org)
	{
		if(session_id() == null)
		{
			session_start();
		}
		
		if(is_numeric($org))
		{
			$_SESSION['sam_org_num'] = $org;
			$school_name= $this->report_model->db_get_school_name_by_org_num($org);
			$data = array('org'=>$org, 'school_name'=>$school_name);
			$this->load->view('sam/report_view', $data);
		}
		
	}
	
	public function discipline($dis)
	{
		if(session_id() == null)
		{
			session_start();
		}
		
		if(strlen($dis) == 4)
		{
			$_SESSION['sam_discipline'] = strtoupper($dis);
			$data = array('dis'=>$dis);
			$this->load->view('sam/report_view_dis', $data);
		}
	}
	
	public function getDis()
	{
		if(session_id() == null)
		{
			session_start();
		}
	
		$ci =& get_instance();
		$ci->load->config('flex');
		$collection_uuid = $ci->config->item('sam_collection');
		$avail_yr = '2017';
		$avails = $this->report_model->postgre_db_get_SAMs_by_discipline($collection_uuid, $avail_yr, $_SESSION['sam_discipline']);
		
		if(!$avails || count($avails) == 0)
		{
			echo 'There is no content from the view';
			exit;
		}
		
		//get all availabilities
		$sam_avails = $this->report_model->db_get_vw_avails_sam_rep_by_dis($avail_yr, $_SESSION['sam_discipline']);
		if(!$sam_avails || count($sam_avails) == 0)
		{
			echo 'There is no content from the view';
			exit;
		}
		if(count($sam_avails)>0)
		{
			$i=-1;
			foreach($sam_avails as $sam)
			{	$i++;
				$sam_avail_ref = trim($sam['avail_ref']);
				$flag = false;
				
				foreach($avails as $avail)
				{
					if($sam_avail_ref == trim($avail['avail_ref']))
					{
						$flag = true;
						
						$sam_avails[$i]['item_uuid'] = $avail['item_uuid'];
						$sam_avails[$i]['item_version'] = $avail['item_version'];
						$sam_avails[$i]['status'] = $avail['status'];
						if(strtoupper($avail['status']) == 'LIVE' || strtoupper($avail['status']) == 'ARCHIVED')
						{
							//if(isset($sam_avails[$i]['flex_link']) && $sam_avails[$i]['flex_link'] != '')
							//{
								$sam_avails[$i]['avail_ref'] = "<a href='".$avail['flex_link']."' target='_blank'>".$avail['avail_ref']."</a>";
							//}
						
							$sam_avails[$i]['flex_link'] = $avail['flex_link'];
						}
						break;
					}
				}
				if(!$flag)
				{
					$sam_avails[$i]['item_uuid'] = 'N/A';
					$sam_avails[$i]['item_version'] = 'N/A';
					$sam_avails[$i]['status'] = 'zzz';
					$sam_avails[$i]['flex_link'] = 'N/A';
				}
			}
		}
		/*echo '<pre>';
		print_r($sam_avails);
		echo '</pre>';*/
		
		echo json_encode($sam_avails);
	}
	
	
	//Ajax call from view sam/report_view ->loadDataFromServer() 
	public function get()
	{  
		if(session_id() == null)
		{
			session_start();
		}
		//print_r($_SESSION);
		
		$ci =& get_instance();
		$ci->load->config('flex');
		$collection_uuid = $ci->config->item('sam_collection');
		$avail_yr = '2016';
		//get SAMs from Equella
		$avails_1 = $this->report_model->postgre_db_get_SAMs($collection_uuid, '2016', $_SESSION['sam_org_num']);
		
		$avail_yr = '2017';
		//get SAMs from Equella
		$avails_2 = $this->report_model->postgre_db_get_SAMs($collection_uuid, '2017', $_SESSION['sam_org_num']);
		
		$avails = array_merge($avails_1, $avails_2);
		
		
		if(!$avails || count($avails) == 0)
		{
			echo 'There is no content from the view';
			exit;
		}
		
		//get all availabilities
		$sam_avails_2016 = $this->report_model->db_get_vw_avails_sam_rep('2016', $_SESSION['sam_org_num']);
		$sam_avails_2017 = $this->report_model->db_get_vw_avails_sam_rep('2017', $_SESSION['sam_org_num']);
		
		$sam_avails = array_merge($sam_avails_2016, $sam_avails_2017);
		if(!$sam_avails || count($sam_avails) == 0)
		{
			echo 'There is no content from the view';
			exit;
		}
		if(count($sam_avails)>0)
		{
			$i=-1;
			foreach($sam_avails as $sam)
			{	$i++;
				$sam_avail_ref = trim($sam['avail_ref']);
				$flag = false;
				
				foreach($avails as $avail)
				{
					if($sam_avail_ref == trim($avail['avail_ref']))
					{
						$flag = true;
						
						$sam_avails[$i]['item_uuid'] = $avail['item_uuid'];
						$sam_avails[$i]['item_version'] = $avail['item_version'];
						$sam_avails[$i]['status'] = $avail['status'];
						if(strtoupper($avail['status']) == 'LIVE' || strtoupper($avail['status']) == 'ARCHIVED')
						{
							//if(isset($sam_avails[$i]['flex_link']) && $sam_avails[$i]['flex_link'] != '')
							//{
								$sam_avails[$i]['avail_ref'] = "<a href='".$avail['flex_link']."' target='_blank'>".$avail['avail_ref']."</a>";
							//}
						
							$sam_avails[$i]['flex_link'] = $avail['flex_link'];
						}
						break;
					}
				}
				if(!$flag)
				{
					$sam_avails[$i]['item_uuid'] = 'N/A';
					$sam_avails[$i]['item_version'] = 'N/A';
					$sam_avails[$i]['status'] = 'zzz';
					$sam_avails[$i]['flex_link'] = 'N/A';
				}
				
			}
		}
		/*echo '<pre>';
		print_r($sam_avails);
		echo '</pre>';*/
		
		echo json_encode($sam_avails);
	}
	
	public function exportCSV()
	{	
		$this->load->helper('url');
		$content = $_POST['html'];
	
		
		//log_message('exportCSV', $content);
		//$html = new DOMDocument();
		//$html->loadHTML($content);
		// Load HTML from a string
		//$html->load($content);
		//$html = str_get_html($content); 
		$data = array();
		$doc = new DOMDocument();
		$doc->loadHTML($content);
		$rows = $doc->getElementsByTagName('tr');
		foreach($rows as $row) {
			$values = array();
			foreach($row->childNodes as $cell) {
				$values[] = $cell->textContent;
			}
			$data[] = $values;
		}

		header('Content-type: application/ms-excel');
		header('Content-Disposition: attachment; filename=sample.csv');
		
		$fp = fopen("php://output", "w");
		
		foreach($data->find('tr') as $element) {
		  $td = array();
		  foreach( $element->find('th') as $row) {
			if (strpos(trim($row->class), 'actions') === false && strpos(trim($row->class), 'checker') === false) {
			  $td [] = $row->plaintext;
			}
		  }
		  if (!empty($td)) {
			//fputcsv($fp, $td);
			fwrite($fp,implode(";",$td)."\r\n");
		  }
		
		  $td = array();
		  foreach( $element->find('td') as $row) {
			if (strpos(trim($row->class), 'actions') === false && strpos(trim($row->class), 'checker') === false) {
			  $td [] = $row->plaintext;
			}
		  }
		  if (!empty($td)) {
			//fputcsv($fp, $td);
			fwrite($fp,implode(";",$td)."\r\n");
		  }
		}
		
		fclose($fp);
		exit;
		//echo 'good';
	}	
	
	
		
		
}
	
	

/* End of file startup.php */