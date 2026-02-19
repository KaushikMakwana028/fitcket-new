<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');



class Booking extends Admin_Controller

{

    public function __construct()

    {

        parent::__construct();
    }



    public function index()

    {

        $this->load->view('admin/header');

        $this->load->view('admin/booking_view');

        $this->load->view('admin/footer');
    }



    public function fetch_partnerss()
    {
        $limit  = 10;
        $page   = (int)$this->input->post('page');
        $search = trim($this->input->post('search'));
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        // ----- COUNT query -----
        $this->db->start_cache();
        $this->db->from('order_items oi');
        $this->db->join('orders o', 'o.id = oi.order_id', 'left');
        $this->db->join('users u', 'u.id = o.user_id', 'left');
        $this->db->join('users p', 'p.id = oi.provider_id', 'left');

        if ($search !== '') {
            $this->db->group_start()
                ->like('u.name', $search)
                ->or_like('u.mobile', $search)
                ->or_like('p.name', $search)
                ->or_like('p.gym_name', $search)
                ->group_end();
        }
        $this->db->stop_cache();
        $total_rows = $this->db->count_all_results();

        // ----- DATA query -----
        $this->db->select('
        o.id as order_id,
        u.name as customer_name,
        u.mobile,
        COALESCE(p.gym_name, p.name) as provider_name,
        o.created_at,
        o.status,
        oi.price as amount,
        oi.duration,
        oi.qty,
        oi.free_qty,
        oi.total_qty,
        oi.start_date
    ');
        $this->db->order_by('o.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        $rows = $this->db->get()->result();
        $this->db->flush_cache();

        // ----- PAGINATION -----
        $total_pages = max(1, (int)ceil($total_rows / $limit));
        $page = max(1, min($page, $total_pages));

        $pagination = '';
        $prev_page = max(1, $page - 1);
        $next_page = min($total_pages, $page + 1);

        // Previous Button
        $pagination .= '<li class="page-item ' . ($page == 1 ? 'disabled' : '') . '">
    <a class="page-link" href="#" data-page="' . $prev_page . '">Previous</a>
</li>';

        if ($total_pages <= 5) {
            // If total pages small, show all
            for ($i = 1; $i <= $total_pages; $i++) {
                $active = ($i == $page) ? 'active' : '';
                $pagination .= '<li class="page-item ' . $active . '">
            <a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a>
        </li>';
            }
        } else {

            // Always show first page
            $pagination .= '<li class="page-item ' . ($page == 1 ? 'active' : '') . '">
        <a class="page-link" href="#" data-page="1">1</a>
    </li>';

            // Show left dots
            if ($page > 3) {
                $pagination .= '<li class="page-item disabled">
            <span class="page-link">...</span>
        </li>';
            }

            // Middle pages (3 pages around current)
            $start = max(2, $page - 1);
            $end   = min($total_pages - 1, $page + 1);

            for ($i = $start; $i <= $end; $i++) {
                $active = ($i == $page) ? 'active' : '';
                $pagination .= '<li class="page-item ' . $active . '">
            <a class="page-link" href="#" data-page="' . $i . '">' . $i . '</a>
        </li>';
            }

            // Show right dots
            if ($page < $total_pages - 2) {
                $pagination .= '<li class="page-item disabled">
            <span class="page-link">...</span>
        </li>';
            }

            // Always show last page
            $pagination .= '<li class="page-item ' . ($page == $total_pages ? 'active' : '') . '">
        <a class="page-link" href="#" data-page="' . $total_pages . '">' . $total_pages . '</a>
    </li>';
        }

        // Next Button
        $pagination .= '<li class="page-item ' . ($page == $total_pages ? 'disabled' : '') . '">
    <a class="page-link" href="#" data-page="' . $next_page . '">Next</a>
</li>';


        echo json_encode([
            'rows'       => $rows,
            'pagination' => $pagination,
            'total'      => $total_rows,
            'limit'      => $limit,
            'page'       => $page
        ]);
    }
}
