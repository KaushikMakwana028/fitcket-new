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


        $categories = $this->general_model->getAll('categories', ['isActive' => 1]);
        foreach ($categories as &$cat) {
            $cat->provider_count = $this->db
                ->group_start()
                ->where('category', $cat->id)
                ->or_where('sub_category', $cat->id)
                ->group_end()
                ->where('isActive', 1)
                ->count_all_results('provider');
        }
        $this->data['category'] = $categories;
        $this->data['total_providers_count'] = $this->db->where('isActive', 1)->count_all_results('provider');


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



        // Fetch active provider cities to match against user_location

        $active_providers_cities = $this->db

            ->select('city')

            ->from('provider')

            ->join('users', 'users.id = provider.provider_id', 'left')

            ->where('users.isActive', 1)

            ->where('provider.city IS NOT NULL')

            ->where('provider.city !=', '')

            ->get()

            ->result();



        $all_db_cities = [];

        foreach ($active_providers_cities as $p) {

            $parts = explode(',', $p->city);

            foreach ($parts as $part) {

                $city_trimmed = trim($part);

                if ($city_trimmed !== '') {

                    $all_db_cities[] = strtolower($city_trimmed);

                }

            }

        }

        $all_db_cities = array_unique($all_db_cities);



        $user_city = '';

        if (!empty($user_location)) {

            foreach ($all_db_cities as $db_city) {

                if (stripos($user_location, $db_city) !== false) {

                    $user_city = $db_city;

                    break;

                }

            }

            if (empty($user_city)) {

                $parts = explode(',', $user_location);

                if (!empty($parts)) {

                    $user_city = trim($parts[0]);

                }

            }

        }




        if ($lat != 0 && $lng != 0) {

            $distance_select = "(6371 * acos(

                cos(radians($lat)) * cos(radians(provider.latitude)) * cos(radians(provider.longitude) - radians($lng)) +

                sin(radians($lat)) * sin(radians(provider.latitude))

            )) AS distance";

            $order_by = 'distance';

            $order_dir = 'ASC';

        } else {

            $distance_select = "NULL AS distance";

            $order_by = 'provider.id';

            $order_dir = 'DESC';

        }




        $this->data['trainer_providers'] = $this->db

            ->select("provider.*, users.name, users.gym_name, COUNT(service.id) as total_services, $distance_select, 
            (SELECT ROUND(IFNULL(AVG(rating), 0), 1) FROM reviews WHERE reviews.provider_id = provider.provider_id) AS avg_rating,
            (SELECT COUNT(*) FROM reviews WHERE reviews.provider_id = provider.provider_id) AS total_reviews", false)

            ->from('provider')

            ->join('users', 'users.id = provider.provider_id', 'left')

            ->join('service', 'service.provider_id = provider.provider_id', 'left')

            ->where('provider.sub_category', $trainer_id)

            ->where('provider.isActive', 1)

            ->where('users.isActive', 1)

            ->group_by('provider.id')

            ->having('avg_rating >', 3.5)

            ->order_by('avg_rating', 'DESC')

            ->get()

            ->result();



        // Fetch Gym Providers + Distance

        $this->data['gym_providers'] = $this->db

            ->select("provider.*, users.name, users.gym_name, COUNT(service.id) as total_services, $distance_select,
            (SELECT ROUND(IFNULL(AVG(rating), 0), 1) FROM reviews WHERE reviews.provider_id = provider.provider_id) AS avg_rating,
            (SELECT COUNT(*) FROM reviews WHERE reviews.provider_id = provider.provider_id) AS total_reviews", false)

            ->from('provider')

            ->join('users', 'users.id = provider.provider_id', 'left')

            ->join('service', 'service.provider_id = provider.provider_id', 'left')

            ->where('provider.sub_category !=', $trainer_id)

            ->where('provider.isActive', 1)

            ->where('provider.latitude IS NOT NULL')

            ->where('provider.longitude IS NOT NULL')

            ->where('provider.latitude !=', 0)

            ->where('provider.longitude !=', 0)

            ->group_by('provider.id')

            ->having('avg_rating >', 3.5)

            ->get()

            ->result();



        // Fetch Nearest Providers (all providers regardless of category)

        $this->db

            ->select("provider.*, users.name, users.gym_name, COUNT(service.id) as total_services, $distance_select,
            (SELECT ROUND(IFNULL(AVG(rating), 0), 1) FROM reviews WHERE reviews.provider_id = provider.provider_id) AS avg_rating,
            (SELECT COUNT(*) FROM reviews WHERE reviews.provider_id = provider.provider_id) AS total_reviews", false)

            ->from('provider')

            ->join('users', 'users.id = provider.provider_id', 'left')

            ->join('service', 'service.provider_id = provider.provider_id', 'left')

            ->where('provider.isActive', 1)
            ->where('users.isActive', 1);

        if ($lat != 0 && $lng != 0) {

            $this->db
                ->where('provider.latitude IS NOT NULL')
                ->where('provider.longitude IS NOT NULL')
                ->where('provider.latitude !=', 0)
                ->where('provider.longitude !=', 0);

        } elseif (!empty($user_city)) {

            $normalized_user_city = preg_replace('/\s+/', '', strtolower($user_city));

            $this->db->where(
                "FIND_IN_SET(" . $this->db->escape($normalized_user_city) . ", REPLACE(LOWER(provider.city), ' ', '')) > 0",
                null,
                false
            );

        }



        $this->db->group_by('provider.id');

        if ($lat != 0 && $lng != 0) {

            $this->db->having('distance <=', 50);

        }

        $this->data['nearest_providers'] = $this->db

            ->order_by($lat != 0 && $lng != 0 ? 'distance IS NULL' : 'provider.id', $lat != 0 && $lng != 0 ? 'ASC' : 'DESC', false)

            ->order_by($order_by, $order_dir)

            ->get()

            ->result();



        // Pass user location and coordinates for display in view

        $this->data['user_location'] = $user_location;

        $this->data['lat'] = $lat;

        $this->data['lng'] = $lng;

        $this->data['all_db_cities'] = $all_db_cities;



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
