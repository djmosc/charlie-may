<?php 

if(class_exists('WC_Widget_Products')){

    class Products_Widget extends WC_Widget_Products {

       function widget($args, $instance) {
            if ( $this->get_cached_widget( $args ) )
                return;

            ob_start();
            extract( $args );

            $title       = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
            $number      = absint( $instance['number'] );
            $show        = sanitize_title( $instance['show'] );
            $orderby     = sanitize_title( $instance['orderby'] );
            $order       = sanitize_title( $instance['order'] );
            $show_rating = false;

            $query_args = array(
                'posts_per_page' => $number,
                'post_status'    => 'publish',
                'post_type'      => 'product',
                'no_found_rows'  => 1,
                'order'          => $order == 'asc' ? 'asc' : 'desc'
            );

            $query_args['meta_query'] = array();

            if ( empty( $instance['show_hidden'] ) ) {
                $query_args['meta_query'][] = WC()->query->visibility_meta_query();
                $query_args['post_parent']  = 0;
            }

            if ( ! empty( $instance['hide_free'] ) ) {
                $query_args['meta_query'][] = array(
                    'key'     => '_price',
                    'value'   => 0,
                    'compare' => '>',
                    'type'    => 'DECIMAL',
                );
            }

            $query_args['meta_query'][] = WC()->query->stock_status_meta_query();
            $query_args['meta_query']   = array_filter( $query_args['meta_query'] );

            switch ( $show ) {
                case 'featured' :
                    $query_args['meta_query'][] = array(
                        'key'   => '_featured',
                        'value' => 'yes'
                    );
                    break;
                case 'onsale' :
                    $product_ids_on_sale = wc_get_product_ids_on_sale();
                    $product_ids_on_sale[] = 0;
                    $query_args['post__in'] = $product_ids_on_sale;
                    break;
            }

            switch ( $orderby ) {
                case 'price' :
                    $query_args['meta_key'] = '_price';
                    $query_args['orderby']  = 'meta_value_num';
                    break;
                case 'rand' :
                    $query_args['orderby']  = 'rand';
                    break;
                case 'sales' :
                    $query_args['meta_key'] = 'total_sales';
                    $query_args['orderby']  = 'meta_value_num';
                    break;
                default :
                    $query_args['orderby']  = 'date';
            }

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


            wp_reset_postdata();

            $content = ob_get_clean();

            echo $content;

            $this->cache_widget( $args, $content );
        }
    }

    register_widget('Products_Widget');
}
?>