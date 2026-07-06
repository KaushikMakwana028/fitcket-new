<!--start page wrapper -->

<style>
    input::-webkit-outer-spin-button,

    input::-webkit-inner-spin-button {

        -webkit-appearance: none;

        margin: 0;

    }



    input[type=number] {

        -moz-appearance: textfield;

    }

    /* ===== Profile page enhancements (existing classes untouched, dark mode targets preserved) ===== */

    .profile-section-title {
        display: flex;
        align-items: center;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        color: #6366F1;
        opacity: 0.9;
        margin: 2rem 0 1.1rem;
        padding-bottom: 0.6rem;
        border-bottom: 1px solid rgba(99, 102, 241, 0.15);
    }

    .profile-section-title:first-of-type {
        margin-top: 0;
    }

    .profile-section-title i {
        margin-right: 8px;
        font-size: 1.05rem;
        color: #6366F1;
    }

    [data-bs-theme="dark"] .profile-section-title,
    [data-theme="dark"] .profile-section-title {
        color: #A5B4FC;
        border-bottom-color: rgba(165, 180, 252, 0.18);
    }

    [data-bs-theme="dark"] .profile-section-title i,
    [data-theme="dark"] .profile-section-title i {
        color: #A5B4FC;
    }

    /* ---- Photo panel wrapper (new, additive class — does not replace avatar-upload-wrap) ---- */
    .photo-panel-card {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem 1rem;
        border-radius: 16px;
        background: linear-gradient(180deg, rgba(99, 102, 241, 0.06), rgba(99, 102, 241, 0.02));
        border: 1px dashed rgba(99, 102, 241, 0.25);
    }

    [data-bs-theme="dark"] .photo-panel-card {
        background: linear-gradient(180deg, rgba(99, 102, 241, 0.1), rgba(99, 102, 241, 0.03));
        border-color: rgba(165, 180, 252, 0.25);
    }

    .avatar-upload-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        width: 100%;
    }

    .avatar-circle {
        position: relative;
        width: 128px;
        height: 128px;
        border-radius: 50%;
        overflow: hidden;
        background: rgba(99, 102, 241, 0.08);
        border: 3px solid #ffffff;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25), 0 10px 24px -8px rgba(99, 102, 241, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.85rem;
        flex-shrink: 0;
    }

    [data-bs-theme="dark"] .avatar-circle {
        border-color: #1c1730;
        box-shadow: 0 0 0 3px rgba(165, 180, 252, 0.3), 0 10px 24px -8px rgba(0, 0, 0, 0.5);
    }

    .avatar-circle img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-circle .avatar-placeholder-icon {
        font-size: 3rem;
        opacity: 0.35;
    }

    .avatar-edit-btn {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #6366F1;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 3px 10px rgba(99, 102, 241, 0.5);
        border: 2px solid #fff;
        font-size: 1rem;
        transition: transform 0.15s ease, background 0.15s ease;
    }

    [data-bs-theme="dark"] .avatar-edit-btn {
        border-color: #1c1730;
    }

    .avatar-edit-btn:hover {
        transform: scale(1.08);
        background: #4f46e5;
    }

    .avatar-hint {
        font-size: 0.75rem;
        opacity: 0.6;
        max-width: 160px;
    }

    /* ---- Unique Geographic Coordinates block ---- */
    .coord-block {
        position: relative;
        height: 100%;
        border-radius: 16px;
        padding: 1.2rem 1.25rem 1.3rem;
        background:
            radial-gradient(circle at 8px 8px, rgba(99, 102, 241, 0.16) 1px, transparent 1.4px),
            linear-gradient(135deg, rgba(99, 102, 241, 0.07), rgba(16, 185, 129, 0.06));
        background-size: 16px 16px, 100% 100%;
        border: 1px solid rgba(99, 102, 241, 0.22);
        box-shadow: 0 10px 28px -14px rgba(99, 102, 241, 0.4);
        overflow: hidden;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .coord-block::after {
        content: "";
        position: absolute;
        top: -30px;
        right: -30px;
        width: 110px;
        height: 110px;
        border-radius: 50%;
        border: 1px dashed rgba(99, 102, 241, 0.25);
        pointer-events: none;
    }

    .coord-block.has-coords {
        border-color: rgba(16, 185, 129, 0.4);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    [data-bs-theme="dark"] .coord-block,
    [data-theme="dark"] .coord-block {
        background:
            radial-gradient(circle at 8px 8px, rgba(165, 180, 252, 0.18) 1px, transparent 1.4px),
            linear-gradient(135deg, rgba(99, 102, 241, 0.14), rgba(16, 185, 129, 0.08));
        background-size: 16px 16px, 100% 100%;
        border-color: rgba(165, 180, 252, 0.28);
    }

    .coord-block .coord-heading {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 0.9rem;
    }

    .coord-block .coord-heading .coord-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        font-size: 0.92rem;
        letter-spacing: 0.1px;
        color: #312E81;
    }

    html[data-bs-theme="dark"] .coord-block .coord-heading .coord-title,
    html[data-theme="dark"] .coord-block .coord-heading .coord-title {
        color: #F1F1FE;
    }

    html[data-bs-theme="dark"] .coord-status-note,
    html[data-theme="dark"] .coord-status-note {
        color: #C7D2FE;
        opacity: 0.85;
    }

    /* Compact coordinate icon badge so the title stays balanced */
    .coord-block .coord-title i {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: rgba(99, 102, 241, 0.12);
        color: #4F46E5;
        font-size: 0.95rem;
        position: relative;
        box-shadow: inset 0 0 0 1px rgba(99, 102, 241, 0.22);
    }

    .coord-block.has-coords .coord-title i {
        background: rgba(16, 185, 129, 0.12);
        color: #059669;
        box-shadow: inset 0 0 0 1px rgba(16, 185, 129, 0.28);
    }

    .coord-block.has-coords .coord-title i::before {
        content: none;
    }

    @keyframes coordPulse {
        0% {
            transform: scale(0.85);
            opacity: 0.9;
        }

        100% {
            transform: scale(1.6);
            opacity: 0;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .coord-block.has-coords .coord-title i::before {
            animation: none;
        }
    }

    .coord-pill-row {
        position: relative;
        z-index: 1;
        display: flex;
        gap: 0.7rem;
    }

    .coord-pill {
        flex: 1;
        position: relative;
    }

    .coord-pill span.coord-label {
        position: absolute;
        top: -8px;
        left: 10px;
        background: #fff;
        padding: 0 6px;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.4px;
        opacity: 0.55;
        border-radius: 4px;
        z-index: 2;
    }

    .coord-pill input.form-control {
        font-family: "SFMono-Regular", Consolas, "Liberation Mono", Menlo, monospace;
        font-size: 0.85rem;
        letter-spacing: 0.3px;
        font-variant-numeric: tabular-nums;
    }

    [data-bs-theme="dark"] .coord-pill span.coord-label,
    [data-theme="dark"] .coord-pill span.coord-label {
        background: #111827;
        color: #E0E7FF;
        opacity: 0.9;
    }

    .coord-status-note {
        position: relative;
        z-index: 1;
        margin-top: 0.65rem;
        font-size: 0.72rem;
        opacity: 0.6;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* ---- Polished pill buttons for Fetch Location / Add City ---- */
    #fetchLocationBtn,
    #toggleAddCityBtn {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 34px;
        padding: 0.45rem 1rem !important;
        font-size: 0.79rem !important;
        font-weight: 700;
        line-height: 1;
        border-radius: 999px !important;
        border: 1px solid rgba(99, 102, 241, 0.35) !important;
        color: #ffffff !important;
        background: linear-gradient(135deg, #6366F1, #4F46E5) !important;
        box-shadow: 0 8px 18px -10px rgba(79, 70, 229, 0.85);
        transition: transform 0.15s ease, box-shadow 0.15s ease, filter 0.15s ease;
    }

    #fetchLocationBtn i,
    #toggleAddCityBtn i {
        margin-right: 0 !important;
        font-size: 0.9rem;
    }

    #fetchLocationBtn:hover,
    #toggleAddCityBtn:hover {
        color: #ffffff !important;
        transform: translateY(-1px);
        filter: brightness(1.05);
        box-shadow: 0 12px 24px -12px rgba(79, 70, 229, 0.95);
    }

    #fetchLocationBtn:active,
    #toggleAddCityBtn:active {
        transform: translateY(0);
    }

    html[data-bs-theme="dark"] #fetchLocationBtn,
    html[data-bs-theme="dark"] #toggleAddCityBtn,
    html[data-theme="dark"] #fetchLocationBtn,
    html[data-theme="dark"] #toggleAddCityBtn {
        border-color: rgba(199, 210, 254, 0.35) !important;
        color: #ffffff !important;
        background: linear-gradient(135deg, #818CF8, #5B5FEF) !important;
        box-shadow: 0 10px 22px -12px rgba(129, 140, 248, 0.95);
    }

    html[data-bs-theme="dark"] #fetchLocationBtn:hover,
    html[data-bs-theme="dark"] #toggleAddCityBtn:hover,
    html[data-theme="dark"] #fetchLocationBtn:hover,
    html[data-theme="dark"] #toggleAddCityBtn:hover {
        color: #ffffff !important;
    }

    @media (max-width: 575.98px) {

        #fetchLocationBtn,
        #toggleAddCityBtn {
            padding: 0.35rem 0.8rem !important;
            font-size: 0.74rem !important;
        }
    }

    /* ---- Select2 tag fields: Languages & Availability in City ---- */
    #js-example-basic-multiple+.select2-container,
    #citySelect+.select2-container {
        width: 100% !important;
    }

    #js-example-basic-multiple+.select2-container .select2-selection--multiple,
    #citySelect+.select2-container .select2-selection--multiple {
        min-height: 44px;
        padding: 4px 8px;
        border-radius: 8px;
        background-color: #ffffff !important;
        border: 1px solid #CBD5E1 !important;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
    }

    #js-example-basic-multiple+.select2-container .select2-selection__rendered,
    #citySelect+.select2-container .select2-selection__rendered {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
        padding: 0 !important;
    }

    #js-example-basic-multiple+.select2-container .select2-selection__choice,
    #citySelect+.select2-container .select2-selection__choice {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin: 0 !important;
        padding: 5px 10px 5px 8px !important;
        border-radius: 7px !important;
        background: #EEF2FF !important;
        border: 1px solid #C7D2FE !important;
        color: #312E81 !important;
        font-size: 0.88rem;
        font-weight: 600;
    }

    #js-example-basic-multiple+.select2-container .select2-selection__choice__remove,
    #citySelect+.select2-container .select2-selection__choice__remove,
    #js-example-basic-multiple+.select2-container .select2-selection__clear,
    #citySelect+.select2-container .select2-selection__clear {
        border-right: 0 !important;
        color: #4F46E5 !important;
        margin-right: 0 !important;
        padding-right: 0 !important;
        position: static !important;
    }

    #js-example-basic-multiple+.select2-container .select2-search__field,
    #citySelect+.select2-container .select2-search__field {
        min-height: 29px;
        margin: 0 !important;
        color: #0F172A !important;
    }

    html[data-bs-theme="dark"] #js-example-basic-multiple+.select2-container .select2-selection--multiple,
    html[data-bs-theme="dark"] #citySelect+.select2-container .select2-selection--multiple,
    html[data-theme="dark"] #js-example-basic-multiple+.select2-container .select2-selection--multiple,
    html[data-theme="dark"] #citySelect+.select2-container .select2-selection--multiple {
        background-color: #1F2937 !important;
        border-color: rgba(148, 163, 184, 0.35) !important;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.03);
    }

    html[data-bs-theme="dark"] #js-example-basic-multiple+.select2-container .select2-selection__choice,
    html[data-bs-theme="dark"] #citySelect+.select2-container .select2-selection__choice,
    html[data-theme="dark"] #js-example-basic-multiple+.select2-container .select2-selection__choice,
    html[data-theme="dark"] #citySelect+.select2-container .select2-selection__choice {
        background: rgba(99, 102, 241, 0.22) !important;
        border-color: rgba(165, 180, 252, 0.35) !important;
        color: #F8FAFC !important;
    }

    html[data-bs-theme="dark"] #js-example-basic-multiple+.select2-container .select2-selection__choice__remove,
    html[data-bs-theme="dark"] #citySelect+.select2-container .select2-selection__choice__remove,
    html[data-bs-theme="dark"] #js-example-basic-multiple+.select2-container .select2-search__field,
    html[data-bs-theme="dark"] #citySelect+.select2-container .select2-search__field,
    html[data-bs-theme="dark"] #js-example-basic-multiple+.select2-container .select2-selection__clear,
    html[data-bs-theme="dark"] #citySelect+.select2-container .select2-selection__clear,
    html[data-theme="dark"] #js-example-basic-multiple+.select2-container .select2-selection__choice__remove,
    html[data-theme="dark"] #citySelect+.select2-container .select2-selection__choice__remove,
    html[data-theme="dark"] #js-example-basic-multiple+.select2-container .select2-search__field,
    html[data-theme="dark"] #citySelect+.select2-container .select2-search__field,
    html[data-theme="dark"] #js-example-basic-multiple+.select2-container .select2-selection__clear,
    html[data-theme="dark"] #citySelect+.select2-container .select2-selection__clear {
        color: #E0E7FF !important;
    }

    html[data-bs-theme="dark"] .select2-dropdown,
    html[data-theme="dark"] .select2-dropdown {
        background-color: #1F2937 !important;
        border-color: rgba(148, 163, 184, 0.35) !important;
        color: #E5E7EB !important;
    }

    html[data-bs-theme="dark"] .select2-results__option,
    html[data-theme="dark"] .select2-results__option {
        color: #E5E7EB !important;
    }

    html[data-bs-theme="dark"] .select2-container--default .select2-results__option--highlighted[aria-selected],
    html[data-bs-theme="dark"] .select2-container--bootstrap-5 .select2-results__option--highlighted,
    html[data-theme="dark"] .select2-container--default .select2-results__option--highlighted[aria-selected],
    html[data-theme="dark"] .select2-container--bootstrap-5 .select2-results__option--highlighted {
        background-color: #6366F1 !important;
        color: #ffffff !important;
    }

    html[data-bs-theme="dark"] .select2-container--default .select2-results__option[aria-selected="true"],
    html[data-theme="dark"] .select2-container--default .select2-results__option[aria-selected="true"] {
        background-color: rgba(99, 102, 241, 0.35) !important;
    }

    /* Choices.js */
    html[data-bs-theme="dark"] .choices__inner,
    html[data-bs-theme="dark"] .choices__list--dropdown {
        background-color: #191527 !important;
        border-color: rgba(165, 180, 252, 0.35) !important;
        color: #E0E7FF !important;
    }

    html[data-bs-theme="dark"] .choices__list--dropdown .choices__item--selectable.is-highlighted {
        background-color: #6366F1 !important;
        color: #ffffff !important;
    }

    html[data-bs-theme="dark"] .choices__input {
        background-color: transparent !important;
        color: #E0E7FF !important;
    }

    /* Tom Select / Selectize */
    html[data-bs-theme="dark"] .ts-control,
    html[data-bs-theme="dark"] .ts-dropdown {
        background-color: #191527 !important;
        border-color: rgba(165, 180, 252, 0.35) !important;
        color: #E0E7FF !important;
    }

    /* City add card refinement (kept classes, just tightened) */
    #addCityCard {
        border-radius: 12px;
    }

    [data-bs-theme="dark"] #addCityCard,
    [data-theme="dark"] #addCityCard {
        background-color: #191527 !important;
        border-color: rgba(165, 180, 252, 0.25) !important;
    }

    [data-bs-theme="dark"] #addCityCard .card-title,
    [data-theme="dark"] #addCityCard .card-title {
        color: #E0E7FF;
    }

    /* Section wrapper spacing for consistent rhythm */
    .profile-field-group {
        margin-bottom: 0.25rem;
    }

    .profile-field-group label.form-label {
        font-size: 0.82rem;
        font-weight: 600;
        opacity: 0.85;
    }

    /* Mobile responsiveness fine-tuning */
    @media (max-width: 991.98px) {
        .photo-panel-card {
            padding: 1.35rem 1rem;
            margin-bottom: 0.5rem;
        }
    }

    @media (max-width: 767.98px) {
        .avatar-circle {
            width: 100px;
            height: 100px;
        }

        .profile-section-title {
            margin: 1.5rem 0 0.85rem;
        }

        .coord-pill-row {
            flex-direction: column;
            gap: 1.1rem;
        }

        .card-body.p-4 {
            padding: 1.15rem !important;
        }

        .col-12.d-flex.justify-content-end {
            justify-content: stretch !important;
            flex-direction: column-reverse;
        }

        .col-12.d-flex.justify-content-end .btn {
            width: 100%;
        }
    }

    @media (max-width: 575.98px) {
        .photo-panel-card {
            border-radius: 14px;
        }

        .coord-block {
            padding: 1rem;
        }
    }
