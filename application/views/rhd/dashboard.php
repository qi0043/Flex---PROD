<?php
include 'header.php';
?>
<script type="text/javascript">
$(function() {
	    /*$(".draft-edit-button").mouseover(function() {
    		$( this ).parent().prev().fadeOut( 100 );
  			$( this ).parent().prev().fadeIn( 500 );
                });*/
		$( "#btn_contribute" ).click(function(){
			 //$( "#myResources" ).html("Thesis Submission - basic information");
			 $( ".submissionForm" ).css("display","block");
			 $( "#btn_contribute" ).prop("disabled", true);
			 $( "#btn_contribute" ).hide();
			// $( ".button_group" ).hide();
			 //$( ".button_group" ).css("display", "none");
			// $( ".deposit_des" ).hide();
			 //$( ".deposit_des" ).css("display", "none");
			// $( ".about_area" ).hide();
			 //$( ".about_area" ).css("display", "none");
			 //$( ".status_area").hide();
			 //$( ".status_area").css("display", "none");
		});

		$( "#cancel_thesis_btn" ).click(function(){
			 $(".spinner-wave").fadeOut('slow');
			// $( "#myResources" ).html("My Resources");
			 $( ".submissionForm" ).hide();
			 $( "#btn_contribute" ).prop("disabled", false);
			 $( ".button_group" ).show();
			 $( ".deposit_des" ).show();
			 $( ".about_area" ).show();
			 $( "#btn_contribute" ).show();
			 $( "#submit_thesis_btn" ).prop("disabled", false);

			// $( ".status_area").show();
		});

		$( "#submit_thesis_btn" ).click(function(){
			//check thesis type
			var thesisType = $("#selType option:selected").text();

			var stuID = $.trim($("#stuID").val());
		   // var prfStuName = $.trim($("#prfStuName").val());
			//var prfStuLastName = $.trim($("#prfStuLastName").val());
		    var stuEmail = $.trim($("#stuEmail").val());
		    var supName = $.trim($("#supName").val());
		    var thesisType = $("#selType option:selected").text();
		    var title = $.trim($("#thesisTitle").val());

			//var compYear = $.trim($("#hiddenYear").val());
			var compYear = $.trim($("#compYear").val());


			var school = $("#selSchool option:selected").text();

		    if(stuID.length <= 0 || stuEmail.length <= 0 || supName.length <= 0 ||thesisType.length <= 0 ||title.length <= 0 ||school.length <= 0)
		    {
			  alert("Please fill in the requested information.");
			  $( "#submit_thesis_btn" ).prop("disabled", false);
			  return false;
		    }
			//check email
			var stuEmail = $.trim($("#stuEmail").val());
			var supEmail = $.trim($("#supEmail").val());
			if(!validateEmail(stuEmail))
			{
				alert('Preferred Email Contact is not valid');
				$("#stuEmail").focus();
				return false;
		    }

			if(supEmail!= '' && !validateEmail(supEmail))
			{
				alert('Principal Supervisor Email is not valid');
				$("#supEmail").focus();
				return false;
			}

			if(compYear != '')
			{
				var subYear = compYear.toString().substring(0,2);
				if( subYear!= '20' || Math.floor(compYear) != compYear || $.isNumeric(compYear) == false || compYear.length != 4)
				{
					//var currentYear = new Date().getFullYear();
					alert('Year of completion is not valid');
					$("#compYear").focus();
					return false;
				}
			}

			submit_request();
		});

		function submit_request()
    	{
          $( "#submit_thesis_btn" ).prop("disabled", true);
			var stuID = $.trim($("#stuID").val());
			//var prfStuName = $.trim($("#prfStuName").val());
			//var prfStuLastName = $.trim($("#prfStuLastName").val());
			var stuEmail = $.trim($("#stuEmail").val());
			var supName = $.trim($("#supName").val());
			
			var thesisType = $("#selType option:selected").text();
			var title = $.trim($("#thesisTitle").val());
			//var compYear = $.trim($("#hiddenYear").val())+'-01-01';
			var compYear = $.trim($("#compYear").val())+'-01-01';
			var supEmail = $.trim($("#supEmail").val());
			var school = $.trim($("#selSchool option:selected").text());
		 	var url =   <?php echo json_encode(base_url('rhd/rhdMgt/createRHD')); ?>;

          	var posting = $.post( url,
                    { "stuID" : stuID,
                      //"prfStuName" : prfStuName,
					 // "prfStuLastName" : prfStuLastName,
                      "stuEmail" : stuEmail,
                      "supName" : supName,
                      "thesisType" : thesisType,
					  "title": title,
					  "compYear": compYear,
					  "supEmail": supEmail,
					  "school": school
                     }
                );
		   $(".spinner-wave").show();
		   posting.done(function( data,status ) {
			   var resultobj = jQuery.parseJSON(data);
              if(status == 'success')
              {
				   var resultobj = jQuery.parseJSON(data);
             	   var result_status = resultobj.status;
				   switch(result_status)
				   {
					   case 'itemExists':
					   		$(".spinner-wave").fadeOut('slow');
					   		alert( "Thesis title already exists" );
							$( "#submit_thesis_btn" ).attr("disabled", false);
					   break;
					   case 'success':
					       var uuid = resultobj.uuid;
						   var version = resultobj.version;
						   var title = resultobj.itemName;
						   var token = resultobj.token;

						   $( ".submissionForm" ).hide();
						   $( "#submit_thesis_btn" ).hide();
						   $( ".deposit_des" ).hide();
						   $( ".about_area" ).show();
						   var href = 'https://flex.flinders.edu.au/items/'+ uuid + '/' + version + '?token='+token;
						   var equellaLink = $('<a>',{
							class: 'equellaLink',
							id:'equellaLink',
    						text: title,
							title: title,
    						href: href
						  }).appendTo('.responseLi');

						 /* var ul_drafts = $('<ul>', {
							  class: 'ul_drafts',
							  id: 'temp_ul'
						  }).appendTo('.responseLi');*/

						  var date = new Date();
						  var year = date.getFullYear();
						  var month = ('0' + (date.getMonth() + 1)).slice(-2);
						  var day = ('0' + date.getDate()).slice(-2);
						  var current_date = year + '-' + month + '-' + day;

						  var p_draft = $('<p>', {
							  class: 'li_details',
							  html: "<span class='label label-warning'>Draft</span>&nbsp; <i>Registration complete - no thesis deposit</i>"
						  }).appendTo('.responseLi');

						  var ext_ul = $('<ul>', {
							  class: 'ul_drafts',
							  id: 'ul_drafts_ext'
						  }).appendTo('.responseLi');

						  var li_drafts = $("<li>", {
							  text: 'Created date: ' + current_date
						  }).appendTo('#ul_drafts_ext');

						  var li_draft = $('<li>', {
							  text: 'Last modified date: ' + current_date
						  }).appendTo('#ul_drafts_ext');

						  var equellaButton = $('<a>',{
							class: 'btn btn-primary',
							id:'equellaButton',
    						text: ' Deposit Thesis ',
							title:' Deposit Thesis ',
							style:' margin-top: 20px; padding: 5px 25px',
    						href: href
						  }).appendTo('.responseButton');

						   $('.responseArea').show();

						   $(".spinner-wave").fadeOut('slow');
						  // location.reload(true);
					   break;
				   }
              }
			  else
              {
				  $(".spinner-wave").fadeOut('slow');
				  //$( "#myResources" ).html("My Resources");
                  $( "#submit_thesis_btn" ).prop("disabled", false);
              }

          });
          posting.fail(function(xhr, status, error) {
			  $(".spinner-wave").fadeOut('slow');
			 // $( "#myResources" ).html("My Resources");
			alert("Error: " + xhr.status + " " + error);
			$( "#submit_thesis_btn" ).attr("disabled", false);
          });
    	}


	    /*$("#selYear").on("change", function()
		{
			var year = $("#selYear option:selected").text();
			$("#hiddenYear").val(year);
			$("#selSchool option").remove();
			if(year != '')
			{
				var url = <?php echo json_encode(base_url('rhd/rhdMgt/getSchools')); ?>;
				var posting = $.post( url,
					{ "year" : year}
				);
				$(".spinner-wave").show();
				posting.done(function( data,status ) {
				  var resultobj = jQuery.parseJSON(data);
				 // alert(status);
				  if(status == 'success')
				  {
					   $(".spinner-wave").fadeOut('slow');
					   var resultobj = jQuery.parseJSON(data);
					   var result_status = resultobj.status;
						//alert(result_status);
					   switch(result_status)
					   {
						   case 'yearNotExist':
								$(".spinner-wave").fadeOut('slow');
								alert( "Please select a valid year" );
								//$( "#submit_thesis_btn" ).attr("disabled", false);
						   break;
						   case 'success':
							   var school = resultobj.schools
							   var schools = jQuery.parseJSON(school);

							   for(i=0; i<Object.keys(schools).length-1; i++)
							   {
								  var sl = $("<option>"+schools[i].term+"</option>").appendTo("#selSchool");
							   }
						   break;
					   }
				  }
				  else
				  {
					  $(".spinner-wave").fadeOut('slow');

					  //$( "#myResources" ).html("My Resources");
				  }
				});
			    posting.fail(function(xhr, status, error) {
				  $(".spinner-wave").fadeOut('slow');
				  // $( "#myResources" ).html("My Resources");
				  alert("Error: " + xhr.status + " " + error);
				  $( "#submit_thesis_btn" ).attr("disabled", false);
			    });
			 }
		 });*/

		 function validateEmail($email) {
 			 var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  			return emailReg.test( $email );
		 }
	});
