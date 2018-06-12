<?php


switch ($_SERVER['SERVER_NAME']) {


    case "flextra.flinders.edu.au":
    
        $flexserv = "https://flex.flinders.edu.au";
        break;

    case "flextra-test.flinders.edu.au":
    
        $flexserv = "https://flex-test.flinders.edu.au";
        break;


    case "flextra-dev.flinders.edu.au":
    
        $flexserv = "https://flex-dev.flinders.edu.au";
        break;

}



$typesofteaching = array(
	'Presentation' => 'Presentation / lecture',
	'Interactive large group' => 'Interactive large group / seminar /workshop / review session',
	'Facilitated small group' => "Facilitated small group 'discussion' / tutorial",
	'Practical' => 'Practical / laboratory / clinical skill simulation',
	'Individual self-directed' => 'Individual self-directed / self-paced',
	'Work-based environment' => 'Work-based environment / placement ',
	'Other' => 'Other / unsure'
	);

$thetype = isset($item['teachingType'])?$item['teachingType']:'';


?>


<script type="text/javascript">

$(document).ready(function(){

	
	
	 $('[data-toggle="myTooltip"]').tooltip();


});  

</script>


<script type="text/javascript">


//$(document).ready(function() {

  
  
  //$('#changeName').click(function(e) {
  function editItemName(url) {	
	  // e.preventDefault(); // do not follow link
	  $('#updateComplete').alert('close');
	   $('#editComplete').alert('close');
	  
 //var url = $(this).attr('href');
	//alert(url);
	$('#itemName').html('<h4 class="modal-title" id="myModalLabel"><span class="text-muted">Loading edit tool…</span>  <i class="fa fa-spinner fa-spin fa-fw text-muted"></i></h4>');
    $('#itemName').load(url) ;
	
	
	$('#changeName').addClass("disabled");
		$('#editDescription').addClass("disabled");
		$('#editItem').addClass("disabled");
	
	
	//alert(textStatus);
    return false;
  }
  

 function editItemDesc(url) {	     

   //$('#editDescription').click(function(e) {
	  // e.preventDefault(); // do not follow link
	  $('#editComplete').alert('close');
	   $('#updateComplete').alert('close');
        //var url = $(this).attr('href');
	//alert(url);
	var divHeight = $('#itemDescription').height();
	//alert(divHeight);
	$('#itemDescription').css("min-height",divHeight);
	
	$('#itemDescription').html('<p><span class="text-muted">Loading edit tool…</span>  <i class="fa fa-spinner fa-spin fa-fw text-muted"></i></p>');
    $('#itemDescription').load(url) ;
	$('#changeName').addClass("disabled");
		$('#editDescription').addClass("disabled");
		$('#editItem').addClass("disabled");
	
	
	//alert(textStatus);
    return false;
  };
  
   function editItemDesc(url) {	     

   //$('#editDescription').click(function(e) {
	  // e.preventDefault(); // do not follow link
	  $('#editComplete').alert('close');
	   $('#updateComplete').alert('close');
        //var url = $(this).attr('href');
	//alert(url);
	var divHeight = $('#itemDescription').height();
	//alert(divHeight);
	$('#itemDescription').css("min-height",divHeight);
	
	$('#itemDescription').html('<p><span class="text-muted">Loading edit tool…</span>  <i class="fa fa-spinner fa-spin fa-fw text-muted"></i></p>');
    $('#itemDescription').load(url) ;
	$('#changeName').addClass("disabled");
		$('#editDescription').addClass("disabled");
		$('#editItem').addClass("disabled");
	
	
	//alert(textStatus);
    return false;
  };
  
  
 $(document).ready(function() {
    
  $('a.generateToken').click(function(e) {
      return;
	   e.preventDefault(); // do not follow link

	  
 var url = $(this).attr('href');
	//alert(url);

	var tokenGenerator = '/flex/ocf/generatetoken/';
	//alert(tokenGenerator);
	
	
	$.ajax({
    url: '/flex/ocf/generatetoken/',
    type: 'GET',
    success: function(data){ 
        var newURL = url + '?token=' + data;
		//alert( "URL = " + newURL );
		window.open(newURL);
    },
    error: function(data) {
        alert( "Error creating token" );//or whatever
    }
});
	
	
	
	
	//alert(textStatus);
    return false;
  });
  
  
});


</script>

<style type="text/css">

.lBtn {
	
	text-align:left; 
	padding-left:6px;
}

</style>

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <div id="itemName">
    <h4 class="modal-title" id="myModalLabel"><!--<i class="fa fa-file-o fa-fw"></i> --><?php echo $item['itemTitle']; ?></h4>
    </div>
    
      <p class="small"><em>Managed by:
      <?php if(!empty($upd_privilege['mgmgrps'])) {
          $mgmgrps_str = implode(', ', $upd_privilege['mgmgrps']); $mgmgrps_lnk = implode(' or ', $upd_privilege['mgmgrps']);
	  #$mgmgrps_lnk = $flexserv . '/access/searching.do?in=C' . $item['ocf_groups_collection'] . '&q=' . htmlentities($mgmgrps_lnk);
      ?>   
      <a target='_blank' href='<?php echo base_url() . "ocf/generatetoken/view_mgmgrps/" . htmlentities($mgmgrps_lnk)?>/'> <?php echo $mgmgrps_str; ?> </a></em><a target='_blank' href='<?php echo base_url() . "ocf/generatetoken/view_mgmgrps/" . htmlentities($mgmgrps_lnk)?>/'></a></p>
      
      <?php } ?>

      <?php if ($_SERVER['REMOTE_USER'] == 'couc0005' || $_SERVER['REMOTE_USER'] == 'chan0604' ) { ?>
      <p class="small">FLO LTI link for copy/paste: <a href="https://flextra.flinders.edu.au/flex/flo-ocf/flosom/index/4/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $item['itemTopic']; ?>" target="_blank">https://flextra.flinders.edu.au/flex/flo-ocf/flosom/index/4/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $item['itemTopic']; ?></a></p>
      <?php } ?>

  </div>
  <!-- / modal-header -->
  
  <div class="modal-body">
