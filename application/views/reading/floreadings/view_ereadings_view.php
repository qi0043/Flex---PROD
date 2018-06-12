<?php
include 'header.php';
if($ereadings === false)
    $readings_count = 0;
else
    $readings_count = count($ereadings);

?>

<script type="text/javascript">
    function view_ereadings(avail)
    {
	$('input[name=current_avail]').val(avail);
	$('#avails_lists').submit();
    }
</script>

<div class="container-fluid">
 
<?php if(isset($down_notice['message'])) {?>
<div class="row">
    <div class="alert alert-info" role="alert"><?php echo $down_notice['message']; ?></div>	
</div>    
<?php }?> 
 
<?php if($course_meta['user_role'] == 'Instructor') { ?>
<div class="row">
    <div class="col-md-3">
      <!--  -->
    </div>
    <div class="col-md-9 bg-info">
      <p class="text-info">You are viewing the topic coordinator/teacher version of the eReadings list</strong>
        <span style="padding-left:1.5em" >
        <a href="#infoForTeachers" class="btn btn-info btn-xs" data-toggle="collapse" role="button">more info</a>
        </span>
      </p>
      <div id="infoForTeachers" class="collapse">
        <p>
          This version displays an icon if an eReading is not viewable by students.
          <ul style="list-style-type:none">
            <li >
              <span class="label label-success">
                  <span class="glyphicon glyphicon-time" aria-label="Viewable by students at a future date"></span>
              </span> &nbsp; The eReading will be available  at a future date.</li>
            <li> <span class="label label-danger">
                  <span class="glyphicon glyphicon-remove" aria-label="No longer viewable by students"></span>
                </span> &nbsp; The eReading is no longer viewable by students.</li>
        </ul>
        <p class="text-danger">NOTE: If an eReading on the list has one of the above icons, and it is made available under Part VB of the Copyright Act, you will not be able to click through and view the file.
        <p>Typically the date that eReadings should be viewable by students is the same day they have access to the FLO site (usually a week before the start of the teaching period).</p>
      </div>
    </div>
</div>    
<?php }?> 
    
