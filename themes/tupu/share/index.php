<style>
.system_list_ifo{ clear:right;}
</style>
<div id="container">
	<div class="view_left">
		<h1 class="view_header">
			<a href="<?php echo site_url('u/'.$share->poster_id); ?>"><img src="<?php echo base_url(get_useravatar($share->poster_id).'_middle.jpg');?>" height="39" /></a>
			<a href="<?php echo site_url('u/'.$share->poster_id); ?>"><?php echo $share->poster_nickname;?></a>
			<span>分享到</span>
			<a href="<?php echo site_url('album/shares/'.$current_share_album->album_id); ?>">#<?php echo $current_share_album -> title;?>#</a>
		</h1>
		<div class="view_main">
        <div class="main_img_outer">
			<div class="main_img_outer02">
				<img id="targe-_big_image" src="<?php echo get_item_first_image($share->image_path , '');?>" />
			</div>
            <ul class="tb_thumb">
            	<?php 
            	$imgs = image_path_to_array($share->image_path);
            	$intro = get_image_intro($share->image_path);
            	if (is_array($imgs)):foreach ($imgs as $key => $img):?>
            	
            	<?php if ($key == 0):?>
            	<li class="tb_thumb_outer image_change_action" targe-image="<?php echo get_one_img($img , '');?>"><div><a href="javascript:;"><img src="<?php echo get_one_img($img , 'square'); ?>"/></a></div><?php if($intro[$key] != 'NULL'):?><span style="display:none;"><?php echo $intro[$key];?></span><?php endif;?></li>
            	<?php else:?>
            	<li class="tb_thumb_outer02 image_change_action" targe-image="<?php echo get_one_img($img , '');?>"><div><a href="javascript:;"><img src="<?php echo get_one_img($img , 'square'); ?>"/></a></div><?php if($intro[$key] != 'NULL'):?><span style="display:none;"><?php echo $intro[$key];?></span><?php endif;?></li>
            	<?php endif;endforeach;endif;?>
            </ul>
         </div>
			<div class="intro">
				<div class="jiathis">
					<!-- JiaThis Button BEGIN -->
					<ul class="detail_fans_four" id="ckepop">
		                <li><span class="jiathis_txt">分享到：</span></li>
		                <li><a href="http://www.jiathis.com%2Fshare%3Fuid%3D1619133" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank"></a></li>
		                <li><a class="jiathis_button_tqq"></a></li>
		                <li><a class="jiathis_button_tsina"></a></li>
		                <li><a class="jiathis_button_renren"></a> </li>  
		                
						<script type="text/javascript" >
			            var jiathis_config={
			                data_track_clickback:true,
			                summary:"<?php echo strip_tags($share->intro); ?>",
			                title:"#爱图谱#",
			                pic:"<?php echo get_item_first_image($share->image_path , 'large');?>"
			            };
			            </script>
						<script type="text/javascript" src="http://v2.jiathis.com/code/jia.js?uid=1619133" charset="utf-8"></script>
						<!-- JiaThis Button END -->
					</ul>
				</div>
				<p>
				<?php echo strip_tags($share->intro);?>
				</p>
				<?php if( $share->price > 0 ):?>
				<div class="to_buy" align="center">
					<span style="float:left;display:block;height:45px; line-height:45px; width:85px;font-size:16px;color:#ffffff;">￥<?php echo $share->price;?></span>
					<a style="float:left;display:block;height:45px; line-height:45px; width:70px;" href="<?php echo  site_url("share/jump") . '/'.$share->item_id;  ?>" target="_blank">去看看</a>
				</div>
				<?php endif;?>
				
				<div id="do_like_share_btn" class="do_like_share_btn">
					<div data-action="do_share_share" data-params="<?php echo $share->share_id; ?> , view" class="do_btn" >
						<div class="ifo_com_h"><span class="share_icon"></span>转发</div>
						<div class="ifo_com_h" id="detail_share_total"><?php echo $share->total_forwarding; ?></div>
					</div>
					
					<div data-action="do_like_share" data-params="<?php echo $share->share_id; ?> , view" id="do_like_share_btn" class="do_btn" style="margin-left:10px;">
						<div class="ifo_com_h"><span class="like_icon"></span>喜欢</div>
						<div class="ifo_com_h" id="detail_like_total"><?php echo $share->total_likes; ?></div>
					</div>
				</div>
				
			</div>
			<div class="clearfix"></div>
		</div>
		
		<!--评论-->
		<ul class="detail_row_l_ifo">  
           		<li class="system_list uniq_li" id="comment" >    <!--系统信息列表-->
                	<ol><textarea name="comments" class="comment" onkeyup="countChar(this,140,'show_warning')" id="comments" cols="40" rows="4" ></textarea></ol>
                    <ol class="comment_bt"><input type="image" src="<?php echo $theme_url;?>/images/comment_btn.png" name="imageField" alt="comment" onclick="page_add_comment('comments','<?php  echo $share->share_id;?>','show_warning')"></ol>
                    <!--<ol class="detail_face"><span class="detail_face_word" id="show_face" style="cursor:pointer;">表情</span></ol>-->
                    <ol class="detail_face_enter">还可以输入<span id="show_warning">140</span>个字符</ol>
                </li> 
                <?php  if($comments){
                	foreach ($comments as $comment){
                		
                	?>
           	  <li class="system_list" id="comment_<?php echo $comment->comment_id ?>">    <!--详细页面评论-->
                	<ol>
                	  <a href="<?php echo site_url('u/'.$comment->poster_uid); ?>" target="_blank"><img src="<?php echo base_url($comment->poster_avatar.'_middle.jpg');  ?>" width="35" /></a>
                	</ol>
                    <ol class="system_list_ifo">
                    	<span><a href="<?php echo site_url('u/'.$comment->poster_uid); ?>" target="_blank" class="member_name"><?php echo $comment->poster_nickname; ?>：</a></span>
                    	<span class="time"><?php echo date('m月d日 h:i',$comment->post_time); ?></span>
                    	<span class="right">
                    		<a href="javascript:void(0)" class="system_list_delete" onclick="report_menu('comment')">举报</a>
                    		<?php  if(($sess_userinfo['uid']==$comment->poster_uid)||($sess_userinfo['user_type']==3)):?> | <a href="javascript:void(0)" onclick="delete_comment('<?php echo $comment->comment_id; ?>','<?php echo $share->share_id; ?>')" id="del_comment_<?php echo $comment->comment_id; ?>" class="system_list_delete">删除</a><?php  endif;?>
                    	</span>
                    </ol>
                    <ol class="commom_ifo"><?php echo ubbReplace($comment->comment); ?></ol>
                </li>
               <?php }}?>
                <li class="right">
                	<div id="pager">
					<div class="pagenum">
					<?php echo $pages;?>
					</div>
				</div>
                </li>
            </ul>
		<!--评论-->
		<?php if( $share->price > 0 ):?>
		<div class="buy_div clearfix">
			<span style="float:right;"><a href="<?php echo  site_url("share/jump") . '/'.$share->item_id;  ?>" target="_blank" class="do_buy_btn">去看看</a></span>
			<span class="title">在这买：</span>
			<a href="<?php echo  site_url("share/jump") . '/'.$share->item_id;  ?>" target="_blank"><img src="<?php echo get_item_first_image($share->image_path , 'square');?>" height="60" /></a>
			<span><?php echo sub_string(strip_tags($share->intro) , 60);?></span>
			<span class="price">￥<?php echo $share->price;?></span>
			
		</div>
		<?php endif;?>
		<div class="clearfix"></div>
	</div>
	<!--/view_left-->
	<div id="detail_row_r" class="view_right" >
    
    	<!--个人信息-->
        <div id="detail_ifo" >
        	<div class="tail_l">
            	<a target="_blank" href="<?php echo site_url('u/'.$share->poster_id);?>"><img src="<?php echo base_url(get_useravatar($share->poster_id).'_large.jpg');?>" class="tail_img"></a><span>
            	
            	<?php if ($sess_userinfo['uid'] != $share->poster_id): if($relation==0||$relation==2):?>
            	<span id="relation_<?php echo $sess_userinfo['uid'].'_'.$share->poster_id; ?>">
	            	<a data-action="do_add_following" data-params="<?php echo $sess_userinfo['uid']; ?> , <?php  echo $share->poster_id;?>" href="javascript:;">
	            		<img src="<?php echo $theme_url?>/images/button/attention.jpg">
	            	</a>
            	</span>
            	<?php else:?>
            	<span id="relation_<?php echo $sess_userinfo['uid'].'_'.$share->poster_id; ?>">
	            	<a id="relation_<?php echo $sess_userinfo['uid'].'_'.$share->poster_id; ?>" data-action="do_remove_following" data-params="<?php echo $sess_userinfo['uid']; ?> , <?php  echo $share->poster_id;?>" href="javascript:;">
	            		<img src="<?php echo $theme_url?>/images/button/attention_no.jpg">
	            	</a>
            	</span>
            	<?php endif;endif; ?>
            	</span>
            </div>
            <div class="tail_r">
                	<h6><?php echo $user -> nickname;?>
                	<?php
                	if ($user -> gender == 'male') {
	        			$gender_ico = 'male.jpg';
	        		}elseif ($user -> gender == 'female'){
	        			$gender_ico = 'female.jpg';
	        		}else{
	        			$gender_ico = 'none.jpg';
	        		}
                	?>
                	<img src="<?php echo $theme_url;?>/images/icon/<?php echo $gender_ico;?>" /></h6>
                	<?php if ($user -> province):?>
                    <p><?php echo $user -> province;?>&nbsp;&nbsp;  <?php echo $user -> city;?></p>
                    <?php endif;?>
                    <p>粉丝<span><?php echo $user -> total_followers;?></span>专辑<span><?php echo $user -> total_albums;?></span></p>
                    <p style=" line-height:18px;"><?php if (strlen($user->bio) == 0) echo '这家伙很懒，什么也没有留下。。。';else echo sub_string($user->bio,70,true);?></p>
            </div>
            
            
        
        </div>
        
        
        
		<!--所在专辑--> 
	    <?php if($current_share_album): ?>
	    <h2 class="album_name">所在专辑</h2>
	    <div id="album_wid">
	        <div class="album_outer_wid">
	            <ul class="album_ifo">
	                <li class="album_name"><?php echo $current_share_album->title ; ?></li>
	            </ul>
	            <ul class="album_layout">
	            <?php if($items):?>
	   				<?php if(is_array($items)): ?>
	   					<?php
	   					$i = 0;
	   					foreach ($items as $item):
	   					$i++;
	   					?>
	                <li class="detail_layout_spacing"><a href="<?php echo site_url('share/view').'/'.$item->share_id; ?>"><img src="<?php echo get_item_first_image($item->image_path , 'square');?>" width="76" height="76"></a></li>
	                	<?php endforeach;?>
	                <?php  endif;?>
	             <?php endif; ?>
	             <?php for ($j = $i;$j <= 5 ;$j++): ?>
	                <li class="detail_layout_spacing"></li>
				 <?php endfor; ?>
	            </ul>
	            <div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div>
	        </div>
	        <!--<div class="pin_shadow"></div>-->
	    </div>
	    <?php endif; ?>
	    <!--//所在专辑--> 
	    <!--可能喜欢的-->  
	    <h2 class="album_name">推荐分享</h2>
		<div class="album_outer_wid">
	    	<ul class="album_ifo">
	            <li class="album_name">可能喜欢的</li>       
	        </ul>
	        <ul class="detail_layout">
	         <?php if($liked_items):?>
					<?php if(is_array($liked_items)): ?>
						<?php  foreach ($liked_items as $liked_item):?>
	       		<li class="detail_layout_spacing"><a href="<?php echo site_url('share/view').'/'.$liked_item->share_id; ?>"><img width="75" height="75" src="<?php echo get_item_first_image($liked_item->image_path , 'square');?>" /></a></li>
	       		<?php endforeach;?>
	            <?php  endif;?>
	         <?php endif; ?>
	    	</ul>
	     <div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div> 
	    </div>
	    <!--<div class="pin_shadow"></div>-->
	    <!--//可能喜欢的-->
		<div class="clearfix"></div>
	</div>
	<!--/view_right-->
	
	<div class="clearfix"></div>
    </div>
    <?php  if($share->has_next):?>
    <div class="page_pre"><a href="<?php echo site_url('share/view/'.$share->has_next); ?>"><img src="<?php echo $theme_url?>/images/button/right-ifo.png"></a></div>
   	<?php  endif;?>
   	 <?php  if($share->has_pre):?>
    <div class="page_next"><a href="<?php echo site_url('share/view/'.$share->has_pre); ?>"><img src="<?php echo $theme_url?>/images/button/left-ifo.png"></a></div>
    <?php  endif;?>