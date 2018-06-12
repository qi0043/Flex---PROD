

  <table class="table-bordered" style="margin-bottom:5em;">
  <thead>
    <tr>
    <th valign="bottom" style="padding:5px;" scope="col">&nbsp;</th>
    <th colspan="6" valign="bottom" class="bg-info" style="padding:5px;" scope="col">Science &amp; Scholarship</th>
    <th colspan="15" valign="bottom" class="bg-warning" style="padding:5px;" scope="col">Clinical Practice</th>
    <th colspan="9" valign="bottom" class="bg-success" style="padding:5px;" scope="col">Health &amp; Society</th>
    <th colspan="10" valign="bottom" class="bg-danger" style="padding:5px;" scope="col">Professionalism &amp; Leadership</th>
    </tr>
    <tr>
      <th valign="bottom" style="padding:5px;" scope="col">&nbsp;</th>
      <?php for ($i = 1; $i <= 40; $i++ ) { ?>
      <th valign="bottom" style="padding:5px; width:4.2em;" scope="col"><a href="amcgosearch/<?php echo strtolower($topics[1]['prof']['los']['lo'.$i]['code']);?>"><?php echo $topics[1]['prof']['los']['lo'.$i]['code'];?></a><?php if (strlen($topics[1]['prof']['los']['lo'.$i]['code']) < 4) { ?>&nbsp;<?php } ?></th>
 <?php } ?>  
    </tr>

  </thead>
  <tbody>  
 <?php foreach ($topics as $topic) { ?>
    <tr>
      <td style="padding:5px; padding-right:3em;">
      <a href="topic/<?php echo $topic['uuid']; ?>/<?php echo $topic['version']; ?>" title="<?php echo $topic['title']; ?>"><?php echo $topic['code']; ?></a>
      </td>
      <?php for ($i = 1; $i <= 40; $i++ ) { ?>
      <td align="center" style="padding:5px;" <?php if($topic['prof']['los']['lo'.$i]['numAlign'] > 0) { ?> class="notNullBG"<?php } ?>><?php if ($topic['prof']['los']['lo'.$i]['level'] == 1) { ?>
<?php 

switch ($topic['prof']['los']['lo'.$i]['level']) {
	
	case 1:
		$w = 16;
		$h = 16;
		break;
		
	case 2:
		$w = 28;
		$h = 17;
		break;
	
	case 3:
		$w = 31;
		$h = 31;
		break;
	
	
}

?>
<img src="<?php echo base_url() . 'resource/ocf/';?>images/heat<?php echo $topic['prof']['los']['lo'.$i]['level']; ?>.png" alt="level<?php echo $topic['prof']['los']['lo'.$i]['level']; ?>" width="24" height="24" data-toggle="tooltip" data-placement="top" title="Level <?php echo $topic['prof']['los']['lo'.$i]['level']; ?>"><?php } else { ?>&nbsp;<?php } ?></td>
   <?php } ?>  
    </tr>
    
<?php } ?>
</tbody>
  </table>
