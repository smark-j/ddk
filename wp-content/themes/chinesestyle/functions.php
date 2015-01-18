<?php
if ( function_exists('register_sidebar') )
    register_sidebar();

//QQ头像开始
$qq_face_url = 'http://face7.qun.qq.com/cgi/svr/face/getface?&uin=%s';
$qq_face_size = false;

add_filter('get_avatar', 'qq_face', 10, 3);
function qq_face($a, $i, $size) {
	global $qq_face_url, $qq_face_size;
	if ( !is_object($i) )
		return $a;
	if ( isset($i->comment_author_url) && preg_match('/^(http:\/\/)?[1-9][0-9]*$/i', $i->comment_author_url) ) {
		$qq = preg_replace('|\D*|', '', $i->comment_author_url);
		$a = preg_replace('/src=\'[^\']*\'/',
			'src=\'' . str_replace('%s', $qq, $qq_face_url) . '\'',
			$a);
		if( $qq_face_size )
			$a = str_replace('\'' . $size . '\'', '\'' . $qq_face_size . '\'', $a);
		return $a;
	}
	return $a;
}
//QQ头像结束

//表情开始
function wp_smilies() {
    global $wpsmiliestrans;
    if ( !get_option('use_smilies') or (empty($wpsmiliestrans))) return;
    $smilies = array_unique($wpsmiliestrans);
    $link='';
    foreach ($smilies as $key => $smile) {
        $file = get_bloginfo('wpurl').'/wp-includes/images/smilies/'.$smile;
        $value = " ".$key." ";
        $img = "<img src=\"{$file}\" alt=\"{$smile}\" />";
        $imglink = htmlspecialchars($img);
        $link .= "<a href=\"#commentform\" title=\"{$smile}\" onclick=\"document.getElementById('comment').value += '{$value}'\">{$img}</a>&nbsp;";
    }
    echo '<div class="wp_smilies">'.$link.'</div>';
}
//表情结束

//翻页开始
function par_pagenavi($range = 4){
	global $paged, $wp_query;
	if ( !$max_page ) {$max_page = $wp_query->max_num_pages;}
	if($max_page > 1){if(!$paged){$paged = 1;}
	echo '<div class="page_navi clear">';
	if($paged != 1){echo "<a href='" . get_pagenum_link(1) . "' class='extend' title='跳转到首页'> 返回首页 </a>";}
	previous_posts_link(' 上一页 ');
    if($max_page > $range){
		if($paged < $range){for($i = 1; $i <= ($range + 1); $i++){echo "<a href='" . get_pagenum_link($i) ."'";
		if($i==$paged)echo " class='current'";echo ">$i</a>";}}
    elseif($paged >= ($max_page - ceil(($range/2)))){
		for($i = $max_page - $range; $i <= $max_page; $i++){echo "<a href='" . get_pagenum_link($i) ."'";
		if($i==$paged)echo " class='current'";echo ">$i</a>";}}
	elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){
		for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++){echo "<a href='" . get_pagenum_link($i) ."'";if($i==$paged) echo " class='current'";echo ">$i</a>";}}}
    else{for($i = 1; $i <= $max_page; $i++){echo "<a href='" . get_pagenum_link($i) ."'";
    if($i==$paged)echo " class='current'";echo ">$i</a>";}}
	next_posts_link(' 下一页 ');
    if($paged != $max_page){echo "<a href='" . get_pagenum_link($max_page) . "' class='extend' title='跳转到最后一页'> 最后一页 </a>";}
    echo '</div>';}
}
//翻页结束

// 评论部分
function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment;
?>

<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>" >
	<div id="div-comment-<?php comment_ID(); ?>" class="commentmetadata">
  <ul class="comminfo clear">
  	<li><?php echo get_avatar( $comment, 32 ); ?></li>
  	<li class="atxt"><span><?php comment_author_link() ?></span><p>发表于 <?php printf(__('%1$s %2$s'), get_comment_date(),  get_comment_time()) ?> </p></li>
  </ul>
  <ul  class="reply">
  	<?php edit_comment_link(__('Edit'),'','') ?>
  	<?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
  </ul>
  <ul class="commtext clear">
   <?php if ($comment->comment_approved == '0') : ?>
   <?php _e('您的评论正在审核中,请等待,以下为您正在审核的评论内容：') ?>
   <?php endif; ?>
  	<?php comment_text() ?>
  </ul>
</div>

<?php }

?>