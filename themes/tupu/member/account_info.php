<!--系统消息页面body部分-->
<div id="container">
	<div id="account_row">
    	<div>
        	<h1 class="account_title01">账号设置</h1>
    <ul class="account">   <!--左侧框-->
    	<?php if(!$is_social): ?>
           	  <li class="account_list">    <!--系统信息列表-->
                    <ol class="account_title">邮箱</ol>
                    <input type="text" maxlength="200" disabled="disabled" value="<?php echo $email;  ?>" class="account_comment" name="email" id="email">
      		  </li>
      		  <?php endif; ?>
              <li class="account_list">    <!--系统信息列表-->
                    <ol class="account_title">密码</ol>
                    <ol><img onclick="edit_password()" src="<?php echo $theme_url; ?>/images/button/Password.jpg" style="cursor:pointer;" /></ol>
      		  </li>
              <li class="account_list">    <!--系统信息列表-->
                    <ol class="account_title">昵称</ol>
                    <input type="text" maxlength="200" value="<?php echo $nickname;?>" disabled="disabled" class="account_comment" name="nickname" id="nickname">
      		  </li>
              <li class="account_list">    <!--系统信息列表-->
                    <ol class="account_title">性别</ol>
                    <ol><label><INPUT TYPE="radio" NAME="gender" value="male" <?php if($gender=='male'): ?>checked="checked"<?php endif;  ?> onclick="register.selecttype(1);">&nbsp;男</label> &nbsp;&nbsp;<label><INPUT TYPE="radio" NAME="gender" value="female"  <?php if($gender=='female'): ?>checked="checked"<?php endif;?>>&nbsp;女</label>&nbsp;&nbsp;<label><INPUT TYPE="radio" NAME="gender" value="none" <?php if(!$gender || $gender == 'none'): ?>checked="checked"<?php endif;?> >&nbsp;保密</label></ol>
      		  </li>
              <li class="account_list">    <!--系统信息列表-->
                    <ol class="account_title">头像</ol>
                    <ol>
                    <img id="info_big_avatar" style="vertical-align:baseline;" src="<?php echo base_url($sess_userinfo['avatar_large']);?>" class="avatar_setup"   onerror="javascript:this.src = base_url + 'themes/tupu/images/face_icon150.png';" />
                    <img id="info_middle_avatar" style="vertical-align:baseline;" src="<?php echo base_url($sess_userinfo['avatar_middle']);?>" class="avatar_setup"   onerror="javascript:this.src = base_url + 'themes/tupu/images/face_icon50.png';" />
                     <img id="info_small_avatar" style="vertical-align:baseline;" src="<?php echo base_url($sess_userinfo['avatar_small']);?>" class="avatar_setup"   onerror="javascript:this.src = base_url + 'themes/tupu/images/face_icon16.png';" />
                    </ol>
                    <br>
                    <form method="post" id="uploadpic_form" name="upform" action="<?php echo site_url('member/upload_avatar');?>" enctype="multipart/form-data">
						
						<input id="avatar_file_input" style="height:22px;" name="Filedata" type="file" data-action="do_uoload_avatar_file" value="" >
						<!--<input type="button" value="上传头像" data-action="do_uoload_avatar">-->
						<p id="form_msg" style="display:none;color:red;">正在上传图片，请稍后···</p>
						<input type="hidden" name="upload" value="1" />
					</form>
      		  </li>
              <li class="account_list">    <!--系统信息列表-->
            
                    <ol class="account_title">绑定</ol>
                   
                    <?php if($Sina_id):?>
                    <ol class="link_app">
                    	<dd><img src="<?php echo $theme_url; ?>/images/button/link_07.jpg" /></dd>
                    	<!--<p class="link_app_title">新浪微博</p>-->
                        <p class="time">你的新浪微博</p>
                        <p class="fans_h3">已经绑定</p>
                    </ol>
                    <?php else: ?>
                      <ol class="link_app">
                    	<dd><img src="<?php echo $theme_url; ?>/images/button/link_07.jpg" /></dd>
                    	<!--<p class="link_app_title">新浪微博</p>-->
                        <p class="time">你的新浪微博</p>
                        <p class="fans_h3"><a href="javascript:TWin=TWinOpen('<?php echo site_url('login/social/Sina');?>','TWin','900','550')""><img src="<?php echo $theme_url; ?>/images/button/link.jpg" /></a></p>
                    </ol>
                    <?php endif;?>
                    <?php if($Taobao_id):?>
                     <ol class="link_app">
                    	<dd><img src="<?php echo $theme_url; ?>/images/button/link_12.jpg" /></dd>
                    	<!--<p class="link_app_title">淘宝商城</p>-->
                        <p class="time">你的淘宝帐号</p>
                        <p class="fans_h3">已经绑定</p>
                    </ol>
                    <?php else: ?>
                     <ol class="link_app">
                    	<dd><img src="<?php echo $theme_url; ?>/images/button/link_12.jpg" /></dd>
                    	<!--<p class="link_app_title">淘宝商城</p>-->
                        <p class="time">你的淘宝帐号</p>
                         <p class="fans_h3"><a href="javascript:TWin=TWinOpen('<?php echo site_url('login/social/Taobao');?>','TWin','900','550')"><img src="<?php echo $theme_url; ?>/images/button/link.jpg" /></a></p>
                    </ol>
                    <?php endif;?>
                    <?php if($Renren_id):?>
                    <ol class="link_app03">
                    	<dd><img src="<?php echo $theme_url; ?>/images/button/link_09.jpg" /></dd>
                    	<!--<p class="link_app_title">人人网</p>-->
                        <p class="time">你的人人网帐号</p>
                        <p class="fans_h3">已经绑定</p>
                    </ol>
                    <?php else: ?>
                     <ol class="link_app03">
                    	<dd><img src="<?php echo $theme_url; ?>/images/button/link_09.jpg" /></dd>
                    	<!--<p class="link_app_title">人人网</p>-->
                        <p class="time">你的人人网帐号</p>
                        <p class="fans_h3"><a href="javascript:TWin=TWinOpen('<?php echo site_url('login/social/Renren');?>','TWin','900','550')"><img src="<?php echo $theme_url; ?>/images/button/link.jpg" /></a></p>
                    </ol>
                    <?php endif;?>  
                    <?php if($QQ_id):?>
                    <ol class="link_app02">
                    	<dd><img src="<?php echo $theme_url; ?>/images/button/link_13.jpg" /></dd>
                    	<!--<p class="link_app_title">QQ</p>-->
                        <p class="time">你的QQ帐号</p>
                       <p class="fans_h3">已经绑定</p>
                    </ol>
                    <?php else: ?>
                     <ol class="link_app02">
                    	<dd><img src="<?php echo $theme_url; ?>/images/button/link_13.jpg" /></dd>
                    	<!--<p class="link_app_title">QQ</p>-->
                        <p class="time">你的QQ帐号</p>
                      	 <p class="fans_h3"><a href="javascript:TWin=TWinOpen('<?php echo site_url('login/social/QQ');?>','TWin','900','550')"><img src="<?php echo $theme_url; ?>/images/button/link.jpg" /></a></p>
                    </ol>
                    <?php endif;?>
   
      		  </li>
              
              <li class="account_list">    <!--系统信息列表-->
                    <ol class="account_title">关于自己</ol>
                    <textarea class="comment" id="textarea" name="bio" onkeyup="count_bio_word()"><?php echo $bio;?></textarea>
      		  </li>
              <li class="account_list">    <!--系统信息列表-->
                    <ol class="account_title">城市</ol>
                    <input type="hidden" value="" id="formComCountry">
                    <select id="province" name="province">
                    </select>
                    <select id="city" name="city">
                    </select>
                     <script type="text/javascript" src="<?php echo base_url('assets/js/city_utf8.js'); ?>"></script>
              		<script type="text/javascript">
					initPlace('<?php echo $city;?>','<?php echo $province;?>');
			  		</script>
      		  </li>
              <div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div>
              <div class="ok_bt"><img style="cursor:pointer;" onclick="update_userinfo()" src="<?php echo $theme_url; ?>/images/button/ok.jpg" /><div id="ajax_message"></div></div>
            </ul>
       
        </div>
        <div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div>    <!--高度自适应ID-->
        <div class="account_shadow"></div>  
      <!--底部阴影--> 
    </div>  
    <!--详细页面左侧结束-->     
 <div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div>     <!--中部高度自适应-->
