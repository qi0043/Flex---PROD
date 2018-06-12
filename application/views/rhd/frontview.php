<?php
include 'rhd_head.php';
?>
<style type="text/css">
	.dl-horizontal dt{
		white-space: normal;
		text-align: left; 
	}
	
	.dl-horizontal dd ul{
		list-style-position: inside;
    	padding-left: 0px;
	}
	
	.label
	{
		font-size: 100% !important;
	}
	
	.submitButton
	{
		margin-bottom: 20px;
	}
	.public_div
	{
		margin-top:20px;
	}
</style>


<div class="container">
	<div class="row" id="content"></div>
</div>

<script type="text/javascript">
	var t_status =  "<?php echo $status ?>";
	
	var item_uuid =  "<?php echo isset($uuid)? $uuid : '' ?>";
	
	var item_version = "<?php echo isset($version)? $version : '' ?>";
	
	var t_name = "<?php echo isset($name)? $name : '' ?>";
	
	

	var isValid = "<?php echo isset($valid)? $valid : true ?>";
	
	var submitURL = <?php echo json_encode(base_url('rhd/coursework/submitForModeration')) ?>;

	var createURL = "<?php echo base_url() ?>" + "rhd/coursework/createThesis/";

	var newURL = "<?php echo base_url() ?>" + "rhd/coursework/index/";
	
	var thesis_link = <?php echo json_encode(base_url('rhd/coursework/getThesis_part4')) ?> + '/' + item_uuid + '/' + item_version + '/';
	
	var modifiedDate = "<?php echo isset($modifiedDate)? substr_replace($modifiedDate, ' ', 10, 1) : '' ?>";

</script>

</div>

<script type="text/javascript" src="<?php echo base_url() . 'resource/rhd/';?>js/frontview.js"></script>

<?php include 'footer.php';
?>