<div id="share_category_layer">
	<div id="share_top">
		<div class="layer_title">创建新专辑</div>
        <div class="layer_close"><a href="javascript:void(0)">x</a></div>
    </div>
	<form id="album_create_form" name="album_create_form" method="POST">
		<div class="share_input_add">
			<input type="text" class="mark_type_input" id="album_title" name="album_title" />
			<label for="album_title" generated="true" class="error" style="">请输入专辑名称</label>
		</div>
		<span class="share_category">为专辑指定一个分类吧</span>
    	<ul>
			<?php if($categories): ?>
			<?php foreach ($categories as $c): ?>
			<li>
				<input type="radio" name="category_id" <?php if($c->is_system): ?>checked<?php endif;?> value="<?php echo $c->category_id; ?>" />
				<span class="share_category_add"><?php echo $c->category_name_cn; ?></span>
			</li>
			<?php endforeach;  ?>
			<?php endif; ?>
    	</ul>
		<div class="share_button"><button type="submit" class="share_textarea_but radius">提交</button></div>
		<div id="ajax_message" style="float:left; margin-top:10px;margin-left:3px;"></div>
		<div class="clearfix"></div>
   </form>
</div>

