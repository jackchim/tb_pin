<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="<?php echo base_url('themes/admin/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url('themes/admin/css/admin.css'); ?>" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url('assets/js/jquery-1.7.2.min.js')?>" type="text/javascript"></script>
<title>后台登录界面</title>
</head>

<body>
<div class="admin_header">
<div class="logo"><img src="<?php echo base_url('themes/admin/images/admin_logo.png');?>" /></div>
<div class="login_info">下午好，<strong><?php echo $sess_userinfo['nickname']?></strong> <span>[超级管理员]</span>
	<a href="<?php echo site_url('welcome/index');?>" target="_blank">前台首页</a>
	<a href="<?php echo site_url('admin/logout');?>">退出</a></div>
</div>
<?php $action = $this->uri->segment(2);?>
<div id="content" class="admin_main" style="width:auto">
<div class="admin_menu">
<div id="Scroll">
<div id="menu" class="menu_list">
<dl class="active">
<dt><i class="menu_icon menu_home"></i>控制面板</dt>
<dd>
<ul>
<li<?php echo ($action == 'dashboard') ?  ' class="active"' : ''; ?>><a href="#" url="<?php echo site_url('admin/dashboard');?>"><i class="arrow_icon"></i>欢迎页</a></li>
</ul>
</dd>
</dl>
<dl>
<dt><i class="menu_icon menu_site"></i>站点设置</dt>
<dd>
<ul>
<li<?php echo ($action == 'setting_basic') ?  ' class="active"' : ''; ?>><a href="#" url="<?php echo site_url('admin/setting_basic');?>"><i class="arrow_icon"></i>基本设置</a></li>
<li<?php echo ($action == 'setting_advance_seo') ?  ' class="active"' : ''; ?>><a href="#" url="<?php echo site_url('admin/setting_advance_seo');?>"><i class="arrow_icon"></i>高级设置</a></li>
</ul>
</dd>
</dl>


<dl> 
<dt><i class="menu_icon menu_content"></i>分类管理</dt>
<dd>
<ul>
<li<?php echo ($action == 'category_list') ?  ' class="active"' : ''; ?>><a href="#" url="<?php echo site_url('admin/category_list');?>"><i class="arrow_icon"></i>分类管理</a></li>
<li<?php echo ($action == 'tag_list') ?  ' class="active"' : ''; ?>><a href="#" url="<?php echo site_url('admin/tag_list');?>"><i class="arrow_icon"></i>标签管理</a></li>

</ul>
</dd>
</dl>

<dl> 
<dt><i class="menu_icon menu_content"></i>内容管理</dt>
<dd>
<ul>
<li<?php echo ($action == 'album') ?  ' class="active"' : ''; ?>><a href="#" url="<?php echo site_url('admin/album_list');?>"><i class="arrow_icon"></i>专辑管理</a></li>
<li<?php echo ($action == 'item_list' || $action == 'item_edit') ?  ' class="active"' : ''; ?>><a href="#" url="<?php echo site_url('admin/item_list');?>"><i class="arrow_icon"></i>分享管理</a></li>
<li<?php echo ($action == 'comment_list') ?  ' class="active"' : ''; ?>><a href="#" url="<?php echo site_url('admin/comment_list');?>"><i class="arrow_icon"></i>评论管理</a></li>
</ul>
</dd>
</dl>

<dl> 
<dt><i class="menu_icon menu_content"></i>批量采集</dt>
<dd>
<ul>
<li<?php echo ($action == 'item_multi_post') ?  ' class="active"' : ''; ?>><a href="#" url="<?php echo site_url('admin/item_multi_post');?>"><i class="arrow_icon"></i>淘宝客采集</a></li>
<li<?php echo ($action == 'images_to_local') ?  ' class="active"' : ''; ?>><a href="#" url="<?php echo site_url('admin/images_to_local');?>"><i class="arrow_icon"></i>图片本地化</a></li>
</ul>
</dd>
</dl>

<dl>
<dt><i class="menu_icon menu_user"></i>用户管理</dt>
<dd>
<ul>
<li<?php echo ($action == 'user_list') ?  ' class="active"' : ''; ?>><a href="#" url="<?php echo site_url('admin/user_list');?>"><i class="arrow_icon"></i>会员管理</a></li>
</ul>
</dd>
</dl>

