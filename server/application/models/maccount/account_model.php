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
		$this->db->order_by('modifyTime', 'DESC');
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
	public function get_account_by_order($ids, $order)
	{
		foreach($ids as $key=>$value)
		{
			$this->db->where($key, $value);
		}
		foreach($order as $key=>$value)
		{
			$this->db->order_by($key, $value);
		}
		$query = $this->db->get('t_account');
		$data = $query->result_array();
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$data
		);
	}
	public function get_min_time($ids)
	{
		$this->db->select_min('createTime');
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
	public function get_max_time($ids)
	{
		$this->db->select_max('createTime');
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
	public function sel($select, $where, $group)
	{
		foreach($select as $key=>$value)
		{
			if($key === 'money')
			{
				$this->db->select_sum($value);
			}
			else
			{
				$this->db->select($value); 
			} 
		} 
		foreach($where as $key=>$value)
		{
			$this->db->where($key, $value);
		}
		foreach($group as $key=>$value)
		{
			$this->db->group_by($value);
		}
		$this->db->from("t_account");
		$query = $this->db->get();
		$data = $query->result_array();
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$data
		);
	}
	public function sel_by_type($ids)
	{
		$sql = "select type, date_format(createTime, '%x') as year, date_format(createTime, '%v') as week, sum(money) as money from t_account where userId=? group by type, year, week";
		$query = $this->db->query($sql, $ids);
		$data = $query->result_array();
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$data
		);
	}
	public function sel_by_category($where)
	{
		$sql = "select categoryId, sum(money) as money from t_account where DATE_FORMAT(createTime, '%x') = ? and TRIM(LEADING '0' From DATE_FORMAT(createTime, '%v')) = ? and userId = ? and type = ? group by categoryId";
		$argv = array($where['year'], $where['week'], $where['userId'], $where['type']);
		$query = $this->db->query($sql, $argv);
		$data = $query->result_array();
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$data
		);
	}
	public function sel_by_card($ids)
	{
		$sql = "select DATE_FORMAT(createTime, '%x') as year, TRIM( LEADING '0' From DATE_FORMAT(createTime, '%v')) as week, cardId, type, SUM(Money) as money from t_account where userId = ? group by year, week, cardId, type order by year asc, week asc";
		$query = $this->db->query($sql, $ids);
		$data = $query->result_array();
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$data
		);
	}
	public function sel_by_type_with_card($where)
	{
		$sql = "select type, sum(money) as money from t_account where DATE_FORMAT(createTime, '%x') = ? and TRIM( LEADING '0' From DATE_FORMAT(createTime, '%v')) = ? and userId = ? and cardId = ? group by type";
		$argv = array($where['year'], $where['week'], $where['userId'], $where['cardId']);
		$query = $this->db->query($sql, $argv);
		$data = $query->result_array();
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$data
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
