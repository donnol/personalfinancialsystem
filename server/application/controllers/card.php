<?php
class Card extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mcard/card_service', 'card_service');
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

		$name = $this->input->post('name');
		$remark = $this->input->post('remark');
		$pageIndex = $this->input->get('pageIndex');
		$pageSize = $this->input->get('pageSize');

		if( $name != '' OR $remark != '' )
		{
			$data['json'] = $this->login_service->get_card_by_name_or_remark($name, $remark, $pageIndex, $pageSize);
			$this->load->view('json', $data);
			return;
		}

		$data['json'] = $this->card_service->get_all_card($name, $remark, $pageIndex, $pageSize);
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

		$cardId = $this->input->get('cardId');
		$data['json'] = $this->card_service->del($cardId);
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
		$bank = $this->input->post('bank');
		$card = $this->input->post('card');
		$money = $this->input->post('money');
		$remark = $this->input->post('remark');
		$createTime = date('Y-m-d H:m:s');
		$modifyTime = $createTime;
		
		$data['json'] = $this->card_service->add($name, $bank, $card, $money, $remark, $createTime, $modifyTime);
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
		$name = $this->input->post('name');
		$bank = $this->input->post('bank');
		$card = $this->input->post('card');
		$money = $this->input->post('money');
		$remark = $this->input->post('remark');
		$modifyTime = date('Y-m-d H:m:s');

		$data['json'] = $this->card_service->mod($name, $bank, $card, $money, $remark, $modifyTime);
		$this->load->view('json', $data);
	}
}
