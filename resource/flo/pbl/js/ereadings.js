
    
    //var current_post_idx;
    //var current_post_count;
    var citationArray=new Array;
    var ereadingArray=new Array;
    var num_div;
    var num_mod;
    var logline_class = 'even';
    var num_success = 0;
    var num_duplication = 0;
    var to_avails = [];
    var toavail_idx = 0;
    var postcall_idx = 1;
    var processing_stopped = true;
    var batch_size = 5;
    
    $(function() {
      $( "#selectall" )
      .button()
      .click(function( ) {
        //markAllRows( "readingForm" );
        $('#ereading_table input:checkbox').attr('checked',true);
        $('#ereading_table tr').addClass('marked');
      });
    });
    
    $(function() {   
     $( "#unselectall" )
      .button()
      .click(function( ) {
        //unMarkAllRows( "readingForm" );
        $('#ereading_table input:checkbox').attr('checked',false);
        $('#ereading_table tr').removeClass('marked');
      });
    });

    $(function() {   
     $( "#backtotopics" )
      .button()
      .click(function( ) {
        history.back();
      }); 
    });
    //$( "#selectall" ).click(function() {markAllRows( "readingForm" );});
    
    $(document).ready(function() {
      $('#ereading_table tr')
        .filter(':has(:checkbox:checked)')
        .addClass('marked')
        .end()
      .click(function(event) {
        $(this).toggleClass('marked');
        if (event.target.type !== 'checkbox') {
          $(':checkbox', this).attr('checked', function() {
            return !this.checked;
          });
        }
      });
    });
    
    
    function postcall() {
        //alert(availability);
        
        var readings = [];
        var reading_idxs = [];
        var k;
        
        if(postcall_idx <= num_div)
        {
            for(k=0;k<batch_size;k++)
            {
                readings[k] = ereadingArray[(postcall_idx-1)*batch_size+k];
                reading_idxs[k] = (postcall_idx-1)*batch_size+k;
                
            }
            //current_post_idx = postcall_idx;
            //current_post_count = batch_size;
        }
        else if(postcall_idx === num_div + 1)
        {
            for(k=0;k<num_mod;k++)
            {
                readings[k] = ereadingArray[(postcall_idx-1)*batch_size+k];
                reading_idxs[k] = (postcall_idx-1)*batch_size+k;   
            }
            //current_post_idx = postcall_idx;
            //current_post_count = num_mod;
        }
        else
        {
            alert("Internal error (wrong postcall_idx)!");
            return;
        }
        //alert(readings);
        var postvar = $.post( "rollover_activate", 
                    {   "from_avail" : $("#from_avail").val(),
                        "to_avail" : to_avails[toavail_idx],
                        "reading_idxs" : reading_idxs,
                        "readings": readings},
                    //,  to_topic_code: to_topic_code}
                    function(data){
                        
                        //console.log("Data: " + data);
                        //
                        //alert("Data: " + data + "\nStatus: " + status);
                        //var availid = "#" + to_avails[toavail_idx];
                        //alert(availid);
                        //var progressbar = $( ".progressbarclass").find("#" + to_avails[toavail_idx]);
                        var progressbar = $("#progbar" + to_avails[toavail_idx]);
                        var progressLabel = $("#proglabel" + to_avails[toavail_idx]);
                        var k;
                        var loginfo = '';
                        var reading_idx = [];
                        var item_status = [];
                        var status_shown = '';

                        if(processing_stopped === true) ////
                            return; 

                         progressbar.progressbar({
                              //value: false,
                              change: function() {
                                progressLabel.text( progressbar.progressbar( "value" ) + "%" );
                              },
                              complete: function() {
                                progressLabel.text( "Complete!" );
                              }
                         });
                        
                        var resultobj = jQuery.parseJSON(data);
                        var items_count = resultobj.items_count;
                        var error_info = resultobj.error_info;
                        
                        $.each(resultobj.items.readingidx, function (index, value) {
                            
                                //console.log("index: " + index + " value: " + value);
                                reading_idx[index] = value; //Not used!
                            
                        });
                        $.each(resultobj.items.status, function (index, value) {
                            
                                //console.log("index: " + index + " value: " + value);
                                item_status[index] = value;
                            
                        });
                                        //alert(Math.floor((i+1)*5*100/ereadingArray.length));
                        //console.log("current_post_count: " + current_post_count);
                        //for(k=0; k<current_post_count; k++)
                        for(k=0; k<items_count; k++)
                        {
                            switch (item_status[k])
                            {
                                case 'activated':
                                    status_shown = 'Success';
                                    num_success ++;
                                    break;
                                case 'duplication':
                                    status_shown = 'Duplication';
                                    num_duplication ++;
                                    break;
                                case 'failed':
                                    status_shown = '<p style="color:red">Failed</p>';
                                    break;
                                default:
                                    status_shown = '<p style="color:yellow">Failed</p>';
                                    break;
                            }
                            //style='font-size:12px'
                            loginfo += "<tr  class='" + logline_class + "'><td>" + 
                                            citationArray[(postcall_idx-1)*batch_size+k].replace('<br>','') 
                                            + " (" + to_avails[toavail_idx] + ")"
                                            + "</td>" + "<td style='width:30px;'>" + status_shown + "</td></tr>";
                            //console.log(loginfo);
                            
                            if (logline_class=='even')
                                logline_class = 'odd';
                            else
                                logline_class = 'even';
                            
                            if(item_status[k]=='failed')
                            {
                                //loginfo += "</table>";
                                loginfo += "<tr><td><p style='color:red'>" + error_info + "</p></td><td></td></tr>";
                                $("#detail_log_table tr:last").after(loginfo);
                                $("#detail_log").scrollTop(999999);
                                processing_stopped = true;
    
                                var result_info = "New activation: " + num_success;
                                if(num_duplication > 0)
                                    result_info += "<br>" + "Duplication: " + num_duplication;
                                result_info += "<br>Stop on error."
                                $("#rollover_progress_table").find("tr." + to_avails[toavail_idx])
                                    .find("td.activation_result").html(result_info);
                                //progressbar.progressbar( "value", Math.floor(postcall_idx*batch_size*100/ereadingArray.length) );
                                progressbar.progressbar( "value", Math.floor(((postcall_idx-1)*batch_size+k)*100/ereadingArray.length) );
                                alert("Processing stoped on Error: " + error_info);
                                return;
                            }    
                            
                        }
                        //loginfo += "</table>";
                        $("#detail_log_table tr:last").after(loginfo);
                        $("#detail_log").scrollTop(999999);
                        //i += batch_size;
                        
                        
                        progressbar.progressbar( "value", Math.floor(((postcall_idx-1)*batch_size+items_count)*100/ereadingArray.length) );
                        
                        if((postcall_idx === num_div && num_mod === 0) || (postcall_idx === num_div+1))
                        {
                            var result_info = "New activation: " + num_success;
                            if(num_duplication > 0)
                                result_info += "<br>" + "Duplication: " + num_duplication;
                            $("#rollover_progress_table").find("tr." + to_avails[toavail_idx])
                                    .find("td.activation_result").html(result_info);
                            toavail_idx++;
                            postcall_idx=1;
                            num_success = 0;
                            num_duplication = 0;
                        }
                        else
                        {
                            postcall_idx++;
                        }
                        
                        if(toavail_idx >= to_avails.length)
                        {
                            processing_stopped = true;
                            $("#detail_log").scrollTop(999999);
                            return;
                        }
                        
                        //if(processing_stopped === false)
                            postcall();
    
                    }
                    
                );
                postvar.fail(function(xhr, status, error) {
                    var loginfo = "<tr><td><p style='color:red'>Processing stoped on Error: " + xhr.status + " " + error + "</p></td><td></td></tr>";
                    $("#detail_log_table tr:last").after(loginfo);
                    $("#detail_log").scrollTop(999999);
                    processing_stopped = true;
                    alert("Processing stoped on Error: " + xhr.status + " " + error);
                    
                    var result_info = "New activation: " + num_success;
                    if(num_duplication > 0)
                        result_info += "<br>" + "Duplication: " + num_duplication;
                    result_info += "<br>Stop on error."
                    $("#rollover_progress_table").find("tr." + to_avails[toavail_idx])
                        .find("td.activation_result").html(result_info);
                });
    }
   
   $(function() { 
    $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 480,
      width: 640,
      modal: true,
      buttons: {
        "Start Rollover": function() {
          
            if(confirm("Are you sure you want to start the rollover?") == false)
                return;
            $("#detail_log_table").append("<tr><td>Start processing ...<br><br></td><td></td></tr>");
            $("#detail_log").scrollTop(999999);
                                
            $(this).parent().find("button:contains('Rollover')").addClass("ui-state-disabled").attr("disabled", true);

            ereadingArray.length = 0;
            ereadingArray=[];
            citationArray.length = 0;
            citationArray=[];
 
            //$("#ereading_table input:checkbox:checked").each(function(){ ereadingArray.push($(this).val()); });
            //citationArray = $("#ereading_table input:checkbox:checked").closest("tr").children("td.tdcitation").map(function() { return $(this).text();});
            //$("#ereading_table input:checkbox:checked").each(function(){ citationArray.push($(this).val()); });
            
            citationArray = $("#ereading_table input:checkbox:checked").closest("tr").children("td.tdcitation").map(function() { return $(this).html();});
            ereadingArray = $("#ereading_table input:checkbox:checked").closest("tr").children("td.tdreadinglink").children("a").map(function() { return $(this).attr('href');});
      
            
            //$.each(citationArray, function(index, citation) 
            //{
            //    alert(citation);
            //});
            processing_stopped = false;
            
            var from_avail = $("#from_avail").val();
            to_avails.length = 0;
            to_avails = [];
            to_avails = $("#to_avails").val().split(",");
            //alert(to_avails[0]);alert(to_avails[1]);

            num_div = Math.floor(ereadingArray.length / batch_size);
            num_mod = ereadingArray.length % batch_size;
            
            postcall_idx = 1;
            
            toavail_idx=0;
            
            num_success = 0;
            num_duplication = 0;
            
            postcall();
             
        },
        Close: function() {
          
          $( this ).dialog( "close" );
        }
      },
      beforeClose : function(){
        if(processing_stopped == false)
            if(confirm("Are you sure you want to stop the rollover process?") == false)
              return false;
        return true;
      },
      close: function() {
        //allFields.val( "" ).removeClass( "ui-state-error" );
        processing_stopped = true;
        
        var progressbar = $("[id^=progbar]");
        var progressLabel = $("[id^=proglabel]");
        progressbar.progressbar( "value", 0 );
        $("#rollover_progress_table").find("td.activation_result").text("");
        
        $("#detail_log_table").empty();
        
      }
    });
  });
  
  $(function() {
    $( "#rollover" )
      .button()
      .click(function() {
  
      var selected_count = $("#ereading_table input:checkbox:checked").length;
      if(selected_count<=0)
      {
          alert("Please select eReadings for rollover first.");
          return;
      }
  
        $("#dialog-form").dialog( "open" );
        $("#dialog-form #dialog_show_num_readings").text(selected_count);
        $("#dialog-form").parent().find("button:contains('Rollover')").removeClass("ui-state-disabled").attr("disabled", false);
        
        var index = $('#tabs a[href="#tabs-1"]').parent().index(); 
        $("#tabs").tabs("option", "active", index);
      });
   });
   
   $(function() {
    $( "#tabs" ).tabs();
    
   });
   
   $(function() {
      
    //var progressbar = $( ".progressbar" );
     // progressLabel = $( ".progress-label" );
      
    var progressbar = $("[id^=progbar]");
    var progressLabel = $("[id^=proglabel]");
        
    progressbar.progressbar({
      //value: false,
      change: function() {
        progressLabel.text( progressbar.progressbar( "value" ) + "%" );
      },
      complete: function() {
        progressLabel.text( "Complete!" );
      }
    });
    
    progressbar.progressbar( "value", 0 );
    //setTimeout( progress, 3000 );
  });

