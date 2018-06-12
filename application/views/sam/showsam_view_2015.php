
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="" lang="">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]--> 
      
    
     <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/sam/';?>css/tmp_flin_base_v2.css" media="all">
     
    <link href="<?php echo base_url() . 'resource/sam/';?>css/tmp_flin_print.css" rel="stylesheet" media="print"/>
    <link rel="stylesheet" href="<?php echo base_url() . 'resource/sam/';?>css/tmp_flin_user_styles.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/sam/';?>css/flex-reports/jquery-ui-1.10.2.custom.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/sam/';?>css/flindersbase_local.css" media="screen">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/sam/';?>css/flindersbase_local_print.css" media="print">
    
    <script type="text/javascript" src="<?php echo base_url() . 'resource/sam/';?>js/jslib.js"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'resource/sam/';?>js/jquery-1.9.1.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url() . 'resource/sam/';?>js/jquery-ui-1.10.2.custom.js"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'resource/sam/';?>js/jquery-ui-1.10.2.custom.min.js"></script>
    
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
        
    .table_coordinators tr, .table_coordinators td, .table_coordinators{
        margin-bottom: 8px;
        margin-top: 0px;
        padding: 0;
        border: 0;
        outline: 0;
        border-spacing: 0;
        text-align: left;
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
    <?php $avail_ref = $sam_array['avail_ref']; ?>
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
<h1 style="text-align:center"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Statement of Assessment Methods 

<span class="importantText">
   <?php  $status = $sam_array['status'];
		  if(isset($status)){?>
			<?php echo ($status=='live')? '' : '&nbsp;&nbsp;&nbsp;&nbsp;DRAFT'; 
		 }?>
         
</span>
</h1>
</div>
  
<!-- Content of SAM -->
 <?php if($sam_array['format']=='pdf'){?>
	<h2 style="text-align:center">Flinders University</h2>
    <h2 style="text-align:center">STATEMENT OF ASSESSMENT METHODS - 2015 
 
           <?php
		    $status = $sam_array['status'];
		  	$approval = $sam_array['metadata']['approved'];
		   if(isset($status) && isset($approval)){
	 ?>
    <span class="importantText" style="color:#FF0000"> <?php echo ($status=='live') ? '' : 	'DRAFT	'; ?>
    </span>
    <?php } 
	else {?>
   	    <span class="importantText" style="color:#FF0000">
    	<?php echo 'DRAFT';}?>
    	</span>
    
<?php } else{ ?>
<h2 style="text-align:center">STATEMENT OF ASSESSMENT METHODS - 2015 </h2>
<?php } ?>
</h2>
<p>Students' attention is drawn to the <em>Student Related Policies and Procedures</em> (available at: <a href="http://www.flinders.edu.au/ppmanual/student/student_home.cfm" target="_blank">http://www.flinders.edu.au/ppmanual/student/student_home.cfm</a>), which outlines the Universities Assessment Policy. </p>



<?php
 $msg = "<font color='#FF0000'><strong> To be Added </strong></font>";
 $draft_msg = "<font color='#FF0000'> Will be added after moderation is complete </font>";

//create function with an exception

if (!function_exists('checkVal')) {
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
}

if (!function_exists('setCarriageReturn')) {
function setCarriageReturn($str)
{
	$order   = array("\r\n", "\n", "\r");
	$replace = '<br />';
	$newstr = str_replace($order, $replace, $str);
	echo $newstr;
}
}
?>

 

<!-- topic specs -->
<div id="topic_specs" class="bordertop">




  <?php
  	$topic_code;
	$topic_name;
	
	if($sam_array['metadata']['version_definition']  != '2014 version 2')
	{
		echo '<p>Topic number and title: <strong>';
		foreach ($sam_array['metadata']['topics'] AS $topic){ 
		$topic_code[$topic['tcode']] = $topic['tcode'];
		$topic_name[$topic['tcode']] = $topic['topicTitle'];
	}
	echo implode('/', $topic_code);
    ?>
   <?php
	echo implode('/', $topic_name);
	?>
    <?php 
	$arr_location = array();
    if(strtoupper($sam_array['metadata']['multiple']) == 'YES')
	{
		if(isset($sam_array['metadata']['availability']))
		{
			foreach ($sam_array['metadata']['availability'] AS $avail){
				if($avail['avRef'] == $avail_ref){
				   $location = $avail['avLocation_code'];
				   if($location == 'DE'){
					  echo(' (Distance Ed, External)');
				   }
				   elseif($location == 'U')
				   {
					  echo('');
				   }
				   else
				   {
					   echo('('.$location.')');
				   }  
				   break;
				}
			}
		}
	}
	else
	{
		if(isset($sam_array['metadata']['availability']))
		{
			foreach ($sam_array['metadata']['availability'] AS $avail){
				array_push($arr_location, $avail['avLocation_code']);
			}
			echo implode(',', array_unique($arr_location));
		}
	}
	}
	else
	{
		$availCodes = array();
		$loc = array();
		$name = array();
		$ver = array();
	
	
	if(strtoupper($sam_array['metadata']['multiple']) == 'YES')
	{
		echo '<p>Topic number and title: ';
		$code = '';
		$name = '';
		if(isset($sam_array['metadata']['availability'])){
			foreach ($sam_array['metadata']['availability'] AS $avail){
				if($avail['avRef'] == $avail_ref){
				   $code = $avail['topic_code'];
				   $name = $avail['topic_name'];
				   $location_display = '';
				   $version = (int)$avail['avVersion'];
				   if($version >1)
				   {
					   $location_display = $avail['avLocation'] . '['. $version . ']';
				   }
				   else
				   {
					   $location_display = $avail['avLocation'];
				   }
				   break;
				}
			}
		
	  	 echo '<strong>' . $code . ' ' . $name . '</strong> <i>' . $location_display . '</i>';
	   }
	   echo '</p>';	
	}
	else
	{
		if(isset($sam_array['metadata']['availability'])){
		  foreach ($sam_array['metadata']['availability'] AS $avail){
			  array_push($availCodes, $avail['topic_code']);
		  }
		  foreach(array_unique($availCodes) AS $availCode)
		  {
			  foreach ($sam_array['metadata']['availability'] AS $i =>$avail){
				  if($avail['topic_code'] == $availCode)
				  {
					  $name[$availCode][$avail['topic_name']] = $avail['topic_name'];
					  $version = $avail['avVersion'];
					  $loc[$availCode][$avail['avLocation']] = $avail['avLocation'] ;
					  if($version >1)
					  {
						  $ver[$availCode][$avail['avLocation']][$version] = $version;
					  }
				  }
			  }
		  }
		}
		
     ?>
     
     <table class="table_coordinators">
     <tr>
     <?php 

	 	if(isset($availCode) && count(array_unique($loc[$availCode]))>=2)
	 	{?>
     
         <td rowspan = "<?php echo count(array_unique(array_unique($availCodes))) * 2;?>" style="vertical-align:top; white-space: nowrap">
            Topic number and title: &nbsp;
         </td>
        <?php 
	    }
		 else{?>
		 <td rowspan = "<?php echo count(array_unique(array_unique($availCodes)));?>" style="vertical-align:top; white-space: nowrap">
			Topic number and title: &nbsp;
		 </td>
		 <?php }
	   ?>
     
    <?php  
		foreach(array_unique($availCodes) AS $availCode)
		{
			echo "<td style='white-space: nowrap'>";
			echo '<strong>'.$availCode . ' '. implode(' ', array_unique($name[$availCode])) . '</strong>';
			$str = $availCode . ' '. implode(' ', array_unique($name[$availCode]));
			 
			echo '</td>';
			
			if(strlen($str) < 60)
			{
				if(count(array_unique($loc[$availCode]))>=2 && count(array_unique($loc[$availCode]))<=3)
				{
					#echo '</tr><tr><td><i>' . implode(',', array_unique($loc[$availCode]));
					echo '<td><i>';
					$i = 0;
					$len = count(array_unique($loc[$availCode]));
					foreach(array_unique($loc[$availCode]) AS $availloc)
					{
						if($i==0)
						{
							echo '&nbsp;'.$availloc ;
						}
						else
						{
							echo ', ' .$availloc  ;
						}
						if(isset($ver[$availCode][$availloc]))
						{   
							echo '[';
							echo implode(',', array_unique($ver[$availCode][$availloc]));
							echo ']';
						}
						$i++;
						
					}
					echo '</i></td></tr><tr>';
				}
				elseif(count(array_unique($loc[$availCode]))>3)
				{
					echo '</tr><tr><td><i>';
					$i = 0;
					$len = count(array_unique($loc[$availCode]));
					foreach(array_unique($loc[$availCode]) AS $availloc)
					{
						if($i==0)
						{
							echo '&nbsp;'.$availloc ;
						}
						else
						{
							echo ', ' .$availloc  ;
						}
						if(isset($ver[$availCode][$availloc]))
						{   
							echo '[';
							echo implode(',', array_unique($ver[$availCode][$availloc]));
							echo ']';
						}
						$i++;
						
					}
					echo '</i></td></tr><tr>';
					
				}
				else
				{
					
					echo "<td><i>"; //.implode(',', array_unique($loc[$availCode])).
					$i = 0;
					$len = count(array_unique($loc[$availCode]));
					foreach(array_unique($loc[$availCode]) AS $availloc)
					{
						if($i==0)
						{
							echo '&nbsp;'. $availloc .'&nbsp;';
						}
						else
						{
							echo  ', ' .$availloc  ;
						}
						if(isset($ver[$availCode][$availloc]))
						{   
							echo '[';
							echo implode(',', array_unique($ver[$availCode][$availloc]));
							echo ']';
						}
						
						$i++;
					}
					echo '</i></td>';
				}
			}
			else
			{
				echo '</tr><tr><td><i>';
				$i = 0;
				$len = count(array_unique($loc[$availCode]));
				foreach(array_unique($loc[$availCode]) AS $availloc)
				{
					if($i==0)
					{
						echo '&nbsp;'.$availloc ;
					}
					else
					{
						echo ', ' .$availloc  ;
					}
					if(isset($ver[$availCode][$availloc]))
					{   
						echo '[';
						echo implode(',', array_unique($ver[$availCode][$availloc]));
						echo ']';
					}
					$i++;
					
				}
				echo '</i><td></tr>';
			}
		}
		
	?>
    </tr>
    </table>
    <?php
	}}
	?>  	
  <p>Units: 
            
  <?php
  if(strtoupper($sam_array['metadata']['multiple']) == 'YES'){?>
   <strong><?php echo (!isset($sam_array['metadata']['topics'][1]['topicUnits']) || ($sam_array['metadata']['topics'][1]['topicUnits']=='') )?$msg:$sam_array['metadata']['topics'][1]['topicUnits']; ?></strong> 
  <?php }else{ ?>
    <strong>
    <?php  $i=0;
    foreach ($sam_array['metadata']['topics'] AS $topic){
      if($i == 0)
      {
          echo $topic['topicUnits'];
      }
      else
      {
          echo ', '.$topic['topicUnits'];
      }
      $i++;
    }?>
    </strong>
<?php }?>
  </p>
  <p>Date on which this statement was provided to students: <strong>
   <?php 
  if($sam_array['metadata']['version_definition']  != '2014 version 2')
  {
	 echo (!isset($sam_array['metadata']['approval']) || ($sam_array['metadata']['approval']=='') )? $msg :date('j F Y',strtotime($sam_array['metadata']['approval'])); 
	  
  }
  else
  {
 	 echo (!isset($sam_array['metadata']['approval']) || ($sam_array['metadata']['approval']=='') )? $draft_msg :date('j F Y',strtotime($sam_array['metadata']['approval'])); 
  }
		?>
 
        </strong></p>
  <p>Duration of topic: 
  <?php	
  	$arr_duration = array();
	if($sam_array['metadata']['multiple'] == 'yes')
	{
		if(isset($sam_array['metadata']['availability'])){
			foreach ($sam_array['metadata']['availability'] AS $avail){
				if($avail['avRef'] == $avail_ref)
				{?>
						<strong><?php echo (!isset($avail['avDuration'])||($avail['avDuration']==''))?$msg:$avail['avDuration'];?></strong>
					<?php		
					 break;
				}
			}
		}
	}
	else
	{
		if(isset($sam_array['metadata']['availability'])){
		foreach ($sam_array['metadata']['availability'] AS $avail){
			array_push($arr_duration, $avail['avDuration']);
	    }?>
		<strong> <?php echo implode(' , ', array_unique($arr_duration)); ?></strong>
	<?php }}?>
	
	
  
  
  
  <p>School(s) responsible for topic: <strong>
  <?php echo (!isset($sam_array['metadata']['topics'][1]['topicSchool']))||($sam_array['metadata']['topics'][1]['topicSchool']=='')?$msg:$sam_array['metadata']['topics'][1]['topicSchool'];
  ?> 
  </strong> 
  
  <?php if(isset($sam_array['metadata']['coordinators']) && count($sam_array['metadata']['coordinators']) >= 1){?>
  <table class="table_coordinators">
  <tr>
  	<td rowspan = "<?php echo count($sam_array['metadata']['coordinators']);?>" style="vertical-align:top">
    Topic Coordinator:
    </td>
    <td>
	<strong> &nbsp; <?php echo $sam_array['metadata']['coordinators'][1]['coord_name_display'] . ' ' . $sam_array['metadata']['coordinators'][1]['coord_phone']. ' ' . $sam_array['metadata']['coordinators'][1]['coord_location'];?></strong> 
  </strong> 
    </td>
  </tr>
  <?php	for($i=1; $i <count($sam_array['metadata']['coordinators']); $i++)
			{?>
        	<tr>
           	<td>
			<strong> &nbsp; <?php echo $sam_array['metadata']['coordinators'][$i+1]['coord_name_display'] . ' ' . $sam_array['metadata']['coordinators'][$i+1]['coord_phone']. ' ' . $sam_array['metadata']['coordinators'][$i+1]['coord_location'];?> </strong>
            </td>
            </tr>
	<?php	}?>

  </table>
  <?php }
  else{
	 echo  '<p>Topic Coordinator:'. '<strong>'.$msg .'</strong>'. '</p>';
  }
  ?>

</div>
<!-- end topic specs -->


<!-- workload -->
<div id="workload" class="bordertop">

  <p>Expected student workload* (<a href="http://www.flinders.edu.au/ppmanual/student/assessment-policy.cfm#appendixb" target="_blank">http://www.flinders.edu.au/ppmanual/student/assessment-policy.cfm#appendixb</a>): <i>number of hours per week or in total.</i></p>
  <?php
	  if(isset($sam_array['metadata']['topics'][1]['work_load']) && ($sam_array['metadata']['topics'][1]['work_load']!=''))
	  {
		  echo '<p><strong>'.$sam_array['metadata']['topics'][1]['work_load']. '</strong></p>';
	  }
	  else
	  {
		  echo $msg;
	  }
  ?>
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
    <?php 	foreach ($sam_array['metadata']['assessment'] AS $assessment ){
				if($asessmentItem == $assessment['id'])
				 {
					 echo trim($assessment['name']);
					 break;
				 }
		
		}
	
	
	?><br />
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

<p><strong>Alignment of Assessment with Graduate Qualities</strong></p>
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
    <?php foreach ($gradattribute['assessment'] as $gradAttribute => $asessmentItem) { 
				foreach ($sam_array['metadata']['assessment'] AS $assessment ){
					if($asessmentItem == $assessment['id'])
				 {
					 echo trim($assessment['name']);
					 break;
				 }
	?>
    <?php  }?> <br />
    <?php }} else { echo 'N/A'; } ?>
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
<?php if ($sam_array['metadata']['academicIntegrity'] == 'Yes') { ?>
<p>If Yes, students will receive a written statement describing how the software will be used and be advised about the Flinders Learning Online Academic Integrity site.</p>
<?php } ?>
</div>
<!-- end integrity statement -->
<!-- scalling -->
<div id="scalling" class="bordertop">
<p>Will scaling procedures be used in determining marks for each piece of work or for determining the final topic grade?
	<strong><?php echo trim((!isset($sam_array['metadata']['scaling'])||($sam_array['metadata']['scaling']==''))?"$msg":$sam_array['metadata']['scaling']); ?></strong>
</p>
<?php if ($sam_array['metadata']['scaling'] == 'Yes') { ?>
<p>Details of scaling procedures:</p>
<p><?php echo trim((!isset($sam_array['metadata']['scalingDetail'])||($sam_array['metadata']['scalingDetail']==''))?"$msg":$sam_array['metadata']['scalingDetail']); ?></p>
<?php } ?>
</div>
<!-- end integrity statement -->


<!-- resubmission statement -->
<div id="resubmission" class="bordertop">

  <p>May assessment exercises be resubmitted after revision for re-marking? <strong>
  <?php echo  trim((!isset($sam_array['metadata']['resubmissionPermitted']) || ($sam_array['metadata']['resubmissionPermitted']==''))?"$msg":$sam_array['metadata']['resubmissionPermitted']); ?>
  </strong></p>
 <?php if ($sam_array['metadata']['resubmissionPermitted'] == 'Yes') { ?>
  <p>The circumstances under which assessment exercises may be resubmitted, the form this may take and the maximum mark obtainable are as follows:</p>
 	<?php echo trim((!isset($sam_array['metadata']['resubmissionDetail'])||($sam_array['metadata']['resubmissionDetail']==''))?"$msg":$sam_array['metadata']['resubmissionDetail']); ?>
 <?php } ?>
</div>
<!-- end resubmission statement -->

<!-- special consideration statement -->
<div id="consideration" class="bordertop">

<p>Students who believe that their ability to satisfy the assessment requirements for this topic has been or will be affected by medical, compassionate or other special circumstances and who want these circumstances to be taken into consideration in determining the mark for an assessment exercise may apply to the Topic Coordinator of the topic for special consideration. The preferred method of application is: </p>
 <?php echo trim((!isset($sam_array['metadata']['consideration']) || ($sam_array['metadata']['consideration']==''))?"$msg":$sam_array['metadata']['consideration']); ?>
</div>
<!-- end special consideration statement -->


<!-- supplementary statement -->
<div id="supplementary" class="bordertop">
<p>Supplementary assessment for this topic may be approved on the following grounds:</p>
<ul>

<li><strong>  Medical/Compassionate</strong> &ndash; a student who is unable to sit or remain for the duration of the original examination due to medical or compassionate reasons may apply for supplementary assessment.  If illness or special circumstance prevents the student from sitting or remaining for the duration of the scheduled supplementary examination, or from submitting by the agreed deadline a supplementary assessment exercise, the student will be either: awarded a result in the topic of Withdraw, Not Fail (WN); or be offered the opportunity to demonstrate competence through an alternative mechanism.  If illness or special circumstance is demonstrated to persist up to the commencement of the next academic year, then the student will be awarded a result in the topic of WN.</li>
<li><strong>  Academic</strong> &ndash; a student will be granted supplementary assessment if he/she: achieves an overall result in the topic of between 45 and 49%, (or between 40 and 49% where a student obtains a fail grade in the last 9 units required for completion of a course) or the equivalent where percentage marks are not awarded; has completed all required work for the topic; has met all attendance requirements; and obtains at least a pass level grade in any specific component of assessment  (other than an examination) for the topic where this is explicitly stated to be a formal requirement for the successful completion of the course or topic. If illness or special circumstance prevents the student from sitting or remaining for the duration of the scheduled supplementary assessment, the student will be either: awarded a result in the topic of Withdraw, Not Fail (WN); or be offered the opportunity to demonstrate competence through an alternative mechanism. If illness or special circumstance is demonstrated to persist up to the commencement of the next academic year, then the student will be awarded a result in the topic of WN.</li>
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
<?php if($sam_array['format']=='pdf'){?>
<table style="width:100%; page-break-inside:avoid;" autosize="1">
	<tr style="width:100%">
    	<td style="width:60%; vertical-align:bottom; height:70px">
        <strong>
		<?php
		if($status=='live'){ 
			if(isset($sam_array['metadata']['coordinators'])){
				echo '&nbsp;&nbsp; ' . $sam_array['metadata']['coordinators'][1]['coord_name_display'];
			}
				else{ echo $msg;} 
		} 
		?> 
        </strong>
    	</td>
        <td style="width:40%; vertical-align:bottom; height:70px">
   
		<?php if($status=='live'){ 
              
				echo '<strong>&nbsp;&nbsp; ';
	  		 	echo (!isset($sam_array['metadata']['approvalDate']) || ($sam_array['metadata']['approvalDate']==''))?"$msg":date('d / m / Y',strtotime($sam_array['metadata']['approvalDate']));
				echo '</strong>';
			}
		?> 
        </td>
    </tr>
    
    <tr style="width:100%">
    	<td style="width:50%">
        	<p class="signature25">Signature of Topic Coordinator</p>
        </td>
        <td style="width:50%">
        	<p class="signature25">Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
        </td>
    </tr>
  
		<?php  	if($sam_array['metadata']['topics'][1]['topicSchool'] == 'School of Medicine' || $sam_array['metadata']['topics'][1]['topicSchool'] == 'School of Nursing & Midwifery'){?> 
    <tr>
    	<td>
        	 <?php if($status=='live'){ 
			 			if($sam_array['metadata']['topics'][1]['topicSchool'] == 'School of Medicine'){
				 			if(substr($sam_array['metadata']['topics'][1]['tcode'], 0, 4) == 'MMED')
				 			{
								echo "<p> <br/><strong>&nbsp;&nbsp;&nbsp;Prof Kevin Forsyth</strong></p> <br/> ";
				    		}
			 				elseif(substr($sam_array['metadata']['topics'][1]['tcode'], 0, 4) == 'BTEC')
							{
					 			echo "<p><br/><strong>&nbsp;&nbsp;&nbsp;Prof Chris Franco</strong></p><br/>";
					 
							}
			 			}
			 			elseif($sam_array['metadata']['topics'][1]['topicSchool'] == 'School of Nursing & Midwifery'){
			 	 			echo "<p> <br/> <strong>&nbsp;&nbsp;&nbsp;Kristen Graham</strong></p><br/>";
			 			}
			 }
			 else
			 {
				 echo "<p> </p><br/> ";
			  }
			 ?>
        </td>
        <td>
        	<?php if($status=='live'){ 
              if($sam_array['metadata']['version_definition']  != '2014 version 2')
  			{
				echo '<strong>&nbsp;&nbsp; ';
				echo (!isset($sam_array['metadata']['approval']) || ($sam_array['metadata']['approval']=='') )? $msg :date('d / m / Y',strtotime($sam_array['metadata']['approval'])); 
				echo '</strong>';
			}
			else
			{
				echo '<strong>&nbsp;&nbsp; ';
	  		 	echo (!isset($sam_array['metadata']['approvalDate']) || ($sam_array['metadata']['approvalDate']==''))?"$msg":date('d / m / Y',strtotime($sam_array['metadata']['approvalDate']));
				echo '</strong>';
			}
		}?> 
			
        </td>
    </tr>
    <tr>
    	<td>
			<p class="signature25">Signature of Course Coordinator</p>
			<p style="line-height:0.6em; font-size:0.7em" class="printonly">[Faculty of Health Science Only]</p>
        </td>
        <td>
			<p class="signature25" style="vertical-align:50%">Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
		
        </td>
    </tr>
    <?php } ?>
    <tr>
    <td>
    <p style="line-height:0.6em; font-size:0.7em; margin-top:5px;" class="printonly">DVCA:   6.11.14</p>
    </td>
    <td>
    </td>
    </tr>

</table>
<?php } ?>
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