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
		
		$('<div class="alert alert-success alert-dissmissable small" role="alert" id="updateComplete"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><p><strong>Update Complete!</strong> Please note that the title change will not be reflected in the activity list until the nightly update is run</p></div>').insertBefore('#itemdescription');
	
		
		 });



</script>



    <h4 class="modal-title" id="myModalLabel"><!--<i class="fa fa-file-o fa-fw"></i> --><?php echo $item['name']; ?></h4>
