<?php echo validation_errors(); ?>

<?php echo form_open('test/edit/'.$user['id']); ?>

	<div>Usrname : <input type="text" name="usrname" value="<?php echo ($this->input->post('usrname') ? $this->input->post('usrname') : $user['usrname']); ?>" /></div>
	<div>Fname : <input type="text" name="fname" value="<?php echo ($this->input->post('fname') ? $this->input->post('fname') : $user['fname']); ?>" /></div>
	<div>Introducer Name : <input type="text" name="introducer_name" value="<?php echo ($this->input->post('introducer_name') ? $this->input->post('introducer_name') : $user['introducer_name']); ?>" /></div>
	<div>Dob : <input type="text" name="dob" value="<?php echo ($this->input->post('dob') ? $this->input->post('dob') : $user['dob']); ?>" /></div>
	<div>Gender : <input type="text" name="gender" value="<?php echo ($this->input->post('gender') ? $this->input->post('gender') : $user['gender']); ?>" /></div>
	<div>Contact : <input type="text" name="contact" value="<?php echo ($this->input->post('contact') ? $this->input->post('contact') : $user['contact']); ?>" /></div>
	<div>Email : <input type="text" name="email" value="<?php echo ($this->input->post('email') ? $this->input->post('email') : $user['email']); ?>" /></div>
	<div>National Id : <input type="text" name="national_id" value="<?php echo ($this->input->post('national_id') ? $this->input->post('national_id') : $user['national_id']); ?>" /></div>
	<div>Address : <input type="text" name="address" value="<?php echo ($this->input->post('address') ? $this->input->post('address') : $user['address']); ?>" /></div>
	<div>Password : <input type="password" name="password" value="<?php echo ($this->input->post('password') ? $this->input->post('password') : $user['password']); ?>" /></div>
	<div>Status : <input type="text" name="status" value="<?php echo ($this->input->post('status') ? $this->input->post('status') : $user['status']); ?>" /></div>
	<div>Role : <input type="text" name="role" value="<?php echo ($this->input->post('role') ? $this->input->post('role') : $user['role']); ?>" /></div>
	<div>Package Id : <input type="text" name="package_id" value="<?php echo ($this->input->post('package_id') ? $this->input->post('package_id') : $user['package_id']); ?>" /></div>
	<div>Last Login : <input type="text" name="last_login" value="<?php echo ($this->input->post('last_login') ? $this->input->post('last_login') : $user['last_login']); ?>" /></div>
	<div>Activ Metod : <input type="text" name="activ_metod" value="<?php echo ($this->input->post('activ_metod') ? $this->input->post('activ_metod') : $user['activ_metod']); ?>" /></div>
	<div>Binary Pos : <input type="text" name="binary_pos" value="<?php echo ($this->input->post('binary_pos') ? $this->input->post('binary_pos') : $user['binary_pos']); ?>" /></div>
	<div>Created By : <input type="text" name="created_by" value="<?php echo ($this->input->post('created_by') ? $this->input->post('created_by') : $user['created_by']); ?>" /></div>
	<div>Created Date : <input type="text" name="created_date" value="<?php echo ($this->input->post('created_date') ? $this->input->post('created_date') : $user['created_date']); ?>" /></div>
	<div>Update By : <input type="text" name="update_by" value="<?php echo ($this->input->post('update_by') ? $this->input->post('update_by') : $user['update_by']); ?>" /></div>
	<div>Update Date : <input type="text" name="update_date" value="<?php echo ($this->input->post('update_date') ? $this->input->post('update_date') : $user['update_date']); ?>" /></div>
	<div>Nominee Name : <input type="text" name="nominee_name" value="<?php echo ($this->input->post('nominee_name') ? $this->input->post('nominee_name') : $user['nominee_name']); ?>" /></div>
	<div>Nominee Contact : <input type="text" name="nominee_contact" value="<?php echo ($this->input->post('nominee_contact') ? $this->input->post('nominee_contact') : $user['nominee_contact']); ?>" /></div>
	<div>Declaration : <input type="text" name="declaration" value="<?php echo ($this->input->post('declaration') ? $this->input->post('declaration') : $user['declaration']); ?>" /></div>
	<div>Bank Name : <input type="text" name="bank_name" value="<?php echo ($this->input->post('bank_name') ? $this->input->post('bank_name') : $user['bank_name']); ?>" /></div>
	<div>Acc Num : <input type="text" name="acc_num" value="<?php echo ($this->input->post('acc_num') ? $this->input->post('acc_num') : $user['acc_num']); ?>" /></div>
	<div>Holder Name : <input type="text" name="holder_name" value="<?php echo ($this->input->post('holder_name') ? $this->input->post('holder_name') : $user['holder_name']); ?>" /></div>
	
	<button type="submit">Save</button>
	
<?php echo form_close(); ?>