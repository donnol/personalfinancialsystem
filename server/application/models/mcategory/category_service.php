<?php
class Category_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mcategory/category_model', 'category_model');
		$this->load->model('maccount/account_model', 'account_model');
	}
	public function search($where, $limit)
	{
		$data = $this->category_model->search($where, $limit);
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$data['data']
		);
	}
	public function get_category_by_id($where)
	{
		$data = $this->category_model->get_category_by_id($where);
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$data['data'][0]
		);
	}
	public function del($where)
	{
		$data = $this->category_model->del($where);
		$category = array(
			'categoryId'=>'0'
		);
		$this->account_model->mod($where, $category);
		return $data;
	}
	public function add($data)
	{
		$where = array(
			'userId'=>$data['userId'],
			'name'=>$data['name']
		);
		$result = $this->category_model->get_category_by_name($where);
		$num = count($result['data']);
		if( $num != 0 )
			return array(
				'code'=>1,
				'msg'=>'name is already exist.',
				'data'=>''
			);

		$reault = $this->category_model->add($data);
		return $result;
	}
	public function mod($where, $data)
	{
		$ids = array(
			'userId'=>$where['userId'],
			'categoryId'=>$where['categoryId']
		);
		$result = $this->category_model->get_category_by_id($ids);
		$tmp = $result['data'];
		if( $tmp[0]['name'] == $data['name'] )
		{
			$result = $this->category_model->mod($where, $data);
			return $result;
		}
			
		$names = array(
			'userId'=>$where['userId'],
			'name'=>$data['name']
		);
		$result = $this->category_model->get_category_by_name($names);
		$num = count($result['data']);
		if( $num != 0 )
			return array(
				'code'=>1,
				'msg'=>'name is already exist.',
				'data'=>''
			);

		$result = $this->category_model->mod($where, $data);
		return $result;
	}
}
