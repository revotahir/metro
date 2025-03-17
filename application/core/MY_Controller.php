<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
           // List of controllers/methods to exclude from the session check
           $excluded_pages = array(
            'welcome', // Exclude the default Welcome controller (base URL)
            'welcome/LoginData', // Exclude the login page
        );
         // Get the current controller and method
         $current_controller = $this->router->fetch_class();
         $current_method = $this->router->fetch_method();
         $current_page = $current_controller . '/' . $current_method;
         // Check if the current request is for the base URL
         $is_base_url = ($this->uri->uri_string() === '');
        if(!$is_base_url){
        // Check if the user is logged in
        if (!in_array($current_page, $excluded_pages) && !$this->session->userdata('loginData')) {
            redirect(base_url()); // Redirect to the login page or home page
        }
    }
    }
}