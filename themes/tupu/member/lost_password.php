<div class="regi_container">
<form action="<?php echo site_url('member/lost_password'); ?>" method="POST" id="send_email">
<div class="forget_pw radius">
	<div class="forget_pw_title">丢了密码也没关系哦</div>
    <div class="forget_pw_sm">出于安全考虑，我们存储加密的密码。这意味着，我们不知道你原来的密码。为了获得一个新的，下面，我们将向您发送一封电子邮件，并指示输入您的电子邮件。</div>
    <div class="forget_pw_input"><label>请输入邮箱</label><input type="text" class="mark_type_input" name="email" id="email" /><button type="submit" class="share_textarea_but">提交</button></div><span for="email" generated="true" class="error forget_pw_error_message" style=""></span>
</div>
</form>
</div>
<script type="text/javascript">
$("#send_email").validate({
	rules:{
		email: { required: true, email: true }
	},
	errorElement: "span",
	messages: {
			email: { required: "请输入有效的邮箱地址", email: "请输入有效的邮箱地址"}
	}
});
</script>