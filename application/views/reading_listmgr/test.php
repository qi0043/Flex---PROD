<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Menu - Default functionality</title>
        
        <script type="text/javascript" src="<?php echo base_url() . 'resource/listmgr/';?>js/jquery-1.11.1.min.js"></script>
    
        <script src="<?php echo base_url() . 'resource/listmgr/';?>js/jquery-ui-1.11.1.custom.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/listmgr/';?>css/jquery-ui-1.11.1.custom/jquery-ui.min.css" media="all">

  <script>
  $(function() {
    $( "#menu" ).menu();
  });
  </script>
  <style>
  .ui-menu { width: 150px; }
  </style>
</head>
<body>
 
<ul id="menu">
  <li class="ui-state-disabled">Aberdeen</li>
  <li>Ada</li>
  <li>Adamsville</li>
  <li>Addyston</li>
  <li>Delphi
    <ul>
      <li class="ui-state-disabled">Ada</li>
      <li>Saarland</li>
      <li>Salzburg an der schönen Donau</li>
    </ul>
  </li>
  <li>Saarland</li>
  <li>Salzburg
    <ul>
      <li>Delphi
        <ul>
          <li>Ada</li>
          <li>Saarland</li>
          <li>Salzburg</li>
        </ul>
      </li>
      <li>Delphi
        <ul>
          <li>Ada</li>
          <li>Saarland</li>
          <li>Salzburg</li>
        </ul>
      </li>
      <li>Perch</li>
    </ul>
  </li>
  <li class="ui-state-disabled">Amesville</li>
</ul>
 
 
</body>
</html>