<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>
<ul class="checkout-progress">
	<li class="current"><?php _e('Bag', THEME_NAME); ?></li>
	<li><?php _e('Payment', THEME_NAME); ?></li>
	<li><?php _e('Confirmation', THEME_NAME); ?></li>
</ul>
<header class="cart-header clearfix">
	<div class="span alpha seven break-on-tablet">
		<h3><?php echo sprintf(_n('You have <span class="red">%d</span> item in your bag', 'You have <span class="red">%d</span> items in your bag', WC()->cart->cart_contents_count), WC()->cart->cart_contents_count);?></h3>
	</div>
	<div class="span three break-on-tablet">
		<p class="text-right"><input type="submit" class="checkout-button button alt" name="proceed" value="<?php _e( 'Proceed to Checkout &rsaquo;', 'woocommerce' ); ?>" /></p>
	</div>
</header>
<form class="cart-form" action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table cart" cellspacing="0">
	<thead>
		<tr>
			<th class="product-thumbnail"><?php _e( 'Item', 'woocommerce' ); ?></th>
			<th class="product-name"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-price"><?php _e( 'Price', 'woocommerce' ); ?></th>
			<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="product-subtotal"><?php _e( 'Total', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		if ( sizeof( WC()->cart->get_cart() ) > 0 ) {
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );;
				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					?>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
						

						<!-- The thumbnail -->
						<td class="product-thumbnail">
							<?php
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

								if ( ! $_product->is_visible() )
									echo $thumbnail;
								else
									printf( '<a href="%s">%s</a>', $_product->get_permalink(), $thumbnail );
							?>
						</td>

						<!-- Product Name -->
						<td class="product-name">
							<?php
								if ( ! $_product->is_visible() )
									echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
								else
									echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', $_product->get_permalink(), $_product->get_title() ), $cart_item, $cart_item_key );

								// Meta data
								echo WC()->cart->get_item_data( $cart_item );

                   				// Backorder notification
                   				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
                   					echo '<p class="backorder_notification">' . __( 'Available on backorder', 'woocommerce' ) . '</p>';

                   				echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove-btn" title="%s">Remove</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'woocommerce' ) ), $cart_item_key );
							?>
						</td>

						<!-- Product price -->
						<td class="product-price">
							<?php
								echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							?>
						</td>

						<!-- Quantity inputs -->
						<td class="product-quantity">
							<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {

									$product_quantity = woocommerce_quantity_input( array(
										'input_name'  => "cart[{$cart_item_key}][qty]",
										'input_value' => $cart_item['quantity'],
										'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									), $_product, false );
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
							?>
							<input type="submit" class="update-btn" name="update_cart" value="<?php _e( 'Update', 'woocommerce' ); ?>" /> 
						</td>

						<!-- Product subtotal -->
						<td class="product-subtotal">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
							?>
						</td>
					</tr>
					<?php
				}
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		
		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

<?php do_action( 'woocommerce_after_cart_table' ); ?>
<?php do_action('woocommerce_proceed_to_checkout'); ?>
<?php wp_nonce_field('woocommerce-cart') ?>
<input type="hidden" name="proceed" value="0" class="proceed" />
</form>

<div class="cart-collaterals">

	<?php do_action('woocommerce_cart_collaterals'); ?>

	<div class="clearfix">
		<div class="span seven break-on-tablet border-right">
		<?php if ( WC()->cart->coupons_enabled() ) { ?>
			<form class="coupon" action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">
				<input type="text" name="coupon_code" id="coupon_code" placeholder="Enter gift voucher" value="" /><input type="submit" class="button alt small" name="apply_coupon" value="<?php _e( 'Apply', 'woocommerce' ); ?>" />
				<?php do_action('woocommerce_cart_coupon'); ?>
			</form>
		<?php } ?>
		<?php woocommerce_shipping_calculator(); ?>
		</div>
		<div class="span three break-on-tablet">
			<?php woocommerce_cart_totals(); ?>
			<p class="text-right">
				<input type="submit" class="checkout-button button alt" name="proceed" value="<?php _e( 'Proceed to Checkout &rsaquo;', 'woocommerce' ); ?>" />
			</p>
		</div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
