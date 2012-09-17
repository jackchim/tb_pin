<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="/favicon.ico" href="/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/favicon.ico" href="/favicon.ico" type="image/x-icon" />
<?php $seo_set = seo_set($seo_set);?>
<title><?php echo $seo_set['title'].$config_custom['site_info']['site_name']; ?></title>
<meta name="keywords" content="<?php echo $seo_set['keywords'].$config_custom['site_info']['site_name']; ?>" />
<meta name="description" content="<?php echo $seo_set['description'].$config_custom['site_info']['site_name']; ?>" />
<link href="<?php echo $theme_url;?>/css/reset_new.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $theme_url;?>/css/layout.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $theme_url;?>/css/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $theme_url;?>/css/index.css" rel="stylesheet" type="text/css" />
<link id="artDialog-skin" href="<?php echo base_url('assets/js/dialog/skins/simple.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/float/css/common.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/js/float/css/powerFloat.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php  echo $theme_url;?>/css/new.css" rel="stylesheet" type="text/css"/>
 <!--[if IE]>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/js/slide'); ?>/slidedeck.skin.ie.css" media="screen,handheld" />
        <![endif]-->
<script>
var site_url = '<?php echo (strpos(site_url(),'index.php') === false) ?site_url():site_url().'/';?>';
var base_url = '<?php echo base_url();?>';
var current_user_avatar = '<?php echo get_useravatar($sess_userinfo['uid']); ?>';
var current_nickname = '<?php echo $sess_userinfo['nickname'];?>';
var current_uid = '<?php echo $sess_userinfo['uid']; ?>';
var config_sina_key =  '<?php echo($config_custom["api"]["Sina"]["APPKEY"]); ?>';
var config_qq_key = '<?php echo($config_custom["api"]["QQ"]["APPKEY"]);?>';
</script>
<?php
echo load_css_file($page_css);
echo load_js_file($global_js);
echo load_js_file($page_js); 
?>
<style type="text/css">
#slidedeck_frame{height:300px;} 
</style>
</head>
<body id="tupu_body">
<!-- 头部 -->
<!--nheader-->
<div id="nheader">
	<!--header_top-->
	<div id="nheader_top">
		<!--nheader_mid_box-->
		<div class="nheader_mid_box">
			<!--mid_box_logo-->
			<div class="mid_box_logo">
				<a href="<?php echo site_url('welcome/index');?>"><img src="<?php echo $logo; ?>"/></a>
			</div>
			<!--/mid_box_logo-->
			<!--mix_box_account-->
			<div class="mix_box_account">
			<!--登录前-->
			<?php if(!$sess_userinfo): ?>
				<ul class="login_register"><li class="log_reg"><span><a href="<?php echo site_url('register/index'); ?>">注册</a></span><span><a href="javascript:void(0)" onclick="show_login('<?php echo $current_controller; ?>')">登录</a></span></li><li class="for_qq"><a href="javascript:void(0)" class="sina popup_social"" flag="QQ">QQ</a></li><li class="for_xinlang"><a href="javascript:void(0)" class="sina popup_social" flag="Sina">新浪</a></li><li class="for_renren"><a href="javascript:void(0)" class="sina popup_social" flag="Renren">人人网</a></li></ul>
			<!--登录前-->
					 <?php  else:?>
			<!--登录后-->
				<div class="afterLogin">
					<div class="leftPart"></div>
					<div class="centerPart">
							<span id="userImage"><img alt="头像"  src="<?php echo base_url($sess_userinfo['avatar_small']);?>"/></span>
							<span id="show_info_menu">
							<span id="userName"><a href="javascript:void(0)"><?php echo $sess_userinfo['nickname'];?></a></span>
                            <span id="dropdwonMenu"></span>
                            </span>
							<span id="sperateLine"></span>
                            <span id="edit"><a href="javascript:void(0)" onclick="fetch_url()"><img src="<?php echo $theme_url;?>/images/share_bt.png" /></a></span>
                            <span id="share"><a href="javascript:void(0)" onclick="fetch_url()">分享</a></span>
                            </div>
					<div class="rightPart"></div>
				</div>
				<?php endif;?>
			<!--登录后-->
			</div>
			<!--/mid_box_account-->
		</div>
		<!--/nheader_mid_box-->
	</div>
	<!--/header_top-->
