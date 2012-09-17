<!-- 尾部开始 -->
<div id="footer_outer">
<div class="footer radius">
	<ul>
    	<li class="foot_title">关于我们</li>
		<li><a href="http://www.duobianxing.com/" target="_blank">关于爱图谱</a></li>
		<li><a href="http://www.duobianxing.com/about/contact/" target="_blank">联系我们</a></li>
	</ul>
	<ul>
        <li class="foot_title">关注我们</li>
		<li>新浪微博</li>
		<li>QQ群1</li>
		<li>QQ群2</li>
	</ul>
	<ul id="foot_anchor">
        <li class="foot_anchor_title"><h4>友情链接</h4></li>
        <?php if (count($friendlinks) > 0):foreach ($friendlinks as $link):?>
        	<li><a target="<?php echo $link -> link_target;?>" href="<?php echo $link -> link_url;?>"><?php echo $link -> link_title;?></a></li>
        <?php endforeach;endif;?>
	</ul>
	<div class="foot_copyright">Copyright ©2012 aitupu.com, All Rights Reserved. <a href="http://www.miibeian.gov.cn/" target="_blank">京ICP备12020632号-1</a> Powered By aitupu <?php echo 'V'.implode('.',str_split($config_custom['version'],1)) ;?>  <a href="http://www.duobianxing.com" target="_blank">多边形工作室</a></div>
</div>
</div>
<!-- 尾部结束 -->

<div class="feedback radius"><a href="javascript:void(0)" onclick="feedback_menu('global')"><!--<img src="<?php echo $theme_url;?>/images/icon/feedback.jpg" />-->意见反馈</a></div>
<div class="xiazai radius"><a href="http://bbs.duobianxing.com/forum.php?mod=viewthread&tid=1" target="_blank"; ><!--<img src="<?php echo $theme_url;?>/images/icon/feedback.jpg" />-->免费下载程序</a></div>
<div class="top_header" style="display:none;"><a href="javascript:void(0)"><img src="<?php echo $theme_url;?>/images/top_back.png" /></a></div>
<script type="text/javascript">
	(function($) {
$.fn.backToTop = function(options) {
var $this = $(this);
$this.hide().click(function() {
$("body, html").animate({
scrollTop:"0px"
});
});
var $window = $(window);
$window.scroll(function() {
if ($window.scrollTop() > 0) {
$this.fadeIn();
} else {
$this.fadeOut();
}
});
return this;
}})(jQuery);
$(".top_header").backToTop();//回到顶部功能
$(".pin").live('mouseover',function(){
	var item_share_id= $(this).attr("item_share_id");
	var show_id = "options_"+item_share_id;
	$("#"+show_id).show();
})
$(".pin").live('mouseleave',function(){
	var item_share_id= $(this).attr("item_share_id");
	var show_id = "options_"+item_share_id;
	$("#"+show_id).hide();
})
</script>
</body>
</html>
<?php
write_page_view($sess_userinfo['uid']);
?>