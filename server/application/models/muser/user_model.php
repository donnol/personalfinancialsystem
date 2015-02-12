<?php
	class User_model extends CI_Model{
		public function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		public function get_all_user()
		{
			$query = $this->db->get('t_user');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
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
		public function get_user_by_pwd($pwd)
		{
			$this->db->where('password', $pwd);
			$query = $this->db->get('t_user');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_user_by_name_and_pwd($name, $password)
		{
			$data = array(
				'name'=>$name,
				'password'=>$password
			);	
			$this->db->where($data);
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
			$this->db->like('name', $name);
			$query = $this->db->get('t_user');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_user_by_type($type)
		{
			$this->db->where('type', $type);
			$query = $this->db->get('t_user');
			$data = $query->result_array();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			);
		}
		public function get_user_by_name_and_type($name, $type)
		{
			$data = array(
				'name'=>$name,
				'type'=>$type
			);
			$this->db->like($data);
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
		public function add($name, $password, $type)
		{
			$data = array(
				'name'=>$name,
				'password'=>$password,
				'type'=>$type,
			);
			$this->db->insert('t_user', $data);
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function mod($userId, $name, $password, $type)
		{
			$data = array(
				'name'=>$name,
				'password'=>$password,
				'type'=>$type,
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
		public function mod_user_pwd($userId, $pwd)
		{
			$data = array(
				'password'=>$pwd
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

