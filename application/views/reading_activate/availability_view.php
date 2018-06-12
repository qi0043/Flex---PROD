<?php

#include 'header.php';

$submit_action = "activate_reading_res.html";
#$current_page = "chktopic";

#include 'nav1.php';
?>

<br>

<?php 
    $avail_count = count($availabilities); 
    //$to_count = count($to_avails); 
    //$count = $from_count>$to_count ? $from_count : $to_count;
?>

<?php #echo form_open($submit_action); ?>
<script type="text/javascript">
 $(function() {
    $( "button" )
      .button();
     
  });
  
 $(document).ready(function() {
  $('#tblavails tr')
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
    
    $("#availsForm").submit(function()
    {
        if( $('#tblavails input:checkbox:checked').length <= 0 )
        {
            alert('Please select the availabilities.');
            return false;
        }
        if(confirm("Are you sure you want to activate the eReading for selected availabilities?")===false)
            return false;
        $("#availsForm input[name=uuid]").val($("#theuuid").val());
        $("#availsForm input[name=version]").val($("#theversion").val());
        $("#availsForm input[name=attachment]").val($("#theattachment").val());
    });
  });      
</script>
        
<div class="breadcrumbs">
          
  <span typeof="v:Breadcrumb"><b>Availabilities for activation:</b></span>
  
</div>
<br>

<form id="availsForm" action="<?php echo $submit_action?>" method="post">

<?php if($topic_name != false) {?>
<b><?php echo $topic_name;?></b>
<br>
<?php }?>

<br>
<label class="preField">Please select availabilities for activation:  </label>   
<br>
<div>
<table id="tblavails">

    <tr>
        <th> </th>
        <th>Availability</th>
        
    </tr>
    <?php for($i=0;$i<$avail_count;$i++){ ?>
    <tr <?php if($i%2==0) echo "class='even'"; else echo "class='odd'";?> >
        <td><input type="checkbox" name="to_avails[]" value="<?php echo $availabilities[$i]['availability']; ?>"></td>
        <td><?php echo $availabilities[$i]['availability']; ?></td>
    </tr>
    <?php } ?>
</table>
    <input type="hidden" name="uuid" value="" />
    <input type="hidden" name="version" value="" />
    <input type="hidden" name="attachment" value="" />
</div>

<br>
<button type="submit" class="directory">Activate eReading</button>
<br><br><br><br>
***Below option for special circumstances only*** e.g. when super contributors delete and re-do activations, after citation amendments.
<br>
<input type="checkbox" name="suppress_dup_chk" value="1" />Override nightly duplication check. 

<br>

</form>
