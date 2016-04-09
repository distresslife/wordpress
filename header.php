<?php
global $template_url;
$template_url = get_bloginfo( 'template_url' );
?>
<!DOCTYPE HTML>
<html>
<head> 
	<meta http-equiv="content-type" content="text/html; charset=utf-8" >
	<meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible' >
	<title><?php
	global $page, $paged;
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'cc2b' ), max( $paged, $page ) );
	?></title> 
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" >
 	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/style.css" >
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' );?>" href="http://feeds.feedburner.com/left-tw" >
	<meta name="viewport" content="user-scalable=yes, width=device-width, initial-scale=0.6, maximum-scale=3.0" >
	<meta property="fb:admins" content="100001658741248" />
	<meta http-equiv="x-dns-prefetch-control" content="off">
	<meta http-equiv="Window-target" content="_top" >
	<meta http-equiv="content-language" content="zh-TW" >
	<meta http-equiv="imagetoolbar" content="no" >
	<meta name="resource-type" content="document" >
	<meta name="author" content="Left" >
	<meta name="date" content="2011" >
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
	<div id="fb-root"></div>
	<script>
	(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1&appId=366868323397417";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
	</script>
	<script>
	//<![CDATA[
	!window.jQuery && document.write('<scr' + 'ipt src="//ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.2.min.js"><\/scr' + 'ipt>');
	//]]>
	</script>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'template_url' ); ?>/css/jquery.lightbox-0.5.css" media="screen" >
	<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/js/jquery.lightbox-0.5.js"></script>
	<script type="text/javascript">
	(function($){
		$(function() {
			$('a[rel=lightbox]').lightBox({
				overlayBgColor: '#000',
				overlayOpacity: 0.7,
				imageBlank: '<?php bloginfo( 'template_url' ); ?>/images/blank.gif',
				imageLoading: '<?php bloginfo( 'template_url' ); ?>/images/loading.gif',
				imageBtnClose: '<?php bloginfo( 'template_url' ); ?>/images/close.gif',
				imageBtnPrev: '<?php bloginfo( 'template_url' ); ?>/images/prev.gif',
				imageBtnNext: '<?php bloginfo( 'template_url' ); ?>/images/next.gif',
				containerResizeSpeed: 350,
				containerBorderSize: 10,
			});
		});
	})(jQuery);
	</script>
	<?php wp_head(); ?>
	<?php flush(); ?>
</head>
<body>
	<div class="base clearfix">
		<div class="container">
			<div class="container-inner">
				<div class="head">
					<h1 id="backtop"><a class="homelink" href="<?php echo home_url('');?>"><?php bloginfo('name'); ?></a></h1>
					<span class="blog-description" ><?php bloginfo('description'); ?></span>
				</div>
				<div class="main">
