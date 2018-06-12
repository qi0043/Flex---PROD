<?php
   #$pdf_link = $course_meta['enrolled'][0]['file_url'];
?>
<style>
    body, html, iframe{
        margin: 0; padding: 0; height: 100%; width: 100%; overflow:hidden;
         border: none;
    }
    
    iframe{
       display:block; position: absolute; height: 85%;
    }

</style>
<script>
    document.oncontextmenu = document.body.oncontextmenu = function() {return false;}
</script>
<p>
See SAM document below or 
<a href="<?php echo $course_meta['enrolled'][0]['file_url_interim']; ?>" target="_blank" >View SAM in a new window</a>.
</p>
<iframe src="<?php echo $course_meta['enrolled'][0]['file_url']; ?>" >
</iframe>


