<div class="sidebar-part">
	<span class="sidebar-part-underline">
		<span class="sidebar-part-title">About</span>
	</span>
	<?php
		$args = array(
			'post_status' => 'publish', 
			'post_type' => 'about',
			'showposts' => 1 ,
			'order' => 'DESC',
			'orderby' => 'menu_order'
		);
		$about_query = new WP_Query( $args );
		if ($about_query->have_posts()) :
		 $about_query->the_post();

		if( has_post_thumbnail() ){
			the_post_thumbnail('post-thumbnail',array(
			'alt' => esc_attr( get_the_title( get_the_ID() ) ),
			'title' => esc_attr( get_the_title( get_the_ID() ) )
			));
		}?>
		<div class="sidebar-about">
			<?php the_excerpt();?>
		</div>
	<a href="<?php the_permalink(); ?>">MORE+</a>
	<?php endif; wp_reset_query();?>
</div>