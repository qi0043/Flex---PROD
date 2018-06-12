<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Report extends CI_Controller {

	public function index()
	{
		$this->get_report();
	}
	
	public function __construct()
	{
		parent::__construct();

		session_start();
		$ci =& get_instance();
		$ci->load->config('flex');
		$this->load->helper('url');
		
		if(isset($_SESSION['tcreport_privilege']) && $_SESSION['tcreport_privilege']=='lib_viewer')
		   return;
		#return;####
		
		if(isset($_SESSION['tcreport_privilege']) && $_SESSION['tcreport_privilege']=='none')
		{
			redirect( 'coord/notification/noprivilege');
			return;
		}
		
		if(!isset($_SERVER['REMOTE_USER']))
		{
			####
			$errdata['message'] = 'Unable to get username';
			$errdata['heading'] = "Internal error";
			$this->load->view('coord/showerror_view', $errdata);
			$this->output->_display();
			exit();
		}
		$userUuid = $_SERVER['REMOTE_USER'];

		$soapusername = $ci->config->item('soap_activation_username');
		$soappassword = $ci->config->item('soap_activation_password');
		$soapparams = array('username'=>$soapusername, 'password'=>$soappassword);
		
		#$groups = 'EQ contributor'; #### '';
		$groups = '';
		
		#$usergrp1_activation = $ci->config->item('usergrp1_activation');
                $usergrp_listmgr_libviewer = $ci->config->item('usergrp_listmgr_libviewer');
		
		$this->load->library('flexsoap/flexsoap',$soapparams);
		if(!$this->flexsoap->success)
		{
			####
			$errdata['message'] = $this->flexsoap->error_info;
			$errdata['heading'] = "Internal error";
			$this->load->view('coord/showerror_view', $errdata);
			$this->output->_display();
			exit();
		}
		
		$groups = $this->flexsoap->getGroupsByUser($userUuid);
		if(!$this->flexsoap->success)
		{
			$errdata['message'] = $this->flexsoap->error_info;
			$errdata['heading'] = "Internal error";
			$this->load->view('coord/showerror_view', $errdata);
			$this->output->_display();
			exit();
		}
		
		#must in the user group to proceed.
		if(strpos($groups, $usergrp_listmgr_libviewer) === false)
		{
			$_SESSION['tcreport_privilege'] = 'none';
			redirect( 'coord/notification/noprivilege');
		}
		else
		{
			$_SESSION['tcreport_privilege'] = 'lib_viewer';
		}
	}
	
	public function get_report()
	{
		$this->load->helper('url');
        $this->load->library('flexrest/flexrest');
		
		$school = $this->input->get('school');
		$topic = $this->input->get('topic');
		$year = $this->input->get('year');
		$semester = $this->input->get('semester');
		
		$this->load->model('/coord/Coord_model');
		$result = $this->Coord_model->get($school, $topic, $year, $semester);
			
		$data = array("school"=>$school, "topic"=>$topic, "year"=>$year, "semester"=>$semester, "result"=>$result);
		$this->load->view('coord/view_coord', $data);
	}
	
}

