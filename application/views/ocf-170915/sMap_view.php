<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>School of Medicine Curriculum Framework</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/bootstrap.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/bootstrap-theme.css">

<!-- Local styles -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/ocf/';?>css/local.css">
<link href="<?php echo base_url() . 'resource/ocf/';?>css/font-awesome-4.2.0/css/font-awesome.css" rel="stylesheet" type="text/css">

<style type="text/css">
.tree {
    min-height:20px;
    padding:19px;
    margin-bottom:20px;
    background-color:#fff;
}
.tree li {
    list-style-type:none;
    margin:0;
    padding:10px 5px 0 5px;
    position:relative;
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
.tree li.parent_li:not(.course_li)::after {
    border-top:1px solid #999;
    height:20px;
    top:25px;
    width:25px
}

.tree li.child_li::after {
    border-top:1px solid #999;
    height:20px;
    top:20px;
    width:22px
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
</style>

<!-- Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<!-- Latest compiled and minified JavaScript -->

<script type="text/javascript" src="<?php echo base_url() . 'resource/ocf/';?>js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'resource/ocf/';?>js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo base_url() . 'resource/ocf/';?>js/bootstrap.min.js"></script>   


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
		
			$(this).attr('title', 'Expand this').find(' > i:first').addClass('fa-plus-circle').removeClass('fa-minus-circle');
		
	} else {
		children.show('fast');
		
			$(this).attr('title', 'Collapse this').find(' > i:first').addClass('fa-minus-circle').removeClass('fa-plus-circle');
		
	}
	e.stopPropagation();
});

});  

</script>
<script type="text/javascript">
/*  resets the modal ready for it's next use */
$(document).on("hidden.bs.modal", function (e) { $(e.target).removeData("bs.modal").find(".modal-body").empty();$(e.target).removeData("bs.modal").find(".modal-title").empty(); $(".modal-body").html('<p>Loading…</p>'); $(".modal-title").html('Detail');
 });
</script>

</head>

<body role="document">
<div class="jumbotron">
  <div class="container-fluid">
    <div class="col-md-9 col-sm-12 col-xs-12"> <img src="<?php echo base_url() . 'resource/ocf/';?>images/logo-flinders_portrait.png" width="51" height="65" alt="Flinders University" style="float:left;" />
      <div class="banner-text">
        <h2><?php echo strtoupper($course['course_code']); ?> Curriculum Map: prototype for MD staff</h2>
        <p>Welcome </p>
      </div>
    </div>
  </div>
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

<div class="container-fluid">
    <div role="main">
        <div class="row">
        
        <div class="col-md-12">
        <div class="alert alert-danger alert-dissmissable small" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <p><strong>Limitation disclaimer</strong></p>
			<ul style="margin-bottom:3px;">
            	<li>As some curriculum content is still being uploaded, the current version of the map is incomplete and may contain inaccuracies. </li>
                <li>Supported browsers: Chrome, Firefox, Safari, and versions 10+ for Internet Explorer</li>
            </ul>
  <button type="button" class="btn btn-sm btn-danger" data-dismiss="alert" aria-label="Close" style="padding: 3px 25px 3px 25px;">OK</button>
</div>
</div>
        </div>
        <div class="row">
        	<div id="myNav" class="col-md-12">
            	<a href="/flex/ocf/home/<?php echo strtolower($course['course_code']); ?>" class="btn btn-sm btn-primary">Return to dashboard</a>
            </div>
            <div class="col-md-9 col-sm-12 tree">
                <ul>
                    <li class="course_li"><span class="bold"><?php echo $course['course_code']; ?> Course</span>
                    <?php for($i=1; $i<count($course); $i++)
                    {
                        echo "<ul>";
                        echo "<li class='theYear'><span class='year_span'><i class='fa fa-plus-circle'></i> Year ". $i . "</span>";
						for($j=1; $j<=count($course[$i]); $j++)
						{
							if(isset($course[$i][$j]['content']))
							{
								echo "<ul><li class='topic_li'>";
								echo $course[$i][$j]['content'];
								echo "</li></ul>";
							}
						}
                		echo "</li></ul>";
                    }
                    ?>
                    </li>
                  </ul>
             </div>
            <div class="col-md-3 col-sm-12">
                <div class="panel panel-primary affix" style="margin-right:25px;">
                    <div class="panel-heading">
                    <h3 class="panel-title">Guide to the map</h3>
                    </div>
                    <div class="panel-body">
                        <dl class="dl-horizontal">
                            <dt><i style="line-height:1em; vertical-align:middle" class="fa fa-plus-circle fa-lg fa-fw"></i></dt>
                            <dd>Expands the item to display items with this parent topic or activity.</dd>
                            <dt><i style="line-height:1em; vertical-align:middle" class="fa fa-minus-circle fa-lg fa-fw"></i></dt>
                            <dd>Collapses the item.</dd>
                        </dl>
                        <dl class="dl-horizontal"> 
                            <dt><i class="fa fa-list fa-lg"></i>
                            <i class="fa fa-question fa-lg"></i>
                            </dt>
                            <dd>This indicates the activity group has a choice of activities.</dd>
                            <dt><i style="line-height:1em; vertical-align:middle" class="fa fa-exclamation-triangle fa-lg fa-fw text-danger"></i></dt>
                            <dd>Required activity</dd>
                            <dt><i style="line-height:1em; vertical-align:middle" class="fa fa-dot-circle-o fa-lg fa-fw"></i></dt>
                            <dd>Optional activity</dd>
                            <dt><i style="line-height:1em; vertical-align:middle" class="fa fa-share-alt fa-lg fa-fw"></i></dt>
                            <dd>Alternative activity</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>
</body>
</html>