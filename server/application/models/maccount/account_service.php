<?php
class Account_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('maccount/account_model', 'account_model');
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
	/*public function get_week_type_statistic($where)
	  {
	  $order = array(
	  'createTime'=>'desc'
	  );
	  $data = $this->account_model->get_account_by_order($where, $order);
	  $use_data = $data['data'];
	  $num = count($use_data);

	  $in_money = 0;
	  $out_money = 0;
	  $transfer_in_money = 0;
	  $transfer_out_money = 0;
	  $year = '';
	  $week = '';
	  $name = '';
	  $j = 0;
	  $weeks = array();
	  foreach($use_data as $key=>$value)
	  {
	  $create_time = $value['createTime'];
	  $ctime = strtotime($create_time);
	  $week = date('W', $ctime);
	  $year = date('Y', $ctime);
	  $name = $year.'年'.$week.'周';
	  $type = $value['type'];

	  switch($type)
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
	  $result[$key] = array(
	  'name'=>$name,
	  'year'=>$year,
	  'week'=>$week,
	  'type'=>$type,
	  'typeName'=>$type_name,
	  'money'=>$value['money']
	  );
	  }

	/*if( $result[0]['year'] == $result[$num - 1]['year'] )
	{
	$data_size = 4 * ($result[0]['week'] - $result[$num - 1]['week']);
	}
	else
	{
	$data_size = 4 * ($result[0]['week'] - $result[$num - 1]['week'] + ($result[0]['year'] - $result[$num - 1]['year']) * 53);
	}

	if( $result[0]['type'] == '1' )
	{
	$in_money += $result[0]['money'];
	}
	elseif( $result[0]['type'] == '2' )
	{
	$out_money += $result[0]['money'];
	}
	elseif( $result[0]['type'] == '3' )
	{
	$transfer_in_money += $result[0]['money'];
	}
	elseif( $result[0]['type'] == '4' )
	{
	$transfer_out_money += $result[0]['money'];
	}

	$n = 0;
	for($m = 0; $m < $data_size; $m + 4)
	{
	//记住那个位置$n+1
	for($n; $n < $num; $n ++)
	{
	if( $result[$n]['week'] == $result[$n + 1]['week'] )
	{
	if( $result[$n]['type'] == '1' )
	{
	$in_money += $result[$n + 1]['money'];
	}
	elseif( $result[$n]['type'] == '2' )
	{
	$out_money += $result[$n + 1]['money'];
	}
	elseif( $result[$n]['type'] == '3' )
	{
	$transfer_in_money += $result[$n + 1]['money'];
	}
	elseif( $result[$n]['type'] == '4' )
	{
	$transfer_out_money += $result[$n + 1]['money'];
	}
	}
	else
	{
	$n = $n + 1;
	break;
	}
	}
	$week_data[$m] = array(
	'name'=>$result[$n]['name'],
	'year'=>$result[$n]['year'],
	'week'=>$result[$n]['week'],
	'type'=>'1',
	'typeName'=>'收入',
	'money'=>$in_money
	);
	$week_data[$m + 1] = array(
	'name'=>$result[$n]['name'],
	'year'=>$result[$n]['year'],
	'week'=>$result[$n]['week'],
	'type'=>'2',
	'typeName'=>'支出',
	'money'=>$out_money

		);
	$week_data[$m + 2] = array(
			'name'=>$result[$n]['name'],
			'year'=>$result[$n]['year'],
			'week'=>$result[$n]['week'],
			'type'=>'3',
			'typeName'=>'转账收入',
			'money'=>$transfer_in_money
			);
	$week_data[$m + 3] = array(
			'name'=>$result[$n]['name'],
			'year'=>$result[$n]['year'],
			'week'=>$result[$n]['week'],
			'type'=>'4',
			'typeName'=>'转账支出',
			'money'=>$transfer_out_money
			);
}
return array(
		'code'=>0,
		'msg'=>'',
		'data'=>$result
	    );
}*/
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

	$group = 'type';
	$where['userId'] = $ids['userId'];
	for($i = 0; ;$i++)
	{
		$down_time = strtotime($min_down_time) + $i * 7 * 3600 * 24;
		$up_time = strtotime($min_up_time) + $i * 7 * 3600 * 24;

		if($up_time > ($cmax + 7 * 3600 * 24) )
			break;

		$where['createTime >='] = date('Y-m-d H:i:s', $down_time);
		$where['createTime <='] = date('Y-m-d H:i:s', $up_time); 
		$result = $this->account_model->get_sum_money($where, $group);

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
