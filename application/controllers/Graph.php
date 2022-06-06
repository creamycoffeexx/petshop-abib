<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Ozdemir\Datatables\Datatables;
use Ozdemir\Datatables\DB\CodeigniterAdapter;

class Graph extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		header('Cache-Control: no-cache, must-revalidate, max-age=0');
		header('Cache-Control: post-check=0, pre-check=0', false);
		header('Pragma: no-cache');

		$this->load->model('NodeModel');
		$this->load->model('GraphModel');
	}

	/**
	 * index
	 * menampilkan halaman daftar rs rujukan
	 * @return void
	 */
	public function index()
	{
		$data = array(
			'title' => 'Graph',
			'nodeResult' => $this->NodeModel->getData()
		);
		$this->load->view('admin/graph/index', $data);
	}

	/**
	 * add
	 * untuk menampilkan form dan menyimpan data RS rujukan
	 * @return void
	 */
	public function add()
	{
		$this->GraphModel->add();
	}

	/**
	 * edit
	 * untuk menampilkan form dan memperbarui data rs rujukan
	 * @return void
	 */
	public function edit()
	{
		$this->form_validation->set_rules('id_graph', 'id', 'required', ['required' => '%s tidak boleh kosong ']);
		if ($this->form_validation->run() == TRUE) {
			$this->GraphModel->edit();
		} else {
			$grafRow = $this->GraphModel->getByID($_POST['id']);
			echo json_encode($grafRow);
		}
	}


	/**
	 * delete
	 *
	 * @param  mixed $id
	 * @return void
	 */
	public function delete($id)
	{
		$this->GraphModel->delete($id);
		$this->session->set_flashdata('statusMessage', alert('success', 'Data Graph berhasil dihapus'));
		redirect('admin/graph');
	}


	/**
	 * ajaxdata
	 * untuk mendapatkan data RS
	 * @return void
	 */
	public function ajaxdata()
	{
		$graphData = $this->NodeModel->getData();
		echo json_encode($graphData);
	}
	public function ajaxdatajoin()
	{
		$graphData = $this->NodeModel->getDatajoin();
		echo json_encode($graphData);
	}

	/**
	 * ajaxlist
	 * untuk mendapatkan data dengan format datatable
	 * @return void
	 */
	public function ajaxlist()
	{
		$datatables = new Datatables(new CodeigniterAdapter);
		$datatables->query('SELECT graph.id,n1.name as name1,n2.name as name2,distance,time FROM graph INNER JOIN node as n1 ON n1.id = graph.start INNER JOIN node as n2 ON n2.id = graph.end');
		$datatables->hide('id');
		$datatables->edit('distance', function ($data) {
			return $data['distance'] . ' Kilometer';
		});
		$datatables->edit('time', function ($data) {
			return $data['time'] . ' Menit';
		});
		$datatables->add('aksi', function ($data) {
			return '<button onclick="showModalEditGraph(' . $data['id'] . ')" class="btn btn-primary"><i class="dripicons-document-edit"></i></button>&nbsp;<a href="#" onclick="deleteData(' . $data['id'] . ')" class="btn btn-danger"><i class="dripicons-trash"></i></a>';
		});
		echo $datatables->generate();
	}

	public function ajaxlistID($id)
	{
		$datatables = new Datatables(new CodeigniterAdapter);
		$datatables->query("SELECT graph.id,n1.name as name1,n2.name as name2,distance,time FROM graph INNER JOIN node as n1 ON n1.id = graph.start INNER JOIN node as n2 ON n2.id = graph.end WHERE graph.start='$id' ORDER BY graph.distance ASC");
		$datatables->hide('id');
		$datatables->edit('distance', function ($data) {
			return $data['distance'] . ' Kilometer';
		});
		$datatables->edit('time', function ($data) {
			return $data['time'] . ' Menit';
		});
		$datatables->add('aksi', function ($data) {
			return '';
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

	/**
	 * getGraphLine
	 *
	 * @return void
	 */
	public function getGraphLine()
	{
		$lineRow = $this->GraphModel->getLine();
		echo json_encode($lineRow);
	}
}
