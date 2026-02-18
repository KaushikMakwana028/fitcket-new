<!-- application/views/user_live_room.php -->

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .live-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 15px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* Session Header */
    .session-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 15px;
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
    }

    .session-header h3 {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 3px;
    }

    .session-header small {
        opacity: 0.9;
        font-size: 0.85rem;
    }

    .header-badges {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .live-badge {
        background: linear-gradient(135deg, #ff4444, #cc0000);
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        animation: pulse-live 1.5s infinite;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    @keyframes pulse-live {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.8; transform: scale(1.05); }
    }

    .connection-status, .participant-count {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
    }

    .connection-status.connected {
        background: rgba(40, 167, 69, 0.9);
    }

    .connection-status.disconnected {
        background: rgba(220, 53, 69, 0.9);
    }

    /* Video Layout */
    .video-layout {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 15px;
    }

    /* Main Video (Big Screen) */
    .main-video-container {
        flex: 1;
        min-height: 300px;
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        background: linear-gradient(145deg, #1a1a2e, #16213e);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .main-video-container:hover {
        box-shadow: 0 12px 40px rgba(102, 126, 234, 0.2);
    }

    .main-video-container #mainVideo {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }

    .main-video-container #mainVideo video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .main-video-container .video-label {
        position: absolute;
        bottom: 15px;
        left: 15px;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(10px);
        color: white;
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 13px;
        font-weight: 500;
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .main-video-container .video-label .status-dot {
        width: 8px;
        height: 8px;
        background: #28a745;
        border-radius: 50%;
        animation: blink 1s infinite;
    }

    .main-video-container .video-label .status-dot.waiting {
        background: #ffc107;
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .expand-hint {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(10px);
        color: white;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 11px;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 10;
    }

    .main-video-container:hover .expand-hint {
        opacity: 1;
    }

    /* Main Video Placeholder */
    .main-placeholder {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #888;
        background: linear-gradient(145deg, #1a1a2e, #16213e);
        z-index: 5;
    }

    .main-placeholder.show {
        display: flex;
    }

    .main-placeholder i {
        font-size: 64px;
        margin-bottom: 15px;
        color: #667eea;
    }

    .main-placeholder p {
        font-size: 16px;
    }

    /* Waiting Overlay - Only for trainer */
    .waiting-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(145deg, rgba(26, 26, 46, 0.95), rgba(22, 33, 62, 0.95));
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        z-index: 20;
    }

    .waiting-overlay.show {
        display: flex;
    }

    .spinner {
        width: 60px;
        height: 60px;
        border: 4px solid rgba(255, 255, 255, 0.1);
        border-top-color: #667eea;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 20px;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .waiting-overlay h5 {
        font-size: 1.1rem;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .waiting-overlay p {
        font-size: 0.85rem;
        opacity: 0.7;
    }

    /* Thumbnail Videos */
    .thumbnail-container {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding: 5px;
        scroll-behavior: smooth;
    }

    .thumbnail-container::-webkit-scrollbar {
        height: 6px;
    }

    .thumbnail-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .thumbnail-container::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 3px;
    }

    .thumbnail-video {
        min-width: 180px;
        width: 180px;
        height: 120px;
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        background: linear-gradient(145deg, #1a1a2e, #16213e);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        transition: all 0.3s ease;
        border: 3px solid transparent;
        flex-shrink: 0;
    }

    .thumbnail-video:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .thumbnail-video.active {
        border-color: #667eea;
        box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
    }

    .thumbnail-video .video-wrapper {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }

    .thumbnail-video .video-wrapper video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .thumbnail-video .video-label {
        position: absolute;
        bottom: 8px;
        left: 8px;
        right: 8px;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
        color: white;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 500;
        text-align: center;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        z-index: 5;
    }

    .thumbnail-video .swap-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        background: rgba(102, 126, 234, 0.9);
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: all 0.3s ease;
        z-index: 10;
    }

    .thumbnail-video:hover .swap-icon {
        transform: translate(-50%, -50%) scale(1);
    }

    /* Thumbnail Placeholder */
    .thumbnail-placeholder {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #666;
        background: linear-gradient(145deg, #1a1a2e, #16213e);
        z-index: 3;
    }

    .thumbnail-placeholder.show {
        display: flex;
    }

    .thumbnail-placeholder i {
        font-size: 32px;
        margin-bottom: 5px;
        color: #667eea;
    }

    .thumbnail-placeholder p {
        font-size: 11px;
    }

    /* Controls Bar */
    .controls-bar {
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        padding: 15px 20px;
        border-radius: 16px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .control-group {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .control-divider {
        width: 1px;
        height: 40px;
        background: #dee2e6;
        margin: 0 10px;
    }

    .control-btn {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        border: none;
        background: linear-gradient(145deg, #f0f0f0, #e6e6e6);
        color: #495057;
        font-size: 22px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .control-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .control-btn:active {
        transform: translateY(-1px);
    }

    .control-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .control-btn.active {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        box-shadow: 0 4px 20px rgba(40, 167, 69, 0.4);
    }

    .control-btn.muted {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
        box-shadow: 0 4px 20px rgba(220, 53, 69, 0.4);
    }

    .control-btn.switch-camera {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
    }

    .control-btn.switch-camera:hover {
        background: linear-gradient(135deg, #764ba2, #667eea);
    }

    .control-btn.swap-btn {
        background: linear-gradient(135deg, #fd7e14, #e65c00);
        color: white;
        box-shadow: 0 4px 20px rgba(253, 126, 20, 0.4);
    }

    .control-btn.fullscreen-btn {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
        box-shadow: 0 4px 20px rgba(23, 162, 184, 0.4);
    }

    .control-btn.leave {
        background: linear-gradient(135deg, #dc3545, #c82333);
        width: auto;
        padding: 0 25px;
        border-radius: 30px;
        gap: 8px;
        font-size: 16px;
        font-weight: 600;
    }

    .control-btn.leave:hover {
        background: linear-gradient(135deg, #c82333, #bd2130);
    }

    .control-btn-label {
        position: absolute;
        bottom: -22px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 10px;
        color: #6c757d;
        white-space: nowrap;
        font-weight: 500;
    }

    /* Fullscreen Mode */
    .fullscreen-mode .live-container {
        padding: 10px;
    }

    .fullscreen-mode .session-header {
        display: none;
    }

    .fullscreen-mode .controls-bar {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        z-index: 1000;
        padding: 12px 20px;
        border-radius: 50px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .live-container {
            padding: 10px;
        }

        .session-header {
            padding: 12px 15px;
            border-radius: 10px;
            flex-direction: column;
            gap: 10px;
        }

        .session-header h3 {
            font-size: 1rem;
        }

        .header-badges {
            gap: 6px;
            width: 100%;
            justify-content: flex-end;
        }

        .main-video-container {
            min-height: 250px;
            border-radius: 12px;
        }

        .thumbnail-container {
            gap: 8px;
        }

        .thumbnail-video {
            min-width: 140px;
            width: 140px;
            height: 95px;
            border-radius: 10px;
        }

        .controls-bar {
            padding: 12px 15px;
            gap: 8px;
            border-radius: 12px;
        }

        .control-btn {
            width: 48px;
            height: 48px;
            font-size: 18px;
        }

        .control-btn.leave {
            padding: 0 18px;
            font-size: 14px;
        }

        .control-divider {
            height: 30px;
            margin: 0 5px;
        }

        .control-btn-label {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .main-video-container {
            min-height: 200px;
        }

        .thumbnail-video {
            min-width: 120px;
            width: 120px;
            height: 80px;
        }

        .control-btn {
            width: 44px;
            height: 44px;
            font-size: 16px;
        }

        .control-btn.leave {
            padding: 0 15px;
            font-size: 12px;
        }

        .control-divider {
            display: none;
        }

        .control-group {
            gap: 6px;
        }
    }

    /* Animations */
    .fade-in {
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .slide-up {
        animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="live-container">

    <!-- HEADER -->
    <div class="session-header d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h3><?= htmlspecialchars($session['title']) ?></h3>
            <small><i class="bx bx-user-circle"></i> Viewing as: <?= htmlspecialchars($user_name) ?></small>
        </div>
        <div class="header-badges">
            <span class="participant-count">
                <i class="bx bx-group"></i> <span id="participantCount">1</span>
            </span>
            <span class="connection-status" id="connectionStatus">
                <i class="bx bx-wifi"></i> Connecting...
            </span>
            <span class="live-badge"><i class="bx bx-broadcast"></i> LIVE</span>
        </div>
    </div>

    <!-- VIDEO LAYOUT -->
    <div class="video-layout">
        
        <!-- Main Video (Big Screen) -->
        <div class="main-video-container fade-in" id="mainVideoContainer">
            <div id="mainVideo"></div>
            
            <!-- Main Placeholder (when camera off) -->
            <div class="main-placeholder" id="mainPlaceholder">
                <i class="bx bx-video-off"></i>
                <p id="mainPlaceholderText">Camera Off</p>
            </div>
            
            <!-- Waiting Overlay - Only shows when provider is on main and not streaming -->
            <div id="waitingOverlay" class="waiting-overlay">
                <div class="spinner"></div>
                <h5>Waiting for trainer to start...</h5>
                <p>The session will begin shortly</p>
            </div>
            
            <div class="video-label" id="mainVideoLabel">
                <span class="status-dot" id="mainStatusDot"></span>
                <span id="mainVideoName">Trainer</span>
            </div>
            
            <div class="expand-hint">
                <i class="bx bx-expand-alt"></i> Double-click for fullscreen
            </div>
        </div>

        <!-- Thumbnail Videos -->
        <div class="thumbnail-container" id="thumbnailContainer">
            
            <!-- Provider Thumbnail -->
            <div class="thumbnail-video active" id="providerThumbnail" data-type="provider">
                <div class="video-wrapper" id="providerVideoSmall"></div>
                <div class="thumbnail-placeholder show" id="providerPlaceholder">
                    <i class="bx bx-loader-circle bx-spin"></i>
                    <p>Waiting...</p>
                </div>
                <div class="video-label">Trainer</div>
                <div class="swap-icon">
                    <i class="bx bx-expand"></i>
                </div>
            </div>

            <!-- Local Thumbnail -->
            <div class="thumbnail-video" id="localThumbnail" data-type="local">
                <div class="video-wrapper" id="localVideoSmall"></div>
                <div class="thumbnail-placeholder" id="localPlaceholder">
                    <i class="bx bx-video-off"></i>
                    <p>Camera Off</p>
                </div>
                <div class="video-label"><?= htmlspecialchars($user_name) ?> (You)</div>
                <div class="swap-icon">
                    <i class="bx bx-expand"></i>
                </div>
            </div>

        </div>
    </div>

    <!-- CONTROLS -->
    <div class="controls-bar slide-up">
        
        <div class="control-group">
            <button id="micBtn" class="control-btn active" title="Toggle Microphone (M)">
                <i class="bx bx-microphone"></i>
                <span class="control-btn-label">Mic</span>
            </button>

            <button id="camBtn" class="control-btn active" title="Toggle Camera (V)">
                <i class="bx bx-video"></i>
                <span class="control-btn-label">Camera</span>
            </button>

            <button id="switchCamBtn" class="control-btn switch-camera" title="Switch Camera (C)">
                <i class="bx bx-refresh"></i>
                <span class="control-btn-label">Flip</span>
            </button>
        </div>

        <div class="control-divider"></div>

        <div class="control-group">
            <button id="swapBtn" class="control-btn swap-btn" title="Swap View (S)">
                <i class="bx bx-transfer-alt"></i>
                <span class="control-btn-label">Swap</span>
            </button>

            <button id="fullscreenBtn" class="control-btn fullscreen-btn" title="Fullscreen (F)">
                <i class="bx bx-fullscreen"></i>
                <span class="control-btn-label">Fullscreen</span>
            </button>
        </div>

        <div class="control-divider"></div>

        <button id="leaveBtn" class="control-btn leave" title="Leave Session">
            <i class="bx bx-log-out"></i>
            <span>Leave</span>
        </button>

    </div>

</div>

<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
<script src="https://download.agora.io/sdk/release/AgoraRTC_N-4.20.0.js"></script>

<script>
    /* =====================================
       AGORA CONFIG
    ===================================== */
    const APP_ID = "<?= $app_id ?>";
    const TOKEN = "<?= $token ?>";
    const CHANNEL = "<?= $channel ?>";
    const UID = <?= $uid ?>;
    const USER_NAME = "<?= htmlspecialchars($user_name) ?>";

    /* =====================================
       GLOBAL STATE
    ===================================== */
    let client = null;
    let localTracks = {
        audioTrack: null,
        videoTrack: null
    };

    let micEnabled = true;
    let cameraEnabled = true;
    let remoteUsers = {};
    
    // Camera switching
    let availableCameras = [];
    let currentCameraIndex = 0;

    // Video layout state
    let mainVideoSource = 'provider'; // 'provider' or 'local'
    let isFullscreen = false;
    let providerConnected = false; // Track if provider has connected

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

    function updateParticipantCount() {
        const el = document.getElementById('participantCount');
        if (el) {
            el.textContent = Object.keys(remoteUsers).length + 1;
        }
    }

    /* =====================================
       VIDEO LAYOUT MANAGEMENT - FIXED
    ===================================== */
    function updateVideoLayout() {
        console.log('[Layout] Updating... mainVideoSource:', mainVideoSource);
        
        const mainContainer = document.getElementById('mainVideo');
        const mainPlaceholder = document.getElementById('mainPlaceholder');
        const mainPlaceholderText = document.getElementById('mainPlaceholderText');
        const mainLabel = document.getElementById('mainVideoName');
        const mainStatusDot = document.getElementById('mainStatusDot');
        const waitingOverlay = document.getElementById('waitingOverlay');
        
        const providerSmall = document.getElementById('providerVideoSmall');
        const providerPlaceholder = document.getElementById('providerPlaceholder');
        
        const localSmall = document.getElementById('localVideoSmall');
        const localPlaceholder = document.getElementById('localPlaceholder');

        // Clear ALL video containers first
        mainContainer.innerHTML = '';
        providerSmall.innerHTML = '';
        localSmall.innerHTML = '';
        
        // Hide all placeholders initially
        mainPlaceholder.classList.remove('show');
        providerPlaceholder.classList.remove('show');
        localPlaceholder.classList.remove('show');
        waitingOverlay.classList.remove('show');

        // Get provider user (first remote user)
        const providerUser = Object.values(remoteUsers)[0];
        const hasProviderVideo = providerUser && providerUser.videoTrack;
        const hasLocalVideo = localTracks.videoTrack && cameraEnabled;

        console.log('[Layout] hasProviderVideo:', hasProviderVideo, 'hasLocalVideo:', hasLocalVideo);

        if (mainVideoSource === 'provider') {
            // ========== PROVIDER in MAIN, LOCAL in THUMBNAIL ==========
            mainLabel.textContent = 'Trainer';
            
            // Main video = Provider
            if (hasProviderVideo) {
                console.log('[Layout] Playing provider in mainVideo');
                providerUser.videoTrack.play('mainVideo');
                mainStatusDot.classList.remove('waiting');
                providerConnected = true;
            } else {
                // Show waiting overlay ONLY when provider is on main screen and not connected
                console.log('[Layout] Showing waiting overlay for provider');
                waitingOverlay.classList.add('show');
                mainStatusDot.classList.add('waiting');
            }
            
            // Thumbnail = Local (You) - Always show local video in thumbnail
            if (hasLocalVideo) {
                console.log('[Layout] Playing local in localVideoSmall');
                localTracks.videoTrack.play('localVideoSmall');
            } else {
                localPlaceholder.classList.add('show');
            }
            
            // Provider thumbnail - show placeholder since provider is on main
            if (!hasProviderVideo) {
                providerPlaceholder.classList.add('show');
                providerPlaceholder.innerHTML = '<i class="bx bx-loader-circle bx-spin"></i><p>Waiting...</p>';
            }
            
        } else {
            // ========== LOCAL in MAIN, PROVIDER in THUMBNAIL ==========
            mainLabel.textContent = USER_NAME + ' (You)';
            mainStatusDot.classList.remove('waiting');
            
            // IMPORTANT: Never show waiting overlay when local video is on main screen
            // The waiting overlay is only for waiting for trainer
            
            // Main video = Local (You)
            if (hasLocalVideo) {
                console.log('[Layout] Playing local in mainVideo');
                localTracks.videoTrack.play('mainVideo');
            } else {
                // Show camera off placeholder, NOT waiting overlay
                mainPlaceholder.classList.add('show');
                mainPlaceholderText.textContent = 'Your Camera is Off';
            }
            
            // Thumbnail = Provider
            if (hasProviderVideo) {
                console.log('[Layout] Playing provider in providerVideoSmall');
                providerUser.videoTrack.play('providerVideoSmall');
                providerPlaceholder.classList.remove('show');
            } else {
                providerPlaceholder.classList.add('show');
                providerPlaceholder.innerHTML = '<i class="bx bx-loader-circle bx-spin"></i><p>Waiting...</p>';
            }
            
            // Local thumbnail - show placeholder since local is on main
            if (!hasLocalVideo) {
                localPlaceholder.classList.add('show');
            }
        }

        // Update thumbnail active states
        updateThumbnailActiveState();
    }

    function updateThumbnailActiveState() {
        document.querySelectorAll('.thumbnail-video').forEach(thumb => {
            thumb.classList.remove('active');
        });
        
        if (mainVideoSource === 'provider') {
            document.getElementById('providerThumbnail').classList.add('active');
        } else {
            document.getElementById('localThumbnail').classList.add('active');
        }
    }

    function switchMainVideo(source) {
        console.log('[Switch] Switching main video to:', source);
        mainVideoSource = source;
        updateVideoLayout();
    }

    function swapVideos() {
        console.log('[Swap] Current:', mainVideoSource);
        mainVideoSource = mainVideoSource === 'provider' ? 'local' : 'provider';
        console.log('[Swap] New:', mainVideoSource);
        updateVideoLayout();

        // Animate swap button
        const swapBtn = document.getElementById('swapBtn');
        swapBtn.querySelector('i').classList.add('bx-spin');
        setTimeout(() => {
            swapBtn.querySelector('i').classList.remove('bx-spin');
        }, 500);
    }

    /* =====================================
       FULLSCREEN
    ===================================== */
    function toggleFullscreen() {
        const mainContainer = document.getElementById('mainVideoContainer');
        
        if (!document.fullscreenElement) {
            mainContainer.requestFullscreen().then(() => {
                isFullscreen = true;
                document.body.classList.add('fullscreen-mode');
                document.getElementById('fullscreenBtn').querySelector('i').className = 'bx bx-exit-fullscreen';
            }).catch(err => {
                console.log('Fullscreen error:', err);
            });
        } else {
            document.exitFullscreen().then(() => {
                isFullscreen = false;
                document.body.classList.remove('fullscreen-mode');
                document.getElementById('fullscreenBtn').querySelector('i').className = 'bx bx-fullscreen';
            });
        }
    }

    document.addEventListener('fullscreenchange', () => {
        if (!document.fullscreenElement) {
            isFullscreen = false;
            document.body.classList.remove('fullscreen-mode');
            document.getElementById('fullscreenBtn').querySelector('i').className = 'bx bx-fullscreen';
        }
    });

    /* =====================================
       CAMERA SWITCHING (FRONT/BACK)
    ===================================== */
    async function getAvailableCameras() {
        try {
            const devices = await AgoraRTC.getDevices();
            availableCameras = devices.filter(device => device.kind === 'videoinput');
            console.log('[Camera] Available cameras:', availableCameras.length);
            
            if (availableCameras.length <= 1) {
                document.getElementById('switchCamBtn').style.opacity = '0.5';
            }
            
            return availableCameras;
        } catch (err) {
            console.error('[Camera] Error getting cameras:', err);
            return [];
        }
    }

    async function switchCamera() {
        if (!cameraEnabled) {
            alert('Please enable your camera first');
            return;
        }

        if (availableCameras.length <= 1) {
            alert('No other camera available');
            return;
        }

        const btn = document.getElementById('switchCamBtn');
        
        try {
            btn.disabled = true;
            btn.querySelector('i').classList.add('bx-spin');
            console.log('[Camera] Switching camera...');

            currentCameraIndex = (currentCameraIndex + 1) % availableCameras.length;
            const newCameraId = availableCameras[currentCameraIndex].deviceId;
            console.log('[Camera] Switching to:', availableCameras[currentCameraIndex].label);

            // Unpublish and close current video track
            if (localTracks.videoTrack) {
                await client.unpublish(localTracks.videoTrack);
                localTracks.videoTrack.stop();
                localTracks.videoTrack.close();
            }

            // Create new video track with different camera
            localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack({
                cameraId: newCameraId,
                encoderConfig: "480p_1"
            });

            // Publish new track
            await client.publish(localTracks.videoTrack);

            console.log('[Camera] Camera switched successfully');

            // Update layout
            updateVideoLayout();

            btn.disabled = false;
            btn.querySelector('i').classList.remove('bx-spin');

        } catch (err) {
            console.error('[Camera] Failed to switch:', err);
            
            // Try to recover
            try {
                localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack({
                    encoderConfig: "480p_1"
                });
                await client.publish(localTracks.videoTrack);
                updateVideoLayout();
            } catch (e) {
                console.error('[Camera] Recovery failed:', e);
            }

            btn.disabled = false;
            btn.querySelector('i').classList.remove('bx-spin');
            alert('Failed to switch camera: ' + err.message);
        }
    }

    /* =====================================
       AGORA EVENTS
    ===================================== */
    function setupEventHandlers() {

        client.on('user-joined', (user) => {
            console.log('[Agora] User joined:', user.uid);
            remoteUsers[user.uid] = user;
            updateParticipantCount();
        });

        client.on('user-published', async (user, mediaType) => {
            console.log('[Agora] User published:', user.uid, mediaType);

            await client.subscribe(user, mediaType);
            remoteUsers[user.uid] = user;

            if (mediaType === 'video') {
                providerConnected = true;
                setTimeout(() => {
                    updateVideoLayout();
                }, 100);
            }

            if (mediaType === 'audio') {
                user.audioTrack.play();
            }
        });

        client.on('user-unpublished', (user, mediaType) => {
            console.log('[Agora] User unpublished:', user.uid, mediaType);

            if (mediaType === 'video') {
                updateVideoLayout();
            }
        });

        client.on('user-left', (user) => {
            console.log('[Agora] User left:', user.uid);
            delete remoteUsers[user.uid];
            providerConnected = false;
            updateParticipantCount();
            updateVideoLayout();
        });

        client.on('connection-state-change', (curState, prevState) => {
            console.log('[Agora] Connection:', prevState, '->', curState);
            updateConnectionStatus(curState);
        });
    }

    /* =====================================
       INITIALIZE SESSION
    ===================================== */
    async function init() {
        try {
            updateConnectionStatus('CONNECTING');
            console.log('[Init] Starting...');

            await getAvailableCameras();

            client = AgoraRTC.createClient({
                mode: 'rtc',
                codec: 'vp8'
            });

            setupEventHandlers();

            await client.join(APP_ID, CHANNEL, TOKEN, UID);
            console.log('[Init] Joined channel');

            localTracks.audioTrack = await AgoraRTC.createMicrophoneAudioTrack();
            localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack({
                encoderConfig: "480p_1"
            });
            console.log('[Init] Local tracks created');

            await client.publish([
                localTracks.audioTrack,
                localTracks.videoTrack
            ]);
            console.log('[Init] Published local tracks');

            updateConnectionStatus('CONNECTED');
            updateParticipantCount();

            // Check if provider is already streaming
            const remoteUsersList = client.remoteUsers;
            for (const user of remoteUsersList) {
                if (user.hasVideo) {
                    await client.subscribe(user, 'video');
                    providerConnected = true;
                }
                if (user.hasAudio) {
                    await client.subscribe(user, 'audio');
                    user.audioTrack.play();
                }
                remoteUsers[user.uid] = user;
            }
            
            // Initial layout
            updateVideoLayout();
            updateParticipantCount();

            console.log('[Init] Complete');

        } catch (err) {
            console.error('[Init] Failed:', err);
            alert('Failed to join session: ' + err.message);
            updateConnectionStatus('DISCONNECTED');
        }
    }

    /* =====================================
       CONTROLS
    ===================================== */
    async function toggleMic() {
        if (!localTracks.audioTrack) return;

        micEnabled = !micEnabled;
        await localTracks.audioTrack.setEnabled(micEnabled);

        const btn = document.getElementById('micBtn');
        const icon = btn.querySelector('i');

        if (micEnabled) {
            btn.classList.add('active');
            btn.classList.remove('muted');
            icon.className = 'bx bx-microphone';
        } else {
            btn.classList.remove('active');
            btn.classList.add('muted');
            icon.className = 'bx bx-microphone-off';
        }
        
        console.log('[Mic]', micEnabled ? 'ON' : 'OFF');
    }

    async function toggleCamera() {
        if (!localTracks.videoTrack) return;

        cameraEnabled = !cameraEnabled;
        await localTracks.videoTrack.setEnabled(cameraEnabled);

        const btn = document.getElementById('camBtn');
        const icon = btn.querySelector('i');

        if (cameraEnabled) {
            btn.classList.add('active');
            btn.classList.remove('muted');
            icon.className = 'bx bx-video';
        } else {
            btn.classList.remove('active');
            btn.classList.add('muted');
            icon.className = 'bx bx-video-off';
        }
        
        console.log('[Camera]', cameraEnabled ? 'ON' : 'OFF');
        
        updateVideoLayout();
    }

    async function leaveSession() {
        if (!confirm('Are you sure you want to leave this session?')) return;

        for (const track of Object.values(localTracks)) {
            if (track) {
                track.stop();
                track.close();
            }
        }

        if (client) {
            await client.leave();
        }

        window.location.href = "<?= base_url('session_booking/my_sessions') ?>";
    }

    /* =====================================
       EVENT LISTENERS
    ===================================== */
    document.addEventListener('DOMContentLoaded', init);

    // Control buttons
    document.getElementById('micBtn').addEventListener('click', toggleMic);
    document.getElementById('camBtn').addEventListener('click', toggleCamera);
    document.getElementById('switchCamBtn').addEventListener('click', switchCamera);
    document.getElementById('swapBtn').addEventListener('click', swapVideos);
    document.getElementById('fullscreenBtn').addEventListener('click', toggleFullscreen);
    document.getElementById('leaveBtn').addEventListener('click', leaveSession);

    // Thumbnail clicks
    document.getElementById('providerThumbnail').addEventListener('click', () => switchMainVideo('provider'));
    document.getElementById('localThumbnail').addEventListener('click', () => switchMainVideo('local'));

    // Double-click for fullscreen
    document.getElementById('mainVideoContainer').addEventListener('dblclick', toggleFullscreen);

    // Keyboard shortcuts
    document.addEventListener('keydown', (e) => {
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
        
        switch(e.key.toLowerCase()) {
            case 'm': toggleMic(); break;
            case 'v': toggleCamera(); break;
            case 's': swapVideos(); break;
            case 'f': toggleFullscreen(); break;
            case 'c': switchCamera(); break;
        }
    });

    // Cleanup
    window.addEventListener('beforeunload', async () => {
        if (client) {
            try { await client.leave(); } catch (e) {}
        }
    });
</script>