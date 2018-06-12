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

<!-- FLO styles

<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/flostyles.css">
 -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/flostyles29.css">

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
<link href="<?php echo base_url() . 'resource/flo/ocf/';?>css/font-awesome-4.4.0/css/font-awesome.css" rel="stylesheet" type="text/css">



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

.printOnly {
	
	display:none;
	visibility:hidden;
	
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
  
.printOnly {
	
	display:block;
	visibility:visible;
	
}
#myNav {
	display:none;
	visibility:hidden;
	
} 



.block {
	
	border: none;


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


$(document).on("hidden.bs.modal", function (e) { $(e.target).removeData("bs.modal").find(".modal-body").empty();$(e.target).removeData("bs.modal").find(".modal-title").empty(); $(".modal-body").html('<p>Loading…</p>'); $(".modal-title").html('Detail');
 });



</script>

  <script type="text/javascript">

$(window).on('resize', function() {
if ($(window).width()>992) {
        
		
var divHeight = $('#activitylist').outerHeight(); 
$('#activitydetail').css('min-height', divHeight+'px');

    } else {
		
	$('#activitydetail').css('min-height', '0px');

	
		
	}
});	

$(document).ready(function() {

$('#activityReset').hide();

if ($(window).width()>992) {
var divHeight = $('#activitylist').outerHeight(); 
$('#activitydetail').css('min-height', divHeight+'px');
}



	

	

  // select all the links with class="ajaxLoad", when one of them is clicked, get its "href" value
  // load the content from that URL and place it into the tag with id="content"
  $('a.ajaxLoad').click(function() {
    var url = $(this).attr('href');
	//alert(url);
	$('#item-detail').html('<h4>Loading…</h4><br /><i class="fa fa-spinner fa-spin fa-3x fa-fw text-muted"></i>');
    $('#item-detail').load(url) ;
	$('#activityReset').show();
	
	//alert(textStatus);
    return false;
  });



$('#printControl').on("click", function() {
    $("#collpaseLO").collapse('show');
	
	setTimeout(function() {window.print(); }, 800);
	
	setTimeout(function() {$("#collpaseLO").collapse('hide');}, 2000);
	
	
	
});


$('#activityReset').on("click", function() {
    $("#item-detail").html('<h4>Activity Detail</h4><p>Select an activity from the list to display detail.</p>');
	
	$('#activityReset').hide();
	
	
	
	
	
});



});




--></script>
 
 <script>
 
 
function groupLoad(uuid, version, topic, puuid, pversion) {

	//alert(uuid);
	//alert(version);
	//alert(topic);
	//alert(puuid);
	//alert(pversion);
	
	var groupURL = '/flex/flo-ocf/activitygroupflo/';
	
	
	groupURL = groupURL + uuid + '/' + version + '/' + topic + '/' + puuid + '/' + pversion;
	
	
	
	

	
	var loURL = '/flex/flo-ocf/logroupflo/';
	
	loURL = loURL + uuid + '/' + version + '/' + topic + '/' + puuid + '/' + pversion;
	
 	
	
	
	
	
	
	// Look for
 	var mrURL = '/flex/flo-ocf/mrgroupflo/';
	
	mrURL = mrURL + uuid + '/' + version + '/' + topic + '/' + puuid + '/' + pversion;
	
	
	//alert('https://flextra.flinders.edu.au' + groupURL);
	//alert('https://flextra.flinders.edu.au' + mrURL);
	
	
	
	
	
	$('#activitylist').html('<h4>Loading content modules…</h4><br /><i class="fa fa-spinner fa-spin fa-3x fa-fw text-muted"></i>');
	
	$('#loBlock').html(' ');
	
   // $('#module-resources').html('<p>Searching for module resources… <i class="fa fa-spinner fa-spin  fa-fw text-muted"></i></p>')

	
	$('#activitylist').load(groupURL) ;
	$('#loBlock').load(loURL) ;
	//$('#module-resources').load(mrURL) ;
	
	
	//$('#item-detail').html('<h4>Loading…</h4><br /><i class="fa fa-spinner fa-spin fa-3x fa-fw text-muted"></i>');
	
	
	
	

	
//   $('#item-detail').load(detailurl) ;
	//$('#activityReset').show();
	
	
    return false;
  }

 
 function activityLoad(url) {

	
	<?php if($_SESSION['userinfo']['fan'] == 'couc0005') { ?>
	//alert('https://flextra.flinders.edu.au' + url);
	
	<?php } ?>
	
	$('#item-detail').html('<h4>Loading …</h4><br /><i class="fa fa-spinner fa-spin fa-3x fa-fw text-muted"></i>');
    $('#item-detail').load(url) ;
	
	
	
	
	$('#activityReset').show();
	
    return false;
  }


 function activityReset() {

	//alert('activityLoad function');
	
	 $("#item-detail").html('<h4>Activity Detail</h4><p>Select an activity from the list to display detail.</p>');
	
	if ($(window).width()>992) {
var divHeight = $('#activitylist').outerHeight(); 
$('#activitydetail').css('min-height', divHeight+'px');
}

	
	
    return false;
  }

 
 </script>
 
 </script>
 
 
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


<div class="jumbotron">
  <div class="container-fluid">
    <div class="col-md-9 col-sm-12 col-xs-12"> <img src="<?php echo base_url() . 'resource/flo/ocf/';?>images/Flinders-50th-logo.png" alt="Flinders University" width="223" height="45" style="float:left;">
      <div class="banner-text">
    
        <p>You are logged in via FLO as <?php echo $_SESSION['userinfo']['name']; ?><br>
          Access level: <?php echo $_SESSION['userinfo']['role']; ?>
        </p>
      </div>
    </div>
   
  </div>
</div>
        
   

<div class="container-fluid" style="margin:0 20px 0 20px;">
  <div role="main">
    <div class="row">
      <h3><?php echo $item['itemTitle']; ?></h3>
    </div>
    
    
    
    <div class="row" style="margin-bottom:0.5em;">


<p><?php echo $item['itemDescription']; ?></p>


</div> <!-- ./ row -->

<div class="row doNotPrint" style="margin-bottom:0.5em;">
<div class="col-md-6">
<div class="block-region block" id="activitylist" style="margin:2px;">




	
<?php if ((!(empty($item['overall']['linked']))) || (!(empty($item['overall']['instructions'])))) { ?>
<h5>Module Resources</h5>

<ul class="fa-ul">
<?php
	  
	switch ($item['overall']['instructions']['type']) {
	
	
	
	case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';
		$resourceserver = '/flex/ocf/loadpageflo/file';
		
		if($item['overall']['instructions']['resourceType'] == 'a') {
				$theUuid = $item['overall']['instructions']['itemUuid'];
				$theVersion = $item['overall']['instructions']['itemVersion'];
				} else {
				$theUuid = $item['thisUuid'];
				$theVersion = $item['thisVersion'];
			}
		
	
		
		$linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($item['overall']['instructions']['filename']));
		
		
		$href = $resourceserver.$linkuse ;
		
		break;
		
	case 'file':

		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		
		//$linktype = 'file';
		
		if($item['overall']['instructions']['resourceType'] == 'a') {
		
		$linkuse = '/' . $item['overall']['instructions']['itemUuid'] . '/' . $item['overall']['instructions']['itemVersion'] . '/' .$item['overall']['instructions']['filename'] ; } else {
		
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$olinked['filename'] ; }
		
		$resourceserver = '/flex/ocf/generatetoken/viewfile/file';
		//$linkclass = 'class="generateToken"';
		$href = $resourceserver.$linkuse ;
		
		break;
	
	
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
        <li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $item['overall']['instructions']['description']; ?></a></li> 
    </ul>


<ul class="fa-ul">
        <?php foreach ($item['overall']['linked'] as $olinked) { ?>
        <?php
	  
switch ($olinked['type']) {
	
	case 'file':

		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		
		//$linktype = 'file';
		
		if($olinked['resourceType'] == 'a') {
		$linkuse = '/' . $olinked['itemUuid'] . '/' . $olinked['itemVersion'] . '/' .$olinked['filename'] ; } else {
		
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$olinked['filename'] ; }
		
		$resourceserver = '/flex/ocf/generatetoken/viewfile/file';
		//$linkclass = 'class="generateToken"';
		$href = $resourceserver.$linkuse ;
		
		break;
		
	case 'linked-resource': 
	
	
		if($item['pblCase']) { 
		
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = '';	
		$linkuse =  $olinked['itemUuid'] . '/' . $olinked['itemVersion'];
		$resourceserver = '/flex/ocf/caseview';
		$linkclass = '';
		$href = $resourceserver.$linkuse ;
		
		} else {
			
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $olinked['itemUuid'] . '/' . $olinked['itemVersion'];
		$resourceserver = $flexserv;
		$linkclass = 'class="generateToken"';
		$href = $resourceserver.$linkuse ;
		
		}
		break;
		
		
		
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';
		
		if($olinked['resourceType'] == 'a') {
			$linkuse = '/' . $olinked['itemUuid'] . '/' . $olinked['itemVersion'] . '/' . urlencode(base64_encode($olinked['filename']));
		} else {
			$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . urlencode(base64_encode($olinked['filename']));
		}
		
		
		$resourceserver = '/flex/ocf/loadpageflo/file';
		$linkclass = '';
		$href = $resourceserver.$linkuse ;
		
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
        <li><?php echo $resourceclass; ?><a href="<?php echo $olinked['url']; ?>" target="_blank"><?php echo $olinked['description']; ?></a><span class="printOnly">URL:&nbsp;<?php echo $olinked['url']; ?></span></li>
        <?php } else { ?>
	<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" <?php echo $linkclass; ?>><?php echo $olinked['description']; ?></a></li>
 
        <?php } ?>
        <?php } ?>
      </ul>


<?php } ?>


  



<h5> Learning  Activities</h5>
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
		//$docondition = '<i class="fa fa-share-alt fa-fw" style="margin-right:0.8em;"></i>';
		//$dctext = ' (Alternative activity)';
		break;
	case 'optional':
		$docondition = '<i class="fa fa-circle-o fa-fw"  style="margin-right:0.8em;"></i>';
		$dctext = ' (Optional activity)';
		break;
	default:
		$docondition = '';
		$dctext = '';
		break;
	
}

