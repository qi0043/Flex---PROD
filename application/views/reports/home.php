<?php include 'header.php'; ?>

    <div class="container">
	
      <div class="row">
	<h4 class="page-header"><i class="fa fa-dashboard"></i>&nbsp;FLEX Flextra Statistics</h4>
      </div>
	
      <!--<div class="row">
	  <div class="col-md-12">
                <div id="daily_import">
                   <i class="fa fa-2x fa-spinner fa-pulse"></i>
                            
                </div> 
	  </div>
      </div>-->
	
      <div class="row">
        
        <div class="col-md-8 ">
          <div class="col-md-11 ">

          <div class="row ">
            
		<div id="login30days">
                   <i class="fa fa-2x fa-spinner fa-pulse"></i>
                            
                </div> 
           
          </div>
	    
	  <div class="row ">
                <div id="login_monthly">
                   <i class="fa fa-2x fa-spinner fa-pulse"></i>
                            
                </div> 
	    
           
          </div>

	  <div class="row ">
            
		<div id="login_hour">
                   <i class="fa fa-2x fa-spinner fa-pulse"></i>
                            
                </div> 
           
          </div>
 
         </div>
	</div>
	
	
	<div class="col-md-4">
	     
	   <div class="row ">
                <div id="flextra_links">
                    <?php include 'flextra_apps_view.php'; ?>
                            
                </div> 
	    
           
           </div>
	    
	    <div class="row ">
                <div id="collection_counts">
                   <i class="fa fa-2x fa-spinner fa-pulse"></i>
                            
                </div> 
	    
           
           </div>
	
	</div>
	
      
    </div>
    </div>


<script>
$(document).ready(function(){
  $.ajax({
    url: "<?php echo base_url();?>/reports/reptmain/get_login30days",
    method: "GET",
    success: function(data,status,request) {
 
       $('#login30days').html(data);
    }
  });
});
</script>
<script>
$(document).ready(function(){
  $.ajax({
    url: "<?php echo base_url();?>/reports/reptmain/get_login_monthly",
    method: "GET",
    success: function(data,status,request) {
        //$('#login_monthly_spin').removeClass( "fa fa-spinner fa-pulse fa-3x" ); 
        //var script1 = document.createElement( 'script' );
	//script1.type = 'text/javascript';
	//script1.src = data;
	//$("body").append( script1 );
	$('#login_monthly').html(data);
    }
  });
});
</script>

<script>
$(document).ready(function(){
  $.ajax({
    url: "<?php echo base_url();?>/reports/reptmain/get_collection_counts",
    method: "GET",
    success: function(data,status,request) {
        //$('#login_monthly_spin').removeClass( "fa fa-spinner fa-pulse fa-3x" ); 
        //var script1 = document.createElement( 'script' );
	//script1.type = 'text/javascript';
	//script1.src = data;
	//$("body").append( script1 );
	$('#collection_counts').html(data);
    }
  });
});
</script>

<script>
$(document).ready(function(){
  $.ajax({
    url: "<?php echo base_url();?>/reports/reptmain/get_login_hour",
    method: "GET",
    success: function(data,status,request) {
 
       $('#login_hour').html(data);
    }
  });
});
</script>
<!--<script>
$(document).ready(function(){
  $.ajax({
    url: "<?php echo base_url();?>/reports/reptmain/get_daily_import",
    method: "GET",
    success: function(data,status,request) {
        //$('#login_monthly_spin').removeClass( "fa fa-spinner fa-pulse fa-3x" ); 
        //var script1 = document.createElement( 'script' );
	//script1.type = 'text/javascript';
	//script1.src = data;
	//$("body").append( script1 );
	$('#daily_import').html(data);
    }
  });
});
</script>-->

<?php include 'footer.php'; ?>