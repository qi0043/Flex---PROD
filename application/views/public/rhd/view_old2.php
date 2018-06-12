<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<script type="text/javascript" src="<?php echo base_url();?>resource/public/rhd/js/jquery.min.js"></script> 
<script src="<?php echo base_url();?>resource/public/rhd/js/bootstrap.min.js"></script> 
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug --> 
<script src="<?php echo base_url();?>resource/public/rhd/js/ie10-viewport-bug-workaround.js"></script>
<script src="<?php echo base_url();?>resource/public/rhd/js/ie-emulation-modes-warning.js"></script>

<!-- Bootstrap core CSS -->
<link href="<?php echo base_url();?>resource/public/rhd/css/bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>resource/public/rhd/css/bootstrap-theme.min.css" rel="stylesheet" />
<!-- <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">-->
<!-- Custom styles -->
<link href="<?php echo base_url();?>resource/public/rhd/css/flextra-rhd.css" rel="stylesheet" >
<link rel="shortcut icon" href="<?php echo base_url();?>resource/public/rhd/images/favicon.ico"> 
    
<style>
#header {
	background:url(<?php echo base_url() . '/resource/public/rhd/images/header_bg.jpg'; ?>) no-repeat scroll center top white !important;
	background-size:100% 100% !important;
	height:95px;
	border:none;
	z-index:1;
}
#header-inner {
	height:95px;
	background:url(<?php echo base_url() . '/resource/public/rhd/images/rhdlogo.png'; ?>) no-repeat scroll 0 3px transparent;
	width:980px;
	float:left;
	margin:0 auto;
	overflow:hidden;
}
#header-wrap {
	height:80px;
	position: relative;
	width:980px;
	margin: 0 auto;	
}
</style>    

<title>Flinders University - RHD Theses</title>

</head>
<body>

<div id="header" role="banner">
    	<div id="header-wrap">
        	<div id="header-inner">
            	<div class="badge"></div>
                
             </div>
         </div>
</div>
<!--    
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-brand">
      <p class="lead"> <a href="s-home.html"><span class="glyphicon glyphicon-home"  tabindex="1000"></span>DEMO ONLY: RHD Theses - Flinders University</a> </p>
    </div>
  </div>
</nav>-->
<div class="container">
  <div class="row">
    <div class="col-md-9">
    	<div class="row">
    		<div class="col-md-12">
      		<h2 class=""> <?php echo $thesis_name; ?></h2>
                <p><i>Author: </i><?php echo $student_name; ?> </p>
              
              
              <?php if ($restrict_attachments == true) { ?>
                <p><span class="glyphicon glyphicon-file"></span>Thesis download: available for open access on <?php echo $release_date_format; ?>. </p>
              <?php } else { ?> 
                <p><span class="glyphicon glyphicon-file"></span>Thesis download: 
                <?php for($i=0; $i<count($attachments); $i++) { ?>  
                <?php if($attachments[$i]['href']==null || $attachments[$i]['uuid']==$abstract_uuid) continue; ?>
                <a href="<?php echo $attachments[$i]['href'];?>" target="_blank"><?php echo $attachments[$i]['description'];?></a>&lt;<?php echo $attachments[$i]['size'];?>b&gt;&nbsp;
                <?php } ?> 
              <?php } ?> 
                
                <p><?php echo $student_last_name . ', ' . $student_first_name;?>, <?php echo $complete_year; ?> <em><?php echo $thesis_name; ?></em>, <?php echo $publisher; ?></p>
      		<p class="well">This electronic version is made publicly available by Flinders University in accordance with its open access policy for student theses. Copyright in this thesis remains with the author. This thesis may incorporate third party material which has been used by the author pursuant to Fair Dealing exceptions. If you are the owner of any included third party copyright material and/or you believe that any material has been made available without permission of the copyright owner please contact <a href="mailto:copyright@flinders.edu.au">copyright@flinders.edu.au</a> with the details.</p>
        	</div>
      </div>
  <div class="row">
    <div class="col-md-12">
      <h3>Abstract</h3>
       
        <?php for($i=0; $i<count($attachments); $i++) { ?>  
          <?php if($attachments[$i]['uuid']==$abstract_uuid) { ?>
            <p><span class="glyphicon glyphicon-file"></span> Abstract download:
            <a href="<?php echo $attachments[$i]['href'];?>" target="_blank"><?php echo $attachments[$i]['description'];?></a>&lt;<?php echo $attachments[$i]['size'];?>b&gt;
        <?php } } ?>  
      </p>     
      <p> <?php echo $abstract; ?> </p>
      <p> <i>Keywords: </i><?php echo $keyword; ?> <br />
          <i>Subject: </i><?php echo $subject; ?> <br />
      </p>
        
    </div>

  </div>
  
  <div class="row">
      <div class="col-md-12">
        <p> 
          <i>Thesis type: </i><?php echo $thesis_type; ?> <br />
          <i>Completed: </i><?php echo $complete_year; ?> <br />
          <i>School: </i><?php echo $school; ?><br />
          <i>Supervisor: </i><?php echo $supervisor_name; ?> <br />
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <p> <!--<i>Award: </i>Doctor of Philosophy <br />-->
          
        </p>
      </div>
    </div>
    </div>
    
    
   <div class="col-md-3"> <br />
    <br />
    <br />
    <br />
    <br />
    <!--    <div class="list-group"> <a href="#" class="list-group-item list-group-item-default inactive">Search</a> <a href="#" class="list-group-item list-group-item-default active">Simple Search</a> <a href="#" class="list-group-item list-group-item-default active">Advanced Search</a> <a href="#" class="list-group-item list-group-item-default active">Browse</a> </div>
--> </div>
</div>
</div>
<div class="footer" role="footer">
  <hr />
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <p class="text-muted"></p>
      </div>
      <div class="col-md-6">
        <p class="text-muted text-center">Flinders University: RHD Theses</p>
      </div>
      <div class="col-md-3">
        <p class="text-muted text-right"></p>
      </div>
    </div>
  </div>
</div>

</body>
</html>