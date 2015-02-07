<?php
	class Login_service extends CI_Model{
		public function __construct()
		{
			parent::__construct();
			$this->load->user_model('muser/user_model', 'user_model');
			$this->load->library('session');
		}
		public function checkin($name, $pwd)
		{
			$data = $this->user_model->get_user_by_name_and_pwd($name, $pwd);
			$tmp = $data['data'];
			if( count($tmp) != 0 )
			{
				$this->session->set_userdata('user_name', $name);
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
			$this->session->set_userdata('user_name', '');
			$this->session->sess_destroy();
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
		public function islogin()
		{
			if( $name = $this->session->userdata('user_name') )
				return array(
					'code'=>0,
					'msg'=>'',
					'data'=>''
				);
			return array(
				'code'=>1,
				'msg'=>'',
				'data'=>''
			);
		}
}
