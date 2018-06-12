<?php

include 'header.php';
$add_availability_link = 'https://' . $_SERVER["SERVER_NAME"] . '/readings/rm/index.php/chktopic';
?>


<div class="column grid_12">

<br>
<script src="<?php echo base_url() . 'resource/rollover/';?>js/chktopic.js" type="text/javascript"></script>

<form id="topicForm" action="">

<div class="breadcrumbs">
          
  <span typeof="v:Breadcrumb"><b>Activate eReading for Topic availabilities</b></span>
  
</div>

<br>    
eReading: <a target="_blank" href="<?php echo $reading_link;?>"><?php echo $reading_link;?></a>
<!--
UUID: <?php echo $uuid;?>, Version: <?php echo $version;?>, Attachment: <?php echo $attachment;?>.
-->

<br>
<!--
<table>
    <tr>
        <th>UUID</th>
        <th>Version</th>
        <th>Attachment</th>
    </tr>
    <tr>
        <td><?php echo $uuid;?></td>
        <td><?php echo $version;?></td>
        <td><?php echo $attachment;?></td>
    </tr>
</table>
-->
<br>
Please enter Topic code (e.g. AGES8022) to display the availabilities for activation:
<br>
<table>
    
    <tr >
        <td >Topic Code:</td>
    </tr>
    <tr>
        <td><input id="topic_code" type="text" tabindex="1" class="directory ui-widget ui-autocomplete-input"></td>
    </tr>
</table>                                    
    <input type="hidden" id="theuuid" value="<?php echo $uuid;?>" />
    <input type="hidden" id="theversion" value="<?php echo $version;?>" />
    <input type="hidden" id="theattachment" value="<?php echo $attachment;?>" />
<br>

<button type="submit" class="directory">Display availabilities</button>
&nbsp;&nbsp;
<button type="reset" onclick="javascript: setFocus();" class="directory">Reset</button>
<br>
<br>

</form>

<div id="avails">
    
</div>

<br>
<br>
    <p style="color:blue">Please note:</p> 
    <ul>
        <li>Do not use this system between midnight and 5AM as this is the system maintenence period.</li>
        <li>If activation fails because of HTTP connection issue you could try the activation again. </li>
        <li>The system shows availabilities that are already in FLEX. You may <a href="<?php echo $add_availability_link; ?>" target="_blank">Add Topic Availabilities to Flex</a>.</li>
        <li>For any issue you could contact: <a href="mailto:flex.help@flinders.edu.au?Subject=Flextra%20activation%20tool%20query">flex.help@flinders.edu.au</a></li>
    </ul>

</div>

</div>

<?php

include 'footer.php';

?>