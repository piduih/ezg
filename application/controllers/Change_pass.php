<?php

class Change_pass extends CI_Controller 
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
		$pass 					= $details[0]->password;

		// submit
		if ($this->form_validation->run() == FALSE)
        {
			// fails
			$this->load->view('index_sidebar', $data);
			$this->load->view('index_topnav', $data);
			$this->load->view('index_passwd',$data);
			$this->load->view('index_footer');	
        }
		else 
		{
			//update user details into db
			$details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
			$uname = $details[0]->usrname;

			date_default_timezone_set('Asia/Kuala_Lumpur');

			$data = array(
    			'update_by'			=> $uname,
    			'update_date'		=> date("Y-m-d H:i:s"),
                'password'			=> md5($this->input->post('npassword'))
			);

			$this->User_model->update_pass($data);
			$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Password updated!.</div>');
			redirect('profile');
/*---------
			if ($this->User_model->update_pass($data))
			{
				$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Password updated!.</div>');
				redirect('profile');
			}
			else
			{
				// error
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error.  Please try again later!!!</div>');
				redirect('profile');
			}
----------*/
		}
	
	}
}
?>