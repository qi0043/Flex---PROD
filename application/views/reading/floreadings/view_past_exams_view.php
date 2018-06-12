<?php
include 'header.php';

if(!isset($past_exams)) $past_exams = array();
?>

<br>


<div class="container">

<?php if(isset($down_notice['message'])) {?>
<div class="row">
    <div class="alert alert-info" role="alert"><?php echo $down_notice['message']; ?></div>	
</div>    
<?php }?> 
    
<div class="row">
    
    
  <div class="col-md-10">
   
      
  <table  class="table table-hover table-striped">
    
    <thead>
        
    <th></th>
    <th>Past Exam Paper</th>
    <th>Notes</th>

    </thead>
    <tbody>
    
    <?php for($i=0;$i<count($past_exams);$i++){ ?>
    <tr>
        
        
        <td><?php echo $i+1; ?>
        </td>
        
        <td>
            <a href="<?php echo $past_exams[$i]['pep_link'];?>" target="_blank"> <?php echo $past_exams[$i]['name'];?></a>
        </td>
        
        <td>
             
        </td>
         
    </tr>
    <?php }  ?>
    <?php if (count($past_exams) == 0){ ?>
    <tr>
          
        <td>
        </td>
        
        <td>
            No past exam paper found.
        </td>
        
        <td>
             
        </td>

    </tr>
    <?php }  ?>
    
    </tbody>
  </table>    
      
  </div>
</div>
 
</div>



<br>


<!--<div id="dialog-form" title="Rollover eReadings">-->


<?php

#include 'footer.php';

?>