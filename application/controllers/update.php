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
 * @author      Gaozh
 * @filesource
 */
// ------------------------------------------------------------------------
/**
 * AiTuPu update Controller
 *
 *
 * @package		AiTuPu
 * @subpackage	Controllers 
 * @category	Controllers
 * @author		Duobianxing Studio Dev Team
 * @link		http://duobianxing.com/doc/index.html
 */
class Update extends CI_Controller {
	 public function __construct() {
		parent::__construct();
		header("Content-Type:text/html;charset=utf-8");//to tell the Broswer the Code
		$this->load->set_install_theme();
		@$this->load->database();
        $this->load->helper('file');
		define("CUR_VERSION",'130');//the Number to update 1.1.0
	 }
	 /**
	  * the access to update 
	  * load the config and have
	  * some version checking and
	  * make sure the version updated 
	  * absolutely
	  *
	  */
	 public function index(){
	 	$data  = array();
	 	
	 	$this->load->library('Curl_Class' , array() , 'url_obj');
	 	$url = "http://www.duobianxing.com/release/check_version.php?key=".md5('aitupu');
	 	$result = @$this -> url_obj -> get($url);
	 	$result = json_decode($result);
		
	 	if ($result -> version > CUR_VERSION) {//如果用户版本低于官网的最新版本，提示下载页面
	 		//exit('fsf');
	 		$data['show_download']  = 1;
	 		$data['local_version'] = @$this -> format_version_tostring(intval(CUR_VERSION));
	 		$data['version']       = @$this -> format_version_tostring(intval($result -> version));
	 		$data['download']      = $result -> download;
	 	}
	 	
	 	$this->config->load('custom',true);
		$custom = $this->config->item("custom");//old version Num
		$aitupu_old_version = $custom['version'];
		$aitupu_old_version = $aitupu_old_version ? $aitupu_old_version : '105';//ok ,if have then true else 105 default
		
		$cur_version = CUR_VERSION;
		$is_need_update = true;
		
		if($cur_version ==$aitupu_old_version || $cur_version < $aitupu_old_version)
		{
			$is_need_update = false;//不需要更新
		}
		$fomat_old_version_tostring = $this->format_version_tostring($aitupu_old_version);//int to string
		$fomat_cur_version_tostring = $this->format_version_tostring($cur_version);//int to string
		$data['old_version'] = $fomat_old_version_tostring;
		$data['new_version'] = $fomat_cur_version_tostring;
		$data['is_need_update'] = $is_need_update;
		$this->load->view("update/index.php",$data);
		
		//$this->import_sql();
	 }
	 
	 /**
	  * to upper update
	  *
	  */
	 public function do_update(){
	 	$this->config->load('custom',true);
	 	$cur_version = CUR_VERSION;
	 	$custom = $this->config->item("custom");//old version Num
		$aitupu_old_version = $custom['version'];
		$aitupu_old_version = $aitupu_old_version ? $aitupu_old_version : '105';//ok ,if have then true else 105 default
	 	$fomat_cur_version_tostring = $this->format_version_tostring($cur_version);//int to string
	 	$data = array();
	 	if($result =  $this->import_sql()){
	 		if (!$result['status']) {
	 			$data['result'] = $result;
	 			$this->load->view("update/error_02.php",$data);
	 		}else{
	 			$custom=$this->config->item("custom");
	 			$custom['version'] =CUR_VERSION;
	 			$this->config->set_item('custom', $custom);
	 			$this->config->save('custom');
	 			$data['cur_version'] = $fomat_cur_version_tostring;
	 			$this->load->view("update/success.php",$data);
	 		}
	 	}
	 	$this->load->view("update/updating.php");
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
	 /**
	  * import sql that the cur_version needed
	  * 
	  *
	  */
	 private function import_sql(){
	 	$this->config->load('custom',true);
	 	$custom = $this->config->item("custom");//old version Num
		$aitupu_old_version = $custom['version'];
		$aitupu_old_version = $aitupu_old_version ? $aitupu_old_version : '105';//ok ,if have then true else 105 default
	 	$sql_file = @read_file(FCPATH.'sql/database.sql');
	 	if (!$sql_file) {
	 		return array('status'=>false,'message'=>'database.sql文件不存在');
	 	}
	 	$pos = stripos($sql_file,'v'.$aitupu_old_version);
		 	if(!$pos){
	 		return array('status'=>false,'message'=>'未能在sql中找到正确的版本号');
	 	}
	    $multi_sql = substr($sql_file,$pos-5);//to prepare sql
	    if ($multi_sql) {
	    	$sqls = explode(";",$multi_sql);
	    	$sqls = str_replace('{dbprefix}', $this->db->dbprefix, $sqls);
	    	foreach($sqls as $sql){
				if(trim($sql) == '') continue;
				$query = $this->db->query($sql);
				if (!$query) {
				    $message  = '数据库执行错误: ' . mysql_error . "\n<br />";
				    $message .= 'SQL语句: ' . $sql;
				    return array('status'=> false,'message'=> str_ireplace("-",'',$message));
				}
			}
			return array('status'=>true,'msg'=> '数据库更新成功' );
	    }
	 } 
}