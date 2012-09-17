<div id="edit_layer_system" class="edit_layer">
	<div id="layer_top">
		<div class="layer_title">编辑专辑</div>
		<div><span class="layer_close"><a href="javascript:void(0)">x</a></span></div>
	</div>
	<form class="ajax_form" onsubmit="return false;" action="<?php echo site_url('member/edit_album')?>" method="POST" name="edit_form" id="edit_album_form_<?php echo $album -> album_id;?>" style="line-height:30px;" onsubmit="return false;">
	<div class="edit_album_content">
		<label class="edit_album_label">专辑名称:</label>
		<input type="text" name="title" class="edit_album_input" id="title" value="<?php echo $album -> title;?>" /><label class="edit_album_error" id="error_msg"></label>
		<label class="edit_album_label pd-t12">分类:</label>
		<ul>
		<?php 
		foreach ($cates as $cate):
		?>
		<li><input type="radio" name="category_id" class="edit_album_radio" value="<?php echo $cate -> category_id;?>" <?php if ($cate -> category_id == $album -> category_id) echo "checked";?> /><?php echo $cate -> category_name_cn;?></li>
		<?php
		endforeach;
		?>
		</ul>
		<div class="edit_album_button"><button class="share_textarea_but">提交</button><button class="share_common_but">取消</button></div>
	</div>
	<!--<table class="layer_table">
		<tbody>
    
			<tr>
				<th class="layer_word" style="width:76px;" align="right">专辑名称:</th>
				<td><input type="text" name="title" class="mem_form_login" id="title" value="<?php echo $album -> title;?>" />
				<p style="display:none;color:red;" id="error_msg"></p>
				</td>
			</tr>
			<tr>
				<th class="layer_word" valign="top" align="right";>分类:</th>
				<td>
				<?php 
				foreach ($cates as $cate):
				?>
				<label style="float:left;display:block; margin:2px 15px 0 0;" class="layer_word" ><input type="radio" style="margin-right:3px;" name="category_id" value="<?php echo $cate -> category_id;?>" <?php if ($cate -> category_id == $album -> category_id) echo "checked";?> /><?php echo $cate -> category_name_cn;?></label>
				<?php
				endforeach;
				?>
				</td>
			</tr>
            <tr><td>&nbsp;</td><td align="center" style="padding-left:20px;">
            <div style="float:left;"><button class="share_textarea_but">提交</button></div>
            <div style="float:left;"><button class="share_common_but">取消</button></div>
            
            </td></tr>
		</tbody>
	</table> -->
	<input type="hidden" name="album_id" value="<?php echo $album -> album_id;?>" />
	<input type="hidden" name="action" value="save" />
	<div style="clear:both">
		<!--<label><input  type="submit" name="submit" value="转发" /></label>-->
		<label class="form_msg" style="display:none;">编辑成功</label>
	</div> 
</form>
<div id="process_form" style="display:none;width:330px; height:80px;" align="center">
	<table width="330" height="80">
		<tr>
			<td valign="middle" align="center"><h1>正在提交</h1></td>
		</tr>
	</table>
</div>


</div>