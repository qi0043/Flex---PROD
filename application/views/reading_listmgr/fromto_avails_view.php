<?php 
    $from_count = count($from_avails); 
    #$to_count = count($to_avails); 
    $count = $from_count;
    #$count = $from_count>$to_count ? $from_count : $to_count;
    if($action_type=="view_er")
        $action_url = "view_ereadings.html";
    else
        $action_url = "rollover_ereadings.html";
?>

<script type="text/javascript">
 
  $(function() {   
     //$("#home_link").attr("href","home.html?topic_code="+"<?php echo $from_topic_code; ?>");  
 });
 
 function getreadings(from_avail){
     
     $("#from_avail").val(from_avail);
     $("#availsForm").submit();
     $("#from_avail").val('');
 }
 /*
 function getrequests(avail){
     $("#avail_for_requests").val(avail);
     $("#getrequestForm").submit();
     $("#avail_for_requests").val('');
 }

 function create_request(){
     if($('input:checkbox[name^=avails_for_new_req]:checked').length == 0)
     {
         alert("Please select the topic availabilities for the request. If the desired availability is not shown then select the availability ending with 'OTHER'");
         return;
     }
     //return;
     $("#create_request").submit();
 }
 $(function(){$('#create_request_btn').button().click(function(){create_request();});});
 */
</script>
        
<form id="availsForm" action="<?php echo $action_url; ?>" method="post" >
    <input type="hidden" name="from_avail" id="from_avail" value="">
    <input type="hidden" name="from_topic_code" id="from_topic_code" value="<?php echo $from_topic_code; ?>">
</form>



<?php if($action_type=="view_er") { ?>
<h2>Select a list to view</h2>
<?php }else{ ?>
<h2>Select a list to copy from</h2>
<?php } ?>


<?php if($from_topic_name != false) {?>
<p><i>Topic:&nbsp;<?php echo $from_topic_name;?></i></p>
<?php }?>
<br />
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Topic Availability</th>
      <th>eReadings</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php for($i=0;$i<$from_count;$i++){ ?>
    <?php $tmp_num = intval($from_avails[$i]['count_reading']) + intval($from_avails[$i]['count_intm_reading']); ?>
    <tr>
      <td><?php echo $from_avails[$i]['availability'];?></td>
      <td><?php echo $tmp_num; ?></td>
      <td>
          <?php if ($tmp_num > 0) {?>

          <a href="javascript:void(0)" class="btn btn-primary" tabindex="10" onclick="javascript:getreadings('<?php echo $from_avails[$i]['availability']; ?>')" > 
              Select >> 
          </a>
          <?php }?>
      </td>
    </tr>
   <?php } ?> 
  </tbody>
</table>
        
<br>
<?php if($action_type=="rollover_er") { ?>
<h3 class="text-muted"><small><span class="glyphicon glyphicon-info-sign" ></span></small> For your information</h3>

<?php if($to_avails != false) { ?>
        <p>In step <b>3. Select target lists</b> the following lists for this topic are available:</p>
        <ul>
            <?php for($i=0;$i<count($to_avails);$i++){ ?>
            <li><?php echo $to_avails[$i]['availability']; ?></li>
            <?php } ?>
        </ul>
        <p>Note: Target lists from another topic can also be selected in step 3.</p>
<?php } else {?> 
        <br />
        <p class="text-danger">Important: There are no lists for this topic that can be used in step 3, <i>Select target lists</i>. </p>
        <p>Note: Target lists can be selected from other topics.</p>
<?php } ?> 
<?php } ?> 
