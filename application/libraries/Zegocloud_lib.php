<?php
// application/libraries/Zegocloud_lib.php

defined('BASEPATH') or exit('No direct script access allowed');

class Zegocloud_lib
{
    private $CI;
    private $appID;
    private $serverSecret;
    
    public function __construct()
    {
        $this->CI =& get_instance();
        
        // Load your ZegoCloud credentials from config
        $this->appID = 'YOUR_ZEGO_APP_ID'; // Replace with your App ID
        $this->serverSecret = 'YOUR_ZEGO_SERVER_SECRET'; // Replace with your Server Secret
    }
    
    public function generateToken($roomID, $userID, $userName, $expireTime = 3600)
    {
        $payload = [
            'app_id' => (int)$this->appID,
            'user_id' => (string)$userID,
            'nonce' => rand(100000, 999999),
            'ctime' => time(),
            'expire' => time() + $expireTime,
            'payload' => json_encode([
                'room_id' => $roomID,
                'privilege' => [
                    'can_publish_stream' => true,
                    'can_subscribe_stream' => true
                ],
                'stream_id_list' => null
            ])
        ];
        
        $token = $this->generateToken04($payload);
        
        return $token;
    }
    
    private function generateToken04($payload)
    {
        // Token version
        $version = '04';
        
        // Create the base64 encoded payload
        $payloadJson = json_encode($payload);
        
        // Generate signature
        $nonce = $payload['nonce'];
        $timestamp = $payload['ctime'];
        
        $signature = hash_hmac('sha256', 
            $this->appID . $payload['user_id'] . $timestamp . $nonce . $payloadJson, 
            $this->serverSecret
        );
        
        // Construct token
        $tokenContent = [
            'ver' => 1,
            'hash' => $signature,
            'nonce' => $nonce,
            'expired' => $payload['expire'],
            'payload' => $payloadJson
        ];
        
        $token = $version . base64_encode(json_encode($tokenContent));
        
        return $token;
    }
    
    public function getAppID()
    {
        return $this->appID;
    }
    
    public function getServerSecret()
    {
        return $this->serverSecret;
    }
}