</script>



<?php
$flag = false;
if(isset($data['live']))
{
	if(count($data['live']) > 0)
	{
		$flag = true;
	}
}
if(isset($data['draft']))
{
	if(count($data['draft']) > 0)
	{
		$flag = true;
	}
}
if(isset($data['rejected']))
{
	if(count($data['rejected']) > 0)
	{
		$flag = true;
	}
}
if(isset($data['moderating']))
{
	if(count($data['moderating']) > 0)
	{
		$flag = true;
	}
}
?>

<div class="container-fluid">
    <div id="page-content" class="row">
        <aside class="col-md-1">
        </aside>
        <div class="col-md-9">
            <div class="row  container-fluid">
                <div class="col-md-8">
                    <div class="status_area">
						<?php /*?><?php if(count($data['live']) > 0 || count($data['draft']) > 0 || count($data['rejected']) > 0 || count($data['moderating']) > 0 )
                        {?>
<?php */?>
						<?php if($flag){ ?>
                        <div class='row'>
                            <h2>Deposit Progress</h2>
                        </div>
                        <?php  if(isset($data['live'])){

                            echo "<div class='row'><ul class='thesis_title_ul'>";
                            for($i=0; $i<count($data['live']); $i++)
                            {
                                $position = stripos($data['live'][$i]['createdDate'], 'T');
                                $subpos = substr($data['live'][$i]['createdDate'], 10, 1);
                                $createDate = '';

                                if($subpos != false && $subpos == 'T' && $position == 10)
                                {
                                    $createDate = substr($data['live'][$i]['createdDate'], 0, 10);
                                }
                                $position = stripos($data['live'][$i]['modifiedDate'], 'T');
                                $subpos = substr($data['live'][$i]['modifiedDate'], 10, 1);
                                $modifiedDate = $data['live'][$i]['modifiedDate'];
                                if($subpos != false && $subpos == 'T' && $position == 10)
                                {
                                    $modifiedDate = substr($data['live'][$i]['modifiedDate'], 0, 10);
                                }


                                echo "<div class='row'>";
                                echo "<li class='li_links'> <a href='https://flex.flinders.edu.au/items/".$data['live'][$i]['uuid']."/". $data['live'][$i]['version']. "?token=". $token. "'>". $data['live'][$i]['name']."</a>";
                                echo "<p class='li_details'><col-md- class='label label-warning'>Open access version available</col-md-><i> <strong>Thesis deposit completed</strong> </i></p>";
                                    echo "<ul class='ul_details'>";
                                            echo "<li> Created date: ".$createDate;
                                            echo "<li> Last modified date: ".$modifiedDate."</li>";
                                    echo "</ul>";
                                echo "</li></div>";
                            }
                            echo "</ul></div>";
                        }

                        if(isset($data['draft']))
                        {
                            echo "<div class='row'><ul class='thesis_title_ul'>";
                            $status = 'draft';
                            for($i=0; $i<count($data['draft']); $i++)
                            {
                                if($data['draft'][$i]['createdDate'] == $data['draft'][$i]['modifiedDate'])
                                {
                                    $status = ' Registration complete - no thesis deposit';
                                }
                                else
                                {
                                    $status = ' thesis deposit incomplete';
                                }

                                $position = stripos($data['draft'][$i]['createdDate'], 'T');
                                $subpos = substr($data['draft'][$i]['createdDate'], 10, 1);
                                $createDate = '';

                                if($subpos != false && $subpos == 'T' && $position == 10)
                                {
                                    $createDate = substr($data['draft'][$i]['createdDate'], 0, 10);
                                }

                                $position = stripos($data['draft'][$i]['modifiedDate'], 'T');
                                $subpos = substr($data['draft'][$i]['modifiedDate'], 10, 1);
                                $modifiedDate = '';
                                if($subpos != false && $subpos == 'T' && $position == 10)
                                {
                                    $modifiedDate = substr($data['draft'][$i]['modifiedDate'], 0, 10);
                                }

                                echo "<div class='col-md-12 tr_draft' id='td_".$data['draft'][$i]['uuid']."'>";
                                    echo "<li>";
                                    echo "<a href='https://flex.flinders.edu.au/items/".$data['draft'][$i]['uuid']."/". $data['draft'][$i]['version']."?token=" . $token. "'>". $data['draft'][$i]['name']."</a>";
                                        echo "<p class='li_details'><col-md- class='label label-warning'>Draft</col-md-><i> &nbsp; " .$status . "</i></p>";
                                        echo "<ul class='ul_drafts'>";
                                            echo "<li> Created date: ".$createDate."</li>";
                                            echo "<li> Last modified date: ".$modifiedDate."</li>";
                                        echo "</ul>";
                                    echo "</li>";
                                echo "</div>";

                                echo "<div class='col-md-12 tr_draft' style='margin-left: 0'>";
                                    echo "<a href='https://flex.flinders.edu.au/items/".$data['draft'][$i]['uuid']."/". $data['draft'][$i]['version']. "?token=". $token. "'  class='btn btn-primary' style='margin-top: 20px; margin-bottom: 20px'>&nbsp; Deposit Thesis &nbsp;</a>";
                                    echo "</div>";

                            }
                            echo "</ul></div>";
                        }

                        if(isset($data['moderating']))
                        {
                            echo "<div class='row'><ul class='thesis_title_ul'>";

                            for($i=0; $i<count($data['moderating']); $i++)
                            {
                                $position = stripos($data['moderating'][$i]['createdDate'], 'T');
                                $subpos = substr($data['moderating'][$i]['createdDate'], 10, 1);
                                $createDate = '';

                                if($subpos != false && $subpos == 'T' && $position == 10)
                                {
                                    $createDate = substr($data['moderating'][$i]['createdDate'], 0, 10);
                                }
                                $position = stripos($data['moderating'][$i]['modifiedDate'], 'T');
                                $subpos = substr($data['moderating'][$i]['modifiedDate'], 10, 1);
                                $modifiedDate = $data['moderating'][$i]['modifiedDate'];
                                if($subpos != false && $subpos == 'T' && $position == 10)
                                {
                                    $modifiedDate = substr($data['moderating'][$i]['modifiedDate'], 0, 10);
                                }

                                echo "<div class='row'>";
                                echo "<a href='https://flex.flinders.edu.au/items/".$data['moderating'][$i]['uuid']."/". $data['moderating'][$i]['version']. "?token=". $token. "'>". $data['moderating'][$i]['name']."</a>";
                                echo "<p class='li_details'> <col-md- class='label label-warning'>Moderating</col-md-><i><strong> Thesis deposit in moderation (by Faculty, OGR, Library)</strong></i><p>";
                                    echo "<ul class='ul_details'>";
                                        echo "<li> Created date: ".$createDate."</li>";
                                        echo "<li> Last modified date: ".$modifiedDate."</li>";
                                    echo "</ul>";
                                echo "</div>";
                            }
                            echo "</ul></div>";
                        }

                        if(isset($data['rejected']))
                        {
                            echo "<div class='row'><ul class='thesis_title_ul'>";

                            for($i=0; $i<count($data['rejected']); $i++)
                            {
                                $position = stripos($data['rejected'][$i]['createdDate'], 'T');
                                $subpos = substr($data['rejected'][$i]['createdDate'], 10, 1);
                                $createDate = '';

                                if($subpos != false && $subpos == 'T' && $position == 10)
                                {
                                    $createDate = substr($data['rejected'][$i]['createdDate'], 0, 10);
                                }
                                $position = stripos($data['rejected'][$i]['modifiedDate'], 'T');
                                $subpos = substr($data['rejected'][$i]['modifiedDate'], 10, 1);
                                $modifiedDate = $data['rejected'][$i]['modifiedDate'];
                                if($subpos != false && $subpos == 'T' && $position == 10)
                                {
                                    $modifiedDate = substr($data['rejected'][$i]['modifiedDate'], 0, 10);
                                }
                                echo "<div class='row'>";
                                echo "<li class='li_links'> <a href='https://flex.flinders.edu.au/items/".$data['rejected'][$i]['uuid']."/". $data['rejected'][$i]['version']. "?token=". $token. "'>". $data['rejected'][$i]['name']."</a>";
                                #echo "<li class='li_links'>" . $data['rejected'][$i]['name'];
                                    echo "<ul class='ul_details'>";
                                        echo "<li class='li_details'><col-md- class='label label-warning'>data: Rejected</col-md-></li>";
                                            echo "<ul>";
                                                echo "<li> Created date: ".$createDate;
                                                echo "<li> Last modified date: ".$modifiedDate."</li>";
					    echo "</ul>";
                                        echo "</li>";
                                    echo "</ul>";
                                echo "</li>";
				echo "</div>";

				echo "<div class='col-md-12 tr_draft' style='margin-left: 0'>";
                                    echo "<a href='https://flex.flinders.edu.au/items/".$data['rejected'][$i]['uuid']."/". $data['rejected'][$i]['version']. "?token=". $token. "'  class='btn btn-primary' style='margin-top: 20px; margin-bottom: 20px'>&nbsp; Update Thesis Deposit &nbsp;</a>";
                                    echo "</div>";

                            }
                            echo "</ul></div>";
                        }
                        } ?>

                        <div class="responseArea" style="display: none">
                        <div class='row'>
                            <h2>Deposit Progress</h2>
                        </div>

                        <div class='row'>
                                <ul class='thesis_title_ul'>
                                    <div class='col-md-12 tr_draft'>
                                        <li class='responseLi' >

                                        </li>
                                    </div>
                                    <div class='col-md-12 tr_draft responseButton' style='margin-left: 0'>
                                    </div>
                                </ul>
                        </div>
                        </div>
                    </div> <!-- end of status area-->

                    <!-- contribute  button -->
                    <div class="button_group">
                    <?php
                        $flag_f = true;

                        if(isset($data['live']))
                        {
                            if(count($data['live']) > 0)
                            {
                                $flag_f = false;
                            }
                        }


                        if(isset($data['draft']))
                        {
                            if(count($data['draft']) > 0)
                            {
                                $flag_f = false;
                            }
                        }


                        if(isset($data['rejected']))
                        {
                            if(count($data['rejected']) > 0)
                            {
                                $flag_f = false;
                            }
                        }


                        if(isset($data['moderating']))
                        {
                            if(count($data['moderating']) > 0)
                            {
                                $flag_f = false;
                            }
                        }

                    ?>
                     <?php  if($flag_f){?>
                        <div class="button-groups">
                             <div class='deposit_des'>
                                <div class='row'>
                                    <h2>Deposit thesis registration</h2>
                                    <p class="text-warning"><i>This website is for RHD students whose thesis has been examined, and where it needs to be deposited in the Library before graduation.</i></p>
                                    <p>Please register your intention to deposit your thesis.</p>
                                </div>
                                <div class='row'>
                                <button type="button" id="btn_contribute" class="btn btn-primary">&nbsp;Register now&nbsp;</button>
                                </div>
                             </div>
			</div>
			<div>
			        <br><br>
                                <h4>Notice: Professional Doctorates and Masters</h3>
				The following are not RHD awards
                                <ul>
																	<li><b>Doctor of Public Health</b> (DrPH) commenced before 2013</li>
																	<li><b>Doctor of Education</b> (EdD) commenced before 2014</li>
																	<li><b>Masters by Coursework</b></li>
                                </ul>
                                Please submit theses for these awards at the coursework theses site:<br>
                                <a href="https://flextra.flinders.edu.au/flex/thesis/coursework">https://flextra.flinders.edu.au/flex/thesis/coursework</a>

			</div>

                     <?php }
                     ?>
                    </div>
                    <!-- spinner -->
                    <div class="spinner-wave" style="display:none; position:fixed;top:30%; left:40%;z-index:100; overflow:auto">
                    <div style="z-index:100;"></div>
                    <div style="z-index:100;"></div>
                    <div style="z-index:100;"></div>
                    <div style="z-index:100;"></div>
                    <div style="z-index:100;"></div>
                    <p style="z-index:100;" id="txt_loading">&nbsp;Loading...</p>
                    </div>

                    <!-- submissionForm -->
                    <div class="submissionForm" style="display: none; margin-bottom:20px">
                    <form action="createRHD" class="form-horizontal" id="createRhdForm" role="form">
                    <div class="row">
                    <h3>Step 1: Your Details</h3>
                    </div>

                    <div class="form-group">
                    <label for="stuID" class="control-label col-sm-3" >Student ID Number <font style="color:red">*</font></label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" name="stuID" id="stuID" placeholder="">
                    </div>
                    </div>

                    <?php /*?><div class="control-group">
                    <label for="prfStuName" class="control-label">Preferred First Name Display <font style="color:red">*</font></label>
                    <div class="controls">
                    <input type="text" class="form-control" name="prfStuName" id="prfStuName" placeholder="">
                    </div>
                    </div>

                    <div class="control-group">
                    <label for="prfStuLastName" class="col-md-3 control-label">Preferred Last Name Display <font style="color:red">*</font></label>
                    <div class="controls">
                    <input type="text" class="form-control" name="prfStuLastName" id="prfStuLastName" placeholder="">
                    </div>
                    </div><?php */?>

                    <div class="form-group">
                    <label for="stuEmail" class="control-label col-sm-3">Preferred Email Contact <font style="color:red">*</font></label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" name="stuEmail" id="stuEmail" placeholder="">
                    </div>
                    </div>

                    <div class="row">
                    <h3>Step 2: Thesis Type, School and Supervisor</h3>
                    </div>

                    <div class="form-group">
                    <label for="selType" class="col-sm-3 control-label">Thesis Type <font style="color:red">*</font> </label>
                    <div class="col-sm-9">
                    <select class="form-control" name="selType" id="selType">
                        <option></option>
                        <option>Doctor of Philosophy</option>
                        <option>Professional Doctorate</option>
                        <option>Masters by Research</option>
                    </select>
                    </div>
                    </div>


                    <div class="form-group">
                        <label for="compYear" class="col-md-3 control-label">Year of Completion</label>
                        <div class="col-sm-9">
                        <input type="text" class="form-control" name="compYear" id="compYear" placeholder="">
                        </div>
                    </div>

                    <?php /*?><div class="form-group">
                        <label for="selSchool" class="col-sm-3 control-label">Year of Completion <font style="color:red">*</font> </label>
                        <div class="col-sm-9">
                        <select class="form-control" name="selYear" id="selYear">
                        <option></option>
                             <?php
                                if(isset($schools))
                                {
                                    for($i = (count($schools)-2); $i>=0; $i--)
                                    {
                                        echo "<option value='".$schools[$i]['term']."'>".$schools[$i]['term']."</option>";
                                    }
                                }
                            ?>
                        </select>
                        </div>
                        <div class="controls">
                        <input type="hidden" id="hiddenYear"></input>
                        </div>
                    </div><?php */?>



                    <div class="form-group">
                        <label for="selSchool" class="col-sm-3 control-label">School <font style="color:red">*</font> </label>
                        <div class="col-sm-9">
                        <select class="form-control" name="selSchool" id="selSchool">
                            <?php
							echo "<option value=''></option>";
                            if(isset($schools))
                            {
                                for($i = 0; $i<(count($schools)); $i++)
                                {
                                    echo "<option value='".$schools[$i]."'>".$schools[$i]."</option>";
                                }
                            }
                             ?>
                        </select>
                        </div>
                    </div>

                    <div class="form-group">
                    <label for="supName" class="col-sm-3 control-label">Principal Supervisor Name <font style="color:red">*</font></label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" name="supName" id="supName" placeholder="">
                    </div>
                    </div>

                    <div class="form-group">
                    <label for="supEmail" class="col-sm-3 control-label">Principal Supervisor Email</label>
                    <div class="col-sm-9">
                    <input type="text" class="form-control" name="supEmail" id="supEmail" placeholder="">
                    </div>
                    </div>



                    <div class="row">
                    <h3>Step 3: About Your Thesis</h3>
                    <br />
                    </div>

                    <div class="form-group">
                    <label for="thesisTitle" class="col-sm-3 control-label">Thesis Title <font style="color:red">*</font></label>
                    <div class="col-sm-9">
                    <textarea rows="5" id="thesisTitle" class="form-control" name="thesisTitle" placeholder=""></textarea>
                    </div>
                    </div>


                    <div class="row">
                    <br/>
                    <button type="button" id="submit_thesis_btn" class="btn btn-primary">&nbsp;&nbsp;Save and Continue&nbsp;&nbsp;</button>
                    &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button type="button" id="cancel_thesis_btn" class="btn btn-primary">&nbsp;&nbsp;Cancel&nbsp;&nbsp;</button>
                    <br/>

                    </div>
                    </form>
                    </div> <!--end of submissionForm-->
           		</div>
                <aside class="col-md-4">
                    <div class="block" style="background-color:#F3F3F3">
                        <h3>Before you start</h3>
                        <p>Check that you are familiar with how to prepare for submission of your final thesis:</p>
                        <ul>
                        	<li><a href="http://flinders.libguides.com/thesisdeposit" target="_blank">Digital Thesis Submission</a></li>
                        </ul>
                        <p><strong>Checklist - you will need</strong></p>
                        <ol>
                            <li>The title of your thesis and the abstract — to copy and paste into the submission.</li>
                            <li>Your thesis
                                <ul>
                                	<li>All files that make up the final, approved version of your thesis.</li>
                                </ul>
                            </li>
                            <li>Keywords to help people find your thesis.</li>
                        </ol>
                        <p><strong>You may also need</strong></p>
                        <ol>
                            <li>An open access version of your thesis </li>
                            <li>A PDF version of your abstract if it has unusual formating.</li>
                        </ol>
                        <p><strong>Embargo requests</strong></p>
                        <ol>
                        	<li>You will need to enter the reason for the request.</li>
                        </ol>
                    </div>
                    <div class="row about_area"></div>
                </aside> <!-- help documents -->
            </div>
        </div>
        <aside class="col-md-1">

        </aside>
	</div>
</div>
</div>
<?php
include 'footer.php';
?>
