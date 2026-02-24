<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');

class Reviews extends Admin_Controller
{
    private $perPage = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function review_list()
    {
        $search = trim((string) $this->input->get('search'));
        $page = (int) $this->input->get('page');
        $page = $page > 0 ? $page : 1;
        $offset = ($page - 1) * $this->perPage;

        $this->base_review_query();
        $this->apply_search_filter($search);
        $totalRows = (int) $this->db->count_all_results();
        $totalPages = max(1, (int) ceil($totalRows / $this->perPage));

        if ($page > $totalPages) {
            $page = $totalPages;
            $offset = ($page - 1) * $this->perPage;
        }

        $this->db->select('
            reviews.id,
            reviews.rating,
            reviews.review_text,
            reviews.created_at,
            u.name as user_name,
            COALESCE(NULLIF(p_map.gym_name, ""), NULLIF(p_map.name, ""), NULLIF(p_direct.gym_name, ""), NULLIF(p_direct.name, "")) as provider_name
        ');
        $this->base_review_query();
        $this->apply_search_filter($search);
        $this->db->order_by('reviews.id', 'DESC');
        $this->db->limit($this->perPage, $offset);
        $reviews = $this->db->get()->result();

        $data = [
            'reviews' => $reviews,
            'search' => $search,
            'page' => $page,
            'total_rows' => $totalRows,
            'total_pages' => $totalPages,
            'start_index' => $totalRows > 0 ? ($offset + 1) : 0,
            'end_index' => min($offset + $this->perPage, $totalRows),
        ];

        $this->load->view('admin/header');
        $this->load->view('admin/review_list', $data);
        $this->load->view('admin/footer');
    }

    private function base_review_query()
    {
        $this->db->from('reviews');
        $this->db->join('users as u', 'u.id = reviews.user_id', 'left');
        $this->db->join('provider as p', 'p.id = reviews.provider_id', 'left');
        $this->db->join('users as p_map', 'p_map.id = p.provider_id', 'left');
        $this->db->join('users as p_direct', 'p_direct.id = reviews.provider_id', 'left');
    }

    private function apply_search_filter($search)
    {
        if ($search === '') {
            return;
        }

        $this->db->group_start();
        $this->db->like('u.name', $search);
        $this->db->or_like('p_map.name', $search);
        $this->db->or_like('p_map.gym_name', $search);
        $this->db->or_like('p_direct.name', $search);
        $this->db->or_like('p_direct.gym_name', $search);
        $this->db->or_like('reviews.review_text', $search);
        $this->db->group_end();
    }
}
