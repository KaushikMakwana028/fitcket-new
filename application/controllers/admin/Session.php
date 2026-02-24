<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Session extends CI_Controller
{
    private $perPage = 10;

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['url', 'form']);
        $this->load->database();
    }

    /* ================= SESSION LIST ================= */
    public function session_list()
    {
        $data = $this->get_session_data(false);

        $this->load->view('admin/header');
        $this->load->view('admin/session_list', $data);
        $this->load->view('admin/footer');
    }

    /* ================= LIVE SESSIONS ================= */
    public function live_sessions()
    {
        $data = $this->get_session_data(true);

        $this->load->view('admin/header');
        $this->load->view('admin/live_sessions', $data);
        $this->load->view('admin/footer');
    }

    private function base_session_query($liveOnly = false)
    {
        $this->db->from('live_sessions');
        $this->db->join('provider', 'provider.id = live_sessions.provider_id', 'left');
        $this->db->join('users u_map', 'u_map.id = provider.provider_id', 'left');
        $this->db->join('users u_direct', 'u_direct.id = live_sessions.provider_id', 'left');
        $this->db->join('categories', 'categories.id = live_sessions.category', 'left');

        if ($liveOnly) {
            $this->db->where('live_sessions.status', 'live');
        } else {
            $this->db->where_in('live_sessions.status', ['live', 'scheduled']);
        }
    }

    private function apply_search_filter($search, $statusFilter = '')
    {
        if ($search === '') {
            // Continue to apply exact filters even when search is empty.
        } else {
            $this->db->group_start();
            $this->db->like('u_map.name', $search);
            $this->db->or_like('u_direct.name', $search);
            $this->db->or_like('live_sessions.title', $search);
            $this->db->or_like('live_sessions.session_type', $search);
            $this->db->or_like('live_sessions.status', $search);
            $this->db->or_like('categories.name', $search);
            $this->db->group_end();
        }

        if ($statusFilter !== '') {
            $this->db->where('live_sessions.status', $statusFilter);
        }

    }

    private function get_session_data($liveOnly = false)
    {
        $search = trim((string) $this->input->get('search'));
        $statusFilter = trim((string) $this->input->get('status'));
        $page = (int) $this->input->get('page');
        $page = $page > 0 ? $page : 1;
        $limit = $this->perPage;

        if ($liveOnly) {
            $statusFilter = 'live';
        } else {
            $allowedStatus = ['live', 'scheduled'];
            if ($statusFilter !== '' && !in_array($statusFilter, $allowedStatus, true)) {
                $statusFilter = '';
            }
        }

        $this->base_session_query($liveOnly);
        $this->apply_search_filter($search, $statusFilter);
        $totalRows = (int) $this->db->count_all_results();

        $totalPages = max(1, (int) ceil($totalRows / $limit));
        if ($page > $totalPages) {
            $page = $totalPages;
        }
        $offset = ($page - 1) * $limit;

        $this->db->select('
            live_sessions.*,
            COALESCE(u_map.name, u_direct.name) as provider_name,
            categories.name as category_name
        ');
        $this->base_session_query($liveOnly);
        $this->apply_search_filter($search, $statusFilter);
        $this->db->order_by('live_sessions.id', 'DESC');
        $this->db->limit($limit, $offset);
        $sessions = $this->db->get()->result();

        $statusCounts = [
            'live' => 0,
            'scheduled' => 0,
        ];

        if (!$liveOnly) {
            $this->base_session_query(false);
            $this->apply_search_filter($search, '');
            $this->db->where('live_sessions.status', 'live');
            $statusCounts['live'] = (int) $this->db->count_all_results();

            $this->base_session_query(false);
            $this->apply_search_filter($search, '');
            $this->db->where('live_sessions.status', 'scheduled');
            $statusCounts['scheduled'] = (int) $this->db->count_all_results();
        }

        return [
            'sessions' => $sessions,
            'search' => $search,
            'status_filter' => $statusFilter,
            'status_counts' => $statusCounts,
            'page' => $page,
            'per_page' => $limit,
            'total_rows' => $totalRows,
            'total_pages' => $totalPages,
            'start_index' => $totalRows > 0 ? ($offset + 1) : 0,
            'end_index' => min($offset + $limit, $totalRows),
        ];
    }
}
