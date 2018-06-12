 <?php include_once('includes/language.php'); ?>
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


$typesofteaching = array(
	'Presentation' => 'Presentation / lecture',
	'Interactive large group' => 'Interactive large group / seminar /workshop / review session',
	'Facilitated small group' => 'Facilitated small group ‘discussion’ / tutorial',
	'Practical' => 'Practical / laboratory / clinical skill simulation',
	'Individual self-directed' => 'Individual self-directed / self-paced',
	'Work-based environment' => 'Work-based environment / placement ',
	'Other' => 'Other / unsure'
	);

$thetype = $item['teachingType'];
?>


<?php 

/*  ---------------------   
if ($fan == 'couc0005') {
	
	
	echo "<pre>";
	print_r($item);
	echo "</pre>";
	
	
}

*/




?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Activity::<?php echo $item['itemTitle']; ?></title>
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
    <div class="col-md-9 col-sm-12 col-xs-12"><img src="https://cal4.flinders.edu.au/flextra/flinders_logo.png"  alt="Flinders University" width="151" height="65" style="float:left;">
      <div class="banner-text">
    
        <p>
		  You are logged in via FLO as <?php echo $_SESSION['userinfo']['name']; ?><br />
          Access level: <?php echo $_SESSION['userinfo']['role']; ?><br />
	    Current OCF: <?php echo $item['itemOCFid']; ?>
		  </p>
		  
		  
      </div>
    </div>
   
  </div>
</div>
        
   

<div class="container-fluid" style="margin:0 20px 0 20px;">
  <div role="main">
    <div class="row">
      <h3><span style="line-height:130%;">Activity Detail: <?php echo $item['itemTitle']; ?></span></h3>
<small><span  class="text-uppercase">Teaching type: <strong><span class="text-success"><?php echo $thetype; ?></span></strong></span></small>
    
    
    
    <div class="block" style="margin-bottom:0.5em;">


<?php echo $item['itemDescription']; ?>

</div>
  
<div class="block" style="margin-bottom:0.5em;">


