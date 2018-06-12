<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title><?php echo $org_name ?> SAMs Assessment Report</title>
  
    <link rel="stylesheet" href="<?php echo base_url() . 'resource/react/build/';?>react-bootstrap-table/css/react-bootstrap-table-all.min.css">
    <link rel="stylesheet" href="<?php echo base_url() . 'resource/rhd/';?>bootstrap-3.3.4-dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="<?php echo base_url() . 'resource/rhd/';?>bootstrap-3.3.4-dist/css/bootstrap.css">
     <link rel="stylesheet" href="<?php echo base_url() . 'resource/rhd/';?>bootstrap-3.3.4-dist/css/bootstrap-theme.css">
    <!-- Local styles -->
    <script type="text/javascript" src="<?php echo base_url() . 'resource/rhd/';?>js/jquery-1.10.2.min.js"></script>
    <script src="<?php echo base_url() . 'resource/rhd/';?>bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>   
    
    <script src="<?php echo base_url() . 'resource/react/';?>build/react.js"></script>
    <script src="<?php echo base_url() . 'resource/react/';?>build/react-dom.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.23/browser.min.js"></script>
    <script src="<?php echo base_url(). 'resource/react/build/';?>react-bootstrap-table/dist/react-bootstrap-table.min.js" ></script>


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

.td-no-key{
	color: white;
}

td
{
	white-space:normal !important;
}

.load
{
	text-align: center;
}

.select-filter
{
	padding: 0px 0px !important;
}

.imgWrap {
  position: relative;
}

.imgDescription {
  position: absolute;
  overflow: visible;
  top: -15px;
  bottom: 0;
  left: 0;
  right: 0;
  color: #333;
  visibility: hidden;
  opacity: 0;

}

.imgWrap:hover .imgDescription {
  visibility: visible;
  opacity: 1;
}
</style>
</head>
<body>

<div class="flex-container">
  <div class="main">
  	<div class="header"><h2><?php echo "SAM Graduate Quality Report"; ?></h2></div>
    <div id="content"></div>
  </div>
</div>



