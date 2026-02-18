<?php

defined('BASEPATH') or exit('No direct script access allowed');

use \Firebase\JWT\JWT;

use \Firebase\JWT\Key;

class Api extends CI_Controller
{

    private $jwt_secret = 'b8d2f4e5a9c7d3b1f6e8a2c4d5f9b0a7e1c3f2d496ab89ce07df12345678abcd';

    public function __construct()
    {

        parent::__construct();

        $this->load->model('general_model');

         $this->load->library(['session']);

        $this->load->helper(['url', 'form']);

        require_once APPPATH . '../vendor/autoload.php';

        header("Access-Control-Allow-Origin: *"); 

        header("Content-Type: application/json; charset=UTF-8");
        $this->load->library('email');
        $this->load->library(['form_validation']);



    }


public function login()
{
    header('Content-Type: application/json');

    $input_data = json_decode($this->input->raw_input_stream, true);
    $mobile   = trim($input_data['mobile'] ?? '');
    $password = trim($input_data['password'] ?? '');

    if (empty($mobile) || empty($password)) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Mobile number and password are required',
                'data'    => null
            ]));
    }

    $user = $this->db->get_where('users', ['mobile' => $mobile])->row();

    if (!$user) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode(['status' => false, 'code' => 400, 'message' => 'User not found', 'data' => null]));
    }

    if ((int)$user->role !== 0 || $user->password !== md5($password)) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode(['status' => false, 'code' => 400, 'message' => 'Invalid credentials', 'data' => null]));
    }

    if ((int)$user->isActive !== 1) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode(['status' => false, 'code' => 400, 'message' => 'Your account is not active yet', 'data' => null]));
    }

    $company_name = '';
    if (!empty($user->company_id)) {
        $company = $this->db->get_where('company', ['id' => $user->company_id])->row();
        if ($company && (int)$company->isActive === 1) {
            $company_name = $company->company_name;
        }
    }

    $token = $this->generate_jwt($user);

    $response = [
        'status'  => true,
        'code'    => 200,
        'message' => 'Login successful',
        'data'    => [
            'token' => $token,
            'user' => [
                'id'              => $user->id,
                'name'            => $user->name,
                'mobile'          => $user->mobile,
                'email'           => $user->email,
                'location'           => $user->location,

                'vehical_name'    => $user->vehical_name,
                'vehical_number'  => $user->vehical_number,
                'licence_no'      => $user->licence_no,
                'company_id'      => $user->company_id,
                'company_name'    => $company_name,
                'profile_image'   => !empty($user->profile_image) ? base_url($user->profile_image) : null
            ]
        ]
    ];

    return $this->output
        ->set_status_header(200)
        ->set_output(json_encode($response));
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

public function register()
{
    header('Content-Type: application/json');

    // Handle both form-data (file + fields) and raw JSON
    $input_data = !empty($_POST) ? $_POST : json_decode($this->input->raw_input_stream, true);

    if (empty($input_data)) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'No input data provided',
                'data' => null
            ]));
    }

    $driver_name     = trim($input_data['driver_name'] ?? '');
    $mobile          = trim($input_data['mobile'] ?? '');
    $email           = trim($input_data['email'] ?? '');
    $location          = trim($input_data['location'] ?? '');
    $company_id      = isset($input_data['company_id']) ? (int)$input_data['company_id'] : null;
    $vehicle_name    = trim($input_data['vehicle_name'] ?? '');
    $vehicle_number  = trim($input_data['vehicle_number'] ?? '');
    $licence_number  = trim($input_data['licence_number'] ?? '');
    $password        = trim($input_data['password'] ?? '');

    if (empty($driver_name) || empty($mobile) || empty($password)) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Driver name, mobile, and password are required',
                'data' => null
            ]));
    }

    // Check duplicate mobile
    $existing = $this->db->get_where('users', ['mobile' => $mobile])->row();
    if ($existing) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'User already exists',
                'data' => null
            ]));
    }

    // ✅ Handle Profile Image Upload (optional)
    $profile_image = null;
    if (!empty($_FILES['profile_image']['name'])) {
        $upload_path = FCPATH . 'uploads/profile/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048; // 2 MB
        $config['file_name']     = 'driver_' . time() . '_' . rand(1000, 9999);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('profile_image')) {
            $upload_data   = $this->upload->data();
            $profile_image = 'uploads/profile/' . $upload_data['file_name'];
        }
    }

    // Insert driver
    $insertData = [
        'name'            => $driver_name,
        'mobile'          => $mobile,
        'email'           => $email,
        'location'        => $location,
        'company_id'      => $company_id,
        'vehical_name'    => $vehicle_name,
        'vehical_number'  => $vehicle_number,
        'licence_no'      => $licence_number,
        'password'        => md5($password),
        'role'            => 0,
        'isActive'        => 1,
        'profile_image'   => $profile_image,
        'created_at'      => date('Y-m-d H:i:s')
    ];

    $this->db->insert('users', $insertData);
    $user_id = $this->db->insert_id();

    // Fetch company name
    $company_name = '';
    if ($company_id) {
        $company = $this->db->get_where('company', ['id' => $company_id])->row();
        if ($company && (int)$company->isActive === 1) {
            $company_name = $company->company_name;
        }
    }

    $user_data = $this->db->get_where('users', ['id' => $user_id])->row();
    $token = $this->generate_jwt($user_data);

    $response = [
        'status'  => true,
        'code'    => 200,
        'message' => 'Driver registered successfully',
        'token'   => $token,
        'data'    => [
            'id'             => $user_id,
            'name'           => $driver_name,
            'mobile'         => $mobile,
            'email'          => $email,
            'location'       => $location,
            'vehical_name'   => $vehicle_name,
            'vehical_number' => $vehicle_number,
            'licence_no'     => $licence_number,
            'company_id'     => $company_id,
            'company_name'   => $company_name,
            'profile_image'  => !empty($profile_image) ? base_url($profile_image) : null,
            'isActive'       => 1,
            'role'           => 0
        ]
    ];

    return $this->output
        ->set_status_header(200)
        ->set_output(json_encode($response));
}

