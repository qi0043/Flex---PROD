<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<?php /*?><link rel="shortcut icon" href="../../assets/ico/favicon.ico"><?php */?>
<title>School of Medicine Curriculum Framework::Course Overview - AMC Graduate Outcomes</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/som/';?>css/bootstrap.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/som/';?>css/bootstrap-theme.css">


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
 
    
<script src="<?php echo base_url() . 'resource/som/';?>js/jquery-1.10.2.min.js"></script>


<script src="<?php echo base_url() . 'resource/som/';?>js/jquery-ui-1.10.3.custom.min.js"></script>


<script src="<?php echo base_url() . 'resource/som/';?>js/bootstrap.js"></script>  


<link href="<?php echo base_url() . 'resource/som/';?>css/font-awesome-4.2.0/css/font-awesome.css" rel="stylesheet" type="text/css">


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




</head>
<body role="document">

<div class="jumbotron">
<div class="container-fluid"><img src="<?php echo base_url() . 'resource/som/';?>images/flinders_logo.png" width="151" height="65" alt="Flinders University"></div>
</div>

<div class="container-fluid" style="margin:0 20px 0 20px;">

<div role="main">
  <div class="page-header">
    <h2>Flinders University MD Curriculum Framework - Pilot v.1</h2>
  </div>
  <div class="row">

<div id="myNav" class="span10"><a href="startup" class="btn btn-sm btn-primary">Return to dashboard</a>&nbsp;&nbsp;<a href="fmgo" class="btn btn-sm btn-success">Flinders Medical Graduate Outcomes</a></div>
<h3>Course Overview - AMC Graduate Outcomes</h3>




<?php 

$topicCount = intval($topiccount['numTopics']);

?>


<!--     
<pre>

<?php print_r($topics); ?>

</pre>


<pre>
<?php if(isset($topics[1]['course']))
	 print_r($topics[1]['course']['los']); ?>
</pre>-->
</div>
 
<h4>Outcome Levels</h4>
<a href="/flex/som/amcgo/0" class="btn  btn-sm btn-default" style="margin-right:25px; float:left;">Show None</a>

<div class="btn-group" style="margin-bottom:10px; float:left;">
<a href="/flex/som/amcgo/1" class="btn  
 btn-sm btn-default" >Level 1</a>
<a href="/flex/som/amcgo/2" class="btn 
 btn-sm btn-default" >Level 2</a>
<a href="/flex/som/amcgo/3" class="btn  
 btn-sm btn-default" >Level 3</a>
</div>



<a href="/flex/som/amcgo" class="btn active btn-sm btn-default" style="margin-left:25px;">Show All</a>
<br clear="left" />



<div class="span10" id="theData">




  <table class="table-bordered table-responsive" style="margin-bottom:5em;">
  <thead>
    <tr>
    <th valign="bottom" style="padding:5px;" scope="col">&nbsp;</th>
    <th colspan="6" valign="bottom" class="bg-info" style="padding:5px;" scope="col">Science &amp; Scholarship</th>
    <th colspan="15" valign="bottom" class="bg-warning" style="padding:5px;" scope="col">Clinical Practice</th>
    <th colspan="9" valign="bottom" class="bg-success" style="padding:5px;" scope="col">Health &amp; Society</th>
    <th colspan="10" valign="bottom" class="bg-danger" style="padding:5px;" scope="col">Professionalism &amp; Leadership</th>
    </tr>
    <tr>
      <th valign="bottom" style="padding:5px;" scope="col">&nbsp;</th>
      <?php for ($i = 1; $i <= 40; $i++ ) { ?>
      <th valign="bottom" style="padding:5px; width:4.2em;" scope="col"><a href="amcgosearch/<?php echo strtolower($topics[2]['prof']['los']['lo'.$i]['code']);?>" class="standard"><?php echo $topics[2]['prof']['los']['lo'.$i]['code'];?></a><?php if (strlen($topics[2]['prof']['los']['lo'.$i]['code']) < 4) { ?>&nbsp;<?php } ?></th>
 <?php } ?>  
    </tr>

  </thead>
  <tbody>  
 <?php foreach ($topics as $topic) { ?>
    <tr>
      <td style="padding:5px; padding-right:3em;">
      <a href="topic/<?php echo $topic['uuid']; ?>/<?php echo $topic['version']; ?>" title="<?php echo $topic['title']; ?>" class="standard"><?php echo $topic['code']; ?></a>
      </td>
      <?php for ($i = 1; $i <= 40; $i++ ) { ?>
      <td align="center" style="padding:5px;" <?php if($topic['prof']['los']['lo'.$i]['numAlign'] > 0) { ?> class="notNullBG"<?php } ?>><?php if ($topic['prof']['los']['lo'.$i]['level'] >= 1) { ?>

<img src="<?php echo base_url() . 'resource/som/';?>images/flextra-level-<?php echo $topic['prof']['los']['lo'.$i]['level']; ?>.svg" alt="level<?php echo $topic['prof']['los']['lo'.$i]['level']; ?>" width="18" height="18" data-toggle="tooltip" data-placement="top" title="Level <?php echo $topic['prof']['los']['lo'.$i]['level']; ?>"><?php } else { ?>&nbsp;<?php } ?></td>
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
