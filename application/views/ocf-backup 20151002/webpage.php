
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $activitytitle; ?> :: <?php echo $title; ?></title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url();?>/resource/ocf/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url();?>//resource/ocf/css/bootstrap-theme.min.css">
<!-- Local styles -->
<link rel="stylesheet" href="<?php echo base_url();?>//resource/ocf/css/local.css">



</head>

<body role="document">
<div class="jumbotron">
	<div class="container-fluid"><img src="<?php echo base_url() . 'resource/ocf/';?>images/flinders_logo.png" width="151" height="65" alt="Flinders University"></div>
</div>
<div class="container-fluid">

<h3><?php echo $activitytitle; ?> :: <?php echo $title; ?></h3>
<?php echo $pagecontent; ?>

</div>
</body>
</html>