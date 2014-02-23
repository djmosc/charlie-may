<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
?>
<ul class="checkout-progress">
	<li><?php _e('Bag', THEME_NAME); ?></li>
	<li><?php _e('Payment', THEME_NAME); ?></li>
	<li class="current"><?php _e('Confirmation', THEME_NAME); ?></li>
</ul>
<?php if ( $order ) : ?>
	
	<?php if ( in_array( $order->status, array( 'failed' ) ) ) : ?>

		<p><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'woocommerce' ); ?></p>

		<p><?php
			if ( is_user_logged_in() )
				_e( 'Please attempt your purchase again or go to your account page.', 'woocommerce' );
			else
				_e( 'Please attempt your purchase again.', 'woocommerce' );
		?></p>

		<p>
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'woocommerce' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>" class="button pay"><?php _e( 'My Account', 'woocommerce' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>
		<div class="content">
			<div class="row">
				<h3 class="page-title no-margin uppercase no-margin"><?php _e( 'Your order has been placed!', THEME_NAME ); ?></h3>
				<p><?php _e("Thank you for shopping at Charlie May, your order will be on its way shortly!", THEME_NAME); ?></p>
				<?php if ( !in_array( $order->status, array( 'failed' ) ) ) : ?>
				<p><?php echo sprintf('Order <span class="black">%s</span> at <span class="black">%s</span>; total of <span class="black">%s</span> paid with <span class="black">%s</span>', $order->get_order_number(), date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ), $order->get_formatted_order_total(), $order->payment_method_title ); ?>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="col2-set">
		
		<div class="col-1">
			<?php do_action( 'woocommerce_thankyou_' . $order->payment_method, $order->id ); ?>
			<?php do_action( 'woocommerce_thankyou', $order->id ); ?>
		</div>
		<div class="col-2">
			<div class="order-newsletter">
				<?php gravity_form(1); ?>
			</div>
		</div>
	</div>
<?php else : ?>

	<p><?php _e( 'Thank you. Your order has been received.', 'woocommerce' ); ?></p>

<?php endif; ?>
