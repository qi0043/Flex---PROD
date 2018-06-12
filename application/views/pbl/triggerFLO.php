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

<!--  **********************   -->
<link href="<?php echo base_url() . 'resource/flo/pbl/';?>css/base.css" rel="stylesheet" type="text/css" />

<!--  **********************   -->

<link href="<?php echo base_url() . 'resource/flo/pbl/';?>css/local.css" rel="stylesheet" type="text/css" />





<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap-theme.css">

<!-- font-awesome theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/font-awesome-4.2.0/css/font-awesome.css">

<!-- YAMM mega menu -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/yamm/yamm.css">


<!--  **********************   -->
<link href="<?php echo base_url() . 'resource/flo/pbl/';?>css/FU_PBL_Large.css" rel="stylesheet" type="text/css" />

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

.navbar-default {
    background-image: none;
	background-color: #FFD200;
    border-color: #FFD200;
    box-shadow:none;
}

.navbar-default .navbar-nav > li > a {
    color: #000;
}

li.open {
	background-color:#fff;
	border-color:#fff;
	
}
dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0px;
    z-index: 1000;
    display: none;
    float: left;
    min-width: 160px;
    padding: 5px 0px;
    margin: 2px 0px 0px;
    list-style: outside none none;
    font-size: 14px;
    background-color: #FFF;
    border: 1px solid #000;
    border-radius: 4px;
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.176);
    background-clip: padding-box;
}

.navbar-default .navbar-nav > .open > a, 
.navbar-default .navbar-nav > .open > a:hover, 
.navbar-default .navbar-nav > .open > a:focus {

    background-color: #FFD200;
	color: #000;
}


a.btn {
	color:#000;
}

</style>

<script src="<?php echo base_url() . 'resource/flo/pbl/';?>js/jquery.cycle2.js"></script>
<script src="<?php echo base_url() . 'resource/flo/pbl/';?>js/jquery.cycle2.caption2.min.js"></script>

<script src="<?php echo base_url() . 'resource/flo/pbl/';?>js/jquery.cycle2.swipe.js"></script>
<script src="<?php echo base_url() . 'resource/flo/pbl/';?>js/ios6fix.js"></script>




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



</head>




<body class="noImg">

   <!--
   
   
   
   
   <?php print_r($caseresources); ?>
   
   
   
   
   
   
   
   --> 


    <!-- Fixed navbar -->
    <nav class="navbar yamm navbar-default navbar-fixed-top">
      <div>
 
        <div id="navbar">
          <h3 style="margin-left:2em;">PBL Case: <?php echo  $basic['name']; ?></h3>        
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
    
    
    
    <!--  
<pre>

<?php print_r($case); ?>


</pre>



 -->
    <?php

foreach ($files['attachments'] as $attachment)  {
	
	
	$trigger = stripos($attachment['description'], 'case trigger');
	
	if ($trigger !== false && $attachment['type'] == 'file') {
		
		
		$imgLink = $attachment['links']['view'];
		
		$imgFile = $attachment['filename'];
		
		
		
		
	}
	
	
	
}


?>
<div align="center" style="margin-top:65px;"> <img name="" src="<?php echo $imgLink; ?>&amp;token=<?php echo $token; ?>" class="img-responsive" /> </div>
<div style="width:100%; text-align:center;">
  <div style="display:inline-block;">
    <div class="column grid_4">
   <a href="/flex/flo-ocf/pblcase/<?php echo  $basic['uuid']; ?>/<?php echo  $basic['version']; ?>"  class="btn btn-default btn-lg btn-block">Begin Case&nbsp;<i class="fa fa-chevron-right"></i>
</a>

    </div>
  </div>
</div>
</body>
</html>
