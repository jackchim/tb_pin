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
	var value = textInput.val();//输入的字或字符串
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
		divs  = total -currentSum;
		$(show_warning).css('color','red');
	}
	$(show_warning).text(divs);
}
//添加评论
function page_add_comment(id,share_id,backText){
	var share_id = parseInt(share_id);
	var total = 140;//只允许140个字符
	var comments = $("#"+id);//评论框
	var totalChar = countCharacters(comments.val());
	if(totalChar > total)
	{
		art.dialog({title:"消息提示",content:"对不起，您的评论超出字数限制!"});
		return false;
	}else if(totalChar < 1){
		art.dialog({title:"消息提示",content:"请输入评论内容!"});
		return;
	}
	var datas = {comment:comments.val(),share_id:share_id};
	var urls = site_url+"share/add_comment";
	$.ajax({
		url:urls,
		type:'post',
		dataType: 'json',
		data:datas,
		success:function(mesg){
			if(mesg.forbid==true){
					art.dialog({title:'消息提示',content:'对不起，您目前处于被禁言状态，暂时不能发表评论！',width:'250',time:'2000',height:100});
					return;	
			}else if($.trim(mesg.msg) == "not_login"){
              if(!current_uid){
                  show_login();
                  return;
              }
			}else if ($.trim(mesg.result) == "true") {	
				var current_userpage = base_url + 'u/' + current_uid ;
				var html ='<li class="system_list">';
				html+='<ol> <a href="#"><img src="'+current_user_avatar+'_middle.jpg"/></a></ol>';
				html+=' <ol class="system_list_ifo"><span><a href="'+current_userpage+'" class="member_name">'+current_nickname+'</a></span>：'+mesg.data+'<span class="time">1秒前</span></ol> <!--<ol class="system_list_delete"><span><a href="#" class="system_list_delete">投诉</a></ol><ol class="system_list_delete"><span><a href="#" class="system_list_delete">删除</a></ol>--></li>';
				$(html).insertAfter("li.uniq_li");
				art.dialog({title:'消息提示',content:'评论成功！',time:'2000'});
				comments.val('');
				if(backText)
				$("#"+backText).text(total);
				}	
		}
	});
}