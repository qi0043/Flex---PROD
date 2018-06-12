<?php
include 'header.php';
?>


<?php /*?><div class="jumbotron">
	<div class="container-fluid"><img src="<?php echo base_url() . 'resource/flo/ocf/';?>images/flinders_logo.png" width="151" height="65" alt="Flinders University"></div>
</div><?php */?>
<div>


<?php
	foreach($attachments as $att)
	{
		if($att['type'] == 'htmlpage') //webpage
		{
			echo "<p>".$att['pagecontent']."</p>";
		}
		
		if($att['type'] == 'file' || $att['type'] == 'url') //pdf, word, txt or url...
		{
			echo "<p>"."<a href=" . $att['links']['view']." target='_blank'>".$att['filename']."</a>"."</p>";
		}
		
		if($att['type'] == 'kaltura') //kaltura
		{
			echo "<p>"."<a href=" . $att['links']['view']." target='_blank'>".$att['title']."</a>"."</p>";
		}
	}
?>

</div>


<?php
include 'footer.php';
?>

