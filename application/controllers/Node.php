<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Node extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		header('Cache-Control: no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');

		$this->load->model('NodeModel');
	}

	/**
	 * index
	 * menampilkan halaman daftar rs rujukan
	 * @return void
	 */
	public function index()
	{
		$data = array(
			'title' => 'Node'
		);
		$this->load->view('admin/node/index', $data);
	}

	/**
	 * add
	 * untuk menampilkan form dan menyimpan data RS rujukan
	 * @return void
	 */
	public function add()
	{

		$this->form_validation->set_rules('name', 'Node', 'required', ['required' => '%s tidak boleh kosong ']);
		$this->form_validation->set_rules('lat', 'Latitude', 'required', ['required' => '%s tidak boleh kosong ']);
		$this->form_validation->set_rules('lng', 'Longitude', 'required', ['required' => '%s tidak boleh kosong ']);


		if ($this->form_validation->run() == TRUE) {
			$_POST['desc'] = '-';
			$_POST['picture'] = '-';
			$_POST['type'] = '-';
			$this->NodeModel->add();
			$this->session->set_flashdata('statusMessage', alert('success', 'Data Node berhasil ditambah'));
			redirect('admin/node');
		}

		$data = array(
			'title' => 'Node'
		);
		$this->load->view('admin/node/add', $data);
	}

	/**
	 * edit
	 * untuk menampilkan form dan memperbarui data rs rujukan
	 * @return void
	 */
	public function edit($id)
	{

		$this->form_validation->set_rules('name', 'Nama rumah sakit', 'required', ['required' => '%s tidak boleh kosong ']);
		$this->form_validation->set_rules('lat', 'Latitude', 'required', ['required' => '%s tidak boleh kosong ']);
		$this->form_validation->set_rules('lng', 'Longitude', 'required', ['required' => '%s tidak boleh kosong ']);


		if ($this->form_validation->run() == TRUE) {
			$_POST['desc'] = '-';
			$_POST['picture'] = '-';
			$this->NodeModel->edit();
			$this->session->set_flashdata('statusMessage', alert('success', 'Data Rumah berhasil diperbarui'));
			redirect('admin/node');
		}

		$data = array(
			'title' => 'Node',
			'rsRow' => $this->NodeModel->getByID($id)
		);
		$this->load->view('admin/node/edit', $data);
	}


	/**
	 * delete
	 *
	 * @param  mixed $id
	 * @return void
	 */
	public function delete($id)
	{
		$this->NodeModel->delete($id);
		$this->session->set_flashdata('statusMessage', alert('success', 'Data Rumah berhasil dihapus'));
		redirect('admin/node');
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
		$datatables->query('SELECT id,name,lat,lng FROM node WHERE type = "-"');
		$datatables->hide('id');
		$datatables->add('aksi', function ($data) {
			return '<a href="' . site_url('admin/node/edit/' . $data['id']) . '" class="btn btn-primary"><i class="dripicons-document-edit"></i></a>&nbsp;<a href="#" onclick="deleteData(' . $data['id'] . ')" class="btn btn-danger"><i class="dripicons-trash"></i></a>';
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
