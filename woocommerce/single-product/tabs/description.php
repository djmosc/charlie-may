<?php
/**
 * Description tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $post;

if($post->post_content):
$heading = esc_html( apply_filters('woocommerce_product_description_heading', __( 'Product Description', 'woocommerce' ) ) );
?>
<div class="description">
	<h3 class="title text-center"><?php echo $heading; ?></h3>
	<div class="content">
		<?php if($post->post_content): ?>
		<div class="product-content"><?php the_content(); ?></div>
		<?php endif; ?>
	</div>
</div>
<?php endif; ?>
