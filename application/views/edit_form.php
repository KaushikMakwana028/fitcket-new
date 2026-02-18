 <style>
        /* * { margin: 0; padding: 0; box-sizing: border-box; } */

        .main-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: auto;
            padding: 30px 20px;
        }

        .section-header { text-align: center; margin-bottom: 30px; }
        .section-header h2 { font-size: 2rem; font-weight: 700; }
        .section-header p { color: #6b7280; font-size: 1.1rem; }

        .form-container {
            background: #f9fafb;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #e5e7eb;
            margin-bottom: 10px;
        }

        .profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid rgba(79,70,229,0.2);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    margin: 0 auto 15px;   /* Center horizontally */
    display: block;        /* Ensure block element */
    transition: transform 0.3s ease;
}


        .profile-avatar:hover { transform: scale(1.05); }

        .form-group { margin-bottom: 20px; }
        .form-group label { font-weight: 600; display: block; margin-bottom: 8px; }
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: #4f46e5;
            outline: none;
            box-shadow: 0 0 8px rgba(79,70,229,0.2);
        }

        .submit-btn, .back-btn {
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .submit-btn {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(79,70,229,0.3);
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79,70,229,0.4);
            background: linear-gradient(135deg, #7c3aed, #4f46e5);
        }

        .back-btn {
            background: none;
            border: 2px solid #e5e7eb;
            color: #374151;
            text-decoration: none;
        }

        @media (max-width: 576px) {
            body { padding: 8px; }
            .main-container { border-radius: 12px; padding: 20px 15px; }
            .section-header h2 { font-size: 1.5rem; }
        }
    </style>
    <div class="main-container mt-5 mb-5">
    <div class="section-header">
        <h2>Edit Profile</h2>
        <p>Update your personal information and preferences</p>
    </div>

    <div class="form-container">
        

        <form id="user_profile_form" method="post" enctype="multipart/form-data">
            <div class="text-center mb-4">
            <img src="<?= !empty($user->profile_image) ? base_url($user->profile_image) : base_url('assets/images/9334234.jpg') ?>"
                 alt="Profile Picture" class="profile-avatar">
            <input type="file" accept="image/*" id="profile-picture" name="profile_image" style="display: none;">
            <label for="profile-picture" class="submit-btn"><i class="bi bi-camera"></i> Change Picture</label>
        </div>
            <!-- Hidden ID field -->
            <input type="hidden" name="id" value="<?= $user->id ?? '' ?>">

            <div class="form-group">
                <label for="full-name">Full Name</label>
                <input type="text" id="full-name" name="name" 
                       value="<?= $user->name ?? '' ?>" 
                       placeholder="Enter your full name">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" 
                       value="<?= $user->email ?? '' ?>" 
                       placeholder="Enter your email">
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="mobile" 
                       value="<?= $user->mobile ?? '' ?>" 
                       placeholder="Enter your phone number">
            </div>

            <div class="text-center">
                <button class="submit-btn" type="submit">
                    <i class="bi bi-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
