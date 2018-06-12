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



?>

<script type="text/javascript">

$(document).ready(function(){

	
	
	// $('[data-toggle="myTooltip"]').tooltip();


});  

</script>


<script type="text/javascript">
//$(document).ready(function() {
 //   $('#changeName').click(editItemName());
//});

//$(document).ready(function() {

  

	  
	  
  //$('#changeName').click(function(e) {
	   
function editItemName(url) {	  
	   //alert("clicked");
	   //e.preventDefault(); // do not follow link
	   
	  // e.stopImmediatePropagation();
	  //var url = $(this).attr('href');
	  ////var url = $('#changeName').attr('href');
	  //  alert(url);
	
	
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
  //);
 
  
 //$(document).ready(function() { 
 function editItemDesc(url) {	
     
     //$('#editDescription').click(function(e) {
	//   e.preventDefault(); // do not follow link
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


<script type="text/javascript">
    
    function add_activity() {	  
        
        $('#add_activity_div').css('visibility', 'visible');
	return false;
	
    }
  
    function delete_activity_fn(uuid, version) {	  

        //if(confirm('Are you sure you want to delete this activity?')==false) 
	//    return false;
	
	var parent_uuid = $("#parent_uuid1").val();
	var parent_version = $("#parent_version1").val();
	var parent_tcode = $("#parent_tcode1").val();
	var activity_level = $("#activity_level1").val();
	
	var url0 = "<?php echo base_url();?>ocf/lta_add/delete_item_save/" + parent_uuid + "/" + parent_version + "/" + uuid + "/" + version;
					  
        $.ajaxSetup ({
	    // Disable caching of AJAX responses
	    cache: false
	});
        $.ajax({
		  type: "GET",
		  url: url0,
		  success: function(data){
		                
				alert(data);
				//console.log(data);
				//return false;
				var url1 = "<?php echo base_url();?>ocf/lta/" + parent_uuid + "/" + parent_version + "/" + parent_tcode +  "/" + activity_level;
				
				$('#myModal').removeData('bs.modal');
				$("#modal-content-id").load(url1, function() { 
				$("#myModal").modal("show"); });
				
		  },
		  error: function(xhr,status,thrownError) {
			 alert('Error: ' + xhr.status);
			 var url2 = "<?php echo base_url();?>ocf/lta/" + parent_uuid + "/" + parent_version + "/" + parent_tcode +  "/" + activity_level;
			 $('#myModal').removeData('bs.modal');
			 $("#modal-content-id").load(url2, function() { 
			 $("#myModal").modal("show"); });
		  }
	});
    
       return false;
    }
    
  
    function new_act_save_fn() {
	    //event.preventDefault();
	    var updateURL = "<?php echo base_url() . 'ocf/lta_add/add_item_save'?>";

	      var itemName_act = $.trim($("#new_act_name").val());
	      var parent_uuid = $("#parent_uuid1").val();
	      var parent_version = $("#parent_version1").val();
	      var parent_tcode = $("#parent_tcode1").val();
	      var activity_level = $("#activity_level1").val();

	      if(itemName_act.length == 0)
		  return false;

	    //console.log('parent_uuid: ' + parent_uuid);
	    $('#add_new_act').html('<span class="text-muted">Adding new activity... </span><i class="fa fa-spinner fa-spin fa-fw text-muted"></i>');

	     $.ajaxSetup ({
		// Disable caching of AJAX responses
		cache: false
	    });
	    $.ajax({
	      type: "POST",
	      url: updateURL,
	      data: {"itemName": itemName_act,
		      "parent_tcode": parent_tcode,
		      "parent_uuid": parent_uuid,
		      "parent_version": parent_version,
		      "activity_level": activity_level },
	      success: function(data){
			    
			    alert(data);
			    var url1 = "<?php echo base_url();?>ocf/lta/" + parent_uuid + "/" + parent_version + "/" + parent_tcode +  "/" + activity_level;
			    //$("#myModal").modal("hide");
			    $('#myModal').removeData('bs.modal');
			    $("#modal-content-id").load(url1, function() { 
			    $("#myModal").modal("show"); });

	      },
	      error: function(xhr,status,thrownError) {
		     alert('Error: ' + xhr.status);
		     var url2 = "<?php echo base_url();?>ocf/lta/" + parent_uuid + "/" + parent_version + "/" + parent_tcode +  "/" + activity_level;
		     $('#myModal').removeData('bs.modal');
		     $("#modal-content-id").load(url2, function() { 
		     $("#myModal").modal("show"); });
	      }
	    });

    };

</script>


<style type="text/css">

.lBtn {
	
	text-align:left; 
	padding-left:6px;
}

</style>



    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <div id="itemName">
<h4 class="modal-title" id="myModalLabel"><!--<i class="fa fa-files-o fa-fw"></i>  --><?php echo $item['itemTitle']; ?></h4>
    </div>
     
      <p class="small"><em>Managed by:
      <?php if(!empty($upd_privilege['mgmgrps'])) {
          $mgmgrps_str = implode(', ', $upd_privilege['mgmgrps']); $mgmgrps_lnk = implode(' or ', $upd_privilege['mgmgrps']);
	  #$mgmgrps_lnk = $flexserv . '/access/searching.do?in=C' . $item['ocf_groups_collection'] . '&q=' . htmlentities($mgmgrps_lnk);
      ?>   
      <a target='_blank' href='<?php echo base_url() . "ocf/generatetoken/view_mgmgrps/" . htmlentities($mgmgrps_lnk)?>/'> <?php echo $mgmgrps_str; ?> </a>
      <?php } ?>
      </em></p>
      <?php if ($_SERVER['REMOTE_USER'] == 'couc0005') { ?>
      <p class="small">FLO LTI link for copy/paste: <a href="https://flextra.flinders.edu.au/flex/flo-ocf/flosom/index/3/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $item['itemTopic']; ?>" target="_blank">https://flextra.flinders.edu.au/flex/flo-ocf/flosom/index/3/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $item['itemTopic']; ?></a></p>
      <?php } ?>
</div>


<div class="modal-body">
<?php if (($_SESSION['ocf_ldapauth'])) { ?>
<div class="row" style="margin-bottom:0.5em;" id="itemdetail">
  <div class="col-md-10 col-sm-8 col-xs-12">
    <div id="itemDescription">
      <p><?php echo $item['itemDescription']; ?></p>
    </div>
    <?php if (!(empty($item['overall']))) { ?>
    <!--<h5 class="text-">Activity-wide instructions/resources</h5>-->
    <?php } ?>
    <?php if (!(empty($item['overall']['instructions']))) { ?>
    <div class="col-md-6 col-sm-12 col-xs-12">
      <ul class="fa-ul">
       <?php
	  
	switch ($item['overall']['instructions']['type']) {
	
	
	
	case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';
		$resourceserver = '/flex/ocf/loadpage/file';
		
		if($item['overall']['instructions']['resourceType'] == 'a') {
				$theUuid = $item['overall']['instructions']['itemUuid'];
				$theVersion = $item['overall']['instructions']['itemVersion'];
				} else {
				$theUuid = $item['thisUuid'];
				$theVersion = $item['thisVersion'];
			}
		
	
		
		$linkuse = '/' . $theUuid . '/' . $theVersion . '/' . urlencode(base64_encode($item['overall']['instructions']['filename']));
		
		
		$href = $resourceserver.$linkuse ;
		
		break;
		
	case 'file':

		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		
		//$linktype = 'file';
		
		if($item['overall']['instructions']['resourceType'] == 'a') {
		
		$linkuse = '/' . $item['overall']['instructions']['itemUuid'] . '/' . $item['overall']['instructions']['itemVersion'] . '/' .$item['overall']['instructions']['filename'] ; } else {
		
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$olinked['filename'] ; }
		
		$resourceserver = '/flex/ocf/generatetoken/viewfile/file';
		//$linkclass = 'class="generateToken"';
		$href = $resourceserver.$linkuse ;
		
		break;
	
	
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
        <li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $item['overall']['instructions']['description']; ?></a></li> 
      </ul>
    </div>
    <?php } ?>
    <?php if (!(empty($item['overall']['linked']))) { ?>
    <div class="col-md-6 col-sm-12 col-xs-12">
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
		
		$resourceserver = '/flex/ocf/generatetoken/viewfile/file';
		//$linkclass = 'class="generateToken"';
		$href = $resourceserver.$linkuse ;
		
		break;
		
	case 'linked-resource': 
	
	
		if($item['pblCase']) { 
		
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = '';	
		$linkuse =  $olinked['itemUuid'] . '/' . $olinked['itemVersion'];
		$resourceserver = '/flex/ocf/caseview';
		$linkclass = '';
		$href = $resourceserver.$linkuse ;
		
		} else {
			
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $olinked['itemUuid'] . '/' . $olinked['itemVersion'];
		$resourceserver = $flexserv;
		$linkclass = 'class="generateToken"';
		$href = $resourceserver.$linkuse ;
		
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
		
		
		$resourceserver = '/flex/ocf/loadpage/file';
		$linkclass = '';
		$href = $resourceserver.$linkuse ;
		
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
				<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" <?php echo $linkclass; ?>><?php if($item['pblCase'] != "False") { ?><?php } ?><?php echo $olinked['description']; ?></a></li>
        <?php } ?>
        <?php } ?>
      </ul>
    </div>
    <?php } ?>
  </div>
  <div class="col-md-2 col-sm-4 col-xs-12 noPrint">
    <!-- edit button -->
   <?php /*?> <?php if($activity_level > 1)
	{ ?><?php */?>
	<?php  if($upd_privilege['has_privilege'] == 'Yes'  )
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
	    <a href="#" onClick="javascript: editItemDesc('<?php echo $itemdesc_url;?>'); return false;" id="editDescription" class="btn btn-sm btn-warning btn-block lBtn"><i class="fa fa-edit"></i> Edit overview</a> 
	    <?php } else { ?>
	    <button class="btn btn-default btn-block btn-sm lBtn" disabled="disabled"><i class="fa fa-lock"></i>&nbsp;Overview</button> 
	    <?php } ?>

	<?php }?>

	<?php if( $upd_privilege['is_contributor'] == 'Yes' || $upd_privilege['is_eqadmin'] == 'Yes'){ ?>
	<a id="editItem" target="_blank" href="/flex/ocf/generatetoken/editactivity/items/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>" class="btn btn-sm btn-danger btn-block lBtn generateToken" data-toggle="myTooltip"  data-placement="left" title="Edit this item in FLEX (Right click and open new tab)"><i class="fa fa-edit"></i> Edit activity</a>
	<?php } ?>
    <?php /*?><?php } ?><?php */?>
  </div>
</div>
<div class="row">
    <div class="col-md-12">
      <h4> Learning & Teaching Activities</h4>
      <div class="table-responsive">
        <table class="table table-condensed table-bordered small">
          <tr>
            <th><?php if((empty($item['los']))) { ?>
              <span class="text-danger">Learning Objectives not defined for this group of activities</span>
              <?php } ?>
              &nbsp;</th>
            <?php $numLOS = 0; ?>
            <?php if(!(empty($item['los']))) { ?>
            <?php foreach($item['los'] as $lo) { ?>
            <th style="text-align:center;"><?php echo $lo['code']; ?></th>
            <?php $numLOS++; ?>
            <?php } ?>
            <?php } ?>
          </tr>
          <?php if (!(empty($item['activities']))) { ?>
          <?php foreach ($item['activities'] as $activity) { ?>
          <?php 
/*    */
switch ($activity['activityType']) {
	
	case 'group':
	
		$liclass = "fa fa-files-o";
		
		
		// $link = "/flex/ocf/lta/". $activity['itemUuid'] . "/" . $activity['itemVersion'] . "/" . $item['itemTopic'] . "/" . $activity['activityParent'] . "/" . $activity['activityParentVersion']. "/" . $item['depth'];	
		
		
			$link = "/flex/ocf/lta/". $activity['itemUuid'] . "/" . $activity['itemVersion'] . "/" . $item['itemTopic'];	
		 
		break;
	
	case 'activity':
	
		$liclass = "fa fa-file-o";
		//$link = "/flex/som/activity/". $activity['itemUuid'] . "/" . $activity['itemVersion'] . "/" . $item['itemTopic'] . "/" . $activity['activityParent'] . "/" . $activity['activityParentVersion'] . "/" . $item['depth'] . "/" . $item['parentItem'];	
		break;
	
	
}


switch ($activity['docondition']) {
	
	case 'alternative':
		$docondition = '<i class="fa fa-share-alt fa-fw text-primary" style="margin-right:0.8em;"></i>';
		break;
	case 'optional':
		$docondition = '<i class="fa fa-circle-o fa-fw text-primary"  style="margin-right:0.8em;"></i>';
		break;
	default:
		$docondition = '';
		break;
	
}

?>
          <tr>
            <td><!--<i class="<?php echo $liclass; ?>" style="margin-right:0.8em;"></i>-->
              <?php echo $docondition; ?><?php echo $activity['itemName']; ?>
	      <?php if(isset($upd_privilege) && $upd_privilege['has_privilege'] == 'Yes' && $upd_privilege['locks']['activities'] != 'Yes'){ ?>
                  <?php $tmp1 = str_replace("'", "\'", $activity['itemName']); $tmp1 = str_replace('"', '\"', $tmp1); $tmp1 = htmlentities($tmp1, ENT_QUOTES);?>
		  &nbsp;<div style="float:right;"><a onClick="javascript: if(confirm('Are you sure you want to remove: <?php echo $tmp1;?> ?')==true) {delete_activity_fn('<?php echo $activity['itemUuid'];?>', '<?php echo $activity['itemVersion'];?>');}" href="#" title="Remove" ><span class="glyphicon glyphicon-remove-sign"></span></a></div><div style="clear:right;"></div>
	      <?php }?>
	    </td>
            <?php if(!(empty($activity['los']))) { ?>
            <?php foreach($activity['los'] as $lo ) { ?>
            <td style="text-align:center;"><?php if ($lo['aligned'] == 1) { ?>
              <i class="fa fa-check text-success"></i>
              <?php }  ?></td>
            <?php } ?>
            <?php } ?>
          </tr>
          <?php } ?>
          <?php }  // $item['activities'] not empty ?>
        </table>
      </div>
    </div>
    
    <?php if(isset($upd_privilege) && $upd_privilege['has_privilege'] == 'Yes' && $upd_privilege['locks']['activities'] != 'Yes'){ ?>
		
    <div class="col-md-2 ">
	<a href="#" onClick="javascript: add_activity(); return false;" id="addActivity" class="btn btn-sm btn-warning btn-block lBtn"><i class="fa fa-edit"></i>Add NEW activity</a> 
    
           <input type="hidden" class="form-control" id="parent_uuid1" value="<?php echo $item['thisUuid']; ?>" />
	   <input type="hidden" class="form-control" id="parent_version1" value="<?php echo $item['thisVersion']; ?>" />
	   <input type="hidden" class="form-control" id="parent_tcode1" value="<?php echo $item['itemTopic']; ?>" />       
	   <input type="hidden" class="form-control" id="activity_level1" value="<?php echo $activity_level; ?>" /> 
	   <br>
    </div>	   
    <div id="add_activity_div" style="visibility:hidden;" class=" col-md-10 ">
	
	<div class="modal-title" id="add_new_act">
	  
	   <div class="input-group">
	   <span class="input-group-addon"><strong>Activity name:<i class="fa fa-hand-o-right "></i></strong>
	   </span>
	  <input name="new_act_name" type="text" class="form-control" id="new_act_name" value="" />
	  <span class="input-group-btn">
	  <button type="button" onClick="new_act_save_fn();" class="btn btn-success" id="new_act_save_btn"><i class="fa fa-check-square-o"></i>&nbsp;Save</button>
	  </span>
      </div>
	    
    </div>
    </div>
    <?php }?>
    <?php if($upd_privilege['has_privilege'] == 'Yes' && $upd_privilege['locks']['activities'] == 'Yes') { ?>
    <div class="col-md-2 ">
    <button class="btn btn-default btn-block btn-sm lBtn" disabled="disabled"><i class="fa fa-lock"></i>&nbsp;Activity</button> 
    </div>
    <?php } ?>
    
    <?php if (!(empty($item['los']))) { ?>
    <div class="col-md-12">
      <h4> Learning Objectives</h4>
      <dl class="dl-horizontal">
        <?php 
/*   */


foreach ($item['los'] as $lo) { ?>
        <dt><?php echo $lo['code']; ?></dt>
        <dd><?php echo $lo['name']; ?></dd>
        <?php }   ?>
      </dl>
    </div>
    <?php } // end not empty LOs ?>
  
  
    <!-- panel for resources -->
    
    
     <?php if ( !(empty($item['pre'])) || !(empty($item['during'])) || !(empty($item['post'])) || !(empty($item['teachingTeam']))  ) {
		 
	 ?> 

<div class="col-md-12" style="margin-top:5px;">
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
	  
	switch ($item['pre']['instructions']['type']) {
	
	case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		
		if($item['pre']['instructions']['resourceType'] == 'a') {
			$theUuid = $item['pre']['instructions']['itemUuid'];
		} else {
			$theUuid = $item['thisUuid'];
		}
			
		$resourceserver = '/flex/ocf/loadpage';
		break;
		
		
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
      <li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $theUuid; ?>/<?php echo $item['thisVersion']; ?>/<?php echo urlencode(base64_encode($item['pre']['instructions']['filename'])); ?>" target="_blank"><?php echo $item['pre']['instructions']['description']; ?></a></li>    

      
  </ul>
    <?php } ?>
    
    
    
     <?php if (!(empty($item['pre']['linked']))) { ?>
     <ul class="fa-ul">
       <?php foreach ($item['pre']['linked'] as $prelinked) { ?>
       <?php
	  
	switch ($prelinked['type']) {
	
case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		//$linktype = 'file';
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .htmlentities($prelinked['filename']);
		$resourceserver = '/flex/ocf/generatetoken/viewfile/file';
		//$linkclass = 'class="generateToken"';
		$href = $resourceserver.$linkuse ;
		
		break;
		
	case 'linked-resource': 
	
	
	
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $prelinked['itemUuid'] . '/' . $prelinked['itemVersion'];
		$resourceserver = $flexserv;
		$linkclass = 'class="generateToken"';
		$href = $resourceserver.$linkuse ;
		
		break;
		
		
		
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		
		if($prelinked['resourceType'] == 'a') {
			$linkuse = '/' . $prelinked['itemUuid'] . '/' . $prelinked['itemVersion'] . '/' . urlencode(base64_encode($prelinked['filename']));
		} else {
			$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . urlencode(base64_encode($prelinked['filename']));
		}
		
		$resourceserver = '/flex/ocf/loadpage/';
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
       <?php if ($prelinked['type'] == 'url') { ?>
       
       <li><?php echo $resourceclass; ?><a href="<?php echo $prelinked['url']; ?>" target="_blank"><?php echo $prelinked['description']; ?></a></li>
    
    <?php } else { ?>

    <li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" <?php echo $linkclass; ?>><?php echo $prelinked['description']; ?></a></li>
      <?php } ?> 
      
    <?php } ?>
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
	  
	switch ($item['during']['instructions']['type']) {
	
	case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$resourceserver = '/flex/ocf/loadpage';
		
		if($item['during']['instructions']['resourceType'] == 'a') {
			$theUuid = $item['during']['instructions']['itemUuid'];
		} else {
			$theUuid = $item['thisUuid'];
		}
		
		break;
		
		
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
<li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $theUuid; ?>/<?php echo $item['thisVersion']; ?>/<?php echo urlencode(base64_encode($item['during']['instructions']['filename'])); ?>" target="_blank"><?php echo $item['during']['instructions']['description']; ?></a></li>    

   </ul>
     <?php } ?>
     
      <?php if (!(empty($item['during']['linked']))) { ?>
      <ul class="fa-ul">
        <?php foreach ($item['during']['linked'] as $dlinked) { ?>
        <?php
	  
	switch ($dlinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$dlinked['filename'] ;
		$resourceserver = '/flex/ocf/generatetoken/viewfile/file';
		//$linkclass = 'class="generateToken"';
		$href = $resourceserver.$linkuse ;
		
		$linkclass = 'class="generateToken"';
		break;
		
		
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $dlinked['itemUuid'] . '/' . $dlinked['itemVersion'];
		$resourceserver = $flexserv;
		$linkclass = 'class="generateToken"';
		break;
		
		
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
	
		if($dlinked['resourceType'] == 'a') {
			$linkuse = '/' . $dlinked['itemUuid'] . '/' . $dlinked['itemVersion'] . '/' . urlencode(base64_encode($dlinked['filename']));
		} else {
			$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . urlencode(base64_encode($dlinked['filename']));
		}

		$resourceserver = '/flex/ocf/loadpage/';
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
        <?php if ($dlinked['type'] == 'url') { ?>
        
        <li><?php echo $resourceclass; ?><a href="<?php echo $dlinked['url']; ?>" target="_blank"><?php echo $dlinked['description']; ?></a></li>
    
    <?php } else { ?>

    <li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" <?php echo $linkclass; ?>><?php echo $dlinked['description']; ?></a></li>
      <?php } ?>
      
       <?php } ?>
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
	  
	switch ($item['post']['instructions']['type']) {
	
	case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$resourceserver = '/flex/ocf/loadpage';
		
		if($item['post']['instructions']['resourceType'] == 'a') {
			$theUuid = $item['post']['instructions']['itemUuid'];
		} else {
			$theUuid = $item['thisUuid'];
		}
		
		break;
		
		
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
      <li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $theUuid; ?>/<?php echo $item['thisVersion']; ?>/<?php echo urlencode(base64_encode($item['post']['instructions']['filename'])); ?>" target="_blank"><?php echo $item['post']['instructions']['description']; ?></a></li>
   </ul>
     <?php } ?>
     
      <?php if (!(empty($item['post']['linked']))) { ?>
      <ul class="fa-ul">
        <?php foreach ($item['post']['linked'] as $plinked) { ?>
        <?php
	  
	switch ($plinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$plinked['filename'] ;
		$resourceserver = '/flex/ocf/generatetoken/viewfile/file';
		//$linkclass = 'class="generateToken"';
		$href = $resourceserver.$linkuse ;
		break;
		
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $plinked['itemUuid'] . '/' . $plinked['itemVersion'];
		$resourceserver = $flexserv;
		$linkclass = 'class="generateToken"';
		break;
	
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		
		if($plinked['resourceType'] == 'a') {
			$linkuse = '/' . $plinked['itemUuid'] . '/' . $plinked['itemVersion'] . '/' . urlencode(base64_encode($plinked['filename']));
		} else {
			$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . urlencode(base64_encode($plinked['filename']));
		}
		
		$resourceserver = '/flex/ocf/loadpage/';
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
        
        <?php if ($plinked['type'] == 'url') { ?>
        
        <li><?php echo $resourceclass; ?><a href="<?php echo $plinked['url']; ?>" target="_blank"><?php echo $plinked['description']; ?></a></li>
    
    <?php } else { ?>

    <li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" <?php echo $linkclass; ?>><?php echo $plinked['description']; ?></a></li>
      <?php } ?>
    
           <?php } ?>
   </ul>
     <?php } ?>
   </div>
  </div>
  </div>
</div> <!-- / post activity  -->

 <?php } ?>
 
 <?php if (!(empty($item['teachingTeam']))) { ?>
 <div class="row">
   <!-- teachingTeam activity -->
   <div class="col-md-12">
     <div class="panel panel-danger" style="margin-bottom:0;">
       <div class="panel-heading ">
         <h5 class="panel-title">Teaching Team Only</h5>
       </div>
       <div class="panel-body" >
         <?php if (!(empty($item['teachingTeam']['instructions']))) { ?>
         <ul class="fa-ul">
           <?php
	  
	switch ($item['teachingTeam']['instructions']['type']) {
	
	case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$resourceserver = '/flex/ocf/loadpage';
		
		if($item['teachingTeam']['instructions']['resourceType'] == 'a') {
			$theUuid = $item['teachingTeam']['instructions']['itemUuid'];
		} else {
			$theUuid = $item['thisUuid'];
		}
		
		break;
		
		
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
           <li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $theUuid; ?>/<?php echo $item['thisVersion']; ?>/<?php echo urlencode(base64_encode($item['teachingTeam']['instructions']['filename'])); ?>" target="_blank"><?php echo $item['teachingTeam']['instructions']['description']; ?></a></li>
         </ul>
         <?php } ?>
         <?php if (!(empty($item['teachingTeam']['linked']))) { ?>
         <ul class="fa-ul">
           <?php foreach ($item['teachingTeam']['linked'] as $plinked) { ?>
           <?php
	  
	switch ($plinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$plinked['filename'] ;
		$resourceserver = '/flex/ocf/generatetoken/viewfile/file';
		//$linkclass = 'class="generateToken"';
		$href = $resourceserver.$linkuse ;
		break;
		
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $plinked['itemUuid'] . '/' . $plinked['itemVersion'];
		$resourceserver = $flexserv;
		$linkclass = 'class="generateToken"';
		break;
	
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		
		if($plinked['resourceType'] == 'a') {
			$linkuse = '/' . $plinked['itemUuid'] . '/' . $plinked['itemVersion'] . '/' . urlencode(base64_encode($plinked['filename']));
		} else {
			$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . urlencode(base64_encode($plinked['filename']));
		}
		
		$resourceserver = '/flex/ocf/loadpage/';
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
           <?php if ($plinked['type'] == 'url') { ?>
           <li><?php echo $resourceclass; ?><a href="<?php echo $plinked['url']; ?>" target="_blank"><?php echo $plinked['description']; ?></a></li>
           <?php } else { ?>
           <li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" <?php echo $linkclass; ?>><?php echo $plinked['description']; ?></a></li>
           <?php } ?>
           <?php } ?>
         </ul>
         <?php } ?>
       </div>
     </div>
   </div>
 </div>
 <?php } ?>
 
 
 
 

</div> 
<!-- / panel panel-primary-->

</div>

<?php 
		 
		 } ?>
    <!-- / resources panel -->
    <?php if (!(empty($item['crossTopic'])) || !(empty($item['disciplines'])) || !(empty($item['common_presentations'])) || !(empty($item['skills'])) || !(empty($item['otherTags'])) ) { ?>
    <div class="col-md-12">
      <div class="well well-sm small">
        <h4> Tags</h4>
        <?php if (!(empty($item['crossTopic']))) { ?>
        <p><span style="margin-right: 2em;"><strong>Cross Topic</strong></span></span>
          <?php foreach ($item['crossTopic'] as $crossTopic) { ?>
          <?php echo $crossTopic['type']; ?>&nbsp;::&nbsp;
          <?php }  // end foreach crossTopic tags ?>
        </p>
        <?php }  //  crossTopic tags not empty   ?>
        <?php if (!(empty($item['disciplines']))) { ?>
        <p><span style="margin-right: 2em;"><strong>Disciplines</strong></span>
          <?php foreach ($item['disciplines'] as $d) { ?>
          <?php echo $d['discipline']; ?>&nbsp;::&nbsp;
          <?php }  // end foreach disciplines tags ?>
        </p>
        <?php }  //  disciplines tags not empty   ?>
        <?php if (!(empty($item['common_presentations']))) { ?>
        <p><span style="margin-right: 2em;"><strong>Common Presentations</strong></span>
          <?php foreach ($item['common_presentations'] as $cp) { ?>
          <?php echo $cp['presentation']; ?>&nbsp;::&nbsp;
          <?php }  // end foreach disciplines tags ?>
        </p>
        <?php }  //  disciplines tags not empty   ?>
        <?php if (!(empty($item['common_conditions']))) { ?>
        <p><span style="margin-right: 2em;"><strong>Common Conditions</strong></span>
          <?php foreach ($item['common_conditions'] as $cc) { ?>
          <?php echo $cc['condition']; ?>&nbsp;::&nbsp;
          <?php }  // end foreach disciplines tags ?>
        </p>
        <?php }  //  disciplines tags not empty   ?>
        <?php if (!(empty($item['skills']))) { ?>
        <p><span style="margin-right: 2em;"><strong>Skills and Procedures</strong></span>
          <?php foreach ($item['skills'] as $s) { ?>
          <?php echo $s['skill']; ?>&nbsp;::&nbsp;
          <?php }  // end foreach disciplines tags ?>
        </p>
        <?php }  //  disciplines tags not empty   ?>
        <?php if (!(empty($item['otherTags']))) { ?>
        <p><span style="margin-right: 2em;"><strong>Other</strong></span>
          <?php foreach ($item['otherTags'] as $other) { ?>
          <?php echo $other['tag']; ?>&nbsp;::&nbsp;
          <?php }  // end foreach other tags ?>
        </p>
        <?php }  //  other tags not empty   ?>
      </div>
      <!-- / col-md-12 -->
      <?php } ?>
    </div>
    
    <?php } // end authorised


else { ?>

<div class="row">
  <h4 class="text-danger">Access denied </h4>
  <p>Your access does not grant you permission to view this item.</p>

</div>




<?php } // not authorised ?>

    
  </div>
  
  
  
  
  
  
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>
