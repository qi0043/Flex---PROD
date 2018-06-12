<?php
include 'header.php';

include 'rollover_nav.php'
?>

<script>
$(function(){
  $body = $("body");
  $(document).on({
    ajaxStart: function() { $("#display_avails_btn").button('loading');//$body.addClass("loading");    
    },
     ajaxStop: function() { $("#display_avails_btn").button('reset');//$body.removeClass("loading"); 
     }    
  });
});

  $("#header_level_2_txt").html("Rollover eReadings");
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


<input type="hidden" id="action_type" value="rollover_er"/>

<div class="container">
  <div class="row">
    
      <div class="col-md-6">
        <h2>Search topics</h2>
        <br />
        <div class="input-group">
          <input id="from_topic_code" name="from_topic_code" class="form-control" type="text" placeholder="Enter Topic Code" autofocus tabindex="1" autocomplete="on" value="<?php if(isset($topic_code)) echo $topic_code; ?>">
          <span class="input-group-btn">
          <button id="display_avails_btn" type="button" class="btn btn-primary" tabindex="2" >Submit</button>
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
      <h3>About rollovers</h3>
      <p>eReading lists displayed on this site contain eReadings added:</p>
      <ul>
        <li>Before today</li>
        <li>Today via this site</li>
      </ul>
      <p>If you rollover eReadings to a list today you will <span class="text-danger">not be able to copy them from that list</span> to another list. You can still copy them from the original list.</p>
      <p>You will need to <em>make a request</em> to:</p>
      <ul>
        <li>Add new eReadings that do not appear on an existing list</li>
        <li>Remove eReadings
      </ul>

      <h3>Navigation</h3>
      <p>To go back to previous steps use the green buttons at the top of the page: </p>
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



<div class="modal"><!-- Place at bottom of page --></div>

<?php
include 'footer.php';
?>