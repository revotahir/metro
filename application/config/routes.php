<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/


$route['login-data'] = 'welcome/LoginData';
$route['dashboard'] = 'welcome/AdminDashboard'; //admin Dashboard


// vendors route
$route['vendors'] = 'welcome/AdminVendors'; 
$route['add-vendor']= 'welcome/AddAdminVendors';
$route['all-vendor']= 'welcome/AllAdminVendors';
$route['deactivate-vendor/:any']= 'welcome/deactivateVendor';
$route['activate-vendor/:any']= 'welcome/activateVendor';
$route['delete-vendor/:any']= 'welcome/deleteVendor';
$route['edit-vendor/:any']= 'welcome/updateVendor';


// customers route
$route['customers'] = 'welcome/AdminCustomers'; 
$route['add-customer'] = 'welcome/AddAdminCustomers'; 
$route['all-customer'] = 'welcome/AllAdminCustomers'; 
$route['deactivate-customer/:any'] = 'welcome/deactivateCustomers'; 
$route['activate-customer/:any'] = 'welcome/activateCustomers'; 
$route['delete-customer/:any'] = 'welcome/deleteCustomers'; 
$route['edit-customer/:any'] = 'welcome/updateCustomers'; 

// category route
$route['category'] = 'welcome/AdminCategory';
$route['add-category'] = 'welcome/AddAdminCategory';
$route['delete-category/:any'] = 'welcome/deleteCategory';
$route['edit-category/:any'] = 'welcome/updateCategory';



// product route
$route['add-new-product'] = 'welcome/AddAdminProduct';





$route['logout'] = 'welcome/LogOut';
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;