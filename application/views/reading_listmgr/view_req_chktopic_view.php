<?php
include 'header.php';

?>

<script>
$(function(){
  $body = $("body");
  $(document).on({
    ajaxStart: function() { $("#request_mgt_btn").button('loading');//$body.addClass("loading");    
    },
     ajaxStop: function() { $("#request_mgt_btn").button('reset');//$body.removeClass("loading"); 
     }    
  });
});

  $("#header_level_2_txt").html("View requests");
</script>

<script src="<?php echo base_url() . 'resource/listmgr/';?>js/chktopics.js" type="text/javascript"></script>

<script>
<?php if(!isset($topic_code)){ ?>
$(document).ready(function(){$("#from_topic_code").focus();});
<?php } ?>
</script>

<?php if(isset($topic_code) && isset($view_type)){ ?>
<script>
    <?php if($view_type == 'EREADING'){ ?>
        $(function() {$("#display_avails_btn").click();});
    <?php } ?>
    <?php if($view_type == 'REQUEST'){ ?>
        $(function() {$("#request_mgt_btn").click();});
    <?php } ?>    
</script>
<?php } ?>

<input type="hidden" id="action_type" value="view_req"/>

<div class="page-header" style="background-color:#EEE">
  <div class="container" >
    <div class="row">
      <div class="col-md-12"> <br />
        <h1 id="view_er_step_titile">Step 1: Select list</h1>
        <br />
      </div>
    </div>
  <div id="view_req_nav" class="row ">
      <div role="navigation"> 
        <!-- For current step display: btn btn-success disabled AND >> before the next step  --> 
        <!-- For previous step display: btn btn-success AND tick before the next step  --> 
        <!-- For following steps display: btn btn-default AND >> before the next step  -->
        <div id="view_er_step1">
          <div class="col-md-2"> <a href="" class="btn btn-success disabled btn-block"  tabindex="100">1. <span class="hidden-md">Select list</span><span class="visible-md-inline">Select list</span></a> </div>
          <div class="col-md-1"> 
            <p class="text-center lead hidden-xs hidden-sm" > >> </p>
            <!--<p class="text-success lead hidden-xs hidden-sm" style="color:#5cb85c;"><span class="glyphicon glyphicon-ok"></span></p>-->
          </div>
        </div>
        <div id="view_er_step2">
          <div class="col-md-2"> <a href="" class="btn btn-default disabled  btn-block" tabindex="100">2. <span class="hidden-md">View requests</span><span class="visible-md-inline">View requests</span></a> </div>
          <div class="col-md-1">
            <p class="text-center lead hidden-xs hidden-sm" >  </p>
            <!--<p class="text-success lead hidden-xs hidden-sm" style="color:#5cb85c;"><span class="glyphicon glyphicon-ok"></span></p>--> 
          </div>
        </div>
        
      </div>
  </div>
 </div>
 </div>

<div class="container">
  <div class="row">
    
      <div class="col-md-6">
        <h2>Search topics</h2>
        <br />
        <div class="input-group">
          <input id="from_topic_code" name="from_topic_code" class="form-control" type="text" placeholder="Enter Topic Code" autofocus tabindex="1" autocomplete="on" value="<?php if(isset($topic_code)) echo $topic_code; ?>">
          <span class="input-group-btn">
          <button id="request_mgt_btn" type="button" class="btn btn-primary" tabindex="2" >Submit</button>
          </span> 
        </div>
        <br />
        <br />
      <div id="avails">
        
        
      </div>
      </div>
    
    <div class="col-md-2"> 
      <!--  Visual breath :-)   --> 
    </div>
    <div class="col-md-4">
      <h3>About requests</h3>
      <p>Making a request is similar to sending an email.
        When you make a request through this system it is sent to the <a href="mailto:eReserve@flinders.edu.au">Learning Access Team</a> for action. </p>
      <p>Requests are logged by the system so you can view a previous request and check its status. </p>
      <p>You need to make a request to:</p>
      <ul>
        <li>Add new eReadings to FLEX</li>
        <li>Remove eReadings from a list.</li>
      </ul>
      <p>You can request any type of list changes and complete list creation.</p>
      <h3>Navigation</h3>
      <p>To go back tp previous steps use the green buttons at the top of the page: </p>
      <ul>
        <li>A completed step is shown with a <span style="color:#5cb85c;"><span class="glyphicon glyphicon-ok"></span></span></li>
      </ul>
      <p>The home link at the very top of the page: </p>
      <ul>
        <li><span class="glyphicon glyphicon-home"></span> eReadings List Management.</li>
      </ul>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12"> 
      <!-- not in use--> 
    </div>
  </div>
</div>


<?php
include 'footer.php';
?>