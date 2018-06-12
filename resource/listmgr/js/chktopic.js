
    //$(document).ready(chktopic);
//$(document).ready(getavails);
$(document).ready(function(){$("#to_topic_code").focus();});

$(function() {
    //$("#display_avails_btn").button();
    $("#display_toavails_btn").click(function(){gettoavails();});
});

function gettoavails(){
 //$("#topicForm").submit(function( event ) {
 
  // Stop form from submitting normally
  //event.preventDefault();
 
  // Get some values from elements on the page:
 
  var topic_code = $.trim($("#to_topic_code").val());
  //var to_topic_code = $.trim($("#to_topic_code").val());
  var url = "get_toavailabilities";
  
 
  if(topic_code.length <= 0){
    alert("Please enter topic code.");
    return false;
  }
 
  //alert(topiccode);
  // Send the data using post
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
    $( "#to_avails1" ).fadeOut(200);
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