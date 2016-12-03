<?php
class Reg_downline extends CI_Controller
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
		$this->form_validation->set_rules('usrnme', 'Member ID', 'trim|required|is_unique[user.usrname]');
		$this->form_validation->set_rules('fullname', 'Full Name', 'trim|required|min_length[3]');
		$this->form_validation->set_rules('birthday', 'Date Of Birth', 'trim|required');
		$this->form_validation->set_rules('contact', 'Contact No.', 'trim|required');
		$this->form_validation->set_rules('national_id', 'National ID', 'trim|required');
		//$this->form_validation->set_rules('address', 'Address', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('declaration', 'Declaration', 'trim|required');
		$this->form_validation->set_rules('package', 'Package', 'trim|required');

		$query = $this->User_model->getPackage();
		$data['packages'] = null;
		if($query){
			$data['packages'] = $query;
		}
		
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
		$data['reg_rw_per'] = $details2[0]->reg_amount*(70/100);

		//get sum cash wallet
		$details2 		= $this->User_model->getCW($usrname);
		$data['ch_cw'] = $details2[0]->ch_amount;
		$data['ch_cw_per'] = $details2[0]->ch_amount*(30/100);		

		// submit
		if ($this->form_validation->run() == FALSE)
        {
			// fails
			$this->load->view('index_sidebar', $data);
			$this->load->view('index_topnav', $data);
			$this->load->view('index_regdownline');
			$this->load->view('index_footer');	
        }
		else
		{
			//insert user details into db
			$details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
			$uname = $details[0]->usrname;

			date_default_timezone_set('Asia/Kuala_Lumpur');

			$data = array(
				'usrname'			=> $this->input->post('usrnme'),
				'introducer_name'	=> $uname,
    			'fname'				=> $this->input->post('fullname'),
    			'binary_pos'		=> $this->input->post('binary_pos'),
    			'dob'				=> $this->input->post('birthday'),
    			'gender'			=> $this->input->post('gen'),
    			'contact'			=> $this->input->post('contact'),
    			'email'				=> $this->input->post('email'),
    			'national_id'		=> $this->input->post('national_id'),
    			'address'			=> $this->input->post('address'),
    			'nominee_name'		=> $this->input->post('nominee_name'),
    			'nominee_contact'	=> $this->input->post('nominee_contact'),
    			'declaration'		=> $this->input->post('declaration'),
    			'created_by'		=> $uname,
    			'created_date'		=> date("Y-m-d H:i:s"),
    			'role'				=> '3',
        	    'activ_metod'		=> $this->input->post('activ_metod'),
            	'package_id'		=> $this->input->post('package'),
                'password'			=> md5($this->input->post('usrnme'))
			);


			//get detail for hibah percentage
			$dtl_hibah	= $this->User_model->getHibah();
			$hp			= $dtl_hibah[0]->hibah_percent;

			//data untuk table roi hdr----------------------
			$data_roi = array(
				'roi_user'		=> $this->input->post('usrnme'),
				'roi_upline'	=> $uname,
				'roi_no'		=> $this->input->post('usrnme').date("ymd"),
				'roi_amount'	=> $this->input->post('package') * ($hp/100),
				'roi_jenis'		=> 'ROI', 
				'roi_date'		=> date("Y-m-d H:i:s"),
				'roi_package'	=> $this->input->post('package')
				);
			//insert ke table roi hdr
			$this->User_model->insert_roi_hdr($data_roi);
			//function utk roi dtl
			$this->cal_date_interval();


			//data check ada atau tak leg kiri / kanan
			$dtl_LR = $this->User_model->getBinum_user_LR();
			$binary_number_LR = $dtl_LR[0]->bi_no;
			$binary_id_LR = $dtl_LR[0]->bi_id;

			if ($binary_number_LR == null)
			{
				//data upline if tak ada leg kiri / kanan
				$dtl_r1 = $this->User_model->getBinum_user_r1();
				$binary_number_r1 = $dtl_r1[0]->bi_no;
				$binary_id_r1 = $dtl_r1[0]->bi_id;
				
				//data untuk table binary hdr ----------------------
				//upline orang yg register untuk downline
				$data_binary = array(
					'bi_user'			=> $this->input->post('usrnme'),
					'bi_userupline'		=> $uname,
					'bi_parent_id'		=> $binary_id_r1,
					'bi_no'				=> $binary_number_r1.' -> '.$this->input->post('usrnme'),
					'bi_pos'			=> $this->input->post('binary_pos'), 
					'bi_date'			=> date("Y-m-d H:i:s"),
					'bi_package'		=> $this->input->post('package')
				);
				// insert
				$this->User_model->insert_binary_hdr($data_binary);
			} 
			else
			{
				//binary numbering -------------
				//get last insert from current user --- user
				/*---
				$dtl_bi = $this->User_model->getBinum_user();
				$binary_number = $dtl_bi[0]->bi_no;
				$binary_id = $dtl_bi[0]->bi_id;
				---*/
				
				//data untuk table binary hdr pos kiri atau kanan ----------------------
				$data_binary = array(
					'bi_user'			=> $this->input->post('usrnme'),
					'bi_userupline'		=> $uname,
					'bi_parent_id'		=> $binary_id_LR,
					'bi_no'				=> $binary_number_LR.' -> '.$this->input->post('usrnme'),
					'bi_pos'			=> $this->input->post('binary_pos'), 
					'bi_date'			=> date("Y-m-d H:i:s"),
					'bi_package'		=> $this->input->post('package')
				);
				// insert
				$this->User_model->insert_binary_hdr($data_binary);
			}
			// end binary numbering -----------------


			//data untuk table cash wallet
			/*--- kira dalam mysql procedure -----
			$data_cw = array(
				'ch_user'		=> $this->input->post('usrnme'),
				'ch_no'			=> $this->input->post('usrnme').date("ymd"),
				'ch_amount'		=> ($this->input->post('package') * ($hp/100)) * (80/100),
				'ch_jenis'		=> 'CW', 
				'ch_date'		=> date("Y-m-d H:i:s")
				);
			//insert ke table cash wallet
			$this->User_model->insert_cw($data_cw);

			//data untuk table product wallet
			$data_pw = array(
				'pd_user'		=> $this->input->post('usrnme'),
				'pd_no'			=> $this->input->post('usrnme').date("ymd"),
				'pd_amount'		=> ($this->input->post('package') * ($hp/100)) * (20/100),
				'pd_jenis'		=> 'PW', 
				'pd_date'		=> date("Y-m-d H:i:s")
				);
			//insert ke table product walllet
			$this->User_model->insert_pw($data_pw);
			--------end kira dlm mysql procedure ------*/


			//tolak RW dari upline bila submit register downline 70% rw , 30% cw
			if ($this->input->post('activ_metod')=='RWCW')
			{
				$data5 = array(
					'reg_user'		=> $uname,
					'reg_no'		=> $uname.date("ymd"),
					'reg_amount'	=> -($this->input->post('package')*(70/100)),
					'reg_jenis'		=> 'RW', 
					'reg_from'		=> 'Reg for - '.$this->input->post('usrnme'),
					'reg_date'		=> date("Y-m-d H:i:s")
				);
				$this->User_model->insert_rw($data5);

				$data6 = array(
					'ch_user'		=> $uname,
					'ch_no'			=> $uname.date("ymd"),
					'ch_amount'		=> -($this->input->post('package')*(30/100)),
					'ch_jenis'		=> 'CW',
					'ch_from'		=> 'Reg for - '.$this->input->post('usrnme'),
					'ch_date'		=> date("Y-m-d H:i:s")
				);
				$this->User_model->insert_cw($data6);
			}
			//end tolak------

			//insert SW 10% dari package signup downline
			$data7 = array(
				'sp_user'		=> $uname,
				'sp_no'			=> $this->input->post('usrnme').date("ymd"),
				'sp_amount'		=> ($this->input->post('package') * (10/100)),
				'sp_jenis'		=> 'SW', 
				'sp_date'		=> date("Y-m-d H:i:s")
				);
			//insert ke table transaksi
			$this->User_model->insert_sw($data7);

			if ($this->User_model->insert_user($data))
			{
				$this->session->set_flashdata('msg','<div class="alert alert-success text-center">You are Successfully Signup New Member. Please ask them to login and change their password.</div>');
				redirect('reg_downline');
			}
			else
			{
				// error
				$this->session->set_flashdata('msg','<div class="alert alert-danger text-center">Oops! Error.  Please try again later!!!</div>');
				redirect('reg_downline');
			}
		}
	}

	function cal_date_interval()
	{
		//roi dtl

		//get cycle
		$dtl_cyc	= $this->User_model->getCycle();
		$cycle_days = $dtl_cyc[0]->cycle_days;

		date_default_timezone_set('Asia/Kuala_Lumpur');

		$pay_cycles=12;
		$period=$cycle_days;
		$d = date("Y-m-d H:i:s");

		//echo "date join: $d<p>"; 

		for ($i=1;$i<=$pay_cycles;$i++) 
		{
			//if first loop get todays date
 			if($i==1)
 			{
 				$time = strtotime ( "$d +$period day" ) ;
 				$due = date("Y-m-d",$time);
 				//else add to previous date
 			} 
 			else 
 			{
 				$time = strtotime ( "$due +$period day" ) ;
 				$due = date("Y-m-d", $time); 
 			}
   		//$arr[] = $due;
 		//echo "$due<br>";
 		$data_roi_dtl = array(
				'roi_user'		=> $this->input->post('usrnme'),
				'roi_no'		=> $this->input->post('usrnme').date("ymd"),
				//'roi_amount'	=> $this->input->post('package') * ($hp/100),
				'roi_jenis'		=> 'ROI', 
				'roi_date'		=> $due
				//'roi_package'	=> $this->input->post('package')
				);
 		$this->User_model->insert_roi_dtl($data_roi_dtl);
		}
	}
}	