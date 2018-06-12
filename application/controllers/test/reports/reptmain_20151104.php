<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller for reporting
 */
class Reptmain extends CI_Controller 
{
    
     public function __construct()
     {
        parent::__construct();
	$this->load->helper('url');
	if(session_id()==null)
	    session_start ();
	if(isset($_SESSION['reports_privilege']) && $_SESSION['reports_privilege']=='flextra')
                return;
	
	if(isset($_SESSION['reports_privilege']) && $_SESSION['reports_privilege']=='none')
	{
	    redirect( 'reports/notification/noprivilege');
	    return;
	}
	if(!isset($_SERVER['REMOTE_USER']))
	{
	    exit();
	}
	$fan = strtolower($_SERVER['REMOTE_USER']);
	
        #LDAP groups.
        $this->load->library('ldap/ldap');
        if(!$this->ldap->success)
        {    
            log_message('error', 'Failed to read ldap.');
            exit();
        }
		
        $ldap_groups = $this->ldap->get_groups_of_member($fan);
        if(!$this->ldap->success)
        {    
            log_message('error', 'Ldap error.');
            exit();
        }
        
	$in_group = false;
	foreach($ldap_groups as $ldap_grp)
	{
	    if(strpos($ldap_grp, 'cn=flextra') !== false)
	    {
		$in_group = true;
		break;
	    }
	} 
	
	if($in_group)
	{
	    #Lib Viewerws have the same privilege as topic coordinator
	    $_SESSION['reports_privilege'] = 'flextra';
	    return;
	}
	else
	{
	    $_SESSION['reports_privilege'] = 'none';
	    redirect( 'reports/notification/noprivilege');
	}
     }
    
