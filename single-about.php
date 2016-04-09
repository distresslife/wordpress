<?php 
	get_header();
	if( have_posts() ): the_post();
?>
	<div class="post-div">
		<div class="post-title">
			<h4><a class="post-title-underline" href="<?php the_permalink();?>"><?php the_title(); ?></a></h4>
			By <?php the_author();?> On <?php the_time('Y-m-d H:i:s');?><br />
		</div>
		<div class="post-content">
			<?php the_content();?>
		</div>
	</div>
<?php endif;?>
	</div>
</div>
<?php get_sidebar();?>
<?php get_footer();?>