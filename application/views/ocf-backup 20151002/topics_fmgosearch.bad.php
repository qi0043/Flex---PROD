<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="../../assets/ico/favicon.ico">



<title>School of Medicine Curriculum Framework::XXXXXXX</title>

<!-- <?php echo base_url(); ?> -->




<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url().'resource/som/';?>css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url().'resource/som/';?>css/bootstrap-theme.min.css">


<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->



<!-- Latest compiled and minified JavaScript -->



<script type="text/javascript" src="<?php echo base_url() . 'resource/som/';?>js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'resource/som/';?>js/jquery-ui-1.10.3.custom.min.js"></script>

<script src="<?php echo base_url() . 'resource/som/';?>js/bootstrap.min.js"></script>   
    


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



</head>

<body role="document">

<div class="container-fluid" style="margin:0 20px 0 20px;">



<div role="main">
  <div class="page-header">
    <h2>School of Medicine Curriculum Framework</h2>
  </div>
  
<div class="row">
<h3>Outcome Detail :: </h3>
<div id="myNav" class="span10"><a href="/flex/som/startup" class="btn btn-primary">Return to dashboard</a>&nbsp;</div>

</div>
 


<div class="span10">


<h4>Topic Learning Outcomes</h4>



<?php 
    echo "<pre>";
    print_r($topiccount);
    print_r($topics);
    echo "</pre>";
?>






<?php if ($_SERVER['REMOTE_ADDR'] == '129.96.68.25') { ?>
<!--
<div class="doNotPrint">
<h4>Topic Alignment</h4>
<pre>     


<?php print_r($topics); ?>

</pre>

-->
<?php } ?>
</div>

</div>
</div>
</body>
</html>