</div>

<div id="upload_avatar_div" style="display:none;">
<div id="layer_top">
        <div class="layer_title">上传头像</div>
        <div><span class="layer_close"><a href="javascript:void(0)">x</a></span></div>
    </div>

	<div style="width:470px;height:350px; padding:16px;">
		<div id="upload_success"  style="clear:both;padding-top:7px;">
			<div style="float:left; width:310px;">
				<div style="clear:both;height:300px;border-right:1px solid #E5E5E5">
				<img id="upload_img" class="upload_data" src=""/>
				</div>		
				<div style="clear:both;padding-top:6px;">
					<form onsubmit="return false;" action="<?php echo site_url('member/upload_avatar');?>" id="save_avatar_form" method="post">
						<input type="hidden" id="org_img" name="org_img" value="<?php echo $image_dir;?>" />
						<input type="hidden" id="img_attr_key" name="img_attr_key" value="<?php echo $img_attr_key;?>" />
						<input type="hidden" id="img_attr_val" name="img_attr_val" value="<?php echo $img_attr_val;?>" />
						<input type="hidden" id="x" name="x" />
						<input type="hidden" id="y" name="y" />
						<input type="hidden" id="w" name="w" />
						<input type="hidden" id="h" name="h" />
						<input type="hidden" name="save_crop" value="1" />
						<div></div>
						<div style="float:left;">
							<input class="share_textarea_but radius" type="submit" id="crop_avatar_btn" value="保存头像" />
						</div>
						<div style="float:left;">
							<input class="share_common_but" type="button" id="cancel_btn" value="取消" />
						</div>
					</form>
				</div>
			</div>
			<div style="float:right;">
				<div style="width:150px;height:150px;margin-left:5px;overflow:hidden; clear:both;">
				<img id="big_preview" class="upload_data" src="" />
				</div>
				<div style="width:50px;height:50px;margin-left:5px;margin-top:5px;overflow:hidden; float:left;">
				<img id="mid_preview" class="upload_data" src="" />
				</div>
				<div style="width:30px;height:30px;margin-left:5px;margin-top:5px;overflow:hidden; float:left;">
				<img id="small_preview" class="upload_data" src="" />
				</div>
			</div>
		</div>
	</div>
</div>
<!--/upload_avatar_div-->



















