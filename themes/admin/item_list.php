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
<script>
var site_url = '<?php echo (strpos(site_url(),'index.php') === false) ?site_url():site_url().'/';?>';
var base_url = '<?php echo base_url();?>';
</script>
<script>
$(function(){
	$(".delete_share").click(function(){
		var target=$(this);
		art.dialog({title:'消息提示',content:"您确定删除该分享吗？",ok:function(){
			window.location.href=target.attr("url");
			return true;
		},cancel:function(){},okValue:'确定',cancelValue:'取消'});
		return false;
	});
});

</script>
<title>后台登录界面</title>
</head>

<body>
<div class="tablebox_header">   
<form action="<?php echo site_url('admin/item_list/search');?>" method="get" class=" form-search pull-right">
        <input type="text" name="keyword" class="input-medium search-query">
        <button type="submit" class="btn">搜索</button>
</form>
<div class="pull-left"><a href="<?php echo site_url('admin/item_list');?>">全部</a>  <a href="<?php echo site_url('admin/item_list/search?is_show=0');?>">未审核</a></div>
</div>
<div class="tablebox">
   <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th>ID</th>
            <th>缩略图</th>
            <th>标题</th>
            <th>描述</th>
            <th>时间</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item):?>
          <tr class="rows" id="share_<?php echo $item->item_id; ?>">
            <td><?php if($is_show): ?><input type="checkbox" name="verify_share" value="<?php echo $item->item_id; ?>"/><?php  endif;?><?php echo $item->item_id;?></td>
            <td><img src="<?php echo get_item_first_image($item->image_path , 'square');?>" width="50"/></td>
            <td><p style="word-wrap: break-word; width:350px;"><?php echo $item->title;?></p></td>
            <td><p style="word-wrap: break-word; width:350px;"><?php echo $item->intro;?></p></td>
            <td><?php echo $item->create_time;?></td>
            <td>
             <?php if($item->is_show==1):?>
            	已通过
            <?php elseif ($item->is_show==2):?>
            	屏蔽
            	<?php else:?>
            	未审核
            <?php endif;?>
            </td>
            <td><a url="<?php echo site_url('admin/item_list/delete/'.$item->item_id);?>" class="delete_share" href="javascript:void(0)">删除</a>
            <?php if($item->is_show==0):?>
            <a href="<?php echo site_url('admin/item_list/deverify/'.$item->item_id);?>">屏蔽</a>
            <a href="<?php echo site_url('admin/item_list/verify/'.$item->item_id);?>">审核</a>
            <?php elseif($item->is_show==1):?>
            <a href="<?php echo site_url('admin/item_list/deverify/'.$item->item_id);?>">屏蔽</a>
            <?php else:?>
            <a href="<?php echo site_url('admin/item_list/verify/'.$item->item_id);?>">审核</a>
            <?php endif;?>
            </td>
          </tr>
        <?php endforeach;?>
        </tbody>
      </table>
      <?php if($is_show):?>
      <div>&nbsp;&nbsp;<input type="button" onclick="select_all('verify_share')" value="全选" name="chekall">&nbsp;&nbsp;<input type="button" name="forone_verify" value="一键审核" onclick="do_share_verify(1)">&nbsp;&nbsp;<input type="button" name="forone_forbid" onclick="do_share_verify(2)" value="一键屏蔽"></div>
      <?php endif; ?>
      <?php echo $pages;?>
			
</div>
</body>
</html>