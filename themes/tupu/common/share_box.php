<div style="position:relative;height:246px;" >
	<div id="layer_top">
        <div class="layer_title">转发到专辑</div>
        <div><span class="layer_close"><a href="javascript:void(0)">x</a></span></div>

    </div>
    <div id="add_form">
		<form action="<?php echo site_url('share/forwarding_share')?>" method="POST" name="share_form" id="share_form_<?php echo $share_id;?>" style="line-height:30px;" onsubmit="return false;">
			<input type="hidden" name="album_id" id="album_id" value="<?php echo $albums[0] -> album_id;?>" />
			<div id="tuge_outer" style="width:350px; padding:16px">
					<div style="height:110px;">
	        	 	<span class="zhuanfa_errer">您可以将分享转发到您的专辑中</span>
					<span style="float:left; font-size:14px;">选择专辑：</span>
					<span class="name_tuge" data-action="do_show_kalon" style="float:right;">
						<a id="float_album" href="javascript:void(0)"><?php echo $albums[0] -> title;?></a>
					</span>	
	                </div>
	                <div style="width:180px;margin:0 auto;">
	                	<span style="display:block; float:left; width:80px; margin-top:15px;"><button class="share_textarea_but">提交</button></span><span style="display:block; float:left; width:80px; margin-top:15px;"><button class="share_common_but">取消</button></span>
	                </div>
	                
					<ul id="show_kalon" class="tuge_outer_layer" style="display:none;left:24px;top:60px;background:#fff;height: 140px; border:#CCCC 1px solid;">
						<?php foreach ($albums as $album):?>
						<li>
							<a class="album_value"  style="border:#ccc 1px solid;" album_id="<?php echo $album -> album_id?>" href="javascript:;"><?php echo $album -> title?></a>
						</li>
						<?php endforeach;?>
						<br>
						<li>
							<dd class="tuge_outer_in">
								<input id="album_title_name" type="text">
								<button id="create_new_album" class="btn_small" category_id="5" type="button">创建新专辑</button>
							</dd>
						</li>
					</ul>
			</div>
			<input type="hidden" name="share_id" value="<?php echo $share_id;?>" />
			<input type="hidden" name="action" value="save" />
			<!--<div style="clear:both">
				<label id="form_msg" style="display:none; color:red;"></label>
			</div> -->
		</form>
	</div>
	
	<div id="process_form" style="display:none;width:400px; height:60px;" align="center">
	<table width="400" height="150">
		<tr>
			<td align="center" valign="middle"><h1>正在转发</h1></td>
		</tr>
	</table>
	</div>
	<div id="return_form" style="display:none;width:400px; height:150px;" align="center">
		<table width="400" height="150">
		<tr>
			<td align="center" valign="middle">
				<h1 style="font-size:14px; color:#000000;"><img src="<?php echo $theme_url;?>/images/conform_ok.png" />&nbsp;恭喜您，转发成功！</h1>	
				<div class="zhuanfa_div">
					<button id="view_share" class="zhuanfa_but" type="button">查看这个转发</button>
				</div>
			</td>
			</tr>
		</table>
	</div>
		
</div>



