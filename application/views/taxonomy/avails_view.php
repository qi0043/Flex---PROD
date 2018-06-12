<br>
<?php 
    $avail_count = count($avails);
?>
        
<div class="breadcrumbs">
          
  <span typeof="v:Breadcrumb"><b>Availabilities: <?php echo $avail_count; ?></b></span>
  
</div>

<br>
<br>
<div style="float:left;">
<table id="tblfromavails">
    <tr >
    	<th> index </th>
        <th>avail reg </th>
        <th>avail num</th>
        <th>topic code</th>
        <th>topic_name</th>
        <th>topic_version</th>
        <th>org_num</th>
        <th>org_name</th>
        <th>teach_start_date</th>
        <th>teach_end_date</th>
        <th>avail_yr</th>
        <th>sprd_cd</th>
        <th>location_cd</th>
        <th>avail_no</th>
        <th>study_mode</th>
        <th>supp_exam_end</th>
        <th>student_access_date</th>
        <th>staff_access_date</th>
        
    </tr>
      
     
    <?php for($i=0; $i<$avail_count; $i++){ ?>
    <tr <?php if($i%2==0) echo "class='even'"; else echo "class='odd'"; ?> >
        <td><?php echo $i + 1; ?></td>
        <td><?php echo $avails[$i]['node']; ?></td>
        <td><?php echo $avails[$i]['keyb']; ?></td>
        <td><?php echo $avails[$i]['keyd']; ?></td>
        <td><?php echo $avails[$i]['keyf']; ?></td>
        <td><?php echo $avails[$i]['keyh']; ?></td>
        <td><?php echo $avails[$i]['keyj']; ?></td>
        <td><?php echo $avails[$i]['keyl']; ?></td>
        <td><?php echo $avails[$i]['keyn']; ?></td>
        <td><?php echo $avails[$i]['keyp']; ?></td>
        <td><?php echo $avails[$i]['keyr']; ?></td>
        <td><?php echo $avails[$i]['keyt']; ?></td>
        <td><?php echo $avails[$i]['keyv']; ?></td>
        <td><?php echo $avails[$i]['keyx']; ?></td>
        <td><?php echo $avails[$i]['keyz']; ?></td>
        <td><?php echo $avails[$i]['keyab']; ?></td>
        <td><?php echo $avails[$i]['keyad']; ?></td>
        <td><?php echo $avails[$i]['keyaf']; ?></td>
    </tr>
    <?php } ?>
</table>
</div>

</div>

<br>

<br>


