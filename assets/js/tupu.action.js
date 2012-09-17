//添加事件监听
$(document).ready(function($) {
	var actions = {
		//popup的Click事件，送入的参数为message
	    do_like_shareClick: function(e,id , from) {
	    	 if(!arguments[1]) from = "waterfall";
	        $.ajax({
	        	url:  site_url + "share/add_like",
				data: {'share_id': id },
				type: 'GET',
				dataType: 'json',
				success: function(data) {
					if(from == 'view'){
						var x,y;
						x = e.pageX;
						y = e.pageY - 40;
						if ($.trim(data.result) == "add") {							
							body_append_msg(id , "谢谢您的喜欢" , x , y);
							total = parseInt($("#detail_like_total").html()) + 1;
							$("#detail_like_total").html(total);
						}else if($.trim(data.result) == "remove"){
							body_append_msg(id , "已经取消喜欢" , x , y);
							total = parseInt($("#detail_like_total").html()) - 1;
							$("#detail_like_total").html(total);
						}else if($.trim(data.msg) == "not_login"){
				             show_login();
						}else if($.trim(data.msg) == "like_self"){
				            body_append_msg(id , "不要这么自恋喔" , x , y);
						}else{
							alert('操作失败，请再试一次');
						}
					}else{
						obj = $('#share_'+id).find(".pin_tu");
						if ($.trim(data.result) == "add") {
							total = parseInt($("#share_"+id+"_total_likes").html()) + 1;
							$("#share_"+id+"_total_likes").html(total);
				            show_msg(obj , 'like_add' , "谢谢您的喜欢");
				            
						}else if($.trim(data.result) == "remove"){
							total = parseInt($("#share_"+id+"_total_likes").html()) - 1;
							$("#share_"+id+"_total_likes").html(total);
				            show_msg(obj , 'like_add' , "已经取消喜欢");
						}else if($.trim(data.msg) == "not_login"){
				            //show_msg(obj , 'like_add' , "请先登录");
				            show_login();
						}else if($.trim(data.msg) == "like_self"){
				            show_msg(obj , 'like_self' , "不要这么自恋喔");
						}else{
							alert('操作失败，请再试一次');
						}
					}
				}
		    });
	        
	    },
	    do_share_shareClick: function(e,id , from) {
	    	if(!arguments[1]) from = "waterfall";
	    	var x,y;
			x = e.pageX;
			y = e.pageY - 60;
	    	$.ajax({
	        	url:  site_url + "share/forwarding_share",
				data: {'share_id': id },
				type: 'POST',
				success: function(data) {
					obj = $('#share_'+id).find(".pin_tu");
					 if($.trim(data) == "not_login"){
					 	show_login();
					 }else if($.trim(data) == "share_self"){
					 	if(from == 'view'){
					 		body_append_msg(id , "亲！请不要转发自己的喔。" , x , y);
					 	}else{
					 		show_msg(obj , 'like_self' , "亲！请不要转发自己的喔。");
					 	}
					 }
					 else if($.trim(data) == "failed"){
					 	if(from == 'view'){
					 		body_append_msg(id , "亲！操作失败。" , x , y);
					 	}else{
					 		show_msg(obj , 'like_add' , "亲！操作失败。");
					 	}
					 }
					 else{
					 	art.dialog({title:'转发',fixed:true,lock:true,content:data,id: 'share_dialog'});
					 	//关闭
					 	
						$('.share_common_but').click(function(){
							art.dialog({id:'share_dialog'}).close();
						});
						$('.layer_close').click(function(){
							art.dialog({id:'share_dialog'}).close();
						});
						//提交按钮
						$('.share_textarea_but').click( function(){
							var options = {
									beforeSubmit: function() {
										$('#add_form').hide();
										$('#do_form').show();
									},
								    success: function(txt) {
										if(txt > 1){
											//dialog.okValue('');
											$('#process_form').hide();
											$('#return_form').show();
											$("#view_share").click(function(){
												art.dialog({id:'share_dialog'}).close();
												window.location.href= site_url + "share/view/"+txt; 
											});
										}
										else{
											alert('转发失败');
										}
								    }
							};		
							$('#share_form_'+id).ajaxSubmit(options);
						    return false;
						});
					 }
					//
				}
		    });
	    },
	    //编辑专辑
	    do_edit_albumClick: function(e,id , from) {
	    	if(!arguments[1]) from = "waterfall";
	    	$.ajax({
	    		url:  site_url + "member/edit_album",
				data: {'album_id': id },
				type: 'POST',
				success: function(data) {
					obj = $('#album_'+id).find(".album_layout");
					if($.trim(data) == "not_login"){
							show_login();
					}else if($.trim(data) == "no_data"){
							show_msg(obj , 'like_add' , "专辑不存在");
					} else{						
						art.dialog({title:'编辑专辑',fixed:true,lock:true,content:data,id: 'album_dialog'});
						//关闭
						$('.share_common_but').click( function(){
							art.dialog({id:'album_dialog'}).close();
						});
						$('.layer_close').click( function(){
							art.dialog({id:'album_dialog'}).close();
						});
						//提交按钮
						$('.share_textarea_but').click( function(){
							var options = {
					 				beforeSubmit: function() {
					 					title = $('#title').val();
										len = title.length;
										if(len < 2 || len > 14){
											$('#error_msg').html('专辑名称2 - 14个字符');
											$('#error_msg').show();
											return false;
										}
										
										//art.dialog({id:'album_dialog'}).close();
										//$('.ajax_form').hide();
										//$('#process_form').show();
										//$(".d-buttons").find('.d-button').remove();
									},
								    success: function(txt) {
										if(txt == 1){
											art.dialog({id:'album_dialog'}).close();
											show_msg(obj , 'like_add' , "编辑专辑成功");
										}
										else{
											alert(txt);
											alert('分享编辑失败');
										}
								    }
							};//option
							$('#edit_album_form_'+id).ajaxSubmit(options);
						    return false;
						});
					}
					
				}
	    	});
	    },
	    //删除专辑
	    do_del_albumClick: function(e,id , from) {
	    	var html = del_html('删除专辑' , '您确定要删除该专辑？<br />删除该专辑，原专辑的分享将被移到默认专辑。');
	    	art.dialog({
	    		id: 'del_album_'+id,
	    		lock:true,
	    		title:'删除专辑',
	    		fixed:true,
	    		content: html
	    	});
	    	$('.layer_close').click( function(){
	    		art.dialog({id:'del_album_'+id}).close();
	    	});
	    	$('.share_common_but').click( function(){
	    		art.dialog({id:'del_album_'+id}).close();
	    	});
	    	$('.share_textarea_but').click( function(){
	    		$.ajax({
    				url:  site_url + "member/del_album",
					data: {'album_id': id },
					type: 'POST',
					success: function(data) {
						obj = $('#album_'+id).find(".album_layout");
						if($.trim(data) == "not_login"){
							art.dialog({id:'del_album_'+id}).close();
							//show_msg(obj , 'like_add' , "请先登录");
							show_login();
						}else if($.trim(data) == 'no_data'){
							art.dialog({id:'del_album_'+id}).close();
							show_msg(obj , 'like_add' , "专辑不存在");
						}else if($.trim(data) == 'del_ok'){
							art.dialog({id:'del_album_'+id}).close();
							show_msg(obj , 'like_add' , "删除成功");							
							setTimeout(function(){
								$('#album_'+id).remove();									
						    	refresh_fall();//在tupu.waterfall.js定义
						    }, 1000);
						}else{
							alert('操作失败');
							
						}
					}
    			});//ajax
	    	});
	    	
	    },
	    do_top_albumClick: function(e,id){
	    	$.ajax({
	        	url:  site_url + "member/do_top_album",
				data: {'album_id': id },
				type: 'POST',
				success: function(data) {
					obj = $('#album_'+id).find(".album_layout");
					if(data == 1){
						show_msg(obj , 'like_self' , "置顶成功，请刷新首页查看效果！");
					}else if(data == 0){
						alert('操作失败');
					}else{
						alert('系统错误');
					}
				}
		    });
	    },
	    //编辑分享
	    do_edit_shareClick: function(e,id , from) {
	    	if(!arguments[1]) from = "waterfall";
	    	var x,y;
			x = e.pageX;
			y = e.pageY - 40;
	    	$.ajax({
	        	url:  site_url + "member/edit_share",
				data: {'share_id': id },
				type: 'POST',
				success: function(data) {
					obj = $('#share_'+id).find(".pin_tu");
					 if($.trim(data) == "not_login"){
					 		//show_msg(obj , 'like_add' , "请先登录");
					 		show_login();
					 }else if($.trim(data) == "no_data"){
					 		show_msg(obj , 'like_add' , "分享不存在");
					 }
					 else{
					 	art.dialog({title:'编辑分享',fixed:true,lock:true,content:data,id: 'share_dialog',okValue:'提交',ok:function(){
					 		var options = {
								    success: function(txt) {
										if(txt == 1){
											$('#edit_share_form_'+id).find('.form_msg').show();
											setTimeout(function(){
										    	art.dialog({id:'share_dialog'}).close();
										    	if(from == 'view'){
										    		body_append_msg(id , "分享编辑成功。" , x , y);
										    	}else{
										    		obj = $('#share_'+id).find(".pin_tu");
													show_msg(obj , 'like_add' , "分享编辑成功");
										    	}
										    }, 2000);
										}
										else{
											alert(txt);
											alert('分享编辑失败');
										}
								    }
							};		
							$('#edit_share_form_'+id).ajaxSubmit(options);
						    return false;
					 		
					 	}});  
					 }
					//
				}
		    });
	    },
	    //删除分享
	    do_del_shareClick: function(e,id , from) {
	    	var html = del_html('删除分享' , '您确定要删除该分享?');
	    	var dialog = art.dialog({id: 'del_share_'+id,fixed:true,lock:true,title:'删除分享',content: html});
	    	
	    	$('.share_common_but').click( function(){
	    		dialog.close();
	    	});
	    	
	    	$('.share_textarea_but').click( function(){
	    		$.ajax({
    				url:  site_url + "member/del_share",
					data: {'share_id': id },
					type: 'POST',
					success: function(data) {
						obj = $('#share_'+id).find(".pin_tu");
						if($.trim(data) == "not_login"){
							//show_msg(obj , 'like_add' , "请先登录");
							art.dialog({id:'del_share_'+id}).close();
							show_login();
						}else if($.trim(data) == 'no_data'){
							show_msg(obj , 'like_add' , "分享不存在");
							art.dialog({id:'del_share_'+id}).close();
						}else if($.trim(data) == 'del_ok'){
							art.dialog({id:'del_share_'+id}).close();
							show_msg(obj , 'like_add' , "删除成功");
							setTimeout(function(){
								$('#share_'+id).remove();
						    	refresh_fall();//在tupu.waterfall.js定义
						    }, 1000);
						}else{
							alert('操作失败');
						}
					}
    			});//ajax
	    	});
	    },
	    //添加关注
	    do_add_followingClick: function(e,u_id , f_id) {
	    	var user_id = parseInt(u_id);
			var friend_id = parseInt(f_id);
			var x,y;
			x = e.pageX;
			y = e.pageY - 40;
			if(u_id == f_id){
				body_append_msg(u_id , '不能关注自己' , x , y);
			}
			var request_url = site_url+'ajax/ajax_add_follow';
			var send_data ={user_id:user_id,friend_id:friend_id};
			$.post(request_url,send_data,function(mesg){
				if(mesg.result == true){
					var img_path = base_url+'assets/img/button/attention_no.jpg';
					var replace_html ='<a data-action="do_remove_following" data-params="'+user_id+', '+f_id+'" href="javascript:;"><img src="'+img_path+'"/></a>';
					$("#relation_"+user_id+'_'+friend_id).html(replace_html);;
					body_append_msg(u_id , '已成功关注' , x , y);
				}else if(mesg.result==false){
					show_login();
				}
				else{
					body_append_msg(u_id , '关注失败' , x , y);
				}
			} , 'json');
	    },
	    do_follow_friendsClick:function(e){
	    	//判断是否选择关注的人
	    	ids = getChecked();
	    	
	    	if(ids.length > 0){
	    		var options = {
					dataType:'json',
						beforeSubmit: function() {
							$('#do_follow_friends_btn').removeAttr('data-action');
		    				$('#do_follow_friends_btn').html('正在提交...');
						},
					    success: function(txt) {
					    	if(txt.result == true){
					    		$('#do_follow_friends_btn').html(txt.msg);
					    		setTimeout(function(){
					    			art.dialog({id:'friend_recommend_dialog'}).close();
					    			location.reload();
					    		} , 2000);
					    	}
					    	else{
					    		$('#do_follow_friends_btn').find('.index_one').html(txt.msg);
					    	}
					    }//success
				};//options
				$('#follow_friends_form').ajaxSubmit(options);
				return false;
	    	}
	    },
	    do_disable_follow_friendsClick:function(e){
	    	var request_url = site_url+'member/disable_follow_friends';
	    	var send_data ={disable:1};
	    	$.post(request_url,send_data,function(msg){
	    		art.dialog({id:'friend_recommend_dialog'}).close();
	    	});
	    },
	    //取消关注
	    do_remove_followingClick: function(e,u_id , f_id) {
	    	var user_id = parseInt(u_id);
			var friend_id = parseInt(f_id);
			var x,y;
			x = e.pageX;
			y = e.pageY - 40;
			if(u_id == f_id){
				body_append_msg(u_id , '操作错误' , x , y);
			}
			var request_url = site_url+'ajax/ajax_remove_follow';
			var send_data ={user_id:user_id,friend_id:friend_id};
			$.post(request_url,send_data,function(mesg){
				if($.trim(mesg.result=="true")){
					var img_path = base_url+'assets/img/button/attention.jpg';
					var replace_html ='<a data-action="do_add_following" data-params="'+user_id+', '+f_id+'" href="javascript:;"><img src="'+img_path+'"/></a>';
					$("#relation_"+user_id+'_'+friend_id).html(replace_html);
					body_append_msg(u_id , '关注已取消' , x , y);
				}
				else{
					body_append_msg(u_id , '操作失败' , x , y);
				}
			});
	    },
	    //显示用户的专辑列表
	    do_show_kalonClick:function(evt) {
	    	var float_album =$(this);
	    	///alert(float_album);
	    	$('#show_kalon').show(10,function(){
	    		var show_kalon = $(this);
	    		$(".album_value").click( function(){
	    			var current_album_id = $(this).attr("album_id");
					$("#album_id").val(current_album_id);
					show_kalon.hide();
					float_album.find('a').text($(this).text());
	    		});
	    		$("#create_new_album").die().live('click' , function(){
	    			var category_id = $(this).attr("category_id");
					var album_title=$.trim($("#album_title_name").val());
					var len = album_title.length;
					if(len < 2 || len > 14){
						$('#album_title_name').css('border-color' , 'red');
						setTimeout(function(){
							$('#album_title_name').css('border-color' , '#DFDFDF');
						},3000);
						return false;
					}
					$('#album_title_name').css('border-color' , '#DFDFDF');
					var data = {category_id:category_id,album_title:album_title};
					var request_url = site_url+"member/ajax_album_create";
					$.post(request_url,data,function(mesg){
						if(mesg.result==true){
							$("#album_id").val(mesg.insert_id);//为专辑隐藏框值
							$("#float_album").text(album_title);//标题
							$("#show_kalon").prepend('<li><a href="javascript:;" class="album_value" album_id="'+mesg.insert_id+'">'+album_title+'</a></li>');
							$("#show_kalon").hide();//隐藏弹出框
							$("#album_title_name").val('')
						}else{
							alert('专辑创建失败');
						}
					},'json');
	    		});
	    	});
	    	
    		$('body').click(function(e){	    		
	    		var tag =e.target.tagName.toLowerCase();
	    		if(tag!="a"&&tag!='button'&&e.target.id!='album_title_name'){
	    			$('#show_kalon').hide();
	    			$("#form_msg").hide();
	    		}
	    	});
	    },
	    do_uoload_avatar_fileClick:function(e){
	    	var select_btn = $("#avatar_file_input");
	    	$("#avatar_file_input").change(function(){
	    		var options = {
	    				dataType:'json',
						beforeSubmit: function() {
							select_btn.attr('disabled' , 'disabled');
							$('#form_msg').show();
						},
					    success: function(txt) {
					    	if(txt.result == 0){
					    		$('#form_msg').html(txt.msg);
					    	}else if(txt.result == 1){
					    		select_btn.val('');
					    		$('#form_msg').hide();
					    		//图片
					    		$('#upload_img').attr('src' , txt.image_url);
					    		$('#big_preview').attr('src' , txt.image_url);
					    		$('#mid_preview').attr('src' , txt.image_url);
					    		$('#small_preview').attr('src' , txt.image_url);
					    		if(txt.img_attr_key == 'width'){
					    			$('#upload_img').attr('width' , txt.img_attr_val);
					    			$('#upload_img').removeAttr("height");
					    		}else if(txt.img_attr_key == 'height'){
					    			$('#upload_img').attr('height' , txt.img_attr_val);
					    			$('#upload_img').removeAttr("width");
					    		}else{
					    			$('#upload_img').removeAttr("width");
					    			$('#upload_img').removeAttr("height");
					    		}
					    		$('#org_img').val(txt.image_dir);
					    		$('#img_attr_key').val(txt.img_attr_key);
					    		$('#img_attr_val').val(txt.img_attr_val);
					    		art.dialog({title:'上传头像',fixed:true,lock:true,content:$('#upload_avatar_div').html(),id: 'upload_avatar_dialog'});
					    		$("#crop_avatar_btn").click( function(){
					    			var options = {
				    						dataType:'json',
				    						beforeSubmit: function() {
				    							$("#crop_avatar_btn").val('正在提交···');
												$("#crop_avatar_btn").attr('disabled' , 'disabled');
											},
										    success: function(txt) {
										    	art.dialog({id:'upload_avatar_dialog'}).close();
										    	if(txt.result == true){
										    		//art.dialog({id:'upload_avatar_dialog'}).close();
										    		$("#info_big_avatar").attr('src',txt.big);
										    		$("#info_middle_avatar").attr('src',txt.mid);
										    		$("#info_small_avatar").attr('src',txt.small);
										    	}
										    	else{
										    		alert('保存失败');
										    	}
										    }//success
									};//options
									$('#save_avatar_form').ajaxSubmit(options);
									return false;
					    		});
					    		$("#cancel_btn").click( function(){
					    			//$("#avatar_file_input").unbind();
					    			art.dialog({id:'upload_avatar_dialog'}).close();
					    			select_btn.val('');
					    		});
					    		$('#layer_close').click(function(){
					    			//$("#avatar_file_input").unbind();
					    		});
					    		
					    		var jcrop_api, boundx, boundy;
						    	function updateCoords(c){
						    		$('#x').val(c.x);
									$('#y').val(c.y);
									$('#w').val(c.w);
									$('#h').val(c.h);
						    	}//updateCoords
						    	function updatePreview(c){
						    		if (parseInt(c.w) > 0){
										var rx = 30 / c.w;		//小头像预览Div的大小
										var ry = 30 / c.h;
										$('#small_preview').css({
											width: Math.round(rx * boundx) + 'px',
											height: Math.round(ry * boundy) + 'px',
											marginLeft: '-' + Math.round(rx * c.x) + 'px',
											marginTop: '-' + Math.round(ry * c.y) + 'px'
										});
										var rx = 50 / c.w;		//中头像预览Div的大小
										var ry = 50 / c.h;
										$('#mid_preview').css({
											width: Math.round(rx * boundx) + 'px',
											height: Math.round(ry * boundy) + 'px',
											marginLeft: '-' + Math.round(rx * c.x) + 'px',
											marginTop: '-' + Math.round(ry * c.y) + 'px'
										});
										var rx = 150 / c.w;		//大头像预览Div的大小
										var ry = 150 / c.h;
										$('#big_preview').css({
											width: Math.round(rx * boundx) + 'px',
											height: Math.round(ry * boundy) + 'px',
											marginLeft: '-' + Math.round(rx * c.x) + 'px',
											marginTop: '-' + Math.round(ry * c.y) + 'px'
										});
									}
						    		updateCoords(c);
						    	}//updatePreview
					    		$("#upload_img").Jcrop({
									minSize: [30,30],
									setSelect: [0,0,150,150],
									onChange: updatePreview,
									onSelect: updatePreview,
									onSelect: updateCoords,
								    aspectRatio: 1
								},function(){
									var bounds = this.getBounds();
								    boundx = bounds[0];
								    boundy = bounds[1];
								    // Store the API in the jcrop_api variable
								    jcrop_api = this;
								    oh = $('#upload_img').height();
								    ow = $('#upload_img').width();
								    select_width = 190;
								    select_height = 190;
								    select_width = Math.min(ow,select_width);
									select_height = Math.min(oh,select_height);
									x = ((ow - select_width) / 2);
									y = ((oh - select_height) / 2);			
								    jcrop_api.animateTo([ x, y, x+select_width, y+select_height ]);
								});
								
					    	}//result == 1
					    	else{
					    		alert('操作失败');
					    	}
					    }
				};		
				$('#uploadpic_form').ajaxSubmit(options);
			    return false;	
	    	});
	    }
	};
	
	//在 #action 中监控事件
	$('body').actionController({
		//如下内容为预配置
	    controller: actions,
	    events: 'click mouseover mouseout change submit keypress'
	});
	
	//详细页图片切换
	$('.image_change_action').mouseover(function(){
		//alert(34234);
		$('.image_change_action').attr('class' , 'tb_thumb_outer02 image_change_action');
		var c = $(this);
		$(this).attr('class' , 'tb_thumb_outer image_change_action');
		$(this).find('span:last').show();
		$('#targe-_big_image').attr('src' , c.attr('targe-image'));
	}).mouseout(function(){
		$(this).find('span:last').hide();
	});
	$('.show_intro_fun').mouseover(function(){
		$(this).find('span:last').show();
	}).mouseout(function(){
		$(this).find('span:last').hide();
	});
});
//添加事件监听 结束
function show_msg(obj , class_name , msg){
	//var html = "<div class='"+class_name+"'>"+msg+"</div>";
	obj.append("<div class='"+class_name+"'>"+msg+"</div>");
	if(class_name == 'like_add' || class_name == 'like_self'){
		var w = $('.'+class_name).width();
		var h = $('.'+class_name).height();
		$('.'+class_name).css('margin-left' , -parseInt(w/2)+'px');
		$('.'+class_name).css('margin-top' , -parseInt(h/2)+'px');
		
	}
    obj.find("."+class_name).fadeTo(5000,"hide",0);
    setTimeout(function(){
    	//$("."+class_name).remove();
    }, 5000);
    //alert(34343);
}

