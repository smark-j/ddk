<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop, $sf_sidebar_config;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
		
if ($sf_sidebar_config == "no-sidebars") {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
} else if ($sf_sidebar_config == "both-sidebars") {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 2 );
} else {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );
}

// Increase loop count
$woocommerce_loop['loop']++;
?>
<li class="product-category product<?php
    if ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 || $woocommerce_loop['columns'] == 1)
        echo ' first';
	if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 )
		echo ' last';
	?>">

	<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

	<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">

		<?php
			/**
			 * woocommerce_before_subcategory_title hook
			 *
			 * @hooked woocommerce_subcategory_thumbnail - 10
			 */
			do_action( 'woocommerce_before_subcategory_title', $category );
		?>
		
		<div class="product-cat-info">
			
			<h3><?php echo $category->name; ?></h3>
	
			<?php if ( $category->count > 0 ) {
				echo apply_filters( 'woocommerce_subcategory_count_html', ' <span class="count">' . $category->count . ' '. __("items", "swiftframework") . '</span>', $category );
				}
			?>
			
		</div>

		<?php
			/**
			 * woocommerce_after_subcategory_title hook
			 */
			do_action( 'woocommerce_after_subcategory_title', $category );
		?>

	</a>

	<?php do_action( 'woocommerce_after_subcategory', $category ); ?>

</li>