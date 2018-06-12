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


<h4>Activity Detail: <?php echo $item['itemTitle']; ?></h4>
<p><?php echo $item['itemDescription']; ?></p>
<!--       
<pre>

<?php print_r($item); ?>
</pre>
-->
  <?php if (!(empty($item['overall']))) { ?> 
<h5>Activity Information & Resources</h5>
 <?php if (!(empty($item['overall']['instructions']))) { ?>
<div class="col-md-6">
<p><span style="margin-right: 2em;"><strong>Information</strong></span></p>
  <ul class="fa-ul">
  <?php
	  
	switch ($item['overall']['instructions']['type']) {
	
	
case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';
		$resourceserver = '/flex/ocf/loadpageflo';
		break;
	default:
		$resourceclass = '';
		break;
}
	 
	  ?>
      <li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo urlencode(base64_encode($item['overall']['instructions']['filename'])); ?>" target="_blank"><?php echo $item['overall']['instructions']['description']; ?></a></li>  
    </ul>
</div>
<?php } // overall instructions not empty ?>

  <?php if (!(empty($item['overall']['linked']))) { ?>
<div class="col-md-6">
<p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
    <ul class="fa-ul">
    <?php foreach ($item['overall']['linked'] as $olinked) { ?>
      <?php
	  
	switch ($olinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . $olinked['filename'] ;
		$resourceserver = $flexserv;
		break;
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $olinked['itemUuid'] . '/' . $olinked['itemVersion'];
		$resourceserver = $flexserv;
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$linkuse = '/' . $item['thisUuid'] . '/' . $item['thisVersion'] . '/' . $olinked['filename'] ;
		$resourceserver = '/flex/ocf/loadpageflo';
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>

    <li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?><?php echo $linkuse ; ?>?token=<?php echo $token; ?>" target="_blank"><?php echo $olinked['description']; ?></a></li>

    <?php } ?>
    </ul>
 </div>   
 <?php } // overall linked not empty ?>
    
  <div class="clear">
    <?php } // overall not empty ?>
  
  
  
  
 <?php if (!(empty($item['pre']))) { ?>  
  
  <hr />
 <h5>Pre-Activity Information & Resources</h5>
 <?php if (!(empty($item['pre']['instructions']))) { ?>
<div class="col-md-6">   
      <p><span style="margin-right: 2em;"><strong>Information</strong></span></p>
  <ul class="fa-ul">
  <?php
	  
	switch ($item['pre']['instructions']['type']) {
	
	case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$resourceserver = '/flex/ocf/loadpageflo';
		break;
	default:
		$resourceclass = '';
		break;
	
} 
	  ?>

      <li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo urlencode(base64_encode($item['pre']['instructions']['filename'])); ?>" target="_blank"><?php echo $item['pre']['instructions']['description']; ?></a></li>     
    </ul>
</div>
<?php } ?>

     <?php if (!(empty($item['pre']['linked']))) { ?>
<div class="col-md-6">    
    <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
    <ul class="fa-ul">
    <?php foreach ($item['pre']['linked'] as $prelinked) { ?>
      <?php
	switch ($prelinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';
		$linkuse = '/' . $prelinked['filename'] ;
		$resourceserver = $flexserv;
		break;
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $prelinked['itemUuid'] . '/' . $prelinked['itemVersion'];
		$resourceserver = $flexserv;
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$linkuse = '/' . $prelinked['filename'] ;
		$resourceserver = '/flex/ocf/loadpageflo';
		break;
	default:
		$resourceclass = '';
		break;
}
	  ?>

    <li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?><?php echo $linkuse ; ?>?token=<?php echo $token; ?>" target="_blank"><?php echo $prelinked['description']; ?></a></li>    
    
    <?php } ?>
    </ul>   
 </div>  
 
 <?php } ?> 
</div>

    
  <div class="clear">
  
   <?php } // pre not empty ?>
 
 
 
 
 <?php if (!(empty($item['during']))) { ?> 
  
  <hr />  
<h5>During Activity Information & Resources</h5>
    <?php if (!(empty($item['during']['instructions']))) { ?>
<div class="col-md-6">
<p><span style="margin-right: 2em;"><strong>Information</strong></span></p>
     <ul class="fa-ul">
       <?php
	switch ($item['during']['instructions']['type']) {
	
	case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$resourceserver = '/flex/ocf/loadpageflo';
		break;
	default:
		$resourceclass = '';
		break;
	
}
	
	 
	  ?>

<li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo urlencode(base64_encode($item['during']['instructions']['filename'])); ?>" target="_blank"><?php echo $item['during']['instructions']['description']; ?></a></li>      
       
     </ul>
</div>
<?php } ?>

<?php if (!(empty($item['during']['linked']))) { ?>
<div class="col-md-6">     
   <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
     <ul class="fa-ul">
       <?php foreach ($item['during']['linked'] as $dlinked) { ?>
       <?php
	  
	switch ($dlinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';
		$linkuse = '/' . $dlinked['filename'] ;
		$resourceserver = $flexserv;
		break;
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $dlinked['itemUuid'] . '/' . $dlinked['itemVersion'];
		$resourceserver = $flexserv;
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$linkuse = '/' . $dlinked['filename'] ;
		$resourceserver = '/flex/ocf/loadpageflo';
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
<li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?><?php echo $linkuse ; ?>?token=<?php echo $token; ?>" target="_blank"><?php echo $dlinked['description']; ?></a></li>
    
       <?php } ?>
     </ul>  
 </div>
 <?php } ?>   
 </div>   
 
    
  <div class="clear">
  
   <?php } ?>
 
 
 
<?php if (!(empty($item['post']))) { ?> 
  
  <hr />
 <h5>Post-Activity Information & Resources</h5>
 

<div class="col-md-6">
  <p><span style="margin-right: 2em;"><strong>Information</strong></span></p>
     <ul class="fa-ul">
       <?php
	  
	  
	switch ($item['post']['instructions']['type']) {
	
	case 'htmlpage':
	//case 'url':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$resourceserver = '/flex/ocf/loadpageflo';
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
<li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo urlencode(base64_encode($item['post']['instructions']['filename'])); ?>" target="_blank"><?php echo $item['post']['instructions']['description']; ?></a></li>   
       
     </ul>
 </div>
<div class="col-md-6">    
 <p><span style="margin-right: 2em;"><strong>Resources</strong></span></p>
     <ul class="fa-ul">
       <?php foreach ($item['post']['linked'] as $plinked) { ?>
       <?php
	  
switch ($plinked['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		$linktype = 'file';
		$linkuse = '/' . $plinked['filename'] ;
		$resourceserver = $flexserv;
		break;
	case 'linked-resource': 
		$resourceclass = '<i class="fa-li fa fa-link fa-fw"></i>';
		$linktype = 'items';	
		$linkuse = '/' . $plinked['itemUuid'] . '/' . $plinked['itemVersion'];
		$resourceserver = $flexserv;
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		$linktype = 'file';	
		$linkuse = '/' . $plinked['filename'] ;
		$resourceserver = '/flex/ocf/loadpageflo';
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
<li><?php echo $resourceclass; ?><a href="<?php echo $resourceserver; ?>/<?php echo $linktype; ?>/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?><?php echo $linkuse ; ?>?token=<?php echo $token; ?>" target="_blank"><?php echo $olinked['description']; ?></a></li>
           <?php } ?>
     </ul> 
     </div>
  <div class="clear">
  
   <?php } ?>
        
</div>     