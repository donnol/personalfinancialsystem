<?php
class Account extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('maccount/account_service', 'account_service');
	}
	public function search()
	{
		$name = $this->input->post('name');
		$remark = $this->input->post('remark');
		$type = $this->input->post('type');
		$categoryId = $this->input->post('categoryId');
		$cardId = $this->input->post('cardId');
		$pageIndex = $this->input->get('pageIndex');
		$pageSize = $this->input->get('pageSize');

		/*if( $name!='' && $remark!='' )
		{
			$data['json'] = $this->account_service->get_account_by_name_and_remark($name, $remark, $pageIndex, $pageSize);
			$this->load->view('json', $data);
			return;
		}
		if( $name!='' )
		{
			$data['json'] = $this->account_service->get_account_by_name($name, $pageIndex, $pageSize);
			$this->load->view('json', $data);
			return;
		}
		if( $remark!='' )
		{
			$data['json'] = $this->account_service->get_account_by_remark($remark, $pageIndex, $pageSize);
			$this->load->view('json',$data);
			return;
		}*/
		if( $name!='' OR $remark!='' OR $type!='' OR $categoryId!='' OR $cardId!='' )
		{
			$data['json'] = $this->account_service->get_account_by_or($name, $remark, $type, $categoryId, $cardId, $pageIndex, $pageSize);
			$this->load->view('json', $data);
			return;
		}
		
		$data['json'] = $this->account_service->get_all_account($pageIndex, $pageSize);
		$this->load->view('json', $data);
	}
	public function get()
	{
		$accountId = $this->input->post('accountId');

		$data['json'] = $this->account_service->get_account_by_id($accountId);
		$this->load->view('json', $data);
	}
	public function del()
	{
		$accountId = $this->input->post('accountId');

		$data['json'] = $this->account_service->del($accountId);
		$this->load->view('json', $data);
	}
	public function add()
	{
		$name = $this->input->post('name');
		$remark = $this->input->post('remark');
		$money = $this->input->post('money');
		$type = $this->input->post('type');
		$categoryId = $this->input->post('categoryId');
		$cardId = $this->input->post('cardId');
		$createTime = date('Y-m-d H:m:s', time());
		$modifyTime = $createTime;

		$data['json'] = $this->account_service->add($name, $money, $type, $categoryId, $cardId, $remark, $createTime, $modifyTime);
		$this->load->view('json', $data);
	}
	public function mod()
	{
		$name = $this->input->post('name');
		$remark = $this->input->post('remark');
		$money = $this->input->post('money');
		$type = $this->input->post('type');
		$categoryId = $this->input->post('categoryId');
		$cardId = $this->input->post('cardId');
		$modifyTime = date('Y-m-d H:m:s', time());

		$data['json'] = $this->account_service->mod($name, $money, $type, $catogoryId, $cardId, $remark, $modifyTime);
		$this->load->view('json', $data);
	}
}
