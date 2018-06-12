<?php

#include 'header.php';

$submit_action = "getereadings.html";
#$current_page = "chktopic";

#include 'nav1.php';
?>

<br>

<?php 
    $from_count = count($from_avails); 
    #$to_count = count($to_avails); 
    $count = $from_count;
    #$count = $from_count>$to_count ? $from_count : $to_count;
?>


<script type="text/javascript">
 function getreadings(from_avail){
     $("#from_avail").val(from_avail);
     $("#availsForm").submit();
     $("#from_avail").val('');
 }
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
 
 $(function() {   
     //$("#home_link").attr("href","home.html?topic_code="+"<?php echo $from_topic_code; ?>");  
 });
 
 <?php if($action_type=="create_req") { ?>
  $(document).ready(function() {
  $('#tblfromavails tr:has(:checkbox)')
    .filter(':has(:checkbox:checked)')
    .addClass('marked')
    .end()
  .click(function(event) {
    $(this).toggleClass('marked');
    if (event.target.type !== 'checkbox') {
      $(':checkbox', this).prop('checked', function() {
        return !this.checked;
      });
    }
  });
});
<?php } ?>
</script>
        

   <?php if($action_type=="view_req") { ?>
        <h2>Select a list to view requests</h2>
        <?php }else{ ?>
        <h2>Select lists for request</h2>
        <?php } ?>
        
<?php if($from_topic_name != false) {?>
<p><i>Topic: <?php echo $from_topic_name;?></i></p>
<?php }?>        
        
<br/> 

<div >

<form id="create_request" action="create_request.html" method="post" >
    <input type="hidden" name="topic_code" id="topic_code" value="<?php echo $from_topic_code; ?>">
<table id="tblfromavails" class="table table-hover">
    
    <!--
    <tr >
        <th colspan="3" style="background: #FFFFFF;"><?php echo $from_topic_name?> </th>
    </tr>
    -->
    <thead>
    <tr >
        <th>Topic Availability</th>
        <th>Requests</th>
        <?php if($action_type=="view_req") { ?>
        <th>Action</th>
        <?php }else{ ?>
        <th>Selections</th>
        <?php } ?>
    </tr>
    </thead>
    <tbody>
    <?php for($i=0;$i<$from_count;$i++){ ?>
    <tr <?php if($i%2==0) echo "class='even'"; else echo "class='odd'"; ?> >
        
        <td><?php echo $from_avails[$i]['availability'];?>
        </td>     
       
        <td style="text-align: center">
            <?php if ($avails_num_requests[$i] > 0) {?>
            
                <?php echo $avails_num_requests[$i]; ?>
            
            <?php } else { echo $avails_num_requests[$i]; }?>
        </td>
        
        <?php if($action_type=="view_req") { ?>
            <?php if ($avails_num_requests[$i] > 0) {?>
            <td><a href="javascript:void(0)" onclick="javascript:getrequests('<?php echo $from_avails[$i]['availability']; ?>')" class="btn btn-primary" tabindex="50">Select >> </a></td>
            <?php }else {?>
            <td></td>
            <?php }?>
        <?php }else{ ?>
        <td style="text-align: center"><input type="checkbox" name="avails_for_new_req[]" value="<?php echo $from_avails[$i]['availability']; ?>"></td>
        <?php } ?>
    </tr>
    <?php } ?>
    </tbody>
</table>
<?php if($action_type!="view_req") { ?>    
<p class="text-right"><button type="button" id="create_request_btn" class="btn btn-primary" tabindex="50">Next step >> </button></p>
<?php } ?>
</form>
 
<br />
<?php if($action_type!="view_req") { ?> 
<p class="text-muted">If you cannot see the topic availability you need use <b>Use <?php echo $from_topic_code; ?>_OTHER</b> and include the actual topic availability in the body of the request.</p>
<?php }else{ ?>   
<p class="text-muted"><b><?php echo $from_topic_code; ?>_OTHER</b> was used when the required topic availability was not listed.</p>    
<?php } ?>
<form id="availsForm" action="<?php echo $submit_action?>" method="post" >
    <input type="hidden" name="from_avail" id="from_avail" value="">
    <input type="hidden" name="from_topic_code" id="from_topic_code" value="<?php echo $from_topic_code; ?>">
</form>

<form id="getrequestForm" action="get_requests_by_avail.html" method="post" >
    <input type="hidden" name="avail_for_requests" id="avail_for_requests" value="">
</form>

    
</div>


<!--<button type="submit" class="directory">Display eReadings</button>-->

<br>


