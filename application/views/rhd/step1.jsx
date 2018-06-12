		import React ,{Component} from 'react';
		import ReactDOM from 'react-dom';
		
         var new_thesis = newThesis;
         var read_only = readonly;
         var default_status = status;
         var topics = topic;
         var count = topic_count;
		var org_unit = school_org_unit;
		var comp_yr = complete_yr;
		var item_uuid = uuid;
		var item_version = version;
		var new_url = step2_url;
		var redirect_url = index_url;
		var student_id = stuid;
		var edit_url = step1_url;
		var create_url = new_thesis_url;
         var default_stu_first_name_dip = stu_first_name_dip;
         var default_stu_last_name_dip = stu_last_name_dip;
         var default_stu_email = stu_email;
         var default_coursework_type = coursework_type;
         var default_coord_name = coord_name;
         var default_coord_email = coord_email;
         var default_thesis_title = thesis_title;
         var default_abstract = ab;
         var default_keywords = keywords;
         var default_ab_file_name = ab_file_name;
         var default_ab_file_size = ab_file_size;
         var default_ab_file_link = ab_file_link;
         
		
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
		}
	
		var spinner_style={
			zIndex:'100',
			margin: '1px 1px'
		};
		
		function hasClass(target, className) {
			return new RegExp('(\\s|^)' + className + '(\\s|$)').test(target.className);
		}
		
		/* END @@ Parameters**/
		class InputError extends React.Component{
		  render(){ 
			return (
				  <div style={error_style} className={this.props.visible?'visible':'invisible'}>
					<span>* {this.props.errorMessage}</span>
				  </div>
				
			)
		  }
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
					<div className="col-sm-2">
						<i onClick={this.props.clickHandler} title="Remove" className="glyphicon glyphicon-remove-sign">
						</i>
					</div>
				)
			}
		}
		
		class RemoveButton extends React.Component{
			render() {
				return (
					<div className="col-sm-2">
						<i onClick={this.props.clickHandler} title="Remove" className="glyphicon glyphicon-trash"></i>
					</div>
				)
			}
		}
		
		class DownloadButton extends React.Component{
			render() {
				return (
					<div className="col-sm-2">
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
					<div className="col-sm-2">
						<i onClick={this.props.clickHandler} title="Undo" className="glyphicon glyphicon-step-backward">
						</i>
					</div>
				)
			}
		}
		
		class SelectList extends React.Component{
			constructor(props) { 
				super(props);
				var items = this.props.data;
				for(var i=0; i<items.length; i++)
				{
					items[i].disabled = this.props.readonly ? true : false;
					
				}
				this.state = {
					readonly: this.props.readonly ? true : false,
					value:this.props.default_value? this.props.default_value : '',
					error: false,
					items: this.props.data? this.props.data : []
				};
				
				this.restart = this.restart.bind(this);
				this.editMode = this.editMode.bind(this);
				this.readOnlyMode = this.readOnlyMode.bind(this);
				this.validation = this.validation.bind(this);
				this.handleChange = this.handleChange.bind(this);
				this.handleBlur = this.handleBlur.bind(this);
				this.handleFocus = this.handleFocus.bind(this);
			}
			
			restart() {
				var items = this.props.data;
				for(var i=0; i<items.length; i++)
				{
					items[i].disabled = this.props.readonly ? true : false;
				}
				this.setState({
					readonly: this.props.readonly ? true : false,
					value:this.props.default_value? this.props.default_value:null,
					error: false,
					items: this.props.data? this.props.data : []
				});
			}
			
			editMode()
			{
				var items = this.state.items;
				for(var i=0; i<items.length; i++)
				{
					items[i].disabled = false;
				}
				this.setState({
					readonly: false,
					items: items
				});
			}
			
			readOnlyMode()
			{
				var items = this.state.items;
				for(var i=0; i<items.length; i++)
				{
					items[i].disabled = true;
				}
				this.setState({
					readonly: true,
					items: items
				});
			}
			
			validation() 
			{
				var value = this.state.value;
				var valid = true;
				if ((this.props.required && value == '') || (this.props.required && value == '#')) 
				{
					valid = false;
					this.setState({
						error: true
					});
				}
				else
				{
					valid = true;
					this.setState({
						error: false
					});
				}
				return valid;
			}
			
			handleChange(e) {
				var input = this.refs.selectList;
				var value = input.value;
				this.setState({
					value: value
				});
			}
			
			setValue(e)
			{
				this.setState({
					value: e.org_unit
				});
			}
			
			handleBlur(e){
				var valid = this.validation();
				e.stopPropagation();
			}
			
			handleFocus(e) {
				this.setState({error: false});
				e.stopPropagation();
			}
			
			render() {
				var className="thesis_type_select_list form-group";
				if (this.state.error)
				{
            		className += ' has-error';
				}
				
				var label = (this.props.required) ? <label htmlFor={this.props.name} className="control-label col-sm-2">{this.props.label} <span style={error_style}>*</span> </label> : <label htmlFor={this.props.name} className="control-label col-sm-2">{this.props.label}</label>;
				return (
					<div className={className} onBlur={this.handleBlur} onFocus={this.handleFocus}>
						{label}
						<div className="col-sm-10">
							<select className="form-control" value={this.state.value} defaultValue={this.props.default_value} name={this.props.name} onChange={this.handleChange} ref="selectList" required={this.props.required? true : false } disabled={this.state.readonly}> 
								{this.state.items.map(function(i){
									return (
										<option key={i.value} value={i.value} disabled={i.disabled}>{i.text}</option>
									)
								})}	
								
							</select>
							<div>
								<InputError visible={this.state.error} errorMessage={this.props.emptyMessage} />
							</div>
						</div>
						
					</div>
				);
			}
		}
		
		class SchoolSelector extends React.Component{
			constructor(props) { 
				super(props);
				var items = this.props.data;
				for(var i=0; i<items.length; i++)
				{
					items[i].disabled = this.props.readonly ? true : false;
					
				}
				this.state = {
					readonly: true,
					value:this.props.default_value? this.props.default_value : '',
					error: false,
					items: this.props.data? this.props.data : []
				};
				
				this.restart = this. restart.bind(this);
				this.editMode = this.editMode.bind(this);
				this.readOnlyMode = this.readOnlyMode.bind(this);
				this.validation = this.validation.bind(this);
				this.handleChange = this.handleChange.bind(this);
				this.handleBlur = this.handleBlur.bind(this);
				this.handleFocus = this.handleFocus.bind(this);
			}
			
			restart() {
				var items = this.props.data;
				for(var i=0; i<items.length; i++)
				{
					items[i].disabled = true;
					
				}
				this.setState({
					readonly: true,
					value:this.props.default_value? this.props.default_value:null,
					error: false,
					items: this.props.data? this.props.data : []
				});
			}
			
			editMode()
			{
				var items = this.state.items;
				for(var i=0; i<items.length; i++)
				{
					items[i].disabled = true;
				}
				this.setState({
					readonly: true,
					items: items
				});
			}
			
			readOnlyMode()
			{
				var items = this.state.items;
				for(var i=0; i<items.length; i++)
				{
					items[i].disabled = true;
				}
				this.setState({
					readonly: true,
					items: items
				});
			}
			
			validation() 
			{
				var value = this.state.value;
				var valid = true;
				if ((this.props.required && value == '') || (this.props.required && value == '#')) 
				{
					valid = false;
					this.setState({
						error: true
					});
				}
				else
				{
					valid = true;
					this.setState({
						error: false
					});
				}
				return valid;
			}
			handleChange(e) {
				var input = this.refs.selectList;
				var value = input.value;
				this.setState({
					value: value
				});
			}
			setValue(e)
			{
				this.setState({
					value: e.org_unit,
					error: false
				});
				
			}
			handleBlur(e){
				var valid = this.validation();
				e.stopPropagation();
			}
			handleFocus(e) {
				this.setState({error: false});
				e.stopPropagation();
			}
			render() {
				var className="thesis_type_select_list form-group";
				if (this.state.error)
				{
            		className += ' has-error';
				}
				
				var label = (this.props.required) ? <label htmlFor={this.props.name} className="control-label col-sm-2">{this.props.label} <span style={error_style}>*</span> </label> : <label htmlFor={this.props.name} className="control-label col-sm-2">{this.props.label}</label>;
				return (
					<div className={className} onBlur={this.handleBlur} onFocus={this.handleFocus}>
						{label}
						<div className="col-sm-10">
							<select className="form-control" value={this.state.value} defaultValue={this.props.default_value} name={this.props.name} onChange={this.handleChange} ref="selectList" required={this.props.required? true : false } disabled={this.state.readonly}> 
								{this.state.items.map(function(i){
									return (
										<option key={i.value} value={i.value} disabled={i.disabled}>{i.text}</option>
									)
								})}	
							</select>
							<div>
								<InputError visible={this.state.error} errorMessage={this.props.emptyMessage} />
							</div>
						</div>
						
					</div>
				)
			}
		}
		
		class TextInput extends React.Component{
			constructor(props) { 
				super(props);
				var default_value = '';
				if(this.props.default_value!= '')
				{
					default_value = this.props.default_value
				}
				this.state = {
					readonly: this.props.readonly,
					value: default_value,
					error: false,
					errorMsg: this.props.errorMessage? this.props.errorMessage: ''
				};
				this.restart = this. restart.bind(this);
				this.editMode = this.editMode.bind(this);
				this.readOnlyMode = this.readOnlyMode.bind(this);
				this.validation = this.validation.bind(this);
				this.handleChange = this.handleChange.bind(this);
				this.handleBlur = this.handleBlur.bind(this);
				this.handleFocus = this.handleFocus.bind(this);
			}
		
			restart()
			{
				this.setState({
					readonly: this.props.readonly,
					value:this.props.default_value? this.props.default_value : null,
					error: false,
					errorMsg: this.props.errorMessage? this.props.errorMessage: ''
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
				
				if(this.props.required && value=='') 
				{
					//console.log('ee');
					validation.push(false);
					this.setState({
						error: true
					});
				}
				else if(this.props.minLength)
				{
					if(value.length < this.props.minLength)
					{
						//console.log('min');
						validation.push(false);
						this.setState({
							error: true
						});
					}
				}
				else if(this.props.type=="year")
				{
					//console.log('year value:' + this.state.value);
					value = parseInt(value);
					
					var patt = /(?:(?:19|20)[0-9]{2})/;
					var result = patt.test(value);
					//console.log('result:' + result);
					validation.push(result);
					this.setState({
						error: !result
					})
				}
				else if(this.props.type=="email")
				{
					//console.log('email value:' + value + '////');
					if(value!= '' && value!= null)
					{
						var patt = /^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/;
						var result = patt.test(value);
						if(!result)
						{
							validation.push(false);
							valid = false;
							this.setState({
								error: true
							});
						}
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
			handleBlur(){
				this.validation();
			}
			
			handleFocus(e) {
				this.setState({error: false});
				e.stopPropagation();
			}
			
			render() {
				var className="form-group";
				if (this.state.error)
				{
            		className += ' has-error';
				}
				
				var label = (this.props.required) ? <label htmlFor={this.props.name} className="control-label col-sm-2">{this.props.label} <span style={error_style}>*</span> </label> : <label htmlFor={this.props.name} className="control-label col-sm-2">{this.props.label}</label>;
				
				var input = (this.props.type == 'textarea') ? <textarea className="form-control" name={this.props.name} rows={this.props.rows} placeholder={this.props.placeholder} value={this.state.value} onChange={this.handleChange} ref="input" minLength={this.props.minLength?this.props.minLength : 0} required={this.props.required? true : false } readOnly={this.state.readonly}/> : <input type={this.props.type} className="form-control" name={this.props.name} placeholder={this.props.placeholder} value={this.state.value} onChange={this.handleChange} ref="input" minLength={this.props.minLength?this.props.minLength : 0}  required={this.props.required? true : false } readOnly={this.state.readonly}/>
				
				return(
					<div className={className} onBlur={this.handleBlur} onFocus={this.handleFocus}>
						{label}
						<div className="col-sm-10">
							{input}
							<InputError visible={this.state.error} errorMessage={this.state.errorMsg} />
						</div>
					</div>
				)
			}
		}
		
		class StudentID extends React.Component{
			constructor(props) { 
				super(props);
				this.state = {
					value:this.props.default_value
				};
				
				this.restart = this.restart.bind(this);
				this.editMode = this.editMode.bind(this);
				this.readOnlyMode = this.readOnlyMode.bind(this);
				this.validation = this.validation.bind(this);
			}
			restart()
			{
				
			}
			editMode()
			{
				
			}
			readOnlyMode()
			{
				
			}
			validation()
			{
				return true;
			}
			render() {
				return(
					<div className="form-group" >
						<label htmlFor="stu_id" className="control-label col-md-2">Student ID</label>
						<div className="col-md-10">
							<input type="text" className="form-control" name="stu_id" value={this.state.value} readOnly/>
						</div>
					</div>
				);
			}
		}
		
		class FileUploader extends React.Component{
			constructor(props) { 
				super(props);
				this.state = {
					attachment: '',
					help: this.props.help,
					readonly: this.props.readonly,
					error: false,
					errorMsg: ''
				};
				this.restart = this.restart.bind(this);
				this.editMode = this.editMode.bind(this);
				this.readOnlyMode = this.readOnlyMode.bind(this);
				this.fileUpload = this.fileUpload.bind(this);
				this.validation = this.validation.bind(this);
			}
			restart(e){
				this.setState({
					help: this.props.help,
					readonly: this.props.readonly,
					error: false,
					errorMsg: ''
				});
			}
			editMode(){
				this.setState({
					readonly: false,
					error: false,
					errorMsg: ''
				});
			}
			readOnlyMode(){
				this.setState({
					readonly: true,
					error: false,
					errorMsg: ''
				});
			}
			fileUpload(e)
			{
				e.preventDefault();
				
				if(!(e.target.files.length < 1))
				{
					let file = e.target.files[0];
					let reader = new FileReader();
					
					if(file.size > 0 && file.type != 'application/pdf')
					{
						//clear file input value
						try 
						{
							e.target.value = null;
						} 
						catch(ex) { }
						
						if (e.target.value) {
							e.target.parentNode.replaceChild(e.target.cloneNode(true), e.target);
						}
						
						//reset display help message
						this.setState({
							help: <div style={error_style}>[Warning] No File chosen, please upload a pdf file</div>
						});
					}
					else
					{
					   var str = 'Selected File: '+ file.name;
					   var size = ' - file size: ' + formatBytes(file.size);
				
						this.setState({
							help: <div>{str}<span><i>{size}</i></span> </div>
						});
						
					}
					
					reader.onloadend=()=>{
						if(file.type == 'application/pdf')
						{
							this.setState({
								attachment: file,
								filePreviewUrl: reader.result
							});
							
							//console.log('reader result:' + reader.result);
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
					else if(attachment_obj.type != 'application/pdf')
					{
						valid = false;
						this.setState({
							error: true,
							errorMsg: 'File upload failed - File type can only be pdf'
						});
					}
				}
				return valid;
			}
			render() {
				var error = (this.state.error)?<div className="alert alert-danger" role="alert"><button type="button" className="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{this.state.errorMsg}</div>:<div></div>;
				
				return (
					<div>
						{error}
					  <input type="file" className="file_upload form-control-file" ref="file_attachment" name="abstract_files[]" onChange={this.fileUpload} disabled={this.state.readonly} />
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
                        <div className="col-md-10">
                            <h5 className="text-muted">{this.state.text}</h5>
                        </div> 
                        {download_link}
                    </div>
                );
            }
        }
                
		class File extends React.Component{
			constructor(props) { 
				super(props);
				this.state = {
					readonly: this.props.readonly,
					visible: this.props.visible
				};
				this.restart = this. restart.bind(this);
				this.editMode = this.editMode.bind(this);
				this.readOnlyMode = this.readOnlyMode.bind(this);
				this.extra_remove_button_handler = this.extra_remove_button_handler.bind(this);
				this.validation = this.validation.bind(this);
			}
			restart()
			{
				if(this.props.default_file_name != '')
				{
					this.setState({
						readonly: this.props.readonly,
						visible: (this.props.default_file_name != '')?true:false
					});
				}
				else
				{
					
					this.setState({
						readonly: this.props.readonly,
						visible: (this.props.default_file_name != '')?true:false
					});
					this.refs.file_uploader.restart();
				}
			}
			editMode()
			{
				this.setState({
					readonly: false
				});
				if(!this.state.visible)
				{
					this.refs.file_uploader.editMode();
				}
			}
			readOnlyMode()
			{
				this.setState({
					readonly: true
				});
				if(!this.state.visible)
				{
					this.refs.file_uploader.readOnlyMode();
				}
			}
			
			extra_remove_button_handler()
			{
				this.setState({
					visible: false
				});
			}
			validation()
			{
				var valid = true;
				if(!this.state.visible)
				{
					valid = this.refs.file_uploader.validation();
				}
				
				return valid;
			}
			
			render() {
				var undo_button = (this.props.default_file_name!= '') ? <UndoButton clickHandler={this.props.undoClickHandler} /> : <div></div>;
				var remove_button = (this.state.readonly)? '' : <RemoveButton clickHandler={this.props.clickHandler} /> ;
				var file = this.state.visible ? <div className="panel-body"><div className="row"><div className="col-sm-10"><DefaultFile default_file_name = {this.props.default_file_name} default_file_size = {this.props.default_file_size} file_link = {this.props.file_link} help={this.props.help} readonly={this.state.readonly} /></div> {remove_button} </div></div>: <div className="panel-body"><div className="row"><div className="col-sm-10"> <FileUploader help={this.props.help} ref="file_uploader" readonly={this.state.readonly}/> </div> {undo_button}</div></div>;
				return (
					<div className="panel panel-default">
						{file}
					</div>
				)
			}
		}
		
		class TopicControl extends React.Component{
			constructor(props) { 
				super(props);
				this.state = {
					readonly : this.props.readonly,
					topic_code:this.props.default_topic_code? this.props.default_topic_code:'',
					topic_name:this.props.default_topic_name? this.props.default_topic_name:'',
					topic_code_error: false,
					topic_code_errorMsg: '',
					topic_name_disable: true,
					btn_select_disable: this.props.readonly? true : false
				};
				this.restart = this. restart.bind(this);
				this.editMode = this.editMode.bind(this);
				this.readOnlyMode = this.readOnlyMode.bind(this);
				this.getTopicInfoFromServer = this.getTopicInfoFromServer.bind(this);
				this.handleChange = this.handleChange.bind(this);
				this.handleNameChange = this.handleNameChange.bind(this);
				this.setError = this.setError.bind(this);
				this.handleEnterPress = this.handleEnterPress.bind(this);
			}
			
			restart()
			{
				this.setState({
					readonly : this.props.readonly,
					topic_code:this.props.default_topic_code? this.props.default_topic_code:null,
					topic_name:this.props.default_topic_name? this.props.default_topic_name:null,
					topic_code_error: false,
					topic_code_errorMsg: '',
					topic_name_disable: true,
					btn_select_disable: this.props.readonly? true : false
				});
			}
			readOnlyMode()
			{
				this.setState({
					readonly: true,
					topic_name_disable: true,
					btn_select_disable: true
				});
			}
			editMode()
			{
				this.setState({
					readonly: false
				});
			}
			
			getTopicInfoFromServer() {
				var input = this.refs.topic_code;
				var value = input.value.toUpperCase();
				this.setState({
					topic_code: value,
					btn_select_disable: true
				});
				
				$.ajax({
					url: 'https://flextra-test.flinders.edu.au/flex/rhd/land/getTopicInfo',
					method: "POST",
					data: {'topic_code': this.state.topic_code},
					dataType: 'json',
					cache: false,
					success: function(d) {
						if(d.name=='undefined' || d.name=='' || d.name==null)
						{
							this.setState({
								topic_code_error: true,
								topic_code_errorMsg: 'There is no topic with this code. Examples of valid topic codes are: ENGR9700D and PHCA9512',
								topic_name_disable: true
							});
						}
						else
						{
							this.setState({
								topic_name: d.name,
								topic_code_error: false
							});
							if(d.org_unit != 'undefined' && d.org_unit != 'NULL')
							{
								this.props.setSchool({org_unit: d.org_unit});
							}
						}
					}.bind(this),
					error: function(xhr, status, err) {
						this.setState({
							topic_code_error: true,
							topic_code_errorMsg: 'Topic code not found, please contact flex.help@flinders.edu.au to check the code',
							topic_name_disable: true,
							btn_select_disable: false
						});
					}.bind(this)
				});
			}
			
			handleChange(e)
			{
				var input = this.refs.topic_code;
				var value = input.value.toUpperCase();
				this.setState({
					topic_code: value,
					topic_name: '',
					topic_code_error: false,
					topic_code_errorMsg: '',
					topic_name_disable: true,
					btn_select_disable: false
				});
				this.props.setError();
				this.props.setSchool({org_unit: ''});
			}
			
			handleNameChange(e)
			{
				var input = this.refs.topic_name;
				var value = input.value;
				this.setState({
					topic_name: value,
					topic_code_error: false,
					topic_code_errorMsg: ''
				});
			}
			
			setError()
			{
				this.setState({
					topic_code_error: true,
					topic_code_errorMsg: 'Please input a valid topic code and then click on Confirm button to populate topic name and school data',
					topic_name_disable: true
				});
			}
			
			handleEnterPress(e)
			{
				if(e.key == 'Enter')
				{
					this.getTopicInfoFromServer();
				}
				
			}
			
		 	render(){ 
		      var className="thesis_type_select_list form-group";
				if (this.state.error)
				{
            		className += ' has-error';
				}
				
				var label = (this.props.required) ? <label htmlFor="topic_code" className="control-label col-sm-2">Topic Code: <span style={error_style}>*</span> </label> : <label htmlFor="topic_code" className="control-label col-sm-2">Topic Code:</label>;
				var button = (this.state.btn_select_disable) ? <button className="btn btn-default" type="button" disabled>Confirm</button> : <button className="btn btn-primary" type="button" onClick={this.getTopicInfoFromServer}>Confirm</button>
				
				return (
					<div>
						<div className={className} onBlur={this.handleBlur} onFocus={this.handleFocus}>
							{label}
							<div className="col-sm-8">
								<input type="text" className="form-control" name="topic_code" value={this.state.topic_code} onChange={this.handleChange} ref="topic_code" required={this.props.required? true : false } disabled={this.state.readonly} onKeyDown={this.handleEnterPress}/>
								<InputError visible={this.state.topic_code_error} errorMessage={this.state.topic_code_errorMsg} />
							</div>
							<div className="col-sm-2">
								{button}
							</div>
						</div>
						<div className="row">
						</div>
						
						<div className="form-group">
							<label htmlFor="topic_name" className="control-label col-sm-2">Topic Name: </label>
							<div className="col-sm-10">
								<input type="text" className="form-control" name="topic_name" value={this.state.topic_name} onChange={this.handleNameChange} ref="topic_name" required={this.props.required? true : false } disabled={this.state.topic_name_disable} />
								
							</div>
						</div>
					</div>
				)
		  	}
		}
		
		class TopicControlWrapper extends React.Component{
			constructor(props) { 
				super(props);
				this.state = {
					readonly: this.props.readonly,
					visible: true,
					count: this.props.count,
					error: false,
					errorMsg: '',
					org_num: this.props.org_num
				};
				this.clickHandler = this.clickHandler.bind(this);
				this.setError = this.setError.bind(this);
				this.setSchool = this.setSchool.bind(this);
				this.restart = this.restart.bind(this);
				this.readOnlyMode = this.readOnlyMode.bind(this);
				this.editMode = this.editMode.bind(this);
				this.validation = this.validation.bind(this);
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
			setError()
			{
				this.setState({
					error: false,
					errorMsg: ''
				});
			}
			
			setSchool(d)
			{
				this.props.setSchool({org_unit: d.org_unit});
			}
		
			restart(){
				//console.log('count: ' + this.props.count);
				this.setState({
					readonly: this.props.readonly,
					visible: true,
					count: this.props.count,
					error: false,
					errorMsg: ''
				});
				for(var ref in this.refs)
				{
					
					var i = this.refs[ref];
					i.restart();
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
					i.readOnlyMode();
				}
			}
			
			editMode()
			{
				this.setState({
					readonly: false
				});
				//console.log('topiccontrowrapper readonly: ' + this.state.readonly);
				for(var ref in this.refs)
				{
					var i = this.refs[ref];
					i.editMode();
				}
				
			}
			
			validation()
			{
				//console.log('validation');
				var valid = true;
				if(this.state.visible)
				{
					var t = this.refs.topicControl;
					var topic_code = t.state.topic_code;
					var topic_name = t.state.topic_name;
					var errorMsg = '';
					if(topic_code == null || topic_code == '')
					{
						errorMsg = 'topic code cannot be empty';
						valid = false;
						this.setState({
							error: true,
							errorMsg: errorMsg
						});
					}
					if(topic_name == null || topic_name == '')
					{
						this.refs.topicControl.setError();
						valid = false;
						
					}
				}
				return valid;
			}
			
			render(){  
			    var error = (this.state.error)?<div className="alert alert-danger" role="alert" id="app_error"><button type="button" className="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{this.state.errorMsg}</div>:<div></div>;
				var topicControl = this.state.visible? <TopicControl ref="topicControl" default_topic_code = {this.props.default_topic_code} default_topic_name = {this.props.default_topic_name} readonly ={this.state.readonly}setSchool={this.setSchool} setError={this.setError}/> : '';
				var button = this.state.visible && !this.state.readonly && this.state.count > 1 ? <MinusButton clickHandler={this.clickHandler} /> : '';
				var className="panel panel-default";
				if (!this.state.visible)
				{
					className += ' invisible';
				}
				
				return(
					<div className={className}>
						{error}
						<div className="panel-body">
							<div className="row">
								<div className="col-md-11">
									{topicControl}
								</div> 
								<div className="col-md-1">
									{button}
								</div>
							</div>
						</div>
					</div>
				);
			}
		}
		
		
		class Topic extends React.Component{
			constructor(props) { 
				super(props);
				if(topics.length > 0)
				{
					for(var i = 0; i<topics.length; i++)
					{
						topics[i].readonly = this.props.readonly;
					}
					
					this.state = {
						count: count,
						items: topics,
						readonly: this.props.readonly
					};
				}
				else
				{
					var items = [];
					var temp = {};
					temp["item"] = 1;
					temp["refname"] = "topicControlWrapper_1";
					temp["default_topic_code"] = '';
					temp["default_topic_name"] = '';
					temp["readonly"] = this.props.readonly;
					items.push(temp);
					
					this.state = {
						count: 1,
						items: items,
						readonly: this.props.readonly
					};
					
                        for(var ref in this.refs)
                        {
                            var i = this.refs[ref];
                            i.restart();
                        }
					//this.refs.topicControlWrapper.restart();
				}
				
				this.restart = this. restart.bind(this);
				this.readOnlyMode = this.readOnlyMode.bind(this);
				this.editMode = this.editMode.bind(this);
				this.validation = this.validation.bind(this);
				this.handleAddClick = this.handleAddClick.bind(this);
				this.updateSchool = this.updateSchool.bind(this);
			}
			
			restart()
			{
				if(topics.length > 0)
				{
					for(var i = 0; i<topics.length; i++)
					{
						topics[i].readonly = this.props.readonly;
					}
					
					this.setState({
						count: count,
						items: topics,
						help: this.props.help,
						readonly: this.props.readonly
					});
				}
				else
				{
					var items = [];
					var temp = {};
					temp["item"] = 1;
					temp["refname"] = "topicControlWrapper_1";
					temp["default_topic_code"] = '';
					temp["default_topic_name"] = '';
					items.push(temp);
					
					this.setState({
						count: 1,
						items: items,
						help: this.props.help,
						readonly: this.props.readonly
					});
				}
				
				for(var ref in this.refs)
				{
					var i = this.refs[ref];
					i.restart();
				}
			}
			readOnlyMode()
			{
				if(topics.length > 0)
				{
					for(var i = 0; i<topics.length; i++)
					{
						topics[i].readonly = true;
					}
					
					this.setState({
						items: topics,
						readonly: true
					});
				}
				else
				{
					this.setState({
						readonly: true
					});
				}
				for(var ref in this.refs)
				{
					var i = this.refs[ref];
					i.readOnlyMode();
				}
			}
			editMode()
			{
				//console.log('topic editmode');
				if(topics.length > 0)
				{
					for(var i = 0; i<topics.length; i++)
					{
						topics[i].readonly = false;
					}
					
					this.setState({
						items: topics,
						readonly: false
					});
				}
				else
				{
					this.setState({
						readonly: false
					});
				}
				for(var ref in this.refs)
				{
					var i = this.refs[ref];
					i.editMode();
				}
			}
			validation()
			{
				var valid = true;
				var validation = [];
				for(var ref in this.refs)
				{
					var i = this.refs[ref];
					validation.push(i.validation());
				}
				
				for (var i = 0; i < validation.length; i++) {
					//console.log('valid?? :' + validation[i] );
					if(validation[i] == false)
					{
						valid = false;
						break;
					}
				}
				return valid;
			}
			handleAddClick()
			{
				var count = this.state.count + 1;
				var temp = {};
				temp['item'] = count;
				temp['refname'] = "topicControlWrapper_"+count;
				var items = this.state.items;
				items.push(temp);
				
				this.setState({
					count: count,
					items: items
				});
			}
			updateSchool(e)
			{
				this.setState({
					org_unit: e.org_unit
				});
				//console.log(e.org_unit);
				this.props.updateSchool({org_unit: e.org_unit});
			}
			
			render() {
				var items = this.state.items.map(function(i){
								return <TopicControlWrapper ref={i.refname} key={i.item} count={i.item} default_topic_code={i.default_topic_code} default_topic_name = {i.default_topic_name} readonly = {i.readonly} setSchool={this.updateSchool}/>
							}.bind(this));
				return (
					<div className="form-group"> 
					    <label className="control-label col-sm-2">Topic <span style={error_style}>*</span></label>
						<div className="col-sm-10">
							{items}
						</div>
					</div>
				)
			 }
		}
				
		class ThesisForm extends React.Component{			
			constructor(props) { 
				super(props);
				this.state = {
					loading: false,
					readonly: this.props.readonly,
					comp_yr: yr,
					items:[],
					default_file : (this.props.default_file_name != '') ? true : false,
					error: false,
					org_unit: this.props.org_unit,
					errorMsg : '',
					newThesis: this.props.newThesis,
					uuid: this.props.uuid,
					version: this.props.version
				};
				this.editMode = this.editMode.bind(this);
				this.readOnlyMode = this.readOnlyMode.bind(this);
				this.cancelEdit = this.cancelEdit.bind(this);
				this.updateSchool = this.updateSchool.bind(this);
				this.handleSubmit = this.handleSubmit.bind(this);
				this.handleRemoveClick = this.handleRemoveClick.bind(this);
				this.handleFileControlRestart = this.handleFileControlRestart.bind(this);
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
			readOnlyMode()
			{
				this.setState({
					readonly: true,
					error: false,
					errorMsg : ''
				});
				
				for(var ref in this.refs)
				{
					var i = this.refs[ref];
					//i.restart();
					i.readOnlyMode();
				}
			}
			cancelEdit()
			{
				this.setState({
					readonly: true,
					error: false,
					errorMsg : ''
				});
				
				for(var ref in this.refs)
				{
					var i = this.refs[ref];
					i.restart();
					i.readOnlyMode();
				}
			}
			updateSchool(e) 
			{
				this.setState({
					org_unit: e.org_unit
				});
				
				var school = this.refs.school;
				school.setValue({org_unit: e.org_unit});
			}
			handleSubmit(e) 
			{
				this.setState({
					error: false,
					errorMsg: ''
				});
				var valid = true;
				var validation = [];
				for(var ref in this.refs)
				{
					var i = this.refs[ref];
					
					validation.push(i.validation());
					if(!i.validation())
					{
						$('html, body').animate({ scrollTop: 0 }, 'fast');
						break;
					}
				}
				
				for(var i = 0; i < validation.length; i++) 
				{
					if(validation[i] == false)
					{
						valid = false;
						break;
					}
				}
				//console.log('valid??' + valid);
				//Submit the form if form is valid
				if(valid == true)
				{
					//var form = document.forms[0];
					//var form_groups = document.getElementsByClassName("form-group");
				
					this.readOnlyMode();
					this.setState({
						loading: true
					});
					
					var formData = new FormData();
					
					var uuid =  this.state.uuid;
					var version = this.state.version;
					formData.append('item_uuid', uuid);
					formData.append('item_version', version);
			    
					//console.log('stu_id:' + this.refs.stu_id.state.value);
					if(this.refs.stu_id.state.value != 'undefined')
					{
						
						formData.append('stu_id', this.refs.stu_id.state.value);
					}
					else
					{
						formData.append('stu_id', '');
					}
					
					
					//console.log('stu_pre_first_name:' + this.refs.stu_pre_first_name.state.value);
					if(this.refs.stu_pre_first_name.value != 'undefined')
					{
						formData.append('stu_pre_first_name', this.refs.stu_pre_first_name.state.value);
					}
					else
					{
						formData.append('stu_pre_first_name', '');
					}
					
						
					//console.log('stu_pre_last_name:' + this.refs.stu_pre_last_name.state.value);
					if(this.refs.stu_pre_last_name.value != 'undefined')
					{
						formData.append('stu_pre_last_name', this.refs.stu_pre_last_name.state.value);
					}
					else
					{
						formData.append('stu_pre_last_name', '');
					}
					
					
					//console.log('stu_email:' + this.refs.stu_email.state.value);
					if(this.refs.stu_email.value != 'undefined')
					{
						formData.append('stu_email', this.refs.stu_email.state.value);
					}
					else
					{
						formData.append('stu_email', '');
					}
					
					
					//console.log('school:' + this.refs.school.state.value);
					if(this.refs.school.value != 'undefined')
					{
						
						formData.append('school', this.refs.school.state.value);
					}
					else
					{
						formData.append('school', '');
					}
					
					//console.log('comp_yr:' + this.refs.comp_yr.state.value);
					if(this.refs.comp_yr.value != 'undefined')
					{
						formData.append('comp_yr', this.refs.comp_yr.state.value);
					}
					else
					{
						formData.append('comp_yr', '');
					}
					
					
					//console.log('thesis_type:' + this.refs.thesis_type.state.value);
					if(this.refs.thesis_type.value != 'undefined')
					{
						formData.append('thesis_type', this.refs.thesis_type.state.value);
					}
					else
					{
						formData.append('thesis_type', '');
					}
					
			
					//console.log('thesis_title:' + this.refs.title.state.value);
					if(this.refs.title.value != 'undefined')
					{
						formData.append('thesis_title', this.refs.title.state.value);
					}
					else
					{
						formData.append('thesis_title', '');
					}
					
					
					//console.log('sup_name:' + this.refs.sup_name.state.value);
					if(this.refs.sup_name.value != 'undefined')
					{
						formData.append('sup_name', this.refs.sup_name.state.value);
					}
					else
					{
						formData.append('sup_name', '');
					}
					
					
					if(this.refs.sup_email.value != 'undefined' )
					{
						//console.log('sup_email: '  + this.refs.sup_email.state.value);
						formData.append('sup_email', this.refs.sup_email.state.value);
					}
					else
					{
						formData.append('sup_email', '');
					}
					
					//console.log('keywords:' + this.refs.keywords.state.value);
					if(this.refs.keywords.value != 'undefined')
					{
						formData.append('keywords', this.refs.keywords.state.value);
					}
					else
					{
						formData.append('keywords', '');
					}
					
					//console.log('abstract:' + this.refs.abstract.state.value);
					if(this.refs.abstract.value != 'undefined')
					{
						formData.append('thesis_abstract', this.refs.abstract.state.value);
					}
					else
					{
						formData.append('thesis_abstract', '');
					}
					
					
					var atts = this.refs.file_upload;
					//console.log(atts);
					var default_file = false;
					if(atts.state.visible == false)
					{
						var file_uploader = atts.refs.file_uploader;
						if(file_uploader.state.attachment != "")
						{
							var file = file_uploader.state.attachment;
							formData.append('abstract_file', file, file.name);
						}
					}
					if(atts.state.visible == true && atts.props.default_file_name != '')
					{ 
						default_file = true;
						//formData.append('default_abstract_file', true);	
					}
					
					formData.append('default_abstract_file', default_file);	
					//console.log('default_abstract_file:' + default_file);	
					
					
					var topic = this.refs.topic;
					var topic_state = topic.state.items;
				
					//console.log(topic);
					
					for(var ref in topic.refs)
					{
						var i = topic.refs[ref];
						if(i.state.visible == true)
						{
							var topic_control = i.refs.topicControl;
							formData.append('topic_code[]', topic_control.state.topic_code);
							formData.append('topic_name[]', topic_control.state.topic_name);
						}
					}
					
					var url = '';	
						
					if(this.state.newThesis)
					{
						if(this.state.uuid != '' )
						{
							url = edit_url;
						}
						else
						{
							url = create_url;
						}
					}
					else
					{
						url = edit_url;
					}
				     
					var returnVal = this.props.onThesisUpdate();
					
					$.ajax({
					   url: url,
					   type: 'POST',
					   data: formData,
					   processData: false, // this has to be set to false
					   contentType: false, // this has to be set to false
					   error: function(jqXHR, textStatus, errorThrown){
						    this.setState({
								loading: false,
								readonly: false,
								error: true,
								errorMsg: 'Ajax error, please try again or contact flex.help@flinders.edu.au'
							});
							for(var ref in this.refs)
							{
								var i = this.refs[ref];
								i.editMode();
							}
							var returnVal = this.props.removeThesisUpdate();
							
							$('html, body').animate({ scrollTop: 0 }, 'fast');
						   //console.log('Ajax error: ' + jqXHR + ' ' + textStatus + ' ' +errorThrown);
					   }.bind(this),
					   success: function(data) {
						  // alert(data);
						  // console.log(data);
							var resultobj = jQuery.parseJSON(data);
							var result_status = resultobj.status;
						
							switch(result_status)
							{
								case 'success':
								    if(this.state.newThesis)
									{
										if(this.state.uuid == '')
										{
											uuid = resultobj.uuid;
											version = resultobj.version;
										}
										
										window.location = new_url;
									}
									else
									{
										if(this.state.newThesis!=this.props.newThesis)
										{
											window.location = new_url;
										}
										else
										{
										 	location.reload(true);
										}
									}
									
								break;
								case 'session_time_out':
									
									window.location = redirect_url;
									this.setState({
										loading: false,
										readonly: false,
										error: true,
										errorMsg: resultobj.error_info
									});
									var returnVal = this.props.removeThesisUpdate();
								break;
								case 'itemExists':
									this.setState({
										loading: false,
										readonly: false,
										error: true,
										errorMsg: resultobj.error_info
									});
									for(var ref in this.refs)
									{
										var i = this.refs[ref];
										i.editMode();
									}
									var returnVal = this.props.removeThesisUpdate();
									$('html, body').animate({ scrollTop: 0 }, 'fast');
								break;
								case 'error':
									this.setState({
										loading: false,
										readonly: false,
										error: true,
										errorMsg: resultobj.error_info
									});
									for(var ref in this.refs)
									{
										var i = this.refs[ref];
										i.editMode();
									}
									var returnVal = this.props.removeThesisUpdate();
									$('html, body').animate({ scrollTop: 0 }, 'fast');
								break;
								
								case 'f_error':
									var return_uuid = resultobj.uuid;
									//console.log(return_uuid);
									
									this.setState({
										loading: false,
										readonly: false,
										error: true,
										errorMsg: resultobj.error_info,
										newThesis: false,
										uuid: return_uuid,
										version: 1
									});
									//console.log(this.state.uuid);
									//console.log(this.state.newThesis);
									for(var ref in this.refs)
									{
										var i = this.refs[ref];
										i.editMode();
									}
									var returnVal = this.props.removeThesisUpdate();
									$('html, body').animate({ scrollTop: 0 }, 'fast');
								break;
								case 'invalid':
									this.setState({
										loading: false,
										readonly: false,
										error: true,
										errorMsg: resultobj.error_info
									});
									for(var ref in this.refs)
									{
										var i = this.refs[ref];
										i.editMode();
									}
									var returnVal = this.props.removeThesisUpdate();
									$('html, body').animate({ scrollTop: 0 }, 'fast');
								break;
								
								case 'attachment_error':
									this.setState({
										loading: false,
										readonly: false,
										error: true,
										errorMsg: resultobj.error_info
									});
									for(var ref in this.refs)
									{
										var i = this.refs[ref];
										i.editMode();
									}
									var returnVal = this.props.removeThesisUpdate();
									$('html, body').animate({ scrollTop: 0 }, 'fast');
								break;
							}
							
					   }.bind(this)
					});
				}
			}
			
			handleRemoveClick(e)
			{
				this.setState({
					default_file: false
				});
				this.refs.file_upload.extra_remove_button_handler();
			}
		
			handleFileControlRestart()
			{
				this.setState({
					default_file:(this.props.default_file_name != '') ? true : false
				});
				this.refs.file_upload.restart();
			}
			
			handleResetClick(e)
			{
				for(var ref in this.refs)
				{
					var i = this.refs[ref];
					i.restart();
				}
			}
		
			render() {
				var buttons = '';
				if(this.props.newThesis)
				{
					buttons = <div className="form-group buttons">
									<div className="row">
										<div className="col-md-6">
											<button className="btn btn-primary save" type="button" onClick={this.handleSubmit}>Save and continue</button>
										</div>
										<div className="col-md-6">
										</div>
									</div>
								</div>
				}
				else
				{
					if(this.state.readonly)
					{
						buttons = <div></div>
					}
					else
					{
						buttons = <div className="form-group buttons">
									<div className="col-sm-offset-2 col-sm-10">
										<div className="row">
											<div className="col-sm-6">
												<button className="btn btn-primary save" type="button" onClick={this.handleSubmit} >Save Step 1</button>
											</div>
											<div className="col-sm-6">
											</div>
										</div>
									</div>
								</div>
					}
				}
				
				var loading = (this.state.loading)? 
								<div className="spinner-wave" style={spinner_wave_style}>
								<div style={spinner_style}></div>
								<div style={spinner_style}></div>
								<div style={spinner_style}></div>
								<div style={spinner_style}></div>
								<div style={spinner_style}></div>
								<p style={spinner_style} id="txt_loading">&nbsp;Loading...</p>
                    			</div>:<div></div>;
								
				var error = (this.state.error)?<div className="alert alert-danger" role="alert"><button type="button" className="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{this.state.errorMsg}</div>:<div></div>;
				var class_name = "";
				if(this.props.new_thesis == true || this.props.status != 'draft')
				{
					class_name = "col-md-12";
				}
				else
				{
					class_name = "col-md-10";
				}
				
				var student_id_component = '';
				
				if(student_id == '')
				{
					student_id_component = <TextInput ref="stu_id" label="Student ID" type="text"  name="stu_id"  required={true} errorMessage="Student ID is invalid" emptyMessage="Student ID is required" minLength={5}  default_value={student_id} readonly={this.state.readonly}/>
				  
				}
				else
				{
					student_id_component = <StudentID ref="stu_id" default_value={student_id} />
				}
				
				return (
					<div className={class_name}>
					  {error}
					  <form role="form" className="thesisForm form-horizontal" noValidate>
					  
						{student_id_component}
						
						<TextInput ref="stu_pre_first_name" label="Preferred First Name Display" type="text" name="stu_pre_first_name" placeholder="This will be used in citations and on the publicly available thesis web page." default_value={default_stu_first_name_dip} errorMessage="Preferred first name is invalid" emptyMessage="Preferred first name is required" readonly={this.state.readonly} />
						
						<TextInput ref="stu_pre_last_name" label="Preferred Last Name Display" type="text" name="stu_pre_last_name" placeholder="This will be used in citations and on the publicly available thesis web page." default_value= {default_stu_last_name_dip} errorMessage="Preferred first name is invalid" emptyMessage="Preferred first name is required" readonly={this.state.readonly}/>
						
						<TextInput ref="stu_email" label="Preferred Email Contact" type="email" name="stu_email" required={true} errorMessage="Student Email is invalid" emptyMessage="Student Email is required" default_value={default_stu_email} readonly={this.state.readonly}/>
						
						<SelectList label="Thesis Type" name="thesis_type" emptyMessage="Thesis Type is required" required={true} ref="thesis_type" data={thesis_type} default_value={default_coursework_type}  readonly={this.state.readonly}/>
						
						<Topic readonly={this.state.readonly} ref="topic" updateSchool = {this.updateSchool}/>
						
						<hr/>
						
						<TextInput ref="comp_yr" label="Thesis Completion (year)" name="comp_yr" required={true} errorMessage="Complete year is invalid" emptyMessage="Complete year is required" type="year" default_value={this.props.comp_yr} readonly={this.state.readonly} />
						
						<SchoolSelector label="School" name="school" emptyMessage="Please fill in a valid topic code to populate school data" required={true} valid={this.state.items} ref="school" data={schools} default_value={this.props.org_unit} readonly={this.state.readonly}/>
						
						<TextInput ref="sup_name" label="Principle Supervisor: Name" type="text" name="sup_name" uniqueName="form-group sup_name" required={true} errorMessage="Supervisor name is invalid" emptyMessage="Supervisor name is required" default_value={default_coord_name} readonly={this.state.readonly}/>
						
						<TextInput ref="sup_email" label="Principle Supervisor: Email" type="email" name="sup_email" uniqueName="form-group sup_email" errorMessage="Supervisor email is invalid"  default_value={default_coord_email} readonly={this.state.readonly}/>
						
						<hr/>
					
						
						<TextInput type="textarea" ref="title" label="Thesis Title" rows="5" name="thesis_title" required={true} placeholder="" emptyMessage="Thesis title is required" default_value={default_thesis_title} readonly={this.state.readonly}/>
						
						<TextInput type="textarea" ref="abstract" label="Abstract" rows="10" name="thesis_abstract"  placeholder="" default_value={default_abstract} readonly={this.state.readonly} required={true}/>
						
						
						<div className="form-group abstract">
							<div className="col-sm-offset-2 col-sm-10">
								<p><span className="opt_span">Optional:</span> <i>PDF version of abstract</i></p>
								<File className="form-control" help="" ref="file_upload" default_file_name = {this.props.default_file_name} default_file_size = {this.props.default_file_size} file_link = {this.props.file_link} clickHandler={this.handleRemoveClick} undoClickHandler={this.handleFileControlRestart} visible={this.state.default_file} readonly={this.state.readonly}/>
							</div>
						</div>
						
						<TextInput type="textarea" ref="keywords" label="Keywords (comma separated)" rows="5" name="keywords"  placeholder="" default_value={default_keywords} required={true} readonly={this.state.readonly}/>
					
						<hr/>
						
						{buttons}
					  </form>
					  {loading}
				  </div>
				)
		  	}
		}
		
		class App extends React.Component{	
			constructor(props) { 
				super(props);
				this.state = {
					readonly: this.props.readonly,
					info: 'To update this page, click on Edit button on the right of the page.',
					onThesisUpdate: false
				};
				this.handleEditClick = this.handleEditClick.bind(this);
				this.handleCancelClick = this.handleCancelClick.bind(this);
				this.handleSubmitClick = this.handleSubmitClick.bind(this);
				this.onThesisUpdate = this.onThesisUpdate.bind(this);
				this.removeThesisUpdate = this.removeThesisUpdate.bind(this);
			}
			
			handleEditClick(){
				this.setState({
					readonly: false,
					info: 'To save the content, click on Save Step 1 button on the right or on the bottom of the page'
					
				});
				this.refs.thesis_form.editMode();
			}
			
			handleCancelClick() {
				this.setState({
					readonly: true,
					info: 'To update this page, click on Edit button on the right of the page.',
					onThesisUpdate: false
				});
				this.refs.thesis_form.handleResetClick();
				this.refs.thesis_form.readOnlyMode();
			}
			
			handleSubmitClick(e) {
				this.refs.thesis_form.handleSubmit(e);
			}
			
			onThesisUpdate()
			{
				this.setState({
					onThesisUpdate: true
				});
				return true;
			}
			
			removeThesisUpdate()
			{
				this.setState({
					info: 'To save the content, click Save Step 1 button on the right or on the bottom of the page',
					onThesisUpdate: false
				});
				return true;
			}
			
			render() {
				var button = '';
				var className = 'col-md-12';
				var info = '';
				if(!this.state.onThesisUpdate)
				{
					if(!this.props.newThesis && this.props.status == 'draft')
					{
						info = <div className="col-md-12"><div className="alert alert-info" role="alert">{this.state.info}</div></div>
						button = (this.state.readonly) ? <div className="edit_buttons" ><Button buttonClick={this.handleEditClick} text="Edit"/><hr/></div>: <div className="edit_buttons"><Button className="edit_buttons" buttonClick = {this.handleSubmitClick} text="Save Step 1"/> &nbsp;&nbsp;&nbsp;&nbsp;<Button className="edit_buttons" buttonClick = {this.handleCancelClick} text="Cancel Edit"/><hr/></div>
					}
					else if(this.props.newThesis && this.props.status == 'draft')
					{
						info = <div className="col-md-12"><div className="alert alert-success" role="alert">Please complete all fields marked with <span style={error_style}>*</span></div></div>
					}
				}
				return (
					<div className="row">
						<div className={className}>
							{button}
							
							<ThesisForm default_file_name={default_ab_file_name} default_file_size ={default_ab_file_size}  file_link={default_ab_file_link} readonly={this.state.readonly} ref="thesis_form"  newThesis={this.props.newThesis} comp_yr={this.props.comp_yr} org_unit={this.props.org_unit} uuid={this.props.uuid} version={this.props.version} onThesisUpdate={this.onThesisUpdate} removeThesisUpdate = {this.removeThesisUpdate}/>
						</div>
					</div>
				)
			}
		}
	
		ReactDOM.render(
		  <App newThesis={new_thesis} readonly={read_only} status={default_status} org_unit={org_unit} comp_yr={comp_yr} uuid={item_uuid} version={item_version}/>,
		  document.getElementById('content')
		);