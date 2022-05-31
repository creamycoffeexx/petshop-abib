<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{
	private $tb_ = 'user';

	/**
	 * login
	 *
	 * @return void
	 */
	public function login()
	{
		return $this->db->get_where($this->tb_, array('username' => $_POST['username'], 'password' => $_POST['password']))->row();
	}

	/**
	 * add
	 *
	 * @return void
	 */
	public function add()
	{
		$this->db->insert($this->tb_, array('username' => $_POST['username'], 'password' => $_POST['password']));
	}
	/**
	 * edit
	 *
	 * @return void
	 */
	public function edit()
	{
		$this->db->update($this->tb_, array('username' => $_POST['username'], 'password' => $_POST['password']), ['id' => $_POST['id']]);
	}
	/**
	 * delete
	 *
	 * @param  mixed $id
	 * @return void
	 */
	public function delete($id)
	{
		$this->db->delete($this->tb_, array('id' => $id));
	}
	/**
	 * getByID
	 *
	 * @param  mixed $id
	 * @return void
	 */
	public function getByID($id)
	{
		return $this->db->get_where($this->tb_, array('id' => $id))->row();
	}
}
