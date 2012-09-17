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
<link href="<?php echo base_url("themes/update/update.css"); ?>" rel="stylesheet" type="text/css" />
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
    height:30px;
    line-height:30px;
}
</style>
</head>
<body>
 
<div class="update_wrap">
	<?php if (isset($show_download) && $show_download == 1){?>
	<div align="center" class="warning" style="font-size:16px;">当前版本为 <b><?php echo $local_version;?></b> ， 服务器最新版本为 <b><?php echo $version;?></b> 点击<a target="_blank" href="<?php echo $download;?>">下载最新版本</a></div>
	<?php }?>
	<div class="update_fm">
    	<div class="update_fm_logo"></div>
		<div class="content">

            <h1>欢迎使用爱图谱安装程序</h1>
            <p>一、版本检测</p>
            <?php if($is_need_update): ?>
            <ul><li>您现在的版本：<?php echo $old_version; ?></li><li>您可以升级到：<?php echo $new_version; ?></li></ul>
            <?php  else:?>
             <ul><li>您已经是最新版本：<?php echo $old_version; ?>无需升级</li></ul>
            <?php endif;?>
            
            <span class="content_sp">
	            <a href="javascript:void(0);" onclick="window.close();window.location.href='about:blank'"  class="update_bt">放弃升级</a>
	            <?php  if($is_need_update):?>
	            <a href="<?php echo site_url('update/do_update'); ?>" class="update_bt">立即升级</a>
	            <?php else:?>
	            <a href="javascript:void(0)" class="update_bt03">立即升级</a>
	            <?php  endif;?>
            </span> 
            
                      
		</div>
	</div>
</div>
</body>
</html>