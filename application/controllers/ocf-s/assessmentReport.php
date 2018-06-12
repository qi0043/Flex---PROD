<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AssessmentReport extends CI_Controller {
	
	public function index($itemUuid='missed', $version='missed')
	{
		$errdata['heading'] = "Error";
		if($this->validate_params($itemUuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
		 $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
        
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }    
        
        $success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        
        #echo "<pre>";
        #print_r($response);
        #echo "</pre>";
        #log_message('error', htmlentities($response['metadata']));
        
        $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));
        
        if(!$this->itemIsSam($this->xmlwrapper))
        {
            $errdata['message'] = "Item is not SAM";
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
       
        $sam_array = $this->Assessment2Array($this->xmlwrapper);
        
       // $sam_array['status'] = $response['status'];
	   #log_message('error', $response['status']);	
        
       #echo'<pre>';
       #echo 'response================<br>';
       #print_r($response);
	   #echo 'sam-array===============<br>';
       #print_r($sam_array);
	   #echo 'responsemetadata========<br>';
       #echo (string)$response['metadata'];
       #echo'</pre><br><hr/>';
        
        /*
        if($this->xmlwrapper->num_node_notfound > 7)
        {
            $errdata['message'] = "Metadata missing";
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        */
        $data = array('sam_array' => $sam_array);
	
        $data['sam_array']['avail_ref'] = $avail_ref;
        $data['sam_array']['avail_ver'] = $avail_ver;
        
		
	}
	

     /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
	protected function Assessment2Array($itemXml) 
    {
       $tmp = array();
	   $topicTitle = '/xml/item/curriculum/topics/topic/name';
	   $topicCode = '/xml/item/curriculum/topics/topic/code';
	   //$activityType = '/xml/item/curriculum/activities/activity/@type';
	   	   
	   $tmp['title'] = $itemXml->nodeValue($topicTitle);
	   $tmp['code'] = $itemXml->nodeValue($topicCode);
	  // $tmp['activityType'] = $itemXml->nodeValue($activityType);
	   
	   $tmp['assessment_num'] = $itemXml->numNodes('/xml/item/curriculum/assessment/a_items/a_item'); 
	   
	   //assessments
	   for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/assessment/a_items/a_item');  $i++) {
			
			$sys_id = '/xml/item/curriculum/assessment/a_items/a_item['.$i.']/@sys_id';
			$tmp['assessment'][$i]['sys_id'] = $itemXml->nodeValue($sys_id);
			$name = '/xml/item/curriculum/assessment/a_items/a_item['.$i.']/name';
			$tmp['assessment'][$i]['name'] = $itemXml->nodeValue($name);
			$format = '/xml/item/curriculum/assessment/a_items/a_item['.$i.']/format';
			$tmp['assessment'][$i]['format'] = $itemXml->nodeValue($format);
			$deadline = '/xml/item/curriculum/assessment/a_items/a_item['.$i.']/deadline';
			$tmp['assessment'][$i]['deadline'] = $itemXml->nodeValue($deadline);
			$penalties = '/xml/item/curriculum/assessment/a_items/a_item['.$i.']/penalties';
			$tmp['assessment'][$i]['penalties'] = $itemXml->nodeValue($penalties);
			$return_date = '/xml/item/curriculum/assessment/a_items/a_item['.$i.']/return_date';
			$tmp['assessment'][$i]['return_date'] = $itemXml->nodeValue($return_date);
			//get course learning outcome & assessment alignment
			$tmp['course_outcome_num'] = $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo');
			$course_index = 0;
	   	    for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo');  $j++) {
				
				for ($x = 1; $x <= $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo['.$j.']/aligned/a_items/a_item');  $x++) {
					$aligned_topic_sysid = '/xml/item/curriculum/outcomes/course/los/lo['.$j.']/aligned/a_items/a_item['.$x.']/@sys_id';
					if($aligned_topic_sysid==$sys_id)
					{   
						$course_index ++;
						$cat_code = '/xml/item/curriculum/outcomes/course/los/lo['.$j.']/@cat_code';
						$tmp['assessment'][$i]['aligned_course_los'][$course_index]['lo_code'] = $itemXml->nodeValue($cat_code);
						$cat_name = '/xml/item/curriculum/outcomes/course/los/lo['.$j.']/@cat_name';
						$tmp['assessment'][$i]['aligned_course_los'][$course_index]['lo_name'] = $itemXml->nodeValue($cat_name);
						$course_id = '/xml/item/curriculum/outcomes/course/los/lo['.$j.']/@sys_id';
						$tmp['assessment'][$i]['aligned_course_los'][$course_index]['lo_id'] = $itemXml->nodeValue($course_id);
						$course_code = '/xml/item/curriculum/outcomes/course/los/lo['.$j.']/code';
						$tmp['assessment'][$i]['aligned_course_los'][$course_index]['lo_code'] = $itemXml->nodeValue($course_code);
						$course_name = '/xml/item/curriculum/outcomes/course/los/lo['.$j.']/name';
						$tmp['assessment'][$i]['aligned_course_los'][$course_index]['lo_name'] = $itemXml->nodeValue($course_name);
						continue;
					}
				}
			}
			//get topic learning outcome & assessment alignment
			$tmp['topic_outcome_num'] = $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo');
			$topic_index = 0;
	   	    for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo');  $j++) {
				
				for ($x = 1; $x <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/aligned/a_items/a_item');  $x++) {
					$aligned_topic_sysid = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/aligned/a_items/a_item['.$x.']/@sys_id';
					if($aligned_topic_sysid==$sys_id)
					{   
						$topic_index ++;
						//$cat_code = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/@cat_code';
						//$tmp['assessment'][$i]['aligned_topic_los'][$topic_index]['cat_code'] = $itemXml->nodeValue($cat_code);
						//$cat_name = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/@cat_name';
						//$tmp['assessment'][$i]['aligned_topic_los'][$topic_index]['cat_name'] = $itemXml->nodeValue($cat_name);
						$lo_id = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/@sys_id';
						$tmp['assessment'][$i]['aligned_topic_los'][$topic_index]['lo_id'] = $itemXml->nodeValue($lo_id);
						$lo_code = '/xml/item/curriculum/outcomes/topiclos/lo['.$j.']/code';
						$tmp['assessment'][$i]['aligned_topic_los'][$topic_index]['lo_code'] = $itemXml->nodeValue($lo_code);
						$lo_name = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/name';
						$tmp['assessment'][$i]['aligned_topic_los'][$topic_index]['lo_name'] = $itemXml->nodeValue($lo_name);
						continue;
					}
				}
			}
			
			//get Professional learning outcome & assessment alignment
			$tmp['prof_outcome_num'] = $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo');
			$prof_index = 0;
	   	    for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo');  $j++) {
				
				for ($x = 1; $x <= $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/aligned/a_items/a_item');  $x++) {
					$aligned_prof_sysid = '/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/aligned/a_items/a_item['.$x.']/@sys_id';
					if($aligned_prof_sysid==$sys_id)
					{   
						$prof_index ++;
						$cat_code = '/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/@cat_code';
						$tmp['assessment'][$i]['aligned_prof_los'][$prof_index]['cat_code'] = $itemXml->nodeValue($cat_code);
						$cat_name = '/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/@cat_name';
						$tmp['assessment'][$i]['aligned_prof_los'][$prof_index]['cat_name'] = $itemXml->nodeValue($cat_name);
						$lo_id = '/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/@sys_id';
						$tmp['assessment'][$i]['aligned_prof_los'][$prof_index]['lo_id'] = $itemXml->nodeValue($lo_id);
						$lo_code = '/xml/item/curriculum/outcomes/proflos/lo['.$j.']/code';
						$tmp['assessment'][$i]['aligned_prof_los'][$prof_index]['lo_code'] = $itemXml->nodeValue($lo_code);
						$lo_name = '/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/name';
						$tmp['assessment'][$i]['aligned_prof_los'][$prof_index]['lo_name'] = $itemXml->nodeValue($lo_name);
						continue;
					}
				}
			}
	   }

	   echo " Assessment Items: <pre>";                                 
	    print_r($tmp);
		echo "<pre>";
		exit;
       return $tmp;
    }
	
     /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
	 
    protected function itemXml2Array($itemXml) 
    {		
		$tmp = array();
	   // $activityType = '/xml/item/curriculum/activities/activity/@type';
	   //$tmp['numActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_actvities/uuid');
	   
	   	// Put the linked activity uuids into an array
		
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');  $i++) 
		{
			$uuid = '/xml/item/curriculum/activities/linked_activities/uuid['.$i.']';
			$tmp[$i]['uuid'] = $itemXml->nodeValue($uuid);
		}
        return $tmp;
    }
	
	/**
     * Validate incoming parameters
     *
     * @param array $uuid, item UUID
     * @param array $version, item Version
     */
    protected function validate_params($uuid, $version)
    {
        if(strcmp($uuid, 'missed')==0 || strlen($uuid) != 36)
            return false;
        
        if(strcmp($version, 'missed')==0 || !is_numeric($version))
            return false;
        
        return true;
    }
	  /**
     * Check whether the item has a type of SAM
     *
     * @param xmlwrapper $itemXml
     */
    protected function itemIsSam($itemXml) 
    { 
		$type = '/xml/item/curriculum/@item_type';

        $itemissam = $itemXml->nodeValue($type);
		$itemissam = 'SAM';
        if(isset($itemissam) && $itemissam == 'SAM')
            return true;
        return false;
    }
} 