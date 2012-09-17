<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * AiTuPu
 *
 * An open source social sharing platform
 *
 * @package		AiTuPu
 * @author		Duobianxing Studio Dev Team
 * @copyright	Copyright (c) 2011 - 2012, Duobianxing, Inc.
 * @license		http://duobianxing.com/doc/license.html
 * @link		http://duobianxing.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * AiTuPu Member Controller
 *
 *
 * @package		AiTuPu
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Duobianxing Studio Dev Team
 * @link		http://duobianxing.com/doc/index.html
 */


class Member extends MY_Controller {
	
	public function __construct() {

		parent::__construct();
		
		//var_dump($this -> data['sess_userinfo']);exit;
	}
	

	public function account_info(){
		
    	
		$this->output("common/layout", array('body'=>'member/account_info'),$data);
	}
	/**
	 * 个人中心，显示我关注的和我的分享
	 *
	 */
	
	public function index(){
		$this->check_login();
		$data['tpl_member_slide'] = $this->load->view('common/member_slide', $this -> data , true);
		
		$page = intval($this->uri->segment(3));
		if($page < 1) $page = 1;
		$this -> load -> model('share_model');
		$condition = array('timeline_by_id' => $this -> data['sess_userinfo']['uid']);
		$share['shares'] = $this -> share_model -> fetch_shares_with_item(($page - 1)*12 , 12 , $condition);
		//var_dump($share['shares']);exit;
		$share['login_uid'] = $this -> data['sess_userinfo']['uid'];
		//模版输出
    	$share['theme_url'] = $this -> data['theme_url'];
    	if ($page > 1) {
    		echo $this->load->view('common/waterfall', $share, true);
    		exit;
    	}
    	
		$data['tpl_waterfall'] = $this->load->view('common/waterfall', $share, true);
		
		$this -> load -> model('user_model');
		$data['is_friend_recommend'] = $this -> user_model -> get_user_friend_recommend($this -> data['sess_userinfo']['uid']);
		//页面级JS
    	$this->data['page_js'] = array(
	    	base_url('assets/js/jquery.masonry.min.js'),
    		base_url('assets/js/jquery.infinitescroll.min.js'),
    		base_url('assets/js/tupu.waterfall.js'),    		
    		base_url('assets/js/tupu.action.js'),
    		base_url('assets/js/jquery.form.js'),
    	);
    	//页面级CSS
    	$this->data['page_css'] = array(
    	);
		
		$this->output("common/layout", array('body'=>'member/index'),$data);
	}
	
	function follow_friends(){
		if (!is_ajax_request()) {
			exit('Access Denied!');
		}
		if (count($this -> input -> post('follow')) > 0) {
			$this->load->model('follow_model');
			foreach ($this -> input -> post('follow') as $f_id){
				$u_id = $this -> data['sess_userinfo']['uid'];
				$this -> follow_model -> add_follow($u_id , $f_id);
			}
			$this -> load -> model('user_model');
			$this -> user_model -> disable_friend_recommend($u_id);
			$response = array('result' => true, 'msg' => "关注成功");
			echo json_encode($response);
		}else{
			exit('您没关注任何人');
		}
	}
	
	function disable_follow_friends(){
		if ($this -> input -> post('disable') == 1) {
			$this -> load -> model('user_model');
			$u_id = $this -> data['sess_userinfo']['uid'];
			$this -> user_model -> disable_friend_recommend($u_id);
			$response = array('result' => true, 'msg' => "关注成功");
			echo json_encode($response);
		}
	}
	
