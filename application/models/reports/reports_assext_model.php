<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Reports_assext_model extends CI_Model {
    
    /**********************************************
     * 
     *  Assignemnt Extension
     * 
     **********************************************/
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database('assext');
        #$this->error_met = false;
        #$this->error_info = '';
    }
    
    
    
    function db_assext_daily_notification()
    {
        $sql_get_login = "select * from VW_DAILY_NOTIFICATION";
        
        $query = $this->db->query($sql_get_login);

        if ($query->num_rows() > 0)
        {
           $result = $query->result_array();
	   
	   
	   $lc_res = array();
	   foreach($result as $row)
	   {
		 $new_row = array();
		 foreach ($row as $key => $value) {
				$new_row[strtolower($key)] = $value;
			    }
		 $lc_res[] = $new_row;	
	   }
	   
           return $lc_res;
        }
        else
        {
            return false;
        }
    }
    
    function db_assext_unsent_notification()
    {
        $sql_get_login = "select * from VW_DAILY_NOTIFICATION_UNSENT";
        
        $query = $this->db->query($sql_get_login);

        if ($query->num_rows() > 0)
        {
           $result = $query->result_array();
	   
	   
	   $lc_res = array();
	   foreach($result as $row)
	   {
		 $new_row = array();
		 foreach ($row as $key => $value) {
				$new_row[strtolower($key)] = $value;
			    }
		 $lc_res[] = $new_row;	
	   }
	   
           return $lc_res;
        }
        else
        {
            return false;
        }
    }
    
    function db_assext_total_by_status()
    {
        $sql = "select * from VW_TOTAL_BY_STATUS";
        
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
        {
           $result = $query->result_array();
	   
	   
	   $lc_res = array();
	   foreach($result as $row)
	   {
		 $new_row = array();
		 foreach ($row as $key => $value) {
				$new_row[strtolower($key)] = $value;
			    }
		 $lc_res[] = $new_row;	
	   }
	   
           return $lc_res;
        }
        else
        {
            return false;
        }
    }
    
    function db_assext_reqcount_school()
    {
        $sql = "select org.org_num, org.org_name, sites.avail_yr, count(*) req_count from tbl_requests req
		inner join tbl_flo_sites sites on sites.flo_site_id = req.flo_site_id
		inner join tbl_org_areas org on org.org_num = sites.org_num
		where sites.avail_yr > extract(year from sysdate) - 2 
		group by org.org_num, org.org_name, sites.avail_yr
		order by org.org_num, org.org_name, sites.avail_yr";
        
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
        {
           $result = $query->result_array();
	   
	   
	   $lc_res = array();
	   foreach($result as $row)
	   {
		 $new_row = array();
		 foreach ($row as $key => $value) {
				$new_row[strtolower($key)] = $value;
			    }
		 $lc_res[] = $new_row;	
	   }
	   
           return $lc_res;
        }
        else
        {
            return false;
        }
    }
    
    function db_assext_topic_count_school()
    {
        $sql = "select org.org_num, org.org_name, sites.avail_yr, count(unique(sites.flo_site_id)) topic_count from tbl_flo_sites sites
		inner join tbl_org_areas org on org.org_num = sites.org_num
		inner join tbl_requests req on sites.flo_site_id = req.flo_site_id
		where sites.avail_yr > extract(year from sysdate) - 2 
		group by org.org_num, org.org_name, sites.avail_yr
		order by org.org_num, org.org_name, sites.avail_yr";
        
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
        {
           $result = $query->result_array();
	   
	   
	   $lc_res = array();
	   foreach($result as $row)
	   {
		 $new_row = array();
		 foreach ($row as $key => $value) {
				$new_row[strtolower($key)] = $value;
			    }
		 $lc_res[] = $new_row;	
	   }
	   
           return $lc_res;
        }
        else
        {
            return false;
        }
    }
    
}