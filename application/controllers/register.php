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
 * AiTuPu Register Controller
 *
 *
 * @package		AiTuPu
 * @subpackage	Controllers
 * @category	Controllers
 * @author		Duobianxing Studio Dev Team
 * @link		http://duobianxing.com/doc/index.html
 */

class Register extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		if (!$this->is_login()) {
			$this->output("common/layout", array('body'=>'register/index'));
		}else{
			redirect('member/index');
		}
		
		
	}
	
	public function agree_vilivege(){
	
		$this->output("common/agree", array('body'=>'register/agree'));
		
	}
	
	
	//Only for AJAX	
	public function ajax_register()
	{
		log_message('error','action ok');
		if(!is_ajax_request())//from helper
		exit('Access Denied!');
		if($this->input->post() && $this->validate_register_form()){
			log_message('error','post ok');
				$data['email'] = $this->input->post('email',true);
				$data['nickname'] = $this->input->post('nickname',true);
				$data['passwd'] = md5($this->input->post('password',true));
				$org_password = $this->input->post('password',true);
				$data['is_active'] = 1;
				if ($this->user_model->check_nickname_exists($data['nickname'])) {
					$response = array('result' => false, 'msg' => "用户昵称已经存在");
					echo json_encode($response);
					exit;
				}
				if ($this->user_model->check_email_exists($data['email'])) {
					$response = array('result' => false, 'msg' => "邮箱已经存在");
					echo json_encode($response);
					exit;
				}
				$this->config->load('ucenter',TRUE);
				$ucenter =  $this->config->item('ucenter');
				$uc = $ucenter['is_active'];
				if ($uc == 1) {//如果整合ucenter
					
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
					
					$uc_uid = uc_user_register($data['nickname'] , $org_password , $data['email']);
					
					if($uc_uid == -1){
						$response = array('result' => false, 'msg' => "用户名不合法");
						echo json_encode($response);
						exit;
					}elseif($uc_uid == -2){
						$response = array('result' => false, 'msg' => "包含要允许注册的词语");
						echo json_encode($response);
						exit;
					}elseif($uc_uid == -3){
						$response = array('result' => false, 'msg' => "用户名已经存在");
						echo json_encode($response);
						exit;
					}elseif($uc_uid == -4){
						$response = array('result' => false, 'msg' => "Email 格式有误");
						echo json_encode($response);
						exit;
					}elseif($uc_uid == -5){
						$response = array('result' => false, 'msg' => "Email 不允许注册");
						echo json_encode($response);
						exit;
					}elseif($uc_uid == -6){
						$response = array('result' => false, 'msg' => "该 Email 已经被注册");
						echo json_encode($response);
						exit;
					}
					
				}
				if($uid = $this->user_model->add_user($data)){
					$update_data['avatar_local'] = $this->user_model->create_default_avatar($uid);
					if($update_data['avatar_local']){
						$this->user_model->edit_user($uid,$update_data);
					}
					$user = $this->user_model->get_user_by_uid($uid);
					$this->user_model->set_usersession($user);
					if ($uc == 1) {
						$synlogin = uc_user_synlogin($uc_uid);
						$response = array('result' => true, 'msg' => "注册成功" , 'synlogin' => $synlogin);
					}else {
						$response = array('result' => true, 'msg' => "注册成功");
					}
					echo json_encode($response);
				}else{
					$response = array('result' => false, 'msg' => "注册失败，请检查你输入的内容是否正常");
					echo json_encode($response);
				}
		}else{
			$response = array('result' => false, 'msg' => "注册失败，请检查你输入的内容是否正常");
			echo json_encode($response);
		}
	}
	
	private function validate_register_form(){
		$this->form_validation->set_rules('email', 'Email' , 'trim|required|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('nickname', '昵称' , 'trim|required|min_length[2]|max_length[20]|xss_clean');
		$this->form_validation->set_rules('password', '用户密码' , 'trim|required|min_length[6]|max_length[40]|matches[passconf]');
		$this->form_validation->set_rules('passconf', '密码验证' , 'trim|required|min_length[6]|max_length[40]');
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}

}