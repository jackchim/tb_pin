<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>爱图谱-安装程序</title>
<meta name="keywords" content="爱图谱,社会化分享系统,瀑布流,php,mysql,开源" />
<meta name="description" content="免费的PHP+Mysql社会化分享系统" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache"> 
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache"> 
<META HTTP-EQUIV="Expires" CONTENT="0">
<link href="<?php echo $theme_url;?>/loading.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="loading_wrap">
	<div class="loading_fm">
    	<div class="loading_fm_logo"></div>
		<div class="content">
        
        	<form action="<?php echo site_url('install/step2'); ?>" method="POST" style="width:940px;">
            
             <!--<div class="login_h2">配置数据库</div-->

               <div class="content_nb_l">
               		<div class="login_h2">配置数据库</div>
                    <div>
                        <span class="right">数据库主机</span><input type="text" name="db_hostname" id="db_hostname" / class="content_nb_in" value="<?php echo $db['hostname']?>">
                    </div>
                    <div>
                        <span class="right">数据库用户名</span><input type="text" name="db_username" id="db_username" / class="content_nb_in" value="<?php echo $db['username']?>">
                    </div>
                    <div>
                        <span class="right">数据库密码</span><input type="password" name="db_password" id="db_password" / class="content_nb_in" value="<?php echo $db['password']?>">
                    </div>
                    <div>
                        <span class="right">数据库名称</span><input type="text" name="db_database" id="db_database" / class="content_nb_in" value="<?php echo $db['database']?>">
                    </div>
                    <div>
                        <span class="right">数据库表前缀</span><input type="text" name="db_dbprefix" id="db_dbprefix" / class="content_nb_in" value="<?php echo $db['dbprefix']?>">
                    </div>
                    <div>
                        <span class="right">是否清除原数据表</span><input type="checkbox" name="drop_table" id="drop_table" value="1" checked="" / class="content_nb_check">
                    </div>
                    
                </div>  

                
                <div class="content_nb_r">
                	<div class="login_h2">创建管理员</div>
                    <div>
                        <span class="right">登录邮箱</span><input type="text" name="adm_email" id="adm_email" / class="content_nb_in" value="<?php echo $adm_user['adm_email']?>">
                    </div>
                    <div>
                        <span class="right">密码</span><input type="password" name="adm_passwd" id="adm_passwd" / class="content_nb_in" value="<?php echo $adm_user['adm_passwd']?>">
                    </div>
                    <div>
                        <span class="right">昵称</span><input type="text" name="adm_nickname" id="adm_nickname" / class="content_nb_in" value="<?php echo $adm_user['adm_nickname']?>">
                    </div>
                </div>    

                    <div class="content_nb_but">
                        <button type="button" class="loading_bt" onclick="window.location.href = '<?php echo site_url('install/step1') ?>';">上一步</button>
                        <button type="submit" class="loading_bt">下一步</button>
                    </div> 

                </form>

            <div class="peizhi_num">
            <?php echo $message;?>
            </div>





		</div>
	</div>
</div>


</body>
</html>