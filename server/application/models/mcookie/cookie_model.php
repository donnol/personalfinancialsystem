<?php
class Cookie_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function get_cookie()
	{
		$query = $this->db->get('ci_sessions');
		$data = $query->result_array();
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$data
		);
	}
	public function get_cookie_by_id($ids)
	{
		foreach($ids as $key=>$value)
		{
			$this->db->where($key, $value);
		}
		$query = $this->db->get('ci_sessions');
		$data = $query->result_array();
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$data
		);
	}
	public function add_cookie($data)
	{
		$this->db->insert('ci_sessions', $data);
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>''
		);
	}
	public function del_cookie($ids)
	{
		foreach($ids as $key=>$value)
		{
			$this->db->where($key, $value);
		}
		$this->db->delete('ci_sessions');
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>''
		);
	}
}
