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
<?php echo $tpl_setting_header;?>
<div class="formbox">
  <form id="save_basic_form" onsubmit="return false;" action="<?php echo site_url('admin/setting_basic');?>" method="post"  class="form-horizontal settingform">
        <fieldset>
          <?php if(validation_errors()): ?>
          <div class=" control-group">
        	<div class="alert alert-error"><?php echo validation_errors(); ?></div>
       	  </div>
       	  <?php endif; ?>
          <div class="control-group">
            <label class="control-label" for="site_name">站点名称</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="site_name" name="site_name" value="<?php echo (set_value('site_name')) ? set_value('site_name') : $site_info['site_name'];?>">
              <p class="help-block">请输入站点名称</p>
            </div>
          </div>
           <div class="control-group">
            <label class="control-label" for="site_domain">站点域名</label>
            <div class="controls">
              <input type="text"  class="input-xlarge" id="site_domain" name="site_domain" value="<?php echo  (set_value('site_domain')) ? set_value('site_domain') : $site_info['site_domain'];?>">
              <p class="help-block">请填写站点域名，格式为：http://www.youname.com</p>
            </div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-info" onclick="ajaxDoFormAction('save_basic_form');">确定</button> 
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