<!--nheader menu-->
	<div id="nheader_menu">
		<!--menu_detai-->
		<div class="menu_detail_box">
			<!--menu_detail-->
			<div class="menu_detail">
			<ul><li class="ft14"><?php if(!$sess_userinfo): ?><a href='<?php echo site_url('welcome/index');?>'>首页</a><?php else:?><a href='<?php echo site_url('member/index');?>'>我的首页</a><?php endif; ?></li><li class="middle_line"></li><li class="ft14"><a href="<?php echo site_url('discovery/index'); ?>">发现</a></li><?php foreach ($category as $cate){ ?><li><a href="<?php echo site_url('category'); ?>/<?php echo $cate->category_name_en; ?>"><?php echo $cate->category_name_cn; ?></a></li><?php }?><li class="middle_line"></li><li class="ft14"><a href='<?php echo site_url('album') ?>'>专辑</a></li></ul>
			<!--/menu_detail-->
		</div>
		<!--menu_text-->
			<div class="menu_text">
				<div class="search_text"><input type="text" id="search_input" name="search" onkeypress="if(event.keyCode==13){ Javascript: window.location.href = site_url + 'search/'+ this.value; }" onblur="if(this.value==''){this.value='搜索'}" onfocus="if(this.value=='搜索') {this.value=''} " class="for_search_text" name="keyword" id="keyword" value="搜索"/></div>
				<!--for_search_max-->
			<div class="for_search_max" onclick="window.location.href = site_url + 'search/'+ $('#search_input').val();"></div>
			<!--/for_search_max-->
			</div>
			<!--/menu_text-->
		<!--/menu_detail-->
	
	</div>
<!--/nheader_menu-->
</div>
<!--space_bottom-->
	<div id="space_bottom"></div>
	<!--/space_bottom-->
<div class="dwarp" id="info_menu" style="display:none;">
	<ul>
	<li class="dwarp_li"><a href="<?php echo site_url('profile/index'); ?>">我的主页</a></li>
	<li class="dwarp_li"><a href="<?php echo site_url('u/'.$sess_userinfo['uid'].'/following'); ?>">我的好友</a></li>
	<li class="dwarp_li"><a href="<?php echo site_url('member/setting_info');  ?>">账号设置</a></li>
	<?php if($sess_userinfo['user_type'] == 3): ?>
	<li class="dwarp_li"><a href="<?php echo site_url('admin/index');  ?>">管理中心</a></li>
	<?php endif;?>
	<li class="dwarp_li"><a href="<?php echo site_url('login/logout'); ?>">退出</a></li>
    </ul>
</div>

<!--/nheader-->
<!--
<div id="space_ge"></div>
  -->
<script>

	$(function(){
		$(function(){
		$("#show_cat_menu").powerFloat({
			target: $("#category_menu"),
			showCall:function(){
				$("#category_menu").hover(function(){
					$("#show_cat_menu").addClass('header_nav_active');
				},function(){});
			},
			hideCall:function(){
				$("#show_cat_menu").removeClass('header_nav_active');
			}
		});
		$("#show_info_menu").powerFloat({
			target:$("#info_menu")
		});
		$("#show_homepage_menu").powerFloat({
			target:$("#homepage_menu"),
			showCall:function(){
				$("#homepage_menu").hover(function(){
					$("#show_homepage_menu").addClass('header_nav_active');
				},function(){});
			},
			hideCall:function(){
				$("#show_homepage_menu").removeClass('header_nav_active');
			}
		});
	});
	});
	
$(function(){
	$("div.mid_word").not(".find").hover(function(){
		var target = $(this);
		target.prev("div.bian_ju").addClass("for_bian_ju");
		target.next(".right_ju").addClass("for_right_ju");
		target.addClass('for_mid_word');

	},function(){
		var target = $(this);
		target.prev("div.bian_ju").removeClass("for_bian_ju");
		target.next(".right_ju").removeClass("for_right_ju");
		target.removeClass('for_mid_word');
	});
	window.onscroll=function(){
		var topPx= document.documentElement.scrollTop||document.body.scrollTop;
		if(topPx>=65){
			$("#nheader_menu:not(:animated)").css({position:'fixed',top:0});
		}else{
			$("#nheader_menu:not(:animated)").css({position:'static'});
		}
		//alert(topPx);
	}
		$("a.popup_social").die().live("click",function(){
			var flag = $(this).attr("flag");
			var TWin=TWinOpen(site_url+'login/social/'+flag,'TWin','900','550')
			
		});
});

</script>
<!-- 头部上半部分 -->


<!-- 下拉分类样式 -->




