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
		if( count($data['data']) == 0 )
			return array(
					'code'=>1,
					'msg'=>'no data',
					'data'=>''
				    );
		return $data;
	}
	public function get_user_by_name($name)
	{
		$data = $this->user_model->get_user_by_name($name);
		$num = count($data['data']);
		if( $num == 0 )
			return array(
					'code'=>1,
					'msg'=>'no data',
					'data'=>''
				    );


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
	public function add($name, $password, $type, $createTime, $modifyTime)
	{
		$data = $this->user_model->get_user_by_name($name);
		if( count($data['data']) != 0 )
			return array(
					'code'=>1,
					'msg'=>'name is already exist.',
					'data'=>''
				    );
		$data = $this->user_model->add($name, $password, $type, $createTime, $modifyTime);
		return $data;
	}
	public function mod_user_type($userId, $type, $modifyTime)
	{
		$data = $this->user_model->mod_user_type($userId, $type, $modifyTime);
		return $data;
	}
	public function mod_user_pwd($userId, $pwd, $modifyTime)
	{
		$data = $this->user_model->mod_user_pwd($userId, $pwd, $modifyTime);
		return $data;
	}
	public function mod_old_pwd($old, $new, $modifyTime)
	{
		$name = $this->session->userdata('user_name');
		$data = $this->user_model->get_user_by_name($name);
		$tmp = $data['data'];
		if( $tmp[0]['password'] == $old )
		{
			$data = $this->user_model->mod_user_pwd($name, $new, $modifyTime);
			return $data;
		}
		return array(
				'code'=>1,
				'msg'=>'wrong password',
				'data'=>''
			    );
	}
	public function get_user_by_name_and_type($name, $type)
	{
		$data = $this->user_model->get_user_by_name_and_type($name, $type);
		$num = count($data['data']);
		if( $num == 0)
			return array(
					'code'=>1,
					'msg'=>'no data',
					'data'=>''
				    );
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
