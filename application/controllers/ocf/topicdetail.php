<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Topicdetail extends CI_Controller {

	/****
		Parameters:
		@$uuid: item uuid from 'Topic Information collection'
		@$version: item version of the item from 'Topic Information collection'
	****/
	public function index($courseId='missed', $uuid='missed', $version='missed')
	{
		
        $errdata['heading'] = "Error";
        if($this->validate_params($uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
		
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		
		if(!$this -> validate_course_params($courseId))
		{
			$errdata['message'] = 'Invalid course code';
            $this->load->view('ocf/showerror_view', $errdata);
            return;
		}
	
		$this->load->model('ocf/ocf_model');
            
		#check down time before authentication through FLEX
		$down_notice = false;
		$down_notice = $this->ocf_model->db_chk_notice();
		if($down_notice != false)
		{
			#$this->error_info($down_notice['message']);
			if ($down_notice['message'] == '')
				$down_notice['message'] = 'Online Curriculum Framework is temporarily unavailable, please try again later.';
			#echo $down_notice['message'];
			$errdata['message'] = $down_notice['message'];
			//$errdata['heading'] = "Notice";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			return;
		}
		#check course code
		$check_course_code = $this->ocf_model->db_get_courseInfo(strtoupper($courseId));
		if(!$check_course_code)
		{
			$errdata['message'] = 'course code not valid';
			$this->load->view('ocf/showerror_view', $errdata);
			return;
		}
		
		$success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }    
        
        $success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
	
		//Get the topic code from the response from the search
		
		$tcode = substr($response['name'],0,8); 
			
		$xmlwrapper_name = 'xmlwrapper'.'topic';
			
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
		
		if(!$this->itemIsTopic($this->$xmlwrapper_name))
        {
            $errdata['message'] = "Item is not a Topic";
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
			
		$topic_array = $this->topicXml2Array($this->$xmlwrapper_name);
		$topic_array['itemID'] = $response['uuid'];
		
		$itemID = $response['uuid'];
		
		/****************************************************************************/
		
		/* Now find the SAM for this topic                                          */
		
		/****************************************************************************/
		
		// Search variables
        $q = '';
        $start = 0;
        $length = 1;
 		// The SAM collection Uuid
		$ci =& get_instance();
		$ci->load->config('flex');
		$collections = $ci->config->item('sam_collection');
		
        $order = 'name';
        $reverse = false;

        $samwhere = "/xml/item/curriculum/@item_type='SAM'";
	$samwhere .= " AND /xml/item/curriculum/topics/topic/code='".$tcode."'";
	$samwhere .= " AND /xml/item/curriculum/courses/course/code='".strtoupper($courseId)."'";
	#$samwhere .= " AND /xml/item/@itemstatus='live'";
        
        $samwhere = urlencode($samwhere);
		
		//echo "<br /><br /><br />".urldecode($samwhere)."<br /><br />";
		
        $info = 'all';
        $showall = false;

		$searchsuccess = $this->flexrest->search($sam, $q, $collections, $samwhere, $start, $length, $order, $reverse, $info, $showall);

		$xmlwrapper_name = 'xmlwrapper'.'sam';
		/*echo "SAM <pre>";
      	print_r($sam);
        echo "</pre>";	*/
		
		if(isset($sam['results'][0]))
		{       
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$sam['results'][0]['metadata']), $xmlwrapper_name);
			$sam_array = $this->samXml2Array($this->$xmlwrapper_name);
		}
		/* Copy assessment items from sam_array to topic_array */
		
		
		if(isset($sam_array['sam']['los']) && count($sam_array['sam']['los'])>0)
		{
			$loCtr = 0; // learning outcome counter
			foreach ($sam_array['sam']['los'] as $learningObj ) { // loop through the los	
				$loCtr++;
				if(isset($learningObj['aitem']))
				{	$aCtr = 0; //assessment counter
					foreach ($learningObj['aitem'] as $item) {				
						//echo $item['aItemID'];				
						$aCtr++;
						$topic_array['topic']['los']['lo'.$loCtr]['assessment']['aitem'.$aCtr]['sysid'] = $item['aItemID'];
						$topic_array['topic']['los']['lo'.$loCtr]['assessment']['aitem'.$aCtr]['name'] = $item['aname'];
						
					}	
					unset($aCtr);
				}
			} // end foreach $sam_array['los'] as $learningOb
			unset($loCtr);
		}
		if(isset($sam_array['sam']['name']))
		{
			$topic_array['sam_name'] = $sam_array['sam']['name'];
		}
		/****************************************************************************/
		
		/* Now find the Topic Availabilities Activities (TAA) for this topic                                          */
		
		/****************************************************************************/
		
		// Search variables
        $q = '';
        $start = 0;
        $length = 1;

		$collections = $ci->config->item('taa_collection');
        $order = 'name';
        $reverse = false;

        $taawhere = "/xml/item/curriculum/@item_type='TAA'";
	$taawhere .= " AND /xml/item/curriculum/topics/topic/code='".$tcode."'";
	$taawhere .= " AND /xml/item/curriculum/courses/course/code='".strtoupper($courseId)."'";
        $taawhere = urlencode($taawhere);
		
		//echo "<br /><br /><br />".urldecode($taawhere)."<br /><br />";
		//exit;
		
        $info = 'all';
        $showall = false;

		$taasuccess = $this->flexrest->search($taa, $q, $collections, $taawhere, $start, $length, $order, $reverse, $info, $showall);
	
		$xmlwrapper_name = 'xmlwrapper'.'taa';
		
		if(isset($taa['results'][0]['metadata']))
		{	
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$taa['results'][0]['metadata']), $xmlwrapper_name);
		$taa_array = $this->taaXml2Array($this->$xmlwrapper_name);
		
		
		/* Copy assessment items from sam_array to topic_array */
		
		$loCtr = 0; // learning outcome counter
		/*echo '<pre>';
		print_r($taa_array['taa']['los']);
		echo '</pre>';*/
		foreach ($taa_array['taa']['los'] as $activity ) { // loop through the los
			
			$loCtr++;
			if(isset($activity['actitem']))
			{
				$aCtr = 0; //activity counter
				foreach ($activity['actitem'] as $item) {
					//echo $item['actItemID'];
					$aCtr++;		
					$topic_array['topic']['los']['lo'.$loCtr]['activities']['actitem'.$aCtr]['sysid'] = $item['actItemID'];
					$topic_array['topic']['los']['lo'.$loCtr]['activities']['actitem'.$aCtr]['name'] = $item['actname'];
				}
				unset($aCtr);
			}	
		} // end foreach $taa_array['los'] as $learningOb
		if(isset($taa_array['taa']['name']))
		{
			$topic_array['taa_name'] = $taa_array['taa']['name'];
		}

		}

		//if ($_SERVER['REMOTE_ADDR'] == '10.26.21.73') {
		/*
			echo "<h2>Topic Info data array</h2>";
			
		echo "<pre>";
      	print_r($topic_array);
       	echo "</pre>";
	
		echo "<h2>TAA data array</h2>";
			
		echo "<pre>";
      	print_r($taa_array);
		
        echo "</pre>";	
		
		echo "<h2>SAM data array</h2>";
			
		echo "<pre>";
      	print_r($sam_array);

		echo "<h2>Topic Info data array</h2>";
			
		echo "<pre>";
      	print_r($topic_array);
       	echo "</pre>";
				
		echo "<h2>SAM data array</h2>";
			
		echo "<pre>";
      	print_r($sam_array);
        echo "</pre>";
		
		echo "<h2>TAA data array</h2>";
			
		echo "<pre>";
      	print_r($taa_array);
		
        echo "</pre>";
   
	    exit;
		*/	
		//}
                #log_message('error', print_r($topic_array,true));
		$data = array('topics' => $topic_array);
		$data['courses']['code']=$courseId;
		/*echo "<pre>";
      	print_r($data);
        echo "</pre>";*/
		$this->load->view('ocf/topicview', $data);	
		}
	
	
	
	    /**
     * Check whether the item has a type of Topic Information
     *
     * @param xmlwrapper $itemXml
     */
    protected function itemIsTopic($itemXml) 
    { 

        $type = '/xml/item/curriculum/@item_type';
        $itemistopic = $itemXml->nodeValue($type);
        if(isset($itemistopic) && $itemistopic=='Topic Information')
            return true;
        return false;
    }
	

 /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function topicXml2Array($itemXml) 
    { 
		
		// loop through related topics
		//echo "Number of topic in topics: ". $itemXml->numNodes('/xml/item/curriculum/topics/topic') . "<br />";

        $tmp['tcode'] = '';
		$tmp['topicTitle'] = '';
		
		$tmp['newTcode'] = '';
		
		$ctr = 0; //set a counter
		
		for ($t = 1; $t <= $itemXml->numNodes('/xml/item/curriculum/topics/topic'); $t++) 
		{
		
			$topicCode = '/xml/item/curriculum/topics/topic['.$t.']/code';
			$topicTitle = '/xml/item/curriculum/topics/topic['.$t.']/name';
			
			if ($ctr >= 1) { $tmp['topicTitle'] .= ', ';  $tmp['tcode'] .= ' '; }
			
			$tmp['tcode'] .= $itemXml->nodeValue($topicCode);
			$tmp['topicTitle'] .= $itemXml->nodeValue($topicTitle);
	
			$tcode = $itemXml->nodeValue($topicCode);
			
			$ctr++; // increment the counter

		}
		$courseCode = '/xml/item/curriculum/courses/course/code';	
		$topicDescription = '/xml/item/curriculum/topics/topic/description';	
		$outcomeIntro = '/xml/item/curriculum/outcomes/topic/intro';
		
		$tmp['courseCode'] = $itemXml->nodeValue($courseCode);
		$tmp['description'] = $itemXml->nodeValue($topicDescription);
		$tmp['ocIntro'] = $itemXml->nodeValue($outcomeIntro);
	
		$numTopicLOS = $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo');
		$numCourseLOS = $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo');
		$numAmcLOS = $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo');
	
		/*
		echo "Topic LOs = ".$numTopicLOS."<br />";
		echo "Course LOs = ".$numCourseLOS."<br />";
		echo "AMC LOs = ".$numAmcLOS."<br />";
		*/
		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo'); $i++) {
			
			$loSysID = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/@sys_id';
            $loName = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/name';
            $loCode = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/code';
			
			$tmp['topic']['los']['lo'.$i]['loSysID'] = $itemXml->nodeValue($loSysID);
            $tmp['topic']['los']['lo'.$i]['name'] = $itemXml->nodeValue($loName);
			$tmp['topic']['los']['lo'.$i]['code'] = $itemXml->nodeValue($loCode);
			
			$loCode = $itemXml->nodeValue($loCode);
			
			// Array to set Flinders Medical Graduate Outcomes

			for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo'); $j++) {

				$numaligned = $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo['.$j.']/aligned/topic/los/lo');
	
				if ($numaligned > 0) {
					
					for ($k=1; $k <= $numaligned; $k++ ) {
					
						$topicloCode = '/xml/item/curriculum/outcomes/course/los/lo['.$j.']/aligned/topic/los/lo['.$k.']/code';
						$tloCode = $itemXml->nodeValue($topicloCode);
						
						//echo "tlo code: ".$tloCode;
						//echo " lo code: ".$loCode;
						//echo "<br />";						
						if ($tloCode == $loCode) {
							
							$courseloCatCode = '/xml/item/curriculum/outcomes/course/los/lo['.$j.']/@cat_code';
							$courseloSysID = '/xml/item/curriculum/outcomes/course/los/lo['.$j.']/@sys_id';
							$courseloCode = '/xml/item/curriculum/outcomes/course/los/lo['.$j.']/code';
							$courseloName = '/xml/item/curriculum/outcomes/course/los/lo['.$j.']/name';
						
							$tmp['topic']['los']['lo'.$i]['course']['lo'.$j]['catcode'] = $itemXml->nodeValue($courseloCatCode);
							$tmp['topic']['los']['lo'.$i]['course']['lo'.$j]['sysid'] = $itemXml->nodeValue($courseloSysID);
							$tmp['topic']['los']['lo'.$i]['course']['lo'.$j]['code'] = $itemXml->nodeValue($courseloCode);
							$tmp['topic']['los']['lo'.$i]['course']['lo'.$j]['name'] = $itemXml->nodeValue($courseloName);
						
						}
					}	
				}
				
			}  // end of Flinders Medical Graduate Outcomes

		// Array to set AMC Graduate Outcomes
		
			for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo'); $j++) {
			
				$numaligned = $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/aligned/topic/los/lo');
		
				if ($numaligned > 0) {
					
					for ($k=1; $k <= $numaligned; $k++ ) {
						
						$topicloCode = '/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/aligned/topic/los/lo['.$k.']/code';
						$tloCode = $itemXml->nodeValue($topicloCode);
						
						//echo "tlo code: ".$tloCode;
						//echo " lo code: ".$loCode;
						//echo "<br />";
						
						if ($tloCode == $loCode) {
							$courseloCatCode = '/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/@cat_code';
							$courseloSysID = '/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/@sys_id';
							$courseloCode = '/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/code';
							$courseloName = '/xml/item/curriculum/outcomes/prof/los/lo['.$j.']/name';
						
							$tmp['topic']['los']['lo'.$i]['prof']['lo'.$j]['catcode'] = $itemXml->nodeValue($courseloCatCode);
							$tmp['topic']['los']['lo'.$i]['prof']['lo'.$j]['sysid'] = $itemXml->nodeValue($courseloSysID);
							$tmp['topic']['los']['lo'.$i]['prof']['lo'.$j]['code'] = $itemXml->nodeValue($courseloCode);
							$tmp['topic']['los']['lo'.$i]['prof']['lo'.$j]['name'] = $itemXml->nodeValue($courseloName);
					
						}
						
					}
					
				}
				
			}  // end of AMC Graduate Outcom		
			
		} // end of $i loop
		/*echo " Topic Array <pre>";
      	print_r($tmp);
        echo "</pre>";	
		exit;*/
        return $tmp;
    }


    /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    private function samXml2Array($itemXml) 
    {
		$sam_name = '/xml/item/itembody/name';
		$tmp['sam']['name'] = $itemXml->nodeValue($sam_name);
        $topicVersion = '/xml/item/curriculum/assessment/SAMs/version_definition';
		$tmp['sam']['version'] = $itemXml->nodeValue($topicVersion);
		
    	
		// Aligned Topic LO assessments
			for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo'); $i++) {
				
				$loSysID = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/@sys_id';
            	$loName = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/name';
            	$loCode = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/code';
			
				$tmp['sam']['los']['lo'.$i]['loSysID'] = $itemXml->nodeValue($loSysID);
            	$tmp['sam']['los']['lo'.$i]['name'] = $itemXml->nodeValue($loName);
				$tmp['sam']['los']['lo'.$i]['code'] = $itemXml->nodeValue($loCode);
		
				$numaligned = $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/aligned/a_items/a_item');
				
				$tmp['sam']['los']['lo'.$i]['numAligned'] = $numaligned;
				
				for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/aligned/a_items/a_item'); $j++) {
					
					$aItemID = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/aligned/a_items/a_item['.$j.']/@sys_id';
            		$aName = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/aligned/a_items/a_item['.$j.']/name';
					
					$tmp['sam']['los']['lo'.$i]['aitem'][$j]['aItemID'] = $itemXml->nodeValue($aItemID);
            		$tmp['sam']['los']['lo'.$i]['aitem'][$j]['aname'] = $itemXml->nodeValue($aName);
					
					//$tmp['topic']['los']['lo'.$i]['assessment']['aitem'.$j]['aItemID'] = $itemXml->nodeValue($aItemID);
            		//$tmp['topic']['los']['lo'.$i]['assessment']['aitem'.$j]['aname'] = $itemXml->nodeValue($aName);			
				}			
			}
		
		// Aligned Professional LO assessments
		
		
			for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo'); $i++) {
				
				$loSysID = '/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/@sys_id';
            	$loName = '/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/name';
            	$loCode = '/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/code';
			
				$tmp['sam']['prof']['lo'.$i]['loSysID'] = $itemXml->nodeValue($loSysID);
            	$tmp['sam']['prof']['lo'.$i]['name'] = $itemXml->nodeValue($loName);
				$tmp['sam']['prof']['lo'.$i]['code'] = $itemXml->nodeValue($loCode);
		
				$numaligned = $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/aligned/a_items/a_item');
				
				$tmp['sam']['prof']['lo'.$i]['numAligned'] = $numaligned;
				
				for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/aligned/a_items/a_item'); $j++) {
					
					$aItemID = '/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/aligned/a_items/a_item['.$j.']/@sys_id';
            		$aName = '/xml/item/curriculum/outcomes/prof/los/lo['.$i.']/aligned/a_items/a_item['.$j.']/name';
					$tmp['sam']['prof']['lo'.$i]['aitem'][$j]['aItemID'] = $itemXml->nodeValue($aItemID);
            		$tmp['sam']['prof']['lo'.$i]['aitem'][$j]['aname'] = $itemXml->nodeValue($aName);
					//$tmp['topic']['los']['lo'.$i]['assessment']['aitem'.$j]['aItemID'] = $itemXml->nodeValue($aItemID);
            		//$tmp['topic']['los']['lo'.$i]['assessment']['aitem'.$j]['aname'] = $itemXml->nodeValue($aName);
				}
				
			}
		/*echo " SAM Array <pre>";
      	print_r($tmp);
        echo "</pre>";	
		exit;*/
        return $tmp;

    }

 /**
     * Extract XML data for TAAs and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function taaXml2Array($itemXml) 
    {
		$taa_name = '/xml/item/itembody/name';
		$tmp['taa']['name'] = $itemXml->nodeValue($taa_name);
		
        $topicVersion = '/xml/item/curriculum/activities/TAA/linked_topic/version';
		$tmp['taa']['version'] = $itemXml->nodeValue($topicVersion);

		for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo'); $i++) {
			
			$loSysID = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/@sys_id';
			$loName = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/name';
			$loCode = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/code';
	
			$tmp['taa']['los']['lo'.$i]['loSysID'] = $itemXml->nodeValue($loSysID);
			$tmp['taa']['los']['lo'.$i]['name'] = $itemXml->nodeValue($loName);
			$tmp['taa']['los']['lo'.$i]['code'] = $itemXml->nodeValue($loCode);
			$numaligned = $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/aligned/act_items/act_item');
			$tmp['taa']['los']['lo'.$i]['numAligned'] = $numaligned;
	
			for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/aligned/act_items/act_item'); $j++) {
				
				$aItemID = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/aligned/act_items/act_item['.$j.']/@sys_id';
				$aName = '/xml/item/curriculum/outcomes/topic/los/lo['.$i.']/aligned/act_items/act_item['.$j.']/name';
				
				
				$tmp['taa']['los']['lo'.$i]['actitem'][$j]['actItemID'] = $itemXml->nodeValue($aItemID);
				$tmp['taa']['los']['lo'.$i]['actitem'][$j]['actname'] = $itemXml->nodeValue($aName);
			}
		}
        return $tmp;
    }


    /**
     * Validate incoming parameters
     *
     * @param string $format, html/pdf
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
     * Validate incoming parameters
     *
     * @param string $coursecode
     */
    private function validate_course_params($courseCode)
    {

        if(strcmp($courseCode, 'missed')==0 ||is_numeric($courseCode) )
		{
            return false;
		}
        return true;
    }
} 
