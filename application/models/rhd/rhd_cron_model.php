<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Rhd_cron_model extends CI_Model 
{
	protected $eq_db;
	protected $postgre_db;
	
    function __construct()
    {
        parent::__construct();
		$this->postgre_db = $this->load->database('postgre', true);
		$this->eq_db = $this->load->database('equella', true);
        $this->load->database();
    }
	function db_chk_notice()
    {
        $sql_get_notice = "SELECT * from tbl_notices 
                           WHERE tbl_notices.context = 'RHD'
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
	
	function db_set_last_imported_timestamp($view_name, $current_timestamp, $update_status, $message)
	{
		$sql = "Select * from f_admin_daily_import('" . $view_name . "', '" . $current_timestamp . "', '" .$update_status . "', '". $message. "')";
		$query = $this ->postgre_db->query($sql);	
		
	}
	
	function eq_db_get_embargo_thesis($collection_uuid)
	{
		$sql = "SELECT UNNEST((xpath('//xml/item/itembody/name/text()', XMLPARSE(CONTENT item_xml.xml))))::text thesis_title, 
					   UNNEST((xpath('//xml/item/curriculum/thesis/release/release_date/text()', XMLPARSE(CONTENT item_xml.xml))))::text release_date, 	
					   item.uuid, item.version,(select url from institution) || 'items/' || item.uuid || '/' || item.version flex_link
				FROM item 
				JOIN item_xml on item.item_xml_id = item_xml.id
				JOIN item_definition on item.item_definition_id = item_definition.id
				JOIN base_entity on base_entity.id = item_definition.id
				JOIN language_string ON language_string.bundle_id = item.name_id
				WHERE base_entity.uuid = ?
				AND item.status = 'LIVE'
				AND cast((xpath('//xml/item/curriculum/thesis/release/status/text()', xmlparse(CONTENT item_xml.xml)))[1] as text)::text = 'Restricted Access'
				AND now() >= to_date(cast((xpath('//xml/item/curriculum/thesis/release/release_date/text()', xmlparse(CONTENT item_xml.xml)))[1] as text), 'YYYY-MM-DD')
				ORDER BY thesis_title
				";

		$query = $this->eq_db->query($sql, array($collection_uuid));
		$results = $query->result_array();
		return $results;	
	}

	function eq_db_get_embargo_thesis_for_release($collection_uuid)
	// Model used by cron to return theses currently under embargo to unrestrict attachments
	{
		$sql = "SELECT UNNEST((xpath('//xml/item/itembody/name/text()', XMLPARSE(CONTENT item_xml.xml))))::text thesis_title, 
		UNNEST((xpath('//xml/item/curriculum/thesis/release/embargo_release/release_status/text()', XMLPARSE(CONTENT item_xml.xml))))::text embargo_release_status,
		(UNNEST((xpath('//xml/item/curriculum/thesis/release/release_date/text()', XMLPARSE(CONTENT item_xml.xml))))::text)::date release_date,
		item.uuid, item.version,(SELECT url from institution) || 'items/' || item.uuid || '/' || item.version flex_link
		FROM item
		JOIN item_xml on item.item_xml_id = item_xml.id
		JOIN item_definition on item.item_definition_id = item_definition.id
		JOIN base_entity on base_entity.id = item_definition.id
		WHERE base_entity.uuid = ?
		AND item.status = 'LIVE'
		AND CAST((xpath('//xml/item/curriculum/thesis/release/status/text()', XMLPARSE(CONTENT item_xml.xml)))[1] AS TEXT)::text = 'Restricted Access'
		AND CAST((xpath('//xml/item/curriculum/thesis/release/embargo_release/release_status/text()', XMLPARSE(CONTENT item_xml.xml)))[1] AS TEXT)::text = 'under embargo'
		AND now() >= to_date(cast((xpath('//xml/item/curriculum/thesis/release/release_date/text()', xmlparse(CONTENT item_xml.xml)))[1] as TEXT), 'YYYY-MM-DD')
		ORDER BY thesis_title";

		$query = $this->eq_db->query($sql, array($collection_uuid));
		$results = $query->result_array();

		return $results;	
	}


	function eq_db_get_embargo_thesis_for_attachment_release($collection_uuid)
	// Model used by cron to return theses currently under embargo to unrestrict attachments
	{
		$sql = "SELECT UNNEST((xpath('//xml/item/itembody/name/text()', XMLPARSE(CONTENT item_xml.xml))))::text thesis_title, 
		UNNEST((xpath('//xml/item/curriculum/thesis/release/embargo_release/release_status/text()', XMLPARSE(CONTENT item_xml.xml))))::text embargo_release_status,
		(UNNEST((xpath('//xml/item/curriculum/thesis/release/release_date/text()', XMLPARSE(CONTENT item_xml.xml))))::text)::date release_date,
		item.uuid, item.version,(SELECT url from institution) || 'items/' || item.uuid || '/' || item.version flex_link
		FROM item
		JOIN item_xml on item.item_xml_id = item_xml.id
		JOIN item_definition on item.item_definition_id = item_definition.id
		JOIN base_entity on base_entity.id = item_definition.id
		WHERE base_entity.uuid = ?
		AND item.status = 'LIVE'
		AND CAST((xpath('//xml/item/curriculum/thesis/release/status/text()', XMLPARSE(CONTENT item_xml.xml)))[1] AS TEXT)::text = 'Restricted Access'
		AND CAST((xpath('//xml/item/curriculum/thesis/release/embargo_release/release_status/text()', XMLPARSE(CONTENT item_xml.xml)))[1] AS TEXT)::text = 'under embargo'
		AND now() < to_date(cast((xpath('//xml/item/curriculum/thesis/release/release_date/text()', xmlparse(CONTENT item_xml.xml)))[1] as TEXT), 'YYYY-MM-DD')
		ORDER BY release_date ASC";

		$query = $this->eq_db->query($sql, array($collection_uuid));
		$results = $query->result_array();

		return $results;	
	}

	function eq_db_get_cw_restricted($collection_uuid)
	{
		$sql = "SELECT UNNEST((xpath('//xml/item/itembody/name/text()', XMLPARSE(CONTENT item_xml.xml))))::text thesis_title, 
		UNNEST((xpath('//xml/item/curriculum/thesis/release/embargo_release/release_status/text()', XMLPARSE(CONTENT item_xml.xml))))::text embargo_release_status,
		(UNNEST((xpath('//xml/item/curriculum/thesis/release/release_date/text()', XMLPARSE(CONTENT item_xml.xml))))::text)::date release_date,
		item.uuid, item.version,(SELECT url from institution) || 'items/' || item.uuid || '/' || item.version flex_link
		FROM item
		JOIN item_xml on item.item_xml_id = item_xml.id
		JOIN item_definition on item.item_definition_id = item_definition.id
		JOIN base_entity on base_entity.id = item_definition.id
		WHERE base_entity.uuid = ?
		AND item.status = 'LIVE'
		AND CAST((xpath('//xml/item/curriculum/thesis/release/status/text()', XMLPARSE(CONTENT item_xml.xml)))[1] AS TEXT)::text = 'Restricted Access'
		AND CAST((xpath('//xml/item/curriculum/thesis/release/embargo_release/release_status/text()', XMLPARSE(CONTENT item_xml.xml)))[1] AS TEXT)::text = 'under embargo'
		AND now() >= to_date(cast((xpath('//xml/item/curriculum/thesis/release/release_date/text()', xmlparse(CONTENT item_xml.xml)))[1] as TEXT), 'YYYY-MM-DD')
		ORDER BY release_date ASC";

		$query = $this->eq_db->query($sql, array($collection_uuid));
		$results = $query->result_array();

		return $results;

	}
		






	
	function eq_db_get_all_embargo_thesis($collection_uuid)
	{
		$sql = "SELECT UNNEST((xpath('//xml/item/itembody/name/text()', XMLPARSE(CONTENT item_xml.xml))))::text thesis_title, 
					   UNNEST((xpath('//xml/item/curriculum/thesis/release/release_date/text()', XMLPARSE(CONTENT item_xml.xml))))::text release_date, 	
					   item.uuid, item.version,(select url from institution) || 'items/' || item.uuid || '/' || item.version flex_link
				FROM item 
				JOIN item_xml on item.item_xml_id = item_xml.id
				JOIN item_definition on item.item_definition_id = item_definition.id
				JOIN base_entity on base_entity.id = item_definition.id
				JOIN language_string ON language_string.bundle_id = item.name_id
				WHERE base_entity.uuid = ?
				AND item.status = 'LIVE'
				AND cast((xpath('//xml/item/curriculum/thesis/release/status/text()', xmlparse(CONTENT item_xml.xml)))[1] as text)::text = 'Restricted Access'
				ORDER BY thesis_title
				";

		$query = $this->eq_db->query($sql, array($collection_uuid));
		$results = $query->result_array();
		return $results;	
	}
	
	
	function eq_db_get_all_thesis($collection_uuid)
	{
		$sql = "SELECT UNNEST((xpath('//xml/item/itembody/name/text()', XMLPARSE(CONTENT item_xml.xml))))::text title, 
						UNNEST((xpath('//xml/item/curriculum/thesis/release/release_date/text()', XMLPARSE(CONTENT item_xml.xml))))::text release_date,
						UNNEST((xpath('//xml/item/curriculum/thesis/schools/primary/text()', XMLPARSE(CONTENT item_xml.xml))))::text school_name,
						UNNEST((xpath('//xml/item/curriculum/thesis/faculties/current_faculties/current_faculty/name/text()', XMLPARSE(CONTENT item_xml.xml))))::text faculty_name,
						UNNEST((xpath('//xml/item/curriculum/thesis/release/status/text()', XMLPARSE(CONTENT item_xml.xml))))::text release_status,
						UNNEST((xpath('//xml/item/curriculum/thesis/@type', XMLPARSE(CONTENT item_xml.xml))))::text thesis_type,
						UNNEST((xpath('//xml/item/curriculum/thesis/complete_year/text()', XMLPARSE(CONTENT item_xml.xml))))::text complete_year,
						item.uuid as item_uuid, 
						item.version as item_version, 
						initcap(item.status) as status
						FROM item
						JOIN item_xml on item.item_xml_id = item_xml.id
						JOIN item_definition on item.item_definition_id = item_definition.id
						JOIN base_entity on base_entity.id = item_definition.id
						JOIN language_string ON language_string.bundle_id = item.name_id
						WHERE base_entity.uuid = ?
						ORDER BY school_name, faculty_name, title";
		$query = $this->eq_db->query($sql, array($collection_uuid));
		$results = $query->result_array();
		return $results;				
						
	}
	
	function eq_db_get_all_thesis_by_org_num($collection_uuid, $org_unit)
	{
		$sql = "SELECT UNNEST((xpath('//xml/item/itembody/name/text()', XMLPARSE(CONTENT item_xml.xml))))::text title, 
						UNNEST((xpath('//xml/item/curriculum/thesis/release/release_date/text()', XMLPARSE(CONTENT item_xml.xml))))::text release_date,
						UNNEST((xpath('//xml/item/curriculum/thesis/release/status/text()', XMLPARSE(CONTENT item_xml.xml))))::text release_status,
						UNNEST((xpath('//xml/item/curriculum/thesis/@type', XMLPARSE(CONTENT item_xml.xml))))::text thesis_type,
						UNNEST((xpath('//xml/item/curriculum/thesis/complete_year/text()', XMLPARSE(CONTENT item_xml.xml))))::text complete_year,
						UNNEST((xpath('//xml/item/curriculum/people/students/student/name_display/text()', XMLPARSE(CONTENT item_xml.xml))))::text student_name,
						UNNEST((xpath('//xml/item/curriculum/people/coords/coord/name/text()', XMLPARSE(CONTENT item_xml.xml))))::text coords_name,
						item.uuid as item_uuid, 
						item.version as item_version, 
						initcap(item.status) as status
						FROM item
						JOIN item_xml on item.item_xml_id = item_xml.id
						JOIN item_definition on item.item_definition_id = item_definition.id
						JOIN base_entity on base_entity.id = item_definition.id
						JOIN language_string ON language_string.bundle_id = item.name_id
						WHERE base_entity.uuid = ? 
						AND item.status = 'LIVE'
						AND cast((xpath('//xml/item/curriculum/thesis/schools/current_schools/current_school/org_unit/text()', xmlparse(CONTENT item_xml.xml)))[1] as text)::text = ?
						ORDER BY release_date desc";
		$query = $this->eq_db->query($sql, array($collection_uuid, $org_unit));
		$results = $query->result_array();
		return $results;				
						
	} 
	
	function eq_db_get_all_thesis_by_subject($collection_uuid)
	{
		$sql = "SELECT UNNEST((xpath('//xml/item/itembody/name/text()', XMLPARSE(CONTENT item_xml.xml))))::text title, 
						UNNEST((xpath('//xml/item/curriculum/thesis/release/release_date/text()', XMLPARSE(CONTENT item_xml.xml))))::text release_date,
						UNNEST((xpath('//xml/item/curriculum/thesis/release/status/text()', XMLPARSE(CONTENT item_xml.xml))))::text release_status,
						UNNEST((xpath('//xml/item/curriculum/thesis/@type', XMLPARSE(CONTENT item_xml.xml))))::text thesis_type,
						UNNEST((xpath('//xml/item/curriculum/thesis/complete_year/text()', XMLPARSE(CONTENT item_xml.xml))))::text complete_year,
						UNNEST((xpath('//xml/item/curriculum/people/students/student/name_display/text()', XMLPARSE(CONTENT item_xml.xml))))::text student_name,
						UNNEST((xpath('//xml/item/curriculum/people/coords/coord/name/text()', XMLPARSE(CONTENT item_xml.xml))))::text coords_name,
						item.uuid as item_uuid, 
						item.version as item_version, 
						initcap(item.status) as status
						FROM item
						JOIN item_xml on item.item_xml_id = item_xml.id
						JOIN item_definition on item.item_definition_id = item_definition.id
						JOIN base_entity on base_entity.id = item_definition.id
						JOIN language_string ON language_string.bundle_id = item.name_id
						WHERE base_entity.uuid = ? 
						AND item.status = 'LIVE'
						AND cast((xpath('//xml/item/curriculum/thesis/subjects/subject/text()', xmlparse(CONTENT item_xml.xml)))[1] as text)::text LIKE '%Public Health thesis%'
						ORDER BY release_date desc";
		$query = $this->eq_db->query($sql, array($collection_uuid));
		$results = $query->result_array();
		return $results;				
						
	} 
	
}