<?php
class Account_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('maccount/account_model', 'account_model');
	}
	public function search($userId, $id, $where, $limit)
	{
		$data = $this->account_model->search($userId, $id, $where, $limit);
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
	public function get_account_by_id($userId, $accountId)
	{
		$data = $this->account_model->get_account_by_id($userId, $accountId);
		$num = count($data['data']);
		if( $num == 0 )
			return array(
					'code'=>1,
					'msg'=>'',
					'data'=>''
				    );
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$data['data'][0]
		);
	}
	public function del($userId, $accountId)
	{
		$this->account_model->del($userId, $accountId);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
	public function add($userId, $name, $money, $type, $categoryId, $cardId, $remark)
	{
		$data = $this->account_model->get_account_by_name($userId, $name);
		$num = count($data['data']);
		if( $num != 0 )
			return array(
					'code'=>1,
					'msg'=>'name is already exist',
					'data'=>''
				    );
		$data = $this->account_model->add($userId, $name, $money, $type, $categoryId, $cardId, $remark);
		return $data;
	}
	public function mod($userId, $accountId, $name, $money, $type, $categoryId, $cardId, $remark)
	{
		$data = $this->account_model->get_account_by_id($userId, $accountId);
		$tmp = $data['data'];
		if( $tmp[0]['name'] == $name )
			{
			$data = $this->account_model->mod($userId, $accountId, $name, $money, $type, $categoryId, $cardId, $remark);
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
			}
		$data = $this->account_model->get_account_by_name($userId, $name);
		$num = count($data['data']);
		if( $num != 0 )
			return array(
				'code'=>1,
				'msg'=>'name is already exist.',
				'data'=>''
			);
		$data = $this->account_model->mod($userId, $accountId, $name, $money, $type, $categoryId, $cardId, $remark);
		return $data;
	}
}
