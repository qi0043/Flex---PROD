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
                           WHERE tbl_notices.context = 'OCF'
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
	
	
	/*********************************************************************
	*****************static map queries **********************************
	*********************************************************************/
	
	function db_get_topics_by_year_level($year_level, $course_code)
	{
		ini_set('display_errors', true);
		error_reporting(E_ALL);
		$sql = 'SELECT tbl_ocf_map.topic_code from tbl_ocf_map WHERE year_level = ? AND course_code = ?';
		$query = $this->db->query($sql, array($year_level, $course_code));
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
	
	function db_get_static_topics_html($year_level, $course_code)
	{
		ini_set('display_errors', true);
		error_reporting(E_ALL);
		
		$sql='SELECT tbl_ocf_map.topic_code, tbl_ocf_map.content FROM tbl_ocf_map WHERE year_level = ? AND course_code = ? ORDER BY tbl_ocf_map.topic_code';	
		$query = $this->db->query($sql, array($year_level, $course_code));
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
	
	function db_get_static_topic($topic_code, $course_code)
	{
		ini_set('display_errors', true);
		error_reporting(E_ALL);
		
		$sql='SELECT tbl_ocf_map.content FROM tbl_ocf_map WHERE course_code = ? AND topic_code = ?';	
		$query = $this->db->query($sql, array(strtoupper($course_code), strtoupper($topic_code)));
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
	
	function db_get_content_by_item_uuid($item_uuid,$item_version)
	{
		$sql = 'SELECT tbl_ocf_map.year_level, tbl_ocf_map.topic_code,tbl_ocf_map.course_code,tbl_ocf_map.content FROM tbl_ocf_map WHERE tbl_ocf_map.content LIKE ?';
		$query = $this->db->query($sql, array('%'.$item_uuid.'/'.$item_version.'%'));
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
	
	function db_transaction_remove_static_topics($year_level, $course_code, $topic_code)
	{
		ini_set('display_errors', true);
		error_reporting(E_ALL);
		
		$status = 'None';
		//apply Strict Mode
		$this->db->trans_strict(FALSE);
		
		//start the transaction
    	$this->db->trans_begin();
		$sql = 'DELETE FROM tbl_ocf_map WHERE year_level = ? AND course_code = ? AND topic_code = ?';
		$query = $this->db->query($sql, array($year_level, $course_code, $topic_code));
		if (!$this->db->affected_rows())  //if anything wrong
		{
			$this->db->trans_rollback(); //roll back
			$status = 'Error';
		}
		if ($this->db->trans_status() === TRUE) {
        	$this->db->trans_commit();
			$status = 'Successful';
    	} 
		else {
        	$this->db->trans_rollback();
			$status = 'Error';
    	}
		
		return $status;
	}
	
	function db_transaction_reload_static_map_by_topic_code($content, $course_code, $topic_code)
	{
		ini_set('display_errors', true);
		error_reporting(E_ALL);
		
		$status = 'None';
		//apply Strict Mode
		$this->db->trans_strict(FALSE);
		
		//start the transaction
    	$this->db->trans_begin();
		
		$sql_update_static_html = "UPDATE tbl_ocf_map SET content = ?, course_code = ?, topic_code = ?, generate_date = CURRENT_TIMestamp WHERE course_code = ? AND topic_code = ?";
		
		$query = $this->db->query($sql_update_static_html, array($content, $course_code, $topic_code, $course_code, $topic_code));
		
		if (!$this->db->affected_rows())  //if anything wrong
		{
			$this->db->trans_rollback(); //roll back
			$status = 'Error';
		}
		
		if ($this->db->trans_status() === TRUE) {
        	$this->db->trans_commit();
			$status = 'Successful';
    	} 
		else {
        	$this->db->trans_rollback();
			$status = 'Error';
    	}
		
		return $status;
	}
	
	function db_transaction_static_html($content, $year_level, $course_code, $topic_code)
    {
		ini_set('display_errors', true);
		error_reporting(E_ALL);
		
		$status = 'None';
		//apply Strict Mode
		$this->db->trans_strict(FALSE);
		
		//start the transaction
    	$this->db->trans_begin();
		$sql_get_topic_count = "SELECT * FROM tbl_ocf_map WHERE year_level = ? AND course_code = ? AND topic_code = ?";
		$query = $this->db->query($sql_get_topic_count, array($year_level, $course_code, $topic_code));
		// if this topic already exists THEN update
		if ($query->num_rows() > 0)
        {
           $result = $query->result_array();
           //return $result[0];
		  
		   $sql_update_static_html = "UPDATE tbl_ocf_map SET content = ?, year_level = ?, course_code = ?, topic_code = ?, generate_date = CURRENT_TIMestamp 
		   							  WHERE year_level = ? AND course_code = ? AND topic_code = ?";
		   $query_r = $this->db->query($sql_update_static_html, array($content, $year_level, $course_code, $topic_code, $year_level, $course_code, $topic_code));
		   

		   if (!$this->db->affected_rows())  //if anything wrong
		   {
				$this->db->trans_rollback(); //roll back
				$status = 'Error';
		   }
        }
        else //if this topic doesn't exists THEN insert
        {
             $sql_ins_static_html = "INSERT INTO tbl_ocf_map(content, year_level, course_code, topic_code, generate_date) VALUES (?,?,?,?, now())";
        	 $this->db->query($sql_ins_static_html, array($content, $year_level, $course_code, $topic_code));   
			 if (!$this->db->affected_rows())  //if anything wrong
			 {
				$this->db->trans_rollback(); //roll back
				$status = 'Error';
			 }
        } 
		
		if ($this->db->trans_status() === TRUE) {
        	$this->db->trans_commit();
			$status = 'Successful';
    	} 
		else {
        	$this->db->trans_rollback();
			$status = 'Error';
    	}
		
		return $status;
	}
     
	function db_add_linked_activities($activity_name, $id, $item_uuid, $item_version, $topic_code, $managed_by)
	{
		 $sql = "INSERT INTO tbl_ocf_linked_activities(id, item_uuid, item_version, activity_name, topic_code, managed_by) VALUES (?,?,?,?,?,?)";
		 return $this->db->query($sql, array($id, $item_uuid, $item_version, $activity_name,  $topic_code, $managed_by));   
		
	}
	
   
}
