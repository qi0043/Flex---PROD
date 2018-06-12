<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Ovp extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');   
		$param = array('oauth_client_config_name' => 'ovp');
		$this->load->library('flexrest/flexrest', $param);
		
		$success = $this->flexrest->processClientCredentialToken();
		if(!$success)
		{
			$errdata['message'] = 'Failed to access FLEX OVP help documentpage.';
			log_message('error','Failed to access FLEX OVP help documentpage: ' . $this->flexrest->error);
			$this->load->view('public/ovp/showerror_view', $errdata);
			echo $this->flexrest->error;
			return false;
		}    
	}
	 
	 /**
     * Load user to the view 
     *
     * @param para, string, the help document name
     */
	public function help($para='missed')
	{  
		$ci =& get_instance();
        $ci->load->config('flex');
		
		$errdata['heading'] = "Error";
		if($para == 'missed')
		{
			$errdata['message'] = 'Invalid page';
			$this->load->view('public/ovp/showerror_view', $errdata);
			return;
		}
		
		$uuid = '';
		$version = '';
		
		switch($para)
		{
			case 'start': //Video Help Dashboard
				$uuid = $ci->config->item('OVP_Video_Help_Dashboard_uuid');
      			$version = $ci->config->item('OVP_Video_Help_Dashboard_version');
			break;
			
			case 'add': //Upload my Media
				$uuid = $ci->config->item('OVP_Upload_to_My_Media_uuid');
              	$version = $ci->config->item('OVP_Upload_to_My_Media_version');
			break;
			
			case 'edit': //Edit Media
				$uuid = $ci->config->item('OVP_Edit_Media_uuid');
              	$version = $ci->config->item('OVP_Edit_Media_version');
			break;
			
			case 'slides': //Slides
				$uuid = $ci->config->item('OVP_Slides_uuid');
              	$version = $ci->config->item('OVP_Slides_version');
			break;
			
			case 'assignment': //Submit a Video Assignment
				$uuid = $ci->config->item('OVP_Submit_Video_Assignment_uuid');
              	$version = $ci->config->item('OVP_Submit_Video_Assignment_version');
			break;
			
			case 'embed': //Publish to FLO (Embed Media)
				$uuid = $ci->config->item('OVP_Publish_to_FLO_uuid');
              	$version = $ci->config->item('OVP_Publish_to_FLO_version');
			break;
			
			case 'vault': //Media Vault (Teaching Team)
				$uuid = $ci->config->item('OVP_Media_Vault_uuid');
              	$version = $ci->config->item('OVP_Media_Vault_version');
			break;
			
			case 'teachers': //Purpose of Media Vault
				$uuid = $ci->config->item('OVP_Purpose_of_Media_Vault_uuid');
              	$version = $ci->config->item('OVP_Purpose_of_Media_Vault_version');
			break;
			
			case 'setup-assignment': //Setyp a Video Assignment
				$uuid = $ci->config->item('OVP_Setup_Video_Assignment_uuid');
              	$version = $ci->config->item('OVP_Setup_Video_Assignment_version');
			break;
			
			case 'faq': //FAQ
				$uuid = $ci->config->item('OVP_FAQ_uuid');
             	$version = $ci->config->item('OVP_FAQ_version');
			break;
			
			case 'preparation': //Creating and preparing video files
				$uuid = $ci->config->item('OVP_Creating_and_preparing_video_uuid');
              	$version = $ci->config->item('OVP_Creating_and_preparing_video_version');
			break;
			
			case 'types': //File Types explained
				$uuid = $ci->config->item('OVP_File_Types_explained_uuid');
              	$version = $ci->config->item('OVP_File_Types_explained_version');
			break;
			
			case 'player': //Player
				$uuid = $ci->config->item('OVP_Video_Player_uuid');
              	$version = $ci->config->item('OVP_Video_Player_version');
			break;
			
			default:
				$uuid = $ci->config->item('OVP_Video_Help_Dashboard_uuid');
      			$version = $ci->config->item('OVP_Video_Help_Dashboard_version');
			break;
			
		}
		
		if($uuid != '' && $version != '')
		{
			$item_array = $this->getItems($uuid, $version);
				
			if($item_array)
			{
				/*echo 'Item_array<pre>';
				print_r($item_array);
				echo '</pre>';*/
				$this->load->view('public/ovp/start', $item_array);
			}
		}
		else
		{
			$errdata['message'] = 'Invalid page';
			$this->load->view('public/ovp/showerror_view', $errdata);
			return;
		}
	}
	
	/**
     * Get item xml via REST
     *
     * @param array $uuid, item UUID
     * @param array $version, item Version
     */
	private function getItems($uuid, $version)
	{
		$errdata['heading'] = "Error";
		if($this->validate_params($uuid, $version) == false)
        {
           
            return false;
        }
            
        $success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = 'Failed to get FLEX item.';
            log_message('error','Failed to get FLEX item: ' . $this->flexrest->error);
            $this->load->view('public/ovp/showerror_view', $errdata);
            return false;
        }
		
		$xmlwrapper_name = 'xmlwrapper_'.$uuid;
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
		
		$item_array = $this->itemXml2Array($this->$xmlwrapper_name);
		
		$attachment_list = $response['attachments'];
		
		$idx = 0;
		if(isset($item_array['attachments']) && count($item_array['attachments']) >0)
		{	
			foreach($item_array['attachments'] as $attachment)
			{
				$idx++;
				$attachment_uuid = $attachment['uuid'];
				
				foreach($attachment_list as $act_attachments)
				{
					if($attachment_uuid == $act_attachments['uuid'])
					{
						
						$item_array['attachments'][$idx]['filename'] = isset($act_attachments['filename']) ? $act_attachments['filename'] : '';
						$item_array['attachments'][$idx]['type'] = $act_attachments['type'];
						$item_array['attachments'][$idx]['description'] = $act_attachments['description'];
						$item_array['attachments'][$idx]['size'] = $act_attachments['size'];
						$item_array['attachments'][$idx]['links'] = isset($act_attachments['links']) ? $act_attachments['links'] : '';
					}
					continue;
				}
				
				if($item_array['attachments'][$idx]['type'] == 'htmlpage')
				{
					$usertoken = $this->generateToken_by_shared_secret();
					$url = $item_array['attachments'][$idx]['links']['view'] . "&token=" . $usertoken;
					$pagecontent = file_get_contents($url);
					$item_array['attachments'][$idx]['pagecontent'] = $pagecontent;
				}
				
				if($item_array['attachments'][$idx]['type'] == 'kaltura')
				{
					$item_array['attachments'][$idx]['title'] = $act_attachments['title'];
					
				}
				if($item_array['attachments'][$idx]['type'] == 'url')
				{
					$item_array['attachments'][$idx]['filename'] = $act_attachments['description'];
					
				}
	
			}
		}
	
		
		/*echo 'response:<pre>';
		print_r($response);
		echo '</pre>';*/
		
		return $item_array;
	}
	
	/**
     * Validate incoming parameters
     *
     * @param array $uuid, item UUID
     * @param array $version, item Version
     */
    private function validate_params($uuid, $version)
    {

        if(strcmp($uuid, 'missed')==0 || strlen($uuid) != 36)
            return false;
        
        if(strcmp($version, 'missed')==0 || !is_numeric($version))
            return false;

        return true;
    }
	
	
	/**
     * Transfer metadata string to XML
     *
     * @param itemXML, the metadata string
     */
	private function itemXml2Array($itemXml)
	{
		$tmp = array();
		$tmp['description'] = $itemXml->nodeValue('/xml/item/itembody/name');
        if($itemXml->numNodes('/xml/item/itembody/attachments/uuid') > 0)
		{
			for ($i = 1; $i <= $itemXml->numNodes('/xml/item/itembody/attachments/uuid'); $i++) 
			{
				$tmp['attachments'][$i]['uuid'] = $itemXml->nodeValue('/xml/item/itembody/attachments/uuid['.$i.']');
			}
		}
		
		return $tmp;
	}
	
	
	
	/**
     * Generate an access token based on shared secrete ID
     *
     */
	private function generateToken_by_shared_secret()
    {
		$ci =& get_instance();
        $ci->load->config('flex');
        $username = $ci->config->item('ovp_shared_secret_username');
        $sharedSecretId = $ci->config->item('ovp_shared_secret_id');
        $sharedSecretValue = $ci->config->item('ovp_shared_secret_value');

        $time = mktime() . '000';
        return urlencode ($username) . ':' . urlencode($sharedSecretId) . ':' .  $time . ':' .
            urlencode(base64_encode (pack ('H*', md5 ($username . $sharedSecretId . $time . $sharedSecretValue))));

    }

}
