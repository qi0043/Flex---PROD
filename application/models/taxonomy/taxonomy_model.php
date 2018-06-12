<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class taxonomy_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
	
	
	/*
		f_admin_daily_import (p_import_process text, p_imported_on timestamp without time zone, p_status text, p_message text)
		Set parameter as follows:
		•	p_import_process For topics set as flex_tax_sam_topics for availabilities set as flex_tax_sam_avails
		•	p_imported_on Current timestamp
		•	p_status If the update is successful set as 'S' otherwise if excetion set as 'E'
		•	p_message For example for Student Two updates I set this as "Completed: 12 created, 0 updated, 0 deleted". For exceptions I set this as the a SQLError or other exception error.

	*/
	function db_set_last_imported_timestamp($view_name, $current_timestamp, $update_status, $message)
	{
	    $p_import_process = 'flex_tax_sam_' . $view_name;
		#$this->db->call_function('f_admin_daily_import', $p_import_process, $current_timestamp, $update_status, $message);
		
		$sql = "Select * from f_admin_daily_import('" . $p_import_process . "', '" . $current_timestamp . "', '" .$update_status . "', '". $message. "')";
		
		$query = $this ->db ->query($sql);	
		
	}

	//get only recently updated  terms
	function db_get_updated_terms($term_name)
	{
		$sql = "SELECT * from vw_taxonomy_sam_" . $term_name. '_mod';
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
	
	 //get all valid terms 
	function db_get_all_terms($term_name)
	{
		$sql = "SELECT * from vw_taxonomy_sam_" . $term_name;
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
	
    function db_get_topicname($topic_code)
    {
        $sql_get_topicname = "SELECT topic_name 
                            FROM  tbl_avails 
                            WHERE  topic_code = ?
                            ORDER BY avail_ref DESC
                            LIMIT 1 OFFSET 0";
        
        $query = $this->db->query($sql_get_topicname, array($topic_code));

        if ($query->num_rows() > 0)
        {
           $result = $query->result_array();
           return $result[0]['topic_name'];
           /*foreach ($query->result() as $row)
           {
              echo $row->avail_ref;
              echo '<br>';
           }*/
        }
        else
        {
            return false;
        }
    }

    
  
    
    
}