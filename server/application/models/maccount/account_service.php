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
	public function get_week_type_statistic($where)
	{
		$data = $this->account_model->get_account_by_order($where);
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
			$modify_time = $value['modifyTime'];
			$mtime = strtotime($modify_time);
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

		if( $result[0]['year'] == $result[$num - 1]['year'] )
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

		for($m = 0; $m < $data_size; $m + 4)
		{
			for($n = 0; $n < $num; $n ++)
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
				'data'=>$week_data
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
