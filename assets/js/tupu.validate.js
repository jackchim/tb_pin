
$(function(){
	
	jQuery.validator.addMethod("byteRangeLength", function(value, element, param) {      
	  var length = value.length;      
	  for(var i = 0; i < value.length; i++){      
	      if(value.charCodeAt(i) > 127){      
	      length++;      
	      }      
	  } 
	  return this.optional(element) || ( length >= param[0] && length <= param[1] );      
	}, "请确保输入的值在{0}-{1}个字符之间(一个中文字算2个字符)"); 
	
	jQuery.validator.addMethod("notDigit", function(value, element, param) {
			var patrn=/^[0-9]{1,20}$/; 
			if(patrn.test(value))   return false; 
			return true; 
		}, "请确保输入的值不全为数字字符"); 
	
	
		$('#register_form').validate({
		rules: {
			nickname: { required: true,byteRangeLength:[4,20],remote: site_url + "ajax/ajax_nickname_valid" },
			email: { required: true, email: true, remote: site_url + "ajax/ajax_email_valid"},
			password: { required: true, rangelength: [6, 15] },
			passconf: { required: true, rangelength: [6, 15],equalTo: "#password" }
		},
		messages: {
			nickname: { required: "请输入昵称", byteRangeLength: "昵称长度在4-20个字符之间",remote: "昵称已存在，请使用其它昵称"},
			email: { required: "请输入有效的邮箱地址", email: "请输入有效的邮箱地址", remote: "邮箱已存在，请选择其它邮箱"},
			password: { required: "请输入密码", rangelength: "密码长度为6-15位"},
			passconf: { required: "请输入密码", rangelength: "密码长度为6-15位",equalTo: "两次输入的密码不一致" }
		},
		submitHandler: function(form) {
			$('#register_form').ajaxSubmit({
					url:  site_url + "register/ajax_register",
					data: $('#register_form').formSerialize(),
					type: 'POST',
					dataType: 'json',
					beforeSubmit: function(){
						$("#agree_validate").attr("disabled","disabled");
					 	$(".regi_errer").css("visibility","visible");
					    $(".regi_errer").html("注册中，请稍后....");
					},
					success: function(data) {
					 if ($.trim(data.result) == "true") {
					    // $('#ajax_message').html('&nbsp;&nbsp;&nbsp;&nbsp;'+data.msg);
					    $(".regi_errer").css("visibility","visible");
					    $(".regi_errer").html(data.msg);
					     if(data.synlogin){
							 document.write(data.synlogin);
						 }
					     window.location.href = site_url + "welcome/index";
					 }else {
					 	 $(".regi_errer").css("visibility","visible");
					    $(".regi_errer").html(data.msg);
					  	//$('#ajax_message').html(data.msg);
					  	//myAlert(data.msg);
					 }
				}
			});
			return false;
		}
	});  //注册表单验证结束
});