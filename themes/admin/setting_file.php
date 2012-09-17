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
<div class="formbox pl30">
  <form id="save_file_form" onsubmit="return false;" action="<?php echo site_url('admin/setting_file');?>" method="post" class="form-horizontal settingform">
        <fieldset>
          <?php if(validation_errors()): ?>
          <div class=" control-group">
        	<div class="alert alert-error"><?php echo validation_errors(); ?></div>
       	  </div>
       	  <?php endif; ?>
          <div class="control-group">
            <label class="control-label">允许上传的图片大小</label>
            <div class="controls">
              <input type="text" class="input-small" id="upload_file_size" name="upload_file_size" value="<?php echo (set_value('upload_file_size')) ? set_value('upload_file_size') : $file['upload_file_size'];?>"> KB
               <p class="help-block">1024KB等于1M</p>
            </div>
          </div>
           <div class="control-group">
            <label class="control-label">允许上传的图片类型</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="upload_file_type" name="upload_file_type"  value="<?php echo (set_value('upload_file_type')) ? set_value('upload_file_type') : $file['upload_file_type'];?>">
              <p class="help-block">附件类型包括(jpg|gif|png)</p>
            </div>
          </div>
            <div class="control-group">
            <label class="control-label">上传图片的最大尺寸</label>
            <div class="controls">
              宽 <input type="text" class="input-small" id="upload_image_size_h" name="upload_image_size_h"  value="<?php echo (set_value('upload_image_size_h')) ? set_value('upload_image_size_h') : $file['upload_image_size_h'];?>"> x高
               <input type="text" class="input-small" id="upload_image_size_w" name="upload_image_size_w" value="<?php echo (set_value('upload_image_size_w')) ? set_value('upload_image_size_w') : $file['upload_image_size_w'];?>"> Px
              <p class="help-block">在用户上传分享图片时，仅接受小于该尺寸的图片</p>
             </div>
          </div>
            <div class="control-group">
            <label class="control-label">远程抓取图片最小尺寸</label>
            <div class="controls">
              宽 <input type="text" class="input-small" id="fetch_image_size_h" name="fetch_image_size_h"  value="<?php echo (set_value('fetch_image_size_h')) ? set_value('fetch_image_size_h') : $file['fetch_image_size_h'];?>"> x高
               <input type="text" class="input-small" id="fetch_image_size_w" name="fetch_image_size_w" value="<?php echo (set_value('fetch_image_size_w')) ? set_value('fetch_image_size_w') : $file['fetch_image_size_w'];?>"> Px
              <p class="help-block">在抓取远端图片时，仅抓取大于该尺寸的图片</p>
            </div>
          </div>
         
          <div class="form-actions">
            <button type="submit" class="btn btn-info" onclick="ajaxDoFormAction('save_file_form')">确定</button> 
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
