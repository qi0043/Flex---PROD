
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
    <h2 style="text-align:center">STATEMENT OF ASSESSMENT METHODS - 2016 
 
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
<h2 style="text-align:center">STATEMENT OF ASSESSMENT METHODS - 2016 </h2>
<?php } ?>
</h2>
<p>Students' attention is drawn to the <em>Student Related Policies and Procedures</em> (available at: <a href="http://www.flinders.edu.au/ppmanual/student/student_home.cfm" onclick="window.open(this.href);return false;">http://www.flinders.edu.au/ppmanual/student/student_home.cfm</a>), and in particular the University's <i><a target="_blank" href="http://www.flinders.edu.au/ppmanual/student/assessment-policy.cfm">Assessment Policy and Procedures</a></i>. </p>



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
	<strong> &nbsp; <?php if(!isset($sam_array['metadata']['coordinators'][1]['coord_name_display']) || $sam_array['metadata']['coordinators'][1]['coord_name_display'] == '')
	{
		echo $msg;
	}
    else
    {
		echo $sam_array['metadata']['coordinators'][1]['coord_name_display'];
		if(!isset($sam_array['metadata']['coordinators'][1]['coord_phone']) || $sam_array['metadata']['coordinators'][1]['coord_phone'] == '')
		{
			echo ' ';
		}
		else
		{
			echo ', '. $sam_array['metadata']['coordinators'][1]['coord_phone'];
			
		}
		if(!isset($sam_array['metadata']['coordinators'][1]['coord_location']) || $sam_array['metadata']['coordinators'][1]['coord_location'] == '')
		{
			echo ' ';
		}
		else
		{
			echo ', '. $sam_array['metadata']['coordinators'][1]['coord_location'];
		}
		// . ' ' . $sam_array['metadata']['coordinators'][1]['coord_phone']. ' ' . $sam_array['metadata']['coordinators'][1]['coord_location'];
		
    }?></strong> 
    </td>
  </tr>
  <?php	for($i=1; $i <count($sam_array['metadata']['coordinators']); $i++)
			{?>
        	<tr>
           	<td>
			<strong> &nbsp; <?php echo $sam_array['metadata']['coordinators'][$i+1]['coord_name_display']; 
			
			if(!isset($sam_array['metadata']['coordinators'][$i+1]['coord_phone']) || $sam_array['metadata']['coordinators'][$i+1]['coord_phone'] == '')
			{
				echo ' ';
			}
			else
			{
				echo ', '. $sam_array['metadata']['coordinators'][$i+1]['coord_phone'];
				
			}
			if(!isset($sam_array['metadata']['coordinators'][$i+1]['coord_location']) || $sam_array['metadata']['coordinators'][$i+1]['coord_location'] == '')
			{
				echo ' ';
			}
			else
			{
				echo ', '. $sam_array['metadata']['coordinators'][$i+1]['coord_location'];
			}
            ?>
            
            
            </strong>
            
            
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

  <p><strong>Expected student workload*</strong> (<a href="
http://flex.flinders.edu.au/items/e950674b-2eb2-4bf2-a376-0a140ae13523/1/?.vi=file&attachment.uuid=65990d2d-e246-4632-9e41-ddc30640130e" target="_blank">refer Appendix B <i>Assessment Policy and Procedures</i></a>): <i>number of hours per week or in total.</i></p>
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
  <p style="font-size: 0.8em"><em>* Indicative only of the estimated minimum time commitment necessary to achieve a Pass grade in the topic.<br/>Expected student workload should be based on the standard student workload of approximately 30 hours of student time commitment per unit.</em></p>
</div>
<!-- end workload -->

<!-- assessable items -->
<div id="assessable" class="bordertop">

  <p><strong>Details of assessable work in the topic</strong> (Optional forms of assessment, where permitted, are also detailed):</p>
    <?php  
   		if(isset($sam_array['metadata']['assessment'])){
	?>
	 <table width="96%" class="aTable">
 	 <thead>
 	 <tr>
    	<th align="left" scope="col">Format of each assessment exercise</th>
   	 	<th align="left" scope="col">Proportion of total marks</th>
    	<th align="left" scope="col">Deadline for submission*</th>
    	<th align="left" scope="col">Penalties to be applied if deadline is not met*</th>
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
<p>
    <i>*See clause 9.3 Assessment Policy and Procedures </i><br/>
    <i>Extensions may be granted by a duly authorised person where the student has:</i>
  <ul>
    <li style="font-size:0.8em;"><i>made a written request for an extension prior to the due date for the assessment item; </i> </li>
    <li style="font-size:0.8em;"><i>included supporting information where relevant when requesting the extension.</i> </li>
    <li style="font-size:0.8em;"><i>justified the request on the basis of unforeseen or exceptional circumstances that are reasonably likely to prevent substantial completion of the assessment by the specified due date.</i></li>
  </ul>
</p>
</div>
<!-- end assessable items -->


<!-- topic completion statement -->
<div id="completion" class="bordertop">

  <p><strong>Criteria for successful completion of the topic</strong> (including, where appropriate, the achievement of a certain minimum level of competence in both the theoretical and practical components of the topic and details of special requirements concerning particular elements or aspects of the topic such as attendance/participation requirements, group activity) are as follows:</p>  
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
    <th width="40%" align="left" scope="col">Assessment exercises relating to each Learning Outcome</th>  
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
    <th width="40%" align="left" scope="col">Assessment exercises relating to each Graduate Quality</th>
   
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
<p><strong>The Nature and Importance of Academic Integrity</strong></p>

<p>All students and staff have an obligation to understand and respect the rules and practice of academic integrity. It is therefore expected that students and staff will adhere to high standards of academic integrity (refer <i><a href="http://www.flinders.edu.au/ppmanual/student/academic-integrity.cfm" target="_blank">Academic Integrity Policy</a></i>).</p>

<p>Academic integrity means that all work which is presented by a student as the work of that student is produced by the student alone, with all sources and collaboration fully acknowledged. Breaches of academic integrity, including cheating, plagiarism and fabrication or falsification of data, are unacceptable and there are serious consequences when a breach is detected.</p>

<p><strong>Detection of Breaches of Academic Integrity</strong></p>
<p>Staff use a range of methods (including electronic means) to assist in the detection of breaches of academic integrity. The University has mandated the use of text-matching for all text-based student assignments.  Except where the Academic Integrity Policy [<a href="http://www.flinders.edu.au/ppmanual/student/academic-integrity.cfm" target="_blank">http://www.flinders.edu.au/ppmanual/student/academic-integrity.cfm</a>] provides for an exemption under special circumstances, all text-based student assignments will be subject to text-matching in conjunction with their submission for assessment. </p>
<p>The University makes available for student use electronic text matching software, which can be accessed through the Flinders Learning Online Academic Integrity site [<a href="http://www.flinders.edu.au/academicintegrity" target="_blank">http://www.flinders.edu.au/academicintegrity</a>].</p>

<p>Have any exemptions from the requirement for the application of text-matching software to student assignments due to special circumstances been approved by the Executive Dean for this topic? <strong>
 <?php echo trim((!isset( $sam_array['metadata']['exemptions'])||( $sam_array['metadata']['exemptions']==''))?"$msg": $sam_array['metadata']['exemptions']); ?>
</strong></p>
<?php if ($sam_array['metadata']['exemptions'] == 'Yes') { ?>
<p>Details of exemptions:</p>
	 <?php echo trim((!isset( $sam_array['metadata']['exemption_details'])||( $sam_array['metadata']['exemption_details']==''))?"$msg": $sam_array['metadata']['exemption_details']); ?>
<?php } ?>
</div>
<!-- end integrity statement -->


<!-- resubmission statement -->
<div id="resubmission" class="bordertop">

  <p><strong>Resubmission of Assessment Exercises</strong> (<a target="_blank" href="http://flex.flinders.edu.au/items/e950674b-2eb2-4bf2-a376-0a140ae13523/1/?.vi=file&attachment.uuid=14437745-2f65-4923-b0cb-ce27ee334688">refer clause 9.4 <i>Assessment Policy and Procedures</i></a>) <p>
  <p> May assessment exercises be resubmitted after revision for re-marking?  <strong>
  <?php echo  trim((!isset($sam_array['metadata']['resubmissionPermitted']) || ($sam_array['metadata']['resubmissionPermitted']==''))?"$msg":$sam_array['metadata']['resubmissionPermitted']); ?>
  </strong></p>
 <?php if ($sam_array['metadata']['resubmissionPermitted'] == 'Yes') { ?>
  <p>Circumstances under which assessment exercises may be resubmitted, the form this may take and the maximum mark obtainable are as follows: </p>
 	<?php echo trim((!isset($sam_array['metadata']['resubmissionDetail'])||($sam_array['metadata']['resubmissionDetail']==''))?"$msg":$sam_array['metadata']['resubmissionDetail']); ?>
 <?php } ?>
</div>
<!-- end resubmission statement -->


<!-- supplementary statement -->
<div id="supplementary" class="bordertop">
<p><strong>Supplementary assessment</strong> for this topic may be granted where a student has:</p>
<ul>
    <li>achieved an overall result in the topic of between 45 and 49% or the equivalent where percentage marks are not awarded; and</li>
    <li>completed all required work for the topic; and</li>
    <li>met all attendance requirements that apply to the topic; and </li>
    <li>obtained at least a pass level grade in any specific component of assessment (other than an examination) for the topic where this is explicitly stated to be a formal requirement for the successful completion of the course or topic.</li>
</ul> 

<p>An Examination Board may grant supplementary assessment for this topic in circumstances other than those covered above on the basis of unforeseen or exceptional circumstances reasonably beyond the control or knowledge of the student.</p>

<p>If unforeseen or exceptional circumstances prevent the student from sitting or remaining for the duration of the scheduled supplementary assessment, the student will be either: awarded a result in the topic of Withdraw, Not Fail (WN); or offered the opportunity to demonstrate competence through an alternative mechanism. </p>

<p>If unforeseen or exceptional circumstances are demonstrated to persist up to the commencement of the next academic year, then the student will be awarded a result in the topic of WN.</p>
</div>
<br/>
<p><strong>Deferred assessment</strong> for this topic may be approved for medical and compassionate reasons in appropriate circumstances. A student who is unable to sit or remain for the duration of the original examination due to unexpected or exceptional circumstances may apply for deferred assessment.</p>
<p>If unexpected or exceptional circumstances prevent the student from sitting or remaining for the duration of a scheduled supplementary or deferred examination, or from submitting by the agreed deadline a supplementary or deferred assessment exercise, the student will be either: awarded a result in the topic of Withdraw, Not Fail (WN); or offered the opportunity to demonstrate competence through an alternative mechanism.</p>
<p>If unexpected or exceptional circumstances are demonstrated to persist up to the commencement of the next academic year, then the student will be awarded a result in the topic of WN.</p>
<!-- end supplementary statement -->

<!-- disability statement -->
<div id="disability" class="bordertop">
<p><strong>Adjustment to Teaching or Assessment Methods</strong> (<a target="_blank" href="http://flex.flinders.edu.au/items/e950674b-2eb2-4bf2-a376-0a140ae13523/1/?.vi=file&attachment.uuid=914531a3-38e1-4f54-8cd4-fa71aa4291be">refer clause 9.1 <i>Assessment Policy and Procedures</i></a>)</p>

<p>A student with a disability, impairment, or medical condition who seeks reasonable adjustments in the teaching or assessment methods of a topic on the basis of his/her disability may make a request to a Disability Advisor as soon as practicable after enrolment in the topic. </p> 

<p>Any such reasonable adjustments must be documented in an Access Plan and discussed between the student and the Topic Coordinator. Any reasonable adjustments must be agreed to by the Topic Coordinator and must be in accordance with related University policy. A student who is dissatisfied with the response from the Topic Coordinator or with provisions made for reasonable adjustments to teaching or assessment methods may appeal in writing to the Faculty Board.</p>
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

<div class="bordertop">
<p><strong>Authorisation of Statement of Assessment Methods</strong></p>
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
  
    <tr>
    <td>
    <p style="line-height:0.6em; font-size:0.7em; margin-top:5px;" class="printonly">DVCA:   07.12.15</p>
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