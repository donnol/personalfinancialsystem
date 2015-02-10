<?php
class Login_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('muser/user_model', 'user_model');
		//	$this->load->library('session');
		$this->load->model('mcookie/cookie_model', 'cookie_model');
		$this->load->library('user_agent');
	}
	public function checkin($name, $pwd)
	{
		$data = $this->user_model->get_user_by_name_and_pwd($name, $pwd);
		$tmp = $data['data'];
		if( count($tmp) != 0)
		{
			$value = sha1(rand());
			$t = time();
			$ip = $this->input->ip_address();
			$user_agent = '';
			$result = $this->cookie_model->get_cookie_by_id($value);
			if( count($result['data']) != 0 )
				$value = sha1(rand());
			setcookie('user', $value, $t+3600, '/', null);
			if($this->agent->is_browser())
				$user_agent = $this->agent->browser().'/'.$this->agent->version();
			
			$this->cookie_model->add_cookie($value, $ip, $user_agent, $t, '');

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
		//	$this->session->unset_userdata('user_name');
		//	$this->session->sess_destroy();
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
			if( $this->agent->is_browser())
				$user_agent = $this->agent->browser().'/'.$this->agent->version();
			$data = $this->cookie_model->get_cookie_by_id($_COOKIE['user']);
			$tmp = $data['data'];
			if( count($tmp) != 0 && $ip == $tmp[0]['ip_address'] && $user_agent == $tmp[0]['user_agent'] )
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
