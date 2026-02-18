<?php



defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/User_Controller.php');
require_once FCPATH . 'vendor/autoload.php';

use Razorpay\Api\Api;









class Cart extends User_Controller
{



    private $RAZORPAY_KEY_ID = "rzp_live_RCge2Oz6kUJE74";

    private $RAZORPAY_KEY_SECRET = "Pw0gRqzQkzjl5pYW10pXXZeq";





    public function __construct()
    {







        parent::__construct();

        // $method = $this->router->fetch_method();



        // if (!$this->user && $method !== 'payu_callback') {

        //     redirect('login');

        // }





    }



    public function index()
    {

        $this->load->view('header');

        $this->load->view('cart_view');

        $this->load->view('footer');



    }



    public function add_to_cart()
    {

        $data = array(

            'id' => $this->input->post('provider_id'),

            'name' => $this->input->post('provider_name'),

            'image' => $this->input->post('provider_image'),

            'price' => $this->input->post('price'),

            'duration' => $this->input->post('duration'),

            'qty' => $this->input->post('quantity'),

            'start_date' => $this->input->post('start_date')

        );



        $cart = $this->session->userdata('cart_items') ?? [];

        $found = false;



        foreach ($cart as $index => $item) {

            if ($item['id'] == $data['id'] && $item['duration'] == $data['duration']) {

                $cart[$index]['qty'] += $data['qty'];

                $found = true;

                break;

            }

        }



        if (!$found) {

            $cart[] = $data;

        }



        $this->session->set_userdata('cart_items', $cart);



        redirect('cart/view');

    }



   public function view()
{
    $cart_items = $this->session->userdata('cart_items');
    $offer_setting = $this->db->get('offer_settings')->row();
    $offer_percent = $offer_setting ? floatval($offer_setting->offer_percent) : 0;
    $min_amount_for_offer = $offer_setting ? floatval($offer_setting->min_amount) : 0;

    $subtotal = 0;
    $discount_amount = 0;

    if ($cart_items) {
        foreach ($cart_items as &$item) {
            $item_total = floatval($item['price']) * intval($item['qty']);
            $subtotal += $item_total;

            if ($offer_percent > 0) {
                if ($min_amount_for_offer == 0 || $subtotal >= $min_amount_for_offer) {
                    $item['platform_discount'] = ($item_total * $offer_percent) / 100;
                } else {
                    $item['platform_discount'] = 0;
                }
                $discount_amount += $item['platform_discount'];
            } else {
                $item['platform_discount'] = 0;
            }
        }
        unset($item);
    }

    $total_after_discount = $subtotal - $discount_amount;

    $data['cart_items'] = $cart_items;
    $data['subtotal'] = $subtotal;
    $data['discount_amount'] = $discount_amount;
    $data['total_after_discount'] = $total_after_discount;
    $data['offer_percent'] = $offer_percent;

    $this->load->view('header');
    $this->load->view('cart_view', $data);
    $this->load->view('footer');
}
    public function remove()
    {
        $item_id = (int) $this->input->post('id');
        $cart = $this->session->userdata('cart_items') ?? [];

        
        foreach ($cart as $key => $item) {
            if ((int) $item['id'] === $item_id) {
                unset($cart[$key]);
                break;
            }
        }

        
        $cart = array_values($cart);

        $this->session->set_userdata('cart_items', $cart);

        echo json_encode([
            'status' => 'success',
            'count' => count($cart)
        ]);
    }
public function update_quantity()
{
    $item_id = (int) $this->input->post('id');
    $action = $this->input->post('action'); // increase or decrease

    $cart = $this->session->userdata('cart_items') ?? [];

    foreach ($cart as $key => $item) {
        if ((int) $item['id'] === $item_id) {
            if ($action === 'increase') {
                $cart[$key]['qty']++;
            } elseif ($action === 'decrease' && $cart[$key]['qty'] > 1) {
                $cart[$key]['qty']--;
            }
            break;
        }
    }

    $this->session->set_userdata('cart_items', $cart);

    echo json_encode([
        'status' => 'success',
        'cart' => $cart
    ]);
}




