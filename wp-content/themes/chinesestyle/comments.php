<?php
	if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	
	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('这篇文章需要密码，请输入密码访问', 'kubrick'); ?></p> 
	<?php
		return;
	}
?>
<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
<h4 id="comments" class="clear"><?php comments_number(__('没有评论', 'kubrick'), __('一篇评论', 'kubrick'), __('% 篇评论', 'kubrick'));?></h4>
	<ol class="commentlist">
		<?php wp_list_comments('type=comment&callback=mytheme_comment'); ?>
	</ol>
 <?php else : ?>
	<?php if ('open' == $post->comment_status) : ?>
	<?php else : ?>
		<p class="nocomments">抱歉，暂停评论。</p>
	<?php endif; ?>
<?php endif; ?>

<div class="comments-navi"><?php paginate_comments_links('prev_text=上一页&next_text=下一页');?></div>

<?php if ( comments_open() ) : ?>

<div id="respond">
<div class="loginin"><h4 class="clear"><?php comment_form_title( __('发表我的评论', 'kubrick'), __('回复 %s' , 'kubrick') ); ?></h4></div>

<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
<div class="loginin"><p><?php printf(__('你需要 <a href="%s">登录</a> 才可以回复.', 'kubrick'), wp_login_url( get_permalink() )); ?></p></div>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( is_user_logged_in() ) : ?>
<p class="smilies"><?php printf(__('当前您登录的用户名为 <a href="%1$s">%2$s</a>，', 'kubrick'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account', 'kubrick'); ?>"><?php _e('退出 &raquo;', 'kubrick'); ?></a></p>
<?php else : ?>

<?php if ( $comment_author != "" ) : ?>
<div id="welcome">
<?php printf(__('欢迎 <strong>%s</strong> 归来！ '), $comment_author) ?>
</div>
<?php endif; ?>
<div id="author_info">
<p><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
<label for="author"><?php _e('昵称', 'kubrick'); ?> <?php if ($req) _e("(必填)", "kubrick"); ?></label></p>

<p><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
<label for="email"><?php _e('邮箱', 'kubrick'); ?> <?php if ($req) _e("(必填)", "kubrick"); ?></label></p>

<p><input type="text" name="url" id="url" value="<?php echo  esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
<label for="url"><?php _e('个人主页或QQ号(填写QQ后即评论头像显示QQ头像)', 'kubrick'); ?></label></p>
</div>
<?php endif; ?>
<p><textarea name="comment" id="comment" cols="5" rows="10" tabindex="4" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};"></textarea></p>
<p class="smilies"><?php wp_smilies();?></p>
<p><input name="submit" type="submit" id="submit" tabindex="5" class="subin" value="<?php _e('','kubrick'); ?>" />
 <?php comment_id_fields(); ?> 
</p><div id="cancel_reply"><?php cancel_comment_reply_link() ?></div>
<?php do_action('comment_form', $post->ID); ?>

</form>
<?php endif; // If registration required and not logged in ?>
</div>
<?php endif; // if you delete this the sky will fall on your head ?>
