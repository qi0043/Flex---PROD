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


<?php include_once('includes/js_css.inc.php'); ?>


<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/flostyles.css">

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


$(document).on("hidden.bs.modal", function (e) { $(e.target).removeData("bs.modal").find(".modal-body").empty();$(e.target).removeData("bs.modal").find(".modal-title").empty(); $(".modal-body").html('<p>Loading…</p>'); $(".modal-title").html('Detail');
 });



</script>

  <script type="text/javascript">



$(document).ready(function() {
	
	
var divHeight = $('#activitylist').outerHeight(); 
$('#activitydetail').css('min-height', divHeight+'px');
	

  // select all the links with class="ajaxLoad", when one of them is clicked, get its "href" value
  // load the content from that URL and place it into the tag with id="content"
  $('a.ajaxLoad').click(function() {
    var url = $(this).attr('href');
	//alert(url);
	$('#item-detail').html('<h4>Loading…</h4><br /><i class="fa fa-spinner fa-spin fa-3x fa-fw text-muted"></i>');
    $('#item-detail').load(url) ;
	//alert(textStatus);
    return false;
  });
});







--></script>
 
 
</head>
<body role="document">
<!-- Modal --><!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
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
        
       

<div class="container-fluid" style="margin:0 20px 0 20px;">
<div role="main">
    <div class="row">
      <h3><?php echo $item['itemTitle']; ?></h3>
    </div
    
><div class="row" style="margin-bottom:0.5em;">


<p><?php echo $item['itemDescription']; ?></p>


</div> <!-- ./ row -->

<div class="row" style="margin-bottom:0.5em;">
<div class="col-md-6">
<div class="block block_course_overview" id="activitylist" style="margin:2px;">
<h4> Learning  Activities</h4>
<?php if (!(empty($item['activities']))) { ?>
<ul>
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

<li>
<?php if ($linktype == "activity" ) { ?>
<?php echo $docondition; ?><a href = "/flex/ocf/activityflo/<?php echo $activity['itemUuid']; ?>/<?php echo $activity['itemVersion']; ?>/<?php echo $activity['activityParent']; ?>"  class="ajaxLoad" title="View activity detail"><?php echo $activity['title']; ?></a>
<?php } ?>

<?php if ($linktype == "group" ) { ?>
<?php echo $docondition; ?><a href = "/flex/ocf/ltats/<?php echo $activity['itemUuid']; ?>/<?php echo $activity['itemVersion']; ?>/<?php echo $item['itemTopic']; ?>"  title="View activity group"><?php echo $activity['title']; ?></a>
<?php } ?>
</li>

<?php } ?>
</ul>
<?php }  // $item['activities'] not empty ?> 
</div>   
</div>




<div class="col-md-6">
<div class="block block_course_overview" id="activitydetail" style="margin:2px;">
<div id="item-detail">
<h4>Activity Detail</h4>
</div>
</div>  
</div> 
</div> <!-- ./ row -->



<!-- new row for aligned LOs -->
<div class="row">
<div class="col-md-12">
<div class="block block_course_overview" style="margin:2px 2px 30px 2px;">

<h4> Learning  Objectives & Alignment<button id="loControl" class="btn btn-mini btn-default" style="margin-left:3em;" data-toggle="collapse" data-target="#collpaseLO" aria-expanded="false" aria-controls="collpaseLO">Show/Hide
</button></h4>

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

</div> <!-- ./ main -->
</div> <!-- ./ container-fluid -->




</body>
</html>
