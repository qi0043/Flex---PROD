<?php
include 'header.php';

?>

<div id="page_wrapper">
<div id="page_content" style="margin: 10px 20px;" class="row">
    
<div class="column grid_13">
<br>

<div id="sel_to_topic" >

  <script src="<?php echo base_url() . 'resource/listmgr/';?>js/chktopic.js" type="text/javascript"></script>

  
  </script>

  <div class="breadcrumbs">    
  <span typeof="v:Breadcrumb"><b>Choose To Topic availabilities</b></span>
  </div>
  
  <form id="topicForm" action="111" autocomplete="on">
  
  Please enter To Topic code (e.g. AGES8022) to display the Topic availabilities.
  <br>
  <table>
    
    <tr >
        <td >To Topic Code:</td>
    </tr>
    <tr>
        <td><input id="to_topic_code" name="to_topic_code" type="text" tabindex="1" class="ui-widget" autocomplete="on"></td>
    </tr>
  </table>                                    

  <br>

  <button type="submit" class="directory">Display availabilities</button>
  &nbsp;&nbsp;
  <!--<button type="reset" onclick='javascript: $("#to_topic_code").focus();' class="directory">Reset</button>
  &nbsp;&nbsp;-->
  <button type="button" name="previous_step">Previous</button>
  <button type="button" name="next_step" >Next</button>  
  <br>
  <br>

  </form>

  <div id="to_avails1">
    
  </div>
  
    
</div>


<div id="req_to_librarians" >
  <!--<div class="breadcrumbs">     
  <span typeof="v:Breadcrumb"><b>Requests to librarians</b></span>
  </div>-->
    
    
    <span>Enter your requests to librarians, e.g. new reading list</span>
    <br><br>
    <script src="<?php echo base_url() . 'resource/listmgr/';?>ckeditor/ckeditor.js"></script>
    <form>
        <textarea name="editor1" id="editor1" rows="10" cols="80">
            
        </textarea>
        <script>
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace( 'editor1' );
        </script>
        <br>
        <button type="button" name="previous_step">Previous</button>
       
        <button type="button" id="submit_req_to_lib" >Submit</button>  
        <button type="button"  >Test</button>  
    </form>
</div>


</div>


<?php

include 'footer.php';

?>