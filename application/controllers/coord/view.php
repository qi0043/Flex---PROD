<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class View extends CI_Controller {

	public function index()
	{
		$this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		
		$this->load->view('coord/view_coord');
	}
	
}


