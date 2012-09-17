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
  <form id="save_seo_form" onsubmit="return false;" action="<?php echo site_url('admin/setting_seo');?>" method="post" class="form-horizontal settingform">
        <fieldset>
          <?php if(validation_errors()): ?>
          <div class=" control-group">
        	<div class="alert alert-error"><?php echo validation_errors(); ?></div>
       	  </div>
       	  <?php endif; ?>
          <div class="control-group">
            <label class="control-label" for="input01">站点标题</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="page_title" name="page_title" value="<?php echo  (set_value('page_title')) ? set_value('page_title') : $seo['page_title'];?>">
                  <p class="help-block">请输入站点标题</p>
            </div>
          </div>
           <div class="control-group">
            <label class="control-label" for="input01">关键词</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="keyword" name="keyword" value="<?php echo (set_value('keyword')) ? set_value('keyword') :  $seo['keyword'];?>">
              <p class="help-block">请填写站点相关的关键词</p>
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">描述</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="description" name="description" value="<?php echo (set_value('description')) ? set_value('description') :  $seo['description'];?>">
              <p class="help-block">请填写站点描述</p>
            </div>
          </div>
          
          <div class="form-actions">
            <button type="submit" class="btn btn-info" onclick="ajaxDoFormAction('save_seo_form')">确定</button> 
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
