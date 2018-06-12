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


<script type="text/javascript">

$(document).ready(function(){

	
	
	 $('[data-toggle="myTooltip"]').tooltip();


});  

</script>


<script type="text/javascript">


//$(document).ready(function() {

  
  
  //$('#changeName').click(function(e) {
  function editItemName(url) {	
	  // e.preventDefault(); // do not follow link
	  $('#updateComplete').alert('close');
	   $('#editComplete').alert('close');
	  
 //var url = $(this).attr('href');
	//alert(url);
	$('#itemName').html('<h4 class="modal-title" id="myModalLabel"><span class="text-muted">Loading edit tool…</span>  <i class="fa fa-spinner fa-spin fa-fw text-muted"></i></h4>');
    $('#itemName').load(url) ;
	
	
	$('#changeName').addClass("disabled");
		$('#editDescription').addClass("disabled");
		$('#editItem').addClass("disabled");
	
	
	//alert(textStatus);
    return false;
  }
  

 function editItemDesc(url) {	     

   //$('#editDescription').click(function(e) {
	  // e.preventDefault(); // do not follow link
	  $('#editComplete').alert('close');
	   $('#updateComplete').alert('close');
        //var url = $(this).attr('href');
	//alert(url);
	var divHeight = $('#itemDescription').height();
	//alert(divHeight);
	$('#itemDescription').css("min-height",divHeight);
	
	$('#itemDescription').html('<p><span class="text-muted">Loading edit tool…</span>  <i class="fa fa-spinner fa-spin fa-fw text-muted"></i></p>');
    $('#itemDescription').load(url) ;
	$('#changeName').addClass("disabled");
		$('#editDescription').addClass("disabled");
		$('#editItem').addClass("disabled");
	
	
	//alert(textStatus);
    return false;
  };
  
   function editItemDesc(url) {	     

   //$('#editDescription').click(function(e) {
	  // e.preventDefault(); // do not follow link
	  $('#editComplete').alert('close');
	   $('#updateComplete').alert('close');
        //var url = $(this).attr('href');
	//alert(url);
	var divHeight = $('#itemDescription').height();
	//alert(divHeight);
	$('#itemDescription').css("min-height",divHeight);
	
	$('#itemDescription').html('<p><span class="text-muted">Loading edit tool…</span>  <i class="fa fa-spinner fa-spin fa-fw text-muted"></i></p>');
    $('#itemDescription').load(url) ;
	$('#changeName').addClass("disabled");
		$('#editDescription').addClass("disabled");
		$('#editItem').addClass("disabled");
	
	
	//alert(textStatus);
    return false;
  };
  
  
 $(document).ready(function() {
    
  $('a.generateToken').click(function(e) {
      return;
	   e.preventDefault(); // do not follow link

	  
 var url = $(this).attr('href');
	//alert(url);

	var tokenGenerator = '/flex/ocf/generatetoken/';
	//alert(tokenGenerator);
	
	
	$.ajax({
    url: '/flex/ocf/generatetoken/',
    type: 'GET',
    success: function(data){ 
        var newURL = url + '?token=' + data;
		//alert( "URL = " + newURL );
		window.open(newURL);
    },
    error: function(data) {
        alert( "Error creating token" );//or whatever
    }
});
	
	
	
	
	//alert(textStatus);
    return false;
  });
  
  
});


</script>

<style type="text/css">

.lBtn {
	
	text-align:left; 
	padding-left:6px;
}

</style>

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <div id="itemName">
    <h4 class="modal-title" id="myModalLabel"><!--<i class="fa fa-file-o fa-fw"></i> --><?php echo $item['itemTitle']; ?></h4>
    </div>
  </div>
  <!-- / modal-header -->
  
  <div class="modal-body">

