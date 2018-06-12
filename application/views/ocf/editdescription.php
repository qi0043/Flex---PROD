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
	
  $('#updatethis').click(function(e) {

	e.preventDefault();
	
	var updateURL = "<?php echo base_url() . 'ocf/updatedescription/' . $item['uuid'] . "/" . $item['version'] ;?>";
	var updateDescription = $('#theDescription').val();
	
	//alert(updateDescription);
	
	$('#itemDescription').html('<span class="text-muted">Saving updated description… </span><i class="fa fa-spinner fa-spin fa-fw text-muted"></i>');
	
	 $.post(updateURL,
    {
        theDescription: updateDescription
      
    },
    function(data, status){
        //console.log("Data:\n" + data + "\nStatus:\n" + status);
		
		 $('#itemDescription').html(data);
    });
		//$('#changeName').removeClass( "disabled" );  
		
		});


});


</script>



    
    
    
 
<div class="alert alert-warning small" role="alert" id="plainText">
  <p><strong>Plain text only!</strong> Formatted text cannot be use here. Do not paste from MS Word or PDF documents.</p></div>

    <textarea name="theDescription" rows="4" class="form-control" id="theDescription" style="resize:none;" ><?php echo $item['itemDescription']; ?></textarea>

      <button type="button" class="btn btn-sm btn-success btn-block" id="updatethis"><i class="fa fa-check-square-o"></i>&nbsp;Save description</button>
<div style="height:5px;"></div>
    
    





  
    
