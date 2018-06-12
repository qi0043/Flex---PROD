<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class ocf_model extends CI_Model {
    
    public $error_met, $error_info;
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->error_met = false;
        $this->error_info = '';
    }
    
    function db_get_courseInfo($course_code)
    {
		$sql_get_courseInfo = "SELECT tbl_ocf_courses.course_name, tbl_ocf_courses.course_total_year 
                            FROM  tbl_ocf_courses
                            WHERE tbl_ocf_courses.discipline = ?
                            LIMIT 1 OFFSET 0";

        $query = $this->db->query($sql_get_courseInfo, array($course_code));

        if ($query->num_rows() > 0)
        {
           return $query->result_array();
           foreach ($query->result() as $row)
           {
              echo $row->course_name;
			  echo $row->course_total_year;
              echo '<br>';
           }
        }
        else
        {
            return false;
        }
    }
	
	 function db_chk_notice()
    {
        $sql_get_notice = "SELECT * from tbl_notices 
                           WHERE tbl_notices.context = 'ocf'
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