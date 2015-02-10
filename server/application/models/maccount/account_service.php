<?php
class Account_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('maccount/account_model', 'account_model');
	}
	public function get_all_account($pageIndex, $pageSize)
	{
		$data = $this->account_model->get_all_account();
		$num = count($data['data']);
		if( $num == 0 )
			return array(
					'code'=>1,
					'msg'=>'no data',
					'data'=>''
				    );
		if($pageSize < $num)
		{
			$leave = $num - $pageIndex;
			$t = 0;
			if( $leave > $pageSize)
			{
				for( $i = $pageIndex;$i < ($pageIndex + $pageSize); $i++ )
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
				for( $i = $pageIndex;$i < ($pageIndex + $leave); $i++ )
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
	public function get_account_by_id($accountId)
	{
		$data = $this->account_model->get_account_by_id($accountId);
		$num = count($data['data']);
		if( $num == 0 )
			return array(
					'code'=>1,
					'msg'=>'',
					'data'=>''
				    );
		return $data;
	}
	public function get_account_by_name($name, $pageIndex, $pageSize)
	{
		$data = $this->account_model->get_account_by_name($name);
		$num = count($data['data']);
		if( $num == 0 )
			return array(
					'code'=>1,
					'msg'=>'',
					'data'=>''
				    );
		if($pageSize < $num)
		{
			$leave = $num - $pageIndex;
			$t = 0;
			if( $leave > $pageSize)
			{
				for( $i = $pageIndex;$i < ($pageIndex + $pageSize); $i++ )
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
				for( $i = $pageIndex;$i < ($pageIndex + $leave); $i++ )
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
	public function get_account_by_remark($remark, $pageIndex, $pageSize)
	{
		$data = $this->account_model->get_account_by_remark($remark);
		$num = count($data['data']);
		if( num == 0 )
			return array(
				'code'=>1,
				'msg'=>'no data',
				'data'=>''
			);
		if($pageSize < $num)
		{
			$leave = $num - $pageIndex;
			$t = 0;
			if( $leave > $pageSize)
			{
				for( $i = $pageIndex;$i < ($pageIndex + $pageSize); $i++ )
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
				for( $i = $pageIndex;$i < ($pageIndex + $leave); $i++ )
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
	public function get_account_by_name_and_remark($name, $remark, $pageIndex, $pageSize)
	{
		$data = $this->account_model->get_account_by_name_and_remark($name, $remark);
		$num = $data['data'];
		if( $num == 0 )
			return array(
				'code'=>1,
				'msg'=>'',
				'data'=>''
			);
		if($pageSize < $num)
		{
			$leave = $num - $pageIndex;
			$t = 0;
			if( $leave > $pageSize)
			{
				for( $i = $pageIndex;$i < ($pageIndex + $pageSize); $i++ )
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
				for( $i = $pageIndex;$i < ($pageIndex + $leave); $i++ )
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
	public function get_account_by_or($name, $remark, $type, $categoryId, $cardId, $pageIndex, $pageSize)
	{
		$data = $this->account_model->get_account_by_or($name, $remark, $type, $categoryId, $cardId);
		$num = count($data['data']);
		if(num == 0)
			return array(
				'code'=>1,
				'msg'=>'no data',
				'data'=>''
			);
		if($pageSize < $num)
		{
			$leave = $num - $pageIndex;
			$t = 0;
			if( $leave > $pageSize)
			{
				for( $i = $pageIndex;$i < ($pageIndex + $pageSize); $i++ )
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
				for( $i = $pageIndex;$i < ($pageIndex + $leave); $i++ )
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
	public function del($accountId)
	{
		$this->account_model->del($accountId);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
	public function add($name, $money, $type, $categoryId, $cardId, $remark, $createTime, $modifyTime)
	{
		$data = $this->account_model->get_account_by_name($name);
		$num = $data['data'];
		if( $num != 0 )
			return array(
					'code'=>1,
					'msg'=>'name is already exist',
					'data'=>''
				    );
		$this->account_model->add($name, $money, $type, $categoryId, $cardId, $remark, $createTime, $modifyTime);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>''
			    );
	}
}
