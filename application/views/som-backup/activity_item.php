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
<body role="document">
<!--    
<pre>

<?php print_r($item); ?>

</pre>

<pre>

<?php print_r($los); ?>

</pre>
  -->
<div class="jumbotron">
<div class="container-fluid"><img src="<?php echo base_url() . 'resource/som/';?>images/flinders_logo.png" width="151" height="65" alt="Flinders University"></div>
</div>

<div class="container-fluid" style="margin:0 20px 0 20px;">
<div role="main">


<!--  page-header   -->
<div class="page-header">
<h2>Flinders University MD Curriculum Framework - Pilot v.1</h2>
</div>
<!--  end page-header   -->
<?php if ($_SERVER['REMOTE_ADDR'] == '10.26.21.73') { ?>
<!--
<pre>
<?php print_r($item); ?>
</pre>
-->
<?php } ?>

<div class="row" style="margin-bottom:1em;">
<div class="col-lg-10">
<h3>Activity :: <?php echo $item['itemTitle']; ?></h3>
</div>
<div class="col-lg-2 pull-right"><a href="https://flex.flinders.edu.au/items/<?php echo $item['thisUUID']; ?>/<?php echo $item['thisVersion']; ?>" target="_blank" class="btn btn-danger pull-right"><i class="fa fa-edit"></i> Edit this item</a></div>
</div>



<div class="row">
<div class="col-md-7">
<h4>Description</h4>
<?php echo $item['itemDescription']; ?>

<?php if($item['preInstructions'] != '' OR $item['duringInstructions'] != '' OR $item['postInstructions'] != '') { ?>
<h4>Instructions</h4>



<div class="panel-group" id="accordion">
  <?php if($item['preInstructions'] != '') { ?>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h5 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          Before you start
        </a>
      </h5>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
      <div class="panel-body">
<?php echo $item['preInstructions']; ?>
      </div>
    </div>
  </div>
 <?php } ?>
 
 
 
 
   <?php if($item['duringInstructions'] != '') { ?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">During the activity</a>
      </h5>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
<?php echo $item['duringInstructions']; ?>
      </div>
    </div>
  </div>
<?php } ?>
  <?php if($item['postInstructions'] != '') { ?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
          Collapsible Group Item #3
        </a>
      </h5>
    </div>
    <div id="collapseThree" class="panel-collapse collapse">
      <div class="panel-body">
<?php echo $item['postInstructions']; ?>.
      </div>
    </div>
  </div>

    <?php } ?>
 


 
</div>


  <?php } ?>


<h4> Learning Outcomes</h4>
<?php if (intval(trim($los['numberApplicable'])) > 0) { ?>
<p>There are <?php echo $los['numberLOs']; ?> Learning Outcomes for the parent item <em><?php echo $item['parentTopic']; ?></em> of which the following <?php if (intval(trim($los['numberApplicable'])) == 1) { ?>outcome<?php } else { ?><?php echo $los['numberApplicable']; ?> outcomes<?php } ?> apply to this activity.
<dl class="dl-horizontal">
<?php foreach ($los['los'] as $lo) { ?>
<dt><?php echo $lo['code']; ?></dt>
<dd><?php echo $lo['name']; ?></dd>
<?php } ?>
</dl>
<?php } else { ?>
<p>This activity has not been aligned to the parent item learning outcomes</p>

<?php } ?>

</div>


<div class="col-md-5">
<div class="panel panel-default">
  <div class="panel-heading">
    <h5 class="panel-title">Parent Topic</h5>
  </div>
  <div class="panel-body">
 <p><a href="/flex/som/summary/<?php echo $item['topicUUID']; ?>/1" class="standard" ><?php echo $item['topicName']; ?></a></p>
  </div>
  <?php if ($item['thisUUID'] != $item['parentUUID']) { ?>
    <div class="panel-heading">
      <h5 class="panel-title">Parent Item</h5>
    </div>
    <div class="panel-body">
<p><a href="/flex/som/lta/<?php echo $item['parentUUID']; ?>/1/<?php echo $item['itemTopic']; ?>" class="standard" ><?php echo $item['parentTopic']; ?></a></p>
</div>
<?php } ?>
</div>
 <?php if ($item['thisUUID'] != $item['parentUUID']) { ?>
<div class="panel panel-default">
    <div class="panel-heading">
      <h5 class="panel-title">Related Activities</h5>
    </div>
    <div class="panel-body">
<ul class="list-unstyled">
<?php foreach ($item['relatedItem'] as $related) { ?>

<li><i class="fa fa-chevron-circle-right"  style="color:#d9534f; <?php if ($related['itemUuid'] != $item['thisUUID']) { ?> visibility:hidden;  <?php } ?>"></i>
<a href="/flex/som/activity/<?php echo $related['itemUuid']; ?>/<?php echo $related['itemVersion']; ?>/<?php echo $item['parentUUID']; ?>" class="standard"><?php echo $related['title']; ?></a> </li>

<?php } ?>
</ul>
</div>
<?php } ?>
</div>
<!--
<div class="well">
<h5>Parent Topic</h5>
<p><a href="/flex/som/summary/<?php echo $item['topicUUID']; ?>/1" class="standard" ><?php echo $item['topicName']; ?></a></p>
<h5>Parent Item</h5>
<p><a href="/flex/som/lta/<?php echo $item['parentUUID']; ?>/1/<?php echo $item['itemTopic']; ?>" class="standard" ><?php echo $item['parentTopic']; ?></a></p>
</div>
<div class="well">
<h5>Related Activities</h5>
<ul class="list-unstyled">
<?php foreach ($item['relatedItem'] as $related) { ?>

<li><i class="fa fa-chevron-circle-right"  style="color:#d9534f; <?php if ($related['itemUuid'] != $item['thisUUID']) { ?> visibility:hidden;  <?php } ?>"></i>
<a href="/flex/som/activity/<?php echo $related['itemUuid']; ?>/<?php echo $related['itemVersion']; ?>/<?php echo $item['parentUUID']; ?>" class="standard"><?php echo $related['title']; ?></a> </li>

<?php } ?>
</ul>


</div>

-->



</div> <!--  end role="main"   -->
</div> <!--  end container-fluid   -->

</body>
</html>
