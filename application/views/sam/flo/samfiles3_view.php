<?php
$num_enrolled = count($course_meta['enrolled']);
$num_othertopics = count($course_meta['othertopics']);
?>
<script>
    function OpenInNewTab(url) {
        var win = window.open(url, '_blank');
        win.focus();
    }
    //$(document).ready(function() {
        //$("#aaa").click();
    //});  onclick="OpenInNewTab('');"
</script>
<script>
    document.oncontextmenu = document.body.oncontextmenu = function() {return false;}
</script>
<?php if($num_enrolled > 0){ ?>
<br/>
<table>
    <tr>
        <th>Enrolled topic availability</th>
        <th>Link to SAM</th>
    </tr>
    <?php for ($i=0; $i<$num_enrolled; $i++){ ?>
    <tr>
        <td><?php echo $course_meta['enrolled'][$i]['shortname']; ?></td>
        <td>
            <?php if ($course_meta['enrolled'][$i]['file_url'] != null){ ?>
            <a id="aaa" href="<?php echo $course_meta['enrolled'][$i]['file_url']; ?>" target="_blank" >View Sam</a>
            <?php } else {?>
            Not available
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
<?php } ?>

<br/>
<?php if($num_othertopics > 0){ ?>
<table>
    <tr>
        <th>Other topic availability &nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th>Link to SAM</th>
    </tr>

    <?php for ($i=0; $i<$num_othertopics; $i++){ ?>
    <tr>
        <td><?php echo $course_meta['othertopics'][$i]['shortname']; ?></td>
        <td>
            <?php if ($course_meta['othertopics'][$i]['file_url'] != null){ ?>
            <a href="<?php echo $course_meta['othertopics'][$i]['file_url']; ?>" target="_blank">View Sam</a>
            <?php } else {?>
            Not available
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
<?php } ?>