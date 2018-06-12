<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="../../assets/ico/favicon.ico">
<title>School of Medicine Curriculum Framework</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/som/';?>css/bootstrap.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/som/';?>css/bootstrap-theme.css">


<!-- Local styles -->

<link rel="stylesheet" href="<?php echo base_url() . 'resource/som/';?>css/local.css">


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
    
<link href="<?php echo base_url() . 'resource/som/';?>css/font-awesome-4.2.0/css/font-awesome.css" rel="stylesheet" type="text/css">



<style type="text/css">
<!--

.tree {
    min-height:20px;
    padding:19px;
    margin-bottom:20px;
    background-color:#fff;
f
}
.tree li {
    list-style-type:none;
    margin:0;
    padding:10px 5px 0 5px;
    position:relative
}
.tree li::before, .tree li::after {
    content:'';
    left:-20px;
    position:absolute;
    right:auto
}
.tree li::before {
    border-left:1px solid #999;
    bottom:50px;
    height:100%;
    top:0;
    width:1px
}
.tree li::after {
    border-top:1px solid #999;
    height:20px;
    top:25px;
    width:25px
}
.tree li span {
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border:1px solid #999;
    border-radius:5px;
    display:inline-block;
    padding:3px 8px;
    text-decoration:none
}

.tree li span.bold {
    -moz-border-radius:0;
    -webkit-border-radius:0;
    border:none;
    border-radius:0;
    display:inline-block;
    padding:3px 8px;
    text-decoration:none;
	font-weight:bold;
	cursor:default;
}



.tree li.parent_li>span {
    cursor:pointer
}
.tree>ul>li::before, .tree>ul>li::after {
    border:0
}
.tree li:last-child::before {
    height:30px
}
.tree li.parent_li>span:hover, .tree li.parent_li>span:hover+ul li span {
	background-color: #eee;
	border: 1px solid #94a0b4;
	color: #000;
	background-image: -webkit-linear-gradient(270deg,rgba(255,255,255,1.00) 0%,rgba(235,235,235,1.00) 100%);
	background-image: -moz-linear-gradient(270deg,rgba(255,255,255,1.00) 0%,rgba(235,235,235,1.00) 100%);
	background-image: -o-linear-gradient(270deg,rgba(255,255,255,1.00) 0%,rgba(235,235,235,1.00) 100%);
	background-image: linear-gradient(180deg,rgba(255,255,255,1.00) 0%,rgba(235,235,235,1.00) 100%);
}

.tree li span.bold:hover {
    background:#fff;
    border:none;
    color:#000;
	cursor:default;
}


@media print {
	
  a[href]:after {
    content: "";
  }
}
-->
</style>



    <script type="text/javascript">

    $(document).ready(function(){
		
	
 //hide the child li elements
    $('.tree li ul > li').hide();
	
	$('.tree li .theYear').show();
    
	$('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Expand this');
    $('.tree li.parent_li > span').on('click', function (e) {
		
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).attr('title', 'Expand this').find(' > i').addClass('fa-plus-circle').removeClass('fa-minus-circle');
        } else {
            children.show('fast');
            $(this).attr('title', 'Collapse this').find(' > i').addClass('fa-minus-circle').removeClass('fa-plus-circle');
        }
        e.stopPropagation();
    });

    });  

    </script>



</head>
<body role="document">
<div class="jumbotron">
<div class="container-fluid"><img src="<?php echo base_url() . 'resource/som/';?>images/flinders_logo.png" width="151" height="65" alt="Flinders University"></div>
</div>

<?php if ($_SERVER['REMOTE_ADDR'] == '10.26.21.73') { ?>
<!--
<pre>
<?php // print_r($course); ?>
</pre>
-->
<?php } ?>
<div class="container-fluid" style="margin:0 20px 0 20px;">
  <div role="main">
      <div class="page-header">
      <h2>MD Curriculum Map - v0.1</h2>
    </div>
     <div class="row tree">

     
     <ul>
     <li><span class="bold">MD Course</span>
     <ul>
     <?php foreach ($course as $c) { ?>
     <li class="theYear"><span><i class="fa fa-plus-circle"></i> Year <?php echo $c['year']; ?></span>
     <?php if($c['numTopics'] > 0) { ?>
     <ul><?php } ?>
     <?php if($c['numTopics'] > 0) { ?>
     <?php foreach($c['topics'] as $topic) { ?>
     <li><span><i class="fa fa-plus-circle"></i> <?php echo $topic['code']; ?> - <?php echo $topic['title']; ?></span>
     <?php if (isset($topic['numLinkedActivities']) && ($topic['numLinkedActivities'] > 0)) { ?>
     <ul><?php } ?>
     <?php foreach($topic['linked_activities'] as $linked) { ?>
      <?php if ($linked['activityType'] == 'activity') { ?>
     <li><a href="/flex/som/activity/<?php echo $linked['itemUuid']; ?>/<?php echo $activity['itemVersion']; ?>/<?php echo $linked['itemUuid']; ?>" target="_blank" title="View activity detail"><?php echo $linked['title']; ?></a></li>
     <?php } else { ?>
     <li><span><i class="fa fa-plus-circle"></i> <?php echo $linked['title']; ?></span> &nbsp;&nbsp;<a href="/flex/som/lta/<?php echo $linked['itemUuid']; ?>/<?php echo $linked['itemVersion']; ?>/<?php echo $topic['code']; ?>" target="_blank">view detail</a><?php } ?>

     <?php if (isset($linked['numLinkedActivities']) && ($linked['numLinkedActivities'] > 0)) { ?>
     <ul><?php } ?>
     <?php foreach($linked['linked_activities'] as $activity) { ?>
      <li><a href="/flex/som/activity/<?php echo $activity['itemUuid']; ?>/<?php echo $activity['itemVersion']; ?>/<?php echo $linked['itemUuid']; ?>" target="_blank" title="View activity detail"><?php echo $activity['title']; ?></a>
      <?php } ?>
     <?php if (isset($linked['numLinkedActivities']) && ($linked['numLinkedActivities'] > 0))  { ?>
     </ul><?php } ?>
     </li>
     <?php } ?>
      <?php if (isset($topic['numLinkedActivities']) && ($topic['numLinkedActivities'] > 0)) { ?>
     </ul><?php } ?>
     </li>
     <?php } ?>
     </ul><?php } ?>
     
     </li>
     <?php } ?>
     </ul>
     </li>
     </ul>
     </div>
    
    
  </div>
</div>



</body>
</html>
