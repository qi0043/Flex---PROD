<?php include 'header.php'; ?>

    <div class="container">
	
      <div class="row">
	<h4 class="page-header"><i class="fa fa-files-o"></i>&nbsp;Flextra Logs</h4>
      </div>
      <div class="row">
      
	
	    
        <div class="col-md-9">
          

          <div class="row ">
            
		<div id="all_flextra_logs">
                   
		    
		     
			       <table id="all_flextra_logs" class="table table-striped table-hover" >
				     <thead>
				       <th>Flextra logs</th>
				       <th>Size (bytes)</th>
			 
				     </thead>
				     <tbody>
					 <?php for($i=0; $i<count($files1); $i++) { ?>
					 <?php if(strpos($files1[$i]['name'], '.php') !== false)  { ?>
					 <tr>

					     <td><i class="fa fa-file-text-o" style="color: black;">&nbsp;&nbsp;<a href="view_flextra_log_file?filename=<?php echo $files1[$i]['name'] ; ?>" target="_blank"><?php echo $files1[$i]['name'] ; ?></td>
					     <td><?php echo $files1[$i]['size'] ; ?></td>
					 </tr>
					 <?php } ?>
					 <?php } ?>
				     </tbody>
				 </table>
			     
				 

                </div> 
           
          </div>
	    
	  <div class="row ">
                
	    
           
          </div>

	 
 
         
	</div>
	
	<div class="col-md-3 ">
	    <div class="col-md-3 ">
		
	    </div>
          <div class="col-md-9 ">
	    <div class="row ">
		<a target="_blank" href="list_flextra_logs">All Flextra Logs</a>
	    </div>
	    <br>
	    <div class="row ">
		
		<a target="_blank" href="<?php echo $flex_res_log_link; ?>">FLEX Logs</a>
		<br><br>Copy 'FLEX Logs' link and paste in windows explorer or browser address bar to open.<br>
	    </div>
	  </div>
	</div>
	
     </div> 
    </div>

 

<?php include 'footer.php'; ?>