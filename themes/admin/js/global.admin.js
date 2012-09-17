//禁言功能
function forbidden(user_id,nickname,obj){
	var html='';
	html+="<div style='width:280px;height:100px;'>";
	html+="<h4 style='color:#050'>请选择对用户 "+nickname+" 的屏蔽时间:</h4>";
	html+="<div style='padding-left:40px;'><input type='radio' name='forbidden' value='1' checked='checked'/>48小时<br />";
	html+="<input type='radio' name='forbidden' value='2'/>永久屏蔽(该操作不可逆)</div>";
	html+="</div>";
	var options={
	title:'系统通知',
	content:html,
	width:300,
	height:80,
	ok:function(){
		var forb_type=$("input[type=radio]:checked").val();//禁言类型
		var url=site_url+"admin/user_forbidden/";
		var data={user_id:user_id,type:forb_type};
		var msg1="屏蔽48小时";
		var msg2="永久屏蔽";
		var spanObj=$(obj).parent();
		var message=forb_type==1?msg1:msg2;
		$.post(url,data,function(msg){
			if(msg==1){
				art.dialog({title:'提示信息',content:'屏蔽成功!',width:200,height:100,time:'2000'});
				spanObj.html(message);
			}else{
				art.dialog({title:'提示信息',content:'屏蔽失败!',width:200,height:100,time:'2000'});
			}
		});
	},
	cancel:function(){}
	};
	art.dialog(options);
}
//后台删除专辑相册
function album_delete(album_id){
	var url=site_url+"admin/album_list/delete";
	art.dialog({title:'消息提示',content:"您确定删除该专辑吗？",ok:function(){
			$.post(url,{album_id:album_id},function(msg){
		if(msg==1){
			art.dialog({title:'信息提示',content:'删除成功!',width:180,height:70,icon:'succeed'});
			$("#album_"+album_id).hide('slow');
		}
	});
			return true;
		},cancel:function(){},okValue:'确定',cancelValue:'取消'});
	
}
//后台删除评论
function comment_delete(comment_id,share_id){
	var url=site_url+"admin/comment_list/delete";
	art.dialog({title:'消息提示',content:"您确定删除该评论吗？",ok:function(){
			$.post(url,{comment_id:comment_id,share_id:share_id},function(msg){
		if(msg==1){
			art.dialog({title:'信息提示',content:'删除成功!',width:180,height:70,icon:'succeed'});
			$("#comment_"+comment_id).hide('slow');
		}
	})
			return true;
		},cancel:function(){},okValue:'确定',cancelValue:'取消'});
	
}
//审核专辑相册，type为类型1是审核通过，2是屏蔽
function verify(album_id,type){
	var flag=(album_id&&type) ? true:false;
	if(!flag)
	art.dialog({title:'信息提示',content:'操作失败，丢失数据!',width:180,height:70,icon:'succeed'});
	var url=site_url+'admin/album_list/verify';
	var data={album_id:album_id,type:type};
	$.ajax({
		type:'post',
		url:url,
		data:data,
		success:function(msg){
			if(msg==1&&type==1){
				art.dialog({title:'信息提示',content:'通过审核!',width:180,height:70});
				$("#status_"+album_id).text('已通过');
				$("#operation_"+album_id).html("<a href='javascript:void(0)' onclick='verify("+album_id+",2)'>屏蔽</a>");
			}else if(msg==1&&type==2){
				art.dialog({title:'信息提示',content:'屏蔽成功!',width:180,height:70});
				$("#status_"+album_id).text('屏蔽');
				$("#operation_"+album_id).html("<a href='javascript:void(0)' onclick='verify("+album_id+",1)'>审核</a>");
			}else{
				art.dialog({title:'信息提示',content:'操作失败!',width:180,height:70});
			}
		}	
	});
}
function verify_commment(comment_id,type,share_id){
	var flag=(comment_id&&type) ? true:false;
	if(!flag)
	art.dialog({title:'信息提示',content:'操作失败，丢失数据!',width:180,height:70,icon:'succeed'});
	var url=site_url+'admin/comment_list/verify';
	var data={comment_id:comment_id,type:type,share_id:share_id};
	var verify_html="<a href='javascript:void(0)' onclick='verify_commment("+comment_id+",1,"+share_id+")'>审核</a>";
	var forbidden_html="<a href='javascript:void(0)' onclick='verify_commment("+comment_id+",2,"+share_id+")'>屏蔽</a>";
	$.ajax({
		type:"post",
		url:url,
		data:data,
		success:function(msg){
			if(msg==1&&type==1){
				art.dialog({title:'信息提示',content:'通过审核!',width:180,height:70});
				$("#operation_"+comment_id).html(forbidden_html);
				$("#status_"+comment_id).text('已通过');
			}else if(msg==1&&type==2){
				art.dialog({title:'信息提示',content:'屏蔽成功!',width:180,height:70});
				$("#operation_"+comment_id).html(verify_html);
				$("#status_"+comment_id).text('屏蔽');
			}else{
				art.dialog({title:'信息提示',content:'操作失败!',width:180,height:70});
			}
		}
	});
}
//全选
function select_all(name){
	$("input[name="+name+"]").attr("checked","checked");
}
//一键功能 专辑审核 type =1，通过审核 2,屏蔽审核
function do_verify(type){
	var selected=new Array();
	$("input[name=verify]").each(function(){
		if($(this).attr("checked")){
			selected.push($(this).val());
		}	
	});
	if(selected.length==0){
		art.dialog({title:'信息提示',content:'没有选择任何专辑!',time:2000,width:180,height:70});
		return;
	}
	var string_albums=selected.join("|");
	var url=site_url+'admin/verify_album';
	$.post(url,{type:type,album_ids:string_albums},function(msg){
		if(msg==1){
			art.dialog({title:'信息提示',content:'操作成功!',time:2000,width:180,height:70});
			for(var album_id in selected){
				$("#album_"+selected[album_id]).hide("slow");
			}
		}else{
			art.dialog({title:'信息提示',content:'认证失败!',time:2000,width:180,height:70});
		}
	});
	
}
//一键功能 评论审核 type =1，通过审核 2,屏蔽审核
function do_comment_verify(type){
	var selected=new Array();
	var share_ids=new Array();
	$("input[name=verify]").each(function(){
		if($(this).attr("checked")){
			selected.push($(this).val());
			share_ids.push($(this).attr("share_id"));
		}	
	});
	if(selected.length==0){
		art.dialog({title:'信息提示',content:'没有选择任何评论!',time:2000,width:180,height:70});
		return;
	}
	var string_coms=selected.join("|");
	var string_shares=share_ids.join("|");
	var url=site_url+'admin/verify_comment';
		$.post(url,{type:type,comment_ids:string_coms,share_ids:string_shares},function(msg){
			if(msg==1){
			art.dialog({title:'信息提示',content:'操作成功!',time:2000,width:180,height:70});
			for(var comment_id in selected){
				$("#comment_"+selected[comment_id]).hide("slow");
			}
		}else{
			art.dialog({title:'信息提示',content:'操作失败!',time:2000,width:180,height:70});
		}
	});
}

