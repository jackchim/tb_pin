<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @todo 友情链接
 *
 */
class Friendlink_model extends CI_Model{

	/**
	 * @todo 构造函数，无意义
	 *
	 */
	function __construct()
	{
		parent::__construct();
	}
	//获取全部的友情链接列表
	function get_list($limit = 0){
		$this -> db -> select("*");
		$this -> db -> from("tupu_friendlink");
		$this -> db -> order_by('display_order','desc');
		if ($limit != 0) {
			$this -> db -> limit($limit);
		}
		return $this -> db -> get() -> result();
	}
	
	function add_link($data){
		if (empty($data)) {
			return false;//添加失败
		}
		if($this->db->insert("tupu_friendlink",$data)){
			return $this->db->insert_id();
		}
		return false;
	}
	function edit_link($id,$set)
	{
		return $this->db->where('id',$id)->update('tupu_friendlink',$set);
	}
	function del_link($id)
	{
		$this->db->where('id',$id);
		if($this->db->delete('tupu_friendlink')){
			return true;
		}
		return false;
	}

	function getOne($id){
		$this -> db -> select('*');
		$this -> db -> from('tupu_friendlink');
		$this ->db -> where('id',$id);
		return $this -> db -> get() -> row();
	}
}