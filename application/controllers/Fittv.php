<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'core/User_Controller.php');
require_once FCPATH . 'vendor/autoload.php';

class Fittv extends User_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('general_model');
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('fittv_gender_select_view');
        $this->load->view('footer');
    }

    public function gender($gender)
    {
        $categories = $this->general_model->getAll(
            'fittv_categories',
            ['gender' => $gender, 'isActive' => 1]
        );

        $data['gender'] = $gender;
        $data['categories'] = $categories;

        $this->load->view('header');
        $this->load->view('fittv_view', $data);
        $this->load->view('footer');
    }

    public function videos($category_id)
    {
        $category = $this->general_model->getOne(
            'fittv_categories',
            ['id' => $category_id]
        );

        if (!$category) {
            redirect('fittv/Boy');
        }

        $data['videos'] = $this->general_model->getAll(
            'fittv_videos',
            ['category_id' => $category_id]
        );
        $data['category'] = $category;
        $data['gender'] = $category->gender;

        $this->load->view('header');
        $this->load->view('fittv_user_videos_view', $data);
        $this->load->view('footer');
    }

}