    public function get_cart_count()
    {
        
        $cart = $this->session->userdata('cart_items') ?? [];
        $count = count($cart);

        echo json_encode(['count' => $count]);
    }

public function pay()
{
    $cart_items = $this->session->userdata('cart_items');

    if (!$cart_items || empty($cart_items)) {
        redirect('cart/view');
    }

    // Get platform offer
    $offer_setting = $this->db->get('offer_settings')->row();
    $offer_percent = $offer_setting ? floatval($offer_setting->offer_percent) : 0;
    $min_amount_for_offer = $offer_setting ? floatval($offer_setting->min_amount) : 0;

    $subtotal = 0;
    $discount_amount = 0;

    // Loop through cart items and apply offers
    foreach ($cart_items as &$item) { // & so we can update quantities
        // Get active offer for this provider and duration
        $offer = $this->db->where('provider_id', $item['id'])
                          ->where('duration', $item['duration'])
                          ->where('isActive', 1)
                          ->where('valid_till >=', date('Y-m-d'))
                          ->get('offers')
                          ->row();

        if ($offer) {
            // Calculate free quantity
            $sets = intval($item['qty'] / $offer->buy_quantity); // Complete sets bought
            $item['free_qty'] = $sets * $offer->free_quantity;
            $item['total_qty'] = $item['qty'] + $item['free_qty'];
        } else {
            $item['free_qty'] = 0;
            $item['total_qty'] = $item['qty'];
        }

        // Add only paid quantity to subtotal
        $item_total = floatval($item['price']) * intval($item['qty']);
        $subtotal += $item_total;

        // Apply platform offer
        if ($offer_percent > 0) {
            if ($min_amount_for_offer == 0 || $subtotal >= $min_amount_for_offer) {
                $item['platform_discount'] = ($item_total * $offer_percent) / 100;
            } else {
                $item['platform_discount'] = 0;
            }
            $discount_amount += $item['platform_discount'];
        } else {
            $item['platform_discount'] = 0;
        }
    }
    unset($item); // break reference

    $total_after_discount = $subtotal - $discount_amount;

    if ($total_after_discount <= 0) {
        $this->session->set_flashdata('error', 'Invalid payment amount.');
        redirect('cart/view');
    }

    $amount_paise = intval($total_after_discount * 100); 
    $txnid = 'TXN' . uniqid();

    // Insert order
    $order_data = [
        'user_id' => $this->user['id'],
        'total' => $total_after_discount,
        'txnid' => $txnid,
        'status' => 'pending',
        'created_at' => date('Y-m-d H:i:s')
    ];
    $this->db->insert('orders', $order_data);
    $order_id = $this->db->insert_id();

    // Insert order items
    foreach ($cart_items as $item) {
        $item_data = [
            'order_id' => $order_id,
            'provider_id' => $item['id'],
            'name' => trim($item['name']),
            'image' => $item['image'],
            'price' => $item['price'],
            'duration' => $item['duration'],
            'qty' => $item['qty'],            // Paid qty
            'free_qty' => $item['free_qty'],  // Free qty
            'total_qty' => $item['total_qty'],// Paid + Free
            // 'platform_discount' => $item['platform_discount'], 
            'start_date' => $item['start_date']
        ];
        $this->db->insert('order_items', $item_data);
    }

    // Razorpay payment
    $api = new Api($this->RAZORPAY_KEY_ID, $this->RAZORPAY_KEY_SECRET);
    $razorpayOrder = $api->order->create([
        'receipt' => $txnid,
        'amount' => $amount_paise,
        'currency' => 'INR',
        'payment_capture' => 1
    ]);

    $data = [
        "key" => $this->RAZORPAY_KEY_ID,
        "amount" => $amount_paise,
        "name" => "Cart Payment",
        "description" => "Order #$order_id",
        "image" => base_url('assets/logo.png'),
        "prefill" => [
            "name" => $this->user['name'] ?? 'Guest',
            "email" => $this->user['email'] ?? 'test@test.com',
            "contact" => $this->user['mobile']
        ],
        "notes" => [
            "order_id" => $order_id
        ],
        "theme" => [
            "color" => "#3399cc"
        ],
        "order_id" => $razorpayOrder['id'],
        "txnid" => $txnid
    ];

    $this->load->view('header');
    $this->load->view('razorpay_redirect', $data);
    $this->load->view('footer');
}



