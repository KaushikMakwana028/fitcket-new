<?php
// application/libraries/AgoraTokenBuilder.php

defined('BASEPATH') or exit('No direct script access allowed');

class AgoraTokenBuilder
{
    const ROLE_PUBLISHER = 1;
    const ROLE_SUBSCRIBER = 2;
    
    // Privilege constants
    const PRIVILEGE_JOIN_CHANNEL = 1;
    const PRIVILEGE_PUBLISH_AUDIO_STREAM = 2;
    const PRIVILEGE_PUBLISH_VIDEO_STREAM = 3;
    const PRIVILEGE_PUBLISH_DATA_STREAM = 4;
    
    private $appId;
    private $appCertificate;
    private $channelName;
    private $uid;
    private $salt;
    private $ts;
    private $privileges = [];
    
    public function __construct($appId, $appCertificate, $channelName, $uid)
    {
        $this->appId = $appId;
        $this->appCertificate = $appCertificate;
        $this->channelName = $channelName;
        $this->uid = $uid;
        $this->salt = rand(1, 99999999);
        $this->ts = time();
    }
    
    public function addPrivilege($privilege, $expireTimestamp)
    {
        $this->privileges[$privilege] = $expireTimestamp;
        return $this;
    }
    
    public function build()
    {
        // Pack message
        $message = $this->packMessage();
        
        // Generate signature
        $signature = hash_hmac('sha256', $message, $this->appCertificate, true);
        
        // Combine signature and message
        $content = $signature . $this->packUint32($this->salt) . $this->packUint32($this->ts) . $message;
        
        // Encode to base64 and prepend version and app ID
        return "006" . $this->appId . base64_encode($content);
    }
    
    private function packMessage()
    {
        $buffer = '';
        
        // Pack salt
        $buffer .= $this->packUint32($this->salt);
        
        // Pack timestamp
        $buffer .= $this->packUint32($this->ts);
        
        // Pack channel name
        $buffer .= $this->packString($this->channelName);
        
        // Pack uid
        $buffer .= $this->packUint32($this->uid);
        
        // Pack privileges
        $buffer .= $this->packMapUint32($this->privileges);
        
        return $buffer;
    }
    
    private function packUint16($value)
    {
        return pack('v', $value);
    }
    
    private function packUint32($value)
    {
        return pack('V', $value);
    }
    
    private function packString($value)
    {
        return $this->packUint16(strlen($value)) . $value;
    }
    
    private function packMapUint32($map)
    {
        $buffer = $this->packUint16(count($map));
        
        foreach ($map as $key => $value) {
            $buffer .= $this->packUint16($key);
            $buffer .= $this->packUint32($value);
        }
        
        return $buffer;
    }
    
    /**
     * Static method to build RTC token
     */
    public static function buildTokenWithUid($appId, $appCertificate, $channelName, $uid, $role = self::ROLE_PUBLISHER, $privilegeExpireTime = 3600)
    {
        $expireTimestamp = time() + $privilegeExpireTime;
        
        $builder = new self($appId, $appCertificate, $channelName, $uid);
        
        $builder->addPrivilege(self::PRIVILEGE_JOIN_CHANNEL, $expireTimestamp);
        
        if ($role == self::ROLE_PUBLISHER) {
            $builder->addPrivilege(self::PRIVILEGE_PUBLISH_AUDIO_STREAM, $expireTimestamp);
            $builder->addPrivilege(self::PRIVILEGE_PUBLISH_VIDEO_STREAM, $expireTimestamp);
            $builder->addPrivilege(self::PRIVILEGE_PUBLISH_DATA_STREAM, $expireTimestamp);
        }
        
        return $builder->build();
    }
    
    /**
     * Build token with user account (string UID)
     */
    public static function buildTokenWithUserAccount($appId, $appCertificate, $channelName, $userAccount, $role = self::ROLE_PUBLISHER, $privilegeExpireTime = 3600)
    {
        // Convert user account to numeric UID using hash
        $uid = crc32($userAccount) & 0x7FFFFFFF;
        
        return self::buildTokenWithUid($appId, $appCertificate, $channelName, $uid, $role, $privilegeExpireTime);
    }
}