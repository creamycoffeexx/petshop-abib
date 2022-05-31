<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GraphModel extends CI_Model
{
	private $tb_ = 'graph';

	/**
	 * add
	 *
	 * @return void
	 */
	public function add()
	{
		$this->db->insert($this->tb_, [
			'start' => $_POST['start'],
			'end' => $_POST['end'],
			'distance' => $_POST['distance'],
			'time' => $_POST['time'],
		]);
	}
	/**
	 * edit
	 *
	 * @return void
	 */
	public function edit()
	{
		$this->db->update($this->tb_, [
			'start' => $_POST['start'],
			'end' => $_POST['end'],
			'distance' => $_POST['distance'],
			'time' => $_POST['time'],
		], ['id' => $_POST['id_graph']]);
	}

	/**
	 * delete
	 *
	 * @param  mixed $id
	 * @return void
	 */
	public function delete($id)
	{
		$this->db->delete($this->tb_, ['id' => $id]);
	}


	/**
	 * get
	 *
	 * @return void
	 */
	public function get()
	{
		$this->db->select(
			'graph.id as g_id,
			n1.id as n1_id,
			n2.id as n2_id,
			n1.lat as n1_lat,n1.lng as n1_lng,
			n2.lat as n2_lat,n2.lng as n2_lng,
			n1.name as n1_name,
			n2.name as n2_name,
			distance,time'
		);
		$this->db->join('node as n1', 'n1.id=' . $this->tb_ . '.start');
		$this->db->join('node as n2', 'n2.id=' . $this->tb_ . '.end');
		return $this->db->get($this->tb_)->result();
	}

	/**
	 * getByID
	 *
	 * @param  mixed $id
	 * @return void
	 */
	public function getByID($id)
	{
		return $this->db->get_where($this->tb_, ['id' => $id])->row();
	}

	/**
	 * getLine
	 *
	 * @return void
	 */
	public function getLine()
	{
		$this->db->select(
			'graph.id as g_id,
			n1.lat as n1_lat,n1.lng as n1_lng,
			n2.lat as n2_lat,n2.lng as n2_lng'
		);
		$this->db->join('node as n1', 'n1.id=' . $this->tb_ . '.start');
		$this->db->join('node as n2', 'n2.id=' . $this->tb_ . '.end');
		return $this->db->get($this->tb_)->result();
	}
	/**
	 * countGraph
	 *
	 * @return void
	 */
	public function countGraph()
	{
		$this->db->from($this->tb_);
		return $this->db->count_all_results();
	}
}
