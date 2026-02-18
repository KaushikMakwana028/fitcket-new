<?php

class Driver extends CI_Controller
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
    // Load active companies (if you want dropdown or reference later)
    $this->data['companies'] = $this->general_model->getAll('company', ['isActive' => 1]);

    $this->load->view('header.php');
    $this->load->view('driver_view.php', $this->data);
    $this->load->view('footer.php');
}

public function fetch_drivers()
{
    $limit = 10;
    $page = $this->input->post('page') ?? 1;
    $search = trim($this->input->post('search'));
    $offset = ($page - 1) * $limit;

    // Base query with JOIN to get company name
    $this->db->select('users.*, company.company_name');
    $this->db->from('users');
    $this->db->join('company', 'company.id = users.company_id', 'left');
    $this->db->where('users.role', 0);

    if (!empty($search)) {
        $this->db->group_start()
                 ->like('users.name', $search)
                 ->or_like('users.mobile', $search)
                 ->group_end();
    }

    // Clone for count
    $clone = clone $this->db;
    $total = $clone->count_all_results();

    // Pagination
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    $drivers = $query->result_array();

    $total_pages = ceil($total / $limit);

    echo json_encode([
        'drivers' => $drivers,
        'total_pages' => $total_pages,
        'current_page' => (int)$page,
    ]);
}
public function toggle_status()
{
    $id = $this->input->post('id');
    $status = $this->input->post('isActive');

    $update = $this->general_model->update('users',['id' => $id], ['isActive' => $status]);
    if($update) {
        echo json_encode(['status' => 'success', 'message' => $status == 1 ? 'Driver activated' : 'Driver deactivated']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Unable to update status']);
    }
}

public function add_driver()
{


    $data['companies'] = $this->general_model->getAll('company', ['isActive' => 1]);

//    echo "<pre>";
//    print_r( $data['companies']);
//    die;

    $this->load->view('header');
    $this->load->view('driver_form', $data);
    $this->load->view('footer');
}


  public function save_driver()
{
    $driver_name     = $this->input->post('driver_name', true);
    $mobile          = $this->input->post('mobile', true);
    $email           = $this->input->post('email', true);
    $location        = $this->input->post('location', true);
    $company_id      = $this->input->post('company_id', true);
    $vehicle_name    = $this->input->post('vehicle_name', true);
    $vehicle_number  = $this->input->post('vehicle_number', true);
    $licence_number  = $this->input->post('licence_number', true);
    $password        = $this->input->post('password', true);

    if (empty($driver_name) || empty($mobile) || empty($company_id) || empty($vehicle_name) || empty($vehicle_number) || empty($password)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'All fields are required.'
        ]);
        return;
    }

    // ✅ Check duplicate mobile
    $existing_driver = $this->general_model->getOne('users', ['mobile' => $mobile]);
    if (!empty($existing_driver)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'A driver with this mobile number already exists.'
        ]);
        return;
    }

    // ✅ Profile image upload
    $profile_image = null;
    if (!empty($_FILES['profile_image']['name'])) {

        $upload_path = './uploads/drivers/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048; // 2 MB
        $config['file_name']     = 'driver_' . time() . '_' . rand(1000, 9999);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('profile_image')) {
            $upload_data   = $this->upload->data();

            // ✅ Save the full relative path (without base_url)
            $profile_image = 'uploads/drivers/' . $upload_data['file_name'];

        } else {
            echo json_encode([
                'status'  => 'error',
                'message' => $this->upload->display_errors('', '')
            ]);
            return;
        }
    } else {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Profile image is required.'
        ]);
        return;
    }

    // ✅ Prepare insert data
    $insertData = [
        'name'           => $driver_name,
        'mobile'         => $mobile,
        'email'          => $email,
        'location'       => $location,
        'company_id'     => $company_id,
        'vehical_name'   => $vehicle_name,
        'vehical_number' => $vehicle_number,
        'licence_no'     => $licence_number,
        'password'       => md5($password),
        'profile_image'  => $profile_image, // full path stored
        'role'           => '0',
        'isActive'       => 1,
        'created_at'     => date('Y-m-d H:i:s')
    ];

    // ✅ Insert into users table
    $insert_id = $this->general_model->insert('users', $insertData);

    if ($insert_id) {
        echo json_encode([
            'status'  => 'success',
            'message' => 'Driver added successfully!',
            'id'      => $insert_id,
            'image'   => $profile_image
        ]);
    } else {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Failed to add driver. Please try again.'
        ]);
    }
}


