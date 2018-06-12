
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-file-o fa-fw"></i> Activity  :: <?php echo $item['itemTitle']; ?></h4>
      </div>
      <div class="modal-body">
      
      
<a href="https://flex.flinders.edu.au/items/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>" target="_blank" class="btn btn-sm btn-danger pull-right"><i class="fa fa-edit"></i> Edit this item</a>

<div class="row" style="margin-bottom:0.5em;">
  <div class="col-md-12">
<h4>Description</h4>
<p><?php echo $item['itemDescription']; ?></p>
</div>
</div>



<div class="row">
<div class="col-md-12">

<?php if($item['preInstructions'] != '' OR $item['duringInstructions'] != '' OR $item['postInstructions'] != '') { ?>
<h4>Instructions</h4>



<div class="panel-group" id="accordion">
  <?php if($item['preInstructions'] != '') { ?>

  <div class="panel panel-default">
    <div class="panel-heading">
      <h5 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          Before you start
        </a>
      </h5>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
      <div class="panel-body">
<?php echo $item['preInstructions']; ?>
      </div>
    </div>
  </div>
 <?php } ?>

 
   <?php if($item['duringInstructions'] != '') { ?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">During the activity</a>
      </h5>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
<?php echo $item['duringInstructions']; ?>
      </div>
    </div>
  </div>
<?php } ?>
  <?php if($item['postInstructions'] != '') { ?>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h5 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
          Collapsible Group Item #3
        </a>
      </h5>
    </div>
    <div id="collapseThree" class="panel-collapse collapse">
      <div class="panel-body">
<?php echo $item['postInstructions']; ?>.
      </div>
    </div>
  </div>

    <?php } ?>
 


 
</div>


  <?php } ?>


</div>
<div class="col-md-12">

<h4> Learning Outcomes</h4>
<?php if (intval(trim($los['numberApplicable'])) > 0) { ?>
<p>There are <?php echo $los['numberLOs']; ?> Learning Outcomes for the parent item <em><?php echo $item['parentTopic']; ?></em> of which the following <?php if (intval(trim($los['numberApplicable'])) == 1) { ?>outcome<?php } else { ?><?php echo $los['numberApplicable']; ?> outcomes<?php } ?> apply to this activity.
<dl class="dl-horizontal">
<?php foreach ($los['los'] as $lo) { ?>
<dt><?php echo $lo['code']; ?></dt>
<dd><?php echo $lo['name']; ?></dd>
<?php } ?>
</dl>
<?php } else { ?>
<p>This activity has not been aligned to the parent item learning outcomes</p>

<?php } ?>


</div>
<div class="col-md-12">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h5 class="panel-title">Resources</h5>
    </div>
    <div class="panel-body" style="font-size:14px;">
      <ul class="fa-ul">
        <?php foreach ($attachments as $a) { ?>
        <?php
	  
	  switch ($a['type']) {
	
	case 'file':
		$resourceclass = '<i class="fa-li fa fa-file-o fa-fw"></i>';
		break;
	case 'htmlpage':
		$resourceclass = '<i class="fa-li fa fa-external-link fa-fw"></i>';
		break;
	default:
		$resourceclass = '';
		break;
	
}
	 
	  ?>
        <li><?php echo $resourceclass; ?><a href="http://flex.flinders.edu.au/items/<?php echo $item['thisUuid']; ?>/<?php echo $item['thisVersion']; ?>/<?php echo $a['filename']; ?>" target="_blank"><?php echo $a['title']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>
      
</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>



