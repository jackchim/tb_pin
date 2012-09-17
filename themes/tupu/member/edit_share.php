<div id="edit_layer_system">
<div id="layer_top">
        <div class="layer_title">编辑分享</div>
        <div><span class="layer_close"><a href="javascript:void(0)">x</a></span></div>
    </div>
<form action="<?php echo site_url('member/edit_share')?>" method="POST" name="share_form" id="edit_share_form_<?php echo $share -> share_id;?>" style="line-height:30px;" onsubmit="return false;">
	<div style="clear:both">
		<label>专辑:</label>
		<label>
			<select id="album_id" name="album_id">
				<?php foreach ($albums as $album):?>
				<option value="<?php echo $album -> album_id?>" <?php if ($share -> album_id == $album -> album_id) echo "selected";?>><?php echo $album -> title?></option>
				<?php endforeach;?>
			</select>
		</label>
	</div>
	<input type="hidden" name="share_id" value="<?php echo $share -> share_id;?>" />
	<input type="hidden" name="action" value="save" />
	<div style="clear:both">
		<!--<label><input  type="submit" name="submit" value="转发" /></label>-->
		<label class="form_msg" style="display:none;">编辑成功</label>
	</div> 
</form>
</div>