<?php 
/*if($_SERVER['REMOTE_USER'] == 'qi0043')
{
	echo 'ITEM ARRAY: <pre>';
	print_r($item);
	echo '</pre>';
}*/
?>


<?php if (isset($_SESSION['ocf_ldapauth'])) { ?>

<div class="row" style="margin-bottom:0.5em;" id="itemdetail">
<div class="col-md-10 col-sm-8 col-xs-12">
<div id="itemDescription">
<p><?php echo $item['itemDescription']; ?></p>
</div>

  <?php if (!(empty($item['overall']))) { ?>  
<!--<h5 class="text-">Activity-wide instructions/resources</h5>-->


     <?php if (isset($item['overall']['instructions']) && !(empty($item['overall']['instructions']))) { ?>
    <div class="col-md-6 col-sm-12 col-xs-12">
      <ul class="fa-ul">
      <?php
          if(isset($item['overall']['instructions']['type']))
          {
			  $resourceclass = '';
			  $href = '';
			  $desc = '';
			  $resourceserver = '';
				switch ($item['overall']['instructions']['type']) 
				{
					case 'htmlpage':
						$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
						$linktype = 'file';
						$resourceserver = '/flex/ocf/loadpage/file';
						
						if(isset($item['overall']['instructions']['resourceType']) && $item['overall']['instructions']['resourceType'] == 'a') {
							$theUuid = $item['overall']['instructions']['itemUuid'];
							$theVersion = $item['overall']['instructions']['itemVersion'];
						} 
						else {
							$theUuid = $item['thisUuid'];
							$theVersion = $item['thisVersion'];
						}
						
						$linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($item['overall']['instructions']['filename']));
						
						
						$href = $resourceserver.$linkuse ;
						$desc = $item['overall']['instructions']['description'];
						
						break;
						
					case 'linked-resource':
						if(isset($item['overall']['instructions']['linked_resources']))
						{
							foreach($item['overall']['instructions']['linked_resources'] as $rlink)
							{
								if(isset($rlink['type']))
								{
									switch($rlink['type'])
									{
										case 'htmlpage':
											$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
											$linktype = 'file';
											$resourceserver = '/flex/ocf/loadpage/file';
											
											if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
											{
												$theUuid = $rlink['itemUuid'];
												$theVersion = $rlink['itemVersion'];
											} 
											else 
											{
												$theUuid = $item['thisUuid'];
												$theVersion = $item['thisVersion'];
											}
											
											$linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($rlink['filename']));
											
											$href = $resourceserver.$linkuse;
											
										break;	
										case 'file':
											$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
											if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
											{
												//$linkuse = '/' . $rlink['thisUuid'] . '/' . $rlink['thisVersion'] . '/' .$rlink['uuid']; 
												$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$item['overall']['instructions']['uuid']; 
											} 
											else 
											{
												$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$item['overall']['instructions']['uuid']; 
											}
											
											
											$resourceserver = '/flex/ocf/generatetoken/viewitem/items';
											$href = $resourceserver.$linkuse ;
										break;
									}
									$desc = $rlink['description'];
								}
							}
						}
					break;
						
					default:
							$resourceclass = '';
							break;
				}?>
	   <li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
	<?php }  ?> 
        
      </ul>
    </div>
    <?php } ?>
    
    
    <?php if (!(empty($item['overall']['linked']))) { 
	
	?>
      <div class="col-md-6 col-sm-12 col-xs-12">

    <ul class="fa-ul">
    	<?php foreach($item['overall']['linked'] as $rlink)
		{
			$resourceclass = '';
			$href = '';
			$desc = '';
			$resourceserver = '';
			
			switch($rlink['type'])
			{
				case 'linked-resource':  //linked to item summary page
					
					if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'p')
					{
						$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
						if(isset($rlink['pbl']) && $rlink['pbl'] == 'True') 
						{
							$linkuse =  $rlink['itemUuid'] . '/' . $rlink['itemVersion'];
							$resourceserver = '/flex/ocf/caseview/';
							$href = $resourceserver.$linkuse ;
							$desc = 'Case Page: '. $rlink['description'];
						}
						else
						{
							$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
							$resourceserver = '/flex/ocf/generatetoken/viewitem/items';
							$href = $resourceserver.$linkuse;
						}
					}
					
				break;
				
				case 'htmlpage':
				    // link to a shared resource attachment and the attachment type is webpage
					$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
					$linktype = 'file';
					$resourceserver = '/flex/ocf/loadpage/file';
					$theUuid = '';
					$theVersion = '';
					if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a')
					{
						$theUuid = $rlink['itemUuid'];
						$theVersion = $rlink['itemVersion'];
					}
					else //a webpage attachment attched
					{
						$theUuid = $item['thisUuid'];
						$theVersion = $item['thisVersion'];
					}
					$linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($rlink['filename']));
					$href = $resourceserver.$linkuse;
				
				break;
				
				/*case 'file':
					$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
					$linkuse = '';
					if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
					{
						//$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['uuid']; 
						$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
					} 
					else 
					{
						$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['filename']; 
					}
					
					
					$resourceserver = '/flex/ocf/generatetoken/viewfile/file';
					$href = $resourceserver.$linkuse ;
				break;*/
				case 'file':
					$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
					$linkuse = '';
					if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
					{
						//$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['uuid']; 
						$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
					} 
					else 
					{
						$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . $rlink['uuid']; 
					}
					
					
					$resourceserver = '/flex/ocf/generatetoken/viewitem/items';
					$href = $resourceserver.$linkuse ;

				break;
				
				case 'url';
					$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
					$href = $rlink['url'];	
				break;
			}
			
			
			
			$desc = isset($rlink['description'])?$rlink['description']:'To be added';
			if(isset($rlink['pbl']) && $rlink['pbl'] == 'True') 
			{
				if (isset($item['hideLink']) && $item['hideLink'] != 1)
				{
					$desc = 'Case page: '.$desc;
				}
				else
				{
					//$href = '';
					$desc = 'Case page: '.$desc . ' (Link will be activated after completion of case)';
				}
			
			}
			?>
			<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
		<?php }?>
    </ul>
    </div>
    <?php } ?>
    <?php } ?>


