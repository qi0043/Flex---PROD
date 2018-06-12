$(document).ready(function() {
	$('.tree li ul > li').hide();
	$('.tree li .theYear').show();
	$('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Expand this');
	
	/*$('.tree .topic_span').on('click', function () 
    {   
		$(this).off();
		$(this).click(function (e) {
			var children = $(this).parent('li.parent_li').find(' > ul');
			if (children.is(":visible")) {
				children.hide('fast');
				$(this).attr('title', 'Expand this').find(' > i:first').addClass('fa-plus-circle').removeClass('fa-minus-circle');
			} 
			else {
				children.show('fast');
				$(this).attr('title', 'Collapse this').find(' > i:first').addClass('fa-minus-circle').removeClass('fa-plus-circle');
			}
				e.stopPropagation();
		});
	});*/
	
	$(document).on('click', 'li.parent_li > span', function (e) {
	
		var children = $(this).parent('li.parent_li').find(' > ul > li');
		if (children.is(":visible")) {
			children.hide("fast");
			$(this).attr("title", "Expand this").find(" > i:first").addClass("fa-plus-circle").removeClass("fa-minus-circle");
		} 
		else if (children.is(":hidden")) {
			children.show("fast");
			$(this).attr("title", "Collapse this").find(" > i:first").addClass("fa-minus-circle").removeClass("fa-plus-circle");
		}
		e.stopPropagation();
		
	});
	
	/************ AJAX call for refresh icon ***************/
	
	$('.tree .refresh_icon').on('click', function () 
    { 
		if($(this).prev("span").find(' > i:first').hasClass('fa-minus-circle'))
		{
			$(this).attr('title', '');
			$(this).prev("span").find(' > i:first').addClass('fa-plus-circle').removeClass('fa-minus-circle');
		}
		
		var current_id = $(this).attr('id');
		var ul_id = '#ul_' + current_id.substr(3);
		var temp = current_id.substr(3).split("_");
		$(ul_id).empty();
		
		var topic = getTopic(temp[0], temp[1], temp[2], temp[3]);
	});
	
	function getTopic(item_uuid, item_version, topic_code, course_code)
	{
		var ul_id = "#ul_"+ item_uuid + "_" + item_version + "_" + topic_code + "_" + course_code;
		var obj = {
			'topic_code': topic_code,
			'course_code':course_code
		};
		
		var posting = $.post( "../getSingleTopic", 
							{"topic": obj}
        ); 
	   
		posting.done(function(returnData,status ) {
			//alert(returnData);
			if($( ul_id ).prev().prev('span').find(' > i:first').hasClass('fa-plus-circle'))
			{
				$( ul_id ).prev().prev('span').attr('title', 'Collapse this');
				$( ul_id ).prev().prev('span').find(' > i:first').addClass('fa-minus-circle').removeClass('fa-plus-circle');
			}
			$( ul_id ).append( returnData );
			$( ul_id ).fadeIn('slow');	
			
			var hideli = ul_id + ' li.parent_li > ul > li';
			$( hideli).hide();
			var hasul = ul_id + ' li.parent_li:has(ul)';
			$( hasul).find(' > span').attr('title', 'Expand this');
			
		  });
		 posting.fail(function(xhr, status, error) {
				alert("Error: " + xhr.status + " " + error);
				//$("#spinner").fadeOut('slow');
				$(".spinner-wave").fadeOut('slow');
				$( rf_id ).fadeIn('slow');
		});
		return true;
	}
	
     /************ AJAX call for reload icon ***************/
	$('.tree .reload_icon').on('click', function () 
    { 
	   
		if($(this).prev("span").find(' > i:first').hasClass('fa-minus-circle'))
		{
			$(this).attr('title', '');
			$(this).prev("span").find(' > i:first').addClass('fa-plus-circle').removeClass('fa-minus-circle');
		}
		
		var current_id = $(this).attr('id');
		
		var ul_id = '#ul_' + current_id.substr(3);
		
		var temp = current_id.substr(3).split("_");
		
		$(ul_id).empty();
		
		//var topic = getTopic(temp[0], temp[1], ul_id);
		var acts = getActs(temp[0], temp[1], temp[2], temp[3]);
	});
	
	function getActs(item_uuid, item_version, topic_code, course_code)
	{
		var ul_id = "#ul_"+ item_uuid + "_" + item_version + "_" + topic_code + "_" + course_code;
	    //alert(ul_id);
		var obj = {
			'uuid': item_uuid,
			'version': item_version,
			'topic_code': topic_code,
			'course_code':course_code
		};
		
		var posting = $.post( "../reload", 
							{"topic": obj}
        );
		$(".spinner-wave").show();
		posting.done(function(returnData,status ) {
			//alert(returnData);
			if($( ul_id ).prev().prev('span').find(' > i:first').hasClass('fa-plus-circle'))
			{
				$( ul_id ).prev().prev('span').attr('title', 'Collapse this');
				$( ul_id ).prev().prev('span').find(' > i:first').addClass('fa-minus-circle').removeClass('fa-plus-circle');
			}
			
			//var ul_parent = $( ul_id ).parent();
			//$(ul_id).parent().empty();
			//ul_parent.append( returnData );
			$( ul_id ).append( returnData );
			$( ul_id ).fadeIn('slow');	
			
			var hideli = ul_id + ' li.parent_li > ul > li';
			$( hideli).hide();
			var hasul = ul_id + ' li.parent_li:has(ul)';
			$( hasul).find(' > span').attr('title', 'Expand this');
			
			$(".spinner-wave").fadeOut('slow');
			
		  });
		 posting.fail(function(xhr, status, error) {
				alert("Error: " + xhr.status + " " + error);
				$(".spinner-wave").fadeOut('slow');
		});
		return true;
		
	}
	
	
	
	
	
 });