function body_append_msg(id , msg , x , y){
	$("#append_msg_"+id).remove();//先移除掉，防止刷屏
	$('body').append("<div id='append_msg_"+id+"' class='append_msg' style='top:"+y+"px;left:"+x+"px;'>"+msg+"</div>");
    $('#append_msg_'+id).fadeTo(3000,"hide",0);
    setTimeout(function(){
    	$('#append_msg_'+id).remove();
    }, 3000);
}


function del_html(title , content){
	var html = '';
	html += '<div id="edit_layer_system" class="delete_layer">';
	html += '<div id="layer_top">';
	html +=	'<div class="layer_title">'+title+'</div>';
	html +=	'<div><span class="layer_close"><a href="javascript:void(0)">x</a></span></div>';
	html +=	'</div>';
	html +=	'<div class="del_content" style="clear:both" align="center"><table width="100%" height="100%"><tr><td align="center" valign="middle" style="font-size:14px;">'+content+'</td></tr></table></div>';
	html +=	'<div class="del_btn" align="center"><div class="bu_float"><button class="share_textarea_but">确定</button></div><div class="bu_float"><button class="share_common_but">取消</button></div></div>';
	html +=	'</div>';
	
	return html;

}

function getChecked() {
    var gids = new Array();
    $.each($('input:checked'), function(i, n){
        gids.push( $(n).val() );
    });
    return gids;
}
//aid.toString();

