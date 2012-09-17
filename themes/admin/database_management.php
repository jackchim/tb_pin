<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="<?php echo base_url('themes/admin/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url('themes/admin/css/admin.css'); ?>" type="text/css" rel="stylesheet" />
<script src="<?php echo base_url('assets/js/jquery-1.7.2.min.js')?>" type="text/javascript"></script>
<title>后台登录界面</title>
</head>

<body>
<div class="tablebox_header">   
<form action="<?php echo site_url('admin/database_backup');?>" method="post" class=" form-search pull-right">
        <button type="submit" class="btn">点击备份数据库</button>
</form>
</div>
<div class="tablebox">
   <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th>ID</th>
            <th>文件名</th>
            <th>文件大小</th>
            <th>创建时间</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
        <?php if($file_list):?>
        <?php foreach ($file_list as $key=>$value):?>
        <?php $i++;?>
          <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $value['name'];?></td>
            <td><?php echo ($value['size']/1024).K;?></td>
            <td><?php echo date('Y-d-m',$value['date']);?></td>
            <td><a href="<?php echo site_url('admin/database_download/'.$value['name']);?>">下载</a>
            </td>
          </tr>
        <?php endforeach;?>
        <?php endif;?>
        </tbody>
      </table>

</div>

</body>
</html>