<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Login extends CI_Controller
{



    public function __construct()
    {

        parent::__construct();

        $this->load->library(['session']);

        $this->load->helper(['url', 'form']);

        $this->load->model('general_model');

        $provider = $this->session->userdata('provider');



        $current_method = $this->router->fetch_method();



        if ($current_method !== 'logout') {

            if ($provider && isset($provider['is_logged_in']) && $provider['is_logged_in'] === true) {

                redirect('provider/dashboard');

            }

        }



    }



    public function index()
    {

        $this->load->view('provider/login_form');

    }



    public function send_otp()
    {

        $mobile = $this->input->post('mobile');

        if (!$mobile) {

            $this->session->set_flashdata('error', 'Mobile number is required.');

            redirect('provider');

        }

        $user = $this->general_model->getOne('users', ['mobile' => $mobile]);



        if (!$user) {

            $this->session->set_flashdata('error', 'User not found Please register.');

            redirect('provider');

        }

        if ($user->role == 1 || $user->role == 0) {

            $this->session->set_flashdata('error', 'Invalid mobile number.');

            redirect('provider');

        }



        $otp = rand(100000, 999999);

        $this->session->set_userdata('otp', $otp);

        $this->session->set_userdata('mobile', $mobile);





        $sms_sent = $this->send_otp_via_sms($mobile, $otp);



        if ($sms_sent) {

            $this->session->set_flashdata('success', 'OTP sent successfully.');

        } else {

            $this->session->set_flashdata('error', 'Failed to send OTP.');

            redirect('provider');

        }



        $masked_mobile = '*******' . substr($mobile, -4);

        $data['masked_mobile'] = $masked_mobile;

        $this->load->view('provider/otp_form', $data);



    }

  public function verify_otp()
{
    $input_otp   = $this->input->post('otp');
    $session_otp = $this->session->userdata('otp');
    $mobile      = $this->session->userdata('mobile');

    if ($input_otp == $session_otp) {

        $user = $this->db->get_where('users', ['mobile' => $mobile])->row_array();

        if ($user && $user['role'] == 2) {

            // Add flags
            $user['is_logged_in'] = true;
            $user['is_registered'] = true;

            // Store in session
            $this->session->set_userdata('provider', $user);

            echo json_encode(['redirect_url' => base_url('provider/dashboard')]);
            return;

        } else {
            // Public user fallback
            $public_user = [
                'mobile' => $mobile,
                'role'   => 0
            ];
            $this->session->set_userdata('user', $public_user);

            echo json_encode(['redirect_url' => base_url('home')]);
            return;
        }

    } else {
        http_response_code(401); // Unauthorized
        echo json_encode(['error' => 'Invalid OTP']);
    }
}


   public function send_register_otp()
{
    $this->load->library('form_validation');

    // Validation rules
    $this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
    $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
    $this->form_validation->set_rules('business_name', 'Business Name', 'required|trim');
    $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|numeric');

    if ($this->form_validation->run() == FALSE) {
        $this->load->view('provider/signup_form');
        return;
    }

    $mobile = $this->input->post('mobile', TRUE);
    $user = $this->db->get_where('users', ['mobile' => $mobile])->row_array();

    if ($user && $user['role'] == 2) {
        // Already a provider
        $this->session->set_flashdata('error', 'This mobile number is already registered as a provider.');
        redirect('provider/sing_up');
        return;
    }

    // Save form data in session
    $form_data = [
        'firstname'     => $this->input->post('firstname', TRUE),
        'lastname'      => $this->input->post('lastname', TRUE),
        'email'         => $this->input->post('email', TRUE),
        'business_name' => $this->input->post('business_name', TRUE),
        'mobile'        => $mobile
    ];
    $this->session->set_userdata('register_form_data', $form_data);

    // Generate OTP
    $otp = rand(100000, 999999);
    $this->session->set_userdata('otp', $otp);

    // Update role 0 → 2 if exists
    if ($user && $user['role'] == 0) {
        $this->db->where('mobile', $mobile)->update('users', ['role' => 2, 'otp_verified' => 0]);
    }

    // Send OTP
    $sms_sent = $this->send_otp_via_sms($mobile, $otp);

    if ($sms_sent) {
        $masked_mobile = '*******' . substr($mobile, -4);
        $data['masked_mobile'] = $masked_mobile;
        $this->load->view('provider/register_otp_form', $data);
    } else {
        $this->session->set_flashdata('error', 'Failed to send OTP.');
        redirect('provider/sing_up');
    }
}




   public function register_verify_otp()
{
    $entered_otp = $this->input->post('otp');
    $session_otp = $this->session->userdata('otp');
    $form_data = $this->session->userdata('register_form_data');

    if (!$form_data) {
        echo json_encode(['error' => 'Session expired. Please try again.']);
        return;
    }

    if ($entered_otp != $session_otp) {
        echo json_encode(['error' => 'Invalid OTP. Please try again.']);
        return;
    }

    $mobile = $form_data['mobile'];
    $user = $this->db->get_where('users', ['mobile' => $mobile])->row_array();

    if ($user) {
        // Update existing user (role 0 → 2)
        $this->db->where('mobile', $mobile)->update('users', [
            'gym_name'     => $form_data['business_name'],
            'name'         => $form_data['firstname'] . ' ' . $form_data['lastname'],
            'email'        => $form_data['email'],
            'role'         => 2,
            'otp_verified' => 1
        ]);

        $user_data = $this->db->get_where('users', ['mobile' => $mobile])->row_array();
    } else {
        // Insert new provider
        $this->db->insert('users', [
            'gym_name'     => $form_data['business_name'],
            'name'         => $form_data['firstname'] . ' ' . $form_data['lastname'],
            'mobile'       => $mobile,
            'email'        => $form_data['email'],
            'role'         => 2,
            'isActive'     => 1,
            'otp_verified' => 1,
            'created_at'   => date('Y-m-d')
        ]);

        $user_id = $this->db->insert_id();
        $user_data = $this->db->get_where('users', ['id' => $user_id])->row_array();
    }

    // Store provider session
    $user_data['is_logged_in'] = true;
    $user_data['is_registered'] = true;
    $this->session->set_userdata('provider', $user_data);

    // Cleanup
    $this->session->unset_userdata('otp');
    $this->session->unset_userdata('register_form_data');

    echo json_encode(['redirect_url' => base_url('provider/dashboard')]);
}









    public function sing_up()
    {



        $this->load->view('provider/signup_form');



    }



    public function logout()
    {

        $this->session->unset_userdata('provider');

        redirect('provider');

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







}

