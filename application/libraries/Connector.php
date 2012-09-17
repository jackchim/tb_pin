<?php if (!defined('BASEPATH')) exit('No direct access allowed.');
class Connector {
	private $ci;

	public function __construct()
	{
		$this->ci =& get_instance();
		log_message('debug', 'Tupu: Connect class initialized.');
	}

	public function init_vendorinfo($vendor){
		if(isset($vendor)){
			$this->ci->session->unset_userdata(
				array(
				'social_api_info'=>'',
				'social_user_info'=>'',
				'social_'.$vendor.'_info'=>''
				));
				
			$custom =  $this->ci->config->item('custom');			
			switch ($vendor) 
			{
				case 'Sina':
					$vendorinfo = array(
						 'APPKEY'=> $custom['api']['Sina']['APPKEY'],
						 'APPSECRET'=> $custom['api']['Sina']['APPSECRET'],
						 'CALLBACK'=> site_url('social/callback/Sina')
						);
					break;
				case 'QQ':
					$vendorinfo = array(
							 'APPKEY'=>$custom['api']['QQ']['APPKEY'],
							 'APPSECRET'=>$custom['api']['QQ']['APPSECRET'],
							 'CALLBACK'=>site_url('social/callback/QQ')
							 );
					break;
				case 'Renren':
					$vendorinfo = array(
							'APPKEY'=>$custom['api']['Renren']['APPKEY'],
							'APPSECRET'=>$custom['api']['Renren']['APPSECRET'],
							'CALLBACK'=>site_url('social/callback/Renren')
							);
					break;
				case 'Taobao':
					$vendorinfo = array(
							 'APPKEY'=>$custom['api']['Taobao']['APPKEY'],
							 'APPSECRET'=>$custom['api']['Taobao']['APPSECRET'],
							 'CALLBACK'=>site_url('social/callback/Taobao')
							 );
					break;			
			}
			
			$this->ci->session->set_userdata('social_api_info',$vendorinfo);
		}
	}

	private function get_vendorinfo($vendor){
		$info = array(
			'social_api_info'=>$this->ci->session->userdata('social_api_info'),
			'social_'.$vendor.'_info'=>$this->ci->session->userdata('social_'.$vendor.'_info')
		);
		return $info;
	}

	public function connect($vendor){
		$driver_class = 'Driver_'.$vendor;
		if(file_exists($driver_class_path = APPPATH.'libraries/connect/drivers/'.$driver_class.'.php')) {
			include_once $driver_class_path;
			if(class_exists($driver_class)){
				$this->init_vendorinfo($vendor);
				$info = $this->get_vendorinfo($vendor);
				$driver = new $driver_class($info);
				$driver->goto_loginpage();
			}else{
				show_error('Class not Found:'.$driver_class);
			}
		}else{
			show_error('File Not Found:'.$driver_class_path);
		}
	}
 
	public function get_accesstoken($vendor){
		$driver_class = 'Driver_'.$vendor;
		if(file_exists($driver_class_path = APPPATH.'libraries/connect/drivers/'.$driver_class.'.php')) {
			include_once $driver_class_path;
			if(class_exists($driver_class)){
				$info = $this->get_vendorinfo($vendor);
				$driver = new $driver_class($info);
				$token = $driver->get_accesstoken();
				if(!token){
					show_error('Can\'t get access token:'.$driver_class);
					return;
				}
				$this->ci->session->set_userdata($token);
			}else{
				show_error('Class not Found:'.$driver_class);
			}
		}else{
			show_error('File Not Found:'.$driver_class_path);
		}
	}

	public function get_userinfo($vendor){
		$driver_class = 'Driver_'.$vendor;
		if(file_exists($driver_class_path = APPPATH.'libraries/connect/drivers/'.$driver_class.'.php')) {
			include_once $driver_class_path;
			if(class_exists($driver_class)){
				$info = $this->get_vendorinfo($vendor);
				$driver = new $driver_class($info);
				$result = $driver->get_userinfo();
				if(!result||count($result)==0){
					show_error('Can\'t get user info:'.$vendor);
					return;
				}
				return $result;
			}else{
				show_error('Class not Found:'.$driver_class);
			}
		}else{
			show_error('File Not Found:'.$driver_class_path);
		}
	}


}
