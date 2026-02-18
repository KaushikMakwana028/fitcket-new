<?php







defined('BASEPATH') or exit('No direct script access allowed');



require_once(APPPATH . 'core/User_Controller.php');















class Profile extends User_Controller

{















    public function __construct()

    {















        parent::__construct();















    }





public function index($offset = 0)
{
    
    $limit = 9;

    $lat = floatval($this->session->userdata('user_lat') ?? 0);
    $lng = floatval($this->session->userdata('user_lng') ?? 0);

    // Get filters
    $price    = $this->input->get('price');
    $rating   = $this->input->get('rating');
    $exp      = $this->input->get('exp');
    $category = $this->input->get('category');
    $language = $this->input->get('language');
    $service  = $this->input->get('service');
    
    // ✅ ADD THIS: Get search parameter
    $search   = $this->input->get('search');

    /* ======================================================
       COUNT TOTAL RECORDS (WITH FILTERS)
    ====================================================== */
    $this->db->select('provider.id');
    $this->db->from('provider');
    $this->db->join('users', 'users.id = provider.provider_id', 'left');
    $this->db->join('reviews', 'reviews.provider_id = provider.provider_id', 'left');
    $this->db->where('users.isActive', 1);

    // ✅ ADD THIS: Search filter for COUNT
    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like('users.gym_name', $search, 'both');
        $this->db->or_like('users.name', $search, 'both'); // if you have provider name
        $this->db->group_end();
    }

    /* Category */
    if (!empty($category)) {
        $this->db->where('provider.category', $category);
    }

    /* Language (CSV field) */
    if (!empty($language)) {
        $this->db->where("FIND_IN_SET('" . $this->db->escape_str($language) . "', provider.language) >", 0, false);
    }

    /* Service Type */
    if (!empty($service)) {
        $this->db->where('provider.service_type', $service);
    }

    /* Experience */
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

    $this->db->group_by('provider.id');

    /* Rating Filter with HAVING */
    if (!empty($rating) && $rating != 'top_rated') {
        $min_rating = 0;
        switch ($rating) {
            case '4_plus': $min_rating = 4; break;
            case '3_plus': $min_rating = 3; break;
            case '2_plus': $min_rating = 2; break;
        }
        if ($min_rating > 0) {
            $this->db->having('IFNULL(AVG(reviews.rating), 0) >=', $min_rating, false);
        }
    }

    $count_query = $this->db->get_compiled_select();
    $count_result = $this->db->query("SELECT COUNT(*) as total FROM ($count_query) as count_table");
    $total_records = $count_result->row()->total;

    /* ======================================================
       FETCH PROVIDERS (WITH FILTERS)
    ====================================================== */
    $this->db->select("
        provider.id,
        provider.provider_id,
        provider.category,
        provider.language,
        provider.service_type,
        provider.exp,
        provider.latitude,
        provider.longitude,
        provider.day_price,        
        provider.month_price,
        provider.description,
        provider.profile_image,
        provider.created_on,
        MAX(users.gym_name) AS gym_name,
        MAX(users.name) AS provider_name,
        COUNT(DISTINCT service.id) AS service_count,
        ROUND(IFNULL(AVG(reviews.rating), 0), 1) AS avg_rating,
        COUNT(DISTINCT reviews.id) AS total_reviews,
        (6371 * acos(
            cos(radians($lat)) * cos(radians(provider.latitude)) *
            cos(radians(provider.longitude) - radians($lng)) +
            sin(radians($lat)) * sin(radians(provider.latitude))
        )) AS distance
    ", false);

    $this->db->from('provider');
    $this->db->join('users', 'users.id = provider.provider_id', 'left');
    $this->db->join('service', 'service.provider_id = provider.provider_id', 'left');
    $this->db->join('reviews', 'reviews.provider_id = provider.provider_id', 'left');

    $this->db->where('users.isActive', 1);

    // ✅ ADD THIS: Search filter for main query
    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like('users.gym_name', $search, 'both');
        $this->db->or_like('users.name', $search, 'both');
        $this->db->group_end();
    }

    /* Apply same filters again */
    if (!empty($category)) {
        $this->db->where('provider.category', $category);
    }

