

<?php if($tag_group):?>
<div class="pin">
	<div class="pin_outer radius"> <!-- 图格外框 -->
		<?php foreach ($tag_group as $group):?>
	    <div class="pin_tags_header"><strong><?php echo $group->tag_group_name_cn;?></strong></div>
	    <div class="pin_tags">
	    	<ul>
	    		<?php $tags = explode(',',$group->tags) ?>
	    		<?php foreach($tags as $tag): ?>
	    		<li class="pin_category_spacing"><a href="<?php echo site_url($tag_url_pre.'tags/'.trim($tag));?>"><?php echo trim($tag);?></a></li>
	    		<?php endforeach; ?>
	  		</ul>
	    	<div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div> 
		</div>
		<?php endforeach; ?>
	</div>
</div>
<?php endif;?>