</div>

 <div class="col-md-2 col-sm-4 col-xs-12 noPrint"> 
 <!-- edit button --> 
 
   <?php /*?> <?php if($activity_level > 1)
	{?><?php */?>
	<?php    if($upd_privilege['has_privilege'] == 'Yes'  )
	    {
	    ?>
		<?php $itemname_url = '/flex/ocf/editname/' . $item['thisUuid'] . '/' . $item['thisVersion'];  ?>
		<?php $itemdesc_url = '/flex/ocf/editdescription/' . $item['thisUuid'] . '/' . $item['thisVersion'];  ?>
		<?php if($upd_privilege['locks']['item_name'] != 'Yes'){ ?>
		<a href="#" onClick="javascript: editItemName('<?php echo $itemname_url;?>'); return false;" id="changeName" class="btn btn-sm btn-warning btn-block lBtn"><i class="fa fa-edit"></i> Edit name</a> 
		<?php } else { ?>
		<button class="btn btn-default btn-block btn-sm lBtn" disabled="disabled"><i class="fa fa-lock"></i>&nbsp;Name</button> 
		<?php } ?>

		<?php if($upd_privilege['locks']['item_description'] != 'Yes'){ ?>
		<a href="#" onClick="javascript: editItemDesc('<?php echo $itemdesc_url;?>'); return false;" id="editDescription" class="btn btn-sm btn-warning btn-block lBtn"><i class="fa fa-edit"></i> Edit Overview</a> 
		<?php } else { ?>
		<button class="btn btn-default btn-block btn-sm lBtn" disabled="disabled"><i class="fa fa-lock"></i>&nbsp;Overview</button> 
		<?php } ?>
	  <?php }?>

	  <?php if( $upd_privilege['is_contributor'] == 'Yes' || $upd_privilege['is_eqadmin'] == 'Yes'){ ?>
    
	    <a id="editItem" target='_blank' href="/flex/ocf/generatetoken/editactivity/items/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>" class="btn btn-sm btn-danger btn-block lBtn generateToken" data-toggle="myTooltip"  data-placement="left" title="Edit this item in FLEX"><i class="fa fa-edit"></i> Edit activity</a>
	  <?php } ?>
    <?php /*?><?php } ?><?php */?>


</div>


</div>   <!-- / row --> 

<div class="row">

<?php if (!(empty($activity_los))) { ?>
<div class="col-md-12">


<h4>Learning Objectives</h4>

<dl class="dl-horizontal">
<?php foreach ($activity_los as $activitylo) { ?>
<dt><?php echo $activitylo['code']; ?></dt>
<dd><?php echo $activitylo['name']; ?></dd>
<?php } ?>
</dl>

</div>   <!-- / col-md-12 --> 
<?php }  //  lo not empty   ?>

<!--

<?php if (!(empty($los['los']))) { ?>

<div class="col-md-12">


<h4> Aligned Outcomes</h4>

<dl class="dl-horizontal">
<?php foreach ($los['los'] as $alignedlo) { ?>
<dt><?php echo $alignedlo['code']; ?></dt>
<dd><?php echo $alignedlo['name']; ?></dd>
<?php } ?>
</dl>
</div>  

<?php }  //  lo not empty   ?>
-->



<div class="col-md-12">
<?php 

$loEmpty = empty($los);

?>

</div>   <!-- / col-md-12 --> 

<!-- panel for resources -->


