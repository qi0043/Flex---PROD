
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


<?php if(!isset($_SESSION)){ session_start();} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>Online Curriculum Framework</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/bootstrap-theme.css">

<!-- Local styles -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/flo/ocf/';?>css/local.css">
<link href="<?php echo base_url() . 'resource/flo/ocf/';?>css/font-awesome-4.4.0/css/font-awesome.css" rel="stylesheet" type="text/css">

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

.tree small.badge
{
	font-style: normal;
	background-color:#428bca !important;
}
.panel-body .acronym dt
{
	font-size: 10px;
	width: 80px;
}

.panel-body .acronym dd
{
	font-size: 10px;
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

<script type="text/javascript" src="<?php echo base_url() . 'resource/flo/ocf/';?>js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . 'resource/flo/ocf/';?>js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo base_url() . 'resource/flo/ocf/';?>js/bootstrap.min.js"></script>   

<script type="text/javascript">
/*  resets the modal ready for it's next use */
$(document).ready(function(){
  $(document).on("hidden.bs.modal", function (e) { $(e.target).removeData("bs.modal").find(".modal-body").empty();$(e.target).removeData("bs.modal").find(".modal-title").empty(); $(".modal-body").html('<p>Loading…</p>'); $(".modal-title").html('Detail');
  });
});
</script>

<script type="text/javascript">

function logoutMsg() {
	
	alert('To log out of the OCF, please close all windows for this browser OR if you are using a Mac quit the browser ');
}

</script>

<script src="<?php echo base_url() . 'resource/ocf/';?>js/smap.js"></script>  

</head>

<body role="document">
<div class="jumbotron">
  <div class="container-fluid">
    <div class="col-md-9 col-sm-12 col-xs-12"> <img src="<?php echo base_url() . 'resource/flo/ocf/';?>images/logo-flinders_portrait.png" width="51" height="65" alt="Flinders University" style="float:left;">
      <div class="banner-text">
        <h2>Browse Course Activities</h2>
<?php 
$numCourses = count($_SESSION['ocf_validgrouplist']);
$i = 0;
?>
        <p>Welcome <?php echo $_SESSION['username']; ?><br />
        <span class="small"><em>You have access to the following course<?php if($numCourses > 1) { ?>s<?php } ?>: 
  <?php foreach($_SESSION['ocf_validgrouplist'] as $key=>$value) {
	  $i++;
	  echo strtoupper($value);
	  
	  if($i < $numCourses)  { echo " / "; }
	  
  }?>
        </em></span></p>
      </div>
    </div>
     <div class="col-md-3 col-sm-12 col-xs-12">
<a href="#" onclick="javascript:logoutMsg();" class="btn btn-default btn-xs"><span class="small"><i class="fa fa-power-off"></i>
 <span class="text-uppercase">log out</span></span></a>
    </div>
 

 </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="modal-content-id">
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

<div class="container-fluid" style="margin:15px 20px 0 20px;">
    <div role="main">
      <div class="row">
          <div class="col-md-7">
            <div class="alert alert-info alert-dissmissable small" role="alert">
            	<div class="row">
                	<div class="col-md-4">
               	 		As several people may be updating the map at once:
                    </div>
                    <div class="col-md-4">
               	 		Click &nbsp;<i class="glyphicon glyphicon-repeat" style="color: black"></i> 
                        <ul>
                        	<li>To view the latest updates for a topic </li>
							<li>After you modify activities from this page</li>
						</ul>
                    </div>
                    <div class="col-md-4">
                    	
                        <p>Click &nbsp;<i class="glyphicon glyphicon-refresh text-primary"></i> 
                        <ul>
                        	<li>After you modify activities in FLEX</li>
                        </ul>
                        </p>
                    </div>
                </div>
             </div>
           </div>
        
             <div class="col-md-1">
             </div>
         <div class="col-md-4">
         	<div class="alert alert-danger alert-dissmissable small" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       
             <ul style="margin-bottom:3px;">
                    <li>As some curriculum content is still being uploaded, the current version of the map is incomplete and may contain inaccuracies. </li>
                    <li>Supported browsers: Chrome, Firefox, Safari, and Internet Explorer 10+</li>
            </ul>
           
            </div>
         </div>
     </div>
         
         <div id="myNav" class="col-md-12"><a href="/flex/ocf/home/<?php echo strtolower($course['course_code']); ?>" class="btn btn-sm btn-primary">Return to dashboard</a></div>
     </div>
     <div class="row spinner-wave" style="display:none; position:fixed;top:30%; left:40%;z-index:100; overflow:auto">
            <div style="z-index:100;"></div>
            <div style="z-index:100;"></div>
            <div style="z-index:100;"></div>
            <div style="z-index:100;"></div>
            <div style="z-index:100;"></div>
            <p style="z-index:100;" id="txt_loading">&nbsp;Loading...</p>
     </div>
 <div class="row">
 
 <div class="col-md-8 col-sm-12 tree">
 
            <?php if (in_array(strtolower($course['course_code']), $_SESSION['ocf_validgrouplist'])) { ?>            
            
              <ul style="margin-left: -55px;">
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
      
          
           
                 
         <?php } // in a valid group list 
		 
		 else  { //not valid ?>
        <h4 class="text-danger">Access denied </h4>
  <p>Your access does not grant you permission to view this course curriculum.</p>
  <p>Please choose a different course.</p>
         
         <?php }  ?>   
         
         
      </div>
 
<div class="col-md-4 col-sm-12">

 
        <div class="panel panel-default" >

                    <!--	
                      <div class="panel-heading">
                    <h3 class="panel-title">Suggestions</h3>
                    </div>         
            <div class="panel-body">
        
            
           
            <a href="/flex/ocf/generatetoken/editactivity/items/b7c9d7be-a285-41b2-9f84-3a5c1514bda3/1/" target="_blank" class="btn btn-success btn-sm" id="suggestion-btn"><i class="fa fa-commenting-o"></i> Suggestion box</a>
            
            
            </div>
            -->
      
    <?php /*?><div class="panel-heading">
   	 <h3 class="panel-title"><i class="fa fa-search"></i>Search</h3>
    </div>  <?php */?>       
    <?php /*?><div class="panel-body">
    	<a href="/flex/ocf/generatetoken/editactivity/items/9739513c-63b3-4221-8e93-c71184ddd388/1/" target="_blank" class="btn btn-success btn-sm" id="suggestion-btn"><i class="fa fa-commenting-o"></i> Suggestions for search</a>
    
    	<form style="margin-bottom:10px; margin-top:10px;">
    
    	<div class="input-group">
    
    		<input name="searchterm" type="text" class="form-control" id="itemname" disabled="disabled" placeholder="Search coming January 2016" readonly />
    
    
   	 		<span class="input-group-btn">
    		button type="button" disabled="disabled" class="btn btn-success" id="searchthis">Search</button>
    
    
   	 	</div><!-- /input-group -->
    
    	</form>
    <!--   <p class="text-right"><a href="#" onclick="javascript:alert('Coming soon!');">Advanced Search</a></p>      -->   
    </div><?php */?>
                

                
    <div class="panel-heading">
    <h3 class="panel-title">Guide to the map</h3>
    </div>
    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt><i style="line-height:1em; vertical-align:middle" class="fa fa-plus-circle fa-lg fa-fw"></i></dt>
            <dd>Expands the item.</dd>
            <dt><i style="line-height:1em; vertical-align:middle" class="fa fa-minus-circle fa-lg fa-fw"></i></dt>
            <dd>Collapses the item.</dd>
        </dl>
        <dl class="dl-horizontal"> 
            <!--
            <dt><i class="fa fa-list fa-lg text-primary"></i>
            <i class="fa fa-question fa-lg text-primary"></i>
            </dt>
            <dd>This indicates the activity group has a choice of activities.</dd>
            -->
            <!--<dt><i style="line-height:1em; vertical-align:middle" class="fa fa-exclamation-triangle fa-lg fa-fw text-danger"></i></dt>
            <dd>Required activity</dd> -->
            <dt><i style="line-height:1em; vertical-align:middle" class="fa fa-circle-o fa-lg fa-fw text-primary"></i></dt>
            <dd>Optional activity</dd>
            <!--
            <dt><i style="line-height:1em; vertical-align:middle" class="fa fa-share-alt fa-lg fa-fw text-primary" ></i></dt>
            <dd>Alternative activity</dd>
            -->
        </dl>
    </div>
    
<!--

Refresh 
-->
            <?php if( substr($course['course_code'], 0, 2) == 'MD') { ?>
              <div class="panel-heading">
                    <h3 class="panel-title">Help</h3>
                    </div>         
            <div class="panel-body">
            <p><i class="fa fa-envelope"></i>
 <a href="mailto:medical.course@flinders.edu.au?Subject=Help with the OCF">medical.course@flinders.edu.au</a></p>
            <p><i class="fa fa-book"></i>
 <a href="/flex/ocf/generatetoken/editactivity/items/52cc53f4-ba1e-44f8-b768-a04a6f51cc71/1/" target="_blank">Help docs and videos</a></p>
     
            </div>
                     <div class="panel-heading">
                    <h3 class="panel-title">Acronyms</h3>
                    </div>         
            <div class="panel-body">
            <dl class="dl-horizontal acronym"> 
            
            <dt>AS-LIFT</dt>
            <dd>Alice Springs - Longitudinal Integrated Flinders Training Program</dd>
            
            <dt>FMC-Group A</dt>
            <dd>Flinders Medical Centre - Group A</dd>
            
            <dt>FMC-Group B</dt>
            <dd>Flinders Medical Centre - Group B</dd>
            
            <dt>FMC-Group C</dt>
            <dd>Flinders Medical Centre - Group C</dd>
            
            <dt>FMC-Group D</dt>
            <dd>Flinders Medical Centre - Group D</dd>
            
            <dt>FMC-Group A-D</dt>
            <dd>Flinders Medical Centre - Group A, B, C & D</dd>
           
            <dt>NTMP-CHME</dt>
            <dd>NTMP - Community-based and Hospital-based Medical Education</dd>
            
            <dt>PRCC</dt>
            <dd>Parallel Rural Community Curriculum</dd>
           
            </dl>
	    </div>
            <?php } ?>
        </div>
<!-- new panel -->                
        
 </div>
 </div> <!-- end map row -->          

            
         
      
        </div>
     </div>
</div>
</body>
</html>