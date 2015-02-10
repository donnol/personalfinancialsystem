<?php
class User extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('muser/user_service', 'user_service');
		$this->load->model('muser/login_service', 'login_service');
	}
	public function search()
	{
		$result = $this->login_service->islogin();
		if( $result['code'] != 0 )
		{
			$data['json'] = $result;
			$this->load->view('json', $data);
			return;
		}
		$name = $this->input->get('name');
		$type = $this->input->get('type');
		$pageIndex = $this->input->get('pageIndex');
		$pageSize = $this->input->get('pageSize');
		if($name != '' && $type != '')
		{
			$data['json'] = $this->user_service->get_user_by_name_and_type($name, $type, $pageIndex, $pageSize);
			$this->load->view('json', $data);
			return;
		}
		if($name != '')
		{
			$data['json'] = $this->user_service->get_user_by_name($name, $pageIndex, $pageSize);
			$this->load->view('json', $data);
			return;
		}
		if($type != '')
		{
			$data['json'] = $this->user_service->get_user_by_type($type, $pageIndex, $pageSize);
			$this->load->view('json', $data);
			return;
		}


		$data['json'] = $this->user_service->get_all_user($pageIndex, $pageSize);
		$this->load->view('json', $data);
	}
	public function get()
	{
		$result = $this->login_service->islogin();
		if( $result['code'] != 0 )
		{
			$data['json'] = $result;
			$this->load->view('json', $data);
			return;
		}
		$userId = $this->input->get('userId');

		$data['json'] = $this->user_service->get_user_by_id($userId);
		$this->load->view('json', $data);
	}
	public function del()
	{
		$result = $this->login_service->islogin();
		if( $result['code'] != 0 )
		{
			$data['json'] = $result;
			$this->load->view('json', $data);
			return;
		}
		$userId = $this->input->post('userId');

		$data['json'] = $this->user_service->del($userId);
		$this->load->view('json', $data);
	}
	public function add()
	{
		$result = $this->login_service->islogin();
		if( $result['code'] != 0 )
		{	
			$data['json'] = $result;
			$this->load->view('json', $data);
			return;
		}
		$name = $this->input->post('name');
		$password = sha1($this->input->post('password'));
		$type = $this->input->post('type');
		$createTime = date('Y-m-d H:m:s');
		$modifyTime = $createTime;

		$data['json'] = $this->user_service->add($name, $password, $type, $createTime, $modifyTime);
		$this->load->view('json', $data);
	}
	public function modType()
	{
		$result = $this->login_service->islogin();
		if( $result['code'] != 0 )
		{	
			$data['json'] = $result;
			$this->load->view('json', $data);
			return;
		}
		$userId = $this->input->post('userId');
		$type = $this->input->post('type');
		$modifyTime = date('Y-m-d H:m:s');

		$data['json'] = $this->user_service->mod_user_type($userId, $type, $modifyTime);
		$this->load->view('json', $data);
	}
	public function modPassword()
	{
		$result = $this->login_service->islogin();
		if( $result['code'] != 0 )
		{	
			$data['json'] = $result;
			$this->load->view('json', $data);
			return;
		}
		$userId = $this->input->post('userId');
		$password = sha1($this->input->post('password'));
		$modifyTime = date('Y-m-d H:m:s');

		$data['json'] = $this->user_service->mod_user_pwd($userId, $password, $modifyTime);
		$this->load->view('json', $data);
	}
	public function modMyPassword()
	{
		$result = $this->login_service->islogin();
		if( $result['code'] != 0 )
		{	
			$data['json'] = $result;
			$this->load->view('json', $data);
			return;
		}
		$old = sha1($this->input->post('oldPassword'));
		$new = sha1($this->input->post('newPassword'));
		$modifyTime = date('Y-m-d H:m:s');

		$data['json'] = $this->user_service->mod_old_pwd($old, $new, $modifyTime);
		$this->load->view('json', $data);
	}
}	
