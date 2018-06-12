<?php include_once('includes/language.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title><?php echo $title; ?>::Course Overview - <?php echo $profstring; ?></title>
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
    <div class="col-md-9 col-sm-12 col-xs-12"> <img src="<?php echo base_url() . 'resource/ocf/';?>images/logo-flinders_portrait.png" width="51" height="65" alt="Flinders University" style="float:left;">
      <div class="banner-text">
        <h2><?php echo strtoupper($courses['code']); ?> Curriculum Framework - Pilot</h2>
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
<div class="container-fluid" style="margin:0 20px 0 20px;">

<div role="main">

  <div class="row">

<div id="myNav" class="span10"><a href="<?php echo base_url() . 'ocf/home/' . $courses['code'] ?>" class="btn btn-sm btn-primary">Return to dashboard</a>&nbsp;&nbsp;<a href="/flex/ocf/<?php echo strtolower($courses['code']) ; ?>/fmgo" class="btn btn-sm btn-success"  data-toggle="tooltip" data-placement="top" title="<?php echo $coursestringlong; ?>"><?php echo $coursestring; ?></a></div>

<h3>Course Overview - <?php echo $profstringlong; ?></h3>



<?php 

$topicCount = intval($topiccount['numTopics']);

?>


    
<?php /*?><pre>

<?php print_r($topics); ?>

</pre>
<?php */?>

</div>
 
<h4>Outcome Levels</h4>
<div class="btn-toolbar" role="toolbar">
<div class="btn-group" role="group" style="margin-bottom:10px; float:left;">
<a href="/flex/ocf/<?php echo $courses['code'] ?>/amcgo/0" class="btn  btn-sm btn-default" style="float:left;">Show None</a>
</div>

<div class="btn-group" role="group" style="margin-bottom:10px; float:left;">
<a href="/flex/ocf/<?php echo $courses['code']; ?>/amcgo/1" class="btn  
 btn-sm btn-default" >Level 1</a>
<a href="/flex/ocf/<?php echo $courses['code']; ?>/amcgo/2" class="btn 
 btn-sm btn-default" >Level 2</a>
<a href="/flex/ocf/<?php echo $courses['code']; ?>/amcgo/3" class="btn  
 btn-sm btn-default" >Level 3</a>
</div>


<div class="btn-group" role="group" style="margin-bottom:10px; float:left;">
<a href="/flex/ocf/<?php echo $courses['code']; ?>/amcgo" class="btn active btn-sm btn-default" >Show All</a>
</div>
</div>

<br clear="left" />



<div class="span12 table-responsive" id="theData">
<?php if($courses['numProfLO'] > 30) { ?>
<div role="tabpanel">


  <h4>Domains</h4>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
  
  <?php foreach($profdomain as $domain) { ?>
  
    <li role="presentation" class="text-<?php echo $domain['class']; ?> small"><a href="#<?php echo $domain['code']; ?>" aria-controls="<?php echo $domain['code']; ?>" role="tab" data-toggle="tab"><?php echo $domain['name']; ?></a></li>
    
    
    <?php } ?>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
  
 <div role="tabpanel" class="tab-pane fade in active" id="Tab">

 <table class="table-bordered table-responsive" style="margin-bottom:5em; margin-top:2em;">
 
   <thead>


    <tr>
    <th valign="bottom" style="padding:5px;" scope="col">&nbsp;</th>
    
   
    <th colspan="20" valign="bottom" style="padding:5px;" scope="col"><i class="fa fa-exclamation-triangle text-danger"></i> Select a domain to view from the choices above</th>
  

    </tr>
     <tr>
      <th valign="bottom" style="padding:5px;" scope="col">&nbsp;</th>
      <?php for ($i = 1; $i <= 20; $i++ ) { ?>
      <th valign="bottom" style="padding:5px; width:4.2em;" scope="col">&nbsp;</th>
 <?php } ?>  
    </tr>
    


  </thead>
    <tbody>  
   <?php foreach ($topics as $topic) { ?>
    <tr>
      <td style="padding:5px; padding-right:3em;">
      <span class="text-muted"><?php echo $topic['code']; ?></span>
      </td>
      <?php for ($i = 1; $i <= 20; $i++ ) { ?>
      <td align="center" style="padding:5px;">&nbsp;</td>
   <?php } ?>  
    </tr>
    
<?php } ?>
  </tbody>
  
 </table>
 
 
</div>
  
  <?php $a = 0; ?>
    <?php foreach($profdomain as $domain) { ?>
      <?php $a++; ?>
    <div role="tabpanel" class="tab-pane fade" id="<?php echo $domain['code']; ?>">

 <table class="table-bordered table-responsive" style="margin-bottom:5em; margin-top:2em;">
 
   <thead>


    <tr>
    <th valign="bottom" style="padding:5px;" scope="col">&nbsp;</th>
    
   
    <th colspan="<?php echo $domain['number']; ?>" valign="bottom" class="<?php echo $domain['class']; ?>" style="padding:5px;" scope="col">Domain: <?php echo $domain['name']; ?></th>
  

    </tr>
     <tr>
      <th valign="bottom" style="padding:5px;" scope="col">&nbsp;</th>
      <?php for ($i = $domain['start']; $i <= ($domain['start'] + $domain['number'] - 1); $i++ ) { ?>
      <th valign="bottom" style="padding:5px; width:4.2em;" scope="col"><a href="amcgosearch/<?php echo strtolower($topics[1]['prof']['los']['lo'.$i]['code']);?>"><?php echo $topics[1]['prof']['los']['lo'.$i]['code'];?></a><?php if (strlen($topics[1]['prof']['los']['lo'.$i]['code']) < 4) { ?>&nbsp;<?php } ?></th>
 <?php } ?>  
    </tr>
    


  </thead>
    <tbody>  
   <?php foreach ($topics as $topic) { ?>
    <tr>
      <td style="padding:5px; padding-right:3em;">
      <a href="topic/<?php echo $topic['uuid']; ?>/<?php echo $topic['version']; ?>" title="<?php echo $topic['title']; ?>"><?php echo $topic['code']; ?></a>
      </td>
      <?php for ($i = $domain['start']; $i <= ($domain['start'] + $domain['number'] - 1); $i++ ) { ?>
      <td align="center" style="padding:5px;" <?php if($topic['prof']['los']['lo'.$i]['numAlign'] > 0) { ?> class="notNullBG"<?php } ?>><?php if ($topic['prof']['los']['lo'.$i]['level'] >= 1) { ?>

<img src="<?php echo base_url() . 'resource/ocf/';?>images/flextra-level-<?php echo $topic['prof']['los']['lo'.$i]['level']; ?>.svg" alt="level<?php echo $topic['prof']['los']['lo'.$i]['level']; ?>" width="18" height="18" data-toggle="tooltip" data-placement="top" title="Level <?php echo $topic['prof']['los']['lo'.$i]['level']; ?>"><?php } else { ?>&nbsp;<?php } ?></td>
   <?php } ?>  
    </tr>
    
<?php } ?>
  </tbody>
  
 </table>
    
    </div>
 <?php } ?>
  </div>

</div>



<?php } else { ?>
<div class="table-responsive">


<table class="table-bordered" style="margin-bottom:5em;">
  <thead>


    <tr>
    <th valign="bottom" style="padding:5px;" scope="col">&nbsp;</th>
    
    <?php foreach($profdomain as $domain) { ?>
    <th colspan="<?php echo $domain['number']; ?>" valign="bottom" class="<?php echo $domain['class']; ?>" style="padding:5px;" scope="col"><?php echo $domain['name']; ?></th>
    <?php } ?>

    </tr>
 
    
    <tr>
      <th valign="bottom" style="padding:5px;" scope="col">&nbsp;</th>
      <?php for ($i = 1; $i <= $courses['numProfLO']; $i++ ) { ?>
      <th valign="bottom" style="padding:5px; width:4.2em;" scope="col"><a href="amcgosearch/<?php echo strtolower($topics[1]['prof']['los']['lo'.$i]['code']);?>"><?php echo $topics[1]['prof']['los']['lo'.$i]['code'];?></a><?php if (strlen($topics[1]['prof']['los']['lo'.$i]['code']) < 4) { ?>&nbsp;<?php } ?></th>
 <?php } ?>  
    </tr>

  </thead>
  <tbody>  
 <?php foreach ($topics as $topic) { ?>
    <tr>
      <td style="padding:5px; padding-right:3em;">
      <a href="topic/<?php echo $topic['uuid']; ?>/<?php echo $topic['version']; ?>" title="<?php echo $topic['title']; ?>"><?php echo $topic['code']; ?></a>
      </td>
    <?php for ($i = 1; $i <= $courses['numProfLO']; $i++ ) { ?>
      <td align="center" style="padding:5px;" <?php if($topic['prof']['los']['lo'.$i]['numAlign'] > 0) { ?> class="notNullBG"<?php } ?>><?php if ($topic['prof']['los']['lo'.$i]['level'] >= 1) { ?>

<img src="<?php echo base_url() . 'resource/ocf/';?>images/flextra-level-<?php echo $topic['prof']['los']['lo'.$i]['level']; ?>.svg" alt="level<?php echo $topic['prof']['los']['lo'.$i]['level']; ?>" width="18" height="18" data-toggle="tooltip" data-placement="top" title="Level <?php echo $topic['prof']['los']['lo'.$i]['level']; ?>"><?php } else { ?>&nbsp;<?php } ?></td>
   <?php } ?>  
    </tr>
    
<?php } ?>
</tbody>
  </table>


</div>

  
<?php } ?>

</div>

</div>

</div>



</body>
</html>
