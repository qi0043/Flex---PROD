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
<!-- caseview2.php -->
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
<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/bootstrap.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/bootstrap-theme.css">

<!-- font-awesome theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/font-awesome-4.2.0/css/font-awesome.css">

<!-- YAMM mega menu -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/yamm/yamm.css">


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
	background-color: #fc3;
    border-color: #fc3;
    box-shadow:none;
}

.navbar-default .navbar-nav > li > a {
    color: #000;
}

li.open {
	background-color:#fff;
	border-color:#fff;
	
}

.yamm-small {
	
	font-size: 1.2vmin;
	
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

    background-color: #fc3;
	color: #000;
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

<script language="JavaScript">



function myLoader() {
	
	
	resizeTo(1280,780);
	
	
	window.focus();


}

</script>

</head>




<body class="noImg"  onload="myLoader();">

   <!--
   
   
   
   
   <?php print_r($caseresources); ?>
   
   
   
   
   
   
   
   --> 


    <!-- Fixed navbar -->
    <nav class="navbar yamm navbar-default navbar-fixed-top">
      <div>
 
        <div id="navbar">
                  <ul class="nav navbar-nav navbar-left" style="margin-left:15px;">
       <li><button id="prev" style="cursor:pointer;" class="btn btn-default"><i class="fa fa-chevron-left"></i>
&nbsp;Previous</button></li>
          </ul>
          <ul class="nav navbar-nav" style="margin-left:15px;">
            <!-- Classic list --><!-- Accordion demo --><!-- Classic dropdown --><!-- Pictures -->
            <li style="margin:0;" class="dropdown yamm-fw"><a href="#" data-toggle="dropdown" class="dropdown-toggle" style="font-size:16px;">Case Resources<b class="caret"></b></a>
              <ul class="dropdown-menu"  style="background-color:#F0F0F0">
                <li>
         
                  <div class="yamm-content">
                    <div class="row-fluid">
<?php if (!empty($caseresources)) { ?>
                       <h4>Case Resources</h4>
  <?php foreach ($caseresources as $cr) { ?>
    <div class="col-md-2 col-sm-3 col-xs-6" style="font-size:0.9em;">
       <a href="/flex/ocf/generatetoken/viewitem/items/<?php echo $case['uuid']; ?>/<?php echo $case['version']; ?>/<?php echo $cr['uuid']; ?>" class="thumbnail" style="height:140px; overflow:hidden;" target="_blank">
       <img src="<?php echo $cr['thumbnailLink']; ?>?token=<?php echo $token;?>" alt="<?php echo $cr['title']; ?>">
        <p class="yamm-small"><?php echo $cr['title']; ?></p>    
        
      </a>
    </div>
    <?php } ?>
     <?php } else { ?>
       <h4>NIL Case Resources identified</h4>
     <?php } ?>             
                    </div>
                  </div>
                </li>
     

   
              </ul>
            </li>
            
            
            
          </ul>
          <?php 
		  // set up tutorials
		  
		  $current = '0';
		  $previous = '0';
		  
		  
		  ?>
        <ul class="nav navbar-nav" style="margin-left:15px;">


            <!-- Classic dropdown -->
            <li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle"  style="font-size:16px;">Screens<b class="caret"></b></a>
              <ul role="menu" class="dropdown-menu" style="font-size:16px;">
              <?php foreach ($case['screens'] AS $screen) {   ?>
        
              <?php $current = $screen['tutorial']; ?>
             <?php if (($current != $previous) && ($previous > 0)){ ?>
              <li class="divider"></li>
              <?php } ?>
                
                <li style="font-size:14px;"><a tabindex="-1" href="#<?php echo $screen['idhash']; ?>" > Tutorial <?php echo $screen['tutorial']; ?>, Screen <?php echo $screen['screenNumber']; ?>: <?php echo $screen['screenName']; ?></a> </li>
                <?php $previous = $current; ?>
      
         <?php } ?>
              </ul>
            </li>
     

   
              </ul>

          
          
          <ul class="nav navbar-nav navbar-right" style="margin-right:15px;">
 
 
 
 
  <li><button id="next" style="cursor:pointer;" class="btn btn-default">Next&nbsp;<i class="fa fa-chevron-right"></i>
</button></li>
        </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
    
    
    
    <!--  
<pre>

<?php print_r($case); ?>


</pre>



 --> 

<?php

$caseTitle = $case['caseTitle'];



?>


<div id="screencontent" style="margin-top:65px; padding-left:2vh;">
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
