<?php 

class Press extends WP_Widget {

    function Press() {
        $widget_opts = array( 'description' => __('Use this widget is to show the latest press release or a specific one') );
        parent::WP_Widget(false, 'Press', $widget_opts);
    }

    function form($instance) {
       // $offset = (isset($instance['offset'])) ? esc_attr($instance['offset']) : '';
        //$category_id = (isset($instance['category_id'])) ? esc_attr($instance['category_id']) : '';
        $post_id = (isset($instance['postid'])) ? esc_attr($instance['postid']) : '';
        $custom_query = new WP_Query( array('posts_per_page' => -1, 'no_found_rows' => true, 'post_type' => array('press_release'), 'post_status' => 'publish', 'ignore_sticky_posts' => true)); 
        // echo '<p><label>';
        // echo _('Position:').'&nbsp;&nbsp;<input class="widefat" style="width: 20px;" name="'. $this->get_field_name('offset').'" type="text" value="'. $offset.'" />';
        // echo '</label></p>';
        // echo '<p><label>';
        // echo _('In category:').'&nbsp;&nbsp;';
        // wp_dropdown_categories(array('hierarchical' => true, 'selected' => $category_id, 'show_option_none' => 'Current', 'show_option_all' => 'All', 'name' => $this->get_field_name('category_id')));
        // echo '</label></p>';
        echo '<p>';
        if ( $custom_query->have_posts() ) :
            echo '<label>'._('Press:');
            echo '&nbsp;&nbsp;<select name="'.$this->get_field_name('postid').'" style="width: 170px;">';
            echo '<option value="">-- Latest --</option>';
            while ( $custom_query->have_posts() ) : $custom_query->the_post(); 
                echo '<option value="'.get_the_ID().'" ';
                if(get_the_ID() == $post_id) echo 'selected';
                echo '>'.get_the_title().'</option>';
            endwhile;
            echo '</select></label>';
        endif;
        echo '</p>';
       
    }

    function update($new_instance, $old_instance){
        return $new_instance;
    }

    function widget($args, $instance) {
        global $post;
        

        $args['postid'] = $instance['postid'];

        $options = array('posts_per_page' => 1, 'no_found_rows' => true, 'post_type' => array('press_release'), 'post_status' => 'publish', 'orderby' => 'menu_order', 'order' => 'ASC');
        if($args['postid']){
            $options['p'] = $args['postid'];
        }

        $custom_query = new WP_Query($options);
        if ( $custom_query->have_posts() ) :
            echo $args['before_widget'];
            $i = 0;
            while ( $custom_query->have_posts() ) : $custom_query->the_post();
            ?>
                <a href="<?php echo get_permalink(get_field('press_page', 'options')); ?>" class="post press-release" >
                    <div class="featured-image">
                        <?php the_post_thumbnail('custom_medium', array('class' => 'thumbnail scale')); ?>
                    </div>
                    <div class="content">
                        <div class="inner">
                            <h5 class="novecento"><?php _e("Featured In", THEME_NAME); ?></h5>
                            <h2 class="title"><?php the_title(); ?></h2>
                        </div>
                    </div>
                </a>
            <?php
            $i++;
            endwhile;
            wp_reset_postdata();
            wp_reset_query();
            echo $args['after_widget'];
            ?>
        <?php endif; ?>
        <?php 
    }
}

register_widget('Press');
?>