<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NodeModel extends CI_Model
{
	private $tb_ = 'node';

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
	 * add
	 *
	 * @return void
	 */
	public function add()
	{
		$this->db->insert($this->tb_, array(
			'name' => $_POST['name'],
			'lat' => $_POST['lat'],
			'lng' => $_POST['lng'],
			'desc' => $_POST['desc'],
			'picture' => $_POST['picture'],
			'type' => $_POST['type'],
		));
	}

	/**
	 * edit
	 *
	 * @return void
	 */
	public function edit()
	{
		$this->db->update($this->tb_, array(
			'name' => $_POST['name'],
			'lat' => $_POST['lat'],
			'lng' => $_POST['lng'],
			'desc' => $_POST['desc'],
			'picture' => $_POST['picture'],
		), [
			'id' => $_POST['id']
		]);
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
	 * getRSData
	 *
	 * @return void
	 */
	public function getObjects()
	{
		return $this->db->get_where($this->tb_, ['type' => 'object'])->result();
	}
	/**
	 * getObjectsOffset
	 *
	 * @return void
	 */
	public function getObjectsOffset($limit, $offset)
	{
		return $this->db->get_where($this->tb_, ['type' => 'object'], $limit, $offset)->result();
	}
	/**
	 * getNodeData
	 *
	 * @return void
	 */
	public function getNodeData()
	{
		return $this->db->get_where($this->tb_, ['type' => '-'])->result();
	}
	/**
	 * getNodeData
	 *
	 * @return void
	 */
	public function getData()
	{
		return $this->db->get($this->tb_,)->result();
	}


	public function getDatajoin()
	{
		return $this->db->query("SELECT graph.id,graph.start,n1.name as name1,n2.name as name2,distance,time FROM graph INNER JOIN node as n1 ON n1.id = graph.start INNER JOIN node as n2 ON n2.id = graph.end")->result();
	}


	/**
	 * countRS
	 *
	 * @return void
	 */
	public function countObject()
	{
		$this->db->where('type', 'object');
		$this->db->from($this->tb_);
		return $this->db->count_all_results();
	}
	/**
	 * countSimpul
	 *
	 * @return void
	 */
	public function countSimpul()
	{
		$this->db->where('type', '-');
		$this->db->from($this->tb_);
		return $this->db->count_all_results();
	}
}
