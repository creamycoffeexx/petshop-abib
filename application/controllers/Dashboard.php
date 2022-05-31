<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	/**
	 * index
	 * menampilkan halaman dashboard
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		header('Cache-Control: no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');
		
		if ($this->session->userdata('user') === null) {
			redirect('login');
		}
	}
	public function index()
	{
		$this->load->model('NodeModel');
		$this->load->model('GraphModel');
		$data = array(
			'title' => 'Beranda',
			'countRS' => $this->NodeModel->countObject(),
			'countSimpul' => $this->NodeModel->countSimpul(),
			'countGraph' => $this->GraphModel->countGraph(),
		);
		$this->load->view('admin/dashboard/index', $data);
	}
}
