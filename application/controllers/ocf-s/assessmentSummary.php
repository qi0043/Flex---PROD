<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AssessmentSummary extends CI_Controller {
	
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
        
        $success = $this->flexrest->getItem($itemUuid, $version, $response);
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
		$sam_array['sam_item_uuid'] = $itemUuid;
		$sam_array['sam_version'] = $version;
		/*$sam_array['item_uuid'] = $response['uuid'];
		$sam_array['version'] = $response['version'];
		$sam_array['description'] = $response['description'];
		$sam_array['sam_name'] = $response['name'];*/
       
       // $sam_array['status'] = $response['status'];
		#log_message('error', $response['status']);	
        
      /* echo'<pre>';
       echo 'response================<br>';
       print_r($response);
	   #echo 'sam-array===============<br>';
       #print_r($sam_array);
	   #echo 'responsemetadata========<br>';
       #echo (string)$response['metadata'];
       echo'</pre><br><hr/>';*/
	   
	   $topic_code = $sam_array['code'];
	   $ci =& get_instance();
	   $ci->load->config('flex');
	   $topic_info_collection_uuid = $ci->config->item('topic_information_collection');
   
	    $where = "/xml/item/curriculum/topics/topic/code='" . $topic_code."' AND ";
		$where = $where . "/xml/item/@itemstatus='live'";
		$where = urlencode($where);
		//generate temp access token
		$success = $this->flexrest->processClientCredentialToken();
		$errdata['heading'] = "Error";
		if(!$success)
		{
			$errdata['message'] = $this->flexrest->error;
			$this->load->view('ocf/showerror_view', $errdata);
			return;
		}  
		if($success)
		{	//echo $depth;
			$searchsuccess = $this->flexrest->search($topic_info_response, '', $topic_info_collection_uuid , $where, 0, 1, 'name', false, 'all', false);
		
			if(!$searchsuccess)
			{
				$errdata['message'] = $this->flexrest->error;
				$this->load->view('ocf/showerror_view', $errdata);
				return;
			}
			if(isset($topic_info_response['results'][0]['uuid']))
				$sam_array['topic_info_uuid'] = $topic_info_response['results'][0]['uuid'];
			if(isset($topic_info_response['results'][0]['version']))
				$sam_array['topic_info_version'] = $topic_info_response['results'][0]['version'];
		}
			   
	   
        $data = array('sam_array' => $sam_array);
	 
       echo'<pre>';
       echo '=================sam assessment array================<br>';
       print_r($data);
       echo'</pre>';
	   
	  $this->load->view('ocf/assessment_report', $data);
	}
	

     /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
	protected function Assessment2Array($itemXml) 
    {
       $tmp = array();
	   $item_name = '/xml/item/itembody/name';
	   $topicTitle = '/xml/item/curriculum/topics/topic/name';
	   $topicCode = '/xml/item/curriculum/topics/topic/code';
	   //$activityType = '/xml/item/curriculum/activities/activity/@type';
	   $tmp['sam_name'] = $itemXml->nodeValue($item_name);
	   $tmp['title'] = $itemXml->nodeValue($topicTitle);
	   $tmp['code'] = $itemXml->nodeValue($topicCode);
	  // $tmp['activityType'] = $itemXml->nodeValue($activityType);
	   
	   $tmp['assessment_num'] = $itemXml->numNodes('/xml/item/curriculum/assessment/a_items/a_item'); 
	  
	   //assessments
	   for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/assessment/a_items/a_item');  $i++) {
			
			$id = '/xml/item/curriculum/assessment/a_items/a_item['.$i.']/@sys_id';
			$sys_id = $itemXml->nodeValue($id);
			$tmp['assessment'][$i]['sys_id'] = $sys_id;
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
			//$tmp['course_outcome_num'] = $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo');
			$course_index = 0;
	   	    for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo');  $j++) {
				
				for ($x = 1; $x <= $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo['.$j.']/aligned/a_items/a_item');  $x++) {
					$id = '/xml/item/curriculum/outcomes/course/los/lo['.$j.']/aligned/a_items/a_item['.$x.']/@sys_id';
					$aligned_topic_sysid = $itemXml->nodeValue($id);
					if($aligned_topic_sysid == $sys_id)
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
						
					}
				}
			}
			$tmp['aligned_course_los_num']= $course_index ;
			
			//get topic learning outcome & assessment alignment
			//$tmp['topic_outcome_num'] = $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo');
			$topic_index = 0;
	   	    for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo');  $j++) {
				
				for ($x = 1; $x <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/aligned/a_items/a_item');  $x++) {
					$id =  '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/aligned/a_items/a_item['.$x.']/@sys_id';
					$aligned_topic_sysid = $itemXml->nodeValue($id);
					//$tmp['assessment'][$i]['aligned_topic_los'][$topic_index]['lo_id'] = $aligned_topic_sysid;
					if($aligned_topic_sysid == $sys_id)
					{   
						$topic_index ++;
						//$cat_code = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/@cat_code';
						//$tmp['assessment'][$i]['aligned_topic_los'][$topic_index]['cat_code'] = $itemXml->nodeValue($cat_code);
						//$cat_name = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/@cat_name';
						//$tmp['assessment'][$i]['aligned_topic_los'][$topic_index]['cat_name'] = $itemXml->nodeValue($cat_name);
						$lo_id = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/@sys_id';
						$tmp['assessment'][$i]['aligned_topic_los'][$topic_index]['lo_id'] = $itemXml->nodeValue($lo_id);
						$lo_code = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/code';
						$tmp['assessment'][$i]['aligned_topic_los'][$topic_index]['lo_code'] = $itemXml->nodeValue($lo_code);
						$lo_name = '/xml/item/curriculum/outcomes/topic/los/lo['.$j.']/name';
						$tmp['assessment'][$i]['aligned_topic_los'][$topic_index]['lo_name'] = $itemXml->nodeValue($lo_name);
						
					}
				}
				
			}
			$tmp['aligned_topic_los_num']= $topic_index;
			
			//get Professional learning outcome & assessment alignment
			//$tmp['prof_outcome_num'] = $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo');
			$prof_index = 0;
	   	    for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo');  $j++) {
				
				for ($x = 1; $x <= $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/aligned/a_items/a_item');  $x++) {
					$id = '/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/aligned/a_items/a_item['.$x.']/@sys_id';
					$aligned_prof_sysid = $itemXml->nodeValue($id);
					//$tmp['assessment'][$i]['aligned_prof_los'][$prof_index]['lo_id'] = $aligned_prof_sysid;
					if($aligned_prof_sysid==$sys_id)
					{   
						$prof_index ++;
						$cat_code = '/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/@cat_code';
						$tmp['assessment'][$i]['aligned_prof_los'][$prof_index]['cat_code'] = $itemXml->nodeValue($cat_code);
						$cat_name = '/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/@cat_name';
						$tmp['assessment'][$i]['aligned_prof_los'][$prof_index]['cat_name'] = $itemXml->nodeValue($cat_name);
						$lo_id = '/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/@sys_id';
						$tmp['assessment'][$i]['aligned_prof_los'][$prof_index]['lo_id'] = $itemXml->nodeValue($lo_id);
						$lo_code = '/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/code';
						$tmp['assessment'][$i]['aligned_prof_los'][$prof_index]['lo_code'] = $itemXml->nodeValue($lo_code);
						$lo_name = '/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/name';
						$tmp['assessment'][$i]['aligned_prof_los'][$prof_index]['lo_name'] = $itemXml->nodeValue($lo_name);
					}
				}
			}
			$tmp['aligned_prof_los_num']= $prof_index ;
	   }

	   /*echo " Assessment Items: <pre>";                                 
	    print_r($tmp);
		echo "<pre>";
		exit;*/
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