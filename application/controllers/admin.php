<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//后台管理界面 
class Admin extends MY_Controller {

	public function __construct() {
		
		parent::__construct();
		$this->load->set_admin_theme();
	}

	function check_admin()
	{
		if(!$this->is_admin())
		{
			redirect('admin/login');
		}
	}

	function is_admin()
	{
		
		if($this->data['sess_userinfo']['uid']&&$this->data['sess_userinfo']['user_type']==3){
			return true;
		}else {
			return false;
		}
	}

	public function index()
	{
		$this->check_admin();
		$this->load->view('admin/index', $this->data, false);
	}

	public function login()
	{
		
		
		if($this->input->post()){
			
			$email = $this->input->post('email',true);

			$password = md5($this->input->post('password',true));
			$user = $this->user_model->get_full_user_by_email($email);
			
			if($user){
				if( $user->passwd == $password){
					$this->user_model->set_usersession($user,false);
					redirect('admin/index' , 'refresh');
					return true;
				}else{
					$data['msg'] = '账号与密码不符，登录失败';
					$this->load->view('admin/login', $data, false);
					return false;
				}
			}else{
				$data['msg'] = '账号不存在';
				$this->load->view('admin/login', $data, false);
				//redirect('admin/login');
				return false;
			}
		}else{
			$this->load->view('admin/login', array(), false);
		}

	}

	public function logout()
	{
		$this->check_admin();
		$this->user_model->remove_usersession();
		redirect('admin/login');
	}

	public function dashboard()
	{
		$this->check_admin();
		$data = $sum =  array();//用到的数据
		$this->load->model("category_model");
		$this->load->model("user_model");
		$this->config->load('custom',TRUE);
		$custom =  $this->config->item('custom');
		$version = $custom['version'];
		$version_arr  = str_split($version,1);
		$version = 'V'.implode('.',$version_arr);
		$share_count=$this->category_model->count_conduct_share();//统计全站商品图数量
		$user_count=$this->user_model->count_user_sub();
		$count_dir=$custom['version_info']['mem_count'];//统计的目录
		$dirsize=$this->user_model->count_dir_size($count_dir);	
		$dirsize=$this->user_model->exchange_byte($dirsize);
		$sum = $this->count_user_behavior();//统计代码，工具函数
		
		$data['share_count']=$share_count;
		$data['user_count']=$user_count;
		$data['attchment_size']=$dirsize;
		$data['version'] = $version;
		$data['sum'] = $sum;
		$this->load->view('admin/dashboard', $data, false);
	}

	public function setting_basic()
	{
		$this->check_admin();
		
		$this->config->load('custom',TRUE);
		$custom =  $this->config->item('custom');
		if($this->input->post()){
			$custom['site_info'] =  array(
										 'site_name'=> $this->input->post('site_name'),
										 'site_domain'=> $this->input->post('site_domain')
			);
			$this->config->set_item('custom',$custom);
			$this->config->save('custom');
			echo 1;
			exit;
		}
		$data['site_info'] = $custom['site_info'];
		$data['tpl_setting_header'] = $this->load->view('admin/setting_header', $data, true);
		$this->load->view('admin/setting_basic', $data, false);
	}
	/**
	 * 设置邮箱服务器
	 */
	public function setting_mailservice(){
		$this->check_admin();
		
		$this->config->load('custom',TRUE);
		$custom =  $this->config->item('custom');
		if($this->input->post()){
			$custom['mail_server'] =  array(
										 'protocol'=> $this->input->post('protocol'),
										 'from'=> $this->input->post('from'),
										 'sender'=> $this->input->post('sender'),
										 'smtp_host'=> $this->input->post('smtp_host'),
										 'smtp_user'=> $this->input->post('smtp_user'),
										 'smtp_pass'=> $this->input->post('smtp_pass'),
										 'smtp_port'=> $this->input->post('smtp_port'),
			);
			$this->config->set_item('custom',$custom);
			$this->config->save('custom');
			echo 1;
			exit;		
		}
		$data['mail_server'] = $custom['mail_server'];
		
		$data['settings'] = $settings;		
		$data['tpl_setting_header'] = $this->load->view('admin/setting_advance_header', $data, true);
		
		$this->load->view('admin/setting_mailservice', $data, false);
	}
	public function setting_seo()
	{
		$this->check_admin();

		$this->config->load('custom',TRUE);
		$custom =  $this->config->item('custom');
		if($this->input->post()){
			$custom['seo'] =  array(
									 'page_title'=> $this->input->post('page_title'),
									 'keyword'=> $this->input->post('keyword'),
									 'description'=> $this->input->post('description')
			);
			$this->config->set_item('custom',$custom);
			$this->config->save('custom');
			echo 1;
			exit;
		}
		$data['seo'] = $custom['seo'];
		$data['tpl_setting_header'] = $this->load->view('admin/setting_header', $data, true);
		$this->load->view('admin/setting_seo', $data, false);
	}
	
