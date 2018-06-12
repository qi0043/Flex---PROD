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

/*echo '<pre>';
//print_r($item);
print_r($_SESSION);
echo '</pre>';*/
?>

<script type="text/javascript">
/*$(document).ready(function() {
  $('a.generateToken').click(function(e) {
  	return;
	e.preventDefault(); // do not follow link
 	var url = $(this).attr('href');
	var tokenGenerator = '/flex/flo-ocf/generatetoken/';
	$.ajax({
		url: '/flex/flo-ocf/generatetoken/',
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
    return false;
  });
});*/
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
    	<h4 class="modal-title" id="myModalLabel"><?php echo $item['itemTitle']; ?></h4>
    	</div>
	</div>


    <div class="modal-body">
       
        <div class="row" style="margin-bottom:0.5em;" id="itemdetail">
          <div class="col-md-10 col-sm-8 col-xs-12">
            <div id="itemDescription">
                <p><?php echo $item['itemDescription']; ?></p>
            </div>
            <?php if (!(empty($item['overall']))) { ?>
				<?php if (!(empty($item['overall']['instructions']))) { ?>
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
                                    $resourceserver = '/flex/flo-ocf/loadpageflo/file';
                                    
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
                                                        $resourceserver = '/flex/flo-ocf/loadpageflo/file';
                                                        
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
                                                        
                                                        
                                                        $resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
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
                    <?php } ?> 
                    </ul>
                </div>
                <?php }
			}?>
            
            <?php if (!(empty($item['overall']['linked']))) { ?>
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
                                                $resourceserver = '/flex/flo-ocf/caseview/';
                                                $href = $resourceserver.$linkuse ;
                                                $desc = 'Case Page: '. $rlink['description'];
                                            }
                                            else
                                            {
                                                $linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
                                                $resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
                                                $href = $resourceserver.$linkuse;
                                            }
                                        }
                                        
                                    break;
                                    
                                    case 'htmlpage':
                                        // link to a shared resource attachment and the attachment type is webpage
                                        $resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
                                        $linktype = 'file';
                                        $resourceserver = '/flex/flo-ocf/loadpageflo/file';
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
                                        
                                        
                                        $resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
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
                                        $href = '';
                                        $desc = 'Case page: '.$desc . ' (Link will be activated after completion of case)';
                                    }
                                
                                }
                                ?>
                                <li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
                            <?php }?>
                    </ul>
                </div>
            <?php } ?>
         </div>
        
        <?php /*?><div class="col-md-2 col-sm-4 col-xs-12 noPrint">
 			<?php if( $upd_privilege['is_contributor'] == 'Yes' || $upd_privilege['is_eqadmin'] == 'Yes'){ ?>
            <a id="editItem" target="_blank" href="/flex/flo-ocf/generatetoken/editactivity/items/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>" class="btn btn-sm btn-danger btn-block lBtn generateToken" data-toggle="myTooltip"  data-placement="left" title="Edit this item in FLEX (Right click and open new tab)"><i class="fa fa-edit"></i> Edit activity</a>
            <?php } ?>
        </div><?php */?>
    </div>
     
    <div class="row">
    	<?php if (!empty($item['activities'])) 
		{ 
			$numLOS = 0; 
			$flag = false;
			foreach ($item['activities'] as $activity) 
			{
				if(!(empty($activity['los']))) 
				{
					foreach($activity['los'] as $lo ) 
					{ 
						if ($lo['aligned'] == 1) 
						{
							$flag = true;
							break;
						}
					}
				}
			} //end of $item['activities'] foreach 
		?>
    		<div class="col-md-12">
          		<h4> Learning & Teaching Activities</h4>
          		<div class="table-responsive">
            	<table class="table table-condensed table-bordered small">     
					<?php if($flag){?>
                    <tr>
                        <th></th>
                        <?php foreach($item['los'] as $lo) 
                        { ?>
                            <th style="text-align:center;"><?php echo $lo['code']; ?></th>
                            <?php $numLOS++; 
                        } ?>
                    </tr>
                    <?php }?>
                
					<?php 
                    $docondition = '';
                    //$liclass = '';
                    foreach ($item['activities'] as $activity) 
                    { 
                    
                        /*switch ($activity['activityType']) {
                            case 'group':
                                $liclass = "<i class='fa fa-files-o text-primary' style='margin-right:0.8em;'></i>";
                                
                                //$link = "/flex/flo-ocf/lta/". $activity['itemUuid'] . "/" . $activity['itemVersion'] . "/" . $item['itemTopic'];	
                                break;
                            
                            case 'activity':
                                $liclass = "<i class='fa fa-file-o text-primary' style='margin-right:0.8em;'></i>";
                                
                                break;
                        }*/
    
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
                    <td>
                      <?php echo $docondition; ?><?php echo $activity['itemName']; ?>
                    </td>
                    <?php if($flag) {
                       
                        foreach($activity['los'] as $lo ) { 
                        if ($lo['aligned'] == 1) {
                        ?>
                            <td style="text-align:center;">
                                <i class="fa fa-check text-success"></i>
                            </td>
                      <?php }
					    else
						{?>
							<td style="text-align:center;"></td>
						<?php }
					  }
					}?>
          		</tr>
          <?php } ?>
        </table>
          </div>
        </div> 
       <?php } // END $item['activities'] not empty ?>
    
    
    <?php if (!(empty($item['los']))) { ?>
    <div class="col-md-12">
      <h4> Learning Objectives</h4>
      <dl class="dl-horizontal">
        <?php 
		foreach ($item['los'] as $lo) { ?>
        	<dt><?php echo $lo['code']; ?></dt>
        	<dd><?php echo $lo['name']; ?></dd>
        <?php }   ?>
      </dl>
    </div>
    <?php } // end not empty LOs ?>
    
 
