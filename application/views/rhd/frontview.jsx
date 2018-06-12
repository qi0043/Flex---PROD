import React ,{Component} from 'react';
import ReactDOM from 'react-dom';

var thesisURL = thesis_link ;
var last_modified_date = modifiedDate;
var url = submitURL;
var new_url = createURL;
var redirect_url = newURL;
var status = t_status;
var uuid = item_uuid;
var version = item_version;
var name = t_name;
var valid = isValid;


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

class Help extends React.Component {
	render() {
		return (
			<div className="col-md-3">
        		<div className="well">    
                	<h3>Before you start</h3>
                	<p>Check that you are familiar with how to prepare for submission of your final thesis:</p>
					<ul>
						<li><a href="http://flinders.libguides.com/thesisdeposit" target="_blank">Digital Thesis Submission</a></li>
					</ul>
                	<p><strong>Checklist - you will need</strong></p>                       
					<ol>
                           <li>The topic code you are enrolled in for your research component, eg.  ENGR9700D and PHCA9512. Do not use code like ENGR9700A-D.</li>
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
    		</div>
		)
	}
}

class New extends React.Component {

	handleClick() {
		window.location = new_url;
	}

	render() {
		return (
			<div className="button-groups">
				<div className='deposit_des'>
					<div className='row'>
						<h2>Deposit thesis</h2>
						<p className="text-warning"><i>This website is for Coursework students whose thesis has been examined, and where it needs to be deposited in the Library.</i></p>
						
					</div>
					<div className='row'>
						<br/>
						<br/>
						<button type="button" className="btn btn-primary" onClick={this.handleClick}>&nbsp;Deposit thesis now&nbsp;</button> 
					</div>
				</div> 
			</div>
		)
	}
}

class Button extends React.Component {
	render() {
		return (
			<button type="button" className="btn btn-primary submitButton" onClick={this.props.buttonClick} >{this.props.text}</button>
		)
	}
}


class Content extends React.Component {
    constructor(props) {    /* Note props is passed into the constructor in order to be used */
        super(props);
        this.state = {
            loading:false,
            error: false,
		   errorMsg: ''
        };
        this.submitThesis= this.submitThesis.bind(this);
    }

	submitThesis()
	{
		var data = {};
		
		data.item_uuid = this.props.uuid;
		data.item_version= this.props.version;
		data.new_thesis = false;
		
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
						window.location = redirect_url;
						
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
					break;
				}	
			  }.bind(this),
			  error: function(xhr, status, err) {
				this.setState({
					loading: false,
					error: true,
					errorMsg : 'Internal Error, please try again or contact flex.help@flinders.edu.au for help',
				});
			  }.bind(this)
		});
	}

	viewThesis()
	{
		window.location = thesisURL;
	}

	redraftViewThesis()
	{
		window.location = thesisURL + '0/1/';
	}
	
	render() {
		var loading = (this.state.loading)? 
								<div className="spinner-wave" style={spinner_wave_style}>
								<div style={spinner_style}></div>
								<div style={spinner_style}></div>
								<div style={spinner_style}></div>
								<div style={spinner_style}></div>
								<div style={spinner_style}></div>
								<p style={spinner_style} id="txt_loading">&nbsp;Loading...</p>
								</div>:<div></div>;
		var error = (this.state.error)?<div className="alert alert-danger" role="alert" id="app_error"><button type="button" className="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{this.state.errorMsg}</div>:<div></div>;
		var staus_statement = '';
		var button = '';
         var link = '';
		var text = '';
		switch(this.props.status)
		{
			case 'draft':
				text = <p><i>This thesis deposit is not finished.</i></p>
				if(this.props.valid)
				{
					staus_statement = <strong> Please finalise and submit for publication. </strong>;
					button = <div><Button buttonClick = {this.viewThesis} text='Edit'/> &nbsp; &nbsp; <Button buttonClick = {this.submitThesis} text='Submit for publication'/></div>;
					
				}
				else
				{
					staus_statement = <span className=""> Thesis deposit incomplete. </span>;
					button = <Button buttonClick = {this.viewThesis} text='Complete thesis deposit'/>;
				}
			break;
			
			case 'moderating':
				text = <p><i>Congratulations. You have successfully uploaded your thesis to the Flinders University Thesis collection.</i></p>
				
				staus_statement = <span className="lead"> Thesis deposit in moderation (by Faculty, DVCA, Library).</span>;
				
				button = <Button buttonClick = {this.viewThesis} text='View submission'/>;
			break;
			
			case 'live':
				staus_statement = <strong> Thesis deposit complete. </strong>;
				//button = <Button buttonClick = {this.viewThesis} text='View'/>;
                  var href = 'https://flextra.flinders.edu.au/flex/public/rhd/view/'+ uuid + '/'+version;
                  link =<div className='public_div'><a href={href} target='_blank'>View thesis public page</a></div>;
				button = '';
			break;
			
			case 'rejected':
				staus_statement = <strong> Please edit and resubmit it.</strong>;
				button = <Button buttonClick={this.redraftViewThesis} text='Edit and submit'/>;
			break;
			
			default:
				staus_statement = '';
			break;
		}
		
		return (
			<div>
				<div className='row'>
					<h3>Deposit Status</h3>
					{text}
					<hr/> 
					
					{loading}
					{error}
					<dl className="dl-horizontal">
						<dt>Thesis title: </dt>
						<dd>{this.props.name}</dd>
					</dl>
					<dl className="dl-horizontal">
						<dt>Status: </dt>
						<dd><span className="label label-info">{this.props.status}</span> &nbsp;{staus_statement} &nbsp;{link}</dd>
					</dl>
					
					<dl className="dl-horizontal">
						<dt>Last modified: </dt>
						<dd>{last_modified_date}</dd>
					</dl>
				</div> 
				<div className='row'>
					<hr/> 
					{button}
				</div>
			</div>
		);
	}
}
	
class App extends React.Component {
	render() {
		var content = '';
		if(this.props.status == 'notCreated')
		{
			content = <New />;
		}
		else
		{
			content = <Content uuid={this.props.uuid} version = {this.props.version} name = {this.props.name} valid = {this.props.valid}  status = {this.props.status}  />;
		}
		return (
			<div className = "col-md-12">
				<div className="col-md-9">
					{content}
				</div>
				<Help />
			</div>
		);
	}
}

ReactDOM.render(
		<App uuid={uuid} version={version} name={name} valid={valid} status={status}/>,
		document.getElementById('content')
	);
