<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;
wp_enqueue_script('zoom');
?>
<div class="images">
	<div class="scroller" data-resize="true">
		<div class="scroller-mask">

		
		<?php
		$attachment_ids = $product->get_gallery_attachment_ids();
		$show_thumbnail = true;
		if ( $attachment_ids ) {
			$loop = 0;
			$show_thumbnail = false;
			$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

			foreach ( $attachment_ids as $attachment_id ) {
				$classes = array( 'woocommerce-main-image', 'zoom');

				if ( $loop == 0 || $loop % $columns == 0 )
					$classes[] = 'first';

				if ( ( $loop + 1 ) % $columns == 0 )
					$classes[] = 'last';

				$image_link = wp_get_attachment_url( $attachment_id );

				if ( ! $image_link )
					continue;

				$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array('data-zoom-image' => $image_link) );
				$image_class = esc_attr( implode( ' ', $classes ) );
				$image_title = esc_attr( get_the_title( $attachment_id ) );
				?>
				<div class="scroll-item" data-id="<?php echo $attachment_id; ?>">
				<?php echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" class="%s" title="%s" rel="prettyPhoto[product-gallery]"><div class="enlarge"><i class="icon-search"></i>view larger image</div>%s</a>', $image_link, $image_class, '', $image ), $attachment_id, $post->ID, $image_class ); ?>
				</div>
				<?php $loop++;
			}
		} elseif($product->is_type('variable')){
			global $wpdb;
			$variations = $product->get_available_variations();
			$loop = 0;
			$selected_attributes = $product->get_variation_default_attributes();
			$curr_variation = null;
			if(!empty($selected_attributes)){		
				foreach($selected_attributes as $selected_attribute){
					$selected_attributes[] = $selected_attribute;
				}
				$curr_variation = $selected_attributes[0];
			}
			foreach($variations as $variation){

				if(isset($variation['image_link'])){
					
					if(!empty($variation['attributes'])){		
						foreach($variation['attributes'] as $attribute){
							$variation['attributes'][] = $attribute;
						}					
					}

					$image_url = $variation['image_link'];
					$attachment_id = $wpdb->get_var( "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_url'");
					$classes = array( 'woocommerce-main-image', 'zoom');
					$image_link = wp_get_attachment_url( $attachment_id );

					if ( ! $image_link )
						continue;

					$show_thumbnail = false;
					$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array('data-zoom-image' => $image_link) );
					$image_class = esc_attr( implode( ' ', $classes ) );
					$image_title = esc_attr( get_the_title( $attachment_id ) );
					
					?>
					<div class="scroll-item <?php if($curr_variation == $variation['attributes'][0]) echo 'current'; ?>" data-id="<?php echo $variation['variation_id']; ?>">
					<?php echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" class="%s" title="%s" rel="prettyPhoto[product-gallery]"><div class="enlarge"><i class="icon-search"></i>View larger image</div>%s</a>', $image_link, $image_class, '', $image ), $attachment_id, $post->ID, $image_class ); ?>
					</div>
					<?php $loop++;
				}
			}
		} 
		
		if ( has_post_thumbnail() && $show_thumbnail) :
			$image_title 		= esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
			$image       		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array('data-zoom-image' => $image_link) );
			$attachment_count   = count( $product->get_gallery_attachment_ids() );
			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
			} else {
				$gallery = '';
			}
			?>
			<div class="scroll-item current" data-id="<?php echo get_post_thumbnail_id(); ?>">
				<?php echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s"  rel="prettyPhoto' . $gallery . '"><div class="enlarge"><i class="icon-search"></i>View larger image</div>%s</a>', $image_link, '', $image ), $post->ID ); ?>
			</div>
		<?php endif; ?>
		</div>
		<?php do_action( 'woocommerce_product_thumbnails' ); ?>
	</div>
	<?php do_action('woocommerce_after_product_images'); ?>
</div>
