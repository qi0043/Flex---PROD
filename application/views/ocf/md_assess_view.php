

<?php if(!isset($_SESSION)){ session_start();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Online Curriculum Framework</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap-theme.css">

<!-- Local styles -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/local.css">
<link href="<?php echo base_url() . 'resource/flo/ocf/';?>css/font-awesome-4.4.0/css/font-awesome.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/tree.css"></link>

<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- Latest compiled and minified JavaScript -->

<script type="text/javascript" src="<?php echo base_url() . 'resource/flo/ocf/';?>js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'resource/flo/ocf/';?>js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo base_url() . 'resource/flo/ocf/';?>js/bootstrap.min.js"></script>   

<script type="text/javascript">
/*  resets the modal ready for it's next use */
$(document).ready(function(){
  $(document).on("hidden.bs.modal", function (e) { $(e.target).removeData("bs.modal").find(".modal-body").empty();$(e.target).removeData("bs.modal").find(".modal-title").empty(); $(".modal-body").html('<p>Loading…</p>'); $(".modal-title").html('Detail');
  });
});
</script>

<script type="text/javascript">

function logoutMsg() {
	
	alert('To log out of the OCF, please close all windows for this browser OR if you are using a Mac quit the browser ');
}

</script>

<script src="<?php echo base_url() . 'resource/ocf/';?>js/smap.js"></script>  

</head>

<body role="document">
<div class="jumbotron">
  <div class="container-fluid">
    <div class="col-md-9 col-sm-12 col-xs-12"> <img src="<?php echo base_url() . 'resource/flo/ocf/';?>images/logo-flinders_portrait.png" width="51" height="65" alt="Flinders University" style="float:left;">
      <div class="banner-text">
        <h2>Browse Assessments</h2>
<?php 
$numCourses = count($_SESSION['ocf_validgrouplist']);
$i = 0;
?>
        <p>Welcome <?php echo $_SESSION['username']; ?><br />
        <span class="small"><em>You have access to the following course<?php if($numCourses > 1) { ?>s<?php } ?>: 
  <?php foreach($_SESSION['ocf_validgrouplist'] as $key=>$value) {
	  $i++;
	  echo strtoupper($value);
	  
	  if($i < $numCourses)  { echo " / "; }
	  
  }?>
        </em></span></p>
      </div>
    </div>
     <div class="col-md-3 col-sm-12 col-xs-12">
<a href="#" onclick="javascript:logoutMsg();" class="btn btn-default btn-xs"><span class="small"><i class="fa fa-power-off"></i>
 <span class="text-uppercase">log out</span></span></a>
    </div>
 

 </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="modal-content-id">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail</h4>
      </div>
      <div class="modal-body">
      <p>Loading…</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid" style="margin:15px 20px 0 20px;">
    <div role="main">
      <div class="row">
          <div class="col-md-7">
            <div class="alert alert-info alert-dissmissable small" role="alert">
            	<div class="row">
                    <p>&nbsp;&nbsp;PROTOTYPE only: The assessment details below displays all the course assessment items by topic availabilities. 
			The data is from the current version of the SAMs and the status of the SAMs is: draft, moderating, rejected, or live (approved).</p>
                </div>
             </div>
           </div>
        
             <div class="col-md-1">
             </div>
         
     </div>
         
         <div id="myNav" class="col-md-12"><a href="/flex/ocf/home/<?php echo strtolower($course['course_code']); ?>" class="btn btn-sm btn-primary">Return to dashboard</a></div>
     </div>
     <div class="row spinner-wave" style="display:none; position:fixed;top:30%; left:40%;z-index:100; overflow:auto">
            <div style="z-index:100;"></div>
            <div style="z-index:100;"></div>
            <div style="z-index:100;"></div>
            <div style="z-index:100;"></div>
            <div style="z-index:100;"></div>
            <p style="z-index:100;" id="txt_loading">&nbsp;Loading...</p>
     </div>
 <div class="row">
 
 <div class="col-md-12 col-sm-12 tree">
 
            <?php if (in_array(strtolower($course['course_code']), $_SESSION['ocf_validgrouplist'])) { ?>            
            
              
            <ul>
	      <li><span><i class='fa fa-plus-circle'></i>&nbsp;MD 2016</span>
	        <ul>
		    <?php $sam_count = count($sam_array); ?> 

		    <?php for($i=0; $i<$sam_count; $i++) {?> 
			<?php 
			$sam = $sam_array[$i];
			if($sam['status']=='moderating') $status_cls = 'badge alert-info';
			else if($sam['status']=='live') $status_cls = 'badge alert-success';
			else $status_cls = 'badge';?>

			<li> <span><i class='fa fa-plus-circle'></i> <?php echo $sam['name']; ?> </span>
			&nbsp;<div class='<?php echo $status_cls; ?>'>  <?php echo $sam['status']; ?> </div>
			<?php #$tree_string .= '&nbsp;<a href="' . $institute_url . 'items/' . $sam['uuid'] . '/' . $sam['version'] . '/" target="_blank">Link to FLEX</a>';?>

			<ul>
			<?php for($j=0; $j<count($sam['aitems']); $j++){?> 

			    <li> <span><i class='fa fa-plus-circle'></i> <?php echo $sam['aitems'][$j]['name'];?>  </span> 
			    <ul>
				 <li><b>Proportion:&nbsp;</b>  <div class='text-info'><?php if(isset($sam['aitems'][$j]['proportion'])) echo $sam['aitems'][$j]['proportion'];?> </div>
				 <li><b>Format:&nbsp;</b> <div class='text-info'><?php if(isset($sam['aitems'][$j]['format'])) echo $sam['aitems'][$j]['format'];?> </div>
				 <li><b>Deadline:&nbsp;</b>  <div class='text-info'><?php if(isset($sam['aitems'][$j]['deadline'])) echo $sam['aitems'][$j]['deadline'];?> </div>
				 <li><b>Penalties:&nbsp;</b>  <div class='text-info'><?php if(isset($sam['aitems'][$j]['penalties'])) echo $sam['aitems'][$j]['penalties'];?> </div>

			   </ul>
			<?php }?>
			</ul>
		    <?php }?>
	    
	        </ul>
	    </ul>
	    
                 
         <?php } // in a valid group list 
		 
		 else  { //not valid ?>
        <h4 class="text-danger">Access denied </h4>
  <p>Your access does not grant you permission to view this course curriculum.</p>
  <p>Please choose a different course.</p>
         
         <?php }  ?>   
         
         
      </div>
 

 </div> <!-- end map row -->          

            
         
      
        </div>
     </div>
</div>
</body>
</html>