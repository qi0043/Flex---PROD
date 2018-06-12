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
<!--
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
/*.tree li:last-child::before {
	height:38px
}*/

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
<script type="text/javascript" src="<?php echo base_url() . 'resource/ocf/';?>js/tmap.js"></script>   

<script type="text/javascript">
$(document).ready(function(){
//hide the child li elements
	
		$(' li ul > li').hide();
		$(' li .theYear').show(); 
		$(' li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Expand this');
		
		$(' li.parent_li > span.year_span').on('click', function (e) {
			var children = $(this).parent('li.parent_li').find(' > ul > li');
			if (children.is(":visible")) {
				children.hide('fast');
				$(this).attr('title', 'Expand this').find(' > i').addClass('fa-plus-circle').removeClass('fa-minus-circle');
			} 
			else {
				children.show('fast');
				$(this).attr('title', 'Collapse this').find(' > i').addClass('fa-minus-circle').removeClass('fa-plus-circle');
			}
			
			//$(this).removeClass('clicked_span');
			e.stopPropagation();
		});
	
});
  
$(window).load(function() {
		$('#spinner').fadeOut(1500, function() {
		});
	});
</script>
</head>

<body role="document">

<div class="jumbotron">
	<div class="container-fluid"><img src="<?php echo base_url() . 'resource/ocf/';?>images/flinders_logo.png" width="151" height="65" alt="Flinders University"></div>
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
      		<h2>MD Curriculum Map - v0.2</h2>
      	</div>

     	<?php /*?><div id="spinner" style="display:none; width:1000px; height:1000px; position:fixed;top:50%; left:50%; text-align:center; margin-left:-40%; margin-top:-70%; z-index:100; overflow:auto"><?php */?>
        <div id="spinner" style="display:none; width:1000px; height:1000px; position:fixed; top: 1%; left:15%; text-align:center; z-index:100; overflow:auto">
        	<center>
        		<img class="loading_img" src="<?php echo base_url() . 'resource/coord/';?>images/loading.gif"  alt="loading..."  style="position:absolute; top:30%; left:30%; z-index:100">
            </center>
        </div>
     	<div class="row tree">
     		<ul>
    			<li class="course_li"><span class="bold">MD Course</span>
     			<ul>
                	<?php for($x=1; $x<=count($course); $x++)
					{
						$c = $course[$x];?>
     				<?php /*?><?php foreach ($course as $c) { ?><?php */?>
                   
     					<li class="theYear"><span class="year_span"><i class="fa fa-plus-circle"></i> Year <?php echo $c['year']; ?></span>
     					<?php if($c['numTopics'] > 0) { ?>
                        
     						<ul>
     							<?php foreach($c['topics'] as $idxt=>$topic) { ?>
									<?php if (isset($topic['numLinkedActivities']) && ($topic['numLinkedActivities'] > 0)) 
										  { 
										  		foreach($topic['linked_activities'] as $act_index => $actUuid)
										  		{
													$topic['linked_activities'][$act_index]['topic_code'] = $topic['code'];
												}
										  ?>
											<li class="topic_li">
                                                <span class="topic_span">
                                                	<i class="fa fa-plus-circle activity"></i> <?php echo $topic['code']; ?> - <?php echo $topic['title']; ?>
                                                    <?php $name = $topic['code'].'_'.$idxt;
                                                          $json_value =  htmlspecialchars(json_encode($topic['linked_activities']));
                                                          echo '<input class = "activity_input" type="hidden" name= "'.$name.'" value="'.$json_value.'">';
                                                    ?>
                                                 </span>
												<?php $id = 'ul_'.$topic['linked_activities'][1]['uuid'];
													  echo '<ul id="'.$id.'">
													      </ul>';
												?>
                                            </li>
									<?php }
										  else
										  {?>
											 <li><span><i class="fa fa-plus-circle"></i> <?php echo $topic['code']; ?> - <?php echo $topic['title']; ?></span>
									<?php }
								}?>
							</ul>
						<?php }?>    
                        </li>
                  	<?php }?>
                </ul>
                </li>
              </ul>
      </div>

  </div>
</div>
</body>
</html>