	/**
	 * 敏感词过滤
	 * @author Cai Shengpeng
	 */
	public function setting_badword(){
		$this->check_admin();
		
		$this -> config ->load('user_badword',TRUE);
		$badword =  $this -> config -> item('user_badword');
		if ($this -> input -> post()) {
			$input = $this -> input -> post('badword');
			
			$badword['badword'] = $input;
			$this -> config -> set_item('user_badword',$badword);
			$this -> config -> save('user_badword');
			echo 1;
			exit;
		}
		
		$data = $badword;
		$data['tpl_setting_header'] = $this->load->view('admin/setting_header', $data, true);
		$this->load->view('admin/setting_badword', $data, false);
	}
	/**
	 * 模板设置
	 */
	public function setting_theme(){
		$this->check_admin();
		
		$this -> config ->load('custom',TRUE);
		$custom = $this -> config -> item('custom');
		$data['theme'] = $custom['theme'];
		
		if ($this -> input -> post('theme')) {
			$custom['theme'] = $this -> input -> post('theme');
			$this->config->set_item('custom',$custom);
			$this->config->save('custom');
			echo 1;
			exit;
		}
		
		$this -> config ->load('themes',TRUE);
		$themes =  $this -> config -> item('themes');
		$data['themes'] = $themes;
		
		
		//var_dump($theme['theme']);exit;
		$data['tpl_setting_header'] = $this->load->view('admin/setting_header', $data, true);
		$this->load->view('admin/setting_theme', $data, false);
	}
	/**
	 * logo设置
	 */
	public function setting_logo(){
		$this -> config ->load('custom',TRUE);
		$custom = $this -> config -> item('custom');
		$data['logo'] = $custom['logo'];
		
		if ($this -> input -> post('logo_file')) {
			$custom['logo'] = $this -> input -> post('logo_file');
			if ($custom['tmp_logo'] == $custom['logo']) {
				unset($custom['tmp_logo']);
			}
			if ($data['logo'] != $custom['logo']) {
				unlink($data['logo']);
			}
			$this->config->set_item('custom',$custom);
			$this->config->save('custom');
			echo 1;
			exit;
		}
		//$data = array();
		$data['tpl_setting_header'] = $this->load->view('admin/setting_header', $data, true);
		$this->load->view('admin/setting_logo', $data, false);
	}
	public function upload_logo(){
		$config['allowedExtensions'] = array("jpeg", "png", "jpg" , 'gif');
		$config['sizeLimit'] = 10 * 1024 * 1024;
		$this->load->library('QqFileUploader' , $config , 'uploader');
		$result = $this -> uploader  -> handleUpload('data/logo/');
		if ($result['success']) {
			
			$this -> config ->load('custom',TRUE);
			$custom = $this -> config -> item('custom');
			$custom['tmp_logo'] = $result['file'];
			$this->config->set_item('custom',$custom);
			$this->config->save('custom');
			
			$result['file_full_url'] = base_url($result['file']);
		}
		
		
		echo json_encode($result);
		exit;
	}
	
	/**
	 * seo高级设置
	 * @author Cai Shengpeng
	 */
	public function setting_advance_seo(){
		$this->check_admin();
		
		$this->config->load('seo_setting',TRUE);
		$settings =  $this->config->item('seo_setting');
		if($this->input->post()){
			//var_dump($this->input->post());exit;
			foreach ($this->input->post() as $k => $v){
				$settings[$k] =  $v;
			}
			$this->config->set_item('seo_setting',$settings);
			$this->config->save('seo_setting');
			echo 1;
			exit;
		}
		$data['settings'] = $settings;		
		$data['tpl_setting_header'] = $this->load->view('admin/setting_advance_header', $data, true);
		
		$this->load->view('admin/setting_advance_seo', $data, false);
	}
	
	/**
	 * ucenter设置
	 * @author Cai Shengpeng
	 */
	public function setting_ucenter(){
		$this->check_admin();
		
		$this->config->load('ucenter',TRUE);
		$ucenter =  $this->config->item('ucenter');
		if($this->input->post()){
			//var_dump($this->input->post());exit;
			foreach ($this->input->post() as $k => $v){
				$settings[$k] =  $v;
			}
			$ucenter = array(
				'is_active' => intval($this -> input -> post('is_active')),
				'uc_host'   => $this -> input -> post('uc_host'),
				'uc_dbuser'   => $this -> input -> post('uc_dbuser'),
				'uc_dbpw'   => $this -> input -> post('uc_dbpw'),
				'uc_dbname'   => $this -> input -> post('uc_dbname'),
				'uc_dbcharset'   => $this -> input -> post('uc_dbcharset'),
				'uc_dbtablepre'   => $this -> input -> post('uc_dbtablepre'),
				'uc_key'   => $this -> input -> post('uc_key'),
				'uc_api'   => $this -> input -> post('uc_api'),
				'uc_apiid'   => $this -> input -> post('uc_apiid'),
			);
			$this -> config -> set_item('ucenter',$ucenter);
			$this -> config -> save('ucenter');
			echo 1;
			exit;
		}
		$data['ucenter'] = $ucenter;
		
		$data['tpl_setting_header'] = $this->load->view('admin/setting_advance_header', $data, true);
		
		$this->load->view('admin/setting_ucenter', $data, false);
	}
	
	
	public function setting_file()
	{
		$this->check_admin();

		$this->config->load('custom',TRUE);
		$custom =  $this->config->item('custom');
		if($this->input->post()){
			$custom['file'] =  array(
									 'upload_file_size'=> $this->input->post('upload_file_size'),
									 'upload_file_type'=> $this->input->post('upload_file_type'),
									 'upload_image_size_h'=> $this->input->post('upload_image_size_h'),
									 'upload_image_size_w'=> $this->input->post('upload_image_size_w'),
									 'fetch_image_size_h'=> $this->input->post('fetch_image_size_h'),
									 'fetch_image_size_w'=> $this->input->post('fetch_image_size_w')
			);
			$this->config->set_item('custom',$custom);
			$this->config->save('custom');
			echo 1;
			exit;
		}
		$data['file'] = $custom['file'];
		$data['tpl_setting_header'] = $this->load->view('admin/setting_header', $data, true);
		$this->load->view('admin/setting_file', $data, false);
	}


	public function setting_api()
	{
		$this->check_admin();

		$this->config->load('custom',TRUE);
		$custom =  $this->config->item('custom');
		if($this->input->post()){
			$custom['api'] =  array(
							 'Sina'=> array('APPKEY'=>$this->input->post('sina_appkey'),
							 				'APPSECRET'=>$this->input->post('sina_appsecret')
							 				),
							 'QQ'=> array('APPKEY'=>$this->input->post('qq_appkey'),
							 				'APPSECRET'=>$this->input->post('qq_appsecret')
							 				),
							 'Renren'=> array('APPKEY'=>$this->input->post('renren_appkey'),
							 				'APPSECRET'=>$this->input->post('renren_appsecret')
							 				),
							 'Taobao'=> array('APPKEY'=>$this->input->post('taobao_appkey'),
							 				'APPSECRET'=>$this->input->post('taobao_appsecret'),
							 				'PID'=>$this->input->post('taobao_pid')
							 				)
							);
			$this->config->set_item('custom',$custom);
			$this->config->save('custom');
			echo 1;
			exit;
		}
		$data['api'] = $custom['api'];
		$data['settings'] = $settings;		
		$data['tpl_setting_header'] = $this->load->view('admin/setting_advance_header', $data, true);
		$this->load->view('admin/setting_api', $data, false);
	}



