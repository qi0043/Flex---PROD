import React ,{Component} from 'react';
import ReactDOM from 'react-dom';

var examinedTheses = theses;
var examinedCount = theses_count;
var item_uuid = uuid;
var item_version = version;
var url = uploadurl;
var all_url = edit_all_url;
var download_url  = downloadurl ;
var redirect_url = redirect_step3_url;
var session_out_url = quit_url;
var authenticity = authenticity_v
var declaration = declaration_v
var status = status_v;
var new_thesis  = new_thesis_v;
var readonly = readonly_v;

if(status != 'draft')
{
    new_thesis = false;
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
            else if(attachment_obj.type != 'application/pdf' && attachment_obj.type != 'application/x-zip-compressed')
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
        this.handleSubmit = this.handleSubmit.bind(this);
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
              
    handleSubmit()
    {
        var valid = this.validation();
        if(valid)
        {
            var formData = new FormData();
            for(var ref in this.refs)
            {
                var i = this.refs[ref];
                if(i.state.visible && i.state.default_file)
                {
                    formData.append('attachments[]', JSON.stringify({'uuid': i.state.uuid}));
                   
                }
                else if(i.state.visible  && ! i.state.default_file )
                {
                    var file_uploader = i.refs.file_uploader;
                    if(file_uploader.state.attachment != "")
                    {
                        var file = file_uploader.state.attachment;
                        formData.append('attachments[]',JSON.stringify({'uuid': '','file_name':file.name, 'file_size': file.size}));
                       
                        formData.append('thesis_file[]', file, file.name);
                    }
                }
            }
            
            formData.append('item_uuid', uuid);
            formData.append('item_version', version);
            
            var xpath = this.props.xpath;
            formData.append('xpath', xpath);
            
            
            this.setState({
                loading: true,
                readonly: true,
            });

            this.props.onUpdate();

            $.ajax({
               url: url,
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
                    });
                    $('html, body').animate({ scrollTop: 0 }, 'fast');
               }.bind(this),
               success: function(data) {
                    var resultobj = jQuery.parseJSON(data);
                    var result_status = resultobj.status;
                
                    switch(result_status)
                    {
                        case 'success':
                            location.reload(true);
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
                                errorMsg: resultobj.error_info
                            });
                        break;
                        case 'error':
                            this.setState({
                                loading: false,
                                readonly: false,
                                error: true,
                                errorMsg: resultobj.error_info
                            });
                            var file_control = this.refs.file_control;
                            file_control.editMode();
                            var dec_control = this.refs.declaration;
                            dec_control.refs.authenticity.editMode();
                            dec_control.refs.declaration.editMode();
                            $('html, body').animate({ scrollTop: 0 }, 'fast');
                        break;
                        case 'invalid':
                            this.setState({
                                loading: false,
                                readonly: false,
                                error: true,
                                errorMsg: resultobj.error_info
                            });
                            var file_control = this.refs.file_control;
                            file_control.editMode();
                            var dec_control = this.refs.declaration;
                            dec_control.refs.authenticity.editMode();
                            dec_control.refs.declaration.editMode();
                            $('html, body').animate({ scrollTop: 0 }, 'fast');
                        break;
                    }
               }.bind(this)
            });
        }
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
      /*  var uploadButton = this.state.readonly?<button type="button" className="btn btn-default" onClick={this.handleSubmit} disabled>Upload Thesis</button> : <button type="button" className="btn btn-default" onClick={this.handleSubmit}>Upload Thesis</button>; */
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


/********** Declaration Sign Offs ********************************/
class CheckBox extends React.Component{
	constructor(props) {
        super(props);
        this.state = {
            value: this.props.default_value ? this.props.default_value : '',
            isChecked: this.props.default_value == this.props.text_value ? true : false,
            readonly: this.props.readonly,
            error: false

        };
        this.handleClick = this.handleClick.bind(this);
        this.editMode = this.editMode.bind(this);
        this.restart = this.restart.bind(this);
        this.readOnlyMode= this.readOnlyMode.bind(this);
        this.validation = this.validation.bind(this);
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
    readOnlyMode() {
        this.setState({
            readonly: true
        });
    }
    
    validation()
    {
        this.setState({
            error: false
        });
        if(this.props.required)
        {
            if(this.state.value != this.props.text_value)
            {
                this.setState({
                    readonly: false,
                    error: true
                });
            }
        }
    }
    
    render() {
        var error = (this.state.error) ? <span style={error_style}> * {this.props.errorMsg}</span> : '';
        return (
            <div className="checkbox">
                <label>
                    <input type="checkbox" checked={this.state.isChecked} onChange={this.handleClick} disabled={this.state.readonly}/>
                    &nbsp;{this.props.text} &nbsp;&nbsp;{error}
                </label>
            </div>
        );
    }
}

class Declaration extends React.Component{
	constructor(props) {
        super(props);
        this.state = {
            readonly: this.props.readonly,
			error: false
        };
        this.handleEditClick = this.handleEditClick.bind(this);
        this.handleCancelClick = this.handleCancelClick.bind(this);
        this.readOnlyMode = this.readOnlyMode.bind(this);
        this.restart = this.restart.bind(this);
        this.validation = this.validation.bind(this);
    }
	