public function edit($id){
$data['driver'] = (array)$this->general_model->getOne('users', array('id' => $id));
 $data['companies'] = (array)$this->general_model->getAll('company', array('isActive' => 1));




        if (!$data['driver']) {

            show_404();

        }



        $this->load->view('header');

        $this->load->view('driver_edit_form', $data);

        $this->load->view('footer');


}
public function update_driver()
{
    $id = $this->input->post('id', true);
    $driver_name = $this->input->post('driver_name', true);
    $mobile = $this->input->post('mobile', true);
    $email = $this->input->post('email', true);
    $location = $this->input->post('location', true);

    $vehicle_name = $this->input->post('vehicle_name', true);
    $vehicle_number = $this->input->post('vehicle_number', true);
    $licence_number = $this->input->post('licence_number', true);
    $company_id = $this->input->post('company_id', true);
    $password = $this->input->post('password', true);
    $old_image = $this->input->post('old_image', true);

    if (empty($driver_name) || empty($mobile) || empty($vehicle_name) || empty($vehicle_number) || empty($company_id)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        return;
    }

    $existing = $this->db->where('mobile', $mobile)
                         ->where('id !=', $id)
                         ->get('users')
                         ->row_array();
    if ($existing) {
        echo json_encode(['status' => 'error', 'message' => 'Mobile number already exists.']);
        return;
    }

    $profile_image = $old_image;
    if (!empty($_FILES['profile_image']['name'])) {
        $upload_path = './uploads/drivers/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        $config['upload_path']   = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size']      = 2048;
        $config['file_name']     = 'driver_' . time() . '_' . rand(1000, 9999);

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('profile_image')) {
            $upload_data = $this->upload->data();
            $profile_image = $upload_data['file_name'];

            if (!empty($old_image) && file_exists($upload_path . $old_image)) {
                unlink($upload_path . $old_image);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors('', '')]);
            return;
        }
    }

    $updateData = [
        'name'           => $driver_name,
        'mobile'         => $mobile,
        'email'          => $email,
        'location'          => $location,
        'vehical_name'   => $vehicle_name,
        'vehical_number' => $vehicle_number,
        'licence_no'     => $licence_number,
        'company_id'     => $company_id,
        'profile_image'  => $profile_image
    ];

    if (!empty($password)) {
        $updateData['password'] = md5($password);
    }

    $updated = $this->general_model->update('users', ['id' => $id], $updateData);

    if ($updated) {
        echo json_encode(['status' => 'success', 'message' => 'Driver updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No changes made or failed to update.']);
    }
}


public function view($id)
{
    

   $data['id'] = $id;
    $this->load->view('header');
    $this->load->view('driver_details',$data);
    $this->load->view('footer');
}
public function fetch_trips_ajax()
{
    header('Content-Type: application/json');

    $limit = 10;
    $page = $this->input->get('page') ?? 1;
    $search = trim($this->input->get('search'));
    $user_id = $this->input->get('user_id'); // 👈 Pass user_id from JS
    // echo $user_id;
    // die;
    $offset = ($page - 1) * $limit;

    if (empty($user_id)) {
        echo json_encode([
            'trips' => [],
            'total_pages' => 0,
            'current_page' => 0
        ]);
        return;
    }

    $this->db->from('trips');
    $this->db->where('status', 'completed');
    $this->db->where('user_id', $user_id); 

    if (!empty($search)) {
        $this->db->group_start()
                 ->like('customer_name', $search)
                 ->or_like('customer_mobile', $search)
                 ->group_end();
    }

    // Count total trips
    $clone = clone $this->db;
    $total = $clone->count_all_results();

    // Fetch trips with limit
    $this->db->limit($limit, $offset);
    $query = $this->db->get();
    $trips = $query->result_array();

    // Calculate total km and hours for each trip
    foreach ($trips as &$trip) {
        $trip['total_km'] = (!empty($trip['start_km']) && !empty($trip['end_km'])) ? round($trip['end_km'] - $trip['start_km'], 2) : null;
        if (!empty($trip['start_time']) && !empty($trip['end_time'])) {
            $start = strtotime($trip['start_time']);
            $end   = strtotime($trip['end_time']);
            $trip['total_hours'] = round(($end - $start)/3600, 2);
        } else {
            $trip['total_hours'] = null;
        }
    }

    $total_pages = ceil($total / $limit);

    echo json_encode([
        'trips' => $trips,
        'total_pages' => $total_pages,
        'current_page' => (int)$page
    ]);
}

