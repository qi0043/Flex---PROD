<?php

include 'header.php';

$to_count = count($to_avails);
#$current_page = "chktopic";

#include 'nav1.php';
?>


<div class="column grid_12">

<script type="text/javascript"> 
 
  $(function() {
    $( "button" ).button();
    $("#closebutton").click(function(){window.open('', '_self', '');window.close();});
  });
  
  
</script>

<br>

<?php #echo validation_errors(); ?>

<?php #echo form_open($submit_action); ?>


<form id="topicForm" action="">

<div class="breadcrumbs">
          
  <span typeof="v:Breadcrumb"><b>Activate eReading for Topic availabilities</b></span>
  
</div>

<br>
Activate eReading: <a target="_blank" href="<?php echo $reading_link;?>"><?php echo $reading_link;?></a>
<br>
<br>
<label class="preField">Activation result:  </label>   
<br>
<div>
<table id="tblfromavails">

    <tr>
        
        <th>Availability</th>
        <th>Result</th>
        
    </tr>
    <?php for($i=0;$i<$to_count;$i++){ ?>
    <tr <?php if($i%2==0) echo "class='even'"; else echo "class='odd'";?> >
        
        <td><?php echo $to_avails[$i]; ?></td>
        <td><?php echo $result["status"][$i]; ?></td>
    </tr>
    <?php } ?>
</table>
<br>
<?php if($result['error_info'] != ''){ ?>
<p style="color:red">Stop on error: <?php echo $result['error_info']; ?> </p>   
<?php } ?>

Note: If a result shows as <b>Duplication</b>, then it has already been activated.
<br>
<br>    
<button type="button" id="closebutton"  >Close</button>    
</div>


</div>

</div>

<?php

#include 'footer.php';

?>