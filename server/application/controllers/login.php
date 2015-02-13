<?php
	class Login extends CI_Controller{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('muser/login_service', 'login_service');
		}
		public function checkin()
		{
			$where = array();

			if( $name = $this->input->post('name'))
				$where['name'] = $name;
			if( $pwd = $this->input->post('password'))
				$where['pwd'] = $pwd;
			
			$data['json'] = $this->login_service->checkin($where);
			$this->load->view('json', $data);
		}
		public function checkout()
		{
			$data['json'] = $this->login_service->checkout();
			$this->load->view('json', $data);
		}
		public function islogin()
		{
			$data['json'] = $this->login_service->islogin();
			$this->load->view('json', $data);
		}
}