<div class="row">
    
  <div class="col-md-3">
    <?php if (count($course_meta['enrolled']) > 0){ ?>
      
    <p class="list-group-heading"><strong>Your eReading list<?php if (count($course_meta['enrolled']) > 1) echo 's'; ?></strong></p>
    
    <table id="ereading_table" class="table table-hover table-striped">
    
    <thead>  
    </thead>
    <tbody>
    
    <?php for($i=0;$i<count($course_meta['enrolled']);$i++){ ?>
    <tr <?php #echo(($i%2==1) ? "class='even'" : "class='odd'");; ?> >
        
            
	<td <?php if($current_avail==$course_meta['enrolled'][$i]['shortname']) {?> class="info" <?php } ?> >
	    <?php if(intval($course_meta['enrolled'][$i]['ercount']) > 0) { ?>
            <a href="javascript:view_ereadings('<?php echo $course_meta['enrolled'][$i]['shortname']; ?>');"> 
		<?php echo $course_meta['enrolled'][$i]['shortname']; ?> 
		<span class="badge" style="float:right"> <?php echo $course_meta['enrolled'][$i]['ercount']; ?></span>  
	    </a>
	    <?php }else{?> 
	        <?php echo $course_meta['enrolled'][$i]['shortname']; ?>
	        <span class="badge" style="float:right">0</span>
	    <?php }?> 
        </td>
        
    </tr>
    <?php } ?>
    </tbody>
  </table>
  
  
  <?php }?>    
  
   <?php if (count($course_meta['othertopics']) > 0){ ?>
  
    <p class="list-group-heading" style="padding-top:1em"><strong>Other list<?php if (count($course_meta['othertopics']) > 1) echo 's'; ?> for FLO site</strong>
          <span style="padding-left:1.5em" >
          <a href="#otherLists" class="btn btn-info btn-xs" data-toggle="collapse" role="button">show/hide</a>
          </span>
    </p>
    <div id="otherLists" class="collapse in">
    <table id="ereading_table" class="table table-hover table-striped">
    
    <thead>
    </thead>
    <tbody>
    
    <?php for($i=0;$i<count($course_meta['othertopics']);$i++){ ?>
    <tr <?php #echo(($i%2==1) ? "class='even'" : "class='odd'");; ?> >
         
	<td <?php if($current_avail==$course_meta['othertopics'][$i]['shortname']) {?> class="info" <?php } ?> >
	    <?php if(intval($course_meta['othertopics'][$i]['ercount']) > 0) { ?>
            <a href="javascript:view_ereadings('<?php echo $course_meta['othertopics'][$i]['shortname']; ?>');"> 
		<?php echo $course_meta['othertopics'][$i]['shortname']; ?> 
		<span class="badge" style="float:right"> <?php echo $course_meta['othertopics'][$i]['ercount']; ?></span>  
	    </a>
	    <?php }else{?> 
	        <?php echo $course_meta['othertopics'][$i]['shortname']; ?>
	        <span class="badge" style="float:right">0</span>
	    <?php }?> 
        </td>
        
    </tr>
    <?php } ?>
    </tbody>
  </table>
  </div>
    
  <?php }?>     
  
  <form id="avails_lists" method="post" action="<?php echo base_url() . 'reading/floreadings/get_reading_for_avail/';?>">
	<!--<input type="hidden" name="enrolled_avails" value="<?php #echo $enrolled_avails; ?>">
	<input type="hidden" name="othertopics_avails" value="<?php #echo $othertopics_avails; ?>">-->
	<input type="hidden" name="current_avail" value="<?php #echo $current_avail; ?>">
	<input type="hidden" name="flo_site" value="<?php echo $flo_site; ?>">
  </form>
      
  </div>
    
    
  <div class="col-md-9">
    <table id="ereading_table" class="table table-hover table-striped">
    <?php if ($readings_count >= 0){ ?>
    <thead>
        
    <th></th>
    <th>eReadings for <?php echo $current_avail;?></th>
    <th>Notes</th>

    </thead>
    <tbody>
    <?php }?>
    <?php for($i=0;$i<$readings_count;$i++){ ?>
      <tr <?php #echo(($i%2==1) ? "class='even'" : "class='odd'");; ?> >
        
        
        <td><?php echo $i+1; ?>
        </td>
        
        <td class="tdreadinglink">
	    <?php if($course_meta['user_role'] == 'Instructor') { ?>
	        <?php if($ereadings[$i]['status'] == 'Inactive'){ ?>
	             <span class="label label-danger"><span class="glyphicon glyphicon-remove" aria-label="No longer viewable by students"></span></span>
	        <?php } else if($ereadings[$i]['status'] == 'Pending'){ ?>
	             <span class="label label-success"><span class="glyphicon glyphicon-time" aria-label="Viewable by students at a future date"></span></span>
	        <?php } ?>
	    <?php } ?>
	    <?php echo $ereadings[$i]['reading_citation']?><br>
            <a href="<?php echo $ereadings[$i]['reading_link'];?>" target="_blank"> <?php echo $ereadings[$i]['reading_description'];?></a>
	    
        </td>
        
        <td>
            <?php echo $ereadings[$i]['reading_notes']; ?>
        </td>
            
      </tr>
    <?php } ?>
    <?php if ($readings_count == 0){ ?>
      <tr>
	  <td></td>
	  <td>There are no eReadings for <?php echo $current_avail;?>.</td>
	  <td></td>
      </tr>
    <?php }?>
    </tbody>
  </table>
      
  
      
  </div>
</div>
 
 
</div>


<br>


<!--<div id="dialog-form" title="Rollover eReadings">-->


<?php

#include 'footer.php';

?>
</body>
</html>