<?php if(!(empty($item['los']))) { ?>
<!-- new row for aligned LOs -->
<div class="row">
<div class="col-md-12">
<div class="block block_course_overview" style="margin:2px 2px 30px 2px;">

<h5> Learning  Objectives & Alignment<button id="loControl" class="btn btn-mini btn-default doNotPrint" style="margin-left:3em;" data-toggle="collapse" data-target="#collpaseLO" aria-expanded="false" aria-controls="collpaseLO">Show/Hide</button><button id="printControl" class="btn btn-mini btn-default doNotPrint" style="margin-left:1em;" ><i class="fa fa-print"></i>&nbsp;Print</button></h5>

<div class="collapse" id="collpaseLO">
<div class="table-responsive">
<table class="table table-condensed table-bordered small">
<tr>
<th><?php if((empty($item['los']))) { ?><span class="text-danger">Learning Objectives not defined for this group of activities</span><?php } ?>&nbsp;</th>
<?php $numLOS = 0; ?>
<?php if(!(empty($item['los']))) { ?>
<?php foreach($item['los'] as $lo) { ?>
<th style="text-align:center;"><?php echo $lo['code']; ?></th>
<?php $numLOS++; ?>
<?php } ?>
<?php } ?>
</tr>

<?php if (!(empty($item['activities']))) { ?>
<?php foreach ($item['activities'] as $activity) { ?>
<?php 
/*    */
switch ($activity['activityType']) {
	
	case 'group':
	
		$liclass = "fa fa-files-o";
		$linktype = "group";
		
		
		// $link = "/flex/ocf/lta/". $activity['itemUuid'] . "/" . $activity['itemVersion'] . "/" . $item['itemTopic'] . "/" . $activity['activityParent'] . "/" . $activity['activityParentVersion']. "/" . $item['depth'];	
		
		
			//$link = "/flex/ocf/ltats/". $activity['itemUuid'] . "/" . $activity['itemVersion'] . "/" . $item['itemTopic'];	
		 
		break;
	
	case 'activity':
	
		$liclass = "fa fa-file-o";
		
		$linktype = "activity";
		//$link = "/flex/ocf/activity/" . $$activity['itemUuid'] . "/" . $itemVersion . "/" . $parent_uuid;
		
		//$link .= 'data-target="#myModal" title="View activity detail';
		
		//$link = "/flex/som/activity/". $activity['itemUuid'] . "/" . $activity['itemVersion'] . "/" . $item['itemTopic'] . "/" . $activity['activityParent'] . "/" . $activity['activityParentVersion'] . "/" . $item['depth'] . "/" . $item['parentItem'];	
		break;
	
	
}


switch ($activity['docondition']) {
	
	case 'alternative':
		$docondition = '<i class="fa fa-share-alt fa-fw" style="margin-right:0.8em;"></i>';
		break;
	case 'optional':
		$docondition = '<i class="fa fa-dot-circle-o fa-fw"  style="margin-right:0.8em;"></i>';
		break;
	default:
		$docondition = '';
		break;
	
}

?>
<tr>
<td><!--<i class="<?php echo $liclass; ?>" style="margin-right:0.8em;"></i>-->
<?php if ($linktype == "activity" ) { ?>
<?php echo $docondition; ?><?php echo $activity['title']; ?>
<?php } ?>

<?php if ($linktype == "group" ) { ?>
<?php echo $docondition; ?><?php echo $activity['title']; ?>
<?php } ?>

 </td>
<?php if(!(empty($activity['los']))) { ?>
<?php foreach($activity['los'] as $lo ) { ?>
<td style="text-align:center;">
<?php if ($lo['aligned'] == 1) { ?>
<i class="fa fa-check text-success"></i>
<?php }  ?></td>

<?php } ?>
<?php } ?>
</tr>
<?php } ?>
<?php }  // $item['activities'] not empty ?> 
</table>

</div>

<div>
<dl class="dl-horizontal">
<?php 
/*   */


foreach ($item['los'] as $lo) { ?>
<dt style="width:40px;"><?php echo $lo['code']; ?></dt>
<dd style="margin-left:60px;"><?php echo $lo['name']; ?></dd>
<?php }   ?>
</dl>


</div>
</div>


</div>
</div>

</div> <!-- ./ row-fluid -->
<?php } ?>