	function friend_recommend(){
		$data['theme_url'] = $this->data['theme_url'];
		
		$this -> load -> model('user_model');
		//获取没有关注的推荐用户
		$u_id = $this -> data['sess_userinfo']['uid'];
		$top_users = $this -> user_model -> get_recommend_friends($u_id , 10);
		$data['top_users'] = $top_users;
		
		$this->load->view('member/friend_recommend.php', $data);
	}
	//编辑专辑
	public  function edit_album(){
		$this->ajax_check_login('txt');
		
		$album_id = intval($this -> input -> post('album_id' , true));
		
		if ($this -> data['is_admin'] == 1) {
			$uid = 0;
		}else {
			$uid = $this->data['sess_userinfo']['uid'];
		}
		
		$this -> load -> model('album_model');
		$album = $this -> album_model -> get_one_album_by_uid($album_id , $uid);
		if (!$album) {
			echo "no_data";
			exit;
		}
		if ($this -> input -> post('action') == 'save') {//处理提交
			$data = array('title' => $this -> input -> post('title') , 'category_id' =>  $this -> input -> post('category_id'));
			$this -> album_model -> edit_album($album_id , $data);
			echo 1;
			exit;
		}
		$data['album'] = $album;
		//var_dump($album);exit;
		$this -> load -> model('category_model');
		$data['cates'] = $this -> category_model -> get_categories();
		$this->load->view('member/edit_album.php', $data);
	}
	//删除专辑
	public function del_album(){
		$this->ajax_check_login('txt');
		
		$album_id = intval($this -> input -> post('album_id' , true));
		if ($this -> data['is_admin'] == 1) {
			$uid = 0;
		}else {
			$uid = $this->data['sess_userinfo']['uid'];
		}
		$this -> load -> model('album_model');
		$return = $this -> album_model -> del_album_by_user($album_id , $uid);
		echo $return;
		exit;
	}
	//编辑分享
	public function edit_share(){
		$this->ajax_check_login('txt');
		
		$share_id = $this->input->post('share_id',true);
		if ($this -> data['is_admin'] == 1) {
			$uid = 0;
		}else {
			$uid = $this->data['sess_userinfo']['uid'];
		}
		$this->load->model('share_model');
		$share = $this->share_model->get_share_by_share_id_and_user_id($share_id , $uid);
		if (!$share) {
			echo "no_data";
			exit;
		}
		if ($this -> input -> post('action') == 'save') {//处理提交
			$data = array('album_id' => intval($this -> input -> post('album_id')));
			$this->share_model -> edit_share($share_id , $data);
			echo 1;
			exit;
		}
		//获取用户的albums
		$this->load->model('album_model');
		$albums = $this -> album_model -> get_user_albums($share -> poster_id , 0 , 0 , 0);
		//var_dump($albums);exit;
		$data = array(
			'share' => $share,
			'albums'   => $albums,
		);
		$this->load->view('member/edit_share.php', $data);
	}
	//删除分享
	public function del_share(){
		$this -> ajax_check_login('txt');
		$share_id = intval($this -> input -> post('share_id'));
		if ($share_id < 1) {
			echo "no_data";
			exit;
		}
		if ($this -> data['is_admin'] == 1) {
			$uid = 0;
		}else {
			$uid = $this->data['sess_userinfo']['uid'];
		}
		$this -> load -> model('share_model');
		$return = $this -> share_model -> del_share($share_id , $uid);
		echo $return;
	}
	//置顶操作
	function do_top_album(){
		$album_id = intval($this -> input -> post('album_id'));
		if ($album_id  < 1) {
			echo 0;
			exit;
		}
		$this -> load -> model('album_model');
		if ($this -> album_model -> set_top_album($album_id)) {
			echo 1;
			exit;
		}
		echo 0;
	}
	
	public function message_system(){
		$this->output("common/layout", array('body'=>'member/message_system'),$data);
	}
	
	/**
	 * 个人账户信息
	 *
	 */
	public function setting_info(){
		$this->check_login();
		$user_session = $this->user_model->get_usersession();
		//connector start
		$this->load->model('connector_model');
		$bind_connectors = $this->connector_model->get_bind_connector_by_uid($user_session['uid']);
		$data_temp = array();
			foreach ($bind_connectors as $connector){
			$vendor = $connector->vendor;
			$data_temp[$vendor.'_id'] = $connector->connect_id;
			$data_temp[$vendor.'_username'] = $connector->username;
		}
		//connector end
		$user = $this->user_model->get_user_by_uid($user_session['uid']);
		$user_info['nickname'] = $user->nickname;
		$user_info['gender'] = $user->gender;
		$user_info['is_social']=$user->is_social;
		$user_info['province'] = $user->province;	
		$user_info['city'] = $user->city;
		$user_info['bio'] = $user->bio;
		$user_info['domain'] = $user->domain;
		$user_info['email'] =  $user->email;
		$data['sess_userinfo'] = $user_info;
		//$this->create_logged_in_membercp();
		$data = $user_info;
		$data = array_merge($data,$data_temp);
		
		$this->data['page_js'] = array( 		
    		base_url('assets/js/tupu.action.js'),
    		base_url('assets/js/jcrop/jquery.Jcrop.min.js'),
    	);
    	//页面级CSS
    	$this->data['page_css'] = array(
    		base_url('assets/js/jcrop/jquery.Jcrop.min.css'),
    	);
		
		$this->output("common/layout", array('body'=>'member/account_info'),$data);
	}
	
