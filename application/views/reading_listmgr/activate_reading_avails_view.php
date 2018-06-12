<?php 
    $avail_count = count($availabilities); 
    //$to_count = count($to_avails); 
    //$count = $from_count>$to_count ? $from_count : $to_count;
?>

<?php #echo form_open($submit_action); ?>
<script type="text/javascript">
 $(function() {
    //$( "button" )
    //  .button();
     
  });
  
 $(document).ready(function() {
  $('#tblavails tr:has(:checkbox)')
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
        $("#availsForm input[name=item_name]").val($("#theitemname").val());
    });
  });  
 


</script>
        
<h2>Select target lists <span class="text-info">to activate eReading</span></h2>
<?php if($topic_name != false) {?>
<p><i>Topic:&nbsp;<?php echo $topic_name;?></i></p>
<?php }?>

<br />
<form id="availsForm" action="activate_reading_res.html" method="post" >
<input type="hidden" name="topic_code" id="topic_code" value="<?php echo $topic_code; ?>">
<table id="tblavails" class="table table-hover">
          <thead>
            <tr>
              <th>Topic Availability</th>
              <th>eReadings</th>
              <th>Targets</th>
            </tr>
          </thead>
          <tbody>
            <?php for($i=0;$i<$avail_count;$i++){ ?>
            <?php $tmp_num = intval($availabilities[$i]['count_reading']) + intval($availabilities[$i]['count_intm_reading']); ?>
            <tr <?php if($i%2==0) echo "class='even'"; else echo "class='odd'";?> >
              <td><?php echo $availabilities[$i]['availability']; ?></td>
              <td><?php echo $tmp_num; ?></td>
              <td><input type="checkbox" name="to_avails[]" value="<?php echo $availabilities[$i]['availability']; ?>"></td>
            </tr>
           <?php } ?> 
          </tbody>
</table>
    <input type="hidden" name="uuid" value="" />
    <input type="hidden" name="version" value="" />
    <input type="hidden" name="attachment" value="" />
    <input type="hidden" name="item_name" value="" />
    <br>
***Below option for special circumstances only*** e.g. when super contributors delete and re-do activations, after citation amendments.
<br>
<input type="checkbox" name="suppress_dup_chk" value="1" />Override nightly duplication check. 
<p class="text-right"><button type="submit" name="activate_ereading" class="btn btn-primary" tabindex="50">Activate eReading </button></p>

</form>



 