<!-- panel for resources -->
<?php if ( !(empty($item['pre'])) || !(empty($item['during'])) || !(empty($item['post']))||!empty($item['teachingTeam']) ) { ?>
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
                                    $resourceserver = '/flex/flo-ocf/loadpageflo/file';
                                    
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
                                                        $resourceserver = '/flex/flo-ocf/loadpageflo/file';
                                                        
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
                                                        
                                                        
                                                        $resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
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
                                                $resourceserver = '/flex/flo-ocf/caseview/';
                                                $href = $resourceserver.$linkuse ;
                
                                                $desc = 'Case Page: '. $item['pre']['instructions']['description'];
                                            }
                                            else
                                            {
                                                $theUuid = $item['pre']['instructions']['itemUuid'];
                                                $theVersion = $item['pre']['instructions']['itemVersion'];
                                                $resourceserver = '/flex/flo-ocf/generatetoken/viewSummaryPage';
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
                                        $resourceserver = '/flex/flo-ocf/caseview/';
                                        $href = $resourceserver.$linkuse ;
                                        $desc = 'Case Page: '. $rlink['description'];
                                    }
                                    else
                                    {
                                        $linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
                                        $resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
                                        $href = $resourceserver.$linkuse;
                                    }
                                }
                                
                            break;
                            
                            case 'htmlpage':
                                // link to a shared resource attachment and the attachment type is webpage
                                $resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
                                $linktype = 'file';
                                $resourceserver = '/flex/flo-ocf/loadpageflo/file';
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
                                
                                
                                $resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
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
                                    $resourceserver = '/flex/flo-ocf/loadpageflo/file';
                                    
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
                                                        $resourceserver = '/flex/flo-ocf/loadpageflo/file';
                                                        
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
                                                        
                                                        
                                                        $resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
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
                                            $resourceserver = '/flex/flo-ocf/caseview/';
                                            $href = $resourceserver.$linkuse ;
                                            $desc = 'Case Page: '. $item['during']['instructions']['description'];
                                        }
                                        else
                                        {
                                            $theUuid = $item['during']['instructions']['itemUuid'];
                                            $theVersion = $item['during']['instructions']['itemVersion'];
                                            $resourceserver = '/flex/flo-ocf/generatetoken/viewSummaryPage';
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
                                    $resourceserver = '/flex/flo-ocf/caseview/';
                                    $href = $resourceserver.$linkuse ;
                                    $desc = 'Case Page: '. $rlink['description'];
                                }
                                else
                                {
                                    $linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
                                    $resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
                                    $href = $resourceserver.$linkuse;
                                }
                            }
                            
                        break;
                        
                        case 'htmlpage':
                            // link to a shared resource attachment and the attachment type is webpage
                            $resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
                            $linktype = 'file';
                            $resourceserver = '/flex/flo-ocf/loadpageflo/file';
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
                            
                            
                            $resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
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
                                        $resourceserver = '/flex/flo-ocf/loadpageflo/file';
                                        
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
                                                            $resourceserver = '/flex/flo-ocf/loadpageflo/file';
                                                            
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
                                                            
                                                            
                                                            $resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
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
                                                $resourceserver = '/flex/flo-ocf/caseview/';
                                                $href = $resourceserver.$linkuse ;
                                                $desc = 'Case Page: '. $item['post']['instructions']['description'];
                                            }
                                            else
                                            {
                                                $theUuid = $item['post']['instructions']['itemUuid'];
                                                $theVersion = $item['post']['instructions']['itemVersion'];
                                                $resourceserver = '/flex/flo-ocf/generatetoken/viewSummaryPage';
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
                                            $resourceserver = '/flex/flo-ocf/caseview/';
                                            $href = $resourceserver.$linkuse ;
                                            $desc = 'Case Page: '. $rlink['description'];
                                        }
                                        else
                                        {
                                            $linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
                                            $resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
                                            $href = $resourceserver.$linkuse;
                                        }
                                    }
                                    
                                break;
                                
                                case 'htmlpage':
                                    // link to a shared resource attachment and the attachment type is webpage
                                    $resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
                                    $linktype = 'file';
                                    $resourceserver = '/flex/flo-ocf/loadpageflo/file';
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
                                    
                                    
                                    $resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
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
         
            <?php if (!(empty($item['teachingTeam']))) {
                $flag = false;
                if(isset($_SESSION['ocf_topic_codes']) && isset($_SESSION['flo_ocf_role']))
                {
                    if($_SESSION['flo_ocf_role'] == 'Instructor')
                    {
                        if(isset($_SESSION['ocf_topic_codes']['enrolled']) && count($_SESSION['ocf_topic_codes']['enrolled'])>0)
                        {
                            foreach($_SESSION['ocf_topic_codes']['enrolled'] as $topic_code)
                            {
                                if($item['itemTopic'] === $topic_code)
                                {
                                    $flag = true;
                                    break;
                                }
                            }
                        }
                        
                        if(isset($_SESSION['ocf_topic_codes']['other']) && count($_SESSION['ocf_topic_codes']['other'])>0)
                        {
                            foreach($_SESSION['ocf_topic_codes']['other'] as $topic_code)
                            {
                                if($item['itemTopic'] === $topic_code)
                                {
                                    $flag = true;
                                    break;
                                }
                            }
                        }
                    }
                    
                }
                if($flag) { ?>
                    <div class="row"> <!-- teaching team -->
                        <div class="col-md-12">
                            <div class="panel panel-danger" style="margin-bottom:0;">
                                <div class="panel-heading ">
                                    <h5 class="panel-title">Teaching Team Only</h5>
                                </div>
                            
                                <div class="panel-body" >
                                    <!-- teaching team instructions -->
                                    <?php if (!(empty($item['teachingTeam']['instructions']))) { ?>
                                        <?php if (empty($item['teachingTeam']['linked'])) { ?>    
                                            <div class="col-md-12">
                                            <?php } else { ?>
                                            <div class="col-md-6">
                                            <?php } ?>
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
                                                                    $resourceserver = '/flex/flo-ocf/loadpageflo/file';
                                                                    
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
                                                                                        $resourceserver = '/flex/flo-ocf/loadpageflo/file';
                                                                                        
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
                                                                                        
                                                                                        
                                                                                        $resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
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
                                                                            $resourceserver = '/flex/flo-ocf/caseview/';
                                                                            $href = $resourceserver.$linkuse ;
                                                                            $desc = 'Case Page: '. $item['teachingTeam']['instructions']['description'];
                                                                        }
                                                                        else
                                                                        {
                                                                            $theUuid = $item['teachingTeam']['instructions']['itemUuid'];
                                                                            $theVersion = $item['teachingTeam']['instructions']['itemVersion'];
                                                                            $resourceserver = '/flex/flo-ocf/generatetoken/viewSummaryPage';
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
                                            </div>
                                 
                                    <?php } ?> <!-- ./teaching team instructions -->
                         
                         
                                    <!-- teaching team linked resources -->
                                    <?php if (!(empty($item['teachingTeam']['linked']))) { ?>
                                        <?php if (empty($item['teachingTeam']['instructions'])) { ?>    
                                            <div class="col-md-12">
                                            <?php } else { ?>
                                            <div class="col-md-6">
                                            <?php } ?>  
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
                                                                    $resourceserver = '/flex/flo-ocf/caseview/';
                                                                    $href = $resourceserver.$linkuse ;
                                                                    $desc = 'Case Page: '. $rlink['description'];
                                                                }
                                                                else
                                                                {
                                                                    $linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
                                                                    $resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
                                                                    $href = $resourceserver.$linkuse;
                                                                }
                                                            }
                                                            
                                                        break;
                                                        
                                                        case 'htmlpage':
                                                            // link to a shared resource attachment and the attachment type is webpage
                                                            $resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
                                                            $linktype = 'file';
                                                            $resourceserver = '/flex/flo-ocf/loadpageflo/file';
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
                                                            
                                                            
                                                            $resourceserver = '/flex/flo-ocf/generatetoken/viewitem/items';
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
                                            </div> 
                                    <?php } ?>  <!-- ./teaching team linked resources -->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } 
            }?>
        </div> <!-- / panel panel-default-->
    </div> <!-- / col-md-12-->
