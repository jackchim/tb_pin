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
class Discovery extends MY_Controller {
	

	 //当前页数
	 var $page = 1;
	 
	 /**
	  * 构造函数，初使化当前Controller公共环境
	  * 
	  * @access public
	  * @return void
	  */
	 public function __construct() {
		
		parent::__construct();
		
		//当前页面激活的菜单
		$this->data['active_menu'] = 'discovery';

    	//页面级JS
    	$this->data['page_js'] = array(
	    	base_url('assets/js/jquery.masonry.min.js'),
    		base_url('assets/js/jquery.infinitescroll.min.js'),
    		base_url('assets/js/tupu.waterfall.js'),
    		base_url('assets/js/tupu.action.js'),
    		base_url('assets/js/jquery.form.js'),
    		base_url('assets/js/jMyCarousel/jMyCarousel.js'),
    	);
    	
    	//页面级CSS
    	$this->data['page_css'] = array(
    		base_url('assets/js/jMyCarousel/jMyCarousel.css'),
    	);


		//载入数据模型
		$this->load->model('tag_model');
		$this->load->model('share_model');
    	$this->load->model('category_model');


		//当前页数,如果是 /category/xxxx/tags/xxxx/2 这样的地址，需要特殊处理
		$page = ($this->uri->segment(3) == 'tags') ? $this->uri->segment(5) : $this->uri->segment(3);
    	$this->page = max(1,intval($page));

		//获取分类参数,如果为 'index'，则是 index 方法，而非分类名
		$category_name_en = $this->uri->segment(2);

		//生成标签组
		if($this->page == 1){
			$tags['cates'] = $this->category_model->get_categories();
			//生成分类下的标签组，当分类名为 'index' 时，不生成
			if($category_name_en != 'index'){
				$tags['tag_group'] = $this->tag_model->fetch_tags_with_category($category_name_en);
				$tags['tag_url_pre'] = 'category/'.$category_name_en.'/';
			}
			$tags['theme_url'] = $this->data['theme_url'];
			$this->data['tpl_tags'] = $this->load->view('common/tags', $tags, true);
		}



    }
    
    
    /**
     * 发现页面，全部内容
     * 查询所有已审核的数据，按热度进行排序
     * @access public
     * @return void
     */
    public function index(){

    	$this->load->model('share_model');
    	$category_share = array();
    	$category_share = $this->share_model->get_top_category_share();
    	//var_dump($category_share);exit;
    	$data['category_share'] = $category_share;
		//瀑布流查询条件
    	$conditions = array();
    	//$conditions['timeline']['start'] = date('Y-m-d',mktime() - 14*3600*24);
		$data['next_page_url'] = 'discovery/index/2';
		
    	//瀑布流
		$conditions['order_by'] = 'tupu_share.total_comments desc,tupu_share.total_forwarding desc,tupu_share.total_likes desc';
    	$share['shares'] = $this->share_model->fetch_shares_with_item(($this->page - 1) * 10,10,$conditions);
		
    	
    	
		//模版输出
    	$share['theme_url'] = $this -> data['theme_url'];
    	$share['is_admin'] = $this -> data['is_admin'];
		$data['tpl_waterfall'] = $this->load->view('common/waterfall', $share, true);
		
    	$this->output("common/layout", array('body'=>'discovery/index'),$data);

    }
    


    /**
     * 发现页面，某分类内容
     * 
     * @access public
     * @return void
     */
    public function category(){
    
		//获取 Get 参数
		$category_name_en = $this->uri->segment(2);
		$data['next_page_url'] = 'category/'.$category_name_en.'/2';
		//var_dump($category_name_en);exit;
		//瀑布流查询条件
    	$conditions = array();
		$conditions['category_name_en'] = $category_name_en;
		
		if($this->uri->segment(3) == 'tags'){
			$tags_name = urldecode($this->uri->segment(4));
			//强制转换编码
			$tags_name = (is_gb2312($tags_name)) ?get_gb_to_utf8($tags_name) : $tags_name;
			
			$this->load->library('segment');
			$conditions['keyword'] = $this->segment->convert_to_py($tags_name);
			$data['next_page_url'] = 'category/'.$category_name_en.'/tags/'.$tags_name.'/2';
			$title_tag = $tags_name.' - ';
		}


    	//瀑布流
		$conditions['order_by'] = 'tupu_share.total_comments desc,tupu_share.total_forwarding desc,tupu_share.total_likes desc';
    	$share['shares'] = $this->share_model->fetch_shares_with_item(($this->page - 1) * 10,10,$conditions);
		
		//模版输出
    	$share['theme_url'] = $this -> data['theme_url'];
    	$share['is_admin'] = $this -> data['is_admin'];
		$data['tpl_waterfall'] = $this->load->view('common/waterfall', $share, true);
		//var_dump($conditions);exit;
		$this -> load -> model('category_model');
		$cate = $this -> category_model -> get_category_by_enname($category_name_en);
		//var_dump($cate);exit;
		$data['seo_set']['seo_title'] = $title_tag.$cate -> category_name_cn;
		$data['seo_set']['seo_keywords'] =$tags_name.' '.$cate -> category_name_cn;
		$data['seo_set']['seo_description'] = $tags_name.' '.$cate -> category_name_cn;
		
    	$this->output("common/layout", array('body'=>'discovery/index'),$data);

    }


    /**
     * 发现页面，搜索和标签方法
     * 点击Tag和进行站内搜索时，采用此方法
     * @access public
     * @return void
     */
    public function search(){
    
		//获取 Get 参数
		$keyword = urldecode($this->uri->segment(2));
		
		$keyword = (is_gb2312($keyword)) ?get_gb_to_utf8($keyword) : $keyword;
		//载入中文切词库
		$this->load->library('segment');
		
		//查询条件：跟据关键字全文检索
		$conditions = array();
		$conditions['keyword'] = $this->segment->convert_to_py($keyword);
		//var_dump($conditions['keyword']);exit;
		//瀑布流
		$conditions['order_by'] = 'tupu_share.total_comments desc,tupu_share.total_forwarding desc,tupu_share.total_likes desc';
		$share['shares'] = $this->share_model->fetch_shares_with_item(($this->page - 1) * 10,10,$conditions);
		$share['is_admin'] = $this -> data['is_admin'];
		//模版输出
		$data['tpl_waterfall'] = $this->load->view('common/waterfall', $share, true);
		$data['next_page_url'] = 'search/'.$keyword.'/2';
		
		//seo设置
		$data['seo_set']['seo_title'] = $keyword;
		$data['seo_set']['seo_keywords'] = $keyword;
		$data['seo_set']['seo_description'] = $keyword;
				
		$this->output("common/layout", array('body'=>'discovery/index'),$data);

    }



    
}