<?php if ( !(empty($item['pre'])) || !(empty($item['during'])) || !(empty($item['post'])) || !(empty($item['teachingTeam']))  ) { ?> 
<div class="col-md-12">
<div class="panel panel-default">

  
  
  
 <?php if (!(empty($item['pre']))) { ?>  
<div class="row"> <!-- pre-activity -->
 
    <div class="col-md-12">
        <div class="panel panel-default" style="margin-bottom:0;">
        <div class="panel-heading ">
        	<h5 class="panel-title">Pre-Activity</h5>
        </div>
    	<div class="panel-body" >

 <?php if (!(empty($item['pre']['instructions']))) { ?>
     <ul class="fa-ul">
       <?php
          if(isset($item['pre']['instructions']['type']))
          {
			  $resourceclass = '';
			  $href = '';
			  $desc = '';
			  $resourceserver = '';
				switch ($item['pre']['instructions']['type']) 
				{
					case 'htmlpage':
						$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
						$linktype = 'file';
						$resourceserver = '/flex/ocf/loadpage/file';
						
						if(isset($item['pre']['instructions']['resourceType']) && $item['pre']['instructions']['resourceType'] == 'a') {
							$theUuid = $item['pre']['instructions']['itemUuid'];
							$theVersion = $item['pre']['instructions']['itemVersion'];
						} 
						else {
							$theUuid = $item['thisUuid'];
							$theVersion = $item['thisVersion'];
						}
						
						$linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($item['pre']['instructions']['filename']));
						
						
						$href = $resourceserver.$linkuse ;
						$desc = $item['pre']['instructions']['description'];
						
						break;
						
					case 'linked-resource':
						if(isset($item['pre']['instructions']['linked_resources']))
						{
							foreach($item['pre']['instructions']['linked_resources'] as $rlink)
							{
								if(isset($rlink['type']))
								{
									switch($rlink['type'])
									{
										case 'htmlpage':
											$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
											$linktype = 'file';
											$resourceserver = '/flex/ocf/loadpage/file';
											
											if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
											{
												$theUuid = $rlink['itemUuid'];
												$theVersion = $rlink['itemVersion'];
											} 
											else {
												$theUuid = $item['thisUuid'];
												$theVersion = $item['thisVersion'];
											}
											
											$linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($rlink['filename']));
											
											$href = $resourceserver.$linkuse;
											
										break;	
										case 'file':
                                            $resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
											$linkuse = '';
											if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
											{
												//$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['uuid']; 
												$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$item['pre']['instructions']['uuid']; 
											} 
											else 
											{
												$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$item['pre']['instructions']['uuid']; 
											}
											
											
											$resourceserver = '/flex/ocf/generatetoken/viewitem/items';
											$href = $resourceserver.$linkuse ;

                                        break;
									}
									$desc = $rlink['description'];
								}
							}
						}
						elseif(isset($item['pre']['instructions']['resourceType']) && $item['pre']['instructions']['resourceType'] == 'p') //link to a shared resource summary page
							{
								$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
								if(isset($item['pre']['instructions']['pbl']) && $item['pre']['instructions']['pbl'] == 'True') 
								{
									$linkuse =  $item['pre']['instructions']['itemUuid'] . '/' . $item['pre']['instructions']['itemVersion'];
									$resourceserver = '/flex/ocf/caseview/';
									$href = $resourceserver.$linkuse ;
									$desc = 'Case Page: '. $item['pre']['instructions']['description'];
								}
								else
								{
									$theUuid = $item['pre']['instructions']['itemUuid'];
									$theVersion = $item['pre']['instructions']['itemVersion'];
									$resourceserver = '/flex/ocf/generatetoken/viewSummaryPage';
									$linkuse = '/items/' . $theUuid . '/' . $theVersion . '/';
									$href = $resourceserver.$linkuse ;
									$desc = $item['pre']['instructions']['description'];
								}
							}
					break;
						
					default:
							$resourceclass = '';
							break;
				}?>
				<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
	<?php }  ?> 
  	</ul>
<?php } ?>

<?php if (!(empty($item['pre']['linked']))) { ?>
   <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
    <ul class="fa-ul">
    	<?php foreach($item['pre']['linked'] as $rlink)
		{
			$resourceclass = '';
			$href = '';
			$desc = '';
			$resourceserver = '';
			
			switch($rlink['type'])
			{
				case 'linked-resource':  //linked to item summary page
					if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'p')
					{
						$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
						if(isset($rlink['pbl']) && $rlink['pbl'] == 'True') 
						{
							$linkuse =  $rlink['itemUuid'] . '/' . $rlink['itemVersion'];
							$resourceserver = '/flex/ocf/caseview/';
							$href = $resourceserver.$linkuse ;
							$desc = 'Case Page: '. $rlink['description'];
						}
						else
						{
							$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
							$resourceserver = '/flex/ocf/generatetoken/viewitem/items';
							$href = $resourceserver.$linkuse;
						}
					}
					
				break;
				
				case 'htmlpage':
				    // link to a shared resource attachment and the attachment type is webpage
					$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
					$linktype = 'file';
					$resourceserver = '/flex/ocf/loadpage/file';
					$theUuid = '';
					$theVersion = '';
					if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a')
					{
						$theUuid = $rlink['itemUuid'];
						$theVersion = $rlink['itemVersion'];
					}
					else //a webpage attachment attched
					{
						$theUuid = $item['thisUuid'];
						$theVersion = $item['thisVersion'];
					}
					$linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($rlink['filename']));
					$href = $resourceserver.$linkuse;
				
				break;
				
				case 'file':
					$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
					$linkuse = '';
					if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
					{
						//$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['uuid']; 
						$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
					} 
					else 
					{
						$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
					}
					
					
					$resourceserver = '/flex/ocf/generatetoken/viewitem/items';
					$href = $resourceserver.$linkuse ;

				break;
				
				case 'url';
					$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
					$href = $rlink['url'];	
				break;
			}
			$desc = isset($rlink['description'])?$rlink['description']:'To be added';
			if(isset($rlink['pbl']) && $rlink['pbl'] == 'True') 
			{
				$desc = 'Case page: '.$desc;
			
			}
			?>
			<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
		<?php }?>
    </ul>
    <?php } ?>
 </div>
  </div>
  </div>
 
