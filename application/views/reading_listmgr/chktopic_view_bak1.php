<?php
include 'header.php';
?>

<!-- progressbar -->
<!--
	<ul id="progressbar">
		<li class="active">Select From topic</li>
		<li>Select eReadings</li>
		<li>Select To topics</li>
                <li>Start rollover</li>
	</ul>



<style>
/*progressbar*/
#progressbar {
	margin-bottom: 30px;
	overflow: hidden;
	/*CSS counters to number the steps*/
	counter-reset: step;
}
#progressbar li {
	list-style-type: none;
	color: brown;
	text-transform: uppercase;
	font-size: 9px;
	width: 20%;
	float: left;
	position: relative;
}
#progressbar li:before {
	content: counter(step);
	counter-increment: step;
	width: 20px;
	line-height: 20px;
	display: block;
	font-size: 10px;
	color: red;/*#333;*/
	background: brown;
	border-radius: 5px;
	margin: 0 auto 5px auto;
}
/*progressbar connectors*/
#progressbar li:after {
	content: '';
	width: 100%;
	height: 2px;
	background: brown;
	position: absolute;
	left: -50%;
	top: 9px;
	z-index: -1; /*put it behind the numbers*/
}
#progressbar li:first-child:after {
	/*connector not needed before the first step*/
	content: none; 
}
/*marking active/completed steps green*/
/*The number of the step and the connector before it = green*/
#progressbar li.active:before,  #progressbar li.active:after{
	background: #27AE60;
	color: brown;
}

</style>
-->
<!--
<script>
  $(function() {
    $( "#menu" ).menu();
  });
</script>
<style>
.ui-menu {
    width: 160px;
  }
</style>

<div style="float:left; margin: 10px 30px;">
<ul id="menu">
  <li>eReadings Rollover</li>
  <li>View/Update Requests to Librarians</li>
  <li>Create New request to Librarians</li>
  <li>Help
</ul>
</div>
-->
<style>
/* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   speak for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
.modal {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .2 ) 
                url('<?php echo base_url() . 'resource/listmgr/';?>images/loading.gif') 
                50% 50% 
                no-repeat;
}

/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading {
    overflow: hidden;   
}

/* Anytime the body has the loading class, our
   modal element will be visible */
body.loading .modal {
    display: block;
}
</style>

<script>
$(function(){
  $body = $("body");
  $(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
  });
});
</script>

<script src="<?php echo base_url() . 'resource/listmgr/';?>js/chktopics.js" type="text/javascript"></script>

<br>
<!--
<nav class="navbar navbar-default" role="navigation">
<form class="navbar-form navbar-left" role="search">
  <div class="form-group">
    <input type="text" class="form-control" placeholder="Topic Code">
  </div>
  <button type="submit" class="btn btn-default">View/Rollover eReadings</button>
</form>
</nav>
-->

<form id="topicForm" method="post" action="get_from_availabilities" autocomplete="on">

<div class="breadcrumbs">
          
  <span typeof="v:Breadcrumb"><b>eReading List Management</b></span>
  
</div>

<br>
Please enter Topic code (e.g. AGES8022) below to display availabilities and eReading lists.
<br>
<table>
    
    <tr >
        <td >Topic Code:</td>
    </tr>
    <tr>
        <td><input id="from_topic_code" name="from_topic_code" type="text" tabindex="1" autocomplete="on" ></td>
    </tr>
</table>                                    

<br>

<button type="submit" id="display_avails_btn" class="btn btn-default">View/Rollover eReadings</button>
&nbsp;&nbsp;
<button type="button" id="request_mgt_btn" class="btn btn-default">List Change Request</button>
&nbsp;&nbsp;
<button type="reset" onclick='javascript: $("#from_topic_code").focus();' class="btn btn-default">Reset</button>
<br>
<br>

</form>

<div id="avails">
    
</div>

<br>
<br>
    <p style="color:blue">Please note:</p> 
    <ul>
        <li>This system will only rollover eReadings activated <b>before today</b>.</li>
        <li>Do not use this system between midnight and 5AM as this is the system maintenence period.</li>
        <li>If rollover fails because of HTTP connection issue you could try the rollover again. </li>
        <li>For any issue you could contact: <a href="mailto:flex.help@flinders.edu.au?Subject=Flextra%20rollover%20tool%20query">flex.help@flinders.edu.au</a></li>
    </ul>

<div class="modal"><!-- Place at bottom of page --></div>

<!--
<script>

$(function(){$('.progress-bar').css('width', 90+'%').prop('aria-valuenow', '90').html('90%');});
</script>

<div class="progress">
  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 30%;">
    30%
  </div>
</div>
-->

<?php

include 'footer.php';

?>