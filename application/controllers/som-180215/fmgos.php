<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Fmgos extends CI_Controller {

    public function index($arg_locode='missed')
    {
		
		echo "In function!";
		
		exit;
		
		
        
		$errdata['heading'] = "Error";
        if(strcmp($arg_locode, 'missed')==0)
        {
            $errdata['message'] = "Invalid Request";
            $this->load->view('som/showerror_view', $errdata);
            return;
        }
		// Search variables
        $q = '';
        $start = 0;
        $length = 50;

        $collections = '6704afea-e88c-4230-b277-6d9d413bfbff';

        $order = 'name';
        $reverse = false;

        $where = "/xml/item/curriculum/@item_type='Topic Information' ";
        $where .= "AND /xml/item/curriculum/info/course/code='MD' ";
        #$where .= "AND /xml/item/curriculum/outcomes/course/los/lo/code='Know'";
        #              '/xml/item/curriculum/outcomes/course/los/lo['.$k.']/code'

        $where = urlencode($where);

        $info = 'metadata';
        $showall = true;

        #$this->load->helper('url');
        $this->load->library('flexrest/flexrest');
        
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('som/showerror_view', $errdata);
            return;
        }  

        $searchsuccess = $this->flexrest->search($response, $q, $collections, $where, $start, $length, $order, $reverse, $info, $showall);
        #echo "<pre>";print_r($response);echo "<pre>";exit();

        if(!$searchsuccess)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('som/showerror_view', $errdata);
            return;
        }

        $topicsdata = array();
        $topicsdata['numTopics'] = intval($response['available']);

        $topic_array = array();

        $topicCount = intval($response['available']);

        for ($i=0; $i < $topicCount; $i++ ) {

            $j = $i + 1;

            $xmlwrapper_name = 'xmlwrapper'.$j;

            $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['results'][$i]['metadata']), $xmlwrapper_name);

            $topic_array[$j] = $this->Xml2Array($this->$xmlwrapper_name, $j, $arg_locode);

            $topic_array[$j]['uuid'] = $response['results'][$i]['uuid'];
            $topic_array[$j]['version'] = $response['results'][$i]['version'];

        }

        $data = array('topiccount' => $topicsdata, 'topics' => $topic_array );
		

    echo "<pre>";
    print_r($topiccount);
    print_r($topics);
    echo "</pre>";


       // $this->load->view('som/topics_fmgosearch', $data);

    }
    
    /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
	 
    protected function Xml2Array($itemXml,$j, $arg_locode) 
    { 

        
		//echo "Topic ".$j."<br />";
		
		$topicCode = '/xml/item/curriculum/info/topic/code';
        $topicTitle = '/xml/item/curriculum/info/topic/name';

        $tmp['code'] = $itemXml->nodeValue($topicCode);
        $tmp['title'] = $itemXml->nodeValue($topicTitle);

        // loop through course objectives

        $tmp['course']['lo']['numAlign'] = 0;
        
        for ($k = 1; $k <= $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo'); $k++) 
        {

           
			
			
			$loCatCode = '/xml/item/curriculum/outcomes/course/los/lo['.$k.']/@cat_code';
            $loCatName = '/xml/item/curriculum/outcomes/course/los/lo['.$k.']/@cat_name';
            $loCode = '/xml/item/curriculum/outcomes/course/los/lo['.$k.']/code';
            $loLevel = '/xml/item/curriculum/outcomes/course/los/lo['.$k.']/level';
			
			
			if(strtolower($itemXml->nodeValue($loCode)) == $arg_locode)
			
			{
				
				
				//echo "&nbsp;&nbsp;&nbsp;Course LO ".$k.": ".$itemXml->nodeValue($loCode)." :: TRUE!<br />";
				
				$topicAlign = $itemXml->numNodes('/xml/item/curriculum/outcomes/course/los/lo['.$k.']/aligned/topic/los/lo');
				
				$tmp['course']['lo']['numAlign'] = intval($topicAlign);

            for($i=1; $i<=$tmp['course']['lo']['numAlign']; $i++)
            {
                $loAlignedCode = '/xml/item/curriculum/outcomes/course/los/lo['.$k.']/aligned/topic/los/lo['.$i.']/code';
                $loAlignedName = '/xml/item/curriculum/outcomes/course/los/lo['.$k.']/aligned/topic/los/lo['.$i.']/name';

                $tmp['course']['loaligned']['lo'.$i]['code'] = $itemXml->nodeValue($loAlignedCode);
                $tmp['course']['loaligned']['lo'.$i]['name'] = $itemXml->nodeValue($loAlignedName);
            }

				
				}
			
			else
			
			{ 
			
			//echo "&nbsp;&nbsp;&nbsp;Course LO ".$k.": ".$itemXml->nodeValue($loCode)."<br />"; 
			
			}

         

            $tmp['course']['lo']['code'] = $itemXml->nodeValue($loCode);
            $tmp['course']['lo']['catCode'] = $itemXml->nodeValue($loCatCode);
            $tmp['course']['lo']['catName'] = $itemXml->nodeValue($loCatName);
            $tmp['course']['lo']['level'] = $itemXml->nodeValue($loLevel);

            

            
        }	

        return $tmp;
	
    }	
    
	
}

/* End of file */
