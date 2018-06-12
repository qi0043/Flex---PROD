<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Flinders University Topic Avalabilities</title>
        <script src="<?php echo base_url();?>resource/ocf/js/jquery-1.10.2.min.js"></script> 
        <script src="<?php echo base_url();?>resource/react/build/react.js"></script>
        <script src="<?php echo base_url();?>resource/react/build/react-dom.js"></script>
        <script src="<?php echo base_url();?>resource/react/build/react-with-addons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.23/browser.min.js"></script>
        <script src="<?php echo base_url();?>resource/react/build/reactable.js"></script>   
        
        <style type="text/css">

			html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
				margin: 0;
				padding: 0;
				border: 0;
				font: inherit;
				vertical-align: baseline;
			}
			body {
				box-sizing: border-box;
				color: #373737;
				background: #212121;
				font-size: 16px;
				font-family: 'Myriad Pro', Calibri, Helvetica, Arial, sans-serif;
				line-height: 1.5;
				-webkit-font-smoothing: antialiased;
			}
			
			#main_content_wrap {
				background: #f2f2f2;
				border-top: 1px solid #111;
				border-bottom: 1px solid #111;
			}
			.outer {
				width: 100%;
			}
			.inner {
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
			#main_content table {
				border: 1px solid #373737;
				margin-bottom: 20px;
				text-align: left;
				border-collapse: collapse;
    			border-spacing: 0;
			}
			#main_content #table thead {
				display: table-header-group;
				vertical-align: middle;
				border-color: inherit;
			}
			#table th {
				cursor: pointer;
				font-family: 'Lucida Grande', 'Helvetica Neue', Helvetica, Arial, sans-serif;
				padding: 10px;
				background: #373737;
				color: #fff;
				display: table-cell;
			}
			#main_content #table tr {
				display: table-row;
				vertical-align: inherit;
				border-color: inherit;
			}
			#main_content #table tbody {
				display: table-row-group;
				vertical-align: middle;
				border-color: inherit;
			}
			td {
				padding: 10px;
    			border: 1px solid #373737;
				display: table-cell;
			}
			tr.reactable-filterer {
				width: 100%;
			}
			.reactable-filter-input {
				width: 95%;
				margin-left: 10px;
				margin-top: 7px;
				margin-bottom: 7px;
				margin-right: 20px;
				padding: 5px;
			}
			.reactable-page-button {
				margin-left: 5px;
				margin-right: 2px;
				margin-bottom: 6px;
				padding: 3px;
				width: 30px;
				float: left;
				cursor: pointer;
				color: #000;
				border: 1px solid #AAA;
				background-color: #EEE;
				text-align: center;
				border-radius: 5px;
			}
			
			.reactable-page-button:hover {
			  text-decoration: none;
			  color: #333;
			  background-color: #DDD;
			}
			
			.reactable-current-page {
			  background-color: #DDD;
			  cursor: default;
			}
			
			.reactable-previous-page, .reactable-next-page{
				padding: 5px 5px;
			}
			
			#table th.reactable-header-sort-desc:after {
			  content: '\25B2';
			  font-size: 10px;
			  padding-left: 10px;
			  padding-bottom: 5px;
			}
			
			#table th.reactable-header-sort-asc:after {
			  content: '\25BC';
			  font-size: 10px;
			  padding-left: 10px;
			  padding-bottom: 5px;
			}
			.table_ul
			{
				
			}
			/**********loading spinner***************/
			.spinner-wave {
				margin: 0 auto;
				width: 100px;
				height: 100px;
				text-align: center;
				
			}
			.spinner-wave > div {
				
				background-color: white;
				height: 50%;
				width: 6px;
				display: inline-block;
				-webkit-animation: wave 1.2s infinite ease-in-out;
				animation: wave 1.2s infinite ease-in-out;
			}
			
			.spinner-wave div:nth-child(2) {
				-webkit-animation-delay: -1.1s;
				animation-delay: -1.1s;
			}
			
			.spinner-wave div:nth-child(3) {
				-webkit-animation-delay: -1.0s;
				animation-delay: -1.0s;
			}
			
			.spinner-wave div:nth-child(4) {
				-webkit-animation-delay: -0.9s;
				animation-delay: -0.9s;
			}
			
			.spinner-wave div:nth-child(5) {
				-webkit-animation-delay: -0.8s;
				animation-delay: -0.8s;
			}
			@-webkit-keyframes wave {
				0%, 40%, 100% { -webkit-transform: scaleY(0.4) }
				20% { -webkit-transform: scaleY(1.0) }
			}
			
			@keyframes wave {
				0%, 40%, 100% { transform: scaleY(0.4); }
				20% { transform: scaleY(1.0); }
			}
			/******************************************/
		</style>
    </head>
	<body>
	<div id="main_content_wrap" class="outer">
    	
       
        <section id="main_content" class="inner">
        
        <div>
        	<h1>SAM Report by <?php echo $school_name[0]['org_name']?></h1>
            <section>
                To filter records enter text into the search box. &nbsp;&nbsp;<i>[Note: dates can not be filtered]</i>
                <ul style="list-style-position: inside;">
                    <li>Use zzz if you want to display topic avalabilities that have no SAMs. </li>
                    <li>Approved SAMs (live, archived) display as a link to FLEX.</li>
                    
                </ul>
                To sort the table first click on column heading
            </section>
        </div>
        <div id="table">
        <!-- This element's contents will be replaced with your component. -->
        </div>
        
        <!-- Loading Spinner -->
        <div class="row spinner-wave" style="display:none;  color:white; position:fixed;top:30%; left:40%;z-index:100; overflow:auto">
            <div style="z-index:100; "></div>
            <div style="z-index:100; "></div>
            <div style="z-index:100; "></div>
            <div style="z-index:100; "></div>
            <div style="z-index:100; "></div>
            <p style="z-index:100; color:white" id="txt_loading">&nbsp;Loading...</p>
        </div>
        </section>
    </div>
  
    
   	<script type="text/babel">
		var Table = Reactable.Table,
			Thead = Reactable.Thead,
			Th = Reactable.Th,
			//Tr = Reactable.Tr,
			unsafe = Reactable.unsafe;
		
		var TableBox = React.createClass({
			getInitialState: function() {
				return {data: []};
			},
			loadDataFromServer: function() {
				$(".spinner-wave").show();
				$.ajax({
					url: this.props.url,
					dataType: 'json',
					cache: false,
					success: function(data) {
						console.log("Receiving data - "+data.length + " items")
						for(var i in data)
						{
							data[i].avail_ref = unsafe(data[i].avail_ref);
						}
						$(".spinner-wave").fadeOut('slow');
						this.setState({data: data});
					}.bind(this),
					error: function(xhr, status, err) {
						$(".spinner-wave").fadeOut('slow');
						//console.error(this.props.da, status, err.toString());
						//console.error(this.props.url, status, err.toString());
					}
				});
			},
			
			componentDidMount: function() {
				this.loadDataFromServer();
			},
			
			render: function(){
				return (
					<div className="tableBox">
						<Table className="table table-striped" data={this.state.data} sortable={[{column: 'num_students',sortFunction: function(a, b){return parseInt(a) > parseInt(b) ? 1 : -1;}},{column: 'student_access_date',sortFunction: 'Date'},{column: 'teach_start_date',sortFunction: 'Date'},'avail_ref','topic_name', 'avail_yr', 'discipline', 'school_name', 'status']} itemsPerPage={1500} pageButtonLimit={10} filterable={['avail_ref','topic_name', 'avail_yr', 'discipline', 'school_name', 'status', 'num_students']}>
							<Thead>
								<Th column="avail_ref">
									<strong>Topic Availability</strong>
							  	</Th>
								<Th column="status">
									<strong>Status</strong>
							  	</Th>
								<Th column="num_students">
									<strong>Enrolled Students</strong>
								</Th>
								<Th column="student_access_date">
									<strong>Student Access Date</strong>
								</Th>
								<Th column="teach_start_date">
									<strong>Teaching Start Date</strong>
								</Th>
							  	<Th column="topic_name">
									<strong>Topic name</strong>
							  	</Th>
								<Th column="discipline">
									<strong>Discipline</strong>
								</Th>
								<Th column="school_name">
									<strong>School</strong>
								</Th>
								
							</Thead>
						</Table>
						
					</div>
				);
			}
		});
		
		//var par = {org_num: "370"};
		
		/*ReactDOM.render(
			<TableBox da={par} />
			,document.getElementById('table')
		);*/
		ReactDOM.render(
			<TableBox url="https://flextra.flinders.edu.au/flex/sam/report/get"/>
			,document.getElementById('table')
		);
	</script>
</body>
</html>