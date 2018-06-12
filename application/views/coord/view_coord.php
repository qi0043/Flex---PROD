<!doctype html>
<html><head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>Download coord info</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/coord/';?>css/bootstrap.css">
<!--<link rel="stylesheet" href="<?php echo base_url() . 'resource/coord/';?>css/loading.css">-->
<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url() . 'resource/coord/';?>css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/coord/';?>css/style7.css" media="all"> 
<script src="<?php echo base_url() . 'resource/coord/';?>js/jquery-1.10.2.min.js"></script>
<script src="<?php echo base_url() . 'resource/coord/';?>js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo base_url() . 'resource/coord/';?>js/bootstrap.js"></script>  
<script src="<?php echo base_url() . 'resource/coord/';?>js/table2CSV.js"></script>
<script src="<?php echo base_url() . 'resource/coord/';?>js/scrollup.js"></script>

<style>
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
</style>

<script language="javascript" type="text/javascript">
	/*$(window).load(function() {
		$('#loading').fadeOut(1500, function() {
			$('#result_data').fadeIn(1500);
		});
	});*/
    //$(function(){
            //alert("kkl");
            //$(".spinner-wave").show();
            //$(".spinner-wave").fadeOut(1500);
            
        //});
        $(window).load(function() {
                $(".spinner-wave").show();
                //$(".spinner-wave").fadeOut(2000);
	        $('.spinner-wave').fadeOut(2000, function() {
			$('#result_data').fadeIn(1500);
		});
                //$('#result_data').fadeIn(3500);
	});
</script>

</head>

<body>

<div class="spinner-wave" style="display:none; position:fixed;top:50%; left:40%;z-index:100; overflow:auto">
        <div style="z-index:100;"></div>
        <div style="z-index:100;"></div>
        <div style="z-index:100;"></div>
        <div style="z-index:100;"></div>
        <div style="z-index:100;"></div>
        <p style="z-index:100;" id="txt_loading">&nbsp;Loading...</p>
</div>
    
<div id="top_banner1" role="banner"> 
	<div id="header-wrap"> 
    	<div id="top_banner5"> 
			<div class="banner5">Flextra: Topic Coordinators List</div> 
		</div> 
		<div id="top_banner2">
			<div class="banner"></div> 
		</div> 
	</div> 
</div>

<br>
<br>

<div class="main_info">
    
    <div class="banner5"></div>
    
    <div class="form box">
    	
        <form id="coord_form" action="<?php echo site_url('/coord/report'); ?>">
        <table id = "filter" class="filter">
            <tr>
                <th colspan="10">Report Filter</th>
            </tr>
            <tr>
            	<td style="vertical-align: middle">School of: </td>
                <td >
                   <input id="school" name="school" type="text" class="form-control" placeholder="e.g. Health Sciences" style="width:250px;" value="<?php if(isset($school)) echo $school; ?>">
                </td>
                <td style="vertical-align: middle">Topic: </td>
                <td>
                   <input id="topic" name="topic" type="text" class="form-control" placeholder="e.g. HLTH" style="width:150px;" value="<?php if(isset($topic)) echo $topic; ?>">
                </td>
                <td style="vertical-align: middle">Year: </td>
                <td>
                    <?php if(isset($year)) echo '<input id="year" name="year" class="form-control" placeholder="e.g. 2014" value="'.$year.'" style="width: 110px">'; else echo '<input id="year" name="year" class="form-control" placeholder="e.g. 2014" value="" style="width: 110px">' ?>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: middle">Semester: </td>
                <td>
                    <select class="form-control" name="semester" id="semester" style="width:100px;">
                    	<option value="all" <?php if(isset($semester)) {if($semester == 'all') echo 'selected="selected"';}?>>All</option>
                    	<?php 
							for($i=0; $i<count($semesters); $i++)
							{
						?>
                        		<option value="<?php echo strtolower($semesters[$i]['sem']);?>" <?php if(isset($semester)) {if($semester == strtolower($semesters[$i]['sem'])) echo 'selected="selected"';}?>><?php echo $semesters[$i]['sem'];?></option>
                        <?php
							}
						?>
                    </select>
                </td>
            
                <td style="vertical-align: middle"> eReadings</td>
                <td style="vertical-align: middle; text-align: left;">
                    <input type="checkbox" id="ereadings" name="ereadings" value="Y" <?php if(isset($ereadings) && $ereadings != '') echo 'checked';?> >&nbsp; Only topics with eReadings
                </td>
                <td style="vertical-align: middle">FAN: </td>
                <td>
                    <?php if(isset($fan)) echo '<input id="fan" name="fan" class="form-control" placeholder="e.g. abcd1234" value="'.$fan.'" style="width: 110px">'; else echo '<input id="fan" name="fan" class="form-control" placeholder="e.g. abcd1234" value="" style="width: 110px">' ?>
                     
                </td>
            </tr>
        </table>
        
        <br>
        
        <button  class="btn btn-primary">Submit</button>
        <a href="javascript:void(0);" class="btn btn-primary" onclick="javascript: $('#coord_form select').val('all');$('#coord_form input').val('');">Clear Filter</a>
        <?php
        if(isset($result)) {
            if($result[0]) {
        ?>
        
        <?php } }	?>
        
		</form>
        
    </div>
    
    <!--<div id="loading">
		<img id="loading-image" src="<?php echo base_url() . 'resource/coord/';?>images/loading.gif" alt="Loading..." />
	</div>-->
	
	<div id="result_data" style="display:none;" class="list box">
    
    	<br>
    	<?php if(isset($result)) {
		if($result[0] == 'empty')
		{
			
		}
		else if($result[0] == 'not found')
		{
		?>
			<table id="results_error" class="results_normal">
            <tr>
                <th colspan="3">Oh, no... We cannot find any matching results... Please update the filter and try again. :)</th>
            </tr>
        	</table>
        <?php 
		}
		else
		{
		?>
        <iframe id="myFrame" style="display:none"></iframe>

        <a href='#' class='btn btn-primary export'>Download Results</a>
        <a href='#' class='scrollup'>Back to Top</a>
        <?php
			echo "<p align='left'>" . count($result) . " results found</p>";
		?>
        
        
        
        <div id = 'dvData'>
      	<table id="results_normal" class="results_normal">
            <tr>
           		<th style="min-width: 150px;">School Name</th>
                <th>Topic</th>
                <th>FAN</th>
                <th>Name</th>
                <th>Email</th>
                <th>eReadings</th>
                <th style="min-width: 120px;">Last Changed</th>
            </tr>
        <?php for($i=0; $i<count($result); $i++) { ?>
            <tr>
            	<td><?php echo $result[$i]['school_name'];?></td>
                <td><?php echo $result[$i]['avail_ref'];?></td>
                <td><?php echo $result[$i]['tc_fan'];?></td>
                <td><?php echo $result[$i]['tc_fullname'];?></td>
                <td><?php echo $result[$i]['tc_email'];?></td>
                <td><?php echo $result[$i]['ereadings'];?></td>
                <td><?php echo $result[$i]['time'];?></td>
            </tr>
        <?php } ?>
        </table>
        </div>
    	<?php } ?>
        
        <?php } ?>
         <br>
        <br>
    
    </div>

</div>




</body>
</html>