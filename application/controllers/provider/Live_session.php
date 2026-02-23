<?php
// application/controllers/provider/Live_session.php

defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'core/Provider_Controller.php');

class Live_session extends Provider_Controller
{
    public function __construct()
    {

        parent::__construct();
        $this->load->model('Live_session_model');

        $this->load->library('Agora_lib');

    }

    public function index()
    {
        //  echo "h";
        // die;
        $data['sessions'] = $this->Live_session_model->getProviderSessions($this->provider['id']);
        $data['categories'] = $this->getCategories();

        $this->load->view('provider/header', $data);
        $this->load->view('provider/live_sessions_list', $data);
        $this->load->view('provider/footer');
    }

    public function create()
    {
        $data['categories'] = $this->getCategories();
        $data['session'] = null;

        $this->load->view('provider/header', $data);
        $this->load->view('provider/session_form', $data);
        $this->load->view('provider/footer');
    }

    public function edit($id)
    {
        $session = $this->Live_session_model->getSession($id);

        if (!$session || $session['provider_id'] != $this->provider['id']) {
            redirect('provider/live_session');
        }

        $data['session'] = $session;
        $data['categories'] = $this->getCategories();

        $this->load->view('provider/header', $data);
        $this->load->view('provider/session_form', $data);
        $this->load->view('provider/footer');
    }

    public function save()
    {
        $input = $this->input->post();
        $provider_id = $this->provider['id'];

        // ================= VALIDATION =================
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]');
        $this->form_validation->set_rules('session_date', 'Session Date', 'required');
        $this->form_validation->set_rules('start_time', 'Start Time', 'required');
        $this->form_validation->set_rules('duration', 'Duration', 'required|numeric');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode([
                'status' => 'error',
                'message' => strip_tags(validation_errors())
            ]);
            return;
        }

        // ================= TIME CALCULATION =================
        $start_time = $input['start_time'];
        $duration = (int) $input['duration'];
        $end_time = date('H:i:s', strtotime($start_time) + ($duration * 60));

        // ================= AGORA CHANNEL =================
        $channel_name = 'live_' . $provider_id . '_' . time() . '_' . rand(1000, 9999);

        // ================= THUMBNAIL UPLOAD =================
        $thumbnail = null;

        if (!empty($_FILES['thumbnail']['name'])) {

            $config['upload_path'] = './uploads/session_thumbnails/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['encrypt_name'] = true;
            $config['max_size'] = 5120; // 5MB

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('thumbnail')) {
                echo json_encode([
                    'status' => 'error',
                    'message' => $this->upload->display_errors('', '')
                ]);
                return;
            }

            $uploadData = $this->upload->data();
            $thumbnail = $uploadData['file_name'];
        }
        // ================= SESSION DATA =================
        $sessionData = [
        'provider_id' => $provider_id,
        'title' => trim($input['title']),
        'description' => trim($input['description'] ?? ''),
        'session_date' => $input['session_date'],
        'start_time' => $start_time,
        'end_time' => $end_time,
        'duration_minutes' => $duration,
        'max_participants' => $input['max_participants'] ?? 1,
        'current_participants' => 0, // ✅ Initialize capacity tracking
        'is_full' => 0,
        'price' => $input['price'],
        'session_type' => $input['session_type'] ?? 'one_on_one',
        'category' => $input['category'] ?? null,
        'recurring' => $input['recurring'] ?? 'none',
        'status' => 'scheduled'
    ];


        // Add thumbnail only if uploaded
        if ($thumbnail) {
            $sessionData['thumbnail'] = $thumbnail;
        }

        // ================= CREATE / UPDATE =================
        if (!empty($input['session_id'])) {

            $session_id = (int) $input['session_id'];

            // OPTIONAL: delete old thumbnail
            if ($thumbnail) {
                $old = $this->Live_session_model->getSessionById($session_id);
                if (!empty($old['thumbnail'])) {
                    @unlink('./uploads/session_thumbnails/' . $old['thumbnail']);
                }
            }

            $this->Live_session_model->updateSession($session_id, $sessionData);
            $message = 'Session updated successfully!';

        } else {

            $sessionData['room_id'] = $channel_name;
            $session_id = $this->Live_session_model->createSession($sessionData);
            $message = 'Session created successfully!';

            if ($input['recurring'] != 'none') {
                $this->createRecurringSessions(
                    $sessionData,
                    $input['recurring'],
                    $input['recurring_count'] ?? 4
                );
            }
        }

        echo json_encode([
            'status' => 'success',
            'message' => $message,
            'session_id' => $session_id
        ]);
    }
