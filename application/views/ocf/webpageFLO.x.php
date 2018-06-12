
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://flextra-test.flinders.edu.au/flex/resource/ocf/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://flextra-test.flinders.edu.au/flex/resource/ocf/css/bootstrap-theme.min.css">
<!-- Local styles -->
<link rel="stylesheet" href="https://flextra-test.flinders.edu.au/flex/resource/ocf/css/local.css">


<!-- Javascripts and css from main FLO installation, update 23-12-2014 -->

<link rel="stylesheet" type="text/css" href="https://flo.flinders.edu.au/theme/yui_combo.php?r1419224232&rollup/3.15.0/yui-moodlesimple-min.css" /><script type="text/javascript" src="https://flo.flinders.edu.au/theme/yui_combo.php?r1419224232&rollup/3.15.0_1/yui-moodlesimple-min.js&amp;rollup/1419224232/mcore-min.js"></script><script type="text/javascript" src="https://flo.flinders.edu.au/theme/jquery.php/r1419224232/core/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="https://flo.flinders.edu.au/theme/jquery.php/r1419224232/theme_flinders/cslider_1.0.js"></script>
<script type="text/javascript" src="https://flo.flinders.edu.au/theme/jquery.php/r1419224232/theme_flinders/custom_1.0.js"></script>
<script type="text/javascript" src="https://flo.flinders.edu.au/theme/jquery.php/r1419224232/theme_flinders/bootstrap_plugins/alert_2.3.2.js"></script>
<script type="text/javascript" src="https://flo.flinders.edu.au/theme/jquery.php/r1419224232/theme_flinders/bootstrap_plugins/carousel_2.3.2.js"></script>

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

<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/flostyles.css">



<!-- jQuery -->




<script type="text/javascript">


    $( document ).ready(function() {
    
	
	$('img[src^=items]').attr('src', function(i, currentAttribute){
   
   
 //alert(currentAttribute); 									 
var thePrepend = '<?php echo $flexserv; ?>';
var theToken ='<?php echo $token; ?>';

var theAppend = '&token=';
   
   
    return thePrepend + currentAttribute + '?token=' + theToken;  
    //return thePrepend + currentAttribute + theAppend + thetoken; 
});


$('a[href^=items]').attr('href', function(i, currentAttribute){
   
   
//alert(currentAttribute); 									 
var thePrepend = '<?php echo $flexserv; ?>';
var theToken ='<?php echo $token; ?>';

var theAppend = '&token=';
   
   
    return thePrepend + currentAttribute + '?token=' + theToken;  
    //return thePrepend + currentAttribute + theAppend + thetoken; 
});
    });

 
</script>

</head>

<body role="document">
<div class="container-fluid">
<div class="block block_course_overview" style="margin:2em;">
<h3><?php echo $activitytitle; ?> :: <?php echo $title; ?></h3>
<?php echo $pagecontent; ?>
</div>
</div>
</body>
</html>