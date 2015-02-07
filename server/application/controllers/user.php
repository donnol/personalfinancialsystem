<?php
	class User extends CI_Controller{
		public function __construct()
		{
			parent::__construct();
			$this->load->model('muser/user_service', 'user_service');
		}
		public function search()
		{
			$name = $this->input->post('name');
			$type = $this->input->post('type');

			$data['json'] = $this->user_service->get_user_by_name_and_type($name, $type);
			$this->load->view('json', $data);
		}
		public function get()
		{
			$userId = $this->input->post('userId');

			$data['json'] = $this->user_service->get_user_by_id($userId);
			$this->load->view('json', $data);
		}
		public function del()
		{
			$userId = $this->input->post('userId');

			$data['json'] = $this->user_service->del($userId);
			$this->load->view('json', $data);
		}
		public function add()
		{
			$name = $this->input->post('name');
			$password = sha1($this->input->post('password'));
			$type = $this->input->post('type');
			$createTime = time();
			$modifyTime = $createTime;

			$data['json'] = $this->user_service->add($name, $password, $type, $createTime, $modifyTime);
			$this->load->view('json', $data);
		}
		public function modType()
		{
			$userId = $this->input->post('userId');
			$type = $this->input->post('type');

			$data['json'] = $this->user_service->mod_user_type($userId, $type);
			$this->load->view('json', $data);
		}
		public function modPassword()
		{
			$userId = $this->input->post('userId');
			$password = $this->input->post('password');

			$data['json'] = $this->user_service->mod_user_pwd($userId, $password);
			$this->load->view('json', $data);
		}
		public function modMyPassword()
		{
			$userId = $this->input->post('userId');
			$old = sha1($this->input->post('oldpassword'));
			$new = sha1($this->input->post('newpassword'));
			
			$data['json'] = $this->user_service->mod_old_pwd($userId, $old, $new);
			$this->load->view('json', $data);
		}
}	
