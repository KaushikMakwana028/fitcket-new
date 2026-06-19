<?php

defined('BASEPATH') or exit('No direct script access allowed');

use \Firebase\JWT\JWT;

use \Firebase\JWT\Key;

class Api extends CI_Controller
{

    private $jwt_secret = 'a4f9e6d5b5c4a1b92f3d93d9f53aa8e13efadcb89e6ba841dd23456789abcd';

    public function __construct()
    {

        parent::__construct();

        $this->load->model('general_model');
        $this->load->model('Live_session_model');
        $this->load->library('Agora_lib');

         $this->load->library(['session']);

        $this->load->helper(['url', 'form']);

        require_once APPPATH . '../vendor/autoload.php';

        header("Access-Control-Allow-Origin: *"); 

        header("Content-Type: application/json; charset=UTF-8");
        $this->load->library('email');
        $this->load->library(['form_validation']);



    }
//     public function register_user()
// {
//     $input_data = json_decode($this->input->raw_input_stream, true);

//     if (!empty($input_data)) {
//         $_POST = $input_data;
//     }

//     $this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
//     $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
//     $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
//     $this->form_validation->set_rules('business_name', 'Business Name', 'required|trim');
//     $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|numeric|min_length[10]|max_length[10]');

//     if ($this->form_validation->run() == FALSE) {
//         echo json_encode([
//             'code'=>400,
//             'status' => false,
//             'errors' => $this->form_validation->error_array()
//         ]);
//         return;
//     }

//     $mobile = $this->input->post('mobile', TRUE);
//     $user   = $this->db->get_where('users', ['mobile' => $mobile])->row_array();

//     if ($user && $user['role'] == 2) {
//         echo json_encode(['code' => 400, 'status' => false, 'message' => 'This number is already registered as a provider']);
//         return;
//     }

//     $form_data = [
//         'firstname'     => $this->input->post('firstname', TRUE),
//         'lastname'      => $this->input->post('lastname', TRUE),
//         'email'         => $this->input->post('email', TRUE),
//         'business_name' => $this->input->post('business_name', TRUE),
//         'mobile'        => $mobile
//     ];
//     $this->session->set_userdata('register_form_data', $form_data);

//     // Generate OTP
//     $otp = rand(100000, 999999);
//     $this->session->set_userdata('otp', $otp);

//     if ($user && $user['role'] == 0) {
//         $this->db->where('mobile', $mobile)->update('users', ['role' => 2, 'otp_verified' => 0]);
//     }

//     // Send OTP
//     $sms_sent = $this->send_otp_via_sms($mobile, $otp);
//     if (!$sms_sent) {
//         echo json_encode(['code' => 400, 'status' => false, 'message' => 'Failed to send OTP']);
//         return;
//     }

//     echo json_encode([
//         'code' => 200,
//         'status' => true,
//         'message' => 'OTP sent successfully',
//         'mobile'  => $mobile
//     ]);
// }

// public function register_verify_otp()
// {
//     $input_data = json_decode($this->input->raw_input_stream, true);
//     if (!empty($input_data)) {
//         $_POST = $input_data;
//     }

//     $entered_otp = $this->input->post('otp');
//     $fcm_token   = $this->input->post('fcm_token'); // ✅ Added
//     $session_otp = $this->session->userdata('otp');
//     $form_data   = $this->session->userdata('register_form_data');

//     if (!$form_data) {
//         echo json_encode(['code'=>400,'status' => false, 'message' => 'Session expired. Please register again.']);
//         return;
//     }

//     if ($entered_otp != $session_otp) {
//         echo json_encode(['code'=>400,'status' => false, 'message' => 'Invalid OTP']);
//         return;
//     }

//     $mobile = $form_data['mobile'];
//     $user   = $this->db->get_where('users', ['mobile' => $mobile])->row_array();

//     if ($user) {
//         // 🔹 Update existing user
//         $this->db->where('mobile', $mobile)->update('users', [
//             'gym_name'     => $form_data['business_name'],
//             'name'         => $form_data['firstname'] . ' ' . $form_data['lastname'],
//             'email'        => $form_data['email'],
//             'role'         => 2,
//             'otp_verified' => 1
//         ]);
//         $user_data = $this->db->get_where('users', ['mobile' => $mobile])->row();
//     } else {
//         // 🔹 Insert new provider
//         $this->db->insert('users', [
//             'gym_name'     => $form_data['business_name'],
//             'name'         => $form_data['firstname'] . ' ' . $form_data['lastname'],
//             'mobile'       => $mobile,
//             'email'        => $form_data['email'],
//             'role'         => 2,
//             'isActive'     => 1,
//             'otp_verified' => 1,
//             'created_at'   => date('Y-m-d H:i:s')
//         ]);
//         $insert_id  = $this->db->insert_id();
//         $user_data  = $this->db->get_where('users', ['id' => $insert_id])->row();
//     }

//     // 🔹 Save or update FCM token for provider
//     if (!empty($fcm_token)) {
//         $existing = $this->db->get_where('provider_tokens', ['provider_id' => $user_data->id])->row();

//         if ($existing) {
//             $this->db->where('provider_id', $user_data->id)
//                      ->update('provider_tokens', ['fcm_token' => $fcm_token,'created_at' => date('Y-m-d H:i:s')]);
//         } else {
//             $this->db->insert('provider_tokens', [
//                 'provider_id' => $user_data->id,
//                 'fcm_token'   => $fcm_token,
//                 'created_at'  => date('Y-m-d H:i:s')
//             ]);
//         }
//     }

//     // 🔹 Fetch provider profile image
//     $provider = $this->db->select('profile_image')
//                          ->where('provider_id', $user_data->id)
//                          ->get('provider')
//                          ->row();

//     $user_data->profile_image = $provider ? $provider->profile_image : null;

//     // 🔹 Generate JWT
//     $token = $this->generate_jwt($user_data);

//     // 🔹 Cleanup session
//     $this->session->unset_userdata('otp');
//     $this->session->unset_userdata('register_form_data');

//     echo json_encode([
//         'code'    => 200,
//         'status'  => true,
//         'message' => 'Provider registered successfully',
//         'token'   => $token,
//         'user'    => $user_data
//     ]);
// }


// public function login_send_otp()
// {
//     // Decode JSON input
//     $input_data = json_decode($this->input->raw_input_stream, true);
//     if (!empty($input_data)) {
//         $_POST = $input_data;
//     }

//     $mobile = $this->input->post('mobile');

//     if (empty($mobile)) {
//         echo json_encode(['code'=>400,'status'=>false,'message'=>'Mobile number is required']);
//         return;
//     }

//     // Check if user exists
//     $user = $this->db->get_where('users', ['mobile'=>$mobile])->row_array();
//     if (!$user) {
//         echo json_encode(['code'=>400,'status'=>false,'message'=>'Mobile not registered']);
//         return;
//     }

//     /* --------------------------------
//        OTP LOGIC
//     -------------------------------- */
//     if ($mobile === '8160348894') {
//         $otp = 123456; // 🔥 ALWAYS SAME OTP
//     } else {
//         $otp = rand(100000, 999999);
//     }

//     // Store OTP in session
//     $this->session->set_userdata('login_otp', $otp);
//     $this->session->set_userdata('login_mobile', $mobile);

//     /* --------------------------------
//        SEND REAL SMS
//     -------------------------------- */
//     $sms_sent = $this->send_otp_via_sms($mobile, $otp);

//     if (!$sms_sent) {
//         echo json_encode(['code'=>400,'status'=>false,'message'=>'Failed to send OTP']);
//         return;
//     }

//     echo json_encode([
//         'code'    => 200,
//         'status'  => true,
//         'message' => 'OTP sent successfully',
//         'mobile'  => $mobile
//     ]);
// }



// public function login_verify_otp()
// {
//     $input_data = json_decode($this->input->raw_input_stream, true);
//     if (!empty($input_data)) {
//         $_POST = $input_data;
//     }

//     $entered_otp = $this->input->post('otp');
//     $fcm_token   = $this->input->post('fcm_token'); // 🔹 Added
//     $session_otp = $this->session->userdata('login_otp');
//     $mobile      = $this->session->userdata('login_mobile');

//     if (!$session_otp || !$mobile) {
//         echo json_encode(['code' => 400, 'status' => false, 'message' => 'Session expired. Please try again.']);
//         return;
//     }

//     if ($entered_otp != $session_otp) {
//         echo json_encode(['code' => 400, 'status' => false, 'message' => 'Invalid OTP']);
//         return;
//     }

//     // ✅ Get provider user record
//     $user = $this->db->get_where('users', ['mobile' => $mobile])->row();
//     if (!$user) {
//         echo json_encode(['code' => 400, 'status' => false, 'message' => 'User not found']);
//         return;
//     }

//     // ✅ Fetch provider profile image
//     $provider = $this->db->select('profile_image')
//                          ->where('provider_id', $user->id)
//                          ->get('provider')
//                          ->row();

//     $user->profile_image = $provider ? $provider->profile_image : null;

//     // ✅ Save or update FCM token in provider_tokens
//     if (!empty($fcm_token)) {
//         $existing = $this->db->get_where('provider_tokens', ['provider_id' => $user->id])->row();

//         if ($existing) {
//             $this->db->where('provider_id', $user->id)
//                      ->update('provider_tokens', ['fcm_token' => $fcm_token,'created_at' => date('Y-m-d H:i:s')]);
//         } else {
//             $this->db->insert('provider_tokens', [
//                 'provider_id' => $user->id,
//                 'fcm_token'   => $fcm_token,
//                 'created_at' => date('Y-m-d H:i:s')
//             ]);
//         }
//     }

//     // ✅ Generate JWT
//     $token = $this->generate_jwt($user);

//     // ✅ Cleanup session
//     $this->session->unset_userdata('login_otp');
//     $this->session->unset_userdata('login_mobile');

//     echo json_encode([
//         'code'    => 200,
//         'status'  => true,
//         'message' => 'Login successful',
//         'token'   => $token,
//         'user'    => $user
//     ]);
// }




public function register_user()
{
    log_message('error', '==== REGISTER USER START ====');

    $input_data = json_decode($this->input->raw_input_stream, true);
    log_message('error', 'Raw Input: ' . json_encode($input_data));

    if (!empty($input_data)) $_POST = $input_data;

    log_message('error', 'POST Data: ' . json_encode($_POST));

    $this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
    $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
    $this->form_validation->set_rules('business_name', 'Business Name', 'required|trim');
    $this->form_validation->set_rules('mobile', 'Mobile', 'required|numeric|exact_length[10]');

    if ($this->form_validation->run() === FALSE) {

        log_message('error', 'Validation Failed');
        log_message('error', json_encode($this->form_validation->error_array()));

        echo json_encode([
            'code'   => 400,
            'status' => false,
            'errors' => $this->form_validation->error_array()
        ]);
        return;
    }

    $mobile = $this->input->post('mobile', true);
    log_message('error', 'Mobile: ' . $mobile);

    $existing = $this->db->get_where('users', ['mobile'=>$mobile])->row_array();
    log_message('error', 'Existing User Query: ' . $this->db->last_query());
    log_message('error', 'Existing User Data: ' . json_encode($existing));

    if ($existing && $existing['role'] == 2) {

        log_message('error', 'Mobile already registered as provider');

        echo json_encode([
            'code'=>400,
            'status'=>false,
            'message'=>'This number is already registered as a provider'
        ]);
        return;
    }

    $otp = OTP_FIXED_MODE ? '123456' : rand(100000, 999999);
    log_message('error', 'Generated OTP: ' . $otp);

    // clear old OTPs
    $this->db->where('mobile', $mobile)->delete('register_otps');
    log_message('error', 'Old OTP Deleted Query: ' . $this->db->last_query());

    $form_data = [
        'firstname'     => $this->input->post('firstname', true),
        'lastname'      => $this->input->post('lastname', true),
        'email'         => $this->input->post('email', true),
        'business_name' => $this->input->post('business_name', true)
    ];

    log_message('error', 'Form Data: ' . json_encode($form_data));

    $this->db->insert('register_otps', [
        'mobile'      => $mobile,
        'otp'         => $otp,
        'form_data'   => json_encode($form_data),
        'expires_at'  => date('Y-m-d H:i:s', strtotime('+5 minutes'))
    ]);

    log_message('error', 'Insert OTP Query: ' . $this->db->last_query());

    if (!OTP_FIXED_MODE) {
        log_message('error', 'Sending OTP via SMS');
        $this->send_otp_via_sms($mobile, $otp);
    } else {
        log_message('error', 'OTP_FIXED_MODE enabled → SMS skipped');
    }

    log_message('error', '==== REGISTER USER END ====');

    echo json_encode([
        'code'=>200,
        'status'=>true,
        'message'=>'OTP sent successfully',
        'mobile'=>$mobile
    ]);
}




public function register_verify_otp()
{
    log_message('error', '==== REGISTER VERIFY OTP START ====');

    $input_data = json_decode($this->input->raw_input_stream, true);
    log_message('error', 'Raw Input: ' . json_encode($input_data));

    if (!empty($input_data)) $_POST = $input_data;

    $mobile      = $this->input->post('mobile');
    $entered_otp = $this->input->post('otp');
    $expo_token  = $this->input->post('fcm_token');
    $device_type = $this->input->post('device_type') ?? 'android';
    $app_version = $this->input->post('app_version');

    log_message('error', 'Mobile: ' . $mobile);
    log_message('error', 'Entered OTP: ' . $entered_otp);
    log_message('error', 'Expo Token: ' . $expo_token);
    log_message('error', 'Device Type: ' . $device_type);
    log_message('error', 'App Version: ' . $app_version);

    if (!$mobile || !$entered_otp) {

        log_message('error', 'Mobile or OTP missing');

        echo json_encode([
            'code'=>400,
            'status'=>false,
            'message'=>'Mobile & OTP required'
        ]);
        return;
    }

    $otp_row = $this->db
        ->where('mobile', $mobile)
        ->where('otp', $entered_otp)
        ->where('expires_at >=', date('Y-m-d H:i:s'))
        ->get('register_otps')
        ->row();

    log_message('error', 'OTP Verify Query: ' . $this->db->last_query());
    log_message('error', 'OTP Row: ' . json_encode($otp_row));

    if (!$otp_row) {

        log_message('error', 'Invalid or expired OTP');

        echo json_encode([
            'code'=>400,
            'status'=>false,
            'message'=>'Invalid or expired OTP'
        ]);
        return;
    }

    $form_data = json_decode($otp_row->form_data, true);
    log_message('error', 'Form Data From OTP Table: ' . json_encode($form_data));

    $user = $this->db->get_where('users', ['mobile'=>$mobile])->row();
    log_message('error', 'User Fetch Query: ' . $this->db->last_query());
    log_message('error', 'User Data: ' . json_encode($user));

    if ($user) {

        log_message('error', 'Updating existing user to provider');

        $this->db->where('id',$user->id)->update('users',[
            'gym_name'     => $form_data['business_name'],
            'name'         => $form_data['firstname'].' '.$form_data['lastname'],
            'email'        => $form_data['email'],
            'role'         => 2,
            'otp_verified' => 1
        ]);

        log_message('error', 'Update Query: ' . $this->db->last_query());

        $user_data = $this->db->get_where('users',['id'=>$user->id])->row();
    } else {

        log_message('error', 'Creating new provider user');

        $this->db->insert('users',[
            'gym_name'     => $form_data['business_name'],
            'name'         => $form_data['firstname'].' '.$form_data['lastname'],
            'mobile'       => $mobile,
            'email'        => $form_data['email'],
            'role'         => 2,
            'isActive'     => 1,
            'otp_verified' => 1,
            'created_at'   => date('Y-m-d H:i:s')
        ]);

        log_message('error', 'Insert User Query: ' . $this->db->last_query());

        $user_data = $this->db->get_where(
            'users',
            ['id'=>$this->db->insert_id()]
        )->row();
    }

    log_message('error', 'Final User Data: ' . json_encode($user_data));

    if ($expo_token) {

        log_message('error', 'Saving Expo Token');

        $this->save_expo_token(
            $user_data->id,
            $expo_token,
            $device_type,
            $app_version
        );
    } else {
        log_message('error', 'Expo token not provided');
    }

    $token = $this->generate_jwt($user_data);
    log_message('error', 'Generated JWT Token');

    // cleanup OTP
    $this->db->where('id',$otp_row->id)->delete('register_otps');
    log_message('error', 'OTP Deleted Query: ' . $this->db->last_query());

    log_message('error', '==== REGISTER VERIFY OTP END ====');

    echo json_encode([
        'code'=>200,
        'status'=>true,
        'message'=>'Provider registered successfully',
        'token'=>$token,
        'user'=>$user_data
    ]);
}




public function login_send_otp()
{
    $input_data = json_decode($this->input->raw_input_stream, true);

    if (!empty($input_data)) $_POST = $input_data;

    $mobile = trim($this->input->post('mobile'));

    if (!$mobile) {
        echo json_encode([
            'code'=>400,
            'status'=>false,
            'message'=>'Mobile required'
        ]);
        return;
    }

    if (!preg_match('/^[0-9]{10}$/', $mobile)) {
        echo json_encode([
            'code'=>400,
            'status'=>false,
            'message'=>'Invalid mobile number format'
        ]);
        return;
    }

    $user = $this->db->get_where('users',['mobile'=>$mobile])->row();

    if (!$user) {
        echo json_encode([
            'code'=>400,
            'status'=>false,
            'message'=>'Mobile not registered'
        ]);
        return;
    }

    $otp = OTP_FIXED_MODE ? '123456' : rand(100000, 999999);
    $expires_at = date('Y-m-d H:i:s', strtotime('+5 minutes'));

    $this->db->where('mobile', $mobile)->delete('login_otps');

    $insert_data = [
        'mobile'     => $mobile,
        'otp'        => (string)$otp,
        'expires_at' => $expires_at
    ];

    $insert = $this->db->insert('login_otps', $insert_data);

    if (!$insert) {
        echo json_encode([
            'code'=>500,
            'status'=>false,
            'message'=>'Failed to generate OTP. Please try again.'
        ]);
        return;
    }

    $verify_insert = $this->db->get_where('login_otps', ['mobile'=>$mobile])->row();
    
    if (!$verify_insert) {
        echo json_encode([
            'code'=>500,
            'status'=>false,
            'message'=>'OTP generation failed. Please try again.'
        ]);
        return;
    }

    if (!OTP_FIXED_MODE) {
        $this->send_otp_via_sms($mobile, $otp);
    }

    echo json_encode([
        'code'    => 200,
        'status'  => true,
        'message' => OTP_FIXED_MODE ? 'OTP: ' . $otp : 'OTP sent successfully',
        'debug'   => OTP_FIXED_MODE ? ['otp' => $otp] : null
    ]);
}



public function login_verify_otp()
{
    try {

        $input_data = json_decode($this->input->raw_input_stream, true);

        if (!empty($input_data)) $_POST = $input_data;

        $mobile      = trim($this->input->post('mobile'));
        $entered_otp = trim($this->input->post('otp'));
        $expo_token  = $this->input->post('fcm_token');
        $device_type = $this->input->post('device_type') ?? 'android';
        $app_version = $this->input->post('app_version');

        if (!$mobile || !$entered_otp) {
            echo json_encode([
                'code'=>400,
                'status'=>false,
                'message'=>'Mobile & OTP required'
            ]);
            return;
        }

        $all_otps = $this->db->get_where('login_otps', ['mobile'=>$mobile])->result();

        if (empty($all_otps)) {
            echo json_encode([
                'code'=>400,
                'status'=>false,
                'message'=>'No OTP found. Please request a new OTP first.'
            ]);
            return;
        }

        $otp_row = $this->db
            ->where('mobile', $mobile)
            ->where('otp', $entered_otp)
            ->where('expires_at >=', date('Y-m-d H:i:s'))
            ->get('login_otps')
            ->row();

        if (!$otp_row) {
            $expired_check = $this->db
                ->where('mobile', $mobile)
                ->where('otp', $entered_otp)
                ->get('login_otps')
                ->row();

            if ($expired_check) {
                echo json_encode([
                    'code'=>400,
                    'status'=>false,
                    'message'=>'OTP has expired. Please request a new one.'
                ]);
                return;
            } else {
                echo json_encode([
                    'code'=>400,
                    'status'=>false,
                    'message'=>'Invalid OTP. Please check and try again.'
                ]);
                return;
            }
        }

        $user = $this->db->get_where('users', ['mobile'=>$mobile])->row();
        
        if (!$user) {
            echo json_encode([
                'code'=>400,
                'status'=>false,
                'message'=>'User not found'
            ]);
            return;
        }

        if ($expo_token) {
            $this->save_expo_token($user->id, $expo_token, $device_type, $app_version);
        }

        $token = $this->generate_jwt($user);

        $this->db->where('id', $otp_row->id)->delete('login_otps');

        echo json_encode([
            'code'   => 200,
            'status' => true,
            'message'=> 'Login successful',
            'token'  => $token,
            'user'   => $user
        ]);

    } catch (Exception $e) {

        echo json_encode([
            'code' => 500,
            'status' => false,
            'message' => 'Server error'
        ]);
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
                'status'  => false,
                'code'    => 400,
                'message' => 'Invalid token or user ID missing',
                'data'    => null
            ]));
    }

    $user_id = (int)$decoded->data->id;

    // 2️⃣ Fetch user info
    $user = $this->db->get_where('users', ['id' => $user_id])->row();
    if (!$user) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'User not found',
                'data'    => null
            ]));
    }

    $this->db->trans_start();

    // 3️⃣ Blacklist token before deleting
    $this->db->insert('token_blacklist', [
        'token'      => $token,
        // 'user_id'    => $user_id,
        'expires_at' => date('Y-m-d H:i:s')
    ]);

    // 4️⃣ If provider → delete related data
    if ($user->role == 2) {
        $this->db->delete('provider', ['provider_id' => $user_id]);
        $this->db->delete('service', ['provider_id' => $user_id]);
        $this->db->delete('provider_schedules', ['provider_id' => $user_id]);
        $this->db->delete('gym_gallery', ['provider_id' => $user_id]);

    }

    // 5️⃣ Delete user record
    $this->db->delete('users', ['id' => $user_id]);

    $this->db->trans_complete();

    // 6️⃣ Transaction check
    if ($this->db->trans_status() === FALSE) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Failed to delete account. Please try again.',
                'data'    => null
            ]));
    }

    // 7️⃣ Success
    return $this->output
        ->set_status_header(200)
        ->set_output(json_encode([
            'status'  => true,
            'code'    => 200,
            'message' => 'Account deleted successfully. Token blacklisted.',
            'data'    => null
        ]));
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
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid token or provider ID missing',
                'data' => null
            ]));
    }

    $provider_id = $decoded->data->id;
    $this->db->where('provider_id', $provider_id)
         ->delete('provider_tokens');
    
    $expiry = date('Y-m-d H:i:s', $decoded->exp);
    $this->db->insert('token_blacklist', [
        'token' => $token,
        'expires_at' => $expiry
    ]);

   
    $this->db->where('provider_id', $provider_id)->delete('provider_tokens');

    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'Logout successful — token invalidated and FCM token removed',
            'data' => null
        ]));
}
/**
 * Save or update Expo push token for provider
 */
