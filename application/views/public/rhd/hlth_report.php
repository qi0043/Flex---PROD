<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<link rel="stylesheet" href="<?php echo base_url() . 'resource/public/rhd/build/';?>react-bootstrap-table/css/react-bootstrap-table-all.min.css">
<link rel="stylesheet" href="<?php echo base_url() . 'resource/public/rhd/';?>bootstrap-3.3.4-dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="<?php echo base_url() . 'resource/public/rhd/';?>bootstrap-3.3.4-dist/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo base_url() . 'resource/public/rhd/';?>bootstrap-3.3.4-dist/css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/public/rhd/';?>css/flextra-er.css" media="all">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'resource/public/rhd/';?>css/rhd.css" media="all">
<!-- Local styles -->
<script type="text/javascript" src="<?php echo base_url() . 'resource/public/rhd/';?>js/jquery-1.10.2.min.js"></script>
<script src="<?php echo base_url() . 'resource/public/rhd/';?>bootstrap-3.3.4-dist/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url() . 'resource/public/rhd/';?>build/react.js"></script>
<script src="<?php echo base_url() . 'resource/public/rhd/';?>build/react-dom.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.23/browser.min.js"></script>
<script src="<?php echo base_url(). 'resource/public/rhd/build/';?>react-bootstrap-table/dist/react-bootstrap-table.min.js" ></script>
    
<link rel="shortcut icon" href="<?php echo base_url();?>resource/public/rhd/images/favicon.ico"> 
<title>Flinders University - HLTH RHD Theses Report</title>
    
<style>
.flex-container {
    display: -webkit-flex;
    display: flex;  
    -webkit-flex-flow: row wrap;
    flex-flow: row wrap;
}

.flex-container > * {
    padding: 10px;
    flex: 1 100%;
}

.header h2{
	text-align: center;
}
.load
{
	text-align: center;
}
td
{
	white-space:normal !important;
}
</style>  

</head>
<body>

<div id="header" role="banner">
    <div id="header-inner">
        <div class="badge"></div>
        <div class="banner"><?php echo $heading;?></div>
    </div>
</div>

<div class="flex-container" style="padding-top:20px">
  <div class="main">
    <div id="content"></div>
  </div>
</div>


<div class="footer" role="footer">
  <hr />
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <p class="text-muted"></p>
      </div>
      <div class="col-md-6">
        <p class="text-muted text-center">Flinders University: RHD Theses - School of Health Sciences</p>
      </div>
      <div class="col-md-3">
        <p class="text-muted text-right"></p>
      </div>
    </div>
  </div>
</div>
<script type="text/babel">
    var decodeHtmlEntity = function(str) {
  		return str.replace(/&#(\d+);/g, function(match, dec) {
    		return String.fromCharCode(dec);
  		});
	};
	
    var ReactBsTable = window.BootstrapTable;		  
	var theses = [];	  
	<?php if(isset($rhds))
	{
		foreach($rhds as $thesis)
		{
			?>
			var temp = {};
			temp["thesis_name"] = "<?php echo isset($thesis['title']) ? $thesis['title'] : '' ?>";
			temp["release_status"] = "<?php echo isset($thesis['release_status']) ? $thesis['release_status'] : '' ?>";
			temp["complete_year"] = "<?php echo isset($thesis['complete_year']) ? $thesis['complete_year'] : '' ?>";
			var student_name = "<?php echo isset($thesis['student_name']) ? $thesis['student_name'] : '' ?>";
			temp["student_name"] = decodeHtmlEntity(student_name);
			
			var sup_name = "<?php echo isset($thesis['coords_name']) ? $thesis['coords_name'] : '' ?>";
			temp["supervisor_name"] = decodeHtmlEntity(sup_name);
			
			temp["thesis_type"] = "<?php echo isset($thesis['thesis_type']) ? $thesis['thesis_type'] : '' ?>";
			temp["release_date"] = "<?php echo isset($thesis['release_date']) ? $thesis['release_date'] : '' ?>";
			temp["uuid"] = "<?php echo isset($thesis['item_uuid']) ? $thesis['item_uuid'] : '' ?>";
			temp["version"] = "<?php echo isset($thesis['item_version']) ? $thesis['item_version'] : '' ?>";
			
			theses.push(temp);
	<?php		
		}
	}
	?>

	var releaseType = {
		"Restricted Access": "Restricted",
		"Open Access": "Open"
	};
	
	var thesisType ={
		"Doctor of Philosophy": "Doctor of Philosophy",
		"Masters by Research": "Masters by Research",
		"Professional Doctorate":"Professional Doctorate"
	};
	
     var Table = React.createClass({
       
        render: function(){
            return (
                <div className="table-responsive">
                     <ReactBsTable data={this.props.data} striped={true} hover={true}>
					 	 <TableHeaderColumn isKey={true} dataField="uuid" hidden={true} dataAlign="LEFT">UUID</TableHeaderColumn>
						 <TableHeaderColumn dataField="complete_year" dataAlign="LEFT" filter={{type: "TextFilter", placeholder: ""}}>Year</TableHeaderColumn>
						 <TableHeaderColumn dataField="student_name"  dataAlign="LEFT" filter={{type: "TextFilter", placeholder: "Author"}}>Author</TableHeaderColumn>
					 	 <TableHeaderColumn dataField="thesis_name"  dataAlign="LEFT" dataFormat={nameFormatter} filter={{type: "TextFilter", placeholder: "Thesis title"}}>Title</TableHeaderColumn>
						 
						 <TableHeaderColumn dataField="release_status"  dataAlign="LEFT" dataFormat={releaseFormatter} filter={{type: "SelectFilter", options: releaseType}}>Access</TableHeaderColumn>
						 
						 <TableHeaderColumn dataField="release_date" dataSort={true} sortFunc={dateSortFunc} dataAlign="LEFT" filter={{type: "TextFilter", placeholder: "Release Date"}}>Release Date</TableHeaderColumn>
						
						 <TableHeaderColumn dataField="thesis_type"  dataAlign="LEFT" dataFormat={enumFormatter} filter={{type: "SelectFilter", options: thesisType}} formatExtraData={thesisType} >Award</TableHeaderColumn>
						 <TableHeaderColumn dataField="supervisor_name"  dataAlign="LEFT" filter={{type: "TextFilter", placeholder: "Supervisor"}}>Supervisor</TableHeaderColumn>
                        
						
                      </ReactBsTable>
                </div>
				
            )
        }
    });
   
    function dateSortFunc(a, b, order){   //order is desc or asc
		if(order === 'desc'){
			return new Date(a.release_date).getTime() - new Date(b.release_date).getTime();
		}
		else
		{
			return new Date(b.release_date).getTime() - new Date(a.release_date).getTime();
		}
	}
   
	function releaseFormatter(cell, row)
	{
		var release = ''
		if(row.release_status == 'Restricted Access')
		{
			release = 'Restricted';
		}
		if(row.release_status == 'Open Access')
		{
			release = 'Open';
		}
		return release;
	}
	
	function nameFormatter(cell, row){
		return '<a href="<?php echo base_url() . 'public/rhd/view/';?>'+ row.uuid+ '/' + row.version +'" target="_blank">' + row.thesis_name + '</a>';
	}
	function emFormatter(cell, row){
		return row.release_status == 'Restricted Access' ? 'Restricted' : 'Open';
	}
	function enumFormatter(cell, row, enumObject){
		return enumObject[cell];
	}
	
	ReactDOM.render(
		<Table data={theses}/>
		,document.getElementById('content')
	);
   
</script>

</body>
</html>