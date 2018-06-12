<?php
include 'header.php';

?>

<div class="jumbotron">
  <div class="container">
    <h1>eReading List Management</h1>
    <p>Welcome to this web tool designed for Topic Coordinators who would like more control over eReading lists.</p>
    <p class="hidden-sm hidden-xs">If you prefer to work directly with the Library's <a href="mailto:eReserve@flinders.edu.au">Learning Access Team </a> you can continue to do that. In this case the site will be useful for you to view previous eReading lists or new ones before they are made available to students via FLO.</p>
    <p class="text-muted hidden-sm hidden-xs">It would be great to have your feedback. Please email ideas and suggestions to <a href="mailto:flex.help@flinders.edu.au">flex.help@flinders.edu.au</a>.</p>
  </div>
</div>
<div class="container">
<div class="row">
  <div class="col-md-4">
    <h2>Lists </h2>
    <?php /*?><p><a class="btn btn-primary" href="view_er_chktopic.html<?php if(isset($topic_code)) echo "?topic_code=" . $topic_code . "&view_type=ereading"; ?>" role="button">View eReading list »</a></p><?php */?>
    
    <p><a class="btn btn-primary" href=<?php if(isset($topic_code)) echo base_url("/reading/listmgr/view_er_chktopic.html?topic_code=" . $topic_code . "&view_type=ereading");  else echo base_url("/reading/listmgr/view_er_chktopic.html"); ?>  role="button" />View eReading list »</a>
    </p>
  
    <ul>
      <li>View eReading lists from semester 2, 2013. </li>
    </ul>
   <?php /*?> <p><a class="btn btn-primary" href="rollover_er_chktopic.html<?php if(isset($topic_code)) echo "?topic_code=" . $topic_code . "&view_type=ereading"; ?>" role="button">Rollover eReadings  »</a></p><?php */?>
    
    <p><a class="btn btn-primary" href=<?php if(isset($topic_code)) echo base_url("/reading/listmgr/rollover_er_chktopic.html?topic_code=" . $topic_code . "&view_type=ereading");  else echo base_url("/reading/listmgr/rollover_er_chktopic.html"); ?>  role="button" />Rollover eReadings  »</a>
   </p>
  
   
    <ul>
      <li>Copy eReadings from one topic list to other lists.</li>
    </ul>
  </div>
  <div class="col-md-4">
    <h2>Requests</h2>
   <?php /*?> <p><a class="btn btn-primary" href="view_req_chktopic.html<?php if(isset($topic_code)) echo "?topic_code=" . $topic_code . "&view_type=request"; ?>" role="button">View Requests »</a></p><?php */?>
    
     
    <p><a class="btn btn-primary" href=<?php if(isset($topic_code)) echo base_url("/reading/listmgr/view_req_chktopic.html?topic_code=" . $topic_code . "&view_type=request");  else echo base_url("/reading/listmgr/view_req_chktopic.html"); ?>  role="button" />View Requests »</a>
    </p>
  
   
    <ul>
      <li>View eReading requests and check their status. </li>
    </ul>
    <?php /*?><p><a class="btn btn-primary" href="create_req_chktopic.html<?php if(isset($topic_code)) echo "?topic_code=" . $topic_code . "&view_type=request"; ?>" role="button">Make a Request »</a></p><?php */?>
   
    <p><a class="btn btn-primary" href=<?php if(isset($topic_code)) echo base_url("/reading/listmgr/create_req_chktopic.html?topic_code=" . $topic_code . "&view_type=request");  else echo base_url("/reading/listmgr/create_req_chktopic.html"); ?>  role="button" />Make a Request »</a>
    </p>
  
    <ul>
      <li>Make a request if you need to add new eReadings or delete eReadings from a list.</li>
        <li>Making a request is similar to sending an email.</li>
        <li>Requests are sent to the <a href="mailto:eReserve@flinders.edu.au">Learning Access Team</a> for action.</li>
    </ul>
  </div>
  <div class="col-md-4">
    <!--
    <h3>How To Guides</h3>
    <p>Documents:</p>
    <ul>
        <li>Coming soon...
    </ul>
    
    <ul>
      <li><a href="http://flex.flinders.edu.au/items/5a555671-1a12-4a21-a2ca-3112c51bf548/1/?attachment.uuid=b4e23b77-b151-4512-9d70-366e955c182e" target="_blank">Manage your eReading List</a></li>
      <li><a href="http://flex.flinders.edu.au/items/5a555671-1a12-4a21-a2ca-3112c51bf548/1/?attachment.uuid=e230a680-9975-4d82-a4e5-54ecbbbe630a" target="_blank">Submit a Request to the Libraray</a></li>
    </ul>
    
    <p>The one minute video:</p>
    <ul>
        <li>Coming soon...
    </ul>
    
    <ul>
      <li><a href = "http://flex.flinders.edu.au/items/5a555671-1a12-4a21-a2ca-3112c51bf548/1/?attachment.uuid=4263281e-a10a-4aa1-9d3e-545da8902dca" title = "View an eReading List - Video Walkthrough" onlick = "return false;" target="_blank"> View an eReading List - Video Walkthrough </a</li>
      <li><a href = "http://flex.flinders.edu.au/items/5a555671-1a12-4a21-a2ca-3112c51bf548/1/?attachment.uuid=1c19232c-a984-46fb-a61f-83876d97ecc5" title = "Add a reading to your list from another list - Video Walkthrough" onlick = "return false;" target="_blank"> Add a reading to your list from another list - Video Walkthrough </a></li>
      <li><a href = "http://flex.flinders.edu.au/items/5a555671-1a12-4a21-a2ca-3112c51bf548/1/?attachment.uuid=1757ffcc-68be-4b6d-b087-26e372d57d43" title = "Request the Library to add new eReadings - Video Walkthrough" onlick = "return false;" target="_blank"> Request the Library to add new eReadings - Video Walkthrough </a></li>
      <li><a href = "http://flex.flinders.edu.au/items/5a555671-1a12-4a21-a2ca-3112c51bf548/1/?attachment.uuid=dfc9f87f-e370-4a23-887f-07205d5e5955" title = "Create a list based on last semester - Video Walkthrough" onlick = "return false;" target="_blank"> Create a list based on last semester - Video Walkthrough </a></li>
    </ul>
    -->
  </div>