	private function validate_reset_form_local(){
		$this->form_validation->set_rules('org_passwd', '原密码' , 'trim|required');
		$this->form_validation->set_rules('new_passwd', '用户密码' , 'trim|required|min_length[6]|max_length[40]|matches[new_verify_passwd]');
		$this->form_validation->set_rules('new_verify_passwd', '密码验证' , 'trim|required|min_length[6]|max_length[40]');
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/**
	 * 检查用户email地址
	 *
	 * @return bool
	 */
	private function validate_reset_form_social(){
		$this->form_validation->set_rules('email', 'Email' , 'trim|required|valid_email|min_length[3]|max_length[20]|xss_clean');
		$this->form_validation->set_rules('new_passwd', '用户密码' , 'trim|required|min_length[6]|max_length[40]|matches[new_verify_passwd]');
		$this->form_validation->set_rules('new_verify_passwd', '密码验证' , 'trim|required|min_length[6]|max_length[40]');
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/**
	 * 重新设置密码
	 * 注意本站永和和第三方用户
	 *
	 */
	public function reset_passwd(){
		$this->ajax_check_login();
		if($this->input->post()){
			$user_session = $this->user_model->get_usersession();
			if($user_session['is_social']){
				if($this->validate_reset_form_social()){
					$data['email'] = $this->input->post('email',true);
					$data['passwd'] = md5($this->input->post('new_passwd',true));
					$data['is_social'] = 0;
					if($this->user_model->edit_user($user_session['uid'],$data)){
						$user = $this->user_model->get_user_by_uid($user_session['uid']);
						$this->user_model->set_usersession($user);
						$response = array('result' => true, 'msg' => "保存成功");
						echo json_encode($response);
					}else{
						$response = array('result' => false, 'msg' => "保存失败，请检查你输入的内容是否正常");
						echo json_encode($response);
					}
					return;
				}else{
					$response = array('result' => false, 'msg' => "保存失败，请检查您的输入！");
					echo json_encode($response);
					return;
				}
			}else {
				if($this->validate_reset_form_local()){
					$org_passwd = $this->input->post('org_passwd',true);
					$new_passwd = $this->input->post('new_passwd',true);
					if($org_passwd==$new_passwd){
						$response = array('result' => false, 'msg' => "新密码不能和原密码一致！");
						echo json_encode($response);
						return;
					}
					$user = $this->user_model->get_user_by_uid($user_session['uid']);
					if($user->passwd != md5($org_passwd)){
						$response = array('result' => false, 'msg' => "您的原始密码错误，请重新输入！");
						echo json_encode($response);
						return;
					}
					$data['passwd'] = md5($new_passwd);
					if($this->user_model->edit_user($user_session['uid'],$data)){
						$response = array('result' => true, 'msg' => "保存成功");
						echo json_encode($response);
					}else{
						$response = array('result' => false, 'msg' => "保存失败，请检查你输入的内容是否正常");
						echo json_encode($response);
					}
					return;
				}else{
					$response = array('result' => false, 'msg' => "保存失败，请检查您的输入！");
					echo json_encode($response);
					return;
				}
			}
		}
	}
	
	/**
	 * 更改头像
	 *
	 */
	public function upload_avatar(){
		$this->ajax_check_login('txt');
		//echo 32424324234;exit;
		if ($this -> input -> post('upload')) {//处理上传
			$file_input_name = 'Filedata';
			if (!isset($_FILES[$file_input_name])){
				$result = array('result' => false , 'msg' => '请选择图片');
				echo json_encode($result);
				exit;
			}
			$u_id = $this -> data['sess_userinfo']['uid'];
			$this -> load -> model('user_model');
			$avatar_info = $this -> user_model -> get_avatarinfo($u_id);
			$avatar_dir = FCPATH.$avatar_info['dir'];
			(!is_dir($avatar_dir))&&@mkdir($avatar_dir,0777,true);
			file_exists($avatar_dir.$avatar_info['orgin']) && unlink($avatar_dir.$avatar_info['orgin']);
			
			$this->load->library('upload');
			$config['upload_path'] = $avatar_dir;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|bmp';
			$config['max_size'] = '1024';
			$config['max_width']  = '4000';
			$config['max_height']  = '4000';
			$config['file_name']  = $avatar_info['orgin'];
			$this->upload->initialize($config);
			if (!$this->upload->do_upload($file_input_name)){
				
				$msg =  $this -> upload -> display_errors();
				$data['result'] = 0;
				$data['msg'] = $msg;
			}else{
				$data['result'] = 1;
				$data['image_dir'] = FCPATH.$avatar_info['dir'].$avatar_info['orgin'];
				$data['image_url'] = base_url($avatar_info['dir'].$avatar_info['orgin']).'?'.time();
				//"width"		=>$imageInfo[0],
                //"height"	=>$imageInfo[1],
				$info  = $this -> _getImageInfo($data['image_dir']);
				
				$data['img_attr_str'] = "";
				$data['img_attr_key'] = 'none';
				$data['img_attr_val'] = 0;
				if ($info['width'] >= $info['height']) {//如果宽度大于高度，宽度缩放
					if ($info['width'] > 300) {
						$data['img_attr_str'] = "width=\"300\"";
						$data['img_attr_key'] = 'width';
						$data['img_attr_val'] = 300;
					}
				}else {
					if ($info['height'] > 300) {
						$data['img_attr_str'] = "height=\"300\"";
						$data['img_attr_key'] = 'height';
						$data['img_attr_val'] = 300;
					}
				}
				
			}
			echo json_encode($data);
			exit;
			//$this->load->view('member/upload_avatar.php', $data);
		}
		if ($this -> input -> post('save_crop')) {//处理裁剪
			$org_image =  $this -> input -> post('org_img');
			$return  = $this -> _cutHeader($org_image);
			$return['result'] = true;
			echo json_encode($return);
			exit;
		}
		//$this->load->view('member/upload_avatar.php', $data);
	}
	function _cutHeader($image , $is_save=false,$suofang=1,$type='',$interlace=true){
		$info  = $this -> _getImageInfo($image);
		
		if($info !== false) {
			$srcWidth  = $info['width'];
			$srcHeight = $info['height'];
            $type = empty($type)?$info['type']:$type;
			$type = strtolower($type);
            $interlace  =  $interlace? 1:0;
            unset($info);
            
            $width  = $srcWidth;
            $height = $srcHeight;
            
            // 载入原图
            $createFun = 'ImageCreateFrom'.($type=='jpg'?'jpeg':$type);
            $srcImg     = $createFun($image);
            if($type!='gif' && function_exists('imagecreatetruecolor'))
                $thumbImg = imagecreatetruecolor($width, $height);
            else
                $thumbImg = imagecreate($width, $height);
            //var_dump($thumbImg);exit;
            //创建缩略图
            if($type!='gif' && function_exists('imagecreatetruecolor'))
                $thumbImg = imagecreatetruecolor($width, $height);
            else
                $thumbImg = imagecreate($width, $height);
                
            if(function_exists("ImageCopyResampled"))
                imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth,$srcHeight);
            else
                imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height,  $srcWidth,$srcHeight);
            if('gif'==$type || 'png'==$type) {
                //imagealphablending($thumbImg, false);//取消默认的混色模式
                //imagesavealpha($thumbImg,true);//设定保存完整的 alpha 通道信息
                $background_color  =  imagecolorallocate($thumbImg,  0,255,0);  //  指派一个绿色
				imagecolortransparent($thumbImg,$background_color);  //  设置为透明色，若注释掉该行则输出绿色的图
            }
            
             // 对jpeg图形设置隔行扫描
            if('jpg'==$type || 'jpeg'==$type) 	imageinterlace($thumbImg,$interlace);
            //$gray=ImageColorAllocate($thumbImg,255,0,0);
            //ImageString($thumbImg,2,5,5,"ThinkPHP",$gray);
            // 生成图片
            $imageFun = 'image'.($type=='jpg'?'jpeg':$type);
            if ($type == 'png') {
            	$q = 9;
            }
            else {
            	$q = 100;
            }
			$length = strlen("00.".$type) * (-1);
			$_type = substr($image,-4);
			$length = ($type != $_type ? $length+1 : $length);
			//裁剪
            if ($suofang==1) {
            	$u_id = $this -> data['sess_userinfo']['uid'];
				$this -> load -> model('user_model');
				$avatar_info = $this -> user_model -> get_avatarinfo($u_id);
				$avatar_dir = FCPATH.$avatar_info['dir'];
				file_exists($avatar_dir.$avatar_info['large']) && unlink($avatar_dir.$avatar_info['large']);
				file_exists($avatar_dir.$avatar_info['middle']) && unlink($avatar_dir.$avatar_info['middle']);
				file_exists($avatar_dir.$avatar_info['small']) && unlink($avatar_dir.$avatar_info['small']);
				$time = time();
				$return = array(
					'big' => base_url($avatar_info['dir'].$avatar_info['large']).'?'.$time,
					'mid' => base_url($avatar_info['dir'].$avatar_info['middle']).'?'.$time,
					'small' => base_url($avatar_info['dir'].$avatar_info['small']).'?'.$time,
				);
				$thumbname01 = $avatar_dir.$avatar_info['large'];		//大头像
				$thumbname02 = $avatar_dir.$avatar_info['middle'];		//中头像
				$thumbname03 = $avatar_dir.$avatar_info['small'];		//小头像
				$imageFun($thumbImg,$thumbname01,$q);
				$imageFun($thumbImg,$thumbname02,$q);
				$imageFun($thumbImg,$thumbname03,$q);
				//var_dump($_POST);exit;
                
                //$srcHeight
                if ($_POST['img_attr_key'] != 'none') {
                	if ($_POST['img_attr_key'] == 'width') {
                		$d = $srcWidth/300;
                	}
                	else {
                		$d = $srcHeight/300;
                	}
                }else {
                	$d = 1;
                }
                
                
                $x = $_POST['x'] * $d;
                $y = $_POST['y'] * $d;
                
                $w = $_POST['w'] * $d;
                $h = $_POST['h'] * $d;
                
                $thumbImg01 = imagecreatetruecolor(150,150);
                imagecopyresampled($thumbImg01,$thumbImg,0,0,$x,$y,150,150,$w,$h);
				
				$thumbImg02 = imagecreatetruecolor(50,50);
                imagecopyresampled($thumbImg02,$thumbImg,0,0,$x,$y,50,50,$w,$h);
                
                $thumbImg03 = imagecreatetruecolor(30,30);
                imagecopyresampled($thumbImg03,$thumbImg,0,0,$x,$y,30,30,$w,$h);
				
				$imageFun($thumbImg01,$thumbname01,$q);
				$imageFun($thumbImg02,$thumbname02,$q);
				$imageFun($thumbImg03,$thumbname03,$q);
//				unlink($image);
				imagedestroy($thumbImg01);
				imagedestroy($thumbImg02);
				imagedestroy($thumbImg03);
				//imagedestroy($thumbImg);
				imagedestroy($srcImg);
				return $return;	//返回包含大小头像路径的数组
            } 
		}
	}
	function _getImageInfo($img) {
        $imageInfo = getimagesize($img);
        if( $imageInfo!== false) {
            $imageType = strtolower(substr(image_type_to_extension($imageInfo[2]),1));
            $imageSize = filesize($img);
            $info = array(
                "width"		=>$imageInfo[0],
                "height"	=>$imageInfo[1],
                "type"		=>$imageType,
                "size"		=>$imageSize,
                "mime"		=>$imageInfo['mime'],
            );
            return $info;
        }else {
            return false;
        }
    }
	
