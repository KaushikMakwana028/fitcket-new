<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');



class Page extends Admin_Controller

{



    public function __construct()

    {

        parent::__construct();

    }



    public function index()

    {

        $data['page_data'] = $this->general_model->getOne('pages', array('slug' => 'about-us'));

        // echo "<pre>";

        // print_r($data['page_data'] );

        // die;

        $this->load->view('admin/header');

        $this->load->view('admin/about_us', $data);

        $this->load->view('admin/footer');



    }



    public function save_about()

    {

        $data = [

            'title' => $this->input->post('title', FALSE), 

            'content' => $this->input->post('content'),

            'updated_at' => date('Y-m-d H:i:s')

        ];



        

        $page_id = $this->input->post('page_id');

        if ($page_id) {

            

            $updated = $this->general_model->update('pages', ['id' => $page_id], $data);

            $status = $updated;

        } else {

            $insert_id = $this->general_model->insert('pages', $data);

            $status = $insert_id;

            $page_id = $insert_id;

        }



        if ($status) {

            $this->output

                ->set_content_type('application/json')

                ->set_output(json_encode([

                    'status' => true,

                    'message' => 'Page saved successfully!',

                    'page_id' => $page_id

                ]));

        } else {

            $this->output

                ->set_content_type('application/json')

                ->set_output(json_encode([

                    'status' => false,

                    'message' => 'Failed to save page.'

                ]));

        }

    }

    // contact us page



    public function contact_us()

    {

        $data['page_data'] = $this->general_model->getOne('pages', array('slug' => 'contact-us'));



        $this->load->view('admin/header');

        $this->load->view('admin/contact_us', $data);

        $this->load->view('admin/footer');

    }



    public function save_contact()

    {

        $data = [

            'title' => $this->input->post('title', FALSE),

            'content' => $this->input->post('content'),

            'updated_at' => date('Y-m-d H:i:s')

        ];



        $page_id = $this->input->post('page_id');

        if ($page_id) {

            $updated = $this->general_model->update('pages', ['id' => $page_id], $data);

            $status = $updated;

        } else {

            $insert_id = $this->general_model->insert('pages', $data);

            $status = $insert_id;

            $page_id = $insert_id;

        }



        if ($status) {

            $this->output

                ->set_content_type('application/json')

                ->set_output(json_encode([

                    'status' => true,

                    'message' => 'Page saved successfully!',

                    'page_id' => $page_id

                ]));

        } else {

            $this->output

                ->set_content_type('application/json')

                ->set_output(json_encode([

                    'status' => false,

                    'message' => 'Failed to save page.'

                ]));

        }

    }



    // privacy_policy

    public function privacy_policy()

    {

        $data['page_data'] = $this->general_model->getOne('pages', array('slug' => 'privacy-policy'));



        $this->load->view('admin/header');

        $this->load->view('admin/privacy_policy', $data);

        $this->load->view('admin/footer');

    }

    public function save_privacy_policy()

    {

        $data = [

            'title' => $this->input->post('title', FALSE),

            'content' => $this->input->post('content'),

            'updated_at' => date('Y-m-d H:i:s')

        ];



        $page_id = $this->input->post('page_id');

        if ($page_id) {

            $updated = $this->general_model->update('pages', ['id' => $page_id], $data);

            $status = $updated;

        } else {

            $insert_id = $this->general_model->insert('pages', $data);

            $status = $insert_id;

            $page_id = $insert_id;

        }



        if ($status) {

            $this->output

                ->set_content_type('application/json')

                ->set_output(json_encode([

                    'status' => true,

                    'message' => 'Page saved successfully!',

                    'page_id' => $page_id

                ]));

        } else {

            $this->output

                ->set_content_type('application/json')

                ->set_output(json_encode([

                    'status' => false,

                    'message' => 'Failed to save page.'

                ]));

        }

    }

    // Refund Policy

    public function refund_policy()

    {

        $data['page_data'] = $this->general_model->getOne('pages', array('slug' => 'refund-policy'));



        $this->load->view('admin/header');

        $this->load->view('admin/refund_policy', $data);

        $this->load->view('admin/footer');

    }

    public function save_refund_policy()

    {

        $data = [

            'title' => $this->input->post('title', FALSE),

            'content' => $this->input->post('content'),

            'updated_at' => date('Y-m-d H:i:s')

        ];



        $page_id = $this->input->post('page_id');

        if ($page_id) {

            $updated = $this->general_model->update('pages', ['id' => $page_id], $data);

            $status = $updated;

        } else {

            $insert_id = $this->general_model->insert('pages', $data);

            $status = $insert_id;

            $page_id = $insert_id;

        }



        if ($status) {

            $this->output

                ->set_content_type('application/json')

                ->set_output(json_encode([

                    'status' => true,

                    'message' => 'Page saved successfully!',

                    'page_id' => $page_id

                ]));

        } else {

            $this->output

                ->set_content_type('application/json')

                ->set_output(json_encode([

                    'status' => false,

                    'message' => 'Failed to save page.'

                ]));

        }

    }

    public function terms_condition()

    {

        $data['page_data'] = $this->general_model->getOne('pages', array('slug' => 'terms-condition'));



        $this->load->view('admin/header');

        $this->load->view('admin/terms_condition', $data);

        $this->load->view('admin/footer');

    }

    public function save_terms()

    {

        $data = [

            'title' => $this->input->post('title', FALSE),

            'content' => $this->input->post('content'),

            'updated_at' => date('Y-m-d H:i:s')

        ];



        $page_id = $this->input->post('page_id');

        if ($page_id) {

            $updated = $this->general_model->update('pages', ['id' => $page_id], $data);

            $status = $updated;

        } else {

            $insert_id = $this->general_model->insert('pages', $data);

            $status = $insert_id;

            $page_id = $insert_id;

        }



        if ($status) {

            $this->output

                ->set_content_type('application/json')

                ->set_output(json_encode([

                    'status' => true,

                    'message' => 'Page saved successfully!',

                    'page_id' => $page_id

                ]));

        } else {

            $this->output

                ->set_content_type('application/json')

                ->set_output(json_encode([

                    'status' => false,

                    'message' => 'Failed to save page.'

                ]));

        }

    }
public function inquries(){
    $this->load->view('admin/header');
    $this->load->view('admin/inquries_view');
    $this->load->view('admin/footer');
}
public function get_inquries()
{
    $limit = $this->input->post('limit') ?: 5;
    $offset = $this->input->post('offset') ?: 0;
    $search = trim($this->input->post('search'));

    $this->db->select('*');
    $this->db->from('contact_queries');
    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like('first_name', $search);
        $this->db->or_like('last_name', $search);
        $this->db->or_like('email', $search);
        $this->db->or_like('phone', $search);
        $this->db->or_like('subject', $search);
        $this->db->or_like('message', $search);
        $this->db->group_end();
    }
    $this->db->order_by('id', 'DESC');
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    $data = $query->result();

    // Get total count
    $this->db->select('COUNT(*) as total');
    $this->db->from('contact_queries');
    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like('first_name', $search);
        $this->db->or_like('last_name', $search);
        $this->db->or_like('email', $search);
        $this->db->or_like('phone', $search);
        $this->db->or_like('subject', $search);
        $this->db->or_like('message', $search);
        $this->db->group_end();
    }
    $total = $this->db->get()->row()->total;

    echo json_encode(['data' => $data, 'total' => $total]);
}



}