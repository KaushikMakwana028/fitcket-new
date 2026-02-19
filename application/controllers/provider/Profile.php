<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Provider_Controller.php');

class Profile extends Provider_Controller
{



    public function __construct()
    {

        parent::__construct();

    }



    public function index()
    {

        $data['provider'] = $this->general_model->getOne('users', array('id' => $this->provider['id']));

        $data['categories'] = $this->general_model->getAll(
            'categories',
            ['isActive' => 1, 'parent_id' => null]
        );
    // echo "<pre>";
    // print_r( $data['categories']);
    // die;


        $data['city'] = $this->general_model->getAll('cities', ['isActive' => 1]);

        $data['profile'] = $this->general_model->getOne('provider', ['isActive' => 1, 'provider_id' => $this->provider['id']]);

        $data['expertis'] = $this->general_model->getAll('expertise_tag', ['provider_id' => $this->provider['id']]);







// echo "H";
// die;

        $this->load->view('provider/header');

        $this->load->view('provider/profile_form', $data);

        $this->load->view('provider/footer');



    }

    public function get_subcategories()
    {
        $category_id = $this->input->post('category_id');

        // Fetch subcategories where parent_id = selected category
        $subcategories = $this->general_model->getAll('categories', [
            'parent_id' => $category_id,
            'isActive' => 1
        ]);

        echo json_encode($subcategories);
    }


    public function save()
    {

        $input = $this->input->post();

        $provider_id = trim($input['id']);

        $profile_image = null;



        // Upload profile image if exists

        if (!empty($_FILES['profile_image']['name'])) {

            $config['upload_path'] = './uploads/profile/';

            $config['allowed_types'] = 'jpg|jpeg|png';

            $config['max_size'] = 2048; // in KB

            $config['file_name'] = 'profile_' . time();



            $this->load->library('upload', $config);

            $this->upload->initialize($config);



            if ($this->upload->do_upload('profile_image')) {

                $uploadData = $this->upload->data();

                $profile_image = 'uploads/profile/' . $uploadData['file_name'];

            } else {

                log_message('error', 'Profile image upload failed: ' . $this->upload->display_errors('', ''));

            }

        }



        // Build provider data

        $address = trim($input['address']);



        // Call OpenStreetMap API to get lat/lng

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($address));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_USERAGENT, 'FitTicketApp/1.0 (support@fitticket.com)');

        $response = curl_exec($ch);

        curl_close($ch);



        $latitude = null;

        $longitude = null;



        if ($response) {

            $data = json_decode($response, true);

            if (!empty($data)) {

                $latitude = $data[0]['lat'];

                $longitude = $data[0]['lon'];

            }

        }



        $providerData = [

            'provider_id' => $provider_id,

            'description' => $input['description'],

            'category'   => $input['category'],              // updated
            'sub_category' => $input['subcategory'] ?? null,

            'city' => isset($input['availability']) ? implode(',', $input['availability']) : '',
            'language' => isset($input['language']) ? implode(',', $input['language']) : '',
            'service_type' => $input['service_type'] ,
            'exp' => $input['exp'] ,




            'address' => $address,

            'day_price' => $input['price_day'],

            'week_price' => $input['price_week'],

            'month_price' => $input['price_month'],

            'year_price' => $input['price_year'],

            'latitude' => $latitude,

            'longitude' => $longitude,

            'isActive' => 1,

            'created_on' => date('Y-m-d')

        ];



        if ($profile_image) {

            $providerData['profile_image'] = $profile_image;

        }



        $existing = $this->general_model->getOne('provider', ['provider_id' => $provider_id]);

        if ($existing) {

            $this->general_model->update(
                'provider',
                ['provider_id' => $provider_id],

                $providerData
            );

        } else {

            $this->general_model->insert('provider', $providerData);

        }





        // Process expertise tags

        $tags = [];

        if (!empty($input['expertise_tags'])) {

            $decoded = json_decode($input['expertise_tags'], true);

            if (is_array($decoded)) {

                $tags = array_map(function ($tag) {

                    return ['value' => trim($tag['value'])];

                }, $decoded);

            } else {

                $tags = array_map(function ($tag) {

                    return ['value' => trim($tag)];

                }, explode(',', $input['expertise_tags']));

            }

        }



        // Remove old tags

        $this->db->delete('expertise_tag', ['provider_id' => $provider_id]);



        // Insert new tags

        foreach ($tags as $tag) {

            if (!empty($tag['value'])) {

                $this->db->insert('expertise_tag', [

                    'provider_id' => $provider_id,

                    'tag' => $tag['value'],

                    'created_on' => date('Y-m-d')

                ]);

            }

        }



        // Return response

        echo json_encode(['status' => 'success', 'message' => 'Profile saved successfully!']);

    }



    public function bank_details()
    {

        $bank_details = $this->db->get_where('provider_bank_details', [

            'provider_id' => $this->provider['id']

        ])->row();



        // Pass data to view

        $data['bank_details'] = $bank_details;

        $this->load->view('provider/header');

        $this->load->view('provider/bank_form', $data);

        $this->load->view('provider/footer');

    }

    public function saveBankDetails()
    {

        $provider_id = $this->provider['id'];

        $account_holder_name = $this->input->post('accountHolderName');

        $bank_name = $this->input->post('bankName');

        $account_number = $this->input->post('accountNumber');

        $ifsc_code = strtoupper($this->input->post('ifscCode'));

        $account_type = $this->input->post('accountType');

        $branch_name = $this->input->post('branchName');



        if (
            empty($provider_id) || empty($account_holder_name) || empty($bank_name) ||

            empty($account_number) || empty($ifsc_code) || empty($account_type)
        ) {

            echo json_encode(['status' => 'error', 'message' => 'All required fields must be filled.']);

            return;

        }



        $data = [

            'provider_id' => $provider_id,

            'account_holder_name' => $account_holder_name,

            'bank_name' => $bank_name,

            'account_number' => $account_number,

            'ifsc_code' => $ifsc_code,

            'account_type' => $account_type,

            'branch_name' => $branch_name

        ];



        // Check if bank details already exist for provider

        $existing = $this->db->get_where('provider_bank_details', ['provider_id' => $provider_id])->row();



        if ($existing) {

            // Update

            $this->db->where('provider_id', $provider_id);

            $this->db->update('provider_bank_details', $data);

            echo json_encode(['status' => 'success', 'message' => 'Bank details updated successfully!']);

        } else {

            // Insert

            $this->db->insert('provider_bank_details', $data);

            echo json_encode(['status' => 'success', 'message' => 'Bank details saved successfully!']);

        }

    }


