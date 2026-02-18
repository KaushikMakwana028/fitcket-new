<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Provider_Controller.php');

class Live_session extends Provider_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Session_model');
        $this->load->library('form_validation');
        $this->load->library('Zegocloud');
    }

    /**
     * Main session dashboard
     */
    public function index()
    {
        $data['title'] = 'Live Sessions';
        $data['stats'] = $this->Session_model->getDashboardStats($this->provider['id'] ?? $this->provider['user_id']);
        $data['today_sessions'] = $this->Session_model->getTodaySessions($this->provider['id'] ?? $this->provider['user_id']);
        $data['upcoming_sessions'] = $this->Session_model->getUpcomingSessions($this->provider['id'] ?? $this->provider['user_id'], 10);
        $data['live_session'] = $this->Session_model->getLiveSession($this->provider['id'] ?? $this->provider['user_id']);
        
        $this->load->view('provider/header', $data);
        $this->load->view('provider/live_session/index', $data);
        $this->load->view('provider/footer');
    }

    /**
     * Create new session page
     */
    public function create()
    {
        $data['title'] = 'Create New Session';
        $data['categories'] = $this->getCategories();
        
        $this->load->view('provider/header', $data);
        $this->load->view('provider/live_session/create', $data);
        $this->load->view('provider/footer');
    }

    /**
     * Save new session (AJAX)
     */
    public function save()
    {
        header('Content-Type: application/json');
        
        $input = $this->input->post();
        $providerId = $this->provider['provider_id'];

        // Validation
        $this->form_validation->set_rules('title', 'Title', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('scheduled_date', 'Date', 'required');
        $this->form_validation->set_rules('start_time', 'Start Time', 'required');
        $this->form_validation->set_rules('end_time', 'End Time', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
        $this->form_validation->set_rules('category', 'Category', 'required');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode([
                'status' => 'error',
                'message' => strip_tags(validation_errors())
            ]);
            return;
        }

        // Validate date is not in the past
        $scheduledDateTime = $input['scheduled_date'] . ' ' . $input['start_time'];
        if (strtotime($scheduledDateTime) < time()) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Cannot schedule session in the past'
            ]);
            return;
        }

        // Calculate duration
        $startTime = strtotime($input['start_time']);
        $endTime = strtotime($input['end_time']);
        $duration = ($endTime - $startTime) / 60;

        if ($duration <= 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'End time must be after start time'
            ]);
            return;
        }

        if ($duration > 480) { // Max 8 hours
            echo json_encode([
                'status' => 'error',
                'message' => 'Session duration cannot exceed 8 hours'
            ]);
            return;
        }

        // Check for conflicts
        $hasConflict = $this->Session_model->hasConflict(
            $providerId,
            $input['scheduled_date'],
            $input['start_time'],
            $input['end_time']
        );

        if ($hasConflict) {
            echo json_encode([
                'status' => 'error',
                'message' => 'You already have a session scheduled during this time'
            ]);
            return;
        }

        // Handle thumbnail upload
        $thumbnail = null;
        if (!empty($_FILES['thumbnail']['name'])) {
            $config['upload_path'] = './uploads/sessions/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['max_size'] = 2048;
            $config['file_name'] = 'session_' . time() . '_' . rand(1000, 9999);

            if (!is_dir('./uploads/sessions/')) {
                mkdir('./uploads/sessions/', 0755, true);
            }

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('thumbnail')) {
                $uploadData = $this->upload->data();
                $thumbnail = 'uploads/sessions/' . $uploadData['file_name'];
            }
        }

        // Process requirements
        $requirements = null;
        if (!empty($input['requirements'])) {
            $reqArray = array_filter(array_map('trim', explode("\n", $input['requirements'])));
            $requirements = json_encode($reqArray);
        }

        // Build session data
        $sessionData = [
            'provider_id' => $providerId,
            'title' => trim($input['title']),
            'description' => trim($input['description'] ?? ''),
            'session_type' => $input['session_type'] ?? 'group',
            'max_participants' => ($input['session_type'] === 'group') ? (int)($input['max_participants'] ?? 10) : 1,
            'scheduled_date' => $input['scheduled_date'],
            'start_time' => $input['start_time'],
            'end_time' => $input['end_time'],
            'duration' => $duration,
            'price' => (float)$input['price'],
            'currency' => $input['currency'] ?? 'USD',
            'category' => $input['category'],
            'difficulty' => $input['difficulty'] ?? 'all-levels',
            'requirements' => $requirements,
            'thumbnail' => $thumbnail,
            'is_recurring' => isset($input['is_recurring']) ? 1 : 0,
            'recurring_pattern' => $input['recurring_pattern'] ?? null,
            'recurring_days' => isset($input['recurring_days']) ? implode(',', $input['recurring_days']) : null,
            'recurring_end_date' => $input['recurring_end_date'] ?? null,
            'status' => 'scheduled',
            'created_on' => date('Y-m-d H:i:s')
        ];

        // Insert session
        $sessionId = $this->Session_model->create($sessionData);

        if ($sessionId) {
            // Generate ZegoCloud room ID
            $zegoRoomId = $this->zegocloud->generateRoomId($sessionId, $providerId);
            $this->Session_model->update($sessionId, ['zego_room_id' => $zegoRoomId]);

            // Create recurring sessions if enabled
            if ($sessionData['is_recurring'] && !empty($input['recurring_end_date'])) {
                $this->createRecurringSessions($sessionId, $sessionData);
            }

            echo json_encode([
                'status' => 'success',
                'message' => 'Session created successfully!',
                'session_id' => $sessionId,
                'redirect' => base_url('provider/live_session')
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to create session'
            ]);
        }
    }

    /**
     * Edit session page
     */
    public function edit($sessionId)
    {
        $session = $this->Session_model->getByIdAndProvider($sessionId, $this->provider['provider_id']);

        if (!$session) {
            redirect('provider/live_session');
        }

        if (in_array($session->status, ['live', 'completed'])) {
            $this->session->set_flashdata('error', 'Cannot edit a ' . $session->status . ' session');
            redirect('provider/live_session');
        }

        $data['title'] = 'Edit Session';
        $data['session'] = $session;
        $data['categories'] = $this->getCategories();
        $data['participants'] = $this->Session_model->getSessionParticipants($sessionId);
        
        $this->load->view('provider/header', $data);
        $this->load->view('provider/live_session/edit', $data);
        $this->load->view('provider/footer');
    }

    /**
     * Update session (AJAX)
     */
    public function update($sessionId)
    {
        header('Content-Type: application/json');
        
        $session = $this->Session_model->getByIdAndProvider($sessionId, $this->provider['provider_id']);

        if (!$session) {
            echo json_encode(['status' => 'error', 'message' => 'Session not found']);
            return;
        }

        if (in_array($session->status, ['live', 'completed'])) {
            echo json_encode(['status' => 'error', 'message' => 'Cannot update a ' . $session->status . ' session']);
            return;
        }

        $input = $this->input->post();
        $participants = $this->Session_model->getSessionParticipants($sessionId);
        $hasBookings = count($participants) > 0;

        // Calculate duration
        $startTime = strtotime($input['start_time']);
        $endTime = strtotime($input['end_time']);
        $duration = ($endTime - $startTime) / 60;

        if ($duration <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'End time must be after start time']);
            return;
        }

        // Check for conflicts
        $hasConflict = $this->Session_model->hasConflict(
            $this->provider['provider_id'],
            $input['scheduled_date'],
            $input['start_time'],
            $input['end_time'],
            $sessionId
        );

        if ($hasConflict) {
            echo json_encode(['status' => 'error', 'message' => 'Schedule conflict detected']);
            return;
        }

        // Handle thumbnail
        $thumbnail = $session->thumbnail;
        if (!empty($_FILES['thumbnail']['name'])) {
            $config['upload_path'] = './uploads/sessions/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['max_size'] = 2048;
            $config['file_name'] = 'session_' . time() . '_' . rand(1000, 9999);

            if (!is_dir('./uploads/sessions/')) {
                mkdir('./uploads/sessions/', 0755, true);
            }

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('thumbnail')) {
                $uploadData = $this->upload->data();
                $thumbnail = 'uploads/sessions/' . $uploadData['file_name'];
                
                if ($session->thumbnail && file_exists('./' . $session->thumbnail)) {
                    unlink('./' . $session->thumbnail);
                }
            }
        }

        $requirements = null;
        if (!empty($input['requirements'])) {
            $reqArray = array_filter(array_map('trim', explode("\n", $input['requirements'])));
            $requirements = json_encode($reqArray);
        }

        $updateData = [
            'title' => trim($input['title']),
            'description' => trim($input['description'] ?? ''),
            'scheduled_date' => $input['scheduled_date'],
            'start_time' => $input['start_time'],
            'end_time' => $input['end_time'],
            'duration' => $duration,
            'category' => $input['category'],
            'difficulty' => $input['difficulty'] ?? 'all-levels',
            'requirements' => $requirements,
            'thumbnail' => $thumbnail,
            'updated_on' => date('Y-m-d H:i:s')
        ];

        if (!$hasBookings) {
            $updateData['price'] = (float)$input['price'];
            $updateData['session_type'] = $input['session_type'] ?? 'group';
            $updateData['max_participants'] = ($input['session_type'] === 'group') ? (int)($input['max_participants'] ?? 10) : 1;
        }

        $this->Session_model->update($sessionId, $updateData);

        if ($hasBookings) {
            $this->notifySessionUpdate($sessionId, $participants);
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Session updated successfully!'
        ]);
    }

    /**
     * Start session (Go Live)
     */
    public function start($sessionId)
    {
        header('Content-Type: application/json');
        
        $session = $this->Session_model->getByIdAndProvider($sessionId, $this->provider['provider_id']);

        if (!$session) {
            echo json_encode(['status' => 'error', 'message' => 'Session not found']);
            return;
        }

        if ($session->status !== 'scheduled') {
            echo json_encode(['status' => 'error', 'message' => 'Cannot start a ' . $session->status . ' session']);
            return;
        }

        // Check if already have a live session
        $liveSession = $this->Session_model->getLiveSession($this->provider['provider_id']);
        if ($liveSession) {
            echo json_encode([
                'status' => 'error',
                'message' => 'You already have a live session. Please end it first.'
            ]);
            return;
        }

        // Check timing
        $now = time();
        $sessionDateTime = strtotime($session->scheduled_date . ' ' . $session->start_time);
        $earliestStart = $sessionDateTime - (15 * 60);
        $latestStart = $sessionDateTime + (30 * 60);

        if ($now < $earliestStart) {
            $waitMinutes = ceil(($earliestStart - $now) / 60);
            echo json_encode([
                'status' => 'error',
                'message' => "Too early! You can start in {$waitMinutes} minutes."
            ]);
            return;
        }

        if ($now > $latestStart) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Session start time has passed. Please reschedule or cancel.'
            ]);
            return;
        }

        // Generate room ID if not exists
        if (empty($session->zego_room_id)) {
            $zegoRoomId = $this->zegocloud->generateRoomId($sessionId, $this->provider['provider_id']);
            $this->Session_model->update($sessionId, ['zego_room_id' => $zegoRoomId]);
            $session->zego_room_id = $zegoRoomId;
        }

        // Update session status
        $this->Session_model->update($sessionId, [
            'status' => 'live',
            'updated_on' => date('Y-m-d H:i:s')
        ]);

        // Notify booked users
        $participants = $this->Session_model->getSessionParticipants($sessionId);
        foreach ($participants as $participant) {
            $this->sendNotification(
                $sessionId,
                $participant->user_id,
                null,
                'session_started',
                'Session is LIVE!',
                $session->title . ' has started. Join now!'
            );
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Session started! Redirecting to room...',
            'redirect' => base_url('provider/live_session/room/' . $sessionId)
        ]);
    }

    /**
     * Video Room
     */
    public function room($sessionId)
    {
        $session = $this->Session_model->getByIdAndProvider($sessionId, $this->provider['provider_id']);

        if (!$session) {
            $this->session->set_flashdata('error', 'Session not found');
            redirect('provider/live_session');
        }

        if (!in_array($session->status, ['scheduled', 'live'])) {
            $this->session->set_flashdata('error', 'Session is not available');
            redirect('provider/live_session');
        }

        // Generate token for provider
        $providerZegoUserId = 'provider_' . $this->provider['provider_id'];
        $hostToken = $this->zegocloud->generateHostToken(
            $providerZegoUserId,
            $session->zego_room_id,
            $session->duration
        );

        $data['title'] = $session->title . ' - Live Room';
        $data['session'] = $session;
        $data['participants'] = $this->Session_model->getSessionParticipants($sessionId);
        $data['zego_config'] = $this->zegocloud->getClientConfig(
            $hostToken,
            $session->zego_room_id,
            $providerZegoUserId,
            $this->provider['name'] ?? 'Host',
            true
        );

        // Use full page layout for room
        $this->load->view('provider/live_session/room', $data);
    }

    /**
     * End session
     */
    public function end($sessionId)
    {
        header('Content-Type: application/json');
        
        $session = $this->Session_model->getByIdAndProvider($sessionId, $this->provider['provider_id']);

        if (!$session) {
            echo json_encode(['status' => 'error', 'message' => 'Session not found']);
            return;
        }

        if ($session->status !== 'live') {
            echo json_encode(['status' => 'error', 'message' => 'Session is not currently live']);
            return;
        }

        $this->Session_model->update($sessionId, [
            'status' => 'completed',
            'updated_on' => date('Y-m-d H:i:s')
        ]);

        // Calculate earnings
        $participants = $this->Session_model->getSessionParticipants($sessionId);
        $totalEarnings = count($participants) * $session->price;
        $platformCommission = $totalEarnings * 0.15;
        $vendorEarnings = $totalEarnings - $platformCommission;

        // Notify participants
        foreach ($participants as $participant) {
            $this->sendNotification(
                $sessionId,
                $participant->user_id,
                null,
                'session_ended',
                'Session Ended',
                $session->title . ' has ended. Thank you for joining!'
            );
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Session ended successfully!',
            'redirect' => base_url('provider/live_session'),
            'data' => [
                'total_earnings' => number_format($totalEarnings, 2),
                'platform_commission' => number_format($platformCommission, 2),
                'your_earnings' => number_format($vendorEarnings, 2),
                'attendees' => count($participants)
            ]
        ]);
    }

    /**
     * Cancel session
     */
    public function cancel($sessionId)
    {
        header('Content-Type: application/json');
        
        $session = $this->Session_model->getByIdAndProvider($sessionId, $this->provider['provider_id']);

        if (!$session) {
            echo json_encode(['status' => 'error', 'message' => 'Session not found']);
            return;
        }

        if (in_array($session->status, ['completed', 'cancelled', 'live'])) {
            echo json_encode(['status' => 'error', 'message' => 'Cannot cancel this session']);
            return;
        }

        $reason = $this->input->post('reason') ?? 'Cancelled by provider';

        $this->Session_model->update($sessionId, [
            'status' => 'cancelled',
            'cancellation_reason' => $reason,
            'updated_on' => date('Y-m-d H:i:s')
        ]);

        // Notify and process refunds
        $participants = $this->Session_model->getSessionParticipants($sessionId);
        foreach ($participants as $participant) {
            $this->db->where('id', $participant->id);
            $this->db->update('session_bookings', ['payment_status' => 'refunded']);

            $this->sendNotification(
                $sessionId,
                $participant->user_id,
                null,
                'session_cancelled',
                'Session Cancelled',
                $session->title . ' has been cancelled. A refund will be processed.'
            );
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Session cancelled. Refunds will be processed.',
            'redirect' => base_url('provider/live_session')
        ]);
    }

    /**
     * Delete session
     */
    public function delete($sessionId)
    {
        header('Content-Type: application/json');
        
        $session = $this->Session_model->getByIdAndProvider($sessionId, $this->provider['provider_id']);

        if (!$session) {
            echo json_encode(['status' => 'error', 'message' => 'Session not found']);
            return;
        }

        // Only allow deleting scheduled sessions with no bookings
        $participants = $this->Session_model->getSessionParticipants($sessionId);
        
        if (count($participants) > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Cannot delete session with bookings. Cancel it instead.']);
            return;
        }

        if ($session->status !== 'scheduled') {
            echo json_encode(['status' => 'error', 'message' => 'Can only delete scheduled sessions']);
            return;
        }

        // Delete thumbnail
        if ($session->thumbnail && file_exists('./' . $session->thumbnail)) {
            unlink('./' . $session->thumbnail);
        }

        $this->db->delete('sessions', ['id' => $sessionId]);

        echo json_encode([
            'status' => 'success',
            'message' => 'Session deleted successfully!'
        ]);
    }

    /**
     * Get sessions list (AJAX)
     */
    public function get_list()
    {
        header('Content-Type: application/json');
        
        $filters = [
            'status' => $this->input->get('status'),
            'start_date' => $this->input->get('start_date'),
            'end_date' => $this->input->get('end_date'),
            'page' => $this->input->get('page') ?? 1,
            'limit' => $this->input->get('limit') ?? 10
        ];

        $sessions = $this->Session_model->getProviderSessions($this->provider['provider_id'], $filters);
        $total = $this->Session_model->countProviderSessions($this->provider['provider_id'], $filters);

        // Add participant count to each session
        foreach ($sessions as &$session) {
            $session->participants_count = count($this->Session_model->getSessionParticipants($session->id));
        }

        echo json_encode([
            'status' => 'success',
            'data' => [
                'sessions' => $sessions,
                'pagination' => [
                    'current_page' => (int)$filters['page'],
                    'total_pages' => ceil($total / $filters['limit']),
                    'total_items' => $total
                ]
            ]
        ]);
    }

    // Helper methods
    private function getCategories()
    {
        return [
            'yoga' => 'Yoga',
            'fitness' => 'Fitness',
            'meditation' => 'Meditation',
            'cardio' => 'Cardio',
            'strength' => 'Strength Training',
            'dance' => 'Dance',
            'nutrition' => 'Nutrition Coaching',
            'pilates' => 'Pilates',
            'hiit' => 'HIIT',
            'crossfit' => 'CrossFit',
            'other' => 'Other'
        ];
    }

    private function createRecurringSessions($parentId, $sessionData)
    {
        $startDate = new DateTime($sessionData['scheduled_date']);
        $endDate = new DateTime($sessionData['recurring_end_date']);
        $pattern = $sessionData['recurring_pattern'];
        $days = explode(',', $sessionData['recurring_days'] ?? '');

        $currentDate = clone $startDate;
        $currentDate->modify('+1 day');

        while ($currentDate <= $endDate) {
            $shouldCreate = false;

            switch ($pattern) {
                case 'daily':
                    $shouldCreate = true;
                    break;
                case 'weekly':
                    $dayName = strtolower($currentDate->format('l'));
                    $shouldCreate = in_array($dayName, $days);
                    break;
                case 'monthly':
                    $shouldCreate = ($currentDate->format('d') === $startDate->format('d'));
                    break;
            }

            if ($shouldCreate) {
                $newSession = $sessionData;
                $newSession['scheduled_date'] = $currentDate->format('Y-m-d');
                $newSession['parent_session_id'] = $parentId;
                $newSession['is_recurring'] = 0;
                unset($newSession['recurring_pattern'], $newSession['recurring_days'], $newSession['recurring_end_date']);

                $newId = $this->Session_model->create($newSession);
                if ($newId) {
                    $zegoRoomId = $this->zegocloud->generateRoomId($newId, $sessionData['provider_id']);
                    $this->Session_model->update($newId, ['zego_room_id' => $zegoRoomId]);
                }
            }

            $currentDate->modify('+1 day');
        }
    }

    private function sendNotification($sessionId, $userId, $providerId, $type, $title, $message)
    {
        $this->db->insert('session_notifications', [
            'session_id' => $sessionId,
            'user_id' => $userId,
            'provider_id' => $providerId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'created_on' => date('Y-m-d H:i:s')
        ]);
    }

    private function notifySessionUpdate($sessionId, $participants)
    {
        $session = $this->Session_model->getById($sessionId);
        foreach ($participants as $participant) {
            $this->sendNotification(
                $sessionId,
                $participant->user_id,
                null,
                'session_updated',
                'Session Updated',
                'The session "' . $session->title . '" has been updated. Please check the new details.'
            );
        }
    }
}