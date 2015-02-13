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

		$ids = array(
			'userId'=>$userId
		);
		$result = $this->user_service->get_user_by_id($ids);
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
		$where = array(
				'name'=>$name,
				'type'=>$type
			      );
		if( $pageIndex == FALSE OR $pageSize == FALSE )
		{
			$limit = array();
		}
		else
		{
			$limit = array(
				'pageIndex'=>$pageIndex,
				'pageSize'=>$pageSize
			);
		}

		$data['json'] = $this->user_service->search($where, $limit);
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
		$where = array(
			'userId'=>$userId
		);

		$data['json'] = $this->user_service->get_user_by_id($where);
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
		$ids = array(
			'userId'=>$adminId
		);
		$result = $this->user_service->get_user_by_id($ids);
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
		$where = array(
			'userId'=>$userId
		);
		$result = $this->user_service->get_user_by_id($where);
		if( $result['data']['type'] == '0' )
		{
			$data['json'] = array(
				'code'=>1,
				'msg'=>'you cant delete the manager.',
				'data'=>''
			);
			$this->load->view('json', $data);
			return;
		}

		$data['json'] = $this->user_service->del($where);
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
		$ids = array(
			'userId'=>$adminId
		);
		$result = $this->user_service->get_user_by_id($ids);
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
		$password = $this->input->post('password');
		$type = $this->input->post('type');

		$array = array(
			'name'=>$name,
			'password'=>$password,
			'type'=>$type
		);
		$data['json'] = $this->user_service->add($array);
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
		$ids = array(
			'userId'=>$adminId
		);
		$result = $this->user_service->get_user_by_id($ids);
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
		$ids = array(
			'userId'=>$userId
		);
		$result = $this->user_service->get_user_by_id($ids);
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
		$where = array(
			'userId'=>$userId
		);
		$mod_data = array(
			'type'=>$type	
		);

		$data['json'] = $this->user_service->mod_user_type($where, $mod_data);
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
		$adminId = $result['data'];
		$ids = array(
			'userId'=>$adminId
		);
		$result = $this->user_service->get_user_by_id($ids);
		$userId = $this->input->post('userId');
		$password = $this->input->post('password');
		$where = array(
			'userId'=>$userId
		);
		$mod_data = array(
			'password'=>$password
		);
		if( $result['data']['type'] == '0' )
		{
			if($adminId != $userId)
			{
				$data['json'] = array(
						'code'=>1,
						'msg'=>'you cant mod user password.',
						'data'=>''
						);
				$this->load->view('json', $data);
				return;
			}
			else
			{
				$data['json'] = $this->user_service->mod_user_pwd($where, $mod_data);	
				$this->load->view('json', $data);
				return;
			}
		}
		
		$data['json'] = $this->user_service->mod_user_pwd($where, $mod_data);
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
		$userId = $result['data'];
		$old = $this->input->post('oldPassword');
		$new = $this->input->post('newPassword');
		$where = array(
			'userId'=>$userId
		);
		$array = array(
			'old'=>$old,
			'new'=>$new
		);

		$data['json'] = $this->user_service->mod_old_pwd($where, $array);
		$this->load->view('json', $data);
	}
}	
