<br>
<?php 
    $topics_count = count($topics);
?>
        
<div class="breadcrumbs">
          
  <span typeof="v:Breadcrumb"><b>Topics: <?php echo $topics_count; ?></b></span>
  
</div>

<br>
<br>
<div style="float:left;">
<table id="tblfromavails">
    <tr >
    	<th>index </th>
        <th>topic code</th>
        <th>topic name</th>
        <th>topic version</th>
        <th>org unit</th>
        <th>org name</th>
        <th>topic_coord</th>
        <th>class_contact</th>
        <th>units</th>
        <th>topic_description</th>
        <th>assessment</th>
        <th>educ_aims</th>
        <th>learning_outcomes</th>
        <th>last_updated</th>
    </tr>
      
     
    <?php for($i=0; $i<$topics_count; $i++){ ?>
    <tr <?php if($i%2==0) echo "class='even'"; else echo "class='odd'"; ?> >
        <td><?php echo $i + 1; ?></td>
        <td><?php echo $topics[$i]['node']; ?></td>
        <td><?php echo $topics[$i]['keyb']; ?></td>
        <td><?php echo $topics[$i]['keyd']; ?></td>
        <td><?php echo $topics[$i]['keyf']; ?></td>
        <td><?php echo $topics[$i]['keyh']; ?></td>
        <td><?php echo $topics[$i]['keyj']; ?></td>
        <td><?php echo $topics[$i]['keyl']; ?></td>
        <td><?php echo $topics[$i]['keyn']; ?></td>
        <td><?php echo $topics[$i]['keyp']; ?></td>
        <td><?php echo $topics[$i]['keyr']; ?></td>
        <td><?php echo $topics[$i]['keyt']; ?></td>
        <td><?php echo $topics[$i]['keyv']; ?></td>
        <td><?php echo $topics[$i]['keyx']; ?></td>
    </tr>
    <?php } ?>
</table>
</div>

</div>

<br>

<br>