public function dashboard(){
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
                'status'  => false,
                'code'    => 401,
                'message' => 'Invalid token or user ID missing',
                'data'    => null
            ]));
    }

    $user_id = (int)$decoded->data->id;

    // 2️⃣ Prepare date filters
    $today = date('Y-m-d');
    $first_day_of_month = date('Y-m-01');

    // 3️⃣ Get today trip count
    $today_trip_count = $this->db
        ->where('user_id', $user_id)
        ->where('trip_date', $today)
        ->count_all_results('trips');

    // 4️⃣ Get this month trip count
    $month_trip_count = $this->db
        ->where('user_id', $user_id)
        ->where('trip_date >=', $first_day_of_month)
        ->where('trip_date <=', $today)
        ->count_all_results('trips');

    $this->db->select('SUM(end_km - start_km) as total_km');
    $this->db->where('user_id', $user_id);
    $this->db->where('trip_date', $today);
    $this->db->where('end_km IS NOT NULL', null, false);
    $total_km = $this->db->get('trips')->row()->total_km ?? 0;

    $this->db->select('SUM(TIMESTAMPDIFF(SECOND, start_time, end_time))/3600 as total_hours', false);
    $this->db->where('user_id', $user_id);
    $this->db->where('trip_date', $today);
    $this->db->where('end_time IS NOT NULL', null, false);
    $total_hours = $this->db->get('trips')->row()->total_hours ?? 0;

   $today_trips = $this->db
    ->where('user_id', $user_id)
    ->where('trip_date', $today)
    ->order_by('id', 'DESC')   // <-- show latest created trips first
    ->get('trips')
    ->result();


    // 8️⃣ Prepare response
    $response = [
        'status'  => true,
        'code'    => 200,
        'message' => 'Dashboard data fetched successfully',
        'data'    => [
            'today_trip_count'  => (int)$today_trip_count,
            'month_trip_count'  => (int)$month_trip_count,
            'total_km_today'    => (float)$total_km,
            'total_hours_today' => round((float)$total_hours, 2),
            'today_trips'       => $today_trips
        ]
    ];

    return $this->output
        ->set_status_header(200)
        ->set_output(json_encode($response));
}

