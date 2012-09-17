<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}
	

	public function get_default_category()
	{
		$this->db->where('is_system',1);
		return $this->db->get('tupu_category')->row();
	}
	
	public function get_category_by_enname($enname){
		
		$this->db->where('category_name_en',$enname);
		return	$this->db->get('tupu_category')->row();
	}

	function get_categories($condition = '')
	{
		if ($condition != '') {
			//array('is_system !=' => 1);
			$this -> db -> where($condition);
		}
		$this->db->order_by("is_system", "asc");
		$this->db->order_by("category_id", "asc");
		return	$this->db->get('tupu_category')->result();
	}

	function add_category($data)
	{
		return $this->db->insert('tupu_category',$data);
	}

	function edit_category($category_id,$data)
	{
		return $this->db->where('category_id',$category_id)->update('tupu_category',$data);
	}

	function del_category($category_id)
	{
		return $this->db->where('category_id',$category_id)->delete('tupu_category');
	}
	
	function get_category($category_id)
	{
		return $this->db->where('category_id',$category_id)->get('tupu_category')->row();
	}
	/**
	 * 统计网站商品图数量
	 *
	 * @return int 商品图片的数量
	 */
	function count_conduct_share(){
		return $this->db->count_all_results("tupu_item");
	}
}