    public function razorpay_callback()
    {
        $api = new Api($this->RAZORPAY_KEY_ID, $this->RAZORPAY_KEY_SECRET);

        $payment_id = $this->input->post('razorpay_payment_id');
        $order_id = $this->input->post('razorpay_order_id');
        $signature = $this->input->post('razorpay_signature');
        $txnid = $this->input->post('txnid');

        try {
            
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $order_id,
                'razorpay_payment_id' => $payment_id,
                'razorpay_signature' => $signature
            ]);

            
            $this->db->where('txnid', $txnid)->update('orders', ['status' => 'success']);
          $order = $this->db
    ->get_where('orders', ['txnid' => $txnid])
    ->row();

if (!$order) {
    throw new Exception('Order not found');
}

/* STEP 2: Fetch order items */
$order_items = $this->db
    ->get_where('order_items', ['order_id' => $order->id])
    ->result();

/* STEP 3: Insert provider notifications */
foreach ($order_items as $item) {

    $this->db->insert('provider_notifications', [
        'provider_id' => $item->provider_id,
        'order_id'    => $order->id,
        'order_item_id' => $item->id, 
        'title'       => 'New Booking Received',
        'message'     => 'You have received a new service booking.',
        'created_at'  => date('Y-m-d H:i:s')
    ]);
}

            $payment_setting = $this->db->get('payment_settings')->row();
            $commission_percent = $payment_setting ? floatval($payment_setting->commission) : 0;

            $order = $this->db->get_where('orders', ['txnid' => $txnid])->row();
            $order_items = $this->db->get_where('order_items', ['order_id' => $order->id])->result();

            foreach ($order_items as $item) {
                $provider_id = $item->provider_id;
                $gross_amount = floatval($item->price) * intval($item->qty);

                
                $commission_amt = ($gross_amount * $commission_percent) / 100;
                $net_amount = $gross_amount - $commission_amt;

                
                $wallet = $this->db->get_where('provider_wallet', ['provider_id' => $provider_id])->row();

                if ($wallet) {
                    $new_balance = $wallet->balance + $net_amount;
                    $this->db->where('provider_id', $provider_id)->update('provider_wallet', [
                        'balance' => $new_balance
                    ]);
                } else {
                    $this->db->insert('provider_wallet', [
                        'provider_id' => $provider_id,
                        'balance' => $net_amount
                    ]);
                }

                
                $this->db->insert('commission_log', [
                    'provider_id' => $provider_id,
                    'order_id' => $order->id,
                    'gross_amount' => $gross_amount,
                    'commission_rate' => $commission_percent,
                    'commission_amt' => $commission_amt,
                    'net_amount' => $net_amount,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }

            $this->session->unset_userdata('cart_items');
            $this->session->set_flashdata('success', 'Payment successful! ID: ' . htmlspecialchars($payment_id));
            redirect('cart/success?txnid=' . urlencode($txnid));

        } catch (Exception $e) {
            $this->db->where('txnid', $txnid)->update('orders', ['status' => 'failed']);
            $this->session->set_flashdata('error', 'Payment verification failed!');
            redirect('cart/view');
        }
    }









    public function success()
    {
        $txnid = $this->input->get('txnid');

        if (!$txnid) {
            show_error('Transaction ID missing.');
            return;
        }

        // Fetch order
        $order = $this->db->get_where('orders', ['txnid' => $txnid])->row_array();
        if (!$order) {
            show_error('Order not found.');
            return;
        }

        // Fetch user
        $user = $this->db->get_where('users', ['id' => $order['user_id']])->row_array();
        if ($user) {
            $user['is_logged_in'] = true;
            $user['is_registered'] = true;
            $this->session->set_userdata('user', $user);
        }

        // Fetch order items (multiple gyms possible)
        $order_items = $this->db->get_where('order_items', ['order_id' => $order['id']])->result_array();

        $data['order'] = $order;
        $data['user'] = $user;
        $data['items'] = $this->db->get_where('order_items', ['order_id' => $order['id']])->result_array();


        $this->load->view('header');
        $this->load->view('success', $data);
        $this->load->view('footer');
    }





}