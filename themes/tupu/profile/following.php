
<!--系统消息页面body部分-->
<div id="container">
	<div id="detail_row_l">
    	<div>
        	<div>
    	<ul class="pin_title">
         <li class="profile_title"><a href="<?php echo site_url('u/'.$_user -> user_id .'/following')?>"><?php echo $ta;?>关注的</a></li>
      	 <li class="profile_title"><li class="profile_title">|&nbsp</li>
      	 <li class="profile_title"><a href="<?php echo site_url('u/'.$_user -> user_id .'/follower')?>"><?php echo $ta;?>的粉丝</a></li>
        </ul>
  </div>
            <ul class="detail_row_l_ifo">   <!--左侧框-->
           	  	<?php 
           	  	if (is_array($followings)):
           	  		foreach ($followings as $following):
           	  	?>
                <li class="system_list">    <!--系统信息列表-->
                <div class="system_list_l">
                	<ol class="system_list_l">
                	  <a href="<?php echo site_url('u/'.$following -> user_id);?>"><img src="<?php echo base_url(get_useravatar($following -> user_id).'_middle.jpg')?>" /></a>
                	</ol>
                </div>
                <div class="system_list_r">
                    <ol class="fans_title"><?php echo $following -> nickname;?></ol>
                    <?php
                    //如果登录，获取登录状态
	                if ($sess_userinfo):
	                	if ($sess_userinfo['uid'] != $following -> user_id):
		                	//0:无关系，1:关注对方, 2: 被关注, 3:互相关注
		                	if($following -> relation == 0 || $following -> relation == 2):
	                ?>
	                <ol class="fans_following" id="relation_<?php echo $sess_userinfo['uid'].'_'.$following -> user_id; ?>"><a data-action="do_add_following" data-params="<?php echo $sess_userinfo['uid']; ?> , <?php echo $following -> user_id; ?>" href="javascript:;"><img src="<?php echo $theme_url; ?>/images/button/attention.jpg" /></a></ol>
	                <?php else:?>
                    <ol class="fans_following" id="relation_<?php echo $sess_userinfo['uid'].'_'.$following -> user_id; ?>"><a data-action="do_remove_following" data-params="<?php echo $sess_userinfo['uid']; ?> , <?php echo $following -> user_id; ?>" href="javascript:;"><img src="<?php echo $theme_url; ?>/images/button/attention_no.jpg" /></a></ol>
                    <?php
                    		endif;
                    	endif;
                    endif;
                    ?>
                    <ol class="system_list_ifo"><?php if($following -> province){ echo $following -> province.'，'.$following -> city;}?><span class="time">粉丝<?php echo $following -> total_followers?>人</span></ol>
                    <ol class="system_list_ifofans"><?php echo $following -> bio?></ol>
               </div>
                </li>
                <?php
                	endforeach;
                endif;
                ?>
                
               
              
                
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
       <!-- <div class="detail_row_l_shadow"><img src="<?php echo $theme_url; ?>/images/icon/detail_big.jpg" /></div>-->  <!--底部阴影-->
    
    </div>
    
    <!--详细页面左侧结束-->
    
    
    
    <!--详细页面右侧开始-->
    <?php echo $tpl_right;?>
    <!--详细页面右侧结束-->
 <div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div>     <!--中部高度自适应-->
</div>
