<script type="text/javascript">

$(document).ready(function(){
//hide the child li elements

var browserName=navigator.appName; 

if (browserName!="Microsoft Internet Explorer")  
{
	$('.topic_li li.parent_li > ul > li').hide();
	$('.topic_li li.parent_li:has(ul)').find(' > span').attr('title', 'Expand this');
	$('.topic_li li.parent_li > span').on('click',function(){
			var children = $(this).parent('li.parent_li').find(' > ul > li');
			if (children.is(":visible")) {
				children.hide('fast');
				$(this).attr('title', 'Expand this').find(' > i:first').addClass('fa-plus-circle').removeClass('fa-minus-circle');
			} 
			else if (children.is(":hidden")) {
				children.show('fast');
				$(this).attr('title', 'Collapse this').find(' >i:first').addClass('fa-minus-circle').removeClass('fa-plus-circle');
			}
			e.stopPropagation();
	});
}
});
</script>

<style type="text/css">
.tree small.badge
{
	background-color:#428bca !important;
}
.tree small.alert
{
	padding: 0 0!important;
}

.tree small span.badge
{
	background-color:transparent;
	border:hidden;
	color:#8a6d3b; 
}
</style>

<li>					
<?php /*?><?php 
echo 'activity page';
for($x=1; $x<=count($data); $x++)
		{
		$act = $data[$x];
		echo "uuid:";
		print_r($act['uuid']);
		echo "<br/>";
		
		echo "itemUuid:";
		print_r($act['itemUuid']);
		echo "<br/>";
		
		echo "item version:";
		print_r($act['itemVersion']);
		echo "<br/>";
		
		echo "activityType:";
		print_r($act['activityType']);
		echo "<br/>";
		
		echo "activityName:";
		print_r($act['activityName']);
		echo "<br/>";
		
		echo "numLinkedActivities:";
		print_r($act['numLinkedActivities']);
		echo "<br/>";
		
		echo "group_how_many:";
		print_r($act['group_how_many']);
		echo "<br/>";
		
		
		echo "topic code:";
		print_r($act['topicCode']);
		echo "<br/>";
		
		if(isset($act['linked_activities']))
		{
			echo "linked_activities:";
			echo "<pre>";
			print_r($act['linked_activities']);
			echo "</pre>";
		}
		echo "course code:";
		print_r($courseCode);
		echo "<br/>";
		
		echo "<br/>";
	
		}
		?><?php */?>
</li>

