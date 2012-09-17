<div id="detail_row_r">
	<div style="height:24px;"></div>
    	<div class="avatar_ifo_fans">
        	<ul class="avatar">
            	<li class="avatar_li_img"><img src="<?php echo base_url(get_useravatar($_user -> user_id).'_large.jpg');?>"/></li>
                <li class="h2"><?php echo $_user -> nickname;?></li>
                <?php 
                if ($sess_userinfo && $sess_userinfo['uid'] != $_user -> user_id):
                	//0:无关系，1:关注对方, 2: 被关注, 3:互相关注
                	if($relation == 0 || $relation == 2):
                ?>
                <li class="avatar_bt" id="relation_<?php echo $sess_userinfo['uid'].'_'.$_user -> user_id; ?>"><a data-action="do_add_following" data-params="<?php echo $sess_userinfo['uid']; ?> , <?php echo $_user -> user_id; ?>" href="javascript:;"><img src="<?php echo $theme_url; ?>/images/button/attention.jpg" /></a></li>
                <?php else:?>
                <li class="avatar_bt" id="relation_<?php echo $sess_userinfo['uid'].'_'.$_user -> user_id; ?>"><a data-action="do_remove_following" data-params="<?php echo $sess_userinfo['uid']; ?> , <?php echo $_user -> user_id; ?>" href="javascript:;"><img src="<?php echo $theme_url; ?>/images/button/attention_no.jpg" /></a></li>
                <?php 
                	endif;
                endif;?>
                
                
                <li class="fans">
                	<ol class="fans_h3"><p class="fans_data"><a href="<?php echo site_url('u/'.$_user -> user_id.'/following'); ?>"><?php echo $_user -> total_follows;?></a></p>关注</ol>
                    <ol class="fans_h3"><p class="fans_data"><a href="<?php echo site_url('u/'.$_user -> user_id.'/follower'); ?>"><?php echo $_user -> total_followers;?></a></p>粉丝</ol>
                    <ol class="fans_h3"><p class="fans_data"><?php echo $_user -> total_shares;?></p>分享</ol>
                </li>
                               
            </ul>
        <div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div> 
      </div>
        <!--<div class="pin_shadow"><img src="<?php echo $theme_url; ?>/images/icon/pin_big.jpg" width="272" /></div>-->
  </div>