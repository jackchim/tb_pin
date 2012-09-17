<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="<?php echo base_url('themes/admin/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url('themes/admin/css/admin.css'); ?>" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url('assets/js/jquery-1.7.2.min.js')?>" type="text/javascript"></script>
<title>用户编辑</title>
</head>

<body>
<div class="tablebox_footer">
   <form action="<?php echo site_url('admin/user_list/edit/'.$user->user_id);?>" method="post" class="form-horizontal">
   <fieldset>
   
   <div class="control-group">
      <label class="control-label" for="input01">用户名</label>
      <div class="controls">
        <span class="input-xlarge"><?php echo $user->nickname;?></span>
      </div>
    </div>
   <div class="control-group">
      <label class="control-label" for="input01">用户密码</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="password" name="password">
      </div>
    </div>
    
     <div class="control-group">
     <?php if($user->user_type==3): ?>
      <label class="control-label" for="input01">取消管理员身份</label>
       <div class="controls">
        <input type="checkbox" class="input-xlarge" id="user_type" name="user_type" value="1">
      </div>
      <?php else: ?>
       <label class="control-label" for="input01">设为管理员身份</label>
       <div class="controls">
        <input type="checkbox" class="input-xlarge" id="user_type" name="user_type" value="3">
      </div>
      <?php endif;?>
    </div>
    
    <div class="control-group">
      <label class="control-label" for="input01">是否激活</label>
      <div class="controls">
       		<label class="radio">
                <input type="radio" name="is_active" id="optionsRadios1" value="1" <?php echo $user->is_active?'checked':'';?>>
          	已激活</label>
              <label class="radio">
                <input type="radio" name="is_active" id="optionsRadios2" value="0" <?php echo $user->is_active?'':'checked';?>>
                                未激活</label>
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