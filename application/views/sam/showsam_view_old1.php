
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]--> 
  

 <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/sam/';?>css/tmp_flin_base_v2.css" media="all">
 
<link href="<?php echo base_url() . 'resource/sam/';?>css/tmp_flin_print.css" rel="stylesheet" media="print"/>
<link rel="stylesheet" href="<?php echo base_url() . 'resource/sam/';?>css/tmp_flin_user_styles.css" type="text/css"/>
  
<script type="text/javascript" src="<?php echo base_url() . 'resource/sam/';?>js/jslib.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'resource/sam/';?>js/jquery-1.9.1.js"></script>

<script type="text/javascript" src="<?php echo base_url() . 'resource/sam/';?>js/jquery-ui-1.10.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'resource/sam/';?>js/jquery-ui-1.10.2.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/sam/';?>css/flex-reports/jquery-ui-1.10.2.custom.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/sam/';?>css/flindersbase_local.css" media="screen">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/sam/';?>css/flindersbase_local_print.css" media="print">

<style type="text/css">
.hiddenForm {
	display: none;
	margin: 0px;
	padding: 0px;
}
.signature_img{
	max-height:200px;
	max-width:250px;
	}
</style>
<script>
$(function() {
$( "input[type=submit], input[type=button], a.button" ).button();

});
</script>
<script>

function submitMe(theID) {
	
	//alert(theID);
	theForm = 'tsearch'+theID
	
	//alert(theForm);
	
	document.getElementById(theForm).submit();
	
}

</script>

<title></title>
</head>


<body id="bodytag">
    <!--Wrapper around entire page-->
    <div id="page_wrapper">

	<!--Banner-->
    <?php if($sam_array['format']=='html'){?>
      <header class="main_header" role="banner">

        <h1>Flinders University SAM</h1>
        <div id="main_banner">
        	<img class="tagline" src="http://www.flinders.edu.au/flinders/app_templates/flinderstemplates/images/banners/inspiring_achievement.png" alt="tagline image" />
        	<a href="http://www.flinders.edu.au"><img src="http://www.flinders.edu.au/flinders/app_templates/flinderstemplates/images/flinders_logo.png" alt="Flinders logo"></a>
			
	  		
        </div>
</header><!--End Banner-->
	<?php } ?>
    
<!--Content wrapper (between header and footer) -->
<div id="page_content" class="row" style="background-color:#FFF; ">  
 <!--  page_content row wrapper -->		      
 <div class="column grid_15" style="margin-bottom: 60px;">

<!-- main content area -->
        
<div class="row">
<div class="column grid_15">  
<article role="main">
<div id="container_num_1" class="container container_no_box">
<div class="noprint">
<h1>Statement of Assessment Methods 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="importantText">
<?php echo (($sam_array['status']=='live') || (!isset($sam_array['status'])) || ($sam_array['status']==''))? '' : 'DRAFT'; ?></span></h1>
</div>
  
<!-- Content of SAM -->
 <?php if($sam_array['format']=='pdf'){?>
	<h2 style="text-align:center">Flinders University</h2>
    <h2 style="text-align:center">STATEMENT OF ASSESSMENT METHODS - 2014
    <span class="importantText" style="color:#FF0000"> <?php echo (($sam_array['status']=='live') || (!isset($sam_array['status'])) || ($sam_array['status']==''))? '' : 	'DRAFT	'; ?></span>
    </h2>
<?php } else{ ?>
<h2>STATEMENT OF ASSESSMENT METHODS - 2013</h2>
<?php } ?>

<p>Students' attention is drawn to the <em>Student Related Policies and Procedures</em> (available at: <a href="http://www.flinders.edu.au/ppmanual/student/student_home.cfm" target="_blank">http://www.flinders.edu.au/ppmanual/student/student_home.cfm</a>), which outlines the Universities Assessment Policy. </p>



<?php
 $msg = "<font color='#FF0000'> To be Added </font>";

