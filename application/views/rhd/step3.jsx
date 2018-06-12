import React ,{Component} from 'react';
import ReactDOM from 'react-dom';

    var uuid = item_uuid;
    var version = item_version;
	var dashboardURL = indexURL;
	var openAccessTheses = theses;
	var openAccessCount = count;

    var part3_url = step3_url;
    var new_url = redirect_url ;
    var session_out_url = session_url; 
	var status = d_status;
    
	var newThesis = new_thesis;
		
	var readonly = !newThesis;
    
	var default_open_access_value = open_access;
	var default_release_status = release_status;
	var default_embargo_radio_button_value = embargo_radio_button_value;
    var embargo_standard_request_reason = default_embargo_standard_request_reason;
	
	var default_copyright_value = copyright_value;
    var default_embargo = embargo;
	var default_embargo_extension_reason = default_embargo_ext_reason;
    var default_embargo_ext_request_value = embargo_ext;
    
	if(status != 'draft')
	{
		newThesis = false;
		readonly = true;
	}


	function formatBytes(bytes,decimals)
	{
	   if(bytes == 0) return '0 Byte';
	   var k = 1000; // or 1024 for binary
	   var dm = decimals + 1 || 3;
	   var sizes = ['Bytes', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
	   var i = Math.floor(Math.log(bytes) / Math.log(k));
	   return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
	}

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
	}

	var spinner_style={
		zIndex:'100',
		margin: '1px 1px'
	};
	
	function hasClass(target, className) {
		return new RegExp('(\\s|^)' + className + '(\\s|$)').test(target.className);
	}
	
	class Button extends React.Component{
    render() {
        return (
            <button type="button" className="btn btn-primary" onClick={this.props.buttonClick} >{this.props.text}</button>
        )
    }
}

class MinusButton extends React.Component{
    render() {
        return (
            <div className="col-md-1 icon">
                <i onClick={this.props.clickHandler} title="Remove" className="glyphicon glyphicon-remove-sign">
                </i>
            </div>
        )
    }
}

class RemoveButton extends React.Component{
    render() {
        return (
            <div className="col-md-1 icon">
                <i onClick={this.props.clickHandler} title="Remove" className="glyphicon glyphicon-trash"></i>
            </div>
        )
    }
}

class DownloadButton extends React.Component{
    constructor(props) { 
        super(props);
        this.download_click= this.download_click.bind(this);
    }

    download_click(e)
    {
        e.preventDefault();
       
        $.ajax({
           url: download_url,
           type: 'POST',
           processData: false, // this has to be set to false
           contentType: false, // this has to be set to false
           error: function(jqXHR, textStatus, errorThrown){
           }.bind(this),
           success: function(data) {
                var resultobj = jQuery.parseJSON(data);
                var result_status = resultobj.status;
                switch(result_status)
                {
                    case 'success':
                        var token = resultobj.token;
                        var newURL = this.props.url+ '&token=' + token;
                        window.open(newURL);
                    break;
                }
           }.bind(this)
        });
    }

    render() {
        return (
            <div className="col-md-1 icon">
                <a href={this.props.url} title="Download" target="_blank" >
                    <span className="glyphicon glyphicon-download-alt"></span>
                </a>
            </div>
        )
    }
}

