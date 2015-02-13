<?php
class Account extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('maccount/account_service', 'account_service');
		$this->load->model('muser/login_service', 'login_service');
		$this->load->model('mcard/card_service', 'card_service');
		$this->load->model('mcategory/category_service', 'category_service');
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

		if( $userId = $result['data'])
			$where['userId'] = $userId;
		if( $name = $this->input->get('name'))
			$where['name'] = $name;
		if( $remark = $this->input->get('remark'))
			$where['remark'] = $remark;
		if( $type = $this->input->get('type'))
			$where['type'] = $type;
		if( $categoryId = $this->input->get('categoryId'))
			$where['categoryId'] = $categoryId;
		if( $cardId = $this->input->get('cardId'))
			$where['cardId'] = $cardId;
		if( $pageIndex = $this->input->get('pageIndex'))
			$limit['pageIndex'] = $pageIndex;
		if( $pageSize = $this->input->get('pageSize'))
			$limit['pageSize'] = $pageSize;

		$data['json'] = $this->account_service->search($where, $limit);
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
		if( $accountId = $this->input->get('accountId'))
			$where['accountId'] = $accountId;

		$data['json'] = $this->account_service->get_account_by_id($where);
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

		$userId = $result['data'];
		if( $accountId = $this->input->post('accountId'))
			$where['accountId'] = $accountId;

		$data['json'] = $this->account_service->del($where);
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
		if( $money = $this->input->post('money'))
			$add_data['money'] = $money;
		if( $type = $this->input->post('type'))
			$add_data['type'] = $type;
		if( $categoryId = $this->input->post('categoryId'))
			$add_data['categoryId'] = $categoryId;
		if( $cardId = $this->input->post('cardId'))
			$add_data['cardId'] = $cardId;

		$data['json'] = $this->account_service->add($add_data);
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
		$data = array();

		if( $userId = $result['data'])
			$where['userId'] = $userId;
		if( $accountId = $this->input->post('accountId'))
			$where['accountId'] = $accountId;
		if( $name = $this->input->post('name'))
			$data['name'] = $name;
		if( $remark = $this->input->post('remark'))
			$data['remark'] = $remark;
		if( $money = $this->input->post('money'))
			$data['money'] = $money;
		if( $type = $this->input->post('type'))
			$data['type'] = $type;
		if( $categoryId = $this->input->post('categoryId'))
			$data['categoryId'] = $categoryId;
		if( $cardId = $this->input->post('cardId'))
			$data['cardId'] = $cardId;

		$data['json'] = $this->account_service->mod($where, $data);
		$this->load->view('json', $data);
	}
}
