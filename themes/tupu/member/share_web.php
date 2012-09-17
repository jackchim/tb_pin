<!--share_layer_web-->
<div id="share_layer_web">
	<!--form -->
<form id="fetch_url_form">
		<!--share_top-->
	<div id="share_top">
		<div class="layer_title">网页分享</div>
        <div><span class="layer_close"><a href="javascript:void(0)">x</a></span></div>
    </div>
   		<!--/share_top-->
    <div class="share_sm">输入网址，将自动获取网页中的图片。</div>
    <!--share_label-->
    <div class="share_label"><div class="share_label_link"><a href="#" class="share_label_selected">网站地址</a> | <a href="javascript:void(0)" class="share_label_selected positive" id="local_upload_share">本地上传</a></div><div class="share_input"><input type="text" class="mark_type_input"  id="fetch_url" name="fetch_url"/></div><div class="hometile_zhuaqu"><a href="javascript:void(0)" id="cratch_pic">获取图片</a></div></div> 
    <!--/share_label-->
    <div class="show_error_class">链接不能为空</div>
    </form><!--结束form放错位置了现在IE正常-->
    <!--form end-->
  <!--<div class="share_input"><input type="text" class="mark_type_input"  id="fetch_url" name="fetch_url"/><div class="loading_icon"></div></div>-->
  	<!--p-t-->
  <div class="p_t">
    <div class="share_img_outer" style="float:left;"><span class="loading_icon"></span><span class="share_img"></span>
    <div class="share_face">封面</div>
    <div class="share_face_web02"><a href="javascript:void(0)"><img src="<?php echo base_url();?>themes/tupu/images/button/web-face02.png"/></a></div>
    <div class="share_face_web01"><a href="javascript:void(0)"><img src="<?php echo base_url();?>themes/tupu/images/button/web-face01.png"/></a></div>
   </div>	
  		<!--p_t  form-->
   <form id="save_share_form" method="POST">
   		<!--p_t form share_web_list-->
   <div class="share_web_list" id="save_share_modal">
   		<input type="hidden" name="item_id" id="item_id">
       <input type="hidden" name="channel" id="channel">
       <input type="hidden" name="share_price" id="share_price">
       <input type="hidden" name="share_title" id="share_title">
       <input type="hidden" name="orgin_url" id="orgin_url">
       <input type="hidden" name="promotion_url" id="promotion_url">
       <input type="hidden" name="image_data" id="image_data">
       <input type="hidden" name="share_type" id="share_type">
       <input type="hidden" name="album" id="album" value="<?php if($albums[0]){echo $albums[0]->album_id;} ?>"/> 
       <input type="hidden" name="category" id="category_id_value" value="<?php  echo $categories[0]->category_id; ?>"/>
       <input type="hidden" name="front_side" id="front_side" value=""/> 
       		<!--p_t form share_web_list album_outer_in-->
   <div id="album_outer_in">
   <!--创建图格样式-->
   		<!--p_t form share_web_list album_outer_in tuge_outer-->
<div id="tuge_outer">
	<span class="cate_zj">分类</span>
	<span class="name_tuge"><a href="javascript:void(0)" id="float_category"><label><?php echo $categories[0]->category_name_cn; ?></label></a>
	</span><span class="cate_zj">专辑</span>
	<span class="name_tuge"><a href="javascript:void(0)" id="float_album"><label><?php if($albums[0]){echo $albums[0]->title;}else{echo "请选择专辑";}  ?></label></a></span>
	<?php if($categories):?>
	<ul class="tuge_outer_layer" style="display:none; border:#CCC 1px solid;" id="show_kalon">
		<?php foreach ($categories as $category): ?>
    	<li><a href="javascript:void(0)" class="category_value" category_id="<?php echo $category->category_id; ?>"><?php echo $category->category_name_cn; ?></a></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
    <?php if($albums):?>
	<ul class="tuge_outer_layer_for_album" style="display:none; border:#CCC 1px solid;">
		<?php foreach ($albums as $album): ?>
    	<li><a href="javascript:void(0)" class="album_value" album_id="<?php echo $album->album_id; ?>"><?php echo $album->title; ?></a></li>
        <?php endforeach; ?>
        <li class="not_remove add_album"><input type="text" onblur="if(this.value=='')this.value='先给专辑起个名字'" onfocus="if(this.value=='先给专辑起个名字') this.value=''" value="先给专辑起个名字" id="album_title_name" value="先给专辑起个名字" class="share_imput"/><button type="button" class="btn_small radius" category_id="<?php echo  $categories[0]->category_id; ?>" id="create_new_album">创建新专辑</button></li>
    </ul>
    <?php endif; ?>
</div>
	<!--p_t form share_web_list album_outer_in /tuge_outer-->
    </div>
    <!--p_t form share_web_list /album_outer_in -->
   
	<span><textarea id="intro"  id="btn_share" name="intro" class="share_textarea">请输入对图片的描述（必填）</textarea></span>
	<button type="submit" disabled="disabled"  class="share_textarea_but right" id="btn_share">提交</button>&nbsp;<span id="ajax_fetch_message" style="line-height:34px; color:red;"></span> 
</div>
	 <!--p_t form /share_web_list -->
 </form>
  <!--p_t /form  -->
  </div>
  <div id="img_box">
 </div>
 
 
 </div>
 
 
 
 
 
 
 
 
 
 
 