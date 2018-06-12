<?php

include 'header.php';

$to_count = count($to_avails);
#$current_page = "chktopic";

#include 'nav1.php';
?>
<script type="text/javascript"> 
 
  $(function() {
    $("#header_level_2_txt").html("Activate one eReading for topic availabilities");
    $("#closebutton").click(function(){window.open('', '_self', '');window.close();});
  });
  
  
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
          <div class="col-md-2"> <a href="<?php echo $activate_link;?>" class="btn btn-success btn-block" tabindex="100">1. <span class="hidden-md">Select & activate</span><span class="visible-md-inline">Select & activate</span></a> </div>
          <div class="col-md-1">
            <!--<p class="text-center lead hidden-xs hidden-sm" > >> </p>-->
            <p class="text-success lead hidden-xs hidden-sm" style="color:#5cb85c;"><span class="glyphicon glyphicon-ok"></span>
          </div>
        </div>
        <div id="view_er_step2">
          <div class="col-md-2"> <a href="" class="btn btn-success disabled  btn-block" tabindex="100">2. View results</a> </div>
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
    
      <div class="col-md-6">
        <label class="preField">Activation result:  </label>   
        <br><br>
        <?php if($result['courses_added'] != null)
            echo "New courses added to FLEX: " . $result['courses_added'] . "<br><br>";
         ?>

        <table id="tblfromavails" class="table table-hover table-striped">

            <tr>

                <th>Availability</th>
                <th>Result</th>

            </tr>
            <?php for($i=0;$i<$to_count;$i++){ ?>
            <tr <?php #if($i%2==0) echo "class='even'"; else echo "class='odd'";?> >

                <td><?php echo $to_avails[$i]; ?></td>
                <td><?php echo $result["status"][$i]; ?></td>
            </tr>
            <?php } ?>
        </table>
        <br>
        <?php if($result['error_info'] != ''){ ?>
        <p style="color:red">Stop on error: <?php echo $result['error_info']; ?> </p>   
        <?php } ?>

        
        <br>
        <br>    
        <button type="button" id="closebutton" class="btn btn-primary" >Close page</button>    

      </div>

    <div class="col-md-2"> 
      <!--  Visual breath :-)   --> 
    </div>
    <div class="col-md-4">
      <h3>Note</h3>
      <p>If a result shows as <b>Duplication</b>, then it has already been activated.</p>
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