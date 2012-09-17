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
 * AiTuPu AJAX Controller
 *
 *
 * @package		AiTuPu
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Duobianxing Studio Dev Team
 * @link		http://duobianxing.com/doc/index.html
 */

class Ajax extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}


	public function index()
	{
		$this->output("common/layout", array('body'=>'ajax/index'));
	}

	public function load_login(){
		if (!is_ajax_request()) {
			exit('Access Denied!');
		}
		@$this->config->load('custom',TRUE);
		$data = array();
		$custom =  $this->config->item('custom');
		$api = $custom['api'];//只有后台配置的才能登陆
		$has_Sina = empty($api['Sina']['APPKEY']) ? false:true;//是否配置sina账号
		$has_QQ = empty($api['QQ']['APPKEY']) ? false:true;//是否配置sina账号
		$has_Renren = empty($api['Renren']['APPKEY']) ? false:true;//是否配置sina账号
		$has_Taobao = empty($api['Taobao']['APPKEY']) ? false:true;//是否配置sina账号
		$data['has_Sina'] = $has_Sina;
		$data['has_QQ'] = $has_QQ;
		$data['has_Renren'] = $has_Renren;
		$data['has_Taobao'] = $has_Taobao;
		$this->output('login/login',array(),$data);//登录框
	}

	//检测邮箱地址是否允许注册
	public function ajax_email_valid()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pramga: no-cache");

		$email = $this->input->get('email',true);
		if ($this->user_model->check_email_exists($email)) {
			echo 'false';
		}else{
			echo 'true';
		}
	}

	//检测昵称是否允许注册
	public function ajax_nickname_valid()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pramga: no-cache");

		$nickname = $this->input->get('nickname',true);
		if ($this->user_model->check_nickname_exists($nickname)) {
			echo 'false';
		}else{
			echo 'true';
		}
	}
	//检测昵称是否允许修改
	public function ajax_nickname_update_valid()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pramga: no-cache");

		$nickname = $this->input->get('nickname',true);
		$user_session = $this->user_model->get_usersession();
		if ($nickname!=$user_session['nickname']&&$this->user_model->check_nickname_exists($nickname)) {
			echo 'false';
		}else{
			echo 'true';
		}
	}

	/**
	 * 删除一条评论
	 *
	 */
	public function del_comment(){
		if (!is_ajax_request()) {
			exit('Request Denied!');
		}
		$comment_id = $this->input->post("comment_id",true);
		$share_id = $this->input->post("share_id",true);
		if (!empty($comment_id)) {
			$this->load->model("comment_model");
			$this->load->model('share_model');
			if ($this->comment_model->del_comment($comment_id,array('share_id'=>$share_id))) {
				$count=$this->comment_model->count_comments(array('share_id'=>$share_id));
				$this->share_model->edit_share($share_id,array('total_comments'=>$count));
				$this->share_model->remove_comment($share_id);
				echo 1;//删除成功
				exit();
			}
			echo 0;//删除失败
			exit();
		}
		echo 0;//删除失败
		exit();
	}

	//检测邮箱地址是否允许注册
	public function ajax_email_exist()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pramga: no-cache");

		$email = $this->input->get('email',true);
		if ($this->user_model->check_email_exists($email)) {
			echo 'true';
		}else{
			echo 'false';
		}
	}

	//检测个性域名是否存在
	public function ajax_domain_valid()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pramga: no-cache");

		$domain = $this->input->get('domain',true);
		$user = $this->user_model->check_domain_exists($domain);
		$user_session = $this->user_model->get_usersession();
		if (!$user||($user->user_id==$user_session['uid'])) {
			echo 'true';
		}else{
			echo 'false';
		}
	}


	/**
	 * ajax_fetch_remoteinfo function.
	 * 通过URL，抓取URL中的内容，支持淘宝推广渠道商品抓取及任意网站的图片抓取
	 * @access public
	 * @return void
	 */
	public function ajax_fetch_remoteinfo()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pramga: no-cache");

		$url = $this->input->post('fetch_url');
		$pattern="/\w*:\/\/*/";
		if (!preg_match($pattern,$url)) {
			$response = array('result' => false, 'msg' => "抓取失败,请输入正确的url地址");
			echo json_encode($response);
			exit();
		}
		//判断URL是否为淘宝，如果是淘宝/天猫，调用taobao的渠道执行抓取
		if(strpos($url, 'taobao')||strpos($url, 'tmall')){
			$channel = 'taobao';
		}else{
			$channel = 'others';
		}
		if($channel){

			$data = $this->channel->fetch_remoteinfo($channel,$url);
			if($data)
			$data['channel'] = $channel;
		}
		if($data){
			$response = array('result' => true, 'msg' => "抓取成功", 'data' => $data);
			echo json_encode($response);
		}else{
			$response = array('result' => false, 'msg' => "抓取失败");
			echo json_encode($response);
		}
		exit();
	}

	/**
	 * ajax_get_channel_items function.
	 * 功能：查询淘宝客推广商品列表
	 * @access public
	 * @param mixed $channel  推广渠道名称
	 * @param mixed $keyword  商品搜索关键词
	 * @param mixed $category_id  商品分类ID
	 * @param mixed $page  返回结果的页数
	 * @return void
	 */
	public function ajax_get_channel_items($channel,$keyword,$category_id,$page)
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pramga: no-cache");

		$channel = $this->input->post($channel);
		$keyword = $this->input->post($keyword);
		$category_id = $this->input->post($category_id);
		$page = $this->input->post($page);

		$data = $this->channel->get_channel_items($channel,$keyword,$category_id,$page);
		$data['channel'] = $channel;

		if($data){
			$response = array('result' => true, 'msg' => "获取商品成功", 'data' => $data);
			echo json_encode($response);
		}else{
			$response = array('result' => false, 'msg' => "获取商品成功");
			echo json_encode($response);
		}
	}


	public function ttt(){
		$data = $this->channel->get_channel_items('taobao','连衣裙','',2);
		print "<pre>";
		print_r($data);
	}

	public function sss(){
		$data = $this->channel->get_channel_cats('taobao',0);
		print "<pre>";
		print_r($data);
	}

	/**
	 * ajax_file_upload function.
	 * 用户本地上传方式分享图片，仅支持图片上传
	 * @access public
	 * @return void
	 */
	public function ajax_file_upload()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pramga: no-cache");

		if(isset($_FILES['upload_file_input'])){
			$this->load->library('upload');
			$temp_dir = 'data/attachments/tmp';
			(!is_dir(FCPATH.$temp_dir))&&@mkdir(FCPATH.$temp_dir,0777,true);
			$file_name = time().'';
			$custom =  $this->config->item('custom');

			$config['upload_path'] = $temp_dir;
			$config['allowed_types'] = $custom['file']['upload_file_type'];
			$config['max_size'] = $custom['file']['upload_file_size'];
			$config['max_width']  = $custom['file']['upload_image_size_h'];
			$config['max_height']  = $custom['file']['upload_image_size_w'];
			$config['file_name']  = $file_name;
			$min_width = max(intval($custom['file']['fetch_image_size_w']),0);//后台设置的最小宽
			$min_height = max(intval($custom['file']['fetch_image_size_h']),0);//后台设置的最小高
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('upload_file_input'))
			{
				$data['error'] = $this->upload->display_errors();
				$response = array('result' => false, 'msg' => "上传失败", 'data' => $data);
			}
			else
			{
				$upload_data = $this->upload->data();
				$data['image_url'] = $temp_dir.'/'.$file_name.$upload_data['file_ext'];

				$data['image_full_url'] = base_url($temp_dir.'/'.$file_name.$upload_data['file_ext']);
				$property = getimagesize($data['image_full_url']);
				$data['width'] = $property[0];//图片宽度
				$data['height'] = $property[1];
				if ($data['width'] < $min_width || $data['height'] < $min_height) {
					$data['msg']="您上传的图片尺寸过小，不符合规定范围内的尺寸要求！";
					$data['error']="";
					$response = array('result' => false, 'msg' => "上传失败，您上传的图片尺寸过小！", 'data' => $data);
					echo json_encode($response);
					exit();//直接退出
				}
				$response = array('result' => true, 'msg' => "上传成功", 'data' => $data);
			}
		}else{
			$data['error'] = '没有图片需要上传';
			$response = array('result' => false, 'msg' => "上传失败", 'data' => $data);
		}
		$response['data']['error'] = strip_tags($response['data']['error']);
		echo json_encode($response);
	}



	/**
	 * 测试方法，暂未使用
	 * ajax_fetch_images function.
	 * 通过URL，预抓取HTML页面中的图片，只抓取图片尺寸超过250*250的图片
	 * @access public
	 * @return void
	 */
	public function ajax_fetch_images()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pramga: no-cache");

		$this->load->helper('file');

		if($this->input->get()) {
			$url = $this->input->get('fetch_url');
			$html = fetch_curl($url);
			$str = stripslashes($html);
			$pattern = "/<img[^>]*src\=\"(([^>]*)(jpg|png|jpeg))\"/";   //获取所有图片标签的全部信息
			$images = array();
			preg_match_all($pattern, $str, $matches);
			foreach ($matches[1] as $value) {  					//$matches[1]中就是所想匹配的结果,结果为数组
				$metadata = get_image_size($value);
				if($metadata['width'] > 250 || $metadata['height'] > 250) {
					array_push($images,$value);
				}
			}
			if(count($images)){
				$response = array('result' => true, 'msg' => "抓取成功",'data'=>$images);
				echo json_encode($response);
			}else{
				$response = array('result' => false, 'msg' => "抓取失败");
				echo json_encode($response);
			}
		}else{

		}
	}


	/**
	 * 判断是否是ajax合法请求
	 *
	 * @return boolean true||false
	 */
	public function is_ajax_request(){
		return $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
	}

	//关注朋友
	public function ajax_add_follow()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pramga: no-cache");

		$this->ajax_check_login();
		if(!$this->is_ajax_request())
		exit('Access denied!');
		if($this->input->post()) {
			$user_id = $this->input->post('user_id');
			$friend_id = $this->input->post('friend_id');
			$this->load->model('follow_model');

			if ($this->follow_model->add_follow($user_id,$friend_id)) {
				$response = array('result' => true, 'msg' => "已成功关注");
				echo json_encode($response);
			}else{
				$response = array('result' => false, 'msg' => "关注失败");
				echo json_encode($response);
			}
		}else{
			$response = array('result' => false, 'msg' => "非法操作");
			echo json_encode($response);
		}

	}

	//取消关注朋友
	public function ajax_remove_follow()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pramga: no-cache");

		$this->ajax_check_login();

		if($this->input->post()) {
			$user_id = $this->input->post('user_id');
			$friend_id = $this->input->post('friend_id');

			$this->load->model('follow_model');

			if ($this->follow_model->remove_follow($user_id,$friend_id)) {
				$response = array('result' => true, 'msg' => "关注已取消");
				echo json_encode($response);
			}else{
				$response = array('result' => false, 'msg' => "取消关注失败");
				echo json_encode($response);
			}
		}else{
			$response = array('result' => false, 'msg' => "非法操作");
			echo json_encode($response);
		}

	}

	/**
	 * 加载修改密码模板
	 *
	 */
	public function load_edit_password(){
		if (!is_ajax_request()) {
			exit('Access Denied!');
		}
		$user_session = $this->user_model->get_usersession();
		$data['sess_userinfo'] = $user_session;
		$this->load->view('member/change_password',$data);
	}

	public function load_fetch_index(){
		if (!is_ajax_request()) {
			exit('Access Denied!');
		}
		$this->load->view("member/share");
	}

	/**
	 * ajax添加专辑
	 *
	 */
	public function add_album(){
		if (!is_ajax_request()) {
			exit('Access Denied!');
		}
		$this->load->model("category_model");
		$categories = $this->category_model->get_categories();
		$data['categories'] = $categories;
		$this->load->view("member/share_add",$data);
	}

	/**
	 * 本地分享图片
	 *
	 */
	public function upload_local_share(){
		if (!is_ajax_request()) {
			exit('Access Denied!');
		}
		$this->load->model("album_model");
		$this->load->model("category_model");
		$albums = array();
		$user = $this->user_model->get_usersession();
		$categories = $this->category_model->get_categories();
		$category_id = $categories[0]->category_id;
		$albums = $this->album_model->get_user_albums_by_cate($category_id,$user['uid'],50);//获取当前登录用户的相册
		if (empty($albums)) {
			$albums = array();
			$albums[] = $this->album_model->get_user_default_album($user['uid']);//用户默认相册
		}
		$data['albums'] = $albums;
		$data['categories'] = $categories;
		$this->load->view("member/share_local",$data);
	}

	/**
	 * 网路获取分享
	 *
	 */
	public function web_upload_share(){
		if (!is_ajax_request()) {
			exit('Access Denied!');
		}
		$this->load->model("album_model");
		$this->load->model("category_model");
		$albums = array();
		$user = $this->user_model->get_usersession();
		$categories = $this->category_model->get_categories();
		$category_id = $categories[0]->category_id;
		$albums = $this->album_model->get_user_albums_by_cate($category_id,$user['uid'],50);//获取当前登录用户的相册
		if (empty($albums)) {
			$albums = array();
			$albums[] = $this->album_model->get_user_default_album($user['uid']);//用户默认相册
		}
		$data['albums'] = $albums;
		$data['categories'] = $categories;
		$this->load->view("member/share_web",$data);
	}

	/**
	 * 举报功能
	 *
	 */
	public function report_content(){
		if (!is_ajax_request()) {
			exit('Access Denied!');
		}
		$data = array();
		$this->load->model("user_model");
		$user = $this->user_model->get_usersession();
		if (!$user['uid']) {
			echo 0;//投诉失败 用户未登录，二重判断
			exit();
		}
		$report_content = strip_tags($this->input->post("report"));
		$report_type = $this->input->post("type");
		if ((!$report_content)||(!$report_type)) {
			echo 0;
			exit();
		}
		$data['port_userid'] =  $user['uid'];
		$data['content'] =  $report_content;
		$data['datetime'] = time();
		$data['report_type'] = $report_type;
		$this->load->model("report_model");
		if($this->report_model->insert_report($data))
		echo 1;//投诉成功
		else
		echo 0;
		exit();
	}

	public function tongji(){
		if (!$this -> input -> get('key') == 'b80de8196dc2aee5b9c2e6f71de67c10') {
			exit;
		}
		$this -> load -> model('user_model');
		//24小时用户活跃数
		$activ_user = $this -> user_model -> count_active_user();
		//24小时用户注册数
		$reg_user = $this -> user_model -> count_new_register_user();
		//data目录的文件大小
		$data_size = $this -> user_model -> count_dir_size();
		$data_size =  $this -> user_model -> exchange_byte($data_size);

		$this -> load -> model('page_view_model');
		$page_vew = $this -> page_view_model -> count_day_views();

		$data = array(
		'activ_user' => $activ_user,
		'reg_user'   => $reg_user,
		'page_count' => $page_vew['page_count'],
		'ip_count'   => $page_vew['ip_count'],
		);

		echo json_encode($data);

	}
	
	/**
	 * 根据分类id载入登录用户相册列表
	 *
	 */
	public function ajax_load_album(){
		if (!is_ajax_request()) {
			exit('Access Denied!');
		}
		$this->load->model("album_model");
		$this->load->model("category_model");
		$user = $this->user_model->get_usersession();
		$data = array();
		$category_id = intval($this->input->post("category_id",true));
		$albums = $this->album_model->get_user_albums_by_cate($category_id,$user['uid'],20);
		if (!empty($albums)) {
			$data =array('flag'=>true,'albums'=>$albums);
		}else {
			$data = array('flag'=>false);
		}
		echo json_encode($data);
	}

}// end of the class