<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<?php /*?><link rel="shortcut icon" href="../../assets/ico/favicon.ico"><?php */?>
<title>School of Medicine Curriculum Framework::Course Overview - Flinders Medical Graduate Outcomes</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/bootstrap-theme.min.css">


<!-- Local styles -->

<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/local.css">


<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->



<!-- Latest compiled and minified JavaScript -->



<script type="text/javascript" src="<?php echo base_url() . 'resource/ocf/';?>js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'resource/ocf/';?>js/jquery-ui-1.10.3.custom.min.js"></script>

<script src="<?php echo base_url() . 'resource/ocf/';?>js/bootstrap.min.js"></script>   
    
<link href="<?php echo base_url() . 'resource/ocf/';?>css/font-awesome-4.2.0/css/font-awesome.css" rel="stylesheet" type="text/css">


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
<body role="document">
<!--  
<pre>

<?php print_r($item); ?>

</pre>
 -->
<div class="jumbotron">
<div class="container-fluid"><img src="<?php echo base_url() . 'resource/ocf/';?>images/flinders_logo.png" width="151" height="65" alt="Flinders University"></div>
</div>


<div class="container-fluid" style="margin:0 20px 0 20px;">

  <div role="main">
    <div class="page-header">
      <h2>Flinders University MD Curriculum Framework</h2>
    </div>
    <!--
    <div class="row">
<div id="myNav" class="span10"><a href="/flex/ocf/startup" class="btn btn-sm btn-primary">Return to dashboard</a>&nbsp;&nbsp;&nbsp;&nbsp;</div>
</div>
-->
 <div class="row" style="margin-bottom:1em;">
<div class="col-lg-10">
<h3>Activity Group :: <?php echo $item['itemTitle']; ?></h3>
</div>
<div class="col-lg-2 pull-right"><a href="https://flex.flinders.edu.au/items/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>" target="_blank" class="btn btn-danger pull-right"><i class="fa fa-edit"></i> Edit this item</a></div>
</div>


<div class="row">

<h4>Parent Topic</h4>
<p><a href="/flex/ocf/summary/<?php echo $item['topicUUID']; ?>/1" class="standard" ><?php echo $item['topicName']; ?></a></p>
<h4>Description</h4>
<?php echo $item['itemDescription']; ?>

</div>
<div class="row">

<div class="col-md-4">

<h4> Learning & Teaching Activities</h4>
<ul>
<?php foreach ($item['activities'] as $activity) { ?>
<li><a href="/flex/ocf/activity/<?php echo $activity['link']; ?>/<?php echo $activity['version']; ?>/<?php echo $item['thisUuid']; ?>" class="standard" ><?php echo $activity['name']; ?></a></li>
<?php } ?>
</ul>

</div>
<div class="col-md-7">


<h4> Learning Outcomes</h4>
<dl class="dl-horizontal">

<?php if ($item['los']['numLOs'] > 0 ) { ?>
<?php foreach ($item['los'] as $lo) { ?>
<dt><?php echo $lo['code']; ?></dt>
<dd><?php echo $lo['name']; ?></dd>
<?php } ?>
<?php } else { ?>

<dt>Note</dt>
<dd>Learning objectives not defined for this activity</dd>
<?php } ?>
</dl>


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
