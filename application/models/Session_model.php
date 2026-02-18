<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Session_model extends CI_Model {
    
    private $table = 'sessions';
    private $bookingsTable = 'session_bookings';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Create new session
     */
    public function create($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Update session
     */
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    /**
     * Get session by ID
     */
    public function getById($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }
    
    /**
     * Get session by ID and provider
     */
    public function getByIdAndProvider($id, $providerId)
    {
        return $this->db->get_where($this->table, [
            'id' => $id,
            'provider_id' => $providerId
        ])->row();
    }
    
    /**
     * Get provider sessions with filters
     */
    public function getProviderSessions($providerId, $filters = [])
    {
        $this->db->where('provider_id', $providerId);
        
        if (!empty($filters['status'])) {
            $this->db->where('status', $filters['status']);
        }
        
        if (!empty($filters['start_date'])) {
            $this->db->where('scheduled_date >=', $filters['start_date']);
        }
        
        if (!empty($filters['end_date'])) {
            $this->db->where('scheduled_date <=', $filters['end_date']);
        }
        
        $page = isset($filters['page']) ? (int)$filters['page'] : 1;
        $limit = isset($filters['limit']) ? (int)$filters['limit'] : 10;
        $offset = ($page - 1) * $limit;
        
        $this->db->order_by('scheduled_date', 'DESC');
        $this->db->order_by('start_time', 'DESC');
        $this->db->limit($limit, $offset);
        
        return $this->db->get($this->table)->result();
    }
    
    /**
     * Count provider sessions
     */
    public function countProviderSessions($providerId, $filters = [])
    {
        $this->db->where('provider_id', $providerId);
        
        if (!empty($filters['status'])) {
            $this->db->where('status', $filters['status']);
        }
        
        if (!empty($filters['start_date'])) {
            $this->db->where('scheduled_date >=', $filters['start_date']);
        }
        
        if (!empty($filters['end_date'])) {
            $this->db->where('scheduled_date <=', $filters['end_date']);
        }
        
        return $this->db->count_all_results($this->table);
    }
    
    /**
     * Get today's sessions
     */
    public function getTodaySessions($providerId)
    {
        $today = date('Y-m-d');
        $this->db->where('provider_id', $providerId);
        $this->db->where('scheduled_date', $today);
        $this->db->where_in('status', ['scheduled', 'live']);
        $this->db->order_by('start_time', 'ASC');
        return $this->db->get($this->table)->result();
    }
    
    /**
     * Get upcoming sessions
     */
    public function getUpcomingSessions($providerId, $limit = 5)
    {
        $today = date('Y-m-d');
        $this->db->where('provider_id', $providerId);
        $this->db->where('scheduled_date >=', $today);
        $this->db->where('status', 'scheduled');
        $this->db->order_by('scheduled_date', 'ASC');
        $this->db->order_by('start_time', 'ASC');
        $this->db->limit($limit);
        return $this->db->get($this->table)->result();
    }
    
    /**
     * Check for scheduling conflicts
     */
    public function hasConflict($providerId, $date, $startTime, $endTime, $excludeId = null)
    {
        $this->db->where('provider_id', $providerId);
        $this->db->where('scheduled_date', $date);
        $this->db->where_in('status', ['scheduled', 'live']);
        
        if ($excludeId) {
            $this->db->where('id !=', $excludeId);
        }
        
        // Check for time overlap
        $this->db->group_start();
        $this->db->where("(start_time <= '$startTime' AND end_time > '$startTime')");
        $this->db->or_where("(start_time < '$endTime' AND end_time >= '$endTime')");
        $this->db->or_where("(start_time >= '$startTime' AND end_time <= '$endTime')");
        $this->db->group_end();
        
        return $this->db->count_all_results($this->table) > 0;
    }
    
    /**
     * Get session participants
     */
    public function getSessionParticipants($sessionId)
    {
        $this->db->select('sb.*, u.name as user_name, u.email, u.phone, u.profile_image');
        $this->db->from($this->bookingsTable . ' sb');
        $this->db->join('users u', 'u.id = sb.user_id', 'left');
        $this->db->where('sb.session_id', $sessionId);
        $this->db->where('sb.payment_status', 'paid');
        return $this->db->get()->result();
    }
    
    /**
     * Get dashboard stats
     */
    public function getDashboardStats($providerId)
    {
        $today = date('Y-m-d');
        $thisMonth = date('Y-m');
        
        // Total sessions
        $totalSessions = $this->db->where('provider_id', $providerId)
                                   ->count_all_results($this->table);
        
        // Upcoming sessions
        $this->db->where('provider_id', $providerId);
        $this->db->where('scheduled_date >=', $today);
        $this->db->where('status', 'scheduled');
        $upcomingSessions = $this->db->count_all_results($this->table);
        
        // Completed sessions
        $this->db->where('provider_id', $providerId);
        $this->db->where('status', 'completed');
        $completedSessions = $this->db->count_all_results($this->table);
        
        // Today's sessions
        $this->db->where('provider_id', $providerId);
        $this->db->where('scheduled_date', $today);
        $todaySessions = $this->db->count_all_results($this->table);
        
        // Total earnings (this month)
        $this->db->select('SUM(sb.payment_amount) as total');
        $this->db->from($this->bookingsTable . ' sb');
        $this->db->join($this->table . ' s', 's.id = sb.session_id');
        $this->db->where('s.provider_id', $providerId);
        $this->db->where('sb.payment_status', 'paid');
        $this->db->like('sb.booking_date', $thisMonth, 'after');
        $earnings = $this->db->get()->row();
        
        // Total participants
        $this->db->select('COUNT(DISTINCT sb.user_id) as total');
        $this->db->from($this->bookingsTable . ' sb');
        $this->db->join($this->table . ' s', 's.id = sb.session_id');
        $this->db->where('s.provider_id', $providerId);
        $participants = $this->db->get()->row();
        
        return [
            'total_sessions' => $totalSessions,
            'upcoming_sessions' => $upcomingSessions,
            'completed_sessions' => $completedSessions,
            'today_sessions' => $todaySessions,
            'monthly_earnings' => $earnings->total ?? 0,
            'total_participants' => $participants->total ?? 0
        ];
    }
    
    /**
     * Get live session
     */
    public function getLiveSession($providerId)
    {
        return $this->db->get_where($this->table, [
            'provider_id' => $providerId,
            'status' => 'live'
        ])->row();
    }
}