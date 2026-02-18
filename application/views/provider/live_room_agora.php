<!-- application/views/provider/live_room_agora.php -->
<style>
.live-header {
    position: sticky;
    top: 0;
    z-index: 100;
}

.live-indicator {
    background: #dc3545;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
}

.timer {
    font-family: 'Courier New', monospace;
    font-size: 1.2rem;
    background: rgba(255,255,255,0.1);
    padding: 5px 15px;
    border-radius: 5px;
}

.connection-status {
    font-size: 14px;
    padding: 5px 10px;
    border-radius: 5px;
    background: rgba(255,255,255,0.1);
}

.connection-status.connected {
    background: rgba(40, 167, 69, 0.3);
}

.connection-status.disconnected {
    background: rgba(220, 53, 69, 0.3);
}

.video-container {
    background: #1a1a1a;
    min-height: calc(100vh - 120px);
    position: relative;
    padding: 20px;
}

.local-video-wrapper {
    position: relative;
    width: 100%;
    height: calc(100vh - 200px);
    background: #000;
    border-radius: 12px;
    overflow: hidden;
}

#localVideo {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

#localVideo video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.video-placeholder {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: #666;
}

.video-placeholder i {
    font-size: 64px;
}

.video-info {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 10;
}

.user-label {
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 14px;
}

.video-controls {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 10px;
    background: rgba(0,0,0,0.7);
    padding: 15px 30px;
    border-radius: 50px;
    z-index: 10;
}

.control-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: none;
    background: rgba(255,255,255,0.2);
    color: white;
    font-size: 24px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.control-btn:hover {
    background: rgba(255,255,255,0.3);
    transform: scale(1.1);
}

.control-btn.muted, .control-btn.off {
    background: #dc3545;
}

.control-btn.active {
    background: #28a745;
}

.remote-videos-grid {
    position: absolute;
    top: 20px;
    right: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: calc(100vh - 240px);
    overflow-y: auto;
}

.remote-video-box {
    width: 200px;
    height: 150px;
    background: #333;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    border: 2px solid transparent;
    transition: border-color 0.3s;
}

.remote-video-box.speaking {
    border-color: #28a745;
}

.remote-player {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
}

.remote-player video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.remote-video-box video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.remote-video-box .user-name {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    color: white;
    padding: 10px 8px 5px;
    text-align: center;
    font-size: 12px;
    z-index: 5;
}

.remote-video-box .user-indicators {
    position: absolute;
    top: 5px;
    right: 5px;
    display: flex;
    gap: 5px;
    z-index: 5;
}

.remote-video-box .user-indicators i {
    font-size: 16px;
    padding: 3px;
    border-radius: 3px;
    background: rgba(0,0,0,0.5);
}

.remote-video-placeholder {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #888;
    background: #222;
    z-index: 2;
}

.remote-video-placeholder i {
    font-size: 48px;
    margin-bottom: 5px;
}

.remote-video-placeholder p {
    font-size: 12px;
    margin: 0;
}

.live-sidebar {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 120px);
    border-left: 1px solid #dee2e6;
}

.live-sidebar .nav-tabs {
    flex-shrink: 0;
    border-bottom: 1px solid #dee2e6;
}

.live-sidebar .nav-tabs .nav-link {
    border: none;
    border-radius: 0;
    padding: 15px 20px;
    color: #666;
}

.live-sidebar .nav-tabs .nav-link.active {
    color: #007bff;
    border-bottom: 2px solid #007bff;
    background: transparent;
}

.live-sidebar .tab-content {
    flex-grow: 1;
    overflow: hidden;
}

.live-sidebar .tab-pane {
    height: 100%;
}

.participants-list {
    height: 100%;
    overflow-y: auto;
}

.participant-item {
    transition: background-color 0.3s;
}

.participant-item:hover {
    background-color: #e9ecef !important;
}

.participant-indicators i {
    margin-left: 5px;
    font-size: 18px;
}

.participant-indicators i.muted {
    color: #dc3545 !important;
}

