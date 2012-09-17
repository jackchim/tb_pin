<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo base_url('themes/admin/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url('themes/admin/css/admin.css'); ?>" type="text/css" rel="stylesheet" />
<title>后台登录界面</title>
<script language="JavaScript"> 
if (window != top) 
top.location.href = location.href; 
</script>
</head>
<body class="body_login">
<div class="admin_login">
<div class="admin_login_header">
<img src="<?php echo base_url('themes/admin/images/admin_logo.png'); ?>" alt="logo" />
</div>
<div class="admin_login_form">
  <form action="<?php echo site_url('admin/login');?>" method="post" class="form-horizontal settingform">
        <fieldset>
          <?php if($msg): ?>
          <div class=" control-group">
        	<div class="alert alert-error"><?php echo $msg; ?></div>
       	  </div>
       	  <?php endif; ?>
          <div class="control-group">
            <label class="control-label" for="email">管理员账户</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="email" name="email">
            </div>
          </div>
           <div class="control-group">
            <label class="control-label" for="password">密码</label>
            <div class="controls">
              <input type="password" class="input-xlarge" id="password" name="password">
            </div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-info">登录</button>
          </div>
        </fieldset>
      </form>
</div>
</div>
</body>
</html>