	public function user_list()
	{
		$this->check_admin();
		$action = $this->uri->segment(3);
		$user_id = $this->uri->segment(4);
		if($user_id){
			$user = $this->user_model->get_user_by_uid($user_id);
		}
		$this->load->library('pagination');
		if($action=='delete'&&$user){
			$this->user_model->flag_user_del($user_id);
			redirect('admin/user_list');
			return;
		}else if($action=='edit'&&$user){
			if($this->input->post()){
				if($this->input->post('passwd',true))
				$data['passwd'] = md5($this->input->post('passwd',true));
				$data['is_active'] = $this->input->post('is_active',true);
				$data['user_type'] = $this->input->post("user_type",true);
				if (!$data['user_type']) {
					unset($data['user_type']);//防止误用
				}
				$this->user_model->edit_user($user_id,$data);
				redirect('admin/user_list');
				return;
			}else{
				$this->load->view('admin/user_edit', array('user'=>$user), false);
				return;
			}
		}else if($action=='search'){
			if($this->input->get()){
				$data['is_active'] = $this->input->get('is_active',true);
				$nickname = $this->input->get('nickname',true);
				if($nickname){
					$data['nickname'] = $nickname;
					$nickname_query = '&nickname='.$nickname;
				}
				if($data['is_active']!=false) {
					$is_active_query = '&is_active='.$data['is_active'];
				}
				$page =  $this->input->get('page',true);
				if(!$page)$page = 1;
				$config['per_page'] = 10;
				$config['total_rows'] = $this->user_model->count_user($data);
				$config['base_url'] = site_url('admin/user_list/search?'.$nickname_query.$is_active_query);
				$config['use_page_numbers'] = TRUE;
				$config['page_query_string'] = TRUE;
				$config['query_string_segment'] = 'page';
				$config['full_tag_open'] = '<p class="pagination">&nbsp;';
				$config['cur_tag_open'] = '<a style="background:#eee">';
				$config['cur_tag_close'] = '</a>';
				$config['full_tag_close'] = '</p>';
				$config['first_link'] = '首页';
				$config['last_link'] = '尾页';
				$this->pagination->initialize($config);
				$pages = $this->pagination->create_links();
				$users = $this->user_model->search_user(($page - 1)*$config['per_page'],$config['per_page'],$data);
				$this->load->view('admin/user_list', array('users'=>$users,'pages'=>$pages), false);
				return;
			}
		}else{
			$page = $this->uri->segment(3);
			if(!$page)$page = 1;
	
			$config['per_page'] = 10;
			$config['total_rows'] = $this->user_model->count_user();
			$config['base_url'] = site_url('admin/user_list');
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<p class="pagination">&nbsp;';
			$config['cur_tag_open'] = '<a style="background:#eee">';
			$config['cur_tag_close'] = '</a>';
			$config['full_tag_close'] = '</p>';
			$config['first_link'] = '首页';
			$config['last_link'] = '尾页';
			$this->pagination->initialize($config);
			$pages = $this->pagination->create_links();
			$users = $this->user_model->search_user(($page - 1)*$config['per_page'],$config['per_page']);
			$users=$this->check_forbidden($users);
			$this->load->view('admin/user_list', array('users'=>$users,'pages'=>$pages), false);
		}
	}


	public function item_list()
	{
		$this->check_admin();
		$action = $this->uri->segment(3);
		$item_id = $this->uri->segment(4);
		$this->load->library('pagination');
		$this->load->model('item_model');
		if($item_id){
			$item = $this->item_model->get_item_by_id($item_id);
		}

		/**
		 * 图片审核，默认用户发表时显示is_show 为0,1是通过审核，2，是屏蔽
		 */
		if($action=='delete'&&$item){
			$this->item_model->del_item($item_id);
			redirect('admin/item_list');
			return;
		}else if($action=='verify'&&$item){
			$this->item_model->edit_item($item_id,array('is_show'=>1));
			redirect('admin/item_list');
			return;
		}else if($action=='deverify'&&$item){
			$this->item_model->edit_item($item_id,array('is_show'=>2));
			redirect('admin/item_list');
			return;
		}else if($action=='search'){
			
			if($this->input->get()){
				$data['is_show'] = $this->input->get('is_show',true);
				$keyword = $this->input->get('keyword',true);
				if($keyword){
					$this->load->library('segment');
					//$data['keyword'] = $this->segment->convert_to_py($keyword);
					$data['key'] = $keyword;
					$keyword_query = '&keyword='.$keyword;
				}
				if($data['is_show']==0||$data['is_show']==1) {
					$is_show_query = '&is_show='.$data['is_show'];
				}
				//var_dump($data);exit;
				$page =  $this->input->get('page',true);
				if(!$page)$page = 1;
				$config['per_page'] = 15;
				$config['total_rows'] = $this->item_model->count_item($data);
				//var_dump($config['total_rows']);exit;
				$config['base_url'] = site_url('admin/item_list/search?'.$keyword_query.$is_show_query);
				$config['use_page_numbers'] = TRUE;
				$config['page_query_string'] = TRUE;
				$config['full_tag_open'] = '<p class="pagination">&nbsp;';
			  	$config['cur_tag_open'] = '<a style="background:#eee">';
				$config['cur_tag_close'] = '</a>';
				$config['full_tag_close'] = '</p>';
				//$config['display_pages'] = FALSE;
				$config['first_link'] = '首页';
				$config['last_link'] = '尾页';
				$config['query_string_segment'] = 'page';
				$this->pagination->initialize($config);
				$pages = $this->pagination->create_links();
				$items = $this->item_model->search_item(($page - 1)*$config['per_page'],$config['per_page'],$data);
				$this->load->view('admin/item_list', array('items'=>$items,'pages'=>$pages,'is_show'=>true), false);
				return;
			}
		}else{
			$page = $this->uri->segment(3);
			if(!$page)$page = 1;

			$config['per_page'] = 15;
			$config['total_rows'] = $this->item_model->count_item();
			$config['base_url'] = site_url('admin/item_list');
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<p class="pagination">&nbsp;';
			$config['cur_tag_open'] = '<a style="background:#eee;">';
			$config['cur_tag_close'] = '</a>';
			$config['full_tag_close'] = '</p>';
			//$config['display_pages'] = FALSE;
			$config['first_link'] = '首页';
			$config['last_link'] = '尾页';
			$this->pagination->initialize($config);
			$pages = $this->pagination->create_links();		
			$items = $this->item_model->search_item(($page - 1)*$config['per_page'],$config['per_page']);
			$this->load->view('admin/item_list', array('items'=>$items,'pages'=>$pages), false);
		}
	}
	
