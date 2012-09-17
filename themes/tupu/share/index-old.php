<!--系统消息页面body部分-->
<div id="container">
	<div id="detail_row_l">
    	<div class="detail_row_l_ifo">
            <ul class="system_list"><!--左侧框-->
           	    <!--名称 按钮统计-->
                <!--头像 谁发到哪个专辑-->
                
                
                
                <li class="avatar_ifo_img clearfix"><a href="<?php echo site_url('u/'.$share->poster_id); ?>"><img src="<?php echo base_url(get_useravatar($share->poster_id).'_middle.jpg');?>" /></a></li>
                <li class="detail_ifo_name02"><a href="<?php echo site_url('u/'.$share->poster_id); ?>"><?php echo $share->poster_nickname;?><a href="javascript:void(0)"></a><span>分享到</span><span><a href="#">淘宝达人</a></span><p class="detail_pic_name_top"><?php echo "“".$share->intro."”"; ?></p><li>

           	     
            </ul>
            
            <ul class="system_list">   <!--图片 来源-->
           	  <li class="time">来源:<?php echo $from_type;?></li>
              <li class="detail_pic_tu" style="padding-bottom:7px;"><img src="<?php echo base_url($share->image_path.'_large.jpg');?>" /></li>
             <!--<a href="javascript:;" data-action="do_like_share" data-params="<?php echo $share->share_id; ?> , view">
             <li class="like_and_retrit">
              	<ol class="detail_dynamic_l"></ol>
                <ol class="detail_dynamic_m"><span class="detail_like_data" id="detail_like_total"><?php echo $share->total_likes; ?></span><span class="detail_like_data">喜欢</span></ol>
                <ol class="detail_dynamic_r"></ol>
              </li>
              </a>
              <a href="javascript:;" data-action="do_share_share" data-params="<?php echo $share->share_id; ?> , view">
              <li class="like_and_retrit" style="margin-right: 7px;">
              	<ol class="detail_like_l"></ol>
                <ol class="detail_dynamic_m"><span class="detail_like_data" id="detail_share_total"><?php echo $share->total_forwarding; ?></span><span class="detail_like_data">转发</span></ol>
                <ol class="detail_dynamic_r"></ol>
              </li></a>-->
            </ul>
            
            
            <ul class="fans">
            </ul>
            <ul class="detail_fans_four" id="ckepop">
             <!-- JiaThis Button BEGIN -->
                    <li><span class="jiathis_txt">分享到：</span></li>
                    <li><a class="jiathis_button_tqq"></a></li>
                    <li><a class="jiathis_button_tsina"></a></li>
                    <li><a class="jiathis_button_renren"></a> </li>  
                    <li><a href="http://www.jiathis.com%2Fshare%3Fuid%3D1619133" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank">更多</a>
				<script type="text/javascript" >
                var jiathis_config={
                    data_track_clickback:true,
                    summary:"<?php echo strip_tags($share->intro); ?>",
                    title:"#爱图谱#",
                    pic:"<?php echo base_url($share->image_path.'_large.jpg');?>"
                };
                </script>
				<script type="text/javascript" src="http://v2.jiathis.com/code/jia.js?uid=1619133" charset="utf-8"></script>
			<!-- JiaThis Button END -->
            </ul>
            
            
            
            <ul class="like_fans_zhuan">
            
            
            	<a href="javascript:;" data-action="do_like_share" data-params="<?php echo $share->share_id; ?> , view">
             <li class="like_and_retrit">
              	<ol class="detail_dynamic_l"></ol>
                <ol class="detail_dynamic_m"><span class="detail_like_data" id="detail_like_total"><?php echo $share->total_likes; ?></span><span class="detail_like_data">喜欢</span></ol>
                <ol class="detail_dynamic_r"></ol>
              </li>
              </a>
              
              
               <a href="javascript:;" data-action="do_share_share" data-params="<?php echo $share->share_id; ?> , view">
              <li class="like_and_retrit" style="margin-right: 7px;">
              	<ol class="detail_like_l"></ol>
                <ol class="detail_dynamic_m"><span class="detail_like_data" id="detail_share_total"><?php echo $share->total_forwarding; ?></span><span class="detail_like_data">转发</span></ol>
                <ol class="detail_dynamic_r"></ol>
              </li></a>
            
            
            
            
            </ul>
            
        <div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div>   <!--自适应高度框不可见-->
        </div>
        <div class="detail_row_l_shadow"></div>  <!--底部阴影-->
         <!--图片 详细信息结束-->
        
        
        
    <!--左侧框评论列表--> 
    <div>
            <ul class="detail_row_l_ifo">  
           		 <li class="system_list uniq_li" id="comment" >    <!--系统信息列表-->
                	<ol><textarea name="comments" class="comment" onkeyup="countChar(this,140,'show_warning')" id="comments" cols="40" rows="4" ></textarea></ol>
                    <ol><input type="image" src="<?php echo $theme_url;?>/images/icon/comment.jpg" name="imageField" alt="comment" onclick="page_add_comment('comments','<?php  echo $share->share_id;?>','show_warning')"></ol>
                    <!--<ol class="detail_face"><span class="detail_face_word" id="show_face" style="cursor:pointer;">表情</span></ol>-->
                    <ol class="detail_face_enter">还可以输入<span id="show_warning">140</span>个字符</ol>
                </li> 
                <?php  if($comments){
                	foreach ($comments as $comment){
                		
                	?>
           	  <li class="system_list" id="comment_<?php echo $comment->comment_id ?>">    <!--详细页面评论-->
                	<ol>
                	  <a href="#"><img src="<?php echo base_url($comment->poster_avatar.'_middle.jpg');  ?>" /></a>
                	</ol>
                    <ol class="system_list_ifo"><span><a href="<?php echo site_url('u/'.$comment->poster_uid); ?>" target="_blank" class="member_name"><?php echo $comment->poster_nickname; ?>：</a></span><?php echo ubbReplace($comment->comment); ?><span class="time"><?php echo date('m月d日 h:i',$comment->post_time); ?></span></ol><ol class="system_list_delete"><span><a href="javascript:void(0)" class="system_list_delete" onclick="report_menu('comment')">投诉</a></span></ol>
                    <?php  if(($sess_userinfo['uid']==$comment->poster_uid)||($sess_userinfo['user_type']==3)):?><ol class="system_list_delete"><span><a href="javascript:void(0)" onclick="delete_comment('<?php echo $comment->comment_id; ?>','<?php echo $share->share_id; ?>')" id="del_comment_<?php echo $comment->comment_id; ?>" class="system_list_delete">删除</a><span></ol><?php  endif;?>
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
        </div>
        <div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div>    <!--高度自适应ID-->
        <div class="detail_row_l_shadow"></div>  <!--底部阴影-->
    </div>
    <!--详细页面左侧结束--> 
    

     
<!--详细页面右侧开始-->
<div id="detail_row_r">
        <?php if( $share->price > 0 ):?>
    	 <ul class="detail_row_r_ifoshare">
        	<li class="buy_outer"><a href="<?php echo $share->promotion_url;  ?>"  target="_blank" class="buy">在这买...</a><span class="buy_price">价格：￥</span><em class="buy_price_sub"><?php echo $share->price; ?></em></li>
        	<li><a href="<?php echo $share->promotion_url;  ?>" class="sgr_btn">去看看></a></li>
    	</ul>
        <?php endif; ?>

    <!--用户头像-->
	<div class="detail_row_r_ifo">
    	<!--<ul class="avatar_ifo">
        	<!--<li class="avatar_ifo_img clearfix"><a href="<?php echo site_url('u/'.$share->poster_id); ?>"><img src="<?php echo base_url(get_useravatar($share->poster_id).'_large.jpg');?>" /></a></li>-->
            <!--<li class="detail_ifo_name02"><a href="<?php echo site_url('u/'.$share->poster_id); ?>"><?php echo $share->poster_nickname;?><a href="javascript:void(0)"></a><li>-->
            <!--<li class="detail_ifo_guanzhu">
            <span class="detail_avatar_bt02" id="uniq">
            <?php if($relation==0||$relation==2):?><a href="javascript:;"><img src="<?php echo $theme_url;?>/images/button/attention.jpg" onclick="add_follow('<?php echo $sess_userinfo['uid'];?>','<?php  echo $share->poster_id;?>','detail_avatar_bt02')" /></a>
            <?php elseif($relation!=4): ?><a href="javascript:;"><img src="<?php echo $theme_url; ?>/images/button/attention_no.jpg" onclick="remove_follow('<?php echo $sess_userinfo['uid'];?>','<?php  echo $share->poster_id;?>','detail_avatar_bt02')"/></a>
            <?php endif; ?></span>
            </a>
            </li>-->
            
 
    	<!--<li class="system_row_intro"><p style="word-wrap: break-word; word-break: normal;"><?php echo sub_string($user->bio,200,true); ?></p></li>     -->   
        </ul> 
          
     <div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div> 
    </div>  
    <!--<div class="pin_shadow"></div>
    <!--//用户头像-->
    
    <!--所在专辑--> 
    <?php if($current_share_album): ?>
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
                <li class="detail_layout_spacing"><a href="<?php echo site_url('share/view').'/'.$item->share_id; ?>"><img src="<?php echo base_url($item->image_path.'_square.jpg');?>" width="76" height="76"></a></li>
                	<?php endforeach;?>
                <?php  endif;?>
             <?php endif; ?>
             <?php for ($j = $i;$j <= 5 ;$j++): ?>
                <li class="detail_layout_spacing"><a href="<?php echo site_url('share/view').'/'.$item->share_id; ?>"></li>
			 <?php endfor; ?>
            </ul>
            <div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div>
        </div>
        <div class="pin_shadow"></div>
    </div>
    <?php endif; ?>
    <!--//所在专辑--> 

	<!--可能喜欢的-->  
	<div class="detail_row_r_ing">
    	<ul class="album_ifo">
            <li class="album_name">可能喜欢的</li>       
        </ul>
        <ul class="detail_layout">
         <?php if($liked_items):?>
				<?php if(is_array($liked_items)): ?>
					<?php  foreach ($liked_items as $liked_item):?>
       		<li class="detail_layout_spacing"><a href="<?php echo site_url('share/view').'/'.$liked_item->share_id; ?>"><img width="75" height="75" src="<?php echo base_url($liked_item->image_path.'_square.jpg');?>" /></a></li>
       		<?php endforeach;?>
            <?php  endif;?>
         <?php endif; ?>
    	</ul>
     <div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div> 
    </div>
    <div class="pin_shadow"></div>
    <!--//可能喜欢的--> 

</div>   
<!--详细页面右侧结束-->
<div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div>     <!--中部高度自适应-->
</div>

<script type="text/javascript">
$(function(){
	var face_path=base_url+"assets/js/face/face/";
	$('#show_face').qqFace({
		id : 'facebox1', //表情盒子的ID
		assign:'comments', //给那个控件赋值
		path:face_path	//表情存放的路径
	});
});
</script>