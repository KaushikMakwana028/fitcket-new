<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class Firebase_messaging
{
    protected $CI;
    protected $messaging;

    public function __construct()
    {
        $this->CI =& get_instance();

        require_once FCPATH . 'vendor/autoload.php';

        $factory = (new Factory)
            ->withServiceAccount(APPPATH . 'config/fitcket-8dedb436b309.json');

        $this->messaging = $factory->createMessaging();
    }

    /**
     * ✅ Send push notification and log in DB
     */
    public function send_to_token($fcm_token, $title, $body, $data = [], $provider_id = null)
    {
        try {
            // 🔹 Create notification
            $notification = Notification::create($title, $body);

            // 🔹 Prepare message
            $msg = CloudMessage::withTarget('token', $fcm_token)
                ->withNotification($notification)
                ->withData($data);

            // 🔹 Send via Firebase
            $this->messaging->send($msg);

            // 🔹 Debug log (check in application/logs/)
            log_message('debug', "FCM notification sent to token: $fcm_token, provider_id: $provider_id");

            // 🔹 Insert into notifications table if provider_id exists
            if (!empty($provider_id)) {
                $insert_data = [
                    'provider_id' => $provider_id,
                    'title'       => $title,
                    'message'     => $body,
                    'data'        => json_encode($data),
                    'is_read'     => 0,
                    'created_at'  => date('Y-m-d H:i:s')
                ];

                $this->CI->db->insert('notifications', $insert_data);

                // ✅ Log success or failure of DB insert
                if ($this->CI->db->affected_rows() > 0) {
                    log_message('debug', 'Notification inserted successfully for provider_id: ' . $provider_id);
                } else {
                    log_message('error', 'Failed to insert notification for provider_id: ' . $provider_id);
                }
            }

            return true;

        } catch (\Throwable $e) {
            // 🔹 Log Firebase or DB error
            log_message('error', 'FCM send error: ' . $e->getMessage());
            return false;
        }
    }
}
