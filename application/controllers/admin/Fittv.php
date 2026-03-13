<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'core/Admin_Controller.php');

class Fittv extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('general_model');
    }


    /* CATEGORY LIST */

    public function category()
    {
        $limit = 10;
        $search = $this->input->get('search');
        $gender = $this->input->get('gender');
        
        $_GET['page'] = isset($_GET['page']) ? $_GET['page'] : "0";
        $offset = (int)$_GET['page'];

        $this->db->from('fittv_categories');

        if (!empty($search)) {
            $this->db->like('name', $search);
        }

        if (!empty($gender)) {
            $this->db->where('gender', $gender);
        }

        $total = $this->db->count_all_results('', false);
        $this->db->limit($limit, $offset);

        $data['categories'] = $this->db->get()->result();

        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/fittv_category');
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config['reuse_query_string'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';

        $config['full_tag_open'] = '<ul class="pagination round-pagination justify-content-center mb-0">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('admin/header');
        $this->load->view('admin/fittv_category_view', $data);
        $this->load->view('admin/footer');
    }


    /* ADD CATEGORY */

    public function add_category()
    {

        $this->load->view('admin/header');
        $this->load->view('admin/add_fittv_category');
        $this->load->view('admin/footer');
    }


    /* SAVE CATEGORY */

    public function save_category()
    {

        $gender = $this->input->post('gender');
        $name = $this->input->post('name');

        $exists = $this->db->get_where('fittv_categories', ['name' => $name, 'gender' => $gender])->row();

        if ($exists) {
            $this->session->set_flashdata('error', 'Category "' . $name . '" already exists for "' . $gender . '".');
            redirect('admin/add_fittv_category');
            return;
        }

        $data = [
            'gender' => $gender,
            'name' => $name
        ];

        $this->general_model->insert('fittv_categories', $data);
        $this->session->set_flashdata('success', 'Category added successfully!');
        redirect('admin/fittv_category');
    }



    /* VIDEO LIST */

    public function videos()
    {

        $limit = 10;

        $search = $this->input->get('search');
        $gender = $this->input->get('gender');
        
        $_GET['page'] = isset($_GET['page']) ? $_GET['page'] : "0";
        $offset = (int)$_GET['page'];

        $this->db->select('fittv_videos.*,
                       fittv_categories.name as category_name,
                       fittv_categories.gender');

        $this->db->from('fittv_videos');

        $this->db->join(
            'fittv_categories',
            'fittv_categories.id = fittv_videos.category_id',
            'left'
        );

        if (!empty($search)) {
            $this->db->like('fittv_videos.title', $search);
        }

        if (!empty($gender)) {
            $this->db->where('fittv_categories.gender', $gender);
        }

        $total = $this->db->count_all_results('', false);
        $this->db->limit($limit, $offset);

        $data['videos'] = $this->db->get()->result();

        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/fittv_videos');
        $config['total_rows'] = $total;
        $config['per_page'] = $limit;
        $config['reuse_query_string'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';

        $config['full_tag_open'] = '<ul class="pagination mt-3 mb-0">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('admin/header');
        $this->load->view('admin/fittv_videos_view', $data);
        $this->load->view('admin/footer');
    }



    /* ADD VIDEO */

    public function add_video()
    {

        $data['categories'] = $this->general_model->getAll('fittv_categories');

        $this->load->view('admin/header');
        $this->load->view('admin/add_fittv_video', $data);
        $this->load->view('admin/footer');
    }



    /* SAVE VIDEO */

    public function save_video()
    {

        $config['upload_path'] = './uploads/videos/';
        $config['allowed_types'] = 'mp4|webm|mov';
        $config['max_size'] = 50000;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('video')) {
            echo $this->upload->display_errors();
            exit;
        }

        $file = $this->upload->data();

        $data = [

            'category_id' => $this->input->post('category_id'),
            'title' => $this->input->post('title'),
            'video' => $file['file_name']

        ];

        $this->general_model->insert('fittv_videos', $data);
        $this->session->set_flashdata('success', 'Video uploaded successfully!');
        redirect('admin/fittv_videos');
    }

    public function category_list($offset = 0)
    {

        $limit = 10;

        $search = $this->input->get('search');
        $gender = $this->input->get('gender');


        $this->db->from('fittv_categories');

        if (!empty($search)) {
            $this->db->like('name', $search);
        }

        if (!empty($gender)) {
            $this->db->where('gender', $gender);
        }

        $total = $this->db->count_all_results('', false);

        $this->db->limit($limit, $offset);

        $data['categories'] = $this->db->get()->result();

        $data['total'] = $total;
        $data['limit'] = $limit;

        $this->load->view('admin/header');
        $this->load->view('admin/fittv_category_view', $data);
        $this->load->view('admin/footer');
    }

    public function edit_category($id)
    {

        $data['category'] = $this->general_model->getOne('fittv_categories', ['id' => $id]);

        $this->load->view('admin/header');
        $this->load->view('admin/edit_fittv_category', $data);
        $this->load->view('admin/footer');
    }

    public function update_category()
    {

        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $gender = $this->input->post('gender');

        $exists = $this->db->get_where('fittv_categories', ['name' => $name, 'gender' => $gender, 'id !=' => $id])->row();

        if ($exists) {
            $this->session->set_flashdata('error', 'Category "' . $name . '" already exists for "' . $gender . '".');
            redirect('admin/edit_fittv_category/' . $id);
            return;
        }

        $data = [
            'name' => $name,
            'gender' => $gender,
            'isActive' => $this->input->post('isActive')
        ];

        $this->general_model->update('fittv_categories', ['id' => $id], $data);
        $this->session->set_flashdata('success', 'Category updated successfully!');
        redirect('admin/fittv_category');
    }

    public function delete_category($id)
    {

        $this->general_model->delete('fittv_categories', ['id' => $id]);
        $this->session->set_flashdata('success', 'Category deleted successfully!');
        redirect('admin/fittv_category');
    }

    public function video_list($offset = 0)
    {

        $limit = 10;

        $search = $this->input->get('search');
        $gender = $this->input->get('gender');

        $this->db->select('fittv_videos.*,fittv_categories.name as category_name,fittv_categories.gender');
        $this->db->from('fittv_videos');
        $this->db->join('fittv_categories', 'fittv_categories.id=fittv_videos.category_id');

        if (!empty($search)) {
            $this->db->like('title', $search);
        }

        if (!empty($gender)) {
            $this->db->where('fittv_categories.gender', $gender);
        }

        $total = $this->db->count_all_results('', false);

        $this->db->limit($limit, $offset);

        $data['videos'] = $this->db->get()->result();

        $this->load->view('admin/header');
        $this->load->view('admin/fittv_videos_view', $data);
        $this->load->view('admin/footer');
    }

    public function edit_video($id)
    {

        $video = $this->db->where('id', $id)->get('fittv_videos')->row();

        $categories = $this->db->get('fittv_categories')->result();

        $data['video'] = $video;
        $data['categories'] = $categories;

        $this->load->view('admin/header');
        $this->load->view('admin/edit_fittv_video', $data);
        $this->load->view('admin/footer');
    }

    public function update_video()
    {

        $id = $this->input->post('id');

        $title = $this->input->post('title');

        $category_id = $this->input->post('category_id');

        $video_name = $this->input->post('old_video');


        if (!empty($_FILES['video']['name'])) {

            $config['upload_path'] = './uploads/videos/';
            $config['allowed_types'] = 'mp4|webm|mov';
            $config['max_size'] = 50000;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('video')) {

                $file = $this->upload->data();

                $video_name = $file['file_name'];
            }
        }

        $data = [

            'title' => $title,
            'category_id' => $category_id,
            'video' => $video_name

        ];

        $this->db->where('id', $id);
        $this->db->update('fittv_videos', $data);
        $this->session->set_flashdata('success', 'Video updated successfully!');
        redirect('admin/fittv_videos');
    }

    public function delete_video($id)
    {

        $this->general_model->delete('fittv_videos', ['id' => $id]);
        $this->session->set_flashdata('success', 'Video deleted successfully!');
        redirect('admin/fittv_videos');
    }

    public function save_fittv_video()
    {

        $config['upload_path'] = './uploads/videos/';
        $config['allowed_types'] = 'mp4|webm|mov';
        $config['max_size'] = 50000;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('video')) {

            echo $this->upload->display_errors();
            exit;
        }

        $file = $this->upload->data();

        $data = [

            'category_id' => $this->input->post('category_id'),
            'title' => $this->input->post('title'),
            'video' => $file['file_name']

        ];

        $this->db->insert('fittv_videos', $data);
        $this->session->set_flashdata('success', 'Video added successfully!');
        redirect('admin/fittv_videos');
    }

    public function get_categories_by_gender()
    {
        $gender = $this->input->post('gender');
        if($gender) {
            $categories = $this->db->where('gender', $gender)
                                   ->where('isActive', 1)
                                   ->get('fittv_categories')
                                   ->result();
            echo json_encode($categories);
        } else {
            echo json_encode([]);
        }
    }
}
