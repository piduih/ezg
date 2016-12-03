<?php

class Profile extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
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
		$session_data = $this->session->userdata('logged_in');

     $query=$this->db->query("select * from user where id=".$session_data['id']);

     foreach ($query->result() as $my_info) {

     $db_password = $my_info->password;

     $db_id = $my_info->id; 
	}

     if ((md5($this->input->post('opassword',$db_password)) == $db_password) && ($this->input->post('npassword') != '') && ($this->input->post('cpassword')!='')) 
	{ 

		$fixed_pw = md5($this->input->post('npassword'));

     $update = $this->db->query("Update user SET password='$fixed_pw' WHERE id='$db_id'")or die(mysql_error()); 

     $this->form_validation->set_message('change','<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Password Updated!</strong></div>');
	return false;
   }
   else  
	{
		$this->form_validation->set_message('change','<div class="alert alert-error"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>Wrong Old Password!</strong> </div>');
	return false;
	}
}
}
?>