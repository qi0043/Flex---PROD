<?php include_once('includes/language.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title><?php echo $title; ?>::<?php echo $coursestring; ?> - <?php echo $topics[1]['catName']; ?> - <?php echo $topics[1]['locode']; ?></title>

<!-- Latest compiled and minified CSS-->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/bootstrap.css"> 

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/bootstrap-theme.css">

<!-- Local styles -->

<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/local.css">



<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->



<!-- Latest compiled and minified JavaScript  -->
 
    
<script type="text/javascript" src="<?php echo base_url() . 'resource/ocf/';?>js/jquery-1.10.2.min.js"></script>

<script type="text/javascript" src="<?php echo base_url() . 'resource/ocf/';?>js/jquery-ui-1.10.3.custom.min.js"></script>



<script src="<?php echo base_url() . 'resource/ocf/';?>js/bootstrap.js"></script>  

<link href="<?php echo base_url() . 'resource/ocf/';?>css/font-awesome-4.2.0/css/font-awesome.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--

.heatmap:hover {
	cursor:default;

}

@media print {
	
  a[href]:after {
    content: "";
  }
  
  .doNotPrint {
	  
	  visibility: hidden;
	  display: none;
	  
	  
  }
  

#myNav {
	display:none;
	visibility:hidden;
	
} 



}
-->
</style>

<script type="text/javascript">




$(document).on("hidden.bs.modal", function (e) { $(e.target).removeData("bs.modal").find(".modal-content").empty(); });


</script>

 <script type="text/javascript">

$(document).ready(function(){

        $('.heatmap').tooltip({
    	'placement': 'top' });


});  

$(document).ready(function(){

        $('.btn-sm').tooltip({
    	'placement': 'top' });

});

 </script>   
    
</head>
<body role="document">


<div class="jumbotron">
<div class="container-fluid"><img src="<?php echo base_url() . 'resource/ocf/';?>images/flinders_logo.png" width="151" height="65" alt="Flinders University"></div>
</div>

<div class="container-fluid" style="margin:0 20px 0 20px;">

<div role="main">
  <div class="page-header">
    <h2>Flinders University <?php echo strtoupper($courses['code']); ?> Curriculum Framework - Pilot v.1</h2>
  </div>
  <div class="row">


<div id="myNav"><a href="<?php echo base_url() . 'ocf/home/' . $courses['code'] ?>" class="btn btn-sm btn-primary">Return to dashboard</a>&nbsp;&nbsp;<a href="/flex/ocf/<?php echo $courses['code']; ?>/fmgo" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="<?php echo $coursestringlong; ?>"><?php echo $coursestring; ?></a>&nbsp;&nbsp;<a href="/flex/ocf/<?php echo $courses['code']; ?>/amcgo" class="btn btn-sm btn-success"  data-toggle="tooltip" data-placement="top" title="<?php echo $profstringlong; ?>"><?php echo $profstring; ?></a></div>

<h3><?php echo $coursestringsingle; ?> :: <?php echo $topics[1]['catName']; ?> - <?php echo $topics[1]['locode']; ?></h3>


<div class="col-md-6">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">Outcome Statement</h3>
    </div>
    <div class="panel-body"> <?php echo $topics[1]['loName']; ?> </div>
  </div>
</div>



</div>
 


<div class="span10">


<h4>Topics</h4>





<table class="table-bordered" style="margin-bottom:2em; width:96%;">
<thead>


<tr>
<th align="left" valign="top" style="padding:5px;" scope="col">Code</th>
<th width="30%" align="left" valign="top" style="padding:5px;" scope="col">Title</th>
<th width="4%" align="center" valign="top" style="padding:5px;" scope="col">Level</th>
<th align="left" valign="top" style="padding:5px;" scope="col">Applicable Learning Outcomes</th>

</tr>



</thead>




<tbody>


 <?php foreach ($topics as $topic) { ?>


<tr>
<td align="left" valign="top" style="padding:5px; width:3em;" scope="col">      <a href="../topic/<?php echo $topic['uuid']; ?>/<?php echo $topic['version']; ?>" title="<?php echo $topic['title']; ?>"><?php echo $topic['code']; ?></a></td>
  <td align="left" valign="top" style="padding:5px; width: 30em;" scope="col"><?php echo $topic['title']; ?></td>
  <td align="center" valign="top" style="padding:5px; width: 22em;" scope="col">
  <?php if ($topic['level'] == 0 && $topic['course']['lo']['numAlign'] > 0) { ?><span class="btn btn-xs  btn-danger heatmap" data-toggle="tooltip" data-placement="top" data-html="true" title="<strong>Warning: data mis-match!</strong><br />Level not identified with associated Learning Outcomes"><i class="fa fa-exclamation-triangle"></i></span><?php } ?>
  <?php if($topic['level'] != '' && $topic['level'] > 0) { ?><img src="<?php echo base_url() . 'resource/ocf/';?>images/flextra-level-<?php echo $topic['level']; ?>.svg" width="18" height="18"<?php if($topic['level'] > 0) { ?> data-toggle="tooltip" data-placement="top" title="Level <?php echo $topic['level']; ?>" class="heatmap" <?php } ?>><?php } ?>

  </td>
<td align="left" valign="top" style="padding:5px; width: 22em;" scope="col">

<?php if(isset($topic['course']['loaligned'])) { ?>
<?php foreach($topic['course']['loaligned'] as $aligned) { ?>
<strong><?php echo $aligned['code']; ?></strong> :: <?php echo $aligned['name']; ?><br />
<?php }  // end foreach   ?>&nbsp;
<?php }  // ecn isset   ?>
<?php if ($topic['level'] > 0 && $topic['course']['lo']['numAlign'] == 0) { ?><span class="btn btn-xs  btn-danger heatmap" data-toggle="tooltip" data-placement="top" data-html="true" title="<strong>Warning: data mis-match!</strong><br />Learning Outcomes not identified with associated Level"><i class="fa fa-exclamation-triangle"></i></span><?php } ?>
</td>

</tr>


<?php } ?>

</tbody>



</table>



</div>

</div>

</div>

</div>



</body>
</html>
