<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
<style>
    body {
        background-color: #f8f9fa !important;
        color: #212529 !important;
    }

    .fittv-container {
        background-color: #f8f9fa;
        color: #212529;
        padding-top: 2rem;
        padding-bottom: 2rem;
        min-height: 100vh;
    }

    .fittv-header h2 {
        font-weight: 800;
        letter-spacing: 1px;
        font-size: 2.2rem;
        color: #212529;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        color: #495057;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 20px;
        background: #e9ecef;
        transition: all 0.2s;
        margin-bottom: 1rem;
    }

    .back-btn:hover {
        background: #dee2e6;
        color: #212529;
    }

    .back-btn svg {
        margin-right: 6px;
    }

    .cat-title {
        font-size: 1.6rem;
        font-weight: 700;
        margin-top: 0.5rem;
        margin-bottom: 2rem;
        letter-spacing: 0.5px;
        text-transform: capitalize;
        color: #212529;
        display: flex;
        align-items: center;
    }

    /* YouTube Style Vertical List Layout */
    .yt-video-list {
        display: flex;
        flex-direction: column;
        gap: 25px;
        max-width: 900px;
        margin: 0 auto;
    }

    .yt-video-card {
        display: flex;
        flex-direction: column;
        background: transparent;
        transition: transform 0.2s ease;
        text-decoration: none;
        color: inherit;
    }

    .yt-video-card:hover {
        text-decoration: none;
        color: inherit;
    }

    .yt-thumbnail-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 16/9;
        background: #000;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: box-shadow 0.3s ease;
    }

    /* Play Button Overlay */
    .video-container {
        position: relative;
        width: 100%;
        height: 100%;
        border-radius: 12px;
        overflow: hidden;
        background: #000;
    }

    .video-container video {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .play-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: rgba(0, 0, 0, 0.3);
        cursor: pointer;
        z-index: 10;
        transition: opacity 0.3s;
    }

    .play-overlay.hidden {
        opacity: 0;
        pointer-events: none;
    }

    .play-button {
        width: 80px;
        height: 80px;
        background: #e63946;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: transform 0.3s;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    .play-button:hover {
        transform: scale(1.1);
    }

    .play-button svg {
        width: 35px;
        height: 35px;
        fill: white;
        margin-left: 5px;
    }

    /* Hide Plyr's default play button */
    .plyr__control--overlaid {
        display: none !important;
    }

    .plyr {
        --plyr-color-main: #e63946;
        height: 100%;
    }

    .yt-info-area {
        display: flex;
        padding-top: 12px;
        gap: 12px;
    }

    .yt-channel-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #dee2e6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: bold;
        flex-shrink: 0;
    }

    .avatar-boy {
        background: #007bff;
    }

    .avatar-girl {
        background: #dc3545;
    }

    .yt-text-details {
        flex-grow: 1;
        overflow: hidden;
    }

    .yt-video-title {
        font-size: 1.15rem;
        font-weight: 600;
        color: #0f0f0f;
        margin: 0 0 4px 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .yt-video-meta {
        font-size: 0.9rem;
        color: #606060;
        margin: 0;
    }

    .yt-thumbnail-wrapper:hover .play-overlay-icon {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1.1);
    }

    @media (min-width: 768px) {
        .yt-video-list {
            gap: 20px;
        }

        .yt-video-card {
            flex-direction: row;
            gap: 16px;
        }

        .yt-thumbnail-wrapper {
            width: 360px;
            flex-shrink: 0;
        }
    }
</style>

<div class="fittv-container container-fluid px-md-5 px-3">

    <div class="d-flex justify-content-between align-items-center mb-3 fittv-header">
        <h2 class="mb-0">FITTV <span class="text-danger">.</span></h2>
    </div>

    <a href="<?= base_url('fittv/' . $gender) ?>" class="back-btn">
        <svg focusable="false" viewBox="0 0 24 24" width="18" height="18" fill="currentColor">
            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path>
        </svg>
        Back to Categories
    </a>

    <!-- Category Header -->
    <h4 class="cat-title">
        <span class="bg-dark rounded-circle me-3" style="width: 8px; height: 8px; display: inline-block;"></span>
        <?= htmlspecialchars($category->name) ?> Workouts
    </h4>

    <!-- Videos List -->
    <?php if (!empty($videos)) { ?>
        <div class="yt-video-list">
            <?php foreach ($videos as $v) { ?>
                <div class="yt-video-card <?= (isset($gender) && $gender == 'Boy') ? 'hover-boy' : 'hover-girl' ?>">

                    <div class="yt-thumbnail-wrapper">
                        <div class="video-container">
                            <video class="player" playsinline preload="metadata" loop>
                                <source src="<?= base_url('uploads/videos/' . $v->video) ?>" type="video/mp4">
                            </video>

                            <div class="play-overlay playOverlay">
                                <div class="play-button">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="yt-info-area">
                        <div class="yt-channel-avatar <?= (isset($gender) && $gender == 'Boy') ? 'avatar-boy' : 'avatar-girl' ?>">
                            F
                        </div>
                        <div class="yt-text-details">
                            <h3 class="yt-video-title"><?= htmlspecialchars($v->title) ?></h3>
                            <p class="yt-video-meta">FitTV Official • <?= htmlspecialchars($category->name) ?></p>
                        </div>
                    </div>

                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="d-flex flex-column align-items-center justify-content-center mt-5 py-5 text-muted bg-white rounded-4 shadow-sm border border-light" style="max-width: 900px; margin: 0 auto;">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-3 opacity-50">
                <polygon points="23 7 16 12 23 17 23 7"></polygon>
                <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
            </svg>
            <h4 class="fw-light opacity-75">No Videos Yet</h4>
            <p class="small opacity-50">This category currently doesn't have any videos. Check back later!</p>
        </div>
    <?php } ?>

</div>

<script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
<script>
    function initPlyrPlayers() {

        const containers = document.querySelectorAll('.video-container');
        const players = [];

        containers.forEach(container => {

            const video = container.querySelector('.player');
            const playOverlay = container.querySelector('.playOverlay');

            const player = new Plyr(video, {
                controls: [],
                clickToPlay: false
            });

            players.push({
                player,
                overlay: playOverlay
            });

            playOverlay.addEventListener('click', () => {

                // Pause all other videos and show their play button
                players.forEach(obj => {
                    if (obj.player !== player) {
                        obj.player.pause();
                        obj.overlay.classList.remove('hidden');
                    }
                });

                playOverlay.classList.add('hidden');
                player.play();
            });

            // Hide overlay while playing
            player.on('play', () => {
                playOverlay.classList.add('hidden');
            });

            // Show overlay when paused
            player.on('pause', () => {
                playOverlay.classList.remove('hidden');
            });

        });

    }

    const observer = new IntersectionObserver(entries => {

        entries.forEach(entry => {

            if (!entry.isIntersecting) {

                const video = entry.target.querySelector('video');

                if (video) {
                    video.pause();
                }

            }

        });

    }, {
        threshold: 0.3
    });

    document.querySelectorAll('.video-container').forEach(el => {
        observer.observe(el);
    });

    // Initialize players reliably depending on ready state
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPlyrPlayers);
    } else {
        initPlyrPlayers();
    }
</script>