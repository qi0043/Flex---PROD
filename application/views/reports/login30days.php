<?php
$count = count($stat_last30days);
$last30days_labels = ''; $last30days_data = '';
for ($i=0; $i<$count; $i++)
{
    $last30days_labels .= '"' . substr($stat_last30days[$i]['date'], 5) . '"';
    if($i<$count-1)
	$last30days_labels .= ',';
    
    $last30days_data .= $stat_last30days[$i]['count'];
    if($i<$count-1)
	$last30days_data .= ',';
}
?>
<script>
		
		var lineChartData_last30days = {
			labels : [<?php echo $last30days_labels;?>],
			datasets : [
				{
					label: "Login in last 30 days",
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
	
	
	
	$( document ).ready( function()
	{
	    var options = {
			    responsive: true
		    };
	    var ctx = $("#login30days_id").get(0).getContext("2d");
	    var myLineChart_last30days = new Chart(ctx).Line(lineChartData_last30days, options);
	}) ;

</script>


<div class="panel panel-default">
	<div class="panel-heading">
	  <h3 class="panel-title"><i class="fa fa-line-chart"></i>&nbsp;FLEX login in last 30 days</h3>
	</div>
	<div class="panel-body">
			<div>
				<canvas id="login30days_id" ></canvas>
			</div>
	</div>
</div>