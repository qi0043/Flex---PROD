<?php
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
    /*
    if($i == $count - 1)
    {
	$curr_month = intval($stat_monthly[$i]['month']);
	for ($k = $curr_month + 1; $k < 13; $k ++)
	{
	    $monthly_data[$the_year] .= ',0';
	    
	}
    }*/
}
?>
<script>
		
	var barChartData_monthly = {
		labels: ["Jan.", "Feb.", "Mar.", "Apr.", "May", "Jun.", "Jul.","Aug.", "Sep.", "Oct.", "Nov.", "Dec."],
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
		    },
		    {
			label: "<?php echo $year0 + 2;?>",
			fillColor: "rgba(205,121,66,0.5)",
			strokeColor: "rgba(205,121,66,0.8)",
			highlightFill: "rgba(205,121,66,0.75)",
			highlightStroke: "rgba(205,121,66,1)",
			data: [<?php echo $monthly_data[$year0 + 2];?>]
		    }
		]
	    };

	$( document ).ready( function(){
	    var options = {
			    responsive: true
		    };
	    var ctx = $("#login_monthly_canvas").get(0).getContext("2d");
	    var myBarChart_monthly = new Chart(ctx).Bar(barChartData_monthly, options);
	}) ;
</script>

<div class="panel panel-default">
		<div class="panel-heading">
		  <h3 class="panel-title"><i class="fa fa-bar-chart"></i>&nbsp;FLEX login of last two years and current year (left to right)</h3>
		</div>
		<div class="panel-body">

			<div>
				<canvas id="login_monthly_canvas" ></canvas>
			</div>
		</div>
</div>
