<!-- include file md/topicsummarynav.php -->

<div id="myNav" class="span10"><a href="<?php echo base_url() . 'ocf/home/' . strtolower($topics['courseCode']) ; ?>" class="btn btn-sm btn-primary">Return to dashboard</a>&nbsp;&nbsp;<a href="/flex/ocf/<?php echo strtolower($topics['courseCode']) ; ?>/fmgo" class="btn btn-sm btn-success">Flinders Medical Graduate Outcomes</a>&nbsp;&nbsp;<a href="/flex/ocf/<?php echo strtolower($topics['courseCode']) ; ?>/amcgo" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Tooltip on top">AMC Graduate Outcomes</a></div>


<?php 
$sam_title = 'N/A';
if(isset($topics['sam_name']))
{
	$sam_title = $topics['sam_name'];
}

$taa_title = 'N/A';
if(isset($topics['taa_name']))
{
	$taa_title = $topics['taa_name'];
}
?>
<h3>Topic Summary :: <span class = "instruction" data-toggle="tooltip" data-placement="top" data-html="true" title="<?php  echo 'SAM: ' . $sam_title .'<br/>' . ' TAA: ' . $taa_title;?> "> <?php echo $topics['tcode'];?> <?php echo $topics['topicTitle'];?></span></h3>


<!-- /include file md/topicsummarynav.php -->