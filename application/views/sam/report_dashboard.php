<?php
include 'header.php';
?>
<style type="text/css">
	html, body, div, span, applet, object, iframe, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, center, dl, dt, dd, ol, ul, li, fieldset, form, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
		margin: 0;
		padding: 0;
		border: 0;
		font: inherit;
		vertical-align: baseline;
	}
	body {
		box-sizing: border-box;
		color: #373737;
		/*background: #f2f2f2;*/
		font-size: 16px;
		font-family: 'Myriad Pro', Calibri, Helvetica, Arial, sans-serif;
		line-height: 1.5;
		-webkit-font-smoothing: antialiased;
	}
	

	#main_content_wrap {
		/*background: #f2f2f2;*/
		
	}
	.outer {
		width: 100%;
	}
	.inner, .div_report {
		position: relative;
		max-width: 1000px;
		padding: 20px 10px;
		margin: 0 auto;
	}
	#main_content {
		padding-top: 40px;
	}
	
	#main_content h1 {
		font-size: 36px;
		font-weight: 700;
	}
	.form-group
	{
		margin-top: 20px;
	}
	.form-group label
	{
		font-size:larger;
		padding-bottom:15px;
    }
	
	
	
</style>
<script type="text/javascript">
$(function() {
	 $("#sel_schools").change(function(){
		 $("#div_report_link").empty();
		 var selectedValue =  $("#sel_schools option:selected").val();
		 var selectedText = $("#sel_schools option:selected").text();
		 if(selectedValue != '#')
		 {
			 var reportLink = $('<a>',{
						class: 'report_link',
						id:'report_link_'+ selectedValue,
						text: 'Click to display report -- ' + selectedText,
						title: 'Report -- ' + selectedText,
						target: '_blank',
						href: 'https://flextra.flinders.edu.au/flex/sam/report/dashboard/'+selectedValue
					  }).appendTo('#div_report_link');
		 }
		 else
		 {
			 $("#div_report_link").empty();
		 }
		  
	});
	
	 $("#sel_disciplines").change(function(){
		 $("#div_report_dis_link").empty();
		 var selectedValue =  $("#sel_disciplines option:selected").val();
		 var selectedText = $("#sel_disciplines option:selected").text();
		 
		 if(selectedValue != '#')
		 {
			var reportLink = $('<a>',{
					class: 'report_link',
					id:'report_link_'+ selectedValue,
					text: 'Click to display report -- ' + selectedText,
					title: 'Report -- ' + selectedText,
					target: '_blank',
					href: 'https://flextra.flinders.edu.au/flex/sam/report/discipline/'+selectedValue
				  }).appendTo('#div_report_dis_link');
		 }
		 else
		 {
			 $("#div_report_dis_link").empty();
		 }
		  
	});
	
	
});
</script>
        
    	<div id="main_content_wrap" class="outer">
            <div class="inner">
             <?php /*?> <h1>
                <?php
                    if(isset($avail_yrs['from']) && isset($avail_yrs['to']))
                    {
                        $str =  "Flinders University topic availabilities (";
                        if($avail_yrs['to'] != 'missed')
                        {
                            $str .= $avail_yrs['from'] . " - " . $avail_yrs['to'];
                        }
                        else
                        {
                            $str .= $avail_yrs['from'];
                        }
                        
                        $str .= ')';
                        
                        echo $str;
                    }
                ?>
                </h1><?php */?>
                
                <ul class="list-group">
                  <li class="list-group-item">
                  	<div class="form-group">
                      <label for="sel_schools">SAMs by School</label>
                      <select class="form-control" id="sel_schools">
                        <option value='#'>Please select a school name</option>
                        <?php 
                        for($i=0; $i<count($schools); $i++)
                        {
                            echo "<option value='".$schools[$i]["org_num"]."'>". $schools[$i]["school_name"]."</option>";
                        }
                        ?>
                        
                      </select>
                    </div>
                    <div class="div_report">
                        <div id="div_report_link">
                        
                        </div>
                    </div>
                  </li>
                   <li class="list-group-item" style="background: #f2f2f2;">OR</li>
                  <li class="list-group-item">
                      <div class="form-group">
                          <label for="sel_disciplines">SAM by Discipline / Subject area</label>
                          <select class="form-control" id="sel_disciplines">
                            <option value="#">Please select a discipline</option>
                            <?php 
                            for($i=0; $i<count($disciplines); $i++)
                            {
                                echo "<option value='".$disciplines[$i]."'>". $disciplines[$i]."</option>";
                            }
                            ?>
                          </select>
                    </div>
                    <div class="div_report">
                        <div id="div_report_dis_link">
                        
                        </div>
                    </div>
                  </li>
                </ul>
            </div>
            
            
        </div>
 <?php
include 'footer.php';
?>