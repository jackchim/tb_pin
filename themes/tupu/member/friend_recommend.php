<!--推荐关注-->
 <div id="attent_lay">
 	<h2>您还没有关注任何人，我们推荐您关注：</h2>
 	<form action="<?php echo site_url('member/follow_friends')?>" method="POST" id="follow_friends_form">
    <ul>
    	<?php if (is_array($top_users)):foreach ($top_users as $top_user):
    			if ($top_user -> gender == 'male') {
        			$gender_ico = 'male.jpg';
        		}elseif ($top_user -> gender == 'female'){
        			$gender_ico = 'female.jpg';
        		}else{
        			$gender_ico = 'none.jpg';
        		}
    	?>
    	<li>
        <label>
	        <span class="layer_mem_index"><img src="<?php echo base_url(get_useravatar($top_user -> user_id) . '_large.jpg'); ?>" width="100" /></span>
	        <a target="_blank" href="<?php echo site_url('u/'.$top_user -> user_id);?>">
            <input name="follow[]" type="checkbox" value="<?php echo $top_user -> user_id;?>" checked style=" margin:0 8px 0 3px;">
            <span class="layer_mem_name"><?php echo cut_str($top_user -> nickname , 4);?><img src="<?php echo $theme_url;?>/images/icon/<?php echo $gender_ico;?>" style="margin-left:3px;" /></span></a>
	     </label>      
        </li>
        <?php endforeach;endif;?>
    </ul>
     
    <ul class="index_two">
    	<li class="index_one"><a id="do_follow_friends_btn" href="javascript:;" data-action="do_follow_friends" style="color:#FFFFFF; font-size:14px; text-decoration:none;">一键关注</a></li>
    	<span><a href="javascript:;" class="index_three" data-action="do_disable_follow_friends">跳过此步骤</a></span>
    </ul>
   
 	</form>
 
 </div>