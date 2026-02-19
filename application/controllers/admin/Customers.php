<?php



defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');







class Customers extends Admin_Controller

{



    public function __construct()

    {

        parent::__construct();
    }





    public function index()

    {

        $this->load->view('admin/header');

        $this->load->view('admin/customer_view');

        $this->load->view('admin/footer');
    }



    public function fetch_customers()
    {
        $limit = 10;
        $page = (int) $this->input->get('page');
        if ($page < 1) $page = 1;

        $search = $this->input->get('search');
        $offset = ($page - 1) * $limit;

        // ---------- COUNT QUERY ----------
        $this->db->from('users');
        $this->db->where('role', 0);

        if (!empty($search)) {
            $this->db->group_start()
                ->like('name', $search)
                ->or_like('email', $search)
                ->or_like('mobile', $search)
                ->group_end();
        }

        $total = $this->db->count_all_results();

        // ---------- DATA QUERY ----------
        $this->db->from('users');
        $this->db->where('role', 0);

        if (!empty($search)) {
            $this->db->group_start()
                ->like('name', $search)
                ->or_like('email', $search)
                ->or_like('mobile', $search)
                ->group_end();
        }

        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $customers = $query->result_array();

        // ---------- PAGINATION ----------
        $total_pages = max(1, ceil($total / $limit));
        $page = max(1, min($page, $total_pages));

        $pagination = '';
        $prev_page = max(1, $page - 1);
        $next_page = min($total_pages, $page + 1);

        // Previous
        $pagination .= '<li class="page-item ' . ($page == 1 ? 'disabled' : '') . '">
    <a class="page-link" href="#" data-page="' . $prev_page . '">Previous</a>
</li>';

        // First page
        $pagination .= '<li class="page-item ' . ($page == 1 ? 'active' : '') . '">
    <a class="page-link" href="#" data-page="1">1</a>
</li>';

        // Left dots
        if ($page > 3) {
            $pagination .= '<li class="page-item disabled">
        <span class="page-link">...</span>
    </li>';
        }

        // Middle pages (only 3 max)
        $start = max(2, $page - 1);
        $end   = min($total_pages - 1, $page + 1);

        for ($i = $start; $i <= $end; $i++) {
            if ($i > 1 && $i < $total_pages) {
                $pagination .= '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
            <a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a>
        </li>';
            }
        }

        // Right dots
        if ($page < $total_pages - 2) {
            $pagination .= '<li class="page-item disabled">
        <span class="page-link">...</span>
    </li>';
        }

        // Last page
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
            'customers' => $customers,
            'total'     => $total,
            'limit'     => $limit,
            'page'      => $page,
            'pagination' => $pagination
        ]);
    }



    public function togglePartnerStatus()

    {

        $partnerId = $this->input->post('partner_id');

        $status = $this->input->post('status');



        $this->db->trans_start();

        $this->db->where('id', $partnerId)->update('users', ['isActive' => $status]);

        $this->db->where('provider_id', $partnerId)->update('provider', ['isActive' => $status]);

        $this->db->trans_complete();



        if ($this->db->trans_status() === FALSE) {

            echo json_encode(['status' => 'error', 'message' => 'Failed to update user status.']);
        } else {

            echo json_encode(['status' => 'success']);
        }
    }
}
