<?php
class Login_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('muser/user_model', 'user_model');
		$this->load->model('mcookie/cookie_model', 'cookie_model');
	}
	public function checkin($name, $pwd)
	{
		$names = array(
			'name'=>$name
		);
		$data = $this->user_model->get_user_by_name($names);
		$tmp = $data['data'];
		if( count($tmp) != 0)
		{
			$rand_value = $tmp[0]['randKeys'];
			$pwd .= $rand_value;
			$pwd = sha1($pwd);
			if( $pwd != $tmp[0]['password'] )
				return array(
					'code'=>1,
					'msg'=>'login failed, please check your account!',
					'data'=>''
				);
			$userId = $tmp[0]['userId'];
			$t = time();
			$ip = $this->input->ip_address();
			$value = sha1(uniqid('hbb_', TRUE));
			$value_encode = base64_encode($value);
			setcookie('user', $value_encode, $t+3600, '/', null);
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			
			$this->cookie_model->add_cookie($value_encode, $ip, $user_agent, $t, $userId);
			return array(
					'code'=>0,
					'msg'=>'login successfully.',
					'data'=>''
				    );
		}
		return array(
				'code'=>1,
				'msg'=>'login failed, please check your account!',
				'data'=>''
			    );
	}
	public function checkout()
	{
		if(isset($_COOKIE['user']))
		{
			$val = $_COOKIE['user'];
			setcookie('user',$val, time()-3600, '/', null);
			$this->cookie_model->del_cookie($val);
			return array(
					'code'=>0,
					'msg'=>'',
					'data'=>''
				    );
		}
		return array(
				'code'=>1,
				'msg'=>'checkout error.',
				'data'=>''
			    );
	}	
	public function islogin()
	{
		if(isset($_COOKIE['user']))
		{
			$ip = $this->input->ip_address();
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			$data = $this->cookie_model->get_cookie_by_id($_COOKIE['user']);
			$tmp = $data['data'];
			if( count($tmp) != 0 && $ip == $tmp[0]['ip_address'] && $user_agent == $tmp[0]['user_agent'] )
			{
				$userId = $tmp[0]['user_data'];
				return array(
						'code'=>0,
						'msg'=>'login',
						'data'=>$userId
					    );
			}
			else
			{
				return array(
						'code'=>1,
						'msg'=>'login failed.',
						'data'=>''
					    );
			}
		}
		return array(
				'code'=>1,
				'msg'=>'please login',
				'data'=>''
			    );
	}
}
