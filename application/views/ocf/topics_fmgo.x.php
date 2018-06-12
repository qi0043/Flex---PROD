<?php include_once('includes/language.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo $title; ?>::Course Overview - <?php echo $coursestring; ?></title>

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

.vertical-text {
	display: inline-block;
	overflow: hidden;
	width: 1.5em;
}
.vertical-text__inner {
	display: inline-block;
	white-space: nowrap;
	line-height: 1.5;
	transform: translate(0,100%) rotate(-90deg);
	transform-origin: 0 0;
}
/* This element stretches the parent to be square
   by using the mechanics of vertical margins  */
.vertical-text__inner:after {
	content: "";
	display: block;
	margin: -1.5em 0 100%;
}


td.nullBG {
	
	
	background-color: #999;
	
}

td.notNullBG {
	
	
	background-color: #E9E9E9 !important;
	
}

#myNav {
	
	margin-bottom:1em;
	
}  



@media print {
	
  a[href]:after {
    content: "";
  }
  
 td.notNullBG {
	background-color: #E9E9E9 !important;

}

th {background:inherit; }


#myNav {
	display:none;
	visibility:hidden;
	
} 


th.bg-success {
  background-color: #dff0d8 !important;
}

th.bg-info {
  background-color: #d9edf7 !important;
}

th.bg-warning {
  background-color: #fcf8e3 !important;
}

th.bg-danger {
  background-color: #f2dede !important;;
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
  <div class="container-fluid">
    <div class="col-md-9 col-sm-12 col-xs-12"> <img src="<?php echo base_url() . 'resource/flo/ocf/';?>images/logo-flinders_portrait.png" width="51" height="65" alt="Flinders University" style="float:left;">
      <div class="banner-text">
        <h2><?php echo strtoupper($courses['code']); ?> Curriculum Framework</h2>
        <p>Welcome <?php echo $_SESSION['username']; ?><br />
          <span class="small"><em>Your group membership grants access to the following course(s):
            <?php foreach($_SESSION['ocf_validgrouplist'] as $key=>$value) {
	  echo strtoupper($value) . " / " ;
	  
  }?>
          </em></span></p>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid" style="margin:15px 20px 0 20px;">

<div role="main">
  <div class="row">
    
  <div id="myNav" class="span10"><a href="<?php echo base_url() . 'ocf/home/' . $courses['code'] ?>" class="btn btn-sm btn-primary">Return to dashboard</a>&nbsp;&nbsp;<a href="/flex/ocf/<?php echo strtolower($courses['code']) ; ?>/amcgo" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="<?php echo $profstringlong; ?>"><?php echo $profstring; ?></a></div>

  <h4>Learning Outcome Map - <?php echo $coursestringlong; ?></h4>

<?php 

$topicCount = intval($topiccount['numTopics']);

?>
<!-- 
 <p>Number of Topics: <?php echo $topicCount; ?></p>
    
<pre>

<?php print_r($topics); ?>

</pre>


<pre>
<?php  print_r($topics[1]['course']['los']); ?>
</pre>
-->

</div>

  <h5>Outcome Levels</h5>
  
  <div class="btn-toolbar" role="toolbar">
<div class="btn-group" role="group" style="margin-bottom:10px; float:left;">
<a href="/flex/ocf/<?php echo $courses['code'] ?>/fmgo/0" class="btn  btn-sm btn-default" style="float:left;">Show None</a>
</div>

<div class="btn-group" role="group" style="margin-bottom:10px; float:left;">
<a href="/flex/ocf/<?php echo $courses['code']; ?>/fmgo/1" class="btn  
 btn-sm btn-default" >Level 1</a>
<a href="/flex/ocf/<?php echo $courses['code']; ?>/fmgo/2" class="btn 
 btn-sm btn-default" >Level 2</a>
<a href="/flex/ocf/<?php echo $courses['code']; ?>/fmgo/3" class="btn  
 btn-sm btn-default" >Level 3</a>
</div>


<div class="btn-group" role="group" style="margin-bottom:10px; float:left;">
<a href="/flex/ocf/<?php echo $courses['code']; ?>/fmgo" class="btn active btn-sm btn-default" >Show All</a>
</div>
</div>
  
  

<br clear="left" />

 
 <div class="span12 table-responsive">
  <table class="table-bordered" style="margin-bottom:5em;">
  <thead>
 
   <tr>
<th valign="bottom" style="padding:5px;"></th>
    <?php foreach($coursedomain as $domain) { ?>
    <th colspan="<?php echo $domain['number']; ?>" valign="bottom" class="<?php echo $domain['class']; ?>" style="padding:5px;" scope="col"><?php echo $domain['name']; ?></th>
    <?php } ?>

</tr>

    <tr>
      <th valign="bottom" style="padding:5px;" scope="col">Topic</th>
       <?php for ($i = 1; $i <= $courses['numCourseLO']; $i++ ) { ?>
       <th valign="bottom" style="padding:5px; width:9em;" scope="col"><a href="fmgosearch/<?php echo strtolower($topics[1]['course']['los']['lo'.$i]['code']);?>"><?php echo $topics[1]['course']['los']['lo'.$i]['code'];?></a></th> <?php } ?>  
    </tr>
  </thead>
  <tbody>  
 <?php foreach ($topics as $topic) { ?>
    <tr>
      <td style="padding:5px; padding-right:3em;">
      <a href="/flex/ocf/<?php echo $courses['code'] ?>/topic/<?php echo $topic['uuid']; ?>/<?php echo $topic['version']; ?>" title="<?php echo $topic['title']; ?>"><?php echo $topic['code']; ?></a>
      </td>
     <?php for ($i = 1; $i <= $courses['numCourseLO']; $i++ ) { ?>
      <td align="center"  style="padding:5px;" <?php if($topic['course']['los']['lo'.$i]['numAlign'] > 0) { ?> class="notNullBG"<?php } ?>><?php if ($topic['course']['los']['lo'.$i]['level'] >= 1) { ?>

<img src="<?php echo base_url() . 'resource/flo/ocf/';?>images/flextra-level-<?php echo $topic['course']['los']['lo'.$i]['level']; ?>.svg" alt="level<?php echo $topic['course']['los']['lo'.$i]['level']; ?>" width="18" height="18" title="Level <?php echo $topic['course']['los']['lo'.$i]['level']; ?>" data-toggle="tooltip" class="heatmap"><?php } else { ?>&nbsp;<?php } ?></td>
   <?php } ?>  
    </tr>
    
<?php } ?>
</tbody>
  </table>


</div>

</div>

</div>



</body>
</html>
