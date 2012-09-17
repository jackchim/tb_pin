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
class Install extends CI_Controller {

	 public function __construct() {
		parent::__construct();
		$this->load->set_install_theme();

	 }
	 
	
	 
	 public function index() {
	 	$data['theme_url'] = base_url('themes/install');
		$this->load->view('install/index', $data, false);
	 }
	 
	 public function step1() {
	 	
	 	$this->load->library('Curl_Class' , array() , 'url_obj');
	 	$url = "http://www.duobianxing.com/release/check_version.php?key=".md5('aitupu');
	 	$result = @$this -> url_obj -> get($url);
	 	$result = json_decode($result);
	 	
	 	$this->config->load('custom',TRUE);
		$custom =  $this->config->item('custom');
	 	if ($custom['version'] && ($result -> version > $custom['version'])) {//如果用户版本低于官网的最新版本，提示下载页面
	 		$data['show_download']  = 1;
	 		$data['local_version'] = @$this -> format_version_tostring(intval($custom['version']));
	 		$data['version']       = @$this -> format_version_tostring(intval($result -> version));
	 		$data['download']      = $result -> download;
	 	}
	 	
		//环境检测配置		
		$env['phpversion'] = array('curr_version'=> phpversion(),'lowest_version'=>'5.2.0','check'=>true);
		
		//PHP库检测配置
		$func['mysql'] = array('func'=>'mysql_connect','check'=>true);
		$func['GD']	= array('func'=>'gd_info','check'=>true);
		$func['iconv'] = array('func'=>'iconv','check'=>true);
		$func['JSON'] = array('func'=>'json_encode','check'=>true);
		$func['CURL'] = array('func'=>'curl_init','check'=>true);

		//权限检测配置
		$files['data'] = 								array('lowest_attrib'=>'777','curr_attrib'=>'','check'=>true);
		$files['data/advert'] = 						array('lowest_attrib'=>'777','curr_attrib'=>'','check'=>true);
		$files['data/attachments'] = 					array('lowest_attrib'=>'777','curr_attrib'=>'','check'=>true);
		$files['data/attachments/tmp'] = 				array('lowest_attrib'=>'777','curr_attrib'=>'','check'=>true);
		$files['data/avatars'] = 						array('lowest_attrib'=>'777','curr_attrib'=>'','check'=>true);
		$files['data/database'] = 						array('lowest_attrib'=>'777','curr_attrib'=>'','check'=>true);
		$files['data/images'] = 						array('lowest_attrib'=>'777','curr_attrib'=>'','check'=>true);
		$files['data/logo'] = 							array('lowest_attrib'=>'777','curr_attrib'=>'','check'=>true);
		$files['application/config'] = 					array('lowest_attrib'=>'660','curr_attrib'=>'','check'=>true);
		$files['application/config/custom.php'] = 		array('lowest_attrib'=>'','curr_attrib'=>'','check'=>true);
		$files['application/config/database.php'] = 	array('lowest_attrib'=>'','curr_attrib'=>'','check'=>true);
		$files['application/config/routes.php'] = 		array('lowest_attrib'=>'','curr_attrib'=>'','check'=>true);
		$files['application/config/seo_setting.php'] = 	array('lowest_attrib'=>'','curr_attrib'=>'','check'=>true);
		$files['application/config/database.php'] = 	array('lowest_attrib'=>'','curr_attrib'=>'','check'=>true);
		$files['application/config/user_badword.php'] = array('lowest_attrib'=>'','curr_attrib'=>'','check'=>true);

		//分别进行检测，结果计入$check_result		
		$check_result = array();
		$check_result['env'] = $env;
		$check_result['func'] = $func;
		$check_result['files'] = $files;
		$check_result['total_check'] = true;
		
		//环境检测
		foreach($env as $key=>$value) {
			if (strnatcmp($env[$key]['curr_version'],$env[$key]['lowest_version']) < 0) { 
				$check_result['env'][$key]['check'] = false;
				$check_result['total_check'] = false;
			}	
		}
		
		//PHP库检测
		foreach($func as $key=>$value) {
			if(!function_exists($value['func'])){
				$check_result['func'][$key]['check'] = false;
				$check_result['total_check'] = false;
			}

		}
	
		//文件权限检测
		$this->load->helper('file');
		foreach($files as $key=>$value) {
			$attrib = octal_permissions(@fileperms(FCPATH.$key));
			$check_result['files'][$key]['curr_attrib'] = $attrib;
			
			if(is_dir(FCPATH.$key)){
				if($attrib != '777'){
					$check_result['files'][$key]['check'] = false;
					$check_result['total_check'] = false;
				}
			}else{
				if(!is_writable(FCPATH.$key) ){
					$check_result['files'][$key]['check'] = false;
					$check_result['total_check'] = false;
				}
			}
		}
				
	 	$data['check_result'] = $check_result;
	 	$data['theme_url'] = base_url('themes/install');
		$this->load->view('install/step1', $data, false);
	 }
	 
