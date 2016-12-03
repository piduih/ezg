<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends CI_Controller {

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

		//get cycle
		$details 			= $this->User_model->getCycle();
		$data['id_cyc'] 	= $details[0]->id_cycle;
		$data['cyc_days'] 	= $details[0]->cycle_days;
		$data['up_by'] 		= $details[0]->update_by;
		$data['up_date'] 	= $details[0]->update_date;

		$this->load->view('index_sidebar', $data);
		$this->load->view('index_topnav', $data);
		$this->load->view('index_manage', $data);
		$this->load->view('index_footer');
	}

    /****************************  START OPEN EDIT FORM WITH DATA *************/
    public function edit_cycle($id)
    {
    $this->data['edit_cycle']= $this->User_model->edit_cycle($id);
    $this->load->view('edit_cyc', $this->data, FALSE);
    }
    /****************************  END OPEN EDIT FORM WITH DATA ***************/


    /****************************  START UPDATE DATA *************************/
    public function update_cycle($id)
    {
    $data = array('cycle_days'          => $this->input->post('cycle'),
                  'update_by'			=> $usrname,
                  'update_date'         => date("Y/m/d h:i:s"));
    $this->db->where('id_cycle', $id);
    $this->db->update('cycle', $data);
    $this->session->set_flashdata('message', 'Your data updated Successfully..');
    redirect('Manage');
    }
    /****************************  END UPDATE DATA ****************************/

    /****************************  manage users ****************************/
	public function user()
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
		
		$details			= $this->User_model->getMembers();
		$data['usrlist']	= $details;

		$this->load->view('index_sidebar', $data);
		$this->load->view('index_topnav', $data);
		$this->load->view('index_users', $data);
		$this->load->view('index_footer');
	}
    /****************************  END manage users ****************************/

}
