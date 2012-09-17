<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="<?php echo base_url('themes/admin/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url('themes/admin/css/admin.css'); ?>" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url('assets/js/jquery-1.7.2.min.js')?>" type="text/javascript"></script>
<script>
	var jq=jQuery.noConflict();
</script>
<title>后台登录界面</title>
</head>
<body>

<div class="tablebox_footer">
   <form action="<?php echo site_url('admin/friendlink?op=edit');?>" method="post" class="form-horizontal">
   <fieldset>
   
   <div class="control-group">
      <label class="control-label" for="input01">链接名称</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="link_title" name="link_title" value="<?php echo $vo -> link_title;?>" style="color:#999"/><span style="color:#ff4444;display:none;">&nbsp;*链接名称不能为空</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="input01">链接地址</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="link_url" name="link_url" value="<?php echo $vo -> link_url;?>" style="color:#999"/><span style="color:#ff4444;display:none;">&nbsp;*链接地址不能为空</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="input01">打开方式</label>
      <div class="controls">
        <label><input type="radio" name="link_target" value="_blank" <?php if ($vo -> link_target == '_blank') echo "checked";?>  />新窗口</label>
        <label><input type="radio" name="link_target" value="_self" <?php if ($vo -> link_target == '_self') echo "checked";?> />当前窗口</label>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="input01">显示排序</label>
      <div class="controls">
        <input type="text" class="input-small" id="display_order" name="display_order" value="<?php echo $vo -> display_order;?>" style="color:#999"/>
      </div>
    </div>
    <div class="form-actions">
  <button type="submit" class="btn btn-info" id="catogary_submit">保存</button>
  <input type="hidden" name="action" value="submit" />
  <input type="hidden" name="id" value="<?php echo $vo -> id;?>" />
  </div>
  </fieldset>
</form>
</div>
</body>
</html>