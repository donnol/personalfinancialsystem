<?php
class Account_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('maccount/account_model', 'account_model');
		$this->load->model('mcard/card_model', 'card_model');
		$this->load->model('mcategory/category_model', 'category_model');
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
	public function get_week_type_statistic($ids)
	{
		$result = $this->account_model->sel_by_type($ids);
		if( $result['code'] != 0 )
			return $result;

		foreach( $result['data'] as $key=>$value)
		{
			$result['data'][$key]['year'] = intval($value['year']);
			$result['data'][$key]['week'] = intval($value['week']);
			$result['data'][$key]['type'] = intval($value['type']);
			$result['data'][$key]['money'] = intval($value['money']);
		}
		$statistic = array();
		foreach( $result['data'] as $key=>$value )
		{
			$year = $value['year'];
			$week = $value['week'];
			$type = $value['type'];
			$money = $value['money'];
			$statistic[$year][$week][$type] = $money;
		}

		$minTime = null;
		$maxTime = null;
		foreach( $result['data'] as $key=>$value )
		{
			if( $minTime == NULL || ($minTime['year']*100 + $minTime['week'] > $value['year']*100 + $value['week']))
			{
				$minTime = array();
				$minTime['year'] = $value['year'];
				$minTime['week'] = $value['week'];
			}
			if( $maxTime == NULL || ($maxTime['year']*100 + $maxTime['week'] < $value['year']*100 + $value['week']))
			{
				$maTime = array();
				$maxTime['year'] = $value['year'];
				$maxTime['week'] = $value['week'];
			}
		}
		$data = array();
		for( $year = $maxTime['year'] ; $year >= $minTime['year'] ; $year -- )
		{
			$minWeek = 1;
			$maxWeek = 52;
			if( $year == $minTime['year'])
				$minWeek = $minTime['week'];
			if( $year == $maxTime['year'])
				$maxWeek = $maxTime['week'];
			for( $week = $maxWeek ; $week >= $minWeek ; $week -- )
			{
				for( $type = 1 ; $type <=4 ; $type ++ )
				{
					$money = 0;
					if( isset($statistic[$year][$week][$type]))
					{
						$money = $statistic[$year][$week][$type];
					}
					$typeMap = array(
							1=>'收入',
							2=>'支出',
							3=>'转账收入',
							4=>'转账支出'
							);
					$data[] = array(
							'name'=>$year.'年'.sprintf('%02d', $week).'周',
							'year'=>$year,
							'week'=>$week,
							'type'=>$type,
							'typeName'=>$typeMap[$type],
							'money'=>$money
						       );
				}
			}
		}
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			    );
	}
	public function get_week_detail_type_statistic($where)
	{
		$result = $this->account_model->sel_by_category($where);
		if( $result['code'] != 0 )
			return $result;
		$statistic = $result['data'];

		$ids['userId'] = $where['userId'];
		$result = $this->category_model->search($ids, array());
		if( $result['code'] != 0 )
			return $result;
		$category = array();
		foreach( $result['data']['data'] as $single)
		{
			$category[$single['categoryId']] = $single['name'];
		}

		$totalMoney = 0;
		foreach( $statistic as $key=>$value)
		{
			$totalMoney += $value['money'];
		}
		foreach( $statistic as $key=>$value)
		{
			$value['precent'] = round($value['money']/$totalMoney*100, 2).'%';
			if( array_key_exists($value['categoryId'], $category))
				$value['categoryName'] = $category[$value['categoryId']];
			else
				$value['categoryName'] = '未分类';
			$data[$key] = array(
				'precent'=>$value['precent'],
				'categoryName'=>$value['categoryName'],
				'categoryId'=>$value['categoryId'],
				'money'=>$value['money']
			);
		}
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			    ); 
	} 
	public function get_week_card_statistic($ids) 
	{ 
		$result = $this->account_model->sel_by_card($ids);
		if( $result['code'] != 0 )
			return $result;
		$accountInfo = $result['data'];
		foreach( $accountInfo as $key=>$value )
		{
			$accountInfo[$key]['year'] = intval($value['year']);
			$accountInfo[$key]['week'] = intval($value['week']);
			$accountInfo[$key]['cardId'] = intval($value['cardId']);
			$accountInfo[$key]['money'] = intval($value['money']);
			$accountInfo[$key]['type'] = intval($value['type']);
		}

		$cards = $this->card_model->search($ids, array());
		if( $cards['code'] != 0 )
			return $cards;

		$card = array();
		foreach($cards['data']['data'] as $single)
		{
			$card[$single['cardId']] = $single;
		}
		foreach( $accountInfo as $key=>$value)
		{
			if( $value['cardId'] == 0 )
			{
				$card[0] = array(
					'cardId'=>0,
					'name'=>'无银行卡',
					'money'=>0
				);
				break;
			}
		}

		$statistic = array();
		foreach( $accountInfo as $key=>$value)
		{
			$year = $value['year'];
			$week = $value['week'];
			$cardId = $value['cardId'];
			$money = 0;
			if( $value['type'] == 1 || $value['type'] == 3)
				$money = $value['money'];
			else
				$money = -$value['money'];
			if( ! isset($statistic[$year][$week][$cardId]))
				$statistic[$year][$week][$cardId] = $money;
			else
				$statistic[$year][$week][$cardId] += $money;
		}

		$minTime = null;
		$maxTime = null;
		foreach( $accountInfo as $key=>$value )
		{
			if( $minTime == NULL || ($minTime['year']*100 + $minTime['week'] > $value['year']*100 + $value['week']))
			{
				$minTime = array();
				$minTime['year'] = $value['year'];
				$minTime['week'] = $value['week'];
			}
			if( $maxTime == NULL || ($maxTime['year']*100 + $maxTime['week'] < $value['year']*100 + $value['week']))
			{
				$maxTime = array();
				$maxTime['year'] = $value['year'];
				$maxTime['week'] = $value['week'];
			}
		}

		$data = array();
		$statistic2 = array();
		for( $year = $minTime['year'] ; $year <= $maxTime['year'] ; $year ++ )
		{
			$minWeek = 1;
			$maxWeek = 52;
			if( $year == $minTime['year'] )
				$minWeek = $minTime['week'];
			if( $year == $maxTime['year'] )
				$maxWeek = $maxTime['week'];
			for ( $week = $minWeek ; $week <= $maxWeek ; $week ++ )
			{
				foreach( $card as $cardId=>$cardData )
				{
					$money = 0;
					if( isset($statistic[$year][$week][$cardId] ))
						$money = $statistic[$year][$week][$cardId];
					if( $year == $minTime['year'] && $week == $minTime['week'] )
					{
						$money = $cardData['money'] + intval($money);
					}
					else
					{
						$lastYear = $year;
						$lastWeek = $week - 1;
						if( $lastWeek == 0 )
						{
							$lastYear = $lastYear - 1;
							$lastWeek = 52;
						}
						$money = $statistic2[$lastYear][$lastWeek][$cardId] + $money;
					}
					$data[] = array(
						'name'=>$year.'年'.sprintf('%02d', $week).'周',
						'year'=>$year,
						'week'=>$week,
						'cardId'=>$cardId,
						'cardName'=>$cardData['name'],
						'money'=>$money
					);
					$statistic2[$year][$week][$cardId] = $money;
				}
			}
		}
		$data = array_reverse($data);
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			    );
	}
	public function get_week_detail_card_statistic($where)
	{
		$result = $this->account_model->sel_by_type_with_card($where);
		if( $result['code'] != 0 )
			return $result;
		$statistic = $result['data'];

		$totalMoney = 0;
		foreach( $statistic as $key=>$value )
		{
			$totalMoney += $value['money'];
		}
		foreach( $statistic as $key=>&$value )
		{
			$typeMap = array(
				1=>'收入',
				2=>'支出',
				3=>'转账收入',
				4=>'转账支出'
			);
			$value['typeName'] = $typeMap[$value['type']];
			$value['precent'] = round($value['money']/$totalMoney*100, 2).'%';
		}
		return array(
			'code'=>0,
			'msg'=>'',
			'data'=>$statistic
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
