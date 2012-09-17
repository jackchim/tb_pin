//获取分享图片支持本地和网路
function fetch_url(){
	if(!current_uid){
	myAlert("亲，请先登录！");
	return false;
	}
	var request_url = site_url+"ajax/load_fetch_index";
	$.post(request_url,{},function(tpl){
		var dialog = art.dialog({title:'',padding:0,fixed:true,content:tpl,initialize: function () {
			$("#local_upload_share").click(function(){
				dialog.close();
				upload_local_share()
			});
			$("#web_upload_share").click(function(){
				dialog.close();
				web_upload_share()
			});
			$("#add_album").click(function(){
				dialog.close();
				add_album();
			});
		}
		});
		dialog.lock();
	});
}

function add_album(){
	if(!current_uid)
	myAlert("亲，请先登录！");
	var request_url = site_url+"ajax/add_album";
	$.post(request_url,{},function(tpl){
		var dialog = art.dialog({title:'',padding:0,lock:true,fixed:true,content:tpl,initialize:function(){
			$('#album_create_form').validate({
				rules: {
					album_title: { required: true,byteRangeLength:[4,20]}
				},
				messages: {
					album_title: { required: "请输入专辑名称", byteRangeLength: "4-20个字符之间"}
				},
				submitHandler: function(form) {
					$('#album_create_form').ajaxSubmit({
						url: site_url + "member/ajax_album_create",
						data: $('#album_create_form').formSerialize(),
						type: 'POST',
						dataType: 'json',
						beforeSubmit: function(){
							$('#ajax_message').html('提交中，请稍候');
						},
						success: function(data) {
							if ($.trim(data.result) == "true") {
								myAlert("<img src='"+base_url+"themes/tupu/images/conform_ok.png'/>&nbsp;&nbsp;"+data.msg);
								dialog.close();
							}else {
								$('#ajax_message').html(data.msg);
							}
						}
					});
					return false;
				}
			}); //创建专辑表单结束

		}});
	});
}
//本地上传分享
function upload_local_share(){
	if(!current_uid)
	myAlert("亲，请先登录！");
	var request_url = site_url+"ajax/upload_local_share";
	$.post(request_url,{},function(tpl){
		var dialog = art.dialog({title:'',fixed:true,padding:0,fixed:false,content:tpl,initialize: function () {
			bind_album_show();//处理album相册分类
			bind_category_show();
			bind_create_new_album();
			bind_img_button();
			var interval = null;
			$("#web_upload_share").click(function(){
				web_upload_share();
				dialog.close();
			});
			$("#intro").focus(function(){
				if($(this).val()=='请输入对图片的描述（必填）'){
					$(this).val('');
					$(this).css('color',"#050");
				}

			}).blur(function(){
				if($(this).val()==''){
					$(this).val('请输入对图片的描述（必填）');
					$(this).css('color',"#ccc");
				}
			}).keyup(function(){
				var intro_val = $.trim($(this).val());
				var pattern=/\n+/g;
				var limit = 100;//100个字
				var intro_val=intro_val.replace(pattern,' ');
				var itself = this;
				if(intro_val.length >limit){
					$(this).css("background-color",'red');
					setTimeout(function(){
					$(itself).css("background-color",'#EAE7E6');
				},100);
				$(this).val(intro_val.substr(0,limit));
		}
		});

			// 保存分享内容表单 form id=save_share_form
			// File : /common/member_cp
			$("#save_share_form").submit(function(){
				var intro = $("#intro").val();
				if(intro==""||intro=='请输入对图片的描述（必填）'){
					//myAlert("请为分享写个描述吧！");
					$('#ajax_upload_message').html("请为分享写个描述吧！");
					return false;
				}
				var album_id = $("#album").val();
				if(!album_id){
					$("#ajax_upload_message").html("您没有选择任何专辑！");
					return false;
				}
				//======检测图片数量，执行验证
				var valide_img_count = $("#crawl_web ul li[checked=checked]").size();
				var total_img_count = $("#crawl_web ul li").size();
				var front_img = $("#front_side").val();//封面图片地址
				if(valide_img_count < 1){
					$('#ajax_upload_message').html('您还没有选择封面或者您的封面图片未被选中');
					return false;
				}else if(valide_img_count > 5){
					$('#ajax_upload_message').html('最多只能分享5张图片');
					return false;
				}else{
					for(var j=0;j<total_img_count;j++){
						if($("#crawl_web ul li:eq("+j+")").attr("checked")){
							var img_src = $("#crawl_web ul li:eq("+j+") span img:first").attr("vsrc");
							var img_detail = $.trim($("#crawl_web ul li:eq("+j+") input").val());
							var pattern=/\n+/g;
							var img_detail = img_detail.replace(pattern," ");
							img_detail = (img_detail=='写个描述~不要超过5个字') ? "NULL" :img_detail; 
							var insert_modal = "<input type='hidden' class='image_data' name='img_urls[]' value='"+img_src+"'/>";
							insert_modal += "<input type='hidden' name='img_details[]' value='"+img_detail+"'/>";
							$("#save_share_modal").prepend(insert_modal);
						}
						if($("#crawl_web ul li:eq("+j+") span img:first").attr("src") == front_img){
							if($("#crawl_web ul li:eq("+j+")").attr("checked") !="checked"){
								$('#ajax_upload_message').html('您还没有选择封面或者您的封面图片未被选中');
								return false;
							}else{
								$('#ajax_upload_message').html('提交中，请稍候');
							}
						}
					}
				}
				//=======处理图片提交验证结束

				$('#save_share_form').ajaxSubmit({
					url:  site_url + "share/ajax_save_share",
					data: $('#save_share_form').formSerialize(),
					type: 'POST',
					dataType: 'json',
					beforeSubmit: function(){
						interval = loop_delimiter("提交中，请稍候",'ajax_upload_message');
					},
					success: function(data) {
						clearInterval(interval);
						if ($.trim(data.result) == "true") {
							$('#ajax_upload_message').html(data.msg);
							setTimeout(function(){
								dialog.close();
							},2000);
						}else {
							$('#ajax_share_message').html(data.msg);
						}
					}
				});

				return false;
			});
			$("#upload_file_input").change(function(){
				$('#upload_share_form').ajaxSubmit({
					url:  site_url + "ajax/ajax_file_upload",
					data: $('#upload_share_form').formSerialize(),
					type: 'POST',
					dataType: 'json',
					beforeSubmit: function(){
						$('#ajax_upload_message').html('正在努力上传图片，请稍候...');
						interval = loop_delimiter("正在努力上传图片，请稍候",'ajax_upload_message');
					},
					error:function(XMLHttpRequest, textStatus, errorThrown){
						var error_status = '';
						clearInterval(interval);
						if(textStatus == 'parsererror'){
						error_status = "服务解析错误，可能是服务器部分功能未开启";
						}else if(textStatus == 'notmodified'){
						error_status = "服务节点被改变";	
						}else if(textStatus == 'timeout'){
						error_status = "请求服务器超时";		
						}
						clearInterval(interval);
						$(".ajax_fetch_message").html(error_status);
						
					},
					success: function(data) {
						clearInterval(interval);
						if ($.trim(data.result) == "true") {
							$('#save_share_modal').find('#image_data').attr('value',data.data.image_url);
							$('#save_share_modal').find('#share_type').attr('value','upload');
							var imgd={};
							imgd.width=data.data.width;
							imgd.height=data.data.height;
							var img_info= DrawImage(imgd,158,158);
							var img_html = "<img src='"+data.data.image_full_url+"' vsrc='"+data.data.image_url+"' width='"+img_info.width+"'  height='"+img_info.height+"'/>";					$(".share_img").html(img_html);
							var front_img = $("#front_side").val(data.data.image_url);//封面图片地址
							mk_img_box2(data.data.image_full_url,data.data.image_url);

							$(".share_img").html(img_html);
							$('#ajax_upload_message').html('');
							$("#btn_share").attr("disabled",false);
						}else {
							$('#ajax_upload_message').html(data.msg+' '+data.data.error);
							var size = $("#crawl_web ul li").size();
							if(size < 1)
							$("#btn_share").attr("disabled",true);
						}
					}
				});
			});
		}
		});
		dialog.lock();
	});
}

