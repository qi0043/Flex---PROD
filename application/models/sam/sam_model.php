<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Sam_model extends CI_Model {
    
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
    
    
}