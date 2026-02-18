<?php
// application/models/Live_session_model.php

defined('BASEPATH') or exit('No direct script access allowed');

class Live_session_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createSession($data)
    {
        $this->db->insert('live_sessions', $data);
        return $this->db->insert_id();
    }
public function getSessionById($session_id, $provider_id = null)
{
    $this->db->from('live_sessions');
    $this->db->where('id', $session_id);

    // Optional: restrict session to logged-in provider
    if (!empty($provider_id)) {
        $this->db->where('provider_id', $provider_id);
    }

    $query = $this->db->get();

    return $query->row_array(); // return single session
}

    public function updateSession($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('live_sessions', $data);
    }

    public function deleteSession($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('live_sessions');
    }

  public function getSession($id)
{
    $this->db->select('
        ls.*,
        u.name AS provider_name,
        u.gym_name,
        u.profile_image
    ');
    $this->db->from('live_sessions ls');
    $this->db->join('users u', 'u.id = ls.provider_id', 'left');
    $this->db->where('ls.id', (int) $id);

    return $this->db->get()->row_array();
}


    public function getSessionByRoomId($room_id)
    {
        $this->db->where('room_id', $room_id);
        return $this->db->get('live_sessions')->row_array();
    }

  public function getProviderSessions($provider_id, $status = null)
{
    $this->db->select('
        ls.*,
        (
            SELECT COUNT(*)
            FROM session_orders so
            WHERE so.session_id = ls.id
              AND so.status = "success"
        ) AS booked_count
    ');

    $this->db->from('live_sessions ls');
    $this->db->where('ls.provider_id', $provider_id);

    if (!empty($status)) {
        $this->db->where('ls.status', $status);
    }

    $this->db->order_by('ls.session_date', 'ASC');
    $this->db->order_by('ls.start_time', 'ASC');

    return $this->db->get()->result_array();
}


    public function getUpcomingSessions($provider_id, $limit = 5)
    {
        $this->db->select('ls.*, 
            (SELECT COUNT(*) FROM session_bookings WHERE session_id = ls.id AND payment_status = "paid") as booked_count');
        $this->db->from('live_sessions ls');
        $this->db->where('ls.provider_id', $provider_id);
        $this->db->where('ls.status', 'scheduled');
        $this->db->where('ls.session_date >=', date('Y-m-d'));
        $this->db->order_by('ls.session_date', 'ASC');
        $this->db->order_by('ls.start_time', 'ASC');
        $this->db->limit($limit);
        
        return $this->db->get()->result_array();
    }

    public function createBooking($data)
    {
        $this->db->insert('session_bookings', $data);
        return $this->db->insert_id();
    }
public function getSessionBookings($session_id)
{
    $this->db->select('
        so.id,
        so.amount,
        so.agora_uid,
        so.created_at,
        u.name AS user_name,
        u.email,
        u.mobile AS phone,
        u.profile_image
    ');

    $this->db->from('session_orders so');
    $this->db->join('users u', 'u.id = so.user_id', 'left');

    $this->db->where('so.session_id', $session_id);
    $this->db->where('so.status', 'success');

    $this->db->order_by('so.created_at', 'DESC');

    return $this->db->get()->result_array();
}


    public function getUserBooking($session_id, $user_id)
    {
        $this->db->where('session_id', $session_id);
        $this->db->where('user_id', $user_id);
        return $this->db->get('session_bookings')->row_array();
    }

    public function updateBooking($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('session_bookings', $data);
    }

    public function updateBookingsAttendance($session_id)
    {
        $this->db->where('session_id', $session_id);
        $this->db->where('attendance_status', 'pending');
        $this->db->where('joined_at IS NOT NULL');
        return $this->db->update('session_bookings', ['attendance_status' => 'attended']);
    }

    public function getAvailableSessions($filters = [])
    {
        $this->db->select('ls.*, p.name as provider_name, p.gym_name, p.profile_image,
            (SELECT COUNT(*) FROM session_bookings WHERE session_id = ls.id AND payment_status = "paid") as booked_count');
        $this->db->from('live_sessions ls');
        $this->db->join('provider p', 'p.id = ls.provider_id', 'left');
        $this->db->where('ls.status', 'scheduled');
        $this->db->where('ls.session_date >=', date('Y-m-d'));
        
        if (!empty($filters['category'])) {
            $this->db->where('ls.category', $filters['category']);
        }
        
        if (!empty($filters['date'])) {
            $this->db->where('ls.session_date', $filters['date']);
        }
        
        if (!empty($filters['price_min'])) {
            $this->db->where('ls.price >=', $filters['price_min']);
        }
        
        if (!empty($filters['price_max'])) {
            $this->db->where('ls.price <=', $filters['price_max']);
        }
        
        $this->db->order_by('ls.session_date', 'ASC');
        $this->db->order_by('ls.start_time', 'ASC');
        
        return $this->db->get()->result_array();
    }

    public function saveMessage($data)
    {
        $this->db->insert('session_messages', $data);
        return $this->db->insert_id();
    }

    public function getSessionMessages($session_id)
    {
        $this->db->where('session_id', $session_id);
        $this->db->order_by('created_at', 'ASC');
        return $this->db->get('session_messages')->result_array();
    }
   public function getPublicSessions()
{
    $this->db->select('
        ls.*,
        u.gym_name,
        p.profile_image
    ');
    $this->db->from('live_sessions ls');

    // Join users table for gym/business name
    $this->db->join('users u', 'u.id = ls.provider_id', 'left');

    // Join providers table for profile image
    $this->db->join('provider p', 'p.provider_id = ls.provider_id', 'left');

    $this->db->where('ls.status', 'scheduled');
    $this->db->where('ls.session_date >=', date('Y-m-d'));
    $this->db->order_by('ls.session_date', 'ASC');
    $this->db->order_by('ls.start_time', 'ASC');

    return $this->db->get()->result_array();
}
public function checkAvailability($session_id)
{
    $session = $this->db->get_where('live_sessions', ['id' => $session_id])->row_array();
    
    if (!$session) {
        return ['available' => false, 'reason' => 'Session not found'];
    }
    
    // Count confirmed bookings
    $booked_count = $this->db->where('session_id', $session_id)
        ->where('status', 'success')
        ->count_all_results('session_orders');
    
    $available_spots = $session['max_participants'] - $booked_count;
    
    return [
        'available' => $available_spots > 0,
        'booked_count' => $booked_count,
        'max_participants' => $session['max_participants'],
        'available_spots' => max(0, $available_spots),
        'is_full' => $available_spots <= 0
    ];
}

public function incrementParticipantCount($session_id)
{
    $this->db->set('current_participants', 'current_participants + 1', FALSE);
    $this->db->where('id', $session_id);
    $this->db->update('live_sessions');
    
    // Check if full
    $session = $this->getSessionById($session_id);
    if ($session['current_participants'] >= $session['max_participants']) {
        $this->db->where('id', $session_id);
        $this->db->update('live_sessions', ['is_full' => 1]);
    }
}

public function decrementParticipantCount($session_id)
{
    $this->db->set('current_participants', 'current_participants - 1', FALSE);
    $this->db->where('id', $session_id);
    $this->db->where('current_participants >', 0);
    $this->db->update('live_sessions');
    
    // Mark as not full
    $this->db->where('id', $session_id);
    $this->db->update('live_sessions', ['is_full' => 0]);
}

// public function getSessionBookings($session_id)
// {
//     return $this->db->select('so.*, u.name as user_name, u.profile_image')
//         ->from('session_orders so')
//         ->join('users u', 'u.id = so.user_id', 'left')
//         ->where('so.session_id', $session_id)
//         ->where('so.status', 'success')
//         ->get()
//         ->result_array();
// }


}