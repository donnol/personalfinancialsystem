<?php
class Card_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mcard/card_model', 'card_model');
	}
	public function get_all_card($pageIndex, $pageSize)
	{
		$data = $this->card_model->get_all_card();
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
	public function get_card_by_id($cardId)
	{
		$data = $this->card_model->get_card_by_id($cardId);
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
			'data'=>$data['data']
		);
	}
	public function get_card_by_name_or_remark($name, $remark, $pageIndex, $pageSize)
	{
		$data = $this->card_model->get_card_by_name_or_remark($name, $remark);
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
	public function del($cardId)
	{
		$data = $this->card_model->del($cardId);
		return $data;
	}
	public function add($name, $bank, $card, $money, $remark, $createTime, $modifyTime)
	{
		$data = $this->card_model->get_by_name($name);
		$num = count($data['data']);
		if( $num != 0 )
			return array(
				'code'=>1,
				'msg'=>'name is already exist.',
				'data'=>''
			);

		$data = $this->card_model->add($name, $bank, $card, $money, $remark, $createTime, $modifyTime);
		return $data;
	}
	public function mod($name, $bank, $card, $money, $remark,  $modifyTime)
	{
		$data = $this->card_model->mod($name, $bank, $card, $money, $remark, $modifyTime);
		return $data;
	}
}
