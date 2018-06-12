
  <?php if (!(empty($item['overall']['linked']))) { ?>
  <!-- new row for activity group resources -->
  <div class="row">
    <div class="col-md-6">
      <div class="block block_course_overview" style="margin:2px 2px 0.5em 2px;">
        <h5>Module Resources</h5>
        <ul class="fa-ul">
      <?php foreach ($item['overall']['linked'] as $olinked) { ?>
      <?php
	  
	  
	switch ($olinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		//$linktype = 'file';
		if($olinked['resourceType'] == 'a') {
		$linkuse = '/' . $olinked['itemUuid'] . '/' . $olinked['itemVersion'] . '/' .$olinked['filename'] ; } else {
		
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$olinked['filename'] ; }
		$resourceserver = '/flex/flo-ocf/generatetoken/viewfile/file';
		//$linkclass = 'class="generateToken"';
		
		
		$href = $resourceserver.$linkuse ;
		
		break;
		
	case 'linked-resource': 
	
	
		if($item['pblCase']) { 
		
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = '';	
		$linkuse =  $olinked['itemUuid'] . '/' . $olinked['itemVersion'];
		$resourceserver = '/flex/flo-ocf/caseview/';
		$linkclass = '';
		
		$href = $resourceserver.$linkuse ;
		
		
		} else {
			
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $olinked['itemUuid'] . '/' . $olinked['itemVersion'];
		$resourceserver = $flexserv;
		$linkclass = 'class="generateToken"';
		
		}
		break;
		
		
		
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		
		
		if($olinked['resourceType'] == 'a') {
			$linkuse = '/' . $olinked['itemUuid'] . '/' . $olinked['itemVersion'] . '/' . urlencode(base64_encode($olinked['filename']));
		} else {
			$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . urlencode(base64_encode($olinked['filename']));
		}
	
	
	
		$resourceserver = '/flex/flo-ocf/loadpage/';
		$linkclass = '';
		
		$href = $resourceserver.$linktype.$linkuse ;
		break;
	
	case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'url';	
		break;
	
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
      

    <?php if ($olinked['type'] == 'url') { ?>
    
     <li><?php echo $resourceclass; ?><a href="<?php echo $olinked['url']; ?>" target="_blank"><?php echo $olinked['description']; ?></a></li>
    
    <?php } else { ?>

    <li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" <?php echo $linkclass; ?>><?php echo $olinked['description']; ?></a></li>
      <?php } ?>


    <?php } ?>
        </ul>
      </div>
    </div>
  </div>
  <!-- ./ row -->
  <?php } ?>

