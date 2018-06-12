<?php

include 'header.php';
include 'rollover_nav.php';

if($ereadings === false)
    $readings_count = 0;
else
    $readings_count = count($ereadings);
#$count = $readings_count; 
$toavail_count = count($to_avails);
if($readings_count>0)
{
$access_from = $ereadings[0]['access_from'];
$access_from = substr($access_from, 0, strpos($access_from, ' '));
$access_to = $ereadings[0]['access_to'];
$access_to = substr($access_to, 0, strpos($access_to, ' '));
}
?>

<script src="<?php echo base_url() . 'resource/listmgr/';?>js/ereadings.js" type="text/javascript"></script>

<br>

<script>
/*    
$(function() {
<?php #if($topic_for_new_list==null) { ?>    
    total_steps = total_steps_rollover;
    for(i=0;i<total_steps;i++)
    {
        nav_steps[i][0] = nav_steps_rollover[i][0];
        nav_steps[i][1] = nav_steps_rollover[i][1];
    }
<?php #} else { ?> 
    total_steps = total_steps_newlist;
    for(i=0;i<total_steps;i++)
    {
        nav_steps[i][0] = nav_steps_newlist[i][0];
        nav_steps[i][1] = nav_steps_newlist[i][1];
    }
<?php #} ?> 
build_nav_steps_title();
});
*/
</script>


<style>
.tooltip-inner {
    text-align:left !important;
    white-space:pre;
    max-width:none;
}

body{
    font-size: 13px;
}
</style>

<div id="sel_ereadings" style="display:inline">

<script>
    //var tooltip_open=false;
    $(function() {
        //$( "#aaa" ).tooltip( "option", "content", "Awesome title!" );
       //$( "a[id^=usage]" ).tooltip({ items: "a" });
       //tooltips = $( "a[id^=usage]" ).tooltip('show');
  });
  $(function() {
      $("a[id^=usage]").prop('name', 'hide');
      $( "a[id^=usage]" )
      .click(function( ) {
       if($(this).prop('name') == 'hide')
       {
          $( this ).tooltip("show");
          $(this).prop('name','show');
       }
       else
       {
          $( this ).tooltip("hide");
          $(this).prop('name', 'hide');
       }
      });
    });
</script>

<script>
/*    $(function() {   
     $( "[name^=backto_avails]" )
      .button()
      .click(function( ) {
        window.location.href = "chktopic?topic_code=<?php echo $from_topic_code;?>&view_type=ereading";
      });
     
    });*/
</script>

<script>
    $(function() { 
     $("#header_level_2_txt").html("Rollover eReadings");
     a1 = $("#rollover_nav #rollover_step1 div a");
     a1.prop("href", 'rollover_er_chktopic?topic_code=<?php echo $from_topic_code;?>&view_type=ereading');
     //a2 = $("#rollover_nav #rollover_step2 div a");
     //a2.prop("href", 'javascript:show_any_pre_step(0);');
     //a3 = $("#rollover_nav #rollover_step3 div a");
     //a3.prop("href", 'javascript:show_any_pre_step(1);');
    });
    
</script>


<div class="container">
<div class="row">
<div class="col-md-4">
  <h2>eReadings table</h2>
  <p>List for: <b><?php echo $from_avail; ?></b></p>
  <ul>
    <li>Teaching period: <?php if($ereadings != false && isset($access_from)) echo $access_from . ' to '. $access_to;?></li>
    <li>No. of students: <?php echo $avail_info["num_students"]; ?></li>
    <li>No. of eReadings for rollover: <?php echo($readings_count);?></li>
   </ul>
  <p><i>Each eReading is viewable via its link.</i></p>
   <?php if($num_rollover_ereadings>0){?>
    <p class="text-danger">
        This list has <?php echo($num_rollover_ereadings);?> eReadings that were copied (rollover) to this list today. They cannot be processed by the system.
    </p>
   <?php } ?>
  
</div>
<div class="col-md-4">
      <h3>Help</h3>
      <p>To select eReadings:</p>
      <ul>
        <li>Click <b>anywhere in a row</b> except links OR</li>
        <li>Use the <i>Select all</i> button</li>
      </ul>
      <p>If an eReading is displayed with light yellow background and the check box is disabled, it means the eReading is superseded and can not be rolled over to other lists.
      </p>    
      <p>When you have finished click the <b>Next step >></b></span> button below
      </p>
      <p>To select a different list use the green button: <br />
        <b>1. Select existing list</b>.
        </li>
      </p>
    </div>
    <div class="col-md-4">
      <div class="hidden-xs hidden-sm">
        <h3>Usage data</h3>
        <p>While you can see how often each eReading was accessed during the teaching period, this may not be specific to this list &ndash; the eReading may have been on another list with an overlapping teaching period. </p>
        <ul>
          <li>Hover over a usage number for more info.</li>
        </ul>
        <p class="text-danger">Data collection commenced:</p>
        <ul>
          <li>16 Aug 2013 - link name ending with '.pdf'</li>
          <li>10 Feb 2014 - all eReadings</li>
        </ul>
      </div>
    </div>
    
