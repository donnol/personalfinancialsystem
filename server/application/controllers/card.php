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

		$userId = $result['data'];
		$where['userId'] = $userId;
		if( ($name = $this->input->get('name')) !== FALSE )
			$where['name'] = $name;
		if( ($remark = $this->input->get('remark')) !== FALSE )
			$where['remark'] = $remark;
		if( ($pageIndex = $this->input->get('pageIndex')) !== FALSE )
			$limit['pageIndex'] = $pageIndex;
		if( ($pageSize = $this->input->get('pageSize')) !== FALSE )
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
		$userId = $result['data'];
		$where['userI'] = $userId;
		if( ($cardId = $this->input->get('cardId')) !== FALSE )
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

		if( ($cardId = $this->input->post('cardId')) !== FALSE )
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

		$userId = $result['data'];
		$add_data['userId'] = $userId;
		if( ($name = $this->input->post('name')) !== FALSE )
			$add_data['name'] = $name;
		if( ($bank = $this->input->post('bank')) !== FALSE )
			$add_data['bank'] = $bank;
		if( ($card = $this->input->post('card')) !== FALSE )
			$add_data['card'] = $card;
		if( ($money = $this->input->post('money')) !== FALSE )
			$add_data['money'] = $money;
		if( ($remark = $this->input->post('remark')) !== FALSE )
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

		$userId = $result['data'];
		$where['userId'] = $userId;
		if( ($cardId = $this->input->post('cardId')) !== FALSE )
			$where['cardId'] = $cardId;
		if( ($name = $this->input->post('name')) !== FALSE )
			$mod_data['name'] = $name;
		if( ($bank = $this->input->post('bank')) !== FALSE )
			$mod_data['bank'] = $bank;
		if( ($card = $this->input->post('card')) !== FALSE )
			$mod_data['card'] = $card;
		if( ($money = $this->input->post('money')) !== FALSE )
			$mod_data['money'] = $money;
		if( ($remark = $this->input->post('remark')) !== FALSE )
			$mod_data['remark'] = $remark;

		$data['json'] = $this->card_service->mod($where, $mod_data);
		$this->load->view('json', $data);
	}
}
