<?php
/*
* Plugin Name: Widget Image Uploader
* Plugin URI: http://www.adeprimo.se
* Description: A widget that allows you to upload media from a widget
* Version: 1.0
* Author: Adeprimo <Nahoj>
* Author URI: http://www.adeprimoe.se
* License:
*/

/**
 * Register the Widget
 */

Class widget_media_upload extends WP_Widget {
    /**
     * Constructor
     */

    public function __construct() {
        $widget_ops = array(
            'classname' => 'widget_media_upload',
            'description' => 'Widget that uses the built in Media library.'
        );

        parent::__construct( 'widget_media_upload', 'Media Upload Widget', $widget_ops);
        add_action('admin_enqueue_scripts', array(&$this ,'upload_scripts'));
    }

    /**
     * Upload the Javascripts for the media uploader
     */

    public function upload_scripts() {
        // Scripts
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('widget_media_upload', plugin_dir_url(__FILE__) . 'upload-media.js', array('jquery'));
        // Css
        wp_enqueue_style('thickbox');
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array  An array of standard parameters for widgets in this theme
     * @param array  An array of settings for this widget instance
     * @return void Echoes it's output
     */

    public function widget($args, $instance) {
        // Add any html to output the image in the $instance array
        $self  = $instance;
        $title = $self['title'];
        $image = $self['image'];

        ?>
            <?php if(!empty($self)) : ?>
                <div class="widget-upload-image">
                    <?php if($title) : ?>
                        <div class="widget-upload-image__title">
                            <h2><?php echo $title; ?></h2>
                        </div>
                    <?php endif; ?>
                    <?php if($image) : ?>
                        <div class="widget-upload-image__img">
                            <img src="<?php echo $image; ?>" alt="" />
                        </div>
                    <?php  endif; ?>
                </div>
            <?php endif; ?>
        <?php
    }

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array  An array of new settings as submitted by the admin
     * @param array  An array of the previous settings
     * @return array The validated and (if necessary) amended settings
     **/

    public function update($new_instance, $old_instance) {
        // update logic goes here
        $updated_instance = $new_instance;
        return $updated_instance;
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     * @return void
     */

    public function form($instance) {
        $title = __('');

        if(isset($instance['title'])) {
            $title = $instance['title'];
        }

        $image = '';

        if(isset($instance['image'])) {
            $image = $instance['image'];
        }

        ?>
            <p>
                <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
                <input name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
                <input class="upload_image_button" type="button" value="Upload Image" />
            </p>
        <?php
    }
}
add_action('widgets_init', create_function('', 'register_widget("widget_media_upload");'));
?>
