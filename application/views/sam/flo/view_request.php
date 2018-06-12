

<h2>View request details</h2>

<table>
    <tr>
        <th colspan="2">Student details</th>
    <tr>
        <td>Name:</td>
        <td><?php echo $request['applicant_name']; ?></td>
    </tr>
    <tr>
        <td>FAN:</td>
        <td><?php echo $request['applicant_fan']; ?></td>
    </tr>
    <tr>
        <td>Email address:</td>
        <td><?php echo $request['applicant_email']; ?></td>
    </tr>
    <tr>
        <th colspan="2">Assignment details</th>
    </tr>
    <tr>
        <td>Topic:</td>
        <td><?php echo $request['topic']; ?></td>
    </tr>
    <tr>
        <td>Assignment:</td>
        <td><?php echo $request['name']; ?></td>
    </tr>
    <tr>
        <td>Due date:</td>
        <td><?php echo ($request['due_date']); ?></td>
    </tr>
    <tr>
        <th colspan="2">Extension details</th>
    </tr>
    <tr>
        <td>Requested ext. date:</td>
        <td><?php echo $request['proposed_duedate']; ?> </td>
    </tr>
    <tr>
        <td>Request reason:</td>
        <td><?php echo $request['request_reason']; ?></td>
    </tr>
    <tr>
        <td>Requested on:</td>
        <td><?php echo ($request['created_date']); ?></td>
    </tr>
     <?php
	  if ($request['status'] == 'approved'){
	 ?>
     	<tr>
        	<td>New Due Date:</td>
        	<td><?php echo $request['extension_date']; ?></td>
        </tr>
     <?php
	  }
	 ?>
    <tr>
        <td>Hand in Hardcopy:</td>
        <td><?php echo ($request['hand_in_evidence'] == 1) ? 'Yes' : 'No' ?></td>
    </tr>
    <tr>
        <?php if ($request['status'] != 'canceled'){ #documents removed once req is canceled ?>
        <td>Uploaded documents:</td>
        <td><?php echo ($evidences) ? 'Yes' : 'No' ?></td>
        <?php } ?>
    </tr>
    
    <?php if($evidences != false ) {?>
    <tr>
        <th>Uploaded Documents</th>
        <th>Student note</th>
    </tr>
   
    <?php   if($evidences != false){?>
		<!--<form id = "form_get_file" action="<?php echo site_url("request/getfile"); ?>" method="post" target="_blank">-->
                <?php $attributes = array('id' => 'form_get_file', 'target' => '_blank');
                echo form_open('request/getfile', $attributes); ?>
		    <input type="hidden" id="file_id" name="fid"/>
		<?php $count = count($evidences);
        for ($i=0; $i<$count; $i++)
        {?>
    <tr>
        <td>
            <?php if($is_approver == true){ ?>
            
            <a href="javascript:void(0);" onclick="javascript: $('#file_id').val('<?php echo $evidences[$i]['fid'] ?>'); $('#form_get_file').submit();"> Attachment <?php echo ($i+1);?></a>
            <?php /*?><a href="getfile?id=<?php echo $evidences[$i]['fid'];?>" target ="_blank"> Attachment <?php echo ($i+1);?> </a><?php */?>
            </form>
            <?php  } else { ?>
            Attachment <?php echo ($i+1);?>
            <?php } ?>
        </td>
                    
        <td>
            <?php echo $evidences[$i]['stud_note'];?>
        </td>
    </tr>
            
    <?php }?>
    	</form>
    <?php }?>
      
    
     <?php } ?>
    
    <tr>
        <th colspan="2">Status</th>
    </tr>
    <tr>
        <td>Status:</td>
        <td><?php echo $request['status']; ?></td>
    </tr>
    <tr>
        <td>Comment:</td>
        <td><?php echo ($request['status_comment'] == '') ? '' : $request['status_comment']; ?></td>
    </tr>
    <tr>
        <td>Actioned by:</td>
       
        <td><?php echo ($request['approver_flo_person_id'] == '') ? 'Not yet actioned' : $request['approver'][0]['name']; ?>
        </td>
    </tr>
    <tr>
        <td>Actioned on:</td>
        <td><?php echo ($request['last_updated_date'] == '' ? 'Not yet actioned' : ($request['last_updated_date'])); ?>
    </tr>
</table>

<br>
    
<table style="border:none">
<tr style="border:none">
<td style="border:none">
<button class="btn btn-primary" onclick="document.location.href='<?php echo site_url('request'); ?>'; return false;">Back to list</button> 

</td>
<td style="border:none">
<?php if ($request['status'] == 'pending') { ?>

<?php $attributes = array('id' => 'form_cancel_request', 'onsubmit' => "javascript: return (confirm('Are you sure you want to cancel this extension request?'));");
echo form_open('request/cancel', $attributes); ?>
    <input type='hidden' name='request_id' value="<?php echo $request['request_id']; ?>" />
    
    <button class="btn btn-primary" type="submit" name="submit1" value="Withdraw request">Withdraw request</button>

</form>

<?php } ?>
  </td>
  </tr>
  <table>  
  
 
