<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CategoryDb extends CI_Model {
	var $tableName = "t_category";

	public function __construct(){
		parent::__construct();
	}

	public function search($where,$limit){
		foreach( $where as $key=>$value ){
			if( $key == "name" || $key == 'remark' )
				$this->db->like($key,$value);
		}
		
		$count = $this->db->count_all_results($this->tableName);
		
		foreach( $where as $key=>$value ){
			if( $key == "name" || $key == 'remark' )
				$this->db->like($key,$value);
		}
			
		$this->db->order_by('createTime','desc');
		
		if( isset($limit["pageIndex"]) && isset($limit["pageSize"]))
			$this->db->limit($limit["pageSize"],$limit["pageIndex"]);

		$query = $this->db->get($this->tableName);
		return array(
				"code"=>0,
				"msg"=>"",
				"data"=>array(
					"count"=>$count,
					"data"=>$query->result_array()
				)
		);
	}

	public function get($categoryId){
		$this->db->where("categoryId",$categoryId);
		$query = $this->db->get($this->tableName)->result_array();
		if( count($query) == 0 )
			return array(
					"code"=>1,
					"msg"=>"不存在此数据",
					"data"=>""
				    );
		return array(
				"code"=>0,
				"msg"=>"",
				"data"=>$query[0]
			    );
	}

	public function del( $categoryId ){
		$this->db->where("categoryId",$categoryId);
		$query = $this->db->delete($this->tableName);
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>""
			);
	}
	
	public function add( $data ){
		$query = $this->db->insert($this->tableName,$data);
		return array(
			"code"=>0,
			"msg"=>"",
			"data"=>""
			);
	}

	public function mod( $categoryId , $data )
	{
		$this->db->where("categoryId",$categoryId);
		$query = $this->db->update($this->tableName,$data);
		return array(
				"code"=>0,
				"msg"=>"",
				"data"=>""
			    );
	}

}
