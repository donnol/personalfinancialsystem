<?php
class Account_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function search($where, $limit)
	{
		foreach($where as $key=>$value)
		{
			if($key == 'userId')
			{
				$this->db->where($key, $value);
			}
			elseif($key == 'categoryId' )
			{
				$this->db->where($key, $value);
			}
			elseif($key == 'cardId' )
			{
				$this->db->where($key, $value);
			}
			else
			{
				$this->db->like($key, $value);
			}

		}
		$this->db->from('t_account');
		$num = $this->db->count_all_results();

		foreach($where as $key=>$value)
		{
			if($key == 'userId')
			{
				$this->db->where($key, $value);
			}
			elseif($key == 'categoryId' )
			{
				$this->db->where($key, $value);
			}
			elseif($key == 'cardId' )
			{
				$this->db->where($key, $value);
			}
			else
			{
				$this->db->like($key, $value);
			}
		}

		if(isset($limit['pageSize']) && isset($limit['pageIndex']) && $limit['pageSize'] != FALSE )
			$this->db->limit($limit['pageSize'], $limit['pageIndex']);
		$query = $this->db->get('t_account');
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
	public function get_account_by_id($ids)
	{
		foreach($ids as $key=>$value)
		{
			$this->db->where($key, $value);
		}
		$query = $this->db->get('t_account');
		$data = $query->result_array();
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			    );
	}
	public function get_account_by_name($names)
	{
		foreach($names as $key=>$value)
		{
			$this->db->where($key, $value);
		}
		$query = $this->db->get('t_account');
		$data = $query->result_array();
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			    );
	}
	public function del($ids)
	{
		foreach($ids as $key=>$value)
		{
			$this->db->where($key, $value);
		}
		$this->db->delete('t_account');
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
	public function add($data)
	{
		$this->db->insert('t_account',$data);
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
		$this->db->update('t_account', $data);
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>''
		);
	}
}