<?php } ?>
    <!-- / resources panel -->
    <?php if (!(empty($item['crossTopic'])) || !(empty($item['disciplines'])) || !(empty($item['common_presentations'])) || !(empty($item['skills'])) || !(empty($item['otherTags'])) ) { ?>
    <div class="col-md-12">
      <div class="well well-sm small">
        <h4> Tags</h4>
        <?php if (!empty($item['crossTopic'])) 
			  { ?>
            	<p><span style="margin-right: 2em;"><strong>Cross Topic:</strong></span>
					<?php
                      $index = 0;
                      foreach ($item['crossTopic'] as $crossTopic) 
                      { 
                         $index++;
                         if($index != 1)
                         {
                            echo ' :: '.$crossTopic['type'];
                         }
                         else
                         {
                            echo $crossTopic['type'];
                         }?> 
                <?php } ?>
                </p>
        <?php }  //  crossTopic tags not empty   ?>
       
       
        <?php if (!(empty($item['disciplines']))) { ?>
            <p><span style="margin-right: 2em;"><strong>Disciplines:</strong></span>
              <?php 
                $index=0;
                foreach ($item['disciplines'] as $d) 
                { 
                    $index++;
                    if($index != 1)
                    {
                         echo ' :: '.$d['discipline'];
                    }
                    else
                    {
                        echo $d['discipline'];
                    }
                } // end foreach disciplines tags 
                    ?>
            </p>
        <?php }  //  disciplines tags not empty   ?>
        
        <?php if (!(empty($item['common_presentations']))) { ?>
            <p><span style="margin-right: 2em;"><strong>Common Presentations:</strong></span>
              <?php  $index=0;
			  		foreach ($item['common_presentations'] as $cp) 
					{ 
						$index++;
						if($index != 1)
						{
							 echo ' :: '.$cp['presentation'];
						}
						else
						{
							echo $cp['presentation'];
						}
					}  // end foreach common_presentations tags
					
			 ?>
            </p>
        <?php }  //  common_presentations not empty   ?>
        
        <?php if (!(empty($item['common_conditions']))) { ?>
        <p><span style="margin-right: 2em;"><strong>Common Conditions:</strong></span>
          <?php 
		  	$index=0;
		  	foreach ($item['common_conditions'] as $cc) 
			{ 
				$index++;
				if($index != 1)
				{
					 echo ' :: '.$cc['condition'];
				}
				else
				{
					echo $cc['condition'];
				}
			}  // end foreach common_conditions tags
			?>        </p>
        <?php }  //  common_conditions not empty   ?>
        
        
        <?php if (!(empty($item['skills']))) { ?>
        <p><span style="margin-right: 2em;"><strong>Skills and Procedures:</strong></span>
          <?php 
		  	$index=0;
		  	foreach ($item['skills'] as $s) 
			{ 
				$index++;
				if($index != 1)
				{
					 echo ' :: '.$s['skill'];
				}
				else
				{
					echo $s['skill'];
				}
			}  // end foreach skills tags
		  ?>
        </p>
        <?php }  //  skills tags not empty   ?>
        
        
        <?php if (!(empty($item['otherTags']))) { ?>
        <p><span style="margin-right: 2em;"><strong>Other:</strong></span>
          <?php 
		  	$index=0;
		  	foreach ($item['otherTags'] as $other) 
			{ 
				$index++;
				if($index != 1)
				{
					 echo ' :: '.$other['tag'];
				}
				else
				{
					echo $other['tag'];
				}
			}  // end otherTags tags
			
			?>
        </p>
        <?php }  //  other tags not empty   ?>
      </div>
      <!-- / col-md-12 -->
      <?php } ?>
    </div>
    
   
  
  </div>
 
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>
