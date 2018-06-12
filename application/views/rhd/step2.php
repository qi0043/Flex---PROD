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
		margin: 20px 0;
	}

	.open_access_form label, .checkbox label
	{
		font-weight: normal;
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
	
	input[type='checkbox']
	{
	   vertical-align:middle !important;
	}
	
	.icon
	{
		text-align:center;
		padding-left: 0px;
		padding-right: 0px;
	}
</style>


<script type="text/javascript">
	var theses = [];
	var theses_count = <?php echo isset($examined_thesis) ? count($examined_thesis) : 1?>;
	<?php
	if(isset($examined_thesis))
	{
		$index = 0;
		foreach($examined_thesis as $t)
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
	var uuid = "<?php echo isset($uuid) ? $uuid : ''; ?>";
	var version = "<?php echo isset($version) ? $version : ''; ?>";
	var uploadurl = <?php echo json_encode(base_url('rhd/coursework/uploadThesis')); ?>;
	var edit_all_url =  <?php echo json_encode(base_url('rhd/coursework/edit_part2_all')); ?>;
	var redirect_step3_url = "<?php echo base_url() ?>" + "rhd/coursework/getThesis_part3/" + uuid + "/" + version + "/15";
	var quit_url = "<?php echo (isset($navs[1]['url']) && $navs[1]['url']!='') ? base_url() .$navs[1]['url'] : '' ?>";
	var authenticity_v = "<?php echo isset($authenticity)?$authenticity:''; ?>";
	var declaration_v = "<?php echo isset($declaration)?$declaration:''; ?>";
	var status_v = "<?php echo $status?>";
	var new_thesis_v  = "<?php echo isset($new_thesis) ? $new_thesis : false ?>";
	var readonly_v = "<?php echo !$new_thesis?>";
	var downloadurl = <?php echo json_encode(base_url('rhd/coursework/redirect')); ?>;
	
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
?>
</div>
<?php include 'footer.php';
?>

<script type="text/javascript" src="<?php echo base_url() . 'resource/rhd/';?>js/step2.js"></script>