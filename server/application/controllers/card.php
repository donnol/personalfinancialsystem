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
		$userId = $result['data'];

		$name = $this->input->get('name');
		$remark = $this->input->get('remark');
		$pageIndex = $this->input->get('pageIndex');
		$pageSize = $this->input->get('pageSize');

		$where = array(
			'userId'=>$userId,
			'name'=>$name,
			'remark'=>$remark
		);
		if( $pageIndex == FALSE OR $pageSize == FALSE )
		{
			$limit = array();
		}
		else
		{
			$limit = array(
				'pageIndex'=>$pageIndex,
				'pageSize'=>$pageSize
			);
		}

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
		$userId = $result['data'];

		$cardId = $this->input->get('cardId');
		$where = array(
			'userId'=>$userId,
			'cardId'=>$cardId
		);
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
		$userId = $result['data'];

		$cardId = $this->input->post('cardId');
		$where = array(
			'cardId'=>$cardId
		);
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
		$userId = $result['data'];
		$name = $this->input->post('name');
		$bank = $this->input->post('bank');
		$card = $this->input->post('card');
		$money = $this->input->post('money');
		$remark = $this->input->post('remark');
		
		$add_data = array(
			'userId'=>$userId,
			'name'=>$name,
			'bank'=>$bank,
			'card'=>$card,
			'money'=>$money,
			'remark'=>$remark
		);
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
		$userId = $result['data'];
		$cardId = $this->input->post('cardId');
		$name = $this->input->post('name');
		$bank = $this->input->post('bank');
		$card = $this->input->post('card');
		$money = $this->input->post('money');
		$remark = $this->input->post('remark');

		$where = array(
			'userId'=>$userId,
			'cardId'=>$cardId
		);
		$mod_data = array(
			'name'=>$name,
			'bank'=>$bank,
			'card'=>$card,
			'money'=>$money,
			'remark'=>$remark
		);
		$data['json'] = $this->card_service->mod($where, $mod_data);
		$this->load->view('json', $data);
	}
}
