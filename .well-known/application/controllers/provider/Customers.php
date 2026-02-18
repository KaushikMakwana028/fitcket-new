<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Provider_Controller.php');

class Customers extends Provider_Controller

{



    public function __construct()

    {

        parent::__construct();

    }



    public function index()

    {

        // echo "<pre>";

        // print_r($this->provider);

        // die;

        $this->load->view('provider/header');

        $this->load->view('provider/customer_view');

        $this->load->view('provider/footer');



    }

    public function get_customers_ajax()

    {

        $provider_id = $this->provider['id'];

        $search = $this->input->get('search');

        $page = (int) $this->input->get('page') ?: 1;

        $limit = 10;

        $offset = ($page - 1) * $limit;



        // Get paginated customers

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

        $query = $this->db->get();

        $customers = $query->result();



        // Get total distinct user count

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



        echo json_encode([

            'customers' => $customers,

            'total' => $total,

            'page' => $page,

            'limit' => $limit

        ]);

    }

    public function booking()

    {

        $this->load->view('provider/header');

        $this->load->view('provider/booking_view');

        $this->load->view('provider/footer');

    }

public function get_bookings_ajax()

{

    $provider_id = $this->provider['id'];

    $search = $this->input->get('search');

    $page = $this->input->get('page') ?? 1;

    $limit = 10;

    $offset = ($page - 1) * $limit;



    // Step 1: Get filtered order IDs for this provider

    $this->db->distinct();                    // <-- Correct way to apply DISTINCT

    $this->db->select('o.id');                // <-- Only select column names

    $this->db->from('orders o');

    $this->db->join('order_items oi', 'o.id = oi.order_id', 'inner');

    $this->db->where('oi.provider_id', $provider_id);



    if (!empty($search)) {

        // Need to join 'users' table if you're filtering on user name/mobile

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



    if ($total > 0) {

        // Paginate order IDs

        $paginated_order_ids = array_slice($order_ids, $offset, $limit);



        // Step 2: Get detailed booking data

        $this->db->select('

            u.name, 

            u.mobile, 

            o.created_at, 

            o.status, 

            oi.price, 

            oi.duration, 

            oi.qty,
            oi.free_qty,
            oi.total_qty,


            oi.start_date, 


            oi.name AS service_name, 

            o.id

        ');

        $this->db->from('orders o');

        $this->db->join('users u', 'u.id = o.user_id');

        $this->db->join('order_items oi', 'o.id = oi.order_id');

        $this->db->where_in('o.id', $paginated_order_ids);

        $this->db->where('oi.provider_id', $provider_id);



        // Keep correct ordering

        $order_ids_order = implode(',', $paginated_order_ids);

        $this->db->order_by("FIELD(o.id, $order_ids_order)", '', false);



        $bookings = $this->db->get()->result_array();

    } else {

        $bookings = [];

    }



    echo json_encode([

        'status' => 'success',

        'data' => $bookings,

        'total' => $total,

        'limit' => $limit,

        'page' => $page

    ]);
    // echo "<pre>";
    // print_r($bookings); echo "<br>";
    // echo "<pre>";
    // print_r($total);echo "<br>";
    // echo "<pre>";
    
    // die;

}





























}