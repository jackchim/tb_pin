<?php if($shares): ?>
<?php foreach ($shares as $item):?>
<!-- 图格 -->
<div class="pin masonry_item" item_share_id="<?php echo $item->share_id;?>"  id="share_<?php echo $item->share_id; ?>">
	<div class="pin_outer radius clearfix" > <!-- 图格外框 -->
    
          <!-- pin头部操作开始 -->
<div class="options" style="display:none;" id="options_<?php echo $item->share_id; ?>">
	<!--<a href="<?php echo site_url('share/view').'/'.$item->share_id;?>" ><div class="magnify"><span>详情</span></div></a>-->
	<a data-action="do_share_share" data-params="<?php echo $item->share_id; ?>" href="javascript:;"><div class="save"><span>转发</span></div></a>
	<a href="javascript:void(0);" onclick="add_comment(<?php echo $item->share_id; ?>)"><div class="pin_comment"><span>评价</span></div></a>
	<a  data-action="do_like_share" data-params="<?php echo $item->share_id; ?>" href="javascript:;"><div class="like"><span>喜欢</span></div></a>
</div>




<div class="tu_intro_com" style="display:none;">
	                	<span class="member"><a href="<?php echo site_url('u/'.$item->poster_id);?>" target="_blank"><img src="<?php echo base_url(get_useravatar($item->poster_id).'_middle.jpg');  ?>" width="24" height="24"/></a></span>
	                    <span><input type="text" class="waterfull_com"/><input type="button" value="评价" class="waterfull_catefy"/></span>
	                </div>
                    
                    
                    
                    
	    	
	        	<ul>
	        		<?php
	        		$deal_image_path = deal_image_path($item->image_path , $item -> is_remote_image);
	        		$intro = get_image_intro($item->image_path);
	        		
	        		if (is_array($deal_image_path)) :
	        			if ($deal_image_path['count'] > 2) :
	        		?>
	        		<li class="pin_tu clearfix show_intro_fun"><a href="<?php echo site_url('share/view/'.$item->share_id); ?>"><img src="<?php echo $deal_image_path['image'][0]; ?>" /></a><?php if($intro[0] != 'NULL'):?><span style="display:none;"><?php echo $intro[0];?></span><?php endif;?></li>
                    <li class="pin_tu_left show_intro_fun"><a href="<?php echo site_url('share/view/'.$item->share_id); ?>"><img src="<?php echo $deal_image_path['image'][1]; ?>" /></a><?php if($intro[1] != 'NULL'):?><span style="display:none;"><?php echo $intro[1];?></span><?php endif;?></li>
                    <li class="pin_tu_right show_intro_fun"><a href="<?php echo site_url('share/view/'.$item->share_id); ?>"><img src="<?php echo $deal_image_path['image'][2]; ?>" /></a><?php if($intro[2] != 'NULL'):?><span style="display:none;"><?php echo $intro[2];?></span><?php endif;?></li>
                    <?php else:?>
                    <li class="pin_tu clearfix show_intro_fun"><a href="<?php echo site_url('share/view/'.$item->share_id); ?>"><img src="<?php echo $deal_image_path['image']; ?>" /></a><?php if($intro[0] != 'NULL'):?><span style="display:none;"><?php echo $intro[0];?></span><?php endif;?></li>
                    <?php endif;//图片个数?>
	        		<?php else:?>
	        		<li class="pin_tu clearfix show_intro_fun"><a href="<?php echo site_url('share/view/'.$item->share_id); ?>"><img src="<?php echo $deal_image_path; ?>" /></a><?php if($intro[0] != 'NULL'):?><span style="display:none;"><?php echo $intro[0];?></span><?php endif;?></li>
	        		<?php endif;//是否反序列化成功?>
	        		
                    <li class="pin_com_f"><a href="<?php echo site_url('share/view/'.$item->share_id); ?>">查看全部<?php echo $item -> image_count;?>张图片</a></li>
	               
	       		</ul>
	            
	            <ul class="dynamic_outer clearfix" id="comment_<?php echo $item->share_id ?>"> <!-- 图格下面内容部分 -->
	            	<li class="tu_intro"><?php echo $item->intro; ?></li>
                     <li class="tu_com_outer clearfix">
	           			<span class="tu_like_img">转发</span>
	           			<span class="tu_com" id="share_<?php echo $item->share_id; ?>_total_forwarding"><?php echo $item->total_forwarding;?></span>
	           			<span class="tu_like_img">喜欢</span>
	            		<span class="tu_com" id="share_<?php echo $item->share_id; ?>_total_likes"><?php echo $item->total_likes;?></span>
	           			<?php
	           			if($login_uid == $item -> poster_id || $is_admin == 1):
	           			?>
                        <span class="edit_del"><a data-action="do_del_share" data-params="<?php echo $item -> share_id; ?> , index" href="javascript:;">删除</a></span><!--<span class="edit_del_r"><a data-action="do_edit_share" data-params="<?php echo $item -> share_id; ?> , index" href="javascript:;">编辑</a></span>-->
                        <?php
                        endif;
                        ?>
	                </li>
                    <li class="tu_intro_line">
	                	<tt class="member"><a href="<?php echo site_url('u/'.$item->poster_id);?>" target="_blank"><img src="<?php echo base_url(get_useravatar($item->poster_id).'_middle.jpg');  ?>" width="24" height="24"/></a></tt>
	                    <tt class="wenzi"><span><a href="<?php echo site_url('u/'.$item->poster_id); ?>"  class="member_name"><?php echo $item->poster_nickname;?></a> </span> <span>发布到 <a href="<?php echo site_url('album/shares/'.$item -> album_id)?>" class="member_name" target="_blank"><?php echo $item -> title;?></a></span></tt>
	                </li>
					<?php  
	            	if($item->comments):
	            		 $comments = unserialize($item->comments);
	            		 	if($comments):
	            		 	foreach ($comments as $comment):
	        		?>
                            <li class="tu_intro_line">
			                	<tt class="member"><a href="<?php echo site_url('u/'.$comment->poster_uid);?>" target="_blank"><img src="<?php echo base_url($comment->poster_avatar.'_middle.jpg');  ?>" width="24" height="24"/></a></tt>
			                    <tt class="wenzi"><span><a href="<?php echo site_url('u/'.$comment->poster_uid); ?>"  class="member_name"><?php echo $comment->poster_nickname;?></a> </span> <?php echo ubbReplace($comment->comment);?></tt>
			                </li>
	                <?php
	                		endforeach;
	                		endif;
	               	endif;
	                ?>
                      <li id="add_comment_<?php echo $item->share_id ?>" class="add_comment">         
                  <div></div>           
                </li>
          <li class="share_all"><span>分享到:</span>
            <a href="javascript:;" onclick="share_to_out(<?php echo $item->share_id ?>,'sina')"><img src="<?php echo base_url(); ?>themes/tupu/images/sina.jpg"/></a>
            <a href="javascript:;" onclick="share_to_out(<?php echo $item->share_id ?>,'qq')"><img src="<?php echo base_url(); ?>themes/tupu/images/qq.jpg"/></a>
            <a href="javascript:;" onclick="share_to_out(<?php echo $item->share_id ?>,'renren')"><img src="<?php echo base_url(); ?>themes/tupu/images/ren.jpg"/></a></li>
	                <?php if($item->total_comments > 5): ?>
	                <li class="show_all" number_count="<?php echo $item->total_comments; ?>"><a href="<?php echo site_url('share/view/'.$item->share_id); ?>" class="comment_all">显示全部<?php echo $item->total_comments; ?>条评论</A></li>
	                <?php endif;?>
	          </ul>
	          <div class="clearfix"></div> 
	        
		</div>  
        
        
  

<!-- pin头部操作开始  -->
        
        
</div>
<!-- 图格结束 -->
<?php endforeach;?>
<?php endif;?>
























