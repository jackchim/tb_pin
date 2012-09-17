<style>
.slide_control_container img{ max-height:280px; }
</style>
<div id="main">
  <!--手风琴模块-->
  <div id="banner">
    <div class="banner_t radius">
    <div id="slidedeck_frame" class="skin-slidedeck">
			<dl class="slidedeck">
			<?php if($advers): ?>
				<?php foreach ($advers as $val): ?>
				<dt><?php echo $val->ad_title; ?></dt>
				<dd><div class="slide_control_container"><a target="_blank" href="<?php echo $val->ad_url; ?>"><img title="<?php echo $val->ad_title; ?>"  alt="<?php echo $val->ad_title; ?>" src="<?php echo base_url('').'/'.$val->ad_photo; ?>"/></a></div></dd>
				<?php endforeach; ?>
				<?php  endif;?>
			</dl>
		</div>
		<script type="text/javascript">
			var slideDec = $('.slidedeck').slidedeck({
                autoPlay: true,
                cycle: true, 
                autoPlayInterval: 3000,
                //start:3,//开始的起始位置
                //index:['A','B'] //标号
                scroll:false,
                hideSpines:false,//是否隐藏滑动框 准滑动
                slideTransition:'fade',
                transition:'linear',
                //speed:1000,//加速度
                controlProgress:true,
                touch:false
               // complete:function(){alert(3)}
            })//.goTo(2);
            //slideDec.next();
            $(function(){
            	$("#slidedeck_frame").height(285);
            });
		</script>	
    </div>
    <div class="banner_b"></div>
  </div>
  <!--刚刚喜欢模块-->
  <div class="main_like radius">
  	<div class="main_like_shdow"></div>
    <h1>这些东西刚刚被喜欢过</h1>
    <ul id="slide_share">
    <?php if(favorites):?>
    	<?php  foreach ($favorites as $val):?>
      <li>
      <a href="<?php echo site_url('share/view').'/'.$val->share_id; ?>">
      	<div style="height:120px;overflow:hidden"><img src="<?php echo get_item_first_image($val->image_path , 'small'); ?>"  width="120"  /></div>
      </a>
      <span class="interval_top"><a href="<?php  echo site_url('u').'/'.$val->user_id;?>"><img src="<?php echo base_url(get_useravatar($val->user_id).'_small.jpg');?>" /></a></span><span class="interval_top"><a href="<?php  echo site_url('u').'/'.$val->user_id;?>" class="mem"><?php echo $val->user_nickname; ?></a>
            <p><?php time_diff($val->share_time);?></p>
      </span>
      </li>
      <?php  endforeach;?>
    <?php  endif;?>
    </ul>
    <script>
    	slide_share();
    </script>
  </div>
 
      
      
      <?php
      if (is_array($cates)):
      	foreach ($cates as $cate):
      		if($cate -> all_count == 0) continue;
      ?>
      <!--虚线-->
  <div class="main_line"></div>
      <div class="main_ca">
           <div id="mainTitle">
           <span><h3><?php echo $cate -> category_name_cn;?></h3></span>
           <span id="leftFrame"></span>
           <tt>最近更新<?php echo $cate -> last_count;?>个</tt>
           <span id="rightFrame"></span>
           <a target="_blank" href="<?php echo site_url('category'); ?>/<?php echo $cate->category_name_en; ?>"><b>还有<?php echo $cate -> all_count;?>个你可能喜欢的共享</b></a>
           </div>
        
        <ul class="main_cate radius">
           <?php if (is_array($cate -> albums)):foreach ($cate -> albums as $i => $album):?>
	           <li><a target="_blank" href="<?php echo site_url('album/shares/'.$album -> album_id)?>"><h2><?php echo sub_string($album -> title , 14)?></h2></a>
		           <?php if (is_array($album -> shares)):foreach ($album -> shares as $key => $share):?>
		           <a href="<?php echo site_url('share/view/'.$share -> share_id)?>">
		           <span><img src="<?php echo get_item_first_image($share -> image_path , 'square'); ?>" width="98" height="98"></span>
		           </a>
		           <?php endforeach;endif;?>
		           <?php
		           for ($j = $key; $j < 3;$j++){
		           ?>
		           <span>
		           	<img src="<?php echo $theme_url?>/images/default_index.png">
		           </span>
		           <?php }?>
	           <span><?php echo $album -> total_shares;?>个共享</span><em><a target="_blank" href="<?php echo site_url('album/shares/'.$album -> album_id)?>">去看看》</a></em></li>
	           <?php if ($i != 3){?>
	           <li class="shdow_one"></li>
	           <?php }?>
           <?php endforeach;endif;?>
        </ul> 
      </div>
      <?php
      	endforeach;
      endif;
      ?>

      
         <!--会员秀-->
  <div class="main_line"></div>
      <div class="main_ca">
        <ul>
          <h3>会员秀</h3>
          
        </ul>
        <ul class="mem_ul" id="slide_users" style="overflow:hidden;">
        	<?php if (is_array($top_users)):foreach ($top_users as $top_user):
        		
        		if ($top_user -> gender == 'male') {
        			$gender_ico = 'male.jpg';
        		}elseif ($top_user -> gender == 'female'){
        			$gender_ico = 'female.jpg';
        		}else{
        			$gender_ico = 'none.jpg';
        		}
        	
        	?>
        	
           <li class="main_mem radius">
	           <a target="_blank" href="<?php echo site_url('u/'.$top_user -> user_id);?>"><img src="<?php echo base_url(get_useravatar($top_user -> user_id) . '_large.jpg'); ?>" width="150" height="150" /></a>
	           <a target="_blank" href="<?php echo site_url('u/'.$top_user -> user_id);?>"><span><?php echo sub_string($top_user -> nickname , 10);?><img src="<?php echo $theme_url;?>/images/icon/<?php echo $gender_ico;?>" /></span></a>
	           <b><img src="<?php echo $theme_url;?>/images/lnk.jpg"  class="bo_img"/><a target="_blank" href="<?php echo site_url('u/'.$top_user -> user_id.'/albums');?>"><?php echo $top_user -> total_shares;?></a></b>
	           <a target="_blank" href="<?php echo site_url('u/'.$top_user -> user_id);?>">
	           <div class="main_mem_base"></div>
	           </a>
           </li>
           <?php endforeach;endif;?>
           
        </ul>
        <script>
    	 slide_users();
        </script>
        
      </div>
