<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_useravatar($uid){
	$uid = abs(intval($uid));
	$uid = sprintf("%09d", $uid);
	$dir1 = substr($uid, 0, 3);
	$dir2 = substr($uid, 3, 2);
	$dir3 = substr($uid, 5, 2);
	$info = array();
	$dir = 'data/avatars/'.$dir1.'/'.$dir2.'/'.$dir3.'/';
	$filename = substr($uid, -2).'_avatar';
	if (!file_exists(FCPATH.'/'.$dir.$filename.'_large.jpg')) {
		//如果没头像
		return 'assets/img/avatar';
	}
	return $dir.$filename;
}
function ubbReplace($str){
    $str = str_replace("<",'&lt;',$str);
    $str = str_replace(">",'&gt;',$str);
    $str = str_replace("\n",'<br/>',$str);
	$str = preg_replace("[\[/表情([0-9]*)\]]","<img src=\"".base_url('assets/js/face')."/face/$1.gif\" />",$str);
    return $str;
}
/**
 * seo优化
 * @author Cai Shengpeng
 */
function seo_set($seo_set = array()){
	$CI =& get_instance();
	$CI -> config -> load('seo_setting',TRUE);
	$settings =  $CI -> config -> item('seo_setting');
	
	$controller = strtolower($CI -> uri -> rsegments[1]);
	$action     = strtolower($CI -> uri -> rsegments[2]);
	$tmp_array = array();
	$key = $controller.'_'.$action;
	if (isset($settings[$key])) {
		$tmp_array = $settings[$key];
	}
	else {
		$tmp_array = $settings[$controller];
	}
	//var_dump($tmp_array);exit;
	if ($seo_set) {
		$tmp_array['title'] = str_replace('{seo_title}' , $seo_set['seo_title'] , $tmp_array['title']);
		$tmp_array['keywords'] = str_replace('{seo_keywords}' , $seo_set['seo_keywords'] , $tmp_array['keywords']);
		$tmp_array['description'] = str_replace('{seo_description}' , $seo_set['seo_description'] , $tmp_array['description']);
	}
	return $tmp_array;
}
/**
 * 铭感词过滤
 * @author Cai Shengpeng
 * 
 * @param string $str
 * @return string $str
 */
function replace_badword($str){
	
	$CI =& get_instance();
	//加载系统配置敏感词库
	$CI -> config ->load('system_badword',TRUE);
	$system_badword =  $CI -> config -> item('system_badword');
	//加载用户配置
	$CI -> config ->load('user_badword',TRUE);
	$user_badword =  $CI -> config -> item('user_badword');
	//连接系统词库和用户词库
	$badword['badword']= trim($system_badword['badword']).'|'.trim($user_badword['badword']);
	//替换换行
	$replace = array("\r\n", "\n", "\r");
	$badword = str_replace($replace , '|' , $badword['badword']);
	//转化成数组，并进行array('敏感词' => '*')结构处理
	$badword_array = explode("|" , $badword);
	$badword_array = array_combine($badword_array,array_fill(0,count($badword_array),'*'));
	
    return strtr($str , $badword_array);
}
/**
 * 加载js应用
 * */
function load_js_file($js_file_arrays=array()){
	$files_html="";
	if (!empty($js_file_arrays)) {
		if (is_array($js_file_arrays)) {
			foreach ($js_file_arrays as $file) {
				$files_html.="<script type='text/javascript' src='".$file."'></script>\n";
			}
		}
	}
	return $files_html;
}

function load_css_file($css_file_arrays=array()){
	$files_html="";
	if (!empty($css_file_arrays)) {
		if (is_array($css_file_arrays)) {
			foreach ($css_file_arrays as $file) {
				$files_html.="<link rel='stylesheet' type='text/css' href='".$file."' />\n";
			}
		}
	}
	return $files_html;
}
/**
 * 判断是否是ajax请求的通用方法，通常用于数据传输安全和防跳墙
 *
 * @return unknown
 */
function is_ajax_request(){
	 return $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
}
/**
 * 在开启ucenter的时候，定义变量
 *
 */
function set_ucenter_define(){
	$CI =& get_instance();
	$CI -> config ->load('ucenter',TRUE);
	$ucenter =  $CI -> config -> item('ucenter');
	
	define('UC_CONNECT', 'mysql');
	define('UC_DBHOST', $ucenter['uc_host']);
	define('UC_DBUSER', $ucenter['uc_dbuser']);
	define('UC_DBPW', $ucenter['uc_dbpw']);
	define('UC_DBNAME', $ucenter['uc_dbname']);
	define('UC_DBCHARSET', $ucenter['uc_dbcharset']);
	define('UC_DBTABLEPRE', $ucenter['uc_dbtablepre']);
	define('UC_DBCONNECT', '0');
	define('UC_KEY', $ucenter['uc_key']);
	define('UC_API', $ucenter['uc_api']);
	define('UC_CHARSET', 'utf-8');
	define('UC_IP', '');
	define('UC_APPID', $ucenter['uc_apiid']);
	define('UC_PPP', '20');
	
}


