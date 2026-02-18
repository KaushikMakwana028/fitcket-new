<?php
// application/libraries/Agora_lib.php

defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'libraries/RtcTokenBuilder.php');

class Agora_lib
{
    private $CI;
    private $appID;
    private $appCertificate;
    
    const ROLE_PUBLISHER = 1;
    const ROLE_SUBSCRIBER = 2;
    
    public function __construct()
    {
        $this->CI =& get_instance();
        
        // Load configuration
        $this->CI->config->load('agora', TRUE);
        
        $this->appID = $this->CI->config->item('app_id', 'agora') ?: '18a48eeaec0d40908a5e7c045e9ad2f7';
        $this->appCertificate = $this->CI->config->item('app_certificate', 'agora') ?: '7b0c56e5edc64eb099f0e6708b645b60';
    }
    
    /**
     * Generate RTC Token for video calls
     */
  public function generateToken($channelName, $uid, $role = self::ROLE_PUBLISHER, $expireTime = 3600)
{
    return RtcTokenBuilder::buildTokenWithUid(
        $this->appID,
        $this->appCertificate,
        $channelName,
        (string)$uid,
        $role,
        $expireTime   // ✅ PASS DURATION ONLY
    );
}


    /**
     * Generate token using user account (string)
     */
    public function generateTokenWithAccount($channelName, $userAccount, $role = self::ROLE_PUBLISHER, $expireTime = 3600)
    {
        return RtcTokenBuilder::buildTokenWithUserAccount(
            $this->appID,
            $this->appCertificate,
            $channelName,
            $userAccount,
            $role,
            $expireTime
        );
    }
    
    public function getAppID()
    {
        return $this->appID;
    }
}