//网路分享图片
function web_upload_share(){
	if(!current_uid)
	myAlert("亲，请先登录！");
	var request_url = site_url+"ajax/web_upload_share";
	$.post(request_url,{},function(tpl){
		var dialog = art.dialog({title:'',padding:0,fixed:false,content:tpl,initialize: function () {
			bind_album_show();//处理album相册分类
			bind_category_show();
			bind_create_new_album();
			bind_img_button();
			$("#local_upload_share").click(function(){
				dialog.close();
				upload_local_share();
			});
			$("#intro").focus(function(){
				if($(this).val()=='请输入对图片的描述（必填）'){
					$(this).val('');
					$(this).css('color',"#050");
				}

			}).blur(function(){
				if($(this).val()==''){
					$(this).val('请输入对图片的描述（必填）');
					$(this).css('color',"#ccc");
				}
			}).keyup(function(){
				var intro_val = $.trim($(this).val());
				var pattern=/\n+/g;
				var limit = 100;//100个字
				var intro_val=intro_val.replace(pattern,' ');
				var itself = this;
				if(intro_val.length >limit){
					$(this).css("background-color",'red');
					setTimeout(function(){
					$(itself).css("background-color",'#EAE7E6');
				},100);
				$(this).val(intro_val.substr(0,limit));
		}
			});

			// 保存分享内容表单 form id=save_share_form
			// File : /common/member_cp
			$("#save_share_form").submit(function(){
				var intro = $("#intro").val();
				var album_id = $("#album").val();
				var interval= null;
				if(!album_id){
					$("#ajax_fetch_message").html("您没有选择任何专辑！");
					return false;
				}
				if(intro==""||intro=='请输入对图片的描述（必填）'){
					$("#ajax_fetch_message").html("请为分享写个描述吧！");
					return false;
				}
				
				//======检测图片数量，执行验证
				var valide_img_count = $("#crawl_web ul li[checked=checked]").size();
				var total_img_count = $("#crawl_web ul li").size();
				var front_img = $("#front_side").val();//封面图片地址
				if(valide_img_count < 1){
					$('#ajax_fetch_message').html('您还没有选择封面或者您的封面图片未被选中');
					return false;
				}else if(valide_img_count > 5){
					$('#ajax_fetch_message').html('一次只能上传少于五张的图片');
					return false;
				}else{
					for(var j=0;j<total_img_count;j++){
						if($("#crawl_web ul li:eq("+j+")").attr("checked")){
							var img_src = $("#crawl_web ul li:eq("+j+") span img:first").attr("src");
							var img_detail = $.trim($("#crawl_web ul li:eq("+j+") input").val());
							var pattern=/\n+/g;
							var img_detail = img_detail.replace(pattern," ");
							img_detail = (img_detail=='写个描述~不要超过5个字') ? "NULL" :img_detail;
							var insert_modal = "<input type='hidden' class='image_data' name='img_urls[]' value='"+img_src+"'/>";
							insert_modal += "<input type='hidden' name='img_details[]' value='"+img_detail+"'/>";
							$("#save_share_modal").prepend(insert_modal);
						}
						if($("#crawl_web ul li:eq("+j+") span img:first").attr("src") == front_img){
							if($("#crawl_web ul li:eq("+j+")").attr("checked") !="checked"){
								$('#ajax_fetch_message').html('您还没有选择封面或者您的封面图片未被选中');
								return false;
							}else{
								$('#ajax_fetch_message').html('提交中，请稍候');
							}
						}
					}
				}
				//=======处理图片提交验证结束
				$('#save_share_form').ajaxSubmit({
					url:  site_url + "share/ajax_save_share",
					data: $('#save_share_form').formSerialize(),
					type: 'POST',
					dataType: 'json',
					beforeSubmit: function(){
					 interval = loop_delimiter("提交中，请稍候",'ajax_fetch_message');
			       	 $("#btn_share").attr("disabled",true);
					},
					error:function(XMLHttpRequest, textStatus, errorThrown){
						var error_status = '';
						if(textStatus == 'parsererror'){
						error_status = "服务解析错误，可能是服务器部分功能未开启";
						}else if(textStatus == 'notmodified'){
						error_status = "服务节点被改变";	
						}else if(textStatus == 'timeout'){
						error_status = "请求服务器超时";		
						}
						clearInterval(interval);
						$(".ajax_fetch_message").html(error_status);
						
					},
					success: function(data) {
						clearInterval(interval);
						if ($.trim(data.result) == "true") {
							$('#ajax_fetch_message').html(data.msg);
							$('#ajax_fetch_message').html('<b>分享成功，感谢您的分享！</b>');
							setTimeout(function(){
								dialog.close();
							},2000);
						}else {
							
							$('#ajax_fetch_message').html(data.msg);
						}
					}
				});

				return false;
			});
			$("#fetch_url").keydown(function(evt){
				if(evt.keyCode==13){
				$("#cratch_pic").click();	
				return false;
				}
			});
			$("#cratch_pic").click(function(){
				var cratch_url_input = $("input#fetch_url");
				$("#btn_share").attr("disabled",true);//先限制住点击按钮
				$(".share_img").empty();//清空图片
				$("#crawl_web").remove();//还原图框
				$(".image_data").remove();//清空图片隐藏
				if(cratch_url_input.val()==''){
					$(".show_error_class").show().html("链接不能为空");
					return;
				}
				var fetch_url=cratch_url_input.val();
				$(".loading_icon").show();
				$.ajax({
					url:  site_url + "ajax/ajax_fetch_remoteinfo",
					data: $('#fetch_url_form').formSerialize(),
					type: 'POST',
					dataType: 'json',
					beforeSend:function(){
						$(".show_error_class").show().html("服务器正在努力处理您的请求，请稍候...");
						$('.input_loading').removeClass('hide');
						$('#fetch_url_modal').find('#btn_fetch').prop('disabled', true);
					},
					error:function(XMLHttpRequest, textStatus, errorThrown){
						var error_status = '';
						if(textStatus == 'parsererror'){
						error_status = "服务解析错误，可能是服务器部分功能未开启";
						}else if(textStatus == 'notmodified'){
						error_status = "服务节点被改变";	
						}else if(textStatus == 'timeout'){
						error_status = "请求服务器超时";		
						}
						$(".show_error_class").html(error_status);
						$(".loading_icon").hide();
					},
					success:function(data){
						$(".loading_icon").hide();
						if ($.trim(data.result) == "true") {
							var data_type = data.data.type;
							if(data_type=='images'){
								var images_list = '';
								if(data.data.images.length > 0){
									var img_srcs=new Array();
									$.each(data.data.images,function(n,value) {
										img_srcs.push(value.src)
									});
									$(".show_error_class").show().html("抓取成功");
									mk_img_box(img_srcs);
									$('#save_share_modal').find('#share_type').attr('value','images');
									$('#save_share_modal').find('#orgin_url').attr('value',data.data.url);
									$('#save_share_modal').find('#basic_info').append('<p>来源：' + data.data.url + '</p>\r\n');
									$('#save_share_modal').find('#images_list').append(images_list);
									$('#save_share_modal').find('#images_list').parent().css('width', 212 * data.data.images.length);
									$('#ajax_fetch_message').html('');
									//$("#image_data").attr("value",'test');
									$("#btn_share").attr("disabled",false);
								}else{
									$(".show_error_class").show().html("没有获取到合适尺寸的图片");
									$(".loading_icon").hide();
								}
							}else if(data_type=='channel'){
								$('#save_share_modal').find('#item_id').attr('value',data.data.item_id);
								$('#save_share_modal').find('#channel').attr('value',data.data.channel);
								$('#save_share_modal').find('#share_title').attr('value',data.data.name);
								$('#save_share_modal').find('#share_price').attr('value',data.data.price);
								$('#save_share_modal').find('#orgin_url').attr('value',data.data.orgin_url);
								$('#save_share_modal').find('#promotion_url').attr('value',data.data.promotion_url);
								$('#save_share_modal').find('#image_data').attr('value',data.data.orgin_image_url);
								$('#save_share_modal').find('#share_type').attr('value','channel');
								var img_srcs=data.data.item_imgs;
								mk_img_box(img_srcs);
								$(".show_error_class").show().html("抓取成功");
								$("#btn_share").attr("disabled",false);
								$("#intro").val(data.data.name);
								$('#ajax_fetch_message').html('');//清空提示语

							}else if(data_type=='upload'){
								$('#fetch_url_modal').modal('hide');
								$('#save_share_modal').modal('hide');
								$('#save_upload_modal').modal('show');
							}
						}else {
							$(".show_error_class").show().html(data.msg);
						}
					}
				});

			});
		}
		});
		dialog.lock();
	});
}