/**
 * 中文字符串截取
 * 
 * @access public
 * @param mixed $string  需要处理的字符串
 * @param mixed $length  截取长度
 * @param bool $append (default: false)  是否追加 ...
 * @return void
 */
function sub_string($string,$length,$append = false)
{
	if(strlen($string) <= $length )
	{
		return $string;
	}
	else
	{
		$i = 0;
		while ($i < $length)
		{
			$stringTMP = substr($string,$i,1);
			if ( ord($stringTMP) >=224 )
			{
				$stringTMP = substr($string,$i,3);
				$i = $i + 3;
			}
			elseif( ord($stringTMP) >=192 )
			{
				$stringTMP = substr($string,$i,2);
				$i = $i + 2;
			}
			else
			{
				$i = $i + 1;
			}
			$stringLast[] = $stringTMP;
		}
		$stringLast = implode("",$stringLast);
		if($append)
		{
			$stringLast .= "…";
		}
		return $stringLast;
	}
}
/**
 * 生成缩略图
 */
function makethumb($srcFile , $dstW = 0,$dstH = 0 , $file_name = '' , $save_dir = '')
{
	
	if (strpos($srcFile , 'http://') !== false) {
		$return = array(
			'w' => 200,
			'h' => 200,
			'image' => $srcFile,
		);
		return $return;
	}
	
	$srcFile = FCPATH.$srcFile.'_large.jpg';
	
	if ($save_dir == '') {
		$save_dir = "data/attachments/tmp";
	}
	if ($file_name == '') {
		$file_name = time();
	}
	$save  = FCPATH.'/'.$save_dir.'/'.$file_name.'.jpg';
	if (is_file($save)) {
		unlink($save);
	}
	$data = GetImageSize($srcFile);	
	switch ($data[2]) {
	case   1:
	      $im   =   @ImageCreateFromGIF($srcFile);
	      $type = 'gif';
	      break;
	case   2:
	      $im   =   @imagecreatefromjpeg($srcFile);
	      $type = 'jpg';
	      break;
	case   3:
	      $im   =   @ImageCreateFromPNG($srcFile);
	      $type = 'png';
	      break;
	}
	$srcW = ImageSX($im);
	$srcH = ImageSY($im);
	if ($dstW == 0) {
		$dstW = $srcW*($dstH/$srcH);
	}elseif ($dstH == 0){
		$dstH = $srcH*($dstW/$srcW );
	}
	$dstX = 0;
	$dstY = 0;
	if ($srcW*$dstH > $srcH*$dstW){
	      $fdstH = round($srcH*$dstW / $srcW);
	      $dstY = floor(($dstH-$fdstH) / 2);
	      $fdstW = $dstW;
	}else{
	      $fdstW = round($srcW * $dstH / $srcH);
	      $dstX = floor(($dstW - $fdstW) / 2);
	      $fdstH=$dstH;
	}
	//$ni = ImageCreate($dstW,$dstH);
	if($type!='gif' && function_exists('imagecreatetruecolor'))
        $ni = imagecreatetruecolor($dstW, $dstH);
    else
        $ni = imagecreate($dstW, $dstH);
	$dstX = ($dstX < 0) ? 0 : $dstX;
	$dstY = ($dstX < 0) ? 0 : $dstY;
	$dstX = ($dstX > ($dstW/2)) ? floor($dstW / 2) : $dstX;
	$dstY = ($dstY > ($dstH/2)) ? floor($dstH / s) : $dstY;
	
	if ($type == 'gif' || $type == 'png') {
		 $black  =  imagecolorallocate($ni,  0,0,0); 
		 imagecolortransparent($ni,$black);  //  设置为透明色，若注释掉该行则输出绿色的图
	}
	if('jpg'==$type || 'jpeg'==$type) 	imageinterlace($ni,true);
	
	$imageFun = 'image'.($type=='jpg'?'jpeg':$type);
	//$black = ImageColorAllocate($ni,0,0,0);//填充的背景色你可以重新指定，我用的是黑色
	//imagefilledrectangle($ni,0,0,$dstW,$dstH,$black);
	if(function_exists("ImageCopyResampled"))
        imagecopyresampled($ni, $im, $dstX, $dstY, 0, 0, $fdstW, $fdstH, $srcW,$srcH);
    else
        imagecopyresized($ni, $im, $dstX, $dstY, 0, 0, $fdstW, $fdstH,  $srcW,$srcH);
	//ImageCopyResized($ni,$im,$dstX,$dstY,0,0,$fdstW,$fdstH,$srcW,$srcH);
	if ($type == 'png') {
		$q = 9;
	}
	else {
		$q = 100;
	}
	$imageFun($ni , $save , $q);//如果你要把图片直接输出到浏览器，那么把第二个参数去掉，并用header()函数指定mine类型先
	imagedestroy($im);
	imagedestroy($ni);
	$return = array(
		'w' => $dstW,
		'h' => $dstH,
		'image' => makethumb($save_dir.'/'.$file_name.'.jpg?'.time()),
	);
	return $return;
}

