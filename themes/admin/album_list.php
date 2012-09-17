<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="<?php echo base_url('themes/admin/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url('themes/admin/css/admin.css'); ?>" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url('assets/js/jquery-1.7.2.min.js')?>" type="text/javascript"></script>
<script>
var site_url = '<?php echo (strpos(site_url(),'index.php') === false) ?site_url():site_url().'/';?>';
var base_url = '<?php echo base_url();?>';
</script>
<link id="artDialog-skin" href="<?php echo base_url('assets/js/dialog/skins/default.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/js/dialog/artDialog_default.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('themes/admin/js/global.admin.js') ?>"></script>
<title>内容管理-专辑管理</title>
</head>
<body>
<div class="tablebox_header">   
<form action="<?php echo site_url('admin/album_list/searchs');?>" method="get" class=" form-search pull-right">
        <input type="text" name="keyword" class="input-medium search-query">
        <button type="submit" class="btn">搜索</button>
</form>
<div class="pull-left"><a href="<?php echo site_url('admin/album_list');?>">全部</a>  <a href="<?php echo site_url('admin/album_list/search?is_show=0');?>">未审核</a></div>
</div>
<div class="tablebox">
   <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th>ID</th>
            <th>专辑名称</th>
            <th>专辑发布者昵称</th>
            <th>发布时间</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($albums as $album):?>
          <tr  class="rows"  id="album_<?php echo $album->album_id;?>">
            <td><?php if($search){ ?><input type="checkbox" name="verify" value="<?php echo $album->album_id; ?>" /><?php }?><?php echo $album->album_id;?></td>
            <td><?php echo $album->title;?></td>
            <td><?php echo $album->nickname;?></td>
            <td><?php echo $album->create_time;?></td>
            <td id="status_<?php echo $album->album_id;?>">
             <?php if($album->is_show==1):?>
            	已通过
            <?php elseif ($album->is_show==2):?>
            	屏蔽
            	<?php else:?>
            	未审核
            <?php endif;?>
            </td>
            <td><?php if($album->is_system!=1): ?><a  href="javascript:void(0)" onclick="album_delete('<?php echo $album->album_id; ?>')">删除</a><?php endif; ?>
            <span id="operation_<?php echo $album->album_id; ?>"><?php if($album->is_show==0):?>
            <a href="javascript:void(0)" onclick="verify('<?php echo $album->album_id;?>',2)">屏蔽</a>
            <a href="javascript:void(0)" onclick="verify('<?php echo $album->album_id;  ?>',1)">审核</a>
            <?php elseif($album->is_show==1):?>
            <a href="javascript:void(0)" onclick="verify('<?php echo $album->album_id;?>',2)">屏蔽</a>
            <?php else:?>
            <a href="javascript:void(0)" onclick="verify('<?php echo $album->album_id;?>',1)">审核</a>
            <?php endif;?>
            </span>
            </td>
          </tr>
        <?php endforeach;?>
        </tbody>
      </table>
      <?php if($search){?><div>&nbsp;&nbsp;<input type="button" name="chekall" value="全选" onclick="select_all('verify')"/>&nbsp;&nbsp;<input type="button" onclick="do_verify(1)" value="一键审核" name="forone_verify"/>&nbsp;&nbsp;<input type="button" value="一键屏蔽" onclick="do_verify(2)" name="forone_forbid"/></div><?php }?>
      <?php echo $pages;?>
</div>
</body>
</html>