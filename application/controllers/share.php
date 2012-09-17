<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * AiTuPu
 *
 * An open source social sharing platform
 *
 * @package		AiTuPu
 * @author		Duobianxing Studio Dev Team
 * @copyright	Copyright © 2011 - 2012, Duobianxing, Inc.
 * @license		http://duobianxing.com/doc/license.html
 * @link		http://duobianxing.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------
/**
 * AiTuPu Share Controller
 *
 *
 * @package		AiTuPu
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Duobianxing Studio Dev Team
 * @link		http://duobianxing.com/doc/index.html
 */
class Share extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('segment');
	}

/**
 * to jump solution
 *
 */
  public function jump(){
		$this->load->model("item_model");
		$item_id = intval($this->uri->segment(3));//url
		if ($item_id) {
			$item = $this->item_model->get_item_by_id($item_id);
			if ($item->promotion_url) {
				$url = str_ireplace('+', '%2B', $item->promotion_url);
				redirect($url);
			}else{
				show_error('请求的链接地址不能识别',500,"非法请求！");
			    exit;
			}
		}else{
			show_error('ID 格式不正确',500,"非法请求！");
			exit;
		}
}

	/**
	 * 分享的图谱详情页
	 *
	 */
	public function view(){
		$share_id = $this->uri->segment(3);
		$perpage =5;
		$relation = 0;//关注关系 默认0 无任何关系
		$comments = $album = $items = $liked_items = array();
  		$this->load->library('table');
  		$this->load->model("comment_model");
  		$this->load->model("album_model");
  		$this->load->model("user_model");
  		$page = intval($this->input->get('page',true)) >=1 ? $this->input->get('page',true):1;
		$col_array = $this->table->make_columns($image_array, 8);  
   		$this->load->library('pagination');
		if($share_id){
			$this->load->model('share_model');
			$this->share_model->add_normal_click($share_id);
			$data['share'] = $this->share_model->get_share_with_item_by_id($share_id);
			$user = $this->user_model->get_user_by_uid($data['share']->poster_id);
			$data['user']=$user;
			//var_dump($data['user']);exit;
			$poster_user_id = $data['share']->poster_id;
			if($this->data['sess_userinfo']['uid'])
			$curren_uid = $this->data['sess_userinfo']['uid'];
			if ($curren_uid) {
				$this->load->model('follow_model');
				$relation = $this->follow_model->get_relation($curren_uid,$poster_user_id);
				$data['relation'] = $relation;
			}
			$album_id = $data['share']->album_id ? $data['share']->album_id:null; 
			if ($album_id) {
				$data['current_share_album'] = $this->album_model->get_album_by_id($album_id);
				
				$conditions['album_id'] = $album_id;
				$items  = $this->share_model->fetch_shares_with_item(0,6,$conditions);
				$data['items'] = $items;//同一个专辑下的图谱
			}
			$liked_items = $this->share_model->fetch_shares_with_item_rand(9);//九宫格
			$data['liked_items'] = $liked_items;//可能喜欢的
			$this->load->model('follow_model');
			$data['friend_relation'] = $this->follow_model->get_relation($this->data['sess_userinfo']['uid'],$data['share']->poster_id);
			//var_dump($data['share']);exit;
			//seo设置
			//var_dump($data['share_type']);
			$share_type = $data['share']->share_type == 'channel' ? $data['share']->reference_channel :($data['share']->share_type == 'images' ? '用户分享' :'用户上传');
			$data['from_type'] = $share_type;
			//var_dump($data['share']);
		}
		$count_total_comments = $this->comment_model->count_comments(array('share_id'=>$share_id,'is_show < '=>2));
		$offset = ($page -1) * $perpage;
		$config['per_page'] = $perpage;
		$config['total_rows'] = $count_total_comments;
		$config['base_url'] = site_url('share/view/'.$share_id.'/?');
		$config['use_page_numbers'] = TRUE;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] = '<p class="pagination">';
		$config['cur_tag_open'] = '<a style="background:#eee">';
		$config['cur_tag_close'] = '</a>';
		$config['full_tag_close'] = '</p>';
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$this->pagination->initialize($config);
		$pages = $this->pagination->create_links();
		$data['pages'] = $pages;
		$comments = $this->comment_model->get_comments($offset,$perpage,array('share_id'=>$share_id,'is_show < '=>2));//获得评论
		$data['comments'] = $comments;
		$data['page_js']=array(
	   		base_url('assets/js/tupu.common.js'),
	   		base_url('assets/js/dialog/artDialog.js'),
	   		base_url('assets/js/tupu.action.js'),
	   		base_url('assets/js/face/jquery.qqFace.min.js'),
   		);
   		$data['page_css']=array(
   		base_url('assets/js/face/qqFace.css'),
   		);
   		$data['seo_set']['seo_title'] = strip_tags($data['share'] -> intro);
		$data['seo_set']['seo_keywords'] = strip_tags($data['share'] -> intro);
		$data['seo_set']['seo_description'] = strip_tags($data['share'] -> intro);
		//var_dump($data['share']);exit;
		$this->output("common/layout", array('body'=>'share/index'),$data);
	}
	
	/**
	 * 用户评论功能
	 *
	 */
	public function add_comment(){
		
		/*Header("Cache-Control","no-store");
		Header("Pragma","no-cache");
		Header("Expires", "0");
		*/
		$this->ajax_check_login();
		if(!$this->is_xmlHttp_request())//防跳墙
		die('Access Deny!');
		//PHP处理函数
		$comment = replace_badword($this->input->post('comment',true));
		$share_id = $this->input->post('share_id',true);
		if (!$comment||!$share_id) {
			$response = array('result' => false, 'msg' => "评论失败");
			echo json_encode($response);
			exit;
		}
		$this->load->model('user_model');
		if ($is_forbidden=$this->user_model->check_forbidden()) {
			echo json_encode(array('forbid'=>true));//检查禁言状态
			exit();
		}
		$this->load->model('share_model');
		$share = $this->share_model->get_share_by_id($share_id);
		if($share->comments){
			$commnets = unserialize($share->comments);
		}else{
			$commnets = array();
		}
		$new_comment['poster_uid'] = $this->data['sess_userinfo']['uid'];
		$new_comment['poster_nickname'] = $this->data['sess_userinfo']['nickname'];
		$new_comment['poster_avatar'] = $this->data['sess_userinfo']['avatar_local'];
		$new_comment['comment'] = $comment;
		$new_comment['post_time'] = time();//当前时间
		$new_comment['share_id']=$share_id;
		$this->load->model("comment_model");
		$count=0;
		$last_comment_id =0;
		if ($last_comment_id=$this->comment_model->add_comment($new_comment)) {
			$count=$this->comment_model->count_comments(array('share_id'=>$share_id));
			$comments=serialize($this->comment_model->get_comments(0,5,array('share_id'=>$share_id,'is_show !='=>2)));
		}	
		$result = $this->share_model->edit_share($share_id,array('total_comments'=>$count,'comments'=>$comments));
		if ($result) {
		log_message('error','ok');
			$response = array('result' => true, 'msg' => "评论成功",'comment_id'=>$last_comment_id, 'data' =>ubbReplace($comment));
			echo json_encode($response);
		}else{
		log_message('error','faild');
			$response = array('result' => false, 'msg' => "评论失败");
			echo json_encode($response);
		}
		exit;
		
	}
	/**
	 * 判断是否是ajax合法请求
	 *
	 * @return boolean true||false
	 */
	public function is_xmlHttp_request(){
		return $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
	}
	
	/**
	 * 喜欢操作
	 * **/
	public function add_like(){
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pramga: no-cache");

		//echo "dfsdfsf";exit;
		//var_dump($this->ajax_check_login());exit;
		$this->ajax_check_login();
		$share_id = $this->input->get('share_id',true);
		$this->load->model('share_model');
		$result = $this->share_model->get_share_by_id($share_id);
		if($result->poster_id == $this->data['sess_userinfo']['uid']){
			$response = array('result' => false, 'msg' => "like_self");
			echo json_encode($response);
			return;
		}
		$this->load->model('favorite_share_model');
		$result = $this->favorite_share_model->add_favorite_share($share_id,$this->data['sess_userinfo']['uid']);
		if ($result) {//如果没喜欢过，喜欢加1
			$addlike_result = $this->share_model->add_like($share_id);
			$response = array('result' => 'add', 'msg' => "success");
		}else {//喜欢过了，移除喜欢，喜欢-1
			$this -> favorite_share_model -> del_favorite_share($share_id,$this->data['sess_userinfo']['uid']);
			$del_result = $this->share_model->remove_like($share_id);
			$response = array('result' => 'remove', 'msg' => "success");
		}
		echo json_encode($response);

	}
	/**
	 * 转发页面
	 * 转发提交
	 * */
	public function forwarding_share(){
		$this->ajax_check_login('txt');
		
		$share_id = $this->input->post('share_id',true);
		$this->load->model('share_model');
		$share = $this->share_model->get_share_by_id($share_id);
		if($share){
			if($share->poster_id == $this->data['sess_userinfo']['uid']){
				echo "share_self";
				return;
			}
			if ($this -> input -> post('action') == 'save') {//处理提交
				$share_data['album_id'] = $this -> input -> post('album_id');
				$share_data['item_id'] = $share->item_id;
				$share_data['poster_id'] = $this->data['sess_userinfo']['uid'];
				$share_data['poster_nickname'] = $this->data['sess_userinfo']['nickname'];
				$share_data['original_id'] = $share_id;
				$share_data['user_id'] = $share->user_id;
				$share_data['user_nickname'] = $share->user_nickname;
				$share_data['total_comments'] = 0;
				$share_data['total_likes'] = 0;
				$share_data['total_forwarding'] = 0;
				$this->share_model->add_forwarding_times($share_id);
				$result = $this->share_model->add_share($share_data);
				if ($result) {
					echo $result;
				}else{
					echo 0;
				}
				exit;
			}
		}else{
			echo "failed";
			return;
		}
		//获取用户的albums
		$uid = $this->data['sess_userinfo']['uid'];
		$this->load->model('album_model');
		$albums = $this -> album_model -> get_user_albums($uid);
		///var_dump($albums);exit;
		$data = array(
			'share_id' => $share_id,
			'albums'   => $albums,
			'theme_url' => $this->data['theme_url'],
		);
		$this->load->view('common/share_box.php', $data);
	}
	
	
	//保存分享的内容
	public function ajax_save_share()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pramga: no-cache");

		$this->ajax_check_login();
		if($this->input->post()&&$this->input->post('share_type',true)){
			
			log_message('error','post ok');
			$this->load->model('item_model');
			$form_type = $this->input->post('share_type',true);
		
			log_message('error','formtype='.$form_type);
			if($form_type=="channel"){
				$item_result = $this->save_share_goods();
				
			}elseif ($form_type=="images"){
			   $item_result = $this->save_share_image();
				
			}elseif ($form_type=="upload"){
				$item_result = $this->save_share_upload();
				
			}
			if($item_result){
				$item_id = $this->db->insert_id();
				$album_id = $this->input->post('album',true);
				$result = $this->create_share_by_item($item_id,$album_id);
			}
			
			if($result){
				$response = array('result' => true, 'msg' => "发布成功，感谢您的分享！");
				echo json_encode($response);
			}else{
				$response = array('result' => false, 'msg' => "failed发布失败，请检查您的输入是否正确");
				echo json_encode($response);
			}
		}else{
			$response = array('result' => false, 'msg' => "forbid非法操作，本操作已被取消");
			echo json_encode($response);
		}
	}
	
	private function validate_share_goods_form(){
		$this->form_validation->set_rules('image_data', '图片' , 'required');
		$this->form_validation->set_rules('share_type', '类型' , 'trim|required|xss_clean');
		$this->form_validation->set_rules('share_price', '宝贝价格' , 'trim|required');
		$this->form_validation->set_rules('intro', '描述' , 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	private function save_share_goods(){
		if(!$this->validate_share_goods_form()){
			return false;
		}
		$front_img = $this->input->post("front_side");//封面图片地址
		$image_data= array();
		$post_urls = $this->input->post("img_urls");
		$total_count_imgs = count($post_urls);
		$post_details = $this->input->post("img_details");
		$post_details  = array_map("strip_tags", $post_details);
		//$image_data = $this->save_remote_image($this->input->post('image_data'));
		/*if(!$image_data){
			return false;
		}
		*/
		if ($total_count_imgs == 1) {
			$img_data = $this->save_remote_image($front_img);
			$image_data[] = $img_data['orgin'];
			$image_data['intro'][] =$post_details[0];
		}else if ($total_count_imgs >1) {
			foreach ($post_urls as $key => $img_url){
				if ($front_img == $img_url) {
					$front_tmps = $this->save_remote_image($img_url);
					$image_data['front_img'] = $front_tmps['orgin'];
					$image_data['intro']['front_intro'] = $post_details[$key] ? $post_details[$key] :'NULL';
					continue;
				}
			$img_urls = $this->save_remote_image($img_url);
			$image_data[] = $img_urls['orgin'];
			$image_data['intro'][] = $post_details[$key] ? $post_details[$key] :'NULL';
			}
		}else{
			return false;
		}
		if(!$image_data){
			return false;
		}
		$data['image_path'] = serialize($image_data);
		//$data['image_path'] = $image_data['orgin'];
		$data['user_id'] = $this->data['sess_userinfo']['uid'];
		$data['image_count'] = $total_count_imgs;
		$data['title'] = strip_tags(replace_badword($this->input->post('share_title',true)));
		$data['intro'] = replace_badword($this->input->post('intro',true));
		$data['price'] = $this->input->post('share_price',true);
		$data['intro_search'] = $this->segment->segment($data['intro']);
		$data['reference_url'] = $this->input->post('orgin_url',true);
		$data['reference_itemid'] = $this->input->post('item_id',true);
		$data['reference_channel'] = $this->input->post('channel',true);
		$data['promotion_url'] = $this->input->post('promotion_url',false);
		$data['share_type'] = 'channel';
		$data['is_show'] = 0;
		return $this->item_model->add_item($data);
	}
	
	private function save_remote_image($url)
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
		$file_name = uniqid('', true).'';
		$file_path = FCPATH.$date_dir.$file_name.'.jpg';
		if(!empty($content) && @file_put_contents($file_path,$content) > 0)
		{
			$this->load->library('tupu_image_lib');
			$this->tupu_image_lib->create_thumb($file_path, 'large', 600);
			$this->tupu_image_lib->create_thumb($file_path, 'middle', 200);
			$this->tupu_image_lib->create_thumb($file_path, 'small', 100);
			$this->tupu_image_lib->crop_square($file_path, 100);
			$image_data = array();
			//数据库中不加扩展名,读的时候再加.jpg,_middle.jpg,_small.jpg
			$image_data['orgin'] = $date_dir.$file_name;
			$image_data['middle'] = $date_dir.$file_name;
			$image_data['small'] = $date_dir.$file_name;
		}
		return $image_data;
	}
	
	private function save_share_image(){
		if(!$this->validate_share_image_form()){
			return false;
		}
		$front_img = $this->input->post("front_side");//封面图片地址
		$image_data= array();
		$post_urls = $this->input->post("img_urls");
		$post_details = $this->input->post("img_details");
		$post_details  = array_map("strip_tags", $post_details);
		$total_count_imgs = count($post_urls);
		if ($total_count_imgs == 1) {
			$img_data = $this->save_remote_image($front_img);
			$image_data[] = $img_data['orgin'];
			$image_data['intro'][] =$post_details[0];
		}else if ($total_count_imgs >1) {
			foreach ($post_urls as $key => $img_url){
				if ($front_img == $img_url) {
					$front_tmps = $this->save_remote_image($img_url);
					$image_data['front_img'] = $front_tmps['orgin'];
					$image_data['intro']['front_intro'] = $post_details[$key] ? $post_details[$key] :'NULL';
					continue;
				}
			$img_urls = $this->save_remote_image($img_url);
			$image_data['intro'][] = $post_details[$key] ? $post_details[$key] :'NULL';
			$image_data[] = $img_urls['orgin'];
			}
		}else{
			return false;
		}
		if(!$image_data){
			return false;
		}
		$data['image_path'] = serialize($image_data);
		$data['image_count'] = $total_count_imgs;
		$data['user_id'] = $this->data['sess_userinfo']['uid'];
		$data['intro'] = $this->input->post('intro',true);
		$data['intro_search'] = $this->segment->segment($data['intro']);
		$data['reference_url'] = $this->input->post('orgin_url',true);
		$data['share_type'] = 'images';
		$data['is_show'] = 0;
		
		return $this->item_model->add_item($data);
	}
	
	private function save_share_upload(){
		if(!$this->validate_share_image_form()){
			return false;
		}
		$front_img = FCPATH.$this->input->post("front_side");//封面图片地址
		$image_data= array();
		$post_urls = $this->input->post("img_urls");
		$post_details = $this->input->post("img_details");
		$post_details  = @array_map("strip_tags", $post_details);
		$total_count_imgs = count($post_urls);
		if ($total_count_imgs == 1) {
			//$img_data = $this->save_local_image(FCPATH.$front_img);
			$image_data[] = $this->save_local_image($front_img);
			
			$image_data['intro'][] =$post_details[0];
		}else if ($total_count_imgs >1) {
			foreach ($post_urls as $key =>$img_url){
				if ($front_img == FCPATH.$img_url) {
					$front_tmps = $this->save_local_image(FCPATH.$img_url);
					$image_data['front_img'] = $front_tmps;
					$image_data['intro']['front_intro'] = $post_details[$key] ? $post_details[$key] :'NULL';
					continue;
				}
			$img_url = $this->save_local_image(FCPATH.$img_url);
			$image_data[] = $img_url;
			$image_data['intro'][] = $post_details[$key] ? $post_details[$key] :'NULL';
			}
		}else{
			return false;
		}
		//$source = FCPATH.$this->input->post('image_data');
		
		$data['image_path'] = serialize($image_data);
		$data['image_count'] = $total_count_imgs;
		$data['user_id'] = $this->data['sess_userinfo']['uid'];
		$data['intro'] = replace_badword($this->input->post('intro',true));
		$data['intro_search'] = $this->segment->segment($data['intro']);
		$data['share_type'] = 'upload';
		$data['is_show'] = 0;
		return $this->item_model->add_item($data);
	}

	private function validate_share_image_form(){
		$this->form_validation->set_rules('img_urls', '图片' , 'required');
		$this->form_validation->set_rules('share_type', '类型' , 'trim|required|xss_clean');
		$this->form_validation->set_rules('intro', '描述' , 'trim|required|xss_clean');
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	private function save_local_image($source){
		$date_dir = 'data/attachments/'.date("Y/m/d/");
		(!is_dir(FCPATH.$date_dir))&&@mkdir(FCPATH.$date_dir,0777,true);
		$file_name = uniqid('', true).'';
		$dest_file_path = FCPATH.$date_dir.$file_name.'.jpg';
		@copy($source, $dest_file_path);
		file_exists($source) && unlink($source);

		$this->load->library('tupu_image_lib');
		$this->tupu_image_lib->create_thumb($dest_file_path, 'large', 600);
		$this->tupu_image_lib->create_thumb($dest_file_path, 'middle', 200);
		$this->tupu_image_lib->create_thumb($dest_file_path, 'small', 150);
		$this->tupu_image_lib->crop_square($dest_file_path, 100);
		return $date_dir.$file_name;
		
	}
	public function create_share_by_item($item_id,$album_id){
		$this->load->model('item_model');
		$this->load->model('share_model');
		$item = $this->item_model->get_item_by_id($item_id);
		if($item){
			$author = $this->user_model->get_user_by_uid($item->user_id);
			$share_data['item_id'] = $item_id;
			if($album_id){
				$share_data['album_id'] = $album_id;
			}
			$share_data['poster_id'] = $this->data['sess_userinfo']['uid'];
			$share_data['poster_nickname'] = $this->data['sess_userinfo']['nickname'];
			$share_data['original_id'] = 0;
			$share_data['user_id'] = $author->user_id;
			$share_data['user_nickname'] = $author->nickname;
			$share_data['total_comments'] = 0;
			$share_data['total_likes'] = 0;
			$share_data['total_forwarding'] = 0;
			return $this->share_model->add_share($share_data);
		}else{
			return false;
		}
	}



	
}