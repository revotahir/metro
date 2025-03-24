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
		$this->load->view('customer/dashboard-customer');
	}

	public function OrderNow()
	{
		$this->data['cartProduct'] = $this->generic->GetProductsByCart(array('c.customerID' => $this->session->userdata['loginData']['userID']));
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
		$cartProduct = $this->generic->GetProductsByCart(array('c.customerID' => $this->session->userdata['loginData']['userID']));
		if ($cartProduct) {
			$totalAmount = 0;
			$li = '';
			foreach ($cartProduct as $row) {
				$li = $li . ' <li class="list-group-item d-flex justify-content-between">
                                                    <div>
                                                        <h6 class="my-0">' . $row['productName'] . '</h6>
                                                        <small class="text-muted">' . $row['productDesp'] . '</small>
                                                    </div>
                                                    <span class="text-muted">$' . $row['price'] . ' X '.$row['quantity'].'</span>
                                                </li>';
				$totalAmount = $totalAmount + ($row['price']*$row['quantity']);
				
			}
		}
		$li=$li.' <li class="list-group-item d-flex justify-content-between">
                                                    <span>Total (USD)</span>
                                                    <strong id="totalAmount">$'.$totalAmount.'</strong>
                                                </li>';
												$TotalProduct = $this->generic->GetCount('cart', 'cartID', array('customerID' => $this->session->userdata['loginData']['userID'], 'cartStatus' => 0));

		$output=$output.$li.'//'.$TotalProduct[0]['result'];
		echo $output;
	}
}
