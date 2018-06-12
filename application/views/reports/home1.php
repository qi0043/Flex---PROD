<?php
include 'header.php';

/*$count = count($stat_monthly);
$monthly_labels = ''; $monthly_data = '';
for ($i=0; $i<$count; $i++)
{
    $monthly_labels .= '"' . $stat_monthly[$i]['year'] . '-' . $stat_monthly[$i]['month'] . '"';
    if($i<$count-1)
	$monthly_labels .= ',';
    
    $monthly_data .= $stat_monthly[$i]['count'];
    if($i<$count-1)
	$monthly_data .= ',';
}*/

$count = count($stat_monthly);
$year0 = intval($stat_monthly[0]['year']);

$monthly_labels = array(); $monthly_data = array();
for ($i=0; $i<$count; $i++)
{
    $the_year = $stat_monthly[$i]['year'];
    if(!isset($monthly_labels[$the_year]))
        $monthly_labels[$the_year] = "";
    $monthly_labels[$the_year] .= '"' . $stat_monthly[$i]['year'] . '-' . $stat_monthly[$i]['month'] . '"';
    if($i<$count-1)
	$monthly_labels[$the_year] .= ',';
    
    if(!isset($monthly_data[$the_year]))
        $monthly_data[$the_year] = "";
    $monthly_data[$the_year] .= $stat_monthly[$i]['count'];
    if($i<$count-1)
	$monthly_data[$the_year] .= ',';
}

$count = count($stat_last30days);
$last30days_labels = ''; $last30days_data = '';
for ($i=0; $i<$count; $i++)
{
    $last30days_labels .= '"' . $stat_last30days[$i]['date'] . '"';
    if($i<$count-1)
	$last30days_labels .= ',';
    
    $last30days_data .= $stat_last30days[$i]['count'];
    if($i<$count-1)
	$last30days_data .= ',';
}
#echo $labels;
?>

<script>
		
		var lineChartData_last30days = {
			labels : [<?php echo $last30days_labels;?>],
			datasets : [
				{
					label: "My First dataset",
					fillColor : "rgba(220,220,220,0.2)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : [<?php echo $last30days_data;?>]
				}
			]

		}

	/*window.onload = function(){
		var ctx = document.getElementById("login30days").getContext("2d");
		window.myLine = new Chart(ctx).Line(lineChartData, {
			responsive: true
		});
	}*/
	
	
	
	$( document ).ready( function(){
	    var options = {
			    responsive: true
		    };
	    var ctx = $("#login30days").get(0).getContext("2d");
	    var myLineChart_last30days = new Chart(ctx).Line(lineChartData_last30days, options);
	}) ;

</script>

<script>
		
	var barChartData_monthly = {
		labels: ["January", "February", "March", "April", "May", "June", "July","August", "September", "October", "November", "December"],
		datasets: [
		    {
			label: "<?php echo $year0;?>",
			fillColor: "rgba(220,220,220,0.5)",
			strokeColor: "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data: [<?php echo $monthly_data[$year0];?>]
		    },
		    {
			label: "<?php echo $year0 + 1;?>",
			fillColor: "rgba(151,187,205,0.5)",
			strokeColor: "rgba(151,187,205,0.8)",
			highlightFill: "rgba(151,187,205,0.75)",
			highlightStroke: "rgba(151,187,205,1)",
			data: [<?php echo $monthly_data[$year0 + 1];?>]
		    }
		]
	    };

	$( document ).ready( function(){
	    var options = {
			    responsive: true
		    };
	    var ctx = $("#login_monthly").get(0).getContext("2d");
	    var myBarChart_monthly = new Chart(ctx).Bar(barChartData_monthly, options);
	}) ;
</script>

<script>
		//var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
	/*	var lineChartData_monthly = {
			labels : [<?php echo $monthly_labels;?>],
			datasets : [
				{
					label: "My First dataset",
					fillColor : "rgba(220,220,220,0.2)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : [<?php echo $monthly_data;?>]
				}
			]

		}


	$( document ).ready( function(){
	    var options = {
			    responsive: true
		    };
	    var ctx = $("#login_monthly").get(0).getContext("2d");
	    var myLineChart_monthly = new Chart(ctx).Line(lineChartData_monthly, options);
	}) ;*/
