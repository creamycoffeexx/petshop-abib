<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		header('Cache-Control: no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
	}

	/**
	 * login
	 * menampilkan halaman login
	 * @return void
	 */
	public function logout()
	{
		$this->session->unset_userdata('user');
		redirect('login');
	}
}
