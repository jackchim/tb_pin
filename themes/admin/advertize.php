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
<script>
var jq=jQuery.noConflict();//交出jquery的$控制权
</script>
<link id="artDialog-skin" href="<?php echo base_url('assets/js/dialog/skins/default.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url('assets/js/dialog/artDialog_default.js'); ?>" type="text/javascript"></script>
<title>后台登录界面</title>
</head>
<body>
<!--tablebox start!-->
<?php  if(!empty($advs)){?>
<div class="tablebox">
   <table class="table table-striped table-bordered table-condensed">
        <thead>
          <tr>
            <th>ad_title</th>
            <th>ad_photo</th>
            <th>ad_url</th>
            <th>焦点图显示顺序</th>
            <th>ad_position</th>
          </tr>
        </thead>
        <tbody>
       	<!--loop start-->
       	
       		<?php foreach ($advs as $val):?>
          <tr id="<?php echo $val->ad_id;?>">
            <td><?php echo $val->ad_title?></td>
            <td><?php echo $val->ad_photo;?></td>
            <td><?php echo $val->ad_url;?></td>
            <td><?php echo $val->display_order ?></td>
            <td><?php echo $val->ad_position; ?></td>
            <td>
            	<?php if (!$item->is_system):?>
            <a url="<?php echo site_url('admin/adinfo/delete/'.$val->ad_id);?>" href="javascript:void(0)" pid="<?php echo $val->ad_id;?>" class="delete_adv">删除</a>
            <?php endif;?>
           		<a href="<?php echo site_url('admin/adinfo/edit/'.$val->ad_id);?>">编辑</a>
           		<a href="javascript:void(0)" class="move_it" type="top" ad_id="<?php echo $val->ad_id; ?>">上移</a>&nbsp;/&nbsp;<a class="move_it" type="bottom" ad_id="<?php echo $val->ad_id; ?>" href="javascript:void(0)">下移</a>
            </td>
          </tr>
             <?php endforeach;?>
       <!--loop end-->
        </tbody>
      </table>
</div>
<?php } ?>
<!-- tablebox end!-->
<div class="tablebox_footer">
   <form action="<?php echo site_url('admin/advertize/add');?>" method="post" enctype="multipart/form-data" class="form-horizontal">
   <fieldset>
   <div class="control-group">
      <label class="control-label" for="input01">广告标题</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="ad_title" name="ad_title" />&nbsp;&nbsp;<span class="hideText" id="adtitle">*广告标题内容不能为空</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="input01">广告URL地址</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="ad_url" name="ad_url" />&nbsp;&nbsp;<span id="adurl" class="hideText">*广告URL不能为空</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="input01">广告位置</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="ad_position" name="ad_position" />&nbsp;&nbsp;<span id="adposition" class="hideText">* 广告位不能为空</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="input01">显示顺序</label>
      <div class="controls">
        <input type="text" class="input-xlarge" id="display_order" name="display_order" value="0"/><span>&nbsp;(该顺序必须是数字，数字越大越靠前)</span>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="input01">上传广告图片</label>
      <div class="controls" style="position:relative;">
        <input type="button" class="btn btn-info"  value="选择文件"/><input type="file" style="cursor:pointer;filter:Alpha(Opacity=0);opacity:0.0;width:10px;position:absolute;left:-10px;" size="1" id="adfile" name="adfile"/>&nbsp;&nbsp;&nbsp;&nbsp;<span id="adfiles" class="hideText">*未选择文件 请选择上传620*218尺寸的广告图</span>
      </div>
    </div>

    <div class="form-actions">
  <button type="submit" class="btn btn-info" id="save">保存</button>
  </div>
  </fieldset>
</form>
</div>
<script>
jq(function(){
	jq(".delete_adv").click(function(){
		var url=this.getAttribute("url");
		var pid=this.getAttribute("pid");
		art.dialog({title:'消息提示',content:"您确定删除该广告吗？",ok:function(){
			jq.post(url,{},function(msg){
			if(msg==1){
				art.dialog({title:"消息提示",content:"删除成功！",time:1500});
				jq("#"+pid).hide('slow');
			}else{
				art.dialog({title:"消息提示",content:"删除失败！",time:1500});
			}
			
		});
			return true;
		},cancel:function(){},okValue:'确定',cancelValue:'取消'});
		
	});
	jq(".move_it").click(function(){
		var type=jq(this).attr("type");//类型，top是上移，botton下移
		var ad_id=jq(this).attr("ad_id");//广告id
		var url="<?php echo site_url('admin/move_adv');?>";//移动处理
		var pre_sib=jq(this).parent().parent().prev('tr');//上一个元素
		var cur_ele=jq(this).parent().parent();//当前元素
		var next_sib=jq(this).parent().parent().next('tr');//下一个元素
		var pre_id=pre_sib.attr('id');
		var next_id=next_sib.attr('id');
		var data={cur_id:ad_id,pre_id:pre_id,next_id:next_id,type:type};
		if(type=='top'){
			if(!pre_sib.get(0)){
			return;
			}
				jq.post(url,data,function(msg){
					if(msg==1)
					pre_sib.before(cur_ele);
				});
		}else if(type=='bottom'){
			if(!next_sib.get(0)){
				return;
			}
			jq.post(url,data,function(msg){
				next_sib.after(cur_ele);
			});	
		}
	});
	(function(){
	//广告类
	function Advertize(){
		this.save=document.getElementById("save");
		this.init=function(){
			jq(this.save).click(function(){
				var error=new Array();
				var succeed=new Array();
				var title=jq.trim(jq("#ad_title").val());//ad标题
				var ad_url=jq.trim(jq("#ad_url").val());
				var ad_pos=jq.trim(jq("#ad_position").val());
				var adfile=jq.trim(jq("#adfile").val());
				if(title.length==0){
					error.push("adtitle");
				}else{
					succeed.push("adtitle");
				}
				if(ad_url.length==0)
				{
					error.push("adurl");
				}else{
					succeed.push("adurl");
				}
				if(ad_pos.length==0)
				{
					error.push("adposition");
				}else{
					succeed.push("adposition");
				}
				if(adfile.length==0)
				{	
					error.push("adfiles");
				}else{
					succeed.push("adfiles");
				}
				if(succeed.length>0){
					for(var pos in succeed){
						jq("#"+succeed[pos]).hide();	
					}
				}
				if(error.length>0){
					for(var index in error){
						jq("#"+error[index]).show();
						return false;
					}
					return false;
				}
				return true;		
			});
		}
	}
	new Advertize().init();
	
})()	
})

</script>
</body>
</html>