function loop_delimiter(word,div_id){
	var index =0;
	var loop =null;
	loop = setInterval(function(){
		index++;
		var  note_word = word;
		for(var i=0;i<(index%6);i++){
			note_word +=' . ';
		}
		$('#'+div_id).html(note_word);
	},500);
	return loop;
}
function loadimgsize(imgurl,min_width,short_url,last) {
	var s = new Object();
	s.img = new Image();
	s.img.src = imgurl;
	s.img.vsrc = short_url ? short_url:'0';
	s.img.last = last ? last: false;
	var props = new Object();
	props.min_width = min_width?min_width:200;
	s.loadCheck = function () {
		if(s.img.complete) {
			props.width = s.img.width ? s.img.width : '';
			props.height = s.img.height ? s.img.height : '';
			if(props.width >=props.min_width){
				if($(".share_img").html()==''){
					//处理封面
					var front_img = '<img src="'+s.img.src+'"/>';
					$(".share_img").html(front_img);
					$("#front_side").val(s.img.src);
				}
				props.total_size = $("#crawl_web ul li").size();
				if(props.total_size >=4)
				$("#crawl_web ul").width($("#crawl_web ul").width()+142);
				var short_url = short_url ? short_url :'0';
				var img_li='<li><span><img src="'+s.img.src+'" vsrc="'+s.img.vsrc+'"/><dd><img style="display:none" src="'+base_url+'themes/tupu/images/button/bt_ok.png"/></dd></span><input type="text" value="写个描述~不要超过5个字"/></li>';
				$("#crawl_web ul").append(img_li);
			}else{
				if(s.img.last){
					var total_li_count = $("#crawl_web ul li").size();
					if(total_li_count < 1){
						$(".show_error_class").html("没有找到合适尺寸的图片");
					}
				}
			}
		} else {
			setTimeout(function () {s.loadCheck();}, 100);
		}
	};
	s.loadCheck();
}

//在页面中生成每个图片
function mk_img_box(img_srcs){
	var html_content = '<div id="crawl_web"><ul>';
	html_content += '</ul> </div>';
	$("#img_box").html(html_content);
	var size = img_srcs.length;
	for(var srcIndex in img_srcs){
		if(srcIndex == (size-1)){
		loadimgsize(img_srcs[srcIndex],'','',true);
		}else{
		loadimgsize(img_srcs[srcIndex]);
		}
	}
}

function mk_img_box2(img_src,short_url){
	var crawl_box = $("#crawl_web").get(0);

	if(!crawl_box){
		var html_content = '<div id="crawl_web"><ul>';
		html_content += '</ul> </div>';
		$("#img_box").html(html_content);
	}
	loadimgsize(img_src,50,short_url);
}

//每个图片是否选中状态 图片封面图
function bind_img_button(){
	$("#crawl_web ul li span").die('click');
	$("#crawl_web ul li input").die('focus').die('blur');
	$("#crawl_web ul li span").live('click',function(){
		var selected_button  = $(this).children("dd").find("img");
		selected_button.toggle();
		if(selected_button.css("display") != 'none'){
			$(this).parent().attr("checked",1);
		}else{
			$(this).parent().removeAttr("checked");
		}
	});
	$("#crawl_web ul li input").live("focus",function(){
		if($(this).val()=='写个描述~不要超过5个字'){
			$(this).val('');
		}
	}).live("blur",function(){
		if($(this).val()==''){
			$(this).val('写个描述~不要超过5个字');
		}
	}).live("keyup",function(){
		var detail = $.trim($(this).val());
		var pattern=/\n+/g;
		var limit = 5;//5个字
		var detail=detail.replace(pattern,' ');
		var itself = this;
		if(detail.length >limit){
			$(this).css("background-color",'red');
			setTimeout(function(){
				$(itself).css("background-color",'#EAE7E6');
			},100);
			$(this).val(detail.substr(0,limit));
		}
	});
	/**
	上一张下一张按钮事件
	*/
	var index=0;
	$(".share_face_web01").click(function(){
		index++;
		var next_img  = $("#crawl_web ul li:eq("+index+") span img").get(0);
		if(next_img){
			$(".share_img").html($(next_img).clone());
			 if($(next_img).attr('vsrc')==0){
				$("#front_side").val($(next_img).attr('src'));
			 }else{
				$("#front_side").val($(next_img).attr('vsrc'));
			}
		}else{
			index = $("#crawl_web ul li").size() - 1;
		}
	})
	$(".share_face_web02").click(function(){
		index--;
		var prev_img  = $("#crawl_web ul li:eq("+index+") span img").get(0);
		if(prev_img){
			$(".share_img").html($(prev_img).clone());
			if($(prev_img).attr('vsrc')==0){
			$("#front_side").val($(prev_img).attr('src'));
			}else{
			$("#front_side").val($(prev_img).attr('vsrc'));
			}
		}else{
			index = 0;
		}
	})
}


