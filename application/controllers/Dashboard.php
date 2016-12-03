<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url','html'));
		$this->load->library('session');
		$this->load->database();
		$this->load->model('User_model');
	}
	
	function index()
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

		$query 				= $this->User_model->getRate();
		$data['rate'] 		= null;
		if($query){
			$data['rate'] 	= $query;
		}

		$query 					= $this->User_model->getPackage();
		$data['packages'] 		= null;
		if($query){
			$data['packages'] 	= $query;
		}

		//get sum register wallet
		$details2 		= $this->User_model->getRW($usrname);
		$data['reg_rw'] = $details2[0]->reg_amount;

		//get sum cash wallet
		$details2 		= $this->User_model->getCW($usrname);
		$data['ch_cw'] = $details2[0]->ch_amount;

		//get sum product wallet
		$details2 		= $this->User_model->getPW($usrname);
		$data['pd_pw'] = $details2[0]->pd_amount;

		//get sum ROI
		$details2 		= $this->User_model->getROI($usrname);
		$data['roi_roi'] = $details2[0]->roi_amount;

		//get sum SW
		$details2 		= $this->User_model->getSW($usrname);
		$data['sp_sw'] = $details2[0]->sp_amount;

		//get sum BW
		$details2 		= $this->User_model->getBW($usrname);
		$data['bns_bw'] = $details2[0]->bi_amount;

		//get cycle
		$details2 		= $this->User_model->getCycle();
		$data['cyc_days'] = $details2[0]->cycle_days;

		//get percent hibah
		$details2 		= $this->User_model->getHibah();
		$data['hibah_per'] = $details2[0]->hibah_percent;

		//get roi date
		$details		= $this->User_model->view_roi_dtl();
		$data['roidate']	= $details;

		$this->load->view('index_sidebar', $data);
		$this->load->view('index_topnav', $data);
		$this->load->view('index_content', $data);
		$this->load->view('index_footer');
		//$this->load->view('indexa', $data);
		//$this->load->view('dboard', $data);
	}

}