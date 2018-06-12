<?php include 'header.php'; ?>

<div class="container">




	
      <!--<div class="row">
	<h4 class="page-header"><i class="fa fa-dashboard"></i>&nbsp;FLEX Flextra Data integration</h4>
      </div>-->
      <br><br>
      <div class="row">
      <div class="col-md-12">
      <div id="daily_import">
                   
	<div class="panel panel-default">
	<div class="panel-heading">
	  <h3 class="panel-title"><i class="fa fa-tasks"></i>&nbsp;FLEX Flextra Data/CRON</h3>
	</div>
	<div class="panel-body"> 
	 
	<div class="table-responsive">
	      <table class="table table-striped table-hover">
              <thead>
	      <tr>
		  <th>Task</th>
		  <th>Status</th>
		  <th>Time</th>
		  <th>Date</th>
		  <th>Details</th>
		  <th>Type</th>
		  <th>Next</th>
	      </tr>
	      </thead>
	      <tbody>
	      <?php for($i=0; $i<count($daily_import); $i++) { ?>
	      <tr>
		  <td><?php echo $daily_import[$i]['import_name']; ?></td> 
		  <td><?php if($daily_import[$i]['status'] == 'S') { ?>
		      <span class="label label-success">Success</span>
		  <?php } elseif($daily_import[$i]['status'] == 'PS') { ?>
			<span class="label label-warning">Warning</span>


		 <?php } else { ?>
		      <span class="label label-danger">Error</span>
		  <?php } ?>
		  </td> 
		  <td><?php echo $daily_import[$i]['last_imported']; ?></td>
		  <td><?php echo $daily_import[$i]['last_updated']; ?></td>
		  <td><?php echo $daily_import[$i]['message']; ?></td>
		  <td><?php echo $daily_import[$i]['schedule_type']; ?></td>
		  <td><?php echo $daily_import[$i]['next_run']; ?></td>
	      </tr>
	      <?php } ?>
	      </tbody>
	  </table>
	</div>
	</div>
	</div>
</div>
</div>
</div>
</div>
<style>
.panel {
    overflow: auto;
}
</style>
<!--<script>
$(document).ready(function(){
  $.ajax({
    url: "<?php echo base_url();?>/reports/reptmain/get_daily_import",
    method: "GET",
    success: function(data,status,request) {
        //$('#login_monthly_spin').removeClass( "fa fa-spinner fa-pulse fa-3x" ); 
        //var script1 = document.createElement( 'script' );
	//script1.type = 'text/javascript';
	//script1.src = data;
	//$("body").append( script1 );
	$('#daily_import').html(data);
    }
  });
});
</script>-->
<?php include 'footer.php'; ?>