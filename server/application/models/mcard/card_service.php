<?php
class Card_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mcard/card_model', 'card_model');
		$this->load->model('maccount/account_model', 'account_model');
	}
	public function search($where, $limit)
	{
		$data = $this->card_model->search($where, $limit);
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$data['data']
		);
	}
	public function get_card_by_id($where)
	{
		$data = $this->card_model->get_card_by_id($where);
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
	public function del($where)
	{
		$data = $this->card_model->del($where);
		$card = array(
			'cardId'=>'0'
		);
		$this->account_model->mod($where, $card);
		return $data;
	}
	public function add($data)
	{
		$array = array(
			'userId'=>$data['userId'],
			'name'=>$data['name']
		);
		$result = $this->card_model->get_card_by_name($array);
		$num = count($result['data']);
		if( $num != 0 )
			return array(
				'code'=>1,
				'msg'=>'name is already exist.',
				'data'=>''
			);

		$result = $this->card_model->add($data);
		return $result;
	}
	public function mod($where, $data )
	{
		
		$result = $this->card_model->get_card_by_id( $where);
		$tmp = $result['data'];
		if( $tmp[0]['name'] == $data['name'] )
		{	
			$data = $this->card_model->mod($where, $data);
			return $data;
		}

		$array = array(
			'userId'=>$where['userId'],
			'name'=>$data['name']
		);
		$result = $this->card_model->get_card_by_name($array);
		$num = count($result['data']);
		if( $num != 0 )
			return array(
				'code'=>1,
				'msg'=>'name is already exist.',
				'data'=>''
			);

		$result = $this->card_model->mod($where, $data);
		return $result;
	}
}
