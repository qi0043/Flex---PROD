<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Workflow extends CI_Controller 
{
	public function __construct()
    {
		parent::__construct();
	
	}
	 
	 /***********************************************************************
	  Redraft a rejected item and then submit for moderation
	  @uuid      item uuid
	  @version   verison no
	 ************************************************************************/
	 public function redraftAndModMilestone($uuid='missed', $version='missed')
	 {
		$ci =& get_instance();
		$ci->load->config('rex');
		 //define logger folder application/logs/cs
		$loggings = $ci->config->item('log');
		$this->load->library('logging/logging',$loggings); //call loggings from the lib
        $this->logger_cs = $this->logging->get_logger('cs'); //get cs folder
		
		 if(!$this->validate_params($uuid,$version))
		 {
			 $this->logger_cs->error("Workflow redraft milestone error: invalid uuid or version no - " . $uuid."/".$version);
			 return false;
		 }
		
		//$this->load->helper('url');
		$oauth = array('oauth_client_config_name' => 'rhd');
		$this->load->library('rexrest/rexrest', $oauth);
		
		$success = $this->rexrest->processClientCredentialToken();
		
		if(!$success)
		{
			$this->logger_cs->error("Workflow redraft milestone processClientCredentailToekn error:".$this->rexrest->error.'-' . $uuid."/".$version);
			return false;
		}
		
		$success = $this->rexrest->getItem($uuid, $version, $response);
		if(!$success)
		{
			$this->logger_cs->error("Workflow redraft milestone getItem error:".$this->rexrest->error.'-' . $uuid."/".$version);
			return false;
		}
		
		
		if($response['status'] == 'rejected')
		{
			$success = $this->rexrest->item_redraft($uuid, $version, $response);
			if(!$success)
			{
				$this->logger_cs->error("Workflow redraft milestone item_redraft error:".$this->rexrest->error.'-' . $uuid."/".$version);
				return false;
			}
			
			$success = $this->rexrest->getItem($uuid, $version, $r);
			if(!$success)
			{
				$this->logger_cs->error("Workflow redraft milestone getItem error:" . $this->rexrest->error. '-' . $uuid."/".$version);
				return false;
			}
			
			if($r['status'] == 'draft')
			{
				$success = $this->rexrest->submitForModeration($uuid, $version, $r);
				if(!$success)
				{
					$this->logger_cs->error("Workflow redraft milestone submitForModeration error:".$this->rexrest->error. '-' . $uuid."/".$version);
					return false;
				}
				
				return true;
			}
			else
			{
				$this->logger_cs->error("Workflow redraft milestone - unable to submit for moderation - item status is:".$r['status'].'-' . $uuid."/".$version);
				return false;	
			}
		}
		else
		{
			$this->logger_cs->error("Workflow redraft milestone - unable to redrafte - item status is:".$response['status'].'-' . $uuid."/".$version);
			return false;	
		}
	 }
	
	
	/***********************************************************************
	  Automatically Redraft an item that the form hasn't completed
	  @uuid      item uuid
	  @version   verison no
	 ************************************************************************/
	public function redraftMilestone($uuid='missed', $version='missed')
	{
		$ci =& get_instance();
		$ci->load->config('rex');
		$loggings = $ci->config->item('log');
		$this->load->library('logging/logging',$loggings); //call loggings from the lib
        $this->logger_cs = $this->logging->get_logger('cs'); //get cs folder
		
		 if(!$this->validate_params($uuid,$version))
		 {
			 $this->logger_cs->error("Workflow redraft milestone error: invalid uuid or version no - " . $uuid."/".$version);
			 return false;
		 }
		 
		//$this->load->helper('url');
		$oauth = array('oauth_client_config_name' => 'rhd');
		$this->load->library('rexrest/rexrest', $oauth);
		
		$success = $this->rexrest->processClientCredentialToken();
		
		if(!$success)
		{
			$this->logger_cs->error("Workflow redraft milestone processClientCredentailToekn error:".$this->rexrest->error.'-' . $uuid."/".$version);
			return false;
		}
		
		$success = $this->rexrest->getItem($uuid, $version, $response);
		if(!$success)
		{
			$this->logger_cs->error("Workflow redraft milestone getItem error:".$this->rexrest->error.'-' . $uuid."/".$version);
			return false;
		}

		if($response['status'] == 'moderating'|| $response['status'] == 'live')
		{
			$success = $this->rexrest->item_redraft($uuid, $version, $response);
			if(!$success)
			{
				$this->logger_cs->error("Workflow redraft milestone item_redraft error:".$this->rexrest->error.'-' . $uuid."/".$version);
				return false;
			}
			else
			{
				echo 'true';
				return true;
			}
			
		}
		else
		{
			$this->logger_cs->error("Workflow redraft milestone - unable to redraft item" . $uuid."/".$version);
			return false;	
		}

		
	}

    public function getComment($uuid='missed', $version='missed')
    {
        $ci =& get_instance();
        $ci->load->config('rex');
        $loggings = $ci->config->item('log');
        $this->load->library('logging/logging', $loggings); //call loggings from the lib
        $this->logger_cs = $this->logging->get_logger('cs'); //get cs folder

        if (!$this->validate_params($uuid, $version)) {
            $this->logger_cs->error("Workflow redraft milestone error: invalid uuid or version no - " . $uuid . "/" . $version);
            return false;
        }

        //$this->load->helper('url');
        $oauth = array('oauth_client_config_name' => 'rhd');
        $this->load->library('rexrest/rexrest', $oauth);

        $success = $this->rexrest->processClientCredentialToken();

        if (!$success) {
            $this->logger_cs->error("Workflow redraft milestone processClientCredentailToekn error:" . $this->rexrest->error . '-' . $uuid . "/" . $version);
            return false;
        }

        $success = $this->rexrest->getItemHistory($uuid, $version, $response);
        if (!$success) {
            $this->logger_cs->error("Workflow redraft milestone getItem error:" . $this->rexrest->error . '-' . $uuid . "/" . $version);
            return false;
        }
        echo 'response: <pre>';
        print_r($response);
        echo '</pre>';
    }
	 
	private function validate_params($uuid, $version)
	{
		if(strcmp($uuid, 'missed')==0 || strlen($uuid) != 36)
		{
			return false;
		}
		
		if(strcmp($version, 'missed')==0 || !is_numeric($version))
		{
			return false;
		}
		
		return true;
	}
	
}
?>