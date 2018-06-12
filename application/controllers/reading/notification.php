<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends CI_Controller {

	public function noprivilege()
	{
                $errdata['message'] = "You don't have the required privilege to view this page.";
                $errdata['heading'] = "Error";
		$this->load->view('reading_rollover/showerror_view.php',$errdata);
	}
}
