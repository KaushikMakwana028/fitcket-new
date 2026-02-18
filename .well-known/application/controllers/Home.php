<?php



defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/User_Controller.php');







class Home extends User_Controller

{







    public function __construct()

    {







        parent::__construct();







    }



    public function index()

    {


        $this->data['category'] = $this->general_model->getAll('categories', ['isActive' => 1]);


        $this->data['sliders'] = $this->db

            ->where('isActive', 1)

            ->order_by('display_order', 'ASC')

            ->get('slider')

            ->result();






        $trainer_sub = $this->db->get_where('categories', [

            'name' => 'TRAINER',

            'isActive' => 1

        ])->row();



        $gym_sub = $this->db->get_where('categories', [

            'name' => 'GYM',

            'isActive' => 1

        ])->row();



        $trainer_id = $trainer_sub ? $trainer_sub->id : 0;

        $gym_id = $gym_sub ? $gym_sub->id : 0;




        $lat = floatval($this->session->userdata('user_lat') ?? 0);

        $lng = floatval($this->session->userdata('user_lng') ?? 0);

        $user_location = $this->session->userdata('user_location') ?? '';




        $this->data['trainer_providers'] = $this->db

            ->select("provider.*, users.name, users.gym_name, COUNT(service.id) as total_services,

            (6371 * acos(

                cos(radians($lat)) * cos(radians(provider.latitude)) * cos(radians(provider.longitude) - radians($lng)) +

                sin(radians($lat)) * sin(radians(provider.latitude))

            )) AS distance")

            ->from('provider')

            ->join('users', 'users.id = provider.provider_id', 'left')

            ->join('service', 'service.provider_id = provider.provider_id', 'left')

            ->where('provider.sub_category', $trainer_id)

            ->where('provider.isActive', 1)

            ->group_by('provider.id')

            ->get()

            ->result();



        // Fetch Gym Providers + Distance

        $this->data['gym_providers'] = $this->db

            ->select("provider.*, users.name, users.gym_name, COUNT(service.id) as total_services,

            (6371 * acos(

                cos(radians($lat)) * cos(radians(provider.latitude)) * cos(radians(provider.longitude) - radians($lng)) +

                sin(radians($lat)) * sin(radians(provider.latitude))

            )) AS distance")

            ->from('provider')

            ->join('users', 'users.id = provider.provider_id', 'left')

            ->join('service', 'service.provider_id = provider.provider_id', 'left')

            ->where('provider.sub_category', $gym_id)

            ->where('provider.isActive', 1)

            ->group_by('provider.id')

            ->get()

            ->result();



        // Fetch Nearest Providers (all providers regardless of category)

        $this->data['nearest_providers'] = $this->db

            ->select("provider.*, users.name, users.gym_name, COUNT(service.id) as total_services,

            (6371 * acos(

                cos(radians($lat)) * cos(radians(provider.latitude)) * cos(radians(provider.longitude) - radians($lng)) +

                sin(radians($lat)) * sin(radians(provider.latitude))

            )) AS distance")

            ->from('provider')

            ->join('users', 'users.id = provider.provider_id', 'left')

            ->join('service', 'service.provider_id = provider.provider_id', 'left')

            ->where('provider.isActive', 1)

            ->group_by('provider.id')

            ->order_by('distance', 'ASC')

            ->get()

            ->result();



        // Pass user location for display in view

        $this->data['user_location'] = $user_location;



        // Load view

        $this->load->view('header');

        $this->load->view('home_view', $this->data);

        $this->load->view('footer');

    }



    public function save_location()

    {

        $lat = $this->input->post('lat');

        $lng = $this->input->post('lng');

        $address = $this->input->post('address');



        // Save all three to session

        $this->session->set_userdata('user_lat', $lat);

        $this->session->set_userdata('user_lng', $lng);

        $this->session->set_userdata('user_location', $address);



        echo 'success';

    }







    //    public function save_location()

// {

//     $lat = $this->input->post('lat');

//     $lng = $this->input->post('lng');

//     $address = $this->input->post('address');



    //     // Save all three to session

//     $this->session->set_userdata('user_lat', $lat);

//     $this->session->set_userdata('user_lng', $lng);

//     $this->session->set_userdata('user_location', $address);



    //     echo 'success';

// }





    public function contact()

    {

        $this->load->view('header');

        $this->load->view('contact_view');

        $this->load->view('footer');



    }

}