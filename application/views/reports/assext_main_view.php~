<?php include 'header.php'; ?>

    <div class="container">
	
      <div class="row">
	<h4 class="page-header"><i class="fa fa-files-o"></i>&nbsp;Assignment Extension</h4>
      </div>
      <div class="row">
      
	
	    
        <div class="col-md-9 ">
          
	  <div class="row ">
            
	      <div id="assext_reqcount_school">
		  <div class="panel panel-default">
		    <div class="panel-heading">
		      <h3 class="panel-title"><i class="fa fa-bar-chart"></i>&nbsp;Request count of last year and current year by school</h3>
		    </div>
		    <div class="panel-body">

			    <div>
				    <canvas id="reqcount_school_canvas" ></canvas>
			    </div>
		    </div>
                 </div>
	      </div>
	  </div>    

	    <div class="row ">
            
		<div id="assext_topic_count_school">
                   
		    
		    <div class="panel panel-default">
			<div class="panel-heading">
			  <h3 class="panel-title"><i class="fa fa-file-text-o"></i>&nbsp;Number of Topics with Requests of last year and current year</h3>
			</div>
			<div class="panel-body">
                             
			        
				 <table id="assext_unsend_notification_table" class="table table-striped table-hover" >
				     <thead>
				       <th>School</th>
				       <th>Year</th>
				       <th>Count</th>
				        
				     </thead>
				     <tbody>
					 <?php for($i=0; $i<count($topic_count_school); $i++) { ?>
					 <tr>
					     <td> <?php echo $topic_count_school[$i]['org_name']; ?> </td>
					     <td> <?php echo $topic_count_school[$i]['avail_yr']; ?> </td>
					     <td><span class="badge"><?php echo $topic_count_school[$i]['topic_count']; ?></span></td>
					      
					 </tr>
					 <?php } ?>
				     </tbody>
				 </table>
			      
			     
				 
			</div>
	           </div>
     
                </div> 
           
          </div>  
	    
	    
          <div class="row ">
            
		<div id="assext_daily_notification">
                   
		    
		    <div class="panel panel-default">
			<div class="panel-heading">
			  <h3 class="panel-title"><i class="fa fa-file-text-o"></i>&nbsp;Daily Notifications</h3>
			</div>
			<div class="panel-body">
                             
			        
				 <table id="assext_daily_notification_table" class="table table-striped table-hover" >
				     <thead>
				       <th>Topic and request count</th>
				       <th>Approver Name</th>
				       <th>Email</th>
				       <th>FAN</th>
				     </thead>
				     <tbody>
					 <?php for($i=0; $i<count($daily_notification); $i++) { ?>
					 <tr>
					      
					     <td><?php echo str_replace(',', '<br>', $daily_notification[$i]['topic_list']); ?></td>
					     <td><?php echo $daily_notification[$i]['name']; ?></td>
					     <td><?php echo $daily_notification[$i]['email']; ?></td>
					     <td><?php echo $daily_notification[$i]['fan']; ?></td>
					 </tr>
					 <?php } ?>
				     </tbody>
				 </table>
			      
			     
				 
			</div>
	           </div>
     
                </div> 
           
          </div>
	    
	  <div class="row ">
            
		<div id="assext_unsend_notification">
                   
		    
		    <div class="panel panel-default">
			<div class="panel-heading">
			  <h3 class="panel-title"><i class="fa fa-file-text-o"></i>&nbsp;No Notifications Pending Requests</h3>
			</div>
			<div class="panel-body">
                             
			        
				 <table id="assext_unsend_notification_table" class="table table-striped table-hover" >
				     <thead>
				       <th>Topic and request count</th>
				       <th>Approver Name</th>
				       <th>Email</th>
				       <th>FAN</th>
				     </thead>
				     <tbody>
					 <?php for($i=0; $i<count($unsent_notification); $i++) { ?>
					 <tr>
					     <td><?php echo str_replace(',', '<br>', $unsent_notification[$i]['topic_list']); ?></td>
					     <td><?php echo $unsent_notification[$i]['name']; ?></td>
					     <td><?php echo $unsent_notification[$i]['email']; ?></td>
					     <td><?php echo $unsent_notification[$i]['fan']; ?></td>
					 </tr>
					 <?php } ?>
				     </tbody>
				 </table>
			      
			     
				 
			</div>
	           </div>
     
                </div> 
           
          </div>  
	    
	  <div class="row ">
                
	    
           
          </div>

	 
 
         
	</div>
	
	<div class="col-md-3 ">
	    <div class="col-md-1 ">
		
	    </div>
          <div class="col-md-11 ">
	    <div id="assext_total_by_status">
                   
		    <div class="panel panel-default">
			<div class="panel-heading">
			  <h3 class="panel-title"><i class="fa fa-file-text-o"></i>&nbsp;Total Requests by Status</h3>
			</div>
			<div class="panel-body">
                             
			        
				 <table id="assext_total_by_status_table" class="table table-striped table-hover" >
				     <thead>
				       <th>Status</th>
				       <th>Count</th>
				     </thead>
				     <tbody>
					 <?php for($i=0; $i<count($total_by_status); $i++) { ?>
					 <tr>
					     <td><?php echo $total_by_status[$i]['status']; ?></td>
					     <td><span class="badge"><?php echo $total_by_status[$i]['no_rows']; ?></span></td>
					   
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

<script>
		
	var barChartData_reqcount_school = {
		labels: [<?php echo $reqcount_school_labels;?>],
		datasets: [
		    {
			label: "<?php echo intval(date("Y")) - 1 ;?>",
			fillColor: "rgba(220,220,220,0.5)",
			strokeColor: "rgba(220,220,220,0.8)",
			highlightFill: "rgba(220,220,220,0.75)",
			highlightStroke: "rgba(220,220,220,1)",
			data: [<?php echo $reqcount_school_data[0];?>]
		    },
		    {
			label: "<?php echo intval(date("Y"));?>",
			fillColor: "rgba(151,187,205,0.5)",
			strokeColor: "rgba(151,187,205,0.8)",
			highlightFill: "rgba(151,187,205,0.75)",
			highlightStroke: "rgba(151,187,205,1)",
			data: [<?php echo $reqcount_school_data[1];?>]
		    }
		]
	    };

	$( document ).ready( function(){
	    var options = {
			    responsive: true
		    };
	    var ctx = $("#reqcount_school_canvas").get(0).getContext("2d");
	    var myBarChart_reqcount_school = new Chart(ctx).Bar(barChartData_reqcount_school, options);
	}) ;
</script> 

<?php include 'footer.php'; ?>

