<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Floreadings_model extends CI_Model {
    
    public $error_met, $error_info;
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->error_met = false;
        $this->error_info = '';
    }
    
    function db_chk_notice()
    {
        $sql_get_notice = "SELECT * from tbl_notices 
                           WHERE tbl_notices.context = 'eReadings'
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
    
    /*
    function db_get_avails_of_topic_libpet($topics)
    {
        #$sql = "select distinct(flex_code) from tbl_flex_readings where flex_code like ? ";
	$sql = "select avail_ref, count(*) as ercount from vw_libpet_readings where topic_code in (?) group by avail_ref";
        #$sql = "select avail_ref, count(*) as ercount from tbl_flex_readings where topic_code in (?) group by avail_ref";

        $query = $this->db->query($sql, array($topics));

        if ($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
        
    }*/
    
    function db_get_readings_of_avail($avail, $include_pend_inact=false)
    {
	#log_message('error','enter get readings of avail');
        #$sql = "select * from tbl_flex_readings where flex_code = ?";
	#$sql = "select * from vw_libpet_readings where avail_ref = ?";
	$sql = "select  
	         fr.flex_code, 
                 fr.reading_citation,
                 fr.reading_description,
                 fr.reading_link, ";
	
	if($include_pend_inact == true)
	    $sql .=	 
                 " (CASE WHEN (NOW() > fr.active_to ) THEN 'Inactive'
                       WHEN (NOW() < fr.active_from ) THEN 'Pending'
                       ELSE 'Active'
                  END) AS status, ";
			 
	$sql .=	 " fr.reading_notes
                 from tbl_flex_readings as fr 
		 where fr.flex_code = ?";
	
	if($include_pend_inact == false)
	    $sql .= " and CURRENT_DATE BETWEEN fr.active_from::DATE AND fr.active_to::DATE";
	#else
	    #$sql .= " and fr.active_to::DATE >= CURRENT_DATE";
	
	$sql .=	 " order by fr.reading_citation";

        $query = $this->db->query($sql, array($avail));
        #log_message('error','left get readings of avail');
        if ($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
        
    }
    
    function db_get_ercount_of_avails($avails, $include_pend_inact=false)
    {
	$count = count($avails);
	
        #$sql = "select distinct(flex_code) from tbl_flex_readings where flex_code like ? ";
	#$sql = "select avail_ref, count(*) as ercount from vw_libpet_readings where avail_ref in (?) group by avail_ref";
	#$sql = "select avail_ref, count(*) as ercount from vw_libpet_readings where avail_ref in (";
	$sql = "select flex_code as avail_ref, count(*) as ercount from tbl_flex_readings where flex_code in (";
	for($i=0; $i<$count; $i++)
	{
	    if($i>0 && $i<$count)
		$sql .= ", ";
	    $sql .= "?";
	}
	$sql .= ")";
	
	if($include_pend_inact == false)
	    $sql .= " and CURRENT_DATE BETWEEN active_from::DATE AND active_to::DATE";
	#else
	    #$sql .= " and active_to::DATE >= CURRENT_DATE";
	
	$sql .= " group by flex_code";
        
        $query = $this->db->query($sql, $avails);
        #var_dump($query);
        if ($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
        
    }
    
}