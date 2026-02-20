<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');

class Payment extends Admin_Controller
{



    public function __construct()
    {

        parent::__construct();
    }

    public function index()
    {
        $this->load->view('admin/header');
        $this->load->view('admin/payment_view');
        $this->load->view('admin/footer');
    }
    public function payouts_list()
    {
        $limit  = (int)($this->input->post('limit') ?? 5);
        $page   = (int)($this->input->post('page') ?? 1);
        $search = $this->input->post('search');

        if ($page < 1) $page = 1;
        if ($limit < 1) $limit = 5;

        $offset = ($page - 1) * $limit;

        // -------------------------
        // BASE QUERY (for filtering)
        // -------------------------
        $this->db->from("provider_payouts p");
        $this->db->join("users u", "u.id = p.provider_id", "left");

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('u.gym_name', $search);
            $this->db->or_like('u.mobile', $search);
            $this->db->group_end();
        }

        // -------------------------
        // TOTAL COUNT WITH FILTER
        // -------------------------
        $total = $this->db->count_all_results('', false); // false = don't reset query

        // -------------------------
        // SELECT DATA
        // -------------------------
        $this->db->select("p.id, p.provider_id, p.amount, p.status, p.created_at as request_date, u.gym_name, u.mobile");
        $this->db->order_by("p.id", "DESC");
        $this->db->limit($limit, $offset);

        $query = $this->db->get();
        $data  = $query->result();

        // -------------------------
        // PAGINATION
        // -------------------------
        $total_pages = max(1, ceil($total / $limit));
        $page = min($page, $total_pages);

        $pagination = '';
        $prev_page = max(1, $page - 1);
        $next_page = min($total_pages, $page + 1);

        // Previous
        $pagination .= '<li class="page-item ' . ($page == 1 ? 'disabled' : '') . '">
        <a class="page-link" href="#" data-page="' . $prev_page . '">Previous</a>
    </li>';

        // First
        $pagination .= '<li class="page-item ' . ($page == 1 ? 'active' : '') . '">
        <a class="page-link" href="#" data-page="1">1</a>
    </li>';

        if ($page > 3) {
            $pagination .= '<li class="page-item disabled">
            <span class="page-link">...</span>
        </li>';
        }

        $start = max(2, $page - 1);
        $end   = min($total_pages - 1, $page + 1);

        for ($i = $start; $i <= $end; $i++) {
            if ($i > 1 && $i < $total_pages) {
                $pagination .= '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
                <a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a>
            </li>';
            }
        }

        if ($page < $total_pages - 2) {
            $pagination .= '<li class="page-item disabled">
            <span class="page-link">...</span>
        </li>';
        }

        if ($total_pages > 1) {
            $pagination .= '<li class="page-item ' . ($page == $total_pages ? 'active' : '') . '">
            <a class="page-link" href="#" data-page="' . $total_pages . '">' . $total_pages . '</a>
        </li>';
        }

        // Next
        $pagination .= '<li class="page-item ' . ($page == $total_pages ? 'disabled' : '') . '">
        <a class="page-link" href="#" data-page="' . $next_page . '">Next</a>
    </li>';

        echo json_encode([
            'data'       => $data,
            'total'      => $total,
            'limit'      => $limit,
            'page'       => $page,
            'pagination' => $pagination
        ]);
    }


    public function payment_setting()
    {
        $query = $this->db->get('payment_settings');
        $data['payment'] = $query->row_array();

        $this->load->view('admin/header');
        $this->load->view('admin/payment_setting_view', $data);
        $this->load->view('admin/footer');
    }
    public function save()
    {
        $id         = $this->input->post('id', TRUE);
        $wallet_min = $this->input->post('wallet_min', TRUE);
        $commission = $this->input->post('commission', TRUE);

        if ($wallet_min === "" || $commission === "") {
            echo json_encode([
                'status'  => 'error',
                'message' => 'All fields are required.'
            ]);
            return;
        }

        $data = [
            'wallet_min' => $wallet_min,
            'commission' => $commission,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if (!empty($id)) {

            $this->db->where('id', $id);
            $result = $this->db->update('payment_settings', $data);
        } else {

            $result = $this->db->insert('payment_settings', $data);
        }

        if ($result) {
            echo json_encode([
                'status'  => 'success',
                'message' => 'Payment settings saved successfully.'
            ]);
        } else {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Failed to save settings. Please try again.'
            ]);
        }
    }
}