//抓图页相册显示
function bind_album_show(){
	$("#float_album").click(function(t){
		$("#album_title_name").click(function(ev){
			ev.stopPropagation();//必须由
	 	 });
		$(".tuge_outer_layer_for_album").mouseleave(function(evt){
			var _this = this;
			var toElement = evt.relatedTarget;
			if(!_this.contains(toElement)){
				$("body").click(function(e){
					$(".tuge_outer_layer_for_album").hide();
					e.stopPropagation();
					$(this).unbind("click");
				});
			}
		});
		var float_album =$(this);
		$(".tuge_outer_layer_for_album").show(10,function(){

			var show_kalon = $(this);
			limit_word('album_title_name',24);
			$(".album_value").click(function(evts){
				var current_album_id = $(this).attr("album_id");
				$("#album").val(current_album_id);
				show_kalon.hide();
				float_album.html("<label>"+$(this).html()+"</label>");
				$(".album_value").unbind("click");
				evts.stopPropagation();
			});
		});
		//evt.stopPropagation();
	});
}

//抓图页分类显示
function bind_category_show(){
	$("#float_category").click(function(t){
		$("#show_kalon").mouseleave(function(evt){
			var _this = this;
			var toElement = evt.relatedTarget;
			if(!_this.contains(toElement)){
				$("body").click(function(e){
					$("#show_kalon").hide();
					e.stopPropagation();
					$(this).unbind("click");
				});
			}
		});
		var float_category =$(this);
		$("#show_kalon").show(10,function(){
			var show_kalon = $(this);
			//limit_word('album_title_name',24);
			$(".category_value").click(function(){
				var current_category_id = $(this).attr("category_id");
				$("#category_id_value").val(current_category_id);
				//$("#album").val(current_album_id);
				show_kalon.hide();
				float_category.html("<label>"+$(this).html()+"</label>");
				reload_album(current_category_id);//重新载入相册
				$(".category_value").unbind('click');
			});
		});
		//e.stopPropagation();
	});
}

//重新装载相册
function reload_album(category_id){
	var req_url =  site_url+"ajax/ajax_load_album";
	var data = {category_id:category_id};
	$(".tuge_outer_layer_for_album li:not(.not_remove)").remove();
	$.ajax({
		data:data,
		url:req_url,
		type:'post',
		dataType:'json',
		success:function(mesg){
			if(mesg.flag==true){
				for(var album in mesg.albums){
					var li='<li><a href="javascript:void(0)" class="album_value" album_id="'+mesg.albums[album].album_id+'">'+mesg.albums[album].title+'</a></li>';
					$(".tuge_outer_layer_for_album").prepend(li);
				}
				$("#float_album").html("<label>"+mesg.albums[0].title+"</label>");
				$("#album").val(mesg.albums[0].album_id);
			}else{
				$("#float_album").html('请选择专辑');
				var li='<li>请选择专辑</li>';
				$(".tuge_outer_layer_for_album").prepend(li);
				$("#album").val('');
			}
		}
	});
}
//限制输入字数，id为要限制的元素的id一般为文本框，count为限制的字数
function limit_word(id,count){
	var text_object = $("#"+id);
	text_object.keyup(function(){
		var word = text_object.val();
		if(countCharacters(word)>=count){
			text_object.val(subString(word,count));
		}
	});
}

//前台抓图创建相册
function bind_create_new_album(){
	$("#create_new_album").unbind("click");
	$("#create_new_album").click(function(){
		var category_id = $("#category_id_value").val();
		var album_title=$.trim($("#album_title_name").val());
		var pattern=/\n+/g;
		album_title = album_title.replace(pattern,' ');
		if(album_title == ''||album_title=='先给专辑起个名字'){
			$("#album_title_name").css("background-color",'red');
			setTimeout(function(){
				$("#album_title_name").css("background-color",'');
			},100);
			$("#album_title_name").val('先给专辑起个名字');
			return false;
		}else if(album_title.length > 20 || album_title.length< 4){
			$("#album_title_name").css("background-color",'red');
			setTimeout(function(){
				$("#album_title_name").css("background-color",'');
			},100);
			return false;
		}
		var data = {category_id:category_id,album_title:album_title};
		var request_url = site_url+"member/ajax_album_create";
		$.post(request_url,data,function(mesg){
			if(mesg.result==true){
				$("#album").val(mesg.insert_id);//为专辑隐藏框值
				$("#float_album").html("<label>"+album_title+"</label>");//标题
				$(".tuge_outer_layer_for_album").prepend('<li><a href="javascript:void(0)" class="album_value" album_id="'+mesg.insert_id+'">'+album_title+'</a></li>');
				$(".tuge_outer_layer_for_album").hide();//隐藏弹出框
				$("#album_title_name").val('先给专辑起个名字');
			}else{
				$("#show_kalon").hide();//隐藏弹出框
				$("#album_title_name").val('先给专辑起个名字');
				
			}
		},'json');
	});
}
function share_info_in(share_id){
	var show_id = "options_"+share_id;
	$("#"+show_id).show();
}