private function save_expo_token($provider_id, $expo_token, $device_type = 'android', $app_version = null)
{
    // Validate Expo token format
    if (!preg_match('/^ExponentPushToken\[.+\]$/', $expo_token)) {
        return false;
    }

    // Check if this token already exists
    $existing_token = $this->db
        ->where('expo_token', $expo_token)
        ->get('provider_tokens')
        ->row();

    $data = [
        'provider_id' => $provider_id,
        'expo_token'  => $expo_token,
        'device_type' => $device_type,
        'app_version' => $app_version,
        'is_active'   => 1,
        'updated_at'  => date('Y-m-d H:i:s')
    ];

    if ($existing_token) {

        // Update existing token record
        $this->db
            ->where('expo_token', $expo_token)
            ->update('provider_tokens', $data);

    } else {

        // Insert new token
        $data['created_at'] = date('Y-m-d H:i:s');

        $this->db->insert('provider_tokens', $data);
    }

    return true;
}





 public function dashboard()
{
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    // Verify JWT
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

    $provider_id = $decoded->data->id;
    $data = [];

    try {
        // -------- Total Customers ----------
        $this->db->select('COUNT(DISTINCT o.user_id) as total_customers');
        $this->db->from('order_items oi');
        $this->db->join('orders o', 'o.id = oi.order_id', 'inner');
        $this->db->where('oi.provider_id', $provider_id);
        $result = $this->db->get()->row();
        $data['total_customers'] = $result ? (int)$result->total_customers : 0;

        // -------- Total Bookings ----------
        $this->db->select('COUNT(oi.id) as total_bookings');
        $this->db->from('order_items oi');
        $this->db->join('orders o', 'o.id = oi.order_id', 'inner');
        $this->db->where('oi.provider_id', $provider_id);
        $result2 = $this->db->get()->row();
        $data['total_bookings'] = $result2 ? (int)$result2->total_bookings : 0;

        // -------- Total Services ----------
        $data['total_service'] = $this->general_model->getCount('service', ['provider_id' => $provider_id]);

        // -------- Wallet Balance ----------
        $this->db->select('balance');
        $this->db->from('provider_wallet');
        $this->db->where('provider_id', $provider_id);
        $wallet = $this->db->get()->row();
        $data['wallet_balance'] = $wallet ? (float)$wallet->balance : 0;

        // -------- Pending Payouts ----------
        $this->db->select('SUM(amount) as total_pending');
        $this->db->from('provider_payouts');
        $this->db->where('provider_id', $provider_id);
        $this->db->where('status', 'pending');
        $pending = $this->db->get()->row();
        $data['pending_payout'] = $pending ? (float)$pending->total_pending : 0;

        // -------- Fulfilled Payouts ----------
        $this->db->select('SUM(amount) as total_success');
        $this->db->from('provider_payouts');
        $this->db->where('provider_id', $provider_id);
        $this->db->where('status', 'success');
        $success = $this->db->get()->row();
        $data['fulfilled_payout'] = $success ? (float)$success->total_success : 0;

        // -------- QR Code ----------
        $data['qr_code_url'] = $this->generate_qr_code($provider_id);

        // ✅ Success Response
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => true,
                'code'    => 200,
                'message' => 'Dashboard data fetched successfully',
                'data'    => $data
            ]));

    } catch (Exception $e) {
        $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Error fetching dashboard: ' . $e->getMessage(),
                'data'    => null
            ]));
    }
}

