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
<div class="tablebox_footer">
   <form action="<?php echo site_url('admin/tag_list/edit/'.$tag->tag_id);?>" method="post" class="form-horizontal">
   <fieldset>
   
   <div class="control-group">
      <label class="control-label" for="input01">标签组名称</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="tag_group_name_cn" name="tag_group_name_cn" value="<?php echo $tag->tag_group_name_cn;?>"/>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="input01">标签组英文名称</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="tag_group_name_en" name="tag_group_name_en" value="<?php echo $tag->tag_group_name_en;?>" />
      </div>
    </div>
    
    <div class="control-group">
      <label class="control-label" for="input01">标签组分类</label>
      <div class="controls">
        <select id="category_id" name="category_id">
            <?php if($categories):?>
            <?php foreach ($categories as $category):?>
              <option value="<?php echo $category->category_id;?>" <?php echo ($category->category_id==$tag->category_id)?'selected':'';?>><?php echo $category->category_name_cn;?></option>
            <?php endforeach;?>
            <?php endif;?>
            </select>
      </div>
    </div>
    
    <div class="control-group">
      <label class="control-label" for="input01">标签内容</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="tags" name="tags"  value="<?php echo $tag->tags;?>"/>
      </div>
    </div>
    
    <div class="control-group">
      <label class="control-label" for="input01">显示顺序</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="display_order" name="display_order"  value="<?php echo $tag->display_order;?>"/>
      </div>
    </div>

    <div class="form-actions">
  <button type="submit" class="btn btn-info">保存</button>
  </div>
  </fieldset>
</form>
</div>
</body>
</html>