public function get_company()
{
   
    $companies = $this->db->select('id, company_name')
                          ->from('company')
                          ->where('isActive', 1)
                          ->get()
                          ->result();

    return $this->output
        ->set_status_header(200)
        ->set_output(json_encode([
            'status'  => true,
            'code'    => 200,
            'message' => 'Companies fetched successfully',
            'data'    => $companies
        ]));
}
public function get_profile() {
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
                'message' => 'Invalid token or user ID missing',
                'data'    => null
            ]));
    }

    $user_id = $decoded->data->id;
    $user = $this->db->get_where('users', ['id' => $user_id])->row();

    if (!$user) {
        return $this->output
            ->set_status_header(404)
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'User not found',
                'data'    => null
            ]));
    }

    // Get company name if active
    $company_name = '';
    if ($user->company_id) {
        $company = $this->db->get_where('company', ['id' => $user->company_id, 'isActive' => 1])->row();
        if ($company) {
            $company_name = $company->company_name;
        }
    }

    return $this->output
        ->set_status_header(200)
        ->set_content_type('application/json')
        ->set_output(json_encode([
            'status'  => true,
            'code'    => 200,
            'message' => 'Profile fetched successfully',
            'data'    => [
                'id'             => $user->id,
                'name'           => $user->name,
                'mobile'         => $user->mobile,
                'profile_image'  => $user->profile_image,
                'email'          => $user->email,
                'location'          => $user->location,
                'password'          => $user->normal_password,
                'vehical_name'   => $user->vehical_name,
                'vehical_number' => $user->vehical_number,
                'licence_no'     => $user->licence_no,
                'company_id'     => $user->company_id,
                'company_name'   => $company_name,
                'isActive'       => $user->isActive,
                'role'           => $user->role
            ]
        ]));
}
public function update_profile()
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
                'status'  => false,
                'code'    => 401,
                'message' => 'Invalid token or user ID missing',
                'data'    => null
            ]));
    }

    $user_id = $decoded->data->id;

    $input_data = !empty($_POST) ? $_POST : [];
    if (empty($input_data) && empty($_FILES)) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'No input data provided',
                'data'    => null
            ]));
    }

    // ✅ Fetch current user details
    $current_user = $this->db->get_where('users', ['id' => $user_id])->row();

    if (!$current_user) {
        return $this->output
            ->set_status_header(404)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'User not found',
                'data'    => null
            ]));
    }

    $new_mobile = $input_data['mobile'] ?? '';

    // ✅ Check if the new mobile number already exists for another user
    if (!empty($new_mobile) && $new_mobile !== $current_user->mobile) {
        $existing_mobile = $this->db
            ->where('mobile', $new_mobile)
            ->where('id !=', $user_id)
            ->get('users')
            ->row();

        if ($existing_mobile) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'code'    => 400,
                    'message' => 'Mobile number already in use, please use a different number',
                    'data'    => null
                ]));
        }
    }

  // ✅ Prepare update data
$updateData = [
    'name'           => trim($input_data['name'] ?? ''),
    'mobile'         => $new_mobile,
    'email'          => $input_data['email'] ?? '',
    'location'       => $input_data['location'] ?? '',
    'vehical_name'   => $input_data['vehical_name'] ?? '',
    'vehical_number' => $input_data['vehical_number'] ?? '',
    'licence_no'     => $input_data['licence_no'] ?? '',
    'company_id'     => $input_data['company_id'] ?? null,
    'created_at'     => date('Y-m-d H:i:s')
];

// ✅ Password handling (store both md5 + plain)
if (!empty($input_data['password'])) {
    $plain_password = trim($input_data['password']);
    $updateData['password'] = md5($plain_password);
    $updateData['normal_password'] = $plain_password;
}


    // ✅ Handle Profile Image Upload (optional)
    if (!empty($_FILES['profile_image']['name'])) {
        $upload_path = FCPATH . 'uploads/profile/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048; // 2 MB
        $config['file_name']     = 'driver_' . time() . '_' . rand(1000, 9999);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('profile_image')) {
            $upload_data = $this->upload->data();
            $updateData['profile_image'] = 'uploads/profile/' . $upload_data['file_name'];
        } else {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'code'    => 400,
                    'message' => $this->upload->display_errors('', ''),
                    'data'    => null
                ]));
        }
    }

    // ✅ Update user data
    $this->db->where('id', $user_id)->update('users', $updateData);

    // ✅ Fetch updated user
    $user = $this->db->get_where('users', ['id' => $user_id])->row();

    // ✅ Fetch company name if active
    $company_name = '';
    if ($user->company_id) {
        $company = $this->db->get_where('company', ['id' => $user->company_id, 'isActive' => 1])->row();
        if ($company) {
            $company_name = $company->company_name;
        }
    }

    // ✅ Return success response
    return $this->output
        ->set_status_header(200)
        ->set_output(json_encode([
            'status'  => true,
            'code'    => 200,
            'message' => 'Profile updated successfully',
            'data'    => [
                'id'             => $user->id,
                'name'           => $user->name,
                'mobile'         => $user->mobile,
                'email'          => $user->email,
                'location'       => $user->location,
                'password'       => $user->normal_password,
                'vehical_name'   => $user->vehical_name,
                'vehical_number' => $user->vehical_number,
                'licence_no'     => $user->licence_no,
                'company_id'     => $user->company_id,
                'company_name'   => $company_name,
                'profile_image'  => !empty($user->profile_image) ? base_url($user->profile_image) : null,
                'isActive'       => $user->isActive,
                'role'           => $user->role
            ]
        ]));
}




