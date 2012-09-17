<form action="" method="POST" id="upload_share_form" enctype="multipart/form-data" >
<div id="share_layer_web">
	<div id="share_top">
		<div class="layer_title">本地上传</div>
        <div><span class="layer_close"><a href="javascript:void(0)">x</a></span></div>
    </div>
    <div class="share_sm">您可以从电脑中上传喜欢的图片，分享到专辑中</div>
    <div class="share_label"><div class="share_label_link"><a href="javascript:void(0)" class="share_label_selected positive" id="web_upload_share">网站地址</a> | <a href="javascript:void(0);" class="share_label_selected" >本地上传</a></div>
  <button type="button" class="local_bt"></button><input type="file" id="upload_file_input" name="upload_file_input" size="1"/>
  <!--<input type="submit" class="btn" style="visibility:hidden;" id="b1"/>-->
 <div class="share_more">可分次上传多张图片，最多可分享5张图片。</div>
 </div> 
  </form>
  <div class="p_t">
 
    <div class="share_img_outer" style="float:left;"><span class="share_img"></span>
    <div class="share_face">封面</div>
     <div class="share_face_web02"><a href="javascript:void(0)"><img src="<?php echo base_url();?>themes/tupu/images/button/web-face02.png"/></a></div>
    <div class="share_face_web01"><a href="javascript:void(0)"><img src="<?php echo base_url();?>themes/tupu/images/button/web-face01.png"/></a></div>
   </div>
   <form id="save_share_form">
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
       
   		<span>
        <!--<select id="album" name="album" class="share_list">
   		<?php foreach ($album as $list): ?>
   		  <option value="<?php echo $list->album_id;?>"><?php echo $list->title;?></option>
   		  <?php  endforeach;?>
   		</select>-->
        <div id="tuge_outer">
    <span class="cate_zj">分类</span>
	<span class="name_tuge"><a href="javascript:void(0)" id="float_category"><label><?php echo $categories[0]->category_name_cn; ?></label></a></span>
	<span class="cate_zj">专辑</span>
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
        <li class="not_remove add_album"><input type="text" id="album_title_name" onblur="if(this.value=='')this.value='先给专辑起个名字'" onfocus="if(this.value=='先给专辑起个名字') this.value=''" value="先给专辑起个名字" class="share_imput" /><button type="button" class="btn_small radius" category_id="<?php echo  $categories[0]->category_id; ?>" id="create_new_album">创建新专辑</button></li>
    </ul>
    <?php endif; ?>
</div>
	<span><textarea id="intro" class="share_textarea" name="intro">请输入对图片的描述（必填）</textarea></span>
	<button type="submit" disabled="disabled" class="share_textarea_but right" id="btn_share">提交</button> &nbsp;<span id="ajax_upload_message" style="line-height:34px; color:red;"></span>
</div>
</form>
</div>
<div id="img_box"></div> 
</div>

