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

<title><?php echo $title; ?></title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap-theme.css">


<!-- Local styles -->

<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/local.css">

    
<script src="<?php echo base_url() . 'resource/flo/ocf/';?>js/jquery-1.10.2.min.js"></script>


<script src="<?php echo base_url() . 'resource/flo/ocf/';?>js/jquery-ui-1.10.3.custom.min.js"></script>


<script src="<?php echo base_url() . 'resource/flo/ocf/';?>js/bootstrap.js"></script>  


<link href="<?php echo base_url() . 'resource/flo/ocf/';?>css/font-awesome-4.2.0/css/font-awesome.css" rel="stylesheet" type="text/css">

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
<script type="text/javascript">

function logoutMsg() {
	
	alert('To log out of the OCF, please close all windows for this browser OR if you are using a Mac quit the browser ');
}

</script>


</head>
<body role="document">
<div class="jumbotron">
  <div class="container-fluid">
    <div class="col-md-9 col-sm-12 col-xs-12"> <img src="<?php echo base_url() . 'resource/flo/ocf/';?>images/logo-flinders_portrait.png" width="51" height="65" alt="Flinders University" style="float:left;">
      <div class="banner-text">
        <h2><?php echo strtoupper($courses['code']); ?> Curriculum Framework</h2>
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
      <!-- framework chooser here  ->
                        <!--Primary buttons with dropdown menu-->
      <div class="btn-group" style="margin-top:2px;">
        <button data-toggle="dropdown" class="btn btn-default btn-xs dropdown-toggle" style="padding-left: 5px; padding-right: 5px;">Change OCF Course&nbsp;&nbsp;<span class="caret"></span></button>
        <ul class="dropdown-menu">
          <?php foreach ($ocfcourses as $ocf) { ?>
          <?php if (in_array(strtolower($ocf['code']), $_SESSION['ocf_validgrouplist'])) { ?>
          <li><a href="/flex/ocf/home/<?php echo strtolower($ocf['code']); ?>"><?php echo $ocf['code']; ?> :: <?php echo $ocf['coursetitle']; ?></a></li>
          <?php } ?>
          <?php } ?>
        </ul>
      </div>
      
      <a href="#" onClick="javascript:logoutMsg();" class="btn btn-default btn-xs"><span class="small"><i class="fa fa-power-off"></i>
 <span class="text-uppercase">log out</span></span></a>
      
    </div>
  </div>
</div>
<div class="container-fluid" style="margin:20px 20px 0 20px;">
        
<?php if ((in_array(strtolower($courseCode), $_SESSION['ocf_validgrouplist']))) { ?>        
        
        <div class="row equal">
        
       <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"> Topic Reports</h3>
                    </div>
                    <div class="panel-body">
        <!--Primary buttons with dropdown menu-->
                        <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" style="padding-left: 20px; padding-right: 20px; margin-bottom:10px;">Topic Summary&nbsp;<span class="caret"></span></button>
                            <ul class="dropdown-menu"> 
                                <?php foreach ($topics as $topic) { ?>
                                <li><a href="/flex/ocf/<?php echo $courseCode; ?>/summary/<?php echo $topic['uuid']; ?>/<?php echo $topic['version']; ?>"><?php echo $topic['code']; ?> :: <?php echo $topic['title']; ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>            
                    
                    
                    <!--Primary buttons with dropdown menu-->
                        <div class="btn-group">
                          <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" style="padding-left: 20px; padding-right: 20px; margin-bottom:10px;">Topic Alignment&nbsp;&nbsp;<span class="caret"></span></button>
                            <ul class="dropdown-menu"> 
                            <?php foreach ($topics as $topic) { ?>
                             
                                  <li><a href="/flex/ocf/<?php echo $courseCode; ?>/topic/<?php echo $topic['uuid']; ?>/<?php echo $topic['version']; ?>"><?php echo $topic['code']; ?> :: <?php echo $topic['title']; ?></a></li>
                               
                                <?php } ?>
                            </ul>
                        </div>
<?php /*?><?php if ($courses['code'] == "md") { ?>                                       
                    <p class="text-danger"><strong>Currently this section is 2015 data only</strong></p>    <?php } ?><?php */?>
                  </div>
                </div>
                
                
            </div>
        
        
        
        
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    <h3 class="panel-title">Learning Outcomes Maps</h3>
                    </div>
                    <div class="panel-body">
                        <ul>
                        <?php if (!(empty($coursestring))) { ?>
                            <li><a href="/flex/ocf/<?php echo $courseCode; ?>/fmgo"><?php echo $coursestringlong; ?></a></li>
                            <?php } ?>
                            <li><a href="/flex/ocf/<?php echo $courseCode; ?>/amcgo"><?php echo $profstringlong; ?></a></li>
                        </ul>
<?php /*?><?php if ($courses['code'] == "md") { ?>                                       
                    <p class="text-danger"><strong>Currently this section is 2015 data only</strong></p>    <?php } ?> <?php */?> 
                    </div>
                </div>
            </div> 

        
        
          
        <div class="col-md-4 col-sm-12 col-xs-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Learning Activities Maps</h3>
                    </div>
                    <div class="panel-body">
                        <p><a class="btn btn-success" href="/flex/ocf/sMap/getStaticMap/<?php echo strtolower($courseCode); ?>">Browse course activities</a> <b> &nbsp;&nbsp; MD staff</b> (first release)</p>
                        <?php /*?><ul>
                            <li><a href="/flex/ocf/maptest/getTopics/<?php echo strtolower($courseCode); ?>">Dynamic Map v0.2</a> <b> &nbsp;&nbsp; OCF team only </b></li>
                        </ul><?php */?>
                    </div>
                </div>
            </div>
	</div>

        <?php if(strtolower($courseCode) == 'md'){ ?> 
	   <div class="row equal">
	     <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">CADMS: Assessment Maps</h3>
                    </div>
                    <div class="panel-body">
                        <p><a class="btn btn-success" href="/flex/ocf/sMap/getMdAssessMap/<?php echo strtolower($courseCode); ?>">Browse course assessment</a> <b> &nbsp; MD staff &nbsp;<i>prototype</i></b> </p>
                        <br>
                    </div>
                </div>
              </div>
	       <div class="col-md-4 col-sm-12 col-xs-12">
		   
	       </div>
	       <div class="col-md-4 col-sm-12 col-xs-12">
		   
	       </div>
	    </div>
        <?php } ?>

        <?php } else { ?>
<div class="row">
  <h4 class="text-danger">Access denied </h4>
  <p>Your access does not grant you permission to view this course curriculum.</p>
  <p>Please choose a different course.</p>
</div>
<?php } ?>
   
    </div>

</div>


</body>
</html>
