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


<div class="jumbotron">
<div class="container-fluid"><img src="<?php echo base_url() . 'resource/som/';?>images/flinders_logo.png" width="151" height="65" alt="Flinders University"></div>
</div>


	<?php	if ($_SERVER['REMOTE_ADDR'] == '10.26.21.73') {
	
/*
		echo "<h2>TAA data</h2>";
			
		echo "<pre>";
      	print_r($taa);
		echo "</pre>";
		


*/
		
	   
	    //
		
		}  ?>
        
        

		
<div class="container-fluid" style="margin:0 20px 0 20px;">

  <div role="main">
    <div class="page-header">
      <h2>Flinders University MD Curriculum Framework - Pilot v.1</h2>
    </div>
    <div class="row">
<div id="myNav" class="span10"><a href="/flex/som/startup" class="btn btn-sm btn-primary">Return to dashboard</a>&nbsp;&nbsp;<a href="/flex/som/fmgo" class="btn btn-sm btn-success">Flinders Medical Graduate Outcomes</a>&nbsp;&nbsp;<a href="/flex/som/amcgo" class="btn btn-sm btn-success">AMC Graduate Outcomes</a></div>
<h3>Topic Summary :: <?php echo $topics['tcode'];?> <?php echo $topics['topicTitle'];?> (v2)</h3>


</div>
 


<div class="span10">
<a href="/flex/som/topic/<?php echo $topics['itemID'];?>/1" class="btn btn-xs btn-default"><i class="fa fa-file-text-o"></i>&nbsp;View Topic Outcome Report</a>
<!--
<h4>Topic Description</h4>
<p><?php echo $topics['description'];?> </p>
-->
</div>

<div class="row">

<h4> Coordinator</h4>
<ul>
<?php 
if(isset($sam['sam']['coord']) && count($sam['sam']['coord'])>0)
{
foreach ($sam['sam']['coord'] as $coord) { ?>
<li><?php echo $coord['name'];?></li>
<?php }} ?>
</ul>

</div>

<div class="row">
<div class="col-md-3">
<h4> Learning & Teaching Activities</h4>
<ul>
<?php foreach ($taa['activities'] as $activity) { ?>
<?php if ($activity['activityType'] == 'group') { ?>
<li><a href="/flex/som/lta/<?php echo $activity['itemUuid']; ?>/<?php echo $activity['itemVersion']; ?>/<?php echo $topics['tcode']; ?>" class="standard"><?php echo $activity['itemTitle']; ?></a></li>
<?php } else { ?>
<li><a href="/flex/som/activity/<?php echo $activity['itemUuid']; ?>/<?php echo $activity['itemVersion']; ?>/<?php echo $activity['itemUuid']; ?>" class="standard"><?php echo $activity['itemTitle']; ?></a></li>
<?php } ?>
<?php } // end activities ?>
</ul>



</div>

<div class="col-md-3">
<h4>Assessment Items</h4>

<ol>
<?php 
if(isset($sam['sam']['assessment']) && count($sam['sam']['assessment'])>0)
{
	foreach ($sam['sam']['assessment'] as $assessment) { ?>
<li><?php echo $assessment['name']; ?></li>

<?php }}  ?>
</ol>
</div>


<div class="col-md-6">

<h4> Learning Outcomes</h4>
<p><?php echo $topics['ocIntro'];?></p>

<dl class="dl-horizontal">
<!--<dl class="dl">-->
<?php foreach ($topics['topic']['los'] as $topicoutcome) { ?>

<dt><?php echo $topicoutcome['code']; ?></dt>

<dd><?php echo $topicoutcome['name']; ?></dd>

<?php } // end topicoutcomes ?>

</dl>





</div>





<!-- Modals -->


<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

</div>
</div>
</div>



<?php if ($_SERVER['REMOTE_ADDR'] == '129.96.68.25') { ?>
<!--
<div class="doNotPrint">
<h4>Topic Alignment</h4>
<pre>     


<?php print_r($topics); ?>

</pre>

-->
<?php } ?>
</div>

</div>

</div>

</div>



</body>
</html>
