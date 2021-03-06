<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Rollover_model extends CI_Model {
    
    public $error_met, $error_info;
    
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
        $this->error_met = false;
        $this->error_info = '';
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
    function db_chk_avails_by_topic($topic_code)
    {
        /*
        $sql_readavail = "SELECT  `avail_ref` 
                            FROM  `tbl_readings_avails` 
                            WHERE  `avail_ref` LIKE ? ESCAPE '/'";
        
        $sql_2014readavail = "SELECT  `flex_code` 
                            FROM  `tbl_2014_readings_avails` 
                            WHERE  `flex_code` LIKE ? ESCAPE '/'";
        
        $sql_nsreadavail = "SELECT  `flex_code` 
                            FROM  `tbl_ns_readings_avails` 
			    WHERE  `flex_code` LIKE ? ESCAPE '/'";

	SELECT  tbl_2014_readings_avails.flex_code as availability
                            FROM  tbl_2014_readings_avails 
                            WHERE  tbl_2014_readings_avails.flex_code LIKE ? ESCAPE '/'
                            UNION
        */
        /*$sql_allreadavail = "SELECT  `tbl_readings_avails`.`avail_ref` as availability
                            FROM  `tbl_readings_avails` 
                            WHERE  `tbl_readings_avails`.`avail_ref` LIKE ? ESCAPE '/'
                            UNION
                            SELECT  `tbl_2014_readings_avails`.`flex_code` as availability
                            FROM  `tbl_2014_readings_avails` 
                            WHERE  `tbl_2014_readings_avails`.`flex_code` LIKE ? ESCAPE '/'
                            UNION
                            SELECT  `tbl_ns_readings_avails`.`flex_code` as availability
                            FROM  `tbl_ns_readings_avails` 
                            WHERE  `tbl_ns_readings_avails`.`flex_code` LIKE ? ESCAPE '/'";
         */
        
        $sql_allreadavail = "SELECT  tbl_readings_avails.avail_ref as availability
                            FROM  tbl_readings_avails 
                            WHERE  tbl_readings_avails.avail_ref LIKE ? ESCAPE '/'
                            UNION
                            SELECT  tbl_ns_readings_avails.flex_code as availability
                            FROM  tbl_ns_readings_avails 
                            WHERE  tbl_ns_readings_avails.flex_code LIKE ? ESCAPE '/'
                            ORDER by 1 DESC";
        
        #$this->load->database();
        
        $query = $this->db->query($sql_allreadavail, array($topic_code.'/_%', $topic_code.'/_%'));
        
        #$query = $this->db->query($sql_readavail, array($topic_code.'/_%'));

        if ($query->num_rows() > 0)
        {
           return $query->result_array();
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
        
        /*
        $sql_chkavail = "SELECT * 
		FROM  `tbl_avails` 
		WHERE  `topic_code` =  ? and teach_end_date > NOW()
                ORDER BY `avail_ref`";
        
        $sql_chkavailcount = "SELECT count(*) 
		FROM  `tbl_avails` 
		WHERE  `topic_code` =  '$topic_code'";
		
	$sql_readavail = "SELECT * 
			FROM  `tbl_readings_avails` 
			WHERE  `flex_code` = ?";
        
        $sql_chk2014plhdavailcount = "SELECT count(*) 
		FROM  `tbl_2014_readings_avails` 
		WHERE  `topic_code` =  '$topic_code'";
        
        $sql_get_topicname =
                "SELECT DISTINCT tbl_avails.topic_name
                 FROM tbl_avails
                 WHERE tbl_avails.topic_code = '$topic_code'";

        $sql_get_orgname =
                "select tbl_org_areas.org_name
                 from tbl_org_areas
                 where tbl_org_areas.org_num =
                (SELECT DISTINCT tbl_avails.org_num
                 FROM tbl_avails
                 WHERE tbl_avails.topic_code = '$topic_code')";
        */
    }
    
    function db_get_readings_by_avail($availability)
    {
        /*$sql_get_readings = "
        select tbl_flex_readings.flex_code, tbl_flex_readings.reading_link, 
        tbl_flex_readings.reading_citation, tbl_flex_readings.reading_description,
        SUBSTRING(tbl_flex_readings.reading_link, LOCATE('items', tbl_flex_readings.reading_link)+6, 36),
        SUBSTRING(tbl_flex_readings.reading_link, LOCATE('uuid', tbl_flex_readings.reading_link)+5, 36)
        from tbl_flex_readings
        where tbl_flex_readings.flex_code = ?";
         */
        
        $sql_get_readings = "
        select tbl_flex_readings.flex_code, tbl_flex_readings.reading_link, 
        tbl_flex_readings.reading_citation, tbl_flex_readings.reading_description,
        SUBSTRING(tbl_flex_readings.reading_link, position('items' in tbl_flex_readings.reading_link)+6, 36),
        SUBSTRING(tbl_flex_readings.reading_link, position('uuid' in tbl_flex_readings.reading_link)+5, 36),
        tbl_flex_readings.active_to,
        tbl_flex_readings.reading_notes,
        tbl_flex_readings.internal_notes,
        CASE (active_to > now())
           WHEN true THEN 'active'
           WHEN false THEN 'inact'
        END AS is_active
        from tbl_flex_readings
        where tbl_flex_readings.flex_code = ?
        order by tbl_flex_readings.reading_citation";

        $query = $this->db->query($sql_get_readings, array($availability));

        if ($query->num_rows() > 0)
        {
           return $query->result_array();
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
    
    function db_get_rollover_readings_by_avail($availability)
    {
        /*$sql_get_readings = "
        select tbl_flex_readings.flex_code, tbl_flex_readings.reading_link, 
        tbl_flex_readings.reading_citation, tbl_flex_readings.reading_description,
        SUBSTRING(tbl_flex_readings.reading_link, LOCATE('items', tbl_flex_readings.reading_link)+6, 36),
        SUBSTRING(tbl_flex_readings.reading_link, LOCATE('uuid', tbl_flex_readings.reading_link)+5, 36)
        from tbl_flex_readings
        where tbl_flex_readings.flex_code = ?";
         */
        $sql_get_rollover_readings = "
        select tbl_intm_readings.reading_link
        from tbl_intm_readings
        where tbl_intm_readings.flex_code = ? and tbl_intm_readings.date = CURRENT_DATE";
        
        $sql_get_readings_details = "
        select tbl_flex_readings.reading_notes, 
        tbl_flex_readings.reading_citation, tbl_flex_readings.reading_description
        from tbl_flex_readings
        where tbl_flex_readings.reading_link = ?
        limit 1 offset 0";

        $query = $this->db->query($sql_get_rollover_readings, array($availability));

        if ($query->num_rows() > 0)
        {
           #return $query->result_array();
           $i = 0;
           foreach ($query->result_array() as $row)
           {
              $results[$i]["reading_link"] = $row["reading_link"];
              $query_detail = $this->db->query($sql_get_readings_details, array($results[$i]["reading_link"]));
              if ($query_detail->num_rows() > 0)
              {
                $res_details = $query_detail->result_array();
                $results[$i]["reading_citation"] = $res_details[0]["reading_citation"];
                $results[$i]["reading_notes"] = $res_details[0]["reading_notes"];
                $results[$i]["reading_description"] = $res_details[0]["reading_description"];
              }
              $i++;
              #echo '<br>';
           }
           return $results;
        }
        else
        {
            return false;
        }
        
    }
    
    function db_get_numof_readings_by_avail($avails)
    {
        $sql_get_numof_readings = "
        select count(*) as num_readings
        from tbl_flex_readings
        where tbl_flex_readings.flex_code = ?";

        for($i=0;$i<count($avails);$i++)
        {
            $query = $this->db->query($sql_get_numof_readings, array($avails[$i]['availability']));
            $result = $query->result_array();
            $num_readings[$i] = $result[0];
        }


        return $num_readings;
        
    }
    
    function db_get_numof_rollover_readings_by_avail($avails)
    {
        $sql_get_numof_readings = "
        select count(*) as num_readings
        from tbl_intm_readings
        where tbl_intm_readings.flex_code = ? and tbl_intm_readings.date = CURRENT_DATE";

        for($i=0;$i<count($avails);$i++)
        {
            $query = $this->db->query($sql_get_numof_readings, array($avails[$i]['availability']));
            $result = $query->result_array();
            $num_readings[$i] = $result[0];
        }


        return $num_readings;
        
    }
    
    function db_chk_reading_for_avail($reading, $avail)
    {
        $sql_chk_reading = "
        select tbl_flex_readings.flex_code
        from tbl_flex_readings
        where tbl_flex_readings.reading_link like ? and tbl_flex_readings.flex_code = ?";

        $query = $this->db->query($sql_chk_reading, array('%'.$reading.'%', $avail));

        if ($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
        
    }
    
    function db_chk_active_reading_for_avail($reading, $avail)
    {
        $sql_chk_reading = "
        select tbl_flex_readings.flex_code
        from tbl_flex_readings
        where tbl_flex_readings.reading_link like ? and tbl_flex_readings.flex_code = ?
        and tbl_flex_readings.active_to > now()";

        $query = $this->db->query($sql_chk_reading, array('%'.$reading.'%', $avail));

        if ($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
        
    }
    
    function db_chk_rollover_reading_for_avail($reading, $avail)
    {
        $sql_chk_reading = "
        select tbl_intm_readings.flex_code
        from tbl_intm_readings
        where tbl_intm_readings.date = CURRENT_DATE and tbl_intm_readings.reading_link like ? and tbl_intm_readings.flex_code = ?";

        $query = $this->db->query($sql_chk_reading, array('%'.$reading.'%', $avail));

        if ($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
        
    }
    
    function db_ins_rollover_reading_for_avail($reading_link,$to_avail,$username,$from_avail=null)
    {
        $sql_ins_rollover_reading = "
            INSERT INTO tbl_intm_readings (reading_link, flex_code, date, username, rollover_from)
            VALUES (?,?,CURRENT_DATE,?,?)";

        $query = $this->db->query($sql_ins_rollover_reading, array($reading_link,$to_avail,$username,$from_avail));

        /*if ($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }*/
        
    }
    
    
}