public function generate_qr_code($provider_id)
{
    $this->load->library('ciqrcode');

    $qr_data = base_url('provider_details/' . $provider_id);
    $qr_directory = FCPATH . 'uploads/qr_codes/';

    if (!is_dir($qr_directory)) {
        mkdir($qr_directory, 0777, true);
    }

    $qr_filename = 'qr_' . $provider_id . '.png';
    $qr_path = $qr_directory . $qr_filename;

    $params['data'] = $qr_data;
    $params['level'] = 'H';
    $params['size'] = 10;
    $params['savename'] = $qr_path;

    $this->ciqrcode->generate($params);

    return base_url('uploads/qr_codes/' . $qr_filename);
}

public function service()
{
    // Verify JWT token
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid token or provider ID missing',
                'data' => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    // Get page number from GET query or POST JSON
    $input  = json_decode($this->input->raw_input_stream, true);
    $page   = isset($input['page']) ? (int)$input['page'] : (int)$this->input->get('page');
    if ($page < 1) { $page = 1; }

    $limit  = 10;
    $offset = ($page - 1) * $limit;

    // Count total services
    $this->db->from('service');
    $this->db->where('provider_id', $provider_id);
    $total = $this->db->count_all_results();

    // Fetch page data
    $this->db->from('service');
    $this->db->where('provider_id', $provider_id);
    $this->db->order_by('id', 'DESC');
    $this->db->limit($limit, $offset);
    $services = $this->db->get()->result();

    // Return response
    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status'  => true,
            'code'    => 200,
            'message' => $total > 0 ? 'Service list fetched successfully' : 'No services found',
            'data'    => $services ? $services : [],
            'total'   => (int)$total,
            'limit'   => $limit,
            'page'    => $page
        ]));
}

public function add_service()
{
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    // Verify JWT
    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid token or provider ID missing',
                'data' => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    // Collect input
    $serviceName        = trim($this->input->post('service_title'));
    $serviceDescription = trim($this->input->post('service_description'));

    // Validate fields
    if (empty($serviceName)) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Service title is required',
                'data' => null
            ]));
    }

    if (empty($serviceDescription)) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Service description is required',
                'data' => null
            ]));
    }

    // Check if service already exists
    $exists = $this->db->where('name', $serviceName)->get('service')->row();
    if ($exists) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Service already exists',
                'data' => null
            ]));
    }

    // Image upload validation
    $image = '';
    if (!empty($_FILES['service_image']['name'])) {
        $config['upload_path']   = './uploads/serviceimage/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['file_name']     = time();

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('service_image')) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => strip_tags($this->upload->display_errors()),
                    'data' => null
                ]));
        }

        $uploadData = $this->upload->data();
        $image = 'uploads/serviceimage/' . $uploadData['file_name'];
    }

    // Insert service
    $data = [
        'provider_id'  => $provider_id,
        'name'         => $serviceName,
        'image'        => $image,
        'description'  => $serviceDescription,
        'created_on'   => date('Y-m-d H:i:s')
    ];

    $this->db->insert('service', $data);

    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'Service added successfully',
            'data' => $data
        ]));
}

public function get_service($id = null)
{
    // --- Verify JWT ---
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(401)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 401,
                'message' => 'Invalid or expired token',
                'data' => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    // --- Validate service ID ---
    if (empty($id) || !is_numeric($id)) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid or missing service ID',
                'data' => null
            ]));
    }

    // --- Fetch service ---
    $service = $this->db
        ->where('id', $id)
        ->where('provider_id', $provider_id)
        ->get('service')
        ->row();

    if (!$service) {
        return $this->output
            ->set_status_header(404)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Service not found',
                'data' => null
            ]));
    }

    // --- Build full image URL ---
    $service->image = !empty($service->image)
        ? base_url($service->image)
        : null;

    // --- Return response ---
    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'Service details fetched successfully',
            'data' => $service
        ]));
}

public function update_service()
{
    // Verify JWT token
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(401)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 401,
                'message' => 'Invalid or expired token',
                'data' => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    // Detect content type (JSON or form-data)
    $contentType = $this->input->get_request_header('Content-Type', TRUE);
    $input = [];

    if (strpos($contentType, 'application/json') !== false) {
        $input = json_decode(trim(file_get_contents('php://input')), true);
    } else {
        $input = $this->input->post();
    }

    // Extract fields
    $service_id   = isset($input['service_id']) ? trim($input['service_id']) : null;
    $name         = isset($input['service_title']) ? trim($input['service_title']) : '';
    $description  = isset($input['service_description']) ? trim($input['service_description']) : '';
    $isActive     = isset($input['isActive']) ? (int)$input['isActive'] : null;

    // Validate required fields
    if (empty($service_id) || empty($name)) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Missing required fields: service_id and service_title are required',
                'data' => null
            ]));
    }

    // Fetch old service record
    $old = $this->general_model->getOne('service', [
        'id' => $service_id,
        'provider_id' => $provider_id
    ]);

    if (!$old) {
        return $this->output
            ->set_status_header(404)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Service not found',
                'data' => null
            ]));
    }

    // Prepare update data
    $data = [
        'name' => $name,
        'description' => $description,
        'created_on' => date('Y-m-d H:i:s')
    ];

    // ✅ Add Active/Inactive toggle
    if ($isActive !== null) {
        $data['isActive'] = ($isActive === 1) ? 1 : 0;
    }

    if (!empty($_FILES['service_image']['name'])) {
        $config['upload_path'] = './uploads/serviceimage/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['file_name'] = time() . '_' . $_FILES['service_image']['name'];

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('service_image')) {
            $uploadData = $this->upload->data();
            $data['image'] = 'uploads/serviceimage/' . $uploadData['file_name'];

            if (!empty($old->image) && file_exists('./' . $old->image)) {
                unlink('./' . $old->image);
            }
        } else {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'code' => 400,
                    'message' => strip_tags($this->upload->display_errors()),
                    'data' => null
                ]));
        }
    }

    // Perform update
    $update = $this->general_model->update('service', ['id' => $service_id], $data);

    if ($update) {
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => true,
                'code' => 200,
                'message' => 'Service updated successfully',
                'data' => $data
            ]));
    } else {
        return $this->output
            ->set_status_header(500)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 500,
                'message' => 'Failed to update service',
                'data' => null
            ]));
    }
}


