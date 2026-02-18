<?php

require_once __DIR__ . '/AccessToken2.php';
require_once __DIR__ . '/ServiceRtc.php';

class RtcTokenBuilder
{
    const ROLE_PUBLISHER  = 1; // Provider
    const ROLE_SUBSCRIBER = 2; // User

    /**
     * Build RTC Token
     *
     * @param string $appId
     * @param string $appCertificate
     * @param string $channelName
     * @param int|string $uid
     * @param int $role
     * @param int $expireSeconds (e.g. 3600)
     * @return string
     */
    public static function buildTokenWithUid(
        $appId,
        $appCertificate,
        $channelName,
        $uid,
        $role,
        $expireSeconds
    ) {
        // 🔐 Create Access Token (expire = duration in seconds)
        $token = new AccessToken2($appId, $appCertificate, $expireSeconds);

        // ⏰ Privilege expiry MUST be absolute timestamp
        $privilegeExpiredTs = time() + (int)$expireSeconds;

        // 🎥 RTC Service
        $serviceRtc = new ServiceRtc($channelName, (string)$uid);

        // ✅ Join Channel (everyone)
        $serviceRtc->addPrivilege(
            ServiceRtc::PRIVILEGE_JOIN_CHANNEL,
            $privilegeExpiredTs
        );

        // 🎙️📹 Provider only
        if ($role === self::ROLE_PUBLISHER) {

            $serviceRtc->addPrivilege(
                ServiceRtc::PRIVILEGE_PUBLISH_AUDIO_STREAM,
                $privilegeExpiredTs
            );

            $serviceRtc->addPrivilege(
                ServiceRtc::PRIVILEGE_PUBLISH_VIDEO_STREAM,
                $privilegeExpiredTs
            );

            $serviceRtc->addPrivilege(
                ServiceRtc::PRIVILEGE_PUBLISH_DATA_STREAM,
                $privilegeExpiredTs
            );
        }

        // 🔗 Attach service to token
        $token->addService($serviceRtc);

        // 🏗️ Build final token
        return $token->build();
    }
}