<dl>
<dt><i class="menu_icon menu_tools"></i>辅助功能</dt>
<dd>
<ul>
<li<?php echo ($action == 'advertize') ?  ' class="active"' : ''; ?>><a href="#" url="<?php echo site_url('admin/advertize');?>"><i class="arrow_icon"></i>广告管理</a></li>
<li<?php echo ($action == 'friendlink') ?  ' class="active"' : ''; ?>><a href="#" url="<?php echo site_url('admin/friendlink');?>"><i class="arrow_icon"></i>友情链接</a></li>
<li<?php echo ($action == 'database_management') ?  ' class="active"' : ''; ?>><a href="#" url="<?php echo site_url('admin/database_management');?>"><i class="arrow_icon"></i>数据备份</a></li>
</ul>
</dd>
</dl>
<dl>
<dt><a href="<?php echo site_url('admin/logout');?>"><i class="menu_icon menu_out"></i>退出登录</a>
</dt>
</dl>
</div>
</div>
<a href="javascript:;" id="openClose" style="outline-style: none; outline-color: invert; outline-width: medium;" hideFocus="hidefocus" class="opens" title="展开与关闭"><span class="hidden">展开</span></a>

</div>
<div class="admin_container">
<div class="admin_crumbs"><div class="pull-left" id="op_title">欢迎页</div></div>
<div class="admin_content">
<iframe id="rightMain" src="<?php echo site_url('admin/dashboard');?>" width="100%" frameborder="false" scrolling="auto" style="border-top-style: none; border-right-style: none; border-bottom-style: none; border-left-style: none; border-width: initial; border-color: initial; margin-bottom: 30px; height: 155px; " allowtransparency="true"></iframe>
</div>
</div>
</div>
<script type="text/javascript">
if(!Array.prototype.map)
Array.prototype.map = function(fn,scope) {
  var result = [],ri = 0;
  for (var i = 0,n = this.length; i < n; i++){
	if(i in this){
	  result[ri++]  = fn.call(scope ,this[i],i,this);
	}
  }
return result;
};

var getWindowSize = function(){
return ["Height","Width"].map(function(name){
  return window["inner"+name] ||
	document.compatMode === "CSS1Compat" && document.documentElement[ "client" + name ] || document.body[ "client" + name ]
});
}
window.onload = function (){
	if(!+"\v1" && !document.querySelector) { // for IE6 IE7
	  document.body.onresize = resize;
	} else { 
	  window.onresize = resize;
	}
	function resize() {
		wSize();
		return false;
	}
}

function wSize(){
	//这是一字符串
	var str=getWindowSize();
	var strs= new Array(); //定义一数组
	strs=str.toString().split(","); //字符分割
	var heights = strs[0]-150,Body = $('body');$('#rightMain').height(heights);   
	//iframe.height = strs[0]-46;
	if(strs[1]<980){
		$('.admin_header').css('width',980+'px');
		$('#content').css('width',980+'px');
		Body.attr('scroll','');
		Body.removeClass('objbody');
	}else{
		$('.admin_header').css('width','auto');
		$('#content').css('width','auto');
		Body.attr('scroll','no');
		Body.addClass('objbody');
	}
	var openClose = $("#rightMain").height()+39;
	$('#center_frame').height(openClose+9);
	$("#openClose").height(openClose+30);	
	$("#Scroll").height(openClose-20);
	windowW();
}
wSize();

$("#openClose").click(function(){
	if($(this).data('clicknum')==1) {
		$("html").removeClass("on");
		$(".admin_menu").removeClass("admin_menu_on");
		$(this).removeClass("closes");
		$(this).data('clicknum', 0);
		$("#Scroll").show();
	} else {
		$(".admin_menu").addClass("admin_menu_on");
		$(this).addClass("closes");
		$("html").addClass("on");
		$(this).data('clicknum', 1);
		$("#Scroll").hide();
	}
	return false;

});
function windowW(){
	if($('#Scroll').height()<$("#admin_menu").height()){
		$(".scroll").show();
	}else{
		$(".scroll").hide();
	}
}
windowW();

function menuScroll(num){
	var Scroll = document.getElementById('Scroll');
	if(num==1){
		Scroll.scrollTop = Scroll.scrollTop - 60;
	}else{
		Scroll.scrollTop = Scroll.scrollTop + 60;
	}
}
$("#menu").find("dt").click(function(){
	$(this).parent().parent().find("dd").hide();
	$(this).parent().find("dd").fadeIn(500);
	$(this).parent().parent().find("dl").removeClass("active");
	$(this).parent().addClass("active");
})
$("#menu").find("li").find("a").click(function(){
	var title = $(this).text();
	$('#op_title').html(title);
	//alert(title);
	var abc=$(this).attr("url");
	$("#rightMain").attr("src",abc)
	$("#menu").find("li").removeClass("active");
	$(this).parent().addClass("active");
})
</script>
</body>
</html>
