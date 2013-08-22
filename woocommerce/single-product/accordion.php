<?php
/**
 * Single product accordion
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;
?>
<?php if(get_field('accordion')): ?>
<ul class="accordion">
	<?php while(has_sub_field('accordion')): ?>
	<li>
		<button class="btn"><?php the_sub_field('title'); ?></button>
		<div class="content"><?php the_sub_field('content'); ?></div>
	</li>
	<?php endwhile; ?>
</ul>
<?php endif; ?>