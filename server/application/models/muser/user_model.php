<?php
class User_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function get_user_by_id($where)
	{
		foreach($where as $key=>$value)
		{
			$this->db->where($key, $value);
		}
		$query = $this->db->get('t_user');
		$data = $query->result_array();
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			    );
	}
	public function get_user_by_name($where)
	{
		foreach($where as $key=>$value)
		{
			$this->db->where($key, $value);
		}
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
		$num = $this->db->count_all('t_user');

		foreach($where as $key=>$value)
		{
			if( $key == 'userId' && $value != '' )
			{
				$this->db->where($key, $value);
			}
			else{
				$this->db->like($key, $value);
			}
		}

		if( isset($limit['pageSize']) && isset($limit['pageIndex']) && $limit['pageSize'] != FALSE )
			$this->db->limit($limit['pageSize'], $limit['pageIndex']);
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
	public function del($where)
	{
		foreach($where as $key=>$value)
		{
			$this->db->where($key, $value);
		}
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
	public function mod($where, $data)
	{
		foreach($where as $key=>$value)
		{
			$this->db->where($key, $value);
		}
		$this->db->update('t_user', $data);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
	public function mod_user_type($where,$data)
	{
		foreach($where as $key=>$value)
		{
			$this->db->where($key, $value);
		}
		$this->db->update('t_user', $data);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
	public function mod_user_pwd($where, $data)
	{
		foreach($where as $key=>$value)
		{
			$this->db->where($key, $value);
		}
		$this->db->update('t_user', $data);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
}

