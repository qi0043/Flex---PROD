<?php include_once('includes/language.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title><?php echo $title; ?>::Topic Detail - <?php echo $topics['tcode'];?></title>
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




$(document).on("hidden.bs.modal", function (e) { $(e.target).removeData("bs.modal").find(".modal-content").empty(); });



</script>



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


<div class="jumbotron">
<div class="container-fluid"><img src="<?php echo base_url() . 'resource/ocf/';?>images/flinders_logo.png" width="151" height="65" alt="Flinders University"></div>
</div>


<div class="container-fluid" style="margin:0 20px 0 20px;">

  <div role="main">
    <div class="page-header">
      <h2>Flinders University <?php echo strtoupper($courses['code']); ?> Curriculum Framework - Pilot v.1</h2>
    </div>
    <div class="row">
    
    
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
<h3>Topic Detail :: <span class = "instruction" data-toggle="tooltip" data-placement="top" data-html="true" title="<?php  echo 'SAM: ' . $sam_title .'<br/>' . ' TAA: ' . $taa_title;?> "> <?php echo $topics['tcode'];?> <?php echo $topics['topicTitle'];?></span></h3>

<?php /*?><a href="/flex/ocf/fmgosearch/<?php echo strtolower($courseoutcome['code']);?>" class="btn btn-link instruction" style="padding:0;"  data-toggle="tooltip" data-placement="top" data-html="true" title="View report for this<br />Learning Outcome" ><?php echo $courseoutcome['catcode']; ?> - <?php echo $courseoutcome['code']; ?></a><?php */?>

</div>
 


<div class="span10">
<a href="/flex/ocf/<?php echo $courses['code']; ?>/summary/<?php echo $topics['itemID'];?>/1" class="btn btn-xs btn-default"><i class="fa fa-file-text-o"></i>&nbsp;View Topic Summary</a>
<!--
<h4>Topic Description</h4>
<p><?php echo $topics['description'];?> </p>
-->
<h4>Topic Learning Outcomes </h4>
<!--<p><?php echo $topics['ocIntro'];?></p>-->
<table class="table-bordered" style="margin-bottom:2em; width:96%;">
<thead>


<tr>
<th align="left" valign="top" style="padding:5px;" scope="col">&nbsp;</th>
<th align="left" valign="top" style="padding:5px;" scope="col">&nbsp;</th>
<th align="left" valign="top" style="padding:5px;" scope="col">Course</th>
<th align="left" valign="top" style="padding:5px;" scope="col">Professional</th>
<th align="left" valign="top" style="padding:5px;" scope="col">L&amp;T Activities</th>
<th align="left" valign="top" style="padding:5px;" scope="col">Assessment Items</th>

</tr>



</thead>




<tbody>



<?php foreach ($topics['topic']['los'] as $topicoutcome) { ?>
<?php if(isset($topicoutcome['code'])&& isset($topicoutcome['name'])){?>
<tr>
<td align="left" valign="top" style="padding:5px; width:3em;" scope="col"><?php echo $topicoutcome['code']; ?></td>
  <td align="left" valign="top" style="padding:5px; width: 30em;" scope="col"><?php echo $topicoutcome['name']; ?></td>
<td align="left" valign="top" style="padding:5px; width: 22em;" scope="col">
<?php } ?>

<?php if (isset($topicoutcome['course'])) { ?>
<?php foreach ($topicoutcome['course'] as $courseoutcome) { ?>


<a href="/flex/ocf/<?php echo $courses['code']; ?>/fmgosearch/<?php echo strtolower($courseoutcome['code']);?>" class="btn btn-link instruction" style="padding:0;"  data-toggle="tooltip" data-placement="top" data-html="true" title="View report for this Learning Outcome" ><?php echo $courseoutcome['catcode']; ?> - <?php echo $courseoutcome['code']; ?></a><!--<span style="margin-left: 1.5em;" class="instruction"  data-toggle="tooltip" data-placement="top" data-html="true" title="Click to view Learning Outcome statement" ><a class="btn btn-link doNotPrint" style="padding:0;"   data-toggle="modal" href="<?php echo base_url() . 'resource/ocf/';?>html/fmgo/<?php echo strtolower($courseoutcome['code']); ?>.html" data-target="#myModal" ><i class="fa fa-info-circle"></i></a></span>--><br />

<?php } // end courseoutcome ?>
<?php } // end isset($topicoutcome['course']) ?>

</td>
<td align="left" valign="top" style="padding:5px; width: 22em;" scope="col">
<?php if (isset($topicoutcome['prof'])) { ?>
<?php foreach ($topicoutcome['prof'] as $profoutcome) { ?>

<a href="/flex/ocf/<?php echo $courses['code']; ?>/amcgosearch/<?php echo strtolower($profoutcome['code']);?>" class="btn btn-link instruction" style="padding:0;"  data-toggle="tooltip" data-placement="top" data-html="true" title="View report for this Learning Outcome" >
<?php echo $profoutcome['catcode']; ?> - <?php echo $profoutcome['code']; ?></a><!--<span style="margin-left: 1.5em;" class="instruction"  data-toggle="tooltip" data-placement="top" data-html="true" title="Click to view Learning Outcome statement" ><a class="btn btn-link doNotPrint" style="padding:0;"   data-toggle="modal" href="<?php echo base_url() . 'resource/ocf/';?>html/amcgo/<?php echo strtolower($profoutcome['code']); ?>.html" data-target="#myModal"><i class="fa fa-info-circle"></i></a></span>--><br />

<?php } // end profoutcome ?>
<?php } // end isset($topicoutcome['prof']) ?>
</td>
<td align="left" valign="top" style="padding:5px; width: 22em;" scope="col">
<ul>
<?php 
if(isset($topicoutcome['activities']))
{
foreach ($topicoutcome['activities'] as $activity) { ?>
<li><?php echo $activity['name']; ?></li>
<?php }
}// end activities ?>
</ul></td>
<td align="left" valign="top" style="padding:5px; width: 22em;" scope="col">
<?php if (isset($topicoutcome['course']) && isset($topicoutcome['assessment'])) { ?>
<ul>
<?php foreach ($topicoutcome['assessment'] as $assessment) { ?>


<li><?php echo $assessment['name']; ?></li>

<?php } // end courseoutcome ?>
</ul>
<?php } // end isset($topicoutcome['course']) ?>



</td>

</tr>

<?php } // end topicoutcomes ?>
</tbody>



</table>

<!-- Modals -->


<div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

</div>
</div>
</div>




</div>

</div>

</div>

</div>



</body>
</html>
