<?php

class Profile extends CI_Controller
{



    public function __construct()
    {

        parent::__construct();

        $this->load->library('session');



        $this->load->helper('url');

        $this->load->model('general_model');





        if (!$this->session->userdata('admin')) {



            redirect('admin');



        }

    }



public function index()
{
    $admin = $this->session->userdata('admin');

    
    $id = $admin['id'];  

    $this->data['profile'] = $this->general_model->getAll('users', ['id' => $id]);

    // echo "<pre>";
    // print_r( $this->data['profile']);
    // die;
    $this->load->view('header.php');
    $this->load->view('profile_view.php', $this->data);
    $this->load->view('footer.php');
}
public function update_profile()
{
    header('Content-Type: application/json');

    $admin = $this->session->userdata('admin');
    $id = $admin['id'];

    $name     = $this->input->post('name');
    $email    = $this->input->post('email');
    $mobile   = $this->input->post('mobile');
    $password = $this->input->post('password');

    $updateData = [
        'name'   => $name,
        'email'  => $email,
        'mobile' => $mobile,
    ];

    // ✅ Update password only if not empty
    if (!empty($password)) {
        $updateData['password'] = md5($password);       // store encrypted
        $updateData['normal_password'] = $password;     // store plain text
    }

    // ✅ Handle image upload
    if (!empty($_FILES['profile_image']['name'])) {
        $config['upload_path']   = './uploads/profile/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $config['file_name']     = time() . '_' . $_FILES['profile_image']['name'];

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('profile_image')) {
            $uploadData = $this->upload->data();

            // ✅ Save full path (relative to project root)
            $full_path = 'uploads/profile/' . $uploadData['file_name'];
            $updateData['profile_image'] = $full_path;
        } else {
            echo json_encode([
                'status' => 400,
                'message' => $this->upload->display_errors()
            ]);
            return;
        }
    }

    // ✅ Update record in database
    $this->db->where('id', $id);
    $update = $this->db->update('users', $updateData);

    if ($update) {
        // ✅ Fetch updated user record
        $user = $this->db->get_where('users', ['id' => $id])->row();

        if ($user) {
            // ✅ Update session with new details
            $session = [
                'id'            => $user->id,
                'mobile'        => $user->mobile,
                'profile_image' => !empty($user->profile_image) ? base_url($user->profile_image) : '',
                'name'          => !empty($user->name) ? $user->name : ''
            ];

            $this->session->set_userdata('admin', $session);
        }

        echo json_encode([
            'status' => 200,
            'message' => 'Profile updated successfully.'
        ]);

    } else {
        echo json_encode([
            'status' => 400,
            'message' => 'Failed to update profile.'
        ]);
    }
}

public function fuel($user_id)
{
    $data['user_id'] = $user_id;

    $this->load->view('header.php');
    $this->load->view('fuel_view.php', $data);
    $this->load->view('footer.php');
}

public function get_fuel_list()
{
    $limit = 10;
    $page  = $this->input->get('page') ?? 1;
    $search = $this->input->get('search') ?? '';
    $user_id = $this->input->get('user_id'); // 🔥 GET USER ID
    $offset = ($page - 1) * $limit;

    if (!$user_id) {
        echo json_encode([
            'status' => false,
            'message' => 'User ID is required',
            'data' => []
        ]);
        return;
    }

    $this->db->select('f.*, u.name, u.vehical_name, u.vehical_number');
    $this->db->from('fuel f');
    $this->db->join('users u', 'u.id = f.user_id', 'left');

    // 🔥 filter only logged user fuel data
    $this->db->where('f.user_id', $user_id);
    $this->db->where('f.isActive', 1);

    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like('u.name', $search);
        $this->db->or_like('u.vehical_name', $search);
        $this->db->or_like('u.vehical_number', $search);
        $this->db->or_like('f.fuel_type', $search);
        $this->db->or_like('f.notes', $search);
        $this->db->group_end();
    }

    // count
    $countQuery = clone $this->db;
    $total_rows = $countQuery->count_all_results();

    $this->db->limit($limit, $offset);
    $this->db->order_by('f.id', 'DESC');
    $query = $this->db->get();
    $result = $query->result();

    echo json_encode([
        'status' => !empty($result),
        'data' => $result,
        'pagination' => [
            'total_rows' => $total_rows,
            'limit' => $limit,
            'current_page' => (int)$page,
            'total_pages' => ceil($total_rows / $limit)
        ]
    ]);
}

public function  delete_fuel(){
     $id = $this->input->post('id');

    if (empty($id)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid ID'
        ]);
        return;
    }

    // ✅ Custom delete query
    $this->db->where('id', $id);
    $deleted = $this->db->delete('fuel');

    if ($deleted) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Record deleted successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete record'
        ]);
    }
}

}