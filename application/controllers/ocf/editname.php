<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Editname extends CI_Controller {
 
	public function index($uuid='missed', $version='missed')
	{
		
		if(!isset($_SESSION)){ session_start();}
		#echo "activity.php - AC 21 APR 2015<br />";
		
		
		sleep(1);
		
		#$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";
        
        if($this->validate_params($uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request";
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
		
        $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		$ci =& get_instance();
		$ci->load->config('flex');
		$collections = $ci->config->item('topic_information_collection');
		
		$success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }    
        if(!isset($_SERVER['REMOTE_USER']))
		{
			$errdata['message'] = 'Unable to get username';
			$errdata['heading'] = "Internal error";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			exit();
		}
			
		/****************************************************************************/
		
		/* Find user permissions                                                    */
		
		/****************************************************************************/
		
		$fan = $_SERVER['REMOTE_USER'];
		

		
	
		$this->load->library('permission/permission');
       
        if(!$this->permission->success)
        {   
           $errdata['message'] = 'Permission not granted';
			$errdata['heading'] = "Internal error";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			exit();
        }
		
        $permission_array = $this->permission->get_ocf_permission($fan);
		
		if ($_SESSION['ocf_privilege'] = 'mod&con') {
			
			$user_role = 'moderator&contributor';
		}
		
      
		
	
		
		/****************************************************************************/
		
		/* Find the activity information                                               */
		
		/****************************************************************************/
		
		/* -------------------      */   
		
		$success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
       
	/* --------------             
	
	echo "<pre>";
	print_r($response);
	echo "</pre>";
	*/
	
	
		$xmlwrapper_name = 'xmlwrapper'.'activity';
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);

		
		$item_array = $this->itemXml2Array($this->$xmlwrapper_name);
		
		
		
		$item_array['name'] = $response['name'];
		$item_array['uuid'] = $uuid;
		$item_array['version'] = $version;
		
		$data = array('item' => $item_array,  'token' => $this->generateToken($fan), 'privilege' => $user_role );
			
			//$data = array('item' => $item_array, 'activity_los' => $activitylos_array, 'los' => $lo_array, 'token' => $this->generateToken($fan), 'privilege' => $user_role );

		
	/* --------------             
	
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	
	*/


		$this->load->view('ocf/editname', $data);
				
		//$this->load->view('ocf/editname');
	 
} 



/**********************************/
/*       FUNCTIONS                */
/**********************************/


    protected function itemXml2Array($itemXml) 
    { 

		$itemTitle = '/xml/item/curriculum/activities/activity/name';
		
		$tmp['itemTitle'] = $itemXml->nodeValue($itemTitle);
	
		
		
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


	private function generateToken($username)
	{
		$ci =& get_instance();
		$ci->load->config('flex');
	
		$sharedSecretId = $ci->config->item('ocf_shared_secret_id');
		$sharedSecretValue = $ci->config->item('ocf_shared_secret_value');
		

	
		$time = mktime() . '000';
				
	    return urlencode ($username) . ':' . urlencode($sharedSecretId) . ':' .  $time . ':' . 
	    urlencode(base64_encode (pack ('H*', md5 ($username . $sharedSecretId . $time . $sharedSecretValue))));
																
	}


}