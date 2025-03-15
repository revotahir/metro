<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->model('Generic_model', 'generic');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		$this->load->view('login');
	}
	public function LoginData() {
		$email=$this->input->post('email-address');
		$pass=$this->input->post('email-password');
		// get user 
		$user=$this->generic->GetData('users',array('userEmail'=>$email,'userPass'=>$pass,'userStatus'=>1));
		if($user){
			$this->session->set_userdata('loginData', $user[0]);
			if($user[0]['userType']==1){
				redirect(base_url('dashboard'));
			}else{
				redirect(base_url('customer-dashboard'));
			}
		}else{
			$this->session->set_flashdata('error', 1);
			redirect(base_url());
		}
	}

public function AdminDashboard(){
	if ($this->session->userdata('loginData')) {
		$this->load->view('dashboard-admin');
	}else{
		redirect(base_url());
	}
}

	public function LogOut()
	{
		$this->session->unset_userdata('loginData');
		redirect(base_url());
	}
}
