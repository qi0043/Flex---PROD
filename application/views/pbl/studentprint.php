<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>PBL Case: <?php echo $case['caseTitle']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">


<link href="<?php echo base_url() . 'resource/flo/pbl/';?>css/FU_PBL_print_2008.css" rel="stylesheet" type="text/css" />

</head>



<?php

foreach ($files['attachments'] as $attachment)  {
	
	
	$trigger = stripos($attachment['description'], 'cover photo');
	
	if ($trigger !== false && $attachment['type'] == 'file') {
		
		
		$imgLink = $attachment['links']['view'];
		
		$imgFile = $attachment['filename'];
		
		
		
		
	}
	
	
	
}


?>


<body>

<div class="SOMRMS_SCREEN">
  <div align="center">
    <table cellpadding="0" cellspacing="0" class="PBL_Cover">
      <tr>

      <td align="center" valign="top"><h1><?php echo $case['caseTitle']; ?></h1>
 
        <p><img src="<?php echo base_url() . 'resource/flo/pbl/';?>images/new_crest.gif" alt="crest" width="184" height="200" /></p>
        </td>
    </tr>
    <tr>    <td align="center" valign="top"><h2>Student Print</h2>
 

        </td></tr>

</table>

 
  </div>
  
  
  
  



  
<!--  
<pre>

<?php print_r($case['screens']); ?>


</pre>



 --> 



<?php 

$thistute = '';
$prevtute = '';
?>

<?php 

foreach ($case['screens'] AS $screen) {   

$thistute = $screen['tutorial']; 

if ($thistute != $prevtute) {  ?>

<h2 class="pageBreak"> Tutorial <?php echo $screen['tutorial'] ; ?></h2>

<?php } ?>

<?php if ($screen['use'] == "Student") { // ie, student text?>



<p style="font-size:0.75em;">Tutorial <?php echo $screen['tutorial']; ?> :: Screen <?php echo $screen['screenNumber']; ?></p>
<p style="font-weight:bold; text-transform:uppercase;"><img name="" src="<?php echo base_url() . 'resource/flo/pbl/';?>images/icons/<?php echo $screen['icon']; ?>" width="24" height="24" alt="<?php echo $screen['iconName']; ?>" style="vertical-align:middle" />&nbsp;&nbsp;<?php echo $screen['screenName']; ?> </p>      
<?php echo html_entity_decode($screen['text']); ?>



<?php }  // end student text display ?>


 
<?php

$prevtute = $thistute;



  } ?>


  </div>
</body>
</html>