<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Caseview extends CI_Controller {
 
	public function index($uuid='missed', $version='missed')
	{
		
		if(!isset($_SESSION)){ session_start();}
		#echo "caseview.php - AC 18 AUG 2015<br />";
		
		#$this->output->enable_profiler(TRUE);
        $errdata['heading'] = "Error";
		
		if($this->validate_params($uuid, $version) == false)
        {
            $errdata['message'] = "Invalid Request - validate params";
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
		
		 $this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		$ci =& get_instance();
		$ci->load->config('flex');
		$collections = $ci->config->item('topic_information_collection');
		
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
		
		$success = $this->flexrest->getItem($uuid, $version, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            $this->load->view('ocf/showerror_view', $errdata);
            return;
        }
        
		/*
		
		echo "<pre>";
		print_r($response);
		echo "</pre>";
		
		*/
		
		
		$xmlwrapper_name = 'xmlwrapper'.'activity';
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);

		
				
		$item_array = $this->itemXml2Array($this->$xmlwrapper_name);
		
		$item_array['uuid'] = $uuid;
		$item_array['version'] = $version;
	
		
		
		/*
		echo "<pre>";
		echo "<h4>Item array</h4>";
		print_r($item_array);
		echo "</pre>";
		*/
		
		/*
		echo "<pre>";
		echo "<h4>Raw attachments</h4>";
		print_r($response['attachments']);
		echo "</pre>";
		*/
		
		
		$restricted = false;
		
		$attachments = array();
		$i = 0;
		
		foreach ($response['attachments'] as $attachment) {
			
			$cp = stripos($attachment['description'], 'cover photo');
			$ct = stripos($attachment['description'], 'case trigger');
			
			if (($cp <= 1) && ($ct <= 1)) {
			
			
			
			$i++;
			
			$attachments[$i]['cp'] = 0;
			$attachments[$i]['ct'] = 0;
			
			$attachments[$i]['cp'] = stripos($attachment['description'], 'cover photo');
			$attachments[$i]['ct'] = stripos($attachment['description'], 'case trigger');
			
			
			$attachments[$i]['title'] =  $attachment['description'];
			$attachments[$i]['filename'] =  $attachment['filename'];
			$attachments[$i]['thumbnail'] =  $attachment['thumbnail'];
			$attachments[$i]['uuid'] =  $attachment['uuid'];
			$attachments[$i]['type'] =  $attachment['type'];
			$attachments[$i]['url'] =  $attachment['url'];
			$attachments[$i]['thumbnailLink'] =  $attachment['links']['thumbnail'];
			$attachments[$i]['view'] =  $attachment['links']['view'];
			
				
			}
			
			
			
			
			
		
		}
		
		/*    ----------------        
		echo "<pre>";
		echo "<h4>Processed attachments</h4>";
		print_r($attachments);
		echo "</pre>";
		
		*/
		
		/*
		
		echo "<pre>";
		print_r($_SESSION);
		echo "</pre>";
		
		
		*/
        
       
	
				 
		$data = array('item' => $item_array, 'caseresources' => $attachments, 'token' => $this->generateToken($fan), 'privilege' => $user_role );

/*   --------------------  		
		
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		
*/	
	
        
		
				
		$this->load->view('ocf/pblcaseview', $data);
	 
} 



/**********************************/
/*       FUNCTIONS                */
/**********************************/



    /**
     * Check whether the item has a type of Topic Information
     *
     * @param xmlwrapper $itemXml
     */
    protected function itemIsActivity($itemXml) 
    { 
        $type = '/xml/item/curriculum/activities/activity/@type';
        $itemIsActivity = $itemXml->nodeValue($type);
        if(isset($itemIsActivity) && $itemIsActivity=='activity')
            return true;
        return false;
    }
	

  /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function itemXml2Array($itemXml) 
    { 

	
		$itemTitle = '/xml/item/itembody/name';
		$itemOverview = '/xml/item/specific/pbls/pbl/overview';
		$numberSections = '/xml/item/specific/pbls/pbl/number_sections';
		
		$tmp['itemTitle'] = $itemXml->nodeValue($itemTitle);
		$tmp['itemOverview'] = $itemXml->nodeValue($itemOverview);
		$tmp['numberSections'] = $itemXml->nodeValue($numberSections);
		
		return $tmp;
	}


    
	  /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
    protected function itemLOsXml2Array($itemXml) 
    {
		if($itemXml->numNodes('/xml/item/curriculum/outcomes/activity/los/lo') > 0)
		
		{
			
			$tmp3 = array();
			for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/activity/los/lo'); $i++) {
				$tmp3[$i]['sysid'] = $itemXml->nodeValue('/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/@sys_id');
				$tmp3[$i]['code'] = $itemXml->nodeValue('/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/code');
				$tmp3[$i]['name'] = $itemXml->nodeValue('/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/name');
	
			}
			
			return $tmp3;
		}
		
		else
		
		{
			
			return '';
			
			
		}

	
	
	}



	protected function loXml2Array($itemXml,$receivedID) 
    { 
		$numApply = 0;
		
		if($itemXml->numNodes('/xml/item/curriculum/outcomes/activity/los/lo') > 0)
		{
			$tmp2 = array();
			for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/outcomes/activity/los/lo'); $i++) {
				$tmp2['numberLOs'] = $itemXml->numNodes('/xml/item/curriculum/outcomes/activity/los/lo') ;			
				$numApply = 0;
	
				for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/aligned/act_items/act_item'); $j++) 			{
					$sysID = '/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/aligned/act_items/act_item['.$j.']/@sys_id';
					
					if( $receivedID === $itemXml->nodeValue($sysID)) { //The item matches this item
				
						$numApply++;
						$loName = '/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/name';
						$loCode = '/xml/item/curriculum/outcomes/activity/los/lo['.$i.']/code';		
						#$taa['los'][$i]['matching'] = "Y";
					
						$tmp2['los'][$i]['name'] = $itemXml->nodeValue($loName) ;
						$tmp2['los'][$i]['code'] = $itemXml->nodeValue($loCode) ;
		
						#$taa['lo'][$i]['code'] = $itemXml->nodeValue($loCode);					   						   
					 }
					$tmp2['numberApplicable'] = $numApply;
				}
	
			} // end of $i loop

			return $tmp2;
		}
		else
		{
			return '';
		}
		
		
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