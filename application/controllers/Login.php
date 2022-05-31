<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		header('Cache-Control: no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');

		$this->load->model('UserModel');
	}

	/**
	 * login
	 * menampilkan halaman login
	 * @return void
	 */
	public function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required', ['required' => 'Username tidak boleh kosong']);
		$this->form_validation->set_rules('password', 'Password', 'trim|required', ['required' => 'Password tidak boleh kosong']);

		if ($this->form_validation->run() == TRUE) {
			$userRow = $this->UserModel->login();	
			if (is_null($userRow)) {
				$this->session->set_flashdata('loginError', alert('danger', '<strong>Maaf</strong>, username atau password anda salah, mohon ulangi sekali lagi !'));
			} else if ($userRow->username === 'admin') {
				$this->session->set_userdata('user', $userRow);
				redirect('admin/dashboard');
			} else if ($userRow->username === 'user') {
				$this->session->set_userdata('user', $userRow);
				redirect('djikstra');
			}
		}

		$data = array(
			'title' => 'Login'
		);
		$this->load->view('login/index', $data);
	}
}
