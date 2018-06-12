<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/***********************************************************************

Class to restrict or release  embargo thesis

@$itemUuid            thesis item uuid
@$itemVersion         thesis version number
@$condition boolean   true: restrict thesis / false release thesis
************************************************************************/
class RhdRestriction extends CI_Controller {

	public function index($itemUuid='missed', $itemVersion='missed', $condition='true')
    {
		if($condition!='true' && $condition!= 'false')
		{
			 $errdata['message'] = "Invalid Request";
			//log_message('error', 'invalid request item uuid: ' . $itemUuid . ', error: ' . $errdata['message']);
            $this->load->view('rhd/showerror_view', $errdata);
            return;

		}

/* ----------------------------------------------
		echo '<pre>';
		echo '<h3>Varaiables array</h3>';
		print_r($this->uri->segment_array());
		echo '</pre>';
*/

		


		session_start();
	    ignore_user_abort(true);
		// Set your timelimit to a length long enough for your script to run,
		// but not so long it will bog down your server in case multiple versions run
		// or this script get's in an endless loop.
		$content = '';
		if($condition == 'true')
		{
			$content = 'Thesis restricted!';         // Get the content of the output buffer
		}
		else if($condition == 'false')
		{
			$content = 'Thesis released!';         // Get the content of the output buffer
		}
		
		#echo $content;
		#exit;
		
		
		
		#ob_end_clean();                     // Close current output buffer
		$len = strlen($content);
		header('Content-Type: text/html; charset=UTF-8');
		header('Content-Encoding: none;');
		header('Connection: close');         // Tell the client to close connection
		#header("Content-Length: $len");      // Close connection after $size characters
		#echo $content;                       // Output content
		ob_flush();
        flush();                             // Force php-output-cache to flush to flex.

		ob_end_flush();

        #make sure sam work flow completely finishes
		sleep(5);
        $errdata['heading'] = "Error";

        if($this->validate_params($itemUuid, $itemVersion, $condition) == false)
        {
            $errdata['message'] = "Invalid Request";
			//log_message('error', 'invalid request item uuid: ' . $itemUuid . ', error: ' . $errdata['message']);
            $this->load->view('rhd/showerror_view', $errdata);
            return;
        }

        $this->load->helper('url');
		$oauth = array('oauth_client_config_name' => 'rhd');
	    $this->load->library('flexrest/flexrest', $oauth);
       // $this->load->library('flexrest/flexrest');

        $success = $this->flexrest->processClientCredentialToken();
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
            //$this->load->view('rhd/showerror_view', $errdata);
			log_message('error', 'Failed processClientCredentialToken, item uuid: ' . $itemUuid . ', error: ' . $errdata['message']);
            return;
        }

        $success = $this->flexrest->getItemMetadata($itemUuid, $itemVersion, $response);
        if(!$success)
        {
            $errdata['message'] = $this->flexrest->error;
			//log_message('error', 'get item failed (getItemAll), item uuid: ' . $itemUuid . ', error: ' . $errdata['message']);
            $this->load->view('rhd/showerror_view', $errdata);
            return;
		}

		/* ------------------------------- */
		
		echo '<pre>';
		echo '<h3>Item Metadata</h3>';
		print_r($response);
		echo '</pre>';

		#exit;

		

		unset($response['headers']);
		$item_bean = $response;
		$xmlwrapper = 'xmlwrapper_'.$itemUuid;

		//pull out metadata XML
		$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$item_bean['metadata']), $xmlwrapper);
		$theses = $this->Xml2Array($this->$xmlwrapper);


		/* ------------------------------- */
		
		echo '<pre>';
		echo '<h3>Theses array</h3>';
		print_r($theses);
		echo '</pre>';

		#exit;

		

		$release_status = $theses['release_status'];
		

		

	   if($condition == 'false')
	   {
	   		$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/thesis/release/embargo_release/release_status", 'Released', true);
	   		$current_date = date("Y-m-d");
	   		$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/thesis/release/embargo_release/embargo_release_date", $current_date, true);
	   }

	   if($condition == 'true') // Restrict the thesis
	   {
			   $this->$xmlwrapper->setNodeValue("/xml/item/curriculum/thesis/release/embargo_release/release_status", 'under embargo', true);
			   #$new_release = '/xml/item/curriculum/thesis/release/embargo_release/release_status';
	   		$current_date = date("Y-m-d");
			   $this->$xmlwrapper->setNodeValue("/xml/item/curriculum/thesis/release/embargo_release/embargo_release_date", '', true);
			   
			   /* ------------------------------- 
		
				echo '<pre>';
				echo '<h3>New release status</h3>';
				echo $itemXml->nodeValue($new_release);
				echo '</pre>';

				*/
	   }


		   $item_bean['metadata'] = $this->$xmlwrapper->__toString();

			/* ---------------------------------------	*/
			echo '<pre>';
			echo '<h3>item bean</h3>';
			print_r ($item_bean);
			echo '</pre>';

		    #exit;

		   

		$f = $this->flexrest->editItem($itemUuid, $itemVersion, $item_bean, $re);

		/* ---------------------------------------	*/
		echo '<pre>';
		echo '<h3>Edit item response</h3>';
		print_r ($re);
		echo '</pre>';

		#exit;


		if(!$f)
		{
			 $errdata['message'] = $this->flexrest->error;
			 log_message('error', 'restrict attachment failed (editItem), item uuid: ' . $itemUuid . ', error: ' . $errdata['message']);
			 //$this->load->view('rhd/showerror_view', $errdata);
			 return;
		}





	}
	


    

	/****************** private functions **********************************************************/

	private function setRestriction($att, $setValue)
	{
		$att['restricted'] = $setValue;
		return $att;
	}
	/***
	 * transfer metadata to array
	 * @itemXml
	***/
	private function Xml2Array($itemXml)
    {
       $tmp = array();
       $release_status = '/xml/item/curriculum/thesis/release/status';
	   $tmp['release_status'] = $itemXml->nodeValue($release_status);
	   $open_access_required = '/xml/item/curriculum/thesis/version/open_access/required';
	   $tmp['open_access_required'] =  $itemXml->nodeValue($open_access_required);


       return $tmp;
    }
	/**
     * Validate incoming parameters
     *
     * @param array $uuid, item UUID
     * @param array $version, item Version
     */
    protected function validate_params($uuid, $version, $con)
    {
        if(strcmp($uuid, 'missed')==0 || strlen($uuid) != 36)
            return false;

        if(strcmp($version, 'missed')==0 || !is_numeric($version))
            return false;

		if($con!='true' && $con!='false')
		{
			return false;
		}

        return true;
    }

}
