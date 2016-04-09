<div class="sidebar-part">
	<span class="sidebar-part-title">Recent Trackbacks</span>
	<ul class="sidebar-list">
		<?php
		$args = array(
			'status' => 'approve',
			'order' => 'date',
			'number' => 10,
			'order' => 'DESC'
		);
		$comments = get_comments($args);
		foreach($comments as $comment) : 
		$post_ID = $comment->comment_post_ID;
		$post_type = get_post_type($post_ID);
		$date = date('m-d',strtotime( $comment->comment_date ));
		$content = wp_filter_nohtml_kses($comment->comment_content);
		if ( $post_type == 'note' && $comment->comment_type == 'trackback' ) {
		?>
		<li>
			<a href="<?php echo get_permalink($post_ID);?>#comment-<?php echo ($comment->comment_ID);?>"><?php echo esc_html( $comment->comment_author );?>（<?php echo $date ;?>）：
			<span class="sidebar-comment-content">
			<?php 
			$count = mb_strlen($content,'UTF-8');
			if($count >= 18 ){
				$content = mb_substr($content, 0, 17, 'UTF-8');
				echo $content."…";
			}else{
				echo ($content);
			}?>
			</span></a>
		</li>
		<?php };endforeach;wp_reset_query();?>
	</ul>
</div>
