<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Reports_equella_model extends CI_Model {
    
    #public $error_met, $error_info;
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database('equella');
        #$this->error_met = false;
        #$this->error_info = '';
    }
    
    function test()
    {
        #$sql_get_login = "select * from tbl_admin_daily_import where imported_on::date = current_date";
        $sql = "select * from audit_log_entry limit 2";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0)
        {
           $result = $query->result_array();
           return $result;
        }
        else
        {
            return 'no rows';
        }
    }
    
    function eqdb_export_ereadings()
    {
        #$sql_get_login = "select * from tbl_admin_daily_import where imported_on::date = current_date";
        $sql = "SELECT course_info.code flex_code,
             ar.from active_from,
             ar.until active_to,
             ar.description reading_citation,
             replace((xpath('//xml/item/copyright/portions/portion/sections/section/type/text()', xmlparse(CONTENT item_xml.xml)))[1]::text, 'file', 'pdf') reading_type,
             'https://flex.flinders.edu.au/items/' || item.uuid || '/' || item.version || '/?.vi=file&attachment.uuid=' || attachment.uuid reading_link,
             attachment.description reading_description,
             (xpath('//xml/item/copyright/portions/portion/notesforusers/text()', xmlparse(CONTENT item_xml.xml)))[1] reading_notes,
             (xpath('//xml/item/copyright/portions/portion/internalnotes/text()', xmlparse(CONTENT item_xml.xml)))[1] internal_notes,
			 LOWER(item.status) reading_status,
             ar.id flex_ar_id,
             item.id flex_item_id,
             item.uuid flex_item_uuid,
             item.version flex_item_version
        FROM activate_request ar
	  INNER JOIN course_info on course_info.id = ar.course_info_id
	  INNER JOIN item on item.id = ar.item_id
	  INNER JOIN attachment on attachment.uuid = ar.attachment
	  INNER JOIN base_entity on base_entity.id = item.item_definition_id
	  INNER JOIN item_xml on item_xml.id = item.item_xml_id
        WHERE base_entity.uuid = 'e8681b61-c93f-47ce-a65b-2810bfb544d5' 
		     --AND item.status = 'LIVE'
	      AND course_info.code != '0000'";
	
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
    
    function db_get_flex_monthly_login()
    {
        $sql_get_login = "select EXTRACT(YEAR FROM logged_in) as year, EXTRACT(MONTH FROM logged_in) as month, count(distinct(id)) as count from tbl_flex_user_logins
			    where EXTRACT(YEAR FROM logged_in) > EXTRACT(YEAR FROM now()) - 2 and internal_user	= false
			    group by EXTRACT(YEAR FROM logged_in), EXTRACT(MONTH FROM logged_in)
			    order by EXTRACT(YEAR FROM logged_in), EXTRACT(MONTH FROM logged_in)";
        
        $query = $this->db->query($sql_get_login);

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
    
    function db_get_flex_last_30days_login()
    {
        $sql_get_login = "select logged_in::date as date, count(*) from tbl_flex_user_logins as count
                          where logged_in::date > (now()::date - interval '30 days') and internal_user = false
			  group by logged_in::date
			  order by logged_in::date";
        
        $query = $this->db->query($sql_get_login);

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
    
    function db_get_flextra_daily_import()
    {
        #$sql_get_login = "select * from tbl_admin_daily_import where imported_on::date = current_date";
        $sql = "select * from vw_admin_daily_import_latest";
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
    
    function db_get_logins_hour()
    {
        #$sql_get_login = "select * from tbl_admin_daily_import where imported_on::date = current_date";
        $sql = "select * from tbl_rpt_logins_hour where time_selection='2015' order by time_hour";
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
}