<script type="text/babel">
    var ReactBsTable = window.BootstrapTable;
	
	//var name = 'SP assessments (5 assessments: GIT, Endocrine, Musculoskeletal, Neurology, Cardiorespiratory)';
    var Table = React.createClass({
        getInitialState: function() {
            return {
               loading: true,
               data: []
            };
        },
		
        loadDataFromServer: function() {
			console.log("URL:" + this.props.url);
            $.ajax({                
			    url: this.props.url,
                dataType: 'json',
                cache: false,
                success: function(data) {
                    console.log("Receiving data - "+data.length + " items");
                    this.setState({loading: false});
                    this.setState({data: data});
					
                }.bind(this),
				error: function(xhr, status, err) {
					this.setState({loading: false});
					console.error(status, err.toString());
				}.bind(this)
            });
        },
		
        componentWillMount: function() {
            this.loadDataFromServer();
        },
        
        render: function(){
            return (
				<div>
					<div className="react_table">
						 {this.state.loading ? <div className="load">loading...</div> : 
						 <ReactBsTable data={this.state.data} striped={true} hover={true} exportCSV={true} csvFileName={"SAM_Graduate_Quality_Report.csv"} >
							 <TableHeaderColumn isKey={true} dataField="avail_ref"  hidden={true} dataAlign="LEFT"></TableHeaderColumn>
							 <TableHeaderColumn  dataField="avail_no"  dataAlign="LEFT"  filter={{type: "TextFilter", placeholder: ""}}>avail</TableHeaderColumn>
							 <TableHeaderColumn  dataField="topic_code" dataAlign="LEFT" dataFormat={nameFormatter} filter={{type: "TextFilter", placeholder: ""}}>topic</TableHeaderColumn>
							 <TableHeaderColumn  dataField="avail_yr"  dataAlign="LEFT"  filter={{type: "TextFilter", placeholder: ""}}>year</TableHeaderColumn>
							 <TableHeaderColumn  dataField="sprd_cd" dataAlign="LEFT" filter={{type: "TextFilter", placeholder: ""}}>per</TableHeaderColumn>
							 <TableHeaderColumn  dataField="location_cd"  dataAlign="LEFT" filter={{type: "TextFilter", placeholder: ""}}>loc</TableHeaderColumn>
							 <TableHeaderColumn  dataField="num_students"  dataAlign="LEFT" filter={{type: "TextFilter", placeholder: ""}}>#enrol</TableHeaderColumn>
							 <TableHeaderColumn  dataField="gradqual1_lvl" dataAlign="center" dataFormat={gq1Formatter} filter={{type: 'NumberFilter', options: grad_levels, defaultValue: { comparator: '=' }}}>know</TableHeaderColumn>
							 <TableHeaderColumn  dataField="gradqual2_lvl" dataAlign="center" dataFormat={gq2Formatter} filter={{type: "NumberFilter", options: grad_levels, defaultValue: { comparator: '=' }}}>apply </TableHeaderColumn>
							 <TableHeaderColumn  dataField="gradqual3_lvl" dataAlign="center" dataFormat={gq3Formatter} filter={{type: "NumberFilter", options: grad_levels, defaultValue: { comparator: '=' }}}>comm </TableHeaderColumn>
							 <TableHeaderColumn  dataField="gradqual4_lvl" dataAlign="center" dataFormat={gq4Formatter} filter={{type: "NumberFilter", options: grad_levels, defaultValue: { comparator: '=' }}}>indep </TableHeaderColumn>
							 <TableHeaderColumn  dataField="gradqual5_lvl" dataAlign="center" dataFormat={gq5Formatter} filter={{type: "NumberFilter", options: grad_levels, defaultValue: { comparator: '=' }}}>collab </TableHeaderColumn>
							 <TableHeaderColumn  dataField="gradqual6_lvl" dataAlign="center" dataFormat={gq6Formatter} filter={{type: "NumberFilter", options: grad_levels, defaultValue: { comparator: '=' }}}>ethic </TableHeaderColumn>
							 <TableHeaderColumn  dataField="gradqual7_lvl" dataAlign="center" dataFormat={gq7Formatter} filter={{type: "NumberFilter", options: grad_levels, defaultValue: { comparator: '=' }}}>connect</TableHeaderColumn>
						  </ReactBsTable>
						  }
					</div>
				</div>
            )
        }
    });
   
   	const grad_levels = [ 0, 1, 2, 3];
	
	function tdClassFormat(fieldValue,row,rowIdx,colIdx){
		return row.key == true?"td-key":"td-no-key";
	}
	
	function nameFormatter(cell, row){
		return '<a href="https://flex.flinders.edu.au/items/'+ row.item_uuid + '/' + row.item_version +'" target="_blank">' + row.topic_code + '</a>';
	}
	
	function gq1Formatter(cell, row)
	{
		var level = cell;
		if(row.gradqual1_aa == 't' || row.gradqual1_aa == 'true' || row.gradqual1_aa == true)
		{
			if(level == null || level == '' || level == '0' || level == 0)
			{
				level = '3';
			}
		}
		return getIcon(level);
	}
	
	function gq2Formatter(cell, row)
	{
		var level = cell;
		if(row.gradqual2_aa == 't' || row.gradqual2_aa == 'true' || row.gradqual2_aa == true)
		{
			if(level == null || level == '' || level == '0' || level == 0)
			{
				level = '3';
			}
		}
		return getIcon(level);
	}
	function gq3Formatter(cell, row)
	{
		var level = cell;
		if(row.gradqual3_aa == 't' || row.gradqual3_aa == 'true' || row.gradqual3_aa == true)
		{
			if(level == null || level == '' || level == '0' || level == 0)
			{
				level = '3';
			}
		}
		return getIcon(level);
	}
	
	function gq4Formatter(cell, row)
	{
		var level = cell;
		if(row.gradqual4_aa == 't' || row.gradqual4_aa == 'true' || row.gradqual4_aa == true)
		{
			if(level == null || level == '' || level == '0' || level == 0)
			{
				level = '3';
			}
		}
		return getIcon(level);
	}
	
	function gq5Formatter(cell, row)
	{
		var level = cell;
		if(row.gradqual5_aa == 't' || row.gradqual5_aa == 'true' || row.gradqual5_aa == true)
		{
			if(level == null || level == '' || level == '0' || level == 0)
			{
				level = '3';
			}
		}
		return getIcon(level);
	}
	function gq6Formatter(cell, row)
	{
		var level = cell;
		if(row.gradqual6_aa == 't' || row.gradqual6_aa == 'true' || row.gradqual6_aa == true)
		{
			if(level == null || level == '' || level == '0' || level == 0)
			{
				level = '3';
			}
		}
		return getIcon(level);
	}
	function gq7Formatter(cell, row)
	{
		var level = cell;
		if(row.gradqual7_aa == 't' || row.gradqual7_aa == 'true' || row.gradqual7_aa == true)
		{
			if(level == null || level == '' || level == '0' || level == 0)
			{
				level = '3';
			}
		}
		return getIcon(level);
	}
	
	
	function getIcon(level)
	{
		switch(level)
		{
			case '1':
				return '<div class="imgWrap"><img src="https://flextra.flinders.edu.au/flex/resource/flo/ocf/images/flextra-level-1.svg" alt="level1" width="15" height="15"><p class="imgDescription">Level 1</p></div>';
				break;
		    case '2':
				return '<div class="imgWrap"><img src="https://flextra.flinders.edu.au/flex/resource/flo/ocf/images/flextra-level-2.svg" alt="level2" width="15" height="15"><p class="imgDescription">Level 2</p></div>';
				break;
			case '3':
			    return '<div class="imgWrap"><img src="https://flextra.flinders.edu.au/flex/resource/flo/ocf/images/flextra-level-3.svg" alt="level3" width="15" height="15"><p class="imgDescription">Level 3</p></div>';
				break;
			default:
			 	return '';
				break;
		}
	}
	
	ReactDOM.render(
		<Table url="https://flextra.flinders.edu.au/flex/sam/report/get_gq_data" />,
        document.getElementById("content")
    );
</script>
</body>
</html>