public function create_trip()
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
            ->set_status_header(400)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Invalid token or user ID missing',
                'data'    => null
            ]));
    }

    $user_id = (int)$decoded->data->id;

    // 2️⃣ Get driver/vehicle details
    $user = $this->db->select('vehical_number,name')->where('id', $user_id)->get('users')->row();

    if (empty($user) || empty($user->vehical_number)) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Vehicle number not found',
                'data'    => null
            ]));
    }

    $vehical_number = $user->vehical_number;
    $driver_name = $user->name;

    
    $input_data = json_decode($this->input->raw_input_stream, true);

    
    $base_required = ['trip_date', 'start_time', 'start_km',  'customer_name', 'customer_mobile'];

    
    if (isset($input_data['trip_type']) && strtolower($input_data['trip_type']) !== 'oncall') {
        $base_required[] = 'from_location';
        $base_required[] = 'to_location';
    }

    // 4️⃣ Validate fields
    foreach ($base_required as $field) {
        if (empty($input_data[$field])) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'code'    => 400,
                    'message' => "Field '$field' is required",
                    'data'    => null
                ]));
        }
    }

    // ✅ Additional validation: trip_details is required for oncall
    if (strtolower($input_data['trip_type']) === 'oncall' && empty($input_data['trip_details'])) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => "Field 'trip_details' is required",
                'data'    => null
            ]));
    }

    // 5️⃣ Prepare trip data
    $trip_data = [
        'user_id'        => $user_id,
        'trip_type'      => $input_data['trip_type'],
        'vehicle_number' => $vehical_number,
        'driver_name'    => $driver_name,
        'trip_date'      => $input_data['trip_date'],
        'start_time'     => $input_data['start_time'],
        'end_time'       => null,
        'start_km'       => $input_data['start_km'],
        'end_km'         => null,
        'customer_name'  => $input_data['customer_name'],
        'customer_mobile'=> $input_data['customer_mobile'],
        'status'         => 'running',
        'created_at'     => date('Y-m-d H:i:s'),
    ];

    // 6️⃣ Handle "oncall" case
    if (strtolower($input_data['trip_type']) === 'oncall') {
        $trip_data['trip_details'] = $input_data['trip_details'];
        $trip_data['from_location'] = null;
        $trip_data['to_location']   = null;
    } else {
        $trip_data['from_location'] = $input_data['from_location'];
        $trip_data['to_location']   = $input_data['to_location'];
        $trip_data['trip_details']  = isset($input_data['trip_details']) ? $input_data['trip_details'] : null;
    }

    // 7️⃣ Insert into DB
    $this->db->insert('trips', $trip_data);
    $trip_id = $this->db->insert_id();

    // ✅ Return success
    return $this->output
        ->set_status_header(200)
        ->set_output(json_encode([
            'status'  => true,
            'code'    => 200,
            'message' => 'Trip created successfully',
            'data'    => ['trip_id' => $trip_id, 'trip' => $trip_data]
        ]));
}

// public function update_trip()
// {
//     header('Content-Type: application/json');

//     // 1️⃣ Verify JWT
//     $authHeader = $this->input->get_request_header('Authorization', TRUE);
//     $token = null;

//     if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
//         $token = $matches[1];
//     }

//     $decoded = $this->verify_jwt($token);
//     if (!$decoded || empty($decoded->data->id)) {
//         return $this->output
//             ->set_status_header(401)
//             ->set_output(json_encode([
//                 'status'  => false,
//                 'code'    => 401,
//                 'message' => 'Invalid token or user ID missing',
//                 'data'    => null
//             ]));
//     }

//     $user_id = (int)$decoded->data->id;

//     // 2️⃣ Parse JSON input
//     $input_data = json_decode($this->input->raw_input_stream, true);

//     if (empty($input_data['trip_id'])) {
//         return $this->output
//             ->set_status_header(400)
//             ->set_output(json_encode([
//                 'status'  => false,
//                 'code'    => 400,
//                 'message' => 'trip_id is required',
//                 'data'    => null
//             ]));
//     }

//     $trip_id = (int)$input_data['trip_id'];

//     // 3️⃣ Verify that trip belongs to the user
//     $trip = $this->db->where('id', $trip_id)
//                      ->where('user_id', $user_id)
//                      ->get('trips')
//                      ->row();

//     if (!$trip) {
//         return $this->output
//             ->set_status_header(404)
//             ->set_output(json_encode([
//                 'status'  => false,
//                 'code'    => 404,
//                 'message' => 'Trip not found or does not belong to this user',
//                 'data'    => null
//             ]));
//     }

//     // 4️⃣ Check if the update is to complete the trip
//     $is_complete = isset($input_data['is_complete']) && $input_data['is_complete'] == true;

//     if ($is_complete) {
//         // Completing the trip
//         if (empty($input_data['end_time']) || empty($input_data['end_km'])) {
//             return $this->output
//                 ->set_status_header(400)
//                 ->set_output(json_encode([
//                     'status'  => false,
//                     'code'    => 400,
//                     'message' => 'end_time and end_km are required to complete trip',
//                     'data'    => null
//                 ]));
//         }

//         $update_data = [
//             'end_time'   => $input_data['end_time'],
//             'end_km'     => $input_data['end_km'],
//             'status'     => 'completed',
//             'created_at' => date('Y-m-d H:i:s')
//         ];
//     } else {
//         $update_data = [];

