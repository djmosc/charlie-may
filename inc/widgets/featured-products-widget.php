<?php 

if(class_exists('WC_Widget_Featured_Products')){

    class Featured_Products extends WC_Widget_Featured_Products {

       function widget($args, $instance) {
            global $woocommerce;
            $cache = wp_cache_get('widget_featured_products', 'widget');

            if ( !is_array($cache) ) $cache = array();

            if ( isset($cache[$args['widget_id']]) ) {
                echo $cache[$args['widget_id']];
                return;
            }

            ob_start();
            extract($args);

            $title = apply_filters('widget_title', empty($instance['title']) ? __('Featured Products', 'woocommerce' ) : $instance['title'], $instance, $this->id_base);
            if ( !$number = (int) $instance['number'] )
                $number = 10;
            else if ( $number < 1 )
                $number = 1;
            else if ( $number > 15 )
                $number = 15;
    ?>

            <?php $query_args = array('posts_per_page' => $number, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product' );

            $query_args['meta_query'] = $woocommerce->query->get_meta_query();
            $query_args['meta_query'][] = array(
                'key' => '_featured',
                'value' => 'yes'
            );

            $query = new WP_Query($query_args);

            if ($query->have_posts()) : ?>

                <?php echo $before_widget; ?>
                <?php if ( $title ) : ?>
                    <h3 class="widget-title uppercase text-center"><?php echo $title; ?></h3>
                <?php endif; ?>
                <h5 class="text-center featured-title"><?php _e("Featured", THEME_NAME); ?></h5>
                <div class="products-scroller scroller" data-auto-scroll="true">
                    <div class="inner">
                        <div class="scroller-mask">
                        <?php while ($query->have_posts()) : $query->the_post(); global $product; ?>

                            <div class="scroll-item" data-id="<?php echo $query->post->ID; ?>">
                                <a href="<?php echo esc_url( get_permalink( $query->post->ID ) ); ?>" title="<?php echo esc_attr($query->post->post_title ? $query->post->post_title : $query->post->ID); ?>">
                                    <?php echo $product->get_image(); ?>
                                    <h5 class="text-center novecento"><?php _e("Shop Now", THEME_NAME); ?></h5>
                                    <?php //if ( $query->post->post_title ) echo get_the_title( $query->post->ID ); else echo $query->post->ID; ?>

                                </a>
                            </div>
                        <?php endwhile; ?>
                        </div>
                    </div>
                    <nav class="scroller-navigation">
                        <button class="prev-btn"></button>
                        <button class="next-btn"></button>
                    </nav>
                </div>
                <?php echo $after_widget; ?>

            <?php endif;

            $content = ob_get_clean();

            if ( isset( $args['widget_id'] ) ) $cache[$args['widget_id']] = $content;

            echo $content;

            wp_cache_set('widget_featured_products', $cache, 'widget');
            wp_reset_postdata();
        }
    }

    register_widget('Featured_Products');
}
?>