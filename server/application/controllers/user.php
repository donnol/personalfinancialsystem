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
		$userId = $result['data'];
		$name = $this->input->get('name');
		$type = $this->input->get('type');
		$pageIndex = $this->input->get('pageIndex');
		$pageSize = $this->input->get('pageSize');

		$result = $this->user_service->get_user_by_id($userId);
		if( $result['data']['type'] != '0' )
		{
			$tmp[0] = $result['data'];
			$tmp_data = array(
				'count'=>1,
				'data'=>$tmp
			);
			 $data['json'] = array(
				'code'=>0,
				'msg'=>'not admin',
				'data'=>$tmp_data
			);
			$this->load->view('json', $data);
			return;
		}
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
		$adminId = $result['data'];
		$result = $this->user_service->get_user_by_id($adminId);
		if( $result['data']['type'] != '0' )
		{
			$data['json'] = array(
				'code'=>1,
				'msg'=>'you dont have the permission to delete user.',
				'data'=>''
			);
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
		$adminId = $result['data'];
		$result = $this->user_service->get_user_by_id($adminId);
		if( $result['data']['type'] != '0' )
		{
			$data['json'] = array(
				'code'=>1,
				'msg'=>'you dont have the permission to add user.',
				'data'=>''
			);
			$this->load->view('json', $data);
			return;
		}

		$name = $this->input->post('name');
		$password = sha1($this->input->post('password'));
		$type = $this->input->post('type');
		$createTime = date('Y-m-d H:i:s');
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
		$adminId = $result['data'];
		$result = $this->user_service->get_user_by_id($adminId);
		if( $result['data']['type'] != '0' )
		{
			$data['json'] = array(
				'code'=>1,
				'msg'=>'you dont have the permission to mod user.',
				'data'=>''
			);
			$this->load->view('json', $data);
			return;
		}

		$userId = $this->input->post('userId');
		$result = $this->user_service->get_user_by_id($userId);
		if( $result['data']['type'] == '0' )
		{
			$data['json'] = array(
				'code'=>1,
				'msg'=>'you cant mod the manager type.',
				'data'=>''
			);
			$this->load->view('json', $data);
			return;
		}
		$type = $this->input->post('type');
		$modifyTime = date('Y-m-d H:i:s');

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
		$result = $this->user_service->get_user_by_id($userId);
		if( $result['data']['type'] == '0' )
		{
			$data['json'] = array(
				'code'=>1,
				'msg'=>'you cant mod the manager type.',
				'data'=>''
			);
			$this->load->view('json', $data);
			return;
		}
		$password = sha1($this->input->post('password'));
		$modifyTime = date('Y-m-d H:i:s');

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
		$modifyTime = date('Y-m-d H:i:s');

		$data['json'] = $this->user_service->mod_old_pwd($old, $new, $modifyTime);
		$this->load->view('json', $data);
	}
}	
