<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="<?php echo base_url('themes/admin/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url('themes/admin/css/admin.css'); ?>" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url('assets/js/jquery-1.7.2.min.js')?>" type="text/javascript"></script>
<link id="artDialog-skin" href="<?php echo base_url('assets/js/dialog/skins/default.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/js/dialog/artDialog_default.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('themes/admin/js/global.admin.js') ?>"></script>
<script src="<?php echo base_url('themes/admin/js/jquery.form.js'); ?>" type="text/javascript"></script>
<script>
var site_url = '<?php echo (strpos(site_url(),'index.php') === false) ?site_url():site_url().'/';?>';
var base_url = '<?php echo base_url();?>';
</script>
<title>后台登录界面</title>
</head>

<body>
<div class="tablebox_header">   
<!--<form action="<?php echo site_url('admin/item_list/search');?>" method="get" class=" form-search pull-right">
        <input type="text" name="keyword" class="input-medium search-query">
        <button type="submit" class="btn">搜索</button>
</form>
-->
<div class="pull-left"><b>内容管理--宝贝批量发布</b></div>
</div>
	
<div class="tablebox">
	<form action="<?php echo site_url("admin/item_multi_post");?>" method="POST">
	<table class="table table-striped table-bordered table-condensed"><thead><tr><td><b>商品搜索:</b>&nbsp;&nbsp;<input type="text" name="keyword" value="<?php if($keyword){echo $keyword;}else{ ?>输入要搜索的关键词<?php } ?>" style="color:#ccc;"/><input type="hidden" name="hide_val" value="1"/>&nbsp;&nbsp;<select  name="category"><option value="0">全部分类</option><?php foreach ($categories as $category){ ?><option value="<?php echo $category->cid; ?>"><?php echo $category->name;?></option><?php } ?></select>&nbsp;&nbsp;<input type="submit" style="width:50px" class="btn btn-info" name="search" id="save" value="搜索"/></td></tr></thead></table>
		<input type="hidden" name="channel" value="taobao"/>
	</form>
	<?php if ($product_infos) {?>
	<form id="post_multi_items_form" method="POST" action="<?php echo site_url('admin/post_multi_items')?>" onsubmit="return false;">
	<table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th>商品推广信息</th>
            <th>选择</th>
            <th>单价:</th>
            <th>佣金比率：</th>
            <th>佣金:</th>
            <th>30天推广量:</th>
            <th>30天推出佣金:</th>
          </tr>
        </thead>
        <tbody> 
        <?php foreach ($product_infos as $item){?>
          <tr class="rows">
          	<td>
          		<p style="width:300px;">
          			<img src="<?php echo $item->pic_url.'_100x100.jpg'; ?>" width="80" height="80" style="float:left;margin-right:5px;"/>
          			<input type="hidden" name="item[<?php echo $item->num_iid; ?>][images][]" value="<?php echo $item->pic_url; ?>" />
          			
          			<span id="item_<?php echo $item->num_iid; ?>_title_span"><?php echo $item->title; ?></span>
          			<input type="hidden" id="item_<?php echo $item->num_iid; ?>_title" name="item[<?php echo $item->num_iid; ?>][title]" value="<?php echo $item -> title; ?>" />
          			
          			<br /><span style="color:#950">掌柜的:<?php echo $item->nick; ?></span>
          			<br /><a href="<?php echo $item->click_url; ?>" target="_blank">店铺推广详情</a>
          			<br /><input type="button" name="edit_item" value="编辑" onclick="show_edit('<?php echo $item->num_iid; ?>')"/>
          			<br />
          			
          			<?php if(count($item -> item_imgs) > 0): foreach ($item -> item_imgs as $img):
          				if ($item->pic_url == $img) {
          					continue;
          				}
          			?>
          			<img src="<?php echo $img.'_40x40.jpg'; ?>" style="float:left;margin-right:5px;"/>
          			<input type="hidden" name="item[<?php echo $item->num_iid; ?>][images][]" value="<?php echo $img; ?>" />
          			<?php endforeach;endif;?>
          			
          		</p>
          	
          	</td>
          	<td><input type="checkbox" name="item_select[]" value="<?php echo $item->num_iid; ?>"/></td>
          	<td><?php echo $item->price;?>元</td>
          	<td><?php echo round(($item->commission_rate/100),2); ?>%</td><td><?php echo $item->commission; ?>元</td>
          	<td><?php echo $item->commission_num; ?>件</td><td><?php echo $item->commission_volume; ?>元</td>
          	<input type="hidden" name="item[<?php echo $item->num_iid; ?>][num_iid]" value="<?php echo $item->num_iid;?>"/>
          	<input type="hidden" name="item[<?php echo $item->num_iid; ?>][price]" value="<?php echo $item->price; ?>" />
          	<input type="hidden" name="item[<?php echo $item->num_iid; ?>][reference_url]" value="<?php echo $item->click_url; ?>" />
          	<input type="hidden" name="item[<?php echo $item->num_iid; ?>][promotion_url]" value="<?php echo $item->click_url; ?>" />
          	</tr>
          <?php }?>
        </tbody>
      </table>
      <div style="width:100%;height:30px;"><div style="width:55%;height:30px;float:left;text-align:right;position:relative;"><input type="button" name="change_items"" onclick="window.location='<?php echo $click_url; ?>'" value="更换一组商品"/></div><div style="width:30%px;height:30px;float:right;">&nbsp;&nbsp;发布至专辑：<select name="album_name" id="album_name"><?php foreach ($albums as $album){ ?><option value="<?php echo $album->album_id; ?>"><?php echo $album->title; ?></option><?php } ?></select>&nbsp;&nbsp;&nbsp;<input type="button" style="width:50px;" name="select_all" value="全选"/>&nbsp;&nbsp;<input type="button" style="width:60px;" name="post_item" value="发布"/></div></div>
		<?php }else{?>
		<div style="width:800px;height:50px;border:1px solid #eee;line-height:50px;text-align:center;color:#666;font-weight:bold;position:absolute;left:30%;top:50%;margin-left:-200px;background:#FFFDC3;"><img src="<?php echo base_url('themes/admin/images/smile.png'); ?>" style="position:relative;top:10px;"/>跟据商品关键词、分类，可实时查询淘宝客分销联盟商品，直接采集至站点内。(请务必配置淘宝客APP Key以及 APP Secret) </div>
		<?php }?>
      </form>
	
