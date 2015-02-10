<?php
class Login_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('muser/user_model', 'user_model');
		//	$this->load->library('session');
		$this->load->model('mcookie/cookie_model', 'cookie_model');
	}
	public function checkin($name, $pwd)
	{
		$data = $this->user_model->get_user_by_name_and_pwd($name, $pwd);
		$tmp = $data['data'];
		if( count($tmp) != 0)
		{
			$value = sha1(rand());
			$t = time();
			setcookie('user', $value, $t+3600);
			$this->cookie_model->add_cookie($value,'', '', $t, '');
			//		$this->session->set_userdata('user_name', $name);
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
		//setcookie('user', '', time()-3600);
		$this->cookie_model->del_cookie($_COOKIE['user']);
		//	$this->session->unset_userdata('user_name');
		//	$this->session->sess_destroy();
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
	public function islogin()
	{
		if(isset($_COOKIE['user']))
				{
				$data = $this->cookie_model->get_cookie_by_id($_COOKIE["user"]);
				$tmp = $data['data'];
				if( count($tmp) != 0 )
				//	if( $name = $this->session->userdata('user_name') )
				{
				return array(
					'code'=>0,
					'msg'=>'login',
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
