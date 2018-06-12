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
</script>
        
<div class="breadcrumbs">
          
  <span typeof="v:Breadcrumb"><b>View/rollover eReading lists:</b></span>
  
</div>
<br>

<form id="availsForm" action="<?php echo $submit_action?>" method="post" >
    <input type="hidden" name="from_avail" id="from_avail" value="">
    <input type="hidden" name="from_topic_code" id="from_topic_code" value="<?php echo $from_topic_code; ?>">
</form>

<form id="getrequestForm" action="get_requests_by_avail" method="post" >
    <input type="hidden" name="avail_for_requests" id="avail_for_requests" value="">
</form>

<?php if($from_topic_name != false) {?>
<b><?php echo $from_topic_name;?></b>
<?php }?>
<br><br>
<!--<label class="preField">Please select one From availabilities for Rollover:  </label>   
<br><br>-->
<div >

<form id="create_request" action="create_request" method="post" target="_blank">
    <input type="hidden" name="topic_code" id="topic_code" value="<?php echo $from_topic_code; ?>">
<table id="tblfromavails">
    
    <!--
    <tr >
        <th colspan="3" style="background: #FFFFFF;"><?php echo $from_topic_name?> </th>
    </tr>
    -->
    <tr >
        <th> </th>
        <th>Topic Availabilities</th>
        <th>eReadings</th>
        <th>Action</th>

    </tr>
    
    <?php for($i=0;$i<$from_count;$i++){ ?>
    <tr <?php if($i%2==0) echo "class='even'"; else echo "class='odd'"; ?> >
        
        <td><?php echo $i+1; ?></td>
        <td><?php echo $from_avails[$i]['availability'];?>
            <?php if($from_avails[$i]['in_equella'] == 'new') { ?>
            <img src="<?php echo base_url() . 'resource/listmgr/';?>images/new_icon.gif"></img>
            <?php } ?>
        </td>     
        <td class="numreadings" style="text-align: center">
            <?php $tmp_num = intval($from_avails_num_readings[$i]['num_readings']) + intval($from_avails_rollover_readings[$i]['num_readings']); ?>
            
            <?php echo $tmp_num; ?>
        </td>
        <td class="numreadings" style="text-align: center">
            <?php #$tmp_num = intval($from_avails_num_readings[$i]['num_readings']) + intval($from_avails_rollover_readings[$i]['num_readings']); ?>
            <?php if ($tmp_num > 0) {?>
            <a href="javascript:void(0)" onclick="javascript:getreadings('<?php echo $from_avails[$i]['availability']; ?>')" >
                     View/Rollover eReadings
            </a>
            <?php } else {  }?>
        </td>

    </tr>
    <?php } ?>
    
    
</table>
</form>
</div>


<!--<button type="submit" class="directory">Display eReadings</button>-->

<br>


