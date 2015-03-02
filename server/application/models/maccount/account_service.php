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
		$min = $this->account_model->get_min_time();
		$max = $this->account_model->get_max_time();
		$min_time = $min['data'][0];
		$max_time = $max['data'][0];
		$cmin = strtotime($min_time['createTime']);
		$cmax = strtotime($max_time['createTime']);
		$min_week = date('W', $cmin);
		$min_year = date('Y', $cmin);
		$max_week = date('W', $cmax);
		$max_year = date('Y', $cmax);
		$min_week_day = date('w', $cmin);
		$max_week_day = date('w', $cmax);

		$down_time_day = date('Y-m-d', $cmin - $min_week_day * 3600 * 24);
		$min_down_time = $down_time_day.' 00:00:00';
		$up_time_day = date('Y-m-d', $cmin + (7 - $min_week_day) * 3600 * 24);
		$min_up_time = $up_time_day.' 23:59:59';

		$group = array(
				'type'=>'type'
			      );
		$where['userId'] = $ids['userId'];
		$select = array(
				'type'=>'type',
				'money'=>'money'
			       );
		for($i = 0; ;$i++)
		{
			$down_time = strtotime($min_down_time) + $i * 7 * 3600 * 24;
			$up_time = strtotime($min_up_time) + $i * 7 * 3600 * 24;

			if($up_time > ($cmax + 7 * 3600 * 24) )
				break;

			$where['createTime >='] = date('Y-m-d H:i:s', $down_time);
			$where['createTime <='] = date('Y-m-d H:i:s', $up_time); 
			$result = $this->account_model->sel($select, $where, $group);

			if( $result['data'] != FALSE )
			{
				$week = $min_week + $i;
				if($week > 53)
				{
					$year = $min_year + 1;
					$week = 1;
				}
				else
				{
					$year = $min_year;
				}

				for( $j = 0; $j < count($result['data']); $j ++ )
				{
					switch($result['data'][$j]['type'])
					{
						case '1':
							$in_money = $result['data'][$j]['money'];
							break;
						case '2':
							$out_money = $result['data'][$j]['money'];
							break;
						case '3':
							$transfer_in_money = $result['data'][$j]['money'];
							break;
						case '4':
							$transfer_out_money = $result['data'][$j]['money'];
							break;
						default:
							break;
					}
				}

				$data[0 + $i * 4] = array(
						'name'=>$year.'年'.$week.'周',
						'year'=>$year,
						'week'=>$week,
						'type'=>'1',
						'typeName'=>'收入',
						'money'=>$in_money
						);
				$data[1 + $i * 4] = array(
						'name'=>$year.'年'.$week.'周',
						'year'=>$year,
						'week'=>$week,
						'type'=>'2',
						'typeName'=>'支出',
						'money'=>$out_money
						);
				$data[2 + $i * 4] = array(
						'name'=>$year.'年'.$week.'周',
						'year'=>$year,
						'week'=>$week,
						'type'=>'3',
						'typeName'=>'转账收入',
						'money'=>$transfer_in_money
						);
				$data[3 + $i * 4] = array(
						'name'=>$year.'年'.$week.'周',
						'year'=>$year,
						'week'=>$week,
						'type'=>'4',
						'typeName'=>'转账支出',
						'money'=>$transfer_out_money
						);
			}
			else
			{
				$week = $min_week + $i;
				if($week > 53)
				{
					$year = $min_year + 1;
					$week = 1;
				}
				else
				{
					$year = $min_year;
				}
				$data[0 + $i * 4] = array(
						'name'=>$year.'年'.$week.'周',
						'year'=>$year,
						'week'=>$week,
						'type'=>'1',
						'typeName'=>'收入',
						'money'=>0
						);
				$data[1 + $i * 4] = array(
						'name'=>$year.'年'.$week.'周',
						'year'=>$year,
						'week'=>$week,
						'type'=>'2',
						'typeName'=>'支出',
						'money'=>0
						);
				$data[2 + $i * 4] = array(
						'name'=>$year.'年'.$week.'周',
						'year'=>$year,
						'week'=>$week,
						'type'=>'3',
						'typeName'=>'转账收入',
						'money'=>0
						);
				$data[3 + $i * 4] = array(
						'name'=>$year.'年'.$week.'周',
						'year'=>$year,
						'week'=>$week,
						'type'=>'4',
						'typeName'=>'转账支出',
						'money'=>0
						);
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
		$year = $where['year'];
		$week = $where['week'];
		$first_week_day = date('w', strtotime($year.'-01-01 00:00:00'));
		if($week == '1')
		{
			$down_time = $year.'-01-01 00:00:00';
			$down_time_unix = strtotime($down_time);
			$up_time = date('Y-m-d H:i:s', $down_time_unix + (7 - $first_week_day + 1) * 24 * 3600 );
		}
		$first_day = $year.'-01-01 00:00:00';
		$first_time = strtotime($first_day);
		$down_time = date('Y-m-d H:i:s', $first_time - ($first_week_day - 1 - ($week - 1) * 7) * 24 * 3600 );
		$up_time = date('Y-m-d H:i:s', strtotime($down_time) + 7 * 24 * 3600 );

		$select = array(
				'money'=>'money',
				'name'=>'name',
				'categoryId'=>'categoryId'
			       );
		$where_time = array(
				'createTime >='=>$down_time,
				'createTime <='=>$up_time,
				'userId'=>$where['userId'],
				'type'=>$where['type']
				);
		$group = array(
				'categoryId'=>'categoryId'
			      );
		$result = $this->account_model->sel($select, $where_time, $group);
		if( $result['data'] != FALSE )
		{
			foreach($result['data'] as $key=>$value)
			{
			$select = array(
					'money'=>'money'	
				       );
			$group = array();
			$temp = $this->account_model->sel($select, $where_time, $group);
			if( $value['categoryId'] === '0')
			{
				$data = array(
				);
			}
			else
			{
			$ids = array(
						'categoryId'=>$value['categoryId']
					    );
			
				$cate_names = $this->category_model->get_category_by_id($ids);
				$precent = round($value['money']/$temp['data'][0]['money']*100, 2).'%';
				$data[$key] = array(
						'categoryId'=>$value['categoryId'],
						'categoryName'=>$cate_names['data'][0]['name'],
						'money'=>$value['money'],
						'precent'=>$precent
						);
			}
			}
		}
		else
		{
			$data = array();
		}
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
			    );
	}
	public function get_week_card_statistic($ids)
	{
		$min = $this->account_model->get_min_time();
		$max = $this->account_model->get_max_time();
		$min_time = $min['data'][0];
		$max_time = $max['data'][0];
		$cmin = strtotime($min_time['createTime']);
		$cmax = strtotime($max_time['createTime']);
		$min_week = date('W', $cmin);
		$min_year = date('Y', $cmin);
		$max_week = date('W', $cmax);
		$max_year = date('Y', $cmax);
		$min_week_day = date('w', $cmin);
		$max_week_day = date('w', $cmax);

		$down_time_day = date('Y-m-d', $cmin - $min_week_day * 3600 * 24);
		$min_down_time = $down_time_day.' 00:00:00';
		$up_time_day = date('Y-m-d', $cmin + (7 - $min_week_day) * 3600 * 24);
		$min_up_time = $up_time_day.' 23:59:59';

		$select = array(
				'money'=>'money'
			       );
		$where['userId'] = $ids['userId'];
		$group = array(
			      );

		$cards = $this->card_model->search($ids, array());
		$count = $cards['data']['count'];
		$card_data = $cards['data']['data'];
		for($i = 0; ;$i++)
		{
			$down_time = strtotime($min_down_time) + $i * 7 * 3600 * 24;
			$up_time = strtotime($min_up_time) + $i * 7 * 3600 * 24;

			if($up_time > ($cmax + 7 * 3600 * 24))
				break;

			$where['createTime >='] = date('Y-m-d H:i:s', $down_time);
			$where['createTime <='] = date('Y-m-d H:i:s', $up_time);

			foreach($card_data as $key=>$value)
			{
				$where['cardId'] = $value['cardId'];
				$result = $this->account_model->sel($select, $where, $group);

				if( $result['data'][0]['money'] != NULL )
				{
					$week = $min_week + $i;
					if($week > 53)
					{
						$year = $min_year + 1;
						$week = 1;
					}
					else
					{
						$year = $min_year;
					}

					$data[$key + $i * $count] = array(
							'name'=>$year.'年'.$week.'周',
							'year'=>$year,
							'week'=>$week,
							'cardId'=>$value['cardId'],
							'cardName'=>$value['name'],
							'money'=>$result['data'][0]['money']
							);
				}
				else
				{
					$week = $min_week + $i;
					if($week > 53)
					{
						$year = $min_year + 1;
						$week = 1;
					}
					else
					{
						$year = $min_year;
					}
					$data[$key + $i * $count] = array(
							'name'=>$year.'年'.$week.'周',
							'year'=>$year,
							'week'=>$week,
							'cardId'=>$value['cardId'],
							'cardName'=>$value['name'],
							'money'=>0
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
	public function get_week_detail_card_statistic($where)
	{
		$year = $where['year'];
		$week = $where['week'];
		$first_week_day = date('w', strtotime($year.'-01-01 00:00:00'));
		if( $week == '1')
		{
			$down_time = $year.'-01-01 00:00:00';
			$down_time_unix = strtotime($down_time);
			$up_time = date('Y-m-d H:i:s', $down_time_unix + (7 - $first_week_day + 1) * 24 * 3600 );
		}
		$first_day = $year.'-01-01 00:00:00';
		$first_time = strtotime($first_day);
		$down_time = date('Y-m-d H:i:s', $first_time - ($first_week_day - 1 - ($week - 1)*7) * 24 * 3600);
		$up_time = date('Y-m-d H:i:s', strtotime($down_time) + 7 * 24 * 3600 );

		$select = array(
				'money'=>'money',
				'type'=>'type'
			       );
		$where_time = array(
				'createTime >='=>$down_time,
				'createTime <='=>$up_time,
				'userId'=>$where['userId'],
				'cardId'=>$where['cardId']
				);
		$group = array(
				'type'=>'type'
			      );
		$result = $this->account_model->sel($select, $where_time, $group);
		if( $result['data'] != FALSE )
		{
			foreach($result['data'] as $key=>$value)
			{
			$select = array(
					'money'=>'money'	
				       );
			$group = array();
			$temp = $this->account_model->sel($select, $where_time, $group);
			$precent = round($value['money']/$temp['data'][0]['money']*100, 2).'%';
			switch($value['type'])
			{
				case '1':
					$type_name = '收入';
					break;
				case '2':
					$type_name = '支出';
					break;
				case '3':
					$type_name = '转账收入';
					break;
				case '4':
					$type_name = '转账支出';
					break;
				default:
					break;
			}
			$data[$key] = array(
					'type'=>$result['data'][0]['type'],
					'typeName'=>$type_name,
					'money'=>$value['money'],
					'precent'=>$precent
					);
			}
		}
		else
		{
			$data = array();
		}
		return array(
				'code'=>0,
				'msg'=>'',
				'data'=>$data
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

		$ids = array(
				'userId'=>$data['userId'],
				'cardId'=>$data['cardId']
			    );
		$cards = $this->card_model->get_card_by_id($ids);
		if( $data['type'] === '1' OR $data['type'] === '3' )
		{
			$card_money = $cards['data'][0]['money'] + $data['money'];
		}
		elseif( $data['type'] === '2' OR $data['type'] === '4' )
		{
			$card_money = $cards['data'][0]['money'] - $data['money'];
		}
		$card_moneys = array(
				'money'=>$card_money
				);
		$this->card_model->mod($ids, $card_moneys);
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
			if( isset($data['money']) && isset($data['cardId']) )
			{
				$ids = array(
						'userId'=>$where['userId'],
						'cardId'=>$data['cardId']
					    );
				$cards = $this->card_model->get_card_by_id($ids);
				if( $accounts[0]['type'] === '1' OR $accounts[0]['type'] === '3' )
				{
					$origin_money = $cards['data'][0]['money'] - $accounts[0]['money'];
				}
				elseif( $accounts[0]['type'] === '2' OR $accounts[0]['type'] === '4' )
				{
					$origin_money = $cards['data'][0]['money'] + $accounts[0]['money'];
				}

				if( $data['type'] === '1' OR $data['type'] === '3' )
				{
					$card_money = $origin_money  + $data['money'];
				}
				elseif( $data['type'] === '2' OR $data['type'] === '4' )
				{
					$card_money = $origin_money - $data['money'];
				}
				$card_moneys = array(
						'money'=>$card_money
						);
				$this->card_model->mod($ids, $card_moneys);
			}
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

		if( isset($data['money']) && isset($data['cardId']) )
		{
			$ids = array(
					'userId'=>$where['userId'],
					'cardId'=>$data['cardId']
				    );
			$cards = $this->card_model->get_card_by_id($ids);
			if( $accounts[0]['type'] === '1' OR $accounts[0]['type'] === '3' )
			{
				$origin_money = $cards['data'][0]['money'] - $accounts[0]['money'];
			}
			elseif( $accounts[0]['type'] === '2' OR $accounts[0]['type'] === '4' )
			{
				$origin_money = $cards['data'][0]['money'] + $accounts[0]['money'];
			}

			if( $data['type'] === '1' OR $data['type'] === '3' )
			{
				$card_money = $origin_money + $data['money'];
			}
			elseif( $data['type'] === '2' OR $data['type'] === '4' )
			{
				$card_money = $origin_money - $data['money'];
			}
			$card_moneys = array(
					'money'=>$card_money
					);
			$this->card_model->mod($ids, $card_moneys);
		}
		$result = $this->account_model->mod($where, $data);
		return $result;
	}
}
