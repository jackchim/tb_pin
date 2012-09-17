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
		art.dialog({title:'消息提示',content:"您确定删除该友情链接吗？",ok:function(){
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
            <th>链接名称</th>
            <th>链接地址</th>
            <th>打开方式</th>
            <th>显示排序</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
        <?php if (count($list) > 0): foreach ($list as $vo):?>
          <tr>
            <td><?php echo $vo -> id;?></td>
            <td><?php echo $vo -> link_title;?></td>
            <td><?php echo $vo -> link_url;?></td>
            <td><?php if($vo -> link_target == '_blank') echo '新窗口';else echo '当前窗口';?></td>
            <td><?php echo $vo -> display_order;?></td>
            <td>
           		<a href="<?php echo site_url('admin/friendlink?op=edit&id='.$vo -> id);?>">编辑</a>
           		<a  href="javascript:void(0)" url="<?php echo site_url('admin/friendlink?op=del&id='.$vo -> id);?>" class="delete_category">删除</a>
            </td>
          </tr>
        <?php endforeach;endif;?>
        </tbody>
      </table>

</div>

<div class="tablebox_footer">
   <form action="<?php echo site_url('admin/friendlink?op=add');?>" method="post" class="form-horizontal">
   <fieldset>
   
   <div class="control-group">
      <label class="control-label" for="input01">链接名称</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="link_title" name="link_title" value="" style="color:#999"/><span style="color:#ff4444;display:none;">&nbsp;*链接名称不能为空</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="input01">链接地址</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="link_url" name="link_url" value="http://" style="color:#999"/><span style="color:#ff4444;display:none;">&nbsp;*链接地址不能为空</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="input01">打开方式</label>
      <div class="controls">
        <label><input type="radio" name="link_target" value="_blank"  checked/>新窗口</label>
        <label><input type="radio" name="link_target" value="_self" />当前窗口</label>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="input01">显示排序</label>
      <div class="controls">
        <input type="text" class="input-small" id="display_order" name="display_order" value="255" style="color:#999"/>
      </div>
    </div>
    <div class="form-actions">
  <button type="submit" class="btn btn-info" id="catogary_submit">添加</button>
  <input type="hidden" name="action" value="submit" />
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