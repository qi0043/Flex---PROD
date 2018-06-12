<div >
	<div class="panel panel-default">
	<div class="panel-heading">
	  <h3 class="panel-title"><i class="fa fa-files-o"></i>&nbsp;FLEX Collections</h3>
	</div>
	<div class="panel-body"> 
	 
	<div class="table-responsive">
	      <table class="table table-striped table-hover">
              <thead>
	      <tr>
		  <th>Collection</th>
		  <th>Live</th>
		  <th>Other</th>
	      </tr>
	      </thead>
	      <tbody>
	      <?php for($i=0; $i<count($collections); $i++) { ?>
	      <tr>
		  <td><?php echo $collections[$i]['name']; ?></td> 
		  <td><span class="badge"><?php echo $collections[$i]['live_count']; ?></span></td>
		  <td><span class="badge"><?php echo $collections[$i]['other']; ?></span></td>
	      </tr>
	      <?php } ?>
	      </tbody>
	  </table>
	</div>
	</div>
	</div>
</div>