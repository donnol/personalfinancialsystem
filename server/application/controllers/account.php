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
		$userId = $result['data'];

		$name = $this->input->get('name');
		$remark = $this->input->get('remark');
		$type = $this->input->get('type');
		$categoryId = $this->input->get('categoryId');
		$cardId = $this->input->get('cardId');
		$pageIndex = $this->input->get('pageIndex');
		$pageSize = $this->input->get('pageSize');

		$where = array(
			'userId'=>$userId,
			'categoryId'=>$categoryId,
			'cardId'=>$cardId,
			'type'=>$type,
			'name'=>$name,
			'remark'=>$remark
		);
		$limit = array(
			'pageIndex'=>$pageIndex,
			'pageSize'=>$pageSize
		);

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
		$userId = $result['data'];
		$accountId = $this->input->get('accountId');

		$data['json'] = $this->account_service->get_account_by_id($userId, $accountId);
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
		$accountId = $this->input->post('accountId');

		$data['json'] = $this->account_service->del($userId, $accountId);
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
		$money = $this->input->post('money');
		$type = $this->input->post('type');
		$categoryId = $this->input->post('categoryId');
		$cardId = $this->input->post('cardId');

		$data['json'] = $this->account_service->add($userId, $name, $money, $type, $categoryId, $cardId, $remark);
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
		$accountId = $this->input->post('accountId');
		$name = $this->input->post('name');
		$remark = $this->input->post('remark');
		$money = $this->input->post('money');
		$type = $this->input->post('type');
		$categoryId = $this->input->post('categoryId');
		$cardId = $this->input->post('cardId');

		$where = array(
			'userId'=>$userId,
			'accountId'=>$accountId
		);
		$data = array(
			'name'=>$name,
			'remark'=>$remark,
			'money'=>$money,
			'type'=>$type,
			'categoryId'=>$categoryId,
			'cardId'=>$cardId
		);
		$data['json'] = $this->account_service->mod($where, $data);
		$this->load->view('json', $data);
	}
}
