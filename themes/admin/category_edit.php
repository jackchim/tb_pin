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
   <form action="<?php echo site_url('admin/category_list/edit/'.$category->category_id);?>" method="post" class="form-horizontal">
   <fieldset>
   
   <div class="control-group">
      <label class="control-label" for="input01">分类名称</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="category_name_cn" name="category_name_cn" value="<?php echo $category->category_name_cn?>"/><span id="noty_word" style="color:#ff4444;display:none;"> *分类名称不能为空</span>
      </div>
    </div>
    <div class="form-actions">
  <button type="submit" class="btn btn-info">保存</button>
  </div>
  </fieldset>
</form>
</div>
<script>
	$(function(){
		$("#category_name_cn]").click(function(){
			if($(this).val()=='')
			{
				alert(33);
				$("#noty_word").show();
			return false;
			}
			return true;
		});
	});
</script>

</body>
</html>