<?php

//print_r($handout);

//exit;


$ajaxLoad = "https://flextra.flinders.edu.au/flex/pbl/tutor/";
$ajaxLoad .= $handout['uuid'];
$ajaxLoad .= "/";
$ajaxLoad .= $handout['version'];
$ajaxLoad .= " #";
$ajaxLoad .= $handout['id'];

//echo rawurlencode($ajaxLoad); 

//exit;
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Handout</title>
<link href="<?php echo base_url() . 'resource/pbl/';?>css/FU_PBL_Handout.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() . 'resource/pbl/';?>css/FU_PBL_print_2008.css" rel="stylesheet" type="text/css" media="print" />

<script type="text/javascript" src="<?php echo base_url() . 'resource/pbl/';?>js/jquery-1.10.2.min.js"></script>


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