<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Album_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
	}

	function create_default_album($uid , $name = ''){
		$this->load->model('category_model');
		$default_category = $this->category_model->get_default_category();
		if ($name == '') {
			$album_data['title'] = '默认专辑';
		}
		else{
			$album_data['title'] = $name.'的专辑';
		}
		
		$album_data['user_id'] = $uid;
		$album_data['cover'] = 'data/images/album_bg.jpg';
		$album_data['is_system'] = 1;
		$album_data['category_id'] = $default_category->category_id;
		return $this->add_album($album_data);
	}
	
	function get_album_info($album_id , $field = ''){
		if ($field == '') {
			$field = '*';
		}
		$this->db->select($field);
		$this->db->join('tupu_user','tupu_album.user_id = tupu_user.user_id','left');
		$condition['album_id'] = $album_id;
		$this -> init_search_condition($condition);
		$album = $this->db->get('tupu_album')->row();
		return $album;
	}

	function get_user_default_album($uid){
		
		$this->db->where('is_system',1);
		$condition['user_id'] = $uid;
		$this -> init_search_condition($condition);
		
		return $this->db->get('tupu_album')->row();
	}
	//获取用户的一个相册
	function get_one_album_by_uid($album_id , $user_id = 0){
		if ($user_id != 0) {
			$this->db->where('user_id',$user_id);
		}
		$this->db->where('album_id',$album_id);
		return $this->db->get('tupu_album')->row();
	}

	function update_album_cover($album_id){
		$conditions = array();
		$conditions['album_id'] = $album_id;
		$this->load->model('share_model');

		$share_number = $this->share_model->count_shares_with_item($conditions);
		//if($share_number>9)
		//	return true;
		$date_dir = 'data/attachments/'.date("Y/m/d/");
		(!is_dir(FCPATH.$date_dir))&&@mkdir(FCPATH.$date_dir,0777,true);
		$file_name = $album_id.'_album';
		$dest_file_path = FCPATH.$date_dir.$file_name.'.jpg';
		@copy(FCPATH.'data/images/album_bg.jpg', $dest_file_path);
		$this->load->library('tupu_image_lib');

		$shares = $this->share_model->fetch_shares_with_item(0,9,$conditions);
		$i = 0;
		foreach ($shares as $share) {
			if($i%3==0){
				$x_offset = 0;
			}else{
				$x_offset = 7;
			}
				
			$x = ($i%3)*(62+$x_offset);
			$y = (floor($i/3))*69;
			$this->tupu_image_lib->combin_image($x, $y, $dest_file_path,FCPATH.$share->image_path.'_square.jpg');
			$i++;
		}

		$data['cover'] = $date_dir.$file_name.'.jpg';
		return $this->edit_album($album_id, $data);
	}

	function get_user_albums($uid,$num=0 , $start = 0 , $shares = 6)
	{

		$condition['user_id'] = $uid;
		$this -> init_search_condition($condition);
		

		$this->db->order_by("album_id", "desc");
		if($num){
			$this->db->limit($num,0);
		}
		if ($start != 0) {
			$this->db->limit($num,$start);
		}
		$albums = $this->db->get('tupu_album')->result();
		if ($shares > 0) {
			if (is_array($albums)) {
				//var_dump($albums);exit;
				$this -> load -> model('share_model');
				foreach ($albums as $k => $album){
					//获取相册最新的6个分享
					$album_shares = $this -> share_model -> get_shares_by_album_id($album -> album_id , $shares);
					$albums[$k] -> shares = $album_shares;
				}
			}
		}
		//var_dump($albums);exit;
		return	$albums;
	}
	/**
	 * @todo 抓取远程图片
	 *
	 * @param string $url 远程图片地址
	 * @return array
	 */
	public function save_remote_image($url)
	{
		if(function_exists('curl_init')){
		    $curl = curl_init($url);
		    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		    $content =  curl_exec($curl);
		    curl_close($curl);
		}else{
			$content = @file_get_contents($url);
		}

		$date_dir = 'data/attachments/'.date("Y/m/d/");
		(!is_dir(FCPATH.$date_dir))&&@mkdir(FCPATH.$date_dir,0777,true);
		$file_name = uniqid().'';
		$file_path = FCPATH.$date_dir.$file_name.'.jpg';
		if(!empty($content) && @file_put_contents($file_path,$content) > 0)
		{
			$this->load->library('tupu_image_lib');
			$this->tupu_image_lib->create_thumb($file_path, 'large', 600);
			$this->tupu_image_lib->create_thumb($file_path, 'middle', 200);
			$this->tupu_image_lib->create_thumb($file_path, 'small', 150);
			$this->tupu_image_lib->crop_square($file_path, 80);
			$image_data = array();
			//数据库中不加扩展名,读的时候再加.jpg,_middle.jpg,_small.jpg
			$image_data['orgin'] = $date_dir.$file_name;
			$image_data['middle'] = $date_dir.$file_name;
			$image_data['small'] = $date_dir.$file_name;
		}
		return $image_data;
	}
	
	private function init_search_condition($conditions){

		if(isset($conditions['user_id'])){
			$this->db->where('tupu_album.user_id',$conditions['user_id']);
		}
		if (isset($conditions['category_id'])) {
			$this->db->where('tupu_album.category_id',$conditions['category_id']);
		}

		if(isset($conditions['album_id'])){
			$this->db->where('tupu_album.album_id',$conditions['album_id']);
		}
		if (isset($conditions['keyword'])) {
			$this->db->like('title',$conditions['keyword']);
		}
		if(isset($conditions['total_share'])){
			$this->db->where('tupu_album.total_share >',0);
		}
		if (isset($conditions['is_show'])) {
				if ($conditions['is_show']==2) {
					$this->db->where('tupu_album.is_show != ',$conditions['is_show']);
				}else{
					$this->db->where('tupu_album.is_show',$conditions['is_show']);
				}
		}else{
			$this->db->where('tupu_album.is_show != ' , 2);
		}
		if(isset($conditions['order_by'])){
			$this->db->order_by($conditions['order_by']);
		}else {
			$this->db->order_by("album_id", "desc");
		}
	}
	//获取用户默认的专辑
	function get_user_default($user_id){
		$this -> db -> where('user_id',$user_id);
		$this -> db -> where('is_system',1);
		$default = $this -> db -> get('tupu_album') -> row();
		return $default;
	}
	function get_album_by_id($id = 0)
	{
		return $this->db->where('album_id',$id)->get('tupu_album')->row();
	}

	function get_albums($start=0,$num=20,$conditions = array())
	{
		$this->db->select('*');
		$this->db->from('tupu_album');
		$this->db->join('tupu_user','tupu_user.user_id = tupu_album.user_id','left');
		$this->init_search_condition($conditions);
		$this->db->limit($num,$start);
		
		$albums = $this->db->get()->result();
		//var_dump($this-> db -> last_query());exit;	
		if (is_array($albums)) {
			$this -> load -> model('share_model');
			foreach ($albums as $k => $album){
				//获取相册最新的6个分享
				$album_shares = $this -> share_model -> get_shares_by_album_id($album -> album_id);
				$albums[$k] -> shares = $album_shares;
			}
		}
		return $albums;
	}

	function add_album_total_share($album_id)
	{
		$this->db->set('total_share', 'total_share+1', FALSE);
		return $this->db->where('album_id',$album_id)->update('tupu_album');
	}

	function update_album_total_share($album_id){
		$conditions = array();
		$conditions['album_id'] = $album_id;
		$this->load->model('share_model');
		$share_number = $this->share_model->count_shares_with_item($conditions);
		$data['total_share'] = $share_number;
		return $this->edit_album($album_id, $data);
	}
	//更新相册的更新时间
	function update_update_time($album_id , $time){
		//var_dump($album_id);exit;
		$data = array('update_time' => $time);
		$this->db->where('album_id', $album_id);
		return $this->db->update('tupu_album', $data); 
	}
	//更新相册的喜欢次数
	function update_total_favorite($album_id , $methon = 'add' , $step = 1){
		if ($methon == 'add') {
			$this->db->set('total_favorite', 'total_favorite+'.$step, FALSE);
		}else {
			$this->db->set('total_favorite', 'total_favorite-'.$step, FALSE);
		}
		
		return $this->db->where('album_id',$album_id)->update('tupu_album');
	}

	
	function move_share_to_default($album_id,$uid){

		$default_album = $this->get_user_default_album($uid);
		if($default_album){
			$this->load->model('share_model');
			$this->share_model->batch_update_share_album($album_id,$default_album->album_id);
			$this->update_album_cover($default_album->album_id);
			return true;
		}else {
			return false;
		}

	}

	function add_album($data)
	{
		$data['cover'] = 'data/images/album_bg.jpg';
		
		 if($this->db->insert('tupu_album',$data))
		 return $this->db->insert_id();
		 return false;  
	}

	function edit_album($album_id,$data)
	{
		$data['update_time'] = time();
		return $this->db->where('album_id',$album_id)->update('tupu_album',$data);
	}
	/**
	 * @todo 屏蔽专辑操作
	 *
	 * @param int $type 1审核通过 2 屏蔽
	 * @param array $ids  album_ids 
 	 * @return bool
	 */
	function verify_album($type=1,$ids=''){
		//return $this->db->query("update tupu_album set is_show=".$type." where album_id in (".$ids.")");
		$ids = explode(',',$ids);
		if (!is_array($ids)) {
			$ids=array($ids);
		}
		$set = array('is_show'=>$type);
		return $this->db->where_in('album_id',$ids)->update("tupu_album",$set);

	}
	function del_album($album_id)
	{
		$this->db->where('album_id',$album_id);
		$this->db->where('is_system',0);
		if($this->db->delete('tupu_album')){
			$this->load->model('favorite_album_model');
			$this->favorite_album_model->del_all_favorite_album($album_id);
			return true;
		}
		return false;
	}
	//用户删除相册
	function del_album_by_user($album_id , $user_id = 0){
		if ($user_id == 0) {//管理员操作
			$this->db->select('user_id');
			$this->db->where('album_id',$album_id);
			$album = $this -> db -> get('tupu_album') -> row();
			if (!$album) {
				return false;
			}
			$user_id = $album -> user_id;
		}
		$this -> load -> model('share_model');
		$return = $this -> share_model -> move_to_default_album($album_id , $user_id);
		if (!$return) {
			return false;
		}
		//var_dump($user_id);exit;
		$this->db->where('album_id',$album_id);
		$this->db->where('user_id',$user_id);
		$this->db->where('is_system',0);
		$return = $this->db->delete('tupu_album');
		if ($return) {
			return 'del_ok';
		}
		return false;
	}
	function count_albums($condition=array('album_id >'=>0)){
		if ($condition['keyword']) {
			$this->db->like('title',$condition['keyword']);
			unset($condition['keyword']);
		}
		return $this->db->where($condition)->count_all_results('tupu_album');
	}
	
	function set_top_album($album_id){
		$set = array('top'=>time());
		return $this->db->where('album_id',$album_id)->update("tupu_album",$set);
	}
	
	function get_albums_by_cate($cate_id , $limit = 4){
		
		$conditions = array('category_id' => $cate_id , 'order_by' => 'top desc , total_share desc');
		
		$this->db->select('*');
		$this->db->from('tupu_album');
		$this -> db -> where(array('tupu_album.total_share >' => 0));
		$this->init_search_condition($conditions);
		$this->db->limit($limit);
		
		$albums = $this->db->get()->result();
		//var_dump($this -> db -> last_query());exit;
		if (is_array($albums)) {
			$this -> load -> model('share_model');
			foreach ($albums as $k => $album){
				//获取相册最新的4个分享
				$album_shares = $this -> share_model -> get_shares_by_album_id($album -> album_id , 4);
				$albums[$k] -> shares = $album_shares;
				//获取全部分享
				$albums[$k] -> total_shares = $this -> share_model -> count_album_shares($album -> album_id);
			}
		}
		
		return $albums;
		
	}
	
	/**
	 * 通过分类id获取用户相册
	 *
	 * @param int $cate_id
	 * @param int $user_id
	 * @param int $limit
	 * @return array
	 */
	function get_user_albums_by_cate($cate_id ,$user_id, $limit = 4){
		
		$conditions = array('category_id' => $cate_id , 'user_id' => $user_id,'order_by' => 'top desc , total_share desc');
		
		$this->db->select('*');
		$this->db->from('tupu_album');
		$this->init_search_condition($conditions);
		$this->db->limit($limit);
		
		$albums = $this->db->get()->result();
		return $albums;
	}

}