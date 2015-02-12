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

		$size = $limit['pageSize'];
		$limit_size = $num - $limit['pageIndex'];
		if( $size != '')
		{
			if( $limit_size <= $size )
				$size = $limit_size;

			$this->db->limit($size, $limit['pageIndex']);
		}
		$query = $this->db->get('t_user');
		$data = $query->result_array();
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
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
	public function add($name, $password, $rand_value, $type)
	{
		$data = array(
				'name'=>$name,
				'password'=>$password,
				'randKeys' =>$rand_value, 
				'type'=>$type
			     );
		$this->db->insert('t_user', $data);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
	public function mod($userId, $name, $password, $rand_value, $type)
	{
		$data = array(
				'name'=>$name,
				'password'=>$password,
				'randKeys'=>$rand_value,
				'type'=>$type
			     );
		$this->db->where('userId', $userId);
		$this->db->update('t_user', $data);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
	public function mod_user_type($userId, $type)
	{
		$data = array(
				'type'=>$type
			     );
		$this->db->where('userId', $userId);
		$this->db->update('t_user', $data);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
	public function mod_user_pwd($userId, $pwd, $rand_value)
	{
		$data = array(
				'password'=>$pwd,
				'randKeys'=>$rand_value
			     );
		$this->db->where('userId', $userId);
		$this->db->update('t_user', $data);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
}

