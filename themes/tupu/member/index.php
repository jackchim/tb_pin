

<!-- 瀑布流容器 -->
<div id="container_walterfall" class="clearfix" layout="auto">
<!-- 标签组 -->
<?php echo $tpl_member_slide; //模版：common/slide.php ?>
<!-- /标签组 -->
<!-- 动态图格区域 -->
<?php echo $tpl_waterfall; //模版：common/waterfall.php ?>
<!-- /动态图格区域 -->
</div>
<!-- /瀑布流容器 -->

<!--<div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div> -->

<!-- 瀑布流分页 -->
<div id="page-nav" class="load" class="clearfix">
	<a href="<?php echo site_url('member/index/2'); ?>">
	</a>
</div>
<!-- /瀑布流分页 -->
<?php if ($is_friend_recommend == 0) {?>
<script type="text/javascript">
$.get("<?php echo site_url('member/friend_recommend');?>", function(tpl){
	//$("div").html(result);
	var dialog = art.dialog({title:'您还没有关注任何人，我们推荐您关注',fixed:true,lock:true,content:tpl,id: 'friend_recommend_dialog'});
});
</script>
<?php }?>