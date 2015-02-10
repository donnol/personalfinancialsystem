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
		public function add($name, $password, $type, $createTime, $modifyTime)
		{
			$data = array(
				'name'=>$name,
				'password'=>$password,
				'type'=>$type,
				'createTime'=>$createTime,
				'modifyTime'=>$modifyTime
			);
			$this->db->insert('t_user', $data);
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function mod($userId, $name, $password, $type, $modifyTime)
		{
			$data = array(
				'name'=>$name,
				'password'=>$password,
				'type'=>$type,
				'modifyTime'=>$modifyTime
			);
			$this->db->where('userId', $userId);
			$this->db->update('t_user', $data);
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function mod_user_type($userId, $type, $modifyTime)
		{
			$data = array(
				'type'=>$type,
				'modifyTime'=>$modifyTime
			);
			$this->db->where('userId', $userId);
			$this->db->update('t_user', $data);
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function mod_user_pwd($name, $pwd, $modifyTime)
		{
			$data = array(
				'password'=>$pwd,
				'modifyTime'=>$modifyTime
			);
			$this->db->where('name', $name);
			$this->db->update('t_user', $data);
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
}