    handleEditClick() {
        this.setState({
            readonly: false,
            error: false
        });
        for(var ref in this.refs)
        {
            var i = this.refs[ref];
            i.editMode();
        }
    }
    
    handleCancelClick() {
        this.setState({
            readonly: this.props.readonly,
            error: false

        });
        for(var ref in this.refs)
        {
            var i = this.refs[ref];
            i.restart();
            i.readOnlyMode();
        }
    }
    
    restart()
    {
        this.setState({
            readonly: this.props.readonly,
            error: false

        });
    }
    
    readOnlyMode()
    {
        this.setState({
            readonly: true
        });
        for(var ref in this.refs)
        {
            var i = this.refs[ref];
            for(var ref in this.refs)
            {
                var i = this.refs[ref];
                i.readOnlyMode();
            }
        }
    }
    
    validation()
    {
        var valid = true;
        for(var ref in this.refs)
        {
            var i = this.refs[ref];
            i.validation();
            if(i.state.value == '')
            {
                valid = false;
            }
        }
        if(valid)
        {
            this.setState({
                valid: true
            });
        }
        return valid;
    }
    
    render() {
        return (
            <div className="row">
                <div className="declaration col-md-12">
                    <h3>SIGN OFF: Authenticity <span style={error_style}>*</span></h3>
                    <p>I certify that this thesis has been approved by the University for the research component of the postgraduate coursework award. I acknowledge that this authoritative thesis may contain third party copyright material and this copy will be archived and will not be publicly accessible.</p>
                    <CheckBox text_value="I agree" default_value = {authenticity} readonly={this.state.readonly} text="I agree" ref="authenticity" errorMsg="Authenticity required" required={true}/>
                </div>

                <div className="declaration col-md-12">
                    <h3>SIGN OFF: Declaration <span style={error_style}>*</span></h3>
                    <p>In accordance with University policy <a href="http://www.flinders.edu.au/ppmanual/student/research-higher-degrees.cfm#AppendixF" target="_blank">Appendix F: Rules for Research Higher Degree Theses </a>Clause 6 (d) I certify that this thesis does not incorporate without acknowledgment any material previously submitted for a degree or diploma in any university; and that to the best of my knowledge and belief it does not contain any material previously published or written by another person except where due reference is made in the text.</p>

                    <CheckBox text_value='Yes' default_value= {declaration} readonly={this.state.readonly}  text="I agree" ref="declaration" errorMsg="Declaration required" required={true}/>
                </div>
                
            </div>
        )
    }
}

class ExaminedForm extends React.Component{
	constructor(props) {
        super(props);
        this.state = {
            readonly: this.props.readonly,
				error: false,
				errorMsg:'',
				onThesisUpdate: false,
				info: 'To update this page, click on Edit button on the right of the page.'
        };
        this.handleEditClick = this.handleEditClick.bind(this);
        this.handleCancelClick = this.handleCancelClick.bind(this);
        this.restart = this.restart.bind(this);
        this.handleResetClick = this.handleResetClick.bind(this);
        this.onThesisUpdate = this.onThesisUpdate.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }
		
    handleEditClick() {
        this.setState({
            readonly: false,
            info: 'To save the content, click on Save Step 2 button on the right or on the bottom of the page'
        });
        this.refs.file_control.handleResetClick();
        this.refs.file_control.editMode();
        this.refs.declaration.handleEditClick();
    }
    
    handleCancelClick() {
        this.setState({
            readonly: true,
            info: 'To update this page, click on Edit button on the right of the page.'
        });
        this.refs.file_control.handleResetClick();
        this.refs.file_control.readOnlyMode();
        this.refs.declaration.handleCancelClick();
    }
    
    restart()
    {
        this.setState({
            readonly: this.props.readonly,
            error: false,
            errorMsg:'',
            info: 'To update this page, click on Edit button on the right of the page.'
        });
        for(var ref in this.refs)
        {
            var i = this.refs[ref];
            i.restart();
        }
    }
    
    handleResetClick() 
    {
        this.setState({
            readonly: this.props.readonly,
            error: false,
            errorMsg:'',
            info: 'To update this page, click on Edit button on the right of the page.'
        });
        this.refs.file_control.handleResetClick();
        this.refs.file_control.restart();
        this.refs.declaration.restart();
    }
    
