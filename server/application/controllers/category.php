<?php
class Category extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mcategory/category_service', 'category_service');
		$this->load->model('muser/login_service', 'login_service');
	}
	public function search()
	{
		$result = $this->login_service->islogin();
		if( $result['code'] != 0 )
			return array(
				'code'=>1,
				'msg'=>'havent login',
				'data'=>''
			);
		$name = $this->input->post('name');
		$remark = $this->input->post('remark');
		$pageIndex = $this->input->get('pageIndex');
		$pageSize = $this->input->get('pageSize');

		if( $name != '' OR $remark != '' )
		{
			$data['json'] = $this->category_service->get_category_by_name_or_remark($name, $remark, $pageIndex, $pageSize);
			$this->load->view('json', $data);
			return;
		}

		$data['json'] = $this->category_service->get_all_category($pageIndex, $pageSize);
		$this->load->view('json', $data);
	}
	public function get()
	{
		$result = $this->login_service->islogin();
		if( $result['code'] != 0 )
			return array(
				'code'=>1,
				'msg'=>'havent login',
				'data'=>''
			);

		$categoryId = $this->input->post('categoryId');

		$data['json'] = $this->category_service->get_category_by_id($categoryId);
		$this->load->view('json', $data);
	}
	public function del()
	{
		$result = $this->login_service->islogin();
		if( $result['code'] != 0 )
			return array(
				'code'=>1,
				'msg'=>'havent login',
				'data'=>''
			);

		$categoryId = $this->input->post('categoryId');

		$data['json'] = $this->category_service->del($categoryId);
		$this->load->view('json', $data);
	}
	public function add()
	{
		$result = $this->login_service->islogin();
		if( $result['code'] != 0 )
			return array(
				'code'=>1,
				'msg'=>'havent login',
				'data'=>''
			);

		$name = $this->input->post('name');
		$remark = $this->input->post('remark');
		$createTime = date('Y-m-d H:m:s', time());
		$modifyTime = $createTime;

		$data['json'] = $this->category_service->add($name, $remark, $createTime, $modifyTime);
		$this->load->view('json', $data);
	}
}
