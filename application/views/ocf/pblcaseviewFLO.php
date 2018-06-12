<?php include_once('includes/language.php'); ?>
<?php

$pagefrom = $_SERVER['HTTP_REFERER']; 

?>
<?php


switch ($_SERVER['SERVER_NAME']) {


    case "flextra.flinders.edu.au":
    
        $flexserv = "https://flex.flinders.edu.au";
        break;

    case "flextra-test.flinders.edu.au":
    
        $flexserv = "https://flex-test.flinders.edu.au";
        break;


    case "flextra-dev.flinders.edu.au":
    
        $flexserv = "https://flex-dev.flinders.edu.au";
        break;

}



?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>PBL Case::<?php echo $item['itemTitle']; ?></title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap-theme.min.css">
<!-- Local styles -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/local.css">


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
<link href="<?php echo base_url() . 'resource/flo/ocf/';?>css/font-awesome-4.4.0/css/font-awesome.css" rel="stylesheet" type="text/css">


  <script src="<?php echo base_url() . 'resource/flo/ocf/';?>js/foundation/foundation/foundation.js"></script>
  <script src="<?php echo base_url() . 'resource/flo/ocf/';?>js/foundation/foundation/foundation.equalizer.js"></script>

<script type="text/javascript">

$(document).ready(function(){

	$('.instruction').tooltip();


});  

</script>
<script type="text/javascript">

/*  resets the modal ready for it's next use */


$(document).on("hidden.bs.modal", function (e) { $(e.target).removeData("bs.modal").find(".modal-body").empty();$(e.target).removeData("bs.modal").find(".modal-title").empty(); $(".modal-body").html('<p>Loading…</p>'); $(".modal-title").html('Detail');
 });



</script>

<style type="text/css">
.tooltip-inner{
    max-width:300px;
    padding:3px 8px;
    color:#fff;
    text-align:left;
}
<!--
  .doNotPrint {

	  
  }
  
  
    .instruction {
	  

	  
  }

@media print {


    body {
        margin: 0;
        padding: 0;
        line-height: 1.4em;
        word-spacing: 1px;
        letter-spacing: 0.2px;
        font: 13px Arial, Helvetica,"Lucida Grande", serif;
        color: #000;
    }

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
--

@media (max-width: @screen-sm-max) { 

body {
    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
    font-size: 12px;
    line-height: 1.42857;
    color: #333;
}

}


>
</style>
<script type="text/javascript">

$(document).ready(function(){

        $('.thumbnail').tooltip({
    	'placement': 'top' });


});  

$(document).ready(function(){

        $('.btn-sm').tooltip({
    	'placement': 'top' });

});

 </script>
 
 <script type="text/javascript">

/*  resets the modal ready for it's next use */


$(document).on("hidden.bs.modal", function (e) { $(e.target).removeData("bs.modal").find(".modal-body").empty();$(e.target).removeData("bs.modal").find(".modal-title").empty(); $(".modal-body").html('<p>Loading…</p>'); $(".modal-title").html('Detail');
 });



</script>

<script>

function show(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

</script>

 
 
</head>
<body role="document">
<!-- Modal -->

<div class="jumbotron">
  <div class="container-fluid"><img src="<?php echo base_url() . 'resource/flo/ocf/';?>images/Flinders-50th-logo.png" alt="Flinders University" width="223" height="45"></div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
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


<!--


<pre>
<?php print_r($item); ?>
</pre>

<pre>
<?php print_r($caseresources); ?>
</pre>


<pre>
<?php print_r($token); ?>
</pre>


-->    

		
<div class="container-fluid" style="margin:0 20px 0 20px;">

  <div role="main">
    <div class="row">
    <div class="col-md-9 col-sm-8">
      <h3>PBL Case: <em><?php echo $item['itemTitle']; ?></em></h3>
    </div>
    <div class="col-md-3 col-sm-4">
 <div class="noPrint" style="padding-top:15px;"> 
 <!-- edit button --> 
 
 <?php if(isset($privilege))
	{
		if($privilege == 'moderator&contributor')
		{
	
	?> 
<!--
<a href="/flex/flo/ocf/generatetoken/editactivity/items/<?php echo $item['uuid']; ?>/<?php echo $item['version']; ?>" target="_blank" class="btn btn-sm btn-danger btn-block"><i class="fa fa-edit"></i> Edit case</a> -->
<?php 
		}}?>


</div>

 </div>
</div>


<div class="row" style="margin-bottom:0.5em;">
  <div class="col-md-9 col-sm-8">
<h4>Overview</h4>
<?php echo $item['itemOverview']; ?>
<?php if($item['numberSections'] == 1) { ?>
<p class="text-success"><strong>There is <?php echo $item['numberSections']; ?> tutorial for this case.</strong></p>
<?php } else { ?>
<p class="text-success"><strong>There are <?php echo $item['numberSections']; ?> tutorials for this case.</strong></p>
<?php } ?>
</div>

  <div class="col-md-3 col-sm-4">
<div class="well" style="font-size:0.9em;">
<h4>Case View</h4>
<ul class="fa-ul">
  <li><i class="fa-li fa fa-television"></i><a href="<?php echo base_url() ;?>flo-ocf/pbltrigger/<?php echo $item['uuid'] ;?>/<?php echo $item['version'];?>" target="_blank">Presentation format</a></li>
 

  <li><i class="fa-li fa fa-print"></i>Print format
    <ul class="fa-ul">
      <li style="margin-left:-7px;"><i class="fa-li fa fa-file-o"></i><a href="<?php echo base_url() ;?>pbl/sprint/<?php echo $item['uuid'] ;?>/<?php echo $item['version'];?>" target="_blank">Student notes</a></li>


  </ul>
  </li>
  </ul>
</div>
</div>
  </div>

<?php if (!empty($caseresources)) { ?>

<div class="row" style="margin-bottom:0.5em;">
   <div class="col-md-12 col-sm-12">
<div class="well">

<h4>Case Resources</h4>
  <div class="row">
  <?php foreach ($caseresources as $cr) { ?>
    <div class="col-md-2 col-sm-4 col-xs-6" style="font-size:0.9em;"  data-toggle="tooltip" data-placement="top" data-html="true" title="<?php echo $cr['title']; ?>">
       <a href="/flex/flo-ocf/generatetoken/viewitem/items/<?php echo $item['uuid']; ?>/<?php echo $item['version']; ?>/<?php echo $cr['uuid']; ?>" class="thumbnail" style="height:120px; overflow:hidden;" target="_blank"  data-toggle="tooltip" data-placement="top" data-html="true" title="<?php echo $cr['title']; ?>">
       <img src="<?php echo $cr['thumbnailLink']; ?>?token=<?php echo $token;?>" alt="<?php echo $cr['title']; ?>" class="img-responsive"  >
       <p class="small text-center"><?php echo $cr['title']; ?></p>   
        
      </a>
    </div>
    <?php } ?>
  

</div>
</div>
</div>
  </div>

<?php } ?>


  
  <div class="row" style="margin-bottom:0.5em;">
  </div>

</div>



</body>
</html>
