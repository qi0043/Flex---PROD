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
    
    function get($school, $topic, $year, $semester)
    {
		if(!isset($semester) || $semester == "")
		{
			$result = array("empty");
			return $result;
		}
		
		$sql = "SELECT school_name, avail_ref, tc_fan, tc_fullname, tc_email, TO_CHAR(last_changed, 'YYYY/MM/DD HH24:MI:SS') AS time FROM vw_flex_readings_tc_details WHERE 1=1 ";
		
		// if specified, search for this semester type
		if($semester != "all")
			$sql .= "AND LOWER(avail_ref) LIKE '%!_$semester%' ESCAPE '!' ";
		
		// ns is in a special format
		if($semester == "ns")
		{
			$sql .= "AND LOWER(avail_ref) LIKE '%!_ns!_%' ESCAPE '!' ";
			$sql .= "OR LOWER(avail_ref) LIKE '%!_ns' ESCAPE '!' ";
		}
		
		if($school != "")
			$sql .= "AND LOWER(school_name) LIKE LOWER('%$school%') ";
		
		if($topic != "")
			$sql .= "AND LOWER(avail_ref) LIKE LOWER('$topic%') ";
		
		if($year != "")
			$sql .= "AND avail_ref LIKE '%!_$year!_%' ESCAPE '!' ";
		
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
    
    
}