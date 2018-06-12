<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>Flinders University Research High Degree Theses Report</title>
  
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

<div class="flex-container">
  <div class="main">
  	<div class="header"><h2>Flinders Research High Degree Theses Report</h2></div>
    <div id="content"></div>
  </div>
</div>



<script type="text/babel">
    var ReactBsTable = window.BootstrapTable;
	
	var releaseType = {
		"Restricted Access": "Embargo",
		"Open Access": "Open Access"
	};
	
	var thesisType ={
		"Doctor of Philosophy": "Doctor of Philosophy",
		"Masters by Research": "Masters by Research",
		"Professional Doctorate":"Professional Doctorate"
	};
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
					//console.error(status, err.toString());
				}.bind(this)
            });
        },
		
        componentDidMount: function() {
            this.loadDataFromServer();
        },
        
		
        render: function(){
            return (
				
                <div className="react_table">
                     {this.state.loading ? <div className="load">loading...</div> : 
                     <ReactBsTable data={this.state.data} striped={true} hover={true} exportCSV={true} csvFileName={"RHD_Report.csv"}>
					 	 <TableHeaderColumn isKey={true} dataField="item_uuid" hidden={true} dataAlign="LEFT">UUID</TableHeaderColumn>
						 
					 	 <TableHeaderColumn  dataField="title"  dataAlign="LEFT" width="500" dataFormat={nameFormatter} filter={{type: "TextFilter", placeholder: "Thesis title"}}>Thesis title</TableHeaderColumn>
						 <TableHeaderColumn  dataField="status"  dataAlign="LEFT"  filter={{type: "TextFilter", placeholder: "Status"}}>Status</TableHeaderColumn>
						 
						 <TableHeaderColumn  dataField="school_name"  dataAlign="LEFT" filter={{type: "TextFilter", placeholder: "school"}}>School</TableHeaderColumn>
						 
						 <TableHeaderColumn  dataField="faculty_name"  dataAlign="LEFT" filter={{type: "TextFilter", placeholder: "faculty"}}>Faculty</TableHeaderColumn>
						 
						 <TableHeaderColumn  dataField="release_status" width="200" dataAlign="LEFT" dataFormat={enumFormatter} filter={{type: "SelectFilter", options: releaseType}}formatExtraData={releaseType} >Open Access / Embargo</TableHeaderColumn>
						 <TableHeaderColumn  dataField="thesis_type"  dataAlign="LEFT" dataFormat={enumFormatter} filter={{type: "SelectFilter", options: thesisType}} formatExtraData={thesisType} >Thesis Type</TableHeaderColumn>
						 
                         <TableHeaderColumn  dataField="complete_year" dataAlign="LEFT" filter={{type: "TextFilter", placeholder: "Complete Year"}}>Complete Year</TableHeaderColumn>
						 <TableHeaderColumn  dataField="release_date" dataSort={true} sortFunc={dateSortFunc} dataAlign="LEFT" filter={{type: "TextFilter", placeholder: "Release Date"}}>Release Date</TableHeaderColumn>
						 
                      </ReactBsTable>
                      }
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
    
	
	function nameFormatter(cell, row){
		return '<a href="https://flex.flinders.edu.au/items/'+ row.item_uuid + '/' + row.item_version +'" target="_blank">' + row.title + '</a>';
	}
	function emFormatter(cell, row){
		return row.release_status == 'Restricted Access' ? 'Embargo' : 'Open Access';
	}
	function enumFormatter(cell, row, enumObject){
		return enumObject[cell];
	}
	
	ReactDOM.render(
		<Table url="https://flextra.flinders.edu.au/flex/rhd/rhdMgt/generateReport"/>
		,document.getElementById('content')
	);
</script>
</body>
</html>
