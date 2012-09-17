<ul class="nav nav-tabs">
  <?php $action = $this->uri->segment(2);?>
  <li<?php echo ($action == 'setting_advance_seo')   ?  ' class="active"' : ''; ?>><a href="<?php echo site_url('admin/setting_advance_seo');?>">SEO高级设置</a></li>
  <li<?php echo ($action == 'setting_mailservice')   ?  ' class="active"' : ''; ?>><a href="<?php echo site_url('admin/setting_mailservice');?>">邮件服务器设置</a></li>
  <li<?php echo ($action == 'setting_api')  ?  ' class="active"' : ''; ?>><a href="<?php echo site_url('admin/setting_api');?>">API接口设置</a></li>
  <li<?php echo ($action == 'setting_ucenter')  ?  ' class="active"' : ''; ?>><a href="<?php echo site_url('admin/setting_ucenter');?>">Ucenter账号绑定设置</a></li>
</ul>