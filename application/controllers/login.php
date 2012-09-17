<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		if($this->user_model->get_usersession()) {
			redirect("member/index");
		}else{
			//exit('Acess denied!');
			redirect('register/index');
		}
		//$this->output("common/layout", array('body'=>'login/index'));
	}

	public function social(){
		$vendor = $this->uri->segment(3);
		$this->connector->connect($vendor);
	}

	public function ajax_login()
	{
		if($this->input->post()){
				$email = $this->input->post('email',true);
				$org_password = $this->input->post('password',true);
				$password = md5($this->input->post('password',true));
				
				$this->config->load('ucenter',TRUE);
				$ucenter =  $this->config->item('ucenter');
				$uc = $ucenter['is_active'];
				/**
				 * 整合UCenter登录的思路
				 *  首先查询UCenter有没有用户名为$username的用户，分以下两种情况：
				 * 1.如果没有，查询本地，如果本地有，则注册到UCenter，同时登陆      *      UCenter，登录失败则提示，如果成功，则到第二步
				 * 2.如果有，判断本地有没有此用户
				 * 		(1).本地有，则更新本地用户的UCenter编号
				 * 		(2).本地没有，则插入本地
				 */
				if ($uc == 1) {
					
					
					define('UC_CONNECT', 'mysql');
					define('UC_DBHOST', $ucenter['uc_host']);
					define('UC_DBUSER', $ucenter['uc_dbuser']);
					define('UC_DBPW', $ucenter['uc_dbpw']);
					define('UC_DBNAME', $ucenter['uc_dbname']);
					define('UC_DBCHARSET', $ucenter['uc_dbcharset']);
					define('UC_DBTABLEPRE', "`{$ucenter['uc_dbname']}`.{$ucenter['uc_dbtablepre']}");
					define('UC_DBCONNECT', '0');
					define('UC_KEY', $ucenter['uc_key']);
					define('UC_API', $ucenter['uc_api']);
					define('UC_CHARSET', 'utf-8');
					define('UC_IP', '');
					define('UC_APPID', $ucenter['uc_apiid']);
					define('UC_PPP', '20');
					
					
					require_once './uc_client/client.php';
					
					//1-用户名登陆，2-邮箱登陆
					list($uc_uid, $uc_username, $uc_password, $uc_email) = uc_user_login($email , $org_password , 2);
					
					if ($uc_uid == -2) {
						$response = array('result' => false, 'msg' => "系统提示：密码错误!");
						echo json_encode($response);
					}elseif ($uc_uid == -1){
						//ucenter无记录,查询本地
						//var_dump($email);exit;
						$user = $this -> user_model -> get_full_user_by_email($email);
						$is_remember = $this->input->post('is_remember',true);
						if($user){
							if( $user -> passwd == $password){
								//本地登陆成功，注册到ucenter，原始密码注册
								$uc_uid = uc_user_register($user -> nickname, $org_password, $user -> email);
								if ($$uc_uidid < 0) {
									$response = array('result' => false, 'msg' => "系统提示：Ucenter注册失败!");
									echo json_encode($response);
								}else{
									$this->user_model->set_usersession($user,$is_remember);
									$synlogin = uc_user_synlogin($uc_uid);
									if ($is_forbidden=$this->user_model->check_forbidden()) {
									$this->user_model->remove_usersession();
									echo json_encode(array('result'=>false,'msg'=>'您目前处于屏蔽状态，暂时不能登录！'));//检查禁言状态													
								exit();
								}
									$response = array('result' => true, 'msg' => "系统提示：登录成功，欢迎回来" , 'synlogin' => $synlogin);
									$this->async_active_user();//同步用户
									echo json_encode($response);
								}
							}
							else {
								$response = array('result' => false, 'msg' => "系统提示：密码不正确!");
								echo json_encode($response);
							}
						}else{
							$response = array('result' => false, 'msg' => "系统提示：用户不存在!");
							echo json_encode($response);
						}
					}elseif ($uc_uid > 0){
						//ucenter用户存在，查询本地是否存在
						$user = $this -> user_model -> get_full_user_by_email($email);
						$is_remember = $this->input->post('is_remember',true);
						if($user){
							if( $user -> passwd == $password){
								$this->user_model->set_usersession($user,$is_remember);
								$synlogin = uc_user_synlogin($uc_uid);
								if ($is_forbidden=$this->user_model->check_forbidden()) {
									$this->user_model->remove_usersession();
									echo json_encode(array('result'=>false,'msg'=>'您目前处于屏蔽状态，暂时不能登录！'));//检查禁言状态													
								exit();
								}
								$response = array('result' => true, 'msg' => "系统提示：登录成功，欢迎回来" , 'synlogin' => $synlogin);
								$this->async_active_user();//同步用户
								echo json_encode($response);
							}
							else {
								$response = array('result' => false, 'msg' => "系统提示：密码不正确!");
								echo json_encode($response);
							}
						}else{
							//ucenter有，本地没有，插入本地
							$data['email'] = $email;
							$data['nickname'] = $uc_username;
							$data['passwd'] = $password;
							$data['is_active'] = 1;
							if($uid = $this->user_model->add_user($data)){
								$update_data['avatar_local'] = $this->user_model->create_default_avatar($uid);
								if($update_data['avatar_local']){
									$this->user_model->edit_user($uid,$update_data);
								}
								$user = $this->user_model->get_user_by_uid($uid);
								$this->user_model->set_usersession($user);
								if ($is_forbidden=$this->user_model->check_forbidden()) {
									$this->user_model->remove_usersession();
									echo json_encode(array('result'=>false,'msg'=>'您目前处于屏蔽状态，暂时不能登录！'));//检查禁言状态													
								exit();
								}
								$response = array('result' => true, 'msg' => "系统提示：登录成功，欢迎回来");
								$this->async_active_user();//同步用户
								echo json_encode($response);
							}else {
								$response = array('result' => true, 'msg' => "系统提示：登陆失败，用户数据无法同步到当前应用");
								echo json_encode($response);
							}
						}
					}
					exit;
					
				}//整合ucener登陆
				else {//一般登陆
					$user = $this -> user_model -> get_full_user_by_email($email);
					$is_remember = $this->input->post('is_remember',true);
					if($user){
						if( $user -> passwd == $password){
							$this->user_model->set_usersession($user,$is_remember);
							//$this->load->model('user_model');
								if ($is_forbidden=$this->user_model->check_forbidden()) {
									$this->user_model->remove_usersession();
									echo json_encode(array('result'=>false,'msg'=>'您目前处于屏蔽状态，暂时不能登录！'));//检查禁言状态													
								exit();
								}
							
							$this->async_active_user();
						
							$response = array('result' => true, 'msg' => "系统提示：登录成功，欢迎回来");
							echo json_encode($response);
						}
						else {
							$response = array('result' => false, 'msg' => "系统提示：密码不正确!");
							echo json_encode($response);
						}
					}else{
						$response = array('result' => false, 'msg' => "系统提示：用户不存在!");
						echo json_encode($response);
					}
				}
				
		}
		return FALSE;
	}
	
	public function logout()
	{
		$this->user_model->remove_usersession();
		$this->config->load('ucenter',TRUE);
		$ucenter =  $this->config->item('ucenter');
		$uc = $ucenter['is_active'];
		if ($uc == 1) {
			header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
			ob_start();
			setcookie('tupu_auth', '',  -86400 * 365 , '/', '');
			setcookie('tupu_loginuser', '',  -86400 * 365 , '/', '');
			ob_end_flush();
			//require_once './config.inc.php';
			define('UC_CONNECT', 'mysql');
			define('UC_DBHOST', $ucenter['uc_host']);
			define('UC_DBUSER', $ucenter['uc_dbuser']);
			define('UC_DBPW', $ucenter['uc_dbpw']);
			define('UC_DBNAME', $ucenter['uc_dbname']);
			define('UC_DBCHARSET', $ucenter['uc_dbcharset']);
			define('UC_DBTABLEPRE', "`{$ucenter['uc_dbname']}`.{$ucenter['uc_dbtablepre']}");
			define('UC_DBCONNECT', '0');
			define('UC_KEY', $ucenter['uc_key']);
			define('UC_API', $ucenter['uc_api']);
			define('UC_CHARSET', 'utf-8');
			define('UC_IP', '');
			define('UC_APPID', $ucenter['uc_apiid']);
			define('UC_PPP', '20');
					
			require_once './uc_client/client.php';
			$ucsynlogout = uc_user_synlogout();
			//echo $ucsynlogout;exit;
			$message = $ucsynlogout.'退出成功';
			$this->load->library('session');
			$this -> session -> set_flashdata('message', $message);
			$this->session->flashdata('message');
		}

		redirect('welcome/index');
	}
	
	/**
	 * 用户登录则标志为当天活跃用户
	 *
	 */
	private function async_active_user(){
		$user = $this->user_model->get_usersession();
		$this->load->helper('tupu');
		$active = array(
							'login_time'=>time(),
							'uid'=>$user['uid'],
							'nickname'=>$user['nickname'],
							'ip'=>get_ip()
							);
	 $this->user_model->insert_active($active);
	}
	

}