    if (!empty($language)) {
        $this->db->where("FIND_IN_SET('" . $this->db->escape_str($language) . "', provider.language) >", 0, false);
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

    $this->db->group_by('provider.id');

    /* Rating Filter with HAVING */
    if (!empty($rating) && $rating != 'top_rated') {
        $min_rating = 0;
        switch ($rating) {
            case '4_plus': $min_rating = 4; break;
            case '3_plus': $min_rating = 3; break;
            case '2_plus': $min_rating = 2; break;
        }
        if ($min_rating > 0) {
            $this->db->having('IFNULL(AVG(reviews.rating), 0) >=', $min_rating, false);
        }
    }

    /* SORTING */
    if ($price == 'low_to_high') {
        $this->db->order_by('provider.day_price', 'ASC');
    } elseif ($price == 'high_to_low') {
        $this->db->order_by('provider.day_price', 'DESC');
    } elseif ($rating == 'top_rated') {
        $this->db->order_by('avg_rating', 'DESC');
    } else {
        $this->db->order_by('distance', 'ASC');
    }

    $this->db->limit($limit, $offset);
    $providers = $this->db->get()->result_array();

    /* ---------------- FORMAT DISTANCE ---------------- */
    foreach ($providers as &$p) {
        if (!empty($p['distance']) && is_numeric($p['distance'])) {
            $p['distance'] = ($p['distance'] < 1)
                ? round($p['distance'] * 1000) . ' m'
                : round($p['distance'], 1) . ' km';
        } else {
            $p['distance'] = 'N/A';
        }
    }

    $data['provider'] = $providers;

    /* ======================================================
       PAGINATION
    ====================================================== */
    $current_page = ($offset / $limit) + 1;
    $total_pages  = max(1, ceil($total_records / $limit));

    $queryString = http_build_query(array_filter($this->input->get() ?: []));
    $pagination  = '<ul class="pagination">';

    /* Prev */
    $prev = ($current_page - 2) * $limit;
    $prevUrl = site_url("profile/index/$prev") . ($queryString ? "?$queryString" : "");
    $pagination .= ($current_page > 1)
        ? '<li class="page-item"><a class="page-link" href="' . $prevUrl . '">&laquo;</a></li>'
        : '<li class="page-item disabled"><span class="page-link">&laquo;</span></li>';

    for ($i = max(1, $current_page - 1); $i <= min($total_pages, $current_page + 1); $i++) {
        $off = ($i - 1) * $limit;
        $active = ($i == $current_page) ? 'active' : '';
        $pageUrl = site_url("profile/index/$off") . ($queryString ? "?$queryString" : "");
        $pagination .= '<li class="page-item ' . $active . '">
            <a class="page-link" href="' . $pageUrl . '">' . $i . '</a>
        </li>';
    }

    /* Next */
    $next = $current_page * $limit;
    $nextUrl = site_url("profile/index/$next") . ($queryString ? "?$queryString" : "");
    $pagination .= ($current_page < $total_pages)
        ? '<li class="page-item"><a class="page-link" href="' . $nextUrl . '">&raquo;</a></li>'
        : '<li class="page-item disabled"><span class="page-link">&raquo;</span></li>';

    $pagination .= '</ul>';
    $data['pagination'] = $pagination;

    /* ======================================================
       AJAX RESPONSE
    ====================================================== */
    if ($this->input->is_ajax_request()) {
       
        echo json_encode([
            'html'       => $this->load->view('provider_list', $data, true),
            'pagination' => $pagination
        ]);
        return;
    }
// echo "<pre>";
// print_r($data);
// die;
    /* ---------------- NORMAL PAGE LOAD ---------------- */
    $this->load->view('header');
    $this->load->view('profile_view', $data);
    $this->load->view('footer');
}












