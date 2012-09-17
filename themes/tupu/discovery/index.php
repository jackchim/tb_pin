<?php if (is_array($category_share)):?>
<!--发现分类-->
<div id="category_find" class="jMyCarousel">
	<ul>
		<?php
		$category_share_num = 0;
		foreach ($category_share as $cate):
			$cate_img_info = makethumb($cate['image'] , 235 , 0 , 'cate_'.$cate['category_id']);
			if ($cate_img_info['h'] > 120) {
				$margin_top = ($cate_img_info['h'] - 120)/2;
			}
		?>
        <li class="category_find_bgimg auto_width">
	        <a href="<?php echo site_url('category/'.$cate['category_name_en'])?>">
	        	<img src="<?php echo $cate_img_info['image'];?>" <?php if (isset($margin_top)):?> style="margin-top:-<?php echo $margin_top;?>px;"<?php endif;?>/></a>
	        	<span class="category_title"><?php echo $cate['category_name_cn'];?></span>
	    </li>
        
        <?php 
       		$category_share_num++;
        endforeach;
        ?>
        <?php
        for ($i = $category_share_num;$i <4 ;$i++):
        ?>
        <li class="category_find_bgimg"></li>
        <?php
        endfor;
        ?>
	</ul>
</div>
<?php endif;?>
<?php
if ($category_share_num > 4):
?>
<script type="text/javascript">
	$(function() {

	    $(".jMyCarousel").jMyCarousel({
	        visible: '4',
	        eltByElt: true,
	        evtStart: 'mousedown',
	        evtStop: 'mouseup'
	    });

	   var li_num = "<?php echo $category_share_num; ?>";
	});
	
</script>
<?php endif;?>
<script type="text/javascript">

	$(function(){
			 var li_num = "<?php echo $category_share_num; ?>";
			 if(li_num <=4){
			 	$("#category_find").width("944");
			 }
		
	});
</script>
<!-- 瀑布流容器 -->
<div id="container_walterfall" class="clearfix" layout="auto">

<!-- 标签组 -->
<?php echo $tpl_tags; //模版：common/tags.php ?>
<!-- /标签组 -->

<!-- 动态图格区域 -->
<?php echo $tpl_waterfall; //模版：common/waterfall.php ?>
<!-- /动态图格区域 -->


</div>
<!-- /瀑布流容器 -->

<div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div> 

<!-- 瀑布流分页 -->
<div id="page-nav" class="load" class="clearfix">
	<a href="<?php echo base_url($next_page_url); ?>">
	</a>
</div>
<!-- /瀑布流分页 -->
