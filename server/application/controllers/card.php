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
		$where = array();
		$limit = array();

		if( $userId = $result['data'])
			$where['userId'] = $userId;
		if( $name = $this->input->get('name'))
			$where['name'] = $nam;
		if( $remark = $this->input->get('remark'))
			$where['remark'] = $remark;
		if( $pageIndex = $this->input->get('pageIndex'))
			$limit['pageIndex'] = $pageIndex;
		if( $pageSize = $this->input->get('pageSize'))
			$limit['pageSize'] = $pageSize;

		$data['json'] = $this->card_service->search($where, $limit);
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
			$where['userI'] = $userId;
		if( $cardId = $this->input->get('cardId'))
			$where['cardId'] = $cardId;

		$data['json'] = $this->card_service->get_card_by_id($where);
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

		if( $cardId = $this->input->post('cardId'))
			$where['cardId'] = $cardId;

		$data['json'] = $this->card_service->del($where);
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
		if( $bank = $this->input->post('bank'))
			$add_data['bank'] = $bank;
		if( $card = $this->input->post('card'))
			$add_data['card'] = $card;
		if( $money = $this->input->post('money'))
			$add_data['money'] = $money;
		if( $remark = $this->input->post('remark'))
			$add_data['remark'] = $remark;
		
		$data['json'] = $this->card_service->add($add_data);
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
		if( $cardId = $this->input->post('cardId'))
			$where['cardId'] = $cardId;
		if( $name = $this->input->post('name'))
			$mod_data['name'] = $name;
		if( $bank = $this->input->post('bank'))
			$mod_data['bank'] = $bank;
		if( $card = $this->input->post('card'))
			$mod_data['card'] = $card;
		if( $money = $this->input->post('money'))
			$mod_data['money'] = $money;
		if( $remark = $this->input->post('remark'))
			$mod_data['remark'] = $remark;

		$data['json'] = $this->card_service->mod($where, $mod_data);
		$this->load->view('json', $data);
	}
}
