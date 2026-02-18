<?php



defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/User_Controller.php');







class Login extends CI_Controller
{







    public function __construct()
    {

        parent::__construct();

        $this->load->library(['session']);

        $this->load->helper(['url', 'form']);

        $this->load->model('general_model');

        $user = $this->session->userdata('user');

// echo "<pre>";
// print_r($user);
// die;

        $current_method = $this->router->fetch_method();



        if ($current_method !== 'logout') {

            if ($user && isset($user['is_logged_in']) && $user['is_logged_in'] === true) {

                redirect(base_url());

            }

        }



    }



    public function index()
    {
        $redirect = $this->input->get('redirect');
        if ($redirect) {
            $this->session->set_userdata('redirect_after_login', urldecode($redirect));
        }
        $this->load->view('header');

        $this->load->view('login_view');

        $this->load->view('footer');

    }



    public function sign_in()
    {
        $redirect = $this->input->get('redirect');
        if ($redirect) {
            $this->session->set_userdata('redirect_after_login', urldecode($redirect));
        }
        $this->load->view('header');

        $this->load->view('sign_in_view');

        $this->load->view('footer');

    }



   public function send_otp()
{
    // Load form validation library
    $this->load->library('form_validation');

    // Set validation rules
    $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|numeric|min_length[10]|max_length[10]');

    if ($this->form_validation->run() == FALSE) {
        // Validation failed → reload login form with errors
       $this->load->view('header');

        $this->load->view('login_view');

        $this->load->view('footer');
        return;
    }

    $mobile = $this->input->post('mobile');

    // Check if user exists
    $user = $this->general_model->getOne('users', ['mobile' => $mobile]);

    if (!$user) {
        $this->session->set_flashdata('error', 'User not found. Please register.');
        redirect('login');
    }

    if ($user->role == 1) {
        $this->session->set_flashdata('error', 'Invalid mobile number.');
        redirect('login');
    }

    // Generate OTP
    $otp = rand(100000, 999999);
    $this->session->set_userdata('otp', $otp);
    $this->session->set_userdata('mobile', $mobile);

    $sms_sent = $this->send_otp_via_sms($mobile, $otp);

    if ($sms_sent) {
        $this->session->set_flashdata('success', 'OTP sent successfully.');
    } else {
        $this->session->set_flashdata('error', 'Failed to send OTP.');
        redirect('login');
    }

    $masked_mobile = '*******' . substr($mobile, -4);
    $data['masked_mobile'] = $masked_mobile;

    $this->load->view('otp_form', $data);
}



    public function verify_otp()
    {

        $input_otp = $this->input->post('otp');

        $session_otp = $this->session->userdata('otp');

        $mobile = $this->session->userdata('mobile');

        if ($input_otp == $session_otp) {

            $query = $this->db->get_where('users', ['mobile' => $mobile]);

            $user = $query->row_array();



            if ($user['role'] == 0 ||$user['role']==2 ) {

                $user['is_logged_in'] = true;

                $user['is_registered'] = true;



                $this->session->set_userdata('user', $user);



                $redirectUrl = $this->session->userdata('redirect_after_login');
                if ($redirectUrl) {
                    $this->session->unset_userdata('redirect_after_login');
                    echo json_encode(['redirect_url' => $redirectUrl]);
                } else {
                    echo json_encode(['redirect_url' => base_url()]);
                }

                return;

            } else {

                $this->session->set_flashdata('error', 'invalid credentails.');

                redirect('login');

            }

        } else {

            http_response_code(401);

            echo json_encode(['error' => 'Invalid OTP']);

        }

    }

   public function register_user()
{
    
    $this->load->library('form_validation');

    
    $this->form_validation->set_rules('first_name', 'First Name', 'required|trim');
    $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim');
    $this->form_validation->set_rules('mobile', 'Mobile Number', 'required|trim|is_unique[users.mobile]',
        ['is_unique' => 'This mobile number is already registered.']);
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

    if ($this->form_validation->run() == FALSE) {
        
        $data['old'] = $this->input->post(); 
        $this->load->view('header');

        $this->load->view('sign_in_view',$data);

        $this->load->view('footer');

        return;
    }

    $form_data = [
        'firstname' => $this->input->post('first_name'),
        'lastname'  => $this->input->post('last_name'),
        'email'     => $this->input->post('email'),
        'mobile'    => $this->input->post('mobile')
    ];

    $this->session->set_userdata('user_register_form_data', $form_data);

    // Generate OTP
    $otp = rand(100000, 999999);
    $this->session->set_userdata('otp', $otp);

    // Send OTP
    $sms_sent = $this->send_otp_via_sms($form_data['mobile'], $otp);
    if ($sms_sent) {
        $masked_mobile = '*******' . substr($form_data['mobile'], -4);
        $data['masked_mobile'] = $masked_mobile;
        $this->load->view('register_otp_form', $data);
    } else {
        $this->session->set_flashdata('error', 'Failed to send OTP.');
        redirect('login');
    }
}



    public function register_verify_otp()
    {

        $entered_otp = $this->input->post('otp');

        $session_otp = $this->session->userdata('otp');

        $form_data = $this->session->userdata('user_register_form_data');



        if (!$form_data) {

            echo json_encode(['error' => 'Session expired. Please try again.']);

            return;

        }

        if ($entered_otp == $session_otp) {



            $this->db->insert('users', [

                // 'gym_name' => $form_data['business_name'],

                'name' => $form_data['firstname'] . ' ' . $form_data['lastname'],

                'mobile' => $form_data['mobile'],

                'email' => $form_data['email'],

                'role' => 0,

                'isActive' => 1,

                'otp_verified' => 1,

                'created_at' => date('Y-m-d')

            ]);

            $user_id = $this->db->insert_id();



         $query = $this->db->get_where('users', ['id' => $user_id]);
$user_data = $query->row_array(); // ✅ returns array
$user_data['is_logged_in']  = true;
$user_data['is_registered'] = true;

$this->session->set_userdata('user', $user_data);



            $this->session->unset_userdata('otp');

            $this->session->unset_userdata('user_register_form_data');

            $redirectUrl = $this->session->userdata('redirect_after_login');
            if ($redirectUrl) {
                $this->session->unset_userdata('redirect_after_login');
                echo json_encode(['redirect_url' => $redirectUrl]);
            } else {
                echo json_encode(['redirect_url' => base_url()]);
            }


        } else {

            echo json_encode(['error' => 'Invalid OTP. Please try again.']);

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

    public function logout()
    {

        $this->session->unset_userdata('user');

        $this->session->unset_userdata('cart_items');



        redirect(base_url());

    }

}