</div>
<script>
	$(function(){
		$("input[name=post_item]").click(function(){
		var loading=base_url+"assets/img/loading.gif";
		var config={
		title:'系统通知',
		width:300,
		height:100,
		ok:function(){},
		cancel:function(){},
		lock:true,
		show:true,
		opacity:0.2,
		ok:function(){
			//alert('提交');
			$("#infomation").html("请稍等，系统正在处理数据，可能需要几分钟时间！");
			
			var options = {
				dataType:'json',
			    success: function(res) {
					if(res.result == 0){
						dialog.close();
						art.dialog({title:'信息提示',content:'您还未选择任何商品!',time:2000,width:180,height:70});
					}else if(res.result == 1){
						dialog.close();
						art.dialog({title:'信息提示',content:'发布商品成功!',time:2000,width:180,height:70});
					}else{
						alert('未知错误，请检查您的服务器');
					}
			    }
			};
			
			$('#post_multi_items_form').ajaxSubmit(options);
				
			return false;
		
		},
		content:'<div><img id="loading" src="'+loading+'" no-repeat left top;margin-right:30px;"/>&nbsp;&nbsp;&nbsp;<span id="infomation" style="font-size:14px;color:#060;">您确定要分享商品吗?.</span></div>'
	};
		var dialog= art.dialog(config);
		//post_items(dialog);
		});
		$("input[name=keyword]").focus(function(){
			if($(this).val()=="输入要搜索的关键词"){
			$(this).val('');
			$(this).css("color",'#050');
			}
		}).blur(function(){
			if($(this).val()==''){
			$(this).val("输入要搜索的关键词");
			$(this).css("color",'#ccc');
			}else{
				$(this).css("color",'#050');
			}
		});
		$("input[name=select_all]").click(function(){
			$(":checkbox").attr("checked","checked");
		});
		$("#save").click(function(){
			if($("input[name=keyword]").val()=="输入要搜索的关键词"){
				$("input[name=keyword]").val('');
			}
		});
	});
</script>
</body>
</html>