
    
    //var current_post_idx;
    //var current_post_count;
    var citationArray=new Array;
    var ereadingArray=new Array;
    var num_div;
    var num_mod;
    var logline_class = 'even';
    var num_success = 0;
    var num_duplication = 0;
    var num_failed = 0;
    var max_num_failed = 10;
    var to_avails = [];
    var toavail_idx = 0;
    var postcall_idx = 1;
    var processing_stopped = true;
    var batch_size = 5;
    
    var final_result_info = '';
    var current_step = 0;
    var total_steps = 3;
    //var to_avails_array = new Array;
    var nav_steps = new Array(total_steps);
    //var create_new_list = false;
    
    var total_steps_rollover = 3;
    //var total_steps_newlist = 2;
    var report_notification_toflex=true;
    var report_error_toflex=true;
    //var nav_steps_rollover = new Array(total_steps_rollover);
    //var nav_steps_newlist = new Array(total_steps_newlist);
    // div id, title
    nav_steps = [ ['Choose eReadings', 'sel_ereadings'],
                  ['Select target lists', 'sel_to_topic'],  
                  ['Populate lists', 'do_rollover']
                ];
    /*
    nav_steps_rollover = [ ['Select eReadings', 'sel_ereadings'],
                  ['Select To Topic', 'sel_to_topic'],
                  ['Rollover eReadings', 'do_rollover']
                  ];
    nav_steps_newlist = [
                  ['Select To Topic', 'sel_to_topic'],
                  ['Requests to librarians', 'req_to_librarians'],
                  ];
    */              
    $(function() {
      $( "[name^='selectall']" )
      .button()
      .click(function( ) {
        //markAllRows( "readingForm" );
        $('#ereading_table input:checkbox:enabled').prop('checked',true);
        $('#ereading_table tr:has(:checkbox:enabled)').addClass('marked');
      });
    });
    
    $(function() {   
     $( "[name^='unselectall']" )
      .button()
      .click(function( ) {
        //unMarkAllRows( "readingForm" );
        $('#ereading_table input:checkbox:enabled').prop('checked',false);
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
    
    $(function() {
      $( "[name^=previous_step]" )
      .button()
      .click(function( ) {
        show_step("Previous");
      });
      $( "[name^=next_step]" )
      .button()
      .click(function( ) {
        show_step("Next");
      });
    });
    
    $(function() {   
      build_nav_steps_title(2); 
    });
    
    /*function build_nav_steps_title(){
        var nav_steps_title = '';
        var i;
        for(i=0; i<total_steps; i++)
        {
            //console.log(nav_steps[i][0]);
            if(i==current_step)
                nav_steps_title += '<font color="blue"><b>' + nav_steps[i][0] + '</b></font>';
            else
                nav_steps_title += nav_steps[i][0];
            
            if(i<total_steps-1)
                nav_steps_title += '-->';
        }
        $("#nav_steps_title").html(nav_steps_title);
    }*/
    
    function build_nav_steps_title(step_num){
    
        if(step_num > 4 || step_num < 1)
            return;
        var i;
        var a;
        var p;

        for(i=1; i<step_num; i++)
        {
            a = $("#rollover_nav #rollover_step" + i + " div a");
            a.removeClass("btn-default disabled");
            a.addClass("btn-success enabled");

            p = $("#rollover_nav #rollover_step" + i + " div p");
            p.html("<span class='glyphicon glyphicon-ok'></span>");
            p.css("color", "#5cb85c");
        }

        var title;
        switch (step_num){
             case 1:
                 title = "Step 1: Select existing list";
                 break;
             case 2:
                 title = "Step 2: Choose eReadings";
                 break;
             case 3:
                 title = "Step 3: Select target lists";
                 break;
             case 4:
                 title = "Step 4: Populate lists";
                 break;
             default:
                 break;
        }
        $("#rollover_step_titile").html(title);

        var a = $("#rollover_nav #rollover_step" + step_num + " div a");
        a.removeClass("btn-default");
        a.addClass("btn-success disabled");

        if(step_num<4)
        {
            var p = $("#rollover_nav #rollover_step" + step_num + " div p");
            p.html(">>");
            p.css("color", "black");
        }

        for(i=step_num+1; i<=4; i++)
        {
            a = $("#rollover_nav #rollover_step" + i + " div a");
            a.removeClass("btn-success");
            a.addClass("btn-default disabled");
            if(i<4)
            {
                p = $("#rollover_nav #rollover_step" + i + " div p");
                p.html(">>");
                p.css("color", "black");
            }
        }
    }
    
    function show_any_pre_step(step_num){
        
        if(step_num > current_step)
            return;
        if(step_num > 1) //only 0, 1
            return;

        
        //$("#"+nav_steps[current_step][1]).hide(300);
        var i;
        for(i=0; i<4; i++)
            $("#"+nav_steps[current_step][i]).css("display","none");
        
        //$("#steps-"+current_step).css("display","none");
        //$("#steps-"+current_step).hide("slide", { direction: "left" }, 300);
        current_step = step_num;


        //$("#steps-"+current_step).show("fade", { direction: move_direct }, 700);
        //$("#steps-"+current_step).css("display","inline");
        build_nav_steps_title(current_step+2);
        //console.log(nav_steps_title);
        //$("#"+nav_steps[current_step][1]).show(300);
        $("#"+nav_steps[current_step][1]).delay(800).css("display","inline");
    };

    function show_step(direction){
        
        if(direction != "Next" && direction != "Previous")
            return;
        if(direction == "Next" && current_step >= total_steps-1)
            return;
        if(direction == "Previous" && current_step <= 0)
            return;
        
                
        if(direction == "Next")
        {
            var ret_val = process_step();
            if (ret_val === false)
                return;
        }
        
        //$("#"+nav_steps[current_step][1]).hide(300);
        $("#"+nav_steps[current_step][1]).css("display","none");
        
        //$("#steps-"+current_step).css("display","none");
        //$("#steps-"+current_step).hide("slide", { direction: "left" }, 300);
        
        if(direction == "Next")
        {
            current_step ++;
            move_direct = "right";
        }
        else if(direction == "Previous")
        {
            current_step --;
            move_direct = "left";
        }


        //$("#steps-"+current_step).show("fade", { direction: move_direct }, 700);
        //$("#steps-"+current_step).css("display","inline");
        build_nav_steps_title(current_step+2);
        //console.log(nav_steps_title);
        //$("#"+nav_steps[current_step][1]).show(300);
        $("#"+nav_steps[current_step][1]).delay(800).css("display","inline");
    };
    
    function process_step(){
        switch(nav_steps[current_step][1])
        {
            case 'sel_to_topic':
                if( $('#tblavails input:checkbox:checked').length <= 0 )
                {
                  alert('Please select the target availabilities for rolling over.');
                  return false;
                };
                /*
                var has_from_avail = false;
                $('#tblavails input:checkbox:checked').each(function()
                {
                  if($(this).val() === $("#from_avail").val())
                  {
                    alert('To availabilities can not include the From availability.');
                    has_from_avail = true;
                    return false;
                  }
                  
                });
                if(has_from_avail === true)
                    return false;
                */
                to_avails = $('#tblavails input:checkbox:checked').map(function() { return $(this).val();});
                break;
            default:
                break;
        }
        switch(nav_steps[current_step+1][1])
        {
            case 'sel_to_topic':
                var selected_count = $("#ereading_table input:checkbox:checked").length;
                if(selected_count<=0)
                {
                    alert("Please select eReadings for rollover.");
                    return false;
                }
            case 'do_rollover':
                //console.log("0000");
                var selected_count = $("#ereading_table input:checkbox:checked").length;
                $("#dialog_show_num_readings").text(selected_count);
                var trstring = '';
                to_avails=[];
                to_avails = $('#tblavails input:checkbox:checked').map(function() { return $(this).val();});
                //console.log(to_avails);
                            
                var view_list_after_rollover_string = "<ul>"
                for(i=0;i<to_avails.length;i++)
                {
                    view_list_after_rollover_string += "<li><a href='view_ereadings?from_avail=" + to_avails[i] + "'>" + to_avails[i] + "</a>";
                    //view_list_after_rollover_string += "<li><a href='' onclick=\"javascript:$('#view_er_from_avail').val('" + to_avails[i] + "'); $('#view_er_form').submit();return false;\">" + to_avails[i] + "</a>";
                    //);"view_er_chktopic.html?topic_code=" + to_topic_code + "&view_type=ereading'>" + to_avails[i] + "</a>";
                }
                view_list_after_rollover_string += "<ui>";
                $("#view_list_after_rollover").html(view_list_after_rollover_string);
                //$("#create_req_after_rollover").prop("href","create_req_chktopic.html?topic_code=" + to_topic_code + "&view_type=request");
                //$("#create_req_after_rollover").html("<a href='' onclick='javascript:$('#create_request_form').submit();return false;' > Send a request to the Library </a>");javascript:$('#create_request_form').submit();return false;");
                
                var view_list_after_rollover_string = "<ul>"
                for(i=0;i<to_avails.length;i++)
                {
                    view_list_after_rollover_string += "<li>" + to_avails[i];
                }
                view_list_after_rollover_string += "<ui>";
                $("#selected_to_avail_list").html(view_list_after_rollover_string);
                
                for(i=0;i<to_avails.length;i++)
                {  
                    //console.log(to_avails[i]);
                    //trstring += "<tr class='" + to_avails[i] + "' " + tmp_bg + ">";
                    //trstring += '<td style="width:170px;vertical-align:top;">' + to_avails[i] + "</td>";
                    //trstring += '<td style="width:470px;"> <div class="progress"> <div class="progress-bar progress-bar-warning" id="progbar' + to_avails[i] + '" role="progressbar" aria-valuemin="0" aria-valuemax="100" ></div> </div>&nbsp;&nbsp;&nbsp;</td>'
                    //trstring += '<td class="activation_result" style="vertical-align:top;"></td> </tr>';
                    
                    
                    trstring += "<div class='row " + to_avails[i] + "' " + ">";
                    trstring += '<div class="col-md-2">' + to_avails[i] + "</div>";
                    trstring += '<div class="col-md-6"><div class="progress"> <div class="progress-bar progress-bar-warning" id="progbar' + to_avails[i] + '" role="progressbar" aria-valuemin="0" aria-valuemax="100" ></div></div></div>'
                    trstring += '<div class="col-md-4 activation_result"> </div></div>';
                }
                //console.log(trstring);
                
                //$('#start_rollover').removeClass("ui-state-disabled").prop("disabled", false);
                //$('#cancelbutton').addClass("ui-state-disabled").prop("disabled", true);
                set_rollover_button_status();
                
                //$("#rollover_progress_table").remove();
                $("#rollover_progress_table").html(trstring);
                //$("#rollover_progress_table").css("border-collapse", "collapse");
                //$("#rollover_progress_table").css("border", "1px solid darkgray");
                //$("#rollover_progress_table tr").css("background-color", "#f3f3f3");
                //console.log("11111");
                //var progressbar = $("[id^=progbar]");
                //var progressLabel = $("[id^=proglabel]");
                /*
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
                */
                break;
            default:
                break;
        }
        return true;
    };
    
    
    $(document).ready(function() {
      $('#ereading_table tr:has(:checkbox:enabled)')
        .filter(':has(:checkbox:checked)')
        .addClass('marked')
        .end()
      .click(function(event) {
        //console.log(event.target.nodeName);
        if(event.target.nodeName !== 'A') {
           $(this).toggleClass('marked');
        }
        if (event.target.type !== 'checkbox' && event.target.nodeName !== 'A') {
           $(':checkbox', this).prop('checked', function() {
            return !this.checked;
           });
        }
      });
    });
    
    function progress_bar(bar, progress){
       (bar).css('width', progress+'%').prop('aria-valuenow', progress).html(progress+'%');
       //console.log(bar);
       //console.log((bar).prop('aria-valuenow'));
    }
    
   function postcall() {
        //alert(availability);
        if(processing_stopped === true) ////
            return; 
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
                        //var progressLabel = $("#proglabel" + to_avails[toavail_idx]);
                        //var progressbar_selector = "#progbar" + to_avails[toavail_idx];
                        var k;
                        var loginfo = '';
                        var reading_idx = [];
                        var item_status = [];
                        var item_message =[];
                        var status_shown = '';
                        var progress1 = '';

                        if(processing_stopped === true) ////
                            return; 
                         /*
                         progressbar.progressbar({
                              //value: false,
                              change: function() {
                                progressLabel.text( progressbar.progressbar( "value" ) + "%" );
                              },
                              complete: function() {
                                progressLabel.text( "Complete!" );
                              }
                         });
                        */
                        
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
                        $.each(resultobj.items.message, function (index, value) {
                            
                                //console.log("index: " + index + " value: " + value);
                                item_message[index] = value;
                            
                        });
                                        //alert(Math.floor((i+1)*5*100/ereadingArray.length));
                        //console.log("current_post_count: " + current_post_count);
                        //for(k=0; k<current_post_count; k++)
                        for(k=0; k<items_count; k++)
                        {
                            loginfo += "<tr class='" + logline_class + "'><td>" + 
                                            citationArray[(postcall_idx-1)*batch_size+k].replace('<br>','') 
                                            + " (" + to_avails[toavail_idx] + ")";
                            switch (item_status[k])
                            {
                                case 'activated':
                                    status_shown = 'Success';
                                    num_success ++;
                                    break;
                                case 'duplication':
                                    status_shown = 'Existing';
                                    num_duplication ++;
                                    break;
                                case 'failed':
                                    num_failed ++;
                                    status_shown = '<p class="text-danger">Failed</p>';
                                    loginfo += "<br><p class='text-danger'>" + item_message[k] + "</p>";
                                    break;
                                default:
                                    status_shown = '<p style="color:yellow">Failed</p>';
                                    break;
                            }
                            loginfo += "</td>" + "<td style='width:30px;'>" + status_shown + "</td></tr>";
                            
                            //loginfo += "<tr  class='" + logline_class + "'><td>" + 
                            //                citationArray[(postcall_idx-1)*batch_size+k].replace('<br>','') 
                            //                + " (" + to_avails[toavail_idx] + ")"
                            //                + "</td>" + "<td style='width:30px;'>" + status_shown + "</td></tr>";
                            //console.log(loginfo);
                            
                            if (logline_class=='even')
                                logline_class = 'odd';
                            else
                                logline_class = 'even';
                            
                            //if(item_status[k]=='failed')
                            if(num_failed > max_num_failed || error_info.length > 1)
                            {
                                if(num_failed > max_num_failed)
                                    error_info = "Process stopped. Too many Failed items!";
                                //console.log(error_info);
                                //loginfo += "</table>";
                                loginfo += "<tr><td><p class='text-danger'>" + error_info + "</p></td><td></td></tr>";
                                $("#detail_log_table tr:last").after(loginfo);
                                $("#detail_log").scrollTop(999999);
                                $("#summary_log_table tr:last").after(loginfo);
                                $("#summary_log").scrollTop(999999);
                                processing_stopped = true;
                                set_rollover_button_status();
                                report_rollover_logs(1);
    
                                var result_info = "Success: " + (num_success+num_duplication);
                                if(num_duplication > 0)
                                    result_info += " (Existing: " + num_duplication + ")";
                                if(num_failed > 0)
                                    result_info += "<br>" + "Failed: " + num_failed;
                                result_info += "<br>Stop on error."
                                $("#rollover_progress_table").find("div." + to_avails[toavail_idx])
                                    .find("div.activation_result").html(result_info);
                                //progressbar.progressbar( "value", Math.floor(postcall_idx*batch_size*100/ereadingArray.length) );
                                
                                progress1 = Math.floor(((postcall_idx-1)*batch_size+k)*100/ereadingArray.length);
                                progress_bar(progressbar, progress1);
                                //progressbar.progressbar( "value", Math.floor(((postcall_idx-1)*batch_size+k)*100/ereadingArray.length) );
                                alert("Processing stopped on Error: " + error_info);
                                return;
                            }    
                            
                        }
                        //loginfo += "</table>";
                        $("#detail_log_table tr:last").after(loginfo);
                        $("#detail_log").scrollTop(999999);
                        //i += batch_size;
                        
                        progress1 = Math.floor(((postcall_idx-1)*batch_size+items_count)*100/ereadingArray.length);
                        //progressbar.progressbar( "value", Math.floor(((postcall_idx-1)*batch_size+items_count)*100/ereadingArray.length) );
                        progress_bar(progressbar, progress1);
                        
                        if((postcall_idx === num_div && num_mod === 0) || (postcall_idx === num_div+1))
                        {
                            var result_info = "Success: " + (num_success+num_duplication);
                            if(num_duplication > 0)
                                    result_info += " (existing: " + num_duplication + ")";
                            if(num_failed > 0)
                                result_info += ", Failed: " + num_failed;

                            var tmp_str = result_info.replace(/\(existing: \d+\)/, "");
							tmp_str = '<span class="label label-warning">Process complete</span>' + ' ' + tmp_str; //HAN added this line
							
                            //if(result_info.indexOf("(existing") != -1)
                            //    tmp_str = result_info.slice(0, result_info.indexOf("(existing"));
                            $("#rollover_progress_table").find("div." + to_avails[toavail_idx])
                                    .find("div.activation_result").html(tmp_str);
                            
                            
                            //var to_topic_code = to_avails[toavail_idx].slice(0, to_avails[toavail_idx].indexOf("_"));
                            var home_link = $("#home_link").attr("href");
                            //console.log(home_link);
                            var view_er_link = home_link.slice(0, home_link.indexOf("home"));
                            view_er_link += "view_ereadings?from_avail=" + to_avails[toavail_idx];
                            var to_avail_link_str = "<a href='" + view_er_link + "'>" + to_avails[toavail_idx] + "</a>";        
                            //console.log(to_avail_link_str);
                            final_result_info += '<br>- ' + to_avail_link_str + ': ' + result_info;
                            
                            
                            //final_result_info += '<br>- ' + to_avails[toavail_idx] + ': ' + result_info;
                            toavail_idx++;
                            postcall_idx=1;
                            num_success = 0;
                            num_failed = 0;
                            num_duplication = 0;               
                        }
                        else
                        {
                            postcall_idx++;
                        }
                        
                        if(toavail_idx >= to_avails.length)
                        {
                            var final_line = "<tr><td>" + '<br><b>Completed</b>: ' + new Date().toLocaleString() + "" + final_result_info + "<br><br></td><td></td></tr>";
                            $("#detail_log_table tr:last").after(final_line);
                            $("#summary_log_table tr:last").after(final_line);
                            //$("#detail_log").scrollTop(999999);
                            processing_stopped = true;
                            set_rollover_button_status();
                            report_rollover_logs(0);
                            $("#detail_log").scrollTop(999999);
                            return;
                        }
                        
                        //if(processing_stopped === false)
                            postcall();
    
                    }
                    
                );
                postvar.fail(function(xhr, status, error) {
                    var loginfo = "<tr><td><p class='text-danger'>Processing stopped on Error: " + xhr.status + " " + error + "</p></td><td></td></tr>";
                    $("#detail_log_table tr:last").after(loginfo);
                    $("#detail_log").scrollTop(999999);
                    $("#summary_log_table tr:last").after(loginfo);
                    $("#summary_log").scrollTop(999999);
                    processing_stopped = true;
                    set_rollover_button_status();
                    alert("Processing stopped on Error: " + xhr.status + " " + error);
                    report_rollover_logs(1);
                    
                    var result_info = "Success: " + (num_success+num_duplication);
                    if(num_duplication > 0)
                                    result_info += " (Existing: " + num_duplication + ")";
                    if(num_failed > 0)
                        result_info += "<br>" + "Failed: " + num_failed;
                    result_info += "<br>Stop on error."
                    $("#rollover_progress_table").find("div." + to_avails[toavail_idx])
                        .find("div.activation_result").html(result_info);
                });
    }
   
   function start_rollover() {
       
        var selected_count = $("#ereading_table input:checkbox:checked").length;
        if(selected_count<=0)
        {
            alert("Please select eReadings for rollover first.");
            return;
        }
  
        //$("#dialog-form").dialog( "open" );
        //$("#dialog-form #dialog_show_num_readings").text(selected_count);
        //$("#dialog-form").parent().find("button:contains('Rollover')").removeClass("ui-state-disabled").attr("disabled", false);
        
          
            if(confirm("Are you sure you want to start the rollover?") == false)
                return;
            
            var from_avail = $("#from_avail").val();
            var selected_count = $("#ereading_table input:checkbox:checked").length;
            var timestring = new Date().toLocaleString();
            //var timestring = timenow.format("dd/mm/yyyy hh:mm:tt");
            var avails_log1 = '<br><b>Start processing:</b> ' + timestring + '<br>Rollover (' + selected_count + ') eReadings from ' + from_avail + ' to ';
            for(i=0;i<to_avails.length;i++)
            {
                avails_log1 += to_avails[i];
                if(i<to_avails.length-1)
                    avails_log1 += ', ';
            }
            avails_log1 += '';
            //$("#detail_log_table").empty();
            //$("#detail_log_table").append("<tr><td>Start processing ... <br><br></td><td></td></tr>");
            
            //$("#detail_log_table").append("<tr><td>Start processing ... " + new Date().format("dd/mm/yyyy hh:mm:tt") + "<br><br></td><td></td></tr>");
            $("#detail_log_table").append("<tr><td>" + avails_log1 + "<br></td><td></td></tr>");
            $("#summary_log_table").append("<tr><td>" + avails_log1 + "<br></td><td></td></tr>");
            
            $("#detail_log").scrollTop(999999);
                                
            $('#start_rollover').addClass("ui-state-disabled").prop("disabled", true);

            ereadingArray.length = 0;
            ereadingArray=[];
            citationArray.length = 0;
            citationArray=[];
 
            //$("#ereading_table input:checkbox:checked").each(function(){ ereadingArray.push($(this).val()); });
            //citationArray = $("#ereading_table input:checkbox:checked").closest("tr").children("td.tdcitation").map(function() { return $(this).text();});
            //$("#ereading_table input:checkbox:checked").each(function(){ citationArray.push($(this).val()); });
            
            citationArray = $("#ereading_table input:checkbox:checked").closest("tr").children("td.tdcitation").map(function() { return $(this).html();});
            ereadingArray = $("#ereading_table input:checkbox:checked").closest("tr").children("td.tdreadinglink").children("a").map(function() { return $(this).attr('href');});
      
            //console.log(ereadingArray[2]);
            var pos;
            for(i=0;i<ereadingArray.length;i++)
            {
                pos = ereadingArray[i].search("&token=")
                if(pos == -1)
                    break;
                ereadingArray[i] = ereadingArray[i].slice(0,pos);
            }
            //console.log(ereadingArray);
            
            processing_stopped = false;
            set_rollover_button_status();
            
            //to_avails.length = 0;
            //to_avails = [];
            //to_avails = $("#to_avails").val().split(",");
            //to_avails = to_avails_array;
            //alert(to_avails[0]);alert(to_avails[1]);

            num_div = Math.floor(ereadingArray.length / batch_size);
            num_mod = ereadingArray.length % batch_size;
            
            postcall_idx = 1;
            
            toavail_idx=0;
            
            num_success = 0;
            num_duplication = 0;
            num_failed = 0;
            final_result_info = '';
            
            var to_avails_postparam = [];
            for(i=0;i<to_avails.length;i++)
            {
                to_avails_postparam[i] = to_avails[i];
            }
            
            //$("#detail_log_table").html("<tr><th>Action</th><th>Status</th></tr>");
            //Check whether the availabilities are in Flex, if no add them in
            var postvar1 = $.post(
                        "chk_to_availabilities", 
                        { "to_avails" : to_avails_postparam },
                    
                    function(data){
                        var loginfo = '';
                        //console.log(data);
                        var resultobj = jQuery.parseJSON(data);
                        var result_stat = resultobj.result_stat;
                        var error_info = resultobj.error_info;
                        var count_courses_added = parseInt(resultobj.count_courses_added);
                        
                        if(result_stat == "success")
                        {
                            if(count_courses_added > 0)
                            {
                                var loginfo = "<tr><td>Adding (" + count_courses_added + ") new topic availabilities to FLEX." + "</td><td>Success</td></tr>";
                                $("#detail_log_table tr:last").after(loginfo);
                                $("#detail_log").scrollTop(999999);
                            }
                            //Start to rollover eReadings
                            postcall();
                        }
                        else
                        {
                            var loginfo = "<tr><td><p class='text-danger'>Processing stopped when adding new course to Flex on Error: " + error_info + "</p></td><td></td></tr>";
                            $("#detail_log_table tr:last").after(loginfo);
                            $("#detail_log").scrollTop(999999);
                            $("#summary_log_table tr:last").after(loginfo);
                            $("#summary_log").scrollTop(999999);
                            processing_stopped = true;
                            set_rollover_button_status();
                            report_rollover_logs(1);
                            alert("Processing stopped when adding new course to Flex on Error: " + error_info);
                        }
                    }
                    
                );
             postvar1.fail(function(xhr, status, error) {
                    var loginfo = "<tr><td><p class='text-danger'>Processing stopped on Error: " + xhr.status + " " + error + "</p></td><td></td></tr>";
                    $("#detail_log_table tr:last").after(loginfo);
                    $("#detail_log").scrollTop(999999);
                    $("#summary_log_table tr:last").after(loginfo);
                    $("#summary_log").scrollTop(999999);
                    processing_stopped = true;
                    set_rollover_button_status();
                    report_rollover_logs(1);
                    alert("Processing stopped on Error: " + xhr.status + " " + error);
                    
                    var result_info = "Success: " + (num_success+num_duplication);
                    //if(num_duplication > 0)
                    //    result_info += "<br>" + "Duplication: " + num_duplication;
                    if(num_failed > 0)
                        result_info += "<br>" + "Failed: " + num_failed;
                    result_info += "<br>Stop on error."
                    $("#rollover_progress_table").find("div." + to_avails[toavail_idx])
                        .find("div.activation_result").html(result_info);
                });
                
            //postcall();
             
   }
   
   function cancel_rollover() {
       if(processing_stopped == false)
            if(confirm("Are you sure you want to stop the rollover process?") == false)
              return false;
       processing_stopped = true;
       set_rollover_button_status();
        
       var progressbar = $("[id^=progbar]");
       //var progressLabel = $("[id^=proglabel]");
       //progressbar.progressbar( "value", 0 );
       progress_bar(progressbar, 0);
       $("#rollover_progress_table").find("div.activation_result").text("");
       var loginfo = "<tr><td><p class='text-danger'>Rollover process canceled by user.</p></td><td></td></tr>";
       $("#detail_log_table tr:last").after(loginfo); 
       $("#detail_log").scrollTop(999999);
       $("#summary_log_table tr:last").after(loginfo);
       $("#summary_log").scrollTop(999999);
       
       
   }
   
   $(function() {
      $( "#cancelbutton" )
      .click(function( ) {
        cancel_rollover();
      });
    });
    
   function set_rollover_button_status(){
       if(processing_stopped === false)
       {
           $('#start_rollover').addClass("ui-state-disabled").prop("disabled", true);
           $('#cancelbutton').removeClass("ui-state-disabled").prop("disabled", false);
           //$('#rollover_previous').addClass("ui-state-disabled").prop("disabled", true); //Previous button
           //$('#closebutton').addClass("ui-state-disabled").prop("disabled", true);
           //$('[name=backto_avails]').addClass("ui-state-disabled").prop("disabled", true);
       }
       else
       {
           $('#start_rollover').removeClass("ui-state-disabled").prop("disabled", false);
           $('#cancelbutton').addClass("ui-state-disabled").prop("disabled", true);
           //$('#rollover_previous').removeClass("ui-state-disabled").prop("disabled", false);
           //$('#closebutton').removeClass("ui-state-disabled").prop("disabled", false);
           //$('[name=backto_avails]').removeClass("ui-state-disabled").prop("disabled", false);
           
           /*if($('#detail_log_table tr').length > 0)
           {
               $('#res_stat_link').css("display",'inline');
               $('#res_stat_explain').css("display",'inline');
           }*/
       }
   }
   
   function report_rollover_logs(is_error){
       
       var log_content;
       var there_is_error = 0;
       if(is_error == 1)
           there_is_error = 1;
       
       var summary_log = $("#summary_log").html();
       
       if(there_is_error == 0)
         if (summary_log.indexOf("Failed") != -1 || summary_log.indexOf("Error") != -1)
           there_is_error = 1;
       
       if(there_is_error==0)
       {
           if(report_notification_toflex==false)
               return;
           log_content = summary_log;
       }
       else
       {
           if(report_error_toflex==false)
               return;
           log_content = $("#detail_log").html();
       }
       
       var to_avails_postparam = [];
       for(i=0;i<to_avails.length;i++)
       {
          to_avails_postparam[i] = to_avails[i];
       }
       //console.log(log_content);console.log(to_avails_postparam);
       var postvar_log = $.post(
                        "report_error_logs", 
                        { "to_avails" : to_avails_postparam,
                          "there_is_error" : there_is_error,
                          "log_content": log_content},
                    
                    function(data){
                        //var loginfo = '';
                        //console.log(data);
                        var resultobj = jQuery.parseJSON(data);
                        var result_stat = resultobj.status;
                        //var error_info = resultobj.error_info;
                        //var count_courses_added = parseInt(resultobj.count_courses_added);
                        
                        if(result_stat == "success")
                        {
                            var loginfo = "<tr><td><p style='color:black'><i>The Learning Access Team has been notified of the result of the rollover. </i></p></td><td></td></tr>";
                            loginfo += "<tr><td><p style='color:black'><strong>What to do now:</strong><br>Return to <a href='home.html'><span class='glyphicon glyphicon-home'></span> eReadings List Management</a> page OR <br>Choose an option listed at the top right of page under <i>Process complete?</i><br></p></td><td></td></tr>";
                            $("#detail_log_table tr:last").after(loginfo);
                            $("#detail_log").scrollTop(999999);
                            $("#summary_log_table tr:last").after(loginfo);
                            $("#summary_log").scrollTop(999999);
                        }
                        else
                        {
                            var loginfo = "<tr><td><p class='text-danger'>Failed to report rollover logs to Librarian. Please contact the <a href='mailto:eReserve@flinders.edu.au'>Learning Access Team</a> if necessary.</p></td><td></td></tr>";
                            $("#detail_log_table tr:last").after(loginfo);
                            $("#detail_log").scrollTop(999999);
                        }
                    }
                );
             postvar_log.fail(function(xhr, status, error) {
                    var loginfo = "<tr><td><p class='text-danger'>Failed to report rollover logs to Librarian. Please contact the <a href='mailto:eReserve@flinders.edu.au'>Learning Access Team</a> if necessary." + xhr.status + " " + error + "</p></td><td></td></tr>";
                    $("#detail_log_table tr:last").after(loginfo);
                    $("#detail_log").scrollTop(999999);
                    
                });
   }
   /*
   $(function() { 
    $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 480,
      width: 640,
      modal: true,
      buttons: {
        "Previous": function(){
            show_step("Previous");
            },
        "Next": function(){
            show_step("Next");
            },
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
  */
  /*
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
   */
   /*
   $(function() {
    $( "#tabs" ).tabs();
    
   });
   */
   /*
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
 */
