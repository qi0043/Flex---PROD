<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {


	public function __construct()
    {
		parent::__construct();
		$ci = & get_instance();
		$ci->load->config('flex');
		$this->load->model('rhd/rhd_cron_model');
		if(!isset($_SESSION)){ session_start();}
	}

	public function restrict()
	{
		$error_list = array();
		$update_list = array();
		$release_list = array();
		$update_status = 'F';
		$update_count = 0;


		$this->load->helper('url');
		//$oauth = array('oauth_client_config_name' => 'rhd');
		//$this->load->library('flexrest/flexrest', $oauth);
		$this->load->library('flexrest/flexrest');
		$ci = & get_instance();
		$ci->load->config('flex');

		$collection_id = $ci->config->item('rhd_collection');
		$success = $this->flexrest->processClientCredentialToken();
		if(!$success)
		{
			exit;
		}
		$restricted_theses = $this->rhd_cron_model->eq_db_get_all_embargo_thesis($collection_id);

		echo '<pre>';
		print_r($restricted_theses);
		echo '</pre>';

		if(count($restricted_theses)>0)
		{
			foreach($restricted_theses as $thesis)
			{
				$su = $this->flexrest->getItemAll($thesis['uuid'], $thesis['version'], $response);
				if(!$su)
				{
					$update_status = 'PS';
					array_push($error_list, 'get item failed (getItem), item uuid: ' . $thesis['uuid'] . ', error: ' . $this->flexrest->error);
					unset($response);
				}
				else
				{
					$item_bean = $response;
					unset($response);
					$xmlwrapper = 'xmlwrapper' . $thesis['uuid'];
					$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$item_bean['metadata']), $xmlwrapper);
					$thesis_xml = $this->Xml2Array($this->$xmlwrapper);
					echo 'thesis array: <pre>';
					print_r($thesis_xml);
					echo '</pre>';
					echo 'attachment array: <pre>';
					print_r($item_bean['attachments']);
					echo '</pre>';


					if($thesis_xml['status'] == 'Restricted Access')
					{
						$attachment = $item_bean['attachments'];
						if($thesis_xml['open_access_required'] == 'new version')
						{
							if(isset($thesis_xml['open_access_thesis']) && count($thesis_xml['open_access_thesis'])>0)
							{
								foreach($thesis_xml['open_access_thesis'] as $o_thesis)
								{
									$o_uuid = $o_thesis['uuid'];
									for($j=0; $j<count($attachment); $j++)
									{
										$a_uuid = $attachment[$j]['uuid'];
										if($o_uuid == $a_uuid)
										{
											echo 'restrict status: ' . $item_bean['attachments'][$j]['restricted'] . '<br/>';
											$item_bean['attachments'][$j]['restricted'] = 'true';
											echo 'open access thesis restrcition set to true <br/>';
											break;
										}
									}
								}
							}
						}
						elseif($thesis_xml['open_access_required'] == 'version of record')
						{
							if(isset($thesis_xml['examined_thesis']) && count($thesis_xml['examined_thesis'])>0)
							{
								foreach($thesis_xml['examined_thesis'] as $e_thesis)
								{
									$e_uuid = $e_thesis['uuid'];

									for($i=0; $i<count($attachment); $i++)
									{
										$a_uuid = $attachment[$i]['uuid'];
										if($e_uuid == $a_uuid)
										{
											  echo 'restrict status: ' . $item_bean['attachments'][$i]['restricted'] . '<br/>';
											  $item_bean['attachments'][$i]['restricted'] = 'true';
											  echo 'examined_thesis version restrcition set to true<br/>';
											  break;
										}
									}
								}
							}
						}

						$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/thesis/release/embargo_release/release_status", '', true);
						//$current_date = date("Y-m-d");
						$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/thesis/release/embargo_release/embargo_release_date", '', true);

						$s = $this->flexrest->filesCopy($thesis['uuid'], $thesis['version'], $f_response);

						/*echo 'file copy array: <pre>';
					print_r($f_response);
					echo '</pre>';*/

						if($s)
						{
							if(!isset($f_response['headers']['location']))
							{
								$update_status = 'PS';
								array_push($error_list, 'Copying file failed, item uuid: ' . $thesis['uuid'] . ', error: ' . 'No Location header in response to copy files REST call.');
								break;
							}
							$location = $f_response['headers']['location'];
							$filearea_uuid = substr($location, strpos($location, 'file')+5, 36);

							//echo 'file area uuid' . $filearea_uuid.'<br/>';

							$item_bean['metadata'] = $this->$xmlwrapper->__toString();

							$f = $this->flexrest->editItem($thesis['uuid'], $thesis['version'], $item_bean, $re, $filearea_uuid);
							if(!$f)
							{
								$update_status = 'PS';
								array_push($error_list, 'restrict attachment failed (editItem), item uuid: ' . $thesis['uuid'] . ', error: ' . $this->flexrest->error);
								break;
							}

							if($update_status!='PS')
							{
								$update_count++;
								$tmp = array('item_uuid' => $thesis['uuid'], 'item_version' => $thesis['version']);
								array_push($update_list, $tmp);
							}
						}
						else
						{
							$update_status = 'PS';
							array_push($error_list, 'file copy error: failed, item uuid: ' . $thesis['uuid'] . ', error: ' . $this->flexrest->error);
							return;
						}
						unset($f_response);
					}
				}

				echo '<hr/>';
			}
		}
		if($update_status!= 'PS')
		{
			$update_status = 'S';
		}

		echo 'update_status:'.$update_status.'<br/>';
		echo 'update_count:'.$update_count.'<br/>';
		echo 'update_list: <pre>';
		print_r($update_list);
		echo '</pre>';

		echo 'error array: <pre>';
		print_r($error_list);
		echo '</pre>';
	}

	public function release()
	{
		$error_list = array();
		$update_list = array();
		$update_status = 'F';
		$update_count = 0;

	    $ci = & get_instance();
		$ci->load->config('flex');
		$this->load->helper('url');

		$oauth = array('oauth_client_config_name' => 'rhd');
		$this->load->library('flexrest/flexrest', $oauth);

		$collection_id = $ci->config->item('rhd_collection');
		$success = $this->flexrest->processClientCredentialToken();

		if(!$success)
		{
			$update_status = 'F';
			$msg = $this->auto_email($update_status, $update_count, $update_list, $error_list);
			$this->rhd_cron_model->db_set_last_imported_timestamp('rhd',date("Y-m-d H:i:s"), $update_status, $msg);
			exit;
		}

		$restricted_theses = $this->rhd_cron_model->eq_db_get_embargo_thesis($collection_id);

		/*echo 'database return array: <pre>';
		print_r($restricted_theses);
		echo '</pre>';*/

		if(count($restricted_theses)>0)
		{
			foreach($restricted_theses as $thesis)
			{
				/*echo 'thesis array: <pre>';
				print_r($thesis);
				echo '</pre>';*/

				$su = $this->flexrest->getItemAll($thesis['uuid'], $thesis['version'], $response);
				if(!$su)
				{
					$update_status = 'PS';
					array_push($error_list, 'get item failed (getItem), item uuid: ' . $thesis['uuid'] . ', error: ' . $this->flexrest->error);
					unset($response);
				}
				else
				{
					$item_bean = $response;
					unset($response);
					$xmlwrapper = 'xmlwrapper' . $thesis['uuid'];
					$this->load->library('xmlwrapper/xmlwrapper', array('xmlString' => (string)$item_bean['metadata']), $xmlwrapper);
					$thesis_xml = $this->Xml2Array($this->$xmlwrapper);
					/*echo 'thesis xml  array: <pre>';
					print_r($thesis_xml);
					echo '</pre>';
					*/

					if($thesis_xml['release_status'] == '' && $thesis_xml['embargo_release_date'] == '')
					{
						$attachment = $item_bean['attachments'];
						if($thesis_xml['open_access_required'] == 'new version')
						{
							if(isset($thesis_xml['open_access_thesis']) && count($thesis_xml['open_access_thesis'])>0)
							{
								foreach($thesis_xml['open_access_thesis'] as $o_thesis)
								{
									$o_uuid = $o_thesis['uuid'];
									for($j=0; $j<count($attachment); $j++)
									{
										$a_uuid = $attachment[$j]['uuid'];
										if($o_uuid == $a_uuid)
										{
											$item_bean['attachments'][$j]['restricted'] = 'false';
											//echo 'open access thesis restrcition set to false<br/>';
											break;
										}
									}
								}
							}
						}
						elseif($thesis_xml['open_access_required'] == 'version of record')
						{
							if(isset($thesis_xml['examined_thesis']) && count($thesis_xml['examined_thesis'])>0)
							{
								foreach($thesis_xml['examined_thesis'] as $e_thesis)
								{
									$e_uuid = $e_thesis['uuid'];

									for($i=0; $i<count($attachment); $i++)
									{
										$a_uuid = $attachment[$i]['uuid'];
										if($e_uuid == $a_uuid)
										{
											  $item_bean['attachments'][$i]['restricted'] = 'false';
											 // echo 'examined_thesis version restrcition set to false<br/>';
											  break;
										}
									}
								}
							}
						}

						$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/thesis/release/embargo_release/release_status", 'Released', true);
						$current_date = date("Y-m-d");
						$this->$xmlwrapper->setNodeValue("/xml/item/curriculum/thesis/release/embargo_release/embargo_release_date", $current_date, true);

						$s = $this->flexrest->filesCopy($thesis['uuid'], $thesis['version'], $f_response);

						/*echo 'file copy array: <pre>';
						print_r($f_response);
						echo '</pre>';*/

						if($s)
						{
							if(!isset($f_response['headers']['location']))
							{
								$update_status = 'PS';
								array_push($error_list, 'Copying file failed, item uuid: ' . $thesis['uuid'] . ', error: ' . 'No Location header in response to copy files REST call.');
								break;
							}
							$location = $f_response['headers']['location'];
							$filearea_uuid = substr($location, strpos($location, 'file')+5, 36);

							//echo 'file area uuid' . $filearea_uuid.'<br/>';

							$item_bean['metadata'] = $this->$xmlwrapper->__toString();

							$f = $this->flexrest->editItem($thesis['uuid'], $thesis['version'], $item_bean, $re, $filearea_uuid);
							if(!$f)
							{
								$update_status = 'PS';
								array_push($error_list, 'restrict attachment failed (editItem), item uuid: ' . $thesis['uuid'] . ', error: ' . $this->flexrest->error);
								break;
							}

							if($update_status!='PS')
							{
								$update_count++;
								$tmp = array('item_uuid' => $thesis['uuid'], 'item_version' => $thesis['version']);
								array_push($update_list, $tmp);
							}
						}
						else
						{
							$update_status = 'PS';
							array_push($error_list, 'file copy error: failed, item uuid: ' . $thesis['uuid'] . ', error: ' . $this->flexrest->error);
							return;
						}
						unset($f_response);

					}
				}
			}
		}
		if($update_status!= 'PS')
		{
			$update_status = 'S';
		}

		/*echo 'update_status:'.$update_status.'<br/>';
		echo 'update_count:'.$update_count.'<br/>';
		echo 'update_list: <pre>';
		print_r($update_list);
		echo '</pre>';

		echo 'error array: <pre>';
		print_r($error_list);
		echo '</pre>';*/

		$msg = $this->auto_email($update_status, $update_count, $update_list, $error_list);
		/*echo 'email sent <pre>';
		print_r($msg);
		echo '</pre>';*/

		$this->rhd_cron_model->db_set_last_imported_timestamp('RHD - Release',date("Y-m-d H:i:s"), $update_status, 'Completed: '.$update_count.'thesis released');
	}


	/****************** private functions **********************************************************/


	private function auto_email($update_status, $update_count, $update_list, $error_list)
	{
		$current_timestamp = date("Y-m-d H:i:sa");
		$this->load->library('email');
		$msg = '';
		for($i = 0; $i < count($error_list); $i++)
		{
			$msg = $msg . '  ' . $error_list[$i];
		}
		$this->email->from('DoNotReply@flinders.edu.au', 'DoNotReply@flinders.edu.au');
		$this->email->to('flex.support@flinders.edu.au');
		$this->email->subject('RHD Thesis release notification');

		$mes = 'update_status:'.$update_status.'  ';
		$mes .= 'update_count:'.$update_count.'  ';
		$mes .= 'Update list:';

		if(count($update_list)>0)
		{
			for($i = 0; $i < count($update_list); $i++)
			{
				$mes .= $i.'. item_uuid:'.$update_list[$i]['item_uuid'].'item_version: '.$update_list[$i]['item_version'].'  ';
			}
		}
		else
		{
			$mes .= 'N/A'.'  ';
		}
		$mes .= 'Error list:';
		if(count($error_list) >0)
		{
			for($i = 0; $i < count($error_list); $i++)
			{
				$mes .= $i.'.'.$error_list[$i].'  ';
			}
		}
		else
		{
			$mes .= 'N/A'.'  ';
		}

		$this->email->message($mes);
		$this->email->send();
		return $mes;
	}


	private function setRestriction($att, $setValue)
	{
		$att['restricted'] = $setValue;
		return $att;
	}

	private function Xml2Array($itemXml)
    {
       $tmp = array();
       $status = '/xml/item/curriculum/thesis/release/status';
	   $tmp['status'] = $itemXml->nodeValue($status);

	   $release_status = '/xml/item/curriculum/thesis/release/embargo_release/release_status';
	   $tmp['release_status'] = $itemXml->nodeExists($release_status)? $itemXml->nodeValue($release_status) : '';

	   $embargo_release_date = '/xml/item/curriculum/thesis/release/embargo_release/embargo_release_date';
	   $tmp['embargo_release_date'] = $itemXml->nodeExists($embargo_release_date )? $itemXml->nodeValue($embargo_release_date) : '';

	   $tmp['numExaminedThesis'] = $itemXml->numNodes('/xml/item/curriculum/thesis/version/examined_thesis/files/uuid');
	   for ($i = 1; $i <= $tmp['numExaminedThesis'];  $i++) {

			$examined_thesis_uuid = '/xml/item/curriculum/thesis/version/examined_thesis/files/uuid['.$i.']';
			$tmp['examined_thesis'][$i]['uuid'] = $itemXml->nodeValue($examined_thesis_uuid);
	   }

	   $open_access_required = '/xml/item/curriculum/thesis/version/open_access/required';
	   $tmp['open_access_required'] =  $itemXml->nodeValue($open_access_required);

	   if($tmp['open_access_required'] == 'new version')
	   {
		   $tmp['numOpenThesis'] = $itemXml->numNodes('/xml/item/curriculum/thesis/version/open_access/files/uuid');

		   for ($i = 1; $i <= $tmp['numOpenThesis'];  $i++) {
				$open_access_thesis_uuid = '/xml/item/curriculum/thesis/version/open_access/files/uuid['.$i.']';
				$tmp['open_access_thesis'][$i]['uuid'] = $itemXml->nodeValue($open_access_thesis_uuid);
	   	   }
	   }
       return $tmp;
    }





}
?>
<body>
</body>
</html>
