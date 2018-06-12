

<h4><?php echo $item['itemTitle']; ?></h4>
<p><?php echo $item['itemDescription']; ?></p>

<?php

if ($_SESSION['userinfo']['fan'] == "couc0005") {
//echo "<pre>";

//print_r($_SESSION['nav']);
//
//echo "</pre>";

}

?>	



  <?php if (!(empty($item['overall']['linked']))) { ?>
  <!-- new row for activity group resources -->

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

  <!-- ./ row -->
  <?php } ?>





<h5>Group Learning  Activities</h5>



<?php if (!(empty($item['activities']))) { ?>
<ul>
<?php foreach ($item['activities'] as $activity) { ?>

<?php 
/*    */
switch ($activity['activityType']) {
	
	case 'group':
	
		$liclass = "fa fa-files-o";
		$linktype = "group";
		
		
		// $link = "/flex/ocf/lta/". $activity['itemUuid'] . "/" . $activity['itemVersion'] . "/" . $item['itemTopic'] . "/" . $activity['activityParent'] . "/" . $activity['activityParentVersion']. "/" . $item['depth'];	
		
		
			//$link = "/flex/ocf/ltats/". $activity['itemUuid'] . "/" . $activity['itemVersion'] . "/" . $item['itemTopic'];	
		 
		break;
	
	case 'activity':
	
		$liclass = "fa fa-file-o";
		
		$linktype = "activity";
		//$link = "/flex/ocf/activity/" . $$activity['itemUuid'] . "/" . $itemVersion . "/" . $parent_uuid;
		
		//$link .= 'data-target="#myModal" title="View activity detail';
		
		//$link = "/flex/som/activity/". $activity['itemUuid'] . "/" . $activity['itemVersion'] . "/" . $item['itemTopic'] . "/" . $activity['activityParent'] . "/" . $activity['activityParentVersion'] . "/" . $item['depth'] . "/" . $item['parentItem'];	
		break;
	
	
}


switch ($activity['docondition']) {
	
	case 'alternative':
		$docondition = '<i class="fa fa-share-alt fa-fw" style="margin-right:0.8em;"></i>';
		break;
	case 'optional':
		$docondition = '<i class="fa fa-dot-circle-o fa-fw"  style="margin-right:0.8em;"></i>';
		break;
	default:
		$docondition = '';
		break;
	
}

?>

<li>
<?php if ($linktype == "activity" ) { ?>
<?php echo $docondition; ?><a href = "#" onClick="javascript:activityLoad('/flex/flo-ocf/activityflo/<?php echo $activity['itemUuid']; ?>/<?php echo $activity['itemVersion']; ?>/<?php echo $activity['activityParent']; ?>');" title="View activity detail"><?php echo $activity['title']; ?></a>
<?php } ?>

<?php if ($linktype == "group" ) { ?>

<?php 

$puuid = $activity['activityParent'];
$pversion =  $activity['activityParentVersion'];

 ?>
<?php echo $docondition; ?><a href = "#" onClick="javascript:groupLoad('<?php echo $activity['itemUuid']; ?>','<?php echo $activity['itemVersion']; ?>','<?php echo $item['itemTopic']; ?>','<?php echo $puuid; ?>','<?php echo $pversion; ?>');"  title="View activity group"><?php echo $activity['title']; ?></a>
<?php } ?>
</li>

<?php } ?>
</ul>



<button id="activityReset" class="btn btn-default btn-mini" style="display:none;" onClick="javascript:activityReset();">Reset activity detail</button>
<?php }  // $item['activities'] not empty ?> 