	 public function step2() {
	 
 		if($this->input->post()){
 			
 			//数据库配置信息
			$db['hostname'] = $this->input->post('db_hostname',true);
			$db['username'] = $this->input->post('db_username',true);
			$db['password'] = $this->input->post('db_password',true);
			$db['database'] = $this->input->post('db_database',true);
			$db['dbprefix'] = $this->input->post('db_dbprefix',true);
			if($db['dbprefix']) {
				$db['dbprefix'] = (substr($db['dbprefix'],-1) == '_') ? $db['dbprefix'] : $db['dbprefix'].'_';
			}
			$drop_tables = $this->input->post('drop_table',true);
			
			//管理员账号
			$adm_user['adm_email'] = $this->input->post('adm_email',true);
			$adm_user['adm_passwd'] = $this->input->post('adm_passwd',true);
			$adm_user['adm_nickname'] = $this->input->post('adm_nickname',true);


			//载入文件读写函数
			$this->load->helper('file');
			
			//修改数据库配置文件
			$database_example_file = FCPATH . 'application/config/database.example.php';
			$database_out_file = FCPATH . 'application/config/database.php';
			$database_conf = read_file($database_example_file);
			$database_conf = str_replace(
								array('{hostname}','{username}','{password}','{database}','{dbprefix}'),
								array($db['hostname'],$db['username'],$db['password'],$db['database'],$db['dbprefix']),
								$database_conf);
			
			$break = false;
			//开始写入文件
			if(!$break) {
				if (! write_file($database_out_file, $database_conf) ){
				     $data['message'] = '数据库配置文件写入失败，请检查文件权限:';
				     $break = true;
				}
			}
			if(!$break) {
				//执行数据库导入
			 	$result = $this->import_sql($db,$drop_tables,$adm_user);
			 	if($result['status'] == 200){
			 		 redirect('install/step3');
			 	}else{
			 		 $data['message'] = $result['message'];
			 	}
			}
			
		}

		$data['db'] = $db;
		$data['adm_user'] = $adm_user;

	 	$data['theme_url'] = base_url('themes/install');
		$this->load->view('install/step2', $data, false);
	 }

	 public function step3() {

		//修改路由配置文件
		$routes_file = FCPATH . 'application/config/routes.php';
		$routes_conf = read_file($routes_file);
		$routes_conf = str_replace('install/index','welcome/index',$routes_conf);

		if ( ! write_file($routes_file, $routes_conf) ){
			$data['message'] = '路由配置文件写入失败，请检查文件权限';
		}
		
	 	$data['theme_url'] = base_url('themes/install');
	 	$this->load->view('install/step3', $data, false);
	 }
	 
	 
	 public function import_sql($db,$drop_table = false,$adm_user){

		 if(!$db['hostname']  || !$db['username'] || !$db['database'] ){
			return array('status'=>500,'message'=>'数据库配置信息不完整，请确保填写完整');
		 }

		 if(!$adm_user['adm_email']  || !$adm_user['adm_passwd'] || !$adm_user['adm_nickname'] ){
			return array('status'=>500,'message'=>'管理员账号信息不完整，请确保填写完整');
		 }

		//初使化数据库
		$link = @mysql_connect($db['hostname'], $db['username'], $db['password']);
		if (!$link) {
			return array('status'=>500,'message'=>'数据库链接失败，请检查用户名密码配置是否正确');
		}
		if(!mysql_select_db($db['database'], $link)){
			return array('status'=>500,'message'=>'数据库不存在，请先建立数据库后再进行安装');
		}
		mysql_query("SET NAMES utf8");


		//处理上次安装的数据
		$old_table = $db['dbprefix'].'tupu_';
		$sql = "SHOW TABLE STATUS LIKE  '%{$old_table}%'";
	 	$result = mysql_query($sql);
	 	if( mysql_num_rows($result) > 0 ){
	 		if($drop_table){
				while($row = mysql_fetch_array($result))
				{
				   mysql_query("drop table {$row['Name']}");
				}
	 		}else{
			    return array('status'=> 500 ,'message'=> '数据表已存在，只有清除原数据表才能继续安装。' );
	 		}
	 	}


		//导入SQL文件
		$sql_file = read_file(FCPATH.'sql/database.sql');
		if($sql_file){
			$sqls = explode(";",$sql_file);
			$sqls = str_replace('{dbprefix}', $db['dbprefix'], $sqls);
			foreach($sqls as $sql){
				if(trim($sql) == '') continue;
				$query = mysql_query($sql);
				if (!$query) {
				    $message  = '数据库执行错误: ' . mysql_error . "\n<br />";
				    $message .= 'SQL语句: ' . $sql;
				    return array('status'=> 500,'message'=> $message );
				}
			}
		}else{
			return array('status'=> 500,'message'=> '安装文件不完整，请重新下载安装包。' );
		}
		
		
		//创建管理员账号
		$adm_email = $adm_user['adm_email'];
		$adm_passwd = md5($adm_user['adm_passwd']);
		$adm_nickname = $adm_user['adm_nickname'];
		$dbprefix = $db['dbprefix'];
		
		$sql = "UPDATE  `{$dbprefix}tupu_user` SET  `email` =  '{$adm_email}', `passwd` =  '{$adm_passwd}', `nickname` =  '{$adm_nickname}'   WHERE  `user_id` =1;";
		
		$result = mysql_query($sql);
		
		if (!$result) {
		    return array('status'=>500,'msg'=> '管理员账号建立失败，请重新安装。' );
		}
		
		
		return array('status'=>200,'msg'=> '数据库导入成功' );
		
		
		
		
	 }
	 

	 /**
	  * fomat the version from int to string
	  *
	  * @param unknown_type $version_arr
	  */
	 private function format_version_tostring($version_int){
	 	$fomat_version = str_split($version_int,1);
		$fomat_version_tostring = 'V'.implode('.',$fomat_version);
		return $fomat_version_tostring;
	 }
	 

}