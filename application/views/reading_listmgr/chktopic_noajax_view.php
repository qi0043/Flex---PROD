<?php
include 'header.php';
?>

<style>
/* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   speak for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
.modal {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .2 ) 
                url('<?php echo base_url() . 'resource/listmgr/';?>images/loading.gif') 
                50% 50% 
                no-repeat;
}

/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading {
    overflow: hidden;   
}

/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .modal {
    display: block;
}
</style>

<script>
$(function(){
  $body = $("body");
  $(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
  });
});
</script>

<script src="<?php echo base_url() . 'resource/listmgr/';?>js/chktopics.js" type="text/javascript"></script>

<br>
<!--
<nav class="navbar navbar-default" role="navigation">
<form class="navbar-form navbar-left" role="search">
  <div class="form-group">
    <input type="text" class="form-control" placeholder="Topic Code">
  </div>
  <button type="submit" class="btn btn-default">View/Rollover eReadings</button>
</form>
</nav>
-->

<form id="topicForm" method="get" action="chktopic" autocomplete="on">

<div class="breadcrumbs">
          
  <span typeof="v:Breadcrumb"><b>eReading List Management</b></span>
  
</div>

<br>
Please enter Topic code (e.g. AGES8022) below to display availabilities and eReading lists.
<br>
<table>
    
    <tr >
        <td >Topic Code:</td>
    </tr>
    <tr>
        <td><input id="topic_code" name="topic_code" type="text" tabindex="1" autocomplete="on" value="<?php if(isset($from_topic_code)) echo $from_topic_code; ?>"></td>
    </tr>
    <tr>
        <td><input id="viewtype" name="viewtype" type="hidden"></td>
    </tr>
</table>                                    
    
<br>

<button type="submit" id="display_avails_btn" class="btn btn-default">View/Rollover eReadings</button>
&nbsp;&nbsp;
<button type="button" id="request_mgt_btn" class="btn btn-default">List Change Request</button>
&nbsp;&nbsp;
<button type="reset" onclick='javascript: $("#from_topic_code").focus();' class="btn btn-default">Reset</button>
<br>
<br>

</form>
<br>
<div id="avails">

<?php if($topic_code_input==true) { ?>
<div class="breadcrumbs">
          
  <span typeof="v:Breadcrumb"><b>Availabilities for eReading list rollover and request management:</b></span>
  
</div>
<br>

<?php if($from_avails==false) { ?>
<p style="color:red">
   No availability found for the specified topic code.
<p>
<?php } else { ?>

<?php if($from_topic_name != false) {?>
<b><?php echo $from_topic_name;?></b>
<?php }?>
<br><br>
<table id="tblfromavails">
    <tr >
        <th> </th>
        <th>Topic Availabilities</th>
        <th>eReadings</th>
        <th>Action</th>

    </tr>
    
    <?php for($i=0;$i<count($from_avails);$i++){ ?>
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

<?php }?>
<?php }?>
    
    
    
</div>

<br>
<br>
    <p style="color:blue">Please note:</p> 
    <ul>
        <li>This system will only rollover eReadings activated <b>before today</b>.</li>
        <li>Do not use this system between midnight and 5AM as this is the system maintenence period.</li>
        <li>If rollover fails because of HTTP connection issue you could try the rollover again. </li>
        <li>For any issue you could contact: <a href="mailto:flex.help@flinders.edu.au?Subject=Flextra%20rollover%20tool%20query">flex.help@flinders.edu.au</a></li>
    </ul>

<div class="modal"><!-- Place at bottom of page --></div>

<!--
<script>

$(function(){$('.progress-bar').css('width', 90+'%').prop('aria-valuenow', '90').html('90%');});
</script>

<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
    30%
  </div>
</div>
-->

<?php

include 'footer.php';

?>