public function toggel_service()
{
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    // Verify JWT
    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid token or provider ID missing',
                'data' => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    $input = json_decode($this->input->raw_input_stream, true);

    $id     = isset($input['id']) ? $input['id'] : null;
    $status = isset($input['status']) ? $input['status'] : null;

    if (!is_numeric($id) || ($status !== '0' && $status !== '1')) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid ID or status',
                'data' => null
            ]));
    }

    $where = ['id' => $id, 'provider_id' => $provider_id];
    $data  = ['isActive' => $status];

    $update = $this->general_model->update('service', $where, $data);

    if ($update) {
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => true,
                'code' => 200,
                'message' => $status == '1' ? 'Service published successfully' : 'Service unpublished successfully',
                'data' => [
                    'service_id' => $id,
                    'status' => $status
                ]
            ]));
    } else {
        return $this->output
            ->set_status_header(500)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 500,
                'message' => 'Failed to update service status',
                'data' => null
            ]));
    }
}

public function customer()
{
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    // Verify JWT
    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Invalid token or provider ID missing',
                'data'    => []
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    // Get params
    $search = $this->input->get('search');
    $page   = (int)$this->input->get('page') ?: 1;
    $limit  = 10;
    $offset = ($page - 1) * $limit;

    // Query customers (paginated)
    $this->db->distinct();
    $this->db->select('u.id, u.name, u.mobile, u.email');
    $this->db->from('users u');
    $this->db->join('orders o', 'u.id = o.user_id');
    $this->db->join('order_items oi', 'o.id = oi.order_id');
    $this->db->where('oi.provider_id', $provider_id);

    if (!empty($search)) {
        $this->db->group_start()
            ->like('u.name', $search)
            ->or_like('u.mobile', $search)
            ->or_like('u.email', $search)
            ->group_end();
    }

    $this->db->limit($limit, $offset);
    $customers = $this->db->get()->result();

    // Total count
    $this->db->distinct();
    $this->db->select('u.id');
    $this->db->from('users u');
    $this->db->join('orders o', 'u.id = o.user_id');
    $this->db->join('order_items oi', 'o.id = oi.order_id');
    $this->db->where('oi.provider_id', $provider_id);

    if (!empty($search)) {
        $this->db->group_start()
            ->like('u.name', $search)
            ->or_like('u.mobile', $search)
            ->or_like('u.email', $search)
            ->group_end();
    }

    $total = $this->db->get()->num_rows();

    // ✅ If no customers found — return empty array, not null
    if ($total == 0) {
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => true,
                'code'    => 200,
                'message' => 'No customer found',
                'data'    => []
            ]));
    }

    // ✅ If customers exist
    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status'  => true,
            'code'    => 200,
            'message' => 'Customers fetched successfully',
            'data'    => [
                'customers' => $customers,
                'pagination' => [
                    'total' => $total,
                    'page'  => $page,
                    'limit' => $limit,
                    'pages' => ceil($total / $limit)
                ]
            ]
        ]));
}


public function booking()
{
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    // Verify JWT
    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid token or provider ID missing',
                'data' => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    // Pagination & Search
    $search = $this->input->get('search');
    $page   = $this->input->get('page') ?? 1;
    $limit  = 10;
    $offset = ($page - 1) * $limit;

    $this->db->distinct();
    $this->db->select('o.id');
    $this->db->from('orders o');
    $this->db->join('order_items oi', 'o.id = oi.order_id', 'inner');
    $this->db->where('oi.provider_id', $provider_id);

    if (!empty($search)) {
        $this->db->join('users u', 'u.id = o.user_id', 'left');
        $this->db->group_start()
            ->like('o.id', $search)
            ->or_like('u.name', $search)
            ->or_like('u.mobile', $search)
            ->or_like('oi.name', $search)
        ->group_end();
        
    }

    $order_ids = array_column($this->db->get()->result_array(), 'id');
    $total = count($order_ids);

    $bookings = [];
    if ($total > 0) {
        $paginated_order_ids = array_slice($order_ids, $offset, $limit);

        // Step 2: Get detailed booking data
        $this->db->select('
            o.id,
            u.name as customer_name,
            u.mobile as customer_mobile,
            o.created_at,
            o.status,
            oi.price,
            oi.duration,
            oi.qty,
            oi.start_date,
            oi.name AS service_name
        ');
        $this->db->from('orders o');
        $this->db->join('users u', 'u.id = o.user_id');
        $this->db->join('order_items oi', 'o.id = oi.order_id');
        $this->db->where_in('o.id', $paginated_order_ids);
        $this->db->where('oi.provider_id', $provider_id);

        // Order properly
        $order_ids_order = implode(',', $paginated_order_ids);
        $this->db->order_by("FIELD(o.id, $order_ids_order)", '', false);

        $bookings = $this->db->get()->result_array();
    }

    // Final Response
    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'Bookings fetched successfully',
            'data' => $bookings,
            'total' => $total,
            'limit' => $limit,
            'page' => $page
        ]));
}

public function scheduled()
{
    // Get Authorization header
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    // Verify JWT token
    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(401)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid token or provider ID missing',
                'data' => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    // Fetch provider schedules from DB
    $query = $this->db->get_where('provider_schedules', ['provider_id' => $provider_id])->result();

    $schedules = [];
    foreach ($query as $row) {
        $schedules[strtolower($row->day)] = [
            'id' => $row->id,
            'day' => $row->day,
            'start_time' => $row->start_time,
            'end_time' => $row->end_time,
            'status' => $row->status
        ]; // Customize fields as needed
    }

    // Return JSON response
    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'Provider schedules fetched successfully',
            'data' => $schedules
        ]));
}
public function bank_details()
{
    // Get Authorization header
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    // Verify JWT
    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(401)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid token or provider ID missing',
                'data' => (object)[] 
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    $bank_details = $this->db->get_where('provider_bank_details', ['provider_id' => $provider_id])->row();

    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'Bank details fetched successfully',
            'data' => $bank_details ? $bank_details : (object)[] 
        ]));
}

public function add_scheduled() {
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(401)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 401,
                'message' => 'Invalid or expired token',
                'data' => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;
    $input = json_decode(trim(file_get_contents('php://input')), true);

    if (empty($input['status']) || !is_array($input['status'])) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid or missing schedule data',
                'data' => null
            ]));
    }

    $status = $input['status'];
    $from   = isset($input['from']) ? $input['from'] : [];
    $to     = isset($input['to']) ? $input['to'] : [];

    foreach ($status as $day => $dayStatus) {
        $start_time = ($dayStatus === 'open' && !empty($from[$day])) ? date('H:i:s', strtotime($from[$day])) : null;
        $end_time   = ($dayStatus === 'open' && !empty($to[$day])) ? date('H:i:s', strtotime($to[$day])) : null;

        $data = [
            'provider_id' => $provider_id,
            'day'         => $day,
            'status'      => $dayStatus,
            'start_time'  => $start_time,
            'end_time'    => $end_time,
            'updated_at'  => date('Y-m-d H:i:s')
        ];

        $existing = $this->db->get_where('provider_schedules', [
            'provider_id' => $provider_id,
            'day'         => $day
        ])->row();

        if ($existing) {
            $this->db->where('id', $existing->id)->update('provider_schedules', $data);
        } else {
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('provider_schedules', $data);
        }
    }

    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'Schedule saved successfully'
        ]));
}

public function save_bank_details()
{
    // Get Authorization header
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    // Verify JWT
    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid token or provider ID missing',
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    $input = json_decode(file_get_contents('php://input'), true);

$account_holder_name = $input['accountHolderName'] ?? null;
$bank_name = $input['bankName'] ?? null;
$account_number = $input['accountNumber'] ?? null;
$ifsc_code = isset($input['ifscCode']) ? strtoupper($input['ifscCode']) : null;
$account_type = $input['accountType'] ?? null;
$branch_name = $input['branchName'] ?? null;

    if (empty($account_holder_name) || empty($bank_name) || empty($account_number) || empty($ifsc_code) || empty($account_type)) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'All required fields must be filled.'
            ]));
    }

    $data = [
        'provider_id' => $provider_id,
        'account_holder_name' => $account_holder_name,
        'bank_name' => $bank_name,
        'account_number' => $account_number,
        'ifsc_code' => $ifsc_code,
        'account_type' => $account_type,
        'branch_name' => $branch_name
    ];

    $existing = $this->db->get_where('provider_bank_details', ['provider_id' => $provider_id])->row();

    if ($existing) {
        $this->db->where('provider_id', $provider_id);
        $this->db->update('provider_bank_details', $data);
        $message = 'Bank details updated successfully!';
    } else {
        $this->db->insert('provider_bank_details', $data);
        $message = 'Bank details saved successfully!';
    }

    // Fetch the updated/inserted row
    $bank_details = $this->db->get_where('provider_bank_details', ['provider_id' => $provider_id])->row();

    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'code' => 200,
            'message' => $message,
            'data' => $bank_details
        ]));
}

public function get_offers()
{
    // --- Verify JWT ---
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(401)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 401,
                'message' => 'Invalid or expired token',
                'data' => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    // --- Fetch Offers ---
    $offers = $this->db->get_where('offers', ['provider_id' => $provider_id])->result();

    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'Offers fetched successfully',
            'data' => $offers
        ]));
}
public function save_offers()
{
    // --- Verify JWT ---
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(401)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 401,
                'message' => 'Invalid or expired token',
                'data' => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    // --- Read JSON input ---
    $input = json_decode(trim(file_get_contents('php://input')), true);

    if (empty($input['offers']) || !is_array($input['offers'])) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid input format',
                'data' => null
            ]));
    }

    foreach ($input['offers'] as $offer) {
        $data = [
            'provider_id'  => $provider_id,
            'duration'     => $offer['duration'],
            'buy_quantity' => $offer['buy_quantity'],
            'free_quantity'=> $offer['free_quantity'],
            'valid_till'   => $offer['valid_till'],
            'isActive'     => $offer['isActive']
        ];

        if (!empty($offer['id'])) {
            $this->db->where('id', $offer['id'])->update('offers', $data);
        } else {
            $this->db->insert('offers', $data);
        }
    }

    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'Offers saved successfully'
        ]));
}

