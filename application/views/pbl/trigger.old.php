<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />


<?php

//$caseTitle = $basic['name'];

//echo $caseTitle;

?>


<title>Case Trigger - <?php echo  $basic['name']; ?></title>



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



<link href="<?php echo base_url() . 'resource/pbl/';?>css/FU_PBL_Large.css" rel="stylesheet" type="text/css" />
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/pbl/';?>css/bootstrap.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/pbl/';?>css/bootstrap-theme.css">


<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->



<!-- Latest compiled and minified JavaScript -->
 
    
<script src="<?php echo base_url() . 'resource/pbl/';?>js/jquery-1.10.2.min.js"></script>


<script src="<?php echo base_url() . 'resource/pbl/';?>js/jquery-ui-1.10.3.custom.min.js"></script>


<script src="<?php echo base_url() . 'resource/pbl/';?>js/bootstrap.js"></script>  


<script>
	$(function() {

	
		$( "#dialog-message" ).dialog({
			modal: true,
			closeOnEscape: false,
			autoOpen: false,
			width: 700,
			height: 400,
			open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
			
			
			buttons: {
				Ok: function() {
					

						   
					$( this ).dialog( "close" );
				

				}
			}
		});
	});
</script>



<script>

function studentInfo()
{
	
	//$('#dialog-message').dialog('open');
	

}
</script>

<script language="JavaScript">



function myLoader() {
	
	
	resizeTo(1280,780);
	
	
	window.focus();


}

</script>


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
	font-size: 140%;
}
.red {color: #CC0000}
h4 {
	font-size: 25px;
	font-weight: bold;
}
-->
</style>





</head>
<body  onLoad="myLoader();">

<div id="header">
  <h3 align="center">PBL Case: <?php echo  $basic['name']; ?></h3>
</div>

<?php

foreach ($files['attachments'] as $attachment)  {
	
	
	$trigger = stripos($attachment['description'], 'case trigger');
	
	if ($trigger !== false && $attachment['type'] == 'file') {
		
		
		$imgLink = $attachment['links']['view'];
		
		$imgFile = $attachment['filename'];
		
		
		
		
	}
	
	
	
}


?>


 <div align="center">


<img name="" src="<?php echo $imgLink; ?>&token=<?php echo $token; ?>">

  </div>
  <div style="width:100%; text-align:center;">
     <div style="display:inline-block;">
   <div class="column grid_3">
   <div class="home_info_button charcoal_gradient">
   <span style="font-size: 1.2em;"><a href="/flex/pbl/case/<?php echo  $basic['uuid']; ?>/<?php echo  $basic['version']; ?>">Begin Case</a></span>
   </div>
   </div>
</div>
</div>

<!--

   <div id="dialog-message" title="Important information for students">
  <h1 class="important">
	<span class="ui-icon ui-icon-alert" style="float:left; margin: 2px 7px 10px 0;"></span>
		Please check your timetable
	</h1>
	<p style="clear:left">Teaching events in MyMedCourse <strong>are not synchronised to the timetable</strong>, and as such may not always be updated when changes are made.</p>
	<p>Although all efforts are made to keep this up to date, there are occasions where this is not always possible.<span class="important"><strong> Students should always check the timetable for the most up to date version of when sessions are scheduled</strong></span>.</p>
</div>
-->

</body>
</html>