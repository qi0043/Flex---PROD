
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-files-o fa-fw"></i> Activity Group :: <?php echo $item['itemTitle']; ?></h4>
      </div>
      <div class="modal-body">
      
      
<a href="https://flex.flinders.edu.au/items/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>" target="_blank" class="btn btn-sm btn-danger pull-right"><i class="fa fa-edit"></i> Edit this item</a>

<div class="row" style="margin-bottom:0.5em;">
  <div class="col-md-12">
<h4>Description</h4>
<p><?php echo $item['itemDescription']; ?></p>
</div>
</div>



<div class="row">
<div class="col-md-12">
<h4> Learning & Teaching Activities</h4>
<ul class="fa-ul">
<?php foreach ($item['activities'] as $activity) { ?>
<?php 
/*    */
switch ($activity['activityType']) {
	
	case 'group':
	
		$liclass = "fa-li fa fa-files-o";
		
		
		// $link = "/flex/som/lta2/". $activity['itemUuid'] . "/" . $activity['itemVersion'] . "/" . $item['itemTopic'] . "/" . $activity['activityParent'] . "/" . $activity['activityParentVersion']. "/" . $item['depth'];	
		
		
			$link = "/flex/som/lta2/". $activity['itemUuid'] . "/" . $activity['itemVersion'] . "/" . $item['itemTopic'];	
		 
		break;
	
	case 'activity':
	
		$liclass = "fa-li fa fa-file-o";
		$link = "/flex/som/activity/". $activity['itemUuid'] . "/" . $activity['itemVersion'] . "/" . $item['itemTopic'] . "/" . $activity['activityParent'] . "/" . $activity['activityParentVersion'] . "/" . $item['depth'] . "/" . $item['parentItem'];	
		break;
	
	
}


switch ($activity['docondition']) {
	
	case 'alternative':
		$docondition = '<i class="fa fa-share-alt fa-fw"></i>';
		break;
	case 'optional':
		$docondition = '<i class="fa fa-dot-circle-o fa-fw"></i>';
		break;
	default:
		$docondition = '';
		break;
	
}

?>

<!-- <li><a href="/flex/som/<?php echo $linktype; ?>/<?php echo $activity['itemUUID']; ?>/<?php echo $activity['itemVersion']; ?>/<?php echo $item['thisUuid']; ?>" class="standard" ><?php echo $activity['itemTitle']; ?></a></li>

<li><i class="<?php echo $liclass; ?>"></i><a href="<?php echo $link; ?>" class="standard" data-toggle="modal" data-target="#myModal"><?php echo $activity['title']; ?></a> <?php echo $docondition; ?></li>
-->

<li><i class="<?php echo $liclass; ?>"></i><?php echo $activity['title']; ?> <?php echo $docondition; ?></li>
<?php } ?>
</ul>
</div>
<div class="col-md-12">

<h4> Learning Outcomes</h4>
<dl class="dl-horizontal">
<?php foreach ($item['los'] as $lo) { ?>
<dt><?php echo $lo['code']; ?></dt>
<dd><?php echo $lo['name']; ?></dd>
<?php } ?>
</dl>


</div>
<div class="col-md-12">

<div class="panel panel-primary">
    <div class="panel-heading">
      <h5 class="panel-title">Resources</h5>
    </div>
    <div class="panel-body" style="font-size:14px;">
      <ul class="fa-ul">
      <?php foreach ($attachments as $a) { ?>
      
      <?php
	  
	  switch ($a['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
      
      
      <li><?php echo $resourceclass; ?><a href="http://flex.flinders.edu.au/items/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $a['filename']; ?>" target="_blank"><?php echo $a['title']; ?></a></li>
      <?php } ?>
      </ul>
    </div>

</div>
      </div>
      
</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>



