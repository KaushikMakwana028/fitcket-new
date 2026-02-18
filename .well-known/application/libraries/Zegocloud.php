<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Zegocloud {
    
    private $CI;
    private $appId;
    private $serverSecret;
    private $serverUrl;
    
    public function __construct()
    {
        $this->CI =& get_instance();
        
        // Load config - you should store these in a config file
        $this->appId = 'YOUR_ZEGO_APP_ID'; // Replace with your App ID
        $this->serverSecret = 'YOUR_ZEGO_SERVER_SECRET'; // Replace with your Server Secret
        $this->serverUrl = 'wss://webliveroom.zego.im/ws';
    }
    
    /**
     * Get App ID
     */
    public function getAppId()
    {
        return $this->appId;
    }
    
    /**
     * Generate Room ID
     */
    public function generateRoomId($sessionId, $providerId)
    {
        return 'room_' . $providerId . '_' . $sessionId . '_' . time();
    }
    
    /**
     * Generate Token for Zegocloud
     * This uses Zegocloud's token generation algorithm
     */
    public function generateToken($userId, $roomId, $privilege = 1, $expireTime = 3600)
    {
        $appId = (int)$this->appId;
        $serverSecret = $this->serverSecret;
        
        $payload = [
            'app_id' => $appId,
            'user_id' => $userId,
            'nonce' => mt_rand(),
            'ctime' => time(),
            'expire' => time() + $expireTime,
            'payload' => json_encode([
                'room_id' => $roomId,
                'privilege' => [
                    1 => $privilege, // loginRoom
                    2 => $privilege  // publishStream
                ],
                'stream_id_list' => null
            ])
        ];
        
        // Create token
        $token = $this->createToken04($appId, $userId, $serverSecret, $expireTime, json_encode($payload));
        
        return $token;
    }
    
    /**
     * Create Token using Zegocloud's algorithm (Token04)
     */
    private function createToken04($appId, $userId, $secret, $effectiveTimeInSeconds, $payload)
    {
        if (empty($appId) || empty($userId) || empty($secret)) {
            return '';
        }
        
        $createTime = time();
        $expireTime = $createTime + $effectiveTimeInSeconds;
        $nonce = mt_rand();
        
        // Build token info
        $tokenInfo = [
            'ver' => 1,
            'hash' => 'md5',
            'nonce' => $nonce,
            'expired' => $expireTime
        ];
        
        // Encode payload
        $plainText = json_encode([
            'app_id' => $appId,
            'user_id' => $userId,
            'nonce' => $nonce,
            'ctime' => $createTime,
            'expire' => $expireTime,
            'payload' => $payload
        ]);
        
        // Encrypt
        $iv = substr(md5($secret), 0, 16);
        $encrypted = openssl_encrypt($plainText, 'aes-128-cbc', substr($secret, 0, 16), OPENSSL_RAW_DATA, $iv);
        
        // Base64 encode
        $token = '04' . base64_encode($iv . $encrypted);
        
        return $token;
    }
    
    /**
     * Generate Host Token (with full privileges)
     */
    public function generateHostToken($userId, $roomId, $duration = 120)
    {
        $expireTime = ($duration + 30) * 60; // Add 30 min buffer
        return $this->generateToken($userId, $roomId, 1, $expireTime);
    }
    
    /**
     * Generate Participant Token (limited privileges)
     */
    public function generateParticipantToken($userId, $roomId, $duration = 120)
    {
        $expireTime = ($duration + 30) * 60;
        return $this->generateToken($userId, $roomId, 1, $expireTime);
    }
    
    /**
     * Get client configuration for frontend
     */
    public function getClientConfig($token, $roomId, $userId, $userName, $isHost = false)
    {
        return [
            'appID' => (int)$this->appId,
            'token' => $token,
            'roomID' => $roomId,
            'userID' => $userId,
            'userName' => $userName,
            'isHost' => $isHost,
            'serverUrl' => $this->serverUrl
        ];
    }
}