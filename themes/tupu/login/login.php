<div class="layer" style="height:auto;">
    <div id="layer_top">
        <div class="layer_title">登录</div>
        <div><span class="layer_close"><a href="javascript:void(0)">x</a></span></div>
    </div>
<div class="layer_cont_login">
<div>
	<form action="" method="POST" id="login_form">
	  <table class="mem_login" cellspacing="0" cellpadding="0">
        <tbody>
          <tr style="height:22px; margin-bottom:3px;">
            <td class="login_error_mail">邮箱</td>
            <td><input class="mem_form_login" type="text" name="email" id="email" value="" />
            </td>
          </tr>
           <tr class="login_error">
           <td align="right" >&nbsp;&nbsp;</td><td for="email" generated="true" class="error" style="padding-left:8px;"></td>
          </tr>
          <tr style="height:22px; margin-bottom:3px;">
            <td class="login_error_mail">密码</td>
            <td><input class="mem_form_login" type="password" name="password" id="password" value="" />
                <div class="u_chk">
                  <input id="poplogin-rem" type="checkbox" name="is_remember"   value="1" id="is_remember" checked="" />
                  <label for="poplogin-rem">记住登录状态</label> 
              </div></td>
          </tr>
          <tr class="login_error">
          <td align="right">&nbsp;&nbsp;</td><td for="password" generated="true" class="error" style="padding-left:8px;"></td>
          </tr>
          <tr>
            <td></td>
            <td><button type="submit" class="login_sub">登录</button>
              <a class="lkl" href="<?php echo site_url('member/lost_password'); ?>">忘记密码？</a></td>
          </tr>
          <tr>
          	<td>&nbsp;</td><td id="show_forbidden_warning" style="color:#B94A48"></td>
          </tr>
        </tbody>
      </table>
	</form>

	<div class="popreg">
		还没有注册帐号？
		<div><a href="<?php echo site_url('register/index') ?>"><img src="<?php echo $theme_url; ?>/images/button/reging.jpg" /></a></div>
		或者
		<div class="popoutlogin social clr">
		<?php if ($has_Sina):  ?>
			<p><img  src="<?php echo $theme_url; ?>/images/sina.jpg" /><a class="sina popup_social" flag="Sina" href="javascript:void(0)">用新浪微博登录</a></p>
			<?php endif; ?>
			<?php if($has_QQ): ?>
			<p><img src="<?php echo $theme_url; ?>/images/qq.jpg" /><a class="sina popup_social" flag="QQ" href="javascript:void(0)">用QQ帐号登录</a></p>
			<?php endif;?>
			<?php if($has_Renren): ?>
			<p><img src="<?php echo $theme_url; ?>/images/ren.jpg" /><a class="sina popup_social" flag="Renren" href="javascript:void(0)">用人人帐号登录</a></p>
			<?php  endif;?>
			
        </div>
	</div>
</div>
</div>
</div>