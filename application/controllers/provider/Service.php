<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Provider_Controller.php');

class Service extends Provider_Controller

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

        $this->load->view('provider/service_view');

        $this->load->view('provider/footer');



    }

  public function fetch_services()
{
    $search = trim((string)$this->input->post('search'));
    $page   = (int)$this->input->post('page');
    if ($page < 1) { $page = 1; }

    $limit  = 10; // ✅ show 10 records per page
    $offset = ($page - 1) * $limit;

    $provider_id = (int)$this->provider['id'];

    // ----- COUNT TOTAL -----
    $this->db->from('service');
    $this->db->where('provider_id', $provider_id);
    if ($search !== '') {
        $this->db->group_start()
                 ->like('name', $search)
                 ->or_like('description', $search)
                 ->group_end();
    }
    $total = $this->db->count_all_results();

    // ----- FETCH PAGE DATA -----
    $this->db->from('service');
    $this->db->where('provider_id', $provider_id);
    if ($search !== '') {
        $this->db->group_start()
                 ->like('name', $search)
                 ->or_like('description', $search)
                 ->group_end();
    }
    $this->db->order_by('id', 'DESC');
    $this->db->limit($limit, $offset);
    $services = $this->db->get()->result();

    echo json_encode([
        'status' => 'success',
        'data'   => $services,
        'total'  => (int)$total,
        'limit'  => $limit,
        'page'   => $page
    ]);
}




    public function toggle_status()

    {

        if ($this->input->method() === 'post') {

            $id = $this->input->post('id');

            $status = $this->input->post('status');



            if (is_numeric($id) && ($status === '0' || $status === '1')) {

                // $this->load->model('Category_model');



                $where = ['id' => $id];

                $data = ['isActive' => $status];



                $update = $this->general_model->update('service', $where, $data);





                if ($update) {

                    echo json_encode([

                        'success' => true,

                        'message' => $status == '1' ? 'Published successfully' : 'Unpublished successfully'

                    ]);

                } else {

                    echo json_encode([

                        'success' => false,

                        'message' => 'Failed to update status'

                    ]);

                }

            } else {

                echo json_encode([

                    'success' => false,

                    'message' => 'Invalid input'

                ]);

            }

        }

    }



    public function add_service()

    {

        $this->load->view('provider/header');

        $this->load->view('provider/service_form');

        $this->load->view('provider/footer');

    }

    public function save()

    {

        $serviceName = $this->input->post('service_title');





        $exists = $this->db->where('name', $serviceName)->get('service')->row();



        if ($exists) {

            echo json_encode([

                'status' => 'exists',

                'message' => 'Category already exists!'

            ]);

            return;

        }



        // Image upload

        if (!empty($_FILES['service_image']['name'])) {

            $config['upload_path'] = './uploads/serviceimage/';

            $config['allowed_types'] = 'jpg|jpeg|png';

            $config['file_name'] = time();



            $this->load->library('upload', $config);



            if (!$this->upload->do_upload('service_image')) {

                echo json_encode([

                    'status' => 'error',

                    'message' => $this->upload->display_errors()

                ]);

                return;

            }



            $uploadData = $this->upload->data();

            $image = 'uploads/serviceimage/' . $uploadData['file_name'];

        } else {

            $image = '';

        }



        $provider_id = $this->provider['id'];

        $data = [

            'provider_id' => $provider_id,

            'name' => $serviceName,

            'image' => $image,

            'description' => $this->input->post('service_description'),

            'created_on' => date('Y-m-d H:i:s')

        ];

        

        $this->db->insert('service', $data);



        echo json_encode([

            'status' => 'success',

            'message' => 'Service saved successfully!'

        ]);

    }

    public function edit_service($id)

    {

        $serevice = $this->general_model->getOne('service', ['id' => $id]);



        if (!$serevice) {

            show_404();

        }



        $data['service'] = $serevice;

        //    echo "<pre>";

        //    print_r($data['category']);

        //    die;

        $this->load->view('provider/header');

        $this->load->view('provider/edit_service_form', $data);

        $this->load->view('provider/footer');

    }

    public function update(){

     $id = $this->input->post('service_id');

    $name = $this->input->post('service_title'); 

    // $isActive = $this->input->post('isActive'); 



    // // Fetch old record for image cleanup

    $old = $this->general_model->getOne('service', ['id' => $id]);



    $data = [

        'name' => $name,

    'description' => $this->input->post('service_description')

    ];



    // Handle new image upload

    if (!empty($_FILES['service_image']['name'])) {

    $config['upload_path'] = './uploads/serviceimage/';

    $config['allowed_types'] = 'jpg|jpeg|png|webp';

    $config['file_name'] = time() . '_' . $_FILES['service_image']['name'];

    $this->load->library('upload', $config);



    if ($this->upload->do_upload('service_image')) {

        $uploadData = $this->upload->data();

        $data['image'] = 'uploads/serviceimage/' . $uploadData['file_name'];



        if (!empty($old->image) && file_exists('./' . $old->image)) {

            unlink('./' . $old->image);

        }

    }

} else {

            echo json_encode(['status' => false, 'message' => strip_tags($this->upload->display_errors())]);

            return;

        }

    

    $update = $this->general_model->update('service', ['id' => $id], $data);



    if ($update) {

        echo json_encode(['status' => true, 'message' => 'Service updated successfully']);

    } else {

        echo json_encode(['status' => false, 'message' => 'Failed to update service']);

    }

}

public function offer()
{
$this->data['offer'] = $this->general_model->getAll('offers', ['provider_id' => $this->provider['id']]);
// echo "<pre>";
// print_r($this->data['offer']);
// die;
    $this->load->view('provider/header');
    $this->load->view('provider/offer_form',$this->data);
    $this->load->view('provider/footer');
}

public function save_offer()
{
    $provider_id = $this->provider['id'];

    $ids           = $this->input->post('id');
    $buy_quantity  = $this->input->post('buy_quantity');
    $free_quantity = $this->input->post('free_quantity');
    $valid_till    = $this->input->post('valid_till');
    $isActive      = $this->input->post('isActive');

    $durations = ['Day', 'Week', 'Month', 'Year'];

    if (empty($provider_id) || empty($buy_quantity)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data.']);
        return;
    }

    for ($i = 0; $i < count($durations); $i++) {
        $data = array(
            'provider_id'  => $provider_id,
            'duration'     => $durations[$i],
            'buy_quantity' => $buy_quantity[$i],
            'free_quantity'=> $free_quantity[$i],
            'valid_till'   => $valid_till[$i],
            'isActive'     => $isActive[$i],
        );

        if (!empty($ids[$i])) {
            $this->general_model->update('offers', ['id' => $ids[$i]], $data);
        } else {
            $this->general_model->insert('offers', $data);
        }
    }

    echo json_encode(['status' => 'success', 'message' => 'Offers saved successfully.']);
}



}