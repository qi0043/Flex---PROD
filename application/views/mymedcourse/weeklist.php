<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>MyMedCourse::<?php echo $topic['availability']; ?></title>



<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/som/';?>css/bootstrap.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/som/';?>css/bootstrap-theme.css">


<!-- Javascripts and css from main FLO installation, update 23-12-2014 -->

<link rel="stylesheet" type="text/css" href="https://flo.flinders.edu.au/theme/yui_combo.php?r1419224232&rollup/3.15.0/yui-moodlesimple-min.css" /><script type="text/javascript" src="https://flo.flinders.edu.au/theme/yui_combo.php?r1419224232&rollup/3.15.0_1/yui-moodlesimple-min.js&amp;rollup/1419224232/mcore-min.js"></script><script type="text/javascript" src="https://flo.flinders.edu.au/theme/jquery.php/r1419224232/core/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="https://flo.flinders.edu.au/theme/jquery.php/r1419224232/theme_flinders/cslider_1.0.js"></script>
<script type="text/javascript" src="https://flo.flinders.edu.au/theme/jquery.php/r1419224232/theme_flinders/custom_1.0.js"></script>
<script type="text/javascript" src="https://flo.flinders.edu.au/theme/jquery.php/r1419224232/theme_flinders/bootstrap_plugins/alert_2.3.2.js"></script>
<script type="text/javascript" src="https://flo.flinders.edu.au/theme/jquery.php/r1419224232/theme_flinders/bootstrap_plugins/carousel_2.3.2.js"></script>
<script type="text/javascript" src="https://flo.flinders.edu.au/theme/jquery.php/r1419224232/theme_flinders/bootstrap_plugins/collapse_2.3.2.js"></script>
<script type="text/javascript" src="https://flo.flinders.edu.au/theme/jquery.php/r1419224232/theme_flinders/bootstrap_plugins/modal_2.3.2.js"></script>
<script type="text/javascript" src="https://flo.flinders.edu.au/theme/jquery.php/r1419224232/theme_flinders/bootstrap_plugins/scrollspy_2.3.2.js"></script>
<script type="text/javascript" src="https://flo.flinders.edu.au/theme/jquery.php/r1419224232/theme_flinders/bootstrap_plugins/tab_2.3.2.js"></script>
<script type="text/javascript" src="https://flo.flinders.edu.au/theme/jquery.php/r1419224232/theme_flinders/bootstrap_plugins/tooltip_2.3.2.js"></script>
<script type="text/javascript" src="https://flo.flinders.edu.au/theme/jquery.php/r1419224232/theme_flinders/bootstrap_plugins/transition_2.3.2.js"></script>
<script type="text/javascript" src="https://flo.flinders.edu.au/theme/jquery.php/r1419224232/theme_flinders/modernizr_2.6.2.js"></script>
<script id="firstthemesheet" type="text/css">/** Required in order to fix style inclusion problems in IE with YUI **/</script><link rel="stylesheet" type="text/css" href="https://flo.flinders.edu.au/theme/styles.php/flinders/1419224232/all" />
<script type="text/javascript" src="https://flo.flinders.edu.au/lib/javascript.php/1419224232/lib/javascript-static.js"></script>




    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- iOS Homescreen Icons -->
    
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="https://flo.flinders.edu.au/theme/image.php/flinders/theme/1386338013/homeicon/iphone" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://flo.flinders.edu.au/theme/image.php/flinders/theme/1386338013/homeicon/ipad" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://flo.flinders.edu.au/theme/image.php/flinders/theme/1386338013/homeicon/iphone_retina" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="https://flo.flinders.edu.au/theme/image.php/flinders/theme/1386338013/homeicon/ipad_retina" />







<!-- Local styles -->

<link rel="stylesheet" href="<?php echo base_url() . 'resource/som/';?>css/local.css">

<link rel="stylesheet" href="<?php echo base_url() . 'resource/mymedcourse/';?>css/localstyles.css">

<link href="<?php echo base_url() . 'resource/som/';?>css/font-awesome-4.2.0/css/font-awesome.css" rel="stylesheet" type="text/css">

<!-- Latest compiled and minified JavaScript -->
 
    
<script src="<?php echo base_url() . 'resource/som/';?>js/jquery-1.10.2.min.js"></script>


<script src="<?php echo base_url() . 'resource/som/';?>js/jquery-ui-1.10.3.custom.min.js"></script>


<script src="<?php echo base_url() . 'resource/som/';?>js/bootstrap.js"></script>  

<style type="text/css">
<!--
.red {color: #CC0000}

.fieldTitle {
	font-weight: bold;
	float: left;
	width: 10em;
}



h2 {
	font-size:22px;

}





-->
</style>


</head>

<body class="flinders-gold margin10">
<h1><i class="fa fa-medkit"></i>&nbsp;MyMedCourse</h1>
<div class="block_course_overview block">

<h3>MyMedCourse  <?php echo $topic['dyear']; ?> Semester <?php echo $topic['semester']; ?></h3>
</div>

<div class="block_course_overview block">
<?php $week = 0; ?>
<?php foreach ($topic['act_item'] as $theme) {
	
	$week++;
	
?>

<p style="margin-left:2em;"><span class="fieldTitle">Week <?php echo $week; ?></span><span style="float:left; width:35em;"><?php echo $theme['title']; ?></span><span style="float:left; width:32em;"><a href="/flex/mymedcourse/weekview/<?php echo $theme['itemUuid']; ?>/<?php echo $theme['itemVersion']; ?>/<?php echo $topic['tcode']; ?>">View</a></span><br clear="left" /></p>	
	
	
	
<?php } ?>


</div>

</body>
</html>