</div> <!-- / pre-activity  -->
 <?php } // pre not empty ?>
 
 
 
 
 <?php if (!(empty($item['during']))) { ?> 
<div class="row"> <!-- during activity -->

  <div class="col-md-12">
  <div class="panel panel-default" style="margin-bottom:0;">
   <div class="panel-heading ">
   <h5 class="panel-title">During Activity</h5>
   </div>
   <div class="panel-body" >
    <?php if (!(empty($item['during']['instructions']))) { ?>
        <ul class="fa-ul">
           <?php
              if(isset($item['during']['instructions']['type']))
              {
                  $resourceclass = '';
                  $href = '';
                  $desc = '';
                  $resourceserver = '';
                    switch ($item['during']['instructions']['type']) 
                    {
                        case 'htmlpage':
                            $resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
                            $linktype = 'file';
                            $resourceserver = '/flex/ocf/loadpage/file';
                            
                            if(isset($item['during']['instructions']['resourceType']) && $item['during']['instructions']['resourceType'] == 'a') {
                                $theUuid = $item['during']['instructions']['itemUuid'];
                                $theVersion = $item['during']['instructions']['itemVersion'];
                            } 
                            else {
                                $theUuid = $item['thisUuid'];
                                $theVersion = $item['thisVersion'];
                            }
                            
                            $linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($item['during']['instructions']['filename']));
                            
                            
                            $href = $resourceserver.$linkuse ;
                            $desc = $item['during']['instructions']['description'];
                            
                            break;
                            
                        case 'linked-resource':
                            if(isset($item['during']['instructions']['linked_resources']))
                            {
                                foreach($item['during']['instructions']['linked_resources'] as $rlink)
                                {
                                    if(isset($rlink['type']))
                                    {
                                        switch($rlink['type'])
                                        {
                                            case 'htmlpage':
                                                $resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
                                                $linktype = 'file';
                                                $resourceserver = '/flex/ocf/loadpage/file';
                                                
                                                if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
                                                {
                                                    $theUuid = $rlink['itemUuid'];
                                                    $theVersion = $rlink['itemVersion'];
                                                } 
                                                else {
                                                    $theUuid = $item['thisUuid'];
                                                    $theVersion = $item['thisVersion'];
                                                }
                                                
                                                $linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($rlink['filename']));
                                                
                                                $href = $resourceserver.$linkuse;
                                                
                                            break;	
											
                                            case 'file':
												$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
												$linkuse = '';
												if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
												{
													//$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['uuid']; 
													$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$item['during']['instructions']['uuid']; 
												} 
												else 
												{
													$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . $item['during']['instructions']['uuid']; 
												}
												
												
												$resourceserver = '/flex/ocf/generatetoken/viewitem/items';
												$href = $resourceserver.$linkuse ;

                                       		break;
                                        }
                                        $desc = $rlink['description'];
                                    }
                                }
                            }
							elseif(isset($item['during']['instructions']['resourceType']) && $item['during']['instructions']['resourceType'] == 'p') //link to a shared resource summary page
							{
								$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
								if(isset($item['during']['instructions']['pbl']) && $item['during']['instructions']['pbl'] == 'True') 
								{
									$linkuse =  $item['during']['instructions']['itemUuid'] . '/' . $item['during']['instructions']['itemVersion'];
									$resourceserver = '/flex/ocf/caseview/';
									$href = $resourceserver.$linkuse ;
									$desc = 'Case Page: '. $item['during']['instructions']['description'];
								}
								else
								{
									$theUuid = $item['during']['instructions']['itemUuid'];
									$theVersion = $item['during']['instructions']['itemVersion'];
									$resourceserver = '/flex/ocf/generatetoken/viewSummaryPage';
									$linkuse = '/items/' . $theUuid . '/' . $theVersion . '/';
									$href = $resourceserver.$linkuse ;
									$desc = $item['during']['instructions']['description'];
								}
							}
                        break;
                            
                        default:
                                $resourceclass = '';
                                break;
                    }?>
                    <li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
        <?php }  ?>  
        </ul>
     <?php } ?>
     
      <?php if (!(empty($item['during']['linked']))) { ?>
     <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
     <ul class="fa-ul">
     	<?php foreach($item['during']['linked'] as $rlink)
		{
			$resourceclass = '';
			$href = '';
			$desc = '';
			$resourceserver = '';
			
			switch($rlink['type'])
			{
				case 'linked-resource':  //linked to item summary page
					if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'p')
					{
						$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
						if(isset($rlink['pbl']) && $rlink['pbl'] == 'True') 
						{
							$linkuse =  $rlink['itemUuid'] . '/' . $rlink['itemVersion'];
							$resourceserver = '/flex/ocf/caseview/';
							$href = $resourceserver.$linkuse ;
							$desc = 'Case Page: '. $rlink['description'];
						}
						else
						{
							$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
							$resourceserver = '/flex/ocf/generatetoken/viewitem/items';
							$href = $resourceserver.$linkuse;
						}
					}
					
				break;
				
				case 'htmlpage':
				    // link to a shared resource attachment and the attachment type is webpage
					$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
					$linktype = 'file';
					$resourceserver = '/flex/ocf/loadpage/file';
					$theUuid = '';
					$theVersion = '';
					if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a')
					{
						$theUuid = $rlink['itemUuid'];
						$theVersion = $rlink['itemVersion'];
					}
					else //a webpage attachment attched
					{
						$theUuid = $item['thisUuid'];
						$theVersion = $item['thisVersion'];
					}
					$linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($rlink['filename']));
					$href = $resourceserver.$linkuse;
				
				break;
				
				case 'file':
					$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
					$linkuse = '';
					if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
					{
						//$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['uuid']; 
						$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
					} 
					else 
					{
						$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
					}
					
					
					$resourceserver = '/flex/ocf/generatetoken/viewitem/items';
					$href = $resourceserver.$linkuse ;

				break;
				
				case 'url';
					$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
					$href = $rlink['url'];	
				break;
			}
			$desc = isset($rlink['description'])?$rlink['description']:'To be added';
			if(isset($rlink['pbl']) && $rlink['pbl'] == 'True') 
			{
				$desc = 'Case page: '.$desc;
			
			}
			?>
			<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
		<?php }?>
     </ul>
     <?php } ?>
   </div>
  </div>
  </div>
 
</div> <!-- / during activity  -->
 <?php } ?>
 
 
 
