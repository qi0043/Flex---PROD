<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Course_model extends CI_Model {
    
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        #$this->error_met = false;
        #$this->error_info = '';
    }
    
    function db_get_courses()
    {
        $sql_get_courses = "SELECT * from vw_flex_courses";
        #$sql_get_courses = "COPY (SELECT * from vw_flex_courses) TO STDOUT with CSV";
        
        #$course_csv = '"Name","Description","Code","Citation","Start","End","Students","Type","DepartmentName"' . "\n";
        
        $query = $this->db->query($sql_get_courses);

        if ($query->num_rows() == 0)
                return false;
        
        $result = $query->result_array();
      
        /*foreach ($result as $row)
        {
            $course_csv .= '"' . $row['Name'] . '"' . ','
                           . '"' . $row['Description'] . '"' . ','
                           . '"' . $row['Code'] . '"' . ','
                           . '"' . $row['Citation'] . '"' . ','
                           . '"' . $row['Start'] . '"' . ','
                           . '"' . $row['End'] . '"' . ','
                           . '"' . $row['Students'] . '"' . ','
                           . '"' . $row['Type'] . '"' . ','
                           . '"' . $row['DepartmentName'] . '"' . "\n";
                    
        }
        return $course_csv;*/
        return $result;
    }
    
    /*
            f_admin_daily_import (p_import_process text, p_imported_on timestamp without time zone, p_status text, p_message text)
            Set parameter as follows:
            •	p_import_process For flex_courses
            •	p_imported_on Current timestamp
            •	p_status If the update is successful set as 'S' otherwise if excetion set as 'E'
            •	p_message = If its successful start with “Complete: “ and how many records exported. If there was an error start with “ERROR: “ then spool error to here.

    */
    function db_set_importe_log($update_status, $message)
    {
        $import_process = 'flex_courses';
        $current_timestamp = date("Y-m-d H:i:s");
            #$this->db->call_function('f_admin_daily_import', $p_import_process, $current_timestamp, $update_status, $message);

            $sql = "Select * from f_admin_daily_import(?,?,?,?)";

            $query = $this ->db ->query($sql, array($import_process, $current_timestamp, $update_status, $message));	

    }
    
}