function share_info_out(share_id){
	var show_id = "options_"+share_id;
	$("#"+show_id).hide();
}
//防灌水机器 limit 限制事件秒数
function pre_crary(limit,limit_word){
	var limit = parseInt(limit)||10;
	var time = new Date().getTime();
	var last_time =0;
	var limit_word = limit_word||"last_time";
	if($("body").attr(limit_word)){
		last_time= $("body").attr(limit_word);
		var limit_time = 1000*limit;//10秒
		if((time-(parseInt(last_time))<limit_time)){
			$("body").attr(limit_word,time);
			return false;//灌水了
		}
		$("body").attr(limit_word,time);
		return true;
	}else{
		$("body").attr(limit_word,time);
		return true;//没有灌水
	}
	return true;

}
function report_menu(report_type){
	if(!current_uid){
		//myAlert("对不起，您尚未登录，请先登录哦！");
		show_login();
		return;
	}

	var limit_word = 255;//目前允许500个字或者字符
	var menu_html = "";
	menu_html+='<div class="jubao_layer">';
	menu_html+='<div id="layer_top">';
	menu_html+='<div class="layer_title">举报不良内容</div>';
	menu_html+='<div><span class="layer_close"><a href="javascript:void(0)">x</a></span></div>';
	menu_html+='</div>';
	menu_html+='<div class="jubao_content">';
	menu_html+='<div class="jubao_subtitle">选择举报类型</div>';
	menu_html+='<ul>';
	menu_html+='<li><input type="radio" name="category_id" value="fake" checked="checked" />虚假中奖信息</li>';
	menu_html+='<li><input type="radio" name="category_id" value="virus" />病毒网址</li>';
	menu_html+='<li><input type="radio" name="category_id" value="yellow" />涉黄信息</li>';
	menu_html+='<li><input type="radio" name="category_id" value="other" />其他原因</li>';
	menu_html+='</ul>';
	menu_html+='<div class="jubao_subtitle">补充说明:</div>';
	menu_html+='<input type="textarea" class="jubao_form" name="category_id" value="补充你的举报信息" />';
	menu_html+='<div id="message_box"></div>';
	menu_html+='<div class="jubao_button"><button type="submit" class="share_textarea_but">提交</button><button type="reset" class="share_common_but">取消</button></div>';
	menu_html+='</div>';
	menu_html+='</div>';
	var options = {
		title:'反馈',
		content:menu_html,
		padding:0,
		fixed:true,
		lock:true
	};
	var dialog = art.dialog(options);
	$("input.jubao_form").focus(function(){
		if($(this).val()=='补充你的举报信息'){
			$(this).val('');
			$(this).css('color',"#050");
		}

	}).blur(function(){
		if($(this).val()==''){
			$(this).val('补充你的举报信息');
			$(this).css('color',"#ccc");
		}
	});
	if(dialog){
		$("button.share_common_but").click(function(){dialog.close()});//have work not to do
		$("button.share_textarea_but").click(function(){
			var content = $("input.jubao_form").val();
			report_type = $("input[name=category_id]:checked").val();
			if(countCharacters(content) > limit_word)
			{
				$("#message_box").html("您输入小于"+limit_word+"的汉字或字符！");
				return false;
			}
			if(countCharacters(content) < 1 || content=="补充你的举报信息")
			{
				$("#message_box").html("请输入举报不良信息的理由！");
				return false;
			}

			var request_url = site_url+"ajax/report_content";
			if(!pre_crary(5,'report')){
				$("#message_box").html("两次举报间隔时间过短！");
				return;
			}
			$.post(request_url,{report:content,type:report_type},function(mesg){
				if(parseInt(mesg) == 1){
					//myAlert("投诉成功，感谢你的参与，我们会尽快处理！");
					art.dialog({title:"消息提示",content:"<img src='"+base_url+"themes/tupu/images/conform_ok.png'/>&nbsp;&nbsp;举报成功，感谢你的参与我们会尽快处理！",time:1000,height:60,width:300,icon:'succeed'});
					dialog.close();
				}
				else{
					art.dialog({title:"消息提示",content:"<img src='"+base_url+"themes/tupu/images/conform_ok.png'/>&nbsp;&nbsp;举报成功，感谢你的参与！",time:1000,height:60,width:300,icon:'succeed'});
					//myAlert("投诉失败，处理您的投诉时发生错误，请确认您已登录并填入正确的投诉内容！");
				}
			});

		});
	}
}
function update_userinfo(){
	var datas ={
		nickname:$("#nickname").val(),
		email:$("#email").val(),
		gender:$("input[name=gender]:checked").val(),
		bio:$("textarea[name=bio]").val(),
		province:$("#province").val(),
		city:$("#city").val()
	};
	var url = site_url+"member/update_userinfo";
	$.ajax({
		url:url,
		dataType:'json',
		data:datas,
		type:"post",
		beforeSend:function(){
			$('#ajax_message').html('提交中，请稍候');
		},
		success:function(mesg){
			if ($.trim(mesg.result) == "true") {
				$('#ajax_message').html(mesg.msg);
				//myAlert("个人信息保存成功，");
			}else {
				$('#ajax_message').html(mesg.msg);
			}
		}
	})
}
function edit_password(){
	var request_url = site_url+"ajax/load_edit_password";
	$.post(request_url,{},function(element){
		try{
			if(element)
			{
				var options = {title:'修改密码',content:element,padding:0,lock:true};
				var dialog = art.dialog(options);

				// 更新用户信息表单 form id=reset_passwd_form
				// File : /member/setting_security
				$('#reset_passwd_form').validate({
					rules: {
						email: { required: true, email: true, remote: site_url + "ajax/ajax_email_valid"},
						org_passwd: { required: true, rangelength: [6, 15] },
						new_passwd: { required: true, rangelength: [6, 15] },
						new_verify_passwd: { required: true, rangelength: [6, 15], equalTo: "#new_passwd" }
					},
					errorElement: "div",
					messages: {
						email: { required: "请输入有效的邮箱地址", email: "请输入有效的邮箱地址", remote: "邮箱已存在，请选择其它邮箱"},
						org_passwd: { required: "请输入密码", rangelength: "密码长度为6-15位"},
						new_passwd: { required: "请输入密码", rangelength: "密码长度为6-15位" },
						new_verify_passwd: { required: "请输入密码", rangelength: "密码长度为6-15位",equalTo: "两次输入的密码不一致" }
					},
					submitHandler: function(form) {
						$('#reset_passwd_form').ajaxSubmit({
							url: site_url + "member/reset_passwd",
							data: $('#update_userinfo').formSerialize(),
							type: 'POST',
							dataType: 'json',
							beforeSubmit: function(){
								$('#ajax_message').html('提交中，请稍候');
							},
							success: function(data) {
								if ($.trim(data.result) == "true") {
									//$('#ajax_message').html(data.msg);
									//myAlert(data.msg+"请重新登录！");
									$("#error_message").html(data.msg+'请重新登录！');
									//window.location.href = site_url + "member/setting_info";
									setTimeout(function(){
										dialog.close();
										window.location.href = site_url + "login/logout";//此处应该退出
									},2000);
								}else {
									//$('#ajax_message').html(data.msg);
									$("#error_message").html(data.msg);
								}

							}
						});
						return false;
					}
				}); //更新用户信息表单结束
			}else{
				throw new Error("未知请求异常！");
			}
		}catch(e){
			myAlert(e.message);
		}
	});
}
function TWinOpen(url,id,iWidth,iHeight)
{
	var iTop = (screen.height-30-iHeight)/2; //获得窗口的垂直位置;
	var iLeft = (screen.width-10-iWidth)/2; //获得窗口的水平位置;
	/*TWin=window.showModalDialog(url,null,"dialogWidth="+iWidth+"px;dialogHeight="+iHeight+"px;dialogTop="+iTop+"px;dialogLeft="+iLeft+"px");*/
	window.location.href=url;
}

function iFrameHeight(frame) {
	var ifm= $(frame);
	var subWeb = document.frames ? document.frames[frame].document : ifm.contentDocument;
	if(ifm != null && subWeb != null) {
		ifm.height = subWeb.body.scrollHeight;
	}
}

function show_login(current_controller){
	var request_url=site_url+'ajax/load_login';
	$.post(request_url,{},function(ele){
		if(ele){
			var dialog  = art.dialog({title:'用户登录',content:ele,padding:0,fixed:true,lock:true,opacity:0.87});
			$('#login_form').validate({
				rules: {
					email: { required: true, email: true },
					password: { required: true, minlength: 6 }
				},
				messages: {
					email: { required: "请输入有效的邮箱地址", email: "请输入有效的邮箱地址"},
					password: { required: "请输入有效的密码", minlength: "请输入有效的密码"}
				},
				errorElement: "td",
				submitHandler: function(form) {
					var url=site_url + "login/ajax_login";
					var data =  $('#login_form').formSerialize();
					$.ajax({
						url:url,
						data:data,
						dataType:'json',
						type:'post',
						beforeSend:function(){
							$('#ajax_message').html('登录中，请稍候');
						},
						success:function(data) {
							if ($.trim(data.result) == "true") {
								//$('#ajax_message').html(data.msg);
								//dialog.close();
								//art.dialog({title:'登录提示!',content:data.msg});
								$("#show_forbidden_warning").html(data.msg);
								if(data.synlogin){
									$("body").append(data.synlogin);
								}
								var controller = (current_controller =="register"||current_controller=="member"||current_controller=="welcome")? "member/index" :"current";
								if(controller=="current"){
									setTimeout(function(){window.location.reload()},1000);
								}else{
									setTimeout(function(){window.location.href = site_url + controller;},1000);
								}


								//setTimeout(function(){window.location.reload()},2000);
							}else {
								//$('#ajax_message').html(data.msg);
								$("#show_forbidden_warning").html(data.msg);
								//art.dialog({title:'登录提示!',content:data.msg});
							}
						}
					});
					return false;
				}
			}); //登录表单结束
		}

	});
}
//首页分类展示
function slide_toggle(){
	$("#hidden_toggle").slideToggle(400,function(){
		var imgs = $("#slide_img");
		if(imgs.attr("src").indexOf('add.png') != -1)
		imgs.attr("src",base_url+'themes/tupu/images/icon/income.png');
		else
		imgs.attr("src",base_url+'themes/tupu/images/icon/add.png');
	});

}
//计算包含英文与汉字的字符串长度
function countCharacters(str){
	var totalCount = 0;
	for (var i=0; i<str.length; i++) {
		var c = str.charCodeAt(i);
		if ((c >= 0x0001 && c <= 0x007e) || (0xff60<=c && c<=0xff9f)) {
			totalCount++;
		}else {
			totalCount+=2;
		}
	}
	// alert(totalCount);
	return totalCount;
}

