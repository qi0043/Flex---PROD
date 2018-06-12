<?php


switch ($_SERVER['SERVER_NAME']) {


    case "flextra.flinders.edu.au":
    
        $flexserv = "https://flex.flinders.edu.au";
        break;

    case "flextra-test.flinders.edu.au":
    
        $flexserv = "https://flex-test.flinders.edu.au";
        break;


    case "flextra-dev.flinders.edu.au":
    
        $flexserv = "https://flex-dev.flinders.edu.au";
        break;

}



?>

<script type="text/javascript">


$(document).ready(function() {
	
  $('#updatethis').click(function() {

	var updateURL = "<?php echo base_url() . 'ocf/update/' . $item['uuid'] . "/" . $item['version'] ;?>";
	var updateName = $('#itemname').val();
	
	//alert(updateName);
	
	$('#myModalLabel').html('<span class="text-muted">Saving new name… </span><i class="fa fa-spinner fa-spin fa-fw text-muted"></i>');
	
	 $.post(updateURL,
    {
        name: updateName
      
    },
    function(data, status){
        //console.log("Data:\n" + data + "\nStatus:\n" + status);
		
		 $('#myModalLabel').html(data);
    });
		//$('#changeName').removeClass( "disabled" );  
		
		});


});


</script>


    <h4 class="modal-title" id="myModalLabel">
    
    
    
    <form>
        <div class="input-group col-md-10">
       <span class="input-group-addon"><strong>Edit this <i class="fa fa-hand-o-right "></i></strong>
</span>
      <input name="itemname" type="text" class="form-control" id="itemname" value="<?php echo $item['name']; ?>" />
      <span class="input-group-btn">
      <button type="button" class="btn btn-success" id="updatethis">Save</button>
      </span>

    </div><!-- /input-group -->
    </form>
  
    </h4>
