<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Amcgosearch_sam extends CI_Controller {

    public function index($arg_locode='missed')
    {
		
        $errdata['heading'] = "Error";
        if(strcmp($arg_locode, 'missed')==0)
        {
            $errdata['message'] = "Invalid Request";
            $this->load->view('som/showerror_view', $errdata);
            return;
        }
		
		
		// Topic info search
		
		
		
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
        
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('som/showerror_view', $errdata);
            return;
        }  



		
		// SAM info search
		
		
		// Search variables
        $q = '';
        $start = 0;
        $length = 50;

        $collections = '2fcc59e4-7fbc-4a87-9c84-a94ca4a850e1';  // The SAM collection

        $order = 'name';
        $reverse = false;

        $samwhere = "/xml/item/curriculum/@item_type='SAM'";
        $samwhere .= " AND /xml/item/curriculum/courses/course/code='MD'";
        #$where .= "AND /xml/item/curriculum/outcomes/prof/los/lo/code='Know'";
        #              '/xml/item/curriculum/outcomes/prof/los/lo['.$k.']/code'

        $samwhere = urlencode($samwhere);

        $info = 'all';
        $showall = true;
		
		$alignedsuccess = $this->flexrest->search($samresponse, $q, $collections, $samwhere, $start, $length, $order, $reverse, $info, $showall);
		
		
		
		/****************************************************************************/
		
		/* Now find the Topic Availabilities Activities (TAA) for this topic                                          */
		
		/****************************************************************************/
		
		
		 
		
		// Search variables
        $q = '';
        $start = 0;
        $length = 1;

        $collections = '5194ef90-32e1-4d8c-ba14-27dd489c5bf5';  // The TAA collection
	

        $order = 'name';
        $reverse = false;

        $taawhere = "/xml/item/curriculum/@item_type='TAA'";
        $taawhere .= " AND /xml/item/curriculum/courses/course/code='MD'";
		
        
        $taawhere = urlencode($taawhere);
		
		//echo "<br /><br /><br />".urldecode($taawhere)."<br /><br />";
		
		//exit;
		
        $info = 'all';
        $showall = true;

		$taasuccess = $this->flexrest->search($taa, $q, $collections, $taawhere, $start, $length, $order, $reverse, $info, $showall);
		
        
		
		if ($_SERVER['REMOTE_ADDR'] == '10.26.21.73') {
		
		echo "<h3>Array - taa</h3>";
		
		echo "<pre>";print_r($taa);echo "<pre>";exit();
		
		
		}
		
		 if(!$alignedsuccess)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('som/showerror_view', $errdata);
            return;
        }
		
		#echo "Alignment success! <br /><br />";
		
		#exit;

		
		

		$sam_array = array();

        $samTopicCount = intval($samresponse['available']);
		
		#echo "Number of aligned topics = ".$samTopicCount." <br /><br />";
		
		#exit;

        for ($r=0; $r < $samTopicCount; $r++ ) {

            $s = $r + 1;

            $xmlwrapper_name = 'xmlwrappersam'.$s;

            $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$samresponse['results'][$r]['metadata']), $xmlwrapper_name);

            $sam_array[$s] = $this->samXml2Array($this->$xmlwrapper_name, $s, $arg_locode);
			
			
			$sam_array[$s]['wrapper_name'] = $xmlwrapper_name;
			
			
			$sam_array[$s]['uuid'] = $samresponse['results'][$r]['uuid'];
            $sam_array[$s]['version'] = $samresponse['results'][$r]['version'];


        }
		
		
		
		if ($_SERVER['REMOTE_ADDR'] == '129.96.68.25') {
		
	
		echo "<h2>Topic Info data array</h2>";
			
		echo "<pre>";
      	print_r($topic_array);
       	echo "</pre>";
	
		
		echo "<h2>SAM data array</h2>";
			
		echo "<pre>";
      	print_r($sam_array);
        echo "</pre>";
   	   
	    exit;
		
		
/*	*/		

		
		
		
		}	
		
		
		
		
		


      //  $this->load->view('som/topics_amcgosearch', $data);

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
		
		
		$ctr++; // increment the counter
		
		//echo $ctr."<br />";
		
		
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

                $tmp['prof']['assessment'.$i]['sys_id'] = $itemXml->nodeValue($assessAlignedCode);
                $tmp['prof']['assessment'.$i]['name'] = $itemXml->nodeValue($assessAlignedName);
            }
				
					
				}
				
				
			}
/*		
*/
        return $tmp;

    }
   
   
	
}

/* End of file */
