<?php


switch ($_SERVER['SERVER_NAME']) {


    case "flextra.flinders.edu.au":
    
        $floserv = "https://flo.flinders.edu.au/";
        break;

    case "flextra-test.flinders.edu.au":
    
        $floserv = "https://flostage.flinders.edu.au/";
        break;


    case "flextra-dev.flinders.edu.au":
    
        $floserv = "https://flodev.flinders.edu.au/";
        break;

}



?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>FLO Required fro Access</title>


<!-- CSS and Javascripts -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap.min.css" media="all">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap-theme.min.css">
<!-- Local styles -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/local.css">

<!-- jQuery -->

<script type="text/javascript" src="<?php echo base_url() . 'resource/flo/ocf/';?>js/jquery-1.10.2.min.js"></script>




</head>

<body role="document">
<div class="jumbotron">
	<div class="container-fluid"><img src="<?php echo base_url() . 'resource/flo/ocf/';?>images/flinders_logo.png" width="151" height="65" alt="Flinders University"></div>
</div>
<div class="container-fluid">

<h3>Please access from FLO</h3>
<p>This resource can only be acessed from Flinders Learning Online (FLO)</p>

<p>Access <a href="<?php echo $floserv; ?>">Flinders Learning Online</a></p>

</div>
</body>
</html>