public function driver_trip_details($id){
     $data['trip'] = (array)$this->general_model->getOne('trips', array('id' => $id));



        if (!$data['trip']) {

            show_404();

        }

      $this->load->view('header.php');

        $this->load->view('driver_trip_details.php',$data);

        $this->load->view('footer.php');
}


    public function company()
    {
        $this->load->view('header.php');

        $this->load->view('company_view.php');

        $this->load->view('footer.php');
    }
    public function add_company()
    {
        $this->load->view('header.php');

        $this->load->view('company_form.php');

        $this->load->view('footer.php');
    }
    public function save_company() {
    $this->load->model('general_model');

    $company_name = trim($this->input->post('company_name'));

    if (empty($company_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Company name is required.']);
        return;
    }

    // Check if company already exists
    $existing = $this->general_model->getOne('company', ['company_name' => $company_name]);
    if ($existing) {
        echo json_encode(['status' => 'exists', 'message' => 'This company already exists.']);
        return;
    }

    // Data to insert
    $data = [
        'company_name' => $company_name,
        'isActive' => 1,
        'created_at' => date('Y-m-d H:i:s')
    ];

    $insert_id = $this->general_model->insert('company', $data);

    if ($insert_id) {
        echo json_encode(['status' => 'success', 'message' => 'Company added successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add company.']);
    }
}
public function fetch_companies(){
        $limit = 10;
        $page = $this->input->post('page') ?? 1;
        $search = trim($this->input->post('search'));
        $offset = ($page-1)*$limit;

        $this->db->from('company');

        if(!empty($search)){
            $this->db->like('company_name', $search);
        }

        // Clone query to count total
        $clone_db = clone $this->db;
        $total = $clone_db->count_all_results();

        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $companies = $query->result();

        $total_pages = ceil($total/$limit);

        echo json_encode([
            'companies' => $companies,
            'total_pages' => $total_pages,
            'current_page' => (int)$page
        ]);
    }

    public function toggle_status_company(){
        $id = $this->input->post('id');
        $status = $this->input->post('isActive');

        $this->db->where('id', $id);
        $update = $this->db->update('company', ['isActive' => $status]);

        if($update){
            echo json_encode(['status'=>'success','message'=>'Company status updated']);
        }else{
            echo json_encode(['status'=>'error','message'=>'Something went wrong']);
        }
    }

    public function edit_company($id){
        $data['company'] = $this->db->get_where('company',['id'=>$id])->row();
        if(!$data['company']) show_404();

        $this->load->view('header');
        $this->load->view('company_edit_form', $data);
        $this->load->view('footer');
    }
    public function update_company(){
    $id = $this->input->post('id');
    $company_name = $this->input->post('company_name');
    $isActive = $this->input->post('isActive');

    if(empty($company_name)){
        echo json_encode(['status'=>'error','message'=>'Company name is required']);
        return;
    }

    $update = $this->db->where('id', $id)
                       ->update('company', [
                           'company_name' => $company_name,
                           'isActive' => $isActive
                       ]);

    if($update){
        echo json_encode(['status'=>'success','message'=>'Company updated successfully']);
    }else{
        echo json_encode(['status'=>'error','message'=>'Failed to update company']);
    }
    }

public function booking(){
    $this->load->view('header');
    $this->load->view('booking_view');
    $this->load->view('footer');

}
public function fetch_trips()
{
    header('Content-Type: application/json');

    $search = $this->input->get('search'); // search term
    $page   = (int)$this->input->get('page');
    $limit  = 10;
    $offset = ($page - 1) * $limit;

    // Base query
    $this->db->from('trips');
    $this->db->join('users', 'users.id = trips.user_id', 'left');

    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like('users.name', $search);
        $this->db->or_like('trips.from_location', $search);
        $this->db->or_like('trips.to_location', $search);
        $this->db->group_end();
    }

    // Count total rows
    $total_rows = $this->db->count_all_results('', false); // false = do not reset query

    // Select columns and fetch rows with limit & offset
    $this->db->select('trips.*, users.name as driver_name, users.vehical_name');
    $this->db->order_by('trips.id', 'DESC');
    // $this->db->order_by('trips.trip_date', 'DESC');
    $this->db->limit($limit, $offset);
    $trips = $this->db->get()->result_array();

    $total_pages = ceil($total_rows / $limit);

    echo json_encode([
        'status'      => true,
        'data'        => $trips,
        'total_pages' => $total_pages,
        'current_page'=> $page
    ]);
}
public function trip_details($id)
{
    // Load header
    $this->load->view('header');

    // Validate trip ID
    if (empty($id) || !is_numeric($id)) {
        show_error('Invalid trip ID', 400);
        return;
    }

    // Fetch trip details by trip_id
    $trip = $this->db->where('id', $id)->get('trips')->row_array();

    if (!$trip) {
        show_error('Trip not found', 404);
        return;
    }

    // Fetch driver details from users table using user_id from trips
    $user = $this->db->where('id', $trip['user_id'])->get('users')->row_array();

    // Merge both arrays (driver + trip info)
    $trip = array_merge($trip, [
        'driver_name'     => isset($user['name']) ? $user['name'] : '',
        'driver_email'    => isset($user['email']) ? $user['email'] : '',
        'driver_mobile'   => isset($user['mobile']) ? $user['mobile'] : '',
        'vehicle_name'    => isset($user['vehical_name']) ? $user['vehical_name'] : '',
        'vehicle_number'  => isset($user['vehical_number']) ? $user['vehical_number'] : '',
        'licence_number'  => isset($user['licence_no']) ? $user['licence_no'] : '',
        'company_id'      => isset($user['company_id']) ? $user['company_id'] : '',
    ]);

    // Send merged data to view
    $this->load->view('trip_details', ['trip' => $trip]);

    // Load footer
    $this->load->view('footer');
}
public function update_trip()
{
    $this->load->library('form_validation');

    $trip_id = $this->input->post('id');

    if (empty($trip_id)) {
        echo json_encode(['status' => false, 'message' => 'Trip ID is missing']);
        return;
    }

    // Validate required fields
    $this->form_validation->set_rules('driver_name', 'Driver Name', 'required');
    $this->form_validation->set_rules('vehicle_name', 'Vehicle Name', 'required');
    $this->form_validation->set_rules('trip_date', 'Trip Date', 'required');
    $this->form_validation->set_rules('from_location', 'From Location', 'required');
    $this->form_validation->set_rules('to_location', 'To Location', 'required');

    if ($this->form_validation->run() == FALSE) {
        echo json_encode([
            'status' => false,
            'message' => strip_tags(validation_errors())
        ]);
        return;
    }

    // Fetch trip record to get user_id
    $trip = $this->db->where('id', $trip_id)->get('trips')->row_array();
    if (empty($trip)) {
        echo json_encode(['status' => false, 'message' => 'Trip not found.']);
        return;
    }

    $user_id = $trip['user_id'];

    $driver_mobile = $this->input->post('driver_mobile');
    if (!empty($driver_mobile)) {
        $existing_mobile = $this->db
            ->where('mobile', $driver_mobile)
            ->where('id !=', $user_id)
            ->get('users')
            ->num_rows();

        if ($existing_mobile > 0) {
            echo json_encode([
                'status' => false,
                'message' => 'This mobile number is already registered with another user.'
            ]);
            return;
        }
    }

    // --- Update trips table ---
    $trip_update = [
        'trip_date'       => $this->input->post('trip_date'),
        'from_location'   => $this->input->post('from_location'),
        'to_location'     => $this->input->post('to_location'),
        'start_km'        => $this->input->post('start_km'),
        'end_km'          => $this->input->post('end_km'),
        'start_time'      => $this->input->post('start_time'),
        'end_time'        => $this->input->post('end_time'),
        'customer_name'   => $this->input->post('customer_name'),
        'customer_mobile' => $this->input->post('customer_mobile'),
        'created_at'      => date('Y-m-d H:i:s')
    ];
    $this->db->where('id', $trip_id)->update('trips', $trip_update);

    // --- Update users table (driver info) ---
    $driver_update = [
        'name'           => $this->input->post('driver_name'),
        'mobile'         => $driver_mobile,
        'vehical_name'   => $this->input->post('vehicle_name'),
        'vehical_number' => $this->input->post('vehicle_number'),
        'licence_no'     => $this->input->post('licence_number'),
        'created_at'     => date('Y-m-d H:i:s')
    ];
    $this->db->where('id', $user_id)->update('users', $driver_update);

    echo json_encode([
        'status' => true,
        'message' => 'Trip and driver details updated successfully.'
    ]);
}

