<?php


switch ($_SERVER['SERVER_NAME']) {


    case "flextra.flinders.edu.au":
    
        $flexserv = "https://flex.flinders.edu.au";
        break;

    case "flextra-test.flinders.edu.au":
    
        $flexserv = "https://flex-test.flinders.edu.au";
        break;


    case "flextra-dev.flinders.edu.au":
    
        $flexserv = "https://flex-dev.flinders.edu.au";
        break;

}



?>

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel"><!--<i class="fa fa-file-o fa-fw"></i> --><?php echo $item['itemTitle']; ?></h4>
  </div>
  <!-- / modal-header -->
  
  <div class="modal-body">
 <div class="noPrint"> 
 <!-- edit button --> 
 
 <?php if(isset($privilege))
	{
		if($privilege == 'moderator&contributor')
		{
	?> 
<a href="<?php echo $flexserv; ?>/items/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>?token=<?php echo $token; ?>" target="_blank" class="btn btn-sm btn-danger pull-right"><i class="fa fa-edit"></i> Edit this item</a>
<?php 
		}}?>
 



</div>
<div class="row" style="margin-bottom:0.5em;">
<div class="col-md-12">
<h4>Description</h4>
<p><?php echo $item['itemDescription']; ?></p>
</div>
</div>   <!-- / row --> 


<div class="row">

<?php if (!(empty($activity_los))) { ?>
<div class="col-md-12">


<h4>Learning Objectives</h4>

<dl class="dl-horizontal">
<?php foreach ($activity_los as $activitylo) { ?>
<dt><?php echo $activitylo['code']; ?></dt>
<dd><?php echo $activitylo['name']; ?></dd>
<?php } ?>
</dl>

</div>   <!-- / col-md-12 --> 
<?php }  //  lo not empty   ?>

<!--

<?php if (!(empty($los['los']))) { ?>

<div class="col-md-12">


<h4> Aligned Outcomes</h4>

<dl class="dl-horizontal">
<?php foreach ($los['los'] as $alignedlo) { ?>
<dt><?php echo $alignedlo['code']; ?></dt>
<dd><?php echo $alignedlo['name']; ?></dd>
<?php } ?>
</dl>
</div>  

<?php }  //  lo not empty   ?>
-->



<div class="col-md-12">
<?php 

$loEmpty = empty($los);

?>

