<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tag_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}

	function fetch_tags_by_category($category_id)
	{
		$this->db->where('category_id',$category_id)->get('tupu_tag');
		$this->db->order_by("tag_id", "desc");
		return $this->db->get()->result();
	}

	function fetch_tags_by_group($group_name)
	{
		$this->db->select('*');
		$this->db->from('tupu_tag');
		$this->db->where('tag_group_name_en',$group_name);
		$this->db->order_by("tag_id", "desc");
		return $this->db->get()->result();
	}

	function fetch_tags_with_category($category_name_en = '')
	{
		$this->db->select('*');
		$this->db->from('tupu_tag');
		$this->db->join('tupu_category','tupu_category.category_id = tupu_tag.category_id','left');
		if($category_name_en)
			$this->db->where('tupu_category.category_name_en',$category_name_en);
		$this->db->order_by("tupu_tag.display_order", "asc");
		return $this->db->get()->result();
	}

	function get_tags()
	{
		$this->db->order_by("tupu_tag.display_order", "asc");
		return $this->db->get('tupu_tag')->result();
	}

	function add_tag($data)
	{
		return $this->db->insert('tupu_tag',$data);
	}

	function edit_tag($tag_id,$data)
	{
		return $this->db->where('tag_id',$tag_id)->update('tupu_tag',$data);
	}

	function del_tag($tag_id)
	{
		return $this->db->where('tag_id',$tag_id)->delete('tupu_tag');
	}
	
	function get_tag($tag_id)
	{
		return $this->db->where('tag_id',$tag_id)->get('tupu_tag')->row();
	}

}