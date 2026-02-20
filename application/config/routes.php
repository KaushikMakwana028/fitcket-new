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

$route['default_controller'] = 'home';

$route['admin'] = 'admin/login';
// $route['dashboard_admin'] = 'admin/dashboard';

// admin routes
$route['category'] = 'admin/category';
$route['add_category'] = 'admin/category/add_category';
$route['sub_category'] = 'admin/category/sub_category';
$route['add_sub_category'] = 'admin/category/add_sub_category';
$route['edit/(:num)'] = 'admin/category/edit/$1';
$route['edit_main/(:num)'] = 'admin/category/edit_main/$1';
$route['slider'] = 'admin/category/slider';
$route['add_slider'] = 'admin/category/add_slider';
$route['ads_banner'] = 'admin/category/ads_banner';
$route['add_ads_banner'] = 'admin/category/add_ads_banner';
$route['settlement'] = 'admin/settlement';
$route['settlement_history'] = 'admin/settlement/settlement_history';
$route['city'] = 'admin/category/city';
$route['add_city'] = 'admin/category/add_city';
$route['edit_city/(:num)'] = 'admin/category/edit_city/$1';
$route['partner'] = 'admin/partner';
$route['loginAsPartner/(:num)'] = 'admin/partner/loginAsPartner/$1';
$route['customers'] = 'admin/customers';
$route['bookings'] = 'admin/booking';
$route['about_us'] = 'admin/page';
$route['contact_us'] = 'admin/page/contact_us';
$route['privacy_policy'] = 'admin/page/privacy_policy';
$route['refund_policy'] = 'admin/page/refund_policy';
$route['terms_condition'] = 'admin/page/terms_condition';
$route['inquries'] = 'admin/page/inquries';
$route['pay_out/(:num)'] = 'admin/pay_out/index/$1';
$route['payment_setting'] = 'admin/payment/payment_setting';
$route['offer'] = 'admin/dashboard/offer';

//provider route
$route['wallet'] = 'provider/wallet';
$route['scheduled'] = 'provider/wallet/scheduled';
$route['provider'] = 'provider/login';
$route['provider/sign_up'] = 'provider/login';

$route['provider/sing_up'] = 'provider/login/sing_up';
$route['send_register_otp'] = 'provider/login/send_register_otp';
$route['service'] = 'provider/service';
$route['offers'] = 'provider/service/offer';
$route['add_service'] = 'provider/service/add_service';
$route['edit_service/(:num)'] = 'provider/service/edit_service/$1';
$route['provider/logout'] = 'provider/login/logout';
$route['customer'] = 'provider/customers';
$route['booking'] = 'provider/customers/booking';
$route['bank_details'] = 'provider/profile/bank_details';
$route['image'] = 'provider/profile/image';
$route['add_image'] = 'provider/profile/add_image';
$route['certification'] = 'provider/profile/certification';


// provider api
$route['provider/register'] = 'provider/api/register_user';
$route['provider/register_verify_otp'] = 'provider/api/register_verify_otp';
$route['provider/login'] = 'provider/api/login_send_otp';
$route['provider/login_verify_otp'] = 'provider/api/login_verify_otp';
$route['provider/logout/api'] = 'provider/api/logout';
$route['provider/dashboard/api'] = 'provider/api/dashboard';
$route['provider/service/api'] = 'provider/api/service';
$route['provider/add_service/api'] = 'provider/api/add_service';
$route['provider/get_service/(:num)/api'] = 'provider/api/get_service/$1';
$route['provider/update_service/api'] = 'provider/api/update_service';
$route['provider/toggel_service/api'] = 'provider/api/toggel_service';
$route['provider/customer/api'] = 'provider/api/customer';
$route['provider/booking/api'] = 'provider/api/booking';
$route['provider/scheduled/api'] = 'provider/api/scheduled';
$route['provider/add_scheduled/api'] = 'provider/api/add_scheduled';
$route['provider/bank_details/api'] = 'provider/api/bank_details';
$route['provider/save_bank_details/api'] = 'provider/api/save_bank_details';
$route['provider/get_offers/api'] = 'provider/api/get_offers';
$route['provider/save_offers/api'] = 'provider/api/save_offers';
$route['provider/api/service_search/search'] = 'provider/api/service_search';
$route['provider/api/customer_search/search'] = 'provider/api/customer_search';
$route['provider/api/booking_search/search'] = 'provider/api/booking_search';
$route['provider/get_profile/api'] = 'provider/api/get_profile';
$route['provider/save_profile/api'] = 'provider/api/save_profile';
$route['provider/wallet/api'] = 'provider/api/wallet';
$route['provider/withdraw_request/api'] = 'provider/api/withdraw_request';
$route['provider/add_gallery_image/api'] = 'provider/api/add_gallery_image';
$route['provider/fetch_gallery/api'] = 'provider/api/fetch_gallery';
$route['provider/delete_image/(:num)'] = 'provider/api/delete_image/$1';
$route['provider/delete_account'] = 'provider/api/delete_account';
$route['provider/add_certificate_image/api'] = 'provider/api/add_certificate_image';
$route['provider/fetch_certificate/api'] = 'provider/api/fetch_certifications';
$route['api/delete_certificate/(:num)'] = 'provider/api/delete_certificate/$1';
$route['provider/save_certificate/api'] = 'provider/api/save_certificate';
$route['provider/fetch_sessions/api'] = 'provider/api/fetch_sessions';
$route['provider/fetch_session_one/api/(:num)'] = 'provider/api/fetch_session_one/$1';
$route['provider/save_session/api'] = 'provider/api/save_session';
$route['provider/delete_session/api/(:num)'] = 'provider/api/delete_session/$1';
$route['provider/start_session/api/(:num)'] = 'provider/api/start_session_api/$1';
$route['provider/end_session/api/(:num)'] = 'provider/api/end_session_api/$1';
$route['provider/session_details/api/(:num)'] = 'provider/api/session_details_api/$1';
$route['provider/notifications_get/api'] = 'provider/api/notifications_get';
$route['provider/notification-read/(:num)'] = 'provider/api/notification_read/$1';
$route['provider/notification-delete/(:num)'] = 'provider/api/notification_delete/$1';
$route['provider/notification-delete-all']    = 'provider/api/notification_delete_all';
$route['provider/delete_notification'] = 'provider/dashboard/delete_notification';


















