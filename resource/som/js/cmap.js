$(document).ready(function() {
	$('.tree .topic_span').on('click', function () 
    {  
		var value = $(this).find(".activity_input:eq(0)").val();
	
		var act = getActivities(value);
		$(this).off();
		
		$(this).click(function (e) {
			var children = $(this).parent('li.parent_li').find(' > ul');
			if (children.is(":visible")) {
				children.hide('fast');
				$(this).attr('title', 'Expand this').find(' > i').addClass('fa-plus-circle').removeClass('fa-minus-circle');
			} 
			else {
				children.show('fast');
				$(this).attr('title', 'Collapse this').find(' > i').addClass('fa-minus-circle').removeClass('fa-plus-circle');
			}
				e.stopPropagation();
		});
	});


	function getActivities(v)
	{  
		var data = jQuery.parseJSON(v);
		var url = "maptest/getActivities";
		var ul_id = "#ul_"+data[1].uuid;
		/*for(var act in data)
		{
			//$( ul_id ).empty();
			var attachmentUuid = data[act].uuid;
			var itemUuid = data[act].itemUuid;
			var itemVersion = parseInt(data[act].itemVersion);
			var topicCode = data[act].topic_code;*/
			var posting = $.post( url, 
							{"activities": data}
							
                    /*{ "attachmentUuid": attachmentUuid,
                      "uuid": itemUuid,
					  "version": itemVersion,
					  "topicCode": topicCode
					}*/
             ); 
			$(".spinner-wave").show();
			//$("#spinner").show();
			posting.done(function(returnData,status ) {
   				$( ul_id ).append( returnData );
   				$( ul_id ).fadeIn('fast');	
				//$("#spinner").fadeOut('slow');
				$(".spinner-wave").fadeOut('slow');
			  });
			 posting.fail(function(xhr, status, error) {
                    alert("Error: " + xhr.status + " " + error);
					//$("#spinner").fadeOut('slow');
					$(".spinner-wave").fadeOut('slow');
  			});
		
		//} 
		return true;
	}
	
 });
