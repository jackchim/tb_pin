<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Share_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}

	private function init_search_condition($conditions){
		if(isset($conditions['keyword'])){
			$this->db->where("MATCH (`".$this->db->dbprefix."tupu_item`.`intro_search`) AGAINST (\"".$conditions['keyword'].'" IN BOOLEAN MODE)', NULL, FALSE);
		}
		if(isset($conditions['category_id'])){
			$this->db->where('tupu_item.category_id',$conditions['category_id']);
		}
		if(isset($conditions['is_show'])){
			if ($conditions['is_show'] == 1) {
				$this->db->where('tupu_item.is_show !=',2);
			}else {
				$this->db->where('tupu_item.is_show',$conditions['is_show']);
			}
		}
		if (isset($conditions['is_del'])) {
			$this->db->where('tupu_share.is_del',$conditions['is_del']);
		}else{
			$this->db->where('tupu_share.is_del',0);
		}
		if(isset($conditions['album_id'])){
			$this->db->where('tupu_share.album_id',$conditions['album_id']);
		}
		if(isset($conditions['in_public_page'])){
			$this->db->where('tupu_share.total_comments >',0);
			$this->db->where('tupu_share.total_likes >',0);
			//$this->db->where('tupu_share.total_forwarding >',0);
		}
		//跟据分类英文名查找
		if(isset($conditions['category_name_en'])){
			$this->db->join('tupu_category','tupu_album.category_id = tupu_category.category_id','left');
			$this->db->where('tupu_category.category_name_en',$conditions['category_name_en']);
		}
		//查找所有商品
		if(isset($conditions['shopping'])){
			$this->db->where('tupu_item.price >',0);
		}

		//时间范围
		if(isset($conditions['timeline'])){
			$this->db->where('tupu_share.create_time >=',$conditions['timeline']['start']);
		}
		
		//最新发表
		if(isset($conditions['lastest'])){
			$this->db->order_by("share_id", "desc");
		}
		
		//我发的宝贝
		if(isset($conditions['my_post_user_id'])){
			$this->db->where('tupu_item.user_id',$conditions['my_post_user_id']);
			$this->db->where('tupu_share.poster_id',$conditions['my_post_user_id']);
		}
		//我发的+我转发的
		if(isset($conditions['poster_id'])){
			$this->db->where('tupu_share.poster_id',$conditions['poster_id']);
		}

		//我的timeline
		if(isset($conditions['timeline_by_id'])){
			$this->db->join('tupu_follow','tupu_share.poster_id = tupu_follow.friend_id','inner');
			$this->db->where('tupu_follow.user_id',$conditions['timeline_by_id']);
		}

		if(isset($conditions['order_by'])){
			$this->db->order_by($conditions['order_by']);
		}else {
			$this->db->order_by("share_id", "desc");
		}
	}

	function fetch_shares_with_item($start=0,$num=20,$conditions = array())
	{
		$conditions['is_show'] = true;
		$this->db->select('*');
		$this->db->from('tupu_share');
		$this->db->join('tupu_item','tupu_item.item_id = tupu_share.item_id','left');
		$this->db->join('tupu_album','tupu_share.album_id =tupu_album.album_id','left');
		$this->init_search_condition($conditions);
		$this->db->limit($num,$start);
		return $this->db->get()->result();
	}

	function fetch_shares_with_item_rand($num){
	
		$conditions['is_show'] = true;
		$this->db->select('*');
		$this->db->from('tupu_share');
		$this->db->join('tupu_item','tupu_item.item_id = tupu_share.item_id','left');
		$this->db->join('tupu_album','tupu_share.album_id =tupu_album.album_id','left');
		$this->db->order_by('tupu_share.share_id','random');
		$this->db->limit($num);
		return $this->db->get()->result();
		
	}
	function count_shares_with_item($conditions = array())
	{
		$conditions['is_show'] = true;
		$this->db->select('COUNT(*) AS total');
		$this->db->from('tupu_share');
		$this->db->join('tupu_item','tupu_item.item_id = tupu_share.item_id','left');
		$this->init_search_condition($conditions);
		return $this->db->get()->row()->total;
	}
	
	function count_album_shares($album_id){
		$this->db->select('COUNT(*) AS total');
		$this->db->from('tupu_share');
		
		$this -> db -> where(array('album_id' => $album_id , 'is_del' => 0));
		
		return $this->db->get()->row()->total;
	}
	
	function add_like($share_id)
	{
		
		$this->db->set('total_likes', 'total_likes+1', FALSE);
		return $this->db->where('share_id',$share_id)->update('tupu_share');
	}
	
	function remove_like($share_id)
	{
		
		$this->db->set('total_likes', 'total_likes-1', FALSE);
		return $this->db->where('share_id',$share_id)->update('tupu_share');
	}
	/**
	 * 减去一条评论
	 *
	 * @param unknown_type $share_id
	 * @return unknown
	 */
	function remove_comment($share_id)
	{
		
		$this->db->set('total_comments', 'total_comments-1', FALSE);
		return $this->db->where('share_id',$share_id)->update('tupu_share');
	}
	function add_forwarding_times($share_id)
	{
		$this->db->set('total_forwarding', 'total_forwarding+1', FALSE);
		return $this->db->where('share_id',$share_id)->update('tupu_share');
	}

	function get_shares()
	{
		return $this->db->get('tupu_share')->order_by("share_id", "desc")->result();
	}

	function get_share_with_item_by_id($share_id)
	{
		$this->db->select('*');
		$this->db->from('tupu_share');
		$this->db->join('tupu_item','tupu_item.item_id = tupu_share.item_id','left');
		//$this->db->join('tupu_user','tupu_user.user_id = tupu_share.poster_id','left');
		
		$this->db->where('tupu_share.share_id',$share_id);
		$data = $this->db->get()->row();
		$category_id  = $this->getshare_categoryid_by_albumid($data->album_id);//share 所属分类id
		$has_pre = $this->has_pre_share($category_id,$data->share_id);
		$has_next =$this->has_next_share($category_id,$data->share_id);
		@$data->has_pre = $has_pre;
		@$data->has_next = $has_next;
		return $data;
	}

	//获得share的category_id通过相册id
	function getshare_categoryid_by_albumid($album_id){
		$category_id =0;
		$result = null;
			if (!empty($album_id)) {
				$result  = $this->db->select("category_id")->from("tupu_album")->where('album_id',$album_id)->get()->row();
				if ($result) {
					$category_id = $result->category_id;
				}
			}
			return $category_id;	
	}

	//是否有上一个share
	function has_pre_share($category_id,$share_id){

			$cur_share_id =$share_id;
			$pre_share_id =0;
			$row = null;
			if (!empty($category_id)) {
				$row = $this->db->select("tupu_share.share_id")->from('tupu_share')->join('tupu_album','tupu_share.album_id = tupu_album.album_id','left')->where('tupu_album.category_id',$category_id)->where('tupu_share.share_id <',$cur_share_id)->order_by('tupu_share.share_id','desc')->get()->row();
			}
			
			$pre_share_id =$row->share_id;
			return $pre_share_id;
	}

	//是否有上下一个share
	function has_next_share($category_id,$share_id){

			$cur_share_id =$share_id;
			$pre_share_id =0;
			$row = null;
			if (!empty($category_id)) {
				$row = $this->db->select("tupu_share.share_id")->from('tupu_share')->join('tupu_album','tupu_share.album_id = tupu_album.album_id','left')->where('tupu_album.category_id',$category_id)->where('tupu_share.share_id >',$cur_share_id)->order_by('tupu_share.share_id','asc')->get()->row();
			}
			
			$pre_share_id =$row->share_id;
			return $pre_share_id;
	}
	function get_share_by_id($share_id)
	{
		return $this->db->where('share_id',$share_id)->get('tupu_share')->row();
	}

	function add_share($data)
	{
		//poster_id
		$add_share_result = $this->db->insert('tupu_share',$data);
		$share_id = $this -> db -> insert_id();
		//var_dump($share_id);exit;
		$this->load->model('album_model');
		//$update_cover_result = $this->album_model->update_album_cover($data['album_id']);
		$this->album_model->update_album_total_share($data['album_id']);
		
		
		//更新相册的更新时间
		$this -> album_model -> update_update_time($data['album_id'] , time());
		$this->load->model('user_model');
		$this -> user_model -> update_total_shares($data['poster_id']);//在user表total_shares + 1
		return intval($share_id);
	}

	function edit_share($share_id,$data)
	{
		//file_put_contents("te.txt",var_export($data,true));
		return $this->db->where('share_id',$share_id)->update('tupu_share',$data);
	}
	
	function move_to_default_album($album_id , $user_id){
		$this -> load -> model('album_model');
		$default = $this -> album_model -> get_user_default($user_id);
		//var_dump($album_id);exit;
		if (!$default) {
			return false;
		}	
		$this->db->where('album_id',$album_id);
		$this->db->where('poster_id',$user_id);
		$update = $this->db->update('tupu_share',array('album_id' => $default -> album_id));
		return $update;
	}
	
	function batch_update_share_album($old_album_id,$new_album_id)
	{
		return $this->db->where('album_id',$old_album_id)->update('tupu_share',array('album_id'=>$new_album_id));
	}
	/**
	 * 删除item下的分享
	 *
	 * @param unknown_type $item_id
	 * @return unknown
	 */
	function del_share_by_item($item_id)
	{
		//先获取item下分享列表
		
		$this->db->where('item_id',$item_id)->delete('tupu_share');
		
		$this->load->model('user_model');
		$this -> user_model -> update_total_shares($data['poster_id']);//在user表total_shares + 1
		return true;
	}
	//获取用户的一个分享
	function get_share_by_share_id_and_user_id($share_id , $u_id = 0)
	{
		$this->db->where('share_id',$share_id);
		if ($u_id != 0) {
			$this->db->where('poster_id',$u_id);
		}
		$share = $this->db->get('tupu_share')->row();
		if (!$share) {
			return false;
		}
		return $share;
	}
	//删除分享
	function del_share($share_id , $u_id = 0)
	{
		$this->db->where('share_id',$share_id);
		if ($u_id != 0) {
			$this->db->where('poster_id',$u_id);
		}
		$share = $this->db->get('tupu_share')->row();
		if (!$share) {
			return 'no_data';
		}
		$this -> load -> model('favorite_share_model');
		$this -> favorite_share_model -> del_favorite_share($share_id);
		
		if ($share -> poster_id != $share -> user_id) {//如果是转发的，删除转发记录			
			$delete_result =  $this->db->where('share_id',$share_id)->delete('tupu_share');
			$this -> load -> model('album_model');
			$this -> album_model -> update_album_total_share($share -> album_id);
		} else {//如果原创人删除
			$delete_result =  $this ->db -> where('item_id',$share -> item_id) -> delete('tupu_share');
			//
			$this -> load -> model('item_model');
			$this -> item_model ->  del_item($share -> item_id);
		}
		return 'del_ok';
	}
	
	function del_shares_by_item($item_id){
		return $this ->db -> where('item_id',$item_id) -> delete('tupu_share');
	}
	
	//获取相册里最新的share
	function get_shares_by_album_id($album_id , $limit = 6 ,  $field = ""){
		if ($field == '') {
			$field = "tupu_share.share_id , tupu_item.title , tupu_item.intro , tupu_item.image_path";
		}
		$conditions['album_id'] = $album_id;
		$conditions['is_show'] = 1;
		$this->db->select($field);
		$this->db->from('tupu_share');
		$this->db->join('tupu_item','tupu_item.item_id = tupu_share.item_id','left');
		$this->init_search_condition($conditions);		
		$this->db->order_by('tupu_share.create_time desc');
		$this->db->limit($limit);
		$results = $this->db->get()->result();
		return $results;
	}
	//分页获取相册里的分享
	public function get_shares_page_by_album_id($album_id , $start = 0 , $row_num = 10 , $field = ""){
		if ($field == '') {
			//$field = "tupu_share.share_id , tupu_item.title , tupu_item.intro , tupu_item.image_path";
			$field = "*";
		}
		$conditions['album_id'] = $album_id;
		$conditions['is_show'] = 1;
		$this->db->select($field);
		$this->db->from('tupu_share');
		$this->db->join('tupu_item','tupu_item.item_id = tupu_share.item_id','left');
		$this->db->join('tupu_album','tupu_share.album_id =tupu_album.album_id','left');
		$this->init_search_condition($conditions);
		//$this->db->where('tupu_share.album_id',$album_id);		
		$this->db->order_by('tupu_share.create_time desc');
		$this->db->limit($row_num , $start);
		$results = $this->db->get()->result();
		return $results;
	}
	
	//获得所有分类下的最新分享
	public function get_top_category_share(){
			$categorys = array();
			$share = array();
			$this->load->model("category_model");
			$categorys = $this->category_model->get_categories();
			$fields = "tupu_item.image_path";
			if (is_array($categorys)) {
				foreach ($categorys as $key => $cate_obj){
					$temp_share = $this->db->select($fields)->from("tupu_share")
								->join("tupu_item",'tupu_item.item_id = tupu_share.item_id','left')
								->join("tupu_album",'tupu_album.album_id = tupu_share.album_id','left')
								->where("tupu_album.category_id = ",$cate_obj->category_id)
								->order_by("tupu_share.create_time desc")
								->limit(1)->get()->row();
					if($temp_share -> image_path){
						$share[$key]['category_id'] = $cate_obj -> category_id;
						$share[$key]['category_name_cn'] = $cate_obj -> category_name_cn;
						$share[$key]['category_name_en'] = $cate_obj -> category_name_en;
						$share[$key]['image'] = get_item_first_image($temp_share -> image_path);
					}
				}
			}
			return $share;
	}
	
	/**
	 * 增加普通链接点击数
	 *
	 * @param int $share_id 分享id
	 */
	public function add_normal_click($share_id){
		if (!empty($share_id)) {
			return $this->db->where("share_id",$share_id)->set('total_click','total_click + 1',false)->update('tupu_share');
		}
		return false;
	}
	
	/**
	 * 增加淘宝链接点击数
	 *
	 * @param int $share_id 分享id
	 */
	public function add_taobao_click($share_id){
		if (!empty($share_id)) {
			return $this->db->where("share_id",$share_id)->set('total_click_taobao','total_click_taobao + 1',false)->update('tupu_share');
		}
		return false;
		
	}
	
	function count_shares_by_cate($cate_id , $from = 0){
		$this->db->select('COUNT(*) AS total');
		$this->db->from('tupu_share');
		$this->db->join('tupu_album','tupu_share.album_id = tupu_album.album_id','left');
		$this->db->where('tupu_album.category_id',$cate_id);
		$this->db->where('tupu_album.is_show !=',2);
		if ($from != 0) {
			$time = strtotime("-{$from} day");
			$date = date('Y-m-d H:i:s' , $time);
			$this->db->where('tupu_share.create_time > ',$date);
		}
		return $this->db->get()->row()->total;
	}

	/**
	 * 统计全站所有图片数量
	 *
	 */
	function count_total_share(){
		$count = $this->db->where("share_id > ",0)->count_all_results('tupu_share');
		return $count;
	}
	/**
	 * 获取用户的分享数
	 *
	 * @param int $u_id
	 * @return int
	 */
	function count_total_share_by_uid($u_id){
		
		$this->db->select('COUNT(*) AS total');
		$this->db->from('tupu_share');
		$this->db->join('tupu_album','tupu_share.album_id = tupu_album.album_id','left');
		$this->db->where('tupu_album.is_show !=',2);
		$this->db->where('tupu_share.is_del',0);
		$this -> db -> where('tupu_share.poster_id' , $u_id);
		
		if ($from != 0) {
			$time = strtotime("-{$from} day");
			$date = date('Y-m-d H:i:s' , $time);
			$this->db->where('tupu_share.create_time > ',$date);
		}
		return $this->db->get()->row()->total;
	}
	
	/**
	 * 商品的总点击数
	 *
	 */
	function count_share_total_click(){
		$total_clicks = array();
		$total_click_arr = $this->db->select_sum("total_click")->where('is_del = 0')->get('tupu_share')->result();
		$total_click_taobao_arr = $this->db->select_sum("total_click_taobao")->where('is_del = 0')->get('tupu_share')->result();
		$total_clicks['total_click'] = @$total_click_arr[0]->total_click?$total_click_arr[0]->total_click:0;
		$total_clicks['total_click_taobao'] = @$total_click_taobao_arr[0]->total_click_taobao?$total_click_taobao_arr[0]->total_click_taobao:0;
		return $total_clicks;
	}
}