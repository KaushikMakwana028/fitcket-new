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
$route['default_controller'] = 'login';
// $route['admin'] = 'admin/login';
// $route['dashboard'] = 'dashboard';
$route['add_driver'] = 'driver/add_driver';
$route['company'] = 'driver/company';
$route['add_company'] = 'driver/add_company';
$route['driver'] = 'driver';
$route['booking'] = 'driver/booking';
$route['driver/edit/(:num)'] = 'driver/edit/$1';
$route['driver/view/(:num)'] = 'driver/view/$1';
$route['company/edit/(:num)'] = 'driver/edit_company/$1';
$route['trip_details/(:num)'] = 'driver/trip_details/$1';
$route['driver_trip_details/(:num)'] = 'driver/driver_trip_details/$1';
$route['fuel/(:num)'] = 'profile/fuel/$1';




// Api Route
$route['api/login'] = 'api/login';
$route['api/logout'] = 'api/logout';
$route['api/register'] = 'api/register';
$route['api/get_company'] = 'api/get_company';
$route['api/create_trip'] = 'api/create_trip';
$route['api/update_trip'] = 'api/update_trip';
$route['api/verify_otp'] = 'api/verify_otp';
$route['api/get_profile'] = 'api/get_profile';
$route['api/update_profile'] = 'api/update_profile';
$route['api/dashboard'] = 'api/dashboard';
$route['api/all_trip'] = 'api/all_trip';
$route['api/all_trip_dummy'] = 'api/all_trip_dummy';

$route['api/get_singal_trip/(:num)']['GET'] = 'api/get_singal_trip/$1';






































$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
