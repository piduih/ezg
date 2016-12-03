<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{

	// untuk reset password
	public $status; 
    public $roles;

	function __construct()
    {
        parent::__construct();

        // untuk reset password
        $this->load->helper(array('form','url','html'));
        $this->load->library(array('session', 'form_validation'));
        $this->load->database();
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');

    }

   /**************************  START INSERT QUERY ***************/
    public function insert_data($data){
        $this->db->insert('user', $data); 
        return TRUE;
    }

    public function insert_transaksi($data){
        $this->db->insert('transaksi', $data); 
        return TRUE;
    }
    /**************************  END INSERT QUERY ****************/

    /*************  START SELECT or VIEW ALL QUERY ***************/
    public function view_data(){

        $details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
        $usrname = $details[0]->usrname;
        $this->db->where('introducer_name', $usrname);
        $this->db->order_by('id');
        $query = $this->db->get('user');
        return $query->result();
    }
    /***************  END SELECT or VIEW ALL QUERY ***************/
    
    /*************  START SELECT or VIEW ALL QUERY for Downline ***************/
/*--- backup ----
    public function view_DL(){

        $details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
        $usrname = $details[0]->usrname;
        $this->db->where('introducer_name', $usrname);
        $this->db->order_by('id');
        $query = $this->db->get('user');
        return $query->result();
--- end backup */

    public function view_DL(){

        $details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
        $usrname = $details[0]->usrname;
        $this->db->like('bi_no',$usrname);
        $this->db->not_like('bi_user',$usrname);
        $query = $this->db->get('binary_hdr');
        return $query->result();
    }
    /***************  END SELECT or VIEW ALL QUERY ***************/
    
    /*************  START SELECT or VIEW ALL QUERY for Downline ***************/
/*---backup 
    public function sum_package_left(){

        $details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
        $usrname = $details[0]->usrname;
        $L = 'L';
        $this->db->select_sum('package_id');
        $this->db->where('introducer_name', $usrname);
        $this->db->where('binary_pos',$L);
        $this->db->order_by('id');
        $query = $this->db->get('user');
        return $query->result();
 end backup   
    }
---*/

    public function view_bonus(){

        $details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
        $usrname = $details[0]->usrname;
        $this->db->where('bi_user',$usrname);
        $this->db->group_by('bi_date');
        $query = $this->db->get('binary_hdr_hst');
        return $query->result();
    }

    public function sum_package_left(){

        $details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
        $usrname = $details[0]->usrname;
        $p = 'L';
        $this->db->select_sum('bi_package');
        $this->db->where('bi_user', $usrname);
        $this->db->where('bi_pos',$p);
        $query = $this->db->get('binary_hdr_cal');
        return $query->result();
    }
/*-----
    public function sum_package_left(){

        $details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
        $usrname = $details[0]->usrname;
        $L = 'L';
        $this->db->select_sum('bi_package');
        $this->db->like('bi_no', $usrname);
        $this->db->not_like('bi_user', $usrname);
        $this->db->where('bi_pos',$L);
        $query = $this->db->get('binary_hdr');
        return $query->result();
    }
----*/
        public function sum_package_right(){

        $details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
        $usrname = $details[0]->usrname;
        $p = 'R';
        $this->db->select_sum('bi_package');
        $this->db->where('bi_user', $usrname);
        $this->db->where('bi_pos',$p);
        $query = $this->db->get('binary_hdr_cal');
        return $query->result();
    }
    /***************  END SELECT or VIEW ALL QUERY ***************/
/*--    
        public function sum_package_right(){

        $details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
        $usrname = $details[0]->usrname;
        $p = 'R';
        $this->db->select_sum('bi_package');
        $this->db->like('bi_no', $usrname);
        $this->db->not_like('bi_user', $usrname);
        $this->db->where('bi_pos',$p);
        $query = $this->db->get('binary_hdr');
        return $query->result();
    }
--*/    
    /***************  END SELECT or VIEW ALL QUERY ***************/
        /*************  START SELECT or VIEW ALL QUERY for roi ***************/
    public function view_roi_dtl(){

        $details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
        $usrname = $details[0]->usrname;
        $this->db->where('roi_user', $usrname);
        $this->db->order_by('roi_date');
        $query = $this->db->get('roi_dtl');
        return $query->result();
    }
    /***************  END SELECT or VIEW ALL QUERY ***************/
    
    /*************  START SELECT or VIEW ALL QUERY for CW ***************/
    public function view_CW(){

        $CW = 'CW';

        $details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
        $usrname = $details[0]->usrname;
        $this->db->where('ch_user', $usrname);
        $this->db->where('ch_jenis',$CW);
        $this->db->order_by('ch_id');
        $query = $this->db->get('cash_wallet_hdr');
        return $query->result();
    }
    /***************  END SELECT or VIEW ALL QUERY ***************/
    
    /*************  START SELECT or VIEW ALL QUERY for RW ***************/
    public function view_RW(){

        $CW = 'RW';

        $details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
        $usrname = $details[0]->usrname;
        $this->db->where('reg_user', $usrname);
        $this->db->where('reg_jenis',$CW);
        $this->db->order_by('reg_date');
        $query = $this->db->get('reg_wallet_hdr');
        return $query->result();
    }
    /***************  END SELECT or VIEW ALL QUERY ***************/

    function getPackage(){

        $this->db->select("id_package, package_code");
        $this->db->from("package");
        $query = $this->db->get();
        return $query->result();
    }

//get days of cycle...
    function getCycle(){

        $this->db->select("id_cycle,cycle_days, update_by, update_date");
        $this->db->from("cycle");
        $query = $this->db->get();
        return $query->result();
    }

    //get bi_no from binary_hdr ... null or not
    function getBinum(){

        $this->db->select("*");
        $this->db->from("binary_hdr");
        $query = $this->db->get();
        return $query->result();
    }

    //get bi_no from binary_hdr depend on current user
    //cari kaki yg paling last if wujud
    function getBinum_user(){

        $details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
        $usrname = $details[0]->usrname;
        $bp      = $this->input->post('binary_pos');

        $this->db->select("bi_id,bi_no");
        $this->db->from("binary_hdr");
        //$this->db->where("bi_userupline",$usrname);
        $this->db->where("bi_pos",$bp);
        $this->db->like("bi_no",$usrname);
        $this->db->order_by("bi_id","DESC");
        $this->db->limit("1");
        $query = $this->db->get();
        return $query->result();
    }

    //cari kaki wujud tak kiri dan kanan
    function getBinum_user_LR(){

        $details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
        $usrname = $details[0]->usrname;
        $bp      = $this->input->post('binary_pos');

        $this->db->select("bi_id,bi_no");
        $this->db->from("binary_hdr");
        //$this->db->where("bi_userupline",$usrname);
        $this->db->where("bi_pos",$bp);
        $this->db->where("bi_userupline",$usrname);
        $this->db->like("bi_no",$usrname);
        $this->db->order_by("bi_id","DESC");
        $this->db->limit("1");
        $query = $this->db->get();
        return $query->result();
    }

    //cari upline sebab tak wujud kiri atau kanan
    //get bi_no from binary_hdr depend on current user, right position on left grouping
    function getBinum_user_r1(){

        $details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
        $usrname = $details[0]->usrname;
        //$bp      = $this->input->post('binary_pos');

        $this->db->select("bi_id,bi_no");
        $this->db->from("binary_hdr");
        //$this->db->where("bi_userupline",$usrname);
        //$this->db->where("bi_pos",$bp);
        $this->db->like("bi_no",$usrname);
        $this->db->order_by("bi_id","ASC");
        $this->db->limit("1");
        $query = $this->db->get();
        return $query->result();
    }

    /*************  START EDIT PARTICULER DATA QUERY *************/
    public function edit_cycle($id){
        $query=$this->db->query("SELECT ud.*
                                 FROM cycle ud 
                                 WHERE ud.id_cycle = $id");
        return $query->result_array();
    }
    /*************  END EDIT PARTICULER DATA QUERY ***************/

//get percent of hibah..
    function getHibah(){

        $this->db->select("hibah_percent, update_by, update_date");
        $this->db->from("hibah");
        $query = $this->db->get();
        return $query->result();
    }

/*------------------
    function getDownline(){

        $details = $this->user_model->get_user_by_id($this->session->userdata('uid'));
        $uname = $details[0]->usrname;

        $this->db->where('introducer_name', $uname);
        $this->db->join('package','package_id = id_package');
        $this->db->from("user");
        $query = $this->db->get();
        return $query->result();
    }
---------------*/

//get data from user table--------
    function getMembers(){
        $details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
        $usrname = $details[0]->usrname;

        //$this->db->join('package','package_id = id_package');
        $this->db->where_not_in('usrname',$usrname);
        $this->db->order_by('usrname');
        $this->db->from("user");
        $query = $this->db->get();
        return $query->result();
    }
//end user table--------

    function getRate(){

        $this->db->select("rate");
        $this->db->from("euro_rate");
        $query = $this->db->get();
        return $query->result();
    }

    //get sum cash wallet of table cash_wallet_hdr
    function getCW($usr){

        $this->db->select_sum("ch_amount");
        $this->db->where('ch_user', $usr);
        $this->db->where('ch_jenis', 'CW');
        $this->db->from("cash_wallet_hdr");
        $query = $this->db->get();
        return $query->result();
    }

    //get sum register wallet of table reg_wallet_hdr
    function getRW($usr){

        $this->db->select_sum("reg_amount");
        $this->db->where('reg_user', $usr);
        $this->db->where('reg_jenis', 'RW');
        $this->db->from("reg_wallet_hdr");
        $query = $this->db->get();
        return $query->result();
    }

    //get sum product wallet of table product_wallet_hdr
    function getPW($usr){

        $this->db->select_sum("pd_amount");
        $this->db->where('pd_user', $usr);
        $this->db->where('pd_jenis', 'PW');
        $this->db->from("product_wallet_hdr");
        $query = $this->db->get();
        return $query->result();
    }

    //get sum ROI of table roi_hdr
    function getROI($usr){

        $this->db->select_sum("roi_amount");
        $this->db->where('roi_user', $usr);
        $this->db->where('roi_jenis', 'ROI');
        $this->db->from("roi_hdr");
        $query = $this->db->get();
        return $query->result();
    }

    //get sum SW of table sponsor_wallet_hdr
    function getSW($usr){

        $this->db->select_sum("sp_amount");
        $this->db->where('sp_user', $usr);
        $this->db->where('sp_jenis', 'SW');
        $this->db->from("sponsor_wallet_hdr");
        $query = $this->db->get();
        return $query->result();
    }

    //get sum BW of table binary_hdr_hst
    function getBW($usr){

        $this->db->select_sum("bi_amount");
        $this->db->where('bi_user', $usr);
        $this->db->where('bi_pos', 'L');
        $this->db->from("binary_hdr_hst");
        $query = $this->db->get();
        return $query->result();
    }
/*--
    //get sum BW of table bonus_wallet_hdr
    function getBW($usr){

        $this->db->select_sum("bns_amount");
        $this->db->where('bns_user', $usr);
        $this->db->where('bns_jenis', 'SW');
        $this->db->from("bonus_wallet_hdr");
        $query = $this->db->get();
        return $query->result();
    }
--*/
	function get_user($usrn, $pwd)
	{
		$this->db->where('usrname', $usrn);
		$this->db->where('password', md5($pwd));
        $query = $this->db->get('user');
		return $query->result();
	}

    //update password di profile
    function update_pass($data)
    {
        $details = $this->User_model->get_user_by_id($this->session->userdata('uid'));
        $uname = $details[0]->usrname;
        
        //$this->db->set($data);
        $this->db->where('usrname', $uname);
        $this->db->update('user',$data);
        //return $query->result();
    }

		// get user
	function get_user_by_id($id)
	{
		$this->db->where('id', $id);
        //$this->db->join('package','package_id = id_package');
        $this->db->join('role','role = role_id');
        $query = $this->db->get('user');
		return $query->result();
	}
	
	// insert
	function insert_user($data)
    {
		return $this->db->insert('user', $data);
	}

    // insert trx
    function insert_trx($data)
    {
        return $this->db->insert('transaksi', $data);
    }

    // insert roi_hdr
    function insert_roi_hdr($data)
    {
        return $this->db->insert('roi_hdr', $data);
    }

    // insert roi_dtl
    function insert_roi_dtl($data)
    {
        return $this->db->insert('roi_dtl', $data);
    }


    // insert binary_hdr
    function insert_binary_hdr($data)
    {
        return $this->db->insert('binary_hdr', $data);
    }


    // insert cash wallet
    function insert_cw($data)
    {
        return $this->db->insert('cash_wallet_hdr', $data);
    }

    // insert product wallet
    function insert_pw($data)
    {
        return $this->db->insert('product_wallet_hdr', $data);
    }

    // insert register wallet
    function insert_rw($data)
    {
        return $this->db->insert('reg_wallet_hdr', $data);
    }

    // insert sponsor wallet
    function insert_sw($data)
    {
        return $this->db->insert('sponsor_wallet_hdr', $data);
    }

    //check username------
    function checkusername($username)
    {
        $this -> db -> select('*');
        $this -> db -> from('user');
        $this -> db -> where('usrname', $username);
        $this -> db -> limit(1);

        $query = $this -> db -> get();

        if($query -> num_rows() == 1)
        {
            return $query->result();
        }
        else
        {
            return TRUE;
        }
    }
    // end check username------

	// untuk reset password
	public function insertUser($d)
    {  
            $string = array(
                'first_name'=>$d['firstname'],
                'last_name'=>$d['lastname'],
                'email'=>$d['email'],
                'role'=>$this->roles[0], 
                'status'=>$this->status[0]
            );
            $q = $this->db->insert_string('user',$string);             
            $this->db->query($q);
            return $this->db->insert_id();
    }

    // untuk reset password
    public function isDuplicate($email)
    {     
        $this->db->get_where('user', array('email' => $email), 1);
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;         
    }

    // untuk reset password
    public function insertToken($user_id)
    {   
        $token = substr(sha1(rand()), 0, 30); 
        $date = date('Y-m-d');
        
        $string = array(
                'token'=> $token,
                'user_id'=>$user_id,
                'created'=>$date
            );
        $query = $this->db->insert_string('tokens',$string);
        $this->db->query($query);
        return $token . $user_id;
        
    }

    // untuk reset password
    public function isTokenValid($token)
    {
       $tkn = substr($token,0,30);
       $uid = substr($token,30);      
       
        $q = $this->db->get_where('tokens', array(
            'tokens.token' => $tkn, 
            'tokens.user_id' => $uid), 1);                         
               
        if($this->db->affected_rows() > 0){
            $row = $q->row();             
            
            $created = $row->created;
            $createdTS = strtotime($created);
            $today = date('Y-m-d'); 
            $todayTS = strtotime($today);
            
            if($createdTS != $todayTS){
                return false;
            }
            
            $user_info = $this->getUserInfo($row->user_id);
            return $user_info;
            
        }else{
            return false;
        }
        
    }

    // untuk reset password
    public function getUserInfo($id)
    {
        $q = $this->db->get_where('user', array('id' => $id), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$id.')');
            return false;
        }
    }

    // untuk reset password
    public function updateUserInfo($post)
    {
        $data = array(
               'password' => $post['password'],
               'last_login' => date('Y-m-d h:i:s A'), 
               'status' => $this->status[1]
            );
        $this->db->where('id', $post['user_id']);
        $this->db->update('user', $data); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            error_log('Unable to updateUserInfo('.$post['user_id'].')');
            return false;
        }
        
        $user_info = $this->getUserInfo($post['user_id']); 
        return $user_info; 
    }

    // 
    public function checkLogin($post)
    {
        $this->load->library('password');       
        $this->db->select('*');
        $this->db->where('usrname',$post['usrnme']);
        $query = $this->db->get('user');
        $userInfo = $query->row();

        if(!$this->password->validate_password($post['password'], $userInfo->password)){
            error_log('Unsuccessful login attempt('.$post['usrnme'].')');
            return false; 
        }
        
        $this->updateLoginTime($userInfo->id);
        
        unset($userInfo->password);
        return $userInfo; 
    }

    // untuk reset password
    public function updateLoginTime($id)
    {
    	date_default_timezone_set("Asia/Kuala_Lumpur");
        $this->db->where('id', $id);
        $this->db->update('user', array('last_login' => date('Y-m-d h:i:s A')));
        return;
    }
    
    // untuk reset password
    public function getUserInfoByEmail($email)
    {
        $q = $this->db->get_where('user', array('email' => $email), 1);  
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$email.')');
            return false;
        }
    }

    // untuk reset password
    public function updatePassword($post)
    {   
        $this->db->where('id', $post['user_id']);
        $this->db->update('user', array('password' => $post['password'])); 
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            error_log('Unable to updatePassword('.$post['user_id'].')');
            return false;
        }        
        return true;
    }


}
