<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Tutor Guide - <?php echo $case['caseTitle']; ?></title>
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

  <h1 style="margin-top: 2cm; margin-bottom: 2cm;">&nbsp;</h1>
  <table cellpadding="0" cellspacing="0" class="PBL_Cover">
    <tr>

      <td align="center" valign="top"><h1><?php echo $case['caseTitle']; ?></h1>
    
        <p><img src="<?php echo base_url() . 'resource/flo/pbl/';?>images/new_crest.gif" alt="crest" width="184" height="200" /></p>
        </td>
    </tr>

  </table>
<h3>Tutor Guide</h3>
 
  </div>
  
  <p class="pageBreak">&nbsp;</p>

    <h3 class="tutor_notes_heading">Abstract</h3>
  <?php echo $case['caseDescription']; ?>
  
      <h3 class="tutor_notes_heading">Keywords, phrases</h3>
  <?php echo $case['caseKW']; ?>
 <!-- 
   <div class="pageBreak"><span class="tutor_notes_heading">Learning Objectives for the Week</span>
     <p style="margin-top: 2cm; margin-bottom: 2cm;">THIS SECTION TO BE DEVELOPED AS PART OF  <em>ACTIVITIES</em></p>
  
  </div>
  -->
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

<div class="student">
<div class="studentBox">


<!-- table to simulate screen heading -->

 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="screenHeading" >
<tr>
<td width="35%" align="left" valign="middle" class="scr_heading"><?php 
				   

	
	echo stripslashes($case['caseTitle']);

?></td>
<td width="30%" align="center" valign="middle" class="scr_heading">Tutorial <?php echo $screen['tutorial']; ?></td>
<td width="35%" align="right" valign="middle" class="scr_heading">Screen <?php echo $screen['screenNumber']; ?></td>
                 </tr>
               </table>
               
<div class="pg_heading"><?php echo $screen['screenName']; ?></div>               
<?php echo html_entity_decode($screen['text']); ?>

</div>
</div>

<?php }  // end student text display ?>

<?php if ($screen['use'] == "Tutor") { // ie, tutor text?>
<div class="tutorNotes">
<img name="" src="<?php echo base_url() . 'resource/flo/pbl/';?>images/icons/<?php echo $screen['icon']; ?>" width="32" height="32" alt="<?php echo $screen['iconName']; ?>" style="vertical-align:middle" />
<span class="tutor_notes_heading"><?php echo $screen['screenName']; ?></span>
<?php echo html_entity_decode(stripslashes($screen['text'])); ?>

</div>
<?php } ?>
 
<?php

$prevtute = $thistute;



  } ?>


  </div>
</body>
</html>