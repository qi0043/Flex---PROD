<?php

include 'header.php';

if($ereadings === false)
    $readings_count = 0;
else
    $readings_count = count($ereadings);
#$count = $readings_count; 
$toavail_count = count($to_avails);
 
?>


<div class="column grid_13">


<br>


<?php #echo form_open($submit_action); ?>


<script src="<?php echo base_url() . 'resource/rollover/';?>js/ereadings.js" type="text/javascript"></script>

<style>
  .ui-progressbar {
    position: relative;
    height: 17px;
  }
  .progress-label {
    position: absolute;
    left: 40%;
    top: 1px;
    font-weight: bold;
    text-shadow: 1px 1px 0 #fff;
  }
</style>


<form id="readingForm" action="">

<div class="breadcrumbs">
          
  <span typeof="v:Breadcrumb"><b>eReadings for Rollover</b></span>
  
</div>
<br>
Rollover eReadings from availability <b><?php echo $from_avail; ?></b> to availability:
<b><?php echo implode($to_avails,', '); ?></b>
<br>

<?php if($readings_count==0){?>
    <p style="color:red">No eReading for rollover.</p>
<?php } ?>
    <br>
    <p style="color:red">Note: This system only shows eReadings activated before today.</p>
    <p style="float:left">Note: Inactive e-Reading will be indicated in column status with:&nbsp;</p> <p style="float:left" class="ui-icon ui-icon-info"></p>
    <p style="clear:both;"></p>
    
<?php if($num_rollover_ereadings>0){?>
    <p style="color:red">There are <?php echo($num_rollover_ereadings);?> 
        eReadings rolled over or activated by this system today, 
        they can not be rolled over to other availabilities today.
    </p>
<?php } ?>
<br>
<?php if($readings_count>0){?>
<label class="preField">There are <?php echo($readings_count);?> eReadings for rollover.
    Please select the eReadings to rollover.  </label>
<?php } ?>
<br>
<br>
<button type="button" id="selectall"  >Select All</button>
<button type="button" id="unselectall"  >Unselect All</button>
<button type="button" id="rollover"  >Rollover Selections</button>
<button type="button" id="backtotopics"  >Back to Topics</button>
<br>    
<br>

<table id="ereading_table">
    <?php if ($readings_count > 0){ ?>
    <thead>
    <th></th>
    <th></th>
    <th>eReading</th>
    <th>Notes</th>
    <th>status</th>
    </thead>
    <?php }?>
    <?php for($i=1;$i<=$readings_count;$i++){ ?>
    <tr <?php echo(($i%2==1) ? "class='even'" : "class='odd'"); ?> >
        <td><input type="checkbox" name="select_reading[]" value="" ></td>
        
        <td><?php echo $i; ?>
        </td>
        
        <td class="tdreadinglink"><?php echo $ereadings[$i-1]['reading_citation']?><br>
            <a href="<?php echo $ereadings[$i-1]['reading_link'];?>" target="_blank"> <?php echo $ereadings[$i-1]['reading_description'];?></a>
        </td>
        
        <td>
            <?php echo $ereadings[$i-1]['internal_notes']; ?>
        </td>
        
        <td>
            <?php if ($ereadings[$i-1]['is_active'] != 'active'){?>
            <span class="ui-icon ui-icon-info"></span>
            <?php } else {echo 'active';}?>
        </td>
        
        <td class="tdcitation" style="display:none"><?php echo $ereadings[$i-1]['reading_citation']?><br>
        </td>
    </tr>
    <?php } ?>
</table>

</form>

<br>

<div id="avails">
    <input type="hidden" id="from_avail" value="<?php echo $from_avail; ?>"/>
    <input type="hidden" id="to_avails" value="<?php echo implode($to_avails,',');?>"/>
</div>


     
<div id="dialog-form" title="Rollover eReadings">
    
<div id="tabs">
<ul>
    <li><a href="#tabs-1">Summary</a></li>
    <li><a href="#tabs-2">Detail log</a></li>
</ul>
    
<div id="tabs-1">
  <!--<div style="overflow: auto; height: 270px;">-->
  <div >     
  <div>Rollover (<b><label id ="dialog_show_num_readings"> </label></b>) eReadings to selected availabilities.</div>
 
  <form>
      
  <!--
  <fieldset>
    <label for="name">Name</label>
    <input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all">
    <label for="email">Email</label>
    <input type="text" name="email" id="email" value="" class="text ui-widget-content ui-corner-all">
    <label for="password">Password</label>
    <input type="password" name="password" id="password" value="" class="text ui-widget-content ui-corner-all">
  </fieldset>
  -->
  <table id="rollover_progress_table">
    <tr >
        <th>To Availability</th>

        <th>Rollover Progress</th>
        <th>Process Result</th>
        
    </tr>
    <?php for($i=0;$i<$toavail_count;$i++){ ?>
    <tr class="<?php echo $to_avails[$i]; ?>">
        <td><?php echo $to_avails[$i]; ?></td>

        <td style="width:200px;"><div class="progressbar" id ="progbar<?php echo $to_avails[$i];?>"> <div class="progress-label" id ="proglabel<?php echo $to_avails[$i];?>">0%</div></div></td>
        <td class="activation_result"></td>
        
    </tr>
    <?php } ?>
  </table> 
  
  
  </form>
  </div>
</div>
    
<div id="tabs-2">
    <div id="detail_log" style="overflow: auto; height: 270px;">
        <table id="detail_log_table" style='font-size:12px'></table>
    </div>    
</div>
    
</div>

</div>

</div>


<?php

include 'footer.php';

?>