	public function update_userinfo(){
		$this->ajax_check_login();
		
		if($this->input->post()){
			$user_session = $this->user_model->get_usersession();
			$data['nickname'] = $this->input->post('nickname',true);
			$data['email'] = $this->input->post('email',true);
			$data['gender'] = $this->input->post('gender',true);
			$data['province'] = $this->input->post('province',true);
			$data['city'] = $this->input->post('city',true);
			//$data['location'] = $this->input->post('location',true);
			$data['bio'] = replace_badword($this->input->post('bio',true));//敏感词过滤
			//$data['domain'] = $this->input->post('domain',true);
			if ($data['nickname']!=$user_session['nickname']&&$this->user_model->check_nickname_exists($data['nickname'])) {
				$response = array('result' => false, 'msg' => "保存失败，你输入的昵称已经存在");
				echo json_encode($response);
				return;
			}
			if($data['email']){
			if($data['email'] != $user_session['email'] && $this->user_model->check_email_exists($data['email'])){
				$response = array('result' => false, 'msg' => "保存失败，你输入的email地址已经存在");
				echo json_encode($response);
				return;
			}	
			}else{
				unset($data['email']);
			}
			//$user = $this->user_model->check_domain_exists($domain);
			if ($user&&($user->user_id==$user_session['uid'])) {
				$response = array('result' => false, 'msg' => "保存失败，你输入的域名已经存在");
				echo json_encode($response);
				return;
			}
		
			if($this->user_model->edit_user($user_session['uid'],$data)){
				$user = $this->user_model->get_user_by_uid($user_session['uid']);
				$this->user_model->set_usersession($user);
				$response = array('result' => true, 'msg' => "保存成功");
				echo json_encode($response);
			}else{
				$response = array('result' => false, 'msg' => "保存失败，请检查你输入的内容是否正常");
				echo json_encode($response);
			}
		}
	}
	
