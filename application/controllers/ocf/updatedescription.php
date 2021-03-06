<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Updatedescription extends CI_Controller {
 
	public function index($uuid='missed', $version='missed')
	{
		
		if(!isset($_SESSION)){ session_start();}
		//echo "updatename.php - AC 15 SEP 2015\n";
		
		//echo  $this->input->post('name') . "\n";
		
		sleep(1);
		
	   // $this->load->model('ocf/ocf_model');
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
		
		//echo  $fan . "\n";

		$this->load->library('permission/permission');
       
        if(!$this->permission->success)
        {   
           $errdata['message'] = 'Permission not granted';
			$errdata['heading'] = "Internal error";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			exit();
        }
		
        /*$permission_array = $this->permission->get_ocf_permission($fan);
		
		if ($_SESSION['ocf_privilege'] = 'mod&con') {
			
			$user_role = 'moderator&contributor';
		}*/
	
		$upd_privilege = $this->permission->get_ocf_activity_upd_privilege($fan, $uuid, $version);
		if(!$this->permission->success)
		{   
		    echo 'Internal Error: Failed to get privilege.';
		    return;
		}
		if(!(isset($upd_privilege['has_privilege']) && $upd_privilege['has_privilege'] == 'Yes' && $upd_privilege['locks']['item_description'] != 'Yes'))
		{
		    echo 'Error: no privilege or item description locked.';
		    return;
		}
		
		
		//echo  $user_role  . "\n";
		
		/****************************************************************************/
		
		/* Find the activity information                                               */
		
		/****************************************************************************/
		
		/* -------------------      */   
		
		$s = $this->flexrest->getLock($uuid, $version, $r);
		if($s)
		{
			echo 'This activity is currently locked for editing. <br/><br/>To find out who is editing this activity, click on the red "Edit Activity" button then, in FLEX, look at the top RHS under Details.<br/><br/>';
			//echo 'Item is currently editing by others. Please try again later! <br/>';
			
		}
		else
		{		
			$success = $this->flexrest->getItem($uuid, $version, $response);
			if(!$success)
			{
				$errdata['message'] = $this->flexrest->error;
				$this->load->view('ocf/showerror_view', $errdata);
				return;
			}
		   
		   
			$item_bean = $response;

			$xmlwrapper = 'xmlwrapper';
		
			//pull out metadata XML 
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$item_bean['metadata']), $xmlwrapper);
			
			
			$description = $this->xmlwrapper->nodeValue("/xml/item/itembody/description");
			//echo 'de'.$description.'<br/>';
			$newname = $this->input->post('theDescription');
			
			
			//echo $this -> xml_entities(html_entity_decode($newname));
			$newactivityname = $this->xmlwrapper->setNodeValue("/xml/item/itembody/description", $this->xml_entities(html_entity_decode($newname)));
	
			$updatedname = $this->xmlwrapper->nodeValue("/xml/item/itembody/description");
			
			//echo "updated name: " . $updatedname . "\n\n";
			
			
			$item_bean['metadata'] = $this->xmlwrapper->__toString();
			
			//echo $item_bean['metadata']. "\n\n";
			
			$updatesuccess = $this->flexrest->editItem($uuid, $version, $item_bean, $updateresponse, '');
			 
			if(!$updatesuccess)
		    {
				$errdata['message'] = $this->flexrest->error;
				log_message('error', 'Item name update fail, item uuid: ' . $uuid . ', error: ' . $errdata['message']);
				echo $errdata['message'];
				//$this->load->view('rhd/showerror_view', $errdata);
				return;
		    } 
		    else
		    {
				$updatesuccess = $this->flexrest->getItem($uuid, $version, $updateresponse);
				if(!$updatesuccess)
				{
					$errdata['message'] = $this->flexrest->error;
					$this->load->view('ocf/showerror_view', $errdata);
					return;
				}
			
				$xmlname = 'xmlwrapper_r';
				$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$updateresponse['metadata']), $xmlname);
				$activity_description = $this->$xmlname->nodeValue("/xml/item/itembody/description");

				$item_array['description'] = $activity_description;
				$item_array['uuid'] = $uuid;
				$item_array['version'] = $version;
					
				$data = array('item' => $item_array,  'token' => $this->generateToken($fan));
	
				$this->load->view('ocf/updateddescription', $data);
			  }
		}

} 


  
  /**** Parse xml special characters ***/
   private function xml_entities($string) {
		return strtr(
			$string, 
			array(
				"<" => "&lt;",
				">" => "&gt;",
				'"' => "&quot;",
				"'" => "&apos;",
				"&" => "&amp;",
			)
		);
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