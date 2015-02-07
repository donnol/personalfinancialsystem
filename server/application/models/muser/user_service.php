<?php
	class User_service extends CI_Model{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('muser/user_model', 'user_model');
		}
		public function get_all_user()
		{
			$data = $this->user_model->get_all_user();
			if( count($data['data']) == 0 )
				return array(
					'code'=>1,
					'msg'=>'no data',
					'data'=>''
				);
			return $data;
		}
		public function get_user_by_id($userId)
		{
			$data = $this->user_model->get_user_by_id($userId);
			if( count($data['data']) == 0 )
				return array(
					'code'=>1,
					'msg'=>'no data',
					'data'=>''
				);
			return $data;
		}
		public function del($userId)
		{
			$data = $this->user_model->del($userId);
			return $data;
		}
		public function add($name, $password, $type, $createTime, $modifyTime)
		{
			$data = $this->user_model->get_user_by_name($name);
			if( count($data['data']) != 0 )
				return array(
					'code'=>1,
					'msg'=>'name is already exist.',
					'data'=>''
				);
			$data = $this->user_model->add($name, $password, $type, $createTime, $modifyTime);
			return $data;
		}
		public function mod_user_type($userId, $type)
		{
			$data = $this->user_model->mod_user_type($userId, $type);
			return $data;
		}
		public function mod_user_pwd($userId, $pwd)
		{
			$data = $this->user_model->mod_user_pwd($userId, $pwd);
			return $data;
		}
		public function mod_old_pwd($userId, $old, $new)
		{
			$data = $this->user_model->get_pwd_by_id($userId);
			$tmp = $data['data'];
			if( $tmp[0]['password'] == $old )
			{
				$data = $this->user_model->mod_user_pwd($userId, $new);
				return $data;
			}
			return array(
				'code'=>1,
				'msg'=>'wrong password',
				'data'=>''
			);
		}
		public function get_user_by_name_and_type($name, $type)
		{
			$data = $this->user_model->get_user_by_name_and_type($name, $type);
			if( count($data['data']) == 0)
				return array(
					'code'=>1,
					'msg'=>'no data',
					'data'=>''
				);
			return $data;
		}
} 