    public function desc_sess()
    {
	$this->load->helper('url');
	$data['heading'] = 'Web Test';
	
	if (session_id()=='')
	{
		log_message('debug', "MY_Session session_start()");
		session_start();
	}
		
        
	if ( isset( $_COOKIE[session_name()] ) )
	{
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
	session_unset();
	$_SESSION = array();
	
	#redirect('https://flextra-dev.flinders.edu.au/flex/test/test/testlogout');
    }
    

	public function home(){
	    
	    $this->load->helper('url');

	    $data = null;
	    $this->load->view('reports/home', $data);
	}
	
	public function get_login30days()
	{
	    $this->load->helper('url');
	    $this->load->model('reports/reports_model');
	    $stat_last30days = $this->reports_model->db_get_flex_last_30days_login();
	    $data['stat_last30days'] = $stat_last30days;
	    
	    $this->load->view('reports/login30days', $data);
	
	}
	public function get_login_monthly()
	{
	    $this->load->helper('url');
	    $this->load->model('reports/reports_model');
	    $stat_monthly = $this->reports_model->db_get_flex_monthly_login();
	    $data['stat_monthly'] = $stat_monthly;
	    $this->load->view('reports/login_monthly', $data);
	
	}
	public function get_daily_import()
	{
	    $this->load->model('reports/reports_model');
	    
	    $daily_import = $this->reports_model->db_get_flextra_daily_import();
	    $data['daily_import'] = $daily_import;
	    $this->load->view('reports/daily_import', $data);
	
	}
	public function get_collection_counts()
	{
	    $this->load->helper('url');
	    $this->load->library('flexsoap/flexsoap');
            if(!$this->flexsoap->success)
            {
                /*log_message('error', 'bulkImportCourses with error: ' . $this->flexsoap->error_info);
                $message = 'Error: failed to connect to FLEX: ' . $this->flexsoap->error_info;
                $this->course_model->db_set_importe_log('E', $message);
                $errdata['message'] = $this->flexsoap->error_info;
                $errdata['heading'] = "Internal error";
                $this->load->view('reading_rollover/showerror_view', $errdata);
                $this->output->_display();*/
                exit();
                
            }
	    $collections_xml = $this->flexsoap->getSearchableCollections();
            if(!$this->flexsoap->success)
            {
                /*$this->logger_rollover->error($this->flexsoap->error_info);
                $this->logger_activation->error($this->flexsoap->error_info);
                $errdata['message'] = $this->flexsoap->error_info;
                $errdata['heading'] = "Internal error";
                $this->load->view('reading_listmgr/showerror_view', $errdata);
                $this->output->_display();*/
                exit();
            }
	    $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => $collections_xml));
	    for ($j = 1; $j <= $this->xmlwrapper->numNodes('/xml/itemdef'); $j++) 
	    {

		$uuid = '/xml/itemdef['.$j.']/uuid';
		$collections[$j-1]['uuid'] = $this->xmlwrapper->nodeValue($uuid);
		#$collectionUuids[$j-1] = $collections[$j-1]['uuid'];
		#$wheres[$j-1] = "";
			
		$name = '/xml/itemdef['.$j.']/name';
		$collections[$j-1]['name'] = $this->xmlwrapper->nodeValue($name);
	    }
	    #$tst = $this->xmlwrapper->__toString();
	    $wheres = "";
	    $wheres[0] = "";
	    $wheres[1] = "/xml/item/@itemstatus='live'";
	    for($j=0; $j<count($collections); $j++)
	    {
		$collectionUuids = "";
		$collectionUuids[0] = $collections[$j]['uuid'];
		$collectionUuids[1] = $collections[$j]['uuid'];
	        $queryCounts = $this->flexsoap->queryCounts($collectionUuids, $wheres);
		
		if(!$this->flexsoap->success)
		{
                    echo 'error';
		}
		$tst = get_object_vars($queryCounts);
		#var_dump($tst["int"]);exit();
		$collections[$j]['count'] = intval($tst["int"][0]);
		$collections[$j]['live_count'] = intval($tst["int"][1]);
		$collections[$j]['other'] = $collections[$j]['count'] - $collections[$j]['live_count'];
	    }
	    #echo '<pre>'; print_r($collections); echo '</pre>'; exit();
	    #var_dump($collections);exit();
	    usort($collections, function($a, $b) {
		return -($a['live_count'] - $b['live_count']);
	    });
	    $data['collections'] = $collections;
	    
	    
	    $this->load->view('reports/collection_counts', $data);
	
	}
	
	public function check_logs(){
	    
	    $this->load->helper('url');

	    $ci =& get_instance();
            $ci->load->config('flex');
            $institute_url = $ci->config->item('institute_url');
	    if(strpos($institute_url, 'flex-dev') !== false)
		    $suffix = '-dev';
	    else if(strpos($institute_url, 'flex-test') !== false)
		    $suffix = '-test';
	    else
		    $suffix = '';
	    
	    $flex_res_log_link = 'file://flex' . $suffix . '.flinders.edu.au/resource-centre' . $suffix . '/';
	    
	    $data['flex_res_log_link'] = $flex_res_log_link;
	    
	    $access_log_file = '/var/log/flextra-httpd/flextra' . $suffix . '/access_log'  ;
	    $access_log_tail_lines = shell_exec('tail -n 10 ' . $access_log_file);
	    $access_log_tail_lines = str_replace('"', '', $access_log_tail_lines);
	    $access_log_tail_lines = str_replace("'", '', $access_log_tail_lines);
	    $access_log_size = filesize($access_log_file);
	    $data['access_log_tail_lines'] = $access_log_tail_lines;
	    $data['access_log_size'] = $access_log_size;
	    #echo '<pre>'; print_r($data); echo '</pre>'; exit();
	    $this->load->view('reports/logs_view', $data);
	}
	
	public function get_flextra_log()
	{
	    if(!isset($_POST['offset']))
		return "";
	    $offset = $_POST['offset'];
	    $log_file = $_SERVER['DOCUMENT_ROOT'] . '/flex/application/logs/log-' . date("Y-m-d") . '.php';
	    #echo '222';
	    
	    if(!file_exists($log_file))
		return "";
	    
            $handle = @fopen($log_file, 'r');
	    if($handle === false)
		return "";
	    $data = stream_get_contents($handle, -1, $offset);
	    # $data .= $offset;
	     
	    echo $data;
	    #echo nl2br($data);
	    #log_message('error','test...');
	 
	}
	public function get_flextra_access_log()
	{
	    if(!isset($_POST['access_log_offset']))
		return "";
	    
	    $ci =& get_instance();
            $ci->load->config('flex');
            $institute_url = $ci->config->item('institute_url');
	    if(strpos($institute_url, 'flex-dev') !== false)
		    $suffix = '-dev';
	    else if(strpos($institute_url, 'flex-test') !== false)
		    $suffix = '-test';
	    else
		    $suffix = '';
	    
	    $access_log_offset = $_POST['access_log_offset'];
	    #$access_log_file = '/var/log/flextra-httpd/flextra-dev/access_log'  ;
	    $access_log_file = '/var/log/flextra-httpd/flextra' . $suffix . '/access_log'  ;
	    
	    if(!file_exists($access_log_file))
		return "";
	    
            $handle = @fopen($access_log_file, 'r');
	    if($handle === false)
		return "";
	    $data = stream_get_contents($handle, -1, $access_log_offset);
	    # $data .= $offset;
	     
	    echo $data;
	    #echo nl2br($data);
	    #log_message('error','test...');
	 
	}
	
	public function list_flextra_logs()
	{
	    #return;
	    $this->load->helper('url');
	    
	    $ci =& get_instance();
            $ci->load->config('flex');
            $institute_url = $ci->config->item('institute_url');
	    if(strpos($institute_url, 'flex-dev') !== false)
		    $suffix = '-dev';
	    else if(strpos($institute_url, 'flex-test') !== false)
		    $suffix = '-test';
	    else
		    $suffix = '';
	    
	    $flex_res_log_link = 'file://flex' . $suffix . '.flinders.edu.au/resource-centre' . $suffix . '/';
	    
	    $data['flex_res_log_link'] = $flex_res_log_link;
	    
	    #$offset = $_POST['offset'];
	    $log_file_dir = $_SERVER['DOCUMENT_ROOT'] . '/flex/application/logs/';
	    #echo '222';
	    $files0 = scandir($log_file_dir);
	    #echo('<pre>');print_r($files1);echo('<pre>');exit();
	    $j=0;
	    for($i=0;$i<count($files0);$i++)
	    {
		if(strpos($files0[$i], '.php') !== false)
	        {
		    $files1[$j]['name'] = $files0[$i];
		    $files1[$j]['size'] = @filesize($log_file_dir . $files0[$i]);
		    $j++;
		}
	    }
	    $data['files1'] = $files1;
	    #echo 'aa';exit();
	    $this->load->view('reports/all_flextra_logs_view', $data);
	    
	    
	 
	}
	public function view_flextra_log_file()
	{
	    if(!isset($_GET['filename']))
		return;
	    $filename = $_GET['filename'];
	    $log_file = $_SERVER['DOCUMENT_ROOT'] . '/flex/application/logs/' . $filename;
	    
	    
	    if(!file_exists($log_file))
		return "";
	    
            $handle = @fopen($log_file, 'r');
	    if($handle === false)
		return "";
	    $data = stream_get_contents($handle, -1);
	    # $data .= $offset;
	     
	    #echo $data;
	    echo nl2br($data);
	    #log_message('error','test...');
	 
	}
	
	public function test1()
	{
	     
	    $this->load->helper('url');
	    $log_file = '/var/log/flextra-httpd/flextra-dev/access_log'  ;
	    echo shell_exec('tail -n 50 /var/log/flextra-httpd/flextra-dev/access_log'); 
	    return; 
	    #echo('<pre>');print_r($files0);echo('<pre>');exit();
	    $handle = @fopen($log_file, 'r');
	    if($handle === false)
		return "";
	    $data = stream_get_contents($handle, -1, $offset);
	    # $data .= $offset;
	     
	    echo nl2br($data);
	    exit();
	    if(!file_exists($log_file))
		echo "not exists";
	    echo 'exist';
	    return;
            $handle = @fopen($log_file, 'r');
	    if($handle === false)
		return "";
	    $data = stream_get_contents($handle, -1);
	    # $data .= $offset;
	     
	    #echo $data;
	    echo nl2br($data);
	    #log_message('error','test...');
	 
	}
	
	/**********************************************
	 * 
	 *  Assignemnt Extension functions below
	 * 
	 **********************************************/
	
	public function assext_main()
	{
	    $this->load->helper('url');
	    $this->load->model('reports/reports_assext_model');
	    
	    $total_by_status = $this->reports_assext_model->db_assext_total_by_status();
	    $data['total_by_status'] = $total_by_status;
	    
	    $daily_notification = $this->reports_assext_model->db_assext_daily_notification();
	    
	    #var_dump($daily_notification);exit();
	    $data['daily_notification'] = $daily_notification;
	    
	    $unsent_notification = $this->reports_assext_model->db_assext_unsent_notification();
	    $data['unsent_notification'] = $unsent_notification;
	    
	    $topic_count_school = $this->reports_assext_model->db_assext_topic_count_school();
	    $data['topic_count_school'] = $topic_count_school;
	    
	    $stat_reqcount_school = $this->reports_assext_model->db_assext_reqcount_school();
	    $count = count($stat_reqcount_school);
	    $year0 = intval(date("Y")) -1;
	    $reqcount_school_labels = "";
	    #$previous_school = "";
	    $reqcount_school_data[0] = "";
	    $reqcount_school_data[1] = "";
	    
	    #$stat_reqcount_school_new = $stat_reqcount_school;
	    for ($i=0; $i<$count; $i++)
	    {
		 
		$the_year = intval($stat_reqcount_school[$i]['avail_yr']);
		$the_org_name = $stat_reqcount_school[$i]['org_name'];
		$the_org_num = $stat_reqcount_school[$i]['org_num'];
		$the_req_count = $stat_reqcount_school[$i]['req_count'];
		
		$reqcount_school_array[$the_year-$year0][$the_org_num]['org_name'] = $the_org_name;
		$reqcount_school_array[$the_year-$year0][$the_org_num]['req_count'] = $the_req_count;
	    }
	    
	    
	    
	    for ($i=0; $i<$count; $i++)
	    {
		 
		#$the_year = intval($stat_reqcount_school[$i]['avail_yr']);
		$the_org_name = $stat_reqcount_school[$i]['org_name'];
		$the_org_num = $stat_reqcount_school[$i]['org_num'];
		#$the_req_count = $stat_reqcount_school[$i]['req_count'];
		
		if(!isset($reqcount_school_array[0][$the_org_num]['req_count']))
		{
		    $reqcount_school_array[0][$the_org_num]['org_name'] = $the_org_name;
		    $reqcount_school_array[0][$the_org_num]['req_count'] = 0;
		}
		if(!isset($reqcount_school_array[1][$the_org_num]['req_count']))
		{
		    $reqcount_school_array[1][$the_org_num]['org_name'] = $the_org_name;
		    $reqcount_school_array[1][$the_org_num]['req_count'] = 0;
		}
	    }
	    #echo('<pre>');print_r($reqcount_school_array);echo('<pre>');exit();
	    $i = -1;
	    foreach ( $reqcount_school_array[1] as $key => $value)
	    {
		$i++;
		$reqcount_school_labels .= '"' . $value['org_name'] . '"';
		if($i<count($reqcount_school_array[1])-1)
		        $reqcount_school_labels .= ',';
		    
		$reqcount_school_data[1] .= $value['req_count'];
		$reqcount_school_data[0] .= $reqcount_school_array[0][$key]['req_count'];
		if($i<count($reqcount_school_array[1])-1)
		{
		    $reqcount_school_data[0] .= ',';
		    $reqcount_school_data[1] .= ',';
		}
	    }
	    $reqcount_school_labels = str_replace('School of ', '', $reqcount_school_labels);
	    $reqcount_school_labels = str_replace('Flinders ', '', $reqcount_school_labels);
	    $reqcount_school_labels = str_replace('Computer Science, Engineering and Mathematics', 'Comp Eng & Math', $reqcount_school_labels);
	    $reqcount_school_labels = str_replace('Chemical and Physical Sciences', 'Chem & Phys', $reqcount_school_labels);
	    $reqcount_school_labels = str_replace('Humanities and Creative Arts', 'Huma & Arts', $reqcount_school_labels);
	    $reqcount_school_labels = str_replace('Social and Policy Studies', 'Soci & Poli', $reqcount_school_labels);
	    $reqcount_school_labels = str_replace('International Studies', 'Intl Stud', $reqcount_school_labels);
	    #echo('<pre>');print_r($reqcount_school_labels);print_r($reqcount_school_data);echo('<pre>');exit();
	    
 
	    $data['reqcount_school_labels'] = $reqcount_school_labels;
	    $data['reqcount_school_data'] = $reqcount_school_data;
	    
	    $this->load->view('reports/assext_main_view', $data);
	 
	}
}
