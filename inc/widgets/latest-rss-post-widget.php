<?php 

class Latest_RSS_Post extends WP_Widget {

    function Latest_RSS_Post() {
        $widget_opts = array( 'description' => __('Use this widget is to show the latest post of an RSS feed') );
        parent::WP_Widget(false, 'Latest RSS Post', $widget_opts);
    }

    function form($instance) {

        $rss_url = (isset($instance['rss_url'])) ? esc_attr($instance['rss_url']) : ''; 
        echo '<p>';
        echo '<label>';
        echo _('RSS Feed Url:').'&nbsp;&nbsp;<input class="widefat" name="'. $this->get_field_name('rss_url').'" type="text" value="'. $rss_url.'" />';
        echo '</label>';
        echo '</p>';
       
    }

    function update($new_instance, $old_instance){
        return $new_instance;
    }

    function widget($args, $instance) {
        global $post;
        
        $args['rss_url'] = $instance['rss_url'];
        $content = file_get_contents($args['rss_url']);  
        if($content):
            $xml = new SimpleXmlElement($content);

            if($xml):
                
                echo $args['before_widget'];
                $i = 0;
                foreach($xml->channel->item as $entry) :
                    if($i == 0):
                ?>
                    <a href="<?php echo $entry->link; ?>" class="post rss-post" >
                        <div class="featured-image">
                            <img src="<?php echo $entry->post_thumbnail->url; ?>" class="scale"/>
                        </div>
                        <div class="content">
                            <div class="inner">
                                <h5 class="novecento"><?php _e("Blog", THEME_NAME); ?></h5>
                                <h2 class="title"><?php echo $entry->title; ?></h2>
                            </div>
                        </div>
                    </a>
                <?php
                    endif;
                $i++;
                endforeach;
                ?>
                <?php echo $args['after_widget']; ?>

            <?php endif; ?>
        <?php endif; ?>
        <?php
    }
}

register_widget('Latest_RSS_Post');
?>