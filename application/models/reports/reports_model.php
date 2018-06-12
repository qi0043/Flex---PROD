<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Reports_model extends CI_Model {
    
    #public $error_met, $error_info;
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        #$this->error_met = false;
        #$this->error_info = '';
    }
    
    function db_chk_notice()
    {
        $sql_get_notice = "SELECT * from tbl_notices 
                           WHERE tbl_notices.context = 'SAM'
                             AND tbl_notices.start_ts < now() AND tbl_notices.end_ts > now()";
        
        $query = $this->db->query($sql_get_notice);

        if ($query->num_rows() > 0)
        {
           $result = $query->result_array();
           return $result[0];
        }
        else
        {
            return false;
        }
    }
    
    function db_get_flex_monthly_login()
    {
        $sql_get_login = "select EXTRACT(YEAR FROM logged_in) as year, EXTRACT(MONTH FROM logged_in) as month, count(distinct(id)) as count from tbl_flex_user_logins
			    where EXTRACT(YEAR FROM logged_in) > EXTRACT(YEAR FROM now()) - 3 and internal_user	= false
			    group by EXTRACT(YEAR FROM logged_in), EXTRACT(MONTH FROM logged_in)
			    order by EXTRACT(YEAR FROM logged_in), EXTRACT(MONTH FROM logged_in)";
        
        $query = $this->db->query($sql_get_login);

        if ($query->num_rows() > 0)
        {
           $result = $query->result_array();
           return $result;
        }
        else
        {
            return false;
        }
    }
    
    function db_get_flex_last_30days_login()
    {
        $sql_get_login = "select logged_in::date as date, count(*) from tbl_flex_user_logins as count
                          where logged_in::date > (now()::date - interval '30 days') and internal_user = false
			  group by logged_in::date
			  order by logged_in::date";
        
        $query = $this->db->query($sql_get_login);

        if ($query->num_rows() > 0)
        {
           $result = $query->result_array();
           return $result;
        }
        else
        {
            return false;
        }
    }
    
    function db_get_flextra_daily_import()
    {
        #$sql_get_login = "select * from tbl_admin_daily_import where imported_on::date = current_date";
        $sql = "select * from vw_admin_daily_import_latest";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
        {
           $result = $query->result_array();
           return $result;
        }
        else
        {
            return false;
        }
    }
    
    function db_get_logins_hour()
    {
        #$sql_get_login = "select * from tbl_admin_daily_import where imported_on::date = current_date";
        $sql = "select * from tbl_rpt_logins_hour where time_selection='2015' order by time_hour";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
        {
           $result = $query->result_array();
           return $result;
        }
        else
        {
            return false;
        }
    }
    
    function flextradb_import_ereadings($p_env)
    {
	#$sql0 = "select * from tbl_flex_readings limit 2";
	#$query = $this->db->query($sql0);return;
	$sql1 = "Select f_flex_daily_readings_import(?::text);";
	$sql2 = "Select f_flex_daily_readings_populate_libpet(?::text);";	
	$query = $this->db->query($sql1, array($p_env));
	$query = $this->db->query($sql2, array($p_env));
    }
    
}