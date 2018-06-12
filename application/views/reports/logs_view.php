<?php include 'header.php'; ?>

    <div class="container">
	
      <div class="row">
	<h4 class="page-header"><i class="fa fa-files-o"></i>&nbsp;FLEX Flextra Logs</h4>
      </div>
      <div class="row">
      
	
	    
        <div class="col-md-10 ">
          

          <div class="row ">
            
		<div id="flextra_log_today">
                   
		    
		    <div class="panel panel-default">
			<div class="panel-heading">
			  <h3 class="panel-title"><i class="fa fa-file-text-o"></i>&nbsp;Flextra log of Today</h3>
			</div>
			<div class="panel-body">
                             
			       <div id="flextra_detail_log_today" style="overflow: auto; height: 450px; border: 1px">
				 <table id="flextra_log_today_table" class="table table-hover" style='font-size:12px'>
				     <thead></thead>
				     <tbody>
					 <tr><td>Logs of today - <?php echo date("D M j T Y"); ?></td></tr>
				     </tbody>
				 </table>
			      </div> 
			     
				 
			</div>
	           </div>

		    
                            
                </div> 
           
          </div>
	    
	   <!--<div class="row ">
            
		<div id="flextra_access_log">
                   
		    
		    <div class="panel panel-default">
			<div class="panel-heading">
			  <h3 class="panel-title"><i class="fa fa-file-text-o"></i>&nbsp;Flextra access log of today</h3>
			</div>
			<div class="panel-body">
                             
			       <div id="flextra_access_log_today" style="overflow: auto; height: 350px; border: 1px">
				 <table id="flextra_access_log_today_table" class="table table-hover" style='font-size:12px'>
				     <thead></thead>
				     <tbody>
					 <tr><td>Access Logs of today - <?php echo date("D M j T Y"); ?></td></tr>
				     </tbody>
				 </table>
			      </div> 
			     
				 
			</div>
	           </div>

		    
                            
                </div> 
           
          </div>-->
	    
	  <div class="row ">
                
	    
           
          </div>

	 
 
         
	</div>
	
	<div class="col-md-2 ">
	    <div class="col-md-3 ">
		
	    </div>
          <div class="col-md-9 ">
	    <div class="row ">
		<a target="_blank" href="<?php echo base_url() . 'reports/reptmain/list_flextra_logs'?>">All Flextra Logs</a>
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

 
<script>
 function nl2br (str, is_xhtml) {
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
 }

  var offset = 0;
  function append_log(){
      $.ajax({
	url: "<?php echo base_url() . 'reports/reptmain/get_flextra_log'?>",
	method: "POST",
	data: {offset: offset},
	success: function(data1,status,request) {
           
           if(data1 != "")
	   {
	       $("#flextra_log_today_table tr:last").after('<tr><td>' + nl2br(data1, '') + '</tr></td>'); 
               //$("#flextra_detail_log_today").scrollTop(999999);
	       $("#flextra_detail_log_today").animate({ 
                                                        scrollTop:  9999999
                                                }, 600); 
	       offset += data1.length;
	   }
	   setTimeout("append_log()", 10000);
	}
      });
  
  }

</script>

<script>
  $(function() {
    append_log();
    
  });
</script>

<script>
  /*
  var access_log_offset = <?php echo $access_log_size; ?>;
  
  $(function() {
     
     setTimeout("append_access_log()", 5000);
  });
  
  function append_access_log(){
      $.ajax({
	url: "get_flextra_access_log",
	method: "POST",
	data: {access_log_offset: access_log_offset},
	success: function(data1,status,request) {

           if(data1 != "")
	   {
	       var lines = data1.split("\n");
	       //console.log(lines);
	       for (i = 0; i < lines.length; i++)  
	       {   
		   //console.log(lines[i]);
		   if(lines[i].indexOf('get_flextra') < 0 &&  lines[i].trim() != "")
		   {
		       $("#flextra_access_log_today_table tr:last").after('<tr><td>' + nl2br(lines[i], '') + '</tr></td>'); 
                       $("#flextra_access_log_today").animate({ 
                                                        scrollTop: $("#flextra_access_log_today").height() 
                                                }, 500); 
		   }
	       }
	   
	       access_log_offset += data1.length;
	   }
	   setTimeout("append_access_log()", 10000);
	}
      });
  
  }
  */
</script>

<?php include 'footer.php'; ?>