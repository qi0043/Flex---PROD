<?php


switch ($_SERVER['SERVER_NAME']) {


    case "flextra.flinders.edu.au":
    
        $flexserv = "https://flex.flinders.edu.au/";
        break;

    case "flextra-test.flinders.edu.au":
    
        $flexserv = "https://flex-test.flinders.edu.au/";
        break;


    case "flextra-dev.flinders.edu.au":
    
        $flexserv = "https://flex-dev.flinders.edu.au/";
        break;

}



?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $activitytitle; ?> :: <?php echo $title; ?></title>


<!-- CSS and Javascripts -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap.min.css" media="all">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap-theme.min.css">
<!-- Local styles -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/local.css">

<!-- jQuery -->

<script type="text/javascript" src="<?php echo base_url() . 'resource/flo/ocf/';?>js/jquery-1.10.2.min.js"></script>


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



<!--  

<?php echo $token; ?>

-->

</head>

<body role="document">
<div class="jumbotron">
	<div class="container-fluid"><img src="<?php echo base_url() . 'resource/flo/ocf/';?>images/flinders_logo.png" width="151" height="65" alt="Flinders University"></div>
</div>
<div class="container-fluid">

<h3><?php echo $activitytitle; ?> :: <?php echo $title; ?></h3>
<?php echo $pagecontent; ?>

</div>
</body>
</html>