</div>
    
<div class="row">
    <div class="col-md-8">
      <h3>About eReading Lists </h3>
      <p>eReadings are stored in the University's learning content repository <a href="http:flex.flinders.edu.au" target="_blank">FLEX</a>, <i>Flinders Learning Exchange</i>.
      <p>When an eReading is requested for a list, the Library first checks whether it is already in FLEX. If it isn't in FLEX:</p>
      <ul>
        <li>It is sourced from the University collections, including licensed collections, or externally. </li>
        <li>Once located, a PDF or a link to the eReading is added to FLEX along with specific metadata. This metadata includes sufficient data to generate a citation and to report on usage to <i>Copyright Australia</i> on  eReadings made available under Part VB of the <i>Copyright Act</i>.</li>
      </ul>
      <p>When an eReading is needed for a list it is tagged with the topic availability and the period it will be made available to students. It is also checked that it will be copyright compliant for that period of time. </p>
    </div>
    <div class="col-md-4">
      <h3>Help </h3>
      <p>For help with your eReading lists please contact the Library's <a href="mailto:eReserve@flinders.edu.au">Learning Access Team </a>.</p>
      <p>If you have a technical problem, please contact CILT:</p>
      <ul>
        <li>email <a href="mailto:flex.help@flinders.edu.au">flex.help@flinders.edu.au</a></li>
      </ul>
    </div>
</div>
   
</div>
<!-- /container --> 

<?php
include 'footer.php';

?>