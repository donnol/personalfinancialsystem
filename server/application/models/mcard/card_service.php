<?php
class Card_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mcard/card_model', 'card_model');
	}
	public function get_all_card($userId, $pageIndex, $pageSize)
	{
		$data = $this->card_model->get_all_card($userId);
		$num = count($data['data']);
		if( $num == 0 )
			return array(
				'code'=>1,
				'msg'=>'no data',
				'data'=>''
			);

		if( $num > $pageSize )
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
				for($i = $pageIndex; $i < ($pageIndex + $leave); $i++)
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
	public function get_card_like_name_and_remark($userId, $name, $remark, $pageIndex, $pageSize)
	{
		$data = $this->card_model->get_card_like_name_and_remark($userId, $name, $remark);
		$num = count($data['data']);
		if( $num == 0 )
			return array(
				'code'=>1,
				'msg'=>'no data',
				'data'=>''
			);

		if( $num > $pageSize )
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
				for($i = $pageIndex; $i < ($pageIndex + $leave); $i++)
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
	public function get_card_like_name($userId, $name, $pageIndex, $pageSize)
	{
		$data = $this->card_model->get_card_like_name($userId, $name);
		$num = count($data['data']);
		if( $num == 0 )
			return array(
				'code'=>1,
				'msg'=>'no data',
				'data'=>''
			);

		if( $num > $pageSize )
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
				for($i = $pageIndex; $i < ($pageIndex + $leave); $i++)
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
	public function get_card_like_remark($userId, $remark, $pageIndex, $pageSize)
	{
		$data = $this->card_model->get_card_like_remark($userId, $remark);
		$num = count($data['data']);
		if( $num == 0 )
			return array(
				'code'=>1,
				'msg'=>'no data',
				'data'=>''
			);

		if( $num > $pageSize )
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
				for($i = $pageIndex; $i < ($pageIndex + $leave); $i++)
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
	public function get_card_by_name_or_remark($userId, $name, $remark, $pageIndex, $pageSize)
	{
		$data = $this->card_model->get_card_by_name_or_remark($userId, $name, $remark);
		$num = count($data['data']);
		if( $num == 0 )
			return array(
				'code'=>1,
				'msg'=>'no data',
				'data'=>''
			);

		if( $num > $pageSize )
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
				for($i = $pageIndex; $i < ($pageIndex + $leave); $i++)
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
