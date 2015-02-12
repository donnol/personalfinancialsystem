<?php
class Category extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mcategory/category_service', 'category_service');
		$this->load->model('muser/login_service', 'login_service');
		$this->load->model('muser/user_service', 'user_service');
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
		$remark = $this->input->get('remark');
		$pageIndex = $this->input->get('pageIndex');
		$pageSize = $this->input->get('pageSize');

		$where = array(
			'name'=>$name,
			'remark'=>$remark
		);
		$limit = array(
			'pageIndex'=>$pageIndex,
			'pageSize'=>$pageSize
		);

		$data['json'] = $this->category_service->search($userId, $where, $limit);
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
		$userId = $result['data'];
		$categoryId = $this->input->get('categoryId');

		$data['json'] = $this->category_service->get_category_by_id($userId, $categoryId);
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
		$userId = $result['data'];
		$categoryId = $this->input->post('categoryId');

		$data['json'] = $this->category_service->del($userId, $categoryId);
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

		$userId = $result['data'];
		$name = $this->input->post('name');
		$remark = $this->input->post('remark');

		$data['json'] = $this->category_service->add($userId, $name, $remark);
		$this->load->view('json', $data);
	}
	public function mod()
	{
		$result = $this->login_service->islogin();
		if( $result['code'] != 0 )
		{
			$data['json'] = $result;
			$this->load->view('json', $data);
			return;
		}
		$userId = $result['data'];
		$categoryId = $this->input->post('categoryId');
		$name = $this->input->post('name');
		$remark = $this->input->post('remark');

		$data['json'] = $this->category_service->mod($categoryId, $userId, $name, $remark);
		$this->load->view('json', $data);
	}
}
