<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Learningandteaching_add extends CI_Controller {

        public function __construct()
        {
            parent::__construct();
	    
	    $fan = $_SERVER['REMOTE_USER'];
	    $this->load->library('flexsoap/flexsoap');
	    if(!$this->flexsoap->success)
	    {

		    echo "Internal error. Please try again later.";
		    exit();
	    }
			
	    //get user group
	    $groups = $this->flexsoap->getGroupsByUser($fan);
	    //print_r($groups);

	    if(!$this->flexsoap->success)
	    {
		    echo "Internal error. Please try again later.";
		    exit();
	    }
	    $ci =& get_instance();
            $ci->load->config('flex');
	    //set up login user privilege
	    $usergrp_taa_moderator = $ci -> config ->item('TAA moderation grp'); //get taa moderator group uuid
	    $usergrp_taa_contributor = $ci -> config->item('TAA contributor grp'); //get taa contributor group uuid

	    $user_role = '';

	    if(strpos($groups, $usergrp_taa_moderator) !== false || strpos($groups, $usergrp_taa_contributor) !== false)
	    {
		    //$_SESSION['ocf_privilege'] = 'mod&con';
		    $user_role = 'moderator&contributor';
	    }
            else 
	    {
		echo "You don't have required privige for this operation.";
		exit();
	    }
            
	    
	}
	/*******************************************
	 * 
	 * Unlink activity from group
	 * 
	 *******************************************/
	public function delete_item_save($parent_uuid='missed', $parent_version='missed', $child_uuid='missed', $child_version='missed')
	{
	    
	    if(strcmp($parent_uuid, 'missed')==0 || strlen($parent_uuid) != 36)
                return false;
	    if(strcmp($child_uuid, 'missed')==0 || strlen($child_uuid) != 36)
                return false;
	    if(strcmp($parent_version, 'missed')==0 || strcmp($child_version, 'missed')==0)
                return false;
	    
	    $this->load->helper('url');
	    $ci =& get_instance();
	    $ci->load->config('flex');
	    // $institute_url = $ci->config->item('institute_url');
	    $collection_id = $ci->config->item('md_activities_collection');
	    
	    if(!isset($_SERVER['REMOTE_USER']))
		return false;
	    $fan = $_SERVER['REMOTE_USER'];
	    
	    $this->load->library('permission/permission');
	    $upd_privilege = $this->permission->get_ocf_activity_upd_privilege($fan, $parent_uuid, $parent_version);
	    if(!$this->permission->success)
	    {   
		echo 'Internal Error: Failed to get privilege.';
		exit();
	    }
	    if(!(isset($upd_privilege['has_privilege']) && $upd_privilege['has_privilege'] == 'Yes' && $upd_privilege['locks']['activities'] != 'Yes'))
	    {
		echo 'Error: no privilege or activity locked.';
		exit();
	    }
	    
	    $this->load->library('flexrest/flexrest');
	    $success = $this->flexrest->processClientCredentialToken();	
	    if(!$success)
	    {
		echo 'Error: Failed to connect to FLEX';
		return;
	    } 
	    
	    $ret_val1 = $this->flexrest->getLock($parent_uuid, $parent_version, $response1);
	    if($ret_val1 != false)
	    {
		    echo 'Item is being edited. Please try again later.';
		    exit();
	    }
	    #$ret_val1 = $this->flexrest->createLock($parent_uuid, $parent_version, $response1);
	    #if(!isset($response1['uuid']))
	    #{
		#    echo 'Failed to create edit lock. Please try again later.';
		#    exit();
	    #}
	    
	    $success = $this->flexrest->getItemAll($parent_uuid, $parent_version, $response_parent);  
	    if(!$success)
	    {
		#$this->flexrest->deleteLock($parent_uuid, $parent_version, $response1);
		echo 'Error: Failed to get item information from FLEX';
		return;
	    }
	    $parent_item_bean = $response_parent;
	    unset($parent_item_bean['headers']);
	    
	    //create a new item
	    #$item_bean["collection"]["uuid"] = $collection_id;
	    //root node
	    
	    
	    $existing_attachments = $parent_item_bean['attachments'];
	    #print_r($parent_item_bean['attachments']);return;
	    $num_attachments = count($existing_attachments );
	    //echo "number of attachments = " . $num_attachments . "<br />";
	    $new_attachments = array();
	    $attach_uuid = "";
	    for($i=0;$i<$num_attachments;$i++)
	    {
		if($existing_attachments[$i]['itemUuid'] != $child_uuid)
		{
		    $new_attachments[] = $existing_attachments[$i];
		}
		else
		{
		    $attach_uuid = $existing_attachments[$i]['uuid'];
		}
	    }
	    
	    $parent_item_bean['attachments'] = $new_attachments;
	    
	    
	    $xmlwrapper_name = 'xmlwrapper1';
	    $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$parent_item_bean['metadata']), $xmlwrapper_name);
	    
	    #$tmp['numLinked'] = $itemXml->numNodes('/xml/item/curriculum/activities/act_items/act_item');
	
	    #$itemXml = $this->$xmlwrapper_name;
	   
	    for ($i = 1; $i <= $this->$xmlwrapper_name->numNodes('/xml/item/curriculum/activities/act_items/act_item'); $i++) 
	    {

		$tmp_uuid = $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/activities/act_items/act_item['.$i.']/@sys_id');
		if($tmp_uuid == $attach_uuid)
		{
		    #log_message('error', 'before delete');
		    $this->$xmlwrapper_name->deleteNodeFromXPath('/xml/item/curriculum/activities/act_items/act_item['.$i.']');
		    #log_message('error', 'after delete');
		    break;
		}
	    }	
	    for ($i = 1; $i <= $this->$xmlwrapper_name->numNodes('/xml/item/curriculum/activities/linked_activities/uuid'); $i++) 
	    {

		$tmp_uuid = $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/activities/linked_activities/uuid['.$i.']');
		if($tmp_uuid == $attach_uuid)
		{
		    $this->$xmlwrapper_name->deleteNodeFromXPath('/xml/item/curriculum/activities/linked_activities/uuid['.$i.']');
		    break;
		}
	    }
	    $parent_item_bean['metadata'] = $this->$xmlwrapper_name->__tostring();
	    #print_r($parent_item_bean);return;

	    $updateparentsuccess = $this->flexrest->editItem($parent_uuid, $parent_version, $parent_item_bean, $updateresponse);
	    #$this->flexrest->deleteLock($parent_uuid, $parent_version, $response1);
	    if(!$updateparentsuccess)
	    {
			log_message('error', 'OCF: deleting activity, failed to edit item: ' . $this->flexrest->error);
			echo 'Error: Failed to edit item.';
			return;
	    }
		
	    echo 'Activity removed successfully.';
	    
			/************** static map ***************/
			
			$this->load->model('ocf/ocf_model');
			
			$return_topics = $this->ocf_model->db_get_content_by_item_uuid($parent_uuid, $parent_version);
			//$uuid_version = $parent_uuid.'/'.$parent_version;
			
			$uuid_version = $parent_uuid.'/'.$parent_version;
			
			for($i=0; $i<count($return_topics); $i++)
			{
				if(isset($return_topics[$i]['content']) && $return_topics[$i]['content']!='')
				{
					
					$content = trim(preg_replace("/&(?!(?:apos|quot|[gl]t|amp);|#)/", '&amp;', $return_topics[$i]['content']));
					
					$dom = new DOMDocument();
					libxml_use_internal_errors(true); //remove load html warning from log
					$dom -> loadHtml($content);
					
					$length = $dom->getElementsByTagName('a')->length;
					
					for($x=0; $x<=$length; $x++)
					{
						if ($dom->getElementsByTagName("a")->item($x) instanceof DOMNode) 
						{
							$href = $dom->getElementsByTagName("a")->item($x)->getAttribute("href");
							if(stripos($href, '/lta/'.$uuid_version)>0) //activity group
							{
								$path = $dom->getElementsByTagName("a")->item($x)->getNodePath();
								$new_xpath = $path;
								if(strrpos($path, "/a") >1)
								{
									$new_xpath = substr($path, 0, strrpos($path, "/a"));
								}
								
								$xpath = new DOMXPath($dom);
								$prev = $xpath->evaluate($new_xpath);
								if($prev != false)
								{
									//echo $xpath->query('.//a', $prev->item(0))->length;
									for($s=0; $s<$xpath->query('.//a', $prev->item(0))->length; $s++)
									{
										$a = $xpath->query('.//a', $prev->item(0))->item($s);
										
										if($a->hasAttributes())
										{
											$a_href = $a->getAttribute("href");
											/************if( is group activity) ************/
											
											if(stripos($a_href, '/lta/'.$child_uuid.'/'.$child_version)>0) //activity group
											{
												//echo 'found';
												$ul = $a->parentNode->parentNode;
												$ul->parentNode->removeChild($ul);
											}
											/************if( is activity) ************/
											elseif(stripos($a_href, '/activity/'.$child_uuid.'/'.$child_version.'/'.$parent_uuid.'/')>0) //activity
											{
												//echo 'found act';
												$ul = $a->parentNode->parentNode;
												$ul->parentNode->removeChild($ul);
											}
										}
									}
									$tmp = $dom->saveXML($dom,LIBXML_NOEMPTYTAG);
									$body_pos= stripos($tmp, '<body>')+6;
									$sbody_pos = stripos($tmp, '</body>');
									$tmp = substr($tmp, $body_pos, $sbody_pos-$body_pos);
									//echo $tmp;
									$return_status = $this->ocf_model->db_transaction_static_html(htmlspecialchars_decode($tmp), $return_topics[$i]['year_level'], $return_topics[$i]['course_code'], $return_topics[$i]['topic_code']);
									//echo $dom->saveHTML();
								}
							}
						}
					}
				}
			
		}
		/************** END of static map ***************/
	    
	    #$suc_notice = 'Activity deleted successfully.';
	    #echo $suc_notice;
	    
	}
	
	/*******************************************
	 * 
	 * Add new activity to group
	 * 
	 *******************************************/
	public function add_item_save()
	{
		
	    if(!isset($_POST['parent_uuid']) || !isset($_POST['parent_version']) || 
	       !isset($_POST['itemName']) || !isset($_POST['parent_tcode']) || !isset($_POST['activity_level']))
	    {
		echo 'invalid input.';
		return false;
	    }
	        

	    $parent_uuid = $_POST['parent_uuid'];
	    $item_name = $_POST['itemName'];
	    $parent_version = $_POST['parent_version'];
	    #$activity_type = $_POST['activity_type'];
	    $parent_tcode = $_POST['parent_tcode'];
	  
	    $activity_type = 'activity';
	    $activity_level = $_POST['activity_level'];
	    
	    if( strlen($parent_uuid) != 36 || strlen($item_name) == 0)
            {
		echo 'invalid input.';
		return false;
	    }
	    #echo $parent_uuid . '|||' . $parent_version . '|||' . $item_name . '|||' . $activity_type. '|||' . $activity_level;
	    #return;
	    #
	    #log_message('error', 'parent_version: ' . $parent_version);
	    // log_message('error', '$activity_level ' . $activity_level);
	    #echo 'ok';return;
	   
	    $ci =& get_instance();
	    $ci->load->config('flex');
	    // $institute_url = $ci->config->item('institute_url');
	    $collection_id = $ci->config->item('md_activities_collection');
	    
	    $fan = $_SERVER['REMOTE_USER'];
	    
	    $this->load->library('permission/permission');
	    $upd_privilege = $this->permission->get_ocf_activity_upd_privilege($fan, $parent_uuid, $parent_version);
	    if(!$this->permission->success)
	    {   
		echo 'Internal Error: Failed to get privilege.';
		exit();
	    }
	    if(!(isset($upd_privilege['has_privilege']) && $upd_privilege['has_privilege'] == 'Yes' && $upd_privilege['locks']['activities'] != 'Yes'))
	    {
		echo 'Error: no privilege or activity locked.';
		exit();
	    }
	    
	    $this->load->library('flexrest/flexrest');
	    $success = $this->flexrest->processClientCredentialToken();	
	    if(!$success)
	    {
		echo 'Error: Failed to connect to FLEX';
		return;
	    } 
	    
	    #Lock parent item for editing.
	    $ret_val1 = $this->flexrest->getLock($parent_uuid, $parent_version, $response1);
	    if($ret_val1 != false)
	    {
		    echo 'Item is being edited. Please try again later.';
		    exit();
	    }
	    /*$ret_val1 = $this->flexrest->createLock($parent_uuid, $parent_version, $response1);
	    if(!isset($response1['uuid']))
	    {
		    echo 'Failed to create edit lock. Please try again later.';
		    exit();
	    }*/
	    
	    $success = $this->flexrest->getItemAll($parent_uuid, $parent_version, $response_parent);  
	    if(!$success)
	    {
		#$this->flexrest->deleteLock($parent_uuid, $parent_version, $response1);
		echo 'Error: Failed to get item information from FLEX';
		return;
	    }
	    $parent_item_bean = $response_parent;
	    unset($parent_item_bean['headers']);
	    $xmlwrapper_name = 'xmlwrapper11';
	    $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$parent_item_bean['metadata']), $xmlwrapper_name);
	    
	    
	    //create a new item
	    $item_bean["collection"]["uuid"] = $collection_id;
	    //root node
	    $xmlwrapper_add = 'xmlwrapper_add';
	    $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => '<xml><item></item></xml>'), $xmlwrapper_add);

	    #Copy management groups from parent to child.
	    $count_topics = $this->$xmlwrapper_name->numNodes('/xml/item/curriculum/topics/topic/code');#parent
	    $item_topic_node = $this->$xmlwrapper_add->createNodeFromXPath('/xml/item/curriculum/topics/topic');#child
	    for ($i = 1; $i <= $count_topics; $i++) 
	    {
		#parent
		$tmp_topic_code_value = $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/topics/topic/code['.$i.']');
		#child
		$item_topic_code_node = $this->$xmlwrapper_add->createNode($item_topic_node, "code");
		$item_topic_code_node->nodeValue = $tmp_topic_code_value;
		#$item_topic_code_node = $this->$xmlwrapper_add->createNodeFromXPath('/xml/item/curriculum/topics/topic/code['.$i.']');
	        #$this->$xmlwrapper_add->createTextNode($item_topic_code_node, $tmp_topic_code);
	    }
	    #parent
	    $tmp_course_code_value = $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/courses/course/code');
	    #child
	    if($tmp_course_code_value != null)
	    {
		$course_code_node = $this->$xmlwrapper_add->createNodeFromXPath("/xml/item/curriculum/courses/course/code");
		$this->$xmlwrapper_add->createTextNode($course_code_node, $tmp_course_code_value);
	    }
	    #parent
	    $tmp_mgmt_code_value = $this->$xmlwrapper_name->nodeValue('/xml/item/restrictions/management/manage/@id');
	    #child
	    if($tmp_mgmt_code_value != null)
	    {
		$mgmt_node = $this->$xmlwrapper_add->createNodeFromXPath("/xml/item/restrictions/management/manage");
		$mgmt_id_node = $this->$xmlwrapper_add->createAttribute($mgmt_node, 'id');
		$mgmt_id_node->nodeValue = $tmp_mgmt_code_value;
	    }
	    #parent
	    $tmp_mgmt_code_value = $this->$xmlwrapper_name->nodeValue('/xml/item/restrictions/management/manage/@ocf_id');
	    #child
	    if($tmp_mgmt_code_value != null)
	    {
		$mgmt_node = $this->$xmlwrapper_add->createNodeFromXPath("/xml/item/restrictions/management/manage");
		$mgmt_id_node = $this->$xmlwrapper_add->createAttribute($mgmt_node, 'ocf_id');
		$mgmt_id_node->nodeValue = $tmp_mgmt_code_value;
	    }
	    
	    
	    //activity title, item name
	    $title = $item_name;
	    
	    $item_name_node1 = $this->$xmlwrapper_add->createNodeFromXPath("/xml/item/itembody/name");
            #$item_name_node1->nodeValue = str_replace('&', 'and', $title);
	    $this->$xmlwrapper_add->createTextNode($item_name_node1, $title);

	    // activity description
	    $item_description = "Please describe this activity";
	    $item_description_node = $this->$xmlwrapper_add->createNodeFromXPath("/xml/item/itembody/description");
	    $this->$xmlwrapper_add->createTextNode($item_description_node, $item_description);


	    // activity type attribute
	    // create node
	    $activity_node = $this->$xmlwrapper_add->createNodeFromXPath("/xml/item/curriculum/activities/activity");
	    $activity_name_node = $this->$xmlwrapper_add->createNodeFromXPath("/xml/item/curriculum/activities/activity/name");
	    #$activity_name_node = $this->xmlwrapper->createNode($activity_node, "name"); # not working well for '&'
	    $this->$xmlwrapper_add->createTextNode($activity_name_node, $title);
	    
	    $activity_type_node = $this->$xmlwrapper_add->createAttribute($activity_node, "type");
	    $activity_type_node->nodeValue = $activity_type;
	    
	    #$this->xmlwrapper->setNodeValue("/xml/item/curriculum/activities/activity/@type", $activity_type);

	    // owner fan 
	    $owner_fan_node = $this->$xmlwrapper_add->createNodeFromXPath("/xml/item/item_owners/owner/fan");
	    $this->$xmlwrapper_add->createTextNode($owner_fan_node, $fan);

	    // parent topic
	    #$created_for_node = $this->$xmlwrapper_add->createNodeFromXPath("/xml/item/curriculum/topics/topic/code");
	    #$this->$xmlwrapper_add->createTextNode($created_for_node, $parent_tcode);

	    $item_bean['metadata'] = $this->$xmlwrapper_add->__toString();
		
		
	    $itemsuccess = $this->flexrest->createItem($item_bean, $newitem);

	    if(!$itemsuccess)
	    {
		#$this->flexrest->deleteLock($parent_uuid, $parent_version, $response1);
		echo 'Error: Failed to create the new item.';
		log_message('error', 'OCF: failed to create new activity: ' . $this->flexrest->error);
		return;
	    }

	    if(!isset($newitem['headers']['location']))
	    {
		#$this->flexrest->deleteLock($parent_uuid, $parent_version, $response1);
		echo 'Error: Failed to create the new item.';
		log_message('error', 'OCF: failed to create new activity: ' . $this->flexrest->error);
		return;
	    }
	    $location = $newitem['headers']['location'];
	    $institute_url = $ci->config->item('institute_url');
	    $location1 = substr($location, strpos($location, 'item')+5);

	    $location1 = explode('/', substr($location1, 0, strlen($location1)-1));

	    $new_uuid = $location1[0];
	    $new_version = $location1[1];

	    #echo $new_uuid ;
	       
	    #$parent_item_bean = $response_parent;
	    #unset($parent_item_bean['headers']);

	    #Create new attachment UUID
	    $existing_attachments = $parent_item_bean['attachments'];
	    $num_attachments = count($existing_attachments );
	    
	    $parent_uuid_first32 = substr($parent_uuid, 0, 32);
	    $uuid_suffix = 1000;
	    for($i=0; $i<$num_attachments; $i++)
	    {
		$tmp_uuid = $existing_attachments[$i]['uuid'];
		$tmp_first32 = substr($tmp_uuid, 0, 32);
		if($tmp_first32 == $parent_uuid_first32)
		{    
		    $tmp_last4 = substr($tmp_uuid, -4);
		    if(is_numeric($tmp_last4))
		    {
			$int_last4 = (int)(intval($tmp_last4));
			if($int_last4 >= $uuid_suffix)
			    $uuid_suffix = (int)$int_last4 + 1;
		    }
		}
	    }
	    $new_attachment_uuid = $parent_uuid_first32 . sprintf("%04d", $uuid_suffix);
	    #$new_attachment_uuid = $new_uuid;
	    
	    #$xmlwrapper_name = 'xmlwrapper11';
	    #$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$parent_item_bean['metadata']), $xmlwrapper_name);
	    
	    $linked_act_xpath = "/xml/item/curriculum/activities/linked_activities";
	    $node_linked_act = $this->$xmlwrapper_name->createNodeFromXPath($linked_act_xpath);
	    $node_linked_act_uuid = $this->$xmlwrapper_name->createNode($node_linked_act, "uuid");
	    $node_linked_act_uuid->nodeValue = $new_attachment_uuid;
						
	    $act_items_xpath = "/xml/item/curriculum/activities/act_items";
	    $node_act_items = $this->$xmlwrapper_name->createNodeFromXPath($act_items_xpath);
	    
	    $node_act_item1 = $this->$xmlwrapper_name->createNode($node_act_items, "act_item");
	    #echo '22'; return;
	    $node_act_item1_sysid = $this->$xmlwrapper_name->createAttribute($node_act_item1, "sys_id");
	    
            $node_act_item1_cond = $this->$xmlwrapper_name->createNode($node_act_item1, "do_condition");
	    $node_act_item1_name = $this->$xmlwrapper_name->createNode($node_act_item1, "name");
	    
	    $node_act_item1_sysid->nodeValue = $new_attachment_uuid;
	    $node_act_item1_cond->nodeValue = "required";
	    $node_act_item1_name->nodeValue = $title;
	    
	    #$this->$xmlwrapper_name->setnodevalue("/xml/item/curriculum/activities/act_item/@sys_id", $new_attachment_uuid);

	    #do_condition
	    #$do_condition = $this->$xmlwrapper_name->createnodefromxpath("/xml/item/curriculum/activities/act_item/do_condition");
	    #$this->$xmlwrapper_name->createtextnode($do_condition, "required");

	    #name
	    #$name = $this->$xmlwrapper_name->createnodefromxpath("/xml/item/curriculum/activities/act_item/name");
	    #$this->$xmlwrapper_name ->createtextnode($name, $title);


	    $parent_item_bean['metadata'] = $this->$xmlwrapper_name ->__tostring();
	    #echo  $parent_item_bean['metadata'];

	    //echo "<pre>";
	    //print_r($parent_item_bean['attachments']);
	    //echo "</pre>";
	    #print_r($parent_item_bean);return;

	    #$existing_attachments = $parent_item_bean['attachments'];
	    #print_r($parent_item_bean['attachments']);return;
	    #$num_attachments = count($existing_attachments );
	    //echo "number of attachments = " . $num_attachments . "<br />";

	    $new_attachment[$num_attachments] = array('type'=>'linked-resource','uuid'=>$new_attachment_uuid, 'description'=>$title,
		'itemUuid'=>$new_uuid,'itemVersion'=>$new_version, 'resourceType'=>'p');


	    $parent_item_bean['attachments'] = array_merge($existing_attachments, $new_attachment);
	    
	    #print_r($parent_item_bean['attachments']);return;

	    $updateparentsuccess = $this->flexrest->editItem($parent_uuid, $parent_version, $parent_item_bean, $updateresponse);
	    #$this->flexrest->deleteLock($parent_uuid, $parent_version, $response1);
	    if(!$updateparentsuccess)
	    {
			log_message('error', 'OCF: Adding new activity: failed to edit item: ' . $this->flexrest->error);
			echo 'Error: New activity created but failed to edit parent item. Please link the new activity in FLEX.';
			return;
	    }
		else
		{
		        echo 'Activity added successfully.';
			
			/************Static map*****************/
			$this->load->model('ocf/ocf_model');
			$return_topics = $this->ocf_model->db_get_content_by_item_uuid($parent_uuid, $parent_version);
			if(!$return_topics)
			{
				return;
			}
			#log_message('error',$return_topics);
			
			$uuid_version = $parent_uuid.'/'.$parent_version;
			
			for($i=0; $i<count($return_topics); $i++)
			{
				$content = trim(preg_replace("/&(?!(?:apos|quot|[gl]t|amp);|#)/", '&amp;', $return_topics[$i]['content']));
				$dom = new DOMDocument();
				libxml_use_internal_errors(true); //remove load html warning from  the log
				$dom -> loadHtml($content);
				
				$length = $dom->getElementsByTagName('a')->length;
				
				for($x=0; $x<$length; $x++)
				{
					$href = $dom->getElementsByTagName("a")->item($x)->getAttribute("href");
					
					if(stripos($href, '/lta/'.$uuid_version)>0) //activity group
					{
						$path = $dom->getElementsByTagName("a")->item($x)->getNodePath();
						
						$new_xpath = $path;
						if(strrpos($path, "/a") >1)
						{
							$new_xpath = substr($path, 0, strrpos($path, "/a"));
						}
						
						$xpath = new DOMXPath($dom);
						$prev = $xpath->evaluate($new_xpath);
						if($prev != false)
						{
							/************if( is group activity) Not In Use************/
							//create new <ul>
							/*$new_ul = $dom->createElement('ul');
						
							$new_li = $dom->createElement('li');
							$new_li_class = $dom->createAttribute('class');
							$new_li_class -> value = 'parent_li';
							$new_li->appendChild($new_li_class);
							
						
							$new_span = $dom->createElement('span', '&lt;i class="fa fa-plus-circle"&gt;&lt;/i&gt;&nbsp;FMC :: General Practice///////////////////////////');
							$new_span_title = $dom->createAttribute('title');
							$new_span_title->value = 'Expand this';
							$new_span->appendChild($new_span_title);
							
							
							$new_a = $dom->createElement('a', '&lt;i&gt;detail&lt;/i&gt;');
							$new_a_class = $dom->createAttribute('href');
							$new_a_class->value = '/flex/ocf_han/lta/4d2ed86a-f808-4e54-a276-95dcf5eaa43b/1/';
							$new_a->appendChild($new_a_class);
							
							
							$new_li->appendChild($new_span);
							$new_li->appendChild($new_a);
							$new_ul->appendChild($new_li);
							$prev->item(0)->appendChild($new_ul);*/
							
							/************if( is activity) ************/
							
							$new_ul = $dom->createElement('ul');
						
							$new_li = $dom->createElement('li', '&nbsp;&nbsp;');
							$new_li_class = $dom->createAttribute('class');
							$new_li_class -> value = 'child_li';
							$new_li_style = $dom->createAttribute('style');
							$new_li_style -> value = 'display:list-item;';
							$new_li->appendChild($new_li_class);
							$new_li->appendChild($new_li_style);
							
							$new_a = $dom->createElement('a', $item_name);
							$new_a_class = $dom->createAttribute('href');
							$new_a_class->value = '/flex/ocf/activity/'.$new_uuid.'/'.$new_version.'/'.$parent_uuid.'/'.($activity_level+1).'/';
							$new_a_data = $dom->createAttribute('data-toggle');
							$new_a_data->value = 'modal';
							$new_a_target = $dom->createAttribute('data-target');
							$new_a_target->value = '#myModal';
							$new_a_title = $dom->createAttribute('title');
							$new_a_title->value = 'View activity detail';
							
							$new_a->appendChild($new_a_class);
							$new_a->appendChild($new_a_data);
							$new_a->appendChild($new_a_target);
							$new_a->appendChild($new_a_title);
							$new_li->appendChild($new_a);
							
							$new_ul->appendChild($new_li);
							$prev->item(0)->appendChild($new_ul);
							
							//echo $dom->saveHTML();
						}
					}
				}
				$tmp = $dom->saveXML($dom,LIBXML_NOEMPTYTAG);
				$body_pos= stripos($tmp, '<body>')+6;
				$sbody_pos = stripos($tmp, '</body>');
				$tmp = substr($tmp, $body_pos, $sbody_pos-$body_pos);
				
				$return_status = $this->ocf_model->db_transaction_static_html(htmlspecialchars_decode($tmp), $return_topics[$i]['year_level'], $return_topics[$i]['course_code'], $return_topics[$i]['topic_code']);
			   
				#log_message('error',$return_status);
			}
		}
		
		/***************END of Static map**********************************/
		
	    #$suc_notice = 'Activity added successfully.';
	    #echo $suc_notice;


	}
	/*
	public function add_act($uuid='missed', $version='missed', $tcode='missed', $activity_level='missed', $depth='missed')
	{
	    $this->load->helper('url');
	    $data['parent_uuid'] = $uuid;
	    $data['parent_version'] = $version;
	    $data['parent_tcode'] = $tcode;
	    $data['activity_level'] = $activity_level;
	    $this->load->view('ocf/lta_item_add_view', $data);
	}
	
	public function add_item_form($uuid, $version, $tcode,$activity_level)
	{
	    $this->load->helper('url');
	    $data['parent_uuid'] = $uuid;
	    $data['parent_version'] = $version;
	    $data['parent_tcode'] = $tcode;
	    $data['activity_level'] = $activity_level;
	    log_message('error', 'form: parent_uuid: ' . $uuid);
	    #echo 'ok';return;
	    $this->load->view('ocf/add_activity_form_view', $data);
	}
	*/
   

} 
