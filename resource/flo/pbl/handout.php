<?php



$ajaxLoad = "https://flextra.flinders.edu.au/flex/pbl/tutor/";
$ajaxLoad .= $_GET['uuid'];
$ajaxLoad .= "/";
$ajaxLoad .= $_GET['version'];
$ajaxLoad .= " #";
$ajaxLoad .= $_GET['handoutid'];

//echo rawurlencode($ajaxLoad); 

//exit;
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Handout</title>
<link href="https://flextra.flinders.edu.au/flex/resource/pbl/FU_PBL_Handout.css" rel="stylesheet" type="text/css" />


<script type="text/javascript" src="https://flextra.flinders.edu.au/flex/resource/pbl/js/jquery-1.10.2.min.js"></script>


<script type="text/javascript">
$(document).ready(function() {


var url = decodeURIComponent('<?php echo rawurlencode($ajaxLoad); ?>');
//alert(url);

$('#content').load(url);

});


</script>

<style type="text/css">
<!--
.handoutonly {
	margin-top: 5em;
	display: block;
	visibility: visible;
	font-size: 0.8em;
	font-style:italic;
	
}



@media print {
	
	
	.handoutonly {
	margin-top: 5em;
	display: block;
	visibility: visible;
	font-size: 0.8em;
	font-style:italic;

}

	
	
}
-->
</style>

</head>

<body>
<div id="content"></div>
</body>
</html>