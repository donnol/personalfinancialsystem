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

		$userId = $result['data'];
		$where['userId'] = $userId;
		if( ($name = $this->input->get('name')) !== FALSE )
			$where['name'] = $name;
		if( ($remark = $this->input->get('remark')) !== FALSE )
			$where['remark'] = $remark;
		if( ($type = $this->input->get('type')) !== FALSE )
			$where['type'] = $type;
		if( ($categoryId = $this->input->get('categoryId')) !== FALSE )
			$where['categoryId'] = $categoryId;
		if( ($cardId = $this->input->get('cardId')) !== FALSE )
			$where['cardId'] = $cardId;
		if( ($pageIndex = $this->input->get('pageIndex')) !== FALSE )
			$limit['pageIndex'] = $pageIndex;
		if( ($pageSize = $this->input->get('pageSize')) !== FALSE )
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

		$userId = $result['data'];
		$where['userId'] = $userId;
		if( ($accountId = $this->input->get('accountId')) !== FALSE )
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

		$userId = $result['data'];
		$add_data['userId'] = $userId;
		if( ($name = $this->input->post('name')) !== FALSE )
			$add_data['name'] = $name;
		if( ($remark = $this->input->post('remark')) !== FALSE )
			$add_data['remark'] = $remark;
		if( ($money = $this->input->post('money')) !== FALSE )
			$add_data['money'] = $money;
		if( ($type = $this->input->post('type')) !== FALSE )
			$add_data['type'] = $type;
		if( ($categoryId = $this->input->post('categoryId')) !== FALSE )
			$add_data['categoryId'] = $categoryId;
		if( ($cardId = $this->input->post('cardId')) !== FALSE )
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

		$userId = $result['data'];
		$where['userId'] = $userId;
		if( ($accountId = $this->input->post('accountId')) !== FALSE )
			$where['accountId'] = $accountId;
		if( ($name = $this->input->post('name')) !== FALSE )
			$data['name'] = $name;
		if( ($remark = $this->input->post('remark')) !== FALSE )
			$data['remark'] = $remark;
		if( ($money = $this->input->post('money')) !== FALSE )
			$data['money'] = $money;
		if( ($type = $this->input->post('type')) !== FALSE )
			$data['type'] = $type;
		if( ($categoryId = $this->input->post('categoryId')) !== FALSE )
			$data['categoryId'] = $categoryId;
		if( ($cardId = $this->input->post('cardId')) !== FALSE )
			$data['cardId'] = $cardId;

		$data['json'] = $this->account_service->mod($where, $data);
		$this->load->view('json', $data);
	}
	public function getWeekTypeStatistic()
	{
		$result = $this->login_service->islogin();
		if( $result['code'] != 0 )
		{
			$data['json'] = $result;
			$this->load->view('json', $data);
			return;
		}

		$userId = $result['data'];
		$ids['userId'] = $userId;

		$data['json'] = $this->account_service->get_week_type_statistic($ids);
		$this->load->view('json', $data);
	}
	public function getWeekDetailTypeStatistic()
	{
		$result = $this->login_service->islogin();
		if( $result['code'] != 0 )
		{
			$data['json'] = $result;
			$this->load->view('json', $data);
			return;
		}

		$userId = $result['data'];
		$where['userId'] = $userId;

		if( ($year = $this->input->post('year')) !== FALSE )
			$where['year'] = $year;
		if( ($week = $this->input->post('week')) !== FALSE )
			$where['week'] = $week;
		if( ($type = $this->input->post('type')) !== FALSE )
			$where['type'] = $type;

		$data['json'] = $this->account_service->get_week_detail_type_statistic($where);
		$this->load->view('json', $data);
	}
}
