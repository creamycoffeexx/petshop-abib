<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class User extends CI_Controller
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
	 * index
	 * menampilkan halaman daftar rs rujukan
	 * @return void
	 */
	public function index()
	{
		$data = array(
			'title' => 'User'
		);
		$this->load->view('admin/user/index', $data);
	}

	/**
	 * add
	 * untuk menampilkan form dan menyimpan data RS rujukan
	 * @return void
	 */
	public function add()
	{

		$this->form_validation->set_rules('username', 'Username', 'required', ['required' => '%s tidak boleh kosong ']);
		$this->form_validation->set_rules('password', 'Password', 'required', ['required' => '%s tidak boleh kosong ']);


		if ($this->form_validation->run() == TRUE) {
			$this->UserModel->add();
			$this->session->set_flashdata('statusMessage', alert('success', 'User berhasil ditambah'));
			redirect('admin/user');
		}

		$data = array(
			'title' => 'User'
		);
		$this->load->view('admin/user/add', $data);
	}

	/**
	 * edit
	 * untuk menampilkan form dan memperbarui data rs rujukan
	 * @return void
	 */
	public function edit($id)
	{

		$this->form_validation->set_rules('username', 'Username', 'required', ['required' => '%s tidak boleh kosong ']);
		$this->form_validation->set_rules('password', 'Password', 'required', ['required' => '%s tidak boleh kosong ']);

		if ($this->form_validation->run() == TRUE) {
			$this->UserModel->edit();
			$this->session->set_flashdata('statusMessage', alert('success', 'Data User berhasil diperbarui'));
			redirect('admin/user');
		}

		$data = array(
			'title' => 'User',
			'userRow' => $this->UserModel->getByID($id)
		);
		$this->load->view('admin/user/edit', $data);
	}


	/**
	 * delete
	 *
	 * @param  mixed $id
	 * @return void
	 */
	public function delete($id)
	{
		$this->UserModel->delete($id);
		$this->session->set_flashdata('statusMessage', alert('success', 'Data RS Rujukan berhasil dihapus'));
		redirect('admin/user');
	}


	/**
	 * ajaxdata
	 * untuk mendapatkan data RS
	 * @return void
	 */
	public function ajaxdata()
	{
		$rsData = $this->NodeModel->getNodeData();
		echo json_encode($rsData);
	}

	/**
	 * ajaxlist
	 * untuk mendapatkan data dengan format datatable
	 * @return void
	 */
	public function ajaxlist()
	{
		$datatables = new Datatables(new CodeigniterAdapter);
		$datatables->query('SELECT id,username,password,inserted_at FROM user');
		$datatables->hide('id');
		$datatables->add('aksi', function ($data) {
			return '<a href="' . site_url('admin/user/edit/' . $data['id']) . '" class="btn btn-primary"><i class="dripicons-document-edit"></i></a>&nbsp;<a href="#" onclick="deleteData(' . $data['id'] . ')" class="btn btn-danger"><i class="dripicons-trash"></i></a>';
		});
		echo $datatables->generate();
	}

	public function upload()
	{
		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'gif|jpg|png';
		$config['max_size']             = 100;
		$config['encrypt_name']             = true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('userfile')) {
			return array('error' => $this->upload->display_errors());
		} else {
			return array('success' => $this->upload->data());
		}
	}
}