// User Route
$route['providers'] = 'profile';
$route['provider_details/(:num)'] = 'profile/provider_details/$1';
$route['services'] = 'services';
$route['login'] = 'login';
$route['logout'] = 'login/logout';
$route['about-us'] = 'page';
$route['contact-us'] = 'page/contact_us';
$route['terms-condition'] = 'page/terms_condition';
$route['privacy-policy'] = 'page/privacy_policy';
$route['refund-policy'] = 'page/refund_policy';
$route['delete-account'] = 'page/delete_account';

$route['edit_user/(:num)'] = 'profile/edit_user/$1';
$route['manage_bank_account/(:num)'] = 'profile/manage_bank_account/$1';
$route['bookings/(:num)'] = 'profile/bookings/$1';
$route['pay_to_gym'] = 'rent_payment';
$route['pay_any_gym'] = 'rent_payment/pay';
// $route['session'] = 'session_booking';

$route['rent_payment/details'] = 'rent_payment/details';

// User Api route
$route['user/register'] = 'api/register_user';
$route['user/register_verify_otp'] = 'api/register_verify_otp';
$route['user/login'] = 'api/login_send_otp';
$route['user/login_verify_otp'] = 'api/login_verify_otp';
$route['user/logout'] = 'api/logout';
$route['user/home'] = 'api/home';
$route['user/service'] = 'api/fetch_services';
$route['user/search_service'] = 'api/search_service';
$route['user/provider'] = 'api/fetch_providers';
$route['user/search_providers'] = 'api/search_providers';
$route['user/provider_details/(:num)'] = 'api/provider_details/$1';
$route['user/profile'] = 'api/profile';
$route['user/edit_profile'] = 'api/edit_profile';
$route['user/update_profile'] = 'api/update_profile';
$route['user/bank_accounts']['GET'] = 'api/bank_accounts';
$route['user/bank_account']['POST'] = 'api/save_bank_account';
$route['user/bookings']['GET'] = 'api/bookings';
$route['user/bank_account/(:num)']['DELETE'] = 'api/delete_bank_account/$1';
$route['user/get_recipients'] = 'api/get_recipients';
$route['user/remove_recipients/(:num)'] = 'api/remove_recipients/$1';
$route['user/transection_details/(:num)'] = 'api/transection_details/$1';
$route['user/pay_any_gym'] = 'api/pay_any_gym';
$route['user/get_transactions'] = 'api/get_transactions';
$route['user/pay_any_gym'] = 'api/pay_api';
$route['user/payment_verification'] = 'api/payment_verification';
$route['user/add_to_cart'] = 'api/add_to_cart';
$route['user/get_cart_items'] = 'api/get_cart_items';
$route['user/update_cart_quantity'] = 'api/update_cart_quantity';
$route['user/remove_cart_item'] = 'api/remove_cart_item';
$route['user/pay_booking'] = 'api/pay_booking';
$route['user/callback_booking'] = 'api/callback_booking';
$route['user/privacy_policy'] = 'api/api_privacy_policy';
$route['user/refund_policy'] = 'api/api_refund_policy';
$route['user/terms_condition'] = 'api/api_terms_condition';
$route['user/submit_query'] = 'api/api_submit_query';
$route['user/delete_account'] = 'api/delete_account';
$route['user/submit_review'] = 'api/submit_review';

$route['user/fetch_sessions'] = 'api/fetch_sessions';
$route['user/session_pay'] = 'api/session_pay';
$route['user/session_payment_callback'] = 'api/session_payment_callback';

$route['user/my_sessions'] = 'api/my_booked_sessions';
$route['user/join_session/(:num)']  = 'api/join_session/$1';
$route['user/leave_session/(:num)'] = 'api/leave_session/$1';
$route['user/get_review/(:num)'] = 'api/get_review/$1';
$route['user/save_review'] = 'api/save_review';
$route['user/notifications']                   = 'api/user_notifications_get';
$route['user/notification/read/(:num)']        = 'api/user_notification_read/$1';
$route['user/notification/delete/(:num)']      = 'api/user_notification_delete/$1';
$route['user/notifications/delete-all']        = 'api/user_notification_delete_all';























$route['sign_in'] = 'login/sign_in';
$route['cart'] = 'cart';
$route['profile'] = 'profile/profile';
// $route['contact'] = 'home/contact';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;