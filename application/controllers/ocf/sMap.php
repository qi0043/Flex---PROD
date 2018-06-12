<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class sMap extends CI_Controller 
{
	 public function __construct()
     {
		parent::__construct();
		$ci =& get_instance();
		$ci->load->config('flex');
		$this->load->helper('url');
		$this->load->library('flexrest/flexrest');
		$this->load->model('ocf/ocf_model');
		
		#check down time before authentication through FLEX
		$down_notice = false;
		$down_notice = $this->ocf_model->db_chk_notice();
		if($down_notice != false)
		{
			#$this->error_info($down_notice['message']);
			if ($down_notice['message'] == '')
				$down_notice['message'] = 'Online Curriculum Framework is temporarily unavailable, please try again later.';
			#echo $down_notice['message'];
			$errdata['message'] = $down_notice['message'];
			$errdata['heading'] = "Notice";
			$this->load->view('ocf/showerror_view', $errdata);
			$this->output->_display();
			exit;
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
	 }
	 
	 public function getStaticMap($courseCode)
	 {
		$courseCode = strtoupper($courseCode);
		if(!$this->validate_params($courseCode))
		{
			$errdata['message'] = 'Invalid course code';
            $this->load->view('ocf/showerror_view', $errdata);
            return;
		}    
		
		#check course code
		$check_course_code = $this->ocf_model->db_get_courseInfo($courseCode);
		if(!$check_course_code)
		{
			$errdata['message'] = 'course code not valid';
			$this->load->view('ocf/showerror_view', $errdata);
			return;
		}
		$course_year = $check_course_code[0]['course_total_year'];
		//echo $course_year .'<br/>';
		$course=array();
		$data = array('course' =>$this->getStaticTopics($courseCode, (int)$course_year, $course, 1));
		unset($course);
		/*echo 'data: <pre>';
		print_r($data);
		echo '</pre>';*/
		$this->load->view('ocf/sMap_view', $data);	 
	 }
	 
	 private function getStaticTopics($courseCode, $year_level, $course, $current_depth)
	 {
		while($current_depth <= $year_level)
		{
			 $db_topics = $this->ocf_model->db_get_static_topics_html($current_depth, $courseCode);
			 for($i=0; $i<count($db_topics); $i++)
			 {
				 $course[$current_depth][$i+1] = $db_topics[$i];
			 }
			 $current_depth++;
			 $this->getStaticTopics($courseCode, $year_level, $course, $current_depth);	 
		 }
		 
		 $course['course_code'] = $courseCode;
		 return $course;
		 
	 }
	 
	 
	 
	 /** Topic Refresh button Ajax cal function***/
	 public function getSingleTopic()
	 {
		 $this->load->helper('url');   
		 $topic = $_POST["topic"];
		 $topic_code = $topic['topic_code'];
		 $course_code = $topic['course_code'];
		 $db_topic = $this->ocf_model-> db_get_static_topic($topic_code, $course_code);
		 if(isset($db_topic[0]['content']))
		 {
			 $content = $db_topic[0]['content'];
			 $ul_index = stripos($content, '<li');
			 $last_ul_index = strripos($content, "</ul>");
			 
			 $data = substr($content, $ul_index, ($last_ul_index-$ul_index));
			 echo $data;
		 }
	 }
	 
	 /*********AJAX call to reload activities under a topic code ****************/
	public function reload()
	{
		$this->load->library('flexrest/flexrest');
		
		$this->load->helper('url');   
		$post = $_POST["topic"];
		
		$uuid = $post['uuid'];
		//echo $uuid;
		$version = $post['version'];
		//echo $version;
		$topic_code = $post['topic_code'];
		//echo $topic_code;
		$course_code = $post['course_code'];
		//echo $course_code;
	
		$itemsuccess = $this->flexrest->getItem($uuid, $version, $response);
		
		if($itemsuccess)
		{
			$xmlwrapper_name = 'xmlwrapper_' . $uuid . '_' . $version;	
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$response['metadata']), $xmlwrapper_name);
			$topics = $this->taaXml2Array($this->$xmlwrapper_name);
	        
			if($topics['item_type']=='TAA')
			{
				//echo $topics['item_type'];
				$l=0;
				foreach($topics['linked_activities'] as $linked) 
				{
					$l++;
					$linkedUUID = $linked['uuid']; //get each linked_activity UUID
	                $itemresponse = '';
					$key = array();
					$data = array();
					$returnData = array();
					//iterate through all attachments under each responsed TAA
					for($a=0; $a<count($response['attachments']); $a++)
					{
						$attachmentUuid = $response['attachments'][$a]['uuid'];
						//echo $response['attachments'][$a]['itemUuid'];
						//echo $response['attachments'][$a]['itemVersion'];
						$do_condition = '';
						if ( $attachmentUuid === $linkedUUID ) 
						{
							
							//getActivityRecursiveCall($attatchmentUuid, $uuid, $version, $topicCode, $do_condition, $itemresponse, $index, &$keys, &$data, $furtherCall)
							//$returnData[$a] = $this->getActivityRecursiveCall($attachmentUuid,$response['attachments'][$a]['itemUuid'],$response['attachments'][$a]['itemVersion'], $topic_code,'', '',1,$key=array(),$vdata=array(),true);
							$returnData = $this->getActivityRecursiveCall($attachmentUuid,$response['attachments'][$a]['itemUuid'],$response['attachments'][$a]['itemVersion'],$topic_code, $do_condition, '',1,$key,$data,true);
														
							$topics['linked_activities'][$l] = $returnData;
						}
					}
				}
				
				$topics['item_uuid'] = $uuid;
				$topics['item_version'] = $version;
			    $html = $this->generateHtml($topics, $course_code);
				
				$db_return = $this->ocf_model->db_transaction_reload_static_map_by_topic_code($html, $course_code, $topic_code);
				if($db_return == 'Successful')
				{
					$ul_index = stripos($html, '<li');
					$last_ul_index = strripos($html, "</ul>");
					$data = substr($html, $ul_index, ($last_ul_index-$ul_index));
					
					echo $data;
				}
				else
				{
					echo 'Please click on the Reload icon again.<br/>';
					
				}
			}	
		}
	}
	
	/***************************************
		recursive call of Linked Activities 
	****************************************/
	private function getActivityRecursiveCall($attatchmentUuid, $uuid, $version, $topicCode, $do_condition, $itemresponse, $index, &$keys, &$data, $furtherCall)
	{

		$this->load->library('flexrest/flexrest');
		$itemsuccess = $this->flexrest->getItem($uuid, $version,$itemresponse);
		
		if($itemsuccess)
		{
			$xmlwrapper_name = 'xmlwrapper_' . $uuid;
			
			$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$itemresponse['metadata']), $xmlwrapper_name);
			
			$tmp = array();
			$tmp['uuid']=$attatchmentUuid;
			$tmp['itemUuid']=$uuid;
			$tmp['itemVersion']=$version;
			$tmp['activityType'] = $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/activities/activity/@type');
			$tmp['activityName']= $this->$xmlwrapper_name->nodeValue('/xml/item/itembody/name');
			$tmp['topicCode']=$topicCode;
			$tmp['activityLevel']=$index;
			if($do_condition== '')
			{
				$do_condition = 'required';
			}
			$tmp['do_condition'] = $do_condition;
			
			if($tmp['activityType'] == 'group')
			{
				//echo 'activityType:'. $tmp['activityType'];
				$tmp['numLinkedActivities'] = $this->$xmlwrapper_name->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');  
				$tmp['group_how_many'] =  $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/activities/activity/@group_how_many');  
				
				 	
				for ($i = 1; $i <= $this->$xmlwrapper_name->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');  $i++) 
				{
					$linked_uuid = '/xml/item/curriculum/activities/linked_activities/uuid['.$i.']';
					$tmp['linked_activities'][$i]['uuid'] = $this->$xmlwrapper_name->nodeValue($linked_uuid);
				}	
				
					$this->setValue($data,$keys,$tmp);
					
				$attachments = $itemresponse['attachments'];
				

				if(isset($tmp['linked_activities'] ) && count($tmp['linked_activities'])>0)
				{
					array_push($keys,'linked_activities');	
					array_push($keys,$index);
					$act_index = 0;
					$condition = '';
					foreach($tmp['linked_activities'] as $linked_uuid_object)
					{	
						for ($j = 1; $j <= $this->$xmlwrapper_name->numNodes('/xml/item/curriculum/activities/act_items/act_item');  $j++) 
						{
							$act_uuid = $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/activities/act_items/act_item['.$j.']/@sys_id');
							if($act_uuid == $linked_uuid_object['uuid'])
							{
								$condition = $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/activities/act_items/act_item['.$j.']/do_condition');
								//$tmp['linked_activities'][$i]['do_condition'] = $this->$xmlwrapper_name->nodeValue('/xml/item/curriculum/activities/act_items/act_item['.$j.']/do_condition');
								continue;
							}
						}
						$act_index ++;
						foreach($attachments as $attachment)
						{
							if($attachment['type'] == 'linked-resource')
							{
								if($linked_uuid_object['uuid'] == $attachment['uuid'])
								{
									//$array_index++;
									$linked_attachment_item_uuid = $attachment['itemUuid'];
									$linked_attachment_item_version = $attachment['itemVersion'];
									
									//$keys[count($keys)-1] = $array_index;
									$keys[count($keys)-1] = $act_index;
									if($act_index >= count($tmp['linked_activities']))
									{
										$this->getActivityRecursiveCall($attachment['uuid'],$linked_attachment_item_uuid,$linked_attachment_item_version,$topicCode,$condition,'', $act_index, $keys, $data, false);
									}
									else
									{
										$this->getActivityRecursiveCall($attachment['uuid'],$linked_attachment_item_uuid,$linked_attachment_item_version,$topicCode,$condition,'', $act_index, $keys, $data, true);
									}
								}
							}
						}
					}
				} 
				else
				{
					//$tmp['uuid']=$attatchmentUuid;
					$tmp['numLinkedActivities'] = 0; 
					//$tmp['itemVersion']=$version; 
					$this->setValue($data,$keys,$tmp); 
				}
			}
			
			if($tmp['activityType'] == 'activity')
			{
				//$do_condition = 'required';
				$tmp['do_condition'] = $do_condition;
				$tmp['numLinkedActivities'] = 0;  
				//$tmp['itemVersion']=$version;
				$this->setValue($data,$keys,$tmp);  
			}
			if(!$furtherCall)
			{	
				array_pop($keys);
				array_pop($keys);
			}
			unset($tmp);
		}
		else
		{
			 //echo 'item not found';
			log_message('error', 'cmap getActivitiesRecursiveCall() - activity item not found: '.$uuid.'/'. $version. '/'.$itemresponse);
			return;
		}
		/*echo "<pre>";                                 
		print_r($data);
		echo "<pre>";	
		exit;*/
		return $data;
	} //END OF getActivityRecursiveCall()
	
	
	
	 
	private function generateHtml($topic, $courseCode)
	{
		if(isset($topic))
		{	
			$html = '<span class="topic_span"> <i class="fa fa-plus-circle activity"></i> ' . $topic["code"] . '-' . $topic["title"] . '</span>&nbsp;&nbsp;<i style="cursor: pointer;" class="refresh_icon glyphicon glyphicon-repeat" id="rf_'.$topic["item_uuid"].'_'.$topic["item_version"].'_'.$topic["code"].'_'.$courseCode.'" title="Refresh if you make changes via this page"></i>&nbsp;&nbsp;<i style="cursor: pointer;" class="reload_icon glyphicon glyphicon-refresh text-primary" id="rl_'.$topic["item_uuid"].'_'.$topic["item_version"].'_'.$topic["code"].'_'.$courseCode.'" title="Update cache & refresh display"></i>';
			
			if(isset($topic['numLinkedActivities']) && isset($topic['linked_activities'])) 
			{
				if($topic['numLinkedActivities'] > 0)
				{
					$html .= '<ul id="ul_'.$topic["item_uuid"].'_'.$topic["item_version"].'_'.$topic["code"].'_'.$courseCode.'">';
					foreach($topic['linked_activities'] as $act)
					{
						if(isset($act['linked_activities']))
						{
							$html .= $this->generateActivities($act['itemUuid'], $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'],$act['linked_activities'], $act['group_how_many'], '', 0);
						}
						else
						{
							if(isset($act['do_condition']))
							{
								$html .= $this->generateActivities($act['itemUuid'], $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'],$linked_activities = array(), 0, $act['do_condition'], 0);
							}
							else
							{
								$html .= $this->generateActivities($act['itemUuid'], $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'],$linked_activities = array(), 0,'', 0);
							}
						}
						//$topic['linked_activities'][$act_index]['topic_code'] = $topic['code'];
						//$topic['linked_activities'][$act_index]['course_code'] = $course['course_code'];
					}
					$html .= "</ul>";
					
				}
				/*else
				{
					$html .= '<span><i class="fa fa-minus-circle activity"></i> ' . $topic['code'] . '-' . $topic["title"] . '</span>';
				}*/
			}
			return $html;
		}
	}
	
	private function generateActivities($parent_uuid, $activityType, $itemUuid, $itemVersion, $activityName, $topicCode, $numLinkedActivities,$linked_activities,$group_how_many, $do_condition, $index)
	{
		$index ++;
		$str = '';
		if($index > 1)
		{
			$str .= '<ul>';
		}
		 if ($activityType == 'activity') { 
			switch($do_condition)
			{
				case 'required':
					$str .= '<li class="child_li">&nbsp;&nbsp;<a href="/flex/ocf/activity/'.$itemUuid.'/'.$itemVersion.'/'.$parent_uuid.'/'.$index.'" data-toggle="modal" data-target="#myModal" title="View activity detail">'.$activityName.'</a></li>';
				break;
				case 'optional': 
					$str .= '<li class="child_li"><i style="line-height:1em; vertical-align:middle" class="fa fa-circle-o fa-fw text-primary" title="optional activity"></i>&nbsp;&nbsp;<a href="/flex/ocf/activity/'.$itemUuid .'/'.$itemVersion.'/'.$parent_uuid .'/'.$index.'" data-toggle="modal" data-target="#myModal" title="View activity detail">'. $activityName.'</a></li>';
			   break; 
			   case 'alternative': 
					$str .= '<li class="child_li">&nbsp;&nbsp;<a href="/flex/ocf/activity/'. $itemUuid.'/'.$itemVersion.'/'.$parent_uuid.'/'.$index.'" data-toggle="modal" data-target="#myModal" title="View activity detail">'.$activityName.'</a> </li>';
			  break; 
			}
		
			/*if($index > 1)
			{
				$str .= '</li>';
			} */
		}
		 elseif($activityType == 'group')
		 {
			if($numLinkedActivities > 0 && isset($linked_activities) && count($linked_activities)>0)
			{
				switch($do_condition)
				{
					case 'required':
						if($group_how_many == 0)
						{
							$str .= '<li class="parent_li"><span><i class="fa fa-plus-circle"></i> '. $activityName .'&nbsp;&nbsp;</span> &nbsp;&nbsp;<a href="/flex/ocf/lta/'.$itemUuid.'/'.$itemVersion.'/'.$topicCode.'/'.$index.'" data-toggle="modal" data-target="#myModal"><i>detail</i></a>';
							
						}
						if($group_how_many >= 1)
						{
							$str .= '<li class="parent_li"><span><i class="fa fa-plus-circle"></i> '. $activityName.'&nbsp;&nbsp;<small class="badge">pick&nbsp;'.$group_how_many.'&nbsp;of&hellip;</small></span> &nbsp;&nbsp;<a href="/flex/ocf/lta/'.$itemUuid.'/'.$itemVersion.'/'.$topicCode.'/'.$index.'" data-toggle="modal" data-target="#myModal"><i>detail</i></a>';
						}
					break;
					case 'optional':
						if($group_how_many == 0)
						{
							$str .= '<li class="parent_li"><span><i class="fa fa-plus-circle"></i> '. $activityName.' &nbsp;&nbsp;<i style="line-height:1em; vertical-align:middle" class="fa fa-circle-o fa-fw text-primary" title="optional activity"></i></span> &nbsp;&nbsp;<a href="/flex/ocf/lta/'. $itemUuid.'/'. $itemVersion.'/'. $topicCode.'/'.$index.'" data-toggle="modal" data-target="#myModal"><i>detail</i></a>';
						}
						
						if($group_how_many >= 1)
						{
							$str .= '<li class="parent_li"><span><i class="fa fa-plus-circle"></i> '.$activityName.'&nbsp;&nbsp; <i style="line-height:1em; vertical-align:middle" class="fa fa-circle-o fa-fw text-primary" title="optional activity"></i> &nbsp;&nbsp;<small class="badge">pick&nbsp;'.$group_how_many.'&nbsp;of&hellip;</small></span>&nbsp;&nbsp;<a href="/flex/ocf/lta/'. $itemUuid.'/'. $itemVersion.'/'. $topicCode.'/'.$index.'" data-toggle="modal" data-target="#myModal"><i>detail</i></a>';
						}
						break;
					case 'alternative':
						if($group_how_many == 0)
						{
							$str .= '<li class="parent_li"><span><i class="fa fa-plus-circle"></i> '. $activityName.' &nbsp;&nbsp;<i style="line-height:1em; vertical-align:middle" ></i></span> &nbsp;&nbsp;<a href="/flex/ocf/lta/'. $itemUuid.'/'. $itemVersion.'/'. $topicCode.'/'.$index.'" data-toggle="modal" data-target="#myModal"><i>detail</i></a>';
						}
	
						
						if($group_how_many >= 1)
						{
							$str .= '<li class="parent_li"><span><i class="fa fa-plus-circle"></i> '.$activityName.'&nbsp;&nbsp;<small class="badge">pick&nbsp;'.$group_how_many.'&nbsp;of&hellip;</small></span> &nbsp;&nbsp;<a href="/flex/ocf/lta/'.$itemUuid.'/'.$itemVersion.'/'.$topicCode.'/'.$index.'" data-toggle="modal" data-target="#myModal"><i>detail</i></a>';
						
						}
						break;
					default:
						if($group_how_many == 0)
						{
							$str .= '<li class="parent_li"><span><i class="fa fa-plus-circle"></i> '. $activityName.'</span> &nbsp;&nbsp;<a href="/flex/ocf/lta/'. $itemUuid.'/'. $itemVersion.'/'. $topicCode.'/'.$index.'" data-toggle="modal" data-target="#myModal"><i>detail</i></a>';
						}
						
						if($group_how_many >= 1)
						{
							$str .= '<li class="parent_li"><span><i class="fa fa-plus-circle"></i> '. $activityName.'&nbsp;&nbsp; <small class="badge">pick&nbsp;'.$group_how_many.'&nbsp;of&hellip;</small></span> &nbsp;&nbsp;<a href="/flex/ocf/lta/'. $itemUuid.'/'. $itemVersion.'/'. $topicCode.'/'.$index.'" data-toggle="modal" data-target="#myModal"><i>detail</i></a>';
						}
					break;
				}
			
				foreach($linked_activities as $act)
				{ 
					   if(isset($act['linked_activities']))
					   { 
							if(isset($act['do_condition']))
							{
								$str .= $this->generateActivities($act['itemUuid'], $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'], $act['linked_activities'], $act['group_how_many'], $act['do_condition'], $index);
								
							}
							else
							{
								$str .= $this->generateActivities($act['itemUuid'], $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'], $act['linked_activities'], $act['group_how_many'], 'required', $index);
							}
							
					   }
					   else
					   { 
							if(isset($act['do_condition']))
							{
								$str .= $this->generateActivities($parent_uuid, $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'], $linked_activities=array(), 0, $act['do_condition'], $index);
							}
							else
							{
								$str .= $this->generateActivities($parent_uuid, $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'], $linked_activities=array(), 0, 'required', $index);
							}
					   }
				   }
		    }
			else
			{
				switch($do_condition)
				{
					case 'required':
						if($group_how_many == 0)
						{
							$str .= '<li class="parent_li"><span  style="border: 1px dashed #999"> '. $activityName .'&nbsp;</span> &nbsp;&nbsp;<a href="/flex/ocf/lta/'.$itemUuid.'/'.$itemVersion.'/'.$topicCode.'/'.$index.'" data-toggle="modal" data-target="#myModal"><i>detail</i></a>';
							
						}
						if($group_how_many >= 1)
						{
							$str .= '<li class="parent_li"><span style="border: 1px dashed #999"> '. $activityName.'&nbsp;&nbsp;<small class="badge">pick&nbsp;'.$group_how_many.'&nbsp;of&hellip;</small></span> &nbsp;&nbsp;<a href="/flex/ocf/lta/'.$itemUuid.'/'.$itemVersion.'/'.$topicCode.'/'.$index.'" data-toggle="modal" data-target="#myModal"><i>detail</i></a>';
						}
					break;
					case 'optional':
						if($group_how_many == 0)
						{
							$str .= '<li class="parent_li"><span style="border: 1px dashed #999"> '. $activityName.' &nbsp;&nbsp;<i style="line-height:1em; vertical-align:middle" class="fa fa-circle-o fa-fw text-primary" title="optional activity"></i></span> &nbsp;&nbsp;<a href="/flex/ocf/lta/'. $itemUuid.'/'. $itemVersion.'/'. $topicCode.'/'.$index.'" data-toggle="modal" data-target="#myModal"><i>detail</i></a>';
						}
						
						if($group_how_many >= 1)
						{
							$str .= '<li class="parent_li"><span style="border: 1px dashed #999">'.$activityName.'&nbsp;&nbsp; <i style="line-height:1em; vertical-align:middle" class="fa fa-circle-o fa-fw text-primary" title="optional activity"></i> &nbsp;<small class="badge">pick&nbsp;'.$group_how_many.'&nbsp;of&hellip;</small></span>&nbsp;&nbsp;<a href="/flex/ocf/lta/'. $itemUuid.'/'. $itemVersion.'/'. $topicCode.'/'.$index.'" data-toggle="modal" data-target="#myModal"><i>detail</i></a>';
						}
						break;
					case 'alternative':
						if($group_how_many == 0)
						{
							$str .= '<li class="parent_li"><span style="border: 1px dashed #999"> '. $activityName. '&nbsp;<i style="line-height:1em; vertical-align:middle" ></i></span> &nbsp;&nbsp;<a href="/flex/ocf/lta/'. $itemUuid.'/'. $itemVersion.'/'. $topicCode.'/'.$index.'" data-toggle="modal" data-target="#myModal"><i>detail</i></a>';
						}
	
						
						if($group_how_many >= 1)
						{
							$str .= '<li class="parent_li"><span style="border: 1px dashed #999"> '.$activityName.'&nbsp;&nbsp;<small class="badge">pick&nbsp;'.$group_how_many.'&nbsp;of&hellip;</small></span> &nbsp;&nbsp;<a href="/flex/ocf/lta/'.$itemUuid.'/'.$itemVersion.'/'.$topicCode.'/'.$index.'" data-toggle="modal" data-target="#myModal"><i>detail</i></a>';
						
						}
						break;
					default:
						if($group_how_many == 0)
						{
							$str .= '<li class="parent_li"><span style="border: 1px dashed #999"> '. $activityName.'</span> &nbsp;&nbsp;<a href="/flex/ocf/lta/'. $itemUuid.'/'. $itemVersion.'/'. $topicCode.'/'.$index.'" data-toggle="modal" data-target="#myModal"><i>detail</i></a>';
						}
						
						if($group_how_many >= 1)
						{
							$str .= '<li class="parent_li"><span style="border: 1px dashed #999"> '. $activityName.'&nbsp;&nbsp; <small class="badge">pick&nbsp;'.$group_how_many.'&nbsp;of&hellip;</small></span> &nbsp;&nbsp;<a href="/flex/ocf/lta/'. $itemUuid.'/'. $itemVersion.'/'. $topicCode.'/'.$index.'" data-toggle="modal" data-target="#myModal"><i>detail</i></a>';
						}
					break;
				}
			}
		}
		if($index > 1)
		{
			$str .= '</ul>';
			
		}
		return $str;
	}


	private function taaXml2Array($itemXml) 
    {
       $tmp = array();
	   $itemType = '/xml/item/curriculum/@item_type';
	   $tmp['item_type'] = $itemXml->nodeValue($itemType);
	   if($tmp['item_type'] == 'TAA')
	   {
		   $topicTitle = '/xml/item/curriculum/topics/topic/name';
		   $topicCode = '/xml/item/curriculum/topics/topic/code';
		   //$activityType = '/xml/item/curriculum/activities/activity/@type';
			   
		   $tmp['title'] = $itemXml->nodeValue($topicTitle);
		   $tmp['code'] = $itemXml->nodeValue($topicCode);
		  // $tmp['activityType'] = $itemXml->nodeValue($activityType);
		   
		   $tmp['numLinkedActivities'] = $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid'); 
		   
		   // Put the linked activity uuids into an array
		   for ($i = 1; $i <= $itemXml->numNodes('/xml/item/curriculum/activities/linked_activities/uuid');  $i++) {
				
				$uuid = '/xml/item/curriculum/activities/linked_activities/uuid['.$i.']';
				$tmp['linked_activities'][$i]['uuid'] = $itemXml->nodeValue($uuid);
		   }
	   }
       return $tmp;
    }
	 
	 /**
     * Validate incoming parameters
     *
     * @param string $coursecode
     */
    private function validate_params($courseCode)
    {
        if(strcmp($courseCode, 'missed')==0 ||is_numeric($courseCode) )
		{
            return false;
		}
        return true;
    }
	
	private function setValue(&$data, $path, $value) 
	{
    	$temp = &$data;
    	foreach ( $path as $key ) {
        	$temp = &$temp[$key];
   		 }
    	$temp = $value;
    	return $value;
	}
	

	private function microtime_float()
	{
    	list($usec, $sec) = explode(" ", microtime());
   		return ((float)$usec + (float)$sec);
	}

	private function notification($course_code, $update_status, $updated_items_count, $deleted_items_count, $search_count, $errmsg, $execution_time)
	{
		$current_timestamp = date("Y-m-d H:i:sa"); 
		$this->load->library('email');
		$msg = '';
		for($i = 0; $i < count($errmsg); $i++)
		{
			$msg = $msg . '  ' . $errmsg[$i];
		}
		$this->email->from('DoNotReply@flinders.edu.au', 'DoNotReply@flinders.edu.au');
		$this->email->to('qi0043@flinders.edu.au'); 
		$this->email->subject('Static Map notification');
		if($deleted_items_count == '')
			$deleted_items_count = 0;
		if($search_count == '')
			$search_count = 0;	
		if($updated_items_count == '')
			$updated_items_count = 0;
	
		
		$mes = 'The '.$course_code.' static updated on ' .$current_timestamp.'. The update was ' . $update_status .'. There were '. $search_count. ' searched in the flex system,  '.$updated_items_count.' items upadted or created in the database and '.$deleted_items_count. ' items deleted from the database. '.'Count of Errors: ' . count($errmsg) .' Execution time: '.$execution_time.'Mins. Error List: ' .$msg . '';
		$this->email->message($mes);	
		$this->email->send();
		return;
	}
	
	public function getMdAssessMap($courseCode='missed')
	{
	    $this->load->helper('url');
	    $ci =& get_instance();
	    $ci->load->config('flex');
	    $sam_collection = $ci->config->item('sam_collection');
	    $institute_url = $ci->config->item('institute_url');
	    
	    if(strtoupper($courseCode) != 'MD')
		return;
	    
	    $this->load->library('flexrest/flexrest');
        
	    $success = $this->flexrest->processClientCredentialToken();
	    if(!$success)
	    {
		#$errdata['message'] = $this->flexrest->error;
		log_message('error', 'search SAM for assessments, error on flex rest access: ' . $this->flexrest->error);
		$this->error_info('Error occurred when accessing the SAM.');
		exit();
	    }

	    #echo $institute_url;exit();
	    $q = '';
	    $start = 0;
	    $length = 40;
	    #$collections = $sam_collection;
	    $order = 'name';
	    $reverse = false;
	    $info = 'all';
	    $showall = true;
	    $where = "/xml/item/curriculum/avails/avail/year = '2016' and /xml/item/curriculum/topics/topic/code like 'MMED%'";
            #$where = "/xml/item/curriculum/avails/avail/@avail_ref='$avail_ref'";where /xml/item/itembody/name like 'MMED%2016%'
            #$where .= "AND /xml/item/curriculum/info/course/code='MD'";
            $where = urlencode($where);
	    
	    $searchsuccess = $this->flexrest->search($response, $q, $sam_collection, $where, $start, $length, $order, $reverse, $info, $showall);
            if(!$searchsuccess)
            {
                #$errdata['message'] = $this->flexrest->error;
                log_message('error', 'search SAM for assessments, error on flex rest searching function: ' . $this->flexrest->error);
                $this->error_info('Error occurred when accessing the SAM.');
                exit();
            }
	    
	    #echo '<pre>'; print_r($response);echo '</pre>';exit();
	    
	    $sam_count = intval($response['length']);
	    $sam_array = array();
	    for($i=0; $i<$sam_count; $i++)
	    {
		$sam = $response['results'][$i];
		#unset($sam['attachments']);
		#$sam_array[$i] = $sam;
		$xmlwrapper_name = 'xmlwrapper'.$i;
                $this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$sam['metadata']), $xmlwrapper_name);
		$sam_array[$i]['name'] = $sam['name'];
		$sam_array[$i]['uuid'] = $sam['uuid'];
		$sam_array[$i]['version'] = $sam['version'];
		$sam_array[$i]['status'] = $sam['status'];
		$sam_array[$i]['description'] = $sam['description'];
		
		$itemXml = $this->$xmlwrapper_name;
		for ($j = 1; $j <= $itemXml->numNodes('/xml/item/curriculum/assessment/a_items/a_item'); $j++) 
		{
		    $aitem_name = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/name';
		    $aitem_proportion = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/proportion';
		    $aitem_format = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/format';
		    $aitem_deadline = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/deadline';
		    $aitem_penalties = '/xml/item/curriculum/assessment/a_items/a_item['.$j.']/penalties';
		    
		    $sam_array[$i]['aitems'][$j-1]['name'] = $itemXml->nodeValue($aitem_name);
		    $sam_array[$i]['aitems'][$j-1]['proportion'] = $itemXml->nodeValue($aitem_proportion);
		    $sam_array[$i]['aitems'][$j-1]['format'] = $itemXml->nodeValue($aitem_format);
		    $sam_array[$i]['aitems'][$j-1]['deadline'] = $itemXml->nodeValue($aitem_deadline);
		    $sam_array[$i]['aitems'][$j-1]['penalties'] = $itemXml->nodeValue($aitem_penalties);
		}
		
		#unset($sam_array[$i]['metadata']);



	    }
	    
	    #$course = $this->getStaticTopics($courseCode, (int)$course_year, $course, 1);
	    $course['course_code'] = $courseCode;
	    $data = array('sam_array' => $sam_array, 'course'=>$course);

	    $this->load->view('ocf/md_assess_view', $data);
	}
}