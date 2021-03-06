<?php 
get_header();

$paged = max( 1, (int)get_query_var('paged') );
$args = array(
	'post_status' => 'publish', 
	'post_type' => 'note',
	'posts_per_page' => 10,
	'order' => 'DESC',
	'paged' => $paged,
	'no_found_rows' => true,
	'orderby' => 'date'
);
$note_query = new WP_Query( $args );
global $main_note_query;
$main_note_query = $note_query;
if ($note_query->have_posts()) :

while ($note_query->have_posts()) : $note_query->the_post();
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
			<div class="post-excerpt">
				<?php the_excerpt();?>
			</div>
			<a href="<?php the_permalink();?>" class="more-link">MORE+</a>
		</div>
<?php endwhile;?>
		<div class="post-link">
			<a href="<?php echo get_page_link_by_slug('note');?>">MORE POST+</a>
		</div>
<?php endif;wp_reset_query(); ?>
	</div>
</div>
<?php get_sidebar();?>
<?php get_footer(); ?>
