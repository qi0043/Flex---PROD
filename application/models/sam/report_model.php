<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Report_model extends CI_Model 
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
	
	function db_get_vw_avails_grad_quals()
	{
		$sql = "SELECT * FROM vw_avail_grad_quals_4";
		$query = $this->postgre_db->query($sql);
        $result = $query->result_array();
        return $result;
	}
	
	function db_get_vw_avails_sam_rep($avail_year, $org_num)
	{
		$sql = "SELECT * FROM vw_avails_sam_rep WHERE avail_yr = ? AND org_num = ? ORDER BY avail_ref ";
		$query = $this->postgre_db->query($sql, array($avail_year, $org_num));
        $result = $query->result_array();
        return $result;
	}
	
	function db_get_vw_avails_sam_rep_by_dis($avail_year, $dis)
	{
		$sql = "SELECT * FROM vw_avails_sam_rep WHERE avail_yr = ? AND discipline = ? ORDER BY avail_ref ";
		$query = $this->postgre_db->query($sql, array($avail_year, $dis));
        $result = $query->result_array();
        return $result;
	}
	function db_get_school_name_by_org_num($org)
	{
		$sql = "select org_name from tbl_org_areas where org_num = ?";
		$query = $this->postgre_db->query($sql, array($org));
        $result = $query->result_array();
        return $result;
	}
	
	function db_get_disciplines($avail_year_from, $avail_year_to)
	{
		$sql = "SELECT DISTINCT(discipline) FROM vw_avails_sam_rep";
		$sql .= $this->return_sql_by_yr($avail_year_from, $avail_year_to);
		$sql .= " ORDER BY discipline";
		$query = $this->postgre_db->query($sql);
        $result = $query->result_array();
        return $result;
	}
	
	function db_get_avail_schools($avail_year_from, $avail_year_to)
	{
		$sql = "SELECT DISTINCT(school_name), org_num FROM vw_avails_sam_rep";
		$sql .= $this->return_sql_by_yr($avail_year_from, $avail_year_to);
		$sql .= " ORDER BY school_name";
		//echo $sql;
		//$sql = "SELECT DISTINCT(school_name) FROM vw_avails_sam_rep WHERE avail_yr = ? ORDER BY school_name";
		$query = $this->postgre_db->query($sql);
        $result = $query->result_array();
        return $result;
		
	}
	
	function postgre_db_get_SAMs($collection_uuid, $avail_year, $org_num)
	{
		$sql = "SELECT UNNEST((xpath('//xml/item/curriculum/avails/avail/@avail_ref', XMLPARSE(CONTENT item_xml.xml))))::text avail_ref,
					   item.uuid as item_uuid, 
					   item.version as item_version, 
					   initcap(item.status) as status, 
					   (select url from institution) || 'items/' || item.uuid || '/' || item.version flex_link
				FROM item
				JOIN item_xml on item.item_xml_id = item_xml.id
				JOIN item_definition on item.item_definition_id = item_definition.id
				JOIN base_entity on base_entity.id = item_definition.id
				JOIN language_string ON language_string.bundle_id = item.name_id
				WHERE base_entity.uuid = ?
				AND language_string.text NOT LIKE '%(Interim Only)%'
				AND item.status <> 'SUSPENDED' AND item.status <> 'DELETED'
				AND cast((xpath('//xml/item/curriculum/assessment/SAMs/labels/label/year/text()', xmlparse(CONTENT item_xml.xml)))[1] as text)::int = ?
				AND cast((xpath('//xml/item/curriculum/topics/topic/org_unit/text()', xmlparse(CONTENT item_xml.xml)))[1] as text)::text = ?
				ORDER BY avail_ref";

		$query = $this->eq_db->query($sql, array($collection_uuid, $avail_year, $org_num));
		$results = $query->result_array();
		return $results;	
	}
	
	function postgre_db_get_SAMs_by_discipline($collection_uuid, $avail_year, $dis)
	{
		/*$sql = "SELECT UNNEST((xpath('//xml/item/curriculum/avails/avail/@avail_ref', XMLPARSE(CONTENT item_xml.xml))))::text avail_ref,
					   item.uuid as item_uuid, 
					   item.version as item_version, 
					   initcap(item.status) as status, 
					   (select url from institution) || 'items/' || item.uuid || '/' || item.version flex_link
				FROM item
				JOIN item_xml on item.item_xml_id = item_xml.id
				JOIN item_definition on item.item_definition_id = item_definition.id
				JOIN base_entity on base_entity.id = item_definition.id
				JOIN language_string ON language_string.bundle_id = item.name_id
				WHERE base_entity.uuid = ?
				AND language_string.text NOT LIKE '%(Interim Only)%'
				AND item.status <> 'SUSPENDED' AND item.status <> 'DELETED'
				AND cast((xpath('//xml/item/curriculum/assessment/SAMs/labels/label/year/text()', xmlparse(CONTENT item_xml.xml)))[1] as text)::int = ?
				AND substr(cast((xpath('//xml/item/curriculum/topics/topic/code/text()', xmlparse(CONTENT item_xml.xml)))[1] as text), 1, 4) = ?
				ORDER BY avail_ref";*/
				
		$sql = "SELECT UNNEST((xpath('//xml/item/curriculum/avails/avail/@avail_ref', XMLPARSE(CONTENT item_xml.xml))))::text avail_ref,
					   item.uuid as item_uuid, 
					   item.version as item_version, 
					   initcap(item.status) as status, 
					   (select url from institution) || 'items/' || item.uuid || '/' || item.version flex_link
				FROM item
				JOIN item_xml on item.item_xml_id = item_xml.id
				JOIN item_definition on item.item_definition_id = item_definition.id
				JOIN base_entity on base_entity.id = item_definition.id
				JOIN language_string ON language_string.bundle_id = item.name_id
				WHERE base_entity.uuid = ?
				AND language_string.text NOT LIKE '%(Interim Only)%'
				AND item.status <> 'SUSPENDED' AND item.status <> 'DELETED'
				
				AND substr(cast((xpath('//xml/item/curriculum/topics/topic/code/text()', xmlparse(CONTENT item_xml.xml)))[1] as text), 1, 4) = ?
				ORDER BY avail_ref";

		$query = $this->eq_db->query($sql, array($collection_uuid,$dis));
		
		//echo $sql; 
		$results = $query->result_array();
		
		
		return $results;	
	}
	
	function postgre_db_get_SAMs_by_school($collection_uuid, $org_num, $year)
	{
		$sql = "SELECT
					item_id,
					sam_name,
					initcap(status) status,
					item_uuid,
					item_version,
					topic_level,
					topic_code,
					topic_coords,
					assess_no,
					CAST((xpath('//name/text()', xmlparse(CONTENT assess_node.assessment_list)))[1] AS text)
					assessment_name,
					CAST((xpath('//format/text()', xmlparse(CONTENT assess_node.assessment_list)))[1] AS text)
					format,
					CAST((xpath('//proportion/text()', xmlparse(CONTENT assess_node.assessment_list)))[1] AS text)
					proportion,
					CAST((xpath('//deadline/text()', xmlparse(CONTENT assess_node.assessment_list)))[1] AS text)
					deadline,
					CAST((xpath('//penalties/text()', xmlparse(CONTENT assess_node.assessment_list)))[1] AS text)
					penalties,
					CAST((xpath('//return_date/text()', xmlparse(CONTENT assess_node.assessment_list)))[1] AS text)
					return_date,
					date_modified
					FROM
					(
						SELECT
							item.id              item_id,
							language_string.TEXT sam_name,
							item.status          status,
							item.uuid            item_uuid,
							item.version         item_version,
							CAST((xpath('//xml/item/curriculum/topics/topic/level/text()', xmlparse(CONTENT
							item_xml.xml)))[1] AS text) topic_level,
							array_to_string((xpath('//xml/item/curriculum/topics/topic/code/text()', xmlparse
							(CONTENT item_xml.xml))),',') topic_code,
							generate_subscripts(xpath('//xml/item/curriculum/assessment/a_items/a_item/name/text()'
							, xmlparse(CONTENT item_xml.xml)), 1) AS assess_no,
							unnest((xpath('//xml/item/curriculum/assessment/a_items/a_item', xmlparse(CONTENT
							item_xml.xml)))) assessment_list,
							array_to_string((xpath('//xml/item/curriculum/people/coords/coord/name_display/text()', xmlparse(CONTENT item_xml.xml))), '|')  topic_coords,
							item.date_modified
						FROM
							item
						JOIN
							item_xml
						ON
							item.item_xml_id = item_xml.id
						JOIN
							item_definition
						ON
							item.item_definition_id = item_definition.id
						JOIN
							base_entity
						ON
							base_entity.id = item_definition.id
						JOIN
							language_string
						ON
							language_string.bundle_id = item.name_id
						WHERE
							base_entity.uuid = ?
						AND CAST((xpath('//xml/item/curriculum/topics/topic/org_unit/text()', xmlparse(CONTENT
							item_xml.xml)))[1] AS text) = ?
						AND CAST((xpath('//xml/item/curriculum/avails/avail/year/text()', xmlparse(CONTENT
							item_xml.xml)))[1] AS text)::INT = ?) AS assess_node
				ORDER BY
					sam_name,
					topic_code,
					assess_no";
				
		$query = $this->eq_db->query($sql, array($collection_uuid, $org_num, $year));
		
		//echo $sql; 
		$results = $query->result_array();
		
		
		return $results;	
			
	}
	
	private function return_sql_by_yr($avail_year_from, $avail_year_to)
	{
		$sql = '';
		$next_year = intval(date('Y')) + 1; 
		if($avail_year_to == 'missed')
		{
			$from = intval($avail_year_from);
			if($from >= 2013 && $from < $next_year)
			{
				$sql .= " WHERE avail_yr = " . $avail_year_from;
			}
		}
		else
		{
			$from = intval($avail_year_from);
			$to = intval($avail_year_to);
			if($from >= 2013 && $to > $from && $to <= $next_year)
			{
				$sql .= " WHERE avail_yr = " . $avail_year_to;
				for($i = $to - 1; $i >= $from; $i--)
				{
					$sql .= " OR avail_yr = " . (string)$i;
				}
			}
		}
		
		return $sql;
	}
	


	
}



