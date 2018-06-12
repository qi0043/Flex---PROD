
    //$(document).ready(chktopic);
$(document).ready(getavails);
$(document).ready(function(){$("#topic_code").focus();});
$(function() {
    $( "button" )
      .button();
  });
  

function getavails(){
 $("#topicForm").submit(function( event ) {
 
  // Stop form from submitting normally
  event.preventDefault();
 
  // Get some values from elements on the page:
 
  var topic_code = $.trim($("#topic_code").val());
  //var to_topic_code = $.trim($("#to_topic_code").val());
  var url = "getavailabilities";
  
 
  if(topic_code.length <= 0){
    alert("Please enter topic code.");
    return false;
  }
 
  //alert(topiccode);
  // Send the data using post
  var posting = $.post( url, 
                    { topic_code: topic_code}
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
    $( "#avails" ).hide(100);
    $( "#avails" ).empty().append( data );
    $( "#avails" ).show("blind",700);
  });
  
  posting.fail(function(xhr, status, error) {
                    alert("Error: " + xhr.status + " " + error);
                    //alert(error);
                    //alert(xhr.responseText);
  });
  
});
}