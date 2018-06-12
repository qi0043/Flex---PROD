<script type="text/javascript">
    
$().ready(function () {
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
    });
});
</script>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-files-o fa-fw"></i>  <?php echo $item['itemTitle']; ?></h4>
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
		
		
		// $link = "/flex/ocf/lta/". $activity['itemUuid'] . "/" . $activity['itemVersion'] . "/" . $item['itemTopic'] . "/" . $activity['activityParent'] . "/" . $activity['activityParentVersion']. "/" . $item['depth'];	
		
		
			$link = "/flex/ocf/lta/". $activity['itemUuid'] . "/" . $activity['itemVersion'] . "/" . $item['itemTopic'];	
		 
		break;
	
	case 'activity':
	
		$liclass = "fa fa-file-o";
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
<td><!--<i class="<?php echo $liclass; ?>" style="margin-right:0.8em;"></i>--><?php echo $docondition; ?><?php echo $activity['title']; ?> </td>
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



</div>


<?php if (!(empty($item['los']))) { ?>
<div class="col-md-12">

<h4> Learning Objectives</h4>
<dl class="dl-horizontal">
<?php 
/*   */


foreach ($item['los'] as $lo) { ?>
<dt><?php echo $lo['code']; ?></dt>
<dd><?php echo $lo['name']; ?></dd>
<?php }   ?>
</dl>


</div>

<?php } // end not empty LOs ?>

