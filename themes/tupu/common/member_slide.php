<style>
.tu_com_outer02 a , .tu_com_outer02 a:hover{text-decoration:none; }
</style>
<div class="pin">
	<div class="pin_outer clearfix"> <!-- 图格外框 -->
	    <ul>
	    	<li class="pin_tu clearfix">
	    		<img src="<?php echo base_url($sess_userinfo['avatar_large']); ?>" style="margin-left:25px;" />
	    	</li>
            <li>
        		<h1 class="hometile_h4">
        		<?php echo $sess_userinfo['nickname']; ?>
        		</h1>
            </li>
   	 		 <li class="tu_com_outer02 clearfix">
	    		<a href="<?php echo site_url('u/'.$sess_userinfo['uid'])?>/following"><span class="tu_com_mem">关注:<?php echo $sess_userinfo['total_follows'];?></span></a>
	    		<a href="<?php echo site_url('u/'.$sess_userinfo['uid'])?>/follower"><span class="tu_com_mem">粉丝:<?php echo $sess_userinfo['total_followers'];?></span></a>
                <a href="<?php echo site_url('u/'.$sess_userinfo['uid'])?>"><span class="tu_com_mem">分享:<?php echo $sess_userinfo['total_shares'];?></span></a>
               
	    	</li>
            
	    </ul>
        <!-- 新分类 首页 -->
     		<div class="hometile">
        		
  <div class="hometile_dwarp">
     			</div>
        	</div>
	    	<div style="height:1px; margin-top:-1px;clear: both;overflow:hidden;"></div> 
	</div>
</div> 