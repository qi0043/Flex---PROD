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
	

	
		$('#changeName').removeClass("disabled");
		$('#editDescription').removeClass("disabled");
		$('#editItem').removeClass("disabled");
		
		
		
		
		
		$('<div class="alert alert-success alert-dissmissable small" role="alert" id="editComplete"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><p><strong>Update Complete!</strong></p></div>').insertBefore('#itemdetail');
	
		
		 });



</script>



    <p><?php echo $item['description']; ?></p>
