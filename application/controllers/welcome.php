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
 * AiTuPu Discover Controller
 *
 *
 * @package		AiTuPu
 * @subpackage	Controllers 
 * @category	Controllers
 * @author		Duobianxing Studio Dev Team
 * @link		http://duobianxing.com/doc/index.html
 */
class Welcome extends MY_Controller {

	 public function __construct() {
		
		parent::__construct();
		
		//当前页面激活的菜单
		$this->data['active_menu'] = 'welcome';
		
		//页面级JS
    	$this->data['page_js'] = array(
	    	base_url('assets/js/jquery.masonry.min.js'),
    		base_url('assets/js/jquery.infinitescroll.min.js'),
    		base_url('assets/js/tupu.waterfall.js'),    		
    		base_url('assets/js/tupu.action.js'),
    		base_url('assets/js/jquery.form.js'),
    		base_url("assets/js/slide/slidedeck.jquery.lite.js"),
    		//base_url('assets/js/slide/jquery.mousewheel.min.js'),
    	);
    	//页面级CSS
    	$this->data['page_css'] = array(
    	base_url('assets/js/slide/slidedeck.skin.css'),
    	);
    	
		//当前页数
    	$this->page = $this->uri->segment(3);
    	$this->page = max(1,intval($this->page));

    	//载入数据模型
    	$this->load->model('category_model');
    	$this->load->model('share_model');
    	$this->load->model('album_model');
    	$this -> load -> model('user_model');
		
		//左侧slide
		$slide['theme_url'] = $this->data['theme_url'];
		$slide['sess_userinfo'] = $this->data['sess_userinfo'];
		$this->data['tpl_slide'] = $this->load->view('common/slide', $slide, true);
    }
    
    public function index(){
    	//瀑布流
    	$this->load->model("advert_model");
    	$this->load->model("favorite_share_model");
    	$conditions = $advers = $favorites =  array();
    	$data['next_page_url'] = 'welcome/index/2';
    	
    	//$conditions['in_public_page'] = true;  //为演示效果，暂时关闭此条件
		$conditions['order_by'] = 'tupu_share.total_comments desc,tupu_share.total_forwarding desc,tupu_share.total_likes desc';
    	$share['shares'] = $this->share_model->fetch_shares_with_item(($this->page - 1) * 10,10,$conditions);
		$advers = $this->advert_model->getAdvByIndex(0,5);
		$favorites = $this->favorite_share_model->get_favorite_common_shares(0,16);
		//模版输出
		$share['login_uid'] = $this -> data['sess_userinfo']['uid'];
    	$share['theme_url'] = $this -> data['theme_url'];
    	$share['is_admin'] = $this -> data['is_admin'];
		$data['tpl_waterfall'] = $this->load->view('common/waterfall', $share, true);
		$data['advers'] = $advers;
		$data['favorites'] = $favorites;
		//var_dump($favorites);
		
		//获取分类
		$cates = $this -> category_model -> get_categories();
		if (is_array($cates)) {
			foreach ($cates as $k => $cate){
				$cates[$k] -> albums = $this -> album_model -> get_albums_by_cate($cate -> category_id);
				$cates[$k] -> all_count = $this -> share_model -> count_shares_by_cate($cate -> category_id);
				$cates[$k] -> last_count = $this -> share_model -> count_shares_by_cate($cate -> category_id , 30);
			}
		}
		$data['cates'] = $cates;
		
		$top_users = $this -> user_model -> top_users(20);
		//var_dump($top_users);exit;
		$data['top_users'] = $top_users;
		
    	$this->output("common/layout", array('body'=>'welcome/index'),$data);
    	
    }
    
    
    

    /**
     * 发现页面，最新内容
     * 
     * @access public
     * @return void
     */
    public function lastest(){
    
		//瀑布流查询条件
    	$conditions = array();
		$data['next_page_url'] = 'welcome/lastest/2';

    	//瀑布流
		$conditions['order_by'] = 'tupu_share.share_id desc';
    	$share['shares'] = $this->share_model->fetch_shares_with_item(($this->page - 1) * 10,10,$conditions);
		
		//模版输出
    	$share['theme_url'] = $this -> data['theme_url'];
    	$share['is_admin'] = $this -> data['is_admin'];
		$data['tpl_waterfall'] = $this->load->view('common/waterfall', $share, true);
    	$this->output("common/layout", array('body'=>'welcome/index'),$data);

    }


    /**
     * 发现页面，最热内容
     * 
     * @access public
     * @return void
     */
    public function popular(){
    
		//瀑布流查询条件
    	$conditions = array();
		$data['next_page_url'] = 'welcome/popular/2';

    	//瀑布流
		$conditions['order_by'] = 'tupu_share.total_comments desc,tupu_share.total_forwarding desc,tupu_share.total_likes desc';
    	$share['shares'] = $this->share_model->fetch_shares_with_item(($this->page - 1) * 10,10,$conditions);
		
		//模版输出
    	$share['theme_url'] = $this -> data['theme_url'];
    	$share['is_admin'] = $this -> data['is_admin'];
		$data['tpl_waterfall'] = $this->load->view('common/waterfall', $share, true);
    	$this->output("common/layout", array('body'=>'welcome/index'),$data);

    }

    
}