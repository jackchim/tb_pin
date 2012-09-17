<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comment_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}
	
	function init_search_condition($conditions=array()){
		if(isset($conditions['keyword'])){
			$keyword = $conditions['keyword'];
			$this->db->like('tupu_comment.comment', $keyword);
			$this->db->or_like('tupu_comment.poster_nickname', $keyword);
		}
		if(isset($conditions['is_show'])){
			$this->db->where('tupu_comment.is_show',$conditions['is_show']);
		}
		if(isset($conditions['is_delete'])){
			$this->db->where('tupu_comment.is_delete',$conditions['is_delete']);
		}
		if (isset($conditions['comment_id']) && intval($conditions['comment_id']) > 0) {
			$this->db->where('tupu_comment.comment_id',$conditions['comment_id']);
		}
		if (isset($conditions['share_id']) && intval($conditions['share_id']) > 0) {
			$this->db->where('tupu_comment.share_id',$conditions['share_id']);
		}
		//$this->db->where('tupu_item.is_deleted',0);
	}
	/**
	 * @todo 发表评论
	 * 传入评论数组
	 *
	 * @param array $comment
	 * @return bool true|false
	 */
	public function add_comment($comment=array()){
		if (empty($comment)) {
			return false;//添加失败
		}
		$comment_id=0;
		if($this->db->insert("tupu_comment",$comment)){
			return $this->db->insert_id();
		}
		return false;
	}
	/**
	 * @todo 统计数目
	 *
	 * @param array $where
	 * @return int 
	 */
	public function count_comments($where=array()){
		if (!$where) {
			return $this->db->count_all_results("tupu_comment");
		}else{
			$this -> init_search_condition($where);
			return $this->db->count_all_results("tupu_comment");
		}
		
	}
	
	/**
	 * @todo 获得评论
	 *
	 * @param int $offset 偏移量
	 * @param int $total 条数
	 * @param array $condition
	 * @return array 
	 */
	public function get_comments($offset=0,$total=10,$condition=array()){
		$this->db->select("*");
		$this->db->from("tupu_comment");
		$this -> db ->order_by('comment_id','desc');
		$this -> init_search_condition($condition);
		return $this -> db ->limit($total,$offset)->get()->result();
	}
	
	/**
	 * @todo 删除一条评论
	 *
	 * @param int $comment_id
	 * @param array $extra 额外的数据　包括share_id
 	 * @param unknown_type $condition
	 */
	public function del_comment($comment_id,$extra=array(),$condition=array()){
		    $condition['comment_id']=$comment_id;
			if (!empty($condition)) {
				if($this->db->delete("tupu_comment",$condition)){
					if($this->update_share($extra['share_id']))
					return true;
					return false;
				}
				return false;
			}
			return false;
	}
	/**
	 * @todo 同步更新share表的评论
	 *
	 * @param 分享id $share_id
	 */
	public function update_share($share_id){
		$comments=$this->get_comments(0,5,array('share_id'=>$share_id,'is_show !='=>2));
		$comments=serialize($comments);
		return $this->db->where("share_id",$share_id)->update("tupu_share",array('comments'=>$comments));
	}
	/**
	 * @todo 更新评论表
	 *
	 * @param int $comment_id
	 * @param array $condition
	 * @return bool
	 */
	public function update_comment($comment_id,$condition=array()){
		return $this->db->where(array('comment_id'=>$comment_id))->update("tupu_comment",$condition);
	}
}