//计算输入的字符个数并计算剩余字数 total 为要输入的总字数，span Text 为要变化的统计对象
function countChar(obj,total,spanText){
	var total = parseInt(total);
	var textInput = $(obj);//对象
	var value = $.trim(textInput.val());//输入的字或字符串
	var currentSum = countCharacters(value);
	var divs =0;//剩下的字符数
	var show_warning = null;
	if(spanText && typeof spanText=='string')
	show_warning = $("#"+spanText).get(0);
	else
	show_warning = spanText;
	if(currentSum <= total){
		divs = total - currentSum;
		if(show_warning)
		$(show_warning).css('color','#717171');
	}else{
		sub_val = subString(textInput.val(),total);
		currentSum = countCharacters(textInput.val());
		divs  = total -currentSum;
		$(show_warning).css('color','red');
		textInput.val(sub_val);
	}
	$(show_warning).text(divs);
}
//添加评论
function page_add_comment(id,share_id,backText){
	var share_id = parseInt(share_id);
	var total = 140;//只允许140个字符
	var comments = $("#"+id);//评论框
	var pattern=/\n+/g;
	var commentVal=comments.val().replace(pattern,' ');
	var totalChar = countCharacters($.trim(commentVal));
	if(!current_uid){
		show_login();
		return;
	}
	if(totalChar > total)
	{
		art.dialog({title:"消息提示",content:"<img src='"+base_url+"themes/tupu/images/conform_no.png'/>&nbsp;&nbsp;对不起，您的评论超出字数限制!",time:'1000',height:50,width:100});
		return false;
	}else if(totalChar < 1){
		art.dialog({title:"消息提示",content:"<img src='"+base_url+"themes/tupu/images/conform_no.png'/>&nbsp;&nbsp;请输入评论内容!",time:'1000',height:50,width:200,icon:'warning'});
		return;
	}
	var datas = {comment:$.trim(commentVal),share_id:share_id};
	var urls = site_url+"share/add_comment";
	if(!pre_crary(5,'comment'))
	{
		art.dialog({title:'消息提示',content:"<img src='"+base_url+"themes/tupu/images/conform_no.png'/>&nbsp;&nbsp;您评论的太快了，休息一下!",width:250,height:50,time:'1000',icon:'system'});
		return;
	}
	$.ajax({
		url:urls,
		type:'post',
		dataType: 'json',
		data:datas,
		success:function(mesg){
			if(mesg.forbid==true){
				art.dialog({title:'消息提示',content:'对不起，您目前处于被禁言状态，暂时不能发表评论！',width:'250',height:'50',time:'2000',height:100});
				return;
			}else if($.trim(mesg.msg) == "not_login"){
				show_login();//登录
				return;
				//art.dialog({title:'消息提示',content:'对不起，您还没有登录，暂时不能评论！',width:'250',time:'2000',height:100});
			}else if ($.trim(mesg.result) == "true") {
				var current_userpage = base_url + 'u/' + current_uid ;
				var html ='<li class="system_list" id="comment_'+mesg.comment_id+'">';
				html+='<ol> <a href="'+current_userpage+'" target="_blank"><img src="'+current_user_avatar+'_middle.jpg"/></a></ol>';
				html+='<ol class="system_list_ifo"><span><a href="'+current_userpage+'" class="member_name" target="_blank">'+current_nickname+'</a></span>：'+mesg.data+'<span class="time">1秒前</span></ol><ol class="system_list_delete"><span><a href="javascript:void(0)" class="system_list_delete" onclick="report_menu()">举报</a></span></ol><ol class="system_list_delete"><span><a href="javascript:void(0)" class="system_list_delete" onclick="delete_comment('+mesg.comment_id+','+share_id+')" id="del_comment_'+mesg.comment_id+'">删除</a></span></ol></li>';
				var new_comment=' <li class="system_list" id="comment_'+mesg.comment_id+'"><ol>';
				new_comment+='<a href="'+current_userpage+'" target="_blank"><img src="'+current_user_avatar+'_middle.jpg" width="35" /></a>';
				new_comment+='</ol><ol class="system_list_ifo"><span><a href="'+current_userpage+'" target="_blank" class="member_name">'+current_nickname+'</a></span>';
				new_comment+='<span class="time">小于一秒</span><span style="float:right;"><a href="javascript:void(0)" class="system_list_delete" onclick="report_menu()">举报</a>| <a href="javascript:void(0)" onclick="delete_comment('+mesg.comment_id+','+share_id+')" id="del_comment_'+mesg.comment_id+'" class="system_list_delete">删除</a>';
				new_comment+='</span></ol><ol style="float:left;width:576px;color:#666666;font-size:12px;padding-left:12px;">'+$.trim(mesg.data)+'</ol></li>';
				art.dialog({title:"消息提示",content:"<img src='"+base_url+"themes/tupu/images/conform_ok.png'/>&nbsp;&nbsp;评论成功！",time:1000,height:50,width:200,icon:'succeed'});
				$(new_comment).insertAfter("li.uniq_li").hide().slideDown("slow");
				comments.val('');
				if(backText)
				$("#"+backText).text(total);
			}
		}
	});
}
//user_id 操作者，friend_id,要加的好友id，element_id，要替换掉的外层箱子类名
function add_follow(user_id,friend_id,element_class){
	var user_id = parseInt(user_id);
	if(!user_id){
		//myAlert("您还没有登录！");
		show_login();
		return;
	}
	var friend_id = parseInt(friend_id);
	var element_class = $.trim(element_class);
	if(user_id == friend_id){
		myAlert('请不要关注自己！');
		return;
	}
	var request_url = site_url+'ajax/ajax_add_follow';
	var send_data ={user_id:user_id,friend_id:friend_id};
	$.post(request_url,send_data,function(mesg){
		if($.trim(mesg.result=="true")){
			var img_path = base_url+'themes/tupu/images/button/attention_no.jpg';
			var replace_button ='<img onclick="remove_follow('+user_id+','+friend_id+',\''+element_class+'\')" src="'+img_path+'"/>';
			if(element_class)
			$("."+element_class).hide().slideDown('slow').html(replace_button);
			myAlert(mesg.msg);
			return;
		}else{
			myAlert("关注失败！");
			return;
		}
		myAlert("非法操作!");
	},'json');
}
function myAlert(mesg,options){
	var option = options || {title:'消息提示',time:2000,width:250,height:50,content:mesg};
	art.dialog(option);
}

