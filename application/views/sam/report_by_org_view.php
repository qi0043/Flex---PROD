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

</style>
</head>
<body>

<div class="flex-container">
  <div class="main">
  	<div class="header"><h2><?php echo $org_name . " SAM Assessment Report"; ?></h2></div>
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
		
        componentDidMount: function() {
            this.loadDataFromServer();
        },
        
		
        render: function(){
            return (
				<div>
                <div className="react_table">
                     {this.state.loading ? <div className="load">loading...</div> : 
                     <ReactBsTable data={this.state.data} striped={true} hover={true} exportCSV={true} csvFileName={"SAM_Report.csv"} trClassName={trClassFormat}>
					 	 <TableHeaderColumn  dataField="sam_name" width="300" columnClassName={tdClassFormat} dataFormat={nameFormatter} dataAlign="LEFT"  filter={{type: "TextFilter", placeholder: "SAM Name"}}>SAM Name</TableHeaderColumn>
						 <TableHeaderColumn  dataField="status" columnClassName={tdClassFormat} dataAlign="LEFT"  filter={{type: "TextFilter", placeholder: "Status"}}>Status</TableHeaderColumn>
						 <TableHeaderColumn  dataField="topic_coords" columnClassName={tdClassFormat} dataAlign="LEFT" filter={{type: "TextFilter", placeholder: "Topic Coordinator(s)"}}>Topic Coordinator(s)</TableHeaderColumn>
						 <TableHeaderColumn  dataField="assess_no"  dataAlign="LEFT" >No.</TableHeaderColumn>
						 <TableHeaderColumn  dataField="assessment_name"  dataAlign="LEFT">Assessment Name</TableHeaderColumn>
						 <TableHeaderColumn  dataField="format" width="300" dataAlign="LEFT" >Assessment Format</TableHeaderColumn>
						 <TableHeaderColumn  dataField="proportion"  dataAlign="LEFT" >Assessment Proportion</TableHeaderColumn>
                         <TableHeaderColumn  dataField="deadline" dataAlign="LEFT">Assessment Deadline</TableHeaderColumn>
						 <TableHeaderColumn  dataField="penalties" dataAlign="LEFT">Assessment penalties</TableHeaderColumn>
						 <TableHeaderColumn  dataField="return_date" dataAlign="LEFT" >Assessment Return Date</TableHeaderColumn>
						 <TableHeaderColumn isKey={true} dataField="item_id" hidden={true} dataAlign="LEFT">Item ID</TableHeaderColumn>
                      </ReactBsTable>
                      }
                </div>
				</div>
            )
        }
    });
   
   	
    function trClassFormat(rowData,rowIndex){
	   return rowData.key == true?"tr-key":"tr-no-key";
	}
	
	function tdClassFormat(fieldValue,row,rowIdx,colIdx){
		return row.key == true?"td-key":"td-no-key";
	}
	
	function nameFormatter(cell, row){
		return row.key == true ? '<a href="https://flex.flinders.edu.au/items/'+ row.item_uuid + '/' + row.item_version +'" target="_blank">' + row.sam_name + '</a>' : row.sam_name;
	}
	ReactDOM.render(
		<Table url="https://flextra.flinders.edu.au/flex/sam/report/getByOrgNum/<?php echo $org_num ?>" />,
        document.getElementById("content")
    );
</script>
</body>
</html>
