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

    $this->db->select("service.*, users.gym_name, provider.city, provider.month_price,
        (6371 * acos(
            cos(radians($lat)) * cos(radians(provider.latitude)) * cos(radians(provider.longitude) - radians($lng)) +
            sin(radians($lat)) * sin(radians(provider.latitude))
        )) AS distance
    ");
    $this->db->from('service');
    $this->db->join('provider', 'provider.provider_id = service.provider_id', 'left');
    $this->db->join('users', 'users.id = provider.provider_id', 'left');
    $this->db->where('service.isActive', 1);

    $total = $this->db->count_all_results('', false);

    $this->db->limit($limit, $offset);
    $services = $this->db->get()->result();

    foreach ($services as &$service) {
        if (isset($service->distance)) {
            if ($service->distance < 1) {
                $service->distance = round($service->distance * 1000) . ' m';
            } else {
                $service->distance = round($service->distance, 1) . ' km';
            }
        }
    }

    $all_providers  = $this->general_model->getAll('users', ['role' => 2, 'isActive' => 1]);
    $provider_count = count($all_providers);

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