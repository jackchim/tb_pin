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
</div>
	
<div class="tablebox">
	
	<form id="post_multi_items_form" method="POST" action="<?php echo site_url('admin/post_multi_items')?>" onsubmit="return false;">
	<table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th>缩略图</th>
            <th>描述</th>
            <th>时间</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody> 
        <?php if (is_array($items)):foreach ($items as $item):?>
          <tr class="rows" id="item_<?php echo $item -> item_id;?>">
          	<td>
          		<p>
          			<?php 
          			$imgs = unserialize($item -> image_path);
          			if(count($imgs) > 0): foreach ($imgs as $img):
          			?>
          			<img src="<?php echo $img.'_40x40.jpg'; ?>" style="float:left;margin-right:5px;"/>
          			<input type="hidden" name="item[<?php echo $item->num_iid; ?>][images][]" value="<?php echo $img; ?>" />
          			<?php endforeach;endif;?>
          			
          		</p>
          	
          	</td>
          	<td><p><?php echo $item -> intro;?></p></td>
          	<td><?php echo $item -> create_time;?></td>
          	<td><a href="javascript:;" onclick="to_local(<?php echo $item -> item_id;?>)">本地化</a></td>
          	</tr>
          <?php endforeach;endif;?>
        </tbody>
      </table>
      <p class="pagination">
      <?php echo $pages;?>
      </p>
	
</div>
<script>
function to_local(item_id){
	var loading=base_url+"assets/img/loading.gif";
	var config = {
		title:'系统通知',
		width:300,
		height:100,
		okValue:'开始本地化',
		ok:function(){
			dialog.close();
			var dialog2 = art.dialog({title:'系统通知',content:'<div><img id="loading" src="'+loading+'" no-repeat left top;margin-right:30px;"/>&nbsp;&nbsp;&nbsp;正在处理，请稍后...!',width:300,height:100,lock:true,show:true});
			
			$.post("<?php echo site_url('admin/images_to_local');?>", {item_id: item_id },function(res){
				dialog2.content(res.msg);
				$('#item_'+item_id).remove();
			} ,'json');
			return false;
		},
		lock:true,
		show:true,
		opacity:0.2,
		content:'图片本地化后将占一定的服务器存储空间，请确保您的服务器存储空间充足'
	};
	var dialog= art.dialog(config);
}
</script>
</body>
</html>