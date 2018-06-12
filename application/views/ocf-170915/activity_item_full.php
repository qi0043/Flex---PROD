

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
<a href="https://flex.flinders.edu.au/items/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>?token=<?php echo $token; ?>" target="_blank" class="btn btn-sm btn-danger pull-right"><i class="fa fa-edit"></i> Edit this item</a>
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
   <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
    <ul class="fa-ul">
    <?php foreach ($item['overall']['linked'] as $olinked) { ?>
      <?php
	  
	switch ($olinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . $olinked['filename'] ;
		break;
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $olinked['itemUuid'] . '/' . $olinked['itemVersion'];
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . $olinked['filename'] ;
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>

    <li><?php echo $resourceclass; ?><a href="https://flex.flinders.edu.au/<?php echo $linktype; ?><?php echo $linkuse ; ?>" target="_blank"><?php echo $olinked['description']; ?></a></li>
    
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
   <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
    <ul class="fa-ul">
    <?php foreach ($item['pre']['linked'] as $prelinked) { ?>
      <?php
	  
	switch ($prelinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';
		$linkuse = '/' . $prelinked['filename'] ;
		break;
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $prelinked['itemUuid'] . '/' . $prelinked['itemVersion'];
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$linkuse = '/' . $prelinked['filename'] ;
		break;
	default:
		$resourceclass = '';
		break;
}
	 
	  ?>

    <li><?php echo $resourceclass; ?><a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?><?php echo $linkuse ; ?>" target="_blank"><?php echo $prelinked['description']; ?></a></li>
    
    
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
     <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
     <ul class="fa-ul">
       <?php foreach ($item['during']['linked'] as $dlinked) { ?>
       <?php
	  
	switch ($dlinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';
		$linkuse = '/' . $dlinked['filename'] ;
		break;
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $dlinked['itemUuid'] . '/' . $dlinked['itemVersion'];
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$linkuse = '/' . $dlinked['filename'] ;
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
    <li><?php echo $resourceclass; ?><a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?><?php echo $linkuse ; ?>" target="_blank"><?php echo $dlinked['description']; ?></a></li>
    
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
     <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
     <ul class="fa-ul">
       <?php foreach ($item['post']['linked'] as $plinked) { ?>
       <?php
	  
	switch ($plinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';
		$linkuse = '/' . $plinked['filename'] ;
		break;
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $plinked['itemUuid'] . '/' . $plinked['itemVersion'];
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$linkuse = '/' . $plinked['filename'] ;
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
    <li><?php echo $resourceclass; ?><a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?><?php echo $linkuse ; ?>" target="_blank"><?php echo $olinked['description']; ?></a></li>
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
<div class="well well-sm small">
<h4> Tags</h4>
<p><span style="margin-right: 2em;"><strong>Cross Topic</strong></span></span>
<?php if (!(empty($item['crossTopic']))) { ?><?php foreach ($item['crossTopic'] as $crossTopic) { ?>
	
<?php echo $crossTopic['type']; ?>&nbsp;::&nbsp;
	
<?php }  // end foreach crossTopic tags ?>
<?php }  //  crossTopic tags not empty   ?>
</p>




<p><span style="margin-right: 2em;"><strong>Disciplines</strong></span> 
<?php if (!(empty($item['disciplines']))) { ?><?php foreach ($item['disciplines'] as $d) { ?>
	
<?php echo $d['discipline']; ?>&nbsp;::&nbsp;
	
<?php }  // end foreach disciplines tags ?>
<?php }  //  disciplines tags not empty   ?>
</p>

<p><span style="margin-right: 2em;"><strong>Common Presentations</strong></span> 
<?php if (!(empty($item['common_presentations']))) { ?><?php foreach ($item['common_presentations'] as $cp) { ?>
	
<?php echo $cp['presentation']; ?>&nbsp;::&nbsp;
	
<?php }  // end foreach disciplines tags ?>
<?php }  //  disciplines tags not empty   ?>
</p>

<p><span style="margin-right: 2em;"><strong>Common Conditions</strong></span> 
<?php if (!(empty($item['common_conditions']))) { ?><?php foreach ($item['common_conditions'] as $cc) { ?>
	
<?php echo $cc['condition']; ?>&nbsp;::&nbsp;
	
<?php }  // end foreach disciplines tags ?>
<?php }  //  disciplines tags not empty   ?>
</p>


<p><span style="margin-right: 2em;"><strong>Skills and Procedures</strong></span> 
<?php if (!(empty($item['skills']))) { ?><?php foreach ($item['skills'] as $s) { ?>
	
<?php echo $s['skill']; ?>&nbsp;::&nbsp;
	
<?php }  // end foreach disciplines tags ?>
<?php }  //  disciplines tags not empty   ?>
</p>

<p><span style="margin-right: 2em;"><strong>Other</strong></span> 
<?php if (!(empty($item['otherTags']))) { ?><?php foreach ($item['otherTags'] as $other) { ?>
	
<?php echo $other['tag']; ?>&nbsp;::&nbsp;
	
<?php }  // end foreach other tags ?>
<?php }  //  other tags not empty   ?>

</p>


</div>   <!-- / col-md-12 --> 

</div>
</div>    <!-- / row --> 

  
</div>
  <!-- / modal-body --> 


<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div><!-- / modal-footer -->
  
