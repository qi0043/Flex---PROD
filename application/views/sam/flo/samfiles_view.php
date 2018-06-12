<?php
$num_enrolled = count($course_meta['enrolled']);
$num_othertopics = count($course_meta['othertopics']);
?>
<script>
    document.oncontextmenu = document.body.oncontextmenu = function() {return false;}
</script>

<?php if($num_enrolled > 0){ ?>
<br/>
<table>
    <tr>
        <th style="width:230px">Your Enrolled Topics </th>
        <th>SAM Approval Date</th>
        <th>Link to SAM</th>
    </tr>
    <?php for ($i=0; $i<$num_enrolled; $i++){ ?>
    <tr>
        <td><?php echo $course_meta['enrolled'][$i]['shortname']; ?></td>
        <td><?php echo $course_meta['enrolled'][$i]['approval_date']; ?></td>
        <td>
            <?php if ($course_meta['enrolled'][$i]['file_url_interim'] != null){ ?>
            <a id="aaa" href="<?php echo $course_meta['enrolled'][$i]['file_url_interim']; ?>" target="_blank" >View SAM</a>
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
        <th style="width:230px">Other Topics Within This Site</th>
        <th>SAM Approval Date</th>
        <th>Link to SAM</th>
    </tr>

    <?php for ($i=0; $i<$num_othertopics; $i++){ ?>
    <tr>
        <td><?php echo $course_meta['othertopics'][$i]['shortname']; ?></td>
        <td><?php echo $course_meta['othertopics'][$i]['approval_date']; ?></td>
        <td>
            <?php if ($course_meta['othertopics'][$i]['file_url_interim'] != null){ ?>
            <a href="<?php echo $course_meta['othertopics'][$i]['file_url_interim']; ?>" target="_blank">View SAM</a>
            <?php } else {?>
            Not available
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
<?php } ?>