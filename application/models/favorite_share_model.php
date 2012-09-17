<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Favorite_share_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}


	function get_favorite_shares($user_id,$start=0,$num=20)
	{

		$this->db->select('tupu_share.*,tupu_item.*,tupu_album.*');
		$this->db->from('tupu_favorite_sharing');
		$this->db->join('tupu_share','tupu_share.share_id = tupu_favorite_sharing.share_id','left');
		$this->db->join('tupu_album','tupu_album.album_id = tupu_share.album_id','left');
		$this->db->join('tupu_item','tupu_item.item_id = tupu_share.item_id','left');
		$this->db->where('tupu_favorite_sharing.user_id',$user_id);
		$this->db->order_by("tupu_favorite_sharing.favorite_id", "desc");
		$this->db->limit($num,$start);
		//$this->db->get()->result();
		//var_dump($this -> db -> last_query());exit;
		return	$this->db->get()->result();
	}
	
	/**
	 * @todo 获得首页习惯过的分享
	 *
	 * @param int $start
	 * @param int $num
	 * @return array
	 */
	function get_favorite_common_shares($start=0,$num=20)
	{

		$this->db->select('tupu_share.*,tupu_item.*,tupu_favorite_sharing.share_time');
		$this->db->from('tupu_favorite_sharing');
		$this->db->join('tupu_share','tupu_share.share_id = tupu_favorite_sharing.share_id','left');
		//$this->db->join('tupu_album','tupu_album.album_id = tupu_share.album_id','left');
		$this->db->join('tupu_item','tupu_item.item_id = tupu_share.item_id','left');
		$this->db->order_by("tupu_favorite_sharing.favorite_id", "desc");
		$this->db->where("tupu_share.share_id is not null");
		$this->db->limit($num,$start);
		//$this->db->get()->result();
		//var_dump($this -> db -> last_query());exit;
		return 	$this->db->get()->result();
		
	}
	
	function check_favorited($user_id,$share_id)
	{

		$this->db->where('share_id',$share_id);
		$this->db->where('user_id',$user_id);
		return	$this->db->get('tupu_favorite_sharing')->row();
	}

	function add_favorite_share($share_id,$user_id)
	{
		if($this->check_favorited($user_id, $share_id)){
			return false;
		}
		$data['share_id'] = $share_id;
		$data['user_id'] = $user_id;
		$data['share_time'] = time();
		return $this->db->insert('tupu_favorite_sharing',$data);
	}


	function del_favorite_share($share_id,$user_id = 0)
	{
		$this->db->where('share_id',$share_id);
		if ($user_id != 0) {
			$this->db->where('user_id',$user_id);
		}
		return $this->db->delete('tupu_favorite_sharing');
	}

	function del_all_favorite_share($share_id)
	{
		$this->db->where('share_id',$share_id);
		return $this->db->delete('tupu_favorite_sharing');
	}

}