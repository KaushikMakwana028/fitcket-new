<?php
// user api file 
defined('BASEPATH') or exit('No direct script access allowed');

use \Firebase\JWT\JWT;

use \Firebase\JWT\Key;
use Razorpay\Api\Api as RazorpayApi;

require_once FCPATH . 'vendor/autoload.php';


class Api extends CI_Controller
{

    private $jwt_secret = 'b7c1f3e9a2d64c58f19a8e73d0bcb52f8edc6b31a9f71e48d9a7e2f3c1a5b8e9';
    private $razorpay_key_id;
    private $razorpay_key_secret;
    private $api;

    public function __construct()
    {

        parent::__construct();
        $this->razorpay_key_id = 'rzp_live_RCge2Oz6kUJE74';
        $this->razorpay_key_secret = 'Pw0gRqzQkzjl5pYW10pXXZeq';
        $this->api = new RazorpayApi($this->razorpay_key_id, $this->razorpay_key_secret);

        $this->load->model('general_model');
        $this->load->model('Live_session_model');

        $this->load->library(['session']);

        $this->load->helper(['url', 'form']);


        header("Access-Control-Allow-Origin: *");

        header("Content-Type: application/json; charset=UTF-8");
        $this->load->library('email');
        $this->load->library(['form_validation']);
        $this->load->library('Firebase_messaging');
    }

