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
		$where = array();
		$limit = array();
		$ids = array();

		$userId = $result['data'];
		$ids['userId'] = $userId;
		if( ($name = $this->input->get('name')) !== FALSE )
			$where['name'] = $name;
		if( ($type = $this->input->get('type')) !== FALSE )
			$where['type'] = $type;
		if( ($pageIndex = $this->input->get('pageIndex')) !== FALSE )
			$limit['pageIndex'] = $pageIndex;
		if( ($pageSize = $this->input->get('pageSize')) !== FALSE )
			$limit['pageSize'] = $pageSize;

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
		$where = array();

		if( ($userId = $this->input->get('userId')) !== FALSE )
			$where['userId'] = $userId;

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
		if( ($userId = $this->input->post('userId')) !== FALSE )
			$ids = array(
					'userId'=>$userId
				      );
		$result = $this->user_service->get_user_by_id($ids);
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

		$add_data = array();
		if( ($name = $this->input->post('name')) !== FALSE )
			$add_data['name'] = $name;
		if( ($password = $this->input->post('password')) !== FALSE )
			$add_data['password'] = $password;
		if( ($type = $this->input->post('type')) !== FALSE )
			$add_data['type'] = $type;

		$data['json'] = $this->user_service->add($add_data);
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

		if( ($userId = $this->input->post('userId')) !== FALSE )
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
		$where = array(
			'userId'=>$userId
		);

		if( ($type = $this->input->post('type')) !== FALSE )
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
		if( ($userId = $this->input->post('userId')) !== FALSE )
			$where = array(
					'userId'=>$userId
				      );
		if( ($password = $this->input->post('password')) !== FALSE )
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
		$where = array();
		$mod_data = array();

		$userId = $result['data'];
		$where['userId'] = $userId;
		if( ($old = $this->input->post('oldPassword')) !== FALSE )
			$mod_data['old'] = $old;
		if( ($new = $this->input->post('newPassword')) !== FALSE )
			$mod_data['new'] = $new;

		$data['json'] = $this->user_service->mod_old_pwd($where, $mod_data);
		$this->load->view('json', $data);
	}
}	
