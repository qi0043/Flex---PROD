<?php
include 'header.php';
?>

  <script>
    $(function(){
      $body = $("body");
      $(document).on({
        ajaxStart: function() { $("#display_toavails_btn").button('loading');//$body.addClass("loading");    
        },
         ajaxStop: function() { $("#display_toavails_btn").button('reset');//$body.removeClass("loading"); 
         }    
      });
    });
  </script>
  <script>
    $(function() {
        //$("#to_topic_code").val("<?php #echo($from_topic_code);?>");
        //$("#to_topic_code").select();
        $("#to_topic_code").focus();
        $("#header_level_2_txt").html("Activate one eReading for topic availabilities");
        $("#display_toavails_btn").click(function(){gettoavails();});
        //$("#display_toavails_btn").click();
    });
    
    $(function() {
        $("#to_topic_code").on("keypress", function(e) {    
            if (e.keyCode == 13) {
                $("#display_toavails_btn").click();
             return false;
            }
        });
    });

    function gettoavails(){

      var topic_code = $.trim($("#to_topic_code").val());
      //var to_topic_code = $.trim($("#to_topic_code").val());
      var url = "activate_reading_get_avails";

      if(topic_code.length <= 0){
        alert("Please enter topic code.");
        return false;
      }

      var posting = $.post( url, 
                        { "topic_code": topic_code}
                        //,function(data,status){
                            //alert("Data: " + data + "\nStatus: " + status);}
                    );

      // Put the results in a div
      posting.done(function( data,status ) {
        //var content = $( data ).find( "#avails" );
        if(data.indexOf("privilege") != -1)
        {
            window.location.href = "reading/notification/noprivilege.html";
            return;
        }
        //console.log(data);
        $( "#to_avails1" ).hide();
        $( "#to_avails1" ).empty().append( data );
        $( "#to_avails1" ).fadeIn(1300);
        //alert("2");
      });

      posting.fail(function(xhr, status, error) {
                        alert("Error: " + xhr.status + " " + error);
                        //alert(error);
                        //alert(xhr.responseText);
      });

    //});
    }
  </script>

<div class="page-header" style="background-color:#EEE">
  <div class="container" >
    <div class="row">
      <div class="col-md-12"> <br /><br />
        <b>Activate eReading: <?php echo $item_name?></b>
            <br><a target="_blank" href="<?php echo $reading_link;?>"><?php echo $reading_link;?></a>
        <br /><br />
      </div>
    </div>
  <div id="view_req_nav" class="row ">
      <div role="navigation"> 
        <!-- For current step display: btn btn-success disabled AND >> before the next step  --> 
        <!-- For previous step display: btn btn-success AND tick before the next step  --> 
        <!-- For following steps display: btn btn-default AND >> before the next step  -->
        
        <div id="view_er_step1">
          <div class="col-md-2"> <a href="" class="btn btn-success disabled  btn-block" tabindex="100">1. <span class="hidden-md">Select & activate</span><span class="visible-md-inline">Select & activate</span></a> </div>
          <div class="col-md-1">
            <p class="text-center lead hidden-xs hidden-sm" > >> </p>
            <!--<p class="text-success lead hidden-xs hidden-sm" style="color:#5cb85c;"><span class="glyphicon glyphicon-ok"></span></p>--> 
          </div>
        </div>
        <div id="view_er_step2">
          <div class="col-md-2"> <a href="" class="btn btn-default disabled  btn-block" tabindex="100">2. View results</a> </div>
          <div class="col-md-4"> 
            <!-- needed to keep height -->
            <p class="text-center lead hidden-xs hidden-sm">&nbsp; </p>
          </div>

        </div>
      </div>
  </div>
 </div>
 </div>
 
  <div class="container">
  <div class="row">
    <form action="">
      <div class="col-md-6">
        <h2>Search topics</h2>
        <br />
        <div class="input-group">
          <input id="to_topic_code" name="to_topic_code" class="form-control" type="text" placeholder="Enter Topic Code" autofocus tabindex="1" autocomplete="on" value="">
          <span class="input-group-btn">
          <button id="display_toavails_btn" type="button" class="btn btn-primary" tabindex="2" >Submit</button>
          </span> 
        </div>
        <br />
        <br />
      <div id="to_avails1">
      </div>
      </div>
      <input type="hidden" id="theuuid" value="<?php echo $uuid;?>" />
      <input type="hidden" id="theversion" value="<?php echo $version;?>" />
      <input type="hidden" id="theattachment" value="<?php echo $attachment;?>" />
      <input type="hidden" id="theitemname" value="<?php echo htmlentities($item_name);?>" />
    </form>
    <div class="col-md-2"> 
      <!--  Visual breath :-)   --> 
    </div>
    <div class="col-md-4">
      <h3>Note</h3>
      <p>This page is for Advanced Contributor only.</p>
      <p>If you activate(add) one eReading to a list today you will <span class="text-danger">not be able to copy it from that list</span> to another list today. </p>
      <p>If activation fails because of HTTP connection issue you could try the activation again.</p>

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
  

<?php
include 'footer.php';
?>