public function service_search()
{
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code'   => 400,
                'message'=> 'Invalid token or provider ID missing',
                'data'   => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;
    $search = $this->input->get('search') ?: '';
    $page   = (int)($this->input->get('page') ?: 1);
    $limit  = 10;
    $offset = ($page - 1) * $limit;

    // Count
    $this->db->from('service');
    $this->db->where('provider_id', $provider_id);
    if ($search !== '') {
        $this->db->group_start()
                 ->like('name', $search)
                 ->or_like('description', $search)
                 ->group_end();
    }
    $total = $this->db->count_all_results();

    // Fetch
    $this->db->from('service');
    $this->db->where('provider_id', $provider_id);
    if ($search !== '') {
        $this->db->group_start()
                 ->like('name', $search)
                 ->or_like('description', $search)
                 ->group_end();
    }
    $this->db->order_by('id', 'DESC');
    $this->db->limit($limit, $offset);
    $services = $this->db->get()->result();

    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'code'   => 200,
            'message'=> $total > 0 ? 'Services fetched successfully' : 'No services found',
            'data'   => $services,
            'pagination' => [
                'total' => $total,
                'page'  => $page,
                'limit' => $limit,
                'pages' => ceil($total / $limit)
            ]
        ]));
}
public function customer_search()
{
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code'   => 400,
                'message'=> 'Invalid token or provider ID missing',
                'data'   => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;
    $search = $this->input->get('search') ?: '';
    $page   = (int)($this->input->get('page') ?: 1);
    $limit  = 10;
    $offset = ($page - 1) * $limit;

    // Query customers
    $this->db->distinct();
    $this->db->select('u.id, u.name, u.mobile, u.email');
    $this->db->from('users u');
    $this->db->join('orders o', 'u.id = o.user_id');
    $this->db->join('order_items oi', 'o.id = oi.order_id');
    $this->db->where('oi.provider_id', $provider_id);

    if ($search !== '') {
        $this->db->group_start()
            ->like('u.name', $search)
            ->or_like('u.mobile', $search)
            ->or_like('u.email', $search)
            ->group_end();
    }

    $this->db->limit($limit, $offset);
    $customers = $this->db->get()->result();

    // Count total
    $this->db->distinct();
    $this->db->select('u.id');
    $this->db->from('users u');
    $this->db->join('orders o', 'u.id = o.user_id');
    $this->db->join('order_items oi', 'o.id = oi.order_id');
    $this->db->where('oi.provider_id', $provider_id);

    if ($search !== '') {
        $this->db->group_start()
            ->like('u.name', $search)
            ->or_like('u.mobile', $search)
            ->or_like('u.email', $search)
            ->group_end();
    }

    $total = $this->db->count_all_results();

    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'code'   => 200,
            'message'=> $total > 0 ? 'Customers fetched successfully' : 'No customers found',
            'data'   => $customers,
            'pagination' => [
                'total' => $total,
                'page'  => $page,
                'limit' => $limit,
                'pages' => ceil($total / $limit)
            ]
        ]));
}
public function booking_search()
{
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid token or provider ID missing',
                'data' => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;
    $search = $this->input->get('search') ?: '';
    $page   = (int)($this->input->get('page') ?: 1);
    $limit  = 10;
    $offset = ($page - 1) * $limit;

    // Filter order IDs
    $this->db->distinct();
    $this->db->select('o.id');
    $this->db->from('orders o');
    $this->db->join('order_items oi', 'o.id = oi.order_id');
    $this->db->where('oi.provider_id', $provider_id);

    if ($search !== '') {
        $this->db->join('users u', 'u.id = o.user_id', 'left');
        $this->db->group_start()
            ->like('o.id', $search)
            ->or_like('u.name', $search)
            ->or_like('u.mobile', $search)
            ->or_like('oi.name', $search)
            ->group_end();
    }

    $order_ids = array_column($this->db->get()->result_array(), 'id');
    $total = count($order_ids);

    $bookings = [];
    if ($total > 0) {
        $paginated_ids = array_slice($order_ids, $offset, $limit);

        $this->db->select('
            o.id,
            u.name AS customer_name,
            u.mobile AS customer_mobile,
            o.created_at,
            o.status,
            oi.price,
            oi.duration,
            oi.qty,
            oi.start_date,
            oi.name AS service_name
        ');
        $this->db->from('orders o');
        $this->db->join('users u', 'u.id = o.user_id');
        $this->db->join('order_items oi', 'o.id = oi.order_id');
        $this->db->where_in('o.id', $paginated_ids);
        $this->db->where('oi.provider_id', $provider_id);
        $this->db->order_by('o.id', 'DESC');
        $bookings = $this->db->get()->result_array();
    }

    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'code' => 200,
            'message' => $total > 0 ? 'Bookings fetched successfully' : 'No bookings found',
            'data' => $bookings,
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'pages' => ceil($total / $limit)
            ]
        ]));
}

public function get_profile()
{
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid token or provider ID missing',
                'data' => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    if (empty($provider_id)) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Provider ID is required',
                'data' => null
            ]));
    }

    // Fetch provider and related data
    $provider = $this->general_model->getOne('provider', ['provider_id' => $provider_id]);
    $expertise = $this->general_model->getAll('expertise_tag', ['provider_id' => $provider_id]);
    $categories = $this->general_model->getAll('categories', ['isActive' => 1]);
    $cities = $this->general_model->getAll('cities', ['isActive' => 1]);
    $user = $this->general_model->getOne('users', ['id' => $provider_id]);

    // If provider not found, return null instead of error
    $providerData = $provider ? $provider : null;

    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status' => true,
            'code' => 200,
            'message' => 'Profile fetched successfully',
            'data' => [
                'user' => $user ? $user : null,
                'provider' => $providerData?$providerData:[],
                'expertise_tags' => $expertise ? $expertise : [],
                'categories' => $categories ? $categories : [],
                'cities' => $cities ? $cities : []
            ]
        ]));
}

public function save_profile()
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
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 401,
                'message' => 'Invalid token or provider ID missing',
                'data' => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    // 2️⃣ Decode JSON input
    $input_data = json_decode($this->input->raw_input_stream, true);
    if (!empty($input_data)) {
        $_POST = $input_data;
    }

    $input = $this->input->post();

    // 3️⃣ Update user details in `users` table
    $userData = [
        'name'     => trim(($input['first_name'] ?? '') . ' ' . ($input['last_name'] ?? '')),
        'email'    => $input['email'] ?? '',
        'mobile'   => $input['mobile'] ?? '',
        'gym_name' => $input['business_name'] ?? ''
    ];
    $this->db->where('id', $provider_id)->update('users', $userData);

    // 4️⃣ Handle profile image (supports URL, Base64, or file upload)
    $profile_image = null;

    if (!empty($_FILES['profile_image']['name'])) {
        // File upload
        $config['upload_path']   = './uploads/profile/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $config['file_name']     = 'profile_' . time();

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('profile_image')) {
            $uploadData = $this->upload->data();
            $profile_image = 'uploads/profile/' . $uploadData['file_name'];
        } else {
            log_message('error', 'Profile image upload failed: ' . $this->upload->display_errors('', ''));
        }
    } elseif (!empty($input['profile_image'])) {
        $imgInput = $input['profile_image'];

        if (filter_var($imgInput, FILTER_VALIDATE_URL)) {
            // ✅ Image URL (use directly)
            $profile_image = $imgInput;
        } elseif (strpos($imgInput, 'base64,') !== false) {
            // ✅ Base64 image string
            $image_parts = explode(";base64,", $imgInput);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1] ?? 'jpg';
            $image_base64 = base64_decode($image_parts[1]);
            $file_name = 'profile_' . time() . '.' . $image_type;
            $file_path = FCPATH . 'uploads/profile/' . $file_name;
            file_put_contents($file_path, $image_base64);
            $profile_image = 'uploads/profile/' . $file_name;
        }
    }

    // 5️⃣ Get lat/lng from address (via OpenStreetMap)
    $address = trim($input['address'] ?? '');
    $latitude = null;
    $longitude = null;

    if ($address) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($address));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'FitTicketApp/1.0 (support@fitticket.com)');
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            $data = json_decode($response, true);
            if (!empty($data)) {
                $latitude  = $data[0]['lat'];
                $longitude = $data[0]['lon'];
            }
        }
    }

    
    $providerData = [
    'provider_id'  => $provider_id,
    'description'  => $input['description'] ?? '',
    'category'     => $input['category'] ?? null,
    'sub_category' => $input['subcategory'] ?? null,
    'city'         => isset($input['availability'])
                        ? (is_array($input['availability'])
                            ? implode(',', $input['availability'])
                            : $input['availability'])
                        : '',
    'address'      => $address,
    'day_price'    => $input['price_day'] ?? 0,
    'week_price'   => $input['price_week'] ?? 0,
    'month_price'  => $input['price_month'] ?? 0,
    'year_price'   => $input['price_year'] ?? 0,
    'exp'   => $input['exp'] ?? null,
    'language'      => isset($input['language'])
                        ? (is_array($input['language'])
                            ? implode(',', $input['language'])
                            : $input['language'])
                        : '',
    'service_type'   => $input['service_type'] ?? null,
    'latitude'     => $latitude,
    'longitude'    => $longitude,
    'isActive'     => 1,
    'created_on'   => date('Y-m-d')
];


    if ($profile_image) {
        $providerData['profile_image'] = $profile_image;
    }

    // 7️⃣ Insert or update provider
    $existing = $this->general_model->getOne('provider', ['provider_id' => $provider_id]);
    if ($existing) {
        $this->general_model->update('provider', ['provider_id' => $provider_id], $providerData);
    } else {
        $this->general_model->insert('provider', $providerData);
    }

    $tags = [];
    if (!empty($input['expertise_tags'])) {
        $decoded_tags = is_array($input['expertise_tags'])
            ? $input['expertise_tags']
            : json_decode($input['expertise_tags'], true);

        if (is_array($decoded_tags)) {
            foreach ($decoded_tags as $tag) {
                $value = is_array($tag) ? trim($tag['value'] ?? '') : trim($tag);
                if ($value) $tags[] = ['value' => $value];
            }
        }
    }

    $this->db->delete('expertise_tag', ['provider_id' => $provider_id]);
    foreach ($tags as $tag) {
        $this->db->insert('expertise_tag', [
            'provider_id' => $provider_id,
            'tag'         => $tag['value'],
            'created_on'  => date('Y-m-d')
        ]);
    }

    // 9️⃣ Return response
    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status'  => true,
            'code'    => 200,
            'message' => 'Profile and user details saved successfully!',
            'data'    => $providerData
        ]));
}



