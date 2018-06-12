<?php
$flexserv = "https://flex.flinders.edu.au";

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

$thetype = $item['teachingType'];
?>
<script>

$('#tagControl').click(function() {

	
    if ( $('#collapseTags').hasClass( "in" ) ) {
 
        $('#tagControl').html('<i class="fa fa-chevron-down"></i>');

    } else {
		
		$('#tagControl').html('<i class="fa fa-chevron-up"></i>');
	}
 
});

</script>

<?php 

/*  ---------------------   
if ($fan == 'couc0005') {
	
	
	echo "<pre>";
	print_r($item);
	echo "</pre>";
	
	
}

*/




?>


<h4 style="line-height:130%;">Activity Detail: <?php echo $item['itemTitle']; ?></h4>
<small><span  class="text-uppercase">Teaching type: <strong><span class="text-success"><?php echo $thetype; ?></span></strong></span></small>
<p><?php echo $item['itemDescription']; ?></p>


<?php if ($item['itemTopic'] == "MMED8106" && $item['teachingType'] == "Facilitated small group" && $item['crossTopic'][1]['type'] == "PBL Case") { ?> 
	<h5>Case Learning Objectives</h5>
<div class="col-md-12">

<dl class="dl-horizontal">
<?php 
/*   */


foreach ($activity_los as $case_lo) { ?>
<dt style="width:40px;"><?php echo $case_lo['code']; ?></dt>
<dd style="margin-left:60px;"><?php echo $case_lo['name']; ?></dd>
<?php }   ?>
</dl>


</div>


<?php  } ?>





<?php if (!(empty($item['overall']))) { ?> 
	<h5>Activity Information & Resources</h5>
	<?php if (isset($item['overall']['instructions']) && !(empty($item['overall']['instructions']))) { ?>


    <div class="col-md-12">


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
											$linkuse = '';
											if(isset($rlink['resourceType']) && $rlink['resourceType'] == 'a') 
											{
												//$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['uuid']; 
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
	<?php }  ?> 
    </ul>
</div>
<?php } // overall instructions not empty ?>

  <?php if (!(empty($item['overall']['linked']))) { ?>


<div class="col-md-12">


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
							$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['thisUuid'] . '/' .$rlink['filename']; 
						} 
						else 
						{
							$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . $rlink['uuid']; 
							//$linkuse = '/' . $rlink['thisUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['uuid']; 
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
					
					if(isset($item['hideLink']) && $item['hideLink']=='1')
					{
						$desc = $desc . ' (Link will be activated after completion of case)';
						?>
						<li><?php echo $resourceclass; ?><?php echo $desc; ?></a></li> 
				   <?php	
					}
					else
					{
					?>
                    	<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
					<?php }
                }
				else
				{?>
					<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
			<?php } ?>
                
            <?php }?>
    </ul>
 </div>   
 <?php } // overall linked not empty ?>
    
  <div class="clear"></div>
    <?php } // overall not empty ?>
  





  
 <?php if (!(empty($item['pre']))) { ?>
 <h5>Pre-Activity</h5>
 <?php if (!(empty($item['pre']['instructions']))) { ?>

  
<div class="col-md-12">


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
												$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['filename']; 
											} 
											else 
											{
												$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['filename']; 
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
								}
								else
								{
									$theUuid = $item['pre']['instructions']['itemUuid'];
									$theVersion = $item['pre']['instructions']['itemVersion'];
									$resourceserver = '/flex/flo-ocf/generatetoken/viewSummaryPage';
									$linkuse = '/items/' . $theUuid . '/' . $theVersion . '/';
									$href = $resourceserver.$linkuse ;
								}
								$desc = $item['pre']['instructions']['description'];
							}
					break;
						
					default:
							$resourceclass = '';
							break;
				}
                
               if(isset($item['pre']['instructions']['pbl']) && $item['pre']['instructions']['pbl'] == 'True')
               {
					$desc = 'Case page: '.$desc;
					
					if(isset($item['hideLink']) && $item['hideLink']=='1')
					{
						$desc = $desc . ' (Link will be activated after completion of case)';
						?>
						<li><?php echo $resourceclass; ?><?php echo $desc; ?></a></li> 
				   <?php	
					}
					else
					{
					?>
                    	<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
					<?php }
                }
				else
				{?>
					<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
			<?php }  	
	 }  ?> 
	</ul>
</div>
<?php } ?>

     <?php if (!(empty($item['pre']['linked']))) { ?>
<div class="col-md-12">    

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
							//$desc = 'Case Page: '. $rlink['description'];
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
						$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['filename']; 
						//$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
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
				
				if(isset($item['hideLink']) && $item['hideLink']=='1')
				{
					$desc = $desc . ' (Link will be activated after completion of case)';
					?>
					<li><?php echo $resourceclass; ?><?php echo $desc; ?></a></li> 
			   <?php	
				}
				else
				{?>
					<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
				<?php }
			}
			else
			{?>
				<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
		<?php } 
		}?>
    </ul>   
 </div>  
 
 <?php } ?> 