</div>
<?php if ($readings_count > 0){ ?>   
<div class="row">
  <div class="col-md-4"> <br />
    <!--<div class="btn-group">-->
    <button type="button" name="selectall" class="btn btn-primary" tabindex="1">Select all</button>
    <button type="button" name="unselectall" class="btn btn-primary" tabindex="2">Deselect all</button>
    <!--</div>--> 
  </div>
  <div class="col-md-4"> <br />
    <button type="button" name="next_step" class="btn btn-primary" tabindex="10" >Next step >> </button> </div>
  <div class="col-md-4"> 
    <!-- not in use --> 
  </div>
</div>
<?php }?>
<div class="row">
  <div class="col-md-12">
    <table id="ereading_table" class="table table-hover">
    <?php if ($readings_count > 0){ ?>
    <thead>
    <th></th>
    <th></th>
    <th>eReading</th>
    <th>Notes for students</th>
    <th>Usage</th>
    <?php if($is_tc == false){?>
    <th>Status</th>
    <?php }?>
    <th>Library notes</th>
    </thead>
    <?php }?>
    <?php for($i=0;$i<$readings_count;$i++){ ?>
    <tr <?php if($ereadings[$i]['reading_status']!='live') echo "style='background-color: lightyellow'"; else echo(($i%2==0) ? "class='even'" : "class='odd'"); ?> >
        <?php $usage_info = 'Total no. of times accessed: ' . $ereadings[$i]['usg_total'] . '<br>' . 
                'Unique users: [' . $ereadings[$i]['usg_unique_users'] . ']<br>' . 
                'Topic availabilities:' . '<br>' . str_replace(",", "<br>", $ereadings[$i]['usg_avails']); ?>
        <script>
            $(function() {
              $("#usage<?php echo $i; ?>")
                //.tooltip('hide')
                .tooltip({html:true})
                .attr('data-original-title', "<?php echo $usage_info; ?>")
                .tooltip('fixTitle');
                
            });
        </script>
        <td><input type="checkbox" name="select_reading[]" value="" <?php if($ereadings[$i]['reading_status']!='live') echo ' disabled';?> ></td>
        
        <td><?php echo $i+1; ?>
        </td>
        
        <td class="tdreadinglink"><?php echo $ereadings[$i]['reading_citation']?><br>
            <a href="<?php echo $ereadings[$i]['reading_link'];?>" target="_blank"> <?php echo $ereadings[$i]['reading_description'];?></a>
        </td>
        
        <td>
            <?php echo $ereadings[$i]['reading_notes']; ?>
        </td>
        
        <td>
            <a id="usage<?php echo $i; ?>"><?php echo $ereadings[$i]['usg_total']; 
                  if($ereadings[$i]['usg_total'] > 0)  echo (' [' . $ereadings[$i]['usg_unique_users'] . ']');?></a>
        </td>
        <?php if($is_tc == false){?>
        <td>
            <?php if ($ereadings[$i]['status'] == 'Active') echo 'a'; 
             else if ($ereadings[$i]['status'] == 'Inactive') echo 'i';
             else if ($ereadings[$i]['status'] == 'Pending') echo 'p';?>
        </td>
        <?php }?>
        <td>
            <?php echo $ereadings[$i]['internal_notes']; ?>
        </td>
        
        <td class="tdcitation" style="display:none"><?php echo $ereadings[$i]['reading_citation']?><br>
        </td>
    </tr>
    <?php } ?>
  </table>
  </div>
</div>
<?php if ($readings_count > 0){ ?>   
<div class="row">
  <div class="col-md-4"> <br />
   <button type="button" name="selectall" class="btn btn-primary" tabindex="1">Select all</button>
   <button type="button" name="unselectall" class="btn btn-primary" tabindex="2">Deselect all</button>
  </div>
  <div class="col-md-4"> <br />
    <button type="button" name="next_step" class="btn btn-primary" tabindex="10" >Next step >> </button> </div>
  <div class="col-md-4"> 
    <!-- not in use --> 
  </div>
</div>    
<?php }?>    
</div>


<br>

</div>

<div id="avails">
    <input type="hidden" id="from_avail" value="<?php echo $from_avail; ?>"/>
    <input type="hidden" id="to_avails" value="<?php #echo implode($to_avails,',');?>"/>
</div>

<!--<div id="dialog-form" title="Rollover eReadings">-->


