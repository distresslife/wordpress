<div class="sidebar-part">
	<span class="sidebar-part-underline">
		<span class="sidebar-part-title">Recent Posts</span>
	</span>
	<ul class="sidebar-list">
		<?php
			$paged = max(1,(int)get_query_var('paged'));
			$args = array(
				'post_status' => 'publish', 
				'post_type' => 'note',
				'posts_per_page' => 10 ,
				'order' => 'DESC',
				'paged' => $paged,
				'no_found_rows' => true,
				'orderby' => 'date',
				'update_post_term_cache' => false,
				'update_post_meta_cache' => false
			);
			$note_query = new WP_Query( $args );
			if ($note_query->have_posts()) :
			while ($note_query->have_posts()) : $note_query->the_post(); ?>
			<li><a href="<?php the_permalink();?>"><?php the_title(); ?> (<?php the_time('m-d');?>)</a></li>
		<?php endwhile; endif; wp_reset_query();?>
	</ul>
</div>
