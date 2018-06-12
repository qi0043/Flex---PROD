<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/***********************************************************************

Class to restrict or release  embargo thesis

@$itemUuid            thesis item uuid
@$itemVersion         thesis version number
@$condition boolean   true: restrict thesis / false release thesis
************************************************************************/
class RhdRestriction extends CI_Controller {
	
	public function index($itemUuid='missed', $itemVersion='missed', $condition='true')
    {   
		if($condition!='true' && $condition!= 'false')
		{
			 $errdata['message'] = "Invalid Request";
			//log_message('error', 'invalid request item uuid: ' . $itemUuid . ', error: ' . $errdata['message']);
            $this->load->view('rhd/showerror_view', $errdata);
            return;
		
		}
		
		
		session_start();
	    ignore_user_abort(true);
		// Set your timelimit to a length long enough for your script to run, 
		// but not so long it will bog down your server in case multiple versions run 
		// or this script get's in an endless loop.
		$content = '';
		if($condition == 'true')
		{
			$content = 'Thesis restricted!';         // Get the content of the output buffer
		}
		else if($condition == 'false')
		{
			$content = 'Thesis released!';         // Get the content of the output buffer
		}
		#ob_end_clean();                     // Close current output buffer
		$len = strlen($content);             
		header('Content-Type: text/html; charset=UTF-8');
		header('Content-Encoding: none;');
		header('Connection: close');         // Tell the client to close connection
		header("Content-Length: $len");      // Close connection after $size characters
		echo $content;                       // Output content
		ob_flush();
        flush();                             // Force php-output-cache to flush to flex.
                                             
		ob_end_flush();                       
										 
        #make sure sam work flow completely finishes
		sleep(5);
        $errdata['heading'] = "Error";
        
        if($this->validate_params($itemUuid, $itemVersion, $condition) == false)
        {
            $errdata['message'] = "Invalid Request";
			//log_message('error', 'invalid request item uuid: ' . $itemUuid . ', error: ' . $errdata['message']);
            $this->load->view('rhd/showerror_view', $errdata);
            return;
        }
		
        $this->load->helper('url');
		$oauth = array('oauth_client_config_name' => 'rhd');
	    $this->load->library('flexrest/flexrest', $oauth);
       // $this->load->library('flexrest/flexrest');
        
        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            //$this->load->view('rhd/showerror_view', $errdata);
			log_message('error', 'Failed processClientCredentialToken, item uuid: ' . $itemUuid . ', error: ' . $errdata['message']);
            return;
        }    
        
        $success = $this->flexrest->getItem($itemUuid, $itemVersion, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
			//log_message('error', 'get item failed (getItemAll), item uuid: ' . $itemUuid . ', error: ' . $errdata['message']);
            $this->load->view('rhd/showerror_view', $errdata);
            return;
		}
		
		unset($response['headers']);
		$item_bean = $response;
		$xmlwrapper = 'xmlwrapper_'.$itemUuid;
    
