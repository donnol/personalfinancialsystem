<?php
class User_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('muser/user_model', 'user_model');
	}
	public function get_user_by_id($userId)
	{
		$data = $this->user_model->get_user_by_id($userId);
		$num = count($data['data']);
		if( $num == 0 )
			return array(
					'code'=>1,
					'msg'=>'no data',
					'data'=>''
				    );
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data['data'][0]
			    );
	}
	public function del($userId)
	{
		$data = $this->user_model->del($userId);
		return $data;
	}
	public function add($array)
	{
		$name = $array['name'];
		$password = $array['password'];
		$type = $array['type'];

		$data = $this->user_model->get_user_by_name($name);
		if( count($data['data']) != 0 )
			return array(
					'code'=>1,
					'msg'=>'name is already exist.',
					'data'=>''
				    );
		$rand_value = uniqid();
		$password .= $rand_value;
		$password = sha1($password);
		$array = array(
			'name'=>$name,
			'password'=>$password,
			'randKeys'=>$rand_value,
			'type'=>$type
		);
		$data = $this->user_model->add($array);
		return $data;
	}
	public function mod_user_type($userId, $type)
	{
		$array = array(
			'type'=>$type
		);
		$data = $this->user_model->mod_user_type($userId, $array);
		return $data;
	}
	public function mod_user_pwd($userId, $pwd)
	{
		$rand_value = uniqid();
		$pwd .= $rand_value;
		$pwd = sha1($pwd);
		$array = array(
			'password'=>$pwd,
			'randKeys'=>$rand_value
		);
		$data = $this->user_model->mod_user_pwd($userId, $array);
		return $data;
	}
	public function mod_old_pwd($userId, $array)
	{
		$data = $this->user_model->get_user_by_id($userId);
		$tmp = $data['data'];
		if( count($data['data']) != 0 )
		{
			$rand_value = $tmp[0]['randKeys'];
			$old = $array['old'];
			$new = $array['new'];
			$old .= $rand_value;
			$old = sha1($old);
			if( $old != $tmp[0]['password'] )
				return array(
					'code'=>1,
					'msg'=>'check your password.',
					'data'=>''
				);
			$rand_value = uniqid();
			$new .= $rand_value;
			$new = sha1($new);
			$array = array(
				'password'=>$new,
				'randKeys'=>$rand_value
			);
			$data = $this->user_model->mod_user_pwd($userId, $array);
			return $data;
		}
		return array(
				'code'=>1,
				'msg'=>'check your password',
				'data'=>''
			    );
	}
	public function search($where, $limit)
	{
		$data = $this->user_model->search($where, $limit);
		return $data;
	}
} 