public function delete($id)
    {
        $session = $this->Live_session_model->getSession($id);

        if (!$session || $session['provider_id'] != $this->provider['id']) {
            echo json_encode(['status' => 'error', 'message' => 'Session not found']);
            return;
        }



        $this->Live_session_model->deleteSession($id);

        echo json_encode(['status' => 'success', 'message' => 'Session deleted successfully']);
    }
   
    

    public function start_session($id)
    {
        $session = $this->Live_session_model->getSession($id);

        if (!$session || $session['provider_id'] != $this->provider['id']) {
            redirect('provider/live_session');
        }

        // Update session status to live
        $startedAt = date('Y-m-d H:i:s');

        $this->Live_session_model->updateSession($id, [
            'status' => 'live',
            'started_at' => $startedAt
        ]);
        // Generate Agora token for provider (as publisher)
        $uid = intval($this->provider['id']);
        $token = $this->agora_lib->generateToken(
            $session['room_id'],  // Channel name
            $uid,
            Agora_lib::ROLE_PUBLISHER,
            7200 // 2 hours token expiry
        );

        $data['session'] = $session;
        $data['token'] = $token;
        $data['app_id'] = $this->agora_lib->getAppID();
        $data['channel'] = $session['room_id'];
        $data['user_type'] = 'provider';
        $data['uid'] = $uid;
        $data['user_name'] = $this->provider['name'];
        $data['participants'] = $this->Live_session_model->getSessionBookings($id);
        $data['started_at'] = $startedAt;
        // echo "<pre>";

        // print_r($data);


        // die;

        // die;
        $this->load->view('provider/header', $data);
        $this->load->view('provider/live_room_agora', $data);
        $this->load->view('provider/footer');
    }

    public function end_session($id)
    {
        $session = $this->Live_session_model->getSession($id);

        if (!$session || $session['provider_id'] != $this->provider['id']) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            return;
        }
        // echo "h";
        // die;

        // Update session status
        $this->Live_session_model->updateSession($id, [
            'status' => 'completed',
            'ended_at' => date('Y-m-d H:i:s')
        ]);

        // Update all bookings attendance
        $this->Live_session_model->updateBookingsAttendance($id);

        echo json_encode(['status' => 'success', 'message' => 'Session ended successfully']);
    }

    public function get_token()
    {
        $channel = $this->input->post('channel');
        $uid = intval($this->input->post('uid'));
        $role = $this->input->post('role') === 'publisher' ? Agora_lib::ROLE_PUBLISHER : Agora_lib::ROLE_SUBSCRIBER;

        if (!$channel) {
            echo json_encode(['status' => 'error', 'message' => 'Channel name required']);
            return;
        }

        $token = $this->agora_lib->generateToken($channel, $uid, $role, 7200);

        echo json_encode([
            'status' => 'success',
            'token' => $token,
            'uid' => $uid
        ]);
    }

    public function get_bookings($session_id)
    {
        $bookings = $this->Live_session_model->getSessionBookings($session_id);
        echo json_encode(['status' => 'success', 'bookings' => $bookings]);
    }

    public function calendar()
    {
        $data['sessions'] = $this->Live_session_model->getProviderSessions($this->provider['id']);

        $this->load->view('provider/header', $data);
        $this->load->view('provider/session_calendar', $data);
        $this->load->view('provider/footer');
    }

    public function get_sessions_json()
    {
        $sessions = $this->Live_session_model->getProviderSessions($this->provider['id']);

        $events = [];
        foreach ($sessions as $session) {
            $events[] = [
                'id' => $session['id'],
                'title' => $session['title'],
                'start' => $session['session_date'] . 'T' . $session['start_time'],
                'end' => $session['session_date'] . 'T' . $session['end_time'],
                'color' => $this->getStatusColor($session['status']),
                'extendedProps' => [
                    'status' => $session['status'],
                    'price' => $session['price'],
                    'participants' => $session['booked_count'] ?? 0
                ]
            ];
        }

        echo json_encode($events);
    }

    private function getStatusColor($status)
    {
        $colors = [
            'scheduled' => '#3788d8',
            'live' => '#28a745',
            'completed' => '#6c757d',
            'cancelled' => '#dc3545'
        ];
        return $colors[$status] ?? '#3788d8';
    }

    private function getCategories()
    {
        $rows = $this->db
            ->select('id, name')
            ->from('categories')
            ->where('isActive', 1)
            ->order_by('name', 'ASC')
            ->get()
            ->result_array();

        $categories = [];
        foreach ($rows as $row) {
            $id = (string)($row['id'] ?? '');
            $name = trim((string)($row['name'] ?? ''));
            if ($id !== '' && $name !== '') {
                $categories[$id] = $name;
            }
        }

        // Fallback if categories table is empty/misconfigured
        if (empty($categories)) {
            return [
                'yoga' => 'Yoga',
                'fitness' => 'Fitness Training',
                'meditation' => 'Meditation',
                'cardio' => 'Cardio Workout',
                'strength' => 'Strength Training',
                'hiit' => 'HIIT',
                'pilates' => 'Pilates',
                'dance' => 'Dance Fitness',
                'nutrition' => 'Nutrition Consulting',
                'other' => 'Other'
            ];
        }

        return $categories;
    }

    // private function processRefund($booking)
    // {
    //     $this->db->update('session_bookings', 
    //         ['payment_status' => 'refunded', 'attendance_status' => 'cancelled'],
    //         ['id' => $booking['id']]
    //     );
    // }
    public function getPublicSessions()
    {
        $this->db->select('*');
        $this->db->from('live_sessions');
        $this->db->where('status', 'scheduled');
        $this->db->where('session_date >=', date('Y-m-d'));
        $this->db->order_by('session_date', 'ASC');
        $this->db->order_by('start_time', 'ASC');

        return $this->db->get()->result_array();
    }

}
