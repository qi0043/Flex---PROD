<?php
include 'header.php';
?>

<div class="page-header" style="background-color:#EEE">
  <div class="container" >
    <div class="row">
      <div class="col-md-12"> <br />
        <h1>Step 3: View Request</h1>
        <br />
      </div>
    </div>
    <div class="row ">
      <div role="navigation"> 
        <!-- For current step display: btn btn-success disabled AND >> before the next step  --> 
        <!-- For previous step display: btn btn-success AND tick before the next step  --> 
        <!-- For following steps display: btn btn-default AND >> before the next step  -->
        <div class="col-md-2"> <a href="create_req_chktopic.html?topic_code=<?php echo $topic_code;?>&view_type=request" class="btn btn-success btn-block"  tabindex="100">1. Select lists</a> </div>
        <div class="col-md-1">
          <!--<p class="text-center lead hidden-xs hidden-sm" > >> </p>-->
          <p class="text-success lead hidden-xs hidden-sm" style="color:#5cb85c;"><span class="glyphicon glyphicon-ok"></span></p> 
        </div>
        <div class="col-md-2"> <a href="" class="btn btn-success disabled  btn-block" tabindex="100">2. Send Request</a> </div>
        <div class="col-md-1">
          <!--<p class="text-center lead hidden-xs hidden-sm" > >> </p>-->
          <p class="text-success lead hidden-xs hidden-sm" style="color:#5cb85c;"><span class="glyphicon glyphicon-ok"></span></p> 
        </div>
        <div class="col-md-2"> <a href="" class="btn btn-success disabled  btn-block" tabindex="100">3. View Request</a> </div>
        <div class="col-md-4"> 
          <!-- needed to keep height -->
          <p class="text-center lead hidden-xs hidden-sm">&nbsp; </p>
        </div>
      </div>
    </div>

  </div>
</div>


<script type="text/javascript">
$(function() {
 $("#header_level_2_txt").html("Make request");

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
    
</script>



<div class="container">
  <?php if($new_req_created == true){ ?>
  <div class="alert alert-success">
	The request has been successfully created. You can view it below.
  </div>
  <?php } ?>
 
  <br>

  <?php $details = $request['meta_array']['name'] . '<br><br>' . $request['meta_array']['content']; ?>

  
  <div class="row">
    <div class="col-md-3">
        Status: <span class="text-danger"><b><?php echo $request['meta_array']['status']; ?></b></span><br />
        Assigned to: <br />
        Date needed: <?php echo $request['meta_array']['needed_by']; ?><br />
        Created: <b><?php echo $request['meta_array']['date_added']; ?></b><br />
        Created by: <?php echo $request['meta_array']['added_by_name']; ?><br />
        Lists:<ul>
          <?php for($j=1; $j<=count($request['meta_array']['availability']); $j++){ 
                echo '<li>'.$request['meta_array']['availability'][$j]['avRef'].'</li>';
          }?> 
          </ul>
    </div>
    <div class="col-md-9">
      <p class="lead"><?php echo $request['meta_array']['name'];?></p>
      <?php echo $request['meta_array']['content'];?>
    </div>
  </div>
  
  <hr />
  
</div>

<br>

