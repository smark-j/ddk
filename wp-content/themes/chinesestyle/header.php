<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<?if (is_home()){
    $description ="你的首页描述";
    $keywords ="你首页关键字";
} elseif (is_single()){
    if ($post->post_excerpt) {
        $description = $post->post_excerpt;
    } else {
        $description = mb_strimwidth(strip_tags(apply_filters('the_content',$post->post_content)),6,220);
    } 
    $keywords = "";       
    $tags = wp_get_post_tags($post->ID);
    foreach ($tags as $tag ) {
        $keywords = $keywords . $tag->name . ", ";
    }
} elseif(is_category()){
foreach((get_the_category()) as $category) {
$catname = $category->category_nicename;
$description  = $category->category_description;
}
    $keywords = "";       
    $tags = wp_get_post_tags($post->ID);
    foreach ($tags as $tag ) {
    $keywords = $keywords . $tag->name . ", ";
    }
}

?>
<meta name="description" content="<?=$description?>" />
<meta name="keywords" content="<?=$keywords?>" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link title="RSS 2.0" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" rel="alternate" />
<!--[if IE 6]>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/DD_belatedPNG.js"></script>
<script>DD_belatedPNG.fix('.logo,.nav li,.searchsm'); </script> 
<![endif]-->
<?php if ( is_singular() ){ ?>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/comments-ajax.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/all.js"></script>
<?php } ?>
<?php wp_head(); ?>
</head>

<body>

   <div id="fullwrapper">
       <div class="wrap">
           <div class="header">
               <div class="logo"><h3><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a><?php bloginfo('description'); ?></h3></div>
               	 <ul class="nav">
                 		<li><a title="<?php _e('Home', 'default'); ?>" href="<?php echo get_settings('home'); ?>/"><?php _e('Home', 'default'); ?></a></li>
	<?php wp_list_pages('title_li=&depth=-1'); ?>
                </ul>
           </div>
       </div>
       <div class="wrap">