	public function category_list()
	{
		$this->check_admin();
		$action = $this->uri->segment(3);
		$category_id = $this->uri->segment(4);
		$this->load->model('category_model');
		if($category_id){
			$category = $this->category_model->get_category($category_id);
		}
		$this->load->model('category_model');
		if($action=='delete'&&$category){
			$this->category_model->del_category($category_id);
			redirect('admin/category_list');
			return;
		}else if($action=='edit'&&$category){
			if($this->input->post()){
				$this->load->library("pinyin");
				$data['category_name_cn'] = $this->input->post('category_name_cn',true);
				$data['category_name_en']=trim($this->pinyin->convert($data['category_name_cn'],'utf-8',true));
			    if (empty($data['category_name_en'])) {
			 	 $data['category_name_en']=$data['category_name_cn'];
			    }
				$this->category_model->edit_category($category_id,$data);
				redirect('admin/category_list');
				return;
			}else{
				$this->load->view('admin/category_edit', array('category'=>$category), false);
				return;
			}
		}else if($action=='add'){
			$data['category_name_cn'] = $this->input->post('category_name_cn',true);
			$this->load->library("pinyin");
			$data['category_name_en']=trim($this->pinyin->convert($data['category_name_cn'],'utf-8',true));
			if (empty($data['category_name_en'])) {
				$data['category_name_en']=$data['category_name_cn'];
			}
			$this->category_model->add_category($data);
			redirect('admin/category_list');
			return;
		}else{
			$categories = $this->category_model->get_categories();
			$this->load->view('admin/category_list', array('categories'=>$categories), false);
			return;
		}
	}

	public function tag_list()
	{
		$this->check_admin();
		$action = $this->uri->segment(3);
		$tag_id = $this->uri->segment(4);
		$this->load->model('tag_model');
		if($tag_id){
			$tag = $this->tag_model->get_tag($tag_id);
		}

		$this->load->model('category_model');
		$categories = $this->category_model->get_categories();

		if($action=='delete'&&$tag){
			$this->tag_model->del_tag($tag_id);
			redirect('admin/tag_list');
			return;
		}else if($action=='edit'&&$tag){
			if($this->input->post()){
				$data['category_id'] = $this->input->post('category_id',true);
				$data['tag_group_name_cn'] = $this->input->post('tag_group_name_cn',true);
				$data['tag_group_name_en'] = $this->input->post('tag_group_name_en',true);
				$data['display_order'] = $this->input->post('display_order',true);
				$data['tags'] = $this->input->post('tags',true);
				$this->tag_model->edit_tag($tag_id,$data);
				redirect('admin/tag_list');
				return;
			}else{
				$this->load->view('admin/tag_edit', array('tag'=>$tag,'categories'=>$categories), false);
				return;
			}
			
		}else if($action=='add'){
			$data['category_id'] = $this->input->post('category_id',true);
			$data['tag_group_name_cn'] = $this->input->post('tag_group_name_cn',true);
			$data['tag_group_name_en'] = $this->input->post('tag_group_name_en',true);
			$data['display_order'] = $this->input->post('display_order',true);
			$data['tags'] = $this->input->post('tags',true);
			$this->tag_model->add_tag($data);
			redirect('admin/tag_list');
			return;
		}else{
			$tags = $this->tag_model->fetch_tags_with_category();
			$this->load->view('admin/tag_list', array('items'=>$tags,'categories'=>$categories), false);
			return;
		}
	}
	/**
	 * @todo 后台广告管理
	 * 该动作执行广告管理广告图片之上传
	 * 并同时对图片执行缩放处理
	 */
	public function advertize(){
		$this->check_admin();//检查用户登录
		$data=$advs=$list=array();//初始化变量
		$this->load->model("advert_model");//加载广告模型
		$advs=$this->advert_model->getAdvByIndex();
		$list['advs']=$advs;
		$action = $this->uri->segment(3);
		if(!empty($action) && $action=='add'){
		$data['ad_title']=$this->input->post("ad_title",true);//广告标题
		$data['ad_url']=$this->input->post("ad_url",true);//广告url
		$data['ad_position']=$this->input->post("ad_position",true);//广告位
		$data['display_order']=$this->input->post("display_order",true);//广告order
		$config['upload_path'] = 'data/advert';//上传配置目录,没有则自动建立
		if (!file_exists($config['upload_path'])) {
			mkdir($config['upload_path'],0777);//自动建立广告目录
		}
  		$config['allowed_types'] = 'gif|jpg|png';//允许的文件类型
  		$config['max_size'] = '';//允许的文件最大尺寸
  		$config['max_width']  = '';//最大的宽度
  		$config['max_height']  = '';//最大的高度
  		$config['file_name']=date('YmdHis',time());
  		$this->load->library('upload', $config);//加载上传文件辅助类库
  		if(!$this->upload->do_upload('adfile')){
  		 $error = array('error' => $this->upload->display_errors());	//出错信息
  		 $error=array('msg'=>$error['error']);
  		 $this->load->view("admin/upload_success",$error);
  		}else{
  		$upload_info =  $this->upload->data();//插入数据库的信息
  		$data['ad_photo']=$config['upload_path'].'/'.$upload_info['file_name'];
  		/*$configs['image_library'] = 'gd2';
		$configs['source_image'] = $config['upload_path'].'/'.$upload_info['file_name'];
		$configs['create_thumb'] = TRUE;
		$configs['maintain_ratio'] = TRUE;
		$configs['width'] = 620;
		$configs['height'] = 218;
		$this->load->library('image_lib', $configs); 
		if ( $this->image_lib->resize())
		{
   			 $data['ad_photo']=$config['upload_path'].'/'.$upload_info['raw_name']."_thumb".$upload_info['file_ext'];
		}else{
  		$data['ad_photo']=$config['upload_path'].'/'.$upload_info['file_name'];
		}
		*/
  		if($this->advert_model->addNewAdv($data)){
  		$success=array('msg'=>"文件上传成功！");
  		$this->load->view("admin/upload_success",$success);
  		}else{
  		$error=array('msg'=>"文件保存失败！");
  		$this->load->view("admin/upload_success",$error);
  		}
  		}
		}else{
		$this->load->view("admin/advertize",$list);//默认页面
		}
	}
	/**
	 * @todo 专辑相册管理控制器
	 * 处理相册审核和查询功能
	 *
	 */
	public function album_list(){
		$this->check_admin();
		$action = $this->uri->segment(3);
		$this->load->model('album_model');
		$this->load->library('pagination');
		$condition=array();
		$albums=array();//专辑相册
		$keyword=$this->input->get('keyword',true);
		$assign=array();//模板分配数组
		if ($keyword) {
			$condition['keyword']=$keyword;
		}
		if ($action=='delete') {
			$album_id=intval($this->input->post('album_id',true));
		    if($this->album_model->del_album($album_id)){
		    	echo 1;//删除成功
		    }else{
		    	echo 0;//删除失败
		    }
			exit();
			
		}elseif($action=='verify'){
			$album_id=$this->input->post("album_id",true);
			$type=$this->input->post("type",true);
			$types=array(1,2);
			if(!in_array($type,$types)){
				echo 0;//错误的类型
				exit();
			}
			$set=array('is_show'=>$type);
			if($this->album_model->edit_album($album_id,$set)){
				echo 1;
			}else{
				echo 0;
			}
			exit();
			
		}else{
		/**
		 * 检查专辑相册的is_show 字段
		 * 开始创建的相册是默认0，显示
		 * 但未审核，1是通过审核 2，是
		 * 屏蔽
		 */
			$condition=$action=="search" ?array('is_show'=>0):array();
			if ($keyword) {
				$condition['keyword']=$keyword;
			}
			$page=$action=='search' ? intval($this->uri->segment(4)):intval($this->uri->segment(3));
			$page = $page <1?1:$page;
			$nums_perpage=10;//每页显示条数
		    $config['per_page'] = $nums_perpage;
		 	$config['total_rows'] = $this->album_model->count_albums($condition);
			$config['base_url'] = $action=="search" ?site_url('admin/album_list/search') :site_url('admin/album_list');
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<p class="pagination">&nbsp;';
			$config['cur_tag_open'] = '<a style="background:#eee;">';
			$config['cur_tag_close'] = '</a>';
			$config['full_tag_close'] = '</p>';
			$config['first_link'] = '首页';
			$config['last_link'] = '尾页';
		    $this->pagination->initialize($config);
			$pages = $this->pagination->create_links();//分页
			$offset=($page-1)*$config['per_page'];//偏移
			$albums=$this->album_model->get_albums($offset,$config['per_page'],$condition);
			if ($action=='search') {
				$assign['search']=1;//分配审核变量
			}
			$assign['albums']=$albums;
			$assign['pages']=$pages;
			$this->load->view("admin/album_list",$assign);
		}
	}
	
