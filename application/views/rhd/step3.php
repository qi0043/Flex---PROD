<?php
include 'rhd_head.php';
?>

<style type="text/css">
	.visible
	{
	   display: block;
	}
	.invisible
	{
	   display: none;
	}
	
	i.glyphicon
	{
		cursor:pointer;
	}
	
	#content
	{
		padding-top:40px;
	}
	
	h3{
	    font-size: 17px;
    	margin: 0 0 7px 0;
		white-space: normal;
   	 	word-wrap: break-word;
		font-weight: bold;
	}
	
	p{
		margin-top: 0;
    	margin-bottom: 10px;
		font-size: 14px;
		line-height: 1.5;
		margin: 10px 0;
	}
	
	.open_access_form label, .checkbox label
	{
		font-weight: normal;
		line-height:1.5;
	}

	.file_ul li
	{
		line-height: 1.5;
	}
	
	.btn_save
	{
		margin-bottom:5px;
	}
	
	.declaration
	{
		margin-bottom:20px;
	}
	.ext_reason_area
	{
		margin-top: 20px;
	}
	.copyright_area
	{
		padding-top: 20px;
		padding-bottom:20px;
	}
	
	.embargo_ul
	{
		line-height: 1.5
	}
	
	.icon
	{
		text-align:center;
		padding-left: 0px;
		padding-right: 0px;
	
	}
	
	.seperator
	{
		width: 50px;
	}
</style>

<script type="text/javascript">

	var item_uuid =  "<?php echo $uuid ?>";
	var item_version = "<?php echo $version ?>";
	var indexURL = <?php echo json_encode(base_url('rhd/newItem/index')); ?>;
	var theses = [];
	var count = <?php echo isset($open_access) ? count($open_access) : 1?>;
	<?php
	if(isset($open_access))
	{
		$index = 0;
		foreach($open_access as $t)
		{
			$index++;
			
	?>		var temp = {};
			temp["item"] = <?php echo $index ?> ;
			temp["uuid"] = "<?php echo isset($t['uuid']) ? $t['uuid'] : '' ?>";
			temp["ref_name"] = "thesis_" + <?php echo $index ?> ;
			temp["default_file_name"] = "<?php echo isset($t['filename']) ? $t['filename'] : '' ?>";
			temp["default_file_size"] = "<?php echo isset($t['filesize']) ? $t['filesize'] : '' ?>";
			temp["default_file_link"] = "<?php echo isset($t['filelink']) ? $t['filelink'].'&token='.$token : '' ?>";
	
			theses.push(temp);
	<?php
		}
	}
	?>
	
	var step3_url = <?php echo json_encode(base_url('rhd/coursework/edit_part3')); ?>;
	var redirect_url = "<?php echo base_url() ?>" + "rhd/coursework/getThesis_part4/" + item_uuid + "/" + item_version + "/15/";
	var session_url = "<?php echo (isset($navs[1]['url']) && $navs[1]['url']!='') ? base_url() .$navs[1]['url'] : '' ?>";
	var d_status = "<?php echo $status?>";
	
	var new_thesis = false;

	<?php
	if(isset($new_thesis))
	{?>
		new_thesis = "<?php echo $new_thesis ?>";
	<?php }
	?>
	
	var open_access = "<?php echo isset($new_version_required) ? $new_version_required: ''; ?>";
	var release_status = "<?php echo isset($release_status) ? $release_status : '' ?>";
	var embargo_radio_button_value = "<?php echo isset($embargo_standard_request_duration) ? $embargo_standard_request_duration : '' ?>";
	var embargo = '<?php echo isset($embargo)?$embargo:''; ?>';
	
	var default_embargo_standard_request_reason = "";
	
	<?php if(isset($embargo_standard_request_reason))
	{?>
		default_embargo_standard_request_reason = "<?php echo $embargo_standard_request_reason ?>";
	<?php } ?>
	
	var copyright_value = "<?php echo isset($copyright)?$copyright:'' ?>";
	
	var default_embargo_ext_reason = "<?php echo isset($embargo_extension_request_reason) ? $embargo_extension_request_reason: ''?>";
	var embargo_ext = '<?php echo isset($embargo_extension)?$embargo_extension:''; ?>';

	
</script>
  
<?php if(isset($_SESSION['rhd_privilege']) && ($_SESSION['rhd_privilege'] == 'mod&con' || $_SESSION['rhd_privilege'] == 'contributor' ||  $_SESSION['rhd_privilege'] == 'moderator'))
{?>

<div class="container">
	<?php include 'nav.php'; ?>
   
	<div class="row" id="content"></div>
</div>

<?php
}
else
{?>
	<div class="container">
        <div className="row">
        <?php echo 'You do no have privilege to view this page or session time out.'; ?>
        </div>
    </div>
<?php } //end of IF session exists
include 'footer.php';
?>


<script type="text/javascript" src="<?php echo base_url() . 'resource/rhd/';?>js/step3.js"></script>