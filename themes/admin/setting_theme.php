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
	<form action="" id="ajaxForm" method="post"  class="form-horizontal settingform" style="padding:0 30px;" onsubmit="return false;">
		<ul class="thumbnails">
			<?php foreach ($themes as $k => $v):?>
			<li>
				<div class="thumbnail">
					<a href="<?php echo base_url('themes/'.$k.'/'.$v['view'])?>" target="_blank" title="点击查看效果图"><img src="<?php echo base_url('themes/'.$k.'/'.$v['thumb'])?>" alt="点击查看效果图"></a>
					<div class="caption">
						<h5><?php echo $v['name']?></h5>
						<p>
							<input type="radio" name="theme" value="<?php echo $k;?>" <?php if ($theme == $k) echo "checked"?>/>
						</p>
					</div>
				</div>
			</li>
			<?php endforeach;?>
		</ul>
		<div class="form-actions">
         <button type="submit" class="btn btn-info" onclick="ajaxDoFormAction('ajaxForm')">保存</button> 
        </div> 
	</form>
</div>
</div>
</div>
</body>
</html>
<script type="text/javascript">
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
