<?php
class User_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function get_user_by_id($userId)
	{
		$this->db->where('userId', $userId);
		$query = $this->db->get('t_user');
		$data = $query->result_array();
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			    );
	}
	public function get_user_by_name($name)
	{
		$this->db->where('name', $name);
		$query = $this->db->get('t_user');
		$data = $query->result_array();
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			    );
	}
	public function search($where, $limit)
	{
		foreach($where as $key=>$value)
		{
			$this->db->like($key, $value);
		}
		$num = $this->db->count_all('t_user');

		foreach($where as $key=>$value)
		{
			$this->db->like($key, $value);
		}

		if( isset($limit['pageSize']) && isset($limit['pageIndex']))
		{
			$size = $limit['pageSize'];
			$this->db->limit($size, $limit['pageIndex']);
		}
		$query = $this->db->get('t_user');
		$data = $query->result_array();
		$result = array(
			'count'=>$num,
			'data'=>$data
		);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$result
			    );
	}
	public function del($userId)
	{
		$this->db->where('userId', $userId);
		$this->db->delete('t_user');
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
	public function add($data)
	{
		$this->db->insert('t_user', $data);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
	public function mod($userId, $data)
	{
		$this->db->where('userId', $userId);
		$this->db->update('t_user', $data);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
	public function mod_user_type($userId,$data)
	{
		$this->db->where('userId', $userId);
		$this->db->update('t_user', $data);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
	public function mod_user_pwd($userId, $data)
	{
		$this->db->where('userId', $userId);
		$this->db->update('t_user', $data);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
}

