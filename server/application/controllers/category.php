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
		$where = array();
		$limit = array();

		if( $userId != FALSE )
			$where['userId'] = $userId;
		if( $name = $this->input->get('name')) 
			$where['name'] = $name;
		if( $remark = $this->input->get('remark'))
			$where['remark'] = $remark;
		if( $pageIndex = $this->input->get('pageIndex'))
			$limit['pageIndex'] = $pageIndex;
		if( $pageSize = $this->input->get('pageSize'))
			$limit['pageSize'] = $pageSize;

		$data['json'] = $this->category_service->search($where, $limit);
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

		if( $userId = $result['data'])
			$where['userId'] = $userId;
		if( $categoryId = $this->input->get('categoryId'))
			$where['categoryId'] = $categoryId;

		$data['json'] = $this->category_service->get_category_by_id($where);
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
		$where = array();

		if( $userId = $result['data'])
			$where['userId'] = $userId;
		if( $categoryId = $this->input->post('categoryId'))
			$where['categoryId'] = $categoryId;

		$data['json'] = $this->category_service->del($where);
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
		$add_data = array();

		if( $userId = $result['data'])
			$add_data['userId'] = $userId;
		if( $name = $this->input->post('name'))
			$add_data['name'] = $name;
		if( $remark = $this->input->post('remark'))
			$add_data['remark'] = $remark;

		$data['json'] = $this->category_service->add($add_data);
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
		$where = array();
		$mod_data = array();

		if( $userId = $result['data'])
			$where['userId'] = $userId;
		if( $categoryId = $this->input->post('categoryId'))
			$where['categoryId'] = $categoryId;
		if( $name = $this->input->post('name'))
			$mod_data['name'] = $name;
		if( $remark = $this->input->post('remark'))
			$mod_data['remark'] = $remark;

		$data['json'] = $this->category_service->mod($where, $mod_data);
		$this->load->view('json', $data);
	}
}