<!-- panel for resources -->

 <?php if (!(empty($item['overall'])) || !(empty($item['pre'])) || !(empty($item['during'])) || !(empty($item['post'])) ) { ?> 

<div class="col-md-12">
<div class="panel panel-primary">
    <div class="panel-heading">
      <h4 class="panel-title">
      Instructions &amp; Resources
      </h5>
    </div>
    
  <?php if (!(empty($item['overall']))) { ?>    
<div class="row"> <!--activity wide -->
 

   <div class="col-md-12">
  <div class="panel panel-default" style="margin-bottom:0;">
   <div class="panel-heading ">
   <h5 class="panel-title">Activity Information</h5>
   </div>
    <div class="panel-body" >
    
    <?php if (!(empty($item['overall']['instructions']))) { ?>
  <p><strong>Information</strong></p>
  <ul class="fa-ul">
  <?php
	  
	switch ($item['overall']['instructions']['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';	
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
      <li><?php echo $resourceclass; ?><a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $item['overall']['instructions']['filename']; ?>" target="_blank"><?php echo $item['overall']['instructions']['description']; ?></a></li>
      
    </ul>
    <?php } ?>
    
    
    <?php if (!(empty($item['overall']['linked']))) { ?>
   <p><strong>Resources</strong></p>
    <ul class="fa-ul">
    <?php foreach ($item['overall']['linked'] as $olinked) { ?>
      <?php
	  
	switch ($olinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';	
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>

    <li><?php echo $resourceclass; ?><a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $olinked['filename']; ?>" target="_blank"><?php echo $olinked['description']; ?></a></li>
    
    <?php } ?>
    </ul>
    <?php } ?>
 </div>
  </div>
   </div>

 
</div> <!-- / activity wide -->
  <?php } // overall not empty ?>
  
  
  
  
 <?php if (!(empty($item['pre']))) { ?>  
<div class="row"> <!-- pre-activity -->
 
  <div class="col-md-12">
  <div class="panel panel-default" style="margin-bottom:0;">
   <div class="panel-heading ">
   <h5 class="panel-title">Pre-Activity Information</h5>
   </div>
<div class="panel-body" >
 <?php if (!(empty($item['pre']['instructions']))) { ?>
  <p><strong>Information</strong></p>
  <ul class="fa-ul">
  <?php
	  
	switch ($item['pre']['instructions']['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';	
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
      <li><?php echo $resourceclass; ?><a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $item['pre']['instructions']['filename']; ?>" target="_blank"><?php echo $item['pre']['instructions']['description']; ?></a></li>
      
    </ul>
    <?php } ?>
    
    
    
     <?php if (!(empty($item['pre']['linked']))) { ?>
   <p><strong>Resources</strong></p>
    <ul class="fa-ul">
    <?php foreach ($item['pre']['linked'] as $prelinked) { ?>
      <?php
	  
	switch ($prelinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';	
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>

    <li><?php echo $resourceclass; ?><a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $prelinked['filename']; ?>" target="_blank"><?php echo $prelinked['description']; ?></a></li>
    
    <?php } ?>
    </ul>
    <?php } ?>
 </div>
  </div>
  </div>
 
</div> <!-- / pre-activity  -->
 <?php } // pre not empty ?>
 
 
 
 
 <?php if (!(empty($item['during']))) { ?> 
<div class="row"> <!-- during activity -->

  <div class="col-md-12">
  <div class="panel panel-default" style="margin-bottom:0;">
   <div class="panel-heading ">
   <h5 class="panel-title">During Activity Information</h5>
   </div>
   <div class="panel-body" >
    <?php if (!(empty($item['during']['instructions']))) { ?>
     <p><strong>Information</strong></p>
     <ul class="fa-ul">
       <?php
	  
	switch ($item['during']['instructions']['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';	
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
       <li><?php echo $resourceclass; ?><a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $item['during']['instructions']['filename']; ?>" target="_blank"><?php echo $item['during']['instructions']['description']; ?></a></li>
     </ul>
     <?php } ?>
     
      <?php if (!(empty($item['during']['linked']))) { ?>
     <p><strong>Resources</strong></p>
     <ul class="fa-ul">
       <?php foreach ($item['during']['linked'] as $dlinked) { ?>
       <?php
	  
	switch ($dlinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';	
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
       <li><?php echo $resourceclass; ?><a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $dlinked['filename']; ?>" target="_blank"><?php echo $dlinked['description']; ?></a></li>
       <?php } ?>
     </ul>
     <?php } ?>
   </div>
  </div>
  </div>
 
</div> <!-- / during activity  -->
 <?php } ?>
 
 
 
<?php if (!(empty($item['post']))) { ?> 
<div class="row"> <!-- post activity -->
  <div class="col-md-12">
  <div class="panel panel-default" style="margin-bottom:0;">
   <div class="panel-heading ">
   <h5 class="panel-title">Post Activity Information</h5>
   </div>
   <div class="panel-body" >
    <?php if (!(empty($item['post']['instructions']))) { ?>
     <p><strong>Information</strong></p>
     <ul class="fa-ul">
       <?php
	  
	switch ($item['post']['instructions']['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';	
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
       <li><?php echo $resourceclass; ?><a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $item['post']['instructions']['filename']; ?>" target="_blank"><?php echo $item['post']['instructions']['description']; ?></a></li>
     </ul>
     <?php } ?>
     
      <?php if (!(empty($item['post']['linked']))) { ?>
     <p><strong>Resources</strong></p>
     <ul class="fa-ul">
       <?php foreach ($item['post']['linked'] as $plinked) { ?>
       <?php
	  
	switch ($dlinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';	
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
       <li><?php echo $resourceclass; ?><a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $plinked['filename']; ?>" target="_blank"><?php echo $plinked['description']; ?></a></li>
       <?php } ?>
     </ul>
     <?php } ?>
   </div>
  </div>
  </div>
</div> <!-- / post activity  -->

 <?php } ?>

</div> <!-- / panel panel-primary-->

</div>

<?php } ?>
<!-- / resources panel -->
<div class="col-md-12">
  <div class="well well-sm" style="font-size:12px;">
    <h4> Tags</h4>
    <p><strong>Cross Topic</strong>
      <?php if (!(empty($item['crossTopic']))) { ?>
      <?php foreach ($item['crossTopic'] as $crossTopic) { ?>
      <?php echo $crossTopic['type']; ?>&nbsp;/&nbsp;
      <?php }  // end foreach crossTopic tags ?>
      <?php }  //  crossTopic tags not empty   ?>
    </p>
    <p><strong>Disciplines</strong>
      <?php if (!(empty($item['disciplines']))) { ?>
      <?php foreach ($item['disciplines'] as $d) { ?>
      <?php echo $d['discipline']; ?>&nbsp;/&nbsp;
      <?php }  // end foreach disciplines tags ?>
      <?php }  //  disciplines tags not empty   ?>
    </p>
    <p><strong>Common Presentations</strong>
      <?php if (!(empty($item['common_presentations']))) { ?>
      <?php foreach ($item['common_presentations'] as $cp) { ?>
      <?php echo $cp['presentation']; ?>&nbsp;/&nbsp;
      <?php }  // end foreach disciplines tags ?>
      <?php }  //  disciplines tags not empty   ?>
    </p>
    <p><strong>Common Conditions</strong>
      <?php if (!(empty($item['common_conditions']))) { ?>
      <?php foreach ($item['common_conditions'] as $cc) { ?>
      <?php echo $cc['condition']; ?>&nbsp;/&nbsp;
      <?php }  // end foreach disciplines tags ?>
      <?php }  //  disciplines tags not empty   ?>
    </p>
    <p><strong>Skills and Procedures</strong>
      <?php if (!(empty($item['skills']))) { ?>
      <?php foreach ($item['skills'] as $s) { ?>
      <?php echo $s['skill']; ?>&nbsp;/&nbsp;
      <?php }  // end foreach disciplines tags ?>
      <?php }  //  disciplines tags not empty   ?>
    </p>
    <p><strong>Other</strong>
      <?php if (!(empty($item['otherTags']))) { ?>
      <?php foreach ($item['otherTags'] as $other) { ?>
      <?php echo $other['tag']; ?>&nbsp;/&nbsp;
      <?php }  // end foreach other tags ?>
      <?php }  //  other tags not empty   ?>
    </p>
  </div>
  <!-- / col-md-12 -->
</div>
</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>


