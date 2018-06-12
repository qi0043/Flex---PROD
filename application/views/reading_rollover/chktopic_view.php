<?php

include 'header.php';
$add_availability_link = 'https://' . $_SERVER["SERVER_NAME"] . '/readings/rm/index.php/chktopic';
?>


<div class="column grid_13">

<script src="<?php echo base_url() . 'resource/rollover/';?>js/chktopics.js" type="text/javascript"></script>

<br>

<form id="topicForm" action="111" autocomplete="on">

<div class="breadcrumbs">
          
  <span typeof="v:Breadcrumb"><b>eReadings Rollover: Choose from and to Topic codes</b></span>
  
</div>

<br>
Please enter From/To Topic codes (e.g. AGES8022) to display the Topic availabilities.
<br>
<table>
    
    <tr >
        <td >From Topic Code:</td>
        <td>&nbsp;</td>
        <td >To Topic Code:</td>
    </tr>
    <tr>
        <td><input id="from_topic_code" name="from_topic_code" type="text" tabindex="1" class="ui-widget" autocomplete="on"></td>
        <td>&nbsp;</td>
        <td><input id="to_topic_code" type="text" tabindex="2" class="directory ui-widget ui-autocomplete-input" autocomplete="on"></td>
    </tr>
</table>                                    

<br>

<button type="submit" class="directory">Display availabilities</button>
&nbsp;&nbsp;
<button type="reset" onclick='javascript: $("#from_topic_code").focus();' class="directory">Reset</button>
<br>
<br>

</form>

<div id="avails">
    
</div>

<br>
<br>
    <p style="color:blue">Please note:</p> 
    <ul><li>This system will only rollover eReadings activated <b>before today</b>.</li>
        <li>Do not use this system between midnight and 5AM as this is the system maintenence period.</li>
        <li>If rollover fails because of HTTP connection issue you could try the rollover again. </li>
        <li>The system shows availabilities that are already in FLEX. You may <a href="<?php echo $add_availability_link; ?>" target="_blank">Add Topic Availabilities to Flex</a>.</li>
        <li>For any issue you could contact: <a href="mailto:flex.help@flinders.edu.au?Subject=Flextra%20rollover%20tool%20query">flex.help@flinders.edu.au</a></li>
    </ul>



</div>


<?php

include 'footer.php';

?>