<?php
class Login_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('muser/user_model', 'user_model');
		$this->load->model('mcookie/cookie_model', 'cookie_model');
		$this->load->library('user_agent');
	}
	public function checkin($name, $pwd)
	{
		$data = $this->user_model->get_user_by_name_and_pwd($name, $pwd);
		$tmp = $data['data'];
		if( count($tmp) != 0)
		{
			$userId = $tmp[0]['userId'];
			$t = time();
			$ip = $this->input->ip_address();
			$user_agent = '';
			$value = sha1(uniqid('hbb_', TRUE));
			$value_encode = base64_encode($value);
			setcookie('user', $value_encode, $t+3600, '/', null);
			
			if($this->agent->is_browser())
			{
				$user_agent = $this->agent->browser().'/'.$this->agent->version();
			}
			elseif($this->agent->is_robot())
			{
				$user_agent = $this->agent->robot();
			}
			elseif($this->agent->is_mobile())
			{
				$user_agent = $this->agent->mobile();
			}
			else
			{
				$user_agent = 'Unidentified User Agent';
			}
			
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
			if($this->agent->is_browser())
			{
				$user_agent = $this->agent->browser().'/'.$this->agent->version();
			}
			elseif($this->agent->is_robot())
			{
				$user_agent = $this->agent->robot();
			}
			elseif($this->agent->is_mobile())
			{
				$user_agent = $this->agent->mobile();
			}
			else
			{
				$user_agent = 'Unidentified User Agent';
			}

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
