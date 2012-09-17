<!--系统消息页面body部分-->
<div class="regi_container">
<div id="regi_container" class="radius">
	<div id="regi_row_1">
		<h1 class="regi_title">注册爱图谱帐号</h1>
		<form action="<?php echo site_url('register/ajax_register') ?>" method="POST" id="register_form">
		<ul class="regi_account">
        	<li class="regi_errer"></li>
        	<li style="width:100%;">
			   	<span>昵称</span>
                <div class="regi_input"><input type="text" maxlength="150" value="" class="account_comment radius" name="nickname" id="nickname"><img style="display:none;" src="<?php echo base_url('themes/tupu'); ?>/images/regyes.gif"/></div>
				<div class="regi_explain">昵称长度在4-20个字符之间,只能包含汉字，数字，英文，"_"或"-"，不能修改</div>
	    	</li>
        	<li> 
                <span>邮箱</span>
                <div class="regi_input"><input type="text" maxlength="200" value="" class="account_comment  radius" name="email" id="email"><img style="display:none" src="<?php echo base_url('themes/tupu'); ?>/images/regyes.gif"/></div>
				<div class="regi_explain">请填写完整邮箱地址，该邮箱将做为您的登录名，不能修改</div>
	    	</li>
			<li>   
                 <span>密码</span>
                 <div class="regi_input"><input type="password" maxlength="200" value="" class="account_comment  radius" name="password" id="password"><img style="display:none" src="<?php echo base_url('themes/tupu'); ?>/images/regyes.gif"/></div>
                 <div class="regi_explain">密码长度在6~15之间</div>
			</li>
        	<li>
				<span>确认密码</span>
				<div class="regi_input"><input type="password" maxlength="200" value="" class="account_comment  radius" name="passconf" id="passconf"><img style="display:none" src="<?php echo base_url('themes/tupu'); ?>/images/regyes.gif"/></div>
            <div class="regi_explain">再次输入你的密码</div>
	    	</li>
        	<li><button type="submit" id="agree_validate" class="radius">注册</button><div style="float:left; padding-top:6px;"><input name="" type="checkbox" id="agree" name="agree" value="1" style="height:13px; width:13px;" /></div><div class="regi_agree">同意<a href="<?php echo site_url("register/agree_vilivege"); ?>" target="_blank">爱图谱注册条款</a></div><div class="regi_noagree" id="agree_privilige"></div></li>
		</ul>
   		</form>
    </div>
    <div id="regi_row_2">
		<ul class="regi_login">
			<li class="login_regi_title">你可以用以下方式直接登录</li>
			<li class="regi_logo"><a href="javascript:TWin=TWinOpen('<?php echo site_url('login/social/Sina'); ?>','TWin','900','550')"><img src="<?php echo base_url('themes/tupu'); ?>/images/button/link_07.jpg" /></a></li>
			<li class="regi_logo"><a href="javascript:TWin=TWinOpen('<?php echo site_url('login/social/QQ'); ?>','TWin','900','550')"><img src="<?php echo base_url('themes/tupu'); ?>/images/button/link_13.jpg" /></a></li>
			<li class="regi_logo"><a href="javascript:TWin=TWinOpen('<?php echo site_url('login/social/Renren'); ?>','TWin','900','550')"><img src="<?php echo base_url('themes/tupu'); ?>/images/button/link_09.jpg" /></a></li>
			<li class="regi_logo"><a href="javascript:TWin=TWinOpen('<?php echo site_url('login/social/Taobao'); ?>','TWin','900','550')"><img src="<?php echo base_url('themes/tupu'); ?>/images/button/link_12.jpg" /></a></li>
		</ul>
	</div>
	<div style="clear:both;"></div>
    </div>
</div>
<div>

</div>
<!-- Javascript for this page. -->
<script type="text/javascript">
    function TWinOpen(url,id,iWidth,iHeight)
    {
        var iTop = (screen.height-30-iHeight)/2; //获得窗口的垂直位置;
        var iLeft = (screen.width-10-iWidth)/2; //获得窗口的水平位置;
        TWin=window.showModalDialog(url,null,"dialogWidth="+iWidth+"px;dialogHeight="+iHeight+"px;dialogTop="+iTop+"px;dialogLeft="+iLeft+"px");
    }

    function iFrameHeight(frame) {   
        var ifm= $(frame);
        var subWeb = document.frames ? document.frames[frame].document : ifm.contentDocument;   
        if(ifm != null && subWeb != null) {
            ifm.height = subWeb.body.scrollHeight;
        }   
    }
</script>