</div>

    
  <div class="clear"></div>
  
   <?php } // pre not empty ?>
 
 
 
 
 <?php if (!(empty($item['during']))) { ?>
<h5>During Activity</h5>
    <?php if (!(empty($item['during']['instructions']))) { ?>
    
	  
    <div class="col-md-12">
   
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
														$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' . $rlink['filename']; 
														//$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$item['during']['instructions']['uuid']; 
													} 
													else 
													{
														$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . $rlink['filename']; 
													}
													
													
													$resourceserver = '/flex/flo-ocf/generatetoken/viewfile/file';
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
                                    }
                                    else
                                    {
                                        $theUuid = $item['during']['instructions']['itemUuid'];
                                        $theVersion = $item['during']['instructions']['itemVersion'];
                                        $resourceserver = '/flex/flo-ocf/generatetoken/viewSummaryPage';
										$linkuse = '/items/' . $theUuid . '/' . $theVersion . '/';
										$href = $resourceserver.$linkuse ;
                                    }
									$desc = $item['during']['instructions']['description'];
                                }
                            break;
                                
                            default:
                                    $resourceclass = '';
                                    break;
                        }
						if(isset($item['during']['instructions']['pbl']) && $item['during']['instructions']['pbl'] == 'True') 
						{
							$desc = 'Case page: '.$desc;
							
							if(isset($item['hideLink']) && $item['hideLink']=='1')
							{
								$desc = $desc . ' (Link will be activated after completion of case)';
								?>
								<li><?php echo $resourceclass; ?><?php echo $desc; ?></a></li> 
						   <?php	
							}
							else
							{?>
								<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
							<?php }
						}
						else
						{?>
							<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
					<?php } ?>
            <?php }  ?>  
        </ul>
    </div>
	<?php } ?>

<?php if (!(empty($item['during']['linked']))) { ?>
<div class="col-md-12">     

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
							//$desc = 'Case Page: '. $rlink['description'];
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
						$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['filename']; 
						//$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
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
				
				if(isset($item['hideLink']) && $item['hideLink']=='1')
				{
					$desc = $desc . ' (Link will be activated after completion of case)';
					?>
					<li><?php echo $resourceclass; ?><?php echo $desc; ?></a></li> 
			   <?php	
				}
				else
				{?>
					<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
				<?php }
			}
			else
			{?>
				<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
		<?php } ?>
		<?php }?>
     </ul>  
 </div>
 <?php } ?>   
  
 
    
  <div class="clear"></div>
  
   <?php } ?>
 
 
 
<?php if (!(empty($item['post']))) { ?>
<h5>Post-Activity</h5>
 
    <?php if (!(empty($item['post']['instructions']))) { ?>
	   
    	<div class="col-md-12">

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
													//$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['uuid']; 
													$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$item['post']['instructions']['uuid']; 
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
                                }
                                else
                                {
                                    $theUuid = $item['post']['instructions']['itemUuid'];
                                    $theVersion = $item['post']['instructions']['itemVersion'];
									$resourceserver = '/flex/flo-ocf/generatetoken/viewSummaryPage';
									$linkuse = '/items/' . $theUuid . '/' . $theVersion . '/';
									$href = $resourceserver.$linkuse ;
                                }
								 $desc = $item['post']['instructions']['description'];
                            }
                        break;
                            
                        default:
                                $resourceclass = '';
                                break;
                    }
					
					if(isset($item['post']['instructions']['pbl']) && $item['post']['instructions']['pbl'] == 'True') 
					{
						$desc = 'Case page: '.$desc;
						if(isset($item['hideLink']) && $item['hideLink']=='1')
						{
							$desc = $desc . ' (Link will be activated after completion of case)';
							?>
							<li><?php echo $resourceclass; ?><?php echo $desc; ?></a></li> 
					   <?php	
						}
						else
						{?>
							<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
						<?php }
					}
					else
					{?>
						<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
					<?php } ?>
            <?php }  ?>  
        </ul>
		</div>
	<?php } ?>
    
    <?php if (!(empty($item['post']['linked']))) { ?>
    	<div class="col-md-12"> 
   
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
                                //$desc = 'Case Page: '. $rlink['description'];
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
							$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['filename']; 
							//$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
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
					
					if(isset($item['hideLink']) && $item['hideLink']=='1')
					{
						$desc = $desc . ' (Link will be activated after completion of case)';
						?>
						<li><?php echo $resourceclass; ?><?php echo $desc; ?></a></li> 
				   <?php	
					}
					else
					{?>
                    	<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
					<?php }
                }
				else
				{?>
					<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank"><?php echo $desc; ?></a></li> 
			<?php } ?>
            <?php }?>
         </ul>
     	</div>
    <?php } ?>
    <div class="clear"></div>
<?php } ?>

