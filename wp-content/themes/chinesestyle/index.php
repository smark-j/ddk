<?php get_header(); ?>
	<div id="content" role="main">
            <div class="content_top conleft"></div>
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('%s', 'kubrick'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h2>
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
					<?php the_content(__('<span>阅读全文 &raquo;</span>', 'kubrick')); ?>
				</div>

			</div>

		<?php endwhile; ?>
         <?php par_pagenavi(4); ?>
	<?php else : ?>

		<div class="nofound"></div>

	<?php endif; ?>

            <div class="content_foot conleft"></div>
        </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>