<?php 
	get_header();
	if(have_posts()): the_post();
	global $post;
?>

		<div class="post-div">
			<div class="post-title">
				<h4><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
				<span class="post-date-span"><?php the_time('Y-m-d H:i:s');?></span>
				<span class="post-term">| Category：<?php $name = ( !empty($term->name)) ? ($term->name) : "未分類"; echo esc_html($name);?></span>
			</div>
			<div class="post-content">
				<?php the_content();?>
			</div>
		</div>
		<div class="post-link">
			<?php previous_post_link('<span>%link</span>'); ?> <?php next_post_link('<span>%link</span>'); ?> <br >
			Trackback URL :<input class="trackback" value="<?php trackback_url(); ?>" readonly /><br >
			Share this : 
			<span class="shareicon">
				<a href="#" onclick="shareicon('p');return false;" title="推到Plurk" class="Plurk"><span>[推到Plurk]</span></a>
				<a href="#" onclick="shareicon('t');return false;" title="推到Twitter" class="Twitter"><span>[推到Twitter]</span></a>
				<a href="#" onclick="shareicon('f');return false;" title="推到Facebook" class="Facebook"><span>[推到Facebook]</span></a>
				<a href="#" onclick="shareicon('s');return false;" title="推到新浪微博" class="Sina"><span>[推到新浪微博]</span></a>
				<span style="display:block;" class="clearB"></span>
			</span>
		</div>
		<script type="text/javascript">
			function shareicon(s){
				switch(s){
					case 's':
					window.open('http://service.weibo.com/share/share.php?url=' + encodeURI(location.href));
					break;
					case 'p':
					window.open('http://www.plurk.com/?qualifier=shares&amp;status=' + encodeURI(location.href + ' (' + document.title + ')'));
					break;
					case 't':
					window.open('http://twitter.com/home/?status=' + encodeURI(location.href));
					break;
					case 'f':
					window.open('http://www.facebook.com/share.php?u=' + encodeURI(location.href));
					break;
				}
				return false;
			}
		</script>
		<?php comments_template( '', true ); ?>
		<div class="post-link">
			<a class="page-left-link" href="<?php echo get_page_link_by_slug('note');?>">POST LIST+</a><a href="#backtop" class="page-right-link">Back Top</a>
		</div>
		<?php endif;?>
	</div>
</div>
<?php get_sidebar();?>
<?php get_footer();?>
