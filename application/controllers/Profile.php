<?php

class Profile extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('User_model');
	}

	function index()
	{
		//$this->form_validation->set_rules('opassword','Old Password','required|trim');
		$this->form_validation->set_rules('npassword','New Password','required|trim');
		$this->form_validation->set_rules('cpassword','Confirm Password','required|trim|matches[npassword]');

		$details 				= $this->User_model->get_user_by_id($this->session->userdata('uid'));
		$data['uname'] 			= $details[0]->fname;
		$data['usrname'] 		= $details[0]->usrname;
		$usrname 				= $details[0]->usrname;
		$data['package_id'] 	= $details[0]->package_id;
		$data['email'] 			= $details[0]->email;
		$data['role'] 			= $details[0]->role;
		$data['role_desc'] 		= $details[0]->role_desc;
		$data['created_date'] 	= $details[0]->created_date;
		$data['dob'] 			= $details[0]->dob;
		$data['nid'] 			= $details[0]->national_id;
		$data['contact'] 		= $details[0]->contact;
		$data['created_date']	= $details[0]->created_date;
		$data['address']		= $details[0]->address;
		$data['bank_name']		= $details[0]->bank_name;
		$data['acc_num']		= $details[0]->acc_num;
		$data['holder_name']	= $details[0]->holder_name;
		$pass 					= $details[0]->password;

		$this->load->view('index_sidebar', $data);
		$this->load->view('index_topnav', $data);
		$this->load->view('index_profile_edit',$data);
		$this->load->view('index_footer');		
	}


}

?>