</div>   <!-- / col-md-12 --> 

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
  <p><span style="margin-right: 2em;"><strong>Information</strong></span></p>
  <ul class="fa-ul">
  <?php
	  
	switch ($item['overall']['instructions']['type']) {
	
	
	
	case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';
		$resourceserver = '/flex/ocf/loadpage';
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>

      
      <li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo urlencode(base64_encode($item['overall']['instructions']['filename'])); ?>" target="_blank"><?php echo $item['overall']['instructions']['description']; ?></a></li>  
      
    </ul>
    <?php } ?>
    
    
    <?php if (!(empty($item['overall']['linked']))) { ?>
   <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
    <ul class="fa-ul">
    <?php foreach ($item['overall']['linked'] as $olinked) { ?>
      <?php
	  
	switch ($olinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . $olinked['filename'] ;
		$resourceserver = $flexserv;
		break;
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $olinked['itemUuid'] . '/' . $olinked['itemVersion'];
		$resourceserver = $flexserv;
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . $olinked['filename'] ;
		$resourceserver = '/flex/ocf/loadpage';
		break;
	
	case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'url';	
		break;
	
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
      
     
    <?php if ($olinked['type'] == 'url') { ?>
    
     <li><?php echo $resourceclass; ?><a href="<?php echo $olinked['url']; ?>" target="_blank"><?php echo $olinked['description']; ?></a></li>
    
    <?php } else { ?>

    <li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?><?php echo $linkuse ; ?>?token=<?php echo $token; ?>" target="_blank"><?php echo $olinked['description']; ?></a></li>
      <?php } ?>
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
  <p><span style="margin-right: 2em;"><strong>Information</strong></span></p>
  <ul class="fa-ul">
  <?php
	  
	switch ($item['pre']['instructions']['type']) {
	
	case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$resourceserver = '/flex/ocf/loadpage';
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
      <li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo urlencode(base64_encode($item['pre']['instructions']['filename'])); ?>" target="_blank"><?php echo $item['pre']['instructions']['description']; ?></a></li>
      
    </ul>
    <?php } ?>
    
    
    
     <?php if (!(empty($item['pre']['linked']))) { ?>
   <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
    <ul class="fa-ul">
    <?php foreach ($item['pre']['linked'] as $prelinked) { ?>
      <?php
	  
	switch ($prelinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';
		$linkuse = '/' . $prelinked['filename'] ;
		$resourceserver = $flexserv;
		break;
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $prelinked['itemUuid'] . '/' . $prelinked['itemVersion'];
		$resourceserver = $flexserv;
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$linkuse = '/' . $prelinked['filename'] ;
		$resourceserver = '/flex/ocf/loadpage';
		break;
		
	case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'url';	
		break;
	default:
		$resourceclass = '';
		break;
}
	 
	  ?>
    <?php if ($prelinked['type'] == 'url') { ?>
    
     <li><?php echo $resourceclass; ?><a href="<?php echo $prelinked['url']; ?>" target="_blank"><?php echo $prelinked['description']; ?></a></li>
    
    <?php } else { ?>
    <li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?><?php echo $linkuse ; ?>?token=<?php echo $token; ?>" target="_blank"><?php echo $prelinked['description']; ?></a></li>
    
   <?php } ?> 
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
     <p><span style="margin-right: 2em;"><strong>Information</strong></span></p>
     <ul class="fa-ul">
       <?php
	  
	switch ($item['during']['instructions']['type']) {
	
	case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$resourceserver = '/flex/ocf/loadpage';
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
       <li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo urlencode(base64_encode($item['during']['instructions']['filename'])); ?>" target="_blank"><?php echo $item['during']['instructions']['description']; ?></a></li>
     </ul>
     <?php } ?>
     
      <?php if (!(empty($item['during']['linked']))) { ?>
     <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
     <ul class="fa-ul">
       <?php foreach ($item['during']['linked'] as $dlinked) { ?>
       <?php
	  
	switch ($dlinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';
		$linkuse = '/' . $dlinked['filename'] ;
		$resourceserver = $flexserv;
		break;
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $dlinked['itemUuid'] . '/' . $dlinked['itemVersion'];
		$resourceserver = $flexserv;
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$linkuse = '/' . $dlinked['filename'] ;
		$resourceserver = '/flex/ocf/loadpage';
		break;
	case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'url';	
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
 <?php if ($dlinked['type'] == 'url') { ?>
    
     <li><?php echo $resourceclass; ?><a href="<?php echo $dlinked['url']; ?>" target="_blank"><?php echo $dlinked['description']; ?></a></li>
    
    <?php } else { ?>
      
    <li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?><?php echo $linkuse ; ?>?token=<?php echo $token; ?>" target="_blank"><?php echo $dlinked['description']; ?></a></li>
    <?php } ?>
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
     <p><span style="margin-right: 2em;"><strong>Information</strong></span></p>
     <ul class="fa-ul">
       <?php
	  
	switch ($item['post']['instructions']['type']) {
	
	case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$resourceserver = '/flex/ocf/loadpage';
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
       <li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo urlencode(base64_encode($item['post']['instructions']['filename'])); ?>" target="_blank"><?php echo $item['post']['instructions']['description']; ?></a></li>
     </ul>
     <?php } ?>
     
      <?php if (!(empty($item['post']['linked']))) { ?>
     <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
     <ul class="fa-ul">
       <?php foreach ($item['post']['linked'] as $plinked) { ?>
       <?php
	  
	switch ($plinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';
		$linkuse = '/' . $plinked['filename'] ;
		$resourceserver = $flexserv;
		break;
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $plinked['itemUuid'] . '/' . $plinked['itemVersion'];
		$resourceserver = $flexserv;
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$linkuse = '/' . $plinked['filename'] ;
		$resourceserver = '/flex/ocf/loadpage';
		break;
	case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'url';	
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
      
     <?php if ($plinked['type'] == 'url') { ?>
    
     <li><?php echo $resourceclass; ?><a href="<?php echo $plinked['url']; ?>" target="_blank"><?php echo $plinked['description']; ?></a></li>
    
    <?php } else { ?>
    <li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?><?php echo $linkuse ; ?>?token=<?php echo $token; ?>" target="_blank"><?php echo $olinked['description']; ?></a></li>
    <?php } ?>
    
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

 <?php if (!(empty($item['crossTopic'])) || !(empty($item['disciplines'])) || !(empty($item['common_presentations'])) || !(empty($item['skills'])) || !(empty($item['otherTags'])) ) { ?> 

<div class="col-md-12">
<div class="well well-sm small">
<h4> Tags</h4>

<?php if (!(empty($item['crossTopic']))) { ?>
<p><span style="margin-right: 2em;"><strong>Cross Topic</strong></span></span>
<?php foreach ($item['crossTopic'] as $crossTopic) { ?>
	
<?php echo $crossTopic['type']; ?>&nbsp;/&nbsp;
	
<?php }  // end foreach crossTopic tags ?>
</p>
<?php }  //  crossTopic tags not empty   ?>



<?php if (!(empty($item['disciplines']))) { ?>
<p><span style="margin-right: 2em;"><strong>Disciplines</strong></span> 
<?php foreach ($item['disciplines'] as $d) { ?>
	
<?php echo $d['discipline']; ?>&nbsp;/&nbsp;
	
<?php }  // end foreach disciplines tags ?>

</p>
<?php }  //  disciplines tags not empty   ?>



<?php if (!(empty($item['common_presentations']))) { ?>
<p><span style="margin-right: 2em;"><strong>Common Presentations</strong></span> 
<?php foreach ($item['common_presentations'] as $cp) { ?>
	
<?php echo $cp['presentation']; ?>&nbsp;/&nbsp;
	
<?php }  // end foreach disciplines tags ?>
</p>
<?php }  //  disciplines tags not empty   ?>


<?php if (!(empty($item['common_conditions']))) { ?><p><span style="margin-right: 2em;"><strong>Common Conditions</strong></span> 
<?php foreach ($item['common_conditions'] as $cc) { ?>
	
<?php echo $cc['condition']; ?>&nbsp;/&nbsp;
	
<?php }  // end foreach disciplines tags ?>
</p>
<?php }  //  disciplines tags not empty   ?>



<?php if (!(empty($item['skills']))) { ?>
<p><span style="margin-right: 2em;"><strong>Skills and Procedures</strong></span> 
<?php foreach ($item['skills'] as $s) { ?>
	
<?php echo $s['skill']; ?>&nbsp;/&nbsp;
	
<?php }  // end foreach disciplines tags ?>
</p>
<?php }  //  disciplines tags not empty   ?>



<?php if (!(empty($item['otherTags']))) { ?><p><span style="margin-right: 2em;"><strong>Other</strong></span> 
<?php foreach ($item['otherTags'] as $other) { ?>
	
<?php echo $other['tag']; ?>&nbsp;/&nbsp;
	
<?php }  // end foreach other tags ?>
</p>
<?php }  //  other tags not empty   ?>


</div>   <!-- / col-md-12 --> 
<?php } ?>
</div>
</div>    <!-- / row --> 

  
</div>
  <!-- / modal-body --> 


<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div><!-- / modal-footer -->
  