<?php if (!(empty($item['post']))) { ?> 
<div class="row"> <!-- post activity -->
  <div class="col-md-12">
  <div class="panel panel-default" style="margin-bottom:0;">
   <div class="panel-heading ">
   <h5 class="panel-title">Post Activity</h5>
   </div>
   <div class="panel-body" >
    <?php if (!(empty($item['post']['instructions']))) { ?>
    <ul class="fa-ul">
	   <?php
          if(isset($item['post']['instructions']['type']))
          {
              $resourceclass = '';
              $href = '';
              $desc = '';
              $resourceserver = '';
                switch ($item['post']['instructions']['type']) 
                {
                    case 'htmlpage':
                        $resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
                        $linktype = 'file';
                        $resourceserver = '/flex/ocf/loadpage/file';
                        
                        if(isset($item['post']['instructions']['resourceType']) && $item['post']['instructions']['resourceType'] == 'a') {
                            $theUuid = $item['post']['instructions']['itemUuid'];
                            $theVersion = $item['post']['instructions']['itemVersion'];
                        } 
                        else {
                            $theUuid = $item['thisUuid'];
                            $theVersion = $item['thisVersion'];
                        }
                        
                        $linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($item['post']['instructions']['filename']));
                        
                        
                        $href = $resourceserver.$linkuse ;
                        $desc = $item['post']['instructions']['description'];
                        
                        break;
                        
                    case 'linked-resource':
                        if(isset($item['post']['instructions']['linked_resources']))
                        {
                            foreach($item['post']['instructions']['linked_resources'] as $rlink)
                            {
                                if(isset($rlink['type']))
                                {
                                    switch($rlink['type'])
                                    {
                                        case 'htmlpage':
                                            $resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
                                            $linktype = 'file';
                                            $resourceserver = '/flex/ocf/loadpage/file';
                                            
                                            if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
                                            {
                                                $theUuid = $rlink['itemUuid'];
                                                $theVersion = $rlink['itemVersion'];
                                            } 
                                            else {
                                                $theUuid = $item['thisUuid'];
                                                $theVersion = $item['thisVersion'];
                                            }
                                            
                                            $linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($rlink['filename']));
                                            
                                            $href = $resourceserver.$linkuse;
                                            
                                        break;	
                                        case 'file':
                                            $resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
											$linkuse = '';
											if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
											{
												$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$item['post']['instructions']['uuid']; 
												//$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['uuid']; 
											} 
											else 
											{
												$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$item['post']['instructions']['uuid']; 
											}
											
											
											$resourceserver = '/flex/ocf/generatetoken/viewitem/items';
											$href = $resourceserver.$linkuse ;

                                        break;
                                    }
                                    $desc = $rlink['description'];
                                }
                            }
                        }
						elseif(isset($item['post']['instructions']['resourceType']) && $item['post']['instructions']['resourceType'] == 'p') //link to a shared resource summary page
						{
							$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
							if(isset($item['post']['instructions']['pbl']) && $item['post']['instructions']['pbl'] == 'True') 
							{
								$linkuse =  $item['post']['instructions']['itemUuid'] . '/' . $item['post']['instructions']['itemVersion'];
								$resourceserver = '/flex/ocf/caseview/';
								$href = $resourceserver.$linkuse ;
								$desc = 'Case Page: '. $item['post']['instructions']['description'];
							}
							else
							{
								$theUuid = $item['post']['instructions']['itemUuid'];
								$theVersion = $item['post']['instructions']['itemVersion'];
								$resourceserver = '/flex/ocf/generatetoken/viewSummaryPage';
								$linkuse = '/items/' . $theUuid . '/' . $theVersion . '/';
								$href = $resourceserver.$linkuse ;
								$desc = $item['post']['instructions']['description'];
							}
						}
                    break;
                        
                    default:
                            $resourceclass = '';
                            break;
                }?>
                <li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
    <?php }  ?>  
    </ul>
     <?php } ?>
     
      <?php if (!(empty($item['post']['linked']))) { ?>
     <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
     <ul class="fa-ul">
     	<?php foreach($item['post']['linked'] as $rlink)
		{
			$resourceclass = '';
			$href = '';
			$desc = '';
			$resourceserver = '';
			
			switch($rlink['type'])
			{
				case 'linked-resource':  //linked to item summary page
					if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'p')
					{
						$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
						if(isset($rlink['pbl']) && $rlink['pbl'] == 'True') 
						{
							$linkuse =  $rlink['itemUuid'] . '/' . $rlink['itemVersion'];
							$resourceserver = '/flex/ocf/caseview/';
							$href = $resourceserver.$linkuse ;
							$desc = 'Case Page: '. $rlink['description'];
						}
						else
						{
							$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
							$resourceserver = '/flex/ocf/generatetoken/viewitem/items';
							$href = $resourceserver.$linkuse;
						}
					}
					
				break;
				
				case 'htmlpage':
				    // link to a shared resource attachment and the attachment type is webpage
					$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
					$linktype = 'file';
					$resourceserver = '/flex/ocf/loadpage/file';
					$theUuid = '';
					$theVersion = '';
					if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a')
					{
						$theUuid = $rlink['itemUuid'];
						$theVersion = $rlink['itemVersion'];
					}
					else //a webpage attachment attched
					{
						$theUuid = $item['thisUuid'];
						$theVersion = $item['thisVersion'];
					}
					$linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($rlink['filename']));
					$href = $resourceserver.$linkuse;
				
				break;
				
				case 'file':
					$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
					$linkuse = '';
					if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
					{
						//$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['uuid']; 
						$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
					} 
					else 
					{
						$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
					}
					
					
					$resourceserver = '/flex/ocf/generatetoken/viewitem/items';
					$href = $resourceserver.$linkuse ;
				break;
				
				case 'url';
					$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
					$href = $rlink['url'];	
				break;
			}
			$desc = isset($rlink['description'])?$rlink['description']:'To be added';
			if(isset($rlink['pbl']) && $rlink['pbl'] == 'True') 
			{
				$desc = 'Case page: '.$desc;
			
			}
			?>
			<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
		<?php }?>
     </ul>
     <?php } ?>
   </div>
  </div>
  </div>
