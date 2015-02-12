<?php
class Account_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function search($userId, $id, $where, $limit)
	{
		$this->db->where('userId', $userId);
		foreach($id as $key=>$value)
		{
			if($value != '')
				$this->db->where($key, $value);
		}
		foreach($where as $key=>$value)
		{
			$this->db->like($key, $value);
		}
		$num = $this->db->count_all('t_account');

		$this->db->where('userId', $userId);
		foreach($id as $key=>$value)
		{
			if($value != '')
				$this->db->where($key, $value);
		}
		foreach($where as $key=>$value)
		{
			$this->db->like($key, $value);
		}

		$size = $limit['pageSize'];
		$index = $limit['pageIndex'];
		if( $size != '')
		{
			$limit_size = $num - $index;
			if( $limit_size <= $size )
				$size = $limit_size;

			$this->db->limit($size, $index);
		}
		$query = $this->db->get('t_account');
		$data = $query->result_array();
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			    );
	}
	public function get_account_by_id($userId, $accountId)
	{
		$this->db->where('userId', $userId);
		$this->db->where('accountId', $accountId);
		$query = $this->db->get('t_account');
		$data = $query->result_array();
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			    );
	}
	public function get_account_by_name($userId, $name)
	{
		$this->db->where('userId', $userId);
		$this->db->where('name', $name);
		$query = $this->db->get('t_account');
		$data = $query->result_array();
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			    );
	}
	public function del($userId, $accountId)
	{
		$this->db->where('userId', $userId);
		$this->db->where('accountId', $accountId);
		$this->db->delete('t_account');
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
	public function add($userId, $name, $money, $type, $categoryId, $cardId, $remark)
	{
		$data = array(
				'userId'=>$userId,
				'name'=>$name,
				'money'=>$money,
				'type'=>$type,
				'categoryId'=>$categoryId,
				'cardId'=>$cardId,
				'remark'=>$remark
			     );
		$this->db->insert('t_account',$data);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
	public function mod($userId, $accountId, $name, $money, $type, $categoryId, $cardId, $remark)
	{
		$data = array(
				'name'=>$name,
				'money'=>$money,
				'type'=>$type,
				'categoryId'=>$categoryId,
				'cardId'=>$cardId,
				'remark'=>$remark
			     );
		$this->db->where('userId', $userId);
		$this->db->where('accountId', $accountId);
		$this->db->update('t_account', $data);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
}
