<!-- include file bmid/profsearchnav.php -->

<div id="myNav" class="span10"><a href="<?php echo base_url() . 'ocf/home/' . $courses['code']; ?>" class="btn btn-sm btn-primary">Return to dashboard</a>&nbsp;&nbsp;<a href="/flex/ocf/<?php echo strtolower($courses['code']) ; ?>/fmgo" class="btn btn-sm btn-success">Flinders B Midwifery Course Outcomes</a>&nbsp;&nbsp;<a href="/flex/ocf/<?php echo strtolower($courses['code']) ; ?>/amcgo" class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Tooltip on top">ANMC National Competency Standards</a></div>

<h3>ANMC National Competency Standard:: <?php echo $topics[1]['catName']; ?> - <?php echo $topics[1]['locode']; ?></h3>
<!-- /include file bmid/profsearchnav.php -->