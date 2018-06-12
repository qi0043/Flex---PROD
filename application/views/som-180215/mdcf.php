<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="../../assets/ico/favicon.ico">
<title>School of Medicine Curriculum Framework</title>
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


@media print {
	
  a[href]:after {
    content: "";
  }
}
-->
</style>



    <script type="text/javascript">

    $(document).ready(function(){

        $(".dropdown-toggle").dropdown();

    });  

    </script>



</head>
<body role="document">
<div class="jumbotron">
<div class="container-fluid"><img src="<?php echo base_url() . 'resource/som/';?>images/flinders_logo.png" width="151" height="65" alt="Flinders University"></div>
</div>

<div class="container-fluid" style="margin:0 20px 0 20px; min-height:700px;">

<div role="main">
  <div class="page-header">

    <h2>Flinders University MD Curriculum Framework - Pilot v.1</h2>
  </div>


<div class="row">
<h3>Welcome</h3>
<p>&nbsp;</p>
</div>
<div class="row">
<div class="col-md-4">

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Outcome Category</h3>
  </div>
  <div class="panel-body">
    <ul>
    <li><a href="/flex/som/fmgo" class="standard">Flinders Medical Graduate Outcomes (FMGO)</a></li>
    <li><a href="/flex/som/amcgo" class="standard">AMC Graduate Outcomes (AMCGO</a>)</li>
  </ul>
  </div>
</div>
</div> 


<div class="col-md-4">

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"> Topic Outcome Report</h3>
  </div>
  <div class="panel-body">
 <!--Primary buttons with dropdown menu-->
        <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" style="padding-left: 20px; padding-right: 20px;">Topics&nbsp;&nbsp;<span class="caret"></span></button>
            <ul class="dropdown-menu">
            
            <?php foreach ($topics as $topic) { ?>
                <li><a href="/flex/som/topic/<?php echo $topic['uuid']; ?>/<?php echo $topic['version']; ?>"><?php echo $topic['code']; ?> :: <?php echo $topic['title']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
  </div>
</div>
</div>

<div class="col-md-4">

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"> Topic Summary Report</h3>
  </div>
  <div class="panel-body">
 <!--Primary buttons with dropdown menu-->
        <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" style="padding-left: 20px; padding-right: 20px;">Topics&nbsp;&nbsp;<span class="caret"></span></button>
            <ul class="dropdown-menu">
            
            <?php foreach ($topics as $topic) { ?>
                <li><a href="/flex/som/summary/<?php echo $topic['uuid']; ?>/<?php echo $topic['version']; ?>"><?php echo $topic['code']; ?> :: <?php echo $topic['title']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
  </div>
</div>
</div>
  </div>
<div class="row">
<div class="col-md-4">

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">The Map</h3>
  </div>
  <div class="panel-body">
    <ul>
    <li><a href="/flex/som/cmap" class="standard">Map v0.1</a></li>
    <li><a href="/flex/som/maptest" class="standard">Map v0.2</a></li>
  </ul>
  </div>
</div>
</div>

</div>
</div>



</div>

</div>


</body>
</html>
