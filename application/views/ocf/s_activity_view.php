<?php /*?><script type="text/javascript">
$(document).ready(function(){
//hide the child li elements
var browserName=navigator.appName; 

if (browserName!="Microsoft Internet Explorer")  
{
	$('.topic_li li.parent_li > ul > li').hide();
	$('.topic_li li.parent_li:has(ul)').find(' > span').attr('title', 'Expand this');
	
	$('.topic_li li.parent_li > span').on('click',function(e){
			var children = $(this).parent('li.parent_li').find(' > ul > li');
			if (children.is(":visible")) {
				children.hide('fast');
				$(this).attr('title', 'Expand this').find(' > i:first').addClass('fa-plus-circle').removeClass('fa-minus-circle');
			} 
			else if (children.is(":hidden")) {
				children.show('fast');
				$(this).attr('title', 'Collapse this').find(' >i:first').addClass('fa-minus-circle').removeClass('fa-plus-circle');
			}
			e.stopPropagation();
	});
}
});
</script><?php */?>


<?php

echo $activity;
?>