	/**
	 * @todo 宝贝批量发布
	 *
	 */
	public function item_multi_post(){
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Pramga: no-cache");

		$this->check_admin();
		$product_infos = $data =  $categories = $albums =array();//商品
		$keyword = $current_uid = '';
		//admin/item_multi_post/search/keyword/page/
		$is_submit=$this->input->post("search",true) ?true:($this->input->get("search")?true:($this->input->post("hide_val") ? true:false));
		$channel = $this->input->post("channel") ? $this->input->post("channel") : "taobao";
		$page = intval($this->input->get("page") ? $this->input->get("page"):1);
		$page = $page <1?1:$page;	
		$this->load->model("album_model");
		$this->load->model("user_model");
		$user_infos =  $this->user_model->get_usersession();
		$current_uid = $user_infos['uid'];//当前登录用户id
		$albums = $this->album_model->get_user_albums($current_uid,100);//获得当前用户所有专辑
		$data['albums'] = $albums;
		$categories = $this->channel->$data = $this->channel->get_channel_cats($channel,0);
		$categories = $categories->item_cat;// arrya object
		$data['categories'] =  $categories;
		if ($is_submit) {
			$keyword = $this->input->post("keyword",true)?$this->input->post("keyword") : ($this->input->get("keyword") ? $this->input->get("keyword",true):'');
			$keyword = $keyword=="输入要搜索的关键词" ? "" : $keyword;
			$category_id = intval($this->input->post("category",true)) ?intval($this->input->post("category",true)) :intval($this->input->get("category",true));//商品分类，
			if ($keyword) {
				$product_infos=$this->channel->get_channel_items($channel,$keyword,$category_id,$page);
				//多图处理
				if(@$product_infos->taobaoke_item){
				foreach ($product_infos -> taobaoke_item as $key => $item){
					$info = $this -> channel -> get_item($channel ,$item -> num_iid);
					$product_infos -> taobaoke_item[$key] -> item_imgs = $info['item_imgs'];
				}
				unset($item , $info);
				
				$product_infos=$product_infos->taobaoke_item;
				$data['product_infos'] = $product_infos;
				$data['keyword'] = $keyword;
				$data['category_id'] = $category_id;
				}
			}
			$next_page = $page +1;
			$build_url=http_build_query(array('page'=>$next_page,'keyword'=>$keyword,'search'=>1,'category'=>$category_id));//构建查询字符串
			$full_url=site_url("admin/item_multi_post").'/?'.$build_url;//构建click_url
			$data['click_url'] = $full_url;	
		}
		$this->load->view("admin/item_multi_post",$data);
		
	}
	/**
	 * @todo ajax 验证album批量
	 *
	 */
	public function verify_album(){
		$types=array(1,2);
		$this->check_admin();
		$type=$this->input->post("type",true);
		if (!in_array($type,$types)) {
			echo 0;//不允许的类型
			exit();
		}
		$ids=ltrim(implode(",",explode("|",$this->input->post("album_ids"))),',');//组装
		//$ids=explode('|',$this->input->post("album_ids"));
		$this->load->model("album_model");
		if($this->album_model->verify_album($type,$ids)){
			echo 1;
			exit();
		}
		echo 0;
		exit();
		//edit_album
	}
	