		//pull out metadata XML 
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$item_bean['metadata']), $xmlwrapper);
		$theses = $this->Xml2Array($this->$xmlwrapper);
		/*echo 'Theses array: <pre>';
		print_r($theses);
		echo '</pre>';*/
		
		/*echo 'response attachment: <pre>';
		print_r($response['attachments']);
		echo '</pre>';*/
		
		$release_status = $theses['release_status'];
		$attachment = $item_bean['attachments'];
		
		// if the status is restircted access, restrict  or release all theses
		if($release_status == 'Restricted Access' || $release_status == 'Never for release')
		{
			
				if(isset($theses['examined_thesis']) && count($theses['examined_thesis'])>0)
				{
					foreach($theses['examined_thesis'] as $e_thesis)
					{
						$e_uuid = $e_thesis['uuid'];
						
						for($i=0; $i<count($attachment); $i++)
						{
							$a_uuid = $attachment[$i]['uuid'];
							
							if($e_uuid == $a_uuid)
							{
								  if($theses['open_access_required'] == 'new version' && isset($theses['open_access_thesis']) && count($theses['open_access_thesis'])>0)
								  {
									  //always restrict 'examined thesis' if the release thesis is different as the approved thesis.
								  	  $item_bean['attachments'][$i] = $this->setRestriction($attachment[$i], 'true');
								  }
								  else if($theses['open_access_required'] == 'version of record')
								  {
									  $item_bean['attachments'][$i] = $this->setRestriction($attachment[$i], $condition);
								  }
								  
								  break;
							}
						}
					}
				}
				
			   if($theses['open_access_required'] == 'new version' && isset($theses['open_access_thesis']) && count($theses['open_access_thesis'])>0)
			   {
				   foreach($theses['open_access_thesis'] as $o_thesis)
				   {
					   $o_uuid = $o_thesis['uuid'];
					   for($j=0; $j<count($attachment); $j++)
					   {
							$a_uuid = $attachment[$j]['uuid'];
							if($o_uuid == $a_uuid)
							{
								$item_bean['attachments'][$j] = $this->setRestriction($attachment[$j], $condition);
								break;
							}
					   }
				   }
			   }
			
	   }
	   // if the status is Open Access, only restrict examined theses
	   else if($release_status == 'Open Access')
	   {
		   if($theses['open_access_required'] == 'new version' && isset($theses['open_access_thesis']) && count($theses['open_access_thesis'])>0)
		   {
			   if(isset($theses['examined_thesis']) && count($theses['examined_thesis'])>0)
				{
					foreach($theses['examined_thesis'] as $e_thesis)
					{
						$e_uuid = $e_thesis['uuid'];
						
						for($i=0; $i<count($attachment); $i++)
						{
							$a_uuid = $attachment[$i]['uuid'];
							if($e_uuid == $a_uuid)
							{
								  $item_bean['attachments'][$i] = $this->setRestriction($attachment[$i], 'true');
								  break;
							}
						}
					}
				}
			   
			   foreach($theses['open_access_thesis'] as $o_thesis)
			   {
				   $o_uuid = $o_thesis['uuid'];
				   for($j=0; $j<count($attachment); $j++)
				   {
						$a_uuid = $attachment[$j]['uuid'];
						if($o_uuid == $a_uuid)
						{
							$item_bean['attachments'][$j] = $this->setRestriction($attachment[$j], 'false');
							break;
						}
				   }
			   }
			   
		   }
	   }
	   
	   if($condition == 'false')
	   {
	   		$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/thesis/release/embargo_release/release_status", 'Released', true);
	   		$current_date = date("Y-m-d");
	   		$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/thesis/release/embargo_release/embargo_release_date", $current_date, true);
	   }
	   
	   // copy files
	   $s = $this->flexrest->filesCopy($itemUuid, $itemVersion, $f_response);
	   if($s)
	   {
		   if(!isset($f_response['headers']['location']))
		   {
				$errdata['message'] = 'No Location header in response to copy files REST call.';
				log_message('error', 'Copying file failed, item uuid: ' . $itemUuid . ', error: ' . $errdata['message']);
				//$this->load->view('rhd/showerror_view', $errdata);
				return;
		   }
		   $location = $f_response['headers']['location'];
		   $filearea_uuid = substr($location, strpos($location, 'file')+5, 36);
		   $response['metadata'] = $this->$xmlwrapper->__toString();
		   $f = $this->flexrest->editItem($itemUuid, $itemVersion, $item_bean, $re, $filearea_uuid);
		   if(!$f)
		   {
				$errdata['message'] = $this->flexrest->error;
				log_message('error', 'restrict attachment failed (editItem), item uuid: ' . $itemUuid . ', error: ' . $errdata['message']);
				//$this->load->view('rhd/showerror_view', $errdata);
				return;
		   }
	   }
	   else
	   {
		   $errdata['message'] = 'file copy error:'. $this->flexrest->error;
		   log_message('error', 'file copy error: failed, item uuid: ' . $itemUuid . ', error: ' . $errdata['message']);
		   
		  // $this->load->view('rhd/showerror_view', $errdata);
		   return;
	   }
	   
	}
	
	
	/****************** private functions **********************************************************/
	
	private function setRestriction($att, $setValue)
	{
		$att['restricted'] = $setValue;
		return $att;
	}
	/***
	 * transfer metadata to array
	 * @itemXml   
	***/
	private function Xml2Array($itemXml) 
    {
       $tmp = array();
       $release_status = '/xml/item/curriculum/thesis/release/status';
	   $tmp['release_status'] = $itemXml->nodeValue($release_status);
	   
	   $tmp['numExaminedThesis'] = $itemXml->numNodes('/xml/item/curriculum/thesis/version/examined_thesis/files/uuid'); 
	   for ($i = 1; $i <= $tmp['numExaminedThesis'];  $i++) {
			
			$examined_thesis_uuid = '/xml/item/curriculum/thesis/version/examined_thesis/files/uuid['.$i.']';
			$tmp['examined_thesis'][$i]['uuid'] = $itemXml->nodeValue($examined_thesis_uuid);
	   }

	   $open_access_required = '/xml/item/curriculum/thesis/version/open_access/required';
	   $tmp['open_access_required'] =  $itemXml->nodeValue($open_access_required);
	   
	   if($tmp['open_access_required'] == 'new version')
	   {
		   $tmp['numOpenThesis'] = $itemXml->numNodes('/xml/item/curriculum/thesis/version/open_access/files/uuid');
		   
		   for ($i = 1; $i <= $tmp['numOpenThesis'];  $i++) {
				$open_access_thesis_uuid = '/xml/item/curriculum/thesis/version/open_access/files/uuid['.$i.']';
				$tmp['open_access_thesis'][$i]['uuid'] = $itemXml->nodeValue($open_access_thesis_uuid);
	   	   }
	   }
       return $tmp;
    }
	/**
     * Validate incoming parameters
     *
     * @param array $uuid, item UUID
     * @param array $version, item Version
     */
    protected function validate_params($uuid, $version, $con)
    {
        if(strcmp($uuid, 'missed')==0 || strlen($uuid) != 36)
            return false;
        
        if(strcmp($version, 'missed')==0 || !is_numeric($version))
            return false;
			
		if($con!='true' && $con!='false')
		{
			return false;
		}
        
        return true;
    }
	
}
