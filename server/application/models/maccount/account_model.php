<?php
class Account_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function search($where, $limit)
	{
		/*foreach($where as $key=>$value)
		{
			if($key == 'userId' OR $key == 'categoryId' OR $key == 'cardId' )
			{
				$this->db->where($key, $value);
			}
			else
			{
				$this->db->like($key, $value);
			}
		}*/
		$num = $this->db->count_all('t_account');

		foreach($where as $key=>$value)
		{
			if($key == 'userId' && $value != '')
			{
				$this->db->where($key, $value);
			}
			elseif($key == 'categoryId' && $value !='')
			{
				$this->db->where($key, $value);
			}
			elseif($key == 'cardId' && $value != '')
			{
				$this->db->where($key, $value);
			}
			else
			{
				$this->db->like($key, $value);
			}
		}

		if(isset($limit['pageSize']) && isset($limit['pageIndex']))
		{
			$size = $limit['pageSize'];
			$index = $limit['pageIndex'];
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
	/*public function mod($userId, $accountId, $name, $money, $type, $categoryId, $cardId, $remark)
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
	}*/
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
