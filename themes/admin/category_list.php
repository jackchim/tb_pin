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
	var jq=jQuery.noConflict();
</script>
<script>
jq(function(){
	jq(".delete_category").click(function(){
		var target=jq(this);
		art.dialog({title:'消息提示',content:"您确定删除该分类吗？",ok:function(){
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
<div class="tablebox">
   <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th>ID</th>
            <th>分类名称</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $item):?>
          <tr>
            <td><?php echo $item->category_id;?></td>
            <td><?php echo $item->category_name_cn;?></td>
            <td>
            	<?php if (!$item->is_system):?>
            <a  href="javascript:void(0)" url="<?php echo site_url('admin/category_list/delete/'.$item->category_id);?>" class="delete_category">删除</a>
            <?php endif;?>
           		<a href="<?php echo site_url('admin/category_list/edit/'.$item->category_id);?>">编辑</a>
            </td>
          </tr>
        <?php endforeach;?>
        </tbody>
      </table>

</div>

<div class="tablebox_footer">
   <form action="<?php echo site_url('admin/category_list/add');?>" method="post" class="form-horizontal">
   <fieldset>
   
   <div class="control-group">
      <label class="control-label" for="input01">分类名称</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="category_name_cn" name="category_name_cn" value="输入分类名称，支持中英文.." style="color:#999"/><span id="show_noty" style="color:#ff4444;display:none;">&nbsp;*分类名称不能为空</span>
      </div>
    </div>
    <div class="form-actions">
  <button type="submit" class="btn btn-info" id="catogary_submit">保存</button>
  </div>
  </fieldset>
</form>
</div>
<script>
	jq(function(){
		var category_name_input=jq("#category_name_cn");
		var options={
			noty_word:'输入分类名称，支持中英文..',
		    word_css:category_name_input.css("color")
		};
		category_name_input.focus(function(){
			if(jq(this).val()==options.noty_word){
				jq(this).val('');
				jq(this).css('color','');
			}
		}).blur(function(){
			if(jq(this).val()==''){
				jq(this).val(options.noty_word);
				jq(this).css('color',options.word_css);
			}
		});
		var catogary_submit=jq("#catogary_submit");
		var show_noty=jq("#show_noty");
		catogary_submit.click(function(){
			if(category_name_input.val()==''||category_name_input.val()==options.noty_word){
			    show_noty.show();
				return false;
			
			}
			return true;
		});
	});
</script>
</body>
</html>