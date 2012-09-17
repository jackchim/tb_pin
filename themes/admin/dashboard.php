<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Language" content="zh-cn" />
<script src="<?php echo base_url('assets/js/jquery-1.7.2.min.js')?>" type="text/javascript"></script>
<link href="<?php echo base_url('themes/admin/css/dashbord.css'); ?>" type="text/css" rel="stylesheet" />
<link id="artDialog-skin" href="<?php echo base_url('assets/js/dialog/skins/default.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/js/dialog/artDialog_default.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('themes/admin/js/global.admin.js') ?>"></script>
<script>
	var jq=jQuery.noConflict();
</script>
<script type="text/javascript">
function checkVersion(){
	var config={
		title:'系统通知',
		width:300,
		height:100,
		ok:function(){},
		okValue:'确定',
		cancelValue:'取消',
		cancel:function(){},
		content:'<div><span id="loading" style="background:url(<?php echo base_url('themes/default/js/source/skins/loading.gif'); ?>) no-repeat left top;margin-right:20px;">&nbsp;&nbsp;&nbsp;</span><span id="infomation" style="font-size:14px;color:#060;">正在检查更新，请耐心等候.</span></div>'
	};
	var dialog=art.dialog(config);
	jq("input[value=确定]").removeClass("d-state-highlight");
	var url="<?php echo site_url('admin/check_version') ?>";//请求检查更新的url
	var info=jq("#infomation");
	var loading=jq("#loading");
	var okButton=jq("input[value=确定]");
	okButton.attr("disabled",'disabled');
	jq.post(url,{},function(msg){
		if(parseInt(msg)!=0){
			info.html("有新版本可以更新！");
			okButton.removeAttr("disabled");
			okButton.click(function(){
				window.location.href=msg;
			});
		}else{
			info.html("已经是最新版本，无需更新！");
			okButton.removeAttr("disabled");
		}
		loading.hide();
	});
}
</script>
<title>后台登录界面</title>
</head>
<body>
<div class="sitebox">
<div class="siteinfo"><h3>站点信息</h3>
<div>
程序版本： <?php echo $version; ?> <a href="javascript:void(0)" onclick="checkVersion()">检查版本更新</a><br />
服务器软件：<?php echo $_SERVER['SERVER_SOFTWARE']?> <br />
共有商品图:<?php echo $share_count;?>张，占用<?php echo $attchment_size;?>存储空间<br/>
注册用户数量:<?php echo $user_count; ?>人
</div>
</div>
<div class="siteinfo02"><h3>团队介绍</h3>
<div>版权所有：多边形工作室<br />
官方网站：<a target="_blank" href="http://www.duobianxing.com">http://www.duobianxing.com</a> <br />
官方论坛：<a target="_blank" href="http://bbs.duobianxing.com">http://bbs.duobianxing.com</a> <br />
产品演示: <a target="_blank" href="http://www.aitupu.com">http://www.aitupu.com</a>
</div>
</div>
<div class="siteinfo03"><h3>数据统计</h3>
 <div id="tab">
  <div id="Menubox">
    <ul>
      <li id="one1" onclick="setTab('one',1,4)" class="hover">累计统计</li>
      <li id="one2" onclick="setTab('one',2,4)">当日统计</li>
    </ul>
  </div>
  <div id="Contentbox">
    <div id="con_one_1">
      <table border="0" cellspacing="0">
          <tr>
            <td>页面展示量PV</td>
            <td>独立访客UV</td>
            <td>商品点击次数</td>
            <td>跳转淘宝点击数</td>
            <td>图片总数</td>
            <td>占用存储空间</td>
          </tr>
          <tr style="font-weight:bold;">
            <td><?php echo $sum['page_count_total']; ?></td>
            <td><?php echo $sum['ip_count_total']; ?></td>
            <td><?php echo $sum['total_click']; ?></td>
            <td><?php echo $sum['total_click_taobao'];?></td>
            <td><?php echo $sum['total_share']; ?></td>
            <td><?php echo $sum['share_space']; ?></td>
          </tr>
      </table>
    </div>
    <div id="con_one_2" style="display:none">
    	<table border="0" cellspacing="0">
          <tr>
            <td>页面展示量PV</td>
            <td>独立访客UV</td>
            <td>新增注册用户数</td>
            <td>注册用户总数</td>
            <td>日登录用户数</td>
          </tr>
          <tr style="font-weight:bold;">
          	<td><?php echo $sum['page_count'];?></td>
          	<td><?php echo  $sum['ip_count']; ?></td>
            <td><?php echo $sum['new_register_user']; ?></td>
            <td><?php echo $sum['total_reg_user']; ?></td>
            <td><?php echo $sum['new_login_user'];?></td>
          </tr>
      </table>
    </div>
  </div>
</div>
</div>
</div>

<script>
<!--
/*第一种形式 第二种形式 更换显示样式*/
function setTab(name,cursel,n){
for(i=1;i<=n;i++){
var menu=document.getElementById(name+i);
var con=document.getElementById("con_"+name+"_"+i);
menu.className=i==cursel?"hover":"";
con.style.display=i==cursel?"block":"none";
}
}
//-->
</script>
</body>
</html>