</div> <!-- / post activity  -->

 <?php } ?>
 
 <?php if (!(empty($item['teachingTeam']))) { ?>
 <div class="row"> <!-- teaching team -->
  <div class="col-md-12">
  <div class="panel panel-danger" style="margin-bottom:0;">
    <div class="panel-heading ">
   <h5 class="panel-title">Teaching Team Only</h5>
   </div>
   
 <div class="panel-body" >
 
   <!-- teaching team instructions -->
 <?php if (!(empty($item['teachingTeam']['instructions']))) { ?>

	<ul class="fa-ul">
    <?php
          if(isset($item['teachingTeam']['instructions']['type']))
          {
              $resourceclass = '';
              $href = '';
              $desc = '';
              $resourceserver = '';
                switch ($item['teachingTeam']['instructions']['type']) 
                {
                    case 'htmlpage':
                        $resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
                        $linktype = 'file';
                        $resourceserver = '/flex/ocf/loadpage/file';
                        
                        if(isset($item['teachingTeam']['instructions']['resourceType']) && $item['teachingTeam']['instructions']['resourceType'] == 'a') {
                            $theUuid = $item['teachingTeam']['instructions']['itemUuid'];
                            $theVersion = $item['teachingTeam']['instructions']['itemVersion'];
                        } 
                        else {
                            $theUuid = $item['thisUuid'];
                            $theVersion = $item['thisVersion'];
                        }
                        
                        $linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($item['teachingTeam']['instructions']['filename']));
                        
                        
                        $href = $resourceserver.$linkuse ;
                        $desc = $item['teachingTeam']['instructions']['description'];
                        
                        break;
                        
                    case 'linked-resource':
                        if(isset($item['teachingTeam']['instructions']['linked_resources']))
                        {
                            foreach($item['teachingTeam']['instructions']['linked_resources'] as $rlink)
                            {
                                if(isset($rlink['type']))
                                {
                                    switch($rlink['type'])
                                    {
                                        case 'htmlpage':
                                            $resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
                                            $linktype = 'file';
                                            $resourceserver = '/flex/ocf/loadpage/file';
                                            
                                            if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
                                            {
                                                $theUuid = $rlink['itemUuid'];
                                                $theVersion = $rlink['itemVersion'];
                                            } 
                                            else {
                                                $theUuid = $item['thisUuid'];
                                                $theVersion = $item['thisVersion'];
                                            }
                                            
                                            $linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($rlink['filename']));
                                            
                                            $href = $resourceserver.$linkuse;
                                            
                                        break;	
                                        case 'file':
                                            $resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
											$linkuse = '';
											if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
											{
												//$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['uuid'];
												$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$item['teachingTeam']['instructions']['uuid'];  
											} 
											else 
											{
												$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$item['teachingTeam']['instructions']['uuid']; 
											}
											
											
											$resourceserver = '/flex/ocf/generatetoken/viewitem/items';
											$href = $resourceserver.$linkuse ;

                                        break;
                                    }
                                    $desc = $rlink['description'];
                                }
                            }
                        }
						elseif(isset($item['teachingTeam']['instructions']['resourceType']) && $item['teachingTeam']['instructions']['resourceType'] == 'p') //link to a shared resource summary page
						{
							$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
							if(isset($item['teachingTeam']['instructions']['pbl']) && $item['teachingTeam']['instructions']['pbl'] == 'True') 
							{
								$linkuse =  $item['teachingTeam']['instructions']['itemUuid'] . '/' . $item['teachingTeam']['instructions']['itemVersion'];
								$resourceserver = '/flex/ocf/caseview/';
								$href = $resourceserver.$linkuse ;
								$desc = 'Case Page: '. $item['teachingTeam']['instructions']['description'];
							}
							else
							{
								$theUuid = $item['teachingTeam']['instructions']['itemUuid'];
								$theVersion = $item['teachingTeam']['instructions']['itemVersion'];
								$resourceserver = '/flex/ocf/generatetoken/viewSummaryPage';
								$linkuse = '/items/' . $theUuid . '/' . $theVersion . '/';
								$href = $resourceserver.$linkuse ;
								$desc = $item['teachingTeam']['instructions']['description'];
							}
						}
                    break;
                        
                    default:
                            $resourceclass = '';
                            break;
                }?>
                <li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
    <?php }  ?>  
    </ul>
 
 
 <?php } ?> <!-- ./teaching team instructions -->
 
 
 <!-- teaching team linked resources -->
<?php if (!(empty($item['teachingTeam']['linked']))) { ?>
 <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
     <ul class="fa-ul">
     	<?php foreach($item['teachingTeam']['linked'] as $rlink)
		{
			$resourceclass = '';
			$href = '';
			$desc = '';
			$resourceserver = '';
			
			switch($rlink['type'])
			{
				case 'linked-resource':  //linked to item summary page
					if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'p')
					{
						$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
						if(isset($rlink['pbl']) && $rlink['pbl'] == 'True') 
						{
							$linkuse =  $rlink['itemUuid'] . '/' . $rlink['itemVersion'];
							$resourceserver = '/flex/ocf/caseview/';
							$href = $resourceserver.$linkuse ;
							$desc = 'Case Page: '. $rlink['description'];
						}
						else
						{
							$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
							$resourceserver = '/flex/ocf/generatetoken/viewitem/items';
							$href = $resourceserver.$linkuse;
						}
					}
					
				break;
				
				case 'htmlpage':
				    // link to a shared resource attachment and the attachment type is webpage
					$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
					$linktype = 'file';
					$resourceserver = '/flex/ocf/loadpage/file';
					$theUuid = '';
					$theVersion = '';
					if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a')
					{
						$theUuid = $rlink['itemUuid'];
						$theVersion = $rlink['itemVersion'];
					}
					else //a webpage attachment attched
					{
						$theUuid = $item['thisUuid'];
						$theVersion = $item['thisVersion'];
					}
					$linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($rlink['filename']));
					$href = $resourceserver.$linkuse;
				
				break;
				
				case 'file':
					$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
					$linkuse = '';
					if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
					{
						//$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['uuid']; 
						$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
					} 
					else 
					{
						$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
					}
					
					
					$resourceserver = '/flex/ocf/generatetoken/viewitem/items';
					$href = $resourceserver.$linkuse ;

				break;
				
				case 'url';
					$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
					$href = $rlink['url'];	
				break;
			}
			$desc = isset($rlink['description'])?$rlink['description']:'To be added';
			if(isset($rlink['pbl']) && $rlink['pbl'] == 'True') 
			{
				$desc = 'Case page: '.$desc;
			
			}
			?>
			<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
		<?php }?>

     </ul> 
	 <?php } ?>  <!-- ./teaching team linked resources -->
 
 
 
 </div>
 
 
 </div>
 </div>
 </div>
 <?php } ?>
 
 
 
 

