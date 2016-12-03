<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Downline extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
	}

	public function index()
	{
		$details 				= $this->User_model->get_user_by_id($this->session->userdata('uid'));
		$data['uname'] 			= $details[0]->fname;
		$data['usrname'] 		= $details[0]->usrname;
		$usrname 				= $details[0]->usrname;
		$data['package_id'] 	= $details[0]->package_id;
		$data['email'] 			= $details[0]->email;
		$data['role'] 			= $details[0]->role;
		$data['role_desc'] 		= $details[0]->role_desc;
		$data['created_date'] 	= $details[0]->created_date;
		
		//downlist downline
		$details		= $this->User_model->view_DL();
		$data['dnline']	= $details;

		//sum sebelah kiri
		$details			= $this->User_model->sum_package_left();
		$data['sumpacleft']	= $details[0]->bi_package;

		//sum sebelah kanan
		$details			= $this->User_model->sum_package_right();
		$data['sumpacright']= $details[0]->bi_package;

		$this->load->view('index_sidebar', $data);
		$this->load->view('index_topnav', $data);
		$this->load->view('index_dnline', $data);
		$this->load->view('index_footer');
	}
    /****************************  END downline ****************************/

}
