<?php
class Card_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function get_card_by_name($userId, $name)
	{
		$this->db->where('userId', $userId);
		$this->db->where('name', $name);
		$query = $this->db->get('t_card');
		$data = $query->result_array();
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			    );
	}
	public function get_card_by_id($userId, $cardId)
	{
		$this->db->where('userId', $userId);
		$this->db->where('cardId', $cardId);
		$query = $this->db->get('t_card');
		$data = $query->result_array();
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			    );
	}
	/* search for the data with like statement */
	public function search($userId, $where, $limit)
	{
		$this->db->where('userId', $userId);
		foreach( $where as $key=>$value)
		{
			$this->db->like($key, $value);
		}
		$num = $this->db->count_all('t_card');

		$this->db->where('userId', $userId);
		foreach( $where as $key=>$value)
		{
			$this->db->like($key, $value);
		}

		$size = $limit['pageSize'];
		$offset = $limit['pageIndex'];
		if( $size != '')
		{
			$limit_size = $num - $limit['pageIndex'];
			if( $limit_size <= $size )
				$size = $limit_size;

			$this->db->limit($size, $offset);
		}
		$query = $this->db->get('t_card');
		$data = $query->result_array();
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			    );

	}
	public function del($userId, $cardId)
	{
		$this->db->where('userId', $userId);
		$this->db->where('cardId', $cardId);
		$this->db->delete('t_card');
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
	public function add($userId, $name, $bank, $card, $money, $remark)
	{
		$data = array(
				'userId'=>$userId,
				'name'=>$name,
				'bank'=>$bank,
				'card'=>$card,
				'money'=>$money,
				'remark'=>$remark
			     );
		$this->db->insert('t_card', $data);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
	public function mod($userId, $cardId, $name, $bank, $card, $money, $remark)
	{
		$data = array(
				'name'=>$name,
				'bank'=>$bank,
				'card'=>$card,
				'money'=>$money,
				'remark'=>$remark
			     );
		$this->db->where('userId', $userId);
		$this->db->where('cardId', $cardId);
		$this->db->update('t_card', $data);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
}
