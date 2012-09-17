<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="<?php echo base_url('themes/admin/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url('themes/admin/css/admin.css'); ?>" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url('assets/js/jquery-1.7.2.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('themes/admin/js/jquery.form.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('themes/admin/js/ajaxupload/fileuploader.js'); ?>" type="text/javascript"></script>
<link href="<?php echo base_url('themes/admin/js/ajaxupload/fileuploader.css'); ?>" type="text/css" rel="stylesheet" />
<title>后台登录界面</title>
<style>
.qq-upload-list{display:none;}
</style>
</head>

<body>
<div class="formmain">
<?php
echo $tpl_setting_header;
if (empty($logo)) {
	$logo = 'assets/img/logo.png';
}
?>
	<div class="formbox">
		<form action="" id="upload_logo_form" name="upload_logo" method="post"  class="form-horizontal settingform" style="padding:0 30px;" enctype="multipart/form-data" onsubmit="return false;">
		<fieldset>	
		<ul class="thumbnails">
				<li>
					<div class="thumbnail">
						<p id="file-info">
							<img id="logo_image" alt="" src="<?php echo site_url($logo)?>" width="185" height="60">
						</p>
						
					</div>
				</li>
				
			</ul>
			<div class="caption" id="file-uploader">
				<noscript>			
					<p>Please enable JavaScript to use file uploader.</p>
				</noscript>  
			</div>
			<p style="padding-top:7px;">为了前台页面的美观，请上传 185px X 60px 规格的图片</p>
		<div class="form-actions">
			<input type="hidden" name="logo_file" id="logo_file" value="<?php echo $logo;?>" />
            <button type="submit" class="btn btn-info" onclick="ajaxDoFormAction('upload_logo_form')">保存</button> 
          </div>
         </fieldset>
		</form>
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
function createUploader(){            
    var uploader = new qq.FileUploader({
        element: document.getElementById('file-uploader'),
        action: '<?php echo site_url('admin/upload_logo');?>',
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
        sizeLimit: 10*1024*1024, // max size
		minSizeLimit: 0, // min size
        onSubmit: function(id, fileName){},
		onProgress: function(id, fileName, loaded, total){},
		onComplete: function(id, fileName, responseJSON){
			if(responseJSON.success){
				//alert('上传成功');
				$('#logo_image').attr('src' , responseJSON.file_full_url);
				$('#logo_file').val(responseJSON.file);
			}else{
				alert('上传失败');
			}
		},
		onCancel: function(id, fileName){},
        debug: false
    });           
}

// in your app create uploader as soon as the DOM is ready
// don't wait for the window to load  
window.onload = createUploader;     
</script>    
