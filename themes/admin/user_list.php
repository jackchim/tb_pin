<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="<?php echo base_url('themes/admin/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url('themes/admin/css/admin.css'); ?>" type="text/css" rel="stylesheet" />
<script>
var site_url = '<?php echo (strpos(site_url(),'index.php') === false) ?site_url():site_url().'/';?>';
var base_url = '<?php echo base_url();?>';
</script>
<script src="<?php echo base_url('assets/js/jquery-1.7.2.min.js')?>" type="text/javascript"></script>
<link id="artDialog-skin" href="<?php echo base_url('assets/js/dialog/skins/default.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/js/dialog/artDialog_default.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('themes/admin/js/global.admin.js') ?>"></script>
<title>后台登录界面</title>
</head>

<body>
<div class="tablebox_header">   
<form action="<?php echo site_url('admin/user_list/search');?>" method="get" class=" form-search pull-right">
        <input type="text" name="nickname" class="input-medium search-query">
        <button type="submit" class="btn">搜索</button>
</form>
<div class="pull-left"><a href="<?php echo site_url('admin/user_list');?>">全部</a><!--<a href="<?php echo site_url('admin/user_list/search?is_active=0');?>">未审核</a>--></div>
</div>
<div class="tablebox">
   <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th>ID</th>
            <th>登录名</th>
            <th>昵称</th>
            <th>类型</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $u):?>
          <tr>
            <td><?php echo $u->user_id;?></td>
            <td><?php echo $u->email;?></td>
            <td><?php echo $u->nickname;?></td>
            <td><?php 
            switch ($u->user_type) {
            	case 1:
            	echo '普通用户';
            	break;
            	case 2:
            	echo '网站编辑';
            	break;
            	case 3:
            	echo '高级管理员';
            	break;
            }
            ?></td>
            <td><a href="<?php echo site_url('admin/user_list/edit/'.$u->user_id);?>">修改</a> <!--<a href="<?php echo site_url('admin/user_list/delete/'.$u->user_id);?>">删除</a>--><?php if($u->user_type!=3): ?> <span id="forb_<?php echo $u->user_id;?>"><?php if($u->is_forbidden==1){ ?>屏蔽48小时<?php }elseif($u->is_forbidden==2){?>永久屏蔽<?php }else{?><a href="javascript:void(0)" onclick="forbidden('<?php echo $u->user_id; ?>','<?php echo $u->nickname; ?>',this)">屏蔽</a><?php }?><span><?php endif; ?></td>
          </tr>
        <?php endforeach;?>
        </tbody>
      </table>
      <?php echo $pages;?>

</div>

</body>
</html>