<?php if (($_SESSION['ocf_ldapauth'])) { ?>



	
<div class="row" style="margin-bottom:0.5em;" id="itemdetail">
<div class="col-md-10 col-sm-8 col-xs-12">
<div id="itemDescription">
<p><?php echo $item['itemDescription']; ?></p>
</div>

  <?php if (!(empty($item['overall']))) { ?>  
<!--<h5 class="text-">Activity-wide instructions/resources</h5>-->
<?php } ?>

    
    <?php if (!(empty($item['overall']['instructions']))) { ?>
    <div class="col-md-6 col-sm-12 col-xs-12">
    
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
  </div>
    <?php } ?>
    
    
    <?php if (!(empty($item['overall']['linked']))) { ?>
      <div class="col-md-6 col-sm-12 col-xs-12">

    <ul class="fa-ul">
    <?php foreach ($item['overall']['linked'] as $olinked) { ?>
      <?php
	  
	switch ($olinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		//$linktype = 'file';
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .htmlentities($olinked['filename']) ;
		$resourceserver = '/flex/ocf/generatetoken/viewfile/file';
		//$linkclass = 'class="generateToken"';
		$href = $resourceserver.$linkuse ;
		
		break;
		
	case 'linked-resource': 
	
	
		if($item['pblCase']) { 
		
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = '';	
		$linkuse =  $olinked['itemUuid'] . '/' . $olinked['itemVersion'];
		$resourceserver = '/flex/ocf/caseview/';
		$linkclass = '';
		
		$href = $resourceserver.$linkuse ;
		
		
		} else {
			
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $olinked['itemUuid'] . '/' . $olinked['itemVersion'];
		$resourceserver = $flexserv;
		$linkclass = 'class="generateToken"';
		
		}
		break;
		
		
		
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . $olinked['filename'] ;
		$resourceserver = '/flex/ocf/loadpage';
		$linkclass = '';
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

    <li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" <?php echo $linkclass; ?>><?php if($item['pblCase'] != "False") { ?>Case page:&nbsp;<?php } ?><?php echo $olinked['description']; ?></a></li>
      <?php } ?>
    <?php } ?>
    </ul>
    </div>
    <?php } ?>


</div>

 <div class="col-md-2 col-sm-4 col-xs-12 noPrint"> 
 <!-- edit button --> 
 
 <?php if(isset($privilege))
	{
		
		if($privilege == 'moderator&contributor' && $activity_level > 1)
		{
	?> 
    <?php $itemname_url = '/flex/ocf/editname/' . $item['thisUuid'] . '/' . $item['thisVersion'];  ?>
    <?php $itemdesc_url = '/flex/ocf/editdescription/' . $item['thisUuid'] . '/' . $item['thisVersion'];  ?>
    <a href="#" onClick="javascript: editItemName('<?php echo $itemname_url;?>'); return false;" id="changeName" class="btn btn-sm btn-warning btn-block lBtn"><i class="fa fa-edit"></i> Edit name</a> 
    
    
    <a href="#" onClick="javascript: editItemDesc('<?php echo $itemdesc_url;?>'); return false;" id="editDescription" class="btn btn-sm btn-warning btn-block lBtn"><i class="fa fa-edit"></i> Edit description</a> 
    <a id="editItem" target='_blank' href="/flex/ocf/generatetoken/editactivity/items/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>" class="btn btn-sm btn-danger btn-block lBtn generateToken" data-toggle="myTooltip"  data-placement="left" title="Edit this item in FLEX"><i class="fa fa-edit"></i> Edit activity</a>
<?php 
		}}?>


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


 <?php if ( !(empty($item['pre'])) || !(empty($item['during'])) || !(empty($item['post'])) ) { ?> 

<div class="col-md-12">
<div class="panel panel-default">

  
  
  
 <?php if (!(empty($item['pre']))) { ?>  
<div class="row"> <!-- pre-activity -->
 
  <div class="col-md-12">
  <div class="panel panel-default" style="margin-bottom:0;">
   <div class="panel-heading ">
   <h5 class="panel-title">Pre-Activity</h5>
   </div>
<div class="panel-body" >
 <?php if (!(empty($item['pre']['instructions']))) { ?>
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
		$linkclass = 'class="generateToken"';
		break;
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $prelinked['itemUuid'] . '/' . $prelinked['itemVersion'];
		$resourceserver = $flexserv;
		$linkclass = 'class="generateToken"';
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
   <h5 class="panel-title">During Activity</h5>
   </div>
   <div class="panel-body" >
    <?php if (!(empty($item['during']['instructions']))) { ?>
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
		$linkclass = 'class="generateToken"';
		break;
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $dlinked['itemUuid'] . '/' . $dlinked['itemVersion'];
		$resourceserver = $flexserv;
		$linkclass = 'class="generateToken"';
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
   <h5 class="panel-title">Post Activity</h5>
   </div>
   <div class="panel-body" >
    <?php if (!(empty($item['post']['instructions']))) { ?>
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
		$linkclass = 'class="generateToken"';
		break;
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $plinked['itemUuid'] . '/' . $plinked['itemVersion'];
		$resourceserver = $flexserv;
		$linkclass = 'class="generateToken"';
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


 <p><span style="margin-right: 2em;"><strong>Teaching Type: </strong></span></span><?php echo $item['teachingType']; ?></p>


<?php if (!(empty($item['crossTopic']))) { ?>
<p><span style="margin-right: 2em;"><strong>Cross Topic</strong></span></span>
<?php foreach ($item['crossTopic'] as $crossTopic) { ?>
	
<?php echo $crossTopic['type']; ?>&nbsp;::&nbsp;
	
<?php }  // end foreach crossTopic tags ?>
</p>
<?php }  //  crossTopic tags not empty   ?>



<?php if (!(empty($item['disciplines']))) { ?>
<p><span style="margin-right: 2em;"><strong>Disciplines</strong></span> 
<?php foreach ($item['disciplines'] as $d) { ?>
	
<?php echo $d['discipline']; ?>&nbsp;::&nbsp;
	
<?php }  // end foreach disciplines tags ?>

</p>
<?php }  //  disciplines tags not empty   ?>



<?php if (!(empty($item['common_presentations']))) { ?>
<p><span style="margin-right: 2em;"><strong>Common Presentations</strong></span> 
<?php foreach ($item['common_presentations'] as $cp) { ?>
	
<?php echo $cp['presentation']; ?>&nbsp;::&nbsp;
	
<?php }  // end foreach disciplines tags ?>
</p>
<?php }  //  disciplines tags not empty   ?>


<?php if (!(empty($item['common_conditions']))) { ?><p><span style="margin-right: 2em;"><strong>Common Conditions</strong></span> 
<?php foreach ($item['common_conditions'] as $cc) { ?>
	
<?php echo $cc['condition']; ?>&nbsp;::&nbsp;
	
<?php }  // end foreach disciplines tags ?>
</p>
<?php }  //  disciplines tags not empty   ?>



<?php if (!(empty($item['skills']))) { ?>
<p><span style="margin-right: 2em;"><strong>Skills and Procedures</strong></span> 
<?php foreach ($item['skills'] as $s) { ?>
	
<?php echo $s['skill']; ?>&nbsp;::&nbsp;
	
<?php }  // end foreach disciplines tags ?>
</p>
<?php }  //  disciplines tags not empty   ?>



<?php if (!(empty($item['otherTags']))) { ?><p><span style="margin-right: 2em;"><strong>Other</strong></span> 
<?php foreach ($item['otherTags'] as $other) { ?>
	
<?php echo $other['tag']; ?>&nbsp;::&nbsp;
	
<?php }  // end foreach other tags ?>
</p>
<?php }  //  other tags not empty   ?>


</div>   <!-- / col-md-12 --> 
<?php } ?>
</div>
</div>

	
<?php } // end authorised


else { ?>

<div class="row">
  <h4 class="text-danger">Access denied </h4>
  <p>Your access does not grant you permission to view this item.</p>

</div>




<?php } // not authorised ?>

    <!-- / row --> 

  
</div>
  <!-- / modal-body --> 


<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div><!-- / modal-footer -->
  
