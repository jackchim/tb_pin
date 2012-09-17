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
  <form id="save_seo_form" action="<?php echo site_url('admin/setting_advance_seo');?>" method="post" class="form-horizontal settingform" onsubmit="return false;">
        <fieldset>
          <?php if(validation_errors()): ?>
          <div class=" control-group">
        	<div class="alert alert-error"><?php echo validation_errors(); ?></div>
       	  </div>
       	  <?php endif; ?>
       	  
          <div class="control-group">
            <label class="control-label" for="input01">首页标题</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="welcome_title" name="welcome[title]" value="<?php echo  (set_value('welcome_title')) ? set_value('welcome_title') :$settings['welcome']['title'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">首页关键字</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="welcome_keywords" name="welcome[keywords]" value="<?php echo  (set_value('welcome_keywords')) ? set_value('welcome_keywords') :$settings['welcome']['keywords'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">首页描述</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="welcome_description" name="welcome[description]" value="<?php echo  (set_value('welcome_description')) ? set_value('welcome_description') :$settings['welcome']['description'];?>">
            </div>
          </div>
          <!--/首页设置-->
          <div class="control-group">
            <label class="control-label" for="input01">最新分享标题</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="welcome_lastest_lastest_title" name="welcome_lastest[title]" value="<?php echo  (set_value('welcome_lastest_title')) ? set_value('welcome_lastest_title') :$settings['welcome_lastest']['title'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">最新分享关键字</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="welcome_lastest_keywords" name="welcome_lastest[keywords]" value="<?php echo  (set_value('welcome_lastest_keywords')) ? set_value('welcome_lastest_keywords') :$settings['welcome_lastest']['keywords'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">最新分享描述</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="welcome_lastest_description" name="welcome_lastest[description]" value="<?php echo  (set_value('welcome_lastest_description')) ? set_value('welcome_lastest_description') :$settings['welcome_lastest']['description'];?>">
            </div>
          </div>
          <!--最新分享-->
          <div class="control-group">
            <label class="control-label" for="input01">专辑首页标题</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="album_title" name="album[title]" value="<?php echo  (set_value('album_title')) ? set_value('album_title') :$settings['album']['title'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">专辑首页关键字</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="album_keywords" name="album[keywords]" value="<?php echo  (set_value('album_keywords')) ? set_value('album_keywords') :$settings['album']['keywords'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">专辑首页描述</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="album_description" name="album[description]" value="<?php echo  (set_value('album_description')) ? set_value('album_description') :$settings['album']['description'];?>">
            </div>
          </div>
          <!--/专辑首页-->
          <div class="control-group">
            <label class="control-label" for="input01">专辑分享列表标题</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="album_shares_title" name="album_shares[title]" value="<?php echo  (set_value('album_shares_title')) ? set_value('album_shares_title') :$settings['album_shares']['title'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">专辑分享列表关键字</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="album_shares_keywords" name="album_shares[keywords]" value="<?php echo  (set_value('album_shares_keywords')) ? set_value('album_shares_keywords') :$settings['album_shares']['keywords'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">专辑分享列表描述</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="album_shares_description" name="album_shares[description]" value="<?php echo  (set_value('album_shares_description')) ? set_value('album_shares_description') :$settings['album_shares']['description'];?>">
            </div>
          </div>
          <!--专辑分享列表页-->
          <div class="control-group">
            <label class="control-label" for="input01">登陆页面标题</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="login_title" name="login[title]" value="<?php echo  (set_value('login_title')) ? set_value('login_title') :$settings['login']['title'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">登陆页面关键字</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="login_keywords" name="login[keywords]" value="<?php echo  (set_value('login_keywords')) ? set_value('login_keywords') :$settings['login']['keywords'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">登陆页面描述</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="login_description" name="login[description]" value="<?php echo  (set_value('login_description')) ? set_value('login_description') :$settings['login']['description'];?>">
            </div>
          </div>
          <!--/登陆页面-->
          <div class="control-group">
            <label class="control-label" for="input01">注册页面标题</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="register_title" name="register[title]" value="<?php echo  (set_value('register_title')) ? set_value('register_title') :$settings['register']['title'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">注册页面关键字</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="register_keywords" name="register[keywords]" value="<?php echo  (set_value('register_keywords')) ? set_value('register_keywords') :$settings['register']['keywords'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">注册页面描述</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="register_description" name="register[description]" value="<?php echo  (set_value('register_description')) ? set_value('register_description') :$settings['register']['description'];?>">
            </div>
          </div>
          <!--/注册页面-->
          <div class="control-group">
            <label class="control-label" for="input01">分享详细页面标题</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="share_view_title" name="share_view[title]" value="<?php echo  (set_value('share_view_title')) ? set_value('share_view_title') :$settings['share_view']['title'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">分享详细页面关键字</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="share_view_keywords" name="share_view[keywords]" value="<?php echo  (set_value('share_view_keywords')) ? set_value('share_view_keywords') :$settings['share_view']['keywords'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">分享详细页面描述</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="share_view_description" name="share_view[description]" value="<?php echo  (set_value('share_view_description')) ? set_value('share_view_description') :$settings['share_view']['description'];?>">
            </div>
          </div>
          <!--/分享详细页面-->
          <div class="control-group">
            <label class="control-label" for="input01">发现模块页面标题</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="discovery_title" name="discovery[title]" value="<?php echo  (set_value('discovery_title')) ? set_value('discovery_title') :$settings['discovery']['title'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">发现模块页面关键字</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="discovery_keywords" name="discovery[keywords]" value="<?php echo  (set_value('discovery_keywords')) ? set_value('discovery_keywords') :$settings['discovery']['keywords'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">发现模块页面描述</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="discovery_description" name="discovery[description]" value="<?php echo  (set_value('discovery_description')) ? set_value('discovery_description') :$settings['discovery']['description'];?>">
            </div>
          </div>
          <!--/发现模块页面-->
          <div class="control-group">
            <label class="control-label" for="input01">发现分类页面标题</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="discovery_category_title" name="discovery_category[title]" value="<?php echo  (set_value('discovery_category_title')) ? set_value('discovery_category_title') :$settings['discovery_category']['title'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">发现分类页面关键字</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="discovery_category_keywords" name="discovery_category[keywords]" value="<?php echo  (set_value('discovery_category_keywords')) ? set_value('discovery_category_keywords') :$settings['discovery_category']['keywords'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">发现分类页面描述</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="discovery_category_description" name="discovery_category[description]" value="<?php echo  (set_value('discovery_category_description')) ? set_value('discovery_category_description') :$settings['discovery_category']['description'];?>">
            </div>
          </div>
          <!--/发现模块分类-->
          <div class="control-group">
            <label class="control-label" for="input01">搜索页面标题</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="discovery_search_title" name="discovery_search[title]" value="<?php echo  (set_value('discovery_search_title')) ? set_value('discovery_search_title') :$settings['discovery_search']['title'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">搜索页面关键字</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="discovery_search_keywords" name="discovery_search[keywords]" value="<?php echo  (set_value('discovery_search_keywords')) ? set_value('discovery_search_keywords') :$settings['discovery_search']['keywords'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">搜索页面描述</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="discovery_search_description" name="discovery_search[description]" value="<?php echo  (set_value('discovery_search_description')) ? set_value('discovery_search_description') :$settings['discovery_search']['description'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">个人主页标题</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="profile_title" name="profile[title]" value="<?php echo  (set_value('profile_title')) ? set_value('profile_title') :$settings['profile']['title'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">个人主页关键字</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="profile_keywords" name="profile[keywords]" value="<?php echo  (set_value('profile_keywords')) ? set_value('profile_keywords') :$settings['profile']['keywords'];?>">
            </div>
          </div>
          <div class="control-group">
            <label class="control-label" for="input01">个人主页描述</label>
            <div class="controls">
              <input type="text" class="input-xlarge" id="profile_description" name="profile[description]" value="<?php echo  (set_value('profile_description')) ? set_value('profile_description') :$settings['profile']['description'];?>">
            </div>
          </div>
          <!--/个人主页-->
          <div class="form-actions">
            <button type="submit" class="btn btn-info" onclick="ajaxDoFormAction('save_seo_form');">确定</button> 
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