.chat-container {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.chat-messages {
    flex-grow: 1;
    overflow-y: auto;
    background: #f8f9fa;
}

.chat-input {
    flex-shrink: 0;
    background: white;
}

.chat-message {
    margin-bottom: 10px;
    padding: 10px 12px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
    max-width: 90%;
}

.chat-message.own {
    background: #007bff;
    color: white;
    margin-left: auto;
}

.chat-message.own .sender {
    color: rgba(255,255,255,0.8);
}

.chat-message.own .time {
    color: rgba(255,255,255,0.6);
}

.chat-message.system {
    background: #fff3cd;
    text-align: center;
    font-size: 12px;
    color: #856404;
    max-width: 100%;
}

.chat-message .sender {
    font-weight: 600;
    font-size: 12px;
    color: #007bff;
    margin-bottom: 3px;
}

.chat-message .text {
    word-break: break-word;
}

.chat-message .time {
    font-size: 10px;
    color: #999;
    text-align: right;
    margin-top: 5px;
}

/* Sidebar handle for mobile (hidden on desktop) */
.sidebar-handle {
    display: none;
}

/* Mobile Responsive Styles */
@media (max-width: 991px) {
    .live-header {
        padding: 10px !important;
    }
    
    .live-header .d-flex {
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .live-header h5 {
        font-size: 14px;
    }
    
    .timer {
        font-size: 0.9rem;
        padding: 3px 10px;
    }
    
    .participants-count, .connection-status {
        font-size: 12px;
        padding: 3px 8px;
    }
    
    .video-container {
        padding: 10px;
        min-height: calc(100vh - 140px);
    }
    
    .local-video-wrapper {
        height: calc(100vh - 220px);
    }
    
    .video-controls {
        bottom: 10px;
        padding: 10px 20px;
        gap: 8px;
        flex-wrap: wrap;
        max-width: 95%;
    }
    
    .control-btn {
        width: 45px;
        height: 45px;
        font-size: 20px;
    }
    
    .remote-videos-grid {
        top: 10px;
        right: 10px;
        max-height: calc(100vh - 260px);
        max-width: calc(100vw - 20px);
        flex-direction: row;
        flex-wrap: wrap;
        overflow-x: auto;
    }
    
    .remote-video-box {
        width: 120px;
        height: 90px;
    }
    
    .remote-video-box .user-name {
        font-size: 10px;
        padding: 5px 4px 2px;
    }
    
    .remote-video-box .user-indicators i {
        font-size: 12px;
    }
    
    /* Sidebar as bottom sheet on mobile */
    .live-sidebar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50vh;
        max-height: 400px;
        z-index: 1000;
        border-top: 2px solid #dee2e6;
        border-left: none;
        transition: transform 0.3s ease;
        box-shadow: 0 -4px 6px rgba(0,0,0,0.1);
    }
    
    .live-sidebar.minimized {
        transform: translateY(calc(100% - 50px));
    }
    
    .sidebar-handle {
        display: flex;
        justify-content: center;
        padding: 10px;
        background: #f8f9fa;
        cursor: pointer;
        border-bottom: 1px solid #dee2e6;
    }
    
    .sidebar-handle::before {
        content: '';
        width: 40px;
        height: 4px;
        background: #ccc;
        border-radius: 2px;
    }
    
    .live-sidebar .nav-tabs .nav-link {
        padding: 10px 15px;
        font-size: 14px;
    }
    
    .participants-list, .chat-messages {
        font-size: 14px;
    }
    
    .participant-item img {
        width: 32px !important;
        height: 32px !important;
    }
    
    .participant-item h6 {
        font-size: 14px;
    }
}

@media (max-width: 576px) {
    .live-header h5 {
        width: 100%;
        order: 1;
        margin-bottom: 10px;
    }
    
    .live-indicator {
        font-size: 11px;
        padding: 4px 10px;
    }
    
    .control-btn {
        width: 40px;
        height: 40px;
        font-size: 18px;
    }
    
    .remote-video-box {
        width: 100px;
        height: 75px;
    }
    
    .video-controls {
        padding: 8px 15px;
        gap: 6px;
    }
}

/* Fullscreen mode */
.fullscreen-mode {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9999;
    background: #000;
}

.fullscreen-mode .local-video-wrapper {
    height: 100vh;
    border-radius: 0;
}

.fullscreen-mode .video-controls {
    bottom: 30px;
}

.fullscreen-mode .remote-videos-grid {
    top: 20px;
}
</style>


<div class="page-wrapper">
    <div class="page-content p-0">
        <!-- Live Session Header -->
        <div class="live-header bg-dark text-white p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <span class="live-indicator me-3">
                        <i class="bx bx-broadcast"></i> LIVE
                    </span>
                    <h5 class="mb-0"><?= htmlspecialchars($session['title']) ?></h5>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="timer" id="sessionTimerLive">00:00:00</span>
                    <span class="participants-count">
                        <i class="bx bx-user"></i> <span id="participantCount">1</span>
                    </span>
                    <span class="connection-status" id="connectionStatus">
                        <i class="bx bx-wifi"></i> Connecting...
                    </span>
                    <button class="btn btn-danger btn-sm" onclick="endSession()">
                        <i class="bx bx-stop"></i> End Session
                    </button>
                </div>
            </div>
        </div>

        <div class="live-container">
            <div class="row g-0">
                <!-- Main Video Area -->
                <div class="col-lg-9">
                    <div class="video-container" id="videoContainer">
                        <!-- Local Video (Provider) -->
                        <div class="local-video-wrapper">
                            <div id="localVideo" class="video-box">
                                <div class="video-placeholder" id="localVideoPlaceholder">
                                    <i class="bx bx-video-off"></i>
                                    <p>Camera Off</p>
                                </div>
                            </div>
                            <div class="video-info">
                                <span class="user-label"><?= htmlspecialchars($user_name) ?> (You - Host)</span>
                            </div>
                            <div class="video-controls">
                                <button class="control-btn" id="toggleMic" onclick="toggleMicrophone()" title="Toggle Microphone">
                                    <i class="bx bx-microphone"></i>
                                </button>
                                <button class="control-btn" id="toggleCamera" onclick="toggleCamera()" title="Toggle Camera">
                                    <i class="bx bx-video"></i>
                                </button>
                                <button class="control-btn" id="switchCamera" onclick="switchCamera()" title="Switch Camera">
                                    <i class="bx bx-camera"></i>
                                </button>
                                <button class="control-btn" id="toggleScreen" onclick="toggleScreenShare()" title="Share Screen">
                                    <i class="bx bx-desktop"></i>
                                </button>
                                <button class="control-btn" id="toggleFullscreen" onclick="toggleFullscreen()" title="Fullscreen">
                                    <i class="bx bx-fullscreen"></i>
                                </button>
                                <button class="control-btn" id="toggleSettings" onclick="openSettings()" title="Settings">
                                    <i class="bx bx-cog"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remote Videos Grid -->
                        <div id="remoteVideosContainer" class="remote-videos-grid">
                            <!-- Remote videos will be added here dynamically -->
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-3">
                    <div class="live-sidebar bg-white h-100" id="liveSidebar">
                        <!-- Handle for mobile drag -->
                        <div class="sidebar-handle" onclick="toggleSidebar()"></div>
                        
                        <!-- Tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#participantsTab">
                                    <i class="bx bx-user"></i> Participants
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#chatTab">
                                    <i class="bx bx-chat"></i> Chat
                                    <span class="badge bg-danger ms-1" id="unreadBadge" style="display:none;">0</span>
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <!-- Participants Tab -->
                            <div class="tab-pane fade show active" id="participantsTab">
                                <div class="participants-list p-3" id="participantsList">
                                    <h6 class="text-muted mb-3">Registered Participants</h6>

                                    <?php if (!empty($participants)): ?>
                                        <?php foreach ($participants as $p): ?>
                                            <div class="participant-item d-flex align-items-center p-2 mb-2 rounded bg-light"
                                                 data-user-id="<?= $p['agora_uid'] ?>">
                                                <img src="<?= !empty($p['profile_image'])
                                                    ? base_url($p['profile_image'])
                                                    : base_url('assets/images/default-user.png') ?>"
                                                    class="rounded-circle me-2" width="40" height="40">
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0"><?= htmlspecialchars($p['user_name']) ?></h6>
                                                    <small class="text-muted status-text">Waiting to join...</small>
                                                </div>
                                                <div class="participant-indicators">
                                                    <i class="bx bx-microphone-off text-muted" id="sidebar_mic_<?= $p['agora_uid'] ?>"></i>
                                                    <i class="bx bx-video-off text-muted" id="sidebar_cam_<?= $p['agora_uid'] ?>"></i>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="text-center text-muted py-4">
                                            <i class="bx bx-user-x" style="font-size: 48px;"></i>
                                            <p>No registered participants yet</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Chat Tab -->
                            <div class="tab-pane fade" id="chatTab">
                                <div class="chat-container">
                                    <div class="chat-messages p-3" id="chatMessages">
                                        <div class="chat-welcome text-center text-muted py-4">
                                            <i class="bx bx-message-dots" style="font-size: 48px;"></i>
                                            <p>Chat messages will appear here</p>
                                        </div>
                                    </div>
                                    <div class="chat-input p-3 border-top">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="messageInput"
                                                   placeholder="Type a message..." maxlength="500">
                                            <button class="btn btn-primary" onclick="sendMessage()">
                                                <i class="bx bx-send"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Settings Modal -->
<div class="modal fade" id="settingsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bx bx-cog me-2"></i>Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Camera</label>
                    <select class="form-select" id="cameraSelect"></select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Microphone</label>
                    <select class="form-select" id="microphoneSelect"></select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Speaker</label>
                    <select class="form-select" id="speakerSelect"></select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Video Quality</label>
                    <select class="form-select" id="qualitySelect">
                        <option value="360p">360p (Low)</option>
                        <option value="480p">480p (Medium)</option>
                        <option value="720p" selected>720p (HD)</option>
                        <option value="1080p">1080p (Full HD)</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="applySettings()">Apply</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script src="https://download.agora.io/sdk/release/AgoraRTC_N-4.20.0.js"></script>

<script>
/* =====================================
   AGORA CONFIG
===================================== */
const APP_ID  = "<?= $app_id ?>";
const TOKEN   = "<?= $token ?>";
const CHANNEL = "<?= $channel ?>";
const UID     = <?= $uid ?>;

/* =====================================
   GLOBAL STATE
===================================== */
let client = null;

let localTracks = {
    audioTrack: null,
    videoTrack: null,
    screenTrack: null
};

let remoteUsers = {};
let isScreenSharing = false;
let micEnabled = true;
let cameraEnabled = true;
let isFullscreen = false;
let availableCameras = [];
let currentCameraIndex = 0;

/* =====================================
   SESSION TIMER
===================================== */
let sessionSeconds = 0;
let sessionTimerInterval = null;

function startSessionTimer() {
    const timerEl = document.getElementById('sessionTimerLive');
    
    if (sessionTimerInterval) {
        clearInterval(sessionTimerInterval);
    }

    sessionTimerInterval = setInterval(() => {
        sessionSeconds++;
        const h = String(Math.floor(sessionSeconds / 3600)).padStart(2, '0');
        const m = String(Math.floor((sessionSeconds % 3600) / 60)).padStart(2, '0');
        const s = String(sessionSeconds % 60).padStart(2, '0');
        timerEl.textContent = `${h}:${m}:${s}`;
    }, 1000);
}

/* =====================================
   MOBILE SIDEBAR TOGGLE
===================================== */
function toggleSidebar() {
    const sidebar = document.getElementById('liveSidebar');
    sidebar.classList.toggle('minimized');
}

/* =====================================
   FULLSCREEN TOGGLE
===================================== */
function toggleFullscreen() {
    const videoContainer = document.getElementById('videoContainer');
    const btn = document.getElementById('toggleFullscreen');
    const icon = btn.querySelector('i');
    
    if (!isFullscreen) {
        // Enter fullscreen
        if (videoContainer.requestFullscreen) {
            videoContainer.requestFullscreen();
        } else if (videoContainer.webkitRequestFullscreen) {
            videoContainer.webkitRequestFullscreen();
        } else if (videoContainer.msRequestFullscreen) {
            videoContainer.msRequestFullscreen();
        }
        
        videoContainer.classList.add('fullscreen-mode');
        icon.className = 'bx bx-exit-fullscreen';
        isFullscreen = true;
    } else {
        // Exit fullscreen
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
        
        videoContainer.classList.remove('fullscreen-mode');
        icon.className = 'bx bx-fullscreen';
        isFullscreen = false;
    }
}

// Listen for fullscreen changes
document.addEventListener('fullscreenchange', handleFullscreenChange);
document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
document.addEventListener('msfullscreenchange', handleFullscreenChange);

function handleFullscreenChange() {
    const videoContainer = document.getElementById('videoContainer');
    const btn = document.getElementById('toggleFullscreen');
    const icon = btn.querySelector('i');
    
    if (!document.fullscreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
        videoContainer.classList.remove('fullscreen-mode');
        icon.className = 'bx bx-fullscreen';
        isFullscreen = false;
    }
}

/* =====================================
   CAMERA SWITCHING
===================================== */
async function switchCamera() {
    if (!localTracks.videoTrack || availableCameras.length <= 1) {
        console.log('[Camera] No additional cameras available');
        return;
    }
    
    try {
        // Get next camera
        currentCameraIndex = (currentCameraIndex + 1) % availableCameras.length;
        const nextCamera = availableCameras[currentCameraIndex];
        
        console.log('[Camera] Switching to:', nextCamera.label);
        
        // Switch to the new camera
        await localTracks.videoTrack.setDevice(nextCamera.deviceId);
        
        // Visual feedback
        const btn = document.getElementById('switchCamera');
        btn.classList.add('active');
        setTimeout(() => btn.classList.remove('active'), 500);
        
    } catch (err) {
        console.error('[Camera] Switch error:', err);
        alert('Failed to switch camera: ' + err.message);
    }
}

/* =====================================
   GET AVAILABLE CAMERAS
===================================== */
async function getAvailableCameras() {
    try {
        const devices = await AgoraRTC.getDevices();
        availableCameras = devices.filter(device => device.kind === 'videoinput');
        
        console.log('[Camera] Found cameras:', availableCameras.length);
        
        // Hide switch button if only one camera
        const switchBtn = document.getElementById('switchCamera');
        if (availableCameras.length <= 1) {
            switchBtn.style.display = 'none';
        }
    } catch (err) {
        console.error('[Camera] Failed to get devices:', err);
    }
}

/* =====================================
   PARTICIPANT UI HELPERS
===================================== */
function markParticipantJoined(uid) {
    uid = String(uid);
    const el = document.querySelector(`.participant-item[data-user-id="${uid}"]`);
    if (!el) {
        console.log('[Participant] No sidebar element for UID:', uid);
        return;
    }

    el.classList.remove('bg-light');
    el.classList.add('bg-success-subtle');

    const status = el.querySelector('.status-text');
    if (status) {
        status.textContent = 'Connected';
        status.classList.remove('text-muted', 'text-danger');
        status.classList.add('text-success');
    }
    
    console.log('[Participant] Marked joined:', uid);
}

function markParticipantLeft(uid) {
    uid = String(uid);
    const el = document.querySelector(`.participant-item[data-user-id="${uid}"]`);
    if (!el) return;

    el.classList.remove('bg-success-subtle');
    el.classList.add('bg-light');

    const status = el.querySelector('.status-text');
    if (status) {
        status.textContent = 'Disconnected';
        status.classList.remove('text-success');
        status.classList.add('text-danger');
    }
    
    // Reset indicators
    updateSidebarIndicators(uid, false, false);
}

function updateSidebarIndicators(uid, hasAudio, hasVideo) {
    uid = String(uid);
    
    const micIcon = document.getElementById(`sidebar_mic_${uid}`);
    const camIcon = document.getElementById(`sidebar_cam_${uid}`);
    
    if (micIcon) {
        if (hasAudio) {
            micIcon.className = 'bx bx-microphone text-success';
        } else {
            micIcon.className = 'bx bx-microphone-off text-danger';
        }
    }
    
    if (camIcon) {
        if (hasVideo) {
            camIcon.className = 'bx bx-video text-success';
        } else {
            camIcon.className = 'bx bx-video-off text-danger';
        }
    }
}

function updateParticipantCount() {
    const el = document.getElementById('participantCount');
    if (el) {
        el.textContent = Object.keys(remoteUsers).length + 1;
    }
}

/* =====================================
   VIDEO HELPERS
===================================== */
function addRemoteVideo(user) {
    const container = document.getElementById('remoteVideosContainer');
    if (!container) {
        console.error('[Video] Remote container not found!');
        return;
    }

    console.log('[Video] Adding remote video for UID:', user.uid);

    let box = document.getElementById(`remote_${user.uid}`);
    
    if (box) {
        const placeholder = box.querySelector('.remote-video-placeholder');
        const player = box.querySelector('.remote-player');
        
        if (user.videoTrack) {
            if (placeholder) placeholder.style.display = 'none';
            user.videoTrack.play(player.id);
            console.log('[Video] Playing video in existing player:', player.id);
        }
        return;
    }

    const participantEl = document.querySelector(`.participant-item[data-user-id="${user.uid}"]`);
    const userName = participantEl 
        ? participantEl.querySelector('h6').textContent 
        : `User ${user.uid}`;

    box = document.createElement('div');
    box.id = `remote_${user.uid}`;
    box.className = 'remote-video-box';

    const player = document.createElement('div');
    player.id = `player_${user.uid}`;
    player.className = 'remote-player';

    const placeholder = document.createElement('div');
    placeholder.className = 'remote-video-placeholder';
    placeholder.innerHTML = `
        <i class="bx bx-video-off"></i>
        <p>Camera Off</p>
    `;
    placeholder.style.display = 'none';

    const nameLabel = document.createElement('div');
    nameLabel.className = 'user-name';
    nameLabel.textContent = userName;

    const indicators = document.createElement('div');
    indicators.className = 'user-indicators';
    indicators.innerHTML = `
        <i class="bx bx-microphone text-success" id="vid_mic_${user.uid}"></i>
        <i class="bx bx-video text-success" id="vid_cam_${user.uid}"></i>
    `;

    box.appendChild(placeholder);
    box.appendChild(player);
    box.appendChild(nameLabel);
    box.appendChild(indicators);
    container.appendChild(box);

    if (user.videoTrack) {
        console.log('[Video] Playing video track in:', player.id);
        user.videoTrack.play(player.id);
        updateVideoIndicator(user.uid, true);
    } else {
        console.log('[Video] No video track, showing placeholder');
        placeholder.style.display = 'flex';
        updateVideoIndicator(user.uid, false);
    }
}

function updateVideoIndicator(uid, hasVideo) {
    uid = String(uid);
    
    const vidCamIcon = document.getElementById(`vid_cam_${uid}`);
    if (vidCamIcon) {
        vidCamIcon.className = hasVideo 
            ? 'bx bx-video text-success' 
            : 'bx bx-video-off text-danger';
    }
    
    const sidebarCamIcon = document.getElementById(`sidebar_cam_${uid}`);
    if (sidebarCamIcon) {
        sidebarCamIcon.className = hasVideo 
            ? 'bx bx-video text-success' 
            : 'bx bx-video-off text-danger';
    }
    
    const placeholder = document.querySelector(`#remote_${uid} .remote-video-placeholder`);
    if (placeholder) {
        placeholder.style.display = hasVideo ? 'none' : 'flex';
    }
}

function updateAudioIndicator(uid, hasAudio) {
    uid = String(uid);
    
    const vidMicIcon = document.getElementById(`vid_mic_${uid}`);
    if (vidMicIcon) {
        vidMicIcon.className = hasAudio 
            ? 'bx bx-microphone text-success' 
            : 'bx bx-microphone-off text-danger';
    }
    
    const sidebarMicIcon = document.getElementById(`sidebar_mic_${uid}`);
    if (sidebarMicIcon) {
        sidebarMicIcon.className = hasAudio 
            ? 'bx bx-microphone text-success' 
            : 'bx bx-microphone-off text-danger';
    }
}

function removeRemoteVideo(uid) {
    const el = document.getElementById(`remote_${uid}`);
    if (el) {
        el.remove();
        console.log('[Video] Removed remote video for UID:', uid);
    }
}

/* =====================================
   CONNECTION STATUS
===================================== */
function updateConnectionStatus(state) {
    const el = document.getElementById('connectionStatus');
    if (!el) return;

    el.classList.remove('connected', 'disconnected');

    if (state === 'CONNECTED') {
        el.innerHTML = '<i class="bx bx-wifi"></i> Connected';
        el.classList.add('connected');
    } else if (state === 'CONNECTING') {
        el.innerHTML = '<i class="bx bx-wifi"></i> Connecting...';
    } else {
        el.innerHTML = '<i class="bx bx-wifi-off"></i> Disconnected';
        el.classList.add('disconnected');
    }
}

/* =====================================
   AGORA EVENTS
===================================== */
function setupEventHandlers() {
    
    client.on('user-joined', (user) => {
        console.log('[Agora] User joined channel:', user.uid);
        remoteUsers[user.uid] = user;
        markParticipantJoined(user.uid);
        updateParticipantCount();
    });

    client.on('user-published', async (user, mediaType) => {
        console.log('[Agora] User published:', user.uid, mediaType);

        try {
            await client.subscribe(user, mediaType);
            console.log('[Agora] Subscribed to:', user.uid, mediaType);
            
            remoteUsers[user.uid] = user;

            if (mediaType === 'video') {
                console.log('[Agora] Video track received, adding remote video');
                addRemoteVideo(user);
                updateVideoIndicator(user.uid, true);
            }

            if (mediaType === 'audio') {
                console.log('[Agora] Audio track received, playing audio');
                if (user.audioTrack) {
                    user.audioTrack.play();
                    console.log('[Agora] Audio playing for UID:', user.uid);
                }
                updateAudioIndicator(user.uid, true);
            }
        } catch (err) {
            console.error('[Agora] Subscribe error:', err);
        }
    });

    client.on('user-unpublished', (user, mediaType) => {
        console.log('[Agora] User unpublished:', user.uid, mediaType);
        
        if (mediaType === 'video') {
            updateVideoIndicator(user.uid, false);
        }

        if (mediaType === 'audio') {
            updateAudioIndicator(user.uid, false);
        }
    });

    client.on('user-left', (user) => {
        console.log('[Agora] User left:', user.uid);
        delete remoteUsers[user.uid];
        removeRemoteVideo(user.uid);
        markParticipantLeft(user.uid);
        updateParticipantCount();
    });

    client.on('connection-state-change', (curState, prevState) => {
        console.log('[Agora] Connection state:', prevState, '->', curState);
        updateConnectionStatus(curState);
    });
    
    client.on('exception', (event) => {
        console.error('[Agora] Exception:', event);
    });
}

/* =====================================
   START LIVE SESSION (HOST)
===================================== */
async function startLiveSession() {
    try {
        updateConnectionStatus('CONNECTING');
        console.log('[Init] Starting live session...');

        client = AgoraRTC.createClient({
            mode: 'rtc',
            codec: 'vp8'
        });

        setupEventHandlers();

        await client.join(APP_ID, CHANNEL, TOKEN, UID);
        console.log('[Init] Joined channel successfully');

        // Get available cameras
        await getAvailableCameras();

        // Create audio track
        try {
            localTracks.audioTrack = await AgoraRTC.createMicrophoneAudioTrack();
            console.log('[Init] Audio track created');
        } catch (err) {
            console.error('[Init] Failed to create audio track:', err);
            alert('Microphone access denied. Audio will not be available.');
        }
        
        // Create video track (try back camera first on mobile)
        try {
            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            const cameraConfig = {
                encoderConfig: "720p_2"
            };
            
            // Try to use back camera on mobile
            if (isMobile && availableCameras.length > 0) {
                const backCamera = availableCameras.find(cam => 
                    cam.label.toLowerCase().includes('back') || 
                    cam.label.toLowerCase().includes('rear')
                );
                
                if (backCamera) {
                    cameraConfig.cameraId = backCamera.deviceId;
                    currentCameraIndex = availableCameras.indexOf(backCamera);
                    console.log('[Init] Using back camera:', backCamera.label);
                }
            }
            
            localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack(cameraConfig);
            console.log('[Init] Video track created');
            
            localTracks.videoTrack.play('localVideo');
            document.getElementById('localVideoPlaceholder').style.display = 'none';
        } catch (err) {
            console.error('[Init] Failed to create video track:', err);
            alert('Camera access denied. Video will not be available.');
        }

        // Publish tracks
        const tracksToPublish = [];
        if (localTracks.audioTrack) tracksToPublish.push(localTracks.audioTrack);
        if (localTracks.videoTrack) tracksToPublish.push(localTracks.videoTrack);
        
        if (tracksToPublish.length > 0) {
            await client.publish(tracksToPublish);
            console.log('[Init] Published tracks:', tracksToPublish.length);
        }

        updateConnectionStatus('CONNECTED');
        updateParticipantCount();
        startSessionTimer();

        await populateDeviceSelects();
        
        for (const user of client.remoteUsers) {
            console.log('[Init] Found existing user:', user.uid);
            remoteUsers[user.uid] = user;
            markParticipantJoined(user.uid);
            
            if (user.hasVideo) {
                await client.subscribe(user, 'video');
                addRemoteVideo(user);
            }
            if (user.hasAudio) {
                await client.subscribe(user, 'audio');
                if (user.audioTrack) {
                    user.audioTrack.play();
                }
            }
        }
        updateParticipantCount();

        console.log('[Init] Live session started successfully!');

    } catch (err) {
        console.error('[Init] Failed to start live:', err);
        alert('Failed to start live session: ' + err.message);
        updateConnectionStatus('DISCONNECTED');
    }
}

/* =====================================
   CONTROLS
===================================== */
async function toggleMicrophone() {
    if (!localTracks.audioTrack) {
        console.warn('[Mic] No audio track available');
        return;
    }

    micEnabled = !micEnabled;
    await localTracks.audioTrack.setEnabled(micEnabled);

    const btn = document.getElementById('toggleMic');
    const icon = btn.querySelector('i');
    
    if (micEnabled) {
        icon.className = 'bx bx-microphone';
        btn.classList.remove('muted');
    } else {
        icon.className = 'bx bx-microphone-off';
        btn.classList.add('muted');
    }
    
    console.log('[Mic]', micEnabled ? 'ON' : 'OFF');
}

async function toggleCamera() {
    if (!localTracks.videoTrack) {
        console.warn('[Camera] No video track available');
        return;
    }

    cameraEnabled = !cameraEnabled;
    await localTracks.videoTrack.setEnabled(cameraEnabled);

    const placeholder = document.getElementById('localVideoPlaceholder');
    placeholder.style.display = cameraEnabled ? 'none' : 'flex';

    const btn = document.getElementById('toggleCamera');
    const icon = btn.querySelector('i');
    
    if (cameraEnabled) {
        icon.className = 'bx bx-video';
        btn.classList.remove('off');
    } else {
        icon.className = 'bx bx-video-off';
        btn.classList.add('off');
    }
    
    console.log('[Camera]', cameraEnabled ? 'ON' : 'OFF');
}

async function toggleScreenShare() {
    try {
        if (!isScreenSharing) {
            localTracks.screenTrack = await AgoraRTC.createScreenVideoTrack({
                encoderConfig: "1080p_1"
            });

            if (localTracks.videoTrack) {
                await client.unpublish([localTracks.videoTrack]);
                localTracks.videoTrack.stop();
            }

            await client.publish([localTracks.screenTrack]);
            localTracks.screenTrack.play('localVideo');

            isScreenSharing = true;
            document.querySelector('#toggleScreen i').className = 'bx bx-stop-circle';
            document.getElementById('toggleScreen').classList.add('active');

            localTracks.screenTrack.on('track-ended', async () => {
                await stopScreenShare();
            });

        } else {
            await stopScreenShare();
        }
    } catch (err) {
        console.error('[Screen] Share error:', err);
        if (err.message !== 'Permission denied') {
            alert('Failed to share screen: ' + err.message);
        }
    }
}

async function stopScreenShare() {
    if (localTracks.screenTrack) {
        await client.unpublish([localTracks.screenTrack]);
        localTracks.screenTrack.stop();
        localTracks.screenTrack.close();
        localTracks.screenTrack = null;
    }

    localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack({
        encoderConfig: "720p_2"
    });
    await client.publish([localTracks.videoTrack]);
    localTracks.videoTrack.play('localVideo');

    isScreenSharing = false;
    document.querySelector('#toggleScreen i').className = 'bx bx-desktop';
    document.getElementById('toggleScreen').classList.remove('active');
    document.getElementById('localVideoPlaceholder').style.display = 'none';
}

function openSettings() {
    const modal = new bootstrap.Modal(document.getElementById('settingsModal'));
    modal.show();
}

async function populateDeviceSelects() {
    try {
        const devices = await AgoraRTC.getDevices();
        
        const cameraSelect = document.getElementById('cameraSelect');
        const micSelect = document.getElementById('microphoneSelect');
        const speakerSelect = document.getElementById('speakerSelect');

        if (cameraSelect) cameraSelect.innerHTML = '';
        if (micSelect) micSelect.innerHTML = '';
        if (speakerSelect) speakerSelect.innerHTML = '';

        devices.forEach(device => {
            const option = document.createElement('option');
            option.value = device.deviceId;
            option.text = device.label || `${device.kind} ${device.deviceId.substr(0, 5)}`;

            if (device.kind === 'videoinput' && cameraSelect) {
                cameraSelect.appendChild(option.cloneNode(true));
            } else if (device.kind === 'audioinput' && micSelect) {
                micSelect.appendChild(option.cloneNode(true));
            } else if (device.kind === 'audiooutput' && speakerSelect) {
                speakerSelect.appendChild(option.cloneNode(true));
            }
        });
    } catch (err) {
        console.error('[Devices] Failed to get devices:', err);
    }
}

async function applySettings() {
    try {
        const cameraId = document.getElementById('cameraSelect').value;
        const micId = document.getElementById('microphoneSelect').value;
        const quality = document.getElementById('qualitySelect').value;

        if (cameraId && localTracks.videoTrack) {
            await localTracks.videoTrack.setDevice(cameraId);
            
            // Update current camera index
            const selectedCamera = availableCameras.find(cam => cam.deviceId === cameraId);
            if (selectedCamera) {
                currentCameraIndex = availableCameras.indexOf(selectedCamera);
            }
        }

        if (micId && localTracks.audioTrack) {
            await localTracks.audioTrack.setDevice(micId);
        }

        if (localTracks.videoTrack) {
            const config = quality === '360p' ? '360p_7' :
                          quality === '480p' ? '480p_2' :
                          quality === '1080p' ? '1080p_2' : '720p_2';
            
            await localTracks.videoTrack.setEncoderConfiguration(config);
        }

        bootstrap.Modal.getInstance(document.getElementById('settingsModal')).hide();
        alert('Settings applied successfully!');
    } catch (err) {
        console.error('[Settings] Failed to apply:', err);
        alert('Failed to apply settings: ' + err.message);
    }
}

async function endSession() {
    if (!confirm('End this live session for all participants?')) return;

    if (sessionTimerInterval) {
        clearInterval(sessionTimerInterval);
    }

    for (const track of Object.values(localTracks)) {
        if (track) {
            track.stop();
            track.close();
        }
    }

    if (client) {
        await client.leave();
    }

    window.location.href = "<?= base_url('provider/live_session') ?>";
}

function sendMessage() {
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    
    if (!message) return;
    console.log('Send message:', message);
    input.value = '';
}

/* =====================================
   INIT
===================================== */
document.addEventListener('DOMContentLoaded', startLiveSession);

window.addEventListener('beforeunload', async () => {
    if (client) {
        try { await client.leave(); } catch (e) {}
    }
});

// Handle mobile keyboard
window.addEventListener('resize', () => {
    // Adjust video container on mobile when keyboard appears
    if (window.innerWidth < 992) {
        const vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    }
});
</script>