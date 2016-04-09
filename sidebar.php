	<div class="footer">
	Copyright &copy; 2011 Left All Rights Reserved.
	</div>
</div>
<div class="sidebar">
	<div class="sidebar-inner">
	<?php 
		get_sidebar('self');
		get_sidebar('mix');
		( is_home() ) ? get_sidebar('main_note') : get_sidebar('note');
		get_sidebar('comment');
		get_sidebar('track');
		get_sidebar('notecategory');
		get_sidebar('music');
	?>
	<div class="sidebar-part">
		<span class="sidebar-part-underline">
		<span class="sidebar-part-title">Search</span>
		</span>
		<div id="cse" style="width: 100%;">Loading</div>
			<script src="http://www.google.com/jsapi" type="text/javascript"></script>
			<script type="text/javascript"> 
			  google.load('search', '1', {language : 'zh-TW', style : '<?php bloginfo( 'template_url' ); ?>/css/search.css'});
			  google.setOnLoadCallback(function() {
				var customSearchOptions = {};  var customSearchControl = new google.search.CustomSearchControl(
				  '014193142399680347135:WMX2129815479', customSearchOptions);
				customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
				customSearchControl.draw('cse');
			  }, true);
			</script>
	</div>
	<?php 
		get_sidebar('megane');
		get_sidebar('banner');
		get_sidebar('unlight');
		get_sidebar('link');
		//get_sidebar('memo');
		/*
		$args = array(
			'post_type' => 'note',
			'type'  => 'monthly',
			'format' => 'html',
			'show_post_count' => 'true'
		);
		wp_get_archives($args); 
		*/
	?>
		<script type="text/javascript">
			(function($){
				$(function(){
				
					$('.sidebar-menu-toggle').css('opacity','0.5');
					$('.sidebar-menu-toggle').hover(
						function(){
							$(this).stop().animate({ opacity: 1 }, 500);
						},
						function(){
							$(this).stop().animate({ opacity: 0.5 }, 500);
						}
					);
					$('.sidebar-menu-toggle').toggle(
						function() { 
							$(this).css('background-image','url(http://left.tw/blog/wp-content/themes/left/images/minus.gif)');
							$(this).closest('li').find('ul.sidebar-submenu').slideDown('slow');
						}, 
						function() { 
							$(this).css('background-image','url(http://left.tw/blog/wp-content/themes/left/images/plus.gif)');
							$(this).closest('li').find('ul.sidebar-submenu').slideUp('slow');
						}
					);
				});
			})(jQuery);
		</script>
	</div>
</div>
