<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Curriculummap extends CI_Controller {

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

	public function index()
	{
		
		
		
		
		#$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";
        
        if($this->validate_params($uuid, $version) == false)
        {
           // $errdata['message'] = "Invalid Request";
            //$this->load->view('som/showerror_view', $errdata);
            //return;
        }
		
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		
		$success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('som/showerror_view', $errdata);
            return;
        }    
        
        


		
		
		
		/****************************************************************************/
		
		/* Find Topic Activities for a topic                                       	*/
		
		/****************************************************************************/
		
		
		 
		
		// Search variables
        
		
		
		
		$q = '';
        $start = 0;
        $length = 1;

        $collections = '5194ef90-32e1-4d8c-ba14-27dd489c5bf5';  // The TAA collection
	

        $order = 'name';
        $reverse = false;

       // $topicswhere = "/xml/item/curriculum/@item_type='TAA'";
        //$topicswhere .= " AND /xml/item/curriculum/topics/topic/code = 'MMED8104'";
		
		$topicswhere = "/xml/item/curriculum/topics/topic/code like 'MMED81%'";

        
        $topicswhere = urlencode($taawhere);
		

		
        $info = 'basic';
        $showall = false;

		$topicssuccess = $this->flexrest->search($topics, $q, $collections, $topicswhere, $start, $length, $order, $reverse, $info, $showall);

		
		
		$xmlwrapper_name = 'xmlwrapper'.'topics';
		
		        
		//$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$topics['results'][0]['metadata']), $xmlwrapper_name);
		//$topicsarray = $this->topicsXml2Array($this->$xmlwrapper_name);
		 
		
		
		
	



		if ($_SERVER['REMOTE_ADDR'] == '10.26.21.73') {

	
		
		echo "<h2>Topics data array XX</h2>";
			
		echo "<pre>";
      	print_r($topics);
		echo "</pre>";
	/*	
*/
		
	   
	    //
		
		}
		
		
		
		//$data = array('topics' => $topic_array, 'taa' => $taa_array, 'sam' => $sam_array);
		
		//$this->load->view('som/topicview', $data);
		//$this->load->view('som/cmap', $data);
		
		
		//$this->load->view('som/cmap');
		

		
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
        if(isset($itemistopic) && $itemistopic=='TAA')
            return true;
        return false;
    }
	

 /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function topicsXml2Array($itemXml) 
    { 

		
		
		
		
		
	
		
		
        return $tmp;

    }


 /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function samXml2Array($itemXml) 
    {
      
        
		
		
		
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