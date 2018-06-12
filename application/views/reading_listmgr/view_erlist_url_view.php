<?php

#include 'header.php';
#include 'view_ereading_nav.php';

if($ereadings === false)
    $readings_count = 0;
else
    $readings_count = count($ereadings);

if($rollover_today_readings === false)
    $rollover_readings_count = 0;
else
    $rollover_readings_count = count($rollover_today_readings);

?>
<html>

<head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        
        <script type="text/javascript" src="<?php echo base_url() . 'resource/listmgr/';?>js/jquery-1.11.1.min.js"></script>
        <script src="<?php echo base_url() . 'resource/listmgr/';?>bootstrap-3.2.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/listmgr/';?>bootstrap-3.2.0-dist/css/bootstrap.min.css" media="all">
        <!--<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/listmgr/';?>bootstrap-3.2.0-dist/css/bootstrap-theme.min.css" media="all">-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/listmgr/';?>css/flextra-er.css" media="all">
	<title>eReading List with URL addresses</title>
        

</head>    
    
<body>
    
<style>
        table{
            font-size: 13px;
        }
</style>

<br>

<div class="container">

<h3>eReadings List for <?php echo $from_avail; ?></h3>

<p ><i>For use by topic teaching teams only </i></p>  
<br>
<p class="text-danger"><big>Important</big></p>
<p>This is the current version of the list. </p>
<ul>
  <li>It does not include eReadings that the Library are in the process of sourcing and adding to the list.</li>
  <li>The eReadings list will be viewable via the FLO topic site once students have access to FLO - the default is one week before the start of the teaching period.</li>
</ul>
<p>Send this URL to share this list with your teaching team.</p>
<ul>
  <li>Access to this list requires a FAN.</li>
  <li class="text-danger">Please do not send this list to students.</li>
</ul>


<div class="row">
  <div class="col-md-12">
    <table id="ereading_table" class="table table-hover table-striped">
    <?php if ($readings_count > 0){ ?>
    <thead>
        
    <th></th>
    <th>eReading</th>
    <th>Notes for students</th>
    
    </thead>
    <?php }?>
    <?php for($i=0;$i<$readings_count;$i++){ ?>
    <tr >
        
        <td><?php echo $i+1; ?>
        </td>
        
        <td ><?php echo $ereadings[$i]['reading_citation']?><br>
            <i>Link Label:</i> <?php echo $ereadings[$i]['reading_description']?><br>
            <i>Link URL:&nbsp;</i><span class="text-success"><?php echo $ereadings[$i]['reading_link'];?></span>
            
        </td>
        
        <td>
            <?php echo $ereadings[$i]['reading_notes']; ?>
        </td>
        
    </tr>
    <?php } ?>
  </table>
  </div>
</div>

<br>
<?php if($rollover_today_readings != false){ ?>
<h4> Below eReadings are rolled over or added today:</h4>
<div class="row">
  <div class="col-md-12">
    <table id="rollover_today_table" class="table table-striped table-hover">

    <thead>
    <th></th>

    <th>eReading</th>
    <th>Notes for students</th>

    </thead>
    <tbody>
    
    <?php for($i=0;$i<$rollover_readings_count;$i++){ ?>
    <tr <?php #echo(($i%2==1) ? "class='even'" : "class='odd'");; ?> >
        <?php #$usage_info = 'Total no. of times accessed: ' . $ereadings[$i]['usg_total'] . '<br>' . 
              #  'Unique users: [' . $ereadings[$i]['usg_unique_users'] . ']<br>' . 
              #  'Topic availabilities:' . '<br>' . str_replace(",", "<br>", $ereadings[$i]['usg_avails']); ?>
        
        
        <td><?php echo $i+1; ?>
        </td>
        
        <td ><?php echo $rollover_today_readings[$i]['reading_citation']?><br>
            <i>Link Label:</i> <?php echo $rollover_today_readings[$i]['reading_description']?><br>
            <i>Link URL:&nbsp;</i><span class="text-success"><?php echo $rollover_today_readings[$i]['reading_link'];?></span>
        </td>
        
        <td>
            <?php echo $rollover_today_readings[$i]['reading_notes']; ?>
        </td>
        
    </tr>
    <?php }?>
    </tbody>
  </table>
  </div>
</div>
<?php } ?>      
    
    
</div>

<br>


<?php

#include 'footer.php';

?>
</body>
</html>
