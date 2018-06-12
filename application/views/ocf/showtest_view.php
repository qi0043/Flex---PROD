<?php
	
	

?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]--> 


  
  
<link media="screen" rel="stylesheet" href="http://www.flinders.edu.au/flinders/app_templates/flinderstemplates/tmp_flin_base_v2.css" type="text/css"/> 
  
<link href="http://www.flinders.edu.au/flinders/app_templates/flinderstemplates/tmp_flin_print.css" rel="stylesheet" media="print"/>
  <link rel="stylesheet" href="http://www.flinders.edu.au/flinders/app_templates/flinderstemplates/tmp_flin_user_styles.css" type="text/css"/>
  <script type="text/javascript" src="http://www.flinders.edu.au/flinders/app_templates/flinderspagelets/content/jslib.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'resource/sam/';?>js/jquery-1.9.1.js"></script>

<script type="text/javascript" src="<?php echo base_url() . 'resource/sam/';?>js/jquery-ui-1.10.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'resource/sam/';?>js/jquery-ui-1.10.2.custom.min.js"></script>
<link href="<?php echo base_url() . 'resource/sam/';?>css/flex-reports/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />


<link href="<?php echo base_url() . 'resource/sam/';?>css/flindersbase_local.css" rel="stylesheet" type="text/css" media="screen"> 
<link href="<?php echo base_url() . 'resource/sam/';?>css/flindersbase_local_print.css" rel="stylesheet" type="text/css" media="print">

