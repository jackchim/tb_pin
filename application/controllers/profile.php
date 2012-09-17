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
 * AiTuPu Profile Controller
 *
 *
 * @package		AiTuPu
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Duobianxing Studio Dev Team
 * @link		http://duobianxing.com/doc/index.html
 */


class Profile extends MY_Controller {
	//var $_user;
	
	public function __construct() {		
		parent::__construct();
		//获取个人主页用户的基本信息
		$u = intval($this -> uri -> segment(2));
		if ($u < 1) {
			if ($this -> data['sess_userinfo']) {
				$u = $this -> data['sess_userinfo']['uid'];
			}else {
				show_404('用户不存在');
			}
		}
		$this->load->model('user_model');
		$user = $this -> user_model -> get_user_by_uid($u);
		
		if (empty($user)) {
			show_404('用户不存在');
		}
		
		$this -> data['_user'] = $user;
		//如果登录用户访问的不是自己的个人主页
		if ($this -> data['sess_userinfo']['uid'] != $this -> data['_user'] -> user_id) {
			$this -> load -> model('follow_model');
			$this -> data['relation'] = $this -> follow_model -> get_relation($this -> data['sess_userinfo']['uid'] , $this -> data['_user'] -> user_id);
			//var_dump($relation);exit;
			$this -> data['ta'] = "TA ";
		}else {
			$this -> data['ta'] = "我";
		}
		
		$this -> data['seo_set']['seo_title'] =$user -> nickname;
		$this -> data['seo_set']['seo_keywords'] = $user -> nickname;
		$this -> data['seo_set']['seo_description'] = $user -> nickname;
		
	}

	public function index()
	{
		
		
		
		
		$page = intval($this->uri->segment(3));
		if($page < 1) $page = 1;
		//个人的专辑
		$this -> load -> model('album_model');
		$albums = $this -> album_model -> get_user_albums($this -> data['_user'] -> user_id , 12 , ($page -1)*12);
		$album['albums'] = $albums;
		//var_dump($albums);exit;
		$album['theme_url'] = $this -> data['theme_url'];
		$album['login_uid'] = $this -> data['sess_userinfo']['uid'];
		$album['is_admin'] = $this -> data['is_admin'];
		if ($page > 1) {
			echo $this->load->view('common/album', $album, true);
			exit;
		}
		//var_dump($album);exit;
		$data['tpl_albums'] = $this->load->view('common/album', $album, true);
		
		
		//如果用户登录了，且用户访问的不是自己的个人主页，添加访问记录
		if ($this -> data['sess_userinfo'] && $this -> data['sess_userinfo']['uid'] != $this -> data['_user'] -> user_id) {
			$view_data = array(
				'user_id' => $this -> data['sess_userinfo']['uid'],
				'nickname' => $this -> data['sess_userinfo']['nickname'],
				'view_time' => time(),
			);
			$this -> user_model -> update_view($this -> data['_user'] -> user_id , $view_data);
		}
		
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
		
		$this -> output("common/layout", array('body'=>'profile/index'),$data);
	}
	//我喜欢的
	public function favorites(){
		//获取用户喜欢的分享
		$page = intval($this->uri->segment(4));
		if($page < 1) $page = 1;
		$this->load->model('favorite_share_model');
		$favorite['shares']  = $this -> favorite_share_model -> get_favorite_shares($this -> data['_user'] -> user_id,($page - 1) * 12,12);
		//var_dump($shares);exit;
		$favorite['theme_url'] = $this -> data['theme_url'];
		$favorite['login_uid'] = $this -> data['sess_userinfo']['uid'];
		$favorite['is_admin'] = $this -> data['is_admin'];
		if ($page > 1) {
			//var_dump($favorite['shares']);exit;
			echo $this->load->view('common/waterfall', $favorite , true);
			exit;
		}
		
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
		
		$data['tpl_waterfall'] = $this->load->view('common/waterfall', $favorite, true);
		$this -> output("common/layout", array('body'=>'profile/favorites'),$data);
	}
	//关注的人
	public function following(){
		//页面级JS
    	$this->data['page_js'] = array(  		
    		base_url('assets/js/tupu.action.js'),
    	);
    	//页面级CSS
    	$this->data['page_css'] = array(
    	);
    	//var_dump($this->uri->segment(4));exit;
		$this -> load -> model('follow_model');
		//$page = intval($this->uri->segment(4));
		$page =  intval($this->input->get('page',true));
		//var_dump($page);exit;
		if($page < 1) $page = 1;
		$data['followings'] = $this -> follow_model -> get_following_by_uid($this -> data['_user'] -> user_id , ($page - 1)*12 , 12);
		//如果登录用户，获取当前用户与用户列表的关注状态
		$this->load->library('pagination');
		$config['per_page'] = 12;
		$config['total_rows'] = $this -> follow_model -> get_friends_count($this -> data['_user'] -> user_id) -> total_friends;
		$config['base_url'] = site_url('u/'.$this -> data['_user'] -> user_id.'/following?');
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
		//var_dump($pages);exit;
		if ($this -> data['sess_userinfo'] && is_array($data['followings'])) {
			foreach ($data['followings'] as $k => $v){
				$data['followings'][$k] -> relation = $this -> follow_model -> get_relation($this -> data['sess_userinfo']['uid'] , $v -> user_id);
			}
		}
		$data['tpl_right'] = $this->load->view('profile/profile_right', $this -> data, true);
		$this -> output("common/layout", array('body'=>'profile/following'),$data);
	}
	//粉丝
	public function follower(){
		//页面级JS
    	$this->data['page_js'] = array(  		
    		base_url('assets/js/tupu.action.js'),
    	);
    	//页面级CSS
    	$this->data['page_css'] = array(
    	);
    	
    	$this -> load -> model('follow_model');
		//$page = intval($this->uri->segment(4));
		$page =  intval($this->input->get('page',true));
		if($page < 1) $page = 1;
		$data['followers'] = $this -> follow_model -> get_follower_by_uid($this -> data['_user'] -> user_id , ($page - 1)*12 , 12);
    	
		$this->load->library('pagination');
		$config['per_page'] = 12;
		$config['total_rows'] = $this -> follow_model -> get_fans_count($this -> data['_user'] -> user_id) -> total_fans;
		$config['base_url'] = site_url('u/'.$this -> data['_user'] -> user_id.'/follower?');
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
		
		//如果登录用户，获取当前用户与用户列表的关注状态
		if ($this -> data['sess_userinfo'] && is_array($data['followers'])) {
			foreach ($data['followers'] as $k => $v){
				$data['followers'][$k] -> relation = $this -> follow_model -> get_relation($this -> data['sess_userinfo']['uid'] , $v -> user_id);
			}
		}
		$data['tpl_right'] = $this->load->view('profile/profile_right', $this -> data, true);
		$this -> output("common/layout", array('body'=>'profile/follower'),$data);
	}

	public function item_list()
	{
		$this->output("common/layout", array('body'=>'profile/item'),$data);
	}
	
	public function friend_follow(){
		
		$this->output("common/layout", array('body'=>'profile/friend_follow'),$data);
	}
}

