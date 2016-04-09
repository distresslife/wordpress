<?php 
	get_header();
	if(have_posts()): the_post();
	global $post;
	$term_list = wp_get_post_terms( $post->ID, 'notecategory');
?>
		<div class="post-div">
			<div class="post-title">
				<h4><a class="post-title-underline" href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
				By <?php the_author();?> On <?php the_time('Y-m-d H:i:s');?><br />
				Category： 
				<?php if(!empty($term_list)) : ?>
					<?php foreach ($term_list as $key => $term) : ?>
						<a href="http://left.tw/notecat/<?php echo $term->slug;?>" class="post-category-link"><?php echo esc_html($term->name) ?></a>
					<?php endforeach; ?>
				<?php else:?>
					<?php echo '未分類'; ?>
				<?php endif;?>
			</div>
			<div class="post-content">
				<?php the_content();?>
			</div>
		</div>
		<div class="single-post-link clearfix">
			<div class="post-prev"><?php previous_post_link('<strong>%link</strong>'); ?></div>
			<div class="post-next"><?php next_post_link('<strong>%link</strong>'); ?></div>
		</div>
		<div class="single-post-link" style="border:none;">
			Trackback URL :<input class="trackback" value="<?php trackback_url(); ?>" readonly /><br >
			Share this : 
			<ul class="shareicon-ul">
				<li>
					<a href="#" onclick="shareicon('p');return false;" title="分享至Plurk" class="Plurk"><span>分享至Plurk</span></a>
				</li>
				<li>
					<a href="#" onclick="shareicon('t');return false;" title="分享至Twitter" class="Twitter"><span>分享至Twitter</span></a>
				</li>
				<li>
					<a href="#" onclick="shareicon('f');return false;" title="分享至Facebook" class="Facebook"><span>分享至Facebook</span></a>
				</li>
				<li>
					<a href="#" onclick="shareicon('s');return false;" title="分享至新浪微博" class="Sina"><span>分享至新浪微博</span></a>
				</li>
			</ul>
			<script type="text/javascript">
			function shareicon(s){
				var map = {
				  's' : 'http://service.weibo.com/share/share.php?url=',
				  'p' : 'http://www.plurk.com/?qualifier=shares&status=',
				  't' : 'http://twitter.com/home/?status=',
				  'f' : 'http://www.facebook.com/share.php?u='
				};
				if( typeof map[s] == 'string' )
					window.open( map[s] + encodeURI( ( s == 'p' ) ? location.href + ' (' + document.title + ')' : location.href ));
				return false;
			}(jQuery);
			</script>
			<div class="fb-like" data-href="<?php the_permalink();?>" data-send="false" data-layout="button_count" data-width="200" data-show-faces="true" data-font="trebuchet ms"></div>
			<div class="g-plusone" data-size="medium" style="height: 17px;"></div>
		</div>
		<?php comments_template( '', true ); ?>
		<?php endif;?>
	</div>
</div>
<?php get_sidebar();?>
<?php get_footer();?>
