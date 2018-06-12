<?php
$count = count($login_hour);
$login_hour_labels = ''; $login_hour_data = '';
for ($i=0; $i<$count; $i++)
{
    $login_hour_labels .= '"' . $login_hour[$i]['time_hour'] . '"';
    if($i<$count-1)
	$login_hour_labels .= ',';
    
    $login_hour_data .= $login_hour[$i]['total_logins'];
    if($i<$count-1)
	$login_hour_data .= ',';
}
?>
<script>
		
		var lineChartData_loginhour = {
			labels : [<?php echo $login_hour_labels;?>],
			datasets : [
				{
					label: "Login by Hours",
					fillColor : "rgba(220,220,220,0.2)",
					//strokeColor : "rgba(255,126,40,1)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					pointHighlightFill : "#fff",
					pointHighlightStroke : "rgba(220,220,220,1)",
					data : [<?php echo $login_hour_data;?>]
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
	    var ctx = $("#login_hour_id").get(0).getContext("2d");
	    var myLineChart_loginhour = new Chart(ctx).Line(lineChartData_loginhour, options);
	}) ;

</script>


<div class="panel panel-default">
	<div class="panel-heading">
	  <h3 class="panel-title"><i class="fa fa-line-chart"></i>&nbsp;FLEX login by Hour </h3>
	</div>
	<div class="panel-body">
			<div>
				<canvas id="login_hour_id" ></canvas>
			</div>
	</div>
</div>