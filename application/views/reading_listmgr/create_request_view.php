<?php

include 'header.php';

$avails_count = count($avails_for_new_req);
if($avails_for_new_req !=null)
    $availabilities = implode($avails_for_new_req, ',');
else
    $availabilities = null;
#$current_page = "chktopic";
#include 'nav1.php';
?>

<script src="<?php echo base_url() . 'resource/listmgr/';?>bootstrap-datepicker-master/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url() . 'resource/listmgr/';?>ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/listmgr/';?>bootstrap-datepicker-master/css/datepicker3.css" media="all">
<script type="text/javascript"> 
 
  
    $(function() {
     $( "#submit_request_btn" )
      .click(function(){submit_request();}); 
    });
    
    $(function() {
      $( "#needed_by_date" ).datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true
      });
    });
  
    function submit_request()
    {
          $( "#submit_request_btn" ).prop("disabled", true);
          //alert(CKEDITOR.instances.editor1.getData());
          //return;
          var req_content = $.trim(CKEDITOR.instances.editor1.getData());
          var req_subject = $.trim($("#request_subject").val());
          var req_needby_date = $.trim($("#needed_by_date").val());
          
          if(req_content.length <= 0 || req_subject.length <= 0 || req_needby_date.length <= 0)
          {
              alert("Please fill in the requested information.");
              $( "#submit_request_btn" ).prop("disabled", false);
              return;
          }
         
         
          var tmp_to_avails=[];
          tmp_to_avails = $('#tblavails input:checkbox:checked').map(function() { return $(this).val();});
          var to_avails_postparam = [];
          for(i=0;i<tmp_to_avails.length;i++)
          {
              to_avails_postparam[i] = to_avails[i];
          }
          
          var posting = $.post( "create_request_res", 
                    { "editor1" : req_content,
                      "topic_code" : $("#topic_code").val(),
                      "avails_for_new_req" : $("#avails_for_new_req").val(),
                      "needed_by_date" : req_needby_date,
                      "request_subject" : req_subject
                      }
                );
 
          posting.done(function( data,status ) {
              var resultobj = jQuery.parseJSON(data);
              var result_status = resultobj.status;
              var error_info = resultobj.error_info;
              if(result_status == 'success')
              {
                  var uuid = resultobj.uuid;
                  var version = resultobj.version;
                  //alert("Request successfully submitted.");
                  $("#uuid").val(uuid);
                  $("#version").val(version);
                  $("#get_one_request_form").submit();
                  //window.location.href = "get_one_request/"+uuid+"/"+version;
                  //$("#getrequestForm").submit();
              }
              else
              {
                  alert("Request submition Failed: " + error_info);
                  $( "#submit_request_btn" ).prop("disabled", false);
              }
              
          });

          posting.fail(function(xhr, status, error) {
                            alert("Error: " + xhr.status + " " + error);
                            //alert(error);
                            //alert(xhr.responseText);
                            $( "#submit_request_btn" ).prop("disabled", false);
          });
    }
    $(function() {
     $("#header_level_2_txt").html("Make request");
    });  
</script>


<div class="page-header" style="background-color:#EEE">
  <div class="container" >
    <div class="row">
      <div class="col-md-12"> <br />
        <h1>Step 2: Send Request</h1>
        <br />
      </div>
    </div>
    <div class="row ">
      <div role="navigation"> 
        <!-- For current step display: btn btn-success disabled AND >> before the next step  --> 
        <!-- For previous step display: btn btn-success AND tick before the next step  --> 
        <!-- For following steps display: btn btn-default AND >> before the next step  -->
        <div class="col-md-2"> <a href="create_req_chktopic.html?topic_code=<?php echo $topic_code;?>&view_type=request" class="btn btn-success btn-block"  tabindex="100">1. Select list</a> </div>
        <div class="col-md-1"> 
          <!--<p class="text-center lead hidden-xs hidden-sm" > >> </p>-->
          <p class="text-success lead hidden-xs hidden-sm" style="color:#5cb85c;"><span class="glyphicon glyphicon-ok"></span></p>
        </div>
        <div class="col-md-2"> <a href="" class="btn btn-success disabled  btn-block" tabindex="100">2. Send Request</a> </div>
        <div class="col-md-1"> 
          <!-- needed to keep height -->
          <p class="text-center lead hidden-xs hidden-sm"> >> </p>
        </div>
        <div class="col-md-2"> <a href="" class="btn btn-default disabled  btn-block" tabindex="100">3. View Request</a> </div>
        <div class="col-md-4"> 
          <!-- needed to keep height -->
          <p class="text-center lead hidden-xs hidden-sm">&nbsp; </p>
        </div>

      </div>
    </div>
  </div>
</div>

<br>
<!--
<?php if(isset($result_status) && $result_status == 'success'){ ?>
<div class="alert alert-success" role="alert">Request successfully created!</div>
<?php } ?>
<?php if(isset($result_status) && $result_status == 'failed'){ ?>
<div class="alert alert-danger" role="alert"><?php #echo $error_info;?></div>
<?php } ?>
-->


<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h2>Complete and send</h2>
      <p><i>Please treat this request as an email to the <a href="mailto:eReserve@flinders.edu.au">Learning Access Team</a>.</i></p>
      <form  class="form-horizontal" role="form">
        <div class="form-group">
          <label for="lists" class="col-sm-2 control-label">Lists</label>
          <div class="col-sm-10">
            <ul>
            <?php for($i=0;$i<$avails_count;$i++){ ?>
                <li><?php echo $avails_for_new_req[$i]; ?></li>
            <?php } ?>
            </ul>
          </div>
        </div>
        <div class="form-group">
          <label for="subject" class="col-sm-2 control-label">Request heading</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name="request_subject" id="request_subject" placeholder="example: New readings">
          </div>
        </div>
        <div class="form-group">
          <label for="neededby" class="col-sm-2 control-label" >Date needed</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" name ="needed_by_date" id="needed_by_date" value="<?php echo $date_neededby;?>">
          </div>
        </div>
        <div class="form-group">
          <label for="requestarea" class="col-sm-2 control-label">Request body</label>

        <div class="col-sm-10">
            <p class="form-control-static"> <i>To paste text below, click into the box and then use type Ctrl-V (Cmd-V on Mac).</i>
            </p>
        </div>
        </div>
        <textarea name="editor1" id="editor1" rows="16" cols="150" value="">
        </textarea>
        <script>
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace( 'editor1' );
            //<?php #if(isset($editor1)){?>
            //  CKEDITOR.instances.editor1.setData('<?php #echo str_replace("\n", "", $editor1);?>');
            //<?php #} ?>
        </script>
        
    	<br />
    	<br />
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="button" id="submit_request_btn" class="btn btn-primary">Send request</button>  
            
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<form id="getrequestForm" action="get_requests_by_avail" method="post">
    <input type="hidden" name="avail_for_requests" id="avail_for_requests" value="<?php echo $avails_for_new_req[0]; ?>">
    <input type="hidden" name="new_req_created" id="new_req_created" value="success">
</form>

<input type="hidden" name="topic_code" id="topic_code" value="<?php echo $topic_code; ?>">
<input type="hidden" name="avails_for_new_req" id="avails_for_new_req" value="<?php echo $availabilities; ?>">

<form id="get_one_request_form" action="get_one_request" method="post">
    <input type="hidden" name="topic_code" id="topic_code" value="<?php echo $topic_code; ?>">
    <input type="hidden" name="uuid" id="uuid" value="">
    <input type="hidden" name="version" id="version" value="1">
</form>

<?php
include 'footer.php';
?>