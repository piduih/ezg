<?php
class Wallet extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this->load->helper(array('form','url'));
		//$this->load->library(array('session', 'form_validation'));
		//$this->load->database();
		$this->load->model('User_model');
	}
	
	function index()
	{
		$this->load->library('form_validation');
		// set form validation rules xss_clean md5
		$this->form_validation->set_rules('amount', 'Amount', 'trim|required|is_natural_no_zero');
		$this->form_validation->set_rules('transto', 'Transfer to', 'trim|required');
		//$this->form_validation->set_rules('usrname', 'Member ID', 'required|callback_username_check');
		
		$details 				= $this->User_model->get_user_by_id($this->session->userdata('uid'));
		$data['uname'] 			= $details[0]->fname;
		$data['usrname'] 		= $details[0]->usrname;
		$usrname 				= $details[0]->usrname;
		$data['package_id'] 	= $details[0]->package_id;
		$data['email'] 			= $details[0]->email;
		$data['role'] 			= $details[0]->role;
		$data['role_desc'] 		= $details[0]->role_desc;
		$data['created_date'] 	= $details[0]->created_date;

		//get sum register wallet
		$details2 		= $this->User_model->getRW($usrname);
		$data['reg_rw'] = $details2[0]->reg_amount;
		$reg_rw = $details2[0]->reg_amount;

		//get sum cash wallet
		$details2 		= $this->User_model->getCW($usrname);
		$data['ch_cw'] = $details2[0]->ch_amount;
		$ch_cw = $details2[0]->ch_amount;

		$query = $this->User_model->getMembers();
		$data['members'] = null;
		if($query){
			$data['members'] = $query;
		}

		$a = $this->input->post('amount');

		// submit
		if ($this->form_validation->run() == FALSE)
		{
			// fails
			$this->load->view('index_sidebar', $data);
			$this->load->view('index_topnav', $data);
			$this->load->view('index_wallet');
			$this->load->view('index_footer');	
        }
        elseif (($a > $reg_rw) || ($a > $ch_cw))
        {
        	$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error.  Please try again!!!</div>');
        	redirect('wallet');
        }
		else
		{
			//insert user details into db
			$details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
			$uname = $details[0]->usrname;

			date_default_timezone_set('Asia/Kuala_Lumpur');

			if ($this->input->post('transf_type') == 'RW')
			{
			//add dtl to
			$data = array(
				'reg_user'		=> $this->input->post('transto'),
				'reg_no'		=> $this->input->post('transto').date("ymd"),
    			'reg_amount'	=> $this->input->post('amount'),
            	'reg_jenis'		=> $this->input->post('transf_type'),
            	'reg_date'		=> date("Y-m-d H:i:s"),
           		'reg_from'		=> $uname,
           		'reg_to'		=> $this->input->post('transto')
               	//'pass'		=> md5($this->input->post('passwd'))
			);
			$this->User_model->insert_rw($data);

			//add dtl from
			$data = array(
				'reg_user'		=> $uname,
				'reg_no'		=> $uname.date("ymd"),
    			'reg_amount'	=> -($this->input->post('amount')),
            	'reg_jenis'		=> $this->input->post('transf_type'),
            	'reg_date'		=> date("Y-m-d H:i:s"),
           		'reg_from'		=> $uname,
           		'reg_to'		=> $this->input->post('transto')
			);

			if ($this->User_model->insert_rw($data))
			{
				$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Your transfer was success.</div>');
				redirect('wallet');
			}
			else
			{
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error.  Please try again later!!!</div>');
				redirect('wallet');
			}

			}

			if ($this->input->post('transf_type') == 'CW')
			{
			//add dtl to
			$data = array(
				'ch_user'		=> $this->input->post('transto'),
				'ch_no'			=> $this->input->post('transto').date("ymd"),
    			'ch_amount'		=> $this->input->post('amount'),
            	'ch_jenis'		=> $this->input->post('transf_type'),
            	'ch_date'		=> date("Y-m-d H:i:s"),
           		'ch_from'		=> $uname,
           		'ch_to'			=> $this->input->post('transto')
			);
			$this->User_model->insert_cw($data);

			//add dtl from
			$data = array(
				'ch_user'		=> $uname,
				'ch_no'			=> $uname.date("ymd"),
    			'ch_amount'		=> -($this->input->post('amount')),
            	'ch_jenis'		=> $this->input->post('transf_type'),
            	'ch_date'		=> date("Y-m-d H:i:s"),
           		'ch_from'		=> $uname,
           		'ch_to'			=> $this->input->post('transto')
			);

			if ($this->User_model->insert_cw($data))
			{
				$this->session->set_flashdata('msg','<div class="alert alert-success text-center">Your transfer was success.</div>');
				redirect('wallet');
			}
			else
			{
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error.  Please try again later!!!</div>');
				redirect('wallet');
			}

			}
		}
	}

}