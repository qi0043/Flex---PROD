
//$(document).ready(getavails);
$(document).ready(function(){$("#from_topic_code").focus();});

$(function() {
      //$( "button" ).button();
});

$(function() {
    //$("#display_avails_btn").button();
    $("#display_avails_btn").click(function(){getavails('reading');});
    $("#request_mgt_btn").click(function(){getavails('request');});
});


function getavails(func){
    
 //$("#topicForm").submit(function( event ) {
 
  // Stop form from submitting normally
  //event.preventDefault();
 
  // Get some values from elements on the page:
 
  var from_topic_code = $.trim($("#topic_code").val());
  //var to_topic_code = $.trim($("#to_topic_code").val());
  var url;
  if(func == 'reading')
     url = "getavails";
  else if(func == 'request')
     url = "getrequests";
 
  if(from_topic_code.length <= 0 ){
    alert("Please enter From topic code.");
    return false;
  }
 
  //alert(topiccode);
  // Send the data using post
  var posting = $.post( url, 
                    { "from_topic_code": from_topic_code}
                    //,function(data,status){
                        //alert("Data: " + data + "\nStatus: " + status);}
                );
 
  // Put the results in a div
  posting.done(function( data,status ) {
    //var content = $( data ).find( "#avails" );
    //alert(data);
    if(data.indexOf("privilege") != -1)
    {
        window.location.href = "reading/notification/noprivilege.html";
        return;
    }
    //alert("1");
    $( "#avails" ).hide(100);
    $( "#avails" ).empty().append( data );
    $( "#avails" ).show(700);
    //alert("2");
  });
  
  posting.fail(function(xhr, status, error) {
                    alert("Error: " + xhr.status + " " + error);
                    //alert(error);
                    //alert(xhr.responseText);
  });
  
//});
}


function getavails1(){

  // Get some values from elements on the page:
 
  var from_topic_code = $.trim($("#from_topic_code").val());
  //var to_topic_code = $.trim($("#to_topic_code").val());
  var url = "getavails";
  
 
  if(from_topic_code.length <= 0 ){
    alert("Please enter From topic code.");
    return false;
  }
  //alert("1");
  //alert(topiccode);
  // Send the data using post
  var posting = $.post( url, 
                    { "from_topic_code": from_topic_code}
                    //,function(data,status){
                        //alert("Data: " + data + "\nStatus: " + status);}
                );
 
  // Put the results in a div
  posting.done(function( data,status ) {
    //var content = $( data ).find( "#avails" );
    //console.log(data);
    if(data.indexOf("privilege") != -1)
    {
        window.location.href = "reading/notification/noprivilege.html";
        return;
    }
    //alert("1");
    $( "#avails" ).hide(100);
    $( "#avails" ).empty().append( data );
    //$( "#avails" ).html( data );
    $( "#avails" ).show("blind",700);
    
    //alert("2");
  });
  
  posting.fail(function(xhr, status, error) {
                    alert("Error: " + xhr.status + " " + error);
                    //alert(error);
                    //alert(xhr.responseText);
  });
  
}