</style>

<div class="page-wrapper">

    <div class="page-content">



        <!-- Breadcrumb -->

        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">

            <div class="ps-3">

                <nav aria-label="breadcrumb">

                    <ol class="breadcrumb mb-0 p-0">

                        <li class="breadcrumb-item"><a href="<?= base_url('provider/dashboard'); ?>"><i
                                    class="bx bx-home-alt"></i></a></li>

                        <li class="breadcrumb-item active" aria-current="page">Profile</li>

                    </ol>

                </nav>

            </div>

        </div>



        <!-- Card -->

        <div class="card">

            <div class="card-body p-4">

                <h5 class="card-title mb-4">Profile</h5>

                <form id="ProfileForm" method="post" enctype="multipart/form-data" novalidate>

                    <!-- ===== Section: Photo + Identity ===== -->

                    <div class="row g-3">

                        <div class="col-12 col-lg-3">

                            <div class="photo-panel-card">

                                <div class="avatar-upload-wrap">

                                    <div class="avatar-circle" id="avatarCircle">

                                        <?php if (!empty($profile->profile_image)): ?>
                                            <img id="previewImage" src="<?= base_url($profile->profile_image) ?>" alt="Profile Preview">
                                        <?php else: ?>
                                            <img id="previewImage" src="" alt="Profile Preview" style="display:none;">
                                            <i class="bx bx-user avatar-placeholder-icon" id="avatarPlaceholderIcon"></i>
                                        <?php endif; ?>

                                        <label for="profileImageInput" class="avatar-edit-btn" title="Change photo">
                                            <i class="bx bx-camera"></i>
                                        </label>

                                    </div>

                                    <input type="file" class="form-control d-none" name="profile_image" id="profileImageInput"
                                        accept="image/*">

                                    <div class="avatar-hint">Click the camera icon to update your photo</div>

                                </div>

                            </div>

                        </div>

                        <div class="col-12 col-lg-9">

                            <div class="row g-3">

                                <div class="col-12 col-sm-6 profile-field-group">

                                    <label class="form-label">Partner First Name</label>

                                    <input type="text" class="form-control" name="first_name"
                                        value="<?= isset($provider->name) ? explode(' ', $provider->name)[0] : '' ?>"
                                        placeholder="Enter First Name" required>

                                    <input type="hidden" name="id" value="<?= isset($provider->id) ? $provider->id : '' ?>">

                                </div>

                                <div class="col-12 col-sm-6 profile-field-group">

                                    <label class="form-label">Partner Last Name</label>

                                    <input type="text" class="form-control" name="last_name"
                                        value="<?= isset($provider->name) && isset(explode(' ', $provider->name)[1]) ? explode(' ', $provider->name)[1] : '' ?>"
                                        placeholder="Enter Last Name" required>

                                </div>

                                <div class="col-12 col-sm-6 profile-field-group">

                                    <label class="form-label">Business Name</label>

                                    <input type="text" class="form-control" name="gym_name"
                                        value="<?= $provider->gym_name ?? '' ?>" placeholder="Enter Business Name" required>

                                </div>

                                <div class="col-12 col-sm-6 profile-field-group">

                                    <label class="form-label">Partner Mobile</label>

                                    <input type="text" class="form-control" name="mobile" value="<?= $provider->mobile ?? '' ?>"
                                        placeholder="Enter Mobile Number" required>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- ===== Section: Contact ===== -->

                    <div class="profile-section-title"><i class="bx bx-envelope"></i>Contact</div>

                    <div class="row g-3">

                        <div class="col-12 col-md-6 profile-field-group">

                            <label class="form-label">Partner Email</label>

                            <input type="email" class="form-control" name="email" value="<?= $provider->email ?? '' ?>"
                                placeholder="Enter Email" required>

                        </div>

                        <div class="col-12 col-md-6 profile-field-group">

                            <label class="form-label">Business Description</label>

                            <textarea class="form-control" name="description" rows="1" placeholder="Enter Description"
                                required><?= $profile->description ?? '' ?></textarea>

                        </div>

                    </div>

                    <!-- ===== Section: Service Details ===== -->

                    <div class="profile-section-title"><i class="bx bx-briefcase"></i>Service Details</div>

                    <div class="row g-3">

                        <div class="col-12 col-md-6 col-lg-4 profile-field-group">

                            <label class="form-label">Service Type</label>

                            <select class="form-control" name="service_type" required>
                                <option value="">Select Service Type</option>
                                <option value="online" <?= (isset($profile->service_type) && $profile->service_type == 'online') ? 'selected' : '' ?>>
                                    Online
                                </option>
                                <option value="offline" <?= (isset($profile->service_type) && $profile->service_type == 'offline') ? 'selected' : '' ?>>
                                    Offline
                                </option>
                                <option value="both" <?= (isset($profile->service_type) && $profile->service_type == 'both') ? 'selected' : '' ?>>
                                    Both
                                </option>
                            </select>

                        </div>

                        <div class="col-12 col-md-6 col-lg-4 profile-field-group">

                            <label class="form-label">Experience(Years)</label>

                            <input type="text" class="form-control" name="exp" value="<?= $profile->exp ?? '' ?>"
                                placeholder="Enter Experience" required>

                        </div>

                        <?php
                        $selectedLanguages = [];

                        if (isset($profile->language) && !empty($profile->language)) {
                            // Convert to lowercase + trim spaces
                            $selectedLanguages = array_map(
                                'strtolower',
                                array_map('trim', explode(',', $profile->language))
                            );
                        }
                        ?>

                        <div class="col-12 col-md-6 col-lg-4 profile-field-group">
                            <label class="form-label">Languages</label>

                            <select class="form-select"
                                id="js-example-basic-multiple"
                                name="language[]"
                                multiple="multiple"
                                required>

                                <option value="hindi" <?= in_array('hindi', $selectedLanguages) ? 'selected' : '' ?>>Hindi</option>
                                <option value="marathi" <?= in_array('marathi', $selectedLanguages) ? 'selected' : '' ?>>Marathi</option>
                                <option value="gujarati" <?= in_array('gujarati', $selectedLanguages) ? 'selected' : '' ?>>Gujarati</option>
                                <option value="telugu" <?= in_array('telugu', $selectedLanguages) ? 'selected' : '' ?>>Telugu</option>
                                <option value="kannada" <?= in_array('kannada', $selectedLanguages) ? 'selected' : '' ?>>Kannada</option>
                                <option value="english" <?= in_array('english', $selectedLanguages) ? 'selected' : '' ?>>English</option>

                            </select>
                        </div>

                        <div class="col-12 col-md-6 profile-field-group">

                            <label class="form-label">Select Category</label>

                            <select name="category" id="categorySelect" class="form-select" required>

                                <option value="">-- Select Category --</option>

                                <?php foreach ($categories as $cat): ?>

                                    <option value="<?= $cat->id ?>" <?= isset($profile->category) && $profile->category == $cat->id ? 'selected' : '' ?>>

                                        <?= $cat->name ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="col-12 col-md-6 profile-field-group" id="subcategoryWrapper" style="display: none;">

                            <label class="form-label">Select Sub Category</label>

                            <select name="subcategory" id="subcategorySelect" class="form-select" required>

                                <option value="">-- Select Subcategory --</option>

                            </select>

                        </div>
                        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

                        <script>
                            // After subcategories are loaded via AJAX based on category, set selected value if present in PHP

                            $(function() {

                                <?php if (!empty($profile->sub_category)): ?>

                                    // Wait for AJAX to populate subcategory select, then set the value

                                    setTimeout(function() {

                                        $('#subcategorySelect').val('<?= $profile->sub_category ?>');

                                    }, 500); // adjust timing as per your AJAX implementation

                                <?php endif; ?>

                            });
                        </script>

                        <div class="col-12 profile-field-group">

                            <label class="form-label">Expertise Tags</label>

                            <?php

                            $tags = '';

                            if (!empty($expertis)) {

                                $tags = implode(',', array_map(function ($row) {
                                    return $row->tag;
                                }, $expertis));
                            }

                            ?>

                            <input type="text" id="expertiseTags" class="form-control" name="expertise_tags"
                                value="<?= htmlspecialchars($tags) ?>" placeholder="Enter tags" required>

                        </div>

                    </div>

                    <!-- ===== Section: Location ===== -->

                    <div class="profile-section-title"><i class="bx bx-map"></i>Location</div>

                    <div class="row g-3">

                        <div class="col-12 col-lg-6 profile-field-group">

                            <label for="address" class="form-label">Address</label>

                            <textarea class="form-control" id="address" name="address" rows="3"
                                placeholder="Enter full address With City And State" required><?= isset($profile->address) && !empty($profile->address) ? htmlspecialchars($profile->address) : '' ?></textarea>

                        </div>

                        <div class="col-12 col-lg-6 profile-field-group">

                            <?php $hasCoords = !empty($profile->latitude) && !empty($profile->longitude); ?>

                            <div class="coord-block<?= $hasCoords ? ' has-coords' : '' ?>" id="coordBlock">

                                <div class="coord-heading">

                                    <div class="coord-title"><i class="bx bx-current-location"></i>Geographic Coordinates</div>

                                    <button type="button" class="btn btn-sm btn-outline-primary" id="fetchLocationBtn">
                                        <i class="fas fa-map-marker-alt me-1"></i>Fetch Location
                                    </button>

                                </div>

                                <div class="coord-pill-row">

                                    <div class="coord-pill">
                                        <span class="coord-label">LATITUDE</span>
                                        <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude"
                                            value="<?= isset($profile->latitude) ? htmlspecialchars($profile->latitude) : '' ?>" readonly>
                                    </div>

                                    <div class="coord-pill">
                                        <span class="coord-label">LONGITUDE</span>
                                        <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude"
                                            value="<?= isset($profile->longitude) ? htmlspecialchars($profile->longitude) : '' ?>" readonly>
                                    </div>

                                </div>

                                <div class="coord-status-note" id="coordStatusNote">
                                    <i class="bx bx-<?= $hasCoords ? 'check-circle' : 'info-circle' ?>"></i>
                                    <span><?= $hasCoords ? 'Location pinned for this profile' : 'No location pinned yet — fetch it from your center' ?></span>
                                </div>

                            </div>

                        </div>

                        <div class="col-12 profile-field-group">

                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label mb-0">Availability in City</label>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="toggleAddCityBtn">
                                    <i class="fas fa-plus-circle me-1"></i>Add City
                                </button>
                            </div>

                            <?php

                            $selected_cities = isset($profile->city) ? explode(',', $profile->city) : [];

                            ?>

                            <select name="availability[]" id="citySelect" class="form-select" multiple required>

                                <?php foreach ($city as $c): ?>

                                    <option value="<?= $c->city ?>" <?= in_array($c->city, $selected_cities) ? 'selected' : '' ?>>

                                        <?= $c->city ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                            <div class="card mt-2 d-none" id="addCityCard" style="border: 1px solid rgba(0,0,0,0.1); background-color: #f8f9fa;">
                                <div class="card-body p-3">
                                    <h6 class="card-title mb-3" style="font-size: 0.9rem; font-weight: 600;">Add New City to System</h6>

                                    <div class="row g-2">

                                        <div class="col-md-6 mb-2">
                                            <label class="form-label" style="font-size: 0.8rem;">State</label>
                                            <select id="new_state_select" class="form-select" style="width: 100%;">
                                                <option value="">Select State</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <label class="form-label" style="font-size: 0.8rem;">City</label>
                                            <select id="new_city_select" class="form-select" style="width: 100%;">
                                                <option value="">Select City</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-sm btn-secondary" id="cancelAddCityBtn">Cancel</button>
                                        <button type="button" class="btn btn-sm btn-primary" id="saveNewCityBtn">Add</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- ===== Section: Pricing ===== -->

                    <div class="profile-section-title"><i class="bx bx-rupee"></i>Pricing</div>

                    <div class="row g-3">

                        <div class="col-6 col-md-3 profile-field-group">

                            <label class="form-label">1 Day Price</label>

                            <input type="number" class="form-control" name="price_day"
                                value="<?= $profile->day_price ?? '' ?>" required>

                        </div>

                        <div class="col-6 col-md-3 profile-field-group">

                            <label class="form-label">1 Week Price</label>

                            <input type="number" class="form-control" name="price_week"
                                value="<?= $profile->week_price ?? '' ?>" required>

                        </div>

                        <div class="col-6 col-md-3 profile-field-group">

                            <label class="form-label">1 Month Price</label>

                            <input type="number" class="form-control" name="price_month"
                                value="<?= $profile->month_price ?? '' ?>" required>

                        </div>

                        <div class="col-6 col-md-3 profile-field-group">

                            <label class="form-label">1 Year Price</label>

                            <input type="number" class="form-control" name="price_year"
                                value="<?= $profile->year_price ?? '' ?>" required>

                        </div>

                    </div>

                    <!-- Submit Buttons -->

                    <div class="col-12 d-flex justify-content-end gap-2 mt-4">

                        <button type="submit" class="btn btn-success">✅ Update</button>

                        <a href="<?= base_url('provider/dashboard'); ?>" class="btn btn-danger">❌ Cancel</a>

                    </div>

                </form>



            </div>

        </div>



    </div>