//         if (isset($input_data['from_location'])) {
//             $update_data['from_location'] = $input_data['from_location'];
//         }
//         if (isset($input_data['to_location'])) {
//             $update_data['to_location'] = $input_data['to_location'];
//         }
//         if (isset($input_data['customer_name'])) {
//             $update_data['customer_name'] = $input_data['customer_name'];
//         }
//         if (isset($input_data['customer_mobile'])) {
//             $update_data['customer_mobile'] = $input_data['customer_mobile'];
//         }

//         if (empty($update_data)) {
//             return $this->output
//                 ->set_status_header(400)
//                 ->set_output(json_encode([
//                     'status'  => false,
//                     'code'    => 400,
//                     'message' => 'No valid fields to update',
//                     'data'    => null
//                 ]));
//         }

//         $update_data['created_at'] = date('Y-m-d H:i:s');
//     }

//     // 5️⃣ Perform update
//     $this->db->where('id', $trip_id)
//              ->where('user_id', $user_id)
//              ->update('trips', $update_data);

//     // 6️⃣ Response
//     return $this->output
//         ->set_status_header(200)
//         ->set_output(json_encode([
//             'status'  => true,
//             'code'    => 200,
//             'message' => $is_complete ? 'Trip completed successfully' : 'Trip updated successfully',
//             'data'    => [
//                 'trip_id' => $trip_id,
//                 'is_complete' => $is_complete,
//                 'update_fields' => $update_data
//             ]
//         ]));
// }
public function update_trip()
{
    header('Content-Type: application/json');

    // ✅ 1. Verify JWT
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

    $user_id = (int)$decoded->data->id;

    // ✅ 2. Parse JSON input
    $input_data = json_decode($this->input->raw_input_stream, true);
    if (empty($input_data['trip_id'])) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'trip_id is required',
                'data'    => null
            ]));
    }

    $trip_id = (int)$input_data['trip_id'];

    // ✅ 3. Verify trip belongs to user
    $trip = $this->db->where('id', $trip_id)
                     ->where('user_id', $user_id)
                     ->get('trips')
                     ->row();

    if (!$trip) {
        return $this->output
            ->set_status_header(404)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Trip not found or does not belong to this user',
                'data'    => null
            ]));
    }

    $update_data = [];

    // ✅ 4. OTP verification (can be combined with completion)
    if (!empty($input_data['isVerify']) && $input_data['isVerify'] == true) {
        if (empty($trip->otp)) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'code'    => 400,
                    'message' => 'Please request OTP first',
                    'data'    => null
                ]));
        }

        if (empty($input_data['otp']) || $input_data['otp'] != $trip->otp) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'code'    => 400,
                    'message' => 'Invalid OTP',
                    'data'    => null
                ]));
        }

        // ✅ Mark OTP verified
        $update_data['otp_verified'] = 1;
    }

    // ✅ 5. Update fields if provided
    if (isset($input_data['from_location'])) {
        $update_data['from_location'] = $input_data['from_location'];
    }
    if (isset($input_data['to_location'])) {
        $update_data['to_location'] = $input_data['to_location'];
    }
    if (isset($input_data['customer_name'])) {
        $update_data['customer_name'] = $input_data['customer_name'];
    }
    if (isset($input_data['customer_mobile'])) {
        $update_data['customer_mobile'] = $input_data['customer_mobile'];
    }

    // ✅ 6. Trip completion logic
    if (!empty($input_data['is_complete']) && $input_data['is_complete'] == true) {
        if (empty($input_data['end_time']) || empty($input_data['end_km'])) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'code'    => 400,
                    'message' => 'end_time and end_km are required to complete trip',
                    'data'    => null
                ]));
        }

        $update_data['end_time'] = $input_data['end_time'];
        $update_data['end_km']   = $input_data['end_km'];
        $update_data['status']   = 'completed';
    }

    // ✅ 7. Ensure there's something to update
    if (empty($update_data)) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'No valid fields to update',
                'data'    => null
            ]));
    }

    // ✅ 8. Update trip
    $update_data['updated_at'] = date('Y-m-d H:i:s');

    $this->db->where('id', $trip_id)
             ->where('user_id', $user_id)
             ->update('trips', $update_data);

    // ✅ 9. Fetch full updated trip details
    $updated_trip = $this->db->where('id', $trip_id)->get('trips')->row_array();

    // ✅ 10. Return final response
    return $this->output
        ->set_status_header(200)
        ->set_output(json_encode([
            'status'  => true,
            'code'    => 200,
            'message' => !empty($input_data['is_complete']) && $input_data['is_complete']
                ? 'Trip completed successfully'
                : (!empty($input_data['isVerify']) ? 'OTP verified successfully' : 'Trip updated successfully'),
            'data'    => $updated_trip
        ]));
}


