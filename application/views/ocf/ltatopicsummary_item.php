<?php include_once('includes/language.php'); ?>
<?php

$pagefrom = $_SERVER['HTTP_REFERER']; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Activity Group::<?php echo $item['itemTitle']; ?></title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap-theme.min.css">
<!-- Local styles -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/local.css">


<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- Latest compiled and minified JavaScript -->



<script type="text/javascript" src="<?php echo base_url() . 'resource/flo/ocf/';?>js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'resource/flo/ocf/';?>js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo base_url() . 'resource/flo/ocf/';?>js/bootstrap.min.js"></script>     
<link href="<?php echo base_url() . 'resource/flo/ocf/';?>css/font-awesome-4.2.0/css/font-awesome.css" rel="stylesheet" type="text/css">
<script type="text/javascript">

$(document).ready(function(){

	$('.instruction').tooltip();


});  

</script>
<script type="text/javascript">

/*  resets the modal ready for it's next use */


$(document).on("hidden.bs.modal", function (e) { $(e.target).removeData("bs.modal").find(".modal-body").empty();$(e.target).removeData("bs.modal").find(".modal-title").empty(); $(".modal-body").html('<p>Loading…</p>'); $(".modal-title").html('Detail');
 });



</script>

<style type="text/css">
.tooltip-inner{
    max-width:300px;
    padding:3px 8px;
    color:#fff;
    text-align:left;
}
<!--
  .doNotPrint {

	  
  }
  
  
    .instruction {
	  

	  
  }

@media print {


    body {
        margin: 0;
        padding: 0;
        line-height: 1.4em;
        word-spacing: 1px;
        letter-spacing: 0.2px;
        font: 13px Arial, Helvetica,"Lucida Grande", serif;
        color: #000;
    }

  a[href]:after {
    content: "";
  }
  
  .doNotPrint {
	  
	  visibility: hidden;
	  display: none;
	  
	  
  }
  

#myNav {
	display:none;
	visibility:hidden;
	
} 



}
-->
</style>
<script type="text/javascript">

$(document).ready(function(){

        $('.heatmap').tooltip({
    	'placement': 'top' });


});  

$(document).ready(function(){

        $('.btn-sm').tooltip({
    	'placement': 'top' });

});

 </script>
 
<script type="text/javascript">
/*  resets the modal ready for it's next use */
$(document).ready(function(){
  $(document).on("hidden.bs.modal", function (e) { $(e.target).removeData("bs.modal").find(".modal-body").empty();$(e.target).removeData("bs.modal").find(".modal-title").empty(); $(".modal-body").html('<p>Loading…</p>'); $(".modal-title").html('Detail');
  });
});
</script>

 
 
</head>
<body role="document">
<!-- Modal -->
<div class="jumbotron">
  <div class="container-fluid">
    <div class="col-md-9 col-sm-12 col-xs-12"> <img src="<?php echo base_url() . 'resource/flo/ocf/';?>images/logo-flinders_portrait.png" width="51" height="65" alt="Flinders University" style="float:left;">
      <div class="banner-text">
        <h2><?php echo strtoupper($courses['code']); ?> Curriculum Framework</h2>
        <p>Welcome <?php echo $_SESSION['username']; ?><br />
          <span class="small"><em>Your group membership grants access to the following course(s):
            <?php foreach($_SESSION['ocf_validgrouplist'] as $key=>$value) {
	  echo strtoupper($value) . " / " ;
	  
  }?>
          </em></span></p>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="modal-content-id">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail</h4>
      </div>
      <div class="modal-body">
      <p>Loading…</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<?php 
$sam_title = 'N/A';
if(isset($sam['sam_name']))
{
	$sam_title = $sam['sam_name'];
}

$taa_title = 'N/A';
if(isset($taa['taa_name']))
{
	$taa_title = $taa['taa_name'];
}
?>
        
        

		
<div class="container-fluid" style="margin:15px 20px 0 20px;">

  <div role="main">
    <div class="row">
      <h4>Activity Group  :: <?php echo $item['itemTitle']; ?></h4>
    </div>

<!--       


Where have I come from = <?php echo $pagefrom; ?>

-->

<div class="row" style="margin-bottom:0.5em;">
  <div class="col-md-12">
<h5>Description</h5>
<p><?php echo $item['itemDescription']; ?></p>
</div>
</div>


<div class="row">
<div class="col-md-12">
<h5> Learning & Teaching Activities</h5>


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
<?php echo $docondition; ?><a href = "/flex/ocf/activity/<?php echo $activity['itemUuid']; ?>/<?php echo $activity['itemVersion']; ?>/<?php echo $activity['activityParent']; ?>/1"  data-toggle="modal" data-target="#myModal" title="View activity detail"><?php echo $activity['title']; ?></a>
<?php } ?>

