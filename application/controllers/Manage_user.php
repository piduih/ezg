<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage_user extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
		$this->load->model('user_model');

	}

	public function _example_output($output = null)
	{
		$details = $this->user_model->get_user_by_id($this->session->userdata('uid'));
		$data['uname'] = $details[0]->fname;
		$data['usrname'] = $details[0]->usrname;
		$data['role'] = $details[0]->role;
		$data['role_desc'] = $details[0]->role_desc;


		$this->load->view('index_sidebar', $data);
		$this->load->view('index_topnav', $data);
		$this->load->view('manage_user.php',$output);
		$this->load->view('index_footer', $data);
		
	}

	function multigrids()
	{
		$this->config->load('grocery_crud');
		$this->config->set_item('grocery_crud_dialog_forms',true);
		$this->config->set_item('grocery_crud_default_per_page',10);

		$output1 = $this->offices_management2();

		$output2 = $this->users_management();

		$output3 = $this->customers_management2();

		$js_files = $output1->js_files + $output2->js_files + $output3->js_files;
		$css_files = $output1->css_files + $output2->css_files + $output3->css_files;
		$output = "<h1>List 1</h1>".$output1->output."<h1>List 2</h1>".$output2->output."<h1>List 3</h1>".$output3->output;

		$this->_example_output((object)array(
				'js_files' => $js_files,
				'css_files' => $css_files,
				'output'	=> $output
		));
	}

	public function offices()
	{
		$output = $this->grocery_crud->render();

		$this->_example_output($output);
	}

	public function index()
	{
		$this->_example_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));

	}

	public function users_management()
	{
			$crud = new grocery_CRUD();

			//$crud->set_theme('bootstrap');

			$crud->set_table('user');
			$crud->columns('usrname','fname','lname','email','role');
			$crud->display_as('usrname','User')
				 ->display_as('fname','First Name')
				 ->display_as('lname','Last Name')
				 ->display_as('email','Email')
				 ->display_as('role','Role');
			$crud->set_subject('Members');
			$crud->set_relation('role','role','role_desc');
			$crud->edit_fields('usrname','fname','lname','email','role');


			$output = $crud->render();

			$this->_example_output($output);
	}

	public function update_profile()
	{
			$crud = new grocery_CRUD();

			$details = $this->user_model->get_user_by_id($this->session->userdata('uid'));
			$data['uid'] = $details[0]->id;

			$crud->where('id',$this->session->userdata('uid'));

			$crud->set_table('user');
			$crud->columns('usrname','fname','lname','email','role');
			$crud->display_as('usrname','User')
				 ->display_as('fname','First Name')
				 ->display_as('lname','Last Name')
				 ->display_as('email','Email')
				 ->display_as('role','Role');
			$crud->set_subject('Members');
			$crud->set_relation('role','role','role_desc');
			$crud->edit_fields('usrname','fname','lname','email','role');

			$crud->unset_delete();
			$crud->unset_print();
			$crud->unset_export();
			$crud->unset_add();

			$crud->set_crud_url_path(site_url('manage_user/update_profile'));

			$output = $crud->render();

			$this->_example_output($output);
	}

}