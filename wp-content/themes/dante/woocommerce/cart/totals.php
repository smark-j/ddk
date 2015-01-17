<?php
/**
 * Cart totals
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

$available_methods = $woocommerce->shipping->get_available_shipping_methods();
?>
<div class="cart_totals <?php if ( $woocommerce->customer->has_calculated_shipping() ) echo 'calculated_shipping'; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<?php if ( ! $woocommerce->shipping->enabled || $available_methods || ! $woocommerce->customer->get_shipping_country() || ! $woocommerce->customer->has_calculated_shipping() ) : ?>

		<h3><?php _e( 'Shopping bag summary', 'swiftframework' ); ?></h3>

		<table cellspacing="0">
			<tbody>

				<tr class="cart-subtotal">
					<th><?php _e( 'Cart Subtotal', 'woocommerce' ); ?></th>
					<td><?php echo $woocommerce->cart->get_cart_subtotal(); ?></td>
				</tr>

				<?php if ( $woocommerce->cart->get_discounts_before_tax() ) : ?>

					<tr class="discount">
						<th><?php _e( 'Cart Discount', 'woocommerce' ); ?> <a href="<?php echo add_query_arg( 'remove_discounts', '1', $woocommerce->cart->get_cart_url() ) ?>"><?php _e( '[Remove]', 'woocommerce' ); ?></a></th>
						<td>-<?php echo $woocommerce->cart->get_discounts_before_tax(); ?></td>
					</tr>

				<?php endif; ?>

				<?php if ( $woocommerce->cart->needs_shipping() && $woocommerce->cart->show_shipping() && ( $available_methods || get_option( 'woocommerce_enable_shipping_calc' ) == 'yes' ) ) : ?>

					<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

					<tr class="shipping">
						<th><?php _e( 'Shipping', 'woocommerce' ); ?></th>
						<td><?php woocommerce_get_template( 'cart/shipping-methods.php', array( 'available_methods' => $available_methods ) ); ?></td>
					</tr>

					<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

				<?php endif ?>

				<?php 
					if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
						foreach ( $woocommerce->cart->get_fees() as $fee ) : ?>
		
						<tr class="fee fee-<?php echo $fee->id ?>">
							<th><?php echo $fee->name ?></th>
							<td><?php
								if ( $woocommerce->cart->tax_display_cart == 'excl' )
									echo woocommerce_price( $fee->amount );
								else
									echo woocommerce_price( $fee->amount + $fee->tax );
							?></td>
						</tr>
		
				<?php 
						endforeach;
					}
				?>

				<?php
					if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
						// Show the tax row if showing prices exclusive of tax only
						if ( $woocommerce->cart->tax_display_cart == 'excl' ) {
							foreach ( $woocommerce->cart->get_tax_totals() as $code => $tax ) {
								echo '<tr class="tax-rate tax-rate-' . $code . '">
									<th>' . $tax->label . '</th>
									<td>' . $tax->formatted_amount . '</td>
								</tr>';
							}
						}
					} else {
						if ( get_option('woocommerce_display_cart_taxes') == 'yes' && $woocommerce->cart->get_cart_tax() ) :
						
							$taxes = $woocommerce->cart->get_formatted_taxes();
	
							if (sizeof($taxes)>0) :
	
								$has_compound_tax = false;
	
								foreach ($taxes as $key => $tax) :
									if ($woocommerce->cart->tax->is_compound( $key )) : $has_compound_tax = true; continue; endif;
									?>
									<tr class="tax-rate tax-rate-<?php echo $key; ?>">
										<th>
											<?php
											if ( get_option( 'woocommerce_display_totals_excluding_tax' ) == 'no' && get_option( 'woocommerce_prices_include_tax' ) == 'yes' ) {
												_e( 'incl.&nbsp;', 'woocommerce' );
											}
											echo $woocommerce->cart->tax->get_rate_label( $key );
											?>
										</th>
										<td><?php echo $tax; ?></td>
									</tr>
									<?php
	
								endforeach;
	
								if ($has_compound_tax && !$woocommerce->cart->prices_include_tax) :
									?>
									<tr class="order-subtotal">
										<th><strong><?php _e('Subtotal', 'woocommerce'); ?></strong></th>
										<td><strong><?php echo $woocommerce->cart->get_cart_subtotal( true ); ?></strong></td>
									</tr>
									<?php
								endif;
	
								foreach ($taxes as $key => $tax) :
									if (!$woocommerce->cart->tax->is_compound( $key )) continue;
									?>
									<tr class="tax-rate tax-rate-<?php echo $key; ?>">
										<th>
											<?php
											if ( get_option( 'woocommerce_display_totals_excluding_tax' ) == 'no' && get_option( 'woocommerce_prices_include_tax' ) == 'yes' ) {
												_e( 'incl.&nbsp;', 'woocommerce' );
											}
											echo $woocommerce->cart->tax->get_rate_label( $key );
											?>
										</th>
										<td><?php echo $tax; ?></td>
									</tr>
									<?php
	
								endforeach;
	
							else :
	
								?>
								<tr class="tax">
									<th><?php _e('Tax', 'woocommerce'); ?></th>
									<td><?php echo $woocommerce->cart->get_cart_tax(); ?></td>
								</tr>
								<?php
	
							endif;
						elseif ( get_option('woocommerce_display_cart_taxes_if_zero') == 'yes' ) :
	
							?>
							<tr class="tax">
								<th><?php _e('Tax', 'woocommerce'); ?></th>
								<td><?php _ex( 'N/A', 'Relating to tax', 'woocommerce' ); ?></td>
							</tr>
							<?php
	
						endif;
					}
				?>

				<?php if ( $woocommerce->cart->get_discounts_after_tax() ) : ?>

					<tr class="discount">
						<th><?php _e( 'Order Discount', 'woocommerce' ); ?> <a href="<?php echo add_query_arg( 'remove_discounts', '2', $woocommerce->cart->get_cart_url() ) ?>"><?php _e( '[Remove]', 'woocommerce' ); ?></a></th>
						<td>-<?php echo $woocommerce->cart->get_discounts_after_tax(); ?></td>
					</tr>

				<?php endif; ?>

				<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

				<tr class="total">
					<th><?php _e( 'Order Total', 'woocommerce' ); ?></th>
					<td>
						<?php
							if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
								
								echo $woocommerce->cart->get_total();
	
								// If prices are tax inclusive, show taxes here
								if (  $woocommerce->cart->tax_display_cart == 'incl' ) {
									$tax_string_array = array();
	
									foreach ( $woocommerce->cart->get_tax_totals() as $code => $tax ) {
										$tax_string_array[] = sprintf( '%s %s', $tax->formatted_amount, $tax->label );
									}
	
									if ( ! empty( $tax_string_array ) ) {
										echo '<small class="includes_tax">' . sprintf( __( '(Includes %s)', 'woocommerce' ), implode( ', ', $tax_string_array ) ) . '</small>';
									}
								}
							} else {
								if (get_option('woocommerce_display_cart_taxes')=='no' && !$woocommerce->cart->prices_include_tax) :
									echo $woocommerce->cart->get_total_ex_tax();
								else :
									echo $woocommerce->cart->get_total();
								endif;
							}
						?>
					</td>
				</tr>

				<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

			</tbody>
		</table>

		<?php if ( $woocommerce->cart->get_cart_tax() ) : ?>

			<p><small><?php

				$estimated_text = ( $woocommerce->customer->is_customer_outside_base() && ! $woocommerce->customer->has_calculated_shipping() ) ? sprintf( ' ' . __( ' (taxes estimated for %s)', 'woocommerce' ), $woocommerce->countries->estimated_for_prefix() . __( $woocommerce->countries->countries[ $woocommerce->countries->get_base_country() ], 'woocommerce' ) ) : '';

				printf( __( 'Note: Shipping and taxes are estimated%s and will be updated during checkout based on your billing and shipping information.', 'woocommerce' ), $estimated_text );

			?></small></p>

		<?php endif; ?>

	<?php elseif( $woocommerce->cart->needs_shipping() ) : ?>

		<?php if ( ! $woocommerce->customer->get_shipping_state() || ! $woocommerce->customer->get_shipping_postcode() ) : ?>

			<div class="woocommerce-info">

				<p><?php _e( 'No shipping methods were found; please recalculate your shipping and enter your state/county and zip/postcode to ensure there are no other available methods for your location.', 'woocommerce' ); ?></p>

			</div>

		<?php else : ?>

			<?php

				$customer_location = $woocommerce->countries->countries[ $woocommerce->customer->get_shipping_country() ];

				echo apply_filters( 'woocommerce_cart_no_shipping_available_html',
					'<div class="woocommerce-error"><p>' .
					sprintf( __( 'Sorry, it seems that there are no available shipping methods for your location (%s).', 'woocommerce' ) . ' ' . __( 'If you require assistance or wish to make alternate arrangements please contact us.', 'woocommerce' ), $customer_location ) .
					'</p></div>'
				);

			?>

		<?php endif; ?>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>