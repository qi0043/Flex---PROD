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
				$(this).attr('title', 'Expand this').find(' > i').addClass('fa-plus-circle').removeClass('fa-minus-circle');
			} 
			else if (children.is(":hidden")) {
				children.show('fast');
				$(this).attr('title', 'Collapse this').find(' >i').addClass('fa-minus-circle').removeClass('fa-plus-circle');
			}
			e.stopPropagation();
	});
}
});
</script>
<li>
						
<?php /*?><?php 
for($x=0; $x<=count($data); $x++)
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
		
		echo "<br/>";
	
		}
		?><?php */?>
</li>

<?php
foreach($data as $act)
{
	if(isset($act['linked_activities']))
	{
		generateActivities($act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'],$act['linked_activities'], 0);
	}
	else
	{
		generateActivities($act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'],$linked_activities = array(), 0);
	}
}

function generateActivities($activityType, $itemUuid, $itemVersion, $activityName, $topicCode, $numLinkedActivities,$linked_activities, $index)
{
	$index ++;
	if($index > 1)
	{
		echo '<ul>';
	}
	 if ($activityType == 'activity') { ?>
	 	<li class="child_li"><a href="/flex/som/activity/<?php echo $itemUuid ?>/<?php echo $itemVersion; ?>/<?php echo $itemUuid; ?>" target="_blank" title="View activity detail"><?php echo $activityName; ?></a></li>
	 <?php
	 	if($index > 1)
		{
			echo '</li>';
		} 
	}
	 elseif($activityType == 'integrated')
	{?>
	  <li class="parent_li"><span><i class="fa fa-plus-circle"></i> <?php echo $activityName; ?></span> &nbsp;&nbsp;<a href="/flex/som/lta/<?php echo $itemUuid; ?>/<?php echo $itemVersion; ?>/<?php echo $topicCode; ?>" target="_blank"><i>detail</i></a>
    <?php 
	   if($numLinkedActivities > 0 && isset($linked_activities) && count($linked_activities)>0)
	   {
		   foreach($linked_activities as $act)
		   {
			   if(isset($act['linked_activities']))
			   		generateActivities($act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'], $act['linked_activities'], $index);
			   else
			    	generateActivities($act['activityType'], $act['itemUuid'], $act['itemVersion'], $act['activityName'], $act['topicCode'], $act['numLinkedActivities'], $linked_activities=array(),$index);
		   }
	   }
	  
	}
	if($index > 1)
	{
		echo '</ul>';
		
	}
}
?>