    public function provider_details($id)
{
    // First, get the provider data without aggregation
    $this->db->select('provider.*, users.gym_name, users.email, users.name, users.mobile');
    $this->db->from('provider');
    $this->db->join('users', 'users.id = provider.provider_id', 'left');
    $this->db->where('provider.provider_id', $id);
    $this->db->where('provider.isActive', 1);
    $provider = $this->db->get()->row();

    if (!empty($provider)) {
        // Get service count separately
        $this->db->select('COUNT(DISTINCT id) as service_count');
        $this->db->from('service');
        $this->db->where('provider_id', $id);
        $this->db->where('isActive', 1);
        $service_data = $this->db->get()->row();
        $provider->service_count = $service_data->service_count ?? 0;

        // Get expertise tags separately
        $this->db->select('GROUP_CONCAT(DISTINCT tag) as expertise_tags');
        $this->db->from('expertise_tag');
        $this->db->where('provider_id', $id);
        $tags_data = $this->db->get()->row();
        $provider->expertise_tags = $tags_data->expertise_tags ?? '';

        $this->data['provider'] = $provider;

        $locationData = $this->getCityState(
            $this->data['provider']->latitude,
            $this->data['provider']->longitude
        );

        $this->data['city'] = $locationData['city'];
        $this->data['state'] = $locationData['state'];
        $this->data['schedule'] = $this->general_model->getAll('provider_schedules', array('provider_id' => $id));
        $this->data['offers'] = $this->general_model->getAll('offers', array('provider_id' => $id, 'isActive' => 1));

        $this->data['reviews'] = $this->db
            ->select('r.*, u.name as user_name')
            ->from('reviews r')
            ->join('users u', 'u.id = r.user_id', 'left')
            ->where('r.provider_id', $id)
            ->order_by('r.created_at', 'DESC')
            ->get()
            ->result();

        $user_id = $this->user['id'] ?? null;

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

        $this->data['can_add_review'] = $has_order ? true : false;

        $this->load->view('header');
        $this->load->view('profile_details', $this->data);
        $this->load->view('footer');
    }
}

