<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Favorite_album_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}


	function get_favorite_albums($user_id,$start=0,$num=20)
	{

		$this->db->select('*');
		$this->db->from('tupu_favorite_album');
		$this->db->join('tupu_album','tupu_album.album_id = tupu_favorite_album.album_id','left');
		$this->db->join('tupu_user','tupu_user.user_id = tupu_album.user_id','left');
		$this->db->where('tupu_favorite_album.user_id',$user_id);
		$this->db->where('tupu_album.is_show != ',2);//屏蔽过滤
		$this->db->order_by("tupu_favorite_album.favorite_id", "desc");
		$this->db->limit($num,$start);
		return	$this->db->get()->result();
	}

	function check_favorited($user_id,$album_id)
	{

		$this->db->where('album_id',$album_id);
		$this->db->where('user_id',$user_id);
		return	$this->db->get('tupu_favorite_album')->row();
	}

	function add_favorite_album($album_id,$user_id)
	{
		if($this->check_favorited($user_id, $album_id)){
			return false;
		}
		$this->load->model('album_model');
		$album = $this->album_model->get_album_by_id($album_id);
		if($album->user_id == $user_id){
			return false;
		}
		//相册喜欢+1
		$this -> album_model -> update_total_favorite($album_id);
		$data['album_id'] = $album_id;
		$data['user_id'] = $user_id;
		return $this->db->insert('tupu_favorite_album',$data);
	}


	function del_favorite_album($album_id,$user_id)
	{
		$this->db->where('album_id',$album_id);
		$this->db->where('user_id',$user_id);
		//相册喜欢-1
		$this->load->model('album_model');
		$this -> album_model -> update_total_favorite($album_id , 'del');
		
		return $this->db->delete('tupu_favorite_album');
	}

	function del_all_favorite_album($album_id)
	{
		$this->db->where('album_id',$album_id);
		return $this->db->delete('tupu_favorite_album');
	}

}