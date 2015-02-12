<?php
class Category_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mcategory/category_model', 'category_model');
		$this->load->model('maccount/account_model', 'account_model');
	}
	public function search($userId, $where, $limit)
	{
		$data = $this->category_model->search($userId, $where, $limit);
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
	public function get_category_by_id($userId, $categoryId)
	{
		$data = $this->category_model->get_category_by_id($userId, $categoryId);
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$data['data'][0]
		);
	}
	public function del($userId, $categoryId)
	{
		$array = array(
			'categoryId'=>$categoryId
		);
		$data = $this->category_model->del($userId, $categoryId);
		$category = array(
			'categoryId'=>'0'
		);
		$this->account_model->mod($array, $category);
		return $data;
	}
	public function add($userId,$name, $remark)
	{
		$result = $this->category_model->get_category_by_name($userId, $name);
		$num = count($result['data']);
		if( $num != 0 )
			return array(
				'code'=>1,
				'msg'=>'name is already exist.',
				'data'=>''
			);

		$data = $this->category_model->add($userId, $name, $remark);
		return $data;
	}
	public function mod($categoryId, $userId, $name, $remark)
	{
		$result = $this->category_model->get_category_by_id($userId, $categoryId);
		$tmp = $result['data'];
		if( $tmp[0]['name'] == $name )
		{
			$data = $this->category_model->mod($categoryId, $userId, $name, $remark);
			return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			);
		}
			
		$result = $this->category_model->get_category_by_name($userId, $name);
		$num = count($result['data']);
		if( $num != 0 )
			return array(
				'code'=>1,
				'msg'=>'name is already exist.',
				'data'=>''
			);

		$data = $this->category_model->mod($categoryId, $userId, $name, $remark);
		return $data;
	}
}
