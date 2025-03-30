<?php
defined('BASEPATH') or exit('No direct script access allowed');

class customer extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper('file');
		$this->load->model('Generic_model', 'generic');
		$this->data['cartCount'] = $this->generic->GetCount('cart', 'cartID', array('customerID' => $this->session->userdata['loginData']['userID'], 'cartStatus' => 0));
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
	public function Dashboard()
	{
		$this->load->view('customer/dashboard-customer', $this->data);
	}

	public function OrderNow()
	{
		$this->data['cartProduct'] = $this->generic->GetProductsByCart(array('c.customerID' => $this->session->userdata['loginData']['userID'],'c.cartStatus'=>0));
		$this->data['products'] = $this->generic->GetAssignedProducts($this->session->userdata['loginData']['userID']);
		$this->load->view('customer/order-now', $this->data);
	}
	public function addToCartData()
	{
		//ajax output
		$output = '';
		//check if products is already added
		$checkcart = $this->generic->GetData('cart', array(
			'productID' => $this->input->post('productID'),
			'customerID' => $this->session->userdata['loginData']['userID'],
			'cartStatus' => 0
		));
		if ($checkcart) {
			//add quantity
			$newQuantity = $this->input->post('quantity') + $checkcart[0]['quantity'];
			$this->generic->Update('cart', array(
				'productID' => $this->input->post('productID'),
				'customerID' => $this->session->userdata['loginData']['userID'],
				'cartStatus' => 0
			), array('quantity' => $newQuantity));
			$output = $output . 'QtyUpdated//';
		} else {
			//get vendor ID 
			$productDetail = $this->generic->GetData('products', array('productID' => $this->input->post('productID')));
			//arrayFor cart
			$data = array(
				'customerID' => $this->session->userdata['loginData']['userID'],
				'vendorID' => $productDetail[0]['userID'],
				'productID' => $this->input->post('productID'),
				'quantity' => $this->input->post('quantity'),
				'price' => $this->input->post('price')
			);
			$this->generic->InsertData('cart', $data);
			$output = $output . 'AddedNew//';
		}
		//get all product for sumary
		$cartProduct = $this->generic->GetProductsByCart(array('c.customerID' => $this->session->userdata['loginData']['userID'],'c.cartStatus'=>0));
		if ($cartProduct) {
			$totalAmount = 0;
			$li = '';
			foreach ($cartProduct as $row) {
				$li = $li . '  <li class="list-group-item" id="cartItems_' . $row['cartID'] . '" style="justify-content: start !important;display:flex;
  gap: 20px;">
				<div>
                                                    <a href="javascript:void(0);" onclick="deleteCart(' . $row['cartID'] . ')"><i class="far fa-window-close" style="color: red;"></i></a>
                                                </div>
                                                    <div>
                                                        <h6 class="my-0">' . $row['productName'] . '</h6>
                                                        <small class="text-muted" >' . $row['productDesp'] . '</small>
                                                    </div>
                                                    <span class="text-muted" style="margin-left: auto;">$' . $row['price'] . ' X ' . $row['quantity'] . '</span>
                                                </li>';
				$totalAmount = $totalAmount + ($row['price'] * $row['quantity']);
			}
		}
		$li = $li . ' <li class="list-group-item d-flex justify-content-between">
                                                    <span>Total (USD)</span>
                                                    <strong id="totalAmount">$' . $totalAmount . '</strong>
                                                </li>';
		$TotalProduct = $this->generic->GetCount('cart', 'cartID', array('customerID' => $this->session->userdata['loginData']['userID'], 'cartStatus' => 0));

		$output = $output . $li . '//' . $TotalProduct[0]['result'];
		echo $output;
	}
	public function DeletCartItem()
	{
		//delet from cart
		$this->generic->Delete('cart', array('cartID' => $this->input->post('cartid')));
		$cartProduct = $this->generic->GetProductsByCart(array('c.customerID' => $this->session->userdata['loginData']['userID'],'c.cartStatus'=>0));
		if ($cartProduct) {
			$totalproducts = 0;
			$totalAmount = 0;
			foreach ($cartProduct as $row) {
				$totalAmount = $totalAmount + ($row['price'] * $row['quantity']);
				$totalproducts++;
			}
		} else {
			$totalAmount = 'empty';
			$totalproducts = 'empty';
		}
		echo 'done//' . $totalAmount . '//' . $totalproducts;
	}
	public function cart()
	{
		$this->data['cartProducts'] = $this->generic->GetProductsByCart(array('c.customerID' => $this->session->userdata['loginData']['userID'],'c.cartStatus'=>0));
		$this->load->view('customer/cart', $this->data);
	}
	public function UpdateQuanityFromCart()
	{
		$this->generic->Update('cart', array('cartID' => $this->input->post('cartid')), array('quantity' => $this->input->post('quantity')));
		$cartProduct = $this->generic->GetProductsByCart(array('c.customerID' => $this->session->userdata['loginData']['userID']));
		if ($cartProduct) {
			$totalAmount = 0;
			foreach ($cartProduct as $row) {
				$totalAmount = $totalAmount + ($row['price'] * $row['quantity']);
			}
		} else {
			$totalAmount = 'empty';
		}
		echo 'done//' . $totalAmount;
	}
	public function CheckOut(){
		$this->data['cartProduct'] = $this->generic->GetProductsByCart(array('c.customerID' => $this->session->userdata['loginData']['userID'],'c.cartStatus'=>0));
		$this->load->view('customer/checkout',$this->data);
	}
	public function CheckOutData(){
		//calculate toal bill
		$cartProducts = $this->generic->GetProductsByCart(array('c.customerID' => $this->session->userdata['loginData']['userID'],'c.cartStatus'=>0));
		if ($cartProducts) {
			$totalAmount = 0;
			foreach ($cartProducts as $row) {
				$totalAmount += $row['price'] * $row['quantity'];
			}
		}
		$data=array(
			'address'=>$this->input->post('address'),
			'address2'=>$this->input->post('address2'),
			'country'=>$this->input->post('country'),
			'state'=>$this->input->post('state'),
			'zip'=>$this->input->post('zip'),
			'addType'=>$this->input->post('addType'),
			'totalBill'=>$totalAmount,
			'addQuestions'=>$this->input->post('addQuestion'),
			
		);
		$this->generic->InsertData('checkout',$data);
		//get max id
		$checkoutid=$this->generic->GetMaxID('checkout','checkoutID');
		//updatecat
		$this->generic->Update('cart',array('customerID' => $this->session->userdata['loginData']['userID'],'cartStatus'=>0),array('checKoutID'=>$checkoutid[0]['result'],'cartStatus'=>1));
		$this->session->set_flashdata('checkoutDone', 1);
		redirect(base_url('order-now'));
	}
}
