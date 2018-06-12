<?php

#include 'header.php';

$submit_action = "getereadings.html";
#$current_page = "chktopic";

#include 'nav1.php';
?>

<br>

<?php 
    $from_count = count($from_avails); 
    $to_count = count($to_avails); 
    $count = $from_count>$to_count ? $from_count : $to_count;
?>


<script type="text/javascript">
 $(function() {
    $( "button" )
      .button();
     
  });
  
 $(document).ready(function() {
  $('#tbltoavails tr')
    .filter(':has(:checkbox:checked)')
    .addClass('marked')
    .end()
  .click(function(event) {
    $(this).toggleClass('marked');
    if (event.target.type !== 'checkbox') {
      $(':checkbox', this).attr('checked', function() {
        return !this.checked;
      });
    }
  });
});

 $(document).ready(function() {
  $('#tblfromavails tr')
    .filter(':has(:radio:checked)')
    .addClass('marked')
    .end()
  .click(function(event) { 
    $(this).toggleClass('marked');
    if (event.target.type !== 'radio') {
      $(':radio', this).attr('checked', function() {
        return !this.checked;
      });
    $('#tblfromavails tr')
    .filter(':not(:has(:radio:checked))')
    .removeClass('marked');  
    }
  });
});
  
  $(document).ready(function() {
    $("#availsForm").submit(function()
    {
        if( $('#tblfromavails tr').filter(':has(:radio:checked)').length <= 0 ||
            //$('#tbltoavails tr').filter(':has(:checkbox:checked)').length <= 0 )
            $('#tbltoavails input:checkbox:checked').length <= 0 )
        {
            alert('Please select From and To availabilities.');
            return false;
        }
        //alert($('#tblfromavails tr').filter(':has(:radio:checked)').children("td.numreadings").text());
        //alert($('#tblfromavails input:radio:checked').parents('tr').children("td.numreadings").html());
        //return false;
        if($('#tblfromavails input:radio:checked').closest('tr').children("td.numreadings").text() == '0')
        {
            alert("Reading number of From availability can not be 0.");
            return false;
        }
        
        var ret = true;
        $('#tbltoavails input:checkbox:checked').each(function()
        {
            if($(this).val() == $('#tblfromavails input:radio:checked').val())
            {
                alert('To availabilities can not contain From availability.');
                ret = false;
                return false;
            }
        });
        
        return ret;
    });
  });      
</script>
        
<div class="breadcrumbs">
          
  <span typeof="v:Breadcrumb"><b>Availabilities for rollover:</b></span>
  
</div>
<br>

<form id="availsForm" action="<?php echo $submit_action?>" method="post">
<?php if($from_topic_name != false) {?>
<b><?php echo $from_topic_name;?></b>
<br>
<?php }?>
<?php if($to_topic_name != false && $to_topic_name != $from_topic_name) {?>
<b><?php echo $to_topic_name;?></b>
<br>
<?php }?>
<br>
<label class="preField">Please select From (one) To (one or multiple) availabilities for Rollover:  </label>   
<br>
<div style="float:left;">
<table id="tblfromavails">
    <!--
    <tr >
        <th colspan="3" style="background: #FFFFFF;"><?php echo $from_topic_name?> </th>
    </tr>
    -->
    <tr >
        <th> </th>
        <th>From Availability</th>
        <th>Readings</th>
    </tr>
    <?php for($i=0;$i<$from_count;$i++){ ?>
    <tr <?php if($i%2==0) echo "class='even'"; else echo "class='odd'"; ?> >
        <td><input type="radio" name ="from_avail" value="<?php echo $from_avails[$i]['availability']; ?>"></td>
        <td><?php echo $from_avails[$i]['availability']; ?></td>
        <td class="numreadings" style="text-align: center"><?php echo intval($from_avails_num_readings[$i]['num_readings']) + intval($from_avails_rollover_readings[$i]['num_readings']); ?></td>
      
    </tr>
    <?php } ?>
</table>
</div>

<div style="float:left;margin-left:10px;">
<table id="tbltoavails">
    <!--
    <tr >
        <th colspan="3" style="background: #FFFFFF;"><?php echo $to_topic_name?> </th>
    </tr>
    -->
    <tr>
        <th> </th>
        <th>To Availability</th>
        <th>Readings</th>
    </tr>
    <?php for($i=0;$i<$to_count;$i++){ ?>
    <tr <?php if($i%2==0) echo "class='even'"; else echo "class='odd'";?> >
        <td><input type="checkbox" name="to_avails[]" value="<?php if($i<$to_count) echo $to_avails[$i]['availability']; ?>"></td>
        <td><?php echo $to_avails[$i]['availability']; ?></td>
        <td style="text-align: center"><?php echo intval($to_avails_num_readings[$i]['num_readings']) + intval($to_avails_rollover_readings[$i]['num_readings']); ?></td>
    </tr>
    <?php } ?>
</table>
</div>

<div style="clear:left;">
</div>
<br>
<button type="submit" class="directory">Display eReadings</button>

<br>

</form>
