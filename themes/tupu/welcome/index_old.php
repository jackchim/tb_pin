<!-- 头部分类图片 
<div class="category_add"><a href="javascript:void(0)" id="slide_toggle" onclick="slide_toggle()"><img src="<?php echo $theme_url;?>/images/icon/add.png" width="36" height="36" id="slide_img" /></a></div> -->
<!-- <div id="hidden_toggle" style="display:none;">
<div class="category"> 分类按钮 
    <div class="category_nav"><a href="#"><img src="<?php echo $theme_url;?>/images/demo/cate_03.jpg" /></a><span class="category_title">服饰</span></div>
    <div class="category_nav"><a href="#"><img src="<?php echo $theme_url;?>/images/demo/cate_08.jpg" /></a><span class="category_title">美容护肤</span></div>
    <div class="category_nav"><a href="#"><img src="<?php echo $theme_url;?>/images/demo/cate_05.jpg" /></a><span class="category_title">美女</span></div>
    <div class="category_nav"><a href="#"><img src="<?php echo $theme_url;?>/images/demo/cate_10.jpg" /></a><span class="category_title">小饰品</span></div>
    <div class="category_nav"><a href="#"><img src="<?php echo $theme_url;?>/images/demo/cate_09.jpg" /></a><span class="category_title">家居</span></div>
    <div class="category_nav"><a href="#"><img src="<?php echo $theme_url;?>/images/demo/cate_16.jpg" /></a><span class="category_title">裙装</span></div>
    <div class="category_nav"><a href="#"><img src="<?php echo $theme_url;?>/images/demo/cate_15.jpg" /></a><span class="category_title">沙发</span></div>
    <div class="category_nav"><a href="#"><img src="<?php echo $theme_url;?>/images/demo/cate_07.jpg" /></a><span class="category_title">数码产品</span></div>
</div>
<div class="category-bottomline"></div>
</div>-->
<!-- 头部分类图片结束 -->

<!-- 首页轮番图 -->
<!--<div class="index_turn_outer">
	<div class="index_turn"><a href="#"><img src="http://s2.img.guang.com/topic/142/142_1_1860924137285_960X270.jpg" width="970" height="270"/></a></div>
</div>-->
<!-- /首页轮番图 -->

<!--瀑布交流标题-->
<!--<div class="pin_title_outer">
	<ul>
     <li class="pin_hot"><a href="<?php echo site_url('welcome/popular');?>">热门图谱</a></li>
  	 <li class="cgray"><img src="<?php echo $theme_url;?>/images/d_line.jpg" /></li>
  	 <li class="pin_new"><a href="<?php echo site_url('welcome/lastest');?>">最新图谱</a></li>
    </ul>
</div>-->
<!--/瀑布交流标题-->

<!-- 瀑布流容器 -->
<div id="container_walterfall" class="clearfix" layout="auto">

<?php if(!$sess_userinfo): ?>
<!-- 标签组 -->
<?php echo $tpl_slide; //模版：common/slide.php ?>
<!-- /标签组 -->
<?php endif;?>

<!-- 动态图格区域 -->
<?php echo $tpl_waterfall; //模版：common/waterfall.php ?>
<!-- /动态图格区域 -->
</div>
<!-- /瀑布流容器 -->

<!--<div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div> -->

<!-- 瀑布流分页 -->
<div id="page-nav" class="load" class="clearfix">
	<a href="<?php echo base_url($next_page_url); ?>">
	</a>
</div>
<!-- /瀑布流分页 -->
