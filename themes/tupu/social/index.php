<div class="regi_container">
	<div class="forget_pw">

<h2 class="regi_title02">绑定帐号</h2>
<div class="row">
	<div class="span8">
		<form id="bind_form" action="<?php echo site_url('social/bind/'.$vendor);?>" class="form-horizontal" method="post">
			<fieldset>
				<legend></legend>
				<!--<img alt="头像" src="<?php echo $avatar?>"/>-->
				<div class="control-group">
            		<label class="control-label forget_title" for="input01">请输入昵称</label>
						<div class="controls">
							<input type="text" class="input-xlarge mark_type_input" id="input01" name="nickname" value="<?php echo $screen_name;?>">
              				<p class="help-block" style="line-height:22px;">2-20个字符，只能包含汉字，数字，英文，“_”或减号。<?php echo form_error('screen_name'); ?></p>
	            			<?php echo form_error('nickname'); ?>
            			</div>
         		</div>
				<div class="form-actions">
					<button type="submit" class="share_textarea_but" style="margin-left:26px;">登录</button>
				</div>
			</fieldset>
		</form>
	</div>
</div>

	</div>
</div>
<!-- Javascript for this page. -->
<script type="text/javascript">
// 第三方用户绑定表单 form id=bind_form 
	// File : /bind/index
	$('#bind_form').validate({
		rules: {
			nickname: { required: true, byteRangeLength:[4,20], remote: site_url + "ajax/ajax_nickname_valid" }
		},
		messages: {
			nickname: { required: "请输入昵称", byteRangeLength: "昵称长度请设置在4-20个字符之间(1个中文汉字为2个字符)",remote: "昵称已存在，请使用其它昵称"}
		}
	}); //用户绑定表单结束
</script>