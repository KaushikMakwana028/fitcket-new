<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/User_Controller.php');



class Services extends User_Controller

{



    public function __construct()

    {
        parent::__construct();
    }



    public function index()

    {

        $this->load->view('header');

        $this->load->view('service_view');

        $this->load->view('footer');
    }

    public function fetch_services()
    {
        $page   = (int) ($this->input->get('page') ?? 1);
        if ($page < 1) $page = 1;

        $limit  = 9;
        $offset = ($page - 1) * $limit;

        $lat           = floatval($this->session->userdata('user_lat') ?? 0);
        $lng           = floatval($this->session->userdata('user_lng') ?? 0);
        $user_location = $this->session->userdata('user_location') ?? '';
        $search        = trim($this->input->get('search') ?? '');

        /*
    ==========================================
    🔥 STEP 1: COUNT QUERY (SEPARATE CLEAN QUERY)
    ==========================================
    */
        $this->db->from('service');
        $this->db->join('provider', 'provider.provider_id = service.provider_id', 'left');
        $this->db->join('users', 'users.id = provider.provider_id', 'left');
        $this->db->where('service.isActive', 1);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('LOWER(users.gym_name)', strtolower($search));
            $this->db->or_like('LOWER(service.name)', strtolower($search));
            $this->db->group_end();
        }

        $total = $this->db->count_all_results();

        /*
    ==========================================
    🔥 STEP 2: FETCH DATA (FRESH QUERY AGAIN)
    ==========================================
    */
        if ($lat != 0 && $lng != 0) {
            $distance_select = "(6371 * acos(
                cos(radians($lat)) * cos(radians(provider.latitude)) *
                cos(radians(provider.longitude) - radians($lng)) +
                sin(radians($lat)) * sin(radians(provider.latitude))
            )) AS distance";
        } else {
            $distance_select = "NULL AS distance";
        }

        $this->db->select("
        service.*, 
        users.gym_name, 
        provider.city, 
        provider.month_price,
        (SELECT ROUND(IFNULL(AVG(rating), 0), 1) FROM reviews WHERE reviews.provider_id = service.provider_id) AS avg_rating,
        (SELECT COUNT(*) FROM reviews WHERE reviews.provider_id = service.provider_id) AS total_reviews,
        $distance_select
    ", false);

        $this->db->from('service');
        $this->db->join('provider', 'provider.provider_id = service.provider_id', 'left');
        $this->db->join('users', 'users.id = provider.provider_id', 'left');
        $this->db->where('service.isActive', 1);

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('LOWER(users.gym_name)', strtolower($search));
            $this->db->or_like('LOWER(service.name)', strtolower($search));
            $this->db->group_end();
        }

        $this->db->order_by('service.id', 'DESC');
        $this->db->limit($limit, $offset);

        $services = $this->db->get()->result();

        /*
    ==========================================
    🔥 STEP 3: FORMAT DISTANCE
    ==========================================
    */
        $is_loc_enabled = ($lat != 0 && $lng != 0);
        foreach ($services as &$service) {
            if (!is_null($service->distance) && is_numeric($service->distance)) {
                $service->distance = ($service->distance < 1)
                    ? round($service->distance * 1000) . ' m'
                    : round($service->distance, 1) . ' km';
            } else {
                $service->distance = $is_loc_enabled ? 'N/A' : 'Enable Location';
            }
        }
        unset($service);

        /*
    ==========================================
    🔥 STEP 4: EXTRA DATA
    ==========================================
    */
        $provider_count = $this->db
            ->where(['role' => 2, 'isActive' => 1])
            ->count_all_results('users');

        /*
    ==========================================
    🔥 STEP 5: RESPONSE
    ==========================================
    */
        echo json_encode([
            'services'       => $services,
            'total'          => $total,
            'limit'          => $limit,
            'page'           => $page,
            'provider_count' => $provider_count,
            'user_location'  => $user_location
        ]);
    }
}