<?php 
if (!(empty($item['teachingTeam'])))
{
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
		<div class="alert alert-danger" role="alert">
			<h5 class="text-danger">Teaching Team</h5>
            <!-- teaching team instructions -->
            <?php if (!(empty($item['teachingTeam']['instructions']))) { ?>
	
                <div class="col-md-12">
          
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
                            }
							
							if(isset($item['teachingTeam']['instructions']['pbl']) && $item['teachingTeam']['instructions']['pbl'] == 'True') 
							{
								$desc = 'Case page: '.$desc;
								
								if(isset($item['hideLink']) && $item['hideLink']=='1')
								{
									$desc = $desc . ' (Link will be activated after completion of case)';
									?>
									<li><?php echo $resourceclass; ?><?php echo $desc; ?></a></li> 
							   <?php	
								}
								else
								{?>
									<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" class="alert-link"><?php echo $desc; ?></a></li> 
								<?php }
							}
							else
							{?>
								<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" class="alert-link"><?php echo $desc; ?></a></li> 
						<?php } ?>
                <?php }  ?>  
                    </ul>
         		</div>
 			<?php } ?> <!-- ./teaching team instructions -->

            <!-- teaching team linked resources -->
            <?php if (!(empty($item['teachingTeam']['linked']))) { ?>
		
                <div class="col-md-12">
      
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
										$linkuse = '/' . $rlink['itemUuid'] . '/' . $rlink['itemVersion'] . '/' .$rlink['filename']; 
										//$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' .$rlink['uuid']; 
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
								
								if(isset($item['hideLink']) && $item['hideLink']=='1')
								{
									$desc = $desc . ' (Link will be activated after completion of case)';
									?>
									<li><?php echo $resourceclass; ?><?php echo $desc; ?></a></li> 
							   <?php	
								}
								else
								{?>
									<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" class="alert-link"><?php echo $desc; ?></a></li> 
								<?php }
							}
							else
							{?>
								<li><?php echo $resourceclass; ?><a href="<?php echo $href; ?>" target="_blank" class="alert-link"><?php echo $desc; ?></a></li> 
						<?php } 
						 }?>
                     </ul> 
                 </div> 
	 		<?php } ?>  <!-- ./teaching team linked resources -->
         <div class="clearfix"></div>
		</div>
		<div class="clear"></div>
     <?php } //end of flag?
 } //end of teachingTeam empty?>
 
 
 <?php if($item['pblCase'] == "False") { ?>  
  <?php if (!(empty($activity_los))) { ?>
<div>


<h5>Session Outcomes </h5>
<p>Session outcomes in addition to the group learning objectives.</p>

<dl class="dl-horizontal">
<?php foreach ($activity_los as $activitylo) { ?>
<dt><?php echo $activitylo['code']; ?></dt>
<dd><?php echo $activitylo['name']; ?></dd>
<?php } ?>
</dl>

</div>   <!-- / col-md-12 --> 
<?php }  //  lo not empty   ?>

<?php }  //  not a PBL case ?>






<?php if($item['pblCase'] == "True"  && $item['itemTopic'] == "MMED8302") { ?>  
  <?php if (!(empty($activity_los))) { ?>
<div>


<h5>Case Learning Objectives</h5>

<dl class="dl-horizontal">
<?php foreach ($activity_los as $activitylo) { ?>
<dt><?php echo $activitylo['code']; ?></dt>
<dd><?php echo $activitylo['name']; ?></dd>
<?php } ?>
</dl>

</div>   <!-- / col-md-12 --> 
<?php }  //  lo not empty   ?>

<?php }  //  item is a Year 3 a PBL case ?>
 
 
 
 <!-- Tags -->

<?php if (!(empty($item['crossTopic'])) || !(empty($item['disciplines'])) || !(empty($item['common_presentations'])) || !(empty($item['skills'])) || !(empty($item['otherTags'])) ) { ?>   
  <div>
    <h5>Tags  <button id="tagControl" class="btn btn-tiny btn-default doNotPrint" style="margin-left:0.5em;" data-toggle="collapse" data-target="#collapseTags" aria-expanded="false" aria-controls="collpaseLO"><i class="fa fa-chevron-down"></i></button></h5>
    <div class="collapse" id="collapseTags">
      <?php if (!(empty($item['crossTopic']))) { ?>
      <p><span style="margin-right: 2em;"><strong>Cross Topic</strong></span></span>
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
      <p><span style="margin-right: 2em;"><strong>Disciplines</strong></span>
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
      <p><span style="margin-right: 2em;"><strong>Common Presentations</strong></span>
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
      <p><span style="margin-right: 2em;"><strong>Common Conditions</strong></span>
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
        <p><span style="margin-right: 2em;"><strong>Skills and Procedures</strong></span>
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
        <p><span style="margin-right: 2em;"><strong>Other</strong></span>
			<?php 
            $numOther = count($item['otherTags']);
            $i = 0;
            ?>
			<?php foreach ($item['otherTags'] as $other) 
			{ 
				$i++;  
             	echo $other['tag']; 
                if($i < $numOther) 
				{ 
					echo "&nbsp;::&nbsp;"; 
				}
			} // end foreach other tags ?>
        </p>
    <?php }  //  other tags not empty   ?>
    </div>

  
  </div>
  
  
  <?php }  //   tags not empty   ?> 
  



</div>     