<style>

</style>

<div class="page-wrapper p-4">
    <div class="page-content">

        <div class="card shadow-sm">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">FITTV Videos</h5>
                <a href="<?= base_url('admin/add_fittv_video') ?>" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> Add Video</a>
            </div>

            <div class="card-body">

                <!-- SEARCH + FILTER -->

                <form method="get" class="row mb-3" id="filterForm">

                    <div class="col-md-4 mb-3 mb-md-0">
                        <input type="text"
                            name="search"
                            id="searchVideo"
                            class="form-control"
                            placeholder="Search video title..."
                            value="<?= $this->input->get('search') ?>">
                    </div>

                    <div class="col-md-3 mb-3 mb-md-0">

                        <select name="gender" id="genderSelect" class="form-control">

                            <option value="">All Gender</option>

                            <option value="Boy"
                                <?= $this->input->get('gender') == 'Boy' ? 'selected' : '' ?>>
                                Boy
                            </option>

                            <option value="Girl"
                                <?= $this->input->get('gender') == 'Girl' ? 'selected' : '' ?>>
                                Girl
                            </option>

                        </select>

                    </div>

                    <div class="col-md-3">

                        <button class="btn btn-primary">
                            <i class="bx bx-search"></i> Search
                        </button>

                        <a href="<?= base_url('admin/fittv_videos') ?>" class="btn btn-secondary">
                            Reset
                        </a>

                    </div>

                </form>


                <!-- TABLE -->

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">

                        <thead>

                            <tr>
                                <th width="50">#</th>
                                <th width="80">Gender</th>
                                <th width="150">Category</th>
                                <th>Title</th>
                                <th width="200">Video</th>
                                <th width="120">Action</th>
                            </tr>

                        </thead>

                        <tbody id="tableBody">

                            <?php if (!empty($videos)) { ?>


                                <?php
                                $index = 1;
                                foreach ($videos as $v) {
                                ?>

                                    <tr>

                                        <td><?= $index++ ?></td>

                                        <td>

                                            <span class="badge <?= ($v->gender ?? '') == 'Boy' ? 'bg-primary' : 'bg-danger' ?>">
                                                <?= $v->gender ?? '' ?>
                                            </span>

                                        </td>

                                        <td>
                                            <?= $v->category_name ?>
                                        </td>

                                        <td>
                                            <?= $v->title ?>
                                        </td>

                                        <td>
                                            <div class="video-container-admin">

                                                <video class="player-admin" loop preload="metadata">
                                                    <source src="<?= base_url('uploads/videos/' . $v->video) ?>" type="video/mp4">
                                                </video>

                                                <div class="play-overlay-admin">
                                                    <div class="play-button-admin">
                                                        ▶
                                                    </div>
                                                </div>

                                            </div>
                                        </td>

                                        <td>

                                            <a href="<?= base_url('admin/edit_fittv_video/' . $v->id) ?>"
                                                class="btn btn-warning btn-sm">

                                                <i class="bx bx-edit"></i>

                                            </a>

                                            <button type="button"
                                                onclick="confirmDelete('<?= base_url('admin/delete_fittv_video/' . $v->id) ?>')"
                                                class="btn btn-danger btn-sm">

                                                <i class="bx bx-trash"></i>

                                            </button>

                                        </td>

                                    </tr>

                                <?php } ?>

                            <?php } else { ?>

                                <tr>
                                    <td colspan="6" class="text-center text-danger">
                                        No Videos Found
                                    </td>
                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>
                </div>

                <!-- PAGINATION -->

                <div class="d-flex justify-content-center" id="paginationWrapper">

                    <?= $pagination ?? '' ?>

                </div>


            </div>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function fetchResults() {
            var formData = $('#filterForm').serialize();
            var currentUrl = window.location.href.split('?')[0];
            var url = currentUrl + '?' + formData;

            $('#tableBody').css('opacity', '0.5');

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    var newTbody = $(response).find('#tableBody').html();
                    var newPagination = $(response).find('#paginationWrapper').html();

                    if (newTbody === undefined) {
                        // Fallback to reload if parsing fails somehow
                        window.location = url;
                        return;
                    }

                    $('#tableBody').html(newTbody).css('opacity', '1');
                    $('#paginationWrapper').html(newPagination);

                    window.history.pushState({
                        "html": response,
                        "pageTitle": document.title
                    }, "", url);
                },
                error: function() {
                    $('#tableBody').css('opacity', '1');
                }
            });
        }

        window.confirmDelete = function(url) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        };

        var timeout = null;
        $('#searchVideo').on('keyup', function() {
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                fetchResults();
            }, 500);
        });

        $('#genderSelect').on('change', function() {
            fetchResults();
        });

        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            fetchResults();
        });
    });

    document.addEventListener("DOMContentLoaded", function() {

        const containers = document.querySelectorAll('.video-container-admin');
        const videos = [];

        containers.forEach(container => {

            const video = container.querySelector('video');
            const overlay = container.querySelector('.play-overlay-admin');

            videos.push({
                video,
                overlay
            });

            overlay.addEventListener('click', function() {

                videos.forEach(v => {

                    if (v.video !== video) {
                        v.video.pause();
                        v.overlay.classList.remove('hidden');
                    }

                });

                overlay.classList.add('hidden');
                video.play();

            });

            video.addEventListener('pause', function() {
                overlay.classList.remove('hidden');
            });

            video.addEventListener('play', function() {
                overlay.classList.add('hidden');
            });

        });

    });
</script>

<style>
    .page-item.disabled .page-link {
        pointer-events: none;
        opacity: 0.6;
    }

    .page-item.active .page-link,
    .page-item.active>a,
    .pagination .active>a:focus,
    .pagination .active>a:hover,
    .pagination .active>span,
    .pagination .active>span:focus,
    .pagination .active>span:hover {
        background: linear-gradient(135deg, #4f46e5, #6366f1);
        border: none;
        color: #fff;
    }

    .pagination .page-link {
        border-radius: 8px;
        margin: 0 3px;
    }

    .video-container-admin {
        position: relative;
        width: 100%;
        height: 100%;
        border-radius: 8px;
        overflow: hidden;
        background: #000;
    }

    .video-container-admin video {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .play-overlay-admin {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.3);
        cursor: pointer;
    }

    .play-overlay-admin.hidden {
        display: none;
    }

    .play-button-admin {
        width: 50px;
        height: 50px;
        background: #e63946;
        color: white;
        font-size: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>