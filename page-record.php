<?php 
	get_header(); 
	if(have_posts()): the_post();
?>
		<div class="post-div">
			<div class="post-title">
				<h4><a class="post-title-underline" href="<?php echo get_page_link_by_slug('record');?>"><?php the_title();?></a></h4>
			</div>
			<div class="post-content">
				<?php the_content();?>

				<ul class="sidebar-menu">
					<li><span class="sidebar-menu-toggle"></span><a href="#" onclick="return false">【歌い手】</a><br />
						<ul class="sidebar-submenu">
							<li>
							請見<a href="http://left.tw/notes?p=666" target="_blank">【MUSIC】喜歡的歌い手</a>。
							</li>
						</ul>
					</li>
					<li>
						<span class="sidebar-menu-toggle"></span><a href="#" onclick="return false">【】</a>
						<ul class="sidebar-submenu">
							<li>
								<blockquote>
									//info
								</blockquote>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
<?php endif;?>
	</div>
</div>
<?php get_sidebar();?>
<?php get_footer(); ?>
