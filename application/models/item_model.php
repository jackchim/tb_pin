<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Item_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}

	function get_item_by_id($item_id)
	{
		return $this->db->where('item_id',$item_id)->get('tupu_item')->row();
	}
	
	function get_item_images_by_id($item_id)
	{
		$imgs = $this -> db -> select('image_path') -> where('item_id',$item_id) -> get('tupu_item') -> row() -> image_path;
		return unserialize($imgs);
	}
	
	function remote_to_local($item_id , $imgs){
		return $this->db->where('item_id',$item_id)->update('tupu_item',array('image_path'=>$imgs , 'is_remote_image' => 0));
	}
	
	function search_item($start=0,$num=20, $conditions=array() )
	{
		$this->init_search_condition($conditions);
		$this->db->limit($num,$start);
		return $this->db->get('tupu_item')->result();
	}

	function init_search_condition($conditions=array()){
		if(isset($conditions['keyword'])){
			$this->db->where('MATCH (tupu_item.intro_search) AGAINST ("'.$conditions['keyword'].'" IN BOOLEAN MODE)', NULL, FALSE);
			
		}
		if(isset($conditions['key'])){
			$keyword = $conditions['key'];
			$this->db->or_like('intro', $keyword);
			$this->db->or_like('intro_search', $keyword);
		}
		if(isset($conditions['is_show'])){
			$this->db->where('tupu_item.is_show',$conditions['is_show']);
		}
		if (isset($conditions['is_remote_image'])) {
			$this->db->where('tupu_item.is_remote_image',$conditions['is_remote_image']);
		}
		$this->db->where('tupu_item.is_deleted',0);
	}

	function count_item($conditions=array())
	{
		$this->db->select('COUNT(*) AS total');
		$this->db->from('tupu_item');
		$this->init_search_condition($conditions);
		$total = $this->db->get()->row()->total;
		//var_dump($this -> db -> last_query());exit;
		return $total;
	}

	function get_items($start=0,$num=2)
	{
		$this->db->limit($num,$start);
		return $this->db->get('tupu_item')->result();
	}

	function add_item($data)
	{
		 if($this->db->insert('tupu_item',$data)){
		 	return $this->db->insert_id();
		 }
		 return false;
		
	}

	function edit_item($item_id,$data)
	{
		return $this->db->where('item_id',$item_id)->update('tupu_item',$data);
	}
	
	function flag_item_del($item_id)
	{
		if(!$item_id)
			return false;
		return $this->db->where('item_id',$item_id)->update('tupu_item',array('is_deleted'=>1));
	}

	function del_item($item_id)
	{
		//删除文件
		$item = $this -> db -> select('image_path') -> where('item_id',$item_id) -> get('tupu_item') -> row();
		$file_name = $item -> image_path;
		$file_1 = FCPATH.$file_name.'.jpg';
		$file_2 = FCPATH.$file_name.'_large.jpg';
		$file_3 = FCPATH.$file_name.'_middle.jpg';
		$file_4 = FCPATH.$file_name.'_small.jpg';
		$file_5 = FCPATH.$file_name.'_square.jpg';
		for($i = 1;$i <= 5;$i++){
			$file = 'file_'.$i;
			if (file_exists($$file)) {
				unlink($$file);
			}
		}
		$this -> load -> model('share_model');
		$this -> share_model -> del_shares_by_item($item_id);
		return $this->db->where('item_id',$item_id)->delete('tupu_item');
	}

}