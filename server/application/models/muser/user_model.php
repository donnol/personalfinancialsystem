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
		public function get_user_by_name_and_pwd($name, $passowrd)
		{
			$data = array(
				'name'=>$name,
				'$password'=>$password,
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
			$data = array(
				'name'=>$name
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
		public function get_user_by_name_and_type($name, $type)
		{
			$data = array(
				'name'=>$name,
				'type'=>$type
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
		public function get_pwd_by_id($userId)
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
			$this->db->where($data);
			$this->db->insert('t_user');
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function mod($name, $password, $type, $modifyTime)
		{
			$data = array(
				'name'=>$name,
				'password'=>$password,
				'type'=>$type,
				'modifyTime'=>$modifyTime
			);
			$this->db->where($data);
			$this->db->update('t_user');
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function mod_user_type($userId, $type)
		{
			$data = array(
				'userId'=>$userId,
				'type'=>$type
			);
			$this->db->where($data);
			$this->db->update('t_user');
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function mod_user_pwd($userId, $pwd)
		{
			$data = array(
				'userId'=>$userId,
				'password'=>$pwd
			);
			$this->db->where($data);
			$this->db->update('t_user');
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
}

