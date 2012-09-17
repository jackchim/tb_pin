
<?php foreach ($shares as $item): ?>
<!-- 图格 -->
<div class="pin masonry_item" id="share_<?php echo $item->share_id; ?>">
<div class="pin_outer"> <!-- 图格外框 -->
    	
        	<ul>
            	<li class="pin_tu"><a href="<?php echo site_url('share/view/id/'.$item->share_id); ?>" target="_blank"><img src="<?php echo base_url($item->image_path . '_middle.jpg'); ?>" /></a></li>
                <li class="tu_com_outer">
           			<ol class="tu_com"><a class="bubble_popup" href="javascript:void(0);"><img src="<?php echo $theme_url;?>/images/icon/xing.jpg" /></a></ol>
           			<ol class="tu_com">12</ol>
           			<ol class="tu_com"><a href="#"><img src="<?php echo $theme_url;?>/images/icon/hand.jpg" /></a></ol>
            		<ol class="tu_com">6</ol>
            		<ol class="tu_com"><a href="#"><img src="<?php echo $theme_url;?>/images/icon/zan.jpg" /></a></ol>
           			<ol class="tu_com">8</ol>
                </li>
       		</ul>
            
            <ul class="dynamic_outer"> <!-- 图格下面内容部分 -->
            	<li class="tu_intro"><?php echo $item->intro; ?></li>
            	<?php  
            	if($item->comments):
            		 $comments = unserialize($item->comments);
            		 //var_dump($comments);
            		 if (is_array($comments)):
            		 	foreach ($comments as $comment):
            		 	//var_dump($comment['poster_uid']);
        		?>
                <li class="interval_line"></li>
                <li>
                	<ol class="member"><a href="<?php echo site_url('profile/index/u/'.$comment->poster_uid);?>" target="_blank"><img src="<?php echo base_url($comment['poster_avatar'].'_middle.jpg');  ?>" width="24" height="24"/></a></ol>
                    <ol class="wenzi"><span><a href="<?php echo site_url('profile/index'); ?>"  class="member_name"><?php echo $comment['poster_nickname'];?></a> </span> <?php echo $comment['comment'];?></ol>
                </li>
                <?php
                		endforeach;
                	endif;
               	endif;
                ?>
                <li class="interval_line"></li>
                <li><a href="<?php echo site_url('share/view/id/'.$item->share_id); ?>"" class="comment_all">显示全部6条评论</A></li>   
          </ul>
          <div class="clearfix"></div> 
        
  </div>  
<div class="pin_shadow"><img src="<?php echo $theme_url;?>/images/icon/index_show.jpg" /></div> 
</div>
<!-- 图格结束 -->
<?php endforeach;?>