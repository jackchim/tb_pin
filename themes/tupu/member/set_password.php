<h2>设置新密码</h2>
  <div class="row">
    <div class="span8">
      <form id="set_password" class="form-horizontal" action="" method="post">
        <fieldset>
          <legend></legend>
          <div class="control-group">
            <?php if ($is_expire): ?>
             <div class="alert">
			  <a class="close"> ×</a>
			 您好，更新密码操作已失效（超过48小时)，请重新执行获取密码操作，谢谢。
			</div>
			<?php else: ?>
            <label class="control-label" for="input01">新密码</label>
            <div class="controls">
              <input type="password" class="span5" id="password" name="password"></div>
              <p class="help-block">请输入新密码</p>
          </div>
         	<div class="control-group">
            <label class="control-label" for="input01">新密码</label>
            <div class="controls">
              <input type="password" class="span5" id="passconf" name="passconf"></div>
              <p class="help-block">再次输入新密码</p>
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">更新密码</button>
          </div>
          <?php endif; ?>
        </fieldset>
      </form>
    </div>
   </div>