function remove_follow(user_id,friend_id,element_class){
	var user_id = parseInt(user_id);
	var friend_id = parseInt(friend_id);
	if(!user_id){
		myAlert("您还没有登录！");
		return;
	}
	var element_class = $.trim(element_class);
	var request_url = site_url+'ajax/ajax_remove_follow';
	var send_data ={user_id:user_id,friend_id:friend_id};
	var dialog = art.dialog({title:'信息提示',content:'确定不再关注此人吗？',okValue:'确认',cancelValue:'取消',ok:function(){
		$.post(request_url,
		send_data,
		function(data){
			if ($.trim(data.result) == "true") {
				var img_path = base_url+'themes/tupu/images/button/attention.jpg';
				var replace_button ='<img onclick="add_follow('+user_id+','+friend_id+',\''+element_class+'\')" src="'+img_path+'"/>';
				if(element_class)
				$("."+element_class).hide().slideDown('slow').html(replace_button);
				myAlert(data.msg);
			}else {
				alert(data.msg);
			}
		},'json');
	},cancel:function(){}});
}

function count_bio_word(){
	var bio_word = $("#textarea").val();
	var word_limit = 255;
	if(countCharacters(bio_word)>=word_limit){
		sub_word = subString(bio_word,word_limit);
		$("#textarea").val(sub_word);
	}

}
function delete_comment(comment_id,share_id){
	if(!current_uid){
		myAlert("非法操作！");
	}
	var request_url = site_url+"ajax/del_comment";
	var data = {comment_id:comment_id,share_id:share_id};
	var html = del_html("删除评论","您确定要删除该评论？");
	/*
	art.dialog({title:'消息提示',content:html,okValue:'确定',cancelValue:'取消',ok:function(){
	$.post(request_url,data,function(msg){
	if(parseInt(msg)==1){
	myAlert("删除评论成功！");
	$("#comment_"+comment_id).hide(800);
	}else{
	myAlert("删除评论失败！");
	}
	});
	},cancel:function(){}});
	*/
	var dialog = art.dialog({content:html,lock:true});
	$(".share_textarea_but").click(function(){
		$.post(request_url,data,function(msg){
			if(parseInt(msg)==1){
				art.dialog({title:"消息提示",content:"<img src='"+base_url+"themes/tupu/images/conform_ok.png'/>&nbsp;&nbsp;删除评论成功！",time:1000,height:60,width:250,icon:'succeed'});
				$("#comment_"+comment_id).hide(800);
				dialog.close();
			}else{
				art.dialog({title:"消息提示",content:"<img src='"+base_url+"themes/tupu/images/conform_ok.png'/>&nbsp;&nbsp;删除评论失败！",time:1000,height:60,width:300,icon:'succeed'});
			}
		});
	})
	$(".share_common_but").click(function(){dialog.close.call(dialog)});
}
//计算图片比例，等比例缩放
function DrawImage(ImgD,FitWidth,FitHeight){
	var image=new Image();
	image.width=ImgD.width;
	image.height=ImgD.height;
	if(image.width>0 && image.height>0){
		if(image.width/image.height>= FitWidth/FitHeight){
			if(image.width>FitWidth){
				ImgD.width=FitWidth;
				ImgD.height=(image.height*FitWidth)/image.width;
			}else{
				ImgD.width=image.width;
				ImgD.height=image.height;
			}
		} else{
			if(image.height>FitHeight){
				ImgD.height=FitHeight;
				ImgD.width=(image.width*FitHeight)/image.height;
			}else{
				ImgD.width=image.width;
				ImgD.height=image.height;
			}
		}

	}
	return ImgD;
}

//中英文截取无乱码
function subString(str, len, hasDot)
{
	var newLength = 0;
	var newStr = "";
	var chineseRegex = /[^\x00-\xff]/g;
	var singleChar = "";
	var strLength = str.replace(chineseRegex,"**").length;
	for(var i = 0;i < strLength;i++){
		singleChar = str.charAt(i).toString();
		if(singleChar.match(chineseRegex) != null){
			newLength += 2;
		}else{
			newLength++;
		}
		if(newLength > len){
			break;
		}
		newStr += singleChar;
	}

	if(hasDot && strLength > len){
		newStr += "...";
	}
	return newStr;
}


function feedback_menu(report_type){
	if(!current_uid){
		//myAlert("对不起，您尚未登录，请先登录哦！");
		show_login();
		return;
	}

	var limit_word = 500;//目前允许500个字或者字符
	var menu_html = "";
	menu_html+='<div class="feedback_layer">';
	menu_html+='<div id="layer_top">';
	menu_html+='<div class="layer_title">意见反馈</div>';
	menu_html+='<div><span class="layer_close"><a href="javascript:void(0)">x</a></span></div>';
	menu_html+='</div>';
	menu_html+='<div class="feedback_content">请输入您的意见或者建议，您的反馈将帮助我们更好的为您服务。</div>';
	menu_html+='<div class="feedback_content"><textarea id="mes" rows="10" cols="30" name="mes" class="feedback_textarea"></textarea></div>';
	menu_html+='<div id="mesg_box" class="feedback_error"></div>';
	menu_html+='<div class="feedback_button"><button type="submit" class="share_textarea_but">提交</button><button type="reset" class="share_common_but">取消</button></div>';
	menu_html+='</div>';
	var options = {
		title:'反馈',
		content:menu_html,
		padding:0,
		fixed:true,
		lock:true
	};
	var dialog = art.dialog(options);
	if(dialog){
		$("button.share_common_but").click(function(){dialog.close()});//have work not to do
		$("button.share_textarea_but").click(function(){
			var content = $("#mes").val();
			report_type = report_type||"comment";
			if(countCharacters(content) > limit_word)
			{
				$("#mesg_box").html("您输入的汉字超过指定的长度，请输入小于"+limit_word+"的汉字或字符！");
				return false;
			}
			var request_url = site_url+"ajax/report_content";

			$.post(request_url,{report:content,type:report_type},function(mesg){
				if(parseInt(mesg) == 1){
					if(!pre_crary(5,'report')){
						$("#mesg_box").html("两次反馈间隔太短，请稍后再试！");
						return;
					}
					myAlert("<img src='"+base_url+"themes/tupu/images/conform_ok.png'/>&nbsp;&nbsp;感谢您的意见，我们会很快处理！");
					dialog.close();
				}
				else{
					$("#mesg_box").html("请输入您要反馈的内容！");
				}
			});

		});
	}
}
function slide_share(){
	var config = {
		count:8,//元素个数至少是count才启动滑动
		speed:5000,//元素滑动的间隔时间
		move_speed:1000,//元素滑动的速度
		slide_speed:1000,//元素淡入的时间
		opacity_speed:1000
	};
	var length = parseInt($("#slide_share li").size());
	if( length < config.count)
	return;
	setInterval(function(){
		var last = $("#slide_share li:last").hide().remove();
		last.css('opacity','0.0');//元素透明度清空
		$("#slide_share").prepend(last);
		last.show(config.slide_speed);
		last.animate({opacity:1.0},config.opacity_speed);

	},config.speed);
}

