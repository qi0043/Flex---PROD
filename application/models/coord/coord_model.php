<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Coord_model extends CI_Model {
    
    #public $error_met, $error_info;
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        #$this->error_met = false;
        #$this->error_info = '';
    }
    
    function get($school, $topic, $year, $semester, $ereadings, $fan)
    {
		if(!isset($semester) || $semester == "")
		{
			$result = array("empty");
			return $result;
		}
		
		$sql = "SELECT school_name, avail_ref, tc_fan, tc_fullname, tc_email, TO_CHAR(last_changed, 'YYYY/MM/DD HH24:MI:SS') AS time, count_ereadings as ereadings FROM vw_flex_readings_tc_details WHERE 1=1 ";
		
		// if specified, search for this semester type
		if($semester != "all")
			$sql .= "AND LOWER(avail_sem) = '$semester' ";
		
		if($school != "")
			$sql .= "AND LOWER(school_name) LIKE LOWER('%$school%') ";
		
		if($topic != "")
			$sql .= "AND LOWER(avail_ref) LIKE LOWER('$topic%') ";
		
		if($year != "")
                {
                    if(is_numeric($year)==false)
                    {
           	        $result = array("not found");
           	        return $result;
                    }
		    $sql .= "AND avail_yr = '$year' ";
		}
                if($ereadings != "")
			$sql .= "AND has_ereadings = 'Y' ";
                
                if($fan != "")
			$sql .= "AND tc_fan = '$fan' ";
                
		$sql .= "ORDER BY tc_fan ASC";
		
		$query = $this->db->query($sql);
		
        if ($query->num_rows() > 0)
        {
           	$result = $query->result_array();
           	return $result;
        }
        else
        {
            $result = array("not found");
			return $result;
        }
    }
    
    function find_semesters()
	{
		$sql = "SELECT DISTINCT(avail_sem) AS sem FROM vw_flex_readings_tc_details WHERE avail_sem!='' ORDER BY sem ASC";
		$query = $this->db->query($sql);
		
		if ($query->num_rows() > 0)
        {
           	$result = $query->result_array();
           	return $result;
        }
        else
        {
            $result = array("not found");
			return $result;
        }
	}
	
	function db_chk_notice()
    {
        $sql_get_notice = "SELECT * from tbl_notices 
                           WHERE tbl_notices.context = 'coord'
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
}