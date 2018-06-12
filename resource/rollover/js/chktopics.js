
$(document).ready(getavails);
$(document).ready(function(){$("#from_topic_code").focus();});

$(function() {
      $( "button" ).button();
});
  
$(function() {
      
     var to_topic_modified = false; 
      
    $( "#to_topic_code" ).change(function (e) {
      to_topic_modified = true;  
    });
  
    $( "#from_topic_code" ).keyup(function (e) {
        if(to_topic_modified === false)
        {
          $( "#to_topic_code" ).val($( "#from_topic_code" ).val());
        }
      });
      
    $( "#to_topic_code" ).focus(function () {
        //if($( "#from_topic_code" ).val().search($( "#to_topic_code" ).val())>=0)
        if(to_topic_modified === false)
        {
            setTimeout(function(){
               $( "#to_topic_code" ).select(); },50);

          //$( "#to_topic_code" ).select();
          //$( "#to_topic_code" ).select();
        }
      });
      
    $( "#to_topic_code" ).click(function () {
        //if($( "#from_topic_code" ).val().search($( "#to_topic_code" ).val())>=0)
        if(to_topic_modified === false)
        {
          $( "#to_topic_code" ).select();
          //$( "#to_topic_code" ).select();
        }
      });
      
});
  

function getavails(){
    
 $("#topicForm").submit(function( event ) {
 
  // Stop form from submitting normally
  event.preventDefault();
 
  // Get some values from elements on the page:
 
  var from_topic_code = $.trim($("#from_topic_code").val());
  var to_topic_code = $.trim($("#to_topic_code").val());
  var url = "getavails";
  
 
  if(from_topic_code.length <= 0 || to_topic_code.length <= 0){
    alert("Please enter From and To topic code.");
    return false;
  }
 
  //alert(topiccode);
  // Send the data using post
  var posting = $.post( url, 
                    { from_topic_code: from_topic_code,
                      to_topic_code: to_topic_code}
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
