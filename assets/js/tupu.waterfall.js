$(document).ready(function($) {
	
	//定义瀑布流容器
	var $container = $('#container_walterfall');
	
	//瀑布流布局处理
	var $elements = $container.find('.masonry_item').fadeIn('slow').css({"opacity":0});
	$container.imagesLoaded(function(){
		$elements.animate({ opacity: 1 });
	    $container.masonry({
	        itemSelector : '.pin',  // 各个图片的容器
                    isAnimated: true,
                    animationOptions: {
                      duration: 250
                    }
	      });
	});
	
	//无限加载处理
	
	$container.infinitescroll({
			navSelector : '#page-nav', //分页导航的选择器
			nextSelector : '#page-nav a', //下页连接的选择器
			itemSelector : '.masonry_item', //你要检索的所有项目的选择器
			animate: false,
            bufferPx     : 1000000,
			loading: {
				finishedMsg: '<p style="line-height:80px;color:green">内容加载完成</p>',//结束显示信息
				img: base_url + 'assets/img/icon/loading.gif',//loading图片
				msgText: "加载更多···"
			}
		},
		//作为回调函数触发masonry
		function( newElements ) {			
			$newElems = $( newElements ).css({"opacity":0});
			$newElems.imagesLoaded(function(){
				$newElems.animate({ opacity: 1 });
				$container.masonry( 'appended', $newElems, true ); //第3个参数表示禁止从下方向上以动画形式插入元素
			});
			
		}
	);//infinitescroll function
	
});

function refresh_fall(){
	var $container = $('#container_walterfall');
	$container.masonry('reload');
}