    onThesisUpdate()
    {
        this.setState({
            readonly: true,
            onThesisUpdate: true
        });
        for(var ref in this.refs)
        {
            var i = this.refs[ref];
            i.readOnlyMode();
        }
    }
    
    handleSubmit(e)
    {
        e.preventDefault();
        var valid = this.refs.file_control.validation();
        if(valid)
        {
            valid = this.refs.declaration.validation();
        }

        if(valid)
        {
            var formData = new FormData();

            var file_control = this.refs.file_control;
            for(var ref in file_control.refs)
            {
                var i = file_control.refs[ref];
                if(i.state.visible  && i.state.default_file)
                {
                    formData.append('attachments[]', JSON.stringify({'uuid': i.state.uuid}));
                    
                }
                else if(i.state.visible && !i.state.default_file)
                {
                    var file_uploader = i.refs.file_uploader;
                    
                    if(file_uploader.state.attachment != "")
                    {
                        var file = file_uploader.state.attachment;
                        console.log('file_name: ' + file.name);
                        formData.append('attachments[]',JSON.stringify({'uuid': '','file_name':file.name, 'file_size': file.size}));
                        formData.append('thesis_file[]', file, file.name);
                    }
                }
            }

            formData.append('item_uuid', uuid);
            formData.append('item_version', version);
            
            var dec_control = this.refs.declaration;
            var authenticity =  dec_control.refs.authenticity.state.value;
            formData.append('authenticity', authenticity);
        
            var declaration =  dec_control.refs.declaration.state.value;
            formData.append('declaration', declaration);
        
            var xpath = this.props.xpath;
            formData.append('xpath', xpath);
        
            this.onThesisUpdate();
            
            this.setState({
                loading: true,
                readonly: true,
                onThesisUpdate: true,
                info: 'To update this page, click on Edit button on the right of the page.'
            });

            $.ajax({
               url: all_url,
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
                                window.location = redirect_url;
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
        var info = '';
       /* if(!this.props.newThesis && this.props.status=='draft')
        {
            className = 'col-md-10';
            
        }*/
        var fileControl = <FileControl help="" xpath={this.props.xpath} readonly={this.state.readonly} ref="file_control" thesisType ='examined' onUpdate = {this.onThesisUpdate}/>;
        var loading = (this.state.loading)?
                            <div className="spinner-wave" style={spinner_wave_style}>
                            <div style={spinner_style}></div>
                            <div style={spinner_style}></div>
                            <div style={spinner_style}></div>
                            <div style={spinner_style}></div>
                            <div style={spinner_style}></div>
                            <p style={spinner_style} id="txt_loading">&nbsp;Processing...</p>
                            </div>:<div></div>;
        var error = (this.state.error)?<div className="alert alert-danger" role="alert" id="error_examined"><button type="button" className="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{this.state.errorMsg}</div>:<div></div>;
        var button = '';
        var submitButton = '';
        if(this.props.status=='draft')
        {
            if(!this.state.onThesisUpdate)
            {
                if(this.state.readonly)
                {
                    button = <div><Button buttonClick={this.handleEditClick} text="Edit Thesis"/><hr/></div>
                    
                }
                else
                {
                    if( !this.props.newThesis )
                    {
                        button = <div><Button buttonClick = {this.handleSubmit} text="Save Step 2"/>&nbsp;&nbsp;&nbsp;&nbsp;<Button buttonClick = {this.handleCancelClick} text="Cancel Edit"/> <hr/></div>
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
            submitButton = (this.state.readonly && this.props.status=='draft') ?  <div></div> : <div className="row"><hr/><div className="col-md-6"><button className="btn btn-primary save" type="button" onClick={this.handleSubmit} >{txt}</button></div></div>
            
        }
        return (
            <form role="form" className="thesisForm form-horizontal" encType="multipart/form-data" noValidate>
                {loading}
                {error}
                <div className="col-md-12">
                    <div className={className}>
                        <div classNmae="row">
                             {button}
                           
                            <h3>Approved version of Thesis <span style={error_style}>*</span> </h3>
                            <ul className="file_ul">
                                <li>The thesis file must be a PDF. </li>
                                <li>Include any supplementary files, used in the examination process (must be a PDF or ZIP file).</li>
                                <li>Name files appropriately.</li>
                            </ul>
                            {fileControl}
                            <hr/>
                            <Declaration readonly={this.state.readonly}  newThesis = {this.props.newThesis} ref="declaration" status={this.props.status}/>
                        </div>
                   </div>
                    {submitButton}
                </div>
            </form>
        )
    }
}
	
ReactDOM.render(
    <ExaminedForm readonly={readonly} newThesis={new_thesis} status={status} xpath="/xml/item/curriculum/thesis/version/examined_thesis/files" />,
    document.getElementById('content')
);


