<?php
include 'header.php';
$req_count = intval($requests['length']); 
$topic_code = substr($availability, 0, strpos($availability, "_"));
?>

<div class="page-header" style="background-color:#EEE">
  <div class="container" >
    <div class="row">
      <div class="col-md-12"> <br />
        <h1>Step 2: View Requests</h1>
        <br />
      </div>
    </div>
    <div class="row ">
      <div role="navigation"> 
        <!-- For current step display: btn btn-success disabled AND >> before the next step  --> 
        <!-- For previous step display: btn btn-success AND tick before the next step  --> 
        <!-- For following steps display: btn btn-default AND >> before the next step  -->
        <div class="col-md-2"> <a href="view_req_chktopic.html?topic_code=<?php echo $topic_code;?>&view_type=request" class="btn btn-success  btn-block"  tabindex="100">1. Select list</a> </div>
        <div class="col-md-1"> 
          <!--<p class="text-center lead hidden-xs hidden-sm" > >> </p>-->
          <p class="text-success lead hidden-xs hidden-sm" style="color:#5cb85c;"><span class="glyphicon glyphicon-ok"></span></p>
        </div>
        <div class="col-md-2"> <a href="" class="btn btn-success disabled  btn-block" tabindex="100">2. View requests</a> </div>
        <div class="col-md-7"> 
          <!-- needed to keep height -->
          <p class="text-center lead hidden-xs hidden-sm">&nbsp; </p>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
$(function() {
 $("#header_level_2_txt").html("View requests");
 $('.readmore1').readmore();
 });
</script>



<style>

</style>
<script src="<?php echo base_url() . 'resource/listmgr/';?>js/readmore.js" type="text/javascript"></script>


<div class="container">
  <?php if($new_req_created == true){ ?>
  <div class="alert alert-success">
	The request has been successfully created..
  </div>
  <?php } ?>
  <br>  
  <div class="row">
    <div class="col-md-8 hidden-xs hidden-sm">
      <h3>Requests for availability: <?php echo $availability;?></h3>
    </div>
    <div class="col-md-4 hidden-xs hidden-sm">
      <p>To select a different list use the green button: <br />
        <b>1. Select list</b>. </p>
      <p>To return to the start page use the home link: <br />
        <b><span class="glyphicon glyphicon-home"></span> eReadings List Management</b>. </p>
    </div>
  </div>

  <br>
  <?php for($i=0;$i<$req_count;$i++){ ?>  
  <?php $details = '<b>' . $requests['results'][$i]['meta_array']['name'] . '</b><br><br>' . $requests['results'][$i]['meta_array']['content']; ?>

  <div class="row">
    <div class="col-md-3">
      
        Status: <span class="text-danger"><b><?php echo $requests['results'][$i]['meta_array']['status']; ?></b></span><br />
        Assigned to: <?php echo ($requests['results'][$i]['owner']['id'] == $requests['results'][$i]['meta_array']['added_by_fan'] ? '' : $requests['results'][$i]['meta_array']['owners'][1]['full_name']); ?><br />
        Date needed: <?php echo $requests['results'][$i]['meta_array']['needed_by']; ?><br />
        Created: <b><?php echo substr($requests['results'][$i]['createdDate'],0,19); ?></b><br />
        Created by: <?php echo $requests['results'][$i]['meta_array']['added_by_name']; ?><br />
        Lists:<ul>
          <?php for($j=1; $j<=count($requests['results'][$i]['meta_array']['availability']); $j++){ 
                echo '<li>'.$requests['results'][$i]['meta_array']['availability'][$j]['avRef'].'</li>';
          }?> 
          </ul>
    </div>
    <div class="col-md-9">
      <p class="lead"><?php echo $requests['results'][$i]['meta_array']['name'];?></p>
      <div <?php if($req_count>1){ ?> class="readmore1" <?php }?> ><?php echo $requests['results'][$i]['meta_array']['content'];?></div>
    </div>
  </div>
  <hr />
  <?php } ?>
</div>

<br>

