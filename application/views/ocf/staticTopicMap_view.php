<!DOCTYPE html>
<html lang="en">
<head>
<title>static page</title>
</head>
<body>
<div>
<?php 
if(isset($topic))
{	
	if(isset($topic['numLinkedActivities']) && isset($topic['linked_activities'])) 
    {
		if($topic['numLinkedActivities'] > 0)
		{
			echo "<span class='topic_span'><i class='fa fa-plus-circle activity'></i>" . $topic['code'] . "-" . $topic['title'] . "</span>";
			echo "<ul>";
			foreach($topic['linked_activities'] as $act)
			{
				if(isset($act['linked_activities']))
				{
					generateActivities($act['itemUuid'], $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'],$act['linked_activities'], $act['group_how_many'], '', 0);
				}
				else
				{
					if(isset($act['do_condition']))
					{
						generateActivities($act['itemUuid'], $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'],$linked_activities = array(), 0, $act['do_condition'], 0);
					}
					else
					{
						generateActivities($act['itemUuid'], $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'],$linked_activities = array(), 0,'', 0);
					}
				}
				//$topic['linked_activities'][$act_index]['topic_code'] = $topic['code'];
				//$topic['linked_activities'][$act_index]['course_code'] = $course['course_code'];
			}
			echo "</ul>";
			
		}
		else
		{
			echo "<span><i class='fa fa-minus-circle activity'></i>" . $topic['code'] . "-" . $topic['title'] . "</span>";
		}
	}
}
?>
</div>
</body>
</html>


<?php
function generateActivities($parent_uuid, $activityType, $itemUuid, $itemVersion, $activityName, $topicCode, $numLinkedActivities,$linked_activities,$group_how_many, $do_condition, $index)
{
	$index ++;
	if($index > 1)
	{
		echo '<ul>';
	}
	 if ($activityType == 'activity') { 
     	switch($do_condition)
		{
			case "required":
				echo "<li class='child_li'> &nbsp;&nbsp;<a href='/flex/ocf/activity/".$itemUuid."/".$itemVersion."/".$parent_uuid."' data-toggle='modal' data-target='#myModal' title='View activity detail'>".$activityName."</a></li>";
			break;
			case "optional": 
				echo "<li class='child_li'><i style='line-height:1em; vertical-align:middle' class='fa fa-dot-circle-o  fa-fw' title='optional activity'></i>&nbsp;&nbsp; <a href='/flex/ocf/activity/".$itemUuid ."/".$itemVersion."/".$parent_uuid ."' data-toggle='modal' data-target='#myModal' title='View activity detail'>". $activityName."</a></li>";
		   break; 
		   case "alternative": 
		   		echo "<li class='child_li'><i style='line-height:1em; vertical-align:middle' class='fa fa-share-alt fa-fw' title='alternative activity'></i>&nbsp;&nbsp;<a href='/flex/ocf/activity/". $itemUuid."/".$itemVersion."/".$parent_uuid."/' data-toggle='modal' data-target='#myModal' title='View activity detail'>".$activityName."</a> </li>";
		  break; 
		}
	
	 	if($index > 1)
		{
			echo '</li>';
		} 
	}
	 elseif($activityType == 'group')
	 {
		switch($do_condition)
		{
			case "required":
				if($group_how_many == 0)
				{
					echo "<li class='parent_li'><span><i class='fa fa-plus-circle'></i>". $activityName ."&nbsp;&nbsp;<i style='line-height:1em; vertical-align:middle' class='fa fa-exclamation-triangle fa-fw text-danger' title='required activity'></i></span> &nbsp;&nbsp;<a href='/flex/ocf/lta/".$itemUuid."/".$itemVersion."/".$topicCode."' data-toggle='modal' data-target='#myModal'><i>detail</i></a></li>";
				}
				if($group_how_many == 1)
				{
					echo "<li class='parent_li'><span><i class='fa fa-plus-circle'></i>". $activityName."&nbsp;&nbsp; <i style='line-height:1em; vertical-align:middle' class='fa fa-exclamation-triangle fa-fw text-danger' title='required activity'></i> &nbsp;&nbsp;<i class='fa fa-list' title='This activity group has a choice of activities.'></i><i class='fa fa-question' title='This activity group has a choice of activities'></i></span> &nbsp;&nbsp;<a href='/flex/ocf/lta/".$itemUuid."/".$itemVersion."/".$topicCode."' data-toggle='modal' data-target='#myModal'><i>detail</i></a></li>";
				}
			break;
			case "optional":
				if($group_how_many == 0)
				{
					echo "<li class='parent_li'><span><i class='fa fa-plus-circle'></i> ". $activityName." &nbsp;&nbsp;<i style='line-height:1em; vertical-align:middle' class='fa fa-dot-circle-o fa-fw' title='optional activity'></i></span> &nbsp;&nbsp;<a href='/flex/ocf/lta/". $itemUuid."/". $itemVersion."/". $topicCode."' data-toggle='modal' data-target='#myModal'><i>detail</i></a></li>";
				}
				
				if($group_how_many == 1)
				{
					echo "<li class='parent_li'><span><i class='fa fa-plus-circle'></i> ".$activityName."&nbsp;&nbsp; <i style='line-height:1em; vertical-align:middle' class='fa fa-dot-circle-o  fa-fw' title='optional activity'></i> &nbsp;&nbsp;<i class='fa fa-list' title='This activity group has a choice of activities.'></i><i class='fa fa-question' title='This activity group has a choice of activities'></i></span> &nbsp;&nbsp;<a href='/flex/ocf/lta/". $itemUuid."/". $itemVersion."/". $topicCode."' data-toggle='modal' data-target='#myModal'><i>detail</i></a></li>";
				}
				break;
			case "alternative":
				if($group_how_many == 0)
				{
					echo "<li class='parent_li'><span><i class='fa fa-plus-circle'></i> ". $activityName." &nbsp;&nbsp;<i style='line-height:1em; vertical-align:middle' class='fa fa-share-alt fa-fw' title='optional activity'></i></span> &nbsp;&nbsp;<a href='/flex/ocf/lta/". $itemUuid."/". $itemVersion."/". $topicCode."' data-toggle='modal' data-target='#myModal'><i>detail</i></a></li>";
				}
				
				if($group_how_many == 1)
				{
					echo "<li class='parent_li'><span><i class='fa fa-plus-circle'></i> ".$activityName."&nbsp;&nbsp; <i style='line-height:1em; vertical-align:middle' class='fa fa-share-alt fa-fw' title='optional activity'></i> &nbsp;&nbsp;<i class='fa fa-list' title='This activity group has a choice of activities.'></i><i class='fa fa-question' title='This activity group has a choice of activities'></i></span> &nbsp;&nbsp;<a href='/flex/ocf/lta/".$itemUuid."/".$itemVersion."/".$topicCode."' data-toggle='modal' data-target='#myModal'><i>detail</i></a></li>";
				
				}
				break;
			case "":
				if($group_how_many == 0)
				{
					echo "<li class='parent_li'><span><i class='fa fa-plus-circle'></i> ". $activityName."</span> &nbsp;&nbsp;<a href='/flex/ocf/lta/". $itemUuid."/". $itemVersion."/". $topicCode."' data-toggle='modal' data-target='#myModal'><i>detail</i></a></li>";
				}
				
				if($group_how_many == 1)
				{
					echo "<li class='parent_li'><span><i class='fa fa-plus-circle'></i> ". $activityName."&nbsp;&nbsp; <i class='fa fa-list' title='This activity group has a choice of activities.'></i><i class='fa fa-question' title='This activity group has a choice of activities'></i></span> &nbsp;&nbsp;<a href='/flex/ocf/lta/". $itemUuid."/". $itemVersion."/". $topicCode."' data-toggle='modal' data-target='#myModal'><i>detail</i></a></li>";
				}
			break;
		}
		
	   if($numLinkedActivities > 0 && isset($linked_activities) && count($linked_activities)>0)
	   {
		   foreach($linked_activities as $act)
		   { 
			   if(isset($act['linked_activities']))
			   { 
			    	if(isset($act['do_condition']))
					{
						generateActivities($act['itemUuid'], $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'], $act['linked_activities'], $act['group_how_many'], $act['do_condition'], $index);
			   			
					}
					else
					{
						generateActivities($act['itemUuid'], $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'], $act['linked_activities'], $act['group_how_many'], '', $index);
					}
					
			   }
			   else
			   { 
			   		if(isset($act['do_condition']))
					{
			    		generateActivities($parent_uuid, $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'], $linked_activities=array(), 0, $act['do_condition'], $index);
					}
					else
					{
						generateActivities($parent_uuid, $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'], $linked_activities=array(), 0, '', $index);
					}
			   }
		   }
	   }
	  
	}
	if($index > 1)
	{
		echo '</ul>';
		
	}
}
?>