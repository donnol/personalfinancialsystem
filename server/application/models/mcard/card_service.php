<?php
class Card_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mcard/card_model', 'card_model');
	}
	public function search($userId, $where, $limit)
	{
		$data = $this->card_model->search($userId, $where, $limit);
		$num = count($data['data']);
		$result = array(
			'count'=>$num,
			'data'=>$data['data']
		);
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$result
		);
	}
	public function get_card_by_id($userId, $cardId)
	{
		$data = $this->card_model->get_card_by_id($userId, $cardId);
		$num = count($data['data']);
		if( $num == 0 )
			return array(
				'code'=>1,
				'msg'=>'no data',
				'data'=>''
			);
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$data['data'][0]
		);
	}
	public function del($userId, $cardId)
	{
		$data = $this->card_model->del($userId, $cardId);
		return $data;
	}
	public function add($userId, $name, $bank, $card, $money, $remark)
	{
		$data = $this->card_model->get_card_by_name($userId, $name);
		$num = count($data['data']);
		if( $num != 0 )
			return array(
				'code'=>1,
				'msg'=>'name is already exist.',
				'data'=>''
			);

		$data = $this->card_model->add($userId, $name, $bank, $card, $money, $remark);
		return $data;
	}
	public function mod($userId, $cardId, $name, $bank, $card, $money, $remark)
	{
		$result = $this->card_model->get_card_by_id($userId, $cardId);
		$tmp = $result['data'];
		if( $tmp[0]['name'] == $name )
		{	
			$data = $this->card_model->mod($userId, $cardId, $name, $bank, $card, $money, $remark);
			return $data;
		}

		$result = $this->card_model->get_card_by_name($userId, $name);
		$num = count($result['data']);
		if( $num != 0 )
			return array(
				'code'=>1,
				'msg'=>'name is already exist.',
				'data'=>''
			);

		$data = $this->card_model->mod($userId, $cardId, $name, $bank, $card, $money, $remark);
		return $data;
	}
}