<?php if (!(empty($item['overall']))) { ?> 




<h5>Activity Information & Resources</h5>
 <?php if (!(empty($item['overall']['instructions']))) { ?>
<div class="col-md-6">
<p><span style="margin-right: 2em;"><strong>Information</strong></span></p>
  <ul class="fa-ul">
  <?php
	  
	switch ($item['overall']['instructions']['type']) {
	
	
case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';
		$resourceserver = '/flex/flo-ocf/loadpageflo';
		break;
	default:
		$resourceclass = '';
		break;
}
	 
	  ?>
      <li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo urlencode(base64_encode($item['overall']['instructions']['filename'])); ?>" target="_blank"><?php echo $item['overall']['instructions']['description']; ?></a></li>  
    </ul>
</div>
<?php } // overall instructions not empty ?>

  <?php if (!(empty($item['overall']['linked']))) { ?>
<div class="col-md-6">
<p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
    <ul class="fa-ul">
    <?php foreach ($item['overall']['linked'] as $olinked) { ?>
      <?php
	  
	  
	switch ($olinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		//$linktype = 'file';
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$olinked['uuid'] ;
		$resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
		//$linkclass = 'class="generateToken"';
		$href = $resourceserver.$linkuse ;
		
		break;
		
	case 'linked-resource': 
	
	
		if($item['pblCase']) { 
		
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = '';	
		$linkuse =  $olinked['itemUuid'] . '/' . $olinked['itemVersion'];
		$resourceserver = '/flex/flo-ocf/caseview/';
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
	
		
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . urlencode(base64_encode($olinked['filename']));
	
		$resourceserver = '/flex/flo-ocf/loadpageflo/';
		$linkclass = '';
		
		$href = $resourceserver.$linktype.$linkuse ;
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
 <?php } // overall linked not empty ?>
    
  <div class="clear"></div>
    <?php } // overall not empty ?>



<?php if($item['pblCase'] == "False") { ?>  
  <?php if (!(empty($activity_los))) { ?>
<div>


<h5>Session Learning Objectives</h5>

<dl class="dl-horizontal">
<?php foreach ($activity_los as $activitylo) { ?>
<dt><?php echo $activitylo['code']; ?></dt>
<dd><?php echo $activitylo['name']; ?></dd>
<?php } ?>
</dl>

</div>   <!-- / col-md-12 --> 
<?php }  //  lo not empty   ?>

<?php }  //  not a PBL case ?>



<?php if($item['pblCase'] == "True"  && $item['itemTopic'] == "MMED8302") { ?>  
  <?php if (!(empty($activity_los))) { ?>
<div>


<h5>Case Learning Objectives</h5>

<dl class="dl-horizontal">
<?php foreach ($activity_los as $activitylo) { ?>
<dt><?php echo $activitylo['code']; ?></dt>
<dd><?php echo $activitylo['name']; ?></dd>
<?php } ?>
</dl>

</div>   <!-- / col-md-12 --> 
<?php }  //  lo not empty   ?>

<?php }  //  item is a Year 3 a PBL case ?>


 <?php if (!(empty($item['pre']))) { ?>
 <h5>Pre-Activity</h5>
 <?php if (!(empty($item['pre']['instructions']))) { ?>

<?php if (empty($item['pre']['linked'])) { ?>    
<div class="col-md-12">
<?php } else { ?>
<div class="col-md-6">
<?php } ?>

  <ul class="fa-ul">
  <?php
	  
	switch ($item['pre']['instructions']['type']) {
	
	case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		
		if($item['pre']['instructions']['resourceType'] == 'a') {
			$theUuid = $item['pre']['instructions']['itemUuid'];
		} else {
			$theUuid = $item['thisUuid'];
		}
			
		$resourceserver = '/flex/flo-ocf/loadpageflo';
		break;
	default:
		$resourceclass = '';
		break;
	
} 
	  ?>

      <li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $theUuid; ?>/<?php echo $item['thisVersion']; ?>/<?php echo urlencode(base64_encode($item['pre']['instructions']['filename'])); ?>" target="_blank"><?php echo $item['pre']['instructions']['description']; ?></a></li>     
    </ul>
</div>
<?php } ?>

     <?php if (!(empty($item['pre']['linked']))) { ?>
<div class="col-md-6">    
    <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
    <ul class="fa-ul">
   <?php foreach ($item['pre']['linked'] as $prelinked) { ?>
      <?php
	  
	  
	switch ($prelinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		//$linktype = 'file';
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$prelinked['uuid'] ;
		$resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
		
		//$linkclass = 'class="generateToken"';
		$href = $resourceserver.$linkuse ;
		
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
	
		if($prelinked['resourceType'] == 'a') {
			$linkuse = '/' . $prelinked['itemUuid'] . '/' . $prelinked['itemVersion'] . '/' . urlencode(base64_encode($prelinked['filename']));
		} else {
			$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . urlencode(base64_encode($prelinked['filename']));
		}
			
		
	
		$resourceserver = '/flex/flo-ocf/loadpageflo/';
		$linkclass = '';
		
		$href = $resourceserver.$linktype.$linkuse ;
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

    <li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" <?php echo $linkclass; ?>><?php echo $prelinked['description']; ?></a></li>
      <?php } ?>   
    
    <?php } ?>
    </ul>   
 </div>  
 
 <?php } ?> 


    
  <div class="clear"></div>
  
   <?php } // pre not empty ?>



<?php if (!(empty($item['during']))) { ?>
<h5>During Activity</h5>
    <?php if (!(empty($item['during']['instructions']))) { ?>
    
  
<div class="col-md-12">

<ul class="fa-ul">
      <?php
	switch ($item['during']['instructions']['type']) {
	
	case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$resourceserver = '/flex/flo-ocf/loadpageflo';
		
		if($item['during']['instructions']['resourceType'] == 'a') {
			$theUuid = $item['during']['instructions']['itemUuid'];
		} else {
			$theUuid = $item['thisUuid'];
		}
		
		
		break;
	default:
		$resourceclass = '';
		break;
	
}
	
	 
	  ?>

<li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $theUuid; ?>/<?php echo $item['thisVersion']; ?>/<?php echo urlencode(base64_encode($item['during']['instructions']['filename'])); ?>" target="_blank"><?php echo $item['during']['instructions']['description']; ?></a></li>      
       
     </ul>
</div>
<?php } ?>

<?php if (!(empty($item['during']['linked']))) { ?>
<div class="col-md-12">     
   <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
     <ul class="fa-ul">
      <?php foreach ($item['during']['linked'] as $dlinked) { ?>
      <?php
	  
	  
	switch ($dlinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		//$linktype = 'file';
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$dlinked['uuid'] ;
		$resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
		//$linkclass = 'class="generateToken"';
		$href = $resourceserver.$linkuse ;
		
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
		
		
		if($dlinked['resourceType'] == 'a') {
			$linkuse = '/' . $dlinked['itemUuid'] . '/' . $dlinked['itemVersion'] . '/' . urlencode(base64_encode($dlinked['filename']));
		} else {
			$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . urlencode(base64_encode($dlinked['filename']));
		}
			
	
	
	
		$resourceserver = '/flex/flo-ocf/loadpage/';
		$linkclass = '';
		
		$href = $resourceserver.$linktype.$linkuse ;
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

    <li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" <?php echo $linkclass; ?>><?php echo $dlinked['description']; ?></a></li>
      <?php } ?>
    
       <?php } ?>
     </ul>  
 </div>
 <?php } ?>   

 
    
  <div class="clear"></div>
  
   <?php } ?>


<?php if (!(empty($item['post']))) { ?>
<h5>Post-Activity</h5>
 
<?php if (!(empty($item['post']['instructions']))) { ?>
<?php if (empty($item['post']['linked'])) { ?>    
<div class="col-md-12">
<?php } else { ?>
<div class="col-md-6">
<?php } ?>
<ul class="fa-ul">
    <?php
	  
	  
	switch ($item['post']['instructions']['type']) {
	
	case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$resourceserver = '/flex/flo-ocf/loadpageflo';
		
		if($item['post']['instructions']['resourceType'] == 'a') {
			$theUuid = $item['post']['instructions']['itemUuid'];
		} else {
			$theUuid = $item['thisUuid'];
		}
		
		
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
<li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $theUuid; ?>/<?php echo $item['thisVersion']; ?>/<?php echo urlencode(base64_encode($item['post']['instructions']['filename'])); ?>" target="_blank"><?php echo $item['post']['instructions']['description']; ?></a></li>   
       
     </ul>
</div>
 
 <?php } ?>
 
 

 
<?php if (!(empty($item['post']['linked']))) { ?>
<?php if (empty($item['post']['instructions'])) { ?>    
<div class="col-md-12">
<?php } else { ?>
<div class="col-md-6">
<?php } ?>  
 <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
     <ul class="fa-ul">
    <?php foreach ($item['post']['linked'] as $plinked) { ?>
      <?php
	  
	  
	switch ($plinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		//$linktype = 'file';
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$plinked['uuid'] ;
		$resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
		//$linkclass = 'class="generateToken"';
		$href = $resourceserver.$linkuse ;
		
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
		
		
		if($plinked['resourceType'] == 'a') {
			$linkuse = '/' . $plinked['itemUuid'] . '/' . $plinked['itemVersion'] . '/' . urlencode(base64_encode($plinked['filename']));
		} else {
			$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . urlencode(base64_encode($plinked['filename']));
		}
			
	
	
	
		$resourceserver = '/flex/flo-ocf/loadpageflo/';
		$linkclass = '';
		
		$href = $resourceserver.$linktype.$linkuse ;
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

    <li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" <?php echo $linkclass; ?>><?php echo $plinked['description']; ?></a></li>
      <?php } ?>
           <?php } ?>
     </ul> 

<div class="clear"></div>
  
   <?php } ?>

 <?php } ?>



<div class="clear"></div>


	
	<?php 
if (!(empty($item['teachingTeam'])))
{
	$flag = false;
	if(isset($_SESSION['ocf_topic_codes']) && isset($_SESSION['flo_ocf_role']))
	{
		if($_SESSION['flo_ocf_role'] == 'Instructor')
		{
			if(isset($_SESSION['ocf_topic_codes']['enrolled']) && count($_SESSION['ocf_topic_codes']['enrolled'])>0)
			{
				foreach($_SESSION['ocf_topic_codes']['enrolled'] as $topic_code)
				{
					if($item['itemTopic'] === $topic_code)
					{
						$flag = true;
						break;
					}
				}
			}
			
			if(isset($_SESSION['ocf_topic_codes']['other']) && count($_SESSION['ocf_topic_codes']['other'])>0)
			{
				foreach($_SESSION['ocf_topic_codes']['other'] as $topic_code)
				{
					if($item['itemTopic'] === $topic_code)
					{
						$flag = true;
						break;
					}
				}
			}
		}
		
	}
 	if($flag) { ?>
		<div class="alert alert-danger" role="alert">
			<h5 class="text-danger">Teaching Team</h5>
            <!-- teaching team instructions -->
            <?php if (!(empty($item['teachingTeam']['instructions']))) { ?>
	
                <div class="col-md-12">
          
                    <ul class="fa-ul">
                        <?php
                      if(isset($item['teachingTeam']['instructions']['type']))
                      {
                          $resourceclass = '';
                          $href = '';
                          $desc = '';
                          $resourceserver = '';
                            switch ($item['teachingTeam']['instructions']['type']) 
                            {
                                case 'htmlpage':
                                    $resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
                                    $linktype = 'file';
                                    $resourceserver = '/flex/flo-ocf/loadpageflo/file';
                                    
                                    if(isset($item['teachingTeam']['instructions']['resourceType']) && $item['teachingTeam']['instructions']['resourceType'] == 'a') {
                                        $theUuid = $item['teachingTeam']['instructions']['itemUuid'];
                                        $theVersion = $item['teachingTeam']['instructions']['itemVersion'];
                                    } 
                                    else {
                                        $theUuid = $item['thisUuid'];
                                        $theVersion = $item['thisVersion'];
                                    }
                                    
                                    $linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($item['teachingTeam']['instructions']['filename']));
                                    
                                    
                                    $href = $resourceserver.$linkuse ;
                                    $desc = $item['teachingTeam']['instructions']['description'];
                                    
                                    break;
                                    
                                case 'linked-resource':
                                    if(isset($item['teachingTeam']['instructions']['linked_resources']))
                                    {
                                        foreach($item['teachingTeam']['instructions']['linked_resources'] as $rlink)
                                        {
                                            if(isset($rlink['type']))
                                            {
                                                switch($rlink['type'])
                                                {
                                                    case 'htmlpage':
                                                        $resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
                                                        $linktype = 'file';
                                                        $resourceserver = '/flex/flo-ocf/loadpageflo/file';
                                                        
                                                        if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
                                                        {
                                                            $theUuid = $rlink['itemUuid'];
                                                            $theVersion = $rlink['itemVersion'];
                                                        } 
                                                        else {
                                                            $theUuid = $item['thisUuid'];
                                                            $theVersion = $item['thisVersion'];
                                                        }
                                                        
                                                        $linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($rlink['filename']));
                                                        
                                                        $href = $resourceserver.$linkuse;
                                                        
                                                    break;	
                                                    case 'file':
                                                        $resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
														$linkuse = '';
														if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
														{
															//$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['uuid']; 
															$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$item['teachingTeam']['instructions']['uuid']; 
														} 
														else 
														{
															$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$item['teachingTeam']['instructions']['uuid']; 
														}
														
														
														$resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
														$href = $resourceserver.$linkuse ;
            
                                                    break;
                                                }
                                                $desc = $rlink['description'];
                                            }
                                        }
                                    }
                                    elseif(isset($item['teachingTeam']['instructions']['resourceType']) && $item['teachingTeam']['instructions']['resourceType'] == 'p') //link to a shared resource summary page
                                    {
                                        $resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
                                        if(isset($item['teachingTeam']['instructions']['pbl']) && $item['teachingTeam']['instructions']['pbl'] == 'True') 
                                        {
                                            $linkuse =  $item['teachingTeam']['instructions']['itemUuid'] . '/' . $item['teachingTeam']['instructions']['itemVersion'];
                                            $resourceserver = '/flex/flo-ocf/caseview/';
                                            $href = $resourceserver.$linkuse ;
                                            $desc = 'Case Page: '. $item['teachingTeam']['instructions']['description'];
                                        }
                                        else
                                        {
                                            $theUuid = $item['teachingTeam']['instructions']['itemUuid'];
                                            $theVersion = $item['teachingTeam']['instructions']['itemVersion'];
                                            $resourceserver = '/flex/flo-ocf/generatetoken/viewSummaryPage';
											$linkuse = '/items/' . $theUuid . '/' . $theVersion . '/';
											$href = $resourceserver.$linkuse ;
                                            $desc = $item['teachingTeam']['instructions']['description'];
                                        }
                                    }
                                break;
                                    
                                default:
                                        $resourceclass = '';
                                        break;
                            }
							
							if(isset($item['teachingTeam']['instructions']['pbl']) && $item['teachingTeam']['instructions']['pbl'] == 'True') 
							{
								$desc = 'Case page: '.$desc;
								
								if(isset($item['hideLink']) && $item['hideLink']=='1')
								{
									$desc = $desc . ' (Link will be activated after completion of case)';
									?>
									<li><?php echo $resourceclass; ?><?php echo $desc; ?></a></li> 
							   <?php	
								}
								else
								{?>
									<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" class="alert-link"><?php echo $desc; ?></a></li> 
								<?php }
							}
							else
							{?>
								<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" class="alert-link"><?php echo $desc; ?></a></li> 
						<?php } ?>
                <?php }  ?>  
                    </ul>
         		</div>
 			<?php } ?> <!-- ./teaching team instructions -->

            <!-- teaching team linked resources -->
            <?php if (!(empty($item['teachingTeam']['linked']))) { ?>
		
                <div class="col-md-12">
      
                     <ul class="fa-ul">
                     	<?php foreach($item['teachingTeam']['linked'] as $rlink)
						{
							$resourceclass = '';
							$href = '';
							$desc = '';
							$resourceserver = '';
							
							switch($rlink['type'])
							{
								case 'linked-resource':  //linked to item summary page
									if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'p')
									{
										$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
										if(isset($rlink['pbl']) && $rlink['pbl'] == 'True') 
										{
											$linkuse =  $rlink['itemUuid'] . '/' . $rlink['itemVersion'];
											$resourceserver = '/flex/flo-ocf/caseview/';
											$href = $resourceserver.$linkuse ;
										}
										else
										{
											$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
											$resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
											$href = $resourceserver.$linkuse;
										}
									}
									
								break;
								
								case 'htmlpage':
									// link to a shared resource attachment and the attachment type is webpage
									$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
									$linktype = 'file';
									$resourceserver = '/flex/flo-ocf/loadpageflo/file';
									$theUuid = '';
									$theVersion = '';
									if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a')
									{
										$theUuid = $rlink['itemUuid'];
										$theVersion = $rlink['itemVersion'];
									}
									else //a webpage attachment attched
									{
										$theUuid = $item['thisUuid'];
										$theVersion = $item['thisVersion'];
									}
									$linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($rlink['filename']));
									$href = $resourceserver.$linkuse;
								
								break;
								
								case 'file':
									$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
									$linkuse = '';
									if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a')
									{
										$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['filename']; 
										//$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
									} 
									else 
									{
										$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
									}
									
									
									$resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
									$href = $resourceserver.$linkuse ;
				
								break;
								
								case 'url';
									$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
									$href = $rlink['url'];	
								break;
							}
							$desc = isset($rlink['description'])?$rlink['description']:'To be added';
							if(isset($rlink['pbl']) && $rlink['pbl'] == 'True') 
							{
								$desc = 'Case page: '.$desc;
								
								if(isset($item['hideLink']) && $item['hideLink']=='1')
								{
									$desc = $desc . ' (Link will be activated after completion of case)';
									?>
									<li><?php echo $resourceclass; ?><?php echo $desc; ?></a></li> 
							   <?php	
								}
								else
								{?>
									<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" class="alert-link"><?php echo $desc; ?></a></li> 
								<?php }
							}
							else
							{?>
								<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" class="alert-link"><?php echo $desc; ?></a></li> 
						<?php } 
						 }?>
                     </ul> 
                 </div> 
	 		<?php } ?>  <!-- ./teaching team linked resources -->
         <div class="clearfix"></div>
		</div>
		<div class="clear"></div>
     <?php } //end of flag?
 } //end of teachingTeam empty?>
<div class="clear"></div>
  
</div> <!-- ./ class=block (resources) -->

</div> <!-- ./ row -->


</div> <!-- ./ main -->
</div> <!-- ./ container-fluid -->




</body>
</html>