    public function get_services_ajax($provider_id)

{

    $page = $this->input->get('page') ?? 1;

    $perPage = 4;



    // Count total

    $this->db->where(['provider_id' => $provider_id, 'isactive' => 1]);

    $totalServices = $this->db->count_all_results('service');



    $totalPages = ceil($totalServices / $perPage);

    $offset = ($page - 1) * $perPage;



    // Fetch services with limit

    $this->db->where(['provider_id' => $provider_id, 'isactive' => 1]);

    $this->db->limit($perPage, $offset);

    $services = $this->db->get('service')->result();



    echo json_encode([

        'services' => $services,

        'totalPages' => $totalPages,

        'currentPage' => (int)$page

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



    public function profile()

    {











        // $orders = $this->general_model->getAll('orders', ['user_id' => $this->user['id']]);







        // $order_data = [];







        // foreach ($orders as $order) {



        //     $items = $this->general_model->getAll('order_items', ['order_id' => $order->id]);







        //     $order_data[] = [



        //         'order' => $order,



        //         'items' => $items



        //     ];



        // }







        // $data['orders'] = $order_data;



        $data['user'] = $this->general_model->getOne('users', ['id' => $this->user['id']]);



        // Booking count

        $booking_count = $this->general_model->getCount('orders', ['user_id' => $this->user['id']]);



        // Bank account count

        $bank_account_count = $this->general_model->getCount('provider_bank_details', ['provider_id' => $this->user['id']]);



        $data['booking_count'] = $booking_count;

        $data['bank_account_count'] = $bank_account_count;











        // // Debug



        // echo "<pre>";



        // print_r($data['user']);



        // die;











        $this->load->view('header');



        $this->load->view('user_profile_view', $data);



        $this->load->view('footer');



    }

public function bookings($id)

{

    $limit = 3;

    $page = (int) $this->input->get('page');

    $page = $page > 0 ? $page : 1;

    $offset = ($page - 1) * $limit;



    // Total records

    $this->db->select("COUNT(DISTINCT o.id) as total");

    $this->db->from("orders o");

    $this->db->where("o.user_id", $id);

    $total_rows = $this->db->get()->row()->total;



    // Paginated results

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

    $this->db->where("o.user_id", $id);

    $this->db->order_by("o.created_at", "DESC");

    $this->db->limit($limit, $offset);

    $query = $this->db->get();



    $bookings = [];

    foreach ($query->result() as $row) {

        $start = new DateTime($row->start_date);

        $end   = clone $start;



        $qty = isset($row->qty) ? (int)$row->qty : 1;



        switch ($row->duration) {

            case 'day':

                // ✅ Day passes expire after qty days (same day if qty=1)

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



            default:

                $end = clone $start;

        }



        $bookings[] = [

            'gym_name'   => $row->gym_name,

            'total'      => $row->total,

            'status'     => $row->status,

            'start_date' => $row->start_date,

            'end_date'   => $end->format('Y-m-d'),

            'created_at' => $row->created_at,

            'qty'        => $qty,

            'duration'   => $row->duration

        ];

    }



    $total_pages = max(1, ceil($total_rows / $limit));



    $data['user']         = $this->general_model->getOne('users', ['id' => $id]);

    $data['bookings']     = $bookings;

    $data['total_pages']  = $total_pages;

    $data['current_page'] = $page;

    $data['total_rows']   = $total_rows;

    $data['limit']        = $limit;



    if ($this->input->is_ajax_request()) {

        $this->load->view('booking_view', $data);

    } else {

        $this->load->view('header');

        $this->load->view('booking_view', $data);

        $this->load->view('footer');

    }

}















    public function edit_user($id)

    {

        $data['user'] = $this->general_model->getOne('users', ['id' => $id]);



        $this->load->view('header');

        $this->load->view('edit_form', $data);

        $this->load->view('footer');

    }

    public function edit_user_profile()

    {

        $this->load->helper(['url', 'form']);

        $this->load->library('upload');



        if ($this->input->server('REQUEST_METHOD') == 'POST') {



            $id = $this->input->post('id');

            $name = $this->input->post('name');

            $email = $this->input->post('email');

            $mobile = $this->input->post('mobile');



            if (empty($name) || empty($email) || empty($mobile)) {

                echo json_encode(['status' => 'error', 'message' => 'Please fill all required fields.']);

                return;

            }



            // Fetch current user

            $user = $this->general_model->getOne('users', ['id' => $id]);



            $updateData = [

                'name' => $name,

                'email' => $email,

                'mobile' => $mobile

            ];



            // Handle new image upload

            if (!empty($_FILES['profile_image']['name'])) {

                $config['upload_path'] = './uploads/profile';

                $config['allowed_types'] = 'jpg|jpeg|png';

                $config['max_size'] = 1024;

                $config['file_name'] = 'profile_' . $id . '_' . time();



                if (!is_dir($config['upload_path'])) {

                    mkdir($config['upload_path'], 0755, true); // create folder if not exists

                }



                $this->upload->initialize($config);



                if ($this->upload->do_upload('profile_image')) {

                    $uploadData = $this->upload->data();

                    $updateData['profile_image'] = 'uploads/profile/' . $uploadData['file_name'];

                } else {

                    echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors('', '')]);

                    return;

                }

            }



            $this->general_model->update('users', ['id' => $id], $updateData);



            $updatedUser = $this->general_model->getOne('users', ['id' => $id]);

            $profileImageUrl = !empty($updatedUser->profile_image)

                ? base_url($updatedUser->profile_image)

                : base_url('assets/images/9334234.jpg');



            echo json_encode(['status' => 'success', 'profile_image' => $profileImageUrl]);

            return;

        }



        show_404();

    }

    public function manage_bank_account($id)

    {

        // Get all accounts for provider

        $data['bank_accounts'] = $this->db

            ->where('provider_id', $id)

            ->order_by('id', 'DESC')

            ->get('provider_bank_details')

            ->result();



        $this->load->view('header');

        $this->load->view('bank_account_form', $data);

        $this->load->view('footer');

    }



    public function saveBankDetails()

    {

        $provider_id = $this->input->post('provider_id') ?: $this->user['id'];



        $id = $this->input->post('id'); // hidden field for edit



        $data = [

            'provider_id' => $provider_id,

            'account_holder_name' => $this->input->post('accountHolderName'),

            'bank_name' => $this->input->post('bankName'),

            'account_number' => $this->input->post('accountNumber'),

            'ifsc_code' => strtoupper($this->input->post('ifscCode')),

            'account_type' => $this->input->post('accountType'),

            'branch_name' => $this->input->post('branchName')

        ];



        // ✅ Validation

        foreach ($data as $k => $v) {

            if ($k != 'branch_name' && empty($v)) {

                echo json_encode([

                    'status' => 'error',

                    'message' => 'All required fields must be filled.'

                ]);

                return;

            }

        }



        if ($id) {

            // Update existing

            $this->db->where('id', $id)->update('provider_bank_details', $data);

            echo json_encode(['status' => 'success', 'message' => 'Bank details updated successfully!']);

        } else {

            // Insert new

            $this->db->insert('provider_bank_details', $data);

            echo json_encode(['status' => 'success', 'message' => 'Bank details saved successfully!']);

        }

    }



    public function deleteBank($id)

    {

        $this->db->where('id', $id)->delete('provider_bank_details');

        echo json_encode(['status' => 'success', 'message' => 'Bank account deleted successfully!']);

    }











}