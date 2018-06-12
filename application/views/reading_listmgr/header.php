<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        
        <script type="text/javascript" src="<?php echo base_url() . 'resource/listmgr/';?>js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url() . 'resource/listmgr/';?>bootstrap-3.2.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/listmgr/';?>bootstrap-3.2.0-dist/css/bootstrap.min.css" media="all">
        <!--<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/listmgr/';?>bootstrap-3.2.0-dist/css/bootstrap-theme.min.css" media="all">-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/listmgr/';?>css/flextra-er.css" media="all">
	<title>eReading List Management</title>
        
</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    
  <div class="container">
    <div class="navbar-brand">
      <p class="lead"> <a id="home_link" href="<?php echo base_url() . 'reading/listmgr/';?>home.html"><span class="glyphicon glyphicon-home"  tabindex="1000"></span> eReading List Management >> </a> <span id="header_level_2_txt" style="color:#EEE"></span> </p>
    </div>
      
  </div>
    
</nav>
<?php if(isset($_SESSION['listmgr_notice'])){ ?>
<br><br>
    <div class="navbar-brand">
      <span class="label label-warning"><?php echo $_SESSION['listmgr_notice']; ?></span> 
    </div>
<?php } ?>


	
