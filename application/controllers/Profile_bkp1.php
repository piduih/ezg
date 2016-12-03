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
		$details 				= $this->User_model->get_user_by_id($this->session->userdata('uid'));
		$data['uname'] 			= $details[0]->fname;
		$data['usrname'] 		= $details[0]->usrname;
		$usrname 				= $details[0]->usrname;
		$data['package_id'] 	= $details[0]->package_id;
		$data['email'] 			= $details[0]->email;
		$data['role'] 			= $details[0]->role;
		$data['role_desc'] 		= $details[0]->role_desc;
		$data['created_date'] 	= $details[0]->created_date;

		$this->load->view('index_sidebar', $data);
		$this->load->view('index_topnav', $data);
		$this->load->view('index_passwd',$data);
		$this->load->view('index_footer');	
	}

	public function changepwd()
	{
		$this->form_validation->set_rules('opassword','Old Password','required|trim|xss_clean|callback_change');
		$this->form_validation->set_rules('npassword','New Password','required|trim');
		$this->form_validation->set_rules('cpassword','Confirm Password','required|trim|matches[npassword]');

		if ($this->form_validation->run() == FALSE)
		{
			echo validation_errors();
		}
	}

	public function change() // we will load models here to check with database
	{
		$details 		= $this->User_model->get_user_by_id($this->session->userdata('uid'));
		$usrname 		= $details[0]->usrname;
		$db_password 	= $details[0]->password;
		$db_id 			= $details[0]->id; 

		if ((md5($this->input->post('opassword',$db_password)) == $db_password) && ($this->input->post('npassword') != '') && ($this->input->post('cpassword')!='')) 
		{ 
			$fixed_pw = md5($this->input->post('npassword'));
			$update = $this->db->query("Update user SET password='$fixed_pw' WHERE id='$db_id'")or die(mysql_error()); 

			$this->form_validation->set_message('msg','<div class="alert alert-success"><strong>Password Updated!</strong></div>');
		
			redirect('profile');
		}
		else
		{
			$this->form_validation->set_message('msg','<div class="alert alert-error"><strong>Wrong Current Password!</strong> </div>');
	
			redirect('profile');

		}
	}
}
?>