<div id="sel_to_topic" style="display:none">

  <script src="<?php echo base_url() . 'resource/listmgr/';?>js/chktopic.js" type="text/javascript"></script>
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
        $("#to_topic_code").val("<?php echo($from_topic_code);?>");
        //$("#to_topic_code").select();
        //$("#to_topic_code").focus();
        $("#display_toavails_btn").click();
    });
    
    $(function() {
        $("#to_topic_code").on("keypress", function(e) {    
            if (e.keyCode == 13) {
                $("#display_toavails_btn").click();
             return false;
            }
        });
});
  </script>
  
  <div class="container">
  <div class="row">
    <form action="">
      <div class="col-md-6">
        <h2>Search topics</h2>
        <br />
        <div class="input-group">
          <input id="to_topic_code" name="to_topic_code" class="form-control" type="text" placeholder="Enter Topic Code" autofocus tabindex="1" autocomplete="on" value="<?php if(isset($topic_code)) echo $topic_code; ?>">
          <span class="input-group-btn">
          <button id="display_toavails_btn" type="button" class="btn btn-primary" tabindex="2" >Submit</button>
          </span> 
        </div>
        <br />
        <br />
      <div id="to_avails1">
        <h2>Select target lists</h2>
        
      </div>
      </div>
    </form>
    <div class="col-md-2"> 
      <!--  Visual breath :-)   --> 
    </div>
    <div class="col-md-4">
      <h3>Note</h3>
      <p>If you rollover eReadings to a list today you will <span class="text-danger">not be able to copy them from that list</span> to another list. You can still copy them from the original list.</p>
      <p>You will need to <em>make a request</em> to:</p>
      <ul>
        <li>Add new eReadings that do not appear on an existing list</li>
        <li>Delete eReadings
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
  
    
</div>


<div id="do_rollover" style="display:none">
<!--    
  <div id="tabs">
  <ul>
      <li><a href="#tabs-1">Summary</a></li>
      <li><a href="#tabs-2">Detail log</a></li>
  </ul>
-->
  

  <div class="container">
  <div class="row">
    <div class="col-md-8">
      <h2>Process</h2>
      <p>Starting the process will copy <b><label id ="dialog_show_num_readings"> </label></b> eReadings from <b><?php echo $from_avail; ?></b> to target lists for:</p>
      <div id="selected_to_avail_list"></div>
      <br />

        <button type="button" id="start_rollover" class="btn btn-primary" onclick="javascript:start_rollover();">Start process</button>
        <button type="button" id="cancelbutton" class="btn btn-primary ui-state-disabled" disabled="">Stop process</button>
    </div>
    <div class="col-md-4">
      <h3>Process complete?</h3>
      <p>Once the process is complete, you can view the list for:</p>     
      <div id="view_list_after_rollover"> 
          <ul></ul> 
      </div>
      <p>or, if you need other changes</p>
      <ul>
        <li><a id="create_req_after_rollover" href="" onclick="javascript:$('#create_request_form').submit();return false;">Make a request to the Library</a></li>
      </ul>
      
    </div>
  </div>
  <hr />
  
  <!--
  <div class="row">
    <table id="rollover_progress_table" >
    <tr>
        <th>Target Availabilities<br><br></th>
        <th>Progress<br><br></th>
        <th>&nbsp;&nbsp;&nbsp;&nbsp;Result<br><br></th>
    </tr>
    
    </table> 
  </div>    
  -->

  <div class="row">
    <div class="col-md-2">
      <p class="lead">Target Lists</p>
    </div>
    <div class="col-md-6">
      <p class="lead">Progress</p>
    </div>
    <div class="col-md-4">
      <p class="lead">Result</p>
    </div>
  </div>
  <div id="rollover_progress_table" >    
  </div>   
  
  <div class="row">
    <hr />
    <div class="col-md-8">
      <ul class="nav nav-tabs" role="tablist">
         <li role="presentation" class="active"><a href="#summary" aria-controls="summary" role="tab" data-toggle="tab">Status</a></li>
         <li role="presentation"><a href="#detaillogs" aria-controls="detaillogs" role="tab" data-toggle="tab">Detail logs</a></li>
      </ul>
        
      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="summary">
           <div id="summary_log" style="overflow: auto; height: 300px; border: 1px">
            <table id="summary_log_table" style='font-size:12px'></table>
          </div> 
        </div>
        <div role="tabpanel" class="tab-pane" id="detaillogs">
           <div id="detail_log" style="overflow: auto; height: 300px; border: 1px">
            <table id="detail_log_table" class="table table-hover" style='font-size:12px'></table>
          </div> 
        </div>
      </div>
    
      
      <br>
      
    </div>
    <div class="col-md-4">
      <h3>What could go wrong?</h3>
      <p class="text-danger">The Library follows up on all issues.</p>
      <ul>
         <li>The <a href="mailto:eReserve@flinders.edu.au">Learning Access Team</a> is automatically notified of all list rollovers - including successful or <span class="text-danger"> failed </span> eReading rollovers.</li>
        <li>You can see this notification in the <i>View Requests</i> area of the site.</li>
      </ul>
      <p>An issue can occur if adding an eReading would breach the copyright requirements - e.g. another Topic is now using another chapter.</p>
      
    </div>
  </div>
</div>
  
</div>




<?php

include 'footer.php';

?>