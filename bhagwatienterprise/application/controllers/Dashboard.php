<?php

class Dashboard extends CI_Controller

{



    public function __construct()

    {
      
        parent::__construct();

        $this->load->library('session');



        $this->load->helper('url');

        $this->load->model('general_model');

       



if (!$this->session->userdata('admin')) {


echo "hi";
die;
			redirect('login');



		}

    }





   public function index()
{
     
    // 1️⃣ Total drivers count (role = 0)
$total_drivers = $this->db->where('role', 0)->count_all_results('users');

// 2️⃣ Total companies count
$total_companies = $this->db->count_all('company');

// 3️⃣ Total trips this month
$month  = date('m');
$year   = date('Y');
$total_month_trips = $this->db
    ->where('MONTH(trip_date)', $month)
    ->where('YEAR(trip_date)', $year)
    ->count_all_results('trips');

// 4️⃣ Today's date
$today = date('Y-m-d');

// 5️⃣ Total trips today
$total_today_trips = $this->db
    ->where('trip_date', $today)
    ->count_all_results('trips');

// 6️⃣ Today's running trips
$running_trips_today = $this->db
    ->where('trip_date', $today)
    ->where('status', 'running')
    ->count_all_results('trips');

// 7️⃣ Today's completed trips
$completed_trips_today = $this->db
    ->where('trip_date', $today)
    ->where('status', 'completed')
    ->count_all_results('trips');

// 8️⃣ Prepare data array
$data = [
    'total_drivers'         => $total_drivers,
    'total_companies'       => $total_companies,
    'total_month_trips'     => $total_month_trips,
    'total_today_trips'     => $total_today_trips,
    'running_trips_today'   => $running_trips_today,
    'completed_trips_today' => $completed_trips_today
];


    // 7️⃣ Load views with data
    $this->load->view('header');
    $this->load->view('dashboard_view', $data);
    $this->load->view('footer');
}



    public function customer(){

      $this->data['customer'] = $this->general_model->getall('users',array('role'=>2));

       $this->load->view('admin/header');

        $this->load->view('admin/customer_view',$this->data);

        $this->load->view('admin/footer');

    }

     public function get_customers() {

        $per_page = 10; // Number of customers per page

        $page = $this->input->post('page') ? $this->input->post('page') : 1;

        $offset = ($page - 1) * $per_page;



        // Get total number of customers

        $total = $this->db->count_all('users');



        // Get paginated customers

        $this->db->limit($per_page, $offset);

        $customers = $this->general_model->getall('users',array('role'=>2));



        // Prepare response

        $response = [

            'customers' => $customers,

            'total' => $total,

            'per_page' => $per_page

        ];



        // Send JSON response

        $this->output

            ->set_content_type('application/json')

            ->set_output(json_encode($response));

    }

}  

?>