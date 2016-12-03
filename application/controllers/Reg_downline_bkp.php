<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reg_downline extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->helper(array('url','html'));
		//$this->load->library('session');
		//$this->load->database();
		$this->load->model('user_model');

	}

	
	public function index()
	{

		$details = $this->user_model->get_user_by_id($this->session->userdata('uid'));
		
        $data['uname'] = $details[0]->fname;
		$data['usrname'] = $details[0]->usrname;
		$data['role'] = $details[0]->role;
		$data['role_desc'] = $details[0]->role_desc;

		$this->load->view('index_sidebar', $data);
		$this->load->view('index_topnav', $data);
		$this->load->view('index_regdownline', $data);
		$this->load->view('index_footer', $data);
        
    }

/****************************  START INSERT FORM DATA ********************/
    public function submit_data()
    {

        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[user.usrname]');

        if ($this->form_validation->run() == FALSE)
        {
            // fails
            //$this->load->view('signup_view');
            $this->load->view('index_sidebar', $data);
            $this->load->view('index_topnav', $data);
            $this->load->view('index_regdownline', $data);
            $this->load->view('index_footer', $data);
        }
        else
        {
			$details = $this->user_model->get_user_by_id($this->session->userdata('uid'));
			$uname = $details[0]->usrname;

    		$data_submit = array('usrname'	=> $this->input->post('username'),
    				'introducer_name'      	=> $this->input->post('introducer')
                    /*-----------
    				'fname'      			=> $this->input->post('fname'),
    				'binary_pos'   			=> $this->input->post('binary_pos'),
    				'dob'      				=> $this->input->post('dob'),
    				'gender'      			=> $this->input->post('gender'),
    				'contact'      			=> $this->input->post('contact'),
    				'email'      			=> $this->input->post('email'),
    				'national_id'      		=> $this->input->post('national_id'),
    				'address'      			=> $this->input->post('address'),
    				'nominee_name'     		=> $this->input->post('nominee_name'),
    				'nominee_contact'  		=> $this->input->post('nominee_contact'),
    				'declaration'  			=> $this->input->post('declaration'),
    				'created_by'  			=> $uname,
    				'role'					=> '3',
        	        'activ_metod'           => $this->input->post('activ_metod'),
            	    'package_id'            => $this->input->post('package'),
                	'password'              => md5($this->input->post('username'))
                    ------------*/
                  	);
    
    		$insert = $this->user_model->insert_data($data_submit);
    		redirect('reg_downline/success');
        }
    }
    /****************************  END INSERT FORM DATA ************************/

    public function success()
    {
		$details = $this->user_model->get_user_by_id($this->session->userdata('uid'));
		$data['uname'] = $details[0]->fname;
		$data['usrname'] = $details[0]->usrname;
		$data['role'] = $details[0]->role;
		$data['role_desc'] = $details[0]->role_desc;

		$this->load->view('index_sidebar', $data);
		$this->load->view('index_topnav', $data);
		$this->load->view('formsuccess', $data);
		$this->load->view('index_footer', $data);    	
    }

    /****************************  START FETCH OR VIEW FORM DATA ***************/
    public function view_data()
    {

        $details = $this->user_model->get_user_by_id($this->session->userdata('uid'));
        $data['uname'] = $details[0]->fname;
        $data['usrname'] = $details[0]->usrname;
        $data['role'] = $details[0]->role;
        $data['role_desc'] = $details[0]->role_desc;
        
        $query = $this->user_model->getDownline();
        $data2['downline'] = null;
        if($query){
            $data2['downline'] = $query;
        }

        $this->load->view('index_sidebar', $data);
        $this->load->view('index_topnav', $data);
        $this->load->view('index_downlinelist',$data2);
        $this->load->view('index_footer', $data);

    
    
    }
    /****************************  END FETCH OR VIEW FORM DATA ***************/

}