function slide_users(){
	var config = {
		count:6,//元素个数至少是count才启动滑动
		speed:5000,//元素滑动的间隔时间
		move_speed:1000,//元素滑动的速度
		slide_speed:1000,//元素淡入的时间
		opacity_speed:1000
	};
	var length = parseInt($("#slide_users li").size());
	//$("a[id=^SlideDeck_Bug]").hide();
	if( length < config.count)
	return;
	setInterval(function(){
		var last = $("#slide_users li:last").hide().remove();
		last.css('opacity','0.0');//元素透明度清空
		$("#slide_users").prepend(last);
		last.show(config.slide_speed);
		last.animate({opacity:1.0},config.opacity_speed);

	},config.speed);
}
//用户注册解决360下无法注册
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?"":e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)d[e(c)]=k[c]||e(c);k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1;};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p;}('$(4(){$("#f").B(4(){2(!$("#C").g("z")){$("#m").5("A",\'#D\').l("G");7 8}o{$("#m").l("")};2($("#k").9()<6||($("#k").9()!=$("#H").9())){$(".0").3("E");7 8};j a=F.u.t();2(a.x(\'y\')!=-1){j b=$(\'#s\').q();$.v({w:r+"I/X",Y:$(\'#s\').q(),W:\'U\',V:\'11\',10:4(){$("#f").g("h","h");$(".0").5("e","d");$(".0").3("Z，M....")},N:4(c){2($.L(c.J)=="n"){$(".0").5("e","d");$(".0").3(c.p);2(c.i){K.O(c.i)};S.T.R=r+"P/Q"}o{$(".0").5("e","d");$(".0").3(c.p);$("#f").g("h",8);}}});7 8};7 n})});',62,64,'regi_errer||if|html|function|css||return|false|val||||visible|visibility|agree_validate|attr|disabled|synlogin|var|password|text|agree_privilige|true|else|msg|formSerialize|site_url|register_form|toLowerCase|appVersion|ajax|url|indexOf|360se|checked|color|click|agree|B94A48|密码长度过小或者两次密码输入不一致|navigator|请阅读用户注册条款|passconf|register|result|document|trim|请稍后|success|write|welcome|index|href|window|location|POST|dataType|type|ajax_register|data|注册中|beforeSend|json'.split('|'),0,{}))

function add_comment(id){
  if(!current_uid){show_login();return;}
  var comment  =  '<li class="tu_intro_line">';
      comment += '<tt class="member"><a href=\"'+site_url+"/u/"+current_uid+"\" target=\"_blank\"><img src="+current_user_avatar+'_middle.jpg width="24" height="24"/></a></tt>';
      comment += '<tt class="wenzi"><textarea id="comment_area_'+id+'"rows="4" cols="32"></textarea><p >140/140</p><input type="image" class="waterfull_catefy" src="'+base_url+'themes/tupu/images/comment_btn02.png" onclick="ajax_add_comment('+id+')" value="评论"></tt></li>';
  $("#add_comment_"+id +" div").html(comment);
  $("#add_comment_"+id +" div  p").css({"width":"110px","height":"15px","float":"left","margin-right":"5px","line-height":"24px"});
  $(".add_comment").hide();
  $("#add_comment_"+id).show();
  $(".show_all").show();
  $(".share_all").show();
  $("#comment_"+id+" li[class='share_all']").hide();
  $("#comment_"+id+" li[class='show_all']").hide();
  refresh_fall();
  
  var total=140;
  $("#add_comment_"+id+" div li tt textarea").focus().keyup(function(){
  var comments = $(this).val();
	var totalChar = countCharacters($.trim(comments));
    limit_word("comment_area_"+id,total);
	if(totalChar > total)
	{
		$("#add_comment_"+id+" div li tt p").text("您输入字符超出限制").css({"color":"red"});
		return false;
	}else if(totalChar < 1){
		$("#add_comment_"+id+" div li tt p").text("请输入评论内容").css({"color":"red"});
		return false;
	}else{
      	$("#add_comment_"+id+" div li tt p").text(140-totalChar+"/140").css({"color":"rgb(113, 113, 113)"});    
    }
  });
}

function ajax_add_comment(id){
  var comment = $("#add_comment_"+id+" div li tt textarea").val();
  var totalChar = countCharacters($.trim(comment));
  if(totalChar<1){
    $("#add_comment_"+id+" div li tt p").text("请输入评论内容").css({"color":"red"});
      return false;
  }
  var pattern=/\n+/g;
  var commentVal=comment.replace(pattern,' ');
  var datas = {comment:commentVal,share_id:id};
	var urls = site_url+"share/add_comment";
	$.ajax({
    url:urls,
    type:'post',
    dataType: 'json',
    data:datas,
    success:function(mesg){   
      if(mesg.forbid==true){     
        art.dialog({
          title:'消息提示',
          content:'对不起，您目前处于被禁言状态，暂时不能发表评论！',
          width:'250',
          time:'2000',
          height:100
        });
        return;	
      }else if($.trim(mesg.msg) == "not_login"){
        if(!current_uid){
          show_login();
          return;
        }
      }else if ($.trim(mesg.result) == "true") {	
        var result_comment = "<p>评论成功&nbsp;&nbsp;</p>";
        $(result_comment).insertAfter($("#comment_"+id).parent()).css({"position":"absolute","top":"100px","left":"90px","padding":"3px 6px","color":"white","background-color":"red"}).show().hide(2000);
        var insert_new_comment = '<li class="tu_intro_line">';
            insert_new_comment += '<tt class="member"><a href="'+site_url+'/u/1" target="_blank"><img src="'+current_user_avatar+'_middle.jpg" width="24" height="24"/></a></tt>';
            insert_new_comment += '<tt class="wenzi"><span><a href="'+site_url+'u/1"  class="member_name">'+current_nickname+'</a> </span>'+ mesg.data+'</tt></li>';
        $(insert_new_comment).insertAfter($("#comment_"+id+" li:eq(2)"));
        var number_count = parseInt($("#comment_"+id+" .show_all").attr("number_count"))+1;
        $("#comment_"+id+" .show_all").attr("number_count", number_count);
        $("#comment_"+id+" .show_all > a").text("显示全部"+number_count+"条评论");
        $("#comment_"+id+" .share_all").show();
        $("#comment_"+id+" .show_all").show();
        $("#add_comment_"+id).hide();
        $("#comment_"+id+" .tu_intro_line:eq(6)").hide();
         refresh_fall();
      }	
    }
  });
}

function share_to_out(id,where){
  var title =$("title").text();
  var content = $("#share_"+id+" .tu_intro").text();
  var link  = $("#share_"+id+" ul li:eq(0)  a").attr("href")
  var pic   = $("#share_"+id+" ul li a img").attr("src");
  
  switch (where){
    case "sina":
        window.open('http://v.t.sina.com.cn/share/share.php?&url='+encodeURIComponent(link)+'&pic='+encodeURIComponent(pic)+'&title='+encodeURIComponent("#"+title+"#"+"#"+content+"#")+'&appkey='+encodeURIComponent(config_sina_key),'_blank','scrollbars=no,width=600,height=450,left=75,top=20,status=no,resizable=yes');
        break;
    case "renren":
        window.open('http://share.renren.com/share/buttonshare.do?link='+encodeURIComponent(link)+'&title='+encodeURIComponent("#"+title+"#")+'&pic='+encodeURIComponent(pic)+'&description='+encodeURIComponent(content),'_blank','scrollbars=no,width=600,height=450,left=75,top=20,status=no,resizable=yes');
        break;
    case "qq":
        window.open('http://v.t.qq.com/share/share.php?url='+encodeURIComponent(link)+'&title='+encodeURIComponent("#"+title+"#"+content+"#")+'&pic='+encodeURI(pic)+'&appkey='+encodeURIComponent(config_qq_key),'_blank','scrollbars=no,width=600,height=450,left=75,top=20,status=no,resizable=yes')    
        break;
    default: 
      return;
  }
}
