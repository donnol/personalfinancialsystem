<?php
class Account_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('maccount/account_model', 'account_model');
	}
	public function search($where, $limit)
	{
		$data = $this->account_model->search($where, $limit);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data['data']
			    );
	}
	public function get_account_by_id($where)
	{
		$data = $this->account_model->get_account_by_id($where);
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
	public function del($where)
	{
		$result = $this->account_model->del($where);
		return $result;
	}
	public function add($data)
	{
		$names = array(
				'userId'=>$data['userId'],
				'name'=>$data['name']
			      );
		$result = $this->account_model->get_account_by_name($names);
		$num = count($result['data']);
		if( $num != 0 )
			return array(
					'code'=>1,
					'msg'=>'name is already exist',
					'data'=>''
				    );
		$result = $this->account_model->add($data);
		return $result;
	}
	public function mod($where, $data)
	{
		$ids = array(
				'userId'=>$where['userId'],
				'accountId'=>$where['accountId']
			    );
		$result = $this->account_model->get_account_by_id($ids);
		$accounts = $result['data'];
		if( $accounts[0]['name'] == $data['name'] )
		{
			$result = $this->account_model->mod($where, $data);
			return $result;
		}
		$names = array(
				'userId'=>$where['userId'],
				'name'=>$data['name']
			      );
		$result = $this->account_model->get_account_by_name($names);
		$num = count($result['data']);
		if( $num != 0 )
			return array(
					'code'=>1,
					'msg'=>'name is already exist.',
					'data'=>''
				    );

		$result = $this->account_model->mod($where, $data);
		return $result;
	}
}
