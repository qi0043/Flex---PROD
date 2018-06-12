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
<h4 class="modal-title" id="myModalLabel"><!--<i class="fa fa-files-o fa-fw"></i>  --><?php echo $topics['tcode']; ?> <?php echo $topics['topicTitle']; ?></h4>
    </div>



<div class="modal-body">

<div class="row" style="margin-bottom:0.5em;" id="itemdetail">
  <div class="col-md-10 col-sm-8 col-xs-12">
    <div id="itemDescription">
     <?php echo $topics['description']; ?>
    </div>
    
  </div>
  </div>
  <div class="row">





<h5> Learning Outcomes</h5>
<p><?php echo $topics['ocIntro'];?></p>

<dl class="dl-horizontal">
<!--<dl class="dl">-->
<?php foreach ($topics['topic']['los'] as $topicoutcome) { ?>

<dt><?php echo $topicoutcome['code']; ?></dt>

<dd><?php echo $topicoutcome['name']; ?></dd>

<?php } // end topicoutcomes ?>

</dl>


<h5>Assessment Items</h5>

<ol>
<?php 
if(isset($sam['sam']['assessment']) && count($sam['sam']['assessment'])>0)
{
	foreach ($sam['sam']['assessment'] as $assessment) { ?>
<li><?php echo $assessment['name']; ?></li>

<?php }}  ?>
</ol>


</div>







</div>












<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>
