<?php
?>
<div class="page-header" style="background-color:#EEE">
  <div class="container" >
    <div class="row">
      <div class="col-md-12"> <br />
        <h1 id="view_er_step_titile">Step 1: Select list</h1>
        <br />
      </div>
    </div>
  <div id="view_er_nav" class="row ">
      <div role="navigation"> 
        <!-- For current step display: btn btn-success disabled AND >> before the next step  --> 
        <!-- For previous step display: btn btn-success AND tick before the next step  --> 
        <!-- For following steps display: btn btn-default AND >> before the next step  -->
        <div id="view_er_step1">
          <div class="col-md-2"> <a href="" class="btn btn-success disabled btn-block"  tabindex="100">1. <span class="hidden-md">Select list</span><span class="visible-md-inline">Select list</span></a> </div>
          <div class="col-md-1"> 
            <p class="text-center lead hidden-xs hidden-sm" > >> </p>
            <!--<p class="text-success lead hidden-xs hidden-sm" style="color:#5cb85c;"><span class="glyphicon glyphicon-ok"></span></p>-->
          </div>
        </div>
        <div id="view_er_step2">
          <div class="col-md-2"> <a href="" class="btn btn-default disabled  btn-block" tabindex="100">2. <span class="hidden-md">View eReadings list</span><span class="visible-md-inline">eReadings</span></a> </div>
          <div class="col-md-1">
            <p class="text-center lead hidden-xs hidden-sm" > >> </p>
            <!--<p class="text-success lead hidden-xs hidden-sm" style="color:#5cb85c;"><span class="glyphicon glyphicon-ok"></span></p>--> 
          </div>
        </div>
        
      </div>
  </div>
 </div>
 </div>



<script type="text/javascript">
$(function() {   
      //showstep(3); 
    });
function showstep(step_num){
    
    if(step_num > 2 || step_num < 1)
        return;
    var i;
    var a;
    var p;
    
    for(i=1; i<step_num; i++)
    {
        a = $("#view_er_nav #view_er_step" + i + " div a");
        a.removeClass("btn-default disabled");
        a.addClass("btn-success enabled");
        
        p = $("#view_er_nav #view_er_step" + i + " div p");
        p.html("<span class='glyphicon glyphicon-ok'></span>");
        p.css("color", "#5cb85c");
    }
    
    var title;
    switch (step_num){
         case 1:
             title = "Step 1: Select list";
             break;
         case 2:
             title = "Step 2: View eReadings list";
             break;
         default:
             break;
    }
    $("#view_er_step_titile").html(title);
    
    var a = $("#view_er_nav #view_er_step" + step_num + " div a");
    a.removeClass("btn-default");
    a.addClass("btn-success disabled");
    
    if(step_num<4)
    {
        var p = $("#view_er_nav #view_er_step" + step_num + " div p");
        p.html(">>");
        p.css("color", "black");
    }
    
    for(i=step_num+1; i<=4; i++)
    {
        a = $("#view_er_nav #view_er_step" + i + " div a");
        a.removeClass("btn-success");
        a.addClass("btn-default disabled");
        if(i<4)
        {
            p = $("#view_er_nav #view_er_step" + i + " div p");
            p.html(">>");
            p.css("color", "black");
        }
    }
}
</script>