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
  <form id="save_api_form" onsubmit="return false;" action="<?php echo site_url('admin/setting_api');?>" method="post" class="form-horizontal settingform">
        <fieldset>
          <?php if(validation_errors()): ?>
          <div class=" control-group">
        	<div class="alert alert-error"><?php echo validation_errors(); ?></div>
       	  </div>
       	  <?php endif; ?>
          <div class="control-group">
            <label class="control-label" for="input01">Sina</label>
            <div class="controls">
              <span>App Key:</span><input type="text" class="input-xlarge" id="sina_appkey" name="sina_appkey" value="<?php echo $api['Sina']['APPKEY'];?>">
              <span>App Secret:</span><input type="text" class="input-xlarge" id="sina_appsecret" name="sina_appsecret" value="<?php echo  $api['Sina']['APPSECRET'];?>">
              <p class="help-block">申请地址: http://open.weibo.com/connect </p>
            </div>
          </div>
           <div class="control-group">
            <label class="control-label" for="input01">QQ</label>
            <div class="controls">
              <span>App Key:</span><input type="text" class="input-xlarge" id="qq_appkey" name="qq_appkey" value="<?php echo  $api['QQ']['APPKEY'];?>">
              <span>App Secret:</span><input type="text" class="input-xlarge" id="qq_appsecret" name="qq_appsecret" value="<?php echo  $api['QQ']['APPSECRET'];?>">
              <p class="help-block">申请地址: http://connect.qq.com/ </p>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">Renren</label>
            <div class="controls">
              <span>App Key:</span><input type="text" class="input-xlarge" id="renren_appkey" name="renren_appkey" value="<?php echo $api['Renren']['APPKEY'];?>">
              <span>App Secret:</span><input type="text" class="input-xlarge" id="renren_appsecret" name="renren_appsecret" value="<?php echo $api['Renren']['APPSECRET'];?>">
              <p class="help-block">申请地址: http://dev.renren.com/website </p>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">Taobao</label>
            <div class="controls">
              <span>App Key:</span><input type="text" class="input-xlarge" id="taobao_appkey" name="taobao_appkey" value="<?php echo   $api['Taobao']['APPKEY'];?>">
              <span>App Secret:</span><input type="text" class="input-xlarge" id="taobao_appsecret" name="taobao_appsecret" value="<?php echo $api['Taobao']['APPSECRET'];?>"><br />
              <span>淘宝客PID:</span><input type="text" class="input-xlarge" id="taobao_pid" name="taobao_pid" value="<?php echo $api['Taobao']['PID'];?>">
              <p class="help-block">App key申请地址: http://open.taobao.com/index.htm  淘宝客PID: http://www.alimama.com/</p>
            </div>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-info" onclick="ajaxDoFormAction('save_api_form')">确定</button> 
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
