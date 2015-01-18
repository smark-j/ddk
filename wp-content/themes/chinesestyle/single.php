<?php get_header(); ?>
	<div id="content" class="widecolumn" role="main">
		<div class="content_top conleft"></div>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h2><?php the_title(); ?></h2>
				<div class="post_intro">
					<span><?php the_author() ?><?php printf(__(' 发表于 %s 分类', 'kubrick'), get_the_category_list(', ')); ?>，<?php the_tags( '标签: '); ?></span>
					<?php edit_post_link(__('<span>编辑</span>', 'kubrick'), '', ''); ?>
				</div>
				<div class="content_date">
					<div class="datebg">
						<span class="day"><?php the_time('d') ?></span>
						<span><?php the_time('F') ?></span>
						<span><?php the_time('Y') ?></span>
					</div>
				</div>
				<div class="comments">
					<span class="cmt_num"><?php comments_popup_link('0', '1', '%'); ?></span>
				</div>
				
			<div class="entry">
				<?php the_content('<p class="serif">' . __('阅读全文', 'kubrick') . '</p>'); ?>
				<span class="align_left"><?php previous_post_link('&laquo; 上一篇：%link') ?></span>
				<span class="align_right"><?php next_post_link('%link：下一篇 &raquo;') ?></span>

			</div>
		</div>

	<?php comments_template(); ?>

	<?php endwhile; else: ?>

			<?php _e('<div class="nofound"></div>', 'kubrick'); ?>

<?php endif; ?>

            <div class="content_foot conleft"></div>
        </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
