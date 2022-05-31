<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Dashboard extends CI_Controller
{

	/**
	 * index
	 * menampilkan halaman dashboard
	 * @return void
	 */
	public function __construct()
	{
		if ($this->session->userdata('user') === null {
			redirect('login');
		}
	}
	public function index()
	{
		$this->load->model('NodeModel');
		$this->load->model('GraphModel');
		$data = array(
			'title' => 'Dashboard',
			'countRS' => $this->NodeModel->countObject(),
			'countSimpul' => $this->NodeModel->countSimpul(),
			'countGraph' => $this->GraphModel->countGraph(),
		);
		$this->load->view('admin/dashboard/index', $data);
	}
}