public function verify_otp()
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
                'status'  => false,
                'code'    => 401,
                'message' => 'Invalid token or user ID missing',
                'data'    => null
            ]));
    }

    $user_id = (int)$decoded->data->id;

    // 2️⃣ Parse JSON input
    $input_data = json_decode($this->input->raw_input_stream, true);
    $trip_id = isset($input_data['trip_id']) ? (int)$input_data['trip_id'] : null;

    if (empty($trip_id)) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Trip ID is required',
                'data' => null
            ]));
    }

    // 3️⃣ Verify that trip belongs to the user
    $trip = $this->db->where('id', $trip_id)
                     ->where('user_id', $user_id)
                     ->get('trips')
                     ->row_array();

    if (!$trip) {
        return $this->output
            ->set_status_header(404)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Trip not found or does not belong to this user',
                'data'    => null
            ]));
    }

    // 4️⃣ Fetch user's mobile from users table
    $user = $this->db->select('mobile')
                     ->where('id', $trip['user_id'])
                     ->get('users')
                     ->row_array();

    if (empty($user) || empty($user['mobile'])) {
        return $this->output
            ->set_status_header(404)
            ->set_output(json_encode([
                'status' => false,
                'code' => 400,
                'message' => 'Driver mobile number not found',
                'data' => null
            ]));
    }

    $mobileNo = $trip['customer_mobile'];

    // 5️⃣ Generate OTP
    $otp = rand(100000, 999999);

    // 6️⃣ Send OTP via SMS
    $sms_response = $this->send_otp_via_sms($mobileNo, $otp);
    if (!$sms_response) {
        return $this->output
            ->set_status_header(500)
            ->set_output(json_encode([
                'status' => false,
                'code' => 500,
                'message' => 'Failed to send OTP',
                'data' => null
            ]));
    }

    // 7️⃣ Store OTP in trips table
    $this->db->where('id', $trip_id)->update('trips', [
        'otp' => $otp,
        // 'otp_sent_at' => date('Y-m-d H:i:s')
    ]);

    // 8️⃣ Fetch updated trip
    $updated_trip = $this->db->where('id', $trip_id)->get('trips')->row_array();

    // 9️⃣ Return response
    return $this->output
        ->set_status_header(200)
        ->set_output(json_encode([
            'status'  => true,
            'code'    => 200,
            'message' => 'OTP sent successfully',
            'data'    => $updated_trip
        ]));
}

 public function send_otp_via_sms($mobileNo, $otp)
    {

        $message = "Hi $mobileNo\n\nYour Verification OTP is $otp Do not share this OTP with anyone for security reasons.\n\nRegards\nOMKARENT";



        $params = [

            'user' => 'Fitcketsp',

            'key' => '81a6b2f99cXX',

            'mobile' => '91' . $mobileNo,

            'message' => $message,

            'senderid' => 'OMENTO',

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

    public function add_fuel()
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
            'message' => 'Invalid or missing token.',
            'data'    => null
        ]);
        return;
    }

    $user_id = $decoded->data->id;

    // 2️⃣ Decode raw JSON data
    $input = json_decode($this->input->raw_input_stream, true);

    if (!$input) {
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Invalid JSON format.',
            'data'    => null
        ]);
        return;
    }

    // 3️⃣ Extract fields
    $driver_id = $user_id;
    $fuel_type = isset($input['fuel_type']) ? trim($input['fuel_type']) : '';
    $quantity  = isset($input['quantity']) ? trim($input['quantity']) : '';
    $amount    = isset($input['amount']) ? trim($input['amount']) : '';
    $km   = isset($input['km']) ? trim($input['km']) : '';

    $notes     = isset($input['notes']) ? trim($input['notes']) : null;

    // 4️⃣ Validate required fields
    if (empty($driver_id) || empty($fuel_type) || empty($quantity) || empty($amount)) {
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Missing required fields: fuel_type, quantity, or amount.',
            'data'    => null
        ]);
        return;
    }

    // 5️⃣ Prepare insert data
    $insertData = [
        'user_id'    => $user_id,
        'fuel_type'  => $fuel_type,
        'quantity'   => $quantity,
        'amount'     => $amount,
        'km'     => $km,

        'notes'      => !empty($notes) ? $notes : null,
        'isActive'   => 1,
        'created_on' => date('Y-m-d H:i:s'),
    ];

    // 6️⃣ Insert into DB
    $insert = $this->db->insert('fuel', $insertData);

    if ($insert) {
        echo json_encode([
            'status'  => true,
            'code'    => 200,
            'message' => 'Fuel record added successfully.',
            'data'    => [
                'insert_id' => $this->db->insert_id(),
                'fuel'      => $insertData
            ]
        ]);
    } else {
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Failed to add fuel record.',
            'data'    => null
        ]);
    }
}
public function get_fuel()
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
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'Invalid or missing token.',
            'data'    => null
        ]);
        return;
    }

    $user_id = $decoded->data->id;

    $month_name = $this->input->get('month');
    if ($month_name) {
        $month = date('m', strtotime($month_name)); 
    } else {
        $month = date('m'); 
    }

    $year = date('Y');

    $query = $this->db->query("
        SELECT id, user_id, fuel_type, quantity,km, amount, notes, isActive, created_on
        FROM fuel
        WHERE user_id = ?
        AND MONTH(created_on) = ?
        AND YEAR(created_on) = ?
        ORDER BY created_on DESC
    ", [$user_id, $month, $year]);

    $fuel_data = $query->result();

    // 4️⃣ Handle response
    if (!empty($fuel_data)) {
        echo json_encode([
            'status'  => true,
            'code'    => 200,
            'message' => 'Fuel records fetched successfully.',
            'data'    => $fuel_data
        ]);
    } else {
        echo json_encode([
            'status'  => false,
            'code'    => 400,
            'message' => 'No fuel records found for this month.',
            'data'    => []
        ]);
    }
}
public function all_trip_dummy()
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
                'status'  => false,
                'code'    => 401,
                'message' => 'Invalid token or user ID missing',
                'data'    => null
            ]));
    }

    $user_id = (int)$decoded->data->id;

    $input_data = json_decode($this->input->raw_input_stream, true);

    // --- 2️⃣ Trip Type Logic ---
    $trip_type_input = isset($input_data['trip_type']) ? strtolower(trim($input_data['trip_type'])) : null;
    
    // Default to 'fixcab' if trip_type is null or empty
    $trip_type = ($trip_type_input === 'oncall' || $trip_type_input === 'fixcab') 
                 ? $trip_type_input 
                 : 'fixcab'; 
    // ---------------------------

    // --- 3️⃣ Month Logic ---
    $month_input = isset($input_data['month']) ? trim($input_data['month']) : '';
    $current_month_flag = empty($month_input); // Check if month was provided

    if (!empty($month_input)) {
        $timestamp = strtotime($month_input);
        if ($timestamp === false) {
            return $this->output
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'code'    => 400,
                    'message' => 'Invalid month format. Use like "October 2025"',
                    'data'    => []
                ]));
        }

        $month = date('m', $timestamp);
        $year  = date('Y', $timestamp);
    } else {
        $month = date('m');
        $year  = date('Y');
    }
    // ---------------------------

    // 4️⃣ Fetch Trips with Filters (User ID, Date, and Trip Type)
    $this->db
        ->where('user_id', $user_id)
        ->where('MONTH(trip_date)', $month)
        ->where('YEAR(trip_date)', $year)
        ->where('trip_type', $trip_type); // Apply the new trip_type filter

    $trips = $this->db
        ->order_by('trip_date', 'DESC')
        ->order_by('created_at', 'DESC')
        ->get('trips')
        ->result_array();

    // 5️⃣ Fetch User Data
    $user = $this->db
        ->select('name, vehical_number, location, mobile, vehical_name')
        ->where('id', $user_id)
        ->get('users')
        ->row_array();

    $user_name        = isset($user['name']) ? $user['name'] : '';
    $vehical_number   = isset($user['vehical_number']) ? $user['vehical_number'] : '';
    $vehical_name     = isset($user['vehical_name']) ? $user['vehical_name'] : '';
    $location         = isset($user['location']) ? $user['location'] : '';
    $mobile           = isset($user['mobile']) ? $user['mobile'] : '';

    // 6️⃣ Handle No Trips Found
    if (empty($trips)) {
        $type_display = strtoupper($trip_type);
        $month_year_display = date('F Y', strtotime("$year-$month-01"));
        
        $message = "No **{$type_display}** trips found for {$month_year_display}";

        return $this->output
            ->set_status_header(404)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 404,
                'message' => $message,
                'data'    => []
            ]));
    }

    // 7️⃣ Prepare Response
    $driver_pass = [
        'vechical_number' => $vehical_number,
        'vechical_name'   => $vehical_name,
        'location'        => $location,
        'mobile'          => $mobile,
        'month'           => (int)$month,
        'year'            => (int)$year,
        'trip_type_filter'=> $trip_type // Indicate which type was filtered
    ];

    $month_year_display = date('F Y', strtotime("$year-$month-01"));

    return $this->output
        ->set_status_header(200)
        ->set_output(json_encode([
            'status'       => true,
            'code'         => 200,
            'message'      => 'Trips fetched successfully for ' . $month_year_display . ' (' . strtoupper($trip_type) . ')',
            'driver_pass'  => $driver_pass,
            'data'         => $trips
        ]));
}
public function all_trip()
{
    header('Content-Type: application/json');

    // --- 1️⃣ Authentication and User ID Retrieval ---
    $authHeader = $this->input->get_request_header('Authorization', TRUE);
    $token = null;

    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }

    $decoded = $this->verify_jwt($token);
    
    // Check for invalid token or missing user ID
    if (empty($decoded) || empty($decoded->data->id)) {
        return $this->response(false, 401, 'Invalid token or user ID missing');
    }

    $user_id = (int)$decoded->data->id;

    // --- 2️⃣ Input Processing (Month and Trip Type) ---
    $input_data = json_decode($this->input->raw_input_stream, true) ?? [];
    
    // Determine Trip Type: Default to 'fixcab'
    $trip_type_input = isset($input_data['trip_type']) ? strtolower(trim($input_data['trip_type'])) : 'fixcab';
    $trip_type = in_array($trip_type_input, ['fixcab', 'oncall']) ? $trip_type_input : 'fixcab';

    // Determine Month and Year
    $month_input = isset($input_data['month']) ? trim($input_data['month']) : '';

    if (!empty($month_input)) {
        $timestamp = strtotime($month_input);
        if ($timestamp === false) {
            return $this->response(false, 400, 'Invalid month format. Use like "October 2025"');
        }
        $month = date('m', $timestamp);
        $year  = date('Y', $timestamp);
    } else {
        // Default to current month/year
        $month = date('m');
        $year  = date('Y');
    }

    $month_year_display = date('F Y', strtotime("$year-$month-01"));
    $type_display = strtoupper($trip_type);

    // --- 3️⃣ Trip Data Retrieval ---
    $trips = $this->db
        ->where('user_id', $user_id)
        ->where('trip_type', $trip_type) // Apply the Trip Type filter
        ->where('MONTH(trip_date)', $month)
        ->where('YEAR(trip_date)', $year)
        ->order_by('trip_date', 'DESC')
        ->order_by('created_at', 'DESC')
        ->get('trips')
        ->result_array();

    // --- 4️⃣ User Data Retrieval ---
    $user = $this->db
        ->select('name, vehical_number, location, mobile, vehical_name')
        ->where('id', $user_id)
        ->get('users')
        ->row_array();
    
    // --- 5️⃣ Handle No Trips Found ---
    if (empty($trips)) {
        return $this->response(false, 404, "No **{$type_display}** trips found for {$month_year_display}");
    }

    // --- 6️⃣ Prepare and Send Success Response ---
    $driver_pass = [
        'vechical_number'  => $user['vehical_number'] ?? '',
        'vechical_name'    => $user['vehical_name'] ?? '',
        'location'         => $user['location'] ?? '',
        'mobile'           => $user['mobile'] ?? '',
        'month'            => (int)$month,
        'year'             => (int)$year,
        'trip_type_filter' => $trip_type
    ];

    return $this->response(
        true, 
        200, 
        "Trips fetched successfully for {$month_year_display} ({$type_display})", 
        $trips, 
        $driver_pass
    );
}