	/**
	 * @todo 用于ajax批量发布宝贝
	 *
	 */
	public function post_multi_items(){
		$this->check_admin();
		$item_ids = $this -> input -> post('item_select');
		if (!$item_ids) {
			$res = array('result' => 0 , 'msg' => '未选择分享的商品！请选择');
			echo json_encode($res);
			exit;
		}
		$all_items = $this -> input -> post('item');
		$album_id = intval($this -> input -> post('album_name'));
		
		$select = array();//勾选的商品
		foreach ($item_ids as $item_id){
			$select[$item_id] = $all_items[$item_id];
		}
		unset($all_items);
		
		//遍历选择的商品
		$this->load->library('segment');
		$this->load->model("item_model");
		$this->load->model("share_model");
		foreach ($select as $v){
			$image_count = count($v['images']);
			$item = array(
				'user_id' => $this->data['sess_userinfo']['uid'],
				'title' => $v['title'],
				'intro' => $v['title'],
				'intro_search' => $this->segment->segment(strip_tags($v['title'])),
				'image_path' => serialize($v['images']),
				'image_count' => $image_count,
				'is_remote_image' => 1,
				'share_type' => 'taobao',
				'price' => $v['price'],
				'reference_url' => $v['reference_url'],
				'reference_itemid' => $v['num_iid'],
				'reference_channel' => 'taobao',
				'promotion_url' => $v['promotion_url'],
				'is_deleted' => 0,
			);
			$insert_id = $this->item_model->add_item($item);
			if ($insert_id) {
				$share = array(
					'item_id' => $insert_id,
					'album_id' => $album_id,
					'poster_id' => $this->data['sess_userinfo']['uid'],
					'poster_nickname' => $this->data['sess_userinfo']['nickname'],
					'original_id' => 0,
					'user_id' => $this->data['sess_userinfo']['uid'],
					'user_nickname' => $this->data['sess_userinfo']['nickname'],
					'total_comments' => 0,
					'total_likes' => 0,
					'total_forwarding' => 0,
				);
				$this -> share_model -> add_share($share);
			}
			//$item['user_id'] = $user_infos['uid'];
		}
		$res = array('result' => 1 , 'msg' => '发布商品成功');
		echo json_encode($res);
	}
	/**
	 * @todo ajax验证批量评论
	 *
	 */
	public function verify_comment(){
		$types=array(1,2);
		$type=$this->input->post("type",true);
		if (!in_array($type,$types)) {
			echo 0;//不允许的类型
			exit();
		}
		$ids=explode('|',$this->input->post('comment_ids'));
		$shares=explode('|',$this->input->post("share_ids"));
		if (count($ids)!=count($shares)) {
			echo 0;//不匹配
			exit;
		}
		$this->load->model("comment_model");
		$length=count($ids);
		$flag=false;
		for ($i=0;$i<$length;$i++){
			$flag=$this->comment_model->update_comment($ids[$i],array('is_show'=>$type));
			$flag=$this->comment_model->update_share($shares[$i]);//同步更新share
		}
		if ($flag) {
			echo 1;
			exit();
		}
		echo 0;
		exit();
		
	}
	
	
	/**
	 * @todo ajax验证批量share
	 *
	 */
	public function verify_share(){
		$types=array(1,2);
		$type=$this->input->post("type",true);
		if (!in_array($type,$types)) {
			echo 0;//不允许的类型
			exit();
		}
		$ids=explode('|',$this->input->post('share_ids'));
		/*
		$this->item_model->edit_item($item_id,array('is_show'=>1));
		*/
		$this->load->model("item_model");
		$length=count($ids);
		$flag=false;
		for ($i=0;$i<$length;$i++){
			$flag=$this->item_model->edit_item($ids[$i],array('is_show'=>$type));
			//$flag=$this->comment_model->update_share($shares[$i]);//同步更新share
		}
		if ($flag) {
			echo 1;
			exit();
		}
		echo 0;
		exit();
		
	}
	/**
	 * @todo 编辑，删除广告
	 */
	public function adinfo(){
		$action=$this->uri->segment(3);//动作
		$ad_id=intval($this->uri->segment(4));//广告id
		$adv=$data=array();
		$this->load->model("advert_model");
		if ($action=='edit') {
			$adv=$this->advert_model->getAdvByIndex(0,1,array("ad_id = ".$ad_id));
			if ($adv[0]) {
			$data['adv']=$adv[0];
			$this->load->view("admin/adver_edit",$data);
			}else{
			$error=array('msg'=>'错误的参数类型或未能在数据库中找到该广告信息！');
			$this->load->view("admin/upload_success",$error);
			}
			
		}elseif ($action=='save'){
			$data=$this->input->post();
			$ad_id=$data['ad_id'];
			unset($data['ad_id']);//防止误用
			unset($data['adfile']);//防止误用
			if($_FILES){
				$config['allowed_types'] = 'gif|jpg|png';//允许的文件类型
  				$config['max_size'] = '';//允许的文件最大尺寸
  				$config['max_width']  = '';//最大的宽度
  				$config['max_height']  = '';//最大的高度
  				$config['file_name']=date('YmdHis',time());
  				$config['upload_path'] = 'data/advert';//上传配置目录,没有则自动建立
  				$this->load->library('upload', $config);//加载上传文件辅助类库
  				if($this->upload->do_upload('adfile')){
  					$photo_path=$this->upload->data();//上传文件信息
  					$data['ad_photo']=$config['upload_path'].'/'.$photo_path['file_name'];//更新数据库用到
  				}
			}
			if ($this->db->update('tupu_advert',$data,'ad_id = '.$ad_id)) {
				$success['msg']="更新成功!";
				$this->load->view('admin/upload_success',$success);
				return;
			}
			$error['msg']="更新失败!";
			$this->load->view('admin/upload_success',$error);
		}elseif ($action=='delete'){
			if ($this->db->delete('tupu_advert',array('ad_id'=>$ad_id))) {
				echo 1;
				exit();
			}
			echo 0;
			exit();
		}
	}
	/**
	 * @todo 评论审核
	 *
	 */
	public function comment_list(){
		$action = $this->uri->segment(2);
		$this->load->model("comment_model");
		$page = intval($this->uri->segment(3));
		$search=$this->uri->segment(3);
		$condition=array();
		$count=0;
		$site_url="admin/comment_list";
		$data = array();
		if (isset($_GET['is_show'])) {
			$condition['is_show']=intval($_GET['is_show']);
			$is_show_query = "&is_show=".$condition['is_show'];
			$site_url = site_url('admin/item_list/comment_list?'.$is_show_query);
			$data['search']=true;
		}
		if ($search=='search') {
			//var_dump($search);exit;
			//$condition['is_show']=0;
			$keyword = $this->input->get('keyword',true);
			if ($keyword) {
				//$this->load->library('segment');
				$condition['keyword'] = $keyword;
				$keyword_query = '&keyword='.$keyword;
				$site_url .= $keyword_query;
			}
			//var_dump($site_url);exit;
		}elseif($search=="delete"){
			//ajax删除
			$comment_id=$this->input->post("comment_id",true);
			$share_id=$this->input->post("share_id",true);
			if($this->comment_model->del_comment($comment_id,array('share_id'=>$share_id))){
				echo 1;
			}
			exit();
		}elseif($search=='verify'){
			$comment_id=$this->input->post("comment_id",true);
			$share_id=$this->input->post("share_id",true);
			$type=$this->input->post("type",true);
			if($this->comment_model->update_comment($comment_id,array('is_show'=>$type))){
				$this->comment_model->update_share($share_id);//同步更新share
				echo 1;
			}else{
				echo 0;
			}
			exit();
		}
		//var_dump($condition);exit;
		$page = $page <1 ? 1: $page;
		$this->load->library('pagination');
		$count=$this->comment_model->count_comments($condition);
		$config['per_page'] = 14;
		$offset=($page-1)*$config['per_page'];
		$config['total_rows'] = $count;
		$config['base_url'] = site_url($site_url);
		$config['use_page_numbers'] = TRUE;
		$config['full_tag_open'] = '<p class="pagination">&nbsp;';
		$config['cur_tag_open'] = '<a style="background:#eee">';
		$config['cur_tag_close'] = '</a>';
		$config['full_tag_close'] = '</p>';
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		//$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
		$this->pagination->initialize($config);
		$pages = $this->pagination->create_links();
		$comments = $this->comment_model->get_comments($offset,$config['per_page'],$condition);
		$data['comments']=$comments;
		$data['pages']=$pages;
		$this->load->view("admin/comment_list",$data);
	}
	public function database_management()
	{
		$this->check_admin();
		$this->load->helper('file');
		$dbbackup_dir = FCPATH.'data/database/';
		$data['file_list'] = get_dir_file_info($dbbackup_dir, $top_level_only = TRUE);
		$this->load->view('admin/database_management', $data, false);
		//var_dump($data);
	}

