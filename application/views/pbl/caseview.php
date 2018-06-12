<?php


switch ($_SERVER['SERVER_NAME']) {


    case "flextra.flinders.edu.au":
    
        $flexserv = "https://flex.flinders.edu.au";
        break;

    case "flextra-test.flinders.edu.au":
    
        $flexserv = "https://flex-test.flinders.edu.au";
        break;


    case "flextra-dev.flinders.edu.au":
    
        $flexserv = "https://flex-dev.flinders.edu.au";
        break;

}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>PBL Case</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

<script language="JavaScript" type="text/JavaScript">
<!--
function show(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>


<script type="text/javascript" src="https://www.flinders.edu.au/flinders/app_templates/flinderstemplates/javascript/modernizr.js"></script>
<link href="<?php echo base_url() . 'resource/flo/pbl/';?>css/base.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'resource/flo/pbl/';?>css/local.css" rel="stylesheet" type="text/css" />



<link href="<?php echo base_url() . 'resource/flo/pbl/';?>css/FU_PBL_Large.css" rel="stylesheet" type="text/css" />
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/pbl/';?>css/bootstrap.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/pbl/';?>css/bootstrap-theme.css">


<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->



<!-- Latest compiled and minified JavaScript -->
 
    
<script src="<?php echo base_url() . 'resource/flo/pbl/';?>js/jquery-1.10.2.min.js"></script>


<script src="<?php echo base_url() . 'resource/flo/pbl/';?>js/jquery-ui-1.10.3.custom.min.js"></script>


<script src="<?php echo base_url() . 'resource/flo/pbl/';?>js/bootstrap.js"></script>  



<style type="text/css">
<!--
.greyBG {
	background-color: #f5f5f5;
	margin-top: 50px;
	border: thin dotted #333333;
	font-weight: bold;
	color: #CC0000;
	width: 95%;
	padding-top: 30px;
	padding-right: 6px;
	padding-bottom: 30px;
	padding-left: 6px;
	margin-bottom: 90px;
	font-size: 120%;
}
-->
</style>

<script src="<?php echo base_url() . 'resource/flo/pbl/';?>js/jquery.cycle2.js"></script>
<script src="<?php echo base_url() . 'resource/flo/pbl/';?>js/jquery.cycle2.caption2.min.js"></script>

<script src="<?php echo base_url() . 'resource/flo/pbl/';?>js/jquery.cycle2.swipe.js"></script>
<script src="<?php echo base_url() . 'resource/flo/pbl/';?>js/ios6fix.js"></script>



<!-- YAMM mega menu -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/pbl/';?>css/yamm/yamm.css">

<script type="text/javascript">

$(document).ready(function() {


$('a.handout').attr('href', function(i, currentAttribute){
    									 
var thePrepend = '<?php echo base_url(); ?>pbl/handout/<?php echo $case['uuid']; ?>/<?php echo $case['version']; ?>/';

newID = currentAttribute.replace('http://flex.flinders.edu.au/','');

//alert(newID);
    
    return thePrepend + newID ;
});

	});
</script>

<script language="JavaScript">



function myLoader() {
	
	
	resizeTo(1280,780);
	
	
	window.focus();


}

</script>

</head>




<body class="noImg"  onload="myLoader();">
<div id="header">
  <div id="prev" style="float:left; cursor:pointer; margin:10px;" class="home_info_button charcoal_gradient">Previous</div>


<div id="next" style="float:right;cursor:pointer;  margin:10px;"class="home_info_button charcoal_gradient">Next</div>

</div>

<!--  
<pre>

<?php print_r($case); ?>


</pre>



 --> 

<?php

$caseTitle = $case['caseTitle'];



?>


<div id="screencontent">
<div class="cycle-slideshow" 
    data-cycle-fx="fade" 
    data-cycle-allow-wrap="false"
    data-cycle-loop="1"   
    data-cycle-timeout="0"
    data-cycle-prev="#prev"
    data-cycle-next="#next"
    data-cycle-swipe="true"
    data-cycle-slides="> div"
    
    >
<?php 

$ctr = 0;

foreach ($case['screens'] AS $screen) {   ?>


<div id="<?php echo $screen['idhash']; ?>" style="width:100%; background-color:#FFF;" data-cycle-hash="<?php echo $screen['idhash']; ?>">	

<p style="font-size:10px; font-style:italic; float:right;">PBL Case: <?php echo $caseTitle; ?> :: Tutorial <?php echo $screen['tutorial']; ?>, Screen <?php echo $screen['screenNumber']; ?> </p>
<div class="scr_heading">
<img name="" src="<?php echo base_url() . 'resource/flo/pbl/';?>images/icons/<?php echo $screen['icon']; ?>" width="48" height="48" alt="<?php echo $screen['iconName']; ?>" style="vertical-align:middle" />&nbsp;&nbsp;<?php echo $screen['screenName']; ?></div>
<?php echo html_entity_decode($screen['text']); ?>
</div>
	
<?php
	
}


?>

</div>
</div>

</body>
</html>
