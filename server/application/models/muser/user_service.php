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
	public function add($name, $password, $type)
	{
		$data = $this->user_model->get_user_by_name($name);
		if( count($data['data']) != 0 )
			return array(
					'code'=>1,
					'msg'=>'name is already exist.',
					'data'=>''
				    );
		$rand_value = rand();
		$password .= $rand_value;
		$password = sha1($password);
		$data = $this->user_model->add($name, $password, $rand_value, $type);
		return $data;
	}
	public function mod_user_type($userId, $type)
	{
		$data = $this->user_model->mod_user_type($userId, $type);
		return $data;
	}
	public function mod_user_pwd($userId, $pwd)
	{
		$rand_value = rand();
		$pwd .= $rand_value;
		$pwd = sha1($pwd);
		$data = $this->user_model->mod_user_pwd($userId, $pwd, $rand_value);
		return $data;
	}
	public function mod_old_pwd($userId, $old, $new)
	{
		$data = $this->user_model->get_user_by_id($userId);
		$tmp = $data['data'];
		if( count($data['data']) != 0 )
		{
			$rand_value = $tmp[0]['randKeys'];
			$old .= $rand_value;
			$old = sha1($old);
			if( $old != $tmp[0]['password'] )
				return array(
					'code'=>1,
					'msg'=>'check your password.',
					'data'=>''
				);
			$rand_value = rand();
			$new .= $rand_value;
			$new = sha1($new);
			$data = $this->user_model->mod_user_pwd($userId, $new, $rand_value);
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
		$num = count($data['data']);
		$result = array(
			'count'=>$num,
			'data'=>$data['data']
		);
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$result
		);
	}
} 