	public function database_backup(){
		$this->check_admin();
		$prefs = array(
                'tables'      => array(),  // 包含了需备份的表名的数组.
                'ignore'      => array(),           // 备份时需要被忽略的表
                'format'      => 'zip',             // gzip, zip, txt
                'filename'    => 'mybackup.sql',    // 文件名 - 如果选择了ZIP压缩,此项就是必需的
                'add_drop'    => TRUE,              // 是否要在备份文件中添加 DROP TABLE 语句
                'add_insert'  => TRUE,              // 是否要在备份文件中添加 INSERT 语句
                'newline'     => "\n"               // 备份文件中的换行符
		);
		$dbbackup_dir = 'data/database';
		(!is_dir(FCPATH.$dbbackup_dir))&&@mkdir(FCPATH.$dbbackup_dir,0777,true);
		$this->load->dbutil();
		$backup =& $this->dbutil->backup($prefs);
		$this->load->helper('file');
		$filename = date('YdmHis').'.zip';
		write_file(FCPATH.$dbbackup_dir.'/'.$filename, $backup);
		redirect('admin/database_management');
	}

	/**
	 * @todo 控制器移动广告位
	 * 要根据当前广告和上移和下移的广告
	 * 进行替换移动
	 * 同时要set彼此的数据order位置
	 */
	public function move_adv(){
		$cur_id=$this->input->post("cur_id",true);
		$next_id=$this->input->post("next_id",true);
		$pre_id=$this->input->post("pre_id",true);
		$type=$this->input->post("type",true);
		$msg='';
		if(empty($cur_id)||empty($next_id)||empty($pre_id)){
			$msg='error';//出错了
		}
		$this->load->model("advert_model");
		if($type=='top'){
			//上移
			if($this->advert_model->move_advs($cur_id,$pre_id)){
				$msg=1;
			}
		}elseif ($type=='bottom'){
			//下移
			if($this->advert_model->move_advs($cur_id,$next_id)){
				$msg=1;
			}
		}else{
			//出错
			$msg="error";
		}
		echo $msg;
		exit();
	}
	
