$(document).ready(function() {
	$('.tree .topic_span').on('click', function () 
    {  
		//var value = $(this).find(".activity_input:eq(0)").val();
	
		//var act = getActivities(value);
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
		//var ul_id = '#ul_' + current_id.substr(3);
		
		//var ul_id = '#ul_' + current_id.substr(3, 36);
		//alert(ul_id);
		//var course_code = current_id.substr(40);
		//alert(course_code);
		var temp = current_id.substr(3).split("_");
		$(ul_id).empty();
		
		var topic = getTopic(temp[0], temp[1]);
		alert(topic);
	});
	
	function getTopic(topic_code, course_code)
	{
		var ul_id = "#ul_"+topic_code + "_" + course_code;
		return ul_id;
		//var obj = jQuery.parseJSON( '{ "topic_code": '+topic_code+', "course_code": '+course_code+' }' );
		//alert( obj.topic_code );
		
	}


	function getActivities(v)
	{  
		var data = jQuery.parseJSON(v);
		var url = "maptopics/getActivities";
		for(var act in data)
		{
			var ul_id = "#ul_"+data[1].uuid;
			$( ul_id ).empty();
			var attachmentUuid = data[act].uuid;
			var itemUuid = data[act].itemUuid;
			var itemVersion = parseInt(data[act].itemVersion);
			var topicCode = data[act].topic_code;	
			var keys = [];
			var obj = [];
			
			var posting = $.post( url, 
                    { "attachmentUuid": attachmentUuid,
                      "uuid": itemUuid,
					  "version": itemVersion,
					  "topicCode": topicCode
					}
             );
			posting.done(function(returnData,status ) {
   				$( ul_id ).append( returnData );
   				$( ul_id ).fadeIn(1300);	
			  });
			 posting.fail(function(xhr, status, error) {
                    alert("Error: " + xhr.status + " " + error);
  			});
			
			/*var spinner_selector = ul_id + ' .spinner';
		  $( ul_id ).ajaxStart(function () {
			  $(spinner_selector).fadeIn('fast');
		  }).ajaxStop(function () {
			  $(spinner_selector).stop().fadeOut('fast');
		  });  */      
			
		} 
		// getActivityRecursiveCall($attatchmentUuid, $uuid, $version,$itemresponse, $index, &$keys, &$data, $furtherCall)
	
		 
    	
	}
 
  
 
  //alert(topiccode);
  // Send the data using post
/*  var posting = $.post( url, 
                    { "from_topic_code": from_topic_code,
                      "action_type": action_type}
                    //,function(data,status){
                        //alert("Data: " + data + "\nStatus: " + status);}
                );
 
  // Put the results in a div
  posting.done(function( data,status ) {
    //var content = $( data ).find( "#avails" );
    //alert(data);
    if(data.indexOf("privilege") != -1)
    {
        window.location.href = "reading/notification/noprivilege.html";
        return;
    }
    //alert("1");
    $( "#avails" ).hide();
    $( "#avails" ).empty().append( data );
    $( "#avails" ).fadeIn(1300);
    //alert("2");
  });
  
  posting.fail(function(xhr, status, error) {
                    alert("Error: " + xhr.status + " " + error);
                    //alert(error);
                    //alert(xhr.responseText);
  });	}*/
 });