    public function register_user()
    {
        header('Content-Type: application/json');

        $input_data = json_decode($this->input->raw_input_stream, true);

        if (empty($input_data)) {
            return $this->output->set_status_header(400)->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid request payload.',
                'data' => null
            ]));
        }

        $first_name = trim($input_data['first_name'] ?? '');
        $last_name  = trim($input_data['last_name'] ?? '');
        $email      = trim($input_data['email'] ?? '');
        $mobile     = trim($input_data['mobile'] ?? '');

        if (!$first_name || !$last_name || !$email || !$mobile) {
            return $this->output->set_status_header(400)->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'All fields are required.',
                'data' => null
            ]));
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->output->set_status_header(400)->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid email address.',
                'data' => null
            ]));
        }

        $exists = $this->db->get_where('users', ['mobile' => $mobile])->row();
        if ($exists) {
            return $this->output->set_status_header(400)->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'This mobile number is already registered.',
                'data' => null
            ]));
        }

        $otp = OTP_FIXED_MODE ? '123456' : rand(100000, 999999);

        // remove old OTPs
        $this->db->where('mobile', $mobile)->delete('user_register_otps');

        $this->db->insert('user_register_otps', [
            'mobile'     => $mobile,
            'otp'        => $otp,
            'form_data'  => json_encode([
                'firstname' => $first_name,
                'lastname' => $last_name,
                'email'    => $email
            ]),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+5 minutes'))
        ]);

        if (!OTP_FIXED_MODE) {
            $this->send_otp_via_sms($mobile, $otp);
        }

        return $this->output->set_status_header(200)->set_output(json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'OTP sent successfully.',
            'data' => [
                'masked_mobile' => '*******' . substr($mobile, -4)
            ]
        ]));
    }

    public function register_verify_otp()
    {
        header('Content-Type: application/json');

        $input_data = json_decode($this->input->raw_input_stream, true);

        if (empty($input_data)) {
            return $this->output->set_status_header(400)->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid request payload.',
                'data' => null
            ]));
        }

        $mobile      = trim($input_data['mobile'] ?? '');
        $entered_otp = trim($input_data['otp'] ?? '');
        $expo_token  = $input_data['fcm_token'] ?? null;
        $device_type = $input_data['device_type'] ?? 'android';
        $app_version = $input_data['app_version'] ?? null;

        if (!$mobile || !$entered_otp) {
            return $this->output->set_status_header(400)->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Mobile & OTP required.',
                'data' => null
            ]));
        }

        $otp_row = $this->db
            ->where('mobile', $mobile)
            ->where('otp', $entered_otp)
            ->where('expires_at >=', date('Y-m-d H:i:s'))
            ->get('user_register_otps')
            ->row();

        if (!$otp_row) {
            return $this->output->set_status_header(400)->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid or expired OTP.',
                'data' => null
            ]));
        }

        $form_data = json_decode($otp_row->form_data, true);

        $this->db->insert('users', [
            'name'         => $form_data['firstname'] . ' ' . $form_data['lastname'],
            'mobile'       => $mobile,
            'email'        => $form_data['email'],
            'role'         => 0,
            'isActive'     => 1,
            'otp_verified' => 1,
            'created_at'   => date('Y-m-d H:i:s')
        ]);

        $user_id = $this->db->insert_id();
        $user    = $this->db->get_where('users', ['id' => $user_id])->row();

        if ($expo_token) {
            $this->save_user_expo_token(
                $user_id,
                $expo_token,
                $device_type,
                $app_version
            );
        }

        $token = $this->generate_jwt($user);

        // cleanup OTP
        $this->db->where('id', $otp_row->id)->delete('user_register_otps');

        return $this->output->set_status_header(200)->set_output(json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'User registered successfully.',
            'token' => $token,
            'data' => [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'is_logged_in' => true
            ]
        ]));
    }



    // public function login_send_otp()
    // {
    //     $input_data = json_decode($this->input->raw_input_stream, true);
    //     if (!empty($input_data)) {
    //         $_POST = $input_data;
    //     }

    //     $mobile = trim($this->input->post('mobile'));

    //     if (empty($mobile) || !is_numeric($mobile) || strlen($mobile) != 10) {
    //         echo json_encode([
    //             'code' => 400,
    //             'status' => false,
    //             'message' => 'Please enter a valid 10-digit mobile number.'
    //         ]);
    //         return;
    //     }

    //     // Check if user exists
    //     $user = $this->general_model->getOne('users', ['mobile' => $mobile]);
    //     if (!$user) {
    //         echo json_encode([
    //             'code' => 400,
    //             'status' => false,
    //             'message' => 'User not found. Please register first.'
    //         ]);
    //         return;
    //     }

    //     if ($user->role == 1) {
    //         echo json_encode([
    //             'code' => 400,
    //             'status' => false,
    //             'message' => 'Invalid mobile number.'
    //         ]);
    //         return;
    //     }

    //     $otp = rand(100000, 999999);
    //     $this->session->set_userdata('login_otp', $otp);
    //     $this->session->set_userdata('login_mobile', $mobile);

    //     $sms_sent = $this->send_otp_via_sms($mobile, $otp);

    //     if (!$sms_sent) {
    //         echo json_encode([
    //             'code' => 400,
    //             'status' => false,
    //             'message' => 'Failed to send OTP. Please try again.'
    //         ]);
    //         return;
    //     }

    //     $masked_mobile = '*******' . substr($mobile, -4);

    //     echo json_encode([
    //         'code' => 200,
    //         'status' => true,
    //         'message' => 'OTP sent successfully.',
    //         'mobile' => $mobile,
    //         'masked_mobile' => $masked_mobile
    //     ]);
    // }

    // public function login_verify_otp()
    // {
    //     // Decode JSON input
    //     $input_data = json_decode($this->input->raw_input_stream, true);
    //     if (!empty($input_data)) {
    //         $_POST = $input_data;
    //     }

    //     $entered_otp = trim($this->input->post('otp'));
    //     $session_otp = $this->session->userdata('login_otp');
    //     $mobile = $this->session->userdata('login_mobile');

    //     if (empty($mobile) || empty($session_otp)) {
    //         echo json_encode([
    //             'code' => 400,
    //             'status' => false,
    //             'message' => 'Session expired. Please resend OTP.'
    //         ]);
    //         return;
    //     }

    //     if ($entered_otp != $session_otp) {
    //         echo json_encode([
    //             'code' => 400,
    //             'status' => false,
    //             'message' => 'Invalid OTP.'
    //         ]);
    //         return;
    //     }

    //     // Fetch user data
    //     $user = $this->db->get_where('users', ['mobile' => $mobile])->row();

    //     if (!$user) {
    //         echo json_encode([
    //             'code' => 400,
    //             'status' => false,
    //             'message' => 'User not found.'
    //         ]);
    //         return;
    //     }

    //     if (!in_array($user->role, [0, 2])) {
    //         echo json_encode([
    //             'code' => 400,
    //             'status' => false,
    //             'message' => 'Invalid credentials.'
    //         ]);
    //         return;
    //     }

    //     $provider = $this->db->select('profile_image')
    //         ->where('provider_id', $user->id)
    //         ->get('provider')
    //         ->row();

    //     $user->profile_image = $provider ? $provider->profile_image : null;

    //     $token = $this->generate_jwt($user);

    //     $this->session->unset_userdata('login_otp');
    //     $this->session->unset_userdata('login_mobile');

    //     echo json_encode([
    //         'code' => 200,
    //         'status' => true,
    //         'message' => 'Login successful.',
    //         'token' => $token,
    //         'user' => $user
    //     ]);
    // }

    public function login_send_otp()
    {
        $input_data = json_decode($this->input->raw_input_stream, true);
        if (!empty($input_data)) $_POST = $input_data;

        $mobile = trim($this->input->post('mobile'));

        // Validate mobile
        if (!$mobile || !is_numeric($mobile) || strlen($mobile) != 10) {
            echo json_encode([
                'code'   => 400,
                'status' => false,
                'message' => 'Please enter a valid 10-digit mobile number.'
            ]);
            return;
        }

        // Check user exists
        $user = $this->db->get_where('users', ['mobile' => $mobile])->row();
        if (!$user || $user->role == 1) {
            echo json_encode([
                'code'   => 400,
                'status' => false,
                'message' => 'Invalid mobile number.'
            ]);
            return;
        }

        // ✅ ALWAYS random OTP (Live mode)
        $otp = rand(100000, 999999);

        // Clear old OTPs
        $this->db->where('mobile', $mobile)->delete('user_login_otps');

        // Insert new OTP
        $this->db->insert('user_login_otps', [
            'mobile'     => $mobile,
            'otp'        => $otp,
            'expires_at' => date('Y-m-d H:i:s', strtotime('+5 minutes'))
        ]);

        // ✅ ALWAYS send SMS
        $this->send_otp_via_sms($mobile, $otp);

        echo json_encode([
            'code'           => 200,
            'status'         => true,
            'message'        => 'OTP sent successfully.',
            'masked_mobile' => '*******' . substr($mobile, -4)
        ]);
    }


    public function login_verify_otp()
    {
        $input_data = json_decode($this->input->raw_input_stream, true);
        if (!empty($input_data)) $_POST = $input_data;

        $mobile      = trim($this->input->post('mobile'));
        $entered_otp = trim($this->input->post('otp'));
        $expo_token  = $this->input->post('fcm_token');
        $device_type = $this->input->post('device_type') ?? 'android';
        $app_version = $this->input->post('app_version') ?? null;

        if (!$mobile || !$entered_otp) {
            echo json_encode([
                'code' => 400,
                'status' => false,
                'message' => 'Mobile & OTP required.'
            ]);
            return;
        }

        // Verify OTP
        $mobile = preg_replace('/[^0-9]/', '', $mobile);
        $mobile = substr($mobile, -10);

        $entered_otp = trim($entered_otp);

        $otp_row = $this->db
            ->where('mobile', $mobile)
            ->where('otp', $entered_otp)
            ->where('expires_at >=', date('Y-m-d H:i:s'))
            ->order_by('id', 'DESC')
            ->get('user_login_otps')
            ->row();

        if (!$otp_row) {
            echo json_encode([
                'code' => 400,
                'status' => false,
                'message' => 'Invalid or expired OTP.'
            ]);
            return;
        }

        // Get user
        $user = $this->db->get_where('users', ['mobile' => $mobile])->row();

        if (!$user || !in_array($user->role, [0, 2])) {
            echo json_encode([
                'code' => 400,
                'status' => false,
                'message' => 'Invalid credentials.'
            ]);
            return;
        }

        // Provider profile image
        $provider = $this->db->select('profile_image')
            ->where('provider_id', $user->id)
            ->get('provider')
            ->row();

        $user->profile_image = $provider ? $provider->profile_image : null;

        // Save device token
        if ($expo_token) {
            $this->save_user_expo_token(
                $user->id,
                $expo_token,
                $device_type,
                $app_version
            );
        }

        // Generate JWT
        $token = $this->generate_jwt($user);

        // Cleanup OTP
        $this->db->where('id', $otp_row->id)->delete('user_login_otps');

        echo json_encode([
            'code'   => 200,
            'status' => true,
            'message' => 'Login successful.',
            'token'  => $token,
            'user'   => $user
        ]);
    }



    public function logout()
    {
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or provider ID missing',
                    'data' => null
                ]));
            return;
        }

        $expiry = date('Y-m-d H:i:s', $decoded->exp);
        $this->db->insert('token_blacklist', [
            'token' => $token,
            'expires_at' => $expiry
        ]);

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => true,
                'code' => 200,
                'message' => 'Logout successful — token invalidated',
                'data' => null
            ]));
    }


    public function delete_account()
    {
        header('Content-Type: application/json');

        // 1️⃣ Verify JWT Token
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = (int) $decoded->data->id;

        $this->db->where('user_id', $user_id)
            ->delete('user_tokens');
        // 2️⃣ Fetch user info
        $user = $this->db->get_where('users', ['id' => $user_id])->row();

        if (!$user) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'User not found',
                    'data' => null
                ]));
        }

        $this->db->trans_start();

        // 3️⃣ If role = 2 → delete from provider & service too
        if ($user->role == 2) {
            $this->db->delete('provider', ['provider_id' => $user_id]);
            $this->db->delete('service', ['provider_id' => $user_id]);
            $this->db->delete('provider_schedules', ['provider_id' => $user_id]);
        }

        // Always delete user
        $this->db->delete('users', ['id' => $user_id]);

        $this->db->trans_complete();

        // 4️⃣ Check transaction success
        if ($this->db->trans_status() === FALSE) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Failed to delete account. Please try again.',
                    'data' => null
                ]));
        }

        // 5️⃣ Success response
        return $this->output
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'code' => 200,
                'message' => 'Account deleted successfully',
                'data' => null
            ]));
    }
    private function save_user_expo_token($user_id, $expo_token, $device_type = 'android', $app_version = null)
    {
        // Validate Expo token format
        if (!preg_match('/^ExponentPushToken\[.+\]$/', $expo_token)) {
            log_message('error', '❌ Invalid Expo token format: ' . $expo_token);
            return false;
        }

        // Check if token already exists for this user
        $existing = $this->db
            ->where('user_id', $user_id)
            ->get('user_tokens')
            ->row();

        $token_data = [
            'user_id'     => $user_id,
            'expo_token'  => $expo_token,
            'device_type' => $device_type,
            'app_version' => $app_version,
            'is_active'   => 1,
            'updated_at'  => date('Y-m-d H:i:s')
        ];

        if ($existing) {

            // Update existing token
            $this->db
                ->where('user_id', $user_id)
                ->update('user_tokens', $token_data);

            log_message('info', '✅ Expo token updated for user: ' . $user_id);
        } else {

            // Insert new token
            $token_data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('user_tokens', $token_data);

            log_message('info', '✅ Expo token saved for user: ' . $user_id);
        }

        return true;
    }


    public function home()
    {
        header('Content-Type: application/json');

        // 1️⃣ Verify JWT
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = (int) $decoded->data->id;
        $default_profile_image = base_url('assets/images/3d-cartoon-fitness-man.jpg');

        $lat = floatval($this->input->post('lat') ?? $this->input->get('lat') ?? 0);
        $lng = floatval($this->input->post('lng') ?? $this->input->get('lng') ?? 0);
        $user_location = $this->input->post('address') ?? $this->input->get('address') ?? '';

        // ✅ Fetch categories and add full path
        $categories = $this->general_model->getAll('categories', ['isActive' => 1]);
        foreach ($categories as &$cat) {
            if (!empty($cat->image)) {
                $cat->image = base_url($cat->image);
            }
        }

        // ✅ Fetch sliders with full image path
        $sliders = $this->db
            ->where('isActive', 1)
            ->order_by('display_order', 'ASC')
            ->get('slider')
            ->result();

        foreach ($sliders as &$slider) {
            if (!empty($slider->slider_image)) {
                $slider->slider_image = base_url('uploads/slider/' . $slider->slider_image);
            }
        }

        // ✅ Get Trainer & Gym sub-category IDs
        $trainer_id = $this->db->get_where('categories', ['name' => 'TRAINER', 'isActive' => 1])->row()->id ?? 0;
        $gym_id = $this->db->get_where('categories', ['name' => 'GYM', 'isActive' => 1])->row()->id ?? 0;

        // ✅ Common select query (distance removed)
        $select_query = "
        provider.*, users.name, users.gym_name, COUNT(service.id) as total_services
    ";

        // ✅ Trainer providers
        $trainer_providers = $this->db
            ->select($select_query)
            ->from('provider')
            ->join('users', 'users.id = provider.provider_id', 'left')
            ->join('service', 'service.provider_id = provider.provider_id', 'left')
            ->where('provider.sub_category', $trainer_id)
            ->where('provider.isActive', 1)
            ->group_by('provider.id')
            ->get()
            ->result();

        foreach ($trainer_providers as &$trainer) {
            if (!empty($trainer->profile_image)) {
                $trainer->profile_image = base_url($trainer->profile_image);
            } else {
                $trainer->profile_image = $default_profile_image;
            }
        }

        // ✅ Gym providers
        $gym_providers = $this->db
            ->select($select_query)
            ->from('provider')
            ->join('users', 'users.id = provider.provider_id', 'left')
            ->join('service', 'service.provider_id = provider.provider_id', 'left')
            ->where('provider.sub_category', $gym_id)
            ->where('provider.isActive', 1)
            ->group_by('provider.id')
            ->get()
            ->result();

        foreach ($gym_providers as &$gym) {
            if (!empty($gym->profile_image)) {
                $gym->profile_image = base_url($gym->profile_image);
            } else {
                $gym->profile_image = $default_profile_image;
            }
        }

        // ✅ Nearest providers (distance removed)
        $nearest_providers = $this->db
            ->select($select_query)
            ->from('provider')
            ->join('users', 'users.id = provider.provider_id', 'left')
            ->join('service', 'service.provider_id = provider.provider_id', 'left')
            ->where('provider.isActive', 1)
            ->group_by('provider.id')
            ->get()
            ->result();

        foreach ($nearest_providers as &$provider) {
            if (!empty($provider->profile_image)) {
                $provider->profile_image = base_url($provider->profile_image);
            } else {
                $provider->profile_image = $default_profile_image;
            }
        }

        // ✅ Final response (distance not included)
        echo json_encode([
            'code' => 200,
            'status' => true,
            'message' => 'Data fetched successfully',
            'user_location' => $user_location,
            'categories' => $categories,
            'sliders' => $sliders,
            'trainer_providers' => $trainer_providers,
            'gym_providers' => $gym_providers,
            'nearest_providers' => $nearest_providers
        ]);
    }

    public function fetch_services()
    {
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = (int) $decoded->data->id;

        $page = (int) ($this->input->get('page') ?? $this->input->post('page') ?? 1);
        if ($page < 1)
            $page = 1;

        $limit = 9;
        $offset = ($page - 1) * $limit;

        $lat = floatval($this->input->post('lat') ?? $this->input->get('lat') ?? 0);
        $lng = floatval($this->input->post('lng') ?? $this->input->get('lng') ?? 0);

        $this->db->select("
    service.id AS service_id,
    service.name AS service_name,
    service.image AS service_image,
    service.description AS service_description,
    service.isActive AS service_status,
    service.created_on,
    provider.id AS provider_table_id,
    provider.provider_id,
    provider.month_price,
    provider.longitude,
    provider.latitude,
    users.name AS provider_name,
    users.gym_name,
    users.email,
    users.mobile,
    provider.profile_image
");
        $this->db->from('service');
        $this->db->join('provider', 'provider.provider_id = service.provider_id', 'left');
        $this->db->join('users', 'users.id = provider.provider_id', 'left');
        $this->db->where('service.isActive', 1);

        $total = $this->db->count_all_results('', false);
        $this->db->limit($limit, $offset);
        $services = $this->db->get()->result();

        foreach ($services as &$service) {
            $service->service_image = !empty($service->service_image) ? base_url($service->service_image) : '';
            $service->profile_image = !empty($service->profile_image) ? base_url($service->profile_image) : '';
        }

        echo json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'Success',
            'total' => $total,
            'limit' => $limit,
            'page' => $page,
            'services' => $services
        ]);
    }

    public function search_service()
    {
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = (int) $decoded->data->id;
        $query = trim($this->input->get('query') ?? $this->input->post('query') ?? '');
        $page = (int) ($this->input->get('page') ?? $this->input->post('page') ?? 1);
        if ($page < 1)
            $page = 1;

        $limit = 9;
        $offset = ($page - 1) * $limit;

        $lat = floatval($this->session->userdata('user_lat') ?? 0);
        $lng = floatval($this->session->userdata('user_lng') ?? 0);

        $this->db->select("
    service.id AS service_id,
    service.name AS service_name,
    service.image AS service_image,
    service.description AS service_description,
    service.isActive AS service_status,
    service.created_on,
    provider.id AS provider_table_id,
    provider.provider_id,
    provider.month_price,
    provider.longitude,
    provider.latitude,
    users.name AS provider_name,
    users.gym_name,
    users.email,
    users.mobile,
    provider.profile_image
");

        if ($lat && $lng) {
            $this->db->select("(6371 * acos(
        cos(radians($lat)) * cos(radians(provider.latitude)) * cos(radians(provider.longitude) - radians($lng)) +
        sin(radians($lat)) * sin(radians(provider.latitude))
    )) AS distance", FALSE);
        }

        $this->db->from('service');
        $this->db->join('provider', 'provider.provider_id = service.provider_id', 'left');
        $this->db->join('users', 'users.id = provider.provider_id', 'left');
        $this->db->where('service.isActive', 1);
        $this->db->where('users.isActive', 1);
        $this->db->where('users.role', 2);
        $this->db->where('provider.isActive', 1);

        if (!empty($query)) {
            $this->db->group_start();
            $this->db->like('service.name', $query);
            $this->db->or_like('service.description', $query);
            $this->db->or_like('users.gym_name', $query);
            $this->db->group_end();
        }

        $total = $this->db->count_all_results('', false);

        if ($lat && $lng) {
            $this->db->order_by('distance', 'ASC');
        } else {
            $this->db->order_by('service.created_on', 'DESC');
        }

        $this->db->limit($limit, $offset);
        $services = $this->db->get()->result();

        foreach ($services as &$service) {
            $service->service_image = !empty($service->service_image) ? base_url($service->service_image) : '';
            $service->profile_image = !empty($service->profile_image) ? base_url($service->profile_image) : '';
            if (isset($service->distance)) {
                $service->distance = ($service->distance < 1)
                    ? round($service->distance * 1000) . ' m'
                    : round($service->distance, 1) . ' km';
            }
        }

        echo json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'Success',
            'total' => $total,
            'limit' => $limit,
            'page' => $page,
            'services' => $services
        ]);
    }
    public function fetch_providers()
    {
        header('Content-Type: application/json');

        /* ================= JWT AUTH ================= */
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        preg_match('/Bearer\s(\S+)/', $authHeader, $matches);
        $decoded = $this->verify_jwt($matches[1] ?? null);

        if (!$decoded || empty($decoded->data->id)) {
            echo json_encode([
                'status' => false,
                'code'   => 400,
                'msg'    => 'Invalid token',
                'data'   => null
            ]);
            return;
        }

        /* ================= PAGINATION ================= */
        $page   = max(1, (int) $this->input->get('page'));
        $limit  = 9;
        $offset = ($page - 1) * $limit;

        /* ================= FILTER INPUTS ================= */
        $category = $this->input->get('category');
        $language = $this->input->get('language');
        $service  = $this->input->get('service');
        $exp      = $this->input->get('exp');
        $price    = $this->input->get('price');
        $rating   = $this->input->get('rating');
        $search   = $this->input->get('search'); // 🔍 NEW: Search parameter

        /* =================================================
       BASE QUERY (JOIN + FILTERS)
    ================================================= */
        $this->db->from('provider');
        $this->db->join('users AS u', 'u.id = provider.provider_id', 'left');
        $this->db->join('service AS s', 's.provider_id = provider.provider_id', 'left');
        $this->db->join('reviews AS r', 'r.provider_id = provider.provider_id', 'left');
        $this->db->where('u.isActive', 1);

        /* ================= SEARCH FILTER ================= */
        if (!empty($search)) {
            $search_term = trim($search);
            $this->db->group_start(); // Start OR group
            $this->db->like('u.gym_name', $search_term);
            $this->db->or_like('provider.category', $search_term);
            $this->db->or_like('provider.service_type', $search_term);
            $this->db->group_end(); // End OR group
        }

        /* ================= APPLY FILTERS ================= */
        if (!empty($category)) {
            $this->db->where('provider.category', $category);
        }

        if (!empty($language)) {
            $this->db->where(
                "FIND_IN_SET(" . $this->db->escape($language) . ", provider.language) > 0",
                null,
                false
            );
        }

        if (!empty($service)) {
            $this->db->where('provider.service_type', $service);
        }

        if (!empty($exp)) {
            switch ($exp) {
                case '0_2':
                    $this->db->where('provider.exp >=', 0);
                    $this->db->where('provider.exp <=', 2);
                    break;
                case '3_5':
                    $this->db->where('provider.exp >=', 3);
                    $this->db->where('provider.exp <=', 5);
                    break;
                case '5_10':
                    $this->db->where('provider.exp >=', 5);
                    $this->db->where('provider.exp <=', 10);
                    break;
                case '10_plus':
                    $this->db->where('provider.exp >=', 10);
                    break;
            }
        }

        /* ================= GROUP BY ================= */
        $this->db->group_by('provider.id');

        /* ================= RATING FILTER ================= */
        if (!empty($rating) && $rating !== 'top_rated') {
            $min = 0;
            if ($rating === '4_plus') $min = 4;
            if ($rating === '3_plus') $min = 3;
            if ($rating === '2_plus') $min = 2;

            if ($min > 0) {
                $this->db->having('IFNULL(AVG(r.rating),0) >=', $min);
            }
        }

        /* ================= COUNT TOTAL RECORDS ================= */
        $count_db = clone $this->db;
        $count_db->select('COUNT(DISTINCT provider.id) AS numrows', false);
        $count_query = $count_db->get();

        $total = 0;
        if ($count_query && $count_query->num_rows() > 0) {
            $row = $count_query->row();
            $total = isset($row->numrows) ? (int)$row->numrows : 0;
        }

        /* ================= SELECT DATA ================= */
        $this->db->select("
        provider.id AS provider_id_main,
        provider.provider_id AS provider_user_id,
        MAX(provider.profile_image) AS profile_image,
        MAX(provider.latitude) AS latitude,
        MAX(provider.longitude) AS longitude,
        MAX(u.gym_name) AS gym_name,
        MAX(provider.day_price) AS day_price,
        COUNT(DISTINCT s.id) AS service_count,
        ROUND(IFNULL(AVG(r.rating),0), 1) AS avg_rating
    ", false);

        /* ================= SORTING ================= */
        if ($price === 'low_to_high') {
            $this->db->order_by('provider.day_price', 'ASC');
        } elseif ($price === 'high_to_low') {
            $this->db->order_by('provider.day_price', 'DESC');
        } elseif ($rating === 'top_rated') {
            $this->db->order_by('avg_rating', 'DESC');
        } else {
            $this->db->order_by('provider.id', 'DESC');
        }

        /* ================= FETCH DATA ================= */
        $this->db->limit($limit, $offset);
        $providers = $this->db->get()->result();

        /* ================= IMAGE PATH FIX ================= */
        foreach ($providers as &$p) {
            $p->profile_image = !empty($p->profile_image)
                ? base_url($p->profile_image)
                : base_url('assets/images/3d-cartoon-fitness-man.jpg');
        }

        /* ================= RESPONSE ================= */
        echo json_encode([
            'status' => true,
            'code'   => 200,
            'msg'    => 'Providers fetched successfully',
            'page'   => $page,
            'limit'  => $limit,
            'total'  => $total,
            'data'   => $providers
        ]);
    }

    public function search_providers()
    {
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = (int) $decoded->data->id;

        $keyword = trim($this->input->get('query') ?? '');
        $page = (int) ($this->input->get('page') ?? 1);
        if ($page < 1)
            $page = 1;

        $limit = 9;
        $offset = ($page - 1) * $limit;

        $lat = floatval($this->session->userdata('user_lat') ?? 0);
        $lng = floatval($this->session->userdata('user_lng') ?? 0);

        $this->db->select("
        provider.profile_image, 
        users.gym_name, 
        provider.provider_id, 
        provider.latitude, 
        provider.longitude,
        COUNT(service.id) as service_count
    ");

        $this->db->from('provider');
        $this->db->join('users', 'users.id = provider.provider_id', 'left');
        $this->db->join('service', 'service.provider_id = provider.provider_id', 'left');
        $this->db->where('users.isActive', 1);
        $this->db->group_start();
        $this->db->like('users.name', $keyword);
        $this->db->or_like('users.gym_name', $keyword);
        $this->db->or_like('provider.city', $keyword);
        $this->db->group_end();
        $this->db->group_by('provider.provider_id');

        $total = $this->db->count_all_results('', false);
        $this->db->limit($limit, $offset);
        $providers = $this->db->get()->result();

        foreach ($providers as &$provider) {
            $provider->profile_image = !empty($provider->profile_image)
                ? base_url($provider->profile_image)
                : base_url('uploads/default.png');
        }

        echo json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'Search results fetched successfully',
            'total' => $total,
            'limit' => $limit,
            'page' => $page,
            'providers' => $providers
        ]);
    }

    public function provider_details($id)
    {
        header('Content-Type: application/json');

        /* -------------------------
       JWT AUTH
    ------------------------- */
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing'
                ]));
        }

        $user_id = (int) $decoded->data->id;

        if (empty($id) || !is_numeric($id)) {
            echo json_encode([
                'status' => false,
                'message' => 'Invalid provider ID'
            ]);
            return;
        }

        /* -------------------------
       PROVIDER DETAILS QUERY
    ------------------------- */
        $this->db->select("
        provider.provider_id,
        provider.profile_image,
        provider.day_price,
        provider.week_price,
        provider.month_price,
        provider.year_price,
        provider.description,
        provider.latitude,
        provider.longitude,
        users.gym_name,
        users.email,
        users.name,
        users.mobile,
        COUNT(DISTINCT service.id) AS service_count,
        GROUP_CONCAT(DISTINCT expertise_tag.tag) AS expertise_tags
    ");

        $this->db->from('provider');
        $this->db->join('users', 'users.id = provider.provider_id', 'left');
        $this->db->join(
            'service',
            'service.provider_id = provider.provider_id AND service.isActive = 1',
            'left'
        );
        $this->db->join(
            'expertise_tag',
            'expertise_tag.provider_id = provider.provider_id',
            'left'
        );

        $this->db->where('provider.provider_id', $id);
        $this->db->where('provider.isActive', 1);

        // ✅ REQUIRED FOR ONLY_FULL_GROUP_BY
        $this->db->group_by([
            'provider.provider_id',
            'provider.profile_image',
            'provider.day_price',
            'provider.week_price',
            'provider.month_price',
            'provider.year_price',
            'provider.description',
            'provider.latitude',
            'provider.longitude',
            'users.gym_name',
            'users.email',
            'users.name',
            'users.mobile'
        ]);

        $provider = $this->db->get()->row();

        if (!$provider) {
            echo json_encode([
                'status' => false,
                'message' => 'Provider not found'
            ]);
            return;
        }

        /* -------------------------
       EXTRA DATA
    ------------------------- */
        $locationData = $this->getCityState($provider->latitude, $provider->longitude);

        $services  = $this->db->get_where('service', [
            'provider_id' => $id,
            'isActive'    => 1
        ])->result();

        $schedules = $this->general_model->getAll('provider_schedules', ['provider_id' => $id]);
        $offers    = $this->general_model->getAll('offers', ['provider_id' => $id, 'isActive' => 1]);
        $gallery   = $this->db->get_where('gym_gallery', [
            'provider_id' => $id,
            'status'      => 1
        ])->result();
        $certificate   = $this->db->get_where('certifications', [
            'provider_id' => $id,
            'is_active'      => 1
        ])->result();

        $base_url = base_url();

        /* -------------------------
       IMAGE FORMATTING
    ------------------------- */
        $profile_image = !empty($provider->profile_image)
            ? (preg_match('/^http/', $provider->profile_image)
                ? $provider->profile_image
                : $base_url . $provider->profile_image)
            : $base_url . 'assets/images/3d-cartoon-fitness-man.jpg';


        foreach ($services as &$srv) {
            $srv->image = !empty($srv->image)
                ? (preg_match('/^http/', $srv->image) ? $srv->image : $base_url . $srv->image)
                : '';

            $srv->service_image = !empty($srv->service_image)
                ? (preg_match('/^http/', $srv->service_image) ? $srv->service_image : $base_url . $srv->service_image)
                : '';
        }

        $gallery_images = [];
        foreach ($gallery as $img) {
            $gallery_images[] = [
                'id'         => $img->id,
                'image'      => preg_match('/^http/', $img->image)
                    ? $img->image
                    : $base_url . $img->image,
                'created_on' => $img->created_on
            ];
        }
        //  $gallery_images = [];
        $certificate_images = [];
        foreach ($certificate as $img) {
            $certificate_images[] = [
                'id'         => $img->id,
                'image'      => preg_match('/^http/', $img->image_path)
                    ? $img->image_path
                    : $base_url . $img->image_path,
                'created_on' => $img->created_on
            ];
        }
        $reviews = $this->db
            ->select('r.id, r.rating, r.review_text, r.created_at, u.name AS user_name')
            ->from('reviews r')
            ->join('users u', 'u.id = r.user_id', 'left')
            ->where('r.provider_id', $id)
            ->order_by('r.created_at', 'DESC')
            ->get()
            ->result_array();


        $has_order = $this->db
            ->select('oi.id')
            ->from('orders o')
            ->join('order_items oi', 'oi.order_id = o.id')
            ->where('o.user_id', $user_id)
            ->where('o.status', 'success')
            ->where('oi.provider_id', $id)
            ->limit(1)
            ->get()
            ->row();

        $can_add_review = $has_order ? true : false;

        /* -------------------------
       RESPONSE
    ------------------------- */
        echo json_encode([
            'code'    => 200,
            'status'  => true,
            'message' => 'Provider details fetched successfully',
            'provider' => [
                'provider_id'    => $provider->provider_id,
                'gym_name'       => $provider->gym_name,
                'email'          => $provider->email,
                'name'           => $provider->name,
                'mobile'         => $provider->mobile,
                'profile_image'  => $profile_image,
                'day_price'      => $provider->day_price,
                'week_price'     => $provider->week_price,
                'month_price'    => $provider->month_price,
                'year_price'     => $provider->year_price,
                'about'          => $provider->description,
                'latitude'       => $provider->latitude,
                'longitude'      => $provider->longitude,
                'city'           => $locationData['city'] ?? '',
                'state'          => $locationData['state'] ?? '',
                'service_count'  => (int) $provider->service_count,
                'expertise_tags' => !empty($provider->expertise_tags)
                    ? explode(',', $provider->expertise_tags)
                    : []
            ],
            'reviews'        => $reviews,
            'can_add_review' => $can_add_review,
            'services' => $services,
            'schedule' => $schedules,
            'offers'   => $offers,
            'gallery'  => $gallery_images,
            'certificate'  => $certificate_images

        ]);
    }




    private function getCityState($latitude, $longitude)
    {

        $apiKey = 'AIzaSyAR5-9XtV0r0VyR7uu0ppEKhNHanKlGwWk';



        // ✅ Validate input

        if (empty($latitude) || empty($longitude)) {

            return ['city' => '', 'state' => ''];
        }



        $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$apiKey}";



        $response = @file_get_contents($url);

        if ($response === false) {

            return ['city' => '', 'state' => '']; // Prevent warnings

        }



        $response = json_decode($response, true);



        $city = '';

        $state = '';



        if (!empty($response['results'][0]['address_components'])) {

            foreach ($response['results'][0]['address_components'] as $component) {

                if (in_array('locality', $component['types'])) {

                    $city = $component['long_name'];
                }

                if (in_array('administrative_area_level_1', $component['types'])) {

                    $state = $component['long_name'];
                }
            }
        }



        return ['city' => $city, 'state' => $state];
    }
    public function bookings()
    {
        header('Content-Type: application/json');

        // ✅ 1. Verify JWT Token
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 401,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = (int) $decoded->data->id;

        // ✅ 2. Pagination setup (limit 5 per page)
        $limit = 5;
        $page = (int) ($this->input->get('page') ?? 1);
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        // ✅ 3. Filters
        $allowed_status = ['pending', 'success', 'failed', 'all'];
        $allowed_dates = ['today', 'this_week', 'this_month', 'last_month', 'all'];
        $allowed_sort = ['newest', 'oldest', 'highest_amount', 'lowest_amount'];

        $status = strtolower(trim($this->input->get('status') ?? 'all'));
        $date_range = strtolower(trim($this->input->get('date_range') ?? 'all'));
        $sort_by = strtolower(trim($this->input->get('sort_by') ?? 'newest'));

        if (!in_array($status, $allowed_status)) $status = 'all';
        if (!in_array($date_range, $allowed_dates)) $date_range = 'all';
        if (!in_array($sort_by, $allowed_sort)) $sort_by = 'newest';

        // ✅ 4. Base query for total records
        $this->db->select("COUNT(DISTINCT o.id) as total");
        $this->db->from("orders o");
        $this->db->where("o.user_id", $user_id);

        if ($status !== 'all') {
            $this->db->where("LOWER(o.status)", $status);
        }

        // ✅ Date filters
        $today = date('Y-m-d');
        switch ($date_range) {
            case 'today':
                $this->db->where("DATE(o.created_at)", $today);
                break;
            case 'this_week':
                $this->db->where("YEARWEEK(o.created_at, 1) =", date('oW'));
                break;
            case 'this_month':
                $this->db->where("MONTH(o.created_at)", date('m'));
                $this->db->where("YEAR(o.created_at)", date('Y'));
                break;
            case 'last_month':
                $this->db->where("MONTH(o.created_at)", date('m', strtotime('-1 month')));
                $this->db->where("YEAR(o.created_at)", date('Y', strtotime('-1 month')));
                break;
        }

        $total_rows = $this->db->get()->row()->total ?? 0;

        // ✅ 5. Fetch paginated records
        $this->db->select("
        o.id as order_id,
        o.total,
        o.status,
        o.created_at,
        oi.start_date,
        oi.duration,
        oi.qty,
        oi.name as gym_name
    ");
        $this->db->from("orders o");
        $this->db->join("order_items oi", "oi.order_id = o.id", "left");
        $this->db->where("o.user_id", $user_id);

        if ($status !== 'all') {
            $this->db->where("LOWER(o.status)", $status);
        }

        // ✅ Apply same date filter for actual records
        switch ($date_range) {
            case 'today':
                $this->db->where("DATE(o.created_at)", $today);
                break;
            case 'this_week':
                $this->db->where("YEARWEEK(o.created_at, 1) =", date('oW'));
                break;
            case 'this_month':
                $this->db->where("MONTH(o.created_at)", date('m'));
                $this->db->where("YEAR(o.created_at)", date('Y'));
                break;
            case 'last_month':
                $this->db->where("MONTH(o.created_at)", date('m', strtotime('-1 month')));
                $this->db->where("YEAR(o.created_at)", date('Y', strtotime('-1 month')));
                break;
        }

        // ✅ Sorting
        switch ($sort_by) {
            case 'oldest':
                $this->db->order_by("o.created_at", "ASC");
                break;
            case 'highest_amount':
                $this->db->order_by("o.total", "DESC");
                break;
            case 'lowest_amount':
                $this->db->order_by("o.total", "ASC");
                break;
            default:
                $this->db->order_by("o.created_at", "DESC");
        }

        $this->db->limit($limit, $offset);
        $query = $this->db->get();

        // ✅ 6. Grouped bookings (avoid duplicates)
        $bookings = [];
        foreach ($query->result() as $row) {
            $order_id = $row->order_id;

            if (!isset($bookings[$order_id])) {
                $bookings[$order_id] = [
                    'order_id'   => (int)$row->order_id,
                    'total'      => (float)$row->total,
                    'status'     => ucfirst($row->status),
                    'created_at' => $row->created_at,
                    'items'      => []
                ];
            }

            // Calculate end date
            $qty = (int)($row->qty ?? 1);
            $start_date = !empty($row->start_date) ? $row->start_date : date('Y-m-d'); // fallback if null
            $start = new DateTime($start_date);
            $end = clone $start;


            switch ($row->duration) {
                case 'day':
                    $end->modify('+' . ($qty - 1) . ' day');
                    break;
                case 'week':
                    $end->modify('+' . $qty . ' week')->modify('-1 day');
                    break;
                case 'month':
                    $end->modify('+' . $qty . ' month')->modify('-1 day');
                    break;
                case 'year':
                    $end->modify('+' . $qty . ' year')->modify('-1 day');
                    break;
            }

            $bookings[$order_id]['items'][] = [
                'gym_name'   => $row->gym_name,
                'start_date' => $row->start_date,
                'end_date'   => $end->format('Y-m-d'),
                'qty'        => $qty,
                'duration'   => $row->duration
            ];
        }

        // Convert associative array to indexed
        $bookings = array_values($bookings);

        // ✅ 7. Pagination
        $total_pages = max(1, ceil($total_rows / $limit));

        // ✅ 8. Final Response
        return $this->output
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'code' => 200,
                'message' => 'Bookings fetched successfully',
                'filters' => [
                    'status' => $status,
                    'date_range' => $date_range,
                    'sort_by' => $sort_by
                ],
                'pagination' => [
                    'total_rows' => $total_rows,
                    'total_pages' => $total_pages,
                    'current_page' => $page,
                    'limit' => $limit
                ],
                'bookings' => $bookings
            ]));
    }



    public function get_recipients()
    {
        header('Content-Type: application/json');

        /* -------------------------
       JWT AUTH
    ------------------------- */
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status'  => false,
                    'code'    => 401,
                    'message' => 'Invalid token or user ID missing'
                ]));
        }

        $user_id = (int) $decoded->data->id;

        /* -------------------------
       QUERY (ONLY_FULL_GROUP_BY SAFE)
    ------------------------- */
        $sql = "
        SELECT rr.*
        FROM rent_recipients rr
        INNER JOIN (
            SELECT account_number, MAX(created_at) AS latest_date
            FROM rent_recipients
            WHERE user_id = ? AND isActive = 1
            GROUP BY account_number
        ) t ON t.account_number = rr.account_number 
           AND t.latest_date = rr.created_at
        WHERE rr.user_id = ? AND rr.isActive = 1
        ORDER BY rr.created_at DESC
        LIMIT 5
    ";

        $recipients = $this->db->query($sql, [$user_id, $user_id])->result_array();

        /* -------------------------
       RESPONSE
    ------------------------- */
        echo json_encode([
            'code'    => 200,
            'status'  => true,
            'message' => 'Recipients fetched successfully',
            'count'   => count($recipients),
            'data'    => $recipients
        ]);
    }

    public function get_transactions()
    {
        header('Content-Type: application/json');

        // ✅ 1. Verify JWT Token
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = (int) $decoded->data->id;

        // ✅ Pagination & filters
        $filter = $this->input->get('filter') ?? '';
        $page = (int)($this->input->get('page') ?? 1);
        if ($page < 1) $page = 1;
        $per_page = 10;
        $offset = ($page - 1) * $per_page;

        $where = "WHERE t.user_id = ?";
        $params = [$user_id];

        // ✅ Apply filters
        switch ($filter) {
            case 'today':
                $where .= " AND DATE(t.created_at) = CURDATE()";
                break;
            case 'month':
                $where .= " AND MONTH(t.created_at) = MONTH(CURDATE()) AND YEAR(t.created_at) = YEAR(CURDATE())";
                break;
            case 'pending':
                $where .= " AND t.status = 'pending'";
                break;
            case 'success':
                $where .= " AND t.status = 'success'";
                break;
        }

        // ✅ Count total records
        $total = $this->db->query("
        SELECT COUNT(*) as cnt 
        FROM rent_transactions t 
        $where
    ", $params)->row()->cnt;

        // ✅ Set order — Latest ID first
        $order = "ORDER BY t.id DESC";
        if ($filter === 'largest') {
            $order = "ORDER BY t.amount DESC";
        } elseif ($filter === 'smallest') {
            $order = "ORDER BY t.amount ASC";
        }

        // ✅ Fetch transaction data
        $transactions = $this->db->query("
        SELECT 
            t.id, 
            t.amount, 
            t.status, 
            t.txnid, 
            t.created_at
        FROM rent_transactions t
        $where
        $order
        LIMIT ? OFFSET ?
    ", array_merge($params, [$per_page, $offset]))->result_array();

        // ✅ Prepare response
        return $this->output
            ->set_status_header(200)
            ->set_output(json_encode([
                'code' => 200,
                'status' => true,
                'message' => 'Transactions fetched successfully',
                'filter' => $filter,
                'current_page' => $page,
                'per_page' => $per_page,
                'total' => (string)$total,
                'transactions' => $transactions
            ]));
    }


    public function remove_recipients($id = null)
    {
        header('Content-Type: application/json');

        // ✅ 1. Verify JWT Token
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = (int) $decoded->data->id;

        // ✅ 2. Validate ID from URL
        if (empty($id) || !is_numeric($id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Recipient ID is required',
                    'data' => null
                ]));
        }

        // ✅ 3. Check if Recipient Exists and Belongs to User
        $recipient = $this->db->get_where('rent_recipients', [
            'id' => $id,
            'user_id' => $user_id
        ])->row();

        if (!$recipient) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Recipient not found or does not belong to this user',
                    'data' => null
                ]));
        }

        // ✅ 4. Check if Already Inactive
        if ((int)$recipient->isActive === 0) {
            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Recipient already removed',
                    'data' => [
                        'id' => (int)$id,
                        'isActive' => 0
                    ]
                ]));
        }

        // ✅ 5. Soft Delete (set isActive = 0)
        $updated = $this->db
            ->where('id', $id)
            ->where('user_id', $user_id)
            ->update('rent_recipients', ['isActive' => 0]);

        if ($updated) {
            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Recipient removed successfully',
                    'data' => [
                        'id' => (int)$id,
                        'isActive' => 0
                    ]
                ]));
        } else {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Failed to remove recipient, please try again',
                    'data' => null
                ]));
        }
    }

    public function transection_details($id = null)
    {
        header('Content-Type: application/json');

        // ✅ Step 1: Verify JWT
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 401,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = (int) $decoded->data->id;

        // ✅ Step 2: Get Transaction ID
        if (empty($id)) {
            $id = $this->input->get('id');
        }

        if (empty($id) || !is_numeric($id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Transaction ID is required',
                    'data' => null
                ]));
        }

        // ✅ Step 3: Fetch Transaction and Recipient Info
        $transaction = $this->db->query("
        SELECT 
            t.id, 
            t.txnid, 
            t.amount, 
            t.status, 
            t.settled, 
            t.settled_at, 
            t.created_at,
            r.recipient_name, 
            r.bank_name, 
            r.account_number, 
            r.remark,
            r.ifsc_code
        FROM rent_transactions t
        LEFT JOIN rent_recipients r ON t.recipient_id = r.id
        WHERE t.id = ? AND t.user_id = ?
        LIMIT 1
    ", [$id, $user_id])->row_array();

        if (!$transaction) {
            return $this->output
                ->set_status_header(404)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 404,
                    'message' => 'Transaction not found or does not belong to this user',
                    'data' => null
                ]));
        }

        // ✅ Step 4: Fetch User Info
        $user = $this->db->select('id AS user_id, name, email, mobile')
            ->from('users')
            ->where('id', $user_id)
            ->get()
            ->row_array();

        // ✅ Step 5: Merge Data
        $data = [
            'id' => $transaction['id'],

            'transaction_id' => $transaction['txnid'],
            'amount' => '₹' . number_format($transaction['amount'], 2),
            'status' => ucfirst($transaction['status']),
            'settlement' => (int) $transaction['settled'],
            'created_at' => date('D, d M Y, h:i A', strtotime($transaction['created_at'])),
            'receiver_name' => $transaction['recipient_name'],
            'bank' => $transaction['bank_name'] . ' (' . $transaction['ifsc_code'] . ')',
            'account_number' => '****' . substr($transaction['account_number'], -4),
            'remark' => $transaction['remark'],
            'sender_name' => $user['name'],
            'mobile' => $user['mobile'],
            'email' => $user['email'],

            // ✅ Static values
            'transaction_fee' => '2% + GST',
            'processing_time' => 'Instant',
            'transfer_type' => 'Fund Transfer to Account',
        ];

        // ✅ Step 6: Final Response
        return $this->output
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'code' => 200,
                'message' => 'Transaction details fetched successfully',
                'data' => $data
            ]));
    }

    public function pay_api()
    {
        header('Content-Type: application/json');

        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;
        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = (int) $decoded->data->id;
        $input = json_decode($this->input->raw_input_stream, true);

        $required_fields = ['name', 'mobile_number', 'account_number', 'confirm_account_number', 'ifsc_code', 'bank_name', 'transfer_amount', 'remark'];
        foreach ($required_fields as $field) {
            if (empty($input[$field])) {
                return $this->output->set_status_header(400)
                    ->set_output(json_encode([
                        'status' => false,
                        'code' => 400,
                        'message' => ucfirst(str_replace('_', ' ', $field)) . ' is required',
                        'data' => null
                    ]));
            }
        }

        if ($input['account_number'] !== $input['confirm_account_number']) {
            return $this->output->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Account numbers do not match',
                    'data' => null
                ]));
        }

        $amount = floatval($input['transfer_amount']);
        if ($amount <= 0) {
            return $this->output->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid transfer amount',
                    'data' => null
                ]));
        }

        $amount_paise = intval($amount * 100);
        $txnid = uniqid('TXN_');

        $recipient_data = [
            'user_id' => $user_id,
            'recipient_name' => $input['name'],
            'phone_number' => $input['mobile_number'],
            'account_number' => $input['account_number'],
            'ifsc_code' => $input['ifsc_code'],
            'bank_name' => $input['bank_name'],
            'remark' => $input['remark'],
            'is_verified' => 0,
            'is_default' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('rent_recipients', $recipient_data);
        $recipient_id = $this->db->insert_id();

        $rent_data = [
            'user_id' => $user_id,
            'recipient_id' => $recipient_id,
            'amount' => $amount,
            'txnid' => $txnid,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('rent_transactions', $rent_data);

        // ✅ Create Razorpay order
        try {
            $razorpayOrder = $this->api->order->create([
                'receipt' => $txnid,
                'amount' => $amount_paise,
                'currency' => 'INR',
                'payment_capture' => 1
            ]);

            $response = [
                'status' => true,
                'code' => 200,
                'message' => 'Order created successfully',
                'data' => [
                    'order_id' => $razorpayOrder['id'],
                    'txnid' => $txnid,
                    'amount' => $amount,
                    'currency' => 'INR',
                    'recipient_id' => $recipient_id,
                    'razorpay_key' => $this->razorpay_key_id
                ]
            ];

            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode($response));
        } catch (Exception $e) {
            return $this->output
                ->set_status_header(500)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Razorpay order creation failed: ' . $e->getMessage(),
                    'data' => null
                ]));
        }
    }


    public function payment_verification()
    {
        header('Content-Type: application/json');

        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;
        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }
        $input = json_decode($this->input->raw_input_stream, true);

        $payment_id = $input['razorpay_payment_id'] ?? null;
        $order_id = $input['razorpay_order_id'] ?? null;
        $signature = $input['razorpay_signature'] ?? null;
        $txnid = $input['txnid'] ?? null;

        if (!$payment_id || !$order_id || !$signature || !$txnid) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Missing required payment fields',
                    'data' => null
                ]));
        }

        try {
            $this->api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $order_id,
                'razorpay_payment_id' => $payment_id,
                'razorpay_signature' => $signature
            ]);

            $this->db->where('txnid', $txnid)->update('rent_transactions', [
                'status' => 'success',
                // 'payment_id' => $payment_id,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Payment verified successfully',
                    'data' => [
                        'txnid' => $txnid,
                        'payment_id' => $payment_id
                    ]
                ]));
        } catch (Exception $e) {
            $this->db->where('txnid', $txnid)->update('rent_transactions', ['status' => 'failed']);
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Payment verification failed: ' . $e->getMessage(),
                    'data' => null
                ]));
        }
    }

    public function add_to_cart()
    {
        header('Content-Type: application/json');

        // ✅ Verify Authorization Token
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;
        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = (int)$decoded->data->id;

        // ✅ Get raw JSON body
        $input = json_decode($this->input->raw_input_stream, true);

        $provider_id = isset($input['provider_id']) ? (int)$input['provider_id'] : 0;
        $duration    = isset($input['duration']) ? trim($input['duration']) : '';
        $qty         = isset($input['quantity']) ? (int)$input['quantity'] : 0;
        $start_date  = isset($input['start_date']) ? trim($input['start_date']) : '';

        // ✅ Validate required fields
        if (empty($provider_id) || empty($duration) || empty($qty) || empty($start_date)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Required fields missing (provider_id, duration, quantity, start_date).',
                    'data' => null
                ]));
        }

        // ✅ Validate start date (cannot be in the past)
        if (strtotime($start_date) < strtotime(date('Y-m-d'))) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Start date cannot be earlier than today.',
                    'data' => null
                ]));
        }

        // ✅ Fetch provider + user info
        $provider = $this->db->select('provider.*, users.name as provider_name, users.email, users.mobile')
            ->from('provider')
            ->join('users', 'users.id = provider.provider_id', 'left')
            ->where('provider.provider_id', $provider_id)
            ->where('provider.isActive', 1)
            ->get()
            ->row();

        if (!$provider) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Provider not found or inactive.',
                    'data' => null
                ]));
        }

        // ✅ Pick correct price based on duration
        switch (strtolower($duration)) {
            case 'day':
            case 'daily':
                $price = (float)$provider->day_price;
                break;
            case 'week':
            case 'weekly':
                $price = (float)$provider->week_price;
                break;
            case 'month':
            case 'monthly':
                $price = (float)$provider->month_price;
                break;
            case 'year':
            case 'yearly':
                $price = (float)$provider->year_price;
                break;
            default:
                $price = 0;
        }

        if ($price <= 0) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid duration or price not set for this provider.',
                    'data' => null
                ]));
        }

        // ✅ Provider image
        $base_url = base_url();
        $provider_image = !empty($provider->profile_image)
            ? (preg_match('/^http/', $provider->profile_image) ? $provider->profile_image : $base_url . $provider->profile_image)
            : '';

        // ✅ Check existing item
        $existing = $this->db->get_where('cart_items', [
            'user_id' => $user_id,
            'provider_id' => $provider_id,
            'duration' => $duration
        ])->row_array();

        if ($existing) {
            // Update existing quantity
            $this->db->set('qty', 'qty + ' . (int)$qty, FALSE)
                ->set('updated_on', date('Y-m-d H:i:s'))
                ->where('id', $existing['id'])
                ->update('cart_items');
            $cart_id = $existing['id'];
        } else {
            // Insert new cart item
            $this->db->insert('cart_items', [
                'user_id' => $user_id,
                'provider_id' => $provider_id,
                'provider_name' => $provider->provider_name,
                'provider_image' => $provider_image,
                'price' => $price,
                'duration' => $duration,
                'qty' => $qty,
                'start_date' => $start_date,
                'created_on' => date('Y-m-d H:i:s')
            ]);
            $cart_id = $this->db->insert_id();
        }

        // ✅ Response
        return $this->output
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'code' => 200,
                'message' => 'Item added to cart successfully.',
                'data' => [
                    'cart_id' => $cart_id,
                    'user_id' => $user_id,
                    'provider_id' => $provider_id,
                    'provider_name' => $provider->provider_name,
                    'provider_image' => $provider_image,
                    'price' => $price,
                    'duration' => $duration,
                    'qty' => $qty,
                    'start_date' => $start_date,
                    'created_on' => date('Y-m-d H:i:s')
                ]
            ]));
    }
    public function get_cart_items()
    {
        header('Content-Type: application/json');

        // ✅ Check Authorization Header
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;
        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = (int)$decoded->data->id;

        // ✅ Fetch cart items for this user
        $cart_items = $this->db
            ->where('user_id', $user_id)
            ->get('cart_items')
            ->result_array();

        // ✅ Get offer settings
        $offer_setting = $this->db->get('offer_settings')->row();
        $offer_percent = $offer_setting ? floatval($offer_setting->offer_percent) : 0;
        $min_amount_for_offer = $offer_setting ? floatval($offer_setting->min_amount) : 0;

        $subtotal = 0;
        $discount_amount = 0;

        if ($cart_items) {
            foreach ($cart_items as &$item) {
                $item_total = floatval($item['price']) * intval($item['qty']);
                $subtotal += $item_total;

                // ✅ Apply offer discount logic
                if ($offer_percent > 0) {
                    if ($min_amount_for_offer == 0 || $subtotal >= $min_amount_for_offer) {
                        $item['platform_discount'] = ($item_total * $offer_percent) / 100;
                    } else {
                        $item['platform_discount'] = 0;
                    }
                    $discount_amount += $item['platform_discount'];
                } else {
                    $item['platform_discount'] = 0;
                }

                // ✅ Add subtotal per item
                $item['subtotal'] = $item_total;
            }
            unset($item);
        }

        $total_after_discount = $subtotal - $discount_amount;

        // ✅ Build response
        return $this->output
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'code' => 200,
                'message' => 'Cart details fetched successfully.',
                'data' => [
                    'offer_percent' => $offer_percent,
                    'subtotal' => round($subtotal, 2),
                    'discount_amount' => round($discount_amount, 2),
                    'total_after_discount' => round($total_after_discount, 2),
                    'cart_items' => $cart_items
                ]
            ]));
    }
    public function update_cart_quantity()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid request method. Use POST.',
                    'data' => null
                ]));
        }

        // ✅ Verify Token
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;
        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = (int)$decoded->data->id;
        $input = json_decode($this->input->raw_input_stream, true);

        if (empty($input) || !is_array($input)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid input format. Expected JSON array.',
                    'data' => null
                ]));
        }

        foreach ($input as $item) {
            $cart_id  = isset($item['cart_id']) ? (int)$item['cart_id'] : 0;
            $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 0; // can be +ve or -ve

            if (!$cart_id || $quantity === 0) continue;

            $exists = $this->db->get_where('cart_items', [
                'id' => $cart_id,
                'user_id' => $user_id
            ])->row_array();

            if ($exists) {
                // ✅ Calculate new quantity
                $new_qty = $exists['qty'] + $quantity;

                // prevent from going below 1
                if ($new_qty < 1) {
                    $new_qty = 1;
                }

                $this->db->where('id', $cart_id)->update('cart_items', [
                    'qty' => $new_qty,
                    'updated_on' => date('Y-m-d H:i:s')
                ]);
            }
        }

        $cart_items = $this->db->get_where('cart_items', ['user_id' => $user_id])->result_array();

        return $this->output
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'code' => 200,
                'message' => 'Cart quantities updated successfully.',
                'data' => $cart_items
            ]));
    }


    public function remove_cart_item()
    {
        header('Content-Type: application/json');

        // ✅ Verify Token
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;
        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = (int)$decoded->data->id;

        // ✅ Handle both JSON and form data
        $raw_input = $this->input->raw_input_stream;
        $input = json_decode($raw_input, true);

        if (empty($input)) {
            $input = $this->input->post(); // fallback for form-data
        }

        $cart_id = isset($input['cart_id']) ? (int)$input['cart_id'] : 0;

        if (!$cart_id) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'cart_id is required.',
                    'data' => [
                        'received_input' => $input, // helps debug
                        'raw_input' => $raw_input   // shows what backend received
                    ]
                ]));
        }

        // ✅ Check if cart item exists for this user
        $exists = $this->db->get_where('cart_items', [
            'id' => $cart_id,
            'user_id' => $user_id
        ])->row_array();

        if (!$exists) {
            return $this->output
                ->set_status_header(404)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 404,
                    'message' => 'Cart item not found.',
                    'data' => null
                ]));
        }

        // ✅ Delete item
        $this->db->where('id', $cart_id)->delete('cart_items');

        return $this->output
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'code' => 200,
                'message' => 'Cart item removed successfully.',
                'data' => [
                    'cart_id' => $cart_id,
                    'user_id' => $user_id
                ]
            ]));
    }

    public function pay_booking()
    {
        header('Content-Type: application/json');

        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 401,
                    'message' => 'Invalid token or user not authorized.',
                    'data' => null
                ]));
        }

        $user_id = (int)$decoded->data->id;

        $cart_items = $this->db->get_where('cart_items', ['user_id' => $user_id])->result_array();

        if (!$cart_items) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Your cart is empty.',
                    'data' => null
                ]));
        }

        // ✅ Offer settings
        $offer_setting = $this->db->get('offer_settings')->row();
        $offer_percent = $offer_setting ? floatval($offer_setting->offer_percent) : 0;
        $min_amount_for_offer = $offer_setting ? floatval($offer_setting->min_amount) : 0;

        $subtotal = 0;
        $discount_amount = 0;

        foreach ($cart_items as &$item) {
            $offer = $this->db->where('provider_id', $item['provider_id'])
                ->where('duration', $item['duration'])
                ->where('isActive', 1)
                ->where('valid_till >=', date('Y-m-d'))
                ->get('offers')
                ->row();

            if ($offer) {
                $sets = intval($item['qty'] / $offer->buy_quantity);
                $item['free_qty'] = $sets * $offer->free_quantity;
                $item['total_qty'] = $item['qty'] + $item['free_qty'];
            } else {
                $item['free_qty'] = 0;
                $item['total_qty'] = $item['qty'];
            }

            $item_total = floatval($item['price']) * intval($item['qty']);
            $subtotal += $item_total;

            if ($offer_percent > 0) {
                if ($min_amount_for_offer == 0 || $subtotal >= $min_amount_for_offer) {
                    $item['platform_discount'] = ($item_total * $offer_percent) / 100;
                } else {
                    $item['platform_discount'] = 0;
                }
                $discount_amount += $item['platform_discount'];
            } else {
                $item['platform_discount'] = 0;
            }
        }
        unset($item);

        $total_after_discount = $subtotal - $discount_amount;

        if ($total_after_discount <= 0) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid total amount.',
                    'data' => null
                ]));
        }

        $amount_paise = intval($total_after_discount * 100);
        $txnid = 'TXN' . uniqid();

        // ✅ Create order
        $order_data = [
            'user_id' => $user_id,
            'total' => $total_after_discount,
            'txnid' => $txnid,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('orders', $order_data);
        $order_id = $this->db->insert_id();

        // ✅ Insert order items
        foreach ($cart_items as $item) {
            $item_data = [
                'order_id' => $order_id,
                'provider_id' => $item['provider_id'],
                'name' => trim($item['provider_name']),
                'image' => $item['provider_image'],
                'price' => $item['price'],
                'duration' => $item['duration'],
                'qty' => $item['qty'],
                'free_qty' => $item['free_qty'],
                'total_qty' => $item['total_qty'],
                'start_date' => $item['start_date']
            ];
            $this->db->insert('order_items', $item_data);
        }


        $this->db->where('user_id', $user_id)->delete('cart_items');


        // foreach ($cart_items as $item) {
        //     $provider_token = $this->db->get_where('provider_tokens', ['provider_id' => $item['provider_id']])->row();
        //     if ($provider_token && !empty($provider_token->fcm_token)) {
        //         $title = '🎉 New Booking Received';
        //         $body  = 'You have received a new booking. Please check your dashboard.';
        //         $data  = [
        //             'order_id' => $order_id,
        //             'txnid' => $txnid,
        //             'amount' => $total_after_discount
        //         ];

        //         $this->firebase_messaging->send_to_token($provider_token->fcm_token, $title, $body, $data, $item['provider_id']);
        //     }
        // }

        // ✅ Create Razorpay order
        $razorpayOrder = $this->api->order->create([
            'receipt' => $txnid,
            'amount' => $amount_paise,
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        // ✅ Response
        return $this->output
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'code' => 200,
                'message' => 'Order created successfully.',
                'data' => [
                    'razorpay_key' => $this->razorpay_key_id,
                    'order_id' => $razorpayOrder['id'],
                    'txnid' => $txnid,
                    'order' => $order_id,
                    'amount' => $total_after_discount,
                    'amount_paise' => $amount_paise,
                    'currency' => 'INR',
                    'description' => "Order #$order_id",
                    'cart_items' => $cart_items
                ]
            ]));
    }


    public function callback_booking()
    {
        header('Content-Type: application/json');

        try {

            $input = $this->input->post() ?: json_decode($this->input->raw_input_stream, true);
            file_put_contents(FCPATH . 'callback_log.txt', print_r($input, true), FILE_APPEND);

            if (
                empty($input['razorpay_order_id']) ||
                empty($input['razorpay_payment_id']) ||
                empty($input['razorpay_signature']) ||
                empty($input['txnid'])
            ) {
                throw new Exception('Missing required payment parameters');
            }

            $this->api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $input['razorpay_order_id'],
                'razorpay_payment_id' => $input['razorpay_payment_id'],
                'razorpay_signature'  => $input['razorpay_signature']
            ]);

            // Update order
            $this->db->where('txnid', $input['txnid'])
                ->update('orders', ['status' => 'success']);

            // Get order
            $order = $this->db
                ->get_where('orders', ['txnid' => $input['txnid']])
                ->row();

            if (!$order) {
                throw new Exception('Order not found');
            }

            // Get order items
            $order_items = $this->db
                ->get_where('order_items', ['order_id' => $order->id])
                ->result();

            foreach ($order_items as $item) {

                $this->db->insert('provider_notifications', [
                    'provider_id'   => $item->provider_id,
                    'type'          => 'service',
                    'order_id'      => $order->id,
                    'order_item_id' => $item->id,
                    'title'         => 'New Booking Received',
                    'message'       => 'You have received a new service booking.',
                    'created_at'    => date('Y-m-d H:i:s')
                ]);

                $notification_id = $this->db->insert_id();

                // 🔔 Push notification
                try {
                    $this->send_expo_push(
                        $item->provider_id,
                        'New Booking Received',
                        'You have received a new service booking.',
                        [
                            'type' => 'service',
                            'notification_id' => $notification_id,
                            'order_id' => $order->id,
                            'order_item_id' => $item->id
                        ]
                    );
                } catch (Exception $e) {
                    log_message('error', 'FCM service push failed: ' . $e->getMessage());
                }
            }

            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => true,
                    'message' => 'Payment verified successfully',
                    'data' => [
                        'txnid' => $input['txnid'],
                        'payment_id' => $input['razorpay_payment_id']
                    ]
                ]));
        } catch (Exception $e) {

            $this->db->where('txnid', $input['txnid'] ?? null)
                ->update('orders', ['status' => 'failed']);

            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => $e->getMessage()
                ]));
        }
    }




    public function send_otp_via_sms($mobileNo, $otp)
    {

        $message = "Hi $mobileNo\n\nYour Verification OTP is $otp Do not share this OTP with anyone for security reasons.\n\nRegards\nOMKARENT";



        $params = [

            'user' => 'Fitcketsp',

            'key' => '81a6b2f99cXX',

            'mobile' => '91' . $mobileNo,

            'message' => $message,

            'senderid' => 'OENTER',

            'accusage' => '1',

            'entityid' => '1401487200000053882',

            'tempid' => '1407168611506367587'

        ];



        $url = 'http://mobicomm.dove-sms.com/submitsms.jsp?' . http_build_query($params);



        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);



        if (curl_errno($ch)) {

            log_message('error', 'OTP SMS cURL Error: ' . curl_error($ch));

            curl_close($ch);

            return false;
        }



        curl_close($ch);

        log_message('info', "OTP sent to $mobileNo. Response: $response");

        // echo "<pre>";

        // print_r($response);

        // exit;

        // redirect('provider/dashboard');



        return $response;
    }

    // ============================
    // 📘 TERMS & CONDITIONS API
    // ============================
    public function api_terms_condition()
    {
        header('Content-Type: application/json');

        // ✅ Verify Token
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;
        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'code'    => 400,
                    'message' => 'Invalid or missing token',
                    'data'    => null
                ]));
        }

        $page_data = $this->general_model->getOne('pages', ['slug' => 'terms-condition']);

        if ($page_data) {
            $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => true,
                    'code'    => 200,
                    'message' => 'Terms & Conditions fetched successfully',
                    'data'    => $page_data
                ]));
        } else {
            $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'code'    => 400,
                    'message' => 'No data found',
                    'data'    => null
                ]));
        }
    }

    // ============================
    // 🔒 PRIVACY POLICY API
    // ============================
    public function api_privacy_policy()
    {
        header('Content-Type: application/json');

        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;
        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid or missing token',
                    'data' => null
                ]));
        }

        $page_data = $this->general_model->getOne('pages', ['slug' => 'privacy-policy']);

        if ($page_data) {
            $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Privacy Policy fetched successfully',
                    'data' => $page_data
                ]));
        } else {
            $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'No data found',
                    'data' => null
                ]));
        }
    }

    // ============================
    // 💸 REFUND POLICY API
    // ============================
    public function api_refund_policy()
    {
        header('Content-Type: application/json');

        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;
        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid or missing token',
                    'data' => null
                ]));
        }

        $page_data = $this->general_model->getOne('pages', ['slug' => 'refund-policy']);

        if ($page_data) {
            $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Refund Policy fetched successfully',
                    'data' => $page_data
                ]));
        } else {
            $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'No data found',
                    'data' => null
                ]));
        }
    }


    public function api_submit_query()
    {
        header('Content-Type: application/json');

        /* ================= JWT AUTH ================= */
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);

        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'code'    => 400,
                    'message' => 'Invalid or missing token',
                    'data'    => null
                ]));
        }

        /* ================= RAW JSON INPUT ================= */
        $input = json_decode($this->input->raw_input_stream, true);

        if (!is_array($input)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'code'    => 400,
                    'message' => 'Invalid JSON format',
                    'data'    => null
                ]));
        }

        /* ================= DATA ================= */
        $data = [
            'user_id'       => $decoded->data->id,
            'gym_name'      => trim($input['gym_name'] ?? ''),
            'mobile_number' => trim($input['mobile_number'] ?? ''),
            'description'   => trim($input['description'] ?? ''),
        ];

        /* ================= VALIDATION ================= */
        if (
            empty($data['gym_name']) ||
            empty($data['mobile_number']) ||
            empty($data['description'])
        ) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'code'    => 400,
                    'message' => 'Gym name, mobile number and description are required',
                    'data'    => null
                ]));
        }

        /* ================= INSERT ================= */
        $this->db->insert('contact_queries', $data);

        if ($this->db->affected_rows() > 0) {

            $insert_id = $this->db->insert_id();

            /* ================= RESPONSE DATA ================= */
            $responseData = [
                'id'            => $insert_id,
                'user_id'       => $data['user_id'],
                'gym_name'      => $data['gym_name'],
                'mobile_number' => $data['mobile_number'],
                'description'   => $data['description'],
                'created_at'    => date('Y-m-d H:i:s')
            ];

            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => true,
                    'code'    => 200,
                    'message' => 'Submitted successfully',
                    'data'    => $responseData
                ]));
        }

        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Failed to submit',
                'data'    => null
            ]));
    }


    private function verify_jwt($token)
    {
        if (empty($token)) {
            $this->output
                ->set_status_header(401)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Authorization header missing or invalid',
                    'data' => null
                ]))
                ->_display();
            exit;
        }

        try {
            $decoded = JWT::decode($token, new Key($this->jwt_secret, 'HS256'));

            $query = $this->db->get_where('token_blacklist', ['token' => $token]);
            if ($query->num_rows() > 0) {
                $this->output
                    ->set_status_header(401)
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'status' => false,
                        'code' => 400,
                        'message' => 'Token has been invalidated. Please log in again.',
                        'data' => null
                    ]))
                    ->_display();
                exit;
            }

            return $decoded;
        } catch (Exception $e) {
            $this->output
                ->set_status_header(401)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token: ' . $e->getMessage(),
                    'data' => null
                ]))
                ->_display();
            exit;
        }
    }
    public function profile()
    {
        header('Content-Type: application/json');

        // ✅ Check Authorization header
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        // ✅ Verify JWT
        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = $decoded->data->id;

        // ✅ Fetch user details
        $user = $this->general_model->getOne('users', ['id' => $user_id]);
        if (empty($user)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'User not found',
                    'data' => null
                ]));
        }

        // ✅ Fetch booking count
        $booking_count = $this->general_model->getCount('orders', ['user_id' => $user_id]);

        // ✅ Fetch bank account count (for providers)
        $bank_account_count = $this->general_model->getCount('provider_bank_details', ['provider_id' => $user_id]);

        // ✅ Prepare response
        $response = [
            'status' => true,
            'code' => 200,
            'message' => 'Profile fetched successfully',
            'data' => [
                'user' => $user,
                'booking_count' => $booking_count,
                'bank_account_count' => $bank_account_count
            ]
        ];

        return $this->output
            ->set_status_header(200)
            ->set_output(json_encode($response));
    }

    public function edit_profile()
    {
        header('Content-Type: application/json');

        // ✅ Check Authorization header
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        // ✅ Verify JWT
        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = $decoded->data->id;

        // ✅ Fetch user details
        $user = $this->general_model->getOne('users', ['id' => $user_id]);

        if (!$user) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'User not found',
                    'data' => null
                ]));
        }

        // ✅ Add full image URL if available
        $user->profile_image = !empty($user->profile_image)
            ? base_url($user->profile_image)
            : base_url('assets/images/9334234.jpg');

        // ✅ Send user data
        return $this->output
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'code' => 200,
                'message' => 'User profile fetched successfully',
                'data' => $user
            ]));
    }
    public function update_profile()
    {
        header('Content-Type: application/json');

        // ✅ Check Authorization header
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        // ✅ Verify JWT
        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = $decoded->data->id;
        // ✅ Get Form Data
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $mobile = $this->input->post('mobile');

        // // ✅ Validate required fields
        // if (empty($name) || empty($email) || empty($mobile)) {
        //     return $this->output
        //         ->set_status_header(400)
        //         ->set_output(json_encode([
        //             'status' => false,
        //             'message' => 'All fields (name, email, mobile) are required.'
        //         ]));
        // }

        $exists = $this->db->where('mobile', $mobile)
            ->where('id !=', $user_id)
            ->get('users')
            ->num_rows();

        if ($exists > 0) {
            return $this->output
                ->set_status_header(409)
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Mobile number already exists for another user.'
                ]));
        }

        // ✅ Handle Image Upload (if provided)
        $profile_image = null;
        if (!empty($_FILES['profile_image']['name'])) {

            $config['upload_path'] = './uploads/profile/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['file_name'] = 'profile_' . time();

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('profile_image')) {
                return $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode([
                        'status' => false,
                        'message' => $this->upload->display_errors('', '')
                    ]));
            } else {
                $upload_data = $this->upload->data();
                $profile_image = 'uploads/profile/' . $upload_data['file_name'];
            }
        }

        // ✅ Prepare Update Data
        $update_data = [
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile
        ];

        if ($profile_image) {
            $update_data['profile_image'] = $profile_image;
        }

        // ✅ Update Profile
        $this->db->where('id', $user_id);
        $updated = $this->db->update('users', $update_data);

        if ($updated) {
            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status' => true,
                    'message' => 'Profile updated successfully.',
                    'data' => $update_data
                ]));
        } else {
            return $this->output
                ->set_status_header(500)
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Failed to update profile.'
                ]));
        }
    }
    public function bank_accounts()
    {
        header('Content-Type: application/json');

        // ✅ Auth check
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = $decoded->data->id;

        $accounts = $this->db
            ->where('provider_id', $user_id)
            ->order_by('id', 'DESC')
            ->get('provider_bank_details')
            ->result();

        if (empty($accounts)) {
            return $this->output
                ->set_status_header(404)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'No bank accounts found',
                    'data' => []
                ]));
        }

        return $this->output
            ->set_output(json_encode([
                'status' => true,
                'code' => 200,
                'message' => 'Bank accounts fetched successfully',
                'data' => $accounts
            ]));
    }

    public function save_bank_account()
    {
        header('Content-Type: application/json');

        // ✅ Auth check
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = $decoded->data->id;


        $input_data = json_decode($this->input->raw_input_stream, true);
        if (empty($input_data)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid input data',
                    'data' => null
                ]));
        }

        $id = $input_data['id'] ?? null;

        $data = [
            'provider_id' => $user_id,
            'account_holder_name' => $input_data['account_holder_name'] ?? '',
            'bank_name' => $input_data['bank_name'] ?? '',
            'account_number' => $input_data['account_number'] ?? '',
            'ifsc_code' => strtoupper($input_data['ifsc_code'] ?? ''),
            'account_type' => $input_data['account_type'] ?? '',
            'branch_name' => $input_data['branch_name'] ?? ''
        ];

        foreach ($data as $key => $val) {
            if ($key != 'branch_name' && empty($val)) {
                return $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode([
                        'status' => false,
                        'code' => 400,
                        'message' => ucfirst(str_replace('_', ' ', $key)) . ' is required',
                        'data' => null
                    ]));
            }
        }

        if ($id) {
            $exists = $this->db->where('id', $id)->where('provider_id', $user_id)->get('provider_bank_details')->row();
            if (!$exists) {
                return $this->output
                    ->set_status_header(404)
                    ->set_output(json_encode([
                        'status' => false,
                        'code' => 400,
                        'message' => 'Record not found for update',
                        'data' => null
                    ]));
            }

            $this->db->where('id', $id)->update('provider_bank_details', $data);
            $message = 'Bank details updated successfully';
        } else {
            // ✅ Insert
            $this->db->insert('provider_bank_details', $data);
            $message = 'Bank details added successfully';
        }

        return $this->output
            ->set_output(json_encode([
                'status' => true,
                'code' => 200,
                'message' => $message,
                'data' => $data
            ]));
    }

    // 🔹 (3) Delete Bank Account
    public function delete_bank_account($id)
    {
        header('Content-Type: application/json');

        // ✅ Auth check
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Invalid token or user ID missing',
                    'data' => null
                ]));
        }

        $user_id = $decoded->data->id;

        $deleted = $this->db->where('id', $id)
            ->where('provider_id', $user_id)
            ->delete('provider_bank_details');

        if ($deleted) {
            return $this->output
                ->set_output(json_encode([
                    'status' => true,
                    'code' => 200,
                    'message' => 'Bank account deleted successfully'
                ]));
        } else {
            return $this->output
                ->set_status_header(404)
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => 'Record not found or already deleted'
                ]));
        }
    }
    private function generate_jwt($user)
    {
        $payload = [
            'iss' => base_url(),
            'iat' => time(),
            'exp' => time() + (10 * 365 * 24 * 60 * 60),
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email ?? '',
                'mobile' => $user->mobile,
                'store_name' => $user->gym_name ?? '',
                'role' => $user->role ?? '0'
            ]
        ];

        return JWT::encode($payload, $this->jwt_secret, 'HS256');
    }


    /**
     * GET /api/sessions/fetch_sessions
     * Fetch all public live sessions with pagination
     */
    public function fetch_sessions()
    {
        header('Content-Type: application/json');
        // echo "h";
        // die;
        /* -------------------------
       JWT AUTHENTICATION
    ------------------------- */
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status'  => false,
                    'code'    => 401,
                    'message' => 'Invalid token or user ID missing',
                    'data'    => null
                ]));
        }

        $user_id = (int) $decoded->data->id;

        /* -------------------------
       PAGINATION
    ------------------------- */
        $page = (int) ($this->input->get('page') ?? 1);
        if ($page < 1) {
            $page = 1;
        }

        $limit  = 10;
        $offset = ($page - 1) * $limit;

        /* -------------------------
       CURRENT DATE & TIME
    ------------------------- */
        $current_date = date('Y-m-d');
        $current_time = date('H:i:s');

        /* -------------------------
       FETCH UPCOMING PUBLIC SESSIONS
    ------------------------- */
        $this->db->select('
        ls.id,
        ls.provider_id,
        ls.title,
        ls.description,
        ls.thumbnail,
        ls.session_date,
        ls.start_time,
        ls.end_time,
        ls.price,
        ls.max_participants,
        ls.current_participants,
        ls.is_full,
        ls.session_type,
        ls.status,
        ls.room_id,
        ls.created_at,
        u.gym_name AS provider_name,
        p.profile_image AS provider_image
    ');
        $this->db->from('live_sessions ls');
        $this->db->join('users u', 'u.id = ls.provider_id', 'left');
        $this->db->join('provider p', 'p.provider_id = ls.provider_id', 'left');

        // Filter: Not cancelled
        $this->db->where('ls.status !=', 'cancelled');

        /* -------------------------
       UPCOMING SESSIONS FILTER
    ------------------------- */
        $this->db->group_start();
        $this->db->where('ls.session_date >', $current_date);
        $this->db->or_group_start();
        $this->db->where('ls.session_date', $current_date);
        $this->db->where('ls.start_time >=', $current_time);
        $this->db->group_end();
        $this->db->group_end();

        // Order by nearest upcoming first
        $this->db->order_by('ls.session_date', 'ASC');
        $this->db->order_by('ls.start_time', 'ASC');

        /* -------------------------
       COUNT (Pagination Total)
    ------------------------- */
        $total = $this->db->count_all_results('', false);

        /* -------------------------
       LIMIT + FETCH DATA
    ------------------------- */
        $this->db->limit($limit, $offset);
        $sessions = $this->db->get()->result();

        /* -------------------------
       IMAGE FIX + BOOKING STATUS + AVAILABILITY
    ------------------------- */
        foreach ($sessions as &$session) {

            // ✅ Thumbnail (single field, URL only)
            $session->thumbnail = !empty($session->thumbnail)
                ? base_url('uploads/session_thumbnails/' . $session->thumbnail)
                : base_url('uploads/default_session.png');
            unset($session->thumbnail);

            // ✅ Provider image
            $session->provider_image = !empty($session->provider_image)
                ? base_url($session->provider_image)
                : base_url('uploads/default.png');

            // ✅ Check if user has already booked
            $booked = $this->db->get_where('session_orders', [
                'user_id'    => $user_id,
                'session_id' => $session->id,
                'status'     => 'success'
            ])->row();

            $session->is_booked = $booked ? true : false;
            $session->is_free   = ($session->price <= 0) ? true : false;

            // ✅ Get real-time availability
            $availability = $this->Live_session_model->checkAvailability($session->id);

            $session->availability = [
                'is_available'     => $availability['available'],
                'booked_count'     => $availability['booked_count'],
                'max_participants' => $availability['max_participants'],
                'available_spots'  => $availability['available_spots'],
                'is_full'          => $availability['is_full']
            ];

            // ✅ Booking status
            if ($session->is_booked) {
                $session->booking_status = 'already_booked';
                $session->can_book = false;
            } elseif ($availability['is_full']) {
                $session->booking_status = 'fully_booked';
                $session->can_book = false;
            } else {
                $session->booking_status = 'available';
                $session->can_book = true;
            }

            // ✅ Time remaining
            $session_datetime = $session->session_date . ' ' . $session->start_time;
            $session->starts_in = $this->getTimeRemaining($session_datetime);

            // ✅ Session type label
            $session->session_type_label = ($session->session_type === 'group')
                ? 'Group Session'
                : 'One-on-One';
        }

        /* -------------------------
       RESPONSE
    ------------------------- */
        echo json_encode([
            'status'   => true,
            'code'     => 200,
            'message'  => 'Upcoming sessions fetched successfully',
            'total'    => $total,
            'limit'    => $limit,
            'page'     => $page,
            'sessions' => $sessions
        ]);
    }


    /**
     * Helper function to calculate time remaining
     */
    private function getTimeRemaining($datetime)
    {
        $now = new DateTime();
        $session_time = new DateTime($datetime);

        if ($session_time <= $now) {
            return 'Starting soon';
        }

        $interval = $now->diff($session_time);

        if ($interval->days > 0) {
            return $interval->days . ' day(s) ' . $interval->h . ' hour(s)';
        } elseif ($interval->h > 0) {
            return $interval->h . ' hour(s) ' . $interval->i . ' min(s)';
        } else {
            return $interval->i . ' minute(s)';
        }
    }

    public function session_pay()
    {
        header('Content-Type: application/json');

        /* -------------------------
       JWT AUTH
    ------------------------- */
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code'   => 400,
                    'message' => 'Invalid token',
                    'data'   => null
                ]));
        }

        $user_id = (int) $decoded->data->id;
        $session_id = (int) $this->input->post('session_id');

        if (!$session_id) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code'   => 400,
                    'message' => 'Session ID required',
                    'data'   => null
                ]));
        }

        /* -------------------------
       SESSION DETAILS
    ------------------------- */
        $session = $this->Live_session_model->getSessionById($session_id);

        if (!$session) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code'   => 400,
                    'message' => 'Session not found',
                    'data'   => null
                ]));
        }

        /* -------------------------
       ALREADY BOOKED?
    ------------------------- */
        $exists = $this->db->get_where('session_orders', [
            'user_id'    => $user_id,
            'session_id' => $session_id,
            'status'     => 'success'
        ])->row();

        if ($exists) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code'   => 400,
                    'message' => 'You have already booked this session',
                    'data'   => null
                ]));
        }

        /* -------------------------
       ✅ CHECK AVAILABILITY
    ------------------------- */
        $availability = $this->Live_session_model->checkAvailability($session_id);

        if (!$availability['available']) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code'   => 400,
                    'message' => 'Sorry, this session is fully booked',
                    'data'   => [
                        'is_full' => true,
                        'booked_count' => $availability['booked_count'],
                        'max_participants' => $availability['max_participants']
                    ]
                ]));
        }

        /* -------------------------
       ✅ GENERATE UNIQUE AGORA UID
    ------------------------- */
        $agora_uid = $this->generateAgoraUID($user_id, $session_id);

        /* -------------------------
       FREE SESSION
    ------------------------- */
        if ($session['price'] <= 0) {

            $txnid = 'SESF' . uniqid();

            // ✅ Use transaction to prevent race conditions
            $this->db->trans_start();

            // Double-check availability within transaction
            $availability = $this->Live_session_model->checkAvailability($session_id);

            if (!$availability['available']) {
                $this->db->trans_complete();
                return $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode([
                        'status' => false,
                        'code'   => 400,
                        'message' => 'Session was just fully booked',
                        'data'   => null
                    ]));
            }

            $this->db->insert('session_orders', [
                'user_id'     => $user_id,
                'session_id'  => $session['id'],
                'provider_id' => $session['provider_id'],
                'amount'      => 0,
                'agora_uid'   => $agora_uid,
                'txnid'       => $txnid,
                'status'      => 'success',
                'created_at'  => date('Y-m-d H:i:s')
            ]);

            $order_id = $this->db->insert_id();

            // ✅ Increment participant count
            $this->Live_session_model->incrementParticipantCount($session_id);

            // ✅ Send notification to provider
            $this->db->insert('provider_notifications', [
                'provider_id'      => $session['provider_id'],
                'type'             => 'session',
                'session_order_id' => $order_id,
                'title'            => 'New Free Session Booked',
                'message'          => 'A user has booked your free live session.',
                'created_at'       => date('Y-m-d H:i:s')
            ]);

            $notification_id = $this->db->insert_id();

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                return $this->output
                    ->set_status_header(500)
                    ->set_output(json_encode([
                        'status' => false,
                        'code'   => 500,
                        'message' => 'Booking failed. Please try again.',
                        'data'   => null
                    ]));
            }

            // ✅ Send push notification
            try {
                $this->send_expo_push(
                    $session['provider_id'],
                    'New Free Session Booked',
                    'A user has booked your free live session.',
                    [
                        'type' => 'session',
                        'notification_id' => $notification_id,
                        'session_order_id' => $order_id
                    ]
                );
            } catch (Exception $e) {
                log_message('error', '❌ PUSH FAILED: ' . $e->getMessage());
            }

            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status' => true,
                    'code'   => 200,
                    'message' => 'Free session booked successfully',
                    'data'   => [
                        'is_free'   => true,
                        'txnid'     => $txnid,
                        'order_id'  => $order_id,
                        'agora_uid' => $agora_uid
                    ]
                ]));
        }

        /* -------------------------
       PAID SESSION
    ------------------------- */
        $amount_paise = (int) ($session['price'] * 100);
        $txnid = 'SES' . uniqid();

        // ✅ Use transaction
        $this->db->trans_start();

        // Double-check availability
        $availability = $this->Live_session_model->checkAvailability($session_id);

        if (!$availability['available']) {
            $this->db->trans_complete();
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'code'   => 400,
                    'message' => 'Session was just fully booked',
                    'data'   => null
                ]));
        }

        $this->db->insert('session_orders', [
            'user_id'     => $user_id,
            'session_id'  => $session['id'],
            'provider_id' => $session['provider_id'],
            'amount'      => $session['price'],
            'agora_uid'   => $agora_uid,
            'txnid'       => $txnid,
            'status'      => 'pending',
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        $order_id = $this->db->insert_id();

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return $this->output
                ->set_status_header(500)
                ->set_output(json_encode([
                    'status' => false,
                    'code'   => 500,
                    'message' => 'Booking failed. Please try again.',
                    'data'   => null
                ]));
        }

        /* -------------------------
       RAZORPAY ORDER
    ------------------------- */
        try {
            $razorpayOrder = $this->api->order->create([
                'receipt' => $txnid,
                'amount'  => $amount_paise,
                'currency' => 'INR',
                'payment_capture' => 1
            ]);
        } catch (Exception $e) {
            // Rollback order if Razorpay fails
            $this->db->where('id', $order_id)->delete('session_orders');

            return $this->output
                ->set_status_header(500)
                ->set_output(json_encode([
                    'status' => false,
                    'code'   => 500,
                    'message' => 'Payment gateway error. Please try again.',
                    'data'   => null
                ]));
        }

        return $this->output
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'code'   => 200,
                'message' => 'Session payment initiated',
                'data'   => [
                    'razorpay_key' => $this->razorpay_key_id,
                    'order_id'     => $razorpayOrder['id'],
                    'txnid'        => $txnid,
                    'amount'       => $amount_paise,
                    'currency'     => 'INR',
                    'agora_uid'    => $agora_uid,
                    'session'      => [
                        'id'    => $session['id'],
                        'title' => $session['title']
                    ]
                ]
            ]));
    }

    /**
     * ✅ Generate unique Agora UID
     */
    private function generateAgoraUID($user_id, $session_id)
    {
        // Combine user_id and session_id to create unique UID
        // Keep within Agora's 32-bit unsigned integer limit
        $combined = intval($user_id . str_pad($session_id % 10000, 4, '0', STR_PAD_LEFT));

        // Ensure it's positive and within limit
        return abs($combined) % 2147483647;
    }


    public function session_payment_callback()
    {
        header('Content-Type: application/json');

        log_message('info', '💡 SESSION CALLBACK START');

        try {
            $input = $this->input->post() ?: json_decode($this->input->raw_input_stream, true);
            log_message('info', '💡 INPUT RECEIVED: ' . json_encode($input));

            if (
                empty($input['razorpay_order_id']) ||
                empty($input['razorpay_payment_id']) ||
                empty($input['razorpay_signature']) ||
                empty($input['txnid'])
            ) {
                log_message('error', '❌ MISSING PAYMENT PARAMETERS');
                throw new Exception('Missing payment parameters');
            }

            log_message('info', '💡 VERIFYING PAYMENT SIGNATURE');
            $this->api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $input['razorpay_order_id'],
                'razorpay_payment_id' => $input['razorpay_payment_id'],
                'razorpay_signature'  => $input['razorpay_signature']
            ]);
            log_message('info', '✅ PAYMENT SIGNATURE VERIFIED');

            /* ================= ✅ START TRANSACTION ================= */
            $this->db->trans_start();

            /* ================= UPDATE ORDER STATUS ================= */
            $this->db->where('txnid', $input['txnid'])
                ->update('session_orders', [
                    'status' => 'success'
                    //  'paid_at' => date('Y-m-d H:i:s')
                ]);
            log_message('info', '✅ SESSION ORDER STATUS UPDATED TO SUCCESS');

            /* ================= FETCH ORDER ================= */
            $order = $this->db
                ->get_where('session_orders', ['txnid' => $input['txnid']])
                ->row();

            if (!$order) {
                log_message('error', '❌ SESSION ORDER NOT FOUND: ' . $input['txnid']);
                throw new Exception('Session order not found');
            }
            log_message('info', '💡 ORDER FETCHED: ' . $order->id);

            /* ================= ✅ INCREMENT PARTICIPANT COUNT ================= */
            $this->Live_session_model->incrementParticipantCount($order->session_id);
            log_message('info', '✅ PARTICIPANT COUNT INCREMENTED FOR SESSION: ' . $order->session_id);

            /* ================= FETCH SESSION & PROVIDER ================= */
            $session = $this->db
                ->select('provider_id, title')
                ->get_where('live_sessions', ['id' => $order->session_id])
                ->row();

            if (!$session || empty($session->provider_id)) {
                log_message('error', '❌ PROVIDER NOT FOUND FOR SESSION ORDER ID: ' . $order->id);
                throw new Exception('Provider not mapped to session');
            }
            $provider_id = $session->provider_id;
            log_message('info', '💡 PROVIDER FOUND: ' . $provider_id);

            /* ================= SAVE NOTIFICATION ================= */
            $this->db->insert('provider_notifications', [
                'provider_id'      => $provider_id,
                'type'             => 'session',
                'session_order_id' => $order->id,
                'title'            => 'New Session Booked',
                'message'          => 'A user has booked your live session: ' . $session->title,
                'created_at'       => date('Y-m-d H:i:s')
            ]);
            $notification_id = $this->db->insert_id();
            log_message('info', '✅ PROVIDER NOTIFICATION SAVED: ' . $notification_id);

            /* ================= ✅ PROVIDER WALLET UPDATE (20% COMMISSION) ================= */
            $commission_rate = 20;
            $commission = ($order->amount * $commission_rate) / 100;
            $provider_amount = $order->amount - $commission;

            $wallet = $this->db->get_where('provider_wallet', [
                'provider_id' => $provider_id
            ])->row();

            if ($wallet) {
                $this->db->where('provider_id', $provider_id)
                    ->update('provider_wallet', [
                        'balance' => $wallet->balance + $provider_amount
                    ]);
            } else {
                $this->db->insert('provider_wallet', [
                    'provider_id' => $provider_id,
                    'balance' => $provider_amount
                ]);
            }
            log_message('info', '✅ PROVIDER WALLET UPDATED: +' . $provider_amount);

            /* ================= SAVE PAYMENT LOG ================= */
            $this->db->insert('session_payments', [
                'order_id' => $order->id,
                'razorpay_payment_id' => $input['razorpay_payment_id'],
                'amount' => $order->amount,
                'commission' => $commission,
                'provider_amount' => $provider_amount,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            log_message('info', '✅ PAYMENT LOG SAVED');

            /* ================= ✅ COMMIT TRANSACTION ================= */
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                log_message('error', '❌ TRANSACTION FAILED');
                throw new Exception('Transaction failed');
            }

            /* ================= PUSH NOTIFICATION ================= */
            try {
                log_message('info', '💡 SENDING PUSH NOTIFICATION');
                $push_result = $this->send_expo_push(
                    $provider_id,
                    'New Session Booked',
                    'A user has booked your live session: ' . $session->title,
                    [
                        'type' => 'session',
                        'notification_id' => $notification_id,
                        'session_order_id' => $order->id
                    ]
                );

                log_message('info', '📦 PUSH RESULT: ' . json_encode([
                    'provider_id' => $provider_id,
                    'session_order_id' => $order->id,
                    'push_success' => $push_result
                ]));
            } catch (Exception $e) {
                log_message('error', '❌ PUSH FAILED: ' . $e->getMessage());
            }

            log_message('info', '💡 SESSION CALLBACK END SUCCESS');

            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => true,
                    'code'    => 200,
                    'message' => 'Session payment verified successfully',
                    'data' => [
                        'txnid' => $input['txnid'],
                        'payment_id' => $input['razorpay_payment_id'],
                        'order_id' => $order->id,
                        'agora_uid' => $order->agora_uid
                    ]
                ]));
        } catch (Exception $e) {

            // Rollback on error
            if (isset($this->db) && $this->db->trans_status() !== null) {
                $this->db->trans_rollback();
            }

            if (!empty($input['txnid'])) {
                $this->db->where('txnid', $input['txnid'])
                    ->update('session_orders', ['status' => 'failed']);
                log_message('error', '❌ SESSION ORDER STATUS SET TO FAILED: ' . $input['txnid']);
            }

            log_message('error', '❌ SESSION CALLBACK FAILED: ' . $e->getMessage());

            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'code'    => 400,
                    'message' => $e->getMessage()
                ]));
        }
    }



    /**
     * ✅ Get user's booked sessions
     */
    public function my_booked_sessions()
    {
        header('Content-Type: application/json');

        /* -------------------------
       JWT AUTH
    ------------------------- */
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status'  => false,
                    'code'    => 401,
                    'message' => 'Invalid token',
                    'data'    => null
                ]));
        }

        $user_id = (int) $decoded->data->id;

        /* -------------------------
       FETCH BOOKED SESSIONS
    ------------------------- */
        $sessions = $this->db
            ->select('
            so.id as order_id,
            so.txnid,
            so.amount,
            so.status as payment_status,
            so.agora_uid,
            so.created_at as booked_at,
            ls.id as session_id,
            ls.title,
            ls.description,
            ls.session_date,
            ls.start_time,
            ls.end_time,
            ls.duration_minutes,
            ls.status as session_status,
            ls.room_id,
            ls.thumbnail,
            ls.max_participants,
            ls.session_type,
            u.gym_name as provider_name,
            p.profile_image as provider_image
        ')
            ->from('session_orders so')
            ->join('live_sessions ls', 'ls.id = so.session_id', 'left')
            ->join('users u', 'u.id = so.provider_id', 'left')
            ->join('provider p', 'p.provider_id = so.provider_id', 'left')
            ->where('so.user_id', $user_id)
            ->where('so.status', 'success')
            ->order_by('ls.session_date', 'ASC')
            ->order_by('ls.start_time', 'ASC')
            ->get()
            ->result();

        /* -------------------------
       FORMAT SESSIONS
    ------------------------- */
        foreach ($sessions as &$session) {
            $session->thumbnail = !empty($session->thumbnail)
                ? base_url('uploads/session_thumbnails/' . $session->thumbnail)
                : base_url('uploads/default_session.png');

            $session->provider_image = !empty($session->provider_image)
                ? base_url($session->provider_image)
                : base_url('uploads/default.png');

            // Calculate time until session
            $session_datetime = $session->session_date . ' ' . $session->start_time;
            $session->starts_in = $this->getTimeRemaining($session_datetime);

            // Can join?
            $session->can_join = ($session->session_status == 'live');

            // Session type label
            $session->session_type_label = ($session->session_type == 'group') ? 'Group Session' : 'One-on-One';
        }

        return $this->output
            ->set_status_header(200)
            ->set_output(json_encode([
                'status'  => true,
                'code'    => 200,
                'message' => 'Booked sessions fetched successfully',
                'total'   => count($sessions),
                'sessions' => $sessions
            ]));
    }

    public function session_start_reminder_cron()
    {
        log_message('info', '⏰ SESSION REMINDER CRON START');

        $now = date('Y-m-d H:i:s');


        // Calculate the time window (14-16 minutes from now)
        $reminder_start = date('Y-m-d H:i:s', strtotime('+14 minutes'));
        $reminder_end = date('Y-m-d H:i:s', strtotime('+16 minutes'));
        // echo $now;

        // echo $reminder_start;
        // echo $reminder_end;
        // die;

        $sessions = $this->db->query("
        SELECT 
            so.id AS order_id,
            so.user_id,
            so.session_id,
            ls.title AS session_title,
            CONCAT(ls.session_date, ' ', ls.start_time) AS session_start
        FROM session_orders so
        JOIN live_sessions ls ON ls.id = so.session_id
        WHERE so.status = 'success'
        AND ls.status = 'scheduled'
        AND CONCAT(ls.session_date, ' ', ls.start_time) BETWEEN ? AND ?
    ", [$reminder_start, $reminder_end])->result();

        log_message('info', '📊 SESSIONS FOUND: ' . count($sessions));

        if (empty($sessions)) {
            // echo "h";
            // die;
            log_message('info', '⏰ NO SESSIONS TO REMIND');
            return;
        }

        foreach ($sessions as $s) {

            // Prevent duplicate notification
            $alreadySent = $this->db
                ->where('user_id', $s->user_id)
                ->where('session_id', $s->session_id)
                ->where('type', 'session_reminder')
                ->where('DATE(created_at) = CURDATE()', NULL, FALSE)
                ->get('user_notifications')
                ->row();

            if ($alreadySent) {
                log_message('info', '⏭️ REMINDER ALREADY SENT - User: ' . $s->user_id . ', Session: ' . $s->session_id);
                continue;
            }

            // Save notification
            $this->db->insert('user_notifications', [
                'user_id' => $s->user_id,
                'type' => 'session_reminder',
                'session_id' => $s->session_id,
                'title' => 'Session Starting Soon',
                'message' => 'Your session "' . $s->session_title . '" will start in 15 minutes. Please be ready.',
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $notification_id = $this->db->insert_id();
            log_message('info', '✅ NOTIFICATION SAVED - ID: ' . $notification_id);

            // Push
            try {
                $push_result = $this->send_expo_push(
                    $s->user_id,
                    'Session Starting Soon',
                    'Your session "' . $s->session_title . '" will start in 15 minutes. Please be ready.',
                    [
                        'type' => 'session_reminder',
                        'session_id' => $s->session_id,
                        'order_id' => $s->order_id,
                        'notification_id' => $notification_id
                    ]
                );

                log_message('info', '✅ PUSH SENT - User: ' . $s->user_id . ', Result: ' . json_encode($push_result));
            } catch (Exception $e) {
                log_message('error', '❌ PUSH FAILED - User: ' . $s->user_id . ', Error: ' . $e->getMessage());
            }
        }

        log_message('info', '⏰ SESSION REMINDER CRON END - Total Reminders Sent: ' . count($sessions));
    }

    public function join_session($session_id)
    {
        header('Content-Type: application/json');

        /* -------------------------
       JWT AUTHENTICATION
    ------------------------- */
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status'  => false,
                    'code'    => 401,
                    'message' => 'Invalid token or user not authorized',
                    'data'    => null
                ]));
        }

        $user_id    = (int) $decoded->data->id;
        $session_id = (int) $session_id;

        if (!$session_id) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => 'Session ID is required',
                    'data'    => null
                ]));
        }



        /* -------------------------
       SESSION DETAILS
    ------------------------- */
        $session = $this->Live_session_model->getSessionById($session_id);

        if (!$session) {
            return $this->output
                ->set_status_header(404)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => 'Session not found',
                    'data'    => null
                ]));
        }
        /* -------------------------
       VERIFY BOOKING
    ------------------------- */
        $booking = $this->db->get_where('session_orders', [
            'user_id'    => $user_id,
            'session_id' => $session_id,
            'status'     => 'success'
        ])->row();

        if (!$booking) {
            return $this->output
                ->set_status_header(403)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => 'You have not booked this session',
                    'data'    => null
                ]));
        }
        if ($session['status'] !== 'live') {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => 'Session is not live yet',
                    'data'    => ['session_status' => $session['status']]
                ]));
        }

        /* -------------------------
       AGORA TOKEN
    ------------------------- */
        $this->load->library('Agora_lib');

        $agora_uid   = (int) $booking->agora_uid;
        $agora_token = $this->agora_lib->generateToken(
            $session['room_id'],
            $agora_uid,
            Agora_lib::ROLE_SUBSCRIBER,
            7200
        );

        /* -------------------------
       ATTENDANCE LOG
    ------------------------- */
        $exists = $this->db->get_where('session_attendance', [
            'session_id' => $session_id,
            'user_id'    => $user_id,
            'left_at'    => null
        ])->row();

        if (!$exists) {
            $this->db->insert('session_attendance', [
                'order_id'   => $booking->id,
                'session_id' => $session_id,
                'user_id'    => $user_id,
                'joined_at'  => date('Y-m-d H:i:s')
            ]);
        }

        $user = $this->db->get_where('users', ['id' => $user_id])->row();

        return $this->output
            ->set_status_header(200)
            ->set_output(json_encode([
                'status'  => true,
                'message' => 'Session joined successfully',
                'data'    => [
                    'agora' => [
                        'app_id'  => $this->agora_lib->getAppID(),
                        'token'   => $agora_token,
                        'channel' => $session['room_id'],
                        'uid'     => $agora_uid
                    ],
                    'session' => [
                        'id'     => $session['id'],
                        'title'  => $session['title'],
                        'status' => $session['status']
                    ],
                    'user' => [
                        'id'   => $user_id,
                        'name' => $user->name
                    ]
                ]
            ]));
    }

    public function leave_session($session_id)
    {
        header('Content-Type: application/json');

        /* -------------------------
       JWT AUTH
    ------------------------- */
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Invalid token',
                    'data' => null
                ]));
        }

        $user_id    = (int) $decoded->data->id;
        $session_id = (int) $session_id;

        if (!$session_id) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Session ID required',
                    'data' => null
                ]));
        }

        $this->db->where([
            'session_id' => $session_id,
            'user_id'    => $user_id,
            'left_at'    => null
        ])->update('session_attendance', [
            'left_at' => date('Y-m-d H:i:s')
        ]);

        if ($this->db->affected_rows() > 0) {
            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status' => true,
                    'message' => 'Session left successfully',
                    'data' => [
                        'session_id' => $session_id,
                        'left_at' => date('Y-m-d H:i:s')
                    ]
                ]));
        }

        return $this->output
            ->set_status_header(404)
            ->set_output(json_encode([
                'status' => false,
                'message' => 'No active session found',
                'data' => null
            ]));
    }
    public function get_review($provider_id)
    {
        header('Content-Type: application/json');

        /* -------------------------
       JWT AUTH
    ------------------------- */
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => 'Unauthorized'
                ]));
        }

        $user_id     = (int) $decoded->data->id;
        $provider_id = (int) $provider_id;

        $review = $this->db
            ->where('user_id', $user_id)
            ->where('provider_id', $provider_id)
            ->get('reviews')
            ->row();

        if ($review) {
            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status' => true,
                    'exists' => true,
                    'data'   => $review
                ]));
        }

        return $this->output
            ->set_status_header(200)
            ->set_output(json_encode([
                'status' => true,
                'exists' => false
            ]));
    }
    public function save_review()
    {
        header('Content-Type: application/json');

        /* -------------------------
       JWT AUTH
    ------------------------- */
        $authHeader = $this->input->get_request_header('Authorization', TRUE);
        $token = null;

        if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);
        if (!$decoded || empty($decoded->data->id)) {
            return $this->output
                ->set_status_header(401)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => 'Unauthorized'
                ]));
        }

        $user_id = (int) $decoded->data->id;

        /* -------------------------
       READ RAW JSON INPUT
    ------------------------- */
        $input = json_decode($this->input->raw_input_stream, true);

        if (!$input) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => 'Invalid JSON payload'
                ]));
        }

        $provider_id = (int) ($input['provider_id'] ?? 0);
        $rating      = (int) ($input['rating'] ?? 0);
        $review_text = trim($input['review_text'] ?? '');

        /* -------------------------
       VALIDATION
    ------------------------- */
        if ($provider_id <= 0) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => 'provider_id is required'
                ]));
        }

        if ($rating < 1 || $rating > 5) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => 'Rating must be between 1 and 5'
                ]));
        }

        /* -------------------------
       DATA
    ------------------------- */
        $data = [
            'rating'      => $rating,
            'review_text' => $review_text,
            'updated_at'  => date('Y-m-d H:i:s')
        ];

        /* -------------------------
       CHECK EXISTING REVIEW
    ------------------------- */
        $exists = $this->db
            ->where('user_id', $user_id)
            ->where('provider_id', $provider_id)
            ->get('reviews')
            ->row();

        if ($exists) {
            // UPDATE
            $this->db
                ->where('user_id', $user_id)
                ->where('provider_id', $provider_id)
                ->update('reviews', $data);

            return $this->output
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => true,
                    'message' => 'Review updated successfully'
                ]));
        }

        // INSERT
        $data['user_id']     = $user_id;
        $data['provider_id'] = $provider_id;
        $data['created_at']  = date('Y-m-d H:i:s');

        $this->db->insert('reviews', $data);

        return $this->output
            ->set_status_header(200)
            ->set_output(json_encode([
                'status'  => true,
                'message' => 'Review submitted successfully'
            ]));
    }

    public function user_notifications_get()
    {
        header('Content-Type: application/json');

        /* ================= JWT ================= */
        $authHeader = $this->input->get_request_header('Authorization', TRUE);

        $token = null;
        if (!empty($authHeader) && preg_match('/Bearer\s+(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        if (empty($token)) {
            echo json_encode([
                'status' => false,
                'code'   => 400,
                'msg'    => 'Authorization header missing or invalid',
                'data'   => null
            ]);
            return;
        }

        $decoded = $this->verify_jwt($token);

        if (!$decoded || empty($decoded->data->id)) {
            echo json_encode([
                'status' => false,
                'code'   => 400,
                'msg'    => 'Invalid token',
                'data'   => null
            ]);
            return;
        }

        $user_id = (int)$decoded->data->id;

        /* ================= FETCH NOTIFICATIONS ================= */
        $rows = $this->db
            ->where('user_id', $user_id)
            ->order_by('id', 'DESC')
            ->get('user_notifications')
            ->result_array();

        $notifications = [];

        foreach ($rows as $n) {

            $item = [
                'id'          => $n['id'],
                'type'        => $n['type'],
                'title'       => $n['title'],
                'message'     => $n['message'],
                'is_read'     => (int)$n['is_read'],
                'created_at'  => $n['created_at'],
                'data'        => null
            ];

            /* ================= SESSION REMINDER ================= */
            if ($n['type'] === 'session_reminder' && !empty($n['session_id'])) {

                $session = $this->db
                    ->select('
        ls.id AS session_id,
        ls.title,
        ls.session_date,
        ls.start_time,
        u.gym_name
    ')
                    ->from('live_sessions ls')
                    ->join('users u', 'u.id = ls.provider_id', 'left')
                    ->where('ls.id', $n['session_id'])
                    ->get()
                    ->row_array();


                $item['data'] = $session;
            }

            $notifications[] = $item;
        }

        echo json_encode([
            'status' => true,
            'code'   => 200,
            'msg'    => 'Notification list',
            'data'   => $notifications
        ]);
    }

    public function user_notification_read($notification_id = null)
    {
        header('Content-Type: application/json');

        /* ================= JWT ================= */
        $authHeader = $this->input->get_request_header('Authorization', TRUE);

        $token = null;
        if (!empty($authHeader) && preg_match('/Bearer\s+(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);

        if (!$decoded || empty($decoded->data->id)) {
            echo json_encode([
                'status' => false,
                'code'   => 400,
                'msg'    => 'Authorization header missing or invalid',
                'data'   => null
            ]);
            return;
        }


        if (empty($notification_id)) {
            echo json_encode([
                'status' => false,
                'code'   => 400,
                'msg'    => 'Notification ID missing',
                'data'   => null
            ]);
            return;
        }

        $user_id = (int)$decoded->data->id;

        $exists = $this->db
            ->where('id', $notification_id)
            ->where('user_id', $user_id)
            ->get('user_notifications')
            ->row();

        if (!$exists) {
            echo json_encode([
                'status' => false,
                'code'   => 400,
                'msg'    => 'Notification not found',
                'data'   => null
            ]);
            return;
        }

        $this->db
            ->where('id', $notification_id)
            ->update('user_notifications', ['is_read' => 1]);

        echo json_encode([
            'status' => true,
            'code'   => 200,
            'msg'    => 'Notification marked as read',
            'data'   => null
        ]);
    }
    public function user_notification_delete($notification_id = null)
    {
        header('Content-Type: application/json');

        if ($this->input->method(TRUE) !== 'DELETE') {
            echo json_encode([
                'status' => false,
                'code'   => 400,
                'msg'    => 'Method not allowed',
                'data'   => null
            ]);
            return;
        }

        /* ================= JWT ================= */
        $authHeader = $this->input->get_request_header('Authorization', TRUE);

        $token = null;
        if (!empty($authHeader) && preg_match('/Bearer\s+(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);

        if (!$decoded || empty($decoded->data->id)) {
            echo json_encode([
                'status' => false,
                'code'   => 400,
                'msg'    => 'Authorization header missing or invalid',
                'data'   => null
            ]);
            return;
        }


        if (empty($notification_id)) {
            echo json_encode([
                'status' => false,
                'code'   => 400,
                'msg'    => 'Notification ID missing',
                'data'   => null
            ]);
            return;
        }

        $user_id = (int)$decoded->data->id;

        $exists = $this->db
            ->where('id', $notification_id)
            ->where('user_id', $user_id)
            ->get('user_notifications')
            ->row();

        if (!$exists) {
            echo json_encode([
                'status' => false,
                'code'   => 400,
                'msg'    => 'Notification not found',
                'data'   => null
            ]);
            return;
        }

        $this->db
            ->where('id', $notification_id)
            ->where('user_id', $user_id)
            ->delete('user_notifications');

        echo json_encode([
            'status' => true,
            'code'   => 200,
            'msg'    => 'Notification deleted successfully',
            'data'   => null
        ]);
    }
    public function user_notification_delete_all()
    {
        header('Content-Type: application/json');

        if ($this->input->method(TRUE) !== 'DELETE') {
            echo json_encode([
                'status' => false,
                'code'   => 400,
                'msg'    => 'Method not allowed',
                'data'   => null
            ]);
            return;
        }

        /* ================= JWT ================= */
        $authHeader = $this->input->get_request_header('Authorization', TRUE);

        $token = null;
        if (!empty($authHeader) && preg_match('/Bearer\s+(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        $decoded = $this->verify_jwt($token);

        if (!$decoded || empty($decoded->data->id)) {
            echo json_encode([
                'status' => false,
                'code'   => 400,
                'msg'    => 'Authorization header missing or invalid',
                'data'   => null
            ]);
            return;
        }


        $user_id = (int)$decoded->data->id;

        $this->db
            ->where('user_id', $user_id)
            ->delete('user_notifications');

        echo json_encode([
            'status' => true,
            'code'   => 200,
            'msg'    => 'All notifications deleted successfully',
            'data'   => null
        ]);
    }

    private function send_expo_push($provider_id, $title, $message, $data = [])
    {
        log_message('info', '📱 Push attempt for provider: ' . $provider_id);

        $tokenRow = $this->db
            ->where('provider_id', $provider_id)
            ->where('is_active', 1)
            ->get('provider_tokens')
            ->row();

        if (!$tokenRow || empty($tokenRow->expo_token)) {
            log_message('error', '❌ Expo token missing for provider: ' . $provider_id);
            return false;
        }

        $expo_token = $tokenRow->expo_token;

        if (!preg_match('/^ExponentPushToken\[.+\]$/', $expo_token)) {
            log_message('error', '❌ Invalid Expo token: ' . $expo_token);
            return false;
        }

        $payload = [
            'to'        => $expo_token,
            'title'     => $title,
            'body'      => $message,
            'sound'     => 'default',
            'priority'  => 'high',
            'channelId' => 'default',
            'data'      => $data
        ];

        $ch = curl_init('https://exp.host/--/api/v2/push/send');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
        ]);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            log_message('error', '❌ Expo cURL error: ' . curl_error($ch));
            curl_close($ch);
            return false;
        }

        curl_close($ch);

        log_message('info', '📥 Expo response: ' . $result);

        return $httpCode === 200;
    }

    public function get_fittv_categories()
    {
        header('Content-Type: application/json');
        $input_data = json_decode($this->input->raw_input_stream, true);
        $gender = $this->input->get('gender') ?? $this->input->post('gender') ?? ($input_data['gender'] ?? null);

        if (!$gender || !in_array($gender, ['Boy', 'Girl'])) {
            return $this->output->set_status_header(400)->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Valid gender parameter is required (Boy or Girl).',
                'data' => null
            ]));
        }

        $categories = $this->db
            ->where('gender', $gender)
            ->where('isActive', 1)
            ->get('fittv_categories')
            ->result();

        foreach ($categories as &$cat) {
            if (!empty($cat->image)) {
                $cat->image = base_url($cat->image); 
            }
        }

        return $this->output->set_status_header(200)->set_output(json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'FitTV categories fetched successfully.',
            'data' => $categories
        ]));
    }

    public function get_fittv_videos()
    {
        header('Content-Type: application/json');
        $category_id = intval($this->input->get('category_id'));

        if (!$category_id) {
            return $this->output->set_status_header(400)->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Category ID is required.',
                'data' => null
            ]));
        }

        $category = $this->db->get_where('fittv_categories', ['id' => $category_id])->row();
        
        if (!$category) {
            return $this->output->set_status_header(404)->set_output(json_encode([
                'status' => false,
                'code' => 404,
                'message' => 'Category not found.',
                'data' => null
            ]));
        }

        $videos = $this->db
            ->where('category_id', $category_id)
            ->where('isActive', 1)
            ->get('fittv_videos')
            ->result();

        foreach ($videos as &$vid) {
            if (!empty($vid->video)) {
                $vid->video = base_url('uploads/videos/' . $vid->video); 
            }
            if (!empty($vid->thumbnail)) {
                $vid->thumbnail = base_url('uploads/thumbnails/' . $vid->thumbnail); 
            }
        }

        return $this->output->set_status_header(200)->set_output(json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'FitTV videos fetched successfully.',
            'category_info' => [
                'id' => $category->id,
                'name' => $category->name,
                'gender' => $category->gender
            ],
            'data' => $videos
        ]));
    }
}