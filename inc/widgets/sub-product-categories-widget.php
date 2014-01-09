<?php 

class Sub_Product_Categories extends WP_Widget {
	
	function Sub_Product_Categories() {
		parent::WP_Widget(false, 'Sub product categories');
	}
	function form($instance) {
		
		$category_id = esc_attr($instance['category_id']);  
        echo '<p><label>';
		echo _e('Parent Category:');
		wp_dropdown_categories(array('hierarchical' => true, 'taxonomy' => 'product_cat', 'selected' => $category_id, 'name' => $this->get_field_name('category_id')));
		echo '</label></p>';
	
	}
	function update($new_instance, $old_instance){
			return $new_instance;
	}
	function widget($args, $instance) {
		$args['category_id'] = $instance['category_id'];
		$category = get_term($args['category_id'], 'product_cat');
		echo $args['before_widget'] . $args['before_title'];
		?>
		<a href="<?php echo get_term_link($category); ?>"><?php echo $category->name; ?></a>
		<?php
		echo $args['after_title'];
		$cat_args['title_li'] = '';
		$cat_args['child_of'] = (int)$args['category_id'];
		$cat_args['taxonomy'] = 'product_cat';
		$cat_args['hide_empty'] = 0;
		if(get_terms($cat_args['taxonomy'], $cat_args)):
			echo '<ul class="product-cateogires">';
			?>
			<li>
				<a href="<?php echo get_term_link($category); ?>"><?php _e("View all", THEME_NAME); ?></a>
			</li>
			<?php
			wp_list_categories($cat_args);
			echo '</ul>';
		endif;
		echo $args['after_widget'];
	}
}

register_widget('Sub_Product_Categories');



?>
