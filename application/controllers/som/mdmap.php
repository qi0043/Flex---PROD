<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Mdmap extends CI_Controller {

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
		
		// Search variables
        $q = '';
        $start = 0;
        $length = 50;

        $collections = '6704afea-e88c-4230-b277-6d9d413bfbff';

        $order = 'name';
        $reverse = false;

        $where = "/xml/item/curriculum/@item_type='Topic Information' ";
        $where .= " AND /xml/item/curriculum/courses/course/code='MD' ";


        $where = urlencode($where);

        $info = 'all';
        $showall = false;
		
	
		
		$this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		
		
		
		$success = $this->flexrest->processClientCredentialToken();
		
		
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('som/showerror_view', $errdata);
            return;
        }  
		
		if($success)
		{
		
		
		$searchsuccess = $this->flexrest->search($response, $q, $collections, $where, $start, $length, $order, $reverse, $info, $showall);
		
		if(!$searchsuccess)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('som/showerror_view', $errdata);
            return;
        }

		/*                  */
		echo "<pre>";
		echo $_SERVER['REMOTE_USER'];
		echo "</pre>";
		
		echo "<pre>";
		print_r($response);
		echo "</pre>";
		
		exit;
		
		
		
		
		
		
		
		
		$topicsdata = array();
        $topicsdata['numTopics'] = intval($response['available']);

        $topic_array = array();

        $topicCount = intval($response['available']);
		
		
		for ($i=0; $i < $topicCount; $i++ ) {

            $j = $i + 1;

            $xmlwrapper_name = 'xmlwrapper'.$j;

            $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['results'][$i]['metadata']), $xmlwrapper_name);

            $topic_array[$j] = $this->Xml2Array($this->$xmlwrapper_name, $j);
			
			$topic_array[$j]['uuid'] = $response['results'][$i]['uuid'];
			$topic_array[$j]['version'] = $response['results'][$i]['version'];

        }  // end "for" loop
		
		
		}  //  end of success
		
	
	
	
	
	
	// code to invoke the view to go here
	
	
	
	
	
	
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