	public function ajax_album_create()
	{
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pramga: no-cache");

		$this->ajax_check_login();
		if($this->input->post()){
			$data['title'] = $this->input->post('album_title',true);
			$data['category_id'] = $this->input->post('category_id',true);
			$data['user_id'] = $this->data['sess_userinfo']['uid'];
			$data['cover'] = 'data/images/album_bg.jpg';
			$data['is_system'] = 0;
			$this->load->model('album_model');
			$insert_id=0;
			if($insert_id = $this->album_model->add_album($data)){
				$this->user_model->refresh_usersession();
				$response = array('result' => true, 'msg' => "保存成功",'insert_id'=>$insert_id);
				echo json_encode($response);
			}else{
				$response = array('result' => false, 'msg' => "保存失败，请检查你输入的内容是否正常");
				echo json_encode($response);
			}
		}
	}
	
	/**
	 * 找回密码
	 *
	 */
	public function lost_password(){
		if($this->input->post()){
			$to_email = $this->input->post('email',true);
			if($this->user_model->check_email_exists($to_email)){
				$password_key = random_string('unique');
				$password_expire = time() + 172800;
				if( $this->user_model->update_password_key($to_email,$password_key,$password_expire)) {
					$user = $this->user_model->get_full_user_by_email($to_email);
					$data['nickname'] = $user->nickname;
					$data['set_password_url'] = '{unwrap}'.site_url('member/set_password').'/'.$password_key.'{/unwrap}';
					
					$data['site_name'] = $site_info['site_name'];

					$this->config->load('custom',TRUE);
					$site_info =  $this->config->item('site_info','custom');
				
					$data['site_name'] = $site_info['site_name'];
					$data['site_url'] = $site_info['site_url'];
					$this->load->helper('email');
					my_send_email($to_email,'mail_lost_password',$data);
					$this->output("common/layout", array('body'=>'member/lost_password_ok'));
					return;
				}
			}else{
				header('content-type:text/html;charset=utf-8');
				show_error('邮箱不存在');
				return;
			}
		}
		$this->output("common/layout", array('body'=>'member/lost_password'));
	}

	/**
	 * 找回密码
	 *
	 */
	public function set_password(){

		//判断是否存在password key
		$password_key = $this->uri->segment(3);
		if(!$password_key){
			redirect('welcome/index');
		}
		//判断password key是否过期
		$user = $this->user_model->get_user_by_password_key($password_key);
		if($user->lost_password_expire > time()){
			$data['is_expire'] = false;
		}else{
			$data['is_expire'] = true;
		}
		//如果条件具备，执行更新密码操作
		if($this->input->post('password') && !$data['is_expire'] ){
			$new_password = $this->input->post('password');
			$this->user_model->update_user_password($user->user_id,$new_password);
			//将password key清空
			$this->user_model->update_password_key($user->email,'','');
			$this->output("common/layout", array('body'=>'member/set_password_ok'));
			return;
		}

		$this->output("common/layout", array('body'=>'member/set_password'),$data);
	}
	
}

