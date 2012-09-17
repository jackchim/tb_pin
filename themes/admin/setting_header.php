	<ul class="nav nav-tabs">
	  <?php $action = $this->uri->segment(2);?>
	  <li<?php echo ($action == 'setting_basic') ?  ' class="active"' : ''; ?>><a href="<?php echo site_url('admin/setting_basic');?>">基本设置</a></li>
	  <li<?php echo ($action == 'setting_seo')   ?  ' class="active"' : ''; ?>><a href="<?php echo site_url('admin/setting_seo');?>">SEO设置</a></li>
	  <li<?php echo ($action == 'setting_badword')   ?  ' class="active"' : ''; ?>><a href="<?php echo site_url('admin/setting_badword');?>">敏感词设置</a></li>
	  <li<?php echo ($action == 'setting_file')  ?  ' class="active"' : ''; ?>><a href="<?php echo site_url('admin/setting_file');?>">文件设置</a></li>
	  <li<?php echo ($action == 'setting_theme')  ?  ' class="active"' : ''; ?>><a href="<?php echo site_url('admin/setting_theme');?>">模板设置</a></li>
	  <li<?php echo ($action == 'setting_logo')  ?  ' class="active"' : ''; ?>><a href="<?php echo site_url('admin/setting_logo');?>">logo设置</a></li>
	</ul>