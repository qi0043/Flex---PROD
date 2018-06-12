<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<?php /*?><link rel="shortcut icon" href="../../assets/ico/favicon.ico"><?php */?>
<title>School of Medicine Curriculum Framework::Course Overview - Flinders Medical Graduate Outcomes</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/bootstrap-theme.min.css">


<!-- Local styles -->

<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/local.css">


<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->



<!-- Latest compiled and minified JavaScript -->



<script type="text/javascript" src="<?php echo base_url() . 'resource/ocf/';?>js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'resource/ocf/';?>js/jquery-ui-1.10.3.custom.min.js"></script>

<script src="<?php echo base_url() . 'resource/ocf/';?>js/bootstrap.min.js"></script>   
    
<link href="<?php echo base_url() . 'resource/ocf/';?>css/font-awesome-4.2.0/css/font-awesome.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
 
$(function () {
 $("[data-toggle=tooltip]").tooltip();
})
</script>

<style type="text/css">
<!--
  .doNotPrint {  
  }

  .instruction {	  
  }

@media print {
    body {
        margin: 0;
        padding: 0;
        line-height: 1.4em;
        word-spacing: 1px;
        letter-spacing: 0.2px;
        font: 13px Arial, Helvetica,"Lucida Grande", serif;
        color: #000;
    }

  a[href]:after {
    content: "";
  }

  .doNotPrint {
	  
	  visibility: hidden;
	  display: none;	  
  }

#myNav {
	display:none;
	visibility:hidden;
	
} 
}
-->
</style>

<script type="text/javascript">

$(document).on("hidden.bs.modal", function (e) { $(e.target).removeData("bs.modal").find(".modal-content").empty(); });
</script>


</head>
<body role="document">


<div class="jumbotron">
<div class="container-fluid"><img src="<?php echo base_url() . 'resource/ocf/';?>images/flinders_logo.png" width="151" height="65" alt="Flinders University"></div>
</div>


<div class="container-fluid" style="margin:0 20px 0 20px;">

  <div role="main">
    <div class="page-header">
      <h2>Flinders University MD Curriculum Framework - Pilot v0.2</h2>
    </div>
    <div class="row">
		<div id="myNav" class="span10"><a href="/flex/ocf/assessment" class="btn btn-sm btn-primary">Return to assessment map</a>&nbsp;&nbsp;</div>

    <div class="span10">
    <h3>Topic Assessment Detail :: <span data-toggle="tooltip" data-placement="bottom" data-html="true" title="<?php echo $sam_array['sam_name'];?>"><?php echo $sam_array['code'];?> <?php echo $sam_array['title'];?></span> </h3>
    <?php if(isset($sam_array['topic_info_uuid'])&& isset($sam_array['topic_info_version'])){?>
    <a href="/flex/ocf/md/summary/<?php echo $sam_array['topic_info_uuid'];?>/<?php echo $sam_array['topic_info_version'];?>" class="btn btn-xs btn-default" target="_blank"><i class="fa fa-file-text-o"></i>&nbsp;View Topic Summary</a>
    <?php }?>
   
</div>
 <br/>
<table class="table-bordered" style="margin-bottom:2em; width:96%;">
<thead>
    <tr>
    <th align="left" valign="top" style="padding:5px;" scope="col">&nbsp;</th>
    <th align="left" valign="top" style="padding:5px;" scope="col">Assessment Items</th>
    <th align="left" valign="top" style="padding:5px;" scope="col">Topic Learning Outcomes</th>
    <th align="left" valign="top" style="padding:5px;" scope="col">Professional (AMC) Learning Outcomes</th>
    <?php /*?><th align="left" valign="top" style="padding:5px;" scope="col">Flinders Graduate Outcomes </th><?php */?>
    </tr>
</thead>

<tbody>
<?php 
	$index=0;
	foreach ($sam_array['assessment'] as $assessment) { 
		$index++ ?>
	<tr>
    <td style="padding:5px; width:3em; text-align:left; vertical-align:top" scope="col"><strong><?php echo $index; ?></strong></td>
    <td style="padding:5px; width: 30em; text-align:left; vertical-align:top" scope="col" ><strong><?php echo $assessment['name']; ?>   </strong>
    		<ul>
                <li><i>Format</i>: <?php print $assessment['format']; ?></li>
                <li><i>Deadline</i>: <?php print $assessment['deadline']; ?></li>
                <li><i>Penalties</i>: <?php echo $assessment['penalties']; ?></li>
                <li><i>Return date</i>: <?php echo $assessment['return_date']; ?></li>
            </ul>     
    </td>
    <td style="padding:5px; width: 30em; text-align:left; vertical-align:top" scope="col">
		<?php if(isset($assessment['aligned_topic_los'])){?>
        	<ul>
            <?php foreach ($assessment['aligned_topic_los'] as $topicoutcome) { ?>
                <li><?php echo $topicoutcome['lo_name']; ?></li>
            <?php } ?>
            </ul>
        <?php } ?>
    </td>
  
    <td style="padding:5px; width: 30em; text-align:left; vertical-align:top" scope="col">
		<?php if(isset($assessment['aligned_prof_los'])){?>
            <ul>
            <?php foreach ($assessment['aligned_prof_los'] as $profoutcome) { ?>
                <li>
                <?php /*?><a href="/flex/ocf/amcgosearch/<?php echo strtolower($profoutcome['lo_code']);?>" target="_blank" class="btn btn-link instruction standard" style="padding:0;" data-toggle="tooltip" data-placement="right" data-html="true" title="view this learning outcome report" >
        <?php echo $profoutcome['cat_code']; ?> - <?php echo $profoutcome['lo_code']; ?></a><?php */?>
        		
                 <strong><?php echo $profoutcome['cat_code']; ?> <?php echo $profoutcome['lo_code']; ?> </strong>- <?php echo $profoutcome['lo_name']; ?>
                
                </li>
            <?php } ?>
            </ul>
        <?php } ?>
    </td>
    <?php /*?><td style="padding:5px; width: 30em; text-align:left; vertical-align:top" scope="col">
		<?php if(isset($assessment['aligned_course_los'])){?>
            <ul>
            <?php foreach ($assessment['aligned_course_los'] as $courseoutcome) { ?>
                <li><?php echo $courseoutcome['lo_name']; ?></li>
            <?php } ?>
            </ul>
        <?php } ?>
    </td><?php */?>
</tr>
 <?php } ?>
</tbody>
</table>

<!-- Modals -->


	</div>
    </div>
</div>




</body>
</html>
