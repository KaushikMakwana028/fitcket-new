<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'core/Admin_Controller.php');

class Host_requests extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata('admin')) {
            redirect('admin/login');
        }

        $this->load->database();
    }

    // 📋 LIST
    public function index()
    {
        $data['requests'] = $this->db
            ->order_by('id', 'DESC')
            ->get('host_requests')
            ->result_array();

        $this->load->view('admin/header');
        $this->load->view('admin/host_requests_view', $data);
        $this->load->view('admin/footer');
    }

    // ✅ ACCEPT
    public function accept($id)
    {
        $request = $this->db->get_where('host_requests', ['id' => $id])->row_array();

        if (!$request) {
            redirect('admin/host_requests');
        }

        // Update request
        $this->db->where('id', $id)->update('host_requests', [
            'status' => 'accepted'
        ]);

        // Update user → MAKE HOST
        $this->db->where('id', $request['user_id'])->update('users', [
            'is_host' => 1
        ]);

        redirect('admin/host_requests');
    }

    // ❌ REJECT
    public function reject($id)
    {
        $request = $this->db->get_where('host_requests', ['id' => $id])->row_array();

        if (!$request) {
            redirect('admin/host_requests');
        }

        // Update request
        $this->db->where('id', $id)->update('host_requests', [
            'status' => 'rejected'
        ]);

        // 🔥 IMPORTANT: REMOVE HOST ACCESS
        $this->db->where('id', $request['user_id'])->update('users', [
            'is_host' => 0
        ]);

        redirect('admin/host_requests');
    }

    // 🔄 PENDING
    public function pending($id)
    {
        $request = $this->db->get_where('host_requests', ['id' => $id])->row_array();

        if (!$request) {
            redirect('admin/host_requests');
        }

        // Update request
        $this->db->where('id', $id)->update('host_requests', [
            'status' => 'pending'
        ]);

        // 🔥 IMPORTANT: REMOVE HOST ACCESS
        $this->db->where('id', $request['user_id'])->update('users', [
            'is_host' => 0
        ]);

        redirect('admin/host_requests');
    }
}
