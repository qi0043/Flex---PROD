<?php
include 'header.php';
$req_count = intval($requests['available']); 
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

<script>
    $(function() {   
     $( "[name^=backto_avails]" )
      .button()
      .click(function( ) {
        window.location.href = "chktopic?topic_code=<?php echo $topic_code;?>&view_type=request";
      }); 
    });
    $(function() {
    //$( "button" ).button();
      $("#closebutton").click(function(){
        if(confirm("Are you sure you want to close the window?") === false)
            return;
        window.open('', '_self', '');
        window.close();});
    //$("#submit_request_btn").click(function(){$('#create_request_form').submit();});
  });
</script>

<style>
/*
table {
    border-collapse: collapse;
}
table, th, td
{
  border: 1px solid grey;
}
*/
table tr.odd1 th,
.odd1 {
    /*background: #E5E5E5;*/
    /*background: #F5F5F5;*/
    background: #FFFFFF;
}

table tr.even1 th,
.even1 {
    /*background: #D5D5D5;*/
    /* background: #E5E5E5; */
    /*background: #F0F0F0;*/
    background: #EEEEEE;
}

body{
    font-size: 13px;
}
</style>
<script src="<?php echo base_url() . 'resource/listmgr/';?>js/readmore.js" type="text/javascript"></script>


<div class="container">
  <?php if($new_req_created == true){ ?>
  <div class="alert alert-success">
	The request has been successfully created. You can view it below.
  </div>
  <?php } ?>
  <br>
  <h4>Requests for availability: <?php echo $availability;?></h4>
  <br>
  <?php for($i=0;$i<$req_count;$i++){ ?>  
  <?php $details = $requests['results'][$i]['meta_array']['name'] . '<br><br>' . $requests['results'][$i]['meta_array']['content']; ?>

  <div class="row">
    <div class="col-md-3"> Status: <span class="text-danger"><b><?php echo $requests['results'][$i]['meta_array']['status']; ?></b></span> <br />
      Assigned to: <br />
      Date needed: 13/12/2014 <br />
    </div>
    <div class="col-md-3"> Created: <b><?php echo substr($requests['results'][$i]['createdDate'],0,19); ?></b> <br />
      Created by: Glen Wang <br />
    </div>
    <div class="col-md-3"> 
      Lists:
      <ul>
        <li>AGES8022_2015_S2</li>
      </ul>
    </div>
    <div class="col-md-3"> 
      <!--not in use--> 
    </div>
  </div>
  <hr />
  <div class="row">
    <div class="col-md-12">
      <p class="lead">Delete</p>
          </div>
  </div>

  
  <div class="row">
    <div class="col-md-3">
      <b>Submission</b>
    </div>
    <div class="col-md-9">
      <b>Request</b>
    </div>
  </div>
  <hr />
  <div class="row">
    <div class="col-md-3">
      <ul class="list-unstyled">
        Status: <span class="text-danger"><b><?php echo $requests['results'][$i]['meta_array']['status']; ?></b></span>
        <br />Assigned to: 
        <br />
        <br />Created: <b><?php echo substr($requests['results'][$i]['createdDate'],0,19); ?></b>
        <br />For:<ul>
          <?php for($j=1; $j<=count($requests['results'][$i]['meta_array']['availability']); $j++){ 
                echo '<li>'.$requests['results'][$i]['meta_array']['availability'][$j]['avRef'].'</li>';
                if($j<count($requests['results'][$i]['meta_array']['availability']))
                    echo '<br>';
          }?> 
          </ul>
          
        <br />
        <br />Created by: <?php echo $requests['results'][$i]['meta_array']['added_by_name']; ?>
    </div>
    <div class="col-md-9">
      <p class="lead"><?php echo $requests['results'][$i]['meta_array']['name'];?></p>
      <?php echo $requests['results'][$i]['meta_array']['content'];?>
    </div>
  </div>
  <hr />
  <?php } ?>
</div>


<br><br>

<div id ="req_content_div">
    
</div>
<br>