</div> <!-- / panel panel-primary-->

</div>
<?php } ?>

<!-- / resources panel -->

 <?php if (!(empty($item['crossTopic'])) || !(empty($item['disciplines'])) || !(empty($item['common_presentations'])) || !(empty($item['skills'])) || !(empty($item['otherTags']) || isset($item['teachingType'])) ) { ?> 

<div class="col-md-12">
<div class="well well-sm small">
<h4>Tags</h4>
<?php 
if(isset($item['teachingType']) && $thetype != '')
{ ?>
<p><span style="margin-right: 2em;"><strong>Teaching Type: </strong></span></span><?php echo $typesofteaching[$thetype] ; ?></p>

<?php }
 if (!(empty($item['crossTopic']))) { ?>
<p><span style="margin-right: 2em;"><strong>Cross Topic: </strong></span></span>
  <?php 
$numCrosstopic = count($item['crossTopic']);
$i = 0;
?>
  <?php foreach ($item['crossTopic'] as $crossTopic) {
	
	$i++;  ?>
  <?php echo $crossTopic['type']; ?>
  <?php if($i < $numCrosstopic)  { echo "&nbsp;::&nbsp;"; }
?>
  <?php }  // end foreach crossTopic tags ?>
</p>
<?php }  //  crossTopic tags not empty   ?>
<?php if (!(empty($item['disciplines']))) { ?>
<p><span style="margin-right: 2em;"><strong>Disciplines: </strong></span>
  <?php 
$numDisciplines = count($item['disciplines']);
$i = 0;
?>
  <?php foreach ($item['disciplines'] as $d) { $i++;  ?>
  <?php echo $d['discipline']; ?>
  <?php if($i < $numDisciplines)  { echo "&nbsp;::&nbsp;"; }
?>
  <?php }  // end foreach disciplines tags ?>
</p>
<?php }  //  disciplines tags not empty   ?>
<?php if (!(empty($item['common_presentations']))) { ?>
<p><span style="margin-right: 2em;"><strong>Common Presentations: </strong></span>
  <?php 
$numCPresentations = count($item['common_presentations']);
$i = 0;
?>
  <?php foreach ($item['common_presentations'] as $cp) { $i++;  ?>
  <?php echo $cp['presentation']; ?>
  <?php if($i < $numCPresentations)  { echo "&nbsp;::&nbsp;"; }
?>
  <?php }  // end foreach disciplines tags ?>
</p>
<?php }  //  disciplines tags not empty   ?>
<?php if (!(empty($item['common_conditions']))) { ?>
<p><span style="margin-right: 2em;"><strong>Common Conditions: </strong></span>
  <?php 
$numCConditions = count($item['common_conditions']);
$i = 0;
?>
  <?php foreach ($item['common_conditions'] as $cc) { $i++;  ?>
  <?php echo $cc['condition']; ?>
  <?php if($i < $numCConditions)  { echo "&nbsp;::&nbsp;"; }
?>
  <?php }  // end foreach disciplines tags ?>
</p>
<?php }  //  disciplines tags not empty   ?>
<?php if (!(empty($item['skills']))) { ?>
<p><span style="margin-right: 2em;"><strong>Skills and Procedures: </strong></span>
  <?php 
$numProcedures = count($item['skills']);
$i = 0;
?>
  <?php foreach ($item['skills'] as $s) { $i++;  ?>
  <?php echo $s['skill']; ?>
  <?php if($i < $numProcedures) 
 { echo "&nbsp;::&nbsp;"; }
?>
  <?php }  // end foreach disciplines tags ?>
</p>
<?php }  //  disciplines tags not empty   ?>
<?php if (!(empty($item['otherTags']))) { ?>
<p><span style="margin-right: 2em;"><strong>Other: </strong></span>
  <?php 
  	$numOther = 0;
  	if(isset($item['otherTags']))
	{
		$numOther = count($item['otherTags']);
	}
	$i = 0;
	
   foreach ($item['otherTags'] as $other) 
   { 
   		$i++;  
 	 	echo $other['tag']; 
		if($i < $numOther) 
		{ 
			echo "&nbsp;::&nbsp;"; 
		}
	}  // end foreach other tags ?>
</p>
<?php }  //  other tags not empty   ?>
</div>   <!-- / col-md-12 --> 
<?php } ?>
</div>
</div>

	
<?php } // end authorised


else { ?>

<div class="row">
  <h4 class="text-danger">Access denied </h4>
  <p>Your access does not grant you permission to view this item.</p>

</div>




<?php } // not authorised ?>

    <!-- / row --> 

  
</div>
  <!-- / modal-body --> 


<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div><!-- / modal-footer -->
  
