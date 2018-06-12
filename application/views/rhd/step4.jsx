import React ,{Component} from 'react';
import ReactDOM from 'react-dom';

var uuid = item_uuid;
var version = item_version;
var url = submit_url;
var redirect_url = new_url;
var newThesis = newThesis;
var disabled = disabled;

var error_style ={
    color: 'red'
};

var span_style={
    color:'#62a4D3'
};
	
var spinner_wave_style=
{
    position:'fixed',
    top:'30%', 
    left:'40%',
    zIndex:'100',
    overflow:'auto'
};
	
var spinner_style={
    zIndex:'100',
    margin: '1px 1px'
};

class Submit_button extends React.Component{

        constructor(props) {    /* Note props is passed into the constructor in order to be used */
            super(props);
            this.state = {
                loading:false,
                error: false,
                errorMsg: ''
            };
           this.handleSubmit = this.handleSubmit.bind(this);
        }
    
		handleSubmit()
		{
			var valid = true;
			if(valid)
			{
				//console.log('relesae status: '  + this.state.radio_button_value);
				var data = {};
				//var uuid = "<?php echo isset($uuid) ? $uuid : ''; ?>";
				//var version = "<?php echo isset($version) ? $version : ''; ?>";
				data.item_uuid = uuid;
				data.item_version= version;
				data.new_thesis = this.props.newThesis;
				
				//var url = <?php echo json_encode(base_url('rhd/newItem/submitForModeration')) ?>;
				this.setState({
					loading: true
				});
            
				$.ajax({
					  url: url,
					  type: 'POST',
					  data: data,
					  success: function(response) {
						var resultobj = jQuery.parseJSON(response);
						var result_status = resultobj.status;
						switch(result_status)
						{
							case 'success':
								$('html, body').animate({ scrollTop: 0 }, 1000);
								//var new_url = "<?php echo base_url() ?>" + "rhd/newItem/index/";
								window.location = new_url;
								
								this.setState({
									loading: false
								});
							break;
							case 'error':
								this.setState({
									loading: false,
									error: true,
									errorMsg: resultobj.error_info
								});
								//$('html, body').animate({ scrollTop: 0 }, 1000);
							break;
						}
					  }.bind(this),
					  error: function(xhr, status, err) {
						this.setState({
							loading: false,
							error: true,
							errorMsg : 'Internal Error, please try again or contact flex.help@flinders.edu.au for help',
						});
						//$('html, body').animate({ scrollTop: 0 }, 1000);
					  }.bind(this)
				}); //End of Ajax
			} //End of Valid
		}
    
		render(){
			var loading = (this.state.loading)? 
								<div className="spinner-wave" style={spinner_wave_style}>
								<div style={spinner_style}></div>
								<div style={spinner_style}></div>
								<div style={spinner_style}></div>
								<div style={spinner_style}></div>
								<div style={spinner_style}></div>
								<p style={spinner_style} id="txt_loading">&nbsp;Prcessing...</p>
								</div>:<div></div>;
			var error = (this.state.error)?<div className="alert alert-danger" role="alert" id="app_error"><button type="button" className="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{this.state.errorMsg}</div>:<div></div>;
			return (
				<div>
					{loading}
					<button type="button" className="btn btn-primary" onClick={this.handleSubmit} disabled={this.props.disabled}>{this.props.text}</button>
				</div>
			)
		}
	}

	ReactDOM.render(
		<Submit_button newThesis = {newThesis} text="Submit for moderation" disabled={disabled} />,
		document.getElementById('submit_button')
	);