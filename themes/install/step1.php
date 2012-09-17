<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>爱图谱-安装程序</title>
<meta name="keywords" content="爱图谱,社会化分享系统,瀑布流,php,mysql,开源" />
<meta name="description" content="免费的PHP+Mysql社会化分享系统" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache"> 
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache"> 
<META HTTP-EQUIV="Expires" CONTENT="0">
<link href="<?php echo $theme_url;?>/loading.css" rel="stylesheet" type="text/css" />
<style>
.warning{
	background-color: #F2DEDE;
    border-color: #EED3D7;
    color: #B94A48;
    border-radius: 4px 4px 4px 4px;
    margin-bottom: 18px;
    padding: 8px 35px 8px 14px;
    text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
    font-size:12px;
    margin:10px 28px;
}
</style>
</head>
<body>
<div class="loading_wrap02">
	<div class="loading_fm">
    	<div class="loading_fm_logo"></div>
		<div class="content">
		
		<h1>安装第一步，环境检测</h1>
		<?php if (isset($show_download) && $show_download == 1){?>
		<div class="warning" style="font-size:16px;" align="center">您使用版本是：<b><?php echo $local_version;?></b> ， 官方最新版本为 <b><?php echo $version;?></b> 点击<a target="_blank" href="<?php echo $download;?>">下载最新版本</a></div>
		<?php }?>
<table width="890" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin:16px 0 25px 30px;" >
  <tr style="font-weight:bold;">
    <td>检测项目</td>
    <td>需求状态</td>
    <td>当前状态</td>
    <td>检测结果</td>
  </tr>
  
  <tr>
  <td colspan="4" style="text-align: left;">&nbsp;&nbsp;基础环境</td>
  </tr>
  <tr>
    <td>PHP</td>
    <td><?php echo $check_result['env']['phpversion']['lowest_version'] ?></td>
    <td><?php echo $check_result['env']['phpversion']['curr_version'] ?></td>
    <td>
    	<?php if($check_result['env']['phpversion']['check']) : ?>
    	<img src="<?php echo $theme_url;?>/images/right.gif" width="25" height="25" />
    	<?php else:?>
    	<img src="<?php echo $theme_url;?>/images/wrong.gif" width="25" height="25" />
    	<?php endif; ?>
    </td>
  </tr>

  <tr>
  <td colspan="4" style="text-align: left;">&nbsp;&nbsp;PHP库</td>
  </tr>
  <?php foreach($check_result['func'] as $key=>$value): ?>
  <tr>
    <td><?php echo $key;?></td>
    <td>开启</td>
    <td><?php echo ($value['check']) ? '开启' : '未开启';  ?></td>
    <td>
    	<?php if($value['check']) : ?>
    	<img src="<?php echo $theme_url;?>/images/right.gif" width="25" height="25" />
    	<?php else:?>
    	<img src="<?php echo $theme_url;?>/images/wrong.gif" width="25" height="25" />
    	<?php endif; ?>
    </td>
  </tr>
  <?php endforeach;?>

  <tr>
  <td colspan="4" style="text-align: left;">&nbsp;&nbsp;文件权限</td>
  </tr>
  <?php foreach($check_result['files'] as $key=>$value): ?>
  <tr>
    <td><?php echo $key;?></td>
    <td>可读写</td>
    <td><?php echo $value['curr_attrib'];?></td>
    <td>
    	<?php if($value['check']) : ?>
    	<img src="<?php echo $theme_url;?>/images/right.gif" width="25" height="25" />
    	<?php else:?>
    	<img src="<?php echo $theme_url;?>/images/wrong.gif" width="25" height="25" />
    	<?php endif; ?>
    </td>
  </tr>
  <?php endforeach;?>

  <tr>
  	<?php if($check_result['total_check'] ) : ?>
	 <td colspan="4" style="color:green; font-weight:normal; font-size:18px; line-height:36px;">环境检测：通过</td>
	<?php else: ?>
	 <td colspan="4" style="color:red; font-weight:normal; font-size:18px; line-height:36px;">环境检测：不通过</td>
	<?php endif;?>
  </tr>
</table>
	<span class="content_nb_but">
	<a href="<?php echo site_url('install/index'); ?>" class="loading_bt">上一步</a>
	<a href="<?php echo ($check_result['total_check']) ?  site_url('install/step2')  : 'javascript:void(0);'; ?>" class="loading_bt">下一步</a>
	</span>
		</div>
	</div>
</div>

</body>
</html>