public function wallet()
{
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Invalid token or provider ID missing',
                'data' => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    // 1️⃣ Get wallet balance
    $wallet = $this->db->get_where('provider_wallet', ['provider_id' => $provider_id])->row();
    $wallet_balance = $wallet ? (float)$wallet->balance : 0.00;

    // 2️⃣ Get credits (successful orders + user name)
    $credits = $this->db->select('o.total, o.created_at, o.txnid as reference, u.name as user_name')
        ->from('orders o')
        ->join('order_items oi', 'oi.order_id = o.id')
        ->join('users u', 'u.id = o.user_id', 'left')
        ->where('oi.provider_id', $provider_id)
        ->where('o.status', 'success')
        ->order_by('o.created_at', 'DESC')
        ->get()
        ->result();

    // 3️⃣ Get debits (withdrawals)
    $debits = $this->db->select('amount, created_at, txn_id as reference')
        ->from('provider_payouts')
        ->where('provider_id', $provider_id)
        ->order_by('created_at', 'DESC')
        ->get()
        ->result();

    // 4️⃣ Combine both into one transaction list
    $transactions = [];

    foreach ($credits as $c) {
        $transactions[] = [
            'amount'    => (float)$c->total,
            'type'      => 'Credit',
            'user_name' => $c->user_name ? $c->user_name : 'Unknown User',
            'date'      => $c->created_at,
            'reference' => 'Booking ID: ' . $c->reference
        ];
    }

    foreach ($debits as $d) {
        $transactions[] = [
            'amount'    => (float)$d->amount,
            'type'      => 'Debit',
            'date'      => $d->created_at,
            'reference' => 'Withdrawal ID: ' . $d->reference
        ];
    }

    // 5️⃣ Sort all by date (latest first)
    usort($transactions, function ($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    // 6️⃣ Get wallet minimum setting
    $query2 = $this->db->query("SELECT wallet_min FROM payment_settings LIMIT 1");
    $wallet_min = ($query2->num_rows() > 0) ? (float)$query2->row()->wallet_min : 0.00;

    // ✅ Final response
    $response = [
        'wallet_balance' => $wallet_balance,
        'wallet_min'     => $wallet_min,
        'transactions'   => $transactions
    ];

    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status'  => true,
            'code'    => 200,
            'message' => 'Wallet details fetched successfully',
            'data'    => $response
        ]));
}


public function withdraw_request()
{
    // ✅ Check Authorization header for JWT token
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        return $this->output
            ->set_status_header(401)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 401,
                'message' => 'Invalid or missing token',
                'data'    => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    // ✅ Get JSON input
    $input = json_decode($this->input->raw_input_stream, true);
    $amount = isset($input['amount']) ? (float)$input['amount'] : 0;

    if ($amount <= 0) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Please enter a valid withdrawal amount.',
                'data'    => null
            ]));
    }

    // ✅ Check bank details
    $bankDetails = $this->db->get_where('provider_bank_details', ['provider_id' => $provider_id])->row_array();
    if (!$bankDetails) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Please add your bank details first.',
                'data'    => null
            ]));
    }

    // ✅ Get provider wallet
    $wallet = $this->db->get_where('provider_wallet', ['provider_id' => $provider_id])->row_array();
    if (!$wallet) {
        return $this->output
            ->set_status_header(404)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Wallet not found for this provider.',
                'data'    => null
            ]));
    }

    $currentBalance = (float)$wallet['balance'];

    // ✅ Get admin minimum wallet balance setting
    $query = $this->db->query("SELECT wallet_min FROM payment_settings LIMIT 1");
    $wallet_min = ($query->num_rows() > 0) ? (float)$query->row()->wallet_min : 0.00;

    // ✅ Validation: Insufficient balance
    if ($currentBalance < $amount) {
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Insufficient wallet balance.',
                'data'    => null
            ]));
    }

    // ✅ Validation: Check minimum required balance rule
    $remainingBalance = $currentBalance - $amount;
    if ($remainingBalance < $wallet_min) {
        $maxWithdrawable = $currentBalance - $wallet_min;
        return $this->output
            ->set_status_header(400)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'You should maintain a minimum balance of ₹' . number_format($wallet_min, 2) . 
                             ' in your wallet. You can withdraw up to ₹' . number_format($maxWithdrawable, 2) . '.',
                'data'    => [
                    'wallet_balance' => $currentBalance,
                    'wallet_min'     => $wallet_min,
                    'max_withdrawable' => $maxWithdrawable
                ]
            ]));
    }

    // ✅ Deduct amount from wallet
    $newBalance = $currentBalance - $amount;
    $this->db->where('provider_id', $provider_id);
    $this->db->update('provider_wallet', [
        'balance'    => $newBalance,
        'updated_at' => date('Y-m-d H:i:s')
    ]);

    // ✅ Create withdrawal record
    $transaction_id = 'TXN' . strtoupper(uniqid());
    $withdraw_data = [
        'provider_id' => $provider_id,
        'amount'      => $amount,
        'txn_id'      => $transaction_id,
        'status'      => 'pending',
        'created_at'  => date('Y-m-d H:i:s')
    ];

    $this->db->insert('provider_payouts', $withdraw_data);

    if ($this->db->affected_rows() > 0) {
        return $this->output
            ->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => true,
                'code'    => 200,
                'message' => 'Withdraw request submitted successfully.',
                'data'    => [
                    'transaction_id' => $transaction_id,
                    'new_balance'    => $newBalance,
                    'status'         => 'pending',
                    'amount'         => $amount
                ]
            ]));
    } else {
        return $this->output
            ->set_status_header(500)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 500,
                'message' => 'Failed to submit withdrawal request. Please try again.',
                'data'    => null
            ]));
    }
}

public function add_gallery_image()
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
                'status'  => false,
                'code'    => 400,
                'message' => 'Invalid or missing token',
                'data'    => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    // ✅ 2. Check if file exists
    if (empty($_FILES['gallery_image']['name'])) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'No image selected for upload',
                'data'    => null
            ]));
    }

    // ✅ 3. Upload configuration
    $upload_path = './uploads/gym_gallery/';
    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0777, true);
    }

    $config['upload_path']   = $upload_path;
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['file_name']     = 'gallery_' . time() . '_' . rand(1000, 9999);

    $this->load->library('upload', $config);

    // ✅ 4. Upload single image
    if (!$this->upload->do_upload('gallery_image')) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => $this->upload->display_errors('', ''),
                'data'    => null
            ]));
    }

    // ✅ 5. Upload success — Save in DB
    $upload_data = $this->upload->data();
    $image_path = 'uploads/gym_gallery/' . $upload_data['file_name'];

    $insert_data = [
        'provider_id' => $provider_id,
        'image'       => $image_path,
        'status'      => 1,
        'created_on'  => date('Y-m-d H:i:s')
    ];
    $this->db->insert('gym_gallery', $insert_data);
    $notificationData = [
    'provider_id' => $provider_id,
    'type'        => 'gallery',
    'title'       => 'Gallery Image Added',
    'message'     => 'A new image has been added to your gallery.',
    'is_read'     => 0,
    'created_at'  => date('Y-m-d H:i:s')
];

$this->db->insert('provider_notifications', $notificationData);

// Get notification ID (optional, for payload)
$notification_id = $this->db->insert_id();

// ✅ 7. Send Expo Push Notification (TESTING)
$this->send_expo_push(
    $provider_id,
    'Gallery Image Added 📸',
    'Your gallery image was uploaded successfully.',
    [
        'type' => 'gallery',
        'notification_id' => $notification_id
    ]
);

    // ✅ 6. Response
    return $this->output
        ->set_status_header(200)
        ->set_output(json_encode([
            'status'  => true,
            'code'    => 200,
            'message' => 'Image uploaded successfully',
            'data'    => [
                'image_url' => base_url($image_path)
            ]
        ]));
}
private function send_expo_push($provider_id, $title, $message, $data = [])
{
    log_message('info', '📱 Attempting to send Expo push to provider: ' . $provider_id);
    
    // Get token from database
    $tokenRow = $this->db
        ->where('provider_id', $provider_id)
        ->where('is_active', 1)
        ->get('provider_tokens')
        ->row();

    if (!$tokenRow) {
        log_message('error', '❌ No token record found for provider: ' . $provider_id);
        return false;
    }

    if (empty($tokenRow->expo_token)) {
        log_message('error', '❌ Expo token is empty for provider: ' . $provider_id);
        return false;
    }

    $expo_token = $tokenRow->expo_token;
    log_message('info', '✅ Found Expo token: ' . substr($expo_token, 0, 30) . '...');

    // Validate token format
    if (!preg_match('/^ExponentPushToken\[.+\]$/', $expo_token)) {
        log_message('error', '❌ Invalid Expo token format: ' . $expo_token);
        return false;
    }

    // Prepare payload
    $payload = [
        'to' => $expo_token,
        'title' => $title,
        'body' => $message,
        'sound' => 'default',
        'priority' => 'high',
        'channelId' => 'default',
        'ttl' => 2419200,
        'data' => $data
    ];

    log_message('info', '📤 Sending payload: ' . json_encode($payload));

    // Send to Expo
    $ch = curl_init('https://exp.host/--/api/v2/push/send');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'Content-Type: application/json'
        ],
        CURLOPT_POSTFIELDS => json_encode($payload),
    ]);

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        log_message('error', '❌ Expo Push cURL Error: ' . curl_error($ch));
        curl_close($ch);
        return false;
    }

    curl_close($ch);

    log_message('info', '📥 Expo API Response Code: ' . $httpCode);
    log_message('info', '📥 Expo API Response: ' . $result);

    if ($httpCode !== 200) {
        log_message('error', '❌ Expo Push HTTP Error: ' . $httpCode);
        return false;
    }

    $response = json_decode($result, true);

    if (!empty($response['data'][0]['status']) && $response['data'][0]['status'] === 'error') {
        log_message('error', '❌ Expo Push Error: ' . json_encode($response['data'][0]));
        return false;
    }

    log_message('info', '✅ Expo push notification sent successfully to provider: ' . $provider_id);
    return true;
}
public function fetch_gallery()
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
                'status'  => false,
                'code'    => 400,
                'message' => 'Invalid or missing token',
                'data'    => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    // ✅ 2. Pagination & Search
    $page   = (int)($this->input->post('page') ?: 1);
    $search = $this->input->post('search');
    $search = $search !== null ? trim($search) : ''; // Avoid null warnings
    $limit  = 5;
    $offset = ($page - 1) * $limit;

    // ✅ 3. Fetch paginated data for this provider
    $this->db->where('provider_id', $provider_id);
    if (!empty($search)) {
        $this->db->like('image', $search);
    }
    $this->db->limit($limit, $offset);
    $query = $this->db->get('gym_gallery');
    $data  = $query->result();

    // ✅ 4. Count total results (with same filters)
    $this->db->where('provider_id', $provider_id);
    if (!empty($search)) {
        $this->db->like('image', $search);
    }
    $total = $this->db->count_all_results('gym_gallery');

    // ✅ 5. Convert image paths to full URLs
    foreach ($data as &$img) {
        $img->image = base_url($img->image);
    }

    // ✅ 6. Send JSON response
    echo json_encode([
        'status'  => true,
        'code'    => 200,
        'message' => count($data) > 0
            ? 'Gallery images fetched successfully.'
            : 'No images found.',
        'data'    => [
            'images'     => $data,
            'pagination' => [
                'page'         => $page,
                'limit'        => $limit,
                'total'        => $total,
                'total_pages'  => ceil($total / $limit)
            ]
        ]
    ]);
}