public function image(){
    $this->load->view('provider/header');
    $this->load->view('provider/gallery_view');
    $this->load->view('provider/footer');

}
public function add_image(){
    $this->load->view('provider/header');
    $this->load->view('provider/gallery_form');
    $this->load->view('provider/footer');

}
public function fetch_gallery()
{
    $page = $this->input->post('page') ?? 1;
    $search = $this->input->post('search') ?? '';

    $limit = 5;
    $offset = ($page - 1) * $limit;

    // $this->db->like('title', $search);
    $this->db->limit($limit, $offset);
    $query = $this->db->get('gym_gallery');
    $data = $query->result();

    // $this->db->like('title', $search);
    $total = $this->db->count_all_results('gym_gallery', FALSE);

    echo json_encode([
        'data' => $data,
        'total' => $total,
        'limit' => $limit,
        'page' => $page
    ]);
}

public function delete_image()
{
    $id = $this->input->post('id');
    $image = $this->db->get_where('gym_gallery', ['id' => $id])->row();

    if ($image) {
        @unlink('./uploads/gallery/' . $image->image);
        $this->db->delete('gym_gallery', ['id' => $id]);
        echo json_encode(['status' => true]);
    } else {
        echo json_encode(['status' => false]);
    }
}

public function upload_gallery_images()
{
    $provider_id = $this->provider['id'];

    if (empty($_FILES['gallery_images']['name'][0])) {
        echo json_encode(['status' => 'error', 'message' => 'No images selected.']);
        return;
    }

    $upload_path = './uploads/gym_gallery/';
    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0777, true);
    }

    $uploaded_files = [];
    $this->load->library('upload');

    foreach ($_FILES['gallery_images']['name'] as $key => $filename) {
        $_FILES['file']['name'] = $_FILES['gallery_images']['name'][$key];
        $_FILES['file']['type'] = $_FILES['gallery_images']['type'][$key];
        $_FILES['file']['tmp_name'] = $_FILES['gallery_images']['tmp_name'][$key];
        $_FILES['file']['error'] = $_FILES['gallery_images']['error'][$key];
        $_FILES['file']['size'] = $_FILES['gallery_images']['size'][$key];

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['file_name'] = 'gallery_' . time() . '_' . rand(1000, 9999);

        $this->upload->initialize($config);

        if ($this->upload->do_upload('file')) {
            $upload_data = $this->upload->data();
            $image_path = 'uploads/gym_gallery/' . $upload_data['file_name'];

            $insert_data = [
                'provider_id' => $provider_id,
                'image'       => $image_path,
                'status'      => 1,
                'created_on'  => date('Y-m-d H:i:s')
            ];
            $this->db->insert('gym_gallery', $insert_data);
            $uploaded_files[] = $image_path;
        }
    }

    if (count($uploaded_files) > 0) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Images uploaded successfully!',
            'files' => $uploaded_files
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No valid images uploaded.']);
    }
}

