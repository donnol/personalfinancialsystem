<?php
class Category_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mcategory/category_model', 'category_model');
	}
	public function get_all_category($pageIndex, $pageSize)
	{
		$data = $this->category_model->get_all_category();
		$num = count($data['data']);
		var_dump($num);
		if( $num == 0 )
			return array(
				'code'=>1, 
				'msg'=>'no data',
				'data'=>''
			);
		if($num > $pageSize)
		{
			$leave = $num - $pageIndex;
			$t = 0;
			if($leave > $pageSize)
			{
				for($i = $pageIndex; $i < ($pageIndex + $pageSize); $i++ )
				{
					$tdata[$t++] = $data['data'][$i];	
				}
				$result = array(
					'count'=>$num,
					'data'=>$tdata
				);
				return array(
					'code'=>0,
					'msg'=>'',
					'data'=>$result
				);
			}
			else
			{
				for($i = $pageIndex; $i < ($leave + $pageIndex); $i ++ )
				{
					$tdata[$t++] = $data['data'][$i];
				}
				$result = array(
					'count'=>$num,
					'data'=>$tdata
				);
				return array(
					'code'=>0,
					'msg'=>'',
					'data'=>$result
				);
			}
		}
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
	public function get_category_by_name_or_remark($name, $remark, $pageIndex, $pageSize)
	{
		$data = $this->category_model->get_category_by_name_or_remark($name, $remark);
		$num = count($data['data']);
		if( $num == 0 )
			return array(
				'code'=>1, 
				'msg'=>'no data',
				'data'=>''
			);
		if($num > $pageSize)
		{
			$leave = $num - $pageIndex;
			$t = 0;
			if($leave > $pageSize)
			{
				for($i = $pageIndex; $i < ($pageIndex + $pageSize); $i++ )
				{
					$tdata[$t++] = $data['data'][$i];	
				}
				$result = array(
					'count'=>$num,
					'data'=>$tdata
				);
				return array(
					'code'=>0,
					'msg'=>'',
					'data'=>$result
				);
			}
			else
			{
				for($i = $pageIndex; $i < ($leave + $pageIndex); $i ++ )
				{
					$tdata[$t++] = $data['data'][$i];
				}
				$result = array(
					'count'=>$num,
					'data'=>$tdata
				);
				return array(
					'code'=>0,
					'msg'=>'',
					'data'=>$result
				);
			}
		}
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
	public function del($categoryId)
	{
		$data = $this->category_model->del($categoryId);
		return $data;
	}
	public function add($name, $remark, $createTime, $modifyTime)
	{
		$data = $this->category_model->add($name, $remark, $createTime, $modifyTime);
		return $data;
	}
	public function mod($categoryId, $name, $remark, $modifyTime)
	{
		$data = $this->category_model->mod($categoryId, $name, $remark, $modifyTime);
		return $data;
	}
}
