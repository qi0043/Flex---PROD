<?php include 'header.php'; ?>

<style>
.modal {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .1 ) 
		url(" <?php echo base_url();?>resource/reports/image/ajax-loader.gif") 
                50% 50% 
                no-repeat;
}
body.loading {
    overflow: hidden;   
}
body.loading .modal {
    display: block;
}

</style>
    <div class="container">
	
      <div class="row">
	<h4 class="page-header"><i class="fa fa-files-o"></i>&nbsp;Administration Tools</h4>
      </div>
      <div class="row">
      
	
	    
        <div class="col-md-10 ">
          

          <div class="row ">
            
		<div id="flextra_log_today">
                   
		    
		    <div class="panel panel-default">
			<div class="panel-heading">
			  <h3 class="panel-title"><i class="fa fa-file-text-o"></i>&nbsp;Export eReadings from FLEX</h3>
			</div>
			<div class="panel-body">
                             
			      <div >
				 This function is used to export eReadings from FLEX into a csv file, then import to Flextra. <br><br>
				 
				 This is used when the daily CRON job to populate eReadings failed, or for urgent eReading requests 
				 in which case the eReadings are wanted immediately.<br><br>
				 <ol>
				 <li>Click on left button to export the eReadings into a csv file. 
				 <li>Check file: ex_daily_ereadings_prod.csv  in \\flextra.flinders.edu.au\working\DailyImports\Prod\ . Confirm the files is larger than 50M.
				 <li>If the file is ok then click the right button to import the csv data into Flexta DB.
				 </ol>
				 <br>
				 
			      </div> 
			    
			    <div class="col-md-3 ">
			    <button class='btn btn-primary' id='export_ereadings_btn' onclick = 'javascript:export_ereadings_btn_clicked();'>
				Export eReadings from FLEX
			    </button>
			    </div>
			    
			    <div class="col-md-3 ">
			    </div>
			    
			    <div class="col-md-3 ">
			    <button class='btn btn-primary' id='export_ereadings_btn' onclick = 'javascript:import_ereadings_btn_clicked();'>
				Import eReadings on Flextra
			    </button>
			    </div>
			    
			    <div class="col-md-3 ">
			    </div>
			    
			</div>
	           </div>

		    
                            
                </div> 
           
          </div>
	    
	    <br>
	    <div class="row ">
            
		<div id="flextra_log_today">
                   
		    
		    <div class="panel panel-default">
			<div class="panel-heading">
			  <h3 class="panel-title"><i class="fa fa-file-text-o"></i>&nbsp;Update SAMs taxonomy</h3>
			</div>
			<div class="panel-body">
                             
			      <div >
				 This function is used to update taxonomy data: Flextra ---> FLEX. <br><br>
				 
				 This is used when the daily CRON job to update taxonomy failed, or for urgent topic requests 
				 in which case the taxonomy are wanted immediately.<br><br>
				 
				 <a target="_blank" href="<?php echo base_url() . 'taxonomy/uploadTaxonomy/updateTaxonomy/topics_taxonomy';?>"> Update Topic Taxonomy</a><br><br>
				 <a target="_blank" href="<?php echo base_url() . 'taxonomy/uploadTaxonomy/updateTaxonomy/avails_taxonomy';?>"> Update Availability Taxonomy</a>
			      </div> 
			    
			   
			    
			</div>
	           </div>

		    
                            
                </div> 
           
          </div>
	    
	    
	  <div class="row ">
                
	    
           
          </div>

	 
 
         
	</div>
	
	
	
     </div> 
    </div>

 
<script>
 function export_ereadings_btn_clicked () {
    
    //$("#export_ereadings_btn").prop('disabled', true);
    if(confirm("Are you sure you want to export eReadings?") == false)
    {
	return;
    }
    $.ajax({
	url: "<?php echo base_url();?>reports/reptmain/export_ereadings_download",
	method: "GET",
	
	success: function(data,status,request) {
             //document.location.href = "<?php echo base_url();?>reports/reptmain/export_ereadings_download";
	     //alert('Task Finished! Check csv file to verify.');
	     if(data == "")
	     {
		 data = "Failed!"
	     }
	     alert(data);
	},
	error: function (xhr, ajaxOptions, thrownError) {
            alert('Failed: ' + xhr.status + thrownError);
            //alert(thrownError);
        }	
      });
 }

 function import_ereadings_btn_clicked () {
    
    //$("#export_ereadings_btn").prop('disabled', true);
    if(confirm("Are you sure you want to import eReadings?") == false)
    {
	return;
    }
    $.ajax({
	url: "<?php echo base_url();?>reports/reptmain/import_ereadings_flextra",
	method: "GET",
	
	success: function(data,status,request) {
             //document.location.href = "<?php echo base_url();?>reports/reptmain/export_ereadings_download";
	     if(data == "")
	     {
		 data = "Failed!"
	     }
	     alert(data);
	     //alert('Task Finished! Check database to verify.')
	},
	error: function (xhr, ajaxOptions, thrownError) {
            alert('Failed: ' + xhr.status + thrownError);
            //alert(thrownError);
        }	
      });
 } 

</script>

<script>
  $(function() {
    
    
  });
</script>
<script type="text/javascript">
  $body = $("body");

  $(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
  });
</script>
<div class="modal"><!-- Place at bottom of page --></div>

<?php include 'footer.php'; ?>