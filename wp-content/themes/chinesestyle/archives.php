<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */
/*
Template Name: 存档模板
*/
?>

<?php get_header(); ?>

<div id="content" class="widecolumn">
		<div class="content_top conleft"></div>
	<div class="links">

<h2><?php _e('月存档:', 'kubrick'); ?></h2>
	<ul class="archives">
		<?php wp_get_archives('type=monthly'); ?>
	</ul>

</div>

<div class="content_foot conleft clear"></div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>