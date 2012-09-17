<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array (
  'theme' => 'default',
  'site_info' => 
  array (
    'site_name' => '爱图谱',
    'site_domain' => 'http://www.aitupu.com',
  ),
  'mail_server' => 
  array (
    'protocol' => 'mail',
    'from' => 'no-reply@aitupu.com',
    'sender' => '爱图谱',
    'smtp_host' => '',
    'smtp_user' => '',
    'smtp_pass' => '',
    'smtp_port' => '',
  ),
  'mail_lost_password' => 
  array (
    'subject' => '密码取回通知',
    'template' => '用户名：{nickname}   地址：{set_password_url}   网站：{site_url}',
  ),
  'seo' => 
  array (
    'page_title' => '爱图谱',
    'keyword' => '爱图谱,社会化分享系统,视觉购物分享系统,瀑布流,php,mysql,开源',
    'description' => '开源免费的PHP+Mysql视觉购物分享系统',
  ),
  'version_info' => 
  array (
    'check_url' => 'temp',
    'mem_count' => 'data/attachments',
  ),
  'api' => 
  array (
    'Sina' => 
    array (
      'APPKEY' => '',
      'APPSECRET' => '',
    ),
    'QQ' => 
    array (
      'APPKEY' => '',
      'APPSECRET' => '',
    ),
    'Renren' => 
    array (
      'APPKEY' => '',
      'APPSECRET' => '',
    ),
    'Taobao' => 
    array (
      'APPKEY' => '',
      'APPSECRET' => '',
      'PID' => '29948364',
    ),
  ),
  'file' => 
  array (
    'upload_file_size' => '2048',
    'upload_file_type' => 'jpg|gif|png',
    'upload_image_size_h' => '2048',
    'upload_image_size_w' => '2048',
    'fetch_image_size_h' => '200',
    'fetch_image_size_w' => '200',
  ),
  'version' => '130',
);
