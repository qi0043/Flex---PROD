<?php /*?><?php include_once('includes/language.php'); ?><?php */?>
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
<div class="container-fluid"><img src="<?php echo base_url() . 'resource/ocf/';?>images/flinders_logo.png" width="151" height="65" alt="Flinders University"></div>
</div>

<div class="container-fluid" style="margin:0 20px 0 20px; min-height:700px;">

<div role="main">
  <div class="page-header">
    <h2>Flinders University Curriculum Framework - Pilot v.1</h2>
  </div>
  <div class="row">
  <div class="col-md-6">

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Courses</h3>
    <p>Choose a course to view framwework (drop-down menu)</p>
  </div>
  <div class="panel-body">
 <!--Primary buttons with dropdown menu-->
        <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" style="padding-left: 20px; padding-right: 20px;">OCF Courses&nbsp;&nbsp;<span class="caret"></span></button>
            <ul class="dropdown-menu">
            
            <?php foreach ($courses as $course) { ?>
                <li><a href="/flex/ocf/home/<?php echo strtolower($course['code']); ?>"><?php echo $course['code']; ?> :: <?php echo $course['coursetitle']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
  </div>
</div>
</div>
<div class="col-md-6">

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Courses</h3>
    <p>Choose a course to view framwework (unordered list)</p>
  </div>
<div class="panel-body">
        

            <ul>
            
            <?php foreach ($courses as $course) { ?>
                <li><a href="/flex/ocf/home/<?php echo strtolower($course['code']); ?>"><?php echo $course['code']; ?> :: <?php echo $course['coursetitle']; ?></a></li>
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
