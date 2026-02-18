<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($session->title) ?> - Live Room</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { height: 100%; overflow: hidden; }
        body { background: #1a1a2e; color: #fff; font-family: 'Segoe UI', sans-serif; }
        
        .room-container { display: flex; height: 100vh; }
        .main-area { flex: 1; display: flex; flex-direction: column; }
        .sidebar-area { width: 320px; background: #16213e; border-left: 1px solid #0f3460; display: flex; flex-direction: column; }
        
        .top-bar {
            background: #16213e;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #0f3460;
        }
        .top-bar .session-info h5 { margin: 0; font-size: 16px; }
        .top-bar .session-info span { font-size: 12px; color: #94a3b8; }
        .top-bar .live-badge {
            background: #ef4444;
            color: #fff;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .video-area { flex: 1; padding: 20px; display: flex; gap: 15px; }
        .main-video {
            flex: 1;
            background: #0f0f23;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
        }
        .main-video video { width: 100%; height: 100%; object-fit: cover; }
        .main-video .no-video {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #64748b;
        }
        .main-video .no-video i { font-size: 80px; margin-bottom: 10px; }
        
        .participants-strip {
            width: 180px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            overflow-y: auto;
        }
        .participant-video {
            aspect-ratio: 16/9;
            background: #0f0f23;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
        }
        .participant-video video { width: 100%; height: 100%; object-fit: cover; }
        .participant-video .name {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 4px 8px;
            background: linear-gradient(transparent, rgba(0,0,0,0.8));
            font-size: 11px;
        }
        
        .controls-bar {
            background: #16213e;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            border-top: 1px solid #0f3460;
        }
        .control-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .control-btn.primary { background: #3b82f6; color: #fff; }
        .control-btn.danger { background: #ef4444; color: #fff; }
        .control-btn.secondary { background: #374151; color: #fff; }
        .control-btn:hover { transform: scale(1.1); }
        .control-btn.muted { background: #ef4444 !important; }
        
        .sidebar-header {
            padding: 16px;
            border-bottom: 1px solid #0f3460;
        }
        .sidebar-tabs {
            display: flex;
            border-bottom: 1px solid #0f3460;
        }
        .sidebar-tab {
            flex: 1;
            padding: 12px;
            text-align: center;
            cursor: pointer;
            border: none;
            background: none;
            color: #94a3b8;
            font-size: 14px;
        }
        .sidebar-tab.active {
            color: #3b82f6;
            border-bottom: 2px solid #3b82f6;
        }
        
        .sidebar-content { flex: 1; overflow-y: auto; padding: 16px; }
        
        .participant-list { list-style: none; padding: 0; }
        .participant-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            background: #1e293b;
            border-radius: 8px;
            margin-bottom: 8px;
        }
        .participant-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
        .participant-item .name { flex: 1; }
        .participant-item .status { font-size: 12px; color: #22c55e; }
        
        .chat-messages { height: calc(100% - 60px); overflow-y: auto; }
        .chat-message {
            margin-bottom: 12px;
            background: #1e293b;
            padding: 10px;
            border-radius: 8px;
        }
        .chat-message .name { font-size: 12px; color: #3b82f6; margin-bottom: 4px; }
        .chat-message .text { font-size: 14px; }
        .chat-message .time { font-size: 10px; color: #64748b; margin-top: 4px; }
        
        .chat-input {
            display: flex;
            gap: 8px;
            margin-top: auto;
        }
        .chat-input input {
            flex: 1;
            background: #1e293b;
            border: 1px solid #374151;
            border-radius: 8px;
            padding: 10px 14px;
            color: #fff;
        }
        .chat-input button {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            border: none;
            background: #3b82f6;
            color: #fff;
            cursor: pointer;
        }
        
        .timer {
            font-family: monospace;
            font-size: 14px;
            background: #1e293b;
            padding: 6px 12px;
            border-radius: 20px;
            margin-left: auto;
        }
        
        