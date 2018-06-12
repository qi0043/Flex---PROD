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
		
		$('<div class="alert alert-success alert-dissmissable small" role="alert" id="updateComplete"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><p><strong>Update Complete!</strong> This change will be reflected in the curriculum browser after running the topic refresh function (click the "Topic Refresh" button&nbsp;<i class="fa fa-refresh"></i> adjacent to the topic link)</p></div>').insertBefore('#itemdetail');
	
		
		 });



</script>



    <h4 class="modal-title" id="myModalLabel"><!--<i class="fa fa-file-o fa-fw"></i> --><?php echo $item['name']; ?></h4>
