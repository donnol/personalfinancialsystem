<?php
class User_service extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('muser/user_model', 'user_model');
	}
	public function get_all_user($pageIndex, $pageSize)
	{
		$data = $this->user_model->get_all_user();
		$num = count($data['data']);
		if( $num == 0 )
			return array(
					'code'=>1,
					'msg'=>'no data',
					'data'=>''
				    );
		if( $pageSize < $num)
		{
			$leave = $num - $pageIndex;
			$t = 0;
			if($leave > $pageSize)
			{
				for($i = $pageIndex; $i < ($pageIndex + $pageSize); $i++)
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
				for($k = $pageIndex; $k < ($pageIndex + $leave); $k++)
				{
					$tdata[$t++] = $data['data'][$k];
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
	public function get_user_by_id($userId)
	{
		$data = $this->user_model->get_user_by_id($userId);
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
	public function get_user_by_name($name, $pageIndex, $pageSize)
	{
		$data = $this->user_model->get_user_by_name($name);
		$num = count($data['data']);
		if( $num == 0 )
			return array(
					'code'=>1,
					'msg'=>'no data',
					'data'=>''
				    );
		if( $pageSize < $num)
		{
			$leave = $num - $pageIndex;
			$t = 0;
			if($leave > $pageSize)
			{
				for($i = $pageIndex; $i < ($pageIndex + $pageSize); $i++)
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
				for($k = $pageIndex; $k < ($pageIndex + $leave); $k++)
				{
					$tdata[$t++] = $data['data'][$k];
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
	public function get_user_by_type($type, $pageIndex, $pageSize)
	{
		$data = $this->user_model->get_user_by_type($type);
		$num = count($data['data']);
		if( $num == 0 )
			return array(
					'code'=>1,
					'msg'=>'no data',
					'data'=>''
				    );
		if( $pageSize < $num)
		{
			$leave = $num - $pageIndex;
			$t = 0;
			if($leave > $pageSize)
			{
				for($i = $pageIndex; $i < ($pageIndex + $pageSize); $i++)
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
				for($k = $pageIndex; $k < ($pageIndex + $leave); $k++)
				{
					$tdata[$t++] = $data['data'][$k];
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
	public function del($userId)
	{
		$data = $this->user_model->del($userId);
		return $data;
	}
	public function add($name, $password, $type)
	{
		$data = $this->user_model->get_user_by_name($name);
		if( count($data['data']) != 0 )
			return array(
					'code'=>1,
					'msg'=>'name is already exist.',
					'data'=>''
				    );
		$password = sha1($password);
		$data = $this->user_model->add($name, $password, $type);
		return $data;
	}
	public function mod_user_type($userId, $type)
	{
		$data = $this->user_model->mod_user_type($userId, $type);
		return $data;
	}
	public function mod_user_pwd($userId, $pwd)
	{
		$pwd = sha1($pwd);
		$data = $this->user_model->mod_user_pwd($userId, $pwd);
		return $data;
	}
	public function mod_old_pwd($old, $new)
	{
		$old = sha1($old);
		$data = $this->user_model->get_user_by_pwd($old);
		$tmp = $data['data'];
		$userId = $tmp[0]['userId'];
		if( count($data['data']) != 0 )
		{
			$new = sha1($new);
			$data = $this->user_model->mod_user_pwd($userId, $new);
			return $data;
		}
		return array(
				'code'=>1,
				'msg'=>'wrong password',
				'data'=>''
			    );
	}
	public function get_user_by_name_and_type($name, $type, $pageIndex, $pageSize)
	{
		$data = $this->user_model->get_user_by_name_and_type($name, $type);
		$num = count($data['data']);
		if( $num == 0)
			return array(
					'code'=>1,
					'msg'=>'no data',
					'data'=>''
				    );
		if( $pageSize < $num)
		{
			$leave = $num - $pageIndex;
			$t = 0;
			if($leave > $pageSize)
			{
				for($i = $pageIndex; $i < ($pageIndex + $pageSize); $i++)
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
				for($k = $pageIndex; $k < ($pageIndex + $leave); $k++)
				{
					$tdata[$t++] = $data['data'][$k];
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
} 
