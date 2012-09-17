<?php
if (is_array($albums)):
	foreach ($albums as $album):
?>
<div id="album_<?php echo $album -> album_id;?>" class="pin masonry_item">
    <div class="album_outer">
        <ul class="album_ifo">
            <li class="album_name"><a class="title" href="<?php echo site_url('album/shares/'.$album -> album_id);?>" target="_blank"><?php echo sub_string($album -> title , 14)?></a></li>
            <li class="album_name_like01"> 
            <?php
			if ($is_admin == 1){
			?>
			<a data-action="do_top_album" data-params="<?php echo $album -> album_id; ?>" href="javascript:;" class="album_layout_member"><span>置顶</span></a> 
			<?php }?>
            <?php if($login_uid == $album -> user_id || $is_admin == 1): ?>
            <a data-action="do_edit_album" data-params="<?php echo $album -> album_id; ?>" href="javascript:;" class="album_layout_member"><span>编辑</span></a> 
            <?php if ($album -> is_system == 0):?>
			<a data-action="do_del_album" data-params="<?php echo $album -> album_id; ?>" href="javascript:;" class="album_layout_member"><span>删除</span></a>
			<?php 
				endif;
			endif;
			?>
			
			</li>
        </ul>

        <ul class="album_layout">
        	<?php
        	$i = 0;
        	if (is_array($album -> shares)):
        		foreach ($album -> shares as $share):
        			$i++;
        	?>
            <li class="album_layout_spacing"><a target="_blank" href="<?php echo site_url('share/view/'.$share -> share_id)?>"><img src="<?php echo get_item_first_image($share -> image_path , 'square'); ?>" width="72" height="72"></a></li>
            <?php
            	endforeach;
            endif;
            ?>
            <?php
            //不足6张图，补上默认图片
            for ($j = $i;$j <= 5 ;$j++):
            ?>
            <li class="album_layout_spacing"><a href="<?php echo site_url('album/shares/'.$album -> album_id);?>" target="_blank"><img src="<?php echo base_url('themes/tupu/images/icon/Default_header.png'); ?>" width="72" height="72"/></a></li>
            <?php
            endfor;
            ?>
            
            <li class="album_member_like"><a href="<?php echo site_url('u/'.$album -> user_id);?>" class="album_layout_member"><?php echo $album -> nickname;?></a>
            
            </li>
			
        </ul>
        <div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div>
    </div>

    <div class="pin_shadow"></div>
</div><!--专辑开始-->
<?php
	endforeach;
endif;
?>