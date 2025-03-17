<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends MY_Controller 
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
	// <!-- ============================================================== -->
    // <!-- Login function -->
    // <!-- ============================================================== -->
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

	// <!-- ============================================================== -->
    // <!-- redirect to dashboard -->
    // <!-- ============================================================== -->

	// redirect to page with check
	public function AdminDashboard(){
		if ($this->session->userdata('loginData')) {
			$this->load->view('dashboard-admin');
		}else{
			redirect(base_url());
		}
	}


	// <!-- ============================================================== -->
    // <!-- vendor redirect and insert function -->
    // <!-- ============================================================== -->

	// redirect to page with check
	public function AdminVendors(){
		if($this->session->userData('loginData')){
			$this->load->view('add-vendors');
		}else{
			redirect(base_url());
		}
	}
	// add vendor
	public function AddAdminVendors(){
		$userName = $this->input->post('user-name');
		$userEmail = $this->input->post('user-email');
		$userPhone = $this->input->post('user-phone');
		$userPassword = $this->input->post('user-password');

		$this->db->where('userEmail' , $userEmail);
		$query = $this->db->get('users');
		if($query->num_rows()>0){
			$this->session->set_flashdata('alreadyRegistered', 1);
			redirect(base_url('vendors'));
		}
		else{
			$VendorUserData = array(
				'userName'=> $userName,
				'userEmail'=> $userEmail,
				'userPhone'=> $userPhone,
				'userPass'=> $userPassword,
				'userType'=> 3,
			);
			$this->generic->InsertData('users' , $VendorUserData);
			$this->session->set_flashdata('successfullyRegistered', 1);
			redirect(base_url('vendors'));
		}
	}
	// show vendor data
	public function AllAdminVendors(){
		if($this->session->userData('loginData'))
		{
			$this->data['vendorsList'] = $this->generic->GetData('users' , array('userType'=>3));
			$this->load->view('vendors-data', $this->data);
		}else{
			redirect(base_url());
		}
	}
	// deactive vendor 
	public function deactivateVendor(){
		$this->generic->Update('users',array('userID'=>$this->uri->segment(2)) , array('userStatus'=>0));
		$this->session->set_flashdata('vendorDeactivated', 1);
		redirect(base_url('all-vendor'));
	}
	// active vendor
	public function activateVendor(){
		$this->generic->Update('users', array('userID'=>$this->uri->segment(2)) , array('userStatus'=>1));
		$this->session->set_flashdata('vendorActivated', 1);
		redirect(base_url('all-vendor'));
	}
	// delete vendor
	public function deleteVendor(){
		$this->generic->Delete('users', array('userID'=>$this->uri->segment(2)));
		$this->session->set_flashdata('vendorDeleted' , 1);
		redirect(base_url('all-vendor'));
	}
	// update vendor
	public function updateVendor(){
		$this->load->view('update-vendor');
	}

	// <!-- ============================================================== -->
    // <!-- customer redirect and insert function -->
    // <!-- ============================================================== -->

	// redirect to page with check
	public function AdminCustomers(){
		if($this->session->userData('loginData')){
			$this->load->view('add-customers');
		}else{
			redirect(base_url());
		}
	}
	
	// add customer
	public function AddAdminCustomers(){
		$userName = $this->input->post('cstm-user-name');
		$userEmail = $this->input->post('cstm-user-email');
		$userPhone = $this->input->post('cstm-user-phone');
		$userPassword = $this->input->post('cstm-user-password');

		$this->db->where('userEmail' , $userEmail);
		$query = $this->db->get('users');
		if($query->num_rows()>0){
			$this->session->set_flashdata('alreadyRegistered', 1);
			redirect(base_url('customers'));
		}
		else{
		$customerUserData = array(
			'userName'=> $userName,
			'userEmail'=> $userEmail,
			'userPhone'=> $userPhone,
			'userPass'=> $userPassword,
			'userType'=> 2,
		);
		$this->generic->InsertData('users' , $customerUserData);
		$this->session->set_flashdata('successfullyRegistered', 1);
		redirect('customers');
		}
	}
	// show customer data
	public function AllAdminCustomers(){
		if($this->session->userData('loginData')){
			$this->data['customersList'] = $this->generic->GetData('users' , array('userType'=>2));
			$this->load->view('customers-data', $this->data);
		}else{
			redirect(base_url());
		}
	}
	// deactive customer
	public function deactivateCustomers(){
		$this->generic->Update('users', array('userID'=>$this->uri->segment(2)) , array('userStatus' =>0));
		$this->session->set_flashdata('customerDeactivated', 1);
		redirect(base_url('all-customer'));
	}
	// active customer
	public function activateCustomers(){
		$this->generic->Update('users' , array('userID'=>$this->uri->segment(2)) , array('userStatus'=>1));
		$this->session->set_flashdata('customerActivated', 1);
		redirect(base_url('all-customer'));
	}
	// delete customer
	public function deleteCustomers()
	{
		$this->generic->Delete('users' , array('userID'=>$this->uri->segment(2)));
		$this->session->set_flashdata('customerDeleted' , 1);
		redirect(base_url('all-customer'));
	}
	// update customer
	public function updateCustomers(){
		$this->load->view('update-vendor');
	}



	// <!-- ============================================================== -->
    // <!-- logout function -->
    // <!-- ============================================================== -->
	public function LogOut()
	{
		$this->session->unset_userdata('loginData');
		redirect(base_url());
	}
}