public function certification()
{
    $provider_id = $this->provider['id'];

    // Fetch certifications
    $certifications = $this->db
        ->where('provider_id', $provider_id)
        ->where('is_active', 1)
        ->order_by('id', 'DESC')
        ->get('certifications')
        ->result();

    $data['certifications'] = $certifications;

    $this->load->view('provider/header');
    $this->load->view('provider/certificate_view', $data);
    $this->load->view('provider/footer');
}

public function save_certificate()
{
    header('Content-Type: application/json');

    $provider_id = $this->provider['id'];;
    $title       = trim($this->input->post('title'));

    // 🔒 Backend Validation
    if (!$provider_id || !$title) {
        echo json_encode([
            'status' => false,
            'message' => 'All fields are required'
        ]);
        return;
    }

    if (empty($_FILES['certificate']['name'])) {
        echo json_encode([
            'status' => false,
            'message' => 'Certificate file is required'
        ]);
        return;
    }

    // Upload Config
    $config['upload_path']   = './uploads/certificates/';
    $config['allowed_types'] = 'jpg|jpeg|png|pdf';
    $config['max_size']      = 5120;
    $config['encrypt_name']  = true;

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('certificate')) {
        echo json_encode([
            'status' => false,
            'message' => $this->upload->display_errors('', '')
        ]);
        return;
    }

    $fileData = $this->upload->data();
    $imagePath = 'uploads/certificates/' . $fileData['file_name'];

    // Insert Data
    $insert = [
        'provider_id' => $provider_id,
        'title'       => $title,
        'image_path'  => $imagePath,
        'is_active'   => 1,
        'created_on'  => date('Y-m-d H:i:s')
    ];

    $this->db->insert('certifications', $insert);

    echo json_encode([
        'status' => true,
        'message' => 'Certification added successfully'
    ]);
}
public function delete_certificate()
{
    header('Content-Type: application/json');

    $id = $this->input->post('id');
    $provider_id = $this->provider['id'];

    if (!$id) {
        echo json_encode([
            'status' => false,
            'message' => 'Invalid request'
        ]);
        return;
    }

    // Verify ownership
    $cert = $this->db
        ->where('id', $id)
        ->where('provider_id', $provider_id)
        ->get('certifications')
        ->row();

    if (!$cert) {
        echo json_encode([
            'status' => false,
            'message' => 'Certification not found'
        ]);
        return;
    }

    // Delete file
    if (file_exists(FCPATH . $cert->image_path)) {
        unlink(FCPATH . $cert->image_path);
    }

    // Delete DB record
    $this->db->where('id', $id)->delete('certifications');

    echo json_encode([
        'status' => true,
        'message' => 'Certification deleted successfully'
    ]);
}



}