</script>


	
<div class="jumbotron">
  <div class="container">
    <h1></h1>
  </div>
</div>
<div class="container">
    
<div class="row">
  <div class="col-md-8">
    <div class="panel panel-default">
	<div class="panel-heading">
	  <h3 class="panel-title">FLEX login in last 30 days.</h3>
	</div>
	<div class="panel-body">
			<div>
				<canvas id="login30days" ></canvas>
			</div>
	</div>
    </div>
      
  </div>
  <div class="col-md-4">

  </div>
</div>
    
<div class="row">
  <div class="col-md-8">
    <div class="panel panel-default">
	<div class="panel-heading">
	  <h3 class="panel-title">FLEX login of last year and current year.</h3>
	</div>
	<div class="panel-body">
	
			<div>
				<canvas id="login_monthly" ></canvas>
			</div>
	</div>
    </div>
        
  </div>
  <div class="col-md-4">
    
 
  </div>
</div>
    
<div class="row">
    <div class="col-md-9">
	<div class="panel panel-default">
	<div class="panel-heading">
	  <h3 class="panel-title">Flextra daily CRON jobs.</h3>
	</div>
	<div class="panel-body"> 
	 
	<div class="table-responsive">
	      <table class="table table-striped table-hover">
              <thead>
	      <tr>
		  <th>Task</th>
		  <th>Time</th>
		  <th>Status</th>
		  <th>Details</th>
	      </tr>
	      </thead>
	      <tbody>
	      <?php for($i=0; $i<count($daily_import); $i++) { ?>
	      <tr>
		  <td><?php echo $daily_import[$i]['import_name']; ?></td> 
		  <td><?php echo $daily_import[$i]['imported_on']; ?></td>
		  <td><?php if($daily_import[$i]['status'] == 'S') { ?>
		      <span class="label label-success">Success</span>
		  <?php } else { ?>
		      <span class="label label-danger">Error</span>
		  <?php } ?>
		  </td> 
		  <td><?php echo $daily_import[$i]['message']; ?></td>
	      </tr>
	      <?php } ?>
	      </tbody>
	  </table>
	</div>
	</div>
	</div>
    </div>
    <div class="col-md-3">
    
    </div>
</div>
    

<div class="row">
    <div class="col-md-9">
	<div class="panel panel-default">
	<div class="panel-heading">
	  <h3 class="panel-title">FLEX Collections</h3>
	</div>
	<div class="panel-body"> 
	 
	<div class="table-responsive">
	      <table class="table table-striped table-hover">
              <thead>
	      <tr>
		  <th>Collection</th>
		  <th>Items</th>
	      </tr>
	      </thead>
	      <tbody>
	      <?php for($i=0; $i<count($collections); $i++) { ?>
	      <tr>
		  <td><?php echo $collections[$i]['name']; ?></td> 
		  <td><?php echo $collections[$i]['count']; ?></td>
	      </tr>
	      <?php } ?>
	      </tbody>
	  </table>
	</div>
	</div>
	</div>
    </div>
    <div class="col-md-3">
    
    </div>
</div>    
    
    
<script>
  $(function() {
    $.repeat(3000, function() {
      $.get('get_flextra_log', function(data) {
        $('#flextra_log').append(data);
      });
    });
  });
</script>
<div class="row">
  <div class="col-md-8">
    <div class="panel panel-default">
	<div class="panel-heading">
	  <h3 class="panel-title">Flextra Log of today</h3>
	</div>
	<div class="panel-body">
	
			<div style="height: 200px" id="flextra_log">
				
			</div>
	</div>
    </div>
        
  </div>
  <div class="col-md-4">
    
 
  </div>
</div>    
    
</div>
<!-- /container --> 

<?php
include 'footer.php';

?>