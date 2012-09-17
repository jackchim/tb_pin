<div class="change_password_layer">
<div id="layer_top">
        <div class="layer_title">修改密码</div>
        <div><span class="layer_close"><a href="javascript:void(0)">x</a></span></div>
    </div>
<div class="layer_cont">
<div>
	<form action="" name="reset_passwd_form" id="reset_passwd_form" method="POST">
	  <table class="change_password" cellspacing="0" cellpadding="0">
        <tbody>
        	<?php if($sess_userinfo['is_social']): ?>
        	 <tr>
            <td class="change_password_title">邮箱地址</td>
            <td><input class="mem_form_login" type="text" id="email" name="email" value="" />
            <div class="u_chk"></div></td>
          </tr>
          	<?php endif;?>
          	 <?php if(!$sess_userinfo['is_social']):?>
          	<tr>
            <td class="change_password_title">邮箱:</td>
            <td>&nbsp;&nbsp;&nbsp;  <?php echo $sess_userinfo['email']?>
            <div class="u_chk"></div></td>
          </tr>
           <tr>
            <td class="change_password_title">原密码:</td>
            <td><input class="mem_form_login" type="password" id="org_passwd" name="org_passwd" value="" />
                <div for="org_passwd" generated="true" class="error u_chk"></div>
                </td>
          </tr>
           <?php endif;?>
          <tr>
            <td class="change_password_title">新密码:</td>
            <td><input class="mem_form_login" type="password" id="new_passwd" name="new_passwd" value="" />
                <div for="new_passwd" generated="true" class="error u_chk"></div></td>
          </tr>
           <tr>
            <td class="change_password_title">确认密码:</td>
            <td><input class="mem_form_login" type="password" id="new_verify_passwd" name="new_verify_passwd" value="" />
                <div for="new_verify_passwd" generated="true" class="error u_chk"></div></td>
          </tr>
          <tr>
          <td></td>
       
            <td><button type="submit" class="login_sub"><!--<img src="<?php echo base_url('themes/tupu'); ?>/images/button/ok.jpg" />-->确定</button><span id="error_message" class="error"></span></td>
          </tr>
        </tbody>
      </table>
	</form>

	</div>
</div>
</div>
