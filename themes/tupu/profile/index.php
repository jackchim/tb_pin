
<!--系统消息页面body部分-->
<div id="container">
	<div id="profile"> <!--个人主页外框-->
    	<div>
            <ul>
           	  <li class="profile_head_mem"><img src="<?php echo base_url(get_useravatar($_user -> user_id).'_large.jpg');?>" /></li>
            </ul>
            <ul class="profile_outer02">
           	  <li class="detail_ifo_name_mem"><?php echo $_user -> nickname;?></li>
              <li class="profile_male">
              <?php
              if ($_user -> gender == 'male') {
              	$gender_ico = "male";
              }else if ($_user -> gender == 'female') {
              	$gender_ico = "female";
              }else{
              	$gender_ico = "none";
              }
              ?>
              <img src="<?php echo base_url('assets/img/icon/'.$gender_ico.'.jpg')?>" /></li>
              <li class="fans">
                	<ol class="fans_h4"><p class="fans_data"><a href="<?php echo site_url('u/'.$_user -> user_id.'/following'); ?>"><?php echo $_user -> total_follows;?></a></p>关注</ol>
                    <ol class="fans_h4"><p class="fans_data"><a href="<?php echo site_url('u/'.$_user -> user_id.'/follower'); ?>"><?php echo $_user -> total_followers;?></a></p>粉丝</ol>
                    <ol class="fans_h4"><p class="fans_data"><?php echo $_user -> total_shares;?></p>分享</ol>
                </li>     
                
                                <!--关注状态、操作--->
                <?php 
                if ($sess_userinfo && $sess_userinfo['uid'] != $_user -> user_id):
                	//0:无关系，1:关注对方, 2: 被关注, 3:互相关注
                	if($relation == 0 || $relation == 2):
                ?>
                <li class="detail_avatar_bt" id="relation_<?php echo $sess_userinfo['uid'].'_'.$_user -> user_id; ?>"><a data-action="do_add_following" data-params="<?php echo $sess_userinfo['uid']; ?> , <?php echo $_user -> user_id; ?>" href="javascript:;"><img src="<?php echo $theme_url; ?>/images/button/attention.jpg" /></a></li>
                <?php else:?>
                <li class="detail_avatar_bt" id="relation_<?php echo $sess_userinfo['uid'].'_'.$_user -> user_id; ?>"><a data-action="do_remove_following" data-params="<?php echo $sess_userinfo['uid']; ?> , <?php echo $_user -> user_id; ?>" href="javascript:;"><img src="<?php echo $theme_url; ?>/images/button/attention_no.jpg" /></a></li>
                <?php 
                	endif;
                endif;?>
                <!--/关注状态、操作--->    
                <li class="profile_address"><?php echo $_user -> province;?>，<?php echo $_user -> city;?></li>
                <li class="profile_address clearfix" ><p style="word-wrap: break-word; word-break: normal;"><?php echo nl2br($_user -> bio);?></p></li>  
            </ul>
            <ul class="visiter">
           	   <li class="visiter_near">最近访客</li>
           	   <?php
           	   $views = unserialize($_user -> view_detail);
           	   if (is_array($views)):
           	   	foreach ($views as $key => $view):
           	    	if ($key > 9) break;
           	   ?>
           	   <li class="m"><a href="<?php echo site_url('u/'.$view['user_id'])?>"><img src="<?php echo base_url(get_useravatar($view['user_id']).'_middle.jpg');?>" width="48" height="48" /></a></li>
           	   <?php
           	   	endforeach;
           	   endif;
           	   ?>
           	   
              
            </ul>
        
        </div>
    </div>
    
    <!--个人信息结束-->
    <div id="profile_cate">
    	<ul>
        	<li class="profile_title"><a href="<?php echo site_url('u/'.$_user -> user_id.'/albums')?>"><?php echo $ta;?>的专辑</a></li>
            <li class="profile_title">|</li>
            <li class="profile_title01"><a href="<?php echo site_url('u/'.$_user -> user_id.'/favorites')?>"><?php echo $ta;?>喜欢的</a></li>
 
        </ul>
    </div>
    
      <!--专辑开始-->
      
 <div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div>     <!--中部高度自适应-->
 


	  <div id="container_walterfall" class="clearfix">
	  	<?php echo $tpl_albums;?>
	  </div>

</div>
<div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div> 

<!-- 瀑布流分页 -->
<div id="page-nav" class="load" class="clearfix">
	<a href="<?php echo site_url('u/'.$_user -> user_id.'/2')?>">
	</a>
</div>
<!-- /瀑布流分页 -->