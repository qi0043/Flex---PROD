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
.printOnly1 {	
	display:none;
	visibility:hidden;
}
.printOnly1 {	
	display:block;
	visibility:visible;
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
    <div class="col-md-9 col-sm-12 col-xs-12"> <img src="<?php echo base_url() . 'resource/flo/ocf/';?>images/logo-flinders_portrait.png" width="51" height="65" alt="Flinders University" style="float:left;">
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
<?php if ((!(empty($item['overall']['linked']))) || (!(empty($item['overall']['instructions'])))) { ?>
<div class="row">
<div class="col-md-12">
<div class="block block_course_overview" style="margin:2px 2px 30px 2px;">
<h4>Module Resources</h4>
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
  <li><?php echo $resourceclass; ?><a href="<?php echo $olinked['url']; ?>" target="_blank"><?php echo $olinked['description']; ?></a><span class="printOnly1">URL:&nbsp;<?php echo $olinked['url']; ?></span></li>
  <?php } else { ?>
  <li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" <?php echo $linkclass; ?>><?php echo $olinked['description']; ?></a></li>
  <?php } ?>
  <?php } ?>
</ul>
</div>
</div>
</div>
<?php } ?>
<!-- new row for aligned LOs -->
<div class="row">
<div class="col-md-12">
<div class="block block_course_overview" style="margin:2px 2px 30px 2px;">

<h4> Learning  Objectives & Alignment</h4>
<div>
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

</div> <!-- ./ main -->
</div> <!-- ./ container-fluid -->




</body>
</html>
