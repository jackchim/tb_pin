<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Follow_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}


	//关注用户的操作，关系状态1:关注对方,2:互相关注
	//注意：此处不设置单纯被对方关注的状态，因为后期总是分开列出我的关注和我的粉丝
	function add_follow($user_id,$friend_id)
	{
		//是否已被对方关注
		$query = $this->db->get_where('tupu_follow', array('user_id' => $friend_id,'friend_id'=>$user_id));
		$row =  $query->row();
		if($row){
			//如果被关注，先将对方关系状态置为2:互相关注
			$this->db->set('friend_status', 2);
			$this->db->where('follow_id', $row->follow_id);
			$this->db->update('tupu_follow');
			if ($user_id !== $friend_id) {
				//给对方粉丝数加1，自己的关注+1
				$this->db->set('total_followers', '`total_followers` + 1',false);
				$this->db->where('user_id', $friend_id);
				$this->db->update('tupu_user');
				
				$this->db->set('total_follows', '`total_follows` + 1',false);
				$this->db->where('user_id', $user_id);
				$this->db->update('tupu_user');
			}
			
			//再将自已记录中的
			$this->db->set('user_id', $user_id);
			$this->db->set('friend_id', $friend_id);
			$this->db->set('friend_status', 2);
			return $this->db->replace('tupu_follow');
		}else{
			if ($user_id !== $friend_id) {
				//给对方粉丝数加1，自己的关注+1
				$this->db->set('total_followers', '`total_followers` + 1',false);
				$this->db->where('user_id', $friend_id);
				$this->db->update('tupu_user');
				
				$this->db->set('total_follows', '`total_follows` + 1',false);
				$this->db->where('user_id', $user_id);
				$this->db->update('tupu_user');
			}
			//log_message('error','SQL: '.$this->db->last_query());
			//如果未被关注，双方关系为1:已关注
			$this->db->set('user_id', $user_id);
			$this->db->set('friend_id', $friend_id);
			$this->db->set('friend_status', 1);
			return $this->db->replace('tupu_follow');
		}
	}

	function remove_follow($user_id,$friend_id)
	{
		$this->db->delete('tupu_follow', array('user_id' => $user_id,'friend_id'=>$friend_id)); 
		//给对方粉丝数减1,我的关注-1
		$this->db->set('total_followers', '`total_followers` - 1',false);
		$this->db->where('user_id', $friend_id);
		$this->db->update('tupu_user');
		
		$this->db->set('total_follows', '`total_follows` - 1',false);
		$this->db->where('user_id', $user_id);
		$this->db->update('tupu_user');
		//将对方关系还原为1		
		$this->db->where('user_id', $friend_id);
		$this->db->where('friend_id', $user_id);
		$this->db->set('friend_status', 1);
		return $this->db->update('tupu_follow');
	}

	function get_friends_count($user_id)
	{
		$this->db->select('count(*) as total_friends')->from('tupu_follow')->where(array('user_id'=>$user_id,'friend_id <>'=>$user_id));
		return $this->db->get()->row();
	}
	
	function get_fans_count($user_id)
	{
		$this->db->select('count(*) as total_fans')->from('tupu_follow')->where(array('friend_id'=>$user_id,'user_id'=>$user_id));
		return $this->db->get()->row();
	}


	function get_friends_info($user_id,$limit = false)
	{
		$this->db->select('tupu_user.*,tupu_follow.friend_status');
		$this->db->from('tupu_follow');
		$this->db->join('tupu_user','tupu_user.user_id = tupu_follow.friend_id','left');
		$this->db->where('tupu_follow.user_id', $user_id);
		$this->db->where('tupu_follow.friend_id <>', $user_id);
		
		if($limit) $this->db->limit($limit);
		
		return $this->db->get()->result();
	}
	//获取我关注的用户
	function get_following_by_uid($user_id , $start = 0 , $row_num = 12){
		$this->db->select('tupu_user.* ,tupu_follow.friend_status');
		$this->db->from('tupu_follow');
		$this->db->join('tupu_user','tupu_user.user_id = tupu_follow.friend_id','left');
		$this->db->where('tupu_follow.user_id', $user_id);
		$this->db->where('tupu_follow.friend_id <>', $user_id);
		$this->db->limit($row_num,$start);
		$return = $this->db->get()->result();
		/*echo $this -> db -> last_query();
		var_dump($return);
		exit;*/
		return $return;
	}
	
	//获取关注我的用户 粉丝
	function get_follower_by_uid($user_id , $start = 0 , $row_num = 12){
		$this->db->select('tupu_user.* ,tupu_follow.friend_status');
		$this->db->from('tupu_follow');
		$this->db->join('tupu_user','tupu_user.user_id = tupu_follow.user_id','left');
		$this->db->where('tupu_follow.friend_id', $user_id);
		$this->db->where('tupu_follow.user_id <>', $user_id);
		$this->db->limit($row_num,$start);
		return $this->db->get()->result();
	}
	
	function get_fans_info($user_id,$limit = false)
	{		
		$this->db->select('tupu_user.*,tupu_follow.friend_status');
		$this->db->from('tupu_follow');
		$this->db->join('tupu_user','tupu_user.user_id = tupu_follow.user_id','left');
		$this->db->where('tupu_follow.friend_id', $user_id);
		$this->db->where('tupu_follow.user_id <>', $user_id);
		
		if($limit) $this->db->limit($limit);
		
		return $this->db->get()->result();
	}

	//获得某两个用户的双方关系，为3种状态
	//注意：与 add_follow() 中的状态标注不一样
	function get_relation($user_id,$friend_id)
	{
		$status = 0;
		if($user_id && $friend_id && $user_id != $friend_id ){
			$this->db->select('user_id')->from('tupu_follow');
			
			$where = '(user_id = '.$user_id.' AND friend_id = '.$friend_id.')';
			$where .= ' or (user_id = '.$friend_id.' AND friend_id = '.$user_id.')';
	
			$this->db->where($where);
			
			foreach ($this->db->get()->result() as $row)
			{
			   if($row->user_id == $user_id) $status += 1;
			   if($row->user_id == $friend_id) $status += 2;
			}
		}elseif($user_id == $friend_id){
			$status = 4;
			
		}
		return $status;  // 0:无关系，1:关注对方, 2: 被关注, 3:互相关注
	}
	
	

}