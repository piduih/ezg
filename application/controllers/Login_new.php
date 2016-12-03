<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_new extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		//$this->load->helper(array('form','url','html'));
		//$this->load->library(array('session', 'form_validation'));
		//$this->load->database();
		$this->load->model('User_model');
	}

    public function index()
    {
		// get form input
		//$email = $this->input->post("email");
		$usrn = $this->input->post("usrnme");
        $password = $this->input->post("password");

		// form validation xss_clean
		$this->form_validation->set_rules("usrnme", "Username", "trim|required");
		$this->form_validation->set_rules("password", "Password", "trim|required");
		
		if ($this->form_validation->run() == FALSE)
        {
			// validation fail
			$this->load->view('login_new_view');
			//redirect('login_new');
		}
		else
		{

			$post = $this->input->post();  
            $clean = $this->security->xss_clean($post);    
            $userInfo = $this->User_model->checkLogin($clean);
            //$userInfo = $this->checkLogin($clean);
			
			// check for user credentials
			
			$uresult = $this->User_model->get_user($usrn, $password);
			if (count($uresult) > 0)
			{
				// set session
				$sess_data = array('login' => TRUE, 'uname' => $uresult[0]->fname, 'uid' => $uresult[0]->id);
				$this->session->set_userdata($sess_data);
				redirect("dashboard/index");
			}
			else
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Wrong username or Password!</div>');
				redirect('login_new');
				die();
				//$this->load->view('login_new');
			}
		}
    }

    function logout()
	{
		// destroy session
        $data = array('login' => '', 'uname' => '', 'uid' => '');
        $this->session->unset_userdata($data);
        $this->session->sess_destroy();
        redirect('Login_new');
		//redirect('login_new');
	}

	
}