	/**
	 * 客户端检测服务器是否有
	 * 版本，如有有新版本，则要
	 * 引导用户进行下载
	 */
	public function check_version(){
		$this->config->load('custom',TRUE);
		$custom =  $this->config->item('custom');
		$version_check_url=$custom['version_info'] ?$custom['version_info']['check_url']:'';//目前用目录检测下面文件
		$version_check_url=ltrim($version_check_url,'/').'/';
		$ajax_info=array();
		$now_version=explode('.',substr(ATP_VERSION,7,5));
		sleep(1);//模拟沉睡，正式上线需要注掉
		if ($version_check_url) {
			if (is_dir($version_check_url)) {
					$dp=opendir($version_check_url);
					while ($file=readdir($dp)) {
						$parse_name=explode('.',substr($file,7,5));//解析的当前版本号，如果有更新的那就取更新的
						$jump=count($parse_name);	
						for ($i=0;$i<$jump;$i++){
							if (intval($parse_name[$i])>intval($now_version[$i])) {
								$download_name=$version_check_url.$file;
								echo $download_name;
								exit();	
							}
						}
					}	
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
		exit();
	}
	
	public function user_forbidden(){
		$check_array=array(1,2);
		$user_id=$this->input->post("user_id",true);
		$for_type=$this->input->post("type",true);
		if (!in_array($for_type,$check_array)) {
			echo 0;//禁言失败
			exit();
		}
		$this->load->model('user_model');
		if($this->user_model->user_forbidden($user_id,$for_type)){
			echo 1;//禁言成功
		}else {
			echo 0;//禁言失败
		}
		exit();
		
	}
	public function database_download(){
		$this->check_admin();
		$file_name = $this->uri->segment(3);
		$this->load->helper('download');
		$dbbackup_dir = FCPATH.'data/database';
		$data = file_get_contents($dbbackup_dir."/".$file_name); // 读文件内容
		force_download($file_name, $data);
	}
	
	/**
	 * @todo 检查用户的禁言状态
	 * 并同时同步用户的禁言信息
	 * @param unknown_type $users
	 * @return unknown
	 */
	public function check_forbidden($users=array()){
		if (empty($users)) {
			return array();//不对空数组操作
		}
		$fact_time=48;//48小时
		$now=time();
		$this->load->model('user_model');
		foreach ($users as $key=>$user) {
			if(intval($user->is_forbidden)==1){
				$hours=($now-($user->forbiden_time))/(3600);//禁言的时间长度值以小时为最小值
				if($hours>=48){
					$data=array('is_forbidden'=>0);
					$this->user_model->edit_user($user->user_id,$data);
					$user->is_forbidden=0;//同步输出
					$users[$key]=$user;
					continue;
				}
			}
			continue;
		}
		return $users;
		
	}
	/**
	 * 友情链接
	 *
	 */
	public function friendlink(){
		$this->check_admin();
		$op = $this -> input -> get('op')?$this -> input -> get('op'):'list';
		$this -> load -> model('friendlink_model');
		if ($op == 'list') {
			//请求列表页面
			$data['list'] = $this -> friendlink_model -> get_list();
			$this->load->view("admin/friendlink_list",$data);
		}//列表页面
		elseif ($op == 'add'){
			//处理添加链接
			if ($this -> input -> post('action') == 'submit') {
				$data = array(
					'link_title' => $this -> input -> post('link_title'),
					'link_url' => $this -> input -> post('link_url'),
					'link_target' => $this -> input -> post('link_target'),
					'display_order' => $this -> input -> post('display_order'),
				);
				if ($this -> friendlink_model -> add_link($data)) {
					my_alert('添加成功' , site_url('admin/friendlink'));
				}else {
					my_alert('添加失败');
				}
			}
		}//添加
		elseif($op == 'edit'){
			if ($this -> input -> post('action') == 'submit') {
				$id = intval($this -> input -> post('id'));
				$set = array(
					'link_title' => $this -> input -> post('link_title'),
					'link_url' => $this -> input -> post('link_url'),
					'link_target' => $this -> input -> post('link_target'),
					'display_order' => $this -> input -> post('display_order'),
				);
				$this -> friendlink_model -> edit_link($id , $set);
				my_alert('数据已保存' , site_url('admin/friendlink'));
			}
			$id = intval($this -> input -> get('id'));
			if ($id < 1) {
				my_alert('请求错误');
			}
			$data['vo'] = $this -> friendlink_model -> getOne($id);
			//var_dump($data['vo']);
			$this->load->view("admin/friendlink_edit",$data);
			
		}//编辑
		elseif ($op == 'del'){
			$id = intval($this -> input -> get('id'));
			if($this -> friendlink_model -> del_link($id)){
				my_alert('一条数据已删除' , site_url('admin/friendlink'));
			}else {
				my_alert('删除事变');
			}
		}
	}
	// 统计代码
	private function count_user_behavior(){
		$data = $page_view = array();
		$new_register_user = $new_login_user = $total_reg_user = $share_space= $total_share= 0;
		$this->load->model("user_model");
		$this->load->model("share_model");
		$this->load->model("page_view_model");
		$this->load->model("category_model");
		$this->config->load('custom',TRUE);
		$new_register_user = $this->user_model->count_new_register_user();//当日新注册用户数
		$new_login_user = $this->user_model->count_active_user();//每日登陆用户数
		$total_reg_user = $this->user_model->count_total_user();//注册用户总数
		$custom =  $this->config->item('custom');
		$count_dir=$custom['version_info']['mem_count'];
		$share_space = $this->user_model->exchange_byte($this->user_model->count_dir_size($count_dir));
		$total_share = $this->category_model->count_conduct_share();//统计全站商品图数量
		$total_click = $this->share_model->count_share_total_click();
		$page_view = $this->page_view_model->count_day_views();
		$data['new_register_user'] = $new_register_user;
		$data['new_login_user'] = $new_login_user;
		$data['total_reg_user'] = $total_reg_user;
		$data['share_space'] = $share_space;
		$data['total_share'] = $total_share;
		$data['page_count'] =$page_view['page_count'];
		$data['ip_count'] =$page_view['ip_count'];
		$data['page_count_total'] =$page_view['page_count_total'];
		$data['ip_count_total'] =$page_view['ip_count_total'];
		$data['total_click'] = $total_click['total_click'];
		$data['total_click_taobao'] = $total_click['total_click_taobao'];
		return $data;
	}
	//图片本地化
	function images_to_local(){
		$this->load->model('item_model');
		if ($item_id = intval($this -> input -> post('item_id'))) {
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
			header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
			header("Cache-Control: no-cache, must-revalidate");
			header("Pramga: no-cache");
			$this->load->model('album_model');
			$imgs = $this -> item_model -> get_item_images_by_id($item_id);
			$save_imgs = array();
			foreach ($imgs as $img){
				$local = $this -> album_model -> save_remote_image($img);
				$save_imgs[] = $local['orgin'];
			}
			$local_imgs = serialize($save_imgs);
			$count = count($save_imgs);
			$this -> item_model -> remote_to_local($item_id , $local_imgs);
			$res = array('result' => 1 , 'msg' => '已完成 <b>'.$count.'</b> 张远程图片本地化');
			echo json_encode($res);
			exit;
		}
		$this->check_admin();
		
		$this->load->library('pagination');
		$this->load->model('item_model');
		

		/**
		 * 获取is_remote_image = 1的item
		 */
		
		$page =  intval($this->input->get('page',true));
		if($page < 1) $page = 1;
		$condition = array('is_remote_image' => 1);
		$config['per_page'] = 15;
		$config['total_rows'] = $this->item_model->count_item($condition);
		$config['base_url'] = site_url('admin/images_to_local?');
		$config['use_page_numbers'] = TRUE;
		$config['page_query_string'] = TRUE;
		$config['query_string_segment'] = 'page';
		$config['full_tag_open'] = '<p class="pagination">&nbsp;';
		$config['cur_tag_open'] = '<a style="background:#eee">';
		$config['cur_tag_close'] = '</a>';
		$config['full_tag_close'] = '</p>';
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$this->pagination->initialize($config);
		$pages = $this->pagination->create_links();
		
		$items = $this->item_model->search_item(($page - 1)*$config['per_page'],$config['per_page'] , $condition);
		$this->load->view('admin/images_to_local', array('items'=>$items,'pages'=>$pages), false);
	}
	//
}
