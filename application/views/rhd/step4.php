<?php
include 'rhd_head.php';
?>

<style type="text/css">
   .visible
   {
	   display: block;
   }
   .invisible
   {
	   display: none;
    }
	
	.active a
	{
		color:#eb6e08 !important;
		font-size: 18px;
		
	}
	i.glyphicon
	{
		cursor:pointer;
	}
	
	.content
	{
		padding-top:40px;
		min-height:500px;
		margin: 0 auto;
	}
	.thesis_title_ul li
	{
		padding: 5px 5px;
	}
	
	.error
	{
		color: red;
	}
	.dl-horizontal dt{
		white-space: normal;
		text-align: left; 
	}
	
	.dl-horizontal dd ul{
		list-style-position: inside;
    	padding-left: 0px;
	}
	.well{
		padding: 20px 80px;
	}
	.section
	{
		 margin-bottom: 50px;
	}
	
	.section h3
	{
		 margin-bottom: 20px;
	}
</style>

<?php if(isset($_SESSION['rhd_privilege']) && ($_SESSION['rhd_privilege'] == 'mod&con' || $_SESSION['rhd_privilege'] == 'contributor' ||  $_SESSION['rhd_privilege'] == 'moderator'))
{?>
	
<div class="container">
	<?php include 'nav.php'; ?>
 
	<div class="row content">
   		<?php if($status == 'draft') {?>
    	<div class="col-md-12">
        	<div class="alert alert-success" role="alert">Please check your draft submission below and then click <strong>Submit for Publication</strong> at the bottom of the page.  </div>
        </div>
         <?php } ?>
    	<div class="col-md-12">
        	<?php if($status != 'draft') {?>
                <dl class="dl-horizontal">
                    <dt>Thesis Name: </dt>
                    <dd><a href="<?php echo $link?>"><?php echo $name?></a></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Status: </dt>
                    <dd><span class="label label-info"><?php echo $status?></span></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Created date: </dt>
                    <dd><?php echo substr($createdDate, 0, 10)?></dd>
                </dl>
                <dl class="dl-horizontal">
                    <dt>Last modified date: </dt>
                    <dd><?php echo substr($modifiedDate, 0, 10)?></dd>
                </dl>
            <?php }
			else
			{?>
				<div class="well">
                	<div class="section">
                        <h3>Step 1: About</h3>
                        <p></p>
                        <?php 
                            $part_1 = $validation['part_1'];
                        ?>
                        <dl class="dl-horizontal">
                            <dt>Thesis Name: </dt>
                            <dd><?php echo isset($part_1['error_list']['thesis_title']) ?  '<span class="error"> * ' . $part_1['error_list']['thesis_title']. '</span>'  : stripslashes($thesis_title); ?></dd>
                        </dl>
                        
                        <dl class="dl-horizontal">
                            <dt>Status: </dt>
                            <dd><span class="label label-warning"> <?php echo $status?></span></dd>
                        </dl>
                       
                        <dl class="dl-horizontal">
                            <dt>Student ID: </dt>
                            <dd><?php echo isset($part_1['error_list']['stu_id']) ?  $stu_id . '<span class="error"> * ' . $part_1['error_list']['stu_id']. '</span>'  : $stu_id; ?></dd>
                        </dl>
                        
                        <dl class="dl-horizontal">
                            <dt>Student Name: </dt>
                            <dd><?php echo $stu_first_name . ' ' . $stu_last_name?></span></dd>
                        </dl>
                        
                        <dl class="dl-horizontal">
                            <dt>Student Preferred Name: </dt>
                            <dd><?php echo $stu_first_name_dip . ' ' . $stu_last_name_dip?></dd>
                        </dl>
                        
                      
                        <dl class="dl-horizontal">
                            <dt>Student Email: </dt>
                            <dd><?php echo isset($part_1['error_list']['stu_email']) ?  $stu_email . '<span class="error"> * ' . $part_1['error_list']['stu_email']. '</span>'  : $stu_email; ?></dd>
                        </dl>
                        
                        <dl class="dl-horizontal">
                            <dt>Thesis Type: </dt>
                            <dd><?php echo isset($part_1['error_list']['coursework_type']) ?  $coursework_type . '<span class="error"> * ' . $part_1['error_list']['coursework_type']. '</span>'  : $coursework_type; ?></dd>
                        </dl>
                        
                        <dl class="dl-horizontal">
                            <dt>Topic: </dt>
                            <?php if(isset($part_1['error_list']['topic']['error']))
                            { ?>
                                <dd><?php echo $part_1['error_list']['topic']['error']; ?></dd>
                            <?php }
                            if(count($topic) > 0)
                            {
                                
                                echo '<dd><ul>';
                                for($i=1; $i<=count($topic); $i++)
                                {
                                    $error_msg = '';
                                    if(isset($part_1['error_list']['topic'][$i]['topic_code']))
                                    {
                                        $error_msg = '<span class="error" > * '. $part_1['error_list']['topic'][$i]['topic_code']. '</span>';
                                    }
                                    
                                    echo '<li>Topic code - ' . $topic[$i]['code'] .$error_msg . '</li>';
                                    
                                    $error_msg = '';
                                    if(isset($part_1['error_list']['topic'][$i]['topic_name']))
                                    {
                                        $error_msg = '<span class="error" > * '. $part_1['error_list']['topic'][$i]['topic_name']. '</span>';
                                    }
                                    echo '<li>Topic name -' . $topic[$i]['name'] .$error_msg . '</li>';
                                }
                                echo '</ul></dd>';
                            }
                            
                            ?>
                        </dl>
                        
                        <dl class="dl-horizontal">
                            <dt>Year: </dt>
                            <dd><?php echo isset($part_1['error_list']['comp_yr']) ?  $comp_yr . '<span class="error"> * ' . $part_1['error_list']['comp_yr']. '</span>'  : $comp_yr; ?></dd>
                        </dl>
                        
                        <dl class="dl-horizontal">
                            <dt>School: </dt>
                            <dd><?php echo isset($part_1['error_list']['school_org_unit']) ?  $school_name . '<span class="error"> * ' . $part_1['error_list']['school_org_unit']. '</span>'  : $school_name; ?></dd>
                        </dl>
                        
                        <dl class="dl-horizontal">
                            <dt>Supervisor Name: </dt>
                            <dd><?php echo isset($part_1['error_list']['coord_name']) ?  $coord_name. '<span class="error"> * ' . $part_1['error_list']['coord_name']. '</span>'  : $coord_name; ?></dd>
                        </dl>
                     
                        <dl class="dl-horizontal">
                            <dt>Supervisor Email: </dt>
                            <dd><?php echo isset($part_1['error_list']['coord_email']) ?  $coord_email . '<span class="error"> * ' . $part_1['error_list']['coord_email']. '</span>'  : $coord_email; ?></dd>
                        </dl>
                        
                        <dl class="dl-horizontal">
                            <dt>Abstract: </dt>
                            <?php if(isset($part_1['error_list']['abstract']))
                            {?>
                            <dd><?php echo '<span class="error"> * ' . $part_1['error_list']['abstract']. '</span>'; ?></dd>
                            <?php }
                            else
                            { ?>
                            <dd><?php echo stripslashes($abstract);?></dd>
                             <?php }?>
                             
                            <dt> </dt>
                            <?php if(isset($part_1['error_list']['abstract_attachment']))
                            {?>
                            <dd><?php echo '<span class="error"> * ' . $part_1['error_list']['abstract_attachment']. '</span>'; ?></dd>
                            <?php 
                            }
                            else
                            { ?>
                            <dd><a href = "<?php echo $abstract_attachment[1]['filelink'].'&token='.$token; ?>" target="_blank"> <?php echo $abstract_attachment[1]['filename']; ?> </a></dd>
                            <?php } ?>
                        </dl>
                      
                        <dl class="dl-horizontal">
                            <dt>Keywords: </dt>
                            <dd><?php
							
							 	echo isset($part_1['error_list']['keywords']) ?  stripslashes($keywords) . '<span class="error"> * ' . $part_1['error_list']['keywords']. '</span>'  : stripslashes($keywords);
							
							?></dd>
                        </dl>
                    </div>
                    
                    <div class="section">
                        <h3>Step 2: Upload</h3>
                            <?php 
                                $part_2 = $validation['part_2'];
                            ?>
                            
                            <dl class="dl-horizontal">
                                <dt>Approved version of Thesis: </dt>
                                
                                <?php if(isset($part_2['error_list']['examined_thesis']['error']))
                                { ?>
                                    <dd><?php echo '<span class="error"> * ' . $part_2['error_list']['examined_thesis']['error'] .'</spam>'; ?></dd>
                                <?php }
                                if(isset($examined_thesis) && count($examined_thesis) > 0)
                                {
                                    echo '<dd><ul>';
                                    for($i=1; $i<=count($examined_thesis); $i++)
                                    {
                                        $error_msg = '';
                                        if(isset($part_2['error_list']['examined_thesis'][$i]))
                                        {
                                            $error_msg = '<span class="error" > * '. $part_2['error_list']['examined_thesis'][$i]. '</span>';
                                        }
                                        
                                        echo '<li><a href="' . $examined_attachment[$i]['filelink'] . '&token='. $token .'/" target="_blank">'.$examined_attachment[$i]['filename']. '</a>'. $error_msg . '</li>';
                                        
                                    }
                                    echo '</ul></dd>';
                                }
                                ?>
                            </dl>
                            
                            <dl class="dl-horizontal">
                                <dt>SIGN OFF - Authenticity: </dt>
                                <?php if(isset($part_2['error_list']['authenticity']))
                                { ?>
                                    <dd><?php echo '<span class="error"> * ' .$part_2['error_list']['authenticity'].'</spam>'; ?></dd>
                                <?php }
                                else
                                {?>
                                    <dd><?php echo $authenticity; ?></dd>
                                <?php }
                                ?>
                                
                            </dl> 
                            
                            <dl class="dl-horizontal">
                                <dt>SIGN OFF - Declaration: </dt>
                                <?php if(isset($part_2['error_list']['declaration']))
                                { ?>
                                    <dd><?php echo '<span class="error"> * ' .$part_2['error_list']['declaration'].'</spam>'; ?></dd>
                                <?php }
                                else
                                {?>
                                    <dd><?php echo $declaration; ?></dd>
                                <?php }
                                ?>
                                
                            </dl> 
                    </div>
                    
                    <div class="section">
                         <h3>Step 3: Public Release</h3>
                            <?php 
                                $part_3 = $validation['part_3'];
                            ?>
                            <dl class="dl-horizontal">
                                <dt>Open Access: </dt>
                                <?php if(isset($part_3['error_list']['open_access_required']))
                                {?>
                                <dd><?php echo '<span class="error"> * ' . $part_3['error_list']['open_access_required']. '</span>'; ?></dd>
                                <?php }
                                else
                                { ?>
                                <dd><?php 
								
								if($open_access_required == 'new version')
								{
									echo 'My open access version is different from my examined thesis (I have removed third party copyright, confidential, or sensitive material as required)';
								}
								else
								{
									echo 'My examined thesis is my open access version';
								}
								?>
							    </dd>
                                 <?php }?>
                            </dl>
                            
                            <?php 
                            if($open_access_required == 'new version')
                            {?>
                                <dl class="dl-horizontal">
                                    <dt>Open Access Version of Thesis: </dt>
                                    
                                    <?php if(isset($part_3['error_list']['open_access']['error']))
                                    { ?>
                                        <dd><?php echo '<span class="error">* '.$part_3['error_list']['open_access']['error'].'</spam>'; ?></dd>
                                    <?php }
                                    if(isset($open_access) && count($open_access) > 0)
                                    {
                                        echo '<dd><ul>';
                                        for($i=1; $i<=count($open_access_attachment); $i++)
                                        {
                                            $error_msg = '';
                                            if(isset($part_3['error_list']['open_access'][$i]))
                                            {
                                                $error_msg = '<span class="error" > * '. $part_2['error_list']['open_access'][$i]. '</span>';
                                            }
                                            
                                            echo '<li><a href="' . $open_access_attachment[$i]['filelink'] . '&token='. $token .'/" target="_blank">'.$open_access_attachment[$i]['filename']. '</a>'. $error_msg . '</li>';
                                            
                                        }
                                        echo '</ul></dd>';
                                    }
                                    ?>
                                </dl>
                            <?php } ?>
                            
                            <dl class="dl-horizontal">
                                <dt>Release of the open access version of your thesis: </dt>
                                
                                <?php if(isset($part_3['error_list']['release_status']))
                                { ?>
                                    <dd><?php echo '<span class="error"> * ' .$part_3['error_list']['release_status'].'</spam>'; ?></dd>
                                <?php }
                                else
                                {?>
                                    <dd><?php if($release_status == 'Restricted Access')
											{
													echo 'Request embargo (released at end of embargo period.)';
											} 
											else if($release_status == 'Open Access')
											{
												echo 'Release immediately';
											}?></dd>
                                <?php }
                                ?>
                            </dl>
                            
                            <?php 
                                if($release_status == 'Restricted Access')
                                {?>
                                     <dl class="dl-horizontal">
                                        <dt>Duration of Embargo: </dt>
                                        
                                        <?php if(isset($part_3['error_list']['embargo_standard_request_duration']))
                                        { ?>
                                            <dd><?php echo '<span class="error"> * ' .$part_3['error_list']['embargo_standard_request_duration'] .'</span>'; ?></dd>
                                        <?php }
                                        else
                                        {?>
                                            <dd><?php echo $embargo_standard_request_duration . ' months'; ?></dd>
                                        <?php }
                                        ?>
                                    </dl>
                                    
                                    <dl class="dl-horizontal">
                                        <dt>Embargo Request Reason: </dt>
                                        
                                        <?php if(isset($part_3['error_list']['embargo_standard_request_reason']))
                                        { ?>
                                            <dd><?php echo '<span class="error"> * ' .$part_3['error_list']['embargo_standard_request_reason'].'<.span>'; ?></dd>
                                        <?php }
                                        else
                                        {?>
                                            <dd><?php echo stripslashes($embargo_standard_request_reason); ?></dd>
                                        <?php }
                                        ?>
                                    </dl>
                                    
                                    <?php 
                                        if(intval($embargo_standard_request_duration) == 36 )
                                        {?>
                                            <dl class="dl-horizontal">
                                            <dt>Embargo Extesion Request: </dt>
                                            <dd><?php if(isset($embargo_extension) && $embargo_extension!= '')
													  { 
													  	 echo  $embargo_extension . '( additional 18 months).'; 
													  }
													  else
													  {
														  echo 'No';
													  }
												?>
                                            </dd>
                                            </dl>
                                            <?php 
                                            if(isset($embargo_extension) && $embargo_extension == 'Additional Restriction')
                                            {?>
                                                 <dl class="dl-horizontal">
                                                    <dt>Reason for Extended Embargo: </dt>
                                                    
                                                    <?php if(isset($part_3['error_list']['embargo_extension_request_reason']))
                                                    { ?>
                                                        <dd><?php echo '<span class="error"> * ' . $part_3['error_list']['embargo_extension_request_reason'] .'</span>'; ?></dd>
                                                    <?php }
                                                    else
                                                    {?>
                                                        <dd><?php echo stripslashes($embargo_extension_request_reason); ?></dd>
                                                    <?php }
                                                    ?>
                                                </dl>
                                             <?php } ?>
                                        </dl>
                                        
                                    <?php } ?>
                                    
                                    
                                  
                                    
                                    <dl class="dl-horizontal">
                                        <dt>Embargo Statement: </dt>
                                        
                                        <?php if(isset($part_3['error_list']['embargo']))
                                        { ?>
                                            <dd><?php echo '<span class="error"> * ' .$part_3['error_list']['embargo'].'</span>'; ?></dd>
                                        <?php }
                                        else
                                        {?>
                                            <dd><?php echo $embargo; ?></dd>
                                        <?php }
                                        ?>
                                    </dl>
                                    
                                    
                            <?php } ?>
                            
                            <dl class="dl-horizontal">
                                <dt>SIGN OFF - Copyright: </dt>
                                <?php if(isset($part_3['error_list']['copyright']))
                                { ?>
                                    <dd><?php echo '<span class="error"> * ' .$part_3['error_list']['copyright'].'</spam>'; ?></dd>
                                <?php }
                                else
                                {?>
                                    <dd><?php echo $copyright; ?></dd>
                                <?php }
                                ?>
                                
                            </dl> 
                    </div>
				</div>
			 <?php } ?>
             <?php if($status == 'draft') {?>
             <div id="submit_button"></div>
               <?php }?>
        </div>
        <div class="col-md-3">
        </div>
    </div>
</div>

<script type="text/javascript">
	var newThesis = "<?php echo isset($new_thesis) ? $new_thesis : false ?>";

	var i_disabled = true;
	
	<?php 
	if($valid)
	{?>
		i_disabled = false;
	<?php }
	else
	{?>
		i_disabled = true;
	<?php }?>
	
	
	var submit_url =  <?php echo json_encode(base_url('rhd/coursework/submitForModeration')) ?>;
	var new_url = "<?php echo base_url() ?>" + "rhd/coursework/index/";
	
	var item_uuid = "<?php echo isset($uuid) ? $uuid : ''; ?>";
	var item_version ="<?php echo isset($version) ? $version : ''; ?>";
</script>
<script type="text/javascript" src="<?php echo base_url() . 'resource/rhd/';?>js/step4.js"></script>


<?php
} //end of IF session exists
include 'footer.php';
?>