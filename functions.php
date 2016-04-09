<?php
function format_comment( $comment, $args, $depth ){
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'twentyeleven' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'twentyeleven' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
add_action('wp_head', 'rd_feed_links', 2);
function rd_feed_links(){
	if( !defined('RD_FEED_POSTTYPE') && !is_tax() )
		return ;
	
	if(defined('RD_FEED_POSTTYPE')){
		$title = esc_attr(sprintf( '%1$s &raquo; %2$s RSS', get_bloginfo('name'), esc_html( strip_only(get_the_title(),array('span')) ) ));
		$href = trailingslashit(home_url()) . 'feed/?post_type=' . RD_FEED_POSTTYPE;
	}else if(is_tax()){
		$taxonomy = get_query_var( 'taxonomy' );
		$term = get_term_by( 'slug', get_query_var( 'term' ), $taxonomy );
		$title = esc_attr(sprintf( '%1$s &raquo; %2$s RSS', get_bloginfo('name'), esc_html( strip_only($term->name,array('span')) ) ));
		$href = trailingslashit(home_url()) . "feed/?taxonomy={$taxonomy}&term={$term->slug}";
	}
	if ( isset($title) && isset($href) )
		echo '<link rel="alternate" type="' . feed_content_type() . '" title="' . $title . '" href="' . $href . '" />' . "\n";
}
if( function_exists('add_theme_support') )
	add_theme_support('post-thumbnails');

if( !function_exists('is_post_type') ){
	function is_post_type($post_type, $post_id = null){
		return isset($post_id) ? ($post_type == get_post_type($post_id)) : post_type_exists($post_type);
	}
}

if( !function_exists('is_tel') ){
	function is_tel($tel){
		return preg_match('/^0[0-9]{1,2}[-]?[0-9-]{6,9}$/s', $tel);
	}
}

if( !function_exists('is_mobile') ){
	function is_mobile($mobile){
		return preg_match('/^09[0-9]{2}[-]?[0-9]{3}[-]?[0-9]{3}$/s', $mobile);
	}
}

if( !function_exists('is_phone') ){
	function is_phone($phone){
		return is_tel($phone) || is_mobile($phone);
	}
}

function rd_get_page_link($post_id, $post_type = 'page'){
	
	if(is_string($post_id)){
		$post = get_page_by_path($post_id, OBJECT, $post_type);
		$post_id = $post->ID;
	}
	return (!empty($post_id) && is_int($post_id)) ? get_page_link($post_id) : '';
}

function get_page_link_by_slug($page_slug) {
	$page = get_page_by_path($page_slug);
	if ($page) :
		return get_permalink( $page->ID );
	else :
		return "#";
	endif;
}

function strip_only($str, $tags) {
	if(!is_array($tags)) {
		$tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
		if(end($tags) == '') array_pop($tags);
	}
	foreach($tags as $tag) $str = preg_replace('#</?'.$tag.'[^>]*>#is', '', $str);
	return $str;
}

add_filter('wp_mail', 'site_wp_mail', 0, 1);
function site_wp_mail($args) {
	
	if(!is_array($args['headers']))
		$args['headers'] = array();
	
	foreach($args['headers'] as $header){
		if(strpos($header, 'from') !== false)
			return $args;
	}
	$args['headers'][] = 'from:左邊Left <distresslife@gmai.com>';
	
	return $args;
}

add_action( 'init', 'site_init_function', 0);
function site_init_function(){
	
	
	if( !current_user_can('administrator') )
		show_admin_bar(false);
	
	if ( !function_exists('fb_AddThumbColumn') && function_exists('add_theme_support') ) {
		
		set_post_thumbnail_size( 220, 310 );
	}
	
}

add_action('admin_init', 'site_admin_init_function');
function site_admin_init_function(){

	add_action('add_meta_boxes_note', 'note_modify_meta_boxes', 10, 1);
	add_action('save_post', 'save_note_meta');
	
	add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );
	add_filter( "manage_posts_columns", 'fb_AddThumbColumn' );
	add_action( "manage_posts_custom_column", 'fb_AddThumbValue', 10, 2 );
	add_filter( "manage_pages_columns", 'fb_AddThumbColumn' );
	add_action( "manage_pages_custom_column", 'fb_AddThumbValue', 10, 2 );
	
	
	
	function fb_AddThumbColumn($cols) {
		$cols['thumbnail'] = 'Thumbnail';
		return $cols;
	}

	function fb_AddThumbValue($column_name, $post_id) {
		$width = (int) 100;
		$height = (int) 100;
		if( 'thumbnail' == $column_name ) {
			// thumbnail of WP 2.9
			$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
			// image from gallery
			$attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
			if($thumbnail_id) {
				$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
			}elseif($attachments) {
				foreach ( $attachments as $attachment_id => $attachment ) {
					$thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
				}
			}
			echo isset($thumb) && $thumb ? $thumb : 'None';
		}
	}
	
}

function remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'w3tc_latest', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
}

function note_modify_meta_boxes( $post ){
	add_meta_box('note-hint-meta', '密碼提示', 'note_hint_meta', 'note', 'side', 'low');
}

function note_hint_meta( $post ){
	$hint = get_post_meta($post->ID, 'hint', true);
	?>
	<label class="screen-reader-text">密碼提示：</label>
	<input style="width: 95%;" name="hint" value="<?php echo esc_attr($hint); ?>" />
	<?php
}

function save_note_meta($post_id, $post = null){
	if(empty($post))
		$post = get_post($post_id);
	if( $_POST['action'] == 'editpost' && $post->post_type == 'note' ){
		update_post_meta($post->ID, 'hint', $_POST['hint']);
	}
}


add_filter( 'private_title_format', 'yourprefix_private_title_format' );
add_filter( 'protected_title_format', 'yourprefix_private_title_format' );
function yourprefix_private_title_format( $format ) {
    return '%s';
}

function my_excerpt_password_form( $excerpt ) {
    if ( post_password_required() )
        $excerpt = get_the_password_form();
    return $excerpt;
}
add_filter( 'the_excerpt', 'my_excerpt_password_form' );


function my_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	$hint = get_post_meta( $post->ID, 'hint', true );
	
    $o = '<form class="protected-post-form" action="' . get_option( 'siteurl' ) . '/wp-pass.php" method="post">
    ' . "密碼提示：$hint <br />" . '
    <label for="' . $label . '">' . __( "Password:" ) . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" /><input type="submit" name="Submit" value="' . esc_attr__( "Submit" ) . '" />
    </form>
    ';
    return $o;
}
add_filter( 'the_password_form', 'my_password_form' );

?>