//create function with an exception

 
function checkVal($str)
  {
  if(isset($str) || $str =='')
    {
   echo $str;
    }
 else
 {
	 echo "N/A";
	 }
  }

function setCarriageReturn($str)
{
	$order   = array("\r\n", "\n", "\r");
	$replace = '<br />';
	$newstr = str_replace($order, $replace, $str);
	echo $newstr;
}
?>

 

<!-- topic specs -->
<div id="topic_specs" class="bordertop">

  <p>Topic number and title: <strong><?php echo (!isset($sam_array['metadata']['tcode']) || ($sam_array['metadata']['tcode']=='') )?$msg:$sam_array['metadata']['tcode']; ?>
  <?php echo (!isset($sam_array['metadata']['topicTitle']) || ($sam_array['metadata']['topicTitle']=='') )?$msg:$sam_array['metadata']['topicTitle']; ?>	    
  </strong></p>
  <p>Units: <strong><?php echo (!isset($sam_array['metadata']['topicUnits']) || ($sam_array['metadata']['topicUnits']=='') )?$msg:$sam_array['metadata']['topicUnits']; ?>
  </strong>
  <p>Date on which this statement was provided to students: <strong>
  		<?php echo (!isset($sam_array['metadata']['approval']) || ($sam_array['metadata']['approval']=='') )?$msg:date('j F Y',strtotime($sam_array['metadata']['approval'])); 
		?>
        </strong></p>
  <p>Duration of topic: <strong><?php echo (!isset($sam_array['metadata']['availability'][1]['avDuration'])||($sam_array['metadata']['availability'][1]['avDuration']==''))?$msg:$sam_array['metadata']['availability'][1]['avDuration'];?></strong>
  <p>School(s) responsible for topic: <strong>
  <?php echo (!isset($sam_array['metadata']['topicSchool']))||($sam_array['metadata']['topicSchool']=='')?$msg:$sam_array['metadata']['topicSchool'];
  ?> 
  </strong> 
  
  
  
  <p>Topic Coordinator: <strong>
  <?php if(isset($sam_array['metadata']['availability'])){?>
  	<?php	foreach ($sam_array['metadata']['availability'] AS $availability ) 
		{ ?><?php echo $availability['avCoordName']; ?> <?php echo  (!isset($availability['avCoordLocation']))||($availability['avCoordLocation'] == '')?"":($availability['avCoordLocation']);?>&nbsp;&nbsp;&nbsp;&nbsp;
		<?php }}
		 else{ echo $msg;  }
		 ?></strong></p>
        
  		 <p> Telephone number of Topic Coordinator: <strong>
		 <?php if(isset($sam_array['metadata']['availability'])){?>
		 <?php foreach ($sam_array['metadata']['availability'] AS $availability ) { ?>
		 <?php echo $availability['avCoordPhone']; ?> <?php echo (!isset($availability['avCoordLocation']))||($availability['avCoordLocation'] == '')?"":($availability['avCoordLocation']);?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
         <?php
		 }
		 else{ echo $msg; }
		 ?>
         </strong></p>
  

</div>
<!-- end topic specs -->


<!-- workload -->
<div id="workload" class="bordertop">

  <p>Expected student workload* (<a href="http://www.flinders.edu.au/ppmanual/student/assessment-policy.cfm#appendixb" target="_blank">http://www.flinders.edu.au/ppmanual/student/assessment-policy.cfm#appendixb</a>): <i>number of hours per week or in total (specify).</i></p>
  <p><strong><?php echo (!isset($sam_array['metadata']['work_load']))||($sam_array['metadata']['work_load']=='')?$msg:$sam_array['metadata']['work_load']; ?></strong></p>
  <p style="font-size: 0.8em"><em>* Indicative only of the estimated minimum time commitment necessary to achieve an average grade in the topic.<br/>Expected student workload should be based on the standard student workload of approximately 30 hours of student time commitment per unit.</em></p>
</div>
<!-- end workload -->

<!-- assessable items -->
<div id="assessable" class="bordertop">

  <p>Details of assessable work in the topic. (Optional forms of assessment, where permitted, are also detailed):</p>
    <?php  
   		if(isset($sam_array['metadata']['assessment'])){
	?>
	 <table width="96%" class="aTable">
 	 <thead>
 	 <tr>
    	<th align="left" scope="col">Format of each form of assessable work</th>
   	 	<th align="left" scope="col">Proportion of total marks</th>
    	<th align="left" scope="col">Deadline for submission*</th>
    	<th align="left" scope="col">Penalties to be applied if deadline is not met</th>
    	<th align="left" scope="col">Date work is expected to be returned to students</th>
  	</tr>
  	</thead>
  <?php foreach ($sam_array['metadata']['assessment'] AS $assessment ) { ?>
 	 <tr>
    	<td align="left" valign="top"><strong>
		<?php $name = setCarriageReturn($assessment['name']);
			echo trim((!isset($name)||($name==''))?'':$name); 
		?></strong>&nbsp;
       <p> <?php
	   $format = setCarriageReturn($assessment['format']);
	    echo trim((!isset($format)||($format==''))?'':$format); 
		?>
        </p>
       
       </td>
    	<td align="left" valign="top">
		<?php 
			$proportion = setCarriageReturn($assessment['proportion']);
			echo trim((!isset($proportion)||($proportion==''))?'':$proportion);
		?>&nbsp;</td>
    	<td align="left" valign="top">
		<?php 
			$deadline = setCarriageReturn($assessment['deadline']);
		echo trim((!isset($deadline)||($deadline==''))?'':$deadline);
		?>&nbsp;</td>
  
    	<td align="left" valign="top">
		<?php 
			$penalties = setCarriageReturn($assessment['penalties']);
			echo trim((!isset($penalties)||($penalties==''))?'':$penalties);
			?></td>
            
    	<td align="left" valign="top">
		<?php 
			$return = setCarriageReturn($assessment['return']);
			echo trim((!isset($return)||($return==''))?'':$return);?></td>
	 </tr>
  <?php } ?>
</table>
<?php
   } 
   else{echo $msg;}

	?>
<br/>
* Extensions may be granted by a topic coordinator where the following criteria apply:
  <ul>
    <li style="font-size:0.8em;"><i>the student has made a written request for an extension prior to the due date for the assessment item; </i>     </li>
    <li style="font-size:0.8em;"><i>the student has justified the request on the basis of unforeseen individual circumstances that are reasonably likely to prevent completion of the assessment by the specified due date.</i> </li>
  </ul>
</div>
<!-- end assessable items -->


<!-- topic completion statement -->
<div id="completion" class="bordertop">

  <p>The criteria for successful completion of the topic (including, where appropriate, the achievement of a certain minimum level of competence in both the theoretical and practical components of the topic and details of special requirements concerning particular elements or aspects of the topic such as attendance/participation requirements, group activity) are as follows:</p>  
  <P><strong><?php echo trim(($sam_array['metadata']['pass']==''||(!isset($sam_array['metadata']['pass'])))?$msg:$sam_array['metadata']['pass']);?> </strong></P>
</div>
<!-- end topic completion statement -->


<!-- topic outcome alignment -->
<div id="topicAlignment" class="bordertop">

<p><strong>Alignment of Assessment with Expected Topic Learning Outcomes</strong></p>
 <?php  
   		if(isset($sam_array['metadata']['topicalign'])){
	?>
  <table width="96%" class="aTable">
  <thead>
  <tr>
    <th width="60%" align="left" scope="col">On completion of this topic, students will be expected to be able to:</th>
    <th width="40%" align="left" scope="col"><p>Assessment items relating to each Learning Outcome</p></th>
   
  </tr>
  </thead>
  <?php $ctr = 0; ?>
  <?php foreach ($sam_array['metadata']['topicalign'] AS $topicalignment ) { ?>
  <?php $ctr++; ?>
  <tr>
    <td align="left" valign="top">LO<?php echo $ctr; ?>: &nbsp;<?php trim(checkVal($topicalignment['name']));?></td>
    <td align="left" valign="top">
  
   <?php if(isset($topicalignment['assessment'])) { ?>
    <?php foreach ($topicalignment['assessment'] as $alignment => $asessmentItem) { ?>
    <?php echo trim($asessmentItem); ?><br />
    <?php  } ?>
    <?php  } else{ echo 'N/A';} ?>
    </td>

  </tr>
  <?php } ?>
</table>
<?php
   } 
   else{echo '';}

	?>
</div>
<!-- end topic outcome alignment -->



<!-- grad attributes -->
<?php if($sam_array['metadata']['grad_quals'] == "Yes"){ ?>
<div id="gradAttributes" class="bordertop">

<p><strong>Alignment of Assessment with Graduate Qualities (only include for topics offered in undergraduate courses)</strong></p>
 <?php  
   		if(isset($sam_array['metadata']['gradattribute'])){
	?>
  <table width="96%" class="aTable">
  <thead>
  <tr>
    <th width="60%" align="left" scope="col">Flinders University's Bachelor degree programs aim to produce graduates who:</th>
    <th width="40%" align="left" scope="col"><p>Assessment items relating to each Graduate Quality</p></th>
   
  </tr>
  </thead>
  <?php foreach ($sam_array['metadata']['gradattribute'] AS $gradattribute ) { ?>
  <tr>
    <td align="left" valign="top"><?php echo $gradattribute['code']; ?>.&nbsp;&nbsp;<?php echo trim($gradattribute['name']); ?></td>
    <td align="left" valign="top">
	<?php if(isset($gradattribute['assessment']) && count($gradattribute['assessment'])>0) { ?>
    <?php foreach ($gradattribute['assessment'] as $gradAttribute => $asessmentItem) { ?>
    <?php echo trim($asessmentItem); ?><br />
    <?php  } ?>
    <?php  } else { echo 'N/A'; } ?>
	</td>
  </tr>
  <?php } ?>
</table>
<?php
 } 
   else{echo '';}

	?>
</div>
<?php
 } 
	?>

<!-- end grad attributes -->


<!-- integrity statement -->
<div id="integrity" class="bordertop">
<p>Detection of Breaches of Academic Integrity</p>
<p>Staff may use a range of methods (including electronic means) to assist in the detection of breaches of academic integrity. In addition, the University makes available for staff and student use the electronic text matching software application <em>- Turnitin</em>.</p>
<p>Will the electronic text matching software application <em>Turnitin</em> be used? <strong>
 <?php echo trim((!isset( $sam_array['metadata']['academicIntegrity'])||( $sam_array['metadata']['academicIntegrity']==''))?"$msg": $sam_array['metadata']['academicIntegrity']); ?>
</strong></p>
<?php /*?><?php if ($sam_array['metadata']['academicIntegrity'] == 'Yes') { ?>
<?php */?><p>If Yes, students will receive a written statement describing how the software will be used and be advised about the Flinders Learning Online Academic Integrity site.</p>
<?php /*?><?php } ?>
<?php */?></div>
<!-- end integrity statement -->
<!-- scalling -->
<div id="scalling" class="bordertop">
<p>Will scaling procedures be used in determining marks for each piece of work or for determining the final topic grade?
	<strong><?php echo trim((!isset($sam_array['metadata']['scaling'])||($sam_array['metadata']['scaling']==''))?"$msg":$sam_array['metadata']['scaling']); ?></strong>
</p>
<?php /*?><?php if ($sam_array['metadata']['scaling'] == 'Yes') { ?><?php */?>
<p>Details of scaling procedures:</p>
<p><?php echo trim((!isset($sam_array['metadata']['scalingDetail'])||($sam_array['metadata']['scalingDetail']==''))?"":$sam_array['metadata']['scalingDetail']); ?></p>
<?php /*?><?php } ?><?php */?>
</div>
<!-- end integrity statement -->


<!-- resubmission statement -->
<div id="resubmission" class="bordertop">

  <p>May assessment exercises be resubmitted after revision for re-marking? <strong>
  <?php echo  trim((!isset($sam_array['metadata']['resubmissionPermitted']) || ($sam_array['metadata']['resubmissionPermitted']==''))?"$msg":$sam_array['metadata']['resubmissionPermitted']); ?>
  </strong></p>
<?php /*?>  <?php if ($sam_array['metadata']['resubmissionPermitted'] == 'Yes') { ?>
<?php */?>  <p>The circumstances under which assessment exercises may be resubmitted, the form this may take and the maximum mark obtainable are as follows:</p>
  <?php echo trim($sam_array['metadata']['resubmissionDetail']); ?>
<?php /*?>  <?php } ?>
<?php */?>

</div>
<!-- end resubmission statement -->

<!-- special consideration statement -->
<div id="consideration" class="bordertop">

<p>Students who believe that their ability to satisfy the assessment requirements for this topic has been or will be affected by medical, compassionate or other special circumstances and who want these circumstances to be taken into consideration in determining the mark for an assessment exercise may apply to the Topic Coordinator of the topic for special consideration. The preferred method of application is: <i>specify</i></p>
 <?php echo trim((!isset($sam_array['metadata']['consideration']) || ($sam_array['metadata']['consideration']==''))?"$msg":$sam_array['metadata']['consideration']); ?>
</div>
<!-- end special consideration statement -->


<!-- supplementary statement -->
<div id="supplementary" class="bordertop">
<p>Supplementary assessment for this topic may be approved on the following grounds:</p>
<ul>

<li><strong>  Medical/Compassionate</strong> &ndash; a student who is unable to sit or remain for the duration of the original examination due to medical or compassionate reasons may apply for supplementary assessment.  If illness or special circumstance prevents the student from sitting or remaining for the duration of the scheduled supplementary examination, or from submitting by the agreed deadline a supplementary assessment exercise, the student will be either: awarded a result in the topic of Withdraw, Not Fail (WN); or be offered the opportunity to demonstrate competence through an alternative mechanism.  If illness or special circumstance is demonstrated to persist up to the commencement of the next academic year, then the student will be awarded a result in the topic of WN.</li>
<li><strong>  Academic</strong> &ndash; a student will be granted supplementary assessment if he/she: achieves an overall result in the topic of between 45 and 49%, (or between 40 and 49% where a student obtains a fail grade in the last 12 units required for completion of a course) or the equivalent where percentage marks are not awarded; has completed all required work for the topic; has met all attendance requirements; and obtains at least a pass level grade in any specific component of assessment  (other than an examination) for the topic where this is explicitly stated to be a formal requirement for the successful completion of the course or topic. If illness or special circumstance prevents the student from sitting or remaining for the duration of the scheduled supplementary assessment, the student will be either: awarded a result in the topic of Withdraw, Not Fail (WN); or be offered the opportunity to demonstrate competence through an alternative mechanism. If illness or special circumstance is demonstrated to persist up to the commencement of the next academic year, then the student will be awarded a result in the topic of WN.</li>
</ul> 

</div>
<!-- end supplementary statement -->

<!-- disability statement -->
<div id="disability" class="bordertop">

<p>A student with a disability, impairment, or medical condition who seeks reasonable adjustments in the teaching or assessment methods of a topic on the basis of his/her disability may make a request to a Disability Advisor as soon as practicable after enrolment in the topic. Any such reasonable adjustments must be documented in an Access Plan and discussed between the student and the Topic Coordinator. Any reasonable adjustments must be agreed to by the Topic Coordinator and must be in accordance with related University policy. A student who is dissatisfied with the response from the Topic Coordinator or with provisions made for reasonable adjustments to teaching or assessment methods may appeal in writing to the Faculty Board. </p> 
</div>
<!-- end disability statement -->




<?php /*?><input type="button" style="margin-left:25px;" onclick="javascript:window.print();" value="Print"  /><?php */?>


<!-- approval -->
<?php /*?><div id="approval" style="margin-top:40px;">

<div class="grid_8" style="float:left; width: 60%;">
<?php
if($sam_array['format']=='pdf'){ 
	if($sam_array['metadata']['approved'] == 'Yes'){
		if(isset($sam_array['attachments_uuid']) && $sam_array['attachments_uuid'] != ''){ 
			if($sam_array['attachments_uuid'] == $sam_array['metadata']['signature_Uuid']){
?>
	<img class = "signature_img" src="<?php echo 'https://flex-dev.flinders.edu.au/file/' . $sam_array['uuid'] . '/' . $sam_array['version'] .'/' . $sam_array['attachments_name'].'/?token=' . $sam_array['url'];?>"/>
<?php 		} else{?>
		<strong> <?php echo (!isset($availability['avCoordName']) || ($availability['avCoordName']==''))?"$msg":$availability['avCoordName'];?> </strong>
<?php }} else{?>
		<strong> <?php echo (!isset($availability['avCoordName']) || ($availability['avCoordName']==''))?"$msg":$availability['avCoordName'];?> </strong>
<?php	}}else{?>
		<strong> <?php echo (!isset($availability['avCoordName']) || ($availability['avCoordName']==''))?"$msg":$availability['avCoordName'];?> </strong>
		
<?php }
	}?>
<p class="signature25" id="coordinator_signature">Signature of Topic Coordinator</p>



<?php if (($sam_array['metadata']['topicSchool'] != 'School of Computer Science, Engineering and Mathematics') && ($sam_array['metadata']['topicSchool'] != 'School of Biological Sciences') && ($sam_array['metadata']['topicSchool'] != 'School of Chemical and Physical Sciences') && ($sam_array['metadata']['topicSchool'] != 'School of the Environment')) { ?>
<p class="signature25">Signature of Course Coordinator</p>
<p style="line-height:0.6em; font-size:0.7em" class="printonly">[Faculty of Health Science Only]</p>
<?php } ?>

<p style="line-height:0.6em; font-size:0.7em; margin-top:5px;" class="printonly">DVCA:   12.11.13</p>
</div>
<div class="grid_3" style="float:right; width: 40%;">
<?php
if($sam_array['format']=='pdf'){
	if($sam_array['metadata']['approved'] == 'Yes'){
?>
<strong><?php echo (!isset($sam_array['metadata']['approvalDate']) || ($sam_array['metadata']['approvalDate']==''))?"$msg":date('j / m / Y',strtotime($sam_array['metadata']['approvalDate']));?> </strong>
<?php }} ?>
<p class="signature12">Date</p>
<br/><br/>


<?php if (($sam_array['metadata']['topicSchool'] != 'School of Computer Science, Engineering and Mathematics') && ($sam_array['metadata']['topicSchool'] != 'School of Biological Sciences') && ($sam_array['metadata']['topicSchool'] != 'School of Chemical and Physical Sciences') && ($sam_array['metadata']['topicSchool'] != 'School of the Environment')) { ?>
<p class="signature12">Date</p>
<?php } ?>


<?php
#if($sam_array['format']=='html'){
?>

</div>
<br clear="all" />
</div><?php */?>
<!-- end disability statement -->

<div>
<table style="width:100%">
	<tr style="width:100%">
    	<td style="width:60%; vertical-align:bottom; height:80px">
    	<?php
		if($sam_array['format']=='pdf'){ 
			if($sam_array['metadata']['approved'] == 'Yes'){
				?>
				<?php /*?>if(isset($sam_array['attachments_name']) && $sam_array['attachments_name'] != ''){ 
		
				<img class="signature_img" src="<?php echo 'https://flex-dev.flinders.edu.au/file/' . $sam_array['uuid'] . '/' . $sam_array['version'] .'/' . $sam_array['attachments_name'].'?method=lms&token=' . $sam_array['url'];?>"/>
                <a href="<?php echo 'https://flex-dev.flinders.edu.au/file/' . $sam_array['uuid'] . '/' . $sam_array['version'] .'/' . $sam_array['attachments_name'].'?method=lms&token=' . $sam_array['url'];?>">img link</a>
		<?php   } else{?><?php */?>
				<strong> <?php echo (!isset($availability['avCoordName']) || ($availability['avCoordName']==''))?"$msg":$availability['avCoordName'];?> </strong>
			<?php }?>
<?php	}else{?>
		<strong> <?php echo (!isset($availability['avCoordName']) || ($availability['avCoordName']==''))?"$msg":$availability['avCoordName'];?> </strong>
		
	<?php }?>
    	</td>
        
        <td style="width:40%; vertical-align:bottom; height:80px ">
        <?php if($sam_array['format']=='pdf'){
			if($sam_array['metadata']['approved'] == 'Yes'){?>
				<strong><?php echo (!isset($sam_array['metadata']['approvalDate']) || ($sam_array['metadata']['approvalDate']==''))?"$msg":date('d / m / Y',strtotime($sam_array['metadata']['approvalDate']));?> </strong>
			<?php }} ?>
        </td>
    </tr>
    
    <tr style="width:100%">
    	<td style="width:60%">
        	<p class="signature25">Signature of Topic Coordinator&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
        </td>
        <td style="width:40%">
        	<p class="signature12">Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
        </td>
    </tr>
    
    <tr>
    	<td>
        	<?php if (($sam_array['metadata']['topicSchool'] != 'School of Computer Science, Engineering and Mathematics') && ($sam_array['metadata']['topicSchool'] != 'School of Biological Sciences') && ($sam_array['metadata']['topicSchool'] != 'School of Chemical and Physical Sciences') && ($sam_array['metadata']['topicSchool'] != 'School of the Environment')) { ?>
			<p class="signature25">Signature of Course Coordinator</p>
			<p style="line-height:0.6em; font-size:0.7em" class="printonly">[Faculty of Health Science Only]</p>
			<?php } ?>
        </td>
        <td>
        <?php if (($sam_array['metadata']['topicSchool'] != 'School of Computer Science, Engineering and Mathematics') && ($sam_array['metadata']['topicSchool'] != 'School of Biological Sciences') && ($sam_array['metadata']['topicSchool'] != 'School of Chemical and Physical Sciences') && ($sam_array['metadata']['topicSchool'] != 'School of the Environment')) { ?>
<p class="signature12">Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
		<?php } ?>
        </td>
    </tr>
    
    <tr>
    <td>
    <p style="line-height:0.6em; font-size:0.7em; margin-top:5px;" class="printonly">DVCA:   12.11.13</p>
    </td>
    <td>
    </td>
    </tr>

</table>
</div>
</div> <!-- end conatiner_num_1 -->

</article>

</div>
</div> <!-- end main content area --> 

</div>
<?php /*?> <br clear="both" />   <?php */?>    
  <!-- footerv2 -->
</div>
<?php if($sam_array['format']=='html'){?>
<div class="row" id="appfooter">
    <div class="app_footer" style="background-image:url(<?php echo base_url() . 'resource/sam/images/gold/footer_app_bg.jpg';?>); height:30px; width:1060px;  position:fixed; bottom: 0px;">
     <span style="float:left; padding: 10px 0 0 5px;">CRICOS Provider: 00114A </span>
     <div style="float:right; padding:5px;"> <img src="<?php echo base_url() . 'resource/sam/images/gold/inspiring_achievement_footer.png';?> "/></div>
    </div> 
</div>  <!-- end of row -->
      <!-- end of footerv2 -->
 
    </div> <!-- pagewrapper --> 
<?php } ?>
</body>
</html>