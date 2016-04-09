<?php 
get_header();
if (have_posts()) : while (have_posts()) : the_post();
?>
	<div class="post-div">
		<div class="post-title">
			<h4><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
			<span class="post-date-span"><?php the_time('Y-m-d H:i:s');?></span><span class="post-term"></span>
		</div>
		<div class="post-excerpt">
			<?php the_excerpt();?>
		</div>
		<a href="<?php the_permalink();?>" class="more-link">MORE+</a>
	</div>
<?php endwhile;?>
		<div class="post-link">
			<?php wp_link_pages(); ?>
		</div>
<?php endif;wp_reset_query(); ?>
	</div>
</div>
<?php get_sidebar();?>
<?php get_footer(); ?>
