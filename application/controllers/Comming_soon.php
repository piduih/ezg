<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comming_soon extends CI_Controller {
/*
	public function __construct()
	{
		parent::__construct();
		//$this->load->helper(array('url', 'html'));
		//$this->load->library('session');
	}
*/
	public function index()
	{
		$this->load->view('comming_soon_view');
	}
}