?>

<li>
<?php if ($linktype == "activity" ) { ?>
<?php echo $docondition; ?><a href = "/flex/flo-ocf/activityflo/<?php echo $activity['itemUuid']; ?>/<?php echo $activity['itemVersion']; ?>/<?php echo $activity['activityParent']; ?>"  class="ajaxLoad" title="View activity detail"><?php echo $activity['title']; ?></a><?php echo $dctext;?>
<?php } ?>

<?php if ($linktype == "group" ) { ?>

<?php 

$puuid = $activity['activityParent'];
$pversion =  $activity['activityParentVersion'];

 ?>
<?php echo $docondition; ?><a href = "#" onClick="javascript:groupLoad('<?php echo $activity['itemUuid']; ?>','<?php echo $activity['itemVersion']; ?>','<?php echo $item['itemTopic']; ?>','<?php echo $puuid; ?>','<?php echo $pversion; ?>');"  title="View activity group"><?php echo $activity['title']; ?></a>
<?php } ?>
</li>

<?php } ?>
</ul>

<button id="activityReset" class="btn btn-default btn-mini">Reset activity detail</button>
<?php }  // $item['activities'] not empty ?> 
</div>   
</div>




<div class="col-md-6 doNotPrint">
<div class="block block_course_overview" id="activitydetail" style="margin:2px;">
<div id="item-detail">
<h4>Activity Detail</h4>
<p>Select an activity from the list to display detail.</p>
</div>
</div>  
</div> 
</div>
<div id="loBlock">
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
</div> <!-- ./ #loBlock -->
</div> <!-- ./ main -->
</div> <!-- ./ container-fluid -->




</body>
</html>