</div>

<!--end page wrapper -->
<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>

<script>
    $(document).ready(function() {

        // Live avatar preview on file select
        $('#profileImageInput').on('change', function(e) {
            const file = e.target.files && e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    $('#avatarPlaceholderIcon').hide();
                    $('#previewImage').attr('src', ev.target.result).show();
                };
                reader.readAsDataURL(file);
            }
        });

        function loadSubcategories(categoryId, selectedSubcat = null) {
            if (categoryId) {
                $.ajax({
                    url: site_url + "provider/profile/get_subcategories",
                    type: "POST",
                    data: {
                        category_id: categoryId
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data.length > 0) {
                            let options = '<option value="">-- Select Subcategory --</option>';
                            $.each(data, function(i, subcat) {
                                options += `<option value="${subcat.id}">${subcat.name}</option>`;
                            });
                            $("#subcategorySelect").html(options);
                            $("#subcategoryWrapper").show();

                            if (selectedSubcat) {
                                $("#subcategorySelect").val(selectedSubcat);
                            }
                        } else {
                            $("#subcategoryWrapper").hide();
                            $("#subcategorySelect").html("");
                        }
                    },
                });
            } else {
                $("#subcategoryWrapper").hide();
                $("#subcategorySelect").html("");
            }
        }

        // On category change
        $("#categorySelect").on("change", function() {
            let categoryId = $(this).val();
            loadSubcategories(categoryId);
        });

        // On edit page load: if profile already has category + subcategory
        <?php if (!empty($profile->category)): ?>
            loadSubcategories("<?= $profile->category ?>", "<?= $profile->sub_category ?>");
        <?php endif; ?>

        // Auto-detect and select city based on address geocoding
        $('#address').on('blur', function() {
            const address = $(this).val().trim();
            if (address.length > 3) {
                $.ajax({
                    url: `https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&q=${encodeURIComponent(address)}`,
                    type: 'GET',
                    headers: {
                        'User-Agent': 'FitTicketApp/1.0'
                    },
                    success: function(data) {
                        if (data && data.length > 0) {
                            const addrObj = data[0].address;
                            const cityResolved = addrObj.city || addrObj.town || addrObj.state_district || addrObj.county || addrObj.village || addrObj.suburb || "";
                            if (cityResolved) {
                                const trimmedCity = cityResolved.trim();
                                let optionExists = false;
                                let existingVal = "";
                                $('#citySelect option').each(function() {
                                    if ($(this).text().trim().toLowerCase() === trimmedCity.toLowerCase()) {
                                        optionExists = true;
                                        existingVal = $(this).val();
                                    }
                                });

                                if (optionExists) {
                                    let currentVals = $('#citySelect').val() || [];
                                    if (!currentVals.includes(existingVal)) {
                                        currentVals.push(existingVal);
                                        $('#citySelect').val(currentVals).trigger('change');
                                    }
                                } else {
                                    const newOption = new Option(trimmedCity, trimmedCity, true, true);
                                    $('#citySelect').append(newOption).trigger('change');
                                }
                            }
                        }
                    },
                    error: function(xhr) {
                        console.error('Error auto-resolving city:', xhr);
                    }
                });
            }
        });

        // Fetch Current Location Coordinates
        $('#fetchLocationBtn').on('click', function() {
            const hasCoords = $('#latitude').val() && $('#longitude').val();

            if (hasCoords) {
                Swal.fire({
                    title: 'Update Location?',
                    text: 'Your profile already has saved coordinates. Do you want to update your location?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Update',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#6366F1',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        triggerGeolocation();
                    }
                });
            } else {
                Swal.fire({
                    title: 'Fetch Location',
                    text: 'Please make sure you are at the physical location of your Gym/Trainer center so we can fetch your exact coordinates.',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Okay',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#6366F1'
                }).then((result) => {
                    if (result.isConfirmed) {
                        triggerGeolocation();
                    }
                });
            }
        });

        function triggerGeolocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;
                        $('#latitude').val(lat);
                        $('#longitude').val(lon);

                        // Visually mark the coordinate card as pinned
                        $('#coordBlock').addClass('has-coords');
                        $('#coordStatusNote').html('<i class="bx bx-check-circle"></i><span>Location pinned for this profile</span>');

                        Swal.fire({
                            title: 'Success!',
                            text: 'Location coordinates fetched successfully! Please click Save to update your profile.',
                            icon: 'success',
                            confirmButtonColor: '#6366F1'
                        });
                    },
                    function(error) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Permission denied or location unavailable. Please enable browser location permissions.',
                            icon: 'error',
                            confirmButtonColor: '#6366F1'
                        });
                    }
                );
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Geolocation is not supported by your browser.',
                    icon: 'error',
                    confirmButtonColor: '#6366F1'
                });
            }
        }

        // Initialize Select2 on the new card selects
        $("#new_state_select").select2({
            placeholder: "Select State",
            allowClear: true,
            width: "100%",
            theme: "bootstrap-5",
            dropdownParent: $("#addCityCard")
        });

        $("#new_city_select").select2({
            placeholder: "Select City",
            allowClear: true,
            width: "100%",
            theme: "bootstrap-5",
            dropdownParent: $("#addCityCard")
        });

        // Toggle card visibility
        $("#toggleAddCityBtn").on("click", function() {
            $("#addCityCard").toggleClass("d-none");
            if ($("#new_state_select option").length <= 1) {
                loadGeonamesStates();
            }
        });

        $("#cancelAddCityBtn").on("click", function() {
            $("#addCityCard").addClass("d-none");
        });

        const providerStateCodeMap = {};

        function loadGeonamesStates() {
            $.ajax({
                url: "https://secure.geonames.org/childrenJSON",
                method: "GET",
                data: {
                    geonameId: 1269750, // India
                    username: "rvmawar",
                },
                success: function(response) {
                    if (response && response.geonames) {
                        response.geonames.forEach(function(state) {
                            const name = state.name;
                            const code = state.adminCode1;
                            providerStateCodeMap[name] = code;
                            $("#new_state_select").append(`<option value="${name}">${name}</option>`);
                        });
                        $("#new_state_select").trigger('change');
                    }
                }
            });
        }

        // On state change, fetch cities strictly by adminCode1
        $("#new_state_select").on("change", function() {
            const selectedState = $(this).val();
            const adminCode1 = providerStateCodeMap[selectedState];

            if (adminCode1) {
                $.ajax({
                    url: "https://secure.geonames.org/searchJSON",
                    method: "GET",
                    data: {
                        country: "IN",
                        adminCode1: adminCode1,
                        featureClass: "P",
                        maxRows: 1000,
                        username: "rvmawar",
                    },
                    success: function(response) {
                        $("#new_city_select").empty().append('<option value="">Select City</option>');
                        if (response && response.geonames) {
                            response.geonames.forEach(function(city) {
                                $("#new_city_select").append(`<option value="${city.name}">${city.name}</option>`);
                            });
                            $("#new_city_select").trigger('change');
                        }
                    }
                });
            } else {
                $("#new_city_select").empty().append('<option value="">Select City</option>').trigger('change');
            }
        });

        // Save new city AJAX
        $("#saveNewCityBtn").on("click", function() {
            const state = $("#new_state_select").val();
            const city = $("#new_city_select").val();

            if (!state || !city) {
                alert("Please select both State and City");
                return;
            }

            $.ajax({
                url: site_url + "provider/profile/add_city_ajax",
                method: "POST",
                data: {
                    state: state,
                    city: city
                },
                dataType: "json",
                success: function(response) {
                    if (response && response.success) {
                        const optionText = response.city;
                        let optionExists = false;
                        $('#citySelect option').each(function() {
                            if ($(this).text().trim().toLowerCase() === optionText.toLowerCase()) {
                                optionExists = true;
                            }
                        });

                        if (!optionExists) {
                            const newOpt = new Option(optionText, optionText, true, true);
                            $('#citySelect').append(newOpt).trigger('change');
                        } else {
                            let currentVals = $('#citySelect').val() || [];
                            if (!currentVals.includes(optionText)) {
                                currentVals.push(optionText);
                                $('#citySelect').val(currentVals).trigger('change');
                            }
                        }

                        $("#addCityCard").addClass("d-none");
                        $("#new_state_select").val("").trigger("change");
                        $("#new_city_select").empty().append('<option value="">Select City</option>').trigger("change");
                    } else {
                        alert(response.message || "Failed to add city.");
                    }
                },
                error: function() {
                    alert("Something went wrong while adding the city.");
                }
            });
        });
    });
</script>