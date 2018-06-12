<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<?php /*?><link rel="shortcut icon" href="../../assets/ico/favicon.ico">
<?php */?><title>School of Medicine Curriculum Framework::Course Overview - Flinders Medical Graduate Outcomes</title>




<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/bootstrap.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/bootstrap-theme.css">



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
 
    
<script src="<?php echo base_url() . 'resource/ocf/';?>js/jquery-1.10.2.min.js"></script>


<script src="<?php echo base_url() . 'resource/ocf/';?>js/jquery-ui-1.10.3.custom.min.js"></script>


<script src="<?php echo base_url() . 'resource/ocf/';?>js/bootstrap.js"></script>  

<link href="<?php echo base_url() . 'resource/ocf/';?>css/font-awesome-4.2.0/css/font-awesome.css" rel="stylesheet" type="text/css">


<style type="text/css">
<!--

.vertical-text {
	display: inline-block;
	overflow: hidden;
	width: 1.5em;
}
.vertical-text__inner {
	display: inline-block;
	white-space: nowrap;
	line-height: 1.5;
	transform: translate(0,100%) rotate(-90deg);
	transform-origin: 0 0;
}
/* This element stretches the parent to be square
   by using the mechanics of vertical margins  */
.vertical-text__inner:after {
	content: "";
	display: block;
	margin: -1.5em 0 100%;
}


td.nullBG {
	
	
	background-color: #999;
	
}

td.notNullBG {
	
	
	background-color: #E9E9E9 !important;
	
}

#myNav {
	
	margin-bottom:1em;
	
}  



@media print {
	
  a[href]:after {
    content: "";
  }
  
 td.notNullBG {
	background-color: #E9E9E9 !important;

}

th {background:inherit; }


#myNav {
	display:none;
	visibility:hidden;
	
} 


th.bg-success {
  background-color: #dff0d8 !important;
}

th.bg-info {
  background-color: #d9edf7 !important;
}

th.bg-warning {
  background-color: #fcf8e3 !important;
}

th.bg-danger {
  background-color: #f2dede !important;;
}
  
}
-->
</style>

<script type="text/javascript">




$(document).on("hidden.bs.modal", function (e) { $(e.target).removeData("bs.modal").find(".modal-content").empty(); });


</script>

<script type="text/javascript">

$('.heatmap').tooltip({
    'placement': 'top'
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
    <h2>Flinders University MD Curriculum Framework - Pilot v.1</h2>
  </div>
  <div class="row">
<div id="myNav" class="span10"><a href="/flex/ocf/startup" class="btn btn-sm btn-primary">Return to dashboard</a>&nbsp;&nbsp;<a href="/flex/ocf/amcgo" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Tooltip on top">AMC Graduate Outcomes</a></div>

<?php 

$topicCount = intval($topiccount['numTopics']);
$theLevel = intval($topiccount['theLevel']);

?>


<h3>Course Overview - Flinders Medical Graduate Outcomes<?php if ($theLevel > 0) { ?> - Level <?php echo $theLevel; ?><?php } ?></h3>


<!--   
 <p>Number of Topics: <?php echo $topicCount; ?></p>
  
<pre>

<?php print_r($topics); ?>

</pre>


<pre>
<?php  print_r($topics[1]['course']['los']); ?>
</pre>
-->

</div>
<h4>Outcome Levels</h4>
<a href="/flex/ocf/fmgo/0" class="btn <?php if ($theLevel == 0) { ?>active<?php } ?> btn-sm btn-default" style="margin-right:25px; float:left;">Show None</a>
<div class="btn-group" style="margin-bottom:10px; float:left;">
<a href="/flex/ocf/fmgo/1" class="btn <?php if ($theLevel == 1) { ?>active<?php } ?> 
 btn-sm btn-default" >Level 1</a>
<a href="/flex/ocf/fmgo/2" class="btn <?php if ($theLevel == 2) { ?>active<?php } ?> 
 btn-sm btn-default" >Level 2</a>
<a href="/flex/ocf/fmgo/3" class="btn <?php if ($theLevel == 3) { ?>active<?php } ?> 
 btn-sm btn-default" >Level 3</a>
</div>



<a href="/flex/ocf/fmgo" class="btn btn-sm btn-default" style="margin-left:25px;">Show All</a>
<br clear="left" />
 <div class="span10">
  <table class="table-bordered" style="margin-bottom:5em;">
  <thead>
  
   <tr>
<th valign="bottom" style="padding:5px;"></th>
<th valign="bottom" class="bg-info" style="padding:5px;">Science &<br />Scholarship</th>
<th colspan="3" valign="bottom" class="bg-warning" style="padding:5px;">Clinical Practice</th>
<th valign="bottom" class="bg-success" style="padding:5px;">Health & Society</th>
<th colspan="3" valign="bottom" class="bg-danger" style="padding:5px;">Professionalism & Leadership</th>
</tr>

    <tr>
      <th valign="bottom" style="padding:5px;" scope="col">Topic</th>
       <?php for ($i = 1; $i <= 8; $i++ ) { ?><th valign="bottom" style="padding:5px; width:9em;" scope="col"><a href="/flex/ocf/fmgosearch/<?php echo strtolower($topics[1]['course']['los']['lo'.$i]['code']);?>" class="standard"><?php echo $topics[1]['course']['los']['lo'.$i]['code'];?></a></th> <?php } ?>  
    </tr>
  </thead>
  <tbody>  
 <?php foreach ($topics as $topic) { ?>
    <tr>
      <td style="padding:5px; padding-right:3em;">
      <a href="/flex/ocf/topic/<?php echo $topic['uuid']; ?>/<?php echo $topic['version']; ?>" title="<?php echo $topic['title']; ?>" class="standard"><?php echo $topic['code']; ?></a>
      </td>
      <?php for ($i = 1; $i <= 8; $i++ ) { ?>
      <td align="center"  style="padding:5px;" <?php if($topic['course']['los']['lo'.$i]['numAlign'] > 0) { ?> class="notNullBG"<?php } ?>><?php if ($topic['course']['los']['lo'.$i]['level'] == $topiccount['theLevel']) { ?>

<img src="<?php echo base_url() . 'resource/ocf/';?>images/flextra-level-<?php echo $topic['course']['los']['lo'.$i]['level']; ?>.svg" alt="level<?php echo $topic['course']['los']['lo'.$i]['level']; ?>" width="18" height="18" title="Level <?php echo $topic['course']['los']['lo'.$i]['level']; ?>" data-toggle="tooltip" class="heatmap"><?php } else { ?>
<span class="notNullBG" style="padding:5px;"><img src="<?php echo base_url() . 'resource/ocf/images/blank.gif'; ?>" alt="" width="18" height="18"></span><?php } ?></td>
   <?php } ?>  
    </tr>
    
<?php } ?>
</tbody>
  </table>


</div>

</div>

</div>



</body>
</html>
