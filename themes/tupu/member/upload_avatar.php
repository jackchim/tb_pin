<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if ($result == 0):
?>
<div align="center" style="width:100px;height:70px;color:red;"><?php echo $msg;?></div>
<?php elseif($result == 1):?>
<div style="width:480px;height:300px;">
	
	<div id="upload_success"  style="display:none;clear:both;padding-top:7px;">
		<div style="float:left; width:310px;">
		<img id="upload_img" class="upload_data" src="<?php echo $image_url?>" <?php echo $img_attr_str?>/>		
		<div style="clear:both;padding-top:10px;">
			<form action="<?php echo site_url('member/upload_avatar');?>" id="save_avatar_form" method="post">
				<input type="hidden" id="org_img" name="org_img" value="<?php echo $image_dir;?>" />
				<input type="hidden" id="img_attr_key" name="img_attr_key" value="<?php echo $img_attr_key;?>" />
				<input type="hidden" id="img_attr_val" name="img_attr_val" value="<?php echo $img_attr_val;?>" />
				<input type="hidden" id="x" name="x" />
				<input type="hidden" id="y" name="y" />
				<input type="hidden" id="w" name="w" />
				<input type="hidden" id="h" name="h" />
				<input type="hidden" name="save_crop" value="1" />
				<input type="submit" id="crop_avatar_btn" value="保存头像" />
				&nbsp; &nbsp; &nbsp;
				<input type="button" id="cancel_btn" value="取消" />
			</form>
		</div>
		</div>
		<div style="float:right;">
			<div style="width:150px;height:150px;margin-left:5px;overflow:hidden; clear:both;">
			<img id="big_preview" class="upload_data" src="<?php echo $image_url?>" />
			</div>
			<div style="width:50px;height:50px;margin-left:5px;margin-top:5px;overflow:hidden; float:left;">
			<img id="mid_preview" class="upload_data" src="<?php echo $image_url?>" />
			</div>
			<div style="width:30px;height:30px;margin-left:5px;margin-top:5px;overflow:hidden; float:left;">
			<img id="small_preview" class="upload_data" src="<?php echo $image_url?>" />
			</div>
			
		</div>
		
	</div>
</div>

<?php endif;?>