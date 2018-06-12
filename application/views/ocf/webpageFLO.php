
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $title; ?></title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap-theme.min.css">

<!-- FLO styles -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/flostyles.css">

<!-- Local styles -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/local.css">



<!-- jw player if required -->

<script type="text/javascript" src="<?php echo base_url() . 'resource/flo/ocf/';?>jwplayer.js">


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
<!--<div class="block block_course_overview" style="margin:2em;">-->
<div style="margin:2em;">
<h2><?php echo $activitytitle; ?> :: <?php echo $title; ?></h2>
<?php echo $pagecontent; ?>
</div>
</div>
</body>
</html>