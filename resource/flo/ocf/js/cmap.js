$(document).ready(function() {
	$('.tree .topic_span').on('click', function () 
    {  
		/*if($(this).find(' > i').hasClass('fa-plus-circle'))
		{
			$(this).attr('title', 'Collapse this');
			$(this).find(' > i').addClass('fa-minus-circle').removeClass('fa-plus-circle');
		}
*/		var value = $(this).find(".activity_input:eq(0)").val();
		var obj = $(this).attr('href');
		var act = getActivities(value, obj);
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
	
	$('.tree .refresh_icon').on('click', function () 
    { 
		if($(this).prev("span").find(' > i').hasClass('fa-minus-circle'))
		{
			$(this).attr('title', '');
			$(this).prev("span").find(' > i').addClass('fa-plus-circle').removeClass('fa-minus-circle');
		}
		var current_id = $(this).attr('id');
		var ul_id = '#ul_' + current_id.substr(3);
		/*
		var ul_id = '#ul_' + current_id.substr(3, 36);
		alert(ul_id);
		var course_code = current_id.substr(40);
		alert(course_code);
		*/
		$(ul_id).empty();
		var value = $(this).prev("span").find(".activity_input:eq(0)").val();
		var act = getActivities(value);
	});




	function getActivities(v, obj)
	{  
		var data = jQuery.parseJSON(v);
		var courseCode = data[1].course_code;
		//var url = "getActivities";
		
		//alert(url);
		var ul_id = "#ul_"+data[1].uuid + "_" + courseCode;
		var rf_id = "#rf_"+data[1].uuid + "_" + courseCode;
		/*for(var act in data)
		{
			//$( ul_id ).empty();
			var attachmentUuid = data[act].uuid;
			var itemUuid = data[act].itemUuid;
			var itemVersion = parseInt(data[act].itemVersion);
			var topicCode = data[act].topic_code;*/
			var posting = $.post( "../getActivities", 
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
				if($( ul_id ).prev().prev('span').find(' > i').hasClass('fa-plus-circle'))
				{
					$( ul_id ).prev().prev('span').attr('title', 'Collapse this');
					$( ul_id ).prev().prev('span').find(' > i').addClass('fa-minus-circle').removeClass('fa-plus-circle');
				}
   				$( ul_id ).append( returnData );
   				$( ul_id ).fadeIn('slow');	
				$( rf_id ).fadeIn('slow');	
				//$("#spinner").fadeOut('slow');
				
				$(".spinner-wave").fadeOut('slow');
			  });
			  
			 posting.fail(function(xhr, status, error) {
                    alert("Error: " + xhr.status + " " + error);
					//$("#spinner").fadeOut('slow');
					$(".spinner-wave").fadeOut('slow');
					$( rf_id ).fadeIn('slow');
  			});
		
		//} 
		return true;
	}
	
 });
