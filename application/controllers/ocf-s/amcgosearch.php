<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Amcgosearch extends CI_Controller {

    public function index($courseId='missed', $arg_locode='missed')
    {
		$errdata['heading'] = "Error";
		$this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		
		if(!$this -> validate_params($courseId))
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
		
		
		// Search variables
		$q = '';
		$start = 0;
		$length = 50;
		
		$ci =& get_instance();
		$ci->load->config('flex');
		$collections= $ci->config->item('topic_information_collection'); // The Topic Information collection uuid 

		$order = 'name';
		$reverse = false;

        $where = "/xml/item/curriculum/@item_type='Topic Information' ";
        $where .= "AND /xml/item/curriculum/courses/course/code='".strtoupper($courseId)."' ";

        $where = urlencode($where);

        $info = 'metadata';
        $showall = true;
        
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }  

        $searchsuccess = $this->flexrest->search($response, $q, $collections, $where, $start, $length, $order, $reverse, $info, $showall);

        if(!$searchsuccess)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }

		//echo "Search success! <br />";
		
		// Topic info search
		
		
		// Search variables
        $q = '';
        $start = 0;
        $length = 50;

        $collections= $ci->config->item('sam_collection');  // The SAM collection

        $order = 'name';
        $reverse = false;

        $samwhere = "/xml/item/curriculum/@item_type='SAM'";
        $samwhere .= " AND /xml/item/curriculum/courses/course/code='".strtoupper($courseId)."'";

        $samwhere = urlencode($samwhere);

        $info = 'all';
        $showall = false;
		
		$alignedsuccess = $this->flexrest->search($samresponse, $q, $collections, $samwhere, $start, $length, $order, $reverse, $info, $showall);
        
		/****************************************************************************/
		
		/* Now find the Topic Availabilities Activities (TAA) for this topic                                          */
		
		/****************************************************************************/
		
		// Search variables
        $q = '';
        $start = 0;
        $length = 50;

        $collections= $ci->config->item('taa_collection'); // The TAA collection

        $order = 'name';
        $reverse = false;

        $taawhere = "/xml/item/curriculum/@item_type='TAA'";
        $taawhere .= " AND /xml/item/curriculum/courses/course/code='".strtoupper($courseId)."'";
		
        
        $taawhere = urlencode($taawhere);
		
		//echo "<br /><br /><br />".urldecode($taawhere)."<br /><br />";
		
		//exit;
		
        $info = 'all';
        $showall = false;

		$taasuccess = $this->flexrest->search($taa, $q, $collections, $taawhere, $start, $length, $order, $reverse, $info, $showall);
			
		if(!$alignedsuccess)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
		
		//echo "Alignment success!";
		
		//exit;
			
        $topicsdata = array();
        $topicsdata['numTopics'] = intval($response['available']);
		
		$alignedtopics = array();
        $alignedtopics['numTopics'] = intval($samresponse['available']);
		

         #echo "<pre>";print_r($alignedtopics);echo "<pre>";exit();
		
		
		$topic_array = array();

        $topicCount = intval($response['available']);

        for ($i=0; $i < $topicCount; $i++ ) 
		{
            $j = $i + 1;

            $xmlwrapper_name = 'xmlwrapper'.$j;

            $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['results'][$i]['metadata']), $xmlwrapper_name);

            $topic_array[$j] = $this->Xml2Array($this->$xmlwrapper_name, $j, $arg_locode);

            $topic_array[$j]['uuid'] = $response['results'][$i]['uuid'];
            $topic_array[$j]['version'] = $response['results'][$i]['version'];

        }

		$sam_array = array();

        $samTopicCount = intval($samresponse['available']);
		
		#echo "Number of aligned topics = ".$samTopicCount." <br /><br />";
		
		#exit;

        for ($r=0; $r < $samTopicCount; $r++ ) 
		{
            $s = $r + 1;

            $xmlwrapper_name = 'xmlwrapper_sam'.$s;

            $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$samresponse['results'][$r]['metadata']), $xmlwrapper_name);

            $sam_array[$s] = $this->samXml2Array($this->$xmlwrapper_name, $s, $arg_locode);
			$sam_array[$s]['wrapper_name'] = $xmlwrapper_name;
			
			$sam_array[$s]['uuid'] = $samresponse['results'][$r]['uuid'];
            $sam_array[$s]['version'] = $samresponse['results'][$r]['version'];
        }

		
		$taa_array = array();

        $taaTopicCount = intval($taa['available']);
		
		#echo "Number of aligned topics = ".$samTopicCount." <br /><br />";
		
		#exit;
		/*echo 'taa array: <br/>';
		echo '<pre/>';
		print_r($taa);
		echo '<pre/>';*/
		
        for ($t=0; $t < $taaTopicCount; $t++ ) 
		{
            $u = $t + 1;
            $xmlwrapper_name = 'xmlwrapper_taa'.$u;

            $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$taa['results'][$t]['metadata']), $xmlwrapper_name);

            $taa_array[$u] = $this->taaXml2Array($this->$xmlwrapper_name, $u, $arg_locode);
			$taa_array[$u]['wrapper_name'] = $xmlwrapper_name;
			
			$taa_array[$u]['uuid'] = $taa['results'][$t]['uuid'];
            $taa_array[$u]['version'] = $taa['results'][$t]['version'];
        }
		
		/*echo 'taa array: <br/>';
		echo '<pre/>';
		print_r($taa_array);
		echo '<pre/>';
*/
		// Copy assessment items to the topic_array
		
		$topicCtr = 0;
		
		foreach ($topic_array as $topic) 
		{ // loop through the topics
			$topicCtr++;
			//$topic_array[$topicCtr]['prof']['assessment'] = '';
			
			$tcode = trim($topic['code']);
			
			foreach ($sam_array as $sams ) { // loop through the sams
			
			$sam_tcode = trim($sams['code']);
			
			//echo "Topic Counter = ".$topicCtr." :: Topic = ".$tcode." SAM Topic = ".$sam_tcode." <br />";
			
			if ($tcode == $sam_tcode) {  // matching topic, let's do something
			
					
				$topic_array[$topicCtr]['prof']['assessment']['numAssessments'] = $sams['assessAlign'];
				
				if(isset($sams['prof']))
				{
					$aCtr = 0;
					foreach ($sams['prof']['assessment'] as $assessment) {
						$aCtr++;
						$topic_array[$topicCtr]['prof']['assessment']['item'][$aCtr]['sys_id'] = $assessment['sys_id'];
						$topic_array[$topicCtr]['prof']['assessment']['item'][$aCtr]['name'] = $assessment['name'];
	
					}
					unset($actCtr);
				}
			}
			}
		
		}   // end foreach topic

		// Copy activity items to the topic_array
		
		$topicCtr = 0;
		
		foreach ($topic_array as $topic) { // loop through the topics
		
			$topicCtr++;
			//$topic_array[$topicCtr]['prof']['assessment'] = '';
			
			$tcode = trim($topic['code']);
			
			foreach ($taa_array as $taas ) { // loop through the sams
			
			$taa_tcode = trim($taas['code']);
			
			//echo "Topic Counter = ".$topicCtr." :: Topic = ".$tcode." SAM Topic = ".$sam_tcode." <br />";
			
			if ($tcode == $taa_tcode) {  // matching topic, let's do something
			
					
				$topic_array[$topicCtr]['prof']['activities']['numActivities'] = $taas['activityAlign'];
				if(isset($taas['prof']))
				{
					$actCtr = 0;
					foreach ($taas['prof']['activities'] as $activities) {
						$actCtr++;
						$topic_array[$topicCtr]['prof']['activities']['item'][$actCtr]['sys_id'] = $activities['sys_id'];
						$topic_array[$topicCtr]['prof']['activities']['item'][$actCtr]['name'] = $activities['name'];
					}
					unset($actCtr);
				}
			}
			}
		
		}   // end foreach topic

        $data = array('topiccount' => $topicsdata, 'topics' => $topic_array );
		$data['courses']['code'] = $courseId;
		/*echo 'data: <br/>';
		echo '<pre/>';
		print_r($data);
		echo '<pre/>';*/

        $this->load->view('ocf/topics_amcgosearch', $data);

    }
    
    /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
	 
    protected function Xml2Array($itemXml,$j, $arg_locode) 
    { 

			// loop through related topics
		
		
		//echo "Number of topic in topics: ". $itemXml->numNodes('/xml/item/curriculum/topics/topic') . "<br />";
		
		
        $tmp['code'] = '';
		$tmp['title'] = '';
		
		$ctr = 0; //set a counter
		
		 for ($t = 1; $t <= $itemXml->numNodes('/xml/item/curriculum/topics/topic'); $t++) 
		
		{
		
		$topicCode = '/xml/item/curriculum/topics/topic['.$t.']/code';
        $topicTitle = '/xml/item/curriculum/topics/topic['.$t.']/name';
		
		if ($ctr >= 1) { $tmp['title'] .= ', ';  }
		
        $tmp['code'] .= $itemXml->nodeValue($topicCode);
		$tmp['code'] .= ' ';
        $tmp['title'] .= $itemXml->nodeValue($topicTitle);
		
		
		$ctr++; // increment the counter
		
		
		}
		
		

        // loop through prof objectives

        $tmp['prof']['lo']['numAlign'] = 0;
        
        for ($k = 1; $k <= $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo'); $k++) 
        {

           	$loCatCode = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/@cat_code';
            $loCatName = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/@cat_name';
            $loCode = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/code';
            $loLevel = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/level';
			$loName = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/name';
			
			
            
            
			
			if(strtolower($itemXml->nodeValue($loCode)) === $arg_locode)
            {
                $tmp['locode'] = $itemXml->nodeValue($loCode);
				$tmp['catCode'] = $itemXml->nodeValue($loCatCode);
            	$tmp['catName'] = $itemXml->nodeValue($loCatName);
           		$tmp['level'] = $itemXml->nodeValue($loLevel);
				$tmp['loName'] = $itemXml->nodeValue($loName);
				
				
				$topicAlign = $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/aligned/topic/los/lo');

            $tmp['prof']['lo']['numAlign'] = intval($topicAlign);

            for($i=1; $i<=$tmp['prof']['lo']['numAlign']; $i++)
            {
                $loAlignedCode = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/aligned/topic/los/lo['.$i.']/code';
                $loAlignedName = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/aligned/topic/los/lo['.$i.']/name';

                $tmp['prof']['loaligned']['lo'.$i]['code'] = $itemXml->nodeValue($loAlignedCode);
                $tmp['prof']['loaligned']['lo'.$i]['name'] = $itemXml->nodeValue($loAlignedName);
            }
				
				
            }

            

            

        }	

        return $tmp;
	
    }	
   
      /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function samXml2Array($itemXml,$k, $arg_locode) 
    {
       
		#echo "array index = ".$k." argument code = ".$arg_locode."<br />";
		
		
        $tmp['code'] = '';
		$tmp['title'] = '';
		
		$ctr = 0; //set a counter
		
		//$numberAlignedTopics = intval($itemXml->numNodes('/xml/item/curriculum/topics/topic'));
		//echo $numberAlignedTopics;
		
		for ($t = 1; $t <= $itemXml->numNodes('/xml/item/curriculum/topics/topic'); $t++) 
		
		{
		
		$topicCode = '/xml/item/curriculum/topics/topic['.$t.']/code';
        $topicTitle = '/xml/item/curriculum/topics/topic['.$t.']/name';
		
		//if ($ctr >= 1) { $tmp['title'] .= ', ';  }
		
       $tmp['code'] .= $itemXml->nodeValue($topicCode);
		//$tmp['code'] .= ' ';
       $tmp['title'] .= $itemXml->nodeValue($topicTitle);
	   $ctr++; 

		}
			// Aligned Professional LO assessments
			
			
			// loop through prof objectives

        	
		
		
		for ($k = 1; $k <= $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo'); $k++) 
       
	   		{
				
				$loCatCode = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/@cat_code';
            	$loCatName = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/@cat_name';
            	$loCode = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/code';
           		$loLevel = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/level';
				$loName = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/name';

				if(strtolower($itemXml->nodeValue($loCode)) === $arg_locode)
				
				{
					
					
				$tmp['locode'] = $itemXml->nodeValue($loCode);
				$tmp['catCode'] = $itemXml->nodeValue($loCatCode);
            	$tmp['catName'] = $itemXml->nodeValue($loCatName);
           		$tmp['level'] = $itemXml->nodeValue($loLevel);
				$tmp['loName'] = $itemXml->nodeValue($loName);
				
				
				$assessAlign = $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/aligned/a_items/a_item');
				
				$tmp['assessAlign'] = intval($assessAlign);
				
				
				for($i=1; $i<=$tmp['assessAlign']; $i++)
            {
                $assessAlignedCode = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/aligned/a_items/a_item['.$i.']/@sys_id';
                $assessAlignedName = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/aligned/a_items/a_item['.$i.']/name';

                $tmp['prof']['assessment'][$i]['sys_id'] = $itemXml->nodeValue($assessAlignedCode);
                $tmp['prof']['assessment'][$i]['name'] = $itemXml->nodeValue($assessAlignedName);
            }
				
					
				}
				
				
			}
/*		
*/
        return $tmp;

    }
   

   /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function taaXml2Array($itemXml,$k, $arg_locode) 
    {
       
		#echo "array index = ".$k." argument code = ".$arg_locode."<br />";
		
		
        $tmp['code'] = '';
		$tmp['title'] = '';
		
		
		
		$ctr=0;
		
		//$numberAlignedTopics = intval($itemXml->numNodes('/xml/item/curriculum/topics/topic'));
		//echo $numberAlignedTopics;
		
		for ($t = 1; $t <= $itemXml->numNodes('/xml/item/curriculum/topics/topic'); $t++) 
		
		{
		
		$topicCode = '/xml/item/curriculum/topics/topic['.$t.']/code';
        $topicTitle = '/xml/item/curriculum/topics/topic['.$t.']/name';


		
		//if ($ctr >= 1) { $tmp['title'] .= ', ';  }
		
       $tmp['code'] .= $itemXml->nodeValue($topicCode);
		//$tmp['code'] .= ' ';
       $tmp['title'] .= $itemXml->nodeValue($topicTitle);
		
		
		$ctr++; // increment the counter
		
		//echo $ctr."<br />";
		
		
		}
		

for ($a = 1; $a <= $itemXml->numNodes('/xml/item/curriculum/activities/act_items/act_item'); $a++) 

{
	
	
	$actItemSysID = '/xml/item/curriculum/activities/act_items/act_item['.$a.']/@sys_id';
    $actItemName = '/xml/item/curriculum/activities/act_items/act_item['.$a.']/name';
	
	
	
	
	//echo $actItemName . "(" . $actItemSysID . ") <br />";
}
		
			// Aligned Professional LO assessments
			
			
			// loop through prof objectives

        	
   			//echo $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo');
			
			
			//exit;
		
		for ($k = 1; $k <= $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo'); $k++) 
	   		{
				
				$loCatCode = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/@cat_code';
            	$loCatName = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/@cat_name';
            	$loCode = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/code';
           		$loLevel = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/level';
				$loName = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/name';

				//echo $itemXml->nodeValue($loCode) . " = " . $arg_locode . " :: ";
				
				if(strtolower($itemXml->nodeValue($loCode)) === $arg_locode)
				
				{
				
				
				//echo "MATCH <br />";
					
				$tmp['locode'] = $itemXml->nodeValue($loCode);
				$tmp['catCode'] = $itemXml->nodeValue($loCatCode);
            	$tmp['catName'] = $itemXml->nodeValue($loCatName);
           		$tmp['level'] = $itemXml->nodeValue($loLevel);
				$tmp['loName'] = $itemXml->nodeValue($loName);
				
				
				$activityAlign = $itemXml->numNodes('/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/aligned/act_items/act_item');
				
				
				
				$tmp['activityAlign'] = intval($activityAlign);
				
				
				for($i=1; $i<=$tmp['activityAlign']; $i++)
            {
                $activityAlignedCode = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/aligned/act_items/act_item['.$i.']/@sys_id';
                $activityAlignedName = '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/aligned/act_items/act_item['.$i.']/name';

                $tmp['prof']['activities'][$i]['sys_id'] = $itemXml->nodeValue($activityAlignedCode);
                $tmp['prof']['activities'][$i]['name'] = $itemXml->nodeValue($activityAlignedName);			
            }
				
					
				} 
				
				
			} // end of $k loop, iw, loop through LOs
	

        return $tmp;

    }

/**
     * Validate incoming parameters
     *
     * @param string $coursecode
     */
    private function validate_params($courseCode)
    {

        if(strcmp($courseCode, 'missed')==0 ||is_numeric($courseCode) )
		{
            return false;
		}
        return true;
    }
}

/* End of file */
