<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="<?php echo base_url('themes/admin/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url('themes/admin/css/admin.css'); ?>" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url('assets/js/jquery-1.7.2.min.js')?>" type="text/javascript"></script>
<title>后台登录界面</title>
</head>
<body>
<div class="tablebox_footer">
   <form action="<?php echo site_url('admin/adinfo/save/'.$adv->ad_id);?>" method="post" class="form-horizontal" enctype="multipart/form-data">
   <fieldset>
   <div class="control-group">
      <label class="control-label" for="input01">广告标题</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="category_name_cn" name="ad_title" value="<?php  echo $adv->ad_title;?>"/>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="input01">广告url连接地址</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="category_name_en" name="ad_url" value="<?php echo $adv->ad_url;?>" />
      </div>
    </div>
    
     <div class="control-group">
      <label class="control-label" for="input01">广告播放顺序</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="category_name_en" name="display_order" value="<?php echo $adv->display_order; ?>" />
      </div>
    </div>
    
     <div class="control-group">
      <label class="control-label" for="input01">广告位</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="category_name_en" name="ad_position" value="<?php echo $adv->ad_position;?>" />
      </div>
    </div>
     <div class="control-group">
      <label class="control-label" for="input01">广告图片</label>
      <div class="controls">
        <input type="text" class="input-xlarge" disabled="disabled" id="category_name_en" name="ad_photo" value="<?php echo $adv->ad_photo; ?>" />
      </div>
      <input type="hidden" name="ad_id" value="<?php echo $adv->ad_id;?>"/>
    </div>
    
     <div class="control-group">
      <label class="control-label" for="input01">上传广告图片</label>
      <div class="controls" style="position:relative;">
        <input type="button"  value="选择文件"/><input type="file" style="cursor:pointer;filter:Alpha(Opacity=0);opacity:0.0;width:10px;position:absolute;left:-10px;" size="1" id="adfile" name="adfile"/>&nbsp;&nbsp;&nbsp;&nbsp;
      </div>
    </div>
    <div class="form-actions">
  <button type="submit" class="btn">保存</button>
  </div>
  </fieldset>
</form>
</div>

</body>
</html>