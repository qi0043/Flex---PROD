<!DOCTYPE html>
<html lang="en">
<head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/reports/';?>bootstrap-3.2.0-dist/css/bootstrap.min.css" media="all">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/reports/css/';?>dashboard.css" media="all">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/reports/';?>font-awesome-4.4.0/css/font-awesome.css" rel="stylesheet" type="text/css">
	<title>FLEX Flextra reports</title>
        
	<script type="text/javascript" src="<?php echo base_url() . 'resource/reports/';?>js/jquery-1.11.1.min.js"></script>
	<script src="<?php echo base_url() . 'resource/reports/';?>bootstrap-3.2.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url() . 'resource/reports/';?>js/Chart.min.js"></script>

</head>
<body>

  <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">FLEX Flextra Assext Reports</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo base_url();?>reports/reptmain/home/">FLEX/Flextra</a></li>
	    <li><a href="<?php echo base_url();?>reports/reptmain/get_daily_import/">Data/Cron</a></li>
            <li><a href="<?php echo base_url();?>reports/reptmain/check_logs/">Logs</a></li>
            <li><a href="<?php echo base_url();?>reports/reptmain/assext_main/">Assignment Ext.</a></li>
            <li><a href="<?php echo base_url();?>reports/reptmain/admin_tools/">Admin tools</a></li>
          </ul>
          <!--<form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>-->
        </div>
      </div>
    </nav>


	
