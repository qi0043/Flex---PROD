<!DOCTYPE html>
<html lang="en">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<head>
	<title>Flinders University - RHD Theses</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/rhd/';?>bootstrap-3.3.4-dist/css/bootstrap.min.css" media="all">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/rhd/';?>bootstrap-3.3.4-dist/css/bootstrap-theme.min.css" media="all">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/rhd/';?>css/flextra-er.css" media="all">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/rhd/';?>css/rhd.css" media="all">
    <script type="text/javascript" src="<?php echo base_url() . 'resource/rhd/';?>js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'resource/rhd/';?>bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
    
     
</head>
<body>
<div class="wrap">
	<?php /*?><div id="wrapper">
        <div id="topbar">
            <div id="topbar-wrap">
                <div id="topbar-inner">
                    <div id="topmenu">
                        <span id="temptopbar_editUserLink">                	
                            <i class="icon-user icon-white"></i>  <?php if(isset($owner)){echo $owner;} else {echo 'You are not logged in';}?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>  <?php */?>
    <div id="header" role="banner">
        <div id="header-inner">
            <div class="badge"></div>
            <div class="banner">My Thesis</div>
        </div>
    </div>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-header col-xs-9 col-md-10">
                <a class="brand" href="https://flextra.flinders.edu.au/flex/rhd">Research Higher Degree Theses</a>
            </div>
            <div class="navbar-header col-xs-3 col-md-2">
                <ul class="nav">
                     <li class="brand"><i class="glyphicon glyphicon-user"></i> <span class="right"><?php if(isset($owner)){echo $owner;} else {echo 'You are not logged in';}?></span></li>
                </ul>
            </div>
             
        </div>
    </nav>
   





	
