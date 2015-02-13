<?php
class User_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('muser/user_model', 'user_model');
		$this->load->model('maccount/account_model', 'account_model');
	}
	public function get_user_by_id($where)
	{
		$data = $this->user_model->get_user_by_id($where);
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
	public function del($where)
	{
		$data = $this->user_model->del($where);
		$result = $this->account_model->del($where);
		return $data;
	}
	public function add($array)
	{
		$name = $array['name'];
		$password = $array['password'];
		$type = $array['type'];
		$names = array(
			'name'=>$name
		);
		$data = $this->user_model->get_user_by_name($names);
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
	public function mod_user_type($where, $data)
	{
		$result = $this->user_model->mod_user_type($where, $data);
		return $result;
	}
	public function mod_user_pwd($where, $data)
	{
		$pwd = $data['password'];
		$rand_value = uniqid();
		$pwd .= $rand_value;
		$pwd = sha1($pwd);
		$array = array(
			'password'=>$pwd,
			'randKeys'=>$rand_value
		);
		$data = $this->user_model->mod_user_pwd($where, $array);
		return $data;
	}
	public function mod_old_pwd($where, $array)
	{
		$result = $this->user_model->get_user_by_id($where);
		$tmp = $result['data'];
		if( count($result['data']) != 0 )
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
			$result= $this->user_model->mod_user_pwd($where, $array);
			return $result;
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
