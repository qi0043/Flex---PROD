<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Handout extends CI_Controller {
	
	
	

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

	public function index($uuid='missed', $version='missed', $handoutid='missed' )
	{
		
		//echo $uuid;
		
		//echo "<br />loading url helper<br />";
		
		//exit;
		
		
		#$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";
		
		//echo $errdata['heading'];
        
		
		/*
        if($this->validate_params($uuid, $version, $handoutid) == false)
        {
            $errdata['message'] = "Invalid Request";
            $this->load->view('pbl/showerror_view', $errdata);
            return;
        }
		
		else { echo "validated<br />"; }
		
		*/
        $this->load->helper('url');
       // $this->load->library('flexrest/flexrest');
		
		//$success = $this->flexrest->processClientCredentialToken();
        
		/*
		if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('pbl/showerror_view', $errdata);
            return;
        }    
        
  		*/
  
	
		//echo "Creating array";
		
		$handout = array();
		
		$handout['uuid'] = $uuid;
		$handout['version'] = $version;
		$handout['id'] = $handoutid;
		
		//print_r($handout);
		
		//exit;
		
		$data = array('handout' => $handout);
		
		$this->load->view('pbl/handout', $data);
		

		
		}
	

 
	 
}