<?php
foreach($data as $act)
{
	$n_lock = '';
	if(isset($act['nameLock']))
	{
		if($act['nameLock'] == 'Yes')
		$n_lock = '<small class="alert alert-warning">&nbsp;<strong>N</strong><span class="badge"><i class="fa fa-lock"></i></span></small>';
	}
	
	$o_lock = '';
	if(isset($act['overviewLock']))
	{
		if($act['overviewLock'] == 'Yes')
		$o_lock = '<small class="alert alert-success">&nbsp;<strong>O</strong><span class="badge"><i class="fa fa-lock"></i></span></small>';	
	}
	
	$a_lock = '';
	if(isset($act['activityLock']))
	{
		if($act['activityLock'] == 'Yes')
		$a_lock = '<small class="alert alert-info">&nbsp;<strong>A</strong><span class="badge"><i class="fa fa-lock"></i></span></small>';	
	}
	
	if(isset($act['linked_activities']))
	{
		generateActivities($act['itemUuid'], $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'],$act['linked_activities'], $act['group_how_many'], $n_lock, $o_lock, $a_lock, '', 0);
	}
	else
	{
		if(isset($act['do_condition']))
		{
			generateActivities($act['itemUuid'], $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'],$linked_activities = array(), 0, $n_lock, $o_lock, $a_lock, $act['do_condition'], 0);
		}
		else
		{
			generateActivities($act['itemUuid'], $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'],$linked_activities = array(), 0, $n_lock, $o_lock, $a_lock, '', 0);
		}
	}
}

function generateActivities($parent_uuid, $activityType, $itemUuid, $itemVersion, $activityName, $topicCode, $numLinkedActivities,$linked_activities,$group_how_many, $name_lock, $overview_lock, $activity_lock, $do_condition, $index)
{
	$index ++;
	if($index > 1)
	{
		echo '<ul>';
	}
	 if ($activityType == 'activity') { ?>
     	<?php switch($do_condition)
			{
				case "required":?>
                <li class="child_li">&nbsp;&nbsp;<a href="/flex/ocf/activity/<?php echo $itemUuid ?>/<?php echo $itemVersion; ?>/<?php echo $parent_uuid; ?>/<?php echo $index; ?>" data-toggle="modal" data-target="#myModal" title="View activity detail"><?php echo $activityName; ?></a>&nbsp;<?php echo $name_lock; ?> <?php echo $overview_lock; ?> <?php echo $activity_lock; ?></li>
		<?php		break;
				case "optional": ?>
                <li class="child_li"><i style="line-height:1em; vertical-align:middle" class="fa fa-circle-o  fa-fw" title="optional activity"></i>&nbsp;&nbsp; <a href="/flex/ocf/activity/<?php echo $itemUuid ?>/<?php echo $itemVersion; ?>/<?php echo $parent_uuid; ?>/<?php echo $index; ?>" data-toggle="modal" data-target="#myModal" title="View activity detail"><?php echo $activityName; ?></a>&nbsp;<?php echo $name_lock; ?> <?php echo $overview_lock; ?> <?php echo $activity_lock; ?></li>
		<?php       break; 
				case "alternative": ?>
                <li class="child_li"><i style="line-height:1em; vertical-align:middle" class="fa fa-share-alt fa-fw" title="alternative activity"></i>&nbsp;&nbsp;<a href="/flex/ocf/activity/<?php echo $itemUuid ?>/<?php echo $itemVersion; ?>/<?php echo $parent_uuid; ?>/<?php echo $index; ?>" data-toggle="modal" data-target="#myModal" title="View activity detail"><?php echo $activityName; ?></a>&nbsp;<?php echo $name_lock; ?> <?php echo $overview_lock; ?> <?php echo $activity_lock; ?></li>
        <?php       break; 
			}?>
	 <?php
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
				{?>
					<li class="parent_li"><span><i class="fa fa-plus-circle"></i> <?php echo $activityName; ?></span>&nbsp;&nbsp;<a href="/flex/ocf/lta/<?php echo $itemUuid; ?>/<?php echo $itemVersion; ?>/<?php echo $topicCode; ?>/<?php echo $index; ?>" data-toggle="modal" data-target="#myModal"><i>detail</i></a>&nbsp;<?php echo $name_lock; ?> <?php echo $overview_lock; ?> <?php echo $activity_lock; ?>
				<?php 
				}
				
				if($group_how_many >= 1)
				{?>
					<li class="parent_li"><span><i class="fa fa-plus-circle"></i> <?php echo $activityName; ?>&nbsp;&nbsp;<small class="badge">pick&nbsp; <?php echo $group_how_many ?>&nbsp;of&hellip;</small></span> &nbsp;&nbsp;<a href="/flex/ocf/lta/<?php echo $itemUuid; ?>/<?php echo $itemVersion; ?>/<?php echo $topicCode; ?>/<?php echo $index; ?>" data-toggle="modal" data-target="#myModal"><i>detail</i></a>&nbsp;<?php echo $name_lock; ?> <?php echo $overview_lock; ?> <?php echo $activity_lock; ?>
				<?php
				}
			break;
			case "optional":
				if($group_how_many == 0)
				{?>
					<li class="parent_li"><span><i class="fa fa-plus-circle"></i> <i style="line-height:1em; vertical-align:middle" class="fa fa-circle-o  fa-fw text-primary" title="optional activity"></i>&nbsp;&nbsp;<?php echo $activityName; ?> </span> &nbsp;&nbsp;<a href="/flex/ocf/lta/<?php echo $itemUuid; ?>/<?php echo $itemVersion; ?>/<?php echo $topicCode; ?>/<?php echo $index; ?>" data-toggle="modal" data-target="#myModal"><i>detail</i></a>&nbsp;<?php echo $name_lock; ?> <?php echo $overview_lock; ?> <?php echo $activity_lock; ?>
				<?php 
				}
				
				if($group_how_many >= 1)
				{?>
					<li class="parent_li">
                    	<span>
                        	<i class="fa fa-plus-circle"></i>
                            <i style="line-height:1em; vertical-align:middle" class="fa fa-circle-o  fa-fw text-primary" title="optional activity"></i>
                            &nbsp;&nbsp;<?php echo $activityName; ?> &nbsp;&nbsp;
                            <small class="badge"> pick&nbsp; <?php echo $group_how_many ?>&nbsp;of&hellip;</small>
                         </span> &nbsp;&nbsp;
                         <a href="/flex/ocf/lta/<?php echo $itemUuid; ?>/<?php echo $itemVersion; ?>/<?php echo $topicCode; ?>/<?php echo $index; ?>" data-toggle="modal" data-target="#myModal"><i>detail</i></a>&nbsp;<?php echo $name_lock; ?> <?php echo $overview_lock; ?> <?php echo $activity_lock; ?>
				<?php
				}
				break;
			case "alternative":
				if($group_how_many == 0)
				{?>
					<li class="parent_li"><span><i class="fa fa-plus-circle"></i> <?php echo $activityName; ?></span> &nbsp;&nbsp;<a href="/flex/ocf/lta/<?php echo $itemUuid; ?>/<?php echo $itemVersion; ?>/<?php echo $topicCode; ?>/<?php echo $index; ?>" data-toggle="modal" data-target="#myModal"><i>detail</i></a>&nbsp;<?php echo $name_lock; ?> <?php echo $overview_lock; ?> <?php echo $activity_lock; ?>
				<?php 
				}
				
				if($group_how_many >= 1)
				{?>
					<li class="parent_li"><span><i class="fa fa-plus-circle"></i> <?php echo $activityName; ?>&nbsp;&nbsp;<small class="badge">pick&nbsp; <?php echo $group_how_many ?>&nbsp;of&hellip;</small></span> &nbsp;&nbsp;<a href="/flex/ocf/lta/<?php echo $itemUuid; ?>/<?php echo $itemVersion; ?>/<?php echo $topicCode; ?>/<?php echo $index; ?>" data-toggle="modal" data-target="#myModal"><i>detail</i></a>&nbsp;<?php echo $name_lock; ?> <?php echo $overview_lock; ?> <?php echo $activity_lock; ?> 
				<?php
				}
				break;
			case "":
				if($group_how_many == 0)
				{?>
					<li class="parent_li"><span><i class="fa fa-plus-circle"></i> <?php echo $activityName; ?></span> &nbsp;&nbsp;<a href="/flex/ocf/lta/<?php echo $itemUuid; ?>/<?php echo $itemVersion; ?>/<?php echo $topicCode; ?>/<?php echo $index; ?>" data-toggle="modal" data-target="#myModal"><i>detail</i> </a>&nbsp;<?php echo $name_lock; ?> <?php echo $overview_lock; ?> <?php echo $activity_lock; ?>
				<?php 
				}
				
				if($group_how_many >= 1)
				{?>
					<li class="parent_li"><span><i class="fa fa-plus-circle"></i> <?php echo $activityName; ?>&nbsp;&nbsp;<small class="badge">pick&nbsp; <?php echo $group_how_many ?>&nbsp;of&hellip;</small></span> &nbsp;&nbsp;<a href="/flex/ocf/lta/<?php echo $itemUuid; ?>/<?php echo $itemVersion; ?>/<?php echo $topicCode; ?>/<?php echo $index; ?>" data-toggle="modal" data-target="#myModal"><i>detail</i></a>&nbsp;<?php echo $name_lock; ?> <?php echo $overview_lock; ?> <?php echo $activity_lock; ?> 
			<?php }
			break;
		}
		
	   if($numLinkedActivities > 0 && isset($linked_activities) && count($linked_activities)>0)
	   {
		   foreach($linked_activities as $act)
		   { 
				$n_lock = '';
				if(isset($act['nameLock']))
				{
					if($act['nameLock'] == 'Yes')
					$n_lock = '<small class="alert alert-warning">&nbsp;<strong>N</strong><span class="badge"><i class="fa fa-lock"></i></span></small>';
				}
				
				$o_lock = '';
				if(isset($act['overviewLock']))
				{
					if($act['overviewLock'] == 'Yes')
					$o_lock = '<small class="alert alert-success">&nbsp;<strong>O</strong><span class="badge"><i class="fa fa-lock"></i></span></small>';	
				}
				
				$a_lock = '';
				if(isset($act['activityLock']))
				{
					if($act['activityLock'] == 'Yes')
					$a_lock = '<small class="alert alert-info">&nbsp;<strong>A</strong><span class="badge"><i class="fa fa-lock"></i></span></small>';	
				}
				 
			   if(isset($act['linked_activities']))
			   {
			    	if(isset($act['do_condition']))
					{
						generateActivities($act['itemUuid'], $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'], $act['linked_activities'], $act['group_how_many'], $n_lock, $o_lock, $a_lock, $act['do_condition'], $index);
			   			
					}
					else
					{
						generateActivities($act['itemUuid'], $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'], $act['linked_activities'], $act['group_how_many'],$n_lock, $o_lock, $a_lock, '', $index);
					}
					
			   }
			   else
			   { 
			   		if(isset($act['do_condition']))
					{
			    		generateActivities($parent_uuid, $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'], $linked_activities=array(), 0, $n_lock, $o_lock, $a_lock, $act['do_condition'], $index);
					}
					else
					{
						generateActivities($parent_uuid, $act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'], $linked_activities=array(), 0, $n_lock, $o_lock, $a_lock, '', $index);
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