<style type="text/css">
.hiddenForm {
	display: none;
	margin: 0px;
	padding: 0px;
}
</style>
<script>
$(function() {
$( "input[type=submit], input[type=button], a.button" )
.button()

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



<script type="text/javascript"> 
    function myalert(){
        alert('<?php echo $sam_string?>');
    }
 
    $(document).ready(function() {
        alert('<?php echo $sam_string?>');
    });
    
</script>




<title>Flextra::SAMS</title>
</head>
<body id="bodytag">
    <!--Wrapper around entire page-->
    <div id="page_wrapper">

	<!--Banner-->
      <header class="main_header" role="banner">

          
        <h1>Flinders University SAM</h1>
        <div id="main_banner">
          <img class="tagline" src="http://www.flinders.edu.au/flinders/app_templates/flinderstemplates/images/banners/inspiring_achievement.png" alt="tagline image"><a href="http://www.flinders.edu.au"><img src="http://www.flinders.edu.au/flinders/app_templates/flinderstemplates/images/flinders_logo.png" alt="Flinders logo"></a>
        </div>
</header><!--End Banner-->
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
<h1>Statement of Assessment Methods <span class="importantText">PROOF OF CONCEPT ONLY</span></h1>
</div>
<?php
// display before search
	if (false)
	{ ?>

<!-- search div -->
<div id="search">
<h2>Choose Topic</h2>
<form method="post" action="index.php"  class="mainForm1" id="login">
<fieldset>
<legend>Display SAM for Topic</legend>
<label for="showSAM">SAMs available</label>
<select id="showSAM" name="showSAM">
<option value="">Choose…</option>
<?php foreach ($samlistResultsXml->nodeList('/results/result') as $samTopics) { ?>
<option value="<?php echo $samlistResultsXml->nodeValue('xml/item/@id', $samTopics); ?>"><?php echo $samlistResultsXml->nodeValue('xml/item/uni/topic/used_in/topics/code', $samTopics); ?>: <?php echo $samlistResultsXml->nodeValue('xml/item/uni/topic/used_in/topics/title', $samTopics); ?></option>
<?php } ?>
</select>
 <input name="onlylive" type="hidden" value="1" />
 <br />
 <input name="search" type="submit"  value="Display SAM" />
</fieldset> 
</form>	
</div> 

  <!-- end search div -->
  <?php } // end display before search ?>
  
  
  <?php
// display after search
	if (true)
	{ ?>
  <?php

?>

<?php
/***********************************/
	// display results
$samsArray[1] = $sam_array['metadata'];
#echo $sam_string;
	#$samsArray = samsForTopic($searchResultsXml); 
	/*
	echo '<pre>';
	print_r($samsArray);
	echo '</pre>';
	
	exit;
	
	 */
	  
	//printf("\n");
?>




  
  <!-- Content of SAM -->
<h2>STATEMENT OF ASSESSMENT METHODS - 2013</h2>
<p>Students' attention is drawn to the <em>Student Related Policies and Procedures Manual 2013</em> (<a href="http://www.flinders.edu.au/ppmanual/student/student_home.cfm" target="_blank">http://www.flinders.edu.au/ppmanual/student/student_home.cfm</a>), which outlines the University’s Assessment Policy. </p>


<!-- topic specs -->
<div id="topic_specs" class="bordertop">

  <p>Topic number and title: <strong><?php echo $samsArray[1]['tcode']; ?> <?php echo $samsArray[1]['topicTitle']; ?></strong></p>
  <p>Units: <strong><?php echo $samsArray[1]['topicUnits']; ?></strong></p>
  <p>Date on which this statement was provided to students: <strong><?php echo date('j F, Y',strtotime($samsArray[1]['approval'])); ?></strong></p>
  <p>Duration of topic: <strong><?php echo $samsArray[1]['availability'][1]['avDuration']; ?></strong></p>
  <p>School(s) responsible for topic: <strong><?php echo $samsArray[1]['topicSchool']; ?></strong></p>
  
  
  <p>Topic Coordinator: <strong><?php foreach ($samsArray[1]['availability'] AS $availability ) { ?><?php echo $availability['avCoordName']; ?> (<?php echo $availability['avCoordLocation']; ?>)&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?></strong></p>
  <p> Telephone number of Topic Coordinator: <strong><?php foreach ($samsArray[1]['availability'] AS $availability ) { ?><?php echo $availability['avCoordPhone']; ?> (<?php echo $availability['avCoordLocation']; ?>)&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?></strong></p>
  

</div>
<!-- end topic specs -->


<!-- workload -->
<div id="workload" class="bordertop">

  <p>Expected student workload* (<a href="http://www.flinders.edu.au/ppmanual/student/assessment-policy.cfm#appendixb" target="_blank">http://www.flinders.edu.au/ppmanual/student/assessment-policy.cfm#appendixb</a>): number of hours per week or in total (specify).</p>
  <p style="font-size: 0.8em"><em>* Indicative only of the estimated minimum time commitment necessary to achieve an average grade in the topic. Expected student workload should be based on the standard student workload of approximately 30 hours of student time commitment per unit.</em></p>
</div>
<!-- end workload -->

<!-- assessable items -->
<div id="assessable" class="bordertop">

  <p>Details of assessable work in the topic. (Optional forms of assessment, where permitted, are also detailed):</p>
  <table width="96%" class="aTable">
  <tr>
    <th align="left" scope="col">Format of each form of assessable work</th>
    <th align="left" scope="col"><p>Proportion of total marks</p></th>
    <th align="left" scope="col">Deadline for submission*</th>
    <th align="left" scope="col">Penalties to be applied if deadline is not met</th>
    <th align="left" scope="col">Date work is expected to be returned to students</th>
  </tr>
  
  <?php foreach ($samsArray[1]['assessment'] AS $assessment ) { ?>
  <tr>
    <td align="left" valign="top"><?php echo $assessment['name']; ?>&nbsp;</td>
    <td align="left" valign="top"><?php echo $assessment['proportion']; ?>&nbsp;</td>
    <td align="left" valign="top"><?php echo $assessment['deadline']; ?>&nbsp;</td>
    <td align="left" valign="top"><?php echo $assessment['penalties']; ?>&nbsp;</td>
    <td align="left" valign="top"><?php echo $assessment['return']; ?>&nbsp;</td>
  </tr>
  <?php } ?>
</table>
 <p style="font-size:0.8em;">* Extensions may be granted by a topic coordinator where the following criteria apply:</p>
  <ul>
    <li style="font-size:0.8em;">the student has made a written request for an extension prior to the due date for the assessment item;      </li>
    <li style="font-size:0.8em;">the student has justified the request on the basis of unforeseen individual circumstances that are reasonably likely to prevent completion of the assessment by the specified due date. </li>
  </ul>
</div>
<!-- end assessable items -->


<!-- topic completion statement -->
<div id="completion" class="bordertop">

  <p>The criteria for successful completion of the topic (including, where appropriate, the achievement of a certain minimum level of competence in both the theoretical and practical components of the topic and details of special requirements concerning particular elements or aspects of the topic such as attendance/participation requirements, group activity) are as follows:</p>
<?php echo $samsArray[1]['pass']; ?>
</div>
<!-- end topic completion statement -->


<!-- topic outcome alignment -->
<div id="topicAlignment" class="bordertop">

<p><strong>Alignment of Assessment with Expected Topic Learning Outcomes</strong></p>
  <table width="96%" class="aTable">
  <tr>
    <th width="60%" align="left" scope="col">On completion of this topic, students will be expected to be able to:</th>
    <th width="40%" align="left" scope="col"><p>Assessment items relating to each Learning Outcome</p></th>
   
  </tr>
  <?php $ctr = 0; ?>
  <?php foreach ($samsArray[1]['topicalign'] AS $topicalignment ) { ?>
  <?php $ctr++; ?>
  <tr>
    <td align="left" valign="top">LO<?php echo $ctr; ?>: <?php echo $topicalignment['name']; ?>&nbsp;</td>
    <td align="left" valign="top">
    
    <?php if(count($topicalignment['assessment']) > 0) { ?>
    <?php foreach ($topicalignment['assessment'] as $alignment => $asessmentItem) { ?>
    <?php echo $asessmentItem; ?><br />
    
    <?php  } ?>
    <?php  } ?>
    &nbsp;</td>

  </tr>
  <?php } ?>
</table>

</div>
<!-- end topic outcome alignment -->


<!-- grad attributes -->
<div id="gradAttributes" class="bordertop">

<p><strong>Alignment of Assessment with Graduate Qualities (only include for topics offered in postgraduate courses)</strong></p>
  <table width="96%" class="aTable">
  <tr>
    <th width="60%" align="left" scope="col">Flinders University’s Bachelor degree programs aim to produce graduates who:</th>
    <th width="40%" align="left" scope="col"><p>Assessment items relating to each Graduate Quality</p></th>
   
  </tr>
  <?php foreach ($samsArray[1]['gradattribute'] AS $gradattribute ) { ?>
  <tr>
    <td align="left" valign="top"><?php echo $gradattribute['code']; ?>&nbsp;<?php echo $gradattribute['name']; ?></td>
    <td align="left" valign="top">
	<?php if(isset($gradattribute['assessment']) && count($gradattribute['assessment']) > 0) { ?>
    <?php foreach ($gradattribute['assessment'] as $gradAttribute => $asessmentItem) { ?>
    <?php echo $asessmentItem; ?><br />
    
    <?php  } ?>
    <?php  } ?>&nbsp;</td>

  </tr>
  <?php } ?>
</table>

</div>
<!-- end grad attributes -->


<!-- integrity statement -->
<div id="integrity" class="bordertop">
<p>Detection of Breaches of Academic Integrity</p>
<p>Staff may use a range of methods (including electronic means) to assist in the detection of breaches of academic integrity. In addition, the University makes available for staff and student use the electronic text matching software application – <em>Turnitin</em>.</p>
<p>Will the electronic text matching software application <em>Turnitin</em> be used? <strong><?php echo $samsArray[1]['academicIntegrity']; ?></strong></p>
<p>If Yes, students will receive a written statement describing how the software will be used and be advised about the Flinders Learning Online Academic Integrity site.</p>
</div>
<!-- end integrity statement -->


<!-- resubmission statement -->
<div id="resubmission" class="bordertop">

  <p>May assessment exercises be resubmitted after revision for re-marking? <strong><?php echo $samsArray[1]['resubmissionPermitted']; ?></strong></p>
  <?php if ($samsArray[1]['resubmissionPermitted'] == 'Yes') { ?>
  <p>The circumstances under which assessment exercises may be resubmitted, the form this may take and the maximum mark obtainable are as follows:</p>
  <?php echo $samsArray[1]['resubmissionDetail']; ?>
  <?php } ?>
</div>
<!-- end resubmission statement -->

<!-- special consideration statement -->
<div id="consideration" class="bordertop">

<p>Students who believe that their ability to satisfy the assessment requirements for this topic has been or will be affected by medical, compassionate or other special circumstances and who want these circumstances to be taken into consideration in determining the mark for an assessment exercise may apply to the Topic Coordinator of the topic for special consideration.</p>

<p>The preferred method of application is:</p>

  <?php echo $samsArray[1]['consideration']; ?>
</div>
<!-- end special consideration statement -->


<!-- supplementary statement -->
<div id="supplementary" class="bordertop">
<p>Supplementary assessment for this topic may be approved on the following grounds:</p>
<ul>

<li><strong>Medical/Compassionate </strong>– a student who is unable to sit or remain for the duration of the original examination due to medical or compassionate reasons may apply for supplementary assessment.  If illness or special circumstance prevents the student from sitting or remaining for the duration of the scheduled supplementary examination, or from submitting by the agreed deadline a supplementary assessment exercise, the student will be either: awarded a result in the topic of Withdraw, Not Fail (WN); or be offered the opportunity to demonstrate competence through an alternative mechanism.  If illness or special circumstance is demonstrated to persist up to the commencement of the next academic year, then the student will be awarded a result in the topic of WN.</li>
<li><strong>Academic</strong> – a student will be granted supplementary assessment if he/she: achieves an overall result in the topic of between 45 and 49%, (or between 40 and 49% where a student obtains a fail grade in the last 12 units required for completion of a course) or the equivalent where percentage marks are not awarded; has completed all required work for the topic; has met all attendance requirements; and obtains at least a pass level grade in any specific component of assessment  (other than an examination) for the topic where this is explicitly stated to be a formal requirement for the successful completion of the course or topic. If illness or special circumstance prevents the student from sitting or remaining for the duration of the scheduled supplementary assessment, the student will be either: awarded a result in the topic of Withdraw, Not Fail (WN); or be offered the opportunity to demonstrate competence through an alternative mechanism. If illness or special circumstance is demonstrated to persist up to the commencement of the next academic year, then the student will be awarded a result in the topic of WN.</li>
</ul> 

</div>
<!-- end supplementary statement -->

<!-- disability statement -->
<div id="disability" class="bordertop">

<p>A student with a disability, impairment, or medical condition who seeks reasonable adjustments in the teaching or assessment methods of a topic on the basis of his/her disability may make a request to the Topic Coordinator or the Disability Advisor as soon as practicable after enrolment in the topic. Any such reasonable adjustments must be agreed in writing between the student and the Topic Coordinator and must be in accordance with related University policy. A student who is dissatisfied with the response from the Topic Coordinator or with provisions made for reasonable adjustments to teaching or assessment methods may appeal in writing to the Faculty Board.</p> 
</div>
<!-- end disability statement -->


<div class="noprint">
<input type="button" onclick="javascript:window.location.href='index.php'" value="Search again"  /><input type="button" style="margin-left:25px;" onclick="javascript:window.print();" value="Print"  />
</div>

<!-- approval -->
<div id="approval" style="margin-top:50px;">

<div class="grid_8" style="float:left; width: 65%;">
<p class="signature25">Signature of Topic Coordinator</p>
<p class="signature25">Signature of Course Coordinator</p>
<p style="line-height:0.6em; font-size:0.7em" class="printonly">[Faculty of Health Science Only]</p>
<p style="line-height:0.6em; font-size:0.7em; margin-top: 15px;" class="printonly">DVCA:   27.11.12</p>
</div>
<div class="grid_3" style="float:right; width: 30%;">
<p class="signature12">Date</p>
<p class="signature12">Date</p>

</div>
<br clear="all" />
</div>
<!-- end disability statement -->


<?php } // end display after search ?>


</div> <!-- end conatiner_num_1 -->


</article>
</div>
</div> <!-- end main content area --> 

</div> <!-- end page_content row wrapper -->  
</div>
 <br clear="both" />       
  <!-- footerv2 -->
<div class="row" id="appfooter">
    <div class="app_footer" style="background-image:url(../gold/footer_app_bg.jpg); height:30px; width:1060px;  position:fixed; bottom: 0px;">
     <span style="float:left; padding: 10px 0 0 5px;">CRICOS Provider: 00114A </span>
     <div style="float:right; padding:5px;"> <img src="../gold/inspiring_achievement_footer.png" /></div>
    </div> 
</div>  <!-- end of row -->
      <!-- end of footerv2 -->
 
    </div> <!-- pagewrapper --> 
</body>

</body>