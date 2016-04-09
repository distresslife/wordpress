<?php get_header(); ?>
<?php if ( have_posts() ) : ?>
	<?php printf( __( 'Search Results for: %s', 'twentyten' ), '<span>' . get_search_query() . '</span>' ); ?>
		<div class="main-content">
			<div class="post-title-div">
				<a class="post-titlelink" href="<?php the_permalink();?>"><span class="post-title"><?php the_title(); ?></span></a>
			</div>
		</div>
<?php else : ?>
				<div id="post-0" class="post no-results not-found">
					<?php _e( 'Nothing Found', 'twentyten' ); ?>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyten' ); ?></p>
					</div><!-- .entry-content -->
				</div><!-- #post-0 -->
<?php endif; ?>
			<!-- #content -->
		<!-- #container -->
</div>
<?php get_sidebar();?>
<?php get_footer(); ?>
