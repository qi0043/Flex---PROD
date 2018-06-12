<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rhd_model extends CI_Model {
    
    public $error_met, $error_info;
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->error_met = false;
        $this->error_info = '';
    }
    
    function db_get_restricted_theses()
    {
		$sql_get_thesesInfo ="SELECT * FROM tbl_flex_rhd_live_theses WHERE tbl_flex_rhd_live_theses.status = 'Restricted Access' AND now() >= tbl_flex_rhd_live_theses.release_date";
			
        $query = $this->db->query($sql_get_thesesInfo);

        if ($query->num_rows() > 0)
        {
           return $query->result_array();
        }
        else
        {
            return 0;
        }
	}
	
	function db_update_thesis_relase_status($release_status, $item_uuid, $item_version)
	{
		ini_set('display_errors', true);
		error_reporting(E_ALL);
		$current_date = date('Y-m-d');
		$sql = "UPDATE tbl_flex_rhd_live_theses
				SET release_status = ?, actual_release_date = ?
				WHERE item_uuid = ? AND item_version = ?";
	    
		$query = $this->db->query($sql, array($release_status,$current_date,$item_uuid,$item_version));
		return $this->db->affected_rows();
	}
}