<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title> - jsFiddle demo</title>
</head>
<body>
  <!--
<button id="example" type="button" class="btn btn-default" title="Tooltip on bottom">Tooltip on bottom</button>
-->

<div>I'm new to JavaScript and was wondering what this meant in their documentation:<div>
    <br />
    <div>Trigger the <span id="example" title="the tooltip">tooltip</span> via JavaScript:</div>

<link href="http://getbootstrap.com/dist/css/bootstrap.css" rel="stylesheet">
<script src="http://getbootstrap.com/assets/js/jquery.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.js"></script>
<script src="http://platform.twitter.com/widgets.js"></script>
    <script>
        var options = {
            toggle:"tooltip",
            placement:"bottom"
        }
        $('#example').tooltip(options);
    </script>
  
</body>


</html>