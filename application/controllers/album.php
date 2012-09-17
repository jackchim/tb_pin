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
 * AiTuPu Tag Controller
 *
 *
 * @package		AiTuPu
 * @subpackage	Controllers
 * @album	Controllers
 * @author		Duobianxing Studio Dev Team
 * @link		http://duobianxing.com/doc/index.html
 */
//专辑
class Album extends MY_Controller {

	public function __construct() {

		parent::__construct();
	}
	
	public function index(){
		//获取全站的相册，按照更新时间倒序显示
		$page = intval($this->uri->segment(3));
		if($page < 1) $page = 1;
		$conditions = array();
		$conditions['total_share'] = true;
		$this -> load -> model('album_model');
		//$conditions['is_show'] = 1;
		$conditions['order_by'] = "tupu_album.total_share desc , tupu_album.update_time desc";
		$albums['albums'] = $this->album_model->get_albums(($page - 1) * 10,10,$conditions);
		//var_dump($albums);exit;
		$albums['login_uid'] = $this -> data['sess_userinfo']['uid'];
		$albums['theme_url'] = $this -> data['theme_url'];		
		$albums['is_admin'] = $this -> data['is_admin'];	
		if ($page > 1) {
			echo $this->load->view('common/album', $albums, true);
			exit;
		}else {
			$data['tpl_album'] = $this->load->view('common/album', $albums, true);
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
		
		$this->output("common/layout", array('body'=>'album/index'),$data);
	}
	//相册的分享列表
	public function shares(){
		$album_id = intval($this->uri->segment(3));
		if ($album_id < 1) {
			show_404('页面不存在');
		}
		
		$page = intval($this->uri->segment(4));
		if($page < 1) $page = 1;
		$this -> load -> model('share_model');
		$share['shares'] = $this -> share_model -> get_shares_page_by_album_id($album_id ,($page-1)*12 , 12);
		//var_dump($share['shares']);exit;
		//模版输出
    	$share['theme_url'] = $this -> data['theme_url'];    	
    	$share['login_uid'] = $this -> data['sess_userinfo']['uid'];
    	$share['is_admin'] = $this -> data['is_admin'];  
    	if ($page > 1) {
    		echo $this->load->view('common/waterfall', $share, true);
    		exit;
    	}
		$data['tpl_waterfall'] = $this->load->view('common/waterfall', $share, true);
		
		$data['album_id'] = $album_id;
		
		$this -> load -> model('album_model');
		$album['album'] = $this -> album_model -> get_album_info($album_id);
		//var_dump($album);exit;
		$data['tpl_album_slide'] = $this->load->view('common/album_slide', $album, true);
		//var_dump($album['album']);exit;
		$data['seo_set']['seo_title'] =$album['album'] -> nickname.' - '. $album['album'] -> title;
		$data['seo_set']['seo_keywords'] = $album['album'] -> title;
		$data['seo_set']['seo_description'] = $album['album'] -> title;
		
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
		
		$this->output("common/layout", array('body'=>'album/shares'),$data);
	}
}