class UndoButton extends React.Component{
    render() {
        return (
            <div className="col-md-1">
                <i onClick={this.props.clickHandler} title="Undo" className="glyphicon glyphicon-step-backward">
                </i>
            </div>
        )
    }
}
	
	
class InputError extends React.Component{
	  render(){ 
		return (
			  <div style={error_style} className={this.props.visible?'visible':'invisible'}>
				<span style={error_style}>* {this.props.errorMessage}</span>
			  </div>
			
		)
	  }
	}
	
	/******File uploader****/
	class FileUploader extends React.Component{
	constructor(props) { 
        super(props);
        this.state = {
            readonly: this.props.readonly,
            attachment: '',
            help: this.props.help,
            error: false,
            errorMsg: ''
        };
        this.restart = this. restart.bind(this);
        this.editMode = this.editMode.bind(this);
        this.readOnlyMode = this.readOnlyMode.bind(this);
        this.fileUpload = this.fileUpload.bind(this);
        this.validation = this.validation.bind(this);
        this.editHelpMsg = this.editHelpMsg.bind(this);
    }

    restart() {
        this.setState({
            readonly: this.props.readonly,
            attachment: '',
            help: this.props.help,
            error: false,
            errorMsg: ''
        });
    }
    
    editMode() {
        this.setState({
            readonly: false
        });
    }
    
    readOnlyMode() {
        this.setState({
            readonly: true
        });
    }

    fileUpload(e){
        e.preventDefault();
        this.setState({
            error: false,
            errorMsg: "",
            upload_button_visible : false
        });
        if(!(e.target.files.length < 1))
        {
            let file = e.target.files[0];
            let reader = new FileReader();
            if(file.size > 0 && file.type != 'application/pdf' && file.type != 'application/x-zip-compressed')
            {
                try
                {
                    e.target.value = null;
                }
                catch(ex) { }

                if (e.target.value) {
                    e.target.parentNode.replaceChild(e.target.cloneNode(true), e.target);
                }

                this.setState({
                    help: <div style={error_style}>[Warning] No File chosen, please upload a pdf or zip file</div>,
                    upload_button_visible : false
                });
                
            }
            else
            {
                var str = 'Selected File: '+ file.name;
                var size = ' - file size: ' + formatBytes(file.size);
        
                this.setState({
                    help: <div>{str}<span><i>{size}</i></span></div>
                });
            }

            reader.onloadend=()=>{
                if(file.type == 'application/pdf' || file.type == 'application/x-zip-compressed')
                {
                    this.setState({
                        attachment: file,
                        upload_button_visible : true
                    });
                }
            }

            reader.readAsDataURL(file);
        }
    }
        
    validation()
    {
        var valid = true;
        var attachment_obj = this.state.attachment;
        if(attachment_obj.name != ''&& attachment_obj.name != 'undefined' && attachment_obj.name != null)
        {
            if(parseInt(attachment_obj.size) == 0 || attachment_obj.size == '' || attachment_obj.size == 'undefined' || attachment_obj.size == null)
            {
                valid = false;
                this.setState({
                    error: true,
                    errorMsg: 'File upload failed - File size is 0'
                });
            }
            else if(attachment_obj.type != 'application/pdf' && file.type != 'application/x-zip-compressed')
            {
                valid = false;
                this.setState({
                    error: true,
                    errorMsg: 'File upload failed - File type can only be pdf or zip'
                });
            }
        }
        return valid;
    }
    
    editHelpMsg(msg)
    {
        this.setState({
            help: msg
        });
    }

    render() {
        var error = (this.state.error)?<div className="alert alert-danger" role="alert">{this.state.errorMsg}</div>:<div></div>;
        return (
            <div>
                {error}
                <input type="file" className="file_upload form-control-file" ref="file_attachment" name="thesisfiles[]" onChange={this.fileUpload} disabled={this.state.readonly}/>
                <h5 className="text-muted">{this.state.help}</h5>
            </div>
        )
    }
}



	class DefaultFile extends React.Component{
	constructor(props) {
        super(props);
        var text = '';
        if(this.props.default_file_name != '')
        {
            var str = 'File: '+ this.props.default_file_name + ' uploaded.' ;
            var size = ' - file size: ' + formatBytes(this.props.default_file_size);
            text = <div>{str}<span><i>{size}</i></span></div>
        }
        else
        {
            text = this.props.help
            
        }
        this.state = {
            text: text
        };
        this.restart = this.restart.bind(this);
    }
	
    restart()
    {
        var text = '';
        if(this.props.default_file_name != '')
        {
            var str = 'File: '+ this.props.default_file_name + ' uploaded.' ;
            var size = ' - file size: ' + formatBytes(this.props.default_file_size);
            text = <div>{str}<span><i>{size}</i></span></div>
        }
        else
        {
            text = this.props.help
            
        }
        
        this.setState({
            text: text
        });
    }
    
    render() {
        var download_link = this.props.file_link ? <DownloadButton url= {this.props.file_link} /> : ''
        return (
            <div className="row">
                <div className="col-md-11">
                    <h5 className="text-muted">{this.state.text}</h5>
                </div> 
                {download_link}
            </div>
        );
    }
}

	class FileWrapper extends React.Component{
    constructor(props) {
        super(props);
        this.state = {
            visible: true,
            count: this.props.count,
            readonly:this.props.readonly,
            default_file:(this.props.default_file_name) ? true : false,
            uuid: this.props.uuid? this.props.uuid : ''
        };
        this.clickHandler = this.clickHandler.bind(this);
        this.editMode = this.editMode.bind(this);
        this.readOnlyMode = this.readOnlyMode.bind(this);
        this.restart = this.restart.bind(this);
        this.removeClickHandler= this.removeClickHandler.bind(this);
        this.undoClickHandler= this. undoClickHandler.bind(this);
        this.validation= this.validation.bind(this);
    }
		
    clickHandler(){
        var numOfControl = this.state.count;
        if( numOfControl > 1 )
        {
            numOfControl = numOfControl-1;
            this.setState({
                visible: false,
                count: numOfControl
            });
        }
    }
    
    editMode()
    {
        this.setState({
            readonly: false
        });
        if(!this.state.default_file)
        {
            this.refs.file_uploader.editMode();
        }
    }
    
    readOnlyMode()
    {
        this.setState({
            readonly: true
        });
        if(!this.state.default_file)
        {
            this.refs.file_uploader.readOnlyMode();
        }
    }
    
    restart()
    {
        this.setState({
            visible: true,
            count: this.props.count,
            readonly:this.props.readonly,
            default_file:(this.props.default_file_name) ? true : false,
            uuid: this.props.uuid
        });
        if(!this.state.default_file)
        {
            this.refs.file_uploader.restart();
        }
    }
    
    removeClickHandler(){
        this.setState({
            default_file: false
        });
    }
    
    undoClickHandler(){
        this.setState({
            default_file: true
        });
    }
    
    validation()
    {
        var valid = true;
        if(this.state.visible && !this.state.default_file)
        {
            valid = this.refs.file_uploader.validation();
        }

        return valid;
    }
    
    render(){
        var remove_button = (this.state.readonly)? '' : <RemoveButton clickHandler={this.removeClickHandler} /> ;
        var undo_button = (this.props.default_file_name) ? <UndoButton clickHandler={this.undoClickHandler} /> : <div></div>;
        var muniusbutton = this.state.visible && !this.state.readonly && this.state.count > 1 ? <MinusButton clickHandler={this.clickHandler} /> : '';

        var file = this.state.default_file ?
        <div className="row"><div className="col-md-10"><DefaultFile default_file_name = {this.props.default_file_name} default_file_size = {this.props.default_file_size} file_link = {this.props.default_file_link} help={this.props.help} /></div> {remove_button}{muniusbutton}</div>:
        <div className="row"><div className="col-md-10"><FileUploader help={this.props.help} ref="file_uploader" readonly={this.state.readonly}/></div>{undo_button} {muniusbutton}</div>;

        var className="panel panel-default";
        if (!this.state.visible)
        {
            className += ' invisible';
        }

        return(
            <div className={className}>
                <div className="panel-body">
                    {file}
                </div>
            </div>
        );
    }
}

	class FileControl extends React.Component{
	constructor(props) {
        super(props);
        if(this.props.thesisType =='examined')
        {
            if(examinedTheses.length > 0)
            {
                for(var i = 0; i<examinedTheses.length; i++)
                {
                    examinedTheses[i].readonly = this.props.readonly;
                    examinedTheses[i].help = this.props.help;
                }
                this.state = {
                    readonly: this.props.readonly,
                    error: false,
                    errorMsg : '',
                    count: examinedCount,
                    items: examinedTheses,
                    help: this.props.help,
                    loading: false
                };
            }
            else
            {
                var items = [];
                var temp = {};
                temp["item"] = 1;
                temp["ref_name"] = "thesis_1" ;
                temp["default_file_name"] = "";
                temp["default_file_size"] = "";
                temp["default_file_link"] = "";
                temp["readonly"] = this.props.readonly;
                temp["help"] = this.props.help;
                items.push(temp);
                this.state = {
                    loading:false,
                    readonly: this.props.readonly,
                    error: false,
                    errorMsg : '',
                    count: 1,
                    items: items,
                    help: this.props.help

                };
            }
        }
        else if(this.props.thesisType =='openAccess')
        {
            if(openAccessTheses.length > 0)
            {
                for(var i = 0; i<openAccessTheses.length; i++)
                {
                    openAccessTheses[i].readonly = this.props.readonly;
                    openAccessTheses[i].help = this.props.help;
                }
                this.state = {
                    readonly: this.props.readonly,
                    error: false,
                    errorMsg : '',
                    count: openAccessCount,
                    items: openAccessTheses,
                    help: this.props.help,
                    loading: false
                };
            }
            else
            {
                var items = [];
                var temp = {};
                temp["item"] = 1;
                temp["ref_name"] = "thesis_1" ;
                temp["default_file_name"] = "";
                temp["default_file_size"] = "";
                temp["default_file_link"] = "";
                temp["readonly"] = this.props.readonly;
                temp["help"] = this.props.help;
                items.push(temp);
                this.state = {
                    loading:false,
                    readonly: this.props.readonly,
                    error: false,
                    errorMsg : '',
                    count: 1,
                    items: items,
                    help: this.props.help

                };
            }
        }
        else
        {
            var items = [];
            var temp = {};
            temp["item"] = 1;
            temp["ref_name"] = "thesis_1" ;
            temp["default_file_name"] = "";
            temp["default_file_size"] = "";
            temp["default_file_link"] = "";
            temp["readonly"] = false;
            temp["help"] = this.props.help;
            items.push(temp);
            this.state = {
                loading:false,
                readonly: this.props.readonly,
                error: false,
                errorMsg : '',
                count: 1,
                items: items,
                help: this.props.help

            };
        }
        
        this.editMode = this.editMode.bind(this);
        this.handleResetClick = this.handleResetClick.bind(this);
        this.readOnlyMode = this.readOnlyMode.bind(this);
        this.restart = this.restart.bind(this);
        this.handleAddClick = this.handleAddClick.bind(this);
        this.validation = this.validation.bind(this);
        //this.handleSubmit = this.handleSubmit.bind(this);
    }
		
    editMode()
    {
        this.setState({
            readonly: false
        });
        for(var ref in this.refs)
        {
            var i = this.refs[ref];
            i.editMode();
        }
    }
    
    handleResetClick()
    {
        if(this.props.thesisType =='examined')
        {
            if(examinedTheses.length > 0)
            {
                for(var i = 0; i<examinedTheses.length; i++)
                {
                    examinedTheses[i].readonly = this.props.readonly;
                    examinedTheses[i].help = this.props.help;
                }
                this.setState({
                    readonly: this.props.readonly,
                    error: false,
                    errorMsg : '',
                    count: examinedCount,
                    items: examinedTheses,
                    help: this.props.help,
                    loading: false
                });
            }
            else
            {
                var items = [];
                var temp = {};
                temp["item"] = 1;
                temp["ref_name"] = "thesis_1" ;
                temp["default_file_name"] = "";
                temp["default_file_size"] = "";
                temp["default_file_link"] = "";
                temp["readonly"] = this.props.readonly;
                temp["help"] = this.props.help;
                items.push(temp);
                this.setState({
                    loading:false,
                    readonly: this.props.readonly,
                    error: false,
                    errorMsg : '',
                    count: 1,
                    items: items,
                    help: this.props.help
                });
            }
        }
        else if(this.props.thesisType =='openAccess')
        {
            if(openAccessTheses.length > 0)
            {
                for(var i = 0; i<openAccessTheses.length; i++)
                {
                    openAccessTheses[i].readonly = this.props.readonly;
                    openAccessTheses[i].help = this.props.help;
                }
                this.setState({
                    readonly: this.props.readonly,
                    error: false,
                    errorMsg : '',
                    count: openAccessCount,
                    items: openAccessTheses,
                    help: this.props.help,
                    loading:false,
                });
            }
            else
            {
                var items = [];
                var temp = {};
                temp["item"] = 1;
                temp["ref_name"] = "thesis_1" ;
                temp["default_file_name"] = "";
                temp["default_file_size"] = "";
                temp["default_file_link"] = "";
                temp["readonly"] = false;
                items.push(temp);
                this.setState({
                    loading:false,
                    readonly: this.props.readonly,
                    error: false,
                    errorMsg : '',
                    count: 1,
                    items: items,
                    help: this.props.help
                });
            }
        }
        else
        {
            var items = [];
                var temp = {};
                temp["item"] = 1;
                temp["ref_name"] = "thesis_1" ;
                temp["default_file_name"] = "";
                temp["default_file_size"] = "";
                temp["default_file_link"] = "";
                temp["readonly"] = false;
                items.push(temp);
                this.setState({
                    loading:false,
                    readonly: this.props.readonly,
                    error: false,
                    errorMsg : '',
                    count: 1,
                    items: items,
                    help: this.props.help
                });
        }
        
        for(var ref in this.refs)
        {
            var i = this.refs[ref];
            //console.log(i);
            if(i.props.default_file_link == "")
            {
                var index = i.state.count;
                if(i.state.count > 1)
                {
                    index = i.state.count - 1;
                }
                
                i.clickHandler();
                
                var elements = this.state.items;
                elements.splice(index, 1);
                this.setState({
                    count: index,
                    items: elements
                });
                
            }
            else
            {
                i.restart();
            }
        }
    }
    
    readOnlyMode()
    {
        this.setState({
            readonly: true
        });
        for(var ref in this.refs)
        {
            var i = this.refs[ref];
            //i.restart();
            i.readOnlyMode();
        }
    }
    
    restart()
    {
        this.setState({
            readonly: this.props.readonly
        });
        for(var ref in this.refs)
        {
            var i = this.refs[ref];
            i.restart();
        }
    }
    
    handleAddClick()
    {
        var count = this.state.count + 1;
        var temp = {};
        temp['item'] = count;
        temp["ref_name"] = "thesis_" + count;
        temp["default_file_name"] = "";
        temp["default_file_size"] = "";
        temp["default_file_link"] = "";
        temp["readonly"] = false;
        temp["help"] = this.props.help;
        var items = this.state.items;
        items.push(temp);

        this.setState({
            count: count,
            items: items
        });
    }
        
    validation()
    {
        var valid = true;
        var validation = [];
        var attachment_names = [];
        for(var ref in this.refs)
        {
            var i = this.refs[ref];
            
            validation.push(i.validation());
            if(i.state.default_file)
            {
                attachment_names.push(i.props.default_file_name);
            }
            else
            {

                var att = i.refs.file_uploader;

                if(att.state.attachment != '')
                {
                    var att_name = att.state.attachment.name;
                    //console.log('att_name :' + att_name);
                    var att_size = att.state.attachment.size;
                    if(attachment_names.length > 0)
                    {
                        var index = 0;
                        for(var x =0; x<attachment_names.length; x++)
                        {
                            var temp_name = attachment_names[x];
                            if(temp_name.toUpperCase() == att_name.toUpperCase())
                            {
                                index++;
                            }
                        }
                        if(index >0)
                        {
                            var help = 'File '+ att_name + '_' + index + ' selected. [File size: ' + formatBytes(att_size)+']';
                            att.editHelpMsg(help);
                        }
                    }
                    attachment_names.push(att_name);
                }
            }
        }

        for (var i = 0; i < validation.length; i++) {
            if(!validation[i])
            {
                valid = false;
                break;
            }
        }

        return valid;
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
        var error = (this.state.error)?<div className="alert alert-danger" role="alert" id="error_examined"><button type="button" className="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{this.state.errorMsg}</div>:<div></div>;
        var addButton = this.state.readonly? <button type="button" className="btn btn-default" onClick={this.handleAddClick} disabled>Add another file</button> : <button type="button" className="btn btn-default" onClick={this.handleAddClick}>Add another file</button>;
        return (
            <div>
                {loading}
                {error}
                <div className="">
                    {this.state.items.map(function(i){
                        return (
                            <FileWrapper key={i.item} help={i.help} count={i.item} default_file_name={i.default_file_name} default_file_size={i.default_file_size} default_file_link={i.default_file_link} readonly={i.readonly} ref={i.ref_name} uuid={i.uuid}/>
                        )
                    })}
                </div>
                <div className="row">
                    <div className="col-md-6">
                        {addButton}
                    </div>
                    <div className="col-md-6">
                    </div>
                </div>
            </div>
        );
    }
}

	class File extends React.Component{
		constructor(props) {
			super(props);
			this.state = {
				readonly: this.props.readonly
			};
			
			this.editMode = this.editMode.bind(this);
			this.restart = this.restart.bind(this);
			this.readOnlyMode= this.readOnlyMode.bind(this);
			this.validation = this.validation.bind(this);
		}
		
		editMode() {
			this.setState({
				readonly: false
			});
			this.refs.file_control.handleResetClick();
			this.refs.file_control.editMode();
		}
		restart() {
			this.refs.file_control.handleResetClick();
			this.refs.file_control.restart();
		}
		readOnlyMode() {
			this.setState({
				readonly: true
			});
			
			this.refs.file_control.handleResetClick();
			this.refs.file_control.readOnlyMode();
		}
		validation()
		{
			return this.refs.file_control.validation();
		}
		render() {
			return (
				<div>
					<ul className="file_ul">
						<li>The thesis file must be a PDF or ZIP. </li>
						<li>Include all supplementary materials, including data and appendices.</li>
						<li>Name files appropriately for public view.</li>
					</ul>
					<FileControl help="" xpath={this.props.xpath} readonly={this.state.readonly} ref="file_control" thesisType ='openAccess' onUpdate = {this.props.onUpdate}/>
				</div>
			);
		}
	}

	class RadioButton extends React.Component{
		constructor(props) {
			super(props);
			this.state = {
				value: this.props.default_value ? this.props.default_value : '',
				readonly: this.props.readonly,
				error: false
			};
			
			this.editMode = this.editMode.bind(this);
			this.restart = this.restart.bind(this);
			this.readOnlyMode= this.readOnlyMode.bind(this);
			this.validation = this.validation.bind(this);
			this.handleChange = this.handleChange.bind(this);
		}
		editMode()
		{
			this.setState({
				readonly: false,
				error: false
			});
		}
		restart()
		{
			//console.log('radiobutton restart');
			this.setState({
				value: this.props.default_value ? this.props.default_value : '',
				readonly: this.props.readonly,
				error: false
			});
			this.props.handleClick({value: this.props.default_value ? this.props.default_value : ''});
		}
		readOnlyMode() {
			this.setState({
				readonly: true,
				error: false
			});
		}
		validation()
		{
			var valid = true;
			if(this.props.required)
			{
				if(this.state.value == '')
				{
					
					valid = false;
					this.setState({
						error:true
					});
				}
			}
			return valid;
	    }
		handleChange(e)
		{
			this.setState({
				error: false,
				value: e.target.value
			});
			this.props.handleClick({value: e.target.value});
		}
		
		render() {
			var error = (this.state.error)?<div className="alert alert-danger" role="alert" id="radiobutton_error"><button type="button" className="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{this.props.errorMsg}</div>:<div></div>;
			return (
				<div className="radio_button">
					<h3>Open Access <span style={error_style}>*</span></h3>
					{error}
					<div className="row"> 
						<label>
						<input type="radio" checked={(this.state.value=="version of record")? true : false} onChange={this.handleChange} value="version of record" disabled={this.state.readonly}/> My examined thesis is my open access version
						</label>
					</div>
					<div className="row"> 
						<label>
						<input type="radio" checked={(this.state.value=="new version")? true : false} onChange={this.handleChange} value="new version" disabled={this.state.readonly}/> My open access version is different from my examined thesis (I have removed third party copyright, confidential, or sensitive material as required)
						</label>
					</div>
				</div>
			);
		}
	}
	
	
	class OpenAccessText extends React.Component{
		render(){
			return(
				<div>
				<p>If third party copyright permission has not been obtained, please remove all affected figures/text/charts/diagrams etc. from the open access version of your thesis. </p>
				<ul>
					<li>In their place insert a short message: <i>Figure (Text/Chart/Diagram etc.) has been removed due to Copyright restrictions.</i></li>
				</ul>
				<p>Confidential and sensitive information should be excluded from the open access version of your thesis.</p>
				<h3>Open Access Version <span style={error_style}>*</span></h3>	
				</div>
			)
		}
	}
	
    /******* Release status ******/
	class ReleaseVersionRadioButton extends React.Component{
		constructor(props) {
			super(props);
			this.state = {
				value: this.props.default_value ? this.props.default_value : '',
				readonly: this.props.readonly,
				error: false
			};
			
			this.editMode = this.editMode.bind(this);
			this.restart = this.restart.bind(this);
			this.readOnlyMode= this.readOnlyMode.bind(this);
			this.validation = this.validation.bind(this);
			this.handleChange = this.handleChange.bind(this);
		}
		editMode()
		{
			this.setState({
				readonly: false,
				error: false
			});
		}
		restart()
		{
			//console.log('radiobutton restart');
			this.setState({
				value: this.props.default_value ? this.props.default_value : '',
				readonly: this.props.readonly,
				error: false
			});
			this.props.handleClick({value: this.props.default_value ? this.props.default_value : ''});
		}
		
		readOnlyMode() {
			this.setState({
				readonly: true,
				error: false
			});
		}	
		validation()
		{
			var valid = true;
			if(this.props.required)
			{
				if(this.state.value == '')
				{
					
					valid = false;
					this.setState({
						error:true
					});
				}
			}
			return valid;
		}
		handleChange(e)
		{
			this.setState({
				value: e.target.value,
				error: false
			});
			this.props.handleClick({value: e.target.value});
		}
		
		render() {
			var errorMsg = '';
			if(this.state.error)
			{
				errorMsg = <span style={error_style}>* Open access or embargo access is required</span>
			}
			return (
				<div className="row">
					<div className="radio_button col-md-12">
						<p>Release of the open access version of your thesis <span style={error_style}>*</span></p>
						{errorMsg}
						<div className = 'row'>
							<label>
							<input type="radio" checked={(this.state.value=="Open Access")? true : false} onChange={this.handleChange} value="Open Access" disabled={this.state.readonly}/> Release immediately
							</label>
						</div>
						
						<div className = 'row'>
						<label>
						<input type="radio" checked={(this.state.value=="Restricted Access")? true : false} onChange={this.handleChange} value="Restricted Access" disabled={this.state.readonly}/> Request embargo  (released at end of embargo period.)
						</label>
						</div>
					</div>
				</div>
			);
		}
	}
	
	
	class TextInput extends React.Component{
		constructor(props) {
			super(props);
			this.state = {
				readonly: this.props.readonly,
				value:this.props.default_value? this.props.default_value : '',
				error: false,
				errorMsg:this.props.errorMsg
			};
			
			this.editMode = this.editMode.bind(this);
			this.restart = this.restart.bind(this);
			this.readOnlyMode= this.readOnlyMode.bind(this);
			this.validation = this.validation.bind(this);
			this.handleChange = this.handleChange.bind(this);
			this.handleBlur = this.handleBlur.bind(this);
			this.handleFocus = this.handleFocus.bind(this);
		}
		restart()
		{
			this.setState({
				readonly: this.props.readonly,
				value:this.props.default_value? this.props.default_value : '',
				error: false,
				errorMsg: this.props.errorMsg? this.props.errorMsg : ''
			});
		}
		editMode()
		{
			this.setState({
				readonly: false
			});
		}
		readOnlyMode()
		{
			this.setState({
				readonly: true
			});
		}
		validation() 
		{
			var value = this.state.value;
			var valid = true;
			var validation = [];
			if(this.props.required) 
			{
				if(value=='' || value.trim()== '')
				{
					validation.push(false);
					this.setState({
						error: true,
						errorMsg: this.props.errorMsg
					});
				}
				
			}
			else if(this.props.minLength)
			{
				validation.push(false);
				if(value.length < this.props.minLength)
				{
					this.setState({
						error: true,
						errorMsg: this.props.errorMsg
					});
				}
			}
			for(var i=0; i<validation.length; i++)
			{
				if(!validation[i])
				{
					valid = false;
					break;
				}
			}
			return valid;
		}
		
		handleChange(e) {
			var input = this.refs.input;
			var value = input.value;
			this.setState({
				value: value
			});
		}
		
		handleBlur(e){
			if(!this.state.readonly){
				this.validation();
			}
		}
		
		handleFocus(e) {
			if(!this.state.readonly){
				this.setState({error: false});
				e.stopPropagation();
			}
		}
		
		render() {
			var className="row";
			if (this.state.error)
			{
				className += ' has-error';
			}
			
			var input = (this.props.type == 'textarea') ? <textarea className="form-control" name={this.props.name} rows={this.props.rows} placeholder={this.props.placeholder} value={this.state.value} onChange={this.handleChange} ref="input" minLength={this.props.minLength?this.props.minLength : 0} required={this.props.required? true : false } readOnly={this.state.readonly}/> : <input type={this.props.type} className="form-control" name={this.props.name} placeholder={this.props.placeholder} value={this.state.value} onChange={this.handleChange} ref="input" minLength={this.props.minLength?this.props.minLength : 0}  required={this.props.required? true : false } readOnly={this.state.readonly}/>;
			
			return(
				<div className={className} onBlur={this.handleBlur} onFocus={this.handleFocus}>
					<div className="col-md-12">
					<InputError errorMessage={this.state.errorMsg} visible={this.state.error}/>
					{input}
					</div>
					
				</div>
			);
		}
	}
	
	
	class Embargo_radio_button extends React.Component{
		constructor(props) {
			super(props);
			this.state = {
				value: this.props.default_value ? this.props.default_value : '',
				readonly: this.props.readonly,
				error: false
			};
			
			this.editMode = this.editMode.bind(this);
			this.restart = this.restart.bind(this);
			this.readOnlyMode= this.readOnlyMode.bind(this);
			this.validation = this.validation.bind(this);
			this.handleChange = this.handleChange.bind(this);
		}
		editMode()
		{
			this.setState({
				readonly: false,
				error: false
			});
		}
		restart()
		{
			//console.log('radiobutton restart');
			this.setState({
				value: this.props.default_value ? this.props.default_value : '',
				readonly: this.props.readonly,
				error: false
			});
			this.props.handleClick({value: this.props.default_value ? this.props.default_value : ''});
		}
		
		readOnlyMode() {
			this.setState({
				readonly: true,
				error: false
			});
		}
		validation()
		{
			var valid = true;
			if(this.props.required)
			{
				if(this.state.value == '')
				{
					
					valid = false;
					this.setState({
						error:true
					});
				}
			}
			return valid;
		}
		handleChange(e)
		{
			this.setState({
				value: e.target.value,
				error: false
			});
			
			this.props.handleClick({value: e.target.value});
		}
		
		render() {
			var errorMsg = "";
			if(this.state.error)
			{
				errorMsg = <span style={error_style}> * Duration of emgargo is required </span>
			}
			return (
				<div className="row">
				<div className="radio_button col-md-12">
					<h3>Duration of Embargo <span style={error_style}>*</span></h3> {errorMsg}
					<div className = 'row'>
						<label>
						<input type="radio" checked={(this.state.value=="12")? true : false} onChange={this.handleChange} value="12" disabled={this.state.readonly}/> 12 months
						</label>
					</div>
					
					<div className = 'row'>
					<label>
					<input type="radio" checked={(this.state.value=="18")? true : false} onChange={this.handleChange} value="18" disabled={this.state.readonly}/> 18 months
					</label>
					</div>
					
					<div className = 'row'>
					<label>
					<input type="radio" checked={(this.state.value=="24")? true : false} onChange={this.handleChange} value="24" disabled={this.state.readonly}/> 24 months
					</label>
					</div>
					
					<div className = 'row'>
					<label>
					<input type="radio" checked={(this.state.value=="36")? true : false} onChange={this.handleChange} value="36" disabled={this.state.readonly}/> 36 months
					</label>
					</div>
				</div>
				</div>
			);
		}
	}


	class CheckBox extends React.Component{
		constructor(props) {
			super(props);
			this.state = {
				value: this.props.default_value ? this.props.default_value : '',
				isChecked: this.props.default_value == this.props.text_value ? true : false,
				readonly: this.props.readonly,
				error: false
			};
			
			this.editMode = this.editMode.bind(this);
			this.restart = this.restart.bind(this);
			this.readOnlyMode= this.readOnlyMode.bind(this);
			this.validation = this.validation.bind(this);
			this.handleClick = this.handleClick.bind(this);
		}
	
		handleClick() {
			var isChecked = !this.state.isChecked;
			if(isChecked)
			{
				this.setState({
					error: false,
					isChecked: true,
					value: this.props.text_value
				});
			}
			else
			{
				this.setState({
					error: false,
					isChecked: false,
					value: ''
				});
			}
		}
		editMode()
		{
			this.setState({
				readonly: false
			});
		}
		restart()
		{
			this.setState({
				value: this.props.default_value ? this.props.default_value : '',
				isChecked: this.props.default_value == this.props.text_value ? true : false,
				readonly: this.props.readonly,
				error: false
			});
		}
		readOnlyMode(){
			this.setState({
				readonly: true
			});
		}
		validation()
		{
			var valid = true;
			
			this.setState({
				error: false
			});
			
			if(this.props.required)
			{
				if(this.state.value == '')
				{
					
					valid = false;
					this.setState({
						error:true
					});
				}
			}
			return valid;
		}
		render() {
			var error = (this.state.error) ? <span style={error_style}> * {this.props.errorMsg}</span> : '';
			return (
				<div className="col-md-12 checkbox">
					{error}
					<label>
						<input type="checkbox" checked={this.state.isChecked} onChange={this.handleClick} disabled={this.state.readonly}/>
						&nbsp;{this.props.text} &nbsp;&nbsp;
					</label>
				</div>
			);
		}
	}
	
	
	
	class CheckBoxCallBack extends React.Component{
		constructor(props) {
			super(props);
			this.state = {
				value: this.props.default_value ? this.props.default_value : '',
				isChecked: this.props.default_value == this.props.text_value ? true : false,
				readonly: this.props.readonly,
				error: false
			};
			
			this.editMode = this.editMode.bind(this);
			this.restart = this.restart.bind(this);
			this.readOnlyMode= this.readOnlyMode.bind(this);
			this.validation = this.validation.bind(this);
			this.handleClick = this.handleClick.bind(this);
		}
		handleClick() {
			var value = '';
			var isChecked = !this.state.isChecked;
			if(isChecked)
			{	value = this.props.text_value;
				this.setState({
					error: false,
					isChecked: true,
					value: this.props.text_value
				});
				
			}
			else
			{
				value = '';
				this.setState({
					error: false,
					isChecked: false,
					value: ''
				});
			}
			this.props.checkedValue({value: value});
		}
		editMode()
		{
			this.setState({
				readonly: false
			});
		}
		restart()
		{
			this.setState({
				value: this.props.default_value ? this.props.default_value : '',
				isChecked: this.props.default_value == this.props.text_value ? true : false,
				readonly: this.props.readonly,
				error: false
			});
		}
		readOnlyMode() {
			this.setState({
				readonly: true
			});
		}
		validation()
		{
			var valid = true;
			this.setState({
				error: false
			});
			if(this.props.required)
			{
				if(this.state.value == '')
				{
					
					valid = false;
					this.setState({
						error:true
					});
				}
			}
			return valid;
		}
		render() {
			var error = (this.state.error) ? <span style={error_style}> * {this.props.errorMsg}</span> : '';
			return (
				
				<div className="col-md-12 checkbox">
					<label>
						<input type="checkbox" checked={this.state.isChecked} onChange={this.handleClick} disabled={this.state.readonly}/>
						&nbsp;{this.props.text}
					</label>
					{error}
				</div>
				
			)
		}
	}
	
	
	class EmbargoExtReason extends React.Component{
		constructor(props) {
			super(props);
			this.state = {
				readonly: this.props.readonly
			};
			
			this.editMode = this.editMode.bind(this);
			this.restart = this.restart.bind(this);
			this.readOnlyMode= this.readOnlyMode.bind(this);
			this.validation = this.validation.bind(this);
		}

		validation(){
			return this.refs.embargo_ext_reason.validation();
		}
		restart()
		{
			this.refs.embargo_ext_reason.restart();
			this.setState({
				value : this.props.default_value? this.props.default_value : '',
				readonly: this.props.readonly
			});
		}
		editMode()
		{
			this.setState({
				readonly: false
			});
			this.refs.embargo_ext_reason.editMode();
		}
		readOnlyMode()
		{
			this.setState({
				readonly: true
			});
			
			this.refs.embargo_ext_reason.restart();
			this.refs.embargo_ext_reason.readOnlyMode();
		}
		render(){
			return (
				<div className="row">
					<h3>Reason for Extended Embargo <span style={error_style}>*</span></h3>
					<p>Provide an explanation outlining the reasons for the request to place an additional restriction, of up to 18 months, on your research component beyond the original 3 years.</p>
					<TextInput type="textarea" ref="embargo_ext_reason" rows="10" name="embargo_ext_reason" default_value={default_embargo_extension_reason} required={this.props.required} readonly={this.state.readonly} errorMsg="Embargo extension reason is required"/>
				</div>
			);
		}
	}
	
	
	class EmbargoExt extends React.Component{
		constructor(props) {
			super(props);
			this.state = {
				value: this.props.default_value? this.props.default_value:'',
				readonly: this.props.readonly,
				error: false
			};
			
			this.editMode = this.editMode.bind(this);
			this.restart = this.restart.bind(this);
			this.readOnlyMode= this.readOnlyMode.bind(this);
			this.validation = this.validation.bind(this);
			this.getCheckBoxValue = this.getCheckBoxValue.bind(this);
		}

		getCheckBoxValue(e){
			this.setState({
				value: e.value
			});
		}
		
		restart()
		{
			this.setState({
				value: this.props.default_value? this.props.default_value:'',
				readonly: this.props.readonly,
				error: false
			});
			this.refs.embargo_ext.restart();
			if(this.state.value == 'Additional Restriction')
			{
				this.refs.embargo_ext_resaon.restart();
			}
		}
		editMode()
		{
			this.setState({
				readonly: false,
				error: false
			});
			
			this.refs.embargo_ext.editMode();
			if(this.state.value == 'Additional Restriction')
			{
				this.refs.embargo_ext_resaon.editMode();
			}
		}
		readOnlyMode()
		{
			this.setState({
				readonly: true,
				error: false
			});
			
			this.refs.embargo_ext.restart();
			this.refs.embargo_ext.readOnlyMode();
			if(this.state.value == 'Additional Restriction')
			{
				this.refs.embargo_ext_resaon.restart();
				this.refs.embargo_ext_resaon.readOnlyMode();
			}
		}
		validation()
		{
			var valid = true;
			var validation = [];
			
			validation.push(this.refs.embargo_ext.validation());
			if(this.state.value == 'Additional Restriction')
			{
				validation.push(this.refs.embargo_ext_resaon.validation());
			}
			
			for(var i = 0; i < validation.length; i++) {
				
				if(validation[i] == false)
				{
					valid = false;
					break;
				}
			}
			return valid;
		}
		render() {
			var embargoExtReason = (this.state.value == 'Additional Restriction') ? <EmbargoExtReason readonly={this.state.readonly} ref="embargo_ext_resaon" required={true}/> : '';
			
			return (
				<div className="row">
					<p>The Deputy Vice-Chancellor (Academic) (or nominee) may approve an application from an author to restrict access to his or her thesis for a period of up to an additional 18 months beyond the original 3-year embargo from the acceptance of the award of the degree. In exceptional circumstances, longer periods of restriction or a total embargo may be approved by the Deputy Vice-Chancellor (Academic) (or nominee).</p>
					<h3>Request extended embargo period</h3>
					<CheckBoxCallBack text_value='Additional Restriction' default_value={this.props.default_value} readonly={this.state.readonly}  text="Request to extend embargo access to your thesis for an additional 18 months beyond the original 3 years." ref="embargo_ext" checkedValue={this.getCheckBoxValue}/>
					<div className="col-md-12 ext_reason_area">
						{embargoExtReason}
					</div>
				</div>
			)
		}
	}
	
	
	class Embargo extends React.Component{
		constructor(props) {
			super(props);
			this.state = {
				radio_button_value: this.props.default_value? this.props.default_value:'',
				embargo_ext_request: this.props.default_embargo_ext_request_value? this.props.default_embargo_ext_request_value:'',
				readonly: this.props.readonly,
				error: false
			};
			
			this.editMode = this.editMode.bind(this);
			this.restart = this.restart.bind(this);
			this.readOnlyMode= this.readOnlyMode.bind(this);
			this.validation = this.validation.bind(this);
			this.handleRadioButtonValue = this.handleRadioButtonValue.bind(this);
			this.handleEmbargoExtRequest = this.handleEmbargoExtRequest.bind(this);
			this.handleTextAreaChange = this.handleTextAreaChange.bind(this);
			
		}
		handleRadioButtonValue(e)
		{
			this.setState({
				radio_button_value: e.value
			});
			
			this.props.handleClick({value: e.value})
		}
		handleEmbargoExtRequest(e)
		{
			this.setState({
				embargo_ext_request: e.value
			});
		}
		restart()
		{
			this.setState({
				radio_button_value: this.props.default_value? this.props.default_value:'',
				readonly: this.props.readonly,
				error: false
			});
			this.refs.radio_button.restart();
			this.refs.embargo_reason.restart();
			this.refs.embargo_statement.restart();
			if(this.state.radio_button_value == '36' || this.state.radio_button_value == 36)
			{
				this.refs.embargo_ext.restart();
			}
		}
		handleTextAreaChange(e)
		{
			this.setState({
				embargo_standard_request_reason: e.value
			});
			return e.value;
		}
		editMode()
		{
			this.setState({
				readonly: false,
				error: false
			});
			this.refs.radio_button.editMode();
			this.refs.embargo_reason.editMode();
			this.refs.embargo_statement.editMode();
			if(this.state.radio_button_value == '36' || this.state.radio_button_value == 36)
			{
				this.refs.embargo_ext.editMode();
			}
		}
		readOnlyMode()
		{
			this.setState({
				readonly: true,
				error: false
			});
			
		
			this.refs.radio_button.readOnlyMode();
			
			this.refs.embargo_reason.readOnlyMode();
			
			this.refs.embargo_statement.readOnlyMode();
		
			if(this.state.radio_button_value == '36' || this.state.radio_button_value == 36)
			{
				this.refs.embargo_ext.readOnlyMode();
			}
			
		}
		validation()
		{
			var valid = true;
			var validation = [];
			validation.push(this.refs.radio_button.validation());
			validation.push(this.refs.embargo_reason.validation());
			validation.push(this.refs.embargo_statement.validation());
			
			if(this.state.radio_button_value == '36' || this.state.radio_button_value == 36)
			{
				validation.push(this.refs.embargo_ext.validation());
			}
			
			for (var i = 0; i < validation.length; i++) {
				if(validation[i] == false)
				{
					valid = false;
					break;
				}
			}
			return valid;
		}
		
		render() {
			var embargo_ext_request = '';
			if(this.state.radio_button_value == '36' || this.state.radio_button_value == 36)
			{
				embargo_ext_request = <EmbargoExt readonly={this.state.readonly} ref="embargo_ext" default_value={this.props.default_embargo_ext_request_value}/>;
			}
			
			return(
				<div className="embargo_area">
					<div className="row">
						<h3>Embargoed Thesis</h3>
						<p>It is mandatory to submit your examined thesis even if you have requested any embargo. You must also designate an open access version (you may select the examined thesis as your open access version). The open access version of your thesis will not be released openly until after the agreed embargo period has passed.</p>
						<Embargo_radio_button default_value={this.props.default_value} readonly={this.state.readonly} handleClick={this.handleRadioButtonValue} ref="radio_button" required={true}/>
					</div>
					
					<div className="row">
						<h3>Embargo Request <span style={error_style}>*</span></h3>
						<p>Provide an explanation detailing the reason for the request to place an embargo on your thesis. <br /><b>Please Note</b> This request will be considered by the Deputy Vice-Chancellor Academic. Please make sure that you provide sufficient detail to justify your request.</p>
						
						<TextInput type="textarea" ref="embargo_reason" label="" rows="10" name="embargo_reason" default_value={this.props.embargo_standard_request_reason} required={true} readonly={this.state.readonly} errorMsg="Embargo reason is required"/>
					</div>
					<p></p>
					<div className="row">
						<p>Embargo requests will be considered by the Deputy Vice-Chancellor (Academic) (or nominee) only on the grounds</p>
						<ul className="embargo_ul">
							<li>that the thesis contains confidential and/or sensitive material; or</li>
							<li>that it was a condition imposed by the owner of private records and material used by the author; or</li>
							<li>that the author was in an employment or other contract relationship with a third party that made the restriction a condition of the contract; or</li>
							<li>that the thesis contains creative, critical, academic or equivalent material with a likelihood of publication, performance or equivalents.</li>
						</ul>
					</div>
					
					{embargo_ext_request}
					<p></p>
					<div className="row">
						<h3>SIGN OFF: Embargo Statement <span style={error_style}>*</span></h3>
						<CheckBox text_value='Yes' default_value={default_embargo} readonly={this.state.readonly}  text="I understand, if this embargo is approved, the full text of the thesis will be unavailable until the embargo period passes. I acknowledge that information about this thesis (including abstract) will be made openly available immediately." ref="embargo_statement" errorMsg="embargo statement required" required={true}/>
					</div>
				</div>
			)
		}
	}
		
		
	class OpenAccessForm extends React.Component{
		constructor(props) {
			super(props);
			this.state = {
				radio_button_value: this.props.default_open_access_value,
				release_status: this.props.default_release_status,
				embargo_radio_button_value: this.props.default_embargo_radio_button_value? this.props.default_embargo_radio_button_value:'',
				copyright_statement: this.props.default_copyright_value,
				readonly: this.props.readonly,
				loading: false,
				error: false,
				valid: false,
				onThesisUpdate: false,
				info: 'To update this page, click on Edit button on the right of the page.'
			};
			this.handleEditClick = this.handleEditClick.bind(this);
			this.handleCancelClick = this.handleCancelClick.bind(this);
			this.handleResetClick = this.handleResetClick.bind(this);
			this.setReleaseStatus = this.setReleaseStatus.bind(this);
			this.setCopyrightValue = this.setCopyrightValue.bind(this);
			this.validation = this.validation.bind(this);
			this.onThesisUpdate = this.onThesisUpdate.bind(this);
			this.handleOpenAccessClick = this.handleOpenAccessClick.bind(this);
			this.handleClick = this.handleClick.bind(this);
			this.handleEmbargoRadioButtonValue = this.handleEmbargoRadioButtonValue.bind(this);
			this.handleSubmitClick = this.handleSubmitClick.bind(this);
		}	
	
		handleEditClick() {
			this.setState({
				readonly: false,
				info: 'To save the content, click on Save Step 3 button on the right or on the bottom of the page.'
			});
			this.refs.radioButton.editMode();
			if(this.state.radio_button_value=="new version")
			{
				this.refs.openAccessForm.editMode();
			}
			
			this.refs.releaseVersionRadioButton.editMode();
			if(this.state.release_status == 'Restricted Access')
			{
				this.refs.embargo.editMode();
			}
			
			this.refs.copyright.editMode();
		}
		
		handleCancelClick() {
			this.setState({
				radio_button_value: this.props.default_open_access_value,
				release_status: this.props.default_release_status,
				embargo_radio_button_value: this.props.default_embargo_radio_button_value? this.props.default_embargo_radio_button_value:'',
				copyright_statement: this.props.default_copyright_value,
				readonly: true,
				loading: false,
				error: false,
				valid: false,
				onThesisUpdate: false,
				info: 'To update this page, click on Edit button on the right of the page.'
			});
			
			this.refs.radioButton.restart();
			this.refs.radioButton.readOnlyMode();
			
			if(this.state.radio_button_value=="new version")
			{
				this.refs.openAccessForm.restart();
				this.refs.openAccessForm.readOnlyMode();
			}
			this.refs.releaseVersionRadioButton.restart();
			this.refs.releaseVersionRadioButton.readOnlyMode();
			
			if(this.state.release_status == 'Restricted Access')
			{
				this.refs.embargo.restart();
				this.refs.embargo.readOnlyMode();
			}
			
			this.refs.copyright.restart();
			this.refs.copyright.readOnlyMode();
			
		}
		handleResetClick()
		{
			this.setState({
				radio_button_value: this.props.default_open_access_value,
				release_status: this.props.default_release_status,
				embargo_radio_button_value: this.props.default_embargo_radio_button_value? this.props.default_embargo_radio_button_value:'',
				copyright_statement: this.props.default_copyright_value,
				readonly: false,
				loading: false,
				error: false,
				valid: false,
				onThesisUpdate: false,
				info: 'To update this page, click on Edit button on the right of the page.'
			});
			
			this.refs.radioButton.restart();
			
			if(this.state.radio_button_value=="new version")
			{
				this.refs.openAccessForm.restart();
				this.refs.openAccessForm.editMode();
			}
			
			this.refs.releaseVersionRadioButton.restart();
			
			if(this.state.release_status == 'Restricted Access')
			{
				this.refs.embargo.restart();
			}
			this.refs.copyright.restart();
		}
		setReleaseStatus(e)
		{
			
			this.setState({
				release_status: e.value
			});
		}
		setCopyrightValue(e)
		{
			this.setState({
				copyright_statement: e.value
			});
		}
		validation()
		{
			var valid = true;
			var validation = [];
			validation.push(this.refs.radioButton.validation());
			
			if(this.state.radio_button_value=="new version")
			{
				validation.push(this.refs.openAccessForm.validation());
			}
			
			validation.push(this.refs.releaseVersionRadioButton.validation());
			
			if(this.state.release_status == 'Restricted Access')
			{
				validation.push(this.refs.embargo.validation());
			}
			validation.push(this.refs.copyright.validation());
			
			
			for(var i = 0; i < validation.length; i++) {
				if(validation[i] == false)
				{
					valid = false;
					break;
				}
			}
		
			return valid;
		}
		
		onThesisUpdate()
		{
			this.setState({
				readonly: true,
				onThesisUpdate: true,
				info: ''
			});
			for(var ref in this.refs)
			{
				var i = this.refs[ref];
				//console.log(i);
				i.readOnlyMode();
			}
			return;
		}
		handleOpenAccessClick(e) { //for open access radio button click
			this.setState({radio_button_value: e.value});
		}
		
		handleClick(e) { //for release status radio button click
			this.setState({release_status: e.value});
		}
		
		handleEmbargoRadioButtonValue(e) // for embargo duration radio button click
		{
			this.setState({
				embargo_radio_button_value: e.value
			});
		}
		
		handleSubmitClick(e) 
		{
			e.preventDefault();
			var valid = this.validation();
			if(valid)
			{
				var formData = new FormData();
				
				formData.append('item_uuid', uuid);
				formData.append('item_version', version);
				
				
				formData.append('open_access', this.state.radio_button_value);
				
				formData.append('xpath', this.props.xpath);
					//console.log('xpath: ' + this.props.xpath);
				if(this.state.radio_button_value == 'new version')
				{	
					var open_access_files = this.refs.openAccessForm;
					var file_control = open_access_files.refs.file_control;
					
					for(var ref in file_control.refs)  
					{
						var i = file_control.refs[ref];
						if(i.state.visible == true && i.state.default_file == true)
						{
							var temp = {'uuid': i.state.uuid};
							formData.append('attachments[]', JSON.stringify({'uuid': i.state.uuid}));
						}
						else if(i.state.visible == true && i.state.default_file == false)
						{
							var file_uploader = i.refs.file_uploader;
							
							if(file_uploader.state.attachment != "")
							{
								var file = file_uploader.state.attachment;
								var temp = {'uuid': '','file_name':file.name, 'file_size': file.size};
	
								formData.append('attachments[]',JSON.stringify({'uuid': '','file_name':file.name, 'file_size': file.size}));
						
								formData.append('thesis_file[]', file, file.name);
							}
						}
					}
				}
				
				formData.append('release_status', this.state.release_status);
				//console.log('release_status:' +this.state.release_status);
				
				if(this.state.release_status == 'Restricted Access')
				{
					formData.append('embargo_duration', this.state.embargo_radio_button_value);
					//console.log('embargo_duration:' +this.state.embargo_radio_button_value);
					
					var embargo = this.refs.embargo;
					
					var embargo_reason_object = embargo.refs.embargo_reason;
					var embargo_reason = embargo_reason_object.state.value;
					formData.append('embargo_reason', embargo_reason);
					//console.log('embargo_reason:' +embargo_reason);
					
					var embargo_statement_object = embargo.refs.embargo_statement;
					var embargo_statement = embargo_statement_object.state.value;
					formData.append('embargo_statement', embargo_statement);
					//console.log('embargo_statement:' +embargo_statement);
					
					if(this.state.embargo_radio_button_value == '36'|| this.state.embargo_radio_button_value == 36)
					{
						var exbargo_ext_obj = embargo.refs.embargo_ext;
						var embargo_ext_request = exbargo_ext_obj.state.value;
						formData.append('embargo_ext_request', embargo_ext_request);
					    //console.log('embargo_ext_request:' +embargo_ext_request);
						
						if(embargo_ext_request == 'Additional Restriction')
						{
							var embargo_ext_reason_obj = exbargo_ext_obj.refs.embargo_ext_resaon;
							var embargo_ext_ext_reason_obj = embargo_ext_reason_obj.refs.embargo_ext_reason;
							var embargo_ext_reason = embargo_ext_ext_reason_obj.state.value;
							
							formData.append('embargo_ext_reason', embargo_ext_reason);
							//console.log('embargo_ext_reason:' +embargo_ext_reason);
						}
					}
				}	
				formData.append('copyright_statement', this.state.copyright_statement);
				//console.log('copyright_statement:' + this.state.copyright_statement);
				this.onThesisUpdate();
				
				
				
				this.setState({
					loading: true,
					readonly: true,
					onThesisUpdate: true,
					info: ''
				});
				
				
				$.ajax({
				   url: part3_url,
				   type: 'POST',
				   data: formData,
				   processData: false, // this has to be set to false
				   contentType: false, // this has to be set to false
				   error: function(jqXHR, textStatus, errorThrown){
					   this.setState({
							loading: false,
							readonly: true,
							error: true,
							errorMsg : 'Internal Error, please try again or contact flex.help@flinders.edu.au for help',
							onThesisUpdate: false
							
						});
						$('html, body').animate({ scrollTop: 0 }, 'fast');
				   }.bind(this),
				   success: function(data) {
						var resultobj = jQuery.parseJSON(data);
						var result_status = resultobj.status;
				
						switch(result_status)
						{
							case 'success':
								if(this.props.newThesis)
								{
									
									window.location = new_url;
								}
								else
								{
									location.reload(true);
								}
								this.setState({
									loading: false,
									readonly: true
								});
								
							break;
							case 'session_time_out':
								window.location = session_out_url;
								this.setState({
									loading: false,
									readonly: false,
									error: true,
									errorMsg: resultobj.error_info,
									onThesisUpdate: false
								});
							break;
							case 'error':
								this.setState({
									loading: false,
									readonly: false,
									error: true,
									errorMsg: resultobj.error_info,
									onThesisUpdate: false
								});
								for(var ref in this.refs)
								{
									var i = this.refs[ref];
									i.editMode();
								}
								$('html, body').animate({ scrollTop: 0 }, 'fast');
							break;
							case 'invalid':
								this.setState({
									loading: false,
									readonly: false,
									error: true,
									errorMsg: resultobj.error_info,
									onThesisUpdate: false
								});
								for(var ref in this.refs)
								{
									var i = this.refs[ref];
									i.editMode();
								}
								$('html, body').animate({ scrollTop: 0 }, 'fast');
							break;
						}
				   }.bind(this)
				});
			}
		}
		
		render() {
			var className = 'col-md-12';
			var loading = (this.state.loading)? 
								<div className="spinner-wave" style={spinner_wave_style}>
								<div style={spinner_style}></div>
								<div style={spinner_style}></div>
								<div style={spinner_style}></div>
								<div style={spinner_style}></div>
								<div style={spinner_style}></div>
								<p style={spinner_style} id="txt_loading">&nbsp;Loading...</p>
                    			</div>:<div></div>;
			var info = '';
			var error = (this.state.error)?<div className="alert alert-danger" role="alert" id="error_examined"><button type="button" className="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{this.state.errorMsg}</div>:<div></div>;
				
			var thesisForm  = this.state.radio_button_value=="new version" ? <div><OpenAccessText /><File readonly={this.state.readonly} ref="openAccessForm" onUpdate={this.onThesisUpdate} xpath={this.props.xpath}/></div>: <div></div>;
				
			
			var button = '';
			if(this.props.status=='draft')
			{
				if(!this.state.onThesisUpdate)
				{
					if(this.state.readonly)
					{
						button = <div><Button buttonClick={this.handleEditClick} text="Edit"/><hr/></div>
					}
					else
					{
						if(this.props.newThesis == false)
						{
							button = <div><Button buttonClick = {this.handleSubmitClick} text="Save Step 3"/>&nbsp;&nbsp;&nbsp;&nbsp;<Button buttonClick = {this.handleCancelClick} text="Cancel Edit"/><hr/></div>
						}
					}
					if(!this.props.newThesis)
					{
						info = <div className="alert alert-info" role="alert">{this.state.info}</div>
					}
				}
				
				var txt = '';
				if(this.props.newThesis)
			    {
					txt = 'Save and Continue';
				}
				else
				{
					txt = 'Save Step 3';
				}
				
				var submitButton = (this.state.readonly) ?  <div></div> : <div className="row"><hr/><div className="col-md-6"><button className="btn btn-primary save" type="submit">{txt}</button></div> <div className="col-md-6"></div></div>
			}
			var embargo = '';
			if(this.state.release_status == 'Restricted Access')
			{
				embargo = <Embargo default_value={this.props.default_embargo_radio_button_value} 
                    readonly={this.state.readonly} 
                    handleClick={this.handleEmbargoRadioButtonValue}
                    ref="embargo" 
                    required={true} 
                    embargo_standard_request_reason={this.props.embargo_standard_request_reason} 
                    default_embargo_ext_request_value = {default_embargo_ext_request_value} />
			}
			
			return (
				<form role="form" className="thesisForm form-horizontal" encType="multipart/form-data" onSubmit={this.handleSubmitClick} noValidate>
					{loading}
					{error}
					<div className="col-md-12 open_access_form">
						
						<div className={className}>
							<div classNmae="row">
								{button}
								<p>
									Third party copyright is any copyrighted material in your thesis that you have not created and does not belong to you. It is any material in your thesis for which you are not the copyright owner. It can include diagrams, images, tables, figures, text, film etc. Permission is required to use 'third party copyright material'. For more information see: <a href="http://www.flinders.edu.au/library/copyright" target="_blank">Overview of Copyright</a>
								</p>
								<p>
									If you have not included any third party copyright material or confidential information in your thesis you may submit the thesis as examined as your open access version.
								</p>
								<p>You can request an embargo period for release of the open access version</p>
							</div>
							<div classNmae="row">
								<RadioButton readonly={this.state.readonly} handleClick={this.handleOpenAccessClick} value={this.state.radio_button_value} default_value={this.props.default_open_access_value} ref="radioButton" required={true} errorMsg='required'/>
								
								{thesisForm}
							</div>
							
							<div className="copyright_area">
								<h3>SIGN OFF: Copyright Statement <span style={error_style}>*</span></h3>
								<p>I confirm that the open access version of my thesis does not infringe the intellectual property rights of a third party OR that all parties with a claim to intellectual property contained in any content in my thesis have agreed to the deposit of my thesis in the Flinders University Theses Collection and dissemination online.</p>
								<p>I confirm that the open access version of my thesis does not contain confidential information OR that I have obtained permission from the authorised party to make the confidential information public.</p>
								<p>I hereby grant to the Flinders University or its agents the right to archive and to make available my thesis or dissertation in whole or in part, in all forms of media, now or hereafter known. I retain all proprietary rights, such as patent rights. I also retain the right to use in future works (such as articles or books) all or part of this thesis or dissertation.</p>
								
								<CheckBoxCallBack text_value='Yes' default_value={this.props.default_copyright_value} readonly={this.state.readonly} text="I agree" ref="copyright" errorMsg="Copyright Statement required" required={true} checkedValue={this.setCopyrightValue}/>
							</div>
							
							<hr/>
							
							<h3>Public Release of your Thesis</h3>
							<p>Candidates may make a request to the Deputy Vice-Chancellor (Academic) (or nominee) to place a restriction on the access to their thesis in accordance with clause 14 of <a href="http://www.flinders.edu.au/ppmanual/student/research-components-of-postgraduate-coursework-awards.cfm" target="_blank"> Research Components of Postgraduate Coursework Awards </a>.</p>
							
							<ReleaseVersionRadioButton default_value={this.props.default_release_status} readonly={this.state.readonly} handleClick={this.setReleaseStatus} required={true} ref="releaseVersionRadioButton"/>
						
							{embargo}
							
							{submitButton}
							
						</div>
						
					</div>
				</form>
				
			);
		}
		
	}
	

	ReactDOM.render(
		<OpenAccessForm readonly={readonly} newThesis={newThesis} default_release_status={default_release_status} default_embargo_radio_button_value = {default_embargo_radio_button_value} embargo_standard_request_reason={embargo_standard_request_reason} status = {status} default_open_access_value={default_open_access_value} default_copyright_value={default_copyright_value} xpath="/xml/item/curriculum/thesis/version/open_access/files" />,
		document.getElementById('content')
	);
