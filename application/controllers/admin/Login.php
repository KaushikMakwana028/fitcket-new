<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Login extends CI_Controller
{



	public $data = [];

	public function __construct()
	{



		parent::__construct();


		$this->load->library('form_validation');

		$this->load->library('session');
		$this->load->helper(['url', 'form']);


		$this->load->model('general_model');

		$this->form_validation->set_error_delimiters("<div class='error'>", "</div>");



		$method = $this->router->fetch_method();





		if ($method != 'logout' && $this->session->userdata('admin')) {

			redirect('admin/dashboard');

		}

	}



	public function index()
	{

		$this->form_validation->set_rules('mobile', 'mobile', 'required');



		$this->form_validation->set_rules('password', 'password', 'required');



		if ($this->form_validation->run() === true) {



			$password = md5($this->input->post('password'));



			$mobile = $this->input->post('mobile');



			$where = array('mobile' => $mobile, 'password' => $password);



			$user = $this->general_model->getOne('users', $where);


			//  echo "<pre>";

			//  print_r($user);die;


			if ($user) {



				$session = array(



					'id' => $user->id,


					'name' => $user->name,

					'gym_name' => $user->store_name,

					'role' => $user->role,
					'phone' => $user->mobile,

				);

				$this->session->set_userdata('admin', $session);

				$this->session->set_flashdata('success', 'You have logged in successfully!');

				redirect('admin/dashboard');

			} else {



				$this->session->set_flashdata('error', 'Invalid email or password. Please try again.');

				redirect('admin', 'refresh');

			}





		}



		$this->load->view('admin/login_view.php');

	}
}
