<?php

include 'header.php';

$avails_count = count($avails_for_new_req);
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




<form id="topicForm" action="">

<div class="breadcrumbs">
          
  <span typeof="v:Breadcrumb"><b>Create new request for Topic availabilities</b></span>
  
</div>


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
    <?php for($i=0;$i<$avails_count;$i++){ ?>
    <tr <?php if($i%2==0) echo "class='even'"; else echo "class='odd'";?> >
        
        <td><?php echo $avails_for_new_req[$i]; ?></td>
        <td></td>
    </tr>
    <?php } ?>
</table>
<br>
   
<button type="button" id="closebutton"  >Close</button>    
</div>


</div>

</div>

<?php
include 'footer.php';
?>