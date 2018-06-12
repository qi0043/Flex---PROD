import React ,{Component} from 'react';
import ReactDOM from 'react-dom';
 
var data = nav_data;
 
 class Li extends React.Component {
      constructor(props) {    /* Note props is passed into the constructor in order to be used */
            super(props);
       }
   
        onClick() {
            return false;
        }
    
        render(){ 
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
}

class Navigator extends React.Component {
    
        constructor(props) {    /* Note props is passed into the constructor in order to be used */
          super(props);
          this.state = {
             items: this.props.items
          };
        }
		
		render(){ 
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
	}
	
	ReactDOM.render(
	  <Navigator items={data} />,
	  document.getElementById('thesis_navigator')
	);