public function delete_image($id = null)
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
                'status'  => false,
                'code'    => 400,
                'message' => 'Invalid or missing token',
                'data'    => null
            ]));
    }

    $provider_id = (int)$decoded->data->id;

    // ✅ 2. Validate ID
    if (empty($id) || !is_numeric($id)) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Invalid or missing image ID',
                'data'    => null
            ]));
    }

    // ✅ 3. Check if image exists and belongs to this provider
    $image = $this->db
        ->where('id', $id)
        ->where('provider_id', $provider_id)
        ->get('gym_gallery')
        ->row();

    if (!$image) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Image not found or access denied',
                'data'    => null
            ]));
    }

    // ✅ 4. Delete file from server
    $file_path = FCPATH . $image->image;
    if (file_exists($file_path)) {
        @unlink($file_path);
    }

    // ✅ 5. Delete from DB
    $this->db->delete('gym_gallery', ['id' => $id]);

    // ✅ 6. Success response
    return $this->output
        ->set_status_header(200)
        ->set_output(json_encode([
            'status'  => true,
            'code'    => 200,
            'message' => 'Image deleted successfully.',
            'data'    => null
        ]));
}
public function fetch_certifications()
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
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Invalid or missing token',
            'data'    => null
        ]);
        return;
    }

    $provider_id = (int)$decoded->data->id;

    // 2️⃣ Fetch Data
    $certs = $this->db
        ->where('provider_id', $provider_id)
        ->where('is_active', 1)
        ->order_by('id', 'DESC')
        ->get('certifications')
        ->result();

    foreach ($certs as &$c) {
        $c->image_path = base_url($c->image_path);
    }

    echo json_encode([
        'status'  => true,
        'code'    => 200,
        'message' => count($certs) ? 'Certifications fetched successfully' : 'No certifications found',
        'data'    => $certs
    ]);
}
public function save_certificate()
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
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Invalid or missing token',
            'data'    => null
        ]);
        return;
    }

    $provider_id = (int) $decoded->data->id;
    $title = trim($this->input->post('title'));

    if (!$title || empty($_FILES['certificate']['name'])) {
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Title and certificate file are required',
            'data'    => null
        ]);
        return;
    }

    /* =====================================================
       2️⃣ DUPLICATE TITLE CHECK (IMPORTANT)
    ===================================================== */
    $exists = $this->db
        ->where('provider_id', $provider_id)
        ->where('LOWER(title)', strtolower($title))
        ->get('certifications')
        ->row();

    if ($exists) {
        echo json_encode([
            'status'  => false,
            'code'    => 409,
            'message' => 'Certificate with this title already exists',
            'data'    => null
        ]);
        return;
    }

    /* =====================================================
       3️⃣ Upload Config
    ===================================================== */
    $config = [
        'upload_path'   => './uploads/certificates/',
        'allowed_types' => 'jpg|jpeg|png|pdf',
        'max_size'      => 2048,
        'encrypt_name'  => true
    ];

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('certificate')) {
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => $this->upload->display_errors('', ''),
            'data'    => null
        ]);
        return;
    }

    $file = $this->upload->data();
    $path = 'uploads/certificates/' . $file['file_name'];

    /* =====================================================
       4️⃣ Insert
    ===================================================== */
    $this->db->insert('certifications', [
        'provider_id' => $provider_id,
        'title'       => $title,
        'image_path'  => $path,
        'is_active'   => 1,
        'created_on'  => date('Y-m-d H:i:s')
    ]);

    echo json_encode([
        'status'  => true,
        'code'    => 200,
        'message' => 'Certification added successfully',
        'data'    => null
    ]);
}

public function delete_certificate($id = null)
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
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Invalid or missing token',
            'data'    => null
        ]);
        return;
    }

    $provider_id = (int)$decoded->data->id;
    $id = (int)$id; // ✅ ID from URL

    if (!$id) {
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Invalid certification ID',
            'data'    => null
        ]);
        return;
    }

    // 2️⃣ Verify ownership
    $cert = $this->db
        ->where('id', $id)
        ->where('provider_id', $provider_id)
        ->get('certifications')
        ->row();

    if (!$cert) {
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Certification not found',
            'data'    => null
        ]);
        return;
    }

    // 3️⃣ Delete file
    if (!empty($cert->image_path) && file_exists(FCPATH . $cert->image_path)) {
        unlink(FCPATH . $cert->image_path);
    }

    // 4️⃣ Delete DB record
    $this->db->where('id', $id)->delete('certifications');

    echo json_encode([
        'status'  => true,
        'code'    => 200,
        'message' => 'Certification deleted successfully',
        'data'    => null
    ]);
}

// ==================== FETCH SESSIONS ====================
public function fetch_sessions()
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
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Invalid or missing token',
            'data'    => null
        ]);
        return;
    }

    $provider_id = (int)$decoded->data->id;

    // 2️⃣ Fetch Data
    $sessions = $this->Live_session_model->getProviderSessions($provider_id);

    // Add full URL for thumbnails
    foreach ($sessions as &$session) {
        if (!empty($session['thumbnail'])) {
            $session['thumbnail_url'] = base_url('uploads/session_thumbnails/' . $session['thumbnail']);
        } else {
            $session['thumbnail_url'] = null;
        }
    }

    echo json_encode([
        'status'  => true,
        'code'    => 200,
        'message' => count($sessions) ? 'Sessions fetched successfully' : 'No sessions found',
        'data'    => $sessions
    ]);
}

// ==================== FETCH SINGLE SESSION ====================
public function fetch_session_one($id = null)
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
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Invalid or missing token',
            'data'    => null
        ]);
        return;
    }

    $provider_id = (int)$decoded->data->id;

    if (!$id) {
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Session ID is required',
            'data'    => null
        ]);
        return;
    }

    // 2️⃣ Fetch Session
    $session = $this->Live_session_model->getSession($id);

    if (!$session || $session['provider_id'] != $provider_id) {
        echo json_encode([
            'status'  => false,
            'code'    => 404,
            'message' => 'Session not found',
            'data'    => null
        ]);
        return;
    }

    // Add full URL for thumbnail
    if (!empty($session['thumbnail'])) {
        $session['thumbnail_url'] = base_url('uploads/session_thumbnails/' . $session['thumbnail']);
    }

    echo json_encode([
        'status'  => true,
        'code'    => 200,
        'message' => 'Session fetched successfully',
        'data'    => $session
    ]);
}
public function save_session()
{
    header('Content-Type: application/json');

    // ================= JWT VERIFY =================
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Invalid or missing token',
            'data'    => null
        ]);
        return;
    }

    $provider_id = (int)$decoded->data->id;

    // ================= INPUT =================
    $input = $this->input->post();

    // ================= VALIDATION =================
    $this->load->library('form_validation');
    $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]');
    $this->form_validation->set_rules('session_date', 'Session Date', 'required');
    $this->form_validation->set_rules('start_time', 'Start Time', 'required');
    $this->form_validation->set_rules('duration', 'Duration', 'required|numeric'); // ✅ Added
    $this->form_validation->set_rules('price', 'Price', 'required|numeric');

    if ($this->form_validation->run() == FALSE) {
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => strip_tags(validation_errors()),
            'data'    => null
        ]);
        return;
    }

    // ================= TIME =================
    $start_time = $input['start_time'];
    $duration   = (int)$input['duration'];
    $end_time   = date('H:i:s', strtotime($start_time) + ($duration * 60));

    // ================= AGORA =================
    $channel_name = 'live_' . $provider_id . '_' . time() . '_' . rand(1000, 9999);

    // ================= THUMBNAIL =================
    $thumbnail = null;

    if (!empty($_FILES['thumbnail']['name'])) {

        $config = [
            'upload_path'   => './uploads/session_thumbnails/',
            'allowed_types' => 'jpg|jpeg|png|webp',
            'encrypt_name'  => true,
            'max_size'      => 2048
        ];

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, true);
        }

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('thumbnail')) {
            echo json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => $this->upload->display_errors('', ''),
                'data'    => null
            ]);
            return;
        }

        $uploadData = $this->upload->data();
        $thumbnail  = $uploadData['file_name'];
    }

    // ================= SESSION DATA =================
    $sessionData = [
        'provider_id'          => $provider_id,
        'title'                => trim($input['title']),
        'description'          => trim($input['description'] ?? ''),
        'session_date'         => $input['session_date'],
        'start_time'           => $start_time,
        'end_time'             => $end_time,
        'duration_minutes'     => $duration,
        'max_participants'     => $input['max_participants'] ?? 1,
        'current_participants' => 0,   // ✅ Added
        'is_full'              => 0,   // ✅ Added
        'price'                => $input['price'],
        'session_type'         => $input['session_type'] ?? 'one_on_one',
        'category'             => $input['category'] ?? null,
        'recurring'            => $input['recurring'] ?? 'none',
        'status'               => 'scheduled'
    ];

    if ($thumbnail) {
        $sessionData['thumbnail'] = $thumbnail;
    }

    // ================= CREATE / UPDATE =================
    if (!empty($input['session_id'])) {

        $session_id = (int)$input['session_id'];

        if ($thumbnail) {
            $old = $this->Live_session_model->getSessionById($session_id);
            if (!empty($old['thumbnail'])) {
                @unlink('./uploads/session_thumbnails/' . $old['thumbnail']);
            }
        }

        $this->Live_session_model->updateSession($session_id, $sessionData);
        $message = 'Session updated successfully';

    } else {

        $sessionData['room_id'] = $channel_name;
        $session_id = $this->Live_session_model->createSession($sessionData);
        $message = 'Session created successfully';

        if (($input['recurring'] ?? 'none') != 'none') {
            $this->createRecurringSessions(
                $sessionData,
                $input['recurring'],
                $input['recurring_count'] ?? 4
            );
        }
    }

    echo json_encode([
        'status'  => true,
        'code'    => 200,
        'message' => $message,
        'data'    => ['session_id' => $session_id]
    ]);
}

