<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller to show SAM in HTML or PDF format
 */
class Course extends CI_Controller 
{
    
	

	public function index()
	
    {
       
      echo "You're in!";
	  
	  exit;
		
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
        
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }  
		
		$q = '';
		$start = 0;
		$length = -1;
		$collections = 'e06d5665-fca6-4f0e-8d29-2e2957eb5161';
		$order = 'name'
		$reverse = false
		$where = "%2Fxml%2Fitem%2Funi%2Ftopic%2F%40type+%3D+'Topic+Information'+AND+%2Fxml%2Fitem%2Funi%2Ftopic%2Fused_in%2Fcourses%2Fcode+%3D+'MMED'+AND+%2Fxml%2Fitem%2Funi%2Ftopic%2Fspecs%2Fcode+LIKE+'MMED%25'"
		$info = 'all';
		$showall = true;
		
        
        $success = $this->flexrest->search($q, $collections, $where, $onlyLive, $orderType, $reverseOrder, $start , $length, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('sam/showerror_view', $errdata);
            return;
        }
        
        
		echo "<pre>";
        print_r($response);
        echo "</pre>";
       //log_message('error', htmlentities($response['metadata']));
	   
	  
	 
        
	}


}

/* End of file */
