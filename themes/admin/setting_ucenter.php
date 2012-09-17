<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="<?php echo base_url('themes/admin/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url('themes/admin/css/admin.css'); ?>" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url('assets/js/jquery-1.7.2.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('themes/admin/js/jquery.form.js'); ?>" type="text/javascript"></script>
<title>后台登录界面</title>
</head>

<body>
<div class="formmain">
<?php
echo $tpl_setting_header;
?>
<div class="formbox">
  <form id="ucenter_form" action="<?php echo site_url('admin/setting_ucenter');?>" method="post"  class="form-horizontal settingform" onsubmit="return false;">
        <fieldset>
          <?php if(validation_errors()): ?>
          <div class=" control-group">
        	<div class="alert alert-error"><?php echo validation_errors(); ?></div>
       	  </div>
       	  <?php endif; ?>
          <div class="control-group">
            <label class="control-label" for="site_name">开启Ucenter</label>
            <div class="controls">
              <label><input type="radio" name="is_active" value="0" <?php if (!isset($ucenter['is_active']) || $ucenter['is_active'] == 0) echo "checked";?> />关闭</label>
              <label><input type="radio" name="is_active" value="1" <?php if ($ucenter['is_active'] == 1) echo "checked";?> />开启</label>
            </div>
          </div>
           <div class="control-group">
            <label class="control-label" for="site_domain">UCener服务器地址</label>
            <div class="controls">
              <input type="text"  class="input-xlarge" id="uc_api" name="uc_api" value="<?php echo  (set_value('uc_api')) ? set_value('uc_api') : $ucenter['uc_api'];?>">
              <p class="help-block">末尾不要加 /</p>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="site_domain">通信密钥</label>
            <div class="controls">
              <input type="text"  class="input-xlarge" id="uc_key" name="uc_key" value="<?php echo  (set_value('uc_key')) ? set_value('uc_key') : $ucenter['uc_key'];?>">
              
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="site_domain">本地客户端应用ID</label>
            <div class="controls">
              <input type="text"  class="input-xlarge" id="uc_apiid" name="uc_apiid" value="<?php echo  (set_value('uc_apiid')) ? set_value('uc_apiid') : $ucenter['uc_apiid'];?>">
              <p class="help-block"></p>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="site_domain">数据库服务器主机名</label>
            <div class="controls">
              <input type="text"  class="input-xlarge" id="uc_host" name="uc_host" value="<?php echo  (set_value('uc_host')) ? set_value('uc_host') : $ucenter['uc_host'];?>">
              <p class="help-block"></p>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="site_domain">服务器数据库名</label>
            <div class="controls">
              <input type="text"  class="input-xlarge" id="uc_dbname" name="uc_dbname" value="<?php echo  (set_value('uc_dbname')) ? set_value('uc_dbname') : $ucenter['uc_dbname'];?>">
              <p class="help-block"></p>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="site_domain">数据库用户名</label>
            <div class="controls">
              <input type="text"  class="input-xlarge" id="uc_dbuser" name="uc_dbuser" value="<?php echo  (set_value('uc_dbuser')) ? set_value('uc_dbuser') : $ucenter['uc_dbuser'];?>">
              <p class="help-block"></p>
            </div>
          </div>
           <div class="control-group">
            <label class="control-label" for="site_domain">服务器数据库密码</label>
            <div class="controls">
              <input type="text"  class="input-xlarge" id="uc_dbpw" name="uc_dbpw" value="<?php echo  (set_value('uc_dbpw')) ? set_value('uc_dbpw') : $ucenter['uc_dbpw'];?>">
              <p class="help-block"></p>
            </div>
          </div>
           <div class="control-group">
            <label class="control-label" for="site_domain">服务器数据表前缀</label>
            <div class="controls">
              <input type="text"  class="input-xlarge" id="uc_dbtablepre" name="uc_dbtablepre" value="<?php echo  (set_value('uc_dbtablepre')) ? set_value('uc_dbtablepre') : $ucenter['uc_dbtablepre'];?>">
              <p class="help-block"></p>
            </div>
          </div>
           <div class="control-group">
            <label class="control-label" for="site_domain">数据库字符集</label>
            <div class="controls">
              <input type="text"  class="input-xlarge" id="uc_dbcharset" name="uc_dbcharset" value="<?php echo  (set_value('uc_dbcharset')) ? set_value('uc_dbcharset') : $ucenter['uc_dbcharset'];?>">
              <p class="help-block"></p>
            </div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-info" onclick="return ajaxDoFormAction('ucenter_form');">确定</button> 
          </div>
        </fieldset>
      </form>
</div>
</div>
</div>
</body>
</html>
<script>
function ajaxDoFormAction(formId){
	var options = {
		    success: function(txt) {
				//alert(txt);
				if(txt == 1){
					alert('数据已保存');
				}
				else{
					alert('数据保存失败');
				}
		    }
	};		
	$('#'+formId).ajaxSubmit(options);
    return false;	
} 
</script>   
