<div class="pin">
	<div class="pin_outer clearfix"> <!-- 图格外框 -->
	    <ul>
	    	<li class="pin_tu clearfix">
	    		<a href="<?php echo site_url('u/'.$album -> user_id);?>">
	    		<img src="<?php echo base_url(get_useravatar($album -> user_id).'_large.jpg'); ?>" style="margin-left:25px;" />
	    		</a>
	    	</li>
            <li>  <!-- 会员名 专辑名 -->
        		<h1 class="hometile_h4"><a href="<?php echo site_url('u/'.$album -> user_id);?>">
        		<?php echo $album -> nickname; ?></a>
        		</h1>
                <h1 class="hometile_h4_name"><?php echo $album -> title; ?></h1>
            
            </li>
   	 		 <li class="tu_com_outer02 clearfix">
	    		<span class="tu_com_mem">分享:<?php echo $album -> total_share;?></span>
	    		<span class="tu_com_mem">喜欢:<?php echo $album -> total_favorite;?></span>
                <span class="tu_com_mem">专辑:<?php echo $album -> total_favorite;?></span>
               
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