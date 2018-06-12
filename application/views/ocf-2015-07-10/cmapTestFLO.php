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
/**********loading spinner***************/
.spinner-wave {
    margin: 0 auto;
    width: 100px;
    height: 100px;
    text-align: center;
	
}
.spinner-wave > div {
    background-color: #333;
    height: 50%;
    width: 6px;
    display: inline-block;
    -webkit-animation: wave 1.2s infinite ease-in-out;
    animation: wave 1.2s infinite ease-in-out;
}

.spinner-wave div:nth-child(2) {
    -webkit-animation-delay: -1.1s;
    animation-delay: -1.1s;
}

.spinner-wave div:nth-child(3) {
    -webkit-animation-delay: -1.0s;
    animation-delay: -1.0s;
}

.spinner-wave div:nth-child(4) {
    -webkit-animation-delay: -0.9s;
    animation-delay: -0.9s;
}

.spinner-wave div:nth-child(5) {
    -webkit-animation-delay: -0.8s;
    animation-delay: -0.8s;
}
@-webkit-keyframes wave {
    0%, 40%, 100% { -webkit-transform: scaleY(0.4) }
    20% { -webkit-transform: scaleY(1.0) }
}

@keyframes wave {
    0%, 40%, 100% { transform: scaleY(0.4); }
    20% { transform: scaleY(1.0); }
}
/******************************************/
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
<script type="text/javascript" src="<?php echo base_url() . 'resource/ocf/';?>js/cmap.js"></script>   

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
  
/*$(window).load(function() {
		$('#spinner').fadeOut(1500, function() {
		});
	});*/
</script>


<script type="text/javascript">

/*  resets the modal ready for it's next use */


$(document).on("hidden.bs.modal", function (e) { $(e.target).removeData("bs.modal").find(".modal-body").empty();$(e.target).removeData("bs.modal").find(".modal-title").empty(); $(".modal-body").html('<p>Loading…</p>'); $(".modal-title").html('Detail');
 });



</script>


</head>

<body role="document">

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
    	<div class="page-header">
      		<h2><?php echo strtoupper($course['course_code']); ?> Curriculum Map - v0.2</h2>
      	</div>
             	<?php /*?><div id="spinner" style="display:none; width:1000px; height:1000px; position:fixed;top:50%; left:50%; text-align:center; margin-left:-40%; margin-top:-70%; z-index:100; overflow:auto"><?php */?>
        <?php /*?><div id="spinner" style="display:none; width:1000px; height:1000px; position:fixed; top: 1%; left:15%; text-align:center; z-index:100; overflow:auto">
        	<center>
        		<img class="loading_img" src="<?php echo base_url() . 'resource/coord/';?>images/loading.gif"  alt="loading..."  style="position:absolute; top:30%; left:30%; z-index:100">
            </center>
        </div><?php */?>
          <div class="spinner-wave" style="display:none; position:fixed;top:30%; left:40%;z-index:100; overflow:auto">
            <div style="z-index:100;"></div>
            <div style="z-index:100;"></div>
            <div style="z-index:100;"></div>
            <div style="z-index:100;"></div>
            <div style="z-index:100;"></div>
            <p style="z-index:100;" id="txt_loading">&nbsp;Loading...</p>
        </div>
      <div class="row">
  <div class="col-md-9 tree">

<ul>
    			<li class="course_li"><span class="bold"><?php echo $course['course_code']; ?> Course</span>
     			<ul>
                	<?php for($x=1; $x<count($course); $x++)
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
													$topic['linked_activities'][$act_index]['course_code'] = $course['course_code'];
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
                                                 <?php  
												 	 $refresh_id = 'rf_' . $topic['linked_activities'][1]['uuid'].'_'. $course['course_code'];
													 echo '&nbsp;&nbsp;<i style="display:none; cursor:pointer" class="refresh_icon glyphicon glyphicon-refresh" id="'.$refresh_id.'" title="refresh"></i>';
												 ?>
												<?php $id = 'ul_'.$topic['linked_activities'][1]['uuid'] .'_'. $course['course_code'];
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
<div class="col-md-3">
<div class="panel panel-primary affix hidden-xs hidden-sm" style="margin-right:25px;">
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
