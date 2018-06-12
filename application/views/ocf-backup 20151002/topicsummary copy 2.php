<?php include_once('includes/language.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title><?php echo $title; ?>::Topic Summary - <?php echo $topics['tcode'];?></title>
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
</head>
<body role="document">
<!-- Modal -->
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
<div class="container-fluid"><img src="<?php echo base_url() . 'resource/ocf/';?>images/flinders_logo.png" width="151" height="65" alt="Flinders University"></div>
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
    <div class="page-header">

      <h2>Flinders University <?php echo strtoupper($topics['courseCode']); ?> Curriculum Framework - Pilot v.1</h2>
    
    </div>
    <div class="row">
<div id="myNav" class="span10">


<div id="myNav" class="span10"><a href="<?php echo base_url() . 'ocf/home/' . $courses['code'] ?>" class="btn btn-sm btn-primary">Return to dashboard</a>&nbsp;&nbsp;<a href="/flex/ocf/<?php echo strtolower($courses['code']) ; ?>/fmgo" class="btn btn-sm btn-success"  data-toggle="tooltip" data-placement="top" title="<?php echo $coursestringlong; ?>"><?php echo $coursestring; ?></a>&nbsp;&nbsp;<a href="/flex/ocf/<?php echo strtolower($courses['code']) ; ?>/amcgo" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="<?php echo $profstringlong; ?>"><?php echo $profstring; ?></a></div>


<?php 
$sam_title = 'N/A';
if(isset($topics['sam_name']))
{
	$sam_title = $topics['sam_name'];
}

$taa_title = 'N/A';
if(isset($topics['taa_name']))
{
	$taa_title = $topics['taa_name'];
}
?>
<h3>Topic Summary :: <span class = "instruction" data-toggle="tooltip" data-placement="top" data-html="true" title="<?php  echo 'SAM: ' . $sam_title .'<br/>' . ' TAA: ' . $taa_title;?> "> <?php echo $topics['tcode'];?> <?php echo $topics['topicTitle'];?></span></h3>
</div>
 


<div class="span10">
<a href="/flex/ocf/<?php echo strtolower($topics['courseCode']); ?>/topic/<?php echo $topics['itemID'];?>/1" class="btn btn-xs btn-default"><i class="fa fa-file-text-o"></i>&nbsp;View Topic Outcome Report</a>
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
	foreach ($sam['sam']['coord'] as $coord) 
	{ ?>
		<li><?php echo $coord['name'];?></li>
	<?php }
}
else
{
	echo "<li>N/A</li>";
} ?>
</ul>

</div>

<div class="row">
<div class="col-md-4">
<h4> Learning & Teaching Activities</h4>
<ul class="fa-ul">
<?php foreach ($taa['activities'] as $activity) { ?>
<?php if ($activity['activityType'] == 'group') { ?>
	<li> 
        <i class="instruction fa-li fa fa-files-o" data-toggle="tooltip" data-placement="top" data-html="true" title="Activity group"></i>&nbsp;
    	<a href="/flex/ocf/ltats/<?php echo $activity['itemUuid']; ?>/<?php echo $activity['itemVersion']; ?>/<?php echo $topics['tcode']; ?>" target="_blank"><?php echo $activity['itemTitle']; ?></a>  
   </li>
<?php } else { ?>
<li>
	
    	<i class="instruction fa-li fa fa-file-o" data-toggle="tooltip" data-placement="top" data-html="true" title="Activity"></i> &nbsp;
		<a href="/flex/ocf/activityts/<?php echo $activity['itemUuid']; ?>/<?php echo $activity['itemVersion']; ?>/<?php echo $activity['itemUuid']; ?>"  data-toggle="modal" data-target="#myModal"  ><?php echo $activity['itemTitle']; ?></a> 
   
</li>
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


<div class="col-md-5">

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







</div>

</div>

</div>

</div>



</body>
</html>
