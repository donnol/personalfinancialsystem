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

		$name = $this->input->get('name');
		$remark = $this->input->get('remark');
		$pageIndex = $this->input->get('pageIndex');
		$pageSize = $this->input->get('pageSize');

		if( $name != '' && $remark != '' )
		{
			$data['json'] = $this->card_service->get_card_like_name_and_remark($name, $remark, $pageIndex, $pageSize);
			$this->load->view('json', $data);
			return;
		}
		if( $name != '' )
		{
			$data['json'] = $this->card_service->get_card_like_name($name, $pageIndex, $pageSize);
			$this->load->view('json', $data);
			return;
		}
		if( $remark != '' )
		{
			$data['json'] = $this->card_service->get_card_like_remark($remark, $pageIndex, $pageSize);
			$this->load->view('json', $data);
			return;
		}

		$data['json'] = $this->card_service->get_all_card($pageIndex, $pageSize);
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

		$cardId = $this->input->get('cardId');
		$data['json'] = $this->card_service->get_card_by_id($cardId);
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

		$cardId = $this->input->post('cardId');
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
		$createTime = date('Y-m-d H:i:s');
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
		$cardId = $this->input->post('cardId');
		$name = $this->input->post('name');
		$bank = $this->input->post('bank');
		$card = $this->input->post('card');
		$money = $this->input->post('money');
		$remark = $this->input->post('remark');
		$modifyTime = date('Y-m-d H:i:s');

		$data['json'] = $this->card_service->mod($cardId, $name, $bank, $card, $money, $remark, $modifyTime);
		$this->load->view('json', $data);
	}
}
