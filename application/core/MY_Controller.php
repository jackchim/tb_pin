<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->before();
		$this->switch_theme();
	}


	/**
	 * 基础/公共环境变量设置
	 * 
	 * @access public
	 * @return void
	 */
	public function before()
	{
		global $_gb_tupu_cookie;
		
		// 重要：$this->data ，用于所有派生的子类
		$this->data = array();
		//var_dump($_gb_tupu_cookie['tupu_auth']);exit;
		//将当前登录用户Session信息送到$this->data，以便随时读取
		$this -> user_model -> refresh_usersession();
		$sess_userinfo = $this -> user_model -> get_usersession();
		if(is_array($sess_userinfo)	&&	!empty($sess_userinfo)){
			$this->data['sess_userinfo'] = $sess_userinfo;
		}elseif (isset($_gb_tupu_cookie['tupu_auth']) && !empty($_gb_tupu_cookie['tupu_loginuser'])){
			//ucenter同步登陆状态
			$login_user = $_gb_tupu_cookie['tupu_loginuser'];
			$user = $this -> user_model -> get_user_by_nickname($login_user);
			if ($user) {
				$this -> user_model -> set_usersession($user);
				$sess_userinfo = $this->user_model->get_usersession();
				$this->data['sess_userinfo'] = $sess_userinfo;
			}
		}
		//如果ucenter退出
		$this->config->load('ucenter',TRUE);
		$ucenter =  $this->config->item('ucenter');
		$uc = $ucenter['is_active'];
		//var_dump($ucenter);exit;
		if ($uc == 1) {
			if ($_gb_tupu_cookie['tupu_logout'] == 1) {
				$this->user_model->remove_usersession();
				unset($this->data['sess_userinfo']);
			}
		}
		
		if ($this -> data['sess_userinfo']['user_type'] == 3) {
			$this -> data['is_admin'] = 1;
		}else {
			$this -> data['is_admin'] = 0;
		}
		//var_dump($this -> data['is_admin']);exit;
		//头部发现中的分类数据
		$this->load->model('category_model');
		$this->data['category'] = $this->category_model->get_categories();
		//友情链接
		$this -> load -> model('friendlink_model');
		$this -> data['friendlinks'] = $this -> friendlink_model -> get_list(16);
		//全局设置
		$this->config->load('custom',TRUE);
		$this->data['config_custom'] = $custom =  $this->config->item('custom');
		$this->data['current_controller'] = $this->router->class;
		$set_logo = $this -> data['config_custom']['logo'];
		
		if (is_file(FCPATH.$set_logo)) {
			$this->data['logo'] = base_url($set_logo);
		}
		else{
			$this->data['logo'] = base_url('assets/img/logo.png');
		}
		//var_dump(base_url('assets/img/logo.png'));exit;
		//全局js引用
		$this->data['global_js'] = array(
			base_url('assets/js/jquery-1.7.2.min.js'),
			base_url('assets/js/jquery.actionController.js'),
			base_url('assets/js/jquery.validate.min.js'),
			base_url('assets/js/jquery.form.js'),
			base_url('assets/js/dialog/artDialog.js'),
			base_url('assets/js/tupu.validate.js'),
			base_url('assets/js/tupu.common.js'),
			base_url('assets/js/tupu.bootstrap.js'),
			base_url('assets/js/jquery.form.js'),
			base_url('assets/js/float/js/jquery-powerFloat-min.js')
		);
		$this->partials = array('header'=>'common/header','footer'=>'common/footer');
		
	}

	
	/**
	 * 设置模版目录的函数
	 * 
	 * @access public
	 * @return void
	 */
	public function switch_theme(){
		/*
		 * TODO: get theme
		 * */
		$this->load->set_theme('tupu');
		$this->data['theme_url'] = base_url('themes/tupu');
	}



	protected function output($layout,$partials,$data=array()){
		if(is_array($data)	&&	!empty($data)){
			$this->data = array_merge($this->data, $data);
		}
		$this->partials = array_merge($this->partials, $partials);
		$this->template->load($layout, $this->partials, $this->data);
	}

	function check_login()
	{
		if(! $this->is_login())
		{
			redirect('login/index');
		}
	}

	function is_login()
	{
		global $_gb_tupu_cookie;
		
		if($this->data['sess_userinfo']['uid']){
			return true;
		}elseif (isset($_gb_tupu_cookie['tupu_auth'])){
			return true;
		}else {
			return false;
		}
	}

	function ajax_check_login($type = 'json')
	{
		if($this->is_login()){
			return true;
		}else {
			if ($type == 'json') {
				$response = array('result' => false, 'msg' => "not_login");
				echo json_encode($response);
				die();
			}
			else {
				echo 'not_login';
				die();
			}
		}
	}

	function ajax_check_admin()
	{
		if($this->is_admin()){
			return true;
		}else {
			$response = array('result' => false, 'msg' => "not_admin");
			echo json_encode($response);
			die();
		}
	}
	



}

?>