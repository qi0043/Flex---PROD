<style type="text/css">
.form-control:focus
{
	cursor:text !important;
	
}
input.form-control[readonly], textarea.form-control[readonly]{
	border-color:transparent;
	box-shadow: none;
}

input:focus {
    outline: 0 none;
    border: 0 none;
}
.inactive a
{
	color: #777 !important;
}
.active a
{
	color:#eb6e08 !important;
	font-size: 18px;
}

a[disabled="disabled"] {
	pointer-events: none;
}
.glyphicon-exclamation-sign
{
	color: red;
}
.visible
{
   display: block;
}
.invisible
{
   display: none;
}

i.glyphicon
{
	cursor:pointer;
}

#content
{
	padding-top:40px;
}

.opt_span
{
	color: #5bc0de;
	font-weight:bold;
}


.radio_button
{
	padding-bottom: 10px;
}
.radio_button input, .embargo_area, .embargo_area input
{
	margin-left: 20px;
	
}
.radio_button label
{
	font-weight: normal;
}
.file_ul li
{
	line-height: 1.5;
}

.btn_save
{
	margin-bottom:5px;
}
.thesisForm hr	
{
	margin-top:40px;
	margin-bottom:40px;
}

.edit_buttons
{
	margin-left:30px;
}

</style>
<div role="navigator" id="thesis_navigator" >

</div>

<script type="text/babel">

	var data = [];
	<?php
	if(isset($navs))
	{
		$index = 0;
		foreach($navs as $nav)
		{
			$index++;
			
	?>		var temp = {};
			temp["index"] = <?php echo $index ?> ;
			temp["url"] = "<?php echo (isset($nav['url']) && $nav['url']!='') ? base_url() .$nav['url'] : '' ?>";
			temp["valid"] = "<?php echo isset($nav['valid']) ? $nav['valid'] : '' ?>";
			temp["text"] = "<?php echo isset($nav['text']) ? $nav['text'] : '' ?>";
			temp["active"] = "<?php echo isset($nav['active']) ? $nav['active'] : '' ?>";
			temp["disabled"] = "<?php echo isset($nav['disabled']) ? $nav['disabled'] : '' ?>";
			data.push(temp);
	<?php
		}
	}
	?>

	var Li = React.createClass({
		getInitialState: function() {
			return {
				active: this.props.active
			};
		},
		onClick: function() {
			return false;
		},
		render: function(){ 
			
			var className = '';
			if(this.props.disabled)
			{
				if(className == '')
				{
					className += 'disabled';
				}
				else
				{
					className += ' disabled';
				}
			}
			if(this.props.active == 'active')
			{
				if(className == '')
				{
					className += 'active';
				}
				else
				{
					className += ' active';
				}
			}
			if(this.props.active == 'inactive')
			{
				if(className == '')
				{
					className += 'inactive';
				}
				else
				{
					className += ' inactive';
				}
			}
			
			var valid_mark = '';
			if(this.props.valid == 'invalid')
			{
				valid_mark = <i className="glyphicon glyphicon-exclamation-sign"></i>
			}
			var a_link = (this.props.url != "" )? <a href={this.props.url} >{this.props.text} {valid_mark}</a> : <a>{this.props.text}</a>;
			return (
				<li role="presentation" className={className}>{a_link} </li> 
			)
		}
	});


	var Navigator = React.createClass({
		getInitialState: function() {
			return {
				items: data
			};
		},
		
		render: function(){ 
			return(
				<nav>
					<ul className="nav nav-tabs nav-justified">
						{this.state.items.map(function(i){
							return (
								<Li key={i.index} active={i.active} url={i.url} text={i.text} disabled={i.disabled} valid={i.valid} /> 
							)
						})}	
					</ul>
				</nav>
			)
		}
	});
	
	ReactDOM.render(
	  <Navigator data={data} />,
	  document.getElementById('thesis_navigator')
	);
</script>