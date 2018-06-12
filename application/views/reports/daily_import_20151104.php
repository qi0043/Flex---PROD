<div >
	<div class="panel panel-default">
	<div class="panel-heading">
	  <h3 class="panel-title"><i class="fa fa-tasks"></i>&nbsp;Flextra daily CRON jobs</h3>
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
<style>
.panel {
    overflow: auto;
}
</style>