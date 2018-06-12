<?php /*?><?php include_once('includes/language.php'); ?><?php */?>
<?php include_once('includes/language.php'); ?>
<?php if(!isset($_SESSION)){ session_start();} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>OCF - Choose Course</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/bootstrap.css">
    
    <!-- Optional theme -->
    <link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/bootstrap-theme.css">
    
    <!-- Local styles -->
    <link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/local.css">   
    <script src="<?php echo base_url() . 'resource/ocf/';?>js/jquery-1.10.2.min.js"></script>
    <script src="<?php echo base_url() . 'resource/ocf/';?>js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?php echo base_url() . 'resource/ocf/';?>js/bootstrap.js"></script>  
    <link href="<?php echo base_url() . 'resource/ocf/';?>css/font-awesome-4.2.0/css/font-awesome.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        <!--
            @media print {
                
              a[href]:after {
                content: "";
              }
            }
        -->
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
        
            $(".dropdown-toggle").dropdown();
        
        });  
    </script>
</head>

<body role="document">
<div class="jumbotron">
  <div class="container-fluid">
    <div class="col-md-9 col-sm-12 col-xs-12"> <img src="<?php echo base_url() . 'resource/ocf/';?>images/logo-flinders_portrait.png" width="51" height="65" alt="Flinders University" style="float:left;">
      <div class="banner-text">
        <h2>Curriculum Framework - Pilot</h2>
        <p>Welcome <?php echo $_SESSION['username']; ?><br /><span class="small"><em>Your group membership grants access to the following course(s): 
  <?php foreach($_SESSION['ocf_validgrouplist'] as $key=>$value) {
	  echo strtoupper($value) . " / " ;
	  
  }?>
        </em></span></p>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid" style="margin:15px 20px 0 20px; min-height:700px;">

<div role="main">

  <div class="row">
    <div class="col-md-6 col-xs-12">
      
  <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Courses</h3>
    <p>Choose a course to view framework</p>
  </div>
<div class="panel-body">
        
         <ul>
            
            <?php foreach ($courses as $course) { ?>
             <?php if (in_array(strtolower($course['code']), $_SESSION['ocf_validgrouplist'])) { ?>
                <li><a href="/flex/ocf/home/<?php echo strtolower($course['code']); ?>"><?php echo $course['code']; ?> :: <?php echo $course['coursetitle']; ?></a></li>
                <?php } ?>
                <?php } ?>
            </ul>
            

        </div>
</div>


  
</div>
</div>
</div>
</div>
</div>



</div>

</div>


</body>
</html>
