<?php
class Category_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mcategory/category_model', 'category_model');
	}
	public function get_all_category($userId, $pageIndex, $pageSize)
	{
		$data = $this->category_model->get_all_category($userId);
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
	public function get_category_by_name_and_remark($userId, $name, $remark, $pageIndex, $pageSize)
	{
		$data = $this->category_model->get_category_by_name_and_remark($userId, $name, $remark);
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
	public function get_category_like_name($userId, $name, $pageIndex, $pageSize)
	{
		$data = $this->category_model->get_category_like_name($userId, $name);
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
	public function get_category_like_remark($userId, $remark, $pageIndex, $pageSize)
	{
		$data = $this->category_model->get_category_like_remark($userId, $remark);
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
	public function get_category_by_name_or_remark($userId, $name, $remark, $pageIndex, $pageSize)
	{
		$data = $this->category_model->get_category_by_name_or_remark($userId, $name, $remark);
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
		$data = $this->category_model->del($userId, $categoryId);
		return $data;
	}
	public function add($userId,$name, $remark, $createTime, $modifyTime)
	{
		$result = $this->category_model->get_category_by_name($userId, $name);
		$num = count($result['data']);
		if( $num != 0 )
			return array(
				'code'=>1,
				'msg'=>'name is already exist.',
				'data'=>''
			);

		$data = $this->category_model->add($userId, $name, $remark, $createTime, $modifyTime);
		return $data;
	}
	public function mod($categoryId, $userId, $name, $remark, $modifyTime)
	{
		$result = $this->category_model->get_category_by_id($userId, $categoryId);
		$tmp = $result['data'];
		if( $tmp[0]['name'] == $name )
		{
			$data = $this->category_model->mod($categoryId, $userId, $name, $remark, $modifyTime);
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

		$data = $this->category_model->mod($categoryId, $userId, $name, $remark, $modifyTime);
		return $data;
	}
}
