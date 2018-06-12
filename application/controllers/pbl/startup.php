<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Startup extends CI_Controller {
	
	
	

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/
<method_name>
* @see http://codeigniter.com/user_guide/general/urls.html
	**/

	public function index($uuid='missed', $version='missed')
	{
		
		
		
		
		#$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";
        
        if($this->validate_params($uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            $this->load->view('pbl/showerror_view', $errdata);
            return;
        }
		
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		
		$success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('pbl/showerror_view', $errdata);
            return;
        }    
        
        $success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('pbl/showerror_view', $errdata);
            return;
        }
		
		
		
		
		 /* 
		
		echo "<pre>";
       print_r($response);
       echo "</pre>";
	   
	   exit;
	  
	   
	  */
       //log_message('error', htmlentities($response['metadata']));
	   
	   
	   //echo htmlentities($response['metadata']);
        
		
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']));
		
		if(!$this->itemIsPBL($this->xmlwrapper))
        {
            $errdata['message'] = "Item is not a PBL Case";
            $this->load->view('pbl/showerror_view', $errdata);
            return;
        }
		
		$case_array = $this->pblXml2Array($this->xmlwrapper);
			
/*
		 echo'<pre>';

       	print_r($case_array);
;
        echo'</pre>';
		
*/

		
		
		
		
		$data = array('case' => $case_array);
		
		$this->load->view('pbl/caseview', $data);
		

		
		}
	
	
	
	    /**
     * Check whether the item has a type of Topic Information
     *
     * @param xmlwrapper $itemXml
     */
    protected function itemIsPbl($itemXml) 
    { 

        $type = '/xml/item/curriculum/@item_type';
        $itemistopic = $itemXml->nodeValue($type);
        if(isset($itemistopic) && $itemistopic=='PBL Case')
            return true;
        return false;
    }
	

 /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function pblXml2Array($itemXml) 
    { 

 

		
		
		$caseTitle = '/xml/item/itembody/name';
		$numTutes = '/xml/item/specific/pbls/pbl/number_sections';
		
		$hashCtr = 0;
		
		
		$tmp['caseTitle'] = $itemXml->nodeValue($caseTitle);
		$tmp['numTutes'] = intval($itemXml->nodeValue($numTutes));
		
		
		$hashseed = substr(md5($itemXml->nodeValue($caseTitle)),0,4);
		
	
		
		
		$numTutes = intval($itemXml->nodeValue($numTutes));
		
		
		$hashCounter = 0;
		
		
		
		for ($t=1; $t <= $numTutes; $t++) {
			
			
			//$tmp['tutorial'][$t]['number'] = $t;
			
			$numAtoms = $itemXml->numNodes('/xml/item/specific/pbls/pbl/sections/section'.$t.'/atoms/atom');
			//$tmp['tutorial'][$t]['numAtoms'] = $numAtoms;
			
			
			$scrCounter = 0;
			
			for ($s = 1; $s <= $numAtoms; $s++) {
				
				
				
				
				
				$who_for = '/xml/item/specific/pbls/pbl/sections/section'.$t.'/atoms/atom['.$s.']/@who_for';
				$textNode = '/xml/item/specific/pbls/pbl/sections/section'.$t.'/atoms/atom['.$s.']/text';
				
				
				$usage = $itemXml->nodeValue($who_for);
				$screenText = $itemXml->nodeValue($textNode);
				
				if ($usage == 'Standard') {
					
					
					$scrCounter++;
					
					
					$hashCounter++;
					
					
					$tmp['screens'][$hashCounter]['tutorial'] = $t;
					
					$tmp['screens'][$hashCounter]['screenNumber'] = $scrCounter;
					
					
					if ($hashCounter < 10) { $idhash = $hashseed."0".$hashCounter; } else { $idhash = $hashseed.$hashCounter; }
					$tmp['screens'][$hashCounter]['idhash'] = $idhash;
					
			
					$tmp['screens'][$hashCounter]['use'] = $usage;
					$tmp['screens'][$hashCounter]['text'] = $screenText;
				
				}  // end of standard text
				
				
			}   // end of $s loop = screens
			
			
			
		}  // end of $t loop = tutorials

			
			

		
		
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
    
	 
}

/* End of file startup.php */