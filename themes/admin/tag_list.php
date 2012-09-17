<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<link href="<?php echo base_url('themes/admin/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo base_url('themes/admin/css/admin.css'); ?>" type="text/css" rel="stylesheet" />
<link id="artDialog-skin" href="<?php echo base_url('assets/js/dialog/skins/default.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/js/jquery-1.7.2.min.js')?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/js/dialog/artDialog_default.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('themes/admin/js/global.admin.js') ?>"></script>
<script>
	var jq=jQuery.noConflict();
</script>
<script>
jq(function(){
	jq(".delete_tag").click(function(){
		var target=jq(this);
		art.dialog({title:'消息提示',content:"您确定删除该标签吗？",ok:function(){
			window.location.href=target.attr("url");
			return true;
		},cancel:function(){},okValue:'确定',cancelValue:'取消'});
		return false;
	});
});

</script>
<style type="text/css">
	.show_word{
		color:#ff4444;
	}
</style>
<title>后台登录界面</title>
</head>

<body>
<div class="tablebox">
   <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th>ID</th>
            <th>所在分类</th>
            <th>标签组中文</th>
            <th>标签</th>
            <th>显示顺序</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item):?>
          <tr>
            <td><?php echo $item->tag_id;?></td>
            <td><?php echo $item->category_name_cn;?></td>
            <td><?php echo $item->tag_group_name_cn;?></td>
            <td><?php echo $item->tags;?></td>
            <td><?php echo $item->display_order;?></td>
            <td><a href="javascript:void(0)" url="<?php echo site_url('admin/tag_list/delete/'.$item->tag_id);?>" class="delete_tag">删除</a>
           		<a href="<?php echo site_url('admin/tag_list/edit/'.$item->tag_id);?>">编辑</a>
            </td>
          </tr>
        <?php endforeach;?>
        </tbody>
      </table>
      <?php echo $pages;?>

</div>

<div class="tablebox_footer">
   <form action="<?php echo site_url('admin/tag_list/add');?>" method="post" class="form-horizontal">
   <fieldset>
   
   <div class="control-group">
      <label class="control-label" for="input01">标签组名称</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="tag_group_name_cn" name="tag_group_name_cn" value="输入标签组名称，支持中英文..."/><span  class="tag_group_name_cn show_word" style="display:none;">*标签组名称不能为空</span>
      </div>
    </div>
    <!--
    <div class="control-group">
      <label class="control-label" for="input01">标签组英文名称</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="tag_group_name_en" name="tag_group_name_en" />
      </div>
    </div>
    -->
    <div class="control-group">
      <label class="control-label" for="input01">标签组分类</label>
      <div class="controls">
        <select id="category_id" name="category_id">
            <?php if($categories):?>
            <?php foreach ($categories as $category):?>
              <option value="<?php echo $category->category_id;?>"><?php echo $category->category_name_cn;?></option>
            <?php endforeach;?>
            <?php endif;?>
            </select>
      </div>
    </div>
    
    <div class="control-group">
      <label class="control-label" for="input01">标签内容</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="tags" name="tags" />(请用英文半角逗号分隔)<span style="display:none;" class="show_word tags">*标签内容不能为空</span>
      </div>
    </div>
    
    <div class="control-group">
      <label class="control-label" for="input01">显示顺序</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="display_order" name="display_order" value="100"/>
      </div>
    </div>
    <div class="form-actions">
  <button type="submit" class="btn btn-info" id="save">保存</button>
  </div>
  </fieldset>
</form>
</div>
<script>
(function($){
		var check_key={
			save_button_id:'save',
			tag_group:$('#tag_group_name_cn'),
			show_word:'输入标签组名称，支持中英文...',
			tag_content:$("#tags")
		};
		var save_button=$("#"+check_key.save_button_id);
		check_key.tag_group.focus(function(){
			if($(this).val()==check_key.show_word){
				$(this).val('');
			}
		}).blur(function(){
			if($(this).val()==''){
				$(this).val(check_key.show_word);
			}
		});
		save_button.click(function(){
			if(check_key.tag_group.val()==''||check_key.tag_group.val()==check_key.show_word){
				$('.tag_group_name_cn').show();
				return false;
			}else{
				$('.tag_group_name_cn').hide();
			}
			if(check_key.tag_content.val()==''){
				$(".tags").show();
				return false;
				
			}else{
				$(".tags").hide();
			}
			return true;
			
		});
	
})(jQuery);
</script>
</body>
</html>