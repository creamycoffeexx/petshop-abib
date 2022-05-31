<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('display_errors', 'off');
include 'Djikstra.php';
class Front extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('NodeModel');
		$this->load->model('GraphModel');
	}
	/**
	 * index
	 * menampilkan data gunung
	 * @return void
	 */
	public function hotel()
	{
		$jumlah_data = $this->NodeModel->countObject();

		$this->load->library('pagination');
		$config['base_url'] = site_url() . 'gunung/';
		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = 10;
		// Membuat Style pagination untuk BootStrap v4
		$config['first_link']       = 'Awal';
		$config['last_link']        = 'Akhir';
		$config['next_link']        = 'Selanjutnya';
		$config['prev_link']        = 'Sebelumnya';
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close']  = '</span>Next</li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close']  = '</span></li>';
		$from = $this->uri->segment(2);
		$this->pagination->initialize($config);
		$data = array(
			'title' => 'Gunung',
			'objectResult' => $this->NodeModel->getObjectsOffset($config['per_page'], $from)

		);
		$this->load->view('front/hotel', $data);
	}
	public function detailHotel($id)
	{
		$data = array(
			'title' => 'Hotel',
			'objectRow' => $this->NodeModel->getById($id)

		);
		$this->load->view('front/detailHotel', $data);
	}

	/**
	 * galeri
	 *
	 * @return void
	 */
	public function galeri()
	{
		$jumlah_data = $this->NodeModel->countObject();

		$this->load->library('pagination');
		$config['base_url'] = site_url() . 'galeri/';
		$config['total_rows'] = $jumlah_data;
		$config['per_page'] = 10;
		// Membuat Style pagination untuk BootStrap v4
		$config['first_link']       = 'Awal';
		$config['last_link']        = 'Akhir';
		$config['next_link']        = 'Selanjutnya';
		$config['prev_link']        = 'Sebelumnya';
		$config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
		$config['full_tag_close']   = '</ul></nav></div>';
		$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
		$config['num_tag_close']    = '</span></li>';
		$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close']  = '</span>Next</li>';
		$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close']  = '</span></li>';
		$from = $this->uri->segment(2);
		$this->pagination->initialize($config);
		$data = array(
			'title' => 'Galeri',
			'objectResult' => $this->NodeModel->getObjectsOffset($config['per_page'], $from)

		);
		$this->load->view('front/galeri', $data);
	}
	/**
	 * index
	 * menampilkan halaman dashboard
	 * @return void
	 */
	public function djikstra()
	{
		$data = array(
			'title' => 'Pencarian Rute',
			'nodeResult' => $this->NodeModel->getData()

		);
		$this->load->view('front/djikstra', $data);
	}

	/**
	 * getShortestPath
	 *
	 * @return void
	 */
	public function getShortestPath()
	{
		$lok_asal = $_POST['start'];
		$lok_akhir = $_POST['end'];


		$graphResult = $this->GraphModel->get();

		foreach ($graphResult as $k => $v) {
			$graf[$v->n1_id][$v->n2_id] = $v->distance;
			$time[$v->n1_id][$v->n2_id] = $v->time;
			$kordinat[$v->n1_id] = array('lat' => $v->n1_lat, 'lng' => $v->n1_lng);
			$kordinat[$v->n2_id] = array('lat' => $v->n2_lat, 'lng' => $v->n2_lng);
			$grafName[$v->n1_id] = $v->n1_name;
			$grafName[$v->n2_id] = $v->n2_name;
		}
		$kordinat_goal = $kordinat[$lok_akhir];

		$djikstra = new Djikstra($graf, $grafName, $lok_asal, $lok_akhir, $time);
		$res['from_'] = $grafName[$lok_asal];
		$res['from'] = $lok_asal;
		$res['to_'] = $grafName[$lok_akhir];
		$res['to'] = $lok_akhir;
		$res['distance'] = round($djikstra->getDistance(), 2) . " Km";
		$res['path'] = $djikstra->getPath();
		$res['path_'] = $djikstra->printPath();
		$res['detail_perhitungan'] = $djikstra->getDetailPerhitungan();
		$res['time'] = $djikstra->getTime() . ' Menit';
		foreach ($djikstra->getPath() as $p) {
			$res['path_cor'][] = $kordinat[$p];
		}

		$res['detail_perhitungan'] = $djikstra->getDetailPerhitungan();

		echo json_encode($res);
	}

	/**
	 * getAllMarker
	 * Untuk mendapatkan data marker
	 * @return void
	 */
	public function getAllMarker()
	{
		$markersRow = $this->NodeModel->getNodeData();
		echo json_encode($markersRow);
	}

	/**
	 * pedoman
	 *
	 * @return void
	 */
	public function pedoman()
	{
		$data = array(
			'title' => 'Pedoman Pendakian',

		);
		$this->load->view('front/pedoman', $data);
	}
	/**
	 * tentang
	 *
	 * @return void
	 */
	public function about()
	{
		$data = array(
			'title' => 'Tentang Aplikasi',

		);
		$this->load->view('front/about', $data);
	}

	public function test()
	{
		$data = array(
			'title' => 'Tentang Aplikasi',

		);
		$this->load->view('front/about', $data);
	}

	
}