// --- Helper Function (Assumes you have a base controller or utility function) ---
// This function cleans up the repetitive JSON output.

private function response($status, $code, $message, $data = [], $driver_pass = null)
{
    $output = [
        'status'  => $status,
        'code'    => $code,
        'message' => $message,
    ];

    if ($driver_pass !== null) {
        $output['driver_pass'] = $driver_pass;
    }
    
    $output['data'] = $data;

    return $this->output
        ->set_status_header($code)
        ->set_output(json_encode($output));
}
public function get_singal_trip($trip_id = null)
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
                'status'  => false,
                'code'    => 401,
                'message' => 'Invalid token or user ID missing',
                'data'    => null
            ]));
    }

    $user_id = $decoded->data->id;

    // 2️⃣ Validate trip_id
    if (empty($trip_id) || !is_numeric($trip_id)) {
        return $this->output
            ->set_status_header(400)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Trip ID is required and must be numeric',
                'data'    => null
            ]));
    }

    // 3️⃣ Fetch trip details
    $trip = $this->db->where('id', $trip_id)->get('trips')->row_array();

    if (empty($trip)) {
        return $this->output
            ->set_status_header(404)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 400,
                'message' => 'Trip not found',
                'data'    => null
            ]));
    }

    // 4️⃣ Check if trip assigned to this user
    if ($trip['user_id'] != $user_id) {
        return $this->output
            ->set_status_header(403)
            ->set_output(json_encode([
                'status'  => false,
                'code'    => 403,
                'message' => 'This trip is not assigned to you',
                'data'    => null
            ]));
    }

    // 5️⃣ Fetch user details using user_id
    $user = $this->db->where('id', $trip['user_id'])->get('users')->row_array();

    // 6️⃣ Merge both arrays
    $trip_data = [
        'trip' => $trip,
        'user' => $user
    ];

    // 7️⃣ Response
    return $this->output
        ->set_status_header(200)
        ->set_output(json_encode([
            'status'  => true,
            'code'    => 200,
            'message' => 'Trip details fetched successfully',
            'data'    => $trip_data
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

        // 🔹 Check if token is blacklisted
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
            'exp' => time() + (365 * 24 * 60 * 60), // 1 year expiry

            // 'exp' => time() + (3600 * 24), // 24 hours expiry
            // 'exp' => time() + 3600, // 1hours expiry


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