function write_page_view($u_id = 0){
	$data = array();
	if (!$_SERVER['HTTP_REFERER']) {
		$data['form_url'] = 'other';
	}else {
		$data['form_url'] = urlencode($_SERVER['HTTP_REFERER']);
	}
	$data['page_url'] = urlencode('http://'.$_SERVER[HTTP_HOST].$_SERVER['REQUEST_URI']);
	$data['client_ip'] = get_ip();
	$data['view_time'] = time();
	if (!isset($u_id) || !is_numeric($u_id)) {
		$u_id = 0;
	}
	$data['u_id'] = $u_id;
	
	$CI = &get_instance();
	$CI -> load -> model('page_view_model');
	$CI -> page_view_model -> addRecord($data);
	return true;
}

function get_ip() {
    if ($_SERVER["HTTP_X_FORWARDED_FOR"])
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    else if ($_SERVER["HTTP_CLIENT_IP"])
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    else if ($_SERVER["REMOTE_ADDR"])
        $ip = $_SERVER["REMOTE_ADDR"];
    else if (getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else
        $ip = "unknown";
    return $ip;
}

function time_diff($time){
	if($time >0){ 
		$diff = floor((time()-$time)/60+1);
		if ($diff <60) {
		echo ($time?floor((time()-$time)/60+1):'1').'分钟前';
		}else{
			echo date('Y-m-d',$time); 
		}
	}else{
		return;
	 }
}

function is_gb2312($str){
	for($i=0; $i<strlen($str); $i++) {
	    $v = ord( $str[$i] );
	    if( $v > 127) {
	            if( ($v >= 228) && ($v <= 233) )
	            {
	                    if( ($i+2) >= (strlen($str) - 1)) return true;  // not enough characters
	                    $v1 = ord( $str[$i+1] );
	                    $v2 = ord( $str[$i+2] );
	                    if( ($v1 >= 128) && ($v1 <=191) && ($v2 >=128) && ($v2 <= 191) ) // utf编码
	                            return false;
	                    else
	                            return true;
	            }
	    }
	}
	return true;
}

function my_alert($alert = "", $url="") {     
    if (!empty($alert)) {     
        $alertstr = "alert('" . $alert . "');\n";     
    } else {     
        $alertstr = "";     
    }     
     
    if (empty ($url)) {     
        $gotoStr = "window.history.back();\n";     
    } else {     
        $gotoStr = "window.location.href='" . $url . "'\n";     
    }     
     
    $content = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
    $content .= "<script type=\"text/javascript\">\n";
    if (!empty($alertstr)) {     
        $content .= $alertstr;     
    }     
    $content .= $gotoStr;
    
    $content .= "</script>\n";     
     
    echo $content;
    exit;  
}
/**
 * gb2312编码字符串转换成utf8编码
 *
 * @param unknown_type $value
 * @return unknown
 */
function get_gb_to_utf8($value){
	$value_1 = $value;
	$value_2 = @iconv( "gb2312", "utf-8//IGNORE",$value_1);
	$value_3 = @iconv( "utf-8", "gb2312//IGNORE",$value_2);
	if (strlen($value_1) == strlen($value_3)){
		return $value_2;
	}else{
		return $value_1;
	}
}
function image_path_to_array($image_path){
	if ($imgs = unserialize($image_path)) {
		unset($imgs['intro']);
		if ($imgs['front_img']) {
			array_unshift($imgs , $imgs['front_img']);
		}
		unset($imgs['front_img']);
		return $imgs;
	}else{
		return $image_path;
	}
}

function get_image_intro($image_path){
	if ($imgs = unserialize($image_path)) {
		$intro = $imgs['intro'];
		if ($intro['front_intro']) {
			array_unshift($intro , $intro['front_intro']);
		}
		unset($intro['front_intro']);
		return $intro;
	}
	return false;
}
function get_item_first_image($image_path , $type = 'middle'){
	if ($imgs = unserialize($image_path)) {
		unset($imgs['intro']);
		if ($imgs['front_img']) {
			array_unshift($imgs , $imgs['front_img']);
		}
		unset($imgs['front_img']);
		if (strpos($imgs[0] , 'http://') !== false) {
			if ($type == 'middle') {
				return $imgs[0].'_200x200.jpg';
			}elseif ($type == 'large'){
				return $imgs[0].'_310x310.jpg';
			}elseif ($type == 'small'){
				return $imgs[0].'_100x100.jpg';
			}elseif ($type == 'square'){
				return $imgs[0].'_100x100.jpg';
			}
			return $imgs[0];
		}else {
			if ($type == 'middle') {
				return base_url($imgs[0].'_middle.jpg');
			}elseif ($type == 'large'){
				return base_url($imgs[0].'_large.jpg');
			}elseif ($type == 'small'){
				return base_url($imgs[0].'_small.jpg');
			}elseif ($type == 'square'){
				return base_url($imgs[0].'_square.jpg');
			}
			return base_url($imgs[0].'.jpg');
		}
	}
	if ($type == '') {
		return base_url($image_path.'.jpg');
	}
	return base_url($image_path.'_'.$type.'.jpg');
}

function get_one_img($img , $type = 'middle'){
	if (strpos($img , 'http://') !== false) {
		if ($type == 'middle') {
			return $img.'_200x200.jpg';
		}elseif ($type == 'large'){
			return $img.'_310x310.jpg';
		}elseif ($type == 'small'){
			return $img.'_100x100.jpg';
		}elseif ($type == 'square'){
			return $img.'_100x100.jpg';
		}
		return $img;
	}else {
		if ($type == 'middle') {
			return base_url($img.'_middle.jpg');
		}elseif ($type == 'large'){
			return base_url($img.'_large.jpg');
		}elseif ($type == 'small'){
			return base_url($img.'_small.jpg');
		}elseif ($type == 'square'){
			return base_url($img.'_square.jpg');
		}
		return base_url($img.'.jpg');
	}
}
//处理分享的图片
function deal_image_path($image_path , $is_remote = 0){
	$return = array();
	if ($imgs = unserialize($image_path)) {
		unset($imgs['intro']);
		if ($imgs['front_img']) {
			array_unshift($imgs , $imgs['front_img']);
		}
		unset($imgs['front_img']);
		//如果反序列化成功
		$count = count($imgs);
		$return['count'] = $count;
		if ($count > 2) {
			if ($is_remote == 1){
				$return['image'] = array(
					$imgs[0].'_200x200.jpg',
					$imgs[1].'_100x100.jpg',
					$imgs[2].'_100x100.jpg',
				);
			}else{
				$return['image'] = array(
					base_url($imgs[0].'_middle.jpg'),
					base_url($imgs[1].'_small.jpg'),
					base_url($imgs[2].'_small.jpg'),
				);
			}
		}else {
			if ($is_remote == 1){
				$return['image'] = $imgs[0].'_200x200.jpg';
			}else{
				$return['image'] = base_url($imgs[0].'_middle.jpg');
			}
		}
	}else{
		return base_url($image_path.'_middle.jpg');
	}
	return $return;
}


/**
 * 截取字符串
 *
 * @param string $string
 * @param int $sublen
 * @param int $start = 0
 * @param string $code = 'UTF-8'
 * @return string
 */
function cut_str($string, $sublen, $start = 0, $code = 'UTF-8'){ 
	if($code == 'UTF-8') { 
		$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/"; 
		preg_match_all($pa, $string, $t_string); 

		if(count($t_string[0]) - $start > $sublen) 
			return join('', array_slice($t_string[0], $start, $sublen))."..."; 
		
		return join('', array_slice($t_string[0], $start, $sublen)); 
	} 
	else { 
		$start = $start*2; 
		$sublen = $sublen*2; 
		$strlen = strlen($string); 
		$tmpstr = ''; 

		for($i=0; $i< $strlen; $i++){ 
			if($i>=$start && $i< ($start+$sublen)){ 
				if(ord(substr($string, $i, 1))>129) { 
					$tmpstr.= substr($string, $i, 2); 
				} 
				else { 
					$tmpstr.= substr($string, $i, 1); 
				} 
			} 
			if(ord(substr($string, $i, 1))>129) 
				$i++; 
		} 
		if(strlen($tmpstr)< $strlen ) $tmpstr.= "..."; 
			return $tmpstr; 
	} 
}