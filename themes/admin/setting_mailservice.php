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
  <form id="mailservice_form" action="<?php echo site_url('admin/setting_mailservice');?>" method="post" class="form-horizontal settingform" onsubmit="return false;">
        <fieldset>
          <div class="control-group">
            <label class="control-label" for="site_name">邮件服务器类型：</label>
            <div class="controls">
              <select name="protocol" onchange="change_op(this.value)">
              	<option value="mail" <?php if ($mail_server['protocol'] == 'mail') echo "selected";?>>mail</option>
              	<option value="smtp" <?php if ($mail_server['protocol'] == 'smtp') echo "selected";?>>smtp</option>
              </select>
            </div>
          </div>
         <div class="control-group">
            <label class="control-label">账号：</label>
            <div class="controls">
              <input type="text"  class="input-xlarge" name="from" value="<?php echo  $mail_server['from'];?>">
            </div>
          </div>
          
          <div class="control-group">
            <label class="control-label">发件人：</label>
            <div class="controls">
              <input type="text"  class="input-xlarge" name="sender" value="<?php echo  $mail_server['sender'];?>">
            </div>
          </div>
          
          <div class="control-group smtp">
            <label class="control-label">smtp服务器：</label>
            <div class="controls">
              <input type="text"  class="input-xlarge" name="smtp_host" value="<?php echo  $mail_server['smtp_host'];?>">
            </div>
          </div>
          
          <div class="control-group smtp">
            <label class="control-label">smtp账号：</label>
            <div class="controls">
              <input type="text"  class="input-xlarge" name="smtp_user" value="<?php echo  $mail_server['smtp_user'];?>">
            </div>
          </div>
          
          <div class="control-group smtp">
            <label class="control-label">smtp密码：</label>
            <div class="controls">
              <input type="text"  class="input-xlarge" name="smtp_pass" value="<?php echo  $mail_server['smtp_pass'];?>">
            </div>
          </div>
          
          <div class="control-group smtp">
            <label class="control-label">smtp端口：</label>
            <div class="controls">
              <input type="text"  class="input-xlarge" name="smtp_port" value="<?php echo  $mail_server['smtp_port'];?>">
            </div>
          </div>
          
          <div class="form-actions">
            <button type="submit" class="btn btn-info" onclick="ajaxDoFormAction('mailservice_form')">确定</button> 
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

function change_op(val){
	if(val == 'mail'){
		$('.smtp').hide();
	}else{
		$('.smtp').show();
	}
}
change_op('<?php echo $mail_server['protocol'];?>');
</script>  
