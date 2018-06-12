<?php
include 'rhd_head.php';
?>

<?php if(isset($_SESSION['rhd_privilege']) && ($_SESSION['rhd_privilege'] == 'mod&con' || $_SESSION['rhd_privilege'] == 'contributor' ||  $_SESSION['rhd_privilege'] == 'moderator'))
{?>
<div class="container">
	<?php include 'nav.php'; ?>
	<div class="row" id="content"></div>
</div>


    <script type="text/javascript">
		/* @@ Parameters**/
		//current year
		var d = new Date();
		var yr = d.getFullYear();
		
		//thesis type
	    var thesis_type = [
			                  {"value": "#", "text": ""},
							  {"value": "DrPH commenced before 2013", "text": "DrPH commenced before 2013"},
							  {"value": "EdD commenced before 2014", "text": "EdD commenced before 2014"},
							  {"value": "Graduate Certificate", "text": "Graduate Certificate"},
							  {"value": "Graduate Diploma", "text": "Graduate Diploma"},
							  {"value": "Masters", "text": "Masters"}
						  ];			  
	    //schools			  
		var schools = [];		  
		<?php if(isset($schools))
		{
			foreach($schools as $school)
			{
				?>
				var temp = {};
			    temp["value"] = "<?php echo isset($school['value']) ? $school['value'] : '' ?>";
				temp["text"] = "<?php echo isset($school['text']) ? $school['text'] : '' ?>";
				schools.push(temp);
		<?php		
			}
		}
		?>
		var status = "<?php echo $status?>";
		
		var new_t = false;
		
		<?php if( isset($new_thesis) && $new_thesis )
		{ ?>
			new_t = true;
		<?php
		}?>;
		
		var readonly = !new_t;
		
		if(status != 'draft')
		{
			new_t = false;
			readonly = true;
		}
		//topics
		var topic = [];
		var topic_count = <?php echo isset($topic) ? count($topic) : 1?>;
		<?php
		if(isset($topic))
		{
			$index = 0;
			foreach($topic as $t)
			{
				$index++;
				
		?>		var temp = {};
				temp["item"] = <?php echo $index ?> ;
				temp["refname"] = "topicControlWrapper_" + <?php echo $index ?>;
				temp["default_topic_code"] = "<?php echo isset($t['code']) ? $t['code'] : '' ?>";
				temp["default_topic_name"] = "<?php echo isset($t['name']) ? $t['name'] : '' ?>";
				temp["org_num"] = '';
				topic.push(temp);
				
		<?php
			}
		}
		?>
		
		var school_org_unit = "<?php echo isset($school_org_unit) ? $school_org_unit : ''?>";
		
		var complete_yr = yr;
		<?php
		 if(isset($comp_yr))
		 { ?>
			 complete_yr = <?php echo $comp_yr?>;
		<?php } ?>
		
		var uuid = "<?php echo isset($uuid) ? $uuid : '' ?>";
		var version = "<?php echo isset($version) ? $version : '' ?>";
		var step2_url = "<?php echo base_url() ?>" + "rhd/coursework/getThesis_part2/";
		var step2_url_n = "<?php echo base_url() ?>" + "rhd/coursework/getThesis_part2/" + uuid + "/" + version + "/15";
		var index_url = "<?php echo base_url() ?>" + "thesis/coursework";
		var stuid = "<?php echo isset($stu_id) ? $stu_id : ''?>";
		var step1_url = <?php echo json_encode(base_url('rhd/coursework/edit_part1')); ?>;
		var new_thesis_url =  <?php echo json_encode(base_url('rhd/coursework/createRHD')); ?>;
		var stu_first_name_dip = "<?php echo isset($stu_first_name_dip) ? $stu_first_name_dip : ''?>";
		var stu_last_name_dip = "<?php echo isset($stu_last_name_dip) ? $stu_last_name_dip : ''?>";
		var stu_email = "<?php echo isset($stu_email) ? $stu_email : ''?>"; 
		var coursework_type = "<?php echo isset($coursework_type) ? $coursework_type  : ''?>";
		var coord_name = "<?php echo isset($coord_name) ? $coord_name: ''?>";
		var coord_email = "<?php echo isset($coord_email) ? $coord_email: ''?>";
		var thesis_title = "<?php echo isset($thesis_title) ? $thesis_title: ''?>";
		
		var ab = "<?php echo isset($abstract) ? $abstract: ''?>";
		var keywords = "<?php echo isset($keywords) ? $keywords: ''?>";
		var ab_file_name = "<?php echo isset($abstract_attachment[1]['filename']) ? $abstract_attachment[1]['filename'] : '' ?>";
		var ab_file_size = "<?php echo isset($abstract_attachment[1]['filesize']) ? $abstract_attachment[1]['filesize']: '' ?>";
		var ab_file_link =  "<?php echo isset($abstract_attachment[1]['filelink']) ? $abstract_attachment[1]['filelink'].'&token='.$token : '' ?>";
		
    </script>

<?php
}
else
{?>
	<div class="container">
        <div className="row">
        <?php echo 'You do no have privilege to view this page or session time out.'; ?>
        </div>
    </div>
<?php } //end of IF session exists
?>
</div>
<?php
//end of IF session exists
include 'footer.php';
?>

<script type="text/javascript" src="<?php echo base_url() . 'resource/rhd/';?>js/step1.js"></script>