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

  /*
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
 */
 
 $(function() {

      $( "[name^=next_step1]" )
      .button()
      .click(function( ) {
        show_step("Next");
      });
    });
    
 $(function() {   
     //$("#home_link").attr("href","home.html?topic_code="+"<?php echo $topic_code; ?>");  
 });

</script>
        
<h2>Select target lists <span class="text-info">to copy to</span></h2>
<?php if($topic_name != false) {?>
<p><i>Topic:&nbsp;<?php echo $topic_name;?></i></p>
<?php }?>

<br />
<form id="create_request_form" action="create_request" method="post" >
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
              <td><input type="checkbox" name="avails_for_new_req[]" value="<?php echo $availabilities[$i]['availability']; ?>"></td>
            </tr>
           <?php } ?> 
          </tbody>
</table>
</form>
<p class="text-right"><button type="button" name="next_step1" class="btn btn-primary" tabindex="50">Next step >> </button></p>

<p class="text-muted"><i>If topic availabilites are used in shared FLO sites, please check if the eReading lists need to be the same.</i></p>



 

