<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Social extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function callback()
	{
		$vendor = $this->uri->segment(3);
		$this->connector->init_vendorinfo($vendor);
		$this->connector->get_accesstoken($vendor);
		$userinfo = $this->connector->get_userinfo($vendor);
		$userinfo['vendor'] = $vendor;
		$this->session->set_userdata('social_user_info',$userinfo);
		//echo '<script>window.opener.location.href="'.site_url('social/bind/'.$vendor).'";window.close();</script>';
		header('location:'.site_url('social/bind/'.$vendor));
		
		
	}

	public function unbind()
	{
		$this->check_login();
		$this->load->model('connector_model');
		$vendor = $this->uri->segment(3);
		if(!$vendor){
			redirect('login/index');
		}
		$user_session = $this->user_model->get_usersession();
		$this->connector_model->del_connector_by_vendor_uid($vendor,$user_session['uid']);
		redirect('member/setting_bind');
	}


	public function temp(){
	
				$this->output("common/layout", array('body'=>'social/index'), $social_user_info);
	}

	public function bind()
	{
		$this->load->model('connector_model');
		$this->load->model('user_model');
		$vendor = $this->uri->segment(3);
		$social_user_info = $this->session->userdata('social_user_info');
		//var_dump($social_user_info);exit;
		if(!$vendor||$vendor!=$social_user_info['vendor']){
			$this->clear_socialinfo($vendor);
			redirect('login/index');
		}
		if($this->input->post()){
			if($this->validate_bind_form() == TRUE){
				$data['email'] = md5(random_string('alnum', 5)).'@aitupu.com';
				$data['nickname'] = $this->input->post('nickname');
				$data['avatar_remote'] = $social_user_info['avatar'];
				$data['gender'] = $social_user_info['gender'];
				$data['location'] = $social_user_info['location'];
				$data['passwd'] = md5(random_string('alnum', 8));
				$data['is_active'] = 1;
				$data['is_social'] = 1;
				$uid = $this->user_model->add_user($data);

				$connector_data['user_id'] = $uid;
				$connector_data['social_userid'] = $social_user_info['uid'];
				$connector_data['vendor'] = $vendor;
				$connector_data['vendor_info'] = serialize($this->session->userdata('social_'.$vendor.'_info'));
				$connector_data['username'] = $social_user_info['screen_name'];
				$connector_data['name'] = $social_user_info['name'];
				$connector_data['description'] = $social_user_info['description'];
				$connector_data['homepage'] = $social_user_info['url'];
				$connector_data['avatar'] = $social_user_info['avatar'];
				$connector_data['email'] = $social_user_info['email'];
				$connector_data['gender'] = $social_user_info['gender'];
				$connector_data['location'] = $social_user_info['location'];
				$this->connector_model->add_connector($connector_data);

				$this->save_remote_avatar($social_user_info['avatar'], $uid);
				$user = $this->user_model->get_user_by_uid($uid);
				$this->user_model->set_usersession($user);
				$this->clear_socialinfo($vendor);
				redirect('member/index');
			}else{
				$this->output("common/layout", array('body'=>'social/index'), $social_user_info);
			}
		}else{
			$social_connector = $this->connector_model->get_bind_by_vendor_and_suid($vendor,$social_user_info['uid']);
			if($social_connector){
				if($this->data['sess_userinfo']['uid']&&$social_connector->user_id!=$this->data['sess_userinfo']['uid']){
					//$this->output("common/layout", array('body'=>'social/bind_error'), array('error'=>'此账号已被其他用户绑定，本操作已取消'));
					header("Content-Type:text/html;charset=utf-8");
					show_error("此账号已被其他用户绑定，本操作已取消",500,'该行为被取消');
				}else{
					$update_connect_data['avatar'] = $social_user_info['avatar'];
					//$update_local_data['avatar_remote'] = $social_user_info['avatar'];
					//need update remote avatar
					$this->connector_model->edit_connector($social_connector->connect_id,$update_connect_data);
					//$this->user_model->edit_user($social_connector->user_id,$update_local_data);
					//
					$local_user = $this->user_model->get_user_by_uid($social_connector->user_id);
					$this->user_model->set_usersession($local_user);
					$this->clear_socialinfo($vendor);
					redirect('member/index');
				}
			}else{
				if($this->data['sess_userinfo']['uid']){
					$connector_data['user_id'] = $this->data['sess_userinfo']['uid'];
					$connector_data['social_userid'] = $social_user_info['uid'];
					$connector_data['vendor'] = $vendor;
					$connector_data['vendor_info'] = serialize($this->session->userdata('social_'.$vendor.'_info'));
					$connector_data['username'] = $social_user_info['screen_name'];
					$connector_data['name'] = $social_user_info['name'];
					$connector_data['description'] = $social_user_info['description'];
					$connector_data['homepage'] = $social_user_info['url'];
					$connector_data['avatar'] = $social_user_info['avatar'];
					$connector_data['email'] = $social_user_info['email'];
					$connector_data['gender'] = $social_user_info['gender'];
					$connector_data['location'] = $social_user_info['location'];
					$this->connector_model->add_connector($connector_data);
					redirect('member/setting_info');
				}else{
					$this->output("common/layout", array('body'=>'social/index'), $social_user_info);
				}
			}
		}
	}

	private function save_remote_avatar($url,$uid)
	{
		/*if(function_exists('curl_init')){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);
			curl_setopt($ch, CURLOPT_REFERER,_REFERER_);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$content = curl_exec($ch);
			curl_close($ch);
		}else{
			$content = @file_get_contents($url);
		}

		$avatar_info = $this->user_model->get_avatarinfo($uid);
		$avatar_dir = FCPATH.$avatar_info['dir'];
		(!is_dir($avatar_dir))&&@mkdir($avatar_dir,0777,true);

		file_exists($avatar_dir.$avatar_info['orgin']) && unlink($avatar_dir.$avatar_info['orgin']);
		file_exists($avatar_dir.$avatar_info['large']) && unlink($avatar_dir.$avatar_info['large']);
		file_exists($avatar_dir.$avatar_info['middle']) && unlink($avatar_dir.$avatar_info['middle']);
		file_exists($avatar_dir.$avatar_info['small']) && unlink($avatar_dir.$avatar_info['small']);
		
		$file_path = $avatar_dir.$avatar_info['orgin'];
		if(!empty($content) && @file_put_contents($file_path,$content) > 0)
		{
			$this->load->library('tupu_image_lib');
			$this->tupu_image_lib->create_thumb($file_path, 'large', 150,150);
			$this->tupu_image_lib->create_thumb($file_path, 'middle', 50,50);
			$this->tupu_image_lib->create_thumb($file_path, 'small', 16,16);
			//update local avatar
			$user_update['avatar_local'] = $avatar_info['dir'].$avatar_info['filename'];
			return $this->user_model->edit_user($uid,$user_update);
		}else{
			$user_update['avatar_local'] = $this->user_model->create_default_avatar($uid);
			return $this->user_model->edit_user($uid,$user_update);
		}
		return false;*/
		$this -> load -> model('user_model');
		$this -> user_model -> create_default_avatar($uid);
		return true;
	}

	private function clear_socialinfo($vendor){
		$this->session->unset_userdata(
		array(
				'social_api_info'=>'',
				'social_user_info'=>'',
				'social_'.$vendor.'_info'=>''
				));
	}

	private function validate_bind_form($name = ''){
		$this->form_validation->set_rules('nickname', '昵称' , 'trim|required|min_length[2]|max_length[20]|callback_check_nickname|xss_clean');
		if ($this->form_validation->run() == FALSE){
			return FALSE;
		}else{
			return TRUE;
		}
	}

	function check_nickname($nickname){
		$users = $this->user_model->get_user_by_nickname($nickname);
		if($users){
			$this->form_validation->set_message('check_nickname', 'nickname already exits!');
			return FALSE;
		}else{
			return TRUE;
		}
	}

}