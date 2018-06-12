<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Updatename extends CI_Controller {
 
	public function index($uuid='missed', $version='missed')
	{
		if(!isset($_SESSION)){ session_start();}
		sleep(1);
		
	    $this->load->model('ocf/ocf_model');
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
			return;
          /*$errdata['message'] = 'Permission not granted';
			$errdata['heading'] = "Internal error";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();*/
			//exit();
        }
		
        $permission_array = $this->permission->get_ocf_permission($fan);
		
		if ($_SESSION['ocf_privilege'] = 'mod&con') {
			
			$user_role = 'moderator&contributor';
		}
		else
		{
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
			echo 'Item is currently editing by others. Please try again later! <br/>';
			
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
			 
			//echo $item_bean['metadata'] . "\n\n";
			 
			$xmlwrapper = 'xmlwrapper';
		
			//pull out metadata XML 
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$item_bean['metadata']), $xmlwrapper);
			
			
			$activityname = $this->xmlwrapper->nodeValue("/xml/item/curriculum/activities/activity/name");
			
			$newname = $this->input->post('name');
			
			//echo "old name: " . $activityname . "\n";
			//echo "input name: " .  $newname . "\n";
			
			//echo $this -> xml_entities(html_entity_decode($newname));
			$newactivityname = $this->xmlwrapper->setNodeValue("/xml/item/curriculum/activities/activity/name", $this->xml_entities(html_entity_decode($newname)));
	
			$updatedname = $this->xmlwrapper->nodeValue("/xml/item/curriculum/activities/activity/name");
			
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
			   
			  // echo "Update complete!";
			   
			   /* -------------------      */   
		
			$updatesuccess = $this->flexrest->getItem($uuid, $version, $updateresponse);
			if(!$updatesuccess)
			{
				$errdata['message'] = $this->flexrest->error;
				$this->load->view('ocf/showerror_view', $errdata);
				return;
			}
			
			$xmlname = 'xmlwrapper_r';
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$updateresponse['metadata']), $xmlname);
		
			$activity_item = $this->itemXml2Array($this->$xmlname);
			//print_r($activity_item);
			
			$return_topics = $this->ocf_model->db_get_content_by_item_uuid($uuid, $version);
			if(!$return_topics)
			{
				$errdata['message'] = 'have found this activity';
				return;
			}
			
			//echo "<pre>Return topic:";       
			//echo count($return_topics).'<br/>';                          
		//	print_r($return_topics);
			
			$uuid_version = $uuid.'/'.$version;
			
			for($i=0; $i<count($return_topics); $i++)
			{
				//$content = $return_topics[$i]['content'];
				$content = trim(preg_replace("/&(?!(?:apos|quot|[gl]t|amp);|#)/", '&amp;', $return_topics[$i]['content']));
				$dom = new DOMDocument();
				libxml_use_internal_errors(true); //remove load html warning from log
				@$dom -> loadHtml($content);
				//log_message('error', htmlspecialchars_decode($dom->saveXML()));
				$length = $dom->getElementsByTagName('a')->length;
				//log_message('error', htmlspecialchars_decode($dom->saveXML()));
				
				for($x=0; $x<$length; $x++)
				{
					$href = $dom->getElementsByTagName("a")->item($x)->getAttribute("href");
					//echo $href;
					if(stripos($href, 'ocf/lta/'.$uuid_version)>0) //activity group
					{
						$path = $dom->getElementsByTagName("a")->item($x)->getNodePath();
						
						$new_xpath = rtrim($path, "a").'span';
					
						$xpath = new DOMXPath($dom);
						$prev = $xpath->evaluate($new_xpath);
						$old_name = $prev->item(0)->textContent;
						
						$x_xpath = rtrim($path, "a").'span/small';
						$spath = new DOMXPath($dom);
						$s= $spath->evaluate($x_xpath);
						//log_message('error', $s->item(0)->textContent);
						//$old_name = $prev->item(0)->nodeValue;
						/*if(stripos('&nbsp;&nbsp;pick&nbsp;1&nbsp;of&hellip;', $old_name)>0)
						{
							$old_name = substr($old_name, stripos('&nbsp;&nbsp;pick&nbsp;1&nbsp;of&hellip;', $old_name));
						}
*/						//log_message('error', $old_name );
						
						$text = trim($this->xml_entities($activity_item['activity_name']));
						//$text = trim(htmlspecialchars($activity_item['activity_name']));
						//log_message('error', $text );
						foreach($prev->item(0)->childNodes as $child) 
						{ 
						    $child_name = $child->nodeValue;
							
							if($child_name == $old_name)
							{
								$child->nodeValue = str_replace($old_name, '&nbsp;'.$text, $child->nodeValue);
							   // echo 'child: '.$child->nodeValue . "<br />";
							}
							//elseif($child_name.'pick&nbsp;1&nbsp;of&hellip;' == $old_name)
							elseif($child_name.$s->item(0)->textContent == $old_name)
							{
								
								
								$spos= stripos($old_name, $s->item(0)->textContent);
								$old_name = substr($old_name, 0, $spos-12);
								$child->nodeValue = str_replace($old_name, '&nbsp;'.$text, $child->nodeValue);
								//$child->nodeValue = ' '.$text.' ';
							}
							
						}
					}
					elseif(stripos($href, 'ocf/activity/'.$uuid_version)>0) //activity
					{
						if(isset($activity_item['activity_name']))
						{
							$dom->getElementsByTagName("a")->item($x)->nodeValue = trim($this->xml_entities($activity_item['activity_name']));
							//log_message('error', trim($this->xml_entities($activity_item['activity_name'])));
						}
					}	
					
				}
				
				$tmp = $dom->saveXML($dom,LIBXML_NOEMPTYTAG);
				$body_pos= stripos($tmp, '<body>')+6;
				$sbody_pos = stripos($tmp, '</body>');
				$tmp = substr($tmp, $body_pos, $sbody_pos-$body_pos);
				//$tmp = preg_replace('/\/>/', '></i>', $tmp);
				//log_message('error', htmlspecialchars_decode($tmp) );
			
				$return_status = $this->ocf_model->db_transaction_static_html(htmlspecialchars_decode($tmp), $return_topics[$i]['year_level'], $return_topics[$i]['course_code'], $return_topics[$i]['topic_code']);
			  //  echo $return_status; 
			  }
				$item_array['name'] = $updateresponse['name'];
				$item_array['uuid'] = $uuid;
				$item_array['version'] = $version;
					
				$data = array('item' => $item_array,  'token' => $this->generateToken($fan), 'privilege' => $user_role );
	
				$this->load->view('ocf/updatedname', $data);
			  }
		}

} 



/**********************************/
/*      PRIVATE FUNCTIONS         */

/**********************************/

private function Xml2Array($itemXml) 
    {
    
		
		$newname = $this->input->post('name');
		
		//$tmp = $itemXml->nodeValue('/xml/item/curriculum/activities/activity/name');
		
		//echo $newname;
	

      	return $tmp;
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
	
	
     /**
     * Extract XML data and store it in array
     *
     * @param xmlwrapper $itemXml
     */
	 
    protected function itemXml2Array($itemXml) 
    {		
		$tmp = array();
	    $activityType = '/xml/item/curriculum/activities/activity/@type';
		$tmp['activity_type'] =  $itemXml->nodeValue($activityType);
		$activityName = '/xml/item/itembody/name';
		$tmp['activity_name'] =  $itemXml->nodeValue($activityName);
	   //$tmp['numActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_actvities/uuid');
	   
	   	// Put the linked activity uuids into an array
		
		/*for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');  $i++) 
		{
			$uuid = '/xml/item/curriculum/activities/linked_activities/uuid['.$i.']';
			$tmp[$i]['uuid'] = $itemXml->nodeValue($uuid);
		}*/
        return $tmp;
    }


}