// ==================== DELETE SESSION ====================
public function delete_session($id = null)
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
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Invalid or missing token',
            'data'    => null
        ]);
        return;
    }

    $provider_id = (int)$decoded->data->id;

    if (!$id) {
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Session ID is required',
            'data'    => null
        ]);
        return;
    }

    // 2️⃣ Verify Ownership
    $session = $this->Live_session_model->getSession($id);

    if (!$session || $session['provider_id'] != $provider_id) {
        echo json_encode([
            'status'  => false,
            'code'    => 404,
            'message' => 'Session not found',
            'data'    => null
        ]);
        return;
    }

    // 3️⃣ Delete thumbnail file if exists
    if (!empty($session['thumbnail'])) {
        @unlink('./uploads/session_thumbnails/' . $session['thumbnail']);
    }

    // 4️⃣ Delete Session
    $this->Live_session_model->deleteSession($id);

    echo json_encode([
        'status'  => true,
        'code'    => 200,
        'message' => 'Session deleted successfully',
        'data'    => null
    ]);
}
public function start_session_api($id)
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
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Invalid or missing token',
            'data'    => null
        ]);
        return;
    }

    $provider_id = (int)$decoded->data->id;

    // 2️⃣ Fetch Session
    $session = $this->Live_session_model->getSession($id);

    if (!$session || (int)$session['provider_id'] !== $provider_id) {
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Session not found or access denied',
            'data'    => null
        ]);
        return;
    }

    // 3️⃣ Update session status
    $startedAt = date('Y-m-d H:i:s');

    $this->Live_session_model->updateSession($id, [
        'status'     => 'live',
        'started_at' => $startedAt
    ]);

    // 4️⃣ Generate Agora Token
    $uid = (int)$provider_id;

    $tokenAgora = $this->agora_lib->generateToken(
        $session['room_id'],
        $uid,
        Agora_lib::ROLE_PUBLISHER,
        7200
    );

    // 5️⃣ Prepare API Response Data
    $data = [
        'session_id'   => $session['id'],
        'title'        => $session['title'] ?? '',
        'status'       => 'live',
        'started_at'   => $startedAt,
        'channel'      => $session['room_id'],
        'app_id'       => $this->agora_lib->getAppID(),
        'agora_token'  => $tokenAgora,
        'uid'          => $uid,
        'user_type'    => 'provider',
        'user_name'    => $decoded->data->name ?? '',
        'participants' => $this->Live_session_model->getSessionBookings($id)
    ];

    echo json_encode([
        'status'  => true,
        'code'    => 200,
        'message' => 'Session started successfully',
        'data'    => $data
    ]);
}
public function end_session_api($id)
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
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Invalid or missing token',
            'data'    => null
        ]);
        return;
    }

    $provider_id = (int)$decoded->data->id;

    // 2️⃣ Fetch Session
    $session = $this->Live_session_model->getSession($id);

    if (!$session || (int)$session['provider_id'] !== $provider_id) {
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Session not found or access denied',
            'data'    => null
        ]);
        return;
    }

    // 3️⃣ Update session status
    $endedAt = date('Y-m-d H:i:s');

    $this->Live_session_model->updateSession($id, [
        'status'   => 'completed',
        'ended_at' => $endedAt
    ]);

    // 4️⃣ Update bookings attendance
    // $this->Live_session_model->updateBookingsAttendance($id);

    // 5️⃣ Response
    echo json_encode([
        'status'  => true,
        'code'    => 200,
        'message' => 'Session ended successfully',
        'data'    => [
            'session_id' => $id,
            'status'     => 'completed',
            'ended_at'   => $endedAt
        ]
    ]);
}
public function session_details_api($id)
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
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Invalid or missing token',
            'data'    => null
        ]);
        return;
    }

    $provider_id = (int)$decoded->data->id;

    // 2️⃣ Fetch Session
    $session = $this->Live_session_model->getSession($id);

    if (!$session || (int)$session['provider_id'] !== $provider_id) {
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Session not found or access denied',
            'data'    => null
        ]);
        return;
    }

    // 3️⃣ Get participants data
    $participants = $this->Live_session_model->getSessionBookings($id);

    $totalBooked   = count($participants);
    $totalJoined   = 0;

    foreach ($participants as $p) {
        // adjust condition as per your DB field
        if (!empty($p['join_time']) || (!empty($p['attendance']) && $p['attendance'] == 1)) {
            $totalJoined++;
        }
    }

    // 4️⃣ Calculate duration (only if completed)
    $duration = null;
    if (!empty($session['started_at']) && !empty($session['ended_at'])) {
        $seconds = strtotime($session['ended_at']) - strtotime($session['started_at']);
        $duration = gmdate('H:i:s', $seconds);
    }

    // 5️⃣ Response
    echo json_encode([
        'status'  => true,
        'code'    => 200,
        'message' => 'Session details fetched successfully',
        'data'    => [
            'session_id'        => $session['id'],
            'title'             => $session['title'] ?? '',
            'status'            => $session['status'],
            'started_at'        => $session['started_at'],
            'ended_at'          => $session['ended_at'],
            'duration'          => $duration,

            'total_booked'      => $totalBooked,
            'total_joined'      => $totalJoined,
            'total_not_joined'  => $totalBooked - $totalJoined,

            'participants'      => $participants
        ]
    ]);
}
public function notifications_get()
{
    header('Content-Type: application/json');

    /* ================= JWT ================= */
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

    $provider_id = (int)$decoded->data->id;

    /* ================= BASE NOTIFICATIONS ================= */
    $rows = $this->db
        ->where('provider_id', $provider_id)
        ->order_by('id', 'DESC')
        ->get('provider_notifications')
        ->result_array();

    $notifications = [];

    foreach ($rows as $n) {

        $item = [
            'id'         => $n['id'],
            'type'       => $n['type'],
            'title'      => $n['title'],
            'message'    => $n['message'],
            'is_read'    => (int)$n['is_read'],
            'created_at'=> $n['created_at'],
            'data'       => null
        ];

        /* ================= SERVICE BOOKING ================= */
        if ($n['type'] === 'service') {
            $booking = $this->db
                ->select('
                    o.id AS order_id,
                    o.total AS amount,
                    oi.duration,
                    oi.start_date,
                    u.name AS user_name,
                    u.mobile AS user_mobile
                ')
                ->from('orders o')
                ->join('order_items oi', 'oi.id = '.$n['order_item_id'], 'left')
                ->join('users u', 'u.id = o.user_id', 'left')
                ->where('o.id', $n['order_id'])
                ->get()
                ->row_array();

            $item['data'] = $booking;
        }

        /* ================= SESSION BOOKING ================= */
        elseif ($n['type'] === 'session') {
            $session = $this->db
                ->select('
                    so.id AS session_order_id,
                    so.amount,
                    ls.title AS session_title,
                    ls.session_date,
                    ls.start_time,
                    u.name AS user_name,
                    u.mobile AS user_mobile
                ')
                ->from('session_orders so')
                ->join('live_sessions ls', 'ls.id = so.session_id', 'left')
                ->join('users u', 'u.id = so.user_id', 'left')
                ->where('so.id', $n['session_order_id'])
                ->get()
                ->row_array();

            $item['data'] = $session;
        }

        /* ================= PAYOUT ================= */
        elseif ($n['type'] === 'payout') {
            $payout = $this->db
                ->select('amount, status, updated_at')
                ->where('id', $n['payout_id'])
                ->get('provider_payouts')
                ->row_array();

            $item['data'] = $payout;
        }

        $notifications[] = $item;
    }

    /* ================= RESPONSE ================= */
    echo json_encode([
        'status' => true,
        'code'   => 200,
        'msg'    => 'Notification list',
        'data'   => $notifications
    ]);
}




public function notification_read($notification_id = null)
{
    header('Content-Type: application/json');

    // 🔐 Verify JWT
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    $decoded = $this->verify_jwt($token);
    if (!$decoded || empty($decoded->data->id)) {
        echo json_encode([
            'status' => false,
            'code'   => 400,
            'msg'    => 'Invalid or missing token',
            'data'   => null
        ]);
        return;
    }

    $provider_id = (int)$decoded->data->id;
    if (!$provider_id) {
        echo json_encode([
            'status' => false,
            'code'   => 400,
            'msg'    => 'Unauthorized',
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

    // 🔍 Ownership check
    $exists = $this->db
        ->where('id', $notification_id)
        ->where('provider_id', $provider_id)
        ->get('provider_notifications')
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

    // ✅ Mark as read
    $this->db->where('id', $notification_id)->update(
        'provider_notifications',
        ['is_read' => 1]
    );

    echo json_encode([
        'status' => true,
        'code'   => 200,
        'msg'    => 'Notification marked as read',
        'data'   => null
    ]);
}

public function notification_delete($notification_id = null)
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
    preg_match('/Bearer\s(\S+)/', $authHeader, $matches);
    $decoded = $this->verify_jwt($matches[1] ?? null);

    if (!$decoded || empty($decoded->data->id)) {
        echo json_encode([
            'status' => false,
            'code'   => 400,
            'msg'    => 'Invalid or missing token',
            'data'   => null
        ]);
        return;
    }

    $provider_id = (int)$decoded->data->id;

    if (empty($notification_id)) {
        echo json_encode([
            'status' => false,
            'code'   => 400,
            'msg'    => 'Notification ID missing',
            'data'   => null
        ]);
        return;
    }

    // 🔍 Check ownership
    $exists = $this->db
        ->where('id', $notification_id)
        ->where('provider_id', $provider_id)
        ->get('provider_notifications')
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

    // ❌ Delete notification
    $this->db
        ->where('id', $notification_id)
        ->where('provider_id', $provider_id)
        ->delete('provider_notifications');

    echo json_encode([
        'status' => true,
        'code'   => 200,
        'msg'    => 'Notification deleted successfully',
        'data'   => null
    ]);
}
public function notification_delete_all()
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
    preg_match('/Bearer\s(\S+)/', $authHeader, $matches);
    $decoded = $this->verify_jwt($matches[1] ?? null);

    if (!$decoded || empty($decoded->data->id)) {
        echo json_encode([
            'status' => false,
            'code'   => 400,
            'msg'    => 'Invalid or missing token',
            'data'   => null
        ]);
        return;
    }

    $provider_id = (int)$decoded->data->id;

    
    $this->db
        ->where('provider_id', $provider_id)
        ->delete('provider_notifications');

    echo json_encode([
        'status' => true,
        'code'   => 200,
        'msg'    => 'All notifications deleted successfully',
        'data'   => null
    ]);
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
                    'code' => 401,
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

        private function generate_jwt($user)
    {
        $payload = [
            'iss' => base_url(),
            'iat' => time(),
            'exp' => time() + (10 * 365 * 24 * 60 * 60),           
            
            'data' => [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email ?? '',
                'mobile'     => $user->mobile,
                'store_name' => $user->gym_name ?? '',
                'role'       => $user->role ?? '0'
            ]
        ];
        return JWT::encode($payload, $this->jwt_secret, 'HS256');
    }



}