public function delete_item()
{
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
    $deleted = $this->db->delete('company');

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
public function delete_user()
{
    $id = $this->input->post('id');

    if (empty($id)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid user ID'
        ]);
        return;
    }

    $this->db->where('id', $id);
    $deleted = $this->db->delete('users');

    if ($deleted) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Driver deleted successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete driver'
        ]);
    }
}
public function delete_trip()
{
    $id = $this->input->post('id');

    if (empty($id)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid Trip ID'
        ]);
        return;
    }

    $this->db->where('id', $id);
    $deleted = $this->db->delete('trips');

    if ($deleted) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Trip deleted successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete Trip'
        ]);
    }
}


public function generate_pdf()
{
    $id = $this->input->get('id'); 
    $currentMonth = date('m');
    $currentYear = date('Y');

    // ✅ Fetch trips
    $this->db->where('user_id', $id);
    $this->db->where('MONTH(trip_date)', $currentMonth);
    $this->db->where('YEAR(trip_date)', $currentYear);
    $this->db->order_by('trip_date', 'ASC');
    $query = $this->db->get('trips');
    $trips = $query->result();

    if (empty($trips)) {
        show_error('No trips found for the current month.', 404);
    }

    // ✅ Fetch driver details
    $this->db->select('name, vehical_name, vehical_number, mobile, location');
    $this->db->where('id', $id);
    $user = $this->db->get('users')->row();

    $driverName = !empty($user->name) ? $user->name : 'N/A';
    $vehicleName = !empty($user->vehical_name) ? $user->vehical_name : 'N/A';
    $vehicleNumber = !empty($user->vehical_number) ? $user->vehical_number : 'N/A';
    $mobile = !empty($user->mobile) ? $user->mobile : 'N/A';
    $location = !empty($user->location) ? $user->location : 'N/A';
    $safeDriverName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $driverName);

    $this->load->library('pdf');

    $html = '
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { border-collapse: collapse; width: 100%; font-size: 11px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background-color: #f2f2f2; }
        h2, h3,h4 { margin: 4px 0; text-align: center; }
    </style>

    <h2>Bhagwati Enterprise</h2>
    <h4>Mobile: '.$mobile.'</h4>
    <h3 style="color:blue;">Fixed Vehicle Log Sheet</h3>

    <table style="margin-bottom: 10px;">
        <tr>
            <th>Vehicle Type:</th><td>' . $vehicleName . '</td>
            <th>Vehicle No.:</th><td>' . $vehicleNumber . '</td>
            <th>Location:</th><td>' . $location . '</td>
            <th>Month & Year:</th><td>' . date('F Y') . '</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Start Time</th>
                <th>Close Time</th>
                <th>Start Km</th>
                <th>Close Km</th>
                <th>Total Km</th>
                <th>Driver Name</th>
                <th>Journey Purpose</th>
                <th>Customer Name</th>
                <th>Trip Type</th>

                <th>Mobile</th>
                <th>Sign</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($trips as $trip) {
        $formattedDate = date('M d, Y', strtotime($trip->trip_date));

        $totalKm = (isset($trip->start_km) && isset($trip->end_km))
            ? ($trip->end_km - $trip->start_km) . ' km'
            : '-';

        $html .= '
        <tr>
            <td>' . $formattedDate . '</td>
            <td>' . ($trip->start_time ?: '-') . '</td>
            <td>' . ($trip->end_time ?: '-') . '</td>
            <td>' . ($trip->start_km ?: '-') . '</td>
            <td>' . ($trip->end_km ?: '-') . '</td>
            <td>' . $totalKm . '</td>
            <td>' . ($trip->driver_name ?: '-') . '</td>
            <td>' . ($trip->from_location && $trip->to_location ? $trip->from_location . " to " . $trip->to_location : '-') . '</td>
            <td>' . ($trip->customer_name ?: '-') . '</td>
            <td>' . ($trip->trip_type ?: '-') . '</td>

            <td>' . ($trip->customer_mobile ?: '-') . '</td>
            <td style="height:30px;"></td>
        </tr>';
    }

    $html .= '</tbody></table>';

    // ✅ Generate PDF
    $this->pdf->loadHtml($html);
    $this->pdf->render();
    $this->pdf->stream("trip_report_{$safeDriverName}_" . date('F_Y') . ".pdf", ["Attachment" => true]);
}








}