<?php if ($linktype == "group" ) { ?>
<?php echo $docondition; ?><a href = "/flex/ocf/ltats/<?php echo $activity['itemUuid']; ?>/<?php echo $activity['itemVersion']; ?>/<?php echo $item['itemTopic']; ?>"  title="View activity group"><?php echo $activity['title']; ?></a>
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



</div>


<?php if (!(empty($item['los']))) { ?>
<div class="col-md-12">

<h5> Learning Objectives</h5>
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
	case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'web';	
		break;
		
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
    <li><?php echo $resourceclass; ?>
    <?php if ($linktype == 'web') { ?>
	<a href="<?php echo $olinked['url']; ?>" target="_blank">Web site: "<?php echo $olinked['description']; ?>"</a>
	<?php } else { ?>
    <a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $olinked['filename']; ?>" target="_blank"><?php echo $olinked['description']; ?></a><?php } ?></li
      
    ></ul>
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
	case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'web';	
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>

    <li><?php echo $resourceclass; ?>
    <?php if ($linktype == 'web') { ?>
	<a href="<?php echo $olinked['url']; ?>" target="_blank">Web site: "<?php echo $olinked['description']; ?>"</a>
	<?php } else { ?>
    <a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $olinked['filename']; ?>" target="_blank"><?php echo $olinked['description']; ?></a><?php } ?></li>
    
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
	case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'web';	
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
    <li><?php echo $resourceclass; ?>
    <?php if ($linktype == 'web') { ?>
	<a href="<?php echo $olinked['url']; ?>" target="_blank">Web site: "<?php echo $olinked['description']; ?>"</a>
	<?php } else { ?>
    <a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $olinked['filename']; ?>" target="_blank"><?php echo $olinked['description']; ?></a><?php } ?></li
      
    ></ul>
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
	case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'web';	
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>

    <li><?php echo $resourceclass; ?>
    <?php if ($linktype == 'web') { ?>
	<a href="<?php echo $olinked['url']; ?>" target="_blank">Web site: "<?php echo $olinked['description']; ?>"</a>
	<?php } else { ?>
    <a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $olinked['filename']; ?>" target="_blank"><?php echo $olinked['description']; ?></a><?php } ?></li
    
    ><?php } ?>
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
	case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'web';	
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
	case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'web';	
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
    <li><?php echo $resourceclass; ?>
    <?php if ($linktype == 'web') { ?>
	<a href="<?php echo $olinked['url']; ?>" target="_blank">Web site: "<?php echo $olinked['description']; ?>"</a>
	<?php } else { ?>
    <a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $olinked['filename']; ?>" target="_blank"><?php echo $olinked['description']; ?></a><?php } ?></li
       ><?php } ?>
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
	case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'web';	
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
    <li><?php echo $resourceclass; ?>
    <?php if ($linktype == 'web') { ?>
	<a href="<?php echo $olinked['url']; ?>" target="_blank">Web site: "<?php echo $olinked['description']; ?>"</a>
	<?php } else { ?>
    <a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $olinked['filename']; ?>" target="_blank"><?php echo $olinked['description']; ?></a><?php } ?></li
     ></ul>
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
	case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'web';	
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
    <li><?php echo $resourceclass; ?>
    <?php if ($linktype == 'web') { ?>
	<a href="<?php echo $olinked['url']; ?>" target="_blank">Web site: "<?php echo $olinked['description']; ?>"</a>
	<?php } else { ?>
    <a href="https://flex.flinders.edu.au/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $olinked['filename']; ?>" target="_blank"><?php echo $olinked['description']; ?></a><?php } ?></li
       ><?php } ?>
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
  <div class="well well-sm" style="font-size:12px;">
    <h4> Tags</h4>
          <?php if (!(empty($item['crossTopic']))) { ?>
    <p><strong>Cross Topic</strong>

      <?php foreach ($item['crossTopic'] as $crossTopic) { ?>
      <?php echo $crossTopic['type']; ?>&nbsp;/&nbsp;
      <?php }  // end foreach crossTopic tags ?>

    </p>
          <?php }  //  crossTopic tags not empty   ?>
     <?php if (!(empty($item['disciplines']))) { ?>
    <p><strong>Disciplines</strong>
    
      <?php foreach ($item['disciplines'] as $d) { ?>
      <?php echo $d['discipline']; ?>&nbsp;/&nbsp;
      <?php }  // end foreach disciplines tags ?>

    </p>
          <?php }  //  disciplines tags not empty   ?>
             <?php if (!(empty($item['common_presentations']))) { ?>
    <p><strong>Common Presentations</strong>
   
      <?php foreach ($item['common_presentations'] as $cp) { ?>
      <?php echo $cp['presentation']; ?>&nbsp;/&nbsp;
      <?php }  // end foreach disciplines tags ?>
 
    </p>
         <?php }  //  disciplines tags not empty   ?>
         
             <?php if (!(empty($item['common_conditions']))) { ?>
    <p><strong>Common Conditions</strong>
  
      <?php foreach ($item['common_conditions'] as $cc) { ?>
      <?php echo $cc['condition']; ?>&nbsp;/&nbsp;

   
    </p>
    
          <?php }  // end foreach disciplines tags ?>
       <?php }  //  disciplines tags not empty   ?>
             <?php if (!(empty($item['skills']))) { ?>
    <p><strong>Skills and Procedures</strong>

      <?php foreach ($item['skills'] as $s) { ?>
      <?php echo $s['skill']; ?>&nbsp;/&nbsp;
      <?php }  // end foreach disciplines tags ?>

    </p>
          <?php }  //  disciplines tags not empty   ?>
                <?php if (!(empty($item['otherTags']))) { ?>
    <p><strong>Other</strong>

      <?php foreach ($item['otherTags'] as $other) { ?>
      <?php echo $other['tag']; ?>&nbsp;/&nbsp;
      <?php }  // end foreach other tags ?>
  
    </p>
        <?php }  //  other tags not empty   ?>
  </div>
  
  <?php } ?>
  <!-- / col-md-12 -->
</div>
</div>


</div>

</div>



</body>
</html>
