<style type="text/css">
.form-control:focus
{
	cursor:text !important;
	
}
input.form-control[readonly], textarea.form-control[readonly]{
	border-color:transparent;
	box-shadow: none;
}

input:focus {
    outline: 0 none;
    border: 0 none;
}
.inactive a
{
	color: #777 !important;
}
.active a
{
	color:#eb6e08 !important;
	font-size: 18px;
}

a[disabled="disabled"] {
	pointer-events: none;
}
.glyphicon-exclamation-sign
{
	color: red;
}
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

.opt_span
{
	color: #5bc0de;
	font-weight:bold;
}


.radio_button
{
	padding-bottom: 10px;
}
.radio_button input, .embargo_area, .embargo_area input
{
	margin-left: 20px;
	
}
.radio_button label
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
.thesisForm hr	
{
	margin-top:40px;
	margin-bottom:40px;
}
</style>
<div role="navigator" id="thesis_navigator" >

</div>
<script type="text/javascript">
	var nav_data = [];
	<?php
	if(isset($navs))
	{
		$index = 0;
		foreach($navs as $nav)
		{
			$index++;
			
	?>		var temp = {};
			temp["index"] = <?php echo $index ?> ;
			temp["url"] = "<?php echo (isset($nav['url']) && $nav['url']!='') ? base_url() .$nav['url'] : '' ?>";
			temp["valid"] = "<?php echo isset($nav['valid']) ? $nav['valid'] : '' ?>";
			temp["text"] = "<?php echo isset($nav['text']) ? $nav['text'] : '' ?>";
			temp["active"] = "<?php echo isset($nav['active']) ? $nav['active'] : '' ?>";
			temp["disabled"] = "<?php echo isset($nav['disabled']) ? $nav['disabled'] : '' ?>";
			nav_data.push(temp);
	<?php
		}
	}
	?>
</script>

<script type="text/javascript" src="<?php echo base_url() . 'resource/rhd/';?>js/navigator.js"></script>