//一键功能 所有审核 type =1，通过审核 2,屏蔽审核
function do_share_verify(type){
	var selected=new Array();
	$("input[name=verify_share]").each(function(){
		if($(this).attr("checked")){
			selected.push($(this).val());
			//share_ids.push($(this).attr("share_id"));
		}	
	});

	if(selected.length==0){
		art.dialog({title:'信息提示',content:'没有选择任何分享!',time:2000,width:180,height:70});
		return;
	}
	var string_ids=selected.join("|");
	//var string_shares=share_ids.join("|");
	var url=site_url+'admin/verify_share';
		$.post(url,{type:type,share_ids:string_ids},function(msg){
			if(msg==1){
			
			for(var share_id in selected){
				$("#share_"+selected[share_id]).remove();
			}
			//setTimeout(function(){
				art.dialog({title:'信息提示',content:'操作成功!',time:2000,width:180,height:70});
			//},1000);
			
		}else{
			art.dialog({title:'信息提示',content:'操作失败!',time:2000,width:180,height:70});
		}
	});
}

//ajax批量发布宝贝
function post_items(dialog){
var pro_infos = new Array();
setTimeout(function(){
	(function(){
	$("input:checkbox").each(function(){
	var pro_id = $(this).val();
	var item_info = $("#pro_infos_"+pro_id).val();
    var url=site_url+'admin/post_multi_items';
		if($(this).attr("checked")){
			pro_infos.push(pro_id);
			var item_info = $("#pro_infos_"+pro_id).val();//要插入数据库的数据
			var album_id = $("#album_name").val();//专辑id
			$.ajax({
				url:url,
				async:false,
				data:{item:item_info,album_id:album_id},
				type:"POST",
				success:function(msg){
				}
			});
		}	
});
if(pro_infos.length==0){
	dialog.close();
	art.dialog({title:'信息提示',content:'您还未选择任何商品!',time:2000,width:180,height:70});
	return;
}else{
	dialog.close();
	art.dialog({title:'信息提示',content:'发布商品成功!',time:2000,width:180,height:70});
	$("input:checkbox").attr("checked",false);
}	
})();
},10);

}
function show_edit(item_id){
	var item_title = $('#item_'+item_id+'_title').val();
	var html_content="<div><textarea cols='5' rows='5' id='textarea_title_"+item_id+"'>"+item_title+"</textarea></div>";
	
	art.dialog({
	title:'编辑商品信息',
	content:html_content,
	ok:function(){
		var edit_info_items_val = $('#textarea_title_'+item_id).val();
		if(edit_info_items_val.length > 120){
			art.dialog({title:'错误提示!',content:"您输入的字符超出120字符!请重新输入",time:1500});
			return false;
		}
		$('#item_'+item_id+'_title').val(edit_info_items_val);
		$('#item_'+item_id+'_title_span').html(edit_info_items_val);
	},
	cancel:function(){}
	});
}
