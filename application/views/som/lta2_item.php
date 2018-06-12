<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="../../assets/ico/favicon.ico">
<title>School of Medicine Curriculum Framework::Course Overview - Flinders Medical Graduate Outcomes</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/som/';?>css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/som/';?>css/bootstrap-theme.min.css">


<!-- Local styles -->

<link rel="stylesheet" href="<?php echo base_url() . 'resource/som/';?>css/local.css">


<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->



<!-- Latest compiled and minified JavaScript -->



<script type="text/javascript" src="<?php echo base_url() . 'resource/som/';?>js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'resource/som/';?>js/jquery-ui-1.10.3.custom.min.js"></script>

<script src="<?php echo base_url() . 'resource/som/';?>js/bootstrap.min.js"></script>   
    
<link href="<?php echo base_url() . 'resource/som/';?>css/font-awesome-4.2.0/css/font-awesome.css" rel="stylesheet" type="text/css">


    <script type="text/javascript">

    $(document).ready(function(){

        $('.instruction').tooltip();


    });  

    </script>


<style type="text/css">
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




$(document).on("hidden.bs.modal", function (e) { $(e.target).removeData("bs.modal").find(".modal-content").empty(); });



</script>


</head>
<body role="document" style="margin-bottom:4em;">
<!--  
<pre>

<?php print_r($item); ?>

</pre>
 -->
<div class="jumbotron">
<div class="container-fluid"><img src="<?php echo base_url() . 'resource/som/';?>images/flinders_logo.png" width="151" height="65" alt="Flinders University"></div>
</div>


<div class="container-fluid" style="margin:0 20px 0 20px;">

  <div role="main">
    <div class="page-header">
      <h2>Flinders University MD Curriculum Framework - Pilot v.1</h2>
    </div>
    <!--
    <div class="row">
<div id="myNav" class="span10"><a href="/flex/som/startup" class="btn btn-sm btn-primary">Return to dashboard</a>&nbsp;&nbsp;&nbsp;&nbsp;</div>
</div>
-->
 <div class="row" style="margin-bottom:1em;">
<div class="col-md-10">
<h3><i class="fa fa-files-o fa-fw"></i> Activity Group :: <?php echo $item['itemTitle']; ?></h3>
</div>
<div class="col-md-2"><h3><a href="https://flex.flinders.edu.au/items/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>" target="_blank" class="btn btn-danger pull-right"><i class="fa fa-edit"></i> Edit this item</a></h3></div>
</div>


<div class="row" style="margin-bottom:2em;">
<div class="col-md-11">
<h4>Description</h4>
<?php echo $item['itemDescription']; ?>
</div>
</div>
<div class="row">
<div class="col-md-3">
<h4> Learning & Teaching Activities</h4>
<ul class="fa-ul">
<?php foreach ($item['activities'] as $activity) { ?>
<?php 
/*    */
switch ($activity['activityType']) {
	
	case 'group':
	
		$liclass = "fa-li fa fa-files-o";
		$link = "/flex/som/lta2/". $activity['itemUuid'] . "/" . $activity['itemVersion'] . "/" . $item['itemTopic'] . "/" . $item['thisUuid'] . "/" . $item['thisVersion'] . "/" . $item['depth'];	
		 
		break;
	
	case 'activity':
	
		$liclass = "fa-li fa fa-file-o";
		$link = "/flex/som/activity/". $activity['itemUuid'] . "/" . $activity['itemVersion'] . "/" . $item['thisUuid'] . "/" . $item['thisVersion']; 
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

<!-- <li><a href="/flex/som/<?php echo $linktype; ?>/<?php echo $activity['itemUUID']; ?>/<?php echo $activity['itemVersion']; ?>/<?php echo $item['thisUuid']; ?>" class="standard" ><?php echo $activity['itemTitle']; ?></a></li>-->

<li><i class="<?php echo $liclass; ?>"></i><a href="<?php echo $link; ?>" class="standard"><?php echo $activity['title']; ?></a> <?php echo $docondition; ?></li>

<?php } ?>
</ul>

</div>
<div class="col-md-5">

<h4> Learning Outcomes</h4>
<dl class="dl-horizontal">
<?php foreach ($item['los'] as $lo) { ?>
<dt><?php echo $lo['code']; ?></dt>
<dd><?php echo $lo['name']; ?></dd>
<?php } ?>
</dl>


</div>


<div class="col-md-4">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h5 class="panel-title">Parent Topic</h5>
    </div>
    <div class="panel-body">
      <p><a href="/flex/som/summary/<?php echo $item['topicUUID']; ?>/1" class="standard" ><?php echo $item['topicName']; ?></a></p>
    </div>
    </div>
    
    
    <?php if ($item['hasParent']) { ?>
    
         <div class="panel panel-primary">

    <div class="panel-heading">
      <h5 class="panel-title">Parent Item</h5>
    </div>
    <div class="panel-body">
<ul class="fa-ul">
<li><i class=" fa-li fa fa-files-o"></i><a href="/flex/som/lta2/<?php echo $item['parentItem']; ?>/<?php echo $item['parentVersion']; ?>/<?php echo $item['itemTopic']; ?>"><?php if ($item['depth'] > 1) { ?>/<?php echo $item['parentName']; ?></a></li>
</ul>
    </div>
   
  </div> 
    
     <?php } ?>

</div>


</div>






</div>







<!-